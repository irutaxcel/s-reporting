<!-- Content Wrapper -->
<div class="content-wrapper">
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

            .legal-note {
                border-left: 4px solid #1f7a5c;
                background: #f8faf9;
            }
            </style>

            <!-- ============ CALCULS ============ -->
            <?php
            $couleurs = ['#1f7a5c', '#2c8a69', '#34608c', '#7a4f1f', '#8a3033', '#6c757d'];
            $auj    = date('Y-m-d');
            $plus60 = date('Y-m-d', strtotime('+60 days'));
            $jours_fr = ['Sunday' => 'Dimanche', 'Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi', 'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi'];

            $reprise = function ($fin) use ($jours_fr) {
                $t = strtotime($fin . ' +1 day');
                return $jours_fr[date('l', $t)] . ' ' . date('d/m', $t);
            };
            $avancement = function ($debut, $fin) use ($auj) {
                $total = max(1, (int) ((strtotime($fin) - strtotime($debut)) / 86400) + 1);
                $fait  = min($total, max(0, (int) ((strtotime($auj) - strtotime($debut)) / 86400) + 1));
                return (int) round($fait / $total * 100);
            };

            /* Employés actifs + droits 2026 */
            $actifs = [];
            $nb_actifs = 0;
            $total_droits = 0;
            $droits = [];
            foreach ($employes as $e) {
                if ($e->statut === 'Fin de contrat') continue;
                $actifs[$e->employe_id] = $e;
                $nb_actifs++;
                $mois  = max(0, (int) ((strtotime($auj) - strtotime($e->date_embauche)) / 2592000));
                $ans   = (int) floor($mois / 12);
                $droit = ($ans < 1) ? (int) round($mois * 1.67) : 20 + (int) floor($ans / 4);
                $droits[$e->employe_id] = ['ans' => $ans, 'mois' => $mois, 'droit' => $droit];
                $total_droits += $droit;
            }

            /* Agrégats des congés */
            $en_conge_auj = [];
            $nb_attente = 0;
            $jours_pris = 0;
            $pris_par = [];
            $encours_par = [];
            foreach ($conges as $c) {
                if ($c->statut !== 'Rejeté' && $c->date_debut <= $auj && $c->date_fin >= $auj) $en_conge_auj[] = $c;
                if ($c->statut === 'En attente') $nb_attente++;
                if ($c->statut === 'Approuvé' && substr($c->date_debut, 0, 4) === date('Y')) {
                    $jours_pris += (int) $c->jours_ouvres;
                    if ($c->date_fin < $auj) $pris_par[$c->employe_id] = (isset($pris_par[$c->employe_id]) ? $pris_par[$c->employe_id] : 0) + (int) $c->jours_ouvres;
                    else                     $encours_par[$c->employe_id] = (isset($encours_par[$c->employe_id]) ? $encours_par[$c->employe_id] : 0) + (int) $c->jours_ouvres;
                }
            }

            /* Planning 60 jours + conflits (chevauchement même site) */
            $planning = [];
            foreach ($conges as $c) {
                if ($c->statut === 'Rejeté') continue;
                if ($c->date_fin >= $auj && $c->date_debut <= $plus60) $planning[] = $c;
            }
            usort($planning, function ($a, $b) {
                return strcmp($a->date_debut, $b->date_debut);
            });

            $conflits = [];
            for ($i = 0; $i < count($planning); $i++) {
                for ($j = $i + 1; $j < count($planning); $j++) {
                    $a = $planning[$i];
                    $b = $planning[$j];
                    if ($a->employe_id == $b->employe_id) continue;
                    $ea = isset($actifs[$a->employe_id]) ? $actifs[$a->employe_id] : NULL;
                    $eb = isset($actifs[$b->employe_id]) ? $actifs[$b->employe_id] : NULL;
                    if (
                        $ea && $eb && $ea->site_affectation === $eb->site_affectation
                        && $a->date_debut <= $b->date_fin && $b->date_debut <= $a->date_fin
                    ) {
                        $conflits[] = [$a, $b, $ea->site_affectation];
                    }
                }
            }

            /* Noms (remplaçants) */
            $noms = [];
            foreach ($employes as $e) $noms[$e->employe_id] = $e->prenoms . ' ' . mb_strtoupper($e->nom);

            $badge_type = ['Congé annuel' => 'info', 'Maladie' => 'warning', 'Maternité' => 'primary', 'Circonstance' => 'primary', 'Sans solde' => 'secondary'];
            ?>

            <!-- ============ 1. INDICATEURS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-umbrella-beach"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">En congé aujourd'hui</span>
                            <span class="info-box-number"><?= count($en_conge_auj) ?></span>
                            <span class="progress-description">Sur <?= $nb_actifs ?> actifs</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Demandes en attente</span>
                            <span class="info-box-number"><?= $nb_attente ?></span>
                            <span class="progress-description">À traiter cette semaine</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-calendar-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jours pris (<?= date('Y') ?>)</span>
                            <span class="info-box-number"><?= $jours_pris ?></span>
                            <span class="progress-description">Sur <?= number_format($total_droits, 0, '', ' ') ?> jours
                                de droits</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Conflits de planning</span>
                            <span class="info-box-number"><?= count($conflits) ?></span>
                            <span class="progress-description">Chevauchements même site (60 j)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. RÈGLES + EN CONGÉ AUJOURD'HUI ============ -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card legal-note">
                        <div class="card-body">
                            <h6 class="font-weight-bold mb-2"><i class="fas fa-balance-scale mr-1 text-success"></i>
                                Règles applicables</h6>
                            <ul class="mb-2 pl-3" style="font-size:.87rem">
                                <li><strong>Congé annuel</strong> : 20 jours ouvrables après 12 mois de service (≈ 1,67
                                    j/mois), majoré de <strong>+1 jour par tranche de 4 ans</strong> d'ancienneté ;</li>
                                <li><strong>Maladie</strong> : jusqu'à 3 mois par année civile, sur certificat médical ;
                                </li>
                                <li><strong>Maternité / circonstances</strong> : selon dispositions légales en vigueur ;
                                </li>
                                <li>Demande à introduire <strong>au moins 14 jours</strong> avant le départ.</li>
                            </ul>
                            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Les soldes sont calculés
                                automatiquement par le système.</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-umbrella-beach mr-1 text-success"></i> En congé
                                aujourd'hui (<?= date('d/m/Y') ?>)</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Type</th>
                                        <th>Période</th>
                                        <th>Jours</th>
                                        <th>Avancement</th>
                                        <th>Reprise</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($en_conge_auj)): foreach ($en_conge_auj as $c):
                                            $initiales = strtoupper(mb_substr($c->prenoms, 0, 1) . mb_substr($c->nom, 0, 1));
                                            $couleur   = $couleurs[$c->employe_id % count($couleurs)];
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar-initials mr-2"
                                                    style="background:<?= $couleur ?>"><?= $initiales ?></span>
                                                <div class="font-weight-bold">
                                                    <?= html_escape($c->prenoms . ' ' . mb_strtoupper($c->nom)) ?>
                                                    <small
                                                        class="text-muted">(<?= html_escape($c->matricule) ?>)</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge badge-<?= $badge_type[$c->type_conge] ?? 'secondary' ?>"><?= $c->type_conge ?></span>
                                        </td>
                                        <td><?= date('d/m', strtotime($c->date_debut)) ?> →
                                            <?= date('d/m/Y', strtotime($c->date_fin)) ?></td>
                                        <td><?= $c->jours_ouvres ?></td>
                                        <td>
                                            <div class="progress" style="height:6px;width:120px">
                                                <div class="progress-bar bg-info"
                                                    style="width:<?= $avancement($c->date_debut, $c->date_fin) ?>%">
                                                </div>
                                            </div>
                                        </td>
                                        <td><strong><?= $reprise($c->date_fin) ?></strong></td>
                                    </tr>
                                    <?php endforeach;
                                    else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Personne n'est en congé
                                            aujourd'hui.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 3. ONGLETS ============ -->
            <div class="card">
                <div class="card-header p-2 px-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tabDemandes"><i
                                        class="fas fa-inbox mr-1"></i> Demandes <span
                                        class="badge badge-warning ml-1"><?= $nb_attente ?></span></a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabPlanning"><i
                                        class="fas fa-calendar-alt mr-1"></i> Planning (60 jours)</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabSoldes"><i
                                        class="fas fa-wallet mr-1"></i> Soldes <?= date('Y') ?></a></li>
                        </ul>
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#modalDemandeConge">
                            <i class="fas fa-plus mr-1"></i> Nouvelle demande
                        </button>
                    </div>
                </div>

                <div class="tab-content">

                    <!-- ===== ONGLET : DEMANDES ===== -->
                    <div class="tab-pane fade active show" id="tabDemandes">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Type</th>
                                        <th>Période demandée</th>
                                        <th>Jours ouvrés</th>
                                        <th>Remplaçant proposé</th>
                                        <th>Statut</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($conges)): foreach ($conges as $c):
                                            $initiales = strtoupper(mb_substr($c->prenoms, 0, 1) . mb_substr($c->nom, 0, 1));
                                            $couleur   = $couleurs[$c->employe_id % count($couleurs)];
                                            $row_class = $c->statut === 'En attente' ? 'table-warning' : '';
                                            if ($c->statut === 'En attente')      $badge_st = '<span class="badge badge-warning">En attente</span>';
                                            elseif ($c->statut === 'Approuvé')    $badge_st = '<span class="badge badge-success">Approuvé</span>';
                                            else                                  $badge_st = '<span class="badge badge-danger">Rejeté</span>';
                                    ?>
                                    <tr class="<?= $row_class ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar-initials mr-2"
                                                    style="background:<?= $couleur ?>"><?= $initiales ?></span>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        <?= html_escape($c->prenoms . ' ' . mb_strtoupper($c->nom)) ?>
                                                    </div>
                                                    <small
                                                        class="text-muted"><?= html_escape($c->matricule . ' · ' . $c->fonction) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge badge-<?= $badge_type[$c->type_conge] ?? 'secondary' ?>"><?= $c->type_conge ?></span>
                                        </td>
                                        <td><?= date('d/m', strtotime($c->date_debut)) ?> →
                                            <?= date('d/m/Y', strtotime($c->date_fin)) ?></td>
                                        <td><?= $c->jours_ouvres ?></td>
                                        <td><?= !empty($c->remplacant_id) && isset($noms[$c->remplacant_id]) ? html_escape($noms[$c->remplacant_id]) : '<small class="text-muted">— à désigner —</small>' ?>
                                        </td>
                                        <td><?= $badge_st ?></td>
                                        <td class="text-right">
                                            <?php if ($c->statut === 'En attente'): ?>
                                            <button class="btn btn-sm btn-success" title="Approuver"><i
                                                    class="fas fa-check"></i></button>
                                            <button class="btn btn-sm btn-danger" title="Rejeter"><i
                                                    class="fas fa-times"></i></button>
                                            <?php else: ?>
                                            <button class="btn btn-sm btn-default" title="Voir"><i
                                                    class="fas fa-eye"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach;
                                    else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">Aucune demande de congé.
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ===== ONGLET : PLANNING 60 JOURS ===== -->
                    <div class="tab-pane fade" id="tabPlanning">
                        <div class="card-body">
                            <?php if (!empty($conflits)): $cf = $conflits[0]; ?>
                            <div class="alert alert-warning py-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <strong>Conflit détecté :</strong>
                                <?= html_escape($cf[0]->prenoms . ' ' . mb_strtoupper($cf[0]->nom)) ?>
                                (<?= date('d/m', strtotime($cf[0]->date_debut)) ?> →
                                <?= date('d/m', strtotime($cf[0]->date_fin)) ?>)
                                et <?= html_escape($cf[1]->prenoms . ' ' . mb_strtoupper($cf[1]->nom)) ?>
                                (<?= date('d/m', strtotime($cf[1]->date_debut)) ?> →
                                <?= date('d/m', strtotime($cf[1]->date_fin)) ?>)
                                absents simultanément sur <strong><?= html_escape($cf[2]) ?></strong> — prévoir un
                                remplaçant ou décaler l'un des deux.
                            </div>
                            <?php endif; ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Employé</th>
                                            <th>Site / Département</th>
                                            <th>Période</th>
                                            <th>Jours</th>
                                            <th>Remplaçant prévu</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($planning)): foreach ($planning as $c):
                                                $e = isset($actifs[$c->employe_id]) ? $actifs[$c->employe_id] : NULL;
                                                $lieu = $e ? (($e->categorie === 'Chantier') ? $e->site_affectation : $e->departement) : '—';
                                        ?>
                                        <tr>
                                            <td><?= html_escape($c->prenoms . ' ' . mb_strtoupper($c->nom)) ?></td>
                                            <td><?= html_escape($lieu) ?></td>
                                            <td><?= date('d/m', strtotime($c->date_debut)) ?> →
                                                <?= date('d/m/Y', strtotime($c->date_fin)) ?></td>
                                            <td><?= $c->jours_ouvres ?></td>
                                            <td><?= !empty($c->remplacant_id) && isset($noms[$c->remplacant_id]) ? html_escape($noms[$c->remplacant_id]) : '— à désigner' ?>
                                            </td>
                                            <td>
                                                <?php if ($c->statut === 'En attente'): ?><span
                                                    class="badge badge-warning">En approbation</span>
                                                <?php else: ?><span
                                                    class="badge badge-success">Approuvé</span><?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach;
                                        else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">Aucun congé planifié sur
                                                les 60 prochains jours.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Le planning est établi en
                                début d'année par service/chantier, puis ajusté par demandes individuelles.</small>
                        </div>
                    </div>

                    <!-- ===== ONGLET : SOLDES ===== -->
                    <div class="tab-pane fade" id="tabSoldes">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Ancienneté</th>
                                        <th>Droit <?= date('Y') ?></th>
                                        <th>Jours pris</th>
                                        <th>En cours / à venir</th>
                                        <th>Solde restant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($actifs as $id => $e):
                                        $d      = $droits[$id];
                                        $pris   = isset($pris_par[$id]) ? $pris_par[$id] : 0;
                                        $enc    = isset($encours_par[$id]) ? $encours_par[$id] : 0;
                                        $solde  = $d['droit'] - $pris - $enc;
                                        $badge  = $solde <= 0 ? 'badge-secondary' : ($solde < 5 ? 'badge-warning' : 'badge-success');
                                    ?>
                                    <tr>
                                        <td><?= html_escape($e->prenoms . ' ' . mb_strtoupper($e->nom)) ?> <small
                                                class="text-muted">(<?= html_escape($e->matricule) ?>)</small></td>
                                        <td><?= $d['ans'] < 1 ? '&lt; 1 an <small class="text-muted">(prorata)</small>' : $d['ans'] . ' ans' ?>
                                        </td>
                                        <td><?= $d['droit'] ?> j</td>
                                        <td><?= $pris ?></td>
                                        <td><?= $enc ?></td>
                                        <td><span class="badge <?= $badge ?>"><?= $solde ?> j</span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Droit annuel = 20 j
                                ouvrables + 1 j par tranche de 4 ans d'ancienneté ; prorata la première année.</small>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============ MODALE : NOUVELLE DEMANDE ============ -->
            <div class="modal fade" id="modalDemandeConge">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="formDemandeConge" method="post" action="<?= base_url('rh-conges-store') ?>"
                            enctype="multipart/form-data">
                            <div class="modal-header bg-success text-white">
                                <h4 class="modal-title"><i class="fas fa-umbrella-beach mr-2"></i>Nouvelle demande de
                                    congé</h4>
                                <button type="button" class="close text-white"
                                    data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Employé *</label>
                                            <select name="employe_id" class="form-control" required>
                                                <option value="">— Sélectionner —</option>
                                                <?php foreach ($employes as $e): if ($e->statut === 'Fin de contrat') continue; ?>
                                                <option value="<?= $e->employe_id ?>">
                                                    <?= html_escape($e->matricule . ' · ' . $e->prenoms . ' ' . mb_strtoupper($e->nom)) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Type de congé *</label>
                                            <select name="type_conge" class="form-control" required>
                                                <option>Congé annuel</option>
                                                <option>Maladie (certificat requis)</option>
                                                <option>Maternité</option>
                                                <option>Circonstance (mariage, naissance, décès)</option>
                                                <option>Sans solde</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Date de début *</label>
                                            <input type="date" name="date_debut" id="congeDebut" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Date de fin *</label>
                                            <input type="date" name="date_fin" id="congeFin" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Jours ouvrés calculés</label>
                                            <input type="text" id="congeJours" name="jours_apercu" class="form-control"
                                                value="—" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Remplaçant proposé</label>
                                            <select name="remplacant_id" class="form-control">
                                                <option value="">— Aucun —</option>
                                                <?php foreach ($employes as $r): if ($r->statut === 'Fin de contrat') continue; ?>
                                                <option value="<?= $r->employe_id ?>">
                                                    <?= html_escape($r->matricule . ' · ' . $r->prenoms . ' ' . mb_strtoupper($r->nom)) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Pièce justificative</label>
                                            <div class="custom-file">
                                                <input type="file" name="justificatif" class="custom-file-input"
                                                    id="fileJustifConge">
                                                <label class="custom-file-label" for="fileJustifConge">Choisir…</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group"><label>Observation</label>
                                            <textarea name="observation" class="form-control" rows="2"
                                                placeholder="Précisions éventuelles (fractionnement, urgence…)"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane mr-1"></i>
                                    Soumettre la demande</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ============ SCRIPTS ============ -->
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var form = document.getElementById('formDemandeConge');
                if (!form) return;

                function joursOuvres(debut, fin) {
                    var d = new Date(debut),
                        f = new Date(fin),
                        n = 0;
                    while (d <= f) {
                        var wd = d.getDay();
                        if (wd !== 0 && wd !== 6) n++;
                        d.setDate(d.getDate() + 1);
                    }
                    return n;
                }

                function majJours() {
                    var deb = form.querySelector('[name="date_debut"]').value;
                    var fin = form.querySelector('[name="date_fin"]').value;
                    var out = form.querySelector('#congeJours');
                    out.value = (deb && fin && fin >= deb) ? joursOuvres(deb, fin) + ' jour(s)' : '—';
                }
                form.querySelector('[name="date_debut"]').addEventListener('change', majJours);
                form.querySelector('[name="date_fin"]').addEventListener('change', majJours);

                form.querySelectorAll('.custom-file-input').forEach(function(input) {
                    input.addEventListener('change', function() {
                        var label = this.closest('.custom-file').querySelector(
                            '.custom-file-label');
                        label.textContent = (this.files && this.files.length) ? this.files[0]
                            .name : 'Choisir…';
                        label.classList.toggle('has-file', this.files.length > 0);
                    });
                });
            });
            </script>

        </div>
    </section>
</div>