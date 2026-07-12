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
                --mc-green: #0f766e;
                --mc-green-light: #22c55e;
                --mc-blue: #2563eb;
                --mc-orange: #f59e0b;
                --mc-red: #dc2626;
                --mc-dark: #0f172a;
                --mc-muted: #64748b;
                --mc-border: #e2e8f0;
                --mc-bg: #f8fafc;
            }

            .mc-page {
                font-family: "Segoe UI", sans-serif;
            }

            .mc-stat-card {
                border: 0;
                border-radius: 18px;
                color: #fff;
                overflow: hidden;
                position: relative;
                min-height: 125px;
                box-shadow: 0 12px 28px rgba(15, 23, 42, .10);
            }

            .mc-stat-card .card-body {
                position: relative;
                z-index: 2;
            }

            .mc-stat-card h3 {
                margin-bottom: 3px;
                font-weight: 800;
                font-size: 28px;
            }

            .mc-stat-card p {
                margin-bottom: 0;
                font-size: 13px;
                opacity: .92;
            }

            .mc-stat-card .mc-stat-icon {
                position: absolute;
                right: 20px;
                bottom: 12px;
                font-size: 58px;
                opacity: .18;
            }

            .mc-gradient-green {
                background: linear-gradient(135deg, #047857, #22c55e);
            }

            .mc-gradient-orange {
                background: linear-gradient(135deg, #b45309, #f59e0b);
            }

            .mc-gradient-blue {
                background: linear-gradient(135deg, #1e3a8a, #2563eb);
            }

            .mc-gradient-red {
                background: linear-gradient(135deg, #991b1b, #ef4444);
            }

            .mc-card {
                border: 0;
                border-radius: 18px;
                overflow: hidden;
                box-shadow: 0 10px 26px rgba(15, 23, 42, .08);
            }

            .mc-card .card-header {
                background: #fff;
                border-bottom: 1px solid var(--mc-border);
                padding: 18px 22px;
            }

            .mc-title {
                margin: 0;
                color: var(--mc-dark);
                font-size: 18px;
                font-weight: 800;
            }

            .mc-subtitle {
                display: block;
                color: var(--mc-muted);
                font-size: 12px;
                margin-top: 3px;
            }

            .mc-action-card {
                height: 100%;
                background: #fff;
                border: 1px dashed #cbd5e1;
                border-radius: 16px;
                padding: 18px 15px;
                text-align: center;
                cursor: pointer;
                transition: .25s ease;
            }

            .mc-action-card:hover {
                transform: translateY(-3px);
                border-color: var(--mc-green);
                background: #ecfdf5;
                box-shadow: 0 10px 20px rgba(15, 118, 110, .12);
            }

            .mc-action-icon {
                width: 50px;
                height: 50px;
                margin: 0 auto 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 14px;
                background: #d1fae5;
                color: var(--mc-green);
                font-size: 22px;
            }

            .mc-action-card h6 {
                color: var(--mc-dark);
                font-weight: 700;
                margin-bottom: 4px;
            }

            .mc-action-card small {
                color: var(--mc-muted);
            }

            .mc-filter-box {
                padding: 18px;
                background: var(--mc-bg);
                border: 1px solid var(--mc-border);
                border-radius: 15px;
            }

            .mc-filter-box label {
                font-size: 12px;
                font-weight: 700;
                color: #334155;
            }

            .mc-btn-primary {
                background: linear-gradient(135deg, var(--mc-green), var(--mc-green-light));
                color: #fff;
                border: 0;
                border-radius: 9px;
                font-weight: 600;
                box-shadow: 0 7px 16px rgba(34, 197, 94, .22);
            }

            .mc-btn-primary:hover {
                color: #fff;
                opacity: .92;
            }

            .mc-table thead th {
                background: #f1f5f9;
                color: #334155;
                border-top: 0;
                border-bottom: 1px solid var(--mc-border);
                font-size: 11px;
                text-transform: uppercase;
                white-space: nowrap;
            }

            .mc-table tbody td {
                vertical-align: middle;
                font-size: 13px;
                border-color: #edf2f7;
            }

            .mc-badge {
                display: inline-block;
                padding: 6px 10px;
                border-radius: 30px;
                font-size: 10px;
                font-weight: 700;
                white-space: nowrap;
            }

            .mc-badge-success {
                background: #dcfce7;
                color: #166534;
            }

            .mc-badge-warning {
                background: #fef3c7;
                color: #92400e;
            }

            .mc-badge-danger {
                background: #fee2e2;
                color: #991b1b;
            }

            .mc-badge-info {
                background: #dbeafe;
                color: #1d4ed8;
            }

            .mc-alert-item {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                padding: 13px;
                border-radius: 13px;
                margin-bottom: 12px;
                border: 1px solid transparent;
            }

            .mc-alert-icon {
                width: 38px;
                height: 38px;
                min-width: 38px;
                border-radius: 11px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .mc-alert-warning {
                background: #fffbeb;
                border-color: #fde68a;
            }

            .mc-alert-warning .mc-alert-icon {
                background: #fef3c7;
                color: #d97706;
            }

            .mc-alert-danger {
                background: #fef2f2;
                border-color: #fecaca;
            }

            .mc-alert-danger .mc-alert-icon {
                background: #fee2e2;
                color: #dc2626;
            }

            .mc-alert-info {
                background: #eff6ff;
                border-color: #bfdbfe;
            }

            .mc-alert-info .mc-alert-icon {
                background: #dbeafe;
                color: #2563eb;
            }

            .mc-alert-item strong {
                color: var(--mc-dark);
                font-size: 13px;
            }

            .mc-alert-item p {
                margin: 2px 0 0;
                font-size: 12px;
                color: var(--mc-muted);
            }

            .mc-engin-line {
                margin-bottom: 17px;
            }

            .mc-engin-line:last-child {
                margin-bottom: 0;
            }

            .mc-engin-line .progress {
                height: 8px;
                border-radius: 30px;
                background: #e2e8f0;
            }

            .mc-progress-label {
                display: flex;
                justify-content: space-between;
                font-size: 12px;
                margin-bottom: 5px;
            }

            .mc-cost-value {
                font-weight: 800;
                color: var(--mc-dark);
            }

            .mc-modal-header {
                background: linear-gradient(135deg, #0f766e, #22c55e);
                color: #fff;
            }

            .mc-modal-header-warning {
                background: linear-gradient(135deg, #b45309, #f59e0b);
                color: #fff;
            }

            #maintenanceDocumentsPreview {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                width: 100%;
            }

            .maintenance-image-preview {
                width: 110px;
                padding: 6px;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(15, 23, 42, .08);
                text-align: center;
            }

            .maintenance-image-preview img {
                display: block;
                width: 100%;
                height: 80px;
                object-fit: cover;
                border-radius: 8px;
            }

            .maintenance-doc-preview {
                width: 100%;
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 11px 13px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
            }

            .maintenance-doc-icon {
                width: 38px;
                height: 38px;
                min-width: 38px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #fff;
                border-radius: 9px;
            }

            .maintenance-doc-icon i {
                font-size: 23px;
            }

            .maintenance-preview-name {
                max-width: 100%;
                color: #334155;
                font-size: 12px;
                font-weight: 700;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            @media (max-width: 767px) {
                .mc-stat-card {
                    min-height: 105px;
                }

                .mc-stat-card h3 {
                    font-size: 23px;
                }
            }

            .mc-alert-item {
                position: relative;
                transition: all .2s ease;
            }

            .mc-alert-item:hover {
                transform: translateX(3px);
                box-shadow: 0 5px 14px rgba(15, 23, 42, .08);
            }

            .mc-engin-line {
                padding: 8px 0;
            }

            .mc-engin-line:not(:last-child) {
                border-bottom: 1px dashed #e2e8f0;
                padding-bottom: 15px;
            }

            .mc-progress-label strong {
                color: #1e293b;
            }

            .mc-cost-value {
                white-space: nowrap;
            }

            .mc-engin-line .progress {
                overflow: hidden;
            }

            .mc-engin-line .progress-bar {
                border-radius: 30px;
                transition: width .5s ease;
            }

            .mc-table tbody tr {
                transition: background-color .2s ease;
            }

            .mc-table tbody tr:hover {
                background: #f8fafc;
            }

            .mc-table td strong {
                color: #1e293b;
            }

            .mc-table .btn-xs {
                margin: 1px;
            }
            </style>

            <div class="mc-page">

                <!-- Statistiques -->
                <div class="row">

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card mc-stat-card mc-gradient-green">

                            <div class="card-body">

                                <h3>
                                    <?= number_format(
                                        (float) (
                                            $maintenanceFuelStats->total_litres ?? 0
                                        ),
                                        2,
                                        ',',
                                        ' '
                                    ) ?>
                                    L
                                </h3>

                                <p>Carburant consommé ce mois</p>

                                <i class="fas fa-gas-pump mc-stat-icon"></i>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card mc-stat-card mc-gradient-orange">

                            <div class="card-body">

                                <h3>
                                    <?= (int) (
                                        $maintenanceFuelStats->programmed_maintenance
                                        ?? 0
                                    ) ?>
                                </h3>

                                <p>Maintenances programmées</p>

                                <i class="fas fa-tools mc-stat-icon"></i>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card mc-stat-card mc-gradient-blue">

                            <div class="card-body">

                                <h3>
                                    <?= (int) (
                                        $maintenanceFuelStats->engins_in_workshop
                                        ?? 0
                                    ) ?>
                                </h3>

                                <p>Engins actuellement en atelier</p>

                                <i class="fas fa-wrench mc-stat-icon"></i>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card mc-stat-card mc-gradient-red">

                            <div class="card-body">

                                <h3>
                                    <?= number_format(
                                        (float) (
                                            $maintenanceFuelStats->total_operation_cost
                                            ?? 0
                                        ),
                                        0,
                                        ',',
                                        ' '
                                    ) ?>
                                </h3>

                                <p>Coût d’exploitation du mois</p>

                                <i class="fas fa-coins mc-stat-icon"></i>

                            </div>

                        </div>
                    </div>

                </div>

                <!-- Actions rapides -->
                <div class="row mb-4">

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="mc-action-card" data-toggle="modal" data-target="#addFuelModal">
                            <div class="mc-action-icon">
                                <i class="fas fa-gas-pump"></i>
                            </div>
                            <h6>Nouveau ravitaillement</h6>
                            <small>Enregistrer une consommation</small>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="mc-action-card" data-toggle="modal" data-target="#addMaintenanceModal">
                            <div class="mc-action-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h6>Nouvelle maintenance</h6>
                            <small>Préventive ou corrective</small>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="mc-action-card">
                            <div class="mc-action-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h6>Signaler une panne</h6>
                            <small>Déclarer un engin indisponible</small>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="mc-action-card">
                            <div class="mc-action-icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <h6>Historique complet</h6>
                            <small>Consulter toutes les opérations</small>
                        </div>
                    </div>

                </div>

                <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">
                        &times;
                    </button>

                    <i class="fas fa-check-circle mr-1"></i>
                    <?= $this->session->flashdata('success') ?>
                </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">
                        &times;
                    </button>

                    <i class="fas fa-exclamation-circle mr-1"></i>
                    <?= $this->session->flashdata('error') ?>
                </div>
                <?php endif; ?>

                <!-- Filtres -->
                <div class="card mc-card mb-4">

                    <div class="card-header">
                        <h5 class="mc-title">
                            <i class="fas fa-filter text-success mr-2"></i>
                            Filtres de recherche
                        </h5>
                        <span class="mc-subtitle">
                            Filtrer les consommations, maintenances et interventions par engin ou chantier.
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="mc-filter-box">

                            <div class="row">

                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label>Recherche</label>
                                    <input type="text" class="form-control" placeholder="Code, plaque, désignation...">
                                </div>

                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label>Engin / Matériel</label>
                                    <select class="form-control">
                                        <option value="">Tous les engins</option>
                                        <option>ENG-2026-00002 - Excavatrice CAT320</option>
                                        <option>ENG-2026-00011 - Camion Actros</option>
                                        <option>ENG-2026-00015 - Camion malaxeur</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-6 mb-3">
                                    <label>Type d’opération</label>
                                    <select class="form-control">
                                        <option value="">Toutes</option>
                                        <option>Carburant</option>
                                        <option>Maintenance</option>
                                        <option>Panne</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-6 mb-3">
                                    <label>Chantier</label>
                                    <select class="form-control">
                                        <option value="">Tous les chantiers</option>
                                        <option>Chantier Gitega</option>
                                        <option>Chantier Rumonge</option>
                                        <option>Dépôt central</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-6 mb-3">
                                    <label>État</label>
                                    <select class="form-control">
                                        <option value="">Tous les états</option>
                                        <option>Programmé</option>
                                        <option>En cours</option>
                                        <option>Terminé</option>
                                        <option>Annulé</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <label>Date début</label>
                                    <input type="date" class="form-control">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Date fin</label>
                                    <input type="date" class="form-control">
                                </div>

                                <div class="col-md-6 d-flex align-items-end justify-content-end mb-3">
                                    <button type="button" class="btn btn-secondary mr-2">
                                        <i class="fas fa-redo mr-1"></i>
                                        Réinitialiser
                                    </button>

                                    <button type="button" class="btn mc-btn-primary">
                                        <i class="fas fa-search mr-1"></i>
                                        Rechercher
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

                <!-- Carburant et maintenance -->
                <div class="row">

                    <!-- Carburant -->
                    <div class="col-xl-7 mb-4">

                        <div class="card mc-card h-100">

                            <div class="card-header d-flex justify-content-between align-items-center">

                                <div>
                                    <h5 class="mc-title">
                                        <i class="fas fa-gas-pump text-success mr-2"></i>
                                        Derniers ravitaillements
                                    </h5>
                                    <span class="mc-subtitle">
                                        Suivi des quantités et coûts de carburant.
                                    </span>
                                </div>

                                <button type="button" class="btn btn-sm mc-btn-primary" data-toggle="modal"
                                    data-target="#addFuelModal">
                                    <i class="fas fa-plus mr-1"></i>
                                    Nouveau
                                </button>

                            </div>

                            <div class="card-body table-responsive p-0">

                                <table class="table table-hover mc-table mb-0">

                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Engin</th>
                                            <th>Chantier</th>
                                            <th class="text-right">Litres</th>
                                            <th class="text-right">Prix/L</th>
                                            <th class="text-right">Montant</th>
                                            <th>Responsable</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php if (!empty($allEnginsWithFuel)): ?>

                                        <?php foreach ($allEnginsWithFuel as $fuel): ?>

                                        <tr>

                                            <td>
                                                <?= !empty($fuel->operation_date)
                                                            ? date('d/m/Y', strtotime($fuel->operation_date))
                                                            : '-'
                                                        ?>
                                            </td>

                                            <td>
                                                <strong>
                                                    <?= html_escape($fuel->designation ?: '-') ?>
                                                </strong>

                                                <br>

                                                <small class="text-muted">
                                                    <?= html_escape($fuel->code_engin ?: '-') ?>
                                                </small>
                                            </td>

                                            <td>
                                                <?= html_escape(
                                                            $fuel->chantier_name ?: 'Aucun chantier'
                                                        ) ?>
                                            </td>

                                            <td class="text-right">
                                                <?= number_format(
                                                            (float) $fuel->quantity_litre,
                                                            2,
                                                            ',',
                                                            ' '
                                                        ) ?>
                                                L
                                            </td>

                                            <td class="text-right">
                                                <?= number_format(
                                                            (float) $fuel->unit_price,
                                                            0,
                                                            ',',
                                                            ' '
                                                        ) ?>
                                            </td>

                                            <td class="text-right font-weight-bold">
                                                <?= number_format(
                                                            (float) $fuel->total_amount,
                                                            0,
                                                            ',',
                                                            ' '
                                                        ) ?>
                                            </td>

                                            <td>
                                                <?= !empty($fuel->operator_name)
                                                            ? html_escape($fuel->operator_name)
                                                            : '-'
                                                        ?>
                                            </td>

                                            <td class="text-center">

                                                <button type="button" class="btn btn-xs btn-info"
                                                    title="Voir le ravitaillement" onclick="viewFuel(
                                                        <?= (int) $fuel->id ?>,
                                                        '<?= html_escape(
                                                                $fuel->code_engin
                                                            ) ?>',
                                                        '<?= html_escape(
                                                                addslashes($fuel->designation)
                                                            ) ?>',
                                                        '<?= html_escape(
                                                                addslashes($fuel->chantier_name ?: '')
                                                            ) ?>',
                                                        '<?= $fuel->operation_date ?>',
                                                        '<?= $fuel->quantity_litre ?>',
                                                        '<?= $fuel->unit_price ?>',
                                                        '<?= $fuel->total_amount ?>',
                                                        '<?= $fuel->kilometrage ?>',
                                                        '<?= $fuel->hour_meter ?>',
                                                        '<?= html_escape(
                                                                addslashes($fuel->operator_name ?: '')
                                                            ) ?>',
                                                        '<?= html_escape(
                                                                addslashes($fuel->supplier ?: '')
                                                            ) ?>',
                                                        '<?= html_escape(
                                                                addslashes($fuel->observation ?: '')
                                                            ) ?>'
                                                    )">

                                                    <i class="fas fa-eye"></i>

                                                </button>

                                            </td>

                                        </tr>

                                        <?php endforeach; ?>

                                        <?php else: ?>

                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">

                                                <i class="fas fa-gas-pump fa-2x mb-2 d-block"></i>

                                                Aucun ravitaillement enregistré.

                                            </td>
                                        </tr>

                                        <?php endif; ?>

                                    </tbody>

                                </table>

                            </div>

                            <div class="card-footer bg-white text-right">
                                <button class="btn btn-sm btn-outline-success">
                                    Voir tout l’historique
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>

                        </div>

                    </div>

                    <!-- Maintenance -->
                    <div class="col-xl-5 mb-4">

                        <div class="card mc-card h-100">

                            <div class="card-header d-flex justify-content-between align-items-center">

                                <div>
                                    <h5 class="mc-title">
                                        <i class="fas fa-tools text-warning mr-2"></i>
                                        Maintenances récentes
                                    </h5>
                                    <span class="mc-subtitle">
                                        Interventions préventives et correctives.
                                    </span>
                                </div>

                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                    data-target="#addMaintenanceModal">
                                    <i class="fas fa-plus mr-1"></i>
                                    Nouvelle
                                </button>

                            </div>

                            <div class="card-body p-0">

                                <div class="table-responsive">

                                    <table class="table table-hover mc-table mb-0">

                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Engin</th>
                                                <th>Intervention</th>
                                                <th class="text-right">Coût</th>
                                                <th>Statut</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php if (!empty($allMaintenances)): ?>

                                            <?php foreach ($allMaintenances as $maintenance): ?>

                                            <?php
                                                    $badgeClass = 'mc-badge-info';

                                                    switch ($maintenance->maintenance_status) {
                                                        case 'Terminé':
                                                            $badgeClass = 'mc-badge-success';
                                                            break;

                                                        case 'En cours':
                                                            $badgeClass = 'mc-badge-warning';
                                                            break;

                                                        case 'Annulé':
                                                            $badgeClass = 'mc-badge-danger';
                                                            break;

                                                        case 'Programmé':
                                                        default:
                                                            $badgeClass = 'mc-badge-info';
                                                            break;
                                                    }
                                                    ?>

                                            <tr>

                                                <td>
                                                    <?= !empty($maintenance->planned_date)
                                                                ? date(
                                                                    'd/m/Y',
                                                                    strtotime($maintenance->planned_date)
                                                                )
                                                                : '-'
                                                            ?>
                                                </td>

                                                <td>
                                                    <strong>
                                                        <?= html_escape(
                                                                    $maintenance->designation ?: '-'
                                                                ) ?>
                                                    </strong>

                                                    <br>

                                                    <small class="text-muted">
                                                        <?= html_escape(
                                                                    $maintenance->code_engin ?: '-'
                                                                ) ?>
                                                    </small>
                                                </td>

                                                <td>
                                                    <strong>
                                                        <?= html_escape(
                                                                    $maintenance->intervention ?: '-'
                                                                ) ?>
                                                    </strong>

                                                    <br>

                                                    <small class="text-muted">
                                                        <?= html_escape(
                                                                    $maintenance->maintenance_type ?: '-'
                                                                ) ?>
                                                    </small>
                                                </td>

                                                <td class="text-right font-weight-bold">
                                                    <?= number_format(
                                                                (float) $maintenance->total_cost,
                                                                0,
                                                                ',',
                                                                ' '
                                                            ) ?>
                                                </td>

                                                <td>

                                                    <span class="mc-badge <?= $badgeClass ?>">
                                                        <?= html_escape(
                                                                    $maintenance->maintenance_status
                                                                ) ?>
                                                    </span>

                                                    <?php if ((int) $maintenance->documents_count > 0): ?>

                                                    <div class="mt-1">

                                                        <small class="text-muted">

                                                            <i class="fas fa-paperclip mr-1"></i>

                                                            <?= (int) $maintenance->documents_count ?>

                                                            fichier<?= (int) $maintenance->documents_count > 1
                                                                                    ? 's'
                                                                                    : ''
                                                                                ?>

                                                        </small>

                                                    </div>

                                                    <?php endif; ?>

                                                </td>

                                                <td class="text-center">

                                                    <button type="button" class="btn btn-xs btn-info"
                                                        title="Voir la maintenance" onclick="viewMaintenance(
                                                                        <?= (int) $maintenance->id ?>
                                                                    )">

                                                        <i class="fas fa-eye"></i>

                                                    </button>

                                                    <button type="button" class="btn btn-xs btn-warning"
                                                        title="Modifier">

                                                        <i class="fas fa-edit"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                            <?php endforeach; ?>

                                            <?php else: ?>

                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted">

                                                    <i class="fas fa-tools fa-2x mb-2 d-block"></i>

                                                    Aucune maintenance enregistrée.

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

                <!-- Alertes et coût par engin -->
                <div class="row">

                    <!-- Alertes -->
                    <div class="col-lg-5 mb-4">

                        <div class="card mc-card h-100">

                            <div class="card-header">
                                <h5 class="mc-title">
                                    <i class="fas fa-bell text-warning mr-2"></i>
                                    Alertes et échéances
                                </h5>
                                <span class="mc-subtitle">
                                    Éléments nécessitant une attention rapide.
                                </span>
                            </div>

                            <div class="card-body">

                                <?php if (!empty($maintenanceAlerts)): ?>

                                <?php foreach ($maintenanceAlerts as $alert): ?>

                                <?php
                                        $daysRemaining = (int) $alert->days_remaining;

                                        $alertClass = 'mc-alert-info';
                                        $iconClass  = 'fas fa-calendar-alt';
                                        $title      = 'Maintenance programmée';

                                        if ($alert->maintenance_status === 'En cours') {
                                            $alertClass = 'mc-alert-warning';
                                            $iconClass  = 'fas fa-tools';
                                            $title      = 'Maintenance en cours';
                                        }

                                        if ($daysRemaining < 0) {
                                            $alertClass = 'mc-alert-danger';
                                            $iconClass  = 'fas fa-exclamation-triangle';
                                            $title      = 'Maintenance en retard';
                                        } elseif ($daysRemaining === 0) {
                                            $alertClass = 'mc-alert-danger';
                                            $iconClass  = 'fas fa-bell';
                                            $title      = 'Maintenance prévue aujourd’hui';
                                        } elseif ($daysRemaining <= 7) {
                                            $alertClass = 'mc-alert-warning';
                                            $iconClass  = 'fas fa-clock';
                                            $title      = 'Maintenance proche';
                                        }

                                        $maintenanceDate =
                                            !empty($alert->next_maintenance_date)
                                            ? $alert->next_maintenance_date
                                            : $alert->planned_date;
                                        ?>

                                <div class="mc-alert-item <?= $alertClass ?>">

                                    <div class="mc-alert-icon">
                                        <i class="<?= $iconClass ?>"></i>
                                    </div>

                                    <div class="flex-fill">

                                        <strong>
                                            <?= html_escape($title) ?>
                                        </strong>

                                        <p class="mb-1">

                                            <strong>
                                                <?= html_escape(
                                                            $alert->designation ?: 'Engin'
                                                        ) ?>
                                            </strong>

                                            <small class="text-muted">
                                                <?= html_escape(
                                                            $alert->code_engin ?: ''
                                                        ) ?>
                                            </small>

                                            :
                                            <?= html_escape(
                                                        $alert->intervention ?: $alert->maintenance_type
                                                    ) ?>.

                                        </p>

                                        <small class="text-muted">

                                            <i class="far fa-calendar-alt mr-1"></i>

                                            <?= !empty($maintenanceDate)
                                                        ? date(
                                                            'd/m/Y',
                                                            strtotime($maintenanceDate)
                                                        )
                                                        : '-'
                                                    ?>

                                            <?php if ($daysRemaining < 0): ?>

                                            <span class="text-danger font-weight-bold ml-1">
                                                Retard de
                                                <?= abs($daysRemaining) ?>
                                                jour<?= abs($daysRemaining) > 1 ? 's' : '' ?>
                                            </span>

                                            <?php elseif ($daysRemaining === 0): ?>

                                            <span class="text-danger font-weight-bold ml-1">
                                                Aujourd’hui
                                            </span>

                                            <?php else: ?>

                                            <span class="ml-1">
                                                Dans
                                                <?= $daysRemaining ?>
                                                jour<?= $daysRemaining > 1 ? 's' : '' ?>
                                            </span>

                                            <?php endif; ?>

                                        </small>

                                    </div>

                                </div>

                                <?php endforeach; ?>

                                <?php else: ?>

                                <div class="text-center text-muted py-4">

                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>

                                    <h6 class="font-weight-bold">
                                        Aucune alerte urgente
                                    </h6>

                                    <p class="mb-0">
                                        Aucune maintenance n’est prévue dans les 30 prochains jours.
                                    </p>

                                </div>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                    <!-- Engins les plus coûteux -->
                    <div class="col-lg-7 mb-4">

                        <div class="card mc-card h-100">

                            <div class="card-header">
                                <h5 class="mc-title">
                                    <i class="fas fa-chart-bar text-success mr-2"></i>
                                    Engins les plus coûteux ce mois
                                </h5>
                                <span class="mc-subtitle">
                                    Carburant et maintenance cumulés par équipement.
                                </span>
                            </div>

                            <div class="card-body">

                                <?php
                                $maximumCost = 0;

                                if (!empty($mostExpensiveEngins)) {
                                    $maximumCost = (float) $mostExpensiveEngins[0]->total_cost;
                                }

                                $progressClasses = [
                                    'bg-danger',
                                    'bg-warning',
                                    'bg-primary',
                                    'bg-success',
                                    'bg-info'
                                ];
                                ?>

                                <?php if (!empty($mostExpensiveEngins)): ?>

                                <?php foreach ($mostExpensiveEngins as $index => $enginCost): ?>

                                <?php
                                        $totalCost = (float) $enginCost->total_cost;

                                        $percentage = $maximumCost > 0
                                            ? ($totalCost / $maximumCost) * 100
                                            : 0;

                                        $percentage = min(
                                            100,
                                            max(5, $percentage)
                                        );

                                        $progressClass =
                                            $progressClasses[$index]
                                            ?? 'bg-secondary';
                                        ?>

                                <div class="mc-engin-line">

                                    <div class="mc-progress-label">

                                        <span>

                                            <strong>
                                                <?= html_escape(
                                                            $enginCost->designation ?: '-'
                                                        ) ?>
                                            </strong>

                                            <small class="text-muted ml-1">
                                                <?= html_escape(
                                                            $enginCost->code_engin ?: '-'
                                                        ) ?>
                                            </small>

                                        </span>

                                        <span class="mc-cost-value">
                                            <?= number_format(
                                                        $totalCost,
                                                        0,
                                                        ',',
                                                        ' '
                                                    ) ?>
                                            BIF
                                        </span>

                                    </div>

                                    <div class="progress">

                                        <div class="progress-bar <?= $progressClass ?>" role="progressbar"
                                            style="width: <?= round($percentage, 2) ?>%"
                                            aria-valuenow="<?= round($percentage) ?>" aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>

                                    </div>

                                    <div class="d-flex justify-content-between mt-1">

                                        <small class="text-muted">

                                            <i class="fas fa-gas-pump text-success mr-1"></i>

                                            Carburant :

                                            <?= number_format(
                                                        (float) $enginCost->fuel_cost,
                                                        0,
                                                        ',',
                                                        ' '
                                                    ) ?>
                                            BIF

                                        </small>

                                        <small class="text-muted">

                                            <i class="fas fa-tools text-warning mr-1"></i>

                                            Maintenance :

                                            <?= number_format(
                                                        (float) $enginCost->maintenance_cost,
                                                        0,
                                                        ',',
                                                        ' '
                                                    ) ?>
                                            BIF

                                        </small>

                                    </div>

                                </div>

                                <?php endforeach; ?>

                                <?php else: ?>

                                <div class="text-center text-muted py-4">

                                    <i class="fas fa-chart-bar fa-3x mb-3"></i>

                                    <h6 class="font-weight-bold">
                                        Aucune dépense enregistrée
                                    </h6>

                                    <p class="mb-0">
                                        Aucun coût de carburant ou de maintenance pour ce mois.
                                    </p>

                                </div>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Historique global -->
                <div class="card mc-card mb-4">

                    <div class="card-header">
                        <h5 class="mc-title">
                            <i class="fas fa-history text-success mr-2"></i>
                            Historique récent des opérations
                        </h5>
                        <span class="mc-subtitle">
                            Derniers ravitaillements, maintenances et pannes enregistrés.
                        </span>
                    </div>

                    <div class="card-body table-responsive p-0">

                        <table class="table table-hover mc-table mb-0">

                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Référence</th>
                                    <th>Engin / Matériel</th>
                                    <th>Opération</th>
                                    <th>Chantier</th>
                                    <th class="text-right">Montant</th>
                                    <th>Responsable</th>
                                    <th>Statut</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (!empty($recentOperations)): ?>

                                <?php foreach ($recentOperations as $operation): ?>

                                <?php
                                        /*
                |--------------------------------------------------------------------------
                | Badge du statut
                |--------------------------------------------------------------------------
                */

                                        $badgeClass = 'mc-badge-info';

                                        switch ($operation->operation_status) {

                                            case 'Validé':
                                            case 'Terminé':
                                                $badgeClass = 'mc-badge-success';
                                                break;

                                            case 'En cours':
                                            case 'Programmé':
                                                $badgeClass = 'mc-badge-warning';
                                                break;

                                            case 'Annulé':
                                            case 'Immobilisé':
                                                $badgeClass = 'mc-badge-danger';
                                                break;
                                        }

                                        /*
                |--------------------------------------------------------------------------
                | Icône de l’opération
                |--------------------------------------------------------------------------
                */

                                        $operationIcon = 'fas fa-tools text-warning';

                                        if ($operation->operation_source === 'fuel') {
                                            $operationIcon = 'fas fa-gas-pump text-success';
                                        }
                                        ?>

                                <tr>

                                    <!-- Date -->
                                    <td>
                                        <?= !empty($operation->operation_date)
                                                    ? date(
                                                        'd/m/Y',
                                                        strtotime($operation->operation_date)
                                                    )
                                                    : '-'
                                                ?>
                                    </td>

                                    <!-- Référence -->
                                    <td>
                                        <strong>
                                            <?= html_escape($operation->reference) ?>
                                        </strong>
                                    </td>

                                    <!-- Engin -->
                                    <td>

                                        <strong>
                                            <?= html_escape(
                                                        $operation->designation ?: 'Engin inconnu'
                                                    ) ?>
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            <?= html_escape(
                                                        $operation->code_engin ?: '-'
                                                    ) ?>
                                        </small>

                                    </td>

                                    <!-- Opération -->
                                    <td>

                                        <i class="<?= $operationIcon ?> mr-1"></i>

                                        <strong>
                                            <?= html_escape(
                                                        $operation->operation_name ?: '-'
                                                    ) ?>
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            <?= html_escape(
                                                        $operation->operation_type ?: '-'
                                                    ) ?>
                                        </small>

                                    </td>

                                    <!-- Chantier -->
                                    <td>
                                        <?= html_escape(
                                                    $operation->chantier_name ?: 'Aucun chantier'
                                                ) ?>
                                    </td>

                                    <!-- Montant -->
                                    <td class="text-right font-weight-bold">

                                        <?= number_format(
                                                    (float) $operation->amount,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) ?>

                                        BIF

                                    </td>

                                    <!-- Responsable -->
                                    <td>
                                        <?= !empty($operation->responsible)
                                                    ? html_escape($operation->responsible)
                                                    : '-'
                                                ?>
                                    </td>

                                    <!-- Statut -->
                                    <td>

                                        <span class="mc-badge <?= $badgeClass ?>">
                                            <?= html_escape(
                                                        $operation->operation_status ?: '-'
                                                    ) ?>
                                        </span>

                                        <?php if (
                                                    $operation->operation_source === 'maintenance'
                                                    && (int) $operation->documents_count > 0
                                                ): ?>

                                        <div class="mt-1">

                                            <small class="text-muted">

                                                <i class="fas fa-paperclip mr-1"></i>

                                                <?= (int) $operation->documents_count ?>

                                                fichier<?= (int) $operation->documents_count > 1
                                                                        ? 's'
                                                                        : ''
                                                                    ?>

                                            </small>

                                        </div>

                                        <?php endif; ?>

                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">

                                        <?php if ($operation->operation_source === 'fuel'): ?>

                                        <button type="button" class="btn btn-xs btn-info" title="Voir le ravitaillement"
                                            onclick="viewFuelOperation(
                                                            <?= (int) $operation->operation_id ?>
                                                        )">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                        <button type="button" class="btn btn-xs btn-warning"
                                            title="Modifier le ravitaillement" onclick="editFuelOperation(
                                                            <?= (int) $operation->operation_id ?>
                                                        )">

                                            <i class="fas fa-edit"></i>

                                        </button>

                                        <?php else: ?>

                                        <button type="button" class="btn btn-xs btn-info" title="Voir la maintenance"
                                            onclick="viewMaintenanceOperation(
                                                            <?= (int) $operation->operation_id ?>
                                                        )">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                        <button type="button" class="btn btn-xs btn-warning"
                                            title="Modifier la maintenance" onclick="editMaintenanceOperation(
                                                            <?= (int) $operation->operation_id ?>
                                                        )">

                                            <i class="fas fa-edit"></i>

                                        </button>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                                <?php endforeach; ?>

                                <?php else: ?>

                                <tr>

                                    <td colspan="9" class="text-center text-muted py-5">

                                        <i class="fas fa-history fa-3x mb-3 d-block"></i>

                                        <h6 class="font-weight-bold">
                                            Aucun historique disponible
                                        </h6>

                                        <p class="mb-0">
                                            Les ravitaillements et maintenances enregistrés
                                            apparaîtront ici.
                                        </p>

                                    </td>

                                </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="addFuelModal" tabindex="-1">
    <div class="modal-dialog modal-lg">

        <form action="<?= base_url('add-new-ravitaillement') ?>" method="post" id="fuelForm">

            <div class="modal-content" style="border-radius:18px; overflow:hidden;">

                <div class="modal-header mc-modal-header">

                    <h5 class="modal-title">
                        <i class="fas fa-gas-pump mr-2"></i>
                        Nouveau ravitaillement
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Engin / Matériel *</label>
                                <select name="engin_id" class="form-control" required>
                                    <option value="">Sélectionner un engin</option>
                                    <?php if (!empty($allEngins)): ?>
                                    <?php foreach ($allEngins as $engin): ?>
                                    <option value="<?= $engin->id ?>">
                                        <?= $engin->code_engin ?> -
                                        <?= $engin->designation ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Chantier</label>
                                <select name="chantier_id" class="form-control">
                                    <option value="">Aucun chantier</option>
                                    <?php if (!empty($chantiers)): ?>
                                    <?php foreach ($chantiers as $chantier): ?>
                                    <option value="<?= $chantier->id ?>">
                                        <?= $chantier->name ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date *</label>
                                <input type="date" name="operation_date" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Quantité en litres *</label>

                                <input type="number" name="quantity_litre" id="fuelQuantity" class="form-control"
                                    min="0" step="0.01" oninput="calculateFuelTotal()" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Prix par litre *</label>

                                <input type="number" name="unit_price" id="fuelUnitPrice" class="form-control" min="0"
                                    step="0.01" oninput="calculateFuelTotal()" required>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Montant total</label>

                                <input type="number" name="total_amount" id="fuelTotal" class="form-control" step="0.01"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kilométrage</label>
                                <input type="number" name="kilometrage" class="form-control" min="0">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Compteur horaire</label>
                                <input type="number" name="hour_meter" class="form-control" min="0" step="0.01">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Chauffeur / Opérateur</label>
                                <input type="text" name="operator_name" class="form-control"
                                    placeholder="Nom du chauffeur ou opérateur">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Station / Fournisseur</label>
                                <input type="text" name="supplier" class="form-control"
                                    placeholder="Nom du fournisseur">
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Observation</label>
                        <textarea name="observation" class="form-control" rows="3"
                            placeholder="Informations supplémentaires..."></textarea>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Annuler
                    </button>

                    <button type="submit" class="btn mc-btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Enregistrer
                    </button>

                </div>

            </div>

        </form>

    </div>
