<!-- =========================================================
     PAGE : ADMINISTRATION DES UTILISATEURS
     Table utilisée : users
========================================================= -->

<style>
    :root {
        --users-primary: #17695f;
        --users-primary-dark: #0e4f48;
        --users-primary-light: #e8f5f2;
        --users-success: #28a745;
        --users-warning: #f0ad4e;
        --users-danger: #dc3545;
        --users-info: #17a2b8;
        --users-muted: #6c757d;
        --users-border: #e5e9ee;
        --users-bg: #f4f6f9;
        --users-white: #ffffff;
        --users-shadow: 0 7px 25px rgba(31, 45, 61, 0.08);
    }

    /* =========================================================
       EN-TÊTE DE PAGE
    ========================================================= */

    .users-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 22px;
    }

    .users-page-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .users-page-title-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg,
                var(--users-primary),
                var(--users-primary-dark));
        color: #fff;
        font-size: 22px;
        box-shadow: 0 8px 20px rgba(23, 105, 95, 0.22);
    }

    .users-page-title h3 {
        margin: 0;
        font-size: 23px;
        font-weight: 700;
        color: #25313c;
    }

    .users-page-title p {
        margin: 4px 0 0;
        color: #7b8794;
        font-size: 13px;
    }

    .btn-add-user {
        border: none;
        background: linear-gradient(135deg,
                var(--users-primary),
                var(--users-primary-dark));
        color: #fff;
        padding: 11px 18px;
        border-radius: 9px;
        font-weight: 600;
        font-size: 13px;
        box-shadow: 0 7px 18px rgba(23, 105, 95, 0.22);
        transition: all 0.25s ease;
    }

    .btn-add-user:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(23, 105, 95, 0.28);
    }

    /* =========================================================
       CARTES STATISTIQUES
    ========================================================= */

    .users-stat-card {
        position: relative;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--users-border);
        border-radius: 13px;
        box-shadow: var(--users-shadow);
        padding: 18px;
        height: 100%;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .users-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(31, 45, 61, 0.12);
    }

    .users-stat-card::before {
        content: "";
        position: absolute;
        width: 90px;
        height: 90px;
        right: -28px;
        top: -30px;
        border-radius: 50%;
        opacity: 0.09;
        background: currentColor;
    }

    .users-stat-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .users-stat-label {
        font-size: 12px;
        color: #7a8793;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .users-stat-number {
        margin-top: 7px;
        font-size: 26px;
        line-height: 1;
        font-weight: 800;
        color: #25313c;
    }

    .users-stat-note {
        margin-top: 9px;
        color: #8b96a1;
        font-size: 11px;
    }

    .users-stat-icon {
        min-width: 49px;
        width: 49px;
        height: 49px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .stat-total .users-stat-icon {
        background: #e8f5f2;
        color: var(--users-primary);
    }

    .stat-active .users-stat-icon {
        background: #eaf7ed;
        color: var(--users-success);
    }

    .stat-inactive .users-stat-icon {
        background: #fff3e4;
        color: #e28b1b;
    }

    .stat-admin .users-stat-icon {
        background: #e8f3fb;
        color: #2383c4;
    }

    /* =========================================================
       CARTE PRINCIPALE
    ========================================================= */

    .users-card {
        background: #fff;
        border: 1px solid var(--users-border);
        border-radius: 14px;
        box-shadow: var(--users-shadow);
        overflow: hidden;
    }

    .users-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid var(--users-border);
        background: #fff;
    }

    .users-card-title {
        margin: 0;
        color: #26333e;
        font-weight: 700;
        font-size: 16px;
    }

    .users-card-subtitle {
        margin-top: 5px;
        margin-bottom: 0;
        color: #87919a;
        font-size: 12px;
    }

    /* =========================================================
       FILTRES
    ========================================================= */

    .users-filters {
        padding: 16px 20px;
        background: #fbfcfd;
        border-bottom: 1px solid var(--users-border);
    }

    .users-filter-group {
        position: relative;
    }

    .users-filter-group .filter-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #93a0aa;
        font-size: 13px;
        z-index: 2;
    }

    .users-filter-control {
        width: 100%;
        height: 40px;
        padding-left: 37px;
        border: 1px solid #dce2e7;
        border-radius: 8px;
        font-size: 12px;
        color: #34404b;
        background-color: #fff;
        transition: all 0.2s ease;
    }

    select.users-filter-control {
        padding-left: 36px;
        padding-right: 25px;
    }

    .users-filter-control:focus {
        border-color: var(--users-primary);
        box-shadow: 0 0 0 3px rgba(23, 105, 95, 0.1);
        outline: none;
    }

    .btn-reset-filter {
        width: 100%;
        height: 40px;
        border-radius: 8px;
        border: 1px solid #dce2e7;
        background: #fff;
        color: #596671;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-reset-filter:hover {
        color: var(--users-primary);
        border-color: #b9d8d2;
        background: #f1faf8;
    }

    /* =========================================================
       TABLEAU
    ========================================================= */

    .users-table-wrapper {
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        margin: 0;
        min-width: 1050px;
    }

    .users-table thead th {
        background: #f7f9fb;
        color: #5f6b76;
        border-top: 0;
        border-bottom: 1px solid #e2e7eb;
        padding: 13px 12px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .users-table tbody td {
        padding: 13px 12px;
        border-top: 1px solid #edf0f2;
        color: #4b5660;
        font-size: 12px;
        vertical-align: middle;
    }

    .users-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .users-table tbody tr:hover {
        background-color: #fafcfb;
    }

    .user-profile-cell {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .user-avatar-initials {
        width: 41px;
        height: 41px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--users-primary);
        background: var(--users-primary-light);
        border: 2px solid #d9ebe7;
        font-size: 13px;
        font-weight: 700;
    }

    .user-name {
        color: #24323d;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .user-reference {
        color: #8a959f;
        font-size: 10px;
    }

    .user-email {
        color: #40505b;
        font-weight: 500;
    }

    .company-label {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #53606a;
    }

    .company-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: #eef5f4;
        color: var(--users-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    .user-role-badge,
    .user-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 50px;
        padding: 5px 9px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .role-admin {
        background: #e8f3fb;
        color: #1b75b0;
    }

    .role-manager {
        background: #f2ebfc;
        color: #7650b1;
    }

    .role-user {
        background: #eef2f5;
        color: #5e6d78;
    }

    .role-finance {
        background: #fff3df;
        color: #b77916;
    }

    .role-technique {
        background: #e8f5f2;
        color: var(--users-primary);
    }

    .status-active {
        background: #e9f7ec;
        color: #218c3b;
    }

    .status-inactive {
        background: #f8ecee;
        color: #bf3646;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .created-date {
        color: #53606a;
        font-size: 11px;
    }

    .created-date small {
        display: block;
        color: #929ca5;
        font-size: 9px;
        margin-top: 2px;
    }

    /* =========================================================
       BOUTONS D’ACTIONS
    ========================================================= */

    .users-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 5px;
    }

    .user-action-btn {
        width: 31px;
        height: 31px;
        padding: 0;
        border-radius: 7px;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        font-size: 11px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .action-view {
        color: #18869a;
        background: #edf8fa;
        border-color: #d4eef2;
    }

    .action-view:hover {
        color: #fff;
        background: #18869a;
    }

    .action-edit {
        color: #b17a1a;
        background: #fff7e8;
        border-color: #fae8c5;
    }

    .action-edit:hover {
        color: #fff;
        background: #d4972a;
    }

    .action-toggle {
        color: #4574a8;
        background: #edf4fb;
        border-color: #d8e7f5;
    }

    .action-toggle:hover {
        color: #fff;
        background: #4574a8;
    }

    .action-delete {
        color: #c5414e;
        background: #fceff0;
        border-color: #f6d7da;
    }

    .action-delete:hover {
        color: #fff;
        background: #c5414e;
    }

    /* =========================================================
       ÉTAT VIDE
    ========================================================= */

    .users-empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .users-empty-icon {
        width: 75px;
        height: 75px;
        margin: auto;
        border-radius: 50%;
        background: #edf7f5;
        color: var(--users-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
    }

    .users-empty-state h5 {
        margin-top: 18px;
        margin-bottom: 6px;
        font-weight: 700;
        color: #37434d;
    }

    .users-empty-state p {
        margin: 0;
        color: #8c969f;
        font-size: 12px;
    }

    /* =========================================================
       PIED DU TABLEAU
    ========================================================= */

    .users-card-footer {
        padding: 14px 20px;
        border-top: 1px solid var(--users-border);
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .users-result-info {
        color: #7f8a94;
        font-size: 11px;
    }

    .users-pagination .page-link {
        border-radius: 7px;
        margin-left: 4px;
        border: 1px solid #dde3e7;
        color: #596671;
        font-size: 11px;
        min-width: 31px;
        text-align: center;
    }

    .users-pagination .page-item.active .page-link {
        border-color: var(--users-primary);
        background: var(--users-primary);
        color: #fff;
    }

    /* =========================================================
       MODALS
    ========================================================= */

    .user-modal .modal-content {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(34, 45, 55, 0.2);
    }

    .user-modal .modal-header {
        padding: 17px 20px;
        border-bottom: 1px solid #e7ebee;
        background: linear-gradient(135deg, #f7fbfa, #fff);
    }

    .user-modal .modal-title {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #283640;
        font-size: 16px;
        font-weight: 700;
    }

    .user-modal-title-icon {
        width: 35px;
        height: 35px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--users-primary-light);
        color: var(--users-primary);
    }

    .user-modal .modal-body {
        padding: 20px;
        background: #fbfcfd;
    }

    .user-modal .modal-footer {
        padding: 14px 20px;
        background: #fff;
        border-top: 1px solid #e7ebee;
    }

    .user-form-section {
        background: #fff;
        border: 1px solid #e5eaed;
        border-radius: 11px;
        padding: 16px;
        margin-bottom: 16px;
    }

    .user-form-section:last-child {
        margin-bottom: 0;
    }

    .user-form-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #edf0f2;
        color: #34424d;
        font-size: 13px;
        font-weight: 700;
    }

    .user-form-section-title i {
        color: var(--users-primary);
    }

    .user-modal label {
        color: #5a6670;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .user-modal .form-control {
        height: 40px;
        border-radius: 8px;
        border: 1px solid #dce2e7;
        font-size: 12px;
        color: #37444e;
    }

    .user-modal .form-control:focus {
        border-color: var(--users-primary);
        box-shadow: 0 0 0 3px rgba(23, 105, 95, 0.1);
    }

    .required-star {
        color: var(--users-danger);
    }

    .password-field {
        position: relative;
    }

    .password-field .form-control {
        padding-right: 43px;
    }

    .toggle-password {
        position: absolute;
        right: 3px;
        top: 3px;
        width: 35px;
        height: 34px;
        border: 0;
        background: transparent;
        color: #8c969f;
        cursor: pointer;
    }

    .btn-modal-save {
        background: var(--users-primary);
        color: #fff;
        border: 0;
        border-radius: 8px;
        padding: 9px 17px;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-modal-save:hover {
        background: var(--users-primary-dark);
        color: #fff;
    }

    .btn-modal-cancel {
        background: #eef1f3;
        color: #5f6b75;
        border: 0;
        border-radius: 8px;
        padding: 9px 17px;
        font-size: 12px;
        font-weight: 700;
    }

    /* =========================================================
       MODAL DÉTAILS
    ========================================================= */

    .user-detail-header {
        text-align: center;
        background: #fff;
        border: 1px solid #e5eaed;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 16px;
    }

    .user-detail-avatar {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        margin: auto;
        background: var(--users-primary-light);
        color: var(--users-primary);
        border: 4px solid #fff;
        box-shadow: 0 5px 20px rgba(35, 70, 65, 0.13);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
        font-weight: 800;
        overflow: hidden;
    }

    .user-detail-name {
        margin-top: 12px;
        margin-bottom: 3px;
        font-size: 18px;
        font-weight: 800;
        color: #283640;
    }

    .user-detail-email {
        color: #84909a;
        font-size: 11px;
    }

    .user-detail-list {
        background: #fff;
        border: 1px solid #e5eaed;
        border-radius: 12px;
        overflow: hidden;
    }

    .user-detail-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 13px 15px;
        border-bottom: 1px solid #edf0f2;
    }

    .user-detail-row:last-child {
        border-bottom: 0;
    }

    .user-detail-label {
        color: #7a858f;
        font-size: 11px;
    }

    .user-detail-value {
        color: #35434e;
        font-size: 11px;
        font-weight: 700;
        text-align: right;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 767px) {
        .users-page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-add-user {
            width: 100%;
        }

        .users-card-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .user-modal .modal-body {
            padding: 12px;
        }
    }
</style>

<!-- =========================================================
     CONTENT WRAPPER
========================================================= -->

<div class="content-wrapper">

    <!-- En-tête principal -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="m-0">
                        <?= isset($title)
                            ? html_escape($title)
                            : 'Utilisateurs' ?>
                    </h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item">

                            <a href="<?= base_url('dashboard') ?>">
                                Accueil
                            </a>

                        </li>



                        <li class="breadcrumb-item active">
                            <?= isset($title)
                                ? html_escape($title)
                                : 'Utilisateurs' ?>
                        </li>

                    </ol>

                </div>

            </div>

        </div>
    </div>

    <!-- Contenu principal -->
    <section class="content">

        <div class="container-fluid">

            <!-- Message de succès -->
            <?php if ($this->session->flashdata('success')) : ?>

                <div class="alert alert-success alert-dismissible fade show">

                    <i class="fas fa-check-circle mr-2"></i>

                    <?= $this->session->flashdata('success') ?>

                    <button type="button" class="close" data-dismiss="alert">

                        <span>&times;</span>

                    </button>

                </div>

            <?php endif; ?>

            <!-- Message d’erreur -->
            <?php if ($this->session->flashdata('error')) : ?>

                <div class="alert alert-danger alert-dismissible fade show">

                    <i class="fas fa-exclamation-circle mr-2"></i>

                    <?= $this->session->flashdata('error') ?>

                    <button type="button" class="close" data-dismiss="alert">

                        <span>&times;</span>

                    </button>

                </div>

            <?php endif; ?>

            <!-- En-tête professionnel -->
            <div class="users-page-header">

                <div class="users-page-title">

                    <div class="users-page-title-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>

                    <div>

                        <h3>
                            Gestion des utilisateurs
                        </h3>

                        <p>
                            Créez les comptes, attribuez les rôles et
                            contrôlez les accès au système.
                        </p>

                    </div>

                </div>

                <button type="button" class="btn btn-add-user" data-toggle="modal" data-target="#createUserModal">

                    <i class="fas fa-user-plus mr-2"></i>

                    Nouvel utilisateur

                </button>

            </div>

            <!-- =====================================================
                 STATISTIQUES
            ====================================================== -->

            <div class="row mb-4">

                <!-- Total -->
                <div class="col-xl-3 col-md-6 mb-3">

                    <div class="users-stat-card stat-total">

                        <div class="users-stat-content">

                            <div>

                                <div class="users-stat-label">
                                    Total utilisateurs
                                </div>

                                <div class="users-stat-number">

                                    <?= isset($stats['total'])
                                        ? (int) $stats['total']
                                        : 0 ?>

                                </div>

                                <div class="users-stat-note">
                                    Comptes enregistrés dans le système
                                </div>

                            </div>

                            <div class="users-stat-icon">
                                <i class="fas fa-users"></i>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Actifs -->
                <div class="col-xl-3 col-md-6 mb-3">

                    <div class="users-stat-card stat-active">

                        <div class="users-stat-content">

                            <div>

                                <div class="users-stat-label">
                                    Comptes actifs
                                </div>

                                <div class="users-stat-number">

                                    <?= isset($stats['actifs'])
                                        ? (int) $stats['actifs']
                                        : 0 ?>

                                </div>

                                <div class="users-stat-note">
                                    Utilisateurs autorisés à se connecter
                                </div>

                            </div>

                            <div class="users-stat-icon">
                                <i class="fas fa-user-check"></i>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Inactifs -->
                <div class="col-xl-3 col-md-6 mb-3">

                    <div class="users-stat-card stat-inactive">

                        <div class="users-stat-content">

                            <div>

                                <div class="users-stat-label">
                                    Comptes inactifs
                                </div>

                                <div class="users-stat-number">

                                    <?= isset($stats['inactifs'])
                                        ? (int) $stats['inactifs']
                                        : 0 ?>

                                </div>

                                <div class="users-stat-note">
                                    Comptes suspendus ou désactivés
                                </div>

                            </div>

                            <div class="users-stat-icon">
                                <i class="fas fa-user-slash"></i>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Administrateurs -->
                <div class="col-xl-3 col-md-6 mb-3">

                    <div class="users-stat-card stat-admin">

                        <div class="users-stat-content">

                            <div>

                                <div class="users-stat-label">
                                    Administrateurs
                                </div>

                                <div class="users-stat-number">

                                    <?= isset($stats['administrateurs'])
                                        ? (int) $stats['administrateurs']
                                        : 0 ?>

                                </div>

                                <div class="users-stat-note">
                                    Comptes avec privilèges élevés
                                </div>

                            </div>

                            <div class="users-stat-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- =====================================================
                 CARTE PRINCIPALE
            ====================================================== -->

            <div class="users-card">

                <div class="users-card-header">

                    <h5 class="users-card-title">

                        <i class="fas fa-address-book text-success mr-2"></i>

                        Liste des utilisateurs

                    </h5>

                    <p class="users-card-subtitle">
                        Consultez et gérez tous les comptes utilisateurs
                        de SATRACO CMS.
                    </p>

                </div>

                <!-- Filtres -->
                <div class="users-filters">

                    <div class="row">

                        <!-- Recherche -->
                        <div class="col-lg-6 col-md-6 mb-2 mb-lg-0">

                            <div class="users-filter-group">

                                <i class="fas fa-search filter-icon"></i>

                                <input type="text" id="searchUser" class="users-filter-control"
                                    placeholder="Rechercher par nom ou adresse e-mail...">

                            </div>

                        </div>

                        <!-- Rôle -->
                        <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">

                            <div class="users-filter-group">

                                <i class="fas fa-user-tag filter-icon"></i>

                                <select id="filterRole" class="users-filter-control">

                                    <option value="">
                                        Tous les rôles
                                    </option>

                                    <?php if (!empty($roles)) : ?>

                                        <?php foreach ($roles as $role) : ?>

                                            <option value="<?= html_escape(
                                                                strtolower($role->name ?? '')
                                                            ) ?>">

                                                <?= html_escape(
                                                    $role->name ?? 'Sans nom'
                                                ) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </select>

                            </div>

                        </div>

                        <!-- Statut -->
                        <div class="col-lg-2 col-md-3 mb-2 mb-lg-0">

                            <div class="users-filter-group">

                                <i class="fas fa-toggle-on filter-icon"></i>

                                <select id="filterStatus" class="users-filter-control">

                                    <option value="">
                                        Tous les statuts
                                    </option>

                                    <option value="active">
                                        Actif
                                    </option>

                                    <option value="inactive">
                                        Inactif
                                    </option>

                                </select>

                            </div>

                        </div>

                        <!-- Réinitialisation -->
                        <div class="col-lg-2 col-md-12">

                            <button type="button" id="resetFilters" class="btn-reset-filter">

                                <i class="fas fa-redo-alt mr-1"></i>

                                Réinitialiser

                            </button>

                        </div>

                    </div>

                </div>

                <!-- =====================================================
                     TABLEAU
                ====================================================== -->

                <div class="users-table-wrapper">

                    <table class="table users-table" id="usersTable">

                        <thead>

                            <tr>

                                <th style="width: 55px;">
                                    #
                                </th>

                                <th>
                                    Utilisateur
                                </th>

                                <th>
                                    Adresse e-mail
                                </th>

                                <!-- <th>
                                    Entreprise
                                </th> -->

                                <th>
                                    Rôle
                                </th>

                                <th>
                                    Statut
                                </th>

                                <th>
                                    Date de création
                                </th>

                                <th class="text-right">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($users)) : ?>

                                <?php $numero = 1; ?>

                                <?php foreach ($users as $user) : ?>

                                    <?php
                                    /*
                                    |--------------------------------------------------------------------------
                                    | Nom complet
                                    |--------------------------------------------------------------------------
                                    */

                                    $firstName = trim(
                                        $user->first_name ?? ''
                                    );

                                    $lastName = trim(
                                        $user->last_name ?? ''
                                    );

                                    $nomComplet = trim(
                                        $firstName . ' ' . $lastName
                                    );

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Initiales
                                    |--------------------------------------------------------------------------
                                    */

                                    $initiales = '';

                                    if ($firstName !== '') {
                                        $initiales .= strtoupper(
                                            mb_substr(
                                                $firstName,
                                                0,
                                                1,
                                                'UTF-8'
                                            )
                                        );
                                    }

                                    if ($lastName !== '') {
                                        $initiales .= strtoupper(
                                            mb_substr(
                                                $lastName,
                                                0,
                                                1,
                                                'UTF-8'
                                            )
                                        );
                                    }

                                    if ($initiales === '') {
                                        $initiales = 'U';
                                    }

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Rôle
                                    |--------------------------------------------------------------------------
                                    */

                                    $nomRole = $user->role_name
                                        ?? 'Sans rôle';

                                    $roleClass = 'role-user';

                                    $roleLower = mb_strtolower(
                                        $nomRole,
                                        'UTF-8'
                                    );

                                    if (
                                        strpos($roleLower, 'admin') !== false ||
                                        strpos($roleLower, 'super') !== false
                                    ) {
                                        $roleClass = 'role-admin';
                                    } elseif (
                                        strpos($roleLower, 'directeur') !== false ||
                                        strpos($roleLower, 'responsable') !== false ||
                                        strpos($roleLower, 'manager') !== false
                                    ) {
                                        $roleClass = 'role-manager';
                                    } elseif (
                                        strpos($roleLower, 'finance') !== false ||
                                        strpos($roleLower, 'comptable') !== false ||
                                        strpos($roleLower, 'daf') !== false ||
                                        strpos($roleLower, 'trésor') !== false
                                    ) {
                                        $roleClass = 'role-finance';
                                    } elseif (
                                        strpos($roleLower, 'technique') !== false ||
                                        strpos($roleLower, 'chantier') !== false ||
                                        strpos($roleLower, 'travaux') !== false ||
                                        strpos($roleLower, 'ingénieur') !== false
                                    ) {
                                        $roleClass = 'role-technique';
                                    }

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Statut
                                    |--------------------------------------------------------------------------
                                    */

                                    $status = strtolower(
                                        trim(
                                            $user->status ?? 'inactive'
                                        )
                                    );

                                    if ($status === 'active') {
                                        $statusClass = 'status-active';
                                        $statusLabel = 'Actif';
                                    } else {
                                        $statusClass = 'status-inactive';
                                        $statusLabel = 'Inactif';
                                    }

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Entreprise
                                    |--------------------------------------------------------------------------
                                    */

                                    if (!empty($user->company_name)) {
                                        $companyLabel = $user->company_name;
                                    } elseif (!empty($user->company_id)) {
                                        $companyLabel =
                                            'Entreprise #' .
                                            (int) $user->company_id;
                                    } else {
                                        $companyLabel = 'Compte global';
                                    }

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Date de création
                                    |--------------------------------------------------------------------------
                                    */

                                    $createdAt = !empty($user->created_at)
                                        ? date(
                                            'd/m/Y à H:i',
                                            strtotime($user->created_at)
                                        )
                                        : '-';
                                    ?>

                                    <tr class="user-row" data-name="<?= html_escape(
                                                                        strtolower($nomComplet)
                                                                    ) ?>" data-email="<?= html_escape(
                                                                                            strtolower($user->email ?? '')
                                                                                        ) ?>" data-role="<?= html_escape(
                                                                                                                strtolower($nomRole)
                                                                                                            ) ?>"
                                        data-status="<?= html_escape(
                                                            $status
                                                        ) ?>">

                                        <!-- Numéro -->
                                        <td>
                                            <?= $numero++ ?>
                                        </td>

                                        <!-- Utilisateur -->
                                        <td>

                                            <div class="user-profile-cell">

                                                <div class="user-avatar-initials">
                                                    <?= html_escape(
                                                        $initiales
                                                    ) ?>
                                                </div>

                                                <div>

                                                    <div class="user-name">

                                                        <?= html_escape(
                                                            $nomComplet !== ''
                                                                ? $nomComplet
                                                                : 'Utilisateur sans nom'
                                                        ) ?>

                                                    </div>

                                                    <div class="user-reference">

                                                        ID utilisateur :
                                                        <?= (int) $user->id ?>

                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                        <!-- E-mail -->
                                        <td>

                                            <div class="user-email">

                                                <i class="far fa-envelope mr-1 text-muted"></i>

                                                <?= html_escape(
                                                    $user->email ?? '-'
                                                ) ?>

                                            </div>

                                        </td>

                                        <!-- Entreprise -->
                                        <!-- <td>

                                            <div class="company-label">

                                                <span class="company-icon">

                                                    <i class="fas fa-building"></i>

                                                </span>

                                                <span>

                                                    <?= html_escape(
                                                        $companyLabel
                                                    ) ?>

                                                </span>

                                            </div>

                                        </td> -->

                                        <!-- Rôle -->
                                        <td>

                                            <span class="user-role-badge <?= $roleClass ?>">

                                                <i class="fas fa-user-tag"></i>

                                                <?= html_escape(
                                                    $nomRole
                                                ) ?>

                                            </span>

                                        </td>

                                        <!-- Statut -->
                                        <td>

                                            <span class="user-status-badge <?= $statusClass ?>">

                                                <span class="status-dot"></span>

                                                <?= $statusLabel ?>

                                            </span>

                                        </td>

                                        <!-- Date de création -->
                                        <td>

                                            <div class="created-date">

                                                <?= html_escape(
                                                    $createdAt
                                                ) ?>

                                                <small>
                                                    Création du compte
                                                </small>

                                            </div>

                                        </td>

                                        <!-- Actions -->
                                        <td>

                                            <div class="users-actions">

                                                <!-- Consulter -->
                                                <button type="button" class="user-action-btn action-view btn-view-user"
                                                    title="Consulter" onclick="openViewUserModal(this)"
                                                    data-id="<?= (int) $user->id ?>" data-name="<?= html_escape($nomComplet) ?>"
                                                    data-email="<?= html_escape($user->email ?? '') ?>"
                                                    data-company="<?= html_escape($companyLabel) ?>"
                                                    data-role="<?= html_escape($nomRole) ?>"
                                                    data-status="<?= html_escape($status) ?>"
                                                    data-status-label="<?= html_escape($statusLabel) ?>"
                                                    data-created="<?= html_escape($createdAt) ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <!-- Modifier -->
                                                <button type="button" class="user-action-btn action-edit btn-edit-user"
                                                    title="Modifier" onclick="openEditUserModal(this)"
                                                    data-id="<?= (int) $user->id ?>"
                                                    data-first-name="<?= html_escape($firstName) ?>"
                                                    data-last-name="<?= html_escape($lastName) ?>"
                                                    data-email="<?= html_escape($user->email ?? '') ?>"
                                                    data-company-id="<?= html_escape($user->company_id ?? '') ?>"
                                                    data-role-id="<?= html_escape($user->role_id ?? '') ?>"
                                                    data-status="<?= html_escape($status) ?>">
                                                    <i class="fas fa-pen"></i>
                                                </button>

                                                <!-- Activer ou désactiver -->
                                                <button type="button" class="user-action-btn action-toggle btn-toggle-user"
                                                    title="<?= $status === 'active'
                                                                ? 'Désactiver'
                                                                : 'Activer' ?>" onclick="toggleUserStatus(this)"
                                                    data-id="<?= (int) $user->id ?>" data-status="<?= html_escape($status) ?>"
                                                    data-name="<?= html_escape($nomComplet) ?>">
                                                    <i class="fas <?= $status === 'active'
                                                                        ? 'fa-user-lock'
                                                                        : 'fa-user-check' ?>"></i>
                                                </button>

                                                <!-- Supprimer -->
                                                <button type="button" class="user-action-btn action-delete btn-delete-user"
                                                    title="Supprimer" onclick="deleteUser(this)"
                                                    data-id="<?= (int) $user->id ?>"
                                                    data-name="<?= html_escape($nomComplet) ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else : ?>

                                <tr>

                                    <td colspan="8">

                                        <div class="users-empty-state">

                                            <div class="users-empty-icon">
                                                <i class="fas fa-users"></i>
                                            </div>

                                            <h5>
                                                Aucun utilisateur enregistré
                                            </h5>

                                            <p>
                                                Cliquez sur « Nouvel utilisateur »
                                                pour créer le premier compte.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            <?php endif; ?>

                            <!-- Résultat vide après filtrage -->
                            <tr id="noSearchResult" style="display: none;">

                                <td colspan="8">

                                    <div class="users-empty-state">

                                        <div class="users-empty-icon">
                                            <i class="fas fa-search"></i>
                                        </div>

                                        <h5>
                                            Aucun résultat trouvé
                                        </h5>

                                        <p>
                                            Modifiez les critères de recherche
                                            ou réinitialisez les filtres.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <!-- Pied du tableau -->
                <div class="users-card-footer">

                    <div class="users-result-info">

                        <span id="visibleUsersCount">

                            <?= !empty($users)
                                ? count($users)
                                : 0 ?>

                        </span>

                        utilisateur(s) affiché(s)

                    </div>

                    <nav class="users-pagination">

                        <ul class="pagination pagination-sm mb-0">

                            <li class="page-item disabled">

                                <a class="page-link" href="javascript:void(0);">

                                    <i class="fas fa-angle-left"></i>

                                </a>

                            </li>

                            <li class="page-item active">

                                <a class="page-link" href="javascript:void(0);">

                                    1

                                </a>

                            </li>

                            <li class="page-item disabled">

                                <a class="page-link" href="javascript:void(0);">

                                    <i class="fas fa-angle-right"></i>

                                </a>

                            </li>

                        </ul>

                    </nav>

                </div>

            </div>

        </div>

    </section>

