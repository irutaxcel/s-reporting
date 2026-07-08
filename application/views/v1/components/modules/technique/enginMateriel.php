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

            <!-- le contenu de la page ici  -->

            <style>
            .engin-page {
                font-family: "Segoe UI", sans-serif;
            }

            .stat-card {
                border: 0;
                border-radius: 18px;
                color: #fff;
                overflow: hidden;
                position: relative;
                box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            }

            .stat-card .icon-bg {
                position: absolute;
                right: 18px;
                bottom: 10px;
                font-size: 55px;
                opacity: .18;
            }

            .stat-card h3 {
                font-weight: 800;
                margin-bottom: 2px;
            }

            .stat-card p {
                margin: 0;
                font-size: 13px;
                opacity: .9;
            }

            .bg-grad-green {
                background: linear-gradient(135deg, #0f766e, #22c55e);
            }

            .bg-grad-blue {
                background: linear-gradient(135deg, #0f172a, #2563eb);
            }

            .bg-grad-orange {
                background: linear-gradient(135deg, #92400e, #f59e0b);
            }

            .bg-grad-red {
                background: linear-gradient(135deg, #7f1d1d, #ef4444);
            }

            .engin-card {
                border: 0;
                border-radius: 18px;
                box-shadow: 0 10px 25px rgba(15, 23, 42, .08);
                overflow: hidden;
            }

            .engin-card .card-header {
                background: #fff;
                border-bottom: 1px solid #eef2f7;
                padding: 18px 22px;
            }

            .engin-title {
                font-weight: 800;
                color: #0f172a;
                margin-bottom: 0;
            }

            .engin-subtitle {
                color: #64748b;
                font-size: 13px;
            }

            .btn-satraco {
                background: linear-gradient(135deg, #0f766e, #22c55e);
                color: #fff;
                border: 0;
                border-radius: 10px;
                font-weight: 600;
                box-shadow: 0 8px 18px rgba(34, 197, 94, .25);
            }

            .btn-satraco:hover {
                color: #fff;
                opacity: .92;
            }

            .filter-box {
                background: #f8fafc;
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                padding: 16px;
            }

            .materiel-item {
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                padding: 15px;
                background: #fff;
                transition: .2s;
            }

            .materiel-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 22px rgba(0, 0, 0, .08);
            }

            .materiel-icon {
                width: 55px;
                height: 55px;
                border-radius: 15px;
                background: #ecfdf5;
                color: #0f766e;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 25px;
            }

            .badge-state {
                border-radius: 50px;
                padding: 6px 12px;
                font-size: 11px;
                font-weight: 700;
            }

            .badge-dispo {
                background: #dcfce7;
                color: #166534;
            }

            .badge-chantier {
                background: #dbeafe;
                color: #1d4ed8;
            }

            .badge-maintenance {
                background: #fef3c7;
                color: #92400e;
            }

            .badge-panne {
                background: #fee2e2;
                color: #991b1b;
            }

            .table thead th {
                background: #f8fafc;
                border-bottom: 1px solid #e5e7eb;
                color: #334155;
                font-size: 12px;
                text-transform: uppercase;
            }

            .progress {
                height: 8px;
                border-radius: 30px;
            }

            .quick-action {
                border: 1px dashed #cbd5e1;
                border-radius: 16px;
                padding: 16px;
                background: #f8fafc;
                text-align: center;
                transition: .2s;
                cursor: pointer;
            }

            .quick-action:hover {
                background: #ecfdf5;
                border-color: #0f766e;
            }

            .quick-action i {
                font-size: 24px;
                color: #0f766e;
                margin-bottom: 8px;
            }
            </style>

            <div class="engin-page">

                <!-- STATISTIQUES -->
                <div class="row mb-4">

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card bg-grad-green">
                            <div class="card-body">
                                <h3>48</h3>
                                <p>Engins & matériels enregistrés</p>
                                <i class="fas fa-truck-monster icon-bg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card bg-grad-blue">
                            <div class="card-body">
                                <h3>31</h3>
                                <p>Actuellement sur chantier</p>
                                <i class="fas fa-hard-hat icon-bg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card bg-grad-orange">
                            <div class="card-body">
                                <h3>9</h3>
                                <p>En maintenance préventive</p>
                                <i class="fas fa-tools icon-bg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card stat-card bg-grad-red">
                            <div class="card-body">
                                <h3>3</h3>
                                <p>Pannes signalées</p>
                                <i class="fas fa-exclamation-triangle icon-bg"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ACTIONS RAPIDES -->
                <div class="row mb-4">

                    <div class="col-md-3 mb-3">
                        <div class="quick-action" data-toggle="modal" data-target="#addEnginModal">
                            <i class="fas fa-plus-circle"></i>
                            <h6>Ajouter un engin</h6>
                            <small>Nouvel équipement</small>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="quick-action">
                            <i class="fas fa-exchange-alt"></i>
                            <h6>Affecter à un chantier</h6>
                            <small>Sortie ou transfert</small>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="quick-action">
                            <i class="fas fa-gas-pump"></i>
                            <h6>Carburant</h6>
                            <small>Consommation engin</small>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="quick-action">
                            <i class="fas fa-wrench"></i>
                            <h6>Maintenance</h6>
                            <small>Réparation / entretien</small>
                        </div>
                    </div>

                </div>

                <!-- FILTRE -->
                <div class="card engin-card mb-4">
                    <div class="card-header">
                        <h5 class="engin-title">
                            <i class="fas fa-filter mr-2 text-success"></i>
                            Filtrage des engins
                        </h5>
                        <span class="engin-subtitle">Rechercher rapidement un engin, un matériel ou une
                            affectation.</span>
                    </div>

                    <div class="card-body">
                        <div class="filter-box">
                            <div class="row">

                                <div class="col-md-3 mb-2">
                                    <label>Recherche</label>
                                    <input type="text" class="form-control" placeholder="Code, nom, plaque...">
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label>Catégorie</label>
                                    <select class="form-control">
                                        <option>Toutes les catégories</option>
                                        <option>Engin lourd</option>
                                        <option>Camion</option>
                                        <option>Matériel léger</option>
                                        <option>Outillage</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label>État</label>
                                    <select class="form-control">
                                        <option>Tous les états</option>
                                        <option>Disponible</option>
                                        <option>Sur chantier</option>
                                        <option>Maintenance</option>
                                        <option>En panne</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label>Chantier</label>
                                    <select class="form-control">
                                        <option>Tous les chantiers</option>
                                        <option>Chantier Gitega</option>
                                        <option>Chantier Rumonge</option>
                                        <option>Chantier Ngozi</option>
                                    </select>
                                </div>

                            </div>

                            <div class="text-right mt-3">
                                <button class="btn btn-secondary">
                                    <i class="fas fa-redo mr-1"></i> Réinitialiser
                                </button>

                                <button class="btn btn-satraco">
                                    <i class="fas fa-search mr-1"></i> Rechercher
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTENU PRINCIPAL -->
                <div class="row">

                    <!-- LISTE DES ENGINS -->
                    <div class="col-lg-8 mb-4">
                        <div class="card engin-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="engin-title">
                                        <i class="fas fa-truck-loading mr-2 text-success"></i>
                                        Parc engins & matériels
                                    </h5>
                                    <span class="engin-subtitle">Vue globale des équipements disponibles et
                                        affectés.</span>
                                </div>

                                <button type="button" class="btn btn-satraco btn-sm" data-toggle="modal"
                                    data-target="#addEnginModal">
                                    <i class="fas fa-plus mr-1"></i> Nouveau
                                </button>
                            </div>

                            <div class="card-body">

                                <div class="materiel-item mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="materiel-icon mr-3">
                                            <i class="fas fa-truck"></i>
                                        </div>

                                        <div class="flex-fill">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1 font-weight-bold">Camion Benne Mercedes Actros</h6>
                                                <span class="badge-state badge-chantier">Sur chantier</span>
                                            </div>

                                            <small class="text-muted">
                                                Code : ENG-001 | Plaque : BA 4587 | Chantier : Gitega
                                            </small>

                                            <div class="progress mt-2">
                                                <div class="progress-bar bg-success" style="width: 78%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="materiel-item mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="materiel-icon mr-3">
                                            <i class="fas fa-tractor"></i>
                                        </div>

                                        <div class="flex-fill">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1 font-weight-bold">Bulldozer Caterpillar D6</h6>
                                                <span class="badge-state badge-dispo">Disponible</span>
                                            </div>

                                            <small class="text-muted">
                                                Code : ENG-002 | Localisation : Dépôt central | Dernier entretien :
                                                05/07/2026
                                            </small>

                                            <div class="progress mt-2">
                                                <div class="progress-bar bg-primary" style="width: 92%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="materiel-item mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="materiel-icon mr-3">
                                            <i class="fas fa-tools"></i>
                                        </div>

                                        <div class="flex-fill">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1 font-weight-bold">Groupe électrogène 50 KVA</h6>
                                                <span class="badge-state badge-maintenance">Maintenance</span>
                                            </div>

                                            <small class="text-muted">
                                                Code : MAT-011 | Intervention : Vidange + filtre | Responsable : Atelier
                                            </small>

                                            <div class="progress mt-2">
                                                <div class="progress-bar bg-warning" style="width: 55%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="materiel-item">
                                    <div class="d-flex align-items-center">
                                        <div class="materiel-icon mr-3">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>

                                        <div class="flex-fill">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1 font-weight-bold">Bétonnière électrique 350L</h6>
                                                <span class="badge-state badge-panne">En panne</span>
                                            </div>

                                            <small class="text-muted">
                                                Code : MAT-021 | Problème : moteur bloqué | Signalé le : 08/07/2026
                                            </small>

                                            <div class="progress mt-2">
                                                <div class="progress-bar bg-danger" style="width: 28%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RESUME LATERAL -->
                    <div class="col-lg-4 mb-4">

                        <div class="card engin-card mb-4">
                            <div class="card-header">
                                <h5 class="engin-title">
                                    <i class="fas fa-chart-pie mr-2 text-success"></i>
                                    Répartition par état
                                </h5>
                            </div>

                            <div class="card-body">

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Disponible</span>
                                        <strong>32%</strong>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width:32%"></div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Sur chantier</span>
                                        <strong>54%</strong>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" style="width:54%"></div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Maintenance</span>
                                        <strong>10%</strong>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width:10%"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>En panne</span>
                                        <strong>4%</strong>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" style="width:4%"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card engin-card">
                            <div class="card-header">
                                <h5 class="engin-title">
                                    <i class="fas fa-bell mr-2 text-warning"></i>
                                    Alertes récentes
                                </h5>
                            </div>

                            <div class="card-body">

                                <div class="alert alert-warning">
                                    <strong>Maintenance proche</strong><br>
                                    Le camion ENG-001 doit passer à l’entretien dans 3 jours.
                                </div>

                                <div class="alert alert-danger">
                                    <strong>Panne signalée</strong><br>
                                    Bétonnière MAT-021 indisponible depuis aujourd’hui.
                                </div>

                                <div class="alert alert-info">
                                    <strong>Affectation</strong><br>
                                    Le bulldozer ENG-002 est disponible au dépôt central.
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- TABLEAU HISTORIQUE -->
                <div class="card engin-card mb-4">
                    <div class="card-header">
                        <h5 class="engin-title">
                            <i class="fas fa-history mr-2 text-success"></i>
                            Dernières affectations et mouvements
                        </h5>
                        <span class="engin-subtitle">Historique récent des sorties, retours et maintenances.</span>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Engin / Matériel</th>
                                    <th>Type mouvement</th>
                                    <th>Chantier</th>
                                    <th>Responsable</th>
                                    <th>Statut</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>08/07/2026</td>
                                    <td>Camion Benne Mercedes</td>
                                    <td>Sortie chantier</td>
                                    <td>Gitega</td>
                                    <td>Chef chantier</td>
                                    <td><span class="badge-state badge-chantier">En cours</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>07/07/2026</td>
                                    <td>Groupe électrogène 50 KVA</td>
                                    <td>Maintenance</td>
                                    <td>Atelier</td>
                                    <td>Technicien</td>
                                    <td><span class="badge-state badge-maintenance">Maintenance</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>06/07/2026</td>
                                    <td>Bulldozer Caterpillar</td>
                                    <td>Retour dépôt</td>
                                    <td>Dépôt central</td>
                                    <td>Logistique</td>
                                    <td><span class="badge-state badge-dispo">Disponible</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
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

<!-- MODAL AJOUT ENGIN / MATERIEL -->
<div class="modal fade" id="addEnginModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form action="<?= base_url('engin-materiel-store') ?>" method="post" enctype="multipart/form-data">

            <div class="modal-content" style="border-radius:18px; overflow:hidden;">

                <div class="modal-header text-white" style="background:linear-gradient(135deg,#0f766e,#22c55e);">
                    <h5 class="modal-title">
                        <i class="fas fa-truck-monster mr-2"></i>
                        Enregistrement d’un engin / matériel
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Code engin *</label>
                                <input type="text" name="code_engin" class="form-control" placeholder="Ex : ENG-001"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Désignation *</label>
                                <input type="text" name="designation" class="form-control"
                                    placeholder="Ex : Camion benne" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Catégorie *</label>
                                <select name="categorie" class="form-control" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Engin lourd">Engin lourd</option>
                                    <option value="Camion">Camion</option>
                                    <option value="Matériel léger">Matériel léger</option>
                                    <option value="Outillage">Outillage</option>
                                    <option value="Véhicule">Véhicule</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Marque</label>
                                <input type="text" name="marque" class="form-control" placeholder="Ex : Caterpillar">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Modèle</label>
                                <input type="text" name="modele" class="form-control" placeholder="Ex : D6">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Numéro de plaque</label>
                                <input type="text" name="plaque" class="form-control" placeholder="Ex : BA 4587">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Numéro de série</label>
                                <input type="text" name="numero_serie" class="form-control"
                                    placeholder="Ex : CATD6-2026-001">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date d’acquisition</label>
                                <input type="date" name="date_acquisition" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Valeur d’achat</label>
                                <input type="number" name="valeur_achat" class="form-control"
                                    placeholder="Ex : 25000000">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>État actuel *</label>
                                <select name="etat" class="form-control" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="Sur chantier">Sur chantier</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="En panne">En panne</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Localisation</label>
                                <input type="text" name="localisation" class="form-control"
                                    placeholder="Ex : Dépôt central">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Chantier affecté</label>
                                <select name="chantier_id" class="form-control">
                                    <option value="">Aucun chantier</option>
                                    <option value="1">Chantier Gitega</option>
                                    <option value="2">Chantier Rumonge</option>
                                    <option value="3">Chantier Ngozi</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Photo de l’engin</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Document / Carte grise</label>
                                <input type="file" name="document" class="form-control"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Observation</label>
                        <textarea name="observation" class="form-control" rows="3"
                            placeholder="Observation ou description de l’état de l’engin..."></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-satraco">
                        <i class="fas fa-save mr-1"></i>
                        Enregistrer
                    </button>
                </div>

            </div>

        </form>
    </div>
</div>