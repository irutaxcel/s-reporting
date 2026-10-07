<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SATRACO-CONSTRUCTION ERP | <?= $title ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/v1/plugins/') ?>fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?= base_url('assets/v1/plugins/') ?>tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/v1/plugins/') ?>icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= base_url('assets/v1/plugins/') ?>jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/v1/dist/') ?>css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/v1/plugins/') ?>overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/v1/plugins/') ?>daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url('assets/v1/plugins/') ?>summernote/summernote-bs4.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    :root {
        --satraco-green: #74c476;
        --satraco-green-dark: #0f766e;
        --satraco-dark: #102033;
        --satraco-dark-2: #173b35;
        --satraco-white-soft: #f3f8f5;
    }

    /* =====================================================
           1. HEADER / NAVBAR
           ===================================================== */
    .main-header.satraco-navbar {
        background: #fff;
        border-bottom: 3px solid var(--satraco-green) !important;
        box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
        min-height: 64px;
        padding: 0 12px;
    }

    .satraco-navbar .nav-btn {
        width: 40px;
        height: 40px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        color: var(--satraco-dark) !important;
        background: var(--satraco-white-soft);
        margin-right: 6px;
        padding: 0 !important;
        transition: all .2s ease;
    }

    .satraco-navbar .nav-btn:hover {
        background: var(--satraco-green);
        color: #fff !important;
        transform: translateY(-1px);
    }

    .satraco-welcome {
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-left: 10px;
        padding-left: 14px;
        border-left: 2px solid #e6efe9;
        line-height: 1.2;
    }

    .satraco-welcome .greeting {
        font-weight: 700;
        color: var(--satraco-dark);
        font-size: 15px;
    }

    .satraco-welcome .datetime {
        font-size: 12.5px;
        color: #6b7f78;
    }

    .satraco-welcome .datetime i {
        color: var(--satraco-green-dark);
        margin-right: 4px;
    }

    .satraco-navbar .nav-icon-btn {
        width: 40px;
        height: 40px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--satraco-dark-2) !important;
        margin: 0 3px;
        padding: 0 !important;
        position: relative;
        transition: background .2s ease;
    }

    .satraco-navbar .nav-icon-btn:hover {
        background: var(--satraco-white-soft);
        color: var(--satraco-green-dark) !important;
    }

    .satraco-navbar .nav-icon-btn .navbar-badge {
        top: 4px;
        right: 2px;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 5px;
        border-radius: 10px;
        border: 2px solid #fff;
    }

    .satraco-dropdown {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, .15);
        min-width: 320px;
        margin-top: 10px !important;
    }

    .satraco-dropdown .dropdown-header {
        background: var(--satraco-white-soft);
        color: var(--satraco-dark);
        font-weight: 700;
        padding: 12px 16px;
    }

    .satraco-empty {
        padding: 28px 16px;
        text-align: center;
        color: #8a9a94;
    }

    .satraco-empty i {
        font-size: 30px;
        color: #cfe3d6;
        display: block;
        margin-bottom: 8px;
    }

    /* Chip utilisateur */
    .satraco-user-chip {
        display: flex !important;
        align-items: center;
        gap: 10px;
        padding: 5px 12px 5px 5px !important;
        margin-left: 8px;
        border-radius: 30px;
        background: var(--satraco-white-soft);
        border: 1px solid #e3eee7;
        transition: all .2s ease;
    }

    .satraco-user-chip:hover {
        border-color: var(--satraco-green);
        box-shadow: 0 4px 12px rgba(116, 196, 118, .25);
    }

    .satraco-user-chip.dropdown-toggle::after {
        display: none !important;
    }

    .satraco-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--satraco-green-dark), var(--satraco-green));
        color: #fff;
        font-weight: 800;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        letter-spacing: .5px;
        flex-shrink: 0;
    }

    .satraco-avatar.lg {
        width: 64px;
        height: 64px;
        font-size: 22px;
        margin: 0 auto 8px;
        border: 3px solid rgba(255, 255, 255, .6);
    }

    .satraco-user-info {
        display: flex;
        flex-direction: column;
        line-height: 1.15;
        text-align: left;
    }

    .satraco-user-info .name {
        font-weight: 700;
        font-size: 14px;
        color: var(--satraco-dark);
    }

    .satraco-user-info .role {
        font-size: 11.5px;
        color: var(--satraco-green-dark);
        font-weight: 600;
    }

    .satraco-user-chip .fa-chevron-down {
        font-size: 11px;
        color: #8a9a94;
    }

    .satraco-user-menu {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, .18);
        min-width: 270px;
        padding: 0;
        margin-top: 10px !important;
    }

    .satraco-user-menu .menu-head {
        background: linear-gradient(135deg, #102033 0%, #173b35 45%, #0f766e 100%);
        color: #fff;
        text-align: center;
        padding: 20px 16px 16px;
    }

    .satraco-user-menu .menu-head .name {
        font-weight: 700;
        font-size: 16px;
    }

    .satraco-user-menu .menu-head .role {
        display: inline-block;
        margin-top: 6px;
        background: rgba(116, 196, 118, .9);
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .satraco-user-menu .dropdown-item {
        padding: 11px 18px;
        font-weight: 600;
        color: var(--satraco-dark);
    }

    .satraco-user-menu .dropdown-item i {
        width: 22px;
        color: var(--satraco-green-dark);
    }

    .satraco-user-menu .dropdown-item:hover {
        background: var(--satraco-white-soft);
    }

    .satraco-user-menu .dropdown-item.logout,
    .satraco-user-menu .dropdown-item.logout i {
        color: #c0392b;
    }

    @media (max-width: 767.98px) {

        .satraco-welcome,
        .satraco-user-info,
        .satraco-user-chip .fa-chevron-down {
            display: none !important;
        }

        .satraco-user-chip {
            padding: 3px !important;
            background: transparent;
            border: 0;
        }
    }

    /* =====================================================
           2. SIDEBAR
           ===================================================== */
    .main-sidebar {
        background: linear-gradient(180deg, #102033 0%, #173b35 45%, #0f766e 100%) !important;
    }

    .main-sidebar *,
    .main-sidebar *::before,
    .main-sidebar *::after {
        box-sizing: border-box;
    }

    /* Logo : même hauteur que le header (64px + 3px de bordure) */
    .brand-link {
        height: 67px;
        display: flex !important;
        align-items: center;
        padding: 10px 14px !important;
        background: rgba(255, 255, 255, .05);
        border-bottom: 1px solid rgba(255, 255, 255, .12) !important;
        overflow: hidden;
    }

    .brand-link .brand-image {
        width: 40px;
        height: 40px;
        max-height: 40px;
        object-fit: contain;
        background: #fff;
        padding: 3px;
        border-radius: 50%;
        margin: 0 10px 0 0 !important;
        float: none !important;
        flex-shrink: 0;
    }

    .brand-link .brand-text {
        color: #fff !important;
        font-size: 15px;
        font-weight: 800 !important;
        line-height: 1.15;
        white-space: normal;
    }

    .main-sidebar .sidebar {
        padding: 12px 10px 20px;
        overflow-x: hidden !important;
    }

    .main-sidebar .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .main-sidebar .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, .25);
        border-radius: 10px;
    }

    /* Liens : on annule la largeur fixe d'AdminLTE (cause du débordement) */
    .nav-sidebar .nav-item {
        width: 100%;
        margin: 0;
    }

    .nav-sidebar .nav-link {
        width: 100% !important;
        display: flex !important;
        align-items: center;
        margin: 0 !important;
        white-space: normal;
        transition: background .15s ease, color .15s ease;
    }

    .nav-sidebar .nav-link:focus,
    .nav-sidebar .nav-link:focus-visible {
        outline: none !important;
        box-shadow: none !important;
    }

    .nav-sidebar .nav-link p {
        flex: 1;
        display: flex !important;
        align-items: center;
        margin: 0;
        line-height: 1.3;
        white-space: normal;
        overflow-wrap: anywhere;
    }

    .nav-sidebar .nav-icon {
        width: 20px;
        min-width: 20px;
        margin-right: 10px !important;
        text-align: center;
        font-size: 15px;
        color: inherit !important;
    }

    .nav-sidebar .nav-link p>.right {
        position: static !important;
        margin-left: auto;
        padding-left: 8px;
        transition: transform .2s ease;
    }

    /* Niveau 1 */
    .nav-sidebar>.nav-item {
        margin-bottom: 6px;
    }

    .nav-sidebar>.nav-item>.nav-link {
        min-height: 44px;
        padding: 10px 12px;
        border-radius: 12px;
        color: #eaf7f2 !important;
        font-weight: 700;
        font-size: 13.5px;
    }

    .nav-sidebar>.nav-item>.nav-link:hover {
        background: rgba(116, 196, 118, .18) !important;
        color: #fff !important;
    }

    .nav-sidebar>.nav-item>.nav-link.active {
        background: #74c476 !important;
        color: #fff !important;
        box-shadow: 0 6px 16px rgba(0, 0, 0, .18);
    }

    .nav-sidebar>.nav-item.menu-open>.nav-link:not(.active) {
        background: rgba(255, 255, 255, .08) !important;
    }

    /* Niveau 2 */
    .nav-sidebar .nav-treeview {
        background: rgba(255, 255, 255, .06);
        border-radius: 14px;
        padding: 6px !important;
        margin: 6px 0 4px !important;
    }

    .nav-sidebar .nav-treeview>.nav-item {
        margin-bottom: 4px;
    }

    .nav-sidebar .nav-treeview>.nav-item:last-child {
        margin-bottom: 0;
    }

    .nav-sidebar .nav-treeview .nav-link {
        min-height: 38px;
        padding: 8px 10px;
        border-radius: 10px;
        background: #f4faf7 !important;
        color: #064b43 !important;
        font-weight: 700;
        font-size: 12.5px;
        border: 2px solid transparent;
    }

    .nav-sidebar .nav-treeview .nav-link:hover {
        background: #dff1e3 !important;
        color: #064b43 !important;
    }

    .nav-sidebar .nav-treeview .nav-link.active {
        background: #74c476 !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .15);
    }

    .nav-sidebar .nav-treeview .nav-icon {
        font-size: 13px;
        margin-right: 8px !important;
    }

    .nav-sidebar .nav-treeview .far.fa-circle {
        font-size: 9px;
    }

    .nav-sidebar .nav-treeview>.nav-item.menu-open>.nav-link:not(.active) {
        background: #e7f4ea !important;
        border-color: #74c476;
    }

    /* Niveau 3 */
    .nav-sidebar .nav-treeview .nav-treeview {
        background: rgba(255, 255, 255, .10);
        padding: 5px !important;
        margin: 4px 0 2px !important;
    }

    .nav-sidebar .nav-treeview .nav-treeview .nav-link {
        min-height: 34px;
        padding: 6px 9px;
        font-size: 12px;
    }

    .nav-sidebar .nav-treeview .nav-header {
        color: rgba(255, 255, 255, .6);
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .8px;
        padding: 8px 8px 4px !important;
        background: transparent;
    }

    /* Sidebar réduite (bouton ☰) */
    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .nav-sidebar>.nav-item>.nav-link {
        justify-content: center;
        padding: 10px 0;
    }

    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .nav-sidebar .nav-icon {
        margin-right: 0 !important;
    }

    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .nav-sidebar p,
    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .nav-sidebar .nav-treeview {
        display: none !important;
    }

    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .brand-link {
        justify-content: center;
        padding: 10px 0 !important;
    }

    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .brand-link .brand-image {
        margin: 0 !important;
    }

    .sidebar-mini.sidebar-collapse .main-sidebar:not(:hover) .sidebar {
        padding: 12px 6px;
    }
    </style>

    <link rel="manifest" href="<?= base_url('manifest.json'); ?>">

    <meta name="theme-color" content="#0f766e">

    <meta name="application-name" content="SATRACO">

    <meta name="mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="apple-mobile-web-app-title" content="SATRACO">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/pwa/icons/icon-192x192.png'); ?>">

    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('assets/pwa/icons/icon-192x192.png'); ?>">

    <link rel="icon" type="image/png" sizes="512x512" href="<?= base_url('assets/pwa/icons/icon-512x512.png'); ?>">


</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="AdminLTELogo"
                height="300" width="500">
        </div> -->

        <?php
        // Données utilisateur pour le header
        $firstName = $this->session->userdata('first_name') ?? '';
        $lastName  = $this->session->userdata('last_name') ?? '';
        $fullName  = trim($firstName . ' ' . $lastName);
        $roleName  = $this->auth->getRoleName($this->session->userdata('role_id'));
        $initials  = strtoupper(mb_substr($firstName, 0, 1) . mb_substr($lastName, 0, 1));
        ?>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light satraco-navbar">

            <!-- Gauche -->
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link nav-btn" data-widget="pushmenu" href="#" role="button" title="Menu">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-btn" href="#" onclick="history.back(); return false;"
                        title="Page précédente">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-btn" href="#" onclick="location.reload(); return false;" title="Actualiser">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </li>

                <li class="nav-item d-none d-md-flex">
                    <div class="satraco-welcome">
                        <span class="greeting">
                            <span id="satracoGreeting">Bonjour</span>,
                            <?= html_escape($firstName) ?> 👋
                        </span>
                        <span class="datetime">
                            <i class="far fa-calendar-alt"></i>
                            <span id="satracoDateTime"></span>
                        </span>
                    </div>
                </li>
            </ul>

            <!-- Droite -->
            <ul class="navbar-nav ml-auto align-items-center">

                <!-- Recherche -->
                <li class="nav-item">
                    <a class="nav-link nav-icon-btn" data-widget="navbar-search" href="#" role="button"
                        title="Rechercher">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search"
                                    placeholder="Rechercher un chantier, un engin, un employé..."
                                    aria-label="Rechercher">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit"><i class="fas fa-search"></i></button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-btn" data-toggle="dropdown" href="#" title="Notifications">
                        <i class="far fa-bell"></i>
                        <!-- À brancher plus tard :
                        <span class="badge badge-warning navbar-badge">3</span> -->
                    </a>
                    <div class="dropdown-menu dropdown-menu-right satraco-dropdown">
                        <span class="dropdown-header">
                            <i class="far fa-bell mr-1"></i> Notifications
                        </span>
                        <div class="satraco-empty">
                            <i class="far fa-bell-slash"></i>
                            Aucune notification pour le moment
                        </div>
                    </div>
                </li>

                <!-- Plein écran -->
                <li class="nav-item d-none d-sm-block">
                    <a class="nav-link nav-icon-btn" data-widget="fullscreen" href="#" role="button"
                        title="Plein écran">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                <!-- Utilisateur -->
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle satraco-user-chip" data-toggle="dropdown">
                        <span class="satraco-avatar"><?= html_escape($initials) ?></span>
                        <span class="satraco-user-info">
                            <span class="name"><?= html_escape($fullName) ?></span>
                            <span class="role"><?= html_escape($roleName) ?></span>
                        </span>
                        <i class="fas fa-chevron-down"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right satraco-user-menu">
                        <div class="menu-head">
                            <div class="satraco-avatar lg"><?= html_escape($initials) ?></div>
                            <div class="name"><?= html_escape($fullName) ?></div>
                            <span class="role"><?= html_escape($roleName) ?></span>
                        </div>

                        <a href="#" class="dropdown-item">
                            <i class="far fa-user"></i> Mon profil
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-key"></i> Changer mot de passe
                        </a>
                        <div class="dropdown-divider m-0"></div>
                        <a href="<?= base_url('auth-logout') ?>" class="dropdown-item logout">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <script>
        // Salutation selon l'heure + date/heure en direct (heure du poste client)
        (function() {
            function updateHeader() {
                var now = new Date();
                var h = now.getHours();
                var greet = h < 12 ? 'Bonjour' : (h < 18 ? 'Bon après-midi' : 'Bonsoir');

                var g = document.getElementById('satracoGreeting');
                var d = document.getElementById('satracoDateTime');
                if (g) g.textContent = greet;
                if (d) {
                    d.textContent = now.toLocaleDateString('fr-FR', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }) + ' · ' + now.toLocaleTimeString('fr-FR', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            }
            updateHeader();
            setInterval(updateHeader, 30000);
        })();
        </script>