<style>
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.montant-autorise-input {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.montant-autorise-empty {
    padding: 5px 10px;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.montant-autorise-empty:hover {
    background-color: #f8f9fa;
    color: #007bff !important;
}

.montant-autorise-display {
    padding: 5px 10px;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.montant-autorise-display:hover {
    background-color: #d4edda;
    text-decoration: underline;
}

.montant-input {
    text-align: right;
    font-weight: bold;
}

.montant-input:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

/* ✅ NOUVEAU : Style pour les lignes déjà effectuées (grisées) */
.row-effectuee {
    background-color: #f8f9fa !important;
    opacity: 0.65;
}

.row-effectuee td {
    color: #6c757d;
}

.row-effectuee .montant-autorise-display,
.row-effectuee .montant-autorise-empty {
    cursor: not-allowed !important;
    pointer-events: none;
    /* Empêche totalement le clic */
}

.row-effectuee .montant-autorise-display:hover {
    background-color: transparent !important;
    text-decoration: none;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-clipboard-list text-primary mr-2"></i> Synthèse des demandes
                        d'achat</h1>
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

    <section class="content">
        <div class="container-fluid">

            <!-- BANDEAU D'INFORMATIONS GÉNÉRALES -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 border-right">
                                    <div class="description-block">
                                        <span class="description-percentage text-muted"><i
                                                class="fas fa-calendar-alt"></i> Période</span>
                                        <h5 class="description-header text-primary"><?= $mois_annee ?></h5>
                                        <span class="description-text"><?= $periode_affichage ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 border-right">
                                    <div class="description-block">
                                        <span class="description-percentage text-muted"><i class="fas fa-hard-hat"></i>
                                            Chantiers actifs</span>
                                        <h5 class="description-header text-success"><?= count($demandes_by_chantier) ?>
                                        </h5>
                                        <span class="description-text">
                                            <?php
                                            $chantiers = array_keys($demandes_by_chantier);
                                            echo count($chantiers) > 3 ? implode(', ', array_slice($chantiers, 0, 3)) . ' & ...' : implode(' & ', $chantiers);
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 border-right">
                                    <div class="description-block">
                                        <span class="description-percentage text-muted"><i
                                                class="fas fa-file-invoice"></i> Nbr de demandes</span>
                                        <h5 class="description-header text-warning"><?= count($demandes) ?></h5>
                                        <span class="description-text">DA RÉPERTORIÉES</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="description-block">
                                        <span class="description-percentage text-muted"><i class="fas fa-filter"></i>
                                            Filtres actifs</span>
                                        <h5 class="description-header text-info"><i
                                                class="fas fa-check-circle text-success"></i> Oui</h5>
                                        <span
                                            class="description-text"><?= (!empty($filtre_chantier) && $filtre_chantier !== 'tous') ? '<strong>' . htmlspecialchars($filtre_chantier) . '</strong>' : 'Tous les chantiers' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <form method="get" action="<?= current_url() ?>" class="form-inline flex-wrap">
                                        <label class="mr-2 text-muted font-weight-bold"><i
                                                class="fas fa-filter mr-1"></i> Filtres :</label>
                                        <div class="form-group mr-2 mb-2">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fas fa-calendar-alt"></i></span></div>
                                                <input type="date" name="date_debut" class="form-control"
                                                    value="<?= $filtre_date_debut ?>" required>
                                            </div>
                                        </div>
                                        <span class="text-muted mx-1 mb-2">au</span>
                                        <div class="form-group mr-2 mb-2">
                                            <div class="input-group input-group-sm">
                                                <input type="date" name="date_fin" class="form-control"
                                                    value="<?= $filtre_date_fin ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group mr-2 mb-2">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fas fa-hard-hat"></i></span></div>
                                                <select name="chantier" class="form-control">
                                                    <option value="tous"
                                                        <?= ($filtre_chantier === 'tous' || empty($filtre_chantier)) ? 'selected' : '' ?>>
                                                        Tous les chantiers</option>
                                                    <?php foreach ($liste_chantiers as $chantier): ?>
                                                    <option value="<?= htmlspecialchars($chantier) ?>"
                                                        <?= ($filtre_chantier === $chantier) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($chantier) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary mr-2 mb-2"><i
                                                class="fas fa-search mr-1"></i> Filtrer</button>
                                        <a href="<?= current_url() ?>" class="btn btn-sm btn-secondary mb-2"><i
                                                class="fas fa-redo mr-1"></i> Réinitialiser</a>
                                    </form>
                                </div>
                                <div class="col-md-5 text-right">
                                    <a href="<?= base_url('direction/imprimer-synthese?date_debut=' . $filtre_date_debut . '&date_fin=' . $filtre_date_fin . '&chantier=' . ($filtre_chantier ?? 'tous')) ?>"
                                        target="_blank" class="btn btn-sm btn-default mr-2"><i
                                            class="fas fa-print mr-1"></i> Imprimer</a>
                                    <button type="button" id="btnExportExcel" class="btn btn-sm btn-success mr-2"
                                        onclick="exporterExcelSynthese()"><i class="fas fa-file-excel mr-1"></i>
                                        Excel</button>
                                    <!-- <button class="btn btn-sm btn-danger"
                                        onclick="alert('Fonctionnalité à implémenter')"><i
                                            class="fas fa-file-pdf mr-1"></i> PDF</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPI CARDS -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= number_format($statistics['total_demande'], 0, ',', ' ') ?></h3>
                            <p>Total Demandé (BIF)</p>
                        </div>
                        <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
                        <span class="small-box-footer">Montant sollicité <i
                                class="fas fa-arrow-circle-right"></i></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= number_format($statistics['total_autorise'], 0, ',', ' ') ?></h3>
                            <p>Total Autorisé (BIF)</p>
                        </div>
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                        <span class="small-box-footer">Montant approuvé <i class="fas fa-arrow-circle-right"></i></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= number_format($statistics['ecart'], 0, ',', ' ') ?></h3>
                            <p>Écart (BIF)</p>
                        </div>
                        <div class="icon"><i class="fas fa-balance-scale"></i></div>
                        <span class="small-box-footer">Différence demande/autorisation <i
                                class="fas fa-arrow-circle-right"></i></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?= $statistics['taux_autorisation'] ?><small style="font-size: 1.2rem">%</small></h3>
                            <p>Taux d'autorisation</p>
                        </div>
                        <div class="icon"><i class="fas fa-chart-line"></i></div>
                        <span class="small-box-footer">Ratio global <i class="fas fa-arrow-circle-right"></i></span>
                    </div>
                </div>
            </div>

            <!-- GRAPHIQUES -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Comparatif par chantier (BIF)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div style="position: relative; height: 300px;"><canvas id="chartChantiers"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Répartition des montants</h3>
                        </div>
                        <div class="card-body">
                            <div style="position: relative; height: 300px;"><canvas id="chartRepartition"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLEAUX PAR CHANTIER -->
            <?php
            $chantier_number = 1;
            $colors = ['primary', 'success', 'info', 'warning', 'danger'];
            $icons = ['hard-hat', 'school', 'building', 'hospital', 'warehouse'];
            ?>

            <?php foreach ($demandes_by_chantier as $chantier_name => $demandes): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-<?= $colors[($chantier_number - 1) % count($colors)] ?>">
                        <div class="card-header bg-<?= $colors[($chantier_number - 1) % count($colors)] ?>">
                            <h3 class="card-title text-white">
                                <i class="fas fa-<?= $icons[($chantier_number - 1) % count($icons)] ?> mr-2"></i>
                                <?= $chantier_number ?>. CHANTIER <?= strtoupper($chantier_name) ?>
                                <span class="badge badge-light ml-2"><?= count($demandes) ?> demande(s)</span>
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0 table-synthese-chantier"
                                    data-chantier="<?= htmlspecialchars($chantier_name, ENT_QUOTES) ?>">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 4%" class="text-center">N°</th>
                                            <th style="width: 10%">N° DA</th>
                                            <th style="width: 30%">Désignation</th>
                                            <th style="width: 15%">Demandé Par</th>
                                            <th style="width: 12%" class="text-right">Montant demandé</th>
                                            <th style="width: 12%" class="text-right">Montant Décaissé</th>
                                            <th style="width: 10%" class="text-center">Statut</th>
                                            <th style="width: 7%">Obs.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $item_number = 1;
                                            $subtotal_demande = 0;
                                            $subtotal_autorise = 0;

                                            foreach ($demandes as $demande):
                                                $items = $this->dg->getRequestItems($demande->request_id);
                                                $designations = [];
                                                $total_items = 0;

                                                foreach ($items as $item) {
                                                    $designation = $item->designation;
                                                    if ($item->technical_specs) $designation .= ' (' . $item->technical_specs . ')';
                                                    $designations[] = $designation;
                                                    $total_items += $item->total_price;
                                                }

                                                $subtotal_demande += $total_items;
                                                $montant_autorise = $demande->montant_autorise ?? 0;

                                                // Vérifier si la demande est déjà effectuée/payée
                                                $isEffectuee = ($demande->payment_status == 'effectue');

                                                // Le "Montant Autorisé" n'entre dans le sous-total que si la
                                                // demande est déjà effectuée (payée). Tant qu'elle est en
                                                // attente, le montant reste une autorisation sur le papier,
                                                // pas encore exécutée — donc pas encore comptabilisée.
                                                if ($isEffectuee) {
                                                    $subtotal_autorise += $montant_autorise;
                                                }

                                                $voucher = $this->dg->getVoucherByRequestId($demande->request_id);
                                                $voucher_id = $voucher ? $voucher->id : 0;
                                                $nom_demandeur = !empty($demande->demandeur_nom) ? $demande->demandeur_nom : ($demande->requested_by ?? $demande->buyer_name ?? '-');
                                            ?>
                                        <tr class="<?= $isEffectuee ? 'row-effectuee' : '' ?>">
                                            <td class="text-center"><strong><?= $item_number++ ?></strong></td>
                                            <td><span
                                                    class="badge badge-<?= $colors[($chantier_number - 1) % count($colors)] ?>">DA-2026-<?= str_pad($demande->request_id, 4, '0', STR_PAD_LEFT) ?></span>
                                            </td>
                                            <td><strong><?= implode(', ', $designations) ?></strong></td>
                                            <td><strong><?= $nom_demandeur ?></strong></td>
                                            <td class="text-right font-weight-bold">
                                                <?= number_format($total_items, 0, ',', ' ') ?></td>
                                            <td class="text-right font-weight-bold"
                                                style="position: relative; min-width: 150px;">
                                                <?php if ($isEffectuee): ?>
                                                <!-- Demande déjà effectuée : affichage seul avec cadenas -->
                                                <span class="montant-autorise-display text-secondary"
                                                    style="cursor: not-allowed;">
                                                    <?= number_format($montant_autorise, 0, ',', ' ') ?> <i
                                                        class="fas fa-lock ml-1" style="font-size: 0.8em;"></i>
                                                </span>
                                                <?php else: ?>
                                                <!-- Demande en attente : le montant autorisé n'est ni
                                                                 affiché ni compté tant que la demande n'est pas
                                                                 effectuée, mais reste modifiable (la saisie prépare
                                                                 le montant qui sera exécuté) -->
                                                <span class="montant-autorise-empty text-muted"
                                                    onclick="window.activerSaisie(this, <?= $demande->request_id ?>, <?= $voucher_id ?>)"
                                                    style="cursor: pointer;"
                                                    title="Cliquez pour saisir / modifier">-</span>
                                                <?php endif; ?>
                                                <div class="montant-autorise-input"
                                                    id="input-<?= $demande->request_id ?>" style="display: none;">
                                                    <div class="input-group input-group-sm">
                                                        <input type="number"
                                                            id="montant-input-<?= $demande->request_id ?>"
                                                            class="form-control montant-input" placeholder="0" min="0"
                                                            max="<?= $total_items ?>" value="<?= $montant_autorise ?>"
                                                            onkeypress="if(event.key==='Enter'){window.validerMontant(<?= $demande->request_id ?>, <?= $voucher_id ?>)}"
                                                            onkeyup="if(event.key==='Escape'){window.annulerMontant(<?= $demande->request_id ?>)}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success"
                                                                onclick="window.validerMontant(<?= $demande->request_id ?>, <?= $voucher_id ?>)"><i
                                                                    class="fas fa-check"></i></button>
                                                            <button class="btn btn-secondary"
                                                                onclick="window.annulerMontant(<?= $demande->request_id ?>)"><i
                                                                    class="fas fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($isEffectuee): ?>
                                                <span class="badge badge-secondary"><i
                                                        class="fas fa-check-circle mr-1"></i>Effectué</span>
                                                <?php else: ?>
                                                <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i>En
                                                    attente</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><span class="text-muted">-</span></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr class="font-weight-bold">
                                            <td colspan="4"
                                                class="text-right text-<?= $colors[($chantier_number - 1) % count($colors)] ?>">
                                                <i class="fas fa-calculator mr-1"></i> Sous-Total
                                                (<?= ucfirst($chantier_name) ?>)
                                            </td>
                                            <td
                                                class="text-right bg-<?= $colors[($chantier_number - 1) % count($colors)] ?> text-white">
                                                <?= number_format($subtotal_demande, 0, ',', ' ') ?> BIF
                                            </td>
                                            <td class="text-right bg-success text-white">
                                                <?= number_format($subtotal_autorise, 0, ',', ' ') ?> BIF
                                            </td>
                                            <td colspan="2" class="text-center">-</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <small class="text-muted"><i class="fas fa-chart-line mr-1"></i> Taux d'exécution
                                        :</small>
                                    <?php $taux = $subtotal_demande > 0 ? round(($subtotal_autorise / $subtotal_demande) * 100, 1) : 0; ?>
                                    <div class="progress progress-sm mt-1">
                                        <div class="progress-bar bg-<?= $taux >= 80 ? 'success' : ($taux >= 50 ? 'warning' : 'danger') ?>"
                                            style="width: <?= $taux ?>%"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <span
                                        class="badge badge-<?= $taux >= 80 ? 'success' : ($taux >= 50 ? 'warning' : 'danger') ?> badge-lg">
                                        <i
                                            class="fas fa-<?= $taux >= 80 ? 'check-double' : 'exclamation-circle' ?> mr-1"></i><?= $taux ?>%
                                        exécuté
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $chantier_number++;
            endforeach; ?>

            <!-- TOTAL GÉNÉRAL -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-danger border-danger shadow-sm">
                        <div class="card-header bg-danger">
                            <h3 class="card-title text-white"><i class="fas fa-calculator mr-2"></i> TOTAL GÉNÉRAL (TOUS
                                LES CHANTIERS)</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool btn-light" onclick="recalculerTotaux()"
                                    title="Rafraîchir"><i class="fas fa-sync-alt"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 40%" class="align-middle text-center bg-light"><i
                                                    class="fas fa-building mr-2 text-secondary"></i> Synthèse globale
                                            </th>
                                            <th class="text-center bg-primary text-white"><i
                                                    class="fas fa-hand-holding-usd mr-1"></i> Total Demandé</th>
                                            <th class="text-center bg-success text-white"><i
                                                    class="fas fa-check-double mr-1"></i> Total Autorisé</th>
                                            <th class="text-center bg-warning text-white"><i
                                                    class="fas fa-balance-scale mr-1"></i> Écart</th>
                                            <th class="text-center bg-info text-white"><i
                                                    class="fas fa-percentage mr-1"></i> Taux global</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="font-weight-bold" style="font-size: 1.1rem;">
                                            <td class="text-left pl-4 bg-light">
                                                <i class="fas fa-chart-pie text-danger mr-2"></i>
                                                <strong><span
                                                        id="nb-chantiers"><?= count($demandes_by_chantier) ?></span>
                                                    chantiers / <span id="nb-demandes"><?= count($demandes) ?></span>
                                                    demandes</strong>
                                            </td>
                                            <td class="text-right bg-primary text-white" style="font-size: 1.2rem;">
                                                <span
                                                    id="total-demande"><?= number_format($statistics['total_demande'], 0, ',', ' ') ?></span>
                                                BIF
                                            </td>
                                            <td class="text-right bg-success text-white" style="font-size: 1.2rem;">
                                                <span
                                                    id="total-autorise"><?= number_format($statistics['total_autorise'], 0, ',', ' ') ?></span>
                                                BIF
                                            </td>
                                            <td class="text-right bg-warning text-white" style="font-size: 1.2rem;">
                                                <span
                                                    id="ecart"><?= number_format($statistics['ecart'], 0, ',', ' ') ?></span>
                                                BIF
                                            </td>
                                            <td class="text-center bg-info text-white" style="font-size: 1.2rem;">
                                                <span id="taux-global"><?= $statistics['taux_autorisation'] ?></span>%
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- SCRIPTS JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/exceljs@4.4.0/dist/exceljs.min.js"></script>
<script>
// ==========================================
// 1. GESTION SAISIE MONTANT AUTORISÉ
// ==========================================
window.activerSaisie = function(element, request_id, voucher_id) {
    element.style.display = 'none';
    var inputDiv = document.getElementById('input-' + request_id);
    if (inputDiv) {
        inputDiv.style.display = 'block';
        var input = document.getElementById('montant-input-' + request_id);
        if (input) {
            input.focus();
            input.select();
        }
    }
};

window.annulerMontant = function(request_id) {
    var inputDiv = document.getElementById('input-' + request_id);
    if (inputDiv) {
        inputDiv.style.display = 'none';
        var spans = document.querySelectorAll('td span[onclick*="' + request_id + '"]');
        spans.forEach(function(span) {
            span.style.display = 'inline';
        });
    }
};

window.validerMontant = function(request_id, voucher_id) {
    var input = document.getElementById('montant-input-' + request_id);
    if (!input) return;
    var montant_autorise = parseFloat(input.value);
    if (isNaN(montant_autorise) || montant_autorise < 0) {
        alert('Montant invalide');
        return;
    }

    var btn = input.parentElement.querySelector('.btn-success');
    var btnOriginalHTML = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    }

    var bodyParams = 'request_id=' + request_id + '&montant_autorise=' + montant_autorise;
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    var csrfParam = document.querySelector('meta[name="csrf-param"]');
    if (csrfToken && csrfParam) {
        bodyParams = csrfParam.getAttribute('content') + '=' + csrfToken.getAttribute('content') + '&' + bodyParams;
    }

    fetch('<?= base_url("direction/update-montant-autorise") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: bodyParams
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var cell = input.closest('td');
                var inputDiv = document.getElementById('input-' + request_id);

                // Le montant autorisé n'est affiché/compté qu'une fois la demande effectuée :
                // tant qu'elle reste en attente, la case revient à "-" après l'enregistrement
                // (la valeur est bien sauvegardée, elle réapparaîtra une fois la demande marquée
                // "effectuée"). Le rechargement de page ci-dessous confirme cet état exact.
                var span = cell.querySelector('.montant-autorise-empty, .montant-autorise-display');
                if (span) {
                    span.className = 'montant-autorise-empty text-muted';
                    span.style.display = 'inline';
                    span.textContent = '-';
                }
                if (inputDiv) inputDiv.style.display = 'none';
                setTimeout(() => location.reload(), 1000);
            } else {
                alert('Erreur: ' + data.message);
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = btnOriginalHTML;
                }
            }
        })
        .catch(error => {
            console.error(error);
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = btnOriginalHTML;
            }
        });
};

