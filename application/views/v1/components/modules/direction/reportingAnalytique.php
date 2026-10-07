<?php
$fmt  = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$dec  = function ($n, $d = 1) {
    return number_format((float) $n, $d, ',', ' ');
};
$dfr  = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '—';
};
$nice = function ($s) {
    return ucfirst(str_replace('_', ' ', (string) $s));
};

$modesLabels = ['especes' => 'Espèces', 'cheque' => 'Chèque', 'virement_bancaire' => 'Virement bancaire'];

/** Libellé affichable selon la dimension */
$lib = function ($dimension, $v) use ($nice, $modesLabels) {
    if ($v === 'Autres') return 'Autres';
    if ($dimension === 'categorie') return $nice($v);
    if ($dimension === 'mode') return $modesLabels[$v] ?? $nice($v);
    return (string) $v;
};

$presets = [
    'mois'       => 'Ce mois',
    'trimestre'  => 'Ce trimestre',
    'annee'      => 'Cette année',
    'annee_prec' => 'Année précédente',
];

$keep = array_filter(['chantier' => $chantierId, 'dim' => $dim, 'mesure' => $mesure]);
$presetUrl = function ($p) use ($keep) {
    return current_url() . '?' . http_build_query(array_merge($keep, ['periode' => $p]));
};
$drillUrl = function ($chantier) use ($periode, $debut, $fin, $mesure) {
    return current_url() . '?' . http_build_query([
        'periode'  => $periode,
        'du'       => $debut,
        'au'       => $fin,
        'chantier' => $chantier,
        'dim'      => 'categorie',
        'mesure'   => $mesure,
    ]);
};

$lignes      = $analyse['lignes'];
$total       = $analyse['total'];
$mesureLabel = $mesure === 'engage' ? 'Montant engagé' : 'Montant payé';
$dimLabel    = $dimensions[$dim];
$colLabel    = $dimensions[$colDim];

// Concentration
$nbElements = count($lignes);
$top1       = $lignes[0] ?? null;
$top3Part   = array_sum(array_column(array_slice($lignes, 0, 3), 'part'));

// Pareto (15 premiers)
$pareto       = array_slice($lignes, 0, 15);
$paretoLabels = array_map(function ($r) use ($lib, $dim) {
    return mb_strimwidth($lib($dim, $r['libelle']), 0, 22, '…');
}, $pareto);

$classeBadge = ['A' => 'success', 'B' => 'warning', 'C' => 'secondary'];
?>

<style>
.an-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
    border: 1px solid #eef3f0;
    margin-bottom: 20px;
}

.an-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px 8px;
    flex-wrap: wrap;
    gap: 8px;
}

.an-card-head h3 {
    font-size: 15px;
    font-weight: 800;
    color: var(--satraco-dark);
    margin: 0;
}

.an-card-head h3 i {
    color: var(--satraco-green-dark);
    margin-right: 6px;
}

.an-card-head small {
    color: #8a9a94;
}

.an-card-body {
    padding: 8px 18px 18px;
}

/* Filtres */
.an-filters {
    padding: 14px 18px;
}

.an-presets {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}

.an-presets a {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    background: var(--satraco-white-soft);
    color: var(--satraco-dark);
    border: 1px solid #e3eee7;
}

.an-presets a:hover {
    text-decoration: none;
    border-color: var(--satraco-green);
}

.an-presets a.active {
    background: var(--satraco-green);
    color: #fff;
    border-color: var(--satraco-green);
}

.an-form {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 10px;
}

.an-form label {
    font-size: 11.5px;
    font-weight: 700;
    color: #6b7f78;
    margin-bottom: 3px;
    display: block;
}

.an-form .form-control {
    border-radius: 10px;
    border: 1px solid #d7e6dc;
    font-weight: 600;
}

.an-form .grow {
    flex: 1;
    min-width: 180px;
}

