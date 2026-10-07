<?php
$fmt = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$dec = function ($n) {
    return $n === null ? '—' : number_format((float) $n, 1, ',', ' ') . ' %';
};
$dfr = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '—';
};
$nice = function ($s) {
    return $s === '' || $s === null ? '—' : ucfirst(str_replace('_', ' ', (string) $s));
};

$k = $suivi['kpi'];
$projets = $suivi['projets'];

$santeBadge = [
    'Dépassement'         => 'danger',
    'En retard'           => 'danger',
    'À surveiller'        => 'warning',
    'Conforme'            => 'success',
    'Données incomplètes' => 'secondary',
    'Hors activité'       => 'light',
    'Sans chantier'       => 'light',
];
$santeCouleur = [
    'Dépassement'         => '#c0392b',
    'En retard'           => '#e67e22',
    'À surveiller'        => '#f6ad55',
    'Conforme'            => '#74c476',
    'Données incomplètes' => '#9fb3ab',
    'Hors activité'       => '#c9d6d0',
    'Sans chantier'       => '#e3eee7',
];

$barCls = function ($p) {
    return $p === null ? '' : ($p > 100 ? 'over' : ($p >= 80 ? 'warn' : ''));
};

// Top 10 projets par budget pour le graphique
$top = array_values(array_filter($projets, function ($p) {
    return $p['id'] !== 0 && $p['budget'] > 0;
}));
usort($top, function ($a, $b) {
    return $b['budget'] <=> $a['budget'];
});
$top = array_slice($top, 0, 10);

$colsManquantes = [];
if ($suivi['table_ok']) {
    foreach (['name' => 'nom du projet', 'budget' => 'budget', 'status' => 'statut'] as $c => $l) {
        if (!isset($suivi['colonnes'][$c])) $colsManquantes[] = $l;
    }
}
?>

<style>
.pj-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
    border: 1px solid #eef3f0;
    margin-bottom: 20px;
}

.pj-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px 8px;
    flex-wrap: wrap;
    gap: 8px;
}

.pj-card-head h3 {
    font-size: 15px;
    font-weight: 800;
    color: var(--satraco-dark);
    margin: 0;
}

.pj-card-head h3 i {
    color: var(--satraco-green-dark);
    margin-right: 6px;
}

.pj-card-body {
    padding: 8px 18px 18px;
}

.pj-chart {
    position: relative;
    height: 280px;
}

.pj-filters {
    padding: 14px 18px;
}

.pj-form {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 10px;
}

.pj-form label {
    font-size: 11.5px;
    font-weight: 700;
    color: #6b7f78;
    margin-bottom: 3px;
    display: block;
}

.pj-form .form-control {
    border-radius: 10px;
    border: 1px solid #d7e6dc;
    font-weight: 600;
}

.pj-form .grow {
    flex: 1;
    min-width: 220px;
}

.btn-pj {
    border-radius: 10px;
    font-weight: 700;
}

.btn-pj-green {
    background: var(--satraco-green);
    color: #fff;
    border: 0;
}

.btn-pj-green:hover {
    background: #3f9f46;
    color: #fff;
}

.btn-pj-light {
    background: var(--satraco-white-soft);
    color: var(--satraco-dark);
    border: 1px solid #e3eee7;
}

