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
                            <span class="info-box-number"><?= $stats['total'] ?? 0 ?></span>
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
                            <span class="info-box-number"><?= $stats['en_cours'] ?? 0 ?></span>
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
                            <span class="info-box-number"><?= $stats['planifies'] ?? 0 ?></span>
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
                            <span class="info-box-number"><?= $stats['termines'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>
            </div>

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
                                <?php if (!empty($projects)): ?>
                                <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item">
                                    </td>
                                    <td><strong><?= htmlspecialchars($project->reference ?? 'PROJ-' . $project->id) ?></strong>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($project->name) ?></strong><br>
                                        <small class="text-muted">
                                            <?php
                                                    $dateDebut = isset($project->created_at) ? date('d/m/Y', strtotime($project->created_at)) : '-';
                                                    echo 'Début: ' . $dateDebut;
                                                    ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php if ($project->client_name): ?>
                                        <i
                                            class="fas fa-<?= $project->type_client == 'public' ? 'landmark' : 'building' ?> text-primary"></i>
                                        <?= htmlspecialchars($project->client_name) ?>
                                        <?php else: ?>
                                        <em class="text-muted">Non assigné</em>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= number_format($project->montant ?? 0, 0, ',', ' ') ?> DA</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-hard-hat"></i> <?= $project->nb_chantiers ?>
                                            chantier<?= $project->nb_chantiers > 1 ? 's' : '' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <?php
                                                    $avancement = round($project->avg_avancement);
                                                    $bgClass = $avancement == 100 ? 'bg-success' : ($avancement > 0 ? 'bg-success' : '');
                                                    ?>
                                            <div class="progress-bar <?= $bgClass ?>"
                                                style="width: <?= $avancement ?>%"></div>
                                        </div>
                                        <small><?= $avancement ?>%</small>
                                    </td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <?php
                                                    $montantTotal = $project->montant ?? 0;
                                                    $totalDecaisse = $project->total_decaisse ?? 0;
                                                    $pourcentageDecaisse = $montantTotal > 0 ? round(($totalDecaisse / $montantTotal) * 100) : 0;
                                                    $bgColor = $pourcentageDecaisse >= 80 ? 'bg-success' : ($pourcentageDecaisse >= 50 ? 'bg-info' : 'bg-warning');
                                                    ?>
                                            <div class="progress-bar <?= $bgColor ?>"
                                                style="width: <?= $pourcentageDecaisse ?>%"></div>
                                        </div>
                                        <small><?= $pourcentageDecaisse ?>%</small>
                                    </td>
                                    <td>
                                        <?php
                                                $statusClass = '';
                                                $statusIcon = '';
                                                switch ($project->status) {
                                                    case 'En cours':
                                                        $statusClass = 'badge-success';
                                                        $statusIcon = '<i class="fas fa-sync fa-spin"></i>';
                                                        break;
                                                    case 'Planifié':
                                                        $statusClass = 'badge-warning';
                                                        $statusIcon = '<i class="fas fa-clock"></i>';
                                                        break;
                                                    case 'Terminé':
                                                        $statusClass = 'badge-info';
                                                        $statusIcon = '<i class="fas fa-check-circle"></i>';
                                                        break;
                                                    default:
                                                        $statusClass = 'badge-secondary';
                                                        $statusIcon = '<i class="fas fa-circle"></i>';
                                                }
                                                ?>
                                        <span class="badge <?= $statusClass ?>">
                                            <?= $statusIcon ?> <?= htmlspecialchars($project->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Voir détails"
                                                onclick="viewProject(<?= $project->id ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" title="Ajouter chantier"
                                                onclick="addChantier(<?= $project->id ?>, '<?= htmlspecialchars($project->name) ?>')">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" title="Contrat">
                                                <i class="fas fa-file-contract"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-5">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>Aucun projet trouvé</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal Ajouter Chantier -->
                    <div class="modal fade" id="modalAddChantier" tabindex="-1" role="dialog"
                        aria-labelledby="modalAddChantierLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h4 class="modal-title" id="modalAddChantierLabel">
                                        <i class="fas fa-hard-hat"></i> Ajouter un Chantier
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="<?= base_url('crm-chantiers-add') ?>" id="formAddChantier">
                                    <div class="modal-body">
                                        <!-- Info Projet -->
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i>
                                            Projet : <strong id="chantier_projet_name"></strong>
                                        </div>
                                        <input type="hidden" name="projet_id" id="chantier_projet_id">

                                        <div class="form-group">
                                            <label>Nom du Chantier <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Ex: Bâtiment Principal" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Localisation</label>
                                                    <input type="text" name="location" class="form-control"
                                                        placeholder="Ex: Oran - Campus Universitaire">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Chef de Chantier</label>
                                                    <input type="text" name="chef_chantier" class="form-control"
                                                        placeholder="Nom du responsable">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Date de Début</label>
                                                    <input type="date" name="date_debut" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Date de Fin Prévue</label>
                                                    <input type="date" name="date_fin_prevue" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Statut</label>
                                                    <select name="status" class="form-control select2">
                                                        <option value="Planifié">Planifié</option>
                                                        <option value="En cours">En cours</option>
                                                        <option value="Terminé">Terminé</option>
                                                        <option value="Suspendu">Suspendu</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Budget (DA)</label>
                                                    <input type="number" name="budget" class="form-control"
                                                        placeholder="0.00" step="0.01" min="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Avancement Initial (%)</label>
                                                    <input type="number" name="avancement" class="form-control"
                                                        placeholder="0" min="0" max="100" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            <i class="fas fa-times"></i> Annuler
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> Enregistrer le Chantier
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- SweetAlert2 JS -->
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                    // Fonction pour ouvrir directement le modal d'ajout de chantier
                    function addChantier(projectId, projectName) {
                        // Remplir les infos du projet dans le modal
                        $('#chantier_projet_id').val(projectId);
                        $('#chantier_projet_name').text(projectName);

                        // Réinitialiser le formulaire
                        $('#formAddChantier')[0].reset();

                        // Remettre le projet_id après le reset (car reset() efface tout)
                        $('#chantier_projet_id').val(projectId);

                        // Ouvrir directement le modal
                        $('#modalAddChantier').modal('show');
                    }
                    </script>

                    <!-- Pagination -->
                    <div class="row mt-3">
                        <div class="col-sm-5">
                            <div class="dataTables_info">
                                Affichage de 1 à <?= count($projects) ?> sur <?= count($projects) ?> projets
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

    <script>
    // Stockage des données projets
    var projectsData = <?= json_encode($projects) ?>;

    // Fonction pour voir un projet
    function viewProject(projectId) {
        // Trouver le projet
        var project = null;
        for (var i = 0; i < projectsData.length; i++) {
            if (projectsData[i].id == projectId) {
                project = projectsData[i];
                break;
            }
        }

        if (project) {
            // Redirection vers la page de détail ou ouverture d'un modal
            alert('Voir détails du projet: ' + project.name);
            // window.location.href = '<?= base_url("projets-view/") ?>' + projectId;
        }
    }

    // Fonction pour ajouter un chantier
    function addChantier(projectId, projectName) {
        Swal.fire({
            title: 'Ajouter un chantier',
            text: 'Projet: ' + projectName,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Continuer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Remplir les infos du projet dans le modal
                $('#chantier_projet_id').val(projectId);
                $('#chantier_projet_name').text(projectName);

                // Réinitialiser le formulaire
                $('#formAddChantier')[0].reset();

                // Réinjecter le projet_id après le reset
                $('#chantier_projet_id').val(projectId);

                // Ouvrir le modal avec le formulaire
                $('#modalAddChantier').modal('show');
            }
        });
    }

    // Initialisation
    $(document).ready(function() {
        // Activer DataTables si disponible
        if ($.fn.DataTable) {
            $('.dataTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr.json"
                },
                "pageLength": 10,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Tous"]
                ],
                "order": [
                    [1, 'desc']
                ]
            });
        }

        // Select2 pour les filtres
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Sélectionner...',
            allowClear: true
        });
    });
    </script>

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