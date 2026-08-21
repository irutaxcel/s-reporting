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

            <!-- ============ 1. INDICATEURS — PÉRIODE AOÛT 2026 ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-money-bill-wave"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Masse salariale brute</span>
                            <span class="info-box-number">52 400 000 <small>BIF</small></span>
                            <span class="progress-description">57 employés · août 2026</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-hand-holding-usd"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Net à payer</span>
                            <span class="info-box-number">46 150 000 <small>BIF</small></span>
                            <span class="progress-description">Virement · espèces · mobile money</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-minus-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Retenues salariales</span>
                            <span class="info-box-number">6 250 000 <small>BIF</small></span>
                            <span class="progress-description">INSS 4 % + IPR (barème OBR)</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Charges patronales</span>
                            <span class="info-box-number">3 140 000 <small>BIF</small></span>
                            <span class="progress-description">INSS 6 % + assurance maladie</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. CYCLE DE PAIE — AOÛT 2026 ============ -->
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-2 mb-2">
                            <span class="step-circle bg-success"><i class="fas fa-database"></i></span>
                            <div class="font-weight-bold mt-1" style="font-size:.85rem">1. Variables</div>
                            <small class="text-muted">Présences, HS, congés</small><br>
                            <span class="badge badge-success mt-1">Collecté · 20/08</span>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <span class="step-circle bg-success"><i class="fas fa-calculator"></i></span>
                            <div class="font-weight-bold mt-1" style="font-size:.85rem">2. Calcul</div>
                            <small class="text-muted">Brut → net</small><br>
                            <span class="badge badge-success mt-1">Terminé · 21/08</span>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <span class="step-circle bg-success"><i class="fas fa-user-check"></i></span>
                            <div class="font-weight-bold mt-1" style="font-size:.85rem">3. Contrôle RH</div>
                            <small class="text-muted">Vérification feuille</small><br>
                            <span class="badge badge-success mt-1">Validé · 21/08</span>
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
                            <small class="text-muted">Échéance 28/08</small><br>
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
                                        class="fas fa-calculator mr-1"></i> Période Août 2026</a></li>
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
                                        <td>Bureau</td>
                                        <td>1 850 000</td>
                                        <td>150 000</td>
                                        <td>—</td>
                                        <td><strong>2 000 000</strong></td>
                                        <td>18 000</td>
                                        <td>262 500</td>
                                        <td><strong class="text-success">1 719 500</strong></td>
                                        <td><span class="badge badge-info">Virement</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                data-toggle="modal" data-target="#modalBulletin"><i
                                                    class="fas fa-file-invoice"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#2c8a69">TN</span>
                                                <div>
                                                    <div class="font-weight-bold">Thierry NIMUBONA</div><small
                                                        class="text-muted">SAT-0009</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Bureau</td>
                                        <td>2 500 000</td>
                                        <td>200 000</td>
                                        <td>—</td>
                                        <td><strong>2 700 000</strong></td>
                                        <td>18 000</td>
                                        <td>372 500</td>
                                        <td><strong class="text-success">2 309 500</strong></td>
                                        <td><span class="badge badge-info">Virement</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                data-toggle="modal" data-target="#modalBulletin"><i
                                                    class="fas fa-file-invoice"></i></button></td>
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
                                        <td>Chantier</td>
                                        <td>1 400 000</td>
                                        <td>140 000</td>
                                        <td>45 000</td>
                                        <td><strong>1 585 000</strong></td>
                                        <td>18 000</td>
                                        <td>186 000</td>
                                        <td><strong class="text-success">1 381 000</strong></td>
                                        <td><span class="badge badge-info">Virement</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                data-toggle="modal" data-target="#modalBulletin"><i
                                                    class="fas fa-file-invoice"></i></button></td>
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
                                        <td>Bureau</td>
                                        <td>950 000</td>
                                        <td>80 000</td>
                                        <td>—</td>
                                        <td><strong>1 030 000</strong></td>
                                        <td>18 000</td>
                                        <td>92 000</td>
                                        <td><strong class="text-success">920 000</strong></td>
                                        <td><span class="badge badge-info">Virement</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                data-toggle="modal" data-target="#modalBulletin"><i
                                                    class="fas fa-file-invoice"></i></button></td>
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
                                        <td>Chantier</td>
                                        <td>900 000</td>
                                        <td>—</td>
                                        <td>60 000</td>
                                        <td><strong>960 000</strong></td>
                                        <td>18 000</td>
                                        <td>80 000</td>
                                        <td><strong class="text-success">862 000</strong></td>
                                        <td><span class="badge badge-info">Virement</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                data-toggle="modal" data-target="#modalBulletin"><i
                                                    class="fas fa-file-invoice"></i></button></td>
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
                                        <td>Bureau</td>
                                        <td>600 000</td>
                                        <td>—</td>
                                        <td>—</td>
                                        <td><strong>600 000</strong></td>
                                        <td>18 000</td>
                                        <td>30 000</td>
                                        <td><strong class="text-success">552 000</strong></td>
                                        <td><span class="badge badge-info">Virement</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                data-toggle="modal" data-target="#modalBulletin"><i
                                                    class="fas fa-file-invoice"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center"><span class="avatar-initials mr-2"
                                                    style="background:#7a4f1f">JM</span>
                                                <div>
                                                    <div class="font-weight-bold">Justine MBONIMPA</div><small
                                                        class="text-muted">SAT-0032</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Chantier</td>
                                        <td>500 000</td>
                                        <td>—</td>
                                        <td>30 000</td>
                                        <td><strong>530 000</strong></td>
                                        <td>18 000</td>
                                        <td>26 000</td>
                                        <td><strong class="text-success">486 000</strong></td>
                                        <td><span class="badge badge-warning">Mobile money</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                data-toggle="modal" data-target="#modalBulletin"><i
                                                    class="fas fa-file-invoice"></i></button></td>
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
                                        <td>Chantier</td>
                                        <td>300 000</td>
                                        <td>—</td>
                                        <td>—</td>
                                        <td><strong>300 000</strong></td>
                                        <td>12 000</td>
                                        <td>0</td>
                                        <td><strong class="text-success">288 000</strong></td>
                                        <td><span class="badge badge-secondary">Espèces</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                data-toggle="modal" data-target="#modalBulletin"><i
                                                    class="fas fa-file-invoice"></i></button></td>
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
                                        <td>Bureau</td>
                                        <td>200 000</td>
                                        <td>—</td>
                                        <td>—</td>
                                        <td><strong>200 000</strong></td>
                                        <td>8 000</td>
                                        <td>0</td>
                                        <td><strong class="text-success">192 000</strong></td>
                                        <td><span class="badge badge-secondary">Espèces</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default"
                                                data-toggle="modal" data-target="#modalBulletin"><i
                                                    class="fas fa-file-invoice"></i></button></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold" style="background:#f4f6f9">
                                        <td colspan="5" class="text-right">TOTAUX (57 employés) —</td>
                                        <td>52 400 000</td>
                                        <td>980 000</td>
                                        <td>5 270 000</td>
                                        <td class="text-success">46 150 000</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center">
                                <div class="col-4"><small class="text-muted">Virement bancaire</small><br><strong>42
                                        employés · 41 300 000 BIF</strong></div>
                                <div class="col-4"><small class="text-muted">Espèces (chantiers)</small><br><strong>12
                                        employés · 3 650 000 BIF</strong></div>
                                <div class="col-4"><small class="text-muted">Mobile money</small><br><strong>3 employés
                                        · 1 200 000 BIF</strong></div>
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
                                        <td>Août 2026</td>
                                        <td>5 270 000 BIF</td>
                                        <td>10/09/2026</td>
                                        <td><span class="badge badge-warning">À déclarer</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-success">Générer la
                                                déclaration</button></td>
                                    </tr>
                                    <tr>
                                        <td><strong>INSS</strong></td>
                                        <td>Cotisations (salariale 4 % + patronale 6 %)</td>
                                        <td>T3 2026 (juil–sept)</td>
                                        <td>≈ 2 940 000 BIF</td>
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
                                        <td>Août 2026</td>
                                        <td>1 310 000 BIF</td>
                                        <td>05/09/2026</td>
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

            <!-- ============ MODALE : BULLETIN DE PAIE ============ -->
            <div class="modal fade" id="modalBulletin">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h4 class="modal-title"><i class="fas fa-file-invoice mr-2"></i>Bulletin de paie — Août 2026
                            </h4>
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
                                    <strong>Jean-Marie NDAYIZEYE</strong> <span
                                        class="badge badge-success">SAT-0001</span><br>
                                    <small class="text-muted">
                                        Responsable RH &amp; Suivi-Évaluation<br>
                                        Matricule INSS : 102456 · CDI — Bureau
                                    </small>
                                </div>
                            </div>

                            <h6 class="section-title">Gains</h6>
                            <table class="table table-sm bulletin mb-2">
                                <tbody>
                                    <tr>
                                        <td>Salaire de base</td>
                                        <td class="text-right">1 850 000</td>
                                    </tr>
                                    <tr>
                                        <td>Allocation logement (10 %)</td>
                                        <td class="text-right">100 000</td>
                                    </tr>
                                    <tr>
                                        <td>Allocation transport</td>
                                        <td class="text-right">50 000</td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>SALAIRE BRUT</td>
                                        <td class="text-right">2 000 000</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h6 class="section-title">Retenues</h6>
                            <table class="table table-sm bulletin mb-2">
                                <tbody>
                                    <tr>
                                        <td>INSS salarié (4 % — assiette plafonnée)</td>
                                        <td class="text-right">18 000</td>
                                    </tr>
                                    <tr>
                                        <td>IPR (barème OBR)</td>
                                        <td class="text-right">262 500</td>
                                    </tr>
                                    <tr class="font-weight-bold">
                                        <td>TOTAL RETENUES</td>
                                        <td class="text-right">280 500</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="alert alert-success py-2 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>NET À PAYER</strong>
                                    <strong class="h5 mb-0">1 719 500 BIF</strong>
                                </div>
                                <small>Arrêté le présent bulletin à la somme de : <em>un million sept cent dix-neuf
                                        mille cinq cents francs burundais</em>.</small>
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