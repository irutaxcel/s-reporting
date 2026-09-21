<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-file-invoice-dollar text-primary"></i> Devis & Contrats par Chantier
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Devis & Contrats</li>
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
                            <i class="fas fa-file-invoice"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Devis</span>
                            <span class="info-box-number">24</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Devis Signés</span>
                            <span class="info-box-number">18</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1">
                            <i class="fas fa-file-contract"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Contrats Actifs</span>
                            <span class="info-box-number">15</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-hard-hat"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Chantiers</span>
                            <span class="info-box-number">12</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Main Card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Liste des Devis & Contrats par Chantier
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#modalUploadDevis">
                            <i class="fas fa-plus"></i> Nouveau Devis
                        </button>
                        <button type="button" class="btn btn-info btn-sm ml-2" data-toggle="modal"
                            data-target="#modalUploadContrat">
                            <i class="fas fa-file-contract"></i> Nouveau Contrat
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
                                <input type="text" class="form-control" placeholder="Rechercher un devis/contrat...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2" id="filterProjet">
                                <option value="">Tous les projets</option>
                                <option value="1">PROJ-2026-001</option>
                                <option value="2">PROJ-2026-002</option>
                                <option value="3">PROJ-2026-003</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2" id="filterChantier">
                                <option value="">Tous les chantiers</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2">
                                <option value="">Tous les types</option>
                                <option value="devis">Devis</option>
                                <option value="contrat">Contrat</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2">
                                <option value="">Tous les statuts</option>
                                <option value="en_attente">En Attente</option>
                                <option value="signe">Signé</option>
                                <option value="expire">Expiré</option>
                                <option value="annule">Annulé</option>
                            </select>
                        </div>
                    </div>

                    <!-- Documents Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" class="checkbox-toggle">
                                    </th>
                                    <th>Référence</th>
                                    <th>Type</th>
                                    <th>Projet</th>
                                    <th>Chantier</th>
                                    <th>Montant</th>
                                    <th>Date Création</th>
                                    <th>Date Signature</th>
                                    <th>Date Expiration</th>
                                    <th width="120">Statut</th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Devis 1 - Chantier 1 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong>DEV-2026-001</strong></td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <i class="fas fa-file-invoice"></i> Devis
                                        </span>
                                    </td>
                                    <td>
                                        <strong>Construction Université Oran</strong><br>
                                        <small class="text-muted">PROJ-2026-001</small>
                                    </td>
                                    <td>
                                        <strong>Bâtiment Principal</strong><br>
                                        <small class="text-muted">Oran - Campus</small>
                                    </td>
                                    <td>
                                        <strong>6,000,000 DA</strong>
                                    </td>
                                    <td>
                                        <i class="far fa-calendar"></i> 01/09/2026
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-check"></i> 15/09/2026
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-times"></i> 01/12/2026
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Signé
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir" data-toggle="modal"
                                                data-target="#modalViewDevis">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" title="Télécharger">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Contrat 1 - Même Chantier -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong>CNT-2026-001</strong></td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-file-contract"></i> Contrat
                                        </span>
                                    </td>
                                    <td>
                                        <strong>Construction Université Oran</strong><br>
                                        <small class="text-muted">PROJ-2026-001</small>
                                    </td>
                                    <td>
                                        <strong>Bâtiment Principal</strong><br>
                                        <small class="text-muted">Oran - Campus</small>
                                    </td>
                                    <td>
                                        <strong>6,000,000 DA</strong>
                                    </td>
                                    <td>
                                        <i class="far fa-calendar"></i> 20/09/2026
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-check"></i> 25/09/2026
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-times"></i> 25/03/2028
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Signé
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" title="Télécharger">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Devis 2 - Chantier 2 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong>DEV-2026-002</strong></td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <i class="fas fa-file-invoice"></i> Devis
                                        </span>
                                    </td>
                                    <td>
                                        <strong>Construction Université Oran</strong><br>
                                        <small class="text-muted">PROJ-2026-001</small>
                                    </td>
                                    <td>
                                        <strong>Laboratoires</strong><br>
                                        <small class="text-muted">Oran - Campus</small>
                                    </td>
                                    <td>
                                        <strong>2,500,000 DA</strong>
                                    </td>
                                    <td>
                                        <i class="far fa-calendar"></i> 10/09/2026
                                    </td>
                                    <td>
                                        <em class="text-muted">-</em>
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-times"></i> 10/12/2026
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> En Attente
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" title="Télécharger">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" title="Relancer">
                                                <i class="fas fa-bell"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Devis 3 - Projet 2, Chantier 1 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong>DEV-2026-003</strong></td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <i class="fas fa-file-invoice"></i> Devis
                                        </span>
                                    </td>
                                    <td>
                                        <strong>Hôpital Régional Annaba</strong><br>
                                        <small class="text-muted">PROJ-2026-002</small>
                                    </td>
                                    <td>
                                        <strong>Bloc Chirurgie</strong><br>
                                        <small class="text-muted">Annaba</small>
                                    </td>
                                    <td>
                                        <strong>8,500,000 DA</strong>
                                    </td>
                                    <td>
                                        <i class="far fa-calendar"></i> 15/08/2026
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-check"></i> 20/08/2026
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-times text-danger"></i> 20/11/2026
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle"></i> Expiré
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" title="Télécharger">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary" title="Renouveler">
                                                <i class="fas fa-sync"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Contrat 2 - Projet 2, Chantier 1 -->
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong>CNT-2026-002</strong></td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-file-contract"></i> Contrat
                                        </span>
                                    </td>
                                    <td>
                                        <strong>Hôpital Régional Annaba</strong><br>
                                        <small class="text-muted">PROJ-2026-002</small>
                                    </td>
                                    <td>
                                        <strong>Bloc Chirurgie</strong><br>
                                        <small class="text-muted">Annaba</small>
                                    </td>
                                    <td>
                                        <strong>8,500,000 DA</strong>
                                    </td>
                                    <td>
                                        <i class="far fa-calendar"></i> 25/08/2026
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-check"></i> 01/09/2026
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-times"></i> 01/03/2028
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Signé
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" title="Télécharger">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
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
                                Affichage de 1 à 5 sur 24 documents
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
                                        <a class="page-link" href="#">6</a>
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

    <!-- Modal Upload Devis -->
    <div class="modal fade" id="modalUploadDevis">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">
                        <i class="fas fa-file-invoice"></i> Enregistrer un Devis pour un Chantier
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Hiérarchie:</strong> Projet → Chantier → Devis
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Projet <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="selectProjetDevis" required>
                                        <option value="">Sélectionner un projet...</option>
                                        <option value="1">PROJ-2026-001 - Construction Université Oran</option>
                                        <option value="2">PROJ-2026-002 - Hôpital Régional Annaba</option>
                                        <option value="3">PROJ-2026-003 - Complexe Sportif Constantine</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Chantier <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="selectChantierDevis" required disabled>
                                        <option value="">Sélectionner d'abord le projet...</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Référence du Devis <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Ex: DEV-2026-001" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Montant Total (DA) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date de Création <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date de Signature</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date d'Expiration <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Statut <span class="text-danger">*</span></label>
                            <select class="form-control select2" required>
                                <option value="en_attente">En Attente</option>
                                <option value="signe">Signé</option>
                                <option value="expire">Expiré</option>
                                <option value="annule">Annulé</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-upload"></i> Fichier du Devis (PDF) <span class="text-danger">*</span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileDevis" accept=".pdf" required>
                                <label class="custom-file-label" for="fileDevis">
                                    Choisir un fichier PDF...
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Format accepté: PDF | Taille max: 10MB
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Description / Notes</label>
                            <textarea class="form-control" rows="3" placeholder="Description du devis..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- Modal Upload Contrat -->
    <div class="modal fade" id="modalUploadContrat">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">
                        <i class="fas fa-file-contract"></i> Enregistrer un Contrat pour un Chantier
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Hiérarchie:</strong> Projet → Chantier → Contrat
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Projet <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="selectProjetContrat" required>
                                        <option value="">Sélectionner un projet...</option>
                                        <option value="1">PROJ-2026-001 - Construction Université Oran</option>
                                        <option value="2">PROJ-2026-002 - Hôpital Régional Annaba</option>
                                        <option value="3">PROJ-2026-003 - Complexe Sportif Constantine</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Chantier <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="selectChantierContrat" required disabled>
                                        <option value="">Sélectionner d'abord le projet...</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>N° de Contrat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Ex: CNT-2026-001" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type de Contrat <span class="text-danger">*</span></label>
                                    <select class="form-control select2" required>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Montant du Contrat (DA) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date de Signature <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date de Fin Prévue</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Délai de Réalisation (mois)</label>
                            <input type="number" class="form-control" placeholder="Ex: 18">
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-upload"></i> Fichier du Contrat (PDF) <span
                                    class="text-danger">*</span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileContrat" accept=".pdf" required>
                                <label class="custom-file-label" for="fileContrat">
                                    Choisir un fichier PDF...
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Format accepté: PDF | Taille max: 10MB
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Clauses et Conditions</label>
                            <textarea class="form-control" rows="3" placeholder="Description des clauses..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-info">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <!-- Modal View Devis/Contrat -->
    <div class="modal fade" id="modalViewDevis">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">
                        <i class="fas fa-eye"></i> Détails du Document
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>
                                <i class="fas fa-file-invoice text-primary"></i>
                                Devis N° DEV-2026-001
                            </h5>
                            <p class="text-muted">
                                <strong>Projet:</strong> Construction Université Oran (PROJ-2026-001)<br>
                                <strong>Chantier:</strong> Bâtiment Principal<br>
                                <strong>Localisation:</strong> Oran - Campus Universitaire
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="badge badge-success badge-lg">
                                <i class="fas fa-check-circle"></i> Signé
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Montant</span>
                                    <span class="info-box-number">6M DA</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-calendar-check"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Signature</span>
                                    <span class="info-box-number">15/09/2026</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-calendar-times"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Expiration</span>
                                    <span class="info-box-number">01/12/2026</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Fichier</span>
                                    <span class="info-box-number">PDF</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Description:</strong><br>
                        Devis pour la construction du bâtiment principal comprenant les salles de cours et
                        l'administration.
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-primary btn-lg">
                            <i class="fas fa-file-pdf"></i> Voir le PDF
                        </button>
                        <button type="button" class="btn btn-success btn-lg ml-2">
                            <i class="fas fa-download"></i> Télécharger
                        </button>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Fermer
                    </button>
                    <button type="button" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

