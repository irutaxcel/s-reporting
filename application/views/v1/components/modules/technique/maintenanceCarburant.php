<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* ---------------------------------------------------------------------
 |  Préparation de l'affichage
 * --------------------------------------------------------------------- */
$query = array_filter([
    'q'           => $filters['q'],
    'engin_id'    => $filters['engin_id'] ?: null,
    'type'        => $filters['type'],
    'chantier_id' => $filters['chantier_id'] ?: null,
    'status'      => $filters['status'],
    'date_debut'  => $filters['date_debut'],
    'date_fin'    => $filters['date_fin'],
]);
$hasFilters = !empty($query);
$sources = [
    'fuel'        => ['Carburant', 'fas fa-gas-pump text-success'],
    'maintenance' => ['Maintenance', 'fas fa-tools text-warning'],
    'panne'       => ['Panne', 'fas fa-car-crash text-danger'],
];

// Options « engin » réutilisées par les 3 formulaires (avec les infos utiles à l'auto-remplissage)
ob_start();
foreach ($allEngins as $e): ?>
<option value="<?= (int) $e->id ?>" data-compteur="<?= eq_e($e->type_compteur) ?>"
    data-actuel="<?= eq_e($e->compteur_actuel) ?>" data-carburant="<?= eq_e($e->type_carburant) ?>"
    data-capacite="<?= eq_e($e->capacite_reservoir) ?>" data-chantier="<?= (int) $e->chantier_id ?>"
    data-responsable="<?= eq_e($e->responsable) ?>">
    <?= eq_e($e->code_engin . ' — ' . $e->designation . ($e->plaque ? ' (' . $e->plaque . ')' : '')) ?>
</option>
<?php endforeach;
$enginOptions = ob_get_clean();

ob_start(); ?>
<option value="">Aucun chantier</option>
<?php foreach ($chantiers as $ch): ?>
<option value="<?= (int) $ch->id ?>"><?= eq_e($ch->name) ?></option>
<?php endforeach;
$chantierOptions = ob_get_clean();

// Pannes ouvertes pour lier une maintenance corrective
$openPannesJs = array_map(function ($p) {
    return [
        'id'          => (int) $p->id,
        'engin_id'    => (int) $p->engin_id,
        'chantier_id' => (int) $p->chantier_id,
        'reference'   => $p->reference,
        'gravite'     => $p->gravite,
        'description' => $p->description,
        'compteur'    => $p->compteur,
    ];
}, $pannes);
if ($prefillPanne && !in_array((int) $prefillPanne->id, array_column($openPannesJs, 'id'), true)) {
    $prefillPanne = null; // panne déjà résolue ou annulée
}

