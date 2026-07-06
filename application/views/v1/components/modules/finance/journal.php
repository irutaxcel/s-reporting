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

            <!-- ici le contenu de la page journal -->

            <style>
            .report-box {
                background: #fff;
                border-radius: 14px;
                border: 1px solid #e5e7eb;
                overflow: hidden;
            }

            .report-header {
                padding: 18px 20px;
                border-bottom: 2px solid #102033;
                background: #f8fafc;
            }

            .report-title {
                font-size: 20px;
                font-weight: 800;
                color: #102033;
                margin-bottom: 4px;
            }

            .report-subtitle {
                font-size: 13px;
                color: #64748b;
            }

            .report-meta {
                font-size: 13px;
                color: #334155;
                line-height: 1.8;
            }

            .journal-report-table thead th {
                background: #102033;
                color: #fff;
                font-size: 12px;
                text-transform: uppercase;
                padding: 12px 10px;
                white-space: nowrap;
                border: none;
            }

            .journal-report-table tbody td {
                padding: 11px 10px;
                vertical-align: middle;
                font-size: 13px;
                border-bottom: 1px solid #e5e7eb;
            }

            .journal-report-table tfoot td {
                background: #f1f5f9;
                font-weight: 800;
                padding: 13px 10px;
                border-top: 2px solid #102033;
            }

            .report-piece {
                background: #ecfdf5;
                color: #0f766e;
                border-radius: 20px;
                padding: 6px 10px;
                font-weight: 800;
                display: inline-block;
            }

            .journal-badge {
                background: #dbeafe;
                color: #1d4ed8;
                border-radius: 20px;
                padding: 6px 10px;
                font-weight: 700;
            }

            .status-draft {
                background: #fef3c7;
                color: #92400e;
                border-radius: 20px;
                padding: 6px 10px;
                font-weight: 700;
            }

            .status-validated {
                background: #dcfce7;
                color: #166534;
                border-radius: 20px;
                padding: 6px 10px;
                font-weight: 700;
            }

            .report-actions .btn {
                width: 32px;
                height: 32px;
                padding: 0;
                margin: 1px;
            }

            .report-signature {
                border-top: 1px solid #e5e7eb;
                padding: 25px 20px;
                background: #fff;
            }

            .signature-line {
                border-top: 1px solid #111827;
                width: 220px;
                margin-top: 45px;
                padding-top: 6px;
                font-weight: 700;
            }

            @media print {

                .main-sidebar,
                .main-header,
                .content-header,
                .btn,
                .no-print,
                footer {
                    display: none !important;
                }

                .content-wrapper {
                    margin-left: 0 !important;
                }

                .report-box {
                    box-shadow: none;
                    border: none;
                }
            }
            </style>

            <div class="report-box mb-4">

                <div class="report-header">
                    <div class="row align-items-center">

                        <div class="col-md-8">
                            <div class="report-title">
                                <i class="fas fa-book mr-2 text-success"></i>
                                Rapport du Journal Comptable
                            </div>

                            <div class="report-subtitle">
                                Liste chronologique des écritures comptables enregistrées dans le système SATRACO.
                            </div>
                        </div>

                        <div class="col-md-4 text-right report-meta">
                            <strong>SATRACO Construction</strong><br>
                            Exercice : 2026<br>
                            Généré le : <?= date('d/m/Y H:i') ?>
                        </div>

                    </div>
                </div>

                <div class="p-3 bg-white border-bottom">
                    <div class="row text-center">

                        <div class="col-md-3">
                            <strong>Écritures trouvées</strong><br>
                            <span class="text-success">20</span>
                        </div>

                        <div class="col-md-3">
                            <strong>Total débit</strong><br>
                            <span>9 416 000 FBU</span>
                        </div>

                        <div class="col-md-3">
                            <strong>Total crédit</strong><br>
                            <span>9 416 000 FBU</span>
                        </div>

                        <div class="col-md-3">
                            <strong>Total TVA</strong><br>
                            <span>1 694 880 FBU</span>
                        </div>

                    </div>
                </div>

                <div class="p-3 no-print">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <strong>Période :</strong>
                            du 01/07/2026 au 10/07/2026
                        </div>

                        <div>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-file-excel mr-1"></i> Excel
                            </button>

                            <button class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-file-pdf mr-1"></i> PDF
                            </button>

                            <button class="btn btn-outline-dark btn-sm" onclick="window.print()">
                                <i class="fas fa-print mr-1"></i> Imprimer
                            </button>
                        </div>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table journal-report-table mb-0">

                        <thead>
                            <tr>
                                <th>Pièce</th>
                                <th>Date</th>
                                <th>Journal</th>
                                <th>Référence</th>
                                <th>Libellé</th>
                                <th>Chantier</th>
                                <th class="text-right">Débit</th>
                                <th class="text-right">Crédit</th>
                                <th class="text-right">TVA</th>
                                <th>Statut</th>
                                <th class="text-center no-print">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td><span class="report-piece">PC-2026-0001</span></td>
                                <td>01/07/2026</td>
                                <td><span class="journal-badge">CAI</span></td>
                                <td>ACH-001</td>
                                <td>
                                    <strong>Achat matériaux chantier Gitega</strong><br>
                                    <small class="text-muted">Ciment, carburant et frais chantier</small>
                                </td>
                                <td>Chantier Gitega</td>
                                <td class="text-right font-weight-bold">500 000,00</td>
                                <td class="text-right font-weight-bold">500 000,00</td>
                                <td class="text-right">90 000,00</td>
                                <td><span class="status-draft">Brouillon</span></td>
                                <td class="text-center report-actions no-print">
                                    <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="report-piece">PC-2026-0002</span></td>
                                <td>01/07/2026</td>
                                <td><span class="journal-badge">BAN</span></td>
                                <td>BNQ-001</td>
                                <td>
                                    <strong>Paiement fournisseur</strong><br>
                                    <small class="text-muted">Paiement matériaux, carburant et transport</small>
                                </td>
                                <td>Kabezi</td>
                                <td class="text-right font-weight-bold">350 000,00</td>
                                <td class="text-right font-weight-bold">350 000,00</td>
                                <td class="text-right">63 000,00</td>
                                <td><span class="status-validated">Validée</span></td>
                                <td class="text-center report-actions no-print">
                                    <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="report-piece">PC-2026-0003</span></td>
                                <td>02/07/2026</td>
                                <td><span class="journal-badge">VEN</span></td>
                                <td>VEN-001</td>
                                <td>
                                    <strong>Facturation client</strong><br>
                                    <small class="text-muted">Travaux réalisés et prestations</small>
                                </td>
                                <td>Avenant</td>
                                <td class="text-right font-weight-bold">800 000,00</td>
                                <td class="text-right font-weight-bold">800 000,00</td>
                                <td class="text-right">144 000,00</td>
                                <td><span class="status-validated">Validée</span></td>
                                <td class="text-center report-actions no-print">
                                    <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></button>
                                </td>
                            </tr>

                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-right">TOTAL GÉNÉRAL</td>
                                <td class="text-right">9 416 000,00</td>
                                <td class="text-right">9 416 000,00</td>
                                <td class="text-right">1 694 880,00</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>

                <div class="report-signature">
                    <div class="row">

                        <div class="col-md-4">
                            <strong>Préparé par :</strong>
                            <div class="signature-line">Comptable</div>
                        </div>

                        <div class="col-md-4">
                            <strong>Vérifié par :</strong>
                            <div class="signature-line">Chef comptable</div>
                        </div>

                        <div class="col-md-4">
                            <strong>Validé par :</strong>
                            <div class="signature-line">DAF</div>
                        </div>

                    </div>
                </div>

            </div>



        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->