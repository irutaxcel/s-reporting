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


                <!-- =====================================================
         STATISTIQUES PRINCIPALES
    ====================================================== -->
                <div class="row">

                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="bank-stat-card">

                            <div class="bank-stat-top">

                                <div class="bank-stat-icon icon-green">
                                    <i class="fas fa-coins"></i>
                                </div>

                                <span class="bank-stat-badge badge-positive">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    6,8 %
                                </span>

                            </div>

                            <div class="bank-stat-label">
                                Solde bancaire global
                            </div>

                            <div class="bank-stat-value">
                                485 750 000 BIF
                            </div>

                            <div class="bank-stat-footer">
                                Tous les comptes actifs en BIF
                            </div>

                        </div>

                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="bank-stat-card">

                            <div class="bank-stat-top">

                                <div class="bank-stat-icon icon-blue">
                                    <i class="fas fa-university"></i>
                                </div>

                                <span class="bank-stat-badge badge-neutral">
                                    6 comptes
                                </span>

                            </div>

                            <div class="bank-stat-label">
                                Comptes actifs
                            </div>

                            <div class="bank-stat-value">
                                6
                            </div>

                            <div class="bank-stat-footer">
                                Répartis dans 4 établissements bancaires
                            </div>

                        </div>

                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="bank-stat-card">

                            <div class="bank-stat-top">

                                <div class="bank-stat-icon icon-orange">
                                    <i class="fas fa-arrow-down"></i>
                                </div>

                                <span class="bank-stat-badge badge-warning">
                                    12 opérations
                                </span>

                            </div>

                            <div class="bank-stat-label">
                                Encaissements bancaires du jour
                            </div>

                            <div class="bank-stat-value">
                                48 500 000 BIF
                            </div>

                            <div class="bank-stat-footer">
                                Virements et dépôts reçus aujourd’hui
                            </div>

                        </div>

                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="bank-stat-card">

                            <div class="bank-stat-top">

                                <div class="bank-stat-icon icon-red">
                                    <i class="fas fa-arrow-up"></i>
                                </div>

                                <span class="bank-stat-badge badge-negative">
                                    8 opérations
                                </span>

                            </div>

                            <div class="bank-stat-label">
                                Décaissements bancaires du jour
                            </div>

                            <div class="bank-stat-value">
                                31 200 000 BIF
                            </div>

                            <div class="bank-stat-footer">
                                Virements et paiements effectués aujourd’hui
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
                                        des 7 derniers jours.
                                    </span>
                                </div>

                                <select class="form-control form-control-sm" style="width: 155px; border-radius: 8px;">
                                    <option>7 derniers jours</option>
                                    <option>30 derniers jours</option>
                                    <option>Ce mois</option>
                                    <option>Cette année</option>
                                </select>

                            </div>

                            <div class="bank-card-body">

                                <div class="bank-chart-wrapper">
                                    <canvas id="bankFlowChart"></canvas>
                                </div>

                            </div>

                        </div>

                    </div>

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

                                    <div class="bank-balance-item">

                                        <div class="bank-balance-item-top">
                                            <span class="bank-balance-name">
                                                CRDB Bank
                                            </span>

                                            <span class="bank-balance-amount">
                                                210 500 000 BIF
                                            </span>
                                        </div>

                                        <div class="bank-balance-progress">
                                            <span style="width: 100%;"></span>
                                        </div>

                                    </div>

                                    <div class="bank-balance-item">

                                        <div class="bank-balance-item-top">
                                            <span class="bank-balance-name">
                                                BANCOBU
                                            </span>

                                            <span class="bank-balance-amount">
                                                125 000 000 BIF
                                            </span>
                                        </div>

                                        <div class="bank-balance-progress">
                                            <span style="width: 59%;"></span>
                                        </div>

                                    </div>

                                    <div class="bank-balance-item">

                                        <div class="bank-balance-item-top">
                                            <span class="bank-balance-name">
                                                ECOBANK
                                            </span>

                                            <span class="bank-balance-amount">
                                                95 250 000 BIF
                                            </span>
                                        </div>

                                        <div class="bank-balance-progress">
                                            <span style="width: 45%;"></span>
                                        </div>

                                    </div>

                                    <div class="bank-balance-item">

                                        <div class="bank-balance-item-top">
                                            <span class="bank-balance-name">
                                                KCB Bank
                                            </span>

                                            <span class="bank-balance-amount">
                                                55 000 000 BIF
                                            </span>
                                        </div>

                                        <div class="bank-balance-progress">
                                            <span style="width: 26%;"></span>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
         FILTRES
    ====================================================== -->
                <div class="bank-filter-box">

                    <div class="row align-items-end">

                        <div class="col-xl-3 col-lg-3 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label>
                                    Rechercher un compte
                                </label>

                                <div class="input-group">

                                    <input type="text" class="form-control" placeholder="Banque, numéro ou intitulé...">

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

                                <label>
                                    Banque
                                </label>

                                <select class="form-control">
                                    <option value="">Toutes les banques</option>
                                    <option>CRDB Bank</option>
                                    <option>BANCOBU</option>
                                    <option>ECOBANK</option>
                                    <option>KCB Bank</option>
                                </select>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label>
                                    Devise
                                </label>

                                <select class="form-control">
                                    <option value="">Toutes</option>
                                    <option value="BIF">BIF</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                </select>

                            </div>

                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label>
                                    Statut
                                </label>

                                <select class="form-control">
                                    <option value="">Tous</option>
                                    <option value="active">Actif</option>
                                    <option value="inactive">Inactif</option>
                                    <option value="blocked">Bloqué</option>
                                </select>

                            </div>

                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-12">

                            <div class="bank-filter-actions">

                                <button class="btn btn-bank-primary mr-1">
                                    <i class="fas fa-filter mr-1"></i>
                                    Appliquer
                                </button>

                                <button class="btn btn-bank-outline">
                                    <i class="fas fa-redo mr-1"></i>
                                    Réinitialiser
                                </button>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
         LISTE DES COMPTES
    ====================================================== -->
                <div class="bank-card">

                    <div class="bank-card-header">

                        <div>
                            <h5 class="bank-card-title">
                                <i class="fas fa-university"></i>
                                Situation des comptes bancaires
                            </h5>

                            <span class="bank-card-subtitle">
                                Soldes, mouvements et informations des comptes actifs.
                            </span>
                        </div>

                        <span class="badge badge-success">
                            6 comptes actifs
                        </span>

                    </div>

                    <div class="bank-card-body pb-1">

                        <div class="row">

                            <!-- CRDB BIF -->
                            <div class="col-xl-4 col-lg-6 col-md-6">

                                <div class="bank-account-card">

                                    <div class="bank-account-card-top">

                                        <div class="bank-account-header">

                                            <div class="bank-account-name">

                                                <div class="bank-logo-box">
                                                    <i class="fas fa-university"></i>
                                                </div>

                                                <div>
                                                    <h6>CRDB BIF</h6>

                                                    <div class="bank-account-number">
                                                        0151001002456
                                                    </div>
                                                </div>

                                            </div>

                                            <span class="bank-account-status active">
                                                Actif
                                            </span>

                                        </div>

                                        <div class="bank-account-balance-label">
                                            Solde disponible
                                        </div>

                                        <div class="bank-account-balance">
                                            185 500 000 BIF
                                        </div>

                                        <div class="bank-account-meta">

                                            <span>
                                                <i class="fas fa-building"></i>
                                                CRDB Bank
                                            </span>

                                            <span>
                                                <i class="fas fa-money-bill"></i>
                                                BIF
                                            </span>

                                            <span>
                                                <i class="fas fa-tag"></i>
                                                Compte courant
                                            </span>

                                        </div>

                                    </div>

                                    <div class="bank-account-footer">

                                        <div class="bank-account-footer-item">
                                            <span>Entrées mois</span>
                                            <strong>95,5 M</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Sorties mois</span>
                                            <strong>68,2 M</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Opérations</span>
                                            <strong>48</strong>
                                        </div>

                                    </div>

                                    <div class="bank-account-actions">

                                        <button class="bank-table-action" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="bank-table-action" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="bank-table-action" title="Journal">
                                            <i class="fas fa-list"></i>
                                        </button>

                                    </div>

                                </div>

                            </div>

                            <!-- CRDB USD -->
                            <div class="col-xl-4 col-lg-6 col-md-6">

                                <div class="bank-account-card">

                                    <div class="bank-account-card-top">

                                        <div class="bank-account-header">

                                            <div class="bank-account-name">

                                                <div class="bank-logo-box">
                                                    <i class="fas fa-university"></i>
                                                </div>

                                                <div>
                                                    <h6>CRDB USD</h6>

                                                    <div class="bank-account-number">
                                                        0151001006892
                                                    </div>
                                                </div>

                                            </div>

                                            <span class="bank-account-status active">
                                                Actif
                                            </span>

                                        </div>

                                        <div class="bank-account-balance-label">
                                            Solde disponible
                                        </div>

                                        <div class="bank-account-balance">
                                            8 500 USD
                                        </div>

                                        <div class="bank-account-meta">

                                            <span>
                                                <i class="fas fa-building"></i>
                                                CRDB Bank
                                            </span>

                                            <span>
                                                <i class="fas fa-dollar-sign"></i>
                                                USD
                                            </span>

                                            <span>
                                                <i class="fas fa-tag"></i>
                                                Compte courant
                                            </span>

                                        </div>

                                    </div>

                                    <div class="bank-account-footer">

                                        <div class="bank-account-footer-item">
                                            <span>Entrées mois</span>
                                            <strong>12 500</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Sorties mois</span>
                                            <strong>6 200</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Opérations</span>
                                            <strong>16</strong>
                                        </div>

                                    </div>

                                    <div class="bank-account-actions">

                                        <button class="bank-table-action">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="bank-table-action">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="bank-table-action">
                                            <i class="fas fa-list"></i>
                                        </button>

                                    </div>

                                </div>

                            </div>

                            <!-- ECOBANK -->
                            <div class="col-xl-4 col-lg-6 col-md-6">

                                <div class="bank-account-card">

                                    <div class="bank-account-card-top">

                                        <div class="bank-account-header">

                                            <div class="bank-account-name">

                                                <div class="bank-logo-box">
                                                    <i class="fas fa-university"></i>
                                                </div>

                                                <div>
                                                    <h6>ECOBANK BIF</h6>

                                                    <div class="bank-account-number">
                                                        001458963247
                                                    </div>
                                                </div>

                                            </div>

                                            <span class="bank-account-status active">
                                                Actif
                                            </span>

                                        </div>

                                        <div class="bank-account-balance-label">
                                            Solde disponible
                                        </div>

                                        <div class="bank-account-balance">
                                            95 250 000 BIF
                                        </div>

                                        <div class="bank-account-meta">

                                            <span>
                                                <i class="fas fa-building"></i>
                                                ECOBANK
                                            </span>

                                            <span>
                                                <i class="fas fa-money-bill"></i>
                                                BIF
                                            </span>

                                            <span>
                                                <i class="fas fa-tag"></i>
                                                Compte courant
                                            </span>

                                        </div>

                                    </div>

                                    <div class="bank-account-footer">

                                        <div class="bank-account-footer-item">
                                            <span>Entrées mois</span>
                                            <strong>42,3 M</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Sorties mois</span>
                                            <strong>31,8 M</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Opérations</span>
                                            <strong>27</strong>
                                        </div>

                                    </div>

                                    <div class="bank-account-actions">

                                        <button class="bank-table-action">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="bank-table-action">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="bank-table-action">
                                            <i class="fas fa-list"></i>
                                        </button>

                                    </div>

                                </div>

                            </div>

                            <!-- BANCOBU -->
                            <div class="col-xl-4 col-lg-6 col-md-6">

                                <div class="bank-account-card">

                                    <div class="bank-account-card-top">

                                        <div class="bank-account-header">

                                            <div class="bank-account-name">

                                                <div class="bank-logo-box">
                                                    <i class="fas fa-university"></i>
                                                </div>

                                                <div>
                                                    <h6>BANCOBU BIF</h6>

                                                    <div class="bank-account-number">
                                                        202658710236
                                                    </div>
                                                </div>

                                            </div>

                                            <span class="bank-account-status active">
                                                Actif
                                            </span>

                                        </div>

                                        <div class="bank-account-balance-label">
                                            Solde disponible
                                        </div>

                                        <div class="bank-account-balance">
                                            125 000 000 BIF
                                        </div>

                                        <div class="bank-account-meta">

                                            <span>
                                                <i class="fas fa-building"></i>
                                                BANCOBU
                                            </span>

                                            <span>
                                                <i class="fas fa-money-bill"></i>
                                                BIF
                                            </span>

                                            <span>
                                                <i class="fas fa-tag"></i>
                                                Compte courant
                                            </span>

                                        </div>

                                    </div>

                                    <div class="bank-account-footer">

                                        <div class="bank-account-footer-item">
                                            <span>Entrées mois</span>
                                            <strong>62,5 M</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Sorties mois</span>
                                            <strong>45,2 M</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Opérations</span>
                                            <strong>32</strong>
                                        </div>

                                    </div>

                                    <div class="bank-account-actions">

                                        <button class="bank-table-action">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="bank-table-action">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="bank-table-action">
                                            <i class="fas fa-list"></i>
                                        </button>

                                    </div>

                                </div>

                            </div>

                            <!-- KCB -->
                            <div class="col-xl-4 col-lg-6 col-md-6">

                                <div class="bank-account-card">

                                    <div class="bank-account-card-top">

                                        <div class="bank-account-header">

                                            <div class="bank-account-name">

                                                <div class="bank-logo-box">
                                                    <i class="fas fa-university"></i>
                                                </div>

                                                <div>
                                                    <h6>KCB USD</h6>

                                                    <div class="bank-account-number">
                                                        321785469001
                                                    </div>
                                                </div>

                                            </div>

                                            <span class="bank-account-status active">
                                                Actif
                                            </span>

                                        </div>

                                        <div class="bank-account-balance-label">
                                            Solde disponible
                                        </div>

                                        <div class="bank-account-balance">
                                            17 600 USD
                                        </div>

                                        <div class="bank-account-meta">

                                            <span>
                                                <i class="fas fa-building"></i>
                                                KCB Bank
                                            </span>

                                            <span>
                                                <i class="fas fa-dollar-sign"></i>
                                                USD
                                            </span>

                                            <span>
                                                <i class="fas fa-tag"></i>
                                                Compte courant
                                            </span>

                                        </div>

                                    </div>

                                    <div class="bank-account-footer">

                                        <div class="bank-account-footer-item">
                                            <span>Entrées mois</span>
                                            <strong>24 000</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Sorties mois</span>
                                            <strong>13 400</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Opérations</span>
                                            <strong>21</strong>
                                        </div>

                                    </div>

                                    <div class="bank-account-actions">

                                        <button class="bank-table-action">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="bank-table-action">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="bank-table-action">
                                            <i class="fas fa-list"></i>
                                        </button>

                                    </div>

                                </div>

                            </div>

                            <!-- Compte bloqué -->
                            <div class="col-xl-4 col-lg-6 col-md-6">

                                <div class="bank-account-card">

                                    <div class="bank-account-card-top">

                                        <div class="bank-account-header">

                                            <div class="bank-account-name">

                                                <div class="bank-logo-box">
                                                    <i class="fas fa-university"></i>
                                                </div>

                                                <div>
                                                    <h6>CRDB Garantie</h6>

                                                    <div class="bank-account-number">
                                                        0151001009002
                                                    </div>
                                                </div>

                                            </div>

                                            <span class="bank-account-status blocked">
                                                Bloqué
                                            </span>

                                        </div>

                                        <div class="bank-account-balance-label">
                                            Solde réservé
                                        </div>

                                        <div class="bank-account-balance">
                                            25 000 000 BIF
                                        </div>

                                        <div class="bank-account-meta">

                                            <span>
                                                <i class="fas fa-building"></i>
                                                CRDB Bank
                                            </span>

                                            <span>
                                                <i class="fas fa-lock"></i>
                                                Compte de garantie
                                            </span>

                                        </div>

                                    </div>

                                    <div class="bank-account-footer">

                                        <div class="bank-account-footer-item">
                                            <span>Entrées mois</span>
                                            <strong>0</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Sorties mois</span>
                                            <strong>0</strong>
                                        </div>

                                        <div class="bank-account-footer-item">
                                            <span>Opérations</span>
                                            <strong>0</strong>
                                        </div>

                                    </div>

                                    <div class="bank-account-actions">

                                        <button class="bank-table-action">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="bank-table-action">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
         MOUVEMENTS RÉCENTS + ALERTES
    ====================================================== -->
                <div class="row">

                    <div class="col-xl-8 col-lg-8">

                        <div class="bank-card">

                            <div class="bank-card-header">

                                <div>
                                    <h5 class="bank-card-title">
                                        <i class="fas fa-exchange-alt"></i>
                                        Mouvements bancaires récents
                                    </h5>

                                    <span class="bank-card-subtitle">
                                        Derniers virements, dépôts, retraits et transferts.
                                    </span>
                                </div>

                                <button class="btn btn-bank-outline">
                                    <i class="fas fa-list mr-1"></i>
                                    Voir tout le journal
                                </button>

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
                                            <th class="text-right">Débit</th>
                                            <th class="text-right">Crédit</th>
                                            <th>Statut</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr>
                                            <td>1</td>

                                            <td>
                                                13/07/2026
                                                <small class="d-block text-muted">
                                                    10:42
                                                </small>
                                            </td>

                                            <td>
                                                <span class="bank-operation-reference">
                                                    BMV-2026-00048
                                                </span>
                                            </td>

                                            <td>
                                                <strong>CRDB BIF</strong>
                                                <small class="d-block text-muted">
                                                    0151001002456
                                                </small>
                                            </td>

                                            <td>
                                                <span class="bank-operation-badge credit">
                                                    <i class="fas fa-arrow-down mr-1"></i>
                                                    Crédit
                                                </span>
                                            </td>

                                            <td>
                                                Paiement client marché Gitega
                                                <small class="d-block text-muted">
                                                    Provenance : Ministère
                                                </small>
                                            </td>

                                            <td class="text-right text-muted">
                                                —
                                            </td>

                                            <td class="text-right bank-amount-in">
                                                + 25 000 000
                                            </td>

                                            <td>
                                                <span class="badge badge-success">
                                                    Validé
                                                </span>
                                            </td>

                                            <td class="text-center">

                                                <button class="bank-table-action">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="bank-table-action">
                                                    <i class="fas fa-print"></i>
                                                </button>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>2</td>

                                            <td>
                                                13/07/2026
                                                <small class="d-block text-muted">
                                                    09:25
                                                </small>
                                            </td>

                                            <td>
                                                <span class="bank-operation-reference">
                                                    BMV-2026-00047
                                                </span>
                                            </td>

                                            <td>
                                                <strong>BANCOBU BIF</strong>
                                                <small class="d-block text-muted">
                                                    202658710236
                                                </small>
                                            </td>

                                            <td>
                                                <span class="bank-operation-badge debit">
                                                    <i class="fas fa-arrow-up mr-1"></i>
                                                    Débit
                                                </span>
                                            </td>

                                            <td>
                                                Paiement fournisseur ciment
                                                <small class="d-block text-muted">
                                                    Bénéficiaire : BUCECO
                                                </small>
                                            </td>

                                            <td class="text-right bank-amount-out">
                                                - 8 500 000
                                            </td>

                                            <td class="text-right text-muted">
                                                —
                                            </td>

                                            <td>
                                                <span class="badge badge-success">
                                                    Validé
                                                </span>
                                            </td>

                                            <td class="text-center">

                                                <button class="bank-table-action">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="bank-table-action">
                                                    <i class="fas fa-print"></i>
                                                </button>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>3</td>

                                            <td>
                                                12/07/2026
                                                <small class="d-block text-muted">
                                                    16:35
                                                </small>
                                            </td>

                                            <td>
                                                <span class="bank-operation-reference">
                                                    BMV-2026-00046
                                                </span>
                                            </td>

                                            <td>
                                                <strong>CRDB BIF</strong>
                                                <small class="d-block text-muted">
                                                    0151001002456
                                                </small>
                                            </td>

                                            <td>
                                                <span class="bank-operation-badge transfer">
                                                    <i class="fas fa-exchange-alt mr-1"></i>
                                                    Transfert
                                                </span>
                                            </td>

                                            <td>
                                                Transfert vers ECOBANK
                                                <small class="d-block text-muted">
                                                    Destination : ECOBANK BIF
                                                </small>
                                            </td>

                                            <td class="text-right bank-amount-out">
                                                - 15 000 000
                                            </td>

                                            <td class="text-right text-muted">
                                                —
                                            </td>

                                            <td>
                                                <span class="badge badge-warning">
                                                    En attente
                                                </span>
                                            </td>

                                            <td class="text-center">

                                                <button class="bank-table-action">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="bank-table-action">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>4</td>

                                            <td>
                                                12/07/2026
                                                <small class="d-block text-muted">
                                                    11:05
                                                </small>
                                            </td>

                                            <td>
                                                <span class="bank-operation-reference">
                                                    BMV-2026-00045
                                                </span>
                                            </td>

                                            <td>
                                                <strong>ECOBANK BIF</strong>
                                                <small class="d-block text-muted">
                                                    001458963247
                                                </small>
                                            </td>

                                            <td>
                                                <span class="bank-operation-badge debit">
                                                    <i class="fas fa-arrow-up mr-1"></i>
                                                    Débit
                                                </span>
                                            </td>

                                            <td>
                                                Paiement sous-traitant
                                                <small class="d-block text-muted">
                                                    Bénéficiaire : ABC Construction
                                                </small>
                                            </td>

                                            <td class="text-right bank-amount-out">
                                                - 6 700 000
                                            </td>

                                            <td class="text-right text-muted">
                                                —
                                            </td>

                                            <td>
                                                <span class="badge badge-danger">
                                                    Justificatif
                                                </span>
                                            </td>

                                            <td class="text-center">

                                                <button class="bank-table-action">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="bank-table-action">
                                                    <i class="fas fa-paperclip"></i>
                                                </button>

                                            </td>
                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

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

                                <span class="badge badge-danger">
                                    3 alertes
                                </span>

                            </div>

                            <div class="bank-card-body">

                                <div class="bank-alert warning">

                                    <div class="bank-alert-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>

                                    <div>
                                        <h6>Virement en attente</h6>

                                        <p>
                                            Le transfert de 15 000 000 BIF de CRDB
                                            vers ECOBANK attend une validation.
                                        </p>
                                    </div>

                                </div>

                                <div class="bank-alert danger">

                                    <div class="bank-alert-icon">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>

                                    <div>
                                        <h6>Justificatif manquant</h6>

                                        <p>
                                            Une opération de 6 700 000 BIF ne possède
                                            pas encore de pièce justificative.
                                        </p>
                                    </div>

                                </div>

                                <div class="bank-alert info">

                                    <div class="bank-alert-icon">
                                        <i class="fas fa-balance-scale"></i>
                                    </div>

                                    <div>
                                        <h6>Rapprochement à effectuer</h6>

                                        <p>
                                            Le compte CRDB BIF n’a pas encore été
                                            rapproché pour le mois de juillet.
                                        </p>
                                    </div>

                                </div>

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
            document.addEventListener('DOMContentLoaded', function() {

                const bankChartElement =
                    document.getElementById('bankFlowChart');

                if (
                    bankChartElement &&
                    typeof Chart !== 'undefined'
                ) {
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
                                labels: [
                                    '07 Juil.',
                                    '08 Juil.',
                                    '09 Juil.',
                                    '10 Juil.',
                                    '11 Juil.',
                                    '12 Juil.',
                                    '13 Juil.'
                                ],

                                datasets: [{
                                        label: 'Encaissements bancaires',

                                        data: [
                                            25000000,
                                            34000000,
                                            19000000,
                                            42000000,
                                            28500000,
                                            38000000,
                                            48500000
                                        ],

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

                                        data: [
                                            18000000,
                                            27000000,
                                            15500000,
                                            33500000,
                                            22000000,
                                            26500000,
                                            31200000
                                        ],

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
                                            label: function(context) {
                                                return (
                                                    context.dataset.label +
                                                    ' : ' +
                                                    new Intl
                                                    .NumberFormat('fr-FR')
                                                    .format(
                                                        context.parsed.y
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
                                                return (
                                                    value / 1000000
                                                ) + ' M';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    );
                }
            });


            // function prepareBankOperation(type) {

            //     const title =
            //         document.getElementById(
            //             'bankOperationTitle'
            //         );

            //     const operationType =
            //         document.getElementById(
            //             'bankOperationType'
            //         );

            //     const destinationField =
            //         document.getElementById(
            //             'bankDestinationField'
            //         );

            //     const destinationSelect =
            //         document.getElementById(
            //             'bankDestinationAccount'
            //         );

            //     const sourceLabel =
            //         document.getElementById(
            //             'bankSourceLabel'
            //         );

            //     operationType.value = type;

            //     destinationField.style.display = 'none';
            //     destinationSelect.disabled = true;
            //     destinationSelect.required = false;
            //     destinationSelect.value = '';

            //     if (type === 'encaissement') {

            //         title.innerHTML =
            //             'Enregistrer un encaissement bancaire';

            //         sourceLabel.innerHTML =
            //             'Compte à créditer ' +
            //             '<span class="required-star">*</span>';
            //     }

            //     if (type === 'decaissement') {

            //         title.innerHTML =
            //             'Enregistrer un décaissement bancaire';

            //         sourceLabel.innerHTML =
            //             'Compte à débiter ' +
            //             '<span class="required-star">*</span>';
            //     }

            //     if (type === 'transfert') {

            //         title.innerHTML =
            //             'Effectuer un transfert bancaire';

            //         sourceLabel.innerHTML =
            //             'Compte source ' +
            //             '<span class="required-star">*</span>';

            //         destinationField.style.display = 'block';
            //         destinationSelect.disabled = false;
            //         destinationSelect.required = true;
            //     }
            // }


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