<?php
$fmt = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$dfr = function ($d) {
    return empty($d) ? '—' : date('d/m/Y', strtotime($d));
};

$stats  = isset($reportStats) && is_array($reportStats) ? $reportStats : [];
$rows   = isset($reportRows) && is_array($reportRows) ? $reportRows : [];
$recent = isset($recentRegularisations) && is_array($recentRegularisations) ? $recentRegularisations : [];

$totalPaid = isset($stats['total_paid']) ? (float) $stats['total_paid'] : 0;
$totalRet  = isset($stats['total_retours']) ? (float) $stats['total_retours'] : 0;
$totalSup  = isset($stats['total_supplements']) ? (float) $stats['total_supplements'] : 0;
$adjusted  = isset($stats['adjusted']) ? (float) $stats['adjusted'] : 0;

$situationMeta = [
    'retour'     => 'Retour caisse',
    'supplement' => 'Supplément payé',
    'soldee'     => 'Soldée',
    'attente'    => 'En attente de retour',
];

$ecartNet = 0;
foreach ($rows as $r) {
    $ecartNet += $r->ecart;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rapport financier — <?= date('d/m/Y') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        color: #111;
        margin: 20px;
    }

    .print-topbar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .topbar-logo img {
        height: 60px;
        width: auto;
    }

    .logo-fallback {
        display: none;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 2px;
        color: #4a7a3a;
    }

    .topbar-actions button {
        padding: 9px 16px;
        margin-left: 8px;
        border: 1px solid #333;
        border-radius: 6px;
        background: #fff;
        font-weight: 700;
        cursor: pointer;
    }

    .topbar-actions button:hover {
        background: #eee;
    }

    .head {
        text-align: center;
        margin-bottom: 12px;
    }

    h1 {
        display: inline-block;
        font-size: 16px;
        margin: 8px 0 4px;
        text-transform: uppercase;
        border: 1.5px solid #111;
        padding: 4px 18px;
    }

    .meta {
        font-size: 10px;
        margin: 3px 0;
    }

    .kpi-row {
        display: flex;
        justify-content: center;
        gap: 24px;
        margin-bottom: 12px;
        font-size: 10px;
    }

    .kpi-row strong {
        display: block;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9px;
        margin-bottom: 12px;
    }

    th,
    td {
        border: 1px solid #111;
        padding: 4px 5px;
        vertical-align: top;
    }

    th {
        background: #efefef;
        font-size: 8px;
        text-transform: uppercase;
        text-align: left;
    }

    td.num,
    th.num {
        text-align: right;
        white-space: nowrap;
    }

    td.ctr {
        text-align: center;
    }

    tfoot td {
        font-weight: 700;
        background: #f7f7f7;
    }

    h2 {
        font-size: 12px;
        text-transform: uppercase;
        border-bottom: 1px solid #111;
        padding-bottom: 3px;
        margin: 14px 0 6px;
    }

    .signatures {
        display: flex;
        justify-content: space-between;
        margin-top: 26px;
    }

    .sig-block {
        width: 30%;
        text-align: center;
        font-size: 10px;
        font-weight: 700;
    }

    .sig-line {
        display: block;
        height: 44px;
        border: 1px solid #111;
        margin-top: 6px;
    }

    @page {
        size: A4 landscape;
        margin: 8mm;
    }

    @media print {
        .topbar-actions {
            display: none !important;
        }

        body {
            margin: 0;
        }
    }
    </style>
</head>

