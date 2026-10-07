<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">



            <!-- STATISTIQUES -->
            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $stats['total_articles']; ?></h3>
                            <p>Articles enregistrés</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?= $stats['total_emplacements']; ?></h3>
                            <p>Emplacements stock</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $stats['total_lignes_stock']; ?></h3>
                            <p>Lignes de stock</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= number_format($stats['quantite_totale'], 2, ',', ' '); ?></h3>
                            <p>Quantité totale</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FILTRE -->
            <div class="card card-outline card-dark">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i>
                        Filtrage du stock
                    </h3>
                </div>

                <form method="get" action="<?= base_url('stock-general') ?>">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Article</label>
                                    <select name="article_id" class="form-control">
                                        <option value="">Tous les articles</option>
                                        <?php foreach ($articles as $article) : ?>
                                        <option value="<?= $article->id ?>"
                                            <?= ($filter_article_id == $article->id) ? 'selected' : ''; ?>>
                                            <?= $article->code_article; ?> - <?= $article->designation; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Emplacement</label>
                                    <select name="emplacement_id" class="form-control">
                                        <option value="">Tous les emplacements</option>
                                        <?php foreach ($emplacements as $emplacement) : ?>
                                        <option value="<?= $emplacement->id ?>"
                                            <?= ($filter_emplacement_id == $emplacement->id) ? 'selected' : ''; ?>>
                                            <?= $emplacement->nom_emplacement; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <div>
                                    <button class="btn btn-dark btn-block">
                                        <i class="fas fa-search"></i> Filtrer
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <!-- BOUTONS -->
            <div class="d-flex justify-content-end mb-3">

                <button class="btn btn-success mr-2" data-toggle="modal" data-target="#addArticleModal">

                    <i class="fas fa-plus"></i>
                    Nouvel article

                </button>

                <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#addEmplacementModal">

                    <i class="fas fa-map-marker-alt"></i>
                    Nouvel emplacement

                </button>

                <button class="btn btn-warning mr-2" data-toggle="modal" data-target="#addQuantiteModal">
                    <i class="fas fa-boxes"></i>
                    Ajouter quantité
                </button>

                <button class="btn btn-info mr-2" data-toggle="modal" data-target="#bonLivraisonModal">
                    <i class="fas fa-truck-loading"></i>
                    Bon de livraison
                </button>

                <a href="<?= base_url('stock-delivery-notes') ?>" class="btn btn-dark">
                    <i class="fas fa-list"></i>
                    Liste des bons
                </a>
            </div>

            <!-- ===================== MODAL BON DE LIVRAISON ===================== -->
            <style>
            #bonLivraisonModal .bl-table td,
            #bonLivraisonModal .bl-table th {
                vertical-align: middle;
            }

            #bonLivraisonModal .bl-row-done {
                background: #f4f6f9;
                color: #6c757d;
            }

            #bonLivraisonModal .bl-qty {
                width: 110px;
                margin: 0 auto;
            }

            #bonLivraisonModal .bl-article {
                min-width: 220px;
            }

            #bonLivraisonModal .bl-scroll {
                max-height: 380px;
                overflow-y: auto;
            }

            #bonLivraisonModal .bl-scroll thead th {
                position: sticky;
                top: 0;
                z-index: 1;
            }
            </style>

            <template id="blArticleOptions">
                <option value="">-- Choisir --</option>
                <option value="hors_stock">Hors stock (service, carburant…)</option>
                <?php foreach ($articles as $article) : ?>
                <option value="<?= $article->id ?>"
                    data-name="<?= htmlspecialchars(mb_strtolower(trim($article->designation)), ENT_QUOTES) ?>">
                    <?= htmlspecialchars($article->code_article . ' - ' . $article->designation) ?>
                </option>
                <?php endforeach; ?>
            </template>

            <div class="modal fade" id="bonLivraisonModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">

                        <div class="modal-header bg-info">
                            <h5 class="modal-title"><i class="fas fa-truck-loading mr-1"></i> Nouveau bon de livraison
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <div id="blAlert" class="alert" style="display:none;"></div>

                            <!-- ÉTAPE 1 : choix de la DA payée -->
                            <div id="blStep1">
                                <p class="text-muted mb-2">
                                    Demandes d'achat payées à la trésorerie et pas encore entièrement livrées.
                                </p>
                                <input type="text" id="blSearch" class="form-control mb-2"
                                    placeholder="Rechercher : n° DA, chantier, demandeur, n° bon de paiement...">
                                <div class="table-responsive bl-scroll">
                                    <table class="table table-sm table-hover table-bordered bl-table mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>DA</th>
                                                <th>Chantier</th>
                                                <th>Demandeur</th>
                                                <th>Bon(s) de paiement</th>
                                                <th class="text-right">Montant payé</th>
                                                <th>Payé le</th>
                                                <th>Livraison</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="blRequestsBody"></tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- ÉTAPE 2 : saisie de la réception -->
                            <form id="blForm" style="display:none;" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" name="request_id" id="blRequestId">

                                <div class="callout callout-info py-2 mb-3" id="blRequestInfo"></div>

                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label>Date de livraison *</label>
                                        <input type="date" name="delivery_date" class="form-control"
                                            value="<?= date('Y-m-d') ?>" required>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Emplacement de réception</label>
                                        <select name="emplacement_id" id="blEmplacement" class="form-control">
                                            <option value="">-- Sélectionner --</option>
                                            <?php foreach ($emplacements as $emplacement) : ?>
                                            <option value="<?= $emplacement->id ?>">
                                                <?= htmlspecialchars($emplacement->nom_emplacement) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- <small class="text-muted">Obligatoire si des articles entrent en stock</small> -->
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>N° BL fournisseur</label>
                                        <input type="text" name="supplier_bl_reference" class="form-control"
                                            maxlength="150">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Réceptionné par</label>
                                        <input type="text" name="received_by" class="form-control" maxlength="191">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Lignes de la demande</strong>
                                    <button type="button" class="btn btn-sm btn-outline-info" id="blFillAll">
                                        <i class="fas fa-check-double"></i> Tout recevoir
                                    </button>
                                </div>

                                <div class="table-responsive bl-scroll mb-3">
                                    <table class="table table-sm table-bordered bl-table mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Désignation</th>
                                                <th class="text-center">Commandé</th>
                                                <th class="text-center">Déjà reçu</th>
                                                <th class="text-center">Reste</th>
                                                <th class="text-center">Qté reçue</th>
                                                <th>Article en stock</th>
                                            </tr>
                                        </thead>
                                        <tbody id="blItemsBody"></tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>Scan du BL (PDF, JPG, PNG – 5 Mo max)</label>
                                        <input type="file" name="attachment" class="form-control-file"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <label>Observation</label>
                                        <textarea name="observation" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" id="blBack" style="display:none;">
                                <i class="fas fa-arrow-left"></i> Retour
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-info" id="blSave" style="display:none;">
                                <i class="fas fa-save"></i> Enregistrer le bon
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var $ = window.jQuery;
                var BASE = '<?= base_url() ?>';
                var CSRF_NAME = '<?= $this->security->get_csrf_token_name() ?>';
                var CSRF_HASH = '<?= $this->security->get_csrf_hash() ?>';
                var SAVE_HTML = '<i class="fas fa-save"></i> Enregistrer le bon';
                var requests = [];

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
                    if (!d) return '';
                    var p = String(d).substr(0, 10).split('-');
                    return p.length === 3 ? p[2] + '/' + p[1] + '/' + p[0] : d;
                }

                function alertBox(type, html) {
                    $('#blAlert').attr('class', 'alert alert-' + type).html(html).show();
                }

                function statusBadge(s) {
                    return s === 'partiel' ?
                        '<span class="badge badge-warning">Partielle</span>' :
                        '<span class="badge badge-secondary">Non livrée</span>';
                }

                function showStep1() {
                    $('#blForm').hide();
                    $('#blBack, #blSave').hide();
                    $('#blStep1').show();
                    $('#blAlert').hide();
                }

                function showStep2() {
                    $('#blStep1').hide();
                    $('#blForm').show();
                    $('#blBack, #blSave').show();
                    $('#blAlert').hide();
                }

                /* ---------- Étape 1 : DA payées ---------- */
                function loadRequests() {
                    $('#blRequestsBody').html(
                        '<tr><td colspan="8" class="text-center text-muted"><i class="fas fa-spinner fa-spin"></i> Chargement...</td></tr>'
                    );
                    $.getJSON(BASE + 'stock-bl-requests')
                        .done(function(res) {
                            requests = (res && res.data) ? res.data : [];
                            renderRequests();
                        })
                        .fail(function() {
                            $('#blRequestsBody').html(
                                '<tr><td colspan="8" class="text-center text-danger">Erreur de chargement des demandes.</td></tr>'
                            );
                        });
                }

                function renderRequests() {
                    var q = $.trim($('#blSearch').val()).toLowerCase();
                    var html = '';

                    $.each(requests, function(i, r) {
                        var hay = ('da-' + r.id + ' ' + r.id + ' ' + r.destination_chantier + ' ' + r
                            .requested_by + ' ' + (r.payment_numbers || '')).toLowerCase();
                        if (q && hay.indexOf(q) === -1) return;

                        html += '<tr>' +
                            '<td><strong>DA-' + esc(r.id) + '</strong><br><small class="text-muted">' +
                            fdate(r.request_date) + '</small></td>' +
                            '<td>' + esc(r.destination_chantier) + '</td>' +
                            '<td>' + esc(r.requested_by) + '</td>' +
                            '<td><small>' + esc(r.payment_numbers) + '</small></td>' +
                            '<td class="text-right">' + num(r.total_paid) + '</td>' +
                            '<td>' + fdate(r.last_payment_date) + '</td>' +
                            '<td>' + statusBadge(r.delivery_status) + '</td>' +
                            '<td class="text-center"><button type="button" class="btn btn-xs btn-info bl-pick" data-id="' +
                            esc(r.id) + '">' +
                            '<i class="fas fa-arrow-right"></i> Choisir</button></td>' +
                            '</tr>';
                    });

                    $('#blRequestsBody').html(html ||
                        '<tr><td colspan="8" class="text-center text-muted">Aucune demande payée en attente de livraison.</td></tr>'
                    );
                }

                $('#blSearch').on('input', renderRequests);

                /* ---------- Étape 2 : lignes de la DA ---------- */
                $('#blRequestsBody').on('click', '.bl-pick', function() {
                    var id = String($(this).data('id'));
                    var r = null;
                    $.each(requests, function(i, x) {
                        if (String(x.id) === id) {
                            r = x;
                            return false;
                        }
                    });
                    if (!r) return;

                    $('#blForm')[0].reset();
                    $('#blRequestId').val(r.id);
                    $('#blRequestInfo').html(
                        '<strong>DA-' + esc(r.id) + '</strong> — ' + esc(r.destination_chantier) +
                        ' | Demandeur : ' + esc(r.requested_by) +
                        ' | Payé : <strong>' + num(r.total_paid) + '</strong> (' + esc(r
                            .payment_numbers) + ')'
                    );
                    $('#blItemsBody').html(
                        '<tr><td colspan="6" class="text-center text-muted"><i class="fas fa-spinner fa-spin"></i> Chargement...</td></tr>'
                    );
                    showStep2();

                    $.getJSON(BASE + 'stock-bl-items/' + r.id)
                        .done(function(res) {
                            if (!res.success) {
                                alertBox('danger', esc(res.message));
                                return;
                            }
                            renderItems(res.items || []);
                        })
                        .fail(function() {
                            alertBox('danger', 'Erreur de chargement des lignes.');
                        });
                });

                function renderItems(items) {
                    var $body = $('#blItemsBody').empty();

                    if (!items.length) {
                        $body.html(
                            '<tr><td colspan="5" class="text-center text-muted">Aucune ligne sur cette demande.</td></tr>'
                        );
                        return;
                    }

                    $.each(items, function(i, it) {
                        var ordered = parseFloat(it.quantity) || 0;
                        var received = parseFloat(it.qty_received) || 0;
                        var rest = Math.max(0, Math.round((ordered - received) * 100) / 100);
                        var done = rest <= 0;

                        var $tr = $('<tr>').toggleClass('bl-row-done', done);
                        $tr.append($('<td>').text(it.designation));
                        $tr.append('<td class="text-center">' + num(ordered) + '</td>');
                        $tr.append('<td class="text-center">' + num(received) + '</td>');
                        $tr.append('<td class="text-center"><strong>' + num(rest) + '</strong></td>');

                        if (done) {
                            $tr.append(
                                '<td class="text-center"><span class="badge badge-success">Soldé</span></td>'
                            );
                        } else {
                            var $qty = $(
                                    '<input type="number" step="0.01" min="0" class="form-control form-control-sm bl-qty">'
                                )
                                .attr({
                                    name: 'qty[' + it.id + ']',
                                    max: rest,
                                    'data-rest': rest
                                });
                            $tr.append($('<td class="text-center">').append($qty));
                        }
                        $body.append($tr);
                    });
                }

                $('#blFillAll').on('click', function() {
                    $('#blItemsBody .bl-qty').each(function() {
                        $(this).val($(this).attr('data-rest'));
                    });
                });

                $('#blBack').on('click', showStep1);

                /* ---------- Enregistrement ---------- */
                $('#blSave').on('click', function() {
                    var errs = [],
                        count = 0;

                    $('#blItemsBody tr').each(function() {
                        var $q = $(this).find('.bl-qty');
                        if (!$q.length) return;
                        var v = parseFloat(String($q.val()).replace(',', '.')) || 0;
                        if (v <= 0) return;

                        count++;
                        var rest = parseFloat($q.attr('data-rest'));
                        var name = $(this).find('td:first').text();
                        if (v > rest + 0.0001) errs.push(name +
                            ' : quantité supérieure au reste (' + num(rest) + ')');
                    });

                    if (!count) errs.push('Saisissez au moins une quantité reçue.');

                    if (errs.length) {
                        alertBox('danger', $.map(errs, esc).join('<br>'));
                        return;
                    }

                    var fd = new FormData(document.getElementById('blForm'));
                    fd.append(CSRF_NAME, CSRF_HASH);

                    var $btn = $(this).prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin"></i> Enregistrement...');

                    $.ajax({
                            url: BASE + 'stock-bl-store',
                            type: 'POST',
                            data: fd,
                            processData: false,
                            contentType: false,
                            dataType: 'json'
                        })
                        .done(function(res) {
                            if (res.csrf_hash) CSRF_HASH = res.csrf_hash;
                            if (res.success) {
                                alertBox('success', esc(res.message));
                                setTimeout(function() {
                                    location.reload();
                                }, 1200);
                            } else {
                                var html = esc(res.message);
                                if (res.errors && res.errors.length) html += '<br>' + $.map(res
                                    .errors, esc).join('<br>');
                                alertBox('danger', html);
                                $btn.prop('disabled', false).html(SAVE_HTML);
                            }
                        })
                        .fail(function() {
                            alertBox('danger', 'Erreur serveur lors de l\'enregistrement.');
                            $btn.prop('disabled', false).html(SAVE_HTML);
                        });
                });

                $('#bonLivraisonModal').on('show.bs.modal', function(e) {
                    if (e.target !== this) return;
                    $('#blSearch').val('');
                    showStep1();
                    loadRequests();
                });
            });
            </script>

            <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php endif; ?>

            <!-- DEUX COLONNES -->
            <div class="row">

                <!-- COLONNE 1 : STOCK PAR EMPLACEMENT -->
                <div class="col-md-8">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-warehouse mr-1"></i>
                                Quantité de stock par article et emplacement
                            </h3>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>Code</th>
                                        <th>Article</th>
                                        <th>Catégorie</th>
                                        <th>Unité</th>
                                        <th>Emplacement</th>
                                        <th>Qté Emplacement</th>
                                        <th>Total Article</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($stocks)) : ?>
                                    <?php foreach ($stocks as $stock) : ?>
                                    <tr>

                                        <td><?= $stock->code_article ?></td>

                                        <td><?= $stock->designation ?></td>

                                        <td><?= $stock->categorie ?></td>

                                        <td><?= $stock->unite ?></td>

                                        <td>
                                            <span class="badge badge-primary">
                                                <?= $stock->nom_emplacement ?>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge badge-success">
                                                <?= number_format($stock->quantite_emplacement, 2, ',', ' ') ?>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge badge-dark">
                                                <?= number_format($stock->total_article, 2, ',', ' ') ?>
                                            </span>
                                        </td>

                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Aucun stock trouvé
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <!-- COLONNE 2 : TOTAL PAR ARTICLE -->
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Total par article
                            </h3>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Article</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($totaux_articles)) : ?>
                                    <?php foreach ($totaux_articles as $item) : ?>
                                    <tr>
                                        <td>
                                            <strong><?= $item->designation; ?></strong><br>
                                            <small class="text-muted">
                                                <?= $item->code_article; ?> / <?= $item->unite; ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">
                                                <?= number_format($item->total_quantite, 2, ',', ' '); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">
                                            Aucun total disponible
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<div class="modal fade" id="addArticleModal">
    <div class="modal-dialog">
        <form action="<?= base_url('stock-article-store') ?>" method="post">
            <div class="modal-content">

                <div class="modal-header bg-success">
                    <h5 class="modal-title">Nouvel article</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Code article</label>
                        <input type="text" name="code_article" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Désignation</label>
                        <input type="text" name="designation" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Unité</label>
                        <input type="text" name="unite" class="form-control" placeholder="Kg, Sac, Pièce, Tonne...">
                    </div>

                    <div class="form-group">
                        <label>Catégorie</label>
                        <input type="text" name="categorie" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">
                        Enregistrer
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="addEmplacementModal">
    <div class="modal-dialog">
        <form action="<?= base_url('stock-emplacement-store') ?>" method="post">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Nouvel emplacement</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nom emplacement</label>
                        <input type="text" name="nom_emplacement" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">
                        Enregistrer
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="addQuantiteModal">
    <div class="modal-dialog">
        <form action="<?= base_url('stock-quantite-store') ?>" method="post">
            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Ajouter quantité au stock</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Article</label>
                        <select name="article_id" class="form-control" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($articles as $article) : ?>
                            <option value="<?= $article->id ?>">
                                <?= $article->designation ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Emplacement</label>
                        <select name="emplacement_id" class="form-control" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($emplacements as $emplacement) : ?>
                            <option value="<?= $emplacement->id ?>">
                                <?= $emplacement->nom_emplacement ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Quantité</label>
                        <input type="number" step="0.01" name="quantite" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning">
                        Ajouter
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>