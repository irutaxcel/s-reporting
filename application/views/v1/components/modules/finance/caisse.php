<!-- =========================================================
     PAGE : GESTION DES CAISSES
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
    background:
        linear-gradient(135deg,
            rgba(15, 118, 110, .98),
            rgba(16, 32, 51, .98));
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
    min-width: 190px;
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

.btn-caisse-success {
    color: #fff;
    border: 1px solid #16a34a;
    background: #16a34a;
}

.btn-caisse-danger {
    color: #fff;
    border: 1px solid #dc2626;
    background: #dc2626;
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
       ACTIONS RAPIDES
    ====================================================== */

.quick-action {
    display: flex;
    align-items: center;
    min-height: 78px;
    margin-bottom: 12px;
    padding: 13px;
    color: var(--caisse-text);
    border: 1px solid var(--caisse-border);
    border-radius: 12px;
    background: #fff;
    transition: all .2s ease;
    cursor: pointer;
}

.quick-action:hover {
    color: var(--caisse-primary);
    border-color: #9bcac5;
    background: #f0fdfa;
    transform: translateY(-2px);
}

.quick-action-icon {
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

.quick-action-title {
    display: block;
    margin-bottom: 2px;
    font-size: 12px;
    font-weight: 800;
}

.quick-action-text {
    color: var(--caisse-muted);
    font-size: 10px;
    line-height: 1.3;
}

/* =====================================================
       FILTRES
    ====================================================== */

.caisse-filter-box {
    margin-bottom: 22px;
    padding: 18px;
    border: 1px solid var(--caisse-border);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
}

.caisse-filter-box label {
    margin-bottom: 6px;
    color: #475569;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
}

.caisse-filter-box .form-control {
    height: 41px;
    border: 1px solid #dbe4ea;
    border-radius: 8px;
    font-size: 12px;
}

.caisse-filter-box .form-control:focus {
    border-color: var(--caisse-primary);
    box-shadow: 0 0 0 .15rem rgba(15, 118, 110, .14);
}

/* =====================================================
       CARTES CAISSES
    ====================================================== */

.cash-box {
    position: relative;
    overflow: hidden;
    min-height: 195px;
    margin-bottom: 18px;
    border: 1px solid var(--caisse-border);
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 6px 22px rgba(15, 23, 42, .05);
    transition: all .2s ease;
}

.cash-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, .10);
}

.cash-box-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 17px 12px;
}

.cash-box-name {
    display: flex;
    align-items: center;
}

.cash-box-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 43px;
    height: 43px;
    margin-right: 11px;
    color: var(--caisse-primary);
    border-radius: 12px;
    background: #ccfbf1;
}

.cash-box-name h6 {
    margin: 0 0 3px;
    color: var(--caisse-secondary);
    font-size: 13px;
    font-weight: 800;
}

