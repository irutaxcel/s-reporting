<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-users text-primary"></i> Clients CRM
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">CRM & Clients</a></li>
                        <li class="breadcrumb-item active">Clients</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Stats Cards Modernes -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card stat-card-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Clients</h6>
                                    <h2 class="mb-0 font-weight-bold">124</h2>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up"></i> +12 ce mois
                                    </small>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card stat-card-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Clients Actifs</h6>
                                    <h2 class="mb-0 font-weight-bold">86</h2>
                                    <small class="text-muted">69% du total</small>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card stat-card-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Prospects</h6>
                                    <h2 class="mb-0 font-weight-bold">28</h2>
                                    <small class="text-muted">À convertir</small>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card stat-card-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Projets Actifs</h6>
                                    <h2 class="mb-0 font-weight-bold">47</h2>
                                    <small class="text-info">
                                        <i class="fas fa-project-diagram"></i> En cours
                                    </small>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="card modern-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list text-primary"></i> Liste des Clients
                    </h5>
                    <div class="card-actions">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#modalNewClient">
                            <i class="fas fa-plus"></i> Nouveau Client
                        </button>
                        <button type="button" class="btn btn-info btn-sm ml-2" data-toggle="modal"
                            data-target="#modalImport">
                            <i class="fas fa-file-import"></i> Importer
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm ml-2">
                            <i class="fas fa-download"></i> Exporter
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Rechercher un client...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control custom-select">
                                <option value="">Tous les types</option>
                                <option value="entreprise">Entreprise</option>
                                <option value="particulier">Particulier</option>
                                <option value="public">Secteur Public</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control custom-select">
                                <option value="">Tous les statuts</option>
                                <option value="actif">Actif</option>
                                <option value="prospect">Prospect</option>
                                <option value="inactif">Inactif</option>
                                <option value="bloque">Bloqué</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control custom-select">
                                <option value="">Toutes catégories</option>
                                <option value="A">Catégorie A</option>
                                <option value="B">Catégorie B</option>
                                <option value="C">Catégorie C</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control custom-select">
                                <option value="">Nb. Projets</option>
                                <option value="0">Sans projet</option>
                                <option value="1-3">1-3 projets</option>
                                <option value="4+">4+ projets</option>
                            </select>
                        </div>
                    </div>

                    <!-- Clients Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" class="custom-checkbox">
                                    </th>
                                    <th width="50">Type</th>
                                    <th>Nom / Raison Sociale</th>
                                    <th>Contact Principal</th>
                                    <th>Ville</th>
                                    <th>Téléphone</th>
                                    <th width="80">Catégorie</th>
                                    <th width="100">Statut</th>
                                    <th width="100">Projets</th>
                                    <th width="130">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Client 1 -->
                                <tr>
                                    <td><input type="checkbox" class="custom-checkbox"></td>
                                    <td class="text-center">
                                        <span class="type-icon type-public" title="Secteur Public">
                                            <i class="fas fa-landmark"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="client-name">
                                            <strong>Ministère de l'Éducation Nationale</strong>
                                            <div class="client-meta">RC: 16/00-0123456B</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <strong>Dr. Ahmed Benali</strong>
                                            <div class="contact-role">Directeur Général</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="location">
                                            <i class="fas fa-map-marker-alt text-danger"></i> Alger
                                        </span>
                                    </td>
                                    <td>
                                        <span class="phone">
                                            <i class="fas fa-phone text-success"></i> 021 12 34 56
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-category badge-a">A</span>
                                    </td>
                                    <td>
                                        <span class="badge-status badge-actif">
                                            <i class="fas fa-check-circle"></i> Actif
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="projects-link">
                                            <span class="badge badge-primary">
                                                <i class="fas fa-project-diagram"></i> 3 projets
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group-actions">
                                            <button type="button" class="btn-action btn-view" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-delete" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Client 2 -->
                                <tr>
                                    <td><input type="checkbox" class="custom-checkbox"></td>
                                    <td class="text-center">
                                        <span class="type-icon type-entreprise" title="Entreprise">
                                            <i class="fas fa-building"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="client-name">
                                            <strong>SARL Bâtiment Plus</strong>
                                            <div class="client-meta">RC: 31/00-9876543A</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <strong>M. Karim Slimani</strong>
                                            <div class="contact-role">Gérant</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="location">
                                            <i class="fas fa-map-marker-alt text-danger"></i> Oran
                                        </span>
                                    </td>
                                    <td>
                                        <span class="phone">
                                            <i class="fas fa-phone text-success"></i> 041 23 45 67
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-category badge-b">B</span>
                                    </td>
                                    <td>
                                        <span class="badge-status badge-actif">
                                            <i class="fas fa-check-circle"></i> Actif
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="projects-link">
                                            <span class="badge badge-primary">
                                                <i class="fas fa-project-diagram"></i> 5 projets
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group-actions">
                                            <button type="button" class="btn-action btn-view" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-delete" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Client 3 -->
                                <tr>
                                    <td><input type="checkbox" class="custom-checkbox"></td>
                                    <td class="text-center">
                                        <span class="type-icon type-particulier" title="Particulier">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="client-name">
                                            <strong>M. Mohamed Trabelsi</strong>
                                            <div class="client-meta">Particulier</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <strong>M. Mohamed Trabelsi</strong>
                                            <div class="contact-role">Propriétaire</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="location">
                                            <i class="fas fa-map-marker-alt text-danger"></i> Constantine
                                        </span>
                                    </td>
                                    <td>
                                        <span class="phone">
                                            <i class="fas fa-phone text-success"></i> 031 98 76 54
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-category badge-c">C</span>
                                    </td>
                                    <td>
                                        <span class="badge-status badge-prospect">
                                            <i class="fas fa-clock"></i> Prospect
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="projects-link">
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-project-diagram"></i> 0 projet
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group-actions">
                                            <button type="button" class="btn-action btn-view" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-delete" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Client 4 -->
                                <tr>
                                    <td><input type="checkbox" class="custom-checkbox"></td>
                                    <td class="text-center">
                                        <span class="type-icon type-public" title="Secteur Public">
                                            <i class="fas fa-landmark"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="client-name">
                                            <strong>Wilaya d'Alger</strong>
                                            <div class="client-meta">NIF: 001234567890123</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <strong>Mme. Fatima Zohra</strong>
                                            <div class="contact-role">Chef de Service</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="location">
                                            <i class="fas fa-map-marker-alt text-danger"></i> Alger
                                        </span>
                                    </td>
                                    <td>
                                        <span class="phone">
                                            <i class="fas fa-phone text-success"></i> 021 98 76 54
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-category badge-a">A</span>
                                    </td>
                                    <td>
                                        <span class="badge-status badge-actif">
                                            <i class="fas fa-check-circle"></i> Actif
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="projects-link">
                                            <span class="badge badge-primary">
                                                <i class="fas fa-project-diagram"></i> 7 projets
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group-actions">
                                            <button type="button" class="btn-action btn-view" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-delete" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Client 5 -->
                                <tr>
                                    <td><input type="checkbox" class="custom-checkbox"></td>
                                    <td class="text-center">
                                        <span class="type-icon type-entreprise" title="Entreprise">
                                            <i class="fas fa-building"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="client-name">
                                            <strong>EURL Construction Moderne</strong>
                                            <div class="client-meta">RC: 25/00-4567891C</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <strong>M. Yacine Boumediene</strong>
                                            <div class="contact-role">Gérant</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="location">
                                            <i class="fas fa-map-marker-alt text-danger"></i> Annaba
                                        </span>
                                    </td>
                                    <td>
                                        <span class="phone">
                                            <i class="fas fa-phone text-success"></i> 038 12 34 56
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-category badge-b">B</span>
                                    </td>
                                    <td>
                                        <span class="badge-status badge-inactif">
                                            <i class="fas fa-pause-circle"></i> Inactif
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="projects-link">
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-project-diagram"></i> 2 projets
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group-actions">
                                            <button type="button" class="btn-action btn-view" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-delete" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div class="pagination-info">
                                Affichage de <strong>1 à 5</strong> sur <strong>124</strong> clients
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <nav aria-label="Pagination">
                                <ul class="pagination pagination-sm justify-content-end">
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
                                        <a class="page-link" href="#">25</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">&raquo;</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Modal Nouveau Client -->
    <div class="modal fade" id="modalNewClient">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">
                        <i class="fas fa-user-plus"></i> Nouveau Client
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type de Client <span class="text-danger">*</span></label>
                                    <select class="form-control select2" required>
                                        <option value="">Sélectionner...</option>
                                        <option value="entreprise">Entreprise</option>
                                        <option value="particulier">Particulier</option>
                                        <option value="public">Secteur Public</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Catégorie</label>
                                    <select class="form-control select2">
                                        <option value="C">Catégorie C</option>
                                        <option value="B">Catégorie B</option>
                                        <option value="A">Catégorie A</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Raison Sociale / Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Ex: SARL Bâtiment Plus" required>
                        </div>

                        <div class="form-group">
                            <label>Nom Commercial</label>
                            <input type="text" class="form-control" placeholder="Ex: Bâtiment Plus">
                        </div>

                        <!-- NOUVEAU CHAMP: Projet Associé -->
                        <div class="form-group">
                            <label>Projet Associé</label>
                            <select class="form-control select2" data-placeholder="Sélectionner un projet...">
                                <option value="">Aucun projet</option>
                                <optgroup label="Projets en Cours">
                                    <option value="1">Construction Université Oran - Ministère Éducation</option>
                                    <option value="2">Hôpital Régional Annaba - Wilaya d'Annaba</option>
                                    <option value="3">Complexe Sportif Constantine - Ministère Sports</option>
                                </optgroup>
                                <optgroup label="Projets Planifiés">
                                    <option value="4">Centre Commercial Alger - SARL ImmoPlus</option>
                                    <option value="5">Résidence Universitaire Sétif - Ministère Éducation</option>
                                </optgroup>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Liez ce client à un projet existant (optionnel)
                            </small>
                        </div>
                        <!-- FIN NOUVEAU CHAMP -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="contact@exemple.dz">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Téléphone <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" placeholder="021 12 34 56" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Adresse</label>
                            <textarea class="form-control" rows="2" placeholder="Adresse complète"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ville <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Alger" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Code Postal</label>
                                    <input type="text" class="form-control" placeholder="16000">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pays</label>
                                    <input type="text" class="form-control" value="Algérie">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>RC (Registre Commerce)</label>
                                    <input type="text" class="form-control" placeholder="16/00-0123456B">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>NIF</label>
                                    <input type="text" class="form-control" placeholder="001234567890123">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>AIS</label>
                                    <input type="text" class="form-control" placeholder="123456789">
                                </div>
                            </div>
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

    <!-- Modal Import -->
    <div class="modal fade" id="modalImport" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-info">
                    <h4 class="modal-title">
                        <i class="fas fa-file-import"></i> Importer des Clients
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Téléchargez le modèle Excel et remplissez-le avec vos données.
                    </div>

                    <div class="form-group">
                        <label class="form-label">Sélectionner le fichier Excel/CSV</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileImport">
                            <label class="custom-file-label" for="fileImport">Choisir un fichier...</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Format accepté</label>
                        <p class="text-muted mb-0">
                            <small>
                                <i class="fas fa-check text-success"></i> .xlsx, .xls, .csv<br>
                                <i class="fas fa-check text-success"></i> Taille max: 5MB
                            </small>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Fermer
                    </button>
                    <button type="button" class="btn btn-info">
                        <i class="fas fa-download"></i> Télécharger Modèle
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Importer
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.content-wrapper -->

