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

                .mini-stat {
                    border-left: 4px solid #1f7a5c;
                }
            </style>

            <!-- ============ 1. INDICATEURS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-file-contract"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Contrats actifs</span>
                            <span class="info-box-number">55</span>
                            <span class="progress-description">31 CDI · 22 CDD · 2 stages</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Expirent sous 30 jours</span>
                            <span class="info-box-number">5</span>
                            <span class="progress-description">À renouveler ou clôturer</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Périodes d'essai en cours</span>
                            <span class="info-box-number">3</span>
                            <span class="progress-description">Dont 1 se termine sous 60 j</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-exchange-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Mouvements (août 2026)</span>
                            <span class="info-box-number">+1 / −1</span>
                            <span class="progress-description">1 entrée · 1 sortie</span>
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
                                    class="badge badge-warning ml-1">5</span></a></li>
                    </ul>
                </div>

                <div class="tab-content">

                    <!-- ==================== ONGLET : CONTRATS ==================== -->
                    <div class="tab-pane fade active show" id="tabContrats">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap p-3 pb-0">
                                <div class="col-md-4 p-0">
                                    <div class="input-group">
                                        <input type="search" class="form-control"
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
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="avatar-initials mr-2"
                                                        style="background:#7a4f1f">AK</span>
                                                    <div>
                                                        <div class="font-weight-bold">Aymar KIGABIRO</div><small
                                                            class="text-muted">SAT-0008</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-success">CDI</span></td>
                                            <td>Designer</td>
                                            <td><i class="fas fa-building mr-1 text-muted"></i>Direction Générale</td>
                                            <td>01/08/2026 <small class="text-muted d-block">→ sans échéance</small>
                                            </td>
                                            <td><span class="badge badge-info">3 mois (en cours)</span></td>
                                            <td><span class="badge badge-success">Actif</span></td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-default" title="Avenant"><i
                                                        class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="avatar-initials mr-2"
                                                        style="background:#1f7a5c">JN</span>
                                                    <div>
                                                        <div class="font-weight-bold">Jean-Marie NDAYIZEYE</div><small
                                                            class="text-muted">SAT-0001</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-success">CDI</span></td>
                                            <td>Responsable RH &amp; Suivi-Évaluation</td>
                                            <td><i class="fas fa-building mr-1 text-muted"></i>Ressources Humaines</td>
                                            <td>02/03/2020 <small class="text-muted d-block">→ sans échéance</small>
                                            </td>
                                            <td><small class="text-muted">Validée (2020)</small></td>
                                            <td><span class="badge badge-success">Actif</span></td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-default" title="Avenant"><i
                                                        class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="avatar-initials mr-2"
                                                        style="background:#34608c">PH</span>
                                                    <div>
                                                        <div class="font-weight-bold">Patrick HAKIZIMANA</div><small
                                                            class="text-muted">SAT-0021</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-success">CDI</span></td>
                                            <td>Conducteur de travaux</td>
                                            <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngagara II</td>
                                            <td>10/01/2022 <small class="text-muted d-block">→ sans échéance</small>
                                            </td>
                                            <td><small class="text-muted">Validée (2022)</small></td>
                                            <td><span class="badge badge-success">Actif</span></td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-default" title="Avenant"><i
                                                        class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr class="table-warning">
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="avatar-initials mr-2"
                                                        style="background:#6c757d">JM</span>
                                                    <div>
                                                        <div class="font-weight-bold">Justine MBONIMPA</div><small
                                                            class="text-muted">SAT-0032</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-warning">CDD</span></td>
                                            <td>Peintre</td>
                                            <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngagara II</td>
                                            <td>19/02/2024 <small class="text-muted d-block">→ 20/08/2026</small></td>
                                            <td><small class="text-muted">Validée</small></td>
                                            <td><span class="badge badge-warning">Expire <strong>J-7</strong></span>
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-success" title="Renouveler"><i
                                                        class="fas fa-redo"></i></button>
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr class="table-warning">
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="avatar-initials mr-2"
                                                        style="background:#2c8a69">EN</span>
                                                    <div>
                                                        <div class="font-weight-bold">Egide NDUWIMANA</div><small
                                                            class="text-muted">SAT-0017</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-warning">CDD</span></td>
                                            <td>Dessinateur projeteur</td>
                                            <td><i class="fas fa-building mr-1 text-muted"></i>Direction Technique</td>
                                            <td>02/05/2023 <small class="text-muted d-block">→ 31/08/2026</small></td>
                                            <td><small class="text-muted">Validée</small></td>
                                            <td><span class="badge badge-warning">Expire <strong>J-18</strong></span>
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-success" title="Renouveler"><i
                                                        class="fas fa-redo"></i></button>
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr class="table-warning">
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="avatar-initials mr-2"
                                                        style="background:#34608c">CN</span>
                                                    <div>
                                                        <div class="font-weight-bold">Cédric NIYONGABO</div><small
                                                            class="text-muted">SAT-0041</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-warning">CDD</span></td>
                                            <td>Manœuvre</td>
                                            <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Gitega</td>
                                            <td>01/09/2025 <small class="text-muted d-block">→ 31/08/2026</small></td>
                                            <td><small class="text-muted">Validée</small></td>
                                            <td><span class="badge badge-warning">Expire <strong>J-18</strong></span>
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-success" title="Renouveler"><i
                                                        class="fas fa-redo"></i></button>
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr class="table-warning">
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="avatar-initials mr-2"
                                                        style="background:#8a3033">NI</span>
                                                    <div>
                                                        <div class="font-weight-bold">Nadia IRAKOZE</div><small
                                                            class="text-muted">SAT-0059</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-info">Stage</span></td>
                                            <td>Stagiaire RH</td>
                                            <td><i class="fas fa-building mr-1 text-muted"></i>Ressources Humaines</td>
                                            <td>02/02/2026 <small class="text-muted d-block">→ 31/08/2026</small></td>
                                            <td><small class="text-muted">Aucune</small></td>
                                            <td><span class="badge badge-warning">Expire <strong>J-18</strong></span>
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-success" title="Renouveler / embaucher"><i
                                                        class="fas fa-redo"></i></button>
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="avatar-initials mr-2"
                                                        style="background:#6c757d">PN</span>
                                                    <div>
                                                        <div class="font-weight-bold">Prisca NDABASHIMANA</div><small
                                                            class="text-muted">SAT-0062</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-warning">CDD</span></td>
                                            <td>Secrétaire de chantier</td>
                                            <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngozi</td>
                                            <td>09/09/2024 <small class="text-muted d-block">→ 08/09/2027</small></td>
                                            <td><small class="text-muted">Validée</small></td>
                                            <td><span class="badge badge-success">Actif</span></td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-default" title="Avenant"><i
                                                        class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="avatar-initials mr-2"
                                                        style="background:#6c757d">RM</span>
                                                    <div>
                                                        <div class="font-weight-bold">Robert MUGISHA</div><small
                                                            class="text-muted">SAT-0061</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-warning">CDD</span></td>
                                            <td>Maçon</td>
                                            <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngozi</td>
                                            <td>13/03/2023 <small class="text-muted d-block">→ 10/08/2026</small></td>
                                            <td><small class="text-muted">Validée</small></td>
                                            <td><span class="badge badge-secondary">Expiré</span></td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-default" title="Voir"><i
                                                        class="fas fa-eye"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <small class="text-muted float-left mt-2">Affichage de 1 à 9 sur 57 contrats</small>
                                <ul class="pagination pagination-sm float-right mb-0">
                                    <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== ONGLET : MOUVEMENTS ==================== -->
                    <div class="tab-pane fade" id="tabMouvements">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap p-3 pb-0">
                                <div>
                                    <span class="badge badge-success p-2 mr-1"><i class="fas fa-sign-in-alt mr-1"></i>
                                        Entrées (30 j) : 1</span>
                                    <span class="badge badge-secondary p-2 mr-1"><i
                                            class="fas fa-sign-out-alt mr-1"></i> Sorties (30 j) : 1</span>
                                    <span class="badge badge-info p-2"><i class="fas fa-random mr-1"></i> Internes (30
                                        j) : 1</span>
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
                                        <tr>
                                            <td><strong>10/08/2026</strong></td>
                                            <td>
                                                <div class="font-weight-bold">Robert MUGISHA</div><small
                                                    class="text-muted">SAT-0061</small>
                                            </td>
                                            <td><span class="badge badge-secondary">Fin de contrat</span></td>
                                            <td>CDD arrivé à échéance — non renouvelé</td>
                                            <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngozi</td>
                                            <td><small>J.-M. NDAYIZEYE</small></td>
                                        </tr>
                                        <tr>
                                            <td><strong>01/08/2026</strong></td>
                                            <td>
                                                <div class="font-weight-bold">Aymar KIGABIRO</div><small
                                                    class="text-muted">SAT-0008</small>
                                            </td>
                                            <td><span class="badge badge-success">Entrée</span></td>
                                            <td>Embauche CDI — Designer</td>
                                            <td><i class="fas fa-building mr-1 text-muted"></i>Direction Générale</td>
                                            <td><small>J.-M. NDAYIZEYE</small></td>
                                        </tr>
                                        <tr>
                                            <td><strong>01/06/2026</strong></td>
                                            <td>
                                                <div class="font-weight-bold">Patrick HAKIZIMANA</div><small
                                                    class="text-muted">SAT-0021</small>
                                            </td>
                                            <td><span class="badge badge-info">Promotion</span></td>
                                            <td>Chef d'équipe → Conducteur de travaux</td>
                                            <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngagara II</td>
                                            <td><small>J.-M. NDAYIZEYE</small></td>
                                        </tr>
                                        <tr>
                                            <td><strong>01/03/2026</strong></td>
                                            <td>
                                                <div class="font-weight-bold">Chantal UWIMANA</div><small
                                                    class="text-muted">SAT-0029</small>
                                            </td>
                                            <td><span class="badge badge-primary">Transfert</span></td>
                                            <td>Chantier Ngagara II → Direction Technique (HSE)</td>
                                            <td><i class="fas fa-building mr-1 text-muted"></i>Direction Technique</td>
                                            <td><small>J.-M. NDAYIZEYE</small></td>
                                        </tr>
                                        <tr>
                                            <td><strong>28/02/2026</strong></td>
                                            <td>
                                                <div class="font-weight-bold">Innocent NTAKARUTIMANA</div><small
                                                    class="text-muted">SAT-0005</small>
                                            </td>
                                            <td><span class="badge badge-warning">Démission</span></td>
                                            <td>Préavis presté du 01/01 au 28/02/2026</td>
                                            <td><i class="fas fa-building mr-1 text-muted"></i>DAF / Finance</td>
                                            <td><small>J.-M. NDAYIZEYE</small></td>
                                        </tr>
                                        <tr>
                                            <td><strong>31/01/2026</strong></td>
                                            <td>
                                                <div class="font-weight-bold">Gaspard NTEREKA</div><small
                                                    class="text-muted">SAT-0002</small>
                                            </td>
                                            <td><span class="badge badge-info">Retraite</span></td>
                                            <td>Départ à la retraite (60 ans) — solde de tout compte réglé</td>
                                            <td><i class="fas fa-building mr-1 text-muted"></i>Direction Technique</td>
                                            <td><small>J.-M. NDAYIZEYE</small></td>
                                        </tr>
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
                                        <tr>
                                            <td>Justine MBONIMPA <small class="text-muted">(SAT-0032)</small></td>
                                            <td><span class="badge badge-warning">CDD</span></td>
                                            <td>20/08/2026</td>
                                            <td><span class="badge badge-danger">J-7</span></td>
                                            <td>Renouvellement ou clôture + solde de tout compte</td>
                                            <td class="text-right"><button class="btn btn-sm btn-success"><i
                                                        class="fas fa-redo mr-1"></i>Renouveler</button></td>
                                        </tr>
                                        <tr>
                                            <td>Egide NDUWIMANA <small class="text-muted">(SAT-0017)</small></td>
                                            <td><span class="badge badge-warning">CDD</span></td>
                                            <td>31/08/2026</td>
                                            <td><span class="badge badge-warning">J-18</span></td>
                                            <td>Renouvellement (profil clé bureau d'études)</td>
                                            <td class="text-right"><button class="btn btn-sm btn-success"><i
                                                        class="fas fa-redo mr-1"></i>Renouveler</button></td>
                                        </tr>
                                        <tr>
                                            <td>Cédric NIYONGABO <small class="text-muted">(SAT-0041)</small></td>
                                            <td><span class="badge badge-warning">CDD</span></td>
                                            <td>31/08/2026</td>
                                            <td><span class="badge badge-warning">J-18</span></td>
                                            <td>Selon avancement du chantier Gitega</td>
                                            <td class="text-right"><button class="btn btn-sm btn-success"><i
                                                        class="fas fa-redo mr-1"></i>Renouveler</button></td>
                                        </tr>
                                        <tr>
                                            <td>Nadia IRAKOZE <small class="text-muted">(SAT-0059)</small></td>
                                            <td><span class="badge badge-info">Stage</span></td>
                                            <td>31/08/2026</td>
                                            <td><span class="badge badge-warning">J-18</span></td>
                                            <td>Fin de stage → évaluation + éventuelle embauche</td>
                                            <td class="text-right"><button class="btn btn-sm btn-success"><i
                                                        class="fas fa-user-plus mr-1"></i>Embaucher</button></td>
                                        </tr>
                                        <tr>
                                            <td>Didier SABUSHIMIKE <small class="text-muted">(SAT-0051)</small></td>
                                            <td><span class="badge badge-warning">CDD</span></td>
                                            <td>09/09/2026</td>
                                            <td><span class="badge badge-warning">J-27</span></td>
                                            <td>Renouvellement ou clôture</td>
                                            <td class="text-right"><button class="btn btn-sm btn-success"><i
                                                        class="fas fa-redo mr-1"></i>Renouveler</button></td>
                                        </tr>
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
                                        <tr>
                                            <td>Aymar KIGABIRO <small class="text-muted">(SAT-0008)</small></td>
                                            <td>01/08/2026</td>
                                            <td>01/11/2026</td>
                                            <td>Confirmation ou rupture de la période d'essai</td>
                                            <td class="text-right"><button class="btn btn-sm btn-default"><i
                                                        class="fas fa-clipboard-check mr-1"></i>Évaluer</button></td>
                                        </tr>
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
                                        <select class="form-control">
                                            <option>— Sélectionner —</option>
                                            <option>SAT-0008 · Aymar KIGABIRO</option>
                                            <option>SAT-0017 · Egide NDUWIMANA</option>
                                            <option>SAT-0032 · Justine MBONIMPA</option>
                                            <option>SAT-0041 · Cédric NIYONGABO</option>
                                            <option>SAT-0051 · Didier SABUSHIMIKE</option>
                                            <option>SAT-0059 · Nadia IRAKOZE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Opération *</label>
                                        <select class="form-control">
                                            <option>Nouveau contrat</option>
                                            <option>Renouvellement</option>
                                            <option>Avenant (modification)</option>
                                            <option>Transformation CDD → CDI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Type de contrat *</label>
                                        <select class="form-control">
                                            <option>CDI</option>
                                            <option>CDD</option>
                                            <option>Stage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Date de début *</label><input type="date"
                                            class="form-control"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Date de fin (si CDD/Stage)</label><input type="date"
                                            class="form-control"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Période d'essai</label>
                                        <select class="form-control">
                                            <option>Aucune</option>
                                            <option>3 mois</option>
                                            <option>6 mois</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Fonction *</label><input type="text"
                                            class="form-control"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Salaire de base (BIF) *</label><input type="number"
                                            class="form-control"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Affectation *</label>
                                        <select class="form-control">
                                            <option>Siège (Bujumbura)</option>
                                            <option>Chantier Ngagara II</option>
                                            <option>Chantier Gitega</option>
                                            <option>Chantier Ngozi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Contrat signé (PDF)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="fileContratSigne">
                                            <label class="custom-file-label" for="fileContratSigne">Choisir…</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group"><label>Observations</label><textarea class="form-control"
                                            rows="2"
                                            placeholder="Motif du renouvellement, conditions particulières…"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-success"><i class="fas fa-save mr-1"></i> Enregistrer
                                le contrat</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ MODALE : ENREGISTRER UN MOUVEMENT ============ -->
            <div class="modal fade" id="modalMouvement">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
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
                                        <select class="form-control">
                                            <option>— Sélectionner —</option>
                                            <option>SAT-0008 · Aymar KIGABIRO</option>
                                            <option>SAT-0021 · Patrick HAKIZIMANA</option>
                                            <option>SAT-0029 · Chantal UWIMANA</option>
                                            <option>SAT-0061 · Robert MUGISHA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Type de mouvement *</label>
                                        <select class="form-control">
                                            <option>Entrée (embauche)</option>
                                            <option>Démission</option>
                                            <option>Licenciement</option>
                                            <option>Fin de contrat</option>
                                            <option>Mise à la retraite</option>
                                            <option>Transfert (changement de site/département)</option>
                                            <option>Promotion</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Date d'effet *</label><input type="date"
                                            class="form-control"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Nouvelle affectation (si transfert/promotion)</label>
                                        <select class="form-control">
                                            <option>— Inchangée —</option>
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
                                            <input type="file" class="custom-file-input" id="fileJustificatif">
                                            <label class="custom-file-label" for="fileJustificatif">Choisir…</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group"><label>Motif / commentaire</label><textarea
                                            class="form-control" rows="2"
                                            placeholder="Ex. : lettre de démission reçue le…, fin de chantier…"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-success"><i class="fas fa-save mr-1"></i> Enregistrer
                                le mouvement</button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->