<?php
$fmt  = function ($n) {
    return $n === null ? '—' : number_format((float) $n, 0, ',', ' ');
};
$qte  = function ($n) {
    return $n === null ? '—' : rtrim(rtrim(number_format((float) $n, 2, ',', ' '), '0'), ',');
};
$dfr  = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '—';
};
$nice = function ($s) {
    return $s === null || $s === '' ? '—' : ucfirst(str_replace('_', ' ', (string) $s));
};

$paiementLbl   = ['non_paye' => 'Non payé', 'partiel' => 'Partiel', 'paye' => 'Payé'];
$paiementBadge = ['non_paye' => 'danger', 'partiel' => 'warning', 'paye' => 'success'];
$dgBadge = function ($s) {
    $s = mb_strtolower((string) $s);
    if (preg_match('/^(valid|approuv)/', $s)) return 'success';
    if (preg_match('/^(rejet|refus)/', $s)) return 'danger';
    if ($s === 'en_attente') return 'warning';
    return 'secondary';
};

$url = function (array $params) {
    $q = array_filter(array_merge($_GET, $params), function ($v) {
        return $v !== '' && $v !== null;
    });
    return current_url() . ($q ? '?' . http_build_query($q) : '');
};

$t = $totaux;
$filtresActifs = array_filter($f, function ($v) {
    return $v !== '' && $v !== null;
});
$manquePrix = !isset($colsItems['pu']) || !isset($colsItems['designation']);
$debutLigne = ($page - 1) * $parPage + 1;
$finLigne   = min($page * $parPage, $total);
?>

<style>
.ar-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
    border: 1px solid #eef3f0;
    margin-bottom: 20px;
}

.ar-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px 8px;
    flex-wrap: wrap;
    gap: 8px;
}

.ar-card-head h3 {
    font-size: 15px;
    font-weight: 800;
    color: var(--satraco-dark);
    margin: 0;
}

.ar-card-head h3 i {
    color: var(--satraco-green-dark);
    margin-right: 6px;
}

.ar-card-body {
    padding: 8px 18px 18px;
}

.ar-filters {
    padding: 14px 18px;
}

.ar-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 10px;
}

.ar-grid .wide {
    grid-column: span 2;
}

.ar-filters label {
    font-size: 11.5px;
    font-weight: 700;
    color: #6b7f78;
    margin-bottom: 3px;
    display: block;
}

.ar-filters .form-control {
    border-radius: 10px;
    border: 1px solid #d7e6dc;
    font-weight: 600;
}

.ar-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
    align-items: center;
}

.btn-ar {
    border-radius: 10px;
    font-weight: 700;
}

.btn-ar-green {
    background: var(--satraco-green);
    color: #fff;
    border: 0;
}

.btn-ar-green:hover {
    background: #3f9f46;
    color: #fff;
}

.btn-ar-excel {
    background: #1d6f42;
    color: #fff;
    border: 0;
}

.btn-ar-excel:hover {
    background: #155533;
    color: #fff;
}

.btn-ar-light {
    background: var(--satraco-white-soft);
    color: var(--satraco-dark);
    border: 1px solid #e3eee7;
}

.ar-tiles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.ar-tile {
    background: #fff;
    border-radius: 16px;
    padding: 16px;
    border: 1px solid #eef3f0;
    box-shadow: 0 4px 18px rgba(16, 32, 51, .06);
}

.ar-tile span {
    display: block;
    font-size: 12px;
    color: #6b7f78;
    font-weight: 700;
}

.ar-tile b {
    display: block;
    font-size: 21px;
    color: var(--satraco-dark);
    margin-top: 2px;
}

.ar-tile b small {
    font-size: 12px;
    color: #8a9a94;
}

