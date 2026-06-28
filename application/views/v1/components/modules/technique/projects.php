<!-- Content Wrapper -->
<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <style>
            .satraco-card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
                overflow: hidden;
            }

            .satraco-stat {
                border-radius: 16px;
                padding: 20px;
                color: #fff;
                min-height: 120px;
                position: relative;
                overflow: hidden;
            }

            .satraco-stat i {
                position: absolute;
                right: 18px;
                bottom: 12px;
                font-size: 55px;
                opacity: .20;
            }

            .stat-green {
                background: linear-gradient(135deg, #0f766e, #74c476);
            }

            .stat-blue {
                background: linear-gradient(135deg, #102033, #2563eb);
            }

            .stat-orange {
                background: linear-gradient(135deg, #b45309, #f59e0b);
            }

            .stat-red {
                background: linear-gradient(135deg, #7f1d1d, #ef4444);
            }

            .satraco-title {
                font-weight: 800;
                color: #102033;
            }

            .btn-satraco {
                background: #0f766e;
                color: #fff;
                border-radius: 10px;
                font-weight: 700;
            }

            .btn-satraco:hover {
                background: #0b5f59;
                color: #fff;
            }

            .table thead th {
                background: #102033;
                color: #fff;
                border: none;
                font-size: 13px;
                vertical-align: middle;
            }

            .table td {
                vertical-align: middle;
                font-size: 13px;
            }

            .project-ref {
                font-weight: 800;
                color: #0f766e;
            }

            .progress {
                height: 9px;
                border-radius: 20px;
            }

            .badge-status {
                padding: 7px 10px;
                border-radius: 20px;
                font-size: 12px;
            }

            .action-btn {
                border-radius: 8px;
                margin: 2px;
            }

            .filter-box {
                background: #fff;
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
            }

            .summary-card {
                border-radius: 16px;
                background: #fff;
                padding: 18px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .07);
                border-left: 5px solid #0f766e;
            }

            .timeline-item-project {
                border-left: 3px solid #0f766e;
                padding-left: 12px;
                margin-bottom: 16px;
            }

            .deadline-danger {
                background: #fee2e2;
                color: #991b1b;
                padding: 10px;
                border-radius: 12px;
                margin-bottom: 10px;
                font-size: 13px;
            }

            .deadline-warning {
                background: #fef3c7;
                color: #92400e;
                padding: 10px;
                border-radius: 12px;
                margin-bottom: 10px;
                font-size: 13px;
            }

            .modal-header-satraco {
                background: linear-gradient(135deg, #102033, #0f766e);
                color: #fff;
            }
            </style>

            <!-- Statistiques -->
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="satraco-stat stat-green">
                        <h6>Total projets</h6>
                        <h2 class="font-weight-bold">25</h2>
                        <small>Projets enregistrés</small>
                        <i class="fas fa-project-diagram"></i>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="satraco-stat stat-orange">
                        <h6>En cours</h6>
                        <h2 class="font-weight-bold">14</h2>
                        <small>Projets actifs</small>
                        <i class="fas fa-hard-hat"></i>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="satraco-stat stat-blue">
                        <h6>Terminés</h6>
                        <h2 class="font-weight-bold">8</h2>
                        <small>Projets clôturés</small>
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="satraco-stat stat-red">
                        <h6>Suspendus</h6>
                        <h2 class="font-weight-bold">3</h2>
                        <small>Projets arrêtés</small>
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>

            </div>

            <!-- Barre d'action -->
            <div class="filter-box mb-4">
                <div class="row align-items-end">

                    <div class="col-md-2 mb-2">
                        <button class="btn btn-satraco btn-block" data-toggle="modal" data-target="#addProjectModal">
                            <i class="fas fa-plus-circle"></i> Nouveau Projet
                        </button>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>Recherche</label>
                        <input type="text" class="form-control" placeholder="Nom ou référence">
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>Chef projet</label>
                        <select class="form-control">
                            <option>Tous</option>
                            <option>Axcel Irutavoyose</option>
                            <option>Jean Claude</option>
                            <option>Patrick N.</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>Client</label>
                        <select class="form-control">
                            <option>Tous</option>
                            <option>SATRACO</option>
                            <option>Ministère TP</option>
                            <option>Client privé</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>Statut</label>
                        <select class="form-control">
                            <option>Tous</option>
                            <option>Planifié</option>
                            <option>En cours</option>
                            <option>Terminé</option>
                            <option>Suspendu</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <button class="btn btn-dark btn-block">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>

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

            <div class="row">

                <!-- Tableau projets -->
                <div class="col-lg-9">

                    <div class="card satraco-card">
                        <div class="card-header bg-white">
                            <h3 class="card-title satraco-title">
                                <i class="fas fa-list mr-2"></i>
                                Liste des projets
                            </h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Réf.</th>
                                        <th>Projet</th>
                                        <th>Client</th>
                                        <th>Chef Projet</th>
                                        <th>Budget</th>
                                        <th>Avancement</th>
                                        <th>Début</th>
                                        <th>Fin prévue</th>
                                        <th>Statut</th>
                                        <th style="width:180px;">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php if (!empty($allProject)) : ?>

                                    <?php foreach ($allProject as $project) : ?>

                                    <tr>

                                        <!-- Référence -->
                                        <td>
                                            <span class="project-ref">
                                                <?= $project->reference ?>
                                            </span>
                                        </td>

                                        <!-- Projet -->
                                        <td>
                                            <strong><?= $project->name ?></strong>
                                        </td>

                                        <!-- Client -->
                                        <td>
                                            -
                                        </td>

                                        <!-- Chef Projet -->
                                        <td>
                                            -
                                        </td>

                                        <!-- Budget -->
                                        <td>
                                            -
                                        </td>

                                        <!-- Avancement -->
                                        <td width="180">

                                            <strong>0 %</strong>

                                            <div class="progress mt-1">

                                                <div class="progress-bar bg-secondary" style="width:0%">
                                                </div>

                                            </div>

                                        </td>

                                        <!-- Début -->
                                        <td>
                                            -
                                        </td>

                                        <!-- Fin prévue -->
                                        <td>
                                            -
                                        </td>

                                        <!-- Statut -->
                                        <td>

                                            <?php

                                                    switch ($project->status) {

                                                        case 'Planifié':
                                                            echo '<span class="badge badge-primary badge-status">Planifié</span>';
                                                            break;

                                                        case 'En cours':
                                                            echo '<span class="badge badge-warning badge-status">En cours</span>';
                                                            break;

                                                        case 'Terminé':
                                                            echo '<span class="badge badge-success badge-status">Terminé</span>';
                                                            break;

                                                        case 'Suspendu':
                                                            echo '<span class="badge badge-danger badge-status">Suspendu</span>';
                                                            break;

                                                        default:
                                                            echo '<span class="badge badge-secondary">' . $project->status . '</span>';
                                                    }

                                                    ?>

                                        </td>

                                        <!-- Actions -->
                                        <td>

                                            <button class="btn btn-info btn-sm action-btn"
                                                onclick="viewProject(<?= $project->id ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button class="btn btn-primary btn-sm action-btn"
                                                onclick="editProject(<?= $project->id ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button class="btn btn-success btn-sm action-btn">
                                                <i class="fas fa-tasks"></i>
                                            </button>

                                            <button class="btn btn-secondary btn-sm action-btn">
                                                <i class="fas fa-print"></i>
                                            </button>

                                            <button class="btn btn-danger btn-sm action-btn"
                                                onclick="deleteProject(<?= $project->id ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </td>

                                    </tr>

                                    <?php endforeach; ?>

                                    <?php else : ?>

                                    <tr>

                                        <td colspan="10" class="text-center">

                                            <div class="alert alert-warning mb-0">

                                                <i class="fas fa-folder-open mr-2"></i>

                                                Aucun projet enregistré.

                                            </div>

                                        </td>

                                    </tr>

                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Résumé financier -->
                    <div class="row mt-4">

                        <div class="col-md-3 mb-3">
                            <div class="summary-card">
                                <small>Budget total</small>
                                <h5 class="font-weight-bold">12 500 000 000</h5>
                                <small>FBu</small>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="summary-card">
                                <small>Dépenses</small>
                                <h5 class="font-weight-bold text-danger">8 300 000 000</h5>
                                <small>FBu</small>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="summary-card">
                                <small>Reste</small>
                                <h5 class="font-weight-bold text-success">4 200 000 000</h5>
                                <small>FBu</small>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="summary-card">
                                <small>Rentabilité</small>
                                <h5 class="font-weight-bold text-primary">66%</h5>
                                <small>Moyenne globale</small>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Bloc droite -->
                <div class="col-lg-3">

                    <div class="card satraco-card mb-4">
                        <div class="card-header bg-white">
                            <h3 class="card-title satraco-title">
                                <i class="fas fa-clock mr-2"></i>
                                Derniers projets
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="timeline-item-project">
                                <strong>Construction Route RN3</strong><br>
                                <small>Aujourd'hui</small>
                            </div>

                            <div class="timeline-item-project">
                                <strong>Réhabilitation Pont Ruziba</strong><br>
                                <small>Hier</small>
                            </div>

                            <div class="timeline-item-project">
                                <strong>Bâtiment Administratif</strong><br>
                                <small>12 Juin 2026</small>
                            </div>
                        </div>
                    </div>

                    <div class="card satraco-card">
                        <div class="card-header bg-white">
                            <h3 class="card-title satraco-title">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Échéances proches
                            </h3>
                        </div>

                        <div class="card-body">

                            <div class="deadline-warning">
                                <strong>Fin dans 5 jours</strong><br>
                                Réhabilitation Pont Ruziba
                            </div>

                            <div class="deadline-warning">
                                <strong>Fin dans 8 jours</strong><br>
                                Extension Dépôt Matériel
                            </div>

                            <div class="deadline-danger">
                                <strong>Dépassé</strong><br>
                                Travaux secondaires RN3
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
</div>


<div class="modal fade" id="editProjectModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header modal-header-satraco">

                <h5>

                    <i class="fas fa-edit"></i>

                    Modifier le projet

                </h5>

                <button class="close text-white" data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <form action="<?= base_url('tech/project-update') ?>" method="post">

                <div class="modal-body">

                    <input type="hidden" name="id" id="edit_id">

                    <div class="row">

                        <div class="col-md-4">

                            <label>Référence</label>

                            <input type="text" class="form-control" id="edit_reference" name="reference" readonly>

                        </div>

                        <div class="col-md-4">

                            <label>Nom du projet</label>

                            <input type="text" class="form-control" id="edit_name" name="name">

                        </div>

                        <div class="col-md-4">

                            <label>Statut</label>

                            <select class="form-control" id="edit_status" name="status">

                                <option>Planifié</option>
                                <option>En cours</option>
                                <option>Terminé</option>
                                <option>Suspendu</option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary" data-dismiss="modal">

                        Annuler

                    </button>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Modifier
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
function editProject(id) {

    $.ajax({

        url: "<?= base_url('tech/project-edit-ajax') ?>",

        type: "POST",

        data: {

            id: id

        },

        dataType: "json",

        success: function(project) {

            $("#edit_id").val(project.id);

            $("#edit_reference").val(project.reference);

            $("#edit_name").val(project.name);

            $("#edit_status").val(project.status);

            $("#editProjectModal").modal("show");

        }

    });

}
</script>

<!-- Modal Ajouter Projet -->
<div class="modal fade" id="addProjectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header modal-header-satraco">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i>
                    Nouveau Projet
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form action="<?= base_url('tech/project-store') ?>" method="post">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Référence projet</label>
                            <input type="text" class="form-control" name="reference" value="<?= $project_ref ?>"
                                readonly>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Nom du projet</label>
                            <input type="text" class="form-control" name="name" placeholder="Nom du projet" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Statut</label>
                            <select class="form-control" name="status" required>
                                <option value="Planifié">Planifié</option>
                                <option value="En cours">En cours</option>
                                <option value="Terminé">Terminé</option>
                                <option value="Suspendu">Suspendu</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-satraco">
                        <i class="fas fa-save"></i>
                        Enregistrer
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Détail Projet -->
<div class="modal fade" id="viewProjectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header modal-header-satraco">
                <h5 class="modal-title">
                    <i class="fas fa-eye"></i>
                    Détail du projet
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <h4 class="satraco-title">Construction Route RN3</h4>
                <hr>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Référence :</strong><br>
                        PRJ-001
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Client :</strong><br>
                        Ministère des Travaux Publics
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Chef projet :</strong><br>
                        Axcel Irutavoyose
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Budget :</strong><br>
                        2 500 000 000 FBu
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Date début :</strong><br>
                        01/01/2026
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Fin prévue :</strong><br>
                        30/10/2026
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Statut :</strong><br>
                        <span class="badge badge-warning badge-status">En cours</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Avancement :</strong><br>
                        68%
                        <div class="progress mt-1">
                            <div class="progress-bar bg-info" style="width:68%"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <strong>Description :</strong>
                        <p class="mt-2">
                            Projet de construction et réhabilitation de la route RN3 comprenant
                            les travaux de terrassement, drainage, fondation, revêtement,
                            signalisation et contrôle qualité.
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function viewProject(ref) {
    $('#viewProjectModal').modal('show');
}

function deleteProject(id) {
    Swal.fire({

        title: 'Supprimer ce projet ?',

        text: "Cette action est irréversible.",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',

        cancelButtonColor: '#6c757d',

        confirmButtonText: 'Oui, supprimer',

        cancelButtonText: 'Annuler'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "<?= base_url('tech/project-delete-ajax') ?>",

                type: "POST",

                data: {

                    id: id

                },

                dataType: "json",

                success: function(response) {

                    if (response.status) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Supprimé',

                            text: response.message,

                            timer: 1500,

                            showConfirmButton: false

                        }).then(() => {

                            location.reload();

                        });

                    } else {

                        Swal.fire({

                            icon: 'error',

                            title: 'Erreur',

                            text: response.message

                        });

                    }

                }

            });

        }

    });

}
</script>