// ==========================================
// 2. RECALCUL DYNAMIQUE DES TOTAUX
// ==========================================
function recalculerTotaux() {
    var totalDemande = <?= $statistics['total_demande'] ?>;
    var totalAutorise = 0;
    <?php foreach ($demandes as $demande): ?>
    <?php if ($demande->payment_status == 'effectue'): ?>
    var montantAut = <?= $demande->montant_autorise ?? 0 ?>;
    if (montantAut > 0) totalAutorise += montantAut;
    <?php endif; ?>
    <?php endforeach; ?>

    var ecart = totalDemande - totalAutorise;
    var tauxGlobal = totalDemande > 0 ? Math.round((totalAutorise / totalDemande) * 100 * 10) / 10 : 0;

    document.getElementById('total-demande').textContent = totalDemande.toLocaleString('fr-FR');
    document.getElementById('total-autorise').textContent = totalAutorise.toLocaleString('fr-FR');
    document.getElementById('ecart').textContent = ecart.toLocaleString('fr-FR');
    document.getElementById('taux-global').textContent = tauxGlobal;
}

// ==========================================
// 3. GRAPHIQUES CHART.JS
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    var chantiersData = <?= json_encode($chantiers_data) ?>;
    var labels = [],
        dataDemande = [],
        dataAutorise = [];

    chantiersData.forEach(function(item) {
        if (!labels.includes(item.destination_chantier)) {
            labels.push(item.destination_chantier);
            dataDemande[item.destination_chantier] = 0;
            dataAutorise[item.destination_chantier] = 0;
        }
        if (item.payment_status === 'en_attente') dataDemande[item.destination_chantier] += parseFloat(
            item.total);
        else dataAutorise[item.destination_chantier] += parseFloat(item.total);
    });

    if (document.getElementById('chartChantiers')) {
        new Chart(document.getElementById('chartChantiers'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Montant demandé',
                        backgroundColor: 'rgba(60,141,188,0.7)',
                        borderColor: '#3c8dbc',
                        borderWidth: 2,
                        data: labels.map(l => dataDemande[l] || 0)
                    },
                    {
                        label: 'Montant autorisé',
                        backgroundColor: 'rgba(0,166,90,0.7)',
                        borderColor: '#00a65a',
                        borderWidth: 2,
                        data: labels.map(l => dataAutorise[l] || 0)
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: v => (v / 1000000) + 'M'
                        }
                    }
                }
            }
        });
    }

    if (document.getElementById('chartRepartition')) {
        new Chart(document.getElementById('chartRepartition'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: labels.map(l => (dataDemande[l] || 0) + (dataAutorise[l] || 0)),
                    backgroundColor: ['#3c8dbc', '#00a65a', '#f39c12', '#dd4b39', '#9b59b6'],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '60%'
            }
        });
    }
});