$maxCost = !empty($expensive) ? (float) $expensive[0]->total_cost : 0;
$barColors = ['bg-danger', 'bg-warning', 'bg-primary', 'bg-success', 'bg-info'];
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
                        <li class="breadcrumb-item"><a href="<?= base_url('engin-materiel') ?>">Engin & Materiel</a>
                        </li>
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

            <!-- Statistiques du mois -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="eq-stat is-green">
                        <p class="eq-stat-value"><?= eq_num($stats->fuel_litres, 0) ?> L</p>
                        <p class="eq-stat-label">Carburant consommé ce mois</p>
                        <span class="eq-stat-sub"><?= eq_money($stats->fuel_montant) ?> · <?= $stats->fuel_nb ?>
                            plein(s)</span>
                        <i class="fas fa-gas-pump eq-stat-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="eq-stat is-orange">
                        <p class="eq-stat-value"><?= $stats->programmees ?></p>
                        <p class="eq-stat-label">Maintenances programmées</p>
                        <span
                            class="eq-stat-sub"><?= $stats->en_retard ? 'dont ' . $stats->en_retard . ' en retard' : 'Aucune en retard' ?></span>
                        <i class="fas fa-calendar-check eq-stat-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="eq-stat is-blue">
                        <p class="eq-stat-value"><?= $stats->en_atelier ?></p>
                        <p class="eq-stat-label">Engins en atelier</p>
                        <span class="eq-stat-sub">Pannes ouvertes : <?= $stats->pannes_ouvertes ?></span>
                        <i class="fas fa-wrench eq-stat-icon"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="eq-stat is-red">
                        <p class="eq-stat-value"><?= eq_num($stats->cout_exploitation) ?></p>
                        <p class="eq-stat-label">Coût d'exploitation du mois (BIF)</p>
                        <span class="eq-stat-sub">Maintenance : <?= eq_num($stats->maint_cout) ?></span>
                        <i class="fas fa-coins eq-stat-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="row mb-2">
                <div class="col-lg-3 col-6 mb-3">
                    <a href="#" class="eq-action" data-action="new-fuel">
                        <div class="eq-action-icon"><i class="fas fa-gas-pump"></i></div>
                        <h6>Nouveau ravitaillement</h6><small>Enregistrer une consommation</small>
                    </a>
                </div>
                <div class="col-lg-3 col-6 mb-3">
                    <a href="#" class="eq-action" data-action="new-maintenance">
                        <div class="eq-action-icon"><i class="fas fa-tools"></i></div>
                        <h6>Nouvelle maintenance</h6><small>Préventive ou corrective</small>
                    </a>
                </div>
                <div class="col-lg-3 col-6 mb-3">
                    <a href="#" class="eq-action" data-action="new-panne">
                        <div class="eq-action-icon" style="background:#fee2e2;color:#dc2626"><i
                                class="fas fa-car-crash"></i></div>
                        <h6>Signaler une panne</h6><small>Déclarer un engin indisponible</small>
                    </a>
                </div>
                <div class="col-lg-3 col-6 mb-3">
                    <a href="<?= base_url('maintenance-carburant-export' . ($query ? '?' . http_build_query($query) : '')) ?>"
                        class="eq-action">
                        <div class="eq-action-icon"><i class="fas fa-file-excel"></i></div>
                        <h6>Exporter l'historique</h6><small>Fichier Excel (filtres appliqués)</small>
                    </a>
                </div>
            </div>

            <!-- Filtres -->
            <div class="eq-card mb-4">
                <div class="eq-card-head">
                    <div>
                        <h5 class="eq-title"><i class="fas fa-filter text-success"></i>Filtres de recherche</h5>
                        <span class="eq-sub">S'appliquent aux ravitaillements, maintenances et à l'historique.</span>
                    </div>
                    <?php if ($hasFilters): ?><span class="eq-chip"><i class="fas fa-filter"></i>Filtres
                        actifs</span><?php endif; ?>
                </div>
                <div class="eq-card-body">
                    <form method="get" action="<?= base_url('maintenance-carburant') ?>" class="eq-filter">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-2">
                                <label for="f_q">Recherche</label>
                                <input type="search" name="q" id="f_q" class="form-control"
                                    value="<?= eq_e($filters['q']) ?>" placeholder="Référence, code, plaque…">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-2">
                                <label for="f_engin">Engin / matériel</label>
                                <select name="engin_id" id="f_engin" class="form-control">
                                    <option value="">Tous les engins</option>
                                    <?php foreach ($allEngins as $e): ?>
                                    <option value="<?= (int) $e->id ?>"
                                        <?= (int) $filters['engin_id'] === (int) $e->id ? 'selected' : '' ?>>
                                        <?= eq_e($e->code_engin . ' — ' . $e->designation) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-4 mb-2">
                                <label for="f_type">Type d'opération</label>
                                <select name="type" id="f_type" class="form-control">
                                    <option value="">Toutes</option>
                                    <?php foreach ($sources as $k => $s): ?>
                                    <option value="<?= $k ?>" <?= $filters['type'] === $k ? 'selected' : '' ?>>
                                        <?= $s[0] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-4 mb-2">
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
                            <div class="col-lg-2 col-md-4 mb-2">
                                <label for="f_status">Statut</label>
                                <select name="status" id="f_status" class="form-control">
                                    <option value="">Tous</option>
                                    <optgroup label="Carburant">
                                        <option value="Validé" <?= $filters['status'] === 'Validé' ? 'selected' : '' ?>>
                                            Validé</option>
                                    </optgroup>
                                    <optgroup label="Maintenance">
                                        <?php foreach (TechModel::MAINT_STATUS as $s): ?>
                                        <option value="<?= eq_e($s) ?>"
                                            <?= $filters['status'] === $s ? 'selected' : '' ?>><?= eq_e($s) ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <optgroup label="Panne">
                                        <?php foreach (TechModel::PANNE_STATUS as $s): ?>
                                        <option value="<?= eq_e($s) ?>"
                                            <?= $filters['status'] === $s ? 'selected' : '' ?>><?= eq_e($s) ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-end">
                            <div class="col-md-3 mb-2">
                                <label for="f_du">Date début</label>
                                <input type="date" name="date_debut" id="f_du" class="form-control"
                                    value="<?= eq_e($filters['date_debut']) ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="f_au">Date fin</label>
                                <input type="date" name="date_fin" id="f_au" class="form-control"
                                    value="<?= eq_e($filters['date_fin']) ?>">
                            </div>
                            <div class="col-md-6 mb-2 d-flex flex-wrap justify-content-end" style="gap:8px">
                                <a href="<?= base_url('maintenance-carburant') ?>" class="btn btn-secondary"><i
                                        class="fas fa-redo mr-1"></i>Réinitialiser</a>
                                <button type="submit" class="btn eq-btn"><i
                                        class="fas fa-search mr-1"></i>Rechercher</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Carburant & maintenances -->
            <div class="row">
                <div class="col-xl-7 mb-4" id="fuel-section">
                    <div class="eq-card h-100">
                        <div class="eq-card-head">
                            <div>
                                <h5 class="eq-title"><i class="fas fa-gas-pump text-success"></i>Derniers
                                    ravitaillements</h5>
                                <span class="eq-sub">Quantités, coûts et relevés de compteur.</span>
                            </div>
                            <button type="button" class="btn btn-sm eq-btn" data-action="new-fuel"><i
                                    class="fas fa-plus mr-1"></i>Nouveau</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover eq-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Engin</th>
                                        <th>Chantier</th>
                                        <th class="text-right">Litres</th>
                                        <th class="text-right">Montant</th>
                                        <th class="text-right">Compteur</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($fuels)): ?>
                                    <tr>
                                        <td colspan="7">
                                            <div class="eq-empty"><i class="fas fa-gas-pump"></i>Aucun
                                                ravitaillement<?= $hasFilters ? ' pour ces filtres' : ' enregistré' ?>.
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php foreach ($fuels as $f):
                                        $cpt = $f->type_compteur === 'heure' ? $f->hour_meter : $f->kilometrage; ?>
                                    <tr>
                                        <td><?= eq_date($f->operation_date) ?><br><span
                                                class="eq-ref"><?= eq_e($f->reference) ?></span></td>
                                        <td><strong><?= eq_e($f->designation) ?></strong><br><small
                                                class="text-muted"><?= eq_e($f->code_engin) ?></small></td>
                                        <td><?= eq_e($f->chantier_name ?: '-') ?></td>
                                        <td class="text-right"><?= eq_num($f->quantity_litre, 2) ?> L<br><small
                                                class="text-muted"><?= eq_num($f->unit_price) ?>/L</small></td>
                                        <td class="text-right font-weight-bold"><?= eq_num($f->total_amount) ?></td>
                                        <td class="text-right">
                                            <?= $cpt !== null ? eq_num($cpt) . ' ' . eq_unit($f->type_compteur) : '-' ?>
                                            <?php if (!(int) $f->plein_complet): ?><br><small class="text-muted">plein
                                                partiel</small><?php endif; ?>
                                        </td>
                                        <td class="text-right text-nowrap">
                                            <button type="button" class="btn btn-sm eq-btn-light eq-icon-btn"
                                                data-action="view-fuel" data-id="<?= (int) $f->id ?>" title="Voir"><i
                                                    class="fas fa-eye"></i></button>
                                            <button type="button" class="btn btn-sm eq-btn-light eq-icon-btn"
                                                data-action="edit-fuel" data-id="<?= (int) $f->id ?>"
                                                title="Modifier"><i class="fas fa-pen"></i></button>
                                            <button type="button"
                                                class="btn btn-sm eq-btn-light eq-icon-btn text-danger"
                                                data-action="cancel-fuel" data-id="<?= (int) $f->id ?>"
                                                data-ref="<?= eq_e($f->reference) ?>" title="Annuler"><i
                                                    class="fas fa-ban"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xl-5 mb-4" id="maintenance-section">
                    <div class="eq-card h-100">
                        <div class="eq-card-head">
                            <div>
                                <h5 class="eq-title"><i class="fas fa-tools text-warning"></i>Maintenances récentes</h5>
                                <span class="eq-sub">Interventions préventives et correctives.</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-warning" data-action="new-maintenance"><i
                                    class="fas fa-plus mr-1"></i>Nouvelle</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover eq-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Engin / intervention</th>
                                        <th class="text-right">Coût</th>
                                        <th>Statut</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($maintenances)): ?>
                                    <tr>
                                        <td colspan="5">
                                            <div class="eq-empty"><i class="fas fa-tools"></i>Aucune
                                                maintenance<?= $hasFilters ? ' pour ces filtres' : ' enregistrée' ?>.
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php foreach ($maintenances as $m): ?>
                                    <tr>
                                        <td><?= eq_date($m->planned_date) ?><br><span
                                                class="eq-ref"><?= eq_e($m->reference) ?></span></td>
                                        <td>
                                            <strong><?= eq_e($m->designation) ?></strong> <small
                                                class="text-muted"><?= eq_e($m->code_engin) ?></small><br>
                                            <small><?= eq_e($m->intervention) ?> · <span
                                                    class="text-muted"><?= eq_e($m->maintenance_type) ?></span></small>
                                            <?php if ((int) $m->documents_count > 0): ?><small
                                                class="text-muted ml-1"><i class="fas fa-paperclip"></i>
                                                <?= (int) $m->documents_count ?></small><?php endif; ?>
                                        </td>
                                        <td class="text-right font-weight-bold"><?= eq_num($m->total_cost) ?></td>
                                        <td><span
                                                class="eq-badge <?= eq_badge($m->maintenance_status) ?>"><?= eq_e($m->maintenance_status) ?></span>
                                        </td>
                                        <td class="text-right text-nowrap">
                                            <button type="button" class="btn btn-sm eq-btn-light eq-icon-btn"
                                                data-action="view-maintenance" data-id="<?= (int) $m->id ?>"
                                                title="Voir"><i class="fas fa-eye"></i></button>
                                            <div class="dropdown d-inline-block">
                                                <button type="button" class="btn btn-sm eq-btn-light eq-icon-btn"
                                                    data-toggle="dropdown" title="Actions"><i
                                                        class="fas fa-ellipsis-v"></i></button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-action="edit-maintenance"
                                                        data-id="<?= (int) $m->id ?>"><i
                                                            class="fas fa-pen fa-fw mr-2"></i>Modifier</a>
                                                    <?php if ($m->maintenance_status === 'Programmé'): ?>
                                                    <a class="dropdown-item" href="#" data-action="maint-status"
                                                        data-status="En cours" data-id="<?= (int) $m->id ?>"><i
                                                            class="fas fa-play fa-fw mr-2 text-warning"></i>Démarrer</a>
                                                    <?php endif; ?>
                                                    <?php if (in_array($m->maintenance_status, ['Programmé', 'En cours'], true)): ?>
                                                    <a class="dropdown-item" href="#" data-action="maint-status"
                                                        data-status="Terminé" data-id="<?= (int) $m->id ?>"><i
                                                            class="fas fa-check fa-fw mr-2 text-success"></i>Terminer</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        data-action="maint-status" data-status="Annulé"
                                                        data-id="<?= (int) $m->id ?>"><i
                                                            class="fas fa-ban fa-fw mr-2"></i>Annuler</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pannes & alertes -->
            <div class="row">
                <div class="col-xl-7 mb-4">
                    <div class="eq-card h-100">
                        <div class="eq-card-head">
                            <div>
                                <h5 class="eq-title"><i class="fas fa-car-crash text-danger"></i>Pannes en cours</h5>
                                <span class="eq-sub">Signalées, en diagnostic ou en réparation.</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-action="new-panne"><i
                                    class="fas fa-plus mr-1"></i>Signaler</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover eq-table">
                                <thead>
                                    <tr>
                                        <th>Signalée le</th>
                                        <th>Engin</th>
                                        <th>Description</th>
                                        <th>Gravité</th>
                                        <th>Statut</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($pannes)): ?>
                                    <tr>
                                        <td colspan="6">
                                            <div class="eq-empty"><i class="fas fa-check-circle text-success"></i>Aucune
                                                panne en cours.</div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php foreach ($pannes as $p): ?>
                                    <tr>
                                        <td><?= eq_date($p->date_signalement, true) ?><br><span
                                                class="eq-ref"><?= eq_e($p->reference) ?></span></td>
                                        <td><strong><?= eq_e($p->designation) ?></strong><br><small
                                                class="text-muted"><?= eq_e($p->code_engin) ?><?= $p->immobilise ? ' · immobilisé' : '' ?></small>
                                        </td>
                                        <td><small><?= eq_e(mb_strimwidth((string) $p->description, 0, 90, '…')) ?></small><?= $p->signale_par ? '<br><small class="text-muted">par ' . eq_e($p->signale_par) . '</small>' : '' ?>
                                        </td>
                                        <td><span
                                                class="eq-badge <?= eq_badge($p->gravite) ?>"><?= eq_e($p->gravite) ?></span>
                                        </td>
                                        <td><span
                                                class="eq-badge <?= eq_badge($p->panne_status) ?>"><?= eq_e($p->panne_status) ?></span>
                                        </td>
                                        <td class="text-right text-nowrap">
                                            <?php if (!$p->maintenance_id): ?>
                                            <button type="button" class="btn btn-sm btn-warning"
                                                data-action="panne-maintenance" data-id="<?= (int) $p->id ?>"
                                                title="Ouvrir une maintenance corrective"><i
                                                    class="fas fa-tools mr-1"></i>Réparer</button>
                                            <?php else: ?>
                                            <button type="button" class="btn btn-sm eq-btn-light"
                                                data-action="view-maintenance" data-id="<?= (int) $p->maintenance_id ?>"
                                                title="Voir la maintenance"><i class="fas fa-tools"></i></button>
                                            <?php endif; ?>
                                            <div class="dropdown d-inline-block">
                                                <button type="button" class="btn btn-sm eq-btn-light eq-icon-btn"
                                                    data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <?php if ($p->panne_status === 'Signalée'): ?>
                                                    <a class="dropdown-item" href="#" data-action="panne-status"
                                                        data-status="En diagnostic" data-id="<?= (int) $p->id ?>"><i
                                                            class="fas fa-stethoscope fa-fw mr-2"></i>En diagnostic</a>
                                                    <?php endif; ?>
                                                    <a class="dropdown-item" href="#" data-action="panne-status"
                                                        data-status="Résolue" data-id="<?= (int) $p->id ?>"><i
                                                            class="fas fa-check fa-fw mr-2 text-success"></i>Marquer
                                                        résolue</a>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        data-action="panne-status" data-status="Annulée"
                                                        data-id="<?= (int) $p->id ?>"><i
                                                            class="fas fa-ban fa-fw mr-2"></i>Annuler (erreur)</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xl-5 mb-4">
                    <div class="eq-card h-100">
                        <div class="eq-card-head">
                            <div>
                                <h5 class="eq-title"><i class="fas fa-bell text-warning"></i>Alertes et échéances</h5>
                                <span class="eq-sub">Entretiens, documents, pannes et consommations anormales.</span>
                            </div>
                        </div>
                        <div class="eq-card-body">
                            <?php if (empty($alerts)): ?>
                            <div class="eq-empty py-3">
                                <i class="fas fa-check-circle text-success"></i>
                                <h6>Aucune alerte</h6>
                                <p class="mb-0 small">Rien à signaler dans les 30 prochains jours.</p>
                            </div>
                            <?php endif; ?>
                            <?php foreach ($alerts as $a): ?>
                            <div class="eq-alert eq-alert-<?= $a->level ?>">
                                <div class="eq-alert-icon"><i class="<?= $a->icon ?>"></i></div>
                                <div class="flex-fill" style="min-width:0">
                                    <strong><?= eq_e($a->title) ?></strong>
                                    <p><b><?= eq_e($a->designation) ?></b> <small><?= eq_e($a->code_engin) ?></small> —
                                        <?= eq_e($a->text) ?></p>
                                    <?php if ($a->date): ?>
                                    <p><i class="far fa-calendar-alt mr-1"></i><?= eq_date($a->date) ?>
                                        <?php if ($a->days !== null && $a->kind !== 'panne'): ?>
                                        ·
                                        <?= $a->days < 0 ? '<span class="text-danger font-weight-bold">retard de ' . abs($a->days) . ' j</span>' : ($a->days === 0 ? "<span class=\"text-danger font-weight-bold\">aujourd'hui</span>" : 'dans ' . $a->days . ' j') ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Évolution & engins coûteux -->
            <div class="row">
                <div class="col-xl-6 mb-4">
                    <div class="eq-card h-100">
                        <div class="eq-card-head">
                            <div>
                                <h5 class="eq-title"><i class="fas fa-chart-bar text-success"></i>Évolution des coûts
                                </h5>
                                <span class="eq-sub">Carburant et maintenance, 6 derniers mois (BIF).</span>
                            </div>
                        </div>
                        <div class="eq-card-body">
                            <div class="eq-chart-box"><canvas id="costChart"
                                    aria-label="Évolution des coûts mensuels"></canvas></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 mb-4">
                    <div class="eq-card h-100">
                        <div class="eq-card-head">
                            <div>
                                <h5 class="eq-title"><i class="fas fa-sort-amount-down text-danger"></i>Engins les plus
                                    coûteux ce mois</h5>
                                <span class="eq-sub">Avec la consommation réelle mesurée sur 90 jours.</span>
                            </div>
                        </div>
                        <div class="eq-card-body">
                            <?php if (empty($expensive)): ?>
                            <div class="eq-empty py-3"><i class="fas fa-chart-bar"></i>
                                <h6>Aucune dépense ce mois</h6>
                            </div>
                            <?php endif; ?>
                            <?php foreach ($expensive as $i => $x):
                                $width = $maxCost > 0 ? max(4, $x->total_cost / $maxCost * 100) : 0;
                                $c = isset($conso[(int) $x->id]) ? $conso[(int) $x->id] : null; ?>
                            <div class="eq-cost-line">
                                <div class="d-flex justify-content-between align-items-baseline mb-1" style="gap:8px">
                                    <span><strong><?= eq_e($x->designation) ?></strong> <small
                                            class="text-muted"><?= eq_e($x->code_engin) ?></small></span>
                                    <strong class="text-nowrap"><?= eq_money($x->total_cost) ?></strong>
                                </div>
                                <div class="progress" style="height:7px">
                                    <div class="progress-bar <?= $barColors[$i] ?? 'bg-secondary' ?>"
                                        style="width:<?= round($width, 1) ?>%"></div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between mt-1 small text-muted"
                                    style="gap:4px 12px">
                                    <span><i
                                            class="fas fa-gas-pump text-success mr-1"></i><?= eq_num($x->fuel_cost) ?></span>
                                    <span><i
                                            class="fas fa-tools text-warning mr-1"></i><?= eq_num($x->maintenance_cost) ?></span>
                                    <?php if ($c && $c->conso !== null): ?>
                                    <span>
                                        Conso. <?= eq_num($c->conso, 1) . ' ' . $c->unite ?>
                                        <?php if ($c->ecart !== null): ?>
                                        <span
                                            class="eq-badge <?= $c->ecart > 20 ? 'eq-badge-danger' : ($c->ecart > 0 ? 'eq-badge-warning' : 'eq-badge-success') ?>"><?= ($c->ecart > 0 ? '+' : '') . eq_num($c->ecart, 0) ?>
                                            %</span>
                                        <?php endif; ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique -->
            <div class="eq-card mb-4">
                <div class="eq-card-head">
                    <div>
                        <h5 class="eq-title"><i class="fas fa-history text-success"></i>Historique des opérations</h5>
                        <span class="eq-sub"><?= count($operations) ?> dernière(s)
                            opération(s)<?= $hasFilters ? ' correspondant aux filtres' : '' ?> — l'export contient tout
                            l'historique.</span>
                    </div>
                    <a href="<?= base_url('maintenance-carburant-export' . ($query ? '?' . http_build_query($query) : '')) ?>"
                        class="btn btn-sm eq-btn-light"><i class="fas fa-file-excel text-success mr-1"></i>Exporter</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover eq-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Référence</th>
                                <th>Engin</th>
                                <th>Opération</th>
                                <th>Chantier</th>
                                <th class="text-right">Montant</th>
                                <th>Responsable</th>
                                <th>Statut</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($operations)): ?>
                            <tr>
                                <td colspan="9">
                                    <div class="eq-empty"><i class="fas fa-history"></i>
                                        <h6>Aucune opération</h6>
                                        <p class="mb-0 small">Les ravitaillements, maintenances et pannes apparaîtront
                                            ici.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <?php foreach ($operations as $o): ?>
                            <tr>
                                <td><?= eq_date($o->operation_date) ?></td>
                                <td class="eq-ref"><?= eq_e($o->reference) ?></td>
                                <td><strong><?= eq_e($o->designation) ?></strong><br><small
                                        class="text-muted"><?= eq_e($o->code_engin) ?></small></td>
                                <td><i
                                        class="<?= $sources[$o->source][1] ?> mr-1"></i><strong><?= eq_e($o->operation_name) ?></strong><br><small
                                        class="text-muted"><?= eq_e($o->operation_type) ?></small></td>
                                <td><?= eq_e($o->chantier_name ?: '-') ?></td>
                                <td class="text-right font-weight-bold">
                                    <?= $o->source === 'panne' ? '-' : eq_num($o->amount) ?></td>
                                <td><?= eq_e($o->responsible ?: '-') ?></td>
                                <td>
                                    <span
                                        class="eq-badge <?= eq_badge($o->operation_status) ?>"><?= eq_e($o->operation_status) ?></span>
                                    <?php if ((int) $o->documents_count > 0): ?><small class="text-muted ml-1"><i
                                            class="fas fa-paperclip"></i>
                                        <?= (int) $o->documents_count ?></small><?php endif; ?>
                                </td>
                                <td class="text-right text-nowrap">
                                    <?php if ($o->source === 'fuel'): ?>
                                    <button type="button" class="btn btn-sm eq-btn-light eq-icon-btn"
                                        data-action="view-fuel" data-id="<?= (int) $o->operation_id ?>" title="Voir"><i
                                            class="fas fa-eye"></i></button>
                                    <button type="button" class="btn btn-sm eq-btn-light eq-icon-btn"
                                        data-action="edit-fuel" data-id="<?= (int) $o->operation_id ?>"
                                        title="Modifier"><i class="fas fa-pen"></i></button>
                                    <?php elseif ($o->source === 'maintenance'): ?>
                                    <button type="button" class="btn btn-sm eq-btn-light eq-icon-btn"
                                        data-action="view-maintenance" data-id="<?= (int) $o->operation_id ?>"
                                        title="Voir"><i class="fas fa-eye"></i></button>
                                    <button type="button" class="btn btn-sm eq-btn-light eq-icon-btn"
                                        data-action="edit-maintenance" data-id="<?= (int) $o->operation_id ?>"
                                        title="Modifier"><i class="fas fa-pen"></i></button>
                                    <?php else: ?>
                                    <span class="text-muted small">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- =====================================================================
     MODALE : RAVITAILLEMENT (ajout / modification)
     ===================================================================== -->
