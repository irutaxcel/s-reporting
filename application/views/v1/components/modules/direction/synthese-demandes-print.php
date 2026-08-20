<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">

    <style>
    @page {
        size: A4 landscape;
        margin: 10mm;
    }

    body {
        font-family: 'Arial', sans-serif;
        font-size: 11px;
        line-height: 1.4;
        color: #000;
        background: #fff;
    }

    .print-header {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 3px solid #28a745;
        padding-bottom: 10px;
    }

    .print-header h1 {
        margin: 0;
        color: #28a745;
        font-size: 20px;
        text-transform: uppercase;
    }

    .print-header .company-info {
        margin-top: 5px;
        font-size: 10px;
        color: #666;
    }

    .periode-info {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        border-left: 4px solid #28a745;
    }

    .periode-info h5 {
        margin: 0 0 5px 0;
        font-size: 12px;
        color: #28a745;
    }

    .periode-info p {
        margin: 0;
        font-size: 10px;
    }

    .chantier-section {
        margin-bottom: 25px;
        page-break-inside: avoid;
    }

    .chantier-header {
        background: #28a745;
        color: white;
        padding: 8px 12px;
        font-weight: bold;
        font-size: 12px;
        border-radius: 3px;
        margin-bottom: 10px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .table th {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 8px;
        text-align: left;
        font-weight: bold;
        font-size: 10px;
    }

    .table td {
        border: 1px solid #dee2e6;
        padding: 6px 8px;
        font-size: 10px;
    }

    .table tr:nth-child(even) {
        background: #f8f9fa;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 9px;
        font-weight: bold;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .sous-total {
        background: #d4edda;
        font-weight: bold;
    }

    .total-general {
        background: #dc3545;
        color: white;
        font-weight: bold;
        font-size: 12px;
    }

    .total-general td {
        border-color: #dc3545;
    }

    .statistics-box {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        page-break-inside: avoid;
    }

    .stat-item {
        flex: 1;
        padding: 10px;
        margin: 0 5px;
        border-radius: 5px;
        text-align: center;
    }

    .stat-item:first-child {
        margin-left: 0;
    }

    .stat-item:last-child {
        margin-right: 0;
    }

    .stat-item h3 {
        margin: 0;
        font-size: 16px;
        font-weight: bold;
    }

    .stat-item p {
        margin: 5px 0 0 0;
        font-size: 9px;
    }

    .bg-primary {
        background: #007bff;
        color: white;
    }

    .bg-success {
        background: #28a745;
        color: white;
    }

    .bg-warning {
        background: #ffc107;
        color: #000;
    }

    .bg-info {
        background: #17a2b8;
        color: white;
    }

    .signatures {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
        page-break-inside: avoid;
    }

    .signature-box {
        width: 45%;
        border-top: 1px solid #000;
        padding-top: 5px;
        text-align: center;
    }

    .signature-box p {
        margin: 5px 0;
        font-size: 10px;
    }

    .footer-print {
        margin-top: 30px;
        text-align: center;
        font-size: 9px;
        color: #666;
        border-top: 1px solid #dee2e6;
        padding-top: 10px;
    }

    @media print {
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .no-print {
            display: none !important;
        }

        .chantier-section {
            page-break-inside: avoid;
        }

        @page {
            margin: 10mm;
        }
    }

    .print-header {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .print-header .logo-container img {
        max-width: 100px;
    }
    </style>
</head>

<body onload="window.print()">

    <!-- Bouton retour (caché à l'impression) -->
    <div class="no-print" style="position: fixed; top: 10px; right: 10px; z-index: 9999;">
        <button onclick="window.close(); return false;" class="btn btn-danger btn-sm">
            <i class="fas fa-times"></i> Fermer
        </button>
        <button onclick="window.print(); return false;" class="btn btn-success btn-sm ml-2">
            <i class="fas fa-print"></i> Imprimer
        </button>
    </div>

    <div class="container-fluid">
        <!-- En-tête avec logo à gauche -->
        <div class="print-header">
            <div class="logo-container">
                <!-- ✅ Remplacez le chemin par le vrai chemin de votre logo -->
                <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO Construction Logo"
                    onerror="this.style.display='none'">
            </div>
            <!-- <div class="header-text">
                <h1>SATRACO CONSTRUCTION</h1>
                <div class="company-info">
                    Construction Management System (CMS)<br>
                    Synthèse des demandes d'achat
                </div>
            </div> -->
        </div>

        <!-- Période -->
        <div class="periode-info">
            <h5><i class="fas fa-calendar-alt"></i> Période concernée</h5>
            <p><strong><?= $mois_annee ?></strong> | Du <?= date('d/m/Y', strtotime($filtre_date_debut)) ?> au
                <?= date('d/m/Y', strtotime($filtre_date_fin)) ?></p>
        </div>

        <!-- Statistiques globales -->
        <div class="statistics-box">
            <div class="stat-item bg-primary">
                <h3><?= number_format($statistics['total_demande'], 0, ',', ' ') ?> BIF</h3>
                <p>Total Demandé</p>
            </div>
            <div class="stat-item bg-success">
                <!-- <h3><?= number_format($statistics['total_autorise'], 0, ',', ' ') ?> BIF</h3> -->
                <p>Total Autorisé</p>
            </div>
            <div class="stat-item bg-warning">
                <!-- <h3><?= number_format($statistics['ecart'], 0, ',', ' ') ?> BIF</h3> -->
                <p>Écart</p>
            </div>
            <div class="stat-item bg-info">
                <!-- <h3><?= $statistics['taux_autorisation'] ?>%</h3> -->
                <p>Taux d'autorisation</p>
            </div>
        </div>

        <!-- Tableaux par chantier -->
        <?php
        $chantier_number = 1;
        foreach ($demandes_by_chantier as $chantier_name => $demandes):
            $subtotal_demande = 0;
            $subtotal_autorise = 0;
        ?>
        <div class="chantier-section">
            <div class="chantier-header">
                <i class="fas fa-hard-hat"></i> <?= $chantier_number ?>. <?= strtoupper($chantier_name) ?>
                <span style="float: right; font-weight: normal;">(<?= count($demandes) ?> demande(s))</span>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%" class="text-center">N°</th>
                        <th style="width: 12%">N° DA</th>
                        <th style="width: 40%">Désignation</th>
                        <th style="width: 15%" class="text-right">Montant demandé</th>
                        <th style="width: 15%" class="text-right">Montant Autorisé</th>
                        <th style="width: 8%" class="text-center">Statut</th>
                        <th style="width: 5%">Obs.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $item_number = 1;
                        foreach ($demandes as $demande):
                            $items = $this->dg->getRequestItems($demande->request_id);
                            $designations = [];
                            $total_items = 0;

                            foreach ($items as $item) {
                                $designation = $item->designation;
                                if ($item->technical_specs) {
                                    $designation .= ' (' . $item->technical_specs . ')';
                                }
                                $designations[] = $designation;
                                $total_items += $item->total_price;
                            }

                            $subtotal_demande += $total_items;
                            $montant_autorise = $demande->montant_autorise ?? 0;
                            $subtotal_autorise += $montant_autorise;
                        ?>
                    <tr>
                        <td class="text-center"><strong><?= $item_number++ ?></strong></td>
                        <td><span
                                class="badge badge-<?= $chantier_number % 2 == 0 ? 'success' : 'warning' ?>">DA-2026-<?= str_pad($demande->request_id, 4, '0', STR_PAD_LEFT) ?></span>
                        </td>
                        <td><?= implode(', ', $designations) ?></td>
                        <td class="text-right"><strong><?= number_format($total_items, 0, ',', ' ') ?></strong></td>
                        <!-- <td class="text-right">
                            <strong><?= $montant_autorise > 0 ? number_format($montant_autorise, 0, ',', ' ') : '-' ?></strong>
                        </td> -->
                        <td class="text-right">
                            <!-- ✅ LAISSER VIDE pour saisie manuelle -->
                            <strong style="color: #999;">-</strong>
                        </td>
                        <td class="text-center">
                            <?php if ($demande->payment_status == 'effectue'): ?>
                            <span class="badge badge-success"><i class="fas fa-check"></i> Effectué</span>
                            <?php else: ?>
                            <span class="badge badge-warning"><i class="fas fa-clock"></i> En attente</span>
                            <?php endif; ?>
                        </td>
                        <td>-</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="sous-total">
                        <td colspan="3" class="text-right">Sous-Total (<?= ucfirst($chantier_name) ?>)</td>
                        <td class="text-right"><?= number_format($subtotal_demande, 0, ',', ' ') ?> BIF</td>
                        <!-- <td class="text-right"><?= number_format($subtotal_autorise, 0, ',', ' ') ?> BIF</td> -->
                        <td class="text-right">
                            <!-- ✅ LAISSER VIDE pour saisie manuelle -->
                            <strong style="color: #999;">-</strong>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php $chantier_number++;
        endforeach; ?>

        <!-- Total Général -->
        <div class="chantier-section">
            <table class="table total-general">
                <thead>
                    <tr>
                        <th style="width: 50%" class="text-center">SYNTHÈSE GLOBALE</th>
                        <th class="text-center">Total Demandé</th>
                        <th class="text-center">Total Autorisé</th>
                        <th class="text-center">Écart</th>
                        <th class="text-center">Taux</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left pl-4">
                            <i class="fas fa-chart-pie"></i>
                            <strong><?= count($demandes_by_chantier) ?> chantiers / <?= count($demandes) ?>
                                demandes</strong>
                        </td>
                        <td class="text-right"><?= number_format($statistics['total_demande'], 0, ',', ' ') ?> BIF</td>
                        <td class="text-right"><?= number_format($statistics['total_autorise'], 0, ',', ' ') ?> BIF</td>
                        <td class="text-right"><?= number_format($statistics['ecart'], 0, ',', ' ') ?> BIF</td>
                        <td class="text-center"><?= $statistics['taux_autorisation'] ?>%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="signature-box">
                <p><strong>Établi par</strong></p>
                <p><?= $this->session->userdata('username') ?? 'Responsable' ?></p>
                <p>Date : <?= date('d/m/Y') ?></p>
            </div>
            <div class="signature-box">
                <p><strong>Validé par la Direction Générale</strong></p>
                <p>Directeur Général</p>
                <p>Date : ___ / ___ / 2026</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-print">
            <p>© <?= date('Y') ?> SATRACO Construction - Document généré le <?= date('d/m/Y à H:i') ?></p>
            <p>Construction Management System (CMS) v1.0.0</p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
    // Auto-impression au chargement (optionnel)
    // setTimeout(function() { window.print(); }, 500);

    // Fermeture automatique après impression
    window.onafterprint = function() {
        // Optionnel: fermer la fenêtre après impression
        // window.close();
    };
    </script>
</body>

</html>