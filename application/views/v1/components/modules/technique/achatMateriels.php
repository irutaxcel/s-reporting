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
                            <h3><?= isset($stats['demandes_validées']) ? $stats['demandes_validées'] : 0 ?></h3>
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
                            <h3><?= isset($stats['achats_effectues']) ? $stats['achats_effectues'] : 0 ?></h3>
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
                            <h3><?= isset($stats['en_approvisionnement']) ? $stats['en_approvisionnement'] : 0 ?></h3>
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
                            <h3><?= isset($stats['livraisons_retard']) ? $stats['livraisons_retard'] : 0 ?></h3>
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
                                                <label>Destination / Chantier</label>
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
                                                    <th width="170">Observation</th>
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
                                                        <input type="text" name="observation[]" class="form-control"
                                                            placeholder="">
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
                                                    <th colspan="2">
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
                            <input type="text" name="observation[]" class="form-control"
                                placeholder="">
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
                    <form action="<?= current_url() ?>" method="get">

                        <div class="row mb-3">

                            <!-- Chantier -->
                            <div class="col-md-3">
                                <div class="form-group mb-0">

                                    <label>Destination / Chantier</label>

                                    <select name="chantier_id" id="filter_chantier_id" class="form-control">

                                        <option value="">Tous les chantiers</option>

                                        <?php if (!empty($allChantiers)) : ?>

                                            <?php foreach ($allChantiers as $chantier) : ?>

                                                <option value="<?= $chantier->id ?>" <?= isset($filters['chantier_id'])
                                                                                            && (string) $filters['chantier_id'] === (string) $chantier->id
                                                                                            ? 'selected'
                                                                                            : '' ?>>

                                                    <?= html_escape($chantier->name) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        <?php endif; ?>

                                    </select>

                                </div>
                            </div>

                            <!-- Statut -->
                            <div class="col-md-3">
                                <div class="form-group mb-0">

                                    <label>Statut achat</label>

                                    <select name="workflow_status" id="filter_workflow_status" class="form-control">

                                        <option value="">Tous les statuts</option>

                                        <option value="brouillon" <?= ($filters['workflow_status'] ?? '') === 'brouillon'
                                                                        ? 'selected'
                                                                        : '' ?>>
                                            Brouillon
                                        </option>

                                        <option value="en_verification" <?= ($filters['workflow_status'] ?? '') === 'en_verification'
                                                                            ? 'selected'
                                                                            : '' ?>>
                                            En vérification
                                        </option>

                                        <option value="valide" <?= ($filters['workflow_status'] ?? '') === 'valide'
                                                                    ? 'selected'
                                                                    : '' ?>>
                                            Validée
                                        </option>

                                        <option value="en_approvisionnement" <?= ($filters['workflow_status'] ?? '') === 'en_approvisionnement'
                                                                                    ? 'selected'
                                                                                    : '' ?>>
                                            En approvisionnement
                                        </option>

                                        <option value="achat_effectue" <?= ($filters['workflow_status'] ?? '') === 'achat_effectue'
                                                                            ? 'selected'
                                                                            : '' ?>>
                                            Achat effectué
                                        </option>

                                        <option value="livre" <?= ($filters['workflow_status'] ?? '') === 'livre'
                                                                    ? 'selected'
                                                                    : '' ?>>
                                            Livré
                                        </option>

                                    </select>

                                </div>
                            </div>

                            <!-- Date début -->
                            <div class="col-md-2">
                                <div class="form-group mb-0">

                                    <label>Date début</label>

                                    <input type="date" name="date_debut" id="filter_date_debut" class="form-control"
                                        value="<?= html_escape($filters['date_debut'] ?? '') ?>">

                                </div>
                            </div>

                            <!-- Date fin -->
                            <div class="col-md-2">
                                <div class="form-group mb-0">

                                    <label>Date fin</label>

                                    <input type="date" name="date_fin" id="filter_date_fin" class="form-control"
                                        value="<?= html_escape($filters['date_fin'] ?? '') ?>">

                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="col-md-2 d-flex align-items-end">

                                <div class="btn-group btn-block">

                                    <button type="submit" class="btn btn-success">

                                        <i class="fas fa-search mr-1"></i>
                                        Filtrer

                                    </button>

                                    <a href="<?= base_url('achats-materiels') ?>" class="btn btn-secondary"
                                        title="Réinitialiser les filtres">

                                        <i class="fas fa-redo-alt"></i>

                                    </a>

                                </div>

                            </div>

                            <?php if (!empty($canSeePaidRequests)) : ?>
                                <!-- Option réservée SUPER_ADMIN / ADMINISTRATEUR_SYSTEM -->
                                <div class="col-12 mt-2">

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" name="include_payes" value="1"
                                            id="includePayes" <?= !empty($filters['include_payes']) ? 'checked' : '' ?>>

                                        <label class="form-check-label" for="includePayes">
                                            Afficher aussi les demandes déjà payées en trésorerie
                                            <span class="badge badge-secondary ml-1">Admin</span>
                                        </label>

                                    </div>

                                </div>
                            <?php endif; ?>

                        </div>

                    </form>

                    <?php
                    $dejaPayees   = (int) ($stats['deja_payees'] ?? 0);
                    $affichePayes = !empty($filters['include_payes']);

                    /* Lien "Afficher" qui conserve les autres filtres */
                    $queryAfficher = http_build_query(array_filter([
                        'chantier_id'     => $filters['chantier_id'] ?? '',
                        'workflow_status' => $filters['workflow_status'] ?? '',
                        'date_debut'      => $filters['date_debut'] ?? '',
                        'date_fin'        => $filters['date_fin'] ?? '',
                        'include_payes'   => '1',
                    ]));
                    ?>

                    <?php if (!$affichePayes && $dejaPayees > 0) : ?>
                        <div class="alert alert-light border d-flex align-items-center py-2 mb-2">

                            <i class="fas fa-info-circle text-secondary mr-2"></i>

                            <small class="mr-2">
                                <strong><?= $dejaPayees ?></strong>
                                demande(s) déjà payée(s) en trésorerie.
                            </small>

                            <?php if (!empty($canSeePaidRequests)) : ?>
                                <a href="<?= base_url('achats-materiels?' . $queryAfficher) ?>" class="badge badge-primary">
                                    Afficher
                                </a>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

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

                        /* Ligne grisée pour une demande déjà payée */
                        .table-achats tr.row-payee,
                        table tr.row-payee {
                            background-color: #f1f3f5 !important;
                        }

                        .table-achats tr.row-payee td,
                        table tr.row-payee td {
                            color: #6c757d;
                        }
                    </style>

                    <!-- Tableau -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>

                                    <th style="width:50px">#</th>

                                    <th style="width:120px">Référence</th>

                                    <th style="width:220px">Destination / Chantier</th>

                                    <th style="width:170px">Demandeur</th>

                                    <th style="width:320px">Matériel demandé</th>

                                    <th style="width:160px" class="text-center">
                                        Montant estimé
                                    </th>

                                    <th style="width:130px">
                                        Date demande
                                    </th>

                                    <?php if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2 || $this->session->userdata('role_id') == 3 || $this->session->userdata('role_id') == 4 || $this->session->userdata('role_id') == 7 || $this->session->userdata('role_id') == 24) { ?>
                                        <th style="width:150px">
                                            Validation
                                        </th>
                                    <?php } else { ?>
                                        <!-- # code... -->
                                    <?php } ?>


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

                                        <?php
                                        /* Demande déjà payée en trésorerie
                                       (visible seulement si include_payes = 1,
                                        donc uniquement pour SUPER_ADMIN / ADMIN) */
                                        $estPaye = (isset($achat->payment_status) && $achat->payment_status === 'paye');
                                        ?>

                                        <tr class="<?= $estPaye ? 'row-payee' : '' ?>">
                                            <td><?= $i++ ?></td>

                                            <td>
                                                <strong>DA-<?= date('Y', strtotime($achat->created_at)) ?>-<?= str_pad($achat->id, 3, '0', STR_PAD_LEFT) ?></strong>
                                            </td>

                                            <td>
                                                <?= !empty($achat->destination_chantier) ? $achat->destination_chantier : $achat->destination_chantier ?>
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

                                            <?php if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2 || $this->session->userdata('role_id') == 3 || $this->session->userdata('role_id') == 4 || $this->session->userdata('role_id') == 7 || $this->session->userdata('role_id') == 24) { ?>
                                                <td class="text-center text-nowrap">

                                                    <button type="button"
                                                        class="btn btn-xs <?= ($achat->technical_status == 'valide') ? 'btn-success' : 'btn-warning' ?>"
                                                        onclick="validerAchat(<?= $achat->id ?>, 'technical_status')"
                                                        <?= $estPaye ? 'disabled' : '' ?>>
                                                        DT
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-xs <?= ($achat->financial_status == 'valide') ? 'btn-success' : 'btn-warning' ?>"
                                                        onclick="validerAchat(<?= $achat->id ?>, 'financial_status')"
                                                        <?= $estPaye ? 'disabled' : '' ?>>
                                                        DAF
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-xs <?= ($achat->treasury_status == 'valide') ? 'btn-success' : 'btn-warning' ?>"
                                                        onclick="validerAchat(<?= $achat->id ?>, 'treasury_status')"
                                                        <?= $estPaye ? 'disabled' : '' ?>>
                                                        Trésorerie
                                                    </button>

                                                </td>
                                            <?php } else { ?>
                                                <!-- # code... -->
                                            <?php } ?>


                                            <td class="text-center text-nowrap">
                                                <?php if ($estPaye) : ?>
                                                    <span class="badge badge-secondary">
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        Payé — effectué
                                                    </span>
                                                <?php elseif ($achat->workflow_status == 'brouillon') : ?>
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

                                                <!-- Voir (toujours disponible) -->
                                                <button class="btn btn-sm btn-info" title="Voir détail"
                                                    onclick="voirAchat(<?= $achat->id ?>)">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <?php
                                                $paymentVoucher = $this->tech->getPaymentVoucherByRequestId($achat->id);
                                                ?>

                                                <?php if (!$estPaye) : ?>

                                                    <?php if (!empty($paymentVoucher)) : ?>

                                                        <!-- Modifier le bon de paiement existant -->
                                                        <button type="button" class="btn btn-sm btn-warning"
                                                            title="Modifier le bon de paiement"
                                                            onclick="modifierBonPaiement(<?= (int) $paymentVoucher->id ?>)">
                                                            <i class="fas fa-file-invoice-dollar"></i>
                                                            <i class="fas fa-pen ml-1"></i>
                                                        </button>

                                                    <?php else : ?>

                                                        <!-- Créer le bon de paiement -->
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            title="Créer un bon de paiement" onclick='creerBonPaiement(
                                                    <?= (int) $achat->id ?>,
                                                    <?= json_encode(
                                                            $achat->articles_designation ?? '',
                                                            JSON_HEX_TAG |
                                                                JSON_HEX_APOS |
                                                                JSON_HEX_QUOT |
                                                                JSON_HEX_AMP |
                                                                JSON_UNESCAPED_UNICODE
                                                        ) ?>,
                                                    <?= json_encode((string) $achat->total_amount) ?>,
                                                    <?= json_encode(
                                                            'DA-' .
                                                                date('Y', strtotime($achat->created_at)) .
                                                                '-' .
                                                                str_pad($achat->id, 3, '0', STR_PAD_LEFT)
                                                        ) ?>
                                                    )'>
                                                            <i class="fas fa-file-invoice-dollar"></i>
                                                        </button>

                                                    <?php endif; ?>

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

                                                <?php endif; ?>

                                                <?php if (!empty($paymentVoucher)) : ?>
                                                    <!-- Imprimer (toujours disponible) -->
                                                    <button class="btn btn-sm btn-secondary" title="Imprimer"
                                                        onclick="window.open('<?= base_url('tech/print-achat/' . $achat->id) ?>','_blank')">
                                                        <i class="fas fa-print"></i>
                                                    </button>
                                                <?php endif; ?>

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

                <div class="modal fade" id="modalModifierBonPaiement" tabindex="-1" role="dialog"
                    aria-labelledby="modalModifierBonPaiementLabel" aria-hidden="true">

                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                        <form action="<?= base_url('tech/update-bon-paiement') ?>" method="post"
                            id="formModifierBonPaiement">

                            <div class="modal-content">

                                <!-- ID du bon -->
                                <input type="hidden" name="payment_voucher_id" id="edit_payment_voucher_id">

                                <!-- ID de la demande -->
                                <input type="hidden" name="request_id" id="edit_payment_request_id">

                                <!-- CSRF -->
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                    value="<?= $this->security->get_csrf_hash(); ?>">

                                <div class="modal-header bg-warning">

                                    <h5 class="modal-title" id="modalModifierBonPaiementLabel">

                                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                                        Modifier le bon de paiement

                                    </h5>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">

                                        <span aria-hidden="true">
                                            &times;
                                        </span>

                                    </button>

                                </div>

                                <div class="modal-body">

                                    <!-- Informations du bon -->
                                    <div class="alert alert-light border mb-4">

                                        <div class="row">

                                            <div class="col-md-6">

                                                <small class="text-muted d-block">
                                                    Numéro du bon
                                                </small>

                                                <strong id="edit_payment_number_display">
                                                    -
                                                </strong>

                                            </div>

                                            <div class="col-md-6 text-md-right">

                                                <small class="text-muted d-block">
                                                    Référence de la demande
                                                </small>

                                                <strong id="edit_request_reference_display">
                                                    -
                                                </strong>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <!-- Synthèse -->
                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label for="edit_payment_summary">
                                                    Synthèse de la demande
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <textarea name="summary" id="edit_payment_summary" class="form-control"
                                                    rows="3" required></textarea>

                                            </div>

                                        </div>

                                        <!-- Mode de paiement -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="edit_payment_mode">
                                                    Mode de paiement
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select name="payment_mode" id="edit_payment_mode" class="form-control"
                                                    required>

                                                    <option value="">
                                                        Sélectionner
                                                    </option>

                                                    <option value="especes">
                                                        Espèces
                                                    </option>

                                                    <option value="cheque">
                                                        Chèque
                                                    </option>

                                                    <option value="virement_bancaire">
                                                        Virement bancaire
                                                    </option>

                                                    <option value="versement_bancaire_espece">
                                                        Versement Bancaire en espece
                                                    </option>

                                                    <option value="transfert_mobile">
                                                        Transfert mobile
                                                    </option>

                                                    <option value="autre">
                                                        Autre
                                                    </option>

                                                </select>

                                            </div>

                                        </div>

                                        <!-- Montant -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="edit_amount_paid">
                                                    Montant payé
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <div class="input-group">

                                                    <input type="number" name="amount_paid" id="edit_amount_paid"
                                                        class="form-control" min="0" step="0.01" required>

                                                    <div class="input-group-append">

                                                        <span class="input-group-text">
                                                            BIF
                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- Référence paiement -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="edit_payment_reference">
                                                    Référence du paiement
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="payment_reference" id="edit_payment_reference"
                                                    class="form-control" required>

                                            </div>

                                        </div>

                                        <!-- Date paiement -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="edit_payment_date">
                                                    Date de paiement
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="date" name="payment_date" id="edit_payment_date"
                                                    class="form-control" required>

                                            </div>

                                        </div>

                                        <!-- Statut -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="edit_payment_status">
                                                    Statut du paiement
                                                </label>

                                                <select name="payment_status" id="edit_payment_status"
                                                    class="form-control">

                                                    <option value="en_attente">
                                                        En attente
                                                    </option>

                                                    <option value="effectue">
                                                        Effectué
                                                    </option>

                                                    <option value="annule">
                                                        Annulé
                                                    </option>

                                                </select>

                                            </div>

                                        </div>

                                        <!-- Observation -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="edit_payment_observation">
                                                    Observation
                                                </label>

                                                <textarea name="observation" id="edit_payment_observation"
                                                    class="form-control" rows="2"></textarea>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                        <i class="fas fa-times mr-1"></i>
                                        Fermer

                                    </button>

                                    <button type="submit" class="btn btn-warning">

                                        <i class="fas fa-save mr-1"></i>
                                        Enregistrer les modifications

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <script>
                    function modifierBonPaiement(id) {
                        $.ajax({

                            url: "<?= base_url('tech/get-bon-paiement/') ?>" + id,

                            type: "GET",

                            dataType: "json",

                            beforeSend: function() {

                                Swal.fire({
                                    title: 'Chargement...',
                                    text: 'Récupération du bon de paiement.',
                                    allowOutsideClick: false,
                                    didOpen: function() {
                                        Swal.showLoading();
                                    }
                                });

                            },

                            success: function(response) {

                                Swal.close();

                                if (!response.status || !response.bon) {

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erreur',
                                        text: response.message || 'Bon introuvable.'
                                    });

                                    return;
                                }

                                const bon = response.bon;

                                $('#edit_payment_voucher_id').val(bon.id);

                                $('#edit_payment_request_id').val(bon.request_id);

                                $('#edit_payment_summary').val(bon.summary);

                                $('#edit_payment_mode').val(bon.payment_mode);

                                $('#edit_amount_paid').val(bon.amount_paid);

                                $('#edit_payment_reference').val(
                                    bon.payment_reference
                                );

                                $('#edit_payment_date').val(
                                    bon.payment_date
                                );

                                $('#edit_payment_status').val(
                                    bon.payment_status
                                );

                                $('#edit_payment_observation').val(
                                    bon.observation || ''
                                );

                                $('#edit_payment_number_display').text(
                                    bon.payment_number || '-'
                                );

                                let referenceDemande =
                                    'DA-' +
                                    new Date(bon.request_created_at).getFullYear() +
                                    '-' +
                                    String(bon.request_id).padStart(3, '0');

                                $('#edit_request_reference_display').text(
                                    referenceDemande
                                );

                                $('#modalModifierBonPaiement').modal('show');
                            },

                            error: function(xhr) {

                                Swal.close();

                                let message =
                                    'Impossible de récupérer le bon de paiement.';

                                if (
                                    xhr.responseJSON &&
                                    xhr.responseJSON.message
                                ) {
                                    message = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: message
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
                                            <label>Destination / Chantier</label>
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
                                                    <th width="170">Observation</th>
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

                                console.log(achat.chantier_id);

                                $('#editArticlesTable tbody').html('');

                                if (items.length > 0) {
                                    items.forEach(function(item) {
                                        addEditArticleRow(
                                            item.designation,
                                            item.quantity,
                                            item.unit_price,
                                            item.total_price,
                                            item.observations
                                        );
                                    });
                                } else {
                                    addEditArticleRow();
                                }

                                $('#modalModifierAchat').modal('show');
                            }
                        });
                    }

                    function addEditArticleRow(article = '', quantite = 1, prix = 0, total = 0, observations = '') {
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
                                <input type="text" name="observation[]" class="form-control edit_observation"
                                    value="${observations}">
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
                                                <td>${item.designation}</td>
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

                <!-- Modal Bon de paiement -->
                <div class="modal fade" id="modalBonPaiement" tabindex="-1" role="dialog"
                    aria-labelledby="modalBonPaiementLabel" aria-hidden="true">

                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

                        <form action="<?= base_url('tech/store-bon-paiement') ?>" method="post" id="formBonPaiement">

                            <div class="modal-content">

                                <!-- ID de la demande -->
                                <input type="hidden" name="request_id" id="payment_request_id">

                                <!-- Token CSRF -->
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                    value="<?= $this->security->get_csrf_hash(); ?>">

                                <div class="modal-header bg-primary text-white">

                                    <h5 class="modal-title" id="modalBonPaiementLabel">
                                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                                        Créer un bon de paiement
                                    </h5>

                                    <button type="button" class="close text-white" data-dismiss="modal"
                                        aria-label="Fermer">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <!-- Informations demande -->
                                    <div class="alert alert-light border mb-4">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <small class="text-muted d-block">
                                                    Référence de la demande
                                                </small>

                                                <strong id="payment_request_reference">
                                                    -
                                                </strong>
                                            </div>

                                            <div class="col-md-6 text-md-right">
                                                <small class="text-muted d-block">
                                                    Montant de la demande
                                                </small>

                                                <strong id="payment_request_amount_display" class="text-primary">
                                                    0 BIF
                                                </strong>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <!-- Synthèse -->
                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label for="payment_summary">
                                                    Synthèse de la demande
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <textarea name="summary" id="payment_summary" class="form-control"
                                                    rows="3"
                                                    placeholder="Exemple : Achat de ciment, fers à béton et gravier..."
                                                    required></textarea>

                                                <small class="form-text text-muted">
                                                    Résumez brièvement la nature du paiement demandé.
                                                </small>

                                            </div>

                                        </div>

                                        <!-- Mode paiement -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="payment_mode">
                                                    Mode de paiement
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select name="payment_mode" id="payment_mode" class="form-control"
                                                    required>

                                                    <option value="">
                                                        Sélectionner le mode de paiement
                                                    </option>

                                                    <option value="especes">
                                                        Espèces
                                                    </option>

                                                    <option value="cheque">
                                                        Chèque
                                                    </option>

                                                    <option value="virement_bancaire">
                                                        Virement bancaire
                                                    </option>

                                                    <option value="transfert_mobile">
                                                        Transfert via téléphone mobile
                                                    </option>

                                                    <option value="versement_bancaire_espece">
                                                        Versement Bancaire en espece
                                                    </option>

                                                    <option value="autre">
                                                        Autre
                                                    </option>

                                                </select>

                                            </div>

                                        </div>

                                        <!-- Montant payé -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="payment_amount">
                                                    Montant payé
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <div class="input-group">

                                                    <input type="number" name="amount_paid" id="payment_amount"
                                                        class="form-control" min="0" step="0.01" readonly required>

                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            BIF
                                                        </span>
                                                    </div>

                                                </div>

                                                <small class="form-text text-muted">
                                                    Le montant est récupéré automatiquement depuis la demande d'achat.
                                                </small>

                                            </div>

                                        </div>

                                        <!-- Référence paiement -->
                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label for="payment_reference">
                                                    Référence du paiement
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="payment_reference" id="payment_reference"
                                                    class="form-control"
                                                    placeholder="Exemple : CHQ-45869, VIR-2026-001, TX-458977..."
                                                    required>

                                                <small class="form-text text-muted">
                                                    Numéro du chèque, référence bancaire, numéro de transaction ou autre
                                                    justificatif.
                                                </small>

                                            </div>

                                        </div>

                                        <!-- Date paiement -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="payment_date">
                                                    Date de paiement
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="date" name="payment_date" id="payment_date"
                                                    class="form-control" value="<?= date('Y-m-d') ?>" required>

                                            </div>

                                        </div>

                                        <!-- Observation -->
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="payment_observation">
                                                    Observation
                                                </label>

                                                <input type="text" name="observation" id="payment_observation"
                                                    class="form-control" placeholder="Observation facultative">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                        <i class="fas fa-times mr-1"></i>
                                        Fermer

                                    </button>

                                    <button type="submit" class="btn btn-primary">

                                        <i class="fas fa-save mr-1"></i>
                                        Enregistrer le bon

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <script>
                    function creerBonPaiement(id, synthese, montant, referenceDemande) {
                        let montantNumerique = parseFloat(montant) || 0;

                        $('#payment_request_id').val(id);

                        $('#payment_summary').val(
                            synthese && synthese.trim() !== '' ?
                            synthese :
                            'Paiement lié à la demande ' + referenceDemande
                        );

                        $('#payment_amount').val(montantNumerique.toFixed(2));

                        $('#payment_request_reference').text(referenceDemande);

                        $('#payment_request_amount_display').text(
                            montantNumerique.toLocaleString('fr-FR') + ' BIF'
                        );

                        /*
                         * Réinitialiser les champs spécifiques au paiement
                         */
                        $('#payment_mode').val('');
                        $('#payment_reference').val('');
                        $('#payment_observation').val('');
                        $('#payment_date').val('<?= date('Y-m-d') ?>');

                        $('#modalBonPaiement').modal('show');
                    }
                </script>

                <!-- <div class="card-footer clearfix">
                    <div class="float-left">
                        <small class="text-muted">
                            Liste des demandes validées et prêtes pour l'achat ou l'approvisionnement.
                            Les demandes déjà payées en trésorerie sont masquées par défaut
                            (consultation réservée au Super Admin / Administrateur).
                        </small>
                    </div>

                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </div> -->

            </div>

        </div>
    </section>
</div>