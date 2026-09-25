<?php

/**
 * Rapport de rentabilité — CRM & Clients > Reporting (données dynamiques)
 * Variables fournies par CrmController::reporting() :
 *   $projet, $client, $projetId, $filters, $portefeuille,
 *   $chantiers     (table `chantiers` : dépenses par chantier)
 *   $chantiersCrm  (table `tbl_chantiers` : devis signés + avancement)
 *   $achatsDetail, $moDetail, $nonRattaches
 *
 *   Dépenses chantier = achats effectués (bon de paiement 'effectue') + main-d'œuvre (contract_amount)
 *   Coût du projet    = somme des devis signés des chantiers du projet (tbl_devis)
 *   Bénéfice          = coût du projet − dépenses du projet
 */

$projet       = isset($projet) ? $projet : null;
$portefeuille = isset($portefeuille) ? $portefeuille : [];
$chantiers    = isset($chantiers) ? $chantiers : [];
$chantiersCrm = isset($chantiersCrm) ? $chantiersCrm : [];
$achatsDetail = isset($achatsDetail) ? $achatsDetail : [];
$moDetail     = isset($moDetail) ? $moDetail : [];
$filters      = isset($filters) ? $filters : [];
$nonRattaches = isset($nonRattaches) ? $nonRattaches : ['nb' => 0, 'montant' => 0];

/* ------------------------------- Helpers --------------------------------- */
$fmt  = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$fmtM = function ($n) {
    return number_format((float) $n / 1000000, 1, ',', ' ') . ' M';
};
$pct  = function ($n, $d = 1) {
    return number_format((float) $n, $d, ',', ' ') . ' %';
};
$e    = function ($s) {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
};
$dateFr = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '—';
};
$url  = function (array $params = []) use ($filters) {
    $q = array_filter([
        'du' => isset($filters['date_du']) ? $filters['date_du'] : null,
        'au' => isset($filters['date_au']) ? $filters['date_au'] : null,
    ]);
    return site_url('crm-reporting') . '?' . http_build_query(array_merge($q, $params));
};

/* ------------------------------ Calculs ---------------------------------- */
$tot = ['achats' => 0, 'mo' => 0, 'depenses' => 0, 'nb_achats' => 0, 'nb_contrats' => 0, 'mo_sans_montant' => 0];
foreach ($chantiers as $c) {
    $tot['achats']          += $c['achats'];
    $tot['mo']              += $c['main_oeuvre'];
    $tot['depenses']        += $c['depenses'];
    $tot['nb_achats']       += $c['nb_achats'];
    $tot['nb_contrats']     += $c['nb_contrats'];
    $tot['mo_sans_montant'] += $c['nb_sans_montant'];
}

$cout = 0;
$devisAttente = 0;
$nbDevisSignes = 0;
$avPond = 0;
$avSimple = 0;
foreach ($chantiersCrm as $k) {
    $cout         += $k['devis_signe'];
    $devisAttente += $k['devis_attente'];
    $nbDevisSignes += $k['refs_signes'] ? count(explode(', ', $k['refs_signes'])) : 0;
    $avPond       += $k['avancement'] * $k['devis_signe'];
    $avSimple     += $k['avancement'];
}
$avancement = $cout > 0 ? $avPond / $cout : (count($chantiersCrm) ? $avSimple / count($chantiersCrm) : 0);

$benefice   = $cout - $tot['depenses'];
$tauxMarge  = $cout > 0 ? $benefice / $cout * 100 : null;
$conso      = $cout > 0 ? $tot['depenses'] / $cout * 100 : null;
$coutTerme  = ($avancement > 0) ? $tot['depenses'] / ($avancement / 100) : null;
$margeTerme = ($coutTerme !== null && $cout > 0) ? $cout - $coutTerme : null;

// Points d'attention
$alertes = [];
if ($projet) {
    if ($cout <= 0 && $tot['depenses'] > 0) {
        $alertes[] = ['danger', 'Aucun devis signé', 'Le projet a déjà ' . $fmtM($tot['depenses']) . ' BIF de dépenses sans devis signé : le bénéfice ne peut pas être calculé.'];
    } elseif ($cout > 0 && $benefice < 0) {
        $alertes[] = ['danger', 'Projet en perte', 'Les dépenses dépassent le coût du projet de ' . $fmtM(-$benefice) . ' BIF.'];
    }
    if ($conso !== null && $avancement > 0 && $conso > $avancement + 10) {
        $alertes[] = ['warning', 'Consommation en avance sur les travaux', $pct($conso, 0) . ' du coût du projet est dépensé pour ' . $pct($avancement, 0) . ' d\'avancement.'
            . ($margeTerme !== null ? ' Marge projetée à terme : ' . $fmtM($margeTerme) . ' BIF.' : '')];
    }
    if ($cout > 0 && $avancement <= 0) {
        $alertes[] = ['info', 'Avancement non renseigné', 'Mettez à jour l\'avancement des chantiers (Chantiers & Avancement) pour obtenir la marge projetée à terme.'];
    }
    foreach ($chantiersCrm as $k) {
        if ($k['devis_signe'] <= 0) {
            $alertes[] = ['warning', $k['name'], 'Chantier sans devis signé : il ne compte pas dans le coût du projet.'];
        }
    }
    if ($devisAttente > 0) {
        $alertes[] = ['info', 'Devis en attente', $fmtM($devisAttente) . ' BIF de devis en attente de signature, non inclus dans le coût du projet.'];
    }
    if ($tot['mo_sans_montant'] > 0) {
        $alertes[] = ['info', 'Main-d\'œuvre incomplète', $tot['mo_sans_montant'] . ' contrat(s) de main-d\'œuvre sans montant (contract_amount = 0) : la main-d\'œuvre est sous-estimée.'];
    }
    if (empty($chantiers)) {
        $alertes[] = ['warning', 'Aucun chantier opérationnel', 'Aucun chantier de la table des chantiers n\'est rattaché à ce projet : aucune dépense ne peut lui être imputée.'];
    }
}
if (!empty($nonRattaches['nb'])) {
    $alertes[] = ['info', 'Achats non rattachés', $nonRattaches['nb'] . ' demande(s) d\'achat effectuée(s) (' . $fmtM($nonRattaches['montant']) . ' BIF) ne sont liées à aucun chantier.'];
}
$nbAlertesFortes = count(array_filter($alertes, function ($a) {
    return $a[0] !== 'info';
}));

// Portefeuille : seulement les projets avec devis ou dépenses
$pfActifs = array_values(array_filter($portefeuille, function ($p) {
    return $p['devis'] > 0 || $p['depenses'] > 0;
}));
$pfMasques = count($portefeuille) - count($pfActifs);

// Données JS
$achatsParChantier = [];
foreach ($achatsDetail as $a) {
    $achatsParChantier[$a['chantier_id']][] = $a;
}
$moParChantier = [];
foreach ($moDetail as $m) {
    $moParChantier[$m['chantier_id']][] = $m;
}

