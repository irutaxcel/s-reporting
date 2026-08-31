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
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- ============ STYLE LOCAL (page paie) ============ -->
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

            .step-circle {
                width: 46px;
                height: 46px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
                color: #fff;
            }

            .bulletin th {
                background: #f4f6f9;
            }
            </style>

            <!-- ============ CALCULS DE LA FEUILLE DE PAIE ============ -->
            <?php
            /* ----- Barème IPR progressif (démo — à ajuster selon barème OBR en vigueur) ----- */
            if (!function_exists('calcul_ipr')) {
                function calcul_ipr($brut)
                {
                    $tranches = [[250000, 0], [250000, 0.15], [500000, 0.20], [1000000, 0.25], [INF, 0.30]];
                    $impot = 0;
                    $restant = $brut;
                    foreach ($tranches as $t) {
                        if ($restant <= 0) break;
                        $base = min($restant, $t[0]);
                        $impot += $base * $t[1];
                        $restant -= $base;
                    }
                    return (int) round($impot);
                }
            }

            $PLAFOND_INSS   = 450000;
            $badge_paiement = ['Virement bancaire' => 'info', 'Espèces' => 'secondary', 'Mobile money' => 'warning'];
            $couleurs       = ['#1f7a5c', '#2c8a69', '#34608c', '#7a4f1f', '#8a3033', '#6c757d'];

            /* ----- Dernier contrat par employé (salaire / fonction prioritaires) ----- */
            $dernier_contrat = [];
            foreach ($contrats as $c) {
                if (!isset($dernier_contrat[$c->employe_id])) $dernier_contrat[$c->employe_id] = $c;
            }

            /* ----- Calcul de la feuille du mois (employés actifs) ----- */
            $lignes    = [];
            $totaux    = ['brut' => 0, 'inss' => 0, 'ipr' => 0, 'net' => 0, 'charges' => 0];
            $paiements = [];

            foreach ($employes as $e) {
                if ($e->statut === 'Fin de contrat') continue;

                $ct   = isset($dernier_contrat[$e->employe_id]) ? $dernier_contrat[$e->employe_id] : NULL;
                $base = (int) ($ct ? $ct->salaire_base : $e->salaire_base);
                $log  = (int) round($base * 0.10);   // allocation logement 10 %
                $tra  = 50000;                       // allocation transport fixe
                $hs   = 0;                           // ← sera alimenté par tbl_pointages
                $brut = $base + $log + $tra + $hs;

                $assiette = min($brut, $PLAFOND_INSS);
                $inss_s   = (int) round($assiette * 0.04);
                $inss_p   = (int) round($assiette * 0.06);
                $ipr      = calcul_ipr($brut);
                $net      = $brut - $inss_s - $ipr;

                $lignes[] = [
                    'employe_id' => $e->employe_id,
                    'matricule' => $e->matricule,
                    'nom' => $e->nom,
                    'prenoms' => $e->prenoms,
                    'fonction' => $ct ? $ct->fonction : $e->fonction,
                    'categorie' => $e->categorie,
                    'mode' => $e->mode_paiement,
                    'matricule_inss' => $e->matricule_inss ?: '—',
                    'base' => $base,
                    'log' => $log,
                    'tra' => $tra,
                    'hs' => $hs,
                    'brut' => $brut,
                    'inss' => $inss_s,
                    'ipr' => $ipr,
                    'net' => $net,
                ];

                $totaux['brut']    += $brut;
                $totaux['inss']    += $inss_s;
                $totaux['ipr']     += $ipr;
                $totaux['net']     += $net;
                $totaux['charges'] += $inss_p;

                if (!isset($paiements[$e->mode_paiement])) $paiements[$e->mode_paiement] = ['nb' => 0, 'net' => 0];
                $paiements[$e->mode_paiement]['nb']++;
                $paiements[$e->mode_paiement]['net'] += $net;
            }

            $fmt        = function ($n) {
                return number_format($n, 0, '', ' ');
            };
            $mois_label = (new DateTime())->format('m/Y');

            $paie_json = [];
            foreach ($lignes as $l) {
                $paie_json[$l['employe_id']] = $l;
            }
            ?>

            <!-- ============ 1. INDICATEURS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-money-bill-wave"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Masse salariale brute</span>
                            <span class="info-box-number"><?= $fmt($totaux['brut']) ?> <small>BIF</small></span>
                            <span class="progress-description"><?= count($lignes) ?> employés ·
                                <?= $mois_label ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-hand-holding-usd"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Net à payer</span>
                            <span class="info-box-number"><?= $fmt($totaux['net']) ?> <small>BIF</small></span>
                            <span class="progress-description">Virement · espèces · mobile money</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-minus-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Retenues salariales</span>
                            <span class="info-box-number"><?= $fmt($totaux['inss'] + $totaux['ipr']) ?>
                                <small>BIF</small></span>
                            <span class="progress-description">INSS 4 % + IPR (barème OBR)</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Charges patronales</span>
                            <span class="info-box-number"><?= $fmt($totaux['charges']) ?> <small>BIF</small></span>
                            <span class="progress-description">INSS 6 % + assurance maladie</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. CYCLE DE PAIE ============ -->
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-2 mb-2">
                            <span class="step-circle bg-success"><i class="fas fa-database"></i></span>
                            <div class="font-weight-bold mt-1" style="font-size:.85rem">1. Variables</div>
                            <small class="text-muted">Présences, HS, congés</small><br>
                            <span class="badge badge-success mt-1">Collecté</span>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <span class="step-circle bg-success"><i class="fas fa-calculator"></i></span>
                            <div class="font-weight-bold mt-1" style="font-size:.85rem">2. Calcul</div>
                            <small class="text-muted">Brut → net</small><br>
                            <span class="badge badge-success mt-1">Terminé</span>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <span class="step-circle bg-success"><i class="fas fa-user-check"></i></span>
                            <div class="font-weight-bold mt-1" style="font-size:.85rem">3. Contrôle RH</div>
                            <small class="text-muted">Vérification feuille</small><br>
                            <span class="badge badge-success mt-1">Validé</span>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <span class="step-circle bg-warning"><i class="fas fa-balance-scale"></i></span>
                            <div class="font-weight-bold mt-1" style="font-size:.85rem">4. Validation DAF</div>
                            <small class="text-muted">+ écriture comptable</small><br>
                            <span class="badge badge-warning mt-1">En cours</span>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <span class="step-circle bg-secondary"><i class="fas fa-university"></i></span>
                            <div class="font-weight-bold mt-1" style="font-size:.85rem">5. Paiement</div>
                            <small class="text-muted">Échéance fin de mois</small><br>
                            <span class="badge badge-secondary mt-1">À venir</span>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <span class="step-circle bg-secondary"><i class="fas fa-landmark"></i></span>
                            <div class="font-weight-bold mt-1" style="font-size:.85rem">6. Déclarations</div>
                            <small class="text-muted">IPR · INSS</small><br>
                            <span class="badge badge-secondary mt-1">À venir</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 3. ONGLETS ============ -->
            <div class="card">
                <div class="card-header p-2 px-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tabPeriode"><i
                                        class="fas fa-calculator mr-1"></i> Période
                                    <?= (new DateTime())->format('F Y') ?></a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabHistorique"><i
                                        class="fas fa-history mr-1"></i> Historique</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabDeclarations"><i
                                        class="fas fa-landmark mr-1"></i> Déclarations sociales</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabRubriques"><i
                                        class="fas fa-sliders-h mr-1"></i> Structure &amp; paramètres</a></li>
                        </ul>
                        <div>
                            <button type="button" class="btn btn-default mr-2"><i class="fas fa-share mr-1"></i>
                                Écriture comptable</button>
                            <button type="button" class="btn btn-success"><i class="fas fa-play mr-1"></i> Lancer le
                                calcul</button>
                        </div>
                    </div>
                </div>

                <div class="tab-content">

                    <!-- ===== ONGLET : PÉRIODE EN COURS ===== -->
                    <div class="tab-pane fade active show" id="tabPeriode">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap" style="font-size:.88rem">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Cat.</th>
                                        <th>Base</th>
                                        <th>Allocations</th>
                                        <th>Heures sup</th>
                                        <th>Brut</th>
                                        <th>INSS 4 %</th>
                                        <th>IPR</th>
                                        <th>Net à payer</th>
                                        <th>Paiement</th>
                                        <th class="text-right">Bulletin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($lignes)): foreach ($lignes as $l):
                                            $initiales = strtoupper(mb_substr($l['prenoms'], 0, 1) . mb_substr($l['nom'], 0, 1));
                                            $couleur   = $couleurs[$l['employe_id'] % count($couleurs)];
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar-initials mr-2"
                                                    style="background:<?= $couleur ?>"><?= $initiales ?></span>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        <?= html_escape($l['prenoms'] . ' ' . mb_strtoupper($l['nom'])) ?>
                                                    </div>
                                                    <small
                                                        class="text-muted"><?= html_escape($l['matricule']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $l['categorie'] ?></td>
                                        <td><?= $fmt($l['base']) ?></td>
                                        <td><?= $fmt($l['log'] + $l['tra']) ?></td>
                                        <td><?= $l['hs'] ? $fmt($l['hs']) : '—' ?></td>
                                        <td><strong><?= $fmt($l['brut']) ?></strong></td>
                                        <td><?= $fmt($l['inss']) ?></td>
                                        <td><?= $fmt($l['ipr']) ?></td>
                                        <td><strong class="text-success"><?= $fmt($l['net']) ?></strong></td>
                                        <td><span
                                                class="badge badge-<?= $badge_paiement[$l['mode']] ?? 'secondary' ?>"><?= str_replace(' bancaire', '', $l['mode']) ?></span>
                                        </td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-sm btn-default" title="Bulletin"
                                                onclick="ouvrirBulletin(<?= $l['employe_id'] ?>)">
                                                <i class="fas fa-file-invoice"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach;
                                    else: ?>
                                    <tr>
                                        <td colspan="11" class="text-center text-muted py-4"><i
                                                class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucun employé actif à payer.
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold" style="background:#f4f6f9">
                                        <td colspan="5" class="text-right">TOTAUX (<?= count($lignes) ?> employés) —
                                        </td>
                                        <td><?= $fmt($totaux['brut']) ?></td>
                                        <td><?= $fmt($totaux['inss']) ?></td>
                                        <td><?= $fmt($totaux['ipr']) ?></td>
                                        <td class="text-success"><?= $fmt($totaux['net']) ?></td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center">
                                <?php
                                $libelles = ['Virement bancaire' => 'Virement bancaire', 'Espèces' => 'Espèces (chantiers)', 'Mobile money' => 'Mobile money'];
                                foreach ($libelles as $cle => $lib):
                                    $p = isset($paiements[$cle]) ? $paiements[$cle] : ['nb' => 0, 'net' => 0];
                                ?>
                                <div class="col-4">
                                    <small class="text-muted"><?= $lib ?></small><br>
                                    <strong><?= $p['nb'] ?> employé<?= $p['nb'] > 1 ? 's' : '' ?> ·
                                        <?= $fmt($p['net']) ?> BIF</strong>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- ===== ONGLET : HISTORIQUE ===== -->
                    <div class="tab-pane fade" id="tabHistorique">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Période</th>
                                        <th>Effectif payé</th>
                                        <th>Masse brute</th>
                                        <th>Net payé</th>
                                        <th>Payée le</th>
                                        <th>Statut</th>
                                        <th class="text-right">Documents</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Juillet 2026</strong></td>
                                        <td>56</td>
                                        <td>51 900 000</td>
                                        <td>45 720 000</td>
                                        <td>28/07/2026</td>
                                        <td><span class="badge badge-success">Payée · comptabilisée</span></td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-default" title="Feuille de paie"><i
                                                    class="fas fa-table"></i></button>
                                            <button class="btn btn-sm btn-default" title="Bulletins (PDF)"><i
                                                    class="fas fa-file-pdf text-danger"></i></button>
                                            <button class="btn btn-sm btn-default" title="Écriture comptable"><i
                                                    class="fas fa-book"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Juin 2026</strong></td>
                                        <td>55</td>
                                        <td>50 800 000</td>
                                        <td>44 760 000</td>
                                        <td>27/06/2026</td>
                                        <td><span class="badge badge-success">Payée · comptabilisée</span></td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-default"><i class="fas fa-table"></i></button>
                                            <button class="btn btn-sm btn-default"><i
                                                    class="fas fa-file-pdf text-danger"></i></button>
                                            <button class="btn btn-sm btn-default"><i class="fas fa-book"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mai 2026</strong></td>
                                        <td>55</td>
                                        <td>50 800 000</td>
                                        <td>44 760 000</td>
                                        <td>28/05/2026</td>
                                        <td><span class="badge badge-success">Payée · comptabilisée</span></td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-default"><i class="fas fa-table"></i></button>
                                            <button class="btn btn-sm btn-default"><i
                                                    class="fas fa-file-pdf text-danger"></i></button>
                                            <button class="btn btn-sm btn-default"><i class="fas fa-book"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ===== ONGLET : DÉCLARATIONS SOCIALES ===== -->
                    <div class="tab-pane fade" id="tabDeclarations">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Organisme</th>
                                        <th>Objet</th>
                                        <th>Période</th>
                                        <th>Assiette / montant</th>
                                        <th>Échéance</th>
                                        <th>Statut</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>OBR</strong></td>
                                        <td>IPR — retenue à la source</td>
                                        <td><?= (new DateTime())->format('F Y') ?></td>
                                        <td><?= $fmt($totaux['ipr']) ?> BIF</td>
                                        <td>10 du mois suivant</td>
                                        <td><span class="badge badge-warning">À déclarer</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-success">Générer la
                                                déclaration</button></td>
                                    </tr>
                                    <tr>
                                        <td><strong>INSS</strong></td>
                                        <td>Cotisations (salariale 4 % + patronale 6 %)</td>
                                        <td>T3 2026 (juil–sept)</td>
                                        <td>≈ <?= $fmt(($totaux['inss'] + $totaux['charges']) * 3) ?> BIF</td>
                                        <td>15/10/2026</td>
                                        <td><span class="badge badge-info">En cours (alimentée par la paie)</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default">Détail</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>INSS</strong></td>
                                        <td>Cotisations</td>
                                        <td>T2 2026 (avr–juin)</td>
                                        <td>2 910 000 BIF</td>
                                        <td>15/07/2026</td>
                                        <td><span class="badge badge-success">Payée · reçu N° INSS-2026-0782</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-receipt"></i> Reçu</button></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Assurance maladie</strong></td>
                                        <td>Cotisation mensuelle (2,5 %)</td>
                                        <td><?= (new DateTime())->format('F Y') ?></td>
                                        <td><?= $fmt((int) round($totaux['brut'] * 0.025)) ?> BIF</td>
                                        <td>05 du mois suivant</td>
                                        <td><span class="badge badge-warning">À payer</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-success">Générer</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i>
                                Assiette INSS plafonnée à 450 000 BIF/mois · barème IPR progressif OBR · taux et
                                plafonds modifiables dans l'onglet « Structure &amp; paramètres ».</small>
                        </div>
                    </div>

                    <!-- ===== ONGLET : STRUCTURE & PARAMÈTRES ===== -->
                    <div class="tab-pane fade" id="tabRubriques">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-sm table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Rubrique</th>
                                        <th>Sens</th>
                                        <th>Mode de calcul</th>
                                        <th>Taux / valeur</th>
                                        <th>Plafond</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>BASE</code></td>
                                        <td>Salaire de base</td>
                                        <td><span class="badge badge-success">Gain</span></td>
                                        <td>Contractuel</td>
                                        <td>—</td>
                                        <td>—</td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><code>LOG</code></td>
                                        <td>Allocation logement</td>
                                        <td><span class="badge badge-success">Gain</span></td>
                                        <td>% du base</td>
                                        <td>10 %</td>
                                        <td>—</td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><code>TRA</code></td>
                                        <td>Allocation transport</td>
                                        <td><span class="badge badge-success">Gain</span></td>
                                        <td>Fixe</td>
                                        <td>50 000 BIF</td>
                                        <td>—</td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><code>FAM</code></td>
                                        <td>Allocations familiales</td>
                                        <td><span class="badge badge-success">Gain</span></td>
                                        <td>Par enfant</td>
                                        <td>10 000 BIF/enfant</td>
                                        <td>3 enfants</td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><code>HS125</code></td>
                                        <td>Heures sup (semaine)</td>
                                        <td><span class="badge badge-success">Gain</span></td>
                                        <td>Majoration</td>
                                        <td>+25 %</td>
                                        <td>—</td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><code>HS150</code></td>
                                        <td>Heures sup (dimanche/férié)</td>
                                        <td><span class="badge badge-success">Gain</span></td>
                                        <td>Majoration</td>
                                        <td>+50 %</td>
                                        <td>—</td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><code>INSS_S</code></td>
                                        <td>INSS salarié</td>
                                        <td><span class="badge badge-danger">Retenue</span></td>
                                        <td>% du brut plafonné</td>
                                        <td>4 %</td>
                                        <td>450 000 BIF</td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><code>INSS_P</code></td>
                                        <td>INSS patronal (charge)</td>
                                        <td><span class="badge badge-secondary">Charge</span></td>
                                        <td>% du brut plafonné</td>
                                        <td>6 %</td>
                                        <td>450 000 BIF</td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><code>IPR</code></td>
                                        <td>Impôt sur revenu (OBR)</td>
                                        <td><span class="badge badge-danger">Retenue</span></td>
                                        <td>Barème progressif</td>
                                        <td>Barème en vigueur</td>
                                        <td>—</td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><code>AM_S</code></td>
                                        <td>Assurance maladie</td>
                                        <td><span class="badge badge-danger">Retenue</span></td>
                                        <td>% du brut</td>
                                        <td>2,5 %</td>
                                        <td>—</td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                    class="fas fa-edit"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============ MODALE : BULLETIN DE PAIE (dynamique) ============ -->
            <div class="modal fade" id="modalBulletin">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h4 class="modal-title"><i class="fas fa-file-invoice mr-2"></i>Bulletin de paie —
                                <?= (new DateTime())->format('F Y') ?></h4>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>SATRACO Construction</strong><br>
                                    <small class="text-muted">
                                        Ave du Large, Bujumbura<br>
                                        N° employeur INSS : E-10245 · NIF : 400 987 654
                                    </small>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <strong id="bNom">—</strong> <span class="badge badge-success"
                                        id="bMatricule">—</span><br>
                                    <small class="text-muted">
                                        <span id="bFonction">—</span><br>
                                        Matricule INSS : <span id="bInss">—</span> · <span id="bCat">—</span>
                                    </small>
                                </div>
                            </div>

                            <h6 class="section-title">Gains</h6>
                            <table class="table table-sm bulletin mb-2">
                                <tbody>
                                    <tr>
                                        <td>Salaire de base</td>
                                        <td class="text-right" id="gBase">—</td>
                                    </tr>
                                    <tr>
                                        <td>Allocation logement (10 %)</td>
                                        <td class="text-right" id="gLog">—</td>
                                    </tr>
                                    <tr>
                                        <td>Allocation transport</td>
                                        <td class="text-right" id="gTra">—</td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>SALAIRE BRUT</td>
                                        <td class="text-right" id="gBrut">—</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h6 class="section-title">Retenues</h6>
                            <table class="table table-sm bulletin mb-2">
                                <tbody>
                                    <tr>
                                        <td>INSS salarié (4 % — assiette plafonnée)</td>
                                        <td class="text-right" id="rInss">—</td>
                                    </tr>
                                    <tr>
                                        <td>IPR (barème OBR)</td>
                                        <td class="text-right" id="rIpr">—</td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>TOTAL RETENUES</td>
                                        <td class="text-right" id="rTotal">—</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="alert alert-success py-2 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>NET À PAYER</strong>
                                    <strong class="h5 mb-0"><span id="bNet">—</span> BIF</strong>
                                </div>
                                <small>Arrêté le présent bulletin à la somme de : <em id="bLettres">—</em>.</small>
                            </div>

                            <div class="row text-center mt-3">
                                <div class="col-6"><small class="text-muted">L'Employeur</small><br><br>______________
                                </div>
                                <div class="col-6"><small class="text-muted">Le
                                        Travailleur</small><br><br>______________</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-danger"><i class="fas fa-file-pdf mr-1"></i>
                                Télécharger PDF</button>
                            <button type="button" class="btn btn-success" onclick="window.print()"><i
                                    class="fas fa-print mr-1"></i> Imprimer</button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- ============ SCRIPT : BULLETIN DYNAMIQUE ============ -->
<script>
var RH_PAIE = <?= json_encode($paie_json) ?>;

function fmtNb(n) {
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

/* ----- Nombre en lettres (français) ----- */
function enLettres(n) {
    var u = ['zéro', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze', 'douze',
        'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'
    ];
    var d = ['', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt',
        'quatre-vingt-dix'
    ];

    function c(n) {
        var s = '',
            h = Math.floor(n / 100),
            r = n % 100;
        if (h) {
            s += (h > 1 ? u[h] + ' cent' : 'cent');
            if (h > 1 && !r) s += 's';
        }
        if (r) {
            if (s) s += ' ';
            if (r < 20) s += u[r];
            else {
                var t = Math.floor(r / 10),
                    o = r % 10;
                if (t === 7 || t === 9) s += d[t - 1] + '-' + u[10 + o];
                else {
                    s += d[t];
                    if (o) s += (o === 1 && t < 8) ? ' et un' : '-' + u[o];
                }
            }
        }
        return s || 'zéro';
    }
    var M = Math.floor(n / 1000000),
        m = Math.floor((n % 1000000) / 1000),
        r = n % 1000,
        s = '';
    if (M) s += (M > 1 ? u[M] + ' millions' : 'un million');
    if (m) s += (s ? ' ' : '') + (m > 1 ? c(m) + ' mille' : 'mille');
    if (r) s += (s ? ' ' : '') + c(r);
    return s || 'zéro';
}

/* ----- Ouverture du bulletin pré-rempli ----- */
function ouvrirBulletin(id) {
    var p = RH_PAIE[id];
    if (!p) return;
    document.getElementById('bNom').textContent = p.prenoms + ' ' + p.nom.toUpperCase();
    document.getElementById('bMatricule').textContent = p.matricule;
    document.getElementById('bFonction').textContent = p.fonction;
    document.getElementById('bInss').textContent = p.matricule_inss;
    document.getElementById('bCat').textContent = p.categorie;
    document.getElementById('gBase').textContent = fmtNb(p.base);
    document.getElementById('gLog').textContent = fmtNb(p.log);
    document.getElementById('gTra').textContent = fmtNb(p.tra);
    document.getElementById('gBrut').textContent = fmtNb(p.brut);
    document.getElementById('rInss').textContent = fmtNb(p.inss);
    document.getElementById('rIpr').textContent = fmtNb(p.ipr);
    document.getElementById('rTotal').textContent = fmtNb(p.inss + p.ipr);
    document.getElementById('bNet').textContent = fmtNb(p.net);
    document.getElementById('bLettres').textContent = enLettres(p.net) + ' francs burundais';
    $('#modalBulletin').modal('show');
}
</script>