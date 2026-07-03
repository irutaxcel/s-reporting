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

            <!-- ici le contenu dela page de codes journaux -->

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

                .section-title-finance {
                    font-weight: 700;
                    color: #102033;
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

                .finance-table thead th {
                    background: #102033;
                    color: #fff;
                    border: none;
                    padding: 15px 12px;
                    font-size: 13px;
                    text-transform: uppercase;
                    white-space: nowrap;
                }

                .finance-table tbody td {
                    vertical-align: middle;
                    padding: 16px 12px;
                    font-size: 14px;
                }

                .journal-code {
                    background: #ecfdf5;
                    color: #0f766e;
                    padding: 8px 14px;
                    border-radius: 30px;
                    font-weight: 800;
                    min-width: 75px;
                    text-align: center;
                    display: inline-block;
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

                .badge-type {
                    background: #dbeafe;
                    color: #1d4ed8;
                    padding: 7px 12px;
                    border-radius: 30px;
                }

                .badge-linked {
                    background: #fef3c7;
                    color: #92400e;
                    padding: 7px 12px;
                    border-radius: 30px;
                }

                .finance-table .btn {
                    width: 34px;
                    height: 34px;
                    padding: 0;
                    margin: 2px;
                }
            </style>

            <div class="row mb-4">

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-green">
                        <h6>Total journaux</h6>
                        <h2 class="font-weight-bold mb-0">5</h2>
                        <small>Journaux configurés</small>
                        <i class="fas fa-book"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-blue">
                        <h6>Journaux actifs</h6>
                        <h2 class="font-weight-bold mb-0">5</h2>
                        <small>Disponibles en saisie</small>
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-orange">
                        <h6>Journal principal</h6>
                        <h2 class="font-weight-bold mb-0">OD</h2>
                        <small>Opérations diverses</small>
                        <i class="fas fa-random"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-purple">
                        <h6>Contrôle</h6>
                        <h2 class="font-weight-bold mb-0">Actif</h2>
                        <small>Validation à la saisie</small>
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>

            </div>

            <div class="row mb-4">

                <div class="col-md-8">
                    <div class="card finance-card">
                        <div class="card-body">
                            <h5 class="section-title-finance">
                                <i class="fas fa-info-circle mr-2 text-success"></i>
                                Codes journaux comptables
                            </h5>

                            <p class="text-muted mb-0">
                                Les codes journaux permettent de classer les écritures comptables selon leur nature :
                                caisse, banque, achats, ventes ou opérations diverses. Chaque saisie comptable devra
                                être
                                rattachée à un journal afin de produire correctement le journal général, le grand livre
                                et la balance.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card finance-card">
                        <div class="card-body text-center">
                            <button class="btn btn-finance btn-block" data-toggle="modal"
                                data-target="#addJournalModal">
                                <i class="fas fa-plus-circle mr-1"></i>
                                Nouveau code journal
                            </button>

                            <button class="btn btn-outline-secondary btn-block mt-2">
                                <i class="fas fa-download mr-1"></i>
                                Charger journaux standards
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card finance-card mb-4">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <label>Type de journal</label>
                            <select class="form-control">
                                <option value="">Tous les types</option>
                                <option>Caisse</option>
                                <option>Banque</option>
                                <option>Achat</option>
                                <option>Vente</option>
                                <option>Opérations diverses</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Statut</label>
                            <select class="form-control">
                                <option value="">Tous</option>
                                <option>Actif</option>
                                <option>Inactif</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Recherche</label>
                            <input type="text" class="form-control" placeholder="Code ou intitulé...">
                        </div>

                    </div>
                </div>
            </div>

            <div class="card finance-card">

                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="section-title-finance mb-0">Liste des codes journaux</h5>
                            <small class="text-muted">
                                Journaux utilisés pour la saisie des pièces comptables.
                            </small>
                        </div>

                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-file-export mr-1"></i>
                            Exporter
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table table-hover finance-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:120px;">Code journal</th>
                                    <th>Intitulé</th>
                                    <th style="width:160px;">Type</th>
                                    <th style="width:180px;">Compte associé</th>
                                    <th style="width:140px;" class="text-center">Saisie autorisée</th>
                                    <th style="width:110px;" class="text-center">Statut</th>
                                    <th style="width:150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php $i = 1;
                                foreach ($journalCodes as $journal): ?>

                                    <tr>

                                        <td>

                                            <span class="journal-code">

                                                <?= $journal->journal_code ?>

                                            </span>

                                        </td>

                                        <td>

                                            <strong>

                                                <?= $journal->journal_name ?>

                                            </strong>

                                            <br>

                                            <small class="text-muted">

                                                <?= $journal->description ?>

                                            </small>

                                        </td>

                                        <td>

                                            <span class="badge-type">

                                                <?= $journal->journal_type ?>

                                            </span>

                                        </td>

                                        <td>

                                            <?php if (!empty($journal->account_code)): ?>

                                                <span class="badge-linked">

                                                    <?= $journal->account_code ?>

                                                </span>

                                            <?php else: ?>

                                                <span class="text-muted">

                                                    Aucun

                                                </span>

                                            <?php endif; ?>

                                        </td>

                                        <td class="text-center">

                                            <?= $journal->allow_entry == 1 ? 'Oui' : 'Non'; ?>

                                        </td>

                                        <td class="text-center">

                                            <?php if ($journal->status == 'active'): ?>

                                                <span class="badge-active">

                                                    Actif

                                                </span>

                                            <?php else: ?>

                                                <span class="badge-inactive">

                                                    Inactif

                                                </span>

                                            <?php endif; ?>

                                        </td>

                                        <td class="text-center">

                                            <button class="btn btn-info btn-sm">

                                                <i class="fas fa-eye"></i>

                                            </button>

                                            <button class="btn btn-warning btn-sm" onclick="editJournal(
                                                    '<?= $journal->id ?>',
                                                    '<?= addslashes($journal->journal_code) ?>',
                                                    '<?= addslashes($journal->journal_name) ?>',
                                                    '<?= addslashes($journal->journal_type) ?>',
                                                    '<?= $journal->default_account_id ?>',
                                                    '<?= $journal->allow_entry ?>',
                                                    '<?= $journal->status ?>',
                                                    '<?= addslashes($journal->description) ?>'
                                                    )">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button class="btn btn-danger btn-sm"
                                                onclick="deleteJournal(<?= $journal->id ?>)">
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


<div class="modal fade" id="addJournalModal">
    <div class="modal-dialog modal-lg">

        <form action="<?= base_url('finance/journal-code-store') ?>" method="post">

            <div class="modal-content">

                <div class="modal-header" style="background:#0f766e;color:#fff;">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Nouveau code journal
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i>
                        Chaque écriture comptable devra être rattachée à un journal.
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Code journal *</label>
                                <input type="text" name="journal_code" class="form-control" placeholder="Ex : CAI"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Intitulé *</label>
                                <input type="text" name="journal_name" class="form-control"
                                    placeholder="Ex : Journal de caisse" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type de journal *</label>
                                <select name="journal_type" class="form-control" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Caisse">Caisse</option>
                                    <option value="Banque">Banque</option>
                                    <option value="Achat">Achat</option>
                                    <option value="Vente">Vente</option>
                                    <option value="Opérations diverses">Opérations diverses</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Compte associé</label>
                                <select name="default_account_id" class="form-control">
                                    <option value="">Aucun compte associé</option>
                                    <?php if (!empty($chart_accounts)) : ?>
                                        <?php foreach ($chart_accounts as $account) : ?>
                                            <option value="<?= $account->id ?>">
                                                <?= $account->account_code ?> - <?= $account->account_name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <small class="text-muted">Ex : journal caisse lié au compte 521000.</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Saisie autorisée ?</label>
                                <select name="allow_entry" class="form-control">
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut</label>
                                <select name="status" class="form-control">
                                    <option value="active">Actif</option>
                                    <option value="inactive">Inactif</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description / Observation</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Information complémentaire sur ce journal"></textarea>
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

<div class="modal fade" id="editJournalModal">

    <div class="modal-dialog modal-lg">

        <form action="<?= base_url('finance/journal-code-update') ?>" method="post">

            <input type="hidden" name="id" id="edit_id">

            <div class="modal-content">

                <div class="modal-header bg-warning">

                    <h5 class="modal-title">

                        <i class="fas fa-edit mr-1"></i>

                        Modifier le code journal

                    </h5>

                    <button class="close" data-dismiss="modal">

                        &times;

                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>Code journal</label>

                                <input type="text" name="journal_code" id="edit_journal_code" class="form-control">

                            </div>

                        </div>

                        <div class="col-md-8">

                            <div class="form-group">

                                <label>Intitulé</label>

                                <input type="text" name="journal_name" id="edit_journal_name" class="form-control">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Type</label>

                                <select name="journal_type" id="edit_journal_type" class="form-control">

                                    <option value="Caisse">Caisse</option>
                                    <option value="Banque">Banque</option>
                                    <option value="Achat">Achat</option>
                                    <option value="Vente">Vente</option>
                                    <option value="Opérations diverses">Opérations diverses</option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Compte associé</label>

                                <select name="default_account_id" id="edit_default_account_id" class="form-control">

                                    <option value="">Aucun</option>

                                    <?php foreach ($chart_accounts as $account): ?>

                                        <option value="<?= $account->id ?>">

                                            <?= $account->account_code ?>

                                            -

                                            <?= $account->account_name ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Saisie autorisée</label>

                                <select name="allow_entry" id="edit_allow_entry" class="form-control">

                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Statut</label>

                                <select name="status" id="edit_status" class="form-control">

                                    <option value="active">Actif</option>

                                    <option value="inactive">Inactif</option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="form-group">

                                <label>Description</label>

                                <textarea name="description" id="edit_description" class="form-control"></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-warning">

                        Modifier

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<script>
    function editJournal(
        id,
        code,
        name,
        type,
        account,
        entry,
        status,
        description
    ) {

        $('#edit_id').val(id);

        $('#edit_journal_code').val(code);

        $('#edit_journal_name').val(name);

        $('#edit_journal_type').val(type);

        $('#edit_default_account_id').val(account);

        $('#edit_allow_entry').val(entry);

        $('#edit_status').val(status);

        $('#edit_description').val(description);

        $('#editJournalModal').modal('show');

    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteJournal(id) {
        Swal.fire({

            title: 'Supprimer ce code journal ?',

            text: "Cette opération est irréversible !",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#d33',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Oui, supprimer',

            cancelButtonText: 'Annuler'

        }).then((result) => {

            if (result.isConfirmed) {

                window.location.href =
                    "<?= base_url('finance/journal-code-delete/') ?>" + id;

            }

        });
    }
</script>