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
    <section class="content">
        <div class="container-fluid">

            <!-- ici le contenu de la page  -->

            <!-- =========================================================
     STYLES : RAPPROCHEMENT BANCAIRE
========================================================== -->
            <style>
            :root {
                --reco-primary: #0f766e;
                --reco-primary-dark: #0b4f4a;
                --reco-secondary: #164e63;
                --reco-dark: #0f172a;
                --reco-muted: #64748b;
                --reco-border: #dbe5ec;
                --reco-bg: #f5f8fa;
                --reco-white: #ffffff;
                --reco-success: #16a34a;
                --reco-warning: #d97706;
                --reco-danger: #dc2626;
                --reco-info: #0284c7;
                --reco-purple: #7c3aed;
            }

            .reco-page {
                padding-bottom: 35px;
            }

            /* =====================================================
       BANNIÈRE
    ====================================================== */

            .reco-hero {
                position: relative;
                overflow: hidden;
                margin-bottom: 22px;
                padding: 26px 28px;
                color: #fff;
                border-radius: 16px;
                background:
                    linear-gradient(120deg,
                        #0f766e 0%,
                        #155e75 52%,
                        #0f172a 100%);
                box-shadow: 0 10px 30px rgba(15, 118, 110, 0.14);
            }

            .reco-hero::before,
            .reco-hero::after {
                position: absolute;
                content: "";
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.06);
            }

            .reco-hero::before {
                width: 230px;
                height: 230px;
                right: 70px;
                bottom: -145px;
            }

            .reco-hero::after {
                width: 180px;
                height: 180px;
                right: -55px;
                top: -80px;
            }

            .reco-hero-content {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
            }

            .reco-hero-left {
                display: flex;
                align-items: flex-start;
                gap: 16px;
            }

            .reco-hero-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 52px;
                width: 52px;
                height: 52px;
                font-size: 22px;
                border-radius: 14px;
                background: rgba(255, 255, 255, 0.14);
                border: 1px solid rgba(255, 255, 255, 0.12);
            }

            .reco-hero h2 {
                margin: 0 0 6px;
                font-size: 25px;
                font-weight: 800;
                color: #fff;
            }

            .reco-hero p {
                max-width: 780px;
                margin: 0;
                line-height: 1.65;
                font-size: 13px;
                color: rgba(255, 255, 255, 0.88);
            }

            .reco-date-box {
                position: relative;
                z-index: 2;
                min-width: 165px;
                padding: 12px 16px;
                text-align: center;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.10);
                border: 1px solid rgba(255, 255, 255, 0.20);
                backdrop-filter: blur(8px);
            }

            .reco-date-box span {
                display: block;
                margin-bottom: 4px;
                font-size: 11px;
                color: rgba(255, 255, 255, 0.78);
            }

            .reco-date-box strong {
                font-size: 14px;
                color: #fff;
            }

            /* =====================================================
       CARTES STATISTIQUES
    ====================================================== */

            .reco-stat-card {
                position: relative;
                overflow: hidden;
                min-height: 165px;
                margin-bottom: 20px;
                padding: 20px;
                border: 1px solid var(--reco-border);
                border-radius: 14px;
                background: #fff;
                box-shadow: 0 7px 22px rgba(15, 23, 42, 0.045);
            }

            .reco-stat-card::after {
                position: absolute;
                width: 100px;
                height: 100px;
                content: "";
                right: -25px;
                bottom: -40px;
                border-radius: 50%;
                background: #f1f6f8;
            }

            .reco-stat-top {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 20px;
            }

            .reco-stat-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 46px;
                height: 46px;
                font-size: 18px;
                border-radius: 12px;
            }

            .reco-icon-green {
                color: #15803d;
                background: #dcfce7;
            }

            .reco-icon-blue {
                color: #0369a1;
                background: #e0f2fe;
            }

            .reco-icon-orange {
                color: #b45309;
                background: #fef3c7;
            }

            .reco-icon-red {
                color: #b91c1c;
                background: #fee2e2;
            }

            .reco-stat-badge {
                padding: 6px 9px;
                font-size: 10px;
                font-weight: 700;
                border-radius: 30px;
            }

            .reco-badge-success {
                color: #15803d;
                background: #dcfce7;
            }

            .reco-badge-info {
                color: #0369a1;
                background: #e0f2fe;
            }

            .reco-badge-warning {
                color: #b45309;
                background: #fef3c7;
            }

            .reco-badge-danger {
                color: #b91c1c;
                background: #fee2e2;
            }

            .reco-stat-label {
                position: relative;
                z-index: 2;
                margin-bottom: 7px;
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                color: #64748b;
            }

            .reco-stat-value {
                position: relative;
                z-index: 2;
                margin-bottom: 6px;
                font-size: 22px;
                line-height: 1.2;
                font-weight: 800;
                color: #0f172a;
            }

            .reco-stat-footer {
                position: relative;
                z-index: 2;
                font-size: 10px;
                color: #64748b;
            }

            /* =====================================================
       CARTES GÉNÉRALES
    ====================================================== */

            .reco-card {
                margin-bottom: 20px;
                border: 1px solid var(--reco-border);
                border-radius: 14px;
                background: #fff;
                box-shadow: 0 7px 22px rgba(15, 23, 42, 0.04);
            }

            .reco-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                padding: 16px 18px;
                border-bottom: 1px solid #e7edf2;
            }

            .reco-card-title {
                margin: 0 0 3px;
                font-size: 15px;
                font-weight: 800;
                color: #0f172a;
            }

            .reco-card-title i {
                margin-right: 7px;
                color: var(--reco-primary);
            }

            .reco-card-subtitle {
                display: block;
                font-size: 10px;
                color: #64748b;
            }

            .reco-card-body {
                padding: 18px;
            }

            /* =====================================================
       ACTIONS RAPIDES
    ====================================================== */

            .reco-quick-action {
                display: flex;
                align-items: center;
                min-height: 88px;
                padding: 13px;
                border: 1px solid #dce6ec;
                border-radius: 12px;
                background: #fff;
                transition: all 0.2s ease;
                cursor: pointer;
            }

            .reco-quick-action:hover {
                transform: translateY(-2px);
                border-color: #8bc8c2;
                box-shadow: 0 8px 20px rgba(15, 118, 110, 0.10);
            }

            .reco-quick-action-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 42px;
                width: 42px;
                height: 42px;
                margin-right: 12px;
                border-radius: 11px;
                font-size: 17px;
            }

            .reco-action-green {
                color: #15803d;
                background: #dcfce7;
            }

            .reco-action-blue {
                color: #0369a1;
                background: #e0f2fe;
            }

            .reco-action-orange {
                color: #b45309;
                background: #fef3c7;
            }

            .reco-action-purple {
                color: #6d28d9;
                background: #ede9fe;
            }

            .reco-quick-action strong {
                display: block;
                margin-bottom: 3px;
                font-size: 12px;
                color: #0f172a;
            }

            .reco-quick-action small {
                display: block;
                line-height: 1.5;
                font-size: 9px;
                color: #64748b;
            }

            /* =====================================================
       FILTRES
    ====================================================== */

            .reco-filter-box {
                margin-bottom: 20px;
                padding: 17px;
                border: 1px solid var(--reco-border);
                border-radius: 14px;
                background: #fff;
                box-shadow: 0 7px 22px rgba(15, 23, 42, 0.035);
            }

            .reco-filter-box label {
                margin-bottom: 7px;
                font-size: 10px;
                font-weight: 800;
                text-transform: uppercase;
                color: #334155;
            }

            .reco-filter-box .form-control {
                height: 40px;
                font-size: 11px;
                border-radius: 8px;
                border-color: #d7e1e8;
            }

            .btn-reco-primary {
                min-height: 40px;
                padding: 9px 16px;
                border: 1px solid var(--reco-primary);
                border-radius: 8px;
                color: #fff;
                background: var(--reco-primary);
                font-size: 11px;
                font-weight: 700;
            }

            .btn-reco-primary:hover,
            .btn-reco-primary:focus {
                color: #fff;
                background: var(--reco-primary-dark);
                border-color: var(--reco-primary-dark);
            }

            .btn-reco-outline {
                min-height: 40px;
                padding: 9px 16px;
                border: 1px solid #9bc9c5;
                border-radius: 8px;
                color: var(--reco-primary);
                background: #fff;
                font-size: 11px;
                font-weight: 700;
            }

            .btn-reco-outline:hover {
                color: #fff;
                background: var(--reco-primary);
            }

            /* =====================================================
       COMPTE À RAPPROCHER
    ====================================================== */

            .reco-account-head {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 18px;
                padding: 15px;
                border-radius: 12px;
                background: linear-gradient(135deg, #f0fdfa, #eff6ff);
                border: 1px solid #cce7e4;
            }

            .reco-account-identity {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .reco-account-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 48px;
                width: 48px;
                height: 48px;
                color: #0369a1;
                border-radius: 12px;
                background: #dff2ff;
                font-size: 20px;
            }

            .reco-account-identity h6 {
                margin: 0 0 4px;
                font-size: 14px;
                font-weight: 800;
                color: #0f172a;
            }

            .reco-account-identity p {
                margin: 0;
                font-size: 10px;
                color: #64748b;
            }

            .reco-account-status {
                padding: 7px 10px;
                font-size: 10px;
                font-weight: 800;
                text-transform: uppercase;
                border-radius: 30px;
                color: #b45309;
                background: #fef3c7;
            }

            /* =====================================================
       BLOC DES SOLDES
    ====================================================== */

            .reco-balance-box {
                height: 100%;
                padding: 15px;
                border: 1px solid #dfe8ee;
                border-radius: 12px;
                background: #fbfdfe;
            }

            .reco-balance-label {
                margin-bottom: 6px;
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                color: #64748b;
            }

            .reco-balance-value {
                margin-bottom: 5px;
                font-size: 20px;
                font-weight: 800;
                color: #0f172a;
            }

            .reco-balance-info {
                font-size: 9px;
                color: #64748b;
            }

            .reco-balance-difference {
                border-color: #fed7aa;
                background: #fff7ed;
            }

            .reco-balance-difference .reco-balance-value {
                color: #c2410c;
            }

            .reco-balance-success {
                border-color: #bbf7d0;
                background: #f0fdf4;
            }

            .reco-balance-success .reco-balance-value {
                color: #15803d;
            }

            /* =====================================================
       PROGRESSION
    ====================================================== */

            .reco-progress-zone {
                margin-top: 18px;
                padding: 15px;
                border-radius: 12px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
            }

            .reco-progress-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 8px;
            }

            .reco-progress-top strong {
                font-size: 11px;
                color: #334155;
            }

            .reco-progress-top span {
                font-size: 11px;
                font-weight: 800;
                color: var(--reco-primary);
            }

            .reco-progress {
                height: 8px;
                overflow: hidden;
                border-radius: 20px;
                background: #e2e8f0;
            }

            .reco-progress-bar {
                height: 100%;
                border-radius: 20px;
                background: linear-gradient(90deg, #14b8a6, #0f766e);
            }

            /* =====================================================
       TABLEAUX
    ====================================================== */

            .reco-table {
                margin-bottom: 0;
                font-size: 10px;
            }

            .reco-table thead th {
                padding: 12px 10px;
                vertical-align: middle;
                text-transform: uppercase;
                white-space: nowrap;
                font-size: 9px;
                color: #475569;
                background: #f6f9fb;
                border-bottom: 1px solid #dce5eb;
            }

            .reco-table tbody td {
                padding: 11px 10px;
                vertical-align: middle;
                border-top: 1px solid #e7edf2;
                color: #334155;
            }

            .reco-table tbody tr:hover {
                background: #fbfefe;
            }

            .reco-reference {
                font-weight: 800;
                color: #0f172a;
            }

            .reco-table strong {
                color: #0f172a;
            }

            .reco-table small {
                font-size: 8px;
                color: #64748b;
            }

            .reco-amount-debit {
                font-weight: 800;
                color: #dc2626;
            }

            .reco-amount-credit {
                font-weight: 800;
                color: #16a34a;
            }

            .reco-match-badge {
                display: inline-flex;
                align-items: center;
                padding: 5px 8px;
                font-size: 9px;
                font-weight: 700;
                border-radius: 30px;
                white-space: nowrap;
            }

            .reco-match-ok {
                color: #15803d;
                background: #dcfce7;
            }

            .reco-match-partial {
                color: #b45309;
                background: #fef3c7;
            }

            .reco-match-missing {
                color: #b91c1c;
                background: #fee2e2;
            }

            .reco-match-pending {
                color: #0369a1;
                background: #e0f2fe;
            }

            .reco-action-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 30px;
                height: 30px;
                margin: 1px;
                padding: 0;
                border: 1px solid #d6e1e8;
                border-radius: 8px;
                color: #334155;
                background: #fff;
                transition: all 0.2s ease;
            }

            .reco-action-btn:hover {
                color: #fff;
                background: var(--reco-primary);
                border-color: var(--reco-primary);
            }

            .reco-action-match {
                color: #15803d;
            }

            .reco-action-warning {
                color: #d97706;
            }

            .reco-action-danger {
                color: #dc2626;
            }

            /* =====================================================
       ANOMALIES
    ====================================================== */

            .reco-alert-item {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                margin-bottom: 12px;
                padding: 13px;
                border-radius: 11px;
                border: 1px solid;
            }

            .reco-alert-item:last-child {
                margin-bottom: 0;
            }

            .reco-alert-danger {
                border-color: #fecaca;
                background: #fff5f5;
            }

            .reco-alert-warning {
                border-color: #fde68a;
                background: #fffbeb;
            }

            .reco-alert-info {
                border-color: #bae6fd;
                background: #f0f9ff;
            }

            .reco-alert-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 38px;
                width: 38px;
                height: 38px;
                border-radius: 10px;
            }

            .reco-alert-danger .reco-alert-icon {
                color: #b91c1c;
                background: #fee2e2;
            }

            .reco-alert-warning .reco-alert-icon {
                color: #b45309;
                background: #fef3c7;
            }

            .reco-alert-info .reco-alert-icon {
                color: #0369a1;
                background: #e0f2fe;
            }

            .reco-alert-item h6 {
                margin: 0 0 4px;
                font-size: 11px;
                font-weight: 800;
                color: #0f172a;
            }

            .reco-alert-item p {
                margin: 0;
                font-size: 9px;
                line-height: 1.55;
                color: #64748b;
            }

            /* =====================================================
       HISTORIQUE DES SESSIONS
    ====================================================== */

            .reco-session-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 12px 0;
                border-bottom: 1px solid #e8eef2;
            }

            .reco-session-item:last-child {
                border-bottom: 0;
            }

            .reco-session-left {
                display: flex;
                align-items: center;
                gap: 11px;
            }

            .reco-session-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 38px;
                width: 38px;
                height: 38px;
                color: var(--reco-primary);
                border-radius: 10px;
                background: #e6fffb;
            }

            .reco-session-left strong {
                display: block;
                margin-bottom: 2px;
                font-size: 11px;
                color: #0f172a;
            }

            .reco-session-left small {
                display: block;
                font-size: 8px;
                color: #64748b;
            }

            .reco-session-amount {
                text-align: right;
            }

            .reco-session-amount strong {
                display: block;
                margin-bottom: 3px;
                font-size: 11px;
                color: #0f172a;
            }

            /* =====================================================
       MODALE
    ====================================================== */

            .modal-reco .modal-content {
                overflow: hidden;
                border: 0;
                border-radius: 14px;
                box-shadow: 0 25px 70px rgba(15, 23, 42, 0.28);
            }

            .modal-reco .modal-header {
                color: #fff;
                border-bottom: 0;
                background:
                    linear-gradient(115deg,
                        #0f766e,
                        #164e63,
                        #0f172a);
            }

            .modal-reco .modal-title {
                font-size: 14px;
                font-weight: 800;
            }

            .modal-reco .close {
                color: #fff;
                opacity: 1;
            }

            .modal-reco .modal-body {
                padding: 22px;
            }

            .modal-reco label {
                margin-bottom: 7px;
                font-size: 10px;
                font-weight: 800;
                color: #334155;
            }

            .modal-reco .form-control {
                height: 41px;
                font-size: 11px;
                border-radius: 8px;
                border-color: #d7e2e9;
            }

            .modal-reco textarea.form-control {
                height: auto;
                min-height: 90px;
            }

            .required-star {
                color: #dc2626;
            }

            /* =====================================================
       RESPONSIVE
    ====================================================== */

            @media (max-width: 991px) {

                .reco-hero-content,
                .reco-account-head {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .reco-date-box {
                    width: 100%;
                }

                .reco-card-header {
                    align-items: flex-start;
                    flex-direction: column;
                }
            }

            @media (max-width: 767px) {
                .reco-hero {
                    padding: 20px;
                }

                .reco-hero-left {
                    flex-direction: column;
                }

                .reco-filter-box .btn {
                    width: 100%;
                    margin-top: 8px;
                }
            }
            </style>


            <div class="reco-page">

                <!-- =====================================================
         BANNIÈRE PRINCIPALE
    ====================================================== -->
                <div class="reco-hero">

                    <div class="reco-hero-content">

                        <div class="reco-hero-left">

                            <div class="reco-hero-icon">
                                <i class="fas fa-balance-scale"></i>
                            </div>

                            <div>
                                <h2>Gestion du rapprochement bancaire</h2>

                                <p>
                                    Comparez les écritures enregistrées dans la trésorerie
                                    avec les opérations figurant sur les relevés bancaires,
                                    identifiez les écarts et validez les rapprochements de
                                    chaque compte.
                                </p>
                            </div>

                        </div>

                        <div class="reco-date-box">
                            <span>
                                <i class="far fa-calendar-alt mr-1"></i>
                                Situation au
                            </span>

                            <strong>
                                <?= date('d/m/Y') ?>
                            </strong>
                        </div>

                    </div>

                </div>

                <?php

                $reconciliationStatistics =
                    isset($reconciliationStatistics)
                    && is_array($reconciliationStatistics)
                    ? $reconciliationStatistics
                    : [];

                $totalBankOperations =
                    (int) (
                        $reconciliationStatistics['total_bank_operations']
                        ?? 0
                    );

                $matchedOperations =
                    (int) (
                        $reconciliationStatistics['matched_operations']
                        ?? 0
                    );

                $matchedPercentage =
                    (float) (
                        $reconciliationStatistics['matched_percentage']
                        ?? 0
                    );

                $statementAccountsCount =
                    (int) (
                        $reconciliationStatistics['statement_accounts_count']
                        ?? 0
                    );

                $statementClosingBalance =
                    (float) (
                        $reconciliationStatistics['statement_closing_balance']
                        ?? 0
                    );

                $pendingOperationsCount =
                    (int) (
                        $reconciliationStatistics['pending_operations_count']
                        ?? 0
                    );

                $pendingOperationsAmount =
                    (float) (
                        $reconciliationStatistics['pending_operations_amount']
                        ?? 0
                    );

                $anomaliesCount =
                    (int) (
                        $reconciliationStatistics['anomalies_count']
                        ?? 0
                    );

                $unjustifiedDifference =
                    (float) (
                        $reconciliationStatistics['unjustified_difference']
                        ?? 0
                    );

                ?>


                <!-- =====================================================
                    STATISTIQUES PRINCIPALES
                ====================================================== -->
                <div class="row">

                    <!-- Opérations rapprochées -->
                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="reco-stat-card">

                            <div class="reco-stat-top">

                                <div class="reco-stat-icon reco-icon-green">
                                    <i class="fas fa-check-double"></i>
                                </div>

                                <span class="reco-stat-badge reco-badge-success">
                                    <?= number_format(
                                        $matchedPercentage,
                                        1,
                                        ',',
                                        ' '
                                    ) ?>
                                    %
                                </span>

                            </div>

                            <div class="reco-stat-label">
                                Opérations rapprochées
                            </div>

                            <div class="reco-stat-value">
                                <?= number_format(
                                    $matchedOperations,
                                    0,
                                    ',',
                                    ' '
                                ) ?>
                            </div>

                            <div class="reco-stat-footer">
                                Sur
                                <?= number_format(
                                    $totalBankOperations,
                                    0,
                                    ',',
                                    ' '
                                ) ?>
                                opération<?= $totalBankOperations > 1 ? 's' : '' ?>
                                bancaire<?= $totalBankOperations > 1 ? 's' : '' ?>
                                du mois
                            </div>

                        </div>

                    </div>


                    <!-- Solde des relevés -->
                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="reco-stat-card">

                            <div class="reco-stat-top">

                                <div class="reco-stat-icon reco-icon-blue">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>

                                <span class="reco-stat-badge reco-badge-info">
                                    <?= number_format(
                                        $statementAccountsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) ?>

                                    compte<?= $statementAccountsCount > 1 ? 's' : '' ?>
                                </span>

                            </div>

                            <div class="reco-stat-label">
                                Solde relevés bancaires
                            </div>

                            <div class="reco-stat-value">
                                <?= number_format(
                                    $statementClosingBalance,
                                    0,
                                    ',',
                                    ' '
                                ) ?>
                                BIF
                            </div>

                            <div class="reco-stat-footer">
                                Solde total des derniers relevés importés
                            </div>

                        </div>

                    </div>


                    <!-- En attente -->
                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="reco-stat-card">

                            <div class="reco-stat-top">

                                <div class="reco-stat-icon reco-icon-orange">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>

                                <span class="reco-stat-badge reco-badge-warning">
                                    <?= number_format(
                                        $pendingOperationsCount,
                                        0,
                                        ',',
                                        ' '
                                    ) ?>

                                    opération<?= $pendingOperationsCount > 1 ? 's' : '' ?>
                                </span>

                            </div>

                            <div class="reco-stat-label">
                                En attente de rapprochement
                            </div>

                            <div class="reco-stat-value">
                                <?= number_format(
                                    $pendingOperationsAmount,
                                    0,
                                    ',',
                                    ' '
                                ) ?>
                                BIF
                            </div>

                            <div class="reco-stat-footer">
                                Opérations non encore associées
                            </div>

                        </div>

                    </div>


                    <!-- Anomalies -->
                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="reco-stat-card">

                            <div class="reco-stat-top">

                                <div class="reco-stat-icon reco-icon-red">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>

                                <span class="reco-stat-badge reco-badge-danger">
                                    <?= number_format(
                                        $anomaliesCount,
                                        0,
                                        ',',
                                        ' '
                                    ) ?>

                                    anomalie<?= $anomaliesCount > 1 ? 's' : '' ?>
                                </span>

                            </div>

                            <div class="reco-stat-label">
                                Écart global non justifié
                            </div>

                            <div class="reco-stat-value">
                                <?= number_format(
                                    $unjustifiedDifference,
                                    0,
                                    ',',
                                    ' '
                                ) ?>
                                BIF
                            </div>

                            <div class="reco-stat-footer">
                                Différences nécessitant une vérification
                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                    ACTIONS RAPIDES
                ====================================================== -->
                <div class="reco-card">

                    <div class="reco-card-header">

                        <div>
                            <h5 class="reco-card-title">
                                <i class="fas fa-bolt"></i>
                                Actions rapides
                            </h5>

                            <span class="reco-card-subtitle">
                                Lancez rapidement les principales opérations de rapprochement.
                            </span>
                        </div>

                    </div>

                    <div class="reco-card-body">

                        <div class="row">

                            <div class="col-xl-3 col-lg-6 col-md-6 mb-3 mb-xl-0">

                                <div class="reco-quick-action" data-toggle="modal" data-target="#importStatementModal">

                                    <div class="reco-quick-action-icon reco-action-green">
                                        <i class="fas fa-file-import"></i>
                                    </div>

                                    <div>
                                        <strong>Importer un relevé</strong>
                                        <small>
                                            Ajouter un relevé bancaire PDF, Excel ou CSV
                                        </small>
                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6 mb-3 mb-xl-0">

                                <div class="reco-quick-action" data-toggle="modal"
                                    data-target="#newReconciliationModal">

                                    <div class="reco-quick-action-icon reco-action-blue">
                                        <i class="fas fa-balance-scale-right"></i>
                                    </div>

                                    <div>
                                        <strong>Nouveau rapprochement</strong>
                                        <small>
                                            Démarrer une nouvelle session de contrôle
                                        </small>
                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6 mb-3 mb-md-0">

                                <div class="reco-quick-action" data-toggle="modal"
                                    data-target="#analyzeDifferencesModal">
                                    <div class="reco-quick-action-icon reco-action-orange">
                                        <i class="fas fa-search-dollar"></i>
                                    </div>

                                    <div>
                                        <strong>Analyser les écarts</strong>

                                        <small>
                                            Afficher les opérations non correspondantes
                                        </small>
                                    </div>
                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6">

                                <div class="reco-quick-action">

                                    <div class="reco-quick-action-icon reco-action-purple">
                                        <i class="fas fa-print"></i>
                                    </div>

                                    <div>
                                        <strong>Imprimer l’état</strong>
                                        <small>
                                            Générer la fiche de rapprochement bancaire
                                        </small>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
         FILTRES
    ====================================================== -->
                <div class="reco-filter-box">

                    <div class="row align-items-end">

                        <div class="col-xl-3 col-lg-3 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label>Compte bancaire</label>

                                <select class="form-control">
                                    <option value="">Tous les comptes</option>
                                    <option value="1">CRDB BIF — 123456789</option>
                                    <option value="2">BANCOBU BIF — 9874563210</option>
                                    <option value="3">ECOBANK BIF — 330000000001</option>
                                    <option value="4">KCB USD — 440000000001</option>
                                </select>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label>Période</label>

                                <select class="form-control">
                                    <option value="current_month">
                                        Ce mois
                                    </option>

                                    <option value="previous_month">
                                        Mois précédent
                                    </option>

                                    <option value="current_quarter">
                                        Ce trimestre
                                    </option>

                                    <option value="current_year">
                                        Cette année
                                    </option>
                                </select>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label>Date du début</label>

                                <input type="date" class="form-control" value="<?= date('Y-m-01') ?>">

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label>Date de fin</label>

                                <input type="date" class="form-control" value="<?= date('Y-m-d') ?>">

                            </div>

                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-12">

                            <button type="button" class="btn btn-reco-primary mr-1">
                                <i class="fas fa-filter mr-1"></i>
                                Appliquer
                            </button>

                            <button type="button" class="btn btn-reco-outline">
                                <i class="fas fa-redo mr-1"></i>
                                Réinitialiser
                            </button>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
         SESSION DE RAPPROCHEMENT ACTIVE
    ====================================================== -->
                <div class="reco-card">

                    <div class="reco-card-header">

                        <div>
                            <h5 class="reco-card-title">
                                <i class="fas fa-university"></i>
                                Session de rapprochement en cours
                            </h5>

                            <span class="reco-card-subtitle">
                                Comparaison entre le relevé bancaire et les écritures enregistrées.
                            </span>
                        </div>

                        <div>
                            <button type="button" class="btn btn-reco-outline mr-1">
                                <i class="fas fa-save mr-1"></i>
                                Enregistrer
                            </button>

                            <button type="button" class="btn btn-reco-primary" onclick="confirmReconciliation()">
                                <i class="fas fa-check-double mr-1"></i>
                                Valider le rapprochement
                            </button>
                        </div>

                    </div>

                    <div class="reco-card-body">

                        <div class="reco-account-head">

                            <div class="reco-account-identity">

                                <div class="reco-account-icon">
                                    <i class="fas fa-university"></i>
                                </div>

                                <div>
                                    <h6>CRDB BIF — Compte principal SATRACO</h6>

                                    <p>
                                        Compte : 110000000001 · Agence siège Bujumbura ·
                                        Période du 01/07/2026 au 31/07/2026
                                    </p>
                                </div>

                            </div>

                            <span class="reco-account-status">
                                En cours
                            </span>

                        </div>

                        <div class="row">

                            <div class="col-xl-3 col-lg-6 col-md-6 mb-3">

                                <div class="reco-balance-box">

                                    <div class="reco-balance-label">
                                        Solde comptable
                                    </div>

                                    <div class="reco-balance-value">
                                        185 500 000 BIF
                                    </div>

                                    <div class="reco-balance-info">
                                        Solde enregistré dans la trésorerie
                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6 mb-3">

                                <div class="reco-balance-box">

                                    <div class="reco-balance-label">
                                        Solde du relevé bancaire
                                    </div>

                                    <div class="reco-balance-value">
                                        183 800 000 BIF
                                    </div>

                                    <div class="reco-balance-info">
                                        Solde communiqué par la banque
                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6 mb-3">

                                <div class="reco-balance-box reco-balance-difference">

                                    <div class="reco-balance-label">
                                        Écart avant ajustement
                                    </div>

                                    <div class="reco-balance-value">
                                        1 700 000 BIF
                                    </div>

                                    <div class="reco-balance-info">
                                        Différence à identifier et justifier
                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6 mb-3">

                                <div class="reco-balance-box reco-balance-success">

                                    <div class="reco-balance-label">
                                        Écart après ajustement
                                    </div>

                                    <div class="reco-balance-value">
                                        0 BIF
                                    </div>

                                    <div class="reco-balance-info">
                                        Session prête pour validation
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="reco-progress-zone">

                            <div class="reco-progress-top">

                                <strong>
                                    Progression du rapprochement
                                </strong>

                                <span>
                                    82,5 %
                                </span>

                            </div>

                            <div class="reco-progress">

                                <div class="reco-progress-bar" style="width: 82.5%;"></div>

                            </div>

                            <small class="d-block mt-2 text-muted">
                                146 opérations rapprochées sur 177 opérations détectées.
                            </small>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                    OPÉRATIONS À RAPPROCHER + ANOMALIES
                ====================================================== -->
                <div class="row">

                    <div class="col-xl-9 col-lg-8">

                        <div class="reco-card">

                            <div class="reco-card-header">

                                <div>
                                    <h5 class="reco-card-title">
                                        <i class="fas fa-list-alt"></i>
                                        Opérations à rapprocher
                                    </h5>

                                    <span class="reco-card-subtitle">
                                        Écritures comptables et mouvements bancaires à vérifier.
                                    </span>
                                </div>

                                <span class="badge badge-warning">
                                    5 opérations en attente
                                </span>

                            </div>

                            <div class="table-responsive">

                                <table class="table reco-table">

                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Référence</th>
                                            <th>Libellé</th>
                                            <th class="text-right">Débit</th>
                                            <th class="text-right">Crédit</th>
                                            <th>Source</th>
                                            <th>Correspondance</th>
                                            <th class="text-center">Actions</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td>1</td>

                                            <td>
                                                15/07/2026
                                                <small class="d-block">
                                                    09:45
                                                </small>
                                            </td>

                                            <td>
                                                <span class="reco-reference">
                                                    BMV-2026-00061
                                                </span>
                                            </td>

                                            <td>
                                                <strong>
                                                    Paiement fournisseur ciment
                                                </strong>

                                                <small class="d-block">
                                                    Bénéficiaire : BUCECO
                                                </small>
                                            </td>

                                            <td class="text-right reco-amount-debit">
                                                8 500 000
                                            </td>

                                            <td class="text-right text-muted">
                                                —
                                            </td>

                                            <td>
                                                Trésorerie
                                                <small class="d-block">
                                                    Virement bancaire
                                                </small>
                                            </td>

                                            <td>
                                                <span class="reco-match-badge reco-match-ok">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Correspondance trouvée
                                                </span>
                                            </td>

                                            <td class="text-center">

                                                <button class="reco-action-btn" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="reco-action-btn reco-action-match" title="Rapprocher">
                                                    <i class="fas fa-link"></i>
                                                </button>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>2</td>

                                            <td>
                                                14/07/2026
                                                <small class="d-block">
                                                    14:20
                                                </small>
                                            </td>

                                            <td>
                                                <span class="reco-reference">
                                                    RBK-2026-00085
                                                </span>
                                            </td>

                                            <td>
                                                <strong>
                                                    Frais de tenue de compte
                                                </strong>

                                                <small class="d-block">
                                                    Prélèvement automatique CRDB
                                                </small>
                                            </td>

                                            <td class="text-right reco-amount-debit">
                                                350 000
                                            </td>

                                            <td class="text-right text-muted">
                                                —
                                            </td>

                                            <td>
                                                Relevé bancaire
                                                <small class="d-block">
                                                    Non comptabilisé
                                                </small>
                                            </td>

                                            <td>
                                                <span class="reco-match-badge reco-match-missing">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Écriture manquante
                                                </span>
                                            </td>

                                            <td class="text-center">

                                                <button class="reco-action-btn" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="reco-action-btn reco-action-warning"
                                                    title="Créer l'écriture">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>3</td>

                                            <td>
                                                14/07/2026
                                                <small class="d-block">
                                                    11:08
                                                </small>
                                            </td>

                                            <td>
                                                <span class="reco-reference">
                                                    BMV-2026-00059
                                                </span>
                                            </td>

                                            <td>
                                                <strong>
                                                    Paiement client marché Gitega
                                                </strong>

                                                <small class="d-block">
                                                    Décompte provisoire n° 04
                                                </small>
                                            </td>

                                            <td class="text-right text-muted">
                                                —
                                            </td>

                                            <td class="text-right reco-amount-credit">
                                                25 000 000
                                            </td>

                                            <td>
                                                Trésorerie
                                                <small class="d-block">
                                                    Encaissement bancaire
                                                </small>
                                            </td>

                                            <td>
                                                <span class="reco-match-badge reco-match-partial">
                                                    <i class="fas fa-exclamation mr-1"></i>
                                                    Écart de 200 000
                                                </span>
                                            </td>

                                            <td class="text-center">

                                                <button class="reco-action-btn" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="reco-action-btn reco-action-warning" title="Ajuster">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>4</td>

                                            <td>
                                                13/07/2026
                                                <small class="d-block">
                                                    16:35
                                                </small>
                                            </td>

                                            <td>
                                                <span class="reco-reference">
                                                    RBK-2026-00083
                                                </span>
                                            </td>

                                            <td>
                                                <strong>
                                                    Virement vers ECOBANK
                                                </strong>

                                                <small class="d-block">
                                                    Transfert interne entre comptes
                                                </small>
                                            </td>

                                            <td class="text-right reco-amount-debit">
                                                15 000 000
                                            </td>

                                            <td class="text-right text-muted">
                                                —
                                            </td>

                                            <td>
                                                Relevé bancaire
                                                <small class="d-block">
                                                    Transfert bancaire
                                                </small>
                                            </td>

                                            <td>
                                                <span class="reco-match-badge reco-match-pending">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Vérification en cours
                                                </span>
                                            </td>

                                            <td class="text-center">

                                                <button class="reco-action-btn" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="reco-action-btn reco-action-match" title="Associer">
                                                    <i class="fas fa-link"></i>
                                                </button>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>5</td>

                                            <td>
                                                12/07/2026
                                                <small class="d-block">
                                                    10:25
                                                </small>
                                            </td>

                                            <td>
                                                <span class="reco-reference">
                                                    BMV-2026-00056
                                                </span>
                                            </td>

                                            <td>
                                                <strong>
                                                    Paiement sous-traitant
                                                </strong>

                                                <small class="d-block">
                                                    ABC Construction
                                                </small>
                                            </td>

                                            <td class="text-right reco-amount-debit">
                                                6 700 000
                                            </td>

                                            <td class="text-right text-muted">
                                                —
                                            </td>

                                            <td>
                                                Trésorerie
                                                <small class="d-block">
                                                    Virement bancaire
                                                </small>
                                            </td>

                                            <td>
                                                <span class="reco-match-badge reco-match-ok">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Correspondance trouvée
                                                </span>
                                            </td>

                                            <td class="text-center">

                                                <button class="reco-action-btn" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="reco-action-btn reco-action-match" title="Rapprocher">
                                                    <i class="fas fa-check-double"></i>
                                                </button>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                            <div class="
                        p-3
                        border-top
                        d-flex
                        justify-content-between
                        align-items-center
                    ">

                                <small class="text-muted">
                                    Affichage de 1 à 5 sur 31 opérations à vérifier
                                </small>

                                <button type="button" class="btn btn-reco-outline">
                                    Voir toutes les opérations
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </button>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                        ALERTES ET ANOMALIES
                    ================================================== -->
                    <div class="col-xl-3 col-lg-4">

                        <div class="reco-card">

                            <div class="reco-card-header">

                                <div>
                                    <h5 class="reco-card-title">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Anomalies détectées
                                    </h5>

                                    <span class="reco-card-subtitle">
                                        Éléments nécessitant une intervention.
                                    </span>
                                </div>

                                <span class="badge badge-danger">
                                    5
                                </span>

                            </div>

                            <div class="reco-card-body">

                                <div class="reco-alert-item reco-alert-danger">

                                    <div class="reco-alert-icon">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>

                                    <div>
                                        <h6>Écriture comptable absente</h6>

                                        <p>
                                            Des frais bancaires de 350 000 BIF figurent
                                            uniquement sur le relevé CRDB.
                                        </p>
                                    </div>

                                </div>

                                <div class="reco-alert-item reco-alert-warning">

                                    <div class="reco-alert-icon">
                                        <i class="fas fa-not-equal"></i>
                                    </div>

                                    <div>
                                        <h6>Montants différents</h6>

                                        <p>
                                            Une différence de 200 000 BIF existe sur
                                            l’encaissement du marché Gitega.
                                        </p>
                                    </div>

                                </div>

                                <div class="reco-alert-item reco-alert-info">

                                    <div class="reco-alert-icon">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>

                                    <div>
                                        <h6>Date de valeur différente</h6>

                                        <p>
                                            Deux opérations présentent un décalage entre
                                            la date comptable et la date bancaire.
                                        </p>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
         HISTORIQUE DES RAPPROCHEMENTS
    ====================================================== -->
                <div class="reco-card">

                    <div class="reco-card-header">

                        <div>
                            <h5 class="reco-card-title">
                                <i class="fas fa-history"></i>
                                Historique des rapprochements
                            </h5>

                            <span class="reco-card-subtitle">
                                Dernières sessions de rapprochement validées ou en cours.
                            </span>
                        </div>

                        <button type="button" class="btn btn-reco-outline">
                            <i class="fas fa-list mr-1"></i>
                            Voir tout l’historique
                        </button>

                    </div>

                    <div class="reco-card-body">

                        <div class="row">

                            <div class="col-xl-4 col-lg-6">

                                <div class="reco-session-item">

                                    <div class="reco-session-left">

                                        <div class="reco-session-icon">
                                            <i class="fas fa-university"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                CRDB BIF — Juin 2026
                                            </strong>

                                            <small>
                                                Validé le 05/07/2026 par Nally Ange
                                            </small>
                                        </div>

                                    </div>

                                    <div class="reco-session-amount">

                                        <strong>
                                            174 300 000 BIF
                                        </strong>

                                        <span class="badge badge-success">
                                            Rapproché
                                        </span>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-4 col-lg-6">

                                <div class="reco-session-item">

                                    <div class="reco-session-left">

                                        <div class="reco-session-icon">
                                            <i class="fas fa-university"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                BANCOBU BIF — Juin 2026
                                            </strong>

                                            <small>
                                                Validé le 04/07/2026 par Axcel
                                            </small>
                                        </div>

                                    </div>

                                    <div class="reco-session-amount">

                                        <strong>
                                            140 000 000 BIF
                                        </strong>

                                        <span class="badge badge-success">
                                            Rapproché
                                        </span>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-4 col-lg-6">

                                <div class="reco-session-item">

                                    <div class="reco-session-left">

                                        <div class="reco-session-icon">
                                            <i class="fas fa-university"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                ECOBANK BIF — Juillet 2026
                                            </strong>

                                            <small>
                                                Créé le 13/07/2026 par Axcel
                                            </small>
                                        </div>

                                    </div>

                                    <div class="reco-session-amount">

                                        <strong>
                                            95 250 000 BIF
                                        </strong>

                                        <span class="badge badge-warning">
                                            En cours
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =========================================================
                MODALE : IMPORTER UN RELEVÉ BANCAIRE
            ========================================================== -->
            <div class="modal fade modal-reco" id="importStatementModal" tabindex="-1" role="dialog">

                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                    <form action="<?= base_url('finance/rapprochement/releve/import'); ?>" method="post"
                        enctype="multipart/form-data" id="importStatementForm" style="width: 100%;">

                        <?php if (
                            config_item('csrf_protection')
                        ): ?>

                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">

                        <?php endif; ?>

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    <i class="fas fa-file-import mr-2"></i>
                                    Importer un relevé bancaire
                                </h5>

                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>

                            </div>

                            <div class="modal-body">

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Compte bancaire
                                                <span class="required-star">*</span>
                                            </label>

                                            <select name="bank_account_id" id="statementBankAccount"
                                                class="form-control" required>
                                                <option value="">
                                                    Sélectionner le compte
                                                </option>

                                                <?php if (
                                                    !empty($allBankAccounts)
                                                ): ?>

                                                <?php foreach (
                                                        $allBankAccounts
                                                        as $account
                                                    ): ?>

                                                <option value="<?= (int) $account->id ?>" data-currency="<?= html_escape(
                                                                                $account->currency
                                                                            ) ?>">
                                                    <?= html_escape(
                                                                $account->bank_name
                                                            ) ?>

                                                    —

                                                    <?= html_escape(
                                                                $account->name
                                                            ) ?>

                                                    —

                                                    <?= html_escape(
                                                                $account->account_number
                                                            ) ?>
                                                </option>

                                                <?php endforeach; ?>

                                                <?php endif; ?>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Date du relevé
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="date" name="statement_date" class="form-control"
                                                value="<?= date('Y-m-d') ?>" required>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Période du début
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="date" name="period_start" class="form-control"
                                                value="<?= date('Y-m-01') ?>" required>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Période de fin
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="date" name="period_end" class="form-control"
                                                value="<?= date('Y-m-d') ?>" required>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Solde initial du relevé
                                            </label>

                                            <input type="number" name="opening_balance" class="form-control" step="0.01"
                                                value="0" placeholder="0">

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Solde final du relevé
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="number" name="closing_balance" class="form-control" step="0.01"
                                                value="0" placeholder="0" required>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>
                                                Fichier du relevé
                                                <span class="required-star">*</span>
                                            </label>

                                            <div class="custom-file">

                                                <input type="file" name="statement_file" id="statementFile"
                                                    class="custom-file-input" accept=".pdf,.xls,.xlsx,.csv" required>

                                                <label class="custom-file-label" for="statementFile">
                                                    Choisir un fichier PDF, Excel ou CSV
                                                </label>

                                            </div>

                                            <small class="text-muted">
                                                Formats autorisés : PDF, XLS, XLSX et CSV.
                                                Taille maximale : 10 Mo.
                                            </small>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group mb-0">

                                            <label>Observation</label>

                                            <textarea name="observation" class="form-control" maxlength="1000"
                                                placeholder="Informations complémentaires sur le relevé..."></textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-reco-outline" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>
                                    Annuler
                                </button>

                                <button type="submit" class="btn btn-reco-primary">
                                    <i class="fas fa-file-import mr-1"></i>
                                    Importer le relevé
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            <script>
            document.addEventListener(
                'DOMContentLoaded',
                function() {

                    const statementFileInput =
                        document.getElementById(
                            'statementFile'
                        );

                    if (!statementFileInput) {
                        return;
                    }

                    statementFileInput.addEventListener(
                        'change',
                        function() {

                            const selectedFile =
                                this.files &&
                                this.files.length > 0 ?
                                this.files[0] :
                                null;

                            const fileLabel =
                                this.nextElementSibling;

                            if (!fileLabel) {
                                return;
                            }

                            fileLabel.textContent =
                                selectedFile ?
                                selectedFile.name :
                                'Choisir un fichier PDF, Excel ou CSV';
                        }
                    );

                }
            );
            </script>


            <!-- =========================================================
                MODALE : NOUVEAU RAPPROCHEMENT
            ========================================================== -->
            <div class="modal fade modal-reco" id="newReconciliationModal" tabindex="-1" role="dialog"
                aria-hidden="true">

                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                    <form action="<?= base_url('finance/rapprochement/store'); ?>" method="post" style="width: 100%;"
                        id="newReconciliationForm">

                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    <i class="fas fa-balance-scale mr-2"></i>
                                    Démarrer un rapprochement bancaire
                                </h5>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                    <span>&times;</span>
                                </button>

                            </div>

                            <div class="modal-body">

                                <div class="row">

                                    <!-- Compte bancaire -->
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Compte bancaire
                                                <span class="required-star">*</span>
                                            </label>

                                            <select name="bank_account_id" id="reconciliationBankAccount"
                                                class="form-control" required>

                                                <option value="">
                                                    Sélectionner le compte
                                                </option>

                                                <?php if (!empty($allBankAccounts)): ?>

                                                <?php foreach ($allBankAccounts as $account): ?>

                                                <option value="<?= (int) $account->id ?>"
                                                    data-currency="<?= html_escape($account->currency) ?>"
                                                    data-balance="<?= number_format(
                                                                                                                                        (float) $account->current_balance,
                                                                                                                                        2,
                                                                                                                                        '.',
                                                                                                                                        ''
                                                                                                                                    ) ?>"
                                                    data-bank="<?= html_escape($account->bank_name) ?>"
                                                    data-account-number="<?= html_escape($account->account_number) ?>">
                                                    <?= html_escape($account->bank_name) ?>
                                                    —
                                                    <?= html_escape($account->name) ?>
                                                    —
                                                    <?= html_escape($account->account_number) ?>
                                                    —
                                                    <?= number_format(
                                                                (float) $account->current_balance,
                                                                0,
                                                                ',',
                                                                ' '
                                                            ) ?>
                                                    <?= html_escape($account->currency) ?>
                                                </option>

                                                <?php endforeach; ?>

                                                <?php else: ?>

                                                <option value="" disabled>
                                                    Aucun compte bancaire actif disponible
                                                </option>

                                                <?php endif; ?>

                                            </select>

                                            <small class="form-text text-muted">
                                                Le rapprochement sera effectué uniquement sur ce compte.
                                            </small>

                                        </div>

                                    </div>

                                    <!-- Devise -->
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Devise</label>

                                            <input type="text" id="reconciliationCurrency" class="form-control"
                                                placeholder="Devise du compte" readonly>

                                            <input type="hidden" name="currency" id="reconciliationCurrencyValue">

                                            <small class="form-text text-muted">
                                                La devise est récupérée automatiquement depuis le compte.
                                            </small>

                                        </div>

                                    </div>

                                    <!-- Date début -->
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Date de début
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="date" name="period_start" id="reconciliationPeriodStart"
                                                class="form-control" value="<?= date('Y-m-01'); ?>" required>

                                        </div>

                                    </div>

                                    <!-- Date fin -->
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Date de fin
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="date" name="period_end" id="reconciliationPeriodEnd"
                                                class="form-control" value="<?= date('Y-m-d'); ?>" required>

                                        </div>

                                    </div>

                                    <!-- Solde initial relevé -->
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Solde initial du relevé
                                                <span class="required-star">*</span>
                                            </label>

                                            <div class="input-group">

                                                <input type="number" name="statement_opening_balance"
                                                    id="statementOpeningBalance" class="form-control" min="0"
                                                    step="0.01" value="0" required>

                                                <div class="input-group-append">
                                                    <span class="input-group-text reconciliation-currency-label">
                                                        —
                                                    </span>
                                                </div>

                                            </div>

                                            <small class="form-text text-muted">
                                                Solde communiqué par la banque au début de la période.
                                            </small>

                                        </div>

                                    </div>

                                    <!-- Solde final relevé -->
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Solde final du relevé
                                                <span class="required-star">*</span>
                                            </label>

                                            <div class="input-group">

                                                <input type="number" name="statement_closing_balance"
                                                    id="statementClosingBalance" class="form-control" min="0"
                                                    step="0.01" placeholder="0" required>

                                                <div class="input-group-append">
                                                    <span class="input-group-text reconciliation-currency-label">
                                                        —
                                                    </span>
                                                </div>

                                            </div>

                                            <small class="form-text text-muted">
                                                Solde communiqué par la banque à la fin de la période.
                                            </small>

                                        </div>

                                    </div>

                                    <!-- Solde système -->
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Solde actuel dans le système
                                            </label>

                                            <input type="text" id="reconciliationSystemBalance" class="form-control"
                                                value="0" readonly>

                                            <input type="hidden" name="system_balance"
                                                id="reconciliationSystemBalanceValue" value="0">

                                            <small class="form-text text-muted">
                                                Solde actuellement enregistré dans l’application.
                                            </small>

                                        </div>

                                    </div>

                                    <!-- Responsable -->
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Responsable du rapprochement
                                            </label>

                                            <input type="text" class="form-control" value="<?= html_escape(
                                                                                                $this->session->userdata('last_name') . " " . $this->session->userdata('first_name')
                                                                                                    ?: $this->session->userdata('username')
                                                                                                    ?: ''
                                                                                            ); ?>" readonly>

                                            <input type="hidden" name="responsible_user_id"
                                                value="<?= (int) $this->session->userdata('user_id'); ?>">

                                        </div>

                                    </div>

                                    <!-- Observation -->
                                    <div class="col-md-12">

                                        <div class="form-group mb-0">

                                            <label>
                                                Observation
                                            </label>

                                            <textarea name="observation" class="form-control" rows="4" maxlength="1000"
                                                placeholder="Précisions relatives à cette session de rapprochement..."></textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-reco-outline" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>
                                    Annuler
                                </button>

                                <button type="submit" class="btn btn-reco-primary">
                                    <i class="fas fa-play mr-1"></i>
                                    Démarrer le rapprochement
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            <div class="modal fade modal-reco" id="analyzeDifferencesModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <form action="<?= base_url('finance/rapprochement/analyser'); ?>" method="post"
                        style="width: 100%;">
                        <div class="modal-content">

                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">

                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fas fa-search-dollar mr-2"></i>
                                    Analyser les écarts bancaires
                                </h5>

                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                Session de rapprochement
                                                <span class="required-star">*</span>
                                            </label>

                                            <select name="reconciliation_id" class="form-control" required>
                                                <option value="">
                                                    Sélectionner une session
                                                </option>

                                                <?php if (!empty($reconciliations)): ?>

                                                <?php foreach ($reconciliations as $reconciliation): ?>

                                                <option value="<?= (int) $reconciliation->id ?>">

                                                    <?= html_escape($reconciliation->reference) ?>

                                                    —

                                                    <?= html_escape($reconciliation->bank_name) ?>

                                                    —

                                                    <?= date(
                                                                'd/m/Y',
                                                                strtotime($reconciliation->period_start)
                                                            ) ?>

                                                    au

                                                    <?= date(
                                                                'd/m/Y',
                                                                strtotime($reconciliation->period_end)
                                                            ) ?>

                                                </option>

                                                <?php endforeach; ?>

                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                Tolérance sur la date
                                            </label>

                                            <select name="date_tolerance" class="form-control">
                                                <option value="0">
                                                    Même date uniquement
                                                </option>

                                                <option value="1">
                                                    ± 1 jour
                                                </option>

                                                <option value="2">
                                                    ± 2 jours
                                                </option>

                                                <option value="3" selected>
                                                    ± 3 jours
                                                </option>

                                                <option value="5">
                                                    ± 5 jours
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                Tolérance sur le montant
                                            </label>

                                            <div class="input-group">
                                                <input type="number" name="amount_tolerance" class="form-control"
                                                    value="0" min="0" step="0.01">

                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        BIF
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">

                                        <div class="alert alert-info mb-0">

                                            <i class="fas fa-info-circle mr-1"></i>

                                            L’analyse va comparer les lignes du relevé
                                            bancaire avec les opérations enregistrées
                                            dans le système.

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-reco-outline" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>
                                    Annuler
                                </button>

                                <button type="submit" class="btn btn-reco-primary">
                                    <i class="fas fa-search-dollar mr-1"></i>
                                    Lancer l’analyse
                                </button>

                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {

                const accountSelect =
                    document.getElementById('reconciliationBankAccount');

                const currencyInput =
                    document.getElementById('reconciliationCurrency');

                const currencyHiddenInput =
                    document.getElementById('reconciliationCurrencyValue');

                const systemBalanceInput =
                    document.getElementById('reconciliationSystemBalance');

                const systemBalanceHiddenInput =
                    document.getElementById('reconciliationSystemBalanceValue');

                const currencyLabels =
                    document.querySelectorAll('.reconciliation-currency-label');

                /*
                 * Vérification de sécurité.
                 */
                if (!accountSelect) {
                    console.error(
                        'Le champ #reconciliationBankAccount est introuvable.'
                    );

                    return;
                }

                function updateSelectedBankAccount() {

                    const selectedOption =
                        accountSelect.options[accountSelect.selectedIndex];

                    /*
                     * Aucun compte bancaire sélectionné.
                     */
                    if (
                        !selectedOption ||
                        !selectedOption.value
                    ) {
                        currencyInput.value = '';

                        currencyHiddenInput.value = '';

                        systemBalanceInput.value = '0';

                        systemBalanceHiddenInput.value = '0';

                        currencyLabels.forEach(function(label) {
                            label.textContent = '—';
                        });

                        return;
                    }

                    /*
                     * Récupérer les informations stockées
                     * dans les attributs data-* de l'option.
                     */
                    const currency =
                        selectedOption.dataset.currency || '';

                    const rawBalance =
                        selectedOption.dataset.balance || '0';

                    const balance =
                        Number.parseFloat(rawBalance) || 0;

                    /*
                     * Formater le montant pour l'affichage.
                     */
                    const formattedBalance =
                        new Intl.NumberFormat(
                            'fr-FR', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 2
                            }
                        ).format(balance);

                    /*
                     * Afficher la devise.
                     */
                    currencyInput.value = currency;

                    /*
                     * Devise envoyée au contrôleur.
                     */
                    currencyHiddenInput.value = currency;

                    /*
                     * Afficher le solde système.
                     */
                    systemBalanceInput.value =
                        formattedBalance + ' ' + currency;

                    /*
                     * Solde brut envoyé au contrôleur.
                     */
                    systemBalanceHiddenInput.value =
                        balance.toString();

                    /*
                     * Mettre la devise à côté des champs
                     * solde initial et solde final.
                     */
                    currencyLabels.forEach(function(label) {
                        label.textContent = currency;
                    });
                }

                /*
                 * Mise à jour au changement du compte.
                 */
                accountSelect.addEventListener(
                    'change',
                    updateSelectedBankAccount
                );

                /*
                 * Mise à jour immédiate lorsqu'un compte
                 * est déjà sélectionné.
                 */
                updateSelectedBankAccount();

            });
            </script>


            <script>
            $(document).on(
                'change',
                '#reconciliationBankAccount',
                function() {

                    const selectedOption = $(this).find('option:selected');

                    const currency =
                        selectedOption.data('currency') || '';

                    const balance =
                        parseFloat(
                            selectedOption.data('balance') || 0
                        );

                    $('#reconciliationCurrency').val(currency);

                    $('#reconciliationCurrencyValue').val(currency);

                    $('.reconciliation-currency-label').text(
                        currency || '—'
                    );

                    const formattedBalance =
                        new Intl.NumberFormat('fr-FR', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 2
                        }).format(balance);

                    $('#reconciliationSystemBalance').val(
                        currency ?
                        formattedBalance + ' ' + currency :
                        formattedBalance
                    );
                }
            );
            </script>


            <!-- =========================================================
                SCRIPTS
            ========================================================== -->
            <script>
            $(document).on(
                'change',
                '.custom-file-input',
                function() {
                    const fileName = $(this)
                        .val()
                        .split('\\')
                        .pop();

                    $(this)
                        .next('.custom-file-label')
                        .html(
                            fileName || 'Choisir un fichier'
                        );
                }
            );

            function confirmReconciliation() {
                if (typeof Swal === 'undefined') {
                    return;
                }

                Swal.fire({
                    title: 'Valider le rapprochement ?',
                    text: 'Cette action clôturera la session de rapprochement bancaire en cours.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0f766e',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Oui, valider',
                    cancelButtonText: 'Annuler'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Rapprochement validé',
                            text: 'La session a été clôturée avec succès.',
                            icon: 'success',
                            confirmButtonColor: '#0f766e'
                        });
                    }
                });
            }
            </script>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($this->session->flashdata('success')): ?>

<script>
document.addEventListener('DOMContentLoaded', function() {

    Swal.fire({
        icon: 'success',
        title: 'Rapprochement démarré',
        html: <?= json_encode(
                            $this->session->flashdata('success')
                        ) ?>,
        confirmButtonText: 'Continuer',
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