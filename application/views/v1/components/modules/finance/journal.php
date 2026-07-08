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

            <!-- ici le contenu de la page journal -->

            <style>
            .journal-entry-card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
                margin-bottom: 22px;
                overflow: hidden;
                background: #fff;
            }

            .journal-entry-header {
                background: linear-gradient(135deg, #0f766e, #102033);
                color: #fff;
                padding: 16px 20px;
            }

            .piece-badge {
                background: #ecfdf5;
                color: #0f766e;
                padding: 7px 12px;
                border-radius: 30px;
                font-weight: 800;
                display: inline-block;
            }

            .journal-line-table thead th {
                background: #102033;
                color: #fff;
                font-size: 12px;
                text-transform: uppercase;
                padding: 12px;
                border: none;
            }

            .journal-line-table tbody td {
                padding: 11px 12px;
                vertical-align: middle;
                border-bottom: 1px solid #e5e7eb;
                font-size: 13px;
            }

            .entry-total-box {
                background: #f8fafc;
                border-top: 1px solid #e5e7eb;
                padding: 14px 20px;
                font-weight: 800;
            }

            .tva-deductible {
                background: #dbeafe;
                color: #1d4ed8;
                padding: 6px 10px;
                border-radius: 20px;
                font-weight: 700;
            }

            .tva-collected {
                background: #fef3c7;
                color: #92400e;
                padding: 6px 10px;
                border-radius: 20px;
                font-weight: 700;
            }

            .tva-none {
                background: #f1f5f9;
                color: #64748b;
                padding: 6px 10px;
                border-radius: 20px;
                font-weight: 700;
            }

            .status-draft {
                background: #fef3c7;
                color: #92400e;
                padding: 6px 10px;
                border-radius: 20px;
                font-weight: 700;
            }

            .status-validated {
                background: #dcfce7;
                color: #166534;
                padding: 6px 10px;
                border-radius: 20px;
                font-weight: 700;
            }
            </style>

            <div class="mb-4">
                <div class="card journal-entry-card">
                    <div class="journal-entry-header">
                        <h4 class="mb-1">
                            <i class="fas fa-book mr-2"></i>
                            Journal Comptable détaillé
                        </h4>
                        <small>
                            Affichage des écritures comptables avec toutes leurs lignes débit/crédit et TVA.
                        </small>
                    </div>
                </div>
            </div>

            <?php if (!empty($entries)) : ?>

            <?php foreach ($entries as $entry) : ?>

            <div class="journal-entry-card">

                <div class="journal-entry-header">
                    <div class="row align-items-center">

                        <div class="col-md-3">
                            <span class="piece-badge">
                                <?= $entry->piece_number ?>
                            </span>
                        </div>

                        <div class="col-md-3">
                            <strong>Date :</strong>
                            <?= date('d/m/Y', strtotime($entry->operation_date)) ?>
                        </div>

                        <div class="col-md-3">
                            <strong>Journal :</strong>
                            <?= $entry->journal_code ?> - <?= $entry->journal_name ?>
                        </div>

                        <div class="col-md-3 text-right">
                            <?php if ($entry->status == 'validated') : ?>
                            <span class="status-validated">Validée</span>
                            <?php else : ?>
                            <span class="status-draft">Brouillon</span>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <div class="p-3">

                    <div class="row mb-3">

                        <div class="col-md-5">
                            <strong>Libellé général :</strong><br>
                            <?= $entry->general_label ?>
                        </div>

                        <div class="col-md-3">
                            <strong>Référence :</strong><br>
                            <?= !empty($entry->reference) ? $entry->reference : '-' ?>
                        </div>

                        <div class="col-md-2">
                            <strong>Chantier :</strong><br>
                            <?= !empty($entry->chantier_name) ? $entry->chantier_name : 'Aucun' ?>
                        </div>

                        <div class="col-md-2">
                            <strong>Devise :</strong><br>
                            <?= $entry->currency ?>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table class="table journal-line-table mb-0">

                            <thead>
                                <tr>
                                    <th>Compte débit</th>
                                    <th>Compte crédit</th>
                                    <th>Libellé ligne</th>
                                    <th class="text-right">Débit</th>
                                    <th class="text-right">Crédit</th>
                                    <th class="text-center">TVA ?</th>
                                    <th>Type TVA</th>
                                    <th class="text-right">Taux</th>
                                    <th class="text-right">Mt TVA</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (!empty($entry->lines)) : ?>

                                <?php foreach ($entry->lines as $line) : ?>

                                <?php
                                                $debit  = (float) $line->debit;
                                                $credit = (float) $line->credit;
                                                $tva    = (float) $line->tva_amount;

                                                $debitDisplay  = $debit;
                                                $creditDisplay = $credit;

                                                $isDeductible = ($line->has_tva == 1 && $line->tva_type == 'deductible');
                                                $isCollected  = ($line->has_tva == 1 && $line->tva_type == 'collected');

                                                /*
                                                    ACHAT = TVA déductible
                                                    Débit : HT + TVA affichée en dessous
                                                    Crédit : TTC
                                                */
                                                if ($isDeductible) {
                                                    $debitDisplay  = $debit;
                                                    $creditDisplay = $credit + $tva;
                                                }

                                                /*
                                                    VENTE = TVA collectée
                                                    Débit : TTC
                                                    Crédit : HT + TVA affichée en dessous
                                                */
                                                if ($isCollected) {
                                                    $debitDisplay  = $debit + $tva;
                                                    $creditDisplay = $credit;
                                                }
                                                ?>

                                <tr>
                                    <td>
                                        <strong><?= $line->debit_code ?></strong><br>
                                        <small class="text-muted"><?= $line->debit_name ?></small>
                                    </td>

                                    <td>
                                        <strong><?= $line->credit_code ?></strong><br>
                                        <small class="text-muted"><?= $line->credit_name ?></small>
                                    </td>

                                    <td><?= $line->line_label ?></td>

                                    <!-- DÉBIT -->
                                    <td class="text-right font-weight-bold">
                                        <?= number_format($debitDisplay, 2, ',', ' ') ?>

                                        <?php if ($isDeductible) : ?>
                                        <br>
                                        <small class="text-success">
                                            TVA : <?= number_format($tva, 2, ',', ' ') ?>
                                        </small>
                                        <?php endif; ?>
                                    </td>

                                    <!-- CRÉDIT -->
                                    <td class="text-right font-weight-bold">
                                        <?= number_format($creditDisplay, 2, ',', ' ') ?>

                                        <?php if ($isCollected) : ?>
                                        <br>
                                        <small class="text-warning">
                                            TVA : <?= number_format($tva, 2, ',', ' ') ?>
                                        </small>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <?= $line->has_tva == 1 ? 'Oui' : 'Non' ?>
                                    </td>

                                    <td>
                                        <?php
                                                        $journalCode = strtoupper($entry->journal_code);
                                                        $tvaPosition = '';

                                                        if ($line->has_tva == 1 && $line->tva_type == 'deductible') {
                                                            $tvaPosition = 'Crédit';
                                                        }

                                                        if ($line->has_tva == 1 && $line->tva_type == 'collected') {
                                                            $tvaPosition = 'Débit';
                                                        }
                                                        ?>

                                        <?php if ($line->has_tva == 1 && $line->tva_type == 'deductible') : ?>

                                        <span class="tva-deductible">
                                            TVA déductible
                                        </span>
                                        <br>
                                        <small class="text-primary font-weight-bold">
                                            Position : <?= $tvaPosition ?>
                                        </small>

                                        <?php elseif ($line->has_tva == 1 && $line->tva_type == 'collected') : ?>

                                        <span class="tva-collected">
                                            TVA collectée
                                        </span>
                                        <br>
                                        <small class="text-warning font-weight-bold">
                                            Position : <?= $tvaPosition ?>
                                        </small>

                                        <?php else : ?>

                                        <span class="tva-none">
                                            Aucune TVA
                                        </span>

                                        <?php endif; ?>
                                    </td>

                                    <td class="text-right">
                                        <?= number_format((float) $line->tva_rate, 2, ',', ' ') ?> %
                                    </td>

                                    <td class="text-right font-weight-bold">
                                        <?= number_format($tva, 2, ',', ' ') ?>
                                    </td>
                                </tr>

                                <?php endforeach; ?>

                                <?php endif; ?>

                            </tbody>

                        </table>
                    </div>

                </div>

                <div class="entry-total-box">
                    <div class="row">

                        <div class="col-md-3">
                            Total débit :
                            <strong>
                                <?= number_format($entry->total_debit, 2, ',', ' ') ?>
                                <?= $entry->currency ?>
                            </strong>
                        </div>

                        <div class="col-md-3">
                            Total crédit :
                            <strong>
                                <?= number_format($entry->total_credit, 2, ',', ' ') ?>
                                <?= $entry->currency ?>
                            </strong>
                        </div>

                        <div class="col-md-3">
                            Total TVA :
                            <strong>
                                <?= number_format($entry->total_tva, 2, ',', ' ') ?>
                                <?= $entry->currency ?>
                            </strong>
                        </div>

                        <div class="col-md-3 text-right">
                            <?php if (round($entry->total_debit, 2) == round($entry->total_credit, 2)) : ?>
                            <span class="status-validated">
                                Écriture équilibrée
                            </span>
                            <?php else : ?>
                            <span class="status-draft">
                                Non équilibrée
                            </span>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            </div>

            <?php endforeach; ?>

            <?php else : ?>

            <div class="card journal-entry-card">
                <div class="card-body text-center text-muted py-5">
                    <i class="fas fa-folder-open fa-3x mb-3"></i><br>
                    Aucune écriture comptable trouvée.
                </div>
            </div>

            <?php endif; ?>



        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->