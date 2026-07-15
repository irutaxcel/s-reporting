<!-- Content Wrapper -->
<div class="content-wrapper dec-page">

    <!-- =========================================================
         EN-TÊTE ADMINLTE
    ========================================================== -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?= $title ?>
                    </h1>
                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item">
                            <a href="<?= base_url('dashboard') ?>">
                                Home
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            <?= $title ?>
                        </li>

                    </ol>

                </div>

            </div>

        </div>
    </div>

    <!-- =========================================================
         CONTENU
    ========================================================== -->
    <section class="content">
        <div class="container-fluid">

            <style>
                :root {
                    --dec-primary: #0f766e;
                    --dec-primary-dark: #115e59;
                    --dec-dark: #102033;
                    --dec-green: #16a34a;
                    --dec-red: #dc2626;
                    --dec-orange: #f59e0b;
                    --dec-blue: #0284c7;
                    --dec-purple: #7c3aed;
                    --dec-light: #f8fafc;
                    --dec-border: #e2e8f0;
                    --dec-text: #334155;
                    --dec-muted: #64748b;
                }

                body .content-wrapper {
                    background: #f4f7f6;
                }

                .dec-page {
                    color: var(--dec-text);
                    font-family: "Segoe UI", Arial, sans-serif;
                }

                /* =====================================================
                   HERO
                ====================================================== */

                .dec-hero {
                    position: relative;
                    overflow: hidden;
                    margin-bottom: 22px;
                    padding: 24px 27px;
                    color: #fff;
                    border-radius: 16px;
                    background:
                        linear-gradient(135deg,
                            rgba(153, 27, 27, .96),
                            rgba(16, 32, 51, .98));
                    box-shadow: 0 10px 30px rgba(153, 27, 27, .16);
                }

                .dec-hero::before {
                    position: absolute;
                    top: -90px;
                    right: -45px;
                    width: 230px;
                    height: 230px;
                    content: "";
                    border-radius: 50%;
                    background: rgba(255, 255, 255, .08);
                }

                .dec-hero::after {
                    position: absolute;
                    right: 145px;
                    bottom: -120px;
                    width: 210px;
                    height: 210px;
                    content: "";
                    border-radius: 50%;
                    background: rgba(255, 255, 255, .05);
                }

                .dec-hero-content {
                    position: relative;
                    z-index: 2;
                }

                .dec-hero-title {
                    display: flex;
                    align-items: center;
                    margin-bottom: 7px;
                    font-size: 25px;
                    font-weight: 800;
                }

                .dec-hero-icon {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 46px;
                    height: 46px;
                    margin-right: 13px;
                    border-radius: 13px;
                    background: rgba(255, 255, 255, .16);
                }

                .dec-hero p {
                    max-width: 830px;
                    margin: 0;
                    color: rgba(255, 255, 255, .86);
                    font-size: 13px;
                    line-height: 1.6;
                }

                .dec-date-box {
                    min-width: 190px;
                    padding: 12px 15px;
                    text-align: right;
                    border: 1px solid rgba(255, 255, 255, .18);
                    border-radius: 12px;
                    background: rgba(255, 255, 255, .10);
                }

                .dec-date-box small {
                    display: block;
                    margin-bottom: 3px;
                    color: rgba(255, 255, 255, .75);
                }

                .dec-date-box strong {
                    font-size: 14px;
                    font-weight: 800;
                }

                /* =====================================================
                   BOUTONS
                ====================================================== */

                .btn-dec-primary,
                .btn-dec-outline,
                .btn-dec-danger,
                .btn-dec-success {
                    min-height: 39px;
                    padding: 9px 15px;
                    border-radius: 9px;
                    font-size: 12px;
                    font-weight: 700;
                    transition: all .2s ease;
                }

                .btn-dec-primary {
                    color: #fff;
                    border: 1px solid var(--dec-primary);
                    background: var(--dec-primary);
                }

                .btn-dec-primary:hover {
                    color: #fff;
                    border-color: var(--dec-primary-dark);
                    background: var(--dec-primary-dark);
                    transform: translateY(-1px);
                }

                .btn-dec-danger {
                    color: #fff;
                    border: 1px solid var(--dec-red);
                    background: var(--dec-red);
                }

                .btn-dec-danger:hover {
                    color: #fff;
                    background: #b91c1c;
                }

                .btn-dec-success {
                    color: #fff;
                    border: 1px solid var(--dec-green);
                    background: var(--dec-green);
                }

                .btn-dec-outline {
                    color: var(--dec-primary);
                    border: 1px solid #b8d8d4;
                    background: #fff;
                }

                .btn-dec-outline:hover {
                    color: #fff;
                    border-color: var(--dec-primary);
                    background: var(--dec-primary);
                }

                /* =====================================================
                   KPI
                ====================================================== */

                .dec-stat-card {
                    position: relative;
                    overflow: hidden;
                    min-height: 150px;
                    margin-bottom: 20px;
                    padding: 20px;
                    border: 1px solid var(--dec-border);
                    border-radius: 15px;
                    background: #fff;
                    box-shadow: 0 7px 25px rgba(15, 23, 42, .06);
                    transition: all .2s ease;
                }

                .dec-stat-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 12px 30px rgba(15, 23, 42, .10);
                }

                .dec-stat-card::after {
                    position: absolute;
                    right: -35px;
                    bottom: -40px;
                    width: 118px;
                    height: 118px;
                    content: "";
                    border-radius: 50%;
                    background: rgba(220, 38, 38, .05);
                }

                .dec-stat-top {
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    margin-bottom: 14px;
                }

                .dec-stat-icon {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 48px;
                    height: 48px;
                    border-radius: 13px;
                    font-size: 19px;
                }

                .dec-icon-red {
                    color: #b91c1c;
                    background: #fee2e2;
                }

                .dec-icon-green {
                    color: #15803d;
                    background: #dcfce7;
                }

                .dec-icon-blue {
                    color: #0369a1;
                    background: #e0f2fe;
                }

                .dec-icon-orange {
                    color: #b45309;
                    background: #fef3c7;
                }

                .dec-icon-purple {
                    color: #6d28d9;
                    background: #ede9fe;
                }

                .dec-stat-badge {
                    padding: 5px 9px;
                    border-radius: 30px;
                    font-size: 9px;
                    font-weight: 800;
                }

                .dec-badge-danger {
                    color: #b91c1c;
                    background: #fee2e2;
                }

                .dec-badge-success {
                    color: #15803d;
                    background: #dcfce7;
                }

                .dec-badge-warning {
                    color: #b45309;
                    background: #fef3c7;
                }

                .dec-badge-info {
                    color: #0369a1;
                    background: #e0f2fe;
                }

                .dec-stat-label {
                    margin-bottom: 5px;
                    color: var(--dec-muted);
                    font-size: 11px;
                    font-weight: 800;
                    text-transform: uppercase;
                    letter-spacing: .4px;
                }

                .dec-stat-value {
                    margin-bottom: 4px;
                    color: var(--dec-dark);
                    font-size: 22px;
                    font-weight: 800;
                    line-height: 1.2;
                }

                .dec-stat-footer {
                    color: var(--dec-muted);
                    font-size: 10px;
                }

                /* =====================================================
                   CARTES
                ====================================================== */

                .dec-card {
                    margin-bottom: 22px;
                    border: 1px solid var(--dec-border);
                    border-radius: 15px;
                    background: #fff;
                    box-shadow: 0 7px 24px rgba(15, 23, 42, .05);
                }

                .dec-card-header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    min-height: 64px;
                    padding: 15px 20px;
                    border-bottom: 1px solid #edf2f7;
                }

                .dec-card-title {
                    display: flex;
                    align-items: center;
                    margin: 0;
                    color: var(--dec-dark);
                    font-size: 15px;
                    font-weight: 800;
                }

                .dec-card-title i {
                    margin-right: 9px;
                    color: var(--dec-primary);
                }

                .dec-card-subtitle {
                    display: block;
                    margin-top: 3px;
                    color: var(--dec-muted);
                    font-size: 10px;
                }

                .dec-card-body {
                    padding: 20px;
                }

                /* =====================================================
                   ACTIONS RAPIDES
                ====================================================== */

                .dec-quick-action {
                    display: flex;
                    align-items: center;
                    min-height: 80px;
                    margin-bottom: 12px;
                    padding: 13px;
                    color: var(--dec-text);
                    border: 1px solid var(--dec-border);
                    border-radius: 12px;
                    background: #fff;
                    cursor: pointer;
                    transition: all .2s ease;
                }

                .dec-quick-action:hover {
                    color: var(--dec-primary);
                    border-color: #9bcac5;
                    background: #f0fdfa;
                    transform: translateY(-2px);
                }

                .dec-quick-action-icon {
                    display: flex;
                    flex: 0 0 43px;
                    align-items: center;
                    justify-content: center;
                    width: 43px;
                    height: 43px;
                    margin-right: 12px;
                    border-radius: 11px;
                    font-size: 17px;
                }

                .dec-quick-title {
                    display: block;
                    margin-bottom: 3px;
                    color: var(--dec-dark);
                    font-size: 11px;
                    font-weight: 800;
                }

                .dec-quick-text {
                    color: var(--dec-muted);
                    font-size: 9px;
                    line-height: 1.4;
                }

                /* =====================================================
                   GRAPHIQUE
                ====================================================== */

                .dec-chart-container {
                    position: relative;
                    width: 100%;
                    height: 315px;
                }

                .dec-chart-container canvas {
                    width: 100% !important;
                    height: 100% !important;
                }

                .dec-period-select {
                    width: 155px;
                    height: 36px;
                    border: 1px solid #dbe4ea;
                    border-radius: 8px;
                    font-size: 11px;
                }

                /* =====================================================
                   CATÉGORIES
                ====================================================== */

                .dec-category-item {
                    margin-bottom: 17px;
                }

                .dec-category-item:last-child {
                    margin-bottom: 0;
                }

                .dec-category-header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-bottom: 7px;
                }

                .dec-category-name {
                    display: flex;
                    align-items: center;
                    font-size: 11px;
                    font-weight: 700;
                }

                .dec-category-name i {
                    width: 26px;
                    color: var(--dec-primary);
                }

                .dec-category-value {
                    color: var(--dec-dark);
                    font-size: 11px;
                    font-weight: 800;
                }

                .dec-category-progress {
                    height: 7px;
                    overflow: hidden;
                    border-radius: 20px;
                    background: #e9eef3;
                }

                .dec-category-progress span {
                    display: block;
                    height: 100%;
                    border-radius: 20px;
                    background: linear-gradient(90deg, #ef4444, #991b1b);
                }

                /* =====================================================
                   FILTRES
                ====================================================== */

                .dec-filter-box {
                    margin-bottom: 22px;
                    padding: 18px;
                    border: 1px solid var(--dec-border);
                    border-radius: 14px;
                    background: #fff;
                    box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
                }

                .dec-filter-box label {
                    margin-bottom: 6px;
                    color: #475569;
                    font-size: 10px;
                    font-weight: 800;
                    text-transform: uppercase;
                }

                .dec-filter-box .form-control {
                    height: 40px;
                    border: 1px solid #dbe4ea;
                    border-radius: 8px;
                    font-size: 11px;
                }

                .dec-filter-box .form-control:focus {
                    border-color: var(--dec-primary);
                    box-shadow: 0 0 0 .15rem rgba(15, 118, 110, .13);
                }

                /* =====================================================
                   TABLEAU
                ====================================================== */

                .dec-table {
                    width: 100%;
                    margin-bottom: 0;
                }

                .dec-table thead th {
                    padding: 12px 10px;
                    color: #475569;
                    border-top: none;
                    border-bottom: 1px solid #dfe7ed;
                    background: #f8fafc;
                    font-size: 9px;
                    font-weight: 800;
                    text-transform: uppercase;
                    white-space: nowrap;
                }

                .dec-table tbody td {
                    padding: 12px 10px;
                    vertical-align: middle;
                    color: #475569;
                    border-top: 1px solid #edf2f7;
                    font-size: 10px;
                }

                .dec-table tbody tr:hover {
                    background: #fffafa;
                }

                .dec-reference {
                    color: var(--dec-dark);
                    font-weight: 800;
                    white-space: nowrap;
                }

                .dec-beneficiary strong,
                .dec-label strong {
                    display: block;
                    margin-bottom: 2px;
                    color: var(--dec-dark);
                    font-size: 10px;
                }

                .dec-beneficiary small,
                .dec-label small {
                    color: var(--dec-muted);
                    font-size: 9px;
                }

                .dec-amount {
                    color: #b91c1c;
                    font-weight: 800;
                    white-space: nowrap;
                }

                .dec-badge {
                    display: inline-flex;
                    align-items: center;
                    padding: 5px 8px;
                    border-radius: 30px;
                    font-size: 8px;
                    font-weight: 800;
                }

                .dec-status-valid {
                    color: #15803d;
                    background: #dcfce7;
                }

                .dec-status-pending {
                    color: #b45309;
                    background: #fef3c7;
                }

                .dec-status-rejected {
                    color: #b91c1c;
                    background: #fee2e2;
                }

                .dec-mode-bank {
                    color: #0369a1;
                    background: #e0f2fe;
                }

                .dec-mode-cash {
                    color: #15803d;
                    background: #dcfce7;
                }

                .dec-mode-cheque {
                    color: #6d28d9;
                    background: #ede9fe;
                }

                .dec-mode-mobile {
                    color: #b45309;
                    background: #fef3c7;
                }

                .dec-action-btn {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 31px;
                    height: 31px;
                    margin: 1px;
                    border: 1px solid #dbe4ea;
                    border-radius: 8px;
                    background: #fff;
                    font-size: 10px;
                }

                .dec-action-view {
                    color: #0369a1;
                }

                .dec-action-edit {
                    color: #b45309;
                }

                .dec-action-print {
                    color: #475569;
                }

                .dec-action-delete {
                    color: #b91c1c;
                }

                /* =====================================================
                   PAIEMENTS EN ATTENTE
                ====================================================== */

                .dec-awaiting-item {
                    display: flex;
                    align-items: center;
                    margin-bottom: 13px;
                    padding: 12px;
                    border: 1px solid var(--dec-border);
                    border-radius: 11px;
                    background: #fbfdfd;
                }

                .dec-awaiting-item:last-child {
                    margin-bottom: 0;
                }

                .dec-awaiting-icon {
                    display: flex;
                    flex: 0 0 42px;
                    align-items: center;
                    justify-content: center;
                    width: 42px;
                    height: 42px;
                    margin-right: 11px;
                    color: #b91c1c;
                    border-radius: 10px;
                    background: #fee2e2;
                }

                .dec-awaiting-info {
                    flex: 1;
                }

                .dec-awaiting-info strong {
                    display: block;
                    margin-bottom: 2px;
                    color: var(--dec-dark);
                    font-size: 10px;
                }

                .dec-awaiting-info small {
                    color: var(--dec-muted);
                    font-size: 9px;
                }

                .dec-awaiting-amount {
                    color: #b91c1c;
                    font-size: 11px;
                    font-weight: 800;
                    white-space: nowrap;
                }

                /* =====================================================
                   MODALE
                ====================================================== */

                .dec-modal .modal-content {
                    overflow: hidden;
                    border: none;
                    border-radius: 15px;
                    box-shadow: 0 20px 45px rgba(15, 23, 42, .20);
                }

                .dec-modal .modal-header {
                    color: #fff;
                    border-bottom: none;
                    background: linear-gradient(135deg, #991b1b, #102033);
                }

                .dec-modal .modal-title {
                    font-size: 16px;
                    font-weight: 800;
                }

                .dec-modal .close {
                    color: #fff;
                    opacity: .9;
                }

                .dec-modal label {
                    margin-bottom: 6px;
                    color: #475569;
                    font-size: 10px;
                    font-weight: 800;
                }

                .dec-modal .form-control {
                    min-height: 41px;
                    border: 1px solid #dbe4ea;
                    border-radius: 8px;
                    font-size: 11px;
                }

                .dec-modal textarea.form-control {
                    min-height: 90px;
                }

                .dec-required {
                    color: #dc2626;
                }

                .dec-section-title {
                    margin-bottom: 15px;
                    padding-bottom: 8px;
                    color: var(--dec-primary);
                    border-bottom: 1px solid #edf2f7;
                    font-size: 11px;
                    font-weight: 800;
                    text-transform: uppercase;
                }

                .dec-balance-box {
                    padding: 12px 15px;
                    border: 1px solid #bae6fd;
                    border-radius: 10px;
                    background: #f0f9ff;
                }

                .dec-balance-box small {
                    display: block;
                    color: #64748b;
                    font-size: 9px;
                }

                .dec-balance-box strong {
                    color: #075985;
                    font-size: 15px;
                    font-weight: 800;
                }

                @media (max-width: 767px) {
                    .dec-hero {
                        padding: 20px;
                    }

                    .dec-date-box {
                        margin-top: 15px;
                        text-align: left;
                    }

                    .dec-card-header {
                        display: block;
                    }

                    .dec-card-header .btn,
                    .dec-period-select {
                        margin-top: 10px;
                    }

                    .dec-stat-value {
                        font-size: 19px;
                    }

                    .dec-chart-container {
                        height: 260px;
                    }
                }

                .dec-chart-summary-item {
                    min-height: 68px;
                    padding: 12px 14px;
                    border: 1px solid #e5e7eb;
                    border-radius: 10px;
                    background: #f8fafc;
                }

                .dec-chart-summary-item span {
                    display: block;
                    margin-bottom: 5px;
                    color: #64748b;
                    font-size: 11px;
                    font-weight: 600;
                }

                .dec-chart-summary-item strong {
                    color: #0f172a;
                    font-size: 15px;
                    font-weight: 800;
                }

                .dec-mode-cheque {
                    background: #f3e8ff;
                    color: #7e22ce;
                }

                .dec-mode-mobile {
                    background: #fef3c7;
                    color: #b45309;
                }

                .dec-status-cancelled {
                    background: #fee2e2;
                    color: #b91c1c;
                }

                .dec-action-attachment {
                    color: #475569;
                }

                .dec-action-attachment:hover {
                    border-color: #64748b;
                    background: #f1f5f9;
                    color: #0f172a;
                    text-decoration: none;
                }

                .dec-empty-state {
                    max-width: 450px;
                    margin: 0 auto;
                }

                .dec-table td {
                    vertical-align: middle;
                }
            </style>

            <!-- =========================================================
                 HERO
            ========================================================== -->
            <div class="dec-hero">

                <div class="dec-hero-content">

                    <div class="row align-items-center">

                        <div class="col-lg-8 col-md-8">

                            <div class="dec-hero-title">

                                <span class="dec-hero-icon">
                                    <i class="fas fa-arrow-circle-up"></i>
                                </span>

                                Gestion des décaissements

                            </div>

                            <p>
                                Enregistrez, contrôlez et suivez toutes les sorties de fonds
                                destinées aux fournisseurs, salariés, sous-traitants, chantiers,
                                administrations fiscales et autres bénéficiaires.
                            </p>

                        </div>

                        <div class="col-lg-4 col-md-4 d-flex justify-content-md-end">

                            <div class="dec-date-box">

                                <small>
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    Situation au
                                </small>

                                <strong>
                                    <?= date('d/m/Y') ?>
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <?php

            $decaissementStatistics =
                isset($decaissementStatistics)
                && is_array($decaissementStatistics)
                ? $decaissementStatistics
                : [];

            $currentMonthAmount =
                isset(
                    $decaissementStatistics['current_month_amount']
                )
                ? (float) $decaissementStatistics['current_month_amount']
                : 0;

            $monthlyVariation =
                isset(
                    $decaissementStatistics['monthly_variation']
                )
                ? (float) $decaissementStatistics['monthly_variation']
                : 0;

            $todayAmount =
                isset(
                    $decaissementStatistics['today_amount']
                )
                ? (float) $decaissementStatistics['today_amount']
                : 0;

            $todayCount =
                isset(
                    $decaissementStatistics['today_count']
                )
                ? (int) $decaissementStatistics['today_count']
                : 0;

            $pendingAmount =
                isset(
                    $decaissementStatistics['pending_amount']
                )
                ? (float) $decaissementStatistics['pending_amount']
                : 0;

            $pendingCount =
                isset(
                    $decaissementStatistics['pending_count']
                )
                ? (int) $decaissementStatistics['pending_count']
                : 0;

            $availableTreasury =
                isset(
                    $decaissementStatistics['available_treasury']
                )
                ? (float) $decaissementStatistics['available_treasury']
                : 0;

            /*
 * Déterminer l'icône de variation.
 */
            $variationIcon =
                $monthlyVariation >= 0
                ? 'fas fa-arrow-up'
                : 'fas fa-arrow-down';

            /*
 * Une augmentation des dépenses reste affichée en rouge.
 * Une diminution est favorable et peut être affichée en vert.
 */
            $variationBadgeClass =
                $monthlyVariation > 0
                ? 'dec-badge-danger'
                : (
                    $monthlyVariation < 0
                    ? 'dec-badge-success'
                    : 'dec-badge-info'
                );

            ?>


            <!-- =========================================================
     STATISTIQUES DES DÉCAISSEMENTS
========================================================== -->
            <div class="row">

                <!-- =====================================================
         TOTAL DÉCAISSÉ CE MOIS
    ====================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="dec-stat-card">

                        <div class="dec-stat-top">

                            <div class="dec-stat-icon dec-icon-red">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>

                            <span class="
                        dec-stat-badge
                        <?= html_escape(
                            $variationBadgeClass
                        ) ?>
                    ">
                                <i class="
                            <?= html_escape(
                                $variationIcon
                            ) ?>
                            mr-1
                        "></i>

                                <?= number_format(
                                    abs($monthlyVariation),
                                    1,
                                    ',',
                                    ' '
                                ) ?> %
                            </span>

                        </div>

                        <div class="dec-stat-label">
                            Total décaissé ce mois
                        </div>

                        <div class="dec-stat-value">

                            <?= number_format(
                                $currentMonthAmount,
                                0,
                                ',',
                                ' '
                            ) ?>

                            BIF

                        </div>

                        <div class="dec-stat-footer">
                            Tous les paiements validés du mois
                        </div>

                    </div>

                </div>

                <!-- =====================================================
         DÉCAISSEMENTS DU JOUR
    ====================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="dec-stat-card">

                        <div class="dec-stat-top">

                            <div class="dec-stat-icon dec-icon-blue">
                                <i class="fas fa-calendar-day"></i>
                            </div>

                            <span class="dec-stat-badge dec-badge-info">

                                <?= $todayCount ?>

                                opération<?= $todayCount > 1
                                                ? 's'
                                                : ''
                                            ?>

                            </span>

                        </div>

                        <div class="dec-stat-label">
                            Décaissements du jour
                        </div>

                        <div class="dec-stat-value">

                            <?= number_format(
                                $todayAmount,
                                0,
                                ',',
                                ' '
                            ) ?>

                            BIF

                        </div>

                        <div class="dec-stat-footer">
                            Sorties validées aujourd’hui
                        </div>

                    </div>

                </div>

                <!-- =====================================================
         EN ATTENTE DE PAIEMENT
    ====================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="dec-stat-card">

                        <div class="dec-stat-top">

                            <div class="dec-stat-icon dec-icon-orange">
                                <i class="fas fa-hourglass-half"></i>
                            </div>

                            <span class="dec-stat-badge dec-badge-warning">

                                <?= $pendingCount ?>

                                demande<?= $pendingCount > 1
                                            ? 's'
                                            : ''
                                        ?>

                            </span>

                        </div>

                        <div class="dec-stat-label">
                            En attente de paiement
                        </div>

                        <div class="dec-stat-value">

                            <?= number_format(
                                $pendingAmount,
                                0,
                                ',',
                                ' '
                            ) ?>

                            BIF

                        </div>

                        <div class="dec-stat-footer">
                            Décaissements non encore validés
                        </div>

                    </div>

                </div>

                <!-- =====================================================
         TRÉSORERIE DISPONIBLE
    ====================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="dec-stat-card">

                        <div class="dec-stat-top">

                            <div class="dec-stat-icon dec-icon-green">
                                <i class="fas fa-wallet"></i>
                            </div>

                            <span class="
                        dec-stat-badge
                        <?= $availableTreasury > 0
                            ? 'dec-badge-success'
                            : 'dec-badge-danger'
                        ?>
                    ">

                                <?= $availableTreasury > 0
                                    ? 'Disponible'
                                    : 'Indisponible'
                                ?>

                            </span>

                        </div>

                        <div class="dec-stat-label">
                            Trésorerie disponible
                        </div>

                        <div class="dec-stat-value">

                            <?= number_format(
                                $availableTreasury,
                                0,
                                ',',
                                ' '
                            ) ?>

                            BIF

                        </div>

                        <div class="dec-stat-footer">
                            Caisses et comptes bancaires actifs
                        </div>

                    </div>

                </div>

            </div>

            <!-- =========================================================
                 ACTIONS RAPIDES
            ========================================================== -->
            <div class="dec-card">

                <div class="dec-card-header">

                    <div>

                        <h5 class="dec-card-title">
                            <i class="fas fa-bolt"></i>
                            Actions rapides
                        </h5>

                        <span class="dec-card-subtitle">
                            Accédez rapidement aux principales opérations de paiement.
                        </span>

                    </div>

                </div>

                <div class="dec-card-body pb-2">

                    <div class="row">

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="dec-quick-action" data-toggle="modal" data-target="#addDecaissementModal">

                                <div class="dec-quick-action-icon dec-icon-red">
                                    <i class="fas fa-plus"></i>
                                </div>

                                <div>
                                    <span class="dec-quick-title">
                                        Nouveau décaissement
                                    </span>

                                    <span class="dec-quick-text">
                                        Enregistrer une nouvelle sortie de fonds
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="dec-quick-action" data-toggle="modal" data-target="#addDecaissementModal"
                                onclick="prepareDecaissement('fournisseur')">

                                <div class="dec-quick-action-icon dec-icon-blue">
                                    <i class="fas fa-truck-loading"></i>
                                </div>

                                <div>
                                    <span class="dec-quick-title">
                                        Payer un fournisseur
                                    </span>

                                    <span class="dec-quick-text">
                                        Régler une facture fournisseur
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="dec-quick-action" data-toggle="modal" data-target="#addDecaissementModal"
                                onclick="prepareDecaissement('sous_traitant')">

                                <div class="dec-quick-action-icon dec-icon-purple">
                                    <i class="fas fa-user-tie"></i>
                                </div>

                                <div>
                                    <span class="dec-quick-title">
                                        Sous-traitant
                                    </span>

                                    <span class="dec-quick-text">
                                        Régler une situation de sous-traitance
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="dec-quick-action" data-toggle="modal" data-target="#addDecaissementModal"
                                onclick="prepareDecaissement('chantier')">

                                <div class="dec-quick-action-icon dec-icon-orange">
                                    <i class="fas fa-hard-hat"></i>
                                </div>

                                <div>
                                    <span class="dec-quick-title">
                                        Approvisionner chantier
                                    </span>

                                    <span class="dec-quick-text">
                                        Alimenter une caisse chantier
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="dec-quick-action">

                                <div class="dec-quick-action-icon dec-icon-blue">
                                    <i class="fas fa-print"></i>
                                </div>

                                <div>
                                    <span class="dec-quick-title">
                                        Journal
                                    </span>

                                    <span class="dec-quick-text">
                                        Imprimer le journal des décaissements
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="dec-quick-action">

                                <div class="dec-quick-action-icon dec-icon-green">
                                    <i class="fas fa-file-excel"></i>
                                </div>

                                <div>
                                    <span class="dec-quick-title">
                                        Exporter
                                    </span>

                                    <span class="dec-quick-text">
                                        Exporter les paiements vers Excel
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <?php

            $decaissementPeriod =
                isset($decaissementPeriod)
                ? (string) $decaissementPeriod
                : '6months';

            $decaissementEvolution =
                isset($decaissementEvolution)
                && is_array($decaissementEvolution)
                ? $decaissementEvolution
                : [];

            $decaissementChartLabels =
                isset(
                    $decaissementEvolution['labels']
                )
                && is_array(
                    $decaissementEvolution['labels']
                )
                ? $decaissementEvolution['labels']
                : [];

            $decaissementChartRealized =
                isset(
                    $decaissementEvolution['realized_amounts']
                )
                && is_array(
                    $decaissementEvolution['realized_amounts']
                )
                ? $decaissementEvolution['realized_amounts']
                : [];

            $decaissementChartPlanned =
                isset(
                    $decaissementEvolution['planned_amounts']
                )
                && is_array(
                    $decaissementEvolution['planned_amounts']
                )
                ? $decaissementEvolution['planned_amounts']
                : [];

            $decaissementChartCashbox =
                isset(
                    $decaissementEvolution['cashbox_amounts']
                )
                && is_array(
                    $decaissementEvolution['cashbox_amounts']
                )
                ? $decaissementEvolution['cashbox_amounts']
                : [];

            $decaissementChartBank =
                isset(
                    $decaissementEvolution['bank_amounts']
                )
                && is_array(
                    $decaissementEvolution['bank_amounts']
                )
                ? $decaissementEvolution['bank_amounts']
                : [];

            ?>

            <!-- =========================================================
                 GRAPHIQUE + CATÉGORIES
            ========================================================== -->
            <div class="row">

                <div class="col-xl-8 col-lg-8">

                    <div class="dec-card">

                        <div class="dec-card-header">

                            <div>

                                <h5 class="dec-card-title">
                                    <i class="fas fa-chart-line"></i>
                                    Évolution des décaissements
                                </h5>

                                <span class="dec-card-subtitle">
                                    Analyse comparative des paiements réalisés
                                    et du budget prévu.
                                </span>

                            </div>

                            <form action="<?= current_url() ?>" method="get" id="decaissementPeriodForm">

                                <select name="decaissement_period" id="decaissementPeriodSelect"
                                    class="form-control dec-period-select">

                                    <option value="6months" <?= $decaissementPeriod === '6months'
                                                                ? 'selected'
                                                                : ''
                                                            ?>>
                                        6 derniers mois
                                    </option>

                                    <option value="12months" <?= $decaissementPeriod === '12months'
                                                                    ? 'selected'
                                                                    : ''
                                                                ?>>
                                        12 derniers mois
                                    </option>

                                    <option value="current_year" <?= $decaissementPeriod === 'current_year'
                                                                        ? 'selected'
                                                                        : ''
                                                                    ?>>
                                        Cette année
                                    </option>

                                    <option value="previous_year" <?= $decaissementPeriod === 'previous_year'
                                                                        ? 'selected'
                                                                        : ''
                                                                    ?>>
                                        Année précédente
                                    </option>

                                </select>

                            </form>

                        </div>

                        <div class="dec-card-body">

                            <?php if (!empty($decaissementChartLabels)): ?>

                                <div class="dec-chart-container">
                                    <canvas id="decaissementChart"></canvas>
                                </div>

                            <?php else: ?>

                                <div class="text-center py-5">

                                    <i class="
                            fas
                            fa-chart-line
                            fa-3x
                            text-muted
                            mb-3
                        "></i>

                                    <h6>
                                        Aucune donnée disponible
                                    </h6>

                                    <p class="text-muted mb-0">
                                        Aucun décaissement n’a été enregistré
                                        durant cette période.
                                    </p>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <?php

                $totalRealized =
                    (float) (
                        $decaissementEvolution['total_realized']
                        ?? 0
                    );

                $totalPlanned =
                    (float) (
                        $decaissementEvolution['total_planned']
                        ?? 0
                    );

                $budgetDifference =
                    (float) (
                        $decaissementEvolution['budget_difference']
                        ?? 0
                    );

                $executionRate =
                    (float) (
                        $decaissementEvolution['budget_execution_rate']
                        ?? 0
                    );

                ?>

                <div class="col-xl-4 col-lg-4">

                    <div class="row mt-3">

                        <div class="col-md-4">

                            <div class="dec-chart-summary-item">

                                <span>
                                    Total réalisé
                                </span>

                                <strong class="text-danger">

                                    <?= number_format(
                                        $totalRealized,
                                        0,
                                        ',',
                                        ' '
                                    ) ?>

                                    BIF

                                </strong>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="dec-chart-summary-item">

                                <span>
                                    Budget prévu
                                </span>

                                <strong>

                                    <?= number_format(
                                        $totalPlanned,
                                        0,
                                        ',',
                                        ' '
                                    ) ?>

                                    BIF

                                </strong>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="dec-chart-summary-item">

                                <span>
                                    Taux d’exécution
                                </span>

                                <strong class="<?= $executionRate > 100
                                                    ? 'text-danger'
                                                    : 'text-success'
                                                ?>">

                                    <?= number_format(
                                        $executionRate,
                                        1,
                                        ',',
                                        ' '
                                    ) ?>

                                    %

                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- =========================================================
                 FILTRES
            ========================================================== -->
            <div class="dec-filter-box">

                <div class="row align-items-end">

                    <div class="col-xl-3 col-lg-3 col-md-6">

                        <div class="form-group mb-lg-0">

                            <label>Recherche</label>

                            <div class="input-group">

                                <input type="text" class="form-control" placeholder="Référence, bénéficiaire, pièce...">

                                <div class="input-group-append">
                                    <span class="input-group-text" style="border-radius: 0 8px 8px 0;">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6">

                        <div class="form-group mb-lg-0">

                            <label>Du</label>

                            <input type="date" class="form-control">

                        </div>

                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6">

                        <div class="form-group mb-lg-0">

                            <label>Au</label>

                            <input type="date" class="form-control">

                        </div>

                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6">

                        <div class="form-group mb-lg-0">

                            <label>Catégorie</label>

                            <select class="form-control">

                                <option value="">Toutes</option>
                                <option>Fournisseur</option>
                                <option>Salaire</option>
                                <option>Sous-traitant</option>
                                <option>Carburant</option>
                                <option>Impôt et taxe</option>
                                <option>Approvisionnement chantier</option>
                                <option>Autre charge</option>

                            </select>

                        </div>

                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-12">

                        <button class="btn btn-dec-primary mr-1">

                            <i class="fas fa-filter mr-1"></i>
                            Appliquer

                        </button>

                        <button class="btn btn-dec-outline">

                            <i class="fas fa-redo mr-1"></i>
                            Réinitialiser

                        </button>

                    </div>

                </div>

            </div>

            <?php

            $decaissementHistory =
                isset($decaissementHistory)
                && is_array($decaissementHistory)
                ? $decaissementHistory
                : [];

            $decaissementPagination =
                isset($decaissementPagination)
                && is_array($decaissementPagination)
                ? $decaissementPagination
                : [];

            $currentPage =
                isset(
                    $decaissementPagination['current_page']
                )
                ? (int) $decaissementPagination['current_page']
                : 1;

            $perPage =
                isset(
                    $decaissementPagination['per_page']
                )
                ? (int) $decaissementPagination['per_page']
                : 10;

            $totalRows =
                isset(
                    $decaissementPagination['total_rows']
                )
                ? (int) $decaissementPagination['total_rows']
                : 0;

            $totalPages =
                isset(
                    $decaissementPagination['total_pages']
                )
                ? (int) $decaissementPagination['total_pages']
                : 1;

            $offset =
                isset(
                    $decaissementPagination['offset']
                )
                ? (int) $decaissementPagination['offset']
                : 0;

            /*
 * Première ligne affichée.
 */
            $startRow =
                $totalRows > 0
                ? $offset + 1
                : 0;

            /*
 * Dernière ligne affichée.
 */
            $endRow =
                min(
                    $offset + $perPage,
                    $totalRows
                );

            /*
 * Fonction locale pour générer une URL de pagination
 * tout en conservant les autres paramètres GET.
 */
            if (!function_exists('buildDecaissementPageUrl')) {
                function buildDecaissementPageUrl(
                    int $page
                ): string {
                    $query = $_GET;

                    $query['page'] =
                        max(1, $page);

                    return current_url()
                        . '?'
                        . http_build_query($query);
                }
            }

            ?>

            <!-- =========================================================
     HISTORIQUE DES DÉCAISSEMENTS
========================================================== -->
            <div class="dec-card">

                <div class="dec-card-header">

                    <div>

                        <h5 class="dec-card-title">
                            <i class="fas fa-list"></i>
                            Historique des décaissements
                        </h5>

                        <span class="dec-card-subtitle">
                            Liste des sorties de fonds enregistrées
                            dans la trésorerie.
                        </span>

                    </div>

                    <button type="button" class="btn btn-dec-danger" data-toggle="modal"
                        data-target="#addDecaissementModal">
                        <i class="fas fa-plus mr-1"></i>
                        Nouveau décaissement
                    </button>

                </div>

                <div class="table-responsive">

                    <table class="table dec-table">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Référence</th>
                                <th>Bénéficiaire</th>
                                <th>Objet / Catégorie</th>
                                <th>Caisse</th>
                                <th>Mode</th>
                                <th>Pièce</th>
                                <th>Chantier</th>
                                <th class="text-right">
                                    Montant
                                </th>
                                <th>Statut</th>
                                <th class="text-center">
                                    Actions
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($decaissementHistory)): ?>

                                <?php foreach (
                                    $decaissementHistory
                                    as $index => $decaissement
                                ): ?>

                                    <?php

                                    /*
                         * =========================================
                         * NUMÉRO DE LIGNE
                         * =========================================
                         */

                                    $rowNumber =
                                        $offset
                                        + $index
                                        + 1;

                                    /*
                         * =========================================
                         * DATE ET HEURE
                         * =========================================
                         */

                                    $operationDate =
                                        !empty($decaissement
                                            ->operation_date)
                                        ? date(
                                            'd/m/Y',
                                            strtotime(
                                                $decaissement
                                                    ->operation_date
                                            )
                                        )
                                        : '—';

                                    $operationTime =
                                        !empty($decaissement
                                            ->created_at)
                                        ? date(
                                            'H:i',
                                            strtotime(
                                                $decaissement
                                                    ->created_at
                                            )
                                        )
                                        : null;

                                    /*
                         * =========================================
                         * BÉNÉFICIAIRE
                         * =========================================
                         */

                                    $beneficiary =
                                        !empty($decaissement
                                            ->third_party)
                                        ? $decaissement
                                        ->third_party
                                        : 'Bénéficiaire non renseigné';

                                    $beneficiaryDescription =
                                        !empty($decaissement
                                            ->category)
                                        ? $decaissement
                                        ->category
                                        : 'Décaissement de caisse';

                                    /*
                         * =========================================
                         * LIBELLÉ ET CATÉGORIE
                         * =========================================
                         */

                                    $operationLabel =
                                        !empty($decaissement
                                            ->label)
                                        ? $decaissement
                                        ->label
                                        : 'Décaissement';

                                    $operationCategory =
                                        !empty($decaissement
                                            ->category)
                                        ? $decaissement
                                        ->category
                                        : 'Non catégorisé';

                                    /*
                         * =========================================
                         * CAISSE
                         * =========================================
                         */

                                    $cashboxName =
                                        !empty($decaissement
                                            ->cashbox_name)
                                        ? $decaissement
                                        ->cashbox_name
                                        : 'Caisse non disponible';

                                    $cashboxCode =
                                        !empty($decaissement
                                            ->cashbox_code)
                                        ? $decaissement
                                        ->cashbox_code
                                        : '—';

                                    $cashboxTypeLabel =
                                        isset(
                                            $decaissement
                                                ->cashbox_type
                                        )
                                        && $decaissement
                                        ->cashbox_type
                                        === 'chantier'
                                        ? 'Caisse chantier'
                                        : 'Caisse siège';

                                    /*
                         * =========================================
                         * CHANTIER
                         * =========================================
                         */

                                    $chantierName =
                                        !empty($decaissement
                                            ->chantier_name)
                                        ? $decaissement
                                        ->chantier_name
                                        : 'Siège / Non affecté';

                                    /*
                         * =========================================
                         * MODE DE RÈGLEMENT
                         * =========================================
                         */

                                    $paymentMethod =
                                        !empty($decaissement
                                            ->payment_method)
                                        ? $decaissement
                                        ->payment_method
                                        : 'cash';

                                    $paymentMethodLabel =
                                        'Espèces';

                                    $paymentMethodIcon =
                                        'fas fa-money-bill-wave';

                                    $paymentMethodClass =
                                        'dec-mode-cash';

                                    switch ($paymentMethod) {
                                        case 'bank':
                                            $paymentMethodLabel =
                                                'Virement';

                                            $paymentMethodIcon =
                                                'fas fa-university';

                                            $paymentMethodClass =
                                                'dec-mode-bank';
                                            break;

                                        case 'cheque':
                                            $paymentMethodLabel =
                                                'Chèque';

                                            $paymentMethodIcon =
                                                'fas fa-money-check-alt';

                                            $paymentMethodClass =
                                                'dec-mode-cheque';
                                            break;

                                        case 'mobile':
                                            $paymentMethodLabel =
                                                'Mobile Money';

                                            $paymentMethodIcon =
                                                'fas fa-mobile-alt';

                                            $paymentMethodClass =
                                                'dec-mode-mobile';
                                            break;

                                        case 'cash':
                                        default:
                                            $paymentMethodLabel =
                                                'Espèces';

                                            $paymentMethodIcon =
                                                'fas fa-money-bill-wave';

                                            $paymentMethodClass =
                                                'dec-mode-cash';
                                            break;
                                    }

                                    /*
                         * =========================================
                         * PIÈCE
                         * =========================================
                         */

                                    $documentNumber =
                                        !empty($decaissement
                                            ->document_number)
                                        ? $decaissement
                                        ->document_number
                                        : 'Sans numéro';

                                    $hasAttachment =
                                        !empty($decaissement
                                            ->attachment);

                                    /*
                         * =========================================
                         * STATUT
                         * =========================================
                         */

                                    $status =
                                        !empty($decaissement
                                            ->status)
                                        ? $decaissement
                                        ->status
                                        : 'pending';

                                    $statusLabel =
                                        'En attente';

                                    $statusClass =
                                        'dec-status-pending';

                                    $statusIcon =
                                        'fas fa-clock';

                                    switch ($status) {
                                        case 'validated':
                                            $statusLabel =
                                                'Payé';

                                            $statusClass =
                                                'dec-status-valid';

                                            $statusIcon =
                                                'fas fa-check-circle';
                                            break;

                                        case 'cancelled':
                                        case 'rejected':
                                            $statusLabel =
                                                'Annulé';

                                            $statusClass =
                                                'dec-status-cancelled';

                                            $statusIcon =
                                                'fas fa-times-circle';
                                            break;

                                        case 'pending':
                                        default:
                                            $statusLabel =
                                                'En validation';

                                            $statusClass =
                                                'dec-status-pending';

                                            $statusIcon =
                                                'fas fa-clock';
                                            break;
                                    }

                                    ?>

                                    <tr>

                                        <td>
                                            <?= $rowNumber ?>
                                        </td>

                                        <td>

                                            <?= html_escape(
                                                $operationDate
                                            ) ?>

                                            <?php if (
                                                !empty($operationTime)
                                            ): ?>

                                                <small class="
                                            d-block
                                            text-muted
                                        ">
                                                    <?= html_escape(
                                                        $operationTime
                                                    ) ?>
                                                </small>

                                            <?php endif; ?>

                                        </td>

                                        <td>

                                            <span class="dec-reference">

                                                <?= html_escape(
                                                    $decaissement
                                                        ->reference
                                                        ?? '—'
                                                ) ?>

                                            </span>

                                        </td>

                                        <td class="dec-beneficiary">

                                            <strong>
                                                <?= html_escape(
                                                    $beneficiary
                                                ) ?>
                                            </strong>

                                            <small>
                                                <?= html_escape(
                                                    $beneficiaryDescription
                                                ) ?>
                                            </small>

                                        </td>

                                        <td class="dec-label">

                                            <strong>
                                                <?= html_escape(
                                                    $operationLabel
                                                ) ?>
                                            </strong>

                                            <small>
                                                <?= html_escape(
                                                    $operationCategory
                                                ) ?>
                                            </small>

                                        </td>

                                        <td>

                                            <strong>
                                                <?= html_escape(
                                                    $cashboxName
                                                ) ?>
                                            </strong>

                                            <small class="
                                        d-block
                                        text-muted
                                    ">
                                                <?= html_escape(
                                                    $cashboxTypeLabel
                                                ) ?>

                                                ·

                                                <?= html_escape(
                                                    $cashboxCode
                                                ) ?>
                                            </small>

                                        </td>

                                        <td>

                                            <span class="
                                        dec-badge
                                        <?= html_escape(
                                            $paymentMethodClass
                                        ) ?>
                                    ">

                                                <i class="
                                            <?= html_escape(
                                                $paymentMethodIcon
                                            ) ?>
                                            mr-1
                                        "></i>

                                                <?= html_escape(
                                                    $paymentMethodLabel
                                                ) ?>

                                            </span>

                                        </td>

                                        <td>

                                            <strong>
                                                <?= html_escape(
                                                    $documentNumber
                                                ) ?>
                                            </strong>

                                            <small class="
                                        d-block
                                        text-muted
                                    ">

                                                <?= $hasAttachment
                                                    ? 'Pièce jointe'
                                                    : 'Aucun justificatif'
                                                ?>

                                            </small>

                                        </td>

                                        <td>

                                            <?= html_escape(
                                                $chantierName
                                            ) ?>

                                            <?php if (
                                                !empty($decaissement
                                                    ->ref_chantier)
                                            ): ?>

                                                <small class="
                                            d-block
                                            text-muted
                                        ">
                                                    <?= html_escape(
                                                        $decaissement
                                                            ->ref_chantier
                                                    ) ?>
                                                </small>

                                            <?php endif; ?>

                                        </td>

                                        <td class="
                                    text-right
                                    dec-amount
                                ">
                                            -

                                            <?= number_format(
                                                (float) (
                                                    $decaissement
                                                    ->amount
                                                    ?? 0
                                                ),
                                                0,
                                                ',',
                                                ' '
                                            ) ?>

                                            <small class="
                                        d-block
                                        text-muted
                                    ">
                                                <?= html_escape(
                                                    $decaissement
                                                        ->currency
                                                        ?? 'BIF'
                                                ) ?>
                                            </small>

                                        </td>

                                        <td>

                                            <span class="
                                        dec-badge
                                        <?= html_escape(
                                            $statusClass
                                        ) ?>
                                    ">

                                                <i class="
                                            <?= html_escape(
                                                $statusIcon
                                            ) ?>
                                            mr-1
                                        "></i>

                                                <?= html_escape(
                                                    $statusLabel
                                                ) ?>

                                            </span>

                                        </td>

                                        <td class="text-center">

                                            <button type="button" class="
                                        dec-action-btn
                                        dec-action-view
                                    " title="Voir" onclick="viewDecaissement(
                                        <?= (int) $decaissement->id ?>
                                    )">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <?php if (
                                                $status !== 'validated'
                                            ): ?>

                                                <button type="button" class="
                                            dec-action-btn
                                            dec-action-edit
                                        " title="Modifier" onclick="editDecaissement(
                                            <?= (int) $decaissement->id ?>
                                        )">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                            <?php endif; ?>

                                            <?php if ($hasAttachment): ?>

                                                <a href="<?=
                                                            base_url(
                                                                'uploads/finance/cashbox_operations/'
                                                                    . rawurlencode(
                                                                        $decaissement
                                                                            ->attachment
                                                                    )
                                                            )
                                                            ?>" target="_blank" class="
                                            dec-action-btn
                                            dec-action-attachment
                                        " title="Voir le justificatif">
                                                    <i class="fas fa-paperclip"></i>
                                                </a>

                                            <?php endif; ?>

                                            <button type="button" class="
                                        dec-action-btn
                                        dec-action-print
                                    " title="Imprimer" onclick="printDecaissement(
                                        <?= (int) $decaissement->id ?>
                                    )">
                                                <i class="fas fa-print"></i>
                                            </button>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="12" class="text-center py-5">

                                        <div class="dec-empty-state">

                                            <i class="
                                        fas
                                        fa-money-bill-wave
                                        fa-3x
                                        text-muted
                                        mb-3
                                    "></i>

                                            <h6>
                                                Aucun décaissement trouvé
                                            </h6>

                                            <p class="text-muted mb-3">
                                                Aucun décaissement n’a encore
                                                été enregistré dans la trésorerie.
                                            </p>

                                            <button type="button" class="btn btn-dec-danger" data-toggle="modal"
                                                data-target="#addDecaissementModal">
                                                <i class="fas fa-plus mr-1"></i>
                                                Enregistrer un décaissement
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

                <!-- =====================================================
         PAGINATION
    ====================================================== -->
                <div class="
            p-3
            border-top
            d-flex
            justify-content-between
            align-items-center
            flex-wrap
        ">

                    <small class="text-muted">

                        Affichage de

                        <?= $startRow ?>

                        à

                        <?= $endRow ?>

                        sur

                        <?= $totalRows ?>

                        décaissement<?= $totalRows > 1
                                        ? 's'
                                        : ''
                                    ?>

                    </small>

                    <?php if ($totalPages > 1): ?>

                        <ul class="pagination pagination-sm mb-0">

                            <li class="
                        page-item
                        <?= $currentPage <= 1
                            ? 'disabled'
                            : ''
                        ?>
                    ">

                                <a class="page-link" href="<?= $currentPage > 1
                                                                ? html_escape(
                                                                    buildDecaissementPageUrl(
                                                                        $currentPage - 1
                                                                    )
                                                                )
                                                                : '#'
                                                            ?>">
                                    Précédent
                                </a>

                            </li>

                            <?php

                            $paginationStart =
                                max(
                                    1,
                                    $currentPage - 2
                                );

                            $paginationEnd =
                                min(
                                    $totalPages,
                                    $currentPage + 2
                                );

                            ?>

                            <?php if (
                                $paginationStart > 1
                            ): ?>

                                <li class="page-item">

                                    <a class="page-link" href="<?= html_escape(
                                                                    buildDecaissementPageUrl(1)
                                                                ) ?>">
                                        1
                                    </a>

                                </li>

                                <?php if (
                                    $paginationStart > 2
                                ): ?>

                                    <li class="
                                page-item
                                disabled
                            ">
                                        <span class="page-link">
                                            …
                                        </span>
                                    </li>

                                <?php endif; ?>

                            <?php endif; ?>

                            <?php for (
                                $pageNumber =
                                    $paginationStart;

                                $pageNumber <=
                                    $paginationEnd;

                                $pageNumber++
                            ): ?>

                                <li class="
                            page-item
                            <?= $pageNumber
                                    === $currentPage
                                    ? 'active'
                                    : ''
                            ?>
                        ">

                                    <a class="page-link" href="<?= html_escape(
                                                                    buildDecaissementPageUrl(
                                                                        $pageNumber
                                                                    )
                                                                ) ?>">
                                        <?= $pageNumber ?>
                                    </a>

                                </li>

                            <?php endfor; ?>

                            <?php if (
                                $paginationEnd
                                < $totalPages
                            ): ?>

                                <?php if (
                                    $paginationEnd
                                    < $totalPages - 1
                                ): ?>

                                    <li class="
                                page-item
                                disabled
                            ">
                                        <span class="page-link">
                                            …
                                        </span>
                                    </li>

                                <?php endif; ?>

                                <li class="page-item">

                                    <a class="page-link" href="<?= html_escape(
                                                                    buildDecaissementPageUrl(
                                                                        $totalPages
                                                                    )
                                                                ) ?>">
                                        <?= $totalPages ?>
                                    </a>

                                </li>

                            <?php endif; ?>

                            <li class="
                        page-item
                        <?= $currentPage
                            >= $totalPages
                            ? 'disabled'
                            : ''
                        ?>
                    ">

                                <a class="page-link" href="<?= $currentPage
                                                                < $totalPages
                                                                ? html_escape(
                                                                    buildDecaissementPageUrl(
                                                                        $currentPage + 1
                                                                    )
                                                                )
                                                                : '#'
                                                            ?>">
                                    Suivant
                                </a>

                            </li>

                        </ul>

                    <?php endif; ?>

                </div>

            </div>

            <?php

            $decaissementChantierSummary =
                isset($decaissementChantierSummary)
                && is_array($decaissementChantierSummary)
                ? $decaissementChantierSummary
                : [];

            $chantierSummaryStartDate =
                isset($chantierSummaryStartDate)
                ? $chantierSummaryStartDate
                : date('Y-m-01');

            $chantierSummaryEndDate =
                isset($chantierSummaryEndDate)
                ? $chantierSummaryEndDate
                : date('Y-m-t');

            ?>

            <!-- =========================================================
     SYNTHÈSE DES DÉCAISSEMENTS PAR CHANTIER