</div>

<!-- =========================================================
     MODAL : CRÉER UN UTILISATEUR
========================================================= -->

<div class="modal fade user-modal" id="createUserModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

        <form action="<?= base_url('utilisateurs-store') ?>" method="post" id="createUserForm" style="width: 100%;">

            <div class="modal-content">

                <!-- CSRF -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                    value="<?= $this->security->get_csrf_hash() ?>">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <span class="user-modal-title-icon">
                            <i class="fas fa-user-plus"></i>
                        </span>

                        Créer un utilisateur

                    </h5>

                    <button type="button" class="close" data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <!-- Informations personnelles -->
                    <div class="user-form-section">

                        <div class="user-form-section-title">

                            <i class="fas fa-id-card"></i>

                            Informations personnelles

                        </div>

                        <div class="row">

                            <!-- Prénom -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>

                                        Prénom

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <input type="text" name="first_name" class="form-control" placeholder="Ex. Jean"
                                        autocomplete="given-name" required>

                                </div>

                            </div>

                            <!-- Nom -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>

                                        Nom

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <input type="text" name="last_name" class="form-control" placeholder="Ex. MINANI"
                                        autocomplete="family-name" required>

                                </div>

                            </div>

                            <!-- E-mail -->
                            <div class="col-md-12">

                                <div class="form-group mb-0">

                                    <label>

                                        Adresse e-mail

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <input type="email" name="email" class="form-control"
                                        placeholder="utilisateur@satracoconstruction.com" autocomplete="email" required>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Connexion -->
                    <div class="user-form-section">

                        <div class="user-form-section-title">

                            <i class="fas fa-key"></i>

                            Informations de connexion

                        </div>

                        <div class="row">

                            <!-- Mot de passe -->
                            <div class="col-md-6">

                                <div class="form-group mb-0">

                                    <label>

                                        Mot de passe

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <div class="password-field">

                                        <input type="password" name="password" id="createPassword" class="form-control"
                                            placeholder="Minimum 8 caractères" autocomplete="new-password" minlength="8"
                                            required>

                                        <button type="button" class="toggle-password" data-target="#createPassword">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                            <!-- Confirmation -->
                            <div class="col-md-6">

                                <div class="form-group mb-0">

                                    <label>

                                        Confirmer le mot de passe

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <div class="password-field">

                                        <input type="password" name="password_confirmation"
                                            id="createPasswordConfirmation" class="form-control"
                                            placeholder="Répétez le mot de passe" autocomplete="new-password"
                                            minlength="8" required>

                                        <button type="button" class="toggle-password"
                                            data-target="#createPasswordConfirmation">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Affectation -->
                    <div class="user-form-section">

                        <div class="user-form-section-title">

                            <i class="fas fa-user-shield"></i>

                            Affectation et autorisations

                        </div>

                        <div class="row">

                            <!-- Entreprise -->
                            <div class="col-md-4">

                                <div class="form-group mb-0">

                                    <label>
                                        Entreprise
                                    </label>

                                    <select name="company_id" class="form-control">

                                        <option value="">
                                            Compte global
                                        </option>

                                        <?php if (!empty($companies)) : ?>

                                            <?php foreach ($companies as $company) : ?>

                                                <option value="<?= (int) $company->id ?>">

                                                    <?= html_escape(
                                                        $company->name ?? 'Entreprise'
                                                    ) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        <?php else : ?>

                                            <option value="1">
                                                Entreprise #1
                                            </option>

                                            <option value="2">
                                                SATRACO Construction
                                            </option>

                                        <?php endif; ?>

                                    </select>

                                </div>

                            </div>

                            <!-- Rôle -->
                            <div class="col-md-4">

                                <div class="form-group mb-0">

                                    <label>

                                        Rôle

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <select name="role_id" class="form-control" required>

                                        <option value="">
                                            Sélectionner un rôle
                                        </option>

                                        <?php if (!empty($roles)) : ?>

                                            <?php foreach ($roles as $role) : ?>

                                                <option value="<?= (int) $role->id ?>">

                                                    <?= html_escape(
                                                        $role->name ?? 'Sans nom'
                                                    ) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        <?php endif; ?>

                                    </select>

                                </div>

                            </div>

                            <!-- Statut -->
                            <div class="col-md-4">

                                <div class="form-group mb-0">

                                    <label>

                                        Statut

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <select name="status" class="form-control" required>

                                        <option value="active">
                                            Actif
                                        </option>

                                        <option value="inactive">
                                            Inactif
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">

                        <i class="fas fa-times mr-1"></i>

                        Annuler

                    </button>

                    <button type="submit" class="btn btn-modal-save">

                        <i class="fas fa-save mr-1"></i>

                        Enregistrer l’utilisateur

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<script>
    /* =====================================================
    CONSULTER UN UTILISATEUR
    ===================================================== */
    function openViewUserModal(btn) {
        var $btn = $(btn);

        var id = $btn.data('id') || '-';
        var name = String($btn.data('name') || '-');
        var email = String($btn.data('email') || '-');
        var company = String($btn.data('company') || '-');
        var role = String($btn.data('role') || '-');
        var status = String($btn.data('status') || 'inactive').toLowerCase();
        var statusLabel = $btn.data('status-label') || (status === 'active' ? 'Actif' : 'Inactif');
        var created = String($btn.data('created') || '-');

        $('#viewUserName').text(name);
        $('#viewUserEmail').text(email);
        $('#viewUserId').text(id !== '-' ? '#' + id : '-');
        $('#viewUserCompany').text(company);
        $('#viewUserCreated').text(created);

        // Initiales de l'avatar ("Axel NDERAGAKURA" -> "AN")
        var initials = name.split(' ').filter(Boolean).map(function(w) {
            return w.charAt(0).toUpperCase();
        }).slice(0, 2).join('');
        $('#viewUserAvatar').text(initials || 'U');

        // Badge rôle
        $('#viewUserRole')
            .removeClass('role-admin role-manager role-user role-finance role-technique')
            .addClass(getRoleClass(role))
            .html('<i class="fas fa-user-tag"></i> ' + escapeHtml(role));

        // Badge statut
        $('#viewUserStatus')
            .removeClass('status-active status-inactive')
            .addClass(status === 'active' ? 'status-active' : 'status-inactive')
            .html('<span class="status-dot"></span> ' + escapeHtml(statusLabel));

        // Ouverture du popup (Bootstrap / AdminLTE)
        $('#viewUserModal').modal('show');
    }

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function getRoleClass(role) {
        var norm = String(role || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '');

        if (/admin/.test(norm)) return 'role-admin';
        if (/(finance|comptab|daf|tresor)/.test(norm)) return 'role-finance';
        if (/(technique|soumission|dessin|architect|chantier|travaux)/.test(norm)) return 'role-technique';
        if (/(direct|responsable|manager|chef|achat|rh|humaines)/.test(norm)) return 'role-manager';
        return 'role-user';
    }
