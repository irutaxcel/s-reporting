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
</style>

<div class="content-wrapper">
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
                                        <span class="description-text">DA EN ATTENTE DE PAIEMENT</span>
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
                                    <button class="btn btn-sm btn-success mr-2"
                                        onclick="alert('Fonctionnalité à implémenter')"><i
                                            class="fas fa-file-excel mr-1"></i> Excel</button>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="alert('Fonctionnalité à implémenter')"><i
                                            class="fas fa-file-pdf mr-1"></i> PDF</button>
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
                                    <table class="table table-bordered table-hover mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 4%" class="text-center">N°</th>
                                                <th style="width: 10%">N° DA</th>
                                                <th style="width: 30%">Désignation</th>
                                                <th style="width: 15%">Demandé Par</th>
                                                <th style="width: 12%" class="text-right">Montant demandé</th>
                                                <th style="width: 12%" class="text-right">Montant Autorisé</th>
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
                                                $subtotal_autorise += $montant_autorise;
                                                $voucher = $this->dg->getVoucherByRequestId($demande->request_id);
                                                $voucher_id = $voucher ? $voucher->id : 0;
                                                $nom_demandeur = !empty($demande->demandeur_nom) ? $demande->demandeur_nom : ($demande->requested_by ?? $demande->buyer_name ?? '-');
                                            ?>
                                                <tr>
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
                                                        <?php if ($montant_autorise > 0): ?>
                                                            <span class="montant-autorise-display text-success"
                                                                onclick="window.activerSaisie(this, <?= $demande->request_id ?>, <?= $voucher_id ?>)"
                                                                style="cursor: pointer;"
                                                                title="Cliquez pour modifier"><?= number_format($montant_autorise, 0, ',', ' ') ?></span>
                                                        <?php else: ?>
                                                            <span class="montant-autorise-empty text-muted"
                                                                onclick="window.activerSaisie(this, <?= $demande->request_id ?>, <?= $voucher_id ?>)"
                                                                style="cursor: pointer;" title="Cliquez pour saisir"><i
                                                                    class="fas fa-edit mr-1"></i>Saisir</span>
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
                                                        <?php if ($demande->payment_status == 'effectue'): ?>
                                                            <span class="badge badge-success"><i
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
                                                    <?= number_format($subtotal_demande, 0, ',', ' ') ?> BIF</td>
                                                <td class="text-right bg-success text-white">
                                                    <?= number_format($subtotal_autorise, 0, ',', ' ') ?> BIF</td>
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
                                            class="badge badge-<?= $taux >= 80 ? 'success' : ($taux >= 50 ? 'warning' : 'danger') ?> badge-lg"><i
                                                class="fas fa-<?= $taux >= 80 ? 'check-double' : 'exclamation-circle' ?> mr-1"></i><?= $taux ?>%
                                            exécuté</span>
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
                                            <td class="text-left pl-4 bg-light"><i
                                                    class="fas fa-chart-pie text-danger mr-2"></i> <strong><span
                                                        id="nb-chantiers"><?= count($demandes_by_chantier) ?></span>
                                                    chantiers / <span id="nb-demandes"><?= count($demandes) ?></span>
                                                    demandes</strong></td>
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
                                            <td class="text-center bg-info text-white" style="font-size: 1.2rem;"><span
                                                    id="taux-global"><?= $statistics['taux_autorisation'] ?></span>%
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
                    var displaySpan = cell.querySelector('.montant-autorise-display');
                    var emptySpan = cell.querySelector('.montant-autorise-empty');
                    var inputDiv = document.getElementById('input-' + request_id);

                    if (displaySpan) {
                        displaySpan.textContent = data.montant_autorise;
                        displaySpan.style.display = 'inline';
                    } else if (emptySpan) {
                        var newSpan = document.createElement('span');
                        newSpan.className = 'montant-autorise-display text-success';
                        newSpan.style.cssText = 'cursor: pointer; padding: 5px 10px; border-radius: 3px;';
                        newSpan.onclick = function() {
                            window.activerSaisie(this, request_id, voucher_id);
                        };
                        newSpan.textContent = data.montant_autorise;
                        emptySpan.replaceWith(newSpan);
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
            var montantAut = <?= $demande->montant_autorise ?? 0 ?>;
            if (montantAut > 0) totalAutorise += montantAut;
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
</script>