========================================================== -->
            <div class="row">

                <div class="col-xl-12 col-lg-12">

                    <div class="dec-card">

                        <div class="dec-card-header">

                            <div>

                                <h5 class="dec-card-title">
                                    <i class="fas fa-hard-hat"></i>
                                    Synthèse des décaissements par chantier
                                </h5>

                                <span class="dec-card-subtitle">

                                    Comparaison entre le budget du chantier
                                    et les décaissements validés du

                                    <strong>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime(
                                                $chantierSummaryStartDate
                                            )
                                        ) ?>
                                    </strong>

                                    au

                                    <strong>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime(
                                                $chantierSummaryEndDate
                                            )
                                        ) ?>
                                    </strong>.

                                </span>

                            </div>

                            <form method="get" action="<?= current_url() ?>" class="
                        d-flex
                        align-items-end
                        flex-wrap
                    ">

                                <?php foreach ($_GET as $key => $value): ?>

                                    <?php if (
                                        !in_array(
                                            $key,
                                            [
                                                'chantier_start_date',
                                                'chantier_end_date',
                                                'page',
                                            ],
                                            true
                                        )
                                    ): ?>

                                        <input type="hidden" name="<?= html_escape($key) ?>" value="<?= html_escape($value) ?>">

                                    <?php endif; ?>

                                <?php endforeach; ?>

                                <div class="form-group mb-0 mr-2">

                                    <label class="
                                small
                                text-muted
                                mb-1
                            ">
                                        Du
                                    </label>

                                    <input type="date" name="chantier_start_date" class="
                                form-control
                                form-control-sm
                            " value="<?= html_escape(
                                            $chantierSummaryStartDate
                                        ) ?>">

                                </div>

                                <div class="form-group mb-0 mr-2">

                                    <label class="
                                small
                                text-muted
                                mb-1
                            ">
                                        Au
                                    </label>

                                    <input type="date" name="chantier_end_date" class="
                                form-control
                                form-control-sm
                            " value="<?= html_escape(
                                            $chantierSummaryEndDate
                                        ) ?>">

                                </div>

                                <button type="submit" class="
                            btn
                            btn-sm
                            btn-dec-danger
                        ">
                                    <i class="fas fa-filter mr-1"></i>
                                    Appliquer
                                </button>

                            </form>

                        </div>

                        <div class="table-responsive">

                            <table class="table dec-table">

                                <thead>

                                    <tr>
                                        <th>Chantier</th>

                                        <th class="text-right">
                                            Budget
                                        </th>

                                        <th class="text-right">
                                            Décaissé
                                        </th>

                                        <th class="text-right">
                                            Disponible
                                        </th>

                                        <th class="text-center">
                                            Opérations
                                        </th>

                                        <th>
                                            Consommation
                                        </th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php if (
                                        !empty($decaissementChantierSummary)
                                    ): ?>

                                        <?php foreach (
                                            $decaissementChantierSummary
                                            as $chantierSummary
                                        ): ?>

                                            <?php

                                            $budget =
                                                (float) (
                                                    $chantierSummary
                                                    ->budget
                                                    ?? 0
                                                );

                                            $totalDisbursed =
                                                (float) (
                                                    $chantierSummary
                                                    ->total_disbursed
                                                    ?? 0
                                                );

                                            $available =
                                                (float) (
                                                    $chantierSummary
                                                    ->available
                                                    ?? 0
                                                );

                                            $consumptionPercentage =
                                                (float) (
                                                    $chantierSummary
                                                    ->consumption_percentage
                                                    ?? 0
                                                );

                                            $progressPercentage =
                                                (float) (
                                                    $chantierSummary
                                                    ->progress_percentage
                                                    ?? 0
                                                );

                                            $progressClass =
                                                $chantierSummary
                                                ->progress_class
                                                ?? 'bg-success';

                                            /*
                                 * Couleur du montant disponible.
                                 */
                                            if ($available < 0) {
                                                $availableClass =
                                                    'text-danger';

                                                $availableLabel =
                                                    number_format(
                                                        abs($available),
                                                        0,
                                                        ',',
                                                        ' '
                                                    )
                                                    . ' dépassement';
                                            } elseif (
                                                $consumptionPercentage
                                                >= 90
                                            ) {
                                                $availableClass =
                                                    'text-danger';

                                                $availableLabel =
                                                    number_format(
                                                        $available,
                                                        0,
                                                        ',',
                                                        ' '
                                                    );
                                            } elseif (
                                                $consumptionPercentage
                                                >= 75
                                            ) {
                                                $availableClass =
                                                    'text-warning';

                                                $availableLabel =
                                                    number_format(
                                                        $available,
                                                        0,
                                                        ',',
                                                        ' '
                                                    );
                                            } else {
                                                $availableClass =
                                                    'text-success';

                                                $availableLabel =
                                                    number_format(
                                                        $available,
                                                        0,
                                                        ',',
                                                        ' '
                                                    );
                                            }

                                            ?>

                                            <tr>

                                                <td>

                                                    <strong>
                                                        <?= html_escape(
                                                            $chantierSummary
                                                                ->name
                                                                ?? 'Chantier'
                                                        ) ?>
                                                    </strong>

                                                    <small class="
                                                d-block
                                                text-muted
                                            ">
                                                        <?= html_escape(
                                                            $chantierSummary
                                                                ->ref_chantier
                                                                ?? 'Sans référence'
                                                        ) ?>

                                                        <?php if (
                                                            !empty($chantierSummary
                                                                ->location)
                                                        ): ?>

                                                            ·

                                                            <?= html_escape(
                                                                $chantierSummary
                                                                    ->location
                                                            ) ?>

                                                        <?php endif; ?>

                                                    </small>

                                                </td>

                                                <td class="text-right">

                                                    <strong>

                                                        <?= number_format(
                                                            $budget,
                                                            0,
                                                            ',',
                                                            ' '
                                                        ) ?>

                                                    </strong>

                                                    <small class="
                                                d-block
                                                text-muted
                                            ">
                                                        BIF
                                                    </small>

                                                </td>

                                                <td class="
                                            text-right
                                            dec-amount
                                        ">

                                                    <strong>

                                                        <?= number_format(
                                                            $totalDisbursed,
                                                            0,
                                                            ',',
                                                            ' '
                                                        ) ?>

                                                    </strong>

                                                    <small class="
                                                d-block
                                                text-muted
                                            ">
                                                        BIF
                                                    </small>

                                                </td>

                                                <td class="
                                            text-right
                                            font-weight-bold
                                            <?= html_escape(
                                                $availableClass
                                            ) ?>
                                        ">

                                                    <?= html_escape(
                                                        $availableLabel
                                                    ) ?>

                                                    <?php if (
                                                        $available >= 0
                                                    ): ?>

                                                        <small class="
                                                    d-block
                                                    text-muted
                                                ">
                                                            BIF
                                                        </small>

                                                    <?php endif; ?>

                                                </td>

                                                <td class="text-center">

                                                    <span class="
                                                badge
                                                badge-light
                                                border
                                                px-2
                                                py-1
                                            ">
                                                        <?= (int) (
                                                            $chantierSummary
                                                            ->operation_count
                                                            ?? 0
                                                        ) ?>
                                                    </span>

                                                </td>

                                                <td style="min-width: 180px;">

                                                    <?php if ($budget > 0): ?>

                                                        <div class="
                                                    progress
                                                    progress-xs
                                                    mb-1
                                                ">

                                                            <div class="
                                                        progress-bar
                                                        <?= html_escape(
                                                            $progressClass
                                                        ) ?>
                                                    " role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                                                aria-valuenow="<?=
                                                                                number_format(
                                                                                    $progressPercentage,
                                                                                    2,
                                                                                    '.',
                                                                                    ''
                                                                                )
                                                                                ?>" style="width: <?=
                                                                                                    number_format(
                                                                                                        $progressPercentage,
                                                                                                        2,
                                                                                                        '.',
                                                                                                        ''
                                                                                                    )
                                                                                                    ?>%;"></div>

                                                        </div>

                                                        <small class="
                                                    d-flex
                                                    justify-content-between
                                                ">

                                                            <span>

                                                                <?= number_format(
                                                                    $consumptionPercentage,
                                                                    1,
                                                                    ',',
                                                                    ' '
                                                                ) ?>

                                                                %

                                                            </span>

                                                            <?php if (
                                                                $consumptionPercentage
                                                                > 100
                                                            ): ?>

                                                                <span class="
                                                            text-danger
                                                            font-weight-bold
                                                        ">
                                                                    Budget dépassé
                                                                </span>

                                                            <?php elseif (
                                                                $consumptionPercentage
                                                                >= 90
                                                            ): ?>

                                                                <span class="
                                                            text-danger
                                                            font-weight-bold
                                                        ">
                                                                    Critique
                                                                </span>

                                                            <?php elseif (
                                                                $consumptionPercentage
                                                                >= 75
                                                            ): ?>

                                                                <span class="
                                                            text-warning
                                                            font-weight-bold
                                                        ">
                                                                    Attention
                                                                </span>

                                                            <?php else: ?>

                                                                <span class="text-muted">
                                                                    Normal
                                                                </span>

                                                            <?php endif; ?>

                                                        </small>

                                                    <?php else: ?>

                                                        <span class="
                                                    badge
                                                    badge-secondary
                                                ">
                                                            Budget non défini
                                                        </span>

                                                        <?php if (
                                                            $totalDisbursed > 0
                                                        ): ?>

                                                            <small class="
                                                        d-block
                                                        text-danger
                                                        mt-1
                                                    ">
                                                                Décaissements sans budget
                                                            </small>

                                                        <?php endif; ?>

                                                    <?php endif; ?>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    <?php else: ?>

                                        <tr>

                                            <td colspan="6" class="
                                        text-center
                                        py-5
                                    ">

                                                <i class="
                                            fas
                                            fa-hard-hat
                                            fa-3x
                                            text-muted
                                            mb-3
                                        "></i>

                                                <h6>
                                                    Aucune synthèse disponible
                                                </h6>

                                                <p class="text-muted mb-0">
                                                    Aucun chantier actif n’a été
                                                    trouvé pour cette période.
                                                </p>

                                            </td>

                                        </tr>

                                    <?php endif; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