</script>

<!-- =========================================================
     MODAL : CONSULTER UN UTILISATEUR
========================================================= -->

<div class="modal fade user-modal" id="viewUserModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-md modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <span class="user-modal-title-icon">
                        <i class="fas fa-user"></i>
                    </span>

                    Détails de l’utilisateur

                </h5>

                <button type="button" class="close" data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="user-detail-header">

                    <div class="user-detail-avatar" id="viewUserAvatar">

                        U

                    </div>

                    <div class="user-detail-name" id="viewUserName">

                        -

                    </div>

                    <div class="user-detail-email" id="viewUserEmail">

                        -

                    </div>

                    <div class="mt-3">

                        <span class="user-role-badge role-user" id="viewUserRole">

                            -

                        </span>

                        <span class="user-status-badge status-active ml-1" id="viewUserStatus">

                            -

                        </span>

                    </div>

                </div>

                <div class="user-detail-list">

                    <div class="user-detail-row">

                        <div class="user-detail-label">
                            Identifiant
                        </div>

                        <div class="user-detail-value" id="viewUserId">

                            -

                        </div>

                    </div>

                    <div class="user-detail-row">

                        <div class="user-detail-label">
                            Entreprise
                        </div>

                        <div class="user-detail-value" id="viewUserCompany">

                            -

                        </div>

                    </div>

                    <div class="user-detail-row">

                        <div class="user-detail-label">
                            Date de création
                        </div>

                        <div class="user-detail-value" id="viewUserCreated">

                            -

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">

                    Fermer

                </button>

            </div>

        </div>

    </div>

