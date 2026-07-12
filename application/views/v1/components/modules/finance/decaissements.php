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

            <!-- =========================================================
                 STATISTIQUES
            ========================================================== -->
            <div class="row">

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="dec-stat-card">

                        <div class="dec-stat-top">

                            <div class="dec-stat-icon dec-icon-red">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>

                            <span class="dec-stat-badge dec-badge-danger">
                                <i class="fas fa-arrow-up mr-1"></i>
                                9,8 %
                            </span>

                        </div>

                        <div class="dec-stat-label">
                            Total décaissé ce mois
                        </div>

                        <div class="dec-stat-value">
                            342 650 000 BIF
                        </div>

                        <div class="dec-stat-footer">
                            Tous les paiements validés du mois
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="dec-stat-card">

                        <div class="dec-stat-top">

                            <div class="dec-stat-icon dec-icon-blue">
                                <i class="fas fa-calendar-day"></i>
                            </div>

                            <span class="dec-stat-badge dec-badge-info">
                                17 opérations
                            </span>

                        </div>

                        <div class="dec-stat-label">
                            Décaissements du jour
                        </div>

                        <div class="dec-stat-value">
                            24 750 000 BIF
                        </div>

                        <div class="dec-stat-footer">
                            Sorties enregistrées aujourd’hui
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="dec-stat-card">

                        <div class="dec-stat-top">

                            <div class="dec-stat-icon dec-icon-orange">
                                <i class="fas fa-hourglass-half"></i>
                            </div>

                            <span class="dec-stat-badge dec-badge-warning">
                                11 demandes
                            </span>

                        </div>

                        <div class="dec-stat-label">
                            En attente de paiement
                        </div>

                        <div class="dec-stat-value">
                            96 400 000 BIF
                        </div>

                        <div class="dec-stat-footer">
                            Demandes approuvées non encore payées
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="dec-stat-card">

                        <div class="dec-stat-top">

                            <div class="dec-stat-icon dec-icon-green">
                                <i class="fas fa-wallet"></i>
                            </div>

                            <span class="dec-stat-badge dec-badge-success">
                                Disponible
                            </span>

                        </div>

                        <div class="dec-stat-label">
                            Trésorerie disponible
                        </div>

                        <div class="dec-stat-value">
                            245 600 000 BIF
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
                                    Analyse comparative des paiements réalisés et du budget prévu.
                                </span>

                            </div>

                            <select class="form-control dec-period-select">
                                <option>6 derniers mois</option>
                                <option>12 derniers mois</option>
                                <option>Cette année</option>
                                <option>Année précédente</option>
                            </select>

                        </div>

                        <div class="dec-card-body">

                            <div class="dec-chart-container">
                                <canvas id="decaissementChart"></canvas>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-xl-4 col-lg-4">

                    <div class="dec-card">

                        <div class="dec-card-header">

                            <div>

                                <h5 class="dec-card-title">
                                    <i class="fas fa-chart-pie"></i>
                                    Répartition des dépenses
                                </h5>

                                <span class="dec-card-subtitle">
                                    Principales catégories de décaissements.
                                </span>

                            </div>

                        </div>

                        <div class="dec-card-body">

                            <div class="dec-category-item">

                                <div class="dec-category-header">

                                    <span class="dec-category-name">
                                        <i class="fas fa-truck-loading"></i>
                                        Fournisseurs
                                    </span>

                                    <span class="dec-category-value">
                                        112,5 M
                                    </span>

                                </div>

                                <div class="dec-category-progress">
                                    <span style="width: 88%;"></span>
                                </div>

                            </div>

                            <div class="dec-category-item">

                                <div class="dec-category-header">

                                    <span class="dec-category-name">
                                        <i class="fas fa-users"></i>
                                        Salaires et main-d’œuvre
                                    </span>

                                    <span class="dec-category-value">
                                        82,7 M
                                    </span>

                                </div>

                                <div class="dec-category-progress">
                                    <span style="width: 70%;"></span>
                                </div>

                            </div>

                            <div class="dec-category-item">

                                <div class="dec-category-header">

                                    <span class="dec-category-name">
                                        <i class="fas fa-user-tie"></i>
                                        Sous-traitants
                                    </span>

                                    <span class="dec-category-value">
                                        68,4 M
                                    </span>

                                </div>

                                <div class="dec-category-progress">
                                    <span style="width: 58%;"></span>
                                </div>

                            </div>

                            <div class="dec-category-item">

                                <div class="dec-category-header">

                                    <span class="dec-category-name">
                                        <i class="fas fa-gas-pump"></i>
                                        Carburant
                                    </span>

                                    <span class="dec-category-value">
                                        45,5 M
                                    </span>

                                </div>

                                <div class="dec-category-progress">
                                    <span style="width: 42%;"></span>
                                </div>

                            </div>

                            <div class="dec-category-item">

                                <div class="dec-category-header">

                                    <span class="dec-category-name">
                                        <i class="fas fa-landmark"></i>
                                        Impôts et taxes
                                    </span>

                                    <span class="dec-category-value">
                                        33,5 M
                                    </span>

                                </div>

                                <div class="dec-category-progress">
                                    <span style="width: 30%;"></span>
                                </div>

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

            <!-- =========================================================
                 TABLEAU
            ========================================================== -->
            <div class="dec-card">

                <div class="dec-card-header">

                    <div>

                        <h5 class="dec-card-title">
                            <i class="fas fa-list"></i>
                            Historique des décaissements
                        </h5>

                        <span class="dec-card-subtitle">
                            Liste des sorties de fonds enregistrées dans la trésorerie.
                        </span>

                    </div>

                    <button class="btn btn-dec-danger" data-toggle="modal" data-target="#addDecaissementModal">

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
                                <th>Caisse / Compte</th>
                                <th>Mode</th>
                                <th>Pièce</th>
                                <th>Chantier</th>
                                <th class="text-right">Montant</th>
                                <th>Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>1</td>

                                <td>
                                    12/07/2026
                                    <small class="d-block text-muted">
                                        11:30
                                    </small>
                                </td>

                                <td>
                                    <span class="dec-reference">
                                        DEC-2026-00058
                                    </span>
                                </td>

                                <td class="dec-beneficiary">
                                    <strong>TotalEnergies Burundi</strong>
                                    <small>Fournisseur carburant</small>
                                </td>

                                <td class="dec-label">
                                    <strong>Achat carburant engins</strong>
                                    <small>Carburant et lubrifiants</small>
                                </td>

                                <td>
                                    <strong>CRDB BIF</strong>
                                    <small class="d-block text-muted">
                                        Compte bancaire
                                    </small>
                                </td>

                                <td>
                                    <span class="dec-badge dec-mode-bank">
                                        <i class="fas fa-university mr-1"></i>
                                        Virement
                                    </span>
                                </td>

                                <td>
                                    <strong>FAC-2026-085</strong>
                                    <small class="d-block text-muted">
                                        Facture jointe
                                    </small>
                                </td>

                                <td>
                                    Chantier Bujumbura
                                </td>

                                <td class="text-right dec-amount">
                                    - 18 500 000
                                </td>

                                <td>
                                    <span class="dec-badge dec-status-valid">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Payé
                                    </span>
                                </td>

                                <td class="text-center">

                                    <button class="dec-action-btn dec-action-view" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="dec-action-btn dec-action-print" title="Imprimer">
                                        <i class="fas fa-print"></i>
                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>2</td>

                                <td>
                                    12/07/2026
                                    <small class="d-block text-muted">
                                        09:45
                                    </small>
                                </td>

                                <td>
                                    <span class="dec-reference">
                                        DEC-2026-00057
                                    </span>
                                </td>

                                <td class="dec-beneficiary">
                                    <strong>ABC Construction</strong>
                                    <small>Sous-traitant</small>
                                </td>

                                <td class="dec-label">
                                    <strong>Paiement situation n° 03</strong>
                                    <small>Travaux de terrassement</small>
                                </td>

                                <td>
                                    <strong>Interbank BIF</strong>
                                    <small class="d-block text-muted">
                                        Compte bancaire
                                    </small>
                                </td>

                                <td>
                                    <span class="dec-badge dec-mode-bank">
                                        Virement
                                    </span>
                                </td>

                                <td>
                                    <strong>SIT-2026-003</strong>
                                    <small class="d-block text-muted">
                                        Situation validée
                                    </small>
                                </td>

                                <td>
                                    Chantier Gitega
                                </td>

                                <td class="text-right dec-amount">
                                    - 35 000 000
                                </td>

                                <td>
                                    <span class="dec-badge dec-status-valid">
                                        Payé
                                    </span>
                                </td>

                                <td class="text-center">

                                    <button class="dec-action-btn dec-action-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="dec-action-btn dec-action-edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="dec-action-btn dec-action-print">
                                        <i class="fas fa-print"></i>
                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>3</td>

                                <td>
                                    11/07/2026
                                    <small class="d-block text-muted">
                                        16:20
                                    </small>
                                </td>

                                <td>
                                    <span class="dec-reference">
                                        DEC-2026-00056
                                    </span>
                                </td>

                                <td class="dec-beneficiary">
                                    <strong>Personnel chantier Ngozi</strong>
                                    <small>Main-d’œuvre journalière</small>
                                </td>

                                <td class="dec-label">
                                    <strong>Paiement hebdomadaire</strong>
                                    <small>Salaires et main-d’œuvre</small>
                                </td>

                                <td>
                                    <strong>Caisse Ngozi</strong>
                                    <small class="d-block text-muted">
                                        Caisse chantier
                                    </small>
                                </td>

                                <td>
                                    <span class="dec-badge dec-mode-cash">
                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                        Espèces
                                    </span>
                                </td>

                                <td>
                                    <strong>PAY-2026-028</strong>
                                    <small class="d-block text-muted">
                                        Liste de paie
                                    </small>
                                </td>

                                <td>
                                    Chantier Ngozi
                                </td>

                                <td class="text-right dec-amount">
                                    - 6 750 000
                                </td>

                                <td>
                                    <span class="dec-badge dec-status-valid">
                                        Payé
                                    </span>
                                </td>

                                <td class="text-center">

                                    <button class="dec-action-btn dec-action-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="dec-action-btn dec-action-print">
                                        <i class="fas fa-print"></i>
                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>4</td>

                                <td>
                                    11/07/2026
                                    <small class="d-block text-muted">
                                        14:05
                                    </small>
                                </td>

                                <td>
                                    <span class="dec-reference">
                                        DEC-2026-00055
                                    </span>
                                </td>

                                <td class="dec-beneficiary">
                                    <strong>Office Burundais des Recettes</strong>
                                    <small>Administration fiscale</small>
                                </td>

                                <td class="dec-label">
                                    <strong>Paiement TVA du mois</strong>
                                    <small>Impôts et taxes</small>
                                </td>

                                <td>
                                    <strong>CRDB BIF</strong>
                                    <small class="d-block text-muted">
                                        Compte bancaire
                                    </small>
                                </td>

                                <td>
                                    <span class="dec-badge dec-mode-bank">
                                        Virement
                                    </span>
                                </td>

                                <td>
                                    <strong>DECL-TVA-07</strong>
                                    <small class="d-block text-muted">
                                        Déclaration fiscale
                                    </small>
                                </td>

                                <td>
                                    Siège
                                </td>

                                <td class="text-right dec-amount">
                                    - 21 800 000
                                </td>

                                <td>
                                    <span class="dec-badge dec-status-pending">
                                        En validation
                                    </span>
                                </td>

                                <td class="text-center">

                                    <button class="dec-action-btn dec-action-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="dec-action-btn dec-action-edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>5</td>

                                <td>
                                    10/07/2026
                                    <small class="d-block text-muted">
                                        10:40
                                    </small>
                                </td>

                                <td>
                                    <span class="dec-reference">
                                        DEC-2026-00054
                                    </span>
                                </td>

                                <td class="dec-beneficiary">
                                    <strong>Caisse chantier Muyinga</strong>
                                    <small>Approvisionnement interne</small>
                                </td>

                                <td class="dec-label">
                                    <strong>Alimentation caisse chantier</strong>
                                    <small>Transfert de trésorerie</small>
                                </td>

                                <td>
                                    <strong>Caisse siège</strong>
                                    <small class="d-block text-muted">
                                        Caisse source
                                    </small>
                                </td>

                                <td>
                                    <span class="dec-badge dec-mode-cash">
                                        Espèces
                                    </span>
                                </td>

                                <td>
                                    <strong>TRF-2026-019</strong>
                                    <small class="d-block text-muted">
                                        Bon de transfert
                                    </small>
                                </td>

                                <td>
                                    Chantier Muyinga
                                </td>

                                <td class="text-right dec-amount">
                                    - 15 000 000
                                </td>

                                <td>
                                    <span class="dec-badge dec-status-valid">
                                        Payé
                                    </span>
                                </td>

                                <td class="text-center">

                                    <button class="dec-action-btn dec-action-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="dec-action-btn dec-action-print">
                                        <i class="fas fa-print"></i>
                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="p-3 border-top d-flex justify-content-between align-items-center">

                    <small class="text-muted">
                        Affichage de 1 à 5 sur 114 décaissements
                    </small>

                    <ul class="pagination pagination-sm mb-0">

                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                Précédent
                            </a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="#">
                                Suivant
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

            <!-- =========================================================
                 PAIEMENTS ATTENDUS + SYNTHÈSE CHANTIERS
            ========================================================== -->
            <div class="row">

                <div class="col-xl-5 col-lg-5">

                    <div class="dec-card">

                        <div class="dec-card-header">

                            <div>

                                <h5 class="dec-card-title">
                                    <i class="fas fa-clock"></i>
                                    Paiements à effectuer
                                </h5>

                                <span class="dec-card-subtitle">
                                    Demandes validées et prêtes pour paiement.
                                </span>

                            </div>

                            <span class="badge badge-danger">
                                4 urgences
                            </span>

                        </div>

                        <div class="dec-card-body">

                            <div class="dec-awaiting-item">

                                <div class="dec-awaiting-icon">
                                    <i class="fas fa-truck-loading"></i>
                                </div>

                                <div class="dec-awaiting-info">
                                    <strong>BUCECO Burundi</strong>
                                    <small>Facture ciment — échéance 13/07/2026</small>
                                </div>

                                <div class="dec-awaiting-amount">
                                    28 500 000 BIF
                                </div>

                            </div>

                            <div class="dec-awaiting-item">

                                <div class="dec-awaiting-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>

                                <div class="dec-awaiting-info">
                                    <strong>Entreprise KAZE</strong>
                                    <small>Situation travaux — échéance 14/07/2026</small>
                                </div>

                                <div class="dec-awaiting-amount">
                                    32 000 000 BIF
                                </div>

                            </div>

                            <div class="dec-awaiting-item">

                                <div class="dec-awaiting-icon">
                                    <i class="fas fa-users"></i>
                                </div>

                                <div class="dec-awaiting-info">
                                    <strong>Personnel chantier Gitega</strong>
                                    <small>Paie hebdomadaire — 15/07/2026</small>
                                </div>

                                <div class="dec-awaiting-amount">
                                    12 400 000 BIF
                                </div>

                            </div>

                            <div class="dec-awaiting-item">

                                <div class="dec-awaiting-icon">
                                    <i class="fas fa-gas-pump"></i>
                                </div>

                                <div class="dec-awaiting-info">
                                    <strong>Engen Burundi</strong>
                                    <small>Facture carburant — 16/07/2026</small>
                                </div>

                                <div class="dec-awaiting-amount">
                                    23 500 000 BIF
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-xl-7 col-lg-7">

                    <div class="dec-card">

                        <div class="dec-card-header">

                            <div>

                                <h5 class="dec-card-title">
                                    <i class="fas fa-hard-hat"></i>
                                    Synthèse des décaissements par chantier
                                </h5>

                                <span class="dec-card-subtitle">
                                    Comparaison entre budget de dépenses et consommation réelle.
                                </span>

                            </div>

                        </div>

                        <div class="table-responsive">

                            <table class="table dec-table">

                                <thead>

                                    <tr>
                                        <th>Chantier</th>
                                        <th class="text-right">Budget</th>
                                        <th class="text-right">Décaissé</th>
                                        <th class="text-right">Disponible</th>
                                        <th>Consommation</th>
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
                                            180 000 000
                                        </td>

                                        <td class="text-right dec-amount">
                                            128 500 000
                                        </td>

                                        <td class="text-right text-success font-weight-bold">
                                            51 500 000
                                        </td>

                                        <td style="min-width: 140px;">

                                            <div class="progress progress-xs mb-1">

                                                <div class="progress-bar bg-success" style="width: 71.4%;">
                                                </div>

                                            </div>

                                            <small>71,4 %</small>

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
                                            150 000 000
                                        </td>

                                        <td class="text-right dec-amount">
                                            124 000 000
                                        </td>

                                        <td class="text-right text-success font-weight-bold">
                                            26 000 000
                                        </td>

                                        <td>

                                            <div class="progress progress-xs mb-1">

                                                <div class="progress-bar bg-warning" style="width: 82.6%;">
                                                </div>

                                            </div>

                                            <small>82,6 %</small>

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
                                            95 000 000
                                        </td>

                                        <td class="text-right dec-amount">
                                            91 700 000
                                        </td>

                                        <td class="text-right text-danger font-weight-bold">
                                            3 300 000
                                        </td>

                                        <td>

                                            <div class="progress progress-xs mb-1">

                                                <div class="progress-bar bg-danger" style="width: 96.5%;">
                                                </div>

                                            </div>

                                            <small>96,5 %</small>

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
                                            125 000 000
                                        </td>

                                        <td class="text-right dec-amount">
                                            76 500 000
                                        </td>

                                        <td class="text-right text-success font-weight-bold">
                                            48 500 000
                                        </td>

                                        <td>

                                            <div class="progress progress-xs mb-1">

                                                <div class="progress-bar bg-info" style="width: 61.2%;">
                                                </div>

                                            </div>

                                            <small>61,2 %</small>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

