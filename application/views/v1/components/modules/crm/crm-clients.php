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
                                    <h2 class="mb-0 font-weight-bold"><?= $stats['total'] ?? 0 ?></h2>
                                    <?php if (($stats['nouveaux_ce_mois'] ?? 0) > 0): ?>
                                        <small class="text-success">
                                            <i class="fas fa-arrow-up"></i> +<?= $stats['nouveaux_ce_mois'] ?> ce mois
                                        </small>
                                    <?php elseif (($stats['nouveaux_cette_semaine'] ?? 0) > 0): ?>
                                        <small class="text-info">
                                            <i class="fas fa-arrow-right"></i> +<?= $stats['nouveaux_cette_semaine'] ?>
                                            cette semaine
                                        </small>
                                    <?php else: ?>
                                        <small class="text-muted">
                                            <i class="fas fa-minus"></i> Aucun nouveau
                                        </small>
                                    <?php endif; ?>
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
                                    <h2 class="mb-0 font-weight-bold"><?= $stats['actifs'] ?? 0 ?></h2>
                                    <small class="text-muted">
                                        <?= $stats['pourcentage_actifs'] ?? 0 ?>% du total
                                    </small>
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
                                    <h2 class="mb-0 font-weight-bold"><?= $stats['prospects'] ?? 0 ?></h2>
                                    <small class="text-muted">
                                        <?= $stats['pourcentage_prospects'] ?? 0 ?>% du total
                                    </small>
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
                                    <h2 class="mb-0 font-weight-bold"><?= $stats['projets_actifs'] ?? 0 ?></h2>
                                    <small class="text-info">
                                        <i class="fas fa-project-diagram"></i> <?= $stats['total_projets'] ?? 0 ?> total
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
                                <input type="text" class="form-control" placeholder="Rechercher un client..."
                                    id="searchClient">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control custom-select" id="filterType">
                                <option value="">Tous les types</option>
                                <option value="entreprise">Entreprise</option>
                                <option value="particulier">Particulier</option>
                                <option value="public">Secteur Public</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control custom-select" id="filterStatut">
                                <option value="">Tous les statuts</option>
                                <option value="actif">Actif</option>
                                <option value="prospect">Prospect</option>
                                <option value="inactif">Inactif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control custom-select" id="filterCategorie">
                                <option value="">Toutes catégories</option>
                                <option value="A">Catégorie A</option>
                                <option value="B">Catégorie B</option>
                                <option value="C">Catégorie C</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control custom-select" id="filterProjets">
                                <option value="">Nb. Projets</option>
                                <option value="0">Sans projet</option>
                                <option value="1-3">1-3 projets</option>
                                <option value="4+">4+ projets</option>
                            </select>
                        </div>
                    </div>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Clients Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="clientsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" class="custom-checkbox" id="selectAll">
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
                                <?php if (!empty($clients)): ?>
                                    <?php foreach ($clients as $client): ?>
                                        <tr data-type="<?= $client->type_client ?>" data-statut="<?= $client->statut ?>"
                                            data-categorie="<?= $client->categorie ?>"
                                            data-projets="<?= $client->nb_projets ?>">
                                            <td><input type="checkbox" class="custom-checkbox"></td>
                                            <td class="text-center">
                                                <?php if ($client->type_client == 'entreprise'): ?>
                                                    <span class="type-icon type-entreprise" title="Entreprise">
                                                        <i class="fas fa-building"></i>
                                                    </span>
                                                <?php elseif ($client->type_client == 'particulier'): ?>
                                                    <span class="type-icon type-particulier" title="Particulier">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="type-icon type-public" title="Secteur Public">
                                                        <i class="fas fa-landmark"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="client-name">
                                                    <strong><?= htmlspecialchars($client->raison_sociale) ?></strong>
                                                    <?php if ($client->rc): ?>
                                                        <div class="client-meta">RC: <?= htmlspecialchars($client->rc) ?></div>
                                                    <?php elseif ($client->nif): ?>
                                                        <div class="client-meta">NIF: <?= htmlspecialchars($client->nif) ?></div>
                                                    <?php else: ?>
                                                        <div class="client-meta"><?= ucfirst($client->type_client) ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-info">
                                                    <strong><?= htmlspecialchars($client->nom_commercial ?: $client->raison_sociale) ?></strong>
                                                    <div class="contact-role">
                                                        <?= $client->type_client == 'particulier' ? 'Propriétaire' : 'Contact Principal' ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="location">
                                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                                    <?= htmlspecialchars($client->ville) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="phone">
                                                    <i class="fas fa-phone text-success"></i>
                                                    <?= htmlspecialchars($client->telephone) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge-category badge-<?= strtolower($client->categorie) ?>">
                                                    <?= strtoupper($client->categorie) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($client->statut == 'actif'): ?>
                                                    <span class="badge-status badge-actif">
                                                        <i class="fas fa-check-circle"></i> Actif
                                                    </span>
                                                <?php elseif ($client->statut == 'prospect'): ?>
                                                    <span class="badge-status badge-prospect">
                                                        <i class="fas fa-clock"></i> Prospect
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge-status badge-inactif">
                                                        <i class="fas fa-pause-circle"></i> Inactif
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($client->nb_projets > 0): ?>
                                                    <a href="#" class="projects-link" data-client-id="<?= $client->id ?>">
                                                        <span class="badge badge-primary">
                                                            <i class="fas fa-project-diagram"></i> <?= $client->nb_projets ?>
                                                            projet<?= $client->nb_projets > 1 ? 's' : '' ?>
                                                        </span>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">
                                                        <i class="fas fa-project-diagram"></i> 0 projet
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group-actions">
                                                    <button type="button" class="btn-action btn-view" title="Voir"
                                                        onclick="viewClient(<?= $client->id ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn-action btn-edit" title="Modifier"
                                                        onclick="editClient(<?= $client->id ?>)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn-action btn-delete" title="Supprimer"
                                                        onclick="deleteClient(<?= $client->id ?>, '<?= htmlspecialchars($client->raison_sociale) ?>')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-5">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Aucun client trouvé</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div class="pagination-info">
                                Affichage de <strong>1 à <?= count($clients) ?></strong> sur
                                <strong><?= count($clients) ?></strong> clients
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
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <style>
        .info-box-custom {
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #17a2b8;
            margin-bottom: 10px;
            min-height: 70px;
        }

        .info-box-custom label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-box-custom p {
            font-size: 1rem;
            color: #333;
        }

        .badge-lg {
            font-size: 0.9rem;
            padding: 6px 12px;
        }

        #modalViewClient .modal-header {
            border-radius: 0;
        }

        #modalViewClient .modal-content {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .type-icon-large {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }

        .type-icon-large.entreprise {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .type-icon-large.particulier {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }

        .type-icon-large.public {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }
    </style>

    <!-- Modal Voir Client -->
    <div class="modal fade" id="modalViewClient" tabindex="-1" role="dialog" aria-labelledby="modalViewClientLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h4 class="modal-title" id="modalViewClientLabel">
                        <i class="fas fa-eye"></i> Détails du Client
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- En-tête avec type et catégorie -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                <div class="d-flex align-items-center">
                                    <div id="view_type_icon" class="mr-3" style="font-size: 2rem;"></div>
                                    <div>
                                        <h4 class="mb-0 font-weight-bold" id="view_raison_sociale"></h4>
                                        <small class="text-muted" id="view_nom_commercial"></small>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span id="view_categorie_badge" class="badge badge-lg mr-2"></span>
                                    <span id="view_statut_badge" class="badge badge-lg"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations Générales -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-info-circle"></i> Informations Générales
                            </h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-box-custom">
                                <label class="text-muted small">Type de Client</label>
                                <p class="mb-0 font-weight-bold" id="view_type_client"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box-custom">
                                <label class="text-muted small">Catégorie</label>
                                <p class="mb-0 font-weight-bold" id="view_categorie"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-address-book"></i> Contact
                            </h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-box-custom">
                                <label class="text-muted small">
                                    <i class="fas fa-envelope text-info"></i> Email
                                </label>
                                <p class="mb-0" id="view_email"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box-custom">
                                <label class="text-muted small">
                                    <i class="fas fa-phone text-success"></i> Téléphone
                                </label>
                                <p class="mb-0" id="view_telephone"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Adresse -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-map-marker-alt"></i> Adresse
                            </h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-box-custom">
                                <label class="text-muted small">Adresse</label>
                                <p class="mb-0" id="view_adresse"></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box-custom">
                                <label class="text-muted small">Ville</label>
                                <p class="mb-0 font-weight-bold" id="view_ville"></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box-custom">
                                <label class="text-muted small">Code Postal</label>
                                <p class="mb-0" id="view_code_postal"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-box-custom">
                                <label class="text-muted small">Pays</label>
                                <p class="mb-0" id="view_pays"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Informations Fiscales -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-file-invoice"></i> Informations Fiscales
                            </h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="info-box-custom">
                                <label class="text-muted small">RC (Registre Commerce)</label>
                                <p class="mb-0 font-weight-bold" id="view_rc"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box-custom">
                                <label class="text-muted small">NIF</label>
                                <p class="mb-0 font-weight-bold" id="view_nif"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box-custom">
                                <label class="text-muted small">AIS</label>
                                <p class="mb-0 font-weight-bold" id="view_ais"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Projets Associés -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-project-diagram"></i> Projets Associés
                            </h6>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="info-box-custom">
                                <label class="text-muted small">Nombre de projets</label>
                                <p class="mb-0">
                                    <span id="view_nb_projets" class="badge badge-primary badge-lg"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Métadonnées -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-secondary py-2">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> Créé le : <strong id="view_created_at"></strong>
                                    &nbsp;|&nbsp;
                                    <i class="fas fa-sync"></i> Mis à jour le : <strong id="view_updated_at"></strong>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Fermer
                    </button>
                    <button type="button" class="btn btn-warning" id="btn_edit_from_view">
                        <i class="fas fa-edit"></i> Modifier
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts pour les filtres -->
    <script>
        $(document).ready(function() {
            // Filtrer par type
            $('#filterType').on('change', function() {
                filterTable();
            });

            // Filtrer par statut
            $('#filterStatut').on('change', function() {
                filterTable();
            });

            // Filtrer par catégorie
            $('#filterCategorie').on('change', function() {
                filterTable();
            });

            // Filtrer par nombre de projets
            $('#filterProjets').on('change', function() {
                filterTable();
            });

            // Recherche textuelle
            $('#searchClient').on('keyup', function() {
                filterTable();
            });

            function filterTable() {
                var type = $('#filterType').val().toLowerCase();
                var statut = $('#filterStatut').val().toLowerCase();
                var categorie = $('#filterCategorie').val().toLowerCase();
                var projets = $('#filterProjets').val();
                var search = $('#searchClient').val().toLowerCase();

                $('#clientsTable tbody tr').each(function() {
                    var rowType = $(this).data('type').toLowerCase();
                    var rowStatut = $(this).data('statut').toLowerCase();
                    var rowCategorie = $(this).data('categorie').toLowerCase();
                    var rowProjets = $(this).data('projets');
                    var rowText = $(this).text().toLowerCase();

                    var showRow = true;

                    if (type && rowType !== type) showRow = false;
                    if (statut && rowStatut !== statut) showRow = false;
                    if (categorie && rowCategorie !== categorie) showRow = false;

                    if (projets === '0' && rowProjets !== 0) showRow = false;
                    if (projets === '1-3' && (rowProjets < 1 || rowProjets > 3)) showRow = false;
                    if (projets === '4+' && rowProjets < 4) showRow = false;

                    if (search && rowText.indexOf(search) === -1) showRow = false;

                    $(this).toggle(showRow);
                });
            }

            // Select all checkbox
            $('#selectAll').on('change', function() {
                var isChecked = $(this).is(':checked');
                $('.custom-checkbox').prop('checked', isChecked);
            });
        });
    </script>

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
                <form method="post" action="<?= base_url('crm-clients-add') ?>" id="formNewClient">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type de Client <span class="text-danger">*</span></label>
                                    <select name="type_client" class="form-control select2" required>
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
                                    <select name="categorie" class="form-control select2">
                                        <option value="C">Catégorie C</option>
                                        <option value="B">Catégorie B</option>
                                        <option value="A">Catégorie A</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Raison Sociale / Nom <span class="text-danger">*</span></label>
                            <input type="text" name="raison_sociale" class="form-control"
                                placeholder="Ex: SARL Bâtiment Plus" required>
                        </div>

                        <div class="form-group">
                            <label>Nom Commercial</label>
                            <input type="text" name="nom_commercial" class="form-control"
                                placeholder="Ex: Bâtiment Plus">
                        </div>

                        <div class="form-group">
                            <label>Projet Associé</label>
                            <select name="projet_id" class="form-control select2"
                                data-placeholder="Sélectionner un projet...">
                                <option value="">Aucun projet</option>
                                <?php foreach ($projects as $project): ?>
                                    <option value="<?= $project->id ?>"><?= $project->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Liez ce client à un projet existant (optionnel)
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="contact@exemple.dz">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Téléphone <span class="text-danger">*</span></label>
                                    <input type="tel" name="telephone" class="form-control" placeholder="021 12 34 56"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Adresse</label>
                            <textarea name="adresse" class="form-control" rows="2"
                                placeholder="Adresse complète"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ville <span class="text-danger">*</span></label>
                                    <input type="text" name="ville" class="form-control" placeholder="Alger" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Code Postal</label>
                                    <input type="text" name="code_postal" class="form-control" placeholder="16000">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pays</label>
                                    <input type="text" name="pays" class="form-control" value="Algérie">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>RC (Registre Commerce)</label>
                                    <input type="text" name="rc" class="form-control" placeholder="16/00-0123456B">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>NIF</label>
                                    <input type="text" name="nif" class="form-control" placeholder="001234567890123">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>AIS</label>
                                    <input type="text" name="ais" class="form-control" placeholder="123456789">
                                </div>
                            </div>
                        </div>

                        <!-- Champs cachés pour le statut par défaut -->
                        <input type="hidden" name="statut" value="prospect">
                        <input type="hidden" name="created_by" value="<?= $this->session->userdata('user_id') ?? 1 ?>">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Stockage des données clients en JSON pour accès rapide
        var clientsData = <?= json_encode($clients) ?>;

        // Fonction pour ouvrir le modal de modification et pré-remplir le formulaire
        function editClient(clientId) {
            // Trouver le client dans les données
            var client = null;
            for (var i = 0; i < clientsData.length; i++) {
                if (clientsData[i].id == clientId) {
                    client = clientsData[i];
                    break;
                }
            }

            if (!client) {
                alert('Client non trouvé !');
                return;
            }

            // Remplir le formulaire avec les données du client
            $('#edit_client_id').val(client.id);
            $('#edit_type_client').val(client.type_client).trigger('change');
            $('#edit_categorie').val(client.categorie).trigger('change');
            $('#edit_raison_sociale').val(client.raison_sociale);
            $('#edit_nom_commercial').val(client.nom_commercial || '');
            $('#edit_projet_id').val(client.projet_id || '').trigger('change');
            $('#edit_email').val(client.email || '');
            $('#edit_telephone').val(client.telephone);
            $('#edit_adresse').val(client.adresse || '');
            $('#edit_ville').val(client.ville);
            $('#edit_code_postal').val(client.code_postal || '');
            $('#edit_pays').val(client.pays || 'Algérie');
            $('#edit_rc').val(client.rc || '');
            $('#edit_nif').val(client.nif || '');
            $('#edit_ais').val(client.ais || '');
            $('#edit_statut').val(client.statut || 'prospect').trigger('change');

            // Ouvrir le modal
            $('#modalEditClient').modal('show');
        }

        // Fonction pour voir les détails d'un client
        function viewClient(clientId) {
            // Trouver le client dans les données
            var client = null;
            for (var i = 0; i < clientsData.length; i++) {
                if (clientsData[i].id == clientId) {
                    client = clientsData[i];
                    break;
                }
            }

            if (!client) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Client non trouvé !',
                    timer: 2000,
                    toast: true,
                    position: 'top-end'
                });
                return;
            }

            // ===== EN-TÊTE =====
            // Icône selon le type
            var typeIcon = '';
            var typeLabel = '';
            var typeClass = '';

            if (client.type_client === 'entreprise') {
                typeIcon = '<i class="fas fa-building"></i>';
                typeLabel = 'Entreprise';
                typeClass = 'entreprise';
            } else if (client.type_client === 'particulier') {
                typeIcon = '<i class="fas fa-user"></i>';
                typeLabel = 'Particulier';
                typeClass = 'particulier';
            } else {
                typeIcon = '<i class="fas fa-landmark"></i>';
                typeLabel = 'Secteur Public';
                typeClass = 'public';
            }

            $('#view_type_icon').html('<div class="type-icon-large ' + typeClass + '">' + typeIcon + '</div>');
            $('#view_raison_sociale').text(client.raison_sociale);
            $('#view_nom_commercial').text(client.nom_commercial ? 'Nom commercial : ' + client.nom_commercial : '');

            // Badges catégorie et statut
            var catClass = client.categorie === 'A' ? 'badge-danger' : (client.categorie === 'B' ? 'badge-warning' :
                'badge-info');
            $('#view_categorie_badge').attr('class', 'badge badge-lg ' + catClass)
                .text('Catégorie ' + client.categorie);

            var statutClass = '';
            var statutIcon = '';
            if (client.statut === 'actif') {
                statutClass = 'badge-success';
                statutIcon = '<i class="fas fa-check-circle"></i> ';
            } else if (client.statut === 'prospect') {
                statutClass = 'badge-warning';
                statutIcon = '<i class="fas fa-clock"></i> ';
            } else {
                statutClass = 'badge-secondary';
                statutIcon = '<i class="fas fa-pause-circle"></i> ';
            }
            $('#view_statut_badge').attr('class', 'badge badge-lg ' + statutClass)
                .html(statutIcon + client.statut.charAt(0).toUpperCase() + client.statut.slice(1));

            // ===== INFORMATIONS GÉNÉRALES =====
            $('#view_type_client').text(typeLabel);
            $('#view_categorie').text('Catégorie ' + client.categorie);

            // ===== CONTACT =====
            $('#view_email').html(client.email ? '<a href="mailto:' + client.email + '">' + client.email + '</a>' :
                '<em class="text-muted">Non renseigné</em>');
            $('#view_telephone').html(client.telephone ? '<a href="tel:' + client.telephone + '">' + client.telephone +
                '</a>' : '<em class="text-muted">Non renseigné</em>');

            // ===== ADRESSE =====
            $('#view_adresse').text(client.adresse || 'Non renseignée');
            $('#view_ville').text(client.ville || '-');
            $('#view_code_postal').text(client.code_postal || '-');
            $('#view_pays').text(client.pays || 'Algérie');

            // ===== INFORMATIONS FISCALES =====
            $('#view_rc').text(client.rc || 'Non renseigné');
            $('#view_nif').text(client.nif || 'Non renseigné');
            $('#view_ais').text(client.ais || 'Non renseigné');

            // ===== PROJETS =====
            var nbProjets = parseInt(client.nb_projets) || 0;
            var projetBadgeClass = nbProjets === 0 ? 'badge-secondary' : (nbProjets <= 3 ? 'badge-primary' :
                'badge-success');
            $('#view_nb_projets').attr('class', 'badge badge-lg ' + projetBadgeClass)
                .html('<i class="fas fa-project-diagram"></i> ' + nbProjets + ' projet' + (nbProjets > 1 ? 's' : ''));

            // ===== MÉTADONNÉES =====
            $('#view_created_at').text(client.created_at ? formatDate(client.created_at) : '-');
            $('#view_updated_at').text(client.updated_at ? formatDate(client.updated_at) : '-');

            // ===== BOUTON MODIFIER =====
            $('#btn_edit_from_view').off('click').on('click', function() {
                $('#modalViewClient').modal('hide');
                setTimeout(function() {
                    editClient(clientId);
                }, 300);
            });

            // ===== OUVRIR LE MODAL =====
            $('#modalViewClient').modal('show');
        }

        // Fonction utilitaire pour formater la date
        function formatDate(dateString) {
            if (!dateString) return '-';
            var date = new Date(dateString);
            var options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            return date.toLocaleDateString('fr-FR', options);
        }

        // Fonction pour supprimer un client avec SweetAlert2
        function deleteClient(clientId, clientName) {
            Swal.fire({
                title: 'Confirmer la suppression',
                html: `Êtes-vous sûr de vouloir supprimer le client <strong>${clientName}</strong> ?<br>
               <small class="text-muted">Cette action est irréversible.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash"></i> Oui, supprimer',
                cancelButtonText: '<i class="fas fa-times"></i> Annuler',
                reverseButtons: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Afficher un loading pendant la suppression
                    Swal.fire({
                        title: 'Suppression en cours...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Rediriger vers la suppression
                    window.location.href = '<?= base_url("crm-clients-delete/") ?>' + clientId;
                }
            });
        }

        // Initialisation des select2 dans le modal
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>

    <!-- Modal Modifier Client -->
    <div class="modal fade" id="modalEditClient" tabindex="-1" role="dialog" aria-labelledby="modalEditClientLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title" id="modalEditClientLabel">
                        <i class="fas fa-edit"></i> Modifier Client
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('crm-clients-update') ?>" id="formEditClient">
                    <div class="modal-body">
                        <!-- ID caché -->
                        <input type="hidden" name="client_id" id="edit_client_id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type de Client <span class="text-danger">*</span></label>
                                    <select name="type_client" id="edit_type_client" class="form-control select2"
                                        required>
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
                                    <select name="categorie" id="edit_categorie" class="form-control select2">
                                        <option value="C">Catégorie C</option>
                                        <option value="B">Catégorie B</option>
                                        <option value="A">Catégorie A</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Raison Sociale / Nom <span class="text-danger">*</span></label>
                            <input type="text" name="raison_sociale" id="edit_raison_sociale" class="form-control"
                                placeholder="Ex: SARL Bâtiment Plus" required>
                        </div>

                        <div class="form-group">
                            <label>Nom Commercial</label>
                            <input type="text" name="nom_commercial" id="edit_nom_commercial" class="form-control"
                                placeholder="Ex: Bâtiment Plus">
                        </div>

                        <div class="form-group">
                            <label>Projet Associé</label>
                            <select name="projet_id" id="edit_projet_id" class="form-control select2"
                                data-placeholder="Sélectionner un projet...">
                                <option value="">Aucun projet</option>
                                <?php foreach ($projects as $project): ?>
                                    <option value="<?= $project->id ?>"><?= $project->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Liez ce client à un projet existant (optionnel)
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" id="edit_email" class="form-control"
                                        placeholder="contact@exemple.dz">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Téléphone <span class="text-danger">*</span></label>
                                    <input type="tel" name="telephone" id="edit_telephone" class="form-control"
                                        placeholder="021 12 34 56" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Adresse</label>
                            <textarea name="adresse" id="edit_adresse" class="form-control" rows="2"
                                placeholder="Adresse complète"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ville <span class="text-danger">*</span></label>
                                    <input type="text" name="ville" id="edit_ville" class="form-control"
                                        placeholder="Alger" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Code Postal</label>
                                    <input type="text" name="code_postal" id="edit_code_postal" class="form-control"
                                        placeholder="16000">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pays</label>
                                    <input type="text" name="pays" id="edit_pays" class="form-control" value="Algérie">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>RC (Registre Commerce)</label>
                                    <input type="text" name="rc" id="edit_rc" class="form-control"
                                        placeholder="16/00-0123456B">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>NIF</label>
                                    <input type="text" name="nif" id="edit_nif" class="form-control"
                                        placeholder="001234567890123">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>AIS</label>
                                    <input type="text" name="ais" id="edit_ais" class="form-control"
                                        placeholder="123456789">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select name="statut" id="edit_statut" class="form-control select2">
                                        <option value="prospect">Prospect</option>
                                        <option value="actif">Actif</option>
                                        <option value="inactif">Inactif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



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