<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper encaissement-page">

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
         CONTENU PRINCIPAL
    ========================================================== -->
    <section class="content">
        <div class="container-fluid">

            <style>
                :root {
                    --enc-primary: #0f766e;
                    --enc-primary-dark: #115e59;
                    --enc-dark: #102033;
                    --enc-green: #16a34a;
                    --enc-blue: #0284c7;
                    --enc-orange: #f59e0b;
                    --enc-red: #dc2626;
                    --enc-purple: #7c3aed;
                    --enc-light: #f8fafc;
                    --enc-border: #e2e8f0;
                    --enc-text: #334155;
                    --enc-muted: #64748b;
                }

                body .content-wrapper {
                    background: #f4f7f6;
                }

                .encaissement-page {
                    color: var(--enc-text);
                    font-family: "Segoe UI", Arial, sans-serif;
                }

                /* =====================================================
                   HERO
                ====================================================== */

                .enc-hero {
                    position: relative;
                    overflow: hidden;
                    margin-bottom: 22px;
                    padding: 24px 27px;
                    color: #fff;
                    border-radius: 16px;
                    background:
                        linear-gradient(135deg,
                            rgba(15, 118, 110, .98),
                            rgba(16, 32, 51, .98));
                    box-shadow: 0 10px 30px rgba(15, 118, 110, .18);
                }

                .enc-hero::before {
                    position: absolute;
                    top: -85px;
                    right: -40px;
                    width: 220px;
                    height: 220px;
                    content: "";
                    border-radius: 50%;
                    background: rgba(255, 255, 255, .08);
                }

                .enc-hero::after {
                    position: absolute;
                    right: 140px;
                    bottom: -120px;
                    width: 210px;
                    height: 210px;
                    content: "";
                    border-radius: 50%;
                    background: rgba(255, 255, 255, .05);
                }

                .enc-hero-content {
                    position: relative;
                    z-index: 2;
                }

                .enc-hero-title {
                    display: flex;
                    align-items: center;
                    margin-bottom: 7px;
                    font-size: 25px;
                    font-weight: 800;
                }

                .enc-hero-icon {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 46px;
                    height: 46px;
                    margin-right: 13px;
                    border-radius: 13px;
                    background: rgba(255, 255, 255, .16);
                }

                .enc-hero p {
                    max-width: 820px;
                    margin: 0;
                    color: rgba(255, 255, 255, .85);
                    font-size: 13px;
                }

                .enc-date-box {
                    min-width: 190px;
                    padding: 12px 15px;
                    text-align: right;
                    border: 1px solid rgba(255, 255, 255, .18);
                    border-radius: 12px;
                    background: rgba(255, 255, 255, .10);
                }

                .enc-date-box small {
                    display: block;
                    margin-bottom: 3px;
                    color: rgba(255, 255, 255, .75);
                }

                .enc-date-box strong {
                    font-size: 14px;
                    font-weight: 800;
                }

                /* =====================================================
                   BOUTONS
                ====================================================== */

                .btn-enc-primary,
                .btn-enc-outline,
                .btn-enc-success,
                .btn-enc-danger {
                    min-height: 39px;
                    padding: 9px 15px;
                    border-radius: 9px;
                    font-size: 12px;
                    font-weight: 700;
                    transition: all .2s ease;
                }

                .btn-enc-primary {
                    color: #fff;
                    border: 1px solid var(--enc-primary);
                    background: var(--enc-primary);
                }

                .btn-enc-primary:hover {
                    color: #fff;
                    border-color: var(--enc-primary-dark);
                    background: var(--enc-primary-dark);
                    transform: translateY(-1px);
                }

                .btn-enc-outline {
                    color: var(--enc-primary);
                    border: 1px solid #b8d8d4;
                    background: #fff;
                }

                .btn-enc-outline:hover {
                    color: #fff;
                    border-color: var(--enc-primary);
                    background: var(--enc-primary);
                }

                .btn-enc-success {
                    color: #fff;
                    border: 1px solid #16a34a;
                    background: #16a34a;
                }

                .btn-enc-danger {
                    color: #fff;
                    border: 1px solid #dc2626;
                    background: #dc2626;
                }

                /* =====================================================
                   CARTES KPI
                ====================================================== */

                .enc-stat-card {
                    position: relative;
                    overflow: hidden;
                    min-height: 150px;
                    margin-bottom: 20px;
                    padding: 20px;
                    border: 1px solid var(--enc-border);
                    border-radius: 15px;
                    background: #fff;
                    box-shadow: 0 7px 25px rgba(15, 23, 42, .06);
                    transition: all .2s ease;
                }

                .enc-stat-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 12px 30px rgba(15, 23, 42, .10);
                }

                .enc-stat-card::after {
                    position: absolute;
                    right: -34px;
                    bottom: -38px;
                    width: 115px;
                    height: 115px;
                    content: "";
                    border-radius: 50%;
                    background: rgba(15, 118, 110, .06);
                }

                .enc-stat-top {
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    margin-bottom: 14px;
                }

                .enc-stat-icon {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 48px;
                    height: 48px;
                    border-radius: 13px;
                    font-size: 19px;
                }

                .enc-icon-green {
                    color: #15803d;
                    background: #dcfce7;
                }

                .enc-icon-blue {
                    color: #0369a1;
                    background: #e0f2fe;
                }

                .enc-icon-orange {
                    color: #b45309;
                    background: #fef3c7;
                }

                .enc-icon-purple {
                    color: #6d28d9;
                    background: #ede9fe;
                }

                .enc-icon-red {
                    color: #b91c1c;
                    background: #fee2e2;
                }

                .enc-stat-badge {
                    padding: 5px 9px;
                    border-radius: 30px;
                    font-size: 9px;
                    font-weight: 800;
                }

                .enc-badge-success {
                    color: #15803d;
                    background: #dcfce7;
                }

                .enc-badge-info {
                    color: #0369a1;
                    background: #e0f2fe;
                }

                .enc-badge-warning {
                    color: #b45309;
                    background: #fef3c7;
                }

                .enc-badge-danger {
                    color: #b91c1c;
                    background: #fee2e2;
                }

                .enc-stat-label {
                    margin-bottom: 5px;
                    color: var(--enc-muted);
                    font-size: 11px;
                    font-weight: 800;
                    text-transform: uppercase;
                    letter-spacing: .4px;
                }

                .enc-stat-value {
                    margin-bottom: 4px;
                    color: var(--enc-dark);
                    font-size: 22px;
                    font-weight: 800;
                    line-height: 1.2;
                }

                .enc-stat-footer {
                    color: var(--enc-muted);
                    font-size: 10px;
                }

                /* =====================================================
                   CARTES
                ====================================================== */

                .enc-card {
                    margin-bottom: 22px;
                    border: 1px solid var(--enc-border);
                    border-radius: 15px;
                    background: #fff;
                    box-shadow: 0 7px 24px rgba(15, 23, 42, .05);
                }

                .enc-card-header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    min-height: 64px;
                    padding: 15px 20px;
                    border-bottom: 1px solid #edf2f7;
                }

                .enc-card-title {
                    display: flex;
                    align-items: center;
                    margin: 0;
                    color: var(--enc-dark);
                    font-size: 15px;
                    font-weight: 800;
                }

                .enc-card-title i {
                    margin-right: 9px;
                    color: var(--enc-primary);
                }

                .enc-card-subtitle {
                    display: block;
                    margin-top: 3px;
                    color: var(--enc-muted);
                    font-size: 10px;
                }

                .enc-card-body {
                    padding: 20px;
                }

                /* =====================================================
                   ACTIONS RAPIDES
                ====================================================== */

                .enc-quick-action {
                    display: flex;
                    align-items: center;
                    min-height: 80px;
                    margin-bottom: 12px;
                    padding: 13px;
                    color: var(--enc-text);
                    border: 1px solid var(--enc-border);
                    border-radius: 12px;
                    background: #fff;
                    cursor: pointer;
                    transition: all .2s ease;
                }

                .enc-quick-action:hover {
                    color: var(--enc-primary);
                    border-color: #9bcac5;
                    background: #f0fdfa;
                    transform: translateY(-2px);
                }

                .enc-quick-action-icon {
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

                .enc-quick-title {
                    display: block;
                    margin-bottom: 3px;
                    color: var(--enc-dark);
                    font-size: 11px;
                    font-weight: 800;
                }

                .enc-quick-text {
                    color: var(--enc-muted);
                    font-size: 9px;
                    line-height: 1.4;
                }

                /* =====================================================
                   GRAPHIQUE
                ====================================================== */

                .enc-chart-container {
                    position: relative;
                    width: 100%;
                    height: 315px;
                }

                .enc-chart-container canvas {
                    width: 100% !important;
                    height: 100% !important;
                }

                .enc-period-select {
                    width: 155px;
                    height: 36px;
                    border: 1px solid #dbe4ea;
                    border-radius: 8px;
                    font-size: 11px;
                }

                /* =====================================================
                   RÉPARTITION
                ====================================================== */

                .enc-source-item {
                    margin-bottom: 17px;
                }

                .enc-source-item:last-child {
                    margin-bottom: 0;
                }

                .enc-source-header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-bottom: 7px;
                }

                .enc-source-name {
                    display: flex;
                    align-items: center;
                    font-size: 11px;
                    font-weight: 700;
                }

                .enc-source-name i {
                    width: 26px;
                    color: var(--enc-primary);
                }

                .enc-source-value {
                    color: var(--enc-dark);
                    font-size: 11px;
                    font-weight: 800;
                }

                .enc-source-progress {
                    height: 7px;
                    overflow: hidden;
                    border-radius: 20px;
                    background: #e9eef3;
                }

                .enc-source-progress span {
                    display: block;
                    height: 100%;
                    border-radius: 20px;
                    background: linear-gradient(90deg, #14b8a6, #0f766e);
                }

                /* =====================================================
                   FILTRES
                ====================================================== */

                .enc-filter-box {
                    margin-bottom: 22px;
                    padding: 18px;
                    border: 1px solid var(--enc-border);
                    border-radius: 14px;
                    background: #fff;
                    box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
                }

                .enc-filter-box label {
                    margin-bottom: 6px;
                    color: #475569;
                    font-size: 10px;
                    font-weight: 800;
                    text-transform: uppercase;
                }

                .enc-filter-box .form-control {
                    height: 40px;
                    border: 1px solid #dbe4ea;
                    border-radius: 8px;
                    font-size: 11px;
                }

                .enc-filter-box .form-control:focus {
                    border-color: var(--enc-primary);
                    box-shadow: 0 0 0 .15rem rgba(15, 118, 110, .13);
                }

                /* =====================================================
                   TABLEAU
                ====================================================== */

                .enc-table {
                    width: 100%;
                    margin-bottom: 0;
                }

                .enc-table thead th {
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

                .enc-table tbody td {
                    padding: 12px 10px;
                    vertical-align: middle;
                    color: #475569;
                    border-top: 1px solid #edf2f7;
                    font-size: 10px;
                }

                .enc-table tbody tr:hover {
                    background: #f8fffd;
                }

                .enc-reference {
                    color: var(--enc-dark);
                    font-weight: 800;
                    white-space: nowrap;
                }

                .enc-client strong,
                .enc-label strong {
                    display: block;
                    margin-bottom: 2px;
                    color: var(--enc-dark);
                    font-size: 10px;
                }

                .enc-client small,
                .enc-label small {
                    color: var(--enc-muted);
                    font-size: 9px;
                }

                .enc-amount {
                    color: #15803d;
                    font-weight: 800;
                    white-space: nowrap;
                }

                .enc-badge {
                    display: inline-flex;
                    align-items: center;
                    padding: 5px 8px;
                    border-radius: 30px;
                    font-size: 8px;
                    font-weight: 800;
                }

                .enc-status-valid {
                    color: #15803d;
                    background: #dcfce7;
                }

                .enc-status-pending {
                    color: #b45309;
                    background: #fef3c7;
                }

                .enc-status-cancelled {
                    color: #b91c1c;
                    background: #fee2e2;
                }

                .enc-mode-bank {
                    color: #0369a1;
                    background: #e0f2fe;
                }

                .enc-mode-cash {
                    color: #15803d;
                    background: #dcfce7;
                }

                .enc-mode-cheque {
                    color: #6d28d9;
                    background: #ede9fe;
                }

                .enc-mode-mobile {
                    color: #b45309;
                    background: #fef3c7;
                }

                .enc-action-btn {
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

                .enc-action-view {
                    color: #0369a1;
                }

                .enc-action-edit {
                    color: #b45309;
                }

                .enc-action-print {
                    color: #475569;
                }

                .enc-action-delete {
                    color: #b91c1c;
                }

                /* =====================================================
                   ATTENTES / PRÉVISIONS
                ====================================================== */

                .enc-awaiting-item {
                    display: flex;
                    align-items: center;
                    margin-bottom: 13px;
                    padding: 12px;
                    border: 1px solid var(--enc-border);
                    border-radius: 11px;
                    background: #fbfdfd;
                }

                .enc-awaiting-item:last-child {
                    margin-bottom: 0;
                }

                .enc-awaiting-icon {
                    display: flex;
                    flex: 0 0 42px;
                    align-items: center;
                    justify-content: center;
                    width: 42px;
                    height: 42px;
                    margin-right: 11px;
                    color: #b45309;
                    border-radius: 10px;
                    background: #fef3c7;
                }

                .enc-awaiting-info {
                    flex: 1;
                }

                .enc-awaiting-info strong {
                    display: block;
                    margin-bottom: 2px;
                    color: var(--enc-dark);
                    font-size: 10px;
                }

                .enc-awaiting-info small {
                    color: var(--enc-muted);
                    font-size: 9px;
                }

                .enc-awaiting-amount {
                    color: var(--enc-dark);
                    font-size: 11px;
                    font-weight: 800;
                    white-space: nowrap;
                }

                /* =====================================================
                   MODALE
                ====================================================== */

                .enc-modal .modal-content {
                    overflow: hidden;
                    border: none;
                    border-radius: 15px;
                    box-shadow: 0 20px 45px rgba(15, 23, 42, .20);
                }

                .enc-modal .modal-header {
                    color: #fff;
                    border-bottom: none;
                    background: linear-gradient(135deg, #0f766e, #102033);
                }

                .enc-modal .modal-title {
                    font-size: 16px;
                    font-weight: 800;
                }

                .enc-modal .close {
                    color: #fff;
                    opacity: .9;
                }

                .enc-modal label {
                    margin-bottom: 6px;
                    color: #475569;
                    font-size: 10px;
                    font-weight: 800;
                }

                .enc-modal .form-control {
                    min-height: 41px;
                    border: 1px solid #dbe4ea;
                    border-radius: 8px;
                    font-size: 11px;
                }

                .enc-modal textarea.form-control {
                    min-height: 90px;
                }

                .enc-required {
                    color: #dc2626;
                }

                .enc-section-title {
                    margin-bottom: 15px;
                    padding-bottom: 8px;
                    color: var(--enc-primary);
                    border-bottom: 1px solid #edf2f7;
                    font-size: 11px;
                    font-weight: 800;
                    text-transform: uppercase;
                }

                @media (max-width: 767px) {
                    .enc-hero {
                        padding: 20px;
                    }

                    .enc-date-box {
                        margin-top: 15px;
                        text-align: left;
                    }

                    .enc-card-header {
                        display: block;
                    }

                    .enc-card-header .btn,
                    .enc-period-select {
                        margin-top: 10px;
                    }

                    .enc-stat-value {
                        font-size: 19px;
                    }

                    .enc-chart-container {
                        height: 260px;
                    }
                }
            </style>

            <!-- =========================================================
                 HERO
            ========================================================== -->
            <div class="enc-hero">

                <div class="enc-hero-content">

                    <div class="row align-items-center">

                        <div class="col-lg-8 col-md-8">

                            <div class="enc-hero-title">

                                <span class="enc-hero-icon">
                                    <i class="fas fa-arrow-circle-down"></i>
                                </span>

                                Gestion des encaissements

                            </div>

                            <p>
                                Enregistrez et contrôlez toutes les entrées de fonds provenant
                                des clients, avances de marchés, emprunts, remboursements et
                                autres produits de l’entreprise.
                            </p>

                        </div>

                        <div class="col-lg-4 col-md-4 d-flex justify-content-md-end">

                            <div class="enc-date-box">

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

                    <div class="enc-stat-card">

                        <div class="enc-stat-top">

                            <div class="enc-stat-icon enc-icon-green">
                                <i class="fas fa-coins"></i>
                            </div>

                            <span class="enc-stat-badge enc-badge-success">
                                <i class="fas fa-arrow-up mr-1"></i>
                                12,6 %
                            </span>

                        </div>

                        <div class="enc-stat-label">
                            Total encaissé ce mois
                        </div>

                        <div class="enc-stat-value">
                            485 700 000 BIF
                        </div>

                        <div class="enc-stat-footer">
                            Tous les encaissements validés du mois
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="enc-stat-card">

                        <div class="enc-stat-top">

                            <div class="enc-stat-icon enc-icon-blue">
                                <i class="fas fa-calendar-day"></i>
                            </div>

                            <span class="enc-stat-badge enc-badge-info">
                                8 opérations
                            </span>

                        </div>

                        <div class="enc-stat-label">
                            Encaissements du jour
                        </div>

                        <div class="enc-stat-value">
                            38 500 000 BIF
                        </div>

                        <div class="enc-stat-footer">
                            Entrées enregistrées aujourd’hui
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="enc-stat-card">

                        <div class="enc-stat-top">

                            <div class="enc-stat-icon enc-icon-orange">
                                <i class="fas fa-clock"></i>
                            </div>

                            <span class="enc-stat-badge enc-badge-warning">
                                6 dossiers
                            </span>

                        </div>

                        <div class="enc-stat-label">
                            En attente de validation
                        </div>

                        <div class="enc-stat-value">
                            72 800 000 BIF
                        </div>

                        <div class="enc-stat-footer">
                            Encaissements non encore comptabilisés
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="enc-stat-card">

                        <div class="enc-stat-top">

                            <div class="enc-stat-icon enc-icon-purple">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>

                            <span class="enc-stat-badge enc-badge-info">
                                12 clients
                            </span>

                        </div>

                        <div class="enc-stat-label">
                            Créances à encaisser
                        </div>

                        <div class="enc-stat-value">
                            310 250 000 BIF
                        </div>

                        <div class="enc-stat-footer">
                            Montants attendus sur factures et décomptes
                        </div>

                    </div>

                </div>

            </div>

            <!-- =========================================================
                 ACTIONS RAPIDES
            ========================================================== -->
            <div class="enc-card">

                <div class="enc-card-header">

                    <div>

                        <h5 class="enc-card-title">
                            <i class="fas fa-bolt"></i>
                            Actions rapides
                        </h5>

                        <span class="enc-card-subtitle">
                            Accédez rapidement aux principales opérations d’encaissement.
                        </span>

                    </div>

                </div>

                <div class="enc-card-body pb-2">

                    <div class="row">

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="enc-quick-action" data-toggle="modal" data-target="#addEncaissementModal">

                                <div class="enc-quick-action-icon enc-icon-green">
                                    <i class="fas fa-plus"></i>
                                </div>

                                <div>

                                    <span class="enc-quick-title">
                                        Nouvel encaissement
                                    </span>

                                    <span class="enc-quick-text">
                                        Enregistrer une nouvelle entrée de fonds
                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="enc-quick-action">

                                <div class="enc-quick-action-icon enc-icon-blue">
                                    <i class="fas fa-user-check"></i>
                                </div>

                                <div>

                                    <span class="enc-quick-title">
                                        Paiement client
                                    </span>

                                    <span class="enc-quick-text">
                                        Affecter un règlement à une facture
                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="enc-quick-action">

                                <div class="enc-quick-action-icon enc-icon-orange">
                                    <i class="fas fa-file-contract"></i>
                                </div>

                                <div>

                                    <span class="enc-quick-title">
                                        Avance marché
                                    </span>

                                    <span class="enc-quick-text">
                                        Enregistrer une avance de démarrage
                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="enc-quick-action">

                                <div class="enc-quick-action-icon enc-icon-purple">
                                    <i class="fas fa-university"></i>
                                </div>

                                <div>

                                    <span class="enc-quick-title">
                                        Emprunt reçu
                                    </span>

                                    <span class="enc-quick-text">
                                        Enregistrer un financement bancaire
                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="enc-quick-action">

                                <div class="enc-quick-action-icon enc-icon-blue">
                                    <i class="fas fa-print"></i>
                                </div>

                                <div>

                                    <span class="enc-quick-title">
                                        Journal
                                    </span>

                                    <span class="enc-quick-text">
                                        Imprimer le journal des encaissements
                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="enc-quick-action">

                                <div class="enc-quick-action-icon enc-icon-green">
                                    <i class="fas fa-file-excel"></i>
                                </div>

                                <div>

                                    <span class="enc-quick-title">
                                        Exporter
                                    </span>

                                    <span class="enc-quick-text">
                                        Exporter les encaissements vers Excel
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- =========================================================
                 GRAPHIQUE + RÉPARTITION
            ========================================================== -->
            <div class="row">

                <div class="col-xl-8 col-lg-8">

                    <div class="enc-card">

                        <div class="enc-card-header">

                            <div>

                                <h5 class="enc-card-title">
                                    <i class="fas fa-chart-line"></i>
                                    Évolution des encaissements
                                </h5>

                                <span class="enc-card-subtitle">
                                    Analyse des entrées de fonds sur les derniers mois.
                                </span>

                            </div>

                            <select class="form-control enc-period-select">
                                <option>6 derniers mois</option>
                                <option>12 derniers mois</option>
                                <option>Cette année</option>
                                <option>Année précédente</option>
                            </select>

                        </div>

                        <div class="enc-card-body">

                            <div class="enc-chart-container">
                                <canvas id="encaissementChart"></canvas>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-xl-4 col-lg-4">

                    <div class="enc-card">

                        <div class="enc-card-header">

                            <div>

                                <h5 class="enc-card-title">
                                    <i class="fas fa-chart-pie"></i>
                                    Sources des encaissements
                                </h5>

                                <span class="enc-card-subtitle">
                                    Répartition des entrées par origine.
                                </span>

                            </div>

                        </div>

                        <div class="enc-card-body">

                            <div class="enc-source-item">

                                <div class="enc-source-header">

                                    <span class="enc-source-name">
                                        <i class="fas fa-users"></i>
                                        Paiements clients
                                    </span>

                                    <span class="enc-source-value">
                                        285,4 M
                                    </span>

                                </div>

                                <div class="enc-source-progress">
                                    <span style="width: 82%;"></span>
                                </div>

                            </div>

                            <div class="enc-source-item">

                                <div class="enc-source-header">

                                    <span class="enc-source-name">
                                        <i class="fas fa-file-contract"></i>
                                        Avances sur marchés
                                    </span>

                                    <span class="enc-source-value">
                                        120,5 M
                                    </span>

                                </div>

                                <div class="enc-source-progress">
                                    <span style="width: 58%;"></span>
                                </div>

                            </div>

                            <div class="enc-source-item">

                                <div class="enc-source-header">

                                    <span class="enc-source-name">
                                        <i class="fas fa-university"></i>
                                        Emprunts
                                    </span>

                                    <span class="enc-source-value">
                                        45,0 M
                                    </span>

                                </div>

                                <div class="enc-source-progress">
                                    <span style="width: 32%;"></span>
                                </div>

                            </div>

                            <div class="enc-source-item">

                                <div class="enc-source-header">

                                    <span class="enc-source-name">
                                        <i class="fas fa-undo-alt"></i>
                                        Remboursements
                                    </span>

                                    <span class="enc-source-value">
                                        18,8 M
                                    </span>

                                </div>

                                <div class="enc-source-progress">
                                    <span style="width: 20%;"></span>
                                </div>

                            </div>

                            <div class="enc-source-item">

                                <div class="enc-source-header">

                                    <span class="enc-source-name">
                                        <i class="fas fa-ellipsis-h"></i>
                                        Autres produits
                                    </span>

                                    <span class="enc-source-value">
                                        16,0 M
                                    </span>

                                </div>

                                <div class="enc-source-progress">
                                    <span style="width: 16%;"></span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- =========================================================
                 FILTRES
            ========================================================== -->
            <div class="enc-filter-box">

                <div class="row align-items-end">

                    <div class="col-xl-3 col-lg-3 col-md-6">

                        <div class="form-group mb-lg-0">

                            <label>Recherche</label>

                            <div class="input-group">

                                <input type="text" class="form-control" placeholder="Référence, client, pièce...">

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

                            <label>Source</label>

                            <select class="form-control">

                                <option value="">Toutes les sources</option>
                                <option>Client</option>
                                <option>Avance marché</option>
                                <option>Emprunt</option>
                                <option>Remboursement</option>
                                <option>Autre produit</option>

                            </select>

                        </div>

                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-12">

                        <button class="btn btn-enc-primary mr-1">

                            <i class="fas fa-filter mr-1"></i>
                            Appliquer

                        </button>

                        <button class="btn btn-enc-outline">

                            <i class="fas fa-redo mr-1"></i>
                            Réinitialiser

                        </button>

                    </div>

                </div>

            </div>

            <!-- =========================================================
                 TABLEAU DES ENCAISSEMENTS
            ========================================================== -->
            <div class="enc-card">

                <div class="enc-card-header">

                    <div>

                        <h5 class="enc-card-title">
                            <i class="fas fa-list"></i>
                            Historique des encaissements
                        </h5>

                        <span class="enc-card-subtitle">
                            Liste des entrées de fonds enregistrées dans la trésorerie.
                        </span>

                    </div>

                    <button class="btn btn-enc-primary" data-toggle="modal" data-target="#addEncaissementModal">

                        <i class="fas fa-plus mr-1"></i>
                        Nouvel encaissement

                    </button>

                </div>

                <div class="table-responsive">

                    <table class="table enc-table">

                        <thead>

                            <tr>

                                <th>#</th>
                                <th>Date</th>
                                <th>Référence</th>
                                <th>Source / Client</th>
                                <th>Objet</th>
                                <th>Caisse / Compte</th>
                                <th>Mode</th>
                                <th>Pièce</th>
                                <th class="text-right">Montant</th>
                                <th>Devise</th>
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
                                        10:42
                                    </small>
                                </td>

                                <td>
                                    <span class="enc-reference">
                                        ENC-2026-00048
                                    </span>
                                </td>

                                <td class="enc-client">

                                    <strong>
                                        Ministère des Infrastructures
                                    </strong>

                                    <small>
                                        Client institutionnel
                                    </small>

                                </td>

                                <td class="enc-label">

                                    <strong>
                                        Paiement décompte n° 04
                                    </strong>

                                    <small>
                                        Projet route nationale RN3
                                    </small>

                                </td>

                                <td>

                                    <strong>CRDB BIF</strong>

                                    <small class="d-block text-muted">
                                        Compte bancaire
                                    </small>

                                </td>

                                <td>

                                    <span class="enc-badge enc-mode-bank">

                                        <i class="fas fa-university mr-1"></i>
                                        Virement

                                    </span>

                                </td>

                                <td>

                                    <strong>FAC-2026-0045</strong>

                                    <small class="d-block text-muted">
                                        Reçu joint
                                    </small>

                                </td>

                                <td class="text-right enc-amount">
                                    + 85 000 000
                                </td>

                                <td>BIF</td>

                                <td>

                                    <span class="enc-badge enc-status-valid">

                                        <i class="fas fa-check-circle mr-1"></i>
                                        Validé

                                    </span>

                                </td>

                                <td class="text-center">

                                    <button class="enc-action-btn enc-action-view" title="Voir">

                                        <i class="fas fa-eye"></i>

                                    </button>

                                    <button class="enc-action-btn enc-action-print" title="Imprimer">

                                        <i class="fas fa-print"></i>

                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>2</td>

                                <td>
                                    12/07/2026
                                    <small class="d-block text-muted">
                                        09:15
                                    </small>
                                </td>

                                <td>
                                    <span class="enc-reference">
                                        ENC-2026-00047
                                    </span>
                                </td>

                                <td class="enc-client">

                                    <strong>
                                        Commune de Gitega
                                    </strong>

                                    <small>
                                        Maître d’ouvrage
                                    </small>

                                </td>

                                <td class="enc-label">

                                    <strong>
                                        Avance de démarrage
                                    </strong>

                                    <small>
                                        Construction bâtiment administratif
                                    </small>

                                </td>

                                <td>

                                    <strong>Interbank BIF</strong>

                                    <small class="d-block text-muted">
                                        Compte bancaire
                                    </small>

                                </td>

                                <td>

                                    <span class="enc-badge enc-mode-cheque">

                                        <i class="fas fa-money-check mr-1"></i>
                                        Chèque

                                    </span>

                                </td>

                                <td>

                                    <strong>CHQ-789541</strong>

                                    <small class="d-block text-muted">
                                        Chèque encaissé
                                    </small>

                                </td>

                                <td class="text-right enc-amount">
                                    + 120 000 000
                                </td>

                                <td>BIF</td>

                                <td>

                                    <span class="enc-badge enc-status-valid">
                                        Validé
                                    </span>

                                </td>

                                <td class="text-center">

                                    <button class="enc-action-btn enc-action-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="enc-action-btn enc-action-edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="enc-action-btn enc-action-print">
                                        <i class="fas fa-print"></i>
                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>3</td>

                                <td>
                                    11/07/2026
                                    <small class="d-block text-muted">
                                        15:35
                                    </small>
                                </td>

                                <td>
                                    <span class="enc-reference">
                                        ENC-2026-00046
                                    </span>
                                </td>

                                <td class="enc-client">

                                    <strong>
                                        ABC Construction
                                    </strong>

                                    <small>
                                        Sous-traitant
                                    </small>

                                </td>

                                <td class="enc-label">

                                    <strong>
                                        Remboursement avance
                                    </strong>

                                    <small>
                                        Trop-perçu sur situation précédente
                                    </small>

                                </td>

                                <td>

                                    <strong>Caisse siège</strong>

                                    <small class="d-block text-muted">
                                        Caisse principale
                                    </small>

                                </td>

                                <td>

                                    <span class="enc-badge enc-mode-cash">

                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                        Espèces

                                    </span>

                                </td>

                                <td>

                                    <strong>REC-2026-0032</strong>

                                    <small class="d-block text-muted">
                                        Reçu de caisse
                                    </small>

                                </td>

                                <td class="text-right enc-amount">
                                    + 5 500 000
                                </td>

                                <td>BIF</td>

                                <td>

                                    <span class="enc-badge enc-status-valid">
                                        Validé
                                    </span>

                                </td>

                                <td class="text-center">

                                    <button class="enc-action-btn enc-action-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="enc-action-btn enc-action-print">
                                        <i class="fas fa-print"></i>
                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>4</td>

                                <td>
                                    11/07/2026
                                    <small class="d-block text-muted">
                                        11:20
                                    </small>
                                </td>

                                <td>
                                    <span class="enc-reference">
                                        ENC-2026-00045
                                    </span>
                                </td>

                                <td class="enc-client">

                                    <strong>
                                        Banque CRDB
                                    </strong>

                                    <small>
                                        Institution financière
                                    </small>

                                </td>

                                <td class="enc-label">

                                    <strong>
                                        Décaissement crédit de trésorerie
                                    </strong>

                                    <small>
                                        Financement court terme
                                    </small>

                                </td>

                                <td>

                                    <strong>CRDB BIF</strong>

                                    <small class="d-block text-muted">
                                        Compte bancaire
                                    </small>

                                </td>

                                <td>

                                    <span class="enc-badge enc-mode-bank">
                                        Virement
                                    </span>

                                </td>

                                <td>

                                    <strong>CRD-2026-0011</strong>

                                    <small class="d-block text-muted">
                                        Contrat de crédit
                                    </small>

                                </td>

                                <td class="text-right enc-amount">
                                    + 75 000 000
                                </td>

                                <td>BIF</td>

                                <td>

                                    <span class="enc-badge enc-status-pending">
                                        En attente
                                    </span>

                                </td>

                                <td class="text-center">

                                    <button class="enc-action-btn enc-action-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="enc-action-btn enc-action-edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>5</td>

                                <td>
                                    10/07/2026
                                    <small class="d-block text-muted">
                                        16:08
                                    </small>
                                </td>

                                <td>
                                    <span class="enc-reference">
                                        ENC-2026-00044
                                    </span>
                                </td>

                                <td class="enc-client">

                                    <strong>
                                        Client particulier
                                    </strong>

                                    <small>
                                        Vente de matériaux
                                    </small>

                                </td>

                                <td class="enc-label">

                                    <strong>
                                        Vente de matériaux récupérés
                                    </strong>

                                    <small>
                                        Ciment et ferraille non utilisés
                                    </small>

                                </td>

                                <td>

                                    <strong>Caisse siège</strong>

                                    <small class="d-block text-muted">
                                        Caisse principale
                                    </small>

                                </td>

                                <td>

                                    <span class="enc-badge enc-mode-mobile">

                                        <i class="fas fa-mobile-alt mr-1"></i>
                                        Mobile Money

                                    </span>

                                </td>

                                <td>

                                    <strong>MOB-554788</strong>

                                    <small class="d-block text-muted">
                                        Transaction mobile
                                    </small>

                                </td>

                                <td class="text-right enc-amount">
                                    + 2 800 000
                                </td>

                                <td>BIF</td>

                                <td>

                                    <span class="enc-badge enc-status-valid">
                                        Validé
                                    </span>

                                </td>

                                <td class="text-center">

                                    <button class="enc-action-btn enc-action-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="enc-action-btn enc-action-edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="enc-action-btn enc-action-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="p-3 border-top d-flex justify-content-between align-items-center">

                    <small class="text-muted">
                        Affichage de 1 à 5 sur 86 encaissements
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
                 ENCAISSEMENTS ATTENDUS + SYNTHÈSE CLIENTS
            ========================================================== -->
            <div class="row">

                <div class="col-xl-5 col-lg-5">

                    <div class="enc-card">

                        <div class="enc-card-header">

                            <div>

                                <h5 class="enc-card-title">
                                    <i class="fas fa-hourglass-half"></i>
                                    Encaissements attendus
                                </h5>

                                <span class="enc-card-subtitle">
                                    Montants prévus dans les prochains jours.
                                </span>

                            </div>

                            <span class="badge badge-warning">
                                4 échéances
                            </span>

                        </div>

                        <div class="enc-card-body">

                            <div class="enc-awaiting-item">

                                <div class="enc-awaiting-icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>

                                <div class="enc-awaiting-info">

                                    <strong>
                                        Ministère des Travaux Publics
                                    </strong>

                                    <small>
                                        Décompte n° 05 — Échéance 15/07/2026
                                    </small>

                                </div>

                                <div class="enc-awaiting-amount">
                                    95 000 000 BIF
                                </div>

                            </div>

                            <div class="enc-awaiting-item">

                                <div class="enc-awaiting-icon">
                                    <i class="fas fa-file-contract"></i>
                                </div>

                                <div class="enc-awaiting-info">

                                    <strong>
                                        Commune de Ngozi
                                    </strong>

                                    <small>
                                        Avance de démarrage — 18/07/2026
                                    </small>

                                </div>

                                <div class="enc-awaiting-amount">
                                    60 000 000 BIF
                                </div>

                            </div>

                            <div class="enc-awaiting-item">

                                <div class="enc-awaiting-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>

                                <div class="enc-awaiting-info">

                                    <strong>
                                        Société BCB
                                    </strong>

                                    <small>
                                        Paiement facture — 22/07/2026
                                    </small>

                                </div>

                                <div class="enc-awaiting-amount">
                                    35 500 000 BIF
                                </div>

                            </div>

                            <div class="enc-awaiting-item">

                                <div class="enc-awaiting-icon">
                                    <i class="fas fa-university"></i>
                                </div>

                                <div class="enc-awaiting-info">

                                    <strong>
                                        Banque KCB
                                    </strong>

                                    <small>
                                        Mise à disposition crédit — 25/07/2026
                                    </small>

                                </div>

                                <div class="enc-awaiting-amount">
                                    120 000 000 BIF
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-xl-7 col-lg-7">

                    <div class="enc-card">

                        <div class="enc-card-header">

                            <div>

                                <h5 class="enc-card-title">
                                    <i class="fas fa-users"></i>
                                    Synthèse par client
                                </h5>

                                <span class="enc-card-subtitle">
                                    Montants facturés, encaissés et restant à recouvrer.
                                </span>

                            </div>

                        </div>

                        <div class="table-responsive">

                            <table class="table enc-table">

                                <thead>

                                    <tr>
                                        <th>Client</th>
                                        <th class="text-right">Facturé</th>
                                        <th class="text-right">Encaissé</th>
                                        <th class="text-right">Reste</th>
                                        <th>Recouvrement</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                        <td>

                                            <strong>
                                                Ministère des Infrastructures
                                            </strong>

                                            <small class="d-block text-muted">
                                                6 factures
                                            </small>

                                        </td>

                                        <td class="text-right">
                                            420 000 000
                                        </td>

                                        <td class="text-right enc-amount">
                                            325 000 000
                                        </td>

                                        <td class="text-right text-danger font-weight-bold">
                                            95 000 000
                                        </td>

                                        <td style="min-width: 140px;">

                                            <div class="progress progress-xs mb-1">

                                                <div class="progress-bar bg-success" style="width: 77.4%;">
                                                </div>

                                            </div>

                                            <small>77,4 %</small>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td>

                                            <strong>
                                                Commune de Gitega
                                            </strong>

                                            <small class="d-block text-muted">
                                                3 factures
                                            </small>

                                        </td>

                                        <td class="text-right">
                                            280 000 000
                                        </td>

                                        <td class="text-right enc-amount">
                                            220 000 000
                                        </td>

                                        <td class="text-right text-danger font-weight-bold">
                                            60 000 000
                                        </td>

                                        <td>

                                            <div class="progress progress-xs mb-1">

                                                <div class="progress-bar bg-info" style="width: 78.5%;">
                                                </div>

                                            </div>

                                            <small>78,5 %</small>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td>

                                            <strong>
                                                Société BCB
                                            </strong>

                                            <small class="d-block text-muted">
                                                2 factures
                                            </small>

                                        </td>

                                        <td class="text-right">
                                            125 000 000
                                        </td>

                                        <td class="text-right enc-amount">
                                            89 500 000
                                        </td>

                                        <td class="text-right text-danger font-weight-bold">
                                            35 500 000
                                        </td>

                                        <td>

                                            <div class="progress progress-xs mb-1">

                                                <div class="progress-bar bg-warning" style="width: 71.6%;">
                                                </div>

                                            </div>

                                            <small>71,6 %</small>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td>

                                            <strong>
                                                Province de Muyinga
                                            </strong>

                                            <small class="d-block text-muted">
                                                4 factures
                                            </small>

                                        </td>

                                        <td class="text-right">
                                            310 000 000
                                        </td>

                                        <td class="text-right enc-amount">
                                            280 250 000
                                        </td>

                                        <td class="text-right text-danger font-weight-bold">
                                            29 750 000
                                        </td>

                                        <td>

                                            <div class="progress progress-xs mb-1">

                                                <div class="progress-bar bg-success" style="width: 90.4%;">
                                                </div>

                                            </div>

                                            <small>90,4 %</small>

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
     MODALE : NOUVEL ENCAISSEMENT
========================================================== -->
<div class="modal fade enc-modal" id="addEncaissementModal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">

        <form action="<?= base_url('finance/encaissement-store') ?>" method="post" enctype="multipart/form-data"
            style="width: 100%;">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="fas fa-arrow-circle-down mr-2"></i>
                        Enregistrer un nouvel encaissement

                    </h5>

                    <button type="button" class="close" data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="enc-section-title">

                        <i class="fas fa-info-circle mr-1"></i>
                        Informations générales

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Référence
                                    <span class="enc-required">*</span>
                                </label>

                                <input type="text" name="reference" class="form-control"
                                    value="ENC-<?= date('Y') ?>-00049" readonly>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Date d’encaissement
                                    <span class="enc-required">*</span>
                                </label>

                                <input type="date" name="encaissement_date" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Source de l’encaissement
                                    <span class="enc-required">*</span>
                                </label>

                                <select name="source_type" id="sourceType" class="form-control"
                                    onchange="toggleEncaissementSource()" required>

                                    <option value="">
                                        Sélectionner
                                    </option>

                                    <option value="client">
                                        Paiement client
                                    </option>

                                    <option value="avance_marche">
                                        Avance sur marché
                                    </option>

                                    <option value="emprunt">
                                        Emprunt bancaire
                                    </option>

                                    <option value="remboursement">
                                        Remboursement
                                    </option>

                                    <option value="vente_actif">
                                        Vente d’actif
                                    </option>

                                    <option value="autre">
                                        Autre produit
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="enc-section-title mt-3">

                        <i class="fas fa-user-tie mr-1"></i>
                        Provenance et affectation

                    </div>

                    <div class="row">

                        <div class="col-md-4" id="clientField">

                            <div class="form-group">

                                <label>
                                    Client / Payeur
                                </label>

                                <select name="client_id" class="form-control">

                                    <option value="">
                                        Sélectionner le client
                                    </option>

                                    <option value="1">
                                        Ministère des Infrastructures
                                    </option>

                                    <option value="2">
                                        Commune de Gitega
                                    </option>

                                    <option value="3">
                                        Province de Muyinga
                                    </option>

                                    <option value="4">
                                        Société BCB
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-4" id="bankSourceField" style="display: none;">

                            <div class="form-group">

                                <label>
                                    Institution financière
                                </label>

                                <input type="text" name="financial_institution" class="form-control"
                                    placeholder="Ex. Banque CRDB">

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Projet / Chantier concerné
                                </label>

                                <select name="chantier_id" class="form-control">

                                    <option value="">
                                        Non affecté à un chantier
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
                                    Facture / Décompte associé
                                </label>

                                <select name="invoice_id" class="form-control">

                                    <option value="">
                                        Aucun document associé
                                    </option>

                                    <option value="1">
                                        FAC-2026-0045 — 85 000 000 BIF
                                    </option>

                                    <option value="2">
                                        DEC-2026-0004 — 95 000 000 BIF
                                    </option>

                                    <option value="3">
                                        FAC-2026-0038 — 35 500 000 BIF
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Caisse ou compte destinataire
                                    <span class="enc-required">*</span>
                                </label>

                                <select name="destination_account_id" class="form-control" required>

                                    <option value="">
                                        Sélectionner
                                    </option>

                                    <optgroup label="Caisses">

                                        <option value="cash-1">
                                            Caisse siège
                                        </option>

                                        <option value="cash-2">
                                            Caisse chantier Gitega
                                        </option>

                                    </optgroup>

                                    <optgroup label="Comptes bancaires">

                                        <option value="bank-1">
                                            CRDB BIF
                                        </option>

                                        <option value="bank-2">
                                            CRDB USD
                                        </option>

                                        <option value="bank-3">
                                            ECOBANK BIF
                                        </option>

                                        <option value="bank-4">
                                            KCB USD
                                        </option>

                                    </optgroup>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Mode d’encaissement
                                    <span class="enc-required">*</span>
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

                                    <option value="bank_deposit">
                                        Versement bancaire
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="enc-section-title mt-3">

                        <i class="fas fa-money-bill-wave mr-1"></i>
                        Montant et justificatifs

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Montant encaissé
                                    <span class="enc-required">*</span>
                                </label>

                                <input type="number" name="amount" id="encAmount" class="form-control" min="0"
                                    step="0.01" placeholder="0" required>

                            </div>

                        </div>

                        <div class="col-md-2">

                            <div class="form-group">

                                <label>
                                    Devise
                                    <span class="enc-required">*</span>
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
                                    placeholder="Reçu, bordereau, avis crédit...">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Pièce justificative
                                </label>

                                <div class="custom-file">

                                    <input type="file" name="attachment" class="custom-file-input"
                                        id="encaissementAttachment" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">

                                    <label class="custom-file-label" for="encaissementAttachment">

                                        Choisir un fichier

                                    </label>

                                </div>

                                <small class="text-muted">
                                    PDF, image ou document — maximum 5 Mo.
                                </small>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Libellé de l’encaissement
                                    <span class="enc-required">*</span>
                                </label>

                                <input type="text" name="label" class="form-control"
                                    placeholder="Ex. Paiement du décompte n° 04" required>

                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="form-group mb-0">

                                <label>
                                    Observation
                                </label>

                                <textarea name="observation" class="form-control"
                                    placeholder="Informations complémentaires sur cet encaissement..."></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-enc-outline" data-dismiss="modal">

                        <i class="fas fa-times mr-1"></i>
                        Annuler

                    </button>

                    <button type="submit" class="btn btn-enc-primary">

                        <i class="fas fa-save mr-1"></i>
                        Enregistrer l’encaissement

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

        const canvas = document.getElementById('encaissementChart');

        if (canvas && typeof Chart !== 'undefined') {

            const ctx = canvas.getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, 300);

            gradient.addColorStop(
                0,
                'rgba(15, 118, 110, 0.32)'
            );

            gradient.addColorStop(
                1,
                'rgba(15, 118, 110, 0.02)'
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
                            label: 'Encaissements réalisés',

                            data: [
                                280000000,
                                325000000,
                                295000000,
                                420000000,
                                390000000,
                                485700000
                            ],

                            borderColor: '#0f766e',
                            backgroundColor: gradient,
                            borderWidth: 2.5,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#0f766e',
                            pointBorderWidth: 2,
                            fill: true,
                            tension: 0.35
                        },
                        {
                            label: 'Objectif mensuel',

                            data: [
                                300000000,
                                340000000,
                                350000000,
                                400000000,
                                430000000,
                                450000000
                            ],

                            borderColor: '#f59e0b',
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

    function toggleEncaissementSource() {

        const sourceType = document.getElementById('sourceType').value;
        const clientField = document.getElementById('clientField');
        const bankField = document.getElementById('bankSourceField');

        clientField.style.display = 'block';
        bankField.style.display = 'none';

        if (sourceType === 'emprunt') {
            clientField.style.display = 'none';
            bankField.style.display = 'block';
        }

        if (
            sourceType === 'vente_actif' ||
            sourceType === 'autre' ||
            sourceType === 'remboursement'
        ) {
            clientField.style.display = 'block';
            bankField.style.display = 'none';
        }
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
                .html(
                    fileName || 'Choisir un fichier'
                );
        }
    );
</script>