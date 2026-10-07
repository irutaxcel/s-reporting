<?php
$fmt = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};

$mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

$totalEngage = array_sum($monthly['engagements']);
$totalPaye   = array_sum($monthly['paiements']);
$resteAPayer = max(0, $totalEngage - $totalPaye);
?>

<style>
.dg-toolbar {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
}

.dg-toolbar select.form-control {
    width: 130px !important;
    flex: 0 0 130px;
    border-radius: 10px;
    border: 1px solid #d7e6dc;
    font-weight: 700;
    color: var(--satraco-dark);
}

.dg-kpi {
    background: #fff;
    border-radius: 16px;
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
    border: 1px solid #eef3f0;
    height: 100%;
    transition: transform .2s ease, box-shadow .2s ease;
}

.dg-kpi:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(16, 32, 51, .10);
}

.dg-kpi .ico {
    width: 50px;
    height: 50px;
    min-width: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #fff;
}

.dg-kpi .lbl {
    font-size: 12.5px;
    color: #6b7f78;
    font-weight: 600;
    margin-bottom: 2px;
}

.dg-kpi .val {
    font-size: 21px;
    font-weight: 800;
    color: var(--satraco-dark);
    line-height: 1.1;
    word-break: break-word;
}

.dg-kpi .val small {
    font-size: 12px;
    font-weight: 700;
    color: #8a9a94;
}

.dg-kpi .sub {
    font-size: 11px;
    color: #8a9a94;
    margin-top: 3px;
}

