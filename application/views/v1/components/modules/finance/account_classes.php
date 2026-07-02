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

            <!-- ici le contenu de la page Classes Compte -->

            <style>
                .finance-card {
                    border: none;
                    border-radius: 16px;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
                }

                .finance-stat {
                    border-radius: 16px;
                    padding: 18px;
                    color: #fff;
                    min-height: 115px;
                    position: relative;
                    overflow: hidden;
                }

                .finance-stat i {
                    position: absolute;
                    right: 18px;
                    bottom: 12px;
                    font-size: 46px;
                    opacity: .22;
                }

                .bg-finance-green {
                    background: linear-gradient(135deg, #0f766e, #74c476);
                }

                .bg-finance-blue {
                    background: linear-gradient(135deg, #0f172a, #2563eb);
                }

                .bg-finance-orange {
                    background: linear-gradient(135deg, #92400e, #f59e0b);
                }

                .bg-finance-purple {
                    background: linear-gradient(135deg, #581c87, #9333ea);
                }

                .finance-table thead th {
                    background: #102033;
                    color: #fff;
                    border: none;
                    font-size: 13px;
                    text-transform: uppercase;
                }

                .finance-table td {
                    vertical-align: middle;
                    font-size: 14px;
                }

                .badge-active {
                    background: #dcfce7;
                    color: #166534;
                    padding: 7px 12px;
                    border-radius: 30px;
                }

                .badge-inactive {
                    background: #fee2e2;
                    color: #991b1b;
                    padding: 7px 12px;
                    border-radius: 30px;
                }

                .btn-finance {
                    background: #0f766e;
                    color: #fff;
                    border-radius: 10px;
                    font-weight: 600;
                }

                .btn-finance:hover {
                    background: #0b5f59;
                    color: #fff;
                }

                .section-title-finance {
                    font-weight: 700;
                    color: #102033;
                }

                .class-number {
                    width: 42px;
                    height: 42px;
                    border-radius: 12px;
                    background: #ecfdf5;
                    color: #0f766e;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: 800;
                    font-size: 18px;
                }
            </style>

            <!-- Statistiques -->
            <div class="row mb-4">

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-green">
                        <h6>Total classes</h6>
                        <h2 class="font-weight-bold mb-0">8</h2>
                        <small>Référentiel comptable</small>
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-blue">
                        <h6>Classes actives</h6>
                        <h2 class="font-weight-bold mb-0">8</h2>
                        <small>Disponibles au plan comptable</small>
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-orange">
                        <h6>Comptes rattachés</h6>
                        <h2 class="font-weight-bold mb-0">0</h2>
                        <small>Plan comptable SATRACO</small>
                        <i class="fas fa-list-alt"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-purple">
                        <h6>Norme utilisée</h6>
                        <h2 class="font-weight-bold mb-0">OHADA</h2>
                        <small>Système comptable francophone</small>
                        <i class="fas fa-balance-scale"></i>
                    </div>
                </div>

            </div>

            <!-- Explication + action -->
            <div class="row mb-4">

                <div class="col-md-8">
                    <div class="card finance-card">
                        <div class="card-body">
                            <h5 class="section-title-finance">
                                <i class="fas fa-info-circle mr-2 text-success"></i>
                                Classes de comptes comptables
                            </h5>

                            <p class="text-muted mb-0">
                                Les classes comptables regroupent les comptes selon leur nature :
                                capitaux, immobilisations, stocks, tiers, trésorerie, charges et produits.
                                Elles constituent la base du plan comptable utilisé pour produire le grand livre,
                                la balance, le bilan et le compte de résultat.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card finance-card">
                        <div class="card-body text-center">
                            <button class="btn btn-finance btn-block" data-toggle="modal" data-target="#addClassModal">
                                <i class="fas fa-plus-circle mr-1"></i>
                                Nouvelle classe comptable
                            </button>

                            <button class="btn btn-outline-secondary btn-block mt-2">
                                <i class="fas fa-sync-alt mr-1"></i>
                                Charger classes standards
                            </button>
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

            <!-- Liste -->
            <div class="card finance-card">

                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="section-title-finance mb-0">
                                Liste des classes comptables
                            </h5>
                            <small class="text-muted">
                                Référentiel de base du plan comptable SATRACO.
                            </small>
                        </div>

                        <div style="width:220px;">
                            <input type="text" class="form-control form-control-sm"
                                placeholder="Rechercher une classe...">
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table table-hover finance-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Classe</th>
                                    <th>Intitulé</th>
                                    <th>Description</th>
                                    <th>Nature</th>
                                    <th>Statut</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php $index = 1;
                                foreach ($account_classes as $class): ?>
                                    <tr>
                                        <td><?php echo $index++; ?></td>
                                        <td>
                                            <div class="class-number"><?php echo $class->code_prefix; ?></div>
                                        </td>
                                        <td><strong><?= $class->class_name ?></strong></td>
                                        <td><?= $class->description ?></td>
                                        <td><?= $class->nature ?></td>
                                        <td><span class="badge-active"><?= $class->status ?></span></td>
                                        <td class="text-right">

                                            <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>

                                            <button type="button" class="btn btn-sm btn-warning" onclick="editAccountClass(
                                                        '<?= $class->id ?>',
                                                        '<?= $class->class_number ?>',
                                                        '<?= htmlspecialchars($class->class_name, ENT_QUOTES) ?>',
                                                        '<?= htmlspecialchars($class->nature, ENT_QUOTES) ?>',
                                                        '<?= htmlspecialchars($class->description, ENT_QUOTES) ?>',
                                                        '<?= $class->status ?>'
                                                    )">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleteAccountClass('<?= $class->id ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>



                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal ajout classe comptable -->
<div class="modal fade" id="addClassModal">
    <div class="modal-dialog modal-lg">

        <form action="<?= base_url('finance/account-class-store') ?>" method="post">

            <div class="modal-content">

                <div class="modal-header" style="background:#0f766e;color:#fff;">
                    <h5 class="modal-title">
                        <i class="fas fa-layer-group mr-1"></i>
                        Nouvelle classe comptable
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i>
                        Les classes comptables servent à structurer le plan comptable.
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Numéro de classe *</label>
                                <input type="number" name="class_number" class="form-control" placeholder="Ex : 1"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Intitulé *</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Ex : Comptes de trésorerie" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nature *</label>
                                <select name="nature" class="form-control" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Bilan - Actif">Bilan - Actif</option>
                                    <option value="Bilan - Passif">Bilan - Passif</option>
                                    <option value="Bilan - Actif / Passif">Bilan - Actif / Passif</option>
                                    <option value="Compte de résultat">Compte de résultat</option>
                                    <option value="Hors bilan">Hors bilan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut *</label>
                                <select name="status" class="form-control" required>
                                    <option value="active">Actif</option>
                                    <option value="inactive">Inactif</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Description de la classe comptable"></textarea>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-finance">
                        <i class="fas fa-save mr-1"></i>
                        Enregistrer
                    </button>
                </div>

            </div>

        </form>
    </div>
</div>

<!-- Modal modification classe comptable -->
<div class="modal fade" id="editClassModal">
    <div class="modal-dialog modal-lg">

        <form action="<?= base_url('finance/account-class-update') ?>" method="post">

            <input type="hidden" name="id" id="edit_class_id">

            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-1"></i>
                        Modifier la classe comptable
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Numéro de classe *</label>
                                <input type="number" name="class_number" id="edit_class_number" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Intitulé *</label>
                                <input type="text" name="class_name" id="edit_class_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nature *</label>
                                <select name="nature" id="edit_nature" class="form-control" required>
                                    <option value="Bilan - Actif">Bilan - Actif</option>
                                    <option value="Bilan - Passif">Bilan - Passif</option>
                                    <option value="Bilan - Actif / Passif">Bilan - Actif / Passif</option>
                                    <option value="Compte de résultat">Compte de résultat</option>
                                    <option value="Hors bilan">Hors bilan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut *</label>
                                <select name="status" id="edit_status" class="form-control" required>
                                    <option value="active">Actif</option>
                                    <option value="inactive">Inactif</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="edit_description" class="form-control"
                                    rows="3"></textarea>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i>
                        Modifier
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>


<script>
    function editAccountClass(id, class_number, class_name, nature, description, status) {
        $('#edit_class_id').val(id);
        $('#edit_class_number').val(class_number);
        $('#edit_class_name').val(class_name);
        $('#edit_nature').val(nature);
        $('#edit_description').val(description);
        $('#edit_status').val(status);

        $('#editClassModal').modal('show');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function deleteAccountClass(id) {
        Swal.fire({
            title: 'Confirmation',
            text: 'Voulez-vous vraiment supprimer cette classe comptable ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('finance/account-class-delete/') ?>" + id;
            }
        });
    }
</script>