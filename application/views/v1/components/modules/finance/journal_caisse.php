<?php
/* ================== Journal de caisse ================== */
$caisseUrl  = base_url('finance-caisse');           // ⚠️ mets ici l'URL de ta page Caisse
$journalUrl = base_url('finance-journal-caisse');

$fmt = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$f = $filters;
$p = $pagination;

$url = function (array $override = []) use ($f, $p, $journalUrl) {
    $params = array_filter(
        array_merge($f, ['per_page' => $p['per_page']], $override),
        function ($v) {
            return $v !== null && $v !== '';
        }
    );
    return $journalUrl . ($params ? '?' . http_build_query($params) : '');
};
$exportUrl = $journalUrl . '/export' . (array_filter($f) ? '?' . http_build_query(array_filter($f)) : '');
$hasFilter = (bool) array_filter($f);

$statutBadge = function ($s) {
    $map = [
        'valide'     => ['Validé', 'jc-badge-success'],
        'en_attente' => ['En attente', 'jc-badge-warning'],
        'annule'     => ['Annulé', 'jc-badge-danger'],
    ];
    $b = $map[strtolower((string) $s)] ?? [ucfirst($s ?: '—'), 'jc-badge-muted'];
    return '<span class="jc-badge ' . $b[1] . '">' . html_escape($b[0]) . '</span>';
};
?>

<style>
/* ====== Palette alignée sur la page Caisse ====== */
.jc-wrap {
    --jc-primary: var(--caisse-primary, #1c7c6c);
    --jc-primary-dark: #145c50;
    --jc-primary-soft: rgba(28, 124, 108, .08);
    --jc-success: #28a745;
    --jc-danger: #dc3545;
    --jc-danger-soft: #fdecee;
    --jc-success-soft: #e8f6ec;
    --jc-warning: #f0ad4e;
    --jc-border: #e9edf1;
    --jc-text: #1f2d3d;
    --jc-muted: #6c7a89;
    font-size: 13px;
    color: var(--jc-text);
}

/* Cartes */
.jc-card {
    background: #fff;
    border: 1px solid var(--jc-border);
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(16, 24, 40, .05);
    margin-bottom: 22px;
    overflow: hidden;
}

.jc-card-header {
    padding: 20px 22px;
    border-bottom: 1px solid var(--jc-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.jc-card-title {
    margin: 0;
    font-size: 17px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}

.jc-card-title i {
    color: var(--jc-primary);
}

.jc-card-subtitle {
    margin: 4px 0 0;
    font-size: 12px;
    color: var(--jc-muted);
}

.jc-card-body {
    padding: 18px 22px;
}

/* Statistiques */
.jc-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 18px;
    margin-bottom: 22px;
}

.jc-stat {
    background: #fff;
    border: 1px solid var(--jc-border);
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(16, 24, 40, .05);
    padding: 18px 20px;
    display: flex;
    gap: 14px;
    align-items: center;
}

.jc-stat-icon {
    width: 48px;
    height: 48px;
    flex: 0 0 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.jc-stat-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--jc-muted);
    text-transform: uppercase;
    letter-spacing: .05em;
}

.jc-stat-value {
    font-size: 20px;
    font-weight: 700;
    line-height: 1.3;
}

.jc-stat-value small {
    font-size: 11px;
    font-weight: 600;
    color: var(--jc-muted);
}

.jc-ic-primary {
    background: var(--jc-primary-soft);
    color: var(--jc-primary);
}

.jc-ic-success {
    background: var(--jc-success-soft);
    color: var(--jc-success);
}

.jc-ic-danger {
    background: var(--jc-danger-soft);
    color: var(--jc-danger);
}

.jc-ic-warning {
    background: #fff5e6;
    color: #d18a12;
}

/* Filtres */
.jc-filters label {
    font-size: 11px;
    font-weight: 700;
    color: var(--jc-muted);
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 6px;
}

.jc-filters .form-control {
    height: 40px;
    border-radius: 10px;
    border-color: var(--jc-border);
    font-size: 13px;
}

.jc-filters .form-control:focus {
    border-color: var(--jc-primary);
    box-shadow: 0 0 0 3px var(--jc-primary-soft);
}

.jc-filters .form-control-sm {
    height: 32px;
}

.jc-filters-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 8px;
    padding-top: 14px;
    border-top: 1px dashed var(--jc-border);
}