</div>

<script>
    /* =====================================================
    MODIFIER UN UTILISATEUR
    ===================================================== */
    function openEditUserModal(btn) {
        var $btn = $(btn);

        var id = $btn.data('id') || '';
        var firstName = String($btn.data('first-name') || '');
        var lastName = String($btn.data('last-name') || '');
        var email = String($btn.data('email') || '');
        var companyId = String($btn.data('company-id') || '');
        var roleId = String($btn.data('role-id') || '');
        var status = String($btn.data('status') || 'active');

        // Champs cachés + texte
        $('#editUserId').val(id);
        $('#editFirstName').val(firstName);
        $('#editLastName').val(lastName);
        $('#editEmail').val(email);

        // Selects : .val() sélectionne l'option dont le value correspond
        $('#editCompany').val(companyId);
        $('#editRole').val(roleId);
        $('#editStatus').val(status);

        // Filet de sécurité : si la valeur n'existe pas dans le select,
        // .val() retourne null -> on retombe sur une valeur par défaut
        if ($('#editCompany').val() === null) $('#editCompany').val('');
        if ($('#editRole').val() === null) $('#editRole').val('');
        if ($('#editStatus').val() === null) $('#editStatus').val('active');

        // Mots de passe TOUJOURS vides à l'ouverture
        $('#editPassword').val('');
        $('#editPasswordConfirmation').val('');

        // Ouverture du popup
        $('#editUserModal').modal('show');
    }

    // Optionnel : reset complet quand on ferme le modal
    $(document).on('hidden.bs.modal', '#editUserModal', function() {
        $('#editPassword').val('');
        $('#editPasswordConfirmation').val('');
    });
