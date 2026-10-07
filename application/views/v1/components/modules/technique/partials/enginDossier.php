<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* Rendu chargé en AJAX dans la modale « Fiche & rapport » (et imprimable). */
$e        = $engin;
$unit     = eq_unit($e->type_compteur);
$photo    = !empty($e->photo_principale)
    ? base_url('uploads/engins/photos/' . $e->photo_principale)
    : base_url('assets/v1/dist/img/no-image.png');
$today    = date('Y-m-d');
$soon     = date('Y-m-d', strtotime('+30 days'));
$maxMonth = 0;
foreach ($monthly as $m) {
    $maxMonth = max($maxMonth, $m['fuel'] + $m['maintenance']);
}
$moisFr = ['01' => 'janv.', '02' => 'févr.', '03' => 'mars', '04' => 'avr.', '05' => 'mai', '06' => 'juin',
           '07' => 'juil.', '08' => 'août', '09' => 'sept.', '10' => 'oct.', '11' => 'nov.', '12' => 'déc.'];
?>
<div class="eq-dossier">

    <!-- En-tête -->
    <div class="eq-dossier-head">
        <img class="eq-dossier-photo" src="<?= $photo ?>" alt="">
        <div class="flex-fill">
            <div class="d-flex flex-wrap align-items-center" style="gap:8px">
                <h4 class="eq-dossier-title"><?= eq_e($e->designation) ?></h4>
                <span class="eq-badge <?= eq_badge($e->etat) ?>"><?= eq_e($e->etat) ?></span>
            </div>
            <div class="text-muted small">
                <?= eq_e($e->code_engin) ?> · <?= eq_e($e->nom_categorie) ?>
                <?= $e->plaque ? ' · Plaque ' . eq_e($e->plaque) : '' ?>
                <?= ($e->marque || $e->modele) ? ' · ' . eq_e(trim($e->marque . ' ' . $e->modele)) : '' ?>
            </div>
            <div class="small mt-1">
                <i class="fas fa-map-marker-alt text-muted mr-1"></i><?= eq_e($e->chantier_name ?: ($e->localisation ?: '-')) ?>
                <?php if ($e->responsable): ?> · <i class="fas fa-user text-muted mx-1"></i><?= eq_e($e->responsable) ?><?php endif; ?>
                <?php if ($e->type_compteur !== 'aucun'): ?> · <i class="fas fa-tachometer-alt text-muted mx-1"></i><?= eq_num($e->compteur_actuel) . ' ' . $unit ?><?php endif; ?>
            </div>
            <div class="small text-muted mt-1">Rapport du <strong><?= eq_date($du) ?></strong> au <strong><?= eq_date($au) ?></strong> · édité le <?= date('d/m/Y à H:i') ?></div>
        </div>
        <?php if ($e->etat !== 'Réformé'): ?>
            <div class="no-print d-flex flex-column" style="gap:6px">
                <a class="btn btn-sm eq-btn-light" href="<?= base_url('maintenance-carburant?engin_id=' . (int) $e->id . '#fuel') ?>"><i class="fas fa-gas-pump mr-1 text-success"></i>Ravitaillement</a>
                <a class="btn btn-sm eq-btn-light" href="<?= base_url('maintenance-carburant?engin_id=' . (int) $e->id . '#maintenance') ?>"><i class="fas fa-tools mr-1 text-warning"></i>Maintenance</a>
                <a class="btn btn-sm eq-btn-light" href="<?= base_url('maintenance-carburant?engin_id=' . (int) $e->id . '#panne') ?>"><i class="fas fa-car-crash mr-1 text-danger"></i>Panne</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Indicateurs -->
    <div class="eq-kpis">
        <div class="eq-kpi">
            <div class="eq-kpi-label">Coût total</div>
            <div class="eq-kpi-value"><?= eq_money($coutTotal) ?></div>
            <div class="eq-kpi-sub">Carburant + maintenance</div>
        </div>
        <div class="eq-kpi">
            <div class="eq-kpi-label">Carburant</div>
            <div class="eq-kpi-value"><?= eq_num($fuel->litres, 1) ?> L</div>
            <div class="eq-kpi-sub"><?= eq_money($fuel->montant) ?> · <?= (int) $fuel->nb ?> plein(s)</div>
        </div>
        <div class="eq-kpi">
            <div class="eq-kpi-label">Maintenance</div>
            <div class="eq-kpi-value"><?= eq_money($maint->cout) ?></div>
            <div class="eq-kpi-sub"><?= (int) $maint->nb ?> intervention(s) · <?= (int) $maint->preventives ?> prév. / <?= (int) $maint->correctives ?> corr.</div>
        </div>
        <?php if ($e->type_compteur !== 'aucun'): ?>
            <div class="eq-kpi">
                <div class="eq-kpi-label">Consommation réelle</div>
                <div class="eq-kpi-value"><?= ($conso && $conso->conso !== null) ? eq_num($conso->conso, 1) : '—' ?> <small><?= eq_conso_unit($e->type_compteur) ?></small></div>
                <div class="eq-kpi-sub">
                    <?php if ($conso && $conso->conso !== null && $conso->reference): ?>
                        Norme <?= eq_num($conso->reference, 1) ?> ·
                        <span class="<?= $conso->ecart > 20 ? 'text-danger font-weight-bold' : ($conso->ecart > 0 ? 'text-warning' : 'text-success') ?>">
                            <?= ($conso->ecart > 0 ? '+' : '') . eq_num($conso->ecart, 0) ?> %
                        </span>
                    <?php elseif ($e->consommation_reference): ?>
                        Norme <?= eq_num($e->consommation_reference, 1) ?> · données insuffisantes
                    <?php else: ?>
                        Au moins 2 pleins complets avec compteur requis
                    <?php endif; ?>
                </div>
            </div>
            <div class="eq-kpi">
                <div class="eq-kpi-label">Coût d'exploitation</div>
                <div class="eq-kpi-value"><?= $coutUnitaire !== null ? eq_num($coutUnitaire, 0) : '—' ?> <small>BIF/<?= $unit ?></small></div>
                <div class="eq-kpi-sub"><?= eq_num($distance) . ' ' . $unit ?> parcourus sur la période</div>
            </div>
        <?php endif; ?>
        <div class="eq-kpi">
            <div class="eq-kpi-label">Disponibilité</div>
            <div class="eq-kpi-value <?= $disponibilite < 80 ? 'text-danger' : '' ?>"><?= eq_num($disponibilite, 0) ?> %</div>
            <div class="eq-kpi-sub"><?= (int) $joursImmo ?> jour(s) d'immobilisation / <?= (int) $joursPeriode ?></div>
        </div>
        <div class="eq-kpi">
            <div class="eq-kpi-label">Pannes</div>
            <div class="eq-kpi-value"><?= count($pannes) ?></div>
            <div class="eq-kpi-sub">signalée(s) sur la période</div>
        </div>
    </div>

    <div class="row">
        <!-- Fiche technique & immobilisation -->
        <div class="col-lg-6">
            <div class="eq-block-title"><i class="fas fa-info-circle mr-1 text-muted"></i>Fiche technique</div>
            <dl class="eq-dl">
                <dt>N° de série</dt><dd><?= eq_e($e->numero_serie ?: '-') ?></dd>
                <dt>N° châssis / moteur</dt><dd><?= eq_e(($e->numero_chassis ?: '-') . ' / ' . ($e->numero_moteur ?: '-')) ?></dd>
                <dt>Année</dt><dd><?= eq_e($e->annee_fabrication ?: '-') ?></dd>
                <dt>Carburant</dt><dd><?= eq_e($e->type_carburant) ?><?= $e->capacite_reservoir ? ' · réservoir ' . eq_num($e->capacite_reservoir) . ' L' : '' ?></dd>
                <dt>Compteur</dt><dd><?= $e->type_compteur === 'aucun' ? 'Aucun' : 'Initial ' . eq_num($e->compteur_initial) . ' → actuel ' . eq_num($e->compteur_actuel) . ' ' . $unit ?></dd>
                <?php if ($e->etat === 'Réformé'): ?>
                    <dt>Réforme</dt><dd class="text-danger"><?= eq_date($e->date_reforme) ?> — <?= eq_e($e->motif_reforme) ?></dd>
                <?php endif; ?>
            </dl>
        </div>
        <div class="col-lg-6">
            <div class="eq-block-title"><i class="fas fa-coins mr-1 text-muted"></i>Immobilisation</div>
            <dl class="eq-dl">
                <dt>Acquisition</dt><dd><?= eq_date($e->date_acquisition) ?> · <?= eq_money($e->valeur_achat) ?></dd>
                <dt>Mise en service</dt><dd><?= eq_date($e->date_mise_service) ?></dd>
                <?php if ($amort): ?>
                    <dt>Amortissement</dt><dd><?= (int) $e->duree_amortissement_mois ?> mois · <?= eq_money($amort->dotation_mensuelle) ?>/mois</dd>
                    <dt>Cumul amorti</dt><dd><?= eq_money($amort->cumul) ?> (<?= eq_num($amort->taux, 0) ?> %)</dd>
                    <dt>Valeur nette comptable</dt><dd><strong><?= eq_money($amort->vnc) ?></strong></dd>
                <?php else: ?>
                    <dt>Amortissement</dt><dd class="text-muted">Renseignez la valeur, la date et la durée pour le calcul.</dd>
                <?php endif; ?>
            </dl>
        </div>
    </div>

    <!-- Coûts mensuels -->
    <div class="eq-block-title"><i class="fas fa-chart-bar mr-1 text-muted"></i>Coûts des 6 derniers mois</div>
    <table class="table table-sm eq-table">
        <thead><tr><th>Mois</th><th class="text-right">Carburant</th><th class="text-right">Maintenance</th><th class="text-right">Total</th><th style="width:35%"></th></tr></thead>
        <tbody>
            <?php foreach ($monthly as $ym => $m):
                $t = $m['fuel'] + $m['maintenance']; ?>
                <tr>
                    <td><?= $moisFr[substr($ym, 5, 2)] . ' ' . substr($ym, 0, 4) ?></td>
                    <td class="text-right"><?= eq_num($m['fuel']) ?></td>
                    <td class="text-right"><?= eq_num($m['maintenance']) ?></td>
                    <td class="text-right font-weight-bold"><?= eq_num($t) ?></td>
                    <td>
                        <div class="progress" style="height:7px">
                            <div class="progress-bar bg-success" style="width:<?= $maxMonth > 0 ? round($m['fuel'] / $maxMonth * 100, 1) : 0 ?>%"></div>
                            <div class="progress-bar bg-warning" style="width:<?= $maxMonth > 0 ? round($m['maintenance'] / $maxMonth * 100, 1) : 0 ?>%"></div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Carburant -->
    <div class="eq-block-title"><i class="fas fa-gas-pump mr-1 text-success"></i>Ravitaillements (<?= count($fuels) ?>)</div>
    <?php if ($fuels): ?>
        <div class="table-responsive">
            <table class="table table-sm eq-table">
                <thead><tr><th>Date</th><th>Réf.</th><th class="text-right">Litres</th><th class="text-right">Prix/L</th><th class="text-right">Montant</th><th class="text-right">Compteur</th><th>Plein</th><th>Chauffeur</th></tr></thead>
                <tbody>
                    <?php foreach ($fuels as $f):
                        $cpt = $e->type_compteur === 'heure' ? $f->hour_meter : $f->kilometrage; ?>
                        <tr>
                            <td><?= eq_date($f->operation_date) ?></td>
                            <td class="eq-ref"><?= eq_e($f->reference) ?></td>
                            <td class="text-right"><?= eq_num($f->quantity_litre, 2) ?></td>
                            <td class="text-right"><?= eq_num($f->unit_price) ?></td>
                            <td class="text-right font-weight-bold"><?= eq_num($f->total_amount) ?></td>
                            <td class="text-right"><?= $cpt !== null ? eq_num($cpt) . ' ' . $unit : '-' ?></td>
                            <td><?= (int) $f->plein_complet ? '<i class="fas fa-check text-success"></i>' : '<span class="text-muted">partiel</span>' ?></td>
                            <td><?= eq_e($f->operator_name ?: '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot><tr class="font-weight-bold"><td colspan="2">Total</td><td class="text-right"><?= eq_num($fuel->litres, 2) ?></td><td></td><td class="text-right"><?= eq_num($fuel->montant) ?></td><td colspan="3"></td></tr></tfoot>
            </table>
        </div>
    <?php else: ?>
        <p class="text-muted small">Aucun ravitaillement sur la période.</p>
    <?php endif; ?>

    <!-- Maintenances -->
    <div class="eq-block-title"><i class="fas fa-tools mr-1 text-warning"></i>Maintenances (<?= count($maintenances) ?>)</div>
    <?php if ($maintenances): ?>
        <div class="table-responsive">
            <table class="table table-sm eq-table">
                <thead><tr><th>Date</th><th>Réf.</th><th>Intervention</th><th>Type</th><th class="text-right">Pièces</th><th class="text-right">M.O.</th><th class="text-right">Total</th><th>Statut</th></tr></thead>
                <tbody>
                    <?php foreach ($maintenances as $m): ?>
                        <tr>
                            <td><?= eq_date($m->end_date ?: ($m->start_date ?: $m->planned_date)) ?></td>
                            <td class="eq-ref"><?= eq_e($m->reference) ?></td>
                            <td><?= eq_e($m->intervention) ?><?= $m->supplier ? '<br><small class="text-muted">' . eq_e($m->supplier) . '</small>' : '' ?></td>
                            <td><?= eq_e($m->maintenance_type) ?></td>
                            <td class="text-right"><?= eq_num($m->parts_cost) ?></td>
                            <td class="text-right"><?= eq_num($m->labor_cost) ?></td>
                            <td class="text-right font-weight-bold"><?= eq_num($m->total_cost) ?></td>
                            <td><span class="eq-badge <?= eq_badge($m->maintenance_status) ?>"><?= eq_e($m->maintenance_status) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-muted small">Aucune maintenance sur la période.</p>
    <?php endif; ?>

    <!-- Pannes -->
    <?php if ($pannes): ?>
        <div class="eq-block-title"><i class="fas fa-car-crash mr-1 text-danger"></i>Pannes (<?= count($pannes) ?>)</div>
        <div class="table-responsive">
            <table class="table table-sm eq-table">
                <thead><tr><th>Date</th><th>Réf.</th><th>Gravité</th><th>Description</th><th>Statut</th><th>Résolue le</th></tr></thead>
                <tbody>
                    <?php foreach ($pannes as $p): ?>
                        <tr>
                            <td><?= eq_date($p->date_signalement, true) ?></td>
                            <td class="eq-ref"><?= eq_e($p->reference) ?></td>
                            <td><span class="eq-badge <?= eq_badge($p->gravite) ?>"><?= eq_e($p->gravite) ?></span></td>
                            <td><?= eq_e($p->description) ?></td>
                            <td><span class="eq-badge <?= eq_badge($p->panne_status) ?>"><?= eq_e($p->panne_status) ?></span></td>
                            <td><?= eq_date($p->date_resolution) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Affectations -->
        <div class="col-lg-6">
            <div class="eq-block-title"><i class="fas fa-exchange-alt mr-1 text-primary"></i>Dernières affectations</div>
            <?php if ($affectations): ?>
                <table class="table table-sm eq-table">
                    <thead><tr><th>Période</th><th>Lieu</th><th>Responsable</th></tr></thead>
                    <tbody>
                        <?php foreach ($affectations as $a): ?>
                            <tr>
                                <td><?= eq_date($a->date_debut) ?> → <?= $a->date_fin ? eq_date($a->date_fin) : '<span class="eq-badge eq-badge-info">en cours</span>' ?></td>
                                <td><?= eq_e($a->chantier_name ?: ($a->localisation ?: '-')) ?></td>
                                <td><?= eq_e($a->responsable ?: '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted small">Aucune affectation enregistrée.</p>
            <?php endif; ?>
        </div>

        <!-- Documents -->
        <div class="col-lg-6">
            <div class="eq-block-title"><i class="fas fa-folder-open mr-1 text-muted"></i>Documents</div>
            <?php if ($documents): ?>
                <table class="table table-sm eq-table">
                    <thead><tr><th>Type</th><th>N°</th><th>Expiration</th></tr></thead>
                    <tbody>
                        <?php foreach ($documents as $d):
                            $cls = !$d->date_expiration ? 'eq-badge-muted'
                                : ($d->date_expiration < $today ? 'eq-badge-danger' : ($d->date_expiration <= $soon ? 'eq-badge-warning' : 'eq-badge-success')); ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url('uploads/engins/documents/' . $d->document) ?>" target="_blank" rel="noopener">
                                        <i class="<?= eq_file_icon($d->document) ?> mr-1"></i><?= eq_e($d->type_document) ?>
                                    </a>
                                </td>
                                <td><?= eq_e($d->numero_document ?: '-') ?></td>
                                <td><span class="eq-badge <?= $cls ?>"><?= $d->date_expiration ? eq_date($d->date_expiration) : 'Sans échéance' ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted small">Aucun document.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($e->observation): ?>
        <div class="eq-block-title"><i class="fas fa-sticky-note mr-1 text-muted"></i>Observation</div>
        <p class="small mb-0"><?= nl2br(eq_e($e->observation)) ?></p>
    <?php endif; ?>
</div>
