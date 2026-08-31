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

            <!-- ============ STYLE LOCAL (page rapports) ============ -->
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

            .rapport-card {
                border-left: 4px solid #1f7a5c;
                transition: transform .15s;
            }

            .rapport-card:hover {
                transform: translateY(-2px);
            }

            .rapport-icone {
                width: 46px;
                height: 46px;
                border-radius: 10px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                color: #fff;
                background: #1f7a5c;
            }
            </style>

            <!-- ============ CALCULS (toutes les tables RH) ============ -->
            <?php
            $annee_crt = date('Y');

            /* Employés actifs */
            $nb_actifs = 0;
            foreach ($employes as $e) if ($e->statut !== 'Fin de contrat') $nb_actifs++;

            /* Mouvements */
            $nb_mouv_annee = $nb_mouv_mois = 0;
            foreach ($mouvements as $m) {
                if (substr($m->date_effet, 0, 4) === $annee_crt) $nb_mouv_annee++;
                if (substr($m->date_effet, 0, 7) === date('Y-m')) $nb_mouv_mois++;
            }

            /* Contrats */
            $nb_contrats_actifs = $nb_expire_30 = 0;
            $auj    = date('Y-m-d');
            $plus30 = date('Y-m-d', strtotime('+30 days'));
            foreach ($contrats as $c) {
                if ($c->statut === 'Actif') $nb_contrats_actifs++;
                if (!empty($c->date_fin) && $c->date_fin >= $auj && $c->date_fin <= $plus30) $nb_expire_30++;
            }

            /* Congés & discipline */
            $nb_conges_attente = 0;
            foreach ($conges as $cg) if ($cg->statut === 'En attente') $nb_conges_attente++;
            $nb_dossiers_ouverts = 0;
            foreach ($dossiers as $d) if ($d->statut !== 'Clôturé') $nb_dossiers_ouverts++;

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

            /* Masse salariale brute (règles de la page Paie) */
            $masse_brute = 0;
            foreach ($employes as $e) {
                if ($e->statut === 'Fin de contrat') continue;
                $base = (float) $e->salaire_base;
                $masse_brute += $base + round($base * 0.10) + 50000;
            }

            /* Rapports */
            $nb_rapports = count($rapports);
            $dernier     = !empty($rapports) ? $rapports[0] : NULL;
            ?>

            <!-- ============ 1. INDICATEURS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-file-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Rapports générés (<?= $annee_crt ?>)</span>
                            <span class="info-box-number"><?= $nb_rapports ?></span>
                            <span class="progress-description">Journalisés dans l'historique</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-exchange-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Mouvements (<?= $annee_crt ?>)</span>
                            <span class="info-box-number"><?= $nb_mouv_annee ?></span>
                            <span class="progress-description">Dont <?= $nb_mouv_mois ?> ce mois-ci</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">En attente</span>
                            <span class="info-box-number"><?= $nb_conges_attente + $nb_dossiers_ouverts ?></span>
                            <span class="progress-description"><?= $nb_conges_attente ?> congé(s) ·
                                <?= $nb_dossiers_ouverts ?> dossier(s) discipline</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-history"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Dernière génération</span>
                            <span
                                class="info-box-number"><?= $dernier ? date('d/m', strtotime($dernier->cree_le)) : '—' ?></span>
                            <span
                                class="progress-description"><?= $dernier ? html_escape($dernier->type_rapport) : 'Aucun rapport' ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. CATALOGUE DES RAPPORTS ============ -->
            <h6 class="section-title mb-3"><i class="fas fa-folder-open mr-1"></i> Catalogue des rapports &amp; éditions
            </h6>
            <div class="row">

                <div class="col-lg-4 col-md-6">
                    <div class="card rapport-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="rapport-icone"><i class="fas fa-exchange-alt"></i></span>
                                <span class="badge badge-success">Mensuel · obligatoire</span>
                            </div>
                            <h5 class="font-weight-bold mb-1">Mouvements du personnel</h5>
                            <small class="text-muted">Entrées au service, départs (résiliation, fin de contrat,
                                licenciement, démission, retraite), transferts et promotions du mois.</small>
                            <small class="d-block text-success mb-2 mt-2"><i
                                    class="fas fa-database mr-1"></i><?= $nb_mouv_annee ?> mouvements en
                                <?= $annee_crt ?> · <?= $nb_mouv_mois ?> ce mois</small>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-sm btn-danger" title="PDF"><i
                                            class="fas fa-file-pdf"></i></button>
                                    <button class="btn btn-sm btn-success" title="Excel"><i
                                            class="fas fa-file-excel"></i></button>
                                </div>
                                <button class="btn btn-sm btn-default" data-toggle="modal"
                                    data-target="#modalRapport"><i class="fas fa-cog mr-1"></i>Générer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card rapport-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="rapport-icone" style="background:#34608c"><i
                                        class="fas fa-users"></i></span>
                                <span class="badge badge-info">Mensuel</span>
                            </div>
                            <h5 class="font-weight-bold mb-1">Effectifs &amp; démographie</h5>
                            <small class="text-muted">Effectif par site, département, catégorie et sexe ; répartition
                                par ancienneté et type de contrat.</small>
                            <small class="d-block text-success mb-2 mt-2"><i
                                    class="fas fa-database mr-1"></i><?= $nb_actifs ?> employés actifs ·
                                <?= count($employes) ?> inscrits</small>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-sm btn-danger" title="PDF"><i
                                            class="fas fa-file-pdf"></i></button>
                                    <button class="btn btn-sm btn-success" title="Excel"><i
                                            class="fas fa-file-excel"></i></button>
                                </div>
                                <button class="btn btn-sm btn-default" data-toggle="modal"
                                    data-target="#modalRapport"><i class="fas fa-cog mr-1"></i>Générer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card rapport-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="rapport-icone" style="background:#2c8a69"><i
                                        class="fas fa-money-bill-wave"></i></span>
                                <span class="badge badge-info">Mensuel</span>
                            </div>
                            <h5 class="font-weight-bold mb-1">Masse salariale &amp; paie</h5>
                            <small class="text-muted">Brut, net, retenues (INSS, IPR), charges patronales ; ventilation
                                par mode de paiement et par site.</small>
                            <small class="d-block text-success mb-2 mt-2"><i class="fas fa-database mr-1"></i>Masse
                                brute ≈ <?= number_format($masse_brute, 0, '', ' ') ?> BIF</small>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-sm btn-danger" title="PDF"><i
                                            class="fas fa-file-pdf"></i></button>
                                    <button class="btn btn-sm btn-success" title="Excel"><i
                                            class="fas fa-file-excel"></i></button>
                                </div>
                                <button class="btn btn-sm btn-default" data-toggle="modal"
                                    data-target="#modalRapport"><i class="fas fa-cog mr-1"></i>Générer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card rapport-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="rapport-icone" style="background:#b7791f"><i
                                        class="fas fa-umbrella-beach"></i></span>
                                <span class="badge badge-info">Mensuel</span>
                            </div>
                            <h5 class="font-weight-bold mb-1">Congés &amp; absences</h5>
                            <small class="text-muted">Congés pris et soldes, absences justifiées / non justifiées, taux
                                d'absentéisme par site.</small>
                            <small class="d-block text-success mb-2 mt-2"><i
                                    class="fas fa-database mr-1"></i><?= $nb_conges_attente ?> demande(s) en
                                attente</small>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-sm btn-danger" title="PDF"><i
                                            class="fas fa-file-pdf"></i></button>
                                    <button class="btn btn-sm btn-success" title="Excel"><i
                                            class="fas fa-file-excel"></i></button>
                                </div>
                                <button class="btn btn-sm btn-default" data-toggle="modal"
                                    data-target="#modalRapport"><i class="fas fa-cog mr-1"></i>Générer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card rapport-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="rapport-icone" style="background:#7a4f1f"><i
                                        class="fas fa-user-clock"></i></span>
                                <span class="badge badge-info">Mensuel</span>
                            </div>
                            <h5 class="font-weight-bold mb-1">Présences &amp; heures supplémentaires</h5>
                            <small class="text-muted">Retards, absences, heures supplémentaires par employé et par
                                chantier — base de la paie.</small>
                            <small class="d-block text-muted mb-2 mt-2"><i class="fas fa-database mr-1"></i>Source :
                                module Temps &amp; présences</small>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-sm btn-danger" title="PDF"><i
                                            class="fas fa-file-pdf"></i></button>
                                    <button class="btn btn-sm btn-success" title="Excel"><i
                                            class="fas fa-file-excel"></i></button>
                                </div>
                                <button class="btn btn-sm btn-default" data-toggle="modal"
                                    data-target="#modalRapport"><i class="fas fa-cog mr-1"></i>Générer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card rapport-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="rapport-icone" style="background:#8a3033"><i
                                        class="fas fa-file-contract"></i></span>
                                <span class="badge badge-warning">À la demande</span>
                            </div>
                            <h5 class="font-weight-bold mb-1">Contrats &amp; échéances</h5>
                            <small class="text-muted">CDD et périodes d'essai expirant sous 30 / 60 jours,
                                renouvellements à prévoir.</small>
                            <small class="d-block text-success mb-2 mt-2"><i
                                    class="fas fa-database mr-1"></i><?= $nb_contrats_actifs ?> actifs ·
                                <?= $nb_expire_30 ?> expirent sous 30 j</small>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-sm btn-danger" title="PDF"><i
                                            class="fas fa-file-pdf"></i></button>
                                    <button class="btn btn-sm btn-success" title="Excel"><i
                                            class="fas fa-file-excel"></i></button>
                                </div>
                                <button class="btn btn-sm btn-default" data-toggle="modal"
                                    data-target="#modalRapport"><i class="fas fa-cog mr-1"></i>Générer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card rapport-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="rapport-icone" style="background:#6c757d"><i
                                        class="fas fa-gavel"></i></span>
                                <span class="badge badge-secondary">Trimestriel</span>
                            </div>
                            <h5 class="font-weight-bold mb-1">Discipline &amp; sanctions</h5>
                            <small class="text-muted">Dossiers ouverts / clôturés, sanctions prononcées, récidives sur
                                12 mois.</small>
                            <small class="d-block text-success mb-2 mt-2"><i
                                    class="fas fa-database mr-1"></i><?= $nb_dossiers_ouverts ?> dossier(s)
                                ouvert(s)</small>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-sm btn-danger" title="PDF"><i
                                            class="fas fa-file-pdf"></i></button>
                                </div>
                                <button class="btn btn-sm btn-default" data-toggle="modal"
                                    data-target="#modalRapport"><i class="fas fa-cog mr-1"></i>Générer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card rapport-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="rapport-icone" style="background:#34608c"><i
                                        class="fas fa-clipboard-check"></i></span>
                                <span class="badge badge-secondary">Par campagne</span>
                            </div>
                            <h5 class="font-weight-bold mb-1">Évaluations des performances</h5>
                            <small class="text-muted">Scores moyens, appréciations, décisions issues (formations,
                                primes, promotions).</small>
                            <small class="d-block text-success mb-2 mt-2"><i
                                    class="fas fa-database mr-1"></i><?= $nb_evals ?> validée(s) · moyenne
                                <?= number_format($note_moy, 2, ',', ' ') ?>/5</small>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-sm btn-danger" title="PDF"><i
                                            class="fas fa-file-pdf"></i></button>
                                    <button class="btn btn-sm btn-success" title="Excel"><i
                                            class="fas fa-file-excel"></i></button>
                                </div>
                                <button class="btn btn-sm btn-default" data-toggle="modal"
                                    data-target="#modalRapport"><i class="fas fa-cog mr-1"></i>Générer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card rapport-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="rapport-icone"><i class="fas fa-book"></i></span>
                                <span class="badge badge-warning">À la demande · légal</span>
                            </div>
                            <h5 class="font-weight-bold mb-1">Registre d'employeur</h5>
                            <small class="text-muted">Édition complète du registre du personnel avec bloc de signatures
                                (Inspection du Travail / OBEM).</small>
                            <small class="d-block text-success mb-2 mt-2"><i
                                    class="fas fa-database mr-1"></i><?= count($employes) ?> inscrits au
                                registre</small>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-sm btn-default" title="Imprimer" onclick="window.print()"><i
                                            class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-danger" title="PDF"><i
                                            class="fas fa-file-pdf"></i></button>
                                </div>
                                <a class="btn btn-sm btn-default" href="<?= base_url('rh-registre') ?>"><i
                                        class="fas fa-external-link-alt mr-1"></i>Ouvrir</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ============ 3. HISTORIQUE DES GÉNÉRATIONS ============ -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title mb-0"><i class="fas fa-history mr-1 text-success"></i> Historique des
                        générations</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>Généré le</th>
                                <th>Rapport</th>
                                <th>Période</th>
                                <th>Format</th>
                                <th>Par</th>
                                <th class="text-right">Télécharger</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rapports)): foreach ($rapports as $r):
                                    if (stripos($r->type_rapport, 'Mouvements') === 0)      $ic = 'fa-exchange-alt';
                                    elseif (stripos($r->type_rapport, 'Masse') === 0)       $ic = 'fa-money-bill-wave';
                                    elseif (stripos($r->type_rapport, 'Effectifs') === 0)   $ic = 'fa-users';
                                    elseif (
                                        stripos($r->type_rapport, 'INSS') !== false
                                        || stripos($r->type_rapport, 'IPR') !== false
                                    )     $ic = 'fa-landmark';
                                    elseif (stripos($r->type_rapport, 'Évaluations') === 0) $ic = 'fa-clipboard-check';
                                    elseif (stripos($r->type_rapport, 'Registre') === 0)    $ic = 'fa-book';
                                    elseif (stripos($r->type_rapport, 'Congés') === 0)      $ic = 'fa-umbrella-beach';
                                    elseif (stripos($r->type_rapport, 'Discipline') === 0)  $ic = 'fa-gavel';
                                    elseif (stripos($r->type_rapport, 'Contrats') === 0)    $ic = 'fa-file-contract';
                                    else                                                    $ic = 'fa-file-alt';
                            ?>
                            <tr>
                                <td><strong><?= date('d/m/Y', strtotime($r->cree_le)) ?></strong></td>
                                <td><i class="fas <?= $ic ?> mr-1 text-success"></i><?= html_escape($r->type_rapport) ?>
                                </td>
                                <td><?= html_escape($r->periode) ?></td>
                                <td>
                                    <?php foreach (explode('+', $r->format) as $f): $f = trim($f); ?>
                                    <?php if (stripos($f, 'excel') !== false): ?>
                                    <span class="badge badge-success">Excel</span>
                                    <?php else: ?>
                                    <span class="badge badge-danger">PDF</span>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </td>
                                <td><small><?= html_escape($r->genere_par) ?></small></td>
                                <td class="text-right"><button class="btn btn-sm btn-default"><i
                                            class="fas fa-download"></i></button></td>
                            </tr>
                            <?php endforeach;
                            else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4"><i
                                        class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucun rapport généré.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <small class="text-muted float-left mt-2">
                        <?= $nb_rapports ?> rapport(s) journalisé(s) · conservation 5 ans (obligation légale)
                    </small>
                </div>
            </div>

            <!-- ============ MODALE : GÉNÉRER UN RAPPORT ============ -->
            <div class="modal fade" id="modalRapport">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h4 class="modal-title"><i class="fas fa-cogs mr-2"></i>Générer un rapport</h4>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"><label>Type de rapport *</label>
                                        <select class="form-control">
                                            <option>Mouvements du personnel (mensuel)</option>
                                            <option>Effectifs &amp; démographie</option>
                                            <option>Masse salariale &amp; paie</option>
                                            <option>Congés &amp; absences</option>
                                            <option>Présences &amp; heures supplémentaires</option>
                                            <option>Contrats &amp; échéances</option>
                                            <option>Discipline &amp; sanctions</option>
                                            <option>Évaluations des performances</option>
                                            <option>Registre d'employeur</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Période *</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <select class="form-control">
                                                    <option>Août</option>
                                                    <option>Juillet</option>
                                                    <option>Juin</option>
                                                    <option>Mai</option>
                                                    <option>Avril</option>
                                                    <option>Mars</option>
                                                    <option>Février</option>
                                                    <option>Janvier</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control">
                                                    <option>2026</option>
                                                    <option>2025</option>
                                                    <option>2024</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Périmètre</label>
                                        <select class="form-control">
                                            <option>Tous les sites</option>
                                            <option>Siège (Bujumbura)</option>
                                            <option>Chantier Ngagara II</option>
                                            <option>Chantier Gitega</option>
                                            <option>Chantier Ngozi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Format de sortie *</label>
                                        <select class="form-control">
                                            <option>PDF (impression / archivage)</option>
                                            <option>Excel (analyse)</option>
                                            <option>Les deux</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group"><label>Commentaire (optionnel)</label>
                                        <textarea class="form-control" rows="2"
                                            placeholder="Destinataire, objet particulier…"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-success"><i class="fas fa-play mr-1"></i> Générer le
                                rapport</button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->