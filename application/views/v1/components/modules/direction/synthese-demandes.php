<style>
/* Animation pour les notifications */
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

/* Style pour le champ de saisie inline */
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

/* Style pour le placeholder cliquable */
.montant-autorise-empty {
    padding: 5px 10px;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.montant-autorise-empty:hover {
    background-color: #f8f9fa;
    color: #007bff !important;
}

/* Style pour le montant affiché */
.montant-autorise-display {
    padding: 5px 10px;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.montant-autorise-display:hover {
    background-color: #d4edda;
    text-decoration: underline;
}

/* Style pour l'input */
.montant-input {
    text-align: right;
    font-weight: bold;
}

.montant-input:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-clipboard-list text-primary mr-2"></i>
                        Synthèse des demandes d'achat
                    </h1>
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

            <!-- ============================================== -->
            <!-- BANDEAU D'INFORMATIONS GÉNÉRALES               -->
            <!-- ============================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 border-right">
                                    <div class="description-block">
                                        <span class="description-percentage text-muted">
                                            <i class="fas fa-calendar-alt"></i> Période
                                        </span>
                                        <h5 class="description-header text-primary"><?= $mois_annee ?></h5>
                                        <span class="description-text"><?= $periode_affichage ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 border-right">
                                    <div class="description-block">
                                        <span class="description-percentage text-muted">
                                            <i class="fas fa-hard-hat"></i> Chantiers actifs
                                        </span>
                                        <h5 class="description-header text-success"><?= count($demandes_by_chantier) ?>
                                        </h5>
                                        <span class="description-text">
                                            <?php
                                            $chantiers = array_keys($demandes_by_chantier);
                                            if (count($chantiers) > 3) {
                                                echo implode(', ', array_slice($chantiers, 0, 3)) . ' & ...';
                                            } else {
                                                echo implode(' & ', $chantiers);
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 border-right">
                                    <div class="description-block">
                                        <span class="description-percentage text-muted">
                                            <i class="fas fa-file-invoice"></i> Nbr de demandes
                                        </span>
                                        <h5 class="description-header text-warning"><?= count($demandes) ?></h5>
                                        <span class="description-text">DA RÉPERTORIÉES</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="description-block">
                                        <span class="description-percentage text-muted">
                                            <i class="fas fa-filter"></i> Filtres actifs
                                        </span>
                                        <h5 class="description-header text-info">
                                            <i class="fas fa-check-circle text-success"></i> Oui
                                        </h5>
                                        <span class="description-text">
                                            <?php if (!empty($filtre_chantier) && $filtre_chantier !== 'tous'): ?>
                                            <strong><?= htmlspecialchars($filtre_chantier) ?></strong>
                                            <?php else: ?>
                                            Tous les chantiers
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dans le card-footer -->
                        <div class="card-footer bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <!-- FILTRES PAR DATE ET CHANTIER -->
                                    <form method="get" action="<?= current_url() ?>" class="form-inline flex-wrap">
                                        <label class="mr-2 text-muted font-weight-bold">
                                            <i class="fas fa-filter mr-1"></i> Filtres :
                                        </label>

                                        <!-- Filtre par période -->
                                        <div class="form-group mr-2 mb-2">
                                            <label class="sr-only">Date début</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="date" name="date_debut" id="date_debut"
                                                    class="form-control" value="<?= $filtre_date_debut ?>" required
                                                    title="Date de début">
                                            </div>
                                        </div>

                                        <span class="text-muted mx-1 mb-2">au</span>

                                        <div class="form-group mr-2 mb-2">
                                            <label class="sr-only">Date fin</label>
                                            <div class="input-group input-group-sm">
                                                <input type="date" name="date_fin" id="date_fin" class="form-control"
                                                    value="<?= $filtre_date_fin ?>" required title="Date de fin">
                                            </div>
                                        </div>

                                        <!-- Filtre par chantier -->
                                        <div class="form-group mr-2 mb-2">
                                            <label class="sr-only">Chantier</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-hard-hat"></i>
                                                    </span>
                                                </div>
                                                <select name="chantier" id="chantier" class="form-control"
                                                    title="Filtrer par chantier">
                                                    <option value="tous"
                                                        <?= ($filtre_chantier === 'tous' || empty($filtre_chantier)) ? 'selected' : '' ?>>
                                                        Tous les chantiers
                                                    </option>
                                                    <?php foreach ($liste_chantiers as $chantier): ?>
                                                    <option value="<?= htmlspecialchars($chantier) ?>"
                                                        <?= ($filtre_chantier === $chantier) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($chantier) ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Boutons d'action -->
                                        <button type="submit" class="btn btn-sm btn-primary mr-2 mb-2">
                                            <i class="fas fa-search mr-1"></i> Filtrer
                                        </button>
                                        <a href="<?= current_url() ?>" class="btn btn-sm btn-secondary mb-2">
                                            <i class="fas fa-redo mr-1"></i> Réinitialiser
                                        </a>
                                    </form>
                                </div>
                                <div class="col-md-5 text-right">
                                    <!-- BOUTON IMPRIMER AVEC FILTRES -->
                                    <a href="<?= base_url('direction/imprimer-synthese?date_debut=' . $filtre_date_debut . '&date_fin=' . $filtre_date_fin . '&chantier=' . ($filtre_chantier ?? 'tous')) ?>"
                                        target="_blank" class="btn btn-sm btn-default mr-2">
                                        <i class="fas fa-print mr-1"></i> Imprimer
                                    </a>
                                    <button class="btn btn-sm btn-success mr-2" onclick="exportExcel()">
                                        <i class="fas fa-file-excel mr-1"></i> Exporter Excel
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="exportPDF()">
                                        <i class="fas fa-file-pdf mr-1"></i> Exporter PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- KPI CARDS - RÉSUMÉ GLOBAL                      -->
            <!-- ============================================== -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= number_format($statistics['total_demande'], 0, ',', ' ') ?></h3>
                            <p>Total Demandé (BIF)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
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
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span class="small-box-footer">Montant approuvé <i class="fas fa-arrow-circle-right"></i></span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= number_format($statistics['ecart'], 0, ',', ' ') ?></h3>
                            <p>Écart (BIF)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
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
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span class="small-box-footer">Ratio global <i class="fas fa-arrow-circle-right"></i></span>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- GRAPHIQUES                                     -->
            <!-- ============================================== -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Comparatif par chantier (BIF)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div style="position: relative; height: 300px;">
                                <canvas id="chartChantiers"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Répartition des montants autorisés
                            </h3>
                        </div>
                        <div class="card-body">
                            <div style="position: relative; height: 300px;">
                                <canvas id="chartRepartition"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- TABLEAUX PAR CHANTIER                          -->
            <!-- ============================================== -->
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
                            <div class="card-tools">
                                <span class="badge badge-light">
                                    <i class="fas fa-map-marker-alt mr-1"></i> Bujumbura
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 5%" class="text-center">N°</th>
                                            <th style="width: 12%">N° DA</th>
                                            <th style="width: 35%">Désignation</th>
                                            <th style="width: 15%" class="text-right">Montant demandé (BIF)</th>
                                            <th style="width: 15%" class="text-right">Montant Autorisé (BIF)</th>
                                            <th style="width: 10%" class="text-center">Statut</th>
                                            <th style="width: 8%">Observation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $item_number = 1;
                                            $subtotal_demande = 0;
                                            $subtotal_autorise = 0;

                                            foreach ($demandes as $demande):
                                                // Récupérer les items de cette demande
                                                $items = $this->dg->getRequestItems($demande->request_id);
                                                $designations = [];
                                                $total_items = 0;

                                                foreach ($items as $item) {
                                                    $designation = $item->designation;
                                                    if ($item->technical_specs) {
                                                        $designation .= ' (' . $item->technical_specs . ')';
                                                    }
                                                    $designations[] = $designation;
                                                    $total_items += $item->total_price;
                                                }

                                                $subtotal_demande += $total_items;
                                                $montant_autorise = $demande->montant_autorise ?? 0;
                                                $subtotal_autorise += $montant_autorise;

                                                // Récupérer le voucher_id pour cette demande
                                                $voucher = $this->dg->getVoucherByRequestId($demande->request_id);
                                                $voucher_id = $voucher ? $voucher->id : 0;
                                            ?>
                                        <tr>
                                            <td class="text-center"><strong><?= $item_number++ ?></strong></td>
                                            <td>
                                                <span
                                                    class="badge badge-<?= $colors[($chantier_number - 1) % count($colors)] ?>">
                                                    DA-2026-<?= str_pad($demande->request_id, 4, '0', STR_PAD_LEFT) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?= implode(', ', $designations) ?></strong>
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                <?= number_format($total_items, 0, ',', ' ') ?>
                                            </td>
                                            <td class="text-right font-weight-bold"
                                                style="position: relative; min-width: 180px;">
                                                <?php if ($montant_autorise > 0): ?>
                                                <span class="montant-autorise-display text-success"
                                                    onclick="activerSaisie(this, <?= $demande->request_id ?>, <?= $voucher_id ?>)"
                                                    style="cursor: pointer; padding: 5px 10px; border-radius: 3px;"
                                                    title="Cliquez pour modifier">
                                                    <?= number_format($montant_autorise, 0, ',', ' ') ?>
                                                </span>
                                                <?php else: ?>
                                                <span class="montant-autorise-empty text-muted"
                                                    onclick="activerSaisie(this, <?= $demande->request_id ?>, <?= $voucher_id ?>)"
                                                    style="cursor: pointer; padding: 5px 10px; border-radius: 3px;"
                                                    title="Cliquez pour saisir le montant autorisé">
                                                    <i class="fas fa-edit mr-1"></i>Cliquer pour saisir
                                                </span>
                                                <?php endif; ?>

                                                <!-- Champ de saisie inline (caché par défaut) -->
                                                <div class="montant-autorise-input"
                                                    id="input-<?= $demande->request_id ?>" style="display: none;">
                                                    <div class="input-group input-group-sm">
                                                        <input type="number"
                                                            id="montant-input-<?= $demande->request_id ?>"
                                                            class="form-control" placeholder="0" min="0"
                                                            max="<?= $total_items ?>" value="<?= $montant_autorise ?>"
                                                            onkeypress="if(event.key==='Enter'){validerMontant(<?= $demande->request_id ?>, <?= $voucher_id ?>)}"
                                                            onkeyup="if(event.key==='Escape'){annulerMontant(<?= $demande->request_id ?>)}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success"
                                                                onclick="validerMontant(<?= $demande->request_id ?>, <?= $voucher_id ?>)"
                                                                title="Valider">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button class="btn btn-secondary"
                                                                onclick="annulerMontant(<?= $demande->request_id ?>)"
                                                                title="Annuler">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted d-block mt-1">Max:
                                                        <?= number_format($total_items, 0, ',', ' ') ?> BIF</small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($demande->payment_status == 'effectue'): ?>
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle mr-1"></i>Effectué
                                                </span>
                                                <?php else: ?>
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-clock mr-1"></i>En attente
                                                </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="text-muted">-</span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr class="font-weight-bold">
                                            <td colspan="3"
                                                class="text-right text-<?= $colors[($chantier_number - 1) % count($colors)] ?>">
                                                <i class="fas fa-calculator mr-1"></i>
                                                Sous-Total (<?= ucfirst($chantier_name) ?>)
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
                                    <small class="text-muted">
                                        <i class="fas fa-chart-line mr-1"></i>
                                        Taux d'exécution du chantier :
                                    </small>
                                    <?php
                                        $taux = $subtotal_demande > 0 ? round(($subtotal_autorise / $subtotal_demande) * 100, 1) : 0;
                                        ?>
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



            <script>
            // ============================================
            // RENDRE LES FONCTIONS GLOBALES (window)
            // ============================================

            window.activerSaisie = function(element, request_id, voucher_id) {
                console.log('✅ Clic détecté ! request_id:', request_id, 'voucher_id:', voucher_id);

                // Cacher le span cliqué
                element.style.display = 'none';

                // Afficher le champ de saisie
                var inputDiv = document.getElementById('input-' + request_id);
                if (inputDiv) {
                    inputDiv.style.display = 'block';

                    // Focus sur l'input
                    var input = document.getElementById('montant-input-' + request_id);
                    if (input) {
                        input.focus();
                        input.select();
                    }
                } else {
                    console.error('❌ Input div non trouvé pour request_id:', request_id);
                }
            };

            window.annulerMontant = function(request_id) {
                console.log('🔄 Annulation pour request_id:', request_id);

                // Cacher l'input
                var inputDiv = document.getElementById('input-' + request_id);
                if (inputDiv) {
                    inputDiv.style.display = 'none';
                }

                // Réafficher tous les spans associés
                var spans = document.querySelectorAll('td span[onclick*="' + request_id + '"]');
                spans.forEach(function(span) {
                    span.style.display = 'inline';
                });
            };

            window.validerMontant = function(request_id, voucher_id) {
                console.log(' Validation pour request_id:', request_id, 'voucher_id:', voucher_id);

                var input = document.getElementById('montant-input-' + request_id);
                if (!input) {
                    alert(' Champ de saisie non trouvé');
                    return;
                }

                var montant_autorise = parseFloat(input.value);

                // Validation
                if (isNaN(montant_autorise) || montant_autorise < 0) {
                    alert('️ Veuillez entrer un montant valide (>= 0)');
                    return;
                }

                // Désactiver le bouton pendant la sauvegarde
                var btn = input.parentElement.querySelector('.btn-success');
                var btnOriginalHTML = btn ? btn.innerHTML : '';
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                }

                // Récupérer le token CSRF si activé
                var csrfToken = document.querySelector('meta[name="csrf-token"]');
                var csrfParam = document.querySelector('meta[name="csrf-param"]');

                var bodyParams = 'request_id=' + request_id + '&montant_autorise=' + montant_autorise;

                if (csrfToken && csrfParam) {
                    bodyParams = csrfParam.getAttribute('content') + '=' + csrfToken.getAttribute('content') + '&' +
                        bodyParams;
                }

                // Requête AJAX avec fetch
                fetch('<?= base_url("direction/update-montant-autorise") ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: bodyParams
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        console.log('📦 Réponse serveur:', data);

                        if (data.success) {
                            // Mettre à jour l'affichage
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
                                newSpan.style.cssText =
                                    'cursor: pointer; padding: 5px 10px; border-radius: 3px;';
                                newSpan.title = 'Cliquez pour modifier';
                                newSpan.onclick = function() {
                                    window.activerSaisie(this, request_id, voucher_id);
                                };
                                newSpan.textContent = data.montant_autorise;
                                emptySpan.replaceWith(newSpan);
                            }

                            // Cacher l'input
                            if (inputDiv) {
                                inputDiv.style.display = 'none';
                            }

                            // Notification de succès
                            window.showNotification('✅ Succès', data.message, 'success');

                            // Recharger après 1.5 secondes
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            alert('❌ Erreur: ' + data.message);
                            if (btn) {
                                btn.disabled = false;
                                btn.innerHTML = btnOriginalHTML;
                            }
                        }
                    })
                    .catch(function(error) {
                        console.error('❌ Erreur fetch:', error);
                        alert(' Erreur de communication avec le serveur. Vérifiez la console (F12).');
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = btnOriginalHTML;
                        }
                    });
            };

            window.showNotification = function(title, message, type) {
                var toast = document.createElement('div');
                toast.style.cssText =
                    'position: fixed; top: 20px; right: 20px; padding: 15px 20px; border-radius: 5px; color: white; z-index: 99999; box-shadow: 0 4px 6px rgba(0,0,0,0.1); animation: slideIn 0.3s ease-out; font-family: Arial, sans-serif;';

                if (type === 'success') {
                    toast.style.backgroundColor = '#28a745';
                } else if (type === 'error') {
                    toast.style.backgroundColor = '#dc3545';
                } else {
                    toast.style.backgroundColor = '#17a2b8';
                }

                toast.innerHTML = '<strong>' + title + '</strong><br>' + message;
                document.body.appendChild(toast);

                setTimeout(function() {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.3s';
                    setTimeout(function() {
                        toast.remove();
                    }, 300);
                }, 3000);
            };

            // Animation CSS
            if (!document.getElementById('toast-style-inline')) {
                var style = document.createElement('style');
                style.id = 'toast-style-inline';
                style.textContent = `
                    @keyframes slideIn {
                        from { transform: translateX(100%); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                    .montant-autorise-empty:hover {
                        background-color: #f8f9fa;
                        color: #007bff !important;
                    }
                    .montant-autorise-display:hover {
                        background-color: #d4edda;
                        text-decoration: underline;
                    }
                `;
                document.head.appendChild(style);
            }

            // Test au chargement
            document.addEventListener('DOMContentLoaded', function() {
                console.log('✅ Page chargée - Fonctions globales prêtes');
                console.log('🔍 activerSaisie défini ?', typeof window.activerSaisie);
                console.log('🔍 validerMontant défini ?', typeof window.validerMontant);
                console.log('🔍 annulerMontant défini ?', typeof window.annulerMontant);
                console.log('📊 Nombre de spans cliquables:', document.querySelectorAll(
                    '[onclick*="activerSaisie"]').length);
            });
            </script>



            <!-- ============================================== -->
            <!-- TOTAL GÉNÉRAL                                  -->
            <!-- ============================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-danger border-danger shadow-sm">
                        <div class="card-header bg-danger">
                            <h3 class="card-title text-white">
                                <i class="fas fa-calculator mr-2"></i>
                                TOTAL GÉNÉRAL (TOUS LES CHANTIERS)
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool btn-light" onclick="recalculerTotaux()"
                                    title="Rafraîchir les totaux">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 40%" class="align-middle text-center bg-light">
                                                <i class="fas fa-building mr-2 text-secondary"></i>
                                                Synthèse globale
                                            </th>
                                            <th class="text-center bg-primary text-white">
                                                <i class="fas fa-hand-holding-usd mr-1"></i>
                                                Total Demandé (BIF)
                                            </th>
                                            <th class="text-center bg-success text-white">
                                                <i class="fas fa-check-double mr-1"></i>
                                                Total Autorisé (BIF)
                                            </th>
                                            <th class="text-center bg-warning text-white">
                                                <i class="fas fa-balance-scale mr-1"></i>
                                                Écart (BIF)
                                            </th>
                                            <th class="text-center bg-info text-white">
                                                <i class="fas fa-percentage mr-1"></i>
                                                Taux global
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="font-weight-bold" style="font-size: 1.1rem;">
                                            <td class="text-left pl-4 bg-light">
                                                <i class="fas fa-chart-pie text-danger mr-2"></i>
                                                <strong>
                                                    <span id="nb-chantiers"><?= count($demandes_by_chantier) ?></span>
                                                    chantiers /
                                                    <span id="nb-demandes"><?= count($demandes) ?></span> demandes
                                                </strong>
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
                                                <span id="badge-autorise" class="badge badge-light ml-2"
                                                    style="display: none;">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                            </td>
                                            <td class="text-right bg-warning text-white" style="font-size: 1.2rem;">
                                                <span
                                                    id="ecart"><?= number_format($statistics['ecart'], 0, ',', ' ') ?></span>
                                                BIF
                                            </td>
                                            <td class="text-center bg-info text-white" style="font-size: 1.2rem;">
                                                <span id="taux-global"><?= $statistics['taux_autorisation'] ?></span>%
                                                <br>
                                                <small id="taux-indicateur" class="text-white">
                                                    <?php if ($statistics['taux_autorisation'] == 0): ?>
                                                    <i class="fas fa-exclamation-triangle"></i> En attente
                                                    <?php elseif ($statistics['taux_autorisation'] < 50): ?>
                                                    <i class="fas fa-arrow-down"></i> Faible
                                                    <?php elseif ($statistics['taux_autorisation'] < 100): ?>
                                                    <i class="fas fa-arrow-right"></i> En cours
                                                    <?php else: ?>
                                                    <i class="fas fa-check-circle"></i> Complet
                                                    <?php endif; ?>
                                                </small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Barre de progression globale -->
                            <div class="card-footer bg-light">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <small class="text-muted">
                                            <i class="fas fa-chart-line mr-1"></i>
                                            Progression globale des autorisations :
                                        </small>
                                        <div class="progress progress-sm mt-1">
                                            <div id="progress-global"
                                                class="progress-bar bg-<?= $statistics['taux_autorisation'] >= 80 ? 'success' : ($statistics['taux_autorisation'] >= 50 ? 'warning' : 'danger') ?>"
                                                style="width: <?= $statistics['taux_autorisation'] ?>%">
                                                <span class="sr-only"><?= $statistics['taux_autorisation'] ?>%
                                                    Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <?php
                                        $nb_autorises = 0;
                                        $nb_en_attente = 0;
                                        foreach ($demandes as $demande) {
                                            if ($demande->montant_autorise > 0) {
                                                $nb_autorises++;
                                            } else {
                                                $nb_en_attente++;
                                            }
                                        }
                                        ?>
                                        <span class="badge badge-success badge-lg mr-2">
                                            <i class="fas fa-check mr-1"></i><?= $nb_autorises ?> autorisées
                                        </span>
                                        <span class="badge badge-warning badge-lg">
                                            <i class="fas fa-clock mr-1"></i><?= $nb_en_attente ?> en attente
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Script pour recalculer les totaux dynamiquement -->
            <script>
            /**
             * Recalculer les totaux en fonction des montants autorisés saisis
             */
            function recalculerTotaux() {
                console.log('🔄 Recalcul des totaux...');

                var totalDemande = <?= $statistics['total_demande'] ?>;
                var totalAutorise = 0;
                var nbAutorises = 0;
                var nbEnAttente = 0;

                // Parcourir toutes les demandes pour calculer les totaux
                <?php foreach ($demandes as $demande): ?>
                var montantAut = <?= $demande->montant_autorise ?? 0 ?>;
                if (montantAut > 0) {
                    totalAutorise += montantAut;
                    nbAutorises++;
                } else {
                    nbEnAttente++;
                }
                <?php endforeach; ?>

                var ecart = totalDemande - totalAutorise;
                var tauxGlobal = totalDemande > 0 ? Math.round((totalAutorise / totalDemande) * 100 * 10) / 10 : 0;

                // Mettre à jour l'affichage avec animation
                animateValue('total-demande', totalDemande);
                animateValue('total-autorise', totalAutorise);
                animateValue('ecart', ecart);
                animateValue('taux-global', tauxGlobal);

                // Mettre à jour les compteurs
                document.getElementById('nb-chantiers').textContent = '<?= count($demandes_by_chantier) ?>';
                document.getElementById('nb-demandes').textContent = '<?= count($demandes) ?>';

                // Mettre à jour la barre de progression
                var progressBar = document.getElementById('progress-global');
                progressBar.style.width = tauxGlobal + '%';
                progressBar.className = 'progress-bar bg-' + (tauxGlobal >= 80 ? 'success' : (tauxGlobal >= 50 ?
                    'warning' : 'danger'));

                // Mettre à jour l'indicateur de taux
                var indicateurEl = document.getElementById('taux-indicateur');
                if (tauxGlobal == 0) {
                    indicateurEl.innerHTML = '<i class="fas fa-exclamation-triangle"></i> En attente';
                } else if (tauxGlobal < 50) {
                    indicateurEl.innerHTML = '<i class="fas fa-arrow-down"></i> Faible';
                } else if (tauxGlobal < 100) {
                    indicateurEl.innerHTML = '<i class="fas fa-arrow-right"></i> En cours';
                } else {
                    indicateurEl.innerHTML = '<i class="fas fa-check-circle"></i> Complet';
                }

                // Afficher notification
                showNotification('Totaux mis à jour',
                    'Total autorisé: ' + totalAutorise.toLocaleString('fr-FR') + ' BIF (' + tauxGlobal + '%)',
                    'success');

                console.log('✅ Totaux recalculés:', {
                    demande: totalDemande,
                    autorise: totalAutorise,
                    ecart: ecart,
                    taux: tauxGlobal + '%'
                });
            }

            /**
             * Animation de changement de valeur
             */
            function animateValue(elementId, newValue) {
                var element = document.getElementById(elementId);
                var oldValue = parseFloat(element.textContent.replace(/\s/g, '')) || 0;
                var duration = 500; // ms
                var startTime = null;

                function updateValue(timestamp) {
                    if (!startTime) startTime = timestamp;
                    var progress = Math.min((timestamp - startTime) / duration, 1);

                    // Ease-out function
                    var easeProgress = 1 - Math.pow(1 - progress, 3);

                    var currentValue = Math.round(oldValue + (newValue - oldValue) * easeProgress);
                    element.textContent = currentValue.toLocaleString('fr-FR');

                    if (progress < 1) {
                        requestAnimationFrame(updateValue);
                    }
                }

                requestAnimationFrame(updateValue);
            }

            /**
             * Afficher une notification
             */
            function showNotification(title, message, type) {
                var toast = document.createElement('div');
                toast.style.cssText =
                    'position: fixed; top: 20px; right: 20px; padding: 15px 20px; border-radius: 5px; color: white; z-index: 99999; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-family: Arial, sans-serif; animation: slideIn 0.3s ease-out;';
                toast.style.backgroundColor = type === 'success' ? '#28a745' : (type === 'error' ? '#dc3545' :
                    '#17a2b8');
                toast.innerHTML = '<strong>' + title + '</strong><br><small>' + message + '</small>';
                document.body.appendChild(toast);
                setTimeout(function() {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.3s';
                    setTimeout(function() {
                        toast.remove();
                    }, 300);
                }, 3000);
            }

            // Animation CSS
            if (!document.getElementById('toast-animation-style')) {
                var style = document.createElement('style');
                style.id = 'toast-animation-style';
                style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
                document.head.appendChild(style);
            }

            // Auto-recalcul au chargement de la page
            document.addEventListener('DOMContentLoaded', function() {
                console.log('📊 Module Total Général initialisé');
                // Optionnel: recalculer automatiquement au chargement
                // recalculerTotaux();
            });
            </script>

        </div>
    </section>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var chantiersData = <?= json_encode($chantiers_data) ?>;

    var labels = [];
    var dataDemande = [];
    var dataAutorise = [];

    chantiersData.forEach(function(item) {
        if (!labels.includes(item.destination_chantier)) {
            labels.push(item.destination_chantier);
            dataDemande[item.destination_chantier] = 0;
            dataAutorise[item.destination_chantier] = 0;
        }
        if (item.payment_status === 'en_attente') {
            dataDemande[item.destination_chantier] += parseFloat(item.total);
        } else {
            dataAutorise[item.destination_chantier] += parseFloat(item.total);
        }
    });

    var ctxChantiers = document.getElementById('chartChantiers');
    if (ctxChantiers) {
        new Chart(ctxChantiers, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Montant demandé (BIF)',
                        backgroundColor: 'rgba(60,141,188,0.7)',
                        borderColor: '#3c8dbc',
                        borderWidth: 2,
                        data: labels.map(function(l) {
                            return dataDemande[l] || 0;
                        })
                    },
                    {
                        label: 'Montant autorisé (BIF)',
                        backgroundColor: 'rgba(0,166,90,0.7)',
                        borderColor: '#00a65a',
                        borderWidth: 2,
                        data: labels.map(function(l) {
                            return dataAutorise[l] || 0;
                        })
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y
                                    .toLocaleString('fr-FR') + ' BIF';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return (value / 1000000) + 'M BIF';
                            }
                        }
                    }
                }
            }
        });
    }

    var ctxRepartition = document.getElementById('chartRepartition');
    if (ctxRepartition) {
        new Chart(ctxRepartition, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: labels.map(function(l) {
                        return (dataDemande[l] || 0) + (dataAutorise[l] || 0);
                    }),
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