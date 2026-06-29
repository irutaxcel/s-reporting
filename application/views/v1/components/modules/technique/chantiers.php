<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Chantiers & exécution</h1>
                    <p class="text-muted mb-0">
                        Suivi des chantiers rattachés aux projets
                    </p>
                </div>

                <div class="col-sm-5">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Chantiers & exécution</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Statistiques -->
            <div class="row">

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>24</h3>
                            <p>Total chantiers</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hard-hat"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>14</h3>
                            <p>En cours</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>7</h3>
                            <p>Terminés</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>3</h3>
                            <p>Suspendus</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-pause-circle"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Filtres -->
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i>
                        Filtrer les chantiers
                    </h3>
                </div>

                <div class="card-body">
                    <form method="get" action="">
                        <div class="row">

                            <div class="col-md-3">
                                <label>Projet</label>
                                <select class="form-control" name="projet_id">
                                    <option value="">Tous les projets</option>
                                    <option>Projet Immeuble Kiriri</option>
                                    <option>Projet Route Nationale</option>
                                    <option>Projet Hangar Industriel</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>État</label>
                                <select class="form-control" name="etat">
                                    <option value="">Tous</option>
                                    <option>En préparation</option>
                                    <option>En cours</option>
                                    <option>Suspendu</option>
                                    <option>Terminé</option>
                                    <option>Annulé</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Chef chantier</label>
                                <input type="text" class="form-control" name="chef" placeholder="Nom du chef chantier">
                            </div>

                            <div class="col-md-2">
                                <label>Date début</label>
                                <input type="date" class="form-control" name="date_debut">
                            </div>

                            <div class="col-md-2">
                                <label>Date fin</label>
                                <input type="date" class="form-control" name="date_fin">
                            </div>

                        </div>

                        <div class="mt-3 text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                            <button type="button" class="btn btn-secondary">
                                <i class="fas fa-sync"></i> Réinitialiser
                            </button>
                        </div>
                    </form>
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

            <!-- Liste -->
            <div class="card card-outline card-dark">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-1"></i>
                        Liste des chantiers par projet
                    </h3>

                    <div class="card-tools">
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addChantierModal">
                            <i class="fas fa-plus"></i> Nouveau chantier
                        </button>

                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>

                        <button class="btn btn-outline-dark btn-sm">
                            <i class="fas fa-print"></i> Imprimer
                        </button>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover table-bordered table-sm text-nowrap">
                        <thead class="bg-dark">
                            <tr>
                                <th>#</th>
                                <th>Référence</th>
                                <th>Projet</th>
                                <th>Chantier</th>
                                <th>Localisation</th>
                                <th>Chef chantier</th>
                                <th>Début</th>
                                <th>Fin prévue</th>
                                <th>Budget</th>
                                <th>État</th>
                                <th width="170">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (!empty($allChantier)) : ?>

                                <?php $index = 1;
                                foreach ($allChantier as $ch) : ?>

                                    <tr>

                                        <td><?= $index++ ?></td>

                                        <td>
                                            <strong><?= $ch->ref_chantier ?></strong>
                                        </td>

                                        <td>
                                            <?= !empty($ch->project_name) ? $ch->project_name : '-' ?>
                                        </td>

                                        <td>
                                            <?= $ch->name ?>
                                        </td>

                                        <td>
                                            <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                                            <?= $ch->location ?>
                                        </td>

                                        <td>
                                            <i class="fas fa-user text-primary mr-1"></i>
                                            <?= $ch->chef_chantier ?>
                                        </td>

                                        <td>
                                            <?= !empty($ch->date_debut) ? date('d/m/Y', strtotime($ch->date_debut)) : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($ch->date_fin_prevue) ? date('d/m/Y', strtotime($ch->date_fin_prevue)) : '-' ?>
                                        </td>

                                        <td class="text-right">
                                            <strong><?= number_format($ch->budget, 0, ',', ' ') ?> FBU</strong>
                                        </td>

                                        <td>

                                            <?php

                                            switch ($ch->status) {

                                                case 'En préparation':
                                                    echo '<span class="badge badge-secondary">En préparation</span>';
                                                    break;

                                                case 'En cours':
                                                    echo '<span class="badge badge-primary">En cours</span>';
                                                    break;

                                                case 'Suspendu':
                                                    echo '<span class="badge badge-warning">Suspendu</span>';
                                                    break;

                                                case 'Terminé':
                                                    echo '<span class="badge badge-success">Terminé</span>';
                                                    break;

                                                case 'Annulé':
                                                    echo '<span class="badge badge-danger">Annulé</span>';
                                                    break;

                                                default:
                                                    echo '<span class="badge badge-dark">' . $ch->status . '</span>';
                                            }

                                            ?>

                                        </td>

                                        <td class="text-center">

                                            <button class="btn btn-info btn-xs" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button class="btn btn-warning btn-xs" onclick="editChantier(<?= $ch->id ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button class="btn btn-secondary btn-xs" title="Tâches">
                                                <i class="fas fa-tasks"></i>
                                            </button>

                                            <button class="btn btn-danger btn-xs" title="Supprimer"
                                                onclick="deleteChantier(<?= $ch->id ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else : ?>

                                <tr>

                                    <td colspan="11" class="text-center text-muted">

                                        <i class="fas fa-folder-open fa-2x mb-2"></i>

                                        <br>

                                        Aucun chantier disponible.

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </section>
</div>

