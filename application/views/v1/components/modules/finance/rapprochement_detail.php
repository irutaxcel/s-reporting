<?php
/* =====================================================================
 * PAGE : ESPACE DE TRAVAIL D'UN RAPPROCHEMENT (6a : onglet Relevé)
 * ===================================================================== */

$flashSuccess = $this->session->flashdata('success');
$flashError   = $this->session->flashdata('error');

if (!function_exists('recoAmount')) {
    function recoAmount($amount, string $currency = 'BIF'): string
    {
        return number_format((float) $amount, $currency === 'BIF' ? 0 : 2, ',', ' ');
    }
}

$reco      = $reconciliation;
$currency  = $reco->currency;
$status    = $statusLabels[$reco->status] ?? [$reco->status, 'badge-light'];
$jsonFlags = JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP;

$lineStatus = [
    'unmatched'         => ['Non pointée', 'badge-light'],
    'matched'           => ['Pointée', 'badge-success'],
    'partially_matched' => ['Partielle', 'badge-warning'],
    'ignored'           => ['Ignorée', 'badge-secondary'],
];
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
    padding: 20px 24px;
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
    margin: 0 0 4px;
    font-size: 20px;
    font-weight: 800
}

.reco-hero p {
    margin: 0;
    color: rgba(255, 255, 255, .85);
    font-size: 12px
}

.reco-stat {
    margin-bottom: 16px;
    padding: 15px 17px;
    border: 1px solid var(--reco-border);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 7px 24px rgba(15, 23, 42, .045)
}

.reco-stat span {
    display: block;
    margin-bottom: 4px;
    color: var(--reco-muted);
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase
}

.reco-stat strong {
    display: block;
    color: #0f172a;
    font-size: 18px;
    font-weight: 900
}

.reco-stat small {
    color: var(--reco-muted);
    font-size: 10px
}

.reco-stat.is-ok {
    border-color: #86efac;
    background: #f0fdf4
}

.reco-stat.is-ko {
    border-color: #fecaca;
    background: #fef2f2
}

.reco-card {
    margin-bottom: 18px;
    overflow: hidden;
    border: 1px solid var(--reco-border);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 6px 22px rgba(15, 23, 42, .04)
}

.reco-tabs {
    padding: 0 12px;
    border-bottom: 1px solid #edf2f7;
    background: #f8fafc
}

.reco-tabs .nav-link {
    padding: 13px 16px;
    color: #475569;
    border: 0;
    border-bottom: 3px solid transparent;
    font-size: 12px;
    font-weight: 800
}

.reco-tabs .nav-link.active {
    color: var(--reco-primary);
    border-bottom-color: var(--reco-primary);
    background: transparent
}

.reco-tabs .nav-link.disabled {
    color: #cbd5e1
}

.reco-section {
    padding: 16px 18px;
    border-bottom: 1px solid #edf2f7
}

.reco-section h6 {
    margin-bottom: 12px;
    color: var(--reco-secondary);
    font-size: 13px;
    font-weight: 800
}

.reco-section label {
    margin-bottom: 5px;
    color: #475569;
    font-size: 11px;
    font-weight: 800
}

.reco-section .form-control {
    min-height: 38px;
    border-color: #dbe4ea;
    border-radius: 8px;
    font-size: 12px
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
    padding: 9px 10px;
    color: #334155;
    font-size: 12px;
    vertical-align: middle
}

.reco-table .num {
    text-align: right;
    white-space: nowrap;
    font-weight: 800
}

.reco-table .debit {
    color: #b91c1c
}

.reco-table .credit {
    color: #15803d
}