<body>

    <!-- BARRE HAUTE : LOGO + BOUTONS -->
    <div class="print-topbar">
        <div class="topbar-logo">
            <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO Construction"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            <span class="logo-fallback">SATRACO CONSTRUCTION</span>
        </div>
        <div class="topbar-actions">
            <button onclick="window.print()"><i class="fas fa-print"></i> Imprimer</button>
            <button onclick="window.close()"><i class="fas fa-times"></i> Fermer</button>
        </div>
    </div>

    <!-- TITRE -->
    <div class="head">
        <h1>Rapport financier — Rapprochement des demandes d'achat</h1>
        <div class="meta">
            <strong>Édité le :</strong> <?= date('d/m/Y H:i') ?>
            · <strong>Par :</strong> <?= html_escape($this->session->userdata('user_name') ?? '—') ?>
            · <strong>Bons effectués :</strong> <?= count($rows) ?>
        </div>
    </div>

    <!-- SYNTHÈSE -->
    <div class="kpi-row">
        <div><strong><?= $fmt($totalPaid) ?> BIF</strong> Total payé (bons)</div>
        <div><strong>+ <?= $fmt($totalRet) ?> BIF</strong> Retours à la caisse</div>
        <div><strong>- <?= $fmt($totalSup) ?> BIF</strong> Suppléments payés</div>
        <div><strong><?= $fmt($adjusted) ?> BIF</strong> Dépense réelle ajustée</div>
    </div>

    <!-- TABLEAU DE RAPPROCHEMENT -->
    <table>
        <thead>
            <tr>
                <th style="width:3%;">N°</th>
                <th style="width:10%;">DA / Bon de paiement</th>
                <th style="width:8%;">Date paiement</th>
                <th style="width:17%;">Chantier / Objet</th>
                <th style="width:11%;">Bénéficiaire</th>
                <th style="width:9%;" class="num">Montant payé</th>
                <th style="width:9%;" class="num">Dépense réelle</th>
                <th style="width:8%;" class="num">Écart</th>
                <th style="width:11%;">Situation</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rows)): ?>
            <?php foreach ($rows as $i => $row): ?>
            <?php
                    $year  = date('Y', strtotime(!empty($row->request_date) ? $row->request_date : $row->created_at));
                    $daRef = 'DA-' . $year . '-' . str_pad((int) $row->id, 4, '0', STR_PAD_LEFT);
                    $chantier = !empty($row->chantier_name) ? $row->chantier_name : $row->destination_chantier;
                    $benef = !empty($row->buyer_name) ? $row->buyer_name : $row->requested_by;
                    ?>
            <tr>
                <td class="ctr"><?= $i + 1 ?></td>
                <td><?= html_escape($daRef) ?><br><small><?= html_escape($row->payment_number) ?></small></td>
                <td><?= $dfr($row->payment_date) ?></td>
                <td><?= html_escape($row->summary) ?><br><small><?= html_escape($chantier) ?></small></td>
                <td><?= html_escape($benef) ?></td>
                <td class="num"><?= $fmt($row->amount_paid) ?></td>
                <td class="num"><?= $row->situation === 'attente' ? '—' : $fmt($row->real_expense) ?></td>
                <td class="num">
                    <?php if ($row->situation === 'attente'): ?>—<?php
                                                                        elseif ($row->ecart > 0): ?>+
                    <?= $fmt($row->ecart) ?><?php
                                                                        elseif ($row->ecart < 0): ?>-
                    <?= $fmt(abs($row->ecart)) ?><?php
                                                                        else: ?>0<?php endif; ?>
                </td>
                <td><?= $situationMeta[$row->situation] ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="9" class="ctr">Aucune demande rapprochée.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">TOTAUX — Écart net :
                    <?= $ecartNet >= 0 ? '+ ' . $fmt($ecartNet) . ' (en faveur de la caisse)' : '- ' . $fmt(abs($ecartNet)) . ' (en défaveur de la caisse)' ?>
                </td>
                <td class="num"><?= $fmt($totalPaid) ?></td>
                <td class="num"><?= $fmt($adjusted) ?></td>
                <td class="num"><?= $ecartNet >= 0 ? '+ ' . $fmt($ecartNet) : '- ' . $fmt(abs($ecartNet)) ?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- RÉGULARISATIONS -->
    <?php if (!empty($recent)): ?>
    <h2>Régularisations enregistrées (retours / suppléments / soldes)</h2>
    <table>
        <thead>
            <tr>
                <th style="width:10%;">Référence</th>
                <th style="width:10%;">Date</th>
                <th style="width:12%;">DA concernée</th>
                <th style="width:12%;">Type</th>
                <th style="width:10%;" class="num">Montant</th>
                <th style="width:14%;">Concerné</th>
                <th style="width:12%;">Reçu / pièce</th>
                <th style="width:20%;">Justification</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent as $reg): ?>
            <?php
                    $typeLabel = ['retour' => 'Retour à la caisse', 'supplement' => 'Supplément payé', 'exact' => 'Demande soldée'];
                    $signe = $reg->regularisation_type === 'retour' ? '+ ' : ($reg->regularisation_type === 'supplement' ? '- ' : '');
                    ?>
            <tr>
                <td><?= html_escape($reg->reference) ?></td>
                <td><?= $dfr($reg->regularisation_date) ?></td>
                <td>DA-<?= date('Y', strtotime($reg->created_at)) ?>-<?= str_pad((int) $reg->purchase_request_id, 4, '0', STR_PAD_LEFT) ?>
                </td>
                <td><?= $typeLabel[$reg->regularisation_type] ?></td>
                <td class="num"><?= $signe ?><?= $fmt($reg->amount) ?> BIF</td>
                <td><?= html_escape(!empty($reg->concerned) ? $reg->concerned : '—') ?></td>
                <td><?= html_escape(!empty($reg->receipt_number) ? $reg->receipt_number : '—') ?></td>
                <td><?= html_escape($reg->justification) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- SIGNATURES -->
    <!-- <div class="signatures">
        <div class="sig-block">Préparé par<br>(Comptable)<span class="sig-line"></span></div>
        <div class="sig-block">Vérifié par<br>(Responsable DAF)<span class="sig-line"></span></div>
        <div class="sig-block">Approuvé par<br>(Directeur Général)<span class="sig-line"></span></div>
    </div> -->

    <div class="signatures">
        <div class="sig-block">Préparé par<br><span class="sig-line"></span></div>
        <div class="sig-block">Vérifié par<br><span class="sig-line"></span></div>
        <div class="sig-block">Approuvé par<br><span class="sig-line"></span></div>
    </div>

    <script>
    window.addEventListener('load', function() {
        setTimeout(function() {
            window.print();
        }, 400);
    });
    </script>
</body>

</html>