</div>

<div class="modal fade" id="addMaintenanceModal" tabindex="-1">
    <div class="modal-dialog modal-xl">

        <form action="<?= base_url('new-technique-maintenance') ?>" method="post" enctype="multipart/form-data">

            <div class="modal-content" style="border-radius:18px; overflow:hidden;">

                <div class="modal-header mc-modal-header-warning">

                    <h5 class="modal-title">
                        <i class="fas fa-tools mr-2"></i>
                        Nouvelle maintenance
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Engin / Matériel *</label>
                                <select name="engin_id" class="form-control" required>
                                    <option value="">Sélectionner un engin</option>
                                    <?php if (!empty($allEngins)): ?>
                                    <?php foreach ($allEngins as $engin): ?>
                                    <option value="<?= $engin->id ?>">
                                        <?= $engin->code_engin ?> -
                                        <?= $engin->designation ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Type de maintenance *</label>
                                <select name="maintenance_type" class="form-control" required>
                                    <option value="">Sélectionner</option>
                                    <option value="Préventive">Préventive</option>
                                    <option value="Corrective">Corrective</option>
                                    <option value="Inspection">Inspection</option>
                                    <option value="Révision générale">Révision générale</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nature de l’intervention *</label>
                                <input type="text" name="intervention" class="form-control"
                                    placeholder="Ex : Vidange moteur" required>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date prévue *</label>
                                <input type="date" name="planned_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date début</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date fin</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Statut *</label>
                                <select name="status" class="form-control" required>
                                    <option value="Programmé">Programmé</option>
                                    <option value="En cours">En cours</option>
                                    <option value="Terminé">Terminé</option>
                                    <option value="Annulé">Annulé</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Garage / Fournisseur</label>
                                <input type="text" name="supplier" class="form-control" placeholder="Nom du garage">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Technicien responsable</label>
                                <input type="text" name="technician" class="form-control"
                                    placeholder="Nom du technicien">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Chantier</label>
                                <select name="chantier_id" class="form-control">
                                    <option value="">Aucun chantier</option>
                                    <?php if (!empty($chantiers)): ?>
                                    <?php foreach ($chantiers as $chantier): ?>
                                    <option value="<?= $chantier->id ?>">
                                        <?= $chantier->name ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Coût des pièces</label>

                                <input type="number" name="parts_cost" id="partsCost" class="form-control" value="0"
                                    min="0" step="0.01" oninput="calculateMaintenanceTotal()">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Coût main-d’œuvre</label>

                                <input type="number" name="labor_cost" id="laborCost" class="form-control" value="0"
                                    min="0" step="0.01" oninput="calculateMaintenanceTotal()">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Coût total</label>

                                <input type="number" name="total_cost" id="maintenanceTotal" class="form-control"
                                    value="0" step="0.01" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prochaine maintenance</label>
                                <input type="date" name="next_maintenance_date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pièces jointes</label>

                                <input type="file" name="documents[]" id="maintenanceDocumentsInput"
                                    class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xls,.xlsx" multiple>

                                <div id="maintenanceDocumentsPreview" class="mt-3"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description des travaux</label>
                        <textarea name="description" class="form-control" rows="4"
                            placeholder="Description de la panne, pièces remplacées et travaux effectués..."></textarea>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="resetMaintenanceDocuments()">

                        <i class="fas fa-times mr-1"></i>
                        Annuler

                    </button>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i>
                        Enregistrer
                    </button>

                </div>

            </div>

        </form>

    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('maintenanceDocumentsInput');
    const preview = document.getElementById('maintenanceDocumentsPreview');

    if (!input || !preview) {
        console.error(
            'Champ ou zone d’aperçu de maintenance introuvable.', {
                input: input,
                preview: preview
            }
        );

        return;
    }

    input.addEventListener('change', function() {
        preview.innerHTML = '';

        const files = Array.from(input.files || []);

        if (files.length === 0) {
            preview.innerHTML = `
                <small class="text-muted">
                    Aucun fichier sélectionné.
                </small>
            `;

            return;
        }

        files.forEach(function(file) {
            const extension = file.name.includes('.') ?
                file.name.split('.').pop().toLowerCase() :
                '';

            const size = formatFileSize(file.size);

            if (['jpg', 'jpeg', 'png'].includes(extension)) {
                showImagePreview(file, size, preview);
            } else {
                showDocumentPreview(file, extension, size, preview);
            }
        });
    });
});

