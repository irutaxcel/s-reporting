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

            <!-- ici le contenu de tableau de bord -->

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

            .kpi-lien {
                color: inherit;
                text-decoration: none;
            }

            .kpi-lien:hover {
                text-decoration: none;
                opacity: .9;
            }
            </style>

            <!-- ============ CALCULS (toutes les tables RH) ============ -->
            <?php
            $auj      = date('Y-m-d');
            $plus30   = date('Y-m-d', strtotime('+30 days'));
            $mois_crt = date('Y-m');
            $couleurs = ['#1f7a5c', '#2c8a69', '#34608c', '#7a4f1f', '#8a3033', '#6c757d'];

            $nb_actifs = $nb_bureau = $nb_chantier = 0;
            $par_site = [];
            $par_dept = [];
            $par_contrat = [];
            $masse_brute = 0;

            foreach ($employes as $e) {
                if ($e->statut === 'Fin de contrat') continue;
                $nb_actifs++;
                ($e->categorie === 'Chantier') ? $nb_chantier++ : $nb_bureau++;

                $site = $e->site_affectation ?: '—';
                $par_site[$site] = isset($par_site[$site]) ? $par_site[$site] + 1 : 1;
                $dept = $e->departement ?: '—';
                $par_dept[$dept] = isset($par_dept[$dept]) ? $par_dept[$dept] + 1 : 1;
                $par_contrat[$e->type_contrat] = isset($par_contrat[$e->type_contrat]) ? $par_contrat[$e->type_contrat] + 1 : 1;

                $base = (float) $e->salaire_base;
                $masse_brute += $base + round($base * 0.10) + 50000;
            }
            arsort($par_site);
            arsort($par_dept);

            /* Mouvements du mois */
            $entrees_mois = $sorties_mois = 0;
            foreach ($mouvements as $m) {
                if (substr($m->date_effet, 0, 7) === $mois_crt) {
                    if ($m->type_mouvement === 'Entrée') $entrees_mois++;
                    elseif (in_array($m->type_mouvement, ['Démission', 'Licenciement', 'Fin de contrat', 'Retraite'])) $sorties_mois++;
                }
            }

            /* Alertes */
            $contrats_alerte = [];
            foreach ($contrats as $c) {
                if (!empty($c->date_fin) && $c->date_fin >= $auj && $c->date_fin <= $plus30 && $c->statut !== 'Expiré') $contrats_alerte[] = $c;
            }
            $conges_attente = [];
            foreach ($conges as $cg) if ($cg->statut === 'En attente') $conges_attente[] = $cg;
            $dossiers_ouverts = [];
            foreach ($dossiers as $d) if ($d->statut !== 'Clôturé') $dossiers_ouverts[] = $d;
            $nb_a_traiter = count($contrats_alerte) + count($conges_attente) + count($dossiers_ouverts);

            /* Évaluations */
            $nb_evals = 0;
            $somme = 0;
            foreach ($evaluations as $ev) {
                if ($ev->statut === 'Validée') {
                    $nb_evals++;
                    $somme += (float) $ev->score_global;
                }
            }
            $note_moy = $nb_evals ? round($somme / $nb_evals, 2) : 0;

            $badge_mouv = [
                'Entrée' => 'success',
                'Démission' => 'warning',
                'Licenciement' => 'danger',
                'Fin de contrat' => 'secondary',
                'Retraite' => 'info',
                'Transfert' => 'primary',
                'Promotion' => 'info'
            ];
            ?>

            <!-- ============ 1. INDICATEURS CLÉS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <a class="kpi-lien" href="<?= base_url('rh-employes') ?>">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Effectif actif</span>
                                <span class="info-box-number"><?= $nb_actifs ?></span>
                                <span class="progress-description"><?= $nb_bureau ?> bureau · <?= $nb_chantier ?>
                                    chantier</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a class="kpi-lien" href="<?= base_url('rh-paie') ?>">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-money-bill-wave"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Masse salariale (est.)</span>
                                <span class="info-box-number"><?= number_format($masse_brute, 0, '', ' ') ?>
                                    <small>BIF</small></span>
                                <span class="progress-description">Brut mensuel · <?= date('F Y') ?></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a class="kpi-lien" href="<?= base_url('rh-contrats') ?>">
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary"><i class="fas fa-exchange-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Mouvements (<?= date('m/Y') ?>)</span>
                                <span class="info-box-number">+<?= $entrees_mois ?> / −<?= $sorties_mois ?></span>
                                <span class="progress-description">Entrées / sorties du mois</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-bell"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Points à traiter</span>
                            <span class="info-box-number"><?= $nb_a_traiter ?></span>
                            <span class="progress-description"><?= count($contrats_alerte) ?> contrats ·
                                <?= count($conges_attente) ?> congés · <?= count($dossiers_ouverts) ?> dossiers</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. RÉPARTITIONS ============ -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-map-marker-alt mr-1 text-success"></i> Effectif
                                par site</h3>
                        </div>
                        <div class="card-body">
                            <?php foreach ($par_site as $site => $nb): $pct = $nb_actifs ? round($nb / $nb_actifs * 100) : 0; ?>
                            <p class="mb-1 d-flex justify-content-between">
                                <span><?= html_escape($site) ?></span><strong><?= $nb ?> <small
                                        class="text-muted">({{ pct }} %)</small></strong></p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar bg-success" style="width:<?= $pct ?>%"></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-sitemap mr-1 text-success"></i> Effectif par
                                département</h3>
                        </div>
                        <div class="card-body">
                            <?php foreach ($par_dept as $dept => $nb): $pct = $nb_actifs ? round($nb / $nb_actifs * 100) : 0; ?>
                            <p class="mb-1 d-flex justify-content-between">
                                <span><?= html_escape($dept) ?></span><strong><?= $nb ?></strong></p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar bg-info" style="width:<?= $pct ?>%"></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-chart-pie mr-1 text-success"></i> Contrats
                                &amp; performance</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-3">
                                <div class="col-4"><span
                                        class="badge badge-success p-2">CDI<br><?= isset($par_contrat['CDI']) ? $par_contrat['CDI'] : 0 ?></span>
                                </div>
                                <div class="col-4"><span
                                        class="badge badge-warning p-2">CDD<br><?= isset($par_contrat['CDD']) ? $par_contrat['CDD'] : 0 ?></span>
                                </div>
                                <div class="col-4"><span
                                        class="badge badge-info p-2">Stage<br><?= isset($par_contrat['Stage']) ? $par_contrat['Stage'] : 0 ?></span>
                                </div>
                            </div>
                            <hr>
                            <p class="mb-1 d-flex justify-content-between"><span>Note moyenne
                                    évaluations</span><strong><?= number_format($note_moy, 2, ',', ' ') ?> / 5</strong>
                            </p>
                            <div class="progress mb-2" style="height:8px">
                                <div class="progress-bar bg-success" style="width:<?= ($note_moy / 5) * 100 ?>%"></div>
                            </div>
                            <small class="text-muted"><?= $nb_evals ?> évaluation(s) validée(s) · campagne 2026</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 3. ALERTES & À TRAITER ============ -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-file-contract mr-1 text-warning"></i> Contrats
                                expirant sous 30 j</h3>
                        </div>
                        <div class="card-body p-0">
                            <?php if (!empty($contrats_alerte)): ?>
                            <table class="table table-sm table-hover mb-0">
                                <tbody>
                                    <?php foreach ($contrats_alerte as $c): $j = (int) (new DateTime($auj))->diff(new DateTime($c->date_fin))->days; ?>
                                    <tr>
                                        <td><?= html_escape($c->prenoms . ' ' . mb_strtoupper($c->nom)) ?><small
                                                class="d-block text-muted"><?= html_escape($c->matricule) ?></small>
                                        </td>
                                        <td class="text-right"><span
                                                class="badge badge-<?= $j <= 10 ? 'danger' : 'warning' ?>">J-<?= $j ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?><p class="text-muted text-center py-3 mb-0">Aucun contrat n'expire sous 30
                                jours.</p><?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-umbrella-beach mr-1 text-info"></i> Congés en
                                attente</h3>
                        </div>
                        <div class="card-body p-0">
                            <?php if (!empty($conges_attente)): ?>
                            <table class="table table-sm table-hover mb-0">
                                <tbody>
                                    <?php foreach ($conges_attente as $cg): ?>
                                    <tr>
                                        <td><?= html_escape($cg->prenoms . ' ' . mb_strtoupper($cg->nom)) ?><small
                                                class="d-block text-muted"><?= date('d/m', strtotime($cg->date_debut)) ?>
                                                → <?= date('d/m/Y', strtotime($cg->date_fin)) ?></small></td>
                                        <td class="text-right"><span class="badge badge-info"><?= $cg->jours_ouvres ?>
                                                j</span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?><p class="text-muted text-center py-3 mb-0">Aucune demande en attente.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-gavel mr-1 text-danger"></i> Dossiers
                                discipline ouverts</h3>
                        </div>
                        <div class="card-body p-0">
                            <?php if (!empty($dossiers_ouverts)): ?>
                            <table class="table table-sm table-hover mb-0">
                                <tbody>
                                    <?php foreach ($dossiers_ouverts as $d): ?>
                                    <tr>
                                        <td><?= html_escape($d->prenoms . ' ' . mb_strtoupper($d->nom)) ?><small
                                                class="d-block text-muted"><?= html_escape($d->reference . ' · ' . $d->type_faute) ?></small>
                                        </td>
                                        <td class="text-right"><span
                                                class="badge badge-<?= $d->statut === 'Ouvert' ? 'warning' : 'info' ?>"><?= $d->statut ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?><p class="text-muted text-center py-3 mb-0">Aucun dossier ouvert.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 4. DERNIERS MOUVEMENTS ============ -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="fas fa-history mr-1 text-success"></i> Derniers mouvements du
                        personnel</h3>
                    <a href="<?= base_url('rh-rapports') ?>" class="btn btn-sm btn-default"><i
                            class="fas fa-chart-bar mr-1"></i> Rapport mensuel</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Date effet</th>
                                <th>Employé</th>
                                <th>Type</th>
                                <th>Détail</th>
                                <th>Affectation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0;
                            foreach ($mouvements as $m): if ($i++ >= 6) break;
                                $initiales = strtoupper(mb_substr($m->prenoms, 0, 1) . mb_substr($m->nom, 0, 1));
                                $couleur   = $couleurs[$m->employe_id % count($couleurs)];
                                $lieu      = !empty($m->nouvelle_affectation) ? $m->nouvelle_affectation : (isset($m->site_affectation) ? $m->site_affectation : '—');
                            ?>
                            <tr>
                                <td><strong><?= date('d/m/Y', strtotime($m->date_effet)) ?></strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar-initials mr-2"
                                            style="background:<?= $couleur ?>"><?= $initiales ?></span>
                                        <div>
                                            <div class="font-weight-bold">
                                                <?= html_escape($m->prenoms . ' ' . mb_strtoupper($m->nom)) ?></div>
                                            <small class="text-muted"><?= html_escape($m->matricule) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-<?= $badge_mouv[$m->type_mouvement] ?? 'secondary' ?>"><?= $m->type_mouvement ?></span>
                                </td>
                                <td><?= html_escape($m->motif ?: '—') ?></td>
                                <td><?= html_escape($lieu) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->