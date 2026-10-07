<?php
$fmt  = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$dfr  = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '—';
};
$nice = function ($s) {
    return ucfirst(str_replace('_', ' ', (string) $s));
};

$modesLabels = [
    'especes'           => 'Espèces',
    'cheque'            => 'Chèque',
    'virement_bancaire' => 'Virement bancaire',
];
$modeLabel = function ($m) use ($modesLabels, $nice) {
    return $modesLabels[$m] ?? $nice($m);
};

$presets = [
    'mois'       => 'Ce mois',
    'trimestre'  => 'Ce trimestre',
    'annee'      => 'Cette année',
    'annee_prec' => 'Année précédente',
];

$baseParams = $chantierId ? ['chantier' => $chantierId] : [];
$presetUrl  = function ($p) use ($baseParams) {
    return current_url() . '?' . http_build_query(array_merge($baseParams, ['periode' => $p]));
};
$exportUrl  = current_url() . '?' . http_build_query(array_merge($_GET, ['export' => 'csv']));

$s = $synthese;

// Totaux par chantier
$tot = ['budget' => 0, 'engage' => 0, 'paye' => 0, 'cumul' => 0, 'reste_budget' => 0];
foreach ($parChantier as $c) {
    foreach ($tot as $k => $v) $tot[$k] += (float) $c[$k];
}
$totPct = $tot['budget'] > 0 ? round($tot['cumul'] / $tot['budget'] * 100, 1) : null;

$totCat   = array_sum(array_column($categories, 'total'));
$totModes = array_sum(array_column($modes, 'total'));

$auteur = trim($this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'));
?>

<style>
.rp-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
    border: 1px solid #eef3f0;
    margin-bottom: 20px;
}

.rp-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px 8px;
    flex-wrap: wrap;
    gap: 8px;
}

.rp-card-head h3 {
    font-size: 15px;
    font-weight: 800;
    color: var(--satraco-dark);
    margin: 0;
}

.rp-card-head h3 i {
    color: var(--satraco-green-dark);
    margin-right: 6px;
}

.rp-card-body {
    padding: 8px 18px 18px;
}

/* Filtres */
.rp-filters {
    padding: 14px 18px;
}

.rp-presets {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}

.rp-presets a {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    background: var(--satraco-white-soft);
    color: var(--satraco-dark);
    border: 1px solid #e3eee7;
}

.rp-presets a:hover {
    text-decoration: none;
    border-color: var(--satraco-green);
}

.rp-presets a.active {
    background: var(--satraco-green);
    color: #fff;
    border-color: var(--satraco-green);
}

.rp-form {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 10px;
}

.rp-form label {
    font-size: 11.5px;
    font-weight: 700;
    color: #6b7f78;
    margin-bottom: 3px;
    display: block;
}

.rp-form .form-control {
    border-radius: 10px;
    border: 1px solid #d7e6dc;
    font-weight: 600;
}

.rp-form .grow {
    flex: 1;
    min-width: 200px;
}

.rp-actions {
    margin-left: auto;
    display: flex;
    gap: 8px;
}

.btn-rp {
    border-radius: 10px;
    font-weight: 700;
}

.btn-rp-green {
    background: var(--satraco-green);
    color: #fff;
    border: 0;
}

.btn-rp-green:hover {
    background: #3f9f46;
    color: #fff;
}

.btn-rp-light {
    background: var(--satraco-white-soft);
    color: var(--satraco-dark);
    border: 1px solid #e3eee7;
}

/* En-tête du rapport */
.rp-report-head {
    background: linear-gradient(135deg, #102033 0%, #173b35 55%, #0f766e 100%);
    color: #fff;
    border-radius: 16px;
    padding: 20px 22px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.rp-report-head h2 {
    font-size: 20px;
    font-weight: 800;
    margin: 0 0 4px;
}

.rp-report-head .meta {
    font-size: 13px;
    opacity: .9;
}

.rp-report-head .meta b {
    color: #b9f0bb;
}

.rp-report-head .right {
    text-align: right;
    font-size: 12px;
    opacity: .85;
}

/* Synthèse */
.rp-tiles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 12px;
}

.rp-tile {
    background: var(--satraco-white-soft);
    border-radius: 14px;
    padding: 14px 16px;
}

.rp-tile span {
    display: block;
    font-size: 12px;
    color: #6b7f78;
    font-weight: 700;
}

.rp-tile b {
    display: block;
    font-size: 20px;
    color: var(--satraco-dark);
    margin-top: 2px;
}

.rp-tile small {
    color: #8a9a94;
    font-weight: 600;
}

.rp-tile.green {
    background: #e6f5ea;
}

.rp-tile.red {
    background: #fdecea;
}

/* Tables */
.rp-table {
    width: 100%;
    font-size: 13px;
}

.rp-table th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #8a9a94;
    font-weight: 700;
    border-bottom: 1px solid #eef3f0;
    padding: 8px 6px;
    white-space: nowrap;
}

