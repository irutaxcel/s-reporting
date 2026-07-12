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

                .preview-box {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 10px;
                }

                .preview-img-card {
                    width: 95px;
                    border: 1px solid #e5e7eb;
                    border-radius: 12px;
                    overflow: hidden;
                    background: #fff;
                    box-shadow: 0 4px 12px rgba(15, 23, 42, .08);
                }

                .preview-img-card img {
                    width: 100%;
                    height: 70px;
                    object-fit: cover;
                }

                .preview-img-card span {
                    display: block;
                    padding: 6px;
                    font-size: 11px;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .preview-doc-card {
                    width: 100%;
                    border: 1px solid #e5e7eb;
                    border-radius: 12px;
                    padding: 10px;
                    background: #f8fafc;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .preview-doc-card i {
                    font-size: 22px;
                    color: #0f766e;
                }

                .preview-doc-card span {
                    font-size: 13px;
                    font-weight: 600;
                    color: #334155;
                }

                .delete-file-btn {
                    position: absolute;
                    top: 4px;
                    right: 4px;
                    border-radius: 50%;
                    width: 22px;
                    height: 22px;
                    padding: 0;
                    font-size: 11px;
                    z-index: 5;
                }

                .preview-img-card {
                    position: relative;
                }

                .preview-new-img {
                    width: 90px;
                    height: 90px;
                    object-fit: cover;
                    border-radius: 10px;
                    border: 1px solid #ddd;
                    margin-right: 10px;
                    margin-bottom: 10px;
                }

                .preview-new-doc {
                    display: flex;
                    align-items: center;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    margin-bottom: 8px;
                    background: #f8f9fa;
                }

                .preview-new-doc i {
                    font-size: 22px;
                    margin-right: 10px;
                    color: #dc3545;
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

                                <?php if (!empty($allEngins)): ?>

                                    <?php foreach ($allEngins as $engin): ?>

                                        <?php
                                        if ($engin->etat == 'Disponible') {
                                            $badgeClass = 'badge-dispo';
                                            $progressClass = 'bg-success';
                                            $progress = 95;
                                        } elseif ($engin->etat == 'Sur chantier') {
                                            $badgeClass = 'badge-chantier';
                                            $progressClass = 'bg-primary';
                                            $progress = 75;
                                        } elseif ($engin->etat == 'Maintenance') {
                                            $badgeClass = 'badge-maintenance';
                                            $progressClass = 'bg-warning';
                                            $progress = 45;
                                        } else {
                                            $badgeClass = 'badge-panne';
                                            $progressClass = 'bg-danger';
                                            $progress = 25;
                                        }

                                        $photo = !empty($engin->photo_principale)
                                            ? base_url('uploads/engins/photos/' . $engin->photo_principale)
                                            : base_url('assets/v1/dist/img/no-image.png');
                                        ?>

                                        <div class="materiel-item mb-3">
                                            <div class="d-flex align-items-center">

                                                <img src="<?= $photo ?>" class="mr-3"
                                                    style="width:75px;height:75px;object-fit:cover;border-radius:15px;border:1px solid #e5e7eb;">

                                                <div class="flex-fill">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-1 font-weight-bold">
                                                            <?= $engin->designation ?>
                                                        </h6>

                                                        <!-- <span class="badge-state <?= $badgeClass ?>">
                                                    <?= $engin->etat ?>
                                                </span> -->
                                                    </div>

                                                    <small class="text-muted">
                                                        Code : <?= $engin->code_engin ?>
                                                        | Catégorie : <?= $engin->nom_categorie ?? '-' ?>
                                                        | Marque : <?= $engin->marque ?? '-' ?>
                                                        | Plaque : <?= $engin->plaque ?? '-' ?>
                                                        | Chantier :
                                                        <?= $engin->chantier_name ?: ($engin->localisation ?: '-') ?>
                                                    </small>

                                                    <div class="progress mt-2">
                                                        <div class="progress-bar <?= $progressClass ?>"
                                                            style="width: <?= $progress ?>%"></div>
                                                    </div>


                                                </div>

                                                <div class="d-flex align-items-center">
                                                    <span class="badge-state <?= $badgeClass ?> mr-2">
                                                        <?= $engin->etat ?>
                                                    </span>

                                                    <button type="button" class="btn btn-sm btn-warning mr-1" onclick="editEngin(
                                                        '<?= $engin->id ?>',
                                                        '<?= addslashes($engin->code_engin) ?>',
                                                        '<?= addslashes($engin->designation) ?>',
                                                        '<?= $engin->categorie_id ?>',
                                                        '<?= addslashes($engin->marque) ?>',
                                                        '<?= addslashes($engin->modele) ?>',
                                                        '<?= addslashes($engin->plaque) ?>',
                                                        '<?= addslashes($engin->numero_serie) ?>',
                                                        '<?= $engin->date_acquisition ?>',
                                                        '<?= $engin->valeur_achat ?>',
                                                        '<?= $engin->etat ?>',
                                                        '<?= addslashes($engin->localisation) ?>',
                                                        '<?= $engin->chantier_id ?>',
                                                        '<?= addslashes($engin->observation) ?>'
                                                    )">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="deleteEngin('<?= $engin->id ?>')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>

                                            </div>



                                        </div>



                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <div class="alert alert-info mb-0">
                                        Aucun engin enregistré pour le moment.
                                    </div>

                                <?php endif; ?>

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
                <!-- <div class="card engin-card mb-4">
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
                </div> -->

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
                                    value="<?= $codeEngin ?>" readonly required>
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
                                <select name="categorie_id" class="form-control" required>
                                    <option value="">Sélectionner une catégorie</option>

                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat->id ?>">
                                            <?= $cat->nom_categorie ?>
                                        </option>
                                    <?php endforeach; ?>
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
                                    <?php foreach ($chantiers as $chantier): ?>
                                        <option value="<?= $chantier->id ?>"><?= $chantier->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Photo de l’engin</label>
                                <input type="file" name="photos[]" id="photosInput" class="form-control"
                                    accept="image/*" multiple>

                                <small class="text-muted">
                                    Vous pouvez sélectionner plusieurs images.
                                </small>

                                <div id="photosPreview" class="preview-box mt-3"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Document / Carte grise</label>
                                <input type="file" name="documents[]" id="documentsInput" class="form-control"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" multiple>

                                <small class="text-muted">
                                    Carte grise, assurance, contrôle technique, facture, etc.
                                </small>

                                <div id="documentsPreview" class="preview-box mt-3"></div>
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

<!-- MODAL MODIFICATION ENGIN -->
<div class="modal fade" id="editEnginModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form action="<?= base_url('engin-materiel-update') ?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id" id="edit_id">

            <div class="modal-content" style="border-radius:18px; overflow:hidden;">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier un engin / matériel
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Code engin</label>
                                <input type="text" name="code_engin" id="edit_code_engin" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Désignation *</label>
                                <input type="text" name="designation" id="edit_designation" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Catégorie *</label>
                                <select name="categorie_id" id="edit_categorie_id" class="form-control" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat->id ?>"><?= $cat->nom_categorie ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <label>Marque</label>
                            <input type="text" name="marque" id="edit_marque" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Modèle</label>
                            <input type="text" name="modele" id="edit_modele" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Numéro de plaque</label>
                            <input type="text" name="plaque" id="edit_plaque" class="form-control">
                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label>Numéro de série</label>
                            <input type="text" name="numero_serie" id="edit_numero_serie" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Date d’acquisition</label>
                            <input type="date" name="date_acquisition" id="edit_date_acquisition" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Valeur d’achat</label>
                            <input type="number" name="valeur_achat" id="edit_valeur_achat" class="form-control">
                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label>État actuel *</label>
                            <select name="etat" id="edit_etat" class="form-control" required>
                                <option value="Disponible">Disponible</option>
                                <option value="Sur chantier">Sur chantier</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="En panne">En panne</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Localisation</label>
                            <input type="text" name="localisation" id="edit_localisation" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Chantier affecté</label>
                            <select name="chantier_id" id="edit_chantier_id" class="form-control">
                                <option value="">Aucun chantier</option>
                                <?php foreach ($chantiers as $chantier): ?>
                                    <option value="<?= $chantier->id ?>"><?= $chantier->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div class="form-group mt-3">
                        <label>Observation</label>
                        <textarea name="observation" id="edit_observation" class="form-control" rows="3"></textarea>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Photos existantes</h6>
                            <div id="editPhotosPreview" class="preview-box mb-3"></div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Documents existants</h6>
                            <div id="editDocumentsPreview" class="preview-box mb-3"></div>
                        </div>
                    </div>




                    <div class="row">

                        <div class="col-md-6">
                            <label>Ajouter d’autres photos</label>

                            <input type="file" name="photos[]" id="editPhotosInput" class="form-control"
                                accept="image/*" multiple>

                            <!-- aperçu -->
                            <div id="editNewPhotosPreview" class="mt-3"></div>
                        </div>

                        <div class="col-md-6">
                            <label>Ajouter d’autres documents</label>

                            <input type="file" name="documents[]" id="editDocumentsInput" class="form-control"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" multiple>

                            <!-- aperçu -->
                            <div id="editNewDocumentsPreview" class="mt-3"></div>
                        </div>

                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i>
                        Modifier
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>




<script>
    document.getElementById('photosInput').addEventListener('change', function() {
        let preview = document.getElementById('photosPreview');
        preview.innerHTML = '';

        Array.from(this.files).forEach(function(file) {
            let reader = new FileReader();

            reader.onload = function(e) {
                preview.innerHTML += `
                <div class="preview-img-card">
                    <img src="${e.target.result}" alt="photo">
                    <span>${file.name}</span>
                </div>
            `;
            };

            reader.readAsDataURL(file);
        });
    });

    document.getElementById('documentsInput').addEventListener('change', function() {
        let preview = document.getElementById('documentsPreview');
        preview.innerHTML = '';

        Array.from(this.files).forEach(function(file) {
            let icon = 'fas fa-file';

            if (file.name.match(/\.pdf$/i)) {
                icon = 'fas fa-file-pdf';
            } else if (file.name.match(/\.(doc|docx)$/i)) {
                icon = 'fas fa-file-word';
            } else if (file.name.match(/\.(xls|xlsx)$/i)) {
                icon = 'fas fa-file-excel';
            } else if (file.name.match(/\.(jpg|jpeg|png)$/i)) {
                icon = 'fas fa-file-image';
            }

            preview.innerHTML += `
            <div class="preview-doc-card">
                <i class="${icon}"></i>
                <span>${file.name}</span>
            </div>
        `;
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteEngin(id) {
        Swal.fire({
            title: 'Supprimer cet engin ?',
            text: 'Cette action va retirer l’engin de la liste.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= base_url('engin-materiel-delete') ?>", {
                    id: id
                }, function() {
                    Swal.fire('Supprimé', 'Engin supprimé avec succès.', 'success')
                        .then(() => location.reload());
                });
            }
        });
    }
</script>

<script>
    function editEngin(
        id,
        code_engin,
        designation,
        categorie_id,
        marque,
        modele,
        plaque,
        numero_serie,
        date_acquisition,
        valeur_achat,
        etat,
        localisation,
        chantier_id,
        observation
    ) {
        $('#edit_id').val(id);
        $('#edit_code_engin').val(code_engin);
        $('#edit_designation').val(designation);
        $('#edit_categorie_id').val(categorie_id);
        $('#edit_marque').val(marque);
        $('#edit_modele').val(modele);
        $('#edit_plaque').val(plaque);
        $('#edit_numero_serie').val(numero_serie);
        $('#edit_date_acquisition').val(date_acquisition);
        $('#edit_valeur_achat').val(valeur_achat);
        $('#edit_etat').val(etat);
        $('#edit_localisation').val(localisation);
        $('#edit_chantier_id').val(chantier_id);
        $('#edit_observation').val(observation);

        $('#editPhotosPreview').html('');
        $('#editDocumentsPreview').html('');

        $('#editPhotosInput').val('');
        $('#editDocumentsInput').val('');
        $('#editNewPhotosPreview').html('');
        $('#editNewDocumentsPreview').html('');

        $.post("<?= base_url('engin-materiel-files') ?>", {
            engin_id: id
        }, function(response) {

            let data = JSON.parse(response);

            if (data.photos.length > 0) {
                data.photos.forEach(function(item) {
                    $('#editPhotosPreview').append(`
                        <div class="preview-img-card" id="photo-${item.id}">
                            <button type="button"
                                    class="btn btn-danger btn-xs delete-file-btn"
                                    onclick="deletePhoto(${item.id})">
                                <i class="fas fa-times"></i>
                            </button>

                            <img src="<?= base_url('uploads/engins/photos/') ?>${item.photo}">
                            <span>${item.photo}</span>
                        </div>
                    `);
                });
            } else {
                $('#editPhotosPreview').html('<small class="text-muted">Aucune photo disponible.</small>');
            }

            if (data.documents.length > 0) {
                data.documents.forEach(function(item) {
                    $('#editDocumentsPreview').append(`
                        <div class="preview-doc-card" id="document-${item.id}">
                            <i class="fas fa-file-pdf"></i>
                            <span class="flex-fill">${item.document}</span>

                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    onclick="deleteDocument(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `);
                });
            } else {
                $('#editDocumentsPreview').html('<small class="text-muted">Aucun document disponible.</small>');
            }

        });



        $('#editEnginModal').modal('show');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function deletePhoto(id) {
        Swal.fire({
            title: 'Supprimer cette image ?',
            text: 'Cette image sera supprimée définitivement.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= base_url('engin-photo-delete') ?>", {
                    id: id
                }, function() {
                    $('#photo-' + id).remove();
                    Swal.fire('Supprimée', 'Image supprimée avec succès.', 'success');
                });
            }
        });
    }

    function deleteDocument(id) {
        Swal.fire({
            title: 'Supprimer ce document ?',
            text: 'Ce document sera supprimé définitivement.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= base_url('engin-document-delete') ?>", {
                    id: id
                }, function() {
                    $('#document-' + id).remove();
                    Swal.fire('Supprimé', 'Document supprimé avec succès.', 'success');
                });
            }
        });
    }