function showImagePreview(file, size, preview) {
    const reader = new FileReader();

    reader.onload = function(event) {
        const card = document.createElement('div');
        card.className = 'maintenance-image-preview';

        const image = document.createElement('img');
        image.src = event.target.result;
        image.alt = file.name;

        const name = document.createElement('div');
        name.className = 'maintenance-preview-name mt-1';
        name.textContent = file.name;
        name.title = file.name;

        const sizeElement = document.createElement('small');
        sizeElement.className = 'text-muted';
        sizeElement.textContent = size;

        card.appendChild(image);
        card.appendChild(name);
        card.appendChild(sizeElement);

        preview.appendChild(card);
    };

    reader.onerror = function() {
        console.error('Impossible de lire cette image :', file.name);
    };

    reader.readAsDataURL(file);
}

function showDocumentPreview(file, extension, size, preview) {
    let iconClass = 'fas fa-file text-secondary';

    if (extension === 'pdf') {
        iconClass = 'fas fa-file-pdf text-danger';
    } else if (['doc', 'docx'].includes(extension)) {
        iconClass = 'fas fa-file-word text-primary';
    } else if (['xls', 'xlsx'].includes(extension)) {
        iconClass = 'fas fa-file-excel text-success';
    }

    const card = document.createElement('div');
    card.className = 'maintenance-doc-preview';

    const iconBox = document.createElement('div');
    iconBox.className = 'maintenance-doc-icon';

    const icon = document.createElement('i');
    icon.className = iconClass;

    const content = document.createElement('div');
    content.className = 'flex-fill';
    content.style.minWidth = '0';

    const name = document.createElement('div');
    name.className = 'maintenance-preview-name';
    name.textContent = file.name;
    name.title = file.name;

    const sizeElement = document.createElement('small');
    sizeElement.className = 'text-muted';
    sizeElement.textContent = size;

    iconBox.appendChild(icon);

    content.appendChild(name);
    content.appendChild(sizeElement);

    card.appendChild(iconBox);
    card.appendChild(content);

    preview.appendChild(card);
}