</div>

<!-- =========================================================
     MODALE : NOUVEAU DÉCAISSEMENT
========================================================== -->
<div class="modal fade dec-modal" id="addDecaissementModal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">

        <form action="<?= base_url('finance/decaissement-store') ?>" method="post" enctype="multipart/form-data"
            style="width: 100%;">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="fas fa-arrow-circle-up mr-2"></i>

                        <span id="decaissementModalTitle">
                            Enregistrer un nouveau décaissement
                        </span>

                    </h5>

                    <button type="button" class="close" data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="dec-section-title">

                        <i class="fas fa-info-circle mr-1"></i>
                        Informations générales

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Référence
                                    <span class="dec-required">*</span>
                                </label>

                                <input type="text" name="reference" class="form-control"
                                    value="DEC-<?= date('Y') ?>-00059" readonly>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Date de décaissement
                                    <span class="dec-required">*</span>
                                </label>

                                <input type="date" name="decaissement_date" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Type de décaissement
                                    <span class="dec-required">*</span>
                                </label>

                                <select name="expense_type" id="expenseType" class="form-control"
                                    onchange="toggleDecaissementFields()" required>

                                    <option value="">
                                        Sélectionner
                                    </option>

                                    <option value="fournisseur">
                                        Paiement fournisseur
                                    </option>

                                    <option value="sous_traitant">
                                        Paiement sous-traitant
                                    </option>

                                    <option value="salaire">
                                        Salaire / Main-d’œuvre
                                    </option>

                                    <option value="chantier">
                                        Approvisionnement chantier
                                    </option>

                                    <option value="carburant">
                                        Carburant
                                    </option>

                                    <option value="taxe">
                                        Impôt et taxe
                                    </option>

                                    <option value="remboursement">
                                        Remboursement emprunt
                                    </option>

                                    <option value="autre">
                                        Autre charge
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="dec-section-title mt-3">

                        <i class="fas fa-user-tie mr-1"></i>
                        Bénéficiaire et affectation

                    </div>

                    <div class="row">

                        <div class="col-md-4" id="beneficiarySelectField">

                            <div class="form-group">

                                <label>
                                    Bénéficiaire
                                    <span class="dec-required">*</span>
                                </label>

                                <select name="beneficiary_id" class="form-control">

                                    <option value="">
                                        Sélectionner le bénéficiaire
                                    </option>

                                    <option value="1">
                                        TotalEnergies Burundi
                                    </option>

                                    <option value="2">
                                        ABC Construction
                                    </option>

                                    <option value="3">
                                        BUCECO Burundi
                                    </option>

                                    <option value="4">
                                        Entreprise KAZE
                                    </option>

                                    <option value="5">
                                        Office Burundais des Recettes
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-4" id="beneficiaryTextField" style="display: none;">

                            <div class="form-group">

                                <label>
                                    Nom du bénéficiaire
                                </label>

                                <input type="text" name="beneficiary_name" class="form-control"
                                    placeholder="Saisir le bénéficiaire">

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Projet / Chantier
                                </label>

                                <select name="chantier_id" class="form-control">

                                    <option value="">
                                        Siège / Non affecté
                                    </option>

                                    <option value="1">
                                        Chantier Bujumbura
                                    </option>

                                    <option value="2">
                                        Chantier Gitega
                                    </option>

                                    <option value="3">
                                        Chantier Ngozi
                                    </option>

                                    <option value="4">
                                        Chantier Muyinga
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Demande de paiement associée
                                </label>

                                <select name="payment_request_id" class="form-control">

                                    <option value="">
                                        Aucune demande associée
                                    </option>

                                    <option value="1">
                                        DP-2026-0048 — BUCECO
                                    </option>

                                    <option value="2">
                                        DP-2026-0047 — ABC Construction
                                    </option>

                                    <option value="3">
                                        DP-2026-0046 — TotalEnergies
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Caisse ou compte débité
                                    <span class="dec-required">*</span>
                                </label>

                                <select name="source_account_id" id="sourceAccount" class="form-control"
                                    onchange="updateSourceBalance()" required>

                                    <option value="">
                                        Sélectionner
                                    </option>

                                    <optgroup label="Caisses">

                                        <option value="cash-1" data-balance="35400000">
                                            Caisse siège
                                        </option>

                                        <option value="cash-2" data-balance="18400000">
                                            Caisse chantier Gitega
                                        </option>

                                        <option value="cash-3" data-balance="32500000">
                                            Caisse chantier Bujumbura
                                        </option>

                                        <option value="cash-4" data-balance="1250000">
                                            Caisse chantier Ngozi
                                        </option>

                                    </optgroup>

                                    <optgroup label="Comptes bancaires">

                                        <option value="bank-1" data-balance="320000000">
                                            CRDB BIF
                                        </option>

                                        <option value="bank-2" data-balance="65000">
                                            CRDB USD
                                        </option>

                                        <option value="bank-3" data-balance="185000000">
                                            ECOBANK BIF
                                        </option>

                                        <option value="bank-4" data-balance="24000">
                                            KCB USD
                                        </option>

                                    </optgroup>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Mode de paiement
                                    <span class="dec-required">*</span>
                                </label>

                                <select name="payment_method" class="form-control" required>

                                    <option value="">
                                        Sélectionner
                                    </option>

                                    <option value="cash">
                                        Espèces
                                    </option>

                                    <option value="bank_transfer">
                                        Virement bancaire
                                    </option>

                                    <option value="cheque">
                                        Chèque
                                    </option>

                                    <option value="mobile_money">
                                        Mobile Money
                                    </option>

                                    <option value="bank_debit">
                                        Prélèvement bancaire
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="dec-balance-box">

                                <small>
                                    Solde disponible du compte sélectionné
                                </small>

                                <strong id="sourceBalance">
                                    0 BIF
                                </strong>

                            </div>

                        </div>

                    </div>

                    <div class="dec-section-title mt-3">

                        <i class="fas fa-money-bill-wave mr-1"></i>
                        Montant et justificatifs

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Montant à décaisser
                                    <span class="dec-required">*</span>
                                </label>

                                <input type="number" name="amount" id="decAmount" class="form-control" min="0"
                                    step="0.01" placeholder="0" required>

                            </div>

                        </div>

                        <div class="col-md-2">

                            <div class="form-group">

                                <label>
                                    Devise
                                    <span class="dec-required">*</span>
                                </label>

                                <select name="currency" class="form-control" required>

                                    <option value="BIF">BIF</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Numéro de transaction
                                </label>

                                <input type="text" name="transaction_number" class="form-control"
                                    placeholder="Virement, chèque, mobile...">

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Numéro de pièce
                                </label>

                                <input type="text" name="document_number" class="form-control"
                                    placeholder="Facture, bon, reçu...">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Pièce justificative
                                </label>

                                <div class="custom-file">

                                    <input type="file" name="attachment" class="custom-file-input"
                                        id="decaissementAttachment" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">

                                    <label class="custom-file-label" for="decaissementAttachment">
                                        Choisir un fichier
                                    </label>

                                </div>

                                <small class="text-muted">
                                    Facture, reçu, bon de paiement ou autre justificatif.
                                </small>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Libellé du décaissement
                                    <span class="dec-required">*</span>
                                </label>

                                <input type="text" name="label" class="form-control"
                                    placeholder="Ex. Paiement facture carburant juillet" required>

                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="form-group mb-0">

                                <label>
                                    Observation
                                </label>

                                <textarea name="observation" class="form-control"
                                    placeholder="Informations complémentaires sur ce paiement..."></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-dec-outline" data-dismiss="modal">

                        <i class="fas fa-times mr-1"></i>
                        Annuler

                    </button>

                    <button type="submit" class="btn btn-dec-danger">

                        <i class="fas fa-check-circle mr-1"></i>
                        Enregistrer le décaissement

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
    document.addEventListener('DOMContentLoaded', function() {

        const canvas = document.getElementById('decaissementChart');

        if (canvas && typeof Chart !== 'undefined') {

            const ctx = canvas.getContext('2d');

            const gradientExpense = ctx.createLinearGradient(0, 0, 0, 300);

            gradientExpense.addColorStop(
                0,
                'rgba(220, 38, 38, 0.28)'
            );

            gradientExpense.addColorStop(
                1,
                'rgba(220, 38, 38, 0.02)'
            );

            new Chart(ctx, {

                type: 'line',

                data: {

                    labels: [
                        'Février',
                        'Mars',
                        'Avril',
                        'Mai',
                        'Juin',
                        'Juillet'
                    ],

                    datasets: [{
                            label: 'Décaissements réalisés',

                            data: [
                                245000000,
                                278000000,
                                265000000,
                                315000000,
                                298000000,
                                342650000
                            ],

                            borderColor: '#dc2626',
                            backgroundColor: gradientExpense,
                            borderWidth: 2.5,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#dc2626',
                            pointBorderWidth: 2,
                            fill: true,
                            tension: 0.35
                        },
                        {
                            label: 'Budget prévu',

                            data: [
                                260000000,
                                290000000,
                                300000000,
                                320000000,
                                330000000,
                                350000000
                            ],

                            borderColor: '#0f766e',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [6, 6],
                            pointRadius: 0,
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
                                color: 'rgba(148, 163, 184, 0.15)'
                            },

                            ticks: {

                                font: {
                                    size: 10
                                },

                                callback: function(value) {
                                    return (value / 1000000) + ' M';
                                }
                            }
                        }
                    }
                }
            });
        }
    });

    function prepareDecaissement(type) {

        const typeField = document.getElementById('expenseType');
        const title = document.getElementById('decaissementModalTitle');

        typeField.value = type;

        if (type === 'fournisseur') {
            title.innerHTML = 'Enregistrer un paiement fournisseur';
        }

        if (type === 'sous_traitant') {
            title.innerHTML = 'Enregistrer un paiement sous-traitant';
        }

        if (type === 'chantier') {
            title.innerHTML = 'Approvisionner une caisse chantier';
        }

        toggleDecaissementFields();
    }

    function toggleDecaissementFields() {

        const type = document.getElementById('expenseType').value;

        const selectField = document.getElementById(
            'beneficiarySelectField'
        );

        const textField = document.getElementById(
            'beneficiaryTextField'
        );

        selectField.style.display = 'block';
        textField.style.display = 'none';

        if (
            type === 'salaire' ||
            type === 'autre' ||
            type === 'remboursement'
        ) {
            selectField.style.display = 'none';
            textField.style.display = 'block';
        }
    }

    function updateSourceBalance() {

        const select = document.getElementById('sourceAccount');
        const selectedOption = select.options[select.selectedIndex];
        const balance = selectedOption.getAttribute('data-balance') || 0;

        document.getElementById('sourceBalance').innerHTML =
            new Intl.NumberFormat('fr-FR').format(balance) + ' BIF';
    }

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
                .html(fileName || 'Choisir un fichier');
        }
    );
</script>