</script>


<!-- =========================================================
     MODAL : MODIFIER UN UTILISATEUR
========================================================= -->

<div class="modal fade user-modal" id="editUserModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

        <form action="<?= base_url(
                            'utilisateurs-update'
                        ) ?>" method="post" id="editUserForm" style="width: 100%;">

            <div class="modal-content">

                <!-- CSRF -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                    value="<?= $this->security->get_csrf_hash() ?>">

                <!-- ID utilisateur -->
                <input type="hidden" name="id" id="editUserId">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <span class="user-modal-title-icon">
                            <i class="fas fa-user-edit"></i>
                        </span>

                        Modifier l’utilisateur

                    </h5>

                    <button type="button" class="close" data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <!-- Informations personnelles -->
                    <div class="user-form-section">

                        <div class="user-form-section-title">

                            <i class="fas fa-id-card"></i>

                            Informations personnelles

                        </div>

                        <div class="row">

                            <!-- Prénom -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>

                                        Prénom

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <input type="text" name="first_name" id="editFirstName" class="form-control"
                                        required>

                                </div>

                            </div>

                            <!-- Nom -->
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>

                                        Nom

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <input type="text" name="last_name" id="editLastName" class="form-control" required>

                                </div>

                            </div>

                            <!-- E-mail -->
                            <div class="col-md-12">

                                <div class="form-group mb-0">

                                    <label>

                                        Adresse e-mail

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <input type="email" name="email" id="editEmail" class="form-control" required>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Compte et affectation -->
                    <div class="user-form-section">

                        <div class="user-form-section-title">

                            <i class="fas fa-user-cog"></i>

                            Compte et affectation

                        </div>

                        <div class="row">

                            <!-- Entreprise -->
                            <div class="col-md-4">

                                <div class="form-group mb-0">

                                    <label>
                                        Entreprise
                                    </label>

                                    <select name="company_id" id="editCompany" class="form-control">

                                        <option value="">
                                            Compte global
                                        </option>

                                        <?php if (!empty($companies)) : ?>

                                            <?php foreach ($companies as $company) : ?>

                                                <option value="<?= (int) $company->id ?>">

                                                    <?= html_escape(
                                                        $company->name ?? 'Entreprise'
                                                    ) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        <?php else : ?>

                                            <option value="1">
                                                Entreprise #1
                                            </option>

                                            <option value="2">
                                                SATRACO Construction
                                            </option>

                                        <?php endif; ?>

                                    </select>

                                </div>

                            </div>

                            <!-- Rôle -->
                            <div class="col-md-4">

                                <div class="form-group mb-0">

                                    <label>

                                        Rôle

                                        <span class="required-star">
                                            *
                                        </span>

                                    </label>

                                    <select name="role_id" id="editRole" class="form-control" required>

                                        <option value="">
                                            Sélectionner un rôle
                                        </option>

                                        <?php if (!empty($roles)) : ?>

                                            <?php foreach ($roles as $role) : ?>

                                                <option value="<?= (int) $role->id ?>">

                                                    <?= html_escape(
                                                        $role->name ?? 'Sans nom'
                                                    ) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        <?php endif; ?>

                                    </select>

                                </div>

                            </div>

                            <!-- Statut -->
                            <div class="col-md-4">

                                <div class="form-group mb-0">

                                    <label>
                                        Statut
                                    </label>

                                    <select name="status" id="editStatus" class="form-control">

                                        <option value="active">
                                            Actif
                                        </option>

                                        <option value="inactive">
                                            Inactif
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Mot de passe -->
                    <div class="user-form-section">

                        <div class="user-form-section-title">

                            <i class="fas fa-lock"></i>

                            Réinitialisation du mot de passe

                        </div>

                        <div class="row">

                            <!-- Nouveau mot de passe -->
                            <div class="col-md-6">

                                <div class="form-group mb-0">

                                    <label>
                                        Nouveau mot de passe
                                    </label>

                                    <div class="password-field">

                                        <input type="password" name="password" id="editPassword" class="form-control"
                                            placeholder="Laisser vide pour conserver l’ancien" minlength="8">

                                        <button type="button" class="toggle-password" data-target="#editPassword">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                            <!-- Confirmation -->
                            <div class="col-md-6">

                                <div class="form-group mb-0">

                                    <label>
                                        Confirmer le nouveau mot de passe
                                    </label>

                                    <div class="password-field">

                                        <input type="password" name="password_confirmation"
                                            id="editPasswordConfirmation" class="form-control"
                                            placeholder="Répétez le nouveau mot de passe" minlength="8">

                                        <button type="button" class="toggle-password"
                                            data-target="#editPasswordConfirmation">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">

                        <i class="fas fa-times mr-1"></i>

                        Annuler

                    </button>

                    <button type="submit" class="btn btn-modal-save">

                        <i class="fas fa-save mr-1"></i>

                        Enregistrer les modifications

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* =====================================================
    ACTIVER / DÉSACTIVER UN COMPTE
    ===================================================== */
    function toggleUserStatus(btn) {
        var $btn = $(btn);
        var id = $btn.data('id');
        var name = String($btn.data('name') || '');
        var status = String($btn.data('status') || 'inactive');
        var isActive = (status === 'active');

        Swal.fire({
            title: isActive ? 'Désactiver ce compte ?' : 'Activer ce compte ?',
            html: 'Vous êtes sur le point de <strong>' + (isActive ? 'désactiver' : 'activer') +
                '</strong> le compte de ' +
                '<strong>' + escapeHtml(name) + '</strong>.<br>' +
                (isActive ?
                    'L’utilisateur ne pourra plus se connecter.' :
                    'L’utilisateur pourra à nouveau se connecter.'),
            icon: isActive ? 'warning' : 'question',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: isActive ? '#dc3545' : '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isActive ? 'Oui, désactiver' : 'Oui, activer',
            cancelButtonText: 'Annuler'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            // Payload + CSRF
            var $csrf = $('#globalCsrf');
            var payload = {
                id: id
            };
            if ($csrf.length) payload[$csrf.attr('name')] = $csrf.val();

            $.ajax({
                url: '<?= base_url('administration/utilisateurs/toggleStatus') ?>',
                type: 'POST',
                dataType: 'json',
                data: payload,
                success: function(res) {
                    // Rafraîchit le hash CSRF si régénéré
                    if ($csrf.length && res.csrf_hash) $csrf.val(res.csrf_hash);

                    Swal.fire({
                        icon: res.success ? 'success' : 'error',
                        title: res.success ? 'Succès' : 'Erreur',
                        text: res.message || 'Statut modifié.',
                        timer: 1800,
                        showConfirmButton: false
                    }).then(function() {
                        if (res.success) location.reload();
                    });
                },
                error: function(xhr) {
                    console.error('Réponse serveur :', xhr.responseText);
                    Swal.fire('Erreur', 'Impossible de modifier le statut.', 'error');
                }
            });
        });
    }