.bg-g1 {
    background: linear-gradient(135deg, #0f766e, #74c476);
}

.bg-g2 {
    background: linear-gradient(135deg, #102033, #2f5d8a);
}

.bg-g3 {
    background: linear-gradient(135deg, #b7791f, #f6ad55);
}

.bg-g4 {
    background: linear-gradient(135deg, #173b35, #3f9f46);
}

.bg-g5 {
    background: linear-gradient(135deg, #c0392b, #f08a7e);
}

.bg-g6 {
    background: linear-gradient(135deg, #5b3f8c, #9f7aea);
}

.dg-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
    border: 1px solid #eef3f0;
    margin-bottom: 20px;
    height: calc(100% - 20px);
    display: flex;
    flex-direction: column;
}

.dg-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px 10px;
}

.dg-card-head h3 {
    font-size: 15px;
    font-weight: 800;
    color: var(--satraco-dark);
    margin: 0;
}

.dg-card-head h3 i {
    color: var(--satraco-green-dark);
    margin-right: 6px;
}

.dg-card-head a {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--satraco-green-dark);
    white-space: nowrap;
}

.dg-card-body {
    padding: 6px 18px 18px;
    flex: 1;
}

.dg-mini-stats {
    display: flex;
    gap: 22px;
    flex-wrap: wrap;
    margin-bottom: 10px;
    font-size: 12.5px;
    color: #6b7f78;
}

.dg-mini-stats b {
    display: block;
    font-size: 15px;
    color: var(--satraco-dark);
}

.dg-table {
    width: 100%;
    font-size: 13px;
}

.dg-table th {
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #8a9a94;
    font-weight: 700;
    border-bottom: 1px solid #eef3f0;
    padding: 8px 6px;
    white-space: nowrap;
}

.dg-table td {
    padding: 10px 6px;
    border-bottom: 1px solid #f3f6f4;
    vertical-align: middle;
    color: var(--satraco-dark);
}

.dg-table tr:last-child td {
    border-bottom: 0;
}

.dg-progress {
    height: 8px;
    background: #eef3f0;
    border-radius: 10px;
    overflow: hidden;
    min-width: 80px;
}

.dg-progress span {
    display: block;
    height: 100%;
    border-radius: 10px;
    background: linear-gradient(90deg, #0f766e, #74c476);
}

.dg-progress span.warn {
    background: linear-gradient(90deg, #b7791f, #f6ad55);
}

.dg-progress span.over {
    background: linear-gradient(90deg, #c0392b, #f08a7e);
}

.dg-list-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 6px;
    margin: 0 -6px;
    border-bottom: 1px solid #f3f6f4;
    color: var(--satraco-dark);
    border-radius: 10px;
}

.dg-list-item:last-child {
    border-bottom: 0;
}

.dg-list-item:hover {
    color: var(--satraco-dark);
    text-decoration: none;
    background: #fafcfb;
}

.dg-list-item .dot {
    width: 38px;
    height: 38px;
    min-width: 38px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dg-list-item .main {
    flex: 1;
    min-width: 0;
}

.dg-list-item .main b {
    display: block;
    font-size: 13px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dg-list-item .main small {
    color: #8a9a94;
}

.dg-empty {
    text-align: center;
    color: #8a9a94;
    padding: 26px 10px;
    font-size: 13px;
}

.dg-empty i {
    display: block;
    font-size: 28px;
    color: #cfe3d6;
    margin-bottom: 8px;
}

.dg-quick {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 12px;
}

.dg-quick a {
    background: var(--satraco-white-soft);
    border-radius: 14px;
    padding: 16px 10px;
    text-align: center;
    color: var(--satraco-dark);
    font-weight: 700;
    font-size: 13px;
    border: 1px solid transparent;
    transition: all .2s ease;
}

.dg-quick a i {
    display: block;
    font-size: 20px;
    color: var(--satraco-green-dark);
    margin-bottom: 8px;
}

.dg-quick a:hover {
    border-color: var(--satraco-green);
    background: #fff;
    text-decoration: none;
    transform: translateY(-2px);
}

.chart-box {
    position: relative;
    height: 280px;
}
</style>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold" style="color: var(--satraco-dark)">Direction Générale</h1>
                    <small class="text-muted">Vue d'ensemble de l'activité — exercice <?= (int) $annee ?></small>
                </div>
                <div class="col-sm-6 mt-2 mt-sm-0">
                    <form method="get" class="dg-toolbar">
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

            <!-- ================= KPI ================= -->
            <div class="row">
                <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
                    <div class="dg-kpi">
                        <div class="ico bg-g1"><i class="fas fa-hard-hat"></i></div>
                        <div>
                            <div class="lbl">Chantiers actifs</div>
                            <div class="val"><?= (int) $kpi['chantiers_actifs'] ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
                    <div class="dg-kpi">
                        <div class="ico bg-g2"><i class="fas fa-project-diagram"></i></div>
                        <div>
                            <div class="lbl">Projets</div>
                            <div class="val"><?= (int) $kpi['projets'] ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
                    <div class="dg-kpi">
                        <div class="ico bg-g4"><i class="fas fa-money-check-alt"></i></div>
                        <div>
                            <div class="lbl">Paiements <?= (int) $annee ?></div>
                            <div class="val"><?= $fmt($kpi['paiements_annee']) ?> <small>BIF</small></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
                    <div class="dg-kpi">
                        <div class="ico bg-g3"><i class="fas fa-wallet"></i></div>
                        <div>
                            <div class="lbl">Trésorerie disponible</div>
                            <div class="val"><?= $fmt($kpi['tresorerie']) ?> <small>BIF</small></div>
                            <div class="sub">Caisse <?= $fmt($kpi['tresorerie_caisse']) ?> · Banque
                                <?= $fmt($kpi['tresorerie_banque']) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
                    <a href="<?= base_url('direction/validations') ?>" class="text-decoration-none">
                        <div class="dg-kpi">
                            <div class="ico bg-g5"><i class="fas fa-hourglass-half"></i></div>
                            <div>
                                <div class="lbl">À valider (DG)</div>
                                <div class="val"><?= (int) $kpi['demandes_attente'] ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
                    <div class="dg-kpi">
                        <div class="ico bg-g6"><i class="fas fa-users"></i></div>
                        <div>
                            <div class="lbl">Effectif actif</div>
                            <div class="val"><?= (int) $kpi['effectif'] ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= GRAPHIQUES ================= -->
            <div class="row mt-2">
                <div class="col-lg-8">
                    <div class="dg-card">
                        <div class="dg-card-head">
                            <h3><i class="fas fa-chart-bar"></i> Engagements & paiements — <?= (int) $annee ?></h3>
                        </div>
                        <div class="dg-card-body">
                            <div class="dg-mini-stats">
                                <div>Engagé (demandes d'achat) <b><?= $fmt($totalEngage) ?> BIF</b></div>
                                <div>Payé <b class="text-success"><?= $fmt($totalPaye) ?> BIF</b></div>
                                <div>Reste à payer <b class="text-danger"><?= $fmt($resteAPayer) ?> BIF</b></div>
                            </div>
                            <div class="chart-box"><canvas id="dgFinanceChart"></canvas></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="dg-card">
                        <div class="dg-card-head">
                            <h3><i class="fas fa-chart-pie"></i> Chantiers par statut</h3>
                        </div>
                        <div class="dg-card-body">
                            <?php if (empty($chantierStatus)): ?>
                            <div class="dg-empty"><i class="fas fa-chart-pie"></i>Aucune donnée</div>
                            <?php else: ?>
                            <div class="chart-box"><canvas id="dgStatusChart"></canvas></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= CHANTIERS + VALIDATIONS ================= -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="dg-card">
                        <div class="dg-card-head">
                            <h3><i class="fas fa-hard-hat"></i> Chantiers actifs — consommation du budget</h3>
                            <a href="<?= base_url('chantiers') ?>">Voir tout <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="dg-card-body">
                            <?php if (empty($chantiers)): ?>
                            <div class="dg-empty"><i class="fas fa-hard-hat"></i>Aucun chantier actif</div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="dg-table">
                                    <thead>
                                        <tr>
                                            <th>Chantier</th>
                                            <th>Chef</th>
                                            <th class="text-right">Budget</th>
                                            <th style="width: 26%">Consommé</th>
                                            <th class="text-right">Fin prévue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($chantiers as $c):
                                                $budget   = (float) $c['budget'];
                                                $depense  = (float) $c['depense'];
                                                $pct      = $budget > 0 ? round($depense / $budget * 100) : 0;
                                                $cls      = $pct > 100 ? 'over' : ($pct >= 80 ? 'warn' : '');
                                                $enRetard = !empty($c['date_fin_prevue']) && $c['date_fin_prevue'] < date('Y-m-d');
                                            ?>
                                        <tr>
                                            <td>
                                                <b><?= html_escape($c['name']) ?></b><br>
                                                <small class="text-muted">
                                                    <?= html_escape($c['ref_chantier']) ?>
                                                    <?php if (!empty($c['location'])): ?>
                                                    · <i class="fas fa-map-marker-alt"></i>
                                                    <?= html_escape($c['location']) ?>
                                                    <?php endif; ?>
                                                </small>
                                            </td>
                                            <td><?= html_escape($c['chef_chantier']) ?></td>
                                            <td class="text-right"><?= $fmt($budget) ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="dg-progress flex-grow-1 mr-2">
                                                        <span class="<?= $cls ?>"
                                                            style="width: <?= min(100, $pct) ?>%"></span>
                                                    </div>
                                                    <b style="font-size:12px"
                                                        class="<?= $pct > 100 ? 'text-danger' : '' ?>"><?= $pct ?>%</b>
                                                </div>
                                                <small class="text-muted"><?= $fmt($depense) ?> BIF payés</small>
                                            </td>
                                            <td class="text-right <?= $enRetard ? 'text-danger font-weight-bold' : '' ?>"
                                                style="white-space:nowrap">
                                                <?= !empty($c['date_fin_prevue']) ? date('d/m/Y', strtotime($c['date_fin_prevue'])) : '—' ?>
                                                <?php if ($enRetard): ?><br><small>En retard</small><?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="dg-card">
                        <div class="dg-card-head">
                            <h3><i class="fas fa-check-double"></i> En attente de votre validation</h3>
                            <a href="<?= base_url('direction/validations') ?>">Tout voir <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="dg-card-body">
                            <?php if (empty($validations)): ?>
                            <div class="dg-empty"><i class="fas fa-check-circle"></i>Rien en attente</div>
                            <?php else: ?>
                            <?php foreach ($validations as $v): ?>
                            <a href="<?= base_url('direction/validations') ?>" class="dg-list-item">
                                <div class="dot" style="background:#fff4e5;color:#b7791f"><i
                                        class="fas fa-file-signature"></i></div>
                                <div class="main">
                                    <b><?= html_escape($v['reference']) ?> — <?= html_escape($v['object']) ?></b>
                                    <small>
                                        <?= html_escape($v['demandeur']) ?>
                                        ·
                                        <?= !empty($v['created_at']) ? date('d/m/Y', strtotime($v['created_at'])) : '' ?>
                                    </small>
                                </div>
                                <b style="font-size:12.5px;white-space:nowrap"><?= $fmt($v['total_amount']) ?></b>
                            </a>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= ALERTES + ACCÈS RAPIDES ================= -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="dg-card">
                        <div class="dg-card-head">
                            <h3><i class="fas fa-exclamation-triangle"></i> Alertes</h3>
                        </div>
                        <div class="dg-card-body">
                            <?php if (empty($alertes)): ?>
                            <div class="dg-empty"><i class="fas fa-shield-alt"></i>Aucune alerte, tout est en ordre
                            </div>
                            <?php else: ?>
                            <?php foreach ($alertes as $a): ?>
                            <a href="<?= base_url($a['url']) ?>" class="dg-list-item">
                                <div class="dot bg-<?= $a['color'] ?>" style="color:#fff"><i
                                        class="fas <?= $a['icon'] ?>"></i></div>
                                <div class="main"><b><?= html_escape($a['label']) ?></b></div>
                                <span class="badge badge-<?= $a['color'] ?> badge-pill"
                                    style="font-size:13px"><?= (int) $a['count'] ?></span>
                            </a>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="dg-card">
                        <div class="dg-card-head">
                            <h3><i class="fas fa-bolt"></i> Accès rapides</h3>
                        </div>
                        <div class="dg-card-body">
                            <div class="dg-quick">
                                <a href="<?= base_url('direction/validations') ?>"><i
                                        class="fas fa-check-double"></i>Validations</a>
                                <a href="<?= base_url('synthese-demandes') ?>"><i
                                        class="fas fa-clipboard-list"></i>Synthèse demandes</a>
                                <a href="<?= base_url('chantiers') ?>"><i class="fas fa-hard-hat"></i>Chantiers</a>
                                <a href="<?= base_url('caisse') ?>"><i class="fas fa-cash-register"></i>Caisse</a>
                                <a href="<?= base_url('engin-materiel') ?>"><i
                                        class="fas fa-truck-monster"></i>Engins</a>
                                <a href="<?= base_url('rh-employes') ?>"><i class="fas fa-users"></i>Employés</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
(function() {
    var nf = new Intl.NumberFormat('fr-FR');
    var compact = new Intl.NumberFormat('fr-FR', {
        notation: 'compact'
    });

    var fc = document.getElementById('dgFinanceChart');
    if (fc) {
        new Chart(fc, {
            type: 'bar',
            data: {
                labels: <?= json_encode($mois) ?>,
                datasets: [{
                    label: 'Engagements',
                    data: <?= json_encode($monthly['engagements']) ?>,
                    backgroundColor: '#102033',
                    borderRadius: 6,
                    maxBarThickness: 22
                }, {
                    label: 'Paiements',
                    data: <?= json_encode($monthly['paiements']) ?>,
                    backgroundColor: '#74c476',
                    borderRadius: 6,
                    maxBarThickness: 22
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
    }

    var sc = document.getElementById('dgStatusChart');
    if (sc) {
        <?php
            $sLabels = [];
            $sData = [];
            foreach ($chantierStatus as $s) {
                $sLabels[] = ucfirst(str_replace('_', ' ', (string) $s['status']));
                $sData[] = (int) $s['total'];
            }
            ?>
        new Chart(sc, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($sLabels) ?>,
                datasets: [{
                    data: <?= json_encode($sData) ?>,
                    backgroundColor: ['#74c476', '#0f766e', '#f6ad55', '#102033', '#c0392b',
                        '#9f7aea'
                    ],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
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