<div class="modal fade" id="fuelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form id="fuelForm" class="modal-content eq-modal" method="post"
            action="<?= base_url('add-new-ravitaillement') ?>" data-store="<?= base_url('add-new-ravitaillement') ?>"
            data-update="<?= base_url('engin-fuel-update') ?>">
            <input type="hidden" name="<?= eq_e($csrfName) ?>" value="<?= eq_e($csrfHash) ?>">
            <input type="hidden" name="id" id="fu_id">
            <div class="modal-header eq-modal-head">
                <h5 class="modal-title"><i class="fas fa-gas-pump mr-2"></i><span id="fuelModalTitle">Nouveau
                        ravitaillement</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7 form-group">
                        <label for="fu_engin">Engin / matériel *</label>
                        <select name="engin_id" id="fu_engin" class="form-control" required>
                            <option value="">Sélectionner…</option>
                            <?= $enginOptions ?>
                        </select>
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="fu_chantier">Chantier</label>
                        <select name="chantier_id" id="fu_chantier"
                            class="form-control"><?= $chantierOptions ?></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Date *</label>
                        <input type="date" name="operation_date" id="fu_date" class="form-control"
                            max="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Carburant</label>
                        <select name="type_carburant" id="fu_type" class="form-control">
                            <?php foreach (TechModel::FUEL_TYPES as $t): ?><option value="<?= eq_e($t) ?>">
                                <?= eq_e($t) ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Source</label>
                        <select name="source" id="fu_source" class="form-control">
                            <?php foreach (TechModel::FUEL_SOURCES as $s): ?><option value="<?= eq_e($s) ?>">
                                <?= eq_e($s) ?></option><?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Quantité (L) *</label>
                        <input type="number" name="quantity_litre" id="fu_qty" class="form-control" min="0.01"
                            step="0.01" required>
                        <small class="eq-hint text-warning d-none" id="fu_qty_warn"></small>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Prix par litre (BIF) *</label>
                        <input type="number" name="unit_price" id="fu_pu" class="form-control" min="0" step="0.01"
                            required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Montant total</label>
                        <input type="text" id="fu_total" class="form-control eq-readonly" value="0 BIF" readonly>
                        <small class="eq-hint">Calculé automatiquement.</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group" id="fu_compteur_wrap">
                        <label><span id="fu_compteur_label">Kilométrage</span> (<span
                                id="fu_compteur_unit">km</span>)</label>
                        <input type="number" name="compteur" id="fu_compteur" class="form-control" min="0" step="0.01">
                        <small class="eq-hint" id="fu_compteur_hint"></small>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>N° bon / ticket</label>
                        <input type="text" name="numero_bon" id="fu_bon" class="form-control" maxlength="50">
                    </div>
                    <div class="col-md-4 form-group d-flex align-items-end">
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" name="plein_complet" id="fu_plein"
                                value="1" checked>
                            <label class="custom-control-label" for="fu_plein">Plein complet</label>
                            <small class="eq-hint">Nécessaire pour mesurer la consommation.</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Chauffeur / opérateur</label>
                        <input type="text" name="operator_name" id="fu_operator" class="form-control" maxlength="150">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Station / fournisseur</label>
                        <input type="text" name="supplier" id="fu_supplier" class="form-control" maxlength="180">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label>Observation</label>
                    <textarea name="observation" id="fu_obs" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn eq-btn"><i class="fas fa-save mr-1"></i>Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- =====================================================================
     MODALE : MAINTENANCE (ajout / modification)
     ===================================================================== -->
