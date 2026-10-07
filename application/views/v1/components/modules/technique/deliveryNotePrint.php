<?php
$e  = function ($s) {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
};
$fd = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '';
};
$nf = function ($n) {
    return number_format((float) $n, 2, ',', ' ');
};

$statusLabels = [
    'livre'     => ['Livraison complète', 'st-ok'],
    'partiel'   => ['Livraison partielle', 'st-part'],
    'non_livre' => ['Non livrée', 'st-none'],
];
$st = isset($statusLabels[$note->delivery_status]) ? $statusLabels[$note->delivery_status] : $statusLabels['non_livre'];

$totalOrdered  = 0;
$totalReceived = 0;
foreach ($items as $it) {
    $totalOrdered  += (float) $it->quantity_ordered;
    $totalReceived += (float) $it->quantity_received;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $e($note->delivery_number) ?> — Bon de livraison</title>
    <style>
    :root {
        --brand: #4e9a3f;
        --brand-dark: #2f6b25;
        --brand-soft: #eef6ec;
        --ink: #1f2933;
        --muted: #6b7280;
        --line: #d9dee3;
    }

    @page {
        size: A4;
        margin: 12mm;
    }

    * {
        box-sizing: border-box;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    body {
        font-family: "Segoe UI", Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: var(--ink);
        margin: 0;
        background: #f1f3f5;
    }

    .page {
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto 20px;
        background: #fff;
        padding: 14mm 14mm 10mm;
        position: relative;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
        display: flex;
        flex-direction: column;
    }

    /* En-tête */
    .head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand img {
        height: 64px;
        width: auto;
    }

    .brand .name {
        font-size: 18px;
        font-weight: 700;
        color: var(--brand-dark);
        line-height: 1.2;
    }

    .brand .sub {
        font-size: 11px;
        color: var(--muted);
    }

    .doc {
        text-align: right;
    }

    .doc .title {
        display: inline-block;
        background: var(--brand);
        color: #fff;
        font-weight: 700;
        font-size: 16px;
        letter-spacing: 1.5px;
        padding: 7px 14px;
        border-radius: 4px;
    }

    .doc .num {
        font-size: 15px;
        font-weight: 700;
        margin-top: 6px;
    }

    .doc .date {
        color: var(--muted);
        margin-top: 2px;
    }

    .bar {
        height: 4px;
        background: linear-gradient(90deg, var(--brand-dark), var(--brand));
        border-radius: 2px;
        margin-bottom: 16px;
    }

    /* Blocs d'info */
    .cards {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
    }

    .card {
        flex: 1;
        border: 1px solid var(--line);
        border-radius: 6px;
        overflow: hidden;
    }

    .card h3 {
        margin: 0;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--brand-dark);
        background: var(--brand-soft);
        padding: 7px 10px;
        border-bottom: 1px solid var(--line);
    }

    .card table {
        width: 100%;
        border-collapse: collapse;
    }

    .card td {
        padding: 6px 10px;
        border-bottom: 1px solid #f0f2f4;
        vertical-align: top;
    }

    .card tr:last-child td {
        border-bottom: none;
    }

    .card td.l {
        color: var(--muted);
        width: 42%;
    }

    .card td.v {
        font-weight: 600;
    }

    .blank {
        display: inline-block;
        min-width: 120px;
        border-bottom: 1px dotted #9aa3ab;
        height: 14px;
    }

    .status {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 10.5px;
        font-weight: 700;
    }

    .st-ok {
        background: #d4edda;
        color: #1e6b31;
    }

    .st-part {
        background: #fff3cd;
        color: #8a6100;
    }

    .st-none {
        background: #e2e3e5;
        color: #41464b;
    }

    /* Lignes */
    .lines {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 14px;
    }

    .lines th {
        background: var(--brand-dark);
        color: #fff;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 8px 10px;
        text-align: left;
    }

    .lines td {
        padding: 8px 10px;
        border-bottom: 1px solid var(--line);
    }

    .lines tbody tr:nth-child(even) td {
        background: #fafbfc;
    }

    .lines .c {
        text-align: center;
        width: 17%;
    }

    .lines .n {
        width: 6%;
        text-align: center;
        color: var(--muted);
    }

    .lines tfoot td {
        font-weight: 700;
        background: var(--brand-soft);
        border-top: 2px solid var(--brand);
    }

    .obs-label {
        font-weight: 700;
        color: var(--brand-dark);
        margin-bottom: 5px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .6px;
    }

    .obs {
        border: 1px solid var(--line);
        border-radius: 6px;
        padding: 8px 10px;
        min-height: 50px;
        margin-bottom: 22px;
    }

    /* Signatures */
    .sign {
        display: flex;
        gap: 20px;
        margin-top: auto;
    }

    .sign>div {
        flex: 1;
        border: 1px solid var(--line);
        border-radius: 6px;
        padding: 10px 12px;
    }

    .sign .role {
        font-weight: 700;
        color: var(--brand-dark);
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: .6px;
        margin-bottom: 10px;
    }

    .sign .row {
        display: flex;
        align-items: flex-end;
        margin-bottom: 9px;
    }

    .sign .row span {
        color: var(--muted);
        width: 70px;
    }

    .sign .row i {
        flex: 1;
        border-bottom: 1px dotted #9aa3ab;
        height: 14px;
    }

    .sign .sig {
        height: 55px;
        border: 1px dashed #c4cad0;
        border-radius: 4px;
        margin-top: 4px;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        color: #b0b7be;
        font-size: 10px;
        padding-bottom: 3px;
    }

    .foot {
        margin-top: 18px;
        padding-top: 8px;
        border-top: 1px solid var(--line);
        display: flex;
        justify-content: space-between;
        font-size: 9.5px;
        color: var(--muted);
    }

    /* Barre d'actions écran */
    .actions {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #fff;
        border-bottom: 1px solid var(--line);
        text-align: center;
        padding: 10px;
        margin-bottom: 20px;
    }

    .actions button {
        padding: 8px 18px;
        font-size: 13px;
        cursor: pointer;
        border-radius: 4px;
        border: 1px solid var(--line);
        background: #fff;
        margin: 0 4px;
    }

    .actions button.primary {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
    }

    @media print {
        body {
            background: #fff;
        }

        .actions {
            display: none;
        }

        .page {
            width: auto;
            min-height: calc(297mm - 24mm);
            margin: 0;
            padding: 0;
            box-shadow: none;
        }
    }
    </style>
</head>

<body>

    <div class="actions">
        <button class="primary" onclick="window.print()">🖨 Imprimer</button>
        <button onclick="window.close()">Fermer</button>
    </div>

    <div class="page">

        <!-- EN-TÊTE -->
        <div class="head">
            <div class="brand">
                <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="Logo SATRACO">
                <div>
                    <div class="name">SATRACO Construction</div>
                    <div class="sub">Direction Technique — Réception des achats</div>
                </div>
            </div>
            <div class="doc">
                <div class="title">BON DE LIVRAISON</div>
                <div class="num"><?= $e($note->delivery_number) ?></div>
                <div class="date">Date de livraison : <strong><?= $fd($note->delivery_date) ?></strong></div>
            </div>
        </div>
        <div class="bar"></div>

        <!-- INFORMATIONS -->
        <div class="cards">
            <div class="card">
                <h3>Demande d'achat</h3>
                <table>
                    <tr>
                        <td class="l">N° demande</td>
                        <td class="v">DA-<?= (int) $note->request_id ?></td>
                    </tr>
                    <tr>
                        <td class="l">Date demande</td>
                        <td class="v"><?= $fd($note->request_date) ?></td>
                    </tr>
                    <tr>
                        <td class="l">Chantier</td>
                        <td class="v"><?= $e($note->destination_chantier) ?></td>
                    </tr>
                    <tr>
                        <td class="l">Demandeur</td>
                        <td class="v"><?= $e($note->requested_by) ?></td>
                    </tr>
                    <tr>
                        <td class="l">Statut</td>
                        <td class="v"><span class="status <?= $st[1] ?>"><?= $st[0] ?></span></td>
                    </tr>
                </table>
            </div>
            <div class="card">
                <h3>Paiement &amp; réception</h3>
                <table>
                    <tr>
                        <td class="l">Bon de paiement</td>
                        <td class="v"><?= $e($note->payment_number) ?></td>
                    </tr>
                    <tr>
                        <td class="l">Montant payé</td>
                        <td class="v"><?= $nf($note->amount_paid) ?> FBu</td>
                    </tr>
                    <tr>
                        <td class="l">Réf. BL fournisseur</td>
                        <td class="v">
                            <?= $note->supplier_bl_reference ? $e($note->supplier_bl_reference) : '<span class="blank"></span>' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="l">Lieu de réception</td>
                        <td class="v"><?= $nom_emplacement ? $e($nom_emplacement) : '<span class="blank"></span>' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="l">Réceptionné par</td>
                        <td class="v"><?= $note->received_by ? $e($note->received_by) : '<span class="blank"></span>' ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- LIGNES -->
        <table class="lines">
            <thead>
                <tr>
                    <th class="n">#</th>
                    <th>Désignation</th>
                    <th class="c">Qté commandée</th>
                    <th class="c">Qté reçue</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $it) : ?>
                <tr>
                    <td class="n"><?= $i + 1 ?></td>
                    <td><?= $e($it->designation) ?></td>
                    <td class="c"><?= $nf($it->quantity_ordered) ?></td>
                    <td class="c"><strong><?= $nf($it->quantity_received) ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td><?= count($items) ?> ligne(s)</td>
                    <td class="c"><?= $nf($totalOrdered) ?></td>
                    <td class="c"><?= $nf($totalReceived) ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="obs-label">Observation</div>
        <div class="obs"><?= nl2br($e($note->observation)) ?></div>

        <!-- SIGNATURES -->
        <div class="sign">
            <div>
                <div class="role">Le livreur</div>
                <div class="row"><span>Nom :</span><i></i></div>
                <div class="row"><span>Date :</span><i></i></div>
                <div class="sig">Signature</div>
            </div>
            <div>
                <div class="role">Le réceptionnaire</div>
                <div class="row"><span>Nom :</span><i><?= $e($note->received_by) ?></i></div>
                <div class="row"><span>Date :</span><i></i></div>
                <div class="sig">Signature &amp; cachet</div>
            </div>
        </div>

        <div class="foot">
            <span>SATRACO Construction — Construction Management System</span>
            <span>Généré le <?= date('d/m/Y à H:i') ?></span>
        </div>
    </div>

</body>

</html>