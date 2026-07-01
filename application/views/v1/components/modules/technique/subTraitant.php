<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sous-traitants</h1>
                    <p class="text-muted mb-0">
                        Gestion des sous-traitants intervenant sur les projets et chantiers.
                    </p>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Sous-traitants</li>
                    </ol>
                </div>
            </div>

        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- Statistiques -->
            <div class="row">

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>10</h3>
                            <p>Total sous-traitants</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>10</h3>
                            <p>Sous-traitants actifs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>7</h3>
                            <p>Spécialités</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tools"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Sous-traitants inactifs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-times"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Filtres -->
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i>
                        Filtres de recherche
                    </h3>
                </div>

                <div class="card-body">
                    <form action="#" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Recherche</label>
                                    <input type="text" class="form-control"
                                        placeholder="Nom, responsable, téléphone...">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Spécialité</label>
                                    <select class="form-control">
                                        <option value="">Toutes les spécialités</option>
                                        <option>Charpentier</option>
                                        <option>Ferrailleur</option>
                                        <option>Maçonnerie</option>
                                        <option>Soudeur</option>
                                        <option>Électricien</option>
                                        <option>Plombier</option>
                                        <option>Peintre</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select class="form-control">
                                        <option value="">Tous</option>
                                        <option value="active">Actif</option>
                                        <option value="inactive">Inactif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-success btn-block">
                                    <i class="fas fa-search"></i>
                                    Rechercher
                                </button>
                            </div>

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
            <div class="card card-outline card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-hard-hat mr-1"></i>
                        Liste des sous-traitants
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#addSubcontractorModal">
                            <i class="fas fa-plus-circle"></i>
                            Nouveau sous-traitant
                        </button>

                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-print"></i>
                            Imprimer
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="subcontractorsTable" class="table table-bordered table-striped table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40">#</th>
                                    <th>Entreprise</th>
                                    <th>Responsable</th>
                                    <th>Spécialité</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th>Statut</th>
                                    <th>Date création</th>
                                    <th width="130" class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php $i = 1; ?>

                                <?php foreach ($allSubTraitant as $item) { ?>

                                <tr>

                                    <td><?= $i++ ?></td>

                                    <td>
                                        <strong><?= $item->name ?></strong>
                                    </td>

                                    <td><?= $item->contact_name ?></td>

                                    <td>
                                        <span class="badge badge-light border">
                                            <?= $item->specialty ?>
                                        </span>
                                    </td>

                                    <td>
                                        <i class="fas fa-phone text-success"></i>
                                        <?= $item->phone ?>
                                    </td>

                                    <td>

                                        <?php if (!empty($item->email)) { ?>

                                        <?= $item->email ?>

                                        <?php } else { ?>

                                        -

                                        <?php } ?>

                                    </td>

                                    <td>

                                        <?php if ($item->status == 'active') { ?>

                                        <span class="badge badge-success">
                                            Actif
                                        </span>

                                        <?php } else { ?>

                                        <span class="badge badge-danger">
                                            Inactif
                                        </span>

                                        <?php } ?>

                                    </td>

                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($item->created_at)) ?>
                                    </td>

                                    <td class="text-center">

                                        <button class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button type="button" class="btn btn-warning btn-sm" onclick="editSubTraitant(
                                                    '<?= $item->id ?>',
                                                    '<?= htmlspecialchars($item->name, ENT_QUOTES) ?>',
                                                    '<?= htmlspecialchars($item->contact_name, ENT_QUOTES) ?>',
                                                    '<?= htmlspecialchars($item->specialty, ENT_QUOTES) ?>',
                                                    '<?= htmlspecialchars($item->phone, ENT_QUOTES) ?>',
                                                    '<?= htmlspecialchars($item->email, ENT_QUOTES) ?>',
                                                    '<?= htmlspecialchars($item->status, ENT_QUOTES) ?>'
                                                )">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteSubTraitant('<?= $item->id ?>')">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </td>

                                </tr>

                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- Modal Ajout -->
    <div class="modal fade" id="addSubcontractorModal">
        <div class="modal-dialog modal-lg">

            <form action="<?= base_url('subcontractor-store') ?>" method="post">

                <input type="hidden" name="company_id" value="2">

                <div class="modal-content">

                    <div class="modal-header bg-success">
                        <h5 class="modal-title">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Nouveau sous-traitant
                        </h5>

                        <button type="button" class="close text-white" data-dismiss="modal">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Entreprise / Nom *</label>
                                    <input type="text" name="name" class="form-control" placeholder="Ex : TUYISENGE"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nom du responsable</label>
                                    <input type="text" name="contact_name" class="form-control"
                                        placeholder="Ex : Dieudonné">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Spécialité *</label>
                                    <input type="text" name="speciality" class="form-control"
                                        placeholder="Ex : Charpentier" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Téléphone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Ex : 62987670">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Ex : contact@email.com">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select name="status" class="form-control">
                                        <option value="active">Actif</option>
                                        <option value="inactive">Inactif</option>
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
                            <i class="fas fa-save"></i>
                            Enregistrer
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <!-- Modal Modification -->
    <div class="modal fade" id="editSubTraitantModal">
        <div class="modal-dialog modal-lg">

            <form action="<?= base_url('subcontractor-update') ?>" method="post">

                <input type="hidden" name="id" id="edit_id">

                <div class="modal-content">

                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">
                            <i class="fas fa-edit mr-1"></i>
                            Modifier le sous-traitant
                        </h5>

                        <button type="button" class="close" data-dismiss="modal">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Entreprise / Nom *</label>
                                    <input type="text" name="name" id="edit_name" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nom du responsable</label>
                                    <input type="text" name="contact_name" id="edit_contact_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Spécialité *</label>
                                    <input type="text" name="speciality" id="edit_speciality" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Téléphone</label>
                                    <input type="text" name="phone" id="edit_phone" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" id="edit_email" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select name="status" id="edit_status" class="form-control">
                                        <option value="active">Actif</option>
                                        <option value="inactive">Inactif</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Annuler
                        </button>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i>
                            Modifier
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <script>
    function editSubTraitant(id, name, contact_name, speciality, phone, email, status) {
        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_contact_name').val(contact_name);
        $('#edit_speciality').val(speciality);
        $('#edit_phone').val(phone);
        $('#edit_email').val(email);
        $('#edit_status').val(status);

        $('#editSubTraitantModal').modal('show');
    }
    </script>

    <!-- Modal Voir -->
    <div class="modal fade" id="viewSubcontractorModal">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header bg-info">
                    <h5 class="modal-title">
                        <i class="fas fa-eye mr-1"></i>
                        Détails du sous-traitant
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered">
                        <tr>
                            <th width="35%">Entreprise / Nom</th>
                            <td id="view_name"></td>
                        </tr>

                        <tr>
                            <th>Responsable</th>
                            <td id="view_contact_name"></td>
                        </tr>

                        <tr>
                            <th>Spécialité</th>
                            <td id="view_speciality"></td>
                        </tr>

                        <tr>
                            <th>Téléphone</th>
                            <td id="view_phone"></td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td id="view_email"></td>
                        </tr>

                        <tr>
                            <th>Statut</th>
                            <td id="view_status"></td>
                        </tr>

                        <tr>
                            <th>Date création</th>
                            <td id="view_created_at"></td>
                        </tr>
                    </table>

                </div>

            </div>

        </div>
    </div>


</div>
<!-- /.content-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteSubTraitant(id) {
    Swal.fire({

        title: 'Supprimer le sous-traitant ?',

        text: "Cette action est irréversible.",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',

        cancelButtonColor: '#6c757d',

        confirmButtonText: 'Oui, supprimer',

        cancelButtonText: 'Annuler'

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href = "<?= base_url('subcontractor-delete/') ?>" + id;

        }

    });

}
</script>