/* Boutons (même style que « Voir tout le journal ») */
.btn-jc,
.btn-jc-outline,
.btn-jc-light {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    height: 40px;
    padding: 0 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    transition: all .15s;
}

.btn-jc {
    background: var(--jc-primary);
    border: 1px solid var(--jc-primary);
    color: #fff;
}

.btn-jc:hover {
    background: var(--jc-primary-dark);
    border-color: var(--jc-primary-dark);
    color: #fff;
}

.btn-jc-outline {
    background: #fff;
    border: 1px solid #cfe3de;
    color: var(--jc-primary);
}

.btn-jc-outline:hover {
    background: var(--jc-primary-soft);
    border-color: var(--jc-primary);
    color: var(--jc-primary);
}

.btn-jc-light {
    background: #f4f6f8;
    border: 1px solid var(--jc-border);
    color: var(--jc-muted);
}

.btn-jc-light:hover {
    background: #e9edf1;
    color: var(--jc-text);
}

/* Tableau (identique à « Mouvements récents ») */
.jc-table {
    margin: 0;
    font-size: 12.5px;
}

.jc-table thead th {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .03em;
    color: #3d4b5c;
    background: #fafbfc;
    border-top: 0;
    border-bottom: 1px solid var(--jc-border);
    padding: 14px 12px;
    white-space: nowrap;
    vertical-align: middle;
}

.jc-table td {
    padding: 16px 12px;
    border-top: 1px solid var(--jc-border);
    vertical-align: middle;
}

.jc-table tbody tr:hover {
    background: #fafcfc;
}

.jc-table .text-right {
    white-space: nowrap;
}

.jc-ref {
    font-weight: 700;
    white-space: nowrap;
}

.jc-caisse {
    font-weight: 700;
    text-transform: uppercase;
    white-space: nowrap;
}

.jc-sub {
    font-size: 11px;
    color: var(--jc-muted);
    margin-top: 2px;
}

.jc-amount {
    font-weight: 700;
}

.jc-dash {
    color: var(--jc-muted);
}

.jc-type {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.jc-type-in {
    background: var(--jc-success-soft);
    color: var(--jc-success);
}

.jc-type-out {
    background: var(--jc-danger-soft);
    color: var(--jc-danger);
}

.jc-in {
    color: var(--jc-success);
}

.jc-out {
    color: var(--jc-danger);
}

.jc-badge {
    display: inline-block;
    padding: 2px 7px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    color: #fff;
}

.jc-badge-success {
    background: var(--jc-success);
}

.jc-badge-warning {
    background: var(--jc-warning);
}

.jc-badge-danger {
    background: var(--jc-danger);
}

.jc-badge-muted {
    background: #adb5bd;
}

.jc-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: 1px solid var(--jc-border);
    background: #fff;
    color: var(--jc-primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 2px;
    transition: all .15s;
}

.jc-action.js-jc-print {
    color: var(--jc-text);
}

.jc-action:hover {
    background: var(--jc-primary-soft);
    border-color: var(--jc-primary);
}

/* Pied de tableau / pagination */
.jc-footer {
    padding: 16px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    border-top: 1px solid var(--jc-border);
    color: var(--jc-muted);
    font-size: 13px;
}

.jc-pagination .page-link {
    color: var(--jc-primary);
    border: 1px solid var(--jc-border);
    border-radius: 8px !important;
    margin: 0 2px;
    min-width: 34px;
    text-align: center;
}

.jc-pagination .page-item.active .page-link {
    background: var(--jc-primary);
    border-color: var(--jc-primary);
    color: #fff;
}

.jc-pagination .page-item.disabled .page-link {
    color: #c0c8d0;
}

.jc-empty {
    padding: 50px 20px;
    text-align: center;
    color: var(--jc-muted);
}

/* Modal détail */
#jcDetailModal .modal-content {
    border-radius: 14px;
    border: 0;
}

#jcDetailModal .modal-header {
    border-bottom: 1px solid #e9edf1;
}

#jcDetailModal .modal-title {
    font-size: 16px;
    font-weight: 700;
}

.jc-detail dt {
    font-size: 11px;
    color: #6c7a89;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.jc-detail dd {
    margin-bottom: 14px;
    font-weight: 600;
}

