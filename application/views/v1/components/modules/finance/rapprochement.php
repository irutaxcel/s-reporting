<?php
/* =====================================================================
 * PAGE : RAPPROCHEMENT BANCAIRE — LISTE (6a)
 * ===================================================================== */

$flashSuccess = $this->session->flashdata('success');
$flashError   = $this->session->flashdata('error');
$reopenModal  = (bool) $this->session->flashdata('open_reconciliation_modal');
$old          = $this->session->flashdata('reconciliation_old_input');
$old          = is_array($old) ? $old : [];

if (!function_exists('recoAmount')) {
    function recoAmount($amount, string $currency = 'BIF'): string
    {
        return number_format((float) $amount, $currency === 'BIF' ? 0 : 2, ',', ' ');
    }
}

$jsonFlags = JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP;

/* Données des comptes pour la modale */
$accountOptions = [];

foreach ($accountRows as $row) {
    $accountOptions[(int) $row->account->id] = [
        'currency'          => $row->account->currency,
        'period_start'      => $row->period_start,
        'period_start_text' => date('d/m/Y', strtotime($row->period_start)),
        'expected_opening'  => $row->expected_opening,
        'open'              => $row->open ? [
            'reference' => $row->open->reference,
            'url'       => base_url('rapprochement/' . (int) $row->open->id),
        ] : null,
    ];
}
?>

