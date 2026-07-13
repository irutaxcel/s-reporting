<?php

if (!function_exists('formatCompactAmount')) {

    function formatCompactAmount($amount)
    {
        $amount = (float) $amount;

        if ($amount >= 1000000000) {
            return number_format(
                $amount / 1000000000,
                1,
                ',',
                ' '
            ) . ' Md';
        }

        if ($amount >= 1000000) {
            return number_format(
                $amount / 1000000,
                1,
                ',',
                ' '
            ) . ' M';
        }

        if ($amount >= 1000) {
            return number_format(
                $amount / 1000,
                1,
                ',',
                ' '
            ) . ' K';
        }

        return number_format(
            $amount,
            0,
            ',',
            ' '
        );
    }
}

?>

<?php

if (!function_exists('formatCashboxAmount')) {
    function formatCashboxAmount($amount): string
    {
        return number_format(
            (float) $amount,
            0,
            ',',
            ' '
        );
    }
}

if (!function_exists('formatCashboxDate')) {
    function formatCashboxDate($date): string
    {
        if (empty($date)) {
            return '—';
        }

        return date(
            'd/m/Y',
            strtotime($date)
        );
    }
}

if (!function_exists('formatCashboxTime')) {
    function formatCashboxTime($datetime): string
    {
        if (empty($datetime)) {
            return '';
        }

        return date(
            'H:i',
            strtotime($datetime)
        );
    }
}

?>

<?php

if (!function_exists('formatCashboxAmount')) {
    function formatCashboxAmount($amount): string
    {
        return number_format(
            (float) $amount,
            0,
            ',',
            ' '
        );
    }
}

?>

<?php

/*
 * Valeurs par défaut afin d’éviter les erreurs
 * si aucune caisse n’existe encore.
 */
$mainStats = isset($cashboxMainStatistics)
    && is_array($cashboxMainStatistics)
    ? $cashboxMainStatistics
    : [];

$statsCurrency = !empty($mainStats['currency'])
    ? $mainStats['currency']
    : 'BIF';

$globalBalance = isset(
    $mainStats['global_balance']
)
    ? (float) $mainStats['global_balance']
    : 0;

$globalVariation = isset(
    $mainStats['global_variation_percentage']
)
    ? (float) $mainStats['global_variation_percentage']
    : 0;

$headOfficeBalance = isset(
    $mainStats['head_office_balance']
)
    ? (float) $mainStats['head_office_balance']
    : 0;

$headOfficeCount = isset(
    $mainStats['head_office_count']
)
    ? (int) $mainStats['head_office_count']
    : 0;

$headOfficePercentage = isset(
    $mainStats['head_office_percentage']
)
    ? (float) $mainStats['head_office_percentage']
    : 0;

$constructionBalance = isset(
    $mainStats['construction_balance']
)
    ? (float) $mainStats['construction_balance']
    : 0;

$constructionCount = isset(
    $mainStats['construction_count']
)
    ? (int) $mainStats['construction_count']
    : 0;

$constructionPercentage = isset(
    $mainStats['construction_percentage']
)
    ? (float) $mainStats['construction_percentage']
    : 0;

$todayDisbursementAmount = isset(
    $mainStats['today_disbursement_amount']
)
    ? (float) $mainStats['today_disbursement_amount']
    : 0;

$todayDisbursementCount = isset(
    $mainStats['today_disbursement_count']
)
    ? (int) $mainStats['today_disbursement_count']
    : 0;

/*
 * Apparence de la variation.
 */
$variationClass = 'badge-neutral';
$variationIcon = 'fas fa-minus';
$variationPrefix = '';

if ($globalVariation > 0) {
    $variationClass = 'badge-positive';
    $variationIcon = 'fas fa-arrow-up';
    $variationPrefix = '+';
} elseif ($globalVariation < 0) {
    $variationClass = 'badge-negative';
    $variationIcon = 'fas fa-arrow-down';
}

/*
 * Texte de disponibilité de la caisse siège.
 */
$headOfficeAvailabilityLabel =
    $headOfficeBalance > 0
    ? 'Disponible'
    : 'Solde nul';

/*
 * Badge de décaissement.
 */
$disbursementBadgeClass =
    $todayDisbursementCount > 0
    ? 'badge-negative'
    : 'badge-neutral';

