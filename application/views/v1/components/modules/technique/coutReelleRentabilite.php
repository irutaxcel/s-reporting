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

            <style>
            :root {
                --cr-green: #0f766e;
                --cr-green-light: #22c55e;
                --cr-green-soft: #ecfdf5;

                --cr-blue: #2563eb;
                --cr-blue-dark: #1e3a8a;
                --cr-blue-soft: #eff6ff;

                --cr-orange: #f59e0b;
                --cr-orange-dark: #b45309;
                --cr-orange-soft: #fffbeb;

                --cr-red: #dc2626;
                --cr-red-dark: #991b1b;
                --cr-red-soft: #fef2f2;

                --cr-purple: #7c3aed;
                --cr-dark: #0f172a;
                --cr-text: #334155;
                --cr-muted: #64748b;
                --cr-border: #e2e8f0;
                --cr-background: #f8fafc;
                --cr-white: #ffffff;
            }

            .cr-page {
                font-family: "Segoe UI", Arial, sans-serif;
            }

            /*
    |--------------------------------------------------------------------------
    | Cartes statistiques
    |--------------------------------------------------------------------------
    */

            .cr-stat-card {
                position: relative;
                min-height: 135px;
                border: 0;
                border-radius: 19px;
                overflow: hidden;
                color: #fff;
                box-shadow: 0 14px 30px rgba(15, 23, 42, .13);
                transition: transform .25s ease, box-shadow .25s ease;
            }

            .cr-stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 38px rgba(15, 23, 42, .18);
            }

            .cr-stat-card .card-body {
                position: relative;
                z-index: 2;
                padding: 22px;
            }

            .cr-stat-card h2 {
                margin: 0 0 5px;
                font-size: 29px;
                font-weight: 800;
            }

            .cr-stat-card p {
                margin: 0;
                font-size: 13px;
                opacity: .94;
            }

            .cr-stat-card .cr-stat-detail {
                display: block;
                margin-top: 9px;
                font-size: 11px;
                opacity: .85;
            }

            .cr-stat-icon {
                position: absolute;
                right: 20px;
                bottom: 13px;
                font-size: 58px;
                opacity: .18;
            }

            .cr-gradient-budget {
                background: linear-gradient(135deg, #0f766e, #22c55e);
            }

            .cr-gradient-real {
                background: linear-gradient(135deg, #1e3a8a, #2563eb);
            }

            .cr-gradient-margin {
                background: linear-gradient(135deg, #b45309, #f59e0b);
            }

            .cr-gradient-profit {
                background: linear-gradient(135deg, #6d28d9, #8b5cf6);
            }

            /*
    |--------------------------------------------------------------------------
    | Cartes générales
    |--------------------------------------------------------------------------
    */

            .cr-card {
                border: 0;
                border-radius: 18px;
                overflow: hidden;
                box-shadow: 0 10px 28px rgba(15, 23, 42, .08);
                background: #fff;
            }

            .cr-card .card-header {
                padding: 18px 22px;
                background: #fff;
                border-bottom: 1px solid var(--cr-border);
            }

            .cr-card .card-body {
                padding: 20px;
            }

            .cr-title {
                margin: 0;
                color: var(--cr-dark);
                font-size: 18px;
                font-weight: 800;
            }

            .cr-subtitle {
                display: block;
                margin-top: 3px;
                color: var(--cr-muted);
                font-size: 12px;
            }

            /*
    |--------------------------------------------------------------------------
    | Filtres
    |--------------------------------------------------------------------------
    */

            .cr-filter-box {
                padding: 18px;
                border: 1px solid var(--cr-border);
                border-radius: 15px;
                background: var(--cr-background);
            }

            .cr-filter-box label {
                color: var(--cr-text);
                font-size: 12px;
                font-weight: 700;
            }

            .cr-filter-box .form-control {
                min-height: 39px;
                border-color: #cbd5e1;
                border-radius: 8px;
                font-size: 13px;
            }

            .cr-btn-primary {
                color: #fff;
                border: 0;
                border-radius: 9px;
                background: linear-gradient(135deg, var(--cr-green), var(--cr-green-light));
                box-shadow: 0 7px 18px rgba(34, 197, 94, .22);
                font-weight: 700;
            }

            .cr-btn-primary:hover {
                color: #fff;
                opacity: .92;
            }

            /*
    |--------------------------------------------------------------------------
    | Tableau
    |--------------------------------------------------------------------------
    */

            .cr-table thead th {
                padding: 13px 12px;
                border-top: 0;
                border-bottom: 1px solid var(--cr-border);
                background: #f1f5f9;
                color: #334155;
                font-size: 11px;
                font-weight: 800;
                text-transform: uppercase;
                white-space: nowrap;
            }

            .cr-table tbody td {
                padding: 13px 12px;
                border-color: #edf2f7;
                color: var(--cr-text);
                font-size: 13px;
                vertical-align: middle;
            }

            .cr-table tbody tr {
                transition: .2s ease;
            }

            .cr-table tbody tr:hover {
                background: #f8fafc;
            }

            .cr-reference {
                color: var(--cr-green);
                font-weight: 800;
            }

            .cr-money {
                color: var(--cr-dark);
                font-weight: 800;
                white-space: nowrap;
            }

            /*
    |--------------------------------------------------------------------------
    | Badges
    |--------------------------------------------------------------------------
    */

            .cr-badge {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 6px 10px;
                border-radius: 30px;
                font-size: 10px;
                font-weight: 800;
                white-space: nowrap;
            }

            .cr-badge-success {
                color: #166534;
                background: #dcfce7;
            }

            .cr-badge-warning {
                color: #92400e;
                background: #fef3c7;
            }

            .cr-badge-danger {
                color: #991b1b;
                background: #fee2e2;
            }

            .cr-badge-info {
                color: #1d4ed8;
                background: #dbeafe;
            }

            .cr-badge-secondary {
                color: #475569;
                background: #e2e8f0;
            }

            /*
    |--------------------------------------------------------------------------
    | Barres de progression
    |--------------------------------------------------------------------------
    */

            .cr-progress {
                height: 8px;
                overflow: hidden;
                border-radius: 30px;
                background: #e2e8f0;
            }

            .cr-progress .progress-bar {
                border-radius: 30px;
            }

            .cr-rentability-value {
                display: flex;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 5px;
                font-size: 11px;
            }

            /*
    |--------------------------------------------------------------------------
    | Répartition des coûts
    |--------------------------------------------------------------------------
    */

            .cr-cost-item {
                padding: 13px 0;
                border-bottom: 1px dashed var(--cr-border);
            }

            .cr-cost-item:last-child {
                border-bottom: 0;
            }

            .cr-cost-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                margin-bottom: 7px;
            }

            .cr-cost-name {
                display: flex;
                align-items: center;
                gap: 9px;
                color: var(--cr-dark);
                font-size: 13px;
                font-weight: 700;
            }

            .cr-cost-icon {
                width: 34px;
                height: 34px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 10px;
            }

            .cr-cost-amount {
                color: var(--cr-dark);
                font-size: 13px;
                font-weight: 800;
                white-space: nowrap;
            }

            /*
    |--------------------------------------------------------------------------
    | Alertes
    |--------------------------------------------------------------------------
    */

            .cr-alert-item {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                padding: 14px;
                margin-bottom: 12px;
                border: 1px solid transparent;
                border-radius: 13px;
                transition: .2s ease;
            }

            .cr-alert-item:hover {
                transform: translateX(3px);
                box-shadow: 0 6px 15px rgba(15, 23, 42, .07);
            }

            .cr-alert-item:last-child {
                margin-bottom: 0;
            }

            .cr-alert-icon {
                width: 39px;
                height: 39px;
                min-width: 39px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 11px;
            }

            .cr-alert-item strong {
                color: var(--cr-dark);
                font-size: 13px;
            }

            .cr-alert-item p {
                margin: 3px 0 0;
                color: var(--cr-muted);
                font-size: 12px;
            }

            .cr-alert-danger {
                border-color: #fecaca;
                background: var(--cr-red-soft);
            }

            .cr-alert-danger .cr-alert-icon {
                color: var(--cr-red);
                background: #fee2e2;
            }

            .cr-alert-warning {
                border-color: #fde68a;
                background: var(--cr-orange-soft);
            }

            .cr-alert-warning .cr-alert-icon {
                color: var(--cr-orange-dark);
                background: #fef3c7;
            }

            .cr-alert-info {
                border-color: #bfdbfe;
                background: var(--cr-blue-soft);
            }

            .cr-alert-info .cr-alert-icon {
                color: var(--cr-blue);
                background: #dbeafe;
            }

            .cr-alert-success {
                border-color: #bbf7d0;
                background: var(--cr-green-soft);
            }

            .cr-alert-success .cr-alert-icon {
                color: var(--cr-green);
                background: #dcfce7;
            }

            /*
    |--------------------------------------------------------------------------
    | Classement
    |--------------------------------------------------------------------------
    */

            .cr-ranking-item {
                display: flex;
                align-items: center;
                gap: 13px;
                padding: 13px 0;
                border-bottom: 1px dashed var(--cr-border);
            }

            .cr-ranking-item:last-child {
                border-bottom: 0;
            }

            .cr-ranking-number {
                width: 34px;
                height: 34px;
                min-width: 34px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: var(--cr-green-soft);
                color: var(--cr-green);
                font-size: 12px;
                font-weight: 800;
            }

            .cr-ranking-info {
                flex: 1;
                min-width: 0;
            }

            .cr-ranking-info strong {
                display: block;
                overflow: hidden;
                color: var(--cr-dark);
                font-size: 13px;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .cr-ranking-info small {
                color: var(--cr-muted);
            }

            .cr-ranking-value {
                color: var(--cr-dark);
                font-size: 13px;
                font-weight: 800;
                white-space: nowrap;
            }

            /*
    |--------------------------------------------------------------------------
    | Projection
    |--------------------------------------------------------------------------
    */

            .cr-projection-card {
                padding: 15px;
                border: 1px solid var(--cr-border);
                border-radius: 14px;
                background: #f8fafc;
            }

            .cr-projection-card h6 {
                color: var(--cr-dark);
                font-size: 14px;
                font-weight: 800;
            }

            .cr-projection-stat {
                display: flex;
                justify-content: space-between;
                gap: 15px;
                margin-top: 9px;
                font-size: 12px;
            }

            .cr-projection-stat span:first-child {
                color: var(--cr-muted);
            }

            .cr-projection-stat span:last-child {
                color: var(--cr-dark);
                font-weight: 800;
            }

            /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

            @media (max-width: 767px) {
                .cr-stat-card {
                    min-height: 115px;
                }

                .cr-stat-card h2 {
                    font-size: 24px;
                }

                .cr-card .card-header {
                    padding: 15px;
                }

                .cr-card .card-body {
                    padding: 15px;
                }
            }
            </style>

            <div class="cr-page">

                <!-- =========================================================
         1. STATISTIQUES PRINCIPALES
    ========================================================== -->

                <div class="row">

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card cr-stat-card cr-gradient-budget">

                            <div class="card-body">

                                <h2>8,2 Md</h2>

                                <p>Budget total des chantiers</p>

                                <small class="cr-stat-detail">
                                    <i class="fas fa-layer-group mr-1"></i>
                                    12 chantiers actifs
                                </small>

                                <i class="fas fa-wallet cr-stat-icon"></i>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card cr-stat-card cr-gradient-real">

                            <div class="card-body">

                                <h2>6,7 Md</h2>

                                <p>Coût réel engagé</p>

                                <small class="cr-stat-detail">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    81,7 % du budget consommé
                                </small>

                                <i class="fas fa-money-bill-wave cr-stat-icon"></i>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card cr-stat-card cr-gradient-margin">

                            <div class="card-body">

                                <h2>1,5 Md</h2>

                                <p>Marge budgétaire restante</p>

                                <small class="cr-stat-detail">
                                    <i class="fas fa-shield-alt mr-1"></i>
                                    Marge globale disponible
                                </small>

                                <i class="fas fa-chart-line cr-stat-icon"></i>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card cr-stat-card cr-gradient-profit">

                            <div class="card-body">

                                <h2>18,3 %</h2>

                                <p>Rentabilité moyenne</p>

                                <small class="cr-stat-detail">
                                    <i class="fas fa-arrow-trend-up mr-1"></i>
                                    +2,4 % par rapport au mois passé
                                </small>

                                <i class="fas fa-percentage cr-stat-icon"></i>

                            </div>

                        </div>
                    </div>

                </div>

                <!-- =========================================================
         2. FILTRES
    ========================================================== -->

                <div class="card cr-card mb-4">

                    <div class="card-header">

                        <h5 class="cr-title">
                            <i class="fas fa-filter text-success mr-2"></i>
                            Analyse et filtrage
                        </h5>

                        <span class="cr-subtitle">
                            Filtrer les données financières par chantier, période et niveau de rentabilité.
                        </span>

                    </div>

                    <div class="card-body">

                        <form action="" method="get" id="profitabilityFilterForm">

                            <div class="cr-filter-box">

                                <div class="row">

                                    <div class="col-lg-3 col-md-6 mb-3">

                                        <label>Recherche rapide</label>

                                        <input type="text" name="search" class="form-control"
                                            placeholder="Code, projet, chantier...">

                                    </div>

                                    <div class="col-lg-3 col-md-6 mb-3">

                                        <label>Chantier</label>

                                        <select name="chantier_id" class="form-control">

                                            <option value="">Tous les chantiers</option>
                                            <option value="1">GASENYI Présidence</option>
                                            <option value="2">Bloc Ciment</option>
                                            <option value="3">Chantier Gitega</option>
                                            <option value="4">Chantier Rumonge</option>
                                            <option value="5">Entrepôts IBB</option>

                                        </select>

                                    </div>

                                    <div class="col-lg-2 col-md-6 mb-3">

                                        <label>Exercice</label>

                                        <select name="year" class="form-control">
                                            <option value="2026">2026</option>
                                            <option value="2025">2025</option>
                                            <option value="2024">2024</option>
                                        </select>

                                    </div>

                                    <div class="col-lg-2 col-md-6 mb-3">

                                        <label>Mois</label>

                                        <select name="month" class="form-control">

                                            <option value="">Toute l’année</option>
                                            <option value="01">Janvier</option>
                                            <option value="02">Février</option>
                                            <option value="03">Mars</option>
                                            <option value="04">Avril</option>
                                            <option value="05">Mai</option>
                                            <option value="06">Juin</option>
                                            <option value="07">Juillet</option>
                                            <option value="08">Août</option>
                                            <option value="09">Septembre</option>
                                            <option value="10">Octobre</option>
                                            <option value="11">Novembre</option>
                                            <option value="12">Décembre</option>

                                        </select>

                                    </div>

                                    <div class="col-lg-2 col-md-6 mb-3">

                                        <label>Rentabilité</label>

                                        <select name="profit_status" class="form-control">

                                            <option value="">Toutes</option>
                                            <option value="rentable">Rentable</option>
                                            <option value="warning">À surveiller</option>
                                            <option value="deficit">Déficitaire</option>

                                        </select>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-3 mb-3">

                                        <label>Date début</label>

                                        <input type="date" name="date_from" class="form-control">

                                    </div>

                                    <div class="col-md-3 mb-3">

                                        <label>Date fin</label>

                                        <input type="date" name="date_to" class="form-control">

                                    </div>

                                    <div class="col-md-6 mb-3 d-flex align-items-end justify-content-end">

                                        <button type="reset" class="btn btn-secondary mr-2"
                                            onclick="resetProfitabilityFilters()">

                                            <i class="fas fa-redo mr-1"></i>
                                            Réinitialiser

                                        </button>

                                        <button type="submit" class="btn cr-btn-primary">

                                            <i class="fas fa-chart-line mr-1"></i>
                                            Analyser

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <!-- =========================================================
         3. RENTABILITÉ DES CHANTIERS
    ========================================================== -->

                <div class="card cr-card mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="cr-title">
                                <i class="fas fa-building text-success mr-2"></i>
                                Rentabilité des chantiers
                            </h5>

                            <span class="cr-subtitle">
                                Comparaison entre budget, dépenses réelles, marge et niveau de rentabilité.
                            </span>

                        </div>

                        <div>

                            <button type="button" class="btn btn-sm btn-outline-success">

                                <i class="fas fa-file-excel mr-1"></i>
                                Exporter

                            </button>

                            <button type="button" class="btn btn-sm btn-outline-dark">

                                <i class="fas fa-print mr-1"></i>
                                Imprimer

                            </button>

                        </div>

                    </div>

                    <div class="card-body table-responsive p-0">

                        <table class="table table-hover cr-table mb-0">

                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th>Chantier / Projet</th>
                                    <th class="text-right">Budget initial</th>
                                    <th class="text-right">Coût réel</th>
                                    <th class="text-right">Marge</th>
                                    <th>Budget consommé</th>
                                    <th>Rentabilité</th>
                                    <th>Situation</th>
                                    <th class="text-center">Action</th>
                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td>1</td>

                                    <td>

                                        <strong>GASENYI Présidence</strong>

                                        <br>

                                        <small class="cr-reference">
                                            CH-2026-0001
                                        </small>

                                    </td>

                                    <td class="text-right cr-money">
                                        4 000 000 000 BIF
                                    </td>

                                    <td class="text-right cr-money">
                                        3 200 000 000 BIF
                                    </td>

                                    <td class="text-right text-success font-weight-bold">
                                        +800 000 000 BIF
                                    </td>

                                    <td style="min-width:160px;">

                                        <div class="cr-rentability-value">

                                            <span>Consommé</span>

                                            <strong>80 %</strong>

                                        </div>

                                        <div class="progress cr-progress">

                                            <div class="progress-bar bg-success" style="width:80%">
                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <strong class="text-success">
                                            25 %
                                        </strong>

                                    </td>

                                    <td>

                                        <span class="cr-badge cr-badge-success">

                                            <i class="fas fa-check-circle"></i>
                                            Rentable

                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <button type="button" class="btn btn-xs btn-info" title="Voir le détail">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                        <button type="button" class="btn btn-xs btn-success" title="Rapport">

                                            <i class="fas fa-chart-pie"></i>

                                        </button>

                                    </td>

                                </tr>

                                <tr>

                                    <td>2</td>

                                    <td>

                                        <strong>Entrepôts IBB</strong>

                                        <br>

                                        <small class="cr-reference">
                                            CH-2026-0002
                                        </small>

                                    </td>

                                    <td class="text-right cr-money">
                                        1 500 000 000 BIF
                                    </td>

                                    <td class="text-right cr-money">
                                        1 410 000 000 BIF
                                    </td>

                                    <td class="text-right text-warning font-weight-bold">
                                        +90 000 000 BIF
                                    </td>

                                    <td style="min-width:160px;">

                                        <div class="cr-rentability-value">

                                            <span>Consommé</span>

                                            <strong>94 %</strong>

                                        </div>

                                        <div class="progress cr-progress">

                                            <div class="progress-bar bg-warning" style="width:94%">
                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <strong class="text-warning">
                                            6,4 %
                                        </strong>

                                    </td>

                                    <td>

                                        <span class="cr-badge cr-badge-warning">

                                            <i class="fas fa-exclamation-circle"></i>
                                            À surveiller

                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <button type="button" class="btn btn-xs btn-info">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                        <button type="button" class="btn btn-xs btn-success">

                                            <i class="fas fa-chart-pie"></i>

                                        </button>

                                    </td>

                                </tr>

                                <tr>

                                    <td>3</td>

                                    <td>

                                        <strong>Route Nationale RN3</strong>

                                        <br>

                                        <small class="cr-reference">
                                            CH-2026-0003
                                        </small>

                                    </td>

                                    <td class="text-right cr-money">
                                        2 100 000 000 BIF
                                    </td>

                                    <td class="text-right cr-money">
                                        2 450 000 000 BIF
                                    </td>

                                    <td class="text-right text-danger font-weight-bold">
                                        -350 000 000 BIF
                                    </td>

                                    <td style="min-width:160px;">

                                        <div class="cr-rentability-value">

                                            <span>Consommé</span>

                                            <strong>116,7 %</strong>

                                        </div>

                                        <div class="progress cr-progress">

                                            <div class="progress-bar bg-danger" style="width:100%">
                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <strong class="text-danger">
                                            -14,3 %
                                        </strong>

                                    </td>

                                    <td>

                                        <span class="cr-badge cr-badge-danger">

                                            <i class="fas fa-times-circle"></i>
                                            Déficitaire

                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <button type="button" class="btn btn-xs btn-info">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                        <button type="button" class="btn btn-xs btn-success">

                                            <i class="fas fa-chart-pie"></i>

                                        </button>

                                    </td>

                                </tr>

                                <tr>

                                    <td>4</td>

                                    <td>

                                        <strong>Bloc Ciment</strong>

                                        <br>

                                        <small class="cr-reference">
                                            CH-2026-0004
                                        </small>

                                    </td>

                                    <td class="text-right cr-money">
                                        600 000 000 BIF
                                    </td>

                                    <td class="text-right cr-money">
                                        395 000 000 BIF
                                    </td>

                                    <td class="text-right text-success font-weight-bold">
                                        +205 000 000 BIF
                                    </td>

                                    <td style="min-width:160px;">

                                        <div class="cr-rentability-value">

                                            <span>Consommé</span>

                                            <strong>65,8 %</strong>

                                        </div>

                                        <div class="progress cr-progress">

                                            <div class="progress-bar bg-primary" style="width:65.8%">
                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <strong class="text-success">
                                            51,9 %
                                        </strong>

                                    </td>

                                    <td>

                                        <span class="cr-badge cr-badge-success">

                                            <i class="fas fa-check-circle"></i>
                                            Très rentable

                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <button type="button" class="btn btn-xs btn-info">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                        <button type="button" class="btn btn-xs btn-success">

                                            <i class="fas fa-chart-pie"></i>

                                        </button>

                                    </td>

                                </tr>

                            </tbody>

                            <tfoot>

                                <tr class="font-weight-bold bg-light">

                                    <td colspan="2">
                                        TOTAL GÉNÉRAL
                                    </td>

                                    <td class="text-right">
                                        8 200 000 000 BIF
                                    </td>

                                    <td class="text-right">
                                        7 455 000 000 BIF
                                    </td>

                                    <td class="text-right text-success">
                                        +745 000 000 BIF
                                    </td>

                                    <td colspan="4"></td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

                <!-- =========================================================
         4. RÉPARTITION DES COÛTS + CHANTIERS COÛTEUX
    ========================================================== -->

                <div class="row">

                    <!-- Répartition des coûts -->
                    <div class="col-lg-6 mb-4">

                        <div class="card cr-card h-100">

                            <div class="card-header">

                                <h5 class="cr-title">
                                    <i class="fas fa-chart-pie text-success mr-2"></i>
                                    Répartition globale des coûts
                                </h5>

                                <span class="cr-subtitle">
                                    Ventilation des dépenses réelles par catégorie.
                                </span>

                            </div>

                            <div class="card-body">

                                <div class="cr-cost-item">

                                    <div class="cr-cost-header">

                                        <div class="cr-cost-name">

                                            <span class="cr-cost-icon bg-primary text-white">
                                                <i class="fas fa-shopping-cart"></i>
                                            </span>

                                            Achats et matériaux

                                        </div>

                                        <span class="cr-cost-amount">
                                            2 760 000 000 BIF
                                        </span>

                                    </div>

                                    <div class="cr-rentability-value">

                                        <span>Part du coût total</span>

                                        <strong>37 %</strong>

                                    </div>

                                    <div class="progress cr-progress">

                                        <div class="progress-bar bg-primary" style="width:37%">
                                        </div>

                                    </div>

                                </div>

                                <div class="cr-cost-item">

                                    <div class="cr-cost-header">

                                        <div class="cr-cost-name">

                                            <span class="cr-cost-icon bg-success text-white">
                                                <i class="fas fa-users"></i>
                                            </span>

                                            Personnel et main-d’œuvre

                                        </div>

                                        <span class="cr-cost-amount">
                                            2 012 000 000 BIF
                                        </span>

                                    </div>

                                    <div class="cr-rentability-value">

                                        <span>Part du coût total</span>

                                        <strong>27 %</strong>

                                    </div>

                                    <div class="progress cr-progress">

                                        <div class="progress-bar bg-success" style="width:27%">
                                        </div>

                                    </div>

                                </div>

                                <div class="cr-cost-item">

                                    <div class="cr-cost-header">

                                        <div class="cr-cost-name">

                                            <span class="cr-cost-icon bg-warning text-white">
                                                <i class="fas fa-gas-pump"></i>
                                            </span>

                                            Carburant

                                        </div>

                                        <span class="cr-cost-amount">
                                            1 043 000 000 BIF
                                        </span>

                                    </div>

                                    <div class="cr-rentability-value">

                                        <span>Part du coût total</span>

                                        <strong>14 %</strong>

                                    </div>

                                    <div class="progress cr-progress">

                                        <div class="progress-bar bg-warning" style="width:14%">
                                        </div>

                                    </div>

                                </div>

                                <div class="cr-cost-item">

                                    <div class="cr-cost-header">

                                        <div class="cr-cost-name">

                                            <span class="cr-cost-icon bg-danger text-white">
                                                <i class="fas fa-tools"></i>
                                            </span>

                                            Maintenance

                                        </div>

                                        <span class="cr-cost-amount">
                                            820 000 000 BIF
                                        </span>

                                    </div>

                                    <div class="cr-rentability-value">

                                        <span>Part du coût total</span>

                                        <strong>11 %</strong>

                                    </div>

                                    <div class="progress cr-progress">

                                        <div class="progress-bar bg-danger" style="width:11%">
                                        </div>

                                    </div>

                                </div>

                                <div class="cr-cost-item">

                                    <div class="cr-cost-header">

                                        <div class="cr-cost-name">

                                            <span class="cr-cost-icon bg-secondary text-white">
                                                <i class="fas fa-handshake"></i>
                                            </span>

                                            Sous-traitance

                                        </div>

                                        <span class="cr-cost-amount">
                                            820 000 000 BIF
                                        </span>

                                    </div>

                                    <div class="cr-rentability-value">

                                        <span>Part du coût total</span>

                                        <strong>11 %</strong>

                                    </div>

                                    <div class="progress cr-progress">

                                        <div class="progress-bar bg-secondary" style="width:11%">
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Chantiers les plus coûteux -->
                    <div class="col-lg-6 mb-4">

                        <div class="card cr-card h-100">

                            <div class="card-header">

                                <h5 class="cr-title">
                                    <i class="fas fa-ranking-star text-warning mr-2"></i>
                                    Chantiers les plus coûteux
                                </h5>

                                <span class="cr-subtitle">
                                    Classement des chantiers selon les dépenses engagées.
                                </span>

                            </div>

                            <div class="card-body">

                                <div class="cr-ranking-item">

                                    <div class="cr-ranking-number">
                                        1
                                    </div>

                                    <div class="cr-ranking-info">

                                        <strong>GASENYI Présidence</strong>

                                        <small>
                                            43 % du coût global
                                        </small>

                                        <div class="progress cr-progress mt-2">

                                            <div class="progress-bar bg-danger" style="width:100%">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="cr-ranking-value">
                                        3,2 Md
                                    </div>

                                </div>

                                <div class="cr-ranking-item">

                                    <div class="cr-ranking-number">
                                        2
                                    </div>

                                    <div class="cr-ranking-info">

                                        <strong>Route Nationale RN3</strong>

                                        <small>
                                            32,8 % du coût global
                                        </small>

                                        <div class="progress cr-progress mt-2">

                                            <div class="progress-bar bg-warning" style="width:76%">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="cr-ranking-value">
                                        2,45 Md
                                    </div>

                                </div>

                                <div class="cr-ranking-item">

                                    <div class="cr-ranking-number">
                                        3
                                    </div>

                                    <div class="cr-ranking-info">

                                        <strong>Entrepôts IBB</strong>

                                        <small>
                                            18,9 % du coût global
                                        </small>

                                        <div class="progress cr-progress mt-2">

                                            <div class="progress-bar bg-primary" style="width:44%">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="cr-ranking-value">
                                        1,41 Md
                                    </div>

                                </div>

                                <div class="cr-ranking-item">

                                    <div class="cr-ranking-number">
                                        4
                                    </div>

                                    <div class="cr-ranking-info">

                                        <strong>Bloc Ciment</strong>

                                        <small>
                                            5,3 % du coût global
                                        </small>

                                        <div class="progress cr-progress mt-2">

                                            <div class="progress-bar bg-success" style="width:15%">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="cr-ranking-value">
                                        395 M
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- =========================================================
         5. COÛTS PAR ENGIN + ALERTES BUDGÉTAIRES
    ========================================================== -->

                <div class="row">

                    <!-- Engins les plus coûteux -->
                    <div class="col-lg-7 mb-4">

                        <div class="card cr-card h-100">

                            <div class="card-header">

                                <h5 class="cr-title">
                                    <i class="fas fa-truck-monster text-success mr-2"></i>
                                    Coût d’exploitation des engins
                                </h5>

                                <span class="cr-subtitle">
                                    Carburant et maintenance cumulés par engin.
                                </span>

                            </div>

                            <div class="card-body table-responsive p-0">

                                <table class="table table-hover cr-table mb-0">

                                    <thead>

                                        <tr>
                                            <th>Engin / Matériel</th>
                                            <th class="text-right">Carburant</th>
                                            <th class="text-right">Maintenance</th>
                                            <th class="text-right">Total</th>
                                            <th>Poids</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td>

                                                <strong>Excavatrice CAT320D</strong>

                                                <br>

                                                <small class="text-muted">
                                                    ENG-2026-00002
                                                </small>

                                            </td>

                                            <td class="text-right">
                                                23 000 000
                                            </td>

                                            <td class="text-right">
                                                12 000 000
                                            </td>

                                            <td class="text-right cr-money">
                                                35 000 000
                                            </td>

                                            <td style="min-width:100px;">

                                                <div class="progress cr-progress">

                                                    <div class="progress-bar bg-danger" style="width:100%">
                                                    </div>

                                                </div>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>

                                                <strong>Camion Actros</strong>

                                                <br>

                                                <small class="text-muted">
                                                    ENG-2026-00011
                                                </small>

                                            </td>

                                            <td class="text-right">
                                                18 000 000
                                            </td>

                                            <td class="text-right">
                                                8 000 000
                                            </td>

                                            <td class="text-right cr-money">
                                                26 000 000
                                            </td>

                                            <td>

                                                <div class="progress cr-progress">

                                                    <div class="progress-bar bg-warning" style="width:74%">
                                                    </div>

                                                </div>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>

                                                <strong>Pompe à béton</strong>

                                                <br>

                                                <small class="text-muted">
                                                    ENG-2026-00016
                                                </small>

                                            </td>

                                            <td class="text-right">
                                                12 500 000
                                            </td>

                                            <td class="text-right">
                                                10 800 000
                                            </td>

                                            <td class="text-right cr-money">
                                                23 300 000
                                            </td>

                                            <td>

                                                <div class="progress cr-progress">

                                                    <div class="progress-bar bg-primary" style="width:66%">
                                                    </div>

                                                </div>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>

                                                <strong>Camion malaxeur</strong>

                                                <br>

                                                <small class="text-muted">
                                                    ENG-2026-00015
                                                </small>

                                            </td>

                                            <td class="text-right">
                                                14 000 000
                                            </td>

                                            <td class="text-right">
                                                5 000 000
                                            </td>

                                            <td class="text-right cr-money">
                                                19 000 000
                                            </td>

                                            <td>

                                                <div class="progress cr-progress">

                                                    <div class="progress-bar bg-success" style="width:54%">
                                                    </div>

                                                </div>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <!-- Alertes -->
                    <div class="col-lg-5 mb-4">

                        <div class="card cr-card h-100">

                            <div class="card-header">

                                <h5 class="cr-title">
                                    <i class="fas fa-bell text-warning mr-2"></i>
                                    Alertes budgétaires
                                </h5>

                                <span class="cr-subtitle">
                                    Chantiers et coûts nécessitant une attention rapide.
                                </span>

                            </div>

                            <div class="card-body">

                                <div class="cr-alert-item cr-alert-danger">

                                    <div class="cr-alert-icon">

                                        <i class="fas fa-arrow-trend-up"></i>

                                    </div>

                                    <div>

                                        <strong>Dépassement budgétaire</strong>

                                        <p>
                                            Le chantier Route Nationale RN3 dépasse son budget de
                                            350 000 000 BIF.
                                        </p>

                                    </div>

                                </div>

                                <div class="cr-alert-item cr-alert-warning">

                                    <div class="cr-alert-icon">

                                        <i class="fas fa-chart-pie"></i>

                                    </div>

                                    <div>

                                        <strong>Budget presque consommé</strong>

                                        <p>
                                            Le chantier Entrepôts IBB a déjà consommé 94 % de son budget.
                                        </p>

                                    </div>

                                </div>

                                <div class="cr-alert-item cr-alert-warning">

                                    <div class="cr-alert-icon">

                                        <i class="fas fa-tools"></i>

                                    </div>

                                    <div>

                                        <strong>Maintenance élevée</strong>

                                        <p>
                                            L’excavatrice CAT320D dépasse le coût moyen de maintenance.
                                        </p>

                                    </div>

                                </div>

                                <div class="cr-alert-item cr-alert-success">

                                    <div class="cr-alert-icon">

                                        <i class="fas fa-check-circle"></i>

                                    </div>

                                    <div>

                                        <strong>Chantier performant</strong>

                                        <p>
                                            Le chantier Bloc Ciment présente une rentabilité de 51,9 %.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- =========================================================
         6. TOP DÉPENSES + PROJECTIONS
    ========================================================== -->

                <div class="row">

                    <!-- Top dépenses -->
                    <div class="col-lg-6 mb-4">

                        <div class="card cr-card h-100">

                            <div class="card-header">

                                <h5 class="cr-title">
                                    <i class="fas fa-money-check-alt text-success mr-2"></i>
                                    Principaux postes de dépenses
                                </h5>

                                <span class="cr-subtitle">
                                    Les dépenses les plus importantes sur l’ensemble des chantiers.
                                </span>

                            </div>

                            <div class="card-body table-responsive p-0">

                                <table class="table table-hover cr-table mb-0">

                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Poste de dépense</th>
                                            <th>Catégorie</th>
                                            <th class="text-right">Montant</th>
                                            <th>Part</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        <tr>
                                            <td>1</td>
                                            <td><strong>Ciment</strong></td>
                                            <td>Matériaux</td>
                                            <td class="text-right cr-money">920 000 000</td>
                                            <td><span class="cr-badge cr-badge-info">12,3 %</span></td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td><strong>Salaires chantier</strong></td>
                                            <td>Personnel</td>
                                            <td class="text-right cr-money">880 000 000</td>
                                            <td><span class="cr-badge cr-badge-success">11,8 %</span></td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td><strong>Carburant</strong></td>
                                            <td>Exploitation</td>
                                            <td class="text-right cr-money">740 000 000</td>
                                            <td><span class="cr-badge cr-badge-warning">9,9 %</span></td>
                                        </tr>

                                        <tr>
                                            <td>4</td>
                                            <td><strong>Acier et fer</strong></td>
                                            <td>Matériaux</td>
                                            <td class="text-right cr-money">690 000 000</td>
                                            <td><span class="cr-badge cr-badge-info">9,2 %</span></td>
                                        </tr>

                                        <tr>
                                            <td>5</td>
                                            <td><strong>Location d’engins</strong></td>
                                            <td>Sous-traitance</td>
                                            <td class="text-right cr-money">420 000 000</td>
                                            <td><span class="cr-badge cr-badge-secondary">5,6 %</span></td>
                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <!-- Projection finale -->
                    <div class="col-lg-6 mb-4">

                        <div class="card cr-card h-100">

                            <div class="card-header">

                                <h5 class="cr-title">
                                    <i class="fas fa-chart-line text-primary mr-2"></i>
                                    Prévisions de fin de chantier
                                </h5>

                                <span class="cr-subtitle">
                                    Projection du coût final selon le rythme actuel des dépenses.
                                </span>

                            </div>

                            <div class="card-body">

                                <div class="cr-projection-card mb-3">

                                    <h6>
                                        GASENYI Présidence
                                    </h6>

                                    <div class="cr-projection-stat">

                                        <span>Budget initial</span>

                                        <span>4 000 000 000 BIF</span>

                                    </div>

                                    <div class="cr-projection-stat">

                                        <span>Coût actuel</span>

                                        <span>3 200 000 000 BIF</span>

                                    </div>

                                    <div class="cr-projection-stat">

                                        <span>Projection finale</span>

                                        <span class="text-warning">
                                            3 820 000 000 BIF
                                        </span>

                                    </div>

                                    <div class="progress cr-progress mt-3">

                                        <div class="progress-bar bg-success" style="width:95.5%">
                                        </div>

                                    </div>

                                </div>

                                <div class="cr-projection-card mb-3">

                                    <h6>
                                        Entrepôts IBB
                                    </h6>

                                    <div class="cr-projection-stat">

                                        <span>Budget initial</span>

                                        <span>1 500 000 000 BIF</span>

                                    </div>

                                    <div class="cr-projection-stat">

                                        <span>Coût actuel</span>

                                        <span>1 410 000 000 BIF</span>

                                    </div>

                                    <div class="cr-projection-stat">

                                        <span>Projection finale</span>

                                        <span class="text-danger">
                                            1 790 000 000 BIF
                                        </span>

                                    </div>

                                    <div class="progress cr-progress mt-3">

                                        <div class="progress-bar bg-danger" style="width:100%">
                                        </div>

                                    </div>

                                </div>

                                <div class="cr-projection-card">

                                    <h6>
                                        Bloc Ciment
                                    </h6>

                                    <div class="cr-projection-stat">

                                        <span>Budget initial</span>

                                        <span>600 000 000 BIF</span>

                                    </div>

                                    <div class="cr-projection-stat">

                                        <span>Coût actuel</span>

                                        <span>395 000 000 BIF</span>

                                    </div>

                                    <div class="cr-projection-stat">

                                        <span>Projection finale</span>

                                        <span class="text-success">
                                            510 000 000 BIF
                                        </span>

                                    </div>

                                    <div class="progress cr-progress mt-3">

                                        <div class="progress-bar bg-success" style="width:85%">
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- =========================================================
         7. SYNTHÈSE PAR CATÉGORIE ET CHANTIER
    ========================================================== -->

                <div class="card cr-card mb-4">

                    <div class="card-header">

                        <h5 class="cr-title">
                            <i class="fas fa-table text-success mr-2"></i>
                            Synthèse détaillée des coûts par chantier
                        </h5>

                        <span class="cr-subtitle">
                            Répartition des dépenses selon les principales sources de coûts.
                        </span>

                    </div>

                    <div class="card-body table-responsive p-0">

                        <table class="table table-hover cr-table mb-0">

                            <thead>

                                <tr>
                                    <th>Chantier</th>
                                    <th class="text-right">Achats</th>
                                    <th class="text-right">Personnel</th>
                                    <th class="text-right">Carburant</th>
                                    <th class="text-right">Maintenance</th>
                                    <th class="text-right">Sous-traitance</th>
                                    <th class="text-right">Total</th>
                                    <th>Poste dominant</th>
                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td>

                                        <strong>GASENYI Présidence</strong>

                                        <br>

                                        <small class="text-muted">
                                            CH-2026-0001
                                        </small>

                                    </td>

                                    <td class="text-right">1 300 000 000</td>
                                    <td class="text-right">780 000 000</td>
                                    <td class="text-right">410 000 000</td>
                                    <td class="text-right">310 000 000</td>
                                    <td class="text-right">400 000 000</td>
                                    <td class="text-right cr-money">3 200 000 000</td>

                                    <td>
                                        <span class="cr-badge cr-badge-info">
                                            Achats
                                        </span>
                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        <strong>Route Nationale RN3</strong>

                                        <br>

                                        <small class="text-muted">
                                            CH-2026-0003
                                        </small>

                                    </td>

                                    <td class="text-right">920 000 000</td>
                                    <td class="text-right">620 000 000</td>
                                    <td class="text-right">430 000 000</td>
                                    <td class="text-right">260 000 000</td>
                                    <td class="text-right">220 000 000</td>
                                    <td class="text-right cr-money">2 450 000 000</td>

                                    <td>
                                        <span class="cr-badge cr-badge-info">
                                            Achats
                                        </span>
                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        <strong>Entrepôts IBB</strong>

                                        <br>

                                        <small class="text-muted">
                                            CH-2026-0002
                                        </small>

                                    </td>

                                    <td class="text-right">440 000 000</td>
                                    <td class="text-right">470 000 000</td>
                                    <td class="text-right">150 000 000</td>
                                    <td class="text-right">180 000 000</td>
                                    <td class="text-right">170 000 000</td>
                                    <td class="text-right cr-money">1 410 000 000</td>

                                    <td>
                                        <span class="cr-badge cr-badge-success">
                                            Personnel
                                        </span>
                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        <strong>Bloc Ciment</strong>

                                        <br>

                                        <small class="text-muted">
                                            CH-2026-0004
                                        </small>

                                    </td>

                                    <td class="text-right">100 000 000</td>
                                    <td class="text-right">142 000 000</td>
                                    <td class="text-right">53 000 000</td>
                                    <td class="text-right">70 000 000</td>
                                    <td class="text-right">30 000 000</td>
                                    <td class="text-right cr-money">395 000 000</td>

                                    <td>
                                        <span class="cr-badge cr-badge-success">
                                            Personnel
                                        </span>
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <script>
            function resetProfitabilityFilters() {
                const form = document.getElementById('profitabilityFilterForm');

                if (form) {
                    form.reset();
                }
            }
            </script>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->