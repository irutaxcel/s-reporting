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
        size: A4 portrait;
        margin: 5mm 8mm;
    }

    body {
        font-family: 'Arial', sans-serif;
        font-size: 10px;
        line-height: 1.3;
        color: #000;
        background: #fff;
    }

    /* ✅ Boutons fixes en haut à droite */
    .print-actions {
        position: fixed;
        top: 15px;
        right: 20px;
        z-index: 9999;
        display: flex;
        gap: 8px;
    }

    .print-actions .btn-action {
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .print-actions .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .print-actions .btn-print {
        background: #28a745;
        color: white;
    }

    .print-actions .btn-print:hover {
        background: #218838;
    }

    .print-actions .btn-close {
        background: #dc3545;
        color: white;
    }

    .print-actions .btn-close:hover {
        background: #c82333;
    }

    /* ✅ En-tête compact */
    .print-header {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        margin-bottom: 5px;
        border-bottom: 2px solid #28a745;
        padding-bottom: 4px;
        page-break-after: avoid;
    }

    .print-header .logo-container img {
        max-width: 50px;
        max-height: 50px;
        object-fit: contain;
    }

    .print-header .header-text h1 {
        margin: 0;
        color: #28a745;
        font-size: 14px;
        text-transform: uppercase;
        text-align: left;
    }

    .print-header .header-text .company-info {
        margin-top: 1px;
        font-size: 8px;
        color: #666;
        text-align: left;
    }

    /* ✅ Section période ultra-compacte */
    .periode-info {
        background: #f8f9fa;
        padding: 4px 8px;
        border-radius: 2px;
        margin-bottom: 5px;
        border-left: 3px solid #28a745;
        page-break-after: avoid;
    }

    .periode-info h5 {
        margin: 0 0 1px 0;
        font-size: 10px;
        color: #28a745;
        font-weight: bold;
    }

    .periode-info p {
        margin: 0;
        font-size: 8px;
    }

    /* ✅ Statistiques masquées à l'impression */
    .statistics-box {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        page-break-inside: avoid;
    }

    .stat-item {
        flex: 1;
        padding: 6px;
        margin: 0 2px;
        border-radius: 3px;
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
        font-size: 12px;
        font-weight: bold;
    }

    .stat-item p {
        margin: 2px 0 0 0;
        font-size: 8px;
        text-transform: uppercase;
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

    /* ✅ Sections de chantier */
    .chantier-section {
        margin-bottom: 10px;
    }

    .chantier-header {
        background: #28a745;
        color: white;
        padding: 4px 8px;
        font-weight: bold;
        font-size: 10px;
        border-radius: 2px;
        margin-bottom: 3px;
        page-break-after: avoid;
    }

    /* ✅ Tableaux très compacts */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
        font-size: 9px;
        page-break-inside: auto;
    }

    .table th {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 3px 4px;
        text-align: left;
        font-weight: bold;
        font-size: 9px;
    }

    .table td {
        border: 1px solid #dee2e6;
        padding: 2px 4px;
        font-size: 9px;
        vertical-align: middle;
    }

    .table tr {
        page-break-inside: avoid;
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

    .text-left {
        text-align: left;
    }

    .badge {
        display: inline-block;
        padding: 2px 5px;
        border-radius: 2px;
        font-size: 8px;
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
        font-size: 10px;
    }

    .total-general {
        background: #dc3545;
        color: white;
        font-weight: bold;
        font-size: 11px;
        page-break-inside: avoid;
    }

    .total-general th,
    .total-general td {
        border-color: #dc3545;
        padding: 5px 4px;
    }

    /* ✅ Tableau récapitulatif */
    .recap-section {
        margin-top: 20px;
        page-break-inside: avoid;
    }

    .recap-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
        font-size: 10px;
    }

    .recap-table th {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 6px 8px;
        text-align: left;
        font-weight: bold;
        font-size: 10px;
    }

    .recap-table td {
        border: 1px solid #dee2e6;
        padding: 5px 8px;
        font-size: 10px;
        vertical-align: middle;
    }

    .recap-table tbody tr:nth-child(even) {
        background: #f8f9fa;
    }

    .recap-total {
        background: #d4edda;
        font-weight: bold;
        font-size: 11px;
    }

    .recap-total td {
        border: 2px solid #28a745;
        padding: 8px;
    }

    /* ✅ Signatures compactes */
    .signatures {
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        page-break-inside: avoid;
    }

    .signature-box {
        width: 45%;
        border-top: 2px solid #000;
        padding-top: 5px;
        text-align: center;
    }

    .signature-box p {
        margin: 2px 0;
        font-size: 9px;
    }

    /* ✅ Footer compact */
    .footer-print {
        margin-top: 10px;
        text-align: center;
        font-size: 8px;
        color: #666;
        border-top: 1px solid #dee2e6;
        padding-top: 5px;
    }

    /* Ligne pointillée pour saisie manuelle */
    .manual-input-line {
        display: block;
        height: 10px;
        border-bottom: 1px dotted #999;
        margin: 0 3px;
    }

    /* ✅ Masquer les boutons à l'impression */
    .no-print {
        display: none !important;
    }

    @media print {
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .no-print,
        .print-actions {
            display: none !important;
        }

        .chantier-section {
            page-break-inside: avoid;
        }

        @page {
            margin: 5mm 8mm;
        }
    }
    </style>
</head>

<body onload="window.print()">

    <!-- ✅ Boutons fixes en haut à droite -->
    <div class="print-actions">
        <button onclick="window.print();" class="btn-action btn-print" title="Imprimer">
            <i class="fas fa-print"></i> Imprimer
        </button>
        <button onclick="window.close();" class="btn-action btn-close" title="Fermer">
            <i class="fas fa-times"></i> Fermer
        </button>
    </div>

    <div class="no-print" style="position: fixed; top: 10px; right: 10px; z-index: 9999;">
        <button onclick="window.close(); return false;" class="btn btn-danger btn-sm">
            <i class="fas fa-times"></i> Fermer
        </button>
        <button onclick="window.print(); return false;" class="btn btn-success btn-sm ml-2">
            <i class="fas fa-print"></i> Imprimer
        </button>
    </div>

    <div class="container-fluid">
        <!-- En-tête -->
        <div class="print-header">
            <div class="logo-container">
                <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO Construction Logo"
                    onerror="this.style.display='none'">
            </div>
            <div class="header-text">
                <h1>SATRACO CONSTRUCTION</h1>
                <div class="company-info">
                    Construction Management System (CMS)<br>
                    Synthèse des demandes d'achat
                </div>
            </div>
        </div>

        <!-- Période -->
        <div class="periode-info">
            <h5><i class="fas fa-calendar-alt"></i> Période concernée</h5>
            <p><strong><?= $mois_annee ?></strong> | Du <?= date('d/m/Y', strtotime($filtre_date_debut)) ?> au
                <?= date('d/m/Y', strtotime($filtre_date_fin)) ?></p>
        </div>

        <!-- Statistiques (masquées à l'impression) -->
        <div class="statistics-box no-print">
            <div class="stat-item bg-primary">
                <h3><?= number_format($statistics['total_demande'], 0, ',', ' ') ?> BIF</h3>
                <p>Total Demandé</p>
            </div>
            <div class="stat-item bg-success">
                <h3><?= number_format($statistics['total_autorise'], 0, ',', ' ') ?> BIF</h3>
                <p>Total Autorisé</p>
            </div>
            <div class="stat-item bg-warning">
                <h3><?= number_format($statistics['ecart'], 0, ',', ' ') ?> BIF</h3>
                <p>Écart</p>
            </div>
            <div class="stat-item bg-info">
                <h3><?= $statistics['taux_autorisation'] ?>%</h3>
                <p>Taux d'autorisation</p>
            </div>
        </div>

        <!-- Calcul des totaux par chantier -->
        <?php
        $recap_chantiers = [];
        $total_general_demande = 0;
        $total_general_autorise = 0;

        foreach ($demandes_by_chantier as $chantier_name => $demandes) {
            $total_chantier_demande = 0;
            $total_chantier_autorise = 0;

            foreach ($demandes as $demande) {
                $items = $this->dg->getRequestItems($demande->request_id);
                foreach ($items as $item) {
                    $total_chantier_demande += $item->total_price;
                }
                $total_chantier_autorise += ($demande->montant_autorise ?? 0);
            }

            $recap_chantiers[] = [
                'name' => $chantier_name,
                'total_demande' => $total_chantier_demande,
                'total_autorise' => $total_chantier_autorise
            ];

            $total_general_demande += $total_chantier_demande;
            $total_general_autorise += $total_chantier_autorise;
        }
        ?>

        <!-- Tableaux par chantier -->
        <?php
        $chantier_number = 1;
        foreach ($demandes_by_chantier as $chantier_name => $demandes):
            $subtotal_demande = 0;
        ?>
        <div class="chantier-section">
            <div class="chantier-header">
                <i class="fas fa-hard-hat"></i> <?= $chantier_number ?>. <?= strtoupper($chantier_name) ?>
                <span style="float: right; font-weight: normal; font-size: 9px;">(<?= count($demandes) ?>
                    demande(s))</span>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 4%" class="text-center">N°</th>
                        <th style="width: 10%">N° DA</th>
                        <th style="width: 30%">Désignation</th>
                        <th style="width: 15%">Demandé Par</th>
                        <th style="width: 12%" class="text-right">Montant demandé</th>
                        <th style="width: 12%" class="text-right">Montant Autorisé</th>
                        <th style="width: 17%">Obs.</th>
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
                        ?>
                    <tr>
                        <td class="text-center"><strong><?= $item_number++ ?></strong></td>
                        <td>
                            <span class="badge badge-<?= $chantier_number % 2 == 0 ? 'success' : 'warning' ?>">
                                DA-2026-<?= str_pad($demande->request_id, 4, '0', STR_PAD_LEFT) ?>
                            </span>
                        </td>
                        <td><?= implode(', ', $designations) ?></td>
                        <td>
                            <strong><?= !empty($demande->demandeur_nom) ? $demande->demandeur_nom : ($demande->requested_by ?? $demande->buyer_name ?? '-') ?></strong>
                        </td>
                        <td class="text-right"><strong><?= number_format($total_items, 0, ',', ' ') ?></strong></td>
                        <td class="text-center">
                            <span class="manual-input-line"></span>
                        </td>
                        <td></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="sous-total">
                        <td colspan="4" class="text-right">Sous-Total (<?= ucfirst($chantier_name) ?>)</td>
                        <td class="text-right"><?= number_format($subtotal_demande, 0, ',', ' ') ?> BIF</td>
                        <td class="text-center">
                            <span class="manual-input-line"></span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php
            $chantier_number++;
        endforeach;
        ?>

        <!-- ============================================== -->
        <!-- TABLEAU RÉCAPITULATIF PAR CHANTIER             -->
        <!-- ============================================== -->
        <div class="recap-section">
            <div class="chantier-header" style="background: #007bff; margin-bottom: 10px;">
                <i class="fas fa-table"></i> TABLEAU RÉCAPITULATIF PAR CHANTIER
            </div>

            <table class="table recap-table">
                <thead>
                    <tr>
                        <th style="width: 5%" class="text-center">N°</th>
                        <th style="width: 50%">Désignation / Chantier</th>
                        <th style="width: 20%" class="text-right">Montant demandé (BIF)</th>
                        <th style="width: 20%" class="text-right">Montant Autorisé (BIF)</th>
                        <th style="width: 5%">Observation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recap_chantiers as $index => $chantier): ?>
                    <tr>
                        <td class="text-center"><strong><?= $index + 1 ?></strong></td>
                        <td><strong><?= strtoupper($chantier['name']) ?></strong></td>
                        <td class="text-right">
                            <strong><?= number_format($chantier['total_demande'], 0, ',', ' ') ?></strong>
                        </td>
                        <td class="text-right">
                            <span class="manual-input-line"></span>
                        </td>
                        <td></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="recap-total">
                        <td colspan="2" class="text-right"><strong>TOTAL GÉNÉRAL</strong></td>
                        <td class="text-right"><strong><?= number_format($total_general_demande, 0, ',', ' ') ?>
                                BIF</strong></td>
                        <td class="text-right">
                            <span class="manual-input-line"></span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
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

</body>

</html>