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

            .scale-step {
                border-left: 4px solid #1f7a5c;
                background: #f8faf9;
            }
            </style>

            <!-- ============ CALCULS ============ -->
            <?php
            $couleurs   = ['#1f7a5c', '#2c8a69', '#34608c', '#7a4f1f', '#8a3033', '#6c757d'];
            $annee_crt  = date('Y');
            $limite_12m = date('Y-m-d', strtotime('-12 months'));

            $nb_actifs = $nb_ouverts = $nb_audiences = $nb_sanctions = $nb_clotures = 0;
            $detail      = ['Avertissement' => 0, 'Blâme' => 0, 'Suspension' => 0, 'Licenciement' => 0];
            $par_employe = [];

            foreach ($dossiers as $d) {
                if ($d->statut === 'Ouvert') {
                    $nb_ouverts++;
                    $nb_actifs++;
                } elseif ($d->statut === 'Audience planifiée') {
                    $nb_audiences++;
                    $nb_actifs++;
                } else {
                    $nb_clotures++;
                }

                if ($d->statut === 'Clôturé' && !empty($d->sanction_finale) && substr($d->date_fait, 0, 4) === $annee_crt) {
                    $nb_sanctions++;
                    foreach ($detail as $cle => $v) {
                        if (stripos($d->sanction_finale, $cle) === 0) {
                            $detail[$cle]++;
                            break;
                        }
                    }
                }

                if ($d->date_fait >= $limite_12m) {
                    if (!isset($par_employe[$d->employe_id])) {
                        $par_employe[$d->employe_id] = ['nb' => 0, 'nom' => mb_substr($d->prenoms, 0, 1) . '. ' . mb_strtoupper($d->nom)];
                    }
                    $par_employe[$d->employe_id]['nb']++;
                }
            }

            $recidives = [];
            foreach ($par_employe as $c) {
                if ($c['nb'] > 1) $recidives[] = $c;
            }
            $nb_recidives = count($recidives);

            $parts = [];
            if ($detail['Avertissement']) $parts[] = $detail['Avertissement'] . ' avertissement' . ($detail['Avertissement'] > 1 ? 's' : '');
            if ($detail['Blâme'])         $parts[] = $detail['Blâme'] . ' blâme' . ($detail['Blâme'] > 1 ? 's' : '');
            if ($detail['Suspension'])    $parts[] = $detail['Suspension'] . ' suspension' . ($detail['Suspension'] > 1 ? 's' : '');
            if ($detail['Licenciement'])  $parts[] = $detail['Licenciement'] . ' licenciement' . ($detail['Licenciement'] > 1 ? 's' : '');
            $resume_sanctions = !empty($parts) ? implode(' · ', $parts) : 'Aucune sanction clôturée';
            $premier_rec      = !empty($recidives) ? $recidives[0]['nom'] . ' — ' . $recidives[0]['nb'] . ' dossiers' : 'Aucune';
            ?>

            <!-- ============ 1. INDICATEURS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-folder-open"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Dossiers en cours</span>
                            <span class="info-box-number"><?= $nb_actifs ?></span>
                            <span class="progress-description"><?= $nb_ouverts ?> ouvert(s) · <?= $nb_audiences ?>
                                audience(s)</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-gavel"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sanctions prononcées (<?= $annee_crt ?>)</span>
                            <span class="info-box-number"><?= $nb_sanctions ?></span>
                            <span class="progress-description"><?= $resume_sanctions ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-user-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Audiences à tenir</span>
                            <span class="info-box-number"><?= $nb_audiences ?></span>
                            <span class="progress-description">Dossiers en attente d'audition</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-redo"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Récidives (12 mois)</span>
                            <span class="info-box-number"><?= $nb_recidives ?></span>
                            <span class="progress-description"><?= $premier_rec ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. ONGLETS ============ -->
            <div class="card">
                <div class="card-header p-2 px-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tabDossiers"><i
                                        class="fas fa-folder-open mr-1"></i> Dossiers &amp; sanctions <span
                                        class="badge badge-warning ml-1"><?= $nb_actifs ?></span></a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabEchelle"><i
                                        class="fas fa-layer-group mr-1"></i> Échelle des sanctions</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabProcedure"><i
                                        class="fas fa-list-ol mr-1"></i> Procédure disciplinaire</a></li>
                        </ul>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDossier">
                            <i class="fas fa-plus mr-1"></i> Ouvrir un dossier
                        </button>
                    </div>
                </div>

                <div class="tab-content">

                    <!-- ===== ONGLET : DOSSIERS & SANCTIONS ===== -->
                    <div class="tab-pane fade active show" id="tabDossiers">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Réf.</th>
                                        <th>Employé</th>
                                        <th>Fait reproché</th>
                                        <th>Date du fait</th>
                                        <th>Statut du dossier</th>
                                        <th>Sanction</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($dossiers)): foreach ($dossiers as $d):
                                            $initiales = strtoupper(mb_substr($d->prenoms, 0, 1) . mb_substr($d->nom, 0, 1));
                                            $couleur   = $couleurs[$d->employe_id % count($couleurs)];
                                            $row_class = $d->statut === 'Ouvert' ? 'table-warning' : ($d->statut === 'Audience planifiée' ? 'table-info' : '');
                                            $fct       = isset($d->fonction) ? $d->fonction : '';

                                            if ($d->statut === 'Ouvert')                 $badge_statut = '<span class="badge badge-warning">Ouvert</span>';
                                            elseif ($d->statut === 'Audience planifiée') $badge_statut = '<span class="badge badge-info">Audience planifiée</span>';
                                            else                                         $badge_statut = '<span class="badge badge-success">Clôturé</span>';

                                            if ($d->statut === 'Clôturé' && !empty($d->sanction_finale)) {
                                                $sf = $d->sanction_finale;
                                                if (stripos($sf, 'Licenciement') === 0)      $c = 'dark';
                                                elseif (stripos($sf, 'Suspension') === 0)    $c = 'danger';
                                                elseif (stripos($sf, 'Avertissement') === 0) $c = 'warning';
                                                elseif (stripos($sf, 'Blâme') === 0)         $c = 'info';
                                                else                                         $c = 'secondary';
                                                $sanction_html = '<span class="badge badge-' . $c . '">' . html_escape($sf) . '</span>';
                                            } else {
                                                $sanction_html = '<small class="text-muted">— en instruction —</small>';
                                            }
                                    ?>
                                    <tr class="<?= $row_class ?>">
                                        <td><strong><?= html_escape($d->reference) ?></strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar-initials mr-2"
                                                    style="background:<?= $couleur ?>"><?= $initiales ?></span>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        <?= html_escape($d->prenoms . ' ' . mb_strtoupper($d->nom)) ?>
                                                    </div>
                                                    <small
                                                        class="text-muted"><?= html_escape($d->matricule . ($fct !== '' ? ' · ' . $fct : '')) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= html_escape($d->type_faute) ?>
                                            <small class="d-block text-muted"
                                                style="max-width:420px;white-space:normal"><?= html_escape($d->description) ?></small>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($d->date_fait)) ?></td>
                                        <td><?= $badge_statut ?></td>
                                        <td><?= $sanction_html ?></td>
                                        <td class="text-right">
                                            <?php if ($d->statut === 'Ouvert'): ?>
                                            <button class="btn btn-sm btn-info" title="Planifier l'audience"><i
                                                    class="fas fa-user-clock"></i></button>
                                            <?php elseif ($d->statut === 'Audience planifiée'): ?>
                                            <button class="btn btn-sm btn-success" title="Tenir l'audience / décider"><i
                                                    class="fas fa-gavel"></i></button>
                                            <?php endif; ?>
                                            <button class="btn btn-sm btn-default" title="Consulter"><i
                                                    class="fas fa-eye"></i></button>
                                            <?php if (!empty($d->pieces)): ?>
                                            <a class="btn btn-sm btn-default" title="Pièce jointe"
                                                href="<?= base_url($d->pieces) ?>" target="_blank"><i
                                                    class="fas fa-file-pdf text-danger"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach;
                                    else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4"><i
                                                class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucun dossier disciplinaire.
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <small class="text-muted float-left mt-2">
                                <?= count($dossiers) ?> dossier(s) · <?= $nb_clotures ?> clôturé(s) · chaque sanction
                                est versée au dossier du personnel
                            </small>
                        </div>
                    </div>

                    <!-- ===== ONGLET : ÉCHELLE DES SANCTIONS ===== -->
                    <div class="tab-pane fade" id="tabEchelle">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h6 class="section-title mb-3"><i class="fas fa-layer-group mr-1"></i> Sanctions
                                        graduées (règlement d'entreprise &amp; Code du travail)</h6>
                                    <div class="scale-step p-3 mb-2"><strong>1. Blâme verbal</strong><small
                                            class="d-block text-muted">Manquement léger et isolé — rappel à l'ordre par
                                            le supérieur hiérarchique.</small></div>
                                    <div class="scale-step p-3 mb-2"><strong>2. Avertissement écrit</strong><small
                                            class="d-block text-muted">Manquement répété ou plus sérieux — notifié par
                                            écrit et versé au dossier.</small></div>
                                    <div class="scale-step p-3 mb-2"><strong>3. Blâme écrit</strong><small
                                            class="d-block text-muted">Faute avérée après audition — dernière étape
                                            avant suspension.</small></div>
                                    <div class="scale-step p-3 mb-2"><strong>4. Suspension (1 à 8 jours, non
                                            rémunérée)</strong><small class="d-block text-muted">Faute grave ou récidive
                                            — proportionnée au manquement.</small></div>
                                    <div class="scale-step p-3 mb-2" style="border-left-color:#dc3545"><strong>5.
                                            Licenciement pour faute grave</strong><small class="d-block text-muted">Vol,
                                            violence, insubordination, mise en danger… — procédure légale
                                            stricte.</small></div>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="section-title mb-3"><i class="fas fa-balance-scale mr-1"></i> Fautes
                                        courantes &amp; barème indicatif</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Faute</th>
                                                    <th>1ʳᵉ fois</th>
                                                    <th>Récidive (12 mois)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Retard non justifié</td>
                                                    <td>Blâme verbal</td>
                                                    <td>Avertissement écrit</td>
                                                </tr>
                                                <tr>
                                                    <td>Absence non justifiée ≤ 1 j</td>
                                                    <td>Avertissement écrit</td>
                                                    <td>Suspension 1–3 j</td>
                                                </tr>
                                                <tr>
                                                    <td>Absence non justifiée &gt; 1 j</td>
                                                    <td>Suspension 2–5 j</td>
                                                    <td>Suspension 6–8 j / licenciement</td>
                                                </tr>
                                                <tr>
                                                    <td>Non-respect des consignes de sécurité (EPI)</td>
                                                    <td>Suspension 3–5 j</td>
                                                    <td>Licenciement</td>
                                                </tr>
                                                <tr>
                                                    <td>Insubordination</td>
                                                    <td>Blâme écrit</td>
                                                    <td>Suspension / licenciement</td>
                                                </tr>
                                                <tr>
                                                    <td>Vol, destruction volontaire</td>
                                                    <td colspan="2"><span class="badge badge-danger">Licenciement pour
                                                            faute grave</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="alert alert-warning py-2 mt-3 mb-0">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <small>Toute sanction doit être <strong>proportionnée</strong>, <strong>notifiée
                                                par écrit</strong> et précédée du <strong>droit d'être entendu</strong>
                                            (art. pertinents du Code du travail).</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== ONGLET : PROCÉDURE ===== -->
                    <div class="tab-pane fade" id="tabProcedure">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-2 col-6 mb-3"><span class="avatar-initials mx-auto mb-2"
                                        style="width:46px;height:46px;font-size:1.1rem;background:#1f7a5c">1</span>
                                    <div class="font-weight-bold" style="font-size:.85rem">Signalement</div><small
                                        class="text-muted">Rapport du supérieur / pointage / plainte</small>
                                </div>
                                <div class="col-md-2 col-6 mb-3"><span class="avatar-initials mx-auto mb-2"
                                        style="width:46px;height:46px;font-size:1.1rem;background:#1f7a5c">2</span>
                                    <div class="font-weight-bold" style="font-size:.85rem">Ouverture du dossier</div>
                                    <small class="text-muted">Par le service RH (réf. DIS-AAAA-NNN)</small>
                                </div>
                                <div class="col-md-2 col-6 mb-3"><span class="avatar-initials mx-auto mb-2"
                                        style="width:46px;height:46px;font-size:1.1rem;background:#1f7a5c">3</span>
                                    <div class="font-weight-bold" style="font-size:.85rem">Audition de l'employé</div>
                                    <small class="text-muted">Droit d'être entendu + moyens de défense</small>
                                </div>
                                <div class="col-md-2 col-6 mb-3"><span class="avatar-initials mx-auto mb-2"
                                        style="width:46px;height:46px;font-size:1.1rem;background:#1f7a5c">4</span>
                                    <div class="font-weight-bold" style="font-size:.85rem">Décision motivée</div><small
                                        class="text-muted">Sanction proportionnée ou classement</small>
                                </div>
                                <div class="col-md-2 col-6 mb-3"><span class="avatar-initials mx-auto mb-2"
                                        style="width:46px;height:46px;font-size:1.1rem;background:#1f7a5c">5</span>
                                    <div class="font-weight-bold" style="font-size:.85rem">Notification</div><small
                                        class="text-muted">Remise contre décharge / courrier</small>
                                </div>
                                <div class="col-md-2 col-6 mb-3"><span class="avatar-initials mx-auto mb-2"
                                        style="width:46px;height:46px;font-size:1.1rem;background:#1f7a5c">6</span>
                                    <div class="font-weight-bold" style="font-size:.85rem">Classement au dossier</div>
                                    <small class="text-muted">Versé au dossier du personnel (RH)</small>
                                </div>
                            </div>
                            <div class="alert alert-info py-2 mb-0">
                                <i class="fas fa-info-circle mr-1"></i>
                                <small>Délai indicatif : l'audition intervient dans les <strong>7 jours</strong> suivant
                                    l'ouverture du dossier ; la décision dans les <strong>48 h</strong> après
                                    l'audition.</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============ MODALE : OUVRIR UN DOSSIER ============ -->
            <div class="modal fade" id="modalDossier">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="formDossier" method="post" action="<?= base_url('rh-discipline-store') ?>"
                            enctype="multipart/form-data">
                            <div class="modal-header bg-success text-white">
                                <h4 class="modal-title"><i class="fas fa-gavel mr-2"></i>Ouvrir un dossier disciplinaire
                                </h4>
                                <button type="button" class="close text-white"
                                    data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Référence du dossier</label>
                                            <input type="text" class="form-control"
                                                value="<?= html_escape($next_ref_dossier) ?> (auto)" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Employé concerné *</label>
                                            <select name="employe_id" class="form-control" required>
                                                <option value="">— Sélectionner —</option>
                                                <?php foreach ($employes as $e): ?>
                                                <option value="<?= $e->employe_id ?>">
                                                    <?= html_escape($e->matricule . ' · ' . $e->prenoms . ' ' . mb_strtoupper($e->nom)) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Type de faute *</label>
                                            <select name="type_faute" class="form-control" required>
                                                <option>Retard non justifié</option>
                                                <option>Absence non justifiée</option>
                                                <option>Non-respect des consignes de sécurité</option>
                                                <option>Insubordination</option>
                                                <option>Vol / destruction volontaire</option>
                                                <option>Autre (préciser en description)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Date du fait *</label>
                                            <input type="date" name="date_fait" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Lieu / site</label>
                                            <select name="lieu" class="form-control">
                                                <option>Siège (Bujumbura)</option>
                                                <option>Chantier Ngagara II</option>
                                                <option>Chantier Gitega</option>
                                                <option>Chantier Ngozi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Signalé par</label>
                                            <input type="text" name="signale_par" class="form-control"
                                                placeholder="Ex. : chef de chantier">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Pièces jointes (rapport, photos…)</label>
                                            <div class="custom-file">
                                                <input type="file" name="pieces" class="custom-file-input"
                                                    id="filePieces">
                                                <label class="custom-file-label" for="filePieces">Choisir…</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Sanction proposée (indicatif)</label>
                                            <select name="sanction_proposee" class="form-control">
                                                <option value="">— À décider après audition —</option>
                                                <option>Blâme verbal</option>
                                                <option>Avertissement écrit</option>
                                                <option>Blâme écrit</option>
                                                <option>Suspension</option>
                                                <option>Licenciement pour faute grave</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group"><label>Description des faits *</label>
                                            <textarea name="description" class="form-control" rows="3" required
                                                placeholder="Décrire précisément les faits (date, heure, circonstances, témoins éventuels)…"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-folder-plus mr-1"></i>
                                    Ouvrir le dossier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.custom-file-input').forEach(function(input) {
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