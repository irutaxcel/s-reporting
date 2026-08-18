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
PAGE : LIVRE DE CAISSE
MODULE : DAF / FINANCE / TRESORERIE
========================================================== -->
<style>
    :root {
        --caisse-primary: #0f766e;
        --caisse-primary-dark: #115e59;
        --caisse-secondary: #102033;
        --caisse-success: #16a34a;
        --caisse-warning: #f59e0b;
        --caisse-danger: #dc2626;
        --caisse-info: #0284c7;
        --caisse-light: #f8fafc;
        --caisse-border: #e2e8f0;
        --caisse-text: #334155;
        --caisse-muted: #64748b;
    }

    .content-wrapper {
        background: #f4f7f6;
    }

    .caisse-page {
        font-family: "Segoe UI", Arial, sans-serif;
        color: var(--caisse-text);
    }

    /* =====================================================
   EN-TÊTE
====================================================== */
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

    .caisse-hero::before {
        position: absolute;
        top: -80px;
        right: -50px;
        width: 220px;
        height: 220px;
        content: "";
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
    }

    .caisse-hero::after {
        position: absolute;
        right: 150px;
        bottom: -100px;
        width: 190px;
        height: 190px;
        content: "";
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
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
        max-width: 760px;
        margin: 0;
        color: rgba(255, 255, 255, .85);
        font-size: 14px;
    }

    .caisse-date-box {
        min-width: 260px;
        padding: 12px 15px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 12px;
        background: rgba(255, 255, 255, .10);
        backdrop-filter: blur(5px);
    }

    .caisse-date-box small {
        display: block;
        margin-bottom: 2px;
        color: rgba(255, 255, 255, .75);
        font-size: 10px;
    }

    .caisse-date-box strong {
        font-size: 13px;
        font-weight: 700;
    }

    .caisse-date-box .livre-box-line {
        margin-bottom: 8px;
    }

    .caisse-date-box .livre-box-line:last-child {
        margin-bottom: 0;
    }

    /* =====================================================
   BOUTONS
====================================================== */
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
        border-color: var(--caisse-primary-dark);
        background: var(--caisse-primary-dark);
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

    /* =====================================================
   CARTES KPI
====================================================== */
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
        transition: transform .2s ease, box-shadow .2s ease;
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

    /* =====================================================
   CARTES GÉNÉRALES
====================================================== */
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
        font-weight: 500;
    }

    .caisse-card-body {
        padding: 20px;
    }

    /* =====================================================
   TABLEAU DU LIVRE
====================================================== */
    .livre-table-wrapper {
        overflow-x: auto;
    }

    .caisse-table {
        width: 100%;
        margin-bottom: 0;
    }

    .caisse-table thead th {
        padding: 12px 8px;
        color: #475569;
        border-top: none;
        border-bottom: 1px solid #dfe7ed;
        background: #f8fafc;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .livre-table {
        min-width: 1250px;
    }

    .livre-table thead th {
        white-space: normal;
        vertical-align: top;
    }

    .caisse-table tbody td {
        padding: 12px 8px;
        vertical-align: middle;
        border-top: 1px solid #edf2f7;
        color: #475569;
        font-size: 11px;
    }

    .caisse-table tbody tr:hover {
        background: #f8fffd;
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

    .livre-cell-justification {
        min-width: 190px;
    }

    .livre-cell-categorie {
        min-width: 150px;
    }

    .livre-ref-badge {
        display: inline-block;
        padding: 4px 7px;
        color: #0f766e;
        border: 1px solid #99d5ce;
        border-radius: 6px;
        background: #f0fdfa;
        font-size: 9px;
        font-weight: 800;
    }

    /* Colonne signature (fidèle au papier) */
    .livre-signature-name {
        display: block;
        margin-bottom: 4px;
        color: var(--caisse-secondary);
        font-size: 10px;
        font-weight: 700;
    }

    .livre-signature-line {
        display: block;
        width: 110px;
        height: 16px;
        border-bottom: 1px dashed #94a3b8;
    }

    /* Totaux du livre */
    .livre-totals-row td {
        padding: 14px 8px;
        border-top: 2px solid #dfe7ed;
        background: #f8fafc;
        font-size: 12px;
        font-weight: 800;
        color: var(--caisse-secondary);
    }

    /* Note des catégories (comme le papier) */
    .livre-note {
        margin-top: 16px;
        padding: 13px 16px;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        background: #f8fafc;
        color: var(--caisse-muted);
        font-size: 10px;
        line-height: 1.6;
    }

    .livre-note strong {
        color: var(--caisse-secondary);
    }

    /* =====================================================
   IMPRESSION
====================================================== */
    .livre-print-header {
        display: none;
    }

    /* =====================================================
   FILTRES DU LIVRE
====================================================== */
    .livre-filter-box {
        margin-bottom: 22px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .livre-filter-box label {
        display: block;
        margin-bottom: 6px;
        color: #475569;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .15px;
    }

    .livre-filter-box .form-control {
        min-height: 40px;
        border: 1px solid #dbe4ea;
        border-radius: 8px;
        color: #334155;
        font-size: 11px;
    }

    .livre-filter-box .form-control:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 .15rem rgba(15, 118, 110, .13);
    }

    .livre-filter-box .input-group .form-control {
        border-radius: 8px 0 0 8px;
    }

    .livre-filter-box .input-group-text {
        min-width: 43px;
        justify-content: center;
        color: #334155;
        border-color: #dbe4ea;
        background: #f1f5f9;
    }

    .livre-filter-actions {
        display: flex;
        align-items: center;
        min-height: 40px;
    }

    .livre-active-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 7px;
        margin-top: 15px;
        padding-top: 14px;
        border-top: 1px solid #edf2f7;
    }

    .livre-active-filters-label {
        color: #475569;
        font-size: 10px;
        font-weight: 800;
    }

    .livre-filter-tag {
        display: inline-flex;
        align-items: center;
        min-height: 27px;
        padding: 5px 9px;
        color: #0f766e;
        border: 1px solid #99d5ce;
        border-radius: 20px;
        background: #f0fdfa;
        font-size: 9px;
    }

    .livre-filter-tag strong {
        margin-left: 4px;
    }

    .livre-filter-results {
        margin-left: auto;
        padding: 5px 9px;
        color: #0369a1;
        border-radius: 20px;
        background: #e0f2fe;
        font-size: 9px;
        font-weight: 800;
    }

    @media print {

        .main-sidebar,
        .main-header,
        .main-footer,
        .content-header,
        .caisse-hero,
        .caisse-stat-card,
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

        .caisse-card-header {
            display: none !important;
        }

        .livre-table {
            min-width: 0;
        }

        .livre-table-wrapper {
            overflow: visible;
        }

        .caisse-table thead th {
            font-size: 8px;
        }

        .caisse-table tbody td {
            font-size: 9px;
        }

        .livre-print-header {
            display: block;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0f766e;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .livre-print-header h2 {
            margin: 0 0 4px;
            color: #102033;
            font-size: 18px;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
        }

        .livre-print-header p {
            margin: 2px 0;
            color: #475569;
            font-size: 11px;
        }

        .livre-signature-line {
            border-bottom: 1px solid #334155;
        }
    }

    /* =====================================================
   RESPONSIVE
====================================================== */
    @media (max-width: 767px) {
        .caisse-hero {
            padding: 20px;
        }

        .caisse-date-box {
            margin-top: 15px;
            min-width: 100%;
        }

        .caisse-card-header {
            display: block;
        }

        .caisse-card-header .btn {
            margin-top: 10px;
        }

        .caisse-stat-value {
            font-size: 19px;
        }
    }
</style>

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

/* -------------------------------------------------
 * Données sécurisées (objet par défaut : jamais null)
 * ------------------------------------------------- */
$cashbox = isset($cashbox) && is_object($cashbox)
    ? $cashbox
    : (object) [
        'id'              => 0,
        'code'            => '',
        'name'            => 'Caisse',
        'type'            => '',
        'devise'          => 'BIF',
        'responsable'     => '',
        'opening_balance' => 0,
        'current_balance' => 0,
        'chantier_name'   => '',
    ];
$livreRows   = isset($livreRows) && is_array($livreRows) ? $livreRows : [];
$stats       = isset($livreStats) && is_array($livreStats) ? $livreStats : [];
$filters     = isset($livreFilters) && is_array($livreFilters) ? $livreFilters : [];

$fSearch     = isset($filters['search']) ? (string) $filters['search'] : '';
$fType       = isset($filters['type']) ? (string) $filters['type'] : '';

$totalIn     = isset($stats['total_in']) ? (float) $stats['total_in'] : 0;
$totalOut    = isset($stats['total_out']) ? (float) $stats['total_out'] : 0;
$countIn     = isset($stats['count_in']) ? (int) $stats['count_in'] : 0;
$countOut    = isset($stats['count_out']) ? (int) $stats['count_out'] : 0;
$countTotal  = isset($stats['count_total']) ? (int) $stats['count_total'] : 0;
$finalBalance = isset($stats['final_balance']) ? (float) $stats['final_balance'] : 0;

$devise       = ($cashbox && !empty($cashbox->devise)) ? $cashbox->devise : 'BIF';
$cashboxTitle = $cashbox ? $cashbox->name : 'Caisse';
$cashboxCode  = $cashbox ? $cashbox->code : '';
?>
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
                                <span class="caisse-hero-title-icon">
                                    <i class="fas fa-book"></i>
                                </span>
                                Livre de caisse
                            </div>
                            <p>
                                Version numérique du livre de caisse papier : entrées, sorties,
                                soldes restants, justifications des dépenses et signatures de
                                réception des fonds.
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4 d-flex justify-content-md-end">
                            <div class="caisse-date-box">
                                <div class="livre-box-line">
                                    <small><i class="fas fa-tag mr-1"></i> Imputation</small>
                                    <strong><?= html_escape($cashboxTitle) ?></strong>
                                </div>
                                <div class="livre-box-line">
                                    <small><i class="fas fa-coins mr-1"></i> Monnaie utilisée</small>
                                    <strong><?= html_escape($devise) ?></strong>
                                </div>
                                <div class="livre-box-line">
                                    <small><i class="far fa-calendar-alt mr-1"></i> Situation au</small>
                                    <strong><?= date('d/m/Y') ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- En-tête imprimé uniquement -->
            <div class="livre-print-header">
                <h2>SATRACO Construction — Livre de caisse</h2>
                <p><strong>Imputation :</strong> <?= html_escape($cashboxTitle) ?> (<?= html_escape($cashboxCode) ?>)
                </p>
                <p><strong>Monnaie utilisée :</strong> <?= html_escape($devise) ?> —
                    <strong>Période :</strong> <?= formatCashboxDate($livreDateFrom) ?> au
                    <?= formatCashboxDate($livreDateTo) ?>
                </p>
            </div>

            <!-- =================================================
                 SYNTHÈSE DU LIVRE
            ================================================== -->
            <div class="row livre-no-print">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-green"><i class="fas fa-arrow-down"></i></div>
                            <span class="caisse-stat-badge badge-positive"><?= $countIn ?>
                                entrée<?= $countIn > 1 ? 's' : '' ?></span>
                        </div>
                        <div class="caisse-stat-label">Entrées dans la caisse</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($totalIn) ?> <?= html_escape($devise) ?>
                        </div>
                        <div class="caisse-stat-footer">Approvisionnements et recettes</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-red"><i class="fas fa-arrow-up"></i></div>
                            <span class="caisse-stat-badge badge-negative"><?= $countOut ?>
                                sortie<?= $countOut > 1 ? 's' : '' ?></span>
                        </div>
                        <div class="caisse-stat-label">Sorties de la caisse</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($totalOut) ?> <?= html_escape($devise) ?>
                        </div>
                        <div class="caisse-stat-footer">Dépenses justifiées</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-blue"><i class="fas fa-wallet"></i></div>
                            <span
                                class="caisse-stat-badge <?= $finalBalance > 0 ? 'badge-positive' : 'badge-negative' ?>">
                                <?= $finalBalance > 0 ? 'Disponible' : 'Solde nul' ?>
                            </span>
                        </div>
                        <div class="caisse-stat-label">Solde restant</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($finalBalance) ?>
                            <?= html_escape($devise) ?></div>
                        <div class="caisse-stat-footer">Solde en caisse au <?= date('d/m/Y') ?></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-orange"><i class="fas fa-pen-nib"></i></div>
                            <span class="caisse-stat-badge badge-neutral"><?= $countTotal ?>
                                ligne<?= $countTotal > 1 ? 's' : '' ?></span>
                        </div>
                        <div class="caisse-stat-label">Opérations consignées</div>
                        <div class="caisse-stat-value"><?= $countTotal ?></div>
                        <div class="caisse-stat-footer">Signées pour réception des fonds</div>
                    </div>
                </div>
            </div>

            <!-- =================================================
                 FILTRES (SERVEUR)
            ================================================== -->
            <div class="livre-filter-box livre-no-print">
                <form action="<?= current_url() ?>" method="get" id="livreFilterForm">
                    <div class="row align-items-end">
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label for="livreSearch">Rechercher</label>
                                <div class="input-group">
                                    <input type="text" name="livre_search" id="livreSearch" class="form-control"
                                        value="<?= html_escape($fSearch) ?>"
                                        placeholder="Justification, source, bénéficiaire, réf DA..." autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text" title="Rechercher"
                                            style="border-radius: 0 8px 8px 0; cursor: pointer;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label for="livreTypeFilter">Type de mouvement</label>
                                <select name="livre_type" id="livreTypeFilter" class="form-control">
                                    <option value="">Tous</option>
                                    <option value="entree" <?= $fType === 'entree' ? 'selected' : '' ?>>Entrées</option>
                                    <option value="sortie" <?= $fType === 'sortie' ? 'selected' : '' ?>>Sorties</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4">
                            <div class="form-group mb-lg-0">
                                <label for="livreDateFrom">Du</label>
                                <input type="date" name="livre_date_from" id="livreDateFrom" class="form-control"
                                    value="<?= html_escape($livreDateFrom) ?>">
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4">
                            <div class="form-group mb-lg-0">
                                <label for="livreDateTo">Au</label>
                                <input type="date" name="livre_date_to" id="livreDateTo" class="form-control"
                                    value="<?= html_escape($livreDateTo) ?>">
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4">
                            <div class="livre-filter-actions">
                                <button type="submit" class="btn btn-caisse-primary mr-1" title="Appliquer les filtres">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <a href="<?= current_url() ?>" class="btn btn-caisse-outline" title="Réinitialiser">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="livre-active-filters">
                        <span class="livre-active-filters-label">
                            <i class="fas fa-filter mr-1"></i>
                            Filtres actifs :
                        </span>
                        <span class="livre-filter-tag">
                            Période : <strong><?= formatCashboxDate($livreDateFrom) ?> →
                                <?= formatCashboxDate($livreDateTo) ?></strong>
                        </span>
                        <span class="livre-filter-tag">
                            Caisse : <strong><?= html_escape($cashboxTitle) ?></strong>
                        </span>
                        <?php if ($fSearch !== ''): ?>
                            <span class="livre-filter-tag">Recherche : <strong><?= html_escape($fSearch) ?></strong></span>
                        <?php endif; ?>
                        <?php if ($fType !== ''): ?>
                            <span class="livre-filter-tag">Type :
                                <strong><?= $fType === 'entree' ? 'Entrées' : 'Sorties' ?></strong></span>
                        <?php endif; ?>
                        <span class="livre-filter-results">
                            <?= $countTotal ?> ligne<?= $countTotal > 1 ? 's' : '' ?>
                        </span>
                    </div>
                </form>
            </div>

            <!-- =================================================
                 LIVRE DE CAISSE
            ================================================== -->
            <div class="caisse-card">
                <div class="caisse-card-header">
                    <div>
                        <h5 class="caisse-card-title">
                            <i class="fas fa-book"></i>
                            Livre de caisse — <?= html_escape($cashboxTitle) ?>
                        </h5>
                        <span class="caisse-card-subtitle">
                            Conforme au modèle papier SATRACO Construction.
                        </span>
                    </div>
                    <div class="livre-no-print">
                        <button type="button" class="btn btn-caisse-outline mr-1" onclick="window.print()">
                            <i class="fas fa-print mr-1"></i>
                            Imprimer
                        </button>
                        <a href="<?= base_url('finance/caisse/export/' . (int) $cashbox->id) ?>"
                            class="btn btn-caisse-primary">
                            <i class="fas fa-file-excel mr-1"></i>
                            Exporter
                        </a>
                    </div>
                </div>

                <div class="livre-table-wrapper">
                    <table class="table caisse-table livre-table">
                        <thead>
                            <tr>
                                <th style="width:35px;">N°</th>
                                <th style="width:80px;">Date</th>
                                <th>Entrées dans la caisse</th>
                                <th>Source de Fonds</th>
                                <th>Sorties de la caisse</th>
                                <th>Solde restant dans la caisse</th>
                                <th class="livre-cell-justification">Justification de la dépense</th>
                                <th class="livre-cell-categorie">Catégorie fonctionnement ou intitulé du chantier /
                                    Projet</th>
                                <th>N° de réf de demande d'achat des biens et services</th>
                                <th>Nom, prénom et signature pour réception des fonds</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($livreRows)): ?>
                                <?php foreach ($livreRows as $index => $row): ?>
                                    <?php
                                    $amount  = (float) $row->amount;
                                    $isEntry = ($row->livre_direction === 'entree');

                                    /* Source de Fonds (entrées uniquement) */
                                    $sourceLabel = '';
                                    $sourceSub   = '';
                                    if ($isEntry) {
                                        if ($row->operation_type === 'approvisionnement' && !empty($row->source_name)) {
                                            $sourceLabel = $row->source_name;
                                            $sourceSub   = $row->source_code;
                                        } elseif (!empty($row->third_party)) {
                                            $sourceLabel = $row->third_party;
                                            $sourceSub   = 'Provenance';
                                        } else {
                                            $sourceLabel = 'Provenance divers';
                                        }
                                    }

                                    /* Justification */
                                    $justification = !empty($row->expense_justification)
                                        ? $row->expense_justification
                                        : (!empty($row->label) ? $row->label : '—');

                                    /* Catégorie ou intitulé du chantier */
                                    $categoryLabel = !empty($row->category)
                                        ? $row->category
                                        : $cashboxTitle;

                                    /* Référence demande d'achat / pièce */
                                    $refLabel = !empty($row->purchase_request_reference)
                                        ? $row->purchase_request_reference
                                        : (!empty($row->document_number) ? $row->document_number : '');

                                    /* Signature */
                                    $signatureName = !empty($row->third_party)
                                        ? $row->third_party
                                        : (!empty($cashbox->responsable) ? $cashbox->responsable : '—');
                                    ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= formatCashboxDate($row->operation_date) ?></td>
                                        <td class="<?= $isEntry ? 'amount-in' : 'text-muted' ?>">
                                            <?= $isEntry ? '+ ' . formatCashboxAmount($amount) : '—' ?>
                                        </td>
                                        <td>
                                            <?php if ($isEntry): ?>
                                                <strong><?= html_escape($sourceLabel) ?></strong>
                                                <?php if ($sourceSub !== ''): ?>
                                                    <small class="d-block text-muted"><?= html_escape($sourceSub) ?></small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="<?= !$isEntry ? 'amount-out' : 'text-muted' ?>">
                                            <?= !$isEntry ? '- ' . formatCashboxAmount($amount) : '—' ?>
                                        </td>
                                        <td>
                                            <strong><?= formatCashboxAmount($row->livre_balance_after) ?></strong>
                                            <small class="d-block text-muted"><?= html_escape($devise) ?></small>
                                        </td>
                                        <td class="livre-cell-justification"><?= html_escape($justification) ?></td>
                                        <td class="livre-cell-categorie"><?= html_escape($categoryLabel) ?></td>
                                        <td>
                                            <?php if ($refLabel !== ''): ?>
                                                <span class="livre-ref-badge"><?= html_escape($refLabel) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="livre-signature-name"><?= html_escape($signatureName) ?></span>
                                            <span class="livre-signature-line"></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!-- TOTAUX -->
                                <tr class="livre-totals-row">
                                    <td colspan="2">
                                        <i class="fas fa-sigma mr-1" style="color:#0f766e;"></i>
                                        Totaux du livre (<?= $countTotal ?> ligne<?= $countTotal > 1 ? 's' : '' ?>)
                                    </td>
                                    <td class="amount-in">+ <?= formatCashboxAmount($totalIn) ?></td>
                                    <td></td>
                                    <td class="amount-out">- <?= formatCashboxAmount($totalOut) ?></td>
                                    <td style="color:<?= ($totalIn - $totalOut) >= 0 ? '#15803d' : '#b91c1c' ?>;">
                                        <?= formatCashboxAmount(abs($totalIn - $totalOut)) ?>
                                        <small class="d-block text-muted">Solde final</small>
                                    </td>
                                    <td colspan="4"></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="mb-3" style="color:#cbd5e1; font-size:42px;">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <h6 style="color:#334155; font-weight:800;">
                                            Aucune opération consignée sur cette période
                                        </h6>
                                        <p class="text-muted mb-0">
                                            Modifiez la période ou les filtres pour afficher le livre.
                                        </p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap livre-no-print">
                    <small class="text-muted">
                        Affichage de <?= $countTotal > 0 ? 1 : 0 ?> à <?= $countTotal ?>
                        sur <?= $countTotal ?> lignes du livre
                    </small>
                    <a href="<?= base_url('finance/journal-caisse') ?>" class="btn btn-caisse-outline btn-sm">
                        <i class="fas fa-list mr-1"></i>
                        Voir le journal de caisse
                    </a>
                </div>
            </div>

            <!-- Note des catégories (comme le papier) -->
            <div class="livre-note">
                <strong>Catégories de fonctionnement :</strong>
                1. Carburant et lubrifiants ;
                2. Entretien / réparation des véhicules, motos ;
                3. Entretien / réparation des équipements informatiques, de bureau ;
                4. Fourniture / équipement de bureau, d'hygiène, de nettoyage, d'informatique ;
                5. Entretien des locaux / bâtiments ;
                6. Entretien des jardins ;
                7. Restauration du personnel ; etc.
            </div>
        </div>
    </section>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* Normalise (minuscules + sans accents) pour la recherche */
        function normalizeStr(str) {
            return String(str || '').toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        }

        /* Index de recherche construit depuis le texte des lignes */
        var rows = document.querySelectorAll('#livreTable tbody tr.livre-row');
        rows.forEach(function(row) {
            row.dataset.search = normalizeStr(row.textContent);
        });

        /* Recherche en temps réel */
        document.getElementById('livreSearch').addEventListener('input', function() {
            applyLivreFilters();
        });
        document.getElementById('livreTypeFilter').addEventListener('change', function() {
            applyLivreFilters();
        });
    });

    /* Formatage des montants : 10650000 -> "10 650 000" */
    function formatLivreNumber(number) {
        return String(Math.round(number)).replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }

    /* =====================================================
     * FILTRAGE CLIENT DU LIVRE (en attendant le serveur)
     * ===================================================== */
    function applyLivreFilters(event) {
        if (event) {
            event.preventDefault();
        }

        var search = document.getElementById('livreSearch').value.trim().toLowerCase();
        var searchNormalized = search.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        var type = document.getElementById('livreTypeFilter').value;
        var dateFrom = document.getElementById('livreDateFrom').value;
        var dateTo = document.getElementById('livreDateTo').value;

        var visible = 0,
            totalIn = 0,
            totalOut = 0;

        document.querySelectorAll('#livreTable tbody tr.livre-row').forEach(function(row) {
            var show = true;

            if (searchNormalized !== '' && row.dataset.search.indexOf(searchNormalized) === -1) {
                show = false;
            }
            if (type !== '' && row.dataset.type !== type) {
                show = false;
            }
            if (dateFrom !== '' && row.dataset.date < dateFrom) {
                show = false;
            }
            if (dateTo !== '' && row.dataset.date > dateTo) {
                show = false;
            }

            row.style.display = show ? '' : 'none';

            if (show) {
                visible++;
                if (row.dataset.type === 'entree') {
                    totalIn += parseFloat(row.dataset.amount || 0);
                } else {
                    totalOut += parseFloat(row.dataset.amount || 0);
                }
            }
        });

        /* Totaux recalculés */
        document.getElementById('livreTotalIn').textContent = '+ ' + formatLivreNumber(totalIn);
        document.getElementById('livreTotalOut').textContent = '- ' + formatLivreNumber(totalOut);

        var net = totalIn - totalOut;
        var netCell = document.getElementById('livreTotalNet');
        netCell.innerHTML = (net >= 0 ? '+ ' : '- ') + formatLivreNumber(Math.abs(net)) +
            '<small class="d-block text-muted">Solde final</small>';
        netCell.style.color = net >= 0 ? '#15803d' : '#b91c1c';

        /* Compteurs */
        document.getElementById('livreCountText').textContent =
            'Affichage de ' + (visible > 0 ? 1 : 0) + ' à ' + visible +
            ' sur ' + visible + ' lignes du livre';
        document.getElementById('livreResultsTag').textContent =
            visible + ' ligne' + (visible > 1 ? 's' : '');

        /* État vide */
        document.getElementById('livreEmptyRow').style.display =
            (visible === 0 ? '' : 'none');
    }

    /* =====================================================
     * RÉINITIALISATION
     * ===================================================== */
    function resetLivreFilters() {
        document.getElementById('livreSearch').value = '';
        document.getElementById('livreTypeFilter').value = '';
        document.getElementById('livreDateFrom').value = '2026-08-01';
        document.getElementById('livreDateTo').value = '2026-08-06';
        applyLivreFilters();
    }
</script>