</div>

<style>
    /* =========================================================
   MODAL DÉCAISSEMENT — STYLE BORDEAUX
========================================================= */

    :root {
        --dec-primary: #7f1d1d;
        --dec-primary-dark: #5f1515;
        --dec-primary-soft: #fef2f2;
        --dec-primary-soft-2: #fee2e2;
        --dec-border: #fecaca;
        --dec-text: #1f2937;
        --dec-muted: #64748b;
        --dec-white: #ffffff;
        --dec-input-border: #cbd5e1;
        --dec-balance-bg: #fff7f7;
    }

    /* Taille et position */
    #addDecaissementModal .modal-dialog {
        max-width: 1050px;
        width: calc(100% - 30px);
    }

    #addDecaissementModal .modal-content {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.28);
    }

    /* =========================================================
   HEADER
========================================================= */

    #addDecaissementModal .modal-header {
        padding: 17px 20px;
        border-bottom: 0;
        background: linear-gradient(135deg,
                var(--dec-primary) 0%,
                var(--dec-primary-dark) 58%,
                #2b1020 100%);
        color: var(--dec-white);
    }

    #addDecaissementModal .modal-title {
        display: flex;
        align-items: center;
        margin: 0;
        color: var(--dec-white);
        font-size: 17px;
        font-weight: 700;
        letter-spacing: 0.1px;
    }

    #addDecaissementModal .modal-title i {
        font-size: 15px;
        color: #fecaca;
    }

    #addDecaissementModal .close {
        padding: 0;
        margin: 0;
        color: var(--dec-white);
        opacity: 1;
        text-shadow: none;
        font-size: 24px;
        line-height: 1;
    }

    #addDecaissementModal .close:hover {
        color: #fecaca;
        opacity: 1;
    }

    /* =========================================================
   BODY
========================================================= */

    #addDecaissementModal .modal-body {
        padding: 22px 20px 10px;
        background: #ffffff;
    }

    #addDecaissementModal .row {
        margin-left: -7px;
        margin-right: -7px;
    }

    #addDecaissementModal .row>[class*="col-"] {
        padding-left: 7px;
        padding-right: 7px;
    }

    #addDecaissementModal .form-group {
        margin-bottom: 17px;
    }

    #addDecaissementModal label {
        display: block;
        margin-bottom: 7px;
        color: var(--dec-text);
        font-size: 12px;
        font-weight: 700;
    }

    #addDecaissementModal .required-star {
        color: #dc2626;
    }

    /* =========================================================
   CHAMPS
========================================================= */

    #addDecaissementModal .form-control {
        min-height: 42px;
        border: 1px solid var(--dec-input-border);
        border-radius: 8px;
        background: #ffffff;
        color: var(--dec-text);
        font-size: 13px;
        box-shadow: none;
        transition: all 0.2s ease;
    }

    #addDecaissementModal textarea.form-control {
        min-height: 95px;
        resize: vertical;
        padding-top: 11px;
    }

    #addDecaissementModal .form-control::placeholder {
        color: #94a3b8;
    }

    #addDecaissementModal .form-control:focus {
        border-color: var(--dec-primary);
        box-shadow: 0 0 0 3px rgba(127, 29, 29, 0.12);
    }

    #addDecaissementModal select.form-control {
        cursor: pointer;
    }

    #addDecaissementModal .input-group-text {
        min-width: 48px;
        justify-content: center;
        border: 1px solid var(--dec-input-border);
        border-left: 0;
        border-radius: 0 8px 8px 0;
        background: #eef2f7;
        color: #475569;
        font-weight: 600;
    }

    /* =========================================================
   SOLDE DISPONIBLE
========================================================= */

    #addDecaissementModal .dec-balance-box {
        min-height: 91px;
        margin-top: 25px;
        padding: 13px 14px;
        border: 1px solid var(--dec-border);
        border-radius: 9px;
        background: var(--dec-balance-bg);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    #addDecaissementModal .dec-balance-box small {
        margin-bottom: 5px;
        color: var(--dec-muted);
        font-size: 11px;
    }

    #addDecaissementModal .dec-balance-box strong {
        color: var(--dec-primary);
        font-size: 17px;
        font-weight: 800;
    }

    #addDecaissementModal #decCashboxCode {
        color: #7c2d2d;
        font-size: 11px;
    }

    /* Solde insuffisant */
    #addDecaissementModal .dec-balance-box.balance-danger {
        border-color: #ef4444;
        background: #fef2f2;
    }

    #addDecaissementModal .dec-balance-box.balance-danger strong {
        color: #dc2626;
    }

    /* =========================================================
   FILE INPUT
========================================================= */

    #addDecaissementModal .custom-file {
        height: 42px;
    }

    #addDecaissementModal .custom-file-input {
        height: 42px;
    }

    #addDecaissementModal .custom-file-label {
        height: 42px;
        padding: 10px 12px;
        border: 1px solid var(--dec-input-border);
        border-radius: 8px;
        color: #475569;
        font-size: 13px;
        font-weight: 500;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    #addDecaissementModal .custom-file-label::after {
        height: 40px;
        padding: 10px 16px;
        border-left: 1px solid var(--dec-input-border);
        border-radius: 0 8px 8px 0;
        background: #eef2f7;
        color: #334155;
        content: "Parcourir";
    }

    #addDecaissementModal .form-text {
        margin-top: 5px;
        color: var(--dec-muted);
        font-size: 11px;
    }

    /* =========================================================
   FOOTER
========================================================= */

    #addDecaissementModal .modal-footer {
        padding: 14px 20px;
        border-top: 1px solid #e5e7eb;
        background: #ffffff;
    }

    #addDecaissementModal .btn {
        min-height: 40px;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
    }

    /* Bouton annuler */
    #addDecaissementModal .btn-caisse-outline {
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #475569;
    }

    #addDecaissementModal .btn-caisse-outline:hover {
        border-color: var(--dec-primary);
        background: var(--dec-primary-soft);
        color: var(--dec-primary);
    }

    /* Bouton principal bordeaux */
    #addDecaissementModal .btn-caisse-primary {
        border: 1px solid var(--dec-primary);
        background: var(--dec-primary);
        color: #ffffff;
        box-shadow: 0 7px 18px rgba(127, 29, 29, 0.18);
    }

    #addDecaissementModal .btn-caisse-primary:hover {
        border-color: var(--dec-primary-dark);
        background: var(--dec-primary-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    #addDecaissementModal .btn-caisse-primary:disabled {
        opacity: 0.7;
        transform: none;
        cursor: not-allowed;
    }

    /* =========================================================
   RESPONSIVE
========================================================= */

    @media (max-width: 991.98px) {
        #addDecaissementModal .modal-dialog {
            max-width: calc(100% - 20px);
            margin: 10px auto;
        }

        #addDecaissementModal .modal-body {
            max-height: calc(100vh - 150px);
            overflow-y: auto;
        }

        #addDecaissementModal .dec-balance-box {
            margin-top: 0;
        }
    }

    @media (max-width: 767.98px) {
        #addDecaissementModal .modal-dialog {
            width: calc(100% - 12px);
            margin: 6px auto;
        }

        #addDecaissementModal .modal-header {
            padding: 14px 15px;
        }

        #addDecaissementModal .modal-title {
            font-size: 15px;
        }

        #addDecaissementModal .modal-body {
            padding: 17px 15px 7px;
        }

        #addDecaissementModal .modal-footer {
            padding: 12px 15px;
            flex-direction: column-reverse;
            align-items: stretch;
        }

        #addDecaissementModal .modal-footer .btn {
            width: 100%;
            margin: 4px 0;
        }
    }
