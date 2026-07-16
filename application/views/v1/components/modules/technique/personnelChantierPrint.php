<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Personnel Chantier' ?></title>

    <style>
    @page {
        size: A4 portrait;
        margin: 10mm;
    }

    body {
        margin: 0;
        padding: 20px;
        background: #f4f6f9;
        font-family: Arial, sans-serif;
        color: #111;
    }

    .chantier-page {
        box-sizing: border-box;
        width: 210mm;
        min-height: 277mm;
        margin: 0 auto 25px;
        padding: 10mm;
        background: #ffffff;
        border: 1px solid #dddddd;

        display: flex;
        flex-direction: column;
    }

    .print-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;

        border-bottom: 2px solid #dddddd;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .company-logo {
        width: 20%;
    }

    .company-logo img {
        display: block;
        width: 105px;
        height: auto;
    }

    .report-title {
        width: 48%;
        text-align: center;
    }

    .report-title h2 {
        margin: 8px 0;
        font-size: 21px;
    }

    .report-title h3 {
        margin: 8px 0;
        font-size: 16px;
        color: #15913b;
    }

    .report-title p {
        margin: 8px 0 0;
    }

    .report-title .line {
        width: 120px;
        height: 3px;
        margin: 0 auto;
        background: #15913b;
    }

    .company-info {
        width: 32%;
        font-size: 12px;
        line-height: 1.7;
    }

    .print-btn {
        margin-top: 10px;
        padding: 9px 16px;
        border: 0;
        border-radius: 4px;
        background: #0d6efd;
        color: #ffffff;
        font-weight: 700;
        cursor: pointer;
    }

    .chantier-card {
        border: 1px solid #dddddd;
        border-radius: 4px;
        overflow: hidden;
    }

    .chantier-header {
        display: flex;
        justify-content: space-between;
        align-items: center;

        padding: 11px 12px;
        background: #15913b;
        color: #ffffff;
        font-weight: 700;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        background: #ffffff;
        color: #111111;
        font-size: 11px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 7px;
        border: 1px solid #dddddd;
        font-size: 12px;
    }

    th {
        background: #f5f5f5;
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .total-row {
        background: #f7f7f7;
        font-weight: 700;
    }

    .signature-zone {
        display: flex;
        justify-content: space-between;
        gap: 30px;

        margin-top: 40px;
    }

    .signature-item {
        width: 31%;
        text-align: center;
        font-size: 12px;
    }

    .signature-space {
        height: 50px;
        margin-bottom: 7px;
        border-bottom: 1px solid #555555;
    }

    .signature-item span {
        font-size: 10px;
        color: #666666;
    }

    .print-footer {
        display: flex;
        justify-content: space-between;

        margin-top: auto;
        padding-top: 12px;
        border-top: 2px solid #15913b;

        font-size: 10px;
        line-height: 1.4;
    }

    @media print {

        html,
        body {
            width: 210mm;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        .chantier-page {
            width: 100%;
            min-height: 277mm;
            margin: 0;
            padding: 8mm;
            border: 0;

            page-break-after: always;
            break-after: page;
            page-break-inside: avoid;
            break-inside: avoid-page;
        }

        .chantier-page:last-child {
            page-break-after: auto;
            break-after: auto;
        }

        .print-btn {
            display: none !important;
        }

        .chantier-card,
        table,
        tr,
        td,
        th {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .print-header {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .signature-zone,
        .print-footer {
            page-break-inside: avoid;
            break-inside: avoid;
        }
    }
    </style>
</head>

<body>

    <div class="print-page">



        <?php
        $chantiers_a_imprimer = [];

        foreach ($allChantier as $chantier) {

            $personnels = $this->tech->getPersonlChantier(
                $chantier->id,
                $debut_semaine,
                $fin_semaine
            );

            // Ne pas créer de feuille pour un chantier vide
            if (!empty($personnels)) {
                $chantiers_a_imprimer[] = [
                    'chantier'  => $chantier,
                    'personnels' => $personnels
                ];
            }
        }
        ?>

        <?php foreach ($chantiers_a_imprimer as $position => $item) : ?>

        <?php
            $chantier       = $item['chantier'];
            $personnels     = $item['personnels'];
            $index          = 1;
            $total_chantier = 0;
            ?>

        <section class="chantier-page">

            <!-- =========================
             EN-TÊTE DE LA FEUILLE
        ========================== -->
            <div class="print-header">

                <div class="company-logo">
                    <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="Logo SATRACO">
                </div>

                <div class="report-title">
                    <h2>LISTE DU PERSONNEL CHANTIER</h2>

                    <div class="line"></div>

                    <h3>
                        <?= strtoupper(htmlspecialchars($chantier->name, ENT_QUOTES, 'UTF-8')) ?>
                    </h3>

                    <p>
                        Période :
                        <strong>
                            <?= date('d-m-Y', strtotime($debut_semaine)) ?>
                        </strong>

                        au

                        <strong>
                            <?= date('d-m-Y', strtotime($fin_semaine)) ?>
                        </strong>
                    </p>
                </div>

                <div class="company-info">
                    <strong>NIF :</strong> 4000070948<br>
                    <strong>R.C :</strong> 46865<br>

                    <strong>TÉL :</strong>
                    +257 68 13 13 13 /
                    +257 22 24 50 97<br>

                    <strong>EMAIL :</strong>
                    info@satracoconstruction.com

                    <?php if ($position === 0) : ?>
                    <br>

                    <button type="button" onclick="window.print()" class="print-btn">

                        <i class="fas fa-print"></i>
                        Imprimer
                    </button>
                    <?php endif; ?>
                </div>

            </div>


            <!-- =========================
             PERSONNEL DU CHANTIER
        ========================== -->
            <div class="chantier-card">

                <div class="chantier-header">

                    <span>
                        Chantier :
                        <?= htmlspecialchars($chantier->name, ENT_QUOTES, 'UTF-8') ?>
                    </span>

                    <span class="badge">
                        <?= count($personnels) ?> Personnel(s)
                    </span>

                </div>

                <table>

                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Nom</th>
                            <th>Fonction</th>
                            <th>Montant</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Signature</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($personnels as $persl) : ?>

                        <?php
                                $montant = (float) ($persl->unit_rate ?? 0);
                                $total_chantier += $montant;
                                ?>

                        <tr>
                            <td class="text-center">
                                <?= $index++ ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                            $persl->worker_name ?? '-',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                            $persl->function_name ?? '-',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                            </td>

                            <td>
                                <?= number_format($montant, 0, ',', ' ') ?>
                                FBU
                            </td>

                            <td>
                                <?= !empty($persl->start_date)
                                            ? date('d-m-Y', strtotime($persl->start_date))
                                            : '-' ?>
                            </td>

                            <td>
                                <?= !empty($persl->end_date)
                                            ? date('d-m-Y', strtotime($persl->end_date))
                                            : '-' ?>
                            </td>

                            <td></td>
                        </tr>

                        <?php endforeach; ?>

                        <tr class="total-row">
                            <td></td>

                            <td colspan="2">
                                Total chantier
                            </td>

                            <td>
                                <?= number_format(
                                        $total_chantier,
                                        0,
                                        ',',
                                        ' '
                                    ) ?>
                                FBU
                            </td>

                            <td colspan="3"></td>
                        </tr>

                    </tbody>

                </table>

            </div>


            <!-- =========================
             SIGNATURES
        ========================== -->
            <div class="signature-zone">

                <div class="signature-item">
                    <strong>Préparé par</strong>

                    <div class="signature-space"></div>

                    <span>Nom et signature</span>
                </div>

                <div class="signature-item">
                    <strong>Chef de chantier</strong>

                    <div class="signature-space"></div>

                    <span>Nom et signature</span>
                </div>

                <div class="signature-item">
                    <strong>Réception du personnel</strong>

                    <div class="signature-space"></div>

                    <span>Nom et signature</span>
                </div>

            </div>


            <!-- =========================
             PIED DE PAGE DE LA FEUILLE
        ========================== -->
            <div class="print-footer">

                <div>
                    <strong>SATRACO Construction</strong><br>
                    Bujumbura, Commune NTAHANGWA<br>
                    Zone NGAGARA, Quartier Industriel, Numéro 15
                </div>

                <div>
                    Tél :
                    +257 68 13 13 13 /
                    +257 22 24 50 97<br>

                    Email :
                    info@satracoconstruction.com<br>

                    Site web :
                    https://satracoconstruction.com
                </div>

            </div>

        </section>

        <?php endforeach; ?>



    </div>

</body>

</html>