.ar-tile.dark {
    background: linear-gradient(135deg, #102033, #0f766e);
    border: 0;
}

.ar-tile.dark span,
.ar-tile.dark b small {
    color: rgba(255, 255, 255, .8);
}

.ar-tile.dark b {
    color: #fff;
}

.ar-table {
    width: 100%;
    font-size: 12.5px;
}

.ar-table>thead th {
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #8a9a94;
    font-weight: 700;
    border-bottom: 1px solid #eef3f0;
    padding: 8px 6px;
    white-space: nowrap;
    position: sticky;
    top: 0;
    background: #fff;
}

.ar-table>tbody>tr.main>td {
    padding: 9px 6px;
    border-bottom: 1px solid #f3f6f4;
    color: var(--satraco-dark);
    vertical-align: middle;
}

.ar-table>tbody>tr.main:hover>td {
    background: #fafcfb;
}

.ar-table .ref {
    font-weight: 800;
    white-space: nowrap;
}

.btn-items {
    border: 1px solid #d7e6dc;
    background: var(--satraco-white-soft);
    color: var(--satraco-dark);
    border-radius: 8px;
    font-size: 11.5px;
    font-weight: 700;
    padding: 3px 8px;
    white-space: nowrap;
}

.btn-items:hover {
    border-color: var(--satraco-green);
}

.btn-items.open {
    background: var(--satraco-green);
    color: #fff;
    border-color: var(--satraco-green);
}

.ar-items>td {
    background: #f7fbf9;
    padding: 10px 14px 14px !important;
    border-bottom: 2px solid #dfeae4;
}

.ar-sub {
    width: 100%;
    font-size: 12.5px;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
}

.ar-sub th {
    background: #eef6f1;
    font-size: 10.5px;
    text-transform: uppercase;
    color: #5f766d;
    padding: 7px 8px;
    font-weight: 700;
}

.ar-sub td {
    padding: 7px 8px;
    border-top: 1px solid #f0f4f2;
}

.ar-sub tfoot td {
    font-weight: 800;
    background: #fafcfb;
}

.ar-pager {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 14px;
    font-size: 13px;
    color: #6b7f78;
}

.ar-pager .pagination {
    margin: 0;
}

.ar-pager .page-link {
    color: var(--satraco-dark);
    border-radius: 8px !important;
    margin: 0 2px;
    border-color: #e3eee7;
}

.ar-pager .page-item.active .page-link {
    background: var(--satraco-green);
    border-color: var(--satraco-green);
    color: #fff;
}

.ar-empty {
    text-align: center;
    color: #8a9a94;
    padding: 40px 10px;
    font-size: 13px;
}

.ar-empty i {
    display: block;
    font-size: 30px;
    color: #cfe3d6;
    margin-bottom: 8px;
}

.ar-warn {
    font-size: 12.5px;
    background: #fff4e5;
    color: #8a5a12;
    border-radius: 10px;
    padding: 10px 14px;
    margin-bottom: 16px;
}

@media print {

    .main-sidebar,
    .main-header,
    .main-footer,
    .ar-no-print {
        display: none !important;
    }

    .content-wrapper {
        margin: 0 !important;
        background: #fff !important;
    }

    .ar-items.d-none {
        display: table-row !important;
    }

    .ar-card,
    .ar-tile {
        box-shadow: none !important;
    }
}
</style>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 font-weight-bold" style="color: var(--satraco-dark)">Archives des demandes d'achat</h1>
            <small class="text-muted">Registre complet des demandes, de leurs articles et de leurs paiements</small>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <?php if ($manquePrix): ?>
            <div class="ar-warn ar-no-print">
                <i class="fas fa-info-circle mr-1"></i>
                Certaines colonnes de <code>purchase_request_items</code> n'ont pas été détectées
                (<?= !isset($colsItems['designation']) ? 'désignation' : '' ?><?= !isset($colsItems['designation']) && !isset($colsItems['pu']) ? ', ' : '' ?><?= !isset($colsItems['pu']) ? 'prix unitaire' : '' ?>).
                Le détail des articles peut être incomplet.
            </div>
            <?php endif; ?>

            <!-- ============ FILTRES ============ -->
            <form method="get" class="ar-card ar-filters ar-no-print">
                <div class="ar-grid">
                    <div class="wide">
                        <label>Rechercher</label>
                        <input type="search" name="q" class="form-control form-control-sm"
                            value="<?= html_escape($f['q']) ?>"
                            placeholder="N° (DA-0012), chantier, demandeur, article, n° de bon…">
                    </div>
                    <div>
                        <label>Du</label>
                        <input type="date" name="du" class="form-control form-control-sm"
                            value="<?= html_escape($f['du']) ?>">
                    </div>
                    <div>
                        <label>Au</label>
                        <input type="date" name="au" class="form-control form-control-sm"
                            value="<?= html_escape($f['au']) ?>">
                    </div>
                    <div>
                        <label>Chantier</label>
                        <select name="chantier" class="form-control form-control-sm">
                            <option value="">Tous</option>
                            <?php foreach ($listeChantiers as $c): ?>
                            <option value="<?= (int) $c['id'] ?>"
                                <?= (int) $c['id'] === $f['chantier'] ? 'selected' : '' ?>>
                                <?= html_escape($c['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Décision DG</label>
                        <select name="dg" class="form-control form-control-sm">
                            <option value="">Toutes</option>
                            <option value="en_attente" <?= $f['dg'] === 'en_attente' ? 'selected' : '' ?>>En attente
                            </option>
                            <option value="approuve" <?= $f['dg'] === 'approuve' ? 'selected' : '' ?>>Validée</option>
                            <option value="rejete" <?= $f['dg'] === 'rejete' ? 'selected' : '' ?>>Rejetée</option>
                        </select>
                    </div>
                    <div>
                        <label>Paiement</label>
                        <select name="paiement" class="form-control form-control-sm">
                            <option value="">Tous</option>
                            <?php foreach ($paiementLbl as $k => $l): ?>
                            <option value="<?= $k ?>" <?= $f['paiement'] === $k ? 'selected' : '' ?>><?= $l ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Workflow</label>
                        <select name="workflow" class="form-control form-control-sm">
                            <option value="">Tous</option>
                            <?php foreach ($options['workflows'] as $w): ?>
                            <option value="<?= html_escape($w) ?>" <?= $f['workflow'] === $w ? 'selected' : '' ?>>
                                <?= html_escape($nice($w)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Catégorie</label>
                        <select name="categorie" class="form-control form-control-sm">
                            <option value="">Toutes</option>
                            <?php foreach ($options['categories'] as $c): ?>
                            <option value="<?= html_escape($c) ?>" <?= $f['categorie'] === $c ? 'selected' : '' ?>>
                                <?= html_escape($nice($c)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="par_page" value="<?= (int) $parPage ?>">
                <div class="ar-actions">
                    <button type="submit" class="btn btn-sm btn-ar btn-ar-green"><i class="fas fa-filter mr-1"></i>
                        Filtrer</button>
                    <?php if ($filtresActifs): ?>
                    <a href="<?= current_url() ?>" class="btn btn-sm btn-ar btn-ar-light"><i
                            class="fas fa-times mr-1"></i> Réinitialiser</a>
                    <?php endif; ?>
                    <div class="ml-auto d-flex" style="gap:8px">
                        <a href="<?= $url(['export' => 'xlsx', 'page' => null]) ?>"
                            class="btn btn-sm btn-ar btn-ar-excel">
                            <i class="fas fa-file-excel mr-1"></i> Exporter en Excel (<?= (int) $total ?>)
                        </a>
                        <button type="button" class="btn btn-sm btn-ar btn-ar-light" onclick="window.print()"><i
                                class="fas fa-print mr-1"></i> Imprimer</button>
                    </div>
                </div>
            </form>

            <!-- ============ SYNTHÈSE ============ -->
            <div class="ar-tiles">
                <div class="ar-tile dark"><span>Demandes</span><b><?= (int) $t['nb'] ?></b></div>
                <div class="ar-tile"><span>Articles</span><b><?= (int) $t['nb_articles'] ?></b></div>
                <div class="ar-tile"><span>Montant total demandé</span><b><?= $fmt($t['total']) ?>
                        <small>BIF</small></b></div>
                <div class="ar-tile"><span>Montant payé</span><b class="text-success"><?= $fmt($t['paye']) ?>
                        <small>BIF</small></b></div>
                <div class="ar-tile"><span>Reste à payer</span><b class="text-danger"><?= $fmt($t['reste']) ?>
                        <small>BIF</small></b></div>
            </div>

            <!-- ============ REGISTRE ============ -->
            <div class="ar-card">
                <div class="ar-card-head">
                    <h3><i class="fas fa-archive"></i> Registre des demandes</h3>
                    <div class="d-flex align-items-center ar-no-print" style="gap:10px">
                        <?php if ($rows): ?>
                        <button type="button" class="btn btn-sm btn-ar btn-ar-light" id="arToggleAll"><i
                                class="fas fa-expand-alt mr-1"></i> Tous les articles</button>
                        <?php endif; ?>
                        <select class="form-control form-control-sm" style="width:auto;border-radius:10px"
                            onchange="location.href=this.value">
                            <?php foreach ([25, 50, 100] as $n): ?>
                            <option value="<?= $url(['par_page' => $n, 'page' => 1]) ?>"
                                <?= $parPage === $n ? 'selected' : '' ?>><?= $n ?> par page</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="ar-card-body">
                    <?php if (empty($rows)): ?>
                    <div class="ar-empty"><i class="fas fa-search"></i>Aucune demande ne correspond à ces critères.
                    </div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="ar-table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Date</th>
                                    <th>Chantier</th>
                                    <th>Catégorie</th>
                                    <th>Demandeur / Acheteur</th>
                                    <th class="text-right">Montant (BIF)</th>
                                    <th>Décision DG</th>
                                    <th>Workflow</th>
                                    <th>Paiement</th>
                                    <th>Bon de paiement</th>
                                    <th class="ar-no-print"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $r):
                                        $its = $items[$r['id']] ?? [];
                                        $totItems = array_sum(array_map(function ($i) {
                                            return (float) $i['total'];
                                        }, $its));
                                        $ecart = $its ? round((float) $r['total_amount'] - $totItems) : 0;
                                    ?>
                                <tr class="main">
                                    <td class="ref"><?= html_escape($r['reference']) ?></td>
                                    <td style="white-space:nowrap"><?= $dfr($r['date_demande']) ?></td>
                                    <td>
                                        <b><?= html_escape($r['chantier_nom'] ?: ($r['destination_chantier'] ?: '—')) ?></b>
                                        <?php if ($r['chantier_nom'] && $r['destination_chantier'] && $r['destination_chantier'] !== $r['chantier_nom']): ?>
                                        <br><small
                                            class="text-muted"><?= html_escape($r['destination_chantier']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= html_escape($nice($r['category_type'])) ?></td>
                                    <td>
                                        <?= html_escape($r['requested_by'] ?: '—') ?>
                                        <?php if ($r['buyer_name']): ?><br><small class="text-muted">Achat :
                                            <?= html_escape($r['buyer_name']) ?></small><?php endif; ?>
                                    </td>
                                    <td class="text-right font-weight-bold"><?= $fmt($r['total_amount']) ?></td>
                                    <td><span
                                            class="badge badge-<?= $dgBadge($r['dg_status']) ?>"><?= html_escape($nice($r['dg_status'])) ?></span>
                                    </td>
                                    <td><small><?= html_escape($nice($r['workflow_status'])) ?></small></td>
                                    <td>
                                        <span
                                            class="badge badge-<?= $paiementBadge[$r['payment_status']] ?? 'secondary' ?>">
                                            <?= $paiementLbl[$r['payment_status']] ?? html_escape($nice($r['payment_status'])) ?>
                                        </span>
                                        <?php if ($r['paye'] > 0): ?><br><small
                                            class="text-muted"><?= $fmt($r['paye']) ?></small><?php endif; ?>
                                    </td>
                                    <td><small><?= html_escape($r['numeros'] ?: '—') ?></small></td>
                                    <td class="ar-no-print text-right">
                                        <button type="button" class="btn-items"
                                            data-target="ar-it-<?= (int) $r['id'] ?>">
                                            <i class="fas fa-list mr-1"></i><?= (int) $r['nb_articles'] ?>
                                            article<?= $r['nb_articles'] > 1 ? 's' : '' ?>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="ar-items d-none" id="ar-it-<?= (int) $r['id'] ?>">
                                    <td colspan="11">
                                        <?php if (empty($its)): ?>
                                        <small class="text-muted"><i class="fas fa-info-circle"></i> Aucun article
                                            enregistré pour cette demande.</small>
                                        <?php else: ?>
                                        <table class="ar-sub">
                                            <thead>
                                                <tr>
                                                    <th style="width:40px">#</th>
                                                    <th>Désignation</th>
                                                    <th class="text-right">Quantité</th>
                                                    <th>Unité</th>
                                                    <th class="text-right">Prix unitaire (BIF)</th>
                                                    <th class="text-right">Prix total (BIF)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($its as $n => $it): ?>
                                                <tr>
                                                    <td><?= $n + 1 ?></td>
                                                    <td><?= html_escape($it['designation'] ?: '—') ?></td>
                                                    <td class="text-right"><?= $qte($it['quantite']) ?></td>
                                                    <td><?= html_escape($it['unite'] ?: '—') ?></td>
                                                    <td class="text-right"><?= $fmt($it['pu']) ?></td>
                                                    <td class="text-right font-weight-bold"><?= $fmt($it['total']) ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-right">Total des articles</td>
                                                    <td class="text-right"><?= $fmt($totItems) ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <?php if (abs($ecart) >= 1): ?>
                                        <small class="text-warning font-weight-bold d-block mt-2">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Écart de <?= $fmt($ecart) ?> BIF entre le montant de la demande et le total
                                            de ses articles.
                                        </small>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="ar-pager ar-no-print">
                        <span>Demandes <?= $debutLigne ?> à <?= $finLigne ?> sur <?= (int) $total ?></span>
                        <?php if ($pages > 1): ?>
                        <ul class="pagination pagination-sm">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $url(['page' => $page - 1]) ?>">&laquo;</a>
                            </li>
                            <?php
                                    $debut = max(1, $page - 2);
                                    $fin   = min($pages, $page + 2);
                                    if ($debut > 1): ?>
                            <li class="page-item"><a class="page-link" href="<?= $url(['page' => 1]) ?>">1</a></li>
                            <?php if ($debut > 2): ?><li class="page-item disabled"><span class="page-link">…</span>
                            </li><?php endif; ?>
                            <?php endif;
                                    for ($i = $debut; $i <= $fin; $i++): ?>
                            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?= $url(['page' => $i]) ?>"><?= $i ?></a>
                            </li>
                            <?php endfor;
                                    if ($fin < $pages): ?>
                            <?php if ($fin < $pages - 1): ?><li class="page-item disabled"><span
                                    class="page-link">…</span></li><?php endif; ?>
                            <li class="page-item"><a class="page-link"
                                    href="<?= $url(['page' => $pages]) ?>"><?= $pages ?></a></li>
                            <?php endif; ?>
                            <li class="page-item <?= $page >= $pages ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $url(['page' => $page + 1]) ?>">&raquo;</a>
                            </li>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
(function() {
    // Déplier / replier les articles d'une demande
    document.querySelectorAll('.btn-items').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var row = document.getElementById(btn.dataset.target);
            if (!row) return;
            row.classList.toggle('d-none');
            btn.classList.toggle('open', !row.classList.contains('d-none'));
        });
    });

    // Tout déplier / replier
    var all = document.getElementById('arToggleAll');
    if (all) {
        var ouvert = false;
        all.addEventListener('click', function() {
            ouvert = !ouvert;
            document.querySelectorAll('.ar-items').forEach(function(r) {
                r.classList.toggle('d-none', !ouvert);
            });
            document.querySelectorAll('.btn-items').forEach(function(b) {
                b.classList.toggle('open', ouvert);
            });
            all.innerHTML = ouvert ?
                '<i class="fas fa-compress-alt mr-1"></i> Replier' :
                '<i class="fas fa-expand-alt mr-1"></i> Tous les articles';
        });
    }
})();
</script>