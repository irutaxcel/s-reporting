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

            <!-- ici le contenu de la page d'ecriture comptable -->

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
                padding: 10px;
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
                position: sticky;
                bottom: 0;
                background: #fff;
                border-top: 1px solid #e5e7eb;
                padding: 15px;
                z-index: 20;
            }

            .btn-remove-line {
                width: 34px;
                height: 34px;
                padding: 0;
                border-radius: 8px;
            }
            </style>

            <!-- Bandeau principal -->
            <div class="entry-header-card mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4>
                            <i class="fas fa-edit mr-2"></i>
                            Saisie des écritures comptables
                        </h4>
                        <p class="mb-0">
                            Enregistrement des pièces comptables par journal, exercice, compte débit et compte crédit.
                        </p>
                    </div>

                    <div class="text-right">
                        <span class="piece-badge">
                            Pièce N° : AUTO
                        </span>
                        <br>
                        <small>Mode brouillard comptable</small>
                    </div>
                </div>
            </div>

            <form action="<?= base_url('finance/accounting-entry-store') ?>" method="post" class="entry-form">

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
                                        <option value="<?= $ex->id ?>" <?= $ex->is_active ? 'selected' : '' ?>>
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
                                            <?= $journal->journal_code ?> - <?= $journal->journal_name ?>
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
                                        placeholder="Ex : Paiement achat ciment chantier Gitega" required>
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

                <!-- Aide métier -->
                <div class="help-panel mb-4">
                    <strong>
                        <i class="fas fa-info-circle mr-1"></i>
                        Rappel comptable :
                    </strong>
                    Une écriture doit toujours être équilibrée.
                    Le total débit doit être égal au total crédit avant enregistrement.
                </div>

                <!-- Lignes comptables -->
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

                            <button type="button" class="btn btn-finance btn-sm" onclick="addEntryLine()">
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
                                        <th style="width:20%;">Compte débit *</th>
                                        <th style="width:20%;">Compte crédit *</th>
                                        <th style="width:18%;">Libellé ligne</th>
                                        <th style="width:10%;" class="text-right">Débit</th>
                                        <th style="width:10%;" class="text-right">Crédit</th>
                                        <th style="width:8%;" class="text-center">TVA ?</th>
                                        <th style="width:8%;" class="text-right">Taux</th>
                                        <th style="width:10%;" class="text-right">Mt TVA</th>
                                        <th style="width:70px;" class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="entryLinesBody">
                                    <?php for ($r = 0; $r < 2; $r++) : ?>
                                    <tr>
                                        <td>
                                            <select name="debit_account_id[]" class="form-control" required>
                                                <option value="">-- Débit --</option>
                                                <?php if (!empty($chart_accounts)) : ?>
                                                <?php foreach ($chart_accounts as $account) : ?>
                                                <option value="<?= $account->id ?>">
                                                    <?= $account->account_code ?> - <?= $account->account_name ?>
                                                </option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="credit_account_id[]" class="form-control" required>
                                                <option value="">-- Crédit --</option>
                                                <?php if (!empty($chart_accounts)) : ?>
                                                <?php foreach ($chart_accounts as $account) : ?>
                                                <option value="<?= $account->id ?>">
                                                    <?= $account->account_code ?> - <?= $account->account_name ?>
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
                                                class="form-control amount-input debit-input" value="0" step="0.01"
                                                oninput="calculateTotals()">
                                        </td>

                                        <td>
                                            <input type="number" name="credit[]"
                                                class="form-control amount-input credit-input" value="0" step="0.01"
                                                oninput="calculateTotals()">
                                        </td>

                                        <td>
                                            <select name="has_tva[]" class="form-control has-tva"
                                                onchange="toggleTva(this)">
                                                <option value="0">Non</option>
                                                <option value="1">Oui</option>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" name="tva_rate[]"
                                                class="form-control amount-input tva-rate" value="0" step="0.01"
                                                readonly oninput="calculateTotals()">
                                        </td>

                                        <td>
                                            <input type="number" name="tva_amount[]"
                                                class="form-control amount-input tva-amount" value="0" step="0.01"
                                                readonly>
                                        </td>

                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm btn-remove-line"
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

                if ($(select).val() === '1') {
                    rateInput.prop('readonly', false);
                    rateInput.val(rateInput.val() == 0 ? 18 : rateInput.val());
                } else {
                    rateInput.val(0);
                    rateInput.prop('readonly', true);
                    row.find('.tva-amount').val(0);
                }

                calculateTotals();
            }

            function removeEntryLine(button) {
                let totalRows = $('#entryLinesBody tr').length;

                if (totalRows <= 2) {
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

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->