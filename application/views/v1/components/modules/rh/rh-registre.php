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

            <!-- ============ STYLE LOCAL (page registre) ============ -->
            <style>
            .registre-table th {
                background: #f4f6f9;
                font-size: .82rem;
                text-transform: uppercase;
                letter-spacing: .02em;
            }

            .registre-table td {
                font-size: .9rem;
            }

            .section-title {
                color: #1f7a5c;
                font-weight: 700;
                border-bottom: 2px solid #e9ecef;
                padding-bottom: .4rem;
            }

            .legal-note {
                border-left: 4px solid #1f7a5c;
                background: #f8faf9;
            }

            .print-only {
                display: none;
            }

            @media print {
                .print-only {
                    display: block !important;
                }

                .no-print {
                    display: none !important;
                }

                .card {
                    border: 1px solid #000 !important;
                    box-shadow: none !important;
                }
            }
            </style>

            <!-- ============ 1. INDICATEURS DU REGISTRE ============ -->
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-book"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Inscrits au registre</span>
                            <span class="info-box-number">60</span>
                            <span class="progress-description">Depuis la création de l'entreprise</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">En service</span>
                            <span class="info-box-number">57</span>
                            <span class="progress-description">55 actifs · 2 en congé</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-user-minus"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sortis</span>
                            <span class="info-box-number">3</span>
                            <span class="progress-description">Démission · retraite · fin de contrat</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. IDENTITÉ DE L'EMPLOYEUR + RAPPEL LÉGAL ============ -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-building mr-1 text-success"></i> Identité de
                                l'employeur</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Raison sociale</p>
                                    <p class="font-weight-bold">SATRACO Construction (SATRACO)</p>
                                    <p class="mb-1 text-muted">Activité principale</p>
                                    <p class="font-weight-bold">Construction de bâtiments et travaux publics</p>
                                    <p class="mb-1 text-muted">Siège social</p>
                                    <p class="font-weight-bold">Avenue du Large, Bujumbura — Burundi</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">N° RCCM</p>
                                    <p class="font-weight-bold">RC/BSB/2019/B/0456</p>
                                    <p class="mb-1 text-muted">N° employeur INSS</p>
                                    <p class="font-weight-bold">E-10245</p>
                                    <p class="mb-1 text-muted">N° contribuable (OBR)</p>
                                    <p class="font-weight-bold">400 987 654</p>
                                    <p class="mb-1 text-muted">Représentant légal</p>
                                    <p class="font-weight-bold">La Direction Générale</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card legal-note">
                        <div class="card-body">
                            <h6 class="font-weight-bold mb-2"><i class="fas fa-balance-scale mr-1 text-success"></i>
                                Obligation légale</h6>
                            <p class="mb-2 text-justify" style="font-size:.88rem">
                                Conformément au <strong>Code du travail de la République du Burundi</strong> et à ses
                                mesures
                                d'application, tout employeur est tenu de tenir un <strong>registre du
                                    personnel</strong>
                                à jour, à présenter à toute réquisition de l'<strong>Inspection Générale du
                                    Travail</strong>
                                et de l'<strong>OBEM</strong>.
                            </p>
                            <ul class="mb-0 pl-3" style="font-size:.85rem">
                                <li>Inscrire tout travailleur dès son embauche ;</li>
                                <li>Mentionner les départs (motif + date) ;</li>
                                <li>Conserver sans suppression ni rature ;</li>
                                <li>Imprimer et faire viser périodiquement.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 3. REGISTRE DU PERSONNEL ============ -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="card-title mb-0"><i class="fas fa-book mr-1 text-success"></i> Registre du personnel
                        </h3>
                        <div class="no-print">
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-download mr-1"></i> Exporter
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-file-excel mr-2 text-success"></i>Excel</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-file-pdf mr-2 text-danger"></i>PDF</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" onclick="window.print()">
                                <i class="fas fa-print mr-1"></i> Imprimer le registre
                            </button>
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div class="row mt-3 no-print">
                        <div class="col-md-5 mb-2">
                            <div class="input-group">
                                <input type="search" class="form-control"
                                    placeholder="Rechercher (nom, matricule, CNID…)">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-search"></i></span></div>
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
                        <div class="col-md-2 mb-2">
                            <select class="form-control">
                                <option>Situation : tous</option>
                                <option>En service</option>
                                <option>Sorti</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-control">
                                <option>Catégorie : tous</option>
                                <option>Bureau</option>
                                <option>Chantier</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped text-nowrap registre-table">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Matricule</th>
                                <th>Nom &amp; prénoms</th>
                                <th>Sexe</th>
                                <th>Date de naissance</th>
                                <th>N° CNID</th>
                                <th>Fonction</th>
                                <th>Cat.</th>
                                <th>Affectation</th>
                                <th>Embauche</th>
                                <th>Contrat</th>
                                <th>N° INSS</th>
                                <th>Situation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><strong>SAT-0001</strong></td>
                                <td>NDAYIZEYE Jean-Marie</td>
                                <td>M</td>
                                <td>01/01/1985</td>
                                <td>1985010112345</td>
                                <td>Responsable RH &amp; Suivi-Évaluation</td>
                                <td>Bureau</td>
                                <td>Ressources Humaines</td>
                                <td>02/03/2020</td>
                                <td><span class="badge badge-success">CDI</span></td>
                                <td>102456</td>
                                <td><span class="badge badge-success">En service</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><strong>SAT-0002</strong></td>
                                <td>NTEREKA Gaspard</td>
                                <td>M</td>
                                <td>10/05/1966</td>
                                <td>1966051012201</td>
                                <td>Ingénieur génie civil</td>
                                <td>Bureau</td>
                                <td>Direction Technique</td>
                                <td>15/03/2019</td>
                                <td><span class="badge badge-success">CDI</span></td>
                                <td>100112</td>
                                <td><span class="badge badge-secondary">Sorti — retraite 31/01/2026</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><strong>SAT-0005</strong></td>
                                <td>NTAKARUTIMANA Innocent</td>
                                <td>M</td>
                                <td>22/09/1991</td>
                                <td>1991092212205</td>
                                <td>Assistant comptable</td>
                                <td>Bureau</td>
                                <td>DAF / Finance</td>
                                <td>07/10/2019</td>
                                <td><span class="badge badge-success">CDI</span></td>
                                <td>100145</td>
                                <td><span class="badge badge-secondary">Sorti — démission 28/02/2026</span></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><strong>SAT-0007</strong></td>
                                <td>INGABIRE Espérance</td>
                                <td>F</td>
                                <td>14/05/1990</td>
                                <td>1990051412346</td>
                                <td>Secrétaire de direction</td>
                                <td>Bureau</td>
                                <td>Direction Générale</td>
                                <td>03/02/2023</td>
                                <td><span class="badge badge-success">CDI</span></td>
                                <td>102890</td>
                                <td><span class="badge badge-success">En service</span></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><strong>SAT-0008</strong></td>
                                <td>KIGABIRO Aymar</td>
                                <td>M</td>
                                <td>03/07/1998</td>
                                <td>1998070312357</td>
                                <td>Designer</td>
                                <td>Bureau</td>
                                <td>Direction Générale</td>
                                <td>01/08/2026</td>
                                <td><span class="badge badge-success">CDI</span></td>
                                <td>103210</td>
                                <td><span class="badge badge-success">En service</span></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><strong>SAT-0014</strong></td>
                                <td>NIYONZIMA Alice</td>
                                <td>F</td>
                                <td>30/11/1992</td>
                                <td>1992113012214</td>
                                <td>Comptable senior</td>
                                <td>Bureau</td>
                                <td>DAF / Finance</td>
                                <td>15/06/2021</td>
                                <td><span class="badge badge-success">CDI</span></td>
                                <td>101780</td>
                                <td><span class="badge badge-success">En service</span></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><strong>SAT-0021</strong></td>
                                <td>HAKIZIMANA Patrick</td>
                                <td>M</td>
                                <td>08/03/1986</td>
                                <td>1986030812221</td>
                                <td>Conducteur de travaux</td>
                                <td>Chantier</td>
                                <td>Chantier Ngagara II</td>
                                <td>10/01/2022</td>
                                <td><span class="badge badge-success">CDI</span></td>
                                <td>102034</td>
                                <td><span class="badge badge-success">En service</span></td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><strong>SAT-0029</strong></td>
                                <td>UWIMANA Chantal</td>
                                <td>F</td>
                                <td>25/06/1993</td>
                                <td>1993062512229</td>
                                <td>Officier HSE</td>
                                <td>Bureau</td>
                                <td>Direction Technique</td>
                                <td>12/11/2021</td>
                                <td><span class="badge badge-success">CDI</span></td>
                                <td>101950</td>
                                <td><span class="badge badge-success">En service</span></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td><strong>SAT-0032</strong></td>
                                <td>MBONIMPA Justine</td>
                                <td>F</td>
                                <td>05/05/1996</td>
                                <td>1996050512324</td>
                                <td>Peintre</td>
                                <td>Chantier</td>
                                <td>Chantier Ngagara II</td>
                                <td>19/02/2024</td>
                                <td><span class="badge badge-warning">CDD</span></td>
                                <td>102660</td>
                                <td><span class="badge badge-success">En service</span></td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><strong>SAT-0041</strong></td>
                                <td>NIYONGABO Cédric</td>
                                <td>M</td>
                                <td>15/01/1997</td>
                                <td>1997011512333</td>
                                <td>Manœuvre</td>
                                <td>Chantier</td>
                                <td>Chantier Gitega</td>
                                <td>01/09/2025</td>
                                <td><span class="badge badge-warning">CDD</span></td>
                                <td>103005</td>
                                <td><span class="badge badge-success">En service</span></td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td><strong>SAT-0059</strong></td>
                                <td>IRAKOZE Nadia</td>
                                <td>F</td>
                                <td>09/09/1999</td>
                                <td>1999090912351</td>
                                <td>Stagiaire RH</td>
                                <td>Bureau</td>
                                <td>Ressources Humaines</td>
                                <td>02/02/2026</td>
                                <td><span class="badge badge-info">Stage</span></td>
                                <td>—</td>
                                <td><span class="badge badge-success">En service</span></td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td><strong>SAT-0061</strong></td>
                                <td>MUGISHA Robert</td>
                                <td>M</td>
                                <td>04/04/1992</td>
                                <td>1992040412353</td>
                                <td>Maçon</td>
                                <td>Chantier</td>
                                <td>Chantier Ngozi</td>
                                <td>13/03/2023</td>
                                <td><span class="badge badge-warning">CDD</span></td>
                                <td>102553</td>
                                <td><span class="badge badge-secondary">Sorti — fin de contrat 10/08/2026</span></td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td><strong>SAT-0062</strong></td>
                                <td>NDABASHIMANA Prisca</td>
                                <td>F</td>
                                <td>21/10/1995</td>
                                <td>1995102112354</td>
                                <td>Secrétaire de chantier</td>
                                <td>Bureau</td>
                                <td>Chantier Ngozi</td>
                                <td>09/09/2024</td>
                                <td><span class="badge badge-warning">CDD</span></td>
                                <td>102774</td>
                                <td><span class="badge badge-success">En service</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <small class="text-muted float-left mt-2">
                        Registre mis à jour le 21/08/2026 · Affichage de 1 à 13 sur 60 inscrits
                    </small>
                    <ul class="pagination pagination-sm float-right mb-0 no-print">
                        <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">…</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div>

            <!-- ============ 4. BLOC DE SIGNATURES (visible uniquement à l'impression) ============ -->
            <div class="print-only mt-4">
                <p class="mb-4">Fait à Bujumbura, le 21/08/2026</p>
                <div class="row text-center">
                    <div class="col-6">
                        <strong>Le Responsable RH</strong><br><br><br>
                        ______________________
                    </div>
                    <div class="col-6">
                        <strong>Pour la Direction Générale</strong><br><br><br>
                        ______________________
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->