<style>
    :root {
        --reco-primary: #0f766e;
        --reco-primary-dark: #115e59;
        --reco-secondary: #102033;
        --reco-muted: #64748b;
        --reco-border: #e2e8f0
    }

    .reco-page {
        padding-bottom: 30px
    }

    .reco-hero {
        margin-bottom: 18px;
        padding: 22px 24px;
        border-radius: 15px;
        color: #fff;
        background: linear-gradient(120deg, #0f766e 0%, #155e75 55%, #102033 100%);
        box-shadow: 0 12px 30px rgba(15, 118, 110, .16)
    }

    .reco-hero-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap
    }

    .reco-hero h2 {
        margin: 0 0 6px;
        font-size: 21px;
        font-weight: 800
    }

    .reco-hero p {
        max-width: 780px;
        margin: 0;
        color: rgba(255, 255, 255, .85);
        font-size: 12px;
        line-height: 1.6
    }

    .reco-card {
        margin-bottom: 18px;
        overflow: hidden;
        border: 1px solid var(--reco-border);
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 6px 22px rgba(15, 23, 42, .04)
    }

    .reco-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        padding: 15px 18px;
        border-bottom: 1px solid #edf2f7
    }

    .reco-card-title {
        margin: 0 0 2px;
        color: var(--reco-secondary);
        font-size: 15px;
        font-weight: 800
    }

    .reco-card-title i {
        margin-right: 7px;
        color: var(--reco-primary)
    }

    .reco-card-subtitle {
        color: var(--reco-muted);
        font-size: 11px
    }

    .reco-table {
        margin-bottom: 0
    }

    .reco-table thead th {
        padding: 11px 10px;
        color: #475569;
        border-top: 0;
        background: #f8fafc;
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        white-space: nowrap
    }

    .reco-table tbody td {
        padding: 10px;
        color: #334155;
        font-size: 12px;
        vertical-align: middle
    }

    .reco-table .num {
        text-align: right;
        white-space: nowrap;
        font-weight: 800
    }

    .btn-reco-primary {
        color: #fff;
        border: 1px solid var(--reco-primary);
        border-radius: 8px;
        background: var(--reco-primary);
        font-size: 12px;
        font-weight: 700
    }

    .btn-reco-primary:hover {
        color: #fff;
        background: var(--reco-primary-dark)
    }

    .btn-reco-outline {
        color: var(--reco-primary);
        border: 1px solid #9bd0ca;
        border-radius: 8px;
        background: #fff;
        font-size: 12px;
        font-weight: 700
    }

    .btn-reco-outline:hover {
        color: #fff;
        background: var(--reco-primary)
    }

    .reco-filters {
        display: flex;
        gap: 8px;
        flex-wrap: wrap
    }

    .reco-filters .form-control,
    .modal-reco .form-control {
        min-height: 38px;
        border-color: #dbe4ea;
        border-radius: 8px;
        font-size: 12px
    }

    .reco-late {
        color: #b45309;
        font-weight: 700
    }

    .reco-empty {
        padding: 40px 20px;
        text-align: center;
        color: var(--reco-muted)
    }

    .reco-empty i {
        display: block;
        margin-bottom: 10px;
        font-size: 32px;
        color: #cbd5e1
    }

    .modal-reco .modal-content {
        overflow: hidden;
        border: 0;
        border-radius: 14px
    }

    .modal-reco .modal-header {
        color: #fff;
        border-bottom: 0;
        background: linear-gradient(120deg, #0f766e, #155e75, #102033)
    }

    .modal-reco .modal-title {
        font-size: 15px;
        font-weight: 800
    }

    .modal-reco .close {
        color: #fff;
        opacity: 1
    }

    .modal-reco label {
        margin-bottom: 5px;
        color: #475569;
        font-size: 11px;
        font-weight: 800
    }

    .reco-info-box {
        padding: 9px 12px;
        border: 1px solid #99d5ce;
        border-radius: 9px;
        background: #f0fdfa;
        font-size: 12px
    }

    .reco-warning-box {
        padding: 9px 12px;
        border: 1px solid #fde68a;
        border-radius: 9px;
        background: #fffbeb;
        color: #92400e;
        font-size: 12px;
        font-weight: 600
    }

    .required-star {
        color: #dc2626
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
                        <li class="breadcrumb-item active"><?= html_escape($title) ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid reco-page">

            <div class="reco-hero">
                <div class="reco-hero-content">
                    <div>
                        <h2><i class="fas fa-balance-scale mr-2"></i>Rapprochement bancaire</h2>
                        <p>
                            Comparez chaque relevé de la banque au livre de banque : pointez les lignes communes,
                            régularisez les opérations manquantes et validez quand l’écart est nul.
                            La période validée est ensuite verrouillée.
                        </p>
                    </div>
                    <button type="button" class="btn btn-light font-weight-bold" data-toggle="modal"
                        data-target="#reconciliationModal">
                        <i class="fas fa-plus mr-1"></i> Nouveau rapprochement
                    </button>
                </div>
            </div>

            <!-- =========================================================
                 SITUATION PAR COMPTE
            ========================================================== -->
            <div class="reco-card">
                <div class="reco-card-header">
                    <div>
                        <h5 class="reco-card-title"><i class="fas fa-university"></i> Situation par compte</h5>
                        <span class="reco-card-subtitle">Dernier rapprochement validé et rapprochement en cours de
                            chaque compte.</span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table reco-table">
                        <thead>
                            <tr>
                                <th>Compte</th>
                                <th>Banque</th>
                                <th>Dernier rapprochement</th>
                                <th class="text-right">Solde rapproché</th>
                                <th>Prochaine période</th>
                                <th>En cours</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($accountRows)): ?>
                                <?php foreach ($accountRows as $row): ?>
                                    <?php
                                    $acc    = $row->account;
                                    $isLate = empty($acc->last_reconciled_date)
                                        ? ($acc->opening_date < date('Y-m-d', strtotime('-35 days')))
                                        : ($acc->last_reconciled_date < date('Y-m-d', strtotime('-35 days')));
                                    ?>
                                    <tr>
                                        <td>
                                            <strong><?= html_escape($acc->name) ?></strong>
                                            <small
                                                class="d-block text-muted"><?= html_escape($acc->code . ' · ' . $acc->account_number . ' · ' . $acc->currency) ?></small>
                                        </td>
                                        <td><?= html_escape($acc->bank_name) ?></td>
                                        <td class="<?= $isLate ? 'reco-late' : '' ?>">
                                            <?= !empty($acc->last_reconciled_date) ? date('d/m/Y', strtotime($acc->last_reconciled_date)) : 'Jamais' ?>
                                            <?php if ($isLate): ?><i class="fas fa-exclamation-triangle ml-1"
                                                    title="Plus de 35 jours"></i><?php endif; ?>
                                        </td>
                                        <td class="num">
                                            <?= $acc->last_reconciled_balance !== null ? recoAmount($acc->last_reconciled_balance, $acc->currency) . ' ' . html_escape($acc->currency) : '—' ?>
                                        </td>
                                        <td>À partir du <?= date('d/m/Y', strtotime($row->period_start)) ?></td>
                                        <td>
                                            <?php if ($row->open): ?>
                                                <span
                                                    class="badge <?= $statusLabels[$row->open->status][1] ?? 'badge-light' ?>"><?= html_escape($row->open->reference) ?></span>
                                                <small
                                                    class="d-block text-muted"><?= html_escape($statusLabels[$row->open->status][0] ?? $row->open->status) ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <?php if ($row->open): ?>
                                                <a href="<?= base_url('rapprochement/' . (int) $row->open->id) ?>"
                                                    class="btn btn-sm btn-reco-primary">
                                                    <i class="fas fa-arrow-right mr-1"></i>Continuer
                                                </a>
                                            <?php elseif (in_array($acc->status, ['active', 'blocked'], true)): ?>
                                                <button type="button" class="btn btn-sm btn-reco-outline" data-toggle="modal"
                                                    data-target="#reconciliationModal" data-account-id="<?= (int) $acc->id ?>">
                                                    <i class="fas fa-plus mr-1"></i>Nouveau
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted small">Compte <?= html_escape($acc->status) ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="reco-empty"><i class="fas fa-university"></i>Aucun compte bancaire.
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- =========================================================
                 HISTORIQUE
            ========================================================== -->
            <div class="reco-card">
                <div class="reco-card-header">
                    <div>
                        <h5 class="reco-card-title"><i class="fas fa-history"></i> Historique des rapprochements</h5>
                        <span class="reco-card-subtitle"><?= count($reconciliations) ?> rapprochement(s)</span>
                    </div>
                    <form method="get" action="<?= base_url('rapprochement') ?>" class="reco-filters">
                        <select name="bank_account_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Tous les comptes</option>
                            <?php foreach ($accountRows as $row): ?>
                                <option value="<?= (int) $row->account->id ?>"
                                    <?= (int) $filters['bank_account_id'] === (int) $row->account->id ? 'selected' : '' ?>>
                                    <?= html_escape($row->account->code . ' — ' . $row->account->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="">Tous les statuts</option>
                            <?php foreach ($statusLabels as $key => $label): ?>
                                <option value="<?= $key ?>" <?= $filters['status'] === $key ? 'selected' : '' ?>>
                                    <?= html_escape($label[0]) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table reco-table">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Compte</th>
                                <th>Période</th>
                                <th>Relevé</th>
                                <th class="text-right">Solde relevé</th>
                                <th class="text-right">Solde livre</th>
                                <th>Statut</th>
                                <th>Responsable</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reconciliations)): ?>
                                <?php foreach ($reconciliations as $reco): ?>
                                    <?php $isOpen = in_array($reco->status, ['draft', 'in_progress', 'completed'], true); ?>
                                    <tr>
                                        <td><a
                                                href="<?= base_url('rapprochement/' . (int) $reco->id) ?>"><strong><?= html_escape($reco->reference) ?></strong></a>
                                        </td>
                                        <td>
                                            <?= html_escape($reco->account_name) ?>
                                            <small class="d-block text-muted"><?= html_escape($reco->bank_name) ?></small>
                                        </td>
                                        <td class="text-nowrap">
                                            <?= date('d/m/Y', strtotime($reco->period_start)) ?> →
                                            <?= date('d/m/Y', strtotime($reco->period_end)) ?>
                                        </td>
                                        <td>
                                            <?= html_escape($reco->statement_reference) ?>
                                            <?php if (!empty($reco->statement_number)): ?>
                                                <small class="d-block text-muted">N°
                                                    <?= html_escape($reco->statement_number) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="num"><?= recoAmount($reco->statement_closing_balance, $reco->currency) ?>
                                        </td>
                                        <td class="num"><?= recoAmount($reco->book_closing_balance, $reco->currency) ?></td>
                                        <td><span
                                                class="badge <?= $statusLabels[$reco->status][1] ?? 'badge-light' ?>"><?= html_escape($statusLabels[$reco->status][0] ?? $reco->status) ?></span>
                                        </td>
                                        <td><?= html_escape($reco->responsible_name ?: '—') ?></td>
                                        <td class="text-center text-nowrap">
                                            <a href="<?= base_url('rapprochement/' . (int) $reco->id) ?>"
                                                class="btn btn-sm btn-reco-outline" title="Ouvrir">
                                                <i class="fas fa-folder-open"></i>
                                            </a>
                                            <?php if ($isOpen): ?>
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Annuler"
                                                    onclick="cancelReconciliation(<?= (int) $reco->id ?>, <?= html_escape(json_encode($reco->reference)) ?>)">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9">
                                        <div class="reco-empty"><i class="fas fa-balance-scale"></i>Aucun rapprochement pour
                                            ces critères.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- =========================================================
     MODALE : NOUVEAU RAPPROCHEMENT
