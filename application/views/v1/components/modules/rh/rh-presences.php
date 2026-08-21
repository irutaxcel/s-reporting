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

            <!-- ============ STYLE LOCAL (page temps & présences) ============ -->
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
            </style>

            <!-- ============ 1. INDICATEURS DU JOUR (vendredi 21/08/2026) ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Présents aujourd'hui</span>
                            <span class="info-box-number">48 / 55</span>
                            <span class="progress-description">
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width:87%"></div>
                                </div>
                                Taux de présence : 87 %
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-user-times"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Absents</span>
                            <span class="info-box-number">2</span>
                            <span class="progress-description">1 justifiée · 1 non justifiée</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Retards (mois)</span>
                            <span class="info-box-number">7</span>
                            <span class="progress-description">Dont 2 de plus de 30 min</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Heures sup (mois)</span>
                            <span class="info-box-number">26 h</span>
                            <span class="progress-description">À transmettre à la paie</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. TAUX DE PRÉSENCE PAR SITE + HORAIRES ============ -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-map-marker-alt mr-1 text-success"></i> Présence
                                par site (aujourd'hui)</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-1 d-flex justify-content-between"><span><i
                                        class="fas fa-building mr-1 text-muted"></i>Siège (Bujumbura)</span><strong>95
                                    %</strong></p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar bg-success" style="width:95%"></div>
                            </div>
                            <p class="mb-1 d-flex justify-content-between"><span><i
                                        class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngagara II</span><strong>92
                                    %</strong></p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar bg-success" style="width:92%"></div>
                            </div>
                            <p class="mb-1 d-flex justify-content-between"><span><i
                                        class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Gitega</span><strong>88
                                    %</strong></p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar bg-warning" style="width:88%"></div>
                            </div>
                            <p class="mb-1 d-flex justify-content-between"><span><i
                                        class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngozi</span><strong>90
                                    %</strong></p>
                            <div class="progress" style="height:8px">
                                <div class="progress-bar bg-success" style="width:90%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-business-time mr-1 text-success"></i> Horaires
                                de travail en vigueur</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4 border-right">
                                    <i class="fas fa-building fa-2x text-muted mb-2"></i>
                                    <p class="font-weight-bold mb-1">Bureau</p>
                                    <small class="text-muted">07h30 – 16h30<br>Lun → Ven · 40 h/sem</small>
                                </div>
                                <div class="col-md-4 border-right">
                                    <i class="fas fa-hard-hat fa-2x text-muted mb-2"></i>
                                    <p class="font-weight-bold mb-1">Chantiers</p>
                                    <small class="text-muted">07h00 – 17h00<br>Lun → Sam · pause 12h-13h</small>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-hourglass-half fa-2x text-muted mb-2"></i>
                                    <p class="font-weight-bold mb-1">Heures supplémentaires</p>
                                    <small class="text-muted">Au-delà de 40 h/sem<br>majorées selon Code du
                                        travail</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 3. ONGLETS POINTAGE ============ -->
            <div class="card">
                <div class="card-header p-2 px-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tabJour"><i
                                        class="fas fa-calendar-day mr-1"></i> Pointage du jour</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabAnomalies"><i
                                        class="fas fa-exclamation-circle mr-1"></i> Anomalies <span
                                        class="badge badge-danger ml-1">4</span></a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tabSynthese"><i
                                        class="fas fa-chart-bar mr-1"></i> Synthèse mensuelle</a></li>
                        </ul>
                        <div>
                            <button type="button" class="btn btn-default mr-2"><i class="fas fa-fingerprint mr-1"></i>
                                Importer badgeuse</button>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#modalPointage">
                                <i class="fas fa-user-clock mr-1"></i> Saisie / correction
                            </button>
                        </div>
                    </div>
                    <!-- Filtres -->
                    <div class="row mt-3">
                        <div class="col-md-3 mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i
                                            class="fas fa-calendar-alt"></i></span></div>
                                <input type="date" class="form-control" value="2026-08-21">
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-control">
                                <option>Site : tous</option>
                                <option>Siège (Bujumbura)</option>
                                <option>Chantier Ngagara II</option>
                                <option>Chantier Gitega</option>
                                <option>Chantier Ngozi</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-control">
                                <option>Situation : tous</option>
                                <option>Présent</option>
                                <option>Retard</option>
                                <option>Absent</option>
                                <option>En congé</option>
                                <option>Suspendu</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="input-group">
                                <input type="search" class="form-control" placeholder="Rechercher un employé…">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-search"></i></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-content">

                    <!-- ===== ONGLET : POINTAGE DU JOUR ===== -->
                    <div class="tab-pane fade active show" id="tabJour">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Affectation</th>
                                        <th>Entrée</th>
                                        <th>Sortie</th>
                                        <th>Heures travaillées</th>
                                        <th>Heures sup</th>
                                        <th>Situation</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                        <td><i class="fas fa-building mr-1 text-muted"></i>Ressources Humaines</td>
                                        <td><span class="badge badge-light border">07:58</span></td>
                                        <td><span class="badge badge-light border">17:02</span></td>
                                        <td>8 h 00</td>
                                        <td>—</td>
                                        <td><span class="badge badge-success">Présent</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                title="Corriger"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#7a4f1f">AK</span>
                                                <div>
                                                    <div class="font-weight-bold">Aymar KIGABIRO</div><small
                                                        class="text-muted">SAT-0008</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><i class="fas fa-building mr-1 text-muted"></i>Direction Générale</td>
                                        <td><span class="badge badge-warning">08:24</span></td>
                                        <td><span class="badge badge-light border">17:00</span></td>
                                        <td>7 h 36</td>
                                        <td>—</td>
                                        <td><span class="badge badge-warning">Retard +24 min</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                title="Corriger"><i class="fas fa-edit"></i></button></td>
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
                                        <td><i class="fas fa-building mr-1 text-muted"></i>DAF / Finance</td>
                                        <td><span class="badge badge-light border">07:55</span></td>
                                        <td><span class="badge badge-light border">17:00</span></td>
                                        <td>8 h 00</td>
                                        <td>—</td>
                                        <td><span class="badge badge-success">Présent</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                title="Corriger"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#34608c">PH</span>
                                                <div>
                                                    <div class="font-weight-bold">Patrick HAKIZIMANA</div><small
                                                        class="text-muted">SAT-0021</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngagara II</td>
                                        <td><span class="badge badge-light border">07:30</span></td>
                                        <td><span class="badge badge-light border">17:45</span></td>
                                        <td>9 h 15</td>
                                        <td><span class="badge badge-info">1 h 15</span></td>
                                        <td><span class="badge badge-success">Présent</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                title="Corriger"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#2c8a69">GR</span>
                                                <div>
                                                    <div class="font-weight-bold">Gilbert RUKARA</div><small
                                                        class="text-muted">SAT-0027</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngagara II</td>
                                        <td><span class="badge badge-light border">07:32</span></td>
                                        <td><span class="badge badge-danger">—</span></td>
                                        <td>—</td>
                                        <td>—</td>
                                        <td><span class="badge badge-danger">Sortie manquante</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                title="Corriger"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#6c757d">JM</span>
                                                <div>
                                                    <div class="font-weight-bold">Justine MBONIMPA</div><small
                                                        class="text-muted">SAT-0032</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngagara II</td>
                                        <td><span class="badge badge-danger">—</span></td>
                                        <td><span class="badge badge-danger">—</span></td>
                                        <td>—</td>
                                        <td>—</td>
                                        <td><span class="badge badge-danger">Absent non justifié</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                title="Corriger"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#34608c">CN</span>
                                                <div>
                                                    <div class="font-weight-bold">Cédric NIYONGABO</div><small
                                                        class="text-muted">SAT-0041</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Gitega</td>
                                        <td><span class="badge badge-light border">07:45</span></td>
                                        <td><span class="badge badge-light border">17:10</span></td>
                                        <td>8 h 25</td>
                                        <td>—</td>
                                        <td><span class="badge badge-success">Présent</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                title="Corriger"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#2c8a69">EI</span>
                                                <div>
                                                    <div class="font-weight-bold">Espérance INGABIRE</div><small
                                                        class="text-muted">SAT-0007</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><i class="fas fa-building mr-1 text-muted"></i>Direction Générale</td>
                                        <td colspan="3" class="text-muted"><small>Congé annuel (12/08 →
                                                21/08/2026)</small></td>
                                        <td>—</td>
                                        <td><span class="badge badge-info">En congé</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default" title="Voir"><i
                                                    class="fas fa-eye"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#8a3033">NI</span>
                                                <div>
                                                    <div class="font-weight-bold">Nadia IRAKOZE</div><small
                                                        class="text-muted">SAT-0059</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><i class="fas fa-building mr-1 text-muted"></i>Ressources Humaines</td>
                                        <td><span class="badge badge-light border">08:00</span></td>
                                        <td><span class="badge badge-light border">17:00</span></td>
                                        <td>8 h 00</td>
                                        <td>—</td>
                                        <td><span class="badge badge-success">Présent</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                title="Corriger"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#6c757d">PN</span>
                                                <div>
                                                    <div class="font-weight-bold">Prisca NDABASHIMANA</div><small
                                                        class="text-muted">SAT-0062</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><i class="fas fa-hard-hat mr-1 text-muted"></i>Chantier Ngozi</td>
                                        <td><span class="badge badge-light border">07:50</span></td>
                                        <td><span class="badge badge-light border">17:05</span></td>
                                        <td>8 h 15</td>
                                        <td>—</td>
                                        <td><span class="badge badge-success">Présent</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                title="Corriger"><i class="fas fa-edit"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <small class="text-muted float-left mt-2">Pointage du 21/08/2026 · 48 présents · 2 absents ·
                                3 congés · 2 suspendus</small>
                        </div>
                    </div>

                    <!-- ===== ONGLET : ANOMALIES ===== -->
                    <div class="tab-pane fade" id="tabAnomalies">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Employé</th>
                                        <th>Type d'anomalie</th>
                                        <th>Détail</th>
                                        <th class="text-right">Traitement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-danger">
                                        <td>21/08/2026</td>
                                        <td>Justine MBONIMPA <small class="text-muted">(SAT-0032)</small></td>
                                        <td><span class="badge badge-danger">Absence non justifiée</span></td>
                                        <td>Aucun pointage — sans nouvelle du chef de chantier</td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-success">Justifier</button>
                                            <button class="btn btn-sm btn-default">Signaler au RH</button>
                                        </td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>21/08/2026</td>
                                        <td>Gilbert RUKARA <small class="text-muted">(SAT-0027)</small></td>
                                        <td><span class="badge badge-warning">Sortie manquante</span></td>
                                        <td>Entrée 07:32 enregistrée, sortie non pointée</td>
                                        <td class="text-right"><button class="btn btn-sm btn-success">Corriger la
                                                sortie</button></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>21/08/2026</td>
                                        <td>Aymar KIGABIRO <small class="text-muted">(SAT-0008)</small></td>
                                        <td><span class="badge badge-warning">Retard 24 min</span></td>
                                        <td>Arrivée 08:24 (horaire 08:00)</td>
                                        <td class="text-right"><button class="btn btn-sm btn-success">Justifier</button>
                                        </td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>20/08/2026</td>
                                        <td>Divine NUNUBAHA <small class="text-muted">(SAT-0053)</small></td>
                                        <td><span class="badge badge-warning">Entrée manquante</span></td>
                                        <td>Sortie 17:00 enregistrée, entrée non pointée</td>
                                        <td class="text-right"><button class="btn btn-sm btn-success">Corriger
                                                l'entrée</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ===== ONGLET : SYNTHÈSE MENSUELLE ===== -->
                    <div class="tab-pane fade" id="tabSynthese">
                        <div class="d-flex justify-content-between align-items-center p-3 pb-0">
                            <h6 class="section-title mb-0">Synthèse — Août 2026 (17 jours ouvrés écoulés)</h6>
                            <button type="button" class="btn btn-success btn-sm"><i class="fas fa-share mr-1"></i>
                                Transmettre à la paie</button>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Employé</th>
                                        <th>Jours ouvrés</th>
                                        <th>Présents</th>
                                        <th>Retards</th>
                                        <th>Abs. justifiées</th>
                                        <th>Abs. non just.</th>
                                        <th>Heures sup</th>
                                        <th>Taux de présence</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jean-Marie NDAYIZEYE <small class="text-muted">(SAT-0001)</small></td>
                                        <td>17</td>
                                        <td>17</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0 h</td>
                                        <td><span class="badge badge-success">100 %</span></td>
                                    </tr>
                                    <tr>
                                        <td>Aymar KIGABIRO <small class="text-muted">(SAT-0008)</small></td>
                                        <td>14</td>
                                        <td>14</td>
                                        <td>2</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0 h</td>
                                        <td><span class="badge badge-success">100 %</span></td>
                                    </tr>
                                    <tr>
                                        <td>Patrick HAKIZIMANA <small class="text-muted">(SAT-0021)</small></td>
                                        <td>17</td>
                                        <td>17</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td><strong>12 h</strong></td>
                                        <td><span class="badge badge-success">100 %</span></td>
                                    </tr>
                                    <tr>
                                        <td>Justine MBONIMPA <small class="text-muted">(SAT-0032)</small></td>
                                        <td>17</td>
                                        <td>15</td>
                                        <td>0</td>
                                        <td>1</td>
                                        <td><strong>1</strong></td>
                                        <td>0 h</td>
                                        <td><span class="badge badge-warning">88 %</span></td>
                                    </tr>
                                    <tr>
                                        <td>Espérance INGABIRE <small class="text-muted">(SAT-0007)</small></td>
                                        <td>17</td>
                                        <td>9</td>
                                        <td>0</td>
                                        <td>8 (congés)</td>
                                        <td>0</td>
                                        <td>0 h</td>
                                        <td><span class="badge badge-info">Congé</span></td>
                                    </tr>
                                    <tr>
                                        <td>Gilbert RUKARA <small class="text-muted">(SAT-0027)</small></td>
                                        <td>17</td>
                                        <td>16</td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td><strong>6 h</strong></td>
                                        <td><span class="badge badge-success">94 %</span></td>
                                    </tr>
                                    <tr>
                                        <td>Cédric NIYONGABO <small class="text-muted">(SAT-0041)</small></td>
                                        <td>17</td>
                                        <td>17</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td><strong>8 h</strong></td>
                                        <td><span class="badge badge-success">100 %</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Les absences non
                                justifiées et les heures supplémentaires sont reprises automatiquement dans le calcul de
                                la paie du mois.</small>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============ MODALE : SAISIE / CORRECTION DE POINTAGE ============ -->
            <div class="modal fade" id="modalPointage">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h4 class="modal-title"><i class="fas fa-user-clock mr-2"></i>Saisie / correction de
                                pointage</h4>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"><label>Employé *</label>
                                        <select class="form-control">
                                            <option>— Sélectionner —</option>
                                            <option>SAT-0001 · Jean-Marie NDAYIZEYE</option>
                                            <option>SAT-0027 · Gilbert RUKARA</option>
                                            <option>SAT-0032 · Justine MBONIMPA</option>
                                            <option>SAT-0053 · Divine NUNUBAHA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Date *</label><input type="date" class="form-control"
                                            value="2026-08-21"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Heure d'entrée</label><input type="time"
                                            class="form-control" value="07:30"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Heure de sortie</label><input type="time"
                                            class="form-control" value="17:00"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Heures supplémentaires</label>
                                        <select class="form-control">
                                            <option>Aucune</option>
                                            <option>1 h</option>
                                            <option>2 h</option>
                                            <option>3 h</option>
                                            <option>4 h et +</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Situation</label>
                                        <select class="form-control">
                                            <option>Présent (journée complète)</option>
                                            <option>Demi-journée</option>
                                            <option>Retard</option>
                                            <option>Absence justifiée (maladie, mission…)</option>
                                            <option>Absence non justifiée</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Pièce justificative (certificat,
                                            autorisation…)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="fileJustifPointage">
                                            <label class="custom-file-label" for="fileJustifPointage">Choisir…</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group"><label>Motif / observation</label>
                                        <textarea class="form-control" rows="2"
                                            placeholder="Ex. : oubli de pointage confirmé par le chef de chantier…"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-success"><i class="fas fa-save mr-1"></i> Enregistrer
                                le pointage</button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->