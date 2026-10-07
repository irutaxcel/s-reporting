<?php
/* =====================================================================
 * PAGE : LIVRE DE BANQUE — MODULE BANQUE V2
 * ===================================================================== */

if (!function_exists('ledgerAmount')) {
    function ledgerAmount($amount, string $currency = 'BIF'): string
    {
        return number_format((float) $amount, $currency === 'BIF' ? 0 : 2, ',', ' ');
    }
}

$currency    = $account->currency;
$query       = http_build_query($filters);
$periodLabel = date('d/m/Y', strtotime($filters['date_from'])) . ' au ' . date('d/m/Y', strtotime($filters['date_to']));
$isFirstPage = $pagination['page'] === 1;
$isLastPage  = $pagination['page'] === $pagination['pages'];

$natureBadges = [
    'solde_initial'       => 'neutral',
    'encaissement'        => 'credit',
    'decaissement'        => 'debit',
    'transfert_entrant'   => 'transfer',
    'transfert_sortant'   => 'transfer',
    'retrait_banque'      => 'cash',
    'versement_banque'    => 'cash',
    'frais_bancaires'     => 'debit',
    'interets_crediteurs' => 'credit',
    'contre_passation'    => 'reversal',
];

$pageUrl = function (int $page) use ($account, $filters) {
    return base_url('banque-livre/' . (int) $account->id) . '?' . http_build_query(array_merge($filters, ['page' => $page]));
};

$flashError = $this->session->flashdata('error');
?>

<style>
:root {
    --bank-primary: #0f766e;
    --bank-primary-dark: #115e59;
    --bank-secondary: #102033;
    --bank-muted: #64748b;
    --bank-border: #e2e8f0
}

.ledger-page {
    padding-bottom: 30px
}

.ledger-hero {
    position: relative;
    overflow: hidden;
    margin-bottom: 18px;
    padding: 22px 24px;
    border-radius: 15px;
    color: #fff;
    background: linear-gradient(120deg, #0f766e 0%, #155e75 55%, #102033 100%);
    box-shadow: 0 12px 30px rgba(15, 118, 110, .16)
}

.ledger-hero-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap
}

.ledger-hero h2 {
    margin: 0 0 4px;
    font-size: 21px;
    font-weight: 800
}

.ledger-hero p {
    margin: 0;
    color: rgba(255, 255, 255, .85);
    font-size: 12px
}

.ledger-account-select {
    min-width: 320px
}

.ledger-account-select label {
    display: block;
    margin-bottom: 4px;
    color: rgba(255, 255, 255, .8);
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase
}

.ledger-account-select select {
    min-height: 40px;
    border: 0;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 700
}

.ledger-stat {
    margin-bottom: 16px;
    padding: 16px 18px;
    border: 1px solid var(--bank-border);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 7px 24px rgba(15, 23, 42, .045)
}

.ledger-stat span {
    display: block;
    margin-bottom: 4px;
    color: var(--bank-muted);
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase
}

.ledger-stat strong {
    display: block;
    color: #0f172a;
    font-size: 20px;
    font-weight: 900
}

.ledger-stat small {
    color: var(--bank-muted);
    font-size: 10px
}

.ledger-stat.is-in strong {
    color: #15803d
}

.ledger-stat.is-out strong {
    color: #b91c1c
}

.ledger-stat.is-closing {
    border-color: #99d5ce;
    background: #f0fdfa
}

.ledger-card {
    margin-bottom: 18px;
    overflow: hidden;
    border: 1px solid var(--bank-border);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 6px 22px rgba(15, 23, 42, .04)
}

.ledger-filters {
    padding: 16px 18px;
    border-bottom: 1px solid #edf2f7
}

.ledger-filters label {
    margin-bottom: 5px;
    color: #475569;
    font-size: 11px;
    font-weight: 800
}

.ledger-filters .form-control {
    min-height: 38px;
    border-color: #dbe4ea;
    border-radius: 8px;
    font-size: 12px
}