?>
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

        .cash-status-active {
            color: #15803d;
            background: #dcfce7;
        }

        .cash-status-danger {
            color: #b91c1c;
            background: #fee2e2;
        }

        .cash-status-warning {
            color: #b45309;
            background: #fef3c7;
        }

        .cash-status-warning {
            color: #b45309;
            background: #fef3c7;
        }

        .cash-box-name {
            display: flex;
            align-items: center;
            min-width: 0;
        }

        .cash-box-name>div:last-child {
            min-width: 0;
        }

        .cash-box-name h6 {
            max-width: 175px;
            margin: 0 0 3px;
            overflow: hidden;
            color: var(--caisse-secondary);
            font-size: 13px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cash-box-code {
            max-width: 175px;
            overflow: hidden;
            color: var(--caisse-muted);
            font-size: 10px;
            font-weight: 600;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }

    /* =====================================================
   PRINCIPALES DÉPENSES
===================================================== */

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
        background: linear-gradient(90deg,
                #14b8a6,
                #0f766e);
        transition: width .35s ease;
    }

    /* =====================================================
   SYNTHÈSE PAR CHANTIER
===================================================== */

    .caisse-summary-table-wrapper {
        max-height: 430px;
        overflow-x: auto;
        overflow-y: auto;
    }

    .caisse-summary-table-wrapper thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #f8fafc;
    }

    .caisse-summary-table-wrapper tbody td:first-child strong {
        display: block;
        max-width: 210px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .caisse-summary-table-wrapper .progress {
        height: 7px;
        overflow: hidden;
        border-radius: 20px;
        background: #e5e7eb;
    }

    .caisse-summary-table-wrapper .progress-bar {
        border-radius: 20px;
        transition: width .35s ease;
    }

    /* =====================================================
   RÉSUMÉ DU GRAPHIQUE
===================================================== */

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

    /* =====================================================
   ALERTES
===================================================== */

    .treasury-alerts-wrapper {
        max-height: 410px;
        overflow-y: auto;
    }

    .treasury-alert-content {
        min-width: 0;
    }

    .treasury-alert-content h6 {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .treasury-empty-alert {
        padding: 30px 15px;
        text-align: center;
    }

    .treasury-empty-alert-icon {
        margin-bottom: 12px;
        color: #16a34a;
        font-size: 44px;
    }

    .treasury-empty-alert h6 {
        margin-bottom: 7px;
        color: #102033;
        font-size: 14px;
        font-weight: 800;
    }

    .treasury-empty-alert p {
        max-width: 300px;
        margin: auto;
        color: #64748b;
        font-size: 10px;
        line-height: 1.6;
    }

    @media (max-width: 767px) {
        .cashflow-summary {
            grid-template-columns: 1fr;
        }

        .cashflow-chart-wrapper {
            height: 260px;
        }
    }

    /* =====================================================
   FILTRES DES CAISSES
===================================================== */

    .caisse-filter-box {
        margin-bottom: 22px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
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
        box-shadow:
            0 0 0 .15rem rgba(15, 118, 110, .13);
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
    }

    .caisse-filter-box button.input-group-text:hover {
        color: #ffffff;
        border-color: #0f766e;
        background: #0f766e;
    }

    .cashbox-filter-actions {
        display: flex;
        align-items: center;
        min-height: 40px;
    }

    /* =====================================================
   FILTRES ACTIFS
===================================================== */

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

    @media (max-width: 991px) {
        .caisse-filter-box .form-group {
            margin-bottom: 13px !important;
        }

        .cashbox-filter-actions {
            margin-top: 2px;
        }
    }

    @media (max-width: 575px) {
        .cashbox-filter-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px;
        }

        .cashbox-filter-actions .btn {
            margin-right: 0 !important;
        }

        .cashbox-filter-results {
            width: 100%;
            margin-left: 0;
            text-align: center;
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

                <!-- =================================================
         SOLDE GLOBAL DISPONIBLE
    ================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="caisse-stat-card">

                        <div class="caisse-stat-top">

                            <div class="caisse-stat-icon icon-green">

                                <i class="fas fa-wallet"></i>

                            </div>

                            <span class="
                        caisse-stat-badge
                        <?= html_escape(
                            $variationClass
                        ) ?>
                    " title="Évolution depuis le début du mois">

                                <i class="
                            <?= html_escape(
                                $variationIcon
                            ) ?>
                            mr-1
                        "></i>

                                <?= $variationPrefix ?>

                                <?= number_format(
                                    abs($globalVariation),
                                    1,
                                    ',',
                                    ' '
                                ) ?>

                                %

                            </span>

                        </div>

                        <div class="caisse-stat-label">

                            Solde global disponible

                        </div>

                        <div class="caisse-stat-value">

                            <?= number_format(
                                $globalBalance,
                                0,
                                ',',
                                ' '
                            ) ?>

                            <?= html_escape(
                                $statsCurrency
                            ) ?>

                        </div>

                        <div class="caisse-stat-footer">

                            Toutes les caisses actives confondues

                        </div>

                    </div>

                </div>

                <!-- =================================================
         CAISSE SIÈGE
    ================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="caisse-stat-card">

                        <div class="caisse-stat-top">

                            <div class="caisse-stat-icon icon-blue">

                                <i class="fas fa-building"></i>

                            </div>

                            <span class="
                        caisse-stat-badge
                        badge-neutral
                    ">

                                <?= html_escape(
                                    $headOfficeAvailabilityLabel
                                ) ?>

                            </span>

                        </div>

                        <div class="caisse-stat-label">

                            Caisse siège

                            <?php if ($headOfficeCount > 1): ?>

                                <small class="ml-1 text-muted" style="
                            font-size: 8px;
                            text-transform: none;
                        ">
                                    (<?= $headOfficeCount ?> caisses)
                                </small>

                            <?php endif; ?>

                        </div>

                        <div class="caisse-stat-value">

                            <?= number_format(
                                $headOfficeBalance,
                                0,
                                ',',
                                ' '
                            ) ?>

                            <?= html_escape(
                                $statsCurrency
                            ) ?>

                        </div>

                        <div class="caisse-stat-footer">

                            <?= number_format(
                                $headOfficePercentage,
                                2,
                                ',',
                                ' '
                            ) ?>

                            % du solde global

                        </div>

                    </div>

                </div>

                <!-- =================================================
         CAISSES CHANTIERS
    ================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="caisse-stat-card">

                        <div class="caisse-stat-top">

                            <div class="caisse-stat-icon icon-orange">

                                <i class="fas fa-hard-hat"></i>

                            </div>

                            <span class="
                        caisse-stat-badge
                        badge-neutral
                    ">

                                <?= $constructionCount ?>

                                caisse<?= $constructionCount > 1
                                            ? 's'
                                            : ''
                                        ?>

                            </span>

                        </div>

                        <div class="caisse-stat-label">

                            Caisses chantiers

                        </div>

                        <div class="caisse-stat-value">

                            <?= number_format(
                                $constructionBalance,
                                0,
                                ',',
                                ' '
                            ) ?>

                            <?= html_escape(
                                $statsCurrency
                            ) ?>

                        </div>

                        <div class="caisse-stat-footer">

                            <?= number_format(
                                $constructionPercentage,
                                2,
                                ',',
                                ' '
                            ) ?>

                            % du solde global sur les chantiers actifs

                        </div>

                    </div>

                </div>

                <!-- =================================================
         DÉCAISSEMENTS DU JOUR
    ================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="caisse-stat-card">

                        <div class="caisse-stat-top">

                            <div class="caisse-stat-icon icon-red">

                                <i class="fas fa-arrow-up"></i>

                            </div>

                            <span class="
                        caisse-stat-badge
                        <?= html_escape(
                            $disbursementBadgeClass
                        ) ?>
                    ">

                                <?= $todayDisbursementCount ?>

                                opération<?= $todayDisbursementCount > 1
                                                ? 's'
                                                : ''
                                            ?>

                            </span>

                        </div>

                        <div class="caisse-stat-label">

                            Décaissements du jour

                        </div>

                        <div class="caisse-stat-value">

                            <?= number_format(
                                $todayDisbursementAmount,
                                0,
                                ',',
                                ' '
                            ) ?>

                            <?= html_escape(
                                $statsCurrency
                            ) ?>

                        </div>

                        <div class="caisse-stat-footer">

                            <?php if (
                                $todayDisbursementCount > 0
                            ): ?>

                                Sorties validées enregistrées aujourd’hui

                            <?php else: ?>

                                Aucun décaissement validé aujourd’hui

                            <?php endif; ?>

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
     GRAPHIQUE + ALERTES DE TRÉSORERIE
================================================== -->
            <div class="row">

                <!-- =================================================
         ÉVOLUTION DE LA TRÉSORERIE
    ================================================== -->
                <div class="col-xl-8 col-lg-8">

                    <div class="caisse-card">

                        <div class="caisse-card-header">

                            <div>

                                <h5 class="caisse-card-title">

                                    <i class="fas fa-chart-line"></i>

                                    Évolution de la trésorerie des caisses

                                </h5>

                                <span class="caisse-card-subtitle">

                                    Comparaison des encaissements et
                                    décaissements sur la période sélectionnée.

                                </span>

                            </div>

                            <form action="<?= current_url() ?>" method="get" id="cashFlowPeriodForm">

                                <select name="cashflow_period" id="cashFlowPeriod" class="form-control form-control-sm"
                                    style="
                            width: 165px;
                            border-radius: 8px;
                        " onchange="
                            document
                                .getElementById(
                                    'cashFlowPeriodForm'
                                )
                                .submit();
                        ">

                                    <option value="7days" <?= $cashFlowPeriod === '7days'
                                                                ? 'selected'
                                                                : ''
                                                            ?>>
                                        7 derniers jours
                                    </option>

                                    <option value="30days" <?= $cashFlowPeriod === '30days'
                                                                ? 'selected'
                                                                : ''
                                                            ?>>
                                        30 derniers jours
                                    </option>

                                    <option value="month" <?= $cashFlowPeriod === 'month'
                                                                ? 'selected'
                                                                : ''
                                                            ?>>
                                        Ce mois
                                    </option>

                                    <option value="year" <?= $cashFlowPeriod === 'year'
                                                                ? 'selected'
                                                                : ''
                                                            ?>>
                                        Cette année
                                    </option>

                                </select>

                            </form>

                        </div>

                        <div class="caisse-card-body">

                            <?php

                            $totalCashFlowIncome = array_sum(
                                $cashFlowEvolution['incomes']
                            );

                            $totalCashFlowExpense = array_sum(
                                $cashFlowEvolution['expenses']
                            );

                            $cashFlowNet =
                                $totalCashFlowIncome
                                - $totalCashFlowExpense;

                            ?>

                            <!-- Résumé de la période -->
                            <div class="cashflow-summary">

                                <div class="cashflow-summary-item">

                                    <span>
                                        Encaissements
                                    </span>

                                    <strong class="text-success">

                                        + <?= number_format(
                                                $totalCashFlowIncome,
                                                0,
                                                ',',
                                                ' '
                                            ) ?>

                                        BIF

                                    </strong>

                                </div>

                                <div class="cashflow-summary-item">

                                    <span>
                                        Décaissements
                                    </span>

                                    <strong class="text-danger">

                                        - <?= number_format(
                                                $totalCashFlowExpense,
                                                0,
                                                ',',
                                                ' '
                                            ) ?>

                                        BIF

                                    </strong>

                                </div>

                                <div class="cashflow-summary-item">

                                    <span>
                                        Flux net
                                    </span>

                                    <strong class="<?= $cashFlowNet >= 0
                                                        ? 'text-success'
                                                        : 'text-danger'
                                                    ?>">

                                        <?= $cashFlowNet >= 0
                                            ? '+ '
                                            : '- '
                                        ?>

                                        <?= number_format(
                                            abs($cashFlowNet),
                                            0,
                                            ',',
                                            ' '
                                        ) ?>

                                        BIF

                                    </strong>

                                </div>

                            </div>

                            <div class="cashflow-chart-wrapper">

                                <canvas id="cashFlowChart"></canvas>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- =================================================
         ALERTES DE TRÉSORERIE
    ================================================== -->
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

                            <?php if ($treasuryAlertsCount > 0): ?>

                                <span class="badge badge-danger">

                                    <?= (int) $treasuryAlertsCount ?>

                                    alerte<?= $treasuryAlertsCount > 1
                                                ? 's'
                                                : ''
                                            ?>

                                </span>

                            <?php else: ?>

                                <span class="badge badge-success">

                                    Aucune alerte

                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="caisse-card-body treasury-alerts-wrapper">

                            <?php if (!empty($treasuryAlerts)): ?>

                                <?php foreach (
                                    $treasuryAlerts as $alert
                                ): ?>

                                    <?php

                                    $alertClass =
                                        'alert-info-soft';

                                    if ($alert['type'] === 'danger') {
                                        $alertClass =
                                            'alert-danger-soft';
                                    } elseif (
                                        $alert['type'] === 'warning'
                                    ) {
                                        $alertClass =
                                            'alert-warning-soft';
                                    }

                                    ?>

                                    <div class="
                                treasury-alert
                                <?= html_escape($alertClass) ?>
                            ">

                                        <div class="treasury-alert-icon">

                                            <i class="<?= html_escape(
                                                            $alert['icon']
                                                        ) ?>"></i>

                                        </div>

                                        <div class="treasury-alert-content">

                                            <h6>

                                                <?= html_escape(
                                                    $alert['title']
                                                ) ?>

                                            </h6>

                                            <p>

                                                <?= html_escape(
                                                    $alert['message']
                                                ) ?>

                                            </p>

                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <div class="treasury-empty-alert">

                                    <div class="treasury-empty-alert-icon">

                                        <i class="fas fa-check-circle"></i>

                                    </div>

                                    <h6>
                                        Trésorerie sous contrôle
                                    </h6>

                                    <p>

                                        Aucun solde critique, aucune opération
                                        en attente et aucun justificatif
                                        manquant n’a été détecté.

                                    </p>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

            <?php

            /*
 * Valeurs par défaut des filtres.
 */
            $cashboxFilters = isset($cashboxFilters)
                && is_array($cashboxFilters)
                ? $cashboxFilters
                : [];

            $filterSearch = isset(
                $cashboxFilters['search']
            )
                ? (string) $cashboxFilters['search']
                : '';

            $filterType = isset(
                $cashboxFilters['type']
            )
                ? (string) $cashboxFilters['type']
                : '';

            $filterChantierId = isset(
                $cashboxFilters['chantier_id']
            )
                ? (int) $cashboxFilters['chantier_id']
                : 0;

            $filterSituation = isset(
                $cashboxFilters['situation']
            )
                ? (string) $cashboxFilters['situation']
                : '';

            ?>

            <!-- =================================================
     FILTRES DES CAISSES
================================================== -->
            <div class="caisse-filter-box">

                <form action="<?= current_url() ?>" method="get" id="cashboxFilterForm">

                    <?php if (
                        !empty($cashFlowPeriod)
                    ): ?>

                        <!--
                Conserver le filtre du graphique lorsque
                les filtres de caisse sont appliqués.
            -->
                        <input type="hidden" name="cashflow_period" value="<?= html_escape(
                                                                                $cashFlowPeriod
                                                                            ) ?>">

                    <?php endif; ?>

                    <div class="row align-items-end">

                        <!-- =========================================
                 RECHERCHE
            ========================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label for="cashboxSearch">

                                    Rechercher une caisse

                                </label>

                                <div class="input-group">

                                    <input type="text" name="cashbox_search" id="cashboxSearch" class="form-control"
                                        value="<?= html_escape(
                                                    $filterSearch
                                                ) ?>" placeholder="Code, nom ou chantier..." autocomplete="off">

                                    <div class="input-group-append">

                                        <button type="submit" class="input-group-text" title="Rechercher" style="
                                    border-radius:
                                    0 8px 8px 0;
                                    cursor: pointer;
                                ">

                                            <i class="fas fa-search"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- =========================================
                 TYPE DE CAISSE
            ========================================== -->
                        <div class="col-xl-2 col-lg-2 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label for="cashboxTypeFilter">

                                    Type de caisse

                                </label>

                                <select name="cashbox_type" id="cashboxTypeFilter" class="form-control">

                                    <option value="">
                                        Toutes
                                    </option>

                                    <option value="siege" <?= $filterType === 'siege'
                                                                ? 'selected'
                                                                : ''
                                                            ?>>
                                        Caisse siège
                                    </option>

                                    <option value="chantier" <?= $filterType === 'chantier'
                                                                    ? 'selected'
                                                                    : ''
                                                                ?>>
                                        Caisse chantier
                                    </option>

                                </select>

                            </div>

                        </div>

                        <!-- =========================================
                 CHANTIER
            ========================================== -->
                        <div class="col-xl-2 col-lg-2 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label for="cashboxChantierFilter">

                                    Chantier

                                </label>

                                <select name="chantier_id" id="cashboxChantierFilter" class="form-control">

                                    <option value="">
                                        Tous les chantiers
                                    </option>

                                    <?php if (!empty($allChantiers)): ?>

                                        <?php foreach (
                                            $allChantiers as $chantier
                                        ): ?>

                                            <option value="<?= (int) $chantier->id ?>" <?= $filterChantierId
                                                                                            === (int) $chantier->id
                                                                                            ? 'selected'
                                                                                            : ''
                                                                                        ?>>

                                                <?= html_escape(
                                                    $chantier->name
                                                ) ?>

                                                <?php if (
                                                    !empty($chantier->ref_chantier)
                                                ): ?>

                                                    —
                                                    <?= html_escape(
                                                        $chantier
                                                            ->ref_chantier
                                                    ) ?>

                                                <?php endif; ?>

                                            </option>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </select>

                            </div>

                        </div>

                        <!-- =========================================
                 SITUATION
            ========================================== -->
                        <div class="col-xl-2 col-lg-2 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label for="cashboxSituationFilter">

                                    Situation

                                </label>

                                <select name="cashbox_situation" id="cashboxSituationFilter" class="form-control">

                                    <option value="">
                                        Toutes
                                    </option>

                                    <option value="normal" <?= $filterSituation === 'normal'
                                                                ? 'selected'
                                                                : ''
                                                            ?>>
                                        Solde normal
                                    </option>

                                    <option value="faible" <?= $filterSituation === 'faible'
                                                                ? 'selected'
                                                                : ''
                                                            ?>>
                                        Seuil faible
                                    </option>

                                    <option value="critique" <?= $filterSituation === 'critique'
                                                                    ? 'selected'
                                                                    : ''
                                                                ?>>
                                        Solde critique
                                    </option>

                                </select>

                            </div>

                        </div>

                        <!-- =========================================
                 ACTIONS
            ========================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-12">

                            <div class="cashbox-filter-actions">

                                <button type="submit" class="
                            btn
                            btn-caisse-primary
                            mr-1
                        ">

                                    <i class="fas fa-filter mr-1"></i>

                                    Appliquer

                                </button>

                                <a href="<?= current_url() ?><?= !empty($cashFlowPeriod)
                                                                    ? '?cashflow_period='
                                                                    . rawurlencode(
                                                                        $cashFlowPeriod
                                                                    )
                                                                    : ''
                                                                ?>" class="btn btn-caisse-outline">

                                    <i class="fas fa-redo mr-1"></i>

                                    Réinitialiser

                                </a>

                            </div>

                        </div>

                    </div>

                    <!-- =============================================
             RÉSUMÉ DES FILTRES ACTIFS
        ============================================== -->
                    <?php

                    $hasActiveCashboxFilter =
                        $filterSearch !== ''
                        || $filterType !== ''
                        || $filterChantierId > 0
                        || $filterSituation !== '';

                    ?>

                    <?php if ($hasActiveCashboxFilter): ?>

                        <div class="cashbox-active-filters">

                            <span class="cashbox-active-filters-label">

                                <i class="fas fa-filter mr-1"></i>

                                Filtres actifs :

                            </span>

                            <?php if ($filterSearch !== ''): ?>

                                <span class="cashbox-filter-tag">

                                    Recherche :

                                    <strong>
                                        <?= html_escape(
                                            $filterSearch
                                        ) ?>
                                    </strong>

                                </span>

                            <?php endif; ?>

                            <?php if ($filterType !== ''): ?>

                                <span class="cashbox-filter-tag">

                                    Type :

                                    <strong>

                                        <?= $filterType === 'siege'
                                            ? 'Caisse siège'
                                            : 'Caisse chantier'
                                        ?>

                                    </strong>

                                </span>

                            <?php endif; ?>

                            <?php if ($filterChantierId > 0): ?>

                                <?php

                                $selectedChantierName =
                                    'Chantier sélectionné';

                                foreach (
                                    $allChantiers as $chantier
                                ) {
                                    if (
                                        (int) $chantier->id
                                        === $filterChantierId
                                    ) {
                                        $selectedChantierName =
                                            $chantier->name;

                                        break;
                                    }
                                }

                                ?>

                                <span class="cashbox-filter-tag">

                                    Chantier :

                                    <strong>

                                        <?= html_escape(
                                            $selectedChantierName
                                        ) ?>

                                    </strong>

                                </span>

                            <?php endif; ?>

                            <?php if ($filterSituation !== ''): ?>

                                <span class="cashbox-filter-tag">

                                    Situation :

                                    <strong>

                                        <?php

                                        $situationLabels = [
                                            'normal' =>
                                            'Solde normal',

                                            'faible' =>
                                            'Seuil faible',

                                            'critique' =>
                                            'Solde critique',
                                        ];

                                        echo html_escape(
                                            $situationLabels[$filterSituation] ?? $filterSituation
                                        );

                                        ?>

                                    </strong>

                                </span>

                            <?php endif; ?>

                            <span class="cashbox-filter-results">

                                <?= (int) $filteredCashboxesCount ?>

                                résultat<?= $filteredCashboxesCount > 1
                                            ? 's'
                                            : ''
                                        ?>

                            </span>

                        </div>

                    <?php endif; ?>

                </form>

            </div>

            <!-- =================================================
     SITUATION DES CAISSES
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

                    <?php

                    $hasCashboxFilters =
                        !empty($cashboxFilters['search'])
                        || !empty($cashboxFilters['type'])
                        || !empty($cashboxFilters['chantier_id'])
                        || !empty($cashboxFilters['situation']);

                    ?>

                    <span class="badge <?= $hasCashboxFilters
                                            ? 'badge-info'
                                            : 'badge-success'
                                        ?>">

                        <?php if ($hasCashboxFilters): ?>

                            <?= (int) $filteredCashboxesCount ?>

                            résultat<?= $filteredCashboxesCount > 1
                                        ? 's'
                                        : ''
                                    ?>

                            sur

                            <?= (int) $activeCashboxesCount ?>

                        <?php else: ?>

                            <?= (int) $activeCashboxesCount ?>

                            caisse<?= $activeCashboxesCount > 1
                                        ? 's'
                                        : ''
                                    ?>

                            active<?= $activeCashboxesCount > 1
                                        ? 's'
                                        : ''
                                    ?>

                        <?php endif; ?>

                    </span>

                </div>

                <div class="caisse-card-body pb-2">

                    <?php if (!empty($cashboxSituations)): ?>

                        <div class="row">

                            <?php foreach ($cashboxSituations as $cashbox): ?>

                                <?php

                                /*
                     * =================================================
                     * DÉTERMINATION DU STATUT DU SOLDE
                     * =================================================
                     */

                                $currentBalance = (float) $cashbox->current_balance;
                                $openingBalance = (float) $cashbox->opening_balance;
                                $alertThreshold = (float) $cashbox->alert_threshold;

                                $statusLabel = 'Normal';
                                $statusClass = 'cash-status-active';
                                $progressColor = '';
                                $iconClass = 'fas fa-hard-hat';

                                /*
                     * Icône différente pour la caisse siège.
                     */
                                if ($cashbox->type === 'siege') {
                                    $iconClass = 'fas fa-building';
                                }

                                /*
                     * Solde critique :
                     * solde inférieur ou égal au seuil d’alerte.
                     */
                                if (
                                    $alertThreshold > 0
                                    && $currentBalance <= $alertThreshold
                                ) {
                                    $statusLabel = 'Critique';
                                    $statusClass = 'cash-status-danger';
                                    $progressColor = '#dc2626';
                                }

                                /*
                     * Solde faible :
                     * supérieur au seuil mais inférieur au double.
                     */ elseif (
                                    $alertThreshold > 0
                                    && $currentBalance <= ($alertThreshold * 2)
                                ) {
                                    $statusLabel = 'Faible';
                                    $statusClass = 'cash-status-warning';
                                    $progressColor = '#f59e0b';
                                }

                                /*
                     * =================================================
                     * CALCUL DU POURCENTAGE DE LA BARRE
                     * =================================================
                     *
                     * On utilise comme référence :
                     * - le solde initial s’il est supérieur à zéro ;
                     * - sinon 5 fois le seuil d’alerte ;
                     * - sinon le solde courant ;
                     * - sinon 1 pour éviter une division par zéro.
                     */

                                $referenceBalance = $openingBalance;

                                if ($referenceBalance <= 0) {
                                    $referenceBalance = $alertThreshold * 5;
                                }

                                if ($referenceBalance <= 0) {
                                    $referenceBalance = $currentBalance;
                                }

                                if ($referenceBalance <= 0) {
                                    $referenceBalance = 1;
                                }

                                $progressPercentage = (
                                    $currentBalance / $referenceBalance
                                ) * 100;

                                /*
                     * Limiter la barre entre 0 % et 100 %.
                     */
                                $progressPercentage = max(
                                    0,
                                    min(
                                        100,
                                        $progressPercentage
                                    )
                                );

                                /*
                     * Pour qu’un faible montant reste visible.
                     */
                                if (
                                    $currentBalance > 0
                                    && $progressPercentage < 4
                                ) {
                                    $progressPercentage = 4;
                                }

                                /*
                     * Nom à afficher.
                     */
                                $displayName = $cashbox->name;

                                if (
                                    $cashbox->type === 'chantier'
                                    && !empty($cashbox->chantier_name)
                                ) {
                                    $displayName = $cashbox->chantier_name;
                                }

                                ?>

                                <div class="col-xl-3 col-lg-4 col-md-6">

                                    <div class="cash-box">

                                        <!-- En-tête de la carte -->
                                        <div class="cash-box-top">

                                            <div class="cash-box-name">

                                                <div class="cash-box-icon">

                                                    <i class="<?= $iconClass ?>"></i>

                                                </div>

                                                <div>

                                                    <h6 title="<?= html_escape($cashbox->name) ?>">

                                                        <?= html_escape($displayName) ?>

                                                    </h6>

                                                    <div class="cash-box-code">

                                                        <?= html_escape($cashbox->code) ?>

                                                        <?php if (
                                                            !empty($cashbox->ref_chantier)
                                                            && $cashbox->type === 'chantier'
                                                        ): ?>

                                                            <span class="ml-1">

                                                                · <?= html_escape(
                                                                        $cashbox->ref_chantier
                                                                    ) ?>

                                                            </span>

                                                        <?php endif; ?>

                                                    </div>

                                                </div>

                                            </div>

                                            <span class="cash-status <?= $statusClass ?>">

                                                <?= $statusLabel ?>

                                            </span>

                                        </div>

                                        <!-- Solde -->
                                        <div class="cash-box-balance">

                                            <span>
                                                Solde disponible
                                            </span>

                                            <strong>

                                                <?= number_format(
                                                    $currentBalance,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) ?>

                                                <?= html_escape($cashbox->devise) ?>

                                            </strong>

                                        </div>

                                        <!-- Barre de niveau -->
                                        <div class="cash-progress">

                                            <div class="cash-progress-bar" style="
                                        width:
                                        <?= number_format(
                                            $progressPercentage,
                                            2,
                                            '.',
                                            ''
                                        ) ?>%;

                                        <?= $progressColor !== ''
                                            ? 'background: '
                                            . $progressColor
                                            . ';'
                                            : ''
                                        ?>
                                    "></div>

                                        </div>

                                        <!-- Statistiques mensuelles -->
                                        <div class="cash-box-footer">

                                            <div class="cash-box-footer-item">

                                                <span>
                                                    Entrées mois
                                                </span>

                                                <strong>

                                                    <?= formatCompactAmount(
                                                        $cashbox->monthly_entries
                                                    ) ?>

                                                </strong>

                                            </div>

                                            <div class="cash-box-footer-item">

                                                <span>
                                                    Sorties mois
                                                </span>

                                                <strong>

                                                    <?= formatCompactAmount(
                                                        $cashbox->monthly_outputs
                                                    ) ?>

                                                </strong>

                                            </div>

                                            <div class="cash-box-footer-item">

                                                <span>
                                                    Opérations
                                                </span>

                                                <strong>

                                                    <?= (int) $cashbox
                                                        ->monthly_operations ?>

                                                </strong>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php else: ?>

                        <div class="text-center py-5">

                            <div class="mb-3" style="
                        font-size: 45px;
                        color: #cbd5e1;
                    ">

                                <i class="fas fa-wallet"></i>

                            </div>

                            <h5 style="
                        color: #334155;
                        font-weight: 800;
                    ">

                                Aucune caisse disponible

                            </h5>

                            <p class="text-muted">

                                Créez une caisse siège ou une caisse chantier
                                pour commencer à enregistrer les opérations.

                            </p>

                            <button type="button" class="btn btn-caisse-primary" data-toggle="modal"
                                data-target="#addCaisseModal">

                                <i class="fas fa-plus mr-1"></i>

                                Créer une caisse

                            </button>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

            <!-- =================================================
     TABLEAU DES MOUVEMENTS RÉCENTS
