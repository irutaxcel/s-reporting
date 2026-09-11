<?php
if (!function_exists('formatCashboxAmount')) {
    function formatCashboxAmount($amount): string
    {
        return number_format((float) $amount, 0, ',', ' ');
    }
}
if (!function_exists('formatCashboxDate')) {
    function formatCashboxDate($date): string
    {
        return empty($date) ? '—' : date('d/m/Y', strtotime($date));
    }
}
if (!function_exists('formatCashboxTime')) {
    function formatCashboxTime($datetime): string
    {
        return empty($datetime) ? '' : date('H:i', strtotime($datetime));
    }
}
if (!function_exists('livrePageUrl')) {
    function livrePageUrl($page)
    {
        $params = $_GET;
        if ($page > 1) {
            $params['page'] = $page;
        } else {
            unset($params['page']);
        }
        $query = http_build_query($params);
        return current_url() . ($query !== '' ? '?' . $query : '');
    }
}
if (!function_exists('livreNatureInfo')) {
    function livreNatureInfo($nature)
    {
        switch ($nature) {
            case 'encaissement':
                return ['label' => 'Encaissement', 'class' => 'badge-entree', 'icon' => 'fas fa-arrow-down'];
            case 'approvisionnement':
                return ['label' => 'Transfert → secondaire', 'class' => 'badge-transfert', 'icon' => 'fas fa-exchange-alt'];
            case 'approvisionnement_recu':
                return ['label' => 'Approvisionnement reçu', 'class' => 'badge-transfert', 'icon' => 'fas fa-exchange-alt'];
            case 'paiement_da':
                return ['label' => 'Paiement DA', 'class' => 'badge-sortie', 'icon' => 'fas fa-arrow-up'];
            case 'solde_initial':
                return ['label' => 'Solde initial', 'class' => 'badge-initial', 'icon' => 'fas fa-flag'];
            default:
                return ['label' => 'Opération', 'class' => 'badge-transfert', 'icon' => 'fas fa-exchange-alt'];
        }
    }
}

/* ---------- Extraction sécurisée ---------- */
$cashbox   = isset($cashbox) && is_object($cashbox) ? $cashbox : null;
$role      = isset($cashboxRole) ? $cashboxRole : 'secondaire';
$movements = isset($livreMovements) && is_array($livreMovements) ? $livreMovements : [];
$stats     = isset($livreStats) && is_array($livreStats) ? $livreStats : [];
$pag       = isset($livrePagination) && is_array($livrePagination) ? $livrePagination : [];

$balance      = $cashbox ? (float) $cashbox->current_balance : 0;
$opening      = $cashbox ? (float) $cashbox->opening_balance : 0;
$threshold    = $cashbox ? (float) $cashbox->alert_threshold : 0;
$totalIn      = isset($stats['total_in']) ? (float) $stats['total_in'] : 0;
$totalOut     = isset($stats['total_out']) ? (float) $stats['total_out'] : 0;
$countIn      = isset($stats['count_in']) ? (int) $stats['count_in'] : 0;
$countOut     = isset($stats['count_out']) ? (int) $stats['count_out'] : 0;
$totalCount   = isset($pag['total']) ? (int) $pag['total'] : 0;
$pgOffset     = isset($pag['offset']) ? (int) $pag['offset'] : 0;
$pgCurrent    = isset($pag['current_page']) ? (int) $pag['current_page'] : 1;
$pgPages      = isset($pag['total_pages']) ? (int) $pag['total_pages'] : 1;
$devise       = $cashbox ? $cashbox->devise : 'BIF';

/* Statut du solde */
$statusLabel = 'Normal';
$statusClass = 'cash-status-active';
if ($threshold > 0 && $balance <= $threshold) {
    $statusLabel = 'Critique';
    $statusClass = 'cash-status-danger';
} elseif ($threshold > 0 && $balance <= ($threshold * 2)) {
    $statusLabel = 'Faible';
    $statusClass = 'cash-status-warning';
}

