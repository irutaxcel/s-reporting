<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- ============ STYLE LOCAL ============ -->
            <style>
            .section-title {
                color: #1f7a5c;
                font-weight: 700;
                border-bottom: 2px solid #e9ecef;
                padding-bottom: .4rem;
            }

            .table td {
                vertical-align: middle;
            }

            .avatar-initials {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 34px;
                height: 34px;
                border-radius: 50%;
                color: #fff;
                font-weight: 600;
                font-size: .78rem;
                flex-shrink: 0;
            }
            </style>

            <!-- ============ CALCULS (tbl_pointages + tbl_employes) ============ -->
            <?php
            $couleurs = ['#1f7a5c', '#2c8a69', '#34608c', '#7a4f1f', '#8a3033', '#6c757d'];
            $mois_crt = substr($date_vue, 0, 7);

            if (!function_exists('heures_travaillees')) {
                function heures_travaillees($entree, $sortie)
                {
                    if (!$entree || !$sortie) return NULL;
                    $mins = ((int) substr($sortie, 0, 2) * 60 + (int) substr($sortie, 3, 2))
                        - ((int) substr($entree, 0, 2) * 60 + (int) substr($entree, 3, 2));
                    if ($mins < 0) return NULL;
                    return floor($mins / 60) . ' h ' . str_pad($mins % 60, 2, '0', STR_PAD_LEFT);
                }
            }

            /* Effectif actif par site */
            $nb_actifs = 0;
            $actifs_par_site = [];
            foreach ($employes as $e) {
                if ($e->statut === 'Fin de contrat') continue;
                $nb_actifs++;
                $s = $e->site_affectation ?: '—';
                $actifs_par_site[$s] = isset($actifs_par_site[$s]) ? $actifs_par_site[$s] + 1 : 1;
            }

            /* Pointages du jour affiché + absents */
            $pointages_jour = [];
            $nb_presents = $nb_abs_j = $nb_abs_nj = 0;
            foreach ($pointages as $p) {
                if ($p->date_pointage !== $date_vue) continue;
                $pointages_jour[] = $p;
                if (in_array($p->situation, ['Présent', 'Retard', 'Demi-journée'])) $nb_presents++;
                elseif ($p->situation === 'Absence justifiée')     $nb_abs_j++;
                elseif ($p->situation === 'Absence non justifiée') $nb_abs_nj++;
            }
            $taux_presence = $nb_actifs ? round($nb_presents / $nb_actifs * 100) : 0;

            /* Présents par site (jour affiché) */
            $presents_par_site = [];
            foreach ($pointages_jour as $p) {
                if (in_array($p->situation, ['Présent', 'Retard', 'Demi-journée'])) {
                    $s = $p->site_affectation ?: '—';
                    $presents_par_site[$s] = isset($presents_par_site[$s]) ? $presents_par_site[$s] + 1 : 1;
                }
            }

            /* Mois : retards + heures sup */
            $nb_retards_mois = 0;
            $hs_mois = 0;
            foreach ($pointages as $p) {
                if (substr($p->date_pointage, 0, 7) !== $mois_crt) continue;
                if ($p->situation === 'Retard') $nb_retards_mois++;
                $hs_mois += (float) $p->heures_sup;
            }

            /* Anomalies du mois */
            $anomalies = [];
            foreach ($pointages as $p) {
                if (substr($p->date_pointage, 0, 7) !== $mois_crt) continue;
                if ($p->situation === 'Absence non justifiée') {
                    $anomalies[] = ['classe' => 'danger', 'type' => 'Absence non justifiée', 'detail' => 'Aucun pointage valide pour cette journée', 'p' => $p];
                } elseif ($p->situation === 'Retard') {
                    $anomalies[] = ['classe' => 'warning', 'type' => 'Retard', 'detail' => 'Arrivée ' . substr($p->heure_entree, 0, 5), 'p' => $p];
                } elseif ($p->situation === 'Présent' && $p->heure_entree && !$p->heure_sortie) {
                    $anomalies[] = ['classe' => 'warning', 'type' => 'Sortie manquante', 'detail' => 'Entrée ' . substr($p->heure_entree, 0, 5) . ' enregistrée, sortie non pointée', 'p' => $p];
                } elseif ($p->situation === 'Présent' && !$p->heure_entree && $p->heure_sortie) {
                    $anomalies[] = ['classe' => 'warning', 'type' => 'Entrée manquante', 'detail' => 'Sortie ' . substr($p->heure_sortie, 0, 5) . ' enregistrée, entrée non pointée', 'p' => $p];
                }
            }

            /* Synthèse mensuelle par employé */
            $synthese = [];
            foreach ($pointages as $p) {
                if (substr($p->date_pointage, 0, 7) !== $mois_crt) continue;
                if (!isset($synthese[$p->employe_id])) {
                    $synthese[$p->employe_id] = ['p' => $p, 'jours' => 0, 'presents' => 0, 'retards' => 0, 'abs_j' => 0, 'abs_nj' => 0, 'hs' => 0];
                }
                $s = &$synthese[$p->employe_id];
                $s['jours']++;
                if (in_array($p->situation, ['Présent', 'Demi-journée', 'Retard'])) $s['presents']++;
                if ($p->situation === 'Retard')                $s['retards']++;
                if ($p->situation === 'Absence justifiée')     $s['abs_j']++;
                if ($p->situation === 'Absence non justifiée') $s['abs_nj']++;
                $s['hs'] += (float) $p->heures_sup;
                unset($s);
            }
            ?>

            <!-- ============ 1. INDICATEURS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Présents (<?= date('d/m/Y', strtotime($date_vue)) ?>)</span>
                            <span class="info-box-number"><?= $nb_presents ?> / <?= $nb_actifs ?></span>
                            <span class="progress-description">
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width:<?= $taux_presence ?>%"></div>
                                </div>
                                Taux de présence : <?= $taux_presence ?> %
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-user-times"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Absents</span>
                            <span class="info-box-number"><?= $nb_abs_j + $nb_abs_nj ?></span>
                            <span class="progress-description"><?= $nb_abs_j ?> justifiée(s) · <?= $nb_abs_nj ?> non
                                justifiée(s)</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Retards (mois)</span>
                            <span class="info-box-number"><?= $nb_retards_mois ?></span>
                            <span class="progress-description">Mois de <?= date('F Y', strtotime($date_vue)) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Heures sup (mois)</span>
                            <span class="info-box-number"><?= (int) $hs_mois ?> h</span>
                            <span class="progress-description">À transmettre à la paie</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. PRÉSENCE PAR SITE + HORAIRES ============ -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-map-marker-alt mr-1 text-success"></i> Présence
                                par site (<?= date('d/m/Y', strtotime($date_vue)) ?>)</h3>
                        </div>
                        <div class="card-body">
                            <?php foreach ($actifs_par_site as $site => $total):
                                $nb   = isset($presents_par_site[$site]) ? $presents_par_site[$site] : 0;
                                $pct  = $total ? round($nb / $total * 100) : 0;
                                $bar  = $pct >= 90 ? 'bg-success' : ($pct >= 75 ? 'bg-warning' : 'bg-danger');
                                $icon = (stripos($site, 'chantier') !== FALSE) ? 'fa-hard-hat' : 'fa-building';
                            ?>
                            <p class="mb-1 d-flex justify-content-between">
                                <span><i class="fas <?= $icon ?> mr-1 text-muted"></i><?= html_escape($site) ?></span>
                                <strong><?= $pct ?> %</strong>
                            </p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar <?= $bar ?>" style="width:<?= $pct ?>%"></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-business-time mr-1 text-success"></i> Horaires
                                de travail en vigueur</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4 border-right">
                                    <i class="fas fa-building fa-2x text-muted mb-2"></i>
                                    <p class="font-weight-bold mb-1">Bureau</p>
                                    <small class="text-muted">07h30 – 16h30<br>Lun → Ven · 40 h/sem</small>
                                </div>
                                <div class="col-md-4 border-right">
                                    <i class="fas fa-hard-hat fa-2x text-muted mb-2"></i>
                                    <p class="font-weight-bold mb-1">Chantiers</p>
                                    <small class="text-muted">07h00 – 17h00<br>Lun → Sam · pause 12h-13h</small>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-hourglass-half fa-2x text-muted mb-2"></i>
                                    <p class="font-weight-bold mb-1">Heures supplémentaires</p>
                                    <small class="text-muted">Au-delà de 40 h/sem<br>majorées selon Code du
                                        travail</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ ALERTES FLASHDATA ============ -->
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

            <!-- ============ 3. ONGLETS POINTAGE ============ -->
            <div class="card">
                <div class="card-header p-2 px-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tabJour"><i
                                        class="fas fa-calendar-day mr-1"></i> Pointage du jour</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabAnomalies"><i
                                        class="fas fa-exclamation-circle mr-1"></i> Anomalies <span
                                        class="badge badge-danger ml-1"><?= count($anomalies) ?></span></a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabSynthese"><i
                                        class="fas fa-chart-bar mr-1"></i> Synthèse mensuelle</a></li>
                        </ul>
                        <div>
                            <button type="button" class="btn btn-default mr-2"><i class="fas fa-fingerprint mr-1"></i>
                                Importer badgeuse</button>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#modalPointage">
                                <i class="fas fa-user-clock mr-1"></i> Saisie / correction
                            </button>
                        </div>
                    </div>
                    <!-- Filtres -->
                    <div class="row mt-3">
                        <div class="col-md-3 mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i
                                            class="fas fa-calendar-alt"></i></span></div>
                                <input type="date" id="filtreDate" class="form-control" value="<?= $date_vue ?>">
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-control">
                                <option>Site : tous</option>
                                <option>Siège (Bujumbura)</option>
                                <option>Chantier Ngagara II</option>
                                <option>Chantier Gitega</option>
                                <option>Chantier Ngozi</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-control">
                                <option>Situation : tous</option>
                                <option>Présent</option>
                                <option>Retard</option>
                                <option>Absent</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="input-group">
                                <input type="search" class="form-control" placeholder="Rechercher un employé…">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-search"></i></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-content">

                    <!-- ===== ONGLET : POINTAGE DU JOUR ===== -->
                    <div class="tab-pane fade active show" id="tabJour">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Affectation</th>
                                        <th>Entrée</th>
                                        <th>Sortie</th>
                                        <th>Heures travaillées</th>
                                        <th>Heures sup</th>
                                        <th>Situation</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pointages_jour)): foreach ($pointages_jour as $p):
                                            $initiales = strtoupper(mb_substr($p->prenoms, 0, 1) . mb_substr($p->nom, 0, 1));
                                            $couleur   = $couleurs[$p->employe_id % count($couleurs)];
                                            $icon      = (stripos($p->site_affectation, 'chantier') !== FALSE) ? 'fa-hard-hat' : 'fa-building';
                                            $ht        = heures_travaillees($p->heure_entree, $p->heure_sortie);
                                            $sortie_manquante = ($p->situation === 'Présent' && $p->heure_entree && !$p->heure_sortie);

                                            if ($sortie_manquante)                          $badge_sit = '<span class="badge badge-danger">Sortie manquante</span>';
                                            elseif ($p->situation === 'Présent')            $badge_sit = '<span class="badge badge-success">Présent</span>';
                                            elseif ($p->situation === 'Retard')             $badge_sit = '<span class="badge badge-warning">Retard</span>';
                                            elseif ($p->situation === 'Demi-journée')       $badge_sit = '<span class="badge badge-info">Demi-journée</span>';
                                            elseif ($p->situation === 'Absence justifiée')  $badge_sit = '<span class="badge badge-info">Absence justifiée</span>';
                                            else                                            $badge_sit = '<span class="badge badge-danger">Absence non justifiée</span>';
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar-initials mr-2"
                                                    style="background:<?= $couleur ?>"><?= $initiales ?></span>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        <?= html_escape($p->prenoms . ' ' . mb_strtoupper($p->nom)) ?>
                                                    </div>
                                                    <small class="text-muted"><?= html_escape($p->matricule) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><i
                                                class="fas <?= $icon ?> mr-1 text-muted"></i><?= html_escape($p->site_affectation) ?>
                                        </td>
                                        <td><?= $p->heure_entree ? '<span class="badge badge-light border">' . substr($p->heure_entree, 0, 5) . '</span>' : '<span class="badge badge-danger">—</span>' ?>
                                        </td>
                                        <td><?= $p->heure_sortie ? '<span class="badge badge-light border">' . substr($p->heure_sortie, 0, 5) . '</span>' : '<span class="badge badge-danger">—</span>' ?>
                                        </td>
                                        <td><?= $ht ?: '—' ?></td>
                                        <td><?= (float) $p->heures_sup > 0 ? '<span class="badge badge-info">' . (int) $p->heures_sup . ' h</span>' : '—' ?>
                                        </td>
                                        <td><?= $badge_sit ?></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                title="Corriger"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <?php endforeach;
                                    else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4"><i
                                                class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucun pointage pour cette
                                            date.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <small class="text-muted float-left mt-2">
                                Pointage du <?= date('d/m/Y', strtotime($date_vue)) ?> · <?= $nb_presents ?> présent(s)
                                · <?= $nb_abs_j + $nb_abs_nj ?> absent(s)
                            </small>
                        </div>
                    </div>

                    <!-- ===== ONGLET : ANOMALIES ===== -->
                    <div class="tab-pane fade" id="tabAnomalies">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Employé</th>
                                        <th>Type d'anomalie</th>
                                        <th>Détail</th>
                                        <th class="text-right">Traitement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($anomalies)): foreach ($anomalies as $a): ?>
                                    <tr class="table-<?= $a['classe'] ?>">
                                        <td><?= date('d/m/Y', strtotime($a['p']->date_pointage)) ?></td>
                                        <td><?= html_escape($a['p']->prenoms . ' ' . mb_strtoupper($a['p']->nom)) ?>
                                            <small class="text-muted">(<?= html_escape($a['p']->matricule) ?>)</small>
                                        </td>
                                        <td><span class="badge badge-<?= $a['classe'] ?>"><?= $a['type'] ?></span></td>
                                        <td><?= html_escape($a['detail']) ?></td>
                                        <td class="text-right"><button class="btn btn-sm btn-success">Traiter</button>
                                        </td>
                                    </tr>
                                    <?php endforeach;
                                    else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Aucune anomalie ce mois-ci.
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ===== ONGLET : SYNTHÈSE MENSUELLE ===== -->
                    <div class="tab-pane fade" id="tabSynthese">
                        <div class="d-flex justify-content-between align-items-center p-3 pb-0">
                            <h6 class="section-title mb-0">Synthèse — <?= date('F Y', strtotime($date_vue)) ?></h6>
                            <button type="button" class="btn btn-success btn-sm"><i class="fas fa-share mr-1"></i>
                                Transmettre à la paie</button>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Jours pointés</th>
                                        <th>Présents</th>
                                        <th>Retards</th>
                                        <th>Abs. justifiées</th>
                                        <th>Abs. non just.</th>
                                        <th>Heures sup</th>
                                        <th>Taux de présence</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($synthese)): foreach ($synthese as $s):
                                            $taux = $s['jours'] ? round($s['presents'] / $s['jours'] * 100) : 0;
                                            $badge_taux = $taux >= 90 ? 'success' : ($taux >= 75 ? 'warning' : 'danger');
                                    ?>
                                    <tr>
                                        <td><?= html_escape($s['p']->prenoms . ' ' . mb_strtoupper($s['p']->nom)) ?>
                                            <small class="text-muted">(<?= html_escape($s['p']->matricule) ?>)</small>
                                        </td>
                                        <td><?= $s['jours'] ?></td>
                                        <td><?= $s['presents'] ?></td>
                                        <td><?= $s['retards'] ?></td>
                                        <td><?= $s['abs_j'] ?></td>
                                        <td><?= $s['abs_nj'] ? '<strong>' . $s['abs_nj'] . '</strong>' : 0 ?></td>
                                        <td><?= $s['hs'] > 0 ? '<strong>' . (int) $s['hs'] . ' h</strong>' : '0 h' ?>
                                        </td>
                                        <td><span class="badge badge-<?= $badge_taux ?>"><?= $taux ?> %</span></td>
                                    </tr>
                                    <?php endforeach;
                                    else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">Aucun pointage ce mois-ci.
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Les absences non
                                justifiées et les heures supplémentaires sont reprises automatiquement dans le calcul de
                                la paie du mois.</small>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============ MODALE : SAISIE / CORRECTION DE POINTAGE ============ -->
            <div class="modal fade" id="modalPointage">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="formPointage" method="post" action="<?= base_url('rh-presences-store') ?>"
                            enctype="multipart/form-data">
                            <div class="modal-header bg-success text-white">
                                <h4 class="modal-title"><i class="fas fa-user-clock mr-2"></i>Saisie / correction de
                                    pointage</h4>
                                <button type="button" class="close text-white"
                                    data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Employé *</label>
                                            <select name="employe_id" class="form-control" required>
                                                <option value="">— Sélectionner —</option>
                                                <?php foreach ($employes as $e):
                                                    if ($e->statut === 'Fin de contrat') continue; ?>
                                                <option value="<?= $e->employe_id ?>">
                                                    <?= html_escape($e->matricule . ' · ' . $e->prenoms . ' ' . mb_strtoupper($e->nom)) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Date *</label>
                                            <input type="date" name="date_pointage" class="form-control"
                                                value="<?= $date_vue ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Heure d'entrée</label>
                                            <input type="time" name="heure_entree" class="form-control" value="07:30">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Heure de sortie</label>
                                            <input type="time" name="heure_sortie" class="form-control" value="17:00">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Heures supplémentaires</label>
                                            <select name="heures_sup" class="form-control">
                                                <option value="0">Aucune</option>
                                                <option value="1">1 h</option>
                                                <option value="2">2 h</option>
                                                <option value="3">3 h</option>
                                                <option value="4">4 h et +</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Situation</label>
                                            <select name="situation" class="form-control">
                                                <option>Présent</option>
                                                <option>Demi-journée</option>
                                                <option>Retard</option>
                                                <option>Absence justifiée</option>
                                                <option>Absence non justifiée</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Pièce justificative (certificat,
                                                autorisation…)</label>
                                            <div class="custom-file">
                                                <input type="file" name="justificatif" class="custom-file-input"
                                                    id="fileJustifPointage">
                                                <label class="custom-file-label"
                                                    for="fileJustifPointage">Choisir…</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group"><label>Motif / observation</label>
                                            <textarea name="motif" class="form-control" rows="2"
                                                placeholder="Ex. : oubli de pointage confirmé par le chef de chantier…"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>
                                    Enregistrer le pointage</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ============ SCRIPTS ============ -->
            <script>
            document.addEventListener('DOMContentLoaded', function() {

                /* Filtre par date → recharge la page */
                var fd = document.getElementById('filtreDate');
                if (fd) fd.addEventListener('change', function() {
                    window.location.search = 'date=' + this.value;
                });

                /* Nom du fichier choisi */
                var form = document.getElementById('formPointage');
                if (form) {
                    form.querySelectorAll('.custom-file-input').forEach(function(input) {
                        input.addEventListener('change', function() {
                            var label = this.closest('.custom-file').querySelector(
                                '.custom-file-label');
                            label.textContent = (this.files && this.files.length) ? this.files[
                                0].name : 'Choisir…';
                            label.classList.toggle('has-file', this.files.length > 0);
                        });
                    });
                }
            });
            </script>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->