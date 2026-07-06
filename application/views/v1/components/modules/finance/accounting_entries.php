<!-- Content Wrapper. Contains page content -->
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
            .finance-card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
            }

            .entry-header-card {
                background: linear-gradient(135deg, #0f766e, #102033);
                color: #fff;
                border-radius: 16px;
                padding: 22px;
            }

            .entry-header-card h4 {
                font-weight: 800;
                margin-bottom: 5px;
            }

            .section-title-finance {
                font-weight: 800;
                color: #102033;
            }

            .btn-finance {
                background: #0f766e;
                color: #fff;
                border-radius: 10px;
                font-weight: 700;
            }

            .btn-finance:hover {
                background: #0b5f59;
                color: #fff;
            }

            .entry-form label {
                font-weight: 700;
                color: #1f2937;
                font-size: 14px;
            }

            .entry-form .form-control {
                border-radius: 10px;
                min-height: 42px;
            }

            .entry-table thead th {
                background: #102033;
                color: #fff;
                border: none;
                padding: 14px 10px;
                font-size: 13px;
                text-transform: uppercase;
                white-space: nowrap;
            }

            .entry-table tbody td {
                vertical-align: middle;
                padding: 13px 10px;
                font-size: 14px;
            }

            .entry-table input,
            .entry-table select {
                border-radius: 8px;
                min-height: 38px;
            }

            .amount-input {
                text-align: right;
                font-weight: 700;
            }

            .total-box {
                border-radius: 14px;
                padding: 16px;
                background: #f8fafc;
                border: 1px solid #e5e7eb;
            }

            .total-box h5 {
                font-weight: 800;
                margin-bottom: 0;
            }

            .total-balanced {
                background: #dcfce7;
                color: #166534;
                border-radius: 30px;
                padding: 8px 14px;
                font-weight: 800;
                display: inline-block;
            }

            .total-unbalanced {
                background: #fee2e2;
                color: #991b1b;
                border-radius: 30px;
                padding: 8px 14px;
                font-weight: 800;
                display: inline-block;
            }

            .help-panel {
                background: #ecfdf5;
                border-left: 5px solid #0f766e;
                border-radius: 14px;
                padding: 16px;
            }

            .piece-badge {
                background: #dbeafe;
                color: #1d4ed8;
                padding: 7px 12px;
                border-radius: 30px;
                font-weight: 700;
            }

            .entry-actions {
                background: #fff;
                border-top: 1px solid #e5e7eb;
                padding: 15px;
                position: sticky;
                bottom: 0;
                z-index: 20;
            }

            .btn-remove-line {
                width: 34px;
                height: 34px;
                padding: 0;
                border-radius: 8px;
            }

            .entry-status-draft {
                background: #fef3c7;
                color: #92400e;
                padding: 7px 12px;
                border-radius: 30px;
                font-weight: 700;
            }

            .entry-status-validated {
                background: #dcfce7;
                color: #166534;
                padding: 7px 12px;
                border-radius: 30px;
                font-weight: 700;
            }

            .entry-status-cancelled {
                background: #fee2e2;
                color: #991b1b;
                padding: 7px 12px;
                border-radius: 30px;
                font-weight: 700;
            }

            .modal-xl {
                max-width: 96%;
            }
            </style>

            <!-- Bandeau principal -->
            <div class="entry-header-card mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4>
                            <i class="fas fa-book mr-2"></i>
                            Gestion des écritures comptables
                        </h4>
                        <p class="mb-0">
                            Consultation, création, modification et suppression des pièces comptables.
                        </p>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-light font-weight-bold" data-toggle="modal"
                            data-target="#addEntryModal">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Nouvelle écriture
                        </button>
                    </div>
                </div>
            </div>

            <!-- Liste des écritures -->
            <div class="card finance-card mb-4">

                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="section-title-finance mb-0">
                                <i class="fas fa-list mr-2 text-success"></i>
                                Liste des écritures comptables
                            </h5>
                            <small class="text-muted">
                                Historique des pièces comptables déjà enregistrées.
                            </small>
                        </div>

                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-file-export mr-1"></i>
                            Exporter
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table table-hover entry-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width:130px;">Pièce</th>
                                    <th style="width:110px;">Date</th>
                                    <th style="width:120px;">Journal</th>
                                    <th>Libellé général</th>
                                    <th style="width:180px;">Chantier</th>
                                    <th class="text-right" style="width:130px;">Débit</th>
                                    <th class="text-right" style="width:130px;">Crédit</th>
                                    <th class="text-right" style="width:110px;">TVA</th>
                                    <th style="width:110px;">Statut</th>
                                    <th class="text-center" style="width:150px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (!empty($accounting_entries)): ?>

                                <?php foreach ($accounting_entries as $entry): ?>

                                <tr>

                                    <td>
                                        <strong><?= $entry->piece_number ?></strong>
                                    </td>

                                    <td>
                                        <?= date('d/m/Y', strtotime($entry->operation_date)); ?>
                                    </td>

                                    <td>
                                        <span class="badge badge-info">
                                            <?= $entry->journal_code ?>
                                        </span>
                                    </td>

                                    <td>

                                        <strong>
                                            <?= $entry->general_label ?>
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            <?= $entry->reference ?>
                                        </small>

                                    </td>

                                    <td>

                                        <?php if (!empty($entry->chantier_name)): ?>

                                        <?= $entry->chantier_name ?>

                                        <?php else: ?>

                                        <span class="text-muted">
                                            Aucun chantier
                                        </span>

                                        <?php endif; ?>

                                    </td>

                                    <td class="text-right">

                                        <strong>

                                            <?= number_format(
                                                        $entry->total_debit,
                                                        2,
                                                        ',',
                                                        ' '
                                                    ); ?>

                                        </strong>

                                    </td>

                                    <td class="text-right">

                                        <strong>

                                            <?= number_format(
                                                        $entry->total_credit,
                                                        2,
                                                        ',',
                                                        ' '
                                                    ); ?>

                                        </strong>

                                    </td>

                                    <td class="text-right">

                                        <?= number_format(
                                                    $entry->total_tva,
                                                    2,
                                                    ',',
                                                    ' '
                                                ); ?>

                                    </td>

                                    <td>

                                        <?php if ($entry->status == 'draft'): ?>

                                        <span class="badge badge-warning">

                                            Brouillon

                                        </span>

                                        <?php elseif ($entry->status == 'validated'): ?>

                                        <span class="badge badge-success">

                                            Validée

                                        </span>

                                        <?php else: ?>

                                        <span class="badge badge-danger">

                                            Annulée

                                        </span>

                                        <?php endif; ?>

                                    </td>

                                    <td class="text-center">

                                        <button class="btn btn-info btn-sm" onclick="viewEntry(<?= $entry->id ?>)">

                                            <i class="fas fa-eye"></i>

                                        </button>

                                        <button class="btn btn-warning btn-sm" onclick="editEntry(<?= $entry->id ?>)">

                                            <i class="fas fa-edit"></i>

                                        </button>

                                        <button class="btn btn-danger btn-sm" onclick="deleteEntry(<?= $entry->id ?>)">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </td>

                                </tr>

                                <?php endforeach; ?>

                                <?php else: ?>

                                <tr>

                                    <td colspan="9" class="text-center py-5">

                                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>

                                        <br>

                                        Aucune écriture enregistrée.

                                    </td>

                                </tr>

                                <?php endif; ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <!-- Modal Nouvelle écriture -->
            <div class="modal fade" id="addEntryModal">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">

                        <div class="modal-header" style="background:#0f766e;color:#fff;">
                            <h5 class="modal-title">
                                <i class="fas fa-edit mr-1"></i>
                                Nouvelle écriture comptable
                            </h5>

                            <button type="button" class="close text-white" data-dismiss="modal">
                                &times;
                            </button>
                        </div>

                        <div class="modal-body">

                            <form action="<?= base_url('finance/accounting-entry-store') ?>" method="post"
                                class="entry-form">

                                <!-- Informations générales -->
                                <div class="card finance-card mb-4">
                                    <div class="card-header bg-white border-0">
                                        <h5 class="section-title-finance mb-0">
                                            <i class="fas fa-file-invoice mr-2 text-success"></i>
                                            Informations de la pièce comptable
                                        </h5>
                                        <small class="text-muted">
                                            Ces informations seront appliquées à toutes les lignes de l’écriture.
                                        </small>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Exercice comptable *</label>
                                                    <select name="exercise_id" class="form-control" required>
                                                        <option value="">-- Sélectionner --</option>
                                                        <?php if (!empty($exercises)) : ?>
                                                        <?php foreach ($exercises as $ex) : ?>
                                                        <option value="<?= $ex->id ?>"
                                                            <?= $ex->is_active ? 'selected' : '' ?>>
                                                            <?= $ex->name ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Date opération *</label>
                                                    <input type="date" name="entry_date" class="form-control"
                                                        value="<?= date('Y-m-d') ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Code journal *</label>
                                                    <select name="journal_id" class="form-control" required>
                                                        <option value="">-- Sélectionner --</option>
                                                        <?php if (!empty($journalCodes)) : ?>
                                                        <?php foreach ($journalCodes as $journal) : ?>
                                                        <option value="<?= $journal->id ?>">
                                                            <?= $journal->journal_code ?> -
                                                            <?= $journal->journal_name ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>N° pièce / Référence</label>
                                                    <input type="text" name="piece_number" class="form-control"
                                                        placeholder="Ex : PC-2026-0001">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label>Libellé général *</label>
                                                    <input type="text" name="label" class="form-control"
                                                        placeholder="Ex : Paiement achat ciment chantier Gitega"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label>Chantier concerné</label>
                                                    <select name="chantier_id" class="form-control">
                                                        <option value="">Aucun chantier</option>
                                                        <?php if (!empty($chantiers)) : ?>
                                                        <?php foreach ($chantiers as $chantier) : ?>
                                                        <option value="<?= $chantier->id ?>">
                                                            <?= $chantier->name ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label>Devise</label>
                                                    <select name="currency" class="form-control">
                                                        <option value="FBU">FBU</option>
                                                        <option value="USD">USD</option>
                                                        <option value="EUR">EUR</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="help-panel mb-4">
                                    <strong>
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Rappel comptable :
                                    </strong>
                                    Une écriture doit toujours être équilibrée.
                                    Le total débit doit être égal au total crédit avant enregistrement.
                                </div>

                                <!-- Lignes -->
                                <div class="card finance-card mb-4">
                                    <div class="card-header bg-white border-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="section-title-finance mb-0">
                                                    <i class="fas fa-list mr-2 text-success"></i>
                                                    Lignes de l’écriture
                                                </h5>
                                                <small class="text-muted">
                                                    Saisissez les comptes débit/crédit concernés par l’opération.
                                                </small>
                                            </div>

                                            <button type="button" class="btn btn-finance btn-sm"
                                                onclick="addEntryLine()">
                                                <i class="fas fa-plus-circle mr-1"></i>
                                                Ajouter une ligne
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table entry-table mb-0" id="entryLinesTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width:15%;">Compte débit *</th>
                                                        <th style="width:15%;">Compte crédit *</th>
                                                        <th style="width:18%;">Libellé ligne</th>
                                                        <th style="width:10%;" class="text-right">Débit</th>
                                                        <th style="width:10%;" class="text-right">Crédit</th>
                                                        <th style="width:5%;" class="text-center">TVA ?</th>
                                                        <th style="width:10%;" class="text-center">Type TVA</th>
                                                        <th style="width:8%;" class="text-right">Taux</th>
                                                        <th style="width:20%;" class="text-right">Mt TVA</th>
                                                        <th style="width:70px;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="entryLinesBody">
                                                    <?php for ($r = 0; $r < 1; $r++) : ?>
                                                    <tr>
                                                        <td>
                                                            <select name="debit_account_id[]" class="form-control"
                                                                required>
                                                                <option value="">-- Débit --</option>
                                                                <?php if (!empty($chart_accounts)) : ?>
                                                                <?php foreach ($chart_accounts as $account) : ?>
                                                                <option value="<?= $account->id ?>">
                                                                    <?= $account->account_code ?> -
                                                                    <?= $account->account_name ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <select name="credit_account_id[]" class="form-control"
                                                                required>
                                                                <option value="">-- Crédit --</option>
                                                                <?php if (!empty($chart_accounts)) : ?>
                                                                <?php foreach ($chart_accounts as $account) : ?>
                                                                <option value="<?= $account->id ?>">
                                                                    <?= $account->account_code ?> -
                                                                    <?= $account->account_name ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="text" name="line_label[]" class="form-control"
                                                                placeholder="Libellé">
                                                        </td>

                                                        <td>
                                                            <input type="number" name="debit[]"
                                                                class="form-control amount-input debit-input" value="0"
                                                                step="0.01" oninput="calculateTotals()">
                                                        </td>

                                                        <td>
                                                            <input type="number" name="credit[]"
                                                                class="form-control amount-input credit-input" value="0"
                                                                step="0.01" oninput="calculateTotals()">
                                                        </td>

                                                        <td>
                                                            <select name="has_tva[]" class="form-control has-tva"
                                                                onchange="toggleTva(this)">
                                                                <option value="0">Non</option>
                                                                <option value="1">Oui</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <select name="tva_type[]" class="form-control tva-type">
                                                                <option value="">-- Aucun --</option>
                                                                <option value="deductible">TVA déductible</option>
                                                                <option value="collected">TVA collectée</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="number" name="tva_rate[]"
                                                                class="form-control amount-input tva-rate" value="0"
                                                                step="0.01" readonly oninput="calculateTotals()">
                                                        </td>

                                                        <td>
                                                            <input type="number" name="tva_amount[]"
                                                                class="form-control amount-input tva-amount" value="0"
                                                                step="0.01" readonly>
                                                        </td>

                                                        <td class="text-center">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm btn-remove-line"
                                                                onclick="removeEntryLine(this)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php endfor; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card-footer bg-white">
                                        <div class="row align-items-center">

                                            <div class="col-md-3">
                                                <div class="total-box">
                                                    <small class="text-muted">Total débit</small>
                                                    <h5 id="totalDebit">0.00</h5>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="total-box">
                                                    <small class="text-muted">Total crédit</small>
                                                    <h5 id="totalCredit">0.00</h5>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="total-box">
                                                    <small class="text-muted">Total TVA</small>
                                                    <h5 id="totalTva">0.00</h5>
                                                </div>
                                            </div>

                                            <div class="col-md-3 text-right">
                                                <span id="balanceStatus" class="total-unbalanced">
                                                    Non équilibré
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Observation -->
                                <div class="card finance-card mb-4">
                                    <div class="card-body">
                                        <div class="form-group mb-0">
                                            <label>Observation / Note interne</label>
                                            <textarea name="note" class="form-control" rows="3"
                                                placeholder="Informations complémentaires sur cette écriture"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="entry-actions text-right">
                                    <button type="reset" class="btn btn-light">
                                        <i class="fas fa-undo mr-1"></i>
                                        Réinitialiser
                                    </button>

                                    <button type="submit" class="btn btn-finance" id="submitEntryBtn" disabled>
                                        <i class="fas fa-save mr-1"></i>
                                        Enregistrer l’écriture
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <script>
            function accountOptions() {
                return `
                        <option value="">-- Sélectionner --</option>
                        <?php if (!empty($chart_accounts)) : ?>
                            <?php foreach ($chart_accounts as $account) : ?>
                                <option value="<?= $account->id ?>">
                                    <?= $account->account_code ?> - <?= addslashes($account->account_name) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    `;
            }

            function addEntryLine() {
                let row = `
                    <tr>
                        <td>
                            <select name="debit_account_id[]" class="form-control" required>
                                ${accountOptions()}
                            </select>
                        </td>

                        <td>
                            <select name="credit_account_id[]" class="form-control" required>
                                ${accountOptions()}
                            </select>
                        </td>

                        <td>
                            <input type="text" name="line_label[]" class="form-control" placeholder="Libellé">
                        </td>

                        <td>
                            <input type="number" name="debit[]" class="form-control amount-input debit-input"
                                value="0" step="0.01" oninput="calculateTotals()">
                        </td>

                        <td>
                            <input type="number" name="credit[]" class="form-control amount-input credit-input"
                                value="0" step="0.01" oninput="calculateTotals()">
                        </td>

                        <td>
                            <select name="has_tva[]" class="form-control has-tva" onchange="toggleTva(this)">
                                <option value="0">Non</option>
                                <option value="1">Oui</option>
                            </select>
                        </td>

                        <td>
                            <select name="tva_type[]" class="form-control tva-type">
                                <option value="">-- Aucun --</option>
                                <option value="deductible">TVA déductible</option>
                                <option value="collected">TVA collectée</option>
                            </select>
                        </td>

                        <td>
                            <input type="number" name="tva_rate[]" class="form-control amount-input tva-rate"
                                value="0" step="0.01" readonly oninput="calculateTotals()">
                        </td>

                        <td>
                            <input type="number" name="tva_amount[]" class="form-control amount-input tva-amount"
                                value="0" step="0.01" readonly>
                        </td>

                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btn-remove-line" onclick="removeEntryLine(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#entryLinesBody').append(row);
                calculateTotals();
            }

            function toggleTva(select) {
                let row = $(select).closest('tr');
                let rateInput = row.find('.tva-rate');
                let typeInput = row.find('.tva-type');

                if ($(select).val() === '1') {
                    rateInput.prop('readonly', false);
                    rateInput.val(rateInput.val() == 0 ? 18 : rateInput.val());

                    if (typeInput.val() === '') {
                        typeInput.val('deductible');
                    }
                } else {
                    rateInput.val(0);
                    rateInput.prop('readonly', true);

                    typeInput.val('');
                    row.find('.tva-amount').val(0);
                }

                calculateTotals();
            }

            function removeEntryLine(button) {
                let totalRows = $('#entryLinesBody tr').length;

                if (totalRows <= 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Attention',
                        text: 'Une écriture comptable doit contenir au minimum deux lignes.'
                    });
                    return;
                }

                $(button).closest('tr').remove();
                calculateTotals();
            }

            function calculateTotals() {
                let totalDebit = 0;
                let totalCredit = 0;
                let totalTva = 0;

                $('#entryLinesBody tr').each(function() {
                    let row = $(this);

                    let debit = parseFloat(row.find('.debit-input').val()) || 0;
                    let credit = parseFloat(row.find('.credit-input').val()) || 0;
                    let hasTva = row.find('.has-tva').val();
                    let rate = parseFloat(row.find('.tva-rate').val()) || 0;

                    let baseAmount = debit > 0 ? debit : credit;
                    let tvaAmount = 0;

                    if (hasTva === '1' && rate > 0) {
                        tvaAmount = baseAmount * rate / 100;
                    }

                    row.find('.tva-amount').val(tvaAmount.toFixed(2));

                    totalDebit += debit;
                    totalCredit += credit;
                    totalTva += tvaAmount;
                });

                $('#totalDebit').text(totalDebit.toLocaleString('fr-FR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));

                $('#totalCredit').text(totalCredit.toLocaleString('fr-FR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));

                $('#totalTva').text(totalTva.toLocaleString('fr-FR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));

                if (totalDebit > 0 && totalDebit === totalCredit) {
                    $('#balanceStatus')
                        .removeClass('total-unbalanced')
                        .addClass('total-balanced')
                        .text('Écriture équilibrée');

                    $('#submitEntryBtn').prop('disabled', false);
                } else {
                    $('#balanceStatus')
                        .removeClass('total-balanced')
                        .addClass('total-unbalanced')
                        .text('Non équilibré');

                    $('#submitEntryBtn').prop('disabled', true);
                }
            }

            calculateTotals();
            </script>

        </div>

    </section>
</div>

<div class="modal fade" id="viewEntryModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye mr-1"></i>
                    Détail de l’écriture comptable
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Pièce :</strong><br><span id="view_piece"></span></div>
                    <div class="col-md-3"><strong>Date :</strong><br><span id="view_date"></span></div>
                    <div class="col-md-3"><strong>Journal :</strong><br><span id="view_journal"></span></div>
                    <div class="col-md-3"><strong>Devise :</strong><br><span id="view_currency"></span></div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6"><strong>Libellé :</strong><br><span id="view_label"></span></div>
                    <div class="col-md-3"><strong>Chantier :</strong><br><span id="view_chantier"></span></div>
                    <div class="col-md-3"><strong>Statut :</strong><br><span id="view_status"></span></div>
                </div>

                <hr>

                <table class="table table-bordered entry-table">
                    <thead>
                        <tr>
                            <th>Compte débit</th>
                            <th>Compte crédit</th>
                            <th>Libellé</th>
                            <th class="text-right">Débit</th>
                            <th class="text-right">Crédit</th>
                            <th>TVA</th>
                            <th>Type TVA</th>
                            <th class="text-right">Taux</th>
                            <th class="text-right">Mt TVA</th>
                        </tr>
                    </thead>
                    <tbody id="viewEntryLinesBody"></tbody>
                </table>

                <div class="row mt-3">
                    <div class="col-md-4"><strong>Total débit :</strong> <span id="view_total_debit"></span></div>
                    <div class="col-md-4"><strong>Total crédit :</strong> <span id="view_total_credit"></span></div>
                    <div class="col-md-4"><strong>Total TVA :</strong> <span id="view_total_tva"></span></div>
                </div>

                <hr>

                <strong>Observation :</strong>
                <p id="view_observation" class="text-muted mb-0"></p>

            </div>

        </div>
    </div>
</div>

<script>
function viewEntry(id) {
    $.ajax({
        url: "<?= base_url('finance/accounting-entry-view/') ?>" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {

            let entry = res.entry;
            let lines = res.lines;

            $('#view_piece').text(entry.piece_number);
            $('#view_date').text(entry.operation_date);
            $('#view_journal').text(entry.journal_id);
            $('#view_currency').text(entry.currency);
            $('#view_label').text(entry.general_label);
            $('#view_chantier').text(entry.chantier_id ? entry.chantier_id : 'Aucun');
            $('#view_status').text(entry.status);
            $('#view_total_debit').text(formatMoney(entry.total_debit));
            $('#view_total_credit').text(formatMoney(entry.total_credit));
            $('#view_total_tva').text(formatMoney(entry.total_tva));
            $('#view_observation').text(entry.observation ? entry.observation : 'Aucune observation');

            let html = '';

            lines.forEach(function(line) {
                html += `
                    <tr>
                        <td>${line.debit_code} - ${line.debit_name}</td>
                        <td>${line.credit_code} - ${line.credit_name}</td>
                        <td>${line.line_label ?? ''}</td>
                        <td class="text-right">${formatMoney(line.debit)}</td>
                        <td class="text-right">${formatMoney(line.credit)}</td>
                        <td>${line.has_tva == 1 ? 'Oui' : 'Non'}</td>
                        <td>${line.tva_type ? line.tva_type : '-'}</td>
                        <td class="text-right">${line.tva_rate}</td>
                        <td class="text-right">${formatMoney(line.tva_amount)}</td>
                    </tr>
                `;
            });

            $('#viewEntryLinesBody').html(html);
            $('#viewEntryModal').modal('show');
        }
    });
}

function formatMoney(value) {
    return parseFloat(value || 0).toLocaleString('fr-FR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}
</script>

<div class="modal fade" id="editEntryModal">
    <div class="modal-dialog modal-xl">
        <form action="<?= base_url('finance/accounting-entry-update') ?>" method="post">

            <input type="hidden" name="id" id="edit_entry_id">

            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-1"></i>
                        Modifier l’écriture comptable
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-3">
                            <label>Exercice</label>
                            <select name="exercise_id" id="edit_exercise_id" class="form-control">
                                <?php foreach ($exercises as $ex): ?>
                                <option value="<?= $ex->id ?>"><?= $ex->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Date opération</label>
                            <input type="date" name="entry_date" id="edit_entry_date" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label>Journal</label>
                            <select name="journal_id" id="edit_journal_id" class="form-control">
                                <?php foreach ($journalCodes as $journal): ?>
                                <option value="<?= $journal->id ?>">
                                    <?= $journal->journal_code ?> - <?= $journal->journal_name ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>N° pièce</label>
                            <input type="text" name="piece_number" id="edit_piece_number" class="form-control">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Libellé général</label>
                            <input type="text" name="label" id="edit_label" class="form-control">
                        </div>

                        <div class="col-md-3 mt-3">
                            <label>Chantier</label>
                            <select name="chantier_id" id="edit_chantier_id" class="form-control">
                                <option value="">Aucun chantier</option>
                                <?php foreach ($chantiers as $chantier): ?>
                                <option value="<?= $chantier->id ?>"><?= $chantier->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3 mt-3">
                            <label>Devise</label>
                            <select name="currency" id="edit_currency" class="form-control">
                                <option value="FBU">FBU</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>

                    </div>

                    <hr>

                    <h5 class="font-weight-bold">
                        <i class="fas fa-list mr-1"></i>
                        Lignes de l’écriture
                    </h5>

                    <div class="text-right mb-2">
                        <button type="button" class="btn btn-finance btn-sm" onclick="addEditEntryLine()">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Ajouter une ligne
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table entry-table">
                            <thead>
                                <tr>
                                    <th>Compte débit</th>
                                    <th>Compte crédit</th>
                                    <th>Libellé</th>
                                    <th>Débit</th>
                                    <th>Crédit</th>
                                    <th>TVA ?</th>
                                    <th>Type TVA</th>
                                    <th>Taux</th>
                                    <th>Mt TVA</th>
                                    <th style="width:70px;" class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody id="editEntryLinesBody"></tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label>Observation</label>
                        <textarea name="note" id="edit_note" class="form-control" rows="3"></textarea>
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
function editEntry(id) {
    $.ajax({
        url: "<?= base_url('finance/accounting-entry-edit/') ?>" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {

            let entry = res.entry;
            let lines = res.lines;

            $('#edit_entry_id').val(entry.id);
            $('#edit_exercise_id').val(entry.exercise_id);
            $('#edit_entry_date').val(entry.operation_date);
            $('#edit_journal_id').val(entry.journal_id);
            $('#edit_piece_number').val(entry.piece_number);
            $('#edit_label').val(entry.general_label);
            $('#edit_chantier_id').val(entry.chantier_id);
            $('#edit_currency').val(entry.currency);
            $('#edit_note').val(entry.observation);

            let html = '';

            lines.forEach(function(line) {
                html += `
                    <tr>
                        <td>
                            <select name="debit_account_id[]" class="form-control">
                                ${accountOptionsSelected(line.debit_account_id)}
                            </select>
                        </td>

                        <td>
                            <select name="credit_account_id[]" class="form-control">
                                ${accountOptionsSelected(line.credit_account_id)}
                            </select>
                        </td>

                        <td>
                            <input type="text" name="line_label[]" class="form-control" value="${line.line_label ?? ''}">
                        </td>

                        <td>
                            <input type="number" name="debit[]" class="form-control amount-input edit-debit-input"
                                value="${line.debit}" step="0.01" oninput="calculateEditTotals()">
                        </td>

                        <td>
                            <input type="number" name="credit[]" class="form-control amount-input edit-credit-input"
                                value="${line.credit}" step="0.01" oninput="calculateEditTotals()">
                        </td>

                        <td>
                            <select name="has_tva[]" class="form-control edit-has-tva" onchange="toggleEditTva(this)">
                                <option value="0" ${line.has_tva == 0 ? 'selected' : ''}>Non</option>
                                <option value="1" ${line.has_tva == 1 ? 'selected' : ''}>Oui</option>
                            </select>
                        </td>

                        <td>
                            <select name="tva_type[]" class="form-control edit-tva-type">
                                <option value="">-- Aucun --</option>
                                <option value="deductible" ${line.tva_type == 'deductible' ? 'selected' : ''}>TVA déductible</option>
                                <option value="collected" ${line.tva_type == 'collected' ? 'selected' : ''}>TVA collectée</option>
                            </select>
                        </td>

                        <td>
                            <input type="number" name="tva_rate[]" class="form-control amount-input edit-tva-rate"
                                value="${line.tva_rate}" step="0.01" oninput="calculateEditTotals()">
                        </td>

                        <td>
                            <input type="number" name="tva_amount[]" class="form-control amount-input edit-tva-amount"
                                value="${line.tva_amount}" step="0.01" readonly>
                        </td>

                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeEditEntryLine(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    `;
            });

            $('#editEntryLinesBody').html(html);

            calculateEditTotals();

            $('#editEntryModal').modal('show');
        }
    });
}

function addEditEntryLine() {
    let row = `
    <tr>
        <td>
            <select name="debit_account_id[]" class="form-control">
                ${accountOptionsSelected('')}
            </select>
        </td>

        <td>
            <select name="credit_account_id[]" class="form-control">
                ${accountOptionsSelected('')}
            </select>
        </td>

        <td>
            <input type="text" name="line_label[]" class="form-control" placeholder="Libellé">
        </td>

        <td>
            <input type="number" name="debit[]" class="form-control amount-input edit-debit-input"
                   value="0" step="0.01" oninput="calculateEditTotals()">
        </td>

        <td>
            <input type="number" name="credit[]" class="form-control amount-input edit-credit-input"
                   value="0" step="0.01" oninput="calculateEditTotals()">
        </td>

        <td>
            <select name="has_tva[]" class="form-control edit-has-tva" onchange="toggleEditTva(this)">
                <option value="0">Non</option>
                <option value="1">Oui</option>
            </select>
        </td>

        <td>
            <select name="tva_type[]" class="form-control edit-tva-type">
                <option value="">-- Aucun --</option>
                <option value="deductible">TVA déductible</option>
                <option value="collected">TVA collectée</option>
            </select>
        </td>

        <td>
            <input type="number" name="tva_rate[]" class="form-control amount-input edit-tva-rate"
                   value="0" step="0.01" oninput="calculateEditTotals()">
        </td>

        <td>
            <input type="number" name="tva_amount[]" class="form-control amount-input edit-tva-amount"
                   value="0" step="0.01" readonly>
        </td>

        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeEditEntryLine(this)">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
    `;

    $('#editEntryLinesBody').append(row);
    calculateEditTotals();
}

function removeEditEntryLine(button) {
    if ($('#editEntryLinesBody tr').length <= 1) {
        Swal.fire({
            icon: 'warning',
            title: 'Attention',
            text: 'Une écriture doit contenir au moins une ligne.'
        });
        return;
    }

    $(button).closest('tr').remove();
    calculateEditTotals();
}

function toggleEditTva(select) {
    let row = $(select).closest('tr');
    let rateInput = row.find('.edit-tva-rate');
    let typeInput = row.find('.edit-tva-type');

    if ($(select).val() === '1') {
        rateInput.prop('readonly', false);

        if (parseFloat(rateInput.val()) == 0) {
            rateInput.val(18);
        }

        if (typeInput.val() === '') {
            typeInput.val('deductible');
        }
    } else {
        rateInput.val(0);
        rateInput.prop('readonly', true);
        typeInput.val('');
        row.find('.edit-tva-amount').val(0);
    }

    calculateEditTotals();
}

function calculateEditTotals() {
    let totalDebit = 0;
    let totalCredit = 0;
    let totalTva = 0;

    $('#editEntryLinesBody tr').each(function() {
        let row = $(this);

        let debit = parseFloat(row.find('.edit-debit-input').val()) || 0;
        let credit = parseFloat(row.find('.edit-credit-input').val()) || 0;
        let hasTva = row.find('.edit-has-tva').val();
        let rate = parseFloat(row.find('.edit-tva-rate').val()) || 0;

        let baseAmount = debit > 0 ? debit : credit;
        let tvaAmount = 0;

        if (hasTva === '1' && rate > 0) {
            tvaAmount = baseAmount * rate / 100;
        }

        row.find('.edit-tva-amount').val(tvaAmount.toFixed(2));

        totalDebit += debit;
        totalCredit += credit;
        totalTva += tvaAmount;
    });
}

function accountOptionsSelected(selectedId) {
    let options = `<option value="">-- Sélectionner --</option>`;

    <?php foreach ($chart_accounts as $account): ?>
    options += `
            <option value="<?= $account->id ?>" ${selectedId == <?= $account->id ?> ? 'selected' : ''}>
                <?= $account->account_code ?> - <?= addslashes($account->account_name) ?>
            </option>
        `;
    <?php endforeach; ?>

    return options;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function deleteEntry(id) {
    Swal.fire({

        title: 'Supprimer cette écriture ?',

        text: "Cette action est irréversible.",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',

        cancelButtonColor: '#6c757d',

        confirmButtonText: '<i class="fas fa-trash"></i> Oui, supprimer',

        cancelButtonText: '<i class="fas fa-times"></i> Annuler'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "<?= base_url('finance/accounting-entry-delete') ?>",

                type: "POST",

                data: {
                    id: id
                },

                dataType: "json",

                success: function(res) {

                    if (res.status) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Supprimée',

                            text: res.message,

                            timer: 1800,

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