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
                                    <i class="fas fa-file-invoice"></i>
                                </span>
                                Factures clients
                            </div>
                            <p>
                                Émettez, suivez et relancez les factures clients :
                                situation de règlement, soldes restants dus et échéances,
                                du brouillon jusqu'à l'encaissement complet.
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
                            <div class="caisse-stat-icon icon-blue"><i class="fas fa-file-invoice"></i></div>
                            <span class="caisse-stat-badge badge-positive"><i class="fas fa-arrow-up mr-1"></i>
                                +2</span>
                        </div>
                        <div class="caisse-stat-label">Factures émises</div>
                        <div class="caisse-stat-value">611 000 000 BIF</div>
                        <div class="caisse-stat-footer">13 factures sur la période</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-green"><i class="fas fa-hand-holding-usd"></i></div>
                            <span class="caisse-stat-badge badge-positive">Taux 38,5 %</span>
                        </div>
                        <div class="caisse-stat-label">Montant encaissé</div>
                        <div class="caisse-stat-value">235 500 000 BIF</div>
                        <div class="caisse-stat-footer">Règlements totaux et partiels</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-orange"><i class="fas fa-hourglass-half"></i></div>
                            <span class="caisse-stat-badge badge-neutral">5 factures</span>
                        </div>
                        <div class="caisse-stat-label">Solde restant dû</div>
                        <div class="caisse-stat-value">375 500 000 BIF</div>
                        <div class="caisse-stat-footer">Factures ouvertes non soldées</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-red"><i class="fas fa-exclamation-circle"></i></div>
                            <span class="caisse-stat-badge badge-negative">2 factures</span>
                        </div>
                        <div class="caisse-stat-label">Factures échues</div>
                        <div class="caisse-stat-value">63 000 000 BIF</div>
                        <div class="caisse-stat-footer">Retard le plus ancien : 32 jours</div>
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
                                <label>Rechercher une facture</label>
                                <div class="input-group">
                                    <input type="text" name="facture_search" class="form-control"
                                        placeholder="Numéro, client, chantier..." autocomplete="off">
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
                                <label>Statut</label>
                                <select name="facture_status" class="form-control">
                                    <option value="">Tous</option>
                                    <option>Brouillon</option>
                                    <option>Émise</option>
                                    <option>Partiellement payée</option>
                                    <option>Payée</option>
                                    <option>Échue</option>
                                    <option>Annulée</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Client</label>
                                <select name="facture_client" class="form-control">
                                    <option value="">Tous les clients</option>
                                    <option>BRARUDI</option>
                                    <option>CONSUME</option>
                                    <option>SATRACO Immo</option>
                                    <option>REGIDESO</option>
                                    <option>Kabezi</option>
                                    <option>NGOZI Store</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Du</label>
                                <input type="date" name="facture_date_from" class="form-control" value="2026-06-01">
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Au</label>
                                <input type="date" name="facture_date_to" class="form-control" value="2026-08-10">
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
                        <span class="cashbox-filter-tag">Statut : <strong>Tous</strong></span>
                        <span class="cashbox-filter-results">13 factures</span>
                    </div>
                </form>
            </div>

            <!-- =================================================
                 TABLEAU DES FACTURES
            ================================================== -->
            <div class="caisse-card">
                <div class="caisse-card-header">
                    <div>
                        <h5 class="caisse-card-title">
                            <i class="fas fa-list-alt"></i>
                            Registre des factures clients
                        </h5>
                        <span class="caisse-card-subtitle">
                            Factures classées de la plus récente à la plus ancienne.
                        </span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-caisse-outline mr-1" data-toggle="modal"
                            data-target="#addFactureModal">
                            <i class="fas fa-plus mr-1"></i>
                            Nouvelle facture
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
                                <th>N° facture</th>
                                <th>Émission</th>
                                <th>Échéance</th>
                                <th>Client</th>
                                <th>Chantier / Objet</th>
                                <th class="text-right">Montant TTC</th>
                                <th>Payé</th>
                                <th class="text-right">Solde dû</th>
                                <th>Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><span class="operation-reference">FAC-2026-0113</span></td>
                                <td>05/08/2026</td>
                                <td class="text-muted">—</td>
                                <td><strong>Kabezi</strong></td>
                                <td class="operation-label"><strong>Chantier Kabezi</strong><small>Travaux
                                        supplémentaires</small></td>
                                <td class="text-right"><strong>21 500 000</strong></td>
                                <td><span class="text-muted">—</span></td>
                                <td class="text-right text-muted">21 500 000</td>
                                <td><span class="badge badge-secondary">Brouillon</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-edit" title="Modifier"><i
                                            class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><span class="operation-reference">FAC-2026-0112</span></td>
                                <td>03/08/2026</td>
                                <td>02/09/2026</td>
                                <td><strong>BRARUDI</strong></td>
                                <td class="operation-label"><strong>Chantier IBB entrepots</strong><small>Tranche 3 des
                                        travaux</small></td>
                                <td class="text-right"><strong>125 000 000</strong></td>
                                <td>
                                    <span class="text-muted">0</span>
                                    <div class="facture-progress"><span style="width: 0%;"></span></div>
                                </td>
                                <td class="text-right amount-out">125 000 000</td>
                                <td><span class="badge badge-info">Émise</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Encaisser"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer / PDF"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><span class="operation-reference">FAC-2026-0111</span></td>
                                <td>01/08/2026</td>
                                <td>31/08/2026</td>
                                <td><strong>CONSUME</strong></td>
                                <td class="operation-label"><strong>Chantier Gitega</strong><small>Décompte n° 4</small>
                                </td>
                                <td class="text-right"><strong>86 500 000</strong></td>
                                <td>
                                    <span class="amount-in">86 500 000</span>
                                    <div class="facture-progress"><span style="width: 100%;"></span></div>
                                </td>
                                <td class="text-right text-muted">0</td>
                                <td><span class="badge badge-success">Payée</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer / PDF"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><span class="operation-reference">FAC-2026-0110</span></td>
                                <td>28/07/2026</td>
                                <td>15/08/2026</td>
                                <td><strong>SATRACO Immo</strong></td>
                                <td class="operation-label"><strong>Chantier Musaga</strong><small>Acompte 50 %</small>
                                </td>
                                <td class="text-right"><strong>70 000 000</strong></td>
                                <td>
                                    <span class="amount-in">35 000 000</span>
                                    <div class="facture-progress"><span style="width: 50%;"></span></div>
                                </td>
                                <td class="text-right amount-out">35 000 000</td>
                                <td><span class="badge badge-warning">Partielle</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Encaisser"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer / PDF"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><span class="operation-reference">FAC-2026-0109</span></td>
                                <td>20/07/2026</td>
                                <td>19/08/2026</td>
                                <td><strong>BRARUDI</strong></td>
                                <td class="operation-label"><strong>Siège social</strong><small>Réhabilitation
                                        bureaux</small></td>
                                <td class="text-right"><strong>54 000 000</strong></td>
                                <td>
                                    <span class="amount-in">54 000 000</span>
                                    <div class="facture-progress"><span style="width: 100%;"></span></div>
                                </td>
                                <td class="text-right text-muted">0</td>
                                <td><span class="badge badge-success">Payée</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer / PDF"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><span class="operation-reference">FAC-2026-0108</span></td>
                                <td>15/07/2026</td>
                                <td>14/08/2026</td>
                                <td><strong>REGIDESO</strong></td>
                                <td class="operation-label"><strong>Chantier Ngozi</strong><small>Lot
                                        électricité</small></td>
                                <td class="text-right"><strong>98 000 000</strong></td>
                                <td>
                                    <span class="text-muted">0</span>
                                    <div class="facture-progress"><span style="width: 0%;"></span></div>
                                </td>
                                <td class="text-right amount-out">98 000 000</td>
                                <td><span class="badge badge-info">Émise</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Encaisser"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer / PDF"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><span class="operation-reference">FAC-2026-0107</span></td>
                                <td>10/07/2026</td>
                                <td>09/08/2026</td>
                                <td><strong>Kabezi</strong></td>
                                <td class="operation-label"><strong>Chantier Kabezi</strong><small>Décompte
                                        final</small></td>
                                <td class="text-right"><strong>32 500 000</strong></td>
                                <td>
                                    <span class="amount-in">20 000 000</span>
                                    <div class="facture-progress"><span style="width: 62%;"></span></div>
                                </td>
                                <td class="text-right amount-out">12 500 000</td>
                                <td><span class="badge badge-warning">Partielle</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Encaisser"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer / PDF"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><span class="operation-reference">FAC-2026-0106</span></td>
                                <td>05/07/2026</td>
                                <td style="color:#b91c1c; font-weight:700;">04/08/2026</td>
                                <td><strong>BRARUDI</strong></td>
                                <td class="operation-label"><strong>Chantier IBB entrepots</strong><small>Tranche 2 des
                                        travaux</small></td>
                                <td class="text-right"><strong>45 000 000</strong></td>
                                <td>
                                    <span class="text-muted">0</span>
                                    <div class="facture-progress"><span style="width: 0%;"></span></div>
                                </td>
                                <td class="text-right amount-out">45 000 000</td>
                                <td><span class="badge badge-danger">Échue</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Encaisser"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer / PDF"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td><span class="operation-reference">FAC-2026-0105</span></td>
                                <td>01/07/2026</td>
                                <td>31/07/2026</td>
                                <td><strong>CONSUME</strong></td>
                                <td class="operation-label"><strong>Chantier Musaga</strong><small>Décompte n° 3</small>
                                </td>
                                <td class="text-right"><strong>27 500 000</strong></td>
                                <td>
                                    <span class="amount-in">27 500 000</span>
                                    <div class="facture-progress"><span style="width: 100%;"></span></div>
                                </td>
                                <td class="text-right text-muted">0</td>
                                <td><span class="badge badge-success">Payée</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer / PDF"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><span class="operation-reference">FAC-2026-0104</span></td>
                                <td>28/06/2026</td>
                                <td style="color:#b91c1c; font-weight:700;">28/07/2026</td>
                                <td><strong>NGOZI Store</strong></td>
                                <td class="operation-label"><strong>Chantier Ngozi</strong><small>Travaux voirie</small>
                                </td>
                                <td class="text-right"><strong>18 000 000</strong></td>
                                <td>
                                    <span class="text-muted">0</span>
                                    <div class="facture-progress"><span style="width: 0%;"></span></div>
                                </td>
                                <td class="text-right amount-out">18 000 000</td>
                                <td><span class="badge badge-danger">Échue</span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Encaisser"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer / PDF"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pied du tableau : pagination -->
                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap">
                    <small class="text-muted">Affichage de 1 à 10 sur 13 factures</small>
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
                 ÉCHÉANCES À VENIR + RÉPARTITION PAR STATUT
            ================================================== -->
            <div class="row">
                <!-- PROCHAINES ÉCHÉANCES -->
                <div class="col-xl-6 col-lg-6">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-calendar-alt"></i> Prochaines échéances
                                </h5>
                                <span class="caisse-card-subtitle">Factures ouvertes classées par date
                                    d'échéance.</span>
                            </div>
                            <a href="<?= base_url('facture-echeances') ?>" class="btn btn-caisse-outline btn-sm">
                                Toutes les échéances
                            </a>
                        </div>
                        <div class="caisse-card-body">
                            <div class="echeance-item">
                                <div class="echeance-icon" style="color:#b45309; background:#fef3c7;"><i
                                        class="fas fa-clock"></i></div>
                                <div>
                                    <h6>FAC-2026-0110 — SATRACO Immo</h6>
                                    <p>Échéance dans 5 jours (15/08/2026)</p>
                                </div>
                                <div class="echeance-amount">
                                    <strong>35 000 000 BIF</strong>
                                    <small>Solde dû</small>
                                </div>
                            </div>
                            <div class="echeance-item">
                                <div class="echeance-icon" style="color:#0369a1; background:#e0f2fe;"><i
                                        class="fas fa-calendar-day"></i></div>
                                <div>
                                    <h6>FAC-2026-0109 — BRARUDI</h6>
                                    <p>Échéance dans 9 jours (19/08/2026)</p>
                                </div>
                                <div class="echeance-amount">
                                    <strong>0 BIF</strong>
                                    <small>Soldée</small>
                                </div>
                            </div>
                            <div class="echeance-item">
                                <div class="echeance-icon" style="color:#0369a1; background:#e0f2fe;"><i
                                        class="fas fa-calendar-day"></i></div>
                                <div>
                                    <h6>FAC-2026-0111 — CONSUME</h6>
                                    <p>Échéance dans 21 jours (31/08/2026)</p>
                                </div>
                                <div class="echeance-amount">
                                    <strong>0 BIF</strong>
                                    <small>Soldée</small>
                                </div>
                            </div>
                            <div class="echeance-item">
                                <div class="echeance-icon" style="color:#0369a1; background:#e0f2fe;"><i
                                        class="fas fa-calendar-day"></i></div>
                                <div>
                                    <h6>FAC-2026-0112 — BRARUDI</h6>
                                    <p>Échéance dans 23 jours (02/09/2026)</p>
                                </div>
                                <div class="echeance-amount">
                                    <strong>125 000 000 BIF</strong>
                                    <small>Solde dû</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RÉPARTITION PAR STATUT -->
                <div class="col-xl-6 col-lg-6">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-chart-pie"></i> Répartition par statut
                                </h5>
                                <span class="caisse-card-subtitle">Situation du portefeuille de factures.</span>
                            </div>
                            <span class="badge badge-light">13 factures</span>
                        </div>
                        <div class="caisse-card-body">
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-check-circle"></i> Payées <small
                                            class="text-muted ml-1">(6)</small></span>
                                    <span class="expense-item-value">46 %</span>
                                </div>
                                <div class="expense-progress"><span style="width: 46%;"></span></div>
                            </div>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-paper-plane"></i> Émises <small
                                            class="text-muted ml-1">(3)</small></span>
                                    <span class="expense-item-value">23 %</span>
                                </div>
                                <div class="expense-progress"><span class="bar-blue" style="width: 23%;"></span></div>
                            </div>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-adjust"></i> Partielles <small
                                            class="text-muted ml-1">(2)</small></span>
                                    <span class="expense-item-value">15 %</span>
                                </div>
                                <div class="expense-progress"><span class="bar-orange" style="width: 15%;"></span></div>
                            </div>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-times-circle"></i> Échues <small
                                            class="text-muted ml-1">(2)</small></span>
                                    <span class="expense-item-value">15 %</span>
                                </div>
                                <div class="expense-progress"><span class="bar-red" style="width: 15%;"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- =========================================================
