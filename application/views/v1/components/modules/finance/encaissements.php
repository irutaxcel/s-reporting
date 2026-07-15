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

                /* =========================================================
   MODALE CAISSE COMMUNE
========================================================= */

                .modal-caisse .modal-content {
                    border: 0;
                    border-radius: 14px;
                    overflow: hidden;
                    box-shadow: 0 24px 60px rgba(15, 23, 42, 0.28);
                }

                .modal-caisse .modal-header {
                    display: flex;
                    align-items: center;
                    min-height: 56px;
                    padding: 14px 18px;
                    color: #ffffff;
                    border-bottom: 0;
                    background: linear-gradient(135deg,
                            #177f75 0%,
                            #124f5b 55%,
                            #102033 100%);
                }

                .modal-caisse .modal-title {
                    margin: 0;
                    color: #ffffff;
                    font-size: 14px;
                    font-weight: 800;
                }

                .modal-caisse .modal-header .close {
                    margin: -5px -5px -5px auto;
                    padding: 8px;
                    color: #ffffff;
                    text-shadow: none;
                    opacity: 1;
                    outline: none;
                }

                .modal-caisse .modal-header .close:hover {
                    color: #d1fae5;
                    opacity: 1;
                }

                .modal-caisse .modal-body {
                    padding: 22px 18px 12px;
                    background: #ffffff;
                }

                .modal-caisse .modal-footer {
                    padding: 13px 18px;
                    border-top: 1px solid #e2e8f0;
                    background: #ffffff;
                }

                .modal-caisse label {
                    margin-bottom: 7px;
                    color: #334155;
                    font-size: 10px;
                    font-weight: 800;
                }

                .modal-caisse .form-control,
                .modal-caisse .custom-file-label,
                .modal-caisse .input-group-text {
                    min-height: 42px;
                    border-color: #cbd5e1;
                    border-radius: 8px;
                    color: #334155;
                    font-size: 11px;
                    box-shadow: none;
                }

                .modal-caisse textarea.form-control {
                    min-height: 88px;
                    resize: vertical;
                }

                .modal-caisse .form-control:focus {
                    border-color: #0f766e;
                    box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.10);
                }

                .modal-caisse .input-group .form-control {
                    border-radius: 8px 0 0 8px;
                }

                .modal-caisse .input-group-append .input-group-text {
                    display: flex;
                    align-items: center;
                    min-width: 54px;
                    justify-content: center;
                    border-left: 0;
                    border-radius: 0 8px 8px 0;
                    background: #e2e8f0;
                    font-weight: 700;
                }

                .modal-caisse .custom-file-label {
                    display: flex;
                    align-items: center;
                    padding-top: 0;
                    padding-bottom: 0;
                }

                .modal-caisse .custom-file-label::after {
                    display: flex;
                    align-items: center;
                    height: 100%;
                    content: "Browse";
                    border-left: 1px solid #cbd5e1;
                    background: #e2e8f0;
                    font-weight: 700;
                }

                .modal-caisse .form-text {
                    margin-top: 5px;
                    color: #64748b !important;
                    font-size: 9px;
                }

                .required-star {
                    color: #dc2626;
                    font-weight: 900;
                }

                .btn-caisse-primary {
                    padding: 9px 15px;
                    color: #ffffff;
                    border: 1px solid #0f766e;
                    border-radius: 8px;
                    background: #0f766e;
                    font-size: 10px;
                    font-weight: 800;
                }

                .btn-caisse-primary:hover,
                .btn-caisse-primary:focus {
                    color: #ffffff;
                    border-color: #115e59;
                    background: #115e59;
                    box-shadow: none;
                }

                .btn-caisse-outline {
                    padding: 9px 15px;
                    color: #0f766e;
                    border: 1px solid #99d5cf;
                    border-radius: 8px;
                    background: #ffffff;
                    font-size: 10px;
                    font-weight: 800;
                }

                .btn-caisse-outline:hover,
                .btn-caisse-outline:focus {
                    color: #0f766e;
                    border-color: #0f766e;
                    background: #f0fdfa;
                    box-shadow: none;
                }

                /* =========================================================
   RÉSUMÉ DE L’ÉVOLUTION DES ENCAISSEMENTS
========================================================= */

                .enc-flow-summary {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 10px;
                    margin-bottom: 16px;
                }

                .enc-flow-summary-item {
                    padding: 10px 12px;
                    border: 1px solid #e2e8f0;
                    border-radius: 10px;
                    background: #f8fafc;
                }

                .enc-flow-summary-item span {
                    display: block;
                    margin-bottom: 4px;
                    color: #64748b;
                    font-size: 8px;
                    font-weight: 800;
                    text-transform: uppercase;
                }

                .enc-flow-summary-item strong {
                    color: #102033;
                    font-size: 12px;
                    font-weight: 900;
                }

                .enc-source-percentage {
                    margin-top: 4px;
                    color: #64748b;
                    font-size: 8px;
                    font-weight: 700;
                    text-align: right;
                }

                @media (max-width: 767px) {
                    .enc-flow-summary {
                        grid-template-columns: 1fr;
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

            <?php

            $encStats = isset($encaissementStatistics)
                && is_array($encaissementStatistics)
                ? $encaissementStatistics
                : [];

            $encCurrency = $encStats['currency']
                ?? 'BIF';

            $currentMonthIncome = isset(
                $encStats['current_month_amount']
            )
                ? (float) $encStats['current_month_amount']
                : 0;

            $currentMonthIncomeCount = isset(
                $encStats['current_month_count']
            )
                ? (int) $encStats['current_month_count']
                : 0;

            $monthlyVariation = isset(
                $encStats['monthly_variation']
            )
                ? (float) $encStats['monthly_variation']
                : 0;

            $todayIncome = isset(
                $encStats['today_amount']
            )
                ? (float) $encStats['today_amount']
                : 0;

            $todayIncomeCount = isset(
                $encStats['today_count']
            )
                ? (int) $encStats['today_count']
                : 0;

            $pendingIncome = isset(
                $encStats['pending_amount']
            )
                ? (float) $encStats['pending_amount']
                : 0;

            $pendingIncomeCount = isset(
                $encStats['pending_count']
            )
                ? (int) $encStats['pending_count']
                : 0;

            $receivableAmount = isset(
                $encStats['receivable_amount']
            )
                ? (float) $encStats['receivable_amount']
                : 0;

            $receivableClientsCount = isset(
                $encStats['receivable_clients_count']
            )
                ? (int) $encStats['receivable_clients_count']
                : 0;

            /*
            * Apparence du badge de variation.
            */
            $variationClass = 'enc-badge-info';
            $variationIcon  = 'fas fa-minus';
            $variationPrefix = '';

            if ($monthlyVariation > 0) {
                $variationClass = 'enc-badge-success';
                $variationIcon  = 'fas fa-arrow-up';
                $variationPrefix = '+';
            } elseif ($monthlyVariation < 0) {
                $variationClass = 'enc-badge-danger';
                $variationIcon  = 'fas fa-arrow-down';
            }

            ?>

            <!-- =========================================================
     STATISTIQUES DYNAMIQUES DES ENCAISSEMENTS
========================================================== -->
            <div class="row">

                <!-- =====================================================
         TOTAL ENCAISSÉ CE MOIS
    ====================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="enc-stat-card">

                        <div class="enc-stat-top">

                            <div class="enc-stat-icon enc-icon-green">

                                <i class="fas fa-coins"></i>

                            </div>

                            <span class="
                        enc-stat-badge
                        <?= html_escape(
                            $variationClass
                        ) ?>
                    " title="Variation par rapport au mois précédent">

                                <i class="
                            <?= html_escape(
                                $variationIcon
                            ) ?>
                            mr-1
                        "></i>

                                <?= $variationPrefix ?>

                                <?= number_format(
                                    abs($monthlyVariation),
                                    1,
                                    ',',
                                    ' '
                                ) ?>

                                %

                            </span>

                        </div>

                        <div class="enc-stat-label">

                            Total encaissé ce mois

                        </div>

                        <div class="enc-stat-value">

                            <?= number_format(
                                $currentMonthIncome,
                                0,
                                ',',
                                ' '
                            ) ?>

                            <?= html_escape($encCurrency) ?>

                        </div>

                        <div class="enc-stat-footer">

                            <?= $currentMonthIncomeCount ?>

                            encaissement<?= $currentMonthIncomeCount > 1
                                            ? 's'
                                            : ''
                                        ?>

                            validé<?= $currentMonthIncomeCount > 1
                                        ? 's'
                                        : ''
                                    ?>

                            ce mois

                        </div>

                    </div>

                </div>

                <!-- =====================================================
         ENCAISSEMENTS DU JOUR
    ====================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="enc-stat-card">

                        <div class="enc-stat-top">

                            <div class="enc-stat-icon enc-icon-blue">

                                <i class="fas fa-calendar-day"></i>

                            </div>

                            <span class="
                        enc-stat-badge
                        enc-badge-info
                    ">

                                <?= $todayIncomeCount ?>

                                opération<?= $todayIncomeCount > 1
                                                ? 's'
                                                : ''
                                            ?>

                            </span>

                        </div>

                        <div class="enc-stat-label">

                            Encaissements du jour

                        </div>

                        <div class="enc-stat-value">

                            <?= number_format(
                                $todayIncome,
                                0,
                                ',',
                                ' '
                            ) ?>

                            <?= html_escape($encCurrency) ?>

                        </div>

                        <div class="enc-stat-footer">

                            <?php if ($todayIncomeCount > 0): ?>

                                Entrées validées aujourd’hui

                            <?php else: ?>

                                Aucun encaissement validé aujourd’hui

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <!-- =====================================================
         EN ATTENTE DE VALIDATION
    ====================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="enc-stat-card">

                        <div class="enc-stat-top">

                            <div class="enc-stat-icon enc-icon-orange">

                                <i class="fas fa-clock"></i>

                            </div>

                            <span class="
                        enc-stat-badge
                        <?= $pendingIncomeCount > 0
                            ? 'enc-badge-warning'
                            : 'enc-badge-info'
                        ?>
                    ">

                                <?= $pendingIncomeCount ?>

                                dossier<?= $pendingIncomeCount > 1
                                            ? 's'
                                            : ''
                                        ?>

                            </span>

                        </div>

                        <div class="enc-stat-label">

                            En attente de validation

                        </div>

                        <div class="enc-stat-value">

                            <?= number_format(
                                $pendingIncome,
                                0,
                                ',',
                                ' '
                            ) ?>

                            <?= html_escape($encCurrency) ?>

                        </div>

                        <div class="enc-stat-footer">

                            <?php if ($pendingIncomeCount > 0): ?>

                                Encaissements non encore validés

                            <?php else: ?>

                                Aucun encaissement en attente

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <!-- =====================================================
         CRÉANCES À ENCAISSER
    ====================================================== -->
                <div class="col-xl-3 col-lg-6 col-md-6">

                    <div class="enc-stat-card">

                        <div class="enc-stat-top">

                            <div class="enc-stat-icon enc-icon-purple">

                                <i class="fas fa-file-invoice-dollar"></i>

                            </div>

                            <span class="
                        enc-stat-badge
                        enc-badge-info
                    ">

                                <?= $receivableClientsCount ?>

                                client<?= $receivableClientsCount > 1
                                            ? 's'
                                            : ''
                                        ?>

                            </span>

                        </div>

                        <div class="enc-stat-label">

                            Créances à encaisser

                        </div>

                        <div class="enc-stat-value">

                            <?= number_format(
                                $receivableAmount,
                                0,
                                ',',
                                ' '
                            ) ?>

                            <?= html_escape($encCurrency) ?>

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

            <?php

            if (
                !function_exists(
                    'formatEncaissementCompactAmount'
                )
            ) {
                function formatEncaissementCompactAmount(
                    $amount
                ): string {
                    $amount = (float) $amount;

                    if (
                        abs($amount) >= 1000000000
                    ) {
                        return number_format(
                            $amount / 1000000000,
                            1,
                            ',',
                            ' '
                        ) . ' Md';
                    }

                    if (
                        abs($amount) >= 1000000
                    ) {
                        return number_format(
                            $amount / 1000000,
                            1,
                            ',',
                            ' '
                        ) . ' M';
                    }

                    if (
                        abs($amount) >= 1000
                    ) {
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

            <!-- =========================================================
     GRAPHIQUE + RÉPARTITION DYNAMIQUES
========================================================== -->
            <div class="row">

                <!-- =====================================================
         ÉVOLUTION DES ENCAISSEMENTS
    ====================================================== -->
                <div class="col-xl-8 col-lg-8">

                    <div class="enc-card">

                        <div class="enc-card-header">

                            <div>

                                <h5 class="enc-card-title">

                                    <i class="fas fa-chart-line"></i>

                                    Évolution des encaissements

                                </h5>

                                <span class="enc-card-subtitle">

                                    Analyse des entrées de fonds sur la période sélectionnée.

                                </span>

                            </div>

                            <form action="<?= current_url() ?>" method="get" id="encaissementPeriodForm">

                                <select name="encaissement_period" id="encaissementPeriod"
                                    class="form-control enc-period-select" onchange="
                            document
                                .getElementById(
                                    'encaissementPeriodForm'
                                )
                                .submit();
                        ">

                                    <option value="6months" <?= $encaissementPeriod === '6months'
                                                                ? 'selected'
                                                                : ''
                                                            ?>>
                                        6 derniers mois
                                    </option>

                                    <option value="12months" <?= $encaissementPeriod === '12months'
                                                                    ? 'selected'
                                                                    : ''
                                                                ?>>
                                        12 derniers mois
                                    </option>

                                    <option value="current_year" <?= $encaissementPeriod === 'current_year'
                                                                        ? 'selected'
                                                                        : ''
                                                                    ?>>
                                        Cette année
                                    </option>

                                    <option value="previous_year" <?= $encaissementPeriod === 'previous_year'
                                                                        ? 'selected'
                                                                        : ''
                                                                    ?>>
                                        Année précédente
                                    </option>

                                </select>

                            </form>

                        </div>

                        <div class="enc-card-body">

                            <!-- Résumé de la période -->
                            <div class="enc-flow-summary">

                                <div class="enc-flow-summary-item">

                                    <span>
                                        Total période
                                    </span>

                                    <strong class="text-success">

                                        <?= number_format(
                                            (float) $encaissementEvolution['total_amount'],
                                            0,
                                            ',',
                                            ' '
                                        ) ?>

                                        BIF

                                    </strong>

                                </div>

                                <div class="enc-flow-summary-item">

                                    <span>
                                        Moyenne mensuelle
                                    </span>

                                    <strong>

                                        <?= number_format(
                                            (float) $encaissementEvolution['average_amount'],
                                            0,
                                            ',',
                                            ' '
                                        ) ?>

                                        BIF

                                    </strong>

                                </div>

                                <div class="enc-flow-summary-item">

                                    <span>
                                        Nombre d’opérations
                                    </span>

                                    <strong>

                                        <?= (int) $encaissementEvolution['total_operations'] ?>

                                    </strong>

                                </div>

                            </div>

                            <div class="enc-chart-container">

                                <canvas id="encaissementChart"></canvas>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- =====================================================
         SOURCES DES ENCAISSEMENTS
    ====================================================== -->
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

                            <?php if (
                                !empty($encaissementSources['sources'])
                            ): ?>

                                <?php foreach (
                                    $encaissementSources['sources']
                                    as $source
                                ): ?>

                                    <?php

                                    $sourcePercentage = isset(
                                        $source['percentage']
                                    )
                                        ? (float) $source['percentage']
                                        : 0;

                                    $sourcePercentage = min(
                                        100,
                                        max(
                                            0,
                                            $sourcePercentage
                                        )
                                    );

                                    $sourcePercentageCss =
                                        number_format(
                                            $sourcePercentage,
                                            2,
                                            '.',
                                            ''
                                        );

                                    ?>

                                    <div class="enc-source-item">

                                        <div class="enc-source-header">

                                            <span class="enc-source-name">

                                                <i class="<?= html_escape(
                                                                $source['icon']
                                                            ) ?>"></i>

                                                <?= html_escape(
                                                    $source['name']
                                                ) ?>

                                                <small class="d-block text-muted" style="font-size: 8px;">

                                                    <?= (int) $source['operation_count'] ?>

                                                    opération<?= $source['operation_count'] > 1
                                                                    ? 's'
                                                                    : ''
                                                                ?>

                                                </small>

                                            </span>

                                            <span class="enc-source-value">

                                                <?= formatEncaissementCompactAmount(
                                                    $source['amount']
                                                ) ?>

                                            </span>

                                        </div>

                                        <div class="enc-source-progress">

                                            <span style="width: <?= $sourcePercentageCss ?>%;"></span>

                                        </div>

                                        <div class="enc-source-percentage">

                                            <?= number_format(
                                                $sourcePercentage,
                                                1,
                                                ',',
                                                ' '
                                            ) ?>

                                            %

                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <div class="text-center py-5">

                                    <i class="
                                fas
                                fa-chart-pie
                                fa-2x
                                text-muted
                                mb-3
                            "></i>

                                    <h6>
                                        Aucune source disponible
                                    </h6>

                                    <p class="text-muted mb-0">

                                        Aucun encaissement validé n’a été trouvé
                                        pour cette période.

                                    </p>

                                </div>

                            <?php endif; ?>

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
     HISTORIQUE DYNAMIQUE DES ENCAISSEMENTS
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

                    <button type="button" class="btn btn-enc-primary" data-toggle="modal"
                        data-target="#addEncaissementModal">
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

                            <?php if (!empty($encaissementHistory)): ?>

                                <?php foreach (
                                    $encaissementHistory
                                    as $index => $encaissement
                                ): ?>

                                    <?php

                                    /*
                         * =========================================
                         * DATE ET HEURE
                         * =========================================
                         */

                                    $displayDate =
                                        !empty($encaissement->operation_date)
                                        ? date(
                                            'd/m/Y',
                                            strtotime(
                                                $encaissement
                                                    ->operation_date
                                            )
                                        )
                                        : '—';

                                    $displayTime =
                                        !empty($encaissement->created_at)
                                        ? date(
                                            'H:i',
                                            strtotime(
                                                $encaissement
                                                    ->created_at
                                            )
                                        )
                                        : '';

                                    /*
                         * =========================================
                         * PROVENANCE
                         * =========================================
                         */

                                    $thirdParty =
                                        !empty($encaissement->third_party)
                                        ? $encaissement->third_party
                                        : 'Provenance non renseignée';

                                    /*
                         * =========================================
                         * CATÉGORIE
                         * =========================================
                         */

                                    $category =
                                        !empty($encaissement->category)
                                        ? $encaissement->category
                                        : 'Encaissement';

                                    /*
                         * =========================================
                         * CAISSE
                         * =========================================
                         */

                                    $cashboxName =
                                        !empty($encaissement->cashbox_name)
                                        ? $encaissement->cashbox_name
                                        : 'Caisse non renseignée';

                                    $cashboxSubtitle =
                                        'Caisse de trésorerie';

                                    if (
                                        $encaissement->cashbox_type
                                        === 'siege'
                                    ) {
                                        $cashboxSubtitle =
                                            'Caisse siège';
                                    } elseif (
                                        $encaissement->cashbox_type
                                        === 'chantier'
                                    ) {
                                        $cashboxSubtitle =
                                            !empty($encaissement
                                                ->chantier_name)
                                            ? 'Chantier : '
                                            . $encaissement
                                            ->chantier_name
                                            : 'Caisse chantier';
                                    }

                                    /*
                         * =========================================
                         * MODE DE RÈGLEMENT
                         * =========================================
                         */

                                    $paymentModeLabel =
                                        'Autre';

                                    $paymentModeIcon =
                                        'fas fa-exchange-alt';

                                    $paymentModeClass =
                                        'enc-mode-bank';

                                    switch ($encaissement
                                        ->payment_method) {
                                        case 'cash':
                                            $paymentModeLabel =
                                                'Espèces';

                                            $paymentModeIcon =
                                                'fas fa-money-bill-wave';

                                            $paymentModeClass =
                                                'enc-mode-cash';
                                            break;

                                        case 'bank':
                                            $paymentModeLabel =
                                                'Virement';

                                            $paymentModeIcon =
                                                'fas fa-university';

                                            $paymentModeClass =
                                                'enc-mode-bank';
                                            break;

                                        case 'cheque':
                                            $paymentModeLabel =
                                                'Chèque';

                                            $paymentModeIcon =
                                                'fas fa-money-check';

                                            $paymentModeClass =
                                                'enc-mode-cheque';
                                            break;

                                        case 'mobile':
                                            $paymentModeLabel =
                                                'Mobile Money';

                                            $paymentModeIcon =
                                                'fas fa-mobile-alt';

                                            $paymentModeClass =
                                                'enc-mode-mobile';
                                            break;
                                    }

                                    /*
                         * =========================================
                         * STATUT
                         * =========================================
                         */

                                    $statusLabel =
                                        'En attente';

                                    $statusClass =
                                        'enc-status-pending';

                                    $statusIcon =
                                        'fas fa-clock';

                                    if (
                                        $encaissement->status
                                        === 'validated'
                                    ) {
                                        $statusLabel =
                                            'Validé';

                                        $statusClass =
                                            'enc-status-valid';

                                        $statusIcon =
                                            'fas fa-check-circle';
                                    } elseif (
                                        $encaissement->status
                                        === 'cancelled'
                                    ) {
                                        $statusLabel =
                                            'Annulé';

                                        $statusClass =
                                            'enc-status-cancelled';

                                        $statusIcon =
                                            'fas fa-times-circle';
                                    }

                                    /*
                         * =========================================
                         * PIÈCE
                         * =========================================
                         */

                                    $documentNumber =
                                        !empty($encaissement
                                            ->document_number)
                                        ? $encaissement
                                        ->document_number
                                        : '—';

                                    $hasAttachment =
                                        !empty($encaissement->attachment);

                                    $rowNumber =
                                        (
                                            (int) $encaissementPagination['offset']
                                        )
                                        + $index
                                        + 1;

                                    ?>

                                    <tr>

                                        <td>
                                            <?= $rowNumber ?>
                                        </td>

                                        <td>

                                            <?= html_escape(
                                                $displayDate
                                            ) ?>

                                            <?php if (
                                                $displayTime !== ''
                                            ): ?>

                                                <small class="d-block text-muted">
                                                    <?= html_escape(
                                                        $displayTime
                                                    ) ?>
                                                </small>

                                            <?php endif; ?>

                                        </td>

                                        <td>

                                            <span class="enc-reference">

                                                <?= html_escape(
                                                    $encaissement
                                                        ->reference
                                                ) ?>

                                            </span>

                                        </td>

                                        <td class="enc-client">

                                            <strong>

                                                <?= html_escape(
                                                    $thirdParty
                                                ) ?>

                                            </strong>

                                            <small>

                                                <?= html_escape(
                                                    $category
                                                ) ?>

                                            </small>

                                        </td>

                                        <td class="enc-label">

                                            <strong>

                                                <?= html_escape(
                                                    $encaissement->label
                                                ) ?>

                                            </strong>

                                            <small>

                                                <?= !empty($encaissement
                                                    ->observation)
                                                    ? html_escape(
                                                        $encaissement
                                                            ->observation
                                                    )
                                                    : 'Aucune observation'
                                                ?>

                                            </small>

                                        </td>

                                        <td>

                                            <strong>

                                                <?= html_escape(
                                                    $cashboxName
                                                ) ?>

                                            </strong>

                                            <small class="d-block text-muted">

                                                <?= html_escape(
                                                    $cashboxSubtitle
                                                ) ?>

                                            </small>

                                            <?php if (
                                                !empty($encaissement
                                                    ->cashbox_code)
                                            ): ?>

                                                <small class="d-block text-muted">

                                                    <?= html_escape(
                                                        $encaissement
                                                            ->cashbox_code
                                                    ) ?>

                                                </small>

                                            <?php endif; ?>

                                        </td>

                                        <td>

                                            <span class="
                                        enc-badge
                                        <?= html_escape(
                                            $paymentModeClass
                                        ) ?>
                                    ">

                                                <i class="
                                            <?= html_escape(
                                                $paymentModeIcon
                                            ) ?>
                                            mr-1
                                        "></i>

                                                <?= html_escape(
                                                    $paymentModeLabel
                                                ) ?>

                                            </span>

                                        </td>

                                        <td>

                                            <strong>

                                                <?= html_escape(
                                                    $documentNumber
                                                ) ?>

                                            </strong>

                                            <small class="d-block text-muted">

                                                <?= $hasAttachment
                                                    ? 'Justificatif joint'
                                                    : 'Aucun justificatif'
                                                ?>

                                            </small>

                                        </td>

                                        <td class="
                                    text-right
                                    enc-amount
                                ">

                                            +

                                            <?= number_format(
                                                (float)
                                                $encaissement->amount,
                                                0,
                                                ',',
                                                ' '
                                            ) ?>

                                        </td>

                                        <td>

                                            <?= html_escape(
                                                $encaissement->currency
                                            ) ?>

                                        </td>

                                        <td>

                                            <span class="
                                        enc-badge
                                        <?= html_escape(
                                            $statusClass
                                        ) ?>
                                    ">

                                                <i class="
                                            <?= html_escape(
                                                $statusIcon
                                            ) ?>
                                            mr-1
                                        "></i>

                                                <?= html_escape(
                                                    $statusLabel
                                                ) ?>

                                            </span>

                                        </td>

                                        <td class="text-center">

                                            <!-- Voir -->
                                            <button type="button" class="
                                        enc-action-btn
                                        enc-action-view
                                    " title="Voir l’encaissement" onclick="viewEncaissement(
                                        <?= (int)
                                        $encaissement->id
                                        ?>
                                    )">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <!-- Modifier -->
                                            <?php if (
                                                $encaissement->status
                                                !== 'cancelled'
                                            ): ?>

                                                <button type="button" class="
                                            enc-action-btn
                                            enc-action-edit
                                        " title="Modifier" onclick="editEncaissement(
                                            <?= (int)
                                                $encaissement->id
                                            ?>
                                        )">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                            <?php endif; ?>

                                            <!-- Pièce justificative -->
                                            <?php if ($hasAttachment): ?>

                                                <a href="<?= base_url(
                                                                'uploads/finance/'
                                                                    . 'cashbox_operations/'
                                                                    . rawurlencode(
                                                                        $encaissement
                                                                            ->attachment
                                                                    )
                                                            ) ?>" class="
                                            enc-action-btn
                                            enc-action-print
                                        " title="Ouvrir le justificatif" target="_blank">
                                                    <i class="fas fa-paperclip"></i>
                                                </a>

                                            <?php endif; ?>

                                            <!-- Imprimer -->
                                            <a href="<?= base_url(
                                                            'finance/encaissement-print/'
                                                                . (int)
                                                                $encaissement->id
                                                        ) ?>" class="
                                        enc-action-btn
                                        enc-action-print
                                    " title="Imprimer" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="12" class="text-center py-5">

                                        <div class="mb-3">

                                            <i class="
                                        fas
                                        fa-coins
                                        fa-3x
                                        text-muted
                                    "></i>

                                        </div>

                                        <h6>
                                            Aucun encaissement enregistré
                                        </h6>

                                        <p class="text-muted mb-3">

                                            Les encaissements ajoutés apparaîtront ici.

                                        </p>

                                        <button type="button" class="btn btn-enc-primary" data-toggle="modal"
                                            data-target="#addEncaissementModal">
                                            <i class="fas fa-plus mr-1"></i>
                                            Nouvel encaissement
                                        </button>

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

                <?php if (
                    !empty($encaissementHistory)
                ): ?>

                    <?php

                    $currentPage =
                        (int) $encaissementPagination['current_page'];

                    $totalPages =
                        (int) $encaissementPagination['total_pages'];

                    $totalRows =
                        (int) $encaissementPagination['total_rows'];

                    $firstDisplayed =
                        (int) $encaissementPagination['offset'] + 1;

                    $lastDisplayed = min(
                        $totalRows,
                        $encaissementPagination['offset']
                            + count($encaissementHistory)
                    );

                    /*
         * Conserver la période du graphique
         * pendant la pagination.
         */
                    $paginationBaseParams = [];

                    if (
                        !empty($encaissementPeriod)
                    ) {
                        $paginationBaseParams['encaissement_period'] = $encaissementPeriod;
                    }

                    ?>

                    <div class="
                p-3
                border-top
                d-flex
                justify-content-between
                align-items-center
                flex-wrap
            ">

                        <small class="text-muted">

                            Affichage de

                            <?= $firstDisplayed ?>

                            à

                            <?= $lastDisplayed ?>

                            sur

                            <?= $totalRows ?>

                            encaissement<?= $totalRows > 1
                                            ? 's'
                                            : ''
                                        ?>

                        </small>

                        <?php if ($totalPages > 1): ?>

                            <ul class="
                        pagination
                        pagination-sm
                        mb-0
                    ">

                                <!-- Précédent -->
                                <?php

                                $previousParams =
                                    $paginationBaseParams;

                                $previousParams['page'] =
                                    max(
                                        1,
                                        $currentPage - 1
                                    );

                                ?>

                                <li class="
                            page-item
                            <?= $currentPage <= 1
                                ? 'disabled'
                                : ''
                            ?>
                        ">

                                    <a class="page-link" href="<?= $currentPage <= 1
                                                                    ? '#'
                                                                    : current_url()
                                                                    . '?'
                                                                    . http_build_query(
                                                                        $previousParams
                                                                    )
                                                                ?>">
                                        Précédent
                                    </a>

                                </li>

                                <!-- Numéros de pages -->
                                <?php

                                $startPage = max(
                                    1,
                                    $currentPage - 2
                                );

                                $endPage = min(
                                    $totalPages,
                                    $currentPage + 2
                                );

                                ?>

                                <?php for (
                                    $pageNumber = $startPage;
                                    $pageNumber <= $endPage;
                                    $pageNumber++
                                ): ?>

                                    <?php

                                    $pageParams =
                                        $paginationBaseParams;

                                    $pageParams['page'] =
                                        $pageNumber;

                                    ?>

                                    <li class="
                                page-item
                                <?= $pageNumber
                                        === $currentPage
                                        ? 'active'
                                        : ''
                                ?>
                            ">

                                        <a class="page-link" href="<?= current_url()
                                                                        . '?'
                                                                        . http_build_query(
                                                                            $pageParams
                                                                        )
                                                                    ?>">
                                            <?= $pageNumber ?>
                                        </a>

                                    </li>

                                <?php endfor; ?>

                                <!-- Suivant -->
                                <?php

                                $nextParams =
                                    $paginationBaseParams;

                                $nextParams['page'] =
                                    min(
                                        $totalPages,
                                        $currentPage + 1
                                    );

                                ?>

                                <li class="
                            page-item
                            <?= $currentPage
                                >= $totalPages
                                ? 'disabled'
                                : ''
                            ?>
                        ">

                                    <a class="page-link" href="<?= $currentPage
                                                                    >= $totalPages
                                                                    ? '#'
                                                                    : current_url()
                                                                    . '?'
                                                                    . http_build_query(
                                                                        $nextParams
                                                                    )
                                                                ?>">
                                        Suivant
                                    </a>

                                </li>

                            </ul>

                        <?php endif; ?>

                    </div>

                <?php endif; ?>

            </div>



        </div>
    </section>

</div>

<!-- =========================================================
     MODALE : NOUVEL ENCAISSEMENT
     Styles identiques à la modale de la page Caisse
========================================================== -->
<div class="modal fade modal-caisse" id="addEncaissementModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">

        <form action="<?= base_url('cashbox-operation-store') ?>" method="post" enctype="multipart/form-data"
            id="encaissementForm" style="width: 100%;">

            <div class="modal-content">

                <!-- =================================================
                     HEADER
                ================================================== -->
                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="fas fa-arrow-circle-down mr-2"></i>

                        Enregistrer un encaissement

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>

                </div>

                <!-- =================================================
                     BODY
                ================================================== -->
                <div class="modal-body">

                    <input type="hidden" name="operation_type" value="encaissement">

                    <div class="row">

                        <!-- Date -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Date de l’opération
                                    <span class="required-star">*</span>
                                </label>

                                <input type="date" name="operation_date" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required>

                            </div>

                        </div>

                        <!-- Caisse -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Caisse concernée
                                    <span class="required-star">*</span>
                                </label>

                                <select name="cashbox_id" id="encaissementCashbox" class="form-control" required>

                                    <option value="">
                                        Sélectionner la caisse
                                    </option>

                                    <?php if (!empty($allCashboxes)): ?>

                                        <?php foreach ($allCashboxes as $cashbox): ?>

                                            <?php
                                            $currentBalance = isset(
                                                $cashbox->current_balance
                                            )
                                                ? (float) $cashbox->current_balance
                                                : 0;
                                            ?>

                                            <option value="<?= (int) $cashbox->id ?>" data-currency="<?= html_escape(
                                                                                                            $cashbox->devise
                                                                                                        ) ?>"
                                                data-balance="<?= $currentBalance ?>">
                                                <?= html_escape($cashbox->code) ?>

                                                —

                                                <?= html_escape($cashbox->name) ?>

                                                —

                                                <?= number_format(
                                                    $currentBalance,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) ?>

                                                <?= html_escape($cashbox->devise) ?>
                                            </option>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </select>

                                <small id="encaissementCashboxInfo" class="form-text text-muted">
                                    La caisse sélectionnée recevra le montant.
                                </small>

                            </div>

                        </div>

                        <!-- Montant -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Montant
                                    <span class="required-star">*</span>
                                </label>

                                <div class="input-group">

                                    <input type="number" name="amount" id="encaissementAmount" class="form-control"
                                        min="0.01" step="0.01" placeholder="0" required>

                                    <div class="input-group-append">

                                        <span class="input-group-text" id="encaissementCurrency">
                                            BIF
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Catégorie -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Catégorie
                                </label>

                                <select name="category" class="form-control">

                                    <option value="">
                                        Sélectionner
                                    </option>

                                    <option value="Paiement client">
                                        Paiement client
                                    </option>

                                    <option value="Avance sur marché">
                                        Avance sur marché
                                    </option>

                                    <option value="Remboursement">
                                        Remboursement
                                    </option>

                                    <option value="Emprunt">
                                        Emprunt
                                    </option>

                                    <option value="Vente actif">
                                        Vente d’actif
                                    </option>

                                    <option value="Autre produit">
                                        Autre produit
                                    </option>

                                </select>

                            </div>

                        </div>

                        <!-- Provenance -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Bénéficiaire / Provenance
                                </label>

                                <input type="text" name="third_party" class="form-control"
                                    placeholder="Nom du bénéficiaire ou de la source">

                            </div>

                        </div>

                        <!-- Mode -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Mode de règlement
                                </label>

                                <select name="payment_method" class="form-control">

                                    <option value="cash">
                                        Espèces
                                    </option>

                                    <option value="bank">
                                        Virement bancaire
                                    </option>

                                    <option value="cheque">
                                        Chèque
                                    </option>

                                    <option value="mobile">
                                        Mobile Money
                                    </option>

                                </select>

                            </div>

                        </div>

                        <!-- Numéro pièce -->
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Numéro de pièce
                                </label>

                                <input type="text" name="document_number" class="form-control"
                                    placeholder="Facture, reçu, bon...">

                            </div>

                        </div>

                        <!-- Fichier -->
                        <div class="col-md-8">

                            <div class="form-group">

                                <label>
                                    Pièce justificative
                                </label>

                                <div class="custom-file">

                                    <input type="file" name="attachment" class="custom-file-input"
                                        id="encaissementAttachment" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">

                                    <label class="custom-file-label" for="encaissementAttachment">
                                        Choisir un fichier
                                    </label>

                                </div>

                                <small class="form-text text-muted">
                                    PDF, image, Word ou Excel — maximum 5 Mo.
                                </small>

                            </div>

                        </div>

                        <!-- Libellé -->
                        <div class="col-md-12">

                            <div class="form-group">

                                <label>
                                    Libellé de l’encaissement
                                    <span class="required-star">*</span>
                                </label>

                                <input type="text" name="label" class="form-control"
                                    placeholder="Ex. Paiement de la facture FAC-2026-0045" required>

                            </div>

                        </div>

                        <!-- Observation -->
                        <div class="col-md-12">

                            <div class="form-group mb-0">

                                <label>
                                    Observation
                                </label>

                                <textarea name="observation" class="form-control" rows="3"
                                    placeholder="Informations complémentaires sur l’opération..."></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- =================================================
                     FOOTER
                ================================================== -->
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
<script>
    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const canvas =
                document.getElementById(
                    'encaissementChart'
                );

            if (
                !canvas ||
                typeof Chart === 'undefined'
            ) {
                return;
            }

            /*
             * Données PHP converties en JavaScript.
             */
            const encaissementLabels =
                <?= json_encode(
                    $encaissementEvolution['labels'],
                    JSON_UNESCAPED_UNICODE
                        | JSON_UNESCAPED_SLASHES
                ) ?>;

            const encaissementAmounts =
                <?= json_encode(
                    array_map(
                        'floatval',
                        $encaissementEvolution['amounts']
                    )
                ) ?>;

            const encaissementObjectives =
                <?= json_encode(
                    array_map(
                        'floatval',
                        $encaissementEvolution['objectives']
                    )
                ) ?>;

            const operationCounts =
                <?= json_encode(
                    array_map(
                        'intval',
                        $encaissementEvolution['operation_counts']
                    )
                ) ?>;

            const context =
                canvas.getContext('2d');

            const gradient =
                context.createLinearGradient(
                    0,
                    0,
                    0,
                    300
                );

            gradient.addColorStop(
                0,
                'rgba(15, 118, 110, 0.32)'
            );

            gradient.addColorStop(
                1,
                'rgba(15, 118, 110, 0.02)'
            );

            new Chart(
                context, {
                    type: 'line',

                    data: {
                        labels: encaissementLabels,

                        datasets: [{
                                label: 'Encaissements réalisés',

                                data: encaissementAmounts,

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

                                data: encaissementObjectives,

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
                                    title: function(
                                        tooltipItems
                                    ) {
                                        return tooltipItems[
                                            0
                                        ].label;
                                    },

                                    label: function(
                                        context
                                    ) {
                                        const amount =
                                            context.parsed.y ||
                                            0;

                                        let label =
                                            context.dataset.label +
                                            ' : ' +
                                            new Intl
                                            .NumberFormat(
                                                'fr-FR'
                                            )
                                            .format(
                                                amount
                                            ) +
                                            ' BIF';

                                        /*
                                         * Afficher le nombre d'opérations
                                         * uniquement pour les encaissements.
                                         */
                                        if (
                                            context.datasetIndex ===
                                            0
                                        ) {
                                            const operationCount =
                                                operationCounts[
                                                    context.dataIndex
                                                ] || 0;

                                            label +=
                                                ' — ' +
                                                operationCount +
                                                ' opération';

                                            if (
                                                operationCount > 1
                                            ) {
                                                label += 's';
                                            }
                                        }

                                        return label;
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