.pj-tiles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(175px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.pj-tile {
    background: #fff;
    border-radius: 16px;
    padding: 16px;
    border: 1px solid #eef3f0;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
}

.pj-tile span {
    display: block;
    font-size: 12px;
    color: #6b7f78;
    font-weight: 700;
}

.pj-tile b {
    display: block;
    font-size: 22px;
    color: var(--satraco-dark);
    margin-top: 2px;
    line-height: 1.15;
}

.pj-tile b small {
    font-size: 12px;
    color: #8a9a94;
}

.pj-tile .hint {
    font-size: 11.5px;
    color: #8a9a94;
    margin-top: 4px;
}

.pj-tile.dark {
    background: linear-gradient(135deg, #102033, #0f766e);
    border: 0;
}

.pj-tile.dark span,
.pj-tile.dark .hint,
.pj-tile.dark b small {
    color: rgba(255, 255, 255, .8);
}

.pj-tile.dark b {
    color: #fff;
}

.pj-tile.alert b {
    color: #c0392b;
}

/* Carte projet */
.pj-project {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #eef3f0;
    margin-bottom: 12px;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .05);
    overflow: hidden;
    border-left: 5px solid #c9d6d0;
}

.pj-top {
    display: grid;
    grid-template-columns: minmax(220px, 2.2fr) repeat(4, minmax(120px, 1fr)) 36px;
    gap: 14px;
    align-items: center;
    padding: 14px 16px;
    cursor: pointer;
}

.pj-top:hover {
    background: #fafcfb;
}

.pj-name b {
    font-size: 14.5px;
    color: var(--satraco-dark);
    display: block;
}

.pj-name small {
    color: #8a9a94;
}

.pj-name .badge {
    font-size: 11px;
    margin-top: 4px;
}

.pj-metric span {
    display: block;
    font-size: 11px;
    color: #8a9a94;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
}

.pj-metric b {
    font-size: 13.5px;
    color: var(--satraco-dark);
}

.pj-chevron {
    color: #9fb3ab;
    transition: transform .2s ease;
    text-align: center;
}

.pj-top[aria-expanded="true"] .pj-chevron {
    transform: rotate(180deg);
}

.pj-dual .row-bar {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #6b7f78;
}

.pj-dual .row-bar+.row-bar {
    margin-top: 4px;
}

.pj-dual .lab {
    width: 42px;
}

.pj-dual .bar {
    flex: 1;
    height: 6px;
    background: #eef3f0;
    border-radius: 10px;
    overflow: hidden;
}

.pj-dual .bar span {
    display: block;
    height: 100%;
    border-radius: 10px;
    background: linear-gradient(90deg, #0f766e, #74c476);
}

.pj-dual .bar span.warn {
    background: linear-gradient(90deg, #b7791f, #f6ad55);
}

.pj-dual .bar span.over {
    background: linear-gradient(90deg, #c0392b, #f08a7e);
}

.pj-dual .bar span.time {
    background: #2f5d8a;
}

.pj-dual .num {
    width: 40px;
    text-align: right;
    font-weight: 700;
    color: var(--satraco-dark);
}

.pj-body {
    border-top: 1px solid #eef3f0;
    background: #fbfdfc;
    padding: 12px 16px 16px;
}

.pj-table {
    width: 100%;
    font-size: 12.5px;
}

.pj-table th {
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #8a9a94;
    font-weight: 700;
    border-bottom: 1px solid #e6eeea;
    padding: 7px 6px;
    white-space: nowrap;
}

.pj-table td {
    padding: 8px 6px;
    border-bottom: 1px solid #eef3f0;
    color: var(--satraco-dark);
    vertical-align: middle;
}

.pj-table tr:last-child td {
    border-bottom: 0;
}

.pj-empty {
    text-align: center;
    color: #8a9a94;
    padding: 30px 10px;
    font-size: 13px;
}

.pj-empty i {
    display: block;
    font-size: 28px;
    color: #cfe3d6;
    margin-bottom: 8px;
}

.pj-warn {
    font-size: 12.5px;
    background: #fff4e5;
    color: #8a5a12;
    border-radius: 10px;
    padding: 10px 14px;
    margin-bottom: 16px;
}

@media (max-width: 991.98px) {
    .pj-top {
        grid-template-columns: 1fr 1fr;
    }

    .pj-name {
        grid-column: 1 / -1;
    }

    .pj-chevron {
        display: none;
    }
}

@media print {

    .main-sidebar,
    .main-header,
    .main-footer,
    .pj-no-print {
        display: none !important;
    }

    .content-wrapper {
        margin: 0 !important;
        background: #fff !important;
    }

    .pj-body.collapse {
        display: block !important;
    }

    .pj-project,
    .pj-card {
        box-shadow: none !important;
        break-inside: avoid;
    }
}
</style>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 font-weight-bold" style="color: var(--satraco-dark)">Suivi des projets</h1>
            <small class="text-muted">Portefeuille de projets et santé de leurs chantiers — situation au
                <?= date('d/m/Y') ?></small>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <?php if (!$suivi['table_ok']): ?>
            <div class="pj-warn"><i class="fas fa-exclamation-triangle mr-1"></i> La table des projets est introuvable :
                seuls les chantiers sont affichés.</div>
            <?php elseif ($colsManquantes): ?>
            <div class="pj-warn pj-no-print">
                <i class="fas fa-info-circle mr-1"></i>
                Colonne(s) non détectée(s) dans la table <code>projects</code> : <?= implode(', ', $colsManquantes) ?>.
                Les valeurs sont calculées à partir des chantiers.
            </div>
            <?php endif; ?>

            <!-- ============ FILTRES ============ -->
            <div class="pj-card pj-filters pj-no-print">
                <form method="get" class="pj-form">
                    <div class="grow">
                        <label>Rechercher</label>
                        <input type="search" name="q" class="form-control form-control-sm"
                            value="<?= html_escape($filtres['q']) ?>" placeholder="Projet, code, client ou chantier…">
                    </div>
                    <div>
                        <label>Projets</label>
                        <select name="statut" class="form-control form-control-sm">
                            <option value="actifs" <?= $filtres['statut'] === 'actifs' ? 'selected' : '' ?>>En activité
                            </option>
                            <option value="tous" <?= $filtres['statut'] === 'tous' ? 'selected' : '' ?>>Tous</option>
                        </select>
                    </div>
                    <div>
                        <label>Santé</label>
                        <select name="sante" class="form-control form-control-sm">
                            <option value="">Toutes</option>
                            <?php foreach (array_keys($santeBadge) as $s): ?>
                            <option value="<?= html_escape($s) ?>" <?= $filtres['sante'] === $s ? 'selected' : '' ?>>
                                <?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Trier par</label>
                        <select name="tri" class="form-control form-control-sm">
                            <option value="sante" <?= $filtres['tri'] === 'sante' ? 'selected' : '' ?>>Plus critique
                                d'abord</option>
                            <option value="budget" <?= $filtres['tri'] === 'budget' ? 'selected' : '' ?>>Budget
                                décroissant</option>
                            <option value="fin" <?= $filtres['tri'] === 'fin' ? 'selected' : '' ?>>Échéance la plus
                                proche</option>
                            <option value="nom" <?= $filtres['tri'] === 'nom' ? 'selected' : '' ?>>Nom (A → Z)</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-pj btn-pj-green"><i class="fas fa-filter mr-1"></i>
                            Filtrer</button>
                    </div>
                    <div class="ml-auto d-flex" style="gap:8px">
                        <button type="button" class="btn btn-sm btn-pj btn-pj-light" id="pjToggleAll"><i
                                class="fas fa-expand-alt mr-1"></i> Tout déplier</button>
                        <button type="button" class="btn btn-sm btn-pj btn-pj-light" onclick="window.print()"><i
                                class="fas fa-print mr-1"></i> Imprimer</button>
                    </div>
                </form>
            </div>

            <!-- ============ INDICATEURS DU PORTEFEUILLE ============ -->
            <div class="pj-tiles">
                <div class="pj-tile dark">
                    <span>Projets</span>
                    <b><?= (int) $k['nb_projets'] ?></b>
                    <div class="hint"><?= (int) $k['nb_chantiers'] ?> chantiers · <?= (int) $k['nb_actifs'] ?> actifs
                    </div>
                </div>
                <div class="pj-tile">
                    <span>Budget du portefeuille</span>
                    <b><?= $fmt($k['budget']) ?> <small>BIF</small></b>
                    <div class="hint">Payé : <?= $fmt($k['depense']) ?> BIF</div>
                </div>
                <div class="pj-tile">
                    <span>Budget consommé</span>
                    <b><?= $dec($k['pct']) ?></b>
                    <div class="hint">Sur l'ensemble des projets affichés</div>
                </div>
                <div class="pj-tile <?= $k['nb_risque'] > 0 ? 'alert' : '' ?>">
                    <span>Projets à risque</span>
                    <b><?= (int) $k['nb_risque'] ?></b>
                    <div class="hint">Dépassement, retard ou à surveiller</div>
                </div>
                <div class="pj-tile <?= $k['nb_retard'] > 0 ? 'alert' : '' ?>">
                    <span>Chantiers en retard</span>
                    <b><?= (int) $k['nb_retard'] ?></b>
                    <div class="hint">Date de fin dépassée</div>
                </div>
                <div class="pj-tile">
                    <span>Demandes à valider</span>
                    <b><?= (int) $k['attente'] ?></b>
                    <div class="hint"><a href="<?= base_url('direction/validations') ?>">Aller aux validations →</a>
                    </div>
                </div>
            </div>

            <?php if (empty($projets)): ?>
            <div class="pj-card">
                <div class="pj-empty"><i class="fas fa-folder-open"></i>Aucun projet ne correspond à ces critères.</div>
            </div>
            <?php else: ?>

            <!-- ============ GRAPHIQUES ============ -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <h3><i class="fas fa-chart-bar"></i> Budget et payé — 10 plus gros projets</h3>
                        </div>
                        <div class="pj-card-body">
                            <?php if (empty($top)): ?>
                            <div class="pj-empty"><i class="fas fa-chart-bar"></i>Aucun budget renseigné</div>
                            <?php else: ?>
                            <div class="pj-chart"><canvas id="pjBudget"></canvas></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <h3><i class="fas fa-heartbeat"></i> Santé des projets</h3>
                        </div>
                        <div class="pj-card-body">
                            <?php if (empty($suivi['sante'])): ?>
                            <div class="pj-empty"><i class="fas fa-heartbeat"></i>Aucune donnée</div>
                            <?php else: ?>
                            <div class="pj-chart"><canvas id="pjSante"></canvas></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ LISTE DES PROJETS ============ -->
            <?php foreach ($projets as $p):
                    $cid = 'pj-' . $p['id'];
                ?>
            <div class="pj-project" style="border-left-color: <?= $santeCouleur[$p['sante']] ?>">
                <div class="pj-top" data-toggle="collapse" data-target="#<?= $cid ?>" aria-expanded="false"
                    role="button">
                    <div class="pj-name">
                        <b><?= html_escape($p['name']) ?></b>
                        <small>
                            <?= $p['code'] ? html_escape($p['code']) : '' ?>
                            <?= $p['client'] ? ($p['code'] ? ' · ' : '') . '<i class="fas fa-user-tie"></i> ' . html_escape($p['client']) : '' ?>
                            <?= $p['status'] ? ' · ' . html_escape($nice($p['status'])) : '' ?>
                        </small><br>
                        <span class="badge badge-<?= $santeBadge[$p['sante']] ?>"><?= $p['sante'] ?></span>
                        <?php if ($p['attente'] > 0): ?>
                        <span class="badge badge-info"><?= (int) $p['attente'] ?> demande(s) à valider</span>
                        <?php endif; ?>
                    </div>
                    <div class="pj-metric">
                        <span>Chantiers</span>
                        <b><?= (int) $p['nb_actifs'] ?> actif(s) / <?= (int) $p['nb_chantiers'] ?></b>
                        <?php if ($p['nb_retard'] > 0): ?><br><small
                            class="text-danger font-weight-bold"><?= (int) $p['nb_retard'] ?> en
                            retard</small><?php endif; ?>
                    </div>
                    <div class="pj-metric">
                        <span>Budget</span>
                        <b><?= $fmt($p['budget']) ?></b><br>
                        <small class="text-muted">Payé <?= $fmt($p['depense']) ?></small>
                    </div>
                    <div class="pj-metric pj-dual">
                        <span>Budget / Délai</span>
                        <div class="row-bar">
                            <span class="lab">Budget</span>
                            <span class="bar"><span class="<?= $barCls($p['pct_budget']) ?>"
                                    style="width: <?= min(100, (float) $p['pct_budget']) ?>%"></span></span>
                            <span
                                class="num"><?= $p['pct_budget'] === null ? '—' : round($p['pct_budget']) . '%' ?></span>
                        </div>
                        <div class="row-bar">
                            <span class="lab">Délai</span>
                            <span class="bar"><span class="time"
                                    style="width: <?= (float) $p['pct_temps'] ?>%"></span></span>
                            <span
                                class="num"><?= $p['pct_temps'] === null ? '—' : round($p['pct_temps']) . '%' ?></span>
                        </div>
                    </div>
                    <div class="pj-metric">
                        <span>Période</span>
                        <b><?= $dfr($p['debut']) ?></b><br>
                        <small
                            class="<?= $p['fin'] && $p['fin'] < date('Y-m-d') && $p['actif'] ? 'text-danger font-weight-bold' : 'text-muted' ?>">
                            → <?= $dfr($p['fin']) ?>
                        </small>
                    </div>
                    <div class="pj-chevron"><i class="fas fa-chevron-down"></i></div>
                </div>

                <div class="collapse pj-body" id="<?= $cid ?>">
                    <?php if (empty($p['chantiers'])): ?>
                    <div class="pj-empty"><i class="fas fa-hard-hat"></i>Aucun chantier rattaché à ce projet.</div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="pj-table">
                            <thead>
                                <tr>
                                    <th>Chantier</th>
                                    <th>Chef</th>
                                    <th>Statut</th>
                                    <th class="text-right">Budget</th>
                                    <th class="text-right">Engagé</th>
                                    <th class="text-right">Payé</th>
                                    <th class="text-right">Budget %</th>
                                    <th class="text-right">Délai %</th>
                                    <th class="text-right">Fin prévue</th>
                                    <th>Santé</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($p['chantiers'] as $c): ?>
                                <tr>
                                    <td>
                                        <b><?= html_escape($c['name']) ?></b><br>
                                        <small class="text-muted">
                                            <?= html_escape($c['ref_chantier']) ?>
                                            <?= $c['location'] ? ' · ' . html_escape($c['location']) : '' ?>
                                        </small>
                                        <?php if ($c['attente'] > 0): ?>
                                        <br><span class="badge badge-info"><?= (int) $c['attente'] ?> à valider</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= html_escape($c['chef_chantier']) ?></td>
                                    <td><?= html_escape($nice($c['status'])) ?></td>
                                    <td class="text-right"><?= $fmt($c['budget']) ?></td>
                                    <td class="text-right"><?= $fmt($c['engage']) ?></td>
                                    <td class="text-right"><?= $fmt($c['depense']) ?></td>
                                    <td
                                        class="text-right font-weight-bold <?= ($c['pct_budget'] ?? 0) > 100 ? 'text-danger' : '' ?>">
                                        <?= $c['pct_budget'] === null ? '—' : round($c['pct_budget']) . '%' ?>
                                    </td>
                                    <td class="text-right">
                                        <?= $c['pct_temps'] === null ? '—' : round($c['pct_temps']) . '%' ?></td>
                                    <td class="text-right <?= $c['en_retard'] ? 'text-danger font-weight-bold' : '' ?>"
                                        style="white-space:nowrap">
                                        <?= $dfr($c['date_fin_prevue']) ?>
                                    </td>
                                    <td><span
                                            class="badge badge-<?= $santeBadge[$c['sante']] ?>"><?= $c['sante'] ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="pj-card pj-no-print" style="padding: 12px 16px; font-size: 12.5px; color: #6b7f78">
                <i class="fas fa-info-circle"></i>
                La <b>santé d'un projet</b> est celle de son chantier le plus critique.
                Un chantier est <b>« À surveiller »</b> quand son budget consommé dépasse de plus de 15 points son délai
                écoulé.
                Le budget d'un projet est celui de la fiche projet s'il est renseigné, sinon la somme des budgets de ses
                chantiers.
            </div>

            <?php endif; ?>

        </div>
    </section>
</div>

<?php if (!empty($projets)): ?>
<script>
(function() {
    // Tout déplier / replier
    var btn = document.getElementById('pjToggleAll');
    var ouvert = false;
    if (btn && window.jQuery) {
        btn.addEventListener('click', function() {
            ouvert = !ouvert;
            jQuery('.pj-body').collapse(ouvert ? 'show' : 'hide');
            btn.innerHTML = ouvert ?
                '<i class="fas fa-compress-alt mr-1"></i> Tout replier' :
                '<i class="fas fa-expand-alt mr-1"></i> Tout déplier';
        });
    }

    if (typeof Chart === 'undefined') return;
    var nf = new Intl.NumberFormat('fr-FR');
    var compact = new Intl.NumberFormat('fr-FR', {
        notation: 'compact'
    });

    var b = document.getElementById('pjBudget');
    if (b) {
        new Chart(b, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_map(function ($p) {
                                    return mb_strimwidth($p['name'], 0, 28, '…');
                                }, $top)) ?>,
                datasets: [{
                    label: 'Budget',
                    data: <?= json_encode(array_column($top, 'budget')) ?>,
                    backgroundColor: '#dfeae4',
                    borderRadius: 6,
                    maxBarThickness: 18
                }, {
                    label: 'Payé',
                    data: <?= json_encode(array_column($top, 'depense')) ?>,
                    backgroundColor: '#0f766e',
                    borderRadius: 6,
                    maxBarThickness: 18
                }]
            },
            options: {
                indexAxis: 'y',
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
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    var s = document.getElementById('pjSante');
    if (s) {
        new Chart(s, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode(array_keys($suivi['sante'])) ?>,
                datasets: [{
                    data: <?= json_encode(array_values($suivi['sante'])) ?>,
                    backgroundColor: <?= json_encode(array_map(function ($l) use ($santeCouleur) {
                                                    return $santeCouleur[$l];
                                                }, array_keys($suivi['sante']))) ?>,
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }
})();
</script>
<?php endif; ?>