@media print {

    .main-sidebar,
    .main-header,
    .main-footer,
    .jc-filters,
    .jc-no-print,
    .jc-pagination {
        display: none !important;
    }

    .content-wrapper {
        margin-left: 0 !important;
    }

    .jc-card,
    .jc-stat {
        box-shadow: none;
    }
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Journal Caisse</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $caisseUrl ?>">Caisse</a></li>
                        <li class="breadcrumb-item active">Journal Caisse</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="jc-wrap">

                <!-- ===== Statistiques ===== -->
                <div class="jc-stats">
                    <div class="jc-stat">
                        <div class="jc-stat-icon jc-ic-primary"><i class="fas fa-list"></i></div>
                        <div>
                            <div class="jc-stat-label">Opérations</div>
                            <div class="jc-stat-value"><?= $fmt($totaux->nb_operations) ?></div>
                        </div>
                    </div>
                    <div class="jc-stat">
                        <div class="jc-stat-icon jc-ic-success"><i class="fas fa-arrow-down"></i></div>
                        <div>
                            <div class="jc-stat-label">Total entrées</div>
                            <div class="jc-stat-value jc-in"><?= $fmt($totaux->total_entrees) ?> <small>BIF</small>
                            </div>
                        </div>
                    </div>
                    <div class="jc-stat">
                        <div class="jc-stat-icon jc-ic-danger"><i class="fas fa-arrow-up"></i></div>
                        <div>
                            <div class="jc-stat-label">Total sorties</div>
                            <div class="jc-stat-value jc-out"><?= $fmt($totaux->total_sorties) ?> <small>BIF</small>
                            </div>
                        </div>
                    </div>
                    <div class="jc-stat">
                        <div class="jc-stat-icon jc-ic-warning"><i class="fas fa-balance-scale"></i></div>
                        <div>
                            <div class="jc-stat-label">Solde net <?= $hasFilter ? '(filtré)' : '(global)' ?></div>
                            <div class="jc-stat-value <?= $totaux->solde_net < 0 ? 'jc-out' : 'jc-in' ?>">
                                <?= ($totaux->solde_net < 0 ? '- ' : '') . $fmt(abs($totaux->solde_net)) ?>
                                <small>BIF</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== Filtres ===== -->
                <div class="jc-card jc-filters">
                    <div class="jc-card-body">
                        <form method="get" action="<?= $journalUrl ?>">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label>Recherche</label>
                                    <input type="text" name="q" class="form-control"
                                        placeholder="Réf., libellé, bénéficiaire, DA..."
                                        value="<?= html_escape($f['q']) ?>">
                                </div>
                                <div class="col-lg-2 col-md-6 mb-3">
                                    <label>Caisse</label>
                                    <select name="caisse_id" class="form-control">
                                        <option value="">Toutes</option>
                                        <?php foreach ($caisses as $ca): ?>
                                        <option value="<?= $ca->id ?>"
                                            <?= $f['caisse_id'] == $ca->id ? 'selected' : '' ?>>
                                            <?= html_escape($ca->nom) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <label>Type</label>
                                    <select name="type" class="form-control">
                                        <option value="">Tous</option>
                                        <option value="entree" <?= $f['type'] === 'entree' ? 'selected' : '' ?>>Entrées
                                        </option>
                                        <option value="sortie" <?= $f['type'] === 'sortie' ? 'selected' : '' ?>>Sorties
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <label>Chantier</label>
                                    <select name="chantier_id" class="form-control">
                                        <option value="">Tous</option>
                                        <?php foreach ($chantiers as $ch): ?>
                                        <option value="<?= $ch->id ?>"
                                            <?= $f['chantier_id'] == $ch->id ? 'selected' : '' ?>>
                                            <?= html_escape($ch->nom) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-4 mb-3">
                                    <label>Période</label>
                                    <div class="d-flex" style="gap:8px">
                                        <input type="date" name="date_debut" class="form-control"
                                            value="<?= html_escape($f['date_debut']) ?>">
                                        <input type="date" name="date_fin" class="form-control"
                                            value="<?= html_escape($f['date_fin']) ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="jc-filters-actions">
                                <div class="d-flex align-items-center" style="gap:8px">
                                    <label class="mb-0">Afficher</label>
                                    <select name="per_page" class="form-control form-control-sm" style="width:80px"
                                        onchange="this.form.submit()">
                                        <?php foreach ([10, 25, 50, 100] as $n): ?>
                                        <option value="<?= $n ?>" <?= $p['per_page'] == $n ? 'selected' : '' ?>>
                                            <?= $n ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="d-flex" style="gap:8px">
                                    <a href="<?= $journalUrl ?>" class="btn btn-jc-light"><i class="fas fa-undo"></i>
                                        Réinitialiser</a>
                                    <button type="submit" class="btn btn-jc"><i class="fas fa-filter"></i>
                                        Filtrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ===== Tableau ===== -->
                <div class="jc-card">
                    <div class="jc-card-header">
                        <div>
                            <h5 class="jc-card-title"><i class="fas fa-exchange-alt"></i> Toutes les opérations de
                                caisse</h5>
                            <p class="jc-card-subtitle">Encaissements (principale), approvisionnements et paiements DA
                                (secondaire).</p>
                        </div>
                        <div class="d-flex flex-wrap jc-no-print" style="gap:8px">
                            <a href="<?= $caisseUrl ?>" class="btn btn-jc-outline"><i class="fas fa-arrow-left"></i>
                                Retour caisse</a>
                            <button type="button" class="btn btn-jc-outline" onclick="window.print()"><i
                                    class="fas fa-print"></i> Imprimer</button>
                            <a href="<?= $exportUrl ?>" class="btn btn-jc"><i class="fas fa-file-excel"></i> Export
                                Excel</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table jc-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Référence</th>
                                    <th>Caisse</th>
                                    <th>Type</th>
                                    <th>Libellé / Bénéficiaire</th>
                                    <th class="text-right">Entrée</th>
                                    <th class="text-right">Sortie</th>
                                    <th class="text-right">Solde après</th>
                                    <th>Statut</th>
                                    <th class="text-center jc-no-print">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($operations)): ?>
                                <tr>
                                    <td colspan="11">
                                        <div class="jc-empty"><i class="fas fa-inbox fa-2x mb-2"></i><br>Aucune
                                            opération trouvée pour ces critères.</div>
                                    </td>
                                </tr>
                                <?php else: foreach ($operations as $i => $op): ?>
                                <tr>
                                    <td><?= $p['from'] + $i ?></td>
                                    <td style="white-space:nowrap">
                                        <?= date('d/m/Y', strtotime($op->date_operation)) ?>
                                        <div class="jc-sub"><?= date('H:i', strtotime($op->date_operation)) ?></div>
                                    </td>
                                    <td class="jc-ref"><?= html_escape($op->reference) ?></td>
                                    <td>
                                        <div class="jc-caisse"><?= html_escape($op->caisse_nom) ?></div>
                                        <div class="jc-sub"><?= html_escape($op->caisse_code) ?></div>
                                    </td>
                                    <td>
                                        <?php if ($op->is_entree): ?>
                                        <span class="jc-type jc-type-in"><i class="fas fa-arrow-down"></i> Entrée</span>
                                        <?php else: ?>
                                        <span class="jc-type jc-type-out"><i class="fas fa-arrow-up"></i> Sortie</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= html_escape($op->libelle ?: ($op->da_reference ? 'Paiement ' . $op->da_reference : '—')) ?></strong>
                                        <?php if ($op->beneficiaire): ?>
                                        <div class="jc-sub">Bénéficiaire : <?= html_escape(trim($op->beneficiaire)) ?>
                                        </div>
                                        <?php endif; ?>
                                        <?php if ($op->chantier_nom && trim($op->chantier_nom) !== trim((string) $op->beneficiaire)): ?>
                                        <div class="jc-sub"><i class="fas fa-hard-hat"></i>
                                            <?= html_escape($op->chantier_nom) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <?= $op->is_entree ? '<span class="jc-amount jc-in">+ ' . $fmt($op->montant) . '</span>' : '<span class="jc-dash">—</span>' ?>
                                    </td>
                                    <td class="text-right">
                                        <?= !$op->is_entree ? '<span class="jc-amount">- ' . $fmt($op->montant) . '</span>' : '<span class="jc-dash">—</span>' ?>
                                    </td>
                                    <td class="text-right">
                                        <span class="jc-amount"><?= $fmt($op->solde_apres) ?></span>
                                        <div class="jc-sub">BIF</div>
                                    </td>
                                    <td><?= $statutBadge($op->statut) ?></td>
                                    <td class="text-center jc-no-print" style="white-space:nowrap">
                                        <button type="button" class="jc-action js-jc-detail"
                                            data-id="<?= html_escape($op->uid) ?>" title="Voir le détail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="jc-action js-jc-print"
                                            data-id="<?= html_escape($op->uid) ?>" title="Imprimer le bon">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="jc-footer">
                        <span>Affichage de <?= $p['from'] ?> à <?= $p['to'] ?> sur <?= $fmt($p['total']) ?>
                            opérations</span>
                        <?php if ($p['nb_pages'] > 1): ?>
                        <ul class="pagination pagination-sm mb-0 jc-pagination">
                            <li class="page-item <?= $p['page'] <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $url(['page' => $p['page'] - 1]) ?>">&laquo;</a>
                            </li>
                            <?php
                                $start = max(1, $p['page'] - 2);
                                $end   = min($p['nb_pages'], $p['page'] + 2);
                                if ($start > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="' . $url(['page' => 1]) . '">1</a></li>';
                                    if ($start > 2) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                                }
                                for ($n = $start; $n <= $end; $n++) {
                                    echo '<li class="page-item ' . ($n == $p['page'] ? 'active' : '') . '"><a class="page-link" href="' . $url(['page' => $n]) . '">' . $n . '</a></li>';
                                }
                                if ($end < $p['nb_pages']) {
                                    if ($end < $p['nb_pages'] - 1) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                                    echo '<li class="page-item"><a class="page-link" href="' . $url(['page' => $p['nb_pages']]) . '">' . $p['nb_pages'] . '</a></li>';
                                }
                                ?>
                            <li class="page-item <?= $p['page'] >= $p['nb_pages'] ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $url(['page' => $p['page'] + 1]) ?>">&raquo;</a>
                            </li>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>

            </div><!-- /.jc-wrap -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- ===== Modal détail ===== -->
