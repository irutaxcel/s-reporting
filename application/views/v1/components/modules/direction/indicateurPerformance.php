<?php
$fmt = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$pct = function ($v) {
    return $v === null ? '—' : number_format($v, 1, ',', ' ') . ' %';
};
$nice = function ($s) {
    return ucfirst(str_replace('_', ' ', (string) $s));
};

/**
 * Badge d'évolution vs N-1
 * $mode  : 'pct' (variation relative) ou 'pts' (différence en points)
 * $sense : 1 = plus haut c'est mieux, -1 = plus bas c'est mieux, 0 = neutre
 */
$evo = function ($cur, $prev, $mode = 'pct', $sense = 1) use ($annee) {
    $ref = ' vs ' . ($annee - 1);
    if ($cur === null || $prev === null) {
        return '<span class="pf-evo neutral"><i class="fas fa-minus"></i> Pas de comparaison</span>';
    }
    if ($mode === 'pts') {
        $d   = $cur - $prev;
        $txt = ($d >= 0 ? '+' : '') . number_format($d, 1, ',', ' ') . ' pts';
    } else {
        if ((float) $prev == 0.0) {
            return '<span class="pf-evo neutral"><i class="fas fa-star"></i> Nouveau' . $ref . '</span>';
        }
        $d   = ($cur - $prev) / abs($prev) * 100;
        $txt = ($d >= 0 ? '+' : '') . number_format($d, 1, ',', ' ') . ' %';
    }
    if (abs($d) < 0.05 || $sense === 0) {
        $cls = 'neutral';
    } else {
        $cls = (($sense === 1 && $d > 0) || ($sense === -1 && $d < 0)) ? 'up' : 'down';
    }
    $icon = $d > 0 ? 'fa-arrow-up' : ($d < 0 ? 'fa-arrow-down' : 'fa-minus');
    return '<span class="pf-evo ' . $cls . '"><i class="fas ' . $icon . '"></i> ' . $txt . $ref . '</span>';
};

$mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

$risqueBadge = [
    'Dépassement'         => 'danger',
    'En retard'           => 'danger',
    'À surveiller'        => 'warning',
    'Conforme'            => 'success',
    'Données incomplètes' => 'secondary',
];
?>

<style>
.pf-toolbar {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
}

.pf-toolbar select.form-control {
    width: 130px !important;
    flex: 0 0 130px;
    border-radius: 10px;
    border: 1px solid #d7e6dc;
    font-weight: 700;
    color: var(--satraco-dark);
}

.pf-section-title {
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .8px;
    text-transform: uppercase;
    color: #6b7f78;
    margin: 6px 0 12px;
}

.pf-kpi {
    background: #fff;
    border-radius: 16px;
    padding: 18px;
    height: 100%;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
    border: 1px solid #eef3f0;
    border-top: 4px solid var(--satraco-green);
}

.pf-kpi.c2 {
    border-top-color: #2f5d8a;
}

.pf-kpi.c3 {
    border-top-color: #f6ad55;
}

.pf-kpi.c4 {
    border-top-color: #9f7aea;
}

.pf-kpi .top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}

.pf-kpi .lbl {
    font-size: 12.5px;
    color: #6b7f78;
    font-weight: 700;
}

.pf-kpi .top i {
    color: #b9cbc2;
    font-size: 18px;
}

.pf-kpi .val {
    font-size: 26px;
    font-weight: 800;
    color: var(--satraco-dark);
    line-height: 1.1;
}

.pf-kpi .val small {
    font-size: 13px;
    color: #8a9a94;
    font-weight: 700;
}

.pf-kpi .hint {
    font-size: 11.5px;
    color: #8a9a94;
    margin-top: 6px;
}

.pf-gauge {
    height: 6px;
    background: #eef3f0;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 10px;
}

