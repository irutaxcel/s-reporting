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

    <!-- ici le contenu spécifique à la page des exercices comptables -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

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
                        min-height: 120px;
                        position: relative;
                        overflow: hidden;
                    }

                    .finance-stat i {
                        position: absolute;
                        right: 18px;
                        bottom: 12px;
                        font-size: 48px;
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

                    .bg-finance-red {
                        background: linear-gradient(135deg, #7f1d1d, #ef4444);
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

                    .badge-open {
                        background: #dcfce7;
                        color: #166534;
                        padding: 7px 12px;
                        border-radius: 30px;
                    }

                    .badge-closed {
                        background: #fee2e2;
                        color: #991b1b;
                        padding: 7px 12px;
                        border-radius: 30px;
                    }

                    .badge-current {
                        background: #dbeafe;
                        color: #1d4ed8;
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

                    .text-muted-small {
                        font-size: 13px;
                        color: #64748b;
                    }
                    </style>

                    <!-- Statistiques -->
                    <div class="row mb-4">

                        <div class="col-md-3">
                            <div class="finance-stat bg-finance-green">
                                <h6>Exercice actif</h6>
                                <h2 class="font-weight-bold mb-0">2026</h2>
                                <small>01/01/2026 - 31/12/2026</small>
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="finance-stat bg-finance-blue">
                                <h6>Total exercices</h6>
                                <h2 class="font-weight-bold mb-0">4</h2>
                                <small>Historique comptable</small>
                                <i class="fas fa-layer-group"></i>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="finance-stat bg-finance-orange">
                                <h6>En cours</h6>
                                <h2 class="font-weight-bold mb-0">1</h2>
                                <small>Ouvert à la saisie</small>
                                <i class="fas fa-unlock-alt"></i>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="finance-stat bg-finance-red">
                                <h6>Clôturés</h6>
                                <h2 class="font-weight-bold mb-0">3</h2>
                                <small>Non modifiables</small>
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>

                    </div>

                    <!-- Actions + explication -->
                    <div class="row mb-4">

                        <div class="col-md-8">
                            <div class="card finance-card">
                                <div class="card-body">
                                    <h5 class="section-title-finance">
                                        <i class="fas fa-info-circle mr-2 text-success"></i>
                                        Gestion des exercices comptables
                                    </h5>

                                    <p class="text-muted mb-0">
                                        L’exercice comptable représente la période pendant laquelle SATRACO enregistre
                                        toutes ses écritures comptables. Généralement, il commence le 1er janvier et se
                                        termine
                                        le 31 décembre. Une fois clôturé, aucune modification ne doit être effectuée
                                        sans autorisation.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card finance-card">
                                <div class="card-body text-center">
                                    <button class="btn btn-finance btn-block" data-toggle="modal"
                                        data-target="#addExerciseModal">
                                        <i class="fas fa-plus-circle mr-1"></i>
                                        Nouvel exercice comptable
                                    </button>

                                    <button class="btn btn-outline-secondary btn-block mt-2">
                                        <i class="fas fa-file-export mr-1"></i>
                                        Exporter la liste
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
                                        Liste des exercices comptables
                                    </h5>
                                    <small class="text-muted-small">
                                        Suivi des exercices ouverts, clôturés et actifs.
                                    </small>
                                </div>

                                <div>
                                    <select class="form-control form-control-sm">
                                        <option>Tous les statuts</option>
                                        <option>Ouvert</option>
                                        <option>Clôturé</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-hover finance-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Exercice</th>
                                            <th>Période</th>
                                            <th>Statut</th>
                                            <th>Actif</th>
                                            <th>Créé par</th>
                                            <th>Date création</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if (!empty($exercises)) : ?>
                                        <?php $i = 1;
                                            foreach ($exercises as $ex) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td>
                                                <strong><?= $ex->name ?></strong><br>
                                                <small class="text-muted">
                                                    <?= $ex->is_active ? 'Année comptable courante' : 'Historique comptable' ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?= date('d/m/Y', strtotime($ex->start_date)) ?>
                                                -
                                                <?= date('d/m/Y', strtotime($ex->end_date)) ?>
                                            </td>
                                            <td>
                                                <?php if ($ex->status == 'open') : ?>
                                                <span class="badge-open">Ouvert</span>
                                                <?php else : ?>
                                                <span class="badge-closed">Clôturé</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($ex->is_active) : ?>
                                                <span class="badge-current">Actif</span>
                                                <?php else : ?>
                                                -
                                                <?php endif; ?>
                                            </td>
                                            <td>Admin Finance</td>
                                            <td><?= date('d/m/Y', strtotime($ex->created_at)) ?></td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <?php if ($ex->status == 'open') : ?>
                                                <button type="button" class="btn btn-sm btn-warning" onclick="editExercise(
                                                                        '<?= $ex->id ?>',
                                                                        '<?= htmlspecialchars($ex->name, ENT_QUOTES) ?>',
                                                                        '<?= $ex->year ?>',
                                                                        '<?= $ex->start_date ?>',
                                                                        '<?= $ex->end_date ?>',
                                                                        '<?= $ex->status ?>',
                                                                        '<?= $ex->is_active ?>'
                                                                    )">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a href="<?= base_url('finance/exercise-close/' . $ex->id) ?>"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Voulez-vous vraiment clôturer cet exercice ?')">
                                                    <i class="fas fa-lock"></i>
                                                </a>
                                                <?php else : ?>
                                                <button class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else : ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                Aucun exercice comptable trouvé.
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </section>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal ajout exercice -->
<div class="modal fade" id="addExerciseModal">
    <div class="modal-dialog modal-lg">
        <form action="<?= base_url('finance/exercise-store') ?>" method="post">

            <div class="modal-content">

                <div class="modal-header" style="background:#0f766e;color:#fff;">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-plus mr-1"></i>
                        Nouvel exercice comptable
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i>
                        Un seul exercice peut être actif à la fois.
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom de l’exercice *</label>
                                <input type="text" name="name" class="form-control" placeholder="Exercice 2026"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Année *</label>
                                <input type="number" name="year" class="form-control" placeholder="2026" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date début *</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date fin *</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut *</label>
                                <select name="status" class="form-control" required>
                                    <option value="open">Ouvert</option>
                                    <option value="closed">Clôturé</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Définir comme actif ?</label>
                                <select name="is_active" class="form-control">
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
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

<!-- Modal modification exercice -->
<div class="modal fade" id="editExerciseModal">
    <div class="modal-dialog modal-lg">

        <form action="<?= base_url('finance/exercise-update') ?>" method="post">

            <input type="hidden" name="id" id="edit_id">

            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-1"></i>
                        Modifier l’exercice comptable
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom de l’exercice *</label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Année *</label>
                                <input type="number" name="year" id="edit_year" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date début *</label>
                                <input type="date" name="start_date" id="edit_start_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date fin *</label>
                                <input type="date" name="end_date" id="edit_end_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut *</label>
                                <select name="status" id="edit_status" class="form-control" required>
                                    <option value="open">Ouvert</option>
                                    <option value="closed">Clôturé</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Définir comme actif ?</label>
                                <select name="is_active" id="edit_is_active" class="form-control">
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
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
function editExercise(id, name, year, start_date, end_date, status, is_active) {
    $('#edit_id').val(id);
    $('#edit_name').val(name);
    $('#edit_year').val(year);
    $('#edit_start_date').val(start_date);
    $('#edit_end_date').val(end_date);
    $('#edit_status').val(status);
    $('#edit_is_active').val(is_active);

    $('#editExerciseModal').modal('show');
}
</script>