// ==========================================
// 4. EXPORT EXCEL (avec logo et tableaux colorés par chantier)
// ==========================================
// On relit les valeurs directement dans les tableaux déjà affichés à l'écran
// (mêmes chiffres que ceux vus par l'utilisateur, calculés une seule fois côté PHP).
// Cela évite de dupliquer en JS la logique métier (items, sous-totaux, etc.)
// et les bugs de désynchronisation que ça entraîne.
function parseMontantCell(text) {
    if (!text) return 0;
    var cleaned = String(text).replace(/[^\d\-]/g, '');
    var num = parseInt(cleaned, 10);
    return isNaN(num) ? 0 : num;
}

// Certains libellés dans la vue sont écrits sur plusieurs lignes dans le HTML source
// (ex: le badge "En\n    attente"). Le navigateur les affiche avec un simple espace,
// mais textContent renvoie les sauts de ligne et l'indentation tels quels : sans ce
// nettoyage, Excel n'affiche que la première ligne du texte.
function nettoyerTexteCellule(text) {
    if (!text) return '';
    return String(text).replace(/\s+/g, ' ').trim();
}

// Couleurs identiques au cycle utilisé dans la vue ($colors = ['primary','success','info','warning','danger'])
var EXCEL_COULEURS = ['FF007BFF', 'FF28A745', 'FF17A2B8', 'FFFFC107', 'FFDC3545'];
var EXCEL_TEXTE_SUR_COULEUR = ['FFFFFFFF', 'FFFFFFFF', 'FFFFFFFF', 'FF3A3000', 'FFFFFFFF'];
var EXCEL_BORDURE = {
    top: {
        style: 'thin',
        color: {
            argb: 'FFD0D0D0'
        }
    },
    left: {
        style: 'thin',
        color: {
            argb: 'FFD0D0D0'
        }
    },
    bottom: {
        style: 'thin',
        color: {
            argb: 'FFD0D0D0'
        }
    },
    right: {
        style: 'thin',
        color: {
            argb: 'FFD0D0D0'
        }
    }
};