.cash-box-code {
    color: var(--caisse-muted);
    font-size: 10px;
    font-weight: 600;
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

.cash-box-balance {
    padding: 8px 17px 15px;
}

.cash-box-balance span {
    display: block;
    margin-bottom: 2px;
    color: var(--caisse-muted);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}

.cash-box-balance strong {
    color: var(--caisse-secondary);
    font-size: 21px;
    font-weight: 800;
}

.cash-progress {
    height: 6px;
    margin: 0 17px 13px;
    overflow: hidden;
    border-radius: 20px;
    background: #e9eef3;
}

.cash-progress-bar {
    height: 100%;
    border-radius: 20px;
    background: linear-gradient(90deg, #14b8a6, #0f766e);
}

.cash-box-footer {
    display: flex;
    border-top: 1px solid #edf2f7;
    background: #fbfdfd;
}

.cash-box-footer-item {
    flex: 1;
    padding: 10px 8px;
    text-align: center;
    border-right: 1px solid #edf2f7;
}

.cash-box-footer-item:last-child {
    border-right: none;
}

.cash-box-footer-item span {
    display: block;
    margin-bottom: 2px;
    color: var(--caisse-muted);
    font-size: 9px;
}

.cash-box-footer-item strong {
    color: var(--caisse-secondary);
    font-size: 11px;
}

/* =====================================================
       TABLEAU
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

.badge-en-attente {
    color: #b45309;
    background: #fef3c7;
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

.btn-table-edit {
    color: #b45309;
}

.btn-table-print {
    color: #475569;
}

/* =====================================================
       ALERTES
    ====================================================== */

.treasury-alert {
    display: flex;
    align-items: flex-start;
    margin-bottom: 12px;
    padding: 12px;
    border: 1px solid;
    border-radius: 11px;
}

.treasury-alert:last-child {
    margin-bottom: 0;
}

.treasury-alert-icon {
    display: flex;
    flex: 0 0 36px;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    margin-right: 10px;
    border-radius: 9px;
}

.treasury-alert h6 {
    margin: 0 0 3px;
    font-size: 11px;
    font-weight: 800;
}

.treasury-alert p {
    margin: 0;
    font-size: 10px;
    line-height: 1.4;
}

.alert-danger-soft {
    color: #991b1b;
    border-color: #fecaca;
    background: #fff7f7;
}

.alert-danger-soft .treasury-alert-icon {
    background: #fee2e2;
}

.alert-warning-soft {
    color: #92400e;
    border-color: #fde68a;
    background: #fffbeb;
}

.alert-warning-soft .treasury-alert-icon {
    background: #fef3c7;
}

.alert-info-soft {
    color: #075985;
    border-color: #bae6fd;
    background: #f0f9ff;
}

.alert-info-soft .treasury-alert-icon {
    background: #e0f2fe;
}

/* =====================================================
       TOP DÉPENSES
    ====================================================== */

.expense-item {
    margin-bottom: 16px;
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
    color: var(--caisse-text);
    font-size: 11px;
    font-weight: 700;
}

.expense-item-title i {
    width: 25px;
    color: var(--caisse-primary);
}

.expense-item-value {
    color: var(--caisse-secondary);
    font-size: 11px;
    font-weight: 800;
}

.expense-progress {
    height: 6px;
    overflow: hidden;
    border-radius: 20px;
    background: #e9eef3;
}

.expense-progress span {
    display: block;
    height: 100%;
    border-radius: 20px;
    background: linear-gradient(90deg, #14b8a6, #0f766e);
}

/* =====================================================
       MODALES
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

.modal-caisse textarea.form-control {
    min-height: 90px;
}

.required-star {
    color: #dc2626;
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
}
</style>

<div class="content-wrapper caisse-page">

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
                                    <i class="fas fa-cash-register"></i>
                                </span>

                                Gestion des caisses
                            </div>

                            <p>
                                Suivez les disponibilités de la caisse siège et des
                                caisses chantiers, contrôlez les mouvements et anticipez
                                les besoins d’approvisionnement.
                            </p>

                        </div>

                        <div class="col-lg-4 col-md-4 d-flex justify-content-md-end">

                            <div class="caisse-date-box">
                                <small>
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    Situation au
                                </small>

                                <strong>
                                    <?= date('d/m/Y'); ?>
                                </strong>
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

            <!-- =================================================
                 STATISTIQUES PRINCIPALES
            ================================================== -->
            <div class="row">

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="caisse-stat-card">

                        <div class="caisse-stat-top">

                            <div class="caisse-stat-icon icon-green">
                                <i class="fas fa-wallet"></i>
                            </div>

                            <span class="caisse-stat-badge badge-positive">
                                <i class="fas fa-arrow-up mr-1"></i>
                                8,4 %
                            </span>

                        </div>

                        <div class="caisse-stat-label">
                            Solde global disponible
                        </div>

                        <div class="caisse-stat-value">
                            245 600 000 BIF
                        </div>

                        <div class="caisse-stat-footer">
                            Toutes les caisses actives confondues
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="caisse-stat-card">

                        <div class="caisse-stat-top">

                            <div class="caisse-stat-icon icon-blue">
                                <i class="fas fa-building"></i>
                            </div>

                            <span class="caisse-stat-badge badge-neutral">
                                Disponible
                            </span>

                        </div>

                        <div class="caisse-stat-label">
                            Caisse siège
                        </div>

                        <div class="caisse-stat-value">
                            35 400 000 BIF
                        </div>

                        <div class="caisse-stat-footer">
                            14,41 % du solde global
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="caisse-stat-card">

                        <div class="caisse-stat-top">

                            <div class="caisse-stat-icon icon-orange">
                                <i class="fas fa-hard-hat"></i>
                            </div>

                            <span class="caisse-stat-badge badge-neutral">
                                8 caisses
                            </span>

                        </div>

                        <div class="caisse-stat-label">
                            Caisses chantiers
                        </div>

                        <div class="caisse-stat-value">
                            210 200 000 BIF
                        </div>

                        <div class="caisse-stat-footer">
                            Réparties sur les chantiers actifs
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="caisse-stat-card">

                        <div class="caisse-stat-top">

                            <div class="caisse-stat-icon icon-red">
                                <i class="fas fa-arrow-up"></i>
                            </div>

                            <span class="caisse-stat-badge badge-negative">
                                24 opérations
                            </span>

                        </div>

                        <div class="caisse-stat-label">
                            Décaissements du jour
                        </div>

                        <div class="caisse-stat-value">
                            7 500 000 BIF
                        </div>

                        <div class="caisse-stat-footer">
                            Sorties enregistrées aujourd’hui
                        </div>

                    </div>

                </div>

            </div>

            <!-- =================================================
                 ACTIONS RAPIDES
            ================================================== -->
            <div class="caisse-card">

                <div class="caisse-card-header">

                    <div>
                        <h5 class="caisse-card-title">
                            <i class="fas fa-bolt"></i>
                            Actions rapides
                        </h5>

                        <span class="caisse-card-subtitle">
                            Accédez rapidement aux principales opérations de caisse.
                        </span>
                    </div>

                </div>

                <div class="caisse-card-body pb-2">

                    <div class="row">

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="quick-action" data-toggle="modal" data-target="#addCaisseModal">

                                <div class="quick-action-icon icon-green">
                                    <i class="fas fa-plus"></i>
                                </div>

                                <div>
                                    <span class="quick-action-title">
                                        Nouvelle caisse
                                    </span>

                                    <span class="quick-action-text">
                                        Créer une caisse siège ou chantier
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="quick-action" data-toggle="modal" data-target="#addOperationModal"
                                onclick="prepareOperation('approvisionnement')">

                                <div class="quick-action-icon icon-blue">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>

                                <div>
                                    <span class="quick-action-title">
                                        Approvisionner
                                    </span>

                                    <span class="quick-action-text">
                                        Alimenter une caisse chantier
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="quick-action" data-toggle="modal" data-target="#addOperationModal"
                                onclick="prepareOperation('encaissement')">

                                <div class="quick-action-icon icon-green">
                                    <i class="fas fa-arrow-down"></i>
                                </div>

                                <div>
                                    <span class="quick-action-title">
                                        Encaissement
                                    </span>

                                    <span class="quick-action-text">
                                        Enregistrer une entrée d’argent
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="quick-action" data-toggle="modal" data-target="#addOperationModal"
                                onclick="prepareOperation('decaissement')">

                                <div class="quick-action-icon icon-red">
                                    <i class="fas fa-arrow-up"></i>
                                </div>

                                <div>
                                    <span class="quick-action-title">
                                        Décaissement
                                    </span>

                                    <span class="quick-action-text">
                                        Enregistrer une sortie d’argent
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="quick-action">

                                <div class="quick-action-icon icon-orange">
                                    <i class="fas fa-print"></i>
                                </div>

                                <div>
                                    <span class="quick-action-title">
                                        Journal de caisse
                                    </span>

                                    <span class="quick-action-text">
                                        Imprimer les mouvements
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <div class="quick-action">

                                <div class="quick-action-icon icon-purple">
                                    <i class="fas fa-file-excel"></i>
                                </div>

                                <div>
                                    <span class="quick-action-title">
                                        Exporter
                                    </span>

                                    <span class="quick-action-text">
                                        Exporter les données vers Excel
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- =================================================
                 GRAPHIQUE + ALERTES
            ================================================== -->
            <div class="row">

                <div class="col-xl-8 col-lg-8">

                    <div class="caisse-card">

                        <div class="caisse-card-header">

                            <div>
                                <h5 class="caisse-card-title">
                                    <i class="fas fa-chart-line"></i>
                                    Évolution de la trésorerie des caisses
                                </h5>

                                <span class="caisse-card-subtitle">
                                    Comparaison des encaissements et décaissements des 7 derniers jours.
                                </span>
                            </div>

                            <select class="form-control form-control-sm" style="width: 145px; border-radius: 8px;">
                                <option>7 derniers jours</option>
                                <option>30 derniers jours</option>
                                <option>Ce mois</option>
                                <option>Cette année</option>
                            </select>

                        </div>

                        <div class="caisse-card-body">
                            <canvas id="cashFlowChart" height="105"></canvas>
                        </div>

                    </div>

                </div>

                <div class="col-xl-4 col-lg-4">

                    <div class="caisse-card">

                        <div class="caisse-card-header">

                            <div>
                                <h5 class="caisse-card-title">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Alertes de trésorerie
                                </h5>

                                <span class="caisse-card-subtitle">
                                    Situations nécessitant une intervention.
                                </span>
                            </div>

                            <span class="badge badge-danger">
                                3 alertes
                            </span>

                        </div>

                        <div class="caisse-card-body">

                            <div class="treasury-alert alert-danger-soft">

                                <div class="treasury-alert-icon">
                                    <i class="fas fa-wallet"></i>
                                </div>

                                <div>
                                    <h6>Solde critique — Chantier Ngozi</h6>

                                    <p>
                                        Le solde disponible est inférieur au seuil
                                        minimal fixé à 2 000 000 BIF.
                                    </p>
                                </div>

                            </div>

                            <div class="treasury-alert alert-warning-soft">

                                <div class="treasury-alert-icon">
                                    <i class="fas fa-clock"></i>
                                </div>

                                <div>
                                    <h6>Approvisionnement en attente</h6>

                                    <p>
                                        La demande du chantier Gitega est en attente
                                        de validation DAF.
                                    </p>
                                </div>

                            </div>

                            <div class="treasury-alert alert-info-soft">

                                <div class="treasury-alert-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>

                                <div>
                                    <h6>Justificatif manquant</h6>

                                    <p>
                                        Une dépense de 850 000 BIF ne possède pas
                                        encore de pièce justificative.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- =================================================
                 FILTRES DES CAISSES
            ================================================== -->
            <div class="caisse-filter-box">

                <div class="row align-items-end">

                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="form-group mb-lg-0">
                            <label>Rechercher une caisse</label>

                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Code, nom ou chantier...">

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
                            <label>Type de caisse</label>

                            <select class="form-control">
                                <option value="">Toutes</option>
                                <option value="siege">Caisse siège</option>
                                <option value="chantier">Caisse chantier</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6">
                        <div class="form-group mb-lg-0">
                            <label>Chantier</label>

                            <select class="form-control">
                                <option value="">Tous les chantiers</option>
                                <option>Chantier Bujumbura</option>
                                <option>Chantier Gitega</option>
                                <option>Chantier Ngozi</option>
                                <option>Chantier Muyinga</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6">
                        <div class="form-group mb-lg-0">
                            <label>Situation</label>

                            <select class="form-control">
                                <option value="">Toutes</option>
                                <option>Solde normal</option>
                                <option>Seuil faible</option>
                                <option>Solde critique</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-12">

                        <button class="btn btn-caisse-primary mr-1">
                            <i class="fas fa-filter mr-1"></i>
                            Appliquer
                        </button>

                        <button class="btn btn-caisse-outline">
                            <i class="fas fa-redo mr-1"></i>
                            Réinitialiser
                        </button>

                    </div>

                </div>

            </div>

            <!-- =================================================
                 LISTE DES CAISSES
            ================================================== -->
            <div class="caisse-card">

                <div class="caisse-card-header">

                    <div>
                        <h5 class="caisse-card-title">
                            <i class="fas fa-wallet"></i>
                            Situation des caisses
                        </h5>

                        <span class="caisse-card-subtitle">
                            Soldes disponibles et mouvements par caisse.
                        </span>
                    </div>

                    <span class="badge badge-success">
                        9 caisses actives
                    </span>

                </div>

                <div class="caisse-card-body pb-2">

                    <div class="row">

                        <!-- Caisse siège -->
                        <div class="col-xl-3 col-lg-4 col-md-6">

                            <div class="cash-box">

                                <div class="cash-box-top">

                                    <div class="cash-box-name">

                                        <div class="cash-box-icon">
                                            <i class="fas fa-building"></i>
                                        </div>

                                        <div>
                                            <h6>Caisse siège</h6>
                                            <div class="cash-box-code">
                                                CAI-SIEGE-001
                                            </div>
                                        </div>

                                    </div>

                                    <span class="cash-status cash-status-active">
                                        Normal
                                    </span>

                                </div>

                                <div class="cash-box-balance">
                                    <span>Solde disponible</span>
                                    <strong>35 400 000 BIF</strong>
                                </div>

                                <div class="cash-progress">
                                    <div class="cash-progress-bar" style="width: 71%;"></div>
                                </div>

                                <div class="cash-box-footer">

                                    <div class="cash-box-footer-item">
                                        <span>Entrées mois</span>
                                        <strong>48,5 M</strong>
                                    </div>

                                    <div class="cash-box-footer-item">
                                        <span>Sorties mois</span>
                                        <strong>36,2 M</strong>
                                    </div>

                                    <div class="cash-box-footer-item">
                                        <span>Opérations</span>
                                        <strong>38</strong>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Gitega -->
                        <div class="col-xl-3 col-lg-4 col-md-6">

                            <div class="cash-box">

                                <div class="cash-box-top">

                                    <div class="cash-box-name">

                                        <div class="cash-box-icon">
                                            <i class="fas fa-hard-hat"></i>
                                        </div>

                                        <div>
                                            <h6>Chantier Gitega</h6>
                                            <div class="cash-box-code">
                                                CAI-CH-002
                                            </div>
                                        </div>

                                    </div>

                                    <span class="cash-status cash-status-active">
                                        Normal
                                    </span>

                                </div>

                                <div class="cash-box-balance">
                                    <span>Solde disponible</span>
                                    <strong>18 400 000 BIF</strong>
                                </div>

                                <div class="cash-progress">
                                    <div class="cash-progress-bar" style="width: 62%;"></div>
                                </div>

                                <div class="cash-box-footer">

                                    <div class="cash-box-footer-item">
                                        <span>Entrées mois</span>
                                        <strong>25 M</strong>
                                    </div>

                                    <div class="cash-box-footer-item">
                                        <span>Sorties mois</span>
                                        <strong>14,6 M</strong>
                                    </div>

                                    <div class="cash-box-footer-item">
                                        <span>Opérations</span>
                                        <strong>24</strong>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Bujumbura -->
                        <div class="col-xl-3 col-lg-4 col-md-6">

                            <div class="cash-box">

                                <div class="cash-box-top">

                                    <div class="cash-box-name">

                                        <div class="cash-box-icon">
                                            <i class="fas fa-hard-hat"></i>
                                        </div>

                                        <div>
                                            <h6>Chantier Bujumbura</h6>
                                            <div class="cash-box-code">
                                                CAI-CH-003
                                            </div>
                                        </div>

                                    </div>

                                    <span class="cash-status cash-status-active">
                                        Normal
                                    </span>

                                </div>

                                <div class="cash-box-balance">
                                    <span>Solde disponible</span>
                                    <strong>32 500 000 BIF</strong>
                                </div>

                                <div class="cash-progress">
                                    <div class="cash-progress-bar" style="width: 80%;"></div>
                                </div>

                                <div class="cash-box-footer">

                                    <div class="cash-box-footer-item">
                                        <span>Entrées mois</span>
                                        <strong>60 M</strong>
                                    </div>

                                    <div class="cash-box-footer-item">
                                        <span>Sorties mois</span>
                                        <strong>42,8 M</strong>
                                    </div>

                                    <div class="cash-box-footer-item">
                                        <span>Opérations</span>
                                        <strong>31</strong>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Ngozi -->
                        <div class="col-xl-3 col-lg-4 col-md-6">

                            <div class="cash-box">

                                <div class="cash-box-top">

                                    <div class="cash-box-name">

                                        <div class="cash-box-icon">
                                            <i class="fas fa-hard-hat"></i>
                                        </div>

                                        <div>
                                            <h6>Chantier Ngozi</h6>
                                            <div class="cash-box-code">
                                                CAI-CH-004
                                            </div>
                                        </div>

                                    </div>

                                    <span class="cash-status cash-status-danger">
                                        Critique
                                    </span>

                                </div>

                                <div class="cash-box-balance">
                                    <span>Solde disponible</span>
                                    <strong>1 250 000 BIF</strong>
                                </div>

                                <div class="cash-progress">
                                    <div class="cash-progress-bar" style="width: 16%; background: #dc2626;"></div>
                                </div>

                                <div class="cash-box-footer">

                                    <div class="cash-box-footer-item">
                                        <span>Entrées mois</span>
                                        <strong>15 M</strong>
                                    </div>

                                    <div class="cash-box-footer-item">
                                        <span>Sorties mois</span>
                                        <strong>13,7 M</strong>
                                    </div>

                                    <div class="cash-box-footer-item">
                                        <span>Opérations</span>
                                        <strong>19</strong>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- =================================================
                 TABLEAU DES MOUVEMENTS
            ================================================== -->
            <div class="caisse-card">

                <div class="caisse-card-header">

                    <div>
                        <h5 class="caisse-card-title">
                            <i class="fas fa-exchange-alt"></i>
                            Mouvements récents de caisse
                        </h5>

                        <span class="caisse-card-subtitle">
                            Derniers encaissements, décaissements et transferts enregistrés.
                        </span>
                    </div>

                    <button class="btn btn-caisse-outline">
                        <i class="fas fa-list mr-1"></i>
                        Voir tout le journal
                    </button>

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
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>1</td>

                                <td>
                                    12/07/2026
                                    <small class="d-block text-muted">
                                        10:45
                                    </small>
                                </td>

                                <td>
                                    <span class="operation-reference">
                                        MVT-2026-00045
                                    </span>
                                </td>

                                <td>
                                    <strong>Caisse Gitega</strong>
                                    <small class="d-block text-muted">
                                        CAI-CH-002
                                    </small>
                                </td>

                                <td>
                                    <span class="badge-operation badge-entree">
                                        <i class="fas fa-arrow-down mr-1"></i>
                                        Entrée
                                    </span>
                                </td>

                                <td class="operation-label">
                                    <strong>Approvisionnement chantier</strong>
                                    <small>
                                        Provenance : Caisse siège
                                    </small>
                                </td>

                                <td class="text-right amount-in">
                                    + 15 000 000
                                </td>

                                <td class="text-right text-muted">
                                    —
                                </td>

                                <td class="text-right">
                                    <strong>18 400 000</strong>
                                </td>

                                <td>
                                    <span class="badge badge-success">
                                        Validé
                                    </span>
                                </td>

                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="btn-table-action btn-table-print" title="Imprimer">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>

                                <td>
                                    12/07/2026
                                    <small class="d-block text-muted">
                                        09:32
                                    </small>
                                </td>

                                <td>
                                    <span class="operation-reference">
                                        MVT-2026-00044
                                    </span>
                                </td>

                                <td>
                                    <strong>Caisse Bujumbura</strong>
                                    <small class="d-block text-muted">
                                        CAI-CH-003
                                    </small>
                                </td>

                                <td>
                                    <span class="badge-operation badge-sortie">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        Sortie
                                    </span>
                                </td>

                                <td class="operation-label">
                                    <strong>Achat de carburant</strong>
                                    <small>
                                        Bénéficiaire : TotalEnergies
                                    </small>
                                </td>

                                <td class="text-right text-muted">
                                    —
                                </td>

                                <td class="text-right amount-out">
                                    - 2 000 000
                                </td>

                                <td class="text-right">
                                    <strong>32 500 000</strong>
                                </td>

                                <td>
                                    <span class="badge badge-success">
                                        Validé
                                    </span>
                                </td>

                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="btn-table-action btn-table-edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn-table-action btn-table-print">
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
                                    <span class="operation-reference">
                                        MVT-2026-00043
                                    </span>
                                </td>

                                <td>
                                    <strong>Caisse siège</strong>
                                    <small class="d-block text-muted">
                                        CAI-SIEGE-001
                                    </small>
                                </td>

                                <td>
                                    <span class="badge-operation badge-sortie">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        Sortie
                                    </span>
                                </td>

                                <td class="operation-label">
                                    <strong>Paiement sous-traitant</strong>
                                    <small>
                                        Bénéficiaire : ABC Construction
                                    </small>
                                </td>

                                <td class="text-right text-muted">
                                    —
                                </td>

                                <td class="text-right amount-out">
                                    - 5 000 000
                                </td>

                                <td class="text-right">
                                    <strong>35 400 000</strong>
                                </td>

                                <td>
                                    <span class="badge badge-warning">
                                        En attente
                                    </span>
                                </td>

                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="btn-table-action btn-table-edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>4</td>

                                <td>
                                    11/07/2026
                                    <small class="d-block text-muted">
                                        13:05
                                    </small>
                                </td>

                                <td>
                                    <span class="operation-reference">
                                        MVT-2026-00042
                                    </span>
                                </td>

                                <td>
                                    <strong>Caisse Ngozi</strong>
                                    <small class="d-block text-muted">
                                        CAI-CH-004
                                    </small>
                                </td>

                                <td>
                                    <span class="badge-operation badge-sortie">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        Sortie
                                    </span>
                                </td>

                                <td class="operation-label">
                                    <strong>Paiement main-d’œuvre</strong>
                                    <small>
                                        Personnel journalier chantier
                                    </small>
                                </td>

                                <td class="text-right text-muted">
                                    —
                                </td>

                                <td class="text-right amount-out">
                                    - 850 000
                                </td>

                                <td class="text-right">
                                    <strong>1 250 000</strong>
                                </td>

                                <td>
                                    <span class="badge badge-danger">
                                        Justificatif
                                    </span>
                                </td>

                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="btn-table-action btn-table-edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>5</td>

                                <td>
                                    10/07/2026
                                    <small class="d-block text-muted">
                                        15:15
                                    </small>
                                </td>

                                <td>
                                    <span class="operation-reference">
                                        MVT-2026-00041
                                    </span>
                                </td>

                                <td>
                                    <strong>Caisse siège</strong>
                                    <small class="d-block text-muted">
                                        CAI-SIEGE-001
                                    </small>
                                </td>

                                <td>
                                    <span class="badge-operation badge-transfert">
                                        <i class="fas fa-exchange-alt mr-1"></i>
                                        Transfert
                                    </span>
                                </td>

                                <td class="operation-label">
                                    <strong>Alimentation caisse chantier</strong>
                                    <small>
                                        Destination : Chantier Gitega
                                    </small>
                                </td>

                                <td class="text-right text-muted">
                                    —
                                </td>

                                <td class="text-right amount-out">
                                    - 15 000 000
                                </td>

                                <td class="text-right">
                                    <strong>40 400 000</strong>
                                </td>

                                <td>
                                    <span class="badge badge-success">
                                        Validé
                                    </span>
                                </td>

                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="btn-table-action btn-table-print">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="p-3 border-top d-flex justify-content-between align-items-center">

                    <small class="text-muted">
                        Affichage de 1 à 5 sur 124 opérations
                    </small>

                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Précédent</a>
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
                            <a class="page-link" href="#">Suivant</a>
                        </li>
                    </ul>

                </div>

            </div>

            <!-- =================================================
                 TOP DÉPENSES + SYNTHÈSE
            ================================================== -->
            <div class="row">

                <div class="col-xl-5 col-lg-5">

                    <div class="caisse-card">

                        <div class="caisse-card-header">

                            <div>
                                <h5 class="caisse-card-title">
                                    <i class="fas fa-chart-bar"></i>
                                    Principales dépenses du mois
                                </h5>

                                <span class="caisse-card-subtitle">
                                    Répartition des sorties de caisse par catégorie.
                                </span>
                            </div>

                        </div>

                        <div class="caisse-card-body">

                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title">
                                        <i class="fas fa-gas-pump"></i>
                                        Carburant
                                    </span>

                                    <span class="expense-item-value">
                                        95 000 000 BIF
                                    </span>
                                </div>

                                <div class="expense-progress">
                                    <span style="width: 92%;"></span>
                                </div>
                            </div>

                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title">
                                        <i class="fas fa-user-tie"></i>
                                        Sous-traitants
                                    </span>

                                    <span class="expense-item-value">
                                        82 000 000 BIF
                                    </span>
                                </div>

                                <div class="expense-progress">
                                    <span style="width: 80%;"></span>
                                </div>
                            </div>

                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title">
                                        <i class="fas fa-users"></i>
                                        Salaires et main-d’œuvre
                                    </span>

                                    <span class="expense-item-value">
                                        77 000 000 BIF
                                    </span>
                                </div>

                                <div class="expense-progress">
                                    <span style="width: 72%;"></span>
                                </div>
                            </div>

                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title">
                                        <i class="fas fa-tools"></i>
                                        Matériaux et fournitures
                                    </span>

                                    <span class="expense-item-value">
                                        60 000 000 BIF
                                    </span>
                                </div>

                                <div class="expense-progress">
                                    <span style="width: 58%;"></span>
                                </div>
                            </div>

                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title">
                                        <i class="fas fa-truck-monster"></i>
                                        Maintenance des engins
                                    </span>

                                    <span class="expense-item-value">
                                        28 000 000 BIF
                                    </span>
                                </div>

                                <div class="expense-progress">
                                    <span style="width: 32%;"></span>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-xl-7 col-lg-7">

                    <div class="caisse-card">

                        <div class="caisse-card-header">

                            <div>
                                <h5 class="caisse-card-title">
                                    <i class="fas fa-project-diagram"></i>
                                    Synthèse par chantier
                                </h5>

                                <span class="caisse-card-subtitle">
                                    Comparaison entre les montants reçus, consommés et disponibles.
                                </span>
                            </div>

                        </div>

                        <div class="table-responsive">

                            <table class="table caisse-table">

                                <thead>
                                    <tr>
                                        <th>Chantier</th>
                                        <th class="text-right">Approvisionné</th>
                                        <th class="text-right">Consommé</th>
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
                                            100 000 000
                                        </td>

                                        <td class="text-right amount-out">
                                            67 500 000
                                        </td>

                                        <td class="text-right amount-in">
                                            32 500 000
                                        </td>

                                        <td style="min-width: 140px;">
                                            <div class="progress progress-xs mb-1">
                                                <div class="progress-bar bg-success" style="width: 67.5%;"></div>
                                            </div>

                                            <small>67,5 %</small>
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
                                            75 000 000
                                        </td>

                                        <td class="text-right amount-out">
                                            56 600 000
                                        </td>

                                        <td class="text-right amount-in">
                                            18 400 000
                                        </td>

                                        <td>
                                            <div class="progress progress-xs mb-1">
                                                <div class="progress-bar bg-warning" style="width: 75.4%;"></div>
                                            </div>

                                            <small>75,4 %</small>
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
                                            50 000 000
                                        </td>

                                        <td class="text-right amount-out">
                                            48 750 000
                                        </td>

                                        <td class="text-right amount-in">
                                            1 250 000
                                        </td>

                                        <td>
                                            <div class="progress progress-xs mb-1">
                                                <div class="progress-bar bg-danger" style="width: 97.5%;"></div>
                                            </div>

                                            <small>97,5 %</small>
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
                                            80 000 000
                                        </td>

                                        <td class="text-right amount-out">
                                            51 000 000
                                        </td>

                                        <td class="text-right amount-in">
                                            29 000 000
                                        </td>

                                        <td>
                                            <div class="progress progress-xs mb-1">
                                                <div class="progress-bar bg-info" style="width: 63.7%;"></div>
                                            </div>

                                            <small>63,7 %</small>
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
     MODALE : CRÉER UNE CAISSE
========================================================== -->
<div class="modal fade modal-caisse" id="addCaisseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="<?= base_url('finance/caisse-store') ?>" method="post" id="addCaisseForm" style="width: 100%;">
            <?php if (
                $this->config->item('csrf_protection')
            ): ?>

            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                value="<?= $this->security->get_csrf_hash() ?>">

            <?php endif; ?>

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="fas fa-wallet mr-2"></i>
                        Créer une nouvelle caisse
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
                                    Code caisse
                                    <span class="required-star">*</span>
                                </label>

                                <input type="text" class="form-control" value="<?= html_escape(
                                                                                    $nextCashboxCode
                                                                                ) ?>" readonly>

                                <small class="text-muted">
                                    Généré automatiquement lors de l’enregistrement.
                                </small>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Intitulé de la caisse
                                    <span class="required-star">*</span>
                                </label>

                                <input type="text" name="name" class="form-control" value="<?= html_escape(
                                                                                                set_value('name')
                                                                                            ) ?>"
                                    placeholder="Ex. Caisse chantier Gitega" maxlength="150" required>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Type de caisse
                                    <span class="required-star">*</span>
                                </label>

                                <select name="type" id="caisseType" class="form-control"
                                    onchange="toggleChantierField()" required>
                                    <option value="">
                                        Sélectionner
                                    </option>

                                    <option value="siege" <?= set_select(
                                                                'type',
                                                                'siege'
                                                            ) ?>>
                                        Caisse siège
                                    </option>

                                    <option value="chantier" <?= set_select(
                                                                    'type',
                                                                    'chantier'
                                                                ) ?>>
                                        Caisse chantier
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6" id="chantierField" style="display: none;">
                            <div class="form-group">

                                <label>
                                    Chantier associé
                                    <span class="required-star">*</span>
                                </label>

                                <select name="chantier_id" id="chantierId" class="form-control">
                                    <option value="">
                                        Sélectionner le chantier
                                    </option>

                                    <?php foreach (
                                        $allChantiers as $chantier
                                    ): ?>

                                    <option value="<?= (int) $chantier->id ?>" <?= set_select(
                                                                                        'chantier_id',
                                                                                        $chantier->id
                                                                                    ) ?>>
                                        <?= html_escape(
                                                $chantier->name
                                            ) ?>
                                    </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Responsable de caisse
                                </label>

                                <input type="text" name="responsable" class="form-control" value="<?= html_escape(
                                                                                                        set_value('responsable')
                                                                                                    ) ?>"
                                    placeholder="Nom du caissier responsable" maxlength="150">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Devise
                                    <span class="required-star">*</span>
                                </label>

                                <select name="devise" class="form-control" required>
                                    <option value="BIF" <?= set_select(
                                                            'devise',
                                                            'BIF',
                                                            true
                                                        ) ?>>
                                        BIF
                                    </option>

                                    <option value="USD" <?= set_select(
                                                            'devise',
                                                            'USD'
                                                        ) ?>>
                                        USD
                                    </option>

                                    <option value="EUR" <?= set_select(
                                                            'devise',
                                                            'EUR'
                                                        ) ?>>
                                        EUR
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Solde initial
                                </label>

                                <input type="number" name="opening_balance" class="form-control" value="<?= html_escape(
                                                                                                            set_value(
                                                                                                                'opening_balance',
                                                                                                                '0'
                                                                                                            )
                                                                                                        ) ?>" min="0"
                                    step="0.01" required>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Seuil d’alerte
                                </label>

                                <input type="number" name="alert_threshold" class="form-control" value="<?= html_escape(
                                                                                                            set_value(
                                                                                                                'alert_threshold',
                                                                                                                '0'
                                                                                                            )
                                                                                                        ) ?>" min="0"
                                    step="0.01" placeholder="Ex. 2 000 000" required>

                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="form-group mb-0">

                                <label>
                                    Observation
                                </label>

                                <textarea name="observation" class="form-control"
                                    placeholder="Informations complémentaires..."><?= html_escape(
                                                                                        set_value('observation')
                                                                                    ) ?></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-caisse-outline" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-caisse-primary">
                        <i class="fas fa-save mr-1"></i>
                        Enregistrer la caisse
                    </button>

                </div>

            </div>

        </form>

    </div>
</div>

<!-- =========================================================
     MODALE : NOUVELLE OPÉRATION
========================================================== -->
<div class="modal fade modal-caisse" id="addOperationModal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">

        <form action="<?= base_url('finance/cashbox-operation-store') ?>" method="post" enctype="multipart/form-data"
            id="cashboxOperationForm" style="width: 100%;">

            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                value="<?= $this->security->get_csrf_hash() ?>">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        <span id="operationModalTitle">
                            Nouvelle opération de caisse
                        </span>
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" name="operation_type" id="operationType">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    Date de l’opération
                                    <span class="required-star">*</span>
                                </label>

                                <input type="date" name="operation_date" class="form-control"
                                    value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    Caisse concernée
                                    <span class="required-star">*</span>
                                </label>

                                <select name="cashbox_id" id="operationCashboxId" class="form-control" required>
                                    <option value="">
                                        Sélectionner la caisse
                                    </option>

                                    <?php foreach ($allCashboxes as $cashbox): ?>

                                    <option value="<?= (int) $cashbox->id ?>"
                                        data-devise="<?= html_escape($cashbox->devise) ?>"
                                        data-balance="<?= (float) $cashbox->current_balance ?>">
                                        <?= html_escape($cashbox->code) ?>
                                        —
                                        <?= html_escape($cashbox->name) ?>
                                        —
                                        <?= number_format(
                                                $cashbox->current_balance,
                                                0,
                                                ',',
                                                ' '
                                            ) ?>
                                        <?= html_escape($cashbox->devise) ?>
                                    </option>

                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div id="selectedCashboxBalance" class="mt-2" style="display: none;">
                                <small class="text-muted">
                                    Solde disponible :
                                </small>

                                <strong id="selectedCashboxBalanceValue" class="text-success">
                                    0 BIF
                                </strong>
                            </div>
                        </div>

                        <div class="col-md-4" id="destinationCashboxField" style="display: none;">

                            <div class="form-group">
                                <label>
                                    Caisse destination
                                    <span class="required-star">*</span>
                                </label>

                                <select name="destination_cashbox_id" id="destinationCashboxId" class="form-control"
                                    disabled>
                                    <option value="">
                                        Sélectionner la destination
                                    </option>

                                    <?php foreach ($allCashboxes as $cashbox): ?>

                                    <option value="<?= (int) $cashbox->id ?>"
                                        data-devise="<?= html_escape($cashbox->devise) ?>">
                                        <?= html_escape($cashbox->code) ?>
                                        —
                                        <?= html_escape($cashbox->name) ?>
                                    </option>

                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    Montant
                                    <span class="required-star">*</span>
                                </label>

                                <div class="input-group">

                                    <input type="number" name="amount" class="form-control" min="0" step="0.01"
                                        placeholder="0" required>

                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            BIF
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Catégorie</label>

                                <select name="category" class="form-control">

                                    <option value="">Sélectionner</option>
                                    <option>Approvisionnement</option>
                                    <option>Carburant</option>
                                    <option>Main-d’œuvre</option>
                                    <option>Fournitures</option>
                                    <option>Sous-traitance</option>
                                    <option>Maintenance engin</option>
                                    <option>Transport</option>
                                    <option>Autre</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bénéficiaire / Provenance</label>

                                <input type="text" name="third_party" class="form-control"
                                    placeholder="Nom du bénéficiaire ou de la source">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mode de règlement</label>

                                <select name="payment_method" class="form-control">

                                    <option value="cash">Espèces</option>
                                    <option value="bank">Virement bancaire</option>
                                    <option value="cheque">Chèque</option>
                                    <option value="mobile">Mobile Money</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Numéro de pièce</label>

                                <input type="text" name="document_number" class="form-control"
                                    placeholder="Facture, reçu, bon...">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Pièce justificative</label>

                                <div class="custom-file">
                                    <input type="file" name="attachment" class="custom-file-input"
                                        id="operationAttachment">

                                    <label class="custom-file-label" for="operationAttachment">
                                        Choisir un fichier
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">

                            <div class="form-group mb-0">

                                <label>
                                    Observation
                                </label>

                                <textarea name="observation" class="form-control"
                                    placeholder="Informations complémentaires sur l’opération..."></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-caisse-outline" data-dismiss="modal">

                        <i class="fas fa-times mr-1"></i>
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-caisse-primary">

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

<!-- Chart.js doit être chargé dans le header ou avant ce script -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const chartElement = document.getElementById('cashFlowChart');

    if (chartElement && typeof Chart !== 'undefined') {

        const context = chartElement.getContext('2d');

        const gradientIncome = context.createLinearGradient(0, 0, 0, 250);
        gradientIncome.addColorStop(0, 'rgba(15, 118, 110, 0.30)');
        gradientIncome.addColorStop(1, 'rgba(15, 118, 110, 0.02)');

        const gradientExpense = context.createLinearGradient(0, 0, 0, 250);
        gradientExpense.addColorStop(0, 'rgba(220, 38, 38, 0.20)');
        gradientExpense.addColorStop(1, 'rgba(220, 38, 38, 0.01)');

        new Chart(context, {
            type: 'line',

            data: {
                labels: [
                    '06 Juil.',
                    '07 Juil.',
                    '08 Juil.',
                    '09 Juil.',
                    '10 Juil.',
                    '11 Juil.',
                    '12 Juil.'
                ],

                datasets: [{
                        label: 'Encaissements',
                        data: [
                            18500000,
                            26000000,
                            15000000,
                            32000000,
                            24000000,
                            28000000,
                            35000000
                        ],
                        borderColor: '#0f766e',
                        backgroundColor: gradientIncome,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0f766e',
                        fill: true,
                        tension: 0.35
                    },
                    {
                        label: 'Décaissements',
                        data: [
                            12000000,
                            17000000,
                            13500000,
                            22500000,
                            18000000,
                            20500000,
                            7500000
                        ],
                        borderColor: '#dc2626',
                        backgroundColor: gradientExpense,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#dc2626',
                        fill: true,
                        tension: 0.35
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: true,

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
                                return context.dataset.label + ' : ' +
                                    new Intl.NumberFormat('fr-FR').format(
                                        context.parsed.y
                                    ) + ' BIF';
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

function toggleChantierField() {

    const type = document.getElementById('caisseType').value;
    const chantierField = document.getElementById('chantierField');

    if (type === 'chantier') {
        chantierField.style.display = 'block';
    } else {
        chantierField.style.display = 'none';
    }
}

// function prepareOperation(type) {

//     const title = document.getElementById('operationModalTitle');
//     const operationType = document.getElementById('operationType');
//     const destinationField = document.getElementById(
//         'destinationCashboxField'
//     );

//     operationType.value = type;
//     destinationField.style.display = 'none';

//     if (type === 'approvisionnement') {
//         title.innerHTML = 'Approvisionner une caisse chantier';
//         destinationField.style.display = 'block';
//     }

//     if (type === 'encaissement') {
//         title.innerHTML = 'Enregistrer un encaissement';
//     }

//     if (type === 'decaissement') {
//         title.innerHTML = 'Enregistrer un décaissement';
//     }
// }

$(document).on('change', '.custom-file-input', function() {

    const fileName = $(this).val().split('\\').pop();

    $(this)
        .next('.custom-file-label')
        .html(fileName || 'Choisir un fichier');
});
</script>

<script>
function prepareOperation(type) {
    const title =
        document.getElementById('operationModalTitle');

    const operationType =
        document.getElementById('operationType');

    const destinationField =
        document.getElementById('destinationCashboxField');

    const destinationSelect =
        document.getElementById('destinationCashboxId');

    const cashboxLabel =
        document.getElementById('operationCashboxLabel');

    const categorySelect =
        document.querySelector(
            '#cashboxOperationForm select[name="category"]'
        );

    operationType.value = type;

    destinationField.style.display = 'none';
    destinationSelect.disabled = true;
    destinationSelect.required = false;
    destinationSelect.value = '';

    if (type === 'approvisionnement') {
        title.innerHTML =
            'Approvisionner une caisse chantier';

        destinationField.style.display = 'block';

        destinationSelect.disabled = false;
        destinationSelect.required = true;

        if (cashboxLabel) {
            cashboxLabel.innerHTML =
                'Caisse source <span class="required-star">*</span>';
        }

        if (categorySelect) {
            categorySelect.value =
                'Approvisionnement';
        }
    }

    if (type === 'encaissement') {
        title.innerHTML =
            'Enregistrer un encaissement';

        if (cashboxLabel) {
            cashboxLabel.innerHTML =
                'Caisse à créditer <span class="required-star">*</span>';
        }
    }

    if (type === 'decaissement') {
        title.innerHTML =
            'Enregistrer un décaissement';

        if (cashboxLabel) {
            cashboxLabel.innerHTML =
                'Caisse à débiter <span class="required-star">*</span>';
        }
    }
}

document.addEventListener(
    'DOMContentLoaded',
    function() {
        const sourceSelect =
            document.getElementById(
                'operationCashboxId'
            );

        const destinationSelect =
            document.getElementById(
                'destinationCashboxId'
            );

        const balanceBox =
            document.getElementById(
                'selectedCashboxBalance'
            );

        const balanceValue =
            document.getElementById(
                'selectedCashboxBalanceValue'
            );

        sourceSelect.addEventListener(
            'change',
            function() {
                const selectedOption =
                    this.options[this.selectedIndex];

                const balance =
                    selectedOption.dataset.balance || 0;

                const devise =
                    selectedOption.dataset.devise || 'BIF';

                if (!this.value) {
                    balanceBox.style.display = 'none';
                    return;
                }

                balanceValue.innerHTML =
                    new Intl.NumberFormat(
                        'fr-FR'
                    ).format(balance) +
                    ' ' +
                    devise;

                balanceBox.style.display = 'block';

                /*
                 * Masquer la caisse source dans la destination.
                 */
                Array.from(
                    destinationSelect.options
                ).forEach(function(option) {
                    if (!option.value) {
                        return;
                    }

                    option.disabled =
                        option.value === sourceSelect.value;
                });

                if (
                    destinationSelect.value ===
                    sourceSelect.value
                ) {
                    destinationSelect.value = '';
                }
            }
        );
    }
);
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

<?php if ($this->session->flashdata('error')): ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#addCaisseModal').modal('show');
});
</script>

<?php endif; ?>