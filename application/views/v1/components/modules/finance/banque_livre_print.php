<?php
if (!function_exists('ledgerAmount')) {
    function ledgerAmount($amount, string $currency = 'BIF'): string
    {
        return number_format((float) $amount, $currency === 'BIF' ? 0 : 2, ',', ' ');
    }
}

$currency = $account->currency;
$from     = date('d/m/Y', strtotime($filters['date_from']));
$to       = date('d/m/Y', strtotime($filters['date_to']));
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Livre de banque — <?= html_escape($account->code) ?> — <?= $from ?> au <?= $to ?></title>
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 24px;
        color: #0f172a;
        font-family: "Segoe UI", Arial, sans-serif;
        font-size: 11px;
    }

    .head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 3px solid #0f766e;
    }

    .head-brand {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .head-logo {
        width: 70px;
        height: 70px;
        object-fit: contain;
    }

    .head h1 {
        margin: 0 0 4px;
        color: #0f766e;
        font-size: 18px;
    }

    .head p {
        margin: 0;
        color: #475569;
    }

    .head-meta {
        text-align: right;
    }

    .title {
        margin: 16px 0 4px;
        font-size: 16px;
        font-weight: 800;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .period {
        margin-bottom: 14px;
        color: #475569;
        text-align: center;
    }

    .infos {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 14px;
    }

    .infos div {
        padding: 8px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
    }

    .infos span {
        display: block;
        color: #64748b;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .infos strong {
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        padding: 7px 6px;
        color: #fff;
        background: #0f766e;
        font-size: 9px;
        text-align: left;
        text-transform: uppercase;
    }

    td {
        padding: 6px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: top;
    }

    .num {
        text-align: right;
        white-space: nowrap;
    }

    .in {
        color: #15803d;
    }

    .out {
        color: #b91c1c;
    }

    .summary td {
        background: #f1f5f9;
        font-weight: 800;
    }

    .reversal td {
        background: #fffbeb;
    }

    .muted {
        color: #64748b;
        font-size: 9px;
    }

    .signatures {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 40px;
    }

    .signatures div {
        padding-top: 50px;
        border-top: 1px solid #0f172a;
        text-align: center;
        font-weight: 700;
    }

    .foot {
        margin-top: 20px;
        color: #94a3b8;
        font-size: 9px;
        text-align: right;
    }

    .actions {
        margin-bottom: 16px;
        text-align: right;
    }

    .actions button {
        padding: 8px 14px;
        color: #fff;
        border: 0;
        border-radius: 6px;
        background: #0f766e;
        font-weight: 700;
        cursor: pointer;
    }

    @media print {
        body {
            padding: 0;
        }

        .actions {
            display: none;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        @page {
            size: A4 landscape;
            margin: 12mm;
        }
    }
    </style>
</head>

<body>

    <div class="actions"><button onclick="window.print()">Imprimer</button></div>

    <div class="head">
        <div class="head-brand">
            <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO" class="head-logo">
            <!-- <div>
                <h1>SATRACO Construction</h1>
                <p>Direction Administrative et Financière — Trésorerie</p>
            </div> -->
        </div>
        <div class="head-meta">
            <p>Édité le <?= date('d/m/Y à H:i') ?></p>
            <?php if (!empty($printedBy)): ?><p>Par : <?= html_escape($printedBy) ?></p><?php endif; ?>
        </div>
    </div>

    <div class="title">Livre de banque</div>
    <div class="period">Période du <?= $from ?> au <?= $to ?></div>

    <div class="infos">
        <div><span>Compte</span><strong><?= html_escape($account->code . ' — ' . $account->name) ?></strong></div>
        <div><span>Banque</span><strong><?= html_escape($account->bank_name) ?></strong></div>
        <div><span>N° de compte</span><strong><?= html_escape($account->account_number) ?></strong></div>
        <div><span>Devise</span><strong><?= html_escape($currency) ?></strong></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Date</th>
                <th>Valeur</th>
                <th>Référence</th>
                <th>Libellé</th>
                <th>Nature</th>
                <th class="num">Entrée</th>
                <th class="num">Sortie</th>
                <th class="num">Solde</th>
                <th>Pointé</th>
            </tr>
        </thead>
        <tbody>
            <tr class="summary">
                <td></td>
                <td><?= $from ?></td>
                <td></td>
                <td></td>
                <td colspan="4">Solde d’ouverture</td>
                <td class="num"><?= ledgerAmount($ledger['opening_balance'], $currency) ?></td>
                <td></td>
            </tr>

            <?php foreach ($ledger['rows'] as $row): ?>
            <tr class="<?= $row->nature === 'contre_passation' ? 'reversal' : '' ?>">
                <td><?= (int) $row->line_number ?></td>
                <td><?= date('d/m/Y', strtotime($row->movement_date)) ?></td>
                <td><?= $row->value_date ? date('d/m/Y', strtotime($row->value_date)) : '' ?></td>
                <td>
                    <?= html_escape($row->reference) ?>
                    <?php if (!empty($row->operation_reference)): ?><div class="muted">
                        <?= html_escape($row->operation_reference) ?></div><?php endif; ?>
                </td>
                <td>
                    <?= html_escape($row->label) ?>
                    <?php if (!empty($row->third_party)): ?><div class="muted">Tiers :
                        <?= html_escape($row->third_party) ?></div><?php endif; ?>
                    <?php if (!empty($row->document_number)): ?><div class="muted">Pièce :
                        <?= html_escape($row->document_number) ?></div><?php endif; ?>
                </td>
                <td><?= html_escape($natureLabels[$row->nature] ?? $row->nature) ?></td>
                <td class="num in"><?= $row->entry_amount > 0 ? ledgerAmount($row->entry_amount, $currency) : '' ?></td>
                <td class="num out"><?= $row->exit_amount > 0 ? ledgerAmount($row->exit_amount, $currency) : '' ?></td>
                <td class="num"><strong><?= ledgerAmount($row->running_balance, $currency) ?></strong></td>
                <td><?= (int) $row->is_reconciled === 1 ? 'Oui' : 'Non' ?></td>
            </tr>
            <?php endforeach; ?>

            <?php if (empty($ledger['rows'])): ?>
            <tr>
                <td colspan="10" style="text-align:center;padding:20px">Aucun mouvement sur cette période.</td>
            </tr>
            <?php endif; ?>

            <tr class="summary">
                <td colspan="6">
                    <?= $ledger['is_filtered'] ? 'Totaux des lignes affichées (filtres actifs)' : 'Totaux de la période' ?>
                </td>
                <td class="num in"><?= ledgerAmount($ledger['filtered_in'], $currency) ?></td>
                <td class="num out"><?= ledgerAmount($ledger['filtered_out'], $currency) ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr class="summary">
                <td></td>
                <td><?= $to ?></td>
                <td></td>
                <td></td>
                <td colspan="4">Solde de clôture</td>
                <td class="num"><?= ledgerAmount($ledger['closing_balance'], $currency) ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="signatures">
        <div>Établi par</div>
        <div>Vérifié par</div>
        <div>Approuvé par (DAF)</div>
    </div>

    <div class="foot">SATRACO Construction ERP — Livre de banque <?= html_escape($account->code) ?></div>

    <script>
    window.addEventListener('load', function() {
        window.print();
    });
    </script>
</body>

</html>