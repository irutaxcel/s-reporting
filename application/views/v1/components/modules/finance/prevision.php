<?php
/* =====================================================================
 * PAGE : PRÉVISIONS DE TRÉSORERIE
 * ===================================================================== */

$flashSuccess = $this->session->flashdata('success');
$flashError   = $this->session->flashdata('error');
$reopenModal  = (bool) $this->session->flashdata('open_forecast_modal');
$old          = $this->session->flashdata('forecast_old_input');
$old          = is_array($old) ? $old : [];

if (!function_exists('prvAmount')) {
    function prvAmount($amount, string $currency = 'BIF'): string
    {
        return number_format((float) $amount, $currency === 'BIF' ? 0 : 2, ',', ' ');
    }
}

$cur       = $filters['currency'];
$today     = date('Y-m-d');
$jsonFlags = JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP;
$periods   = $plan['periods'];
$nbPeriods = count($periods);

$planQuery = http_build_query([
    'horizon'   => $filters['horizon'],
    'currency'  => $cur,
    'scenario'  => $filters['scenario'],
    'threshold' => $filters['threshold'],
]);

$statusLabels = [
    'planned'            => ['Prévue', 'badge-info'],
    'partially_realized' => ['Partielle', 'badge-warning'],
    'realized'           => ['Réalisée', 'badge-success'],
    'cancelled'          => ['Annulée', 'badge-secondary'],
];

$recurrenceLabels = [
    'none'      => 'Ponctuelle',
    'weekly'    => 'Hebdomadaire',
    'monthly'   => 'Mensuelle',
    'quarterly' => 'Trimestrielle',
    'yearly'    => 'Annuelle',
];

$entryTypes = ['encaissement', 'versement_banque', 'interets_crediteurs'];

$lowestAmount = (float) ($plan['lowest']['amount'] ?? $plan['opening']);
$lowestPeriod = $periods[$plan['lowest']['index']] ?? $periods[0];
$isLowAlert   = $lowestAmount < $plan['threshold'];

$oldValue = function (string $key, $default = '') use ($old) {
    return html_escape($old[$key] ?? $default);
};
?>

