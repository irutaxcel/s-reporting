<?php
/* =====================================================================
 * PAGE : COMPTES BANCAIRES — MODULE BANQUE V2
 * ===================================================================== */

/* ---------- Flashdata ---------- */
$oldAccount   = $this->session->flashdata('bank_account_old_input');
$oldAccount   = is_array($oldAccount) ? $oldAccount : [];
$oldOperation = $this->session->flashdata('bank_operation_old_input');
$oldOperation = is_array($oldOperation) ? $oldOperation : [];

$reopenAccountModal   = (bool) $this->session->flashdata('open_bank_account_modal');
$reopenOperationModal = (bool) $this->session->flashdata('open_bank_operation_modal');
$flashSuccess         = $this->session->flashdata('success');
$flashError           = $this->session->flashdata('error');

/* ---------- Données ---------- */
$banks            = $banks ?? [];
$bankFilters      = $bankFilters ?? [];
$stats            = is_array($bankMainStatistics ?? null) ? $bankMainStatistics : [];
$currency         = $stats['currency'] ?? 'BIF';
$flow             = $bankFlowEvolution ?? ['labels' => [], 'incomes' => [], 'expenses' => [], 'total_income' => 0, 'total_expense' => 0, 'net' => 0];
$principalCashbox = $principalCashbox ?? null;
$allBankAccounts  = $allBankAccounts ?? [];

/* ---------- Formatage ---------- */
if (!function_exists('bankAmount')) {
    function bankAmount($amount, string $currency = 'BIF'): string
    {
        return number_format((float) $amount, $currency === 'BIF' ? 0 : 2, ',', ' ') . ' ' . $currency;
    }
}

if (!function_exists('bankCompact')) {
    function bankCompact($amount): string
    {
        $amount = (float) $amount;
        $abs    = abs($amount);

        if ($abs >= 1000000000) return number_format($amount / 1000000000, 1, ',', ' ') . ' Md';
        if ($abs >= 1000000)    return number_format($amount / 1000000, 1, ',', ' ') . ' M';
        if ($abs >= 100000)     return number_format($amount / 1000, 0, ',', ' ') . ' K';

        return number_format($amount, 0, ',', ' ');
    }
}

/* ---------- Libellés ---------- */
$operationTypes = [
    'encaissement'        => ['label' => 'Encaissement',        'badge' => 'credit',   'icon' => 'fas fa-arrow-down'],
    'decaissement'        => ['label' => 'Décaissement',        'badge' => 'debit',    'icon' => 'fas fa-arrow-up'],
    'transfert'           => ['label' => 'Transfert',           'badge' => 'transfer', 'icon' => 'fas fa-exchange-alt'],
    'retrait_banque'      => ['label' => 'Retrait → caisse',    'badge' => 'cash',     'icon' => 'fas fa-money-bill-wave'],
    'versement_banque'    => ['label' => 'Versement caisse',    'badge' => 'cash',     'icon' => 'fas fa-piggy-bank'],
    'frais_bancaires'     => ['label' => 'Frais bancaires',     'badge' => 'debit',    'icon' => 'fas fa-receipt'],
    'interets_crediteurs' => ['label' => 'Intérêts créditeurs', 'badge' => 'credit',   'icon' => 'fas fa-percentage'],
];

$debitTypes = ['decaissement', 'transfert', 'retrait_banque', 'frais_bancaires'];

$accountTypeLabels = [
    'courant'  => 'Compte courant',
    'epargne'  => 'Compte épargne',
    'garantie' => 'Compte de garantie',
    'projet'   => 'Compte projet',
    'credit'   => 'Ligne de crédit',
];

$accountStatusLabels = [
    'active'   => ['Actif', 'active'],
    'inactive' => ['Inactif', 'inactive'],
    'blocked'  => ['Bloqué', 'blocked'],
    'closed'   => ['Clôturé', 'inactive'],
];

$operationStatusLabels = [
    'validated' => ['Validée', 'badge-success'],
    'pending'   => ['En attente', 'badge-warning'],
    'cancelled' => ['Annulée', 'badge-secondary'],
];

$paymentMethods = [
    'virement'          => 'Virement bancaire',
    'cheque'            => 'Chèque',
    'versement_especes' => 'Versement d’espèces',
    'retrait_especes'   => 'Retrait d’espèces',
    'prelevement'       => 'Prélèvement / avis de débit',
    'autre'             => 'Autre',
];

$categories = [
    'paiement_client' => 'Paiement client',
    'avance_marche'   => 'Avance de marché',
    'fournisseur'     => 'Paiement fournisseur',
    'sous_traitance'  => 'Sous-traitance',
    'salaire'         => 'Salaires',
    'impot'           => 'Impôts et taxes',
    'frais'           => 'Frais bancaires',
    'transfert'       => 'Transfert interne',
    'autre'           => 'Autre',
];

$oldValue = function (array $source, string $key, $default = '') {
    return html_escape($source[$key] ?? $default);
};

