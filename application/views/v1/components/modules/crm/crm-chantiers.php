<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-hard-hat text-warning"></i> Chantiers & Avancement
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">CRM & Clients</a></li>
                        <li class="breadcrumb-item active">Chantiers & Avancement</li>
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
                            <i class="fas fa-hard-hat"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Chantiers</span>
                            <span class="info-box-number">142</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-sync fa-spin"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">En Cours</span>
                            <span class="info-box-number">87</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1">
                            <i class="fas fa-clock"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Non Démarrés</span>
                            <span class="info-box-number">38</span>
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
                            <span class="info-box-number">17</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Main Chantiers Card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Liste des Chantiers Affectés
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                            data-target="#modalGlobalProgress">
                            <i class="fas fa-chart-line"></i> Mise à Jour Globale
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
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Rechercher un chantier...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2">
                                <option value="">Tous les projets</option>
                                <option value="1">Construction Université Oran</option>
                                <option value="2">Hôpital Régional Annaba</option>
                                <option value="3">Complexe Sportif Constantine</option>
                                <option value="4">Centre Commercial Alger</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2">
                                <option value="">Tous les statuts</option>
                                <option value="non_demarre">Non Démarré</option>
                                <option value="en_cours">En Cours</option>
                                <option value="termine">Terminé</option>
                                <option value="suspendu">Suspendu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2">
                                <option value="">Toutes les villes</option>
                                <option value="Alger">Alger</option>
                                <option value="Oran">Oran</option>
                                <option value="Constantine">Constantine</option>
                                <option value="Annaba">Annaba</option>
                            </select>
                        </div>
                    </div>

                    <!-- Chantiers Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" class="checkbox-toggle">
                                    </th>
                                    <th>Nom du Chantier</th>
                                    <th>Projet Associé</th>
                                    <th>Ville</th>
                                    <th width="150">% Avancement</th>
                                    <th width="150">Montant Alloué</th>
                                    <th width="150">Montant Décaissé</th>
                                    <th width="120">Statut</th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Chantier 1 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td>
                                        <strong>Bâtiment Principal</strong><br>
                                        <small class="text-muted">Oran - Campus Universitaire</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-project-diagram text-primary"></i>
                                        Construction Université Oran
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger"></i> Oran
                                    </td>
                                    <td>
                                        <div class="progress progress-sm mb-1">
                                            <div class="progress-bar bg-success" style="width: 60%">60%</div>
                                        </div>
                                        <small class="text-muted">Mis à jour: 02/09/2026</small>
                                    </td>
                                    <td>
                                        <strong>6,000,000 DA</strong><br>
                                        <small class="text-muted">(60% du total)</small>
                                    </td>
                                    <td>
                                        <strong class="text-success">3,000,000 DA</strong><br>
                                        <small class="text-muted">(50% alloué)</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-sync fa-spin"></i> En cours
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-warning" title="Modifier avancement"
                                                data-toggle="modal" data-target="#modalUpdateProgress">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                data-toggle="modal" data-target="#modalChantierDetails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary" title="Historique">
                                                <i class="fas fa-history"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Chantier 2 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td>
                                        <strong>Laboratoires</strong><br>
                                        <small class="text-muted">Oran - Campus Universitaire</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-project-diagram text-primary"></i>
                                        Construction Université Oran
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger"></i> Oran
                                    </td>
                                    <td>
                                        <div class="progress progress-sm mb-1">
                                            <div class="progress-bar bg-warning" style="width: 30%">30%</div>
                                        </div>
                                        <small class="text-muted">Mis à jour: 01/09/2026</small>
                                    </td>
                                    <td>
                                        <strong>2,500,000 DA</strong><br>
                                        <small class="text-muted">(25% du total)</small>
                                    </td>
                                    <td>
                                        <strong class="text-warning">750,000 DA</strong><br>
                                        <small class="text-muted">(30% alloué)</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-sync fa-spin"></i> En cours
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-warning" title="Modifier avancement"
                                                data-toggle="modal" data-target="#modalUpdateProgress">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                data-toggle="modal" data-target="#modalChantierDetails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary" title="Historique">
                                                <i class="fas fa-history"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Chantier 3 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td>
                                        <strong>Parking</strong><br>
                                        <small class="text-muted">Oran - Campus Universitaire</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-project-diagram text-primary"></i>
                                        Construction Université Oran
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger"></i> Oran
                                    </td>
                                    <td>
                                        <div class="progress progress-sm mb-1">
                                            <div class="progress-bar" style="width: 10%">10%</div>
                                        </div>
                                        <small class="text-muted">Mis à jour: 28/08/2026</small>
                                    </td>
                                    <td>
                                        <strong>1,500,000 DA</strong><br>
                                        <small class="text-muted">(15% du total)</small>
                                    </td>
                                    <td>
                                        <strong class="text-muted">150,000 DA</strong><br>
                                        <small class="text-muted">(10% alloué)</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-pause-circle"></i> Non démarré
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-warning" title="Modifier avancement"
                                                data-toggle="modal" data-target="#modalUpdateProgress">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                data-toggle="modal" data-target="#modalChantierDetails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary" title="Historique">
                                                <i class="fas fa-history"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Chantier 4 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td>
                                        <strong>Bloc Administratif</strong><br>
                                        <small class="text-muted">Annaba - Centre Ville</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-project-diagram text-primary"></i>
                                        Hôpital Régional Annaba
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger"></i> Annaba
                                    </td>
                                    <td>
                                        <div class="progress progress-sm mb-1">
                                            <div class="progress-bar bg-success" style="width: 75%">75%</div>
                                        </div>
                                        <small class="text-muted">Mis à jour: 03/09/2026</small>
                                    </td>
                                    <td>
                                        <strong>8,000,000 DA</strong><br>
                                        <small class="text-muted">(52% du total)</small>
                                    </td>
                                    <td>
                                        <strong class="text-success">6,000,000 DA</strong><br>
                                        <small class="text-muted">(75% alloué)</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-sync fa-spin"></i> En cours
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-warning" title="Modifier avancement"
                                                data-toggle="modal" data-target="#modalUpdateProgress">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                data-toggle="modal" data-target="#modalChantierDetails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary" title="Historique">
                                                <i class="fas fa-history"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Chantier 5 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td>
                                        <strong>Urgences</strong><br>
                                        <small class="text-muted">Annaba - Centre Ville</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-project-diagram text-primary"></i>
                                        Hôpital Régional Annaba
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger"></i> Annaba
                                    </td>
                                    <td>
                                        <div class="progress progress-sm mb-1">
                                            <div class="progress-bar bg-info" style="width: 100%">100%</div>
                                        </div>
                                        <small class="text-muted">Mis à jour: 30/08/2026</small>
                                    </td>
                                    <td>
                                        <strong>4,500,000 DA</strong><br>
                                        <small class="text-muted">(29% du total)</small>
                                    </td>
                                    <td>
                                        <strong class="text-info">4,500,000 DA</strong><br>
                                        <small class="text-muted">(100% alloué)</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-check-circle"></i> Terminé
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-warning" title="Modifier avancement"
                                                disabled>
                                                <i class="fas fa-ban"></i>
                                            </button>
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                data-toggle="modal" data-target="#modalChantierDetails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary" title="Historique">
                                                <i class="fas fa-history"></i>
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
                                Affichage de 1 à 5 sur 142 chantiers
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
                                        <a class="page-link" href="#">29</a>
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
                            <small class="text-muted">
                                Montant alloué: 6,000,000 DA | Décaissé: 3,000,000 DA
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Nouvel Avancement (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="newProgress" min="0" max="100" value="60"
                                required>
                            <small class="form-text text-muted">
                                <i class="fas fa-calculator"></i>
                                Le montant décaissé sera recalculé automatiquement
                            </small>
                        </div>

                        <div class="alert alert-success" id="calculationPreview">
                            <h6><i class="fas fa-calculator"></i> Calcul Automatique</h6>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Nouveau montant alloué:</strong><br>
                                    <span id="newAllocated">6,000,000 DA</span>
                                </div>
                                <div class="col-6">
                                    <strong>Nouveau montant décaissé:</strong><br>
                                    <span id="newDisbursed">3,000,000 DA</span>
                                </div>
                            </div>
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

                        <div class="form-group">
                            <label>Date de mise à jour</label>
                            <input type="date" class="form-control" value="<?= date('Y-m-d') ?>">
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

    <!-- Modal Détails Chantier -->
    <div class="modal fade" id="modalChantierDetails">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">
                        <i class="fas fa-hard-hat"></i> Détails du Chantier
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Info Chantier -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5>
                                <i class="fas fa-hard-hat text-warning"></i>
                                Bâtiment Principal
                            </h5>
                            <p class="text-muted">
                                <strong>Projet:</strong> Construction Université Oran<br>
                                <strong>Localisation:</strong> Oran - Campus Universitaire
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="badge badge-success badge-lg">
                                <i class="fas fa-sync fa-spin"></i> En cours
                            </span>
                        </div>
                    </div>

                    <!-- Stats du Chantier -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-chart-line"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Avancement</span>
                                    <span class="info-box-number">60%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Montant Alloué</span>
                                    <span class="info-box-number">6M DA</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Montant Décaissé</span>
                                    <span class="info-box-number">3M DA</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Planning -->
                    <h6 class="mb-3">
                        <i class="fas fa-calendar-alt text-primary"></i> Planning
                    </h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td><strong>Date Début:</strong></td>
                                <td>01/09/2026</td>
                                <td><strong>Date Fin Prévue:</strong></td>
                                <td>15/02/2028</td>
                            </tr>
                            <tr>
                                <td><strong>Responsable:</strong></td>
                                <td colspan="3">Ahmed Benali</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Historique Avancement -->
                    <h6 class="mb-3">
                        <i class="fas fa-history text-secondary"></i> Historique des Mises à Jour
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Ancien %</th>
                                    <th>Nouveau %</th>
                                    <th>Responsable</th>
                                    <th>Commentaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>02/09/2026</td>
                                    <td>45%</td>
                                    <td><span class="badge badge-success">60%</span></td>
                                    <td>Ahmed Benali</td>
                                    <td>Avancement gros oeuvre terminé</td>
                                </tr>
                                <tr>
                                    <td>15/08/2026</td>
                                    <td>30%</td>
                                    <td><span class="badge badge-warning">45%</span></td>
                                    <td>Ahmed Benali</td>
                                    <td>Fondations terminées</td>
                                </tr>
                                <tr>
                                    <td>01/08/2026</td>
                                    <td>10%</td>
                                    <td><span class="badge badge-info">30%</span></td>
                                    <td>Karim Slimani</td>
                                    <td>Début terrassement</td>
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
                            <div class="col-md-6">
                                <strong>N° Contrat:</strong> CNT-2026-001<br>
                                <strong>Type:</strong> Marché Public<br>
                                <strong>Montant:</strong> 6,000,000 DA
                            </div>
                            <div class="col-md-6 text-right">
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
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalUpdateProgress"
                        data-dismiss="modal">
                        <i class="fas fa-edit"></i> Modifier Avancement
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- Modal Mise à Jour Globale -->
    <div class="modal fade" id="modalGlobalProgress">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">
                        <i class="fas fa-chart-line"></i> Mise à Jour Globale des Avancements
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Attention:</strong> Cette action mettra à jour tous les chantiers sélectionnés.
                    </div>

                    <form>
                        <div class="form-group">
                            <label>Sélectionner les chantiers à mettre à jour</label>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="50">
                                                <input type="checkbox" id="selectAllGlobal">
                                            </th>
                                            <th>Chantier</th>
                                            <th>Projet</th>
                                            <th>Avancement Actuel</th>
                                            <th width="120">Nouvel Avancement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="chantier-select">
                                            </td>
                                            <td>Bâtiment Principal</td>
                                            <td>Université Oran</td>
                                            <td>
                                                <span class="badge badge-success">60%</span>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" min="0"
                                                    max="100" value="60">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="chantier-select">
                                            </td>
                                            <td>Laboratoires</td>
                                            <td>Université Oran</td>
                                            <td>
                                                <span class="badge badge-warning">30%</span>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" min="0"
                                                    max="100" value="30">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="chantier-select">
                                            </td>
                                            <td>Parking</td>
                                            <td>Université Oran</td>
                                            <td>
                                                <span class="badge badge-secondary">10%</span>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" min="0"
                                                    max="100" value="10">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Commentaire global</label>
                            <textarea class="form-control" rows="2"
                                placeholder="Raison de la mise à jour..."></textarea>
                        </div>

                        <div class="form-group">
                            <label>Responsable</label>
                            <input type="text" class="form-control" placeholder="Nom du responsable">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-info">
                        <i class="fas fa-save"></i> Mettre à jour tout
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

</div>
<!-- /.content-wrapper -->

<!-- Script pour le calcul automatique -->
<script>
$(document).ready(function() {
    // Calcul automatique lors du changement de pourcentage
    $('#newProgress').on('input', function() {
        var newProgress = $(this).val();
        var totalProjet = 10000000; // Montant total du projet (à récupérer dynamiquement)
        var currentDisbursed = 3000000; // Montant décaissé actuel

        // Calcul du nouveau montant alloué
        var newAllocated = (totalProjet * newProgress / 100).toFixed(0);

        // Calcul du nouveau montant décaissé (proportionnel)
        var newDisbursed = (currentDisbursed * newProgress / 60).toFixed(
        0); // 60% est l'avancement actuel

        // Mise à jour de l'affichage
        $('#newAllocated').text(formatCurrency(newAllocated) + ' DA');
        $('#newDisbursed').text(formatCurrency(newDisbursed) + ' DA');
    });

    // Fonction pour formater les montants
    function formatCurrency(amount) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Select all pour la mise à jour globale
    $('#selectAllGlobal').on('change', function() {
        $('.chantier-select').prop('checked', $(this).prop('checked'));
    });
});
</script>