<div class="modal fade" id="jcDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-receipt"></i> Détail de l'opération <span id="jcRef"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="jcDetailBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success" id="jcPrintBtn"><i class="fas fa-print"></i>
                    Imprimer</button>
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    (function($) {
        var detailUrl = '<?= $journalUrl ?>/detail/';
        var current = null;

        function esc(v) {
            return $('<div>').text(v == null || v === '' ? '—' : v).html();
        }

        function money(v) {
            return Number(v || 0).toLocaleString('fr-FR').replace(/ | /g, ' ') + ' BIF';
        }

        function dateFr(v) {
            if (!v) return '—';
            var d = new Date(v.replace(' ', 'T'));
            return d.toLocaleDateString('fr-FR') + ' ' + d.toLocaleTimeString('fr-FR', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function render(op) {
            var entree = op.is_entree == 1,
                cls = entree ? 'jc-in' : 'jc-out';
            var statut = {
                valide: 'Validé',
                en_attente: 'En attente',
                annule: 'Annulé'
            } [op.statut] || op.statut;
            return '<dl class="row jc-detail mb-0">' +
                '<div class="col-md-6"><dt>Référence</dt><dd>' + esc(op.reference) + '</dd></div>' +
                '<div class="col-md-6"><dt>Date</dt><dd>' + esc(dateFr(op.date_operation)) + '</dd></div>' +
                '<div class="col-md-6"><dt>Caisse</dt><dd>' + esc(op.caisse_nom) +
                ' <small class="text-muted">' + esc(op.caisse_code) + '</small></dd></div>' +
                '<div class="col-md-6"><dt>Type</dt><dd class="' + cls + '">' + (entree ? 'Entrée' :
                    'Sortie') + ' — ' + esc(op.nature) + '</dd></div>' +
                '<div class="col-md-6"><dt>Montant</dt><dd class="' + cls + '">' + (entree ? '+ ' : '- ') +
                money(op.montant) + '</dd></div>' +
                '<div class="col-md-6"><dt>Solde avant → après</dt><dd>' + money(op.solde_avant) + ' → ' +
                money(op.solde_apres) + '</dd></div>' +
                '<div class="col-md-12"><dt>Libellé</dt><dd>' + esc(op.libelle) + '</dd></div>' +
                '<div class="col-md-6"><dt>Bénéficiaire / Tiers</dt><dd>' + esc(op.beneficiaire) +
                '</dd></div>' +
                '<div class="col-md-6"><dt>Demande d\'achat</dt><dd>' + esc(op.da_reference) +
                '</dd></div>' +
                '<div class="col-md-6"><dt>Chantier</dt><dd>' + esc(op.chantier_nom) + '</dd></div>' +
                '<div class="col-md-6"><dt>N° pièce</dt><dd>' + esc(op.document_number) + '</dd></div>' +
                '<div class="col-md-6"><dt>Statut</dt><dd>' + esc(statut) + '</dd></div>' +
                '<div class="col-md-6"><dt>Créé par</dt><dd>' + esc(op.cree_par) + '</dd></div>' +
                '<div class="col-md-12"><dt>Observation</dt><dd>' + esc(op.observation) + '</dd></div>' +
                '</dl>';
        }

        function loadDetail(id, cb) {
            $.getJSON(detailUrl + encodeURIComponent(id))
                .done(function(res) {
                    cb(res && res.success ? res.data : null);
                })
                .fail(function() {
                    cb(null);
                });
        }

        function printOp(op) {
            var w = window.open('', '_blank', 'width=800,height=700');
            w.document.write('<html><head><title>Bon ' + esc(op.reference) + '</title>' +
                '<style>body{font-family:Arial,sans-serif;padding:30px;color:#1f2d3d}h2{margin:0 0 4px}' +
                'table{width:100%;border-collapse:collapse;margin-top:20px}td{padding:8px;border:1px solid #ddd}' +
                'td:first-child{width:35%;font-weight:bold;background:#f7f7f7}.sign{display:flex;justify-content:space-between;margin-top:60px}</style>' +
                '</head><body><h2>SATRACO Construction</h2><div>Bon de caisse — ' + (op.is_entree == 1 ?
                    'Entrée' : 'Sortie') + '</div><table>' +
                '<tr><td>Référence</td><td>' + esc(op.reference) + '</td></tr>' +
                '<tr><td>Date</td><td>' + esc(dateFr(op.date_operation)) + '</td></tr>' +
                '<tr><td>Caisse</td><td>' + esc(op.caisse_nom) + ' (' + esc(op.caisse_code) +
                ')</td></tr>' +
                '<tr><td>Libellé</td><td>' + esc(op.libelle) + '</td></tr>' +
                '<tr><td>Bénéficiaire</td><td>' + esc(op.beneficiaire) + '</td></tr>' +
                '<tr><td>DA / Chantier</td><td>' + esc(op.da_reference) + ' / ' + esc(op.chantier_nom) +
                '</td></tr>' +
                '<tr><td>N° pièce</td><td>' + esc(op.document_number) + '</td></tr>' +
                '<tr><td>Montant</td><td><strong>' + money(op.montant) + '</strong></td></tr>' +
                '<tr><td>Solde après</td><td>' + money(op.solde_apres) + '</td></tr>' +
                '</table><div class="sign"><div>Le caissier</div><div>Le bénéficiaire</div><div>Visa DAF</div></div>' +
                '<script>window.onload=function(){window.print();}<\/script></body></html>');
            w.document.close();
        }

        $(document).on('click', '.js-jc-detail', function() {
            current = null;
            $('#jcRef').text('');
            $('#jcDetailBody').html(
                '<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Chargement…</div>'
                );
            $('#jcDetailModal').modal('show');
            loadDetail($(this).data('id'), function(op) {
                if (!op) {
                    $('#jcDetailBody').html(
                        '<div class="alert alert-danger mb-0">Impossible de charger cette opération.</div>'
                        );
                    return;
                }
                current = op;
                $('#jcRef').text(op.reference);
                $('#jcDetailBody').html(render(op));
            });
        });

        $(document).on('click', '.js-jc-print', function() {
            loadDetail($(this).data('id'), function(op) {
                if (op) printOp(op);
            });
        });

        $('#jcPrintBtn').on('click', function() {
            if (current) printOp(current);
        });
    })(jQuery);
});
</script>