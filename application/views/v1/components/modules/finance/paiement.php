<!-- =========================================================
PAGE : FACTURES CLIENTS
MODULE : DAF / FINANCE / FACTURATION
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
        background: #fff;
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
        color: #fff;
        border-color: #0f766e;
        background: #0f766e;
    }

    .cashbox-filter-actions {
        display: flex;
        align-items: center;
        min-height: 40px;
    }

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
   TABLEAU DES FACTURES
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

    /* Jauge de règlement dans la colonne « Payé » */
    .facture-progress {
        width: 90px;
        height: 5px;
        margin-top: 5px;
        overflow: hidden;
        border-radius: 20px;
        background: #e9eef3;
    }

    .facture-progress span {
        display: block;
        height: 100%;
        border-radius: 20px;
        background: linear-gradient(90deg, #14b8a6, #0f766e);
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

    .btn-table-pay {
        color: #15803d;
    }

    /* =====================================================
   ÉCHÉANCES + RÉPARTITION
====================================================== */
    .echeance-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        background: #f8fafc;
    }

    .echeance-item:last-child {
        margin-bottom: 0;
    }

    .echeance-icon {
        display: flex;
        flex: 0 0 36px;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        margin-right: 10px;
        border-radius: 9px;
    }

    .echeance-item h6 {
        margin: 0 0 3px;
        color: var(--caisse-secondary);
        font-size: 11px;
        font-weight: 800;
    }

    .echeance-item p {
        margin: 0;
        color: var(--caisse-muted);
        font-size: 10px;
    }

    .echeance-amount {
        margin-left: auto;
        text-align: right;
    }

    .echeance-amount strong {
        display: block;
        color: var(--caisse-secondary);
        font-size: 12px;
        font-weight: 800;
    }

    .echeance-amount small {
        color: var(--caisse-muted);
        font-size: 9px;
    }

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

    .expense-progress span.bar-red {
        background: linear-gradient(90deg, #f87171, #dc2626);
    }

    .expense-progress span.bar-blue {
        background: linear-gradient(90deg, #38bdf8, #0284c7);
    }

    .expense-progress span.bar-orange {
        background: linear-gradient(90deg, #fbbf24, #f59e0b);
    }

    /* =====================================================
   PAGINATION
====================================================== */
    .facture-pagination .page-item .page-link {
        margin: 0 3px;
        padding: 7px 12px;
        color: var(--caisse-primary);
        border: 1px solid #dbe4ea;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
    }

    .facture-pagination .page-item.active .page-link {
        color: #fff;
        border-color: var(--caisse-primary);
        background: var(--caisse-primary);
    }

    .facture-pagination .page-item.disabled .page-link {
        color: #cbd5e1;
        background: #f8fafc;
    }

    /* =====================================================
   MODALE
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

    /* =====================================================
   RESPONSIVE
====================================================== */
    @media (max-width: 991px) {
        .caisse-filter-box .form-group {
            margin-bottom: 13px !important;
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
                        <li class="breadcrumb-item"><a href="<?= base_url('facturation') ?>">Facturation</a></li>
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
                                    <i class="fas fa-hand-holding-usd"></i>
                                </span>
                                Paiements
                            </div>
                            <p>
                                Registre central des règlements : encaissements des factures
                                clients et paiements des factures fournisseurs, avec mode de
                                règlement, imputation et émission des reçus.
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4 d-flex justify-content-md-end">
                            <div class="caisse-date-box">
                                <small><i class="far fa-calendar-alt mr-1"></i> Période couverte</small>
                                <strong>01/06/2026 – 10/08/2026</strong>
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
                 STATISTIQUES DE LA PÉRIODE
            ================================================== -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-green"><i class="fas fa-arrow-down"></i></div>
                            <span class="caisse-stat-badge badge-positive">8 règlements</span>
                        </div>
                        <div class="caisse-stat-label">Encaissements clients</div>
                        <div class="caisse-stat-value">235 500 000 BIF</div>
                        <div class="caisse-stat-footer">Règlements totaux et acomptes reçus</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-red"><i class="fas fa-arrow-up"></i></div>
                            <span class="caisse-stat-badge badge-negative">12 règlements</span>
                        </div>
                        <div class="caisse-stat-label">Paiements fournisseurs</div>
                        <div class="caisse-stat-value">214 500 000 BIF</div>
                        <div class="caisse-stat-footer">dont 2 règlements partiels</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-blue"><i class="fas fa-balance-scale"></i></div>
                            <span class="caisse-stat-badge badge-positive">Excédentaire</span>
                        </div>
                        <div class="caisse-stat-label">Flux net des paiements</div>
                        <div class="caisse-stat-value" style="color:#15803d;">+21 000 000 BIF</div>
                        <div class="caisse-stat-footer">Encaissements – paiements sur la période</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-orange"><i class="fas fa-hourglass-half"></i></div>
                            <span class="caisse-stat-badge badge-neutral">3 règlements</span>
                        </div>
                        <div class="caisse-stat-label">Paiements en attente</div>
                        <div class="caisse-stat-value">16 850 000 BIF</div>
                        <div class="caisse-stat-footer">À valider ou à programmer</div>
                    </div>
                </div>
            </div>

            <!-- =================================================
                 FILTRES
            ================================================== -->
            <div class="caisse-filter-box">
                <form action="<?= current_url() ?>" method="get">
                    <div class="row align-items-end">
                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Rechercher un paiement</label>
                                <div class="input-group">
                                    <input type="text" name="pay_search" class="form-control"
                                        placeholder="Référence, tiers, facture..." autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text" title="Rechercher">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Sens du paiement</label>
                                <select name="pay_sens" class="form-control">
                                    <option value="">Tous</option>
                                    <option>Encaissement</option>
                                    <option>Paiement</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Mode de règlement</label>
                                <select name="pay_mode" class="form-control">
                                    <option value="">Tous</option>
                                    <option>Espèces</option>
                                    <option>Virement bancaire</option>
                                    <option>Chèque</option>
                                    <option>Mobile Money</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Du</label>
                                <input type="date" name="pay_date_from" class="form-control" value="2026-06-01">
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Au</label>
                                <input type="date" name="pay_date_to" class="form-control" value="2026-08-10">
                            </div>
                        </div>
                        <div class="col-xl-1 col-lg-1 col-md-12">
                            <div class="cashbox-filter-actions">
                                <button type="submit" class="btn btn-caisse-primary w-100"
                                    title="Appliquer les filtres">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="cashbox-active-filters">
                        <span class="cashbox-active-filters-label"><i class="fas fa-filter mr-1"></i> Filtres actifs
                            :</span>
                        <span class="cashbox-filter-tag">Période : <strong>01/06/2026 → 10/08/2026</strong></span>
                        <span class="cashbox-filter-tag">Sens : <strong>Tous</strong></span>
                        <span class="cashbox-filter-results">20 paiements</span>
                    </div>
                </form>
            </div>

            <!-- =================================================
                 REGISTRE DES PAIEMENTS
            ================================================== -->
            <div class="caisse-card">
                <div class="caisse-card-header">
                    <div>
                        <h5 class="caisse-card-title">
                            <i class="fas fa-list-alt"></i>
                            Registre des paiements
                        </h5>
                        <span class="caisse-card-subtitle">
                            Tous les règlements enregistrés, classés du plus récent au plus ancien.
                        </span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-caisse-outline mr-1" data-toggle="modal"
                            data-target="#addPaiementModal">
                            <i class="fas fa-plus mr-1"></i>
                            Nouveau paiement
                        </button>
                        <a href="#" class="btn btn-caisse-primary">
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
                                <th>Référence</th>
                                <th>Date</th>
                                <th>Sens</th>
                                <th>Tiers</th>
                                <th>Facture liée</th>
                                <th>Mode de règlement</th>
                                <th>Caisse / Compte</th>
                                <th class="text-right">Montant</th>
                                <th>Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><span class="operation-reference">PAY-2026-0312</span></td>
                                <td>08/08/2026</td>
                                <td><span class="badge badge-success">Encaissement</span></td>
                                <td class="operation-label"><strong>Client BRARUDI</strong><small>Règlement facture
                                        soldée</small></td>
                                <td><span class="livre-ref-badge">FAC-2026-0109</span></td>
                                <td><i class="fas fa-university mr-1" style="color:#0369a1;"></i> Virement bancaire</td>
                                <td><strong>Compte bancaire BCB</strong><small class="d-block text-muted">102254</small>
                                </td>
                                <td class="text-right amount-in">+ 54 000 000</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Reçu"><i
                                            class="fas fa-receipt"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><span class="operation-reference">PAY-2026-0311</span></td>
                                <td>06/08/2026</td>
                                <td><span class="badge badge-danger">Paiement</span></td>
                                <td class="operation-label"><strong>Fournisseur SARL Batimat</strong><small>Règlement
                                        partiel 50 %</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0207</span></td>
                                <td><i class="fas fa-money-bill-wave mr-1" style="color:#15803d;"></i> Espèces</td>
                                <td><strong>Caisse siège</strong><small class="d-block text-muted">CAI-2026-001</small>
                                </td>
                                <td class="text-right amount-out">- 16 000 000</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Reçu"><i
                                            class="fas fa-receipt"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><span class="operation-reference">PAY-2026-0310</span></td>
                                <td>05/08/2026</td>
                                <td><span class="badge badge-success">Encaissement</span></td>
                                <td class="operation-label"><strong>Client CONSUME</strong><small>Règlement facture
                                        soldée</small></td>
                                <td><span class="livre-ref-badge">FAC-2026-0111</span></td>
                                <td><i class="fas fa-money-check-alt mr-1" style="color:#b45309;"></i> Chèque</td>
                                <td><strong>Compte bancaire BCB</strong><small class="d-block text-muted">102254</small>
                                </td>
                                <td class="text-right amount-in">+ 86 500 000</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Reçu"><i
                                            class="fas fa-receipt"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><span class="operation-reference">PAY-2026-0309</span></td>
                                <td>04/08/2026</td>
                                <td><span class="badge badge-danger">Paiement</span></td>
                                <td class="operation-label"><strong>Fournisseur Locamat</strong><small>Location
                                        échafaudage juillet</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0211</span></td>
                                <td><i class="fas fa-money-bill-wave mr-1" style="color:#15803d;"></i> Espèces</td>
                                <td><strong>Caisse chantier Gitega</strong><small
                                        class="d-block text-muted">CAI-2026-003</small></td>
                                <td class="text-right amount-out">- 5 500 000</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Reçu"><i
                                            class="fas fa-receipt"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><span class="operation-reference">PAY-2026-0308</span></td>
                                <td>02/08/2026</td>
                                <td><span class="badge badge-success">Encaissement</span></td>
                                <td class="operation-label"><strong>Client Kabezi</strong><small>Acompte sur décompte
                                        final</small></td>
                                <td><span class="livre-ref-badge">FAC-2026-0107</span></td>
                                <td><i class="fas fa-money-bill-wave mr-1" style="color:#15803d;"></i> Espèces</td>
                                <td><strong>Caisse siège</strong><small class="d-block text-muted">CAI-2026-001</small>
                                </td>
                                <td class="text-right amount-in">+ 20 000 000</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Reçu"><i
                                            class="fas fa-receipt"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><span class="operation-reference">PAY-2026-0307</span></td>
                                <td>01/08/2026</td>
                                <td><span class="badge badge-danger">Paiement</span></td>
                                <td class="operation-label"><strong>Fournisseur Carrière Nyakabiga</strong><small>Achat
                                        sable rivière</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0209</span></td>
                                <td><i class="fas fa-mobile-alt mr-1" style="color:#6d28d9;"></i> Mobile Money</td>
                                <td><strong>Caisse siège</strong><small class="d-block text-muted">CAI-2026-001</small>
                                </td>
                                <td class="text-right amount-out">- 8 750 000</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Reçu"><i
                                            class="fas fa-receipt"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><span class="operation-reference">PAY-2026-0306</span></td>
                                <td>30/07/2026</td>
                                <td><span class="badge badge-danger">Paiement</span></td>
                                <td class="operation-label"><strong>Fournisseur Station Total</strong><small>Carburant
                                        groupe électrogène</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0212</span></td>
                                <td><i class="fas fa-money-bill-wave mr-1" style="color:#15803d;"></i> Espèces</td>
                                <td><strong>Caisse chantier Ngozi</strong><small
                                        class="d-block text-muted">CAI-2026-005</small></td>
                                <td class="text-right amount-out">- 3 850 000</td>
                                <td><span class="badge badge-warning">En attente</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-edit" title="Valider"><i
                                            class="fas fa-check"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><span class="operation-reference">PAY-2026-0305</span></td>
                                <td>28/07/2026</td>
                                <td><span class="badge badge-success">Encaissement</span></td>
                                <td class="operation-label"><strong>Client SATRACO Immo</strong><small>Acompte 50
                                        %</small></td>
                                <td><span class="livre-ref-badge">FAC-2026-0110</span></td>
                                <td><i class="fas fa-university mr-1" style="color:#0369a1;"></i> Virement bancaire</td>
                                <td><strong>Compte bancaire BCB</strong><small class="d-block text-muted">102254</small>
                                </td>
                                <td class="text-right amount-in">+ 35 000 000</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Reçu"><i
                                            class="fas fa-receipt"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td><span class="operation-reference">PAY-2026-0304</span></td>
                                <td>25/07/2026</td>
                                <td><span class="badge badge-danger">Paiement</span></td>
                                <td class="operation-label"><strong>Fournisseur Kanyoni Transport</strong><small>Acompte
                                        transport gravier</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0210</span></td>
                                <td><i class="fas fa-money-bill-wave mr-1" style="color:#15803d;"></i> Espèces</td>
                                <td><strong>Caisse chantier Ngozi</strong><small
                                        class="d-block text-muted">CAI-2026-005</small></td>
                                <td class="text-right amount-out">- 2 000 000</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Reçu"><i
                                            class="fas fa-receipt"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><span class="operation-reference">PAY-2026-0303</span></td>
                                <td>22/07/2026</td>
                                <td><span class="badge badge-success">Encaissement</span></td>
                                <td class="operation-label"><strong>Client REGIDESO</strong><small>Acompte lot
                                        électricité</small></td>
                                <td><span class="livre-ref-badge">FAC-2026-0108</span></td>
                                <td><i class="fas fa-university mr-1" style="color:#0369a1;"></i> Virement bancaire</td>
                                <td><strong>Compte bancaire BCB</strong><small class="d-block text-muted">102254</small>
                                </td>
                                <td class="text-right amount-in">+ 20 000 000</td>
                                <td><span class="badge badge-success">Validé</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Reçu"><i
                                            class="fas fa-receipt"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pied du tableau : pagination -->
                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap">
                    <small class="text-muted">Affichage de 1 à 10 sur 20 paiements</small>
                    <nav>
                        <ul class="pagination facture-pagination mb-0">
                            <li class="page-item disabled"><span class="page-link"><i
                                        class="fas fa-chevron-left"></i></span></li>
                            <li class="page-item active"><span class="page-link">1</span></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- =================================================
                 RÉPARTITION PAR MODE + PAIEMENTS EN ATTENTE
            ================================================== -->
            <div class="row">
                <!-- RÉPARTITION PAR MODE DE RÈGLEMENT -->
                <div class="col-xl-6 col-lg-6">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-credit-card"></i> Répartition par mode de
                                    règlement</h5>
                                <span class="caisse-card-subtitle">Volume des paiements par mode sur la période.</span>
                            </div>
                            <span class="badge badge-light">20 paiements</span>
                        </div>
                        <div class="caisse-card-body">
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-university"></i> Virement bancaire
                                        <small class="text-muted ml-1">(9)</small></span>
                                    <span class="expense-item-value">52 %</span>
                                </div>
                                <div class="expense-progress"><span class="bar-blue" style="width: 52%;"></span></div>
                            </div>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-money-bill-wave"></i> Espèces
                                        <small class="text-muted ml-1">(8)</small></span>
                                    <span class="expense-item-value">30 %</span>
                                </div>
                                <div class="expense-progress"><span style="width: 30%;"></span></div>
                            </div>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-money-check-alt"></i> Chèque
                                        <small class="text-muted ml-1">(2)</small></span>
                                    <span class="expense-item-value">12 %</span>
                                </div>
                                <div class="expense-progress"><span class="bar-orange" style="width: 12%;"></span></div>
                            </div>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-mobile-alt"></i> Mobile Money
                                        <small class="text-muted ml-1">(1)</small></span>
                                    <span class="expense-item-value">6 %</span>
                                </div>
                                <div class="expense-progress"><span class="bar-red" style="width: 6%;"></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PAIEMENTS EN ATTENTE DE TRAITEMENT -->
                <div class="col-xl-6 col-lg-6">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-hourglass-half"></i> Paiements en attente
                                    de traitement</h5>
                                <span class="caisse-card-subtitle">Règlements à valider, programmer ou compléter.</span>
                            </div>
                            <span class="badge badge-warning">3 en attente</span>
                        </div>
                        <div class="caisse-card-body">
                            <div class="echeance-item">
                                <div class="echeance-icon" style="color:#b91c1c; background:#fee2e2;"><i
                                        class="fas fa-exclamation-circle"></i></div>
                                <div>
                                    <h6>Paiement échue à programmer — Gedeon H.</h6>
                                    <p>FF-2026-0206 — main-d'œuvre maçonnerie, échéance dépassée</p>
                                </div>
                                <div class="echeance-amount">
                                    <strong>12 500 000 BIF</strong>
                                    <small>À décaisser</small>
                                </div>
                            </div>
                            <div class="echeance-item">
                                <div class="echeance-icon" style="color:#b45309; background:#fef3c7;"><i
                                        class="fas fa-clock"></i></div>
                                <div>
                                    <h6>PAY-2026-0306 — Station Total</h6>
                                    <p>Paiement enregistré, en attente de validation DAF</p>
                                </div>
                                <div class="echeance-amount">
                                    <strong>3 850 000 BIF</strong>
                                    <small>À valider</small>
                                </div>
                            </div>
                            <div class="echeance-item">
                                <div class="echeance-icon" style="color:#0369a1; background:#e0f2fe;"><i
                                        class="fas fa-undo"></i></div>
                                <div>
                                    <h6>Remboursement avance personnel — J. Niyonzima</h6>
                                    <p>Reçu à émettre après encaissement espèces</p>
                                </div>
                                <div class="echeance-amount">
                                    <strong>500 000 BIF</strong>
                                    <small>Reçu à émettre</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- =========================================================
MODALE : NOUVEAU PAIEMENT
========================================================== -->
<div class="modal fade modal-caisse" id="addPaiementModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="#" method="post" style="width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-hand-holding-usd mr-2"></i> Nouveau paiement</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sens du paiement <span class="required-star">*</span></label>
                                <select class="form-control" required>
                                    <option value="">Sélectionner</option>
                                    <option>Encaissement client</option>
                                    <option>Paiement fournisseur</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tiers concerné <span class="required-star">*</span></label>
                                <select class="form-control" required>
                                    <option value="">Sélectionner le tiers</option>
                                    <optgroup label="Clients">
                                        <option>BRARUDI</option>
                                        <option>CONSUME</option>
                                        <option>SATRACO Immo</option>
                                        <option>REGIDESO</option>
                                        <option>Kabezi</option>
                                    </optgroup>
                                    <optgroup label="Fournisseurs">
                                        <option>SARL Batimat</option>
                                        <option>Station Total</option>
                                        <option>Locamat</option>
                                        <option>Kanyoni Transport</option>
                                        <option>Carrière Nyakabiga</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Facture liée <span class="required-star">*</span></label>
                                <select class="form-control" required>
                                    <option value="">Sélectionner la facture ouverte</option>
                                    <option>FAC-2026-0112 — BRARUDI — solde 125 000 000</option>
                                    <option>FAC-2026-0110 — SATRACO Immo — solde 35 000 000</option>
                                    <option>FAC-2026-0107 — Kabezi — solde 12 500 000</option>
                                    <option>FF-2026-0206 — Gedeon H. — solde 12 500 000</option>
                                    <option>FF-2026-0207 — SARL Batimat — solde 16 000 000</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date du paiement <span class="required-star">*</span></label>
                                <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Montant <span class="required-star">*</span></label>
                                <input type="number" class="form-control" min="0.01" step="0.01" placeholder="0"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mode de règlement <span class="required-star">*</span></label>
                                <select class="form-control" required>
                                    <option value="cash">Espèces</option>
                                    <option value="bank">Virement bancaire</option>
                                    <option value="cheque">Chèque</option>
                                    <option value="mobile">Mobile Money</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Caisse / compte imputé <span class="required-star">*</span></label>
                                <select class="form-control" required>
                                    <option value="">Sélectionner</option>
                                    <option>Caisse siège — CAI-2026-001</option>
                                    <option>Caisse chantier Gitega — CAI-2026-003</option>
                                    <option>Caisse chantier Ngozi — CAI-2026-005</option>
                                    <option>Compte bancaire BCB — 102254</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label>Observation</label>
                                <textarea class="form-control"
                                    placeholder="Référence du virement, n° de chèque, précisions..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-caisse-outline" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-caisse-primary">
                        <i class="fas fa-save mr-1"></i> Enregistrer le paiement
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

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