$jsData = [
    'chantiers' => array_map(function ($c) use ($achatsParChantier, $moParChantier) {
        return [
            'id' => (int) $c['id'],
            'nom' => $c['name'],
            'ref' => $c['ref_chantier'],
            'chef' => $c['chef_chantier'],
            'lieu' => $c['location'],
            'statut' => $c['status'],
            'achats' => (float) $c['achats'],
            'mo' => (float) $c['main_oeuvre'],
            'depenses' => (float) $c['depenses'],
            'nb_achats' => (int) $c['nb_achats'],
            'nb_contrats' => (int) $c['nb_contrats'],
            'nb_sans_montant' => (int) $c['nb_sans_montant'],
            'achats_detail' => array_map(function ($a) {
                return [
                    'id' => (int) $a['id'],
                    'ref' => 'DA-' . date('Y', strtotime($a['request_date'] ?: $a['payment_date'])) . '-' . $a['id'],
                    'date' => $a['payment_date'],
                    'demandeur' => $a['requested_by'],
                    'libelle' => $a['premiere_ligne'],
                    'nb_lignes' => (int) $a['nb_lignes'],
                    'montant' => (float) $a['montant']
                ];
            }, isset($achatsParChantier[$c['id']]) ? $achatsParChantier[$c['id']] : []),
            'mo_detail' => array_map(function ($m) {
                return ['type' => $m['worker_type'] ?: 'Non précisé', 'nb' => (int) $m['nb_contrats'], 'montant' => (float) $m['montant']];
            }, isset($moParChantier[$c['id']]) ? $moParChantier[$c['id']] : []),
        ];
    }, $chantiers),
    'totaux' => ['achats' => $tot['achats'], 'mo' => $tot['mo']],
];
?>

