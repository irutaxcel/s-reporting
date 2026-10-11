<?php
$fmt    = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$fmtPct = function ($p) {
    return $p === null ? '—' : number_format($p, 1, ',', ' ') . ' %';
};
$dateFr = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '—';
};
$noteClass = function ($n) {
    if ($n === null) return 'secondary';
    return $n >= 85 ? 'success' : ($n >= 70 ? 'info' : ($n >= 50 ? 'warning' : 'danger'));
};
$noteBadge = function ($n) use ($noteClass) {
    if ($n === null) return '<span class="text-muted" title="Non évalué">—</span>';
    return '<span class="badge badge-' . $noteClass($n) . ' ev-note">' . number_format($n, 0, ',', ' ') . '</span>';
};
$criteres = ['budget' => 'Budget', 'delais' => 'Délais', 'suivi' => 'Suivi', 'engins' => 'Engins', 'appro' => 'Appro.'];
$gradesInfo = [
    'A'  => ['Excellent (≥ 85)', 'success'],
    'B'  => ['Bon (70 – 84)', 'info'],
    'C'  => ['À améliorer (50 – 69)', 'warning'],
    'D'  => ['Critique (< 50)', 'danger'],
    'NE' => ['Non évaluable', 'secondary'],
];
$s = $synthese;
?>
<style>
.ev-table td,
.ev-table th {
    vertical-align: middle;
}

.ev-note {
    font-size: .9rem;
    min-width: 38px;
}

.ev-global {
    font-size: 1.35rem;
    font-weight: 700;
    line-height: 1;
}

.ev-bar {
    height: 6px;
    min-width: 70px;
}

.ev-section {
    font-weight: 600;
    margin: 18px 0 8px;
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 4px;
}

