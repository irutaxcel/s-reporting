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
        font-size: 14px;
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
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        color: #fff;
        font-size: 14px;
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
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 3px solid var(--primary);
    }

    .company-left {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .logo-box {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 65px;
        width: 65px;
        height: 65px;
        border: 1px solid #ddd;
        border-radius: 50%;
        overflow: hidden;
    }

    .logo-box img {
        width: 58px;
        height: 58px;
        object-fit: contain;
    }

    .company-title {
        min-width: 0;
    }

    .company-title h2 {
        margin: 0;
        color: var(--primary);
        font-size: 22px;
        font-weight: 700;
        line-height: 1.2;
        text-transform: uppercase;
    }

    .company-title p {
        margin: 4px 0 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.3;
    }

    .company-info {
        flex: 0 0 auto;
        color: #222;
        text-align: right;
        font-size: 12px;
        line-height: 1.55;
    }

    /* =====================================================
           TITRES DES DOCUMENTS
        ===================================================== */

    .document-title {
        margin: 14px 0 16px;
        text-align: center;
    }

    .document-title h1 {
        display: inline-block;
        margin: 0;
        padding: 8px 30px;
        border: 2px solid var(--primary);
        background: #fff;
        color: var(--primary);
        font-size: 21px;
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
        gap: 8px 22px;
        margin-bottom: 12px;
    }

    .info-item {
        min-width: 0;
        padding-bottom: 6px;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .info-label {
        display: inline-block;
        width: 135px;
        max-width: 48%;
        color: var(--primary);
        font-size: 14px;
        font-weight: bold;
        vertical-align: top;
    }

    /* =====================================================
           VALIDATIONS
        ===================================================== */

    .validation-box {
        margin: 10px 0 12px;
        padding: 10px;
        border: 1px solid #ddd;
        background: #f9fafb;
    }

    .validation-title {
        margin-bottom: 8px;
        color: var(--primary);
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .validation-row {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    .validation-badge {
        padding: 5px 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: #fff;
        font-size: 12px;
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
        margin-top: 8px;
        border-collapse: collapse;
        table-layout: fixed;
        font-size: 13px;
    }

    .items-table th {
        padding: 7px 6px;
        border: 1px solid var(--primary-dark);
        background: #fff;
        color: var(--primary-dark);
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }

    .items-table td {
        padding: 6px 7px;
        border: 1px solid #ccc;
        font-size: 13px;
        line-height: 1.35;
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
        font-size: 14px;
        font-weight: bold;
    }

    .notes-box {
        margin-top: 9px;
        padding: 8px;
        border: 1px solid var(--border-soft);
        font-size: 13px;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    /* =====================================================
           SIGNATURES DE LA DEMANDE
        ===================================================== */

    .signature-section {
        margin-top: 22px;
    }

    .signature-title {
        margin-bottom: 10px;
        color: var(--primary);
        font-size: 16px;
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
        height: 128px;
        padding: 10px;
        border: 1px solid #cfcfcf;
        background: #fff;
        overflow: hidden;
    }

    .signature-box .title {
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: bold;
        line-height: 1.25;
        overflow-wrap: anywhere;
    }

    .signature-box .function {
        color: #444;
        font-size: 13px;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    /* =====================================================
           SÉPARATEUR + DEUX PANNEAUX 60% / 40%
        ===================================================== */

    .payment-divider-line {
        width: 100%;
        height: 3px;
        margin-top: 26px;
        margin-bottom: 14px;
        background: var(--primary);
    }

    .payment-split {
        display: grid;
        grid-template-columns: minmax(0, 6fr) minmax(0, 4fr);
        gap: 14px;
        width: 100%;
        align-items: stretch;
    }

    .split-col {
        min-width: 0;
        display: flex;
        flex-direction: column;
        padding: 10px;
        border: 1px solid var(--border);
        background: #fff;
    }

    .split-title {
        margin-bottom: 10px;
        text-align: center;
    }

    .split-title span {
        display: inline-block;
        padding: 6px 12px;
        border: 2px solid var(--primary);
        background: #fff;
        color: var(--primary);
        font-size: 13px;
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    /* ----- Panneau BON DE PAIEMENT (60%) ----- */

    .payment-summary-stack {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
        margin-bottom: 10px;
    }

    .payment-summary {
        width: 100%;
        min-width: 0;
        min-height: 52px;
        padding: 8px 10px;
        border: 1px solid var(--border-soft);
        background: var(--background-soft);
        overflow: hidden;
    }

    .payment-summary-label {
        display: block;
        margin-bottom: 4px;
        color: var(--primary);
        font-size: 12.5px;
        font-weight: bold;
        line-height: 1.25;
        text-transform: uppercase;
        overflow-wrap: anywhere;
    }

    .payment-summary-value {
        display: block;
        color: var(--text);
        font-size: 14px;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    .payment-info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 6px;
        width: 100%;
    }

    .payment-info-item {
        min-width: 0;
        padding: 5px 0;
        border-bottom: 1px solid var(--border-soft);
        font-size: 13px;
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .payment-info-label {
        display: inline-block;
        width: 145px;
        max-width: 55%;
        color: var(--primary);
        font-size: 13px;
        font-weight: bold;
        vertical-align: top;
    }

    .payment-amount {
        color: var(--primary-dark);
        font-size: 15px;
        font-weight: bold;
        white-space: nowrap;
    }

    .payment-observation {
        width: 100%;
        min-height: 40px;
        margin-top: 9px;
        padding: 8px;
        border: 1px solid var(--border-soft);
        font-size: 13px;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    .payment-signatures {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        gap: 8px;
        margin-top: 10px;
        min-width: 0;
    }

    .payment-signature-box {
        min-width: 0;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--border);
        background: #fff;
        overflow: hidden;
    }

    .payment-signature-box .box-head {
        padding: 4px 6px;
        border-bottom: 1px solid var(--border);
        background: var(--background-soft);
        color: var(--primary-dark);
        font-size: 11.5px;
        font-weight: bold;
        line-height: 1.3;
        text-align: center;
        overflow-wrap: anywhere;
    }

    .payment-signature-box .box-head .function {
        display: block;
        color: #444;
        font-size: 11px;
        font-weight: normal;
    }

    .payment-signature-box .sign-area {
        flex: 1 1 auto;
        min-height: 46px;
    }

    .payment-signature-box.treasury {
        grid-column: 1;
        grid-row: 1;
    }

    .payment-signature-box.remise {
        grid-column: 1;
        grid-row: 2;
    }

    .payment-signature-box.reception {
        grid-column: 2;
        grid-row: 1 / 3;
    }

    /* ----- Panneau RAPPORT D'UTILISATION DES FONDS (40%) ----- */

    .fund-body {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        min-width: 0;
    }

    .fund-amount-item {
        margin-bottom: 10px;
        padding: 5px 0;
        border-bottom: 1px solid var(--border-soft);
        font-size: 13px;
    }

    .fund-report-row {
        display: flex;
        align-items: flex-end;
        gap: 6px;
        margin-bottom: 12px;
        font-size: 13px;
    }

    .fund-report-row .label {
        flex: 0 0 auto;
        color: var(--primary);
        font-weight: bold;
    }

    .fund-report-row .fill {
        flex: 1 1 auto;
        height: 14px;
        border-bottom: 1.6px dotted #94a3b8;
    }

    .fund-report-row .unit {
        flex: 0 0 auto;
        color: var(--primary-dark);
        font-size: 12.5px;
        font-weight: bold;
    }

    /* Signatures du rapport :
           3 rectangles PLEINE LARGEUR, empilés,
           qui remplissent TOUT l'espace vide du panneau */

    .fund-report-sign-grid {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: repeat(3, 1fr);
        gap: 10px;
        flex: 1 1 auto;
        padding-top: 10px;
    }

    .fund-sign-box {
        min-width: 0;
        min-height: 48px;
        padding: 6px;
        border: 1px solid var(--border-soft);
        background: #fff;
    }

    .fund-sign-box .caption {
        display: block;
        text-align: center;
        color: var(--primary-dark);
        font-size: 11px;
        font-weight: bold;
        overflow-wrap: anywhere;
    }

    /* =====================================================
           PIED DE PAGE
        ===================================================== */

    .footer {
        margin-top: 17px;
        padding-top: 8px;
        border-top: 2px solid var(--primary);
        color: var(--muted);
        font-size: 11px;
        line-height: 1.4;
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

        .company-title h2 {
            font-size: 18px;
        }

        .company-title p {
            font-size: 12px;
        }

        .company-info {
            font-size: 10px;
        }

        .info-grid,
        .payment-info-grid {
            grid-template-columns: 1fr;
        }

        .signature-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .payment-split {
            grid-template-columns: 1fr;
        }

        .payment-signature-box .sign-area {
            min-height: 60px;
        }

        .fund-sign-box {
            min-height: 70px;
        }
    }

    /* =====================================================
           IMPRESSION A4
        ===================================================== */

    @media print {

        @page {
            size: A4 portrait;
            margin: 6mm 7mm;
        }

        html,
        body {
            font-size: 12px !important;
            color: #000 !important;
            background: #fff !important;
        }

        .print-actions {
            display: none !important;
        }

        /* La page : les marges viennent uniquement de @page */

        .print-page {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            color: #000 !important;
            overflow: visible !important;
        }

        /* Tolérance aux coupures : plus jamais de grande page vide */

        .payment-split,
        .split-col,
        .fund-body {
            break-inside: auto !important;
        }

        tr,
        .validation-box,
        .signature-grid,
        .payment-summary-stack,
        .payment-signatures,
        .fund-report-sign-grid {
            break-inside: avoid;
        }

        thead {
            display: table-header-group;
        }

        /* EN-TÊTE */

        .header {
            margin-bottom: 8px !important;
            padding-bottom: 6px !important;
            border-bottom: 3px solid #000 !important;
        }

        .logo-box {
            width: 48px !important;
            height: 48px !important;
            flex-basis: 48px !important;
            border: 1.5px solid #000 !important;
        }

        .logo-box img {
            width: 43px !important;
            height: 43px !important;
        }

        .company-title h2 {
            font-size: 17px !important;
            font-weight: 800 !important;
            color: #000 !important;
        }

        .company-title p {
            font-size: 10.5px !important;
            color: #000 !important;
        }

        .company-info {
            font-size: 10px !important;
            line-height: 1.4 !important;
            color: #000 !important;
        }

        /* TITRE DEMANDE */

        .document-title {
            margin: 8px 0 9px !important;
        }

        .document-title h1 {
            padding: 5px 20px !important;
            border: 2px solid #000 !important;
            color: #000 !important;
            background: #fff !important;
            font-size: 16px !important;
            font-weight: 800 !important;
            letter-spacing: 1px !important;
        }

        /* INFORMATIONS DE LA DEMANDE */

        .info-grid {
            gap: 4px 14px !important;
            margin-bottom: 7px !important;
        }

        .info-item {
            padding: 3px 0 !important;
            border-bottom: 1.5px solid #000 !important;
            color: #000 !important;
            font-size: 11px !important;
            line-height: 1.3 !important;
        }

        .info-label {
            width: 110px !important;
            max-width: 48% !important;
            color: #000 !important;
            font-size: 11px !important;
            font-weight: 800 !important;
        }

        /* CIRCUIT DE VALIDATION */

        .validation-box {
            margin: 6px 0 8px !important;
            padding: 6px !important;
            border: 1.5px solid #000 !important;
            background: #fff !important;
        }

        .validation-title {
            margin-bottom: 5px !important;
            color: #000 !important;
            font-size: 11px !important;
            font-weight: 800 !important;
        }

        .validation-badge {
            padding: 3px 6px !important;
            border: 1.5px solid #000 !important;
            color: #000 !important;
            background: #fff !important;
            font-size: 10px !important;
            font-weight: 700 !important;
        }

        .validated,
        .pending {
            color: #000 !important;
            border-color: #000 !important;
            background: #fff !important;
        }

        /* TABLEAU DES ARTICLES */

        .items-table {
            margin-top: 5px !important;
            border: 1.5px solid #000 !important;
            color: #000 !important;
            font-size: 10.5px !important;
        }

        .items-table th {
            padding: 4px 5px !important;
            border: 1.5px solid #000 !important;
            background: #fff !important;
            color: #000 !important;
            font-size: 10.5px !important;
            font-weight: 800 !important;
        }

        .items-table td {
            padding: 4px 5px !important;
            border: 1.5px solid #000 !important;
            color: #000 !important;
            font-size: 10.5px !important;
            line-height: 1.25 !important;
        }

        .total-row td {
            border: 1.5px solid #000 !important;
            background: #fff !important;
            color: #000 !important;
            font-size: 11px !important;
            font-weight: 800 !important;
        }

        /* NOTES */

        .notes-box {
            margin-top: 6px !important;
            padding: 6px !important;
            border: 1.5px solid #000 !important;
            color: #000 !important;
            font-size: 10.5px !important;
        }

        /* SIGNATURES DE LA DEMANDE */

        .signature-section {
            margin-top: 10px !important;
        }

        .signature-title {
            margin-bottom: 6px !important;
            color: #000 !important;
            font-size: 12px !important;
            font-weight: 800 !important;
        }

        .signature-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 7px !important;
        }

        .signature-box {
            height: 66px !important;
            padding: 6px !important;
            border: 1.5px solid #000 !important;
            color: #000 !important;
            background: #fff !important;
        }

        .signature-box .title {
            margin-bottom: 5px !important;
            color: #000 !important;
            font-size: 10px !important;
            font-weight: 800 !important;
        }

        .signature-box .function {
            color: #000 !important;
            font-size: 9.5px !important;
            line-height: 1.25 !important;
        }

        /* DEUX PANNEAUX 60/40 */

        .payment-divider-line {
            height: 2px !important;
            margin-top: 10px !important;
            margin-bottom: 6px !important;
            background: #000 !important;
        }

        .payment-split {
            grid-template-columns: minmax(0, 6fr) minmax(0, 4fr) !important;
            gap: 7px !important;
        }

        .split-col {
            padding: 5px !important;
            border: 1.5px solid #000 !important;
            background: #fff !important;
            color: #000 !important;
        }

        .split-title {
            margin-bottom: 5px !important;
        }

        .split-title span {
            padding: 3px 8px !important;
            border: 2px solid #000 !important;
            color: #000 !important;
            background: #fff !important;
            font-size: 10.5px !important;
            font-weight: 800 !important;
            letter-spacing: .5px !important;
        }

        /* --- Panneau bon de paiement --- */

        .payment-summary-stack {
            gap: 0 !important;
            margin-bottom: 5px !important;
            border: 1.5px solid #000 !important;
        }

        .payment-summary {
            min-height: 34px !important;
            padding: 4px 6px !important;
            border: none !important;
            background: #fff !important;
            color: #000 !important;
        }

        .payment-summary+.payment-summary {
            border-top: 1.5px solid #000 !important;
        }

        .payment-summary-label {
            color: #000 !important;
            font-size: 9px !important;
            font-weight: 800 !important;
        }

        .payment-summary-value {
            color: #000 !important;
            font-size: 10.5px !important;
        }

        .payment-info-grid {
            gap: 2px !important;
        }

        .payment-info-item {
            padding: 2.5px 0 !important;
            border-bottom: 1.5px solid #000 !important;
            color: #000 !important;
            font-size: 9.5px !important;
            line-height: 1.25 !important;
        }

        .payment-info-label {
            width: 105px !important;
            max-width: 55% !important;
            color: #000 !important;
            font-size: 9.5px !important;
            font-weight: 800 !important;
        }

        .payment-amount {
            color: #000 !important;
            font-size: 11px !important;
            font-weight: 800 !important;
        }

        .payment-observation {
            min-height: 26px !important;
            margin-top: 4px !important;
            padding: 4px !important;
            border: 1.5px solid #000 !important;
            color: #000 !important;
            background: #fff !important;
            font-size: 9.5px !important;
        }

        .payment-signatures {
            gap: 4px !important;
            margin-top: 5px !important;
        }

        .payment-signature-box {
            border: 1.5px solid #000 !important;
            background: #fff !important;
        }

        .payment-signature-box .box-head {
            padding: 2px 3px !important;
            border-bottom: 1.5px solid #000 !important;
            background: #fff !important;
            color: #000 !important;
            font-size: 8.5px !important;
            font-weight: 800 !important;
        }

        .payment-signature-box .box-head .function {
            color: #000 !important;
            font-size: 8px !important;
        }

        .payment-signature-box .sign-area {
            min-height: 26px !important;
        }

        /* --- Panneau rapport --- */

        .fund-amount-item {
            margin-bottom: 5px !important;
            padding: 2px 0 !important;
            border-bottom: 1.5px solid #000 !important;
            color: #000 !important;
            font-size: 9.5px !important;
        }

        .fund-report-row {
            margin-bottom: 6px !important;
            font-size: 9.5px !important;
        }

        .fund-report-row .label {
            color: #000 !important;
            font-weight: 800 !important;
        }

        .fund-report-row .fill {
            height: 10px !important;
            border-bottom: 1.5px dotted #000 !important;
        }

        .fund-report-row .unit {
            color: #000 !important;
            font-size: 9px !important;
            font-weight: 800 !important;
        }

        .fund-report-sign-grid {
            grid-template-columns: 1fr !important;
            grid-template-rows: repeat(3, 1fr) !important;
            gap: 5px !important;
            padding-top: 4px !important;
        }

        .fund-sign-box {
            min-height: 28px !important;
            padding: 3px 4px !important;
            border: 1.5px solid #000 !important;
            background: #fff !important;
        }

        .fund-sign-box .caption {
            color: #000 !important;
            font-size: 8px !important;
            font-weight: 800 !important;
        }

        /* PIED DE PAGE */

        .footer {
            margin-top: 6px !important;
            padding-top: 4px !important;
            border-top: 2px solid #000 !important;
            color: #000 !important;
            font-size: 8px !important;
            line-height: 1.25 !important;
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
                    Destination :
                </span>

                <?= html_escape($achat->destination_chantier) ?>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Trésorerie :
                </span>

                <?= $achat->treasury_status === 'valide'
                    ? 'Fonds disponible'
                    : 'Fonds en attente' ?>

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

                    <th class="col-number">N°</th>

                    <th class="col-designation">Désignation</th>

                    <th class="col-quantity">Qté</th>

                    <th class="col-unit-price">PU</th>

                    <th class="col-total">Total</th>

                    <th class="col-observation">Observation</th>

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

                    <td class="text-center"><?= $index + 1 ?></td>

                    <td><?= html_escape($article->designation) ?></td>

                    <td class="text-right">
                        <?= number_format((float) $article->quantity, 2, ',', ' ') ?>
                    </td>

                    <td class="text-right">
                        <?= number_format((float) $article->unit_price, 0, ',', ' ') ?> BIF
                    </td>

                    <td class="text-right">
                        <strong>
                            <?= number_format($articleTotal, 0, ',', ' ') ?> BIF
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
                        <?= number_format($total_general, 0, ',', ' ') ?> BIF
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
                        DT. NIYIMBONA Emmanuel
                    </div>

                </div>

                <div class="signature-box">

                    <div class="title">
                        Approbation financière
                    </div>

                    <div class="function">
                        DAF. NDAGIJE Mariam
                    </div>

                </div>

            </div>

        </section>

        <!-- =====================================================
            DEUX PANNEAUX : 60% BON DE PAIEMENT | 40% RAPPORT
        ====================================================== -->

        <?php if (!empty($bonPaiement)) : ?>

        <div class="payment-divider-line"></div>

        <div class="payment-split">

            <!-- ===== 60% GAUCHE : BON DE PAIEMENT ===== -->

            <section class="split-col">

                <div class="split-title">
                    <span>Bon de paiement</span>
                </div>

                <div class="payment-summary-stack">

                    <div class="payment-summary">

                        <span class="payment-summary-label">
                            Synthèse de la demande
                        </span>

                        <div class="payment-summary-value">
                            <?= nl2br(html_escape($bonPaiement->summary)) ?>
                        </div>

                    </div>

                    <div class="payment-summary">

                        <span class="payment-summary-label">
                            Destination / Chantier
                        </span>

                        <div class="payment-summary-value">
                            <?= html_escape($achat->destination_chantier) ?>
                        </div>

                    </div>

                </div>

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

                    <div class="fund-amount-item">

                        <span class="payment-info-label">
                            Montant autorisé :
                        </span>

                        <!-- <span class="payment-amount">
                            <?= number_format((float) $bonPaiement->amount_paid, 0, ',', ' ') ?> BIF
                        </span> -->

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

                </div>

                <?php if (!empty($bonPaiement->observation)) : ?>

                <div class="payment-observation">

                    <strong>Observation :</strong><br>

                    <?= nl2br(html_escape($bonPaiement->observation)) ?>

                </div>

                <?php endif; ?>

                <div class="payment-signatures">

                    <div class="payment-signature-box treasury">

                        <div class="box-head">
                            Trésorerie
                            <span class="function">
                                / AHISHAKIYE Nelly Ange
                            </span>
                        </div>

                        <div class="sign-area"></div>

                    </div>

                    <div class="payment-signature-box remise">

                        <div class="box-head">
                            Pour la remise de fonds
                        </div>

                        <div class="sign-area"></div>

                    </div>

                    <div class="payment-signature-box reception">

                        <div class="box-head">
                            Pour la réception de fonds
                        </div>

                        <div class="sign-area"></div>

                    </div>

                </div>

            </section>

            <!-- ===== 40% DROITE : RAPPORT D'UTILISATION DES FONDS ===== -->

            <section class="split-col">

                <div class="split-title">
                    <span>Rapport d'utilisation des fonds</span>
                </div>

                <div class="fund-body">

                    <!-- <div class="fund-amount-item">

                            <span class="payment-info-label">
                                Montant payé :
                            </span>

                            <span class="payment-amount">
                                <?= number_format((float) $bonPaiement->amount_paid, 0, ',', ' ') ?> BIF
                            </span>

                        </div> -->

                    <div class="fund-report-row">

                        <span class="label">Montant dépensé :</span>

                        <span class="fill"></span>

                        <span class="unit">BIF</span>

                    </div>

                    <div class="fund-report-row">

                        <span class="label">Retour caisse :</span>

                        <span class="fill"></span>

                        <span class="unit">BIF</span>

                    </div>

                    <div class="fund-report-row">

                        <span class="label">Supplément à payer :</span>

                        <span class="fill"></span>

                        <span class="unit">BIF</span>

                    </div>

                    <!-- 3 rectangles pleine largeur,
                             empilés, qui remplissent tout l'espace vide -->

                    <div class="fund-report-sign-grid">

                        <div class="fund-sign-box">

                            <div class="caption">Rapporté par :</div>

                        </div>

                        <div class="fund-sign-box">

                            <div class="caption">Vérifié par :</div>

                        </div>

                        <div class="fund-sign-box">

                            <div class="caption">Validé par :</div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

        <?php endif; ?>

        <!-- =====================================================
            PIED DE PAGE
        ====================================================== -->

        <!-- <footer class="footer">

            © <?= date('Y') ?>
            SATRACO Construction -
            Document généré automatiquement par
            Construction Management System (CMS).

            <br>

            Adresse :
            Bujumbura, Commune NTAHANGWA,
            Zone Ngagara, Quartier Industriel,
            Numéro 15

        </footer> -->

    </div>

</body>

</html>