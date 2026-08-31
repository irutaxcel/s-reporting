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

            <!-- ici le contenu de la page  -->

            <!-- ============ STYLE LOCAL (page conformité) ============ -->
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

            .legal-note {
                border-left: 4px solid #1f7a5c;
                background: #f8faf9;
            }

            .echeance-item {
                border-left: 3px solid #dee2e6;
            }

            .echeance-item.urgent {
                border-left-color: #dc3545;
            }

            .echeance-item.proche {
                border-left-color: #ffc107;
            }
            </style>

            <!-- ============ 1. INDICATEURS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-stamp"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Déclarations déposées (2026)</span>
                            <span class="info-box-number">14</span>
                            <span class="progress-description">OBR · INSS · OBEM · assurance maladie</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-calendar-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Échéances (30 jours)</span>
                            <span class="info-box-number">2</span>
                            <span class="progress-description">IPR OBR · assurance maladie</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">En retard / contentieux</span>
                            <span class="info-box-number">0</span>
                            <span class="progress-description">Aucune pénalité en cours</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-tasks"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Taux de conformité</span>
                            <span class="info-box-number">94 %</span>
                            <span class="progress-description">Checklist interne · août 2026</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. ÉCHÉANCIER + PROCHAINES ÉCHÉANCES ============ -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0"><i class="fas fa-landmark mr-1 text-success"></i> Échéancier des
                                déclarations obligatoires</h3>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#modalDeclaration">
                                <i class="fas fa-plus mr-1"></i> Encoder une déclaration
                            </button>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Organisme</th>
                                        <th>Objet</th>
                                        <th>Fréquence</th>
                                        <th>Prochaine échéance</th>
                                        <th>Statut</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>OBR</strong></td>
                                        <td>IPR — retenue à la source sur salaires</td>
                                        <td>Mensuelle</td>
                                        <td>10/09/2026 <span class="badge badge-warning ml-1">J-14</span></td>
                                        <td><span class="badge badge-warning">À déclarer</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-success">Générer</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Assurance maladie</strong></td>
                                        <td>Cotisation mensuelle (2,5 %)</td>
                                        <td>Mensuelle</td>
                                        <td>05/09/2026 <span class="badge badge-danger ml-1">J-9</span></td>
                                        <td><span class="badge badge-warning">À payer</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-success">Générer</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>INSS</strong></td>
                                        <td>Cotisations salariales 4 % + patronales 6 %</td>
                                        <td>Trimestrielle</td>
                                        <td>15/10/2026 <span class="badge badge-secondary ml-1">J-49</span></td>
                                        <td><span class="badge badge-info">En cours (alimentée par la paie)</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default">Détail</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>OBEM</strong></td>
                                        <td>Déclarations d'embauche / de sortie des travailleurs</td>
                                        <td>À chaque événement</td>
                                        <td>Continue</td>
                                        <td><span class="badge badge-success">À jour</span></td>
                                        <td class="text-right"><button
                                                class="btn btn-sm btn-default">Historique</button></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Inspection Générale du Travail</strong></td>
                                        <td>Présentation du registre du personnel &amp; textes d'application</td>
                                        <td>Sur réquisition</td>
                                        <td>—</td>
                                        <td><span class="badge badge-success">Prêt à présenter</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default">Registre</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>INSS</strong></td>
                                        <td>Affiliation des nouveaux employés</td>
                                        <td>À chaque embauche</td>
                                        <td>Continue</td>
                                        <td><span class="badge badge-success">À jour (100 %)</span></td>
                                        <td class="text-right"><button class="btn btn-sm btn-default">Liste</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-bell mr-1 text-warning"></i> Prochaines
                                échéances</h3>
                        </div>
                        <div class="card-body">
                            <div class="echeance-item urgent pl-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>Assurance maladie (août)</strong>
                                    <span class="badge badge-danger">J-9</span>
                                </div>
                                <small class="text-muted">05/09/2026 · ≈ 1 310 000 BIF</small>
                            </div>
                            <div class="echeance-item proche pl-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>OBR — IPR (août)</strong>
                                    <span class="badge badge-warning">J-14</span>
                                </div>
                                <small class="text-muted">10/09/2026 · ≈ 5 270 000 BIF</small>
                            </div>
                            <div class="echeance-item pl-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>INSS — T3 2026</strong>
                                    <span class="badge badge-secondary">J-49</span>
                                </div>
                                <small class="text-muted">15/10/2026 · ≈ 2 940 000 BIF</small>
                            </div>
                            <hr>
                            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Les montants sont repris
                                automatiquement de la feuille de paie du mois.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 3. HISTORIQUE DES DÉCLARATIONS ============ -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0"><i class="fas fa-history mr-1 text-success"></i> Historique des dépôts —
                        2026</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Organisme</th>
                                <th>Objet / période</th>
                                <th>Montant déclaré</th>
                                <th>Déposé le</th>
                                <th>N° reçu</th>
                                <th>Statut</th>
                                <th class="text-right">Pièce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>OBR</strong></td>
                                <td>IPR — Juillet 2026</td>
                                <td>5 180 000 BIF</td>
                                <td>08/08/2026</td>
                                <td>OBR-2026-08-1123</td>
                                <td><span class="badge badge-success">Déposée</span></td>
                                <td class="text-right"><button class="btn btn-sm btn-default"><i
                                            class="fas fa-receipt"></i></button></td>
                            </tr>
                            <tr>
                                <td><strong>Assurance maladie</strong></td>
                                <td>Cotisation — Juillet 2026</td>
                                <td>1 290 000 BIF</td>
                                <td>04/08/2026</td>
                                <td>AM-2026-07-0456</td>
                                <td><span class="badge badge-success">Payée</span></td>
                                <td class="text-right"><button class="btn btn-sm btn-default"><i
                                            class="fas fa-receipt"></i></button></td>
                            </tr>
                            <tr>
                                <td><strong>INSS</strong></td>
                                <td>Cotisations — T2 2026 (avr–juin)</td>
                                <td>2 910 000 BIF</td>
                                <td>10/07/2026</td>
                                <td>INSS-2026-0782</td>
                                <td><span class="badge badge-success">Payée</span></td>
                                <td class="text-right"><button class="btn btn-sm btn-default"><i
                                            class="fas fa-receipt"></i></button></td>
                            </tr>
                            <tr>
                                <td><strong>OBR</strong></td>
                                <td>IPR — Juin 2026</td>
                                <td>5 040 000 BIF</td>
                                <td>09/07/2026</td>
                                <td>OBR-2026-07-0987</td>
                                <td><span class="badge badge-success">Déposée</span></td>
                                <td class="text-right"><button class="btn btn-sm btn-default"><i
                                            class="fas fa-receipt"></i></button></td>
                            </tr>
                            <tr>
                                <td><strong>OBEM</strong></td>
                                <td>Déclaration annuelle des effectifs 2025</td>
                                <td>—</td>
                                <td>15/01/2026</td>
                                <td>OBEM-2026-0112</td>
                                <td><span class="badge badge-success">Déposée</span></td>
                                <td class="text-right"><button class="btn btn-sm btn-default"><i
                                            class="fas fa-receipt"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ============ 4. VEILLE RÉGLEMENTAIRE + CHECKLIST CONFORMITÉ ============ -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-book-open mr-1 text-success"></i> Textes
                                applicables &amp; veille réglementaire</h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-balance-scale mr-2 text-success"></i>
                                        <strong>Code du travail de la République du Burundi</strong>
                                        <small class="d-block text-muted">Révision 2020 — contrats, congés, registre,
                                            sanctions</small>
                                    </div>
                                    <button class="btn btn-sm btn-default"><i
                                            class="fas fa-file-pdf text-danger mr-1"></i>Consulter</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-building mr-2 text-success"></i>
                                        <strong>Règlement d'entreprise</strong>
                                        <small class="d-block text-muted">Version 2024 — affiché · horaires ·
                                            discipline</small>
                                    </div>
                                    <button class="btn btn-sm btn-default"><i
                                            class="fas fa-file-pdf text-danger mr-1"></i>Consulter</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-hand-holding-usd mr-2 text-success"></i>
                                        <strong>Barème IPR (OBR) en vigueur</strong>
                                        <small class="d-block text-muted">Barème progressif — mis à jour dans «
                                            Structure &amp; paramètres »</small>
                                    </div>
                                    <button class="btn btn-sm btn-default"><i
                                            class="fas fa-file-pdf text-danger mr-1"></i>Consulter</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-shield-alt mr-2 text-success"></i>
                                        <strong>Cotisations INSS — taux &amp; plafond</strong>
                                        <small class="d-block text-muted">Salarié 4 % · patronal 6 % · assiette
                                            plafonnée 450 000 BIF</small>
                                    </div>
                                    <button class="btn btn-sm btn-default"><i
                                            class="fas fa-file-pdf text-danger mr-1"></i>Consulter</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-briefcase mr-2 text-success"></i>
                                        <strong>OBEM — obligations déclaratives de l'employeur</strong>
                                        <small class="d-block text-muted">Embauches, sorties, effectifs annuels</small>
                                    </div>
                                    <button class="btn btn-sm btn-default"><i
                                            class="fas fa-file-pdf text-danger mr-1"></i>Consulter</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0"><i class="fas fa-tasks mr-1 text-success"></i> Checklist de
                                conformité interne</h3>
                            <span class="badge badge-info p-2">94 %</span>
                        </div>
                        <div class="card-body">
                            <p class="mb-1 d-flex justify-content-between"><span>Registre d'employeur à
                                    jour</span><strong class="text-success">100 %</strong></p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar bg-success" style="width:100%"></div>
                            </div>

                            <p class="mb-1 d-flex justify-content-between"><span>Affiliation INSS des
                                    employés</span><strong class="text-success">100 %</strong></p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar bg-success" style="width:100%"></div>
                            </div>

                            <p class="mb-1 d-flex justify-content-between"><span>Horaires &amp; règlement
                                    affichés</span><strong class="text-success">100 %</strong></p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar bg-success" style="width:100%"></div>
                            </div>

                            <p class="mb-1 d-flex justify-content-between"><span>Contrats signés &amp;
                                    archivés</span><strong class="text-warning">96 %</strong></p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar bg-warning" style="width:96%"></div>
                            </div>

                            <p class="mb-1 d-flex justify-content-between"><span>Mesures HSE / comité de
                                    sécurité</span><strong class="text-warning">75 %</strong></p>
                            <div class="progress mb-3" style="height:8px">
                                <div class="progress-bar bg-warning" style="width:75%"></div>
                            </div>

                            <div class="legal-note p-2 mt-3" style="font-size:.85rem">
                                <i class="fas fa-lightbulb mr-1 text-success"></i>
                                <strong>Prochain audit interne :</strong> septembre 2026 — points à corriger : archivage
                                de 2 contrats CDD et finalisation du plan HSE chantier Ngozi.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ MODALE : ENCODER UNE DÉCLARATION ============ -->
            <div class="modal fade" id="modalDeclaration">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h4 class="modal-title"><i class="fas fa-stamp mr-2"></i>Encoder une déclaration</h4>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"><label>Organisme *</label>
                                        <select class="form-control">
                                            <option>OBR — Impôts</option>
                                            <option>INSS</option>
                                            <option>OBEM</option>
                                            <option>Inspection Générale du Travail</option>
                                            <option>Assurance maladie</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Objet *</label>
                                        <input type="text" class="form-control"
                                            placeholder="Ex. : IPR — retenue à la source">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Période concernée *</label>
                                        <input type="month" class="form-control" value="2026-08">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Montant déclaré (BIF)</label>
                                        <input type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label>Date de dépôt *</label>
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>N° de reçu / quittance</label>
                                        <input type="text" class="form-control" placeholder="Ex. : OBR-2026-09-…">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label>Reçu / preuve de dépôt (PDF)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="fileRecu">
                                            <label class="custom-file-label" for="fileRecu">Choisir…</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group"><label>Observations</label>
                                        <textarea class="form-control" rows="2"
                                            placeholder="Remarques éventuelles…"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-success"><i class="fas fa-save mr-1"></i> Enregistrer
                                la déclaration</button>
                        </div>
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
                    });
                });
            });
            </script>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->