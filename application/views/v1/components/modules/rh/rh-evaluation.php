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

            <!-- ============ STYLE LOCAL (page évaluations) ============ -->
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

            .score-pill {
                display: inline-block;
                min-width: 52px;
                text-align: center;
                padding: .25rem .5rem;
                border-radius: 1rem;
                font-weight: 700;
                color: #fff;
            }

            .scale-step {
                border-left: 4px solid #1f7a5c;
                background: #f8faf9;
            }
            </style>

            <!-- ============ CALCULS ============ -->
            <?php
            $couleurs = ['#1f7a5c', '#2c8a69', '#34608c', '#7a4f1f', '#8a3033', '#6c757d'];

            $total_evals = count($evaluations);
            $nb_validees = $nb_encours = $nb_formation = 0;
            $somme_scores = 0;

            foreach ($evaluations as $ev) {
                if ($ev->statut === 'Validée') {
                    $nb_validees++;
                    $somme_scores += (float) $ev->score_global;
                } else {
                    $nb_encours++;
                }
                if ($ev->decision_proposee === 'Formation') $nb_formation++;
            }

            $note_moyenne = $nb_validees ? round($somme_scores / $nb_validees, 2) : 0;
            $pct          = $total_evals ? round($nb_validees / $total_evals * 100) : 0;

            $couleur_score = function ($s) {
                if ($s >= 4.5) return '#1f7a5c';
                if ($s >= 3.5) return '#2c8a69';
                if ($s >= 2.5) return '#34608c';
                if ($s >= 1.5) return '#b7791f';
                return '#8a3033';
            };
            $badge_app = [
                'Excellent' => 'success',
                'Très bien' => 'info',
                'Satisfaisant' => 'secondary',
                'À améliorer' => 'warning',
                'Insuffisant' => 'danger'
            ];
            ?>

            <!-- ============ 1. INDICATEURS — CAMPAGNE 2026 ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-clipboard-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Campagne annuelle 2026</span>
                            <span class="info-box-number"><?= $nb_validees ?> / <?= $total_evals ?></span>
                            <span class="progress-description">
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width:<?= $pct ?>%"></div>
                                </div>
                                Évaluations réalisées
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-star-half-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Note moyenne</span>
                            <span class="info-box-number"><?= number_format($note_moyenne, 2, ',', ' ') ?> / 5</span>
                            <span class="progress-description">Sur <?= $nb_validees ?> évaluation(s) validée(s)</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">À traiter</span>
                            <span class="info-box-number"><?= $nb_encours ?></span>
                            <span class="progress-description">Évaluation(s) en cours</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-graduation-cap"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Plans de formation</span>
                            <span class="info-box-number"><?= $nb_formation ?></span>
                            <span class="progress-description">Issus des évaluations 2026</span>
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

            <!-- ============ 2. ONGLETS ============ -->
            <div class="card">
                <div class="card-header p-2 px-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tabCampagne"><i
                                        class="fas fa-clipboard-list mr-1"></i> Campagne 2026</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabGrille"><i
                                        class="fas fa-th-list mr-1"></i> Grille &amp; barème</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabHistorique"><i
                                        class="fas fa-history mr-1"></i> Historique des campagnes</a></li>
                        </ul>
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#modalEvaluation">
                            <i class="fas fa-plus mr-1"></i> Nouvelle évaluation
                        </button>
                    </div>
                </div>

                <div class="tab-content">

                    <!-- ===== ONGLET : CAMPAGNE 2026 (DYNAMIQUE) ===== -->
                    <div class="tab-pane fade active show" id="tabCampagne">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Affectation</th>
                                        <th>Évaluateur</th>
                                        <th>Période évaluée</th>
                                        <th>Score</th>
                                        <th>Appréciation</th>
                                        <th>Statut</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($evaluations)): foreach ($evaluations as $ev):
                                            $initiales = strtoupper(mb_substr($ev->prenoms, 0, 1) . mb_substr($ev->nom, 0, 1));
                                            $couleur   = $couleurs[$ev->employe_id % count($couleurs)];
                                            $affect    = ($ev->categorie === 'Chantier') ? $ev->site_affectation : $ev->departement;
                                            $row_class = $ev->statut === 'En cours' ? 'table-warning' : '';
                                    ?>
                                    <tr class="<?= $row_class ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar-initials mr-2"
                                                    style="background:<?= $couleur ?>"><?= $initiales ?></span>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        <?= html_escape($ev->prenoms . ' ' . mb_strtoupper($ev->nom)) ?>
                                                    </div>
                                                    <small class="text-muted"><?= html_escape($ev->matricule) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= html_escape($affect) ?></td>
                                        <td><?= html_escape($ev->evaluateur) ?></td>
                                        <td><?= date('d/m/Y', strtotime($ev->periode_debut)) ?>
                                            <small class="text-muted d-block">→
                                                <?= date('d/m/Y', strtotime($ev->periode_fin)) ?></small>
                                        </td>
                                        <td><span class="score-pill"
                                                style="background:<?= $couleur_score((float) $ev->score_global) ?>"><?= number_format((float) $ev->score_global, 1, ',', ' ') ?></span>
                                        </td>
                                        <td><span
                                                class="badge badge-<?= $badge_app[$ev->appreciation] ?? 'secondary' ?>"><?= html_escape($ev->appreciation) ?></span>
                                        </td>
                                        <td>
                                            <?php if ($ev->statut === 'Validée'): ?>
                                            <span class="badge badge-success">Validée</span>
                                            <?php else: ?>
                                            <span class="badge badge-warning">En cours</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right">
                                            <?php if ($ev->statut === 'En cours'): ?>
                                            <button class="btn btn-sm btn-success" title="Compléter l'évaluation"><i
                                                    class="fas fa-edit"></i></button>
                                            <?php endif; ?>
                                            <button class="btn btn-sm btn-default" title="Consulter"><i
                                                    class="fas fa-eye"></i></button>
                                            <button class="btn btn-sm btn-default" title="Compte-rendu PDF"><i
                                                    class="fas fa-file-pdf text-danger"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach;
                                    else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4"><i
                                                class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucune évaluation
                                            enregistrée.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <small class="text-muted float-left mt-2">
                                Campagne 2026 · <?= $nb_validees ?> validée(s) · <?= $nb_encours ?> en cours · note
                                moyenne <?= number_format($note_moyenne, 2, ',', ' ') ?> / 5
                            </small>
                        </div>
                    </div>

                    <!-- ===== ONGLET : GRILLE & BARÈME ===== -->
                    <div class="tab-pane fade" id="tabGrille">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-7">
                                    <h6 class="section-title mb-3"><i class="fas fa-th-list mr-1"></i> Critères pondérés
                                        (total = 100 %)</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Critère</th>
                                                    <th>Description</th>
                                                    <th class="text-center">Poids</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Performance du travail</strong></td>
                                                    <td>Qualité, quantité, respect des délais</td>
                                                    <td class="text-center"><span class="badge badge-success">30
                                                            %</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Compétences techniques</strong></td>
                                                    <td>Maîtrise du métier, polyvalence</td>
                                                    <td class="text-center"><span class="badge badge-success">20
                                                            %</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Ponctualité &amp; assiduité</strong></td>
                                                    <td>Présences, retards, respect des horaires</td>
                                                    <td class="text-center"><span class="badge badge-success">15
                                                            %</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Esprit d'équipe</strong></td>
                                                    <td>Collaboration, communication, entraide</td>
                                                    <td class="text-center"><span class="badge badge-success">15
                                                            %</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Initiative &amp; autonomie</strong></td>
                                                    <td>Propositions, prise de responsabilité</td>
                                                    <td class="text-center"><span class="badge badge-success">10
                                                            %</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Respect des règles &amp; sécurité</strong></td>
                                                    <td>EPI, procédures, discipline</td>
                                                    <td class="text-center"><span class="badge badge-success">10
                                                            %</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="alert alert-info py-2 mb-0">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <small>Le <strong>score global</strong> est la moyenne pondérée des 6 critères ;
                                            les données de présence et de discipline sont reprises automatiquement des
                                            modules <em>Temps &amp; présences</em> et <em>Discipline</em>.</small>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <h6 class="section-title mb-3"><i class="fas fa-star mr-1"></i> Échelle de notation
                                    </h6>
                                    <div class="scale-step p-3 mb-2"><strong>5 — Excellent</strong><small
                                            class="d-block text-muted">Dépasse durablement les attentes.</small></div>
                                    <div class="scale-step p-3 mb-2"><strong>4 — Très bien</strong><small
                                            class="d-block text-muted">Atteint et dépasse souvent les attentes.</small>
                                    </div>
                                    <div class="scale-step p-3 mb-2"><strong>3 — Bien / Satisfaisant</strong><small
                                            class="d-block text-muted">Atteint les attentes du poste.</small></div>
                                    <div class="scale-step p-3 mb-2"><strong>2 — À améliorer</strong><small
                                            class="d-block text-muted">Atteint partiellement les attentes — plan de
                                            progrès requis.</small></div>
                                    <div class="scale-step p-3 mb-2" style="border-left-color:#dc3545"><strong>1 —
                                            Insuffisant</strong><small class="d-block text-muted">N'atteint pas les
                                            attentes — accompagnement ou décision RH.</small></div>
                                    <div class="alert alert-warning py-2 mt-3 mb-0">
                                        <i class="fas fa-handshake mr-1"></i>
                                        <small>Chaque évaluation se conclut par un <strong>entretien individuel</strong>
                                            et fixe les <strong>objectifs de la période suivante</strong>.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== ONGLET : HISTORIQUE ===== -->
                    <div class="tab-pane fade" id="tabHistorique">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h6 class="section-title mb-3"><i class="fas fa-archive mr-1"></i> Campagnes
                                        précédentes</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Campagne</th>
                                                    <th>Évalués</th>
                                                    <th>Note moyenne</th>
                                                    <th>Décisions issues</th>
                                                    <th class="text-right">Archive</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Annuelle 2025</strong></td>
                                                    <td>52</td>
                                                    <td><span class="score-pill" style="background:#34608c">3,6</span>
                                                    </td>
                                                    <td><small>2 promotions · 4 primes · 6 formations</small></td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-folder-open"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Annuelle 2024</strong></td>
                                                    <td>48</td>
                                                    <td><span class="score-pill" style="background:#7a4f1f">3,4</span>
                                                    </td>
                                                    <td><small>1 promotion · 3 primes · 5 formations</small></td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-folder-open"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="section-title mb-3"><i class="fas fa-chart-bar mr-1"></i> Répartition des
                                        appréciations — 2025</h6>
                                    <p class="mb-1 d-flex justify-content-between"><span>Excellent
                                            (5)</span><strong>4</strong></p>
                                    <div class="progress mb-2" style="height:8px">
                                        <div class="progress-bar bg-success" style="width:8%"></div>
                                    </div>
                                    <p class="mb-1 d-flex justify-content-between"><span>Très bien
                                            (4)</span><strong>14</strong></p>
                                    <div class="progress mb-2" style="height:8px">
                                        <div class="progress-bar bg-info" style="width:27%"></div>
                                    </div>
                                    <p class="mb-1 d-flex justify-content-between"><span>Satisfaisant
                                            (3)</span><strong>24</strong></p>
                                    <div class="progress mb-2" style="height:8px">
                                        <div class="progress-bar bg-warning" style="width:46%"></div>
                                    </div>
                                    <p class="mb-1 d-flex justify-content-between"><span>À améliorer
                                            (2)</span><strong>8</strong></p>
                                    <div class="progress mb-2" style="height:8px">
                                        <div class="progress-bar" style="width:15%;background:#fd7e14"></div>
                                    </div>
                                    <p class="mb-1 d-flex justify-content-between"><span>Insuffisant
                                            (1)</span><strong>2</strong></p>
                                    <div class="progress mb-2" style="height:8px">
                                        <div class="progress-bar bg-danger" style="width:4%"></div>
                                    </div>
                                    <div class="alert alert-success py-2 mt-3 mb-0">
                                        <i class="fas fa-lightbulb mr-1"></i>
                                        <small>Les évaluations alimentent les décisions de <strong>formation</strong>,
                                            <strong>promotion</strong> et <strong>primes</strong>, ainsi que la
                                            confirmation des périodes d'essai.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============ MODALE : NOUVELLE ÉVALUATION ============ -->
            <div class="modal fade" id="modalEvaluation">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="formEvaluation" method="post" action="<?= base_url('rh-evaluations-store') ?>">
                            <div class="modal-header bg-success text-white">
                                <h4 class="modal-title"><i class="fas fa-clipboard-check mr-2"></i>Nouvelle évaluation
                                </h4>
                                <button type="button" class="close text-white"
                                    data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Employé évalué *</label>
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
                                        <div class="form-group"><label>Évaluateur *</label>
                                            <select name="evaluateur" class="form-control" required>
                                                <option value="">— Sélectionner —</option>
                                                <option>J.-M. NDAYIZEYE (Resp. RH)</option>
                                                <option>O. BUKURU (Dir. Technique)</option>
                                                <option>Th. NIMUBONA (DAF)</option>
                                                <option>J.-C. NSABIMANA (Chef de chantier)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Type d'évaluation *</label>
                                            <select name="type_evaluation" class="form-control" required>
                                                <option>Annuelle</option>
                                                <option>Fin de période d'essai</option>
                                                <option>Fin de stage</option>
                                                <option>Ponctuelle (après incident ou promotion)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Période évaluée *</label>
                                            <div class="row">
                                                <div class="col-6"><input type="date" name="periode_debut"
                                                        class="form-control" required></div>
                                                <div class="col-6"><input type="date" name="periode_fin"
                                                        class="form-control" required></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="section-title mt-2 mb-2">Notation par critère (1 à 5)</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group"><label>Performance du travail (30 %)</label>
                                                    <select name="note_performance" class="form-control note-critere"
                                                        required>
                                                        <option value="">—</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"><label>Compétences techniques (20 %)</label>
                                                    <select name="note_competences" class="form-control note-critere"
                                                        required>
                                                        <option value="">—</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"><label>Ponctualité &amp; assiduité (15
                                                        %)</label>
                                                    <select name="note_ponctualite" class="form-control note-critere"
                                                        required>
                                                        <option value="">—</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"><label>Esprit d'équipe (15 %)</label>
                                                    <select name="note_esprit" class="form-control note-critere"
                                                        required>
                                                        <option value="">—</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"><label>Initiative &amp; autonomie (10 %)</label>
                                                    <select name="note_initiative" class="form-control note-critere"
                                                        required>
                                                        <option value="">—</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"><label>Règles &amp; sécurité (10 %)</label>
                                                    <select name="note_securite" class="form-control note-critere"
                                                        required>
                                                        <option value="">—</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"><label>Score global pondéré (auto)</label>
                                                    <input type="text" id="scoreGlobal"
                                                        class="form-control font-weight-bold" value="—" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Points forts</label>
                                            <textarea name="points_forts" class="form-control" rows="2"
                                                placeholder="Ce que l'employé fait bien…"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Axes d'amélioration</label>
                                            <textarea name="axes_amelioration" class="form-control" rows="2"
                                                placeholder="Points à travailler, formation proposée…"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Objectifs de la prochaine période</label>
                                            <textarea name="objectifs" class="form-control" rows="2"
                                                placeholder="Objectifs SMART assignés…"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Décision proposée</label>
                                            <select name="decision_proposee" class="form-control">
                                                <option value="">— Aucune —</option>
                                                <option>Formation</option>
                                                <option>Prime de performance</option>
                                                <option>Promotion</option>
                                                <option>Plan de progrès</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>
                                    Enregistrer l'évaluation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ============ SCRIPT : SCORE EN DIRECT ============ -->
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var form = document.getElementById('formEvaluation');
                if (!form) return;

                var poids = {
                    note_performance: 0.30,
                    note_competences: 0.20,
                    note_ponctualite: 0.15,
                    note_esprit: 0.15,
                    note_initiative: 0.10,
                    note_securite: 0.10
                };

                function majScore() {
                    var total = 0,
                        complet = true;
                    for (var k in poids) {
                        var v = parseFloat(form.querySelector('[name="' + k + '"]').value);
                        if (isNaN(v)) {
                            complet = false;
                            break;
                        }
                        total += v * poids[k];
                    }
                    var out = document.getElementById('scoreGlobal');
                    if (!complet) {
                        out.value = '—';
                        return;
                    }
                    var txt = total.toFixed(2) + ' / 5';
                    if (total >= 4.5) txt += ' · Excellent';
                    else if (total >= 3.5) txt += ' · Très bien';
                    else if (total >= 2.5) txt += ' · Satisfaisant';
                    else if (total >= 1.5) txt += ' · À améliorer';
                    else txt += ' · Insuffisant';
                    out.value = txt;
                }
                form.querySelectorAll('.note-critere').forEach(function(s) {
                    s.addEventListener('change', majScore);
                });
            });
            </script>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->