.pf-gauge span {
    display: block;
    height: 100%;
    border-radius: 10px;
    background: linear-gradient(90deg, #0f766e, #74c476);
}

.pf-gauge span.warn {
    background: linear-gradient(90deg, #b7791f, #f6ad55);
}

.pf-gauge span.bad {
    background: linear-gradient(90deg, #c0392b, #f08a7e);
}

.pf-evo {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-top: 8px;
    font-size: 11.5px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 20px;
}

.pf-evo.up {
    background: #e6f5ea;
    color: #1f7a3a;
}

.pf-evo.down {
    background: #fdecea;
    color: #c0392b;
}

.pf-evo.neutral {
    background: #f1f4f3;
    color: #6b7f78;
}

.pf-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
    border: 1px solid #eef3f0;
    margin-bottom: 20px;
    height: calc(100% - 20px);
    display: flex;
    flex-direction: column;
}

.pf-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px 6px;
}

.pf-card-head h3 {
    font-size: 15px;
    font-weight: 800;
    color: var(--satraco-dark);
    margin: 0;
}

.pf-card-head h3 i {
    color: var(--satraco-green-dark);
    margin-right: 6px;
}

.pf-card-head small {
    color: #8a9a94;
}

.pf-card-body {
    padding: 8px 18px 18px;
    flex: 1;
}

.pf-chart {
    position: relative;
    height: 280px;
}

.pf-chart.sm {
    height: 240px;
}

.pf-empty {
    text-align: center;
    color: #8a9a94;
    padding: 30px 10px;
    font-size: 13px;
}

.pf-empty i {
    display: block;
    font-size: 28px;
    color: #cfe3d6;
    margin-bottom: 8px;
}

.pf-table {
    width: 100%;
    font-size: 13px;
}

.pf-table th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #8a9a94;
    font-weight: 700;
    border-bottom: 1px solid #eef3f0;
    padding: 8px 6px;
    white-space: nowrap;
}

.pf-table td {
    padding: 10px 6px;
    border-bottom: 1px solid #f3f6f4;
    vertical-align: middle;
    color: var(--satraco-dark);
}

.pf-table tr:last-child td {
    border-bottom: 0;
}

.pf-dual {
    min-width: 150px;
}

.pf-dual .row-bar {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #6b7f78;
}

.pf-dual .row-bar+.row-bar {
    margin-top: 4px;
}

.pf-dual .row-bar .lab {
    width: 48px;
}

.pf-dual .row-bar .bar {
    flex: 1;
    height: 6px;
    background: #eef3f0;
    border-radius: 10px;
    overflow: hidden;
}

.pf-dual .row-bar .bar span {
    display: block;
    height: 100%;
    border-radius: 10px;
}

.pf-dual .row-bar .num {
    width: 42px;
    text-align: right;
    font-weight: 700;
    color: var(--satraco-dark);
}

.pf-legend-note {
    font-size: 12px;
    color: #6b7f78;
    background: var(--satraco-white-soft);
    border-radius: 10px;
    padding: 10px 12px;
}

