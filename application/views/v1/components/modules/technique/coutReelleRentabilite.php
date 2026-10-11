<?php
$fmt = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$fmtCourt = function ($n) {
    $n = (float) $n;
    $a = abs($n);
    if ($a >= 1e9) return number_format($n / 1e9, 1, ',', ' ') . ' Md';
    if ($a >= 1e6) return number_format($n / 1e6, 1, ',', ' ') . ' M';
    return number_format($n, 0, ',', ' ');
};
$fmtPct = function ($p) {
    return $p === null ? '—' : number_format($p, 1, ',', ' ') . ' %';
};
$signe  = function ($n) use ($fmt) {
    return ($n > 0 ? '+' : '') . $fmt($n);
};
$s = $synthese;
$partPct = function ($v) use ($s) {
    return $s['cout_total'] > 0 ? round($v / $s['cout_total'] * 100, 1) : 0;
};
?>
<style>
.cr-table td,
.cr-table th {
    vertical-align: middle;
}

.cr-bar {
    height: 6px;
    min-width: 60px;
}

.cr-modal-section {
    font-weight: 600;
    margin: 18px 0 8px;
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 4px;
}

@media print {

    .main-sidebar,
    .main-header,
    .main-footer,
    .no-print,
    .breadcrumb,
    .card-tools,
    .pagination {
        display: none !important;
    }

    .content-wrapper {
        margin-left: 0 !important;
    }

    .table-responsive {
        overflow: visible !important;
    }
}
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- 1. TUILES -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $fmtCourt($s['budget']) ?></h3>
                            <p>Budget prévisionnel total (BIF)</p>
                        </div>
                        <div class="icon"><i class="fas fa-coins"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $fmtCourt($s['cout_total']) ?></h3>
                            <p>Coût réel total (BIF)</p>
                        </div>
                        <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div
                        class="small-box <?= ($s['marge_pct'] !== null && $s['marge_pct'] < 0) ? 'bg-danger' : 'bg-success' ?>">
                        <div class="inner">
                            <h3><?= $fmtPct($s['marge_pct']) ?></h3>
                            <p>Marge globale sur budget</p>
                        </div>
                        <div class="icon"><i class="fas fa-chart-line"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= (int) $s['nb_depassement'] ?></h3>
                            <p>Chantier(s) en dépassement · <?= (int) $s['nb_surveiller'] ?> à surveiller</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                </div>
            </div>

            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $this->session->flashdata('error'); ?>
            </div>
            <?php endif; ?>

            <!-- 2. ANALYSE PAR CHANTIER -->
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-balance-scale mr-2"></i>Analyse des coûts &amp; rentabilité
                        par chantier</h3>
                    <div class="card-tools">
                        <a href="<?= site_url('cout-reelle-rentebilite/export') . ($queryString ? '?' . $queryString : '') ?>"
                            class="btn btn-sm btn-success"><i class="fas fa-file-excel mr-1"></i>Exporter</a>
                        <button type="button" id="crPrintAll" class="btn btn-sm btn-secondary"><i
                                class="fas fa-print mr-1"></i>Imprimer</button>
                    </div>
                </div>

                <div class="card-body">
                    <form action="<?= site_url('cout-reelle-rentebilite') ?>" method="get" class="no-print">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label>Chantier</label>
                                    <select name="chantier" class="form-control">
                                        <option value="">Tous les chantiers</option>
                                        <?php foreach ($allChantiers as $c): ?>
                                        <option value="<?= (int) $c['id'] ?>"
                                            <?= $filters['chantier_id'] == $c['id'] ? 'selected' : '' ?>>
                                            <?= html_escape($c['name']) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label>Date début</label>
                                    <input type="date" name="date_debut" class="form-control"
                                        value="<?= html_escape($filters['date_debut']) ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label>Date fin</label>
                                    <input type="date" name="date_fin" class="form-control"
                                        value="<?= html_escape($filters['date_fin']) ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label>Statut</label>
                                    <select name="statut" class="form-control">
                                        <option value="">Tous les statuts</option>
                                        <?php foreach (['rentable' => 'Rentable', 'surveiller' => 'À surveiller', 'depassement' => 'Dépassement', 'sans_budget' => 'Sans budget'] as $k => $lbl): ?>
                                        <option value="<?= $k ?>" <?= $filters['statut'] === $k ? 'selected' : '' ?>>
                                            <?= $lbl ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="btn-group btn-block">
                                    <button type="submit" class="btn btn-success"><i
                                            class="fas fa-search mr-1"></i>Filtrer</button>
                                    <a href="<?= site_url('cout-reelle-rentebilite') ?>" class="btn btn-secondary"
                                        title="Réinitialiser les filtres"><i class="fas fa-redo-alt"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped cr-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:40px">#</th>
                                    <th style="width:200px">Chantier</th>
                                    <th class="text-right">Budget prévisionnel</th>
                                    <th class="text-right">Matériaux</th>
                                    <th class="text-right">Main-d'œuvre</th>
                                    <th class="text-right">Engins &amp; carb.</th>
                                    <th class="text-right">Sous-traitance</th>
                                    <th class="text-right">Coût réel total</th>
                                    <th class="text-right">Écart</th>
                                    <th style="width:170px">Marge / consommé</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-center no-print" style="width:100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($rows)): ?>
                                <tr>
                                    <td colspan="12" class="text-center text-muted py-4">Aucun chantier ne correspond
                                        aux filtres.</td>
                                </tr>
                                <?php else: foreach ($rows as $i => $r):
                                        $barW = $r['conso_pct'] === null ? 0 : min(100, max(0, $r['conso_pct'])); ?>
                                <tr>
                                    <td><?= $offset + $i + 1 ?></td>
                                    <td>
                                        <strong><?= html_escape($r['name']) ?></strong>
                                        <?php if (!empty($r['projet_name'])): ?>
                                        <br><small class="text-muted"><?= html_escape($r['projet_name']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right text-nowrap"><?= $fmt($r['budget']) ?></td>
                                    <td class="text-right text-nowrap"><?= $fmt($r['cout_materiaux']) ?></td>
                                    <td class="text-right text-nowrap"><?= $fmt($r['cout_main_oeuvre']) ?></td>
                                    <td class="text-right text-nowrap"><?= $fmt($r['cout_engins']) ?></td>
                                    <td class="text-right text-nowrap"><?= $fmt($r['cout_sous_traitance']) ?></td>
                                    <td class="text-right text-nowrap"><strong><?= $fmt($r['cout_total']) ?></strong>
                                    </td>
                                    <td
                                        class="text-right text-nowrap <?= $r['ecart'] < 0 ? 'text-danger' : 'text-success' ?>">
                                        <strong><?= $signe($r['ecart']) ?></strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress cr-bar flex-grow-1 mr-2" title="Budget consommé">
                                                <div class="progress-bar bg-<?= $r['statut_class'] ?>"
                                                    style="width:<?= $barW ?>%"></div>
                                            </div>
                                            <strong
                                                class="<?= ($r['marge_pct'] !== null && $r['marge_pct'] < 0) ? 'text-danger' : '' ?>"><?= $fmtPct($r['marge_pct']) ?></strong>
                                        </div>
                                        <small class="text-muted">Consommé <?= $fmtPct($r['conso_pct']) ?>
                                            <?= $r['temps_pct'] !== null ? '· Temps ' . $fmtPct($r['temps_pct']) : '' ?></small>
                                    </td>
                                    <td class="text-center"><span
                                            class="badge badge-<?= $r['statut_class'] ?>"><?= $r['statut_label'] ?></span>
                                    </td>
                                    <td class="text-center text-nowrap no-print">
                                        <button type="button" class="btn btn-sm btn-info js-cr-detail"
                                            data-id="<?= (int) $r['id'] ?>" title="Voir le détail"><i
                                                class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-sm btn-secondary js-cr-print"
                                            data-id="<?= (int) $r['id'] ?>" title="Imprimer"><i
                                                class="fas fa-print"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-light">
                                    <th colspan="2" class="text-right">TOTAUX (<?= (int) $s['nb_chantiers'] ?>
                                        chantiers)</th>
                                    <th class="text-right text-nowrap"><?= $fmt($s['budget']) ?></th>
                                    <th class="text-right text-nowrap"><?= $fmt($s['cout_materiaux']) ?></th>
                                    <th class="text-right text-nowrap"><?= $fmt($s['cout_main_oeuvre']) ?></th>
                                    <th class="text-right text-nowrap"><?= $fmt($s['cout_engins']) ?></th>
                                    <th class="text-right text-nowrap"><?= $fmt($s['cout_sous_traitance']) ?></th>
                                    <th class="text-right text-nowrap"><?= $fmt($s['cout_total']) ?></th>
                                    <th
                                        class="text-right text-nowrap <?= $s['ecart'] < 0 ? 'text-danger' : 'text-success' ?>">
                                        <?= $signe($s['ecart']) ?></th>
                                    <th colspan="3">Marge globale : <strong><?= $fmtPct($s['marge_pct']) ?></strong>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-left">
                        <small class="text-muted">Montants en BIF. Coût réel = bons de paiement effectués + contrats
                            main-d'œuvre. Écart = Budget − Coût réel.</small>
                    </div>
                    <?= $pagination ?>
                </div>
            </div>

            <!-- 3. RÉPARTITION -->
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Répartition du coût réel global</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach (
                            [
                                ['Matériaux & achats', $s['cout_materiaux'], 'primary'],
                                ["Main-d'œuvre", $s['cout_main_oeuvre'], 'success'],
                                ['Engins, maintenance & carburant', $s['cout_engins'], 'warning'],
                                ['Sous-traitance', $s['cout_sous_traitance'], 'danger'],
                            ] as $poste
                        ): $pp = $partPct($poste[1]); ?>
                        <div class="col-md-6">
                            <div class="progress-group">
                                <span class="progress-text"><?= html_escape($poste[0]) ?></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-<?= $poste[2] ?>" style="width:<?= $pp ?>%"></div>
                                </div>
                                <span class="text-muted small"><?= $fmt($poste[1]) ?> BIF
                                    (<?= number_format($pp, 1, ',', ' ') ?> %)</span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- 4. MODALE DÉTAIL -->
            <div class="modal fade" id="modalDetailCout" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title"><i class="fas fa-balance-scale mr-2"></i><span
                                    id="crDetailTitle">Détail</span></h5>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body" id="crDetailBody"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-info" id="crPrintModal"><i
                                    class="fas fa-print mr-1"></i>Imprimer</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var CR_DETAIL_URL = <?= json_encode(site_url('cout-reelle-rentebilite/detail')) ?>;
    var CR_QS = <?= json_encode($datesQueryString) ?>;
    var titleEl = document.getElementById('crDetailTitle');
    var bodyEl = document.getElementById('crDetailBody');

    function fmt(n) {
        return Math.round(Number(n) || 0).toLocaleString('fr-FR').replace(/[\u202f\u00a0]/g, ' ');
    }

    function signe(n) {
        return (Number(n) > 0 ? '+' : '') + fmt(n);
    }

    function pct(n) {
        return (n === null || n === undefined) ? '—' :
            Number(n).toLocaleString('fr-FR', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            }) + ' %';
    }

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function(c) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [c];
        });
    }

    function dateFr(d) {
        return d ? String(d).substring(0, 10).split('-').reverse().join('/') : '—';
    }

    function box(label, val, cls) {
        return '<div class="col-md-3"><div class="alert alert-' + cls + ' mb-2"><small class="d-block">' +
            label +
            '</small><strong>' + val + '</strong></div></div>';
    }

    function rendre(d) {
        var c = d.chantier,
            total = Number(c.cout_total) || 0;
        var cls = Number(c.ecart) >= 0 ? 'success' : 'danger';
        titleEl.textContent = 'Détail coût réel — ' + c.name;

        var h = '<div class="row">' +
            box('Budget prévisionnel', fmt(c.budget) + ' BIF', 'light border') +
            box('Coût réel', fmt(total) + ' BIF', 'light border') +
            box('Écart', signe(c.ecart) + ' BIF', cls) +
            box('Marge sur budget', pct(c.marge_pct), cls) + '</div>';

        h += '<p class="mb-2"><span class="badge badge-' + c.statut_class + ' mr-2">' + esc(c.statut_label) +
            '</span>' +
            'Budget consommé : <strong>' + pct(c.conso_pct) + '</strong>' +
            (c.temps_pct !== null ? ' — Temps écoulé : <strong>' + pct(c.temps_pct) + '</strong>' : '') +
            (c.date_debut ? ' — Du ' + dateFr(c.date_debut) + ' au ' + dateFr(c.date_fin_prevue) : '') + '</p>';

        // Postes
        var postes = [
            ['Matériaux & achats', c.cout_materiaux],
            ["Main-d'œuvre", c.cout_main_oeuvre],
            ['Engins, maintenance & carburant', c.cout_engins],
            ['Sous-traitance', c.cout_sous_traitance]
        ];
        h += '<div class="cr-modal-section">Coût réel par poste</div><table class="table table-bordered table-sm">' +
            '<thead class="thead-light"><tr><th>Poste</th><th class="text-right">Coût réel</th><th class="text-right">Part</th></tr></thead><tbody>';
        postes.forEach(function(p) {
            h += '<tr><td>' + esc(p[0]) + '</td><td class="text-right text-nowrap">' + fmt(p[1]) +
                '</td><td class="text-right">' +
                pct(total > 0 ? p[1] / total * 100 : 0) + '</td></tr>';
        });
        h += '</tbody><tfoot><tr><th>TOTAL</th><th class="text-right text-nowrap">' + fmt(total) +
            '</th><th class="text-right">100 %</th></tr></tfoot></table>';

        // Paiements
        h += '<div class="cr-modal-section">Achats payés (' + d.paiements.length + ')</div>';
        if (!d.paiements.length) {
            h += '<p class="text-muted">Aucun bon de paiement effectué sur la période.</p>';
        } else {
            h += '<div class="table-responsive"><table class="table table-bordered table-sm"><thead class="thead-light"><tr>' +
                '<th>Date</th><th>N° paiement</th><th>DA</th><th>Poste</th><th>Objet</th><th>Mode</th><th class="text-right">Montant</th></tr></thead><tbody>';
            d.paiements.forEach(function(p) {
                h += '<tr><td class="text-nowrap">' + dateFr(p.payment_date) + '</td><td>' + esc(p
                        .payment_number) + '</td><td>#' + esc(p.da_id) +
                    '</td><td>' + esc(p.poste) + '</td><td>' + esc(p.summary) + '</td><td>' + esc(p
                        .payment_mode) +
                    '</td><td class="text-right text-nowrap">' + fmt(p.amount_paid) + '</td></tr>';
            });
            h += '</tbody></table></div>';
        }

        // Contrats
        h += '<div class="cr-modal-section">Contrats main-d\'œuvre (' + d.contrats.length + ')</div>';
        if (!d.contrats.length) {
            h += '<p class="text-muted">Aucun contrat sur la période.</p>';
        } else {
            h += '<div class="table-responsive"><table class="table table-bordered table-sm"><thead class="thead-light"><tr>' +
                '<th>Travailleur</th><th>Type</th><th>Fonction</th><th>Période</th><th>Paie</th><th class="text-right">Taux</th><th class="text-right">Montant</th><th>Statut</th></tr></thead><tbody>';
            d.contrats.forEach(function(w) {
                h += '<tr><td>' + esc(w.worker_name) + '</td><td>' + esc(w.worker_type) + '</td><td>' +
                    esc(w.function_name) +
                    '</td><td class="text-nowrap">' + dateFr(w.start_date) + ' → ' + dateFr(w
                        .end_date) + '</td><td>' + esc(w.pay_mode) +
                    '</td><td class="text-right text-nowrap">' + fmt(w.unit_rate) +
                    '</td><td class="text-right text-nowrap">' + fmt(w.contract_amount) +
                    '</td><td>' + esc(w.status_label) + '</td></tr>';
            });
            h += '</tbody></table></div>';
        }

        bodyEl.innerHTML = h;
    }

    function chargerDetail(id, imprimer) {
        titleEl.textContent = 'Chargement…';
        bodyEl.innerHTML =
            '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-info"></i></div>';
        window.jQuery('#modalDetailCout').modal('show');

        fetch(CR_DETAIL_URL + '/' + id + (CR_QS ? '?' + CR_QS : ''), {
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(r) {
                var type = r.headers.get('content-type') || '';
                if (type.indexOf('application/json') === -1) {
                    throw new Error('Réponse inattendue du serveur (HTTP ' + r.status + '). ' +
                        'Vérifiez la route « cout-reelle-rentebilite/detail » dans routes.php.');
                }
                return r.json().then(function(j) {
                    return {
                        ok: r.ok,
                        j: j
                    };
                });
            })
            .then(function(res) {
                if (!res.ok || !res.j.success) {
                    throw new Error(res.j.message || 'Erreur de chargement.');
                }
                rendre(res.j.data);
                if (imprimer) {
                    imprimerModale();
                }
            })
            .catch(function(e) {
                titleEl.textContent = 'Erreur';
                bodyEl.innerHTML = '<div class="alert alert-danger mb-0">' + esc(e.message) + '</div>';
            });
    }

    function imprimerModale() {
        var w = window.open('', '_blank', 'width=1000,height=800');
        if (!w) {
            alert('Autorisez les fenêtres pop-up pour imprimer.');
            return;
        }
        var css = Array.prototype.map.call(document.querySelectorAll('link[rel="stylesheet"]'), function(l) {
            return l.outerHTML;
        }).join('');
        w.document.write('<html><head><meta charset="utf-8"><title>' + esc(titleEl.textContent) + '</title>' +
            css +
            '<style>body{padding:20px;font-size:12px;background:#fff}.cr-modal-section{font-weight:600;margin:16px 0 6px;border-bottom:1px solid #dee2e6}</style>' +
            '</head><body><h4>SATRACO — ' + esc(titleEl.textContent) + '</h4><small>Imprimé le ' +
            new Date().toLocaleString('fr-FR') +
            '</small><hr>' + bodyEl.innerHTML + '</body></html>');
        w.document.close();
        setTimeout(function() {
            w.focus();
            w.print();
        }, 600);
    }

    document.querySelectorAll('.js-cr-detail').forEach(function(b) {
        b.addEventListener('click', function() {
            chargerDetail(b.dataset.id, false);
        });
    });
    document.querySelectorAll('.js-cr-print').forEach(function(b) {
        b.addEventListener('click', function() {
            chargerDetail(b.dataset.id, true);
        });
    });
    document.getElementById('crPrintModal').addEventListener('click', imprimerModale);
    document.getElementById('crPrintAll').addEventListener('click', function() {
        window.print();
    });
});
</script>