<style>
    :root {
        --prv-primary: #0f766e;
        --prv-primary-dark: #115e59;
        --prv-secondary: #102033;
        --prv-muted: #64748b;
        --prv-border: #e2e8f0
    }

    .prv-page {
        padding-bottom: 30px
    }

    .prv-hero {
        margin-bottom: 18px;
        padding: 20px 24px;
        border-radius: 15px;
        color: #fff;
        background: linear-gradient(120deg, #0f766e 0%, #155e75 55%, #102033 100%);
        box-shadow: 0 12px 30px rgba(15, 118, 110, .16)
    }

    .prv-hero h2 {
        margin: 0 0 6px;
        font-size: 21px;
        font-weight: 800
    }

    .prv-hero p {
        max-width: 820px;
        margin: 0 0 14px;
        color: rgba(255, 255, 255, .85);
        font-size: 12px;
        line-height: 1.6
    }

    .prv-hero label {
        display: block;
        margin-bottom: 4px;
        color: rgba(255, 255, 255, .8);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase
    }

    .prv-hero .form-control {
        min-height: 38px;
        border: 0;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700
    }

    .prv-stat {
        margin-bottom: 16px;
        padding: 16px 18px;
        border: 1px solid var(--prv-border);
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 7px 24px rgba(15, 23, 42, .045)
    }

    .prv-stat span {
        display: block;
        margin-bottom: 4px;
        color: var(--prv-muted);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase
    }

    .prv-stat strong {
        display: block;
        color: #0f172a;
        font-size: 19px;
        font-weight: 900
    }

    .prv-stat small {
        color: var(--prv-muted);
        font-size: 10px
    }

    .prv-stat.is-in strong {
        color: #15803d
    }

    .prv-stat.is-out strong {
        color: #b91c1c
    }

    .prv-stat.is-alert {
        border-color: #fecaca;
        background: #fef2f2
    }

    .prv-stat.is-alert strong {
        color: #b91c1c
    }

    .prv-stat.is-ok {
        border-color: #86efac;
        background: #f0fdf4
    }

    .prv-card {
        margin-bottom: 18px;
        overflow: hidden;
        border: 1px solid var(--prv-border);
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 6px 22px rgba(15, 23, 42, .04)
    }

    .prv-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 15px 18px;
        border-bottom: 1px solid #edf2f7
    }

    .prv-card-title {
        margin: 0 0 2px;
        color: var(--prv-secondary);
        font-size: 15px;
        font-weight: 800
    }

    .prv-card-title i {
        margin-right: 7px;
        color: var(--prv-primary)
    }

    .prv-card-subtitle {
        color: var(--prv-muted);
        font-size: 11px
    }

    .prv-card-body {
        padding: 18px
    }

    .btn-prv-primary {
        color: #fff;
        border: 1px solid var(--prv-primary);
        border-radius: 8px;
        background: var(--prv-primary);
        font-size: 12px;
        font-weight: 700
    }

    .btn-prv-primary:hover {
        color: #fff;
        background: var(--prv-primary-dark)
    }

    .btn-prv-outline {
        color: var(--prv-primary);
        border: 1px solid #9bd0ca;
        border-radius: 8px;
        background: #fff;
        font-size: 12px;
        font-weight: 700
    }

    .btn-prv-outline:hover {
        color: #fff;
        background: var(--prv-primary)
    }

    .prv-warning {
        margin-bottom: 16px;
        padding: 10px 14px;
        border: 1px solid #fde68a;
        border-radius: 10px;
        background: #fffbeb;
        color: #92400e;
        font-size: 12px;
        font-weight: 600
    }

    .prv-chart {
        position: relative;
        height: 300px
    }

    /* Plan de trésorerie */
    .prv-plan {
        margin-bottom: 0;
        font-size: 11px
    }

    .prv-plan th,
    .prv-plan td {
        padding: 7px 9px;
        white-space: nowrap;
        vertical-align: middle;
        border-color: #edf2f7
    }

    .prv-plan thead th {
        color: #475569;
        background: #f8fafc;
        font-size: 10px;
        font-weight: 900;
        text-align: right
    }

    .prv-plan thead th small {
        display: block;
        color: #94a3b8;
        font-weight: 600
    }

    .prv-plan th:first-child,
    .prv-plan td:first-child {
        position: sticky;
        left: 0;
        z-index: 1;
        min-width: 230px;
        text-align: left;
        background: #fff
    }

    .prv-plan thead th:first-child {
        background: #f8fafc
    }

    .prv-plan td {
        text-align: right
    }

    .prv-plan .prv-section td {
        color: var(--prv-secondary);
        background: #f1f5f9;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 10px
    }

    .prv-plan .prv-section td:first-child {
        background: #f1f5f9
    }

    .prv-plan .prv-total td {
        background: #f8fafc;
        font-weight: 900
    }

    .prv-plan .prv-total td:first-child {
        background: #f8fafc
    }

    .prv-plan .prv-balance td {
        background: #f0fdfa;
        font-weight: 900;
        color: #0f172a
    }

    .prv-plan .prv-balance td:first-child {
        background: #f0fdfa
    }

    .prv-plan td.is-low {
        color: #b91c1c !important;
        background: #fee2e2 !important
    }

    .prv-plan .prv-in {
        color: #15803d
    }

    .prv-plan .prv-out {
        color: #b91c1c
    }

    .prv-plan .prv-zero {
        color: #cbd5e1
    }

    .prv-auto {
        display: inline-block;
        margin-left: 5px;
        padding: 1px 6px;
        border-radius: 10px;
        color: #6d28d9;
        background: #ede9fe;
        font-size: 9px;
        font-weight: 800
    }

    /* Liste des prévisions */
    .prv-table {
        margin-bottom: 0
    }

    .prv-table thead th {
        padding: 10px;
        color: #475569;
        border-top: 0;
        background: #f8fafc;
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        white-space: nowrap
    }

    .prv-table tbody td {
        padding: 9px 10px;
        color: #334155;
        font-size: 12px;
        vertical-align: middle
    }

    .prv-table .num {
        text-align: right;
        white-space: nowrap;
        font-weight: 800
    }

    .prv-flow {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800
    }

    .prv-flow.entree {
        color: #15803d;
        background: #dcfce7
    }

    .prv-flow.sortie {
        color: #b91c1c;
        background: #fee2e2
    }

    .prv-late {
        color: #b45309;
        font-weight: 700
    }

    .prv-filters {
        display: flex;
        gap: 8px;
        flex-wrap: wrap
    }

    .prv-filters .form-control {
        min-height: 36px;
        border-color: #dbe4ea;
        border-radius: 8px;
        font-size: 12px
    }

    .prv-empty {
        padding: 40px 20px;
        text-align: center;
        color: var(--prv-muted)
    }

    .prv-empty i {
        display: block;
        margin-bottom: 10px;
        font-size: 32px;
        color: #cbd5e1
    }

    .prv-rate {
        display: inline-block;
        min-width: 52px;
        padding: 2px 7px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 800;
        text-align: center
    }

    .prv-rate.good {
        color: #15803d;
        background: #dcfce7
    }

    .prv-rate.mid {
        color: #92400e;
        background: #fef3c7
    }

    .prv-rate.bad {
        color: #b91c1c;
        background: #fee2e2
    }

    /* Modales */
    .modal-prv .modal-content {
        overflow: hidden;
        border: 0;
        border-radius: 14px
    }

    .modal-prv .modal-header {
        color: #fff;
        border-bottom: 0;
        background: linear-gradient(120deg, #0f766e, #155e75, #102033)
    }

    .modal-prv .modal-title {
        font-size: 15px;
        font-weight: 800
    }

    .modal-prv .close {
        color: #fff;
        opacity: 1
    }

    .modal-prv label {
        margin-bottom: 5px;
        color: #475569;
        font-size: 11px;
        font-weight: 800
    }

    .modal-prv .form-control {
        min-height: 38px;
        border-color: #dbe4ea;
        border-radius: 8px;
        font-size: 12px
    }

    .prv-info-box {
        padding: 9px 12px;
        border: 1px solid #99d5ce;
        border-radius: 9px;
        background: #f0fdfa;
        font-size: 12px
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
        <div class="container-fluid prv-page">

            <!-- =========================================================
                 BANDEAU + PARAMÈTRES DU PLAN
            ========================================================== -->
            <div class="prv-hero">
                <div class="d-flex justify-content-between flex-wrap" style="gap:12px">
                    <div>
                        <h2><i class="fas fa-chart-line mr-2"></i>Prévisions de trésorerie</h2>
                        <p>
                            Projection des soldes à partir de la trésorerie disponible aujourd’hui (banques et caisses),
                            des prévisions saisies, des échéances clients attendues et des bons de paiement en attente.
                        </p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-light font-weight-bold mb-2" data-toggle="modal"
                            data-target="#forecastModal">
                            <i class="fas fa-plus mr-1"></i> Nouvelle prévision
                        </button>
                        <a href="<?= base_url('prevision-export') . '?' . $planQuery ?>"
                            class="btn btn-outline-light font-weight-bold mb-2">
                            <i class="fas fa-file-csv mr-1"></i> Exporter
                        </a>
                    </div>
                </div>

                <form method="get" action="<?= base_url('prevision') ?>" class="row align-items-end">
                    <div class="col-xl-2 col-md-3 form-group mb-xl-0">
                        <label>Horizon</label>
                        <select name="horizon" class="form-control" onchange="this.form.submit()">
                            <option value="13w" <?= $filters['horizon'] === '13w' ? 'selected' : '' ?>>13 semaines
                            </option>
                            <option value="6m" <?= $filters['horizon'] === '6m' ? 'selected' : '' ?>>6 mois</option>
                            <option value="12m" <?= $filters['horizon'] === '12m' ? 'selected' : '' ?>>12 mois</option>
                        </select>
                    </div>
                    <div class="col-xl-2 col-md-3 form-group mb-xl-0">
                        <label>Devise</label>
                        <select name="currency" class="form-control" onchange="this.form.submit()">
                            <?php foreach (['BIF', 'USD', 'EUR'] as $c): ?>
                                <option value="<?= $c ?>" <?= $cur === $c ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-xl-2 col-md-3 form-group mb-xl-0">
                        <label>Scénario</label>
                        <select name="scenario" class="form-control" onchange="this.form.submit()">
                            <option value="pondere" <?= $filters['scenario'] === 'pondere' ? 'selected' : '' ?>>Pondéré
                                (× probabilité)</option>
                            <option value="brut" <?= $filters['scenario'] === 'brut' ? 'selected' : '' ?>>Brut (100 %)
                            </option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-md-3 form-group mb-xl-0">
                        <label>Seuil de sécurité (<?= html_escape($cur) ?>)</label>
                        <input type="number" name="threshold" class="form-control" min="0" step="1"
                            value="<?= html_escape($filters['threshold'] !== '' ? $filters['threshold'] : (string) round($threshold)) ?>">
                    </div>
                    <div class="col-xl-3 col-md-12 form-group mb-0">
                        <button type="submit" class="btn btn-light font-weight-bold mr-1"><i
                                class="fas fa-sync-alt mr-1"></i>Recalculer</button>
                        <a href="<?= base_url('prevision') ?>" class="btn btn-outline-light font-weight-bold"><i
                                class="fas fa-redo"></i></a>
                    </div>
                </form>
            </div>

            <?php if ($plan['overdue']['count'] > 0): ?>
                <div class="prv-warning">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    <?= (int) $plan['overdue']['count'] ?> flux en retard (date dépassée, non réalisés) ont été reportés
                    dans la première période :
                    entrées <?= prvAmount($plan['overdue']['in'], $cur) ?>, sorties
                    <?= prvAmount($plan['overdue']['out'], $cur) ?> <?= html_escape($cur) ?>.
                    Mettez-les à jour (réalisés, reportés ou annulés) pour fiabiliser le plan.
                </div>
            <?php endif; ?>

            <!-- =========================================================
                 INDICATEURS
            ========================================================== -->
            <div class="row">
                <div class="col-xl col-md-4">
                    <div class="prv-stat">
                        <span>Trésorerie disponible</span>
                        <strong><?= prvAmount($position['total'], $cur) ?> <?= html_escape($cur) ?></strong>
                        <small>Banques <?= prvAmount($position['bank'], $cur) ?> · Caisses
                            <?= prvAmount($position['cash'], $cur) ?></small>
                    </div>
                </div>
                <div class="col-xl col-md-4">
                    <div class="prv-stat is-in">
                        <span>Encaissements prévus</span>
                        <strong>+ <?= prvAmount($plan['total_in'], $cur) ?></strong>
                        <small>Sur l’horizon (<?= $filters['scenario'] === 'pondere' ? 'pondéré' : 'brut' ?>)</small>
                    </div>
                </div>
                <div class="col-xl col-md-4">
                    <div class="prv-stat is-out">
                        <span>Décaissements prévus</span>
                        <strong>- <?= prvAmount($plan['total_out'], $cur) ?></strong>
                        <small>Dont bons de paiement en attente</small>
                    </div>
                </div>
                <div class="col-xl col-md-6">
                    <div class="prv-stat <?= $plan['closing'] < $plan['threshold'] ? 'is-alert' : '' ?>">
                        <span>Solde prévisionnel fin d’horizon</span>
                        <strong><?= prvAmount($plan['closing'], $cur) ?> <?= html_escape($cur) ?></strong>
                        <small>Au <?= date('d/m/Y', strtotime($periods[$nbPeriods - 1]['end'])) ?></small>
                    </div>
                </div>
                <div class="col-xl col-md-6">
                    <div class="prv-stat <?= $isLowAlert ? 'is-alert' : 'is-ok' ?>">
                        <span>Point bas</span>
                        <strong><?= prvAmount($lowestAmount, $cur) ?> <?= html_escape($cur) ?></strong>
                        <small>
                            <?= html_escape($lowestPeriod['label'] . ' (' . $lowestPeriod['sublabel'] . ')') ?> —
                            <?= $isLowAlert
                                ? '<i class="fas fa-exclamation-circle"></i> sous le seuil (' . (int) $plan['alert_count'] . ' période(s))'
                                : '<i class="fas fa-check-circle"></i> au-dessus du seuil' ?>
                        </small>
                    </div>
                </div>
            </div>

            <!-- =========================================================
                 GRAPHIQUE + PRÉVU / RÉALISÉ
            ========================================================== -->
            <div class="row">
                <div class="col-xl-8">
                    <div class="prv-card">
                        <div class="prv-card-header">
                            <div>
                                <h5 class="prv-card-title"><i class="fas fa-chart-area"></i> Évolution du solde
                                    prévisionnel</h5>
                                <span class="prv-card-subtitle">Encaissements, décaissements et solde de fin de période,
                                    comparés au seuil de sécurité.</span>
                            </div>
                        </div>
                        <div class="prv-card-body">
                            <div class="prv-chart"><canvas id="prvChart"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="prv-card">
                        <div class="prv-card-header">
                            <div>
                                <h5 class="prv-card-title"><i class="fas fa-bullseye"></i> Prévu / réalisé</h5>
                                <span class="prv-card-subtitle">Prévisions saisies des 6 derniers mois.</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table prv-table">
                                <thead>
                                    <tr>
                                        <th>Mois</th>
                                        <th class="text-right">Entrées</th>
                                        <th class="text-right">Sorties</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($forecastVsActual as $month): ?>
                                        <?php
                                        $rateBadge = function ($rate) {
                                            if ($rate === null) return '<span class="text-muted">—</span>';
                                            $class = $rate >= 90 ? 'good' : ($rate >= 60 ? 'mid' : 'bad');
                                            return '<span class="prv-rate ' . $class . '">' . number_format($rate, 0, ',', ' ') . ' %</span>';
                                        };
                                        ?>
                                        <tr>
                                            <td><?= html_escape($month['label']) ?></td>
                                            <td class="text-right">
                                                <?= $rateBadge($month['in_rate']) ?>
                                                <?php if ($month['in_planned'] > 0): ?>
                                                    <small
                                                        class="d-block text-muted"><?= prvAmount($month['in_realized'], $cur) ?>
                                                        / <?= prvAmount($month['in_planned'], $cur) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-right">
                                                <?= $rateBadge($month['out_rate']) ?>
                                                <?php if ($month['out_planned'] > 0): ?>
                                                    <small
                                                        class="d-block text-muted"><?= prvAmount($month['out_realized'], $cur) ?>
                                                        / <?= prvAmount($month['out_planned'], $cur) ?></small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =========================================================
                 PLAN DE TRÉSORERIE
            ========================================================== -->
            <div class="prv-card">
                <div class="prv-card-header">
                    <div>
                        <h5 class="prv-card-title"><i class="fas fa-table"></i> Plan de trésorerie
                            (<?= html_escape($cur) ?>)</h5>
                        <span class="prv-card-subtitle">
                            Les cellules rouges indiquent un solde de fin sous le seuil de sécurité
                            (<?= prvAmount($plan['threshold'], $cur) ?>).
                            <span class="prv-auto">auto</span> = montant lu directement dans un autre module.
                        </span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered prv-plan">
                        <thead>
                            <tr>
                                <th>Rubrique</th>
                                <?php foreach ($periods as $period): ?>
                                    <th><?= html_escape($period['label']) ?><small><?= html_escape($period['sublabel']) ?></small>
                                    </th>
                                <?php endforeach; ?>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="prv-balance">
                                <td>Solde de début</td>
                                <?php foreach ($plan['openings'] as $value): ?>
                                    <td><?= prvAmount($value, $cur) ?></td>
                                <?php endforeach; ?>
                                <td></td>
                            </tr>

                            <?php foreach (['entree' => ['Encaissements', 'prv-in', 'totals_in', 'total_in'], 'sortie' => ['Décaissements', 'prv-out', 'totals_out', 'total_out']] as $flow => $meta): ?>
                                <tr class="prv-section">
                                    <td colspan="<?= $nbPeriods + 2 ?>"><?= $meta[0] ?></td>
                                </tr>

                                <?php if (empty($plan['rows'][$flow])): ?>
                                    <tr>
                                        <td class="text-muted">Aucun flux prévu</td>
                                        <td colspan="<?= $nbPeriods + 1 ?>"></td>
                                    </tr>
                                <?php endif; ?>

                                <?php foreach ($plan['rows'][$flow] as $row): ?>
                                    <tr>
                                        <td>
                                            <?= html_escape($row['label']) ?>
                                            <?php if ($row['auto']): ?><span class="prv-auto">auto</span><?php endif; ?>
                                        </td>
                                        <?php foreach ($row['values'] as $value): ?>
                                            <td class="<?= $value > 0 ? $meta[1] : 'prv-zero' ?>">
                                                <?= $value > 0 ? prvAmount($value, $cur) : '—' ?></td>
                                        <?php endforeach; ?>
                                        <td class="<?= $meta[1] ?> font-weight-bold"><?= prvAmount($row['total'], $cur) ?></td>
                                    </tr>
                                <?php endforeach; ?>

                                <tr class="prv-total">
                                    <td>Total <?= mb_strtolower($meta[0]) ?></td>
                                    <?php foreach ($plan[$meta[2]] as $value): ?>
                                        <td class="<?= $meta[1] ?>"><?= prvAmount($value, $cur) ?></td>
                                    <?php endforeach; ?>
                                    <td class="<?= $meta[1] ?>"><?= prvAmount($plan[$meta[3]], $cur) ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="prv-total">
                                <td>Flux net</td>
                                <?php foreach ($plan['net'] as $value): ?>
                                    <td class="<?= $value >= 0 ? 'prv-in' : 'prv-out' ?>">
                                        <?= ($value >= 0 ? '+' : '') . prvAmount($value, $cur) ?></td>
                                <?php endforeach; ?>
                                <td><?= prvAmount($plan['total_in'] - $plan['total_out'], $cur) ?></td>
                            </tr>
                            <tr class="prv-balance">
                                <td>Solde de fin</td>
                                <?php foreach ($plan['closings'] as $value): ?>
                                    <td class="<?= $value < $plan['threshold'] ? 'is-low' : '' ?>">
                                        <?= prvAmount($value, $cur) ?></td>
                                <?php endforeach; ?>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- =========================================================
                 PRÉVISIONS SAISIES
            ========================================================== -->
            <div class="prv-card">
                <div class="prv-card-header">
                    <div>
                        <h5 class="prv-card-title"><i class="fas fa-list"></i> Prévisions saisies</h5>
                        <span class="prv-card-subtitle"><?= count($forecasts) ?> ligne(s) — devise
                            <?= html_escape($cur) ?></span>
                    </div>
                    <form method="get" action="<?= base_url('prevision') ?>" class="prv-filters">
                        <input type="hidden" name="horizon" value="<?= html_escape($filters['horizon']) ?>">
                        <input type="hidden" name="currency" value="<?= html_escape($cur) ?>">
                        <input type="hidden" name="scenario" value="<?= html_escape($filters['scenario']) ?>">
                        <input type="hidden" name="threshold" value="<?= html_escape($filters['threshold']) ?>">
                        <select name="flow_type" class="form-control" onchange="this.form.submit()">
                            <option value="">Entrées et sorties</option>
                            <option value="entree" <?= $filters['flow_type'] === 'entree' ? 'selected' : '' ?>>Entrées
                            </option>
                            <option value="sortie" <?= $filters['flow_type'] === 'sortie' ? 'selected' : '' ?>>Sorties
                            </option>
                        </select>
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="open" <?= $filters['status'] === 'open' ? 'selected' : '' ?>>À réaliser
                            </option>
                            <?php foreach ($statusLabels as $key => $label): ?>
                                <option value="<?= $key ?>" <?= $filters['status'] === $key ? 'selected' : '' ?>>
                                    <?= $label[0] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table prv-table">
                        <thead>
                            <tr>
                                <th>Date prévue</th>
                                <th>Référence</th>
                                <th>Sens</th>
                                <th>Libellé</th>
                                <th>Récurrence</th>
                                <th class="text-right">Montant</th>
                                <th class="text-right">Réalisé</th>
                                <th class="text-center">Proba.</th>
                                <th>Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($forecasts)): ?>
                                <?php foreach ($forecasts as $f): ?>
                                    <?php
                                    $isOpen  = in_array($f->status, ['planned', 'partially_realized'], true);
                                    $isLate  = $isOpen && $f->expected_date < $today;
                                    $st      = $statusLabels[$f->status] ?? [$f->status, 'badge-light'];
                                    $payload = [
                                        'id'        => (int) $f->id,
                                        'reference' => $f->reference,
                                        'label'     => $f->label,
                                        'flow'      => $f->flow_type,
                                        'currency'  => $f->currency,
                                        'remaining' => round((float) $f->amount - (float) $f->realized_amount, 2),
                                    ];
                                    ?>
                                    <tr>
                                        <td class="<?= $isLate ? 'prv-late' : '' ?>">
                                            <?= date('d/m/Y', strtotime($f->expected_date)) ?>
                                            <?php if ($isLate): ?><small class="d-block"><i class="fas fa-clock"></i> en
                                                    retard</small><?php endif; ?>
                                        </td>
                                        <td><strong><?= html_escape($f->reference) ?></strong></td>
                                        <td><span
                                                class="prv-flow <?= $f->flow_type ?>"><?= $f->flow_type === 'entree' ? 'Entrée' : 'Sortie' ?></span>
                                        </td>
                                        <td>
                                            <strong><?= html_escape($f->label) ?></strong>
                                            <small class="d-block text-muted">
                                                <?= html_escape($categories[$f->flow_type][$f->category] ?? $f->category) ?>
                                                <?= !empty($f->third_party) ? ' · ' . html_escape($f->third_party) : '' ?>
                                                <?= !empty($f->chantier_name) ? ' · ' . html_escape($f->chantier_name) : '' ?>
                                                <?= !empty($f->account_name) ? ' · ' . html_escape($f->account_name) : '' ?>
                                            </small>
                                            <?php if ($f->status === 'cancelled' && !empty($f->cancel_reason)): ?>
                                                <small class="d-block text-danger">Annulée :
                                                    <?= html_escape($f->cancel_reason) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= html_escape($recurrenceLabels[$f->recurrence] ?? $f->recurrence) ?></td>
                                        <td class="num"><?= prvAmount($f->amount, $f->currency) ?></td>
                                        <td class="num">
                                            <?= (float) $f->realized_amount > 0 ? prvAmount($f->realized_amount, $f->currency) : '—' ?>
                                            <?php if (!empty($f->operation_reference)): ?>
                                                <small
                                                    class="d-block text-muted"><?= html_escape($f->operation_reference) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?= (int) $f->probability ?> %</td>
                                        <td><span class="badge <?= $st[1] ?>"><?= $st[0] ?></span></td>
                                        <td class="text-center text-nowrap">
                                            <?php if ($isOpen): ?>
                                                <button type="button" class="btn btn-sm btn-prv-outline" title="Réaliser"
                                                    data-toggle="modal" data-target="#realizeModal"
                                                    data-forecast="<?= html_escape(json_encode($payload, $jsonFlags)) ?>">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($f->status === 'planned'): ?>
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Annuler"
                                                    onclick="prvCancel(<?= (int) $f->id ?>, <?= html_escape(json_encode($f->reference)) ?>, <?= $f->recurrence !== 'none' ? 'true' : 'false' ?>)">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10">
                                        <div class="prv-empty">
                                            <i class="fas fa-calendar-plus"></i>
                                            Aucune prévision pour ces critères.
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-prv-primary" data-toggle="modal"
                                                    data-target="#forecastModal">
                                                    <i class="fas fa-plus mr-1"></i> Saisir une prévision
                                                </button>
                                            </div>
                                        </div>
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
     MODALE : NOUVELLE PRÉVISION
========================================================== -->
<div class="modal fade modal-prv" id="forecastModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="<?= base_url('prevision-store') ?>" method="post" class="w-100" autocomplete="off">
            <input type="hidden" name="return_query" value="<?= html_escape($planQuery) ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-calendar-plus mr-2"></i>Nouvelle prévision</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Sens <span class="required-star">*</span></label>
                            <select name="flow_type" id="prvFlow" class="form-control" required>
                                <option value="sortie"
                                    <?= ($old['flow_type'] ?? 'sortie') === 'sortie' ? 'selected' : '' ?>>Sortie
                                    (décaissement)</option>
                                <option value="entree" <?= ($old['flow_type'] ?? '') === 'entree' ? 'selected' : '' ?>>
                                    Entrée (encaissement)</option>
                            </select>
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Catégorie <span class="required-star">*</span></label>
                            <select name="category" id="prvCategory" class="form-control" required>
                                <?php foreach ($categories as $flow => $items): ?>
                                    <?php foreach ($items as $key => $label): ?>
                                        <option value="<?= $key ?>" data-flow="<?= $flow ?>"
                                            <?= ($old['category'] ?? '') === $key ? 'selected' : '' ?>>
                                            <?= html_escape($label) ?></option>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Libellé <span class="required-star">*</span></label>
                            <input type="text" name="label" class="form-control" maxlength="255" required
                                value="<?= $oldValue('label') ?>"
                                placeholder="Ex. Salaires du personnel de chantier, décompte n°3 chantier X…">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Date prévue <span class="required-star">*</span></label>
                            <input type="date" name="expected_date" class="form-control" required
                                value="<?= $oldValue('expected_date', $today) ?>">
                        </div>
                        <div class="col-md-5 form-group">
                            <label>Montant <span class="required-star">*</span></label>
                            <input type="number" name="amount" class="form-control" min="0.01" step="0.01" required
                                value="<?= $oldValue('amount') ?>">
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Devise <span class="required-star">*</span></label>
                            <select name="currency" id="prvCurrency" class="form-control" required>
                                <?php foreach (['BIF', 'USD', 'EUR'] as $c): ?>
                                    <option value="<?= $c ?>" <?= ($old['currency'] ?? $cur) === $c ? 'selected' : '' ?>>
                                        <?= $c ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Probabilité <span class="required-star">*</span></label>
                            <select name="probability" class="form-control" required>
                                <?php foreach ([100 => 'Certaine (100 %)', 90 => 'Très probable (90 %)', 70 => 'Probable (70 %)', 50 => 'Incertaine (50 %)', 25 => 'Peu probable (25 %)'] as $p => $label): ?>
                                    <option value="<?= $p ?>"
                                        <?= (int) ($old['probability'] ?? 100) === $p ? 'selected' : '' ?>><?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Récurrence <span class="required-star">*</span></label>
                            <select name="recurrence" id="prvRecurrence" class="form-control" required>
                                <?php foreach ($recurrenceLabels as $key => $label): ?>
                                    <option value="<?= $key ?>"
                                        <?= ($old['recurrence'] ?? 'none') === $key ? 'selected' : '' ?>><?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="prvRecurrenceEndField">
                            <label>Jusqu’au <span class="required-star">*</span></label>
                            <input type="date" name="recurrence_end_date" id="prvRecurrenceEnd" class="form-control"
                                value="<?= $oldValue('recurrence_end_date', date('Y-12-31')) ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Compte bancaire concerné</label>
                            <select name="bank_account_id" id="prvAccount" class="form-control">
                                <option value="">Trésorerie globale</option>
                                <?php foreach ($bankAccounts as $account): ?>
                                    <option value="<?= (int) $account->id ?>"
                                        data-currency="<?= html_escape($account->currency) ?>"
                                        <?= (string) ($old['bank_account_id'] ?? '') === (string) $account->id ? 'selected' : '' ?>>
                                        <?= html_escape($account->code . ' — ' . $account->name . ' (' . $account->currency . ')') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Chantier</label>
                            <select name="chantier_id" class="form-control">
                                <option value="">Aucun / frais généraux</option>
                                <?php foreach ($chantiers as $chantier): ?>
                                    <option value="<?= (int) $chantier->id ?>"
                                        <?= (string) ($old['chantier_id'] ?? '') === (string) $chantier->id ? 'selected' : '' ?>>
                                        <?= html_escape(($chantier->ref_chantier ? $chantier->ref_chantier . ' — ' : '') . $chantier->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Tiers</label>
                            <input type="text" name="third_party" class="form-control" maxlength="255"
                                value="<?= $oldValue('third_party') ?>"
                                placeholder="Client, fournisseur, administration…">
                        </div>
                        <div class="col-md-12 form-group mb-0">
                            <label>Observation</label>
                            <textarea name="observation" class="form-control"
                                rows="2"><?= $oldValue('observation') ?></textarea>
                        </div>
                    </div>
                    <div class="prv-info-box mt-3" id="prvRecurrenceInfo" style="display:none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-prv-outline" data-dismiss="modal"><i
                            class="fas fa-times mr-1"></i>Annuler</button>
                    <button type="submit" class="btn btn-prv-primary"><i
                            class="fas fa-save mr-1"></i>Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
     MODALE : RÉALISATION
========================================================== -->
<div class="modal fade modal-prv" id="realizeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="realizeForm" class="w-100" autocomplete="off">
            <input type="hidden" name="forecast_id" id="realizeId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-check-circle mr-2"></i>Réaliser <span
                            id="realizeRef"></span></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="prv-info-box mb-3" id="realizeInfo"></div>
                    <div class="form-group">
                        <label>Montant réalisé <span class="required-star">*</span></label>
                        <input type="number" name="realized_amount" id="realizeAmount" class="form-control" min="0.01"
                            step="0.01" required>
                        <small class="text-muted">Un montant inférieur au reste à réaliser donne une réalisation
                            partielle.</small>
                    </div>
                    <div class="form-group">
                        <label>Date de réalisation <span class="required-star">*</span></label>
                        <input type="date" name="realized_date" class="form-control" max="<?= $today ?>"
                            value="<?= $today ?>" required>
                    </div>
                    <div class="form-group mb-0">
                        <label>Opération bancaire correspondante (facultatif)</label>
                        <select name="bank_operation_id" id="realizeOperation" class="form-control">
                            <option value="">Aucune / paiement en caisse</option>
                            <?php foreach ($realizableOperations as $op): ?>
                                <option value="<?= (int) $op->id ?>"
                                    data-direction="<?= in_array($op->operation_type, $entryTypes, true) ? 'entree' : 'sortie' ?>">
                                    <?= html_escape($op->reference . ' — ' . date('d/m/Y', strtotime($op->operation_date)) . ' — ' . prvAmount($op->amount, $cur) . ' — ' . $op->label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-prv-outline" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-prv-primary"><i class="fas fa-check mr-1"></i>Enregistrer la
                        réalisation</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
     SCRIPTS
========================================================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var PRV = {
        urls: {
            realize: <?= json_encode(base_url('prevision-realize'), $jsonFlags) ?>,
            cancel: <?= json_encode(base_url('prevision-cancel'), $jsonFlags) ?>
        },
        csrf: {
            name: <?= json_encode($this->security->get_csrf_token_name()) ?>,
            hash: <?= json_encode($this->security->get_csrf_hash()) ?>
        },
        currency: <?= json_encode($cur) ?>,
        chart: {
            labels: <?= json_encode(array_map(function ($p) {
                        return $p['label'];
                    }, $periods), $jsonFlags) ?>,
            incomes: <?= json_encode($plan['totals_in']) ?>,
            expenses: <?= json_encode($plan['totals_out']) ?>,
            closings: <?= json_encode($plan['closings']) ?>,
            threshold: <?= json_encode((float) $plan['threshold']) ?>
        },
        recurrenceLabels: <?= json_encode($recurrenceLabels, $jsonFlags) ?>
    };

    function prvMoney(amount, currency) {
        currency = currency || PRV.currency;
        var digits = currency === 'BIF' ? 0 : 2;
        return new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: digits,
                maximumFractionDigits: digits
            })
            .format(parseFloat(amount || 0)) + ' ' + currency;
    }

    function prvPost(url, data) {
        if (PRV.csrf.name) data[PRV.csrf.name] = PRV.csrf.hash;
        return window.jQuery.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json'
        });
    }

    function prvError(xhr) {
        Swal.fire({
            icon: 'error',
            title: 'Action impossible',
            text: (xhr.responseJSON && xhr.responseJSON.message) || 'Erreur serveur.',
            confirmButtonColor: '#dc2626'
        });
    }

    function prvSuccessReload(title, message) {
        Swal.fire({
                icon: 'success',
                title: title,
                text: message,
                confirmButtonColor: '#0f766e'
            })
            .then(function() {
                window.location.reload();
            });
    }

    /* Annulation d'une prévision (avec option « toute la suite de la série ») */
    function prvCancel(id, reference, isRecurring) {
        Swal.fire({
            icon: 'warning',
            title: 'Annuler ' + reference + ' ?',
            html: '<textarea id="prvCancelReason" class="swal2-textarea" placeholder="Motif de l’annulation…"></textarea>' +
                (isRecurring ?
                    '<label style="font-size:13px;display:block;margin-top:8px"><input type="checkbox" id="prvCancelSeries"> Annuler aussi les échéances suivantes de cette série</label>' :
                    ''),
            showCancelButton: true,
            confirmButtonText: 'Annuler la prévision',
            cancelButtonText: 'Fermer',
            confirmButtonColor: '#dc2626',
            preConfirm: function() {
                var reason = document.getElementById('prvCancelReason').value.trim();
                if (!reason) {
                    Swal.showValidationMessage('Le motif est obligatoire.');
                    return false;
                }
                var series = document.getElementById('prvCancelSeries');
                return {
                    reason: reason,
                    series: series && series.checked ? 1 : 0
                };
            }
        }).then(function(result) {
            if (!result.isConfirmed) return;

            prvPost(PRV.urls.cancel, {
                    forecast_id: id,
                    cancel_reason: result.value.reason,
                    cancel_series: result.value.series
                })
                .done(function(response) {
                    prvSuccessReload('Prévision annulée', response.message);
                })
                .fail(prvError);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var $ = window.jQuery;

        if (!$) {
            console.error('Prévisions : jQuery n’est pas chargé.');
            return;
        }

        $(document).ajaxComplete(function(event, xhr) {
            if (xhr.responseJSON && xhr.responseJSON.csrf_hash) {
                PRV.csrf.hash = xhr.responseJSON.csrf_hash;
            }
        });

        /* ---------- Modale « Nouvelle prévision » ---------- */
        function refreshCategories() {
            var flow = $('#prvFlow').val();
            var $select = $('#prvCategory');

            $select.find('option').each(function() {
                var visible = $(this).data('flow') === flow;
                $(this).prop('hidden', !visible).prop('disabled', !visible);
            });

            if ($select.find('option:selected').prop('disabled')) {
                $select.val($select.find('option[data-flow="' + flow + '"]').first().val());
            }
        }

        function refreshRecurrence() {
            var recurrence = $('#prvRecurrence').val();
            var isRecurring = recurrence !== 'none';

            $('#prvRecurrenceEndField').toggle(isRecurring);
            $('#prvRecurrenceEnd').prop('required', isRecurring);
            $('#prvRecurrenceInfo').toggle(isRecurring).text(
                isRecurring ?
                'Une échéance ' + PRV.recurrenceLabels[recurrence].toLowerCase() +
                ' sera créée de la date prévue jusqu’à la date de fin (60 échéances maximum). Chacune pourra être réalisée ou annulée séparément.' :
                ''
            );
        }

        function refreshAccountCurrency() {
            var currency = $('#prvAccount option:selected').data('currency');
            if (currency) {
                $('#prvCurrency').val(currency);
            }
            $('#prvCurrency').prop('disabled', !!currency);
        }

        $('#prvFlow').on('change', refreshCategories);
        $('#prvRecurrence').on('change', refreshRecurrence);
        $('#prvAccount').on('change', refreshAccountCurrency);

        /* Le champ devise désactivé n'est pas envoyé : on le réactive avant l'envoi */
        $('#forecastModal form').on('submit', function() {
            $('#prvCurrency').prop('disabled', false);
        });

        refreshCategories();
        refreshRecurrence();
        refreshAccountCurrency();

        <?php if ($reopenModal): ?>
            $('#forecastModal').modal('show');
        <?php endif; ?>

        /* ---------- Modale « Réaliser » ---------- */
        $('#realizeModal').on('show.bs.modal', function(event) {
            var data = $(event.relatedTarget).data('forecast');

            if (!data) return;

            $('#realizeId').val(data.id);
            $('#realizeRef').text(data.reference);
            $('#realizeAmount').val(data.remaining);
            $('#realizeInfo').html(
                '<strong>' + $('<div>').text(data.label).html() + '</strong><br>' +
                (data.flow === 'entree' ? 'Entrée' : 'Sortie') + ' — reste à réaliser : <strong>' +
                prvMoney(data.remaining, data.currency) + '</strong>'
            );

            /* Seules les opérations bancaires de même sens sont proposées */
            $('#realizeOperation').val('').find('option').each(function() {
                if (!this.value) return;
                var visible = $(this).data('direction') === data.flow;
                $(this).prop('hidden', !visible).prop('disabled', !visible);
            });
        });

        $('#realizeForm').on('submit', function(event) {
            event.preventDefault();

            var data = {};
            $(this).serializeArray().forEach(function(field) {
                data[field.name] = field.value;
            });

            prvPost(PRV.urls.realize, data)
                .done(function(response) {
                    $('#realizeModal').modal('hide');
                    prvSuccessReload('Réalisation enregistrée', response.message);
                })
                .fail(prvError);
        });

        /* ---------- Graphique ---------- */
        var canvas = document.getElementById('prvChart');

        if (canvas && typeof Chart !== 'undefined') {
            new Chart(canvas.getContext('2d'), {
                data: {
                    labels: PRV.chart.labels,
                    datasets: [{
                        type: 'bar',
                        label: 'Encaissements',
                        data: PRV.chart.incomes,
                        backgroundColor: 'rgba(22,163,74,.55)',
                        borderRadius: 4,
                        order: 3
                    }, {
                        type: 'bar',
                        label: 'Décaissements',
                        data: PRV.chart.expenses,
                        backgroundColor: 'rgba(220,38,38,.5)',
                        borderRadius: 4,
                        order: 3
                    }, {
                        type: 'line',
                        label: 'Solde de fin',
                        data: PRV.chart.closings,
                        borderColor: '#0f766e',
                        backgroundColor: '#0f766e',
                        borderWidth: 3,
                        pointRadius: 3,
                        tension: .3,
                        order: 1
                    }, {
                        type: 'line',
                        label: 'Seuil de sécurité',
                        data: PRV.chart.labels.map(function() {
                            return PRV.chart.threshold;
                        }),
                        borderColor: '#f59e0b',
                        borderDash: [6, 6],
                        borderWidth: 2,
                        pointRadius: 0,
                        order: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    return ctx.dataset.label + ' : ' + prvMoney(ctx.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(148,163,184,.15)'
                            },
                            ticks: {
                                callback: function(v) {
                                    var a = Math.abs(v);
                                    if (a >= 1e9) return (v / 1e9) + ' Md';
                                    if (a >= 1e6) return (v / 1e6) + ' M';
                                    if (a >= 1e3) return (v / 1e3) + ' K';
                                    return v;
                                }
                            }
                        }
                    }
                }
            });
        }

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