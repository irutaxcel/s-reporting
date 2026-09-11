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

            <!-- ============ MESSAGES FLASHDATA (SweetAlert2) ============ -->
            <?php if ($msg = $this->session->flashdata('success')): ?>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Enregistrement réussi',
                        text: '<?= addslashes($msg) ?>',
                        confirmButtonColor: '#1f7a5c',
                        confirmButtonText: 'Parfait !',
                        timer: 4000,
                        timerProgressBar: true
                    });
                }
            });
            </script>
            <?php endif; ?>
            <?php if ($msg = $this->session->flashdata('error')): ?>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                rhNotify('error', '<?= addslashes($msg) ?>');
            });
            </script>
            <?php endif; ?>

            <!-- ============ STYLE LOCAL (page contrats) ============ -->
            <style>
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

            .table td {
                vertical-align: middle;
            }

            .section-title {
                color: #1f7a5c;
                font-weight: 700;
                border-bottom: 2px solid #e9ecef;
                padding-bottom: .4rem;
            }
            </style>

            <!-- ============ CALCULS (contrats, alertes, essais, mouvements) ============ -->
            <?php
            $aujourd_hui = new DateTime();
            $plus_30    = (new DateTime())->modify('+30 days');
            $mois_crt   = $aujourd_hui->format('Y-m');

            $couleurs   = ['#1f7a5c', '#2c8a69', '#34608c', '#7a4f1f', '#8a3033', '#6c757d'];
            $badge_type = ['CDI' => 'success', 'CDD' => 'warning', 'Stage' => 'info'];
            $badge_mouv = [
                'Entrée' => 'success',
                'Démission' => 'warning',
                'Licenciement' => 'danger',
                'Fin de contrat' => 'secondary',
                'Retraite' => 'info',
                'Transfert' => 'primary',
                'Promotion' => 'info'
            ];

            $nb_actifs = $nb_cdi = $nb_cdd = $nb_stage = $nb_expire_30 = $nb_essai = 0;
            $alertes = [];
            $essais = [];

            foreach ($contrats as $c) {
                $fin        = !empty($c->date_fin) ? new DateTime($c->date_fin) : NULL;
                $c->_expire = ($fin && $fin < $aujourd_hui) || $c->statut === 'Expiré';
                $c->_expire_bientot = FALSE;

                if ($fin && !$c->_expire && $fin <= $plus_30) {
                    $c->_expire_bientot = TRUE;
                    $c->_jours = (int) $aujourd_hui->diff($fin)->days;
                    $nb_expire_30++;
                    $alertes[] = $c;
                }
                if (!$c->_expire && $c->statut === 'Actif') {
                    $nb_actifs++;
                    if ($c->type_contrat === 'CDI') $nb_cdi++;
                    elseif ($c->type_contrat === 'CDD') $nb_cdd++;
                    else $nb_stage++;
                }
                if (!empty($c->periode_essai) && $c->periode_essai !== 'Aucune') {
                    $fin_essai = (new DateTime($c->date_debut))->modify('+' . (int) $c->periode_essai . ' months');
                    if ($fin_essai > $aujourd_hui && !$c->_expire) {
                        $c->_fin_essai = $fin_essai;
                        $nb_essai++;
                        $essais[] = $c;
                    }
                }
            }

            $entrees_mois = $sorties_mois = $internes_mois = 0;
            foreach ($mouvements as $m) {
                if (substr($m->date_effet, 0, 7) === $mois_crt) {
                    if ($m->type_mouvement === 'Entrée') $entrees_mois++;
                    elseif (in_array($m->type_mouvement, ['Démission', 'Licenciement', 'Fin de contrat', 'Retraite'])) $sorties_mois++;
                    else $internes_mois++;
                }
            }
            ?>

            <!-- ============ 1. INDICATEURS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-file-contract"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Contrats actifs</span>
                            <span class="info-box-number"><?= $nb_actifs ?></span>
                            <span class="progress-description"><?= $nb_cdi ?> CDI · <?= $nb_cdd ?> CDD ·
                                <?= $nb_stage ?> stage(s)</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Expirent sous 30 jours</span>
                            <span class="info-box-number"><?= $nb_expire_30 ?></span>
                            <span class="progress-description">À renouveler ou clôturer</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Périodes d'essai en cours</span>
                            <span class="info-box-number"><?= $nb_essai ?></span>
                            <span class="progress-description">À suivre avant confirmation</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-exchange-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Mouvements (<?= $aujourd_hui->format('m/Y') ?>)</span>
                            <span class="info-box-number">+<?= $entrees_mois ?> / −<?= $sorties_mois ?></span>
                            <span class="progress-description"><?= $entrees_mois ?> entrée(s) · <?= $sorties_mois ?>
                                sortie(s) · <?= $internes_mois ?> interne(s)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. ONGLETS ============ -->
            <div class="card">
                <div class="card-header p-2 px-3">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tabContrats"><i
                                    class="fas fa-file-contract mr-1"></i> Contrats</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabMouvements"><i
                                    class="fas fa-exchange-alt mr-1"></i> Mouvements</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabAlertes"><i
                                    class="fas fa-bell mr-1"></i> Alertes &amp; échéances <span
                                    class="badge badge-warning ml-1"><?= count($alertes) ?></span></a></li>
                    </ul>
                </div>

                <div class="tab-content">

                    <!-- ==================== ONGLET : CONTRATS ==================== -->
                    <div class="tab-pane fade active show" id="tabContrats">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap p-3 pb-0">
                                <div class="col-md-4 p-0">
                                    <div class="input-group">
                                        <input type="search" id="searchContrats" class="form-control"
                                            placeholder="Rechercher (employé, matricule, fonction…)">
                                        <div class="input-group-append"><span class="input-group-text"><i
                                                    class="fas fa-search"></i></span></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="btn-group mr-2">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown"><i class="fas fa-download mr-1"></i>
                                            Exporter</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-file-excel mr-2 text-success"></i>Excel</a>
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-file-pdf mr-2 text-danger"></i>PDF</a>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#modalNouveauContrat">
                                        <i class="fas fa-file-signature mr-1"></i> Nouveau contrat / renouvellement
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive p-0">
                                <table class="table table-hover table-striped text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Employé</th>
                                            <th>Type</th>
                                            <th>Fonction</th>
                                            <th>Affectation</th>
                                            <th>Période</th>
                                            <th>Période d'essai</th>
                                            <th>Statut</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($contrats)): foreach ($contrats as $c):
                                                $initiales = strtoupper(mb_substr($c->prenoms, 0, 1) . mb_substr($c->nom, 0, 1));
                                                $couleur   = $couleurs[$c->employe_id % count($couleurs)];
                                                $icone     = (stripos($c->site_affectation, 'chantier') !== FALSE) ? 'fa-hard-hat' : 'fa-building';

                                                if ($c->_expire)                     $badge_stat = '<span class="badge badge-secondary">Expiré</span>';
                                                elseif ($c->statut === 'Renouvelé')  $badge_stat = '<span class="badge badge-info">Renouvelé</span>';
                                                elseif ($c->_expire_bientot)         $badge_stat = '<span class="badge badge-warning">Expire J-' . $c->_jours . '</span>';
                                                else                                 $badge_stat = '<span class="badge badge-success">Actif</span>';

                                                if (isset($c->_fin_essai))               $essai_html = '<span class="badge badge-info">' . $c->periode_essai . ' (en cours)</span>';
                                                elseif ($c->periode_essai !== 'Aucune')  $essai_html = '<small class="text-muted">Validée</small>';
                                                else                                     $essai_html = '<small class="text-muted">Aucune</small>';
                                        ?>
                                        <tr class="<?= $c->_expire_bientot ? 'table-warning' : '' ?>">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar-initials mr-2"
                                                        style="background:<?= $couleur ?>"><?= $initiales ?></span>
                                                    <div>
                                                        <div class="font-weight-bold">
                                                            <?= html_escape($c->prenoms . ' ' . mb_strtoupper($c->nom)) ?>
                                                        </div>
                                                        <small
                                                            class="text-muted"><?= html_escape($c->matricule) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span
                                                    class="badge badge-<?= $badge_type[$c->type_contrat] ?? 'secondary' ?>"><?= $c->type_contrat ?></span>
                                            </td>
                                            <td><?= html_escape($c->fonction) ?></td>
                                            <td><i
                                                    class="fas <?= $icone ?> mr-1 text-muted"></i><?= html_escape($c->site_affectation) ?>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($c->date_debut)) ?>
                                                <small
                                                    class="text-muted d-block"><?= $c->date_fin ? '→ ' . date('d/m/Y', strtotime($c->date_fin)) : '→ sans échéance' ?></small>
                                            </td>
                                            <td><?= $essai_html ?></td>
                                            <td><?= $badge_stat ?></td>
                                            <td class="text-right">
                                                <?php if ($c->_expire_bientot): ?>
                                                <button class="btn btn-sm btn-success" title="Renouveler"><i
                                                        class="fas fa-redo"></i></button>
                                                <?php elseif (!$c->_expire): ?>
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-default" title="Avenant"><i
                                                        class="fas fa-edit"></i></button>
                                                <?php else: ?>
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach;
                                        else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4"><i
                                                    class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucun contrat
                                                enregistré.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <small class="text-muted float-left mt-2">Affichage de <?= count($contrats) ?>
                                    contrat(s)</small>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== ONGLET : MOUVEMENTS ==================== -->
                    <div class="tab-pane fade" id="tabMouvements">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap p-3 pb-0">
                                <div>
                                    <span class="badge badge-success p-2 mr-1"><i class="fas fa-sign-in-alt mr-1"></i>
                                        Entrées (30 j) : <?= $entrees_mois ?></span>
                                    <span class="badge badge-secondary p-2 mr-1"><i
                                            class="fas fa-sign-out-alt mr-1"></i> Sorties (30 j) :
                                        <?= $sorties_mois ?></span>
                                    <span class="badge badge-info p-2"><i class="fas fa-random mr-1"></i> Internes (30
                                        j) : <?= $internes_mois ?></span>
                                </div>
                                <div>
                                    <div class="btn-group mr-2">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown"><i class="fas fa-download mr-1"></i> Rapport
                                            mensuel</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-file-excel mr-2 text-success"></i>Excel</a>
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-file-pdf mr-2 text-danger"></i>PDF</a>
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-print mr-2 text-secondary"></i>Imprimer</a>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#modalMouvement">
                                        <i class="fas fa-plus mr-1"></i> Enregistrer un mouvement
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive p-0">
                                <table class="table table-hover table-striped text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Date effet</th>
                                            <th>Employé</th>
                                            <th>Type de mouvement</th>
                                            <th>Détail</th>
                                            <th>Affectation</th>
                                            <th>Encodé par</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($mouvements)): foreach ($mouvements as $m):
                                                $lieu  = !empty($m->nouvelle_affectation) ? $m->nouvelle_affectation : (isset($m->site_affectation) ? $m->site_affectation : '—');
                                                $icone = (stripos($lieu, 'chantier') !== FALSE) ? 'fa-hard-hat' : 'fa-building';
                                        ?>
                                        <tr>
                                            <td><strong><?= date('d/m/Y', strtotime($m->date_effet)) ?></strong></td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    <?= html_escape($m->prenoms . ' ' . mb_strtoupper($m->nom)) ?></div>
                                                <small class="text-muted"><?= html_escape($m->matricule) ?></small>
                                            </td>
                                            <td><span
                                                    class="badge badge-<?= $badge_mouv[$m->type_mouvement] ?? 'secondary' ?>"><?= $m->type_mouvement ?></span>
                                            </td>
                                            <td><?= html_escape($m->motif ?: '—') ?></td>
                                            <td><i
                                                    class="fas <?= $icone ?> mr-1 text-muted"></i><?= html_escape($lieu) ?>
                                            </td>
                                            <td><small><?= html_escape($m->encode_par ?: '—') ?></small></td>
                                        </tr>
                                        <?php endforeach;
                                        else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4"><i
                                                    class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucun mouvement
                                                enregistré.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== ONGLET : ALERTES & ÉCHÉANCES ==================== -->
                    <div class="tab-pane fade" id="tabAlertes">
                        <div class="card-body">
                            <h6 class="section-title mb-3"><i class="fas fa-file-contract mr-1"></i> Contrats à traiter
                                sous 30 jours</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Employé</th>
                                            <th>Type</th>
                                            <th>Fin de contrat</th>
                                            <th>Échéance</th>
                                            <th>Action suggérée</th>
                                            <th class="text-right">Traiter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($alertes)): foreach ($alertes as $c): ?>
                                        <tr>
                                            <td><?= html_escape($c->prenoms . ' ' . mb_strtoupper($c->nom)) ?> <small
                                                    class="text-muted">(<?= $c->matricule ?>)</small></td>
                                            <td><span
                                                    class="badge badge-<?= $badge_type[$c->type_contrat] ?? 'secondary' ?>"><?= $c->type_contrat ?></span>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($c->date_fin)) ?></td>
                                            <td><span
                                                    class="badge badge-<?= $c->_jours <= 10 ? 'danger' : 'warning' ?>">J-<?= $c->_jours ?></span>
                                            </td>
                                            <td><?= $c->type_contrat === 'Stage' ? 'Fin de stage → évaluation + éventuelle embauche' : 'Renouvellement ou clôture' ?>
                                            </td>
                                            <td class="text-right"><button class="btn btn-sm btn-success"><i
                                                        class="fas fa-redo mr-1"></i>Renouveler</button></td>
                                        </tr>
                                        <?php endforeach;
                                        else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">Aucun contrat n'expire
                                                sous 30 jours.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="section-title mt-4 mb-3"><i class="fas fa-user-check mr-1"></i> Périodes d'essai
                                à valider</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Employé</th>
                                            <th>Embauche</th>
                                            <th>Fin d'essai</th>
                                            <th>Décision attendue</th>
                                            <th class="text-right">Traiter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($essais)): foreach ($essais as $c): ?>
                                        <tr>
                                            <td><?= html_escape($c->prenoms . ' ' . mb_strtoupper($c->nom)) ?> <small
                                                    class="text-muted">(<?= $c->matricule ?>)</small></td>
                                            <td><?= date('d/m/Y', strtotime($c->date_debut)) ?></td>
                                            <td><?= date('d/m/Y', $c->_fin_essai->getTimestamp()) ?></td>
                                            <td>Confirmation ou rupture de la période d'essai</td>
                                            <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                        class="fas fa-clipboard-check mr-1"></i>Évaluer</button></td>
                                        </tr>
                                        <?php endforeach;
                                        else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">Aucune période d'essai
                                                en cours.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============ MODALE : NOUVEAU CONTRAT / RENOUVELLEMENT ============ -->
            <div class="modal fade" id="modalNouveauContrat">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="formNouveauContrat" method="post" action="<?= base_url('rh-contrats-store') ?>"
                            enctype="multipart/form-data">
                            <div class="modal-header bg-success text-white">
                                <h4 class="modal-title"><i class="fas fa-file-signature mr-2"></i>Nouveau contrat /
                                    renouvellement</h4>
                                <button type="button" class="close text-white"
                                    data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Employé *</label>
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
                                        <div class="form-group"><label>Opération *</label>
                                            <select name="operation" class="form-control">
                                                <option>Nouveau contrat</option>
                                                <option>Renouvellement</option>
                                                <option>Avenant (modification)</option>
                                                <option>Transformation CDD → CDI</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Type de contrat *</label>
                                            <select name="type_contrat" class="form-control">
                                                <option>CDI</option>
                                                <option>CDD</option>
                                                <option>Stage</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Date de début *</label>
                                            <input type="date" name="date_debut" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Date de fin (si CDD/Stage)</label>
                                            <input type="date" name="date_fin" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Période d'essai</label>
                                            <select name="periode_essai" class="form-control">
                                                <option>Aucune</option>
                                                <option>3 mois</option>
                                                <option>6 mois</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Fonction *</label>
                                            <input type="text" name="fonction" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Salaire BRUT (BIF) *</label>
                                            <input type="number" name="salaire_base" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Affectation *</label>
                                            <select name="site_affectation" class="form-control">
                                                <option>Siège (Bujumbura)</option>
                                                <option>Chantiers</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Contrat signé (PDF)</label>
                                            <div class="custom-file">
                                                <input type="file" name="document" class="custom-file-input"
                                                    id="fileContratSigne">
                                                <label class="custom-file-label" for="fileContratSigne">Choisir…</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group"><label>Observations</label>
                                            <textarea name="observations" class="form-control" rows="2"
                                                placeholder="Motif du renouvellement, conditions particulières…"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>
                                    Enregistrer le contrat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ============ MODALE : ENREGISTRER UN MOUVEMENT ============ -->
            <div class="modal fade" id="modalMouvement">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="formMouvement" method="post" action="<?= base_url('rh-mouvements-store') ?>"
                            enctype="multipart/form-data">
                            <div class="modal-header bg-success text-white">
                                <h4 class="modal-title"><i class="fas fa-exchange-alt mr-2"></i>Enregistrer un mouvement
                                </h4>
                                <button type="button" class="close text-white"
                                    data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Employé *</label>
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
                                        <div class="form-group"><label>Type de mouvement *</label>
                                            <select name="type_mouvement" class="form-control" required>
                                                <option value="Entrée">Entrée (embauche)</option>
                                                <option value="Démission">Démission</option>
                                                <option value="Licenciement">Licenciement</option>
                                                <option value="Fin de contrat">Fin de contrat</option>
                                                <option value="Retraite">Mise à la retraite</option>
                                                <option value="Transfert">Transfert (changement de site/département)
                                                </option>
                                                <option value="Promotion">Promotion</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Date d'effet *</label>
                                            <input type="date" name="date_effet" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Nouvelle affectation (si
                                                transfert/promotion)</label>
                                            <select name="nouvelle_affectation" class="form-control">
                                                <option value="">— Inchangée —</option>
                                                <option>Siège (Bujumbura)</option>
                                                <option>Chantier Ngagara II</option>
                                                <option>Chantier Gitega</option>
                                                <option>Chantier Ngozi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label>Pièce justificative (lettre, avis…)</label>
                                            <div class="custom-file">
                                                <input type="file" name="justificatif" class="custom-file-input"
                                                    id="fileJustificatif">
                                                <label class="custom-file-label" for="fileJustificatif">Choisir…</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group"><label>Motif / commentaire</label>
                                            <textarea name="motif" class="form-control" rows="2"
                                                placeholder="Ex. : lettre de démission reçue le…, fin de chantier…"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>
                                    Enregistrer le mouvement</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ============ SCRIPTS ============ -->
            <script>
            /* Données employés embarquées (pré-remplissage fonction & salaire) */
            var RH_EMPLOYES = {};
            <?php foreach ($employes as $e): ?>
            RH_EMPLOYES[<?= (int)$e->employe_id ?>] = <?= json_encode($e) ?>;
            <?php endforeach; ?>

            function rhNotify(type, msg) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: (type === 'success') ? 'success' : (type === 'warning' ? 'warning' : 'error'),
                        title: msg,
                        showConfirmButton: false,
                        timer: 3500,
                        timerProgressBar: true
                    });
                } else {
                    console.log('[' + type + '] ' + msg);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {

                /* Pré-remplissage fonction + salaire à la sélection d'un employé */
                var formC = document.getElementById('formNouveauContrat');
                if (formC) {
                    formC.querySelector('[name="employe_id"]').addEventListener('change', function() {
                        var emp = RH_EMPLOYES[this.value];
                        if (emp) {
                            formC.querySelector('[name="fonction"]').value = emp.fonction;
                            formC.querySelector('[name="salaire_base"]').value = parseFloat(emp
                                .salaire_base);
                        }
                    });
                }

                /* Affichage du nom du fichier choisi (toutes les modales) */
                document.querySelectorAll('.custom-file-input').forEach(function(input) {
                    input.addEventListener('change', function() {
                        var label = this.closest('.custom-file').querySelector(
                            '.custom-file-label');
                        label.textContent = (this.files && this.files.length) ? this.files[0]
                            .name : 'Choisir…';
                        label.classList.toggle('has-file', this.files.length > 0);
                    });
                });

                /* Recherche rapide dans l'onglet Contrats */
                var sc = document.getElementById('searchContrats');
                if (sc) sc.addEventListener('keyup', function() {
                    var q = this.value.toLowerCase();
                    document.querySelectorAll('#tabContrats tbody tr').forEach(function(tr) {
                        tr.style.display = tr.textContent.toLowerCase().indexOf(q) !== -1 ? '' :
                            'none';
                    });
                });
            });
            </script>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->