// Charge le logo de l'entreprise en base64 pour l'embarquer dans le fichier Excel.
// En cas d'échec (réseau, logo absent, etc.), l'export continue simplement sans logo.
function chargerLogoBase64(url) {
    return fetch(url)
        .then(function(response) {
            if (!response.ok) throw new Error('Logo introuvable (HTTP ' + response.status + ')');
            return response.blob();
        })
        .then(function(blob) {
            return new Promise(function(resolve, reject) {
                var reader = new FileReader();
                reader.onload = function() {
                    resolve(reader.result);
                };
                reader.onerror = reject;
                reader.readAsDataURL(blob);
            });
        })
        .catch(function(err) {
            console.warn('Logo non chargé pour l\'export Excel :', err);
            return null;
        });
}

// Ratio réel du logo (assets/v1/dist/img/logoUpdate.png = 2144x1552px) : on le respecte
// pour ne pas l'écraser dans un carré.
var LOGO_RATIO_LARGEUR_HAUTEUR = 2144 / 1552;

// Ajoute l'entête commun (logo + titre + période) en haut d'une feuille.
// colonneTitreDebut : première colonne où démarre le bloc titre — sur "Détail" on le décale
// en colonne C pour laisser tout l'espace des colonnes A+B (N°, N° DA) au logo, sans le
// resserrer ni le faire déborder sur le texte, comme sur la feuille "Synthèse" où la
// colonne A, plus large, offre déjà cette place naturellement.
function ajouterEnteteExcel(ws, logoBase64, moisAnnee, periode, filtreChantier, colonneTitreDebut, derniereColonne) {
    if (logoBase64) {
        var imgId = ws.workbook.addImage({
            base64: logoBase64,
            extension: 'png'
        });
        var logoHauteur = 48;
        var logoLargeur = Math.round(logoHauteur * LOGO_RATIO_LARGEUR_HAUTEUR);
        ws.addImage(imgId, {
            tl: {
                col: 0.15,
                row: 0.15
            },
            ext: {
                width: logoLargeur,
                height: logoHauteur
            }
        });
    }

    ws.getRow(1).height = 20;
    ws.getRow(2).height = 18;
    ws.getRow(3).height = 16;

    ws.mergeCells(1, colonneTitreDebut, 1, derniereColonne);
    ws.getCell(1, colonneTitreDebut).value = 'SATRACO CONSTRUCTION';
    ws.getCell(1, colonneTitreDebut).font = {
        bold: true,
        size: 15,
        color: {
            argb: 'FF1A1A1A'
        }
    };
    ws.getCell(1, colonneTitreDebut).alignment = {
        vertical: 'middle'
    };

    ws.mergeCells(2, colonneTitreDebut, 2, derniereColonne);
    ws.getCell(2, colonneTitreDebut).value = 'SYNTHÈSE DES DEMANDES D\'ACHAT';
    ws.getCell(2, colonneTitreDebut).font = {
        bold: true,
        size: 11,
        color: {
            argb: 'FF555555'
        }
    };
    ws.getCell(2, colonneTitreDebut).alignment = {
        vertical: 'middle'
    };

    ws.mergeCells(3, colonneTitreDebut, 3, derniereColonne);
    ws.getCell(3, colonneTitreDebut).value = 'Période : ' + moisAnnee + ' (' + periode + ')   —   Chantier(s) : ' +
        filtreChantier;
    ws.getCell(3, colonneTitreDebut).font = {
        italic: true,
        size: 9,
        color: {
            argb: 'FF777777'
        }
    };

    ws.addRow([]);
}

