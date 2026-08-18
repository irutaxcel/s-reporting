<?php
if (!function_exists('formatCashboxAmount')) {
    function formatCashboxAmount($amount): string
    {
        return number_format((float) $amount, 0, ',', ' ');
    }
}
if (!function_exists('formatCompactAmount')) {
    function formatCompactAmount($amount)
    {
        $amount = (float) $amount;
        if ($amount >= 1000000000) return number_format($amount / 1000000000, 1, ',', ' ') . ' Md';
        if ($amount >= 1000000) return number_format($amount / 1000000, 1, ',', ' ') . ' M';
        if ($amount >= 1000) return number_format($amount / 1000, 1, ',', ' ') . ' K';
        return number_format($amount, 0, ',', ' ');
    }
}
if (!function_exists('formatCashboxDate')) {
    function formatCashboxDate($date): string
    {
        if (empty($date)) return '—';
        return date('d/m/Y', strtotime($date));
    }
}
if (!function_exists('formatCashboxTime')) {
    function formatCashboxTime($datetime): string
    {
        if (empty($datetime)) return '';
        return date('H:i', strtotime($datetime));
    }
}
?>
<!-- =========================================================
PAGE : GESTION DES CAISSES (PRINCIPALE + SECONDAIRE UNIQUES)
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

/* ============ EN-TÊTE ============ */
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
    max-width: 780px;
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

/* ============ BOUTONS ============ */
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

/* ============ KPI ============ */
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
    transition: all .2s ease;
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

/* ============ CARTES ============ */
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
}

.caisse-card-body {
    padding: 20px;
}

/* ============ SCHÉMA DU FLUX ============ */
.flux-steps {
    display: grid;
    grid-template-columns: 1fr 40px 1fr 40px 1fr;
    align-items: stretch;
}

.flux-step {
    padding: 18px;
    border: 1px solid var(--caisse-border);
    border-radius: 13px;
    background: #f8fafc;
    text-align: center;
}

.flux-step-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    margin-bottom: 10px;
    border-radius: 12px;
    font-size: 18px;
}

.flux-step h6 {
    margin: 0 0 5px;
    color: var(--caisse-secondary);
    font-size: 12px;
    font-weight: 800;
}

.flux-step p {
    margin: 0;
    color: var(--caisse-muted);
    font-size: 10px;
    line-height: 1.5;
}

.flux-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 18px;
}

@media (max-width: 991px) {
    .flux-steps {
        grid-template-columns: 1fr;
    }

    .flux-arrow {
        transform: rotate(90deg);
        padding: 6px 0;
    }
}

/* ============ CARTES CAISSE PRINCIPALE / SECONDAIRE ============ */
.principal-box {
    position: relative;
    overflow: hidden;
    margin-bottom: 22px;
    border: 1px solid rgba(124, 58, 237, .25);
    border-radius: 15px;
    background: linear-gradient(135deg, #fdfcff, #f3efff);
}

.principal-box.secondary-box {
    border-color: rgba(2, 132, 199, .25);
    background: linear-gradient(135deg, #fbfdff, #eff8ff);
}

.principal-box-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    padding: 18px 20px 8px;
}

.principal-box-name {
    display: flex;
    align-items: center;
}

.principal-box-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    margin-right: 12px;
    color: #6d28d9;
    border-radius: 13px;
    background: #ede9fe;
    font-size: 19px;
}

.secondary-box .principal-box-icon {
    color: #0369a1;
    background: #e0f2fe;
}

.principal-box-name h5 {
    margin: 0 0 3px;
    color: var(--caisse-secondary);
    font-size: 15px;
    font-weight: 800;
}

.principal-box-name small {
    color: var(--caisse-muted);
    font-size: 10px;
    font-weight: 700;
}

.role-badge {
    padding: 6px 11px;
    border-radius: 30px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
}

.role-principale {
    color: #6d28d9;
    background: #ede9fe;
}

.role-secondaire {
    color: #0369a1;
    background: #e0f2fe;
}

.principal-box-balance {
    padding: 6px 20px 14px;
}

.principal-box-balance span {
    display: block;
    margin-bottom: 2px;
    color: var(--caisse-muted);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}

.principal-box-balance strong {
    color: var(--caisse-secondary);
    font-size: 28px;
    font-weight: 800;
}

.principal-box-stats {
    display: flex;
    flex-wrap: wrap;
    border-top: 1px solid #ece6fb;
    background: #fbfaff;
}

.secondary-box .principal-box-stats {
    border-top-color: #e3f2fd;
    background: #f8fcff;
}

.principal-stat {
    flex: 1;
    min-width: 140px;
    padding: 12px 8px;
    text-align: center;
    border-right: 1px solid #ece6fb;
}

.secondary-box .principal-stat {
    border-right-color: #e3f2fd;
}

.principal-stat:last-child {
    border-right: none;
}

.principal-stat span {
    display: block;
    margin-bottom: 2px;
    color: var(--caisse-muted);
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
}

.principal-stat strong {
    color: var(--caisse-secondary);
    font-size: 12px;
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

/* ============ ACTIONS RAPIDES ============ */
.quick-action {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    min-height: 104px;
    padding: 16px;
    overflow: hidden;
    background: #fff;
    border: 1px solid #d9e3ec;
    border-radius: 14px;
    color: #1e293b;
    text-align: left;
    text-decoration: none;
    cursor: pointer;
    transition: all .2s ease;
}

button.quick-action {
    appearance: none;
    font-family: inherit;
}

.quick-action:hover,
.quick-action:focus {
    color: #0f766e;
    text-decoration: none;
    border-color: rgba(15, 118, 110, .38);
    box-shadow: 0 10px 24px rgba(15, 23, 42, .09);
    transform: translateY(-3px);
    outline: none;
}

.quick-action-icon {
    position: relative;
    z-index: 2;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 48px;
    width: 48px;
    height: 48px;
    margin-right: 13px;
    border-radius: 13px;
    font-size: 19px;
}

.quick-action-content {
    position: relative;
    z-index: 2;
    min-width: 0;
}

.quick-action-title {
    display: block;
    margin-bottom: 5px;
    color: #243247;
    font-size: 14px;
    font-weight: 700;
}

.quick-action-text {
    display: block;
    color: #64748b;
    font-size: 11px;
    line-height: 1.5;
}

/* ============ TABLEAU ============ */
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

/* ============ ALERTES ============ */
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

/* ============ DÉPENSES / CHANTIERS ============ */
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
}

.expense-progress span.bar-orange {
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
}

