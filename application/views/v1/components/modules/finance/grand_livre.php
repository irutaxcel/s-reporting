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

            <!-- ici le contenu du grand livre comptable -->

            <style>
            .gl-header {
                background: linear-gradient(135deg, #0f766e, #102033);
                color: #fff;
                border-radius: 16px;
                padding: 22px;
                margin-bottom: 25px;
            }

            .gl-card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
                overflow: hidden;
                margin-bottom: 22px;
                background: #fff;
            }

            .gl-account-header {
                background: #102033;
                color: #fff;
                padding: 15px 20px;
            }

            .gl-account-code {
                background: #ecfdf5;
                color: #0f766e;
                padding: 7px 13px;
                border-radius: 30px;
                font-weight: 800;
                display: inline-block;
            }

            .gl-table thead th {
                background: #f1f5f9;
                color: #102033;
                font-size: 12px;
                text-transform: uppercase;
                padding: 12px;
                border-bottom: 2px solid #102033;
                white-space: nowrap;
            }

            .gl-table tbody td {
                padding: 11px 12px;
                font-size: 13px;
                vertical-align: middle;
                border-bottom: 1px solid #e5e7eb;
            }

            .gl-table tfoot td {
                background: #f8fafc;
                font-weight: 800;
                padding: 13px 12px;
                border-top: 2px solid #102033;
            }

            .balance-positive {
                color: #166534;
                font-weight: 800;
            }

            .balance-negative {
                color: #991b1b;
                font-weight: 800;
            }

            .filter-box {
                background: #fff;
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
                margin-bottom: 22px;
            }

            .filter-box label {
                font-weight: 700;
                font-size: 13px;
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

            .gl-summary {
                background: #f8fafc;
                border-radius: 14px;
                padding: 15px;
                border: 1px solid #e5e7eb;
                margin-bottom: 20px;
            }
            </style>

            <div class="gl-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-1">
                            <i class="fas fa-book-open mr-2"></i>
                            Grand Livre Comptable
                        </h4>
                        <p class="mb-0">
                            Consultation détaillée des mouvements par compte comptable avec solde progressif.
                        </p>
                    </div>

                    <div>
                        <button class="btn btn-light btn-sm">
                            <i class="fas fa-print mr-1"></i>
                            Imprimer
                        </button>

                        <button class="btn btn-light btn-sm">
                            <i class="fas fa-file-excel mr-1"></i>
                            Export Excel
                        </button>
                    </div>
                </div>
            </div>

            <div class="filter-box">
                <div class="row">

                    <div class="col-md-3">
                        <label>Exercice comptable</label>
                        <select class="form-control">
                            <option>Exercice 2026</option>
                            <option>Exercice 2025</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Compte comptable</label>
                        <select class="form-control">
                            <option>Tous les comptes</option>
                            <option>512000 - Compte bancaire principal</option>
                            <option>521000 - Caisse principale</option>
                            <option>601000 - Achats matériaux</option>
                            <option>701000 - Prestations facturées</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Du</label>
                        <input type="date" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Au</label>
                        <input type="date" class="form-control">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-finance btn-block">
                            <i class="fas fa-search mr-1"></i>
                            Filtrer
                        </button>
                    </div>

                </div>
            </div>

            <?php
            $totalAccounts = !empty($accounts) ? count($accounts) : 0;
            $totalDebitGlobal = 0;
            $totalCreditGlobal = 0;

            if (!empty($accounts)) {
                foreach ($accounts as $acc) {
                    $totalDebitGlobal  += (float) ($acc['total_debit'] ?? 0);
                    $totalCreditGlobal += (float) ($acc['total_credit'] ?? 0);
                }
            }

            $soldeGlobal = $totalDebitGlobal - $totalCreditGlobal;
            ?>

            <div class="gl-summary">
                <div class="row text-center">

                    <div class="col-md-3">
                        <strong>Comptes affichés</strong><br>
                        <span class="text-success font-weight-bold">
                            <?= $totalAccounts ?>
                        </span>
                    </div>

                    <div class="col-md-3">
                        <strong>Total débit</strong><br>
                        <span class="font-weight-bold">
                            <?= number_format($totalDebitGlobal, 2, ',', ' ') ?> FBU
                        </span>
                    </div>

                    <div class="col-md-3">
                        <strong>Total crédit</strong><br>
                        <span class="font-weight-bold">
                            <?= number_format($totalCreditGlobal, 2, ',', ' ') ?> FBU
                        </span>
                    </div>

                    <div class="col-md-3">
                        <strong>Solde global</strong><br>
                        <span class="<?= $soldeGlobal >= 0 ? 'balance-positive' : 'balance-negative' ?>">
                            <?= number_format($soldeGlobal, 2, ',', ' ') ?> FBU
                        </span>
                    </div>

                </div>
            </div>

            <!-- Compte 512000 -->
            <div class="gl-card">

                <div class="gl-account-header">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <span class="gl-account-code">
                                <?= $account['account_code'] ?? '-' ?>
                            </span>

                            <strong class="ml-2">
                                <?= $account['account_name'] ?? 'Compte comptable' ?>
                            </strong>
                        </div>

                        <div class="text-right">
                            <small>Solde final :</small><br>

                            <?php $balance = (float) ($account['balance'] ?? 0); ?>

                            <strong class="<?= $balance >= 0 ? 'balance-positive' : 'balance-negative' ?>">
                                <?= number_format($balance, 2, ',', ' ') ?> FBU
                            </strong>
                        </div>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table gl-table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Pièce</th>
                                <th>Journal</th>
                                <th>Libellé</th>
                                <th class="text-right">Débit</th>
                                <th class="text-right">Crédit</th>
                                <th class="text-right">Solde</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>01/07/2026</td>
                                <td>PC-2026-0002</td>
                                <td>BAN</td>
                                <td>Paiement fournisseur matériaux</td>
                                <td class="text-right">0,00</td>
                                <td class="text-right">350 000,00</td>
                                <td class="text-right balance-negative">-350 000,00</td>
                            </tr>

                            <tr>
                                <td>05/07/2026</td>
                                <td>PC-2026-0010</td>
                                <td>BAN</td>
                                <td>Paiement transport chantier</td>
                                <td class="text-right">0,00</td>
                                <td class="text-right">310 000,00</td>
                                <td class="text-right balance-negative">-660 000,00</td>
                            </tr>

                            <tr>
                                <td>08/07/2026</td>
                                <td>PC-2026-0015</td>
                                <td>VEN</td>
                                <td>Encaissement facturation marché</td>
                                <td class="text-right">1 910 000,00</td>
                                <td class="text-right">0,00</td>
                                <td class="text-right balance-positive">1 250 000,00</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Total compte 512000</td>
                                <td class="text-right">1 910 000,00</td>
                                <td class="text-right">660 000,00</td>
                                <td class="text-right">1 250 000,00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

            <!-- Compte 521000 -->
            <div class="gl-card">

                <div class="gl-account-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="gl-account-code">521000</span>
                            <strong class="ml-2">Caisse principale</strong>
                        </div>
                        <div>
                            Solde final :
                            <strong>420 000 FBU</strong>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table gl-table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Pièce</th>
                                <th>Journal</th>
                                <th>Libellé</th>
                                <th class="text-right">Débit</th>
                                <th class="text-right">Crédit</th>
                                <th class="text-right">Solde</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>02/07/2026</td>
                                <td>PC-2026-0004</td>
                                <td>CAI</td>
                                <td>Paiement salaire chantier</td>
                                <td class="text-right">0,00</td>
                                <td class="text-right">420 000,00</td>
                                <td class="text-right balance-negative">-420 000,00</td>
                            </tr>

                            <tr>
                                <td>03/07/2026</td>
                                <td>PC-2026-0005</td>
                                <td>OD</td>
                                <td>Régularisation caisse</td>
                                <td class="text-right">840 000,00</td>
                                <td class="text-right">0,00</td>
                                <td class="text-right balance-positive">420 000,00</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Total compte 521000</td>
                                <td class="text-right">840 000,00</td>
                                <td class="text-right">420 000,00</td>
                                <td class="text-right">420 000,00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

            <!-- Compte 601000 -->
            <div class="gl-card">

                <div class="gl-account-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="gl-account-code">601000</span>
                            <strong class="ml-2">Achats matériaux de construction</strong>
                        </div>
                        <div>
                            Solde final :
                            <strong>780 000 FBU</strong>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table gl-table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Pièce</th>
                                <th>Journal</th>
                                <th>Libellé</th>
                                <th class="text-right">Débit</th>
                                <th class="text-right">Crédit</th>
                                <th class="text-right">Solde</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (!empty($account['lines']) && is_array($account['lines'])) : ?>

                            <?php foreach ($account['lines'] as $line) : ?>

                            <tr>
                                <td>
                                    <?= !empty($line->operation_date) ? date('d/m/Y', strtotime($line->operation_date)) : '-' ?>
                                </td>

                                <td>
                                    <strong><?= !empty($line->piece_number) ? $line->piece_number : '-' ?></strong>
                                </td>

                                <td>
                                    <span class="badge badge-info">
                                        <?= !empty($line->journal_code) ? $line->journal_code : '-' ?>
                                    </span>
                                </td>

                                <td>
                                    <?= !empty($line->line_label) ? $line->line_label : (!empty($line->general_label) ? $line->general_label : '-') ?>
                                </td>

                                <td class="text-right font-weight-bold">
                                    <?= number_format((float) ($line->debit_amount ?? 0), 2, ',', ' ') ?>
                                </td>

                                <td class="text-right font-weight-bold">
                                    <?= number_format((float) ($line->credit_amount ?? 0), 2, ',', ' ') ?>
                                </td>

                                <td class="text-right font-weight-bold">
                                    <?= number_format((float) ($line->running_balance ?? 0), 2, ',', ' ') ?>
                                </td>
                            </tr>

                            <?php endforeach; ?>

                            <?php else : ?>

                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    Aucune ligne pour ce compte.
                                </td>
                            </tr>

                            <?php endif; ?>

                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">
                                    Total compte <?= $account['account_code'] ?? '-' ?>
                                </td>

                                <td class="text-right">
                                    <?= number_format((float) ($account['total_debit'] ?? 0), 2, ',', ' ') ?>
                                </td>

                                <td class="text-right">
                                    <?= number_format((float) ($account['total_credit'] ?? 0), 2, ',', ' ') ?>
                                </td>

                                <td class="text-right">
                                    <?= number_format((float) ($account['balance'] ?? 0), 2, ',', ' ') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->