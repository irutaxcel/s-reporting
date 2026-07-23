<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Demande d'achat - Impression</title>

    <style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        color: #222;
        background: #f4f6f9;
        margin: 0;
        padding: 10px;
        font-size: 14px;
    }

    .print-page {
        width: 210mm;
        min-height: 297mm;
        margin: auto;
        background: #fff;
        padding: 12mm 14mm;
        border: 1px solid #ddd;
    }

    .print-actions {
        width: 210mm;
        margin: 0 auto 8px auto;
        text-align: right;
    }

    .btn-print,
    .btn-back {
        border: none;
        padding: 7px 14px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        color: #fff;
        font-size: 14px;
        text-decoration: none;
    }

    .btn-print {
        background: #0f766e;
    }

    .btn-back {
        background: #6c757d;
        margin-right: 5px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px solid #0f766e;
        padding-bottom: 10px;
        margin-bottom: 14px;
    }

    .company-left {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .logo-box {
        width: 65px;
        height: 65px;
        border: 1px solid #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-box img {
        width: 58px;
        height: 58px;
        object-fit: contain;
    }

    .company-title h2 {
        margin: 0;
        color: #0f766e;
        font-size: 18px;
        text-transform: uppercase;
    }

    .company-title p {
        margin: 3px 0 0 0;
        color: #555;
        font-size: 14px;
    }

    .company-info {
        text-align: right;
        font-size: 11px;
        line-height: 1.45;
    }

    .document-title {
        text-align: center;
        margin: 14px 0 16px;
    }

    .document-title h1 {
        display: inline-block;
        margin: 0;
        padding: 7px 28px;
        border: 2px solid #0f766e;
        color: #0f766e;
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 7px 22px;
        margin-bottom: 12px;
    }

    .info-item {
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
    }

    .info-label {
        font-weight: bold;
        color: #0f766e;
        display: inline-block;
        width: 110px;
    }

    .validation-box {
        margin: 10px 0 12px 0;
        border: 1px solid #ddd;
        padding: 9px;
        background: #f9fafb;
    }

    .validation-title {
        font-weight: bold;
        color: #0f766e;
        margin-bottom: 7px;
        text-transform: uppercase;
    }

    .validation-row {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .validation-badge {
        border: 1px solid #ccc;
        padding: 4px 7px;
        border-radius: 4px;
        background: #fff;
        font-size: 11px;
    }

    .validated {
        background: #e9f7ef;
        border-color: #28a745;
        color: #155724;
        font-weight: bold;
    }

    .pending {
        background: #fff3cd;
        border-color: #ffc107;
        color: #856404;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
        font-size: 11.5px;
    }

    table th {
        background: #fff;
        color: #102033;
        padding: 6px;
        border: 1px solid #102033;
    }

    table td {
        border: 1px solid #ccc;
        padding: 5px 6px;
        vertical-align: middle;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .total-row td {
        font-weight: bold;
        background: #f1f5f9;
        font-size: 14px;
    }

    .signature-section {
        margin-top: 25px;
    }

    .signature-title {
        font-size: 13px;
        font-weight: bold;
        color: #0f766e;
        margin-bottom: 12px;
        text-transform: uppercase;
    }



    .signature-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .signature-box {
        border: 1px solid #cfcfcf;
        height: 140px;
        padding: 10px;
        position: relative;
        background: #fff;
    }

    .signature-box .title {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .signature {
        position: absolute;
        left: 10px;
        right: 10px;
        bottom: 12px;
    }

    .signature hr {
        margin: 0;
        border: none;
        border-top: 1px solid #444;
    }

    .signature span {
        display: block;
        text-align: center;
        margin-top: 4px;
        font-size: 10px;
        color: #666;
    }

    .signature-box .name {
        font-size: 11px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .signature-box .function {
        font-size: 11px;
        color: #444;
        line-height: 18px;
    }

    .signature-box .signature {
        position: absolute;
        left: 10px;
        right: 10px;
        bottom: 15px;
        text-align: center;
    }

    .signature-box .signature hr {
        border: none;
        border-top: 1px solid #444;
        margin-bottom: 3px;
    }

    .signature-box .signature span {
        font-size: 8px;
        color: #777;
    }

    .footer {
        margin-top: 18px;
        border-top: 2px solid #0f766e;
        padding-top: 8px;
        font-size: 10px;
        color: #555;
        text-align: center;
    }



    .payment-voucher-section {
        margin-top: 22px;
        border: 1px solid #cbd5e1;
        page-break-inside: avoid;
        background: #fff;
    }

    .payment-voucher-header {
        background: #fff;
        color: #0f766e;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .payment-voucher-header h3 {
        margin: 0;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .payment-voucher-number {
        font-size: 14px;
        font-weight: bold;
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .4);
        padding: 4px 8px;
        border-radius: 3px;
    }

    .payment-voucher-body {
        padding: 12px;
    }

    .payment-summary {
        border: 1px solid #d8dee4;
        background: #f8fafc;
        padding: 9px;
        margin-bottom: 10px;
    }

    .payment-summary-label {
        display: block;
        color: #0f766e;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .payment-summary-value {
        font-size: 14px;
        line-height: 1.4;
    }

    .payment-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px 18px;
    }

    .payment-info-item {
        border-bottom: 1px solid #d8dee4;
        padding: 5px 0;
        font-size: 11.5px;
    }

    .payment-info-label {
        display: inline-block;
        width: 125px;
        font-weight: bold;
        color: #0f766e;
    }

    .payment-amount {
        font-size: 13px;
        font-weight: bold;
        color: #102033;
    }

    .payment-observation {
        margin-top: 10px;
        border: 1px solid #d8dee4;
        padding: 8px;
        min-height: 42px;
    }

    .payment-signatures {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-top: 14px;
    }

    .payment-signature-box {
        height: 95px;
        border: 1px solid #cbd5e1;
        padding: 8px;
        position: relative;
    }

    .payment-signature-box strong {
        display: block;
        font-size: 11px;
    }

    .payment-signature-line {
        position: absolute;
        left: 8px;
        right: 8px;
        bottom: 10px;
        border-top: 1px solid #333;
        padding-top: 3px;
        text-align: center;
        font-size: 8.5px;
        color: #666;
    }

    .no-payment-voucher {
        margin-top: 18px;
        padding: 10px;
        border: 1px dashed #cbd5e1;
        color: #6b7280;
        text-align: center;
        font-size: 11px;
        background: #f8fafc;
    }



    /* =========================================
   BON DE PAIEMENT
========================================= */

    .payment-voucher-section {
        width: 100%;
        max-width: 100%;
        margin-top: 18px;
        border: 1px solid #cbd5e1;
        background: #fff;
        overflow: hidden;
    }

    .payment-voucher-body {
        width: 100%;
        max-width: 100%;
        padding: 12px;
        overflow: hidden;
    }

    /* Synthèse 70 % / Chantier 30 % */
    .payment-summary-grid {
        display: grid;
        grid-template-columns: minmax(0, 7fr) minmax(0, 3fr);
        gap: 14px;
        width: 100%;
        max-width: 100%;
        margin-bottom: 12px;
        align-items: stretch;
    }

    .payment-summary-grid .payment-summary {
        width: 100%;
        min-width: 0;
        max-width: 100%;
        min-height: 76px;
        margin: 0;
        padding: 10px 12px;
        border: 1px solid #d8dee4;
        background: #f8fafc;
        overflow: hidden;
    }

    .payment-summary-label {
        display: block;
        max-width: 100%;
        margin-bottom: 5px;
        color: #0f766e;
        font-size: 11px;
        font-weight: bold;
        line-height: 1.25;
        text-transform: uppercase;
        overflow-wrap: break-word;
        word-wrap: break-word;
    }

    .payment-summary-value {
        display: block;
        max-width: 100%;
        color: #222;
        font-size: 14px;
        line-height: 1.4;
        overflow-wrap: anywhere;
        word-break: normal;
    }

    /* Informations du paiement */
    .payment-info-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 8px 18px;
        width: 100%;
    }

    .payment-info-item {
        min-width: 0;
        border-bottom: 1px solid #d8dee4;
        padding: 5px 0;
        font-size: 11.5px;
        overflow-wrap: anywhere;
    }

    .payment-info-label {
        display: inline-block;
        width: 125px;
        max-width: 45%;
        font-weight: bold;
        color: #0f766e;
        vertical-align: top;
    }

    .payment-amount {
        color: #102033;
        font-size: 13px;
        font-weight: bold;
        white-space: nowrap;
    }

    .payment-observation {
        width: 100%;
        min-height: 42px;
        margin-top: 10px;
        padding: 8px;
        border: 1px solid #d8dee4;
        overflow-wrap: anywhere;
    }

    .payment-signatures {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        width: 100%;
        margin-top: 14px;
    }

    .payment-signature-box {
        min-width: 0;
        height: 95px;
        padding: 8px;
        border: 1px solid #cbd5e1;
        position: relative;
        overflow: hidden;
    }

    .payment-signature-box strong {
        display: block;
        font-size: 11px;
        overflow-wrap: anywhere;
    }

    .payment-signature-box .function {
        margin-top: 3px;
        font-size: 11px;
        line-height: 1.25;
        overflow-wrap: anywhere;
    }

    @media screen and (max-width: 700px) {

        .payment-summary-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .payment-info-grid {
            grid-template-columns: 1fr;
        }

        .payment-signatures {
            grid-template-columns: 1fr;
        }
    }

    @media print {

        @page {
            size: A4 portrait;
            margin: 5mm;
        }

        html,
        body {
            width: 100%;
            margin: 0;
            padding: 0;
            background: #fff;
            font-size: 10px;
        }

        .print-actions {
            display: none !important;
        }

        .print-page {
            width: 100%;
            max-width: 100%;
            min-height: 0;
            margin: 0;
            padding: 4mm 6mm;
            border: none;
            box-shadow: none;
        }

        .header,
        .document-title,
        .info-grid,
        .validation-box,
        table,
        .signature-section,
        .payment-divider {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        /*
     * Le bon peut continuer sur la page suivante si nécessaire
     */
        .payment-voucher-section {
            width: 100% !important;
            max-width: 100% !important;
            margin-top: 12px;
            overflow: hidden !important;
            page-break-inside: auto !important;
            break-inside: auto !important;
        }

        .payment-voucher-body {
            width: 100% !important;
            max-width: 100% !important;
            padding: 8px;
            overflow: hidden !important;
        }

        /*
     * Conserver réellement 70 % / 30 % à l’impression
     */
        .payment-summary-grid {
            display: grid !important;
            grid-template-columns: minmax(0, 7fr) minmax(0, 3fr) !important;
            gap: 8px !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 6px;
        }

        .payment-summary-grid .payment-summary {
            width: 100% !important;
            min-width: 0 !important;
            max-width: 100% !important;
            min-height: 48px;
            margin: 0 !important;
            padding: 6px 8px !important;
            overflow: hidden !important;
        }

        .payment-summary-label {
            font-size: 8px;
            line-height: 1.2;
        }

        .payment-summary-value {
            font-size: 9px;
            line-height: 1.25;
        }

        .payment-info-grid {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
            gap: 4px 12px;
            width: 100%;
        }

        .payment-info-item {
            min-width: 0;
            padding: 3px 0;
            font-size: 9px;
        }

        .payment-info-label {
            width: 105px;
            max-width: 48%;
        }

        .payment-amount {
            font-size: 10px;
        }

        .payment-observation {
            min-height: 30px;
            margin-top: 6px;
            padding: 6px;
            font-size: 9px;
        }

        .payment-signatures {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 8px;
            margin-top: 8px;
        }

        .payment-signature-box {
            min-width: 0;
            height: 65px;
            padding: 6px;
        }

        .payment-signature-box strong,
        .payment-signature-box .function {
            font-size: 8px;
        }

        .payment-divider {
            margin-top: 18px;
            margin-bottom: 10px;
        }

        .payment-divider-line {
            height: 2px;
            margin-bottom: 8px;
        }

        .payment-divider-title span {
            min-width: 250px;
            padding: 6px 24px;
            border-width: 2px;
            font-size: 16px;
        }

        .signature-section {
            margin-top: 14px;
        }

        .signature-title {
            margin-bottom: 6px;
            font-size: 10px;
        }

        .signature-grid {
            gap: 8px;
        }

        .signature-box {
            height: 85px;
            padding: 7px;
        }

        .signature-box .title {
            margin-bottom: 7px;
            font-size: 9px;
        }

        .signature-box .function {
            font-size: 8px;
            line-height: 12px;
        }

        .footer {
            margin-top: 8px;
            padding-top: 5px;
            font-size: 7.5px;
        }
    }
    </style>
</head>

<body>

    <?php
    $reference = 'DA-' . date('Y', strtotime($achat->created_at)) . '-' . str_pad($achat->id, 3, '0', STR_PAD_LEFT);
    $total_general = 0;
    ?>

    <div class="print-actions">
        <!-- <a href="javascript:history.back()" class="btn-back">Retour</a> -->
        <button onclick="window.print()" class="btn-print">Imprimer</button>
    </div>

    <div class="print-page">

        <div class="header">
            <div class="company-left">
                <div class="logo-box">
                    <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="Logo">
                </div>

                <div class="company-title">
                    <h2>SATRACO Construction</h2>
                    <p>Construction Management System - CMS</p>
                </div>
            </div>

            <div class="company-info">
                <strong>NIF :</strong> 4000070948<br>
                <strong>R C : </strong> 46865<br>
                <strong>TÉL :</strong> +257 68 13 13 13 / +257 22 24 50 97<br>
            </div>
        </div>

        <div class="document-title">
            <h1>Demande d'achat des biens / services</h1>
        </div>

        <div class="info-grid">

            <div class="info-item">
                <span class="info-label">Référence :</span>
                <?= $reference ?>
            </div>

            <div class="info-item">
                <span class="info-label">Date demande :</span>
                <?= !empty($achat->request_date) ? date('d/m/Y', strtotime($achat->request_date)) : date('d/m/Y', strtotime($achat->created_at)) ?>
            </div>

            <div class="info-item">
                <span class="info-label">Destination / Chantier :</span>
                <?= $achat->destination_chantier ?>
            </div>



            <!-- <div class="info-item">
                <span class="info-label">Tresoriere :</span>
                AHISHAKIYE Nelly Ange
            </div> -->

            <div class="info-item">
                <span class="info-label">Tresoriere / Fonds :</span>
                <?php if ($achat->treasury_status == 'valide') { ?>
                Fonds Disponible
                <?php } else { ?>
                Fonds Non Disponible
                <?php } ?>
            </div>
            <!-- <div class="info-item">
                <span class="info-label">Demandé par :</span>
                <?= $achat->requested_by ?>
            </div> -->

            <div class="info-item">
                <span class="info-label">Chargé achat :</span>
                <?= $achat->buyer_name ?>
            </div>



            <!-- <div class="info-item">
                <span class="info-label">Statut :</span>
                <?= ucfirst($achat->workflow_status) ?>
            </div> -->

        </div>

        <div class="validation-box">
            <div class="validation-title">Circuit de validation</div>

            <div class="validation-row">

                <div class="validation-badge <?= ($achat->technical_status == 'valide') ? 'validated' : 'pending' ?>">
                    DT :
                    <?= ($achat->technical_status == 'valide') ? 'Validé' : 'En attente' ?>
                </div>

                <div class="validation-badge <?= ($achat->financial_status == 'valide') ? 'validated' : 'pending' ?>">
                    DAF :
                    <?= ($achat->financial_status == 'valide') ? 'Validé' : 'En attente' ?>
                </div>

                <!-- <div class="validation-badge <?= ($achat->dg_status == 'valide') ? 'validated' : 'pending' ?>">
                    DG :
                    <?= ($achat->dg_status == 'valide') ? 'Validé' : 'En attente' ?>
                </div> -->

                <div class="validation-badge <?= ($achat->treasury_status == 'valide') ? 'validated' : 'pending' ?>">
                    Trésorerie :
                    <?= ($achat->treasury_status == 'valide') ? 'Validé' : 'En attente' ?>
                </div>

            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="40"><strong>N°</strong></th>
                    <th><strong>Désignation</strong></th>
                    <th width="90"><strong>Qté</strong></th>
                    <th width="120"><strong>PU</strong></th>
                    <th width="130"><strong>Total</strong></th>
                    <th><strong>Observation</strong></th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($articles)) : ?>
                <?php $i = 1; ?>
                <?php foreach ($articles as $article) : ?>
                <?php $total_general += $article->total_price; ?>

                <tr>
                    <td class="text-center"><?= $i++ ?></td>
                    <td><?= $article->designation ?></td>
                    <td class="text-right"><?= number_format($article->quantity, 2, ',', ' ') ?></td>
                    <td class="text-right"><?= number_format($article->unit_price, 0, ',', ' ') ?> BIF</td>
                    <td class="text-right">
                        <strong><?= number_format($article->total_price, 0, ',', ' ') ?> BIF</strong>
                    </td>
                    <td><?= $article->observations ?></td>
                </tr>

                <?php endforeach; ?>
                <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">Aucun article trouvé.</td>
                </tr>
                <?php endif; ?>
            </tbody>

            <tfoot>
                <tr class="total-row">
                    <td colspan="4" class="text-right">Total général</td>
                    <td class="text-right">
                        <?= number_format($total_general, 0, ',', ' ') ?> BIF
                    </td>
                </tr>
            </tfoot>
        </table>

        <?php if (!empty($achat->notes)) : ?>
        <p><strong>Notes :</strong> <?= nl2br($achat->notes) ?></p>
        <?php endif; ?>

        <div class="signature-section">

            <div class="signature-title">
                SIGNATURES
            </div>

            <div class="signature-grid">

                <!-- Demandé -->
                <div class="signature-box">

                    <div class="title">
                        Demandé par
                    </div>

                    <div class="function">
                        <?= $achat->requested_by ?>
                    </div>



                </div>

                <!-- DT -->
                <div class="signature-box">

                    <div class="title">
                        Verifie Par
                    </div>

                    <div class="function">
                        <?= $achat->verified_by ?>
                    </div>



                </div>

                <!-- DAF -->
                <div class="signature-box">

                    <div class="title">
                        Approbation Techinique
                    </div>

                    <div class="function">
                        DT. NIYIMBONA Emmanuel
                    </div>



                </div>

                <!-- Trésorerie -->
                <div class="signature-box">

                    <div class="title">
                        Approbation Financiere
                    </div>

                    <div class="function">
                        DAF. NDAGIJE Mariam
                    </div>



                </div>

            </div>

        </div>

        <!-- ici le bon de Paiement -->

        <!-- =========================
            Séparation Bon Paiement
        ========================== -->

        <?php if (!empty($bonPaiement)) : ?>

        <div class="payment-divider">

            <div class="payment-divider-line"></div>

            <div class="payment-divider-title">
                <span>Bon de paiement</span>
            </div>

        </div>

        <?php endif; ?>

        <?php if (!empty($bonPaiement)) : ?>

        <?php
            $paymentModes = [
                'especes'            => 'Espèces',
                'cheque'             => 'Chèque',
                'virement_bancaire'  => 'Virement bancaire',
                'transfert_mobile'   => 'Transfert via téléphone mobile',
                'autre'              => 'Autre'
            ];

            $paymentStatuses = [
                'en_attente' => 'En attente',
                'effectue'   => 'Effectué',
                'annule'     => 'Annulé'
            ];

            $modePaiement = isset($paymentModes[$bonPaiement->payment_mode])
                ? $paymentModes[$bonPaiement->payment_mode]
                : ucfirst(str_replace('_', ' ', $bonPaiement->payment_mode));

            $statutPaiement = isset($paymentStatuses[$bonPaiement->payment_status])
                ? $paymentStatuses[$bonPaiement->payment_status]
                : ucfirst(str_replace('_', ' ', $bonPaiement->payment_status));
            ?>

        <div class="payment-voucher-section">

            <!-- <div class="payment-voucher-header">

                <h3>
                    Bon de paiement
                </h3>

                <div class="payment-voucher-number">
                    <?= html_escape($bonPaiement->payment_number) ?>
                </div>

            </div> -->

            <div class="payment-voucher-body">

                <!-- Synthèse + Destination -->
                <div class="payment-summary-grid">

                    <!-- Synthèse -->
                    <div class="payment-summary">

                        <span class="payment-summary-label">
                            Synthèse de la demande
                        </span>

                        <div class="payment-summary-value">
                            <?= nl2br(html_escape($bonPaiement->summary)) ?>
                        </div>

                    </div>

                    <!-- Destination -->
                    <div class="payment-summary">

                        <span class="payment-summary-label">
                            Destination / Chantier
                        </span>

                        <div class="payment-summary-value">
                            <?= html_escape($achat->destination_chantier) ?>
                        </div>

                    </div>

                </div>

                <!-- Informations paiement -->
                <div class="payment-info-grid">

                    <div class="payment-info-item">

                        <span class="payment-info-label">
                            Référence demande :
                        </span>

                        <?= html_escape($reference) ?>

                    </div>

                    <div class="payment-info-item">

                        <span class="payment-info-label">
                            Numéro du bon :
                        </span>

                        <?= html_escape($bonPaiement->payment_number) ?>

                    </div>

                    <div class="payment-info-item">

                        <span class="payment-info-label">
                            Mode de paiement :
                        </span>

                        <?= html_escape($modePaiement) ?>

                    </div>

                    <div class="payment-info-item">

                        <span class="payment-info-label">
                            Référence paiement :
                        </span>

                        <?= html_escape($bonPaiement->payment_reference) ?>

                    </div>

                    <div class="payment-info-item">

                        <span class="payment-info-label">
                            Date de paiement :
                        </span>

                        <?= !empty($bonPaiement->payment_date)
                                ? date('d/m/Y', strtotime($bonPaiement->payment_date))
                                : '-' ?>

                    </div>

                    <!-- <div class="payment-info-item">

                        <span class="payment-info-label">
                            Statut :
                        </span>

                        <?= html_escape($statutPaiement) ?>

                    </div> -->

                    <div class="payment-info-item">

                        <span class="payment-info-label">
                            Montant payé :
                        </span>

                        <span class="payment-amount">
                            <?= number_format(
                                    (float) $bonPaiement->amount_paid,
                                    0,
                                    ',',
                                    ' '
                                ) ?> BIF
                        </span>

                    </div>

                    <!-- <div class="payment-info-item">

                        <span class="payment-info-label">
                            Destination / Chantier :
                        </span>

                        <?= html_escape($achat->destination_chantier) ?>

                    </div> -->

                </div>

                <?php if (!empty($bonPaiement->observation)) : ?>

                <div class="payment-observation">

                    <strong>Observation :</strong><br>

                    <?= nl2br(html_escape($bonPaiement->observation)) ?>

                </div>

                <?php endif; ?>

                <!-- Signatures du paiement -->
                <div class="payment-signatures">

                    <div class="payment-signature-box">

                        <strong>
                            Trésorerie
                        </strong>

                        <div class="function">
                            AHISHAKIYE Nelly Ange
                        </div>

                        <!-- <div class="payment-signature-line">
                            Nom, signature et cachet
                        </div> -->

                    </div>

                    <div class="payment-signature-box">

                        <strong>
                            Pour la remise de fonds
                        </strong>



                        <!-- <div class="payment-signature-line">
                            Nom, signature et cachet
                        </div> -->

                    </div>



                    <div class="payment-signature-box">

                        <strong>
                            Pour la reception de fonds
                        </strong>

                        <!-- <div class="payment-signature-line">
                            Nom et signature
                        </div> -->

                    </div>

                </div>

            </div>

        </div>

        <?php endif; ?>

        <div class="footer">
            © <?= date('Y') ?> SATRACO Construction - Document généré automatiquement par Construction Management System
            (CMS).
            <br>
            Adresse :
            Bujumbura, Commune NTAHANGWA, ZONE NGAGARA, Q. INDUSTRIEL, Numero 15
        </div>

    </div>

</body>

</html>