.rp-table td {
    padding: 9px 6px;
    border-bottom: 1px solid #f3f6f4;
    color: var(--satraco-dark);
    vertical-align: middle;
}

.rp-table tfoot td {
    font-weight: 800;
    border-top: 2px solid #dfeae4;
    border-bottom: 0;
    background: #fafcfb;
}

.rp-bar {
    height: 6px;
    background: #eef3f0;
    border-radius: 10px;
    overflow: hidden;
    min-width: 60px;
}

.rp-bar span {
    display: block;
    height: 100%;
    border-radius: 10px;
    background: linear-gradient(90deg, #0f766e, #74c476);
}

.rp-bar span.warn {
    background: linear-gradient(90deg, #b7791f, #f6ad55);
}

.rp-bar span.over {
    background: linear-gradient(90deg, #c0392b, #f08a7e);
}

.rp-empty {
    text-align: center;
    color: #8a9a94;
    padding: 26px 10px;
    font-size: 13px;
}

.rp-empty i {
    display: block;
    font-size: 26px;
    color: #cfe3d6;
    margin-bottom: 8px;
}

.rp-chart {
    position: relative;
    height: 260px;
}

/* Impression */
@media print {

    .main-sidebar,
    .main-header,
    .main-footer,
    .rp-no-print {
        display: none !important;
    }

    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
    }

    body {
        background: #fff !important;
    }

    .rp-card,
    .rp-report-head {
        box-shadow: none !important;
        break-inside: avoid;
    }

    .rp-card {
        border: 1px solid #dfe7e3 !important;
    }

    .rp-report-head {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .rp-tile,
    .rp-bar span {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .col-lg-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}
</style>

<div class="content-wrapper">

    <div class="content-header rp-no-print">
        <div class="container-fluid">
            <h1 class="m-0 font-weight-bold" style="color: var(--satraco-dark)">Reporting général</h1>
            <small class="text-muted">Rapport consolidé d'activité sur une période</small>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- ============ FILTRES ============ -->
            <div class="rp-card rp-filters rp-no-print">
                <div class="rp-presets">
                    <?php foreach ($presets as $code => $lib): ?>
                    <a href="<?= $presetUrl($code) ?>" class="<?= $periode === $code ? 'active' : '' ?>"><?= $lib ?></a>
                    <?php endforeach; ?>
                    <?php if ($periode === 'personnalise'): ?>
                    <a href="#" class="active" onclick="return false;">Personnalisée</a>
                    <?php endif; ?>
                </div>

                <form method="get" class="rp-form">
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
                                <?= html_escape($c['name']) ?><?= $c['ref_chantier'] ? ' — ' . html_escape($c['ref_chantier']) : '' ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-rp btn-rp-green"><i class="fas fa-filter mr-1"></i>
                            Appliquer</button>
                    </div>
                    <div class="rp-actions">
                        <button type="button" class="btn btn-sm btn-rp btn-rp-light" onclick="window.print()">
                            <i class="fas fa-print mr-1"></i> Imprimer
                        </button>
                        <a href="<?= $exportUrl ?>" class="btn btn-sm btn-rp btn-rp-light">
                            <i class="fas fa-file-csv mr-1"></i> Exporter CSV
                        </a>
                    </div>
                </form>
            </div>

            <!-- ============ EN-TÊTE DU RAPPORT ============ -->
            <div class="rp-report-head">
                <div>
                    <h2>Rapport général d'activité</h2>
                    <div class="meta">
                        Période du <b><?= $dfr($debut) ?></b> au <b><?= $dfr($fin) ?></b>
                        · <?= html_escape($chantierNom) ?>
                    </div>
                </div>
                <div class="right">
                    SATRACO Construction<br>
                    Généré le <?= date('d/m/Y à H:i') ?><?= $auteur ? '<br>par ' . html_escape($auteur) : '' ?>
                </div>
            </div>

            <!-- ============ 1. SYNTHÈSE ============ -->
            <div class="rp-card">
                <div class="rp-card-head">
                    <h3><i class="fas fa-clipboard-check"></i> 1. Synthèse de la période</h3>
                </div>
                <div class="rp-card-body">
                    <div class="rp-tiles">
                        <div class="rp-tile"><span>Montant
                                engagé</span><b><?= $fmt($s['engage']) ?></b><small>BIF</small></div>
                        <div class="rp-tile green"><span>Montant
                                payé</span><b><?= $fmt($s['paye']) ?></b><small>BIF</small></div>
                        <div class="rp-tile red"><span>Reste à
                                payer</span><b><?= $fmt($s['reste']) ?></b><small>BIF</small></div>
                        <div class="rp-tile"><span>Demandes
                                d'achat</span><b><?= (int) $s['nb_demandes'] ?></b><small>sur la période</small></div>
                        <div class="rp-tile"><span>Paiements
                                effectués</span><b><?= (int) $s['nb_paiements'] ?></b><small>bons de paiement</small>
                        </div>
                        <div class="rp-tile">
                            <span>Décisions DG</span>
                            <b><?= (int) $s['nb_approuvees'] ?> <small>validées</small></b>
                            <small><?= (int) $s['nb_rejetees'] ?> rejetées · <?= (int) $s['nb_attente'] ?> en
                                attente</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. ÉVOLUTION MENSUELLE ============ -->
            <div class="rp-card">
                <div class="rp-card-head">
                    <h3><i class="fas fa-chart-bar"></i> 2. Évolution mensuelle</h3>
                </div>
                <div class="rp-card-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="rp-chart"><canvas id="rpMensuel"></canvas></div>
                        </div>
                        <div class="col-lg-5">
                            <div class="table-responsive">
                                <table class="rp-table">
                                    <thead>
                                        <tr>
                                            <th>Mois</th>
                                            <th class="text-right">Engagé</th>
                                            <th class="text-right">Payé</th>
                                            <th class="text-right">Écart</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($mensuel as $m): $ecart = $m['engage'] - $m['paye']; ?>
                                        <tr>
                                            <td><?= html_escape($m['label']) ?></td>
                                            <td class="text-right"><?= $fmt($m['engage']) ?></td>
                                            <td class="text-right"><?= $fmt($m['paye']) ?></td>
                                            <td class="text-right <?= $ecart > 0 ? 'text-danger' : 'text-success' ?>">
                                                <?= $fmt($ecart) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-right"><?= $fmt($s['engage']) ?></td>
                                            <td class="text-right"><?= $fmt($s['paye']) ?></td>
                                            <td class="text-right"><?= $fmt($s['engage'] - $s['paye']) ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 3. SITUATION PAR CHANTIER ============ -->
            <div class="rp-card">
                <div class="rp-card-head">
                    <h3><i class="fas fa-hard-hat"></i> 3. Situation par chantier</h3>
                    <small class="text-muted">Montants en BIF · « Payé cumulé » = depuis le démarrage du
                        chantier</small>
                </div>
                <div class="rp-card-body">
                    <?php if (empty($parChantier)): ?>
                    <div class="rp-empty"><i class="fas fa-hard-hat"></i>Aucun chantier sur cette période</div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="rp-table">
                            <thead>
                                <tr>
                                    <th>Chantier</th>
                                    <th>Statut</th>
                                    <th class="text-right">Budget</th>
                                    <th class="text-right">Engagé période</th>
                                    <th class="text-right">Payé période</th>
                                    <th class="text-right">Payé cumulé</th>
                                    <th class="text-right">Reste budget</th>
                                    <th style="width: 13%">Consommé</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($parChantier as $c):
                                        $p   = $c['pct'];
                                        $cls = $p === null ? '' : ($p > 100 ? 'over' : ($p >= 80 ? 'warn' : ''));
                                    ?>
                                <tr>
                                    <td>
                                        <b><?= html_escape($c['name']) ?></b><br>
                                        <small class="text-muted"><?= html_escape($c['ref_chantier']) ?></small>
                                    </td>
                                    <td><?= html_escape($nice($c['status'])) ?></td>
                                    <td class="text-right"><?= $fmt($c['budget']) ?></td>
                                    <td class="text-right"><?= $fmt($c['engage']) ?></td>
                                    <td class="text-right"><?= $fmt($c['paye']) ?></td>
                                    <td class="text-right"><?= $fmt($c['cumul']) ?></td>
                                    <td
                                        class="text-right <?= $c['reste_budget'] < 0 ? 'text-danger font-weight-bold' : '' ?>">
                                        <?= $fmt($c['reste_budget']) ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rp-bar flex-grow-1 mr-2"><span class="<?= $cls ?>"
                                                    style="width: <?= min(100, (float) $p) ?>%"></span></div>
                                            <b style="font-size:12px"><?= $p === null ? '—' : round($p) . '%' ?></b>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">Total (<?= count($parChantier) ?> chantiers)</td>
                                    <td class="text-right"><?= $fmt($tot['budget']) ?></td>
                                    <td class="text-right"><?= $fmt($tot['engage']) ?></td>
                                    <td class="text-right"><?= $fmt($tot['paye']) ?></td>
                                    <td class="text-right"><?= $fmt($tot['cumul']) ?></td>
                                    <td class="text-right"><?= $fmt($tot['reste_budget']) ?></td>
                                    <td><?= $totPct === null ? '—' : number_format($totPct, 1, ',', ' ') . ' %' ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ============ 4. RÉPARTITIONS ============ -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="rp-card">
                        <div class="rp-card-head">
                            <h3><i class="fas fa-tags"></i> 4a. Paiements par catégorie</h3>
                        </div>
                        <div class="rp-card-body">
                            <?php if (empty($categories)): ?>
                            <div class="rp-empty"><i class="fas fa-tags"></i>Aucun paiement sur la période</div>
                            <?php else: ?>
                            <table class="rp-table">
                                <thead>
                                    <tr>
                                        <th>Catégorie</th>
                                        <th class="text-right">Nb</th>
                                        <th class="text-right">Montant</th>
                                        <th style="width:28%">Part</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $r): $part = $totCat > 0 ? $r['total'] / $totCat * 100 : 0; ?>
                                    <tr>
                                        <td><?= html_escape($nice($r['libelle'])) ?></td>
                                        <td class="text-right"><?= (int) $r['nb'] ?></td>
                                        <td class="text-right"><?= $fmt($r['total']) ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rp-bar flex-grow-1 mr-2"><span
                                                        style="width: <?= $part ?>%"></span></div>
                                                <b style="font-size:12px"><?= round($part) ?>%</b>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="rp-card">
                        <div class="rp-card-head">
                            <h3><i class="fas fa-money-check-alt"></i> 4b. Paiements par mode</h3>
                        </div>
                        <div class="rp-card-body">
                            <?php if (empty($modes)): ?>
                            <div class="rp-empty"><i class="fas fa-money-check-alt"></i>Aucun paiement sur la période
                            </div>
                            <?php else: ?>
                            <table class="rp-table">
                                <thead>
                                    <tr>
                                        <th>Mode</th>
                                        <th class="text-right">Nb</th>
                                        <th class="text-right">Montant</th>
                                        <th style="width:28%">Part</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($modes as $r): $part = $totModes > 0 ? $r['total'] / $totModes * 100 : 0; ?>
                                    <tr>
                                        <td><?= html_escape($modeLabel($r['libelle'])) ?></td>
                                        <td class="text-right"><?= (int) $r['nb'] ?></td>
                                        <td class="text-right"><?= $fmt($r['total']) ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rp-bar flex-grow-1 mr-2"><span
                                                        style="width: <?= $part ?>%"></span></div>
                                                <b style="font-size:12px"><?= round($part) ?>%</b>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 5. TOP PAIEMENTS ============ -->
            <div class="rp-card">
                <div class="rp-card-head">
                    <h3><i class="fas fa-sort-amount-down"></i> 5. Les 10 plus gros paiements de la période</h3>
                </div>
                <div class="rp-card-body">
                    <?php if (empty($topPaiements)): ?>
                    <div class="rp-empty"><i class="fas fa-receipt"></i>Aucun paiement sur la période</div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="rp-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>N° paiement</th>
                                    <th>Date</th>
                                    <th>Chantier</th>
                                    <th>Objet</th>
                                    <th>Mode</th>
                                    <th class="text-right">Montant (BIF)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topPaiements as $i => $p): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><b><?= html_escape($p['payment_number']) ?></b></td>
                                    <td style="white-space:nowrap"><?= $dfr($p['payment_date']) ?></td>
                                    <td><?= html_escape($p['chantier']) ?></td>
                                    <td><?= html_escape(mb_strimwidth((string) $p['summary'], 0, 70, '…')) ?></td>
                                    <td><?= html_escape($modeLabel($p['payment_mode'])) ?></td>
                                    <td class="text-right font-weight-bold"><?= $fmt($p['amount_paid']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
(function() {
    var el = document.getElementById('rpMensuel');
    if (!el) return;

    var nf = new Intl.NumberFormat('fr-FR');
    var compact = new Intl.NumberFormat('fr-FR', {
        notation: 'compact'
    });

    new Chart(el, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($mensuel, 'label')) ?>,
            datasets: [{
                label: 'Engagé',
                data: <?= json_encode(array_column($mensuel, 'engage')) ?>,
                backgroundColor: '#102033',
                borderRadius: 6,
                maxBarThickness: 22
            }, {
                label: 'Payé',
                data: <?= json_encode(array_column($mensuel, 'paye')) ?>,
                backgroundColor: '#74c476',
                borderRadius: 6,
                maxBarThickness: 22
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
})();
</script>