$jsonFlags = JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP;
?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= html_escape($title) ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= html_escape($title) ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid bank-page">

            <style>
                :root {
                    --bank-primary: #0f766e;
                    --bank-primary-dark: #115e59;
                    --bank-secondary: #102033;
                    --bank-muted: #64748b;
                    --bank-border: #e2e8f0
                }

                .bank-page {
                    padding-bottom: 30px
                }

                .bank-hero {
                    position: relative;
                    overflow: hidden;
                    margin-bottom: 20px;
                    padding: 24px;
                    border-radius: 15px;
                    color: #fff;
                    background: linear-gradient(120deg, #0f766e 0%, #155e75 55%, #102033 100%);
                    box-shadow: 0 12px 30px rgba(15, 118, 110, .16)
                }

                .bank-hero::after {
                    position: absolute;
                    right: -35px;
                    top: -70px;
                    width: 190px;
                    height: 190px;
                    content: "";
                    border-radius: 50%;
                    background: rgba(255, 255, 255, .06)
                }

                .bank-hero-content {
                    position: relative;
                    z-index: 2;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 20px
                }

                .bank-hero-main {
                    display: flex;
                    align-items: flex-start;
                    gap: 14px
                }

                .bank-hero-icon {
                    display: flex;
                    flex: 0 0 48px;
                    align-items: center;
                    justify-content: center;
                    height: 48px;
                    border-radius: 12px;
                    background: rgba(255, 255, 255, .14);
                    font-size: 20px
                }

                .bank-hero h2 {
                    margin: 0 0 7px;
                    font-size: 22px;
                    font-weight: 800
                }

                .bank-hero p {
                    max-width: 760px;
                    margin: 0;
                    color: rgba(255, 255, 255, .88);
                    font-size: 12px;
                    line-height: 1.6
                }

                .bank-hero-date {
                    min-width: 155px;
                    padding: 11px 14px;
                    border: 1px solid rgba(255, 255, 255, .18);
                    border-radius: 11px;
                    background: rgba(255, 255, 255, .10);
                    text-align: center
                }

                .bank-hero-date span {
                    display: block;
                    margin-bottom: 3px;
                    color: rgba(255, 255, 255, .75);
                    font-size: 10px
                }

                .bank-hero-date strong {
                    font-size: 13px;
                    font-weight: 800
                }

                .bank-stat-card {
                    position: relative;
                    overflow: hidden;
                    min-height: 150px;
                    margin-bottom: 16px;
                    padding: 18px;
                    border: 1px solid var(--bank-border);
                    border-radius: 14px;
                    background: #fff;
                    box-shadow: 0 7px 24px rgba(15, 23, 42, .045)
                }

                .bank-stat-top {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-bottom: 15px
                }

                .bank-stat-icon {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 43px;
                    height: 43px;
                    border-radius: 11px;
                    font-size: 17px
                }

                .icon-green {
                    color: #15803d;
                    background: #dcfce7
                }

                .icon-blue {
                    color: #0369a1;
                    background: #e0f2fe
                }

                .icon-orange {
                    color: #b45309;
                    background: #fef3c7
                }

                .icon-red {
                    color: #b91c1c;
                    background: #fee2e2
                }

                .icon-purple {
                    color: #6d28d9;
                    background: #ede9fe
                }

                .bank-stat-badge {
                    padding: 4px 9px;
                    border-radius: 20px;
                    font-size: 10px;
                    font-weight: 800
                }

                .bank-stat-badge.badge-positive {
                    color: #15803d;
                    background: #dcfce7
                }

                .bank-stat-badge.badge-neutral {
                    color: #0369a1;
                    background: #e0f2fe
                }

                .bank-stat-badge.badge-negative {
                    color: #b91c1c;
                    background: #fee2e2
                }

                .bank-stat-label {
                    margin-bottom: 4px;
                    color: var(--bank-muted);
                    font-size: 11px;
                    font-weight: 800;
                    text-transform: uppercase
                }

                .bank-stat-value {
                    margin-bottom: 4px;
                    color: #0f172a;
                    font-size: 21px;
                    font-weight: 900;
                    line-height: 1.15
                }

                .bank-stat-footer {
                    color: var(--bank-muted);
                    font-size: 10px
                }

                .bank-card {
                    margin-bottom: 18px;
                    overflow: hidden;
                    border: 1px solid var(--bank-border);
                    border-radius: 14px;
                    background: #fff;
                    box-shadow: 0 6px 22px rgba(15, 23, 42, .04)
                }

                .bank-card-header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 15px;
                    min-height: 62px;
                    padding: 15px 18px;
                    border-bottom: 1px solid #edf2f7
                }

                .bank-card-title {
                    margin: 0 0 2px;
                    color: var(--bank-secondary);
                    font-size: 15px;
                    font-weight: 800
                }

                .bank-card-title i {
                    margin-right: 7px;
                    color: var(--bank-primary)
                }

                .bank-card-subtitle {
                    color: var(--bank-muted);
                    font-size: 11px
                }

                .bank-card-body {
                    padding: 18px
                }

                .btn-bank-primary {
                    color: #fff;
                    border: 1px solid var(--bank-primary);
                    border-radius: 8px;
                    background: var(--bank-primary);
                    font-size: 12px;
                    font-weight: 700
                }

                .btn-bank-primary:hover {
                    color: #fff;
                    background: var(--bank-primary-dark)
                }

                .btn-bank-outline {
                    color: var(--bank-primary);
                    border: 1px solid #9bd0ca;
                    border-radius: 8px;
                    background: #fff;
                    font-size: 12px;
                    font-weight: 700
                }

                .btn-bank-outline:hover {
                    color: #fff;
                    background: var(--bank-primary)
                }

                .bank-actions-grid {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 11px
                }

                .bank-action-item {
                    display: flex;
                    align-items: center;
                    min-height: 72px;
                    padding: 12px;
                    color: #334155;
                    border: 1px solid var(--bank-border);
                    border-radius: 11px;
                    background: #fff;
                    cursor: pointer;
                    transition: all .2s ease
                }

                .bank-action-item:hover {
                    border-color: #99d5ce;
                    box-shadow: 0 9px 22px rgba(15, 118, 110, .08);
                    transform: translateY(-2px)
                }

                .bank-action-icon {
                    display: flex;
                    flex: 0 0 40px;
                    align-items: center;
                    justify-content: center;
                    height: 40px;
                    margin-right: 10px;
                    border-radius: 10px;
                    font-size: 16px
                }

                .bank-action-item strong {
                    display: block;
                    margin-bottom: 2px;
                    font-size: 12px
                }

                .bank-action-item small {
                    color: var(--bank-muted);
                    font-size: 10px
                }

                .bank-flow-summary {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 11px;
                    margin-bottom: 16px
                }

                .bank-flow-summary>div {
                    padding: 10px 12px;
                    border: 1px solid var(--bank-border);
                    border-radius: 10px;
                    background: #f8fafc
                }

                .bank-flow-summary span {
                    display: block;
                    margin-bottom: 4px;
                    color: var(--bank-muted);
                    font-size: 10px;
                    font-weight: 800;
                    text-transform: uppercase
                }

                .bank-flow-summary strong {
                    font-size: 13px;
                    font-weight: 900
                }

                .bank-chart-wrapper {
                    position: relative;
                    height: 285px
                }

                .bank-balance-item {
                    margin-bottom: 16px
                }

                .bank-balance-item-top {
                    display: flex;
                    justify-content: space-between;
                    gap: 10px;
                    margin-bottom: 6px;
                    font-size: 12px;
                    font-weight: 800
                }

                .bank-progress {
                    height: 7px;
                    overflow: hidden;
                    border-radius: 20px;
                    background: #e9eef3
                }

                .bank-progress span {
                    display: block;
                    height: 100%;
                    border-radius: 20px;
                    background: linear-gradient(90deg, #14b8a6, #0f766e)
                }

                .bank-filter-box {
                    margin-bottom: 18px;
                    padding: 16px;
                    border: 1px solid var(--bank-border);
                    border-radius: 14px;
                    background: #fff
                }

                .bank-filter-box label,
                .modal-bank label {
                    margin-bottom: 5px;
                    color: #475569;
                    font-size: 11px;
                    font-weight: 800
                }

                .bank-filter-box .form-control,
                .modal-bank .form-control {
                    min-height: 38px;
                    border-color: #dbe4ea;
                    border-radius: 8px;
                    font-size: 12px
                }

                .bank-account-card {
                    margin-bottom: 16px;
                    overflow: hidden;
                    border: 1px solid var(--bank-border);
                    border-radius: 13px;
                    background: #fff;
                    transition: all .2s ease
                }

                .bank-account-card:hover {
                    border-color: #9bd0ca;
                    box-shadow: 0 10px 25px rgba(15, 118, 110, .075)
                }

                .bank-account-card.is-blocked {
                    border-color: #fecaca
                }

                .bank-account-top {
                    padding: 16px
                }

                .bank-account-header {
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    gap: 10px;
                    margin-bottom: 14px
                }

                .bank-account-name {
                    display: flex;
                    min-width: 0;
                    align-items: center;
                    gap: 10px
                }

                .bank-logo {
                    display: flex;
                    flex: 0 0 44px;
                    align-items: center;
                    justify-content: center;
                    height: 44px;
                    border-radius: 11px;
                    color: #0369a1;
                    background: #e0f2fe;
                    font-size: 18px
                }

                .bank-account-name h6 {
                    max-width: 200px;
                    margin: 0 0 2px;
                    overflow: hidden;
                    color: var(--bank-secondary);
                    font-size: 13px;
                    font-weight: 800;
                    text-overflow: ellipsis;
                    white-space: nowrap
                }

                .bank-account-name small {
                    display: block;
                    color: var(--bank-muted);
                    font-size: 10px
                }

                .bank-account-name .bank-code {
                    color: var(--bank-primary);
                    font-weight: 700
                }

                .bank-status {
                    padding: 4px 8px;
                    border-radius: 20px;
                    font-size: 9px;
                    font-weight: 800;
                    text-transform: uppercase;
                    white-space: nowrap
                }

                .bank-status.active {
                    color: #15803d;
                    background: #dcfce7
                }

                .bank-status.blocked {
                    color: #b91c1c;
                    background: #fee2e2
                }

                .bank-status.inactive {
                    color: #64748b;
                    background: #e2e8f0
                }

                .bank-balance-label {
                    color: var(--bank-muted);
                    font-size: 10px;
                    font-weight: 800;
                    text-transform: uppercase
                }

                .bank-balance-value {
                    margin-bottom: 8px;
                    color: #0f172a;
                    font-size: 21px;
                    font-weight: 900
                }

                .bank-balance-value.is-negative {
                    color: #b91c1c
                }

                .bank-meta {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 6px
                }

                .bank-meta span {
                    padding: 4px 8px;
                    color: #475569;
                    border-radius: 20px;
                    background: #f1f5f9;
                    font-size: 10px
                }

                .bank-meta i {
                    margin-right: 4px;
                    color: var(--bank-primary)
                }

                .bank-account-footer {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    border-top: 1px solid #edf2f7;
                    background: #fbfdff
                }

                .bank-account-footer>div {
                    padding: 9px 6px;
                    text-align: center;
                    border-right: 1px solid #edf2f7
                }

                .bank-account-footer>div:last-child {
                    border-right: 0
                }

                .bank-account-footer span {
                    display: block;
                    color: var(--bank-muted);
                    font-size: 10px
                }

                .bank-account-footer strong {
                    font-size: 11px
                }

                .bank-account-actions {
                    display: flex;
                    justify-content: flex-end;
                    gap: 5px;
                    padding: 9px 13px;
                    border-top: 1px solid #edf2f7
                }

                .bank-btn-icon {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 30px;
                    height: 30px;
                    color: #475569;
                    border: 1px solid #dbe4ea;
                    border-radius: 8px;
                    background: #fff;
                    font-size: 11px
                }

                .bank-btn-icon:hover {
                    color: #fff;
                    border-color: var(--bank-primary);
                    background: var(--bank-primary);
                    text-decoration: none
                }

                .bank-btn-icon.is-success:hover {
                    border-color: #16a34a;
                    background: #16a34a
                }

                .bank-btn-icon.is-danger:hover {
                    border-color: #dc2626;
                    background: #dc2626
                }

                .bank-table {
                    margin-bottom: 0
                }

                .bank-table thead th {
                    padding: 11px 10px;
                    color: #475569;
                    border-top: 0;
                    background: #f8fafc;
                    font-size: 10px;
                    font-weight: 900;
                    text-transform: uppercase;
                    white-space: nowrap
                }

                .bank-table tbody td {
                    padding: 10px;
                    color: #334155;
                    font-size: 11px;
                    vertical-align: middle
                }

                .bank-row-cancelled td {
                    opacity: .55
                }

                .bank-row-cancelled td.bank-strike {
                    text-decoration: line-through
                }

                .bank-op-badge {
                    display: inline-flex;
                    align-items: center;
                    padding: 4px 8px;
                    border-radius: 20px;
                    font-size: 10px;
                    font-weight: 800;
                    white-space: nowrap
                }

                .bank-op-badge.credit {
                    color: #15803d;
                    background: #dcfce7
                }

                .bank-op-badge.debit {
                    color: #b91c1c;
                    background: #fee2e2
                }

                .bank-op-badge.transfer {
                    color: #0369a1;
                    background: #e0f2fe
                }

                .bank-op-badge.cash {
                    color: #6d28d9;
                    background: #ede9fe
                }

                .bank-amount-in {
                    color: #15803d;
                    font-weight: 900;
                    white-space: nowrap
                }

                .bank-amount-out {
                    color: #b91c1c;
                    font-weight: 900;
                    white-space: nowrap
                }

                .bank-alert {
                    display: flex;
                    gap: 11px;
                    margin-bottom: 11px;
                    padding: 12px;
                    border: 1px solid;
                    border-radius: 11px
                }

                .bank-alert.danger {
                    color: #991b1b;
                    border-color: #fecaca;
                    background: #fef2f2
                }

                .bank-alert.warning {
                    color: #92400e;
                    border-color: #fde68a;
                    background: #fffbeb
                }

                .bank-alert.info {
                    color: #075985;
                    border-color: #bae6fd;
                    background: #f0f9ff
                }

                .bank-alert-icon {
                    display: flex;
                    flex: 0 0 34px;
                    align-items: center;
                    justify-content: center;
                    height: 34px;
                    border-radius: 9px;
                    background: rgba(255, 255, 255, .6)
                }

                .bank-alert h6 {
                    margin: 0 0 3px;
                    font-size: 12px;
                    font-weight: 800
                }

                .bank-alert p {
                    margin: 0;
                    font-size: 11px
                }

                .bank-empty {
                    padding: 40px 20px;
                    text-align: center;
                    color: var(--bank-muted)
                }

                .bank-empty i {
                    display: block;
                    margin-bottom: 12px;
                    font-size: 34px;
                    color: #cbd5e1
                }

                .modal-bank .modal-content {
                    overflow: hidden;
                    border: 0;
                    border-radius: 14px
                }

                .modal-bank .modal-header {
                    color: #fff;
                    border-bottom: 0;
                    background: linear-gradient(120deg, #0f766e, #155e75, #102033)
                }

                .modal-bank .modal-title {
                    font-size: 15px;
                    font-weight: 800
                }

                .modal-bank .close {
                    color: #fff;
                    opacity: 1
                }

                .required-star {
                    color: #dc2626
                }

                .bank-info-box {
                    margin-top: 6px;
                    padding: 8px 12px;
                    border: 1px solid #99d5ce;
                    border-radius: 9px;
                    background: #f0fdfa;
                    font-size: 11px
                }

                .bank-warning-box {
                    padding: 9px 12px;
                    border: 1px solid #fde68a;
                    border-radius: 9px;
                    background: #fffbeb;
                    color: #92400e;
                    font-size: 12px;
                    font-weight: 600
                }

                .bank-detail-table th {
                    width: 40%;
                    color: var(--bank-muted);
                    font-size: 11px;
                    font-weight: 700
                }

                .bank-detail-table td {
                    font-size: 12px
                }

                @media (max-width:1199px) {
                    .bank-actions-grid {
                        grid-template-columns: repeat(2, 1fr)
                    }
                }

                @media (max-width:767px) {
                    .bank-hero-content {
                        flex-direction: column;
                        align-items: flex-start
                    }

                    .bank-actions-grid,
                    .bank-flow-summary {
                        grid-template-columns: 1fr
                    }
                }
            </style>

            <!-- =========================================================
                 BANDEAU
            ========================================================== -->
            <div class="bank-hero">
                <div class="bank-hero-content">
                    <div class="bank-hero-main">
                        <div class="bank-hero-icon"><i class="fas fa-university"></i></div>
                        <div>
                            <h2>Gestion des comptes bancaires</h2>
                            <p>
                                Suivez les disponibilités par banque et par devise. Chaque opération validée
                                est inscrite au livre de banque ; les retraits et versements sont reportés
                                automatiquement dans le livre de la caisse principale.
                            </p>
                        </div>
                    </div>
                    <div class="bank-hero-date">
                        <span><i class="far fa-calendar-alt mr-1"></i> Situation au</span>
                        <strong><?= date('d/m/Y') ?></strong>
                    </div>
                </div>
            </div>

            <!-- =========================================================
                 STATISTIQUES
            ========================================================== -->
            <?php
            $variation = (float) ($stats['global_variation_percentage'] ?? 0);

            $statCards = [
                [
                    'icon'       => 'fas fa-coins',
                    'color'      => 'green',
                    'label'      => 'Solde bancaire global',
                    'value'      => bankAmount($stats['global_balance'] ?? 0, $currency),
                    'badge'      => ($variation > 0 ? '+' : '') . number_format($variation, 1, ',', ' ') . ' %',
                    'badgeClass' => $variation > 0 ? 'positive' : ($variation < 0 ? 'negative' : 'neutral'),
                    'footer'     => (int) ($stats['currency_accounts'] ?? 0) . ' compte(s) actif(s) en ' . $currency . ' — évolution depuis le 1er du mois',
                ],
                [
                    'icon'       => 'fas fa-university',
                    'color'      => 'blue',
                    'label'      => 'Comptes actifs',
                    'value'      => (int) ($stats['active_accounts'] ?? 0),
                    'badge'      => (int) ($stats['bank_count'] ?? 0) . ' banque(s)',
                    'badgeClass' => 'neutral',
                    'footer'     => 'Toutes devises confondues',
                ],
                [
                    'icon'       => 'fas fa-arrow-down',
                    'color'      => 'orange',
                    'label'      => 'Entrées du jour',
                    'value'      => bankAmount($stats['today_income_amount'] ?? 0, $currency),
                    'badge'      => (int) ($stats['today_income_count'] ?? 0) . ' mouvement(s)',
                    'badgeClass' => ($stats['today_income_count'] ?? 0) > 0 ? 'positive' : 'neutral',
                    'footer'     => 'Hors transferts entre comptes',
                ],
                [
                    'icon'       => 'fas fa-arrow-up',
                    'color'      => 'red',
                    'label'      => 'Sorties du jour',
                    'value'      => bankAmount($stats['today_expense_amount'] ?? 0, $currency),
                    'badge'      => (int) ($stats['today_expense_count'] ?? 0) . ' mouvement(s)',
                    'badgeClass' => ($stats['today_expense_count'] ?? 0) > 0 ? 'negative' : 'neutral',
                    'footer'     => 'Hors transferts entre comptes',
                ],
            ];
            ?>

            <div class="row">
                <?php foreach ($statCards as $card): ?>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="bank-stat-card">
                            <div class="bank-stat-top">
                                <div class="bank-stat-icon icon-<?= $card['color'] ?>"><i class="<?= $card['icon'] ?>"></i>
                                </div>
                                <span
                                    class="bank-stat-badge badge-<?= $card['badgeClass'] ?>"><?= html_escape($card['badge']) ?></span>
                            </div>
                            <div class="bank-stat-label"><?= html_escape($card['label']) ?></div>
                            <div class="bank-stat-value"><?= html_escape((string) $card['value']) ?></div>
                            <div class="bank-stat-footer"><?= html_escape($card['footer']) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- =========================================================
                 ACTIONS RAPIDES
            ========================================================== -->
            <?php
            $quickActions = [
                ['action' => 'account',             'icon' => 'fas fa-plus',            'color' => 'green',  'title' => 'Nouveau compte',      'text' => 'Ajouter un compte bancaire'],
                ['action' => 'encaissement',        'icon' => 'fas fa-arrow-down',      'color' => 'blue',   'title' => 'Encaissement',        'text' => 'Entrée sur un compte'],
                ['action' => 'decaissement',        'icon' => 'fas fa-arrow-up',        'color' => 'red',    'title' => 'Décaissement',        'text' => 'Sortie d’un compte'],
                ['action' => 'transfert',           'icon' => 'fas fa-exchange-alt',    'color' => 'orange', 'title' => 'Transfert',           'text' => 'Entre deux comptes bancaires'],
                ['action' => 'retrait_banque',      'icon' => 'fas fa-money-bill-wave', 'color' => 'purple', 'title' => 'Retrait → caisse',    'text' => 'Alimenter la caisse principale'],
                ['action' => 'versement_banque',    'icon' => 'fas fa-piggy-bank',      'color' => 'green',  'title' => 'Versement en banque', 'text' => 'Depuis la caisse principale'],
                ['action' => 'frais_bancaires',     'icon' => 'fas fa-receipt',         'color' => 'red',    'title' => 'Frais bancaires',     'text' => 'Agios, commissions, tenue de compte'],
                ['action' => 'interets_crediteurs', 'icon' => 'fas fa-percentage',      'color' => 'blue',   'title' => 'Intérêts créditeurs', 'text' => 'Intérêts versés par la banque'],
            ];
            ?>

            <div class="bank-card">
                <div class="bank-card-header">
                    <div>
                        <h5 class="bank-card-title"><i class="fas fa-bolt"></i> Actions rapides</h5>
                        <span class="bank-card-subtitle">Chaque opération validée est inscrite immédiatement au livre de
                            banque.</span>
                    </div>
                </div>
                <div class="bank-card-body">
                    <div class="bank-actions-grid">
                        <?php foreach ($quickActions as $action): ?>
                            <div class="bank-action-item" <?php if ($action['action'] === 'account'): ?> data-toggle="modal"
                                data-target="#addBankAccountModal" <?php else: ?>
                                onclick="openBankOperation('<?= $action['action'] ?>')" <?php endif; ?>>
                                <div class="bank-action-icon icon-<?= $action['color'] ?>"><i
                                        class="<?= $action['icon'] ?>"></i></div>
                                <div>
                                    <strong><?= html_escape($action['title']) ?></strong>
                                    <small><?= html_escape($action['text']) ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- =========================================================
     CHAMPS FICHIER : nom du fichier + bouton en français
     (global, s'applique à tous les formulaires)
========================================================== -->
            <style>
                .custom-file-label {
                    overflow: hidden;
                    padding-right: 100px;
                    white-space: nowrap;
                    text-overflow: ellipsis;
                    font-weight: 500;
                }

                .custom-file-label::after {
                    content: "Parcourir" !important;
                }

                .custom-file-input.has-file~.custom-file-label {
                    color: #0f766e;
                    font-weight: 700;
                }
            </style>

            <script>
                (function($) {
                    if (!$) {
                        return;
                    }

                    var DEFAULT_LABEL = 'Choisir un fichier';

                    function formatFileSize(bytes) {
                        if (bytes >= 1048576) return (bytes / 1048576).toFixed(1).replace('.', ',') + ' Mo';
                        if (bytes >= 1024) return Math.round(bytes / 1024) + ' Ko';
                        return bytes + ' o';
                    }

                    function refreshFileLabel(input) {
                        var $label = $(input).siblings('.custom-file-label');

                        if (!$label.length) {
                            return;
                        }

                        /* Mémoriser le texte d'origine du label (une seule fois) */
                        if ($label.data('defaultLabel') === undefined) {
                            $label.data('defaultLabel', $.trim($label.text()) || DEFAULT_LABEL);
                        }

                        var files = input.files ? Array.prototype.slice.call(input.files) : [];

                        if (!files.length) {
                            $label.text($label.data('defaultLabel')).removeAttr('title');
                            $(input).removeClass('has-file');
                            return;
                        }

                        var text = files.length === 1 ?
                            files[0].name + ' (' + formatFileSize(files[0].size) + ')' :
                            files.length + ' fichiers sélectionnés';

                        $label
                            .text(text)
                            .attr('title', files.map(function(file) {
                                return file.name;
                            }).join(', '));

                        $(input).addClass('has-file');
                    }

                    /* Sélection d'un fichier */
                    $(document).on('change', '.custom-file-input', function() {
                        refreshFileLabel(this);
                    });

                    /* Remise à zéro du label quand un formulaire est réinitialisé (form.reset()) */
                    $(document).on('reset', 'form', function() {
                        var form = this;

                        setTimeout(function() {
                            $(form).find('.custom-file-input').each(function() {
                                refreshFileLabel(this);
                            });
                        }, 0);
                    });
                })(window.jQuery);
            </script>

            <!-- =========================================================
                 GRAPHIQUE + RÉPARTITION
            ========================================================== -->
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="bank-card">
                        <div class="bank-card-header">
                            <div>
                                <h5 class="bank-card-title"><i class="fas fa-chart-line"></i> Évolution des flux
                                    bancaires (<?= html_escape($currency) ?>)</h5>
                                <span class="bank-card-subtitle">Entrées et sorties hors transferts entre
                                    comptes.</span>
                            </div>
                            <form action="<?= base_url('compte-banques') ?>" method="get">
                                <select name="bankflow_period" class="form-control form-control-sm"
                                    style="width:165px;border-radius:8px" onchange="this.form.submit()">
                                    <?php foreach (['7days' => '7 derniers jours', '30days' => '30 derniers jours', 'month' => 'Ce mois', 'year' => 'Cette année'] as $key => $label): ?>
                                        <option value="<?= $key ?>"
                                            <?= ($bankFlowPeriod ?? '7days') === $key ? 'selected' : '' ?>><?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </div>
                        <div class="bank-card-body">
                            <div class="bank-flow-summary">
                                <div><span>Entrées</span><strong class="text-success">+
                                        <?= bankAmount($flow['total_income'] ?? 0, $currency) ?></strong></div>
                                <div><span>Sorties</span><strong class="text-danger">-
                                        <?= bankAmount($flow['total_expense'] ?? 0, $currency) ?></strong></div>
                                <div>
                                    <span>Flux net</span>
                                    <strong class="<?= ($flow['net'] ?? 0) >= 0 ? 'text-success' : 'text-danger' ?>">
                                        <?= ($flow['net'] ?? 0) >= 0 ? '+' : '-' ?>
                                        <?= bankAmount(abs($flow['net'] ?? 0), $currency) ?>
                                    </strong>
                                </div>
                            </div>
                            <div class="bank-chart-wrapper"><canvas id="bankFlowChart"></canvas></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4">
                    <div class="bank-card">
                        <div class="bank-card-header">
                            <div>
                                <h5 class="bank-card-title"><i class="fas fa-chart-pie"></i> Répartition par banque</h5>
                                <span class="bank-card-subtitle">Part du solde global <?= html_escape($currency) ?> par
                                    établissement.</span>
                            </div>
                        </div>
                        <div class="bank-card-body">
                            <?php if (!empty($bankBalanceDistribution)): ?>
                                <?php foreach ($bankBalanceDistribution as $item): ?>
                                    <div class="bank-balance-item">
                                        <div class="bank-balance-item-top">
                                            <span>
                                                <?= html_escape($item['bank_name']) ?>
                                                <small
                                                    class="d-block text-muted font-weight-normal"><?= (int) $item['account_count'] ?>
                                                    compte(s) — <?= number_format((float) $item['percentage'], 1, ',', ' ') ?>
                                                    %</small>
                                            </span>
                                            <span><?= bankAmount($item['total_balance'], $currency) ?></span>
                                        </div>
                                        <div class="bank-progress"><span
                                                style="width: <?= number_format(min(100, max(0, (float) $item['percentage'])), 2, '.', '') ?>%"></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="bank-empty"><i class="fas fa-university"></i>Aucun compte actif en
                                    <?= html_escape($currency) ?>.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =========================================================
                 FILTRES
            ========================================================== -->
            <div class="bank-filter-box">
                <form action="<?= base_url('compte-banques') ?>" method="get">
                    <div class="row align-items-end">
                        <div class="col-xl-3 col-md-6 form-group mb-xl-0">
                            <label for="bankSearch">Rechercher</label>
                            <input type="text" name="search" id="bankSearch" class="form-control"
                                value="<?= html_escape($bankFilters['search'] ?? '') ?>"
                                placeholder="Code, intitulé, numéro, agence…" autocomplete="off">
                        </div>
                        <div class="col-xl-2 col-md-6 form-group mb-xl-0">
                            <label for="bankFilterBank">Banque</label>
                            <select name="bank_id" id="bankFilterBank" class="form-control">
                                <option value="">Toutes les banques</option>
                                <?php foreach ($banks as $bank): ?>
                                    <option value="<?= (int) $bank->id ?>"
                                        <?= (int) ($bankFilters['bank_id'] ?? 0) === (int) $bank->id ? 'selected' : '' ?>>
                                        <?= html_escape($bank->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-6 form-group mb-xl-0">
                            <label for="bankFilterCurrency">Devise</label>
                            <select name="currency" id="bankFilterCurrency" class="form-control">
                                <option value="">Toutes</option>
                                <?php foreach (['BIF', 'USD', 'EUR'] as $cur): ?>
                                    <option value="<?= $cur ?>"
                                        <?= ($bankFilters['currency'] ?? '') === $cur ? 'selected' : '' ?>><?= $cur ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-6 form-group mb-xl-0">
                            <label for="bankFilterStatus">Statut</label>
                            <select name="status" id="bankFilterStatus" class="form-control">
                                <option value="">Tous</option>
                                <?php foreach ($accountStatusLabels as $key => $statusLabel): ?>
                                    <option value="<?= $key ?>"
                                        <?= ($bankFilters['status'] ?? '') === $key ? 'selected' : '' ?>>
                                        <?= $statusLabel[0] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xl-3 col-md-12 form-group mb-0 d-flex">
                            <button type="submit" class="btn btn-bank-primary mr-2"><i class="fas fa-filter mr-1"></i>
                                Appliquer</button>
                            <a href="<?= base_url('compte-banques') ?>" class="btn btn-bank-outline"><i
                                    class="fas fa-redo mr-1"></i> Réinitialiser</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- =========================================================
                 COMPTES BANCAIRES
            ========================================================== -->
            <div class="bank-card">
                <div class="bank-card-header">
                    <div>
                        <h5 class="bank-card-title"><i class="fas fa-university"></i> Situation des comptes bancaires
                        </h5>
                        <span class="bank-card-subtitle">Soldes calculés depuis le livre de banque.</span>
                    </div>
                    <span class="badge badge-success"><?= count($bankAccountSituations ?? []) ?> compte(s)
                        affiché(s)</span>
                </div>
                <div class="bank-card-body pb-1">
                    <?php if (!empty($bankAccountSituations)): ?>
                        <div class="row">
                            <?php foreach ($bankAccountSituations as $account): ?>
                                <?php
                                $statusLabel = $accountStatusLabels[$account->status] ?? [$account->status, 'inactive'];
                                $balance     = (float) $account->current_balance;
                                ?>
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="bank-account-card <?= $account->status === 'blocked' ? 'is-blocked' : '' ?>">
                                        <div class="bank-account-top">
                                            <div class="bank-account-header">
                                                <div class="bank-account-name">
                                                    <div class="bank-logo"><i class="fas fa-university"></i></div>
                                                    <div>
                                                        <h6 title="<?= html_escape($account->name) ?>">
                                                            <?= html_escape($account->name) ?></h6>
                                                        <small><?= html_escape($account->account_number) ?></small>
                                                        <small class="bank-code"><?= html_escape($account->code) ?></small>
                                                    </div>
                                                </div>
                                                <span class="bank-status <?= $statusLabel[1] ?>"><?= $statusLabel[0] ?></span>
                                            </div>

                                            <div class="bank-balance-label">
                                                <?= $account->account_type === 'garantie' ? 'Solde réservé' : 'Solde disponible' ?>
                                            </div>
                                            <div class="bank-balance-value <?= $balance < 0 ? 'is-negative' : '' ?>">
                                                <?= bankAmount($balance, $account->currency) ?></div>

                                            <div class="bank-meta">
                                                <span><i
                                                        class="fas fa-building"></i><?= html_escape($account->bank_name) ?></span>
                                                <span><i
                                                        class="fas fa-tag"></i><?= html_escape($accountTypeLabels[$account->account_type] ?? $account->account_type) ?></span>
                                                <?php if (!empty($account->branch_name)): ?>
                                                    <span><i
                                                            class="fas fa-map-marker-alt"></i><?= html_escape($account->branch_name) ?></span>
                                                <?php endif; ?>
                                                <?php if ((float) $account->overdraft_limit > 0): ?>
                                                    <span><i class="fas fa-shield-alt"></i>Découvert
                                                        <?= bankCompact($account->overdraft_limit) ?></span>
                                                <?php endif; ?>
                                                <span>
                                                    <i class="fas fa-balance-scale"></i>
                                                    <?= !empty($account->last_reconciled_date)
                                                        ? 'Rapproché au ' . date('d/m/Y', strtotime($account->last_reconciled_date))
                                                        : 'Jamais rapproché' ?>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="bank-account-footer">
                                            <div><span>Entrées du mois</span><strong
                                                    class="text-success"><?= bankCompact($account->monthly_entries) ?></strong>
                                            </div>
                                            <div><span>Sorties du mois</span><strong
                                                    class="text-danger"><?= bankCompact($account->monthly_outputs) ?></strong>
                                            </div>
                                            <div>
                                                <span>Mouvements</span><strong><?= (int) $account->monthly_operations ?></strong>
                                            </div>
                                        </div>

                                        <div class="bank-account-actions">
                                            <button type="button" class="bank-btn-icon" title="Voir le compte"
                                                onclick="viewBankAccount(<?= (int) $account->id ?>)"><i
                                                    class="fas fa-eye"></i></button>
                                            <button type="button" class="bank-btn-icon" title="Modifier le compte"
                                                onclick="editBankAccount(<?= (int) $account->id ?>)"><i
                                                    class="fas fa-edit"></i></button>
                                            <a href="<?= base_url('banque-livre/' . (int) $account->id) ?>"
                                                class="bank-btn-icon" title="Livre de banque"><i class="fas fa-book"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="bank-empty">
                            <i class="fas fa-university"></i>
                            <p class="mb-3">Aucun compte bancaire ne correspond à ces critères.</p>
                            <button type="button" class="btn btn-bank-primary" data-toggle="modal"
                                data-target="#addBankAccountModal">
                                <i class="fas fa-plus mr-1"></i> Créer un compte bancaire
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- =========================================================
                 OPÉRATIONS RÉCENTES + ALERTES
            ========================================================== -->
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="bank-card">
                        <div class="bank-card-header">
                            <div>
                                <h5 class="bank-card-title"><i class="fas fa-exchange-alt"></i> Opérations bancaires
                                    récentes</h5>
                                <span class="bank-card-subtitle">
                                    <?= min(count($recentBankOperations ?? []), (int) ($bankOperationsCount ?? 0)) ?>
                                    sur <?= (int) ($bankOperationsCount ?? 0) ?> opération(s).
                                </span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table bank-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Référence</th>
                                        <th>Compte</th>
                                        <th>Type</th>
                                        <th>Libellé</th>
                                        <th class="text-right">Montant</th>
                                        <th>Statut</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recentBankOperations)): ?>
                                        <?php foreach ($recentBankOperations as $op): ?>
                                            <?php
                                            $meta     = $operationTypes[$op->operation_type] ?? ['label' => $op->operation_type, 'badge' => 'transfer', 'icon' => 'fas fa-exchange-alt'];
                                            $isDebit  = in_array($op->operation_type, $debitTypes, true);
                                            $accName  = $isDebit ? $op->source_account_name : $op->destination_account_name;
                                            $accNum   = $isDebit ? $op->source_account_number : $op->destination_account_number;
                                            $opStatus = $operationStatusLabels[$op->status] ?? [$op->status, 'badge-light'];

                                            switch ($op->operation_type) {
                                                case 'transfert':
                                                    $subtitle = 'Vers : ' . ($op->destination_account_name ?: '—');
                                                    break;
                                                case 'retrait_banque':
                                                    $subtitle = 'Vers la caisse principale';
                                                    break;
                                                case 'versement_banque':
                                                    $subtitle = 'Depuis la caisse principale';
                                                    break;
                                                default:
                                                    $subtitle = !empty($op->third_party)
                                                        ? ($isDebit ? 'Bénéficiaire : ' : 'Provenance : ') . $op->third_party
                                                        : '';
                                            }
                                            ?>
                                            <tr class="<?= $op->status === 'cancelled' ? 'bank-row-cancelled' : '' ?>">
                                                <td>
                                                    <?= date('d/m/Y', strtotime($op->operation_date)) ?>
                                                    <small
                                                        class="d-block text-muted"><?= date('H:i', strtotime($op->created_at)) ?></small>
                                                </td>
                                                <td><strong><?= html_escape($op->reference) ?></strong></td>
                                                <td>
                                                    <strong><?= html_escape($accName ?: '—') ?></strong>
                                                    <small class="d-block text-muted"><?= html_escape($accNum ?: '') ?></small>
                                                </td>
                                                <td>
                                                    <span class="bank-op-badge <?= $meta['badge'] ?>">
                                                        <i
                                                            class="<?= $meta['icon'] ?> mr-1"></i><?= html_escape($meta['label']) ?>
                                                    </span>
                                                </td>
                                                <td class="bank-strike">
                                                    <strong><?= html_escape($op->label) ?></strong>
                                                    <?php if ($subtitle !== ''): ?>
                                                        <small class="d-block text-muted"><?= html_escape($subtitle) ?></small>
                                                    <?php endif; ?>
                                                    <?php if (!empty($op->document_number)): ?>
                                                        <small class="d-block text-muted">Pièce :
                                                            <?= html_escape($op->document_number) ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-right bank-strike">
                                                    <span class="<?= $isDebit ? 'bank-amount-out' : 'bank-amount-in' ?>">
                                                        <?= $isDebit ? '-' : '+' ?>
                                                        <?= bankAmount($op->amount, $op->currency) ?>
                                                    </span>
                                                </td>
                                                <td><span
                                                        class="badge <?= $opStatus[1] ?>"><?= html_escape($opStatus[0]) ?></span>
                                                </td>
                                                <td class="text-center text-nowrap">
                                                    <button type="button" class="bank-btn-icon" title="Voir"
                                                        onclick="viewBankOperation(<?= (int) $op->id ?>)"><i
                                                            class="fas fa-eye"></i></button>
                                                    <?php if (!empty($op->attachment)): ?>
                                                        <a href="<?= base_url('uploads/finance/bank_operations/' . rawurlencode($op->attachment)) ?>"
                                                            target="_blank" class="bank-btn-icon" title="Pièce justificative"><i
                                                                class="fas fa-paperclip"></i></a>
                                                    <?php endif; ?>
                                                    <?php if ($op->status === 'pending'): ?>
                                                        <button type="button" class="bank-btn-icon is-success" title="Valider"
                                                            onclick="validateBankOperation(<?= (int) $op->id ?>, <?= html_escape(json_encode($op->reference)) ?>)"><i
                                                                class="fas fa-check"></i></button>
                                                    <?php endif; ?>
                                                    <?php if ($op->status !== 'cancelled'): ?>
                                                        <button type="button" class="bank-btn-icon is-danger" title="Annuler"
                                                            onclick="cancelBankOperation(<?= (int) $op->id ?>, <?= html_escape(json_encode($op->reference)) ?>, <?= $op->status === 'validated' ? 'true' : 'false' ?>)"><i
                                                                class="fas fa-ban"></i></button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8">
                                                <div class="bank-empty"><i class="fas fa-exchange-alt"></i>Aucune opération
                                                    bancaire enregistrée.</div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4">
                    <div class="bank-card">
                        <div class="bank-card-header">
                            <div>
                                <h5 class="bank-card-title"><i class="fas fa-exclamation-triangle"></i> Alertes
                                    bancaires</h5>
                                <span class="bank-card-subtitle">Situations à vérifier.</span>
                            </div>
                            <span
                                class="badge <?= ($bankAlertsCount ?? 0) > 0 ? 'badge-danger' : 'badge-success' ?>"><?= (int) ($bankAlertsCount ?? 0) ?></span>
                        </div>
                        <div class="bank-card-body">
                            <?php if (!empty($bankAlerts)): ?>
                                <?php foreach ($bankAlerts as $alert): ?>
                                    <div
                                        class="bank-alert <?= in_array($alert['type'], ['danger', 'warning', 'info'], true) ? $alert['type'] : 'info' ?>">
                                        <div class="bank-alert-icon"><i class="<?= html_escape($alert['icon']) ?>"></i></div>
                                        <div>
                                            <h6><?= html_escape($alert['title']) ?></h6>
                                            <p><?= html_escape($alert['description']) ?></p>
                                            <?php if (!empty($alert['operation_id'])): ?>
                                                <button type="button" class="btn btn-sm btn-bank-outline mt-2"
                                                    onclick="viewBankOperation(<?= (int) $alert['operation_id'] ?>)">
                                                    <i class="fas fa-eye mr-1"></i> Voir l’opération
                                                </button>
                                            <?php elseif (!empty($alert['account_id'])): ?>
                                                <button type="button" class="btn btn-sm btn-bank-outline mt-2"
                                                    onclick="viewBankAccount(<?= (int) $alert['account_id'] ?>)">
                                                    <i class="fas fa-university mr-1"></i> Voir le compte
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="bank-empty"><i class="fas fa-check-circle text-success"></i>Aucune anomalie
                                    détectée.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <a href="<?= base_url('banque-livre') ?>" class="btn btn-bank-outline btn-sm">
                <i class="fas fa-book mr-1"></i> Livre de banque
            </a>

        </div>
    </section>
</div>

<!-- =========================================================
     MODALE : CRÉER UN COMPTE
========================================================== -->
<div class="modal fade modal-bank" id="addBankAccountModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="<?= base_url('bank-account-store') ?>" method="post" class="w-100" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-university mr-2"></i> Créer un compte bancaire</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Code (automatique)</label>
                            <input type="text" class="form-control"
                                value="<?= html_escape($nextBankAccountCode ?? '') ?>" readonly>
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Intitulé du compte <span class="required-star">*</span></label>
                            <input type="text" name="name" class="form-control" maxlength="150" required
                                value="<?= $oldValue($oldAccount, 'name') ?>"
                                placeholder="Ex. CRDB — Compte courant BIF">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Banque <span class="required-star">*</span></label>
                            <select name="bank_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                <?php foreach ($banks as $bank): ?>
                                    <option value="<?= (int) $bank->id ?>"
                                        <?= (string) ($oldAccount['bank_id'] ?? '') === (string) $bank->id ? 'selected' : '' ?>>
                                        <?= html_escape($bank->code) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Numéro de compte <span class="required-star">*</span></label>
                            <input type="text" name="account_number" class="form-control" maxlength="100" required
                                value="<?= $oldValue($oldAccount, 'account_number') ?>"
                                placeholder="Numéro officiel du compte">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Type de compte <span class="required-star">*</span></label>
                            <select name="account_type" class="form-control" required>
                                <?php foreach ($accountTypeLabels as $key => $label): ?>
                                    <option value="<?= $key ?>"
                                        <?= ($oldAccount['account_type'] ?? 'courant') === $key ? 'selected' : '' ?>>
                                        <?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Devise <span class="required-star">*</span></label>
                            <select name="currency" class="form-control" required>
                                <?php foreach (['BIF', 'USD', 'EUR'] as $cur): ?>
                                    <option value="<?= $cur ?>"
                                        <?= ($oldAccount['currency'] ?? 'BIF') === $cur ? 'selected' : '' ?>><?= $cur ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Date d’ouverture <span class="required-star">*</span></label>
                            <input type="date" name="opening_date" class="form-control" max="<?= date('Y-m-d') ?>"
                                required value="<?= $oldValue($oldAccount, 'opening_date', date('Y-m-d')) ?>">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Solde initial</label>
                            <input type="number" name="opening_balance" class="form-control" min="0" step="0.01"
                                value="<?= $oldValue($oldAccount, 'opening_balance', '0') ?>">
                            <small class="text-muted">Première ligne du livre de banque.</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Découvert autorisé</label>
                            <input type="number" name="overdraft_limit" class="form-control" min="0" step="0.01"
                                value="<?= $oldValue($oldAccount, 'overdraft_limit', '0') ?>">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Seuil d’alerte</label>
                            <input type="number" name="alert_threshold" class="form-control" min="0" step="0.01"
                                value="<?= $oldValue($oldAccount, 'alert_threshold', '0') ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Agence</label>
                            <input type="text" name="branch_name" class="form-control" maxlength="150"
                                value="<?= $oldValue($oldAccount, 'branch_name') ?>"
                                placeholder="Ex. Agence siège Bujumbura">
                        </div>
                        <div class="col-md-12 form-group mb-0">
                            <label>Observation</label>
                            <textarea name="observation" class="form-control"
                                rows="2"><?= $oldValue($oldAccount, 'observation') ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-bank-outline" data-dismiss="modal"><i
                            class="fas fa-times mr-1"></i> Annuler</button>
                    <button type="submit" class="btn btn-bank-primary"><i class="fas fa-save mr-1"></i> Enregistrer le
                        compte</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
     MODALE : MODIFIER UN COMPTE
========================================================== -->
<div class="modal fade modal-bank" id="editBankAccountModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="<?= base_url('bank-account-update') ?>" method="post" class="w-100" id="editBankAccountForm"
            autocomplete="off">
            <input type="hidden" name="id">
            <input type="hidden" name="accounting_account_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit mr-2"></i> Modifier le compte</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="bank-info-box mb-3" id="editBankAccountInfo"></div>
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <label>Intitulé du compte <span class="required-star">*</span></label>
                            <input type="text" name="name" class="form-control" maxlength="150" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Statut <span class="required-star">*</span></label>
                            <select name="status" class="form-control" required>
                                <?php foreach ($accountStatusLabels as $key => $statusLabel): ?>
                                    <option value="<?= $key ?>"><?= $statusLabel[0] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Agence</label>
                            <input type="text" name="branch_name" class="form-control" maxlength="150">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Découvert autorisé</label>
                            <input type="number" name="overdraft_limit" class="form-control" min="0" step="0.01">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Seuil d’alerte</label>
                            <input type="number" name="alert_threshold" class="form-control" min="0" step="0.01">
                        </div>
                        <div class="col-md-12 form-group mb-0">
                            <label>Observation</label>
                            <textarea name="observation" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <small class="text-muted d-block mt-2">
                        Les soldes ne se modifient jamais ici : ils proviennent uniquement du livre de banque.
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-bank-outline" data-dismiss="modal"><i
                            class="fas fa-times mr-1"></i> Annuler</button>
                    <button type="submit" class="btn btn-bank-primary"><i class="fas fa-save mr-1"></i>
                        Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
     MODALE : OPÉRATION BANCAIRE
========================================================== -->
<div class="modal fade modal-bank" id="bankOperationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <form action="<?= base_url('bank-operation-store') ?>" method="post" enctype="multipart/form-data"
            id="bankOperationForm" class="w-100" autocomplete="off">
            <input type="hidden" name="operation_type" id="bankOperationType">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exchange-alt mr-2"></i> <span
                            id="bankOperationTitle">Opération bancaire</span></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Référence (automatique)</label>
                            <input type="text" class="form-control"
                                value="<?= html_escape($nextBankOperationReference ?? '') ?>" readonly>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Date de l’opération <span class="required-star">*</span></label>
                            <input type="date" name="operation_date" class="form-control" max="<?= date('Y-m-d') ?>"
                                value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Date de valeur</label>
                            <input type="date" name="value_date" class="form-control">
                        </div>

                        <div class="col-md-6 form-group">
                            <label id="bankAccountLabel">Compte <span class="required-star">*</span></label>
                            <select name="bank_account_id" id="bankAccountSelect" class="form-control" required>
                                <option value="">Sélectionner le compte</option>
                                <?php foreach ($allBankAccounts as $account): ?>
                                    <option value="<?= (int) $account->id ?>"
                                        data-currency="<?= html_escape($account->currency) ?>"
                                        data-balance="<?= (float) $account->current_balance ?>"
                                        data-overdraft="<?= (float) $account->overdraft_limit ?>">
                                        <?= html_escape($account->code . ' — ' . $account->name . ' (' . $account->bank_name . ')') ?>
                                        — <?= bankAmount($account->current_balance, $account->currency) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="bank-info-box" id="bankAvailableBox" style="display:none"></div>
                        </div>

                        <div class="col-md-6 form-group" id="bankDestinationField" style="display:none">
                            <label>Compte destination <span class="required-star">*</span></label>
                            <select name="destination_bank_account_id" id="bankDestinationAccount" class="form-control"
                                disabled>
                                <option value="">Sélectionner la destination</option>
                                <?php foreach ($allBankAccounts as $account): ?>
                                    <option value="<?= (int) $account->id ?>"
                                        data-currency="<?= html_escape($account->currency) ?>">
                                        <?= html_escape($account->code . ' — ' . $account->name . ' (' . $account->currency . ')') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Même devise que le compte source.</small>
                        </div>

                        <div class="col-md-6 form-group" id="bankCashboxField" style="display:none">
                            <label>Caisse principale</label>
                            <div class="bank-info-box mt-0" id="bankCashboxInfo">
                                <?php if ($principalCashbox): ?>
                                    <strong><?= html_escape($principalCashbox->code . ' — ' . $principalCashbox->name) ?></strong><br>
                                    Solde : <?= bankAmount($principalCashbox->current_balance, $principalCashbox->devise) ?>
                                <?php else: ?>
                                    Aucune caisse principale active.
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Montant <span class="required-star">*</span></label>
                            <div class="input-group">
                                <input type="number" name="amount" id="bankOperationAmount" class="form-control"
                                    min="0.01" step="0.01" required>
                                <div class="input-group-append"><span class="input-group-text"
                                        id="bankOperationCurrency">BIF</span></div>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Mode d’opération <span class="required-star">*</span></label>
                            <select name="payment_method" class="form-control" required>
                                <?php foreach ($paymentMethods as $key => $label): ?>
                                    <option value="<?= $key ?>"><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Catégorie</label>
                            <select name="category" class="form-control">
                                <option value="">Sélectionner</option>
                                <?php foreach ($categories as $key => $label): ?>
                                    <option value="<?= $key ?>"><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Tiers / Bénéficiaire</label>
                            <input type="text" name="third_party" class="form-control" maxlength="255"
                                placeholder="Client, fournisseur, banque…">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>N° de pièce</label>
                            <input type="text" name="document_number" class="form-control" maxlength="100"
                                placeholder="Chèque, bordereau, avis…">
                        </div>

                        <style>
                            /* ---------------------------------------------------------------------
 * CHAMPS FICHIER (module banque uniquement : .bank-file-field)
 * ------------------------------------------------------------------- */
                            .bank-file-field .custom-file-label {
                                overflow: hidden;
                                padding-right: 105px;
                                white-space: nowrap;
                                text-overflow: ellipsis;
                                color: #64748b;
                                font-weight: 500;
                            }

                            /* Bouton « Parcourir » (data-browse) — !important pour passer devant Bootstrap */
                            .bank-file-field .custom-file-label::after {
                                content: attr(data-browse) !important;
                                color: #0f766e;
                                font-weight: 700;
                                background: #f0fdfa;
                            }

                            /* Fichier sélectionné */
                            .bank-file-field.has-file .custom-file-label {
                                color: #0f766e;
                                font-weight: 700;
                                border-color: #99d5ce;
                                background: #f8fffd;
                            }

                            /* Fichier refusé */
                            .bank-file-field.has-error .custom-file-label {
                                border-color: #dc2626;
                            }

                            .bank-file-feedback {
                                display: flex;
                                flex-wrap: wrap;
                                align-items: center;
                                justify-content: space-between;
                                gap: 6px;
                                margin-top: 5px;
                            }

                            .bank-file-hint {
                                color: #94a3b8;
                                font-size: 10px;
                            }

                            .bank-file-clear {
                                padding: 0;
                                color: #dc2626;
                                border: 0;
                                background: none;
                                font-size: 11px;
                                font-weight: 700;
                                cursor: pointer;
                            }

                            .bank-file-clear:hover {
                                text-decoration: underline;
                            }

                            .bank-file-error {
                                width: 100%;
                                color: #dc2626;
                                font-size: 11px;
                                font-weight: 600;
                            }
                        </style>

                        <div class="col-md-4 form-group bank-file-field">
                            <label for="bankAttachment">Pièce justificative</label>
                            <div class="custom-file">
                                <input type="file" name="attachment" class="custom-file-input" id="bankAttachment"
                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx" data-max-size="5242880">
                                <label class="custom-file-label" for="bankAttachment" data-browse="Parcourir">Choisir un
                                    fichier</label>
                            </div>
                            <div class="bank-file-feedback">
                                <small class="bank-file-hint">PDF, image, Word ou Excel — 5 Mo maximum.</small>
                                <button type="button" class="bank-file-clear" style="display:none">
                                    <i class="fas fa-times mr-1"></i>Retirer
                                </button>
                                <small class="bank-file-error" style="display:none"></small>
                            </div>
                        </div>


                        <!-- Champs fichier du module banque (autonome, sans dépendance) -->
                        <script>
                            (function() {
                                'use strict';

                                var ALLOWED_EXTENSIONS = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx'];
                                var INPUT_SELECTOR = '.bank-file-field .custom-file-input';

                                function formatSize(bytes) {
                                    if (bytes >= 1048576) return (bytes / 1048576).toFixed(1).replace('.', ',') + ' Mo';
                                    if (bytes >= 1024) return Math.round(bytes / 1024) + ' Ko';
                                    return bytes + ' o';
                                }

                                function getParts(input) {
                                    var field = input.closest('.bank-file-field');

                                    return {
                                        field: field,
                                        label: field.querySelector('.custom-file-label'),
                                        hint: field.querySelector('.bank-file-hint'),
                                        clear: field.querySelector('.bank-file-clear'),
                                        error: field.querySelector('.bank-file-error')
                                    };
                                }

                                function showError(parts, message) {
                                    parts.field.classList.add('has-error');
                                    parts.error.textContent = message;
                                    parts.error.style.display = '';
                                }

                                function clearError(parts) {
                                    parts.field.classList.remove('has-error');
                                    parts.error.textContent = '';
                                    parts.error.style.display = 'none';
                                }

                                function refresh(input) {
                                    var parts = getParts(input);

                                    /* Mémoriser le texte d'origine du label (une seule fois) */
                                    if (!parts.label.hasAttribute('data-default')) {
                                        parts.label.setAttribute('data-default', parts.label.textContent.trim() ||
                                            'Choisir un fichier');
                                    }

                                    var file = input.files && input.files[0];

                                    /* Aucun fichier : état initial */
                                    if (!file) {
                                        parts.label.textContent = parts.label.getAttribute('data-default');
                                        parts.label.removeAttribute('title');
                                        parts.field.classList.remove('has-file');
                                        parts.clear.style.display = 'none';
                                        parts.hint.style.display = '';
                                        return;
                                    }

                                    clearError(parts);

                                    /* Contrôle de l'extension */
                                    var extension = file.name.split('.').pop().toLowerCase();

                                    if (ALLOWED_EXTENSIONS.indexOf(extension) === -1) {
                                        input.value = '';
                                        refresh(input);
                                        showError(parts, 'Format non autorisé (.' + extension +
                                            '). Formats acceptés : PDF, JPG, PNG, Word, Excel.');
                                        return;
                                    }

                                    /* Contrôle de la taille */
                                    var maxSize = parseInt(input.getAttribute('data-max-size'), 10) || 5242880;

                                    if (file.size > maxSize) {
                                        input.value = '';
                                        refresh(input);
                                        showError(parts, 'Fichier trop volumineux (' + formatSize(file.size) +
                                            '). Taille maximale : ' + formatSize(maxSize) + '.');
                                        return;
                                    }

                                    /* Fichier valide */
                                    parts.label.textContent = file.name + ' (' + formatSize(file.size) + ')';
                                    parts.label.setAttribute('title', file.name);
                                    parts.field.classList.add('has-file');
                                    parts.clear.style.display = '';
                                    parts.hint.style.display = 'none';
                                }

                                /* Sélection d'un fichier */
                                document.addEventListener('change', function(event) {
                                    if (event.target.matches(INPUT_SELECTOR)) {
                                        refresh(event.target);
                                    }
                                });

                                /* Bouton « Retirer » */
                                document.addEventListener('click', function(event) {
                                    var button = event.target.closest('.bank-file-clear');

                                    if (!button) {
                                        return;
                                    }

                                    var input = button.closest('.bank-file-field').querySelector(
                                        '.custom-file-input');

                                    input.value = '';
                                    clearError(getParts(input));
                                    refresh(input);
                                });

                                /* form.reset() : remettre les champs fichier à l'état initial */
                                document.addEventListener('reset', function(event) {
                                    var form = event.target;

                                    setTimeout(function() {
                                        form.querySelectorAll(INPUT_SELECTOR).forEach(function(input) {
                                            clearError(getParts(input));
                                            refresh(input);
                                        });
                                    }, 0);
                                }, true);
                            })();
                        </script>

                        <div class="col-md-12 form-group">
                            <label>Libellé <span class="required-star">*</span></label>
                            <input type="text" name="label" class="form-control" maxlength="255" required
                                placeholder="Libellé tel qu’il apparaîtra dans le livre de banque">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Observation</label>
                            <textarea name="observation" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-md-12">
                            <div class="bank-warning-box mb-2" id="bankOperationWarning" style="display:none"></div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bankSaveAsPending"
                                    name="save_as_pending" value="1">
                                <label class="custom-control-label" for="bankSaveAsPending">
                                    Enregistrer en attente de validation (le livre de banque ne sera pas modifié)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-bank-outline" data-dismiss="modal"><i
                            class="fas fa-times mr-1"></i> Annuler</button>
                    <button type="submit" class="btn btn-bank-primary" id="bankOperationSubmit"><i
                            class="fas fa-check-circle mr-1"></i> Enregistrer l’opération</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
     MODALE : DÉTAIL (compte ou opération)
========================================================== -->
<div class="modal fade modal-bank" id="bankDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle mr-2"></i> <span id="bankDetailTitle">Détail</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" id="bankDetailBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-bank-outline" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================
     SCRIPTS
========================================================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /* ---------------- Configuration ---------------- */
    const BANK_URLS = {
        accountView: <?= json_encode(base_url('bank-account-view'), $jsonFlags) ?>,
        operationView: <?= json_encode(base_url('bank-operation-view'), $jsonFlags) ?>,
        operationValidate: <?= json_encode(base_url('bank-operation-validate'), $jsonFlags) ?>,
        operationCancel: <?= json_encode(base_url('bank-operation-cancel'), $jsonFlags) ?>
    };

    const BANK_TODAY = <?= json_encode(date('Y-m-d')) ?>;
    let bankCsrf = {
        name: <?= json_encode($this->security->get_csrf_token_name()) ?>,
        hash: <?= json_encode($this->security->get_csrf_hash()) ?>
    };

    const BANK_CASHBOX = <?= json_encode($principalCashbox ? [
                                'name'    => $principalCashbox->code . ' — ' . $principalCashbox->name,
                                'devise'  => $principalCashbox->devise,
                                'balance' => (float) $principalCashbox->current_balance,
                            ] : null, $jsonFlags) ?>;

    const BANK_OLD_OPERATION = <?= json_encode($oldOperation, $jsonFlags) ?>;
    const BANK_REOPEN_ACCOUNT = <?= $reopenAccountModal ? 'true' : 'false' ?>;
    const BANK_REOPEN_OPERATION = <?= $reopenOperationModal ? 'true' : 'false' ?>;

    const BANK_OPERATION_CONFIG = {
        encaissement: {
            title: 'Encaissement bancaire',
            account: 'Compte à créditer',
            debit: false,
            method: 'virement',
            category: 'paiement_client'
        },
        decaissement: {
            title: 'Décaissement bancaire',
            account: 'Compte à débiter',
            debit: true,
            method: 'virement',
            category: 'fournisseur'
        },
        transfert: {
            title: 'Transfert entre comptes bancaires',
            account: 'Compte source',
            debit: true,
            method: 'virement',
            category: 'transfert',
            destination: true,
            label: 'Transfert entre comptes'
        },
        retrait_banque: {
            title: 'Retrait bancaire vers la caisse principale',
            account: 'Compte à débiter',
            debit: true,
            method: 'retrait_especes',
            category: 'transfert',
            cashbox: true,
            label: 'Retrait d’espèces pour la caisse principale'
        },
        versement_banque: {
            title: 'Versement de la caisse principale en banque',
            account: 'Compte à créditer',
            debit: false,
            method: 'versement_especes',
            category: 'transfert',
            cashbox: true,
            label: 'Versement des espèces de la caisse principale'
        },
        frais_bancaires: {
            title: 'Frais bancaires',
            account: 'Compte débité',
            debit: true,
            method: 'prelevement',
            category: 'frais',
            label: 'Frais bancaires'
        },
        interets_crediteurs: {
            title: 'Intérêts créditeurs',
            account: 'Compte crédité',
            debit: false,
            method: 'virement',
            category: 'autre',
            label: 'Intérêts créditeurs'
        }
    };

    const BANK_TYPES = <?= json_encode(array_map(function ($t) {
                            return $t['label'];
                        }, $operationTypes), $jsonFlags) ?>;
    const BANK_ACCOUNT_TYPES = <?= json_encode($accountTypeLabels, $jsonFlags) ?>;
    const BANK_ACCOUNT_STATUS = <?= json_encode(array_map(function ($s) {
                                    return $s[0];
                                }, $accountStatusLabels), $jsonFlags) ?>;
    const BANK_OPERATION_STATUS = <?= json_encode(array_map(function ($s) {
                                        return $s[0];
                                    }, $operationStatusLabels), $jsonFlags) ?>;
    const BANK_METHODS = <?= json_encode($paymentMethods, $jsonFlags) ?>;
    const BANK_NATURES = {
        solde_initial: 'Solde initial',
        encaissement: 'Encaissement',
        decaissement: 'Décaissement',
        transfert_entrant: 'Transfert entrant',
        transfert_sortant: 'Transfert sortant',
        retrait_banque: 'Retrait vers caisse',
        versement_banque: 'Versement depuis caisse',
        frais_bancaires: 'Frais bancaires',
        interets_crediteurs: 'Intérêts créditeurs',
        contre_passation: 'Contre-passation'
    };

    /* ---------------- Utilitaires ---------------- */
    function bankEsc(value) {
        return $('<div>').text(value === null || value === undefined ? '' : String(value)).html();
    }

    function bankFmt(amount, currency) {
        currency = currency || 'BIF';
        const digits = currency === 'BIF' ? 0 : 2;
        return new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: digits,
                maximumFractionDigits: digits
            })
            .format(parseFloat(amount || 0)) + ' ' + currency;
    }

    function bankDate(value) {
        if (!value) return '—';
        const parts = String(value).substring(0, 10).split('-');
        return parts.length === 3 ? parts[2] + '/' + parts[1] + '/' + parts[0] : value;
    }

    function bankDetailTable(rows) {
        return '<table class="table table-sm bank-detail-table mb-0"><tbody>' +
            rows.map(function(row) {
                return '<tr><th>' + bankEsc(row[0]) + '</th><td>' + (row[2] ? row[1] : bankEsc(row[1])) + '</td></tr>';
            }).join('') +
            '</tbody></table>';
    }

    function showBankDetail(title, html) {
        $('#bankDetailTitle').text(title);
        $('#bankDetailBody').html(html);
        $('#bankDetailModal').modal('show');
    }

    function bankAjaxError(xhr) {
        const message = (xhr && xhr.responseJSON && xhr.responseJSON.message) || 'Erreur de communication avec le serveur.';
        Swal.fire({
            icon: 'error',
            title: 'Action impossible',
            text: message,
            confirmButtonColor: '#dc2626'
        });
    }

    function bankPost(url, data) {
        data[bankCsrf.name] = bankCsrf.hash;
        return $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json'
        });
    }

    /* ---------------- Opération : préparation du formulaire ---------------- */
    function openBankOperation(type) {
        prepareBankOperation(type, false);
        $('#bankOperationModal').modal('show');
    }

    function prepareBankOperation(type, keepValues) {
        const cfg = BANK_OPERATION_CONFIG[type];
        if (!cfg) return;

        const form = document.getElementById('bankOperationForm');

        if (!keepValues) {
            form.reset();
            $(form).find('[name="operation_date"]').val(BANK_TODAY);
            $(form).find('.custom-file-label').text('Choisir un fichier');
            $(form).find('[name="payment_method"]').val(cfg.method);
            $(form).find('[name="category"]').val(cfg.category || '');
            $(form).find('[name="label"]').val(cfg.label || '');
        }

        $('#bankOperationType').val(type);
        $('#bankOperationTitle').text(cfg.title);
        $('#bankAccountLabel').html(bankEsc(cfg.account) + ' <span class="required-star">*</span>');

        $('#bankDestinationField').toggle(!!cfg.destination);
        $('#bankDestinationAccount').prop('disabled', !cfg.destination).prop('required', !!cfg.destination);
        $('#bankCashboxField').toggle(!!cfg.cashbox);

        refreshBankOperationInfo();
    }

    function refreshBankOperationInfo() {
        const type = $('#bankOperationType').val();
        const cfg = BANK_OPERATION_CONFIG[type] || {};
        const $option = $('#bankAccountSelect option:selected');
        const accountId = $option.val();
        const currency = $option.data('currency') || 'BIF';
        const balance = parseFloat($option.data('balance') || 0);
        const overdraft = parseFloat($option.data('overdraft') || 0);
        const amount = parseFloat($('#bankOperationAmount').val() || 0);
        let warning = '';

        $('#bankOperationCurrency').text(currency);

        if (accountId) {
            $('#bankAvailableBox').show().html(
                'Solde : <strong>' + bankFmt(balance, currency) + '</strong>' +
                (overdraft > 0 ? ' — découvert autorisé : ' + bankFmt(overdraft, currency) : '')
            );
        } else {
            $('#bankAvailableBox').hide();
        }

        if (cfg.debit && accountId && amount > balance + overdraft) {
            warning = 'Le montant dépasse le disponible du compte (' + bankFmt(balance + overdraft, currency) + ').';
        }

        if (cfg.destination) {
            $('#bankDestinationAccount option').each(function() {
                if (!this.value) return;
                const invalid = this.value === accountId || (accountId && $(this).data('currency') !== currency);
                $(this).prop('disabled', invalid);
                if (invalid && this.selected) $('#bankDestinationAccount').val('');
            });
        }

        if (cfg.cashbox) {
            if (!BANK_CASHBOX) {
                warning = 'Aucune caisse principale active : cette opération est impossible.';
            } else if (accountId && BANK_CASHBOX.devise !== currency) {
                warning = 'La caisse principale est en ' + BANK_CASHBOX.devise +
                    ' : choisissez un compte dans la même devise.';
            } else if (type === 'versement_banque' && amount > BANK_CASHBOX.balance) {
                warning = 'Le montant dépasse le solde de la caisse principale (' + bankFmt(BANK_CASHBOX.balance,
                    BANK_CASHBOX.devise) + ').';
            }
        }

        $('#bankOperationWarning').toggle(!!warning).text(warning);
        $('#bankOperationSubmit').prop('disabled', !!warning);
    }

    /* ---------------- Comptes : voir / modifier ---------------- */
    function viewBankAccount(id) {
        $.getJSON(BANK_URLS.accountView + '/' + id).done(function(response) {
            const a = response.data;

            showBankDetail('Compte ' + a.code, bankDetailTable([
                ['Intitulé', a.name],
                ['Banque', a.bank_name],
                ['Numéro de compte', a.account_number],
                ['Type', BANK_ACCOUNT_TYPES[a.account_type] || a.account_type],
                ['Devise', a.currency],
                ['Agence', a.branch_name || '—'],
                ['Date d’ouverture', bankDate(a.opening_date)],
                ['Solde initial', bankFmt(a.opening_balance, a.currency)],
                ['Solde actuel', '<strong>' + bankEsc(bankFmt(a.current_balance, a.currency)) +
                    '</strong>', true
                ],
                ['Découvert autorisé', bankFmt(a.overdraft_limit, a.currency)],
                ['Seuil d’alerte', bankFmt(a.alert_threshold, a.currency)],
                ['Dernier rapprochement', a.last_reconciled_date ? bankDate(a.last_reconciled_date) :
                    'Jamais'
                ],
                ['Statut', BANK_ACCOUNT_STATUS[a.status] || a.status],
                ['Observation', a.observation || '—']
            ]));
        }).fail(bankAjaxError);
    }

    function editBankAccount(id) {
        $.getJSON(BANK_URLS.accountView + '/' + id).done(function(response) {
            const a = response.data;
            const $form = $('#editBankAccountForm');

            ['id', 'name', 'status', 'branch_name', 'overdraft_limit', 'alert_threshold', 'accounting_account_id',
                'observation'
            ]
            .forEach(function(field) {
                $form.find('[name="' + field + '"]').val(a[field] === null ? '' : a[field]);
            });

            $('#editBankAccountInfo').html(
                '<strong>' + bankEsc(a.code) + '</strong> — ' + bankEsc(a.bank_name) + ' — ' +
                bankEsc(a.account_number) + ' (' + bankEsc(a.currency) + ') — solde ' + bankEsc(bankFmt(a
                    .current_balance, a.currency))
            );

            $('#editBankAccountModal').modal('show');
        }).fail(bankAjaxError);
    }

    /* ---------------- Opérations : voir / valider / annuler ---------------- */
    function viewBankOperation(id) {
        $.getJSON(BANK_URLS.operationView + '/' + id).done(function(response) {
            const o = response.data;

            let html = bankDetailTable([
                ['Type', BANK_TYPES[o.operation_type] || o.operation_type],
                ['Statut', BANK_OPERATION_STATUS[o.status] || o.status],
                ['Date / date de valeur', bankDate(o.operation_date) + ' / ' + bankDate(o.value_date)],
                ['Montant', '<strong>' + bankEsc(bankFmt(o.amount, o.currency)) + '</strong>', true],
                ['Compte débité', o.source_account_name ? o.source_account_code + ' — ' + o
                    .source_account_name : '—'
                ],
                ['Compte crédité', o.destination_account_name ? o.destination_account_code + ' — ' + o
                    .destination_account_name : '—'
                ],
                ['Caisse liée', o.cash_movement_reference || '—'],
                ['Mode', BANK_METHODS[o.payment_method] || o.payment_method],
                ['Tiers', o.third_party || '—'],
                ['N° de pièce', o.document_number || '—'],
                ['Libellé', o.label],
                ['Observation', o.observation || '—'],
                ['Créée par', (o.created_by_name || '—') + ' le ' + bankDate(o.created_at)],
                ['Validée par', o.validated_by_name ? o.validated_by_name + ' le ' + bankDate(o
                    .validated_at) : '—'],
                ['Annulation', o.cancel_reason ? bankDate(o.cancelled_at) + ' — ' + o.cancel_reason : '—']
            ]);

            const movements = (o.movements || []).map(function(m) {
                const isIn = m.sens === 'entree';
                return '<tr>' +
                    '<td>' + bankEsc(m.reference) + '</td>' +
                    '<td>' + bankDate(m.movement_date) + '</td>' +
                    '<td>' + bankEsc(m.account_code + ' — ' + m.account_name) + '</td>' +
                    '<td>' + bankEsc(BANK_NATURES[m.nature] || m.nature) + '</td>' +
                    '<td class="text-right ' + (isIn ? 'bank-amount-in">+ ' : 'bank-amount-out">- ') +
                    bankEsc(bankFmt(m.amount, m.currency)) + '</td>' +
                    '<td class="text-right">' + bankEsc(bankFmt(m.balance_after, m.currency)) + '</td>' +
                    '</tr>';
            }).join('');

            html += '<h6 class="mt-4 mb-2 font-weight-bold">Lignes du livre de banque</h6>';
            html += movements ?
                '<div class="table-responsive"><table class="table table-sm bank-table"><thead><tr><th>Réf.</th><th>Date</th><th>Compte</th><th>Nature</th><th class="text-right">Montant</th><th class="text-right">Solde après</th></tr></thead><tbody>' +
                movements + '</tbody></table></div>' :
                '<p class="text-muted mb-0">Aucune ligne au livre (opération en attente ou annulée avant validation).</p>';

            showBankDetail('Opération ' + o.reference, html);
        }).fail(bankAjaxError);
    }

    function validateBankOperation(id, reference) {
        Swal.fire({
            icon: 'question',
            title: 'Valider ' + reference + ' ?',
            text: 'L’opération sera inscrite au livre de banque et les soldes seront mis à jour.',
            showCancelButton: true,
            confirmButtonText: 'Valider',
            cancelButtonText: 'Fermer',
            confirmButtonColor: '#0f766e'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            bankPost(BANK_URLS.operationValidate, {
                    operation_id: id
                })
                .done(function(response) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Opération validée',
                            text: response.message,
                            confirmButtonColor: '#0f766e'
                        })
                        .then(function() {
                            window.location.reload();
                        });
                })
                .fail(bankAjaxError);
        });
    }

    function cancelBankOperation(id, reference, isValidated) {
        Swal.fire({
            icon: 'warning',
            title: 'Annuler ' + reference + ' ?',
            text: isValidated ?
                'L’opération sera contre-passée dans le livre de banque (et dans la caisse si elle y est liée).' : 'L’opération en attente sera simplement annulée.',
            input: 'textarea',
            inputPlaceholder: 'Motif de l’annulation…',
            inputValidator: function(value) {
                return !value || !value.trim() ? 'Le motif est obligatoire.' : undefined;
            },
            showCancelButton: true,
            confirmButtonText: 'Annuler l’opération',
            cancelButtonText: 'Fermer',
            confirmButtonColor: '#dc2626'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            bankPost(BANK_URLS.operationCancel, {
                    operation_id: id,
                    cancel_reason: result.value
                })
                .done(function(response) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Opération annulée',
                            text: response.message,
                            confirmButtonColor: '#0f766e'
                        })
                        .then(function() {
                            window.location.reload();
                        });
                })
                .fail(bankAjaxError);
        });
    }

    /* ---------------- Initialisation ---------------- */
    $(function() {
        /* Jeton CSRF renouvelé après chaque appel AJAX */
        $(document).ajaxComplete(function(event, xhr) {
            if (xhr.responseJSON && xhr.responseJSON.csrf_hash) {
                bankCsrf.hash = xhr.responseJSON.csrf_hash;
            }
        });

        $('#bankAccountSelect, #bankOperationAmount').on('change input', refreshBankOperationInfo);

        $(document).on('change', '.custom-file-input', function() {
            $(this).next('.custom-file-label').text($(this).val().split('\\').pop() ||
                'Choisir un fichier');
        });

        /* Réouverture des modales après une erreur, saisie conservée */
        if (BANK_REOPEN_ACCOUNT) {
            $('#addBankAccountModal').modal('show');
        }

        if (BANK_REOPEN_OPERATION && BANK_OLD_OPERATION && BANK_OLD_OPERATION.operation_type) {
            prepareBankOperation(BANK_OLD_OPERATION.operation_type, true);

            $.each(BANK_OLD_OPERATION, function(field, value) {
                if (field === 'operation_type') return;
                $('#bankOperationForm [name="' + field + '"]').not('[type="file"], [type="checkbox"]').val(
                    value);
            });

            $('#bankSaveAsPending').prop('checked', !!BANK_OLD_OPERATION.save_as_pending);
            refreshBankOperationInfo();
            $('#bankOperationModal').modal('show');
        }

        /* Graphique */
        const chartElement = document.getElementById('bankFlowChart');

        if (chartElement && typeof Chart !== 'undefined') {
            const currency = <?= json_encode($currency) ?>;

            new Chart(chartElement.getContext('2d'), {
                type: 'line',
                data: {
                    labels: <?= json_encode($flow['labels'] ?? [], $jsonFlags) ?>,
                    datasets: [{
                        label: 'Entrées',
                        data: <?= json_encode(array_map('floatval', $flow['incomes'] ?? [])) ?>,
                        borderColor: '#0f766e',
                        backgroundColor: 'rgba(15,118,110,.12)',
                        borderWidth: 2.5,
                        pointRadius: 3,
                        fill: true,
                        tension: .35
                    }, {
                        label: 'Sorties',
                        data: <?= json_encode(array_map('floatval', $flow['expenses'] ?? [])) ?>,
                        borderColor: '#dc2626',
                        backgroundColor: 'rgba(220,38,38,.08)',
                        borderWidth: 2.5,
                        pointRadius: 3,
                        fill: true,
                        tension: .35
                    }]
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
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    return ctx.dataset.label + ' : ' + bankFmt(ctx.parsed.y, currency);
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
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 15
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(148,163,184,.15)'
                            },
                            ticks: {
                                callback: function(v) {
                                    if (v >= 1e9) return (v / 1e9) + ' Md';
                                    if (v >= 1e6) return (v / 1e6) + ' M';
                                    if (v >= 1e3) return (v / 1e3) + ' K';
                                    return v;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>

<?php if ($flashSuccess || $flashError): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: <?= json_encode($flashError ? 'error' : 'success') ?>,
                title: <?= json_encode($flashError ? 'Action impossible' : 'Succès', JSON_UNESCAPED_UNICODE) ?>,
                html: <?= json_encode($flashError ?: $flashSuccess, $jsonFlags) ?>,
                confirmButtonText: 'D’accord',
                confirmButtonColor: <?= json_encode($flashError ? '#dc2626' : '#0f766e') ?>
            });
        });
    </script>
<?php endif; ?>