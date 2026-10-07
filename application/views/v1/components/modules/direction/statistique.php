<?php
$fmt = function ($n) {
    return $n === null ? '—' : number_format((float) $n, 0, ',', ' ');
};
$dec = function ($n, $d = 1) {
    return $n === null ? '—' : number_format((float) $n, $d, ',', ' ');
};
$sgn = function ($n) use ($dec) {
    return $n === null ? '—' : (($n > 0 ? '+' : '') . $dec($n) . ' %');
};
$clsEvo = function ($n) {
    return $n === null ? 'neutral' : ($n >= 0 ? 'up' : 'down');
};

$mois   = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
$curY   = (int) date('Y');
$s      = $stats;
$mesureLabel = $mesure === 'engage' ? 'Montant engagé' : 'Montant payé';
$vide   = $s['total_general'] <= 0;

$keep = array_filter(['chantier' => $chantierId, 'mesure' => $mesure, 'annees' => $nbAnnees]);

// Données graphiques
$labelsAnnees = array_map('strval', $s['annees']);
$realise      = [];
$reste        = [];
$couleurs     = [];
foreach ($s['annees'] as $y) {
    $realise[]  = $s['annuel'][$y]['total'];
    $reste[]    = ($y === $curY && $s['projection']) ? max(0, $s['projection'] - $s['annuel'][$y]['total']) : 0;
    $couleurs[] = $y === $curY ? '#102033' : '#74c476';
}

$palette = ['#c9d6d0', '#9fb3ab', '#f6ad55', '#9f7aea', '#2f5d8a', '#74c476', '#0f766e'];
$lignesMois = [];
$k = count($s['annees']);
foreach ($s['annees'] as $i => $y) {
    $data = array_values($s['mensuel'][$y]);
    if ($y === $curY) {
        $data = array_map(function ($v, $idx) {
            return $idx < (int) date('n') ? $v : null;
        }, $data, array_keys($data));
    }
    $lignesMois[] = [
        'label'       => (string) $y,
        'data'        => $data,
        'borderColor' => $y === $curY ? '#0f766e' : $palette[($k - 1 - $i) % count($palette)],
        'borderWidth' => $y === $curY ? 3 : 1.5,
        'pointRadius' => $y === $curY ? 3 : 0,
        'tension'     => .3,
        'spanGaps'    => false,
    ];
}

$indices = array_values($s['saison']['indices']);
$moisForts  = [];
$moisCreux  = [];
foreach ($indices as $i => $v) {
    if ($v === null) continue;
    if ($v >= 115) $moisForts[] = $mois[$i];
    if ($v <= 85)  $moisCreux[] = $mois[$i];
}

$descRows = [
    ['Nombre d\'opérations', 'n',          'int'],
    ['Montant total',         'total',      'bif'],
    ['Montant moyen',         'moyenne',    'bif'],
    ['Montant médian',        'mediane',    'bif'],
    ['Plus petit montant',    'min',        'bif'],
    ['Plus gros montant',     'max',        'bif'],
    ['Écart-type',            'ecart_type', 'bif'],
    ['Coefficient de variation', 'cv',      'pct'],
];
$fmtDesc = function ($v, $type) use ($fmt, $dec) {
    if ($v === null) return '—';
    if ($type === 'int') return (int) $v;
    if ($type === 'pct') return $dec($v) . ' %';
    return $fmt($v);
};
?>

<style>
.st-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
    border: 1px solid #eef3f0;
    margin-bottom: 20px;
    height: calc(100% - 20px);
    display: flex;
    flex-direction: column;
}

.st-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px 8px;
    flex-wrap: wrap;
    gap: 8px;
}

.st-card-head h3 {
    font-size: 15px;
    font-weight: 800;
    color: var(--satraco-dark);
    margin: 0;
}

.st-card-head h3 i {
    color: var(--satraco-green-dark);
    margin-right: 6px;
}

.st-card-head small {
    color: #8a9a94;
}