</style>

<!-- =========================================================
     MODALE : NOUVEAU DÉCAISSEMENT
========================================================== -->
<div class="modal fade modal-caisse" id="addDecaissementModal" tabindex="-1" role="dialog"
    aria-labelledby="addDecaissementModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">

        <form action="<?= base_url('cashbox-operation-store') ?>" method="post" enctype="multipart/form-data"
            id="decaissementForm" style="width: 100%;">

            <div class="modal-content">

                <!-- =================================================
                     ENTÊTE
                ================================================== -->
                <div class="modal-header">

                    <h5 class="modal-title" id="addDecaissementModalLabel">
                        <i class="fas fa-exchange-alt mr-2"></i>

                        Enregistrer un décaissement
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>

                </div>

                <!-- =================================================
                     CONTENU
                ================================================== -->
                <div class="modal-body">

                    <!-- Type d'opération transmis au contrôleur -->
                    <input type="hidden" name="operation_type" value="decaissement">

                    <div class="row">

                        <!-- Date -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="decOperationDate">

                                    Date de l’opération

                                    <span class="required-star">
                                        *
                                    </span>

                                </label>

                                <input type="date" name="operation_date" id="decOperationDate" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required>

                            </div>

                        </div>

                        <!-- Caisse -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="decCashboxId">

                                    Caisse concernée

                                    <span class="required-star">
                                        *
                                    </span>

                                </label>

                                <select name="cashbox_id" id="decCashboxId" class="form-control"
                                    onchange="updateDecaissementCashboxInfo()" required>

                                    <option value="">
                                        Sélectionner la caisse
                                    </option>

                                    <?php if (!empty($allCashboxes)): ?>

                                        <?php foreach (
                                            $allCashboxes
                                            as $cashbox
                                        ): ?>

                                            <option value="<?= (int) $cashbox->id ?>"
                                                data-balance="<?= (float) $cashbox->current_balance ?>"
                                                data-currency="<?= html_escape($cashbox->devise) ?>"
                                                data-code="<?= html_escape($cashbox->code) ?>"
                                                data-type="<?= html_escape($cashbox->type) ?>">

                                                <?= html_escape($cashbox->code) ?>

                                                —

                                                <?= html_escape($cashbox->name) ?>

                                                —

                                                <?= number_format(
                                                    (float) $cashbox->current_balance,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) ?>

                                                <?= html_escape($cashbox->devise) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </select>

                                <small class="form-text text-muted">

                                    La caisse sélectionnée sera débitée.

                                </small>

                            </div>

                        </div>

                        <!-- Montant -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="decAmount">

                                    Montant

                                    <span class="required-star">
                                        *
                                    </span>

                                </label>

                                <div class="input-group">

                                    <input type="number" name="amount" id="decAmount" class="form-control" min="0.01"
                                        step="0.01" placeholder="0" required>

                                    <div class="input-group-append">

                                        <span class="input-group-text" id="decCurrencyLabel">
                                            BIF
                                        </span>

                                    </div>

                                </div>

                                <small class="form-text" id="decAmountHelp">
                                    Le montant doit être supérieur à zéro.
                                </small>

                            </div>

                        </div>

                        <!-- Solde disponible -->
                        <div class="col-md-4">

                            <div class="dec-balance-box">

                                <small>
                                    Solde disponible
                                </small>

                                <strong id="decAvailableBalance">
                                    0 BIF
                                </strong>

                                <span class="d-block mt-1" id="decCashboxCode">
                                    Aucune caisse sélectionnée
                                </span>

                            </div>

                        </div>

                        <!-- Catégorie -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="decCategory">
                                    Catégorie
                                </label>

                                <select name="category" id="decCategory" class="form-control">

                                    <option value="">
                                        Sélectionner
                                    </option>

                                    <option value="Fournitures">
                                        Fournitures
                                    </option>

                                    <option value="Carburant">
                                        Carburant
                                    </option>

                                    <option value="Main-d’œuvre">
                                        Main-d’œuvre
                                    </option>

                                    <option value="Salaire">
                                        Salaire
                                    </option>

                                    <option value="Sous-traitance">
                                        Sous-traitance
                                    </option>

                                    <option value="Maintenance engin">
                                        Maintenance engin
                                    </option>

                                    <option value="Transport">
                                        Transport
                                    </option>

                                    <option value="Impôts et taxes">
                                        Impôts et taxes
                                    </option>

                                    <option value="Remboursement emprunt">
                                        Remboursement emprunt
                                    </option>

                                    <option value="Achat de matériaux">
                                        Achat de matériaux
                                    </option>

                                    <option value="Charges diverses">
                                        Charges diverses
                                    </option>

                                    <option value="Autre">
                                        Autre
                                    </option>

                                </select>

                            </div>

                        </div>

                        <!-- Bénéficiaire -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="decThirdParty">
                                    Bénéficiaire
                                </label>

                                <input type="text" name="third_party" id="decThirdParty" class="form-control"
                                    placeholder="Nom du fournisseur ou bénéficiaire">

                            </div>

                        </div>

                        <!-- Mode de règlement -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="decPaymentMethod">
                                    Mode de règlement
                                </label>

                                <select name="payment_method" id="decPaymentMethod" class="form-control">

                                    <option value="cash">
                                        Espèces
                                    </option>

                                    <option value="bank">
                                        Virement bancaire
                                    </option>

                                    <option value="cheque">
                                        Chèque
                                    </option>

                                    <option value="mobile">
                                        Mobile Money
                                    </option>

                                </select>

                            </div>

                        </div>

                        <!-- Numéro de pièce -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="decDocumentNumber">
                                    Numéro de pièce
                                </label>

                                <input type="text" name="document_number" id="decDocumentNumber" class="form-control"
                                    placeholder="Facture, reçu, bon...">

                            </div>

                        </div>

                        <!-- Pièce justificative -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="decAttachment">
                                    Pièce justificative
                                </label>

                                <div class="custom-file">

                                    <input type="file" name="attachment" id="decAttachment" class="custom-file-input"
                                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">

                                    <label class="custom-file-label" for="decAttachment">
                                        Choisir un fichier
                                    </label>

                                </div>

                                <small class="form-text text-muted">

                                    PDF, image, Word ou Excel — maximum 5 Mo.

                                </small>

                            </div>

                        </div>

                        <!-- Libellé -->
                        <div class="col-md-12">

                            <div class="form-group">

                                <label for="decLabel">

                                    Libellé du décaissement

                                    <span class="required-star">
                                        *
                                    </span>

                                </label>

                                <input type="text" name="label" id="decLabel" class="form-control"
                                    placeholder="Ex. Paiement facture carburant juillet" maxlength="255" required>

                            </div>

                        </div>

                        <!-- Observation -->
                        <div class="col-md-12">

                            <div class="form-group mb-0">

                                <label for="decObservation">
                                    Observation
                                </label>

                                <textarea name="observation" id="decObservation" class="form-control" rows="4"
                                    placeholder="Informations complémentaires sur l’opération..."></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- =================================================
                     PIED DU MODAL
                ================================================== -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-caisse-outline" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-caisse-primary" id="saveDecaissementButton">
                        <i class="fas fa-check-circle mr-1"></i>
                        Enregistrer l’opération
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- =========================================================
     SCRIPTS