.pf-rh {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.pf-rh div {
    background: var(--satraco-white-soft);
    border-radius: 12px;
    padding: 12px;
}

.pf-rh span {
    display: block;
    font-size: 11.5px;
    color: #6b7f78;
    font-weight: 600;
}

.pf-rh b {
    font-size: 18px;
    color: var(--satraco-dark);
}
</style>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold" style="color: var(--satraco-dark)">Indicateurs de performance</h1>
                    <small class="text-muted">Exercice <?= (int) $annee ?> comparé à <?= (int) $annee - 1 ?></small>
                </div>
                <div class="col-sm-6 mt-2 mt-sm-0">
                    <form method="get" class="pf-toolbar">
                        <label class="mb-0 text-muted small font-weight-bold">Année</label>
                        <select name="annee" class="form-control form-control-sm" onchange="this.form.submit()">
                            <?php for ($y = (int) date('Y'); $y >= (int) date('Y') - 4; $y--): ?>
                            <option value="<?= $y ?>" <?= $y == $annee ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- ============ PERFORMANCE FINANCIÈRE & PROCESSUS ============ -->
            <div class="pf-section-title">Finances & processus d'achat — <?= (int) $annee ?></div>
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="pf-kpi">
                        <div class="top"><span class="lbl">Taux d'exécution financière</span><i
                                class="fas fa-percentage"></i></div>
                        <div class="val"><?= $pct($perf['taux_execution']) ?></div>
                        <div class="hint"><?= $fmt($perf['paye']) ?> payés / <?= $fmt($perf['engage']) ?> BIF engagés
                        </div>
                        <?= $evo($perf['taux_execution'], $perfPrev['taux_execution'], 'pts', 1) ?>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="pf-kpi c2">
                        <div class="top"><span class="lbl">Délai moyen de traitement</span><i
                                class="fas fa-stopwatch"></i></div>
                        <div class="val">
                            <?= $perf['delai_moyen'] === null ? '—' : number_format($perf['delai_moyen'], 1, ',', ' ') ?>
                            <small>jours</small>
                        </div>
                        <div class="hint">De la demande au paiement effectif</div>
                        <?= $evo($perf['delai_moyen'], $perfPrev['delai_moyen'], 'pct', -1) ?>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="pf-kpi c3">
                        <div class="top"><span class="lbl">Taux d'approbation DG</span><i class="fas fa-stamp"></i>
                        </div>
                        <div class="val"><?= $pct($perf['taux_approbation']) ?></div>
                        <div class="hint"><?= (int) $perf['nb_approuvees'] ?> validées ·
                            <?= (int) $perf['nb_rejetees'] ?> rejetées</div>
                        <?= $evo($perf['taux_approbation'], $perfPrev['taux_approbation'], 'pts', 0) ?>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="pf-kpi c4">
                        <div class="top"><span class="lbl">Montant moyen par demande</span><i
                                class="fas fa-receipt"></i></div>
                        <div class="val">
                            <?= $perf['montant_moyen'] === null ? '—' : $fmt($perf['montant_moyen']) ?>
                            <small>BIF</small>
                        </div>
                        <div class="hint"><?= (int) $perf['nb_demandes'] ?> demandes sur l'année</div>
                        <?= $evo($perf['montant_moyen'], $perfPrev['montant_moyen'], 'pct', 0) ?>
                    </div>
                </div>
            </div>

            <!-- ============ OPÉRATIONS (PHOTO DU JOUR) ============ -->
            <div class="pf-section-title mt-2">Opérations — situation au <?= date('d/m/Y') ?></div>
            <div class="row">
                <?php
                $tc  = $snap['taux_consommation'];
                $tcC = $tc === null ? '' : ($tc > 100 ? 'bad' : ($tc >= 80 ? 'warn' : ''));
                $tr  = $snap['taux_retard'];
                $trC = $tr === null ? '' : ($tr >= 30 ? 'bad' : ($tr > 0 ? 'warn' : ''));
                $td  = $snap['taux_disponibilite'];
                $tdC = $td === null ? '' : ($td < 60 ? 'bad' : ($td < 80 ? 'warn' : ''));
                ?>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="pf-kpi">
                        <div class="top"><span class="lbl">Consommation budgétaire</span><i class="fas fa-coins"></i>
                        </div>
                        <div class="val"><?= $pct($tc) ?></div>
                        <div class="hint"><?= $fmt($snap['depense_actifs']) ?> / <?= $fmt($snap['budget_actifs']) ?> BIF
                            (chantiers actifs)</div>
                        <div class="pf-gauge"><span class="<?= $tcC ?>"
                                style="width: <?= min(100, (float) $tc) ?>%"></span></div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="pf-kpi c2">
                        <div class="top"><span class="lbl">Chantiers en retard</span><i
                                class="fas fa-hourglass-end"></i></div>
                        <div class="val"><?= $pct($tr) ?></div>
                        <div class="hint"><?= (int) $snap['chantiers_retard'] ?> sur
                            <?= (int) $snap['chantiers_actifs'] ?> chantiers actifs</div>
                        <div class="pf-gauge"><span class="<?= $trC ?>"
                                style="width: <?= min(100, (float) $tr) ?>%"></span></div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="pf-kpi c3">
                        <div class="top"><span class="lbl">Disponibilité du parc</span><i
                                class="fas fa-truck-monster"></i></div>
                        <div class="val"><?= $pct($td) ?></div>
                        <div class="hint">
                            <?= (int) $snap['engins_affectes'] ?> sur chantier · <?= (int) $snap['engins_dispo'] ?>
                            disponibles
                            · utilisation <?= $pct($snap['taux_utilisation']) ?>
                        </div>
                        <div class="pf-gauge"><span class="<?= $tdC ?>"
                                style="width: <?= min(100, (float) $td) ?>%"></span></div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="pf-kpi c4">
                        <div class="top"><span class="lbl">Effectif actif</span><i class="fas fa-users"></i></div>
                        <div class="val"><?= (int) $snap['effectif'] ?> <small>personnes</small></div>
                        <div class="hint">
                            <?= (int) $snap['effectif_chantier'] ?> chantier · <?= (int) $snap['effectif_bureau'] ?>
                            bureau
                            · <?= (int) $snap['embauches'] ?> embauche(s) en <?= (int) $annee ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ GRAPHIQUES ============ -->
            <div class="row mt-2">
                <div class="col-lg-8">
                    <div class="pf-card">
                        <div class="pf-card-head">
                            <h3><i class="fas fa-chart-line"></i> Paiements mensuels — <?= (int) $annee ?> vs
                                <?= (int) $annee - 1 ?></h3>
                        </div>
                        <div class="pf-card-body">
                            <div class="pf-chart"><canvas id="pfMonthly"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="pf-card">
                        <div class="pf-card-head">
                            <h3><i class="fas fa-tags"></i> Dépenses par catégorie</h3>
                        </div>
                        <div class="pf-card-body">
                            <?php if (empty($categories)): ?>
                            <div class="pf-empty"><i class="fas fa-tags"></i>Aucun paiement sur l'année</div>
                            <?php else: ?>
                            <div class="pf-chart"><canvas id="pfCategories"></canvas></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ RISQUE CHANTIERS + DÉCISIONS ============ -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="pf-card">
                        <div class="pf-card-head">
                            <h3><i class="fas fa-shield-alt"></i> Analyse de risque des chantiers actifs</h3>
                            <small>Budget consommé vs délai écoulé</small>
                        </div>
                        <div class="pf-card-body">
                            <?php if (empty($chantiers)): ?>
                            <div class="pf-empty"><i class="fas fa-hard-hat"></i>Aucun chantier actif</div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="pf-table">
                                    <thead>
                                        <tr>
                                            <th>Chantier</th>
                                            <th class="text-right">Budget (BIF)</th>
                                            <th>Budget / Délai</th>
                                            <th class="text-right">Écart</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($chantiers as $c):
                                                $pb = $c['pct_budget'];
                                                $pt = $c['pct_temps'];
                                                $colB = $pb === null ? '#cfd8d4' : ($pb > 100 ? '#c0392b' : ($pb >= 80 ? '#f6ad55' : '#74c476'));
                                            ?>
                                        <tr>
                                            <td>
                                                <b><?= html_escape($c['name']) ?></b><br>
                                                <small class="text-muted">
                                                    <?= html_escape($c['ref_chantier']) ?>
                                                    <?php if (!empty($c['chef_chantier'])): ?> ·
                                                    <?= html_escape($c['chef_chantier']) ?><?php endif; ?>
                                                </small>
                                            </td>
                                            <td class="text-right"><?= $fmt($c['budget']) ?></td>
                                            <td class="pf-dual">
                                                <div class="row-bar">
                                                    <span class="lab">Budget</span>
                                                    <span class="bar"><span
                                                            style="width: <?= min(100, (float) $pb) ?>%; background: <?= $colB ?>"></span></span>
                                                    <span
                                                        class="num"><?= $pb === null ? '—' : round($pb) . '%' ?></span>
                                                </div>
                                                <div class="row-bar">
                                                    <span class="lab">Délai</span>
                                                    <span class="bar"><span
                                                            style="width: <?= (float) $pt ?>%; background: #2f5d8a"></span></span>
                                                    <span
                                                        class="num"><?= $pt === null ? '—' : round($pt) . '%' ?></span>
                                                </div>
                                            </td>
                                            <td
                                                class="text-right font-weight-bold <?= ($c['ecart'] ?? 0) > 15 ? 'text-danger' : '' ?>">
                                                <?= $c['ecart'] === null ? '—' : (($c['ecart'] > 0 ? '+' : '') . number_format($c['ecart'], 1, ',', ' ') . ' pts') ?>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-<?= $risqueBadge[$c['risque']] ?> badge-pill px-2 py-1">
                                                    <?= html_escape($c['risque']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pf-legend-note mt-3">
                                <i class="fas fa-info-circle"></i>
                                <b>Écart</b> = % budget consommé − % délai écoulé. Au-delà de +15 pts, le chantier
                                dépense plus vite
                                qu'il n'avance dans le temps : risque de dépassement budgétaire.
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="pf-card">
                        <div class="pf-card-head">
                            <h3><i class="fas fa-gavel"></i> Décisions DG — <?= (int) $annee ?></h3>
                        </div>
                        <div class="pf-card-body">
                            <?php if (empty($decisions)): ?>
                            <div class="pf-empty"><i class="fas fa-gavel"></i>Aucune demande sur l'année</div>
                            <?php else: ?>
                            <div class="pf-chart sm"><canvas id="pfDecisions"></canvas></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ PARC + RH ============ -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="pf-card">
                        <div class="pf-card-head">
                            <h3><i class="fas fa-truck-monster"></i> Parc engins par état</h3>
                        </div>
                        <div class="pf-card-body">
                            <?php if (empty($engins)): ?>
                            <div class="pf-empty"><i class="fas fa-truck-monster"></i>Aucun engin enregistré</div>
                            <?php else: ?>
                            <div class="pf-chart sm"><canvas id="pfEngins"></canvas></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="pf-card">
                        <div class="pf-card-head">
                            <h3><i class="fas fa-user-tie"></i> Ressources humaines</h3>
                        </div>
                        <div class="pf-card-body">
                            <div class="pf-rh">
                                <div><span>Effectif actif</span><b><?= (int) $snap['effectif'] ?></b></div>
                                <div><span>Embauches <?= (int) $annee ?></span><b><?= (int) $snap['embauches'] ?></b>
                                </div>
                                <div><span>Personnel chantier</span><b><?= (int) $snap['effectif_chantier'] ?></b></div>
                                <div><span>Personnel bureau</span><b><?= (int) $snap['effectif_bureau'] ?></b></div>
                                <div style="grid-column: 1 / -1">
                                    <span>Masse salariale mensuelle (salaires de base)</span>
                                    <b><?= $fmt($snap['masse_salariale']) ?> BIF</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<?php
$catLabels = array_map(function ($r) use ($nice) {
    return $nice($r['cat']);
}, $categories);
$catData   = array_map(function ($r) {
    return (float) $r['total'];
}, $categories);
$decLabels = array_map(function ($r) use ($nice) {
    return $nice($r['statut']);
}, $decisions);
$decData   = array_map(function ($r) {
    return (int) $r['total'];
}, $decisions);
$engLabels = array_map(function ($r) {
    return (string) $r['etat'];
}, $engins);
$engData   = array_map(function ($r) {
    return (int) $r['total'];
}, $engins);
?>

<script>
(function() {
    var nf = new Intl.NumberFormat('fr-FR');
    var compact = new Intl.NumberFormat('fr-FR', {
        notation: 'compact'
    });
    var palette = ['#74c476', '#0f766e', '#f6ad55', '#102033', '#c0392b', '#9f7aea', '#2f5d8a', '#3f9f46'];
    var legend = {
        position: 'bottom',
        labels: {
            usePointStyle: true
        }
    };

    var el = document.getElementById('pfMonthly');
    if (el) {
        new Chart(el, {
            type: 'line',
            data: {
                labels: <?= json_encode($mois) ?>,
                datasets: [{
                    label: '<?= (int) $annee ?>',
                    data: <?= json_encode($monthly) ?>,
                    borderColor: '#0f766e',
                    backgroundColor: 'rgba(116, 196, 118, .18)',
                    fill: true,
                    tension: .35,
                    pointRadius: 3
                }, {
                    label: '<?= (int) $annee - 1 ?>',
                    data: <?= json_encode($monthlyPrev) ?>,
                    borderColor: '#9fb3ab',
                    borderDash: [6, 4],
                    fill: false,
                    tension: .35,
                    pointRadius: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: legend,
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                return c.dataset.label + ' : ' + nf.format(c.raw) + ' BIF';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#eef3f0'
                        },
                        ticks: {
                            callback: function(v) {
                                return compact.format(v);
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    el = document.getElementById('pfCategories');
    if (el) {
        new Chart(el, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($catLabels) ?>,
                datasets: [{
                    data: <?= json_encode($catData) ?>,
                    backgroundColor: palette,
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: legend,
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                return c.label + ' : ' + nf.format(c.raw) + ' BIF';
                            }
                        }
                    }
                }
            }
        });
    }

    el = document.getElementById('pfDecisions');
    if (el) {
        new Chart(el, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($decLabels) ?>,
                datasets: [{
                    data: <?= json_encode($decData) ?>,
                    backgroundColor: ['#74c476', '#f6ad55', '#c0392b', '#102033', '#9f7aea'],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: legend
                }
            }
        });
    }

    el = document.getElementById('pfEngins');
    if (el) {
        new Chart(el, {
            type: 'bar',
            data: {
                labels: <?= json_encode($engLabels) ?>,
                datasets: [{
                    label: 'Engins',
                    data: <?= json_encode($engData) ?>,
                    backgroundColor: palette,
                    borderRadius: 6,
                    maxBarThickness: 26
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: '#eef3f0'
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
})();
</script>