<div class="modal fade" id="maintenanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form id="maintForm" class="modal-content eq-modal" method="post" enctype="multipart/form-data"
            action="<?= base_url('new-technique-maintenance') ?>"
            data-store="<?= base_url('new-technique-maintenance') ?>"
            data-update="<?= base_url('engin-maintenance-update') ?>">
            <input type="hidden" name="<?= eq_e($csrfName) ?>" value="<?= eq_e($csrfHash) ?>">
            <input type="hidden" name="id" id="mt_id">
            <div class="modal-header eq-modal-head is-orange">
                <h5 class="modal-title"><i class="fas fa-tools mr-2"></i><span id="maintModalTitle">Nouvelle
                        maintenance</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">&times;</button>
            </div>
            <div class="modal-body">
                <div class="eq-section"><i class="fas fa-info-circle"></i>Intervention</div>
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label for="mt_engin">Engin / matériel *</label>
                        <select name="engin_id" id="mt_engin" class="form-control" required>
                            <option value="">Sélectionner…</option>
                            <?= $enginOptions ?>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Type *</label>
                        <select name="maintenance_type" id="mt_type" class="form-control" required>
                            <option value="">Sélectionner…</option>
                            <?php foreach (TechModel::MAINT_TYPES as $t): ?><option value="<?= eq_e($t) ?>">
                                <?= eq_e($t) ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Nature de l'intervention *</label>
                        <input type="text" name="intervention" id="mt_intervention" class="form-control" maxlength="255"
                            placeholder="Ex : Vidange moteur" list="mt_interventions" required>
                        <datalist id="mt_interventions">
                            <option value="Vidange moteur">
                            <option value="Remplacement filtres">
                            <option value="Révision générale">
                            <option value="Freinage">
                            <option value="Pneumatiques">
                            <option value="Batterie">
                            <option value="Circuit hydraulique">
                            <option value="Embrayage">
                            <option value="Électricité">
                            <option value="Graissage">
                        </datalist>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label for="mt_panne">Panne à l'origine</label>
                        <select name="panne_id" id="mt_panne" class="form-control">
                            <option value="">Aucune</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Chantier</label>
                        <select name="chantier_id" id="mt_chantier"
                            class="form-control"><?= $chantierOptions ?></select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Statut *</label>
                        <select name="maintenance_status" id="mt_status" class="form-control" required>
                            <?php foreach (TechModel::MAINT_STATUS as $s): ?><option value="<?= eq_e($s) ?>">
                                <?= eq_e($s) ?></option><?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group"><label>Date prévue *</label><input type="date" name="planned_date"
                            id="mt_planned" class="form-control" required></div>
                    <div class="col-md-3 form-group"><label>Date début</label><input type="date" name="start_date"
                            id="mt_start" class="form-control"></div>
                    <div class="col-md-3 form-group"><label>Date fin</label><input type="date" name="end_date"
                            id="mt_end" class="form-control"></div>
                    <div class="col-md-3 form-group js-compteur">
                        <label>Compteur (<span class="js-mt-unit">km</span>)</label>
                        <input type="number" name="compteur_intervention" id="mt_compteur" class="form-control" min="0"
                            step="0.01">
                        <small class="eq-hint" id="mt_compteur_hint"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group"><label>Garage / fournisseur</label><input type="text"
                            name="supplier" id="mt_supplier" class="form-control" maxlength="180"></div>
                    <div class="col-md-4 form-group"><label>Technicien responsable</label><input type="text"
                            name="technician" id="mt_technician" class="form-control" maxlength="180"></div>
                    <div class="col-md-4 form-group d-flex align-items-end">
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" name="immobilise" id="mt_immobilise"
                                value="1" checked>
                            <label class="custom-control-label" for="mt_immobilise">Engin immobilisé pendant
                                l'intervention</label>
                        </div>
                    </div>
                </div>

                <div class="eq-section"><i class="fas fa-cogs"></i>Pièces remplacées</div>
                <div id="pieceRows"></div>
                <button type="button" class="btn btn-sm eq-btn-light" id="addPieceRow"><i
                        class="fas fa-plus mr-1"></i>Ajouter une pièce</button>

                <div class="row mt-3">
                    <div class="col-md-4 form-group">
                        <label>Total pièces</label>
                        <input type="text" id="mt_parts" class="form-control eq-readonly" value="0 BIF" readonly>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Main-d'œuvre (BIF)</label>
                        <input type="number" name="labor_cost" id="mt_labor" class="form-control" min="0" step="1"
                            value="0">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Coût total</label>
                        <input type="text" id="mt_total" class="form-control eq-readonly" value="0 BIF" readonly>
                    </div>
                </div>

                <div class="eq-section"><i class="fas fa-calendar-plus"></i>Prochaine échéance</div>
                <div class="row">
                    <div class="col-md-6 form-group"><label>Prochaine maintenance (date)</label><input type="date"
                            name="next_maintenance_date" id="mt_next_date" class="form-control"></div>
                    <div class="col-md-6 form-group js-compteur">
                        <label>Ou au compteur (<span class="js-mt-unit">km</span>)</label>
                        <input type="number" name="next_maintenance_compteur" id="mt_next_cpt" class="form-control"
                            min="0" step="0.01">
                        <small class="eq-hint">Une alerte sera levée à l'approche de l'échéance.</small>
                    </div>
                </div>

                <div class="eq-section"><i class="fas fa-paperclip"></i>Pièces jointes & description</div>
                <div id="mt_docs_existing" class="d-flex flex-column mb-2" style="gap:6px"></div>
                <input type="file" name="documents[]" id="mt_docs" class="form-control"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" multiple>
                <small class="eq-hint">Facture, devis, bon de travail, photos… (10 Mo max par fichier)</small>
                <div id="mt_docs_preview" class="eq-files mt-2"></div>
                <div class="form-group mt-3 mb-0">
                    <label>Description des travaux</label>
                    <textarea name="description" id="mt_description" class="form-control" rows="3"
                        placeholder="Diagnostic, travaux effectués, recommandations…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i>Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<template id="pieceRowTpl">
    <div class="eq-repeat-row js-piece">
        <div class="row no-gutters" style="gap:6px 0">
            <div class="col-md-4 pr-md-1"><input type="text" name="piece_designation[]"
                    class="form-control form-control-sm" placeholder="Désignation de la pièce" maxlength="255"></div>
            <div class="col-md-2 px-md-1"><input type="text" name="piece_reference[]"
                    class="form-control form-control-sm" placeholder="Référence" maxlength="100"></div>
            <div class="col-md-1 px-md-1"><input type="number" name="piece_quantite[]"
                    class="form-control form-control-sm js-qty" min="0.01" step="0.01" value="1" title="Quantité"></div>
            <div class="col-md-2 px-md-1"><input type="number" name="piece_prix[]"
                    class="form-control form-control-sm js-pu" min="0" step="1" placeholder="Prix unitaire"></div>
            <div class="col-md-2 px-md-1"><input type="text" class="form-control form-control-sm eq-readonly js-amount"
                    value="0" readonly tabindex="-1"></div>
            <div class="col-md-1 pl-md-1 text-right"><button type="button" class="btn btn-sm btn-outline-danger"
                    data-action="remove-row" title="Retirer"><i class="fas fa-times"></i></button></div>
        </div>
    </div>