========================================================== -->
<script>
    document.addEventListener(
        'DOMContentLoaded',
        function() {

            /*
             * =====================================================
             * CHANGEMENT DE PÉRIODE
             * =====================================================
             */

            const periodForm =
                document.getElementById(
                    'decaissementPeriodForm'
                );

            const periodSelect =
                document.getElementById(
                    'decaissementPeriodSelect'
                );

            if (
                periodForm &&
                periodSelect
            ) {
                periodSelect.addEventListener(
                    'change',
                    function() {
                        periodForm.submit();
                    }
                );
            }

            /*
             * =====================================================
             * DONNÉES PHP VERS JAVASCRIPT
             * =====================================================
             */

            const chartLabels =
                <?= json_encode(
                    $decaissementChartLabels,
                    JSON_UNESCAPED_UNICODE
                        | JSON_UNESCAPED_SLASHES
                ) ?>;

            const realizedAmounts =
                <?= json_encode(
                    array_map(
                        'floatval',
                        $decaissementChartRealized
                    )
                ) ?>;

            const plannedAmounts =
                <?= json_encode(
                    array_map(
                        'floatval',
                        $decaissementChartPlanned
                    )
                ) ?>;

            const cashboxAmounts =
                <?= json_encode(
                    array_map(
                        'floatval',
                        $decaissementChartCashbox
                    )
                ) ?>;

            const bankAmounts =
                <?= json_encode(
                    array_map(
                        'floatval',
                        $decaissementChartBank
                    )
                ) ?>;

            /*
             * =====================================================
             * CRÉATION DU GRAPHIQUE
             * =====================================================
             */

            const canvas =
                document.getElementById(
                    'decaissementChart'
                );

            if (
                !canvas ||
                typeof Chart === 'undefined'
            ) {
                return;
            }

            const ctx =
                canvas.getContext('2d');

            const gradientExpense =
                ctx.createLinearGradient(
                    0,
                    0,
                    0,
                    300
                );

            gradientExpense.addColorStop(
                0,
                'rgba(127, 29, 29, 0.30)'
            );

            gradientExpense.addColorStop(
                1,
                'rgba(127, 29, 29, 0.02)'
            );

            new Chart(
                ctx, {
                    type: 'line',

                    data: {
                        labels: chartLabels,

                        datasets: [{
                                label: 'Décaissements réalisés',

                                data: realizedAmounts,

                                borderColor: '#991b1b',

                                backgroundColor: gradientExpense,

                                borderWidth: 2.5,

                                pointRadius: 4,

                                pointHoverRadius: 6,

                                pointBackgroundColor: '#ffffff',

                                pointBorderColor: '#991b1b',

                                pointBorderWidth: 2,

                                fill: true,

                                tension: 0.35
                            },
                            {
                                label: 'Budget prévu',

                                data: plannedAmounts,

                                borderColor: '#0f766e',

                                backgroundColor: 'transparent',

                                borderWidth: 2,

                                borderDash: [6, 6],

                                pointRadius: 0,

                                pointHoverRadius: 4,

                                fill: false,

                                tension: 0.25
                            }
                        ]
                    },

                    options: {
                        responsive: true,

                        maintainAspectRatio: false,

                        interaction: {
                            intersect: false,

                            mode: 'index'
                        },

                        plugins: {
                            legend: {
                                position: 'bottom',

                                labels: {
                                    usePointStyle: true,

                                    boxWidth: 8,

                                    padding: 20,

                                    font: {
                                        size: 11
                                    }
                                }
                            },

                            tooltip: {
                                callbacks: {
                                    label: function(
                                        context
                                    ) {
                                        return (
                                            context.dataset.label +
                                            ' : ' +
                                            new Intl
                                            .NumberFormat(
                                                'fr-FR'
                                            )
                                            .format(
                                                context.parsed.y
                                            ) +
                                            ' BIF'
                                        );
                                    },

                                    afterBody: function(
                                        tooltipItems
                                    ) {
                                        if (
                                            !tooltipItems.length
                                        ) {
                                            return '';
                                        }

                                        const index =
                                            tooltipItems[0]
                                            .dataIndex;

                                        const cashAmount =
                                            cashboxAmounts[index] ||
                                            0;

                                        const bankAmount =
                                            bankAmounts[index] ||
                                            0;

                                        return [
                                            '',
                                            'Caisses : ' +
                                            new Intl
                                            .NumberFormat(
                                                'fr-FR'
                                            )
                                            .format(
                                                cashAmount
                                            ) +
                                            ' BIF',

                                            'Banques : ' +
                                            new Intl
                                            .NumberFormat(
                                                'fr-FR'
                                            )
                                            .format(
                                                bankAmount
                                            ) +
                                            ' BIF'
                                        ];
                                    }
                                }
                            }
                        },

                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },

                                ticks: {
                                    font: {
                                        size: 10
                                    }
                                }
                            },

                            y: {
                                beginAtZero: true,

                                grid: {
                                    color: 'rgba(148, 163, 184, 0.15)'
                                },

                                ticks: {
                                    font: {
                                        size: 10
                                    },

                                    callback: function(
                                        value
                                    ) {
                                        if (
                                            Math.abs(value) >=
                                            1000000000
                                        ) {
                                            return (
                                                    value /
                                                    1000000000
                                                ).toFixed(1) +
                                                ' Md';
                                        }

                                        return (
                                                value /
                                                1000000
                                            ).toFixed(0) +
                                            ' M';
                                    }
                                }
                            }
                        }
                    }
                }
            );
        }
    );
