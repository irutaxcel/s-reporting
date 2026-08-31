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

            <!-- ============ STYLE LOCAL (page paramètres) ============ -->
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

            .param-card {
                border-left: 4px solid #1f7a5c;
            }
            </style>

            <!-- ============ BANNIÈRE D'INFORMATION ============ -->
            <div class="alert alert-info py-2">
                <i class="fas fa-shield-alt mr-1"></i>
                <small>Ces paramètres pilotent <strong>tous les calculs du module RH</strong> (paie, congés, alertes,
                    rapports).
                    Toute modification est <strong>journalisée</strong> (qui, quand, ancienne/nouvelle valeur).</small>
            </div>

            <!-- ============ ONGLETS ============ -->
            <div class="card">
                <div class="card-header p-2 px-3">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tabEntreprise"><i
                                    class="fas fa-building mr-1"></i> Entreprise &amp; organisation</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabPaie"><i
                                    class="fas fa-money-bill-wave mr-1"></i> Paie</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabConges"><i
                                    class="fas fa-umbrella-beach mr-1"></i> Congés &amp; temps</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabRegles"><i
                                    class="fas fa-balance-scale mr-1"></i> Règles &amp; numérotation</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabAcces"><i
                                    class="fas fa-user-shield mr-1"></i> Utilisateurs &amp; permissions</a></li>
                    </ul>
                </div>

                <div class="tab-content">

                    <!-- ===== ONGLET : ENTREPRISE & ORGANISATION ===== -->
                    <div class="tab-pane fade active show" id="tabEntreprise">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h6 class="section-title mb-3"><i class="fas fa-building mr-1"></i> Identité de
                                        l'employeur</h6>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group"><label>Raison sociale</label><input type="text"
                                                    class="form-control" value="SATRACO Construction (SATRACO)"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><label>N° RCCM</label><input type="text"
                                                    class="form-control" value="RC/BSB/2019/B/0456"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><label>N° employeur INSS</label><input type="text"
                                                    class="form-control" value="E-10245"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><label>N° contribuable (OBR)</label><input
                                                    type="text" class="form-control" value="400 987 654"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><label>Représentant légal</label><input type="text"
                                                    class="form-control" value="La Direction Générale"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group"><label>Siège social</label><input type="text"
                                                    class="form-control" value="Avenue du Large, Bujumbura — Burundi">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group"><label>Activité principale</label><input type="text"
                                                    class="form-control"
                                                    value="Construction de bâtiments et travaux publics"></div>
                                        </div>
                                        <div class="col-12 text-right"><button class="btn btn-success"><i
                                                    class="fas fa-save mr-1"></i> Enregistrer</button></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="section-title mb-3"><i class="fas fa-map-marker-alt mr-1"></i> Sites
                                        &amp; départements</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Site</th>
                                                    <th>Type</th>
                                                    <th>Responsable</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Siège (Bujumbura)</td>
                                                    <td><span class="badge badge-info">Siège</span></td>
                                                    <td>Direction Générale</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Chantier Ngagara II</td>
                                                    <td><span class="badge badge-warning">Chantier</span></td>
                                                    <td>J.-C. NSABIMANA</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Chantier Gitega</td>
                                                    <td><span class="badge badge-warning">Chantier</span></td>
                                                    <td>F. NDIKUMANA</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Chantier Ngozi</td>
                                                    <td><span class="badge badge-warning">Chantier</span></td>
                                                    <td>P. NIMBONEZA</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive mt-2">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Département</th>
                                                    <th>Responsable</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Direction Générale</td>
                                                    <td>Direction Générale</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>DAF / Finance</td>
                                                    <td>Th. NIMUBONA</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Direction Technique</td>
                                                    <td>O. BUKURU</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Ressources Humaines</td>
                                                    <td>J.-M. NDAYIZEYE</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="btn btn-default btn-sm"><i class="fas fa-plus mr-1"></i> Ajouter un
                                        site / département</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== ONGLET : PAIE ===== -->
                    <div class="tab-pane fade" id="tabPaie">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-7">
                                    <h6 class="section-title mb-3"><i class="fas fa-sliders-h mr-1"></i> Rubriques de
                                        paie</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Rubrique</th>
                                                    <th>Sens</th>
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
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><code>LOG</code></td>
                                                    <td>Allocation logement</td>
                                                    <td><span class="badge badge-success">Gain</span></td>
                                                    <td>10 % du base</td>
                                                    <td>—</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><code>TRA</code></td>
                                                    <td>Allocation transport</td>
                                                    <td><span class="badge badge-success">Gain</span></td>
                                                    <td>50 000 BIF</td>
                                                    <td>—</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><code>FAM</code></td>
                                                    <td>Allocations familiales</td>
                                                    <td><span class="badge badge-success">Gain</span></td>
                                                    <td>10 000 BIF / enfant</td>
                                                    <td>3 enfants</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><code>HS125</code></td>
                                                    <td>Heures sup (semaine)</td>
                                                    <td><span class="badge badge-success">Gain</span></td>
                                                    <td>+25 %</td>
                                                    <td>—</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><code>HS150</code></td>
                                                    <td>Heures sup (dimanche / férié)</td>
                                                    <td><span class="badge badge-success">Gain</span></td>
                                                    <td>+50 %</td>
                                                    <td>—</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><code>INSS_S</code></td>
                                                    <td>INSS salarié</td>
                                                    <td><span class="badge badge-danger">Retenue</span></td>
                                                    <td>4 %</td>
                                                    <td>450 000 BIF</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><code>INSS_P</code></td>
                                                    <td>INSS patronal (charge)</td>
                                                    <td><span class="badge badge-secondary">Charge</span></td>
                                                    <td>6 %</td>
                                                    <td>450 000 BIF</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><code>AM_S</code></td>
                                                    <td>Assurance maladie</td>
                                                    <td><span class="badge badge-danger">Retenue</span></td>
                                                    <td>2,5 %</td>
                                                    <td>—</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <h6 class="section-title mb-3"><i class="fas fa-percentage mr-1"></i> Barème IPR
                                        (OBR) — démo, à ajuster</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Tranche (BIF / mois)</th>
                                                    <th class="text-center">Taux</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>0 – 250 000</td>
                                                    <td class="text-center">0 %</td>
                                                </tr>
                                                <tr>
                                                    <td>250 001 – 500 000</td>
                                                    <td class="text-center">15 %</td>
                                                </tr>
                                                <tr>
                                                    <td>500 001 – 1 000 000</td>
                                                    <td class="text-center">20 %</td>
                                                </tr>
                                                <tr>
                                                    <td>1 000 001 – 2 000 000</td>
                                                    <td class="text-center">25 %</td>
                                                </tr>
                                                <tr>
                                                    <td>&gt; 2 000 000</td>
                                                    <td class="text-center">30 %</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h6 class="section-title mt-3 mb-3"><i class="fas fa-cog mr-1"></i> Règles de
                                        gestion</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"><label>Jour de paie</label><select
                                                    class="form-control">
                                                    <option>28 du mois</option>
                                                    <option>25 du mois</option>
                                                    <option>Dernier jour ouvré</option>
                                                </select></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><label>Devise</label><input type="text"
                                                    class="form-control" value="BIF (Franc burundais)" disabled></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><label>Plafond assiette INSS</label><input
                                                    type="number" class="form-control" value="450000"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><label>Arrondi</label><select class="form-control">
                                                    <option>Franc supérieur</option>
                                                    <option>Franc inférieur</option>
                                                </select></div>
                                        </div>
                                        <div class="col-12 text-right"><button class="btn btn-success"><i
                                                    class="fas fa-save mr-1"></i> Enregistrer</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== ONGLET : CONGÉS & TEMPS ===== -->
                    <div class="tab-pane fade" id="tabConges">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h6 class="section-title mb-3"><i class="fas fa-umbrella-beach mr-1"></i> Types de
                                        congé &amp; droits</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Durée</th>
                                                    <th>Justificatif</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Congé annuel</td>
                                                    <td>20 j ouvrables + 1 j / 4 ans d'ancienneté</td>
                                                    <td>—</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Maladie</td>
                                                    <td>Jusqu'à 3 mois / an</td>
                                                    <td>Certificat médical</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Maternité</td>
                                                    <td>Selon Code du travail</td>
                                                    <td>Certificat médical</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Circonstances</td>
                                                    <td>1 – 5 j (mariage, naissance, décès)</td>
                                                    <td>Pièce justificative</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Sans solde</td>
                                                    <td>Sur accord</td>
                                                    <td>Demande écrite</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="alert alert-info py-2 mb-0">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <small>Acquisition : <strong>1,67 j / mois</strong> · prorata la 1ʳᵉ année ·
                                            demande à introduire <strong>14 jours</strong> avant le départ.</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="section-title mb-3"><i class="fas fa-business-time mr-1"></i> Horaires de
                                        travail</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Population</th>
                                                    <th>Horaires</th>
                                                    <th>Semaine</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Bureau</td>
                                                    <td>07h30 – 16h30</td>
                                                    <td>Lun → Ven · 40 h</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Chantiers</td>
                                                    <td>07h00 – 17h00 (pause 12h–13h)</td>
                                                    <td>Lun → Sam</td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h6 class="section-title mt-3 mb-3"><i class="fas fa-clock mr-1"></i> Règles de
                                        pointage</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"><label>Tolérance retard (min)</label><input
                                                    type="number" class="form-control" value="10"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><label>Seuil heures sup (h / semaine)</label><input
                                                    type="number" class="form-control" value="40"></div>
                                        </div>
                                        <div class="col-12 text-right"><button class="btn btn-success"><i
                                                    class="fas fa-save mr-1"></i> Enregistrer</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== ONGLET : RÈGLES & NUMÉROTATION ===== -->
                    <div class="tab-pane fade" id="tabRegles">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <h6 class="section-title mb-3"><i class="fas fa-hashtag mr-1"></i> Numérotation des
                                        références</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Document</th>
                                                    <th>Masque</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Matricule employé</td>
                                                    <td><code>SAT-NNNN</code></td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Dossier disciplinaire</td>
                                                    <td><code>DIS-AAAA-NNN</code></td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Évaluation</td>
                                                    <td><code>EVL-AAAA-NNN</code></td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Contrat</td>
                                                    <td><code>CTR-AAAA-NNN</code></td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h6 class="section-title mt-3 mb-3"><i class="fas fa-archive mr-1"></i> Durées de
                                        conservation</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <tbody>
                                                <tr>
                                                    <td>Registre d'employeur</td>
                                                    <td><span class="badge badge-success">Permanent</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Bulletins &amp; feuilles de paie</td>
                                                    <td><span class="badge badge-info">5 ans</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Contrats &amp; dossiers du personnel</td>
                                                    <td><span class="badge badge-info">5 ans après départ</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Déclarations INSS / OBR</td>
                                                    <td><span class="badge badge-info">10 ans</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="section-title mb-3"><i class="fas fa-layer-group mr-1"></i> Échelle
                                        disciplinaire</h6>
                                    <div class="param-card p-2 mb-2"><strong>1. Blâme verbal</strong></div>
                                    <div class="param-card p-2 mb-2"><strong>2. Avertissement écrit</strong></div>
                                    <div class="param-card p-2 mb-2"><strong>3. Blâme écrit</strong></div>
                                    <div class="param-card p-2 mb-2"><strong>4. Suspension 1 – 8 j</strong></div>
                                    <div class="param-card p-2 mb-2" style="border-left-color:#dc3545"><strong>5.
                                            Licenciement faute grave</strong></div>
                                    <small class="text-muted"><i class="fas fa-info-circle mr-1"></i>Chaque sanction :
                                        proportionnée, notifiée par écrit, précédée du droit d'être entendu.</small>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="section-title mb-3"><i class="fas fa-clipboard-check mr-1"></i> Critères
                                        d'évaluation &amp; poids</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <tbody>
                                                <tr>
                                                    <td>Performance du travail</td>
                                                    <td class="text-right"><span class="badge badge-success">30 %</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Compétences techniques</td>
                                                    <td class="text-right"><span class="badge badge-success">20 %</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Ponctualité &amp; assiduité</td>
                                                    <td class="text-right"><span class="badge badge-success">15 %</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Esprit d'équipe</td>
                                                    <td class="text-right"><span class="badge badge-success">15 %</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Initiative &amp; autonomie</td>
                                                    <td class="text-right"><span class="badge badge-success">10 %</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Règles &amp; sécurité</td>
                                                    <td class="text-right"><span class="badge badge-success">10 %</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="btn btn-default btn-sm"><i class="fas fa-edit mr-1"></i> Modifier les
                                        poids</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== ONGLET : UTILISATEURS & PERMISSIONS ===== -->
                    <div class="tab-pane fade" id="tabAcces">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h6 class="section-title mb-3"><i class="fas fa-users-cog mr-1"></i> Utilisateurs du
                                        module RH</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Utilisateur</th>
                                                    <th>Rôle</th>
                                                    <th>Statut</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Axcel IRUTAVYOSE</td>
                                                    <td><span class="badge badge-dark">Administrateur</span></td>
                                                    <td><span class="badge badge-success">Actif</span></td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>J.-M. NDAYIZEYE</td>
                                                    <td><span class="badge badge-success">Responsable RH</span></td>
                                                    <td><span class="badge badge-success">Actif</span></td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>D. IRAKOZE</td>
                                                    <td><span class="badge badge-info">Assistant RH</span></td>
                                                    <td><span class="badge badge-success">Actif</span></td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td>Th. NIMUBONA</td>
                                                    <td><span class="badge badge-warning">DAF (lecture + paie)</span>
                                                    </td>
                                                    <td><span class="badge badge-success">Actif</span></td>
                                                    <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                                class="fas fa-edit"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="btn btn-default btn-sm"><i class="fas fa-user-plus mr-1"></i> Ajouter
                                        un utilisateur</button>
                                </div>
                                <div class="col-lg-7">
                                    <h6 class="section-title mb-3"><i class="fas fa-key mr-1"></i> Matrice des
                                        permissions</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover text-nowrap text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Module</th>
                                                    <th>Resp. RH</th>
                                                    <th>Assistant RH</th>
                                                    <th>DAF</th>
                                                    <th>Chef de chantier</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-left">Employés &amp; registre</td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-eye text-info"></i></td>
                                                    <td><i class="fas fa-times-circle text-danger"></i></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Contrats &amp; mouvements</td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-eye text-info"></i></td>
                                                    <td><i class="fas fa-times-circle text-danger"></i></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Temps &amp; présences</td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-eye text-info"></i></td>
                                                    <td><i class="fas fa-edit text-warning"></i> saisie</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Congés</td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-eye text-info"></i></td>
                                                    <td><i class="fas fa-check-circle text-success"></i> approbation
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Paie</td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-times-circle text-danger"></i></td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-times-circle text-danger"></i></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Discipline &amp; évaluations</td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-eye text-info"></i></td>
                                                    <td><i class="fas fa-edit text-warning"></i> avis</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Rapports &amp; paramètres</td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-eye text-info"></i></td>
                                                    <td><i class="fas fa-check-circle text-success"></i></td>
                                                    <td><i class="fas fa-times-circle text-danger"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <small class="text-muted"><i class="fas fa-info-circle mr-1"></i><i
                                            class="fas fa-check-circle text-success mx-1"></i>accès complet · <i
                                            class="fas fa-eye text-info mx-1"></i>lecture seule · <i
                                            class="fas fa-edit text-warning mx-1"></i>saisie / avis · <i
                                            class="fas fa-times-circle text-danger mx-1"></i>aucun accès.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->