<!-- Styles CSS Personnalisés -->
<style>
    /* Stats Cards Modernes */
    .stat-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }

    .stat-card .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .stat-card-primary .stat-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-card-success .stat-icon {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .stat-card-warning .stat-icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stat-card-info .stat-icon {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    /* Modern Card */
    .modern-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .modern-card .card-header {
        background: white;
        border-bottom: 2px solid #f0f0f0;
        padding: 1rem 1.5rem;
        border-radius: 12px 12px 0 0;
    }

    /* Table Styles */
    .table thead th {
        border-top: none;
        border-bottom: 2px solid #e9ecef;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    /* Type Icons */
    .type-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }

    .type-entreprise {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .type-particulier {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .type-public {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    /* Client Name */
    .client-name strong {
        color: #2c3e50;
        font-size: 0.95rem;
    }

    .client-meta {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 2px;
    }

    /* Contact Info */
    .contact-info strong {
        color: #2c3e50;
        font-size: 0.9rem;
    }

    .contact-role {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 2px;
    }

    /* Location & Phone */
    .location,
    .phone {
        font-size: 0.9rem;
        color: #495057;
    }

    .location i,
    .phone i {
        margin-right: 4px;
    }

    /* Category Badges */
    .badge-category {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        color: white;
    }

    .badge-a {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .badge-b {
        background: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%);
    }

    .badge-c {
        background: linear-gradient(135deg, #48dbfb 0%, #0abde3 100%);
    }

    /* Status Badges */
    .badge-status {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-actif {
        background: #d4edda;
        color: #155724;
    }

    .badge-prospect {
        background: #fff3cd;
        color: #856404;
    }

    .badge-inactif {
        background: #e2e3e5;
        color: #383d41;
    }

    /* Projects Link */
    .projects-link {
        text-decoration: none;
    }

    .projects-link .badge {
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Action Buttons */
    .btn-group-actions {
        display: flex;
        gap: 4px;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: white;
        font-size: 12px;
        transition: transform 0.2s;
    }

    .btn-action:hover {
        transform: scale(1.1);
    }

    .btn-view {
        background: #17a2b8;
    }

    .btn-edit {
        background: #ffc107;
        color: #212529;
    }

    .btn-delete {
        background: #dc3545;
    }

    /* Custom Checkbox */
    .custom-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    /* Form Labels */
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    /* Modal Headers */
    .modal-header-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0;
    }

    .modal-header-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .modal-header .close {
        color: white;
        opacity: 0.8;
    }

    .modal-header .close:hover {
        opacity: 1;
    }

    /* Pagination Info */
    .pagination-info {
        color: #6c757d;
        font-size: 0.9rem;
        padding-top: 0.5rem;
    }

    /* Custom Select */
    .custom-select {
        border-radius: 6px;
        border: 1px solid #ced4da;
    }

    .custom-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    /* Buttons */
    .btn-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
    }

    .btn-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
</style>