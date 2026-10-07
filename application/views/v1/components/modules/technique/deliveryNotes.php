<?php
$e = function ($s) {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
};
$fd = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '';
};
$statusBadge = function ($s) {
    if ($s === 'livre')   return '<span class="badge badge-success">Livrée</span>';
    if ($s === 'partiel') return '<span class="badge badge-warning">Partielle</span>';
    return '<span class="badge badge-secondary">Non livrée</span>';
};
$pageUrl = function ($p) use ($filters) {
    $q = array_filter([
        'date_from' => $filters['date_from'],
        'date_to'   => $filters['date_to'],
        'q'         => $filters['q'],
        'page'      => $p,
    ]);
    return base_url('stock-delivery-notes') . '?' . http_build_query($q);
};
?>
<style>
.dn-table td,
.dn-table th {
    vertical-align: middle;
}

.dn-table .btn-xs {
    padding: .15rem .45rem;
}

#dnDetailModal dl dt {
    font-weight: 600;
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
                        <li class="breadcrumb-item"><a href="<?= base_url('stock-general') ?>">Stocks</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- STATISTIQUES -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= (int) $stats['bl_month'] ?></h3>
                            <p>Bons de livraison ce mois</p>
                        </div>
                        <div class="icon"><i class="fas fa-truck-loading"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= (int) $stats['da_livre'] ?></h3>
                            <p>DA entièrement livrées</p>
                        </div>
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= (int) $stats['da_partiel'] ?></h3>
                            <p>DA livrées partiellement</p>
                        </div>
                        <div class="icon"><i class="fas fa-adjust"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= (int) $stats['da_non_livre'] ?></h3>
                            <p>DA payées non livrées</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                </div>
            </div>

            <!-- FILTRES -->
            <div class="card card-outline card-dark">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filtrage</h3>
                </div>
                <form method="get" action="<?= base_url('stock-delivery-notes') ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <label>Du</label>
                                <input type="date" name="date_from" class="form-control"
                                    value="<?= $e($filters['date_from']) ?>">
                            </div>
                            <div class="col-md-2 form-group">
                                <label>Au</label>
                                <input type="date" name="date_to" class="form-control"
                                    value="<?= $e($filters['date_to']) ?>">
                            </div>
                            <div class="col-md-5 form-group">
                                <label>Recherche</label>
                                <input type="text" name="q" class="form-control" value="<?= $e($filters['q']) ?>"
                                    placeholder="N° BL, DA-…, chantier, demandeur, n° BP, réf. fournisseur…">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>&nbsp;</label>
                                <div class="d-flex">
                                    <button class="btn btn-dark flex-fill mr-2"><i class="fas fa-search"></i>
                                        Filtrer</button>
                                    <a href="<?= base_url('stock-delivery-notes') ?>" class="btn btn-outline-secondary"
                                        title="Réinitialiser">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <a href="<?= base_url('stock-general') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour aux stocks
                </a>
            </div>

            <!-- LISTE -->
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-truck-loading mr-1"></i>
                        Bons de livraison <span class="badge badge-info ml-1"><?= (int) $total ?></span>
                    </h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped table-hover dn-table mb-0">
                        <thead>
                            <tr>
                                <th>N° BL</th>
                                <th>Date</th>
                                <th>DA</th>
                                <th>Chantier</th>
                                <th>Bon de paiement</th>
                                <th>Réf. fournisseur</th>
                                <th class="text-center">Lignes</th>
                                <th>Réceptionné par</th>
                                <th>Statut DA</th>
                                <th class="text-center" style="width:120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($notes)) : ?>
                            <?php foreach ($notes as $n) : ?>
                            <tr>
                                <td><strong><?= $e($n->delivery_number) ?></strong></td>
                                <td><?= $fd($n->delivery_date) ?></td>
                                <td>DA-<?= (int) $n->request_id ?></td>
                                <td><?= $e($n->destination_chantier) ?></td>
                                <td><?= $e($n->payment_number) ?></td>
                                <td><?= $n->supplier_bl_reference ? $e($n->supplier_bl_reference) : '<span class="text-muted">—</span>' ?>
                                </td>
                                <td class="text-center"><span class="badge badge-dark"><?= (int) $n->nb_lines ?></span>
                                </td>
                                <td><?= $n->received_by ? $e($n->received_by) : '<span class="text-muted">—</span>' ?>
                                </td>
                                <td><?= $statusBadge($n->delivery_status) ?></td>
                                <td class="text-center text-nowrap">
                                    <button type="button" class="btn btn-xs btn-info dn-view"
                                        data-id="<?= (int) $n->id ?>" title="Détail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="<?= base_url('stock-delivery-note-print/' . (int) $n->id) ?>"
                                        target="_blank" class="btn btn-xs btn-secondary" title="Imprimer">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <?php if ($n->attachment) : ?>
                                    <a href="<?= base_url($n->attachment) ?>" target="_blank"
                                        class="btn btn-xs btn-outline-dark" title="Scan du BL">
                                        <i class="fas fa-paperclip"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">Aucun bon de livraison trouvé</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($pages > 1) : ?>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <?= (($page - 1) * $per_page) + 1 ?>–<?= min($page * $per_page, $total) ?> sur
                        <?= (int) $total ?>
                    </small>
                    <ul class="pagination pagination-sm m-0">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= $pageUrl($page - 1) ?>">&laquo;</a>
                        </li>
                        <?php for ($p = max(1, $page - 2); $p <= min($pages, $page + 2); $p++) : ?>
                        <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $pageUrl($p) ?>"><?= $p ?></a>
                        </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $page >= $pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= $pageUrl($page + 1) ?>">&raquo;</a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </section>
