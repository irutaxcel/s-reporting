<!-- Content Wrapper -->
<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Small boxes -->
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>24</h3>
                            <p>Demandes validées</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>18</h3>
                            <p>Achats effectués</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>6</h3>
                            <p>En approvisionnement</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>2</h3>
                            <p>Livraisons en retard</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>

            </div>

            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('error'); ?>
            </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('success'); ?>
            </div>
            <?php endif; ?>

            <!-- Card principale -->
            <div class="card card-outline card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clipboard-check mr-2"></i>
                        Demandes d'achat validées par DT, DAF et Trésorerie
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                            data-target="#modalNouvelAchat">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Créer un achat
                        </button>

                        <button class="btn btn-sm btn-secondary">
                            <i class="fas fa-print mr-1"></i>
                            Imprimer
                        </button>
                    </div>
                </div>

                <!-- Modal Nouvelle demande / Achat -->
                <div class="modal fade" id="modalNouvelAchat" tabindex="-1" role="dialog"
                    aria-labelledby="modalNouvelAchatLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <form action="<?= base_url('tech/store_achat_materiel') ?>" method="post" id="formNouvelAchat">
                            <div class="modal-content">

                                <div class="modal-header bg-success">
                                    <h5 class="modal-title" id="modalNouvelAchatLabel">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Nouvelle demande d'achat
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Chantier</label>
                                                <select name="chantier_id" class="form-control" required>
                                                    <option value="">-- Sélectionner le chantier --</option>
                                                    <?php foreach ($allChantiers as $chant) : ?>
                                                    <option value="<?= $chant->id ?>"><?= $chant->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Demandé par</label>
                                                <input type="text" name="demande_par" class="form-control"
                                                    placeholder="Nom du demandeur" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Chargé des achats</label>
                                                <input type="text" name="charge_achat" class="form-control"
                                                    placeholder="Nom du chargé des achats" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Vérifié par</label>
                                                <input type="text" name="verifie_par" class="form-control"
                                                    placeholder="Nom du vérificateur" required>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">
                                            <i class="fas fa-list mr-1"></i>
                                            Articles demandés
                                        </h5>

                                        <button type="button" class="btn btn-sm btn-success" onclick="addArticleRow()">
                                            <i class="fas fa-plus mr-1"></i>
                                            Ajouter article
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm" id="articlesTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Désignation article</th>
                                                    <th width="140">Quantité</th>
                                                    <th width="170">Prix unitaire</th>
                                                    <th width="180">Total</th>
                                                    <th width="60">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="article[]" class="form-control"
                                                            placeholder="Ex : Ciment, fer à béton..." required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="quantite[]"
                                                            class="form-control quantite" min="1" value="1"
                                                            onkeyup="calculerLigne(this)" onchange="calculerLigne(this)"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="prix_unitaire[]"
                                                            class="form-control prix_unitaire" min="0" value="0"
                                                            onkeyup="calculerLigne(this)" onchange="calculerLigne(this)"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="total_ligne[]"
                                                            class="form-control total_ligne" value="0" readonly>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="removeArticleRow(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-right">Total général</th>
                                                    <th>
                                                        <input type="number" name="total_general" id="total_general"
                                                            class="form-control font-weight-bold" value="0" readonly>
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Fermer
                                    </button>

                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save mr-1"></i>
                                        Enregistrer
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <script>
                function addArticleRow() {
                    let tbody = document.querySelector('#articlesTable tbody');

                    let tr = document.createElement('tr');

                    tr.innerHTML = `
                        <td>
                            <input type="text" name="article[]" class="form-control" placeholder="Ex : Ciment, fer à béton..." required>
                        </td>
                        <td>
                            <input type="number" name="quantite[]" class="form-control quantite" min="1" value="1" onkeyup="calculerLigne(this)" onchange="calculerLigne(this)" required>
                        </td>
                        <td>
                            <input type="number" name="prix_unitaire[]" class="form-control prix_unitaire" min="0" value="0" onkeyup="calculerLigne(this)" onchange="calculerLigne(this)" required>
                        </td>
                        <td>
                            <input type="number" name="total_ligne[]" class="form-control total_ligne" value="0" readonly>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeArticleRow(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;

                    tbody.appendChild(tr);
                }

                function removeArticleRow(button) {
                    let tbody = document.querySelector('#articlesTable tbody');

                    if (tbody.rows.length > 1) {
                        button.closest('tr').remove();
                        calculerTotalGeneral();
                    }
                }

                function calculerLigne(input) {
                    let tr = input.closest('tr');

                    let quantite = parseFloat(tr.querySelector('.quantite').value) || 0;
                    let prix = parseFloat(tr.querySelector('.prix_unitaire').value) || 0;
                    let total = quantite * prix;

                    tr.querySelector('.total_ligne').value = total;

                    calculerTotalGeneral();
                }

                function calculerTotalGeneral() {
                    let totalGeneral = 0;

                    document.querySelectorAll('.total_ligne').forEach(function(input) {
                        totalGeneral += parseFloat(input.value) || 0;
                    });

                    document.getElementById('total_general').value = totalGeneral;
                }
                </script>

                <div class="card-body">

                    <!-- Filtres -->
                    <div class="row mb-3">

                        <div class="col-md-3">
                            <label>Chantier / Projet</label>
                            <select class="form-control">
                                <option>Tous les chantiers</option>
                                <option>Chantier Bujumbura</option>
                                <option>Chantier Gitega</option>
                                <option>Chantier Ngozi</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Statut achat</label>
                            <select class="form-control">
                                <option>Tous</option>
                                <option>Validée</option>
                                <option>Achat effectué</option>
                                <option>En approvisionnement</option>
                                <option>Livré</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>Date début</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <label>Date fin</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-success btn-block">
                                <i class="fas fa-search mr-1"></i>
                                Filtrer
                            </button>
                        </div>

                    </div>

                    <style>
                    .table-achats {
                        table-layout: fixed;
                        width: 100%;
                    }

                    .table-achats td {
                        vertical-align: middle;
                    }

                    .table-achats th {
                        white-space: nowrap;
                    }

                    .col-materiel {
                        width: 320px;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }

                    .col-montant {
                        width: 170px;
                        white-space: nowrap;
                        text-align: right;
                        font-weight: bold;
                    }

                    .col-date {
                        width: 130px;
                        white-space: nowrap;
                    }

                    .col-action {
                        width: 140px;
                        white-space: nowrap;
                    }
                    </style>

                    <!-- Tableau -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>

                                    <th style="width:50px">#</th>

                                    <th style="width:120px">Référence</th>

                                    <th style="width:220px">Chantier / Projet</th>

                                    <th style="width:170px">Demandeur</th>

                                    <th style="width:320px">Matériel demandé</th>

                                    <th style="width:160px" class="text-center">
                                        Montant estimé
                                    </th>

                                    <th style="width:130px">
                                        Date demande
                                    </th>

                                    <th style="width:150px">
                                        Validation
                                    </th>

                                    <th style="width:170px">
                                        Statut achat
                                    </th>

                                    <th style="width:140px">
                                        Actions
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                <?php if (!empty($allAchats)) : ?>

                                <?php $i = 1; ?>
                                <?php foreach ($allAchats as $achat) : ?>

                                <tr>
                                    <td><?= $i++ ?></td>

                                    <td>
                                        <strong>DA-<?= date('Y', strtotime($achat->created_at)) ?>-<?= str_pad($achat->id, 3, '0', STR_PAD_LEFT) ?></strong>
                                    </td>

                                    <td>
                                        <?= !empty($achat->chantier_nom) ? $achat->chantier_nom : $achat->destination_chantier ?>
                                    </td>

                                    <td><?= $achat->requested_by ?></td>

                                    <td style="max-width:320px;">
                                        <?= !empty($achat->articles_designation) ? $achat->articles_designation : 'Aucun article' ?>
                                    </td>

                                    <td class="text-right text-nowrap">
                                        <strong>
                                            <?= number_format($achat->total_amount, 0, ',', ' ') ?> BIF
                                        </strong>
                                    </td>

                                    <td class="text-nowrap">
                                        <?= !empty($achat->request_date) ? date('d/m/Y', strtotime($achat->request_date)) : date('d/m/Y', strtotime($achat->created_at)) ?>
                                    </td>

                                    <td class="text-center text-nowrap">

                                        <button type="button"
                                            class="btn btn-xs <?= ($achat->technical_status == 'valide') ? 'btn-success' : 'btn-warning' ?>"
                                            onclick="validerAchat(<?= $achat->id ?>, 'technical_status')">
                                            DT
                                        </button>

                                        <button type="button"
                                            class="btn btn-xs <?= ($achat->financial_status == 'valide') ? 'btn-success' : 'btn-warning' ?>"
                                            onclick="validerAchat(<?= $achat->id ?>, 'financial_status')">
                                            DAF
                                        </button>

                                        <button type="button"
                                            class="btn btn-xs <?= ($achat->treasury_status == 'valide') ? 'btn-success' : 'btn-warning' ?>"
                                            onclick="validerAchat(<?= $achat->id ?>, 'treasury_status')">
                                            Trésorerie
                                        </button>

                                    </td>

                                    <td class="text-center text-nowrap">
                                        <?php if ($achat->workflow_status == 'brouillon') : ?>
                                        <span class="badge badge-secondary">Brouillon</span>
                                        <?php elseif ($achat->workflow_status == 'commandee' || $achat->workflow_status == 'commandée') : ?>
                                        <span class="badge badge-warning">En approvisionnement</span>
                                        <?php elseif ($achat->workflow_status == 'livre' || $achat->workflow_status == 'livré') : ?>
                                        <span class="badge badge-primary">Livré</span>
                                        <?php elseif ($achat->workflow_status == 'Valide' || $achat->workflow_status == 'Validé') : ?>
                                        <span class="badge badge-success">Validé</span>
                                        <?php else : ?>
                                        <span class="badge badge-info"><?= ucfirst($achat->workflow_status) ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center text-nowrap">

                                        <!-- Voir -->
                                        <button class="btn btn-sm btn-info" title="Voir détail"
                                            onclick="voirAchat(<?= $achat->id ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Créer achat -->
                                        <button class="btn btn-sm btn-success" title="Créer achat"
                                            onclick="creerAchat(<?= $achat->id ?>)">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>

                                        <!-- Modifier -->
                                        <button class="btn btn-sm btn-warning" title="Modifier"
                                            onclick="modifierAchat(<?= $achat->id ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Supprimer -->
                                        <button class="btn btn-sm btn-danger" title="Supprimer"
                                            onclick="supprimerAchat(<?= $achat->id ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <!-- Imprimer -->
                                        <button class="btn btn-sm btn-secondary" title="Imprimer"
                                            onclick="window.open('<?= base_url('tech/print-achat/' . $achat->id) ?>','_blank')">
                                            <i class="fas fa-print"></i>
                                        </button>

                                    </td>
                                </tr>

                                <?php endforeach; ?>

                                <?php else : ?>

                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        Aucune demande d'achat trouvée.
                                    </td>
                                </tr>

                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>

                </div>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                function validerAchat(id, champ) {
                    Swal.fire({
                        title: 'Confirmation',
                        text: 'Voulez-vous valider cette étape ?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, valider',
                        cancelButtonText: 'Annuler',
                        confirmButtonColor: '#28a745'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: "<?= base_url('tech/valider-achat') ?>",
                                type: "POST",
                                data: {
                                    id: id,
                                    champ: champ
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Validé',
                                        text: 'Validation effectuée avec succès',
                                        timer: 1200,
                                        showConfirmButton: false
                                    });

                                    setTimeout(function() {
                                        location.reload();
                                    }, 1200);
                                },
                                error: function() {
                                    Swal.fire('Erreur', 'Impossible de valider cette demande.',
                                        'error');
                                }
                            });
                        }
                    });
                }
                </script>

                <div class="modal fade" id="modalModifierAchat" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xl" role="document">
                        <form action="<?= base_url('tech/update-achat-materiel') ?>" method="post"
                            id="formModifierAchat">
                            <input type="hidden" name="id" id="edit_id">

                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title">
                                        <i class="fas fa-edit mr-2"></i>
                                        Modifier la demande d'achat
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Chantier</label>
                                            <select name="chantier_id" id="edit_chantier_id" class="form-control"
                                                required>
                                                <option value="">Sélectionner...</option>
                                                <?php foreach ($allChantiers as $c) : ?>
                                                <option value="<?= $c->id ?>"><?= $c->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Demandé par</label>
                                            <input type="text" name="demande_par" id="edit_demande_par"
                                                class="form-control" required>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label>Chargé des achats</label>
                                            <input type="text" name="charge_achat" id="edit_charge_achat"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label>Vérifié par</label>
                                            <input type="text" name="verifie_par" id="edit_verifie_par"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between mb-2">
                                        <h5>
                                            <i class="fas fa-list mr-1"></i>
                                            Articles demandés
                                        </h5>

                                        <button type="button" class="btn btn-sm btn-success"
                                            onclick="addEditArticleRow()">
                                            <i class="fas fa-plus"></i>
                                            Ajouter article
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm" id="editArticlesTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Désignation article</th>
                                                    <th width="140">Quantité</th>
                                                    <th width="170">Prix unitaire</th>
                                                    <th width="180">Total</th>
                                                    <th width="60">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody></tbody>

                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-right">Total général</th>
                                                    <th>
                                                        <input type="number" name="total_general"
                                                            id="edit_total_general"
                                                            class="form-control font-weight-bold" readonly>
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Fermer
                                    </button>

                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save mr-1"></i>
                                        Modifier
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                function modifierAchat(id) {
                    $.ajax({
                        url: "<?= base_url('tech/get-achat-materiel/') ?>" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(res) {
                            let achat = res.achat;
                            let items = res.items;

                            $('#edit_id').val(achat.id);
                            $('#edit_chantier_id').val(achat.chantier_id);
                            $('#edit_demande_par').val(achat.requested_by);
                            $('#edit_charge_achat').val(achat.buyer_name);
                            $('#edit_verifie_par').val(achat.verified_by);
                            $('#edit_total_general').val(achat.total_amount);

                            $('#editArticlesTable tbody').html('');

                            if (items.length > 0) {
                                items.forEach(function(item) {
                                    addEditArticleRow(
                                        item.designation,
                                        item.quantity,
                                        item.unit_price,
                                        item.total_price
                                    );
                                });
                            } else {
                                addEditArticleRow();
                            }

                            $('#modalModifierAchat').modal('show');
                        }
                    });
                }

                function addEditArticleRow(article = '', quantite = 1, prix = 0, total = 0) {
                    let row = `
                        <tr>
                            <td>
                                <input type="text" name="article[]" class="form-control" value="${article}" required>
                            </td>
                            <td>
                                <input type="number" name="quantite[]" class="form-control edit_quantite"
                                    value="${quantite}" min="1"
                                    onkeyup="calculerEditLigne(this)" onchange="calculerEditLigne(this)" required>
                            </td>
                            <td>
                                <input type="number" name="prix_unitaire[]" class="form-control edit_prix_unitaire"
                                    value="${prix}" min="0"
                                    onkeyup="calculerEditLigne(this)" onchange="calculerEditLigne(this)" required>
                            </td>
                            <td>
                                <input type="number" name="total_ligne[]" class="form-control edit_total_ligne"
                                    value="${total}" readonly>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeEditArticleRow(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#editArticlesTable tbody').append(row);
                    calculerEditTotalGeneral();
                }

                function removeEditArticleRow(btn) {
                    if ($('#editArticlesTable tbody tr').length > 1) {
                        $(btn).closest('tr').remove();
                        calculerEditTotalGeneral();
                    }
                }

                function calculerEditLigne(input) {
                    let tr = $(input).closest('tr');

                    let quantite = parseFloat(tr.find('.edit_quantite').val()) || 0;
                    let prix = parseFloat(tr.find('.edit_prix_unitaire').val()) || 0;
                    let total = quantite * prix;

                    tr.find('.edit_total_ligne').val(total);
                    calculerEditTotalGeneral();
                }

                function calculerEditTotalGeneral() {
                    let total = 0;

                    $('.edit_total_ligne').each(function() {
                        total += parseFloat($(this).val()) || 0;
                    });

                    $('#edit_total_general').val(total);
                }
                </script>


                <script>
                function supprimerAchat(id) {
                    Swal.fire({
                        title: 'Supprimer la demande ?',
                        text: "Cette action va supprimer la demande et tous ses articles.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: "<?= base_url('tech/delete-achat-materiel') ?>",
                                type: "POST",
                                dataType: "json",
                                data: {
                                    id: id
                                },
                                success: function(response) {

                                    if (response.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Supprimé',
                                            text: 'La demande a été supprimée avec succès.',
                                            timer: 1200,
                                            showConfirmButton: false
                                        });

                                        setTimeout(function() {
                                            location.reload();
                                        }, 1200);

                                    } else {
                                        Swal.fire('Erreur', 'La suppression a échoué.', 'error');
                                    }
                                },
                                error: function() {
                                    Swal.fire('Erreur', 'Impossible de supprimer cette demande.',
                                        'error');
                                }
                            });
                        }
                    });
                }
                </script>

                <div class="modal fade" id="modalVoirAchat" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">

                            <div class="modal-header bg-info">
                                <h5 class="modal-title">
                                    <i class="fas fa-eye mr-2"></i>
                                    Détail de la demande d'achat
                                </h5>

                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="row">

                                    <div class="col-md-4">
                                        <strong>Référence</strong>
                                        <p id="view_reference" class="text-muted"></p>
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Chantier</strong>
                                        <p id="view_chantier" class="text-muted"></p>
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Demandé par</strong>
                                        <p id="view_demande_par" class="text-muted"></p>
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Chargé des achats</strong>
                                        <p id="view_charge_achat" class="text-muted"></p>
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Vérifié par</strong>
                                        <p id="view_verifie_par" class="text-muted"></p>
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Date demande</strong>
                                        <p id="view_date" class="text-muted"></p>
                                    </div>

                                </div>

                                <hr>

                                <h5>
                                    <i class="fas fa-list mr-1"></i>
                                    Articles demandés
                                </h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Désignation</th>
                                                <th>Spécification</th>
                                                <th class="text-right">Quantité</th>
                                                <th class="text-right">Prix unitaire</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>

                                        <tbody id="view_articles_body"></tbody>

                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-right">Total général</th>
                                                <th class="text-right" id="view_total_general"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Fermer
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <script>
                function voirAchat(id) {
                    $.ajax({
                        url: "<?= base_url('tech/get-achat-materiel/') ?>" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(res) {

                            let achat = res.achat;
                            let items = res.items;

                            $('#view_reference').text('DA-' + new Date(achat.created_at).getFullYear() +
                                '-' + String(achat.id).padStart(3, '0'));
                            $('#view_chantier').text(achat.destination_chantier);
                            $('#view_demande_par').text(achat.requested_by);
                            $('#view_charge_achat').text(achat.buyer_name);
                            $('#view_verifie_par').text(achat.verified_by);
                            $('#view_date').text(formatDateFr(achat.request_date ?? achat.created_at));

                            $('#view_articles_body').html('');

                            let totalGeneral = 0;

                            if (items.length > 0) {

                                items.forEach(function(item, index) {

                                    let total = parseFloat(item.total_price) || 0;
                                    totalGeneral += total;

                                    $('#view_articles_body').append(`
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${item.designation}</td>
                                                <td>${item.technical_specs ?? '-'}</td>
                                                <td class="text-right">${item.quantity}</td>
                                                <td class="text-right">${formatMontant(item.unit_price)} BIF</td>
                                                <td class="text-right"><strong>${formatMontant(item.total_price)} BIF</strong></td>
                                            </tr>
                                        `);
                                });

                            } else {

                                $('#view_articles_body').html(`
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                Aucun article trouvé.
                                            </td>
                                        </tr>
                                    `);
                            }

                            $('#view_total_general').html('<strong>' + formatMontant(totalGeneral) +
                                ' BIF</strong>');

                            $('#modalVoirAchat').modal('show');
                        },
                        error: function() {
                            Swal.fire('Erreur', 'Impossible de charger le détail de cette demande.',
                                'error');
                        }
                    });
                }

                function formatMontant(value) {
                    value = parseFloat(value) || 0;
                    return value.toLocaleString('fr-FR');
                }

                function formatDateFr(dateValue) {
                    if (!dateValue) return '-';

                    let date = new Date(dateValue);

                    if (isNaN(date.getTime())) {
                        return dateValue;
                    }

                    return date.toLocaleDateString('fr-FR');
                }
                </script>

                <div class="card-footer clearfix">
                    <div class="float-left">
                        <small class="text-muted">
                            Liste des demandes validées et prêtes pour l’achat ou l’approvisionnement.
                        </small>
                    </div>

                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </div>

            </div>

        </div>
    </section>
</div>