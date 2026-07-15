<div class="content-wrapper">

    <!-- En-tête de page -->
    <div class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?= $title ?? 'Prévisions de trésorerie'; ?>
                    </h1>
                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('dashboard'); ?>">
                                Home
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            Prévisions de trésorerie
                        </li>
                    </ol>

                </div>

            </div>

        </div>

    </div>

    <!-- Contenu -->
    <section class="content forecast-content-section">

        <div class="container-fluid forecast-container">

            <!-- Tout le contenu de ta page ici -->

            <!-- =========================================================
     PAGE : PRÉVISIONS DE TRÉSORERIE
========================================================== -->

            <style>
            :root {
                --prev-primary: #0f766e;
                --prev-primary-dark: #0b4f4a;
                --prev-dark: #102033;
                --prev-blue: #0284c7;
                --prev-green: #16a34a;
                --prev-orange: #d97706;
                --prev-red: #dc2626;
                --prev-purple: #7c3aed;
                --prev-border: #dbe5ec;
                --prev-muted: #64748b;
                --prev-bg: #f5f8fa;
                --prev-white: #ffffff;
            }

            .forecast-page {
                padding-bottom: 30px;
            }

            /* =====================================================
       BANNIÈRE
    ====================================================== */

            .forecast-hero {
                position: relative;
                overflow: hidden;
                min-height: 150px;
                margin-bottom: 20px;
                padding: 28px 30px;
                border-radius: 16px;
                color: #fff;
                background: linear-gradient(135deg,
                        #0f766e 0%,
                        #0b5d58 45%,
                        #102033 100%);
                box-shadow: 0 12px 30px rgba(15, 118, 110, 0.14);
            }

            .forecast-hero::before,
            .forecast-hero::after {
                position: absolute;
                content: "";
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.06);
            }

            .forecast-hero::before {
                width: 230px;
                height: 230px;
                top: -95px;
                right: 85px;
            }

            .forecast-hero::after {
                width: 170px;
                height: 170px;
                right: -35px;
                bottom: -75px;
            }

            .forecast-hero-content {
                position: relative;
                z-index: 2;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 20px;
            }

            .forecast-hero-left {
                display: flex;
                align-items: flex-start;
                gap: 16px;
            }

            .forecast-hero-icon {
                width: 58px;
                height: 58px;
                flex: 0 0 58px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 14px;
                font-size: 24px;
                background: rgba(255, 255, 255, 0.14);
                border: 1px solid rgba(255, 255, 255, 0.15);
            }

            .forecast-hero h2 {
                margin: 2px 0 8px;
                font-size: 28px;
                font-weight: 800;
            }

            .forecast-hero p {
                max-width: 820px;
                margin: 0;
                line-height: 1.65;
                color: rgba(255, 255, 255, 0.88);
            }

            .forecast-situation {
                min-width: 170px;
                padding: 14px 18px;
                text-align: center;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.11);
                border: 1px solid rgba(255, 255, 255, 0.20);
                backdrop-filter: blur(4px);
            }

            .forecast-situation span {
                display: block;
                margin-bottom: 4px;
                font-size: 11px;
                color: rgba(255, 255, 255, 0.74);
            }

            .forecast-situation strong {
                display: block;
                font-size: 15px;
            }

            /* =====================================================
       BOUTONS
    ====================================================== */

            .btn-forecast-primary {
                color: #fff;
                background: var(--prev-primary);
                border: 1px solid var(--prev-primary);
                border-radius: 9px;
                font-weight: 700;
                padding: 9px 15px;
            }

            .btn-forecast-primary:hover,
            .btn-forecast-primary:focus {
                color: #fff;
                background: var(--prev-primary-dark);
                border-color: var(--prev-primary-dark);
            }

            .btn-forecast-outline {
                color: var(--prev-primary);
                background: #fff;
                border: 1px solid #a7d4d0;
                border-radius: 9px;
                font-weight: 700;
                padding: 9px 15px;
            }

            .btn-forecast-outline:hover {
                color: #fff;
                background: var(--prev-primary);
                border-color: var(--prev-primary);
            }

            .btn-forecast-danger {
                color: #fff;
                background: #b91c1c;
                border: 1px solid #b91c1c;
                border-radius: 9px;
                font-weight: 700;
                padding: 9px 15px;
            }

            /* =====================================================
       CARTES STATISTIQUES
    ====================================================== */

            .forecast-stat-card {
                position: relative;
                overflow: hidden;
                min-height: 165px;
                margin-bottom: 20px;
                padding: 20px;
                border: 1px solid var(--prev-border);
                border-radius: 15px;
                background: #fff;
                box-shadow: 0 8px 22px rgba(15, 23, 42, 0.045);
            }

            .forecast-stat-card::after {
                position: absolute;
                width: 105px;
                height: 105px;
                right: -32px;
                bottom: -42px;
                content: "";
                border-radius: 50%;
                background: #f0f7f7;
            }

            .forecast-stat-top {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                margin-bottom: 18px;
            }

            .forecast-stat-icon {
                width: 48px;
                height: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 13px;
                font-size: 19px;
            }

            .forecast-icon-green {
                color: #15803d;
                background: #dcfce7;
            }

            .forecast-icon-blue {
                color: #0369a1;
                background: #e0f2fe;
            }

            .forecast-icon-orange {
                color: #b45309;
                background: #fef3c7;
            }

            .forecast-icon-red {
                color: #b91c1c;
                background: #fee2e2;
            }

            .forecast-stat-badge {
                display: inline-flex;
                align-items: center;
                padding: 5px 9px;
                border-radius: 20px;
                font-size: 10px;
                font-weight: 800;
            }

            .forecast-badge-success {
                color: #15803d;
                background: #dcfce7;
            }

            .forecast-badge-info {
                color: #0369a1;
                background: #e0f2fe;
            }

            .forecast-badge-warning {
                color: #b45309;
                background: #fef3c7;
            }

            .forecast-badge-danger {
                color: #b91c1c;
                background: #fee2e2;
            }

            .forecast-stat-label {
                position: relative;
                z-index: 2;
                margin-bottom: 5px;
                color: #64748b;
                font-size: 11px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.35px;
            }

            .forecast-stat-value {
                position: relative;
                z-index: 2;
                margin-bottom: 4px;
                color: #0f172a;
                font-size: 23px;
                font-weight: 800;
            }

            .forecast-stat-footer {
                position: relative;
                z-index: 2;
                color: var(--prev-muted);
                font-size: 11px;
            }

            /* =====================================================
       CARTES PRINCIPALES
    ====================================================== */

            .forecast-card {
                margin-bottom: 20px;
                border: 1px solid var(--prev-border);
                border-radius: 15px;
                background: #fff;
                box-shadow: 0 7px 20px rgba(15, 23, 42, 0.04);
                overflow: hidden;
            }

            .forecast-card-header {
                min-height: 70px;
                padding: 16px 18px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                border-bottom: 1px solid #e8eef3;
                background: #fff;
            }

            .forecast-card-title {
                margin: 0 0 4px;
                color: #102033;
                font-size: 16px;
                font-weight: 800;
            }

            .forecast-card-title i {
                margin-right: 7px;
                color: var(--prev-primary);
            }

            .forecast-card-subtitle {
                color: var(--prev-muted);
                font-size: 11px;
            }

            .forecast-card-body {
                padding: 18px;
            }

            /* =====================================================
       ACTIONS RAPIDES
    ====================================================== */

            .forecast-quick-actions {
                display: grid;
                grid-template-columns: repeat(6, minmax(145px, 1fr));
                gap: 12px;
            }

            .forecast-action {
                display: flex;
                align-items: center;
                gap: 11px;
                min-height: 82px;
                padding: 12px;
                color: #1e293b;
                background: #fff;
                border: 1px solid var(--prev-border);
                border-radius: 12px;
                transition: all 0.2s ease;
                cursor: pointer;
            }

            .forecast-action:hover {
                color: #0f766e;
                border-color: #82c8c1;
                box-shadow: 0 7px 16px rgba(15, 118, 110, 0.09);
                transform: translateY(-2px);
            }

            .forecast-action-icon {
                width: 42px;
                height: 42px;
                flex: 0 0 42px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 11px;
                font-size: 17px;
            }

            .forecast-action strong {
                display: block;
                margin-bottom: 2px;
                font-size: 12px;
            }

            .forecast-action small {
                display: block;
                color: var(--prev-muted);
                font-size: 9px;
                line-height: 1.4;
            }

            /* =====================================================
       FILTRES
    ====================================================== */

            .forecast-filter-box {
                margin-bottom: 20px;
                padding: 18px;
                border: 1px solid var(--prev-border);
                border-radius: 15px;
                background: #fff;
            }

            .forecast-filter-box label {
                margin-bottom: 6px;
                color: #475569;
                font-size: 10px;
                font-weight: 800;
                text-transform: uppercase;
            }

            .forecast-filter-box .form-control {
                height: 40px;
                border-color: #d5e0e8;
                border-radius: 8px;
                font-size: 12px;
            }

            /* =====================================================
       GRAPHIQUE
    ====================================================== */

            .forecast-chart-wrapper {
                position: relative;
                height: 340px;
            }

            .forecast-summary-row {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
                margin-bottom: 18px;
            }

            .forecast-summary-item {
                padding: 12px 14px;
                border-radius: 10px;
                background: #f8fafc;
                border: 1px solid #e6edf2;
            }

            .forecast-summary-item span {
                display: block;
                margin-bottom: 4px;
                color: var(--prev-muted);
                font-size: 9px;
                font-weight: 800;
                text-transform: uppercase;
            }

            .forecast-summary-item strong {
                display: block;
                font-size: 16px;
            }

            /* =====================================================
       ALERTES
    ====================================================== */

            .forecast-alert {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                padding: 13px;
                margin-bottom: 12px;
                border-radius: 11px;
                border: 1px solid;
            }

            .forecast-alert:last-child {
                margin-bottom: 0;
            }

            .forecast-alert-icon {
                width: 38px;
                height: 38px;
                flex: 0 0 38px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 10px;
            }

            .forecast-alert h6 {
                margin: 0 0 4px;
                font-size: 12px;
                font-weight: 800;
            }

            .forecast-alert p {
                margin: 0;
                color: #475569;
                font-size: 10px;
                line-height: 1.5;
            }

            .forecast-alert-danger {
                border-color: #fecaca;
                background: #fef2f2;
            }

            .forecast-alert-danger .forecast-alert-icon {
                color: #b91c1c;
                background: #fee2e2;
            }

            .forecast-alert-warning {
                border-color: #fde68a;
                background: #fffbeb;
            }

            .forecast-alert-warning .forecast-alert-icon {
                color: #b45309;
                background: #fef3c7;
            }

            .forecast-alert-info {
                border-color: #bae6fd;
                background: #f0f9ff;
            }

            .forecast-alert-info .forecast-alert-icon {
                color: #0369a1;
                background: #e0f2fe;
            }

            .forecast-alert-success {
                border-color: #bbf7d0;
                background: #f0fdf4;
            }

            .forecast-alert-success .forecast-alert-icon {
                color: #15803d;
                background: #dcfce7;
            }

            /* =====================================================
       TABLEAUX
    ====================================================== */

            .forecast-table {
                margin-bottom: 0;
                color: #334155;
                font-size: 11px;
            }

            .forecast-table thead th {
                padding: 13px 12px;
                color: #475569;
                background: #f8fafc;
                border-top: 0;
                border-bottom: 1px solid #dce6ed;
                font-size: 9px;
                font-weight: 800;
                text-transform: uppercase;
                white-space: nowrap;
            }

            .forecast-table tbody td {
                padding: 13px 12px;
                vertical-align: middle;
                border-top: 1px solid #edf2f6;
            }

            .forecast-table tbody tr:hover {
                background: #fbfefe;
            }

            .forecast-reference {
                color: #0f172a;
                font-size: 10px;
                font-weight: 800;
            }

            .forecast-table small {
                font-size: 9px;
            }

            .amount-income {
                color: #15803d;
                font-weight: 800;
            }

            .amount-expense {
                color: #b91c1c;
                font-weight: 800;
            }

            .forecast-badge {
                display: inline-flex;
                align-items: center;
                padding: 5px 8px;
                border-radius: 18px;
                font-size: 9px;
                font-weight: 800;
            }

            .forecast-badge-green {
                color: #15803d;
                background: #dcfce7;
            }

            .forecast-badge-orange {
                color: #b45309;
                background: #fef3c7;
            }

            .forecast-badge-red {
                color: #b91c1c;
                background: #fee2e2;
            }

            .forecast-badge-blue {
                color: #0369a1;
                background: #e0f2fe;
            }

            .btn-forecast-table {
                width: 31px;
                height: 31px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin: 1px;
                padding: 0;
                color: #0f766e;
                background: #fff;
                border: 1px solid #d5e1e8;
                border-radius: 8px;
            }

            .btn-forecast-table:hover {
                color: #fff;
                background: #0f766e;
                border-color: #0f766e;
            }

            /* =====================================================
       PROJECTION PAR CHANTIER
    ====================================================== */

            .forecast-progress {
                width: 100%;
                height: 7px;
                overflow: hidden;
                border-radius: 10px;
                background: #e8eef2;
            }

            .forecast-progress span {
                display: block;
                height: 100%;
                border-radius: 10px;
            }

            .progress-green {
                background: #16a34a;
            }

            .progress-orange {
                background: #f59e0b;
            }

            .progress-red {
                background: #dc2626;
            }

            .progress-blue {
                background: #0891b2;
            }

            /* =====================================================
       RÉPARTITION DES DÉPENSES
    ====================================================== */

            .forecast-category-item {
                margin-bottom: 17px;
            }

            .forecast-category-item:last-child {
                margin-bottom: 0;
            }

            .forecast-category-top {
                display: flex;
                justify-content: space-between;
                gap: 12px;
                margin-bottom: 7px;
                font-size: 11px;
            }

            .forecast-category-name {
                font-weight: 700;
            }

            .forecast-category-name i {
                width: 18px;
                color: var(--prev-primary);
            }

            .forecast-category-amount {
                font-weight: 800;
                color: #0f172a;
            }

            /* =====================================================
       PLAN D'ACTION
    ====================================================== */

            .forecast-plan-item {
                display: flex;
                gap: 12px;
                padding: 13px 0;
                border-bottom: 1px dashed #dce5eb;
            }

            .forecast-plan-item:last-child {
                padding-bottom: 0;
                border-bottom: 0;
            }

            .forecast-plan-number {
                width: 28px;
                height: 28px;
                flex: 0 0 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                color: #fff;
                background: var(--prev-primary);
                font-size: 10px;
                font-weight: 800;
            }

            .forecast-plan-item h6 {
                margin: 0 0 3px;
                font-size: 11px;
                font-weight: 800;
            }

            .forecast-plan-item p {
                margin: 0;
                color: var(--prev-muted);
                font-size: 10px;
                line-height: 1.5;
            }

            /* =====================================================
       MODALES
    ====================================================== */

            .modal-forecast .modal-content {
                overflow: hidden;
                border: 0;
                border-radius: 15px;
                box-shadow: 0 20px 55px rgba(15, 23, 42, 0.26);
            }

            .modal-forecast .modal-header {
                color: #fff;
                background: linear-gradient(135deg, #0f766e, #102033);
                border-bottom: 0;
            }

            .modal-forecast .modal-title {
                font-size: 15px;
                font-weight: 800;
            }

            .modal-forecast .modal-header .close {
                color: #fff;
                opacity: 1;
            }

            .modal-forecast label {
                margin-bottom: 6px;
                color: #475569;
                font-size: 10px;
                font-weight: 800;
            }

            .modal-forecast .form-control {
                min-height: 40px;
                border-radius: 8px;
                border-color: #d7e2e9;
                font-size: 12px;
            }

            .modal-forecast textarea.form-control {
                min-height: 90px;
            }

            .required-star {
                color: #dc2626;
            }

            /* =====================================================
       RESPONSIVE
    ====================================================== */

            @media (max-width: 1400px) {
                .forecast-quick-actions {
                    grid-template-columns: repeat(3, 1fr);
                }
            }

            @media (max-width: 991px) {
                .forecast-hero-content {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .forecast-situation {
                    min-width: 100%;
                    text-align: left;
                }

                .forecast-quick-actions {
                    grid-template-columns: repeat(2, 1fr);
                }

                .forecast-summary-row {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 575px) {
                .forecast-hero {
                    padding: 22px 18px;
                }

                .forecast-hero-left {
                    flex-direction: column;
                }

                .forecast-hero h2 {
                    font-size: 22px;
                }

                .forecast-quick-actions {
                    grid-template-columns: 1fr;
                }

                .forecast-card-header {
                    align-items: flex-start;
                    flex-direction: column;
                }
            }
            </style>

            <div class="forecast-page">

                <!-- =====================================================
         BANNIÈRE PRINCIPALE
    ====================================================== -->
                <div class="forecast-hero">

                    <div class="forecast-hero-content">

                        <div class="forecast-hero-left">

                            <div class="forecast-hero-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>

                            <div>
                                <h2>Prévisions de trésorerie</h2>

                                <p>
                                    Anticipez les entrées et sorties de fonds, identifiez les futurs
                                    besoins de financement et assurez la continuité des opérations
                                    du siège et des différents chantiers.
                                </p>
                            </div>

                        </div>

                        <div class="forecast-situation">
                            <span>
                                <i class="fas fa-calendar-alt mr-1"></i>
                                Situation au
                            </span>

                            <strong>
                                <?= date('d/m/Y'); ?>
                            </strong>
                        </div>

                    </div>

                </div>

                <!-- =====================================================
         STATISTIQUES PRINCIPALES
    ====================================================== -->
                <div class="row">

                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="forecast-stat-card">

                            <div class="forecast-stat-top">

                                <div class="forecast-stat-icon forecast-icon-green">
                                    <i class="fas fa-wallet"></i>
                                </div>

                                <span class="forecast-stat-badge forecast-badge-success">
                                    Disponible
                                </span>

                            </div>

                            <div class="forecast-stat-label">
                                Trésorerie actuelle
                            </div>

                            <div class="forecast-stat-value">
                                245 600 000 BIF
                            </div>

                            <div class="forecast-stat-footer">
                                Caisses et comptes bancaires actifs
                            </div>

                        </div>

                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="forecast-stat-card">

                            <div class="forecast-stat-top">

                                <div class="forecast-stat-icon forecast-icon-blue">
                                    <i class="fas fa-calendar-check"></i>
                                </div>

                                <span class="forecast-stat-badge forecast-badge-danger">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    19,2 %
                                </span>

                            </div>

                            <div class="forecast-stat-label">
                                Solde prévu à 30 jours
                            </div>

                            <div class="forecast-stat-value">
                                198 450 000 BIF
                            </div>

                            <div class="forecast-stat-footer">
                                Projection après mouvements attendus
                            </div>

                        </div>

                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="forecast-stat-card">

                            <div class="forecast-stat-top">

                                <div class="forecast-stat-icon forecast-icon-green">
                                    <i class="fas fa-arrow-down"></i>
                                </div>

                                <span class="forecast-stat-badge forecast-badge-success">
                                    14 opérations
                                </span>

                            </div>

                            <div class="forecast-stat-label">
                                Encaissements prévus
                            </div>

                            <div class="forecast-stat-value">
                                132 500 000 BIF
                            </div>

                            <div class="forecast-stat-footer">
                                Prévisions des 30 prochains jours
                            </div>

                        </div>

                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="forecast-stat-card">

                            <div class="forecast-stat-top">

                                <div class="forecast-stat-icon forecast-icon-red">
                                    <i class="fas fa-arrow-up"></i>
                                </div>

                                <span class="forecast-stat-badge forecast-badge-danger">
                                    21 opérations
                                </span>

                            </div>

                            <div class="forecast-stat-label">
                                Décaissements prévus
                            </div>

                            <div class="forecast-stat-value">
                                179 650 000 BIF
                            </div>

                            <div class="forecast-stat-footer">
                                Engagements des 30 prochains jours
                            </div>

                        </div>

                    </div>

                </div>

                <!-- =====================================================
         ACTIONS RAPIDES
    ====================================================== -->
                <div class="forecast-card">

                    <div class="forecast-card-header">

                        <div>
                            <h5 class="forecast-card-title">
                                <i class="fas fa-bolt"></i>
                                Actions rapides
                            </h5>

                            <span class="forecast-card-subtitle">
                                Enregistrez une prévision ou simulez une situation future.
                            </span>
                        </div>

                    </div>

                    <div class="forecast-card-body">

                        <div class="forecast-quick-actions">

                            <div class="forecast-action" data-toggle="modal" data-target="#addForecastIncomeModal">

                                <div class="forecast-action-icon forecast-icon-green">
                                    <i class="fas fa-arrow-down"></i>
                                </div>

                                <div>
                                    <strong>Encaissement prévu</strong>
                                    <small>Ajouter une entrée future</small>
                                </div>

                            </div>

                            <div class="forecast-action" data-toggle="modal" data-target="#addForecastExpenseModal">

                                <div class="forecast-action-icon forecast-icon-red">
                                    <i class="fas fa-arrow-up"></i>
                                </div>

                                <div>
                                    <strong>Décaissement prévu</strong>
                                    <small>Ajouter une sortie future</small>
                                </div>

                            </div>

                            <div class="forecast-action" data-toggle="modal" data-target="#forecastScenarioModal">

                                <div class="forecast-action-icon forecast-icon-blue">
                                    <i class="fas fa-project-diagram"></i>
                                </div>

                                <div>
                                    <strong>Simuler un scénario</strong>
                                    <small>Tester plusieurs hypothèses</small>
                                </div>

                            </div>

                            <div class="forecast-action">

                                <div class="forecast-action-icon forecast-icon-orange">
                                    <i class="fas fa-sync-alt"></i>
                                </div>

                                <div>
                                    <strong>Actualiser les données</strong>
                                    <small>Recalculer les projections</small>
                                </div>

                            </div>

                            <div class="forecast-action">

                                <div class="forecast-action-icon" style="background:#ede9fe;color:#6d28d9;">
                                    <i class="fas fa-file-excel"></i>
                                </div>

                                <div>
                                    <strong>Exporter le rapport</strong>
                                    <small>Télécharger au format Excel</small>
                                </div>

                            </div>

                            <div class="forecast-action">

                                <div class="forecast-action-icon forecast-icon-orange">
                                    <i class="fas fa-print"></i>
                                </div>

                                <div>
                                    <strong>Imprimer</strong>
                                    <small>Rapport prévisionnel complet</small>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- =====================================================
         FILTRES
    ====================================================== -->
                <div class="forecast-filter-box">

                    <form action="" method="get">

                        <div class="row align-items-end">

                            <div class="col-xl-2 col-lg-3 col-md-6">

                                <div class="form-group mb-lg-0">
                                    <label>Horizon de prévision</label>

                                    <select name="forecast_period" class="form-control">
                                        <option value="30">30 prochains jours</option>
                                        <option value="60">60 prochains jours</option>
                                        <option value="90">90 prochains jours</option>
                                        <option value="365">12 prochains mois</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-xl-2 col-lg-3 col-md-6">

                                <div class="form-group mb-lg-0">
                                    <label>Chantier</label>

                                    <select name="chantier_id" class="form-control">
                                        <option value="">Tous les chantiers</option>
                                        <option value="1">Chantier Bujumbura</option>
                                        <option value="2">Chantier Gitega</option>
                                        <option value="3">Chantier Ngozi</option>
                                        <option value="4">Chantier Muyinga</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-xl-2 col-lg-3 col-md-6">

                                <div class="form-group mb-lg-0">
                                    <label>Type de flux</label>

                                    <select name="flow_type" class="form-control">
                                        <option value="">Tous les flux</option>
                                        <option value="income">Encaissements</option>
                                        <option value="expense">Décaissements</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-xl-2 col-lg-3 col-md-6">

                                <div class="form-group mb-lg-0">
                                    <label>Scénario</label>

                                    <select name="scenario" class="form-control">
                                        <option value="realistic">Scénario réaliste</option>
                                        <option value="optimistic">Scénario optimiste</option>
                                        <option value="pessimistic">Scénario pessimiste</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-xl-2 col-lg-3 col-md-6">

                                <div class="form-group mb-lg-0">
                                    <label>Devise</label>

                                    <select name="currency" class="form-control">
                                        <option value="BIF">BIF</option>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-xl-2 col-lg-5 col-md-12">

                                <button type="submit" class="btn btn-forecast-primary mr-1">
                                    <i class="fas fa-filter mr-1"></i>
                                    Appliquer
                                </button>

                                <a href="<?= current_url(); ?>" class="btn btn-forecast-outline">
                                    <i class="fas fa-redo mr-1"></i>
                                    Réinitialiser
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

                <!-- =====================================================
         COURBE + ALERTES
    ====================================================== -->
                <div class="row">

                    <div class="col-xl-8 col-lg-8">

                        <div class="forecast-card">

                            <div class="forecast-card-header">

                                <div>
                                    <h5 class="forecast-card-title">
                                        <i class="fas fa-chart-area"></i>
                                        Évolution prévisionnelle de la trésorerie
                                    </h5>

                                    <span class="forecast-card-subtitle">
                                        Comparaison des flux prévus et du solde projeté sur les 90 prochains jours.
                                    </span>
                                </div>

                                <select class="form-control form-control-sm" style="width:165px;border-radius:8px;"
                                    id="forecastChartPeriod">

                                    <option value="90">90 prochains jours</option>
                                    <option value="30">30 prochains jours</option>
                                    <option value="60">60 prochains jours</option>
                                    <option value="365">12 prochains mois</option>
                                </select>

                            </div>

                            <div class="forecast-card-body">

                                <div class="forecast-summary-row">

                                    <div class="forecast-summary-item">
                                        <span>Total encaissements prévus</span>
                                        <strong class="text-success">
                                            + 265 500 000 BIF
                                        </strong>
                                    </div>

                                    <div class="forecast-summary-item">
                                        <span>Total décaissements prévus</span>
                                        <strong class="text-danger">
                                            - 246 100 000 BIF
                                        </strong>
                                    </div>

                                    <div class="forecast-summary-item">
                                        <span>Solde net prévisionnel</span>
                                        <strong style="color:#0f766e;">
                                            + 19 400 000 BIF
                                        </strong>
                                    </div>

                                </div>

                                <div class="forecast-chart-wrapper">
                                    <canvas id="treasuryForecastChart"></canvas>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-4 col-lg-4">

                        <div class="forecast-card">

                            <div class="forecast-card-header">

                                <div>
                                    <h5 class="forecast-card-title">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Alertes prévisionnelles
                                    </h5>

                                    <span class="forecast-card-subtitle">
                                        Risques détectés dans les projections.
                                    </span>
                                </div>

                                <span class="badge badge-danger">
                                    4 alertes
                                </span>

                            </div>

                            <div class="forecast-card-body">

                                <div class="forecast-alert forecast-alert-danger">

                                    <div class="forecast-alert-icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>

                                    <div>
                                        <h6>Risque de rupture — Chantier Ngozi</h6>

                                        <p>
                                            Le solde prévisionnel pourrait devenir insuffisant
                                            dans les 14 prochains jours.
                                        </p>
                                    </div>

                                </div>

                                <div class="forecast-alert forecast-alert-warning">

                                    <div class="forecast-alert-icon">
                                        <i class="fas fa-users"></i>
                                    </div>

                                    <div>
                                        <h6>Paiement des salaires à anticiper</h6>

                                        <p>
                                            Un besoin de 20 000 000 BIF est prévu avant
                                            la prochaine paie.
                                        </p>
                                    </div>

                                </div>

                                <div class="forecast-alert forecast-alert-info">

                                    <div class="forecast-alert-icon">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>

                                    <div>
                                        <h6>Encaissement client non sécurisé</h6>

                                        <p>
                                            Le paiement de 45 000 000 BIF attendu du client
                                            REGIDESO reste incertain.
                                        </p>
                                    </div>

                                </div>

                                <div class="forecast-alert forecast-alert-success">

                                    <div class="forecast-alert-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>

                                    <div>
                                        <h6>Chantier Bujumbura suffisamment couvert</h6>

                                        <p>
                                            Les disponibilités prévues couvrent les besoins
                                            des 60 prochains jours.
                                        </p>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- =====================================================
         PRÉVISIONS ENCAISSEMENTS
    ====================================================== -->
                <div class="forecast-card">

                    <div class="forecast-card-header">

                        <div>
                            <h5 class="forecast-card-title">
                                <i class="fas fa-arrow-circle-down"></i>
                                Encaissements prévus
                            </h5>

                            <span class="forecast-card-subtitle">
                                Entrées de fonds attendues provenant des clients, marchés et autres partenaires.
                            </span>
                        </div>

                        <button type="button" class="btn btn-forecast-primary" data-toggle="modal"
                            data-target="#addForecastIncomeModal">

                            <i class="fas fa-plus mr-1"></i>
                            Ajouter une prévision
                        </button>

                    </div>

                    <div class="table-responsive">

                        <table class="table forecast-table">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date prévue</th>
                                    <th>Référence</th>
                                    <th>Client / Provenance</th>
                                    <th>Chantier</th>
                                    <th>Libellé</th>
                                    <th class="text-right">Montant</th>
                                    <th>Probabilité</th>
                                    <th>Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>1</td>

                                    <td>
                                        20/07/2026
                                        <small class="d-block text-muted">
                                            Dans 5 jours
                                        </small>
                                    </td>

                                    <td>
                                        <span class="forecast-reference">
                                            PRE-ENC-2026-001
                                        </span>
                                    </td>

                                    <td>
                                        <strong>REGIDESO</strong>
                                        <small class="d-block text-muted">
                                            Client institutionnel
                                        </small>
                                    </td>

                                    <td>
                                        Chantier Bujumbura
                                        <small class="d-block text-muted">
                                            CH-2026-001
                                        </small>
                                    </td>

                                    <td>
                                        Paiement décompte n° 05
                                    </td>

                                    <td class="text-right amount-income">
                                        + 45 000 000 BIF
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-green">
                                            95 %
                                        </span>
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-green">
                                            Très probable
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <button class="btn-forecast-table" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn-forecast-table" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>

                                    <td>
                                        28/07/2026
                                        <small class="d-block text-muted">
                                            Dans 13 jours
                                        </small>
                                    </td>

                                    <td>
                                        <span class="forecast-reference">
                                            PRE-ENC-2026-002
                                        </span>
                                    </td>

                                    <td>
                                        <strong>Commune de Gitega</strong>
                                        <small class="d-block text-muted">
                                            Maître d’ouvrage
                                        </small>
                                    </td>

                                    <td>
                                        Chantier Gitega
                                        <small class="d-block text-muted">
                                            CH-2026-002
                                        </small>
                                    </td>

                                    <td>
                                        Avance sur travaux
                                    </td>

                                    <td class="text-right amount-income">
                                        + 18 000 000 BIF
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-orange">
                                            80 %
                                        </span>
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-orange">
                                            Probable
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>

                                    <td>
                                        10/08/2026
                                        <small class="d-block text-muted">
                                            Dans 26 jours
                                        </small>
                                    </td>

                                    <td>
                                        <span class="forecast-reference">
                                            PRE-ENC-2026-003
                                        </span>
                                    </td>

                                    <td>
                                        <strong>Office Burundais des Routes</strong>
                                        <small class="d-block text-muted">
                                            Client public
                                        </small>
                                    </td>

                                    <td>
                                        Chantier Ngozi
                                        <small class="d-block text-muted">
                                            CH-2026-003
                                        </small>
                                    </td>

                                    <td>
                                        Paiement situation travaux
                                    </td>

                                    <td class="text-right amount-income">
                                        + 32 000 000 BIF
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-red">
                                            60 %
                                        </span>
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-red">
                                            À confirmer
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>

                                <tr>
                                    <td>4</td>

                                    <td>
                                        18/08/2026
                                        <small class="d-block text-muted">
                                            Dans 34 jours
                                        </small>
                                    </td>

                                    <td>
                                        <span class="forecast-reference">
                                            PRE-ENC-2026-004
                                        </span>
                                    </td>

                                    <td>
                                        <strong>Banque CRDB</strong>
                                        <small class="d-block text-muted">
                                            Institution financière
                                        </small>
                                    </td>

                                    <td>
                                        Siège
                                    </td>

                                    <td>
                                        Mise à disposition crédit
                                    </td>

                                    <td class="text-right amount-income">
                                        + 75 000 000 BIF
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-green">
                                            100 %
                                        </span>
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-blue">
                                            Confirmé
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- =====================================================
         PRÉVISIONS DÉCAISSEMENTS
    ====================================================== -->
                <div class="forecast-card">

                    <div class="forecast-card-header">

                        <div>
                            <h5 class="forecast-card-title">
                                <i class="fas fa-arrow-circle-up"></i>
                                Décaissements prévus
                            </h5>

                            <span class="forecast-card-subtitle">
                                Engagements financiers futurs liés aux fournisseurs, salaires, taxes et chantiers.
                            </span>
                        </div>

                        <button type="button" class="btn btn-forecast-danger" data-toggle="modal"
                            data-target="#addForecastExpenseModal">

                            <i class="fas fa-plus mr-1"></i>
                            Ajouter une dépense prévue
                        </button>

                    </div>

                    <div class="table-responsive">

                        <table class="table forecast-table">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date prévue</th>
                                    <th>Référence</th>
                                    <th>Bénéficiaire</th>
                                    <th>Catégorie</th>
                                    <th>Chantier</th>
                                    <th class="text-right">Montant</th>
                                    <th>Priorité</th>
                                    <th>Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>1</td>

                                    <td>
                                        18/07/2026
                                        <small class="d-block text-muted">
                                            Dans 3 jours
                                        </small>
                                    </td>

                                    <td>
                                        <span class="forecast-reference">
                                            PRE-DEC-2026-001
                                        </span>
                                    </td>

                                    <td>
                                        <strong>Personnel chantier Ngozi</strong>
                                        <small class="d-block text-muted">
                                            Main-d’œuvre
                                        </small>
                                    </td>

                                    <td>Salaires</td>

                                    <td>
                                        Chantier Ngozi
                                        <small class="d-block text-muted">
                                            CH-2026-003
                                        </small>
                                    </td>

                                    <td class="text-right amount-expense">
                                        - 12 500 000 BIF
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-red">
                                            Critique
                                        </span>
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-orange">
                                            À payer
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>

                                    <td>
                                        21/07/2026
                                        <small class="d-block text-muted">
                                            Dans 6 jours
                                        </small>
                                    </td>

                                    <td>
                                        <span class="forecast-reference">
                                            PRE-DEC-2026-002
                                        </span>
                                    </td>

                                    <td>
                                        <strong>TotalEnergies Burundi</strong>
                                        <small class="d-block text-muted">
                                            Fournisseur carburant
                                        </small>
                                    </td>

                                    <td>Carburant</td>

                                    <td>
                                        Chantier Bujumbura
                                        <small class="d-block text-muted">
                                            CH-2026-001
                                        </small>
                                    </td>

                                    <td class="text-right amount-expense">
                                        - 6 800 000 BIF
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-orange">
                                            Haute
                                        </span>
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-green">
                                            Approuvé
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>

                                    <td>
                                        24/07/2026
                                        <small class="d-block text-muted">
                                            Dans 9 jours
                                        </small>
                                    </td>

                                    <td>
                                        <span class="forecast-reference">
                                            PRE-DEC-2026-003
                                        </span>
                                    </td>

                                    <td>
                                        <strong>ABC Construction</strong>
                                        <small class="d-block text-muted">
                                            Sous-traitant
                                        </small>
                                    </td>

                                    <td>Sous-traitance</td>

                                    <td>
                                        Chantier Gitega
                                        <small class="d-block text-muted">
                                            CH-2026-002
                                        </small>
                                    </td>

                                    <td class="text-right amount-expense">
                                        - 18 500 000 BIF
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-blue">
                                            Normale
                                        </span>
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-orange">
                                            Planifié
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>

                                <tr>
                                    <td>4</td>

                                    <td>
                                        31/07/2026
                                        <small class="d-block text-muted">
                                            Dans 16 jours
                                        </small>
                                    </td>

                                    <td>
                                        <span class="forecast-reference">
                                            PRE-DEC-2026-004
                                        </span>
                                    </td>

                                    <td>
                                        <strong>Office Burundais des Recettes</strong>
                                        <small class="d-block text-muted">
                                            Administration fiscale
                                        </small>
                                    </td>

                                    <td>Impôts et taxes</td>

                                    <td>Siège</td>

                                    <td class="text-right amount-expense">
                                        - 21 300 000 BIF
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-red">
                                            Critique
                                        </span>
                                    </td>

                                    <td>
                                        <span class="forecast-badge forecast-badge-green">
                                            Confirmé
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn-forecast-table">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- =====================================================
         PROJECTION PAR CHANTIER + RÉPARTITION DÉPENSES
    ====================================================== -->
                <div class="row">

                    <div class="col-xl-8 col-lg-8">

                        <div class="forecast-card">

                            <div class="forecast-card-header">

                                <div>
                                    <h5 class="forecast-card-title">
                                        <i class="fas fa-hard-hat"></i>
                                        Projection de trésorerie par chantier
                                    </h5>

                                    <span class="forecast-card-subtitle">
                                        Solde projeté après prise en compte des encaissements et décaissements.
                                    </span>
                                </div>

                            </div>

                            <div class="table-responsive">

                                <table class="table forecast-table">

                                    <thead>
                                        <tr>
                                            <th>Chantier</th>
                                            <th class="text-right">Solde actuel</th>
                                            <th class="text-right">Encaissements</th>
                                            <th class="text-right">Décaissements</th>
                                            <th class="text-right">Solde futur</th>
                                            <th>Couverture</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td>
                                                <strong>Chantier Bujumbura</strong>
                                                <small class="d-block text-muted">
                                                    CH-2026-001
                                                </small>
                                            </td>

                                            <td class="text-right">
                                                58 000 000
                                            </td>

                                            <td class="text-right amount-income">
                                                + 45 000 000
                                            </td>

                                            <td class="text-right amount-expense">
                                                - 37 000 000
                                            </td>

                                            <td class="text-right font-weight-bold">
                                                66 000 000
                                            </td>

                                            <td style="min-width:180px;">

                                                <div class="forecast-progress mb-1">
                                                    <span class="progress-green" style="width:82%;"></span>
                                                </div>

                                                <small>Couverture satisfaisante : 82 %</small>
                                            </td>

                                        </tr>

                                        <tr>

                                            <td>
                                                <strong>Chantier Gitega</strong>
                                                <small class="d-block text-muted">
                                                    CH-2026-002
                                                </small>
                                            </td>

                                            <td class="text-right">
                                                43 000 000
                                            </td>

                                            <td class="text-right amount-income">
                                                + 18 000 000
                                            </td>

                                            <td class="text-right amount-expense">
                                                - 29 000 000
                                            </td>

                                            <td class="text-right font-weight-bold">
                                                32 000 000
                                            </td>

                                            <td>

                                                <div class="forecast-progress mb-1">
                                                    <span class="progress-orange" style="width:58%;"></span>
                                                </div>

                                                <small>Couverture moyenne : 58 %</small>
                                            </td>

                                        </tr>

                                        <tr>

                                            <td>
                                                <strong>Chantier Ngozi</strong>
                                                <small class="d-block text-muted">
                                                    CH-2026-003
                                                </small>
                                            </td>

                                            <td class="text-right">
                                                25 000 000
                                            </td>

                                            <td class="text-right amount-income">
                                                + 10 000 000
                                            </td>

                                            <td class="text-right amount-expense">
                                                - 31 000 000
                                            </td>

                                            <td class="text-right text-danger font-weight-bold">
                                                4 000 000
                                            </td>

                                            <td>

                                                <div class="forecast-progress mb-1">
                                                    <span class="progress-red" style="width:18%;"></span>
                                                </div>

                                                <small class="text-danger">
                                                    Risque élevé : 18 %
                                                </small>
                                            </td>

                                        </tr>

                                        <tr>

                                            <td>
                                                <strong>Chantier Muyinga</strong>
                                                <small class="d-block text-muted">
                                                    CH-2026-004
                                                </small>
                                            </td>

                                            <td class="text-right">
                                                38 000 000
                                            </td>

                                            <td class="text-right amount-income">
                                                + 22 000 000
                                            </td>

                                            <td class="text-right amount-expense">
                                                - 24 500 000
                                            </td>

                                            <td class="text-right font-weight-bold">
                                                35 500 000
                                            </td>

                                            <td>

                                                <div class="forecast-progress mb-1">
                                                    <span class="progress-blue" style="width:66%;"></span>
                                                </div>

                                                <small>Couverture correcte : 66 %</small>
                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-4 col-lg-4">

                        <div class="forecast-card">

                            <div class="forecast-card-header">

                                <div>
                                    <h5 class="forecast-card-title">
                                        <i class="fas fa-chart-pie"></i>
                                        Dépenses futures par catégorie
                                    </h5>

                                    <span class="forecast-card-subtitle">
                                        Répartition des engagements prévus.
                                    </span>
                                </div>

                            </div>

                            <div class="forecast-card-body">

                                <div class="forecast-category-item">

                                    <div class="forecast-category-top">
                                        <span class="forecast-category-name">
                                            <i class="fas fa-users"></i>
                                            Salaires
                                        </span>

                                        <span class="forecast-category-amount">
                                            57,5 M
                                        </span>
                                    </div>

                                    <div class="forecast-progress">
                                        <span class="progress-red" style="width:82%;"></span>
                                    </div>

                                </div>

                                <div class="forecast-category-item">

                                    <div class="forecast-category-top">
                                        <span class="forecast-category-name">
                                            <i class="fas fa-truck"></i>
                                            Fournisseurs
                                        </span>

                                        <span class="forecast-category-amount">
                                            43,1 M
                                        </span>
                                    </div>

                                    <div class="forecast-progress">
                                        <span class="progress-orange" style="width:68%;"></span>
                                    </div>

                                </div>

                                <div class="forecast-category-item">

                                    <div class="forecast-category-top">
                                        <span class="forecast-category-name">
                                            <i class="fas fa-user-tie"></i>
                                            Sous-traitants
                                        </span>

                                        <span class="forecast-category-amount">
                                            32,3 M
                                        </span>
                                    </div>

                                    <div class="forecast-progress">
                                        <span class="progress-blue" style="width:51%;"></span>
                                    </div>

                                </div>

                                <div class="forecast-category-item">

                                    <div class="forecast-category-top">
                                        <span class="forecast-category-name">
                                            <i class="fas fa-gas-pump"></i>
                                            Carburant
                                        </span>

                                        <span class="forecast-category-amount">
                                            26,9 M
                                        </span>
                                    </div>

                                    <div class="forecast-progress">
                                        <span class="progress-orange" style="width:42%;"></span>
                                    </div>

                                </div>

                                <div class="forecast-category-item">

                                    <div class="forecast-category-top">
                                        <span class="forecast-category-name">
                                            <i class="fas fa-university"></i>
                                            Impôts et taxes
                                        </span>

                                        <span class="forecast-category-amount">
                                            12,6 M
                                        </span>
                                    </div>

                                    <div class="forecast-progress">
                                        <span class="progress-green" style="width:24%;"></span>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- =====================================================
         PLAN D'ACTION
    ====================================================== -->
                <div class="row">

                    <div class="col-xl-8 col-lg-8">

                        <div class="forecast-card">

                            <div class="forecast-card-header">

                                <div>
                                    <h5 class="forecast-card-title">
                                        <i class="fas fa-tasks"></i>
                                        Plan d’action recommandé
                                    </h5>

                                    <span class="forecast-card-subtitle">
                                        Actions proposées pour sécuriser la trésorerie future.
                                    </span>
                                </div>

                                <span class="badge badge-info">
                                    4 recommandations
                                </span>

                            </div>

                            <div class="forecast-card-body">

                                <div class="forecast-plan-item">

                                    <div class="forecast-plan-number">1</div>

                                    <div>
                                        <h6>Approvisionner la caisse du chantier Ngozi</h6>

                                        <p>
                                            Prévoir un transfert de 15 000 000 BIF avant le
                                            22/07/2026 afin d’éviter une rupture de trésorerie.
                                        </p>
                                    </div>

                                </div>

                                <div class="forecast-plan-item">

                                    <div class="forecast-plan-number">2</div>

                                    <div>
                                        <h6>Relancer le client REGIDESO</h6>

                                        <p>
                                            Confirmer la date de règlement du décompte de
                                            45 000 000 BIF attendu le 20/07/2026.
                                        </p>
                                    </div>

                                </div>

                                <div class="forecast-plan-item">

                                    <div class="forecast-plan-number">3</div>

                                    <div>
                                        <h6>Reporter un paiement fournisseur non prioritaire</h6>

                                        <p>
                                            Négocier le report d’une échéance de 8 500 000 BIF
                                            pour préserver la liquidité disponible.
                                        </p>
                                    </div>

                                </div>

                                <div class="forecast-plan-item">

                                    <div class="forecast-plan-number">4</div>

                                    <div>
                                        <h6>Renforcer la réserve du chantier Gitega</h6>

                                        <p>
                                            Programmer un transfert bancaire de 20 000 000 BIF
                                            avant le démarrage de la prochaine phase des travaux.
                                        </p>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-4 col-lg-4">

                        <div class="forecast-card">

                            <div class="forecast-card-header">

                                <div>
                                    <h5 class="forecast-card-title">
                                        <i class="fas fa-shield-alt"></i>
                                        Indicateurs de couverture
                                    </h5>

                                    <span class="forecast-card-subtitle">
                                        Capacité à couvrir les engagements futurs.
                                    </span>
                                </div>

                            </div>

                            <div class="forecast-card-body">

                                <div class="forecast-category-item">

                                    <div class="forecast-category-top">
                                        <span class="forecast-category-name">
                                            Couverture à 30 jours
                                        </span>

                                        <span class="forecast-category-amount text-success">
                                            110,4 %
                                        </span>
                                    </div>

                                    <div class="forecast-progress">
                                        <span class="progress-green" style="width:100%;"></span>
                                    </div>

                                </div>

                                <div class="forecast-category-item">

                                    <div class="forecast-category-top">
                                        <span class="forecast-category-name">
                                            Couverture à 60 jours
                                        </span>

                                        <span class="forecast-category-amount text-warning">
                                            86,8 %
                                        </span>
                                    </div>

                                    <div class="forecast-progress">
                                        <span class="progress-orange" style="width:86.8%;"></span>
                                    </div>

                                </div>

                                <div class="forecast-category-item">

                                    <div class="forecast-category-top">
                                        <span class="forecast-category-name">
                                            Couverture à 90 jours
                                        </span>

                                        <span class="forecast-category-amount text-danger">
                                            72,5 %
                                        </span>
                                    </div>

                                    <div class="forecast-progress">
                                        <span class="progress-red" style="width:72.5%;"></span>
                                    </div>

                                </div>

                                <div class="forecast-alert forecast-alert-warning mt-4 mb-0">

                                    <div class="forecast-alert-icon">
                                        <i class="fas fa-lightbulb"></i>
                                    </div>

                                    <div>
                                        <h6>Besoin de financement estimé</h6>

                                        <p>
                                            Un financement complémentaire de
                                            <strong>47 150 000 BIF</strong> pourrait être nécessaire.
                                        </p>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- =========================================================
     MODALE : ENCAISSEMENT PRÉVU
========================================================== -->
            <div class="modal fade modal-forecast" id="addForecastIncomeModal" tabindex="-1" role="dialog">

                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                    <form action="#" method="post" style="width:100%;">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    <i class="fas fa-arrow-circle-down mr-2"></i>
                                    Ajouter un encaissement prévu
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
                                                Date prévue
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="date" name="forecast_date" class="form-control" required>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>
                                                Client / Provenance
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="text" name="client" class="form-control"
                                                placeholder="Nom du client ou de la provenance" required>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Chantier concerné</label>

                                            <select name="chantier_id" class="form-control">
                                                <option value="">Siège / Non affecté</option>
                                                <option value="1">Chantier Bujumbura</option>
                                                <option value="2">Chantier Gitega</option>
                                                <option value="3">Chantier Ngozi</option>
                                                <option value="4">Chantier Muyinga</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>
                                                Montant prévu
                                                <span class="required-star">*</span>
                                            </label>

                                            <div class="input-group">

                                                <input type="number" name="amount" class="form-control" min="0"
                                                    step="0.01" required>

                                                <div class="input-group-append">
                                                    <span class="input-group-text">BIF</span>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Probabilité d’encaissement</label>

                                            <select name="probability" class="form-control">
                                                <option value="100">100 % — Confirmé</option>
                                                <option value="95">95 % — Très probable</option>
                                                <option value="80">80 % — Probable</option>
                                                <option value="60">60 % — Incertain</option>
                                                <option value="30">30 % — Faible</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Catégorie</label>

                                            <select name="category" class="form-control">
                                                <option value="client">Paiement client</option>
                                                <option value="advance">Avance sur marché</option>
                                                <option value="loan">Emprunt</option>
                                                <option value="refund">Remboursement</option>
                                                <option value="other">Autre produit</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label>
                                                Libellé
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="text" name="label" class="form-control"
                                                placeholder="Ex. Paiement du décompte n° 05" required>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group mb-0">
                                            <label>Observation</label>

                                            <textarea name="observation" class="form-control"
                                                placeholder="Informations complémentaires..."></textarea>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-forecast-outline" data-dismiss="modal">

                                    <i class="fas fa-times mr-1"></i>
                                    Annuler
                                </button>

                                <button type="submit" class="btn btn-forecast-primary">

                                    <i class="fas fa-save mr-1"></i>
                                    Enregistrer la prévision
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <!-- =========================================================
     MODALE : DÉCAISSEMENT PRÉVU
========================================================== -->
            <div class="modal fade modal-forecast" id="addForecastExpenseModal" tabindex="-1" role="dialog">

                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                    <form action="#" method="post" style="width:100%;">

                        <div class="modal-content">

                            <div class="modal-header" style="background:linear-gradient(135deg,#991b1b,#102033);">

                                <h5 class="modal-title">
                                    <i class="fas fa-arrow-circle-up mr-2"></i>
                                    Ajouter un décaissement prévu
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
                                                Date prévue
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="date" name="forecast_date" class="form-control" required>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>
                                                Bénéficiaire
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="text" name="supplier" class="form-control"
                                                placeholder="Fournisseur ou bénéficiaire" required>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Chantier concerné</label>

                                            <select name="chantier_id" class="form-control">
                                                <option value="">Siège / Non affecté</option>
                                                <option value="1">Chantier Bujumbura</option>
                                                <option value="2">Chantier Gitega</option>
                                                <option value="3">Chantier Ngozi</option>
                                                <option value="4">Chantier Muyinga</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>
                                                Montant prévu
                                                <span class="required-star">*</span>
                                            </label>

                                            <div class="input-group">

                                                <input type="number" name="amount" class="form-control" min="0"
                                                    step="0.01" required>

                                                <div class="input-group-append">
                                                    <span class="input-group-text">BIF</span>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Catégorie</label>

                                            <select name="category" class="form-control">
                                                <option value="salary">Salaires</option>
                                                <option value="supplier">Fournisseur</option>
                                                <option value="subcontractor">Sous-traitance</option>
                                                <option value="fuel">Carburant</option>
                                                <option value="tax">Impôts et taxes</option>
                                                <option value="maintenance">Maintenance</option>
                                                <option value="other">Autre dépense</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Priorité</label>

                                            <select name="priority" class="form-control">
                                                <option value="normal">Normale</option>
                                                <option value="high">Haute</option>
                                                <option value="critical">Critique</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label>
                                                Libellé
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="text" name="label" class="form-control"
                                                placeholder="Ex. Paiement facture carburant" required>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group mb-0">
                                            <label>Observation</label>

                                            <textarea name="observation" class="form-control"
                                                placeholder="Informations complémentaires..."></textarea>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-forecast-outline" data-dismiss="modal">

                                    <i class="fas fa-times mr-1"></i>
                                    Annuler
                                </button>

                                <button type="submit" class="btn btn-forecast-danger">

                                    <i class="fas fa-save mr-1"></i>
                                    Enregistrer la prévision
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <!-- =========================================================
     MODALE : SIMULATION
========================================================== -->
            <div class="modal fade modal-forecast" id="forecastScenarioModal" tabindex="-1" role="dialog">

                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                    <form action="#" method="post" style="width:100%;">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    <i class="fas fa-project-diagram mr-2"></i>
                                    Simuler un scénario de trésorerie
                                </h5>

                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>

                            </div>

                            <div class="modal-body">

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Nom du scénario</label>

                                            <input type="text" name="scenario_name" class="form-control"
                                                placeholder="Ex. Retard paiement client REGIDESO">
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Horizon</label>

                                            <select name="period" class="form-control">
                                                <option value="30">30 jours</option>
                                                <option value="60">60 jours</option>
                                                <option value="90">90 jours</option>
                                                <option value="365">12 mois</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Variation des encaissements</label>

                                            <div class="input-group">

                                                <input type="number" name="income_variation" class="form-control"
                                                    value="0">

                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Variation des décaissements</label>

                                            <div class="input-group">

                                                <input type="number" name="expense_variation" class="form-control"
                                                    value="0">

                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group mb-0">
                                            <label>Description du scénario</label>

                                            <textarea name="description" class="form-control"
                                                placeholder="Décrivez les hypothèses de la simulation..."></textarea>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-forecast-outline" data-dismiss="modal">

                                    <i class="fas fa-times mr-1"></i>
                                    Annuler
                                </button>

                                <button type="submit" class="btn btn-forecast-primary">

                                    <i class="fas fa-calculator mr-1"></i>
                                    Lancer la simulation
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <!-- =========================================================
     GRAPHIQUE CHART.JS
========================================================== -->
            <script>
            document.addEventListener('DOMContentLoaded', function() {

                const canvas = document.getElementById('treasuryForecastChart');

                if (!canvas || typeof Chart === 'undefined') {
                    return;
                }

                const ctx = canvas.getContext('2d');

                const balanceGradient = ctx.createLinearGradient(0, 0, 0, 320);

                balanceGradient.addColorStop(
                    0,
                    'rgba(15, 118, 110, 0.28)'
                );

                balanceGradient.addColorStop(
                    1,
                    'rgba(15, 118, 110, 0.02)'
                );

                new Chart(ctx, {

                    type: 'line',

                    data: {

                        labels: [
                            'Aujourd’hui',
                            '+ 7 jours',
                            '+ 15 jours',
                            '+ 30 jours',
                            '+ 60 jours',
                            '+ 90 jours'
                        ],

                        datasets: [{
                                label: 'Solde prévisionnel',

                                data: [
                                    245600000,
                                    228500000,
                                    214300000,
                                    198450000,
                                    173200000,
                                    265000000
                                ],

                                borderColor: '#0f766e',
                                backgroundColor: balanceGradient,
                                borderWidth: 3,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#0f766e',
                                pointBorderWidth: 2,
                                fill: true,
                                tension: 0.35
                            },
                            {
                                label: 'Encaissements prévus',

                                data: [
                                    0,
                                    38000000,
                                    65000000,
                                    132500000,
                                    185000000,
                                    265500000
                                ],

                                borderColor: '#0284c7',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                borderDash: [6, 5],
                                pointRadius: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#0284c7',
                                fill: false,
                                tension: 0.30
                            },
                            {
                                label: 'Décaissements prévus',

                                data: [
                                    0,
                                    55100000,
                                    96300000,
                                    179650000,
                                    257400000,
                                    246100000
                                ],

                                borderColor: '#dc2626',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                borderDash: [4, 4],
                                pointRadius: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#dc2626',
                                fill: false,
                                tension: 0.30
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

                                    label: function(context) {

                                        return context.dataset.label +
                                            ' : ' +
                                            new Intl.NumberFormat('fr-FR').format(
                                                context.parsed.y
                                            ) +
                                            ' BIF';
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
                                    color: 'rgba(148, 163, 184, 0.16)'
                                },

                                ticks: {

                                    font: {
                                        size: 10
                                    },

                                    callback: function(value) {
                                        return (
                                            value / 1000000
                                        ) + ' M';
                                    }
                                }
                            }
                        }
                    }
                });
            });
            </script>

        </div>

    </section>

</div>