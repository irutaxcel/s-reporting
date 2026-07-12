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

        /* Fond sidebar comme login */
        .main-sidebar {
            background: linear-gradient(180deg,
                    #102033 0%,
                    #173b35 45%,
                    #0f766e 100%) !important;
        }

        /* Logo */
        .brand-link {
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, .12) !important;
            padding: 12px 10px;
        }

        .brand-link .brand-image {
            width: 42px;
            height: 42px;
            max-height: 42px;
            object-fit: contain;
            background: #fff;
            padding: 4px;
        }

        .brand-link .brand-text {
            color: #fff !important;
            font-weight: 800 !important;
            font-size: 20px;
        }

        /* Menu principal */
        .nav-sidebar>.nav-item {
            margin: 6px 10px;
        }

        .nav-sidebar>.nav-item>.nav-link {
            border-radius: 14px;
            color: #eaf7ef !important;
            font-weight: 600;
            padding: 12px 14px;
        }

        .nav-sidebar>.nav-item>.nav-link:hover {
            background: rgba(116, 196, 118, .18) !important;
            color: #fff !important;
        }

        /* Menu actif */
        .nav-sidebar>.nav-item>.nav-link.active {
            background: rgba(116, 196, 118, .95) !important;
            color: #fff !important;
            box-shadow: 0 8px 18px rgba(0, 0, 0, .18);
        }

        /* Sous-menus */
        .nav-treeview {
            background: rgba(255, 255, 255, .06);
            margin: 6px 8px 12px 8px;
            padding: 8px;
            border-radius: 16px;
        }

        .nav-treeview .nav-item {
            margin-bottom: 7px;
        }

        .nav-treeview .nav-link {
            background: #f3f8f5 !important;
            color: #0f4f45 !important;
            border-radius: 13px;
            font-weight: 700;
            padding: 10px 14px;
        }

        .nav-treeview .nav-link:hover,
        .nav-treeview .nav-link.active {
            background: #74c476 !important;
            color: #fff !important;
        }

        /* Icônes */
        .nav-sidebar .nav-icon {
            color: inherit !important;
            margin-right: 8px;
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .25);
            border-radius: 10px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="AdminLTELogo"
                height="300" width="500">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="<?= base_url('assets/v1/dist/') ?>img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="<?= base_url('assets/v1/dist/') ?>img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="<?= base_url('assets/v1/dist/') ?>img/user3-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>

                <style>
                    .satraco-user-dropdown {
                        border: 0;
                        border-radius: 14px;
                        overflow: hidden;
                        box-shadow: 0 15px 35px rgba(0, 0, 0, .18);
                    }

                    .satraco-user-header {
                        background: linear-gradient(135deg,
                                #102033 0%,
                                #173b35 45%,
                                #74c476 100%) !important;
                        color: #fff;
                    }

                    .satraco-user-header img {
                        background: #fff;
                        padding: 6px;
                    }

                    .satraco-user-header p {
                        font-weight: 700;
                    }

                    .satraco-user-header small {
                        color: #eef7ee;
                    }

                    .satraco-user-dropdown .user-body a {
                        color: #0f4f45 !important;
                        font-weight: 700;
                    }

                    .btn-satraco {
                        background: #74c476;
                        border-color: #74c476;
                        color: #fff;
                        font-weight: 700;
                    }

                    .btn-satraco:hover {
                        background: #3f9f46;
                        border-color: #3f9f46;
                        color: #fff;
                    }
                </style>
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>"
                            class="user-image img-circle elevation-2" alt="User Image">

                        <span class="d-none d-md-inline">
                            <?= $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') ?>
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right satraco-user-dropdown">

                        <li class="user-header satraco-user-header">
                            <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>"
                                class="img-circle elevation-2" alt="User Image">

                            <p>
                                <?= $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') ?>
                                <small><?= $this->auth->getRoleName($this->session->userdata('role_id')) ?></small>
                            </p>
                        </li>

                        <li class="user-body">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <a href="#">Profil</a>
                                </div>
                                <div class="col-4 text-center">
                                    <a href="#">Rôle</a>
                                </div>
                                <div class="col-4 text-center">
                                    <a href="#">Compte</a>
                                </div>
                            </div>
                        </li>

                        <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">
                                Mon profil
                            </a>

                            <a href="<?= base_url('auth-logout') ?>" class="btn btn-satraco btn-flat float-right">
                                Déconnexion
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->