.st-card-body {
    padding: 8px 18px 18px;
    flex: 1;
}

.st-chart {
    position: relative;
    height: 290px;
}

.st-chart.sm {
    height: 240px;
}

.st-filters {
    padding: 14px 18px;
    height: auto;
}

.st-form {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 12px;
}

.st-form label.t {
    font-size: 11.5px;
    font-weight: 700;
    color: #6b7f78;
    margin-bottom: 3px;
    display: block;
}

.st-form .form-control {
    border-radius: 10px;
    border: 1px solid #d7e6dc;
    font-weight: 600;
}

.st-form .grow {
    flex: 1;
    min-width: 200px;
}

.st-seg {
    display: inline-flex;
    background: var(--satraco-white-soft);
    border: 1px solid #e3eee7;
    border-radius: 10px;
    padding: 3px;
}

.st-seg label {
    margin: 0;
}

.st-seg input {
    display: none;
}

.st-seg span {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    color: #6b7f78;
    cursor: pointer;
}

.st-seg input:checked+span {
    background: var(--satraco-green);
    color: #fff;
}

.btn-st {
    border-radius: 10px;
    font-weight: 700;
}

.btn-st-green {
    background: var(--satraco-green);
    color: #fff;
    border: 0;
}

.btn-st-green:hover {
    background: #3f9f46;
    color: #fff;
}

.btn-st-light {
    background: var(--satraco-white-soft);
    color: var(--satraco-dark);
    border: 1px solid #e3eee7;
}

.st-tiles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(185px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.st-tile {
    background: #fff;
    border-radius: 16px;
    padding: 16px;
    border: 1px solid #eef3f0;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
}

.st-tile span {
    display: block;
    font-size: 12px;
    color: #6b7f78;
    font-weight: 700;
}

.st-tile b {
    display: block;
    font-size: 21px;
    color: var(--satraco-dark);
    margin-top: 2px;
    line-height: 1.15;
}

.st-tile b small {
    font-size: 12px;
    color: #8a9a94;
}

.st-tile .hint {
    font-size: 11.5px;
    color: #8a9a94;
    margin-top: 4px;
}

.st-tile.dark {
    background: linear-gradient(135deg, #102033, #0f766e);
    border: 0;
}

.st-tile.dark span,
.st-tile.dark .hint,
.st-tile.dark b small {
    color: rgba(255, 255, 255, .8);
}

.st-tile.dark b {
    color: #fff;
}

.st-evo {
    display: inline-block;
    font-size: 11.5px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
}

.st-evo.up {
    background: #e6f5ea;
    color: #1f7a3a;
}

.st-evo.down {
    background: #fdecea;
    color: #c0392b;
}

.st-evo.neutral {
    background: #f1f4f3;
    color: #6b7f78;
}

.st-table {
    width: 100%;
    font-size: 13px;
}

.st-table th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #8a9a94;
    font-weight: 700;
    border-bottom: 1px solid #eef3f0;
    padding: 8px 6px;
    white-space: nowrap;
}

.st-table td {
    padding: 9px 6px;
    border-bottom: 1px solid #f3f6f4;
    color: var(--satraco-dark);
    vertical-align: middle;
}

.st-table tr.current td {
    background: #f3f8f5;
    font-weight: 700;
}

.st-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 10px;
    font-size: 12.5px;
    color: #6b7f78;
    align-items: center;
}

.st-pill {
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 12px;
}

.st-pill.fort {
    background: #e6f5ea;
    color: #1f7a3a;
}

.st-pill.creux {
    background: #fff4e5;
    color: #b7791f;
}

.st-note {
    font-size: 12px;
    color: #6b7f78;
    background: var(--satraco-white-soft);
    border-radius: 10px;
    padding: 10px 12px;
    margin-top: 12px;
}

.st-empty {
    text-align: center;
    color: #8a9a94;
    padding: 40px 10px;
    font-size: 13px;
}