================================================== -->
            <div class="caisse-card">

                <div class="caisse-card-header">

                    <div>

                        <h5 class="caisse-card-title">

                            <i class="fas fa-exchange-alt"></i>

                            Mouvements récents de caisse

                        </h5>

                        <span class="caisse-card-subtitle">

                            Derniers encaissements, décaissements
                            et transferts enregistrés.

                        </span>

                    </div>

                    <a href="<?= base_url(
                                    'finance/journal-caisse'
                                ) ?>" class="btn btn-caisse-outline">

                        <i class="fas fa-list mr-1"></i>

                        Voir tout le journal

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

                                <th class="text-right">
                                    Entrée
                                </th>

                                <th class="text-right">
                                    Sortie
                                </th>

                                <th class="text-right">
                                    Solde après
                                </th>

                                <th>Statut</th>

                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if (
                                !empty($recentCashboxMovements)
                            ): ?>

                                <?php foreach (
                                    $recentCashboxMovements as $index => $movement
                                ): ?>

                                    <?php

                                    /*
                         * =============================================
                         * TYPE D’OPÉRATION
                         * =============================================
                         */

                                    $typeLabel = 'Opération';
                                    $typeClass = 'badge-transfert';
                                    $typeIcon = 'fas fa-exchange-alt';

                                    $entryAmount = null;
                                    $outputAmount = null;

                                    if (
                                        $movement->operation_type
                                        === 'encaissement'
                                    ) {
                                        $typeLabel = 'Entrée';
                                        $typeClass = 'badge-entree';
                                        $typeIcon = 'fas fa-arrow-down';

                                        $entryAmount = (float) $movement->amount;
                                    } elseif (
                                        $movement->operation_type
                                        === 'decaissement'
                                    ) {
                                        $typeLabel = 'Sortie';
                                        $typeClass = 'badge-sortie';
                                        $typeIcon = 'fas fa-arrow-up';

                                        $outputAmount = (float) $movement->amount;
                                    } elseif (
                                        $movement->operation_type
                                        === 'approvisionnement'
                                    ) {
                                        $typeLabel = 'Transfert';
                                        $typeClass = 'badge-transfert';
                                        $typeIcon = 'fas fa-exchange-alt';

                                        /*
                             * Dans le tableau global, le transfert
                             * est vu depuis la caisse source.
                             */
                                        $outputAmount = (float) $movement->amount;
                                    }

                                    /*
                         * =============================================
                         * STATUT
                         * =============================================
                         */

                                    $statusLabel = ucfirst(
                                        $movement->status
                                    );

                                    $statusClass = 'badge-secondary';

                                    if (
                                        $movement->status
                                        === 'validated'
                                    ) {
                                        $statusLabel = 'Validé';
                                        $statusClass = 'badge-success';
                                    } elseif (
                                        $movement->status
                                        === 'pending'
                                    ) {
                                        $statusLabel = 'En attente';
                                        $statusClass = 'badge-warning';
                                    } elseif (
                                        $movement->status
                                        === 'cancelled'
                                    ) {
                                        $statusLabel = 'Annulé';
                                        $statusClass = 'badge-danger';
                                    }

                                    /*
                         * =============================================
                         * SOUS-LIBELLÉ
                         * =============================================
                         */

                                    $secondaryLabel = '';

                                    if (
                                        $movement->operation_type
                                        === 'encaissement'
                                    ) {
                                        if (
                                            !empty($movement->third_party)
                                        ) {
                                            $secondaryLabel =
                                                'Provenance : '
                                                . $movement->third_party;
                                        }
                                    } elseif (
                                        $movement->operation_type
                                        === 'decaissement'
                                    ) {
                                        if (
                                            !empty($movement->third_party)
                                        ) {
                                            $secondaryLabel =
                                                'Bénéficiaire : '
                                                . $movement->third_party;
                                        }
                                    } elseif (
                                        $movement->operation_type
                                        === 'approvisionnement'
                                    ) {
                                        $secondaryLabel =
                                            'Destination : '
                                            . (
                                                $movement
                                                ->destination_cashbox_name
                                                ?: 'Caisse destination'
                                            );
                                    }

                                    ?>

                                    <tr>

                                        <!-- Numéro -->
                                        <td>

                                            <?= $index + 1 ?>

                                        </td>

                                        <!-- Date -->
                                        <td>

                                            <?= formatCashboxDate(
                                                $movement->operation_date
                                            ) ?>

                                            <small class="d-block text-muted">

                                                <?= formatCashboxTime(
                                                    $movement->created_at
                                                ) ?>

                                            </small>

                                        </td>

                                        <!-- Référence -->
                                        <td>

                                            <span class="operation-reference">

                                                <?= html_escape(
                                                    $movement->reference
                                                ) ?>

                                            </span>

                                        </td>

                                        <!-- Caisse -->
                                        <td>

                                            <strong>

                                                <?= html_escape(
                                                    $movement->cashbox_name
                                                ) ?>

                                            </strong>

                                            <small class="d-block text-muted">

                                                <?= html_escape(
                                                    $movement->cashbox_code
                                                ) ?>

                                            </small>

                                        </td>

                                        <!-- Type -->
                                        <td>

                                            <span class="
                                        badge-operation
                                        <?= $typeClass ?>
                                    ">

                                                <i class="
                                            <?= $typeIcon ?>
                                            mr-1
                                        "></i>

                                                <?= $typeLabel ?>

                                            </span>

                                        </td>

                                        <!-- Libellé -->
                                        <td class="operation-label">

                                            <strong title="<?= html_escape(
                                                                $movement->label
                                                            ) ?>">

                                                <?= html_escape(
                                                    $movement->label
                                                ) ?>

                                            </strong>

                                            <?php if (
                                                $secondaryLabel !== ''
                                            ): ?>

                                                <small>

                                                    <?= html_escape(
                                                        $secondaryLabel
                                                    ) ?>

                                                </small>

                                            <?php elseif (
                                                !empty($movement->category)
                                            ): ?>

                                                <small>

                                                    Catégorie :
                                                    <?= html_escape(
                                                        $movement->category
                                                    ) ?>

                                                </small>

                                            <?php endif; ?>

                                        </td>

                                        <!-- Entrée -->
                                        <td class="
                                    text-right
                                    <?= $entryAmount !== null
                                        ? 'amount-in'
                                        : 'text-muted'
                                    ?>
                                ">

                                            <?php if (
                                                $entryAmount !== null
                                            ): ?>

                                                + <?= formatCashboxAmount(
                                                        $entryAmount
                                                    ) ?>

                                            <?php else: ?>

                                                —

                                            <?php endif; ?>

                                        </td>

                                        <!-- Sortie -->
                                        <td class="
                                    text-right
                                    <?= $outputAmount !== null
                                        ? 'amount-out'
                                        : 'text-muted'
                                    ?>
                                ">

                                            <?php if (
                                                $outputAmount !== null
                                            ): ?>

                                                - <?= formatCashboxAmount(
                                                        $outputAmount
                                                    ) ?>

                                            <?php else: ?>

                                                —

                                            <?php endif; ?>

                                        </td>

                                        <!-- Solde après -->
                                        <td class="text-right">

                                            <strong>

                                                <?= formatCashboxAmount(
                                                    $movement->balance_after
                                                ) ?>

                                            </strong>

                                            <small class="d-block text-muted">

                                                <?= html_escape(
                                                    $movement->currency
                                                ) ?>

                                            </small>

                                        </td>

                                        <!-- Statut -->
                                        <td>

                                            <span class="
                                        badge
                                        <?= $statusClass ?>
                                    ">

                                                <?= $statusLabel ?>

                                            </span>

                                        </td>

                                        <!-- Actions -->
                                        <td class="text-center">

                                            <button type="button" class="
                                        btn-table-action
                                        btn-table-view
                                    " title="Voir les détails" onclick="viewCashboxMovement(
                                        <?= (int) $movement->id ?>
                                    )">

                                                <i class="fas fa-eye"></i>

                                            </button>

                                            <?php if (
                                                $movement->status
                                                === 'pending'
                                            ): ?>

                                                <button type="button" class="
                                            btn-table-action
                                            btn-table-edit
                                        " title="Modifier" onclick="editCashboxMovement(
                                            <?= (int) $movement->id ?>
                                        )">

                                                    <i class="fas fa-edit"></i>

                                                </button>

                                            <?php endif; ?>

                                            <?php if (
                                                !empty($movement->attachment)
                                            ): ?>

                                                <a href="<?= base_url(
                                                                'uploads/finance/'
                                                                    . 'cashbox_operations/'
                                                                    . rawurlencode(
                                                                        $movement->attachment
                                                                    )
                                                            ) ?>" target="_blank" class="
                                            btn-table-action
                                            btn-table-print
                                        " title="Voir le justificatif">

                                                    <i class="fas fa-paperclip"></i>

                                                </a>

                                            <?php endif; ?>

                                            <a href="<?= base_url(
                                                            'finance/cashbox-operation-print/'
                                                                . (int) $movement->id
                                                        ) ?>" target="_blank" class="
                                        btn-table-action
                                        btn-table-print
                                    " title="Imprimer">

                                                <i class="fas fa-print"></i>

                                            </a>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="11" class="text-center py-5">

                                        <div class="mb-3" style="
                                    color: #cbd5e1;
                                    font-size: 42px;
                                ">

                                            <i class="fas fa-exchange-alt"></i>

                                        </div>

                                        <h6 style="
                                    color: #334155;
                                    font-weight: 800;
                                ">

                                            Aucun mouvement enregistré

                                        </h6>

                                        <p class="
                                    text-muted
                                    mb-3
                                ">

                                            Les encaissements,
                                            décaissements et transferts
                                            apparaîtront ici.

                                        </p>

                                        <button type="button" class="btn btn-caisse-primary" data-toggle="modal"
                                            data-target="#addOperationModal" onclick="
                                    prepareOperation(
                                        'encaissement'
                                    )
                                ">

                                            <i class="fas fa-plus mr-1"></i>

                                            Enregistrer une opération

                                        </button>

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

                <!-- Pied du tableau -->
                <div class="
            p-3
            border-top
            d-flex
            justify-content-between
            align-items-center
            flex-wrap
        ">

                    <small class="text-muted">

                        <?php

                        $displayedMovements = !empty($recentCashboxMovements)
                            ? count($recentCashboxMovements)
                            : 0;

                        ?>

                        Affichage de

                        <?= $displayedMovements > 0 ? 1 : 0 ?>

                        à

                        <?= $displayedMovements ?>

                        sur

                        <?= (int) $cashboxMovementsCount ?>

                        opération<?= $cashboxMovementsCount > 1
                                        ? 's'
                                        : ''
                                    ?>

                    </small>

                    <a href="<?= base_url(
                                    'finance/journal-caisse'
                                ) ?>" class="
                btn
                btn-caisse-outline
                btn-sm
            ">

                        Voir les

                        <?= (int) $cashboxMovementsCount ?>

                        opérations

                        <i class="fas fa-arrow-right ml-1"></i>

                    </a>

                </div>

            </div>

            <!-- =================================================
     TOP DÉPENSES + SYNTHÈSE PAR CHANTIER
