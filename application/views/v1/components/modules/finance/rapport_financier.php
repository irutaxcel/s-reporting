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
        if (empty($date)) {
            return '—';
        }
        return date('d/m/Y', strtotime($date));
    }
}
?>
<!-- =========================================================
PAGE : RAPPORT FINANCIER
MODULE : DAF / FINANCE / TRESORERIE
========================================================== -->
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
        font-size: 25px;
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
        max-width: 780px;
        margin: 0;
        color: rgba(255, 255, 255, .85);
        font-size: 14px;
    }

    .caisse-date-box {
        min-width: 190px;
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
        font-size: 14px;
        font-weight: 700;
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
        min-height: 148px;
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid var(--caisse-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 7px 25px rgba(15, 23, 42, .06);
        transition: all .2s ease;
    }

    .caisse-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .10);
    }

    .caisse-stat-card::after {
        position: absolute;
        right: -32px;
        bottom: -35px;
        width: 110px;
        height: 110px;
        content: "";
        border-radius: 50%;
        background: rgba(15, 118, 110, .06);
    }

    .caisse-stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .caisse-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 13px;
        font-size: 19px;
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
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .caisse-stat-value {
        margin-bottom: 4px;
        color: var(--caisse-secondary);
        font-size: 22px;
        font-weight: 800;
        line-height: 1.2;
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

    .caisse-card-body {
        padding: 20px;
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
        max-width: 220px;
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

    .badge-situation {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 30px;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sit-retour {
        color: #15803d;
        background: #dcfce7;
    }

    .sit-supplement {
        color: #b45309;
        background: #fef3c7;
    }

    .sit-soldee {
        color: #0369a1;
        background: #e0f2fe;
    }

    .sit-attente {
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

    .btn-table-retour {
        color: #15803d;
    }

    .btn-table-suppl {
        color: #b45309;
    }

    .return-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        background: #f8fafc;
    }

    .return-item:last-child {
        margin-bottom: 0;
    }

    .return-item-icon {
        display: flex;
        flex: 0 0 36px;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        margin-right: 10px;
        border-radius: 9px;
    }

    .return-item h6 {
        margin: 0 0 3px;
        color: var(--caisse-secondary);
        font-size: 11px;
        font-weight: 800;
    }

    .return-item p {
        margin: 0;
        color: var(--caisse-muted);
        font-size: 10px;
    }

    .return-amount {
        margin-left: auto;
        text-align: right;
    }

    .return-amount strong {
        display: block;
        font-size: 12px;
        font-weight: 800;
    }

    .return-amount small {
        color: var(--caisse-muted);
        font-size: 9px;
    }

    .chart-wrapper {
        position: relative;
        width: 100%;
        height: 280px;
    }

    .modal-caisse .modal-content {
        overflow: hidden;
        border: none;
        border-radius: 15px;
        box-shadow: 0 20px 45px rgba(15, 23, 42, .20);
    }

    .modal-caisse .modal-header {
        color: #fff;
        border-bottom: none;
        background: linear-gradient(135deg, #0f766e, #102033);
    }

    .modal-caisse .modal-title {
        font-size: 16px;
        font-weight: 800;
    }

    .modal-caisse .close {
        color: #fff;
        opacity: .9;
    }

    .modal-caisse label {
        margin-bottom: 6px;
        color: #475569;
        font-size: 11px;
        font-weight: 800;
    }

    .modal-caisse .form-control {
        min-height: 42px;
        border: 1px solid #dbe4ea;
        border-radius: 8px;
        font-size: 12px;
    }

    .required-star {
        color: #dc2626;
    }

    .da-paid-box {
        margin-top: 8px;
        padding: 8px 12px;
        border: 1px solid #99d5ce;
        border-radius: 9px;
        background: #f0fdfa;
    }

    .da-paid-box small {
        display: block;
        color: #0f766e;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .da-paid-box strong {
        color: var(--caisse-secondary);
        font-size: 13px;
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

        .caisse-stat-value {
            font-size: 19px;
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
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================
         EN-TÊTE
    ====================================================== -->
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="caisse-hero">
                <div class="caisse-hero-content">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-8">
                            <div class="caisse-hero-title">
                                <span class="caisse-hero-title-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                                Rapport financier
                            </div>
                            <p>
                                Rapprochez chaque demande d'achat payée de sa dépense réelle :
                                enregistrez les <strong>retours à la caisse</strong> (fonds non utilisés
                                rendus) et les <strong>suppléments</strong> (compléments payés).
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4 d-flex justify-content-md-end">
                            <div class="caisse-date-box">
                                <small><i class="far fa-calendar-alt mr-1"></i> Situation au</small>
                                <strong><?= date('d/m/Y') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    $stats  = isset($reportStats) && is_array($reportStats) ? $reportStats : [];
    $rows   = isset($reportRows) && is_array($reportRows) ? $reportRows : [];
    $recent = isset($recentRegularisations) && is_array($recentRegularisations) ? $recentRegularisations : [];
    $counts = isset($situationCounts) && is_array($situationCounts) ? $situationCounts
        : ['soldee' => 0, 'retour' => 0, 'supplement' => 0, 'attente' => 0];
    $filters = isset($rapportFilters) && is_array($rapportFilters) ? $rapportFilters : [];

    $totalPaid   = isset($stats['total_paid']) ? (float) $stats['total_paid'] : 0;
    $paidCount   = isset($stats['paid_count']) ? (int) $stats['paid_count'] : 0;
    $totalRet    = isset($stats['total_retours']) ? (float) $stats['total_retours'] : 0;
    $retCount    = isset($stats['retours_count']) ? (int) $stats['retours_count'] : 0;
    $totalSup    = isset($stats['total_supplements']) ? (float) $stats['total_supplements'] : 0;
    $supCount    = isset($stats['supplements_count']) ? (int) $stats['supplements_count'] : 0;
    $adjusted    = isset($stats['adjusted']) ? (float) $stats['adjusted'] : 0;

    $situationMeta = [
        'retour'     => ['label' => 'Retour caisse',         'class' => 'sit-retour',     'icon' => 'fas fa-undo'],
        'supplement' => ['label' => 'Supplément payé',       'class' => 'sit-supplement', 'icon' => 'fas fa-plus-circle'],
        'soldee'     => ['label' => 'Soldée',                'class' => 'sit-soldee',     'icon' => 'fas fa-check'],
        'attente'    => ['label' => 'En attente de retour',  'class' => 'sit-attente',    'icon' => 'fas fa-hourglass-half'],
    ];

    $ecartNet = 0;
    foreach ($rows as $r) {
        $ecartNet += $r->ecart;
    }
    ?>

    <section class="content">
        <div class="container-fluid">

            <!-- =================================================
                STATISTIQUES (DYNAMIQUES)
            ================================================== -->
            <div class="row">
                <!-- TOTAL PAYÉ (BONS DE PAIEMENT) -->
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-blue"><i class="fas fa-hand-holding-usd"></i></div>
                            <span class="caisse-stat-badge badge-neutral">
                                <?= $paidCount ?> bon<?= $paidCount > 1 ? 's' : '' ?>
                            </span>
                        </div>
                        <div class="caisse-stat-label">Total payé (bons de paiement)</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($totalPaid) ?> BIF</div>
                        <div class="caisse-stat-footer">Décaissé par la caisse secondaire</div>
                    </div>
                </div>

                <!-- RETOURS À LA CAISSE -->
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-green"><i class="fas fa-undo"></i></div>
                            <span class="caisse-stat-badge badge-positive">
                                <?= $retCount ?> retour<?= $retCount > 1 ? 's' : '' ?>
                            </span>
                        </div>
                        <div class="caisse-stat-label">Retours à la caisse</div>
                        <div class="caisse-stat-value amount-in">+ <?= formatCashboxAmount($totalRet) ?> BIF</div>
                        <div class="caisse-stat-footer">Fonds non utilisés rendus</div>
                    </div>
                </div>

                <!-- SUPPLÉMENTS PAYÉS -->
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-orange"><i class="fas fa-plus-circle"></i></div>
                            <span class="caisse-stat-badge badge-negative">
                                <?= $supCount ?> supplément<?= $supCount > 1 ? 's' : '' ?>
                            </span>
                        </div>
                        <div class="caisse-stat-label">Suppléments payés</div>
                        <div class="caisse-stat-value amount-out">- <?= formatCashboxAmount($totalSup) ?> BIF</div>
                        <div class="caisse-stat-footer">Compléments sur demandes</div>
                    </div>
                </div>

                <!-- DÉPENSE RÉELLE AJUSTÉE -->
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-purple"><i class="fas fa-balance-scale"></i></div>
                            <span class="caisse-stat-badge badge-neutral">Net</span>
                        </div>
                        <div class="caisse-stat-label">Dépense réelle ajustée</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($adjusted) ?> BIF</div>
                        <div class="caisse-stat-footer">Payé − retours + suppléments</div>
                    </div>
                </div>
            </div>

            <!-- =================================================
                FILTRES
            ================================================== -->
            <div class="caisse-filter-box">
                <form action="<?= current_url() ?>" method="get">
                    <div class="row align-items-end">
                        <!-- RECHERCHE -->
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Rechercher</label>
                                <div class="input-group">
                                    <input type="text" name="rapport_search" class="form-control"
                                        value="<?= html_escape(!empty($filters['search']) ? $filters['search'] : '') ?>"
                                        placeholder="N° DA, bon de paiement, chantier, bénéficiaire..."
                                        autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text" title="Rechercher"
                                            style="border-radius:0 8px 8px 0; cursor:pointer;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SITUATION -->
                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Situation</label>
                                <select name="rapport_situation" class="form-control">
                                    <option value="">Toutes</option>
                                    <option value="retour"
                                        <?= (!empty($filters['situation']) && $filters['situation'] === 'retour') ? 'selected' : '' ?>>
                                        Retour à la caisse
                                    </option>
                                    <option value="supplement"
                                        <?= (!empty($filters['situation']) && $filters['situation'] === 'supplement') ? 'selected' : '' ?>>
                                        Supplément
                                    </option>
                                    <option value="soldee"
                                        <?= (!empty($filters['situation']) && $filters['situation'] === 'soldee') ? 'selected' : '' ?>>
                                        Soldée
                                    </option>
                                    <option value="attente"
                                        <?= (!empty($filters['situation']) && $filters['situation'] === 'attente') ? 'selected' : '' ?>>
                                        En attente de retour
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- DU -->
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Du</label>
                                <input type="date" name="rapport_date_from" class="form-control"
                                    value="<?= html_escape(!empty($filters['date_from']) ? $filters['date_from'] : '') ?>">
                            </div>
                        </div>

                        <!-- AU -->
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Au</label>
                                <input type="date" name="rapport_date_to" class="form-control"
                                    value="<?= html_escape(!empty($filters['date_to']) ? $filters['date_to'] : '') ?>">
                            </div>
                        </div>

                        <!-- ACTIONS -->
                        <div class="col-xl-1 col-lg-1 col-md-12">
                            <div class="d-flex">
                                <button type="submit" class="btn btn-caisse-primary w-100 mr-1"
                                    title="Appliquer les filtres">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <a href="<?= current_url() ?>" class="btn btn-caisse-outline" title="Réinitialiser">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- =================================================
                 TABLEAU DE RAPPROCHEMENT
            ================================================== -->
            <div class="caisse-card">
                <div class="caisse-card-header">
                    <div>
                        <h5 class="caisse-card-title"><i class="fas fa-receipt"></i> Rapprochement des demandes d'achat
                        </h5>
                        <span class="caisse-card-subtitle">Bon de paiement vs dépense réelle — retours et
                            suppléments.</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-caisse-primary mr-1" data-toggle="modal"
                            data-target="#addRetourModal">
                            <i class="fas fa-plus mr-1"></i> Retour / Supplément
                        </button>
                        <a href="<?= base_url('finance-rapport-financier-print') ?>" target="_blank"
                            class="btn btn-caisse-outline mr-1">
                            <i class="fas fa-print mr-1"></i> Imprimer
                        </a>
                        <a href="#" class="btn btn-caisse-outline"><i class="fas fa-file-excel mr-1"></i> Exporter</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table caisse-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>DA / Bon de paiement</th>
                                <th>Date paiement</th>
                                <th>Chantier / Objet</th>
                                <th>Bénéficiaire</th>
                                <th class="text-right">Montant payé</th>
                                <th class="text-right">Dépense réelle</th>
                                <th class="text-right">Écart</th>
                                <th>Situation</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rows)): ?>
                                <?php foreach ($rows as $index => $row): ?>
                                    <?php
                                    $meta     = $situationMeta[$row->situation];
                                    $year     = date('Y', strtotime(!empty($row->request_date) ? $row->request_date : $row->created_at));
                                    $daRef    = 'DA-' . $year . '-' . str_pad((int) $row->id, 4, '0', STR_PAD_LEFT);
                                    $chantier = !empty($row->chantier_name) ? $row->chantier_name : $row->destination_chantier;
                                    $benef    = !empty($row->buyer_name) ? $row->buyer_name : $row->requested_by;
                                    $isAttente = ($row->situation === 'attente');
                                    ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <span class="operation-reference"><?= html_escape($daRef) ?></span>
                                            <small class="d-block text-muted"><?= html_escape($row->payment_number) ?></small>
                                        </td>
                                        <td><?= formatCashboxDate($row->payment_date) ?></td>
                                        <td class="operation-label">
                                            <strong><?= html_escape($row->summary) ?></strong>
                                            <small><?= html_escape($chantier) ?></small>
                                        </td>
                                        <td><?= html_escape($benef) ?></td>
                                        <td class="text-right"><strong><?= formatCashboxAmount($row->amount_paid) ?></strong>
                                        </td>
                                        <td class="text-right <?= $isAttente ? 'text-muted' : '' ?>">
                                            <?= $isAttente ? '—' : formatCashboxAmount($row->real_expense) ?>
                                        </td>
                                        <td
                                            class="text-right <?= $row->ecart > 0 ? 'amount-in' : ($row->ecart < 0 ? 'amount-out' : 'text-muted') ?>">
                                            <?php if ($isAttente): ?>
                                                —
                                            <?php elseif ($row->ecart > 0): ?>
                                                + <?= formatCashboxAmount($row->ecart) ?>
                                            <?php elseif ($row->ecart < 0): ?>
                                                - <?= formatCashboxAmount(abs($row->ecart)) ?>
                                            <?php else: ?>
                                                0
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge-situation <?= $meta['class'] ?>">
                                                <i class="<?= $meta['icon'] ?> mr-1"></i> <?= $meta['label'] ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($isAttente): ?>
                                                <button class="btn-table-action btn-table-retour"
                                                    title="Enregistrer un retour / supplément" data-toggle="modal"
                                                    data-target="#addRetourModal" onclick="preselectRequest(<?= (int) $row->id ?>)">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button class="btn-table-action btn-table-view" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="mb-3" style="color:#cbd5e1; font-size:42px;"><i
                                                class="fas fa-receipt"></i></div>
                                        <h6 style="color:#334155; font-weight:800;">Aucune demande rapprochée</h6>
                                        <p class="text-muted mb-0">
                                            Modifiez les filtres ou effectuez d'abord des paiements de demandes d'achat.
                                        </p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap">
                    <small class="text-muted">
                        Affichage de <?= !empty($rows) ? 1 : 0 ?> à <?= count($rows) ?>
                        sur <?= count($rows) ?> demande<?= count($rows) > 1 ? 's' : '' ?>
                        rapprochée<?= count($rows) > 1 ? 's' : '' ?>
                    </small>
                    <small class="text-muted">
                        Écart net :
                        <strong class="<?= $ecartNet >= 0 ? 'amount-in' : 'amount-out' ?>">
                            <?= $ecartNet >= 0 ? '+ ' : '- ' ?><?= formatCashboxAmount(abs($ecartNet)) ?> BIF
                        </strong>
                        <?= $ecartNet >= 0 ? 'en faveur de la caisse' : 'en défaveur de la caisse' ?>
                    </small>
                </div>
            </div>

            <script>
                function preselectRequest(id) {
                    var select = document.getElementById('retourDaSelect');
                    if (!select) {
                        return;
                    }
                    select.value = String(id);
                    select.dispatchEvent(new Event('change')); /* affiche le montant payé (bon) */
                }
            </script>

            <?php $totalRequests = array_sum($counts); ?>
            <!-- =================================================
                RÉPARTITION + DERNIERS RETOURS / SUPPLÉMENTS
            ================================================== -->
            <div class="row">
                <!-- ============ SITUATION DES DEMANDES (DONUT) ============ -->
                <div class="col-xl-5 col-lg-5">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-chart-pie"></i> Situation des demandes
                                </h5>
                                <span class="caisse-card-subtitle">
                                    Répartition des <?= $totalRequests ?> demande<?= $totalRequests > 1 ? 's' : '' ?>
                                    rapprochée<?= $totalRequests > 1 ? 's' : '' ?>.
                                </span>
                            </div>
                        </div>
                        <div class="caisse-card-body">
                            <?php if ($totalRequests > 0): ?>
                                <div class="chart-wrapper"><canvas id="situationChart"></canvas></div>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <div class="mb-3" style="color:#cbd5e1; font-size:40px;"><i
                                            class="fas fa-chart-pie"></i></div>
                                    <h6 style="color:#334155; font-weight:800;">Aucune demande rapprochée</h6>
                                    <p class="text-muted mb-0">Les demandes payées apparaîtront ici.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- ============ DERNIERS RETOURS & SUPPLÉMENTS ============ -->
                <div class="col-xl-7 col-lg-7">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-history"></i> Derniers retours &
                                    suppléments</h5>
                                <span class="caisse-card-subtitle">Mouvements de régularisation enregistrés.</span>
                            </div>
                            <span class="badge badge-success">
                                <?= count($recent) ?> régularisation<?= count($recent) > 1 ? 's' : '' ?>
                            </span>
                        </div>
                        <div class="caisse-card-body">
                            <?php if (!empty($recent)): ?>
                                <?php foreach ($recent as $reg): ?>
                                    <?php
                                    /* Apparence selon le type */
                                    if ($reg->regularisation_type === 'retour') {
                                        $icon = 'fas fa-undo';
                                        $color = '#15803d';
                                        $bg = '#dcfce7';
                                        $title = 'Retour à la caisse';
                                        $amountHtml = '<strong class="amount-in">+ ' . formatCashboxAmount($reg->amount) . ' BIF</strong>';
                                    } elseif ($reg->regularisation_type === 'supplement') {
                                        $icon = 'fas fa-plus-circle';
                                        $color = '#b45309';
                                        $bg = '#fef3c7';
                                        $title = 'Supplément payé';
                                        $amountHtml = '<strong class="amount-out">- ' . formatCashboxAmount($reg->amount) . ' BIF</strong>';
                                    } else {
                                        $icon = 'fas fa-check';
                                        $color = '#0369a1';
                                        $bg = '#e0f2fe';
                                        $title = 'Demande soldée';
                                        $amountHtml = '<strong>0 BIF</strong>';
                                    }

                                    /* Référence DA + chantier */
                                    $daYear = date('Y', strtotime(!empty($reg->request_date) ? $reg->request_date : $reg->created_at));
                                    $daRef  = 'DA-' . $daYear . '-' . str_pad((int) $reg->purchase_request_id, 4, '0', STR_PAD_LEFT);
                                    $chantier = !empty($reg->chantier_name) ? $reg->chantier_name
                                        : (!empty($reg->destination_chantier) ? $reg->destination_chantier : '');
                                    ?>
                                    <div class="return-item">
                                        <div class="return-item-icon" style="color:<?= $color ?>; background:<?= $bg ?>;">
                                            <i class="<?= $icon ?>"></i>
                                        </div>
                                        <div>
                                            <h6>
                                                <?= $title ?> — <?= html_escape($daRef) ?>
                                                <?= $chantier !== '' ? ' (' . html_escape($chantier) . ')' : '' ?>
                                            </h6>
                                            <p>
                                                <?= formatCashboxDate($reg->regularisation_date) ?>
                                                · <?= html_escape(!empty($reg->concerned) ? $reg->concerned : '—') ?>
                                                · <?= html_escape(!empty($reg->receipt_number)
                                                        ? 'Reçu n° ' . $reg->receipt_number
                                                        : $reg->justification) ?>
                                            </p>
                                        </div>
                                        <div class="return-amount">
                                            <?= $amountHtml ?>
                                            <small><?= html_escape($reg->reference) ?></small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <div class="mb-3" style="color:#cbd5e1; font-size:40px;"><i class="fas fa-history"></i>
                                    </div>
                                    <h6 style="color:#334155; font-weight:800;">Aucune régularisation enregistrée</h6>
                                    <p class="text-muted mb-0">
                                        Les retours à la caisse, suppléments et demandes soldées
                                        apparaîtront ici automatiquement.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- =========================================================
MODALE : ENREGISTRER UN RETOUR / SUPPLÉMENT
========================================================== -->
<div class="modal fade modal-caisse" id="addRetourModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="<?= base_url('finance-retour_caisse') ?>" method="post" style="width:100%;">
            <?php if ($this->config->item('csrf_protection')): ?>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                    value="<?= $this->security->get_csrf_hash() ?>">
            <?php endif; ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-balance-scale mr-2"></i> Retour à la caisse / Supplément
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Demande d'achat (bon de paiement effectué) <span
                                        class="required-star">*</span></label>
                                <select class="form-control" id="retourDaSelect" name="purchase_request_id" required>
                                    <option value="">Sélectionner la demande</option>
                                    <?php if (!empty($regularizableRequests)): ?>
                                        <?php foreach ($regularizableRequests as $request): ?>
                                            <?php
                                            /* Référence lisible : DA-AAAA-XXXX */
                                            $requestYear = date(
                                                'Y',
                                                strtotime(!empty($request->request_date) ? $request->request_date : $request->created_at)
                                            );
                                            $requestReference = 'DA-' . $requestYear . '-' . str_pad((int) $request->id, 4, '0', STR_PAD_LEFT);

                                            $chantierName = !empty($request->chantier_name)
                                                ? $request->chantier_name
                                                : (!empty($request->destination_chantier) ? $request->destination_chantier : 'Non affecté');

                                            $summary = !empty($request->summary)
                                                ? $request->summary
                                                : 'Dépense liée à la demande d’achat';
                                            ?>
                                            <option value="<?= (int) $request->id ?>"
                                                data-amount="<?= (float) $request->amount_paid ?>"
                                                data-reference="<?= html_escape($requestReference) ?>"
                                                data-voucher="<?= html_escape($request->payment_number) ?>"
                                                data-chantier="<?= html_escape($chantierName) ?>"
                                                data-summary="<?= html_escape($summary) ?>">
                                                <?= html_escape($requestReference) ?> —
                                                <?= html_escape($request->payment_number) ?> —
                                                <?= html_escape($chantierName) ?> —
                                                <?= number_format((float) $request->amount_paid, 0, ',', ' ') ?> BIF
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="da-paid-box" id="daPaidBox" style="display:none;">
                                    <small>Montant payé (bon)</small>
                                    <strong id="daPaidValue">0 BIF</strong>
                                </div>
                                <small class="text-muted">
                                    Seules les demandes dont le bon de paiement est
                                    <strong>effectué</strong> sont affichées.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type de régularisation <span class="required-star">*</span></label>
                                <select class="form-control" id="retourType" name="regularisation_type" required>
                                    <option value="">Sélectionner</option>
                                    <option value="retour">Retour à la caisse (fonds rendus)</option>
                                    <option value="supplement">Supplément (complément payé)</option>
                                    <option value="exact">Montant payé exact (demande soldée)</option>
                                </select>
                                <small class="text-muted" id="retourTypeNote"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Montant <span class="required-star">*</span></label>
                                <input type="number" name="amount" id="retourAmount" class="form-control" min="0"
                                    step="0.01" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date <span class="required-star">*</span></label>
                                <input type="date" name="regularisation_date" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Concerné</label>
                                <input type="text" name="concerned" class="form-control"
                                    placeholder="Qui rend / qui reçoit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>N° de reçu / pièce</label>
                                <input type="text" name="receipt_number" class="form-control"
                                    placeholder="Ex. R-2026-015">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Justification <span class="required-star">*</span></label>
                                <input type="text" name="justification" class="form-control"
                                    placeholder="Motif du retour / supplément" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label>Observation</label>
                                <textarea class="form-control" rows="2"
                                    placeholder="Informations complémentaires..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-caisse-outline" data-dismiss="modal"><i
                            class="fas fa-times mr-1"></i> Annuler</button>
                    <button type="submit" class="btn btn-caisse-primary"><i class="fas fa-save mr-1"></i>
                        Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Graphique + modale JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        /* ----- Donut des situations ----- */
        var el = document.getElementById('situationChart');
        if (el && typeof Chart !== 'undefined') {
            new Chart(el.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Soldées', 'Retours à la caisse', 'Suppléments', 'En attente'],
                    datasets: [{
                        data: [
                            <?= (int) $counts['soldee'] ?>,
                            <?= (int) $counts['retour'] ?>,
                            <?= (int) $counts['supplement'] ?>,
                            <?= (int) $counts['attente'] ?>
                        ],
                        backgroundColor: ['#0284c7', '#16a34a', '#f59e0b', '#94a3b8'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }

        /* ----- Affiche le montant payé de la DA sélectionnée ----- */
        var daSelect = document.getElementById('retourDaSelect');
        if (daSelect) {
            daSelect.addEventListener('change', function() {
                var option = this.options[this.selectedIndex];
                var box = document.getElementById('daPaidBox');
                if (!this.value) {
                    box.style.display = 'none';
                    return;
                }
                box.style.display = 'block';
                document.getElementById('daPaidValue').textContent =
                    new Intl.NumberFormat('fr-FR').format(parseFloat(option.dataset.amount || 0)) + ' BIF';
            });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if ($this->session->flashdata('success')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                html: <?= json_encode($this->session->flashdata('success')) ?>,
                confirmButtonText: 'D’accord',
                confirmButtonColor: '#0f766e'
            });
        });
    </script>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                html: <?= json_encode($this->session->flashdata('error')) ?>,
                confirmButtonText: 'Corriger',
                confirmButtonColor: '#dc2626'
            });
        });
    </script>
<?php endif; ?>


<script>
    /* =====================================================
     * COMPORTEMENT SELON LE TYPE DE RÉGULARISATION
     * ===================================================== */
    var typeSelect = document.getElementById('retourType');
    var amountInput = document.getElementById('retourAmount');
    var typeNote = document.getElementById('retourTypeNote');

    if (typeSelect && amountInput) {
        typeSelect.addEventListener('change', function() {
            var value = this.value;

            if (value === 'exact') {
                /* Montant payé exact : aucun mouvement de caisse */
                amountInput.value = 0;
                amountInput.readOnly = true;
                amountInput.required = false;
                if (typeNote) {
                    typeNote.textContent =
                        'Aucun mouvement de caisse : dépense réelle = montant payé. La demande sera marquée « Soldée ».';
                }
            } else {
                amountInput.value = '';
                amountInput.readOnly = false;
                amountInput.required = true;
                if (typeNote) {
                    typeNote.textContent = (value === 'retour') ?
                        'Fonds non utilisés rendus à la caisse secondaire.' :
                        ((value === 'supplement') ?
                            'Complément payé depuis la caisse secondaire.' :
                            '');
                }
            }
        });
    }
</script>