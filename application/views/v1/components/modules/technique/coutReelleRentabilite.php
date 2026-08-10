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

            <!-- ici le contenu de la page -->

            <!-- ============================================================ -->
            <!-- COÛT RÉEL & RENTABILITÉ                                      -->
            <!-- ============================================================ -->

            <!-- ---------- 1. TUILES DE SYNTHÈSE ---------- -->
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>780 M</h3>
                            <p>Budget prévisionnel total (BIF)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>664,5 M</h3>
                            <p>Coût réel total (BIF)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>14,8 %</h3>
                            <p>Rentabilité moyenne</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>1</h3>
                            <p>Chantier en dépassement</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>

            </div>

            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('error'); ?>
            </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('success'); ?>
            </div>
            <?php endif; ?>

            <!-- ---------- 2. ANALYSE PAR CHANTIER ---------- -->
            <div class="card card-outline card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-balance-scale mr-2"></i>
                        Analyse des coûts &amp; rentabilité par chantier
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-success">
                            <i class="fas fa-file-excel mr-1"></i>
                            Exporter
                        </button>
                        <button class="btn btn-sm btn-secondary">
                            <i class="fas fa-print mr-1"></i>
                            Imprimer
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    <!-- Filtres -->
                    <form action="#" method="get">
                        <div class="row mb-3">

                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label>Chantier</label>
                                    <select name="chantier" class="form-control">
                                        <option value="">Tous les chantiers</option>
                                        <!-- PLUS TARD : boucler sur $allChantiers -->
                                        <option value="1">Chantier Résidence Les Palmiers</option>
                                        <option value="2">Projet Immeuble SATRACO I</option>
                                        <option value="3">VRD Zone Nord – Phase 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label>Date début</label>
                                    <input type="date" name="date_debut" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label>Date fin</label>
                                    <input type="date" name="date_fin" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label>Statut</label>
                                    <select name="statut" class="form-control">
                                        <option value="">Tous les statuts</option>
                                        <option value="rentable">Rentable</option>
                                        <option value="surveiller">À surveiller</option>
                                        <option value="depassement">Dépassement</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <div class="btn-group btn-block">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-search mr-1"></i>
                                        Filtrer
                                    </button>
                                    <a href="#" class="btn btn-secondary" title="Réinitialiser les filtres">
                                        <i class="fas fa-redo-alt"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>

                    <!-- Tableau d'analyse -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:40px">#</th>
                                    <th style="width:200px">Chantier</th>
                                    <th style="width:130px" class="text-right">Budget prévisionnel</th>
                                    <th style="width:120px" class="text-right">Matériaux</th>
                                    <th style="width:120px" class="text-right">Main-d'œuvre</th>
                                    <th style="width:120px" class="text-right">Engins &amp; carb.</th>
                                    <th style="width:120px" class="text-right">Sous-traitance</th>
                                    <th style="width:130px" class="text-right">Coût réel total</th>
                                    <th style="width:120px" class="text-right">Écart</th>
                                    <th style="width:160px">Rentabilité</th>
                                    <th style="width:110px" class="text-center">Statut</th>
                                    <th style="width:100px" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- PLUS TARD : boucler sur $rentabiliteChantiers ici -->

                                <tr>
                                    <td>1</td>
                                    <td><strong>Chantier Résidence Les Palmiers</strong></td>
                                    <td class="text-right text-nowrap">250 000 000</td>
                                    <td class="text-right text-nowrap">98 550 000</td>
                                    <td class="text-right text-nowrap">42 300 000</td>
                                    <td class="text-right text-nowrap">18 700 000</td>
                                    <td class="text-right text-nowrap">35 000 000</td>
                                    <td class="text-right text-nowrap"><strong>194 550 000</strong></td>
                                    <td class="text-right text-nowrap text-success"><strong>+55 450 000</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 mr-2" style="height:6px;">
                                                <div class="progress-bar bg-success" style="width:22%"></div>
                                            </div>
                                            <strong>22,2 %</strong>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="badge badge-success">Rentable</span></td>
                                    <td class="text-center text-nowrap">
                                        <button class="btn btn-sm btn-info" title="Voir le détail" data-toggle="modal"
                                            data-target="#modalDetailCout"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-secondary" title="Imprimer"><i
                                                class="fas fa-print"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td><strong>Projet Immeuble SATRACO I</strong></td>
                                    <td class="text-right text-nowrap">180 000 000</td>
                                    <td class="text-right text-nowrap">86 400 000</td>
                                    <td class="text-right text-nowrap">38 000 000</td>
                                    <td class="text-right text-nowrap">17 000 000</td>
                                    <td class="text-right text-nowrap">30 000 000</td>
                                    <td class="text-right text-nowrap"><strong>171 400 000</strong></td>
                                    <td class="text-right text-nowrap text-success"><strong>+8 600 000</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 mr-2" style="height:6px;">
                                                <div class="progress-bar bg-warning" style="width:5%"></div>
                                            </div>
                                            <strong>4,8 %</strong>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="badge badge-warning">À surveiller</span></td>
                                    <td class="text-center text-nowrap">
                                        <button class="btn btn-sm btn-info" title="Voir le détail" data-toggle="modal"
                                            data-target="#modalDetailCout"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-secondary" title="Imprimer"><i
                                                class="fas fa-print"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td><strong>VRD Zone Nord – Phase 2</strong></td>
                                    <td class="text-right text-nowrap">95 000 000</td>
                                    <td class="text-right text-nowrap">45 250 000</td>
                                    <td class="text-right text-nowrap">18 000 000</td>
                                    <td class="text-right text-nowrap">28 000 000</td>
                                    <td class="text-right text-nowrap">10 000 000</td>
                                    <td class="text-right text-nowrap"><strong>101 250 000</strong></td>
                                    <td class="text-right text-nowrap text-danger"><strong>-6 250 000</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 mr-2" style="height:6px;">
                                                <div class="progress-bar bg-danger" style="width:7%"></div>
                                            </div>
                                            <strong class="text-danger">-6,6 %</strong>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="badge badge-danger">Dépassement</span></td>
                                    <td class="text-center text-nowrap">
                                        <button class="btn btn-sm btn-info" title="Voir le détail" data-toggle="modal"
                                            data-target="#modalDetailCout"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-secondary" title="Imprimer"><i
                                                class="fas fa-print"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td><strong>Chantier Miroir</strong></td>
                                    <td class="text-right text-nowrap">60 000 000</td>
                                    <td class="text-right text-nowrap">20 800 000</td>
                                    <td class="text-right text-nowrap">12 000 000</td>
                                    <td class="text-right text-nowrap">6 000 000</td>
                                    <td class="text-right text-nowrap">3 000 000</td>
                                    <td class="text-right text-nowrap"><strong>41 800 000</strong></td>
                                    <td class="text-right text-nowrap text-success"><strong>+18 200 000</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 mr-2" style="height:6px;">
                                                <div class="progress-bar bg-success" style="width:30%"></div>
                                            </div>
                                            <strong>30,3 %</strong>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="badge badge-success">Rentable</span></td>
                                    <td class="text-center text-nowrap">
                                        <button class="btn btn-sm btn-info" title="Voir le détail" data-toggle="modal"
                                            data-target="#modalDetailCout"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-secondary" title="Imprimer"><i
                                                class="fas fa-print"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td><strong>PROJET BLOC CIMENT</strong></td>
                                    <td class="text-right text-nowrap">120 000 000</td>
                                    <td class="text-right text-nowrap">44 600 000</td>
                                    <td class="text-right text-nowrap">15 000 000</td>
                                    <td class="text-right text-nowrap">20 000 000</td>
                                    <td class="text-right text-nowrap">5 000 000</td>
                                    <td class="text-right text-nowrap"><strong>84 600 000</strong></td>
                                    <td class="text-right text-nowrap text-success"><strong>+35 400 000</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 mr-2" style="height:6px;">
                                                <div class="progress-bar bg-success" style="width:29%"></div>
                                            </div>
                                            <strong>29,5 %</strong>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="badge badge-success">Rentable</span></td>
                                    <td class="text-center text-nowrap">
                                        <button class="btn btn-sm btn-info" title="Voir le détail" data-toggle="modal"
                                            data-target="#modalDetailCout"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-secondary" title="Imprimer"><i
                                                class="fas fa-print"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>6</td>
                                    <td><strong>PROJET PAVE</strong></td>
                                    <td class="text-right text-nowrap">75 000 000</td>
                                    <td class="text-right text-nowrap">33 900 000</td>
                                    <td class="text-right text-nowrap">14 000 000</td>
                                    <td class="text-right text-nowrap">18 000 000</td>
                                    <td class="text-right text-nowrap">5 000 000</td>
                                    <td class="text-right text-nowrap"><strong>70 900 000</strong></td>
                                    <td class="text-right text-nowrap text-success"><strong>+4 100 000</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 mr-2" style="height:6px;">
                                                <div class="progress-bar bg-warning" style="width:6%"></div>
                                            </div>
                                            <strong>5,5 %</strong>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="badge badge-warning">À surveiller</span></td>
                                    <td class="text-center text-nowrap">
                                        <button class="btn btn-sm btn-info" title="Voir le détail" data-toggle="modal"
                                            data-target="#modalDetailCout"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-secondary" title="Imprimer"><i
                                                class="fas fa-print"></i></button>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr class="bg-light">
                                    <th colspan="2" class="text-right">TOTAUX</th>
                                    <th class="text-right text-nowrap">780 000 000</th>
                                    <th class="text-right text-nowrap">329 500 000</th>
                                    <th class="text-right text-nowrap">139 300 000</th>
                                    <th class="text-right text-nowrap">107 700 000</th>
                                    <th class="text-right text-nowrap">88 000 000</th>
                                    <th class="text-right text-nowrap">664 500 000</th>
                                    <th class="text-right text-nowrap text-success">+115 500 000</th>
                                    <th colspan="3">Rentabilité globale : <strong>14,8 %</strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

                <div class="card-footer clearfix">
                    <div class="float-left">
                        <small class="text-muted">
                            Montants en BIF. Écart = Budget prévisionnel − Coût réel.
                        </small>
                    </div>
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </div>

            </div>

            <!-- ---------- 3. RÉPARTITION DU COÛT RÉEL GLOBAL ---------- -->
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Répartition du coût réel global
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="progress-group">
                                <span class="progress-text">Matériaux &amp; achats</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary" style="width:45%"></div>
                                </div>
                                <span class="text-muted small">329 500 000 BIF (45 %)</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="progress-group">
                                <span class="progress-text">Main-d'œuvre</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width:21%"></div>
                                </div>
                                <span class="text-muted small">139 300 000 BIF (21 %)</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="progress-group">
                                <span class="progress-text">Engins, maintenance &amp; carburant</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" style="width:16%"></div>
                                </div>
                                <span class="text-muted small">107 700 000 BIF (16 %)</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="progress-group">
                                <span class="progress-text">Sous-traitance</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger" style="width:13%"></div>
                                </div>
                                <span class="text-muted small">88 000 000 BIF (13 %)</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ---------- 4. MODALE : DÉTAIL RENTABILITÉ D'UN CHANTIER ---------- -->
            <div class="modal fade" id="modalDetailCout" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">

                        <div class="modal-header bg-info">
                            <h5 class="modal-title">
                                <i class="fas fa-balance-scale mr-2"></i>
                                Détail rentabilité — Chantier Résidence Les Palmiers
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <!-- Synthèse -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="alert alert-light border mb-2">
                                        <small class="text-muted d-block">Budget prévisionnel</small>
                                        <strong>250 000 000 BIF</strong>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-light border mb-2">
                                        <small class="text-muted d-block">Coût réel</small>
                                        <strong>194 550 000 BIF</strong>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-success mb-2">
                                        <small class="d-block">Écart</small>
                                        <strong>+55 450 000 BIF</strong>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-success mb-2">
                                        <small class="d-block">Rentabilité</small>
                                        <strong>22,2 %</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Détail par poste -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Poste de dépense</th>
                                            <th class="text-right">Budget</th>
                                            <th class="text-right">Coût réel</th>
                                            <th class="text-right">Écart</th>
                                            <th class="text-right">Taux de consommation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Matériaux &amp; achats</td>
                                            <td class="text-right text-nowrap">110 000 000</td>
                                            <td class="text-right text-nowrap">98 550 000</td>
                                            <td class="text-right text-nowrap text-success">+11 450 000</td>
                                            <td class="text-right">89,6 %</td>
                                        </tr>
                                        <tr>
                                            <td>Main-d'œuvre</td>
                                            <td class="text-right text-nowrap">48 000 000</td>
                                            <td class="text-right text-nowrap">42 300 000</td>
                                            <td class="text-right text-nowrap text-success">+5 700 000</td>
                                            <td class="text-right">88,1 %</td>
                                        </tr>
                                        <tr>
                                            <td>Engins, maintenance &amp; carburant</td>
                                            <td class="text-right text-nowrap">22 000 000</td>
                                            <td class="text-right text-nowrap">18 700 000</td>
                                            <td class="text-right text-nowrap text-success">+3 300 000</td>
                                            <td class="text-right">85,0 %</td>
                                        </tr>
                                        <tr>
                                            <td>Sous-traitance</td>
                                            <td class="text-right text-nowrap">40 000 000</td>
                                            <td class="text-right text-nowrap">35 000 000</td>
                                            <td class="text-right text-nowrap text-success">+5 000 000</td>
                                            <td class="text-right">87,5 %</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-right">TOTAL</th>
                                            <th class="text-right text-nowrap">250 000 000</th>
                                            <th class="text-right text-nowrap">194 550 000</th>
                                            <th class="text-right text-nowrap text-success">+55 450 000</th>
                                            <th class="text-right">77,8 %</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-info"><i class="fas fa-print mr-1"></i>
                                Imprimer</button>
                        </div>

                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->