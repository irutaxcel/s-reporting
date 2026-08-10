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
if (!function_exists('formatCashboxTime')) {
    function formatCashboxTime($datetime): string
    {
        if (empty($datetime)) {
            return '';
        }
        return date('H:i', strtotime($datetime));
    }
}
?>
<!-- =========================================================
PAGE : JOURNAL DE CAISSE
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
        --caisse-purple: #7c3aed;
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
        min-width: 210px;
        padding: 12px 15px;
        text-align: right;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 12px;
        background: rgba(255, 255, 255, .10);
        backdrop-filter: blur(5px);
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

    /* =====================================================
   BOUTONS
====================================================== */
    .btn-caisse-primary,
    .btn-caisse-outline,
    .btn-caisse-success,
    .btn-caisse-danger {
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
   FILTRES
====================================================== */
    .caisse-filter-box {
        margin-bottom: 22px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .caisse-filter-box label {
        display: block;
        margin-bottom: 6px;
        color: #475569;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .15px;
    }

    .caisse-filter-box .form-control {
        min-height: 40px;
        border: 1px solid #dbe4ea;
        border-radius: 8px;
        color: #334155;
        font-size: 11px;
    }

    .caisse-filter-box .form-control:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 .15rem rgba(15, 118, 110, .13);
    }

    .caisse-filter-box .input-group .form-control {
        border-radius: 8px 0 0 8px;
    }

    .caisse-filter-box .input-group-text {
        min-width: 43px;
        justify-content: center;
        color: #334155;
        border-color: #dbe4ea;
        background: #f1f5f9;
    }

    .caisse-filter-box button.input-group-text {
        appearance: none;
        cursor: pointer;
    }

    .caisse-filter-box button.input-group-text:hover {
        color: #ffffff;
        border-color: #0f766e;
        background: #0f766e;
    }

    .cashbox-filter-actions {
        display: flex;
        align-items: center;
        min-height: 40px;
    }

    /* =====================================================
   FILTRES ACTIFS
====================================================== */
    .cashbox-active-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 7px;
        margin-top: 15px;
        padding-top: 14px;
        border-top: 1px solid #edf2f7;
    }

    .cashbox-active-filters-label {
        color: #475569;
        font-size: 10px;
        font-weight: 800;
    }

    .cashbox-filter-tag {
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

    .cashbox-filter-tag strong {
        margin-left: 4px;
    }

    .cashbox-filter-results {
        margin-left: auto;
        padding: 5px 9px;
        color: #0369a1;
        border-radius: 20px;
        background: #e0f2fe;
        font-size: 9px;
        font-weight: 800;
    }

    /* =====================================================
   TABLEAU JOURNAL
====================================================== */
    .caisse-table {
        width: 100%;
        margin-bottom: 0;
    }

    .caisse-table thead th {
        padding: 12px 10px;
        color: #475569;
        border-top: none;
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

    /* Ligne de séparation par journée */
    .journal-day-row td {
        padding: 9px 10px;
        border-top: none;
        background: #f0fdfa;
    }

    .journal-day-row:hover {
        background: #f0fdfa !important;
    }

    .journal-day-label {
        display: flex;
        align-items: center;
        color: var(--caisse-primary-dark);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .journal-day-label i {
        margin-right: 8px;
        color: var(--caisse-primary);
    }

    .journal-day-totals {
        display: flex;
        justify-content: flex-end;
        gap: 18px;
        font-size: 10px;
        font-weight: 700;
    }

    .journal-day-totals .day-in {
        color: #15803d;
    }

    .journal-day-totals .day-out {
        color: #b91c1c;
    }

    /* Ligne des totaux de la période */
    .journal-totals-row td {
        padding: 14px 10px;
        border-top: 2px solid #dfe7ed;
        background: #f8fafc;
        font-size: 12px;
        font-weight: 800;
        color: var(--caisse-secondary);
    }

    .operation-reference {
        color: var(--caisse-secondary);
        font-weight: 800;
    }

    .operation-label {
        max-width: 230px;
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

    /* =====================================================
   PAGINATION
====================================================== */
    .journal-pagination .page-item .page-link {
        margin: 0 3px;
        padding: 7px 12px;
        color: var(--caisse-primary);
        border: 1px solid #dbe4ea;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
    }

    .journal-pagination .page-item.active .page-link {
        color: #fff;
        border-color: var(--caisse-primary);
        background: var(--caisse-primary);
    }

    .journal-pagination .page-item.disabled .page-link {
        color: #cbd5e1;
        background: #f8fafc;
    }

    /* =====================================================
   RÉPARTITION / CAISSES ACTIVES
====================================================== */
    .expense-item {
        margin-bottom: 18px;
    }

    .expense-item:last-child {
        margin-bottom: 0;
    }

    .expense-item-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 7px;
    }

    .expense-item-title {
        display: flex;
        align-items: center;
        min-width: 0;
        color: #334155;
        font-size: 11px;
        font-weight: 700;
    }

    .expense-item-title i {
        flex: 0 0 25px;
        width: 25px;
        color: #0f766e;
    }

    .expense-item-value {
        margin-left: 10px;
        color: #102033;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .expense-progress {
        width: 100%;
        height: 7px;
        overflow: hidden;
        border-radius: 20px;
        background: #e9eef3;
    }

    .expense-progress span {
        display: block;
        height: 100%;
        border-radius: 20px;
        background: linear-gradient(90deg, #14b8a6, #0f766e);
        transition: width .35s ease;
    }

    .expense-progress span.bar-blue {
        background: linear-gradient(90deg, #38bdf8, #0284c7);
    }

    .expense-progress span.bar-red {
        background: linear-gradient(90deg, #f87171, #dc2626);
    }

    .expense-progress span.bar-orange {
        background: linear-gradient(90deg, #fbbf24, #f59e0b);
    }

    /* =====================================================
   MODALE DÉTAILS
====================================================== */
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

    .journal-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 13px 18px;
    }

    .journal-detail-item {
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
    }

    .journal-detail-item span {
        display: block;
        margin-bottom: 4px;
        color: #64748b;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .journal-detail-item strong {
        color: #102033;
        font-size: 12px;
        font-weight: 700;
        word-break: break-word;
    }

    .journal-detail-item.full {
        grid-column: 1 / -1;
    }

    .journal-detail-amount {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding: 14px 16px;
        border-radius: 12px;
    }

    .journal-detail-amount.in {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
    }

    .journal-detail-amount.out {
        background: #fef2f2;
        border: 1px solid #fecaca;
    }

    .journal-detail-amount span {
        color: #475569;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .journal-detail-amount strong {
        font-size: 20px;
        font-weight: 800;
    }

    /* =====================================================
   IMPRESSION
====================================================== */
    .journal-print-header {
        display: none;
    }

    @media print {

        .main-sidebar,
        .main-header,
        .main-footer,
        .content-header,
        .caisse-hero,
        .caisse-filter-box,
        .caisse-stat-card,
        .journal-no-print,
        .journal-actions-cell {
            display: none !important;
        }

        .content-wrapper {
            margin-left: 0 !important;
            background: #fff !important;
        }

        .caisse-card {
            border: 1px solid #ddd !important;
        }

        .journal-print-header {
            display: block;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 2px solid #0f766e;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .journal-print-header h2 {
            margin: 0 0 4px;
            color: #102033;
            font-size: 18px;
            font-weight: 800;
        }

        .journal-print-header p {
            margin: 0;
            color: #475569;
            font-size: 11px;
        }
    }

    /* =====================================================
   RESPONSIVE
====================================================== */
    @media (max-width: 991px) {
        .caisse-filter-box .form-group {
            margin-bottom: 13px !important;
        }

        .cashbox-filter-actions {
            margin-top: 2px;
        }
    }

    @media (max-width: 767px) {
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

        .caisse-card-header .btn {
            margin-top: 10px;
        }

        .caisse-stat-value {
            font-size: 19px;
        }

        .journal-detail-grid {
            grid-template-columns: 1fr;
        }

        .cashbox-filter-results {
            width: 100%;
            margin-left: 0;
            text-align: center;
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
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('dashboard') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================
         EN-TÊTE DE LA PAGE
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
                                Journal de caisse
                            </div>
                            <p>
                                Consultez l’historique détaillé de tous les mouvements de caisse :
                                encaissements, décaissements et transferts, avec soldes après chaque
                                opération et justificatifs associés.
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4 d-flex justify-content-md-end">
                            <div class="caisse-date-box">
                                <small>
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    Période couverte
                                </small>
                                <strong>28/07/2026 – 04/08/2026</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================
         CONTENU PRINCIPAL
    ====================================================== -->
    <section class="content">
        <div class="container-fluid">

            <!-- En-tête imprimé uniquement -->
            <div class="journal-print-header">
                <h2>SATRACO Construction — Journal de caisse</h2>
                <p>
                    Période : 28/07/2026 – 04/08/2026 ·
                    Édité le <?= date('d/m/Y') ?> à <?= date('H:i') ?> ·
                    Toutes les caisses confondues
                </p>
            </div>

            <!-- =================================================
                STATISTIQUES DE LA PÉRIODE (DONNÉES RÉELLES)
            ================================================== -->
            <?php
            /* -------------------------------------------------
            * Extraction sécurisée des statistiques
            * ------------------------------------------------- */
            $stats = isset($journalStatistics) && is_array($journalStatistics)
                ? $journalStatistics
                : [];

            $totalIn         = isset($stats['total_in'])         ? (float) $stats['total_in']         : 0;
            $totalOut        = isset($stats['total_out'])        ? (float) $stats['total_out']        : 0;
            $countIn         = isset($stats['count_in'])         ? (int) $stats['count_in']           : 0;
            $countOut        = isset($stats['count_out'])        ? (int) $stats['count_out']          : 0;
            $totalOperations = isset($stats['total_operations']) ? (int) $stats['total_operations']   : 0;
            $pendingCount    = isset($stats['pending_count'])    ? (int) $stats['pending_count']      : 0;
            $netFlow         = isset($stats['net_flow'])         ? (float) $stats['net_flow']         : ($totalIn - $totalOut);
            $inVariation     = isset($stats['in_variation'])     ? $stats['in_variation']             : null;
            $outVariation    = isset($stats['out_variation'])    ? $stats['out_variation']            : null;

            /* ----- Badge de variation des ENCAISSEMENTS -----
            (une hausse est favorable = vert)               */
            $inBadgeClass  = 'badge-neutral';
            $inBadgeIcon   = 'fas fa-minus';
            $inBadgePrefix = '';
            if ($inVariation !== null && $inVariation > 0) {
                $inBadgeClass  = 'badge-positive';
                $inBadgeIcon   = 'fas fa-arrow-up';
                $inBadgePrefix = '+';
            } elseif ($inVariation !== null && $inVariation < 0) {
                $inBadgeClass  = 'badge-negative';
                $inBadgeIcon   = 'fas fa-arrow-down';
            }

            /* ----- Badge de variation des DÉCAISSEMENTS -----
            (une hausse est défavorable = rouge)            */
            $outBadgeClass  = 'badge-neutral';
            $outBadgeIcon   = 'fas fa-minus';
            $outBadgePrefix = '';
            if ($outVariation !== null && $outVariation > 0) {
                $outBadgeClass  = 'badge-negative';
                $outBadgeIcon   = 'fas fa-arrow-up';
                $outBadgePrefix = '+';
            } elseif ($outVariation !== null && $outVariation < 0) {
                $outBadgeClass  = 'badge-positive';
                $outBadgeIcon   = 'fas fa-arrow-down';
            }

            /* ----- Badge + couleur du FLUX NET ----- */
            if ($netFlow > 0) {
                $netBadgeClass = 'badge-positive';
                $netBadgeLabel = 'Excédentaire';
                $netColor      = '#15803d';
                $netPrefix     = '+';
            } elseif ($netFlow < 0) {
                $netBadgeClass = 'badge-negative';
                $netBadgeLabel = 'Déficitaire';
                $netColor      = '#b91c1c';
                $netPrefix     = '- ';
            } else {
                $netBadgeClass = 'badge-neutral';
                $netBadgeLabel = 'Équilibré';
                $netColor      = '';
                $netPrefix     = '';
            }
            ?>
            <div class="row journal-no-print">
                <!-- ENCAISSEMENTS -->
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-green">
                                <i class="fas fa-arrow-down"></i>
                            </div>
                            <span class="caisse-stat-badge <?= $inBadgeClass ?>"
                                title="Évolution par rapport à la période précédente">
                                <i class="<?= $inBadgeIcon ?> mr-1"></i>
                                <?php if ($inVariation !== null): ?>
                                    <?= $inBadgePrefix ?><?= number_format(abs($inVariation), 1, ',', ' ') ?> %
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="caisse-stat-label">Encaissements</div>
                        <div class="caisse-stat-value">
                            <?= formatCashboxAmount($totalIn) ?> BIF
                        </div>
                        <div class="caisse-stat-footer">
                            <?= $countIn ?> entrée<?= $countIn > 1 ? 's' : '' ?> validée<?= $countIn > 1 ? 's' : '' ?>
                            sur la période
                        </div>
                    </div>
                </div>
                <!-- DÉCAISSEMENTS -->
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-red">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                            <span class="caisse-stat-badge <?= $outBadgeClass ?>"
                                title="Évolution par rapport à la période précédente">
                                <i class="<?= $outBadgeIcon ?> mr-1"></i>
                                <?php if ($outVariation !== null): ?>
                                    <?= $outBadgePrefix ?><?= number_format(abs($outVariation), 1, ',', ' ') ?> %
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="caisse-stat-label">Décaissements</div>
                        <div class="caisse-stat-value">
                            <?= formatCashboxAmount($totalOut) ?> BIF
                        </div>
                        <div class="caisse-stat-footer">
                            <?= $countOut ?> sortie<?= $countOut > 1 ? 's' : '' ?>
                            validée<?= $countOut > 1 ? 's' : '' ?> sur la période
                        </div>
                    </div>
                </div>
                <!-- FLUX NET -->
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-blue">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <span class="caisse-stat-badge <?= $netBadgeClass ?>">
                                <?= $netBadgeLabel ?>
                            </span>
                        </div>
                        <div class="caisse-stat-label">Flux net de trésorerie</div>
                        <div class="caisse-stat-value"
                            <?= $netColor !== '' ? 'style="color:' . $netColor . ';"' : '' ?>>
                            <?= $netPrefix ?><?= formatCashboxAmount(abs($netFlow)) ?> BIF
                        </div>
                        <div class="caisse-stat-footer">Encaissements – décaissements</div>
                    </div>
                </div>
                <!-- OPÉRATIONS -->
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-orange">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            <span class="caisse-stat-badge badge-neutral">
                                <?= $totalOperations ?> opération<?= $totalOperations > 1 ? 's' : '' ?>
                            </span>
                        </div>
                        <div class="caisse-stat-label">Opérations enregistrées</div>
                        <div class="caisse-stat-value"><?= $totalOperations ?></div>
                        <div class="caisse-stat-footer">
                            <?php if ($pendingCount > 0): ?>
                                dont <?= $pendingCount ?> en attente de validation
                            <?php else: ?>
                                Aucune opération en attente de validation
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =================================================
                FILTRES DU JOURNAL (DYNAMIQUES)
            ================================================== -->
            <?php
            /* -------------------------------------------------
            * Extraction sécurisée des filtres renvoyés
            * par le contrôleur ($data['journalFilters'])
            * ------------------------------------------------- */
            $jFilters       = isset($journalFilters) && is_array($journalFilters) ? $journalFilters : [];
            $jSearch        = isset($jFilters['search'])     ? (string) $jFilters['search']     : '';
            $jCashboxId     = isset($jFilters['cashbox_id']) ? (int) $jFilters['cashbox_id']    : 0;
            $jType          = isset($jFilters['type'])       ? (string) $jFilters['type']       : '';
            $jStatus        = isset($jFilters['status'])     ? (string) $jFilters['status']     : '';

            /* Liste des caisses actives (pour le select) */
            $jCashboxes = isset($journalCashboxes) && is_array($journalCashboxes) ? $journalCashboxes : [];

            /* Libellés d'affichage */
            $journalTypeLabels = [
                'encaissement'    => 'Encaissement',
                'decaissement'    => 'Décaissement',
                'approvisionnement' => 'Transfert',
            ];
            $journalStatusLabels = [
                'validated' => 'Validé',
                'pending'   => 'En attente',
                'cancelled' => 'Annulé',
            ];

            /* Libellé de la caisse filtrée (code — nom) */
            $jCashboxLabel = '';
            foreach ($jCashboxes as $cashboxOption) {
                if ((int) $cashboxOption->id === $jCashboxId) {
                    $jCashboxLabel = $cashboxOption->code . ' — ' . $cashboxOption->name;
                    break;
                }
            }

            /* Nombre de résultats (pagination) */
            $jResultsCount = isset($journalPagination['total']) ? (int) $journalPagination['total'] : 0;

            /* Filtres actifs hors période ? */
            $hasExtraJournalFilters = ($jSearch !== '' || $jCashboxId > 0 || $jType !== '' || $jStatus !== '');
            ?>
            <div class="caisse-filter-box journal-no-print">
                <form action="<?= current_url() ?>" method="get" id="journalFilterForm">
                    <div class="row align-items-end">
                        <!-- RECHERCHE -->
                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label for="journalSearch">Rechercher</label>
                                <div class="input-group">
                                    <input type="text" name="journal_search" id="journalSearch" class="form-control"
                                        value="<?= html_escape($jSearch) ?>"
                                        placeholder="Référence, libellé, bénéficiaire..." autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text" title="Rechercher"
                                            style="border-radius: 0 8px 8px 0; cursor: pointer;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CAISSE -->
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label for="journalCashboxFilter">Caisse</label>
                                <select name="journal_cashbox" id="journalCashboxFilter" class="form-control">
                                    <option value="">Toutes les caisses</option>
                                    <?php if (!empty($jCashboxes)): ?>
                                        <?php foreach ($jCashboxes as $cashboxOption): ?>
                                            <option value="<?= (int) $cashboxOption->id ?>"
                                                <?= $jCashboxId === (int) $cashboxOption->id ? 'selected' : '' ?>>
                                                <?= html_escape($cashboxOption->code) ?> —
                                                <?= html_escape($cashboxOption->name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <!-- TYPE -->
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label for="journalTypeFilter">Type d’opération</label>
                                <select name="journal_type" id="journalTypeFilter" class="form-control">
                                    <option value="">Tous</option>
                                    <?php foreach ($journalTypeLabels as $typeValue => $typeLabelText): ?>
                                        <option value="<?= $typeValue ?>" <?= $jType === $typeValue ? 'selected' : '' ?>>
                                            <?= $typeLabelText ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- STATUT -->
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label for="journalStatusFilter">Statut</label>
                                <select name="journal_status" id="journalStatusFilter" class="form-control">
                                    <option value="">Tous</option>
                                    <?php foreach ($journalStatusLabels as $statusValue => $statusLabelText): ?>
                                        <option value="<?= $statusValue ?>"
                                            <?= $jStatus === $statusValue ? 'selected' : '' ?>>
                                            <?= $statusLabelText ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- DATE DÉBUT -->
                        <div class="col-xl-1 col-lg-1 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label for="journalDateFrom">Du</label>
                                <input type="date" name="journal_date_from" id="journalDateFrom" class="form-control"
                                    value="<?= html_escape(isset($journalDateFrom) ? $journalDateFrom : date('Y-m-01')) ?>">
                            </div>
                        </div>
                        <!-- DATE FIN -->
                        <div class="col-xl-1 col-lg-1 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label for="journalDateTo">Au</label>
                                <input type="date" name="journal_date_to" id="journalDateTo" class="form-control"
                                    value="<?= html_escape(isset($journalDateTo) ? $journalDateTo : date('Y-m-d')) ?>">
                            </div>
                        </div>
                        <!-- ACTIONS -->
                        <div class="col-xl-1 col-lg-1 col-md-12">
                            <div class="cashbox-filter-actions">
                                <button type="submit" class="btn btn-caisse-primary mr-1" title="Appliquer les filtres">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <a href="<?= current_url() ?>" class="btn btn-caisse-outline"
                                    title="Réinitialiser les filtres">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- RÉSUMÉ DES FILTRES ACTIFS -->
                    <div class="cashbox-active-filters">
                        <span class="cashbox-active-filters-label">
                            <i class="fas fa-filter mr-1"></i>
                            Filtres actifs :
                        </span>

                        <!-- Période (toujours affichée) -->
                        <span class="cashbox-filter-tag">
                            Période :
                            <strong><?= formatCashboxDate(isset($journalDateFrom) ? $journalDateFrom : date('Y-m-01')) ?>
                                →
                                <?= formatCashboxDate(isset($journalDateTo) ? $journalDateTo : date('Y-m-d')) ?></strong>
                        </span>

                        <!-- Recherche -->
                        <?php if ($jSearch !== ''): ?>
                            <span class="cashbox-filter-tag">
                                Recherche : <strong><?= html_escape($jSearch) ?></strong>
                            </span>
                        <?php endif; ?>

                        <!-- Caisse -->
                        <span class="cashbox-filter-tag">
                            Caisse :
                            <strong><?= $jCashboxLabel !== '' ? html_escape($jCashboxLabel) : 'Toutes' ?></strong>
                        </span>

                        <!-- Type -->
                        <?php if ($jType !== '' && isset($journalTypeLabels[$jType])): ?>
                            <span class="cashbox-filter-tag">
                                Type : <strong><?= $journalTypeLabels[$jType] ?></strong>
                            </span>
                        <?php endif; ?>

                        <!-- Statut -->
                        <?php if ($jStatus !== '' && isset($journalStatusLabels[$jStatus])): ?>
                            <span class="cashbox-filter-tag">
                                Statut : <strong><?= $journalStatusLabels[$jStatus] ?></strong>
                            </span>
                        <?php endif; ?>

                        <!-- Lien de réinitialisation si filtres actifs -->
                        <?php if ($hasExtraJournalFilters): ?>
                            <a href="<?= current_url() ?>" class="cashbox-filter-tag"
                                style="text-decoration: none; color: #b91c1c; border-color: #fecaca; background: #fff7f7;"
                                title="Retirer tous les filtres">
                                <i class="fas fa-times mr-1"></i> Réinitialiser
                            </a>
                        <?php endif; ?>

                        <!-- Nombre de résultats -->
                        <span class="cashbox-filter-results">
                            <?= $jResultsCount ?> opération<?= $jResultsCount > 1 ? 's' : '' ?>
                        </span>
                    </div>
                </form>
            </div>

            <!-- =================================================
                TABLEAU DU JOURNAL (DONNÉES RÉELLES)
            ================================================== -->
            <?php
            /* -------------------------------------------------
            * Préparation des données du tableau
            * ------------------------------------------------- */
            if (!function_exists('formatJournalDayLabel')) {
                function formatJournalDayLabel($date)
                {
                    $days   = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
                    $months = [
                        'janvier',
                        'février',
                        'mars',
                        'avril',
                        'mai',
                        'juin',
                        'juillet',
                        'août',
                        'septembre',
                        'octobre',
                        'novembre',
                        'décembre'
                    ];
                    $ts = strtotime($date);
                    return ucfirst($days[(int) date('w', $ts)]) . ' ' . date('d', $ts)
                        . ' ' . $months[(int) date('n', $ts) - 1] . ' ' . date('Y', $ts);
                }
            }
            if (!function_exists('journalPageUrl')) {
                function journalPageUrl($page)
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

            $operations   = isset($journalOperations) && is_array($journalOperations) ? $journalOperations : [];
            $dayTotalsMap = isset($journalDayTotals) && is_array($journalDayTotals) ? $journalDayTotals : [];

            $pgTotal   = isset($journalPagination['total'])        ? (int) $journalPagination['total']        : 0;
            $pgOffset  = isset($journalPagination['offset'])       ? (int) $journalPagination['offset']       : 0;
            $pgCurrent = isset($journalPagination['current_page']) ? (int) $journalPagination['current_page'] : 1;
            $pgPages   = isset($journalPagination['total_pages'])  ? (int) $journalPagination['total_pages']  : 1;

            $methodLabels = [
                'cash'   => 'Espèces',
                'bank'   => 'Virement bancaire',
                'cheque' => 'Chèque',
                'mobile' => 'Mobile Money',
            ];

            /* Totaux de la période (respectent les filtres actifs) */
            $periodIn  = 0;
            $periodOut = 0;
            foreach ($dayTotalsMap as $dayTotalRow) {
                $periodIn  += (float) $dayTotalRow->day_in;
                $periodOut += (float) $dayTotalRow->day_out;
            }
            $periodNet = $periodIn - $periodOut;

            /* Fenêtre de pagination (5 pages visibles) */
            $windowStart = max(1, $pgCurrent - 2);
            $windowEnd   = min($pgPages, $windowStart + 4);
            $windowStart = max(1, $windowEnd - 4);
            ?>
            <div class="caisse-card">
                <div class="caisse-card-header">
                    <div>
                        <h5 class="caisse-card-title">
                            <i class="fas fa-list-alt"></i>
                            Détail des mouvements
                        </h5>
                        <span class="caisse-card-subtitle">
                            Opérations classées de la plus récente à la plus ancienne,
                            regroupées par journée.
                        </span>
                    </div>
                    <div class="journal-no-print">
                        <button type="button" class="btn btn-caisse-outline mr-1" onclick="window.print()">
                            <i class="fas fa-print mr-1"></i>
                            Imprimer
                        </button>
                        <a href="<?= base_url('finance/caisse/export') ?>" class="btn btn-caisse-primary">
                            <i class="fas fa-file-excel mr-1"></i>
                            Exporter
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table caisse-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Référence</th>
                                <th>Caisse</th>
                                <th>Type</th>
                                <th>Libellé / Bénéficiaire</th>
                                <th class="text-right">Entrée</th>
                                <th class="text-right">Sortie</th>
                                <th class="text-right">Solde après</th>
                                <th>Statut</th>
                                <th class="text-center journal-actions-cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($operations)): ?>
                                <?php $currentDay = null; ?>
                                <?php foreach ($operations as $index => $movement): ?>

                                    <?php /* ---------- LIGNE DE SÉPARATION PAR JOURNÉE ---------- */ ?>
                                    <?php if ($movement->operation_date !== $currentDay): ?>
                                        <?php
                                        $currentDay   = $movement->operation_date;
                                        $dayInfo      = isset($dayTotalsMap[$currentDay]) ? $dayTotalsMap[$currentDay] : null;
                                        $dayCount     = $dayInfo ? (int) $dayInfo->day_count     : 0;
                                        $dayIn        = $dayInfo ? (float) $dayInfo->day_in      : 0;
                                        $dayOut       = $dayInfo ? (float) $dayInfo->day_out     : 0;
                                        $dayTransfer  = $dayInfo ? (float) $dayInfo->day_transfer : 0;
                                        ?>
                                        <tr class="journal-day-row">
                                            <td colspan="11">
                                                <div class="journal-day-label">
                                                    <i class="far fa-calendar-alt"></i>
                                                    <?= formatJournalDayLabel($currentDay) ?>
                                                    — <?= $dayCount ?> opération<?= $dayCount > 1 ? 's' : '' ?>
                                                </div>
                                                <div class="journal-day-totals">
                                                    <span class="day-in">Entrées : +<?= formatCashboxAmount($dayIn) ?></span>
                                                    <span class="day-out">Sorties : -<?= formatCashboxAmount($dayOut) ?></span>
                                                    <?php if ($dayTransfer > 0): ?>
                                                        <span class="day-out" style="color:#0369a1;">
                                                            Transferts : -<?= formatCashboxAmount($dayTransfer) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php /* ---------- PRÉPARATION DE LA LIGNE ---------- */ ?>
                                    <?php
                                    $rowNumber = $pgOffset + $index + 1;
                                    $amount    = (float) $movement->amount;

                                    /* Type d'opération */
                                    $typeLabel    = 'Opération';
                                    $typeClass    = 'badge-transfert';
                                    $typeIcon     = 'fas fa-exchange-alt';
                                    $entryAmount  = null;
                                    $outputAmount = null;
                                    $flow         = 'out';

                                    if ($movement->operation_type === 'encaissement') {
                                        $typeLabel   = 'Entrée';
                                        $typeClass   = 'badge-entree';
                                        $typeIcon    = 'fas fa-arrow-down';
                                        $entryAmount = $amount;
                                        $flow        = 'in';
                                    } elseif ($movement->operation_type === 'decaissement') {
                                        $typeLabel    = 'Sortie';
                                        $typeClass    = 'badge-sortie';
                                        $typeIcon     = 'fas fa-arrow-up';
                                        $outputAmount = $amount;
                                    } elseif ($movement->operation_type === 'approvisionnement') {
                                        $typeLabel    = 'Transfert';
                                        $typeClass    = 'badge-transfert';
                                        $typeIcon     = 'fas fa-exchange-alt';
                                        $outputAmount = $amount;
                                    }

                                    /* Statut */
                                    $statusLabel = 'Inconnu';
                                    $statusClass = 'badge-secondary';
                                    if ($movement->status === 'validated') {
                                        $statusLabel = 'Validé';
                                        $statusClass = 'badge-success';
                                    } elseif ($movement->status === 'pending') {
                                        $statusLabel = 'En attente';
                                        $statusClass = 'badge-warning';
                                    } elseif ($movement->status === 'cancelled') {
                                        $statusLabel = 'Annulé';
                                        $statusClass = 'badge-danger';
                                    }

                                    /* Caisse affichée (caisse source) */
                                    $cashboxName = !empty($movement->source_cashbox_name)
                                        ? $movement->source_cashbox_name : 'Caisse';
                                    $cashboxCode = !empty($movement->source_cashbox_code)
                                        ? $movement->source_cashbox_code : '';

                                    /* Sous-libellé */
                                    $secondaryLabel = '';
                                    if ($movement->operation_type === 'encaissement') {
                                        if (!empty($movement->third_party)) {
                                            $secondaryLabel = 'Provenance : ' . $movement->third_party;
                                        }
                                    } elseif ($movement->operation_type === 'decaissement') {
                                        if (!empty($movement->third_party)) {
                                            $secondaryLabel = 'Bénéficiaire : ' . $movement->third_party;
                                        }
                                    } elseif ($movement->operation_type === 'approvisionnement') {
                                        $secondaryLabel = 'Destination : '
                                            . (!empty($movement->destination_cashbox_name)
                                                ? $movement->destination_cashbox_name
                                                : (!empty($movement->destination_cashbox_code)
                                                    ? $movement->destination_cashbox_code
                                                    : 'Caisse destination'));
                                    }

                                    /* Mode de règlement */
                                    $methodLabel = isset($methodLabels[$movement->payment_method])
                                        ? $methodLabels[$movement->payment_method]
                                        : (!empty($movement->payment_method) ? $movement->payment_method : '—');

                                    /* Montant affiché dans la modale */
                                    $amountDisplay = ($flow === 'in' ? '+ ' : '- ')
                                        . formatCashboxAmount($amount) . ' '
                                        . (!empty($movement->currency) ? $movement->currency : 'BIF');
                                    ?>
                                    <tr>
                                        <td><?= $rowNumber ?></td>
                                        <td>
                                            <?= formatCashboxDate($movement->operation_date) ?>
                                            <small class="d-block text-muted">
                                                <?= formatCashboxTime($movement->created_at) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <span class="operation-reference">
                                                <?= html_escape($movement->reference) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong><?= html_escape($cashboxName) ?></strong>
                                            <small class="d-block text-muted"><?= html_escape($cashboxCode) ?></small>
                                        </td>
                                        <td>
                                            <span class="badge-operation <?= $typeClass ?>">
                                                <i class="<?= $typeIcon ?> mr-1"></i>
                                                <?= $typeLabel ?>
                                            </span>
                                        </td>
                                        <td class="operation-label">
                                            <strong title="<?= html_escape($movement->label) ?>">
                                                <?= html_escape($movement->label) ?>
                                            </strong>
                                            <?php if ($secondaryLabel !== ''): ?>
                                                <small><?= html_escape($secondaryLabel) ?></small>
                                            <?php elseif (!empty($movement->category)): ?>
                                                <small>Catégorie : <?= html_escape($movement->category) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right <?= $entryAmount !== null ? 'amount-in' : 'text-muted' ?>">
                                            <?php if ($entryAmount !== null): ?>
                                                + <?= formatCashboxAmount($entryAmount) ?>
                                            <?php else: ?>
                                                —
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right <?= $outputAmount !== null ? 'amount-out' : 'text-muted' ?>">
                                            <?php if ($outputAmount !== null): ?>
                                                - <?= formatCashboxAmount($outputAmount) ?>
                                            <?php else: ?>
                                                —
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right">
                                            <strong><?= formatCashboxAmount($movement->balance_after) ?></strong>
                                            <small class="d-block text-muted">
                                                <?= html_escape($movement->currency) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span>
                                        </td>
                                        <td class="text-center journal-actions-cell">
                                            <button type="button" class="btn-table-action btn-table-view"
                                                title="Voir les détails" onclick='viewJournalMovement(this)'
                                                data-reference="<?= html_escape($movement->reference) ?>"
                                                data-date="<?= formatCashboxDate($movement->operation_date) ?> à <?= formatCashboxTime($movement->created_at) ?>"
                                                data-cashbox="<?= html_escape($cashboxName . ($cashboxCode !== '' ? ' (' . $cashboxCode . ')' : '')) ?>"
                                                data-type="<?= $typeLabel ?>" data-type-class="<?= $typeClass ?>"
                                                data-label="<?= html_escape($movement->label) ?>"
                                                data-secondary="<?= html_escape($secondaryLabel !== '' ? $secondaryLabel : '—') ?>"
                                                data-category="<?= html_escape(!empty($movement->category) ? $movement->category : '—') ?>"
                                                data-method="<?= html_escape($methodLabel) ?>"
                                                data-document="<?= html_escape(!empty($movement->document_number) ? $movement->document_number : '—') ?>"
                                                data-amount="<?= html_escape($amountDisplay) ?>" data-flow="<?= $flow ?>"
                                                data-balance="<?= html_escape(formatCashboxAmount($movement->balance_after) . ' ' . $movement->currency) ?>"
                                                data-status="<?= $statusLabel ?>" data-status-class="<?= $statusClass ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if (!empty($movement->attachment)): ?>
                                                <a href="<?= base_url('uploads/finance/cashbox_operations/' . rawurlencode($movement->attachment)) ?>"
                                                    target="_blank" class="btn-table-action btn-table-print"
                                                    title="Voir le justificatif">
                                                    <i class="fas fa-paperclip"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?= base_url('finance/cashbox-operation-print/' . (int) $movement->id) ?>"
                                                target="_blank" class="btn-table-action btn-table-print" title="Imprimer">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php /* ---------- TOTAUX DE LA PÉRIODE ---------- */ ?>
                                <tr class="journal-totals-row">
                                    <td colspan="6">
                                        <i class="fas fa-sigma mr-1" style="color:#0f766e;"></i>
                                        Totaux de la période (<?= $pgTotal ?> opération<?= $pgTotal > 1 ? 's' : '' ?>)
                                    </td>
                                    <td class="text-right amount-in">+ <?= formatCashboxAmount($periodIn) ?></td>
                                    <td class="text-right amount-out">- <?= formatCashboxAmount($periodOut) ?></td>
                                    <td class="text-right" style="color:<?= $periodNet >= 0 ? '#15803d' : '#b91c1c' ?>;">
                                        <?= $periodNet >= 0 ? '+ ' : '- ' ?><?= formatCashboxAmount(abs($periodNet)) ?>
                                        <small class="d-block text-muted">Flux net</small>
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center py-5">
                                        <div class="mb-3" style="color:#cbd5e1; font-size:42px;">
                                            <i class="fas fa-exchange-alt"></i>
                                        </div>
                                        <h6 style="color:#334155; font-weight:800;">
                                            Aucune opération sur cette période
                                        </h6>
                                        <p class="text-muted mb-0">
                                            Modifiez la période ou réinitialisez les filtres
                                            pour afficher les mouvements de caisse.
                                        </p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pied du tableau : pagination réelle -->
                <div
                    class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap journal-no-print">
                    <small class="text-muted">
                        <?php if ($pgTotal > 0): ?>
                            Affichage de <?= $pgOffset + 1 ?> à <?= $pgOffset + count($operations) ?>
                            sur <?= $pgTotal ?> opérations
                        <?php else: ?>
                            Aucune opération à afficher
                        <?php endif; ?>
                    </small>
                    <?php if ($pgPages > 1): ?>
                        <nav>
                            <ul class="pagination journal-pagination mb-0">
                                <li class="page-item <?= $pgCurrent <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="<?= $pgCurrent > 1 ? journalPageUrl($pgCurrent - 1) : '#' ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                <?php for ($p = $windowStart; $p <= $windowEnd; $p++): ?>
                                    <li class="page-item <?= $p === $pgCurrent ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= journalPageUrl($p) ?>"><?= $p ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?= $pgCurrent >= $pgPages ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="<?= $pgCurrent < $pgPages ? journalPageUrl($pgCurrent + 1) : '#' ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
            <!-- =================================================
                RÉPARTITION + CAISSES ACTIVES (DONNÉES RÉELLES)
            ================================================== -->
            <?php
            /* -------------------------------------------------
            * Répartition par type d'opération
            * ------------------------------------------------- */
            $dist = isset($journalTypeDistribution) && is_array($journalTypeDistribution)
                ? $journalTypeDistribution : [];
            $distTotal = isset($dist['total']) ? (int) $dist['total'] : 0;

            $distItems = [
                [
                    'icon'       => 'fas fa-arrow-up',
                    'label'      => 'Décaissements',
                    'count'      => isset($dist['decaissement']) ? (int) $dist['decaissement'] : 0,
                    'percentage' => isset($dist['decaissement_percentage']) ? (float) $dist['decaissement_percentage'] : 0,
                    'barClass'   => 'bar-red',
                ],
                [
                    'icon'       => 'fas fa-arrow-down',
                    'label'      => 'Encaissements',
                    'count'      => isset($dist['encaissement']) ? (int) $dist['encaissement'] : 0,
                    'percentage' => isset($dist['encaissement_percentage']) ? (float) $dist['encaissement_percentage'] : 0,
                    'barClass'   => '',
                ],
                [
                    'icon'       => 'fas fa-exchange-alt',
                    'label'      => 'Transferts entre caisses',
                    'count'      => isset($dist['transfert']) ? (int) $dist['transfert'] : 0,
                    'percentage' => isset($dist['transfert_percentage']) ? (float) $dist['transfert_percentage'] : 0,
                    'barClass'   => 'bar-blue',
                ],
            ];

            /* -------------------------------------------------
            * Caisses les plus actives
            * ------------------------------------------------- */
            $activity = isset($journalCashboxActivity) && is_array($journalCashboxActivity)
                ? $journalCashboxActivity : [];

            $maxActivity = 0;
            foreach ($activity as $activityItem) {
                if ((int) $activityItem['operations_count'] > $maxActivity) {
                    $maxActivity = (int) $activityItem['operations_count'];
                }
            }
            $activityBarClasses = ['', 'bar-orange', 'bar-blue', 'bar-red', 'bar-orange'];
            ?>
            <div class="row journal-no-print">
                <!-- RÉPARTITION PAR TYPE -->
                <div class="col-xl-6 col-lg-6">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title">
                                    <i class="fas fa-chart-pie"></i>
                                    Répartition par type d’opération
                                </h5>
                                <span class="caisse-card-subtitle">
                                    Volume des opérations sur la période sélectionnée.
                                </span>
                            </div>
                            <span class="badge badge-light">
                                <?= $distTotal ?> opération<?= $distTotal > 1 ? 's' : '' ?>
                            </span>
                        </div>
                        <div class="caisse-card-body">
                            <?php if ($distTotal > 0): ?>
                                <?php foreach ($distItems as $distItem): ?>
                                    <div class="expense-item">
                                        <div class="expense-item-header">
                                            <span class="expense-item-title">
                                                <i class="<?= $distItem['icon'] ?>"></i>
                                                <?= $distItem['label'] ?>
                                                <small class="text-muted ml-1">
                                                    (<?= $distItem['count'] ?>)
                                                </small>
                                            </span>
                                            <span class="expense-item-value">
                                                <?= number_format($distItem['percentage'], 0) ?> %
                                            </span>
                                        </div>
                                        <div class="expense-progress">
                                            <span class="<?= $distItem['barClass'] ?>"
                                                style="width: <?= max($distItem['percentage'] > 0 ? 4 : 0, min(100, $distItem['percentage'])) ?>%;"></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <div class="mb-3" style="color: #cbd5e1; font-size: 40px;">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                    <h6 style="color: #334155; font-weight: 800;">
                                        Aucune opération sur la période
                                    </h6>
                                    <p class="text-muted mb-0">
                                        La répartition par type apparaîtra
                                        automatiquement ici.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- CAISSES LES PLUS ACTIVES -->
                <div class="col-xl-6 col-lg-6">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title">
                                    <i class="fas fa-cash-register"></i>
                                    Caisses les plus actives
                                </h5>
                                <span class="caisse-card-subtitle">
                                    Nombre d’opérations enregistrées par caisse.
                                </span>
                            </div>
                            <?php if (!empty($activity)): ?>
                                <span class="badge badge-success">
                                    <?= count($activity) ?> caisse<?= count($activity) > 1 ? 's' : '' ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="caisse-card-body">
                            <?php if (!empty($activity)): ?>
                                <?php foreach ($activity as $activityIndex => $activityItem): ?>
                                    <?php
                                    $activityPercentage = $maxActivity > 0
                                        ? round(((int) $activityItem['operations_count'] / $maxActivity) * 100)
                                        : 0;
                                    /* Toujours visible si au moins une opération */
                                    if ($activityItem['operations_count'] > 0 && $activityPercentage < 4) {
                                        $activityPercentage = 4;
                                    }
                                    $activityBarClass = isset($activityBarClasses[$activityIndex])
                                        ? $activityBarClasses[$activityIndex]
                                        : '';
                                    ?>
                                    <div class="expense-item">
                                        <div class="expense-item-header">
                                            <span class="expense-item-title">
                                                <i
                                                    class="<?= $activityItem['type'] === 'siege' ? 'fas fa-building' : 'fas fa-hard-hat' ?>"></i>
                                                <?= html_escape($activityItem['code']) ?> —
                                                <?= html_escape($activityItem['name']) ?>
                                            </span>
                                            <span class="expense-item-value">
                                                <?= (int) $activityItem['operations_count'] ?>
                                                opération<?= $activityItem['operations_count'] > 1 ? 's' : '' ?>
                                            </span>
                                        </div>
                                        <div class="expense-progress">
                                            <span class="<?= $activityBarClass ?>"
                                                style="width: <?= min(100, $activityPercentage) ?>%;"></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <div class="mb-3" style="color: #cbd5e1; font-size: 40px;">
                                        <i class="fas fa-cash-register"></i>
                                    </div>
                                    <h6 style="color: #334155; font-weight: 800;">
                                        Aucune caisse active sur la période
                                    </h6>
                                    <p class="text-muted mb-0">
                                        Les caisses ayant enregistré des opérations
                                        apparaîtront ici.
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
MODALE : DÉTAILS D’UNE OPÉRATION
========================================================== -->
<div class="modal fade modal-caisse" id="journalDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-receipt mr-2"></i>
                    Détails de l’opération <span id="jdReference"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="journal-detail-amount" id="jdAmountBox">
                    <span>Montant de l’opération</span>
                    <strong id="jdAmount">0 BIF</strong>
                </div>
                <div class="journal-detail-grid">
                    <div class="journal-detail-item">
                        <span>Date et heure</span>
                        <strong id="jdDate">—</strong>
                    </div>
                    <div class="journal-detail-item">
                        <span>Caisse concernée</span>
                        <strong id="jdCashbox">—</strong>
                    </div>
                    <div class="journal-detail-item">
                        <span>Type d’opération</span>
                        <strong><span class="badge-operation" id="jdType">—</span></strong>
                    </div>
                    <div class="journal-detail-item">
                        <span>Statut</span>
                        <strong><span class="badge" id="jdStatus">—</span></strong>
                    </div>
                    <div class="journal-detail-item full">
                        <span>Libellé</span>
                        <strong id="jdLabel">—</strong>
                    </div>
                    <div class="journal-detail-item full">
                        <span>Bénéficiaire / Provenance / Destination</span>
                        <strong id="jdSecondary">—</strong>
                    </div>
                    <div class="journal-detail-item">
                        <span>Catégorie</span>
                        <strong id="jdCategory">—</strong>
                    </div>
                    <div class="journal-detail-item">
                        <span>Mode de règlement</span>
                        <strong id="jdMethod">—</strong>
                    </div>
                    <div class="journal-detail-item">
                        <span>Numéro de pièce</span>
                        <strong id="jdDocument">—</strong>
                    </div>
                    <div class="journal-detail-item">
                        <span>Solde après opération</span>
                        <strong id="jdBalance">—</strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-caisse-outline" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Fermer
                </button>
                <button type="button" class="btn btn-caisse-primary" onclick="window.print()">
                    <i class="fas fa-print mr-1"></i>
                    Imprimer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================
SCRIPTS
========================================================== -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        /*
         * =====================================================
         * AFFICHER LES DÉTAILS D’UNE OPÉRATION
         * (Statique : lecture des data-attributs de la ligne.
         *  Sera remplacé par un appel AJAX lors du dynamisme.)
         * =====================================================
         */
        window.viewJournalMovement = function(button) {
            const data = button.dataset;

            document.getElementById('jdReference').textContent = data.reference || '';
            document.getElementById('jdDate').textContent = data.date || '—';
            document.getElementById('jdCashbox').textContent = data.cashbox || '—';
            document.getElementById('jdLabel').textContent = data.label || '—';
            document.getElementById('jdSecondary').textContent = data.secondary || '—';
            document.getElementById('jdCategory').textContent = data.category || '—';
            document.getElementById('jdMethod').textContent = data.method || '—';
            document.getElementById('jdDocument').textContent = data.document || '—';
            document.getElementById('jdBalance').textContent = data.balance || '—';
            document.getElementById('jdAmount').textContent = data.amount || '—';

            /* Type d’opération */
            const typeBadge = document.getElementById('jdType');
            typeBadge.textContent = data.type || '—';
            typeBadge.className = 'badge-operation ' + (data.typeClass || 'badge-transfert');

            /* Statut */
            const statusBadge = document.getElementById('jdStatus');
            statusBadge.textContent = data.status || '—';
            statusBadge.className = 'badge ' + (data.statusClass || 'badge-secondary');

            /* Couleur du montant selon le sens */
            const amountBox = document.getElementById('jdAmountBox');
            amountBox.className = 'journal-detail-amount ' +
                (data.flow === 'in' ? 'in' : 'out');
            document.getElementById('jdAmount').style.color =
                data.flow === 'in' ? '#15803d' : '#b91c1c';

            $('#journalDetailModal').modal('show');
        };
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