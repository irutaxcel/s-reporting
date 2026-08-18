<?php
$isPrincipal = ($cashboxRole === 'principale');
$fmt = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$dfr = function ($d) {
    return empty($d) ? '—' : date('d/m/Y', strtotime($d));
};

$totalIn = 0;
$totalOut = 0;
foreach ($movements as $m) {
    if ($m->sens === 'entree') {
        $totalIn += (float) $m->amount;
    } else {
        $totalOut += (float) $m->amount;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= html_escape($title) ?> — <?= html_escape($cashbox->code) ?></title>
    <!-- Icônes Font Awesome (boutons Imprimer / Fermer) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        color: #111;
        margin: 20px;
    }

    /* =====================================================
           BARRE HAUTE : LOGO (gauche) + ACTIONS (droite)
        ===================================================== */
    .print-topbar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .topbar-logo img {
        height: 60px;
        width: auto;
    }

    /* Repli texte si l'image du logo est introuvable */
    .logo-fallback {
        display: none;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 2px;
        color: #4a7a3a;
    }

    .topbar-actions button {
        padding: 9px 16px;
        margin-left: 8px;
        border: 1px solid #333;
        border-radius: 6px;
        background: #fff;
        font-weight: 700;
        cursor: pointer;
    }

    .topbar-actions button:hover {
        background: #eee;
    }

    .head {
        text-align: center;
        margin-bottom: 14px;
    }

    h1 {
        display: inline-block;
        font-size: 17px;
        margin: 10px 0 6px;
        text-transform: uppercase;
        border: 1.5px solid #111;
        padding: 4px 18px;
    }

    .meta {
        font-size: 11px;
        margin: 3px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
    }

    th,
    td {
        border: 1px solid #111;
        padding: 5px 6px;
        vertical-align: top;
    }

    th {
        background: #efefef;
        font-size: 9px;
        text-transform: uppercase;
        text-align: left;
    }

    td.num,
    th.num {
        text-align: right;
        white-space: nowrap;
    }

    td.ctr {
        text-align: center;
    }

    .sig {
        display: block;
        height: 16px;
        border-bottom: 1px solid #111;
        margin-top: 3px;
    }

    tfoot td {
        font-weight: 700;
        background: #f7f7f7;
    }

    .foot-note {
        margin-top: 10px;
        font-size: 9px;
    }

    @page {
        size: A4 landscape;
        margin: 8mm;
    }

    @media print {

        /* Les boutons disparaissent à l'impression, le logo reste */
        .topbar-actions {
            display: none !important;
        }

        body {
            margin: 0;
        }
    }
    </style>
</head>

<body>

    <!-- =====================================================
         BARRE HAUTE : LOGO (gauche) + BOUTONS (droite)
    ======================================================= -->
    <div class="print-topbar">
        <!-- Logo à gauche (remplace le chemin par ton vrai fichier logo) -->
        <div class="topbar-logo">
            <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO Construction"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            <span class="logo-fallback">SATRACO CONSTRUCTION</span>
        </div>

        <!-- Boutons à droite (masqués à l'impression) -->
        <div class="topbar-actions">
            <button onclick="window.print()"><i class="fas fa-print"></i> Imprimer</button>
            <button onclick="window.close()"><i class="fas fa-times"></i> Fermer</button>
        </div>
    </div>

    <!-- =====================================================
         TITRE CENTRÉ (comme le modèle papier)
    ======================================================= -->
    <div class="head">
        <h1><?= $isPrincipal ? 'Livre de caisse principal' : 'Livre de caisse secondaire' ?></h1>
        <div class="meta">
            <strong>Caisse :</strong> <?= html_escape($cashbox->name) ?> (<?= html_escape($cashbox->code) ?>)
            · <strong>Responsable :</strong>
            <?= html_escape(!empty($cashbox->responsable) ? $cashbox->responsable : '—') ?>
            · <strong>Devise :</strong> <?= html_escape($cashbox->devise) ?>
            · <strong>Édité le :</strong> <?= date('d/m/Y H:i') ?>
        </div>
    </div>

    <?php if ($isPrincipal): ?>
    <!-- =====================================================
     LIVRE DE CAISSE PRINCIPAL (modèle papier)
====================================================== -->
    <table>
        <thead>
            <tr>
                <th style="width:4%;">N°</th>
                <th style="width:9%;">Date</th>
                <th style="width:11%;">Entrées</th>
                <th style="width:15%;">Sources de fonds</th>
                <th style="width:12%;" class="num">Montant décaissé en BIF</th>
                <th style="width:11%;" class="num">Solde restant</th>
                <th style="width:19%;">Destination</th>
                <th style="width:19%;">Nom de la pers. qui a réceptionné les fonds</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($movements)): ?>
            <?php foreach ($movements as $i => $m): ?>
            <?php
                        $isIn = ($m->sens === 'entree');

                        /* Sources de fonds */
                        if ($m->nature === 'encaissement') {
                            $source = !empty($m->third_party) ? $m->third_party : $m->label;
                        } elseif ($m->nature === 'solde_initial') {
                            $source = 'Solde initial';
                        } else {
                            $source = '—'; /* sortie : tiret */
                        }

                        /* Destination + réception (approvisionnement) */
                        $destination = '—';
                        $reception   = '';
                        if ($m->nature === 'approvisionnement') {
                            $destination = $m->label;
                            if ($secondaryCashbox) {
                                $destination .= ' — ' . $secondaryCashbox->name
                                    . ' (' . $secondaryCashbox->code . ')';
                                $reception = !empty($secondaryCashbox->responsable)
                                    ? $secondaryCashbox->responsable : '';
                            }
                            if (!empty($m->transfer_reference)) {
                                $destination .= ' · ' . $m->transfer_reference;
                            }
                        }
                        ?>
            <tr>
                <td class="ctr"><?= $i + 1 ?></td>
                <td><?= $dfr($m->movement_date) ?></td>
                <td class="num"><?= $isIn ? $fmt($m->amount) : '' ?></td>
                <td><?= html_escape($source) ?></td>
                <td class="num"><?= !$isIn ? $fmt($m->amount) : '' ?></td>
                <td class="num"><?= $fmt($m->balance_after) ?></td>
                <td><?= html_escape($destination) ?></td>
                <td><?= html_escape($reception) ?><span class="sig"></span></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="8" class="ctr">Aucun mouvement dans ce livre.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">TOTAUX</td>
                <td class="num"><?= $fmt($totalIn) ?></td>
                <td></td>
                <td class="num"><?= $fmt($totalOut) ?></td>
                <td class="num"><?= $fmt($totalIn - $totalOut) ?></td>
                <td colspan="2">Solde final : <?= $fmt((float) $cashbox->current_balance) ?>
                    <?= html_escape($cashbox->devise) ?></td>
            </tr>
        </tfoot>
    </table>

    <?php else: ?>
    <!-- =====================================================
     LIVRE DE CAISSE SECONDAIRE (modèle papier)
====================================================== -->
    <table>
        <thead>
            <tr>
                <th style="width:3%;">N°</th>
                <th style="width:7%;">Date</th>
                <th style="width:8%;" class="num">Entrées dans la caisse</th>
                <th style="width:11%;">Source de fonds</th>
                <th style="width:8%;" class="num">Sorties de la caisse</th>
                <th style="width:8%;" class="num">Solde restant dans la caisse</th>
                <th style="width:17%;">Justification de la dépense</th>
                <th style="width:14%;">Catégorie fonctionnement ou intitulé du chantier / projet</th>
                <th style="width:10%;">N° de réf. de demande d'achat des biens et services</th>
                <th style="width:14%;">Nom, prénom et signature pour réception des fonds</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($movements)): ?>
            <?php foreach ($movements as $i => $m): ?>
            <?php
                        $isIn = ($m->sens === 'entree');

                        /* Source de fonds */
                        if ($m->nature === 'approvisionnement_recu') {
                            $source = $principalCashbox
                                ? $principalCashbox->name . ' (' . $principalCashbox->code . ')'
                                : 'Caisse principale';
                        } elseif ($m->nature === 'solde_initial') {
                            $source = 'Solde initial';
                        } else {
                            $source = '—';
                        }

                        /* Justification + catégorie + réf DA + signature */
                        $justification = $m->label;
                        $categorie     = !empty($m->category) ? $m->category
                            : (!empty($m->da_chantier_name) ? $m->da_chantier_name
                                : (!empty($m->da_destination) ? $m->da_destination : '—'));
                        $refDa         = !empty($m->purchase_request_reference) ? $m->purchase_request_reference
                            : (!empty($m->transfer_reference) ? $m->transfer_reference : '—');
                        $signature     = !empty($m->third_party) ? $m->third_party
                            : (!empty($cashbox->responsable) ? $cashbox->responsable : '');
                        ?>
            <tr>
                <td class="ctr"><?= $i + 1 ?></td>
                <td><?= $dfr($m->movement_date) ?></td>
                <td class="num"><?= $isIn ? $fmt($m->amount) : '' ?></td>
                <td><?= html_escape($source) ?></td>
                <td class="num"><?= !$isIn ? $fmt($m->amount) : '' ?></td>
                <td class="num"><?= $fmt($m->balance_after) ?></td>
                <td><?= html_escape($justification) ?></td>
                <td><?= html_escape($categorie) ?></td>
                <td><?= html_escape($refDa) ?></td>
                <td><?= html_escape($signature) ?><span class="sig"></span></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="10" class="ctr">Aucun mouvement dans ce livre.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">TOTAUX</td>
                <td class="num"><?= $fmt($totalIn) ?></td>
                <td></td>
                <td class="num"><?= $fmt($totalOut) ?></td>
                <td class="num"><?= $fmt($totalIn - $totalOut) ?></td>
                <td colspan="4">Solde final : <?= $fmt((float) $cashbox->current_balance) ?>
                    <?= html_escape($cashbox->devise) ?></td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>

    <div class="foot-note">
        Catégorie de fonctionnement : 1. Carburant et lubrifiants ; 2. Entretien/réparation des véhicules, motos ;
        3. Entretien/réparation des équipements informatiques, de bureau ; 4. Fourniture/équipement de bureau,
        d'hygiène, de nettoyage, d'informatique ; 5. Entretien des locaux/bâtiments ; 6. Entretien des jardins ;
        7. Restauration du personnel ; etc.
    </div>

    <script>
    /* Ouvre directement la boîte d'impression à l'arrivée
       (supprime cette ligne si tu préfères cliquer sur le bouton) */
    window.addEventListener('load', function() {
        setTimeout(function() {
            window.print();
        }, 400);
    });
    </script>
</body>

</html>