.st-empty i {
    display: block;
    font-size: 30px;
    color: #cfe3d6;
    margin-bottom: 8px;
}

@media print {

    .main-sidebar,
    .main-header,
    .main-footer,
    .st-no-print {
        display: none !important;
    }

    .content-wrapper {
        margin: 0 !important;
        background: #fff !important;
    }

    .st-card,
    .st-tile {
        box-shadow: none !important;
        break-inside: avoid;
    }

    .st-tile.dark {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 font-weight-bold" style="color: var(--satraco-dark)">Statistiques</h1>
            <small class="text-muted">
                Tendances <?= $anneeDebut ?>–<?= $anneeFin ?> · <?= $mesureLabel ?> · <?= html_escape($chantierNom) ?>
            </small>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- ============ FILTRES ============ -->
            <div class="st-card st-filters st-no-print">
                <form method="get" class="st-form">
                    <div>
                        <label class="t">Historique</label>
                        <div class="st-seg">
                            <?php foreach ([3, 5, 7] as $n): ?>
                            <label><input type="radio" name="annees" value="<?= $n ?>"
                                    <?= $nbAnnees === $n ? 'checked' : '' ?>><span><?= $n ?> ans</span></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div>
                        <label class="t">Mesure</label>
                        <div class="st-seg">
                            <label><input type="radio" name="mesure" value="paye"
                                    <?= $mesure === 'paye' ? 'checked' : '' ?>><span>Payé</span></label>
                            <label><input type="radio" name="mesure" value="engage"
                                    <?= $mesure === 'engage' ? 'checked' : '' ?>><span>Engagé</span></label>
                        </div>
                    </div>
                    <div class="grow">
                        <label class="t">Chantier</label>
                        <select name="chantier" class="form-control form-control-sm">
                            <option value="">Tous les chantiers</option>
                            <?php foreach ($listeChantiers as $c): ?>
                            <option value="<?= (int) $c['id'] ?>"
                                <?= (int) $c['id'] === $chantierId ? 'selected' : '' ?>><?= html_escape($c['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-st btn-st-green"><i
                                class="fas fa-sync-alt mr-1"></i> Actualiser</button>
                    </div>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-sm btn-st btn-st-light" onclick="window.print()"><i
                                class="fas fa-print mr-1"></i> Imprimer</button>
                    </div>
                </form>
            </div>

            <?php if ($vide): ?>
            <div class="st-card">
                <div class="st-empty"><i class="fas fa-chart-line"></i>Aucune donnée sur
                    <?= $anneeDebut ?>–<?= $anneeFin ?> pour ces critères.</div>
            </div>
            <?php else: ?>

            <!-- ============ 1. CHIFFRES CLÉS ============ -->
            <div class="st-tiles">
                <div class="st-tile dark">
                    <span>Cumul <?= $curY ?> au <?= date('d/m') ?></span>
                    <b><?= $fmt($s['ytd']) ?> <small>BIF</small></b>
                    <div class="hint"><?= $mesureLabel ?></div>
                </div>
                <div class="st-tile">
                    <span>vs même période <?= $curY - 1 ?></span>
                    <b><?= $sgn($s['ytd_croissance']) ?></b>
                    <div class="hint"><?= $curY - 1 ?> à date : <?= $fmt($s['ytd_prev']) ?> BIF</div>
                </div>
                <div class="st-tile">
                    <span>Projection fin <?= $curY ?></span>
                    <b><?= $fmt($s['projection']) ?> <small>BIF</small></b>
                    <div class="hint">
                        <?= $s['methode'] ? 'Méthode ' . html_escape($s['methode']) : 'Pas assez de données' ?></div>
                </div>
                <div class="st-tile">
                    <span>Croissance annuelle moyenne</span>
                    <b><?= $sgn($s['tcam']) ?></b>
                    <div class="hint">
                        <?= count($s['pleines']) >= 2 ? 'TCAM ' . $s['pleines'][0] . '–' . end($s['pleines']) : 'Il faut au moins 2 années terminées' ?>
                    </div>
                </div>
                <div class="st-tile">
                    <span>Meilleure année</span>
                    <b><?= $s['meilleure'] ?? '—' ?></b>
                    <div class="hint">
                        <?= $s['meilleure'] ? $fmt($s['annuel'][$s['meilleure']]['total']) . ' BIF' : 'Aucune année terminée' ?>
                    </div>
                </div>
                <div class="st-tile">
                    <span>Moyenne mensuelle <?= $curY ?></span>
                    <b><?= $fmt($s['moyenne_mensuelle']) ?> <small>BIF</small></b>
                    <div class="hint">Sur les mois écoulés</div>
                </div>
            </div>

            <!-- ============ 2. ÉVOLUTION ANNUELLE ============ -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="st-card">
                        <div class="st-card-head">
                            <h3><i class="fas fa-chart-bar"></i> Évolution annuelle</h3>
                            <small><?= $curY ?> : réalisé + reste projeté</small>
                        </div>
                        <div class="st-card-body">
                            <div class="st-chart"><canvas id="stAnnuel"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="st-card">
                        <div class="st-card-head">
                            <h3><i class="fas fa-table"></i> Détail par année</h3>
                        </div>
                        <div class="st-card-body">
                            <div class="table-responsive">
                                <table class="st-table">
                                    <thead>
                                        <tr>
                                            <th>Année</th>
                                            <th class="text-right">Montant</th>
                                            <th class="text-right">Opér.</th>
                                            <th class="text-right">Croissance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_reverse($s['annees']) as $y): $a = $s['annuel'][$y]; ?>
                                        <tr class="<?= $y === $curY ? 'current' : '' ?>">
                                            <td><?= $y ?><?= $y === $curY ? ' <small class="text-muted">(en cours)</small>' : '' ?>
                                            </td>
                                            <td class="text-right"><?= $fmt($a['total']) ?></td>
                                            <td class="text-right"><?= (int) $a['nb'] ?></td>
                                            <td class="text-right">
                                                <?php if ($y === $curY): ?>
                                                <span class="st-evo <?= $clsEvo($s['ytd_croissance']) ?>"
                                                    title="vs même période N-1"><?= $sgn($s['ytd_croissance']) ?>*</span>
                                                <?php else: ?>
                                                <span
                                                    class="st-evo <?= $clsEvo($a['croissance']) ?>"><?= $sgn($a['croissance']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="st-note">* Année en cours comparée à la même période de <?= $curY - 1 ?>, pour
                                une comparaison équitable.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 3. MENSUEL MULTI-ANNÉES + 4. CUMUL ============ -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="st-card">
                        <div class="st-card-head">
                            <h3><i class="fas fa-chart-line"></i> Comparaison mensuelle par année</h3>
                        </div>
                        <div class="st-card-body">
                            <div class="st-chart"><canvas id="stMensuel"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="st-card">
                        <div class="st-card-head">
                            <h3><i class="fas fa-chart-area"></i> Cumul annuel : en avance ou en retard ?</h3>
                        </div>
                        <div class="st-card-body">
                            <div class="st-chart"><canvas id="stCumul"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 5. SAISONNALITÉ ============ -->
            <div class="st-card" style="height:auto">
                <div class="st-card-head">
                    <h3><i class="fas fa-calendar-alt"></i> Saisonnalité</h3>
                    <small>Indice 100 = mois moyen · calculé sur <?= count($s['pleines']) ?> année(s)
                        terminée(s)</small>
                </div>
                <div class="st-card-body">
                    <?php if (empty($s['pleines'])): ?>
                    <div class="st-empty"><i class="fas fa-calendar-alt"></i>Il faut au moins une année complète
                        d'historique pour mesurer la saisonnalité.</div>
                    <?php else: ?>
                    <div class="st-chart sm"><canvas id="stSaison"></canvas></div>
                    <div class="st-pills">
                        <?php if ($moisForts): ?>
                        <b>Mois forts :</b>
                        <?php foreach ($moisForts as $m): ?><span
                            class="st-pill fort"><?= $m ?></span><?php endforeach; ?>
                        <?php endif; ?>
                        <?php if ($moisCreux): ?>
                        <b class="ml-2">Mois creux :</b>
                        <?php foreach ($moisCreux as $m): ?><span
                            class="st-pill creux"><?= $m ?></span><?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (!$moisForts && !$moisCreux): ?>
                        <span>Activité régulière, sans mois nettement plus fort ou plus creux.</span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ============ 6. STATISTIQUES DESCRIPTIVES ============ -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="st-card">
                        <div class="st-card-head">
                            <h3><i class="fas fa-calculator"></i> Statistiques des opérations</h3>
                        </div>
                        <div class="st-card-body">
                            <table class="st-table">
                                <thead>
                                    <tr>
                                        <th>Indicateur</th>
                                        <th class="text-right"><?= $curY - 1 ?></th>
                                        <th class="text-right"><?= $curY ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($descRows as [$label, $key, $type]): ?>
                                    <tr>
                                        <td><?= $label ?></td>
                                        <td class="text-right"><?= $fmtDesc($descPrev[$key], $type) ?></td>
                                        <td class="text-right font-weight-bold"><?= $fmtDesc($descN[$key], $type) ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="st-note">
                                Si la <b>moyenne</b> est bien au-dessus de la <b>médiane</b>, quelques grosses
                                opérations tirent le total vers le haut.
                                Un <b>coefficient de variation</b> élevé (au-delà de 100 %) signale des montants très
                                hétérogènes.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="st-card">
                        <div class="st-card-head">
                            <h3><i class="fas fa-layer-group"></i> Répartition par tranche de montant (BIF)</h3>
                        </div>
                        <div class="st-card-body">
                            <div class="st-chart"><canvas id="stTranches"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php endif; ?>

            <!-- ============ 7. ACTIVITÉ PAR ANNÉE ============ -->
            <div class="st-card" style="height:auto">
                <div class="st-card-head">
                    <h3><i class="fas fa-building"></i> Activité de l'entreprise par année</h3>
                    <small>Toute l'entreprise, indépendamment du filtre chantier</small>
                </div>
                <div class="st-card-body">
                    <div class="table-responsive">
                        <table class="st-table">
                            <thead>
                                <tr>
                                    <th>Année</th>
                                    <th class="text-right">Demandes d'achat</th>
                                    <th class="text-right">Paiements effectués</th>
                                    <th class="text-right">Chantiers démarrés</th>
                                    <th class="text-right">Embauches</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_reverse(array_keys($activite)) as $y): $a = $activite[$y]; ?>
                                <tr class="<?= $y === $curY ? 'current' : '' ?>">
                                    <td><?= $y ?><?= $y === $curY ? ' <small class="text-muted">(en cours)</small>' : '' ?>
                                    </td>
                                    <td class="text-right"><?= $a['demandes'] ?></td>
                                    <td class="text-right"><?= $a['paiements'] ?></td>
                                    <td class="text-right"><?= $a['chantiers'] ?></td>
                                    <td class="text-right"><?= $a['embauches'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<?php if (!$vide): ?>
<script>
(function() {
    if (typeof Chart === 'undefined') return;

    var nf = new Intl.NumberFormat('fr-FR');
    var compact = new Intl.NumberFormat('fr-FR', {
        notation: 'compact'
    });
    var mois = <?= json_encode($mois) ?>;
    var legend = {
        position: 'bottom',
        labels: {
            usePointStyle: true
        }
    };
    var yMoney = {
        beginAtZero: true,
        grid: {
            color: '#eef3f0'
        },
        ticks: {
            callback: function(v) {
                return compact.format(v);
            }
        }
    };
    var tipMoney = {
        callbacks: {
            label: function(c) {
                return c.dataset.label + ' : ' + (c.raw === null ? '—' : nf.format(c.raw) + ' BIF');
            }
        }
    };

    // 2. Évolution annuelle
    new Chart(document.getElementById('stAnnuel'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($labelsAnnees) ?>,
            datasets: [{
                label: 'Réalisé',
                data: <?= json_encode($realise) ?>,
                backgroundColor: <?= json_encode($couleurs) ?>,
                borderRadius: 6,
                maxBarThickness: 48
            }, {
                label: 'Reste projeté',
                data: <?= json_encode($reste) ?>,
                backgroundColor: 'rgba(16, 32, 51, .15)',
                borderColor: '#102033',
                borderWidth: 1,
                borderDash: [4, 3],
                borderRadius: 6,
                maxBarThickness: 48
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: legend,
                tooltip: tipMoney
            },
            scales: {
                x: {
                    stacked: true,
                    grid: {
                        display: false
                    }
                },
                y: Object.assign({
                    stacked: true
                }, yMoney)
            }
        }
    });

    // 3. Comparaison mensuelle
    new Chart(document.getElementById('stMensuel'), {
        type: 'line',
        data: {
            labels: mois,
            datasets: <?= json_encode($lignesMois) ?>
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: legend,
                tooltip: tipMoney
            },
            scales: {
                y: yMoney,
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // 4. Cumul
    new Chart(document.getElementById('stCumul'), {
        type: 'line',
        data: {
            labels: mois,
            datasets: [{
                label: '<?= $curY ?>',
                data: <?= json_encode($s['cumul']['n']) ?>,
                borderColor: '#0f766e',
                backgroundColor: 'rgba(116, 196, 118, .18)',
                fill: true,
                borderWidth: 3,
                tension: .3,
                pointRadius: 2
            }, {
                label: '<?= $curY - 1 ?>',
                data: <?= json_encode($s['cumul']['prev']) ?>,
                borderColor: '#9fb3ab',
                borderDash: [6, 4],
                fill: false,
                tension: .3,
                pointRadius: 0
            }, {
                label: 'Moyenne historique',
                data: <?= json_encode($s['cumul']['moyenne']) ?>,
                borderColor: '#f6ad55',
                fill: false,
                tension: .3,
                pointRadius: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: legend,
                tooltip: tipMoney
            },
            scales: {
                y: yMoney,
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // 5. Saisonnalité
    var saison = document.getElementById('stSaison');
    if (saison) {
        var idx = <?= json_encode($indices) ?>;
        new Chart(saison, {
            data: {
                labels: mois,
                datasets: [{
                    type: 'line',
                    label: 'Mois moyen (100)',
                    data: mois.map(function() {
                        return 100;
                    }),
                    borderColor: '#102033',
                    borderDash: [5, 4],
                    borderWidth: 1.5,
                    pointRadius: 0,
                    fill: false
                }, {
                    type: 'bar',
                    label: 'Indice saisonnier',
                    data: idx,
                    backgroundColor: idx.map(function(v) {
                        return v >= 115 ? '#0f766e' : (v <= 85 ? '#f6ad55' : '#74c476');
                    }),
                    borderRadius: 6,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: legend
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#eef3f0'
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

    // 6. Tranches
    new Chart(document.getElementById('stTranches'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($descN['tranches'], 'label')) ?>,
            datasets: [{
                label: '<?= $curY - 1 ?>',
                data: <?= json_encode(array_column($descPrev['tranches'], 'nb')) ?>,
                backgroundColor: '#c9d6d0',
                borderRadius: 6,
                maxBarThickness: 30
            }, {
                label: '<?= $curY ?>',
                data: <?= json_encode(array_column($descN['tranches'], 'nb')) ?>,
                backgroundColor: '#0f766e',
                borderRadius: 6,
                maxBarThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: legend,
                tooltip: {
                    callbacks: {
                        label: function(c) {
                            return c.dataset.label + ' : ' + c.raw + ' opération(s)';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: '#eef3f0'
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
})();
</script>
<?php endif; ?>