================================================== -->
            <div class="row">

                <!-- =================================================
         PRINCIPALES DÉPENSES DU MOIS
    ================================================== -->
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

                            <?php if (!empty($monthlyMainExpenses)): ?>

                                <span class="badge badge-light">

                                    <?= count($monthlyMainExpenses) ?>

                                    catégorie<?= count($monthlyMainExpenses) > 1 ? 's' : '' ?>

                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="caisse-card-body">

                            <?php if (!empty($monthlyMainExpenses)): ?>

                                <?php foreach ($monthlyMainExpenses as $expense): ?>

                                    <?php
                                    /*
                         * =============================================
                         * INFORMATIONS DE LA CATÉGORIE
                         * =============================================
                         */

                                    $categoryName = !empty($expense->category)
                                        ? trim((string) $expense->category)
                                        : 'Autre';

                                    $normalizedCategory = mb_strtolower(
                                        $categoryName,
                                        'UTF-8'
                                    );

                                    /*
                         * Icône par défaut.
                         */
                                    $categoryIcon = 'fas fa-receipt';

                                    if (
                                        strpos(
                                            $normalizedCategory,
                                            'carburant'
                                        ) !== false
                                    ) {
                                        $categoryIcon = 'fas fa-gas-pump';
                                    } elseif (
                                        strpos(
                                            $normalizedCategory,
                                            'sous-trait'
                                        ) !== false
                                    ) {
                                        $categoryIcon = 'fas fa-user-tie';
                                    } elseif (
                                        strpos(
                                            $normalizedCategory,
                                            'main-d'
                                        ) !== false
                                        || strpos(
                                            $normalizedCategory,
                                            'salaire'
                                        ) !== false
                                        || strpos(
                                            $normalizedCategory,
                                            'personnel'
                                        ) !== false
                                    ) {
                                        $categoryIcon = 'fas fa-users';
                                    } elseif (
                                        strpos(
                                            $normalizedCategory,
                                            'fourniture'
                                        ) !== false
                                        || strpos(
                                            $normalizedCategory,
                                            'matériau'
                                        ) !== false
                                        || strpos(
                                            $normalizedCategory,
                                            'materiau'
                                        ) !== false
                                    ) {
                                        $categoryIcon = 'fas fa-tools';
                                    } elseif (
                                        strpos(
                                            $normalizedCategory,
                                            'maintenance'
                                        ) !== false
                                    ) {
                                        $categoryIcon = 'fas fa-truck-monster';
                                    } elseif (
                                        strpos(
                                            $normalizedCategory,
                                            'transport'
                                        ) !== false
                                    ) {
                                        $categoryIcon = 'fas fa-truck';
                                    } elseif (
                                        strpos(
                                            $normalizedCategory,
                                            'impôt'
                                        ) !== false
                                        || strpos(
                                            $normalizedCategory,
                                            'impot'
                                        ) !== false
                                        || strpos(
                                            $normalizedCategory,
                                            'taxe'
                                        ) !== false
                                    ) {
                                        $categoryIcon = 'fas fa-landmark';
                                    } elseif (
                                        strpos(
                                            $normalizedCategory,
                                            'loyer'
                                        ) !== false
                                    ) {
                                        $categoryIcon = 'fas fa-building';
                                    } elseif (
                                        strpos(
                                            $normalizedCategory,
                                            'électricité'
                                        ) !== false
                                        || strpos(
                                            $normalizedCategory,
                                            'electricite'
                                        ) !== false
                                    ) {
                                        $categoryIcon = 'fas fa-bolt';
                                    }

                                    /*
                         * =============================================
                         * MONTANTS
                         * =============================================
                         */

                                    $expenseTotal = isset(
                                        $expense->total_amount
                                    )
                                        ? (float) $expense->total_amount
                                        : 0;

                                    $expenseOperations = isset(
                                        $expense->total_operations
                                    )
                                        ? (int) $expense->total_operations
                                        : 0;

                                    /*
                         * =============================================
                         * POURCENTAGE DE LA BARRE
                         * =============================================
                         */

                                    $expensePercentage = isset(
                                        $expense->percentage
                                    )
                                        ? (float) $expense->percentage
                                        : 0;

                                    /*
                         * Limiter entre 0 et 100.
                         */
                                    $expensePercentage = max(
                                        0,
                                        min(
                                            100,
                                            $expensePercentage
                                        )
                                    );

                                    /*
                         * Rendre visible une petite valeur.
                         */
                                    if (
                                        $expenseTotal > 0
                                        && $expensePercentage < 4
                                    ) {
                                        $expensePercentage = 4;
                                    }

                                    /*
                         * Valeur prête à être utilisée dans style.
                         */
                                    $expensePercentageFormatted = number_format(
                                        $expensePercentage,
                                        2,
                                        '.',
                                        ''
                                    );
                                    ?>

                                    <div class="expense-item">

                                        <div class="expense-item-header">

                                            <span class="expense-item-title">

                                                <i class="<?= html_escape($categoryIcon) ?>"></i>

                                                <?= html_escape($categoryName) ?>

                                                <small class="text-muted ml-1" title="Nombre d’opérations">
                                                    (<?= $expenseOperations ?>)
                                                </small>

                                            </span>

                                            <span class="expense-item-value">

                                                <?= formatCashboxAmount($expenseTotal) ?>

                                                BIF

                                            </span>

                                        </div>

                                        <div class="expense-progress">

                                            <span style="width: <?= $expensePercentageFormatted ?>%;"></span>

                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <div class="text-center py-4">

                                    <div class="mb-3" style="color: #cbd5e1; font-size: 40px;">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>

                                    <h6 style="
                                color: #334155;
                                font-weight: 800;
                            ">
                                        Aucune dépense ce mois
                                    </h6>

                                    <p class="text-muted mb-0">
                                        Les décaissements validés apparaîtront
                                        automatiquement dans cette section.
                                    </p>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <!-- =================================================
         SYNTHÈSE PAR CHANTIER
    ================================================== -->
                <div class="col-xl-7 col-lg-7">

                    <div class="caisse-card">

                        <div class="caisse-card-header">

                            <div>

                                <h5 class="caisse-card-title">

                                    <i class="fas fa-project-diagram"></i>

                                    Synthèse par chantier

                                </h5>

                                <span class="caisse-card-subtitle">

                                    Comparaison entre les montants reçus,
                                    consommés et disponibles.

                                </span>

                            </div>

                            <?php if (!empty($cashboxSummaryByChantier)): ?>

                                <span class="badge badge-success">

                                    <?= count($cashboxSummaryByChantier) ?>

                                    chantier<?= count($cashboxSummaryByChantier) > 1 ? 's' : '' ?>

                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="table-responsive caisse-summary-table-wrapper">

                            <table class="table caisse-table">

                                <thead>

                                    <tr>

                                        <th>Chantier</th>

                                        <th class="text-right">
                                            Approvisionné
                                        </th>

                                        <th class="text-right">
                                            Consommé
                                        </th>

                                        <th class="text-right">
                                            Disponible
                                        </th>

                                        <th>
                                            Consommation
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php if (!empty($cashboxSummaryByChantier)): ?>

                                        <?php foreach (
                                            $cashboxSummaryByChantier
                                            as $chantierSummary
                                        ): ?>

                                            <?php
                                            /*
                                 * =====================================
                                 * VALEURS FINANCIÈRES
                                 * =====================================
                                 */

                                            $totalFunded = isset(
                                                $chantierSummary->total_funded
                                            )
                                                ? (float) $chantierSummary->total_funded
                                                : 0;

                                            $totalConsumed = isset(
                                                $chantierSummary->total_consumed
                                            )
                                                ? (float) $chantierSummary->total_consumed
                                                : 0;

                                            $currentBalance = isset(
                                                $chantierSummary->current_balance
                                            )
                                                ? (float) $chantierSummary->current_balance
                                                : 0;

                                            $alertThreshold = isset(
                                                $chantierSummary->alert_threshold
                                            )
                                                ? (float) $chantierSummary->alert_threshold
                                                : 0;

                                            /*
                                 * =====================================
                                 * POURCENTAGE DE CONSOMMATION
                                 * =====================================
                                 */

                                            $percentage = isset(
                                                $chantierSummary
                                                    ->consumption_percentage
                                            )
                                                ? (float) $chantierSummary
                                                    ->consumption_percentage
                                                : 0;

                                            $percentage = max(
                                                0,
                                                min(
                                                    100,
                                                    $percentage
                                                )
                                            );

                                            $visualPercentage = $percentage;

                                            if (
                                                $visualPercentage > 0
                                                && $visualPercentage < 3
                                            ) {
                                                $visualPercentage = 3;
                                            }

                                            $visualPercentageFormatted = number_format(
                                                $visualPercentage,
                                                2,
                                                '.',
                                                ''
                                            );

                                            /*
                                 * =====================================
                                 * COULEUR DE LA BARRE
                                 * =====================================
                                 */

                                            $progressClass = 'bg-info';
                                            $consumptionStatus = 'Faible';

                                            if ($percentage >= 90) {
                                                $progressClass = 'bg-danger';
                                                $consumptionStatus = 'Critique';
                                            } elseif ($percentage >= 75) {
                                                $progressClass = 'bg-warning';
                                                $consumptionStatus = 'Élevée';
                                            } elseif ($percentage >= 65) {
                                                $progressClass = 'bg-success';
                                                $consumptionStatus = 'Normale';
                                            }

                                            /*
                                 * =====================================
                                 * NOM ET RÉFÉRENCE DU CHANTIER
                                 * =====================================
                                 */

                                            $chantierName = !empty($chantierSummary->chantier_name)
                                                ? $chantierSummary->chantier_name
                                                : $chantierSummary->cashbox_name;

                                            $chantierReference = !empty($chantierSummary->ref_chantier)
                                                ? $chantierSummary->ref_chantier
                                                : $chantierSummary->cashbox_code;

                                            $devise = !empty($chantierSummary->devise)
                                                ? $chantierSummary->devise
                                                : 'BIF';

                                            /*
                                 * =====================================
                                 * COULEUR DU SOLDE DISPONIBLE
                                 * =====================================
                                 */

                                            $availableAmountClass = 'amount-in';

                                            if (
                                                $alertThreshold > 0
                                                && $currentBalance <= $alertThreshold
                                            ) {
                                                $availableAmountClass = 'text-danger';
                                            } elseif (
                                                $alertThreshold > 0
                                                && $currentBalance
                                                <= ($alertThreshold * 2)
                                            ) {
                                                $availableAmountClass = 'text-warning';
                                            }
                                            ?>

                                            <tr>

                                                <!-- Chantier -->
                                                <td>

                                                    <strong title="<?= html_escape(
                                                                        $chantierSummary->cashbox_name
                                                                    ) ?>">
                                                        <?= html_escape($chantierName) ?>
                                                    </strong>

                                                    <small class="d-block text-muted">

                                                        <?= html_escape(
                                                            $chantierReference
                                                        ) ?>

                                                        <?php if (
                                                            !empty($chantierSummary->location)
                                                        ): ?>

                                                            · <?= html_escape(
                                                                    $chantierSummary->location
                                                                ) ?>

                                                        <?php endif; ?>

                                                    </small>

                                                </td>

                                                <!-- Approvisionné -->
                                                <td class="text-right">

                                                    <strong>

                                                        <?= formatCashboxAmount(
                                                            $totalFunded
                                                        ) ?>

                                                    </strong>

                                                    <small class="d-block text-muted">

                                                        <?= html_escape($devise) ?>

                                                    </small>

                                                </td>

                                                <!-- Consommé -->
                                                <td class="text-right amount-out">

                                                    <strong>

                                                        <?= formatCashboxAmount(
                                                            $totalConsumed
                                                        ) ?>

                                                    </strong>

                                                    <small class="d-block text-muted">

                                                        <?= html_escape($devise) ?>

                                                    </small>

                                                </td>

                                                <!-- Disponible -->
                                                <td class="
                                            text-right
                                            <?= html_escape(
                                                $availableAmountClass
                                            ) ?>
                                        ">

                                                    <strong>

                                                        <?= formatCashboxAmount(
                                                            $currentBalance
                                                        ) ?>

                                                    </strong>

                                                    <small class="d-block text-muted">

                                                        <?= html_escape($devise) ?>

                                                    </small>

                                                </td>

                                                <!-- Consommation -->
                                                <td style="min-width: 165px;">

                                                    <div class="progress progress-xs mb-1">

                                                        <div class="progress-bar <?= html_escape(
                                                                                        $progressClass
                                                                                    ) ?>"
                                                            style="width: <?= $visualPercentageFormatted ?>%;"></div>

                                                    </div>

                                                    <small>

                                                        <?= number_format(
                                                            $percentage,
                                                            1,
                                                            ',',
                                                            ' '
                                                        ) ?>

                                                        %

                                                        <span class="text-muted ml-1">

                                                            <?= html_escape(
                                                                $consumptionStatus
                                                            ) ?>

                                                        </span>

                                                    </small>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    <?php else: ?>

                                        <tr>

                                            <td colspan="5" class="text-center py-5">

                                                <div class="mb-3" style="
                                            color: #cbd5e1;
                                            font-size: 40px;
                                        ">
                                                    <i class="fas fa-project-diagram"></i>
                                                </div>

                                                <h6 style="
                                            color: #334155;
                                            font-weight: 800;
                                        ">
                                                    Aucune caisse chantier
                                                </h6>

                                                <p class="text-muted mb-0">

                                                    Les caisses associées aux
                                                    chantiers apparaîtront ici.

                                                </p>

                                            </td>

                                        </tr>

                                    <?php endif; ?>

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
    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const chartElement =
                document.getElementById(
                    'cashFlowChart'
                );

            if (
                !chartElement ||
                typeof Chart === 'undefined'
            ) {
                return;
            }

            const cashFlowLabels =
                <?= json_encode(
                    $cashFlowEvolution['labels'],
                    JSON_UNESCAPED_UNICODE
                        | JSON_UNESCAPED_SLASHES
                ) ?>;

            const cashFlowIncomes =
                <?= json_encode(
                    array_map(
                        'floatval',
                        $cashFlowEvolution['incomes']
                    )
                ) ?>;

            const cashFlowExpenses =
                <?= json_encode(
                    array_map(
                        'floatval',
                        $cashFlowEvolution['expenses']
                    )
                ) ?>;

            const context =
                chartElement.getContext('2d');

            const gradientIncome =
                context.createLinearGradient(
                    0,
                    0,
                    0,
                    280
                );

            gradientIncome.addColorStop(
                0,
                'rgba(15, 118, 110, 0.30)'
            );

            gradientIncome.addColorStop(
                1,
                'rgba(15, 118, 110, 0.02)'
            );

            const gradientExpense =
                context.createLinearGradient(
                    0,
                    0,
                    0,
                    280
                );

            gradientExpense.addColorStop(
                0,
                'rgba(220, 38, 38, 0.20)'
            );

            gradientExpense.addColorStop(
                1,
                'rgba(220, 38, 38, 0.01)'
            );

            new Chart(
                context, {
                    type: 'line',

                    data: {
                        labels: cashFlowLabels,

                        datasets: [{
                                label: 'Encaissements',

                                data: cashFlowIncomes,

                                borderColor: '#0f766e',

                                backgroundColor: gradientIncome,

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
                                label: 'Décaissements',

                                data: cashFlowExpenses,

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
                                    label: function(
                                        context
                                    ) {
                                        const amount =
                                            context.parsed.y ||
                                            0;

                                        return (
                                            context.dataset.label +
                                            ' : ' +
                                            new Intl
                                            .NumberFormat(
                                                'fr-FR'
                                            )
                                            .format(
                                                amount
                                            ) +
                                            ' BIF'
                                        );
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
                                    maxTicksLimit: 15,

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

                                    callback: function(
                                        value
                                    ) {
                                        if (
                                            value >=
                                            1000000000
                                        ) {
                                            return (
                                                value /
                                                1000000000
                                            ) + ' Md';
                                        }

                                        if (
                                            value >=
                                            1000000
                                        ) {
                                            return (
                                                value /
                                                1000000
                                            ) + ' M';
                                        }

                                        if (
                                            value >= 1000
                                        ) {
                                            return (
                                                value /
                                                1000
                                            ) + ' K';
                                        }

                                        return value;
                                    }
                                }
                            }
                        }
                    }
                }
            );
        }
    );
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