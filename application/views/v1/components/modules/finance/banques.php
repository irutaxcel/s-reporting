<?php

$bankAccountOldInput =
    $this->session->flashdata(
        'bank_account_old_input'
    );

$bankAccountOldInput =
    is_array($bankAccountOldInput)
    ? $bankAccountOldInput
    : [];

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- ici le contenu de la page -->

            <!-- =========================================================
     STYLES DE LA PAGE COMPTES BANCAIRES
========================================================== -->
            <style>
            :root {
                --bank-primary: #0f766e;
                --bank-primary-dark: #115e59;
                --bank-secondary: #102033;
                --bank-blue: #2563eb;
                --bank-orange: #d97706;
                --bank-red: #dc2626;
                --bank-green: #16a34a;
                --bank-purple: #7c3aed;
                --bank-muted: #64748b;
                --bank-light: #f8fafc;
                --bank-border: #e2e8f0;
                --bank-white: #ffffff;
            }

            /* =====================================================
       CONTENEUR GÉNÉRAL
    ===================================================== */

            .bank-page {
                padding-bottom: 30px;
            }

            .bank-page .row {
                margin-left: -8px;
                margin-right: -8px;
            }

            .bank-page .row>[class*="col-"] {
                padding-left: 8px;
                padding-right: 8px;
            }

            /* =====================================================
       BANDEAU PRINCIPAL
    ===================================================== */

            .bank-hero {
                position: relative;
                overflow: hidden;
                margin-bottom: 20px;
                padding: 24px;
                border-radius: 15px;
                color: #ffffff;
                background:
                    linear-gradient(120deg,
                        #0f766e 0%,
                        #155e75 55%,
                        #102033 100%);
                box-shadow: 0 12px 30px rgba(15, 118, 110, .16);
            }

            .bank-hero::before {
                position: absolute;
                right: 85px;
                bottom: -95px;
                width: 220px;
                height: 220px;
                content: "";
                border-radius: 50%;
                background: rgba(255, 255, 255, .06);
            }

            .bank-hero::after {
                position: absolute;
                right: -35px;
                top: -70px;
                width: 190px;
                height: 190px;
                content: "";
                border-radius: 50%;
                background: rgba(255, 255, 255, .05);
            }

            .bank-hero-content {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
            }

            .bank-hero-main {
                display: flex;
                align-items: flex-start;
                gap: 14px;
            }

            .bank-hero-icon {
                display: flex;
                flex: 0 0 48px;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 48px;
                border-radius: 12px;
                background: rgba(255, 255, 255, .14);
                font-size: 20px;
            }

            .bank-hero h2 {
                margin: 0 0 7px;
                font-size: 22px;
                font-weight: 800;
            }

            .bank-hero p {
                max-width: 760px;
                margin: 0;
                color: rgba(255, 255, 255, .88);
                font-size: 11px;
                line-height: 1.6;
            }

            .bank-hero-date {
                min-width: 155px;
                padding: 11px 14px;
                border: 1px solid rgba(255, 255, 255, .18);
                border-radius: 11px;
                background: rgba(255, 255, 255, .10);
                text-align: center;
                backdrop-filter: blur(5px);
            }

            .bank-hero-date span {
                display: block;
                margin-bottom: 3px;
                color: rgba(255, 255, 255, .75);
                font-size: 9px;
            }

            .bank-hero-date strong {
                display: block;
                font-size: 12px;
                font-weight: 800;
            }

            /* =====================================================
       CARTES STATISTIQUES
    ===================================================== */

            .bank-stat-card {
                position: relative;
                overflow: hidden;
                min-height: 160px;
                margin-bottom: 17px;
                padding: 19px;
                border: 1px solid var(--bank-border);
                border-radius: 14px;
                background: var(--bank-white);
                box-shadow: 0 7px 24px rgba(15, 23, 42, .045);
            }

            .bank-stat-card::after {
                position: absolute;
                right: -30px;
                bottom: -42px;
                width: 105px;
                height: 105px;
                content: "";
                border-radius: 50%;
                background: #f1f5f9;
            }

            .bank-stat-top {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 17px;
            }

            .bank-stat-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 43px;
                height: 43px;
                border-radius: 11px;
                font-size: 17px;
            }

            .bank-stat-icon.icon-green {
                color: #15803d;
                background: #dcfce7;
            }

            .bank-stat-icon.icon-blue {
                color: #0369a1;
                background: #e0f2fe;
            }

            .bank-stat-icon.icon-orange {
                color: #b45309;
                background: #fef3c7;
            }

            .bank-stat-icon.icon-red {
                color: #b91c1c;
                background: #fee2e2;
            }

            .bank-stat-badge {
                display: inline-flex;
                align-items: center;
                min-height: 23px;
                padding: 4px 8px;
                border-radius: 20px;
                font-size: 8px;
                font-weight: 800;
            }

            .bank-stat-badge.badge-positive {
                color: #15803d;
                background: #dcfce7;
            }

            .bank-stat-badge.badge-neutral {
                color: #0369a1;
                background: #e0f2fe;
            }

            .bank-stat-badge.badge-warning {
                color: #b45309;
                background: #fef3c7;
            }

            .bank-stat-badge.badge-negative {
                color: #b91c1c;
                background: #fee2e2;
            }

            .bank-stat-label {
                position: relative;
                z-index: 2;
                margin-bottom: 4px;
                color: #64748b;
                font-size: 10px;
                font-weight: 800;
                text-transform: uppercase;
            }

            .bank-stat-value {
                position: relative;
                z-index: 2;
                margin-bottom: 5px;
                color: #0f172a;
                font-size: 22px;
                font-weight: 900;
                line-height: 1.15;
            }

            .bank-stat-footer {
                position: relative;
                z-index: 2;
                color: #64748b;
                font-size: 9px;
            }

            /* =====================================================
       CARTE GÉNÉRALE
    ===================================================== */

            .bank-card {
                margin-bottom: 18px;
                overflow: hidden;
                border: 1px solid var(--bank-border);
                border-radius: 14px;
                background: var(--bank-white);
                box-shadow: 0 6px 22px rgba(15, 23, 42, .04);
            }

            .bank-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                min-height: 62px;
                padding: 15px 18px;
                border-bottom: 1px solid #edf2f7;
            }

            .bank-card-title {
                margin: 0 0 2px;
                color: var(--bank-secondary);
                font-size: 14px;
                font-weight: 800;
            }

            .bank-card-title i {
                margin-right: 7px;
                color: var(--bank-primary);
            }

            .bank-card-subtitle {
                color: var(--bank-muted);
                font-size: 9px;
            }

            .bank-card-body {
                padding: 18px;
            }

            /* =====================================================
       BOUTONS
    ===================================================== */

            .btn-bank-primary {
                color: #ffffff;
                border: 1px solid var(--bank-primary);
                border-radius: 8px;
                background: var(--bank-primary);
                font-size: 10px;
                font-weight: 800;
            }

            .btn-bank-primary:hover {
                color: #ffffff;
                border-color: var(--bank-primary-dark);
                background: var(--bank-primary-dark);
            }

            .btn-bank-outline {
                color: var(--bank-primary);
                border: 1px solid #9bd0ca;
                border-radius: 8px;
                background: #ffffff;
                font-size: 10px;
                font-weight: 800;
            }

            .btn-bank-outline:hover {
                color: #ffffff;
                border-color: var(--bank-primary);
                background: var(--bank-primary);
            }

            /* =====================================================
       ACTIONS RAPIDES
    ===================================================== */

            .bank-actions-grid {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 11px;
            }

            .bank-action-item {
                display: flex;
                align-items: center;
                min-height: 76px;
                padding: 12px;
                color: #334155;
                border: 1px solid var(--bank-border);
                border-radius: 11px;
                background: #ffffff;
                transition: all .2s ease;
                cursor: pointer;
            }

            .bank-action-item:hover {
                color: #334155;
                border-color: #99d5ce;
                box-shadow: 0 9px 22px rgba(15, 118, 110, .08);
                transform: translateY(-2px);
            }

            .bank-action-icon {
                display: flex;
                flex: 0 0 40px;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                margin-right: 10px;
                border-radius: 10px;
                font-size: 16px;
            }

            .bank-action-icon.green {
                color: #15803d;
                background: #dcfce7;
            }

            .bank-action-icon.blue {
                color: #0369a1;
                background: #e0f2fe;
            }

            .bank-action-icon.orange {
                color: #b45309;
                background: #fef3c7;
            }

            .bank-action-icon.red {
                color: #b91c1c;
                background: #fee2e2;
            }

            .bank-action-icon.purple {
                color: #6d28d9;
                background: #ede9fe;
            }

            .bank-action-item strong {
                display: block;
                margin-bottom: 3px;
                font-size: 10px;
                font-weight: 800;
            }

            .bank-action-item small {
                color: #64748b;
                font-size: 8px;
                line-height: 1.4;
            }

            /* =====================================================
       GRAPHES
    ===================================================== */

            .bank-chart-wrapper {
                position: relative;
                width: 100%;
                height: 285px;
            }

            .bank-chart-wrapper canvas {
                width: 100% !important;
                height: 100% !important;
            }

            .bank-balance-list {
                max-height: 285px;
                overflow-y: auto;
            }

            .bank-balance-item {
                margin-bottom: 17px;
            }

            .bank-balance-item:last-child {
                margin-bottom: 0;
            }

            .bank-balance-item-top {
                display: flex;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 7px;
            }

            .bank-balance-name {
                color: #334155;
                font-size: 10px;
                font-weight: 800;
            }

            .bank-balance-amount {
                color: #0f172a;
                font-size: 10px;
                font-weight: 900;
                white-space: nowrap;
            }

            .bank-balance-progress {
                height: 7px;
                overflow: hidden;
                border-radius: 20px;
                background: #e9eef3;
            }

            .bank-balance-progress span {
                display: block;
                height: 100%;
                border-radius: 20px;
                background: linear-gradient(90deg, #14b8a6, #0f766e);
            }

            /* =====================================================
       FILTRES
    ===================================================== */

            .bank-filter-box {
                margin-bottom: 18px;
                padding: 17px;
                border: 1px solid var(--bank-border);
                border-radius: 14px;
                background: #ffffff;
                box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
            }

            .bank-filter-box label {
                margin-bottom: 6px;
                color: #475569;
                font-size: 9px;
                font-weight: 800;
                text-transform: uppercase;
            }

            .bank-filter-box .form-control {
                min-height: 39px;
                border-color: #dbe4ea;
                border-radius: 8px;
                font-size: 10px;
            }

            .bank-filter-box .form-control:focus {
                border-color: var(--bank-primary);
                box-shadow: 0 0 0 .15rem rgba(15, 118, 110, .12);
            }

            .bank-filter-actions {
                display: flex;
                align-items: center;
                min-height: 39px;
            }

            /* =====================================================
       CARTES COMPTES BANCAIRES
    ===================================================== */

            .bank-account-card {
                position: relative;
                overflow: hidden;
                margin-bottom: 17px;
                border: 1px solid var(--bank-border);
                border-radius: 13px;
                background: #ffffff;
                transition: all .2s ease;
            }

            .bank-account-card:hover {
                border-color: #9bd0ca;
                box-shadow: 0 10px 25px rgba(15, 118, 110, .075);
                transform: translateY(-2px);
            }

            .bank-account-card-top {
                padding: 16px;
            }

            .bank-account-header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 18px;
            }

            .bank-account-name {
                display: flex;
                min-width: 0;
                align-items: center;
                gap: 10px;
            }

            .bank-logo-box {
                display: flex;
                flex: 0 0 45px;
                align-items: center;
                justify-content: center;
                width: 45px;
                height: 45px;
                border-radius: 11px;
                color: #0369a1;
                background: #e0f2fe;
                font-size: 18px;
            }

            .bank-account-name h6 {
                max-width: 190px;
                margin: 0 0 3px;
                overflow: hidden;
                color: #102033;
                font-size: 12px;
                font-weight: 800;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .bank-account-number {
                color: #64748b;
                font-size: 9px;
                font-weight: 600;
            }

            .bank-account-status {
                display: inline-flex;
                align-items: center;
                min-height: 22px;
                padding: 4px 8px;
                border-radius: 20px;
                font-size: 8px;
                font-weight: 800;
                text-transform: uppercase;
            }

            .bank-account-status.active {
                color: #15803d;
                background: #dcfce7;
            }

            .bank-account-status.blocked {
                color: #b91c1c;
                background: #fee2e2;
            }

            .bank-account-status.inactive {
                color: #64748b;
                background: #e2e8f0;
            }

            .bank-account-balance-label {
                margin-bottom: 4px;
                color: #64748b;
                font-size: 9px;
                font-weight: 800;
                text-transform: uppercase;
            }

            .bank-account-balance {
                margin-bottom: 5px;
                color: #0f172a;
                font-size: 21px;
                font-weight: 900;
            }

            .bank-account-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
            }

            .bank-account-meta span {
                display: inline-flex;
                align-items: center;
                min-height: 23px;
                padding: 4px 7px;
                color: #475569;
                border-radius: 20px;
                background: #f1f5f9;
                font-size: 8px;
            }

            .bank-account-meta i {
                margin-right: 4px;
                color: var(--bank-primary);
            }

            .bank-account-footer {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                border-top: 1px solid #edf2f7;
                background: #fbfdff;
            }

            .bank-account-footer-item {
                padding: 10px 7px;
                text-align: center;
                border-right: 1px solid #edf2f7;
            }

            .bank-account-footer-item:last-child {
                border-right: 0;
            }

            .bank-account-footer-item span {
                display: block;
                margin-bottom: 3px;
                color: #64748b;
                font-size: 8px;
            }

            .bank-account-footer-item strong {
                color: #102033;
                font-size: 9px;
                font-weight: 800;
            }

            .bank-account-actions {
                display: flex;
                justify-content: flex-end;
                gap: 5px;
                padding: 10px 13px;
                border-top: 1px solid #edf2f7;
            }

            .bank-table-action {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 29px;
                height: 29px;
                color: #475569;
                border: 1px solid #dbe4ea;
                border-radius: 8px;
                background: #ffffff;
                font-size: 10px;
            }

            .bank-table-action:hover {
                color: #ffffff;
                border-color: var(--bank-primary);
                background: var(--bank-primary);
            }

            /* =====================================================
       TABLEAU
    ===================================================== */

            .bank-table {
                margin-bottom: 0;
            }

            .bank-table thead th {
                padding: 11px 10px;
                color: #475569;
                border-top: 0;
                border-bottom: 1px solid #dbe4ea;
                background: #f8fafc;
                font-size: 8px;
                font-weight: 900;
                text-transform: uppercase;
                white-space: nowrap;
            }

            .bank-table tbody td {
                padding: 11px 10px;
                color: #334155;
                border-color: #edf2f7;
                font-size: 9px;
                vertical-align: middle;
            }

            .bank-table tbody tr:hover {
                background: #fbfefd;
            }

            .bank-operation-reference {
                color: #0f172a;
                font-weight: 900;
            }

            .bank-operation-badge {
                display: inline-flex;
                align-items: center;
                min-height: 23px;
                padding: 4px 8px;
                border-radius: 20px;
                font-size: 8px;
                font-weight: 800;
            }

            .bank-operation-badge.credit {
                color: #15803d;
                background: #dcfce7;
            }

            .bank-operation-badge.debit {
                color: #b91c1c;
                background: #fee2e2;
            }

            .bank-operation-badge.transfer {
                color: #0369a1;
                background: #e0f2fe;
            }

            .bank-amount-in {
                color: #15803d !important;
                font-weight: 900;
            }

            .bank-amount-out {
                color: #b91c1c !important;
                font-weight: 900;
            }

            /* =====================================================
       ALERTES
    ===================================================== */

            .bank-alert {
                display: flex;
                gap: 11px;
                margin-bottom: 11px;
                padding: 12px;
                border: 1px solid;
                border-radius: 11px;
            }

            .bank-alert:last-child {
                margin-bottom: 0;
            }

            .bank-alert.danger {
                color: #991b1b;
                border-color: #fecaca;
                background: #fef2f2;
            }

            .bank-alert.warning {
                color: #92400e;
                border-color: #fde68a;
                background: #fffbeb;
            }

            .bank-alert.info {
                color: #075985;
                border-color: #bae6fd;
                background: #f0f9ff;
            }

            .bank-alert-icon {
                display: flex;
                flex: 0 0 34px;
                align-items: center;
                justify-content: center;
                width: 34px;
                height: 34px;
                border-radius: 9px;
                background: rgba(255, 255, 255, .55);
                font-size: 14px;
            }

            .bank-alert h6 {
                margin: 0 0 4px;
                font-size: 10px;
                font-weight: 900;
            }

            .bank-alert p {
                margin: 0;
                font-size: 8px;
                line-height: 1.5;
            }

            /* =====================================================
       MODALES
    ===================================================== */

            .modal-bank .modal-content {
                overflow: hidden;
                border: 0;
                border-radius: 14px;
                box-shadow: 0 20px 55px rgba(15, 23, 42, .22);
            }

            .modal-bank .modal-header {
                color: #ffffff;
                border-bottom: 0;
                background:
                    linear-gradient(120deg,
                        #0f766e,
                        #155e75,
                        #102033);
            }

            .modal-bank .modal-title {
                font-size: 13px;
                font-weight: 800;
            }

            .modal-bank .close {
                color: #ffffff;
                opacity: 1;
            }

            .modal-bank .modal-body {
                padding: 20px;
            }

            .modal-bank label {
                margin-bottom: 6px;
                color: #475569;
                font-size: 9px;
                font-weight: 800;
            }

            .modal-bank .form-control {
                min-height: 39px;
                border-color: #dbe4ea;
                border-radius: 8px;
                font-size: 10px;
            }

            .modal-bank textarea.form-control {
                min-height: 85px;
            }

            .required-star {
                color: #dc2626;
            }

            /* =====================================================
       RESPONSIVE
    ===================================================== */

            @media (max-width: 1199px) {
                .bank-actions-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }

            @media (max-width: 991px) {
                .bank-hero-content {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .bank-actions-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .bank-filter-box .form-group {
                    margin-bottom: 13px !important;
                }
            }

            @media (max-width: 575px) {
                .bank-actions-grid {
                    grid-template-columns: 1fr;
                }

                .bank-hero {
                    padding: 18px;
                }

                .bank-hero-main {
                    flex-direction: column;
                }

                .bank-hero-date {
                    width: 100%;
                }

                .bank-filter-actions {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 7px;
                }

                .bank-filter-actions .btn {
                    margin-right: 0 !important;
                }
            }

            /* =====================================================
   RÉSUMÉ DES FLUX BANCAIRES
===================================================== */

            .bank-flow-summary {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 11px;
                margin-bottom: 17px;
            }

            .bank-flow-summary-item {
                padding: 10px 12px;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                background: #f8fafc;
            }

            .bank-flow-summary-item span {
                display: block;
                margin-bottom: 4px;
                color: #64748b;
                font-size: 8px;
                font-weight: 800;
                text-transform: uppercase;
            }

            .bank-flow-summary-item strong {
                display: block;
                font-size: 12px;
                font-weight: 900;
            }

            @media (max-width: 767px) {
                .bank-flow-summary {
                    grid-template-columns: 1fr;
                }
            }

            /* Code interne du compte */
            .bank-account-code {
                margin-top: 2px;
                color: #0f766e;
                font-size: 8px;
                font-weight: 700;
            }

            /* Compte bloqué */
            .bank-account-card-blocked {
                border-color: #fecaca;
                background:
                    linear-gradient(180deg,
                        #ffffff 0%,
                        #fffafa 100%);
            }

            .bank-account-card-blocked .bank-logo-box {
                color: #b91c1c;
                background: #fee2e2;
            }

            /* État vide */
            .bank-empty-state {
                padding: 45px 20px;
                text-align: center;
            }

            .bank-empty-state-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 62px;
                height: 62px;
                margin: 0 auto 14px;
                color: #0f766e;
                border-radius: 50%;
                background: #ccfbf1;
                font-size: 24px;
            }

            .bank-empty-state h5 {
                margin-bottom: 6px;
                color: #102033;
                font-size: 15px;
                font-weight: 800;
            }

            .bank-empty-state p {
                margin-bottom: 16px;
                color: #64748b;
                font-size: 10px;
            }
            </style>


            <div class="bank-page">

                <!-- =====================================================
         BANDEAU PRINCIPAL
    ====================================================== -->
                <div class="bank-hero">

                    <div class="bank-hero-content">

                        <div class="bank-hero-main">

                            <div class="bank-hero-icon">
                                <i class="fas fa-university"></i>
                            </div>

                            <div>
                                <h2>Gestion des comptes bancaires</h2>

                                <p>
                                    Centralisez les comptes bancaires de SATRACO,
                                    suivez les disponibilités par banque et par devise,
                                    contrôlez les mouvements et préparez les opérations
                                    de rapprochement bancaire.
                                </p>
                            </div>

                        </div>

                        <div class="bank-hero-date">

                            <span>
                                <i class="far fa-calendar-alt mr-1"></i>
                                Situation au
                            </span>

                            <strong>
                                <?= date('d/m/Y') ?>
                            </strong>

                        </div>

                    </div>

                </div>

                <?php

                /*
                * =========================================================
                * VALEURS DES STATISTIQUES BANCAIRES
                * =========================================================
                */

                $bankStats = isset($bankMainStatistics)
                    && is_array($bankMainStatistics)
                    ? $bankMainStatistics
                    : [];

                $bankCurrency = !empty($bankStats['currency'])
                    ? $bankStats['currency']
                    : 'BIF';

                $globalBankBalance = isset(
                    $bankStats['global_balance']
                )
                    ? (float) $bankStats['global_balance']
                    : 0;

                $activeBankAccounts = isset(
                    $bankStats['active_accounts']
                )
                    ? (int) $bankStats['active_accounts']
                    : 0;

                $activeBifAccounts = isset(
                    $bankStats['active_bif_accounts']
                )
                    ? (int) $bankStats['active_bif_accounts']
                    : 0;

                $bankEstablishmentsCount = isset(
                    $bankStats['bank_count']
                )
                    ? (int) $bankStats['bank_count']
                    : 0;

                $todayBankIncomeAmount = isset(
                    $bankStats['today_income_amount']
                )
                    ? (float) $bankStats['today_income_amount']
                    : 0;

                $todayBankIncomeCount = isset(
                    $bankStats['today_income_count']
                )
                    ? (int) $bankStats['today_income_count']
                    : 0;

                $todayBankExpenseAmount = isset(
                    $bankStats['today_expense_amount']
                )
                    ? (float) $bankStats['today_expense_amount']
                    : 0;

                $todayBankExpenseCount = isset(
                    $bankStats['today_expense_count']
                )
                    ? (int) $bankStats['today_expense_count']
                    : 0;

                $bankGlobalVariation = isset(
                    $bankStats['global_variation_percentage']
                )
                    ? (float) $bankStats['global_variation_percentage']
                    : 0;

                /*
                * Apparence du badge d’évolution.
                */
                $bankVariationClass =
                    'badge-neutral';

                $bankVariationIcon =
                    'fas fa-minus';

                $bankVariationPrefix = '';

                if ($bankGlobalVariation > 0) {
                    $bankVariationClass =
                        'badge-positive';

                    $bankVariationIcon =
                        'fas fa-arrow-up';

                    $bankVariationPrefix = '+';
                } elseif ($bankGlobalVariation < 0) {
                    $bankVariationClass =
                        'badge-negative';

                    $bankVariationIcon =
                        'fas fa-arrow-down';
                }

                ?>


                <!-- =====================================================
                    STATISTIQUES PRINCIPALES
                ====================================================== -->
                <div class="row">

                    <!-- =================================================
                        SOLDE BANCAIRE GLOBAL
                    ================================================== -->
                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="bank-stat-card">

                            <div class="bank-stat-top">

                                <div class="bank-stat-icon icon-green">

                                    <i class="fas fa-coins"></i>

                                </div>

                                <span class="
                                        bank-stat-badge
                                        <?= html_escape(
                                            $bankVariationClass
                                        ) ?>
                                    " title="Évolution depuis le début du mois">

                                    <i class="
                                        <?= html_escape(
                                            $bankVariationIcon
                                        ) ?>
                                        mr-1
                                    "></i>

                                    <?= $bankVariationPrefix ?>

                                    <?= number_format(
                                        abs($bankGlobalVariation),
                                        1,
                                        ',',
                                        ' '
                                    ) ?>

                                    %

                                </span>

                            </div>

                            <div class="bank-stat-label">

                                Solde bancaire global

                            </div>

                            <div class="bank-stat-value">

                                <?= number_format(
                                    $globalBankBalance,
                                    0,
                                    ',',
                                    ' '
                                ) ?>

                                <?= html_escape(
                                    $bankCurrency
                                ) ?>

                            </div>

                            <div class="bank-stat-footer">

                                <?= $activeBifAccounts ?>

                                compte<?= $activeBifAccounts > 1
                                            ? 's'
                                            : ''
                                        ?>

                                actif<?= $activeBifAccounts > 1
                                            ? 's'
                                            : ''
                                        ?>

                                en <?= html_escape($bankCurrency) ?>

                            </div>

                        </div>

                    </div>

                    <!-- =================================================
                        COMPTES ACTIFS
                    ================================================== -->
                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="bank-stat-card">

                            <div class="bank-stat-top">

                                <div class="bank-stat-icon icon-blue">

                                    <i class="fas fa-university"></i>

                                </div>

                                <span class="
                                        bank-stat-badge
                                        badge-neutral
                                    ">

                                    <?= $activeBankAccounts ?>

                                    compte<?= $activeBankAccounts > 1
                                                ? 's'
                                                : ''
                                            ?>

                                </span>

                            </div>

                            <div class="bank-stat-label">

                                Comptes actifs

                            </div>

                            <div class="bank-stat-value">

                                <?= $activeBankAccounts ?>

                            </div>

                            <div class="bank-stat-footer">

                                Réparti<?= $activeBankAccounts > 1
                                            ? 's'
                                            : ''
                                        ?>

                                dans

                                <?= $bankEstablishmentsCount ?>

                                établissement<?= $bankEstablishmentsCount > 1
                                                    ? 's'
                                                    : ''
                                                ?>

                                bancaire<?= $bankEstablishmentsCount > 1
                                            ? 's'
                                            : ''
                                        ?>

                            </div>

                        </div>

                    </div>

                    <!-- =================================================
                        ENCAISSEMENTS DU JOUR
                    ================================================== -->
                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="bank-stat-card">

                            <div class="bank-stat-top">

                                <div class="bank-stat-icon icon-orange">

                                    <i class="fas fa-arrow-down"></i>

                                </div>

                                <span class="
                                        bank-stat-badge
                                        <?= $todayBankIncomeCount > 0
                                            ? 'badge-warning'
                                            : 'badge-neutral'
                                        ?>
                                    ">

                                    <?= $todayBankIncomeCount ?>

                                    opération<?= $todayBankIncomeCount > 1
                                                    ? 's'
                                                    : ''
                                                ?>

                                </span>

                            </div>

                            <div class="bank-stat-label">

                                Encaissements bancaires du jour

                            </div>

                            <div class="bank-stat-value">

                                <?= number_format(
                                    $todayBankIncomeAmount,
                                    0,
                                    ',',
                                    ' '
                                ) ?>

                                <?= html_escape(
                                    $bankCurrency
                                ) ?>

                            </div>

                            <div class="bank-stat-footer">

                                <?php if (
                                    $todayBankIncomeCount > 0
                                ): ?>

                                Virements et dépôts validés aujourd’hui

                                <?php else: ?>

                                Aucun encaissement bancaire aujourd’hui

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                    <!-- =================================================
                        DÉCAISSEMENTS DU JOUR
                    ================================================== -->
                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="bank-stat-card">

                            <div class="bank-stat-top">

                                <div class="bank-stat-icon icon-red">

                                    <i class="fas fa-arrow-up"></i>

                                </div>

                                <span class="
                                        bank-stat-badge
                                        <?= $todayBankExpenseCount > 0
                                            ? 'badge-negative'
                                            : 'badge-neutral'
                                        ?>
                                    ">

                                    <?= $todayBankExpenseCount ?>

                                    opération<?= $todayBankExpenseCount > 1
                                                    ? 's'
                                                    : ''
                                                ?>

                                </span>

                            </div>

                            <div class="bank-stat-label">

                                Décaissements bancaires du jour

                            </div>

                            <div class="bank-stat-value">

                                <?= number_format(
                                    $todayBankExpenseAmount,
                                    0,
                                    ',',
                                    ' '
                                ) ?>

                                <?= html_escape(
                                    $bankCurrency
                                ) ?>

                            </div>

                            <div class="bank-stat-footer">

                                <?php if (
                                    $todayBankExpenseCount > 0
                                ): ?>

                                Virements et paiements validés aujourd’hui

                                <?php else: ?>

                                Aucun décaissement bancaire aujourd’hui

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                    ACTIONS RAPIDES
                ====================================================== -->
                <div class="bank-card">

                    <div class="bank-card-header">

                        <div>
                            <h5 class="bank-card-title">
                                <i class="fas fa-bolt"></i>
                                Actions rapides
                            </h5>

                            <span class="bank-card-subtitle">
                                Accédez rapidement aux principales opérations bancaires.
                            </span>
                        </div>

                    </div>

                    <div class="bank-card-body">

                        <div class="bank-actions-grid">

                            <div class="bank-action-item" data-toggle="modal" data-target="#addBankAccountModal">
                                <div class="bank-action-icon green">
                                    <i class="fas fa-plus"></i>
                                </div>

                                <div>
                                    <strong>Nouveau compte</strong>
                                    <small>Ajouter un compte bancaire</small>
                                </div>
                            </div>

                            <div class="bank-action-item" data-toggle="modal" data-target="#bankOperationModal"
                                onclick="prepareBankOperation('encaissement')">
                                <div class="bank-action-icon blue">
                                    <i class="fas fa-arrow-down"></i>
                                </div>

                                <div>
                                    <strong>Encaissement bancaire</strong>
                                    <small>Enregistrer une entrée en banque</small>
                                </div>
                            </div>

                            <div class="bank-action-item" data-toggle="modal" data-target="#bankOperationModal"
                                onclick="prepareBankOperation('decaissement')">
                                <div class="bank-action-icon red">
                                    <i class="fas fa-arrow-up"></i>
                                </div>

                                <div>
                                    <strong>Décaissement bancaire</strong>
                                    <small>Enregistrer une sortie de banque</small>
                                </div>
                            </div>

                            <div class="bank-action-item" data-toggle="modal" data-target="#bankOperationModal"
                                onclick="prepareBankOperation('transfert')">
                                <div class="bank-action-icon orange">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>

                                <div>
                                    <strong>Transfert bancaire</strong>
                                    <small>Transférer entre deux comptes</small>
                                </div>
                            </div>

                            <a href="<?= base_url('finance/rapprochement') ?>" class="bank-action-item">
                                <div class="bank-action-icon purple">
                                    <i class="fas fa-balance-scale"></i>
                                </div>

                                <div>
                                    <strong>Rapprochement</strong>
                                    <small>Comparer banque et comptabilité</small>
                                </div>
                            </a>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
     GRAPHIQUE + RÉPARTITION PAR BANQUE
====================================================== -->
                <div class="row">

                    <!-- =================================================
         ÉVOLUTION DES FLUX BANCAIRES
    ================================================== -->
                    <div class="col-xl-8 col-lg-8">

                        <div class="bank-card">

                            <div class="bank-card-header">

                                <div>

                                    <h5 class="bank-card-title">

                                        <i class="fas fa-chart-line"></i>

                                        Évolution des flux bancaires

                                    </h5>

                                    <span class="bank-card-subtitle">

                                        Comparaison des encaissements et décaissements
                                        sur la période sélectionnée.

                                    </span>

                                </div>

                                <form action="<?= current_url() ?>" method="get" id="bankFlowPeriodForm">

                                    <select name="bankflow_period" id="bankFlowPeriod"
                                        class="form-control form-control-sm" style="
                            width: 165px;
                            border-radius: 8px;
                        " onchange="
                            document
                                .getElementById(
                                    'bankFlowPeriodForm'
                                )
                                .submit();
                        ">

                                        <option value="7days" <?= $bankFlowPeriod === '7days'
                                                                    ? 'selected'
                                                                    : ''
                                                                ?>>
                                            7 derniers jours
                                        </option>

                                        <option value="30days" <?= $bankFlowPeriod === '30days'
                                                                    ? 'selected'
                                                                    : ''
                                                                ?>>
                                            30 derniers jours
                                        </option>

                                        <option value="month" <?= $bankFlowPeriod === 'month'
                                                                    ? 'selected'
                                                                    : ''
                                                                ?>>
                                            Ce mois
                                        </option>

                                        <option value="year" <?= $bankFlowPeriod === 'year'
                                                                    ? 'selected'
                                                                    : ''
                                                                ?>>
                                            Cette année
                                        </option>

                                    </select>

                                </form>

                            </div>

                            <div class="bank-card-body">

                                <?php

                                $bankFlowTotalIncome = array_sum(
                                    $bankFlowEvolution['incomes']
                                );

                                $bankFlowTotalExpense = array_sum(
                                    $bankFlowEvolution['expenses']
                                );

                                $bankFlowNet =
                                    $bankFlowTotalIncome
                                    - $bankFlowTotalExpense;

                                ?>

                                <div class="bank-flow-summary">

                                    <div class="bank-flow-summary-item">

                                        <span>
                                            Encaissements
                                        </span>

                                        <strong class="text-success">

                                            + <?= number_format(
                                                    $bankFlowTotalIncome,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) ?>

                                            BIF

                                        </strong>

                                    </div>

                                    <div class="bank-flow-summary-item">

                                        <span>
                                            Décaissements
                                        </span>

                                        <strong class="text-danger">

                                            - <?= number_format(
                                                    $bankFlowTotalExpense,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) ?>

                                            BIF

                                        </strong>

                                    </div>

                                    <div class="bank-flow-summary-item">

                                        <span>
                                            Flux net
                                        </span>

                                        <strong class="<?= $bankFlowNet >= 0
                                                            ? 'text-success'
                                                            : 'text-danger'
                                                        ?>">

                                            <?= $bankFlowNet >= 0
                                                ? '+ '
                                                : '- '
                                            ?>

                                            <?= number_format(
                                                abs($bankFlowNet),
                                                0,
                                                ',',
                                                ' '
                                            ) ?>

                                            BIF

                                        </strong>

                                    </div>

                                </div>

                                <div class="bank-chart-wrapper">

                                    <canvas id="bankFlowChart"></canvas>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- =================================================
         RÉPARTITION PAR BANQUE
    ================================================== -->
                    <div class="col-xl-4 col-lg-4">

                        <div class="bank-card">

                            <div class="bank-card-header">

                                <div>

                                    <h5 class="bank-card-title">

                                        <i class="fas fa-chart-pie"></i>

                                        Répartition par banque

                                    </h5>

                                    <span class="bank-card-subtitle">

                                        Solde disponible par établissement bancaire.

                                    </span>

                                </div>

                            </div>

                            <div class="bank-card-body">

                                <div class="bank-balance-list">

                                    <?php if (
                                        !empty($bankBalanceDistribution)
                                    ): ?>

                                    <?php foreach (
                                            $bankBalanceDistribution
                                            as $bankDistribution
                                        ): ?>

                                    <div class="bank-balance-item">

                                        <div class="bank-balance-item-top">

                                            <span class="bank-balance-name">

                                                <?= html_escape(
                                                            $bankDistribution['bank_name']
                                                        ) ?>

                                                <small class="d-block text-muted" style="font-size: 8px;">

                                                    <?= (int) $bankDistribution['account_count'] ?>

                                                    compte<?= $bankDistribution['account_count'] > 1
                                                                        ? 's'
                                                                        : ''
                                                                    ?>

                                                </small>

                                            </span>

                                            <span class="bank-balance-amount">

                                                <?= number_format(
                                                            $bankDistribution['total_balance'],
                                                            0,
                                                            ',',
                                                            ' '
                                                        ) ?>

                                                BIF

                                            </span>

                                        </div>

                                        <div class="bank-balance-progress">
                                            <span style="width: <?= number_format(
                                                                            max(
                                                                                0,
                                                                                min(
                                                                                    100,
                                                                                    (float) $bankDistribution['percentage']
                                                                                )
                                                                            ),
                                                                            2,
                                                                            '.',
                                                                            ''
                                                                        ) ?>%;"></span>
                                        </div>

                                    </div>

                                    <?php endforeach; ?>

                                    <?php else: ?>

                                    <div class="text-center py-4">

                                        <i class="
                                    fas
                                    fa-university
                                    fa-2x
                                    text-muted
                                    mb-2
                                "></i>

                                        <h6>
                                            Aucun compte bancaire
                                        </h6>

                                        <p class="text-muted mb-0">

                                            Aucun compte actif en BIF
                                            n’a été trouvé.

                                        </p>

                                    </div>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
     FILTRES DES COMPTES BANCAIRES
====================================================== -->
                <div class="bank-filter-box">

                    <form action="<?= base_url('finance/banques') ?>" method="get" id="bankAccountFilterForm">

                        <div class="row align-items-end">

                            <!-- =================================================
                 RECHERCHE
            ================================================== -->
                            <div class="col-xl-3 col-lg-3 col-md-6">

                                <div class="form-group mb-lg-0">

                                    <label for="bankSearch">
                                        Rechercher un compte
                                    </label>

                                    <div class="input-group">

                                        <input type="text" name="search" id="bankSearch" class="form-control" value="<?= html_escape(
                                                        $bankFilters['search'] ?? ''
                                                    ) ?>" placeholder="Banque, numéro ou intitulé..."
                                            autocomplete="off">

                                        <div class="input-group-append">

                                            <button type="submit" class="input-group-text" style="
                                    border-radius: 0 8px 8px 0;
                                    cursor: pointer;
                                " title="Rechercher">
                                                <i class="fas fa-search"></i>
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- =================================================
                 BANQUE
            ================================================== -->
                            <div class="col-xl-2 col-lg-2 col-md-6">

                                <div class="form-group mb-lg-0">

                                    <label for="bankNameFilter">
                                        Banque
                                    </label>

                                    <select name="bank_name" id="bankNameFilter" class="form-control">

                                        <option value="">
                                            Toutes les banques
                                        </option>

                                        <?php if (!empty($availableBanks)): ?>

                                        <?php foreach ($availableBanks as $bank): ?>

                                        <?php

                                                $bankName = is_object($bank)
                                                    ? $bank->bank_name
                                                    : $bank['bank_name'];

                                                ?>

                                        <option value="<?= html_escape($bankName) ?>" <?= (
                                                        ($bankFilters['bank_name'] ?? '')
                                                        === $bankName
                                                    )
                                                        ? 'selected'
                                                        : ''
                                                    ?>>
                                            <?= html_escape($bankName) ?>
                                        </option>

                                        <?php endforeach; ?>

                                        <?php endif; ?>

                                    </select>

                                </div>

                            </div>

                            <!-- =================================================
                 DEVISE
            ================================================== -->
                            <div class="col-xl-2 col-lg-2 col-md-6">

                                <div class="form-group mb-lg-0">

                                    <label for="bankCurrencyFilter">
                                        Devise
                                    </label>

                                    <select name="currency" id="bankCurrencyFilter" class="form-control">

                                        <option value="">
                                            Toutes
                                        </option>

                                        <option value="BIF" <?= (
                                                ($bankFilters['currency'] ?? '')
                                                === 'BIF'
                                            )
                                                ? 'selected'
                                                : ''
                                            ?>>
                                            BIF
                                        </option>

                                        <option value="USD" <?= (
                                                ($bankFilters['currency'] ?? '')
                                                === 'USD'
                                            )
                                                ? 'selected'
                                                : ''
                                            ?>>
                                            USD
                                        </option>

                                        <option value="EUR" <?= (
                                                ($bankFilters['currency'] ?? '')
                                                === 'EUR'
                                            )
                                                ? 'selected'
                                                : ''
                                            ?>>
                                            EUR
                                        </option>

                                    </select>

                                </div>

                            </div>

                            <!-- =================================================
                 STATUT
            ================================================== -->
                            <div class="col-xl-2 col-lg-2 col-md-6">

                                <div class="form-group mb-lg-0">

                                    <label for="bankStatusFilter">
                                        Statut
                                    </label>

                                    <select name="status" id="bankStatusFilter" class="form-control">

                                        <option value="">
                                            Tous
                                        </option>

                                        <option value="active" <?= (
                                                ($bankFilters['status'] ?? '')
                                                === 'active'
                                            )
                                                ? 'selected'
                                                : ''
                                            ?>>
                                            Actif
                                        </option>

                                        <option value="inactive" <?= (
                                                ($bankFilters['status'] ?? '')
                                                === 'inactive'
                                            )
                                                ? 'selected'
                                                : ''
                                            ?>>
                                            Inactif
                                        </option>

                                        <option value="blocked" <?= (
                                                ($bankFilters['status'] ?? '')
                                                === 'blocked'
                                            )
                                                ? 'selected'
                                                : ''
                                            ?>>
                                            Bloqué
                                        </option>

                                    </select>

                                </div>

                            </div>

                            <!-- =================================================
                 ACTIONS
            ================================================== -->
                            <div class="col-xl-3 col-lg-3 col-md-12">

                                <div class="bank-filter-actions">

                                    <button type="submit" class="btn btn-bank-primary mr-1">
                                        <i class="fas fa-filter mr-1"></i>
                                        Appliquer
                                    </button>

                                    <a href="<?= base_url('finance/banques') ?>" class="btn btn-bank-outline">
                                        <i class="fas fa-redo mr-1"></i>
                                        Réinitialiser
                                    </a>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <?php

                /**
                 * Formate un montant de manière compacte.
                 *
                 * Exemples :
                 * 95 500 000 => 95,5 M
                 * 425 000    => 425 K
                 * 8 500      => 8 500
                 */
                if (!function_exists('formatBankCompactAmount')) {
                    function formatBankCompactAmount($amount): string
                    {
                        $amount = (float) $amount;

                        if (abs($amount) >= 1000000000) {
                            return number_format(
                                $amount / 1000000000,
                                1,
                                ',',
                                ' '
                            ) . ' Md';
                        }

                        if (abs($amount) >= 1000000) {
                            return number_format(
                                $amount / 1000000,
                                1,
                                ',',
                                ' '
                            ) . ' M';
                        }

                        if (abs($amount) >= 100000) {
                            return number_format(
                                $amount / 1000,
                                0,
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


                <!-- =====================================================
                    LISTE DES COMPTES BANCAIRES
                ====================================================== -->
                <div class="bank-card">

                    <div class="bank-card-header">

                        <div>

                            <h5 class="bank-card-title">

                                <i class="fas fa-university"></i>

                                Situation des comptes bancaires

                            </h5>

                            <span class="bank-card-subtitle">

                                Soldes, mouvements et informations des comptes bancaires.

                            </span>

                        </div>

                        <span class="badge badge-success">

                            <?= (int) $activeBankAccountsCount ?>

                            compte<?= $activeBankAccountsCount > 1
                                        ? 's'
                                        : ''
                                    ?>

                            actif<?= $activeBankAccountsCount > 1
                                        ? 's'
                                        : ''
                                    ?>

                        </span>

                    </div>

                    <div class="bank-card-body pb-1">

                        <?php if (
                            !empty($bankAccountSituations)
                        ): ?>

                        <div class="row">

                            <?php foreach (
                                    $bankAccountSituations
                                    as $bankAccount
                                ): ?>

                            <?php

                                    /*
                     * =========================================
                     * BANQUE
                     * =========================================
                     */

                                    $bankLabels = [
                                        'CRDB' =>
                                        'CRDB Bank',

                                        'BANCOBU' =>
                                        'BANCOBU',

                                        'ECOBANK' =>
                                        'ECOBANK',

                                        'KCB' =>
                                        'KCB Bank',

                                        'BCB' =>
                                        'BCB',

                                        'BHB' =>
                                        'BHB',

                                        'INTERBANK' =>
                                        'Interbank Burundi',
                                    ];

                                    $displayBankName =
                                        $bankLabels[$bankAccount->bank_name]
                                        ?? $bankAccount->bank_name;

                                    /*
                     * =========================================
                     * TYPE DE COMPTE
                     * =========================================
                     */

                                    $accountTypeLabels = [
                                        'courant' =>
                                        'Compte courant',

                                        'epargne' =>
                                        'Compte épargne',

                                        'garantie' =>
                                        'Compte de garantie',

                                        'projet' =>
                                        'Compte projet',

                                        'credit' =>
                                        'Ligne de crédit',
                                    ];

                                    $displayAccountType =
                                        $accountTypeLabels[$bankAccount->account_type]
                                        ?? ucfirst(
                                            $bankAccount->account_type
                                        );

                                    /*
                     * =========================================
                     * STATUT
                     * =========================================
                     */

                                    $statusClass =
                                        'inactive';

                                    $statusLabel =
                                        'Inactif';

                                    if (
                                        $bankAccount->status
                                        === 'active'
                                    ) {
                                        $statusClass =
                                            'active';

                                        $statusLabel =
                                            'Actif';
                                    } elseif (
                                        $bankAccount->status
                                        === 'blocked'
                                    ) {
                                        $statusClass =
                                            'blocked';

                                        $statusLabel =
                                            'Bloqué';
                                    }

                                    /*
                     * =========================================
                     * LIBELLÉ DU SOLDE
                     * =========================================
                     */

                                    $balanceLabel =
                                        $bankAccount->account_type
                                        === 'garantie'
                                        ? 'Solde réservé'
                                        : 'Solde disponible';

                                    /*
                     * =========================================
                     * ICÔNE DE LA DEVISE
                     * =========================================
                     */

                                    $currencyIcon =
                                        'fas fa-money-bill';

                                    if (
                                        $bankAccount->currency
                                        === 'USD'
                                    ) {
                                        $currencyIcon =
                                            'fas fa-dollar-sign';
                                    } elseif (
                                        $bankAccount->currency
                                        === 'EUR'
                                    ) {
                                        $currencyIcon =
                                            'fas fa-euro-sign';
                                    }

                                    /*
                     * =========================================
                     * BOUTON JOURNAL
                     * =========================================
                     */

                                    $showJournalButton =
                                        (int) $bankAccount
                                            ->monthly_operations > 0;

                                    ?>

                            <div class="
                            col-xl-4
                            col-lg-6
                            col-md-6
                        ">

                                <div class="
                                bank-account-card
                                <?= $bankAccount->status
                                        === 'blocked'
                                        ? 'bank-account-card-blocked'
                                        : ''
                                ?>
                            ">

                                    <div class="bank-account-card-top">

                                        <div class="bank-account-header">

                                            <div class="bank-account-name">

                                                <div class="bank-logo-box">

                                                    <i class="
                                                    fas
                                                    fa-university
                                                "></i>

                                                </div>

                                                <div>

                                                    <h6 title="<?= html_escape(
                                                                            $bankAccount->name
                                                                        ) ?>">

                                                        <?= html_escape(
                                                                    $bankAccount->name
                                                                ) ?>

                                                    </h6>

                                                    <div class="
                                                    bank-account-number
                                                ">

                                                        <?= html_escape(
                                                                    $bankAccount
                                                                        ->account_number
                                                                ) ?>

                                                    </div>

                                                    <div class="
                                                    bank-account-code
                                                ">

                                                        <?= html_escape(
                                                                    $bankAccount->code
                                                                ) ?>

                                                    </div>

                                                </div>

                                            </div>

                                            <span class="
                                            bank-account-status
                                            <?= html_escape(
                                                $statusClass
                                            ) ?>
                                        ">

                                                <?= html_escape(
                                                            $statusLabel
                                                        ) ?>

                                            </span>

                                        </div>

                                        <div class="
                                        bank-account-balance-label
                                    ">

                                            <?= html_escape(
                                                        $balanceLabel
                                                    ) ?>

                                        </div>

                                        <div class="
                                        bank-account-balance
                                    ">

                                            <?= number_format(
                                                        (float) $bankAccount
                                                            ->current_balance,
                                                        0,
                                                        ',',
                                                        ' '
                                                    ) ?>

                                            <?= html_escape(
                                                        $bankAccount->currency
                                                    ) ?>

                                        </div>

                                        <div class="bank-account-meta">

                                            <span>

                                                <i class="
                                                fas
                                                fa-building
                                            "></i>

                                                <?= html_escape(
                                                            $displayBankName
                                                        ) ?>

                                            </span>

                                            <span>

                                                <i class="<?= html_escape(
                                                                        $currencyIcon
                                                                    ) ?>"></i>

                                                <?= html_escape(
                                                            $bankAccount->currency
                                                        ) ?>

                                            </span>

                                            <span>

                                                <i class="
                                                fas
                                                fa-tag
                                            "></i>

                                                <?= html_escape(
                                                            $displayAccountType
                                                        ) ?>

                                            </span>

                                            <?php if (
                                                        !empty($bankAccount
                                                            ->branch_name)
                                                    ): ?>

                                            <span>

                                                <i class="
                                                    fas
                                                    fa-map-marker-alt
                                                "></i>

                                                <?= html_escape(
                                                                $bankAccount
                                                                    ->branch_name
                                                            ) ?>

                                            </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                    <div class="bank-account-footer">

                                        <div class="
                                        bank-account-footer-item
                                    ">

                                            <span>
                                                Entrées mois
                                            </span>

                                            <strong class="text-success">

                                                <?= formatBankCompactAmount(
                                                            $bankAccount
                                                                ->monthly_entries
                                                        ) ?>

                                            </strong>

                                        </div>

                                        <div class="
                                        bank-account-footer-item
                                    ">

                                            <span>
                                                Sorties mois
                                            </span>

                                            <strong class="text-danger">

                                                <?= formatBankCompactAmount(
                                                            $bankAccount
                                                                ->monthly_outputs
                                                        ) ?>

                                            </strong>

                                        </div>

                                        <div class="
                                        bank-account-footer-item
                                    ">

                                            <span>
                                                Opérations
                                            </span>

                                            <strong>

                                                <?= (int) $bankAccount
                                                            ->monthly_operations
                                                        ?>

                                            </strong>

                                        </div>

                                    </div>

                                    <div class="bank-account-actions">

                                        <!-- Voir -->
                                        <button type="button" class="
                                        bank-table-action
                                        btn-view-bank-account
                                    " title="Voir le compte" onclick="viewBankAccount(
                                        <?= (int) $bankAccount->id ?>
                                    )">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                        <!-- Modifier -->
                                        <button type="button" class="
                                        bank-table-action
                                        btn-edit-bank-account
                                    " title="Modifier le compte" onclick="editBankAccount(
                                        <?= (int) $bankAccount->id ?>
                                    )">

                                            <i class="fas fa-edit"></i>

                                        </button>

                                        <!-- Journal -->
                                        <?php if (
                                                    $showJournalButton
                                                ): ?>

                                        <a href="<?= base_url(
                                                                    'finance/banques/journal/'
                                                                        . (int) $bankAccount->id
                                                                ) ?>" class="
                                            bank-table-action
                                        " title="Voir le journal">

                                            <i class="fas fa-list"></i>

                                        </a>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </div>

                            <?php endforeach; ?>

                        </div>

                        <?php else: ?>

                        <div class="bank-empty-state">

                            <div class="bank-empty-state-icon">

                                <i class="fas fa-university"></i>

                            </div>

                            <h5>
                                Aucun compte bancaire
                            </h5>

                            <p>
                                Aucun compte bancaire n’a encore été enregistré.
                            </p>

                            <button type="button" class="btn btn-bank-primary" data-toggle="modal"
                                data-target="#addBankAccountModal">

                                <i class="fas fa-plus mr-1"></i>

                                Créer un compte bancaire

                            </button>

                        </div>

                        <?php endif; ?>

                    </div>

                </div>


                <div class="row">
                    <!-- =====================================================
                    MOUVEMENTS BANCAIRES RÉCENTS
                ====================================================== -->
                    <div class="col-xl-8 col-lg-8">

                        <div class="bank-card">

                            <div class="bank-card-header">

                                <div>

                                    <h5 class="bank-card-title">

                                        <i class="fas fa-exchange-alt"></i>

                                        Mouvements bancaires récents

                                    </h5>

                                    <span class="bank-card-subtitle">

                                        Derniers virements, dépôts, retraits et transferts enregistrés.

                                    </span>

                                </div>

                                <a href="<?= base_url(
                                                'finance/banques/journal'
                                            ) ?>" class="btn btn-bank-outline">

                                    <i class="fas fa-list mr-1"></i>

                                    Voir tout le journal

                                </a>

                            </div>

                            <div class="table-responsive">

                                <table class="table bank-table">

                                    <thead>

                                        <tr>

                                            <th>#</th>

                                            <th>Date</th>

                                            <th>Référence</th>

                                            <th>Compte</th>

                                            <th>Type</th>

                                            <th>Libellé</th>

                                            <th class="text-right">
                                                Débit
                                            </th>

                                            <th class="text-right">
                                                Crédit
                                            </th>

                                            <th>Statut</th>

                                            <th class="text-center">
                                                Actions
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php if (
                                            !empty($recentBankOperations)
                                        ): ?>

                                        <?php foreach (
                                                $recentBankOperations
                                                as $index => $operation
                                            ): ?>

                                        <?php

                                                /*
                                            * =====================================
                                            * INFORMATIONS DU COMPTE À AFFICHER
                                            * =====================================
                                            */

                                                $accountName =
                                                    'Compte bancaire';

                                                $accountNumber =
                                                    '—';

                                                $accountCode =
                                                    '';

                                                /*
                                            * Encaissement :
                                            * le compte destination reçoit l'argent.
                                            */
                                                if (
                                                    $operation->operation_type
                                                    === 'encaissement'
                                                ) {
                                                    $accountName =
                                                        $operation
                                                        ->destination_account_name
                                                        ?: 'Compte destination';

                                                    $accountNumber =
                                                        $operation
                                                        ->destination_account_number
                                                        ?: '—';

                                                    $accountCode =
                                                        $operation
                                                        ->destination_account_code
                                                        ?: '';
                                                }

                                                /*
                                            * Décaissement et transfert :
                                            * le compte source fournit l'argent.
                                            */
                                                if (
                                                    in_array(
                                                        $operation->operation_type,
                                                        [
                                                            'decaissement',
                                                            'transfert',
                                                        ],
                                                        true
                                                    )
                                                ) {
                                                    $accountName =
                                                        $operation
                                                        ->source_account_name
                                                        ?: 'Compte source';

                                                    $accountNumber =
                                                        $operation
                                                        ->source_account_number
                                                        ?: '—';

                                                    $accountCode =
                                                        $operation
                                                        ->source_account_code
                                                        ?: '';
                                                }

                                                /*
                                            * =====================================
                                            * TYPE D'OPÉRATION
                                            * =====================================
                                            */

                                                $operationTypeLabel =
                                                    'Opération';

                                                $operationBadgeClass =
                                                    'transfer';

                                                $operationIcon =
                                                    'fas fa-exchange-alt';

                                                if (
                                                    $operation->operation_type
                                                    === 'encaissement'
                                                ) {
                                                    $operationTypeLabel =
                                                        'Crédit';

                                                    $operationBadgeClass =
                                                        'credit';

                                                    $operationIcon =
                                                        'fas fa-arrow-down';
                                                } elseif (
                                                    $operation->operation_type
                                                    === 'decaissement'
                                                ) {
                                                    $operationTypeLabel =
                                                        'Débit';

                                                    $operationBadgeClass =
                                                        'debit';

                                                    $operationIcon =
                                                        'fas fa-arrow-up';
                                                } elseif (
                                                    $operation->operation_type
                                                    === 'transfert'
                                                ) {
                                                    $operationTypeLabel =
                                                        'Transfert';

                                                    $operationBadgeClass =
                                                        'transfer';

                                                    $operationIcon =
                                                        'fas fa-exchange-alt';
                                                }

                                                /*
                                            * =====================================
                                            * STATUT
                                            * =====================================
                                            */

                                                $statusLabel =
                                                    'En attente';

                                                $statusClass =
                                                    'badge-warning';

                                                if (
                                                    $operation->status
                                                    === 'validated'
                                                ) {
                                                    $statusLabel =
                                                        'Validé';

                                                    $statusClass =
                                                        'badge-success';
                                                } elseif (
                                                    $operation->status
                                                    === 'cancelled'
                                                ) {
                                                    $statusLabel =
                                                        'Annulé';

                                                    $statusClass =
                                                        'badge-danger';
                                                } elseif (
                                                    $operation->status
                                                    === 'pending'
                                                ) {
                                                    $statusLabel =
                                                        'En attente';

                                                    $statusClass =
                                                        'badge-warning';
                                                }

                                                /*
                                            * =====================================
                                            * DATE ET HEURE
                                            * =====================================
                                            */

                                                $operationDate =
                                                    !empty($operation->operation_date)
                                                    ? date(
                                                        'd/m/Y',
                                                        strtotime(
                                                            $operation
                                                                ->operation_date
                                                        )
                                                    )
                                                    : '—';

                                                $operationTime =
                                                    !empty($operation->created_at)
                                                    ? date(
                                                        'H:i',
                                                        strtotime(
                                                            $operation
                                                                ->created_at
                                                        )
                                                    )
                                                    : '';

                                                /*
                                            * =====================================
                                            * SOUS-LIBELLÉ
                                            * =====================================
                                            */

                                                $operationSubtitle = '';

                                                if (
                                                    $operation->operation_type
                                                    === 'encaissement'
                                                ) {
                                                    $operationSubtitle =
                                                        !empty($operation->third_party)
                                                        ? 'Provenance : '
                                                        . $operation
                                                        ->third_party
                                                        : 'Entrée bancaire';
                                                } elseif (
                                                    $operation->operation_type
                                                    === 'decaissement'
                                                ) {
                                                    $operationSubtitle =
                                                        !empty($operation->third_party)
                                                        ? 'Bénéficiaire : '
                                                        . $operation
                                                        ->third_party
                                                        : 'Sortie bancaire';
                                                } elseif (
                                                    $operation->operation_type
                                                    === 'transfert'
                                                ) {
                                                    $operationSubtitle =
                                                        'Destination : '
                                                        . (
                                                            $operation
                                                            ->destination_account_name
                                                            ?: 'Compte destination'
                                                        );
                                                }

                                                ?>

                                        <tr>

                                            <td>

                                                <?= $index + 1 ?>

                                            </td>

                                            <td>

                                                <?= html_escape(
                                                            $operationDate
                                                        ) ?>

                                                <?php if (
                                                            $operationTime !== ''
                                                        ): ?>

                                                <small class="
                                                d-block
                                                text-muted
                                            ">

                                                    <?= html_escape(
                                                                    $operationTime
                                                                ) ?>

                                                </small>

                                                <?php endif; ?>

                                            </td>

                                            <td>

                                                <span class="
                                            bank-operation-reference
                                        ">

                                                    <?= html_escape(
                                                                $operation->reference
                                                            ) ?>

                                                </span>

                                            </td>

                                            <td>

                                                <strong>

                                                    <?= html_escape(
                                                                $accountName
                                                            ) ?>

                                                </strong>

                                                <small class="
                                                d-block
                                                text-muted
                                            ">

                                                    <?= html_escape(
                                                                $accountNumber
                                                            ) ?>

                                                </small>

                                                <?php if (
                                                            $accountCode !== ''
                                                        ): ?>

                                                <small class="
                                                d-block
                                                text-muted
                                            " style="
                                                color: #0f766e
                                                    !important;
                                            ">

                                                    <?= html_escape(
                                                                    $accountCode
                                                                ) ?>

                                                </small>

                                                <?php endif; ?>

                                            </td>

                                            <td>

                                                <span class="
                                            bank-operation-badge
                                            <?= html_escape(
                                                    $operationBadgeClass
                                                ) ?>
                                        ">

                                                    <i class="
                                                <?= html_escape(
                                                    $operationIcon
                                                ) ?>
                                                mr-1
                                            "></i>

                                                    <?= html_escape(
                                                                $operationTypeLabel
                                                            ) ?>

                                                </span>

                                            </td>

                                            <td>

                                                <strong>

                                                    <?= html_escape(
                                                                $operation->label
                                                            ) ?>

                                                </strong>

                                                <?php if (
                                                            $operationSubtitle !== ''
                                                        ): ?>

                                                <small class="
                                                d-block
                                                text-muted
                                            ">

                                                    <?= html_escape(
                                                                    $operationSubtitle
                                                                ) ?>

                                                </small>

                                                <?php endif; ?>

                                                <?php if (
                                                            !empty($operation
                                                                ->document_number)
                                                        ): ?>

                                                <small class="
                                                d-block
                                                text-muted
                                            ">

                                                    Pièce :

                                                    <?= html_escape(
                                                                    $operation
                                                                        ->document_number
                                                                ) ?>

                                                </small>

                                                <?php endif; ?>

                                            </td>

                                            <!-- DÉBIT -->
                                            <td class="text-right">

                                                <?php if (
                                                            in_array(
                                                                $operation
                                                                    ->operation_type,
                                                                [
                                                                    'decaissement',
                                                                    'transfert',
                                                                ],
                                                                true
                                                            )
                                                        ): ?>

                                                <span class="
                                                bank-amount-out
                                            ">

                                                    -

                                                    <?= number_format(
                                                                    (float)
                                                                    $operation->amount,
                                                                    0,
                                                                    ',',
                                                                    ' '
                                                                ) ?>

                                                    <?= html_escape(
                                                                    $operation->currency
                                                                ) ?>

                                                </span>

                                                <?php else: ?>

                                                <span class="text-muted">
                                                    —
                                                </span>

                                                <?php endif; ?>

                                            </td>

                                            <!-- CRÉDIT -->
                                            <td class="text-right">

                                                <?php if (
                                                            $operation->operation_type
                                                            === 'encaissement'
                                                        ): ?>

                                                <span class="
                                                bank-amount-in
                                            ">

                                                    +

                                                    <?= number_format(
                                                                    (float)
                                                                    $operation->amount,
                                                                    0,
                                                                    ',',
                                                                    ' '
                                                                ) ?>

                                                    <?= html_escape(
                                                                    $operation->currency
                                                                ) ?>

                                                </span>

                                                <?php else: ?>

                                                <span class="text-muted">
                                                    —
                                                </span>

                                                <?php endif; ?>

                                            </td>

                                            <td>

                                                <span class="
                                            badge
                                            <?= html_escape(
                                                    $statusClass
                                                ) ?>
                                        ">

                                                    <?= html_escape(
                                                                $statusLabel
                                                            ) ?>

                                                </span>

                                            </td>

                                            <td class="text-center">

                                                <!-- Voir -->
                                                <button type="button" class="
                                                    bank-table-action
                                                    btn-view-bank-operation
                                                " title="Voir l’opération" onclick="viewBankOperation(
                                                    <?= (int)
                                                    $operation->id
                                                    ?>
                                                )">

                                                    <i class="fas fa-eye"></i>

                                                </button>

                                                <!-- Pièce jointe -->
                                                <?php if (
                                                            !empty($operation->attachment)
                                                        ): ?>

                                                <a href="<?= base_url(
                                                                            'uploads/finance/'
                                                                                . 'bank_operations/'
                                                                                . rawurlencode(
                                                                                    $operation
                                                                                        ->attachment
                                                                                )
                                                                        ) ?>" class="
                                                            bank-table-action
                                                        " title="Voir la pièce justificative" target="_blank">

                                                    <i class="
                                                    fas
                                                    fa-paperclip
                                                "></i>

                                                </a>

                                                <?php endif; ?>

                                                <!-- Imprimer -->
                                                <a href="<?= base_url(
                                                                        'finance/banques/'
                                                                            . 'operation-print/'
                                                                            . (int) $operation->id
                                                                    ) ?>" class="
                                                        bank-table-action
                                                    " title="Imprimer" target="_blank">

                                                    <i class="fas fa-print"></i>

                                                </a>

                                            </td>

                                        </tr>

                                        <?php endforeach; ?>

                                        <?php else: ?>

                                        <tr>

                                            <td colspan="10" class="text-center py-5">

                                                <i class="
                                                fas
                                                fa-exchange-alt
                                                fa-2x
                                                text-muted
                                                mb-3
                                            "></i>

                                                <h6>
                                                    Aucun mouvement bancaire
                                                </h6>

                                                <p class="text-muted mb-0">

                                                    Aucune opération bancaire
                                                    n’a encore été enregistrée.

                                                </p>

                                            </td>

                                        </tr>

                                        <?php endif; ?>

                                    </tbody>

                                </table>

                            </div>

                            <?php if (
                                !empty($recentBankOperations)
                            ): ?>

                            <div class="
                                p-3
                                border-top
                                d-flex
                                justify-content-between
                                align-items-center
                            ">

                                <small class="text-muted">

                                    Affichage de 1 à

                                    <?= count(
                                            $recentBankOperations
                                        ) ?>

                                    sur

                                    <?= (int) $bankOperationsCount ?>

                                    opération<?= $bankOperationsCount > 1
                                                        ? 's'
                                                        : ''
                                                    ?>

                                </small>

                                <?php if (
                                        $bankOperationsCount
                                        > count($recentBankOperations)
                                    ): ?>

                                <a href="<?= base_url(
                                                        'finance/banques/journal'
                                                    ) ?>" class="btn btn-bank-outline">

                                    Voir les

                                    <?= (int) $bankOperationsCount ?>

                                    opérations

                                    <i class="
                                            fas
                                            fa-arrow-right
                                            ml-1
                                        "></i>

                                </a>

                                <?php endif; ?>

                            </div>

                            <?php endif; ?>

                        </div>

                    </div>

                    <!-- =====================================================
                    ALERTES BANCAIRES
                ====================================================== -->
                    <div class="col-xl-4 col-lg-4">

                        <div class="bank-card">

                            <div class="bank-card-header">

                                <div>

                                    <h5 class="bank-card-title">

                                        <i class="fas fa-exclamation-triangle"></i>

                                        Alertes bancaires

                                    </h5>

                                    <span class="bank-card-subtitle">

                                        Situations nécessitant une vérification.

                                    </span>

                                </div>

                                <span class="
                                badge
                                <?= $bankAlertsCount > 0
                                    ? 'badge-danger'
                                    : 'badge-success'
                                ?>
                            ">

                                    <?= (int) $bankAlertsCount ?>

                                    alerte<?= $bankAlertsCount > 1
                                                ? 's'
                                                : ''
                                            ?>

                                </span>

                            </div>

                            <div class="bank-card-body">

                                <?php if (
                                    !empty($bankAlerts)
                                ): ?>

                                <?php foreach (
                                        $bankAlerts
                                        as $alert
                                    ): ?>

                                <?php

                                        $alertClass = 'info';

                                        if (
                                            $alert['type']
                                            === 'warning'
                                        ) {
                                            $alertClass =
                                                'warning';
                                        } elseif (
                                            $alert['type']
                                            === 'danger'
                                        ) {
                                            $alertClass =
                                                'danger';
                                        }

                                        ?>

                                <div class="
                            bank-alert
                                <?= html_escape(
                                            $alertClass
                                        ) ?>
                            ">

                                    <div class="bank-alert-icon">

                                        <i class="<?= html_escape(
                                                                $alert['icon']
                                                            ) ?>"></i>

                                    </div>

                                    <div class="bank-alert-content">

                                        <h6>

                                            <?= html_escape(
                                                        $alert['title']
                                                    ) ?>

                                        </h6>

                                        <p>

                                            <?= html_escape(
                                                        $alert['description']
                                                    ) ?>

                                        </p>

                                        <div class="
                                        bank-alert-actions
                                        mt-2
                                    ">

                                            <?php if (
                                                        !empty($alert['operation_id'])
                                                    ): ?>

                                            <button type="button" class="
                                            btn
                                            btn-sm
                                            btn-bank-outline
                                        " onclick="viewBankOperation(
                                            <?= (int) $alert['operation_id'] ?>
                                        )">

                                                <i class="
                                                fas
                                                fa-eye
                                                mr-1
                                            "></i>

                                                Voir l’opération

                                            </button>

                                            <?php endif; ?>

                                            <?php if (
                                                        !empty($alert['account_id'])
                                                    ): ?>

                                            <button type="button" class="
                                            btn
                                            btn-sm
                                            btn-bank-outline
                                        " onclick="viewBankAccount(
                                            <?= (int) $alert['account_id'] ?>
                                        )">

                                                <i class="
                                                fas
                                                fa-university
                                                mr-1
                                            "></i>

                                                Voir le compte

                                            </button>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </div>

                                <?php endforeach; ?>

                                <?php else: ?>

                                <div class="
                                text-center
                                py-5
                            ">

                                    <div class="
                                    bank-alert-empty-icon
                                    mb-3
                                ">

                                        <i class="
                                        fas
                                        fa-check-circle
                                    "></i>

                                    </div>

                                    <h6 style="
                                    font-weight: 800;
                                    color: #102033;
                                ">

                                        Aucune alerte bancaire

                                    </h6>

                                    <p class="
                                    text-muted
                                    mb-0
                                " style="
                                    font-size: 9px;
                                ">

                                        Les comptes et opérations bancaires
                                        ne présentent aucune anomalie.

                                    </p>

                                </div>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>
                </div>




            </div>


            <!-- =========================================================
                MODALE : CRÉER UN COMPTE BANCAIRE
            ========================================================== -->
            <div class="modal fade modal-bank" id="addBankAccountModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <form action="<?= base_url('bank-account-store') ?>" method="post">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    <i class="fas fa-university mr-2"></i>
                                    Créer un compte bancaire
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
                                                Code du compte
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="text" name="code" class="form-control"
                                                value="<?= html_escape($nextBankAccountCode ?? '') ?>" readonly>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Intitulé du compte
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="text" name="name" class="form-control" value="<?= html_escape(
                                                                                                            $bankAccountOldInput['name']
                                                                                                                ?? ''
                                                                                                        ) ?>"
                                                placeholder="Ex. CRDB BIF" required>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Banque
                                                <span class="required-star">*</span>
                                            </label>

                                            <select name="bank_name" class="form-control" required>
                                                <option value="">
                                                    Sélectionner
                                                </option>

                                                <option value="CRDB" <?= (
                                                                            $bankAccountOldInput['bank_name']
                                                                            ?? ''
                                                                        ) === 'CRDB'
                                                                            ? 'selected'
                                                                            : ''
                                                                        ?>>
                                                    CRDB Bank
                                                </option>

                                                <option value="BANCOBU" <?= (
                                                                            $bankAccountOldInput['bank_name']
                                                                            ?? ''
                                                                        ) === 'BANCOBU'
                                                                            ? 'selected'
                                                                            : ''
                                                                        ?>>
                                                    BANCOBU
                                                </option>

                                                <option value="ECOBANK" <?= (
                                                                            $bankAccountOldInput['bank_name']
                                                                            ?? ''
                                                                        ) === 'ECOBANK'
                                                                            ? 'selected'
                                                                            : ''
                                                                        ?>>
                                                    ECOBANK
                                                </option>

                                                <option value="KCB" <?= (
                                                                        $bankAccountOldInput['bank_name']
                                                                        ?? ''
                                                                    ) === 'KCB'
                                                                        ? 'selected'
                                                                        : ''
                                                                    ?>>
                                                    KCB Bank
                                                </option>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Numéro de compte
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="text" name="account_number" class="form-control"
                                                placeholder="Numéro officiel du compte" required>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Type de compte
                                                <span class="required-star">*</span>
                                            </label>

                                            <select name="account_type" class="form-control" required>
                                                <option value="">
                                                    Sélectionner
                                                </option>

                                                <option value="courant">
                                                    Compte courant
                                                </option>

                                                <option value="epargne">
                                                    Compte épargne
                                                </option>

                                                <option value="garantie">
                                                    Compte de garantie
                                                </option>

                                                <option value="projet">
                                                    Compte projet
                                                </option>

                                                <option value="credit">
                                                    Ligne de crédit
                                                </option>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Devise
                                                <span class="required-star">*</span>
                                            </label>

                                            <select name="currency" class="form-control" required>
                                                <option value="BIF">
                                                    BIF
                                                </option>

                                                <option value="USD">
                                                    USD
                                                </option>

                                                <option value="EUR">
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

                                            <input type="number" name="opening_balance" class="form-control" min="0"
                                                step="0.01" value="0">

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Seuil d’alerte
                                            </label>

                                            <input type="number" name="alert_threshold" class="form-control" min="0"
                                                step="0.01" value="0">

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Agence bancaire
                                            </label>

                                            <input type="text" name="branch_name" class="form-control"
                                                placeholder="Ex. Agence siège Bujumbura">

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Code SWIFT
                                            </label>

                                            <input type="text" name="swift_code" class="form-control"
                                                placeholder="Ex. ECOCBIBI">

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group mb-0">

                                            <label>
                                                Observation
                                            </label>

                                            <textarea name="observation" class="form-control"
                                                placeholder="Informations complémentaires..."></textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-bank-outline" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>
                                    Annuler
                                </button>

                                <button type="submit" class="btn btn-bank-primary">
                                    <i class="fas fa-save mr-1"></i>
                                    Enregistrer le compte
                                </button>

                            </div>

                        </div>

                    </form>

                </div>
            </div>


            <!-- =========================================================
                MODALE : OPÉRATION BANCAIRE
            ========================================================== -->
            <div class="modal fade modal-bank" id="bankOperationModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <form action="<?= base_url('bank-operation-store') ?>" method="post" enctype="multipart/form-data"
                        id="bankOperationForm" style="width: 100%;">

                        <input type="hidden" name="operation_type" id="bankOperationType">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">

                                    <i class="fas fa-exchange-alt mr-2"></i>

                                    <span id="bankOperationTitle">
                                        Nouvelle opération bancaire
                                    </span>

                                </h5>

                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>

                            </div>

                            <div class="modal-body">

                                <div class="row">

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

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Référence
                                                <span class="required-star">*</span>
                                            </label>

                                            <input type="text" name="reference" class="form-control" value="<?= html_escape(
                                                                                                                $nextBankOperationReference ?? ''
                                                                                                            ) ?>"
                                                readonly>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label id="bankSourceLabel">
                                                Compte concerné
                                                <span class="required-star">*</span>
                                            </label>

                                            <select name="bank_account_id" id="bankSourceAccount" class="form-control"
                                                required>
                                                <option value="">
                                                    Sélectionner le compte
                                                </option>

                                                <?php if (!empty($allBankAccounts)): ?>

                                                <?php foreach ($allBankAccounts as $account): ?>

                                                <option value="<?= (int) $account->id ?>"
                                                    data-currency="<?= html_escape($account->currency) ?>"
                                                    data-balance="<?= (float) $account->current_balance ?>"
                                                    data-name="<?= html_escape($account->name) ?>">
                                                    <?= html_escape($account->code) ?>

                                                    —

                                                    <?= html_escape($account->name) ?>

                                                    —

                                                    <?= number_format(
                                                                (float) $account->current_balance,
                                                                2,
                                                                ',',
                                                                ' '
                                                            ) ?>

                                                    <?= html_escape($account->currency) ?>
                                                </option>

                                                <?php endforeach; ?>

                                                <?php endif; ?>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-4" id="bankDestinationField" style="display: none;">

                                        <div class="form-group">

                                            <label>
                                                Compte destination
                                                <span class="required-star">*</span>
                                            </label>

                                            <select name="destination_bank_account_id" id="bankDestinationAccount"
                                                class="form-control">
                                                <option value="">
                                                    Sélectionner la destination
                                                </option>

                                                <?php if (!empty($allBankAccounts)): ?>

                                                <?php foreach ($allBankAccounts as $account): ?>

                                                <option value="<?= (int) $account->id ?>"
                                                    data-currency="<?= html_escape($account->currency) ?>"
                                                    data-balance="<?= (float) $account->current_balance ?>">
                                                    <?= html_escape($account->code) ?>

                                                    —

                                                    <?= html_escape($account->name) ?>

                                                    —

                                                    <?= number_format(
                                                                (float) $account->current_balance,
                                                                2,
                                                                ',',
                                                                ' '
                                                            ) ?>

                                                    <?= html_escape($account->currency) ?>
                                                </option>

                                                <?php endforeach; ?>

                                                <?php endif; ?>
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

                                                <input type="number" name="amount" class="form-control" min="0"
                                                    step="0.01" placeholder="0" required>

                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="bankOperationCurrency">
                                                        BIF
                                                    </span>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Catégorie
                                            </label>

                                            <select name="category" class="form-control">
                                                <option value="">
                                                    Sélectionner
                                                </option>

                                                <option value="paiement_client">
                                                    Paiement client
                                                </option>

                                                <option value="avance_marche">
                                                    Avance de marché
                                                </option>

                                                <option value="fournisseur">
                                                    Paiement fournisseur
                                                </option>

                                                <option value="salaire">
                                                    Salaires
                                                </option>

                                                <option value="sous_traitance">
                                                    Sous-traitance
                                                </option>

                                                <option value="impot">
                                                    Impôts et taxes
                                                </option>

                                                <option value="transfert">
                                                    Transfert interne
                                                </option>

                                                <option value="autre">
                                                    Autre
                                                </option>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Tiers / Bénéficiaire
                                            </label>

                                            <input type="text" name="third_party" class="form-control"
                                                placeholder="Client, fournisseur ou bénéficiaire">

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Mode d’opération
                                            </label>

                                            <select name="payment_method" class="form-control">
                                                <option value="transfer">
                                                    Virement bancaire
                                                </option>

                                                <option value="deposit">
                                                    Dépôt bancaire
                                                </option>

                                                <option value="cheque">
                                                    Chèque
                                                </option>

                                                <option value="withdrawal">
                                                    Retrait
                                                </option>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Numéro de pièce
                                            </label>

                                            <input type="text" name="document_number" class="form-control"
                                                placeholder="Bordereau, chèque, avis de débit...">

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Pièce justificative
                                            </label>

                                            <div class="custom-file">

                                                <input type="file" name="attachment" class="custom-file-input"
                                                    id="bankAttachment">

                                                <label class="custom-file-label" for="bankAttachment">
                                                    Choisir un fichier
                                                </label>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group mb-0">

                                            <label>
                                                Libellé / Observation
                                                <span class="required-star">*</span>
                                            </label>

                                            <textarea name="label" class="form-control"
                                                placeholder="Décrivez clairement l’opération bancaire..."
                                                required></textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-bank-outline" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>
                                    Annuler
                                </button>

                                <button type="submit" class="btn btn-bank-primary">
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

                    const bankChartElement =
                        document.getElementById(
                            'bankFlowChart'
                        );

                    if (
                        !bankChartElement ||
                        typeof Chart === 'undefined'
                    ) {
                        return;
                    }

                    const bankFlowLabels =
                        <?= json_encode(
                                $bankFlowEvolution['labels'],
                                JSON_UNESCAPED_UNICODE
                                    | JSON_UNESCAPED_SLASHES
                            ) ?>;

                    const bankFlowIncomes =
                        <?= json_encode(
                                array_map(
                                    'floatval',
                                    $bankFlowEvolution['incomes']
                                )
                            ) ?>;

                    const bankFlowExpenses =
                        <?= json_encode(
                                array_map(
                                    'floatval',
                                    $bankFlowEvolution['expenses']
                                )
                            ) ?>;

                    const context =
                        bankChartElement.getContext('2d');

                    const incomeGradient =
                        context.createLinearGradient(
                            0,
                            0,
                            0,
                            270
                        );

                    incomeGradient.addColorStop(
                        0,
                        'rgba(15, 118, 110, 0.30)'
                    );

                    incomeGradient.addColorStop(
                        1,
                        'rgba(15, 118, 110, 0.02)'
                    );

                    const expenseGradient =
                        context.createLinearGradient(
                            0,
                            0,
                            0,
                            270
                        );

                    expenseGradient.addColorStop(
                        0,
                        'rgba(220, 38, 38, 0.20)'
                    );

                    expenseGradient.addColorStop(
                        1,
                        'rgba(220, 38, 38, 0.01)'
                    );

                    new Chart(
                        context, {
                            type: 'line',

                            data: {
                                labels: bankFlowLabels,

                                datasets: [{
                                        label: 'Encaissements bancaires',

                                        data: bankFlowIncomes,

                                        borderColor: '#0f766e',

                                        backgroundColor: incomeGradient,

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
                                        label: 'Décaissements bancaires',

                                        data: bankFlowExpenses,

                                        borderColor: '#dc2626',

                                        backgroundColor: expenseGradient,

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

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (
    $this->session->flashdata('success')
): ?>

<script>
Swal.fire({
    icon: 'success',
    title: 'Compte bancaire créé',
    html: <?= json_encode(
                        $this->session->flashdata(
                            'success'
                        )
                    ) ?>,
    confirmButtonText: 'D’accord',
    confirmButtonColor: '#0f766e'
});
</script>

<?php endif; ?>

<?php if (
    $this->session->flashdata('error')
): ?>

<script>
Swal.fire({
    icon: 'error',
    title: 'Enregistrement impossible',
    html: <?= json_encode(
                        $this->session->flashdata(
                            'error'
                        )
                    ) ?>,
    confirmButtonText: 'Corriger',
    confirmButtonColor: '#dc2626'
});
</script>

<?php endif; ?>


<script>
function prepareBankOperation(type) {

    const form =
        document.getElementById(
            'bankOperationForm'
        );

    const title =
        document.getElementById(
            'bankOperationTitle'
        );

    const operationType =
        document.getElementById(
            'bankOperationType'
        );

    const sourceLabel =
        document.getElementById(
            'bankSourceLabel'
        );

    const sourceAccount =
        document.getElementById(
            'bankSourceAccount'
        );

    const destinationField =
        document.getElementById(
            'bankDestinationField'
        );

    const destinationAccount =
        document.getElementById(
            'bankDestinationAccount'
        );

    if (!operationType) {
        return;
    }

    /*
     * Réinitialiser le formulaire.
     */
    if (form) {
        form.reset();
    }

    operationType.value = type;

    destinationField.style.display =
        'none';

    destinationAccount.disabled =
        true;

    destinationAccount.required =
        false;

    destinationAccount.value =
        '';

    /*
     * Encaissement.
     */
    if (type === 'encaissement') {
        title.textContent =
            'Enregistrer un encaissement bancaire';

        sourceLabel.innerHTML =
            'Compte à créditer ' +
            '<span class="required-star">*</span>';
    }

    /*
     * Décaissement.
     */
    else if (type === 'decaissement') {
        title.textContent =
            'Enregistrer un décaissement bancaire';

        sourceLabel.innerHTML =
            'Compte à débiter ' +
            '<span class="required-star">*</span>';
    }

    /*
     * Transfert.
     */
    else if (type === 'transfert') {
        title.textContent =
            'Effectuer un transfert bancaire';

        sourceLabel.innerHTML =
            'Compte source ' +
            '<span class="required-star">*</span>';

        destinationField.style.display =
            'block';

        destinationAccount.disabled =
            false;

        destinationAccount.required =
            true;
    }

    /*
     * Remettre la date actuelle après reset.
     */
    const dateField =
        form.querySelector(
            '[name="operation_date"]'
        );

    if (dateField) {
        dateField.value =
            new Date()
            .toISOString()
            .split('T')[0];
    }
}

$(document).on(
    'change',
    '.custom-file-input',
    function() {

        const fileName =
            $(this)
            .val()
            .split('\\')
            .pop();

        $(this)
            .next('.custom-file-label')
            .html(
                fileName ||
                'Choisir un fichier'
            );
    }
);


/*
 * Mettre à jour la devise affichée.
 */
$(document).on(
    'change',
    '#bankSourceAccount',
    function() {

        const option =
            $(this)
            .find('option:selected');

        const currency =
            option.data('currency') ||
            'BIF';

        $('#bankOperationCurrency')
            .text(currency);
    }
);


/*
 * Empêcher la sélection du même compte
 * comme source et destination.
 */
$(document).on(
    'change',
    '#bankSourceAccount, #bankDestinationAccount',
    function() {

        const sourceId =
            $('#bankSourceAccount').val();

        const destinationId =
            $('#bankDestinationAccount').val();

        if (
            sourceId &&
            destinationId &&
            sourceId === destinationId
        ) {
            Swal.fire({
                icon: 'warning',
                title: 'Comptes identiques',
                text: 'Le compte source et le compte destination doivent être différents.',
                confirmButtonText: 'Corriger',
                confirmButtonColor: '#0f766e'
            });

            $('#bankDestinationAccount')
                .val('');
        }
    }
);
</script>


<?php if ($this->session->flashdata('success')): ?>

<script>
Swal.fire({
    icon: 'success',
    title: 'Opération enregistrée',
    html: <?= json_encode(
                        $this->session->flashdata(
                            'success'
                        )
                    ) ?>,
    confirmButtonText: 'D’accord',
    confirmButtonColor: '#0f766e'
});
</script>

<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>

<script>
Swal.fire({
    icon: 'error',
    title: 'Enregistrement impossible',
    html: <?= json_encode(
                        $this->session->flashdata(
                            'error'
                        )
                    ) ?>,
    confirmButtonText: 'Corriger',
    confirmButtonColor: '#dc2626'
});
</script>

<?php endif; ?>