.btn-bank-primary {
    color: #fff;
    border: 1px solid var(--bank-primary);
    border-radius: 8px;
    background: var(--bank-primary);
    font-size: 12px;
    font-weight: 700
}

.btn-bank-primary:hover {
    color: #fff;
    background: var(--bank-primary-dark)
}

.btn-bank-outline {
    color: var(--bank-primary);
    border: 1px solid #9bd0ca;
    border-radius: 8px;
    background: #fff;
    font-size: 12px;
    font-weight: 700
}

.btn-bank-outline:hover {
    color: #fff;
    background: var(--bank-primary)
}

.ledger-info {
    margin: 12px 18px 0;
    padding: 9px 12px;
    border: 1px solid #bae6fd;
    border-radius: 9px;
    background: #f0f9ff;
    color: #075985;
    font-size: 11px
}

.ledger-table {
    margin-bottom: 0
}

.ledger-table thead th {
    position: sticky;
    top: 0;
    z-index: 1;
    padding: 11px 10px;
    color: #475569;
    border-top: 0;
    background: #f8fafc;
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    white-space: nowrap
}

.ledger-table tbody td {
    padding: 9px 10px;
    color: #334155;
    font-size: 11px;
    vertical-align: middle
}

.ledger-table .is-amount {
    text-align: right;
    white-space: nowrap;
    font-weight: 800
}

.ledger-table .amount-in {
    color: #15803d
}

.ledger-table .amount-out {
    color: #b91c1c
}

.ledger-table .balance {
    text-align: right;
    white-space: nowrap;
    font-weight: 900;
    color: #0f172a
}

.ledger-table .balance.is-negative {
    color: #b91c1c
}

.ledger-row-summary td {
    background: #f8fafc;
    font-weight: 800
}

.ledger-row-reversal td {
    background: #fffbeb
}

.ledger-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 800;
    white-space: nowrap
}

.ledger-badge.credit {
    color: #15803d;
    background: #dcfce7
}

.ledger-badge.debit {
    color: #b91c1c;
    background: #fee2e2
}

.ledger-badge.transfer {
    color: #0369a1;
    background: #e0f2fe
}

.ledger-badge.cash {
    color: #6d28d9;
    background: #ede9fe
}

.ledger-badge.reversal {
    color: #92400e;
    background: #fef3c7
}

.ledger-badge.neutral {
    color: #475569;
    background: #e2e8f0
}

.ledger-check {
    color: #16a34a
}

.ledger-uncheck {
    color: #cbd5e1
}

.ledger-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    padding: 12px 18px;
    border-top: 1px solid #edf2f7
}

.ledger-empty {
    padding: 40px 20px;
    text-align: center;
    color: var(--bank-muted)
}

