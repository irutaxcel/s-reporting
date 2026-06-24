<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Personnel Chantier' ?></title>

    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 13px;
        color: #111;
        background: #f4f6f9;
        margin: 0;
        padding: 20px;
    }

    .print-page {
        background: #fff;
        max-width: 1100px;
        margin: auto;
        padding: 25px;
        border: 1px solid #ddd;
    }

    .print-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 2px solid #ddd;
        padding-bottom: 20px;
        margin-bottom: 25px;
    }

    .company-logo img {
        width: 120px;
    }

    .report-title {
        text-align: center;
        flex: 1;
    }

    .report-title h2 {
        margin: 20px 0 10px;
        font-size: 24px;
    }

    .report-title .line {
        width: 140px;
        height: 3px;
        background: #14883e;
        margin: 0 auto 15px;
    }

    .company-info {
        width: 260px;
        line-height: 1.8;
    }

    .print-btn {
        background: #0d6efd;
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        margin-top: 10px;
    }

    .chantier-card {
        border: 1px solid #ddd;
        margin-bottom: 25px;
        border-radius: 5px;
        overflow: hidden;
    }

    .chantier-header {
        background: #15913b;
        color: #fff;
        padding: 12px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
    }

    .badge {
        background: #fff;
        color: #111;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background: #f5f5f5;
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .total-row {
        font-weight: bold;
        background: #f7f7f7;
    }

    .general-total {
        margin-top: 25px;
        padding: 18px;
        border: 1px solid #cfe8d5;
        background: #f2fff5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 18px;
        font-weight: bold;
        color: #0f6b2f;
    }

    .print-footer {
        border-top: 2px solid #15913b;
        margin-top: 35px;
        padding-top: 18px;
        display: flex;
        justify-content: space-between;
        font-size: 12px;
    }

    @media print {
        body {
            background: #fff;
            padding: 0;
        }

        .print-page {
            border: none;
            max-width: 100%;
        }

        .print-btn {
            display: none;
        }
    }
    </style>
</head>

<body>

    <div class="print-page">

        <div class="print-header">

            <div class="company-logo">
                <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO">
            </div>

            <div class="report-title">
                <h2>LISTE DU PERSONNEL CHANTIER</h2>
                <div class="line"></div>
                <p>
                    Période :
                    <strong><?= date('d-m-Y', strtotime($debut_semaine)) ?></strong>
                    au
                    <strong><?= date('d-m-Y', strtotime($fin_semaine)) ?></strong>
                </p>
            </div>

            <div class="company-info">
                <strong>NIF :</strong> 1002003004005<br>
                <strong>REGISTRE DE COMMERCE :</strong><br>
                RCCM/BUJ/2020/B/12345<br>
                <strong>TÉL :</strong> +257 68 13 13 13<br>
                <strong>EMAIL :</strong> info@satracoconstruction.com<br>

                <button onclick="window.print()" class="print-btn">
                    🖨 Imprimer
                </button>
            </div>

        </div>

        <?php foreach ($allChantier as $chantier) : ?>

        <?php
            $personnels = $this->tech->getPersonlChantier(
                $chantier->id,
                $debut_semaine,
                $fin_semaine
            );

            if (empty($personnels)) {
                continue;
            }

            $index = 1;
            $total_chantier = 0;
            ?>

        <div class="chantier-card">

            <div class="chantier-header">
                <span>Chantier : <?= $chantier->name ?></span>
                <span class="badge"><?= count($personnels) ?> Personnel(s)</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Nom</th>
                        <th>Fonction</th>
                        <th>Montant</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Date saisie</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($personnels as $persl) : ?>
                    <?php $total_chantier += (float) $persl->unit_rate; ?>

                    <tr>
                        <td class="text-center"><?= $index++ ?></td>
                        <td><?= $persl->worker_name ?></td>
                        <td><?= $persl->function_name ?></td>
                        <td><?= number_format($persl->unit_rate, 0, ',', ' ') ?> FBU</td>
                        <td><?= !empty($persl->start_date) ? date('d-m-Y', strtotime($persl->start_date)) : '-' ?></td>
                        <td><?= !empty($persl->end_date) ? date('d-m-Y', strtotime($persl->end_date)) : '-' ?></td>
                        <td><?= !empty($persl->created_at) ? date('d-m-Y H:i', strtotime($persl->created_at)) : '-' ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <tr class="total-row">
                        <td></td>
                        <td colspan="2">Total chantier</td>
                        <td><?= number_format($total_chantier, 0, ',', ' ') ?> FBU</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>

        </div>

        <?php endforeach; ?>

        <div class="general-total">
            <span>TOTAL GÉNÉRAL</span>
            <span><?= number_format($montant_total ?? 0, 0, ',', ' ') ?> FBU</span>
        </div>

        <div class="print-footer">
            <div>
                <strong>SATRACO Construction</strong><br>
                Bujumbura, Commune NTAHANGWA,<br>
                ZONE NGAGARA, Q. INDUSTRIEL, Numero 15
            </div>

            <div>
                Tél : +257 68 13 13 13<br>
                Email : info@satracoconstruction.com<br>
                Site web : https://satracoconstruction.com
            </div>

            <div>
                Imprimé le : <?= date('d-m-Y à H:i') ?><br>
                Page 1 / 1
            </div>
        </div>

    </div>

</body>

</html>