</script>

<script>
    /* =====================================================
   SUPPRIMER UN UTILISATEUR
===================================================== */
    function deleteUser(btn) {
        var $btn = $(btn);
        var id = $btn.data('id');
        var name = String($btn.data('name') || '');

        Swal.fire({
            title: 'Supprimer ce compte ?',
            html: 'Vous êtes sur le point de supprimer définitivement le compte de ' +
                '<strong>' + escapeHtml(name) + '</strong>.<br>' +
                '<span style="color:#dc3545;">Cette action est irréversible.</span>',
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            focusCancel: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            // Payload + CSRF
            var $csrf = $('#globalCsrf');
            var payload = {
                id: id
            };
            if ($csrf.length) payload[$csrf.attr('name')] = $csrf.val();

            $.ajax({
                url: '<?= base_url('administration/utilisateurs/delete') ?>',
                type: 'POST',
                dataType: 'json',
                data: payload,
                success: function(res) {
                    if ($csrf.length && res.csrf_hash) $csrf.val(res.csrf_hash);

                    Swal.fire({
                        icon: res.success ? 'success' : 'error',
                        title: res.success ? 'Succès' : 'Erreur',
                        text: res.message || 'Compte supprimé.',
                        timer: 1800,
                        showConfirmButton: false
                    }).then(function() {
                        if (res.success) location.reload();
                    });
                },
                error: function(xhr) {
                    console.error('Réponse serveur :', xhr.responseText);
                    Swal.fire('Erreur', 'Impossible de supprimer le compte.', 'error');
                }
            });
        });
    }