.expense-progress span.bar-blue {
    background: linear-gradient(90deg, #38bdf8, #0284c7);
}

.expense-progress span.bar-red {
    background: linear-gradient(90deg, #f87171, #dc2626);
}

/* ============ GRAPHIQUE ============ */
.cashflow-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 18px;
}

.cashflow-summary-item {
    padding: 11px 13px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #f8fafc;
}

.cashflow-summary-item span {
    display: block;
    margin-bottom: 4px;
    color: #64748b;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
}

.cashflow-summary-item strong {
    display: block;
    font-size: 13px;
    font-weight: 800;
}

.cashflow-chart-wrapper {
    position: relative;
    width: 100%;
    height: 305px;
}

.cashflow-chart-wrapper canvas {
    width: 100% !important;
    height: 100% !important;
}

/* ============ MODALES ============ */
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

.cashbox-selected-balance {
    margin-top: 8px;
    padding: 8px 12px;
    border: 1px solid #99d5ce;
    border-radius: 9px;
    background: #f0fdfa;
}

.cashbox-selected-balance small {
    display: block;
    color: #0f766e;
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
}

.cashbox-selected-balance strong {
    color: var(--caisse-secondary);
    font-size: 13px;
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

    .caisse-stat-value {
        font-size: 19px;
    }

    .cashflow-summary {
        grid-template-columns: 1fr;
    }

    .cashflow-chart-wrapper {
        height: 260px;
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
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================
         EN-TÊTE
    ====================================================== -->
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="caisse-hero">
                <div class="caisse-hero-content">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-8">
                            <div class="caisse-hero-title">
                                <span class="caisse-hero-title-icon"><i class="fas fa-cash-register"></i></span>
                                Gestion des caisses
                            </div>
                            <p>
                                La caisse principale encaisse tous les fonds et approvisionne
                                <strong>la caisse secondaire (unique)</strong>, qui règle les demandes
                                d'achat de <strong>tous les chantiers</strong>. Chaque caisse dispose
                                de son propre livre de mouvements.
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

    <section class="content">
        <div class="container-fluid">

            <!-- =================================================
                 SCHÉMA DU FLUX DE TRÉSORERIE
            ================================================== -->
            <div class="caisse-card">
                <div class="caisse-card-body">
                    <div class="flux-steps">
                        <div class="flux-step">
                            <span class="flux-step-icon icon-green"><i class="fas fa-arrow-down"></i></span>
                            <h6>1 · Encaissements</h6>
                            <p>Tous les fonds (clients, banque, apports) entrent <strong>uniquement</strong> dans la
                                caisse principale.</p>
                        </div>
                        <div class="flux-arrow"><i class="fas fa-arrow-right"></i></div>
                        <div class="flux-step">
                            <span class="flux-step-icon icon-blue"><i class="fas fa-exchange-alt"></i></span>
                            <h6>2 · Approvisionnements</h6>
                            <p>La caisse principale alimente <strong>la caisse secondaire</strong>, selon les besoins.
                            </p>
                        </div>
                        <div class="flux-arrow"><i class="fas fa-arrow-right"></i></div>
                        <div class="flux-step">
                            <span class="flux-step-icon icon-red"><i class="fas fa-arrow-up"></i></span>
                            <h6>3 · Décaissements</h6>
                            <p>La caisse secondaire paie les demandes d'achat de <strong>tous les chantiers</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            /* -------------------------------------------------
 * Extraction sécurisée des statistiques
 * ------------------------------------------------- */
            $stats     = isset($cashboxStats) && is_array($cashboxStats) ? $cashboxStats : [];
            $principal = isset($principalCashbox) && is_object($principalCashbox) ? $principalCashbox : null;
            $secondary = isset($secondaryCashbox) && is_object($secondaryCashbox) ? $secondaryCashbox : null;

            $globalBalance   = isset($stats['global_balance']) ? (float) $stats['global_balance'] : 0;
            $globalVariation = isset($stats['global_variation_percentage']) ? (float) $stats['global_variation_percentage'] : 0;
            $pBalance        = isset($stats['principal_balance']) ? (float) $stats['principal_balance'] : 0;
            $pPercentage     = isset($stats['principal_percentage']) ? (float) $stats['principal_percentage'] : 0;
            $sBalance        = isset($stats['secondary_balance']) ? (float) $stats['secondary_balance'] : 0;
            $sPercentage     = isset($stats['secondary_percentage']) ? (float) $stats['secondary_percentage'] : 0;
            $sStatus         = isset($stats['secondary_status']) ? $stats['secondary_status'] : 'normal';
            $sThreshold      = isset($stats['secondary_threshold']) ? (float) $stats['secondary_threshold'] : 0;

            $pMonthEntries = isset($stats['month_entries']) ? (float) $stats['month_entries'] : 0;
            $pMonthAppro   = isset($stats['month_approvisionnements']) ? (float) $stats['month_approvisionnements'] : 0;
            $pTodayEntries = isset($stats['today_entries']) ? (float) $stats['today_entries'] : 0;
            $pMonthOps     = isset($stats['month_operations']) ? (int) $stats['month_operations'] : 0;

            $sMonthReceived  = isset($stats['month_received']) ? (float) $stats['month_received'] : 0;
            $sMonthPayments  = isset($stats['month_payments']) ? (float) $stats['month_payments'] : 0;
            $sMonthPaidCount = isset($stats['month_paid_count']) ? (int) $stats['month_paid_count'] : 0;
            $sTodayPayments  = isset($stats['today_payments']) ? (float) $stats['today_payments'] : 0;
            $sTodayPayCount  = isset($stats['today_payments_count']) ? (int) $stats['today_payments_count'] : 0;

            $devise = $principal ? $principal->devise : 'BIF';

            /* Badge de variation du solde global */
            $variationClass  = 'badge-neutral';
            $variationIcon   = 'fas fa-minus';
            $variationPrefix = '';
            if ($globalVariation > 0) {
                $variationClass  = 'badge-positive';
                $variationIcon   = 'fas fa-arrow-up';
                $variationPrefix = '+';
            } elseif ($globalVariation < 0) {
                $variationClass = 'badge-negative';
                $variationIcon  = 'fas fa-arrow-down';
            }

            /* Badge + couleur du solde secondaire */
            if ($sStatus === 'critique') {
                $sBadgeClass = 'badge-negative';
                $sBadgeLabel = 'Solde critique';
                $sColor      = '#b91c1c';
            } elseif ($sStatus === 'faible') {
                $sBadgeClass = 'badge-neutral';
                $sBadgeLabel = 'Solde faible';
                $sColor      = '#b45309';
            } else {
                $sBadgeClass = 'badge-positive';
                $sBadgeLabel = 'Disponible';
                $sColor      = '';
            }
            ?>

            <!-- =================================================
                STATISTIQUES PRINCIPALES
            ================================================== -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-green"><i class="fas fa-wallet"></i></div>
                            <span class="caisse-stat-badge <?= $variationClass ?>"
                                title="Évolution depuis le début du mois">
                                <i class="<?= $variationIcon ?> mr-1"></i>
                                <?= $variationPrefix ?><?= number_format(abs($globalVariation), 1, ',', ' ') ?> %
                            </span>
                        </div>
                        <div class="caisse-stat-label">Solde global disponible</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($globalBalance) ?>
                            <?= html_escape($devise) ?></div>
                        <div class="caisse-stat-footer">Caisse principale + caisse secondaire</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-purple"><i class="fas fa-crown"></i></div>
                            <span class="caisse-stat-badge badge-neutral">Unique — encaissements</span>
                        </div>
                        <div class="caisse-stat-label">Caisse principale</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($pBalance) ?> <?= html_escape($devise) ?>
                        </div>
                        <div class="caisse-stat-footer"><?= number_format($pPercentage, 1, ',', ' ') ?> % du solde
                            global</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-blue"><i class="fas fa-hard-hat"></i></div>
                            <span class="caisse-stat-badge <?= $sBadgeClass ?>"><?= $sBadgeLabel ?></span>
                        </div>
                        <div class="caisse-stat-label">Caisse secondaire</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($sBalance) ?> <?= html_escape($devise) ?>
                        </div>
                        <div class="caisse-stat-footer">
                            <?= number_format($sPercentage, 1, ',', ' ') ?> % du solde global
                            <?php if ($sThreshold > 0): ?> — seuil
                            <?= formatCashboxAmount($sThreshold) ?><?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="caisse-stat-card">
                        <div class="caisse-stat-top">
                            <div class="caisse-stat-icon icon-red"><i class="fas fa-arrow-up"></i></div>
                            <span
                                class="caisse-stat-badge <?= $sTodayPayCount > 0 ? 'badge-negative' : 'badge-neutral' ?>">
                                <?= $sTodayPayCount ?> opération<?= $sTodayPayCount > 1 ? 's' : '' ?>
                            </span>
                        </div>
                        <div class="caisse-stat-label">Décaissements du jour</div>
                        <div class="caisse-stat-value"><?= formatCashboxAmount($sTodayPayments) ?>
                            <?= html_escape($devise) ?></div>
                        <div class="caisse-stat-footer">
                            <?php if ($sTodayPayCount > 0): ?> Paiement DA validé aujourd'hui
                            <?php else: ?> Aucun paiement DA aujourd'hui <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =================================================
                CAISSE PRINCIPALE (UNIQUE)
            ================================================== -->
            <div class="principal-box" data-role-caisse="principale">
                <div class="principal-box-head">
                    <div class="principal-box-name">
                        <div class="principal-box-icon"><i class="fas fa-crown"></i></div>
                        <div>
                            <h5><?= html_escape($principal ? $principal->name : 'Caisse Principale') ?></h5>
                            <small>
                                <?= html_escape($principal ? $principal->code : '—') ?>
                                · Responsable :
                                <?= html_escape($principal && !empty($principal->responsable) ? $principal->responsable : '—') ?>
                            </small>
                        </div>
                    </div>
                    <span class="role-badge role-principale"><i class="fas fa-crown mr-1"></i> Principale —
                        unique</span>
                </div>
                <div class="principal-box-balance">
                    <span>Solde disponible</span>
                    <strong><?= formatCashboxAmount($pBalance) ?> <?= html_escape($devise) ?></strong>
                </div>
                <div class="principal-box-stats">
                    <div class="principal-stat"><span>Entrées du mois</span><strong class="amount-in">+
                            <?= formatCashboxAmount($pMonthEntries) ?></strong></div>
                    <div class="principal-stat"><span>Approvisionnements du mois</span><strong class="amount-out">-
                            <?= formatCashboxAmount($pMonthAppro) ?></strong></div>
                    <div class="principal-stat"><span>Encaissements
                            aujourd'hui</span><strong><?= formatCashboxAmount($pTodayEntries) ?></strong></div>
                    <div class="principal-stat"><span>Opérations du mois</span><strong><?= $pMonthOps ?></strong></div>
                </div>
                <div class="p-3 d-flex flex-wrap" style="border-top: 1px solid #ece6fb;">
                    <button type="button" class="btn btn-caisse-primary mr-2 mb-2" data-toggle="modal"
                        data-target="#addOperationModal" onclick="prepareOperation('approvisionnement')">
                        <i class="fas fa-exchange-alt mr-1"></i> Approvisionner la caisse secondaire
                    </button>
                    <button type="button" class="btn btn-caisse-outline mr-2 mb-2" data-toggle="modal"
                        data-target="#addOperationModal" onclick="prepareOperation('encaissement')">
                        <i class="fas fa-arrow-down mr-1"></i> Encaisser
                    </button>
                    <?php if ($principal): ?>
                    <a href="<?= base_url('finance-cashbox/' . (int) $principal->id) ?>"
                        class="btn btn-caisse-outline mb-2">
                        <i class="fas fa-book mr-1"></i> Livre de la caisse principale
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- =================================================
                CAISSE SECONDAIRE (UNIQUE)
            ================================================== -->
            <div class="principal-box secondary-box" data-role-caisse="secondaire">
                <div class="principal-box-head">
                    <div class="principal-box-name">
                        <div class="principal-box-icon"><i class="fas fa-hard-hat"></i></div>
                        <div>
                            <h5><?= html_escape($secondary ? $secondary->name : 'Caisse Secondaire') ?></h5>
                            <small>
                                <?= html_escape($secondary ? $secondary->code : '—') ?>
                                · Responsable :
                                <?= html_escape($secondary && !empty($secondary->responsable) ? $secondary->responsable : '—') ?>
                            </small>
                        </div>
                    </div>
                    <span class="role-badge role-secondaire"><i class="fas fa-hard-hat mr-1"></i> Secondaire —
                        unique</span>
                </div>
                <div class="principal-box-balance">
                    <span>Solde disponible</span>
                    <strong <?= $sColor !== '' ? 'style="color:' . $sColor . ';"' : '' ?>>
                        <?= formatCashboxAmount($sBalance) ?> <?= html_escape($devise) ?>
                    </strong>
                </div>
                <div class="principal-box-stats">
                    <div class="principal-stat"><span>Approvisionnements reçus (mois)</span><strong class="amount-in">+
                            <?= formatCashboxAmount($sMonthReceived) ?></strong></div>
                    <div class="principal-stat"><span>Paiements DA (mois)</span><strong class="amount-out">-
                            <?= formatCashboxAmount($sMonthPayments) ?></strong></div>
                    <div class="principal-stat"><span>DA payées (mois)</span><strong><?= $sMonthPaidCount ?></strong>
                    </div>
                    <div class="principal-stat"><span>Chantiers couverts</span><strong>Tous</strong></div>
                </div>
                <div class="p-3 d-flex flex-wrap" style="border-top: 1px solid #e3f2fd;">
                    <button type="button" class="btn btn-caisse-primary mr-2 mb-2" data-toggle="modal"
                        data-target="#addOperationModal" onclick="prepareOperation('decaissement')">
                        <i class="fas fa-arrow-up mr-1"></i> Payer une demande d'achat
                    </button>
                    <button type="button" class="btn btn-caisse-outline mr-2 mb-2" data-toggle="modal"
                        data-target="#addOperationModal" onclick="prepareOperation('approvisionnement')">
                        <i class="fas fa-exchange-alt mr-1"></i> Demander un approvisionnement
                    </button>
                    <?php if ($secondary): ?>
                    <a href="<?= base_url('finance-cashbox/' . (int) $secondary->id) ?>"
                        class="btn btn-caisse-outline mb-2">
                        <i class="fas fa-book mr-1"></i> Livre de la caisse secondaire
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- =================================================
                ACTIONS RAPIDES
            ================================================== -->
            <div class="caisse-card">
                <div class="caisse-card-header">
                    <div>
                        <h5 class="caisse-card-title"><i class="fas fa-bolt"></i> Actions rapides</h5>
                        <span class="caisse-card-subtitle">Opérations conformes au flux principale → secondaire.</span>
                    </div>
                </div>
                <div class="caisse-card-body pb-2">
                    <div class="row">
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <button type="button" class="quick-action" data-toggle="modal"
                                data-target="#addOperationModal" onclick="prepareOperation('encaissement')">
                                <span class="quick-action-icon icon-green"><i class="fas fa-arrow-down"></i></span>
                                <span class="quick-action-content">
                                    <span class="quick-action-title">Encaissement</span>
                                    <span class="quick-action-text">Entrée de fonds dans la caisse principale</span>
                                </span>
                            </button>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <button type="button" class="quick-action" data-toggle="modal"
                                data-target="#addOperationModal" onclick="prepareOperation('approvisionnement')">
                                <span class="quick-action-icon icon-blue"><i class="fas fa-exchange-alt"></i></span>
                                <span class="quick-action-content">
                                    <span class="quick-action-title">Approvisionner</span>
                                    <span class="quick-action-text">Caisse principale → caisse secondaire</span>
                                </span>
                            </button>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <button type="button" class="quick-action" data-toggle="modal"
                                data-target="#addOperationModal" onclick="prepareOperation('decaissement')">
                                <span class="quick-action-icon icon-red"><i class="fas fa-arrow-up"></i></span>
                                <span class="quick-action-content">
                                    <span class="quick-action-title">Payer une DA</span>
                                    <span class="quick-action-text">Dépense via la caisse secondaire</span>
                                </span>
                            </button>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <button type="button" class="quick-action" data-toggle="modal"
                                data-target="#addCaisseModal">
                                <span class="quick-action-icon icon-green"><i class="fas fa-plus"></i></span>
                                <span class="quick-action-content">
                                    <span class="quick-action-title">Nouvelle caisse</span>
                                    <span class="quick-action-text">Principale ou secondaire (unicité contrôlée)</span>
                                </span>
                            </button>
                        </div>


                        <?php
                        /* IDs des deux caisses uniques (pour les livres) */
                        $principalId = !empty($principalCashbox) ? (int) $principalCashbox->id : 0;
                        $secondaryId = !empty($secondaryCashbox) ? (int) $secondaryCashbox->id : 0;
                        ?>
                        <!-- =================================================
                            LIVRE DE CAISSE — CAISSE PRINCIPALE
                        ================================================== -->
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <a href="<?= $principalId > 0 ? base_url('finance-cashbox/' . $principalId) : '#' ?>"
                                class="quick-action"
                                <?= $principalId > 0 ? '' : 'title="Aucune caisse principale créée"' ?>>
                                <span class="quick-action-icon icon-orange"><i class="fas fa-crown"></i></span>
                                <span class="quick-action-content">
                                    <span class="quick-action-title">Livre caisse principale</span>
                                    <span class="quick-action-text">
                                        Entrées / sorties de la caisse principale
                                    </span>
                                </span>
                            </a>
                        </div>
                        <!-- =================================================
                            LIVRE DE CAISSE — CAISSE SECONDAIRE
                        ================================================== -->
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <a href="<?= $secondaryId > 0 ? base_url('finance-cashbox/' . $secondaryId) : '#' ?>"
                                class="quick-action"
                                <?= $secondaryId > 0 ? '' : 'title="Aucune caisse secondaire créée"' ?>>
                                <span class="quick-action-icon icon-purple"><i class="fas fa-hard-hat"></i></span>
                                <span class="quick-action-content">
                                    <span class="quick-action-title">Livre caisse secondaire</span>
                                    <span class="quick-action-text">
                                        Entrées / sorties de la caisse secondaire
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            /* Valeurs par défaut (sécurité) */
            $evolution = isset($cashFlowEvolution) && is_array($cashFlowEvolution)
                ? $cashFlowEvolution
                : [
                    'labels' => [],
                    'incomes' => [],
                    'expenses' => [],
                    'total_income' => 0,
                    'total_expense' => 0,
                    'net' => 0
                ];
            $alerts      = isset($treasuryAlerts) && is_array($treasuryAlerts) ? $treasuryAlerts : [];
            $alertsCount = isset($treasuryAlertsCount) ? (int) $treasuryAlertsCount : 0;
            $period      = isset($cashFlowPeriod) ? $cashFlowPeriod : '7days';
            ?>
            <!-- =================================================
                GRAPHIQUE + ALERTES (DYNAMIQUES)
            ================================================== -->
            <div class="row">
                <!-- ÉVOLUTION DE LA TRÉSORERIE -->
                <div class="col-xl-8 col-lg-8">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-chart-line"></i> Évolution de la
                                    trésorerie</h5>
                                <span class="caisse-card-subtitle">Encaissements (principale) vs décaissements
                                    (secondaire).</span>
                            </div>
                            <form action="<?= current_url() ?>" method="get" id="cashFlowPeriodForm">
                                <select name="cashflow_period" id="cashFlowPeriod" class="form-control form-control-sm"
                                    style="width: 165px; border-radius: 8px;"
                                    onchange="document.getElementById('cashFlowPeriodForm').submit();">
                                    <option value="7days" <?= $period === '7days' ? 'selected' : '' ?>>7 derniers jours
                                    </option>
                                    <option value="30days" <?= $period === '30days' ? 'selected' : '' ?>>30 derniers
                                        jours</option>
                                    <option value="month" <?= $period === 'month' ? 'selected' : '' ?>>Ce mois</option>
                                </select>
                            </form>
                        </div>
                        <div class="caisse-card-body">
                            <div class="cashflow-summary">
                                <div class="cashflow-summary-item">
                                    <span>Encaissements</span>
                                    <strong class="text-success">+
                                        <?= formatCashboxAmount($evolution['total_income']) ?> BIF</strong>
                                </div>
                                <div class="cashflow-summary-item">
                                    <span>Décaissements</span>
                                    <strong class="text-danger">-
                                        <?= formatCashboxAmount($evolution['total_expense']) ?> BIF</strong>
                                </div>
                                <div class="cashflow-summary-item">
                                    <span>Flux net</span>
                                    <strong class="<?= $evolution['net'] >= 0 ? 'text-success' : 'text-danger' ?>">
                                        <?= $evolution['net'] >= 0 ? '+ ' : '- ' ?><?= formatCashboxAmount(abs($evolution['net'])) ?>
                                        BIF
                                    </strong>
                                </div>
                            </div>
                            <div class="cashflow-chart-wrapper"><canvas id="cashFlowChart"></canvas></div>
                        </div>
                    </div>
                </div>

                <!-- ALERTES -->
                <div class="col-xl-4 col-lg-4">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-exclamation-triangle"></i> Alertes</h5>
                                <span class="caisse-card-subtitle">Situations nécessitant une intervention.</span>
                            </div>
                            <?php if ($alertsCount > 0): ?>
                            <span class="badge badge-danger"><?= $alertsCount ?>
                                alerte<?= $alertsCount > 1 ? 's' : '' ?></span>
                            <?php else: ?>
                            <span class="badge badge-success">Aucune alerte</span>
                            <?php endif; ?>
                        </div>
                        <div class="caisse-card-body">
                            <?php if (!empty($alerts)): ?>
                            <?php foreach ($alerts as $alert): ?>
                            <?php
                                    $alertClass = 'alert-info-soft';
                                    if ($alert['type'] === 'danger') {
                                        $alertClass = 'alert-danger-soft';
                                    } elseif ($alert['type'] === 'warning') {
                                        $alertClass = 'alert-warning-soft';
                                    }
                                    ?>
                            <div class="treasury-alert <?= $alertClass ?>">
                                <div class="treasury-alert-icon"><i class="<?= html_escape($alert['icon']) ?>"></i>
                                </div>
                                <div>
                                    <h6><?= html_escape($alert['title']) ?></h6>
                                    <p><?= html_escape($alert['message']) ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <div class="mb-3" style="color:#16a34a; font-size:40px;"><i
                                        class="fas fa-check-circle"></i></div>
                                <h6 style="color:#102033; font-weight:800;">Trésorerie sous contrôle</h6>
                                <p class="text-muted mb-0" style="font-size:10px;">
                                    Aucun solde critique ni paiement en attente.
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $recentMovements   = isset($recentMovements) && is_array($recentMovements) ? $recentMovements : [];
            $allMovementsCount = isset($allMovementsCount) ? (int) $allMovementsCount : 0;
            ?>
            <!-- =================================================
                MOUVEMENTS RÉCENTS (DYNAMIQUES)
            ================================================== -->
            <div class="caisse-card">
                <div class="caisse-card-header">
                    <div>
                        <h5 class="caisse-card-title"><i class="fas fa-exchange-alt"></i> Mouvements récents</h5>
                        <span class="caisse-card-subtitle">Encaissements (principale), approvisionnements et paiements
                            DA (secondaire).</span>
                    </div>
                    <a href="<?= base_url('finance/journal-caisse') ?>" class="btn btn-caisse-outline">
                        <i class="fas fa-list mr-1"></i> Voir tout le journal
                    </a>
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
                            <?php if (!empty($recentMovements)): ?>
                            <?php foreach ($recentMovements as $index => $movement): ?>
                            <?php
                                    /* Type d'opération */
                                    $typeLabel = 'Opération';
                                    $typeClass = 'badge-transfert';
                                    $typeIcon  = 'fas fa-exchange-alt';
                                    if ($movement['type'] === 'entree') {
                                        $typeLabel = 'Entrée';
                                        $typeClass = 'badge-entree';
                                        $typeIcon  = 'fas fa-arrow-down';
                                    } elseif ($movement['type'] === 'sortie') {
                                        $typeLabel = 'Sortie';
                                        $typeClass = 'badge-sortie';
                                        $typeIcon  = 'fas fa-arrow-up';
                                    }

                                    /* Statut */
                                    $statusLabel = 'Validé';
                                    $statusClass = 'badge-success';
                                    if ($movement['status'] === 'pending') {
                                        $statusLabel = 'En attente';
                                        $statusClass = 'badge-warning';
                                    } elseif ($movement['status'] === 'cancelled') {
                                        $statusLabel = 'Annulé';
                                        $statusClass = 'badge-danger';
                                    }
                                    ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <?= formatCashboxDate($movement['movement_date']) ?>
                                    <small
                                        class="d-block text-muted"><?= formatCashboxTime($movement['created_at']) ?></small>
                                </td>
                                <td><span class="operation-reference"><?= html_escape($movement['reference']) ?></span>
                                </td>
                                <td>
                                    <strong><?= html_escape($movement['cashbox_name']) ?></strong>
                                    <small
                                        class="d-block text-muted"><?= html_escape($movement['cashbox_code']) ?></small>
                                </td>
                                <td>
                                    <span class="badge-operation <?= $typeClass ?>">
                                        <i class="<?= $typeIcon ?> mr-1"></i> <?= $typeLabel ?>
                                    </span>
                                </td>
                                <td class="operation-label">
                                    <strong title="<?= html_escape($movement['label']) ?>">
                                        <?= html_escape($movement['label']) ?>
                                    </strong>
                                    <?php if ($movement['secondary_label'] !== ''): ?>
                                    <small><?= html_escape($movement['secondary_label']) ?></small>
                                    <?php elseif (!empty($movement['category'])): ?>
                                    <small>Catégorie : <?= html_escape($movement['category']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td
                                    class="text-right <?= $movement['entry_amount'] !== null ? 'amount-in' : 'text-muted' ?>">
                                    <?php if ($movement['entry_amount'] !== null): ?>
                                    + <?= formatCashboxAmount($movement['entry_amount']) ?>
                                    <?php else: ?>
                                    —
                                    <?php endif; ?>
                                </td>
                                <td
                                    class="text-right <?= $movement['output_amount'] !== null ? 'amount-out' : 'text-muted' ?>">
                                    <?php if ($movement['output_amount'] !== null): ?>
                                    - <?= formatCashboxAmount($movement['output_amount']) ?>
                                    <?php else: ?>
                                    —
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <strong><?= formatCashboxAmount($movement['balance_after']) ?></strong>
                                    <small class="d-block text-muted"><?= html_escape($movement['currency']) ?></small>
                                </td>
                                <td><span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                                <td class="text-center">
                                    <button class="btn-table-action btn-table-view" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn-table-action btn-table-print" title="Imprimer"><i
                                            class="fas fa-print"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <div class="mb-3" style="color:#cbd5e1; font-size:42px;">
                                        <i class="fas fa-exchange-alt"></i>
                                    </div>
                                    <h6 style="color:#334155; font-weight:800;">Aucun mouvement enregistré</h6>
                                    <p class="text-muted mb-3">
                                        Les encaissements, approvisionnements et paiements DA apparaîtront ici.
                                    </p>
                                    <button type="button" class="btn btn-caisse-primary" data-toggle="modal"
                                        data-target="#addOperationModal" onclick="prepareOperation('encaissement')">
                                        <i class="fas fa-plus mr-1"></i> Enregistrer une opération
                                    </button>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap">
                    <small class="text-muted">
                        Affichage de <?= !empty($recentMovements) ? 1 : 0 ?> à <?= count($recentMovements) ?>
                        sur <?= $allMovementsCount ?> opération<?= $allMovementsCount > 1 ? 's' : '' ?>
                    </small>
                    <a href="<?= base_url('finance/journal-caisse') ?>" class="btn btn-caisse-outline btn-sm">
                        Voir les <?= $allMovementsCount ?> opérations <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <?php
            /* -------------------------------------------------
 * Extraction sécurisée
 * ------------------------------------------------- */
            $categoryExpenses  = isset($secondaryExpensesByCategory) && is_array($secondaryExpensesByCategory)
                ? $secondaryExpensesByCategory : [];
            $chantierConsumption = isset($secondaryConsumptionByChantier) && is_array($secondaryConsumptionByChantier)
                ? $secondaryConsumptionByChantier : [];

            /* Couleurs des barres (cycle) */
            $barClasses = ['', 'bar-orange', 'bar-red', 'bar-blue'];

            /* Icône selon la catégorie */
            if (!function_exists('expenseCategoryIcon')) {
                function expenseCategoryIcon($name)
                {
                    $n = mb_strtolower($name, 'UTF-8');
                    if (strpos($n, 'carburant') !== false)                       return 'fas fa-gas-pump';
                    if (
                        strpos($n, 'main-d') !== false || strpos($n, 'œuvre') !== false
                        || strpos($n, 'salaire') !== false || strpos($n, 'personnel') !== false
                    )
                        return 'fas fa-users';
                    if (
                        strpos($n, 'fourniture') !== false || strpos($n, 'matériau') !== false
                        || strpos($n, 'materiau') !== false
                    )                     return 'fas fa-tools';
                    if (strpos($n, 'transport') !== false)                       return 'fas fa-truck';
                    if (strpos($n, 'sous-trait') !== false)                      return 'fas fa-user-tie';
                    if (strpos($n, 'maintenance') !== false)                     return 'fas fa-truck-monster';
                    if (strpos($n, 'électricité') !== false || strpos($n, 'electricite') !== false)
                        return 'fas fa-bolt';
                    if (strpos($n, 'loyer') !== false)                           return 'fas fa-building';
                    if (strpos($n, 'taxe') !== false || strpos($n, 'impôt') !== false)
                        return 'fas fa-landmark';
                    return 'fas fa-receipt';
                }
            }
            ?>
            <!-- =================================================
     DÉPENSES PAR CATÉGORIE + CONSOMMATION PAR CHANTIER
================================================== -->
            <div class="row">
                <!-- DÉPENSES DE LA SECONDAIRE (MOIS) -->
                <div class="col-xl-5 col-lg-5">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-chart-bar"></i> Dépenses de la secondaire
                                    (mois)</h5>
                                <span class="caisse-card-subtitle">Répartition des paiements DA par catégorie.</span>
                            </div>
                            <?php if (!empty($categoryExpenses)): ?>
                            <span class="badge badge-light">
                                <?= count($categoryExpenses) ?> catégorie<?= count($categoryExpenses) > 1 ? 's' : '' ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="caisse-card-body">
                            <?php if (!empty($categoryExpenses)): ?>
                            <?php foreach ($categoryExpenses as $index => $expense): ?>
                            <?php
                                    $barClass = isset($barClasses[$index % 4]) ? $barClasses[$index % 4] : '';
                                    $width = max(0, min(100, (float) $expense->percentage));
                                    if ($expense->total_amount > 0 && $width < 4) {
                                        $width = 4;
                                    }
                                    ?>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title">
                                        <i class="<?= html_escape(expenseCategoryIcon($expense->category_name)) ?>"></i>
                                        <?= html_escape($expense->category_name) ?>
                                        <small class="text-muted ml-1">(<?= $expense->total_operations ?>)</small>
                                    </span>
                                    <span class="expense-item-value">
                                        <?= formatCashboxAmount($expense->total_amount) ?> BIF
                                    </span>
                                </div>
                                <div class="expense-progress">
                                    <span class="<?= $barClass ?>"
                                        style="width: <?= number_format($width, 2, '.', '') ?>%;"></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <div class="mb-3" style="color:#cbd5e1; font-size:40px;"><i
                                        class="fas fa-chart-bar"></i></div>
                                <h6 style="color:#334155; font-weight:800;">Aucune dépense ce mois</h6>
                                <p class="text-muted mb-0">
                                    Les paiements DA validés de la caisse secondaire
                                    apparaîtront automatiquement ici.
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- CONSOMMATION PAR CHANTIER -->
                <div class="col-xl-7 col-lg-7">
                    <div class="caisse-card">
                        <div class="caisse-card-header">
                            <div>
                                <h5 class="caisse-card-title"><i class="fas fa-project-diagram"></i> Consommation par
                                    chantier</h5>
                                <span class="caisse-card-subtitle">DA payées par la caisse secondaire, par
                                    chantier.</span>
                            </div>
                            <?php if (!empty($chantierConsumption)): ?>
                            <span class="badge badge-success">
                                <?= count($chantierConsumption) ?>
                                chantier<?= count($chantierConsumption) > 1 ? 's' : '' ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="caisse-card-body">
                            <?php if (!empty($chantierConsumption)): ?>
                            <?php foreach ($chantierConsumption as $index => $chantier): ?>
                            <?php
                                    $barClass = isset($barClasses[$index % 4]) ? $barClasses[$index % 4] : '';
                                    $width = max(0, min(100, (float) $chantier->percentage));
                                    if ($chantier->total_consumed > 0 && $width < 4) {
                                        $width = 4;
                                    }
                                    ?>
                            <div class="expense-item">
                                <div class="expense-item-header">
                                    <span class="expense-item-title">
                                        <i class="fas fa-hard-hat"></i>
                                        <?= html_escape($chantier->display_name) ?>
                                        <small class="text-muted ml-1">(<?= $chantier->da_count ?> DA)</small>
                                    </span>
                                    <span class="expense-item-value">
                                        <?= formatCashboxAmount($chantier->total_consumed) ?> BIF
                                    </span>
                                </div>
                                <div class="expense-progress">
                                    <span class="<?= $barClass ?>"
                                        style="width: <?= number_format($width, 2, '.', '') ?>%;"></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <div class="mb-3" style="color:#cbd5e1; font-size:40px;"><i
                                        class="fas fa-project-diagram"></i></div>
                                <h6 style="color:#334155; font-weight:800;">Aucune consommation ce mois</h6>
                                <p class="text-muted mb-0">
                                    Les chantiers des demandes d'achat payées
                                    apparaîtront automatiquement ici.
                                </p>
                            </div>
                            <?php endif; ?>
                            <div class="livre-note"
                                style="margin-top: 18px; padding: 13px 16px; border: 1px dashed #cbd5e1; border-radius: 10px; background: #f8fafc; color: #64748b; font-size: 10px;">
                                <strong style="color:#102033;">Rappel :</strong> la caisse secondaire est unique et
                                couvre
                                tous les chantiers — la consommation par chantier est calculée depuis les demandes
                                d'achat payées.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- =========================================================
MODALE : CRÉER UNE CAISSE (PRINCIPALE OU SECONDAIRE)
========================================================== -->
<div class="modal fade modal-caisse" id="addCaisseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="<?= base_url('finance-caisse-store') ?>" method="post" id="addCaisseForm" style="width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-wallet mr-2"></i> Créer une nouvelle caisse</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Code caisse <span class="required-star">*</span></label>
                                <input type="text" class="form-control"
                                    value="<?= html_escape(isset($nextCashboxCode) ? $nextCashboxCode : '') ?>"
                                    readonly>
                                <small class="text-muted">Généré automatiquement lors de l'enregistrement.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Intitulé de la caisse <span class="required-star">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Ex. Caisse Principale / Caisse Secondaire" maxlength="150" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rôle de la caisse <span class="required-star">*</span></label>
                                <select name="role" id="caisseRole" class="form-control" required>
                                    <option value="">Sélectionner</option>
                                    <option value="principale" <?= !empty($hasPrincipale) ? 'disabled' : '' ?>>
                                        Principale — encaisse tous les fonds (unique)
                                    </option>
                                    <option value="secondaire" <?= !empty($hasSecondaire) ? 'disabled' : '' ?>>
                                        Secondaire — paie les DA de tous les chantiers (unique)
                                    </option>
                                </select>
                                <small class="text-muted">
                                    <?php if (!empty($hasPrincipale) && !empty($hasSecondaire)): ?>
                                    Les deux caisses existent déjà (unicité).
                                    <?php elseif (empty($hasPrincipale)): ?>
                                    Commencez par créer la caisse principale.
                                    <?php else: ?>
                                    Créez maintenant la caisse secondaire.
                                    <?php endif; ?>
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable de caisse</label>
                                <input type="text" name="responsable" class="form-control"
                                    placeholder="Nom du caissier responsable" maxlength="150">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Devise <span class="required-star">*</span></label>
                                <select name="devise" class="form-control" required>
                                    <option selected>BIF</option>
                                    <option>USD</option>
                                    <option>EUR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Solde initial</label>
                                <input type="number" name="opening_balance" class="form-control" value="0" min="0"
                                    step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Seuil d'alerte</label>
                                <input type="number" name="alert_threshold" class="form-control" value="0" min="0"
                                    step="0.01" placeholder="Ex. 5 000 000" required>
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
                    <button type="button" class="btn btn-caisse-outline" data-dismiss="modal"><i
                            class="fas fa-times mr-1"></i> Annuler</button>
                    <button type="submit" class="btn btn-caisse-primary"><i class="fas fa-save mr-1"></i> Enregistrer la
                        caisse</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
MODALE : NOUVELLE OPÉRATION (RÔLES VERROUILLÉS)
========================================================== -->
<div class="modal fade modal-caisse" id="addOperationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="<?= base_url('finance-cashbox-operation-store') ?>" method="post" enctype="multipart/form-data"
            id="cashboxOperationForm" style="width: 100%;">
            <input type="hidden" name="operation_type" id="operationType">
            <input type="hidden" name="payment_voucher_id" id="paymentVoucherId">
            <input type="hidden" name="purchase_request_reference" id="purchaseRequestReference">
            <input type="hidden" name="payment_voucher_reference" id="paymentVoucherReference">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exchange-alt mr-2"></i> <span
                            id="operationModalTitle">Nouvelle opération de caisse</span></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date de l'opération <span class="required-star">*</span></label>
                                <input type="date" name="operation_date" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label id="operationCashboxLabel">Caisse concernée <span
                                        class="required-star">*</span></label>
                                <select name="cashbox_id" id="operationCashboxId" class="form-control" required>
                                    <option value="">Sélectionner la caisse</option>
                                    <?php if (!empty($allCashboxes)): ?>
                                    <?php foreach ($allCashboxes as $cashboxOption): ?>
                                    <option value="<?= (int) $cashboxOption->id ?>"
                                        data-role="<?= html_escape($cashboxOption->role) ?>"
                                        data-currency="<?= html_escape($cashboxOption->devise) ?>"
                                        data-balance="<?= (float) $cashboxOption->current_balance ?>">
                                        <?= html_escape($cashboxOption->code) ?> —
                                        <?= html_escape($cashboxOption->name) ?> —
                                        <?= number_format((float) $cashboxOption->current_balance, 0, ',', ' ') ?>
                                        <?= html_escape($cashboxOption->devise) ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div id="selectedCashboxBalance" class="cashbox-selected-balance"
                                    style="display: none;">
                                    <small>Solde disponible</small>
                                    <strong id="selectedCashboxBalanceValue">0 BIF</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" id="destinationCashboxField" style="display: none;">
                            <div class="form-group">
                                <label>Caisse destination (secondaire) <span class="required-star">*</span></label>
                                <select name="destination_cashbox_id" id="destinationCashboxId" class="form-control"
                                    disabled>
                                    <option value="">Sélectionner la destination</option>
                                    <?php if (!empty($allCashboxes)): ?>
                                    <?php foreach ($allCashboxes as $cashboxOption): ?>
                                    <?php if ($cashboxOption->role === 'secondaire'): ?>
                                    <option value="<?= (int) $cashboxOption->id ?>" data-role="secondaire"
                                        data-currency="<?= html_escape($cashboxOption->devise) ?>"
                                        data-balance="<?= (float) $cashboxOption->current_balance ?>">
                                        <?= html_escape($cashboxOption->code) ?> —
                                        <?= html_escape($cashboxOption->name) ?> —
                                        <?= number_format((float) $cashboxOption->current_balance, 0, ',', ' ') ?>
                                        <?= html_escape($cashboxOption->devise) ?>
                                    </option>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="purchaseRequestField" style="display: none;">
                            <div class="form-group">
                                <label>Demande d'achat <span class="required-star">*</span></label>
                                <select name="purchase_request_id" id="purchaseRequestId" class="form-control" disabled>
                                    <option value="">Sélectionner la demande</option>
                                    <?php if (!empty($payablePurchaseRequests)): ?>
                                    <?php foreach ($payablePurchaseRequests as $request): ?>
                                    <?php
                                            /* Référence lisible : DA-AAAA-XXXX (id) */
                                            $requestYear = date(
                                                'Y',
                                                strtotime(!empty($request->request_date) ? $request->request_date : $request->created_at)
                                            );
                                            $requestReference = 'DA-' . $requestYear . '-' . str_pad((int) $request->id, 4, '0', STR_PAD_LEFT);

                                            $chantierName = !empty($request->chantier_name)
                                                ? $request->chantier_name
                                                : (!empty($request->destination_chantier) ? $request->destination_chantier : 'Non affecté');

                                            $expenseSummary = !empty($request->summary)
                                                ? $request->summary
                                                : 'Décaissement lié à la demande d’achat';
                                            ?>
                                    <option value="<?= (int) $request->id ?>"
                                        data-payment-voucher-id="<?= (int) $request->voucher_id ?>"
                                        data-request-reference="<?= html_escape($requestReference) ?>"
                                        data-voucher-reference="<?= html_escape($request->payment_number) ?>"
                                        data-amount="<?= (float) $request->amount_paid ?>"
                                        data-summary="<?= html_escape($expenseSummary) ?>"
                                        data-chantier="<?= html_escape($chantierName) ?>"
                                        data-payment-mode="<?= html_escape($request->payment_mode) ?>"
                                        data-payment-date="<?= html_escape($request->payment_date) ?>"
                                        data-observation="<?= html_escape($request->payment_observation) ?>">
                                        <?= html_escape($requestReference) ?> —
                                        <?= html_escape($request->payment_number) ?> —
                                        <?= html_escape($chantierName) ?> —
                                        <?= number_format((float) $request->amount_paid, 0, ',', ' ') ?> BIF
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <small class="text-muted">
                                    Seules les DA attachées à un bon de paiement
                                    et non encore payées sont affichées.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Montant <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="amount" id="operationAmount" class="form-control"
                                        min="0.01" step="0.01" placeholder="0" required>
                                    <div class="input-group-append"><span class="input-group-text"
                                            id="operationCurrencyLabel">BIF</span></div>
                                </div>
                                <small class="text-danger" id="amountError" style="display: none;">Le montant dépasse le
                                    solde disponible.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Catégorie</label>
                                <select name="category" id="operationCategory" class="form-control">
                                    <option value="">Sélectionner</option>
                                    <option>Approvisionnement</option>
                                    <option>Paiement demande achat</option>
                                    <option>Carburant</option>
                                    <option>Main-d'œuvre</option>
                                    <option>Fournitures</option>
                                    <option>Transport</option>
                                    <option>Autre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bénéficiaire / Provenance</label>
                                <input type="text" name="third_party" id="operationThirdParty" class="form-control"
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
                        <div class="col-md-12" id="expenseJustificationField" style="display: none;">
                            <div class="form-group">
                                <label>Justification de la dépense <span class="required-star">*</span></label>
                                <textarea name="expense_justification" id="expenseJustification" class="form-control"
                                    rows="3" readonly disabled></textarea>
                                <small class="text-muted">Provenant automatiquement du bon de paiement / de la
                                    DA.</small>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="form-group mb-0">
                                <label>Observation</label>
                                <textarea name="observation" class="form-control" rows="3"
                                    placeholder="Informations complémentaires..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-caisse-outline" data-dismiss="modal"><i
                            class="fas fa-times mr-1"></i> Annuler</button>
                    <button type="submit" class="btn btn-caisse-primary" id="submitCashboxOperation"><i
                            class="fas fa-check-circle mr-1"></i> Enregistrer l'opération</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
SCRIPTS : RÔLES + OPÉRATIONS + CRÉATION
========================================================== -->
<script>
/* =====================================================
 * FILTRAGE DES CAISSES PAR RÔLE
 * ===================================================== */
function applyRoleFilter(select, allowedRoles) {
    if (!select) {
        return;
    }
    Array.prototype.forEach.call(select.options, function(opt) {
        if (!opt.value) {
            return;
        }
        var role = opt.getAttribute('data-role') || 'secondaire';
        var allowed = allowedRoles.indexOf(role) !== -1;
        opt.disabled = !allowed;
        opt.style.display = allowed ? '' : 'none';
    });
    var current = select.options[select.selectedIndex];
    if (current && current.value && current.disabled) {
        select.value = '';
    }
}

function autoSelectSingleAllowed(select) {
    if (!select) {
        return;
    }
    var enabled = Array.prototype.filter.call(select.options, function(o) {
        return o.value && !o.disabled;
    });
    if (enabled.length === 1) {
        select.value = enabled[0].value;
        select.dispatchEvent(new Event('change'));
    }
}

/* =====================================================
 * PRÉPARER L'OPÉRATION SELON LE TYPE (RÔLES VERROUILLÉS)
 * ===================================================== */
function prepareOperation(type) {
    var operationType = document.getElementById('operationType');
    var modalTitle = document.getElementById('operationModalTitle');
    var cashboxLabel = document.getElementById('operationCashboxLabel');
    var cashboxSelect = document.getElementById('operationCashboxId');
    var destinationField = document.getElementById('destinationCashboxField');
    var destinationSelect = document.getElementById('destinationCashboxId');
    var purchaseRequestField = document.getElementById('purchaseRequestField');
    var purchaseRequestSelect = document.getElementById('purchaseRequestId');
    var justificationField = document.getElementById('expenseJustificationField');
    var justificationInput = document.getElementById('expenseJustification');
    var categorySelect = document.getElementById('operationCategory');
    var amountInput = document.getElementById('operationAmount');

    /* Réinitialisation */
    operationType.value = type;
    destinationField.style.display = 'none';
    destinationSelect.disabled = true;
    destinationSelect.required = false;
    destinationSelect.value = '';
    purchaseRequestField.style.display = 'none';
    purchaseRequestSelect.disabled = true;
    purchaseRequestSelect.required = false;
    purchaseRequestSelect.value = '';
    justificationField.style.display = 'none';
    justificationInput.disabled = true;
    justificationInput.required = false;
    justificationInput.value = '';
    amountInput.value = '';
    amountInput.readOnly = false;

    /* ENCAISSEMENT : caisse PRINCIPALE uniquement */
    if (type === 'encaissement') {
        modalTitle.textContent = 'Encaisser dans la caisse principale';
        cashboxLabel.innerHTML = 'Caisse principale à créditer <span class="required-star">*</span>';
        applyRoleFilter(cashboxSelect, ['principale']);
        autoSelectSingleAllowed(cashboxSelect);
    }

    /* APPROVISIONNEMENT : principale → secondaire */
    if (type === 'approvisionnement') {
        modalTitle.textContent = 'Approvisionner la caisse secondaire';
        cashboxLabel.innerHTML = 'Caisse principale (source) <span class="required-star">*</span>';
        destinationField.style.display = 'block';
        destinationSelect.disabled = false;
        destinationSelect.required = true;
        applyRoleFilter(cashboxSelect, ['principale']);
        applyRoleFilter(destinationSelect, ['secondaire']);
        autoSelectSingleAllowed(cashboxSelect);
        autoSelectSingleAllowed(destinationSelect);
        if (categorySelect) {
            categorySelect.value = 'Approvisionnement';
        }
    }

    /* DÉCAISSEMENT : caisse SECONDAIRE uniquement (DA) */
    if (type === 'decaissement') {
        modalTitle.textContent = 'Payer une demande d’achat (caisse secondaire)';
        cashboxLabel.innerHTML = 'Caisse secondaire à débiter <span class="required-star">*</span>';
        applyRoleFilter(cashboxSelect, ['secondaire']);
        autoSelectSingleAllowed(cashboxSelect);
        purchaseRequestField.style.display = 'block';
        purchaseRequestSelect.disabled = false;
        purchaseRequestSelect.required = true;
        justificationField.style.display = 'block';
        justificationInput.disabled = false;
        justificationInput.required = true;
        if (categorySelect) {
            categorySelect.value = 'Paiement demande achat';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var cashboxSelect = document.getElementById('operationCashboxId');
    var destinationSelect = document.getElementById('destinationCashboxId');
    var balanceBox = document.getElementById('selectedCashboxBalance');
    var balanceValue = document.getElementById('selectedCashboxBalanceValue');
    var currencyLabel = document.getElementById('operationCurrencyLabel');
    var amountInput = document.getElementById('operationAmount');
    var amountError = document.getElementById('amountError');
    var submitButton = document.getElementById('submitCashboxOperation');
    var purchaseRequestSelect = document.getElementById('purchaseRequestId');
    var justificationInput = document.getElementById('expenseJustification');

    function formatMoney(amount, currency) {
        return new Intl.NumberFormat('fr-FR', {
            maximumFractionDigits: 0
        }).format(amount) + ' ' + currency;
    }

    function validateAmount() {
        var option = cashboxSelect.options[cashboxSelect.selectedIndex];
        var balance = option && option.value ? parseFloat(option.dataset.balance || 0) : 0;
        var amount = parseFloat(amountInput.value || 0);
        var type = document.getElementById('operationType').value;
        var mustCheck = (type === 'decaissement' || type === 'approvisionnement');
        var insufficient = mustCheck && amount > balance;
        amountError.style.display = insufficient ? 'block' : 'none';
        submitButton.disabled = insufficient;
    }

    cashboxSelect.addEventListener('change', function() {
        var option = this.options[this.selectedIndex];
        if (!this.value) {
            balanceBox.style.display = 'none';
            return;
        }
        balanceBox.style.display = 'block';
        balanceValue.textContent = formatMoney(parseFloat(option.dataset.balance || 0), option.dataset
            .currency || 'BIF');
        currencyLabel.textContent = option.dataset.currency || 'BIF';
        validateAmount();
    });

    amountInput.addEventListener('input', validateAmount);

    purchaseRequestSelect.addEventListener('change', function() {
        var option = this.options[this.selectedIndex];
        if (!this.value) {
            amountInput.value = '';
            justificationInput.value = '';
            return;
        }
        amountInput.value = option.dataset.amount || '';
        amountInput.readOnly = true;
        justificationInput.value = option.dataset.summary || '';
        document.getElementById('paymentVoucherId').value = option.dataset.paymentVoucherId || '';
        document.getElementById('purchaseRequestReference').value = option.dataset.requestReference ||
            '';
        document.getElementById('paymentVoucherReference').value = option.dataset.voucherReference ||
            '';
        document.getElementById('operationThirdParty').value = option.dataset.chantier || '';
        validateAmount();
    });

    /* Réouverture des rôles à la fermeture */
    $('#addOperationModal').on('hidden.bs.modal', function() {
        applyRoleFilter(cashboxSelect, ['principale', 'secondaire']);
        applyRoleFilter(destinationSelect, ['secondaire']);
        balanceBox.style.display = 'none';
        amountError.style.display = 'none';
        submitButton.disabled = false;
    });

    /* =====================================================
     * MODALE CRÉATION : UNICITÉ PRINCIPALE + SECONDAIRE
     * ===================================================== */
    function refreshRoleOptions() {
        var principaleExists = document.querySelectorAll('[data-role-caisse="principale"]').length > 0;
        var secondaireExists = document.querySelectorAll('[data-role-caisse="secondaire"]').length > 0;
        var optP = document.getElementById('optionPrincipale');
        var optS = document.getElementById('optionSecondaire');
        var note = document.getElementById('caisseRoleNote');
        var roleSelect = document.getElementById('caisseRole');

        if (optP) {
            optP.enabled = principaleExists;
        }
        if (optS) {
            optS.enabled = secondaireExists;
        }

        if (note) {
            if (principaleExists && secondaireExists) {
                note.textContent =
                    'Les deux caisses existent déjà : une principale + une secondaire (unicité).';
            } else if (!principaleExists) {
                note.textContent = 'Créez d’abord la caisse principale.';
            } else {
                note.textContent = 'La secondaire couvre TOUS les chantiers (unique).';
            }
        }
        if (roleSelect && roleSelect.value && roleSelect.options[roleSelect.selectedIndex].disabled) {
            roleSelect.value = '';
        }
    }
    refreshRoleOptions();
    $('#addCaisseModal').on('shown.bs.modal', refreshRoleOptions);
});
</script>

<!-- Graphique -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var el = document.getElementById('cashFlowChart');
    if (!el || typeof Chart === 'undefined') {
        return;
    }

    var labels = <?= json_encode($evolution['labels'], JSON_UNESCAPED_UNICODE) ?>;
    var incomes = <?= json_encode(array_map('floatval', $evolution['incomes'])) ?>;
    var expenses = <?= json_encode(array_map('floatval', $evolution['expenses'])) ?>;

    new Chart(el.getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Encaissements (principale)',
                data: incomes,
                borderColor: '#0f766e',
                backgroundColor: 'rgba(15,118,110,.15)',
                borderWidth: 2.5,
                pointRadius: 4,
                fill: true,
                tension: .35
            }, {
                label: 'Décaissements (secondaire)',
                data: expenses,
                borderColor: '#dc2626',
                backgroundColor: 'rgba(220,38,38,.10)',
                borderWidth: 2.5,
                pointRadius: 4,
                fill: true,
                tension: .35
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        font: {
                            size: 11
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ctx.dataset.label + ' : ' +
                                new Intl.NumberFormat('fr-FR').format(ctx.parsed.y) + ' BIF';
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
                        color: 'rgba(148,163,184,.15)'
                    },
                    ticks: {
                        font: {
                            size: 10
                        },
                        callback: function(v) {
                            return v >= 1000000 ? (v / 1000000) + ' M' : v;
                        }
                    }
                }
            }
        }
    });
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
        title: 'Enregistrement impossible',
        html: <?= json_encode($this->session->flashdata('error')) ?>,
        confirmButtonText: 'Corriger',
        confirmButtonColor: '#dc2626'
    });
});
</script>
<?php endif; ?>