MODALE : NOUVELLE FACTURE CLIENT
========================================================== -->
<div class="modal fade modal-caisse" id="addFactureModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="#" method="post" style="width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-invoice mr-2"></i> Nouvelle facture client</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Client <span class="required-star">*</span></label>
                                <select class="form-control" required>
                                    <option value="">Sélectionner le client</option>
                                    <option>BRARUDI</option>
                                    <option>CONSUME</option>
                                    <option>SATRACO Immo</option>
                                    <option>REGIDESO</option>
                                    <option>Kabezi</option>
                                    <option>NGOZI Store</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Chantier / Projet</label>
                                <select class="form-control">
                                    <option value="">Sélectionner le chantier</option>
                                    <option>Chantier IBB entrepots</option>
                                    <option>Chantier Gitega</option>
                                    <option>Chantier Musaga</option>
                                    <option>Chantier Ngozi</option>
                                    <option>Siège social</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date d'émission <span class="required-star">*</span></label>
                                <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date d'échéance <span class="required-star">*</span></label>
                                <input type="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Devise</label>
                                <select class="form-control">
                                    <option selected>BIF</option>
                                    <option>USD</option>
                                    <option>EUR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Montant HT <span class="required-star">*</span></label>
                                <input type="number" class="form-control" min="0" step="0.01" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>TVA (%)</label>
                                <select class="form-control">
                                    <option value="0" selected>0 % (exonéré)</option>
                                    <option value="18">18 %</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Objet de la facture</label>
                                <input type="text" class="form-control" placeholder="Ex. Décompte n° 4 — tranche 3">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label>Observation</label>
                                <textarea class="form-control" placeholder="Informations complémentaires..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-caisse-outline" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-caisse-outline">
                        <i class="fas fa-save mr-1"></i> Enregistrer en brouillon
                    </button>
                    <button type="submit" class="btn btn-caisse-primary">
                        <i class="fas fa-paper-plane mr-1"></i> Émettre la facture
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