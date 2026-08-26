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

            <!-- ici le contenus de la page  -->

            <!-- ============================================================ -->
            <!-- SUIVIE PAIE CHANTIER                                         -->
            <!-- ============================================================ -->

            <!-- ---------- 1. TUILES DE SYNTHÈSE ---------- -->
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= number_format($totalCumul, 0, ',', ' ') ?></h3>
                            <p>Montant total cumulé (BIF)</p>
                        </div>
                        <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= number_format($totalMois, 0, ',', ' ') ?></h3>
                            <p>Total du mois en cours (BIF)</p>
                        </div>
                        <div class="icon"><i class="fas fa-calendar-check"></i></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $nbEnAttente ?></h3>
                            <p>En attente d'approbation</p>
                        </div>
                        <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?= $nbChantiersMois ?></h3>
                            <p>Chantiers payés ce mois</p>
                        </div>
                        <div class="icon"><i class="fas fa-hard-hat"></i></div>
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

            <!-- ---------- 2. CARTE PRINCIPALE ---------- -->
            <div class="card card-outline card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-money-check-alt mr-2"></i>
                        Suivi des paies hebdomadaires par chantier
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-success"><i class="fas fa-file-excel mr-1"></i> Exporter</button>
                        <button class="btn btn-sm btn-secondary"><i class="fas fa-print mr-1"></i> Imprimer</button>
                    </div>
                </div>

                <div class="card-body">

                    <!-- ---------- Filtres ---------- -->
                    <form action="<?= current_url() ?>" method="get">
                        <div class="row mb-3">

                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label>Semaine</label>
                                    <select name="semaine" class="form-control">
                                        <option value="">
                                            <?= $moisVide ? 'Dernières semaines disponibles' : 'Semaines du mois en cours' ?>
                                        </option>
                                        <?php foreach ($weekOptions as $mois => $opts): ?>
                                        <optgroup label="<?= $mois ?>">
                                            <?php foreach ($opts as $o): ?>
                                            <option value="<?= $o['yw'] ?>"
                                                <?= (string) ($filters['semaine'] ?? '') === (string) $o['yw'] ? 'selected' : '' ?>>
                                                <?= $o['label'] ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label>Chantier</label>
                                    <select name="chantier" class="form-control">
                                        <option value="">Tous les chantiers</option>
                                        <?php foreach ($allChantiers as $c): ?>
                                        <option value="<?= $c->id ?>"
                                            <?= (string) ($filters['chantier'] ?? '') === (string) $c->id ? 'selected' : '' ?>>
                                            <?= html_escape($c->name) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <div class="btn-group btn-block">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-search mr-1"></i> Filtrer
                                    </button>
                                    <a href="<?= current_url() ?>" class="btn btn-secondary"
                                        title="Réinitialiser les filtres">
                                        <i class="fas fa-redo-alt"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>

                    <?php if (!empty($paieSemaines)) : ?>

                    <?php foreach ($paieSemaines as $sem): ?>

                    <!-- ===== En-tête de la semaine ===== -->
                    <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-week mr-1 text-success"></i>
                            Semaine du <?= date('d/m', strtotime($sem['week_start'])) ?>
                            au <?= date('d/m/Y', strtotime($sem['week_end'])) ?>
                        </h5>
                        <span class="badge badge-success">
                            Total semaine : <?= number_format($sem['total'], 0, ',', ' ') ?> BIF
                        </span>
                    </div>

                    <!-- ===== Une table par chantier ===== -->
                    <?php foreach ($sem['chantiers'] as $ch): ?>
                    <div class="card card-outline card-secondary mb-3">
                        <div class="card-header py-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="fas fa-hard-hat mr-1 text-success"></i>
                                Chantier <?= html_escape($ch['name']) ?>
                            </h6>
                            <span class="badge badge-info">
                                Total : <?= number_format($ch['total'], 0, ',', ' ') ?> BIF
                            </span>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table table-bordered table-hover table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width:40px">#</th>
                                        <th>Personnel</th>
                                        <th>Type</th>
                                        <th>Fonction / Tâche</th>
                                        <th class="text-center" style="width:100px">Jours</th>
                                        <th class="text-right" style="width:150px">Montant (BIF)</th>
                                        <th class="text-center" style="width:110px">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($ch['rows'] as $ct): ?>
                                    <?php
                                                    $jours = '-';
                                                    if (!empty($ct->start_date) && !empty($ct->end_date)) {
                                                        $jours = (int) round((strtotime($ct->end_date) - strtotime($ct->start_date)) / 86400) + 1;
                                                    }
                                                    $approuve = ($ct->approved_by_dt == 1 && $ct->approved_by_daf == 1);
                                                    ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><strong><?= html_escape($ct->worker_name) ?></strong></td>
                                        <td><?= html_escape($ct->worker_type) ?></td>
                                        <td><?= html_escape($ct->function_name ?: '-') ?></td>
                                        <td class="text-center"><?= $jours ?></td>
                                        <td class="text-right text-nowrap">
                                            <strong><?= number_format($ct->unit_rate, 0, ',', ' ') ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($approuve): ?>
                                            <span class="badge badge-success">Approuvé</span>
                                            <?php else: ?>
                                            <span class="badge badge-warning">En attente</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <?php endforeach; ?>

                    <!-- ---------- TOTAL GÉNÉRAL ---------- -->
                    <div class="alert alert-success mt-4 mb-0">
                        <i class="fas fa-hand-holding-usd mr-2"></i>
                        <strong>TOTAL GÉNÉRAL (période affichée, tous chantiers) :</strong>
                        <?= number_format($totalGeneral, 0, ',', ' ') ?> BIF
                    </div>

                    <?php else : ?>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i>
                        Aucune paie trouvée pour cette période.
                    </div>

                    <?php endif; ?>

                </div>

                <div class="card-footer clearfix">
                    <div class="float-left">
                        <small class="text-muted">
                            Semaines déterminées par la date de création (created_at). Montant = taux hebdomadaire
                            (unit_rate).
                        </small>
                    </div>
                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->