<!-- Modal ajout chantier -->
<div class="modal fade" id="addChantierModal" tabindex="-1" role="dialog" aria-labelledby="addChantierModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" action="<?= base_url('chantier-store') ?>">
            <div class="modal-content">

                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="addChantierModalLabel">
                        <i class="fas fa-hard-hat mr-1"></i>
                        Nouveau chantier
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Projet *</label>
                                <select class="form-control" name="projet_id" required>
                                    <option value="">-- Sélectionner le projet --</option>
                                    <?php foreach ($allProject as $p) : ?>
                                        <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Référence chantier *</label>
                                <input type="text" class="form-control" name="reference" id="reference"
                                    value="<?= $reference ?>" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom du chantier *</label>
                                <input type="text" class="form-control" name="nom_chantier"
                                    placeholder="Ex: Fondation Bloc A" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Chef chantier *</label>
                                <input type="text" class="form-control" name="chef_chantier"
                                    placeholder="Nom du chef chantier" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Localisation *</label>
                                <input type="text" class="form-control" name="localisation"
                                    placeholder="Ville / Province" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Budget prévisionnel</label>
                                <input type="number" class="form-control" name="budget" placeholder="Ex: 35000000">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date début</label>
                                <input type="date" class="form-control" name="date_debut">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date fin prévue</label>
                                <input type="date" class="form-control" name="date_fin_prevue">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Progression initiale (%)</label>
                                <input type="number" class="form-control" name="progression" min="0" max="100"
                                    value="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>État</label>
                                <select class="form-control" name="etat">
                                    <option value="En préparation">En préparation</option>
                                    <option value="En cours">En cours</option>
                                    <option value="Suspendu">Suspendu</option>
                                    <option value="Terminé">Terminé</option>
                                    <option value="Annulé">Annulé</option>
                                </select>
                            </div>
                        </div>



                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editChantierModal">

    <div class="modal-dialog modal-lg">

        <form action="<?= base_url('chantier-update') ?>" method="post">

            <input type="hidden" name="id" id="edit_id">

            <div class="modal-content">

                <div class="modal-header bg-warning">

                    <h5 class="modal-title">
                        Modifier un chantier
                    </h5>

                    <button class="close" data-dismiss="modal">
                        &times;
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Projet *</label>
                                <select class="form-control" name="projet_id" id="edit_project_id" required>
                                    <option value="">-- Sélectionner le projet --</option>
                                    <?php foreach ($allProject as $p) : ?>
                                        <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Référence chantier *</label>
                                <input type="text" class="form-control" name="reference" id="edit_reference" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom du chantier *</label>
                                <input type="text" class="form-control" name="nom_chantier" id="edit_nom" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Chef chantier *</label>
                                <input type="text" class="form-control" name="chef_chantier" id="edit_chef" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Localisation *</label>
                                <input type="text" class="form-control" name="localisation" id="edit_location" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Budget prévisionnel</label>
                                <input type="number" class="form-control" name="budget" id="edit_budget">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date début</label>
                                <input type="date" class="form-control" name="date_debut" id="edit_date_debut">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date fin prévue</label>
                                <input type="date" class="form-control" name="date_fin_prevue" id="edit_date_fin">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Progression initiale (%)</label>
                                <input type="number" class="form-control" name="progression" min="0" max="100"
                                    value="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>État</label>
                                <select class="form-control" name="etat" id="edit_status">
                                    <option value="En préparation">En préparation</option>
                                    <option value="En cours">En cours</option>
                                    <option value="Suspendu">Suspendu</option>
                                    <option value="Terminé">Terminé</option>
                                    <option value="Annulé">Annulé</option>
                                    <option value="Actif">Actif</option>
                                </select>
                            </div>
                        </div>



                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary" data-dismiss="modal">

                        Annuler

                    </button>

                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-save"></i> Modifier
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<script>
    function editChantier(id) {
        $.ajax({
            url: "<?= base_url('chantier-edit-ajax') ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(res) {
                $("#edit_id").val(res.id);
                $("#edit_project_id").val(res.project_id);
                $("#edit_reference").val(res.ref_chantier);
                $("#edit_nom").val(res.name);
                $("#edit_chef").val(res.chef_chantier);
                $("#edit_location").val(res.location);
                $("#edit_budget").val(res.budget);
                $("#edit_date_debut").val(res.date_debut);
                $("#edit_date_fin").val(res.date_fin_prevue);
                $("#edit_status").val(res.status);

                $("#editChantierModal").modal("show");
            },
            error: function() {
                alert("Erreur lors du chargement du chantier.");
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteChantier(id) {

        Swal.fire({

            title: 'Supprimer ce chantier ?',

            text: "Cette opération est irréversible.",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#d33',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Oui, supprimer',

            cancelButtonText: 'Annuler'

        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: "<?= base_url('chantier-delete-ajax') ?>",

                    type: "POST",

                    data: {
                        id: id
                    },

                    dataType: "json",

                    success: function(res) {

                        if (res.status) {

                            Swal.fire({

                                icon: 'success',

                                title: 'Supprimé',

                                text: res.message,

                                timer: 1500,

                                showConfirmButton: false

                            }).then(() => {

                                location.reload();

                            });

                        } else {

                            Swal.fire({

                                icon: 'error',

                                title: 'Erreur',

                                text: res.message

                            });

                        }

                    },

                    error: function() {

                        Swal.fire({

                            icon: 'error',

                            title: 'Erreur',

                            text: 'Impossible de communiquer avec le serveur.'

                        });

                    }

                });

            }

        });

    }
</script>