</div>
<!-- /.content-wrapper -->

<script>
$(document).ready(function() {
    // Gestion de l'affichage du nom de fichier
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: 'Sélectionner...',
        allowClear: true
    });

    // Données des chantiers par projet (simulation)
    var chantiersParProjet = {
        '1': [{
                id: '1',
                name: 'Bâtiment Principal - Oran Campus'
            },
            {
                id: '2',
                name: 'Laboratoires - Oran Campus'
            },
            {
                id: '3',
                name: 'Parking - Oran Campus'
            }
        ],
        '2': [{
                id: '4',
                name: 'Bloc Chirurgie - Annaba'
            },
            {
                id: '5',
                name: 'Urgences - Annaba'
            },
            {
                id: '6',
                name: 'Hospitalisation - Annaba'
            }
        ],
        '3': [{
                id: '7',
                name: 'Stade Principal - Constantine'
            },
            {
                id: '8',
                name: 'Piscine Olympique - Constantine'
            }
        ]
    };

    // Gestion changement projet pour Devis
    $('#selectProjetDevis').on('change', function() {
        var projetId = $(this).val();
        var selectChantier = $('#selectChantierDevis');

        selectChantier.empty().append('<option value="">Sélectionner un chantier...</option>');

        if (projetId && chantiersParProjet[projetId]) {
            chantiersParProjet[projetId].forEach(function(chantier) {
                selectChantier.append('<option value="' + chantier.id + '">' + chantier.name +
                    '</option>');
            });
            selectChantier.prop('disabled', false);
        } else {
            selectChantier.prop('disabled', true);
        }

        selectChantier.trigger('change');
    });

    // Gestion changement projet pour Contrat
    $('#selectProjetContrat').on('change', function() {
        var projetId = $(this).val();
        var selectChantier = $('#selectChantierContrat');

        selectChantier.empty().append('<option value="">Sélectionner un chantier...</option>');

        if (projetId && chantiersParProjet[projetId]) {
            chantiersParProjet[projetId].forEach(function(chantier) {
                selectChantier.append('<option value="' + chantier.id + '">' + chantier.name +
                    '</option>');
            });
            selectChantier.prop('disabled', false);
        } else {
            selectChantier.prop('disabled', true);
        }

        selectChantier.trigger('change');
    });

    // Filtrage par projet
    $('#filterProjet').on('change', function() {
        var projetId = $(this).val();
        var selectChantier = $('#filterChantier');

        selectChantier.empty().append('<option value="">Tous les chantiers</option>');

        if (projetId && chantiersParProjet[projetId]) {
            chantiersParProjet[projetId].forEach(function(chantier) {
                selectChantier.append('<option value="' + chantier.id + '">' + chantier.name +
                    '</option>');
            });
        }
    });
});
</script>