.ledger-empty i {
    display: block;
    margin-bottom: 10px;
    font-size: 32px;
    color: #cbd5e1
}
</style>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= html_escape($title) ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('compte-banques') ?>">Comptes bancaires</a>
                        </li>
                        <li class="breadcrumb-item active"><?= html_escape($title) ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid ledger-page">

            <!-- =========================================================
                 BANDEAU + SÉLECTEUR DE COMPTE
            ========================================================== -->
            <div class="ledger-hero">
                <div class="ledger-hero-content">
                    <div>
                        <h2><i class="fas fa-book mr-2"></i><?= html_escape($account->name) ?></h2>
                        <p>
                            <?= html_escape($account->code) ?> · <?= html_escape($account->bank_name) ?> ·
                            N° <?= html_escape($account->account_number) ?> · <?= html_escape($currency) ?>
                            — période du <?= $periodLabel ?>
                        </p>
                    </div>
                    <div class="ledger-account-select">
                        <label for="ledgerAccountSelect">Changer de compte</label>
                        <select id="ledgerAccountSelect" class="form-control"
                            onchange="if (this.value) { window.location.href = this.value; }">
                            <?php foreach ($accounts as $item): ?>
                            <?php $url = base_url('banque-livre/' . (int) $item->id) . '?' . http_build_query(['date_from' => $filters['date_from'], 'date_to' => $filters['date_to']]); ?>
                            <option value="<?= html_escape($url) ?>"
                                <?= (int) $item->id === (int) $account->id ? 'selected' : '' ?>>
                                <?= html_escape($item->code . ' — ' . $item->name . ' (' . $item->bank_name . ', ' . $item->currency . ')') ?>
                                <?= $item->status !== 'active' ? ' — ' . $item->status : '' ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- =========================================================
                 SOLDES DE LA PÉRIODE
            ========================================================== -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="ledger-stat">
                        <span>Solde d’ouverture</span>
                        <strong><?= ledgerAmount($ledger['opening_balance'], $currency) ?>
                            <?= html_escape($currency) ?></strong>
                        <small>Au <?= date('d/m/Y', strtotime($filters['date_from'])) ?></small>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="ledger-stat is-in">
                        <span>Total des entrées</span>
                        <strong>+ <?= ledgerAmount($ledger['total_in'], $currency) ?></strong>
                        <small><?= (int) $ledger['count_in'] ?> mouvement(s)</small>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="ledger-stat is-out">
                        <span>Total des sorties</span>
                        <strong>- <?= ledgerAmount($ledger['total_out'], $currency) ?></strong>
                        <small><?= (int) $ledger['count_out'] ?> mouvement(s)</small>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="ledger-stat is-closing">
                        <span>Solde de clôture</span>
                        <strong><?= ledgerAmount($ledger['closing_balance'], $currency) ?>
                            <?= html_escape($currency) ?></strong>
                        <small>Au <?= date('d/m/Y', strtotime($filters['date_to'])) ?> —
                            <?= (int) $ledger['unreconciled'] ?> ligne(s) non pointée(s)</small>
                    </div>
                </div>
            </div>

            <!-- =========================================================
                 FILTRES + TABLEAU
            ========================================================== -->
            <div class="ledger-card">

                <form class="ledger-filters" method="get"
                    action="<?= base_url('banque-livre/' . (int) $account->id) ?>">
                    <div class="row align-items-end">
                        <div class="col-xl-2 col-md-4 form-group mb-xl-0">
                            <label for="ledgerFrom">Du</label>
                            <input type="date" name="date_from" id="ledgerFrom" class="form-control"
                                value="<?= html_escape($filters['date_from']) ?>">
                        </div>
                        <div class="col-xl-2 col-md-4 form-group mb-xl-0">
                            <label for="ledgerTo">Au</label>
                            <input type="date" name="date_to" id="ledgerTo" class="form-control"
                                value="<?= html_escape($filters['date_to']) ?>">
                        </div>
                        <div class="col-xl-1 col-md-4 form-group mb-xl-0">
                            <label for="ledgerSens">Sens</label>
                            <select name="sens" id="ledgerSens" class="form-control">
                                <option value="">Tous</option>
                                <option value="entree" <?= $filters['sens'] === 'entree' ? 'selected' : '' ?>>Entrées
                                </option>
                                <option value="sortie" <?= $filters['sens'] === 'sortie' ? 'selected' : '' ?>>Sorties
                                </option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4 form-group mb-xl-0">
                            <label for="ledgerNature">Nature</label>
                            <select name="nature" id="ledgerNature" class="form-control">
                                <option value="">Toutes</option>
                                <?php foreach ($natureLabels as $key => $label): ?>
                                <option value="<?= $key ?>" <?= $filters['nature'] === $key ? 'selected' : '' ?>>
                                    <?= html_escape($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xl-1 col-md-4 form-group mb-xl-0">
                            <label for="ledgerReconciled">Pointage</label>
                            <select name="reconciled" id="ledgerReconciled" class="form-control">
                                <option value="">Tous</option>
                                <option value="yes" <?= $filters['reconciled'] === 'yes' ? 'selected' : '' ?>>Pointés
                                </option>
                                <option value="no" <?= $filters['reconciled'] === 'no' ? 'selected' : '' ?>>Non pointés
                                </option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4 form-group mb-xl-0">
                            <label for="ledgerSearch">Recherche</label>
                            <input type="text" name="search" id="ledgerSearch" class="form-control"
                                value="<?= html_escape($filters['search']) ?>"
                                placeholder="Réf., libellé, tiers, pièce…">
                        </div>
                        <div class="col-xl-2 col-md-12 form-group mb-0 d-flex flex-wrap">
                            <button type="submit" class="btn btn-bank-primary mr-1 mb-1"><i
                                    class="fas fa-filter mr-1"></i>Appliquer</button>
                            <a href="<?= base_url('banque-livre/' . (int) $account->id) ?>"
                                class="btn btn-bank-outline mb-1" title="Réinitialiser"><i class="fas fa-redo"></i></a>
                        </div>
                    </div>
                    <div class="mt-3 d-flex flex-wrap">
                        <a href="<?= base_url('banque-livre-print/' . (int) $account->id) . '?' . $query ?>"
                            target="_blank" class="btn btn-bank-outline btn-sm mr-2 mb-1">
                            <i class="fas fa-print mr-1"></i>Imprimer
                        </a>
                        <a href="<?= base_url('banque-livre-export/' . (int) $account->id) . '?' . $query ?>"
                            class="btn btn-bank-outline btn-sm mr-2 mb-1">
                            <i class="fas fa-file-csv mr-1"></i>Exporter (CSV / Excel)
                        </a>
                        <a href="<?= base_url('compte-banques') ?>" class="btn btn-bank-outline btn-sm mb-1">
                            <i class="fas fa-arrow-left mr-1"></i>Comptes bancaires
                        </a>
                    </div>
                </form>

                <?php if ($ledger['is_filtered']): ?>
                <div class="ledger-info">
                    <i class="fas fa-info-circle mr-1"></i>
                    Filtres actifs : <?= (int) $pagination['total'] ?> ligne(s) sur <?= (int) $ledger['count_all'] ?>.
                    Le solde affiché sur chaque ligne reste celui du livre complet.
                </div>
                <?php endif; ?>

                <div class="table-responsive mt-2">
                    <table class="table ledger-table">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Date</th>
                                <th>Valeur</th>
                                <th>Référence</th>
                                <th>Libellé</th>
                                <th>Nature</th>
                                <th class="text-right">Entrée</th>
                                <th class="text-right">Sortie</th>
                                <th class="text-right">Solde</th>
                                <th class="text-center">Pointé</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($isFirstPage): ?>
                            <tr class="ledger-row-summary">
                                <td></td>
                                <td><?= date('d/m/Y', strtotime($filters['date_from'])) ?></td>
                                <td></td>
                                <td></td>
                                <td colspan="4">Solde d’ouverture</td>
                                <td class="balance <?= $ledger['opening_balance'] < 0 ? 'is-negative' : '' ?>">
                                    <?= ledgerAmount($ledger['opening_balance'], $currency) ?></td>
                                <td></td>
                            </tr>
                            <?php endif; ?>

                            <?php if (!empty($ledger['rows'])): ?>
                            <?php foreach ($ledger['rows'] as $row): ?>
                            <tr class="<?= $row->nature === 'contre_passation' ? 'ledger-row-reversal' : '' ?>">
                                <td class="text-muted"><?= (int) $row->line_number ?></td>
                                <td><?= date('d/m/Y', strtotime($row->movement_date)) ?></td>
                                <td class="text-muted">
                                    <?= $row->value_date ? date('d/m/Y', strtotime($row->value_date)) : '—' ?></td>
                                <td>
                                    <strong><?= html_escape($row->reference) ?></strong>
                                    <?php if (!empty($row->operation_reference)): ?>
                                    <small
                                        class="d-block text-muted"><?= html_escape($row->operation_reference) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= html_escape($row->label) ?></strong>
                                    <?php if (!empty($row->third_party)): ?>
                                    <small class="d-block text-muted">Tiers :
                                        <?= html_escape($row->third_party) ?></small>
                                    <?php endif; ?>
                                    <?php if (!empty($row->document_number)): ?>
                                    <small class="d-block text-muted">Pièce :
                                        <?= html_escape($row->document_number) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="ledger-badge <?= $natureBadges[$row->nature] ?? 'neutral' ?>">
                                        <?= html_escape($natureLabels[$row->nature] ?? $row->nature) ?>
                                    </span>
                                </td>
                                <td class="is-amount amount-in">
                                    <?= $row->entry_amount > 0 ? ledgerAmount($row->entry_amount, $currency) : '' ?>
                                </td>
                                <td class="is-amount amount-out">
                                    <?= $row->exit_amount > 0 ? ledgerAmount($row->exit_amount, $currency) : '' ?></td>
                                <td class="balance <?= $row->running_balance < 0 ? 'is-negative' : '' ?>">
                                    <?= ledgerAmount($row->running_balance, $currency) ?></td>
                                <td class="text-center">
                                    <?php if ((int) $row->is_reconciled === 1): ?>
                                    <i class="fas fa-check-circle ledger-check" title="Pointé avec le relevé"></i>
                                    <?php else: ?>
                                    <i class="far fa-circle ledger-uncheck" title="Non pointé"></i>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="10">
                                    <div class="ledger-empty"><i class="fas fa-book-open"></i>Aucun mouvement sur cette
                                        période.</div>
                                </td>
                            </tr>
                            <?php endif; ?>

                            <?php if ($isLastPage): ?>
                            <tr class="ledger-row-summary">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="2">
                                    <?= $ledger['is_filtered'] ? 'Totaux des lignes affichées' : 'Totaux de la période' ?>
                                </td>
                                <td class="is-amount amount-in"><?= ledgerAmount($ledger['filtered_in'], $currency) ?>
                                </td>
                                <td class="is-amount amount-out"><?= ledgerAmount($ledger['filtered_out'], $currency) ?>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class="ledger-row-summary">
                                <td></td>
                                <td><?= date('d/m/Y', strtotime($filters['date_to'])) ?></td>
                                <td></td>
                                <td></td>
                                <td colspan="4">Solde de clôture</td>
                                <td class="balance <?= $ledger['closing_balance'] < 0 ? 'is-negative' : '' ?>">
                                    <?= ledgerAmount($ledger['closing_balance'], $currency) ?></td>
                                <td></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="ledger-footer">
                    <small class="text-muted">
                        Lignes <?= (int) $pagination['from'] ?> à <?= (int) $pagination['to'] ?> sur
                        <?= (int) $pagination['total'] ?>
                    </small>
                    <?php if ($pagination['pages'] > 1): ?>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item <?= $isFirstPage ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="<?= $isFirstPage ? '#' : html_escape($pageUrl($pagination['page'] - 1)) ?>">&laquo;</a>
                        </li>
                        <?php for ($p = max(1, $pagination['page'] - 2); $p <= min($pagination['pages'], $pagination['page'] + 2); $p++): ?>
                        <li class="page-item <?= $p === $pagination['page'] ? 'active' : '' ?>">
                            <a class="page-link" href="<?= html_escape($pageUrl($p)) ?>"><?= $p ?></a>
                        </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $isLastPage ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="<?= $isLastPage ? '#' : html_escape($pageUrl($pagination['page'] + 1)) ?>">&raquo;</a>
                        </li>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>
</div>

<?php if ($flashError): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: 'Action impossible',
        html: <?= json_encode($flashError, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>,
        confirmButtonColor: '#dc2626'
    });
});
</script>
<?php endif; ?>