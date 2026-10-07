<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* ---------------------------------------------------------------------
 |  Préparation de l'affichage
 * --------------------------------------------------------------------- */
$total    = (int) ($stats->total ?? 0);
$reformes = (int) ($stats->reformes ?? 0);
$actifs   = max(0, $total - $reformes);
$pct      = function ($n) use ($actifs) {
    return $actifs > 0 ? round($n * 100 / $actifs) : 0;
};
$repartition = [
    ['Disponible',   (int) ($stats->disponible ?? 0),   'bg-success'],
    ['Sur chantier', (int) ($stats->sur_chantier ?? 0), 'bg-primary'],
    ['Maintenance',  (int) ($stats->maintenance ?? 0),  'bg-warning'],
    ['En panne',     (int) ($stats->en_panne ?? 0),     'bg-danger'],
];

$query = array_filter([
    'q'            => $filters['q'],
    'categorie_id' => $filters['categorie_id'] ?: null,
    'etat'         => $filters['etat'],
    'chantier_id'  => $filters['chantier_id'] ?: null,
]);
$hasFilters = !empty($query);
$noImage    = base_url('assets/v1/dist/img/no-image.png');

$photoUrl = function ($e) use ($noImage) {
    return !empty($e->photo_principale) ? base_url('uploads/engins/photos/' . $e->photo_principale) : $noImage;
};
$lieu = function ($e) {
    return $e->chantier_name ?: ($e->localisation ?: '-');
};