.ev-alert-list li {
    margin-bottom: 4px;
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
                            <h3><?= (int) $s['notes'] ?> <small style="font-size:1rem">/ <?= (int) $s['nb'] ?></small>
                            </h3>
                            <p>Chantiers évalués</p>
                        </div>
                        <div class="icon"><i class="fas fa-hard-hat"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-<?= $noteClass($s['moyenne']) ?>">
                        <div class="inner">
                            <h3><?= $s['moyenne'] === null ? '—' : number_format($s['moyenne'], 1, ',', ' ') ?><small
                                    style="font-size:1rem"> / 100</small></h3>
                            <p>Note moyenne</p>
                        </div>
                        <div class="icon"><i class="fas fa-star-half-alt"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= (int) $s['grades']['D'] ?></h3>
                            <p>Chantier(s) critique(s) · classe D</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= (int) $s['retard'] ?></h3>
                            <p>Chantier(s) en retard</p>
                        </div>
                        <div class="icon"><i class="fas fa-hourglass-end"></i></div>
                    </div>
                </div>
            </div>

            <!-- 2. TABLEAU D'ÉVALUATION -->
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clipboard-check mr-2"></i>Évaluation des chantiers</h3>
                    <div class="card-tools">
                        <a href="<?= site_url('evaluation-chantier/export') . ($queryString ? '?' . $queryString : '') ?>"
                            class="btn btn-sm btn-success"><i class="fas fa-file-excel mr-1"></i>Exporter</a>
                        <button type="button" id="evPrintAll" class="btn btn-sm btn-secondary"><i
                                class="fas fa-print mr-1"></i>Imprimer</button>
                    </div>
                </div>

                <div class="card-body">
                    <form action="<?= site_url('evaluation-chantier') ?>" method="get" class="no-print">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <div class="form-group mb-2">
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
                                <div class="form-group mb-2">
                                    <label>Date début</label>
                                    <input type="date" name="date_debut" class="form-control"
                                        value="<?= html_escape($filters['date_debut']) ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label>Date fin</label>
                                    <input type="date" name="date_fin" class="form-control"
                                        value="<?= html_escape($filters['date_fin']) ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label>Classe</label>
                                    <select name="grade" class="form-control">
                                        <option value="">Toutes</option>
                                        <?php foreach ($gradesInfo as $g => $gi): ?>
                                        <option value="<?= $g ?>" <?= $filters['grade'] === $g ? 'selected' : '' ?>>
                                            <?= $g === 'NE' ? '' : $g . ' — ' ?><?= $gi[0] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label>Recherche</label>
                                    <div class="input-group">
                                        <input type="text" name="q" class="form-control" placeholder="Nom, réf., chef…"
                                            value="<?= html_escape($filters['q']) ?>">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success" title="Filtrer"><i
                                                    class="fas fa-search"></i></button>
                                            <a href="<?= site_url('evaluation-chantier') ?>" class="btn btn-secondary"
                                                title="Réinitialiser"><i class="fas fa-redo-alt"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <p class="text-muted small mb-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Période d'analyse (suivi, engins, approvisionnement) : du
                        <strong><?= $dateFr($periode['du']) ?></strong>
                        au <strong><?= $dateFr($periode['au']) ?></strong>. Budget et délais : depuis le début du
                        chantier.
                        Classement du moins bon au meilleur.
                    </p>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped ev-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:40px">#</th>
                                    <th style="width:220px">Chantier</th>
                                    <th style="width:150px">Avancement (temps)</th>
                                    <?php foreach ($criteres as $k => $lbl): ?>
                                    <th class="text-center" title="Poids : <?= (int) $poids[$k] ?> %">
                                        <?= $lbl ?><br><small><?= (int) $poids[$k] ?> %</small></th>
                                    <?php endforeach; ?>
                                    <th class="text-center" style="width:110px">Note globale</th>
                                    <th class="text-center">Alertes</th>
                                    <th class="text-center no-print" style="width:100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($rows)): ?>
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-4">Aucun chantier ne correspond
                                        aux filtres.</td>
                                </tr>
                                <?php else: foreach ($rows as $i => $r):
                                        $nbAlertes = 0;
                                        $txtAlertes = [];
                                        foreach ($r['alertes'] as $a) {
                                            if (in_array($a[0], ['danger', 'warning'], true)) $nbAlertes++;
                                            $txtAlertes[] = '• ' . $a[1];
                                        }
                                        $barW = $r['temps_pct'] === null ? 0 : $r['temps_pct']; ?>
                                <tr>
                                    <td><?= $offset + $i + 1 ?></td>
                                    <td>
                                        <strong><?= html_escape($r['name']) ?></strong>
                                        <br><small class="text-muted">
                                            <?= html_escape($r['projet_name'] ?: '—') ?>
                                            <?= $r['chef_chantier'] ? ' · ' . html_escape($r['chef_chantier']) : '' ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="progress ev-bar mb-1">
                                            <div class="progress-bar bg-<?= $r['retard'] > 0 ? 'danger' : 'primary' ?>"
                                                style="width:<?= $barW ?>%"></div>
                                        </div>
                                        <small class="text-muted">
                                            <?= $r['temps_pct'] === null ? 'Dates non renseignées' : $fmtPct($r['temps_pct']) ?>
                                            <?php if ($r['retard'] > 0): ?>
                                            · <span class="text-danger"><?= (int) $r['retard'] ?> j de retard</span>
                                            <?php endif; ?>
                                        </small>
                                        <br><small class="text-muted"><?= html_escape($r['status']) ?></small>
                                    </td>
                                    <?php foreach ($criteres as $k => $lbl): ?>
                                    <td class="text-center"><?= $noteBadge($r['notes'][$k]) ?></td>
                                    <?php endforeach; ?>
                                    <td class="text-center">
                                        <div class="ev-global text-<?= $r['grade_class'] ?>">
                                            <?= $r['note'] === null ? '—' : number_format($r['note'], 0, ',', ' ') ?>
                                        </div>
                                        <span class="badge badge-<?= $r['grade_class'] ?>">
                                            <?= $r['grade'] === 'NE' ? '' : $r['grade'] . ' · ' ?><?= $r['grade_label'] ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($nbAlertes > 0): ?>
                                        <span class="badge badge-danger" style="cursor:help"
                                            title="<?= html_escape(implode("\n", $txtAlertes)) ?>">
                                            <i class="fas fa-bell mr-1"></i><?= $nbAlertes ?>
                                        </span>
                                        <?php else: ?>
                                        <i class="fas fa-check-circle text-success"
                                            title="<?= html_escape(implode("\n", $txtAlertes)) ?>"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center text-nowrap no-print">
                                        <button type="button" class="btn btn-sm btn-info js-ev-detail"
                                            data-id="<?= (int) $r['id'] ?>" title="Voir le détail"><i
                                                class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-sm btn-secondary js-ev-print"
                                            data-id="<?= (int) $r['id'] ?>" title="Imprimer"><i
                                                class="fas fa-print"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-left">
                        <small class="text-muted">
                            Note sur 100 = moyenne pondérée des critères évalués. A ≥ 85 · B ≥ 70 · C ≥ 50 · D &lt; 50.
                        </small>
                    </div>
                    <?= $pagination ?>
                </div>
            </div>

            <!-- 3. RÉPARTITION DES CLASSES -->
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Répartition des chantiers par classe
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($gradesInfo as $g => $gi):
                            $nb = (int) $s['grades'][$g];
                            $pp = $s['nb'] > 0 ? round($nb / $s['nb'] * 100, 1) : 0; ?>
                        <div class="col-md-6">
                            <div class="progress-group">
                                <span
                                    class="progress-text"><?= $g === 'NE' ? '' : '<strong>' . $g . '</strong> — ' ?><?= $gi[0] ?></span>
                                <span class="float-right"><b><?= $nb ?></b> / <?= (int) $s['nb'] ?></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-<?= $gi[1] ?>" style="width:<?= $pp ?>%"></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- 4. MODALE DÉTAIL -->
            <div class="modal fade" id="modalEvaluation" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title"><i class="fas fa-clipboard-check mr-2"></i><span
                                    id="evDetailTitle">Détail</span></h5>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body" id="evDetailBody"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-info" id="evPrintModal"><i
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
    var EV_DETAIL_URL = <?= json_encode(site_url('evaluation-chantier/detail')) ?>;
    var EV_QS = <?= json_encode($datesQueryString) ?>;
    var titleEl = document.getElementById('evDetailTitle');
    var bodyEl = document.getElementById('evDetailBody');
    var CRITERES = [
        ['budget', 'Budget'],
        ['delais', 'Délais'],
        ['suivi', 'Suivi (journal de production)'],
        ['engins', 'Engins'],
        ['appro', 'Approvisionnement']
    ];

    function fmt(n) {
        return Math.round(Number(n) || 0).toLocaleString('fr-FR').replace(/[\u202f\u00a0]/g, ' ');
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

    function noteClass(n) {
        if (n === null || n === undefined) return 'secondary';
        return n >= 85 ? 'success' : (n >= 70 ? 'info' : (n >= 50 ? 'warning' : 'danger'));
    }

    function noteBadge(n) {
        return (n === null || n === undefined) ? '<span class="text-muted">Non évalué</span>' :
            '<span class="badge badge-' + noteClass(n) + ' ev-note">' + Math.round(n) + ' / 100</span>';
    }

    function indicateur(k, e) {
        switch (k) {
            case 'budget':
                return e.budget > 0 ?
                    'Consommé ' + pct(e.conso_pct) + (e.temps_pct !== null ? ' pour ' + pct(e.temps_pct) +
                        ' du délai écoulé' : '') +
                    ' — ' + fmt(e.cout_total) + ' / ' + fmt(e.budget) + ' BIF' :
                    'Aucun budget saisi';
            case 'delais':
                if (e.retard === null) return e.date_fin_prevue ? 'Pas de journal pour dater la fin réelle' :
                    'Date de fin prévue non renseignée';
                if (e.retard > 0) return e.retard + ' jour(s) de retard (fin prévue le ' + dateFr(e
                    .date_fin_prevue) + ')';
                return e.jours_restants !== null ? 'Dans les délais — ' + e.jours_restants +
                    ' jour(s) restant(s)' : 'Dans les délais';
            case 'suivi':
                if (e.couverture === null) return e.clos ? 'Chantier clôturé' :
                    'Aucun jour ouvré sur la période';
                return e.nb_jours + ' jour(s) renseigné(s) sur ' + e.attendus + ' jours ouvrés — ' +
                    e.nb_valides + ' validé(s), ' + e.nb_attente + ' en attente';
            case 'engins':
                return e.nb_pannes + ' panne(s) dont ' + e.pannes_ouvertes + ' ouverte(s) — carburant ' +
                    fmt(e.cout_fuel) + ' BIF (' + fmt(e.litres) + ' L), maintenance ' + fmt(e.cout_maint) +
                    ' BIF';
            case 'appro':
                return e.nb_payees > 0 ?
                    e.livrees + ' livrée(s), ' + e.partielles + ' partielle(s) sur ' + e.nb_payees +
                    ' DA payée(s)' :
                    'Aucune DA payée sur la période';
        }
        return '';
    }

    function table(headers, rows) {
        var h =
            '<div class="table-responsive"><table class="table table-bordered table-sm"><thead class="thead-light"><tr>';
        headers.forEach(function(x) {
            h += '<th' + (x[1] ? ' class="' + x[1] + '"' : '') + '>' + x[0] + '</th>';
        });
        return h + '</tr></thead><tbody>' + rows.join('') + '</tbody></table></div>';
    }

    function rendre(d) {
        var e = d.evaluation;
        titleEl.textContent = 'Évaluation — ' + e.name;

        var h = '<div class="row">' +
            '<div class="col-md-3"><div class="alert alert-' + e.grade_class + ' mb-2 text-center">' +
            '<small class="d-block">Note globale</small><span style="font-size:1.8rem;font-weight:700">' +
            (e.note === null ? '—' : Math.round(e.note)) + '</span> / 100<br><strong>' +
            (e.grade === 'NE' ? '' : 'Classe ' + e.grade + ' · ') + esc(e.grade_label) +
            '</strong></div></div>' +
            '<div class="col-md-9"><p class="mb-1"><strong>Projet :</strong> ' + esc(e.projet_name || '—') +
            ' &nbsp; <strong>Chef :</strong> ' + esc(e.chef_chantier || '—') +
            ' &nbsp; <strong>Lieu :</strong> ' + esc(e.location || '—') + '</p>' +
            '<p class="mb-1"><strong>Statut :</strong> ' + esc(e.status) +
            ' &nbsp; <strong>Période prévue :</strong> ' +
            dateFr(e.date_debut) + ' → ' + dateFr(e.date_fin_prevue) + '</p>' +
            '<p class="mb-0 text-muted small">Période d\'analyse : ' + dateFr(d.periode.du) + ' → ' + dateFr(d
                .periode.au) +
            ' · Effectif moyen : ' + e.effectif_moyen + ' · Heures travaillées : ' + fmt(e.heures) +
            '</p></div></div>';

        // Critères
        var lignes = CRITERES.map(function(c) {
            return '<tr><td><strong>' + c[1] + '</strong></td><td class="text-center">' + d.poids[c[
                0]] + ' %</td>' +
                '<td class="text-center">' + noteBadge(e.notes[c[0]]) + '</td><td>' + esc(indicateur(c[
                    0], e)) + '</td></tr>';
        });
        h += '<div class="ev-section">Détail des critères</div>' +
            table([
                ['Critère'],
                ['Poids', 'text-center'],
                ['Note', 'text-center'],
                ['Indicateur']
            ], lignes);

        // Points d'attention
        h += '<div class="ev-section">Points d\'attention</div>';
        if (!e.alertes.length) {
            h +=
            '<p class="text-success"><i class="fas fa-check-circle mr-1"></i>Aucun point d\'attention.</p>';
        } else {
            var icons = {
                danger: 'fa-times-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle',
                secondary: 'fa-minus-circle'
            };
            h += '<ul class="list-unstyled ev-alert-list">' + e.alertes.map(function(a) {
                return '<li class="text-' + a[0] + '"><i class="fas ' + (icons[a[0]] || 'fa-circle') +
                    ' mr-2"></i>' + esc(a[1]) + '</li>';
            }).join('') + '</ul>';
        }

        // Journaux
        h += '<div class="ev-section">Journaux de production de la période (' + d.journaux.length + ')</div>';
        h += d.journaux.length ? table(
            [
                ['Date'],
                ['Référence'],
                ['Chef'],
                ['Effectif', 'text-right'],
                ['Heures', 'text-right'],
                ['Statut']
            ],
            d.journaux.map(function(j) {
                return '<tr><td>' + dateFr(j.journal_date) + '</td><td>' + esc(j.reference) +
                    '</td><td>' + esc(j.chef_chantier) +
                    '</td><td class="text-right">' + ((+j.effectif_interne) + (+j
                        .effectif_sous_traitant)) +
                    '</td><td class="text-right">' + fmt(j.heures_travaillees) + '</td><td>' + esc(j
                        .statut) + '</td></tr>';
            })) : '<p class="text-muted">Aucun journal sur la période.</p>';

        // Pannes
        h += '<div class="ev-section">Pannes d\'engins de la période (' + d.pannes.length + ')</div>';
        h += d.pannes.length ? table(
            [
                ['Date'],
                ['Référence'],
                ['Engin'],
                ['Gravité'],
                ['Statut'],
                ['Description']
            ],
            d.pannes.map(function(p) {
                return '<tr><td>' + dateFr(p.date_signalement) + '</td><td>' + esc(p.reference) +
                    '</td><td>' +
                    esc(p.code_engin + ' — ' + p.designation) + '</td><td>' + esc(p.gravite) +
                    '</td><td>' +
                    esc(p.panne_status) + '</td><td>' + esc(p.description) + '</td></tr>';
            })) : '<p class="text-muted">Aucune panne sur la période.</p>';

        // DA non livrées
        h += '<div class="ev-section">DA payées non entièrement livrées (' + d.da.length + ')</div>';
        h += d.da.length ? table(
            [
                ['DA'],
                ['Demandeur'],
                ['Dernier paiement'],
                ['Payé', 'text-right'],
                ['Livraison']
            ],
            d.da.map(function(a) {
                return '<tr><td>#' + esc(a.id) + '</td><td>' + esc(a.requested_by) + '</td><td>' +
                    dateFr(a.payment_date) +
                    '</td><td class="text-right">' + fmt(a.amount_paid) + '</td><td>' +
                    (a.delivery_status === 'partiel' ? 'Partielle' : 'Non livrée') + '</td></tr>';
            })) : '<p class="text-muted">Aucune.</p>';

        bodyEl.innerHTML = h;
    }

    function chargerDetail(id, imprimer) {
        titleEl.textContent = 'Chargement…';
        bodyEl.innerHTML =
            '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-info"></i></div>';
        window.jQuery('#modalEvaluation').modal('show');

        fetch(EV_DETAIL_URL + '/' + id + (EV_QS ? '?' + EV_QS : ''), {
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(r) {
                var type = r.headers.get('content-type') || '';
                if (type.indexOf('application/json') === -1) {
                    throw new Error(r.status === 404 ?
                        'Adresse introuvable (404) : vérifiez la route « evaluation-chantier/detail » dans routes.php.' :
                        'Erreur serveur (HTTP ' + r.status + '). Ouvrez ' + EV_DETAIL_URL + '/' + id +
                        ' pour voir le détail.');
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
            '<style>body{padding:20px;font-size:12px;background:#fff}.ev-section{font-weight:600;margin:16px 0 6px;border-bottom:1px solid #dee2e6}</style>' +
            '</head><body><h4>SATRACO — ' + esc(titleEl.textContent) + '</h4><small>Imprimé le ' +
            new Date().toLocaleString('fr-FR') +
            '</small><hr>' + bodyEl.innerHTML + '</body></html>');
        w.document.close();
        setTimeout(function() {
            w.focus();
            w.print();
        }, 600);
    }

    document.querySelectorAll('.js-ev-detail').forEach(function(b) {
        b.addEventListener('click', function() {
            chargerDetail(b.dataset.id, false);
        });
    });
    document.querySelectorAll('.js-ev-print').forEach(function(b) {
        b.addEventListener('click', function() {
            chargerDetail(b.dataset.id, true);
        });
    });
    document.getElementById('evPrintModal').addEventListener('click', imprimerModale);
    document.getElementById('evPrintAll').addEventListener('click', function() {
        window.print();
    });
});
</script>