========================================================== -->
<div class="modal fade modal-reco" id="reconciliationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="<?= base_url('reconciliation-store') ?>" method="post" class="w-100" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-balance-scale mr-2"></i>Nouveau rapprochement</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="recoAccount">Compte bancaire <span class="required-star">*</span></label>
                            <select name="bank_account_id" id="recoAccount" class="form-control" required>
                                <option value="">Sélectionner le compte</option>
                                <?php foreach ($accountRows as $row): ?>
                                    <?php if (!in_array($row->account->status, ['active', 'blocked'], true)) continue; ?>
                                    <option value="<?= (int) $row->account->id ?>"
                                        <?= (string) ($old['bank_account_id'] ?? '') === (string) $row->account->id ? 'selected' : '' ?>>
                                        <?= html_escape($row->account->code . ' — ' . $row->account->name . ' (' . $row->account->bank_name . ', ' . $row->account->currency . ')') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3" id="recoOpenWarning" style="display:none">
                            <div class="reco-warning-box">
                                Un rapprochement est déjà en cours pour ce compte :
                                <a href="#" id="recoOpenLink" class="font-weight-bold"></a>.
                                Terminez-le ou annulez-le avant d’en commencer un autre.
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Début de la période</label>
                            <input type="text" id="recoPeriodStart" class="form-control" value="—" readonly>
                            <small class="text-muted">Calculé : lendemain du dernier rapprochement validé.</small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="recoPeriodEnd">Fin de la période <span class="required-star">*</span></label>
                            <input type="date" name="period_end" id="recoPeriodEnd" class="form-control"
                                max="<?= date('Y-m-d') ?>" required
                                value="<?= html_escape($old['period_end'] ?? date('Y-m-t', strtotime('last month'))) ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="recoStatementNumber">N° du relevé</label>
                            <input type="text" name="statement_number" id="recoStatementNumber" class="form-control"
                                maxlength="50" value="<?= html_escape($old['statement_number'] ?? '') ?>"
                                placeholder="Numéro indiqué par la banque">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="recoStatementDate">Date du relevé</label>
                            <input type="date" name="statement_date" id="recoStatementDate" class="form-control"
                                value="<?= html_escape($old['statement_date'] ?? '') ?>">
                            <small class="text-muted">Par défaut : la date de fin de période.</small>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="recoOpening">Solde initial du relevé <span
                                    class="required-star">*</span></label>
                            <div class="input-group">
                                <input type="number" name="statement_opening_balance" id="recoOpening"
                                    class="form-control" step="0.01" required
                                    value="<?= html_escape($old['statement_opening_balance'] ?? '') ?>">
                                <div class="input-group-append"><span class="input-group-text reco-currency">BIF</span>
                                </div>
                            </div>
                            <small class="text-muted" id="recoExpectedText"></small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="recoClosing">Solde final du relevé <span class="required-star">*</span></label>
                            <div class="input-group">
                                <input type="number" name="statement_closing_balance" id="recoClosing"
                                    class="form-control" step="0.01" required
                                    value="<?= html_escape($old['statement_closing_balance'] ?? '') ?>">
                                <div class="input-group-append"><span class="input-group-text reco-currency">BIF</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 form-group mb-0">
                            <label for="recoObservation">Observation</label>
                            <textarea name="observation" id="recoObservation" class="form-control"
                                rows="2"><?= html_escape($old['observation'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-reco-outline" data-dismiss="modal"><i
                            class="fas fa-times mr-1"></i>Annuler</button>
                    <button type="submit" class="btn btn-reco-primary" id="recoSubmit"><i
                            class="fas fa-check mr-1"></i>Créer et saisir le relevé</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /* =====================================================================
     * RAPPROCHEMENT — LISTE
     * La modale est ouverte par Bootstrap (data-toggle) ;
     * ce script remplit seulement les champs selon le compte choisi.
     * ===================================================================== */

    var RECO_ACCOUNTS = <?= json_encode($accountOptions, $jsonFlags) ?: '{}' ?>;
    var RECO_CANCEL_URL = <?= json_encode(base_url('reconciliation-cancel'), $jsonFlags) ?>;
    var RECO_CSRF = {
        name: <?= json_encode($this->security->get_csrf_token_name()) ?>,
        hash: <?= json_encode($this->security->get_csrf_hash()) ?>
    };
    var recoKeepOpening = <?= !empty($old['statement_opening_balance']) ? 'true' : 'false' ?>;

    function recoMoney(amount, currency) {
        var digits = currency === 'BIF' ? 0 : 2;

        return new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: digits,
                maximumFractionDigits: digits
            })
            .format(parseFloat(amount || 0)) + ' ' + currency;
    }

    /* Remplit la modale selon le compte sélectionné */
    function recoRefreshAccount() {
        var $ = window.jQuery;
        var data = RECO_ACCOUNTS[$('#recoAccount').val()];

        if (!data) {
            $('#recoPeriodStart').val('—');
            $('#recoExpectedText').text('');
            $('#recoOpenWarning').hide();
            $('#recoSubmit').prop('disabled', false);
            return;
        }

        $('#recoPeriodStart').val(data.period_start_text);
        $('#recoPeriodEnd').attr('min', data.period_start);

        /* Fin de période proposée : jamais avant le début, jamais après aujourd'hui */
        var today = $('#recoPeriodEnd').attr('max');

        if (!$('#recoPeriodEnd').val() || $('#recoPeriodEnd').val() < data.period_start) {
            $('#recoPeriodEnd').val(today < data.period_start ? data.period_start : today);
        }

        $('.reco-currency').text(data.currency);
        $('#recoExpectedText').text('Solde attendu (continuité) : ' + recoMoney(data.expected_opening, data.currency));

        if (!recoKeepOpening) {
            $('#recoOpening').val(data.expected_opening);
        }

        recoKeepOpening = false;

        if (data.open) {
            $('#recoOpenLink').text(data.open.reference).attr('href', data.open.url);
            $('#recoOpenWarning').show();
            $('#recoSubmit').prop('disabled', true);
        } else {
            $('#recoOpenWarning').hide();
            $('#recoSubmit').prop('disabled', false);
        }
    }

    /* Annulation d'un rapprochement (bouton de l'historique) */
    function cancelReconciliation(id, reference) {
        var $ = window.jQuery;

        Swal.fire({
            icon: 'warning',
            title: 'Annuler ' + reference + ' ?',
            text: 'Le relevé et les pointages de ce rapprochement seront annulés. Le livre de banque n’est pas modifié.',
            input: 'textarea',
            inputPlaceholder: 'Motif de l’annulation…',
            inputValidator: function(value) {
                return !value || !value.trim() ? 'Le motif est obligatoire.' : undefined;
            },
            showCancelButton: true,
            confirmButtonText: 'Annuler le rapprochement',
            cancelButtonText: 'Fermer',
            confirmButtonColor: '#dc2626'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            var data = {
                reconciliation_id: id,
                cancel_reason: result.value
            };
            if (RECO_CSRF.name) data[RECO_CSRF.name] = RECO_CSRF.hash;

            $.ajax({
                    url: RECO_CANCEL_URL,
                    method: 'POST',
                    data: data,
                    dataType: 'json'
                })
                .done(function(response) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Rapprochement annulé',
                            text: response.message,
                            confirmButtonColor: '#0f766e'
                        })
                        .then(function() {
                            window.location.reload();
                        });
                })
                .fail(function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Action impossible',
                        text: (xhr.responseJSON && xhr.responseJSON.message) || 'Erreur serveur.',
                        confirmButtonColor: '#dc2626'
                    });
                });
        });
    }

    /* Compatibilité : ouverture de la modale par appel direct (anciens onclick) */
    function openReconciliationModal(accountId) {
        var $ = window.jQuery;

        if (accountId) {
            $('#recoAccount').val(String(accountId));
        }

        recoRefreshAccount();
        $('#reconciliationModal').modal('show');
    }

    document.addEventListener('DOMContentLoaded', function() {
        var $ = window.jQuery;

        if (!$) {
            console.error('Rapprochement : jQuery n’est pas chargé.');
            return;
        }

        /* À l'ouverture de la modale : présélection du compte (bouton « Nouveau » d'une ligne) */
        $('#reconciliationModal').on('show.bs.modal', function(event) {
            var accountId = event.relatedTarget ? $(event.relatedTarget).data('account-id') : null;

            if (accountId) {
                $('#recoAccount').val(String(accountId));
            }

            recoRefreshAccount();
        });

        $('#recoAccount').on('change', recoRefreshAccount);

        /* Réouverture après une erreur, saisie conservée */
        <?php if ($reopenModal): ?>
            $('#reconciliationModal').modal('show');
        <?php endif; ?>

        <?php if ($flashSuccess || $flashError): ?>
            Swal.fire({
                icon: <?= json_encode($flashError ? 'error' : 'success') ?>,
                title: <?= json_encode($flashError ? 'Action impossible' : 'Succès', JSON_UNESCAPED_UNICODE) ?>,
                html: <?= json_encode($flashError ?: $flashSuccess, $jsonFlags) ?>,
                confirmButtonColor: <?= json_encode($flashError ? '#dc2626' : '#0f766e') ?>
            });
        <?php endif; ?>
    });
</script>