</script>

<script>
    function checkDecaissementBalance() {

        const cashboxSelect =
            document.getElementById('decCashboxId');

        const amountInput =
            document.getElementById('decAmount');

        const balanceBox =
            document.querySelector(
                '#addDecaissementModal .dec-balance-box'
            );

        const amountHelp =
            document.getElementById('decAmountHelp');

        if (
            !cashboxSelect ||
            !amountInput ||
            !balanceBox
        ) {
            return;
        }

        const selectedOption =
            cashboxSelect.options[
                cashboxSelect.selectedIndex
            ];

        const availableBalance =
            selectedOption && selectedOption.value ?
            parseFloat(
                selectedOption.dataset.balance || 0
            ) :
            0;

        const amount =
            parseFloat(
                amountInput.value || 0
            );

        balanceBox.classList.remove(
            'balance-danger'
        );

        amountInput.classList.remove(
            'is-invalid'
        );

        if (
            selectedOption &&
            selectedOption.value &&
            amount > availableBalance
        ) {
            balanceBox.classList.add(
                'balance-danger'
            );

            amountInput.classList.add(
                'is-invalid'
            );

            if (amountHelp) {
                amountHelp.textContent =
                    'Le montant dépasse le solde disponible.';

                amountHelp.style.color =
                    '#dc2626';
            }

            return;
        }

        if (amountHelp) {
            amountHelp.textContent =
                'Le montant doit être supérieur à zéro.';

            amountHelp.style.color =
                '';
        }
    }

    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const cashboxSelect =
                document.getElementById(
                    'decCashboxId'
                );

            const amountInput =
                document.getElementById(
                    'decAmount'
                );

            if (cashboxSelect) {
                cashboxSelect.addEventListener(
                    'change',
                    function() {
                        updateDecaissementCashboxInfo();
                        checkDecaissementBalance();
                    }
                );
            }

            if (amountInput) {
                amountInput.addEventListener(
                    'input',
                    checkDecaissementBalance
                );
            }

        }
    );