<style>
    .rpt {
        --rpt-ink: #1b2a33;
        --rpt-muted: #6b7a86;
        --rpt-line: #e6ebef;
        --rpt-surface: #ffffff;
        --rpt-soft: #f5f8f7;
        --rpt-brand: #1f5c4b;
        --rpt-brand-2: #6fbf73;
        --rpt-devis: #2f5d8a;
        --rpt-depense: #d4782c;
        --rpt-paye: #2e9b6a;
        --rpt-profit: #1f5c4b;
        --rpt-loss: #c0392b;
        --rpt-warn: #d99a1e;
        --rpt-radius: 12px;
        --rpt-shadow: 0 1px 2px rgba(16, 24, 40, .04), 0 4px 14px rgba(16, 24, 40, .06);
        color: var(--rpt-ink);
    }

    .rpt .mono {
        font-variant-numeric: tabular-nums;
        font-feature-settings: "tnum";
    }

    .rpt .text-muted-2 {
        color: var(--rpt-muted) !important;
    }

    .rpt .text-loss {
        color: var(--rpt-loss) !important;
    }

    .rpt .text-profit {
        color: var(--rpt-profit) !important;
    }

    .rpt .text-warn {
        color: #a3700a !important;
    }

    .rpt-card {
        background: var(--rpt-surface);
        border: 1px solid var(--rpt-line);
        border-radius: var(--rpt-radius);
        box-shadow: var(--rpt-shadow);
        margin-bottom: 1.25rem;
    }

    .rpt-card__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--rpt-line);
        flex-wrap: wrap;
    }

    .rpt-card__title {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
    }

    .rpt-card__sub {
        font-size: .8rem;
        color: var(--rpt-muted);
        margin: 2px 0 0;
    }

    .rpt-card__body {
        padding: 1.25rem;
    }

    .rpt-hero {
        background: linear-gradient(120deg, #173f35 0%, #1f5c4b 55%, #2f7a5f 100%);
        color: #fff;
        border-radius: var(--rpt-radius);
        padding: 1.4rem 1.5rem;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--rpt-shadow);
    }

    .rpt-hero::after {
        content: "";
        position: absolute;
        right: -60px;
        top: -60px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(111, 191, 115, .35), transparent 70%);
    }

    .rpt-hero__code {
        display: inline-block;
        font-size: .72rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        background: rgba(255, 255, 255, .14);
        padding: 3px 10px;
        border-radius: 999px;
        margin-bottom: .5rem;
    }

    .rpt-hero__name {
        font-size: 1.45rem;
        font-weight: 700;
        margin: 0 0 .35rem;
    }

    .rpt-hero__meta {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem 1.4rem;
        font-size: .85rem;
        opacity: .9;
    }

    .rpt-hero__meta i {
        width: 16px;
        opacity: .8;
        margin-right: 4px;
    }

    .rpt-hero__progress {
        position: relative;
        z-index: 1;
        min-width: 240px;
    }

    .rpt-hero__progress .lbl {
        display: flex;
        justify-content: space-between;
        font-size: .8rem;
        opacity: .9;
        margin-bottom: 6px;
    }

    .rpt-hero__bar {
        height: 8px;
        background: rgba(255, 255, 255, .18);
        border-radius: 999px;
        overflow: hidden;
        margin-bottom: .9rem;
    }

    .rpt-hero__bar span {
        display: block;
        height: 100%;
        border-radius: 999px;
        background: var(--rpt-brand-2);
    }

    .rpt-hero__bar span.pay {
        background: #b9e4c9;
    }

    .rpt-filters {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
        align-items: flex-end;
    }

    .rpt-filters .form-group {
        margin: 0;
        min-width: 170px;
        flex: 1 1 170px;
    }

    .rpt-filters label {
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--rpt-muted);
        font-weight: 600;
        margin-bottom: 4px;
    }

    .rpt-filters .form-control {
        border-radius: 8px;
        border-color: var(--rpt-line);
        height: 38px;
    }

    .rpt-actions {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .rpt-btn {
        border-radius: 8px;
        font-weight: 600;
        font-size: .85rem;
        height: 38px;
        padding: 0 .9rem;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
    }

    .rpt-btn-brand {
        background: var(--rpt-brand);
        color: #fff;
        border: 1px solid var(--rpt-brand);
    }

    .rpt-btn-brand:hover {
        background: #174a3c;
        color: #fff;
    }

    .rpt-btn-ghost {
        background: #fff;
        color: var(--rpt-ink);
        border: 1px solid var(--rpt-line);
    }

    .rpt-btn-ghost:hover {
        background: var(--rpt-soft);
    }

    .rpt-kpi {
        background: var(--rpt-surface);
        border: 1px solid var(--rpt-line);
        border-radius: var(--rpt-radius);
        box-shadow: var(--rpt-shadow);
        padding: 1.1rem 1.2rem;
        height: calc(100% - 1.25rem);
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
    }

    .rpt-kpi::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--kpi-color);
    }

    .rpt-kpi__top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .rpt-kpi__label {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--rpt-muted);
        font-weight: 600;
    }

    .rpt-kpi__icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        background: color-mix(in srgb, var(--kpi-color) 12%, white);
        color: var(--kpi-color);
        font-size: 1rem;
    }

    .rpt-kpi__value {
        font-size: 1.65rem;
        font-weight: 700;
        line-height: 1.15;
        margin: .35rem 0 .15rem;
    }

    .rpt-kpi__value small {
        font-size: .8rem;
        font-weight: 600;
        color: var(--rpt-muted);
        margin-left: 3px;
    }

    .rpt-kpi__full {
        font-size: .78rem;
        color: var(--rpt-muted);
    }

    .rpt-kpi__foot {
        margin-top: .7rem;
        padding-top: .6rem;
        border-top: 1px dashed var(--rpt-line);
        font-size: .8rem;
        display: flex;
        justify-content: space-between;
        gap: .5rem;
    }

    .rpt-table {
        margin: 0;
        font-size: .86rem;
    }

    .rpt-table thead th {
        background: var(--rpt-soft);
        color: var(--rpt-muted);
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        font-weight: 700;
        border-top: 0;
        border-bottom: 1px solid var(--rpt-line);
        white-space: nowrap;
        vertical-align: middle;
        padding: .7rem .75rem;
    }

    .rpt-table td {
        vertical-align: middle;
        border-top: 1px solid var(--rpt-line);
        padding: .75rem;
    }

    .rpt-table tbody tr {
        cursor: pointer;
        transition: background .15s;
    }

    .rpt-table tbody tr:hover {
        background: #f8fbfa;
    }

    .rpt-table tfoot td {
        background: #eef4f1;
        font-weight: 700;
        border-top: 2px solid var(--rpt-brand);
    }

    .rpt-table .num {
        text-align: right;
        white-space: nowrap;
    }

    .rpt-ch-name {
        font-weight: 700;
    }

    .rpt-ch-meta {
        font-size: .75rem;
        color: var(--rpt-muted);
    }

    .rpt-progress {
        display: flex;
        align-items: center;
        gap: .5rem;
        min-width: 120px;
    }

    .rpt-progress__track {
        flex: 1;
        height: 6px;
        background: #e8eef0;
        border-radius: 999px;
        overflow: hidden;
    }

    .rpt-progress__fill {
        height: 100%;
        border-radius: 999px;
        background: var(--rpt-devis);
    }

    .rpt-progress__val {
        font-size: .78rem;
        font-weight: 700;
        width: 38px;
        text-align: right;
    }

    .rpt-gauge-legend {
        font-size: .7rem;
        color: var(--rpt-muted);
        margin-top: 3px;
    }

    .rpt-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .72rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 999px;
        white-space: nowrap;
    }

    .rpt-badge--danger {
        background: #fbe6e3;
        color: #b0322a;
    }

    .rpt-badge--neutral {
        background: #eef1f4;
        color: #4a5a66;
    }

    .rpt-legend-inline {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        font-size: .75rem;
        color: var(--rpt-muted);
    }

    .rpt-legend-inline span::before {
        content: "";
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 3px;
        margin-right: 5px;
        vertical-align: -1px;
        background: var(--c);
    }

    .rpt-chart {
        position: relative;
        height: 320px;
    }

    .rpt-chart--sm {
        height: 260px;
    }

    .rpt-donut-center {
        position: absolute;
        inset: 0;
        display: grid;
        place-items: center;
        pointer-events: none;
        text-align: center;
    }

    .rpt-donut-center b {
        display: block;
        font-size: 1.15rem;
    }

    .rpt-donut-center span {
        font-size: .72rem;
        color: var(--rpt-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .rpt-cat-list {
        list-style: none;
        padding: 0;
        margin: 1rem 0 0;
        font-size: .82rem;
    }

    .rpt-cat-list li {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px dashed var(--rpt-line);
    }

    .rpt-cat-list li:last-child {
        border-bottom: 0;
    }

    .rpt-cat-list i {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 3px;
        margin-right: 8px;
    }

    .rpt-empty {
        height: 220px;
        display: grid;
        place-items: center;
        align-content: center;
        gap: .5rem;
        color: var(--rpt-muted);
        font-size: .9rem;
        text-align: center;
    }

    .rpt-empty i {
        display: block;
        font-size: 1.8rem;
        opacity: .4;
        margin-bottom: .4rem;
    }

    .rpt-alert {
        display: flex;
        gap: .8rem;
        padding: .85rem 1rem;
        border-radius: 10px;
        margin-bottom: .7rem;
        border: 1px solid;
    }

    .rpt-alert:last-child {
        margin-bottom: 0;
    }

    .rpt-alert__icon {
        width: 30px;
        height: 30px;
        flex: 0 0 30px;
        border-radius: 8px;
        display: grid;
        place-items: center;
        font-size: .85rem;
    }

    .rpt-alert b {
        display: block;
        font-size: .85rem;
    }

    .rpt-alert p {
        margin: 2px 0 0;
        font-size: .8rem;
        color: #45535e;
    }

    .rpt-alert--danger {
        background: #fdf4f3;
        border-color: #f4d2cd;
    }

    .rpt-alert--danger .rpt-alert__icon {
        background: #f9dcd8;
        color: var(--rpt-loss);
    }

    .rpt-alert--warning {
        background: #fefaf0;
        border-color: #f3e2b6;
    }

    .rpt-alert--warning .rpt-alert__icon {
        background: #fbecc5;
        color: #a3700a;
    }

    .rpt-alert--info {
        background: #f3f7fb;
        border-color: #d4e2ef;
    }

    .rpt-alert--info .rpt-alert__icon {
        background: #dde9f5;
        color: var(--rpt-devis);
    }

    .rpt-calc__row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: .7rem 0;
        border-bottom: 1px dashed var(--rpt-line);
        font-size: .9rem;
    }

    .rpt-calc__row small {
        color: var(--rpt-muted);
    }

    .rpt-calc__row.minus b {
        color: var(--rpt-depense);
    }

    .rpt-calc__row.total {
        border-bottom: 0;
        border-top: 2px solid var(--rpt-ink);
        margin-top: .3rem;
        padding-top: .9rem;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .rpt-calc__row.total b {
        color: var(--rpt-profit);
        font-size: 1.2rem;
    }

    .rpt-calc__row.total.loss b {
        color: var(--rpt-loss);
    }

    .rpt-calc__note {
        font-size: .8rem;
        color: var(--rpt-muted);
        margin-top: .4rem;
    }

    .rpt-row-active {
        background: #f1f8f4 !important;
    }

    .rpt-row-active td:first-child {
        box-shadow: inset 3px 0 0 var(--rpt-brand);
    }

    .rpt-modal .modal-content {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
    }

    .rpt-modal .modal-header {
        background: linear-gradient(120deg, #173f35, #1f5c4b);
        color: #fff;
        border: 0;
    }

    .rpt-modal .modal-header .close {
        color: #fff;
        opacity: .8;
        text-shadow: none;
    }

    .rpt-mini {
        background: var(--rpt-soft);
        border-radius: 10px;
        padding: .75rem .9rem;
        height: 100%;
    }

    .rpt-mini span {
        display: block;
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--rpt-muted);
        font-weight: 600;
    }

    .rpt-mini b {
        font-size: 1.05rem;
    }

    .rpt-bar-row {
        display: grid;
        grid-template-columns: 130px 1fr 110px;
        align-items: center;
        gap: .6rem;
        font-size: .8rem;
        margin-bottom: .5rem;
    }

    .rpt-bar-row .trk {
        height: 8px;
        background: #eef1f3;
        border-radius: 999px;
        overflow: hidden;
    }

    .rpt-bar-row .trk span {
        display: block;
        height: 100%;
        background: var(--rpt-depense);
        border-radius: 999px;
    }

    @media (max-width: 767.98px) {
        .rpt-hero__name {
            font-size: 1.15rem;
        }

        .rpt-kpi__value {
            font-size: 1.35rem;
        }

        .rpt-bar-row {
            grid-template-columns: 100px 1fr 90px;
        }
    }

    @media print {

        .main-sidebar,
        .main-header,
        .main-footer,
        .rpt-no-print {
            display: none !important;
        }

        .content-wrapper {
            margin-left: 0 !important;
            background: #fff !important;
        }

        .rpt-card,
        .rpt-kpi {
            box-shadow: none;
            break-inside: avoid;
        }

        .rpt-hero {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content rpt">
        <div class="container-fluid">

            <!-- ============ Filtres ============ -->
            <div class="rpt-card rpt-no-print">
                <div class="rpt-card__body">
                    <form class="rpt-filters" method="get" action="<?= site_url('crm-reporting') ?>">
                        <div class="form-group" style="flex-basis:300px">
                            <label for="rptProjet">Projet</label>
                            <select id="rptProjet" name="projet_id" class="form-control" onchange="this.form.submit()">
                                <?php foreach ($portefeuille as $p): ?>
                                    <option value="<?= (int) $p['id'] ?>"
                                        <?= (int) $p['id'] === (int) $projetId ? 'selected' : '' ?>>
                                        <?= $e($p['reference'] . ' · ' . $p['name']) ?><?= $p['devis'] > 0 ? ' ★' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rptDu">Paiements du</label>
                            <input id="rptDu" name="du" type="date" class="form-control"
                                value="<?= $e(isset($filters['date_du']) ? $filters['date_du'] : '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="rptAu">Au</label>
                            <input id="rptAu" name="au" type="date" class="form-control"
                                value="<?= $e(isset($filters['date_au']) ? $filters['date_au'] : '') ?>">
                        </div>
                        <div class="rpt-actions">
                            <button type="submit" class="btn rpt-btn rpt-btn-brand"><i class="fas fa-filter"></i>
                                Appliquer</button>
                            <a href="<?= site_url('crm-reporting') . ($projetId ? '?projet_id=' . (int) $projetId : '') ?>"
                                class="btn rpt-btn rpt-btn-ghost" title="Effacer la période"><i
                                    class="fas fa-undo"></i></a>
                            <?php if ($projet): ?>
                                <a href="<?= $url(['projet_id' => $projetId, 'export' => 'csv']) ?>"
                                    class="btn rpt-btn rpt-btn-ghost"><i class="fas fa-file-excel text-success"></i>
                                    Excel</a>
                            <?php endif; ?>
                            <button type="button" class="btn rpt-btn rpt-btn-ghost" onclick="window.print()"><i
                                    class="fas fa-print"></i> Imprimer / PDF</button>
                        </div>
                    </form>
                    <p class="text-muted-2 mb-0 mt-2" style="font-size:.75rem"><i class="fas fa-star"
                            style="font-size:.65rem"></i> projet ayant au moins un devis signé</p>
                </div>
            </div>

            <?php if (!$projet): ?>
                <div class="rpt-card">
                    <div class="rpt-card__body text-center py-5">
                        <i class="fas fa-folder-open fa-2x text-muted-2 mb-3"></i>
                        <h5 class="mb-1">Aucun projet à afficher</h5>
                        <p class="text-muted-2 mb-0">Créez un projet et ses chantiers pour voir le rapport de rentabilité.
                        </p>
                    </div>
                </div>
            <?php else: ?>

                <!-- ============ Bandeau projet ============ -->
                <div class="rpt-hero">
                    <div class="row align-items-center">
                        <div class="col-lg-8 mb-3 mb-lg-0" style="position:relative;z-index:1">
                            <span class="rpt-hero__code"><?= $e($projet['reference']) ?> ·
                                <?= $e($projet['status']) ?></span>
                            <h2 class="rpt-hero__name"><?= $e($projet['name']) ?></h2>
                            <div class="rpt-hero__meta">
                                <?php if (!empty($client)): ?><span><i
                                            class="fas fa-building"></i><?= $e($client) ?></span><?php endif; ?>
                                <span><i class="far fa-calendar"></i>Créé le <?= $dateFr($projet['created_at']) ?></span>
                                <span><i class="fas fa-hard-hat"></i><?= count($chantiers) ?>
                                    chantier<?= count($chantiers) > 1 ? 's' : '' ?>
                                    opérationnel<?= count($chantiers) > 1 ? 's' : '' ?></span>
                                <span><i class="fas fa-file-signature"></i><?= count($chantiersCrm) ?>
                                    chantier<?= count($chantiersCrm) > 1 ? 's' : '' ?> avec devis</span>
                                <?php if (!empty($filters['date_du']) || !empty($filters['date_au'])): ?>
                                    <span><i class="fas fa-filter"></i>Période : <?= $dateFr($filters['date_du'] ?? null) ?> →
                                        <?= $dateFr($filters['date_au'] ?? null) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="rpt-hero__progress">
                                <div class="lbl"><span>Avancement physique</span><b
                                        class="mono"><?= $pct($avancement, 0) ?></b></div>
                                <div class="rpt-hero__bar"><span style="width:<?= min(100, round($avancement)) ?>%"></span>
                                </div>
                                <div class="lbl"><span>Dépenses / coût du projet</span><b
                                        class="mono"><?= $conso !== null ? $pct($conso, 1) : '—' ?></b></div>
                                <div class="rpt-hero__bar" style="margin-bottom:0"><span class="pay"
                                        style="width:<?= $conso !== null ? min(100, round($conso)) : 0 ?>%<?= ($conso !== null && $conso > 100) ? ';background:#f3a39a' : '' ?>"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============ KPI ============ -->
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="rpt-kpi" style="--kpi-color: var(--rpt-devis)">
                            <div class="rpt-kpi__top">
                                <div class="rpt-kpi__label">Coût du projet</div>
                                <div class="rpt-kpi__icon"><i class="fas fa-file-invoice-dollar"></i></div>
                            </div>
                            <div class="rpt-kpi__value mono"><?= $fmtM($cout) ?><small>BIF</small></div>
                            <div class="rpt-kpi__full mono"><?= $fmt($cout) ?> BIF · devis signés</div>
                            <div class="rpt-kpi__foot"><span class="text-muted-2"><?= $nbDevisSignes ?> devis
                                    signé<?= $nbDevisSignes > 1 ? 's' : '' ?></span><b
                                    class="mono"><?= $devisAttente > 0 ? '+ ' . $fmtM($devisAttente) . ' en attente' : '' ?></b>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="rpt-kpi" style="--kpi-color: var(--rpt-depense)">
                            <div class="rpt-kpi__top">
                                <div class="rpt-kpi__label">Dépenses du projet</div>
                                <div class="rpt-kpi__icon"><i class="fas fa-coins"></i></div>
                            </div>
                            <div class="rpt-kpi__value mono"><?= $fmtM($tot['depenses']) ?><small>BIF</small></div>
                            <div class="rpt-kpi__full mono"><?= $fmt($tot['depenses']) ?> BIF</div>
                            <div class="rpt-kpi__foot"><span class="text-muted-2">Achats <b
                                        class="mono"><?= $fmtM($tot['achats']) ?></b></span><span
                                    class="text-muted-2">M.-d'œuvre <b class="mono"><?= $fmtM($tot['mo']) ?></b></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <?php $kpiBenefColor = $cout <= 0 ? 'var(--rpt-muted)' : ($benefice < 0 ? 'var(--rpt-loss)' : 'var(--rpt-profit)'); ?>
                        <div class="rpt-kpi" style="--kpi-color: <?= $kpiBenefColor ?>">
                            <div class="rpt-kpi__top">
                                <div class="rpt-kpi__label">Bénéfice</div>
                                <div class="rpt-kpi__icon"><i class="fas fa-chart-line"></i></div>
                            </div>
                            <?php if ($cout > 0): ?>
                                <div class="rpt-kpi__value mono <?= $benefice < 0 ? 'text-loss' : 'text-profit' ?>">
                                    <?= $fmtM($benefice) ?><small>BIF</small></div>
                                <div class="rpt-kpi__full mono"><?= $fmt($benefice) ?> BIF</div>
                                <div class="rpt-kpi__foot"><span class="text-muted-2">Taux de marge</span><b
                                        class="mono <?= $benefice < 0 ? 'text-loss' : 'text-profit' ?>"><?= $pct($tauxMarge) ?></b>
                                </div>
                            <?php else: ?>
                                <div class="rpt-kpi__value mono text-muted-2">—</div>
                                <div class="rpt-kpi__full">Non calculable</div>
                                <div class="rpt-kpi__foot"><span class="text-muted-2">Aucun devis signé sur ce projet</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="rpt-kpi"
                            style="--kpi-color: <?= ($margeTerme !== null && $margeTerme < 0) ? 'var(--rpt-loss)' : 'var(--rpt-warn)' ?>">
                            <div class="rpt-kpi__top">
                                <div class="rpt-kpi__label">Marge projetée à terme</div>
                                <div class="rpt-kpi__icon"><i class="fas fa-bullseye"></i></div>
                            </div>
                            <?php if ($margeTerme !== null): ?>
                                <div class="rpt-kpi__value mono <?= $margeTerme < 0 ? 'text-loss' : 'text-profit' ?>">
                                    <?= $fmtM($margeTerme) ?><small>BIF</small></div>
                                <div class="rpt-kpi__full mono">Coût estimé à terme : <?= $fmtM($coutTerme) ?></div>
                                <div class="rpt-kpi__foot"><span class="text-muted-2">Taux projeté</span><b
                                        class="mono"><?= $pct($margeTerme / $cout * 100) ?></b></div>
                            <?php else: ?>
                                <div class="rpt-kpi__value mono text-muted-2">—</div>
                                <div class="rpt-kpi__full"><?= $cout > 0 ? 'Avancement à 0 %' : 'Coût du projet inconnu' ?>
                                </div>
                                <div class="rpt-kpi__foot"><span class="text-muted-2">Dépenses ÷ avancement, dès que
                                        l'avancement est saisi</span></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- ============ Graphiques ============ -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="rpt-card">
                            <div class="rpt-card__head">
                                <div>
                                    <h3 class="rpt-card__title">Dépenses par chantier</h3>
                                    <p class="rpt-card__sub">Achats effectués et main-d'œuvre, en millions de BIF</p>
                                </div>
                                <div class="rpt-legend-inline">
                                    <span style="--c: var(--rpt-depense)">Achats effectués</span>
                                    <span style="--c: var(--rpt-devis)">Main-d'œuvre</span>
                                </div>
                            </div>
                            <div class="rpt-card__body">
                                <?php if ($tot['depenses'] > 0): ?>
                                    <div class="rpt-chart"><canvas id="rptChartChantiers"></canvas></div>
                                <?php else: ?>
                                    <div class="rpt-empty"><i class="fas fa-chart-bar"></i>Aucune dépense enregistrée sur la
                                        période.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="rpt-card">
                            <div class="rpt-card__head">
                                <div>
                                    <h3 class="rpt-card__title">Coût du projet vs dépenses</h3>
                                    <p class="rpt-card__sub">Où en est le budget du projet</p>
                                </div>
                            </div>
                            <div class="rpt-card__body">
                                <div class="rpt-chart rpt-chart--sm" style="height:200px">
                                    <canvas id="rptChartBudget"></canvas>
                                    <div class="rpt-donut-center">
                                        <div>
                                            <b
                                                class="mono <?= ($cout > 0 && $benefice < 0) ? 'text-loss' : '' ?>"><?= $conso !== null ? $pct($conso, 1) : '—' ?></b>
                                            <span><?= $conso !== null ? 'du coût consommé' : 'pas de devis signé' ?></span>
                                        </div>
                                    </div>
                                </div>
                                <ul class="rpt-cat-list">
                                    <li><span><i style="background:var(--rpt-depense)"></i>Achats effectués</span><span
                                            class="mono"><b><?= $fmtM($tot['achats']) ?></b></span></li>
                                    <li><span><i style="background:var(--rpt-devis)"></i>Main-d'œuvre</span><span
                                            class="mono"><b><?= $fmtM($tot['mo']) ?></b></span></li>
                                    <?php if ($cout > 0): ?>
                                        <li><span><i
                                                    style="background:<?= $benefice < 0 ? 'var(--rpt-loss)' : '#dfe7e3' ?>"></i><?= $benefice >= 0 ? 'Reste (bénéfice)' : 'Dépassement' ?></span><span
                                                class="mono"><b
                                                    class="<?= $benefice < 0 ? 'text-loss' : 'text-profit' ?>"><?= $fmtM($benefice) ?></b></span>
                                        </li>
                                    <?php else: ?>
                                        <li><span class="text-muted-2"><i style="background:#dfe7e3"></i>Aucun devis signé : pas
                                                de coût de référence</span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============ Dépenses par chantier ============ -->
                <div class="rpt-card">
                    <div class="rpt-card__head">
                        <div>
                            <h3 class="rpt-card__title">Dépenses par chantier</h3>
                            <p class="rpt-card__sub">Achats payés (bon de paiement effectué) + contrats de main-d'œuvre ·
                                cliquez sur une ligne pour le détail</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table rpt-table">
                            <thead>
                                <tr>
                                    <th>Chantier</th>
                                    <th>Statut</th>
                                    <th class="num">Achats effectués</th>
                                    <th class="num">Main-d'œuvre</th>
                                    <th class="num">Dépenses totales</th>
                                    <th style="min-width:170px">Part des dépenses du projet</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($chantiers)): ?>
                                    <tr style="cursor:default">
                                        <td colspan="6" class="text-center text-muted-2 py-4">Aucun chantier opérationnel
                                            rattaché à ce projet.</td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($chantiers as $c):
                                    $part = $tot['depenses'] > 0 ? $c['depenses'] / $tot['depenses'] * 100 : 0; ?>
                                    <tr data-rpt-id="<?= (int) $c['id'] ?>">
                                        <td>
                                            <div class="rpt-ch-name"><?= $e($c['name']) ?></div>
                                            <div class="rpt-ch-meta">
                                                <?= $e($c['ref_chantier'] ?: 'CH-' . $c['id']) ?>
                                                <?= $c['chef_chantier'] ? ' · ' . $e($c['chef_chantier']) : '' ?>
                                                <?= $c['location'] ? ' · ' . $e(trim($c['location'])) : '' ?>
                                            </div>
                                        </td>
                                        <td><span class="rpt-badge rpt-badge--neutral"><?= $e($c['status']) ?></span></td>
                                        <td class="num mono">
                                            <?= $fmt($c['achats']) ?>
                                            <div class="rpt-gauge-legend"><?= (int) $c['nb_achats'] ?>
                                                demande<?= $c['nb_achats'] > 1 ? 's' : '' ?></div>
                                        </td>
                                        <td class="num mono">
                                            <?= $fmt($c['main_oeuvre']) ?>
                                            <div class="rpt-gauge-legend">
                                                <?= (int) $c['nb_contrats'] ?> contrat<?= $c['nb_contrats'] > 1 ? 's' : '' ?>
                                                <?php if ($c['nb_sans_montant'] > 0): ?>
                                                    · <span class="text-warn" title="Contrats avec contract_amount = 0"><i
                                                            class="fas fa-exclamation-triangle"></i>
                                                        <?= (int) $c['nb_sans_montant'] ?> sans montant</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="num mono"><b><?= $fmt($c['depenses']) ?></b></td>
                                        <td>
                                            <div class="rpt-progress">
                                                <div class="rpt-progress__track">
                                                    <div class="rpt-progress__fill"
                                                        style="width:<?= round($part, 1) ?>%;background:var(--rpt-depense)">
                                                    </div>
                                                </div>
                                                <span class="rpt-progress__val mono"><?= round($part) ?>%</span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <?php if (!empty($chantiers)): ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Total dépenses du projet</td>
                                        <td class="num mono"><?= $fmt($tot['achats']) ?><div class="rpt-gauge-legend">
                                                <?= $tot['nb_achats'] ?> demande<?= $tot['nb_achats'] > 1 ? 's' : '' ?></div>
                                        </td>
                                        <td class="num mono"><?= $fmt($tot['mo']) ?><div class="rpt-gauge-legend">
                                                <?= $tot['nb_contrats'] ?> contrat<?= $tot['nb_contrats'] > 1 ? 's' : '' ?>
                                            </div>
                                        </td>
                                        <td class="num mono"><?= $fmt($tot['depenses']) ?></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>

                <!-- ============ Devis & avancement ============ -->
                <div class="rpt-card">
                    <div class="rpt-card__head">
                        <div>
                            <h3 class="rpt-card__title">Devis et avancement des chantiers du projet</h3>
                            <p class="rpt-card__sub">La somme des devis signés forme le coût du projet</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table rpt-table">
                            <thead>
                                <tr>
                                    <th>Chantier</th>
                                    <th>Statut</th>
                                    <th style="min-width:150px">Avancement</th>
                                    <th>Devis signés</th>
                                    <th class="num">Montant signé</th>
                                    <th class="num">En attente</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($chantiersCrm)): ?>
                                    <tr style="cursor:default">
                                        <td colspan="6" class="text-center text-muted-2 py-4">Aucun chantier avec devis pour ce
                                            projet (Chantiers &amp; Avancement).</td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($chantiersCrm as $k): ?>
                                    <tr style="cursor:default">
                                        <td>
                                            <div class="rpt-ch-name"><?= $e($k['name']) ?></div>
                                            <div class="rpt-ch-meta">
                                                <?= $e(trim(($k['chef_chantier'] ?: '') . ($k['location'] ? ' · ' . $k['location'] : ''), ' ·')) ?>
                                            </div>
                                        </td>
                                        <td><span class="rpt-badge rpt-badge--neutral"><?= $e($k['status']) ?></span></td>
                                        <td>
                                            <div class="rpt-progress">
                                                <div class="rpt-progress__track">
                                                    <div class="rpt-progress__fill"
                                                        style="width:<?= min(100, (float) $k['avancement']) ?>%"></div>
                                                </div>
                                                <span class="rpt-progress__val mono"><?= round($k['avancement']) ?>%</span>
                                            </div>
                                        </td>
                                        <td class="mono" style="font-size:.8rem">
                                            <?= $k['refs_signes'] ? $e($k['refs_signes']) : '<span class="text-muted-2">—</span>' ?>
                                        </td>
                                        <td class="num mono"><b><?= $fmt($k['devis_signe']) ?></b></td>
                                        <td class="num mono text-muted-2">
                                            <?= $k['devis_attente'] > 0 ? $fmt($k['devis_attente']) : '—' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <?php if (!empty($chantiersCrm)): ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Coût du projet</td>
                                        <td class="mono"><?= $pct($avancement, 0) ?></td>
                                        <td></td>
                                        <td class="num mono"><?= $fmt($cout) ?></td>
                                        <td class="num mono"><?= $devisAttente > 0 ? $fmt($devisAttente) : '—' ?></td>
                                    </tr>
                                </tfoot>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>

                <!-- ============ Calcul du bénéfice + points d'attention ============ -->
                <div class="row">
                    <div class="col-lg-5">
                        <div class="rpt-card">
                            <div class="rpt-card__head">
                                <div>
                                    <h3 class="rpt-card__title">Calcul du bénéfice</h3>
                                    <p class="rpt-card__sub"><?= $e($projet['name']) ?></p>
                                </div>
                            </div>
                            <div class="rpt-card__body">
                                <div class="rpt-calc">
                                    <div class="rpt-calc__row"><span>Coût du projet <small>(devis signés)</small></span><b
                                            class="mono"><?= $fmt($cout) ?></b></div>
                                    <div class="rpt-calc__row minus"><span>Achats effectués</span><b class="mono">−
                                            <?= $fmt($tot['achats']) ?></b></div>
                                    <div class="rpt-calc__row minus"><span>Main-d'œuvre</span><b class="mono">−
                                            <?= $fmt($tot['mo']) ?></b></div>
                                    <div class="rpt-calc__row total <?= ($cout > 0 && $benefice < 0) ? 'loss' : '' ?>">
                                        <span>Bénéfice</span>
                                        <b class="mono"><?= $cout > 0 ? $fmt($benefice) . ' BIF' : 'Non calculable' ?></b>
                                    </div>
                                    <?php if ($tauxMarge !== null): ?>
                                        <div class="rpt-calc__note">Soit une marge de <b><?= $pct($tauxMarge) ?></b> sur le coût
                                            du projet.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="rpt-card">
                            <div class="rpt-card__head">
                                <div>
                                    <h3 class="rpt-card__title">Points d'attention</h3>
                                    <p class="rpt-card__sub">Détectés automatiquement à partir des données</p>
                                </div>
                                <?php if ($alertes): ?>
                                    <span
                                        class="rpt-badge rpt-badge--<?= $nbAlertesFortes ? 'danger' : 'neutral' ?>"><?= count($alertes) ?>
                                        point<?= count($alertes) > 1 ? 's' : '' ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="rpt-card__body">
                                <?php if (empty($alertes)): ?>
                                    <p class="text-muted-2 mb-0"><i class="fas fa-check-circle text-success"></i> Aucun point
                                        d'attention sur ce projet.</p>
                                <?php endif; ?>
                                <?php foreach ($alertes as $a):
                                    $ic = ['danger' => 'fa-exclamation-circle', 'warning' => 'fa-exclamation-triangle', 'info' => 'fa-info-circle'][$a[0]]; ?>
                                    <div class="rpt-alert rpt-alert--<?= $a[0] ?>">
                                        <div class="rpt-alert__icon"><i class="fas <?= $ic ?>"></i></div>
                                        <div><b><?= $e($a[1]) ?></b>
                                            <p><?= $e($a[2]) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; /* projet */ ?>

            <!-- ============ Portefeuille ============ -->
            <div class="rpt-card">
                <div class="rpt-card__head">
                    <div>
                        <h3 class="rpt-card__title">Portefeuille de projets</h3>
                        <p class="rpt-card__sub">Coût (devis signés), dépenses et bénéfice par projet · cliquez sur un
                            projet pour l'ouvrir</p>
                    </div>
                    <?php if ($pfMasques > 0): ?>
                        <span class="rpt-badge rpt-badge--neutral"><?= $pfMasques ?> projet<?= $pfMasques > 1 ? 's' : '' ?>
                            sans devis ni dépense masqué<?= $pfMasques > 1 ? 's' : '' ?></span>
                    <?php endif; ?>
                </div>
                <div class="table-responsive">
                    <table class="table rpt-table">
                        <thead>
                            <tr>
                                <th>Projet</th>
                                <th class="num">Chantiers</th>
                                <th class="num">Coût du projet</th>
                                <th class="num">Achats</th>
                                <th class="num">Main-d'œuvre</th>
                                <th class="num">Dépenses</th>
                                <th class="num">Bénéfice</th>
                                <th style="min-width:150px">Dépenses / coût</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $pt = ['devis' => 0, 'achats' => 0, 'mo' => 0, 'depenses' => 0];
                            foreach ($pfActifs as $p):
                                $pt['devis'] += $p['devis'];
                                $pt['achats'] += $p['achats'];
                                $pt['mo'] += $p['main_oeuvre'];
                                $pt['depenses'] += $p['depenses'];
                                $pc = $p['devis'] > 0 ? $p['depenses'] / $p['devis'] * 100 : null;
                                $pb = $p['devis'] - $p['depenses'];
                                $col = $pc === null ? '#9aa7b1' : ($pc > 90 ? '#c0392b' : ($pc > 75 ? '#d99a1e' : '#2e9b6a')); ?>
                                <tr class="<?= (int) $p['id'] === (int) $projetId ? 'rpt-row-active' : '' ?>"
                                    onclick="location.href='<?= $url(['projet_id' => (int) $p['id']]) ?>'">
                                    <td>
                                        <div class="rpt-ch-name"><?= $e($p['name']) ?></div>
                                        <div class="rpt-ch-meta"><?= $e($p['reference']) ?> · <?= $e($p['status']) ?></div>
                                    </td>
                                    <td class="num mono"><?= (int) $p['nb_chantiers'] ?></td>
                                    <td class="num mono">
                                        <?= $p['devis'] > 0 ? '<b>' . $fmt($p['devis']) . '</b>' : '<span class="text-muted-2">aucun devis</span>' ?>
                                    </td>
                                    <td class="num mono"><?= $fmt($p['achats']) ?></td>
                                    <td class="num mono"><?= $fmt($p['main_oeuvre']) ?></td>
                                    <td class="num mono"><?= $fmt($p['depenses']) ?></td>
                                    <td
                                        class="num mono <?= $p['devis'] > 0 ? ($pb < 0 ? 'text-loss' : 'text-profit') : 'text-muted-2' ?>">
                                        <?= $p['devis'] > 0 ? $fmt($pb) : '—' ?></td>
                                    <td>
                                        <?php if ($pc !== null): ?>
                                            <div class="rpt-progress">
                                                <div class="rpt-progress__track">
                                                    <div class="rpt-progress__fill"
                                                        style="width:<?= min(100, round($pc)) ?>%;background:<?= $col ?>"></div>
                                                </div>
                                                <span class="rpt-progress__val mono"><?= round($pc) ?>%</span>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted-2" style="font-size:.75rem">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total portefeuille</td>
                                <td class="num mono"><?= $fmt($pt['devis']) ?></td>
                                <td class="num mono"><?= $fmt($pt['achats']) ?></td>
                                <td class="num mono"><?= $fmt($pt['mo']) ?></td>
                                <td class="num mono"><?= $fmt($pt['depenses']) ?></td>
                                <td class="num mono text-muted-2" title="Seuls les projets avec devis ont un bénéfice">—
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <p class="text-center text-muted-2 mb-4" style="font-size:.75rem">
                Rapport généré le <?= date('d/m/Y à H:i') ?> · SATRACO Construction ERP
            </p>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- ============ Modal détail chantier ============ -->
<div class="modal fade rpt-modal rpt" id="rptDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <small id="rptMCode" style="opacity:.8"></small>
                    <h5 class="modal-title font-weight-bold" id="rptMNom"></h5>
                    <small id="rptMResp" style="opacity:.8"></small>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row" id="rptMMinis"></div>
                <h6 class="font-weight-bold mt-4 mb-3">Main-d'œuvre par type</h6>
                <div id="rptMMo"></div>
                <h6 class="font-weight-bold mt-4 mb-2">Achats effectués <small class="text-muted-2"
                        id="rptMAchatsNb"></small></h6>
                <div class="table-responsive">
                    <table class="table table-sm rpt-table mb-0">
                        <thead>
                            <tr>
                                <th>Payé le</th>
                                <th>Demande</th>
                                <th>Désignation</th>
                                <th class="num">Montant (BIF)</th>
                            </tr>
                        </thead>
                        <tbody id="rptMAchats"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn rpt-btn rpt-btn-ghost" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.RPT_DATA = <?= json_encode($jsData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
    window.RPT_COUT = <?= json_encode((float) $cout) ?>;

    (function() {
        var D = window.RPT_DATA;
        var C = {
            achat: '#d4782c',
            mo: '#2f5d8a',
            reste: '#dfe7e3',
            loss: '#c0392b'
        };

        var nf = new Intl.NumberFormat('fr-FR');
        var fmt = function(n) {
            return nf.format(Math.round(n)).replace(/\u202f|\u00a0/g, ' ');
        };
        var fmtM = function(n) {
            return (n / 1e6).toLocaleString('fr-FR', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            }) + ' M';
        };
        var esc = function(s) {
            return String(s == null ? '' : s).replace(/[&<>"']/g, function(c) {
                return ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                })[c];
            });
        };
        var dateFr = function(d) {
            if (!d) return '—';
            var p = d.split('-');
            return p[2] + '/' + p[1] + '/' + p[0];
        };

        /* ---------- Graphiques (Chart.js v4, chargé si absent) ---------- */
        function withChart(cb) {
            // AdminLTE 3 embarque parfois Chart.js v2 : on n'utilise l'instance globale que si elle est en v4+
            if (window.Chart && parseInt(String(Chart.version || '0'), 10) >= 4) return cb();
            var s = document.createElement('script');
            s.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js';
            s.onload = cb;
            document.head.appendChild(s);
        }

        withChart(function() {
            Chart.defaults.font.family = getComputedStyle(document.body).fontFamily;
            Chart.defaults.color = '#6b7a86';
            var M = function(v) {
                return +(v / 1e6).toFixed(2);
            };

            var el = document.getElementById('rptChartChantiers');
            if (el) {
                var rows = D.chantiers.filter(function(c) {
                    return c.depenses > 0;
                });
                el.parentNode.style.height = Math.max(220, Math.min(420, 60 + rows.length * 38)) + 'px';
                new Chart(el, {
                    type: 'bar',
                    data: {
                        labels: rows.map(function(c) {
                            return c.nom.length > 28 ? c.nom.slice(0, 27) + '…' : c.nom;
                        }),
                        datasets: [{
                                label: 'Achats effectués',
                                data: rows.map(function(c) {
                                    return M(c.achats);
                                }),
                                backgroundColor: C.achat,
                                borderRadius: 4,
                                maxBarThickness: 22
                            },
                            {
                                label: "Main-d'œuvre",
                                data: rows.map(function(c) {
                                    return M(c.mo);
                                }),
                                backgroundColor: C.mo,
                                borderRadius: 4,
                                maxBarThickness: 22
                            }
                        ]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(ctx) {
                                        return ' ' + ctx.dataset.label + ' : ' + fmt(ctx.parsed.x *
                                            1e6) + ' BIF';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: true,
                                beginAtZero: true,
                                grid: {
                                    color: '#eef1f3'
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    callback: function(v) {
                                        return v + ' M';
                                    }
                                }
                            },
                            y: {
                                stacked: true,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            }

            var elB = document.getElementById('rptChartBudget');
            if (elB) {
                var cout = window.RPT_COUT,
                    a = D.totaux.achats,
                    m = D.totaux.mo;
                var reste = Math.max(0, cout - a - m);
                var vals = cout > 0 ? [a, m, reste] : [a, m];
                var cols = cout > 0 ? [C.achat, C.mo, (a + m > cout ? C.loss : C.reste)] : [C.achat, C.mo];
                if (vals.every(function(v) {
                        return v <= 0;
                    })) {
                    vals = [1];
                    cols = [C.reste];
                }
                new Chart(elB, {
                    type: 'doughnut',
                    data: {
                        labels: cout > 0 ? ['Achats effectués', "Main-d'œuvre", 'Reste'] : [
                            'Achats effectués', "Main-d'œuvre"
                        ],
                        datasets: [{
                            data: vals,
                            backgroundColor: cols,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '74%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(ctx) {
                                        return ' ' + ctx.label + ' : ' + fmt(ctx.parsed) + ' BIF';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });

        /* ---------- Modal détail chantier ---------- */
        function openDetail(id) {
            var c = D.chantiers.find(function(x) {
                return x.id === id;
            });
            if (!c) return;
            document.getElementById('rptMCode').textContent = (c.ref || ('CH-' + c.id)) + ' · ' + (c.statut || '') + (c
                .lieu ? ' · ' + c.lieu : '');
            document.getElementById('rptMNom').textContent = c.nom;
            document.getElementById('rptMResp').textContent = c.chef ? 'Chef de chantier : ' + c.chef : '';

            var mini = function(lbl, val, sub) {
                return '<div class="col-6 col-md-4 mb-2"><div class="rpt-mini"><span>' + lbl +
                    '</span><b class="mono">' + val + '</b>' + (sub ? '<div class="rpt-gauge-legend">' + sub +
                        '</div>' : '') + '</div></div>';
            };
            document.getElementById('rptMMinis').innerHTML =
                mini('Achats effectués', fmtM(c.achats), c.nb_achats + ' demande(s)') +
                mini("Main-d'œuvre", fmtM(c.mo), c.nb_contrats + ' contrat(s)' + (c.nb_sans_montant ? ' · ' + c
                    .nb_sans_montant + ' sans montant' : '')) +
                mini('Dépenses totales', fmtM(c.depenses), '');

            var max = Math.max.apply(null, c.mo_detail.map(function(x) {
                return x.nb;
            }).concat([1]));
            document.getElementById('rptMMo').innerHTML = c.mo_detail.length ? c.mo_detail.map(function(x) {
                    return '<div class="rpt-bar-row"><span>' + esc(x.type) + ' <small class="text-muted-2">(' + x
                        .nb + ')</small></span>' +
                        '<div class="trk"><span style="width:' + (x.nb / max * 100) +
                        '%;background:#2f5d8a"></span></div>' +
                        '<span class="mono text-right">' + fmt(x.montant) + '</span></div>';
                }).join('') :
                '<p class="text-muted-2 mb-0" style="font-size:.85rem">Aucun contrat de main-d\'œuvre.</p>';

            var total = 0;
            document.getElementById('rptMAchatsNb').textContent = c.achats_detail.length < c.nb_achats ?
                '(' + c.achats_detail.length + ' plus récents sur ' + c.nb_achats + ')' : '(' + c.nb_achats + ')';
            document.getElementById('rptMAchats').innerHTML = c.achats_detail.length ? c.achats_detail.map(function(x) {
                    total += x.montant;
                    return '<tr style="cursor:default"><td class="mono" style="white-space:nowrap">' + dateFr(x
                            .date) + '</td>' +
                        '<td class="mono" style="white-space:nowrap">' + esc(x.ref) + '</td>' +
                        '<td>' + esc(x.libelle) + (x.nb_lignes > 1 ? ' <small class="text-muted-2">+ ' + (x
                            .nb_lignes - 1) + ' ligne(s)</small>' : '') +
                        (x.demandeur ? '<div class="rpt-ch-meta">Demandé par ' + esc(x.demandeur) + '</div>' : '') +
                        '</td>' +
                        '<td class="num mono">' + fmt(x.montant) + '</td></tr>';
                }).join('') +
                '<tr style="cursor:default"><td colspan="3"><b>Total affiché</b></td><td class="num mono"><b>' + fmt(
                    total) + '</b></td></tr>' :
                '<tr style="cursor:default"><td colspan="4" class="text-center text-muted-2">Aucun achat effectué.</td></tr>';

            if (window.jQuery && jQuery.fn.modal) {
                jQuery('#rptDetailModal').modal('show');
            }
        }

        document.querySelectorAll('tr[data-rpt-id]').forEach(function(tr) {
            tr.addEventListener('click', function() {
                openDetail(parseInt(tr.getAttribute('data-rpt-id'), 10));
            });
        });
    })();
</script>