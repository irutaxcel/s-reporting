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

            <!-- ici le contenu dela page -->
            <style>
                .card-outline.card-success {
                    border-top: 3px solid #74c476;
                }

                .btn-success,
                .bg-success {
                    background-color: #74c476 !important;
                    border-color: #74c476 !important;
                }

                .table thead.bg-success {
                    background-color: #173b35 !important;
                }

                .custom-control-input:checked~.custom-control-label::before {
                    background-color: #74c476 !important;
                    border-color: #74c476 !important;
                }
            </style>

            <div class="row">

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Personnel actif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Chantiers concernés</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hard-hat"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Présences du jour</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Absences</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-times"></i>
                        </div>
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


            <div class="card card-outline card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-hard-hat mr-2"></i>
                        Personnel par chantier
                    </h3>

                    <div class="card-tools">
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPersonnel">

                            <i class="fas fa-plus"></i>
                            Ajouter personnel
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="modalPersonnel">

                    <div class="modal-dialog modal-xl">

                        <div class="modal-content">

                            <div class="modal-header bg-success">

                                <h4 class="modal-title">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Ajouter un personnel chantier
                                </h4>

                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>

                            </div>

                            <form action="<?= base_url('personnel-chantier/store') ?>" method="post">

                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Chantier</label>
                                                <select class="form-control" name="chantier_id" required>
                                                    <option value="">Sélectionner</option>
                                                    <?php foreach ($allChantier as $chant) : ?>
                                                        <option value="<?= $chant->id ?>"><?= $chant->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="directeur_technique" name="directeur_technique" value="1">

                                                    <label class="custom-control-label" for="directeur_technique">

                                                        Directeur Technique
                                                    </label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="directeur_financier" name="directeur_financier" value="1">

                                                    <label class="custom-control-label" for="directeur_financier">

                                                        Directeur Financier
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>



                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">
                                            <i class="fas fa-users mr-1"></i>
                                            Personnel à ajouter
                                        </h6>

                                        <button type="button" class="btn btn-success btn-sm"
                                            onclick="addPersonnelRow()">
                                            <i class="fas fa-plus"></i>
                                            Ajouter une ligne
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="bg-success text-white">
                                                <tr>
                                                    <th>Nom et prénom</th>
                                                    <th>Type</th>
                                                    <th>Fonction</th>
                                                    <th>Début</th>
                                                    <th>Fin</th>
                                                    <th>Mode paie</th>
                                                    <th>Taux</th>
                                                    <th width="50">#</th>
                                                </tr>
                                            </thead>

                                            <tbody id="personnelRows">
                                                <tr>
                                                    <td>
                                                        <input type="text" name="worker_name[]"
                                                            class="form-control form-control-sm" required>
                                                    </td>

                                                    <td>
                                                        <select name="worker_type[]"
                                                            class="form-control form-control-sm" required>
                                                            <option value="">Type</option>
                                                            <option value="Journalier">Journalier</option>
                                                            <option value="Manœuvre">Manœuvre</option>
                                                            <option value="Tâcheron">Tâcheron</option>
                                                            <option value="Magasinier">Magasinier chantier</option>
                                                            <option value="Gardien">Gardien</option>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="text" name="function_name[]"
                                                            class="form-control form-control-sm">
                                                    </td>


                                                    <td>
                                                        <input type="date" name="start_date[]"
                                                            class="form-control form-control-sm">
                                                    </td>

                                                    <td>
                                                        <input type="date" name="end_date[]"
                                                            class="form-control form-control-sm">
                                                    </td>

                                                    <td>
                                                        <select name="payment_mode[]"
                                                            class="form-control form-control-sm">
                                                            <option value="">Mode</option>
                                                            <option value="Hebdomadaire">Hebdomadaire</option>
                                                            <option value="Mensuel">Mensuel</option>
                                                            <option value="Taux unitaire">Taux unitaire</option>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="number" name="unit_rate[]"
                                                            class="form-control form-control-sm" placeholder="0">
                                                    </td>

                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="removePersonnelRow(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Annuler
                                    </button>

                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save mr-1"></i>
                                        Enregistrer
                                    </button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                <script>
                    function addPersonnelRow() {
                        let tbody = document.getElementById('personnelRows');

                        let row = `
                            <tr>
                                <td>
                                    <input type="text" name="worker_name[]" class="form-control form-control-sm" required>
                                </td>

                                <td>
                                    <select name="worker_type[]" class="form-control form-control-sm" required>
                                        <option value="">Type</option>
                                        <option value="Journalier">Journalier</option>
                                        <option value="Manœuvre">Manœuvre</option>
                                        <option value="Tâcheron">Tâcheron</option>
                                        <option value="Magasinier">Magasinier chantier</option>
                                        <option value="Gardien">Gardien</option>
                                    </select>
                                </td>

                                <td>
                                    <input type="text" name="function_name[]" class="form-control form-control-sm">
                                </td>

                                

                                <td>
                                    <input type="date" name="start_date[]" class="form-control form-control-sm">
                                </td>

                                <td>
                                    <input type="date" name="end_date[]" class="form-control form-control-sm">
                                </td>

                                <td>
                                    <select name="payment_mode[]" class="form-control form-control-sm">
                                        <option value="">Mode</option>
                                        <option value="Hebdomadaire">Hebdomadaire</option>
                                        <option value="Mensuel">Mensuel</option>
                                        <option value="Taux unitaire">Taux unitaire</option>
                                    </select>
                                </td>

                                <td>
                                    <input type="number" name="unit_rate[]" class="form-control form-control-sm" placeholder="0">
                                </td>

                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removePersonnelRow(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;

                        tbody.insertAdjacentHTML('beforeend', row);
                    }

                    function removePersonnelRow(button) {
                        let tbody = document.getElementById('personnelRows');

                        if (tbody.rows.length > 1) {
                            button.closest('tr').remove();
                        } else {
                            alert('Vous devez garder au moins une ligne.');
                        }
                    }
                </script>

                <div class="card-body">

                    <!-- CHANTIER 1 -->
                    <?php foreach ($allChantier as $chantier) : ?>
                        <div class="card card-success card-outline mb-4">

                            <div class="card-header bg-success">
                                <h3 class="card-title text-white">
                                    Chantier : <?= $chantier->name ?>
                                </h3>

                                <div class="card-tools">
                                    <span class="badge badge-light">
                                        12 Personnels
                                    </span>
                                </div>
                            </div>

                            <div class="card-body p-0">

                                <table class="table table-bordered table-sm table-hover mb-0">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Fonction</th>
                                            <th>Téléphone</th>
                                            <th>Date début</th>
                                            <th>Statut</th>
                                            <th width="120">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php foreach ($this->tech->getPersonlChantier($chantier->id) as $persl) :  ?>
                                            <tr>
                                                <td>1</td>
                                                <td>Jean Claude Ndayishimiye</td>
                                                <td>Chef Chantier</td>
                                                <td>79 12 34 56</td>
                                                <td>01/06/2026</td>
                                                <td>
                                                    <span class="badge badge-success">
                                                        Actif
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>

                                        <tr>
                                            <td>2</td>
                                            <td>Eric Nkurunziza</td>
                                            <td>Maçon</td>
                                            <td>69 44 11 22</td>
                                            <td>05/06/2026</td>
                                            <td>
                                                <span class="badge badge-success">
                                                    Actif
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>
                    <?php endforeach ?>

                    <!-- CHANTIER 2 -->
                    <div class="card card-info card-outline mb-4">

                        <div class="card-header bg-info">
                            <h3 class="card-title text-white">
                                Chantier : SATRACO Head Office
                            </h3>

                            <div class="card-tools">
                                <span class="badge badge-light">
                                    8 Personnels
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-0">

                            <table class="table table-bordered table-hover mb-0">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Fonction</th>
                                        <th>Téléphone</th>
                                        <th>Date début</th>
                                        <th>Statut</th>
                                        <th width="120">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td>1</td>
                                        <td>David Ndayisaba</td>
                                        <td>Conducteur Travaux</td>
                                        <td>71 22 33 44</td>
                                        <td>12/05/2026</td>
                                        <td>
                                            <span class="badge badge-success">
                                                Actif
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>Alexis Nkurunziza</td>
                                        <td>Ingénieur Civil</td>
                                        <td>79 55 66 77</td>
                                        <td>15/05/2026</td>
                                        <td>
                                            <span class="badge badge-warning">
                                                En congé
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->