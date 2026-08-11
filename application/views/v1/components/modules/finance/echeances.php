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
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                Suivi des échéances
                            </div>
                            <p>
                                Surveillez les dates limites d'encaissement des factures clients
                                et de règlement des factures fournisseurs, priorisez les retards
                                et anticipez la trésorerie des 30 prochains jours.
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4 d-flex justify-content-md-end">
                            <div class="caisse-date-box">
                                <small><i class="far fa-calendar-alt mr-1"></i> Situation au</small>
                                <strong><?= date('d/m/Y') ?></strong>
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
                 STATISTIQUES DES ÉCHÉANCES
            ================================================== -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-red"><i class="fas fa-exclamation-circle"></i></div>
                            <span class="caisse-stat-badge badge-negative">4 échéances</span>
                        </div>
                        <div class="caisse-stat-label">Montants échus</div>
                        <div class="caisse-stat-value">82 300 000 BIF</div>
                        <div class="caisse-stat-footer">dont 63 000 000 BIF à encaisser (clients)</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-orange"><i class="fas fa-clock"></i></div>
                            <span class="caisse-stat-badge badge-neutral">2 échéances</span>
                        </div>
                        <div class="caisse-stat-label">À échéance sous 7 jours</div>
                        <div class="caisse-stat-value">51 000 000 BIF</div>
                        <div class="caisse-stat-footer">Actions à préparer cette semaine</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-blue"><i class="fas fa-calendar-day"></i></div>
                            <span class="caisse-stat-badge badge-neutral">4 échéances</span>
                        </div>
                        <div class="caisse-stat-label">À échéance sous 30 jours</div>
                        <div class="caisse-stat-value">178 150 000 BIF</div>
                        <div class="caisse-stat-footer">Encours à planifier</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-green"><i class="fas fa-check-double"></i></div>
                            <span class="caisse-stat-badge badge-positive">87 % à l'heure</span>
                        </div>
                        <div class="caisse-stat-label">Échéances soldées (période)</div>
                        <div class="caisse-stat-value">14</div>
                        <div class="caisse-stat-footer">Réglées ou encaissées à bonne date</div>
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
                                <label>Rechercher une échéance</label>
                                <div class="input-group">
                                    <input type="text" name="ech_search" class="form-control"
                                        placeholder="Tiers, n° de facture..." autocomplete="off">
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
                                <label>Sens</label>
                                <select name="ech_sens" class="form-control">
                                    <option value="">Tous</option>
                                    <option>À encaisser (client)</option>
                                    <option>À régler (fournisseur)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Situation</label>
                                <select name="ech_situation" class="form-control">
                                    <option value="">Toutes</option>
                                    <option>Échue</option>
                                    <option>Sous 7 jours</option>
                                    <option>Sous 30 jours</option>
                                    <option>Au-delà de 30 jours</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>Échéances du</label>
                                <input type="date" name="ech_date_from" class="form-control" value="2026-07-01">
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label>au</label>
                                <input type="date" name="ech_date_to" class="form-control" value="2026-09-30">
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
                        <span class="cashbox-filter-tag">Période : <strong>01/07/2026 → 30/09/2026</strong></span>
                        <span class="cashbox-filter-tag">Situation : <strong>Toutes</strong></span>
                        <span class="cashbox-filter-results">10 échéances ouvertes</span>
                    </div>
                </form>
            </div>

            <!-- =================================================
                 REGISTRE DES ÉCHÉANCES
            ================================================== -->
            <div class="caisse-card">
                <div class="caisse-card-header">
                    <div>
                        <h5 class="caisse-card-title">
                            <i class="fas fa-list-ol"></i>
                            Registre des échéances ouvertes
                        </h5>
                        <span class="caisse-card-subtitle">
                            Classées de la plus urgente à la plus lointaine.
                        </span>
                    </div>
                    <a href="#" class="btn btn-caisse-primary">
                        <i class="fas fa-file-excel mr-1"></i>
                        Exporter
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table caisse-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Échéance</th>
                                <th>Retard / Reste</th>
                                <th>Sens</th>
                                <th>Tiers</th>
                                <th>Facture liée</th>
                                <th class="text-right">Montant total</th>
                                <th class="text-right">Déjà réglé</th>
                                <th class="text-right">Solde exigible</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td style="color:#b91c1c; font-weight:700;">28/07/2026</td>
                                <td><span class="badge badge-danger">- 13 jours</span></td>
                                <td><span class="badge badge-success">À encaisser</span></td>
                                <td class="operation-label"><strong>Client NGOZI Store</strong><small>Travaux voirie
                                        Ngozi</small></td>
                                <td><span class="livre-ref-badge">FAC-2026-0104</span></td>
                                <td class="text-right"><strong>18 000 000</strong></td>
                                <td class="text-right text-muted">0</td>
                                <td class="text-right amount-out">18 000 000</td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir la facture"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-edit" title="Relancer le client"><i
                                            class="fas fa-bell"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td style="color:#b91c1c; font-weight:700;">31/07/2026</td>
                                <td><span class="badge badge-danger">- 10 jours</span></td>
                                <td><span class="badge badge-danger">À régler</span></td>
                                <td class="operation-label"><strong>Fournisseur Locamat</strong><small>Location engins
                                        juin</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0204</span></td>
                                <td class="text-right"><strong>6 800 000</strong></td>
                                <td class="text-right text-muted">0</td>
                                <td class="text-right amount-out">6 800 000</td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir la facture"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Programmer le paiement"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td style="color:#b91c1c; font-weight:700;">04/08/2026</td>
                                <td><span class="badge badge-danger">- 6 jours</span></td>
                                <td><span class="badge badge-success">À encaisser</span></td>
                                <td class="operation-label"><strong>Client BRARUDI</strong><small>Tranche 2 chantier
                                        IBB</small></td>
                                <td><span class="livre-ref-badge">FAC-2026-0106</span></td>
                                <td class="text-right"><strong>45 000 000</strong></td>
                                <td class="text-right text-muted">0</td>
                                <td class="text-right amount-out">45 000 000</td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir la facture"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-edit" title="Relancer le client"><i
                                            class="fas fa-bell"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td style="color:#b91c1c; font-weight:700;">04/08/2026</td>
                                <td><span class="badge badge-danger">- 6 jours</span></td>
                                <td><span class="badge badge-danger">À régler</span></td>
                                <td class="operation-label"><strong>Fournisseur Gedeon H.</strong><small>Main-d'œuvre
                                        maçonnerie</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0206</span></td>
                                <td class="text-right"><strong>12 500 000</strong></td>
                                <td class="text-right text-muted">0</td>
                                <td class="text-right amount-out">12 500 000</td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir la facture"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Programmer le paiement"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td style="color:#b45309; font-weight:700;">14/08/2026</td>
                                <td><span class="badge badge-warning">+ 4 jours</span></td>
                                <td><span class="badge badge-danger">À régler</span></td>
                                <td class="operation-label"><strong>Fournisseur SARL Batimat</strong><small>Tranche 2
                                        matériaux maçonnerie</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0207</span></td>
                                <td class="text-right"><strong>32 000 000</strong></td>
                                <td class="text-right amount-in">16 000 000</td>
                                <td class="text-right amount-out">16 000 000</td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir la facture"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Programmer le paiement"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td style="color:#b45309; font-weight:700;">15/08/2026</td>
                                <td><span class="badge badge-warning">+ 5 jours</span></td>
                                <td><span class="badge badge-success">À encaisser</span></td>
                                <td class="operation-label"><strong>Client SATRACO Immo</strong><small>Acompte 50 %
                                        chantier Musaga</small></td>
                                <td><span class="livre-ref-badge">FAC-2026-0110</span></td>
                                <td class="text-right"><strong>70 000 000</strong></td>
                                <td class="text-right amount-in">35 000 000</td>
                                <td class="text-right amount-out">35 000 000</td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir la facture"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-edit" title="Envoyer un rappel"><i
                                            class="fas fa-bell"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>19/08/2026</td>
                                <td><span class="badge badge-info">+ 9 jours</span></td>
                                <td><span class="badge badge-danger">À régler</span></td>
                                <td class="operation-label"><strong>Fournisseur REGIDESO</strong><small>Électricité
                                        siège</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0208</span></td>
                                <td class="text-right"><strong>2 450 000</strong></td>
                                <td class="text-right text-muted">0</td>
                                <td class="text-right amount-out">2 450 000</td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir la facture"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Programmer le paiement"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>29/08/2026</td>
                                <td><span class="badge badge-info">+ 19 jours</span></td>
                                <td><span class="badge badge-danger">À régler</span></td>
                                <td class="operation-label"><strong>Fournisseur Kanyoni
                                        Transport</strong><small>Transport gravier 15 m³</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0210</span></td>
                                <td class="text-right"><strong>4 200 000</strong></td>
                                <td class="text-right amount-in">2 000 000</td>
                                <td class="text-right amount-out">2 200 000</td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir la facture"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Programmer le paiement"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>02/09/2026</td>
                                <td><span class="badge badge-info">+ 23 jours</span></td>
                                <td><span class="badge badge-success">À encaisser</span></td>
                                <td class="operation-label"><strong>Client BRARUDI</strong><small>Tranche 3 chantier
                                        IBB</small></td>
                                <td><span class="livre-ref-badge">FAC-2026-0112</span></td>
                                <td class="text-right"><strong>125 000 000</strong></td>
                                <td class="text-right text-muted">0</td>
                                <td class="text-right amount-out">125 000 000</td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir la facture"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>05/09/2026</td>
                                <td><span class="badge badge-info">+ 26 jours</span></td>
                                <td><span class="badge badge-danger">À régler</span></td>
                                <td class="operation-label"><strong>Fournisseur SARL Batimat</strong><small>Ciment &
                                        fers à béton</small></td>
                                <td><span class="livre-ref-badge">FF-2026-0213</span></td>
                                <td class="text-right"><strong>48 500 000</strong></td>
                                <td class="text-right text-muted">0</td>
                                <td class="text-right amount-out">48 500 000</td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir la facture"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-pay" title="Programmer le paiement"><i
                                            class="fas fa-hand-holding-usd"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pied du tableau -->
                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap">
                    <small class="text-muted">
                        10 échéances ouvertes — solde exigible total :
                        <strong style="color:#b91c1c;">311 450 000 BIF</strong>
                    </small>
                    <a href="<?= base_url('facture-paiements') ?>" class="btn btn-caisse-outline btn-sm">
                        <i class="fas fa-hand-holding-usd mr-1"></i>
                        Traiter dans Paiements
                    </a>
                </div>
            </div>

            <!-- =================================================
                 PRÉVISIONNEL 30 JOURS + ANCIENNETÉ DES SOLDES
            ================================================== -->
            <div class="row">
                <!-- PRÉVISIONNEL DE TRÉSORERIE -->
                <div class="col-xl-7 col-lg-7">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-chart-line"></i> Prévisionnel de
                                    trésorerie (4 semaines)</h5>
                                <span class="caisse-card-subtitle">Encaissements attendus vs règlements
                                    programmés.</span>
                            </div>
                            <span class="badge badge-light">30 jours</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table caisse-table">
                                <thead>
                                    <tr>
                                        <th>Semaine</th>
                                        <th class="text-right">Encaissements attendus</th>
                                        <th class="text-right">Règlements programmés</th>
                                        <th class="text-right">Flux net prévu</th>
                                        <th>Commentaire</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Semaine 33</strong><small class="d-block text-muted">10 – 16
                                                août</small></td>
                                        <td class="text-right amount-in">+ 35 000 000</td>
                                        <td class="text-right amount-out">- 16 000 000</td>
                                        <td class="text-right" style="color:#15803d; font-weight:800;">+ 19 000 000</td>
                                        <td><small class="text-muted">Acompte SATRACO Immo + Batimat</small></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Semaine 34</strong><small class="d-block text-muted">17 – 23
                                                août</small></td>
                                        <td class="text-right text-muted">0</td>
                                        <td class="text-right amount-out">- 2 450 000</td>
                                        <td class="text-right" style="color:#b91c1c; font-weight:800;">- 2 450 000</td>
                                        <td><small class="text-muted">Facture REGIDESO</small></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Semaine 35</strong><small class="d-block text-muted">24 – 30
                                                août</small></td>
                                        <td class="text-right text-muted">0</td>
                                        <td class="text-right amount-out">- 2 200 000</td>
                                        <td class="text-right" style="color:#b91c1c; font-weight:800;">- 2 200 000</td>
                                        <td><small class="text-muted">Solde Kanyoni Transport</small></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Semaine 36</strong><small class="d-block text-muted">31 août – 06
                                                sept.</small></td>
                                        <td class="text-right amount-in">+ 125 000 000</td>
                                        <td class="text-right amount-out">- 48 500 000</td>
                                        <td class="text-right" style="color:#15803d; font-weight:800;">+ 76 500 000</td>
                                        <td><small class="text-muted">Tranche 3 BRARUDI vs Batimat</small></td>
                                    </tr>
                                    <tr class="livre-totals-row" style="background:#f8fafc;">
                                        <td><i class="fas fa-sigma mr-1" style="color:#0f766e;"></i> Total 30 jours</td>
                                        <td class="text-right amount-in">+ 160 000 000</td>
                                        <td class="text-right amount-out">- 69 150 000</td>
                                        <td class="text-right" style="color:#15803d; font-weight:800;">
                                            + 90 850 000
                                            <small class="d-block text-muted">Flux net prévu</small>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ANCIENNETÉ DES SOLDES EXIGIBLES -->
                <div class="col-xl-5 col-lg-5">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-hourglass-half"></i> Ancienneté des
                                    soldes exigibles</h5>
                                <span class="caisse-card-subtitle">Clients + fournisseurs confondus.</span>
                            </div>
                            <span class="badge badge-danger">311,45 M ouverts</span>
                        </div>
                        <div class="caisse-card-body">
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-calendar-check"></i> Non échus
                                        <small class="text-muted ml-1">(6)</small></span>
                                    <span class="expense-item-value">229 150 000 BIF</span>
                                </div>
                                <div class="expense-progress"><span style="width: 74%;"></span></div>
                            </div>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-exclamation-triangle"></i> Échus 1
                                        – 15 jours <small class="text-muted ml-1">(4)</small></span>
                                    <span class="expense-item-value">82 300 000 BIF</span>
                                </div>
                                <div class="expense-progress"><span class="bar-red" style="width: 26%;"></span></div>
                            </div>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-times-circle"></i> Échus 16 – 30
                                        jours <small class="text-muted ml-1">(0)</small></span>
                                    <span class="expense-item-value">0 BIF</span>
                                </div>
                                <div class="expense-progress"><span class="bar-red" style="width: 0%;"></span></div>
                            </div>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title"><i class="fas fa-skull-crossbones"></i> Échus &gt;
                                        30 jours <small class="text-muted ml-1">(0)</small></span>
                                    <span class="expense-item-value">0 BIF</span>
                                </div>
                                <div class="expense-progress"><span class="bar-red" style="width: 0%;"></span></div>
                            </div>
                            <div class="livre-note" style="margin-top: 18px;">
                                <strong>Recommandation :</strong> relancer prioritairement le client
                                NGOZI Store (-13 j) et programmer le paiement Locamat (-10 j) afin
                                d'éviter les pénalités et de préserver la relation fournisseur.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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