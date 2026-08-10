<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Journal de Production - <?= $journal->reference ?></title>
    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        color: #222;
        margin: 30px;
    }

    .header {
        text-align: center;
        border-bottom: 2px solid #2d6a4f;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .header h1 {
        margin: 0;
        font-size: 20px;
        text-transform: uppercase;
        color: #2d6a4f;
    }

    .header p {
        margin: 2px 0;
        font-size: 12px;
    }

    .title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin: 15px 0;
        text-transform: uppercase;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    th,
    td {
        border: 1px solid #444;
        padding: 6px 8px;
        text-align: left;
        vertical-align: top;
    }

    th {
        background: #eee;
    }

    .label {
        width: 200px;
        font-weight: bold;
        background: #eee;
    }

    .right {
        text-align: right;
    }

    .center {
        text-align: center;
    }

    .signatures table td {
        border: none;
        height: 80px;
    }

    .no-print {
        text-align: center;
        margin-top: 20px;
    }

    @media print {
        .no-print {
            display: none;
        }
    }
    </style>
</head>

<body onload="window.print()">

    <?php
    $statutLabel = [
        'valide'     => 'Validé',
        'en_attente' => 'En attente',
        'brouillon'  => 'Brouillon',
    ];
    $statut = $statutLabel[$journal->statut] ?? ucfirst($journal->statut);

    $totalH = 0;
    $totalC = 0;
    foreach ($engins as $e) {
        $totalH += (float) $e->heures_utilisation;
        $totalC += (float) $e->carburant_l;
    }
    ?>

    <!-- En-tête société -->
    <div class="header">
        <h1>SATRACO Construction</h1>
        <p>Construction Management System (CMS)</p>
    </div>

    <div class="title">Journal de Production - <?= html_escape($journal->reference) ?></div>

    <!-- Informations générales -->
    <table>
        <tr>
            <td class="label">Date du journal</td>
            <td><?= date('d/m/Y', strtotime($journal->journal_date)) ?></td>
            <td class="label">Statut</td>
            <td><?= $statut ?></td>
        </tr>
        <tr>
            <td class="label">Chantier</td>
            <td><?= html_escape($journal->chantier_name) ?></td>
            <td class="label">Chef de chantier</td>
            <td><?= html_escape($journal->chef_chantier) ?></td>
        </tr>
        <tr>
            <td class="label">Météo</td>
            <td><?= html_escape($journal->meteo) ?></td>
            <td class="label">Heures travaillées</td>
            <td><?= ($journal->heures_travaillees + 0) ?> h</td>
        </tr>
        <tr>
            <td class="label">Ouvriers internes</td>
            <td><?= $journal->effectif_interne ?></td>
            <td class="label">Ouvriers sous-traitants</td>
            <td><?= $journal->effectif_sous_traitant ?></td>
        </tr>
    </table>

    <!-- Engins & matériel -->
    <table>
        <thead>
            <tr>
                <th class="center" style="width:40px">#</th>
                <th>Engin / Matériel</th>
                <th class="right" style="width:150px">Heures d'utilisation</th>
                <th class="right" style="width:150px">Carburant (L)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($engins)) : ?>
            <?php $i = 1; ?>
            <?php foreach ($engins as $e) : ?>
            <tr>
                <td class="center"><?= $i++ ?></td>
                <td><?= html_escape($e->engin_name ?: '-') ?></td>
                <td class="right"><?= ($e->heures_utilisation + 0) ?></td>
                <td class="right"><?= ($e->carburant_l + 0) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else : ?>
            <tr>
                <td colspan="4" class="center">Aucun engin utilisé.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="right">Totaux</th>
                <th class="right"><?= ($totalH + 0) ?> h</th>
                <th class="right"><?= ($totalC + 0) ?> L</th>
            </tr>
        </tfoot>
    </table>

    <!-- Travaux réalisés -->
    <table>
        <tr>
            <th class="label">Travaux réalisés (production du jour)</th>
        </tr>
        <tr>
            <td style="min-height:60px"><?= nl2br(html_escape($journal->travaux_realises ?: '-')) ?></td>
        </tr>
    </table>

    <!-- Observations -->
    <table>
        <tr>
            <th class="label">Observations / incidents</th>
        </tr>
        <tr>
            <td style="min-height:50px"><?= nl2br(html_escape($journal->observations ?: '-')) ?></td>
        </tr>
    </table>

    <!-- Signatures -->
    <div class="signatures">
        <table>
            <tr>
                <td class="center" style="width:33%"><strong>Le Chef de chantier</strong></td>
                <td class="center" style="width:33%"><strong>La Direction Technique</strong></td>
                <td class="center" style="width:33%"><strong>La Direction Générale</strong></td>
            </tr>
        </table>
    </div>

    <!-- Bouton visible uniquement à l'écran -->
    <div class="no-print">
        <button onclick="window.print()" style="padding:8px 20px; cursor:pointer;">
            🖨️ Imprimer
        </button>
    </div>

</body>

</html>