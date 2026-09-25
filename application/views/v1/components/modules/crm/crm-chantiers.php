<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-hard-hat text-warning"></i> Chantiers & Avancement
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">CRM & Clients</a></li>
                        <li class="breadcrumb-item active">Chantiers & Avancement</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1">
                            <i class="fas fa-hard-hat"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Chantiers</span>
                            <span class="info-box-number"><?= $stats['total'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-sync fa-spin"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">En Cours</span>
                            <span class="info-box-number"><?= $stats['en_cours'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1">
                            <i class="fas fa-clock"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Non Démarrés</span>
                            <span class="info-box-number"><?= $stats['non_demarres'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Terminés</span>
                            <span class="info-box-number"><?= $stats['termines'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Main Chantiers Card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Liste des Chantiers Affectés
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                            data-target="#modalGlobalProgress">
                            <i class="fas fa-chart-line"></i> Mise à Jour Globale
                        </button>
                        <button type="button" class="btn btn-default btn-sm ml-2">
                            <i class="fas fa-download"></i> Exporter
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <!-- Filters and Search -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" id="searchChantier" class="form-control"
                                    placeholder="Rechercher un chantier...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="filterProjet" class="form-control select2" onchange="applyFilters()">
                                <option value="">Tous les projets</option>
                                <?php if (!empty($projects)): foreach ($projects as $p): ?>
                                        <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filterStatut" class="form-control select2" onchange="applyFilters()">
                                <option value="">Tous les statuts</option>
                                <option value="Planifié">Non Démarré</option>
                                <option value="En cours">En Cours</option>
                                <option value="Terminé">Terminé</option>
                                <option value="Suspendu">Suspendu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filterVille" class="form-control select2" onchange="applyFilters()">
                                <option value="">Toutes les villes</option>
                                <option value="alger">Alger</option>
                                <option value="oran">Oran</option>
                                <option value="constantine">Constantine</option>
                                <option value="annaba">Annaba</option>
                                <option value="bujumbura">Bujumbura</option>
                            </select>
                        </div>
                    </div>

                    <!-- Chantiers Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable" id="chantiersTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50"><input type="checkbox" class="checkbox-toggle"></th>
                                    <th>Nom du Chantier</th>
                                    <th>Projet Associé</th>
                                    <th>Ville</th>
                                    <th width="150">% Avancement</th>
                                    <th width="150">Montant Alloué</th>
                                    <th width="150">Montant Décaissé</th>
                                    <th width="120">Statut</th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="chantiersTableBody">
                                <?php if (!empty($chantiers)): ?>
                                    <?php foreach ($chantiers as $chantier): ?>
                                        <?php $avancement = round($chantier->avancement ?? 0); ?>
                                        <tr data-chantier-id="<?= $chantier->id ?>" data-projet-id="<?= $chantier->projet_id ?>"
                                            data-statut="<?= $chantier->status ?>"
                                            data-location="<?= strtolower($chantier->location ?? '') ?>">
                                            <td><input type="checkbox" class="checkbox-item"></td>
                                            <td>
                                                <strong><?= htmlspecialchars($chantier->name) ?></strong><br>
                                                <small
                                                    class="text-muted"><?= htmlspecialchars($chantier->location ?? '') ?></small>
                                            </td>
                                            <td>
                                                <i class="fas fa-project-diagram text-primary"></i>
                                                <?= htmlspecialchars($chantier->projet_name ?? 'Non assigné') ?>
                                            </td>
                                            <td>
                                                <i class="fas fa-map-marker-alt text-danger"></i>
                                                <?= htmlspecialchars(explode('-', $chantier->location ?? '')[0] ?? $chantier->location ?? '') ?>
                                            </td>
                                            <td>
                                                <div class="progress progress-sm mb-1">
                                                    <?php
                                                    $bgClass = 'bg-secondary';
                                                    if ($avancement >= 75) $bgClass = 'bg-success';
                                                    elseif ($avancement >= 30) $bgClass = 'bg-warning';
                                                    elseif ($avancement > 0) $bgClass = 'bg-info';
                                                    ?>
                                                    <div class="progress-bar <?= $bgClass ?>"
                                                        style="width: <?= $avancement ?>%">
                                                        <?= $avancement ?>%
                                                    </div>
                                                </div>
                                                <small class="text-muted">Mis à jour:
                                                    <?= date('d/m/Y', strtotime($chantier->created_at ?? 'now')) ?></small>
                                            </td>
                                            <td>
                                                <strong><?= number_format($chantier->budget ?? 0, 0, ',', ' ') ?> DA</strong>
                                            </td>
                                            <td>
                                                <?php $montantDecaisse = (($chantier->budget ?? 0) * $avancement / 100); ?>
                                                <strong class="<?= $avancement > 0 ? 'text-success' : 'text-muted' ?>">
                                                    <?= number_format($montantDecaisse, 0, ',', ' ') ?> DA
                                                </strong>
                                            </td>
                                            <td>
                                                <?php
                                                $statutClass = 'badge-secondary';
                                                $statutIcon = '<i class="fas fa-circle"></i>';
                                                $statutText = $chantier->status ?? 'Inconnu';
                                                if ($chantier->status == 'En cours') {
                                                    $statutClass = 'badge-success';
                                                    $statutIcon = '<i class="fas fa-sync fa-spin"></i>';
                                                    $statutText = 'En cours';
                                                } elseif ($chantier->status == 'Planifié') {
                                                    $statutClass = 'badge-secondary';
                                                    $statutIcon = '<i class="fas fa-pause-circle"></i>';
                                                    $statutText = 'Non démarré';
                                                } elseif ($chantier->status == 'Terminé') {
                                                    $statutClass = 'badge-info';
                                                    $statutIcon = '<i class="fas fa-check-circle"></i>';
                                                    $statutText = 'Terminé';
                                                } elseif ($chantier->status == 'Suspendu') {
                                                    $statutClass = 'badge-danger';
                                                    $statutIcon = '<i class="fas fa-ban"></i>';
                                                    $statutText = 'Suspendu';
                                                }
                                                ?>
                                                <span class="badge <?= $statutClass ?>"><?= $statutIcon ?>
                                                    <?= $statutText ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-warning" title="Modifier avancement"
                                                        onclick="updateProgress(<?= $chantier->id ?>, '<?= htmlspecialchars($chantier->name) ?>', <?= $avancement ?>)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-info" title="Voir détails"
                                                        onclick="viewChantierDetails(<?= $chantier->id ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" title="Historique"
                                                        onclick="viewHistory(<?= $chantier->id ?>)">
                                                        <i class="fas fa-history"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-5">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Aucun chantier trouvé</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-3">
                        <div class="col-sm-5">
                            <div class="dataTables_info">
                                Affichage de <span id="visibleCount"><?= count($chantiers ?? []) ?></span> sur
                                <?= count($chantiers ?? []) ?> chantiers
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers float-right">
                                <ul class="pagination">
                                    <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- ========================================== -->
    <!-- MODAL : Détails Chantier                   -->
    <!-- ========================================== -->
    <div class="modal fade" id="modalChantierDetails" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title"><i class="fas fa-hard-hat"></i> Détails du Chantier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5><i class="fas fa-hard-hat text-warning"></i> <span id="detailChantierNom"></span></h5>
                            <p class="text-muted">
                                <strong>Projet:</strong> <span id="detailProjetName"></span><br>
                                <strong>Localisation:</strong> <span id="detailLocation"></span>
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <span id="detailStatutBadge" class="badge badge-lg"></span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Avancement</span>
                                    <span class="info-box-number" id="detailAvancement"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-money-bill-wave"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Budget</span>
                                    <span class="info-box-number" id="detailBudget"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-hand-holding-usd"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Décaissé</span>
                                    <span class="info-box-number" id="detailDecaisse"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-3"><i class="fas fa-calendar-alt text-primary"></i> Planning</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td><strong>Date Début:</strong></td>
                                <td id="detailDateDebut"></td>
                                <td><strong>Date Fin Prévue:</strong></td>
                                <td id="detailDateFin"></td>
                            </tr>
                            <tr>
                                <td><strong>Chef de Chantier:</strong></td>
                                <td colspan="3" id="detailChefChantier"></td>
                            </tr>
                        </table>
                    </div>

                    <h6 class="mb-3"><i class="fas fa-tasks text-success"></i> Progression</h6>
                    <div class="progress mb-3" style="height: 30px;">
                        <div id="detailProgressBar" class="progress-bar bg-success" role="progressbar" style="width: 0%"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i>
                        Fermer</button>
                    <button type="button" class="btn btn-warning" onclick="openUpdateModalFromDetails()"
                        data-dismiss="modal"><i class="fas fa-edit"></i> Modifier Avancement</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL : Modifier Avancement (DYNAMIQUE)    -->
    <!-- ========================================== -->
    <div class="modal fade" id="modalUpdateProgress" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title"><i class="fas fa-chart-line"></i> Modifier l'Avancement</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form id="formUpdateProgress" method="post" action="<?= base_url('crm-chantiers-update-progress') ?>">
                    <div class="modal-body">
                        <input type="hidden" id="updateChantierId" name="chantier_id">

                        <div class="alert alert-info">
                            <strong>Chantier:</strong> <span id="updateChantierName"></span><br>
                            <strong>Projet:</strong> <span id="updateProjetName"></span>
                        </div>

                        <div class="form-group">
                            <label>Avancement Actuel</label>
                            <div class="progress mb-2">
                                <div id="currentProgressBar" class="progress-bar bg-success" style="width: 0%">0%</div>
                            </div>
                            <small class="text-muted">Budget: <span id="updateBudget"></span> DA | Décaissé: <span
                                    id="updateDecaisse"></span> DA</small>
                        </div>

                        <div class="form-group">
                            <label>Nouvel Avancement (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="newProgress" name="avancement" min="0"
                                max="100" value="0" required oninput="calculateUpdate()">
                            <small class="form-text text-muted"><i class="fas fa-calculator"></i> Le montant décaissé
                                sera recalculé automatiquement</small>
                        </div>

                        <div class="alert alert-success" id="calculationPreview" style="display:none;">
                            <h6><i class="fas fa-calculator"></i> Calcul Automatique</h6>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Nouveau montant décaissé:</strong><br>
                                    <span id="newDisbursed" class="text-primary font-weight-bold"></span> DA
                                </div>
                                <div class="col-6">
                                    <strong>Différence:</strong><br>
                                    <span id="diffAmount" class="font-weight-bold"></span> DA
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Statut</label>
                            <select class="form-control select2" name="statut" id="updateStatut" required>
                                <option value="Planifié">Planifié (Non démarré)</option>
                                <option value="En cours">En cours</option>
                                <option value="Terminé">Terminé</option>
                                <option value="Suspendu">Suspendu</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Commentaire</label>
                            <textarea class="form-control" name="commentaire" rows="2"
                                placeholder="Description de l'avancement..."></textarea>
                        </div>

                        <div class="form-group">
                            <label>Date de mise à jour</label>
                            <input type="date" class="form-control" name="date_maj" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i>
                            Annuler</button>
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.content-wrapper -->

<!-- ========================================== -->
<!-- SCRIPTS                                      -->
<!-- ========================================== -->
<script>
    // Variable globale
    var currentChantier = null;
    var chantiersData = <?= json_encode($chantiers ?? []) ?>;

    // Fonction pour voir les détails
    function viewChantierDetails(chantierId) {
        var chantier = chantiersData.find(c => c.id == chantierId);
        if (!chantier) {
            alert('Chantier non trouvé !');
            return;
        }

        currentChantier = chantier;

        $('#detailChantierNom').text(chantier.name);
        $('#detailProjetName').text(chantier.projet_name || 'Non assigné');
        $('#detailLocation').text(chantier.location || '-');

        var statutClass = 'badge-secondary',
            statutText = chantier.status || 'Inconnu';
        if (chantier.status == 'En cours') {
            statutClass = 'badge-success';
            statutText = 'En cours';
        } else if (chantier.status == 'Planifié') {
            statutClass = 'badge-secondary';
            statutText = 'Non démarré';
        } else if (chantier.status == 'Terminé') {
            statutClass = 'badge-info';
            statutText = 'Terminé';
        } else if (chantier.status == 'Suspendu') {
            statutClass = 'badge-danger';
            statutText = 'Suspendu';
        }

        $('#detailStatutBadge').attr('class', 'badge badge-lg ' + statutClass).text(statutText);

        var avancement = parseFloat(chantier.avancement) || 0;
        $('#detailAvancement').text(avancement + '%');
        $('#detailProgressBar').css('width', avancement + '%').text(avancement + '%');

        var budget = parseFloat(chantier.budget) || 0;
        var decaisse = (budget * avancement / 100).toFixed(2);
        $('#detailBudget').text(formatNumber(budget) + ' DA');
        $('#detailDecaisse').text(formatNumber(decaisse) + ' DA');

        $('#detailDateDebut').text(chantier.date_debut ? formatDate(chantier.date_debut) : '-');
        $('#detailDateFin').text(chantier.date_fin_prevue ? formatDate(chantier.date_fin_prevue) : '-');
        $('#detailChefChantier').text(chantier.chef_chantier || 'Non assigné');

        $('#modalChantierDetails').modal('show');
    }

    function openUpdateModalFromDetails() {
        if (currentChantier) {
            updateProgress(currentChantier.id, currentChantier.name, parseFloat(currentChantier.avancement) || 0);
        }
    }

    function updateProgress(chantierId, chantierName, currentProgress) {
        var chantier = chantiersData.find(c => c.id == chantierId);
        if (!chantier) {
            alert('Chantier non trouvé !');
            return;
        }

        $('#updateChantierId').val(chantierId);
        $('#updateChantierName').text(chantierName);
        $('#updateProjetName').text(chantier.projet_name || 'Non assigné');

        $('#currentProgressBar').css('width', currentProgress + '%').text(currentProgress + '%');

        var budget = parseFloat(chantier.budget) || 0;
        var currentDecaisse = (budget * currentProgress / 100).toFixed(2);
        $('#updateBudget').text(formatNumber(budget));
        $('#updateDecaisse').text(formatNumber(currentDecaisse));

        $('#newProgress').val(currentProgress);
        $('#updateStatut').val(chantier.status);

        calculateUpdate();
        $('#modalUpdateProgress').modal('show');
    }

    function calculateUpdate() {
        if (!currentChantier) return;

        var newProgress = parseFloat($('#newProgress').val()) || 0;
        var budget = parseFloat(currentChantier.budget) || 0;
        var currentProgress = parseFloat(currentChantier.avancement) || 0;

        var newDecaisse = (budget * newProgress / 100).toFixed(2);
        var currentDecaisse = (budget * currentProgress / 100).toFixed(2);
        var diff = (newDecaisse - currentDecaisse).toFixed(2);

        $('#newDisbursed').text(formatNumber(newDecaisse));
        $('#diffAmount').text(diff >= 0 ? '+' + formatNumber(diff) : formatNumber(diff))
            .removeClass('text-danger text-success')
            .addClass(diff >= 0 ? 'text-success' : 'text-danger');

        $('#calculationPreview').show();
    }

    function viewHistory(chantierId) {
        Swal.fire({
            icon: 'info',
            title: 'Historique',
            text: 'Fonctionnalité à implémenter pour le chantier ID: ' + chantierId
        });
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        var date = new Date(dateStr);
        return date.toLocaleDateString('fr-FR');
    }

    // Filtrage
    function applyFilters() {
        var search = $('#searchChantier').val().toLowerCase();
        var projet = $('#filterProjet').val();
        var statut = $('#filterStatut').val();
        var ville = $('#filterVille').val().toLowerCase();
        var visible = 0;

        $('#chantiersTableBody tr').each(function() {
            var row = $(this);
            var text = row.text().toLowerCase();
            var rProjet = row.data('projet-id');
            var rStatut = row.data('statut');
            var rVille = row.data('location');

            var show = true;
            if (search && text.indexOf(search) === -1) show = false;
            if (projet && rProjet != projet) show = false;
            if (statut && rStatut != statut) show = false;
            if (ville && rVille.indexOf(ville) === -1) show = false;

            row.toggle(show);
            if (show) visible++;
        });
        $('#visibleCount').text(visible);
    }

    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Sélectionner...',
            allowClear: true
        });
        $('#searchChantier').on('keyup', applyFilters);
    });
</script>