</script>


<script>
    $(document).ready(function() {

        $(document).on('change', '#editPhotosInput', function() {

            let preview = $('#editNewPhotosPreview');
            preview.html('');

            Array.from(this.files).forEach(function(file) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    preview.append(`
                    <div class="preview-img-card">
                        <img src="${e.target.result}" alt="photo">
                        <span>${file.name}</span>
                    </div>
                `);
                };

                reader.readAsDataURL(file);
            });
        });

        $(document).on('change', '#editDocumentsInput', function() {

            let preview = $('#editNewDocumentsPreview');
            preview.html('');

            Array.from(this.files).forEach(function(file) {
                let icon = 'fas fa-file';

                if (file.name.match(/\.pdf$/i)) {
                    icon = 'fas fa-file-pdf';
                } else if (file.name.match(/\.(doc|docx)$/i)) {
                    icon = 'fas fa-file-word';
                } else if (file.name.match(/\.(xls|xlsx)$/i)) {
                    icon = 'fas fa-file-excel';
                } else if (file.name.match(/\.(jpg|jpeg|png)$/i)) {
                    icon = 'fas fa-file-image';
                }

                preview.append(`
                <div class="preview-doc-card">
                    <i class="${icon}"></i>
                    <span>${file.name}</span>
                </div>
            `);
            });
        });

    });
</script>