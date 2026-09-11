<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-project-diagram text-primary"></i> Projets CRM
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">CRM & Clients</a></li>
                        <li class="breadcrumb-item active">Projets</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1">
                            <i class="fas fa-folder"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Projets</span>
                            <span class="info-box-number">47</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-hard-hat"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">En Cours</span>
                            <span class="info-box-number">28</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1">
                            <i class="fas fa-clock"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Planifiés</span>
                            <span class="info-box-number">12</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Terminés</span>
                            <span class="info-box-number">7</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Main Projects Card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Liste des Projets
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#modalAssignContract">
                            <i class="fas fa-file-contract"></i> Associer Contrat
                        </button>
                        <button type="button" class="btn btn-default btn-sm ml-2">
                            <i class="fas fa-download"></i> Exporter
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <!-- Filters and Search -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Rechercher un projet...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2">
                                <option value="">Tous les statuts</option>
                                <option value="planification">Planification</option>
                                <option value="en_cours">En Cours</option>
                                <option value="termine">Terminé</option>
                                <option value="suspendu">Suspendu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2">
                                <option value="">Toutes les institutions</option>
                                <option value="1">Ministère de l'Éducation</option>
                                <option value="2">Wilaya d'Alger</option>
                                <option value="3">Ministère de la Santé</option>
                                <option value="4">SARL ImmoPlus</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2">
                                <option value="">Toutes catégories</option>
                                <option value="A">Catégorie A</option>
                                <option value="B">Catégorie B</option>
                                <option value="C">Catégorie C</option>
                            </select>
                        </div>
                    </div>

                    <!-- Projects Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" class="checkbox-toggle">
                                    </th>
                                    <th>Code</th>
                                    <th>Nom du Projet</th>
                                    <th>Institution / Client</th>
                                    <th>Montant Total</th>
                                    <th>Chantiers</th>
                                    <th>% Avancement</th>
                                    <th>% Décaissé</th>
                                    <th width="120">Statut</th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Projet 1 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong>PROJ-2026-001</strong></td>
                                    <td>
                                        <strong>Construction Université Oran</strong><br>
                                        <small class="text-muted">Début: 01/09/2026</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-building text-primary"></i>
                                        Ministère de l'Éducation
                                    </td>
                                    <td>
                                        <strong>10,000,000 DA</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-hard-hat"></i> 3 chantiers
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 45%"></div>
                                        </div>
                                        <small>45%</small>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-warning" style="width: 30%"></div>
                                        </div>
                                        <small>30%</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-sync fa-spin"></i> En cours
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                data-toggle="modal" data-target="#modalProjectDetails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" title="Ajouter chantier"
                                                data-toggle="modal" data-target="#modalAddSite">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" title="Contrat">
                                                <i class="fas fa-file-contract"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Projet 2 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong>PROJ-2026-002</strong></td>
                                    <td>
                                        <strong>Hôpital Régional Annaba</strong><br>
                                        <small class="text-muted">Début: 15/08/2026</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-landmark text-primary"></i>
                                        Wilaya d'Annaba
                                    </td>
                                    <td>
                                        <strong>15,500,000 DA</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-hard-hat"></i> 5 chantiers
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 60%"></div>
                                        </div>
                                        <small>60%</small>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" style="width: 55%"></div>
                                        </div>
                                        <small>55%</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-sync fa-spin"></i> En cours
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                data-toggle="modal" data-target="#modalProjectDetails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" title="Ajouter chantier"
                                                data-toggle="modal" data-target="#modalAddSite">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" title="Contrat">
                                                <i class="fas fa-file-contract"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Projet 3 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong>PROJ-2026-003</strong></td>
                                    <td>
                                        <strong>Complexe Sportif Constantine</strong><br>
                                        <small class="text-muted">Début: 01/10/2026</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-building text-primary"></i>
                                        Ministère des Sports
                                    </td>
                                    <td>
                                        <strong>8,200,000 DA</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-hard-hat"></i> 0 chantier
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                        <small>0%</small>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                        <small>0%</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Planification
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                data-toggle="modal" data-target="#modalProjectDetails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" title="Ajouter chantier"
                                                data-toggle="modal" data-target="#modalAddSite">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" title="Associer contrat"
                                                data-toggle="modal" data-target="#modalAssignContract">
                                                <i class="fas fa-link"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Projet 4 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong>PROJ-2026-004</strong></td>
                                    <td>
                                        <strong>Centre Commercial Alger</strong><br>
                                        <small class="text-muted">Début: 01/03/2026</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-building text-primary"></i>
                                        SARL ImmoPlus
                                    </td>
                                    <td>
                                        <strong>20,000,000 DA</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-hard-hat"></i> 4 chantiers
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 85%"></div>
                                        </div>
                                        <small>85%</small>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 80%"></div>
                                        </div>
                                        <small>80%</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-sync fa-spin"></i> En cours
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                data-toggle="modal" data-target="#modalProjectDetails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" title="Ajouter chantier"
                                                data-toggle="modal" data-target="#modalAddSite">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" title="Contrat">
                                                <i class="fas fa-file-contract"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Projet 5 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong>PROJ-2025-045</strong></td>
                                    <td>
                                        <strong>Résidence Universitaire Sétif</strong><br>
                                        <small class="text-muted">Terminé: 30/06/2026</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-building text-primary"></i>
                                        Ministère de l'Éducation
                                    </td>
                                    <td>
                                        <strong>12,300,000 DA</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-hard-hat"></i> 2 chantiers
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                        </div>
                                        <small>100%</small>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                        </div>
                                        <small>100%</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-check-circle"></i> Terminé
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                data-toggle="modal" data-target="#modalProjectDetails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary" title="Ajouter chantier"
                                                disabled>
                                                <i class="fas fa-ban"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" title="Contrat">
                                                <i class="fas fa-file-contract"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-3">
                        <div class="col-sm-5">
                            <div class="dataTables_info">
                                Affichage de 1 à 5 sur 47 projets
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers float-right">
                                <ul class="pagination">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">&laquo;</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">...</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">10</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">&raquo;</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal Détails Projet -->
    <div class="modal fade" id="modalProjectDetails">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">
                        <i class="fas fa-project-diagram"></i> Détails du Projet
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Info Projet -->
                    <div class="row">
                        <div class="col-md-8">
                            <h5>
                                <i class="fas fa-folder text-primary"></i>
                                Construction Université Oran
                            </h5>
                            <p class="text-muted">
                                <strong>Code:</strong> PROJ-2026-001 |
                                <strong>Client:</strong> Ministère de l'Éducation Nationale
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="badge badge-success badge-lg">
                                <i class="fas fa-sync fa-spin"></i> En cours
                            </span>
                        </div>
                    </div>

                    <hr>

                    <!-- Stats du Projet -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Montant Total</span>
                                    <span class="info-box-number">10M DA</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-percentage"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">% Décaissé</span>
                                    <span class="info-box-number">30%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-chart-line"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Avancement</span>
                                    <span class="info-box-number">45%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-hard-hat"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Chantiers</span>
                                    <span class="info-box-number">3</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chantiers Affectés -->
                    <h6 class="mb-3">
                        <i class="fas fa-hard-hat text-warning"></i> Chantiers Affectés
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nom du Chantier</th>
                                    <th>Localisation</th>
                                    <th>% Avancement</th>
                                    <th>Montant Alloué</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Bâtiment Principal</strong></td>
                                    <td>Oran - Campus Universitaire</td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-success" style="width: 60%"></div>
                                        </div>
                                        <small>60%</small>
                                    </td>
                                    <td><strong>6,000,000 DA</strong></td>
                                    <td>
                                        <span class="badge badge-success">En cours</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" title="Modifier avancement"
                                            data-toggle="modal" data-target="#modalUpdateProgress">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Laboratoires</strong></td>
                                    <td>Oran - Campus Universitaire</td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-warning" style="width: 30%"></div>
                                        </div>
                                        <small>30%</small>
                                    </td>
                                    <td><strong>2,500,000 DA</strong></td>
                                    <td>
                                        <span class="badge badge-success">En cours</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" title="Modifier avancement"
                                            data-toggle="modal" data-target="#modalUpdateProgress">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Parking</strong></td>
                                    <td>Oran - Campus Universitaire</td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar" style="width: 10%"></div>
                                        </div>
                                        <small>10%</small>
                                    </td>
                                    <td><strong>1,500,000 DA</strong></td>
                                    <td>
                                        <span class="badge badge-secondary">Non démarré</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" title="Modifier avancement"
                                            data-toggle="modal" data-target="#modalUpdateProgress">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Contrat Associé -->
                    <h6 class="mb-3 mt-4">
                        <i class="fas fa-file-contract text-danger"></i> Contrat Associé
                    </h6>
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>N° Contrat:</strong> CNT-2026-001<br>
                                <strong>Date Signature:</strong> 15/08/2026
                            </div>
                            <div class="col-md-4">
                                <strong>Délai Réalisation:</strong> 18 mois<br>
                                <strong>Date Fin Prévue:</strong> 15/02/2028
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="button" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download"></i> Télécharger
                                </button>
                                <button type="button" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Voir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Fermer
                    </button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddSite">
                        <i class="fas fa-plus"></i> Ajouter un Chantier
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- Modal Ajouter Chantier -->
    <div class="modal fade" id="modalAddSite">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title">
                        <i class="fas fa-hard-hat"></i> Ajouter un Chantier Affecté
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Projet: <strong>Construction Université Oran</strong> (PROJ-2026-001)
                        </div>

                        <div class="form-group">
                            <label>Nom du Chantier <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Ex: Bâtiment Principal" required>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="2" placeholder="Description du chantier..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Localisation</label>
                                    <input type="text" class="form-control" placeholder="Adresse du chantier">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ville <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Oran" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date Début</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date Fin Prévue</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>% Avancement Initial</label>
                                    <input type="number" class="form-control" min="0" max="100" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Responsable du Chantier</label>
                            <input type="text" class="form-control" placeholder="Nom du responsable">
                        </div>

                        <!-- SECTION CONTRAT -->
                        <div class="card card-outline card-primary mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-file-contract text-primary"></i> Contrat du Chantier
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>N° Contrat</label>
                                            <input type="text" class="form-control" placeholder="Ex: CNT-2026-001">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type de Contrat</label>
                                            <select class="form-control select2">
                                                <option value="">Sélectionner...</option>
                                                <option value="marche_public">Marché Public</option>
                                                <option value="gre_a_gre">Gré à Gré</option>
                                                <option value="appel_offres">Appel d'Offres</option>
                                                <option value="contrat_prive">Contrat Privé</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date de Signature</label>
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Montant du Contrat (DA)</label>
                                            <input type="number" class="form-control" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload de Fichier Contrat -->
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-upload"></i> Upload du Contrat (PDF)
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="fileContrat"
                                            accept=".pdf,.doc,.docx">
                                        <label class="custom-file-label" for="fileContrat">
                                            Choisir un fichier...
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Formats acceptés: PDF, DOC, DOCX | Taille max: 10MB
                                    </small>
                                </div>

                                <!-- Preview du fichier uploadé (caché par défaut) -->
                                <div id="contratPreview" class="alert alert-success" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-file-pdf text-danger"></i>
                                            <strong id="contratFileName">contrat.pdf</strong>
                                            <br>
                                            <small id="contratFileSize">2.5 MB</small>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-info mr-2" id="btnVoirContrat">
                                                <i class="fas fa-eye"></i> Voir
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                id="btnSupprimerContrat">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN SECTION CONTRAT -->

                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- Script pour gérer l'upload et la preview -->
    <script>
    $(document).ready(function() {
        // Gestion de l'affichage du nom de fichier
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).siblings('.custom-file-label').addClass('selected').html(fileName);

            // Afficher la preview
            if (fileName) {
                var fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
                $('#contratFileName').text(fileName);
                $('#contratFileSize').text(fileSize + ' MB');
                $('#contratPreview').slideDown();
            }
        });

        // Bouton supprimer contrat
        $('#btnSupprimerContrat').on('click', function() {
            $('#fileContrat').val('');
            $('#fileContrat').siblings('.custom-file-label').html('Choisir un fichier...');
            $('#contratPreview').slideUp();
        });

        // Bouton voir contrat (simulation)
        $('#btnVoirContrat').on('click', function() {
            alert('Aperçu du contrat: ' + $('#contratFileName').text());
            // En production: ouvrir le PDF dans un nouvel onglet ou modal
        });
    });
    </script>

    <!-- Modal Modifier Avancement -->
    <div class="modal fade" id="modalUpdateProgress">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">
                        <i class="fas fa-chart-line"></i> Modifier l'Avancement
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="alert alert-info">
                            <strong>Chantier:</strong> Bâtiment Principal<br>
                            <strong>Projet:</strong> Construction Université Oran
                        </div>

                        <div class="form-group">
                            <label>Avancement Actuel</label>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-success" style="width: 60%">60%</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nouvel Avancement (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" min="0" max="100" value="60" required>
                        </div>

                        <div class="form-group">
                            <label>Commentaire</label>
                            <textarea class="form-control" rows="2"
                                placeholder="Description de l'avancement..."></textarea>
                        </div>

                        <div class="form-group">
                            <label>Responsable de la mise à jour</label>
                            <input type="text" class="form-control" placeholder="Nom du responsable">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-warning">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- Modal Associer Contrat -->
    <div class="modal fade" id="modalAssignContract">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">
                        <i class="fas fa-link"></i> Associer un Contrat
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Sélectionner un Projet <span class="text-danger">*</span></label>
                            <select class="form-control select2" required>
                                <option value="">Sélectionner...</option>
                                <option value="1">Construction Université Oran - Ministère Éducation</option>
                                <option value="2">Hôpital Régional Annaba - Wilaya d'Annaba</option>
                                <option value="3">Complexe Sportif Constantine - Ministère Sports</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Sélectionner un Contrat <span class="text-danger">*</span></label>
                            <select class="form-control select2" required>
                                <option value="">Sélectionner...</option>
                                <option value="1">CNT-2026-001 - Marché Public N°123/2026</option>
                                <option value="2">CNT-2026-002 - Contrat Gré à Gré</option>
                                <option value="3">CNT-2026-003 - Appel d'Offres Ouvert</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Date d'Association</label>
                            <input type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>

                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control" rows="2" placeholder="Notes complémentaires..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-info">
                        <i class="fas fa-link"></i> Associer
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

</div>
<!-- /.content-wrapper -->