.an-toggle {
    display: inline-flex;
    background: var(--satraco-white-soft);
    border: 1px solid #e3eee7;
    border-radius: 10px;
    padding: 3px;
}

.an-toggle label {
    margin: 0;
}

.an-toggle input {
    display: none;
}

.an-toggle span {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    color: #6b7f78;
    cursor: pointer;
}

.an-toggle input:checked+span {
    background: var(--satraco-green);
    color: #fff;
}

.an-toggle input:disabled+span {
    opacity: .4;
    cursor: not-allowed;
}

.btn-an {
    border-radius: 10px;
    font-weight: 700;
}

.btn-an-green {
    background: var(--satraco-green);
    color: #fff;
    border: 0;
}

.btn-an-green:hover {
    background: #3f9f46;
    color: #fff;
}

.btn-an-light {
    background: var(--satraco-white-soft);
    color: var(--satraco-dark);
    border: 1px solid #e3eee7;
}

/* Contexte */
.an-context {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
    font-size: 13px;
    color: #6b7f78;
    margin-bottom: 14px;
}

.an-chip {
    background: #fff;
    border: 1px solid #e3eee7;
    border-radius: 20px;
    padding: 4px 12px;
    font-weight: 700;
    color: var(--satraco-dark);
}

.an-chip i {
    color: var(--satraco-green-dark);
    margin-right: 4px;
}

/* Concentration */
.an-tiles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.an-tile {
    background: #fff;
    border-radius: 16px;
    padding: 16px;
    border: 1px solid #eef3f0;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
}

.an-tile span {
    display: block;
    font-size: 12px;
    color: #6b7f78;
    font-weight: 700;
}

.an-tile b {
    display: block;
    font-size: 22px;
    color: var(--satraco-dark);
    margin-top: 2px;
    line-height: 1.15;
}

.an-tile small {
    color: #8a9a94;
    font-weight: 600;
    display: block;
    margin-top: 3px;
}

.an-tile.highlight {
    background: linear-gradient(135deg, #102033, #0f766e);
    border: 0;
}

.an-tile.highlight span,
.an-tile.highlight small {
    color: rgba(255, 255, 255, .8);
}

.an-tile.highlight b {
    color: #fff;
}

/* Tableau */
.an-table {
    width: 100%;
    font-size: 13px;
}

.an-table th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #8a9a94;
    font-weight: 700;
    border-bottom: 1px solid #eef3f0;
    padding: 8px 6px;
    white-space: nowrap;
}

.an-table td {
    padding: 9px 6px;
    border-bottom: 1px solid #f3f6f4;
    color: var(--satraco-dark);
    vertical-align: middle;
}

.an-table tfoot td {
    font-weight: 800;
    border-top: 2px solid #dfeae4;
    border-bottom: 0;
    background: #fafcfb;
}

.an-table a.drill {
    color: var(--satraco-dark);
    font-weight: 700;
}

.an-table a.drill:hover {
    color: var(--satraco-green-dark);
}

.an-table a.drill i {
    font-size: 10px;
    color: var(--satraco-green-dark);
    margin-left: 4px;
}

.an-bar {
    height: 6px;
    background: #eef3f0;
    border-radius: 10px;
    overflow: hidden;
    min-width: 60px;
}