$isPrincipal = ($role === 'principale');
$windowStart = max(1, $pgCurrent - 2);
$windowEnd   = min($pgPages, $windowStart + 4);
$windowStart = max(1, $windowEnd - 4);

/* ID sûr pour les liens (évite l'avertissement Intelephense) */
$cashboxId = ($cashbox !== null) ? (int) $cashbox->id : 0;
?>
<style>
    :root {
        --caisse-primary: #0f766e;
        --caisse-secondary: #102033;
        --caisse-border: #e2e8f0;
        --caisse-muted: #64748b;
    }

    .content-wrapper {
        background: #f4f7f6;
    }

    .caisse-page {
        font-family: "Segoe UI", Arial, sans-serif;
        color: #334155;
    }

    .caisse-hero {
        position: relative;
        overflow: hidden;
        margin-bottom: 22px;
        padding: 24px 26px;
        color: #fff;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(15, 118, 110, .98), rgba(16, 32, 51, .98));
        box-shadow: 0 10px 30px rgba(15, 118, 110, .18);
    }

    .caisse-hero-content {
        position: relative;
        z-index: 2;
    }

    .caisse-hero-title {
        display: flex;
        align-items: center;
        margin-bottom: 7px;
        font-size: 24px;
        font-weight: 800;
    }

    .caisse-hero-title-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        margin-right: 13px;
        border-radius: 13px;
        background: rgba(255, 255, 255, .16);
    }

    .caisse-hero p {
        max-width: 760px;
        margin: 0;
        color: rgba(255, 255, 255, .85);
        font-size: 13px;
    }

    .caisse-date-box {
        min-width: 220px;
        padding: 12px 15px;
        text-align: right;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 12px;
        background: rgba(255, 255, 255, .10);
    }

    .caisse-date-box small {
        display: block;
        margin-bottom: 3px;
        color: rgba(255, 255, 255, .75);
    }

    .caisse-date-box strong {
        font-size: 16px;
        font-weight: 800;
    }

    .role-badge {
        padding: 6px 11px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .role-principale {
        color: #6d28d9;
        background: #ede9fe;
    }

    .role-secondaire {
        color: #0369a1;
        background: #e0f2fe;
    }

    .cash-status {
        padding: 5px 9px;
        border-radius: 30px;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .cash-status-active {
        color: #15803d;
        background: #dcfce7;
    }

    .cash-status-warning {
        color: #b45309;
        background: #fef3c7;
    }

    .cash-status-danger {
        color: #b91c1c;
        background: #fee2e2;
    }

    .btn-caisse-primary,
    .btn-caisse-outline {
        min-height: 40px;
        padding: 9px 15px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .btn-caisse-primary {
        color: #fff;
        border: 1px solid var(--caisse-primary);
        background: var(--caisse-primary);
    }

    .btn-caisse-primary:hover {
        color: #fff;
        background: var(--caisse-primary);
        transform: translateY(-1px);
    }

    .btn-caisse-outline {
        color: var(--caisse-primary);
        border: 1px solid #b8d8d4;
        background: #fff;
    }

    .btn-caisse-outline:hover {
        color: #fff;
        border-color: var(--caisse-primary);
        background: var(--caisse-primary);
    }

    .caisse-stat-card {
        position: relative;
        overflow: hidden;
        min-height: 140px;
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid var(--caisse-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 7px 25px rgba(15, 23, 42, .06);
    }

    .caisse-stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .caisse-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 13px;
        font-size: 18px;
    }

    .icon-green {
        color: #15803d;
        background: #dcfce7;
    }

    .icon-blue {
        color: #0369a1;
        background: #e0f2fe;
    }

    .icon-orange {
        color: #b45309;
        background: #fef3c7;
    }

    .icon-red {
        color: #b91c1c;
        background: #fee2e2;
    }

    .icon-purple {
        color: #6d28d9;
        background: #ede9fe;
    }

    .icon-grey {
        color: #475569;
        background: #e2e8f0;
    }

    .caisse-stat-badge {
        padding: 5px 9px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 800;
    }

    .badge-positive {
        color: #15803d;
        background: #dcfce7;
    }

    .badge-neutral {
        color: #0369a1;
        background: #e0f2fe;
    }

    .badge-negative {
        color: #b91c1c;
        background: #fee2e2;
    }

    .caisse-stat-label {
        margin-bottom: 5px;
        color: var(--caisse-muted);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .caisse-stat-value {
        margin-bottom: 4px;
        color: var(--caisse-secondary);
        font-size: 21px;
        font-weight: 800;
    }

    .caisse-stat-footer {
        color: var(--caisse-muted);
        font-size: 11px;
    }

    .caisse-card {
        margin-bottom: 22px;
        border: 1px solid var(--caisse-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 7px 24px rgba(15, 23, 42, .05);
    }

    .caisse-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 64px;
        padding: 15px 20px;
        border-bottom: 1px solid #edf2f7;
    }

    .caisse-card-title {
        display: flex;
        align-items: center;
        margin: 0;
        color: var(--caisse-secondary);
        font-size: 15px;
        font-weight: 800;
    }

    .caisse-card-title i {
        margin-right: 9px;
        color: var(--caisse-primary);
    }

    .caisse-card-subtitle {
        display: block;
        margin-top: 3px;
        color: var(--caisse-muted);
        font-size: 11px;
    }

    .caisse-filter-box {
        margin-bottom: 22px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #fff;
    }

    .caisse-filter-box label {
        display: block;
        margin-bottom: 6px;
        color: #475569;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .caisse-filter-box .form-control {
        min-height: 40px;
        border: 1px solid #dbe4ea;
        border-radius: 8px;
        font-size: 11px;
    }

    .caisse-filter-box .form-control:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 .15rem rgba(15, 118, 110, .13);
    }

    .caisse-table {
        width: 100%;
        margin-bottom: 0;
    }

    .caisse-table thead th {
        padding: 12px 10px;
        color: #475569;
        border-bottom: 1px solid #dfe7ed;
        background: #f8fafc;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .caisse-table tbody td {
        padding: 12px 10px;
        vertical-align: middle;
        border-top: 1px solid #edf2f7;
        color: #475569;
        font-size: 11px;
    }

    .caisse-table tbody tr:hover {
        background: #f8fffd;
    }

    .operation-reference {
        color: var(--caisse-secondary);
        font-weight: 800;
    }

    .operation-label {
        max-width: 260px;
    }

    .operation-label strong {
        display: block;
        margin-bottom: 2px;
        color: var(--caisse-secondary);
        font-size: 11px;
    }

    .operation-label small {
        color: var(--caisse-muted);
        font-size: 9px;
    }

    .amount-in {
        color: #15803d;
        font-weight: 800;
        white-space: nowrap;
    }

    .amount-out {
        color: #b91c1c;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-operation {
        display: inline-flex;
        align-items: center;
        padding: 5px 8px;
        border-radius: 30px;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-entree {
        color: #15803d;
        background: #dcfce7;
    }

    .badge-sortie {
        color: #b91c1c;
        background: #fee2e2;
    }

    .badge-transfert {
        color: #0369a1;
        background: #e0f2fe;
    }

    .badge-initial {
        color: #475569;
        background: #e2e8f0;
    }

    .btn-table-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 31px;
        height: 31px;
        margin: 1px;
        border: 1px solid #dbe4ea;
        border-radius: 8px;
        background: #fff;
        font-size: 11px;
    }

    .btn-table-view {
        color: #0369a1;
    }

    .btn-table-print {
        color: #475569;
    }

    .livre-totals-row td {
        padding: 14px 10px;
        border-top: 2px solid #dfe7ed;
        background: #f8fafc;
        font-size: 12px;
        font-weight: 800;
        color: var(--caisse-secondary);
    }

    .livre-pagination .page-item .page-link {
        margin: 0 3px;
        padding: 7px 12px;
        color: var(--caisse-primary);
        border: 1px solid #dbe4ea;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
    }

    .livre-pagination .page-item.active .page-link {
        color: #fff;
        border-color: var(--caisse-primary);
        background: var(--caisse-primary);
    }

    .livre-pagination .page-item.disabled .page-link {
        color: #cbd5e1;
        background: #f8fafc;
    }

    .livre-print-header {
        display: none;
    }

    @media print {

        .main-sidebar,
        .main-header,
        .main-footer,
        .content-header,
        .caisse-filter-box,
        .livre-no-print {
            display: none !important;
        }

        .content-wrapper {
            margin-left: 0 !important;
            background: #fff !important;
        }

        .caisse-card {
            border: none !important;
            box-shadow: none !important;
        }

        .livre-print-header {
            display: block;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0f766e;
        }

        .livre-print-header h2 {
            margin: 0 0 4px;
            color: #102033;
            font-size: 18px;
            font-weight: 800;
        }

        .livre-print-header p {
            margin: 2px 0;
            color: #475569;
            font-size: 11px;
        }
    }

    @media (max-width:767px) {
        .caisse-hero {
            padding: 20px;
        }

        .caisse-date-box {
            margin-top: 15px;
            text-align: left;
        }

        .caisse-card-header {
            display: block;
        }
    }
</style>

<div class="content-wrapper caisse-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('caisse') ?>">Caisse</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="caisse-hero">
                <div class="caisse-hero-content">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-8">
                            <div class="caisse-hero-title">
                                <span class="caisse-hero-title-icon">
                                    <i class="<?= $isPrincipal ? 'fas fa-crown' : 'fas fa-hard-hat' ?>"></i>
                                </span>
                                Livre de caisse — <?= html_escape($cashbox ? $cashbox->name : '') ?>
                            </div>
                            <p>
                                <?php if ($isPrincipal): ?>
                                    Caisse principale : encaisse tous les fonds et approvisionne
                                    la caisse secondaire. Chaque mouvement entrée/sortie est consigné ici.
                                <?php else: ?>
                                    Caisse secondaire : reçoit les approvisionnements de la caisse
                                    principale et paie les demandes d'achat de tous les chantiers.
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4 d-flex justify-content-md-end">
                            <div class="caisse-date-box">
                                <small>
                                    <span
                                        class="role-badge <?= $isPrincipal ? 'role-principale' : 'role-secondaire' ?>">
                                        <?= $isPrincipal ? 'Principale' : 'Secondaire' ?>
                                    </span>
                                    <span class="cash-status <?= $statusClass ?> ml-1"><?= $statusLabel ?></span>
                                </small>
                                <strong><?= formatCashboxAmount($balance) ?> <?= html_escape($devise) ?></strong>
                                <small><?= html_escape($cashbox ? $cashbox->code : '') ?> · Resp. :
                                    <?= html_escape($cashbox && !empty($cashbox->responsable) ? $cashbox->responsable : '—') ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="livre-print-header">
                <h2>SATRACO Construction — Livre de caisse</h2>
                <p><strong>Caisse :</strong> <?= html_escape($cashbox ? $cashbox->name : '') ?>
                    (<?= html_escape($cashbox ? $cashbox->code : '') ?>) —
                    <strong>Rôle :</strong> <?= $isPrincipal ? 'Principale' : 'Secondaire' ?> —
                    <strong>Édité le :</strong> <?= date('d/m/Y H:i') ?>
                </p>
            </div>

            <!-- ============ STATISTIQUES ============ -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-grey"><i class="fas fa-flag"></i></div>
                        </div>
                        <div class="caisse-stat-label">Solde initial</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($opening) ?> <?= html_escape($devise) ?>
                        </div>
                        <div class="caisse-stat-footer">À la création de la caisse</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-green"><i class="fas fa-arrow-down"></i></div>
                            <span class="caisse-stat-badge badge-positive"><?= $countIn ?>
                                entrée<?= $countIn > 1 ? 's' : '' ?></span>
                        </div>
                        <div class="caisse-stat-label">Total entrées (période)</div>
                        <div class="caisse-stat-value amount-in">+ <?= formatCashboxAmount($totalIn) ?></div>
                        <div class="caisse-stat-footer">
                            <?= $isPrincipal ? 'Encaissements + solde initial' : 'Approvisionnements reçus' ?></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-red"><i class="fas fa-arrow-up"></i></div>
                            <span class="caisse-stat-badge badge-negative"><?= $countOut ?>
                                sortie<?= $countOut > 1 ? 's' : '' ?></span>
                        </div>
                        <div class="caisse-stat-label">Total sorties (période)</div>
                        <div class="caisse-stat-value amount-out">- <?= formatCashboxAmount($totalOut) ?></div>
                        <div class="caisse-stat-footer">
                            <?= $isPrincipal ? 'Approvisionnements vers secondaire' : 'Paiements des DA' ?></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-purple"><i class="fas fa-wallet"></i></div>
                            <span class="cash-status <?= $statusClass ?>"><?= $statusLabel ?></span>
                        </div>
                        <div class="caisse-stat-label">Solde actuel</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($balance) ?> <?= html_escape($devise) ?>
                        </div>
                        <div class="caisse-stat-footer">Seuil d'alerte : <?= formatCashboxAmount($threshold) ?></div>
                    </div>
                </div>
            </div>

            <!-- ============ FILTRES ============ -->
            <div class="caisse-filter-box livre-no-print">
                <form action="<?= current_url() ?>" method="get">
                    <div class="row align-items-end">
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Rechercher dans le livre</label>
                                <input type="text" name="livre_search" class="form-control"
                                    value="<?= html_escape(isset($livreSearch) ? $livreSearch : '') ?>"
                                    placeholder="Référence, libellé, tiers, bon..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Du</label>
                                <input type="date" name="livre_date_from" class="form-control"
                                    value="<?= html_escape(isset($livreDateFrom) ? $livreDateFrom : '') ?>">
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Au</label>
                                <input type="date" name="livre_date_to" class="form-control"
                                    value="<?= html_escape(isset($livreDateTo) ? $livreDateTo : '') ?>">
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="d-flex">
                                <button type="submit" class="btn btn-caisse-primary mr-1 w-100">
                                    <i class="fas fa-filter mr-1"></i> Filtrer
                                </button>
                                <a href="<?= current_url() ?>" class="btn btn-caisse-outline" title="Réinitialiser">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ============ LIVRE ============ -->
            <div class="caisse-card">
                <div class="caisse-card-header">
                    <div>
                        <h5 class="caisse-card-title"><i class="fas fa-book"></i>
                            Mouvements de la caisse <?= $isPrincipal ? 'principale' : 'secondaire' ?></h5>
                        <span class="caisse-card-subtitle">Registre chronologique des entrées et sorties.</span>
                    </div>
                    <div class="livre-no-print">
                        <a href="<?= base_url('caisse') ?>" class="btn btn-caisse-outline mr-1">
                            <i class="fas fa-arrow-left mr-1"></i> Retour
                        </a>
                        <a href="<?= base_url('finance-cashbox-print/' . $cashboxId) ?>" target="_blank"
                            class="btn btn-caisse-primary">
                            <i class="fas fa-print mr-1"></i> Imprimer
                        </a>
                    </div>
                </div>

                <?php
                $principalBox = isset($principalCashbox) && is_object($principalCashbox) ? $principalCashbox : null;
                $secondaryBox = isset($secondaryCashbox) && is_object($secondaryCashbox) ? $secondaryCashbox : null;
                $colspanTotal = $isPrincipal ? 9 : 10;
                ?>
                <div class="table-responsive">
                    <table class="table caisse-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th class="text-right">Entrée</th>
                                <th>Source de fonds</th>
                                <?php if ($isPrincipal): ?>
                                    <th class="text-right">Montant décaissé (BIF)</th>
                                <?php else: ?>
                                    <th class="text-right">Sortie de la caisse</th>
                                <?php endif; ?>
                                <th class="text-right">Solde restant</th>
                                <?php if (!$isPrincipal): ?>
                                    <th>Libellé / Tiers</th>
                                <?php endif; ?>
                                <th>Destination</th>
                                <th>Statut</th>
                                <th class="text-center livre-no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($movements)): ?>
                                <?php foreach ($movements as $index => $m): ?>
                                    <?php
                                    $isIn   = ($m->sens === 'entree');
                                    $amount = (float) $m->amount;

                                    /* ---------- Statut ---------- */
                                    $statusLabel = 'Validé';
                                    $statusClass = 'badge-success';
                                    if ($m->status === 'pending') {
                                        $statusLabel = 'En attente';
                                        $statusClass = 'badge-warning';
                                    } elseif ($m->status === 'cancelled') {
                                        $statusLabel = 'Annulé';
                                        $statusClass = 'badge-danger';
                                    }

                                    /* ---------- SOURCE DE FONDS / LIBELLÉ / DESTINATION ---------- */
                                    $sourceFonds  = '—';
                                    $libelleTiers = '';
                                    $destination  = '—';

                                    if ($isPrincipal) {
                                        /* ===== CAISSE PRINCIPALE ===== */
                                        if ($m->nature === 'encaissement') {
                                            /* Entrée : la source = provenance / tiers */
                                            $sourceFonds = !empty($m->third_party)
                                                ? $m->third_party
                                                : (!empty($m->label) ? $m->label : '—');
                                            $destination = '—';
                                        } elseif ($m->nature === 'solde_initial') {
                                            $sourceFonds = 'Solde initial';
                                            $destination = '—';
                                        } else {
                                            /* ===== APPROVISIONNEMENT (sortie de fonds) =====
                                            - SOURCE DE FONDS  → tiret
                                            - DESTINATION      → libellé + caisse secondaire */
                                            $sourceFonds = '—';

                                            $destination = !empty($m->label)
                                                ? $m->label
                                                : 'Approvisionnement de la caisse secondaire';

                                            if ($secondaryBox) {
                                                $destination .= ' — ' . $secondaryBox->name . ' (' . $secondaryBox->code . ')';
                                            }
                                            if (!empty($m->transfer_reference)) {
                                                $destination .= ' · ' . $m->transfer_reference;
                                            }
                                        }
                                    } else {
                                        /* ===== CAISSE SECONDAIRE ===== */
                                        if ($m->nature === 'approvisionnement_recu') {
                                            /* Toutes les entrées viennent de la principale */
                                            $sourceFonds = $principalBox
                                                ? $principalBox->name . ' (' . $principalBox->code . ')'
                                                : 'Caisse principale';
                                            $libelleTiers = !empty($m->label) ? $m->label : 'Approvisionnement reçu';
                                            $destination  = !empty($m->transfer_reference) ? $m->transfer_reference : '—';
                                        } elseif ($m->nature === 'solde_initial') {
                                            $sourceFonds  = 'Solde initial';
                                            $libelleTiers = !empty($m->label) ? $m->label : 'Solde initial';
                                        } else { /* paiement_da */
                                            $sourceFonds  = '—';
                                            $libelleTiers = trim((!empty($m->label) ? $m->label : '')
                                                . (!empty($m->third_party) ? ' — ' . $m->third_party : ''));
                                            /* Destination = pièce liée (DA / document) */
                                            $destination = !empty($m->purchase_request_reference)
                                                ? $m->purchase_request_reference
                                                : (!empty($m->document_number) ? $m->document_number : '—');
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $pgOffset + $index + 1 ?></td>
                                        <td>
                                            <?= formatCashboxDate($m->movement_date) ?>
                                            <small class="d-block text-muted"><?= formatCashboxTime($m->created_at) ?></small>
                                        </td>
                                        <!-- ENTRÉE -->
                                        <td class="text-right <?= $isIn ? 'amount-in' : 'text-muted' ?>">
                                            <?= $isIn ? '+ ' . formatCashboxAmount($amount) : '—' ?>
                                        </td>
                                        <!-- SOURCE DE FONDS -->
                                        <td><?= html_escape($sourceFonds) ?></td>
                                        <!-- MONTANT DÉCAISSÉ (principale) / SORTIE (secondaire) -->
                                        <td class="text-right <?= !$isIn ? 'amount-out' : 'text-muted' ?>">
                                            <?= !$isIn ? '- ' . formatCashboxAmount($amount) : '—' ?>
                                        </td>
                                        <!-- SOLDE RESTANT -->
                                        <td class="text-right">
                                            <strong><?= formatCashboxAmount($m->balance_after) ?></strong>
                                            <small class="d-block text-muted"><?= html_escape($m->devise) ?></small>
                                        </td>
                                        <?php if (!$isPrincipal): ?>
                                            <!-- LIBELLÉ / TIERS -->
                                            <td class="operation-label">
                                                <strong><?= html_escape($libelleTiers) ?></strong>
                                                <?php if (!empty($m->category)): ?>
                                                    <small>Catégorie : <?= html_escape($m->category) ?></small>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                        <!-- DESTINATION -->
                                        <td><?= html_escape($destination) ?></td>
                                        <!-- STATUT -->
                                        <td><span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                                        <!-- ACTIONS -->
                                        <td class="text-center livre-no-print">
                                            <button class="btn-table-action btn-table-view" title="Voir"
                                                onclick='viewLivreMovement(this)'
                                                data-reference="<?= html_escape($m->reference) ?>"
                                                data-date="<?= formatCashboxDate($m->movement_date) ?>"
                                                data-type="<?= html_escape($m->nature) ?>"
                                                data-label="<?= html_escape($m->label) ?>"
                                                data-third="<?= html_escape(!empty($m->third_party) ? $m->third_party : $sourceFonds) ?>"
                                                data-piece="<?= html_escape($destination) ?>"
                                                data-amount="<?= html_escape(($isIn ? '+ ' : '- ') . formatCashboxAmount($amount) . ' ' . $m->devise) ?>"
                                                data-flow="<?= $isIn ? 'in' : 'out' ?>"
                                                data-balance="<?= html_escape(formatCashboxAmount($m->balance_after) . ' ' . $m->devise) ?>"
                                                data-status="<?= $statusLabel ?>" data-status-class="<?= $statusClass ?>"
                                                data-observation="<?= html_escape(!empty($m->observation) ? $m->observation : '—') ?>">
                                                <i class="fas fa-eye"></i></button>
                                            <button class="btn-table-action btn-table-print" title="Imprimer"
                                                onclick="window.print()">
                                                <i class="fas fa-print"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!-- TOTAUX -->
                                <tr class="livre-totals-row">
                                    <td colspan="2">
                                        <i class="fas fa-sigma mr-1" style="color:#0f766e;"></i>
                                        Totaux (<?= $totalCount ?> mouvement<?= $totalCount > 1 ? 's' : '' ?>)
                                    </td>
                                    <td class="text-right amount-in">+ <?= formatCashboxAmount($totalIn) ?></td>
                                    <td></td>
                                    <td class="text-right amount-out">- <?= formatCashboxAmount($totalOut) ?></td>
                                    <td class="text-right"
                                        style="color:<?= ($totalIn - $totalOut) >= 0 ? '#15803d' : '#b91c1c' ?>;">
                                        <?= ($totalIn - $totalOut) >= 0 ? '+ ' : '- ' ?><?= formatCashboxAmount(abs($totalIn - $totalOut)) ?>
                                        <small class="d-block text-muted">Flux net</small>
                                    </td>
                                    <td colspan="<?= $isPrincipal ? 3 : 4 ?>"></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= $colspanTotal ?>" class="text-center py-5">
                                        <div class="mb-3" style="color:#cbd5e1; font-size:42px;"><i class="fas fa-book"></i>
                                        </div>
                                        <h6 style="color:#334155; font-weight:800;">Aucun mouvement dans ce livre</h6>
                                        <p class="text-muted mb-0">Modifiez la période ou enregistrez une opération depuis
                                            la page Caisse.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap livre-no-print">
                    <small class="text-muted">
                        Affichage de <?= $totalCount > 0 ? $pgOffset + 1 : 0 ?> à <?= $pgOffset + count($movements) ?>
                        sur <?= $totalCount ?> mouvement<?= $totalCount > 1 ? 's' : '' ?>
                    </small>
                    <?php if ($pgPages > 1): ?>
                        <nav>
                            <ul class="pagination livre-pagination mb-0">
                                <li class="page-item <?= $pgCurrent <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= $pgCurrent > 1 ? livrePageUrl($pgCurrent - 1) : '#' ?>">
                                        <i class="fas fa-chevron-left"></i></a>
                                </li>
                                <?php for ($p = $windowStart; $p <= $windowEnd; $p++): ?>
                                    <li class="page-item <?= $p === $pgCurrent ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= livrePageUrl($p) ?>"><?= $p ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?= $pgCurrent >= $pgPages ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="<?= $pgCurrent < $pgPages ? livrePageUrl($pgCurrent + 1) : '#' ?>">
                                        <i class="fas fa-chevron-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ============ MODALE DÉTAILS ============ -->
<div class="modal fade" id="livreDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border:none; border-radius:15px; overflow:hidden;">
            <div class="modal-header"
                style="color:#fff; background:linear-gradient(135deg,#0f766e,#102033); border:none;">
                <h5 class="modal-title" style="font-weight:800;"><i class="fas fa-receipt mr-2"></i>
                    <span id="lmReference"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal"
                    style="color:#fff;"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="lmAmountBox" style="padding:12px 15px; border-radius:10px; margin-bottom:14px;">
                    <small style="text-transform:uppercase; font-weight:800;">Montant</small>
                    <strong id="lmAmount" style="display:block; font-size:18px;"></strong>
                </div>
                <div class="row" style="font-size:12px;">
                    <div class="col-6 mb-2"><small class="text-muted">Date</small><br><strong id="lmDate"></strong>
                    </div>
                    <div class="col-6 mb-2"><small class="text-muted">Type</small><br><strong id="lmType"></strong>
                    </div>
                    <div class="col-12 mb-2"><small class="text-muted">Libellé</small><br><strong id="lmLabel"></strong>
                    </div>
                    <div class="col-6 mb-2"><small class="text-muted">Tiers</small><br><strong id="lmThird"></strong>
                    </div>
                    <div class="col-6 mb-2"><small class="text-muted">Pièce liée</small><br><strong
                            id="lmPiece"></strong></div>
                    <div class="col-6 mb-2"><small class="text-muted">Solde après</small><br><strong
                            id="lmBalance"></strong></div>
                    <div class="col-6 mb-2"><small class="text-muted">Statut</small><br><span id="lmStatus"
                            class="badge"></span></div>
                    <div class="col-12"><small class="text-muted">Observation</small><br><span
                            id="lmObservation"></span></div>
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #edf2f7;">
                <button type="button" class="btn btn-caisse-outline" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
    function viewLivreMovement(btn) {
        var d = btn.dataset;
        document.getElementById('lmReference').textContent = d.reference;
        document.getElementById('lmDate').textContent = d.date;
        document.getElementById('lmType').textContent = d.type;
        document.getElementById('lmLabel').textContent = d.label;
        document.getElementById('lmThird').textContent = d.third;
        document.getElementById('lmPiece').textContent = d.piece;
        document.getElementById('lmAmount').textContent = d.amount;
        document.getElementById('lmBalance').textContent = d.balance;
        document.getElementById('lmObservation').textContent = d.observation;
        var st = document.getElementById('lmStatus');
        st.textContent = d.status;
        st.className = 'badge ' + d.statusClass;
        var box = document.getElementById('lmAmountBox');
        box.style.background = (d.flow === 'in') ? '#f0fdf4' : '#fef2f2';
        box.style.border = '1px solid ' + ((d.flow === 'in') ? '#bbf7d0' : '#fecaca');
        document.getElementById('lmAmount').style.color = (d.flow === 'in') ? '#15803d' : '#b91c1c';
        $('#livreDetailModal').modal('show');
    }
</script>