</script>

<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>
    $(document).ready(function() {

        /* =====================================================
           RECHERCHE ET FILTRAGE
        ===================================================== */

        function filterUsers() {

            const search = String(
                $('#searchUser').val() || ''
            ).toLowerCase().trim();

            const role = String(
                $('#filterRole').val() || ''
            ).toLowerCase().trim();

            const status = String(
                $('#filterStatus').val() || ''
            ).toLowerCase().trim();

            let visibleCount = 0;

            $('.user-row').each(function() {

                const row = $(this);

                const userName = String(
                    row.attr('data-name') || ''
                ).toLowerCase();

                const email = String(
                    row.attr('data-email') || ''
                ).toLowerCase();

                const userRole = String(
                    row.attr('data-role') || ''
                ).toLowerCase();

                const userStatus = String(
                    row.attr('data-status') || ''
                ).toLowerCase();

                const matchSearch =
                    search === '' ||
                    userName.includes(search) ||
                    email.includes(search);

                const matchRole =
                    role === '' ||
                    userRole.includes(role);

                const matchStatus =
                    status === '' ||
                    userStatus === status;

                if (
                    matchSearch &&
                    matchRole &&
                    matchStatus
                ) {

                    row.show();
                    visibleCount++;

                } else {

                    row.hide();

                }

            });

            $('#visibleUsersCount').text(
                visibleCount
            );

            if (
                visibleCount === 0 &&
                $('.user-row').length > 0
            ) {

                $('#noSearchResult').show();

            } else {

                $('#noSearchResult').hide();

            }

        }

        $('#searchUser').on(
            'keyup input',
            filterUsers
        );

        $('#filterRole').on(
            'change',
            filterUsers
        );

        $('#filterStatus').on(
            'change',
            filterUsers
        );

        $('#resetFilters').on(
            'click',
            function() {

                $('#searchUser').val('');
                $('#filterRole').val('');
                $('#filterStatus').val('');

                filterUsers();

            }
        );

        /* =====================================================
           AFFICHER OU MASQUER LE MOT DE PASSE
        ===================================================== */

        $(document).on(
            'click',
            '.toggle-password',
            function() {

                const inputSelector = $(this).data('target');
                const input = $(inputSelector);
                const icon = $(this).find('i');

                if (input.attr('type') === 'password') {

                    input.attr('type', 'text');

                    icon
                        .removeClass('fa-eye')
                        .addClass('fa-eye-slash');

                } else {

                    input.attr('type', 'password');

                    icon
                        .removeClass('fa-eye-slash')
                        .addClass('fa-eye');

                }

            }
        );

        /* =====================================================
           VALIDATION DU FORMULAIRE DE CRÉATION
        ===================================================== */

        $('#createUserForm').on(
            'submit',
            function(event) {

                const password =
                    $('#createPassword').val();

                const confirmation =
                    $('#createPasswordConfirmation').val();

                if (password !== confirmation) {

                    event.preventDefault();

                    Swal.fire({
                        icon: 'error',
                        title: 'Mots de passe différents',
                        text: 'La confirmation ne correspond pas au mot de passe.'
                    });

                    return false;

                }

                return true;

            }
        );

        /* =====================================================
           VALIDATION DU FORMULAIRE DE MODIFICATION
        ===================================================== */

        $('#editUserForm').on(
            'submit',
            function(event) {

                const password =
                    $('#editPassword').val();

                const confirmation =
                    $('#editPasswordConfirmation').val();

                if (
                    password !== '' &&
                    password !== confirmation
                ) {

                    event.preventDefault();

                    Swal.fire({
                        icon: 'error',
                        title: 'Mots de passe différents',
                        text: 'La confirmation du nouveau mot de passe est incorrecte.'
                    });

                    return false;

                }

                return true;

            }
        );

        /* =====================================================
           FONCTION DE SÉCURISATION DU TEXTE
        ===================================================== */

        function escapeHtml(value) {

            return $('<div>')
                .text(value || '')
                .html();

        }

        /* =====================================================
           CLASSE DU RÔLE
        ===================================================== */

        function getRoleClass(role) {

            role = String(
                role || ''
            ).toLowerCase();

            if (
                role.includes('admin') ||
                role.includes('super')
            ) {
                return 'role-admin';
            }

            if (
                role.includes('directeur') ||
                role.includes('responsable') ||
                role.includes('manager')
            ) {
                return 'role-manager';
            }

            if (
                role.includes('finance') ||
                role.includes('comptable') ||
                role.includes('daf') ||
                role.includes('trésor')
            ) {
                return 'role-finance';
            }

            if (
                role.includes('technique') ||
                role.includes('chantier') ||
                role.includes('travaux') ||
                role.includes('ingénieur')
            ) {
                return 'role-technique';
            }

            return 'role-user';

        }

        // /* =====================================================
        // CONSULTER UN UTILISATEUR
        // ===================================================== */

        // /* -----------------------------------------------------
        //    Fonctions utilitaires
        // ----------------------------------------------------- */

        // /**
        //  * Échappe les caractères HTML (protection XSS).
        //  * Indispensable ici car on injecte du contenu avec .html()
        //  * (les data-* sont décodés par jQuery, il faut donc ré-échapper).
        //  */
        // function escapeHtml(value) {
        //     return String(value || '')
        //         .replace(/&/g, '&amp;')
        //         .replace(/</g, '&lt;')
        //         .replace(/>/g, '&gt;')
        //         .replace(/"/g, '&quot;')
        //         .replace(/'/g, '&#039;');
        // }

        // /**
        //  * Retourne la classe du badge selon le libellé du rôle.
        //  * Doit impérativement retourner une des classes listées
        //  * dans le removeClass() : role-admin / role-manager /
        //  * role-user / role-finance / role-technique.
        //  * Ajuste les mots-clés selon tes rôles réels.
        //  */
        // function getRoleClass(role) {
        //     const norm = String(role || '')
        //         .toLowerCase()
        //         .normalize('NFD') // décompose les accents
        //         .replace(/[\u0300-\u036f]/g, ''); // les supprime

        //     if (/admin/.test(norm)) {
        //         return 'role-admin';
        //     }
        //     if (/(finance|comptab|daf|tresor|caisse)/.test(norm)) {
        //         return 'role-finance';
        //     }
        //     if (/(technique|soumission|dessin|architect|bim|chantier|travaux|etude)/.test(norm)) {
        //         return 'role-technique';
        //     }
        //     if (/(direct|responsable|manager|chef|superviseur|achat|approvisionn|rh|humaines)/.test(norm)) {
        //         return 'role-manager';
        //     }
        //     return 'role-user';
        // }

        /* -----------------------------------------------------
           Ouverture du modal de consultation
        ----------------------------------------------------- */
        // $(document).on('click', '.btn-view-user', function() {

        //     const button = $(this);

        //     const id = button.data('id') || '-';
        //     const name = button.data('name') || '-';
        //     const email = button.data('email') || '-';
        //     const company = button.data('company') || '-';
        //     const role = button.data('role') || '-';

        //     const status = String(
        //         button.data('status') || 'inactive'
        //     ).toLowerCase();

        //     const statusLabel =
        //         button.data('status-label') ||
        //         (status === 'active' ? 'Actif' : 'Inactif');

        //     const created = button.data('created') || '-';

        //     /* --- Champs texte simples (.text() = déjà sûr) --- */
        //     $('#viewUserName').text(name);
        //     $('#viewUserEmail').text(email);
        //     $('#viewUserId').text(id !== '-' ? '#' + id : '-');
        //     $('#viewUserCompany').text(company);
        //     $('#viewUserCreated').text(created);

        //     /* --- Initiales de l'avatar ("Axel NDERAGAKURA" -> "AN") --- */
        //     const initials = String(name)
        //         .split(' ')
        //         .filter(Boolean)
        //         .map(function(word) {
        //             return word.charAt(0).toUpperCase();
        //         })
        //         .slice(0, 2)
        //         .join('');

        //     $('#viewUserAvatar').text(initials || 'U');

        //     /* --- Badge rôle (injection HTML => escapeHtml obligatoire) --- */
        //     $('#viewUserRole')
        //         .removeClass(
        //             'role-admin ' +
        //             'role-manager ' +
        //             'role-user ' +
        //             'role-finance ' +
        //             'role-technique'
        //         )
        //         .addClass(getRoleClass(role))
        //         .html(
        //             '<i class="fas fa-user-tag"></i> ' +
        //             escapeHtml(role)
        //         );

        //     /* --- Badge statut --- */
        //     $('#viewUserStatus')
        //         .removeClass('status-active status-inactive')
        //         .addClass(
        //             status === 'active' ? 'status-active' : 'status-inactive'
        //         )
        //         .html(
        //             '<span class="status-dot"></span> ' +
        //             escapeHtml(statusLabel)
        //         );

        //     /* --- Ouverture du modal (Bootstrap 4 / AdminLTE) --- */
        //     $('#viewUserModal').modal('show');
        // });

        // /* =====================================================
        //    MODIFIER UN UTILISATEUR
        // ===================================================== */

        // $(document).on(
        //     'click',
        //     '.btn-edit-user',
        //     function() {

        //         const button = $(this);

        //         $('#editUserId').val(
        //             button.data('id')
        //         );

        //         $('#editFirstName').val(
        //             button.data('first-name')
        //         );

        //         $('#editLastName').val(
        //             button.data('last-name')
        //         );

        //         $('#editEmail').val(
        //             button.data('email')
        //         );

        //         $('#editCompany').val(
        //             button.data('company-id')
        //         );

        //         $('#editRole').val(
        //             button.data('role-id')
        //         );

        //         $('#editStatus').val(
        //             button.data('status')
        //         );

        //         $('#editPassword').val('');

        //         $('#editPasswordConfirmation').val('');

        //         $('#editUserModal').modal(
        //             'show'
        //         );

        //     }
        // );

        /* =====================================================
           ACTIVER OU DÉSACTIVER
        ===================================================== */

        $(document).on(
            'click',
            '.btn-toggle-user',
            function() {

                const id =
                    $(this).data('id');

                const status = String(
                    $(this).data('status') || ''
                ).toLowerCase();

                const name =
                    $(this).data('name') ||
                    'cet utilisateur';

                const isActive =
                    status === 'active';

                Swal.fire({

                    title: isActive ?
                        'Désactiver cet utilisateur ?' : 'Activer cet utilisateur ?',

                    html: 'Voulez-vous vraiment ' +
                        (
                            isActive ?
                            'désactiver' :
                            'activer'
                        ) +
                        ' le compte de <strong>' +
                        escapeHtml(name) +
                        '</strong> ?',

                    icon: 'question',

                    showCancelButton: true,

                    confirmButtonText: isActive ?
                        'Oui, désactiver' : 'Oui, activer',

                    cancelButtonText: 'Annuler',

                    reverseButtons: true,

                    confirmButtonColor: isActive ?
                        '#dc3545' : '#17695f',

                    cancelButtonColor: '#6c757d'

                }).then(function(result) {

                    if (result.isConfirmed) {

                        window.location.href =
                            "<?= base_url(
                                    'administration/utilisateurs/toggle/'
                                ) ?>" + id;

                    }

                });

            }
        );

        /* =====================================================
           SUPPRIMER UN UTILISATEUR
        ===================================================== */

        $(document).on(
            'click',
            '.btn-delete-user',
            function() {

                const id =
                    $(this).data('id');

                const name =
                    $(this).data('name') ||
                    'cet utilisateur';

                Swal.fire({

                    title: 'Supprimer cet utilisateur ?',

                    html: 'Le compte de <strong>' +
                        escapeHtml(name) +
                        '</strong> sera supprimé définitivement.',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonText: 'Oui, supprimer',

                    cancelButtonText: 'Annuler',

                    reverseButtons: true,

                    confirmButtonColor: '#dc3545',

                    cancelButtonColor: '#6c757d'

                }).then(function(result) {

                    if (result.isConfirmed) {

                        window.location.href =
                            "<?= base_url(
                                    'administration/utilisateurs/delete/'
                                ) ?>" + id;

                    }

                });

            }
        );

    });
</script>