</script>

<script>
    function updateDecaissementCashboxInfo() {

        const cashboxSelect =
            document.getElementById('decCashboxId');

        const balanceElement =
            document.getElementById('decAvailableBalance');

        const codeElement =
            document.getElementById('decCashboxCode');

        const currencyElement =
            document.getElementById('decCurrencyLabel');

        const amountInput =
            document.getElementById('decAmount');

        if (
            !cashboxSelect ||
            !balanceElement ||
            !codeElement ||
            !currencyElement
        ) {
            return;
        }

        const selectedOption =
            cashboxSelect.options[
                cashboxSelect.selectedIndex
            ];

        if (
            !selectedOption ||
            !selectedOption.value
        ) {
            balanceElement.textContent =
                '0 BIF';

            codeElement.textContent =
                'Aucune caisse sélectionnée';

            currencyElement.textContent =
                'BIF';

            if (amountInput) {
                amountInput.removeAttribute('max');
            }

            return;
        }

        const balance = parseFloat(
            selectedOption.dataset.balance || 0
        );

        const currency =
            selectedOption.dataset.currency || 'BIF';

        const code =
            selectedOption.dataset.code || '';

        balanceElement.textContent =
            new Intl.NumberFormat('fr-FR').format(
                balance
            ) +
            ' ' +
            currency;

        codeElement.textContent =
            code;

        currencyElement.textContent =
            currency;

        /*
         * Empêcher l’utilisateur de saisir un montant
         * supérieur au solde disponible.
         */
        if (amountInput) {
            amountInput.max = balance;
        }
    }

    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const decaissementForm =
                document.getElementById(
                    'decaissementForm'
                );

            const amountInput =
                document.getElementById(
                    'decAmount'
                );

            const cashboxSelect =
                document.getElementById(
                    'decCashboxId'
                );

            const submitButton =
                document.getElementById(
                    'saveDecaissementButton'
                );

            if (decaissementForm) {

                decaissementForm.addEventListener(
                    'submit',
                    function(event) {

                        const selectedOption =
                            cashboxSelect ?
                            cashboxSelect.options[
                                cashboxSelect.selectedIndex
                            ] :
                            null;

                        const balance =
                            selectedOption ?
                            parseFloat(
                                selectedOption.dataset.balance ||
                                0
                            ) :
                            0;

                        const amount =
                            amountInput ?
                            parseFloat(
                                amountInput.value ||
                                0
                            ) :
                            0;

                        if (amount <= 0) {
                            event.preventDefault();

                            Swal.fire({
                                icon: 'warning',
                                title: 'Montant invalide',
                                text: 'Le montant doit être supérieur à zéro.',
                                confirmButtonText: 'Corriger'
                            });

                            return;
                        }

                        if (amount > balance) {
                            event.preventDefault();

                            Swal.fire({
                                icon: 'error',
                                title: 'Solde insuffisant',
                                text: 'Le montant demandé dépasse le solde disponible de la caisse.',
                                confirmButtonText: 'Corriger'
                            });

                            return;
                        }

                        if (submitButton) {
                            submitButton.disabled = true;

                            submitButton.innerHTML =
                                '<i class="fas fa-spinner fa-spin mr-1"></i>' +
                                ' Enregistrement...';
                        }
                    }
                );
            }

            /*
             * Affichage du nom de la pièce jointe.
             */
            $(document).on(
                'change',
                '#decAttachment',
                function() {

                    const fileName =
                        $(this)
                        .val()
                        .split('\\')
                        .pop();

                    $(this)
                        .next('.custom-file-label')
                        .html(
                            fileName ||
                            'Choisir un fichier'
                        );
                }
            );

            /*
             * Réinitialiser le modal à sa fermeture.
             */
            $('#addDecaissementModal').on(
                'hidden.bs.modal',
                function() {

                    const form =
                        document.getElementById(
                            'decaissementForm'
                        );

                    if (form) {
                        form.reset();
                    }

                    const balanceElement =
                        document.getElementById(
                            'decAvailableBalance'
                        );

                    const codeElement =
                        document.getElementById(
                            'decCashboxCode'
                        );

                    const currencyElement =
                        document.getElementById(
                            'decCurrencyLabel'
                        );

                    const fileLabel =
                        document.querySelector(
                            'label[for="decAttachment"]'
                        );

                    if (balanceElement) {
                        balanceElement.textContent =
                            '0 BIF';
                    }

                    if (codeElement) {
                        codeElement.textContent =
                            'Aucune caisse sélectionnée';
                    }

                    if (currencyElement) {
                        currencyElement.textContent =
                            'BIF';
                    }

                    if (fileLabel) {
                        fileLabel.textContent =
                            'Choisir un fichier';
                    }

                    if (submitButton) {
                        submitButton.disabled = false;

                        submitButton.innerHTML =
                            '<i class="fas fa-check-circle mr-1"></i>' +
                            ' Enregistrer l’opération';
                    }
                }
            );

        }
    );
</script>

<script>
    function viewDecaissement(id) {
        console.log(
            'Voir le décaissement :',
            id
        );
    }

    function editDecaissement(id) {
        console.log(
            'Modifier le décaissement :',
            id
        );
    }

    function printDecaissement(id) {
        window.location.href =
            '<?= base_url('finance/decaissement-print/') ?>' +
            id;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if ($this->session->flashdata('success')): ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Caisse créée',
                html: <?= json_encode(
                            $this->session->flashdata('success')
                        ) ?>,
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
                title: 'Enregistrement impossible',
                html: <?= json_encode(
                            $this->session->flashdata('error')
                        ) ?>,
                confirmButtonText: 'Corriger',
                confirmButtonColor: '#dc2626'
            });
        });
    </script>

<?php endif; ?>