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

            <!-- ============ STYLE LOCAL (page congés) ============ -->
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

            <!-- ============ 1. INDICATEURS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-umbrella-beach"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">En congé aujourd'hui</span>
                            <span class="info-box-number">3</span>
                            <span class="progress-description">Sur 55 actifs</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Demandes en attente</span>
                            <span class="info-box-number">3</span>
                            <span class="progress-description">À traiter cette semaine</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-calendar-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jours pris (2026)</span>
                            <span class="info-box-number">148</span>
                            <span class="progress-description">Sur 1 155 jours de droits</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Conflits de planning</span>
                            <span class="info-box-number">1</span>
                            <span class="progress-description">Chevauchement Ngagara II</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. RAPPEL LÉGAL + EN CONGÉ AUJOURD'HUI ============ -->
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
                                aujourd'hui (21/08/2026)</h3>
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
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#2c8a69">EI</span>
                                                <div class="font-weight-bold">Espérance INGABIRE <small
                                                        class="text-muted">(SAT-0007)</small></div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-info">Congé annuel</span></td>
                                        <td>12/08 → 21/08/2026</td>
                                        <td>10</td>
                                        <td>
                                            <div class="progress" style="height:6px;width:120px">
                                                <div class="progress-bar bg-info" style="width:100%"></div>
                                            </div>
                                        </td>
                                        <td><strong>Lundi 24/08</strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#34608c">CU</span>
                                                <div class="font-weight-bold">Chantal UWIZEYIMANA <small
                                                        class="text-muted">(SAT-0038)</small></div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-info">Congé annuel</span></td>
                                        <td>17/08 → 28/08/2026</td>
                                        <td>10</td>
                                        <td>
                                            <div class="progress" style="height:6px;width:120px">
                                                <div class="progress-bar bg-info" style="width:45%"></div>
                                            </div>
                                        </td>
                                        <td><strong>Lundi 31/08</strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#8a3033">ES</span>
                                                <div class="font-weight-bold">Eric SINDAYIHEBURA <small
                                                        class="text-muted">(SAT-0028)</small></div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-info">Congé annuel</span></td>
                                        <td>18/08 → 28/08/2026</td>
                                        <td>9</td>
                                        <td>
                                            <div class="progress" style="height:6px;width:120px">
                                                <div class="progress-bar bg-info" style="width:35%"></div>
                                            </div>
                                        </td>
                                        <td><strong>Lundi 31/08</strong></td>
                                    </tr>
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
                                        class="badge badge-warning ml-1">3</span></a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabPlanning"><i
                                        class="fas fa-calendar-alt mr-1"></i> Planning (60 jours)</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabSoldes"><i
                                        class="fas fa-wallet mr-1"></i> Soldes 2026</a></li>
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
                                        <th>Supérieur hiérarchique</th>
                                        <th>Statut</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-warning">
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#2c8a69">DI</span>
                                                <div>
                                                    <div class="font-weight-bold">Divine IRAKOZE</div><small
                                                        class="text-muted">SAT-0033 · Assistant RH</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-info">Annuel</span></td>
                                        <td>24/08 → 04/09/2026</td>
                                        <td>10</td>
                                        <td><span class="badge badge-success">Favorable</span> <small
                                                class="text-muted">Resp. RH</small></td>
                                        <td><span class="badge badge-warning">En attente RH</span></td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-success" title="Approuver"><i
                                                    class="fas fa-check"></i></button>
                                            <button class="btn btn-sm btn-danger" title="Rejeter"><i
                                                    class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#34608c">AN</span>
                                                <div>
                                                    <div class="font-weight-bold">Ange NIYONKURU</div><small
                                                        class="text-muted">SAT-0047 · Maçon (Ngozi)</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-info">Annuel</span></td>
                                        <td>01/09 → 12/09/2026</td>
                                        <td>10</td>
                                        <td><span class="badge badge-warning">En attente</span> <small
                                                class="text-muted">Chef de chantier</small></td>
                                        <td><span class="badge badge-warning">En attente</span></td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-success" title="Approuver"><i
                                                    class="fas fa-check"></i></button>
                                            <button class="btn btn-sm btn-danger" title="Rejeter"><i
                                                    class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#34608c">AN</span>
                                                <div>
                                                    <div class="font-weight-bold">Alice NIYONZIMA</div><small
                                                        class="text-muted">SAT-0014 · Comptable senior</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-primary">Circonstance (mariage)</span></td>
                                        <td>28/08/2026</td>
                                        <td>1</td>
                                        <td><span class="badge badge-success">Favorable</span> <small
                                                class="text-muted">DAF</small></td>
                                        <td><span class="badge badge-warning">En attente RH</span></td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-success" title="Approuver"><i
                                                    class="fas fa-check"></i></button>
                                            <button class="btn btn-sm btn-danger" title="Rejeter"><i
                                                    class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#34608c">AN</span>
                                                <div>
                                                    <div class="font-weight-bold">Alice NIYONZIMA</div><small
                                                        class="text-muted">SAT-0014</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-info">Annuel</span></td>
                                        <td>09/03 → 20/03/2026</td>
                                        <td>10</td>
                                        <td><span class="badge badge-success">Favorable</span></td>
                                        <td><span class="badge badge-success">Approuvé · pris</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default" title="Voir"><i
                                                    class="fas fa-eye"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#7a4f1f">DB</span>
                                                <div>
                                                    <div class="font-weight-bold">David BIZIMANA</div><small
                                                        class="text-muted">SAT-0048</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-info">Annuel</span></td>
                                        <td>03/08 → 14/08/2026</td>
                                        <td>10</td>
                                        <td><span class="badge badge-danger">Défavorable</span> <small
                                                class="text-muted">Effectif insuffisant Ngagara II</small></td>
                                        <td><span class="badge badge-danger">Rejeté</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default" title="Voir"><i
                                                    class="fas fa-eye"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#1f7a5c">JN</span>
                                                <div>
                                                    <div class="font-weight-bold">Jean-Marie NDAYIZEYE</div><small
                                                        class="text-muted">SAT-0001</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-info">Annuel</span></td>
                                        <td>23/12/2025 → 02/01/2026</td>
                                        <td>8</td>
                                        <td><span class="badge badge-success">Favorable</span></td>
                                        <td><span class="badge badge-success">Approuvé · pris</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default" title="Voir"><i
                                                    class="fas fa-eye"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ===== ONGLET : PLANNING 60 JOURS ===== -->
                    <div class="tab-pane fade" id="tabPlanning">
                        <div class="card-body">
                            <div class="alert alert-warning py-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <strong>Conflit détecté :</strong> SINDAYIHEBURA (18–28/08) et UWIZEYIMANA (17–28/08)
                                absents simultanément
                                alors qu'ils relèvent de la même équipe électricité — prévoir un remplaçant ou décaler
                                l'un des deux.
                            </div>
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
                                        <tr>
                                            <td>Divine IRAKOZE</td>
                                            <td>Ressources Humaines</td>
                                            <td>24/08 → 04/09/2026</td>
                                            <td>10</td>
                                            <td>J.-M. NDAYIZEYE (partiel)</td>
                                            <td><span class="badge badge-warning">En approbation</span></td>
                                        </tr>
                                        <tr>
                                            <td>Ange NIYONKURU</td>
                                            <td>Chantier Ngozi</td>
                                            <td>01/09 → 12/09/2026</td>
                                            <td>10</td>
                                            <td>— à désigner</td>
                                            <td><span class="badge badge-warning">En approbation</span></td>
                                        </tr>
                                        <tr>
                                            <td>Vestine GAKOBWA</td>
                                            <td>Chantier Ngozi</td>
                                            <td>07/09 → 18/09/2026</td>
                                            <td>10</td>
                                            <td>D. NUNUBAHA</td>
                                            <td><span class="badge badge-success">Approuvé</span></td>
                                        </tr>
                                        <tr>
                                            <td>Thierry NIMUBONA</td>
                                            <td>DAF / Finance</td>
                                            <td>14/09 → 25/09/2026</td>
                                            <td>10</td>
                                            <td>A. NIYONZIMA</td>
                                            <td><span class="badge badge-success">Approuvé</span></td>
                                        </tr>
                                        <tr>
                                            <td>Gilbert RUKARA</td>
                                            <td>Chantier Ngagara II</td>
                                            <td>21/09 → 02/10/2026</td>
                                            <td>10</td>
                                            <td>— à désigner</td>
                                            <td><span class="badge badge-success">Approuvé</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Le planning est établi en
                                début d'année par service/chantier, puis ajusté par demandes individuelles.</small>
                        </div>
                    </div>

                    <!-- ===== ONGLET : SOLDES 2026 ===== -->
                    <div class="tab-pane fade" id="tabSoldes">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Ancienneté</th>
                                        <th>Droit 2026</th>
                                        <th>Jours pris</th>
                                        <th>En cours</th>
                                        <th>Solde restant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jean-Marie NDAYIZEYE <small class="text-muted">(SAT-0001)</small></td>
                                        <td>6 ans</td>
                                        <td>21 j</td>
                                        <td>8</td>
                                        <td>0</td>
                                        <td><span class="badge badge-success">13 j</span></td>
                                    </tr>
                                    <tr>
                                        <td>Espérance INGABIRE <small class="text-muted">(SAT-0007)</small></td>
                                        <td>3 ans</td>
                                        <td>20 j</td>
                                        <td>10</td>
                                        <td>10</td>
                                        <td><span class="badge badge-info">0 j</span></td>
                                    </tr>
                                    <tr>
                                        <td>Alice NIYONZIMA <small class="text-muted">(SAT-0014)</small></td>
                                        <td>5 ans</td>
                                        <td>21 j</td>
                                        <td>10</td>
                                        <td>0</td>
                                        <td><span class="badge badge-success">11 j</span></td>
                                    </tr>
                                    <tr>
                                        <td>Patrick HAKIZIMANA <small class="text-muted">(SAT-0021)</small></td>
                                        <td>4 ans</td>
                                        <td>21 j</td>
                                        <td>5</td>
                                        <td>0</td>
                                        <td><span class="badge badge-success">16 j</span></td>
                                    </tr>
                                    <tr>
                                        <td>Justine MBONIMPA <small class="text-muted">(SAT-0032)</small></td>
                                        <td>2 ans</td>
                                        <td>20 j</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td><span class="badge badge-success">20 j</span></td>
                                    </tr>
                                    <tr>
                                        <td>Aymar KIGABIRO <small class="text-muted">(SAT-0008)</small></td>
                                        <td>&lt; 1 an</td>
                                        <td>3 j <small class="text-muted">(prorata)</small></td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td><span class="badge badge-success">3 j</span></td>
                                    </tr>
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

            <!-- ============ MODALE : NOUVELLE DEMANDE DE CONGÉ ============ -->
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
                                                <?php foreach ($employes as $r):
                                                    if ($r->statut === 'Fin de contrat') continue; ?>
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

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var form = document.getElementById('formDemandeConge');
                if (!form) return;

                /* ----- Calcul des jours ouvrés (lun → ven) en temps réel ----- */
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
                    if (deb && fin && fin >= deb) {
                        out.value = joursOuvres(deb, fin) + ' jour(s)';
                    } else {
                        out.value = '—';
                    }
                }
                form.querySelector('[name="date_debut"]').addEventListener('change', majJours);
                form.querySelector('[name="date_fin"]').addEventListener('change', majJours);

                /* ----- Nom du fichier choisi ----- */
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

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->