function formatFileSize(bytes) {
    if (!bytes) {
        return '0 KB';
    }

    if (bytes < 1024 * 1024) {
        return (bytes / 1024).toFixed(1) + ' KB';
    }

    return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
}
</script>


<script>
function resetMaintenanceDocuments() {
    const input = document.getElementById('maintenanceDocumentsInput');
    const preview = document.getElementById('maintenanceDocumentsPreview');

    if (input) {
        input.value = '';
    }

    if (preview) {
        preview.innerHTML = '';
    }
}
</script>


<script>
$(document).on('hidden.bs.modal', '#addMaintenanceModal', function() {
    document.getElementById('maintenanceDocumentsInput').value = '';
    document.getElementById('maintenanceDocumentsPreview').innerHTML = '';
});
</script>

<script>
function calculateFuelTotal() {
    const quantityInput = document.getElementById('fuelQuantity');
    const priceInput = document.getElementById('fuelUnitPrice');
    const totalInput = document.getElementById('fuelTotal');

    if (!quantityInput || !priceInput || !totalInput) {
        console.error('Un des champs du calcul carburant est introuvable.');
        return;
    }

    const quantity = parseFloat(quantityInput.value) || 0;
    const unitPrice = parseFloat(priceInput.value) || 0;
    const total = quantity * unitPrice;

    totalInput.value = total.toFixed(2);
}
</script>

