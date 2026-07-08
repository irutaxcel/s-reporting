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

            <style>
            .balance-header {
                background: linear-gradient(135deg, #0f766e, #102033);
                color: #fff;
                border-radius: 16px;
                padding: 22px;
                margin-bottom: 24px;
            }

            .balance-card {
                background: #fff;
                border-radius: 16px;
                border: none;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
                overflow: hidden;
                margin-bottom: 22px;
            }

            .balance-filter {
                background: #fff;
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
                margin-bottom: 22px;
            }

            .balance-filter label {
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

            .balance-summary {
                background: #fff;
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
                margin-bottom: 22px;
                border-left: 5px solid #0f766e;
            }

            .summary-item {
                text-align: center;
                border-right: 1px solid #e5e7eb;
            }

            .summary-item:last-child {
                border-right: none;
            }

            .summary-item strong {
                display: block;
                color: #102033;
                font-size: 14px;
            }

            .summary-item span {
                font-weight: 800;
                font-size: 18px;
            }

            .balance-table thead th {
                background: #102033;
                color: #fff;
                font-size: 12px;
                text-transform: uppercase;
                padding: 13px 10px;
                border: none;
                white-space: nowrap;
                text-align: center;
            }

            .balance-table tbody td {
                padding: 12px 10px;
                vertical-align: middle;
                font-size: 13px;
                border-bottom: 1px solid #e5e7eb;
            }

            .balance-table tfoot td {
                background: #f1f5f9;
                font-weight: 800;
                padding: 14px 10px;
                border-top: 2px solid #102033;
            }

            .account-code {
                background: #ecfdf5;
                color: #0f766e;
                padding: 7px 12px;
                border-radius: 30px;
                font-weight: 800;
                display: inline-block;
            }

            .class-badge {
                background: #dbeafe;
                color: #1d4ed8;
                padding: 6px 10px;
                border-radius: 20px;
                font-weight: 700;
                font-size: 12px;
            }

            .balance-debit {
                color: #166534;
                font-weight: 800;
            }

            .balance-credit {
                color: #991b1b;
                font-weight: 800;
            }

            .balance-zero {
                color: #64748b;
                font-weight: 800;
            }

            .report-note {
                background: #ecfdf5;
                border-left: 5px solid #0f766e;
                border-radius: 12px;
                padding: 14px;
                margin-bottom: 20px;
                color: #102033;
            }
            </style>


            <div class="balance-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-1">
                            <i class="fas fa-balance-scale mr-2"></i>
                            Balance Générale
                        </h4>
                        <p class="mb-0">
                            Synthèse des mouvements débit/crédit et des soldes par compte comptable.
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

                        <button class="btn btn-light btn-sm">
                            <i class="fas fa-file-pdf mr-1"></i>
                            Export PDF
                        </button>
                    </div>
                </div>
            </div>


            <div class="balance-filter">
                <div class="row">

                    <div class="col-md-3">
                        <label>Exercice comptable</label>
                        <select class="form-control">
                            <option>Exercice 2026</option>
                            <option>Exercice 2025</option>
                            <option>Exercice 2024</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Classe comptable</label>
                        <select class="form-control">
                            <option>Toutes les classes</option>
                            <option>Classe 1 - Capitaux</option>
                            <option>Classe 2 - Immobilisations</option>
                            <option>Classe 3 - Stocks</option>
                            <option>Classe 4 - Tiers</option>
                            <option>Classe 5 - Trésorerie</option>
                            <option>Classe 6 - Charges</option>
                            <option>Classe 7 - Produits</option>
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


            <div class="balance-summary">
                <div class="row">

                    <div class="col-md-3 summary-item">
                        <strong>Comptes affichés</strong>
                        <span class="text-success">12</span>
                    </div>

                    <div class="col-md-3 summary-item">
                        <strong>Total mouvements débit</strong>
                        <span>9 416 000 FBU</span>
                    </div>

                    <div class="col-md-3 summary-item">
                        <strong>Total mouvements crédit</strong>
                        <span>9 416 000 FBU</span>
                    </div>

                    <div class="col-md-3 summary-item">
                        <strong>Équilibre balance</strong>
                        <span class="balance-debit">Équilibrée</span>
                    </div>

                </div>
            </div>


            <div class="report-note">
                <i class="fas fa-info-circle mr-1"></i>
                La balance générale présente pour chaque compte le total des mouvements débit/crédit ainsi que le solde
                débiteur ou créditeur.
            </div>


            <div class="balance-card">

                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-list mr-2 text-success"></i>
                        Balance des comptes
                    </h5>
                    <small class="text-muted">
                        État synthétique des comptes mouvementés sur la période sélectionnée.
                    </small>
                </div>

                <?php

                $totalDebit = 0;
                $totalCredit = 0;
                $totalDebitBalance = 0;
                $totalCreditBalance = 0;

                /** @var array $balance */
                foreach ($balance as $b) {

                    $totalDebit += $b->total_debit;
                    $totalCredit += $b->total_credit;

                    $totalDebitBalance += $b->debit_balance;
                    $totalCreditBalance += $b->credit_balance;
                }

                ?>

                <!-- <?= count($balance) ?>

                <?= number_format($totalDebit, 2, ',', ' ') ?>

                <?= number_format($totalCredit, 2, ',', ' ') ?>

                <?= number_format($totalDebitBalance, 2, ',', ' ') ?>

                <?= number_format($totalCreditBalance, 2, ',', ' ') ?> -->

                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table balance-table mb-0">

                            <thead>
                                <tr>
                                    <th rowspan="2">Compte</th>
                                    <th rowspan="2">Intitulé du compte</th>
                                    <th rowspan="2">Classe</th>
                                    <th colspan="2">Mouvements</th>
                                    <th colspan="2">Soldes</th>
                                    <th rowspan="2">Devise</th>
                                </tr>

                                <tr>
                                    <th>Débit</th>
                                    <th>Crédit</th>
                                    <th>Débiteur</th>
                                    <th>Créditeur</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach ($balance as $row): ?>

                                <tr>

                                    <td>
                                        <span class="account-code">
                                            <?= $row->account_code ?>
                                        </span>
                                    </td>

                                    <td>
                                        <strong><?= $row->account_name ?></strong>
                                    </td>

                                    <td class="text-center">

                                        <span class="class-badge">

                                            Classe <?= $row->class_number ?>

                                            -

                                            <?= $row->class_name ?>

                                        </span>

                                    </td>

                                    <td class="text-right">

                                        <?= number_format($row->total_debit, 2, ',', ' ') ?>

                                    </td>

                                    <td class="text-right">

                                        <?= number_format($row->total_credit, 2, ',', ' ') ?>

                                    </td>

                                    <td class="text-right balance-debit">

                                        <?= number_format($row->debit_balance, 2, ',', ' ') ?>

                                    </td>

                                    <td class="text-right balance-credit">

                                        <?= number_format($row->credit_balance, 2, ',', ' ') ?>

                                    </td>

                                    <td class="text-center">

                                        FBU

                                    </td>

                                </tr>

                                <?php endforeach; ?>

                            </tbody>

                            <tfoot>

                                <tr>

                                    <td colspan="3" class="text-right">

                                        <strong>TOTAL GÉNÉRAL</strong>

                                    </td>

                                    <td class="text-right">

                                        <?= number_format($totalDebit, 2, ',', ' ') ?>

                                    </td>

                                    <td class="text-right">

                                        <?= number_format($totalCredit, 2, ',', ' ') ?>

                                    </td>

                                    <td class="text-right">

                                        <?= number_format($totalDebitBalance, 2, ',', ' ') ?>

                                    </td>

                                    <td class="text-right">

                                        <?= number_format($totalCreditBalance, 2, ',', ' ') ?>

                                    </td>

                                    <td class="text-center">

                                        FBU

                                    </td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>
                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->