/** Menu d'actions d'un engin (grille et tableau) */
$actions = function ($e) {
    $id   = (int) $e->id;
    $name = eq_e($e->code_engin . ' — ' . $e->designation);
    $reforme = $e->etat === 'Réformé';
    ob_start(); ?>
<button type="button" class="btn btn-sm eq-btn-light" data-action="dossier" data-id="<?= $id ?>"
    title="Fiche & rapport">
    <i class="fas fa-file-alt mr-1"></i>Fiche
</button>
<button type="button" class="btn btn-sm eq-btn-light eq-icon-btn" data-action="edit" data-id="<?= $id ?>"
    title="Modifier">
    <i class="fas fa-pen"></i>
</button>
<div class="dropdown d-inline-block">
    <button type="button" class="btn btn-sm eq-btn-light eq-icon-btn" data-toggle="dropdown" title="Plus d'actions">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        <?php if (!$reforme): ?>
        <a class="dropdown-item" href="#" data-action="affect" data-id="<?= $id ?>">
            <i class="fas fa-exchange-alt fa-fw mr-2 text-primary"></i>Affecter / transférer
        </a>
        <a class="dropdown-item" href="<?= base_url('maintenance-carburant?engin_id=' . $id . '#fuel') ?>">
            <i class="fas fa-gas-pump fa-fw mr-2 text-success"></i>Nouveau ravitaillement
        </a>
        <a class="dropdown-item" href="<?= base_url('maintenance-carburant?engin_id=' . $id . '#maintenance') ?>">
            <i class="fas fa-tools fa-fw mr-2 text-warning"></i>Nouvelle maintenance
        </a>
        <a class="dropdown-item" href="<?= base_url('maintenance-carburant?engin_id=' . $id . '#panne') ?>">
            <i class="fas fa-car-crash fa-fw mr-2 text-danger"></i>Signaler une panne
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-action="reform" data-id="<?= $id ?>" data-name="<?= $name ?>">
            <i class="fas fa-archive fa-fw mr-2 text-secondary"></i>Réformer (sortir du parc)
        </a>
        <?php endif; ?>
        <a class="dropdown-item text-danger" href="#" data-action="delete" data-id="<?= $id ?>"
            data-name="<?= $name ?>">
            <i class="fas fa-trash-alt fa-fw mr-2"></i>Supprimer
        </a>
    </div>
</div>
<?php return ob_get_clean();
};
?>
<link rel="stylesheet" href="<?= base_url('assets/v1/dist/css/module-engins.css?v=2') ?>">

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= eq_e($title) ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= eq_e($title) ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid eq-page">

            <!-- Messages -->
            <?php foreach (['success' => 'check-circle', 'warning' => 'exclamation-triangle', 'error' => 'exclamation-circle'] as $type => $icon): ?>
            <?php if ($msg = $this->session->flashdata($type)): ?>
            <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?> alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-<?= $icon ?> mr-1"></i><?= eq_e($msg) ?>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>

            <!-- Statistiques -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="eq-stat is-green">
                        <p class="eq-stat-value"><?= $actifs ?></p>
                        <p class="eq-stat-label">Engins & matériels actifs</p>
                        <span class="eq-stat-sub">Valeur d'acquisition :
                            <?= eq_money($stats->valeur_parc ?? 0) ?></span>
                        <i class="fas fa-truck-monster eq-stat-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="eq-stat is-blue">
                        <p class="eq-stat-value"><?= (int) ($stats->sur_chantier ?? 0) ?></p>
                        <p class="eq-stat-label">Sur chantier</p>
                        <span class="eq-stat-sub"><?= $pct((int) ($stats->sur_chantier ?? 0)) ?> % du parc engagé</span>
                        <i class="fas fa-hard-hat eq-stat-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="eq-stat is-orange">
                        <p class="eq-stat-value"><?= (int) ($stats->maintenance ?? 0) ?></p>
                        <p class="eq-stat-label">En maintenance</p>
                        <span class="eq-stat-sub">Disponibles : <?= (int) ($stats->disponible ?? 0) ?></span>
                        <i class="fas fa-tools eq-stat-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="eq-stat is-red">
                        <p class="eq-stat-value"><?= (int) ($stats->en_panne ?? 0) ?></p>
                        <p class="eq-stat-label">En panne</p>
                        <span class="eq-stat-sub">Réformés : <?= $reformes ?></span>
                        <i class="fas fa-exclamation-triangle eq-stat-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="row mb-2">
                <div class="col-lg-3 col-6 mb-3">
                    <a href="#" class="eq-action" data-action="new-engin">
                        <div class="eq-action-icon"><i class="fas fa-plus"></i></div>
                        <h6>Ajouter un engin</h6><small>Nouvel équipement</small>
                    </a>
                </div>
                <div class="col-lg-3 col-6 mb-3">
                    <a href="#" class="eq-action" data-action="affect">
                        <div class="eq-action-icon"><i class="fas fa-exchange-alt"></i></div>
                        <h6>Affecter à un chantier</h6><small>Sortie, transfert ou retour</small>
                    </a>
                </div>
                <div class="col-lg-3 col-6 mb-3">
                    <a href="<?= base_url('maintenance-carburant#fuel') ?>" class="eq-action">
                        <div class="eq-action-icon"><i class="fas fa-gas-pump"></i></div>
                        <h6>Carburant</h6><small>Saisir un ravitaillement</small>
                    </a>
                </div>
                <div class="col-lg-3 col-6 mb-3">
                    <a href="<?= base_url('maintenance-carburant#maintenance') ?>" class="eq-action">
                        <div class="eq-action-icon"><i class="fas fa-wrench"></i></div>
                        <h6>Maintenance</h6><small>Réparation / entretien</small>
                    </a>
                </div>
            </div>

            <!-- Filtres -->
            <div class="eq-card mb-4">
                <div class="eq-card-head">
                    <div>
                        <h5 class="eq-title"><i class="fas fa-filter text-success"></i>Filtrage des engins</h5>
                        <span class="eq-sub">Recherche par code, désignation, plaque, marque, modèle ou n° de
                            série.</span>
                    </div>
                    <?php if ($hasFilters): ?>
                    <span class="eq-chip"><i class="fas fa-filter"></i><?= count($engins) ?> résultat(s)
                        filtré(s)</span>
                    <?php endif; ?>
                </div>
                <div class="eq-card-body">
                    <form method="get" action="<?= base_url('engin-materiel') ?>" class="eq-filter">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-2">
                                <label for="f_q">Recherche</label>
                                <input type="search" name="q" id="f_q" class="form-control"
                                    value="<?= eq_e($filters['q']) ?>" placeholder="Code, nom, plaque…">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-2">
                                <label for="f_cat">Catégorie</label>
                                <select name="categorie_id" id="f_cat" class="form-control">
                                    <option value="">Toutes les catégories</option>
                                    <?php foreach ($categories as $c): ?>
                                    <option value="<?= (int) $c->id ?>"
                                        <?= (int) $filters['categorie_id'] === (int) $c->id ? 'selected' : '' ?>>
                                        <?= eq_e($c->nom_categorie) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-2">
                                <label for="f_etat">État</label>
                                <select name="etat" id="f_etat" class="form-control">
                                    <option value="">Tous (hors réformés)</option>
                                    <?php foreach (TechModel::ETATS as $etat): ?>
                                    <option value="<?= eq_e($etat) ?>"
                                        <?= $filters['etat'] === $etat ? 'selected' : '' ?>>
                                        <?= $etat === 'Réformé' ? 'Réformés (hors parc)' : eq_e($etat) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-2">
                                <label for="f_ch">Chantier</label>
                                <select name="chantier_id" id="f_ch" class="form-control">
                                    <option value="">Tous les chantiers</option>
                                    <?php foreach ($chantiers as $ch): ?>
                                    <option value="<?= (int) $ch->id ?>"
                                        <?= (int) $filters['chantier_id'] === (int) $ch->id ? 'selected' : '' ?>>
                                        <?= eq_e($ch->name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-end mt-2" style="gap:8px">
                            <a href="<?= base_url('engin-materiel') ?>" class="btn btn-secondary"><i
                                    class="fas fa-redo mr-1"></i>Réinitialiser</a>
                            <a href="<?= base_url('engin-materiel-export' . ($query ? '?' . http_build_query($query) : '')) ?>"
                                class="btn eq-btn-light">
                                <i class="fas fa-file-excel mr-1 text-success"></i>Exporter (Excel)
                            </a>
                            <button type="submit" class="btn eq-btn"><i
                                    class="fas fa-search mr-1"></i>Rechercher</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <!-- Parc -->
                <div class="col-xl-8 mb-4">
                    <div class="eq-card">
                        <div class="eq-card-head">
                            <div>
                                <h5 class="eq-title"><i class="fas fa-truck-loading text-success"></i>Parc engins &
                                    matériels</h5>
                                <span class="eq-sub"><?= count($engins) ?> équipement(s) affiché(s)</span>
                            </div>
                            <div class="d-flex align-items-center" style="gap:6px">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm eq-btn-light" data-view="grid"
                                        title="Vue grille"><i class="fas fa-th-large"></i></button>
                                    <button type="button" class="btn btn-sm eq-btn-light" data-view="table"
                                        title="Vue tableau"><i class="fas fa-list"></i></button>
                                </div>
                                <button type="button" class="btn btn-sm eq-btn" data-action="new-engin"><i
                                        class="fas fa-plus mr-1"></i>Nouveau</button>
                            </div>
                        </div>

                        <?php if (empty($engins)): ?>
                        <div class="eq-empty">
                            <i class="fas fa-truck"></i>
                            <h6><?= $hasFilters ? 'Aucun engin ne correspond aux filtres' : 'Aucun engin enregistré' ?>
                            </h6>
                            <p class="mb-0">
                                <?= $hasFilters ? 'Modifiez ou réinitialisez les filtres.' : 'Commencez par ajouter votre premier équipement.' ?>
                            </p>
                        </div>
                        <?php else: ?>

                        <!-- Vue grille -->
                        <div class="eq-card-body" id="enginGrid">
                            <div class="eq-grid">
                                <?php foreach ($engins as $e): ?>
                                <div class="eq-item">
                                    <div class="eq-item-top">
                                        <img class="eq-item-photo" src="<?= $photoUrl($e) ?>" alt="" loading="lazy">
                                        <div class="flex-fill" style="min-width:0">
                                            <div class="d-flex justify-content-between align-items-start"
                                                style="gap:6px">
                                                <div class="eq-item-title"><?= eq_e($e->designation) ?></div>
                                                <span
                                                    class="eq-badge <?= eq_badge($e->etat) ?>"><?= eq_e($e->etat) ?></span>
                                            </div>
                                            <div class="eq-item-code"><?= eq_e($e->code_engin) ?> ·
                                                <?= eq_e($e->nom_categorie ?: '-') ?></div>
                                            <?php if ($e->marque || $e->modele): ?>
                                            <div class="eq-item-code"><?= eq_e(trim($e->marque . ' ' . $e->modele)) ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="eq-item-meta">
                                        <span title="Plaque"><i
                                                class="fas fa-id-card"></i><?= eq_e($e->plaque ?: 'Sans plaque') ?></span>
                                        <span title="Chantier / localisation"><i
                                                class="fas fa-map-marker-alt"></i><?= eq_e($lieu($e)) ?></span>
                                        <span title="Compteur"><i
                                                class="fas fa-tachometer-alt"></i><?= $e->type_compteur === 'aucun' ? 'Sans compteur' : eq_num($e->compteur_actuel) . ' ' . eq_unit($e->type_compteur) ?></span>
                                        <span title="Carburant"><i
                                                class="fas fa-gas-pump"></i><?= eq_e($e->type_carburant) ?></span>
                                        <?php if ($e->responsable): ?>
                                        <span title="Responsable" style="grid-column:1/-1"><i
                                                class="fas fa-user"></i><?= eq_e($e->responsable) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ((int) $e->docs_alerte > 0): ?>
                                    <div class="eq-item-warn"><i
                                            class="fas fa-exclamation-circle mr-1"></i><?= (int) $e->docs_alerte ?>
                                        document(s) expiré(s) ou à renouveler</div>
                                    <?php endif; ?>
                                    <div class="eq-item-actions"><?= $actions($e) ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Vue tableau -->
                        <div class="table-responsive d-none" id="enginTable">
                            <table class="table table-hover eq-table">
                                <thead>
                                    <tr>
                                        <th>Engin</th>
                                        <th>Catégorie</th>
                                        <th>Plaque</th>
                                        <th>Chantier / lieu</th>
                                        <th class="text-right">Compteur</th>
                                        <th>État</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($engins as $e): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="eq-thumb-sm" src="<?= $photoUrl($e) ?>" alt=""
                                                    loading="lazy">
                                                <div>
                                                    <strong><?= eq_e($e->designation) ?></strong><br>
                                                    <span class="eq-ref"><?= eq_e($e->code_engin) ?></span>
                                                    <?php if ((int) $e->docs_alerte > 0): ?>
                                                    <i class="fas fa-exclamation-circle text-warning ml-1"
                                                        title="Document(s) à renouveler"></i>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= eq_e($e->nom_categorie ?: '-') ?></td>
                                        <td><?= eq_e($e->plaque ?: '-') ?></td>
                                        <td><?= eq_e($lieu($e)) ?></td>
                                        <td class="text-right">
                                            <?= $e->type_compteur === 'aucun' ? '-' : eq_num($e->compteur_actuel) . ' ' . eq_unit($e->type_compteur) ?>
                                        </td>
                                        <td><span
                                                class="eq-badge <?= eq_badge($e->etat) ?>"><?= eq_e($e->etat) ?></span>
                                        </td>
                                        <td class="text-right text-nowrap"><?= $actions($e) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="col-xl-4 mb-4">
                    <div class="eq-card mb-4">
                        <div class="eq-card-head">
                            <h5 class="eq-title"><i class="fas fa-chart-pie text-success"></i>Répartition par état</h5>
                        </div>
                        <div class="eq-card-body">
                            <?php foreach ($repartition as $r): ?>
                            <div class="eq-bar">
                                <div class="eq-bar-label">
                                    <span><?= eq_e($r[0]) ?></span>
                                    <strong><?= $r[1] ?> <small class="text-muted">(<?= $pct($r[1]) ?>
                                            %)</small></strong>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar <?= $r[2] ?>" style="width: <?= $pct($r[1]) ?>%"></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($reformes > 0): ?>
                        <div class="eq-card-foot small text-muted">
                            <i class="fas fa-archive mr-1"></i><?= $reformes ?> engin(s) réformé(s), exclus du calcul.
                            <a href="<?= base_url('engin-materiel?etat=' . rawurlencode('Réformé')) ?>">Voir</a>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="eq-card">
                        <div class="eq-card-head">
                            <div>
                                <h5 class="eq-title"><i class="fas fa-bell text-warning"></i>Alertes</h5>
                                <span class="eq-sub">Échéances à 30 jours, documents, pannes, consommation.</span>
                            </div>
                        </div>
                        <div class="eq-card-body">
                            <?php if (empty($alerts)): ?>
                            <div class="eq-empty py-3">
                                <i class="fas fa-check-circle text-success"></i>
                                <h6>Aucune alerte</h6>
                                <p class="mb-0 small">Tout le parc est à jour.</p>
                            </div>
                            <?php else: ?>
                            <?php foreach ($alerts as $a): ?>
                            <div class="eq-alert eq-alert-<?= $a->level ?>">
                                <div class="eq-alert-icon"><i class="<?= $a->icon ?>"></i></div>
                                <div class="flex-fill" style="min-width:0">
                                    <strong><?= eq_e($a->title) ?></strong>
                                    <p><b><?= eq_e($a->designation) ?></b> <small><?= eq_e($a->code_engin) ?></small>
                                    </p>
                                    <p><?= eq_e($a->text) ?></p>
                                    <?php if ($a->date): ?>
                                    <p><i class="far fa-calendar-alt mr-1"></i><?= eq_date($a->date) ?>
                                        <?php if ($a->days !== null && $a->kind !== 'panne'): ?>
                                        ·
                                        <?= $a->days < 0 ? '<span class="text-danger font-weight-bold">retard de ' . abs($a->days) . ' j</span>' : ($a->days === 0 ? "<span class=\"text-danger font-weight-bold\">aujourd'hui</span>" : 'dans ' . $a->days . ' j') ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <?php if ($a->engin_id): ?>
                                <button type="button" class="btn btn-sm btn-link p-0 align-self-center"
                                    data-action="dossier" data-id="<?= (int) $a->engin_id ?>" title="Ouvrir la fiche">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                            <a href="<?= base_url('maintenance-carburant') ?>"
                                class="d-block text-center small mt-2">Toutes les alertes <i
                                    class="fas fa-arrow-right ml-1"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- =====================================================================
     MODALE : AJOUT / MODIFICATION D'UN ENGIN
     ===================================================================== -->
<div class="modal fade" id="enginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form id="enginForm" class="modal-content eq-modal" method="post" enctype="multipart/form-data"
            action="<?= base_url('engin-materiel-store') ?>" data-store="<?= base_url('engin-materiel-store') ?>"
            data-update="<?= base_url('engin-materiel-update') ?>">
            <input type="hidden" name="<?= eq_e($csrfName) ?>" value="<?= eq_e($csrfHash) ?>">
            <input type="hidden" name="id" id="e_id">

            <div class="modal-header eq-modal-head">
                <h5 class="modal-title"><i class="fas fa-truck-monster mr-2"></i><span id="enginModalTitle">Nouvel engin
                        / matériel</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">&times;</button>
            </div>

            <div class="modal-body">
                <div class="eq-section"><i class="fas fa-id-card"></i>Identification</div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>Code engin</label>
                        <input type="text" id="e_code" class="form-control eq-readonly"
                            value="<?= eq_e($codePreview) ?>" readonly>
                        <small class="eq-hint js-create-only">Attribué définitivement à l'enregistrement.</small>
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="e_designation">Désignation *</label>
                        <input type="text" name="designation" id="e_designation" class="form-control" maxlength="255"
                            placeholder="Ex : Camion benne Fuso" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="e_categorie">Catégorie *</label>
                        <select name="categorie_id" id="e_categorie" class="form-control" required>
                            <option value="">Sélectionner…</option>
                            <?php foreach ($categories as $c): ?>
                            <option value="<?= (int) $c->id ?>" data-compteur="<?= eq_e($c->type_compteur_defaut) ?>">
                                <?= eq_e($c->nom_categorie) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group"><label>Marque</label><input type="text" name="marque"
                            class="form-control" maxlength="100" placeholder="Ex : Toyota"></div>
                    <div class="col-md-3 form-group"><label>Modèle</label><input type="text" name="modele"
                            class="form-control" maxlength="100" placeholder="Ex : Hilux"></div>
                    <div class="col-md-3 form-group"><label>Plaque</label><input type="text" name="plaque"
                            class="form-control text-uppercase" maxlength="50" placeholder="Ex : C1566A"></div>
                    <div class="col-md-3 form-group"><label>Année de fabrication</label><input type="number"
                            name="annee_fabrication" class="form-control" min="1950" max="<?= date('Y') + 1 ?>"></div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group"><label>N° de série</label><input type="text" name="numero_serie"
                            class="form-control" maxlength="100"></div>
                    <div class="col-md-4 form-group"><label>N° de châssis</label><input type="text"
                            name="numero_chassis" class="form-control" maxlength="100"></div>
                    <div class="col-md-4 form-group"><label>N° de moteur</label><input type="text" name="numero_moteur"
                            class="form-control" maxlength="100"></div>
                </div>

                <div class="eq-section"><i class="fas fa-cogs"></i>Exploitation</div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>Carburant</label>
                        <select name="type_carburant" class="form-control">
                            <?php foreach (TechModel::CARBURANTS as $c): ?>
                            <option value="<?= eq_e($c) ?>"><?= eq_e($c) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Capacité du réservoir (L)</label>
                        <input type="number" name="capacite_reservoir" class="form-control" min="0" step="0.01">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="e_type_compteur">Type de compteur</label>
                        <select name="type_compteur" id="e_type_compteur" class="form-control">
                            <option value="km">Kilométrique (km)</option>
                            <option value="heure">Horaire (h)</option>
                            <option value="aucun">Aucun compteur</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group js-create-only">
                        <label>Compteur initial (<span class="js-unit">km</span>)</label>
                        <input type="number" name="compteur_initial" class="form-control" min="0" step="0.01" value="0">
                    </div>
                    <div class="col-md-3 form-group js-edit-only">
                        <label>Compteur actuel</label>
                        <input type="text" id="e_compteur_actuel" class="form-control eq-readonly" readonly>
                        <small class="eq-hint">Mis à jour par les ravitaillements et maintenances.</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Consommation de référence (<span id="e_conso_unit">L/100 km</span>)</label>
                        <input type="number" name="consommation_reference" class="form-control" min="0" step="0.01"
                            placeholder="Norme constructeur">
                        <small class="eq-hint">Sert à détecter les consommations anormales.</small>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Chauffeur / opérateur attitré</label>
                        <input type="text" name="responsable" class="form-control" maxlength="150">
                    </div>
                    <div class="col-md-4 form-group js-edit-only">
                        <label>Affectation actuelle</label>
                        <input type="text" id="e_affect_actuelle" class="form-control eq-readonly" readonly>
                        <small class="eq-hint">Se modifie via « Affecter / transférer ».</small>
                    </div>
                </div>

                <div class="eq-section"><i class="fas fa-coins"></i>Acquisition & amortissement</div>
                <div class="row">
                    <div class="col-md-3 form-group"><label>Date d'acquisition</label><input type="date"
                            name="date_acquisition" class="form-control"></div>
                    <div class="col-md-3 form-group"><label>Mise en service</label><input type="date"
                            name="date_mise_service" class="form-control"></div>
                    <div class="col-md-2 form-group"><label>Valeur d'achat (BIF)</label><input type="number"
                            name="valeur_achat" class="form-control" min="0" step="1"></div>
                    <div class="col-md-2 form-group"><label>Amortissement (mois)</label><input type="number"
                            name="duree_amortissement_mois" class="form-control" min="1" step="1" placeholder="Ex : 60">
                    </div>
                    <div class="col-md-2 form-group"><label>Valeur résiduelle</label><input type="number"
                            name="valeur_residuelle" class="form-control" min="0" step="1"></div>
                </div>

                <div class="js-create-only">
                    <div class="eq-section"><i class="fas fa-map-marker-alt"></i>Affectation initiale</div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Chantier</label>
                            <select name="chantier_id" class="form-control">
                                <option value="">Aucun — reste au dépôt</option>
                                <?php foreach ($chantiers as $ch): ?>
                                <option value="<?= (int) $ch->id ?>"><?= eq_e($ch->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Localisation (si pas de chantier)</label>
                            <input type="text" name="localisation" class="form-control" maxlength="150"
                                value="Dépôt central">
                        </div>
                    </div>
                </div>

                <div class="eq-section"><i class="fas fa-camera"></i>Photos</div>
                <div id="e_photos_existing" class="eq-files mb-2 js-edit-only"></div>
                <input type="file" name="photos[]" id="e_photos" class="form-control" accept=".jpg,.jpeg,.png" multiple>
                <small class="eq-hint">JPG ou PNG, 5 Mo max par image. La première photo devient la photo
                    principale.</small>
                <div id="e_photos_preview" class="eq-files mt-2"></div>

                <div class="eq-section"><i class="fas fa-folder-open"></i>Documents administratifs</div>
                <div id="e_docs_existing" class="d-flex flex-column mb-2 js-edit-only" style="gap:6px"></div>
                <div id="docRows"></div>
                <button type="button" class="btn btn-sm eq-btn-light" id="addDocRow"><i
                        class="fas fa-plus mr-1"></i>Ajouter un document</button>
                <small class="eq-hint">Carte grise, assurance, contrôle technique… Renseignez la date d'expiration pour
                    recevoir une alerte.</small>

                <div class="eq-section"><i class="fas fa-sticky-note"></i>Observation</div>
                <textarea name="observation" class="form-control" rows="3"
                    placeholder="État général, remarques…"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="fas fa-times mr-1"></i>Annuler</button>
                <button type="submit" class="btn eq-btn" id="enginSubmit"><i
                        class="fas fa-save mr-1"></i>Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<template id="docRowTpl">
    <div class="eq-repeat-row">
        <div class="row no-gutters" style="gap:6px 0">
            <div class="col-md-3 pr-md-1">
                <select name="doc_type[]" class="form-control form-control-sm">
                    <?php foreach (TechModel::DOC_TYPES as $t): ?>
                    <option value="<?= eq_e($t) ?>"><?= eq_e($t) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 px-md-1"><input type="text" name="doc_numero[]" class="form-control form-control-sm"
                    placeholder="N° document" maxlength="100"></div>
            <div class="col-md-2 px-md-1"><input type="date" name="doc_expiration[]"
                    class="form-control form-control-sm" title="Date d'expiration"></div>
            <div class="col-md-4 px-md-1"><input type="file" name="doc_file[]" class="form-control form-control-sm"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"></div>
            <div class="col-md-1 pl-md-1 text-right">
                <button type="button" class="btn btn-sm btn-outline-danger" data-action="remove-row" title="Retirer"><i
                        class="fas fa-times"></i></button>
            </div>
        </div>
    </div>
</template>

<!-- =====================================================================
     MODALE : AFFECTATION
     ===================================================================== -->
<div class="modal fade" id="affectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content eq-modal" method="post" action="<?= base_url('engin-affecter') ?>">
            <input type="hidden" name="<?= eq_e($csrfName) ?>" value="<?= eq_e($csrfHash) ?>">
            <input type="hidden" name="redirect" value="engin-materiel">
            <div class="modal-header eq-modal-head is-dark">
                <h5 class="modal-title"><i class="fas fa-exchange-alt mr-2"></i>Affecter / transférer un engin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="a_engin">Engin / matériel *</label>
                    <select name="engin_id" id="a_engin" class="form-control" required>
                        <option value="">Sélectionner…</option>
                        <?php foreach ($allEngins as $e): ?>
                        <option value="<?= (int) $e->id ?>" data-lieu="<?= eq_e($lieu($e)) ?>"
                            data-compteur="<?= eq_e($e->compteur_actuel) ?>"
                            data-unit="<?= eq_unit($e->type_compteur) ?>"
                            data-responsable="<?= eq_e($e->responsable) ?>">
                            <?= eq_e($e->code_engin . ' — ' . $e->designation . ($e->plaque ? ' (' . $e->plaque . ')' : '')) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="eq-hint" id="a_actuel"></small>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="a_chantier">Chantier de destination</label>
                        <select name="chantier_id" id="a_chantier" class="form-control">
                            <option value="">— Aucun chantier (retour au dépôt) —</option>
                            <?php foreach ($chantiers as $ch): ?>
                            <option value="<?= (int) $ch->id ?>"><?= eq_e($ch->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="a_localisation">Ou localisation</label>
                        <input type="text" name="localisation" id="a_localisation" class="form-control" maxlength="150"
                            value="Dépôt central">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Date de début *</label>
                        <input type="date" name="date_debut" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Responsable / chauffeur</label>
                        <input type="text" name="responsable" id="a_responsable" class="form-control" maxlength="150">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Compteur au départ (<span id="a_unit">km</span>)</label>
                        <input type="number" name="compteur_depart" id="a_compteur" class="form-control" min="0"
                            step="0.01">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label>Observation</label>
                    <textarea name="observation" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn eq-btn"><i class="fas fa-check mr-1"></i>Valider l'affectation</button>
            </div>
        </form>
    </div>
</div>

<!-- =====================================================================
     MODALE : RÉFORME
     ===================================================================== -->
<div class="modal fade" id="reformModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content eq-modal" method="post" action="<?= base_url('engin-reformer') ?>">
            <input type="hidden" name="<?= eq_e($csrfName) ?>" value="<?= eq_e($csrfHash) ?>">
            <input type="hidden" name="engin_id" id="r_engin">
            <div class="modal-header eq-modal-head is-red">
                <h5 class="modal-title"><i class="fas fa-archive mr-2"></i>Réformer un engin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning small">
                    <strong id="r_name"></strong> sortira du parc actif. Son historique (carburant, maintenances, coûts)
                    reste consultable.
                </div>
                <div class="form-group">
                    <label>Date de réforme *</label>
                    <input type="date" name="date_reforme" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group mb-0">
                    <label>Motif *</label>
                    <input type="text" name="motif_reforme" class="form-control" maxlength="255"
                        placeholder="Vente, casse, vol, fin de vie…" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-archive mr-1"></i>Réformer</button>
            </div>
        </form>
    </div>
</div>

<!-- =====================================================================
     MODALE : FICHE / RAPPORT DÉTAILLÉ
     ===================================================================== -->
<div class="modal fade" id="dossierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content eq-modal">
            <div class="modal-header eq-modal-head is-dark flex-wrap" style="gap:8px">
                <h5 class="modal-title mr-auto"><i class="fas fa-file-alt mr-2"></i>Fiche & rapport de l'engin</h5>
                <div class="d-flex align-items-center flex-wrap" style="gap:6px">
                    <label class="mb-0 small" for="d_du">Du</label>
                    <input type="date" id="d_du" class="form-control form-control-sm" style="width:150px"
                        value="<?= date('Y-01-01') ?>">
                    <label class="mb-0 small" for="d_au">au</label>
                    <input type="date" id="d_au" class="form-control form-control-sm" style="width:150px"
                        value="<?= date('Y-m-d') ?>">
                    <button type="button" class="btn btn-sm btn-light" id="d_refresh" title="Actualiser"><i
                            class="fas fa-sync-alt"></i></button>
                    <button type="button" class="btn btn-sm btn-light" id="d_print" title="Imprimer / PDF"><i
                            class="fas fa-print mr-1"></i>Imprimer</button>
                </div>
                <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Fermer">&times;</button>
            </div>
            <div class="modal-body" id="dossierContent"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* Attend que jQuery + Bootstrap soient chargés (ils peuvent l'être dans footer.php, après cette vue) */
window.eqOnReady = function(fn) {
    var tries = 0;

    function run() {
        if (window.jQuery && window.jQuery.fn && window.jQuery.fn.modal) {
            fn(window.jQuery);
        } else if (tries++ < 200) {
            setTimeout(run, 50);
        } else {
            console.error('[Engins] jQuery/Bootstrap introuvable : vérifiez header.php / footer.php.');
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
};
window.EQ = {
    baseUrl: <?= eq_json(base_url()) ?>,
    csrfName: <?= eq_json($csrfName) ?>,
    csrfHash: <?= eq_json($csrfHash) ?>
};
</script>
<script src="<?= base_url('assets/v1/dist/js/module-engins.js?v=2') ?>"></script>
<script>
eqOnReady(function($) {
    'use strict';

    var CODE_PREVIEW = <?= eq_json($codePreview) ?>;
    var $modal = $('#enginModal');
    var $form = $('#enginForm');

    /* ---------- Vue grille / tableau ---------- */
    function setView(view) {
        $('#enginGrid').toggleClass('d-none', view !== 'grid');
        $('#enginTable').toggleClass('d-none', view !== 'table');
        $('[data-view]').removeClass('active').filter('[data-view="' + view + '"]').addClass('active');
        try {
            localStorage.setItem('eq-parc-view', view);
        } catch (e) {
            /* stockage indisponible */
        }
    }
    var savedView = 'grid';
    try {
        savedView = localStorage.getItem('eq-parc-view') || 'grid';
    } catch (e) {
        /* ignore */
    }
    setView(savedView);
    $('[data-view]').on('click', function() {
        setView($(this).data('view'));
    });

    /* ---------- Unités selon le type de compteur ---------- */
    function syncUnits() {
        var t = $('#e_type_compteur').val();
        $('.js-unit').text(t === 'heure' ? 'h' : (t === 'km' ? 'km' : '-'));
        $('#e_conso_unit').text(t === 'heure' ? 'L/h' : 'L/100 km');
    }
    $('#e_categorie').on('change', function() {
        var c = $(this).find(':selected').data('compteur');
        if (c && $form.data('mode') === 'create') {
            $('#e_type_compteur').val(c);
            syncUnits();
        }
    });
    $('#e_type_compteur').on('change', syncUnits);

    /* ---------- Documents : lignes dynamiques ---------- */
    function addDocRow() {
        $('#docRows').append(document.getElementById('docRowTpl').content.cloneNode(true));
    }
    $('#addDocRow').on('click', addDocRow);
    $('#docRows').on('click', '[data-action="remove-row"]', function() {
        $(this).closest('.eq-repeat-row').remove();
    });

    $('#e_photos').on('change', function() {
        EQ.previewFiles(this, document.getElementById('e_photos_preview'));
    });

    /* ---------- Formulaire : création / modification ---------- */
    function resetForm(mode) {
        $form[0].reset();
        $form.data('mode', mode);
        $form.attr('action', $form.data(mode === 'create' ? 'store' : 'update'));
        $('#e_id').val('');
        $('#docRows, #e_photos_preview, #e_photos_existing, #e_docs_existing').empty();
        addDocRow();
        $('.js-create-only').toggleClass('d-none', mode !== 'create');
        $('.js-edit-only').toggleClass('d-none', mode === 'create');
        $('#enginModalTitle').text(mode === 'create' ? 'Nouvel engin / matériel' : 'Modifier l\'engin');
        $('#e_code').val(CODE_PREVIEW);
        $('#enginSubmit').prop('disabled', false).html('<i class="fas fa-save mr-1"></i>Enregistrer');
        syncUnits();
    }

    function renderPhotos(photos) {
        var $box = $('#e_photos_existing').empty();
        if (!photos || !photos.length) {
            $box.html('<small class="text-muted">Aucune photo.</small>');
            return;
        }
        photos.forEach(function(p) {
            var main = parseInt(p.is_principale, 10) === 1;
            $box.append(
                '<div class="eq-thumb' + (main ? ' is-main' : '') + '">' +
                '<div class="eq-thumb-tools">' +
                (main ? '' :
                    '<button type="button" class="btn btn-light" data-action="photo-main" data-id="' +
                    p.id + '" title="Définir comme principale"><i class="fas fa-star"></i></button>'
                ) +
                '<button type="button" class="btn btn-danger" data-action="photo-delete" data-id="' +
                p.id + '" title="Supprimer"><i class="fas fa-times"></i></button>' +
                '</div>' +
                '<img src="' + EQ.esc(p.url) + '" alt="">' +
                '<span title="' + EQ.esc(p.original_name || p.photo) + '">' + (main ?
                    '<i class="fas fa-star text-warning mr-1"></i>' : '') + EQ.esc(p
                    .original_name || p.photo) + '</span>' +
                '</div>'
            );
        });
    }

    function renderDocs(docs) {
        var $box = $('#e_docs_existing').empty();
        if (!docs || !docs.length) {
            $box.html('<small class="text-muted">Aucun document.</small>');
            return;
        }
        var today = new Date().toISOString().substr(0, 10);
        var soon = new Date(Date.now() + 30 * 86400000).toISOString().substr(0, 10);
        docs.forEach(function(d) {
            var badge = '';
            if (d.date_expiration) {
                var cls = d.date_expiration < today ? 'eq-badge-danger' : (d.date_expiration <= soon ?
                    'eq-badge-warning' : 'eq-badge-success');
                badge = '<span class="eq-badge ' + cls + '">Exp. ' + EQ.date(d.date_expiration) +
                    '</span>';
            }
            $box.append(
                '<div class="eq-doc">' +
                '<i class="' + EQ.fileIcon(d.document) + ' fa-lg"></i>' +
                '<a class="eq-doc-name" href="' + EQ.esc(d.url) +
                '" target="_blank" rel="noopener">' +
                '<b>' + EQ.esc(d.type_document) + '</b>' + (d.numero_document ? ' · ' + EQ.esc(d
                    .numero_document) : '') +
                ' <small class="text-muted">' + EQ.esc(d.original_name || d.document) +
                '</small></a>' +
                badge +
                '<button type="button" class="btn btn-sm btn-outline-danger eq-icon-btn" data-action="doc-delete" data-id="' +
                d.id + '" title="Supprimer"><i class="fas fa-trash-alt"></i></button>' +
                '</div>'
            );
        });
    }

    $(document).on('click', '[data-action="new-engin"]', function(e) {
        e.preventDefault();
        resetForm('create');
        $modal.modal('show');
    });

    $(document).on('click', '[data-action="edit"]', function() {
        var id = $(this).data('id');
        resetForm('edit');
        EQ.get('engin-materiel-get/' + id).done(function(r) {
            var e = r.engin;
            $('#e_id').val(e.id);
            $('#e_code').val(e.code_engin);
            ['designation', 'categorie_id', 'marque', 'modele', 'plaque', 'numero_serie',
                'numero_chassis',
                'numero_moteur', 'annee_fabrication', 'type_carburant', 'capacite_reservoir',
                'type_compteur',
                'consommation_reference', 'responsable', 'date_acquisition',
                'date_mise_service', 'valeur_achat',
                'duree_amortissement_mois', 'valeur_residuelle', 'observation'
            ].forEach(function(k) {
                $form.find('[name="' + k + '"]').val(e[k] === null || e[k] ===
                    undefined ? '' : e[k]);
            });
            $('#e_compteur_actuel').val(e.type_compteur === 'aucun' ? 'Sans compteur' : EQ.num(e
                .compteur_actuel) + ' ' + EQ.unit(e.type_compteur));
            $('#e_affect_actuelle').val(e.chantier_name || e.localisation || '-');
            $('#docRows').empty();
            renderPhotos(r.photos);
            renderDocs(r.documents);
            syncUnits();
            $modal.modal('show');
        }).fail(EQ.fail);
    });

    $form.on('submit', function() {
        $('#enginSubmit').prop('disabled', true).html(
            '<i class="fas fa-spinner fa-spin mr-1"></i>Enregistrement…');
    });

    /* ---------- Photos & documents existants ---------- */
    $('#e_photos_existing').on('click', '[data-action="photo-main"]', function() {
        EQ.post('engin-photo-principale', {
            id: $(this).data('id')
        }).done(function(r) {
            renderPhotos(r.photos);
            EQ.toast('success', 'Photo principale mise à jour');
        }).fail(EQ.fail);
    });

    $('#e_photos_existing').on('click', '[data-action="photo-delete"]', function() {
        var id = $(this).data('id');
        EQ.confirm({
                titleText: 'Supprimer cette photo ?',
                text: 'Le fichier sera supprimé définitivement.',
                confirmButtonText: 'Supprimer'
            })
            .then(function(res) {
                if (!res.isConfirmed) {
                    return;
                }
                EQ.post('engin-photo-delete', {
                    id: id
                }).done(function(r) {
                    renderPhotos(r.photos);
                    EQ.toast('success', 'Photo supprimée');
                }).fail(EQ.fail);
            });
    });

    $('#e_docs_existing').on('click', '[data-action="doc-delete"]', function() {
        var $row = $(this).closest('.eq-doc');
        var id = $(this).data('id');
        EQ.confirm({
                titleText: 'Supprimer ce document ?',
                text: 'Le fichier sera supprimé définitivement.',
                confirmButtonText: 'Supprimer'
            })
            .then(function(res) {
                if (!res.isConfirmed) {
                    return;
                }
                EQ.post('engin-document-delete', {
                    id: id
                }).done(function() {
                    $row.remove();
                    EQ.toast('success', 'Document supprimé');
                }).fail(EQ.fail);
            });
    });

    /* ---------- Suppression d'un engin ---------- */
    $(document).on('click', '[data-action="delete"]', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        EQ.confirm({
            titleText: 'Supprimer ' + $(this).data('name') + ' ?',
            text: 'Possible uniquement si l\'engin n\'a aucun historique.',
            confirmButtonText: 'Supprimer'
        }).then(function(res) {
            if (!res.isConfirmed) {
                return;
            }
            EQ.post('engin-materiel-delete', {
                id: id
            }).done(function(r) {
                Swal.fire({
                        icon: 'success',
                        title: r.message,
                        timer: 1400,
                        showConfirmButton: false
                    })
                    .then(function() {
                        location.reload();
                    });
            }).fail(EQ.fail);
        });
    });

    /* ---------- Affectation ---------- */
    function syncAffect() {
        var $o = $('#a_engin option:selected');
        if (!$o.val()) {
            $('#a_actuel').text('');
            return;
        }
        var unit = $o.data('unit');
        $('#a_actuel').html('<i class="fas fa-map-marker-alt mr-1"></i>Actuellement : ' + EQ.esc($o.data(
                'lieu')) +
            (unit ? ' · compteur ' + EQ.num($o.data('compteur')) + ' ' + unit : ''));
        $('#a_unit').text(unit || '-');
        $('#a_compteur').prop('disabled', !unit).attr('placeholder', unit ? EQ.num($o.data('compteur')) : '');
        if (!$('#a_responsable').val()) {
            $('#a_responsable').val($o.data('responsable') || '');
        }
    }
    $('#a_engin').on('change', syncAffect);
    $('#a_chantier').on('change', function() {
        $('#a_localisation').prop('disabled', !!$(this).val());
    });
    $(document).on('click', '[data-action="affect"]', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('#affectModal form')[0].reset();
        $('#a_localisation').prop('disabled', false);
        $('#a_engin').val(id || '');
        syncAffect();
        $('#affectModal').modal('show');
    });

    /* ---------- Réforme ---------- */
    $(document).on('click', '[data-action="reform"]', function(e) {
        e.preventDefault();
        $('#r_engin').val($(this).data('id'));
        $('#r_name').text($(this).data('name'));
        $('#reformModal').modal('show');
    });

    /* ---------- Fiche / rapport ---------- */
    var dossierId = null;

    function loadDossier() {
        $('#dossierContent').html(
            '<div class="eq-loading"><i class="fas fa-spinner fa-spin mr-2"></i>Chargement du dossier…</div>'
        );
        $.get(EQ.url('engin-materiel-dossier/' + dossierId), {
                du: $('#d_du').val(),
                au: $('#d_au').val()
            })
            .done(function(html) {
                $('#dossierContent').html(html);
            })
            .fail(function(x) {
                $('#dossierContent').html(x.responseText ||
                    '<div class="alert alert-danger mb-0">Impossible de charger le dossier.</div>');
            });
    }
    $(document).on('click', '[data-action="dossier"]', function() {
        dossierId = $(this).data('id');
        $('#dossierModal').modal('show');
        loadDossier();
    });
    $('#d_refresh').on('click', loadDossier);
    $('#d_du, #d_au').on('change', loadDossier);
    $('#d_print').on('click', function() {
        EQ.printElement('dossierContent', 'Fiche engin — SATRACO');
    });
});
</script>