async function exporterExcelSynthese() {
    if (typeof ExcelJS === 'undefined') {
        alert('Erreur : la librairie d\'export Excel n\'a pas pu être chargée. Vérifiez votre connexion internet.');
        return;
    }

    var btn = document.getElementById('btnExportExcel');
    var btnOriginalHTML = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Export...';
    }

    try {
        var statistics = <?= json_encode($statistics) ?>;
        var periode = <?= json_encode($periode_affichage) ?>;
        var moisAnnee = <?= json_encode($mois_annee) ?>;
        var filtreChantier =
            <?= json_encode((!empty($filtre_chantier) && $filtre_chantier !== 'tous') ? $filtre_chantier : 'Tous les chantiers') ?>;
        var logoUrl = <?= json_encode(base_url('assets/v1/dist/img/logoUpdate.png')) ?>;

        var logoBase64 = await chargerLogoBase64(logoUrl);

        var workbook = new ExcelJS.Workbook();
        workbook.creator = 'SATRACO Construction ERP';
        workbook.created = new Date();

        // ---- Feuille 1 : Synthèse globale ----
        var wsSynthese = workbook.addWorksheet('Synthèse');
        wsSynthese.columns = [{
            width: 32
        }, {
            width: 20
        }];
        ajouterEnteteExcel(wsSynthese, logoBase64, moisAnnee, periode, filtreChantier, 2, 2);

        var kpiHeaderRow = wsSynthese.addRow(['Indicateur', 'Valeur']);
        kpiHeaderRow.eachCell(function(cell) {
            cell.font = {
                bold: true,
                color: {
                    argb: 'FFFFFFFF'
                }
            };
            cell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: 'FF343A40'
                }
            };
            cell.border = EXCEL_BORDURE;
        });

        [
            ['Nombre de demandes', statistics.nb_demandes],
            ['Nombre en attente', statistics.nb_en_attente],
            ['Nombre effectué', statistics.nb_effectue],
            ['Total demandé (BIF)', statistics.total_demande],
            ['Total autorisé (BIF)', statistics.total_autorise],
            ['Écart (BIF)', statistics.ecart],
            ['Taux d\'autorisation (%)', statistics.taux_autorisation]
        ].forEach(function(kpi) {
            var row = wsSynthese.addRow(kpi);
            row.getCell(1).font = {
                bold: true
            };
            row.eachCell(function(cell) {
                cell.border = EXCEL_BORDURE;
            });
        });

        // ---- Feuille 2 : Détail par chantier (tableaux colorés, identiques à l'écran) ----
        var wsDetail = workbook.addWorksheet('Détail', {
            pageSetup: {
                orientation: 'landscape',
                fitToPage: true,
                fitToWidth: 1
            }
        });
        wsDetail.columns = [{
                width: 6
            }, {
                width: 14
            }, {
                width: 45
            }, {
                width: 20
            },
            {
                width: 18
            }, {
                width: 18
            }, {
                width: 14
            }, {
                width: 10
            }
        ];
        ajouterEnteteExcel(wsDetail, logoBase64, moisAnnee, periode, filtreChantier, 3, 8);

        var colonnesEntete = ['N°', 'N° DA', 'Désignation', 'Demandé Par', 'Montant demandé (BIF)',
            'Montant Autorisé (BIF)', 'Statut', 'Obs.'
        ];

        document.querySelectorAll('table.table-synthese-chantier').forEach(function(table, chantierIndex) {
            var chantierName = table.getAttribute('data-chantier') || '-';
            var couleur = EXCEL_COULEURS[chantierIndex % EXCEL_COULEURS.length];
            var couleurTexte = EXCEL_TEXTE_SUR_COULEUR[chantierIndex % EXCEL_COULEURS.length];
            var rows = table.querySelectorAll('tbody tr');

            wsDetail.addRow([]);

            var titreRow = wsDetail.addRow([(chantierIndex + 1) + '. CHANTIER ' + chantierName
                .toUpperCase() +
                ' (' + rows.length + ' demande(s))'
            ]);
            wsDetail.mergeCells(titreRow.number, 1, titreRow.number, 8);
            titreRow.height = 22;
            titreRow.getCell(1).font = {
                bold: true,
                size: 12,
                color: {
                    argb: couleurTexte
                }
            };
            titreRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: couleur
                }
            };
            titreRow.getCell(1).alignment = {
                vertical: 'middle',
                horizontal: 'left',
                indent: 1
            };

            var headerRow = wsDetail.addRow(colonnesEntete);
            headerRow.eachCell(function(cell) {
                cell.font = {
                    bold: true,
                    color: {
                        argb: 'FF333333'
                    }
                };
                cell.fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: {
                        argb: 'FFF1F1F1'
                    }
                };
                cell.border = EXCEL_BORDURE;
                cell.alignment = {
                    vertical: 'middle'
                };
            });

            var ligne = 1;
            rows.forEach(function(row) {
                var cells = row.querySelectorAll('td');
                if (cells.length < 8) return;

                var numDA = nettoyerTexteCellule(cells[1].textContent);
                var designation = nettoyerTexteCellule(cells[2].textContent);
                var demandeur = nettoyerTexteCellule(cells[3].textContent);
                var montantDemande = parseMontantCell(cells[4].textContent);
                var montantAutorise = parseMontantCell(cells[5].textContent);
                var statut = nettoyerTexteCellule(cells[6].textContent);

                var dataRow = wsDetail.addRow([ligne++, numDA, designation, demandeur,
                    montantDemande,
                    montantAutorise, statut, '-'
                ]);
                dataRow.eachCell(function(cell, colNumber) {
                    cell.border = EXCEL_BORDURE;
                    if (colNumber === 5 || colNumber === 6) {
                        cell.numFmt = '#,##0';
                        cell.alignment = {
                            horizontal: 'right'
                        };
                    }
                    if (colNumber === 1 || colNumber === 7 || colNumber === 8) {
                        cell.alignment = {
                            horizontal: 'center'
                        };
                    }
                });
            });

            // Sous-total du chantier (lu dans le pied du tableau affiché à l'écran)
            var tfootCells = table.querySelectorAll('tfoot td');
            var sousTotalDemande = tfootCells.length >= 3 ? parseMontantCell(tfootCells[1].textContent) : 0;
            var sousTotalAutorise = tfootCells.length >= 3 ? parseMontantCell(tfootCells[2].textContent) :
                0;

            var sousTotalRow = wsDetail.addRow(['', '', '', 'SOUS-TOTAL', sousTotalDemande,
                sousTotalAutorise, '', ''
            ]);
            wsDetail.mergeCells(sousTotalRow.number, 1, sousTotalRow.number, 4);
            sousTotalRow.getCell(4).alignment = {
                horizontal: 'right'
            };
            sousTotalRow.eachCell(function(cell, colNumber) {
                cell.font = {
                    bold: true,
                    color: {
                        argb: couleurTexte
                    }
                };
                cell.fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: {
                        argb: couleur
                    }
                };
                cell.border = EXCEL_BORDURE;
                if (colNumber === 5 || colNumber === 6) {
                    cell.numFmt = '#,##0';
                    cell.alignment = {
                        horizontal: 'right'
                    };
                }
            });
        });

        // ---- Ligne TOTAL GÉNÉRAL ----
        wsDetail.addRow([]);
        var totalRow = wsDetail.addRow(['', '', '', 'TOTAL GÉNÉRAL', statistics.total_demande,
            statistics.total_autorise, statistics.taux_autorisation + ' %', ''
        ]);
        wsDetail.mergeCells(totalRow.number, 1, totalRow.number, 4);
        totalRow.height = 24;
        totalRow.getCell(4).alignment = {
            horizontal: 'right'
        };
        totalRow.getCell(7).alignment = {
            horizontal: 'center'
        };
        totalRow.eachCell(function(cell, colNumber) {
            cell.font = {
                bold: true,
                size: 12,
                color: {
                    argb: 'FFFFFFFF'
                }
            };
            cell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: 'FFDC3545'
                }
            };
            cell.border = EXCEL_BORDURE;
            if (colNumber === 5 || colNumber === 6) {
                cell.numFmt = '#,##0';
                cell.alignment = {
                    horizontal: 'right'
                };
            }
        });

        var nomFichier = 'Synthese_Demandes_' + periode.replace(/\//g, '-').replace(/\s/g, '') +
            '.xlsx';
        var buffer = await workbook.xlsx.writeBuffer();
        var blob = new Blob([buffer], {
            type: 'application/octet-stream'
        });
        var url = window.URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = nomFichier;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    } catch (error) {
        console.error('Erreur export Excel:', error);
        alert('Une erreur est survenue lors de l\'export Excel.');
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = btnOriginalHTML;
        }
    }
}
</script>