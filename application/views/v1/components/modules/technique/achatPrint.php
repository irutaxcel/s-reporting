<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Demande d'achat - Impression
    </title>

    <style>
        /* =====================================================
           CONFIGURATION GÉNÉRALE
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        :root {
            --primary: #0f766e;
            --primary-dark: #102033;
            --border: #cbd5e1;
            --border-soft: #d8dee4;
            --background-soft: #f8fafc;
            --text: #222;
            --muted: #555;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background: #f4f6f9;
            padding: 10px;
            font-size: 12px;
        }

        .print-page {
            width: 210mm;
            min-height: 297mm;
            margin: auto;
            padding: 11mm 13mm;
            background: #fff;
            border: 1px solid #ddd;
        }

        /* =====================================================
           BOUTONS
        ===================================================== */

        .print-actions {
            width: 210mm;
            margin: 0 auto 8px;
            text-align: right;
        }

        .btn-print,
        .btn-back {
            display: inline-block;
            border: none;
            border-radius: 4px;
            padding: 7px 14px;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-print {
            background: var(--primary);
        }

        .btn-back {
            margin-right: 5px;
            background: #6c757d;
        }

        /* =====================================================
           EN-TÊTE SATRACO
        ===================================================== */

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 13px;
            padding-bottom: 9px;
            border-bottom: 3px solid var(--primary);
        }

        .company-left {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .logo-box {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 62px;
            width: 62px;
            height: 62px;
            border: 1px solid #ddd;
            border-radius: 50%;
            overflow: hidden;
        }

        .logo-box img {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }

        .company-title {
            min-width: 0;
        }

        .company-title h2 {
            margin: 0;
            color: var(--primary);
            font-size: 18px;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .company-title p {
            margin: 3px 0 0;
            color: var(--muted);
            font-size: 11px;
        }

        .company-info {
            flex: 0 0 auto;
            text-align: right;
            font-size: 10px;
            line-height: 1.5;
        }

        /* =====================================================
           TITRES DES DOCUMENTS
        ===================================================== */

        .document-title,
        .payment-document-title {
            text-align: center;
        }

        .document-title {
            margin: 13px 0 15px;
        }

        .document-title h1,
        .payment-document-title span {
            display: inline-block;
            margin: 0;
            padding: 7px 28px;
            border: 2px solid var(--primary);
            background: #fff;
            color: var(--primary);
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* =====================================================
           INFORMATIONS DE LA DEMANDE
        ===================================================== */

        .info-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 7px 22px;
            margin-bottom: 11px;
        }

        .info-item {
            min-width: 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
            overflow-wrap: anywhere;
        }

        .info-label {
            display: inline-block;
            width: 120px;
            max-width: 45%;
            color: var(--primary);
            font-weight: bold;
            vertical-align: top;
        }

        /* =====================================================
           VALIDATIONS
        ===================================================== */

        .validation-box {
            margin: 9px 0 11px;
            padding: 8px;
            border: 1px solid #ddd;
            background: #f9fafb;
        }

        .validation-title {
            margin-bottom: 7px;
            color: var(--primary);
            font-weight: bold;
            text-transform: uppercase;
        }

        .validation-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .validation-badge {
            padding: 4px 7px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: #fff;
            font-size: 10px;
        }

        .validated {
            color: #155724;
            background: #e9f7ef;
            border-color: #28a745;
            font-weight: bold;
        }

        .pending {
            color: #856404;
            background: #fff3cd;
            border-color: #ffc107;
            font-weight: bold;
        }

        /* =====================================================
           TABLEAU DES ARTICLES
        ===================================================== */

        .items-table {
            width: 100%;
            margin-top: 7px;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 10.5px;
        }

        .items-table th {
            padding: 6px;
            border: 1px solid var(--primary-dark);
            background: #fff;
            color: var(--primary-dark);
            text-align: center;
        }

        .items-table td {
            padding: 5px 6px;
            border: 1px solid #ccc;
            vertical-align: middle;
            overflow-wrap: anywhere;
        }

        .items-table .col-number {
            width: 5%;
        }

        .items-table .col-designation {
            width: 31%;
        }

        .items-table .col-quantity {
            width: 11%;
        }

        .items-table .col-unit-price {
            width: 16%;
        }

        .items-table .col-total {
            width: 17%;
        }

        .items-table .col-observation {
            width: 20%;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row td {
            background: #f1f5f9;
            font-size: 11px;
            font-weight: bold;
        }

        .notes-box {
            margin-top: 8px;
            padding: 7px;
            border: 1px solid var(--border-soft);
            overflow-wrap: anywhere;
        }

        /* =====================================================
           SIGNATURES DE LA DEMANDE
        ===================================================== */

        .signature-section {
            margin-top: 20px;
        }

        .signature-title {
            margin-bottom: 9px;
            color: var(--primary);
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .signature-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .signature-box {
            min-width: 0;
            height: 120px;
            padding: 9px;
            border: 1px solid #cfcfcf;
            background: #fff;
            overflow: hidden;
        }

        .signature-box .title {
            margin-bottom: 10px;
            font-size: 11px;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .signature-box .function {
            color: #444;
            font-size: 10px;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        /* =====================================================
           SÉPARATEUR DU BON DE PAIEMENT
        ===================================================== */

        .payment-divider {
            width: 100%;
            margin-top: 28px;
            margin-bottom: 16px;
            text-align: center;
        }

        .payment-divider-line {
            width: 100%;
            height: 3px;
            margin-bottom: 15px;
            background: var(--primary);
        }

        /*
         * Même contour que le titre de la demande d'achat
         */
        .payment-document-title span {
            min-width: 300px;
        }

        /* =====================================================
           BON DE PAIEMENT
        ===================================================== */

        .payment-voucher-section {
            width: 100%;
            max-width: 100%;
            border: 1px solid var(--border);
            background: #fff;
            overflow: hidden;
        }

        .payment-voucher-body {
            width: 100%;
            max-width: 100%;
            padding: 11px;
            overflow: hidden;
        }

        /*
         * Synthèse 70 % / chantier 30 %
         * Utiliser 7fr / 3fr évite de dépasser 100 % avec le gap.
         */
        .payment-summary-grid {
            display: grid;
            grid-template-columns: minmax(0, 7fr) minmax(0, 3fr);
            gap: 12px;
            width: 100%;
            max-width: 100%;
            margin-bottom: 10px;
            align-items: stretch;
        }

        .payment-summary {
            width: 100%;
            min-width: 0;
            min-height: 68px;
            margin: 0;
            padding: 9px 10px;
            border: 1px solid var(--border-soft);
            background: var(--background-soft);
            overflow: hidden;
        }

        .payment-summary-label {
            display: block;
            max-width: 100%;
            margin-bottom: 5px;
            color: var(--primary);
            font-size: 10px;
            font-weight: bold;
            line-height: 1.25;
            text-transform: uppercase;
            overflow-wrap: anywhere;
        }

        .payment-summary-value {
            display: block;
            max-width: 100%;
            color: var(--text);
            font-size: 12px;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        /* Informations du bon */

        .payment-info-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 7px 18px;
            width: 100%;
        }

        .payment-info-item {
            min-width: 0;
            padding: 5px 0;
            border-bottom: 1px solid var(--border-soft);
            font-size: 10.5px;
            overflow-wrap: anywhere;
        }

        .payment-info-label {
            display: inline-block;
            width: 135px;
            max-width: 48%;
            color: var(--primary);
            font-weight: bold;
            vertical-align: top;
        }

        .payment-amount {
            color: var(--primary-dark);
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .payment-observation {
            width: 100%;
            min-height: 42px;
            margin-top: 10px;
            padding: 8px;
            border: 1px solid var(--border-soft);
            overflow-wrap: anywhere;
        }

        /* Signatures du paiement */

        .payment-signatures {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            width: 100%;
            margin-top: 12px;
        }

        .payment-signature-box {
            min-width: 0;
            height: 90px;
            padding: 8px;
            border: 1px solid var(--border);
            background: #fff;
            overflow: hidden;
        }

        .payment-signature-box strong {
            display: block;
            margin-bottom: 3px;
            font-size: 10px;
            overflow-wrap: anywhere;
        }

        .payment-signature-box .function {
            font-size: 10px;
            line-height: 1.3;
            overflow-wrap: anywhere;
        }

        /* =====================================================
           PIED DE PAGE
        ===================================================== */

        .footer {
            margin-top: 16px;
            padding-top: 7px;
            border-top: 2px solid var(--primary);
            color: var(--muted);
            font-size: 8.5px;
            line-height: 1.35;
            text-align: center;
        }

        /* =====================================================
           RESPONSIVE ÉCRAN
        ===================================================== */

        @media screen and (max-width: 800px) {

            body {
                padding: 0;
            }

            .print-actions,
            .print-page {
                width: 100%;
            }

            .print-page {
                min-height: auto;
                padding: 15px;
                border: none;
            }

            .header {
                align-items: flex-start;
            }

            .company-info {
                font-size: 9px;
            }

            .info-grid,
            .payment-info-grid {
                grid-template-columns: 1fr;
            }

            .payment-summary-grid {
                grid-template-columns: 1fr;
            }

            .signature-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .payment-signatures {
                grid-template-columns: 1fr;
            }
        }

        /* =====================================================
           IMPRESSION A4
        ===================================================== */

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
                font-size: 9px;
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
            .items-table,
            .signature-section,
            .payment-divider {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            /* En-tête */

            .header {
                margin-bottom: 8px;
                padding-bottom: 6px;
            }

            .logo-box {
                flex-basis: 45px;
                width: 45px;
                height: 45px;
            }

            .logo-box img {
                width: 40px;
                height: 40px;
            }

            .company-title h2 {
                font-size: 13px;
            }

            .company-title p {
                font-size: 7px;
            }

            .company-info {
                font-size: 7px;
            }

            /* Titres */

            .document-title {
                margin: 8px 0 9px;
            }

            .document-title h1,
            .payment-document-title span {
                padding: 5px 20px;
                border-width: 2px;
                font-size: 13px;
            }

            /* Informations */

            .info-grid {
                gap: 4px 14px;
                margin-bottom: 7px;
            }

            .info-item {
                padding-bottom: 3px;
                font-size: 8px;
            }

            .info-label {
                width: 95px;
            }

            /* Validation */

            .validation-box {
                margin: 6px 0 7px;
                padding: 6px;
            }

            .validation-title {
                margin-bottom: 4px;
                font-size: 8px;
            }

            .validation-badge {
                padding: 3px 5px;
                font-size: 7px;
            }

            /* Tableau */

            .items-table {
                margin-top: 5px;
                font-size: 7.5px;
            }

            .items-table th,
            .items-table td {
                padding: 3px 4px;
            }

            .total-row td {
                font-size: 8px;
            }

            /* Signatures demande */

            .signature-section {
                margin-top: 12px;
            }

            .signature-title {
                margin-bottom: 5px;
                font-size: 8px;
            }

            .signature-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
                gap: 7px;
            }

            .signature-box {
                height: 72px;
                padding: 6px;
            }

            .signature-box .title {
                margin-bottom: 5px;
                font-size: 7.5px;
            }

            .signature-box .function {
                font-size: 7px;
                line-height: 1.2;
            }

            /* Séparation paiement */

            .payment-divider {
                margin-top: 14px;
                margin-bottom: 8px;
            }

            .payment-divider-line {
                height: 2px;
                margin-bottom: 8px;
            }

            .payment-document-title span {
                min-width: 220px;
                padding: 5px 20px;
                font-size: 12px;
            }

            /* Bon de paiement */

            .payment-voucher-section {
                width: 100% !important;
                max-width: 100% !important;
                overflow: hidden !important;
                page-break-inside: auto !important;
                break-inside: auto !important;
            }

            .payment-voucher-body {
                width: 100% !important;
                max-width: 100% !important;
                padding: 7px;
                overflow: hidden !important;
            }

            /*
             * Conserver obligatoirement 70 % / 30 %
             */
            .payment-summary-grid {
                display: grid !important;
                grid-template-columns: minmax(0, 7fr) minmax(0, 3fr) !important;
                gap: 7px !important;
                width: 100% !important;
                max-width: 100% !important;
                margin-bottom: 5px;
            }

            .payment-summary {
                width: 100% !important;
                min-width: 0 !important;
                min-height: 42px;
                margin: 0 !important;
                padding: 5px 6px !important;
            }

            .payment-summary-label {
                margin-bottom: 3px;
                font-size: 7px;
                line-height: 1.15;
            }

            .payment-summary-value {
                font-size: 8px;
                line-height: 1.2;
            }

            .payment-info-grid {
                display: grid !important;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
                gap: 3px 10px;
            }

            .payment-info-item {
                padding: 3px 0;
                font-size: 7.5px;
            }

            .payment-info-label {
                width: 95px;
                max-width: 50%;
            }

            .payment-amount {
                font-size: 8px;
            }

            .payment-observation {
                min-height: 27px;
                margin-top: 5px;
                padding: 5px;
                font-size: 7.5px;
            }

            .payment-signatures {
                display: grid !important;
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                gap: 7px;
                margin-top: 6px;
            }

            .payment-signature-box {
                height: 55px;
                padding: 5px;
            }

            .payment-signature-box strong,
            .payment-signature-box .function {
                font-size: 7px;
            }

            .footer {
                margin-top: 6px;
                padding-top: 4px;
                font-size: 6px;
            }
        }
    </style>

</head>

<body>

    <?php

    $reference = 'DA-'
        . date('Y', strtotime($achat->created_at))
        . '-'
        . str_pad($achat->id, 3, '0', STR_PAD_LEFT);

    $total_general = 0;

    $paymentModes = [
        'especes'           => 'Espèces',
        'cheque'            => 'Chèque',
        'virement_bancaire' => 'Virement bancaire',
        'transfert_mobile'  => 'Transfert via téléphone mobile',
        'autre'             => 'Autre'
    ];

    $paymentStatuses = [
        'en_attente' => 'En attente',
        'effectue'   => 'Effectué',
        'annule'     => 'Annulé'
    ];

    $modePaiement = null;
    $statutPaiement = null;

    if (!empty($bonPaiement)) {

        $modePaiement = $paymentModes[$bonPaiement->payment_mode]
            ?? ucfirst(str_replace('_', ' ', $bonPaiement->payment_mode));

        $statutPaiement = $paymentStatuses[$bonPaiement->payment_status]
            ?? ucfirst(str_replace('_', ' ', $bonPaiement->payment_status));
    }

    ?>

    <div class="print-actions">

        <a href="javascript:history.back()" class="btn-back">
            Retour
        </a>

        <button type="button" class="btn-print" onclick="window.print()">
            Imprimer
        </button>

    </div>

    <div class="print-page">

        <!-- =====================================================
         EN-TÊTE
    ====================================================== -->

        <header class="header">

            <div class="company-left">

                <div class="logo-box">

                    <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="Logo SATRACO">

                </div>

                <div class="company-title">

                    <h2>
                        SATRACO Construction
                    </h2>

                    <p>
                        Construction Management System - CMS
                    </p>

                </div>

            </div>

            <div class="company-info">

                <strong>NIF :</strong> 4000070948<br>

                <strong>R C :</strong> 46865<br>

                <strong>TÉL :</strong>
                +257 68 13 13 13 /
                +257 22 24 50 97

            </div>

        </header>

        <!-- =====================================================
         TITRE DEMANDE
    ====================================================== -->

        <div class="document-title">

            <h1>
                Demande d'achat des biens / services
            </h1>

        </div>

        <!-- =====================================================
         INFORMATIONS DEMANDE
    ====================================================== -->

        <div class="info-grid">

            <div class="info-item">

                <span class="info-label">
                    Référence :
                </span>

                <?= html_escape($reference) ?>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Date demande :
                </span>

                <?= !empty($achat->request_date)
                    ? date('d/m/Y', strtotime($achat->request_date))
                    : date('d/m/Y', strtotime($achat->created_at)) ?>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Destination / Chantier :
                </span>

                <?= html_escape($achat->destination_chantier) ?>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Trésorerie / Fonds :
                </span>

                <?= $achat->treasury_status === 'valide'
                    ? 'Fonds disponibles'
                    : 'Fonds non disponibles' ?>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Chargé achat :
                </span>

                <?= html_escape($achat->buyer_name) ?>

            </div>

        </div>

        <!-- =====================================================
         VALIDATION
    ====================================================== -->

        <div class="validation-box">

            <div class="validation-title">
                Circuit de validation
            </div>

            <div class="validation-row">

                <div class="validation-badge
                <?= $achat->technical_status === 'valide'
                    ? 'validated'
                    : 'pending' ?>">

                    DT :
                    <?= $achat->technical_status === 'valide'
                        ? 'Validé'
                        : 'En attente' ?>

                </div>

                <div class="validation-badge
                <?= $achat->financial_status === 'valide'
                    ? 'validated'
                    : 'pending' ?>">

                    DAF :
                    <?= $achat->financial_status === 'valide'
                        ? 'Validé'
                        : 'En attente' ?>

                </div>

                <div class="validation-badge
                <?= $achat->treasury_status === 'valide'
                    ? 'validated'
                    : 'pending' ?>">

                    Trésorerie :
                    <?= $achat->treasury_status === 'valide'
                        ? 'Validé'
                        : 'En attente' ?>

                </div>

            </div>

        </div>

        <!-- =====================================================
         ARTICLES
    ====================================================== -->

        <table class="items-table">

            <thead>

                <tr>

                    <th class="col-number">
                        N°
                    </th>

                    <th class="col-designation">
                        Désignation
                    </th>

                    <th class="col-quantity">
                        Qté
                    </th>

                    <th class="col-unit-price">
                        PU
                    </th>

                    <th class="col-total">
                        Total
                    </th>

                    <th class="col-observation">
                        Observation
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php if (!empty($articles)) : ?>

                    <?php foreach ($articles as $index => $article) : ?>

                        <?php
                        $articleTotal = (float) $article->total_price;
                        $total_general += $articleTotal;
                        ?>

                        <tr>

                            <td class="text-center">
                                <?= $index + 1 ?>
                            </td>

                            <td>
                                <?= html_escape($article->designation) ?>
                            </td>

                            <td class="text-right">
                                <?= number_format(
                                    (float) $article->quantity,
                                    2,
                                    ',',
                                    ' '
                                ) ?>
                            </td>

                            <td class="text-right">
                                <?= number_format(
                                    (float) $article->unit_price,
                                    0,
                                    ',',
                                    ' '
                                ) ?> BIF
                            </td>

                            <td class="text-right">

                                <strong>
                                    <?= number_format(
                                        $articleTotal,
                                        0,
                                        ',',
                                        ' '
                                    ) ?> BIF
                                </strong>

                            </td>

                            <td>
                                <?= !empty($article->observations)
                                    ? html_escape($article->observations)
                                    : '-' ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>

                        <td colspan="6" class="text-center">

                            Aucun article trouvé.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

            <tfoot>

                <tr class="total-row">

                    <td colspan="4" class="text-right">

                        Total général

                    </td>

                    <td class="text-right">

                        <?= number_format(
                            $total_general,
                            0,
                            ',',
                            ' '
                        ) ?> BIF

                    </td>

                    <td></td>

                </tr>

            </tfoot>

        </table>

        <?php if (!empty($achat->notes)) : ?>

            <div class="notes-box">

                <strong>Notes :</strong><br>

                <?= nl2br(html_escape($achat->notes)) ?>

            </div>

        <?php endif; ?>

        <!-- =====================================================
         SIGNATURES DEMANDE
    ====================================================== -->

        <section class="signature-section">

            <div class="signature-title">
                Signatures
            </div>

            <div class="signature-grid">

                <div class="signature-box">

                    <div class="title">
                        Demandé par
                    </div>

                    <div class="function">
                        <?= html_escape($achat->requested_by) ?>
                    </div>

                </div>

                <div class="signature-box">

                    <div class="title">
                        Vérifié par
                    </div>

                    <div class="function">
                        <?= html_escape($achat->verified_by) ?>
                    </div>

                </div>

                <div class="signature-box">

                    <div class="title">
                        Approbation technique
                    </div>

                    <div class="function">
                        <?= !empty($achat->technical_approver)
                            ? html_escape($achat->technical_approver)
                            : 'DT. NIYIMBONA Emmanuel' ?>
                    </div>

                </div>

                <div class="signature-box">

                    <div class="title">
                        Approbation financière
                    </div>

                    <div class="function">
                        <?= !empty($achat->financial_approver)
                            ? html_escape($achat->financial_approver)
                            : 'DAF. NDAGIJE Mariam' ?>
                    </div>

                </div>

            </div>

        </section>

        <!-- =====================================================
         BON DE PAIEMENT
    ====================================================== -->

        <?php if (!empty($bonPaiement)) : ?>

            <!-- Ligne de séparation + titre encadré -->

            <div class="payment-divider">

                <div class="payment-divider-line"></div>

                <div class="payment-document-title">

                    <span>
                        Bon de paiement
                    </span>

                </div>

            </div>

            <section class="payment-voucher-section">

                <div class="payment-voucher-body">

                    <!-- Synthèse 70 % / Destination 30 % -->

                    <div class="payment-summary-grid">

                        <div class="payment-summary">

                            <span class="payment-summary-label">
                                Synthèse de la demande
                            </span>

                            <div class="payment-summary-value">

                                <?= nl2br(
                                    html_escape($bonPaiement->summary)
                                ) ?>

                            </div>

                        </div>

                        <div class="payment-summary">

                            <span class="payment-summary-label">
                                Destination / Chantier
                            </span>

                            <div class="payment-summary-value">

                                <?= html_escape(
                                    $achat->destination_chantier
                                ) ?>

                            </div>

                        </div>

                    </div>

                    <!-- Informations du paiement -->

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

                            <?= html_escape(
                                $bonPaiement->payment_number
                            ) ?>

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

                            <?= html_escape(
                                $bonPaiement->payment_reference
                            ) ?>

                        </div>

                        <div class="payment-info-item">

                            <span class="payment-info-label">
                                Date de paiement :
                            </span>

                            <?= !empty($bonPaiement->payment_date)
                                ? date(
                                    'd/m/Y',
                                    strtotime($bonPaiement->payment_date)
                                )
                                : '-' ?>

                        </div>

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

                    </div>

                    <?php if (!empty($bonPaiement->observation)) : ?>

                        <div class="payment-observation">

                            <strong>
                                Observation :
                            </strong>

                            <br>

                            <?= nl2br(
                                html_escape($bonPaiement->observation)
                            ) ?>

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

                        </div>

                        <div class="payment-signature-box">

                            <strong>
                                Pour la remise de fonds
                            </strong>

                        </div>

                        <div class="payment-signature-box">

                            <strong>
                                Pour la réception de fonds
                            </strong>

                        </div>

                    </div>

                </div>

            </section>

        <?php endif; ?>

        <!-- =====================================================
         PIED DE PAGE
    ====================================================== -->

        <footer class="footer">

            © <?= date('Y') ?>
            SATRACO Construction -
            Document généré automatiquement par
            Construction Management System (CMS).

            <br>

            Adresse :
            Bujumbura, Commune NTAHANGWA,
            Zone Ngagara, Quartier Industriel,
            Numéro 15

        </footer>

    </div>

</body>

</html>