<script>
function calculateMaintenanceTotal() {
    const partsInput = document.getElementById('partsCost');
    const laborInput = document.getElementById('laborCost');
    const totalInput = document.getElementById('maintenanceTotal');

    if (!partsInput || !laborInput || !totalInput) {
        console.error('Un des champs de maintenance est introuvable.');
        return;
    }

    const partsCost = parseFloat(partsInput.value) || 0;
    const laborCost = parseFloat(laborInput.value) || 0;

    const total = partsCost + laborCost;

    totalInput.value = total.toFixed(2);
}
</script>

<script>
function viewFuelOperation(id) {
    console.log('Voir le ravitaillement :', id);

    Swal.fire({
        title: 'Ravitaillement',
        text: 'Ouverture du ravitaillement numéro ' + id,
        icon: 'info'
    });
}

function editFuelOperation(id) {
    console.log('Modifier le ravitaillement :', id);

    Swal.fire({
        title: 'Modification',
        text: 'Modification du ravitaillement numéro ' + id,
        icon: 'info'
    });
}

function viewMaintenanceOperation(id) {
    console.log('Voir la maintenance :', id);

    Swal.fire({
        title: 'Maintenance',
        text: 'Ouverture de la maintenance numéro ' + id,
        icon: 'info'
    });
}

function editMaintenanceOperation(id) {
    console.log('Modifier la maintenance :', id);

    Swal.fire({
        title: 'Modification',
        text: 'Modification de la maintenance numéro ' + id,
        icon: 'info'
    });
}
</script>