</div>

<!-- MODAL DÉTAIL -->
<div class="modal fade" id="dnDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title"><i class="fas fa-truck-loading mr-1"></i> <span id="dnTitle">Bon de
                        livraison</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="dnBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <a href="#" target="_blank" class="btn btn-info" id="dnPrint"><i class="fas fa-print"></i> Imprimer</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var $ = window.jQuery;
    var BASE = '<?= base_url() ?>';

    function esc(s) {
        return $('<div>').text(s === null || s === undefined ? '' : String(s)).html();
    }

    function num(n) {
        return Number(n || 0).toLocaleString('fr-FR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function fdate(d) {
        if (!d) return '—';
        var p = String(d).substr(0, 10).split('-');
        return p.length === 3 ? p[2] + '/' + p[1] + '/' + p[0] : d;
    }

    function orDash(v) {
        return v ? esc(v) : '<span class="text-muted">—</span>';
    }

    function statusBadge(s) {
        if (s === 'livre') return '<span class="badge badge-success">Livrée</span>';
        if (s === 'partiel') return '<span class="badge badge-warning">Partielle</span>';
        return '<span class="badge badge-secondary">Non livrée</span>';
    }

    $('.dn-view').on('click', function() {
        var id = $(this).data('id');
        $('#dnTitle').text('Bon de livraison');
        $('#dnBody').html(
            '<div class="text-center text-muted py-4"><i class="fas fa-spinner fa-spin"></i> Chargement...</div>'
            );
        $('#dnPrint').attr('href', BASE + 'stock-delivery-note-print/' + id);
        $('#dnDetailModal').modal('show');

        $.getJSON(BASE + 'stock-delivery-note-detail/' + id)
            .done(function(res) {
                if (!res.success) {
                    $('#dnBody').html('<div class="alert alert-danger mb-0">' + esc(res.message) +
                        '</div>');
                    return;
                }
                var n = res.note;
                $('#dnTitle').text(n.delivery_number);

                var html = '' +
                    '<div class="row">' +
                    '  <div class="col-md-6"><dl class="row mb-0">' +
                    '    <dt class="col-5">Date livraison</dt><dd class="col-7">' + fdate(n
                        .delivery_date) + '</dd>' +
                    '    <dt class="col-5">Demande</dt><dd class="col-7">DA-' + esc(n.request_id) +
                    ' ' + statusBadge(n.delivery_status) + '</dd>' +
                    '    <dt class="col-5">Chantier</dt><dd class="col-7">' + orDash(n
                        .destination_chantier) + '</dd>' +
                    '    <dt class="col-5">Demandeur</dt><dd class="col-7">' + orDash(n
                        .requested_by) + '</dd>' +
                    '  </dl></div>' +
                    '  <div class="col-md-6"><dl class="row mb-0">' +
                    '    <dt class="col-5">Bon de paiement</dt><dd class="col-7">' + orDash(n
                        .payment_number) + '</dd>' +
                    '    <dt class="col-5">Montant payé</dt><dd class="col-7">' + num(n
                    .amount_paid) + '</dd>' +
                    '    <dt class="col-5">Réf. fournisseur</dt><dd class="col-7">' + orDash(n
                        .supplier_bl_reference) + '</dd>' +
                    '    <dt class="col-5">Réceptionné par</dt><dd class="col-7">' + orDash(n
                        .received_by) + '</dd>' +
                    '    <dt class="col-5">Lieu</dt><dd class="col-7">' + orDash(n
                    .nom_emplacement) + '</dd>' +
                    '  </dl></div>' +
                    '</div><hr>' +
                    '<table class="table table-sm table-bordered mb-3"><thead class="thead-light"><tr>' +
                    '<th>Désignation</th><th class="text-center">Commandé</th><th class="text-center">Reçu</th>' +
                    '</tr></thead><tbody>';

                $.each(res.items || [], function(i, it) {
                    html += '<tr><td>' + esc(it.designation) + '</td>' +
                        '<td class="text-center">' + num(it.quantity_ordered) + '</td>' +
                        '<td class="text-center"><strong>' + num(it.quantity_received) +
                        '</strong></td></tr>';
                });
                html += '</tbody></table>';

                if (n.observation) {
                    html += '<p class="mb-2"><strong>Observation :</strong><br>' + esc(n
                        .observation).replace(/\n/g, '<br>') + '</p>';
                }
                if (n.attachment_url) {
                    html += '<a href="' + esc(n.attachment_url) +
                        '" target="_blank" class="btn btn-sm btn-outline-dark">' +
                        '<i class="fas fa-paperclip"></i> Voir le scan du BL</a>';
                }

                $('#dnBody').html(html);
            })
            .fail(function() {
                $('#dnBody').html(
                    '<div class="alert alert-danger mb-0">Erreur de chargement.</div>');
            });
    });
});
</script>