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

            <!-- ici le contenu de la page cloture_comptable -->

            <style>
            .closing-header {
                background: linear-gradient(135deg, #0f766e, #102033);
                color: #fff;
                border-radius: 16px;
                padding: 22px;
                margin-bottom: 24px;
            }

            .closing-card {
                background: #fff;
                border-radius: 16px;
                border: none;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
                overflow: hidden;
                margin-bottom: 22px;
            }

            .closing-step {
                display: flex;
                align-items: center;
                padding: 16px;
                border-bottom: 1px solid #e5e7eb;
            }

            .step-icon {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                background: #ecfdf5;
                color: #0f766e;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 14px;
                font-size: 18px;
            }

            .step-title {
                font-weight: 800;
                color: #102033;
                margin-bottom: 2px;
            }

            .step-desc {
                color: #64748b;
                font-size: 13px;
            }

            .badge-ready {
                background: #dcfce7;
                color: #166534;
                padding: 7px 12px;
                border-radius: 30px;
                font-weight: 700;
            }

            .badge-warning-soft {
                background: #fef3c7;
                color: #92400e;
                padding: 7px 12px;
                border-radius: 30px;
                font-weight: 700;
            }

            .badge-danger-soft {
                background: #fee2e2;
                color: #991b1b;
                padding: 7px 12px;
                border-radius: 30px;
                font-weight: 700;
            }

            .closing-summary {
                background: #f8fafc;
                border-radius: 14px;
                padding: 18px;
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
            }

            .summary-item span {
                font-size: 18px;
                font-weight: 800;
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

            .btn-closing-danger {
                background: #991b1b;
                color: #fff;
                border-radius: 10px;
                font-weight: 800;
            }

            .btn-closing-danger:hover {
                background: #7f1d1d;
                color: #fff;
            }
            </style>

            <?php
            $exerciseName = !empty($active_exercise) ? $active_exercise->name : 'Aucun exercice';

            $totalDebit  = !empty($closing_stats->total_debit) ? (float) $closing_stats->total_debit : 0;
            $totalCredit = !empty($closing_stats->total_credit) ? (float) $closing_stats->total_credit : 0;
            $totalTva    = !empty($closing_stats->total_tva) ? (float) $closing_stats->total_tva : 0;

            $isBalanced = !empty($closing_checks['balance_ok']);
            $drafts = $closing_checks['drafts'] ?? 0;
            $withoutJournal = $closing_checks['without_journal'] ?? 0;
            $withoutChantier = $closing_checks['without_chantier'] ?? 0;
            ?>

            <div class="closing-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-1">
                            <i class="fas fa-lock mr-2"></i>
                            Clôture Comptable
                        </h4>
                        <p class="mb-0">
                            Vérification, validation et clôture définitive de l’exercice comptable.
                        </p>
                    </div>

                    <button class="btn btn-light btn-sm" onclick="window.print()">
                        <i class="fas fa-print mr-1"></i>
                        Imprimer le rapport
                    </button>
                </div>
            </div>

            <div class="closing-summary mb-4">
                <div class="row">
                    <div class="col-md-3 summary-item">
                        <strong>Exercice concerné</strong>
                        <span><?= $exerciseName ?></span>
                    </div>

                    <div class="col-md-3 summary-item">
                        <strong>Total débit</strong>
                        <span><?= number_format($totalDebit, 2, ',', ' ') ?> FBU</span>
                    </div>

                    <div class="col-md-3 summary-item">
                        <strong>Total crédit</strong>
                        <span><?= number_format($totalCredit, 2, ',', ' ') ?> FBU</span>
                    </div>

                    <div class="col-md-3 summary-item">
                        <strong>État</strong>
                        <?php if ($isBalanced) : ?>
                        <span class="text-success">Équilibré</span>
                        <?php else : ?>
                        <span class="text-danger">Non équilibré</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-8">

                    <div class="closing-card">
                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0 font-weight-bold">
                                <i class="fas fa-tasks mr-2 text-success"></i>
                                Contrôles avant clôture
                            </h5>
                            <small class="text-muted">
                                Ces vérifications doivent être validées avant la clôture de l’exercice.
                            </small>
                        </div>

                        <div class="closing-step">
                            <div class="step-icon">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="step-title">Balance générale équilibrée</div>
                                <div class="step-desc">Le total débit est égal au total crédit.</div>
                            </div>
                            <!-- Balance générale -->
                            <?php if ($isBalanced) : ?>
                            <span class="badge-ready">Validé</span>
                            <?php else : ?>
                            <span class="badge-danger-soft">Non équilibré</span>
                            <?php endif; ?>
                        </div>

                        <div class="closing-step">
                            <div class="step-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="step-title">Journaux comptables contrôlés</div>
                                <div class="step-desc">Toutes les écritures sont rattachées à un code journal.</div>
                            </div>
                            <!-- Journaux -->
                            <?php if ($withoutJournal == 0) : ?>
                            <span class="badge-ready">Validé</span>
                            <?php else : ?>
                            <span class="badge-danger-soft"><?= $withoutJournal ?> sans journal</span>
                            <?php endif; ?>
                        </div>

                        <div class="closing-step">
                            <div class="step-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="step-title">TVA vérifiée</div>
                                <div class="step-desc">TVA déductible et TVA collectée contrôlées.</div>
                            </div>
                            <!-- TVA -->
                            <?php if ($totalTva > 0) : ?>
                            <span class="badge-ready">TVA détectée</span>
                            <?php else : ?>
                            <span class="badge-warning-soft">Aucune TVA</span>
                            <?php endif; ?>
                        </div>

                        <div class="closing-step">
                            <div class="step-icon">
                                <i class="fas fa-hard-hat"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="step-title">Chantiers et caisses contrôlés</div>
                                <div class="step-desc">Les soldes par chantier doivent être validés.</div>
                            </div>
                            <!-- Chantiers -->
                            <?php if ($withoutChantier == 0) : ?>
                            <span class="badge-ready">Validé</span>
                            <?php else : ?>
                            <span class="badge-warning-soft"><?= $withoutChantier ?> sans chantier</span>
                            <?php endif; ?>
                        </div>

                        <div class="closing-step">
                            <div class="step-icon">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="step-title">Écritures brouillon</div>
                                <div class="step-desc">Aucune écriture en brouillon ne doit rester avant clôture.</div>
                            </div>
                            <!-- Brouillons -->
                            <?php if ($drafts == 0) : ?>
                            <span class="badge-ready">Validé</span>
                            <?php else : ?>
                            <span class="badge-danger-soft"><?= $drafts ?> brouillons</span>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="closing-card">
                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0 font-weight-bold">
                                <i class="fas fa-calendar-check mr-2 text-success"></i>
                                Exercice à clôturer
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label>Exercice comptable</label>
                                <select name="exercise_id" class="form-control">
                                    <?php if (!empty($exercises)) : ?>
                                    <?php foreach ($exercises as $ex) : ?>
                                    <option value="<?= $ex->id ?>"
                                        <?= (!empty($active_exercise) && $active_exercise->id == $ex->id) ? 'selected' : '' ?>>
                                        <?= $ex->name ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <option value="">Aucun exercice</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Date de clôture</label>
                                <input type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                            </div>

                            <div class="form-group">
                                <label>Observation</label>
                                <textarea class="form-control" rows="4"
                                    placeholder="Note de clôture comptable..."></textarea>
                            </div>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Après clôture, les écritures de cet exercice ne pourront plus être modifiées.
                            </div>

                            <button class="btn btn-finance btn-block mb-2">
                                <i class="fas fa-search mr-1"></i>
                                Vérifier avant clôture
                            </button>

                            <button class="btn btn-closing-danger btn-block">
                                <i class="fas fa-lock mr-1"></i>
                                Clôturer l’exercice
                            </button>
                        </div>
                    </div>

                </div>

            </div>

            <div class="closing-card">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-history mr-2 text-success"></i>
                        Historique des clôtures
                    </h5>
                    <small class="text-muted">
                        Liste des exercices déjà clôturés ou en cours de validation.
                    </small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background:#102033;color:#fff;">
                            <tr>
                                <th>Exercice</th>
                                <th>Date clôture</th>
                                <th>Total débit</th>
                                <th>Total crédit</th>
                                <th>Clôturé par</th>
                                <th>Statut</th>
                                <th class="text-center">Rapport</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($closing_history)) : ?>
                            <?php foreach ($closing_history as $history) : ?>
                            <tr>
                                <td><strong><?= $history->name ?></strong></td>

                                <td>
                                    <?= !empty($history->closed_at) ? date('d/m/Y', strtotime($history->closed_at)) : '-' ?>
                                </td>

                                <td><?= number_format((float)($history->total_debit ?? 0), 2, ',', ' ') ?> FBU</td>

                                <td><?= number_format((float)($history->total_credit ?? 0), 2, ',', ' ') ?> FBU</td>

                                <td><?= !empty($history->closed_by_name) ? $history->closed_by_name : '-' ?></td>

                                <td>
                                    <?php if ($history->status == 'closed') : ?>
                                    <span class="badge-ready">Clôturé</span>
                                    <?php else : ?>
                                    <span class="badge-warning-soft">En cours</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <button class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button class="btn btn-secondary btn-sm">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    Aucun historique de clôture trouvé.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->