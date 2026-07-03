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

            <!-- ici le contenu du plan comptable -->

            <style>
                .finance-card {
                    border: none;
                    border-radius: 16px;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
                }

                .finance-stat {
                    border-radius: 16px;
                    padding: 18px;
                    color: #fff;
                    min-height: 115px;
                    position: relative;
                    overflow: hidden;
                }

                .finance-stat i {
                    position: absolute;
                    right: 18px;
                    bottom: 12px;
                    font-size: 46px;
                    opacity: .22;
                }

                .bg-finance-green {
                    background: linear-gradient(135deg, #0f766e, #74c476);
                }

                .bg-finance-blue {
                    background: linear-gradient(135deg, #0f172a, #2563eb);
                }

                .bg-finance-orange {
                    background: linear-gradient(135deg, #92400e, #f59e0b);
                }

                .bg-finance-purple {
                    background: linear-gradient(135deg, #581c87, #9333ea);
                }

                .section-title-finance {
                    font-weight: 700;
                    color: #102033;
                }

                .btn-finance {
                    background: #0f766e;
                    color: #fff;
                    border-radius: 10px;
                    font-weight: 600;
                }

                .btn-finance:hover {
                    background: #0b5f59;
                    color: #fff;
                }

                .finance-table thead th {
                    background: #102033;
                    color: #fff;
                    border: none;
                    font-size: 13px;
                    text-transform: uppercase;
                }

                .finance-table td {
                    vertical-align: middle;
                    font-size: 14px;
                }

                .account-code {
                    background: #ecfdf5;
                    color: #0f766e;
                    padding: 7px 12px;
                    border-radius: 10px;
                    font-weight: 800;
                    display: inline-block;
                }

                .badge-active {
                    background: #dcfce7;
                    color: #166534;
                    padding: 7px 12px;
                    border-radius: 30px;
                }

                .badge-inactive {
                    background: #fee2e2;
                    color: #991b1b;
                    padding: 7px 12px;
                    border-radius: 30px;
                }

                .badge-cash {
                    background: #dbeafe;
                    color: #1d4ed8;
                    padding: 7px 12px;
                    border-radius: 30px;
                }

                .badge-bank {
                    background: #fef3c7;
                    color: #92400e;
                    padding: 7px 12px;
                    border-radius: 30px;
                }

                .badge-site {
                    background: #ede9fe;
                    color: #6d28d9;
                    padding: 7px 12px;
                    border-radius: 30px;
                }

                .finance-table thead th {

                    background: #102033;
                    color: #fff;

                    font-size: 13px;
                    font-weight: 700;

                    text-transform: uppercase;

                    letter-spacing: .4px;

                    vertical-align: middle;

                    border: none;

                    padding: 16px 12px;

                    white-space: nowrap;
                }

                .finance-table tbody td {

                    padding: 14px 12px;

                    vertical-align: middle;

                    border-top: 1px solid #edf2f7;

                    font-size: 14px;

                }

                .finance-table tbody tr:hover {

                    background: #f8fbfd;

                }

                .finance-table th.text-right,
                .finance-table td.text-right {

                    text-align: right;

                }

                .finance-table th.text-center,
                .finance-table td.text-center {

                    text-align: center;

                }

                .finance-table {

                    font-size: 14px;

                }

                .finance-table thead th {

                    background: #132235;

                    color: #fff;

                    border: none;

                    padding: 16px 14px;

                    white-space: nowrap;

                    font-weight: 700;

                }

                .finance-table tbody td {

                    vertical-align: middle;

                    padding: 18px 14px;

                }

                .finance-table tbody tr {

                    transition: .2s;

                }

                .finance-table tbody tr:hover {

                    background: #f5f9fc;

                }

                .account-code {

                    background: #E9F8F0;

                    color: #0f766e;

                    font-weight: 700;

                    padding: 8px 14px;

                    border-radius: 30px;

                    display: inline-block;

                    min-width: 95px;

                    text-align: center;

                }

                .finance-table .btn {

                    width: 34px;

                    height: 34px;

                    padding: 0;

                    margin: 2px;

                }
            </style>

            <!-- Statistiques -->
            <div class="row mb-4">

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-green">
                        <h6>Total comptes</h6>
                        <h2 class="font-weight-bold mb-0">0</h2>
                        <small>Plan comptable SATRACO</small>
                        <i class="fas fa-list-alt"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-blue">
                        <h6>Comptes actifs</h6>
                        <h2 class="font-weight-bold mb-0">0</h2>
                        <small>Disponibles en saisie</small>
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-orange">
                        <h6>Caisses chantiers</h6>
                        <h2 class="font-weight-bold mb-0">0</h2>
                        <small>Comptes rattachés aux chantiers</small>
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="finance-stat bg-finance-purple">
                        <h6>Norme</h6>
                        <h2 class="font-weight-bold mb-0">OHADA</h2>
                        <small>Structure comptable</small>
                        <i class="fas fa-balance-scale"></i>
                    </div>
                </div>

            </div>

            <!-- Explication + actions -->
            <div class="row mb-4">

                <div class="col-md-8">
                    <div class="card finance-card">
                        <div class="card-body">
                            <h5 class="section-title-finance">
                                <i class="fas fa-info-circle mr-2 text-success"></i>
                                Plan comptable
                            </h5>

                            <p class="text-muted mb-0">
                                Le plan comptable regroupe tous les comptes utilisés dans les écritures comptables.
                                Chez SATRACO, certains comptes peuvent être rattachés à un chantier, par exemple une
                                caisse
                                propre à un chantier. Cela permettra de suivre le solde comptable par chantier.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card finance-card">
                        <div class="card-body text-center">

                            <button class="btn btn-finance btn-block" data-toggle="modal"
                                data-target="#addAccountModal">
                                <i class="fas fa-plus-circle mr-1"></i>
                                Nouveau compte
                            </button>

                            <button class="btn btn-outline-secondary btn-block mt-2">
                                <i class="fas fa-download mr-1"></i>
                                Charger modèle OHADA
                            </button>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Filtres -->
            <div class="card finance-card mb-4">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-3">
                            <label>Classe comptable</label>
                            <select class="form-control">
                                <option value="">Toutes les classes</option>
                                <option>Classe 1 - Ressources durables</option>
                                <option>Classe 2 - Immobilisations</option>
                                <option>Classe 3 - Stocks</option>
                                <option>Classe 4 - Tiers</option>
                                <option>Classe 5 - Trésorerie</option>
                                <option>Classe 6 - Charges</option>
                                <option>Classe 7 - Produits</option>
                                <option>Classe 8 - Comptes spéciaux</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Type de compte</label>
                            <select class="form-control">
                                <option value="">Tous les types</option>
                                <option>Caisse</option>
                                <option>Banque</option>
                                <option>Client</option>
                                <option>Fournisseur</option>
                                <option>Charge</option>
                                <option>Produit</option>
                                <option>Stock</option>
                                <option>Immobilisation</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Statut</label>
                            <select class="form-control">
                                <option value="">Tous</option>
                                <option>Actif</option>
                                <option>Inactif</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Recherche</label>
                            <input type="text" class="form-control" placeholder="Code ou intitulé...">
                        </div>

                    </div>
                </div>
            </div>



            <!-- Liste -->
            <div class="card finance-card">

                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="section-title-finance mb-0">Liste du plan comptable</h5>
                            <small class="text-muted">
                                Comptes généraux, comptes de trésorerie, comptes chantiers et comptes de charges.
                            </small>
                        </div>

                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-file-export mr-1"></i>
                            Exporter
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table table-hover finance-table mb-0">
                            <thead class="finance-header">
                                <tr>

                                    <th style="width:140px">Code compte</th>

                                    <th>Intitulé du compte</th>

                                    <th style="width:110px">Classe</th>

                                    <th style="width:130px">Type</th>

                                    <th style="width:180px">Chantier</th>

                                    <th class="text-right" style="width:140px">Solde initial</th>

                                    <th class="text-center" style="width:90px">Devise</th>

                                    <th class="text-center" style="width:110px">Statut</th>

                                    <th class="text-center" style="width:150px">Actions</th>

                                </tr>
                            </thead>

                            <tbody>

                                <?php if (!empty($chart_accounts)): ?>

                                    <?php foreach ($chart_accounts as $account): ?>

                                        <tr>

                                            <td>

                                                <span class="account-code">

                                                    <?= $account->account_code; ?>

                                                </span>

                                            </td>

                                            <td>

                                                <div class="font-weight-bold">

                                                    <?= $account->account_name; ?>

                                                </div>

                                                <small class="text-muted">

                                                    <?= $account->description; ?>

                                                </small>

                                            </td>

                                            <td>

                                                <span class="badge badge-secondary">

                                                    <?= $account->class_number; ?>

                                                </span>

                                            </td>

                                            <td>

                                                <?php

                                                switch ($account->account_type) {

                                                    case 'Banque':
                                                        $color = 'primary';
                                                        break;

                                                    case 'Caisse':
                                                        $color = 'success';
                                                        break;

                                                    case 'Client':
                                                        $color = 'info';
                                                        break;

                                                    case 'Fournisseur':
                                                        $color = 'warning';
                                                        break;

                                                    case 'Charge':
                                                        $color = 'danger';
                                                        break;

                                                    case 'Produit':
                                                        $color = 'purple';
                                                        break;

                                                    case 'Immobilisation':
                                                        $color = 'dark';
                                                        break;

                                                    default:
                                                        $color = 'secondary';
                                                }

                                                ?>

                                                <span class="badge badge-<?= $color; ?>">

                                                    <?= $account->account_type; ?>

                                                </span>

                                            </td>

                                            <td>

                                                <?php if (!empty($account->chantier_name)): ?>

                                                    <span class="badge badge-light">

                                                        <?= $account->chantier_name; ?>

                                                    </span>

                                                <?php else: ?>

                                                    <span class="text-muted">

                                                        Aucun

                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                            <td class="text-right font-weight-bold">

                                                <?= number_format($account->opening_balance, 2, ',', ' '); ?>

                                            </td>

                                            <td class="text-center">

                                                <?= $account->currency; ?>

                                            </td>

                                            <td class="text-center">

                                                <?php if ($account->status == 'active'): ?>

                                                    <span class="badge badge-success">

                                                        Actif

                                                    </span>

                                                <?php else: ?>

                                                    <span class="badge badge-danger">

                                                        Inactif

                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                            <td class="text-center">

                                                <button class="btn btn-info btn-sm">

                                                    <i class="fas fa-eye"></i>

                                                </button>

                                                <button type="button" class="btn btn-warning btn-sm" onclick="editChartAccount(
                                                        '<?= $account->id ?>',
                                                        '<?= htmlspecialchars($account->account_code, ENT_QUOTES) ?>',
                                                        '<?= htmlspecialchars($account->account_name, ENT_QUOTES) ?>',
                                                        '<?= $account->class_id ?>',
                                                        '<?= htmlspecialchars($account->account_type, ENT_QUOTES) ?>',
                                                        '<?= $account->chantier_id ?>',
                                                        '<?= $account->opening_balance ?>',
                                                        '<?= htmlspecialchars($account->currency, ENT_QUOTES) ?>',
                                                        '<?= htmlspecialchars($account->status, ENT_QUOTES) ?>',
                                                        '<?= $account->allow_entry ?>',
                                                        '<?= htmlspecialchars($account->description, ENT_QUOTES) ?>'
                                                    )">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="deleteChartAccount('<?= $account->id ?>')">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal ajout compte comptable -->
<div class="modal fade" id="addAccountModal">
    <div class="modal-dialog modal-lg">

        <form action="<?= base_url('finance/chart-account-store') ?>" method="post">

            <div class="modal-content">

                <div class="modal-header" style="background:#0f766e;color:#fff;">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Nouveau compte comptable
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i>
                        Créez ici les comptes utilisés dans les écritures comptables.
                        Pour les caisses chantier, rattachez le compte au chantier concerné.
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Code compte *</label>
                                <input type="text" name="account_code" class="form-control" placeholder="Ex : 521001"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Intitulé du compte *</label>
                                <input type="text" name="account_name" class="form-control"
                                    placeholder="Ex : Caisse Chantier Gitega" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classe comptable *</label>
                                <select name="class_id" class="form-control" required>
                                    <option value="">-- Sélectionner --</option>
                                    <?php if (!empty($account_classes)) : ?>
                                        <?php foreach ($account_classes as $class) : ?>
                                            <option value="<?= $class->id ?>">
                                                Classe <?= $class->class_number ?> - <?= $class->class_name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type de compte *</label>
                                <select name="account_type" class="form-control" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Caisse">Caisse</option>
                                    <option value="Banque">Banque</option>
                                    <option value="Client">Client</option>
                                    <option value="Fournisseur">Fournisseur</option>
                                    <option value="Charge">Charge</option>
                                    <option value="Produit">Produit</option>
                                    <option value="Stock">Stock</option>
                                    <option value="Immobilisation">Immobilisation</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Chantier lié</label>
                                <select name="chantier_id" class="form-control">
                                    <option value="">Aucun chantier</option>
                                    <?php if (!empty($chantiers)) : ?>
                                        <?php foreach ($chantiers as $chantier) : ?>
                                            <option value="<?= $chantier->id ?>">
                                                <?= $chantier->nom_chantier ?? $chantier->name ?? 'Chantier' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <small class="text-muted">À utiliser surtout pour les caisses de chantier.</small>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Solde initial</label>
                                <input type="number" name="opening_balance" class="form-control" value="0" step="0.01">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Devise</label>
                                <select name="currency" class="form-control">
                                    <option value="FBU">FBU</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut</label>
                                <select name="status" class="form-control">
                                    <option value="active">Actif</option>
                                    <option value="inactive">Inactif</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Compte utilisable en saisie ?</label>
                                <select name="allow_entry" class="form-control">
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description / Observation</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Information complémentaire sur le compte"></textarea>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-finance">
                        <i class="fas fa-save mr-1"></i>
                        Enregistrer
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

<div class="modal fade" id="editAccountModal">
    <div class="modal-dialog modal-lg">
        <form action="<?= base_url('finance/chart-account-update') ?>" method="post">

            <input type="hidden" name="id" id="edit_id">

            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-1"></i>
                        Modifier le compte comptable
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Code compte *</label>
                                <input type="text" name="account_code" id="edit_account_code" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Intitulé du compte *</label>
                                <input type="text" name="account_name" id="edit_account_name" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classe comptable *</label>
                                <select name="class_id" id="edit_class_id" class="form-control" required>
                                    <option value="">-- Sélectionner --</option>
                                    <?php foreach ($account_classes as $class) : ?>
                                        <option value="<?= $class->id ?>">
                                            Classe <?= $class->class_number ?> - <?= $class->class_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type de compte *</label>
                                <select name="account_type" id="edit_account_type" class="form-control" required>
                                    <option value="Caisse">Caisse</option>
                                    <option value="Banque">Banque</option>
                                    <option value="Client">Client</option>
                                    <option value="Fournisseur">Fournisseur</option>
                                    <option value="Charge">Charge</option>
                                    <option value="Produit">Produit</option>
                                    <option value="Stock">Stock</option>
                                    <option value="Immobilisation">Immobilisation</option>
                                    <option value="Personnel">Personnel</option>
                                    <option value="Etat">Etat</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Chantier lié</label>
                                <select name="chantier_id" id="edit_chantier_id" class="form-control">
                                    <option value="">Aucun chantier</option>
                                    <?php foreach ($chantiers as $chantier) : ?>
                                        <option value="<?= $chantier->id ?>">
                                            <?= $chantier->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Solde initial</label>
                                <input type="number" name="opening_balance" id="edit_opening_balance"
                                    class="form-control" step="0.01">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Devise</label>
                                <select name="currency" id="edit_currency" class="form-control">
                                    <option value="FBU">FBU</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut</label>
                                <select name="status" id="edit_status" class="form-control">
                                    <option value="active">Actif</option>
                                    <option value="inactive">Inactif</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Compte utilisable en saisie ?</label>
                                <select name="allow_entry" id="edit_allow_entry" class="form-control">
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description / Observation</label>
                                <textarea name="description" id="edit_description" class="form-control"
                                    rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        Annuler
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
    function editChartAccount(id, account_code, account_name, class_id, account_type, chantier_id, opening_balance,
        currency, status, allow_entry, description) {
        $('#edit_id').val(id);
        $('#edit_account_code').val(account_code);
        $('#edit_account_name').val(account_name);
        $('#edit_class_id').val(class_id);
        $('#edit_account_type').val(account_type);
        $('#edit_chantier_id').val(chantier_id);
        $('#edit_opening_balance').val(opening_balance);
        $('#edit_currency').val(currency);
        $('#edit_status').val(status);
        $('#edit_allow_entry').val(allow_entry);
        $('#edit_description').val(description);

        $('#editAccountModal').modal('show');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function deleteChartAccount(id) {
        Swal.fire({

            title: 'Supprimer ce compte ?',

            text: "Cette opération est irréversible.",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc3545',

            cancelButtonColor: '#6c757d',

            confirmButtonText: '<i class="fas fa-trash"></i> Oui, supprimer',

            cancelButtonText: '<i class="fas fa-times"></i> Annuler',

            reverseButtons: true

        }).then((result) => {

            if (result.isConfirmed) {

                window.location.href = "<?= base_url('finance/chart-account-delete/') ?>" + id;

            }

        });

    }
</script>