.an-bar span {
    display: block;
    height: 100%;
    border-radius: 10px;
    background: linear-gradient(90deg, #0f766e, #74c476);
}

/* Heatmap */
.an-heat {
    width: 100%;
    font-size: 12.5px;
    border-collapse: separate;
    border-spacing: 3px;
}

.an-heat th {
    font-size: 11px;
    font-weight: 700;
    color: #6b7f78;
    padding: 6px;
    text-align: center;
    white-space: nowrap;
}

.an-heat th.rowh {
    text-align: left;
    color: var(--satraco-dark);
    font-size: 12.5px;
    max-width: 220px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.an-heat td {
    text-align: right;
    padding: 8px;
    border-radius: 6px;
    white-space: nowrap;
    font-weight: 600;
}

.an-heat td.tot {
    background: #f3f8f5;
    font-weight: 800;
    color: var(--satraco-dark);
}

.an-empty {
    text-align: center;
    color: #8a9a94;
    padding: 30px 10px;
    font-size: 13px;
}

.an-empty i {
    display: block;
    font-size: 28px;
    color: #cfe3d6;
    margin-bottom: 8px;
}

.an-chart {
    position: relative;
    height: 300px;
}

@media print {

    .main-sidebar,
    .main-header,
    .main-footer,
    .an-no-print {
        display: none !important;
    }

    .content-wrapper {
        margin: 0 !important;
        background: #fff !important;
    }

    .an-card,
    .an-tile {
        box-shadow: none !important;
        break-inside: avoid;
    }

    .an-heat td,
    .an-tile.highlight,
    .an-bar span {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 font-weight-bold" style="color: var(--satraco-dark)">Analytique</h1>
            <small class="text-muted">Où va l'argent, et qui ou quoi le concentre</small>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- ============ FILTRES ============ -->
            <div class="an-card an-filters an-no-print">
                <div class="an-presets">
                    <?php foreach ($presets as $code => $l): ?>
                    <a href="<?= $presetUrl($code) ?>" class="<?= $periode === $code ? 'active' : '' ?>"><?= $l ?></a>
                    <?php endforeach; ?>
                    <?php if ($periode === 'personnalise'): ?>
                    <a href="#" class="active" onclick="return false;">Personnalisée</a>
                    <?php endif; ?>
                </div>

                <form method="get" class="an-form">
                    <input type="hidden" name="periode" value="personnalise">
                    <div>
                        <label>Du</label>
                        <input type="date" name="du" class="form-control form-control-sm"
                            value="<?= html_escape($debut) ?>" required>
                    </div>
                    <div>
                        <label>Au</label>
                        <input type="date" name="au" class="form-control form-control-sm"
                            value="<?= html_escape($fin) ?>" required>
                    </div>
                    <div class="grow">
                        <label>Chantier</label>
                        <select name="chantier" class="form-control form-control-sm">
                            <option value="">Tous les chantiers</option>
                            <?php foreach ($listeChantiers as $c): ?>
                            <option value="<?= (int) $c['id'] ?>"
                                <?= (int) $c['id'] === $chantierId ? 'selected' : '' ?>>
                                <?= html_escape($c['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Analyser par</label>
                        <select name="dim" id="anDim" class="form-control form-control-sm">
                            <?php foreach ($dimensions as $code => $l): ?>
                            <option value="<?= $code ?>" <?= $dim === $code ? 'selected' : '' ?>><?= $l ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Mesure</label>
                        <div class="an-toggle">
                            <label><input type="radio" name="mesure" value="paye"
                                    <?= $mesure === 'paye' ? 'checked' : '' ?>><span>Payé</span></label>
                            <label><input type="radio" name="mesure" value="engage" id="anEngage"
                                    <?= $mesure === 'engage' ? 'checked' : '' ?>
                                    <?= $dim === 'mode' ? 'disabled' : '' ?>><span>Engagé</span></label>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-an btn-an-green"><i
                                class="fas fa-search-dollar mr-1"></i> Analyser</button>
                    </div>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-sm btn-an btn-an-light" onclick="window.print()"><i
                                class="fas fa-print mr-1"></i> Imprimer</button>
                    </div>
                </form>
            </div>

            <!-- ============ CONTEXTE ============ -->
            <div class="an-context">
                <span class="an-chip"><i class="far fa-calendar-alt"></i><?= $dfr($debut) ?> → <?= $dfr($fin) ?></span>
                <span class="an-chip"><i class="fas fa-hard-hat"></i><?= html_escape($chantierNom) ?></span>
                <span class="an-chip"><i class="fas fa-layer-group"></i>Par <?= mb_strtolower($dimLabel) ?></span>
                <span class="an-chip"><i class="fas fa-coins"></i><?= $mesureLabel ?></span>
                <?php if ($chantierId): ?>
                <a class="an-chip an-no-print"
                    href="<?= current_url() . '?' . http_build_query(['periode' => $periode, 'du' => $debut, 'au' => $fin, 'dim' => 'chantier', 'mesure' => $mesure]) ?>">
                    <i class="fas fa-times"></i>Retirer le filtre chantier
                </a>
                <?php endif; ?>
            </div>

            <?php if (empty($lignes)): ?>
            <div class="an-card">
                <div class="an-empty"><i class="fas fa-search"></i>Aucune donnée pour ces critères.<br>Essayez une autre
                    période ou une autre mesure.</div>
            </div>
            <?php else: ?>

            <!-- ============ 1. CONCENTRATION ============ -->
            <div class="an-tiles">
                <div class="an-tile highlight">
                    <span><?= $mesureLabel ?></span>
                    <b><?= $fmt($total) ?> <small style="display:inline">BIF</small></b>
                    <small><?= (int) $analyse['nb_operations'] ?> opérations</small>
                </div>
                <div class="an-tile">
                    <span>Éléments analysés</span>
                    <b><?= $nbElements ?></b>
                    <small><?= mb_strtolower($dimLabel) ?>(s) distinct(s)</small>
                </div>
                <div class="an-tile">
                    <span>N° 1</span>
                    <b><?= $dec($top1['part']) ?> %</b>
                    <small><?= html_escape(mb_strimwidth($lib($dim, $top1['libelle']), 0, 40, '…')) ?></small>
                </div>
                <div class="an-tile">
                    <span>Top 3</span>
                    <b><?= $dec($top3Part) ?> %</b>
                    <small>du total</small>
                </div>
                <div class="an-tile">
                    <span>Règle des 80 %</span>
                    <b><?= (int) $analyse['nb_80'] ?> / <?= $nbElements ?></b>
                    <small>élément(s) font 80 % du total</small>
                </div>
            </div>

            <!-- ============ 2. PARETO ============ -->
            <div class="an-card">
                <div class="an-card-head">
                    <h3><i class="fas fa-chart-bar"></i> Diagramme de Pareto — par <?= mb_strtolower($dimLabel) ?></h3>
                    <small><?= count($pareto) < $nbElements ? count($pareto) . ' premiers sur ' . $nbElements : '' ?></small>
                </div>
                <div class="an-card-body">
                    <div class="an-chart"><canvas id="anPareto"></canvas></div>
                </div>
            </div>

            <!-- ============ 3. TABLEAU D'ANALYSE ============ -->
            <div class="an-card">
                <div class="an-card-head">
                    <h3><i class="fas fa-list-ol"></i> Classement détaillé</h3>
                    <small>
                        <span class="badge badge-success">A</span> 80 % du total ·
                        <span class="badge badge-warning">B</span> 15 % suivants ·
                        <span class="badge badge-secondary">C</span> reste
                        <?php if ($dim === 'chantier'): ?> · Cliquez sur un chantier pour le détailler<?php endif; ?>
                    </small>
                </div>
                <div class="an-card-body">
                    <div class="table-responsive">
                        <table class="an-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?= $dimLabel ?></th>
                                    <th class="text-right">Opérations</th>
                                    <th class="text-right">Montant (BIF)</th>
                                    <th class="text-right">Moyenne</th>
                                    <?php if ($mesure === 'paye'): ?><th class="text-right">Délai moy.</th>
                                    <?php endif; ?>
                                    <th style="width: 16%">Part</th>
                                    <th class="text-right">Cumul</th>
                                    <th class="text-center">Classe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lignes as $i => $r): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td>
                                        <?php if ($dim === 'chantier' && !empty($r['dim_id']) && !$chantierId): ?>
                                        <a class="drill" href="<?= $drillUrl($r['dim_id']) ?>">
                                            <?= html_escape($lib($dim, $r['libelle'])) ?><i
                                                class="fas fa-search-plus"></i>
                                        </a>
                                        <?php else: ?>
                                        <b><?= html_escape($lib($dim, $r['libelle'])) ?></b>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right"><?= $r['nb'] ?></td>
                                    <td class="text-right font-weight-bold"><?= $fmt($r['total']) ?></td>
                                    <td class="text-right"><?= $fmt($r['moyenne']) ?></td>
                                    <?php if ($mesure === 'paye'): ?>
                                    <td class="text-right"><?= $r['delai'] === null ? '—' : $dec($r['delai']) . ' j' ?>
                                    </td>
                                    <?php endif; ?>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="an-bar flex-grow-1 mr-2"><span
                                                    style="width: <?= $r['part'] ?>%"></span></div>
                                            <b style="font-size:12px"><?= $dec($r['part']) ?>%</b>
                                        </div>
                                    </td>
                                    <td class="text-right"><?= $dec($r['cumul']) ?> %</td>
                                    <td class="text-center"><span
                                            class="badge badge-<?= $classeBadge[$r['classe']] ?>"><?= $r['classe'] ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td class="text-right"><?= (int) $analyse['nb_operations'] ?></td>
                                    <td class="text-right"><?= $fmt($total) ?></td>
                                    <td class="text-right">
                                        <?= $analyse['nb_operations'] > 0 ? $fmt($total / $analyse['nb_operations']) : '—' ?>
                                    </td>
                                    <?php if ($mesure === 'paye'): ?><td></td><?php endif; ?>
                                    <td>100 %</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ============ 4. MATRICE CROISÉE ============ -->
            <div class="an-card">
                <div class="an-card-head">
                    <h3><i class="fas fa-th"></i> Matrice croisée — <?= $dimLabel ?> × <?= $colLabel ?></h3>
                    <small>Plus la case est foncée, plus le montant est élevé</small>
                </div>
                <div class="an-card-body">
                    <?php if (empty($matrice['rows'])): ?>
                    <div class="an-empty"><i class="fas fa-th"></i>Aucune donnée</div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="an-heat">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php foreach ($matrice['cols'] as $col): ?>
                                    <th><?= html_escape(mb_strimwidth($lib($colDim, $col), 0, 20, '…')) ?></th>
                                    <?php endforeach; ?>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($matrice['rows'] as $row): ?>
                                <tr>
                                    <th class="rowh" title="<?= html_escape($lib($dim, $row)) ?>">
                                        <?= html_escape(mb_strimwidth($lib($dim, $row), 0, 32, '…')) ?>
                                    </th>
                                    <?php foreach ($matrice['cols'] as $col):
                                                    $v = $matrice['cells'][$row][$col] ?? 0;
                                                    $alpha = $matrice['max'] > 0 && $v > 0 ? 0.08 + 0.77 * ($v / $matrice['max']) : 0;
                                                    $bg = $v > 0 ? "rgba(15, 118, 110, " . round($alpha, 3) . ")" : '#fafcfb';
                                                    $fg = $alpha > 0.45 ? '#fff' : 'var(--satraco-dark)';
                                                ?>
                                    <td style="background: <?= $bg ?>; color: <?= $fg ?>"
                                        title="<?= html_escape($lib($dim, $row) . ' × ' . $lib($colDim, $col)) ?>">
                                        <?= $v > 0 ? $fmt($v) : '·' ?>
                                    </td>
                                    <?php endforeach; ?>
                                    <td class="tot"><?= $fmt($matrice['rowTotals'][$row] ?? 0) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <th class="rowh">Total</th>
                                    <?php foreach ($matrice['cols'] as $col): ?>
                                    <td class="tot"><?= $fmt($matrice['colTotals'][$col] ?? 0) ?></td>
                                    <?php endforeach; ?>
                                    <td class="tot"><?= $fmt($matrice['total']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ============ 5. TENDANCE TOP 5 ============ -->
            <div class="an-card">
                <div class="an-card-head">
                    <h3><i class="fas fa-chart-area"></i> Évolution mensuelle des 5 premiers</h3>
                </div>
                <div class="an-card-body">
                    <?php if (empty($tendance['series'])): ?>
                    <div class="an-empty"><i class="fas fa-chart-area"></i>Aucune donnée</div>
                    <?php else: ?>
                    <div class="an-chart"><canvas id="anTendance"></canvas></div>
                    <?php endif; ?>
                </div>
            </div>

            <?php endif; ?>

        </div>
    </section>
</div>

<?php
$tendSeries = [];
foreach ($tendance['series'] as $name => $values) {
    $tendSeries[] = ['label' => $lib($dim, $name), 'data' => $values];
}
?>

<script>
(function() {
    // Mode de paiement => mesure "Payé" obligatoire
    var dimSel = document.getElementById('anDim');
    var engage = document.getElementById('anEngage');
    if (dimSel && engage) {
        dimSel.addEventListener('change', function() {
            var isMode = this.value === 'mode';
            engage.disabled = isMode;
            if (isMode) document.querySelector('input[name="mesure"][value="paye"]').checked = true;
        });
    }

    if (typeof Chart === 'undefined') return;

    var nf = new Intl.NumberFormat('fr-FR');
    var compact = new Intl.NumberFormat('fr-FR', {
        notation: 'compact'
    });
    var palette = ['#0f766e', '#74c476', '#f6ad55', '#2f5d8a', '#9f7aea', '#c9d6d0'];

    var p = document.getElementById('anPareto');
    if (p) {
        new Chart(p, {
            data: {
                labels: <?= json_encode($paretoLabels) ?>,
                datasets: [{
                    type: 'line',
                    label: 'Cumul %',
                    data: <?= json_encode(array_map(function ($r) {
                                    return round($r['cumul'], 1);
                                }, $pareto)) ?>,
                    borderColor: '#f6ad55',
                    backgroundColor: '#f6ad55',
                    yAxisID: 'y1',
                    tension: .3,
                    pointRadius: 3
                }, {
                    type: 'bar',
                    label: '<?= $mesureLabel ?>',
                    data: <?= json_encode(array_column($pareto, 'total')) ?>,
                    backgroundColor: <?= json_encode(array_map(function ($r) {
                                                return $r['classe'] === 'A' ? '#0f766e' : ($r['classe'] === 'B' ? '#74c476' : '#c9d6d0');
                                            }, $pareto)) ?>,
                    borderRadius: 6,
                    maxBarThickness: 34,
                    yAxisID: 'y'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                return c.dataset.yAxisID === 'y1' ?
                                    'Cumul : ' + c.raw + ' %' :
                                    c.dataset.label + ' : ' + nf.format(c.raw) + ' BIF';
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
                    y1: {
                        position: 'right',
                        min: 0,
                        max: 100,
                        grid: {
                            display: false
                        },
                        ticks: {
                            callback: function(v) {
                                return v + ' %';
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

    var t = document.getElementById('anTendance');
    if (t) {
        var series = <?= json_encode($tendSeries) ?>;
        new Chart(t, {
            type: 'bar',
            data: {
                labels: <?= json_encode($tendance['labels']) ?>,
                datasets: series.map(function(s, i) {
                    return {
                        label: s.label,
                        data: s.data,
                        backgroundColor: palette[i % palette.length],
                        borderRadius: 4,
                        maxBarThickness: 36
                    };
                })
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                return c.dataset.label + ' : ' + nf.format(c.raw) + ' BIF';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        grid: {
                            color: '#eef3f0'
                        },
                        ticks: {
                            callback: function(v) {
                                return compact.format(v);
                            }
                        }
                    }
                }
            }
        });
    }
})();
</script>