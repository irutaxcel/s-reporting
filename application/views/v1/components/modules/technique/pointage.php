<?php
$dateFr  = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '—';
};
$jourFr  = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
$jourAbr = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
$num     = function ($v, $d = 1) {
    return number_format((float) $v, $d, ',', ' ');
};
$styles  = [
    ''         => ['—', 'secondary', 'Non pointé'],
    'present'  => ['P', 'success', 'Présent'],
    'demi'     => ['½', 'info', 'Demi-journée'],
    'absent'   => ['A', 'danger', 'Absent'],
    'justifie' => ['J', 'warning', 'Absence justifiée'],
];
$st         = $stats;
$urlJour    = function ($d) use ($chantierId) {
    return site_url('pointage') . '?' . http_build_query(['chantier' => $chantierId, 'date' => $d]);
};
$veille     = date('Y-m-d', strtotime($date . ' -1 day'));
$lendemain  = date('Y-m-d', strtotime($date . ' +1 day'));
$jourNonOuvre = !in_array($date, $bornes['jours'], true);
?>
<style>
.pt-table td,
.pt-table th {
    vertical-align: middle;
}

.pt-choix label {
    margin-bottom: 0;
    cursor: pointer;
    min-width: 38px;
}

.pt-choix input[type=radio] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.pt-heures {
    width: 80px;
}

.pt-recap td.pt-off {
    background: #f1f3f5;
    color: #adb5bd;
}

.pt-recap .badge {
    min-width: 26px;
}

.pt-counters .badge {
    font-size: .85rem;
}

@media print {

    .main-sidebar,
    .main-header,
    .main-footer,
    .no-print,
    .breadcrumb,
    .card-tools {
        display: none !important;
    }

    .content-wrapper {
        margin-left: 0 !important;
    }

    .table-responsive {
        overflow: visible !important;
    }
}
</style>