.reco-table tfoot td {
    padding: 10px;
    background: #f8fafc;
    font-weight: 900;
    font-size: 12px
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

.reco-warning-box {
    margin-bottom: 14px;
    padding: 10px 14px;
    border: 1px solid #fde68a;
    border-radius: 10px;
    background: #fffbeb;
    color: #92400e;
    font-size: 12px;
    font-weight: 600
}

.reco-info-box {
    margin-bottom: 14px;
    padding: 10px 14px;
    border: 1px solid #bae6fd;
    border-radius: 10px;
    background: #f0f9ff;
    color: #075985;
    font-size: 12px
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

.reco-soon {
    padding: 50px 20px;
    text-align: center;
    color: var(--reco-muted)
}

.reco-soon i {
    display: block;
    margin-bottom: 12px;
    font-size: 36px;
    color: #99d5ce
}

/* Champ fichier (limité à cette page) */
.reco-file-field .custom-file-label {
    overflow: hidden;
    padding-right: 105px;
    white-space: nowrap;
    text-overflow: ellipsis;
    font-weight: 500
}

.reco-file-field .custom-file-label::after {
    content: attr(data-browse) !important;
    color: #0f766e;
    font-weight: 700;
    background: #f0fdfa
}

.reco-file-field.has-file .custom-file-label {
    color: #0f766e;
    font-weight: 700;
    border-color: #99d5ce
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
                        <li class="breadcrumb-item"><a href="<?= base_url('rapprochement') ?>">Rapprochement
                                bancaire</a></li>
                        <li class="breadcrumb-item active"><?= html_escape($reco->reference) ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid reco-page">

            <!-- =========================================================
                 EN-TÊTE
            ========================================================== -->
            <div class="reco-hero">
                <div class="reco-hero-content">
                    <div>
                        <h2>
                            <i class="fas fa-balance-scale mr-2"></i><?= html_escape($reco->reference) ?>
                            <span class="badge <?= $status[1] ?> ml-2"
                                style="font-size:11px"><?= html_escape($status[0]) ?></span>
                        </h2>
                        <p>
                            <?= html_escape($reco->account_code . ' — ' . $reco->account_name) ?> ·
                            <?= html_escape($reco->bank_name) ?> ·
                            N° <?= html_escape($reco->account_number) ?> ·
                            période du <?= date('d/m/Y', strtotime($reco->period_start)) ?> au
                            <?= date('d/m/Y', strtotime($reco->period_end)) ?> ·
                            relevé
                            <?= html_escape($reco->statement_reference) ?><?= !empty($reco->statement_number) ? ' (N° ' . html_escape($reco->statement_number) . ')' : '' ?>
                        </p>
                    </div>
                    <div>
                        <a href="<?= base_url('rapprochement') ?>" class="btn btn-light btn-sm font-weight-bold mr-1"><i
                                class="fas fa-arrow-left mr-1"></i>Liste</a>
                        <a href="<?= base_url('banque-livre/' . (int) $reco->bank_account_id) . '?' . http_build_query(['date_from' => $reco->period_start, 'date_to' => $reco->period_end]) ?>"
                            class="btn btn-light btn-sm font-weight-bold mr-1"><i class="fas fa-book mr-1"></i>Livre de
                            banque</a>
                        <?php if ($canEdit): ?>
                        <button type="button" class="btn btn-danger btn-sm font-weight-bold"
                            onclick="cancelReconciliation()">
                            <i class="fas fa-ban mr-1"></i>Annuler
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ($canEdit && abs($summary['continuity_gap']) >= 0.005): ?>
            <div class="reco-warning-box">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Le solde initial du relevé (<?= recoAmount($summary['opening'], $currency) ?>) ne correspond pas au
                solde attendu
                (<?= recoAmount($summary['expected_opening'], $currency) ?>), soit un écart de
                <?= recoAmount($summary['continuity_gap'], $currency) ?> <?= html_escape($currency) ?>.
                Vérifiez la saisie du relevé ou le rapprochement précédent.
            </div>
            <?php endif; ?>

            <?php if ($reco->status === 'cancelled' && !empty($reco->validation_observation)): ?>
            <div class="reco-warning-box"><i
                    class="fas fa-ban mr-1"></i><?= html_escape($reco->validation_observation) ?></div>
            <?php endif; ?>

            <!-- =========================================================
                 SYNTHÈSE DU RELEVÉ
            ========================================================== -->
            <div class="row">
                <div class="col-xl col-md-4">
                    <div class="reco-stat">
                        <span>Solde initial (relevé)</span>
                        <strong><?= recoAmount($summary['opening'], $currency) ?></strong>
                        <small>Au <?= date('d/m/Y', strtotime($reco->period_start . ' -1 day')) ?></small>
                    </div>
                </div>
                <div class="col-xl col-md-4">
                    <div class="reco-stat">
                        <span>Crédits du relevé</span>
                        <strong class="text-success">+ <?= recoAmount($summary['total_credit'], $currency) ?></strong>
                        <small><?= (int) $summary['line_count'] ?> ligne(s) au total</small>
                    </div>
                </div>
                <div class="col-xl col-md-4">
                    <div class="reco-stat">
                        <span>Débits du relevé</span>
                        <strong class="text-danger">- <?= recoAmount($summary['total_debit'], $currency) ?></strong>
                        <small><?= (int) $summary['unmatched_count'] ?> ligne(s) non pointée(s)</small>
                    </div>
                </div>
                <div class="col-xl col-md-6">
                    <div class="reco-stat <?= $summary['is_balanced'] ? 'is-ok' : 'is-ko' ?>">
                        <span>Solde final (relevé)</span>
                        <strong><?= recoAmount($summary['closing'], $currency) ?></strong>
                        <small>
                            <?php if ($summary['is_balanced']): ?>
                            <i class="fas fa-check-circle text-success"></i> Relevé équilibré
                            <?php else: ?>
                            <i class="fas fa-times-circle text-danger"></i>
                            Calculé : <?= recoAmount($summary['computed_closing'], $currency) ?> — écart
                            <?= recoAmount($summary['statement_gap'], $currency) ?>
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
                <div class="col-xl col-md-6">
                    <div class="reco-stat">
                        <span>Solde du livre</span>
                        <strong><?= recoAmount($summary['book_closing'], $currency) ?></strong>
                        <small>Au <?= date('d/m/Y', strtotime($reco->period_end)) ?></small>
                    </div>
                </div>
            </div>

            <!-- =========================================================
                 ONGLETS
            ========================================================== -->
            <div class="reco-card">
                <ul class="nav reco-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabStatement" role="tab">
                            <i class="fas fa-file-invoice mr-1"></i>1. Relevé (<?= (int) $summary['line_count'] ?>)
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabMatching" role="tab"><i
                                class="fas fa-link mr-1"></i>2. Pointage</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabRegularization" role="tab"><i
                                class="fas fa-tools mr-1"></i>3. Régularisation</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabState" role="tab"><i
                                class="fas fa-clipboard-check mr-1"></i>4. État &amp; validation</a></li>
                </ul>

                <div class="tab-content">

                    <!-- ============ ONGLET 1 : RELEVÉ ============ -->
                    <div class="tab-pane fade show active" id="tabStatement" role="tabpanel">

                        <?php if ($canEdit): ?>
                        <!-- Saisie manuelle -->
                        <div class="reco-section">
                            <h6><i class="fas fa-keyboard mr-1"></i>Ajouter une ligne du relevé</h6>
                            <form action="<?= base_url('statement-line-store') ?>" method="post" autocomplete="off">
                                <input type="hidden" name="reconciliation_id" value="<?= (int) $reco->id ?>">
                                <div class="row align-items-end">
                                    <div class="col-xl-2 col-md-4 form-group mb-xl-0">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <input type="date" name="operation_date" class="form-control" required
                                            min="<?= $reco->period_start ?>" max="<?= $reco->period_end ?>"
                                            value="<?= $reco->period_end ?>">
                                    </div>
                                    <div class="col-xl-2 col-md-4 form-group mb-xl-0">
                                        <label>Date de valeur</label>
                                        <input type="date" name="value_date" class="form-control">
                                    </div>
                                    <div class="col-xl-3 col-md-4 form-group mb-xl-0">
                                        <label>Libellé <span class="text-danger">*</span></label>
                                        <input type="text" name="label" class="form-control" maxlength="255" required
                                            placeholder="Tel qu’il figure sur le relevé">
                                    </div>
                                    <div class="col-xl-1 col-md-4 form-group mb-xl-0">
                                        <label>Réf.</label>
                                        <input type="text" name="bank_reference" class="form-control" maxlength="100">
                                    </div>
                                    <div class="col-xl-1 col-md-4 form-group mb-xl-0">
                                        <label>Sens <span class="text-danger">*</span></label>
                                        <select name="direction" class="form-control" required>
                                            <option value="credit">Crédit</option>
                                            <option value="debit">Débit</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-2 col-md-4 form-group mb-xl-0">
                                        <label>Montant <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" class="form-control" min="0.01" step="0.01"
                                            required>
                                    </div>
                                    <div class="col-xl-1 col-md-12 form-group mb-0">
                                        <button type="submit" class="btn btn-reco-primary btn-block"><i
                                                class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Crédit = argent entré sur le compte (versement, virement reçu). Débit = argent sorti
                                    (chèque payé, virement émis, frais).
                                </small>
                            </form>
                        </div>

                        <!-- Import CSV -->
                        <div class="reco-section">
                            <h6><i class="fas fa-file-import mr-1"></i>Importer le relevé (CSV)</h6>
                            <form action="<?= base_url('statement-import') ?>" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="reconciliation_id" value="<?= (int) $reco->id ?>">
                                <div class="row align-items-start">
                                    <div class="col-xl-5 col-md-7 form-group mb-xl-0 reco-file-field">
                                        <div class="custom-file">
                                            <input type="file" name="statement_file" class="custom-file-input"
                                                id="statementFile" accept=".csv,.txt" required>
                                            <label class="custom-file-label" for="statementFile"
                                                data-browse="Parcourir">Choisir le fichier CSV</label>
                                        </div>
                                        <small class="text-muted">Colonnes : date ; date_valeur ; libelle ; reference ;
                                            debit ; credit — 2 Mo maximum.</small>
                                    </div>
                                    <div class="col-xl-7 col-md-5 form-group mb-0">
                                        <button type="submit" class="btn btn-reco-primary mr-1 mb-1"><i
                                                class="fas fa-upload mr-1"></i>Importer</button>
                                        <a href="<?= base_url('statement-template') ?>"
                                            class="btn btn-reco-outline mb-1"><i class="fas fa-download mr-1"></i>Modèle
                                            CSV</a>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    Depuis Excel : Fichier → Enregistrer sous → « CSV (séparateur : point-virgule) ».
                                    Les lignes hors période sont ignorées et signalées.
                                </small>
                            </form>
                        </div>
                        <?php endif; ?>

                        <!-- Lignes du relevé -->
                        <div class="table-responsive">
                            <table class="table reco-table">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Date</th>
                                        <th>Valeur</th>
                                        <th>Libellé</th>
                                        <th>Réf. banque</th>
                                        <th class="text-right">Débit</th>
                                        <th class="text-right">Crédit</th>
                                        <th>Pointage</th>
                                        <?php if ($canEdit): ?><th class="text-center">Action</th><?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($statementLines)): ?>
                                    <?php foreach ($statementLines as $line): ?>
                                    <?php $ls = $lineStatus[$line->matching_status] ?? [$line->matching_status, 'badge-light']; ?>
                                    <tr>
                                        <td class="text-muted"><?= (int) $line->line_number ?></td>
                                        <td><?= date('d/m/Y', strtotime($line->operation_date)) ?></td>
                                        <td class="text-muted">
                                            <?= $line->value_date ? date('d/m/Y', strtotime($line->value_date)) : '—' ?>
                                        </td>
                                        <td><?= html_escape($line->label) ?></td>
                                        <td class="text-muted"><?= html_escape($line->bank_reference ?: '—') ?></td>
                                        <td class="num debit">
                                            <?= (float) $line->debit > 0 ? recoAmount($line->debit, $currency) : '' ?>
                                        </td>
                                        <td class="num credit">
                                            <?= (float) $line->credit > 0 ? recoAmount($line->credit, $currency) : '' ?>
                                        </td>
                                        <td><span class="badge <?= $ls[1] ?>"><?= html_escape($ls[0]) ?></span></td>
                                        <?php if ($canEdit): ?>
                                        <td class="text-center">
                                            <?php if (!in_array($line->matching_status, ['matched', 'partially_matched'], true)): ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                title="Supprimer"
                                                onclick="deleteStatementLine(<?= (int) $line->id ?>)"><i
                                                    class="fas fa-trash-alt"></i></button>
                                            <?php endif; ?>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="<?= $canEdit ? 9 : 8 ?>">
                                            <div class="reco-empty"><i class="fas fa-file-invoice"></i>Aucune ligne.
                                                Saisissez les lignes du relevé ou importez un fichier CSV.</div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                                <?php if (!empty($statementLines)): ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">Totaux du relevé</td>
                                        <td class="num debit"><?= recoAmount($summary['total_debit'], $currency) ?></td>
                                        <td class="num credit"><?= recoAmount($summary['total_credit'], $currency) ?>
                                        </td>
                                        <td colspan="<?= $canEdit ? 2 : 1 ?>">
                                            <?= $summary['is_balanced']
                                                    ? '<span class="text-success"><i class="fas fa-check-circle"></i> Équilibré</span>'
                                                    : '<span class="text-danger"><i class="fas fa-times-circle"></i> Écart ' . recoAmount($summary['statement_gap'], $currency) . '</span>' ?>
                                        </td>
                                    </tr>
                                </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>

                    <!-- ============ ONGLETS À VENIR ============ -->
                    <div class="tab-pane fade" id="tabMatching" role="tabpanel">
                        <div class="reco-soon"><i class="fas fa-link"></i>Le pointage automatique et manuel arrive à
                            l’étape 6b.</div>
                    </div>
                    <div class="tab-pane fade" id="tabRegularization" role="tabpanel">
                        <div class="reco-soon"><i class="fas fa-tools"></i>La régularisation des lignes du relevé arrive
                            à l’étape 6c.</div>
                    </div>
                    <div class="tab-pane fade" id="tabState" role="tabpanel">
                        <div class="reco-soon"><i class="fas fa-clipboard-check"></i>L’état de rapprochement et la
                            validation arrivent aux étapes 6b et 6c.</div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function($) {
    'use strict';

    var RECO_ID = <?= (int) $reco->id ?>;
    var URLS = {
        deleteLine: <?= json_encode(base_url('statement-line-delete'), $jsonFlags) ?>,
        cancel: <?= json_encode(base_url('reconciliation-cancel'), $jsonFlags) ?>,
        list: <?= json_encode(base_url('rapprochement'), $jsonFlags) ?>
    };
    var csrf = {
        name: <?= json_encode($this->security->get_csrf_token_name()) ?>,
        hash: <?= json_encode($this->security->get_csrf_hash()) ?>
    };

    function post(url, data) {
        if (csrf.name) data[csrf.name] = csrf.hash;
        return $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json'
        });
    }

    function ajaxError(xhr) {
        Swal.fire({
            icon: 'error',
            title: 'Action impossible',
            text: (xhr.responseJSON && xhr.responseJSON.message) || 'Erreur serveur.',
            confirmButtonColor: '#dc2626'
        });
    }

    window.deleteStatementLine = function(lineId) {
        Swal.fire({
            icon: 'question',
            title: 'Supprimer cette ligne du relevé ?',
            showCancelButton: true,
            confirmButtonText: 'Supprimer',
            cancelButtonText: 'Fermer',
            confirmButtonColor: '#dc2626'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            post(URLS.deleteLine, {
                    reconciliation_id: RECO_ID,
                    line_id: lineId
                })
                .done(function() {
                    window.location.reload();
                })
                .fail(ajaxError);
        });
    };

    window.cancelReconciliation = function() {
        Swal.fire({
            icon: 'warning',
            title: 'Annuler ce rapprochement ?',
            text: 'Le relevé et les pointages seront annulés. Le livre de banque n’est pas modifié.',
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

            post(URLS.cancel, {
                    reconciliation_id: RECO_ID,
                    cancel_reason: result.value
                })
                .done(function() {
                    window.location.href = URLS.list;
                })
                .fail(ajaxError);
        });
    };

    /* Nom du fichier CSV choisi */
    document.addEventListener('change', function(event) {
        if (!event.target.matches('.reco-file-field .custom-file-input')) return;

        var field = event.target.closest('.reco-file-field');
        var label = field.querySelector('.custom-file-label');
        var file = event.target.files && event.target.files[0];

        label.textContent = file ? file.name : 'Choisir le fichier CSV';
        field.classList.toggle('has-file', !!file);
    });

    $(function() {
        <?php if ($flashSuccess || $flashError): ?>
        Swal.fire({
            icon: <?= json_encode($flashError ? 'error' : 'success') ?>,
            title: <?= json_encode($flashError ? 'Action impossible' : 'Succès', JSON_UNESCAPED_UNICODE) ?>,
            html: <?= json_encode($flashError ?: $flashSuccess, $jsonFlags) ?>,
            confirmButtonColor: <?= json_encode($flashError ? '#dc2626' : '#0f766e') ?>
        });
        <?php endif; ?>
    });
})(window.jQuery);
</script>