</template>

<!-- =====================================================================
     MODALE : PANNE
     ===================================================================== -->
<div class="modal fade" id="panneModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="panneForm" class="modal-content eq-modal" method="post" action="<?= base_url('engin-panne-store') ?>">
            <input type="hidden" name="<?= eq_e($csrfName) ?>" value="<?= eq_e($csrfHash) ?>">
            <input type="hidden" name="redirect" value="maintenance-carburant">
            <div class="modal-header eq-modal-head is-red">
                <h5 class="modal-title"><i class="fas fa-car-crash mr-2"></i>Signaler une panne</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7 form-group">
                        <label for="pa_engin">Engin / matériel *</label>
                        <select name="engin_id" id="pa_engin" class="form-control" required>
                            <option value="">Sélectionner…</option>
                            <?= $enginOptions ?>
                        </select>
                    </div>
                    <div class="col-md-5 form-group">
                        <label>Chantier</label>
                        <select name="chantier_id" id="pa_chantier"
                            class="form-control"><?= $chantierOptions ?></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Date et heure *</label>
                        <input type="datetime-local" name="date_signalement" id="pa_date" class="form-control" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Gravité *</label>
                        <select name="gravite" class="form-control">
                            <option value="Mineure">Mineure — l'engin peut rouler</option>
                            <option value="Majeure" selected>Majeure — réparation nécessaire</option>
                            <option value="Critique">Critique — arrêt immédiat</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group js-pa-compteur">
                        <label>Compteur (<span id="pa_unit">km</span>)</label>
                        <input type="number" name="compteur" id="pa_compteur" class="form-control" min="0" step="0.01">
                    </div>
                </div>
                <div class="form-group">
                    <label>Description de la panne *</label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Symptômes constatés, circonstances…" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Signalée par</label>
                        <input type="text" name="signale_par" id="pa_par" class="form-control" maxlength="150">
                    </div>
                    <div class="col-md-6 form-group d-flex flex-column justify-content-end">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="immobilise" id="pa_immobilise"
                                value="1" checked>
                            <label class="custom-control-label" for="pa_immobilise">L'engin est immobilisé</label>
                        </div>
                        <div class="custom-control custom-switch mt-1">
                            <input type="checkbox" class="custom-control-input" name="open_maintenance" id="pa_open"
                                value="1">
                            <label class="custom-control-label" for="pa_open">Ouvrir ensuite une maintenance
                                corrective</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-paper-plane mr-1"></i>Signaler</button>
            </div>
        </form>
    </div>
</div>

<!-- =====================================================================
     MODALE : DÉTAIL (ravitaillement / maintenance)
     ===================================================================== -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content eq-modal">
            <div class="modal-header eq-modal-head is-dark">
                <h5 class="modal-title" id="detailTitle">Détail</h5>
                <div class="ml-auto d-flex align-items-center" style="gap:6px">
                    <button type="button" class="btn btn-sm btn-light" id="detailPrint"><i
                            class="fas fa-print mr-1"></i>Imprimer</button>
                    <button type="button" class="close ml-1" data-dismiss="modal" aria-label="Fermer">&times;</button>
                </div>
            </div>
            <div class="modal-body" id="detailBody"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