<div class="content-wrapper">
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

    <section class="content">
        <div class="container-fluid">

            <!-- 1. TUILES (aujourd'hui, tous chantiers) -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= (int) $st['presents'] ?></h3>
                            <p>Présents aujourd'hui</p>
                        </div>
                        <div class="icon"><i class="fas fa-user-check"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= (int) $st['absents'] ?> <small style="font-size:1rem">+
                                    <?= (int) $st['justifies'] ?> justifié(s)</small></h3>
                            <p>Absents aujourd'hui</p>
                        </div>
                        <div class="icon"><i class="fas fa-user-times"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $st['taux_semaine'] === null ? '—' : $num($st['taux_semaine']) . ' %' ?></h3>
                            <p>Taux de présence de la semaine</p>
                        </div>
                        <div class="icon"><i class="fas fa-percentage"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= count($st['non_pointes']) ?></h3>
                            <p>Chantier(s) non pointé(s) aujourd'hui</p>
                        </div>
                        <div class="icon"><i class="fas fa-clipboard-list"></i></div>
                    </div>
                </div>
            </div>

            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $this->session->flashdata('success') ?>
            </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $this->session->flashdata('error') ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($st['non_pointes'])): ?>
            <div class="alert alert-warning no-print">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                <strong>Pas encore pointés aujourd'hui :</strong>
                <?php foreach ($st['non_pointes'] as $i => $np): ?>
                <a href="<?= site_url('pointage') . '?' . http_build_query(['chantier' => $np['id'], 'date' => $today]) ?>"
                    class="text-dark"><u><?= html_escape($np['name']) ?></u></a><?= $i < count($st['non_pointes']) - 1 ? ', ' : '' ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- 2. SÉLECTION -->
            <div class="card card-outline card-success no-print">
                <div class="card-body">
                    <form action="<?= site_url('pointage') ?>" method="get">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group mb-0">
                                    <label>Chantier</label>
                                    <select name="chantier" class="form-control" required onchange="this.form.submit()">
                                        <option value="">— Choisir un chantier —</option>
                                        <?php foreach ($allChantiers as $c): ?>
                                        <option value="<?= (int) $c['id'] ?>"
                                            <?= $chantierId === (int) $c['id'] ? 'selected' : '' ?>>
                                            <?= html_escape($c['name']) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" value="<?= $date ?>"
                                        max="<?= $today ?>">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="btn-group btn-block">
                                    <button type="submit" class="btn btn-success"><i
                                            class="fas fa-search mr-1"></i>Afficher</button>
                                    <?php if ($chantierId): ?>
                                    <a href="<?= $urlJour($veille) ?>" class="btn btn-outline-secondary"
                                        title="Jour précédent"><i class="fas fa-chevron-left"></i></a>
                                    <a href="<?= $urlJour($today) ?>" class="btn btn-outline-secondary"
                                        title="Aujourd'hui">Auj.</a>
                                    <a href="<?= $date < $today ? $urlJour($lendemain) : '#' ?>"
                                        class="btn btn-outline-secondary <?= $date >= $today ? 'disabled' : '' ?>"
                                        title="Jour suivant"><i class="fas fa-chevron-right"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php if (!$chantierId): ?>
            <div class="callout callout-info">
                <h5><i class="fas fa-info-circle mr-1"></i>Choisissez un chantier</h5>
                <p class="mb-0">Sélectionnez un chantier pour afficher la feuille de pointage du jour et le
                    récapitulatif de la semaine.</p>
            </div>
            <?php else: ?>

            <!-- 3. ONGLETS -->
            <div class="card card-outline card-success card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= $onglet === 'jour' ? 'active' : '' ?>" data-toggle="tab"
                                href="#ptJour" role="tab">
                                <i class="fas fa-calendar-day mr-1"></i>Feuille du
                                <?= $jourFr[(int) date('w', strtotime($date))] ?> <?= $dateFr($date) ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $onglet === 'semaine' ? 'active' : '' ?>" data-toggle="tab"
                                href="#ptSemaine" role="tab">
                                <i class="fas fa-calendar-week mr-1"></i>Semaine du <?= $dateFr($bornes['debut']) ?> au
                                <?= $dateFr($bornes['fin']) ?>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">

                        <!-- 3a. FEUILLE DU JOUR -->
                        <div class="tab-pane fade <?= $onglet === 'jour' ? 'show active' : '' ?>" id="ptJour"
                            role="tabpanel">
                            <h5 class="mb-3"><?= html_escape($chantierNom) ?></h5>

                            <?php if ($jourNonOuvre): ?>
                            <div class="alert alert-light border"><i class="fas fa-info-circle mr-1"></i>
                                Ce jour est hors de la semaine de travail (dimanche → vendredi). Le pointage reste
                                possible.</div>
                            <?php endif; ?>

                            <?php if (empty($feuille)): ?>
                            <p class="text-muted">Aucun travailleur actif sur ce chantier à cette date.
                                Ajoutez le personnel dans <a href="<?= site_url('personnel-chantier') ?>">Personnel
                                    Chantier</a>.</p>
                            <?php else: ?>
                            <form action="<?= site_url('pointage/store') ?>" method="post" id="ptForm">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                                    value="<?= $this->security->get_csrf_hash() ?>">
                                <input type="hidden" name="chantier_id" value="<?= (int) $chantierId ?>">
                                <input type="hidden" name="date" value="<?= $date ?>">

                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 no-print">
                                    <div class="pt-counters mb-2">
                                        <span class="badge badge-success">Présents : <span id="ptNbP">0</span></span>
                                        <span class="badge badge-info">Demi : <span id="ptNbD">0</span></span>
                                        <span class="badge badge-danger">Absents : <span id="ptNbA">0</span></span>
                                        <span class="badge badge-warning">Justifiés : <span id="ptNbJ">0</span></span>
                                        <span class="badge badge-secondary">Non pointés : <span
                                                id="ptNbN">0</span></span>
                                    </div>
                                    <div class="mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-success"
                                            id="ptTousPresents">
                                            <i class="fas fa-check-double mr-1"></i>Tous présents
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm pt-table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="width:40px">#</th>
                                                <th>Travailleur</th>
                                                <th>Type</th>
                                                <th class="text-center" style="width:260px">Statut</th>
                                                <th class="text-center">Heures</th>
                                                <th>Observation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($feuille as $i => $w):
                                                        $cid = (int) $w['contract_id'];
                                                        $cur = (string) $w['statut']; ?>
                                            <tr class="pt-row">
                                                <td><?= $i + 1 ?></td>
                                                <td>
                                                    <strong><?= html_escape($w['worker_name']) ?></strong>
                                                    <?php if ($w['function_name']): ?><br><small
                                                        class="text-muted"><?= html_escape($w['function_name']) ?></small><?php endif; ?>
                                                </td>
                                                <td><?= html_escape($w['worker_type']) ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm pt-choix">
                                                        <?php foreach ($styles as $val => $sty): ?>
                                                        <label
                                                            class="btn btn-outline-<?= $sty[1] ?> <?= $cur === $val ? 'active' : '' ?>"
                                                            title="<?= $sty[2] ?>">
                                                            <input type="radio" name="statut[<?= $cid ?>]"
                                                                value="<?= $val ?>"
                                                                <?= $cur === $val ? 'checked' : '' ?>>
                                                            <?= $sty[0] ?>
                                                        </label>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" step="0.5" min="0" max="24"
                                                        name="heures[<?= $cid ?>]"
                                                        class="form-control form-control-sm pt-heures mx-auto"
                                                        value="<?= $w['heures'] !== null ? (float) $w['heures'] : '' ?>"
                                                        placeholder="h">
                                                </td>
                                                <td>
                                                    <input type="text" maxlength="255" name="observation[<?= $cid ?>]"
                                                        class="form-control form-control-sm"
                                                        value="<?= html_escape((string) $w['observation']) ?>">
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center no-print">
                                    <small class="text-muted">P = Présent · ½ = Demi-journée · A = Absent · J = Absence
                                        justifiée · — = Non pointé (efface le pointage)</small>
                                    <button type="submit" class="btn btn-success"><i
                                            class="fas fa-save mr-1"></i>Enregistrer le pointage</button>
                                </div>
                            </form>
                            <?php endif; ?>
                        </div>

                        <!-- 3b. RÉCAPITULATIF SEMAINE -->
                        <div class="tab-pane fade <?= $onglet === 'semaine' ? 'show active' : '' ?>" id="ptSemaine"
                            role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><?= html_escape($chantierNom) ?></h5>
                                <div class="card-tools">
                                    <a href="<?= site_url('pointage/export') . '?' . http_build_query(['chantier' => $chantierId, 'date' => $date]) ?>"
                                        class="btn btn-sm btn-success"><i
                                            class="fas fa-file-excel mr-1"></i>Exporter</a>
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="window.print()"><i
                                            class="fas fa-print mr-1"></i>Imprimer</button>
                                </div>
                            </div>

                            <?php if (empty($semaine['lignes'])): ?>
                            <p class="text-muted">Aucun travailleur actif sur ce chantier pendant cette semaine.</p>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm pt-recap">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Travailleur</th>
                                            <?php foreach ($bornes['jours'] as $d): ?>
                                            <th class="text-center <?= $d === $date ? 'bg-success' : '' ?>">
                                                <a href="<?= $urlJour($d) ?>"
                                                    class="text-white"><?= $jourAbr[(int) date('w', strtotime($d))] ?><br><small><?= date('d/m', strtotime($d)) ?></small></a>
                                            </th>
                                            <?php endforeach; ?>
                                            <th class="text-right">Jours</th>
                                            <th class="text-right">Abs.</th>
                                            <th class="text-right">Heures</th>
                                            <th class="text-right">Présence</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($semaine['lignes'] as $l): ?>
                                        <tr>
                                            <td>
                                                <strong><?= html_escape($l['worker_name']) ?></strong>
                                                <?php if ($l['function_name']): ?><br><small
                                                    class="text-muted"><?= html_escape($l['function_name']) ?></small><?php endif; ?>
                                            </td>
                                            <?php foreach ($bornes['jours'] as $d):
                                                            $j = $l['jours'][$d];
                                                            if (!$j['actif']): ?>
                                            <td class="text-center pt-off" title="Hors contrat">—</td>
                                            <?php elseif ($j['statut']): $sty = $styles[$j['statut']]; ?>
                                            <td class="text-center"><span class="badge badge-<?= $sty[1] ?>"
                                                    title="<?= $sty[2] ?>"><?= $sty[0] ?></span></td>
                                            <?php elseif ($d > $today): ?>
                                            <td class="text-center text-muted"></td>
                                            <?php else: ?>
                                            <td class="text-center text-muted" title="Non pointé">·</td>
                                            <?php endif;
                                                        endforeach; ?>
                                            <td class="text-right"><strong><?= $num($l['travailles']) ?></strong></td>
                                            <td class="text-right <?= $l['absences'] > 0 ? 'text-danger' : '' ?>">
                                                <?= (int) $l['absences'] ?></td>
                                            <td class="text-right"><?= $l['heures'] > 0 ? $num($l['heures']) : '—' ?>
                                            </td>
                                            <td class="text-right">
                                                <?= $l['taux'] === null ? '—' : $num($l['taux']) . ' %' ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light">
                                            <th class="text-right">Présents / pointés</th>
                                            <?php foreach ($bornes['jours'] as $d): $t = $semaine['totaux'][$d]; ?>
                                            <th class="text-center">
                                                <?= $t['pointes'] ? $num($t['presents']) . ' / ' . $t['pointes'] : '—' ?>
                                            </th>
                                            <?php endforeach; ?>
                                            <th colspan="4"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <small class="text-muted">P = Présent · ½ = Demi-journée · A = Absent · J = Absence
                                justifiée · · = Non pointé · — = Hors contrat.
                                Cliquez sur un jour pour ouvrir sa feuille.</small>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('ptForm');
    if (!form) {
        return;
    }
    var modifie = false;

    function majGroupe(groupe) {
        groupe.querySelectorAll('label').forEach(function(lbl) {
            lbl.classList.toggle('active', lbl.querySelector('input').checked);
        });
        var row = groupe.closest('tr');
        var checked = groupe.querySelector('input:checked');
        var val = checked ? checked.value : '';
        var heures = row.querySelector('.pt-heures');
        var sansHeures = (val === 'absent' || val === 'justifie' || val === '');
        heures.disabled = sansHeures;
        if (sansHeures) {
            heures.value = '';
        }
    }

    function compter() {
        var n = {
            present: 0,
            demi: 0,
            absent: 0,
            justifie: 0,
            '': 0
        };
        form.querySelectorAll('.pt-choix').forEach(function(g) {
            var c = g.querySelector('input:checked');
            n[c ? c.value : '']++;
        });
        document.getElementById('ptNbP').textContent = n.present;
        document.getElementById('ptNbD').textContent = n.demi;
        document.getElementById('ptNbA').textContent = n.absent;
        document.getElementById('ptNbJ').textContent = n.justifie;
        document.getElementById('ptNbN').textContent = n[''];
    }

    form.querySelectorAll('.pt-choix').forEach(function(g) {
        if (!g.querySelector('input:checked')) {
            g.querySelector('input[value=""]').checked = true;
        }
        majGroupe(g);
        g.addEventListener('change', function() {
            majGroupe(g);
            compter();
            modifie = true;
        });
    });
    form.querySelectorAll('input[type=text], input[type=number]').forEach(function(i) {
        i.addEventListener('input', function() {
            modifie = true;
        });
    });

    document.getElementById('ptTousPresents').addEventListener('click', function() {
        form.querySelectorAll('.pt-choix').forEach(function(g) {
            g.querySelector('input[value="present"]').checked = true;
            majGroupe(g);
        });
        compter();
        modifie = true;
    });

    form.addEventListener('submit', function() {
        modifie = false;
    });
    window.addEventListener('beforeunload', function(e) {
        if (modifie) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    compter();
});
</script>