window.EQChart = window.Chart; // conserve Chart.js v4 même si une autre version est chargée plus tard
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

    var OPEN_PANNES = <?= eq_json($openPannesJs) ?>;
    var MONTHLY = <?= eq_json($monthly) ?>;
    var PREFILL_PANNE = <?= eq_json($prefillPanne ? (int) $prefillPanne->id : null) ?>;
    var PREFILL_ENGIN = <?= eq_json($prefillEngin ?: null) ?>;
    var TODAY = <?= eq_json(date('Y-m-d')) ?>;

    function enginInfo($select) {
        var $o = $select.find('option:selected');
        if (!$o.val()) {
            return null;
        }
        return {
            type: $o.data('compteur'),
            actuel: parseFloat($o.data('actuel')) || 0,
            carburant: $o.data('carburant'),
            capacite: parseFloat($o.data('capacite')) || 0,
            chantier: parseInt($o.data('chantier'), 10) || '',
            responsable: $o.data('responsable') || ''
        };
    }

    function prepareForm($form, mode) {
        $form[0].reset();
        $form.data('mode', mode);
        $form.attr('action', $form.data(mode === 'create' ? 'store' : 'update'));
        $form.find('button[type="submit"]').prop('disabled', false).find('.fa-spinner').remove();
    }

    $('form.eq-modal').on('submit', function() {
        $(this).find('button[type="submit"]').prop('disabled', true)
            .prepend('<i class="fas fa-spinner fa-spin mr-1"></i>');
    });

    /* =================================================================
     |  CARBURANT
     * ================================================================= */
    var $fuelForm = $('#fuelForm');

    function calcFuel() {
        var q = parseFloat($('#fu_qty').val()) || 0;
        var pu = parseFloat($('#fu_pu').val()) || 0;
        $('#fu_total').val(EQ.money(q * pu));
        var info = enginInfo($('#fu_engin'));
        var over = info && info.capacite > 0 && q > info.capacite;
        $('#fu_qty_warn').toggleClass('d-none', !over)
            .text(over ? 'Supérieur à la capacité du réservoir (' + EQ.num(info.capacite) + ' L).' : '');
    }

    function onFuelEngin() {
        var info = enginInfo($('#fu_engin'));
        if (!info) {
            $('#fu_compteur_hint').text('');
            return;
        }
        if ($fuelForm.data('mode') === 'create') {
            if (['Diesel', 'Essence', 'Mélange 2T'].indexOf(info.carburant) >= 0) {
                $('#fu_type').val(info.carburant);
            }
            $('#fu_chantier').val(info.chantier);
            if (!$('#fu_operator').val()) {
                $('#fu_operator').val(info.responsable);
            }
        }
        $('#fu_compteur_wrap').toggleClass('d-none', info.type === 'aucun');
        $('#fu_compteur_label').text(info.type === 'heure' ? 'Compteur horaire' : 'Kilométrage');
        $('#fu_compteur_unit').text(EQ.unit(info.type));
        $('#fu_compteur_hint').text('Dernier relevé connu : ' + EQ.num(info.actuel) + ' ' + EQ.unit(info.type));
        calcFuel();
    }

    function openFuel(enginId) {
        prepareForm($fuelForm, 'create');
        $('#fu_id').val('');
        $('#fuelModalTitle').text('Nouveau ravitaillement');
        $('#fu_date').val(TODAY);
        $('#fu_engin').val(enginId || '');
        onFuelEngin();
        calcFuel();
        $('#fuelModal').modal('show');
    }

    $('#fu_engin').on('change', onFuelEngin);
    $('#fu_qty, #fu_pu').on('input', calcFuel);
    $(document).on('click', '[data-action="new-fuel"]', function(e) {
        e.preventDefault();
        openFuel();
    });

    $fuelForm.on('submit', function(e) {
        var info = enginInfo($('#fu_engin'));
        var cpt = parseFloat($('#fu_compteur').val());
        if ($fuelForm.data('mode') === 'create' && info && info.type !== 'aucun' && !isNaN(cpt) && cpt <
            info.actuel &&
            $('#fu_date').val() === TODAY) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $fuelForm.find('button[type="submit"]').prop('disabled', false).find('.fa-spinner')
                .remove();
            Swal.fire('Compteur incohérent', 'Le relevé saisi est inférieur au dernier relevé connu (' +
                EQ.num(info.actuel) + ' ' + EQ.unit(info.type) + ').', 'warning');
        }
    });

    $(document).on('click', '[data-action="edit-fuel"]', function() {
        EQ.get('engin-fuel-get/' + $(this).data('id')).done(function(r) {
            var f = r.fuel;
            prepareForm($fuelForm, 'edit');
            $('#fuelModalTitle').text('Modifier ' + f.reference);
            $('#fu_id').val(f.id);
            $('#fu_engin').val(f.engin_id);
            onFuelEngin();
            $('#fu_chantier').val(f.chantier_id || '');
            $('#fu_date').val(f.operation_date);
            $('#fu_type').val(f.type_carburant);
            $('#fu_source').val(f.source);
            $('#fu_qty').val(f.quantity_litre);
            $('#fu_pu').val(f.unit_price);
            $('#fu_compteur').val(f.type_compteur === 'heure' ? (f.hour_meter || '') : (f
                .kilometrage || ''));
            $('#fu_bon').val(f.numero_bon || '');
            $('#fu_plein').prop('checked', parseInt(f.plein_complet, 10) === 1);
            $('#fu_operator').val(f.operator_name || '');
            $('#fu_supplier').val(f.supplier || '');
            $('#fu_obs').val(f.observation || '');
            calcFuel();
            $('#fuelModal').modal('show');
        }).fail(EQ.fail);
    });

    $(document).on('click', '[data-action="cancel-fuel"]', function() {
        var id = $(this).data('id');
        EQ.confirm({
            titleText: 'Annuler le ravitaillement ' + $(this).data('ref') + ' ?',
            text: 'Il sera retiré des statistiques et des coûts.',
            confirmButtonText: 'Annuler le ravitaillement'
        }).then(function(res) {
            if (!res.isConfirmed) {
                return;
            }
            EQ.post('engin-fuel-cancel', {
                id: id
            }).done(function() {
                location.reload();
            }).fail(EQ.fail);
        });
    });

    $(document).on('click', '[data-action="view-fuel"]', function() {
        EQ.get('engin-fuel-get/' + $(this).data('id')).done(function(r) {
            var f = r.fuel;
            var cpt = f.type_compteur === 'heure' ? f.hour_meter : f.kilometrage;
            $('#detailTitle').html('<i class="fas fa-gas-pump mr-2"></i>Ravitaillement ' + EQ
                .esc(f.reference));
            $('#detailBody').html(
                '<dl class="eq-dl">' +
                '<dt>Engin</dt><dd><strong>' + EQ.esc(f.designation) + '</strong> · ' + EQ
                .esc(f.code_engin) + (f.plaque ? ' · ' + EQ.esc(f.plaque) : '') + '</dd>' +
                '<dt>Date</dt><dd>' + EQ.date(f.operation_date) + '</dd>' +
                '<dt>Chantier</dt><dd>' + EQ.esc(f.chantier_name || '-') + '</dd>' +
                '<dt>Carburant</dt><dd>' + EQ.esc(f.type_carburant) + ' · ' + EQ.esc(f
                    .source) + (f.numero_bon ? ' · bon n° ' + EQ.esc(f.numero_bon) : '') +
                '</dd>' +
                '<dt>Quantité</dt><dd>' + EQ.num(f.quantity_litre, 2) + ' L × ' + EQ.num(f
                    .unit_price) + ' BIF</dd>' +
                '<dt>Montant</dt><dd><strong>' + EQ.money(f.total_amount) +
                '</strong></dd>' +
                '<dt>Compteur</dt><dd>' + (cpt !== null ? EQ.num(cpt) + ' ' + EQ.unit(f
                    .type_compteur) : '-') + (parseInt(f.plein_complet, 10) ?
                    ' · plein complet' : ' · plein partiel') + '</dd>' +
                '<dt>Chauffeur</dt><dd>' + EQ.esc(f.operator_name || '-') + '</dd>' +
                '<dt>Fournisseur</dt><dd>' + EQ.esc(f.supplier || '-') + '</dd>' +
                '<dt>Observation</dt><dd>' + EQ.esc(f.observation || '-') + '</dd>' +
                '<dt>Saisi le</dt><dd>' + EQ.esc(f.created_at || '-') + '</dd>' +
                '</dl>'
            );
            $('#detailModal').modal('show');
        }).fail(EQ.fail);
    });

    /* =================================================================
     |  MAINTENANCE
     * ================================================================= */
    var $maintForm = $('#maintForm');

    function addPieceRow(p) {
        var $row = $($.parseHTML(document.getElementById('pieceRowTpl').innerHTML.trim()));
        if (p) {
            $row.find('[name="piece_designation[]"]').val(p.designation);
            $row.find('[name="piece_reference[]"]').val(p.reference_piece || '');
            $row.find('[name="piece_quantite[]"]').val(p.quantite);
            $row.find('[name="piece_prix[]"]').val(p.prix_unitaire);
        }
        $('#pieceRows').append($row);
        calcMaint();
    }

    function calcMaint() {
        var parts = 0;
        $('#pieceRows .js-piece').each(function() {
            var q = parseFloat($(this).find('.js-qty').val()) || 0;
            var pu = parseFloat($(this).find('.js-pu').val()) || 0;
            $(this).find('.js-amount').val(EQ.num(q * pu));
            parts += q * pu;
        });
        var labor = parseFloat($('#mt_labor').val()) || 0;
        $('#mt_parts').val(EQ.money(parts));
        $('#mt_total').val(EQ.money(parts + labor));
    }

    function fillPannes(enginId, selected) {
        var $sel = $('#mt_panne').empty().append('<option value="">Aucune</option>');
        OPEN_PANNES.filter(function(p) {
            return p.engin_id === parseInt(enginId, 10);
        }).forEach(function(p) {
            $sel.append($('<option>').val(p.id).text(p.reference + ' — ' + p.gravite + ' : ' + String(p
                .description).substr(0, 60)));
        });
        if (selected && !$sel.find('option[value="' + selected.id + '"]').length) {
            $sel.append($('<option>').val(selected.id).text(selected.label));
        }
        $sel.val(selected ? selected.id : '');
    }

    function onMaintEngin() {
        var info = enginInfo($('#mt_engin'));
        fillPannes($('#mt_engin').val(), null);
        if (!info) {
            return;
        }
        $('.js-compteur').toggleClass('d-none', info.type === 'aucun');
        $('.js-mt-unit').text(EQ.unit(info.type));
        $('#mt_compteur_hint').text('Actuel : ' + EQ.num(info.actuel) + ' ' + EQ.unit(info.type));
        if ($maintForm.data('mode') === 'create') {
            $('#mt_chantier').val(info.chantier);
        }
    }

    function openMaintenance(enginId) {
        prepareForm($maintForm, 'create');
        $('#mt_id').val('');
        $('#maintModalTitle').text('Nouvelle maintenance');
        $('#pieceRows, #mt_docs_existing, #mt_docs_preview').empty();
        $('#mt_planned').val(TODAY);
        $('#mt_engin').val(enginId || '');
        onMaintEngin();
        addPieceRow();
        $('#maintenanceModal').modal('show');
    }

    $('#mt_engin').on('change', onMaintEngin);
    $('#addPieceRow').on('click', function() {
        addPieceRow();
    });
    $('#pieceRows').on('input', '.js-qty, .js-pu', calcMaint);
    $('#pieceRows').on('click', '[data-action="remove-row"]', function() {
        $(this).closest('.js-piece').remove();
        calcMaint();
    });
    $('#mt_labor').on('input', calcMaint);
    $('#mt_docs').on('change', function() {
        EQ.previewFiles(this, document.getElementById('mt_docs_preview'));
    });
    $('#mt_status').on('change', function() {
        var s = $(this).val();
        if ((s === 'En cours' || s === 'Terminé') && !$('#mt_start').val()) {
            $('#mt_start').val(TODAY);
        }
        if (s === 'Terminé' && !$('#mt_end').val()) {
            $('#mt_end').val(TODAY);
        }
    });
    $('#mt_panne').on('change', function() {
        if ($(this).val() && !$('#mt_type').val()) {
            $('#mt_type').val('Corrective');
        }
    });

    $(document).on('click', '[data-action="new-maintenance"]', function(e) {
        e.preventDefault();
        openMaintenance();
    });

    $(document).on('click', '[data-action="panne-maintenance"]', function() {
        openFromPanne(parseInt($(this).data('id'), 10));
    });

    function openFromPanne(panneId) {
        var p = OPEN_PANNES.filter(function(x) {
            return x.id === panneId;
        })[0];
        if (!p) {
            return openMaintenance();
        }
        openMaintenance(p.engin_id);
        fillPannes(p.engin_id, {
            id: p.id,
            label: p.reference
        });
        $('#mt_type').val('Corrective');
        $('#mt_status').val('En cours').trigger('change');
        $('#mt_intervention').val('Réparation : ' + String(p.description).substr(0, 200));
        if (p.chantier_id) {
            $('#mt_chantier').val(p.chantier_id);
        }
        if (p.compteur) {
            $('#mt_compteur').val(p.compteur);
        }
    }

    function renderMaintDocs(docs) {
        var $box = $('#mt_docs_existing').empty();
        (docs || []).forEach(function(d) {
            $box.append(
                '<div class="eq-doc"><i class="' + EQ.fileIcon(d.document) + ' fa-lg"></i>' +
                '<a class="eq-doc-name" href="' + EQ.esc(d.url) +
                '" target="_blank" rel="noopener">' + EQ.esc(d.original_name || d.document) +
                '</a>' +
                '<small class="text-muted">' + EQ.size(d.file_size) + '</small>' +
                '<button type="button" class="btn btn-sm btn-outline-danger eq-icon-btn" data-action="mdoc-delete" data-id="' +
                d.id + '"><i class="fas fa-trash-alt"></i></button></div>'
            );
        });
    }

    $('#mt_docs_existing').on('click', '[data-action="mdoc-delete"]', function() {
        var id = $(this).data('id');
        var $row = $(this).closest('.eq-doc');
        EQ.confirm({
            titleText: 'Supprimer cette pièce jointe ?',
            confirmButtonText: 'Supprimer'
        }).then(function(res) {
            if (!res.isConfirmed) {
                return;
            }
            EQ.post('engin-maintenance-document-delete', {
                id: id
            }).done(function() {
                $row.remove();
                EQ.toast('success', 'Pièce jointe supprimée');
            }).fail(EQ.fail);
        });
    });

    $(document).on('click', '[data-action="edit-maintenance"]', function(e) {
        e.preventDefault();
        EQ.get('engin-maintenance-get/' + $(this).data('id')).done(function(r) {
            var m = r.maintenance;
            prepareForm($maintForm, 'edit');
            $('#maintModalTitle').text('Modifier ' + m.reference);
            $('#mt_id').val(m.id);
            $('#pieceRows, #mt_docs_preview').empty();
            $('#mt_engin').val(m.engin_id);
            onMaintEngin();
            fillPannes(m.engin_id, m.panne_id ? {
                id: m.panne_id,
                label: m.panne_reference || ('Panne #' + m.panne_id)
            } : null);
            $('#mt_type').val(m.maintenance_type);
            $('#mt_intervention').val(m.intervention);
            $('#mt_chantier').val(m.chantier_id || '');
            $('#mt_status').val(m.maintenance_status);
            $('#mt_planned').val(m.planned_date);
            $('#mt_start').val(m.start_date || '');
            $('#mt_end').val(m.end_date || '');
            $('#mt_compteur').val(m.compteur_intervention || '');
            $('#mt_supplier').val(m.supplier || '');
            $('#mt_technician').val(m.technician || '');
            $('#mt_immobilise').prop('checked', parseInt(m.immobilise, 10) === 1);
            $('#mt_labor').val(m.labor_cost);
            $('#mt_next_date').val(m.next_maintenance_date || '');
            $('#mt_next_cpt').val(m.next_maintenance_compteur || '');
            $('#mt_description').val(m.description || '');
            if (m.pieces.length) {
                m.pieces.forEach(function(p) {
                    addPieceRow(p);
                });
            } else if (parseFloat(m.parts_cost) > 0) {
                addPieceRow({
                    designation: 'Pièces (montant global)',
                    quantite: 1,
                    prix_unitaire: m.parts_cost
                });
            } else {
                addPieceRow();
            }
            renderMaintDocs(m.documents);
            calcMaint();
            $('#maintenanceModal').modal('show');
        }).fail(EQ.fail);
    });

    $(document).on('click', '[data-action="maint-status"]', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        var labels = {
            'En cours': 'Démarrer cette maintenance ?',
            'Terminé': 'Marquer cette maintenance comme terminée ?',
            'Annulé': 'Annuler cette maintenance ?'
        };
        EQ.confirm({
            titleText: labels[status],
            text: status === 'Terminé' ?
                'L\'engin redeviendra disponible et la panne liée sera résolue.' : '',
            icon: status === 'Annulé' ? 'warning' : 'question',
            confirmButtonColor: status === 'Annulé' ? '#dc3545' : '#0f766e'
        }).then(function(res) {
            if (!res.isConfirmed) {
                return;
            }
            EQ.post('engin-maintenance-status', {
                id: id,
                status: status
            }).done(function() {
                location.reload();
            }).fail(EQ.fail);
        });
    });

    $(document).on('click', '[data-action="view-maintenance"]', function(e) {
        e.preventDefault();
        EQ.get('engin-maintenance-get/' + $(this).data('id')).done(function(r) {
            var m = r.maintenance;
            var rows = m.pieces.map(function(p) {
                return '<tr><td>' + EQ.esc(p.designation) + (p.reference_piece ?
                        ' <small class="text-muted">' + EQ.esc(p.reference_piece) +
                        '</small>' : '') +
                    '</td><td class="text-right">' + EQ.num(p.quantite, 2) +
                    '</td><td class="text-right">' + EQ.num(p.prix_unitaire) +
                    '</td><td class="text-right">' + EQ.num(p.montant) + '</td></tr>';
            }).join('');
            var docs = m.documents.map(function(d) {
                return '<a class="d-block small" href="' + EQ.esc(d.url) +
                    '" target="_blank" rel="noopener"><i class="' + EQ.fileIcon(d
                        .document) + ' mr-1"></i>' + EQ.esc(d.original_name || d
                        .document) + '</a>';
            }).join('');
            var unit = EQ.unit(m.type_compteur);

            $('#detailTitle').html('<i class="fas fa-tools mr-2"></i>Maintenance ' + EQ.esc(m
                .reference));
            $('#detailBody').html(
                '<div class="d-flex justify-content-between align-items-start mb-3"><div><h5 class="mb-0">' +
                EQ.esc(m.intervention) + '</h5>' +
                '<small class="text-muted">' + EQ.esc(m.maintenance_type) + ' · ' + EQ.esc(m
                    .designation) + ' (' + EQ.esc(m.code_engin) + ')</small></div>' +
                '<span class="eq-badge ' + ({
                    'Terminé': 'eq-badge-success',
                    'En cours': 'eq-badge-warning',
                    'Annulé': 'eq-badge-danger'
                } [m.maintenance_status] || 'eq-badge-info') + '">' + EQ.esc(m
                    .maintenance_status) + '</span></div>' +
                '<dl class="eq-dl">' +
                '<dt>Dates</dt><dd>Prévue ' + EQ.date(m.planned_date) + ' · début ' + EQ
                .date(m.start_date) + ' · fin ' + EQ.date(m.end_date) + '</dd>' +
                '<dt>Chantier</dt><dd>' + EQ.esc(m.chantier_name || '-') + '</dd>' +
                (m.panne_reference ? '<dt>Panne liée</dt><dd>' + EQ.esc(m.panne_reference) +
                    ' — ' + EQ.esc(m.panne_description) + '</dd>' : '') +
                '<dt>Compteur</dt><dd>' + (m.compteur_intervention ? EQ.num(m
                    .compteur_intervention) + ' ' + unit : '-') + '</dd>' +
                '<dt>Garage / technicien</dt><dd>' + EQ.esc(m.supplier || '-') + ' / ' + EQ
                .esc(m.technician || '-') + '</dd>' +
                '<dt>Immobilisation</dt><dd>' + (parseInt(m.immobilise, 10) ? 'Oui' :
                    'Non') + '</dd>' +
                '<dt>Prochaine échéance</dt><dd>' + EQ.date(m.next_maintenance_date) + (m
                    .next_maintenance_compteur ? ' ou ' + EQ.num(m
                        .next_maintenance_compteur) + ' ' + unit : '') + '</dd>' +
                '</dl>' +
                '<div class="eq-block-title">Pièces remplacées</div>' +
                (rows ?
                    '<table class="table table-sm eq-table"><thead><tr><th>Pièce</th><th class="text-right">Qté</th><th class="text-right">P.U.</th><th class="text-right">Montant</th></tr></thead><tbody>' +
                    rows + '</tbody></table>' :
                    '<p class="small text-muted">Aucune pièce détaillée.</p>') +
                '<table class="table table-sm mb-0"><tr><td>Pièces</td><td class="text-right">' +
                EQ.money(m.parts_cost) + '</td></tr>' +
                '<tr><td>Main-d\'œuvre</td><td class="text-right">' + EQ.money(m
                    .labor_cost) + '</td></tr>' +
                '<tr class="font-weight-bold"><td>Total</td><td class="text-right">' + EQ
                .money(m.total_cost) + '</td></tr></table>' +
                (m.description ?
                    '<div class="eq-block-title">Description</div><p class="small" style="white-space:pre-line">' +
                    EQ.esc(m.description) + '</p>' : '') +
                (docs ? '<div class="eq-block-title">Pièces jointes</div>' + docs : '')
            );
            $('#detailModal').modal('show');
        }).fail(EQ.fail);
    });

    $('#detailPrint').on('click', function() {
        EQ.printElement('detailBody', $('#detailTitle').text());
    });

    /* =================================================================
     |  PANNES
     * ================================================================= */
    function nowLocal() {
        var d = new Date();
        d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
        return d.toISOString().substr(0, 16);
    }

    function onPanneEngin() {
        var info = enginInfo($('#pa_engin'));
        if (!info) {
            return;
        }
        $('#pa_chantier').val(info.chantier);
        $('.js-pa-compteur').toggleClass('d-none', info.type === 'aucun');
        $('#pa_unit').text(EQ.unit(info.type));
        $('#pa_compteur').attr('placeholder', EQ.num(info.actuel));
    }

    function openPanne(enginId) {
        $('#panneForm')[0].reset();
        $('#panneForm button[type="submit"]').prop('disabled', false).find('.fa-spinner').remove();
        $('#pa_date').val(nowLocal());
        $('#pa_engin').val(enginId || '');
        onPanneEngin();
        $('#panneModal').modal('show');
    }

    $('#pa_engin').on('change', onPanneEngin);
    $(document).on('click', '[data-action="new-panne"]', function(e) {
        e.preventDefault();
        openPanne();
    });

    $(document).on('click', '[data-action="panne-status"]', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        EQ.confirm({
            titleText: 'Passer la panne en « ' + status + ' » ?',
            icon: status === 'Annulée' ? 'warning' : 'question',
            confirmButtonColor: status === 'Annulée' ? '#dc3545' : '#0f766e'
        }).then(function(res) {
            if (!res.isConfirmed) {
                return;
            }
            EQ.post('engin-panne-status', {
                id: id,
                status: status
            }).done(function() {
                location.reload();
            }).fail(EQ.fail);
        });
    });

    /* =================================================================
     |  GRAPHIQUE DES COÛTS
     * ================================================================= */
    var ChartJs = window.EQChart;
    var canvas = document.getElementById('costChart');
    if (ChartJs && canvas) {
        var keys = Object.keys(MONTHLY);
        new ChartJs(canvas, {
            type: 'bar',
            data: {
                labels: keys.map(function(k) {
                    return new Date(k + '-01T00:00:00').toLocaleDateString('fr-FR', {
                        month: 'short',
                        year: '2-digit'
                    });
                }),
                datasets: [{
                        label: 'Carburant',
                        data: keys.map(function(k) {
                            return MONTHLY[k].fuel;
                        }),
                        backgroundColor: '#22c55e',
                        borderRadius: 6
                    },
                    {
                        label: 'Maintenance',
                        data: keys.map(function(k) {
                            return MONTHLY[k].maintenance;
                        }),
                        backgroundColor: '#f59e0b',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            callback: function(v) {
                                return EQ.num(v);
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                return c.dataset.label + ' : ' + EQ.money(c.parsed.y);
                            }
                        }
                    }
                }
            }
        });
    }

    /* =================================================================
     |  OUVERTURE DIRECTE (liens depuis la page Engin & Materiel)
     |  maintenance-carburant?engin_id=5#fuel | #maintenance | #panne
     |  maintenance-carburant?panne=12#maintenance
     * ================================================================= */
    var hash = window.location.hash;
    if (PREFILL_PANNE) {
        openFromPanne(PREFILL_PANNE);
    } else if (hash === '#fuel') {
        openFuel(PREFILL_ENGIN);
    } else if (hash === '#maintenance') {
        openMaintenance(PREFILL_ENGIN);
    } else if (hash === '#panne') {
        openPanne(PREFILL_ENGIN);
    }
    if (hash || PREFILL_PANNE) {
        history.replaceState(null, '', window.location.pathname);
    }
});
</script>