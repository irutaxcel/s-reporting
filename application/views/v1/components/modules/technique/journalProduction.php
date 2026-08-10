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

            <!-- Small boxes (tuiles AdminLTE) -->
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $nbJournauxMois ?></h3>
                            <p>Journaux (mois en cours)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $nbJournauxValides ?></h3>
                            <p>Journaux validés</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $nbJournauxAttente ?></h3>
                            <p>En attente de validation</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?= ($heuresEngins + 0) ?> h</h3>
                            <p>Heures engins cumulées</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck-monster"></i>
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
                        <i class="fas fa-clipboard-list mr-2"></i>
                        Journaux de production des chantiers
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                            data-target="#modalNouveauJournal">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Nouveau journal
                        </button>
                        <button class="btn btn-sm btn-secondary">
                            <i class="fas fa-print mr-1"></i>
                            Imprimer
                        </button>
                    </div>
                </div>

                <!-- ========== MODAL : NOUVEAU JOURNAL DE PRODUCTION ========== -->
                <div class="modal fade" id="modalNouveauJournal" tabindex="-1" role="dialog"
                    aria-labelledby="modalNouveauJournalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <form action="<?= base_url('journalProduction-create') ?>" method="post"
                            id="formJournalProduction">
                            <div class="modal-content">

                                <div class="modal-header bg-success">
                                    <h5 class="modal-title" id="modalNouveauJournalLabel">
                                        <i class="fas fa-clipboard-list mr-2"></i>
                                        Nouveau journal de production
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <!-- Informations générales -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date du journal <span class="text-danger">*</span></label>
                                                <input type="date" name="jp_date" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Chantier <span class="text-danger">*</span></label>
                                                <select name="jp_chantier" class="form-control" required>
                                                    <option value="">-- Sélectionner le chantier --</option>
                                                    <?php foreach ($allChantiers as $c): ?> <option
                                                        value="<?= $c->id ?>"><?= $c->name ?></option>
                                                    <?php endforeach; ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Chef de chantier</label>
                                                <input type="text" name="jp_chef" class="form-control"
                                                    placeholder="Nom du responsable">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Main-d'œuvre & conditions -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Météo</label>
                                                <select name="jp_meteo" class="form-control">
                                                    <option>Ensoleillé</option>
                                                    <option>Nuageux</option>
                                                    <option>Pluvieux</option>
                                                    <option>Orageux</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ouvriers internes</label>
                                                <input type="number" name="jp_effectif_int" class="form-control" min="0"
                                                    value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ouvriers sous-traitants</label>
                                                <input type="number" name="jp_effectif_st" class="form-control" min="0"
                                                    value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Heures travaillées</label>
                                                <input type="number" name="jp_heures" class="form-control" min="0"
                                                    step="0.5" value="8">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Engins & matériel utilisés -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">
                                            <i class="fas fa-truck-monster mr-1"></i>
                                            Engins &amp; matériel utilisés
                                        </h5>
                                        <button type="button" class="btn btn-sm btn-success" onclick="addEnginRow()">
                                            <i class="fas fa-plus mr-1"></i>
                                            Ajouter un engin
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm" id="enginsTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Engin / Matériel</th>
                                                    <th width="170">Heures d'utilisation</th>
                                                    <th width="170">Carburant (L)</th>
                                                    <th width="60">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <!-- PLUS TARD : boucler sur la table engins -->
                                                        <select name="jp_engin[]" class="form-control">
                                                            <option value="">-- Sélectionner --</option>
                                                            <?php foreach ($allEngins as $engin): ?>
                                                            <option value="<?= $engin->id ?>"><?= $engin->designation ?>
                                                            </option>
                                                            <?php endforeach; ?>

                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="jp_heures_engin[]"
                                                            class="form-control" min="0" step="0.5" value="0">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="jp_carburant[]" class="form-control"
                                                            min="0" value="0">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="removeEnginRow(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <hr>

                                    <!-- Travaux réalisés -->
                                    <div class="form-group">
                                        <label>Travaux réalisés (production du jour)</label>
                                        <textarea name="jp_travaux" class="form-control" rows="3"
                                            placeholder="Décrire les travaux réalisés et les quantités produites (ex : coulage de 45 m³ de béton, pose de 120 m de caniveaux...)"></textarea>
                                    </div>

                                    <!-- Observations -->
                                    <div class="form-group">
                                        <label>Observations / incidents</label>
                                        <textarea name="jp_observations" class="form-control" rows="2"
                                            placeholder="Retards, pannes, intempéries, visites, arrêts de chantier..."></textarea>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Fermer
                                    </button>
                                    <button type="button" class="btn btn-warning">
                                        <i class="fas fa-save mr-1"></i>
                                        Enregistrer brouillon
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane mr-1"></i>
                                        Enregistrer &amp; soumettre
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <!-- Script : lignes dynamiques des engins (1 ligne minimum) -->
                <script>
                function addEnginRow() {
                    let tbody = document.querySelector('#enginsTable tbody');
                    let clone = tbody.rows[0].cloneNode(true);
                    clone.querySelectorAll('select').forEach(s => s.value = '');
                    clone.querySelectorAll('input[type="number"]').forEach(i => i.value = '0');
                    tbody.appendChild(clone);
                }

                function removeEnginRow(button) {
                    let tbody = document.querySelector('#enginsTable tbody');
                    if (tbody.rows.length > 1) { // toujours 1 ligne minimum
                        button.closest('tr').remove();
                    }
                }
                </script>

                <div class="card-body">

                    <!-- Filtres -->
                    <form action="<?= base_url('journal-production') ?>" method="get">
                        <div class="row mb-3">

                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label>Date début</label>
                                    <input type="date" name="date_debut" class="form-control"
                                        value="<?= html_escape($filters['date_debut'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label>Date fin</label>
                                    <input type="date" name="date_fin" class="form-control"
                                        value="<?= html_escape($filters['date_fin'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label>Chantier</label>
                                    <select name="chantier" class="form-control">
                                        <option value="">Tous les chantiers</option>
                                        <?php foreach ($allChantiers as $c): ?>
                                        <option value="<?= $c->id ?>"
                                            <?= ((string) ($filters['chantier'] ?? '') === (string) $c->id) ? 'selected' : '' ?>>
                                            <?= html_escape($c->name) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label>Statut</label>
                                    <select name="statut" class="form-control">
                                        <option value="">Tous les statuts</option>
                                        <option value="valide"
                                            <?= ($filters['statut'] ?? '') === 'valide' ? 'selected' : '' ?>>
                                            Validé
                                        </option>
                                        <option value="en_attente"
                                            <?= ($filters['statut'] ?? '') === 'en_attente' ? 'selected' : '' ?>>
                                            En attente
                                        </option>
                                        <option value="brouillon"
                                            <?= ($filters['statut'] ?? '') === 'brouillon' ? 'selected' : '' ?>>
                                            Brouillon
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <div class="btn-group btn-block">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-search mr-1"></i>
                                        Filtrer
                                    </button>
                                    <a href="<?= base_url('journal-production') ?>" class="btn btn-secondary"
                                        title="Réinitialiser les filtres">
                                        <i class="fas fa-redo-alt"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>

                    <!-- Tableau des journaux -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:40px">#</th>
                                    <th style="width:120px">Référence</th>
                                    <th style="width:100px">Date</th>
                                    <th style="width:190px">Chantier</th>
                                    <th style="width:130px">Chef de chantier</th>
                                    <th style="width:110px">Météo</th>
                                    <th style="width:110px" class="text-center">Effectif (Int. / ST)</th>
                                    <th style="width:100px" class="text-center">Engins – h</th>
                                    <th>Production du jour</th>
                                    <th style="width:110px" class="text-center">Statut</th>
                                    <th style="width:170px" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if (!empty($journalProduction)) : ?>

                                <?php $i = 1; ?>
                                <?php foreach ($journalProduction as $jp) : ?>

                                <?php
                                        // Icône selon la météo
                                        switch ($jp->meteo) {
                                            case 'Ensoleillé':
                                                $iconMeteo = '<i class="fas fa-sun text-warning"></i>';
                                                break;
                                            case 'Nuageux':
                                                $iconMeteo = '<i class="fas fa-cloud text-secondary"></i>';
                                                break;
                                            case 'Pluvieux':
                                                $iconMeteo = '<i class="fas fa-cloud-rain text-info"></i>';
                                                break;
                                            case 'Orageux':
                                                $iconMeteo = '<i class="fas fa-bolt text-warning"></i>';
                                                break;
                                            default:
                                                $iconMeteo = '<i class="fas fa-cloud text-secondary"></i>';
                                        }

                                        // Badge selon le statut
                                        if ($jp->statut == 'valide') {
                                            $badgeStatut = '<span class="badge badge-success">Validé</span>';
                                        } elseif ($jp->statut == 'en_attente') {
                                            $badgeStatut = '<span class="badge badge-warning">En attente</span>';
                                        } elseif ($jp->statut == 'brouillon') {
                                            $badgeStatut = '<span class="badge badge-secondary">Brouillon</span>';
                                        } else {
                                            $badgeStatut = '<span class="badge badge-info">' . ucfirst($jp->statut) . '</span>';
                                        }
                                        ?>

                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><strong><?= html_escape($jp->reference) ?></strong></td>
                                    <td class="text-nowrap"><?= date('d/m/Y', strtotime($jp->journal_date)) ?></td>
                                    <td><?= html_escape($jp->chantier_name) ?></td>
                                    <td><?= html_escape($jp->chef_chantier) ?></td>
                                    <td><?= $iconMeteo ?> <?= html_escape($jp->meteo) ?></td>
                                    <td class="text-center"><?= $jp->effectif_interne ?> /
                                        <?= $jp->effectif_sous_traitant ?></td>
                                    <td class="text-center"><?= ($jp->nb_engins + 0) ?> –
                                        <?= ($jp->total_heures_engins + 0) ?> h</td>
                                    <td><?= html_escape($jp->travaux_realises) ?></td>
                                    <td class="text-center"><?= $badgeStatut ?></td>
                                    <td class="text-center text-nowrap">
                                        <button class="btn btn-sm btn-info" title="Voir"
                                            onclick="voirJournal(<?= $jp->id ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" title="Modifier"
                                            onclick="modifierJournal(<?= $jp->id ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" title="Supprimer"
                                            onclick="supprimerJournal(<?= $jp->id ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary" title="Imprimer"
                                            onclick="window.open('<?= base_url('journalProduction-print/' . $jp->id) ?>', '_blank')">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>

                                <?php endforeach; ?>

                                <?php else : ?>

                                <tr>
                                    <td colspan="11" class="text-center text-muted">
                                        Aucun journal de production trouvé.
                                    </td>
                                </tr>

                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="card-footer clearfix">
                    <div class="float-left">
                        <small class="text-muted">
                            Liste des journaux de production saisis par les chefs de chantier.
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

<!-- ========== MODAL : DÉTAIL DU JOURNAL ========== -->
<div class="modal fade" id="modalVoirJournal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h5 class="modal-title">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Détail du journal de production
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <!-- Informations générales -->
                <div class="row">
                    <div class="col-md-3">
                        <strong>Référence</strong>
                        <p id="view_reference" class="text-muted"></p>
                    </div>
                    <div class="col-md-3">
                        <strong>Date du journal</strong>
                        <p id="view_date" class="text-muted"></p>
                    </div>
                    <div class="col-md-3">
                        <strong>Chantier</strong>
                        <p id="view_chantier" class="text-muted"></p>
                    </div>
                    <div class="col-md-3">
                        <strong>Chef de chantier</strong>
                        <p id="view_chef" class="text-muted"></p>
                    </div>
                    <div class="col-md-3">
                        <strong>Météo</strong>
                        <p id="view_meteo" class="text-muted"></p>
                    </div>
                    <div class="col-md-3">
                        <strong>Ouvriers internes</strong>
                        <p id="view_effectif_int" class="text-muted"></p>
                    </div>
                    <div class="col-md-3">
                        <strong>Ouvriers sous-traitants</strong>
                        <p id="view_effectif_st" class="text-muted"></p>
                    </div>
                    <div class="col-md-3">
                        <strong>Heures travaillées</strong>
                        <p id="view_heures" class="text-muted"></p>
                    </div>
                    <div class="col-md-3">
                        <strong>Statut</strong>
                        <p id="view_statut" class="text-muted"></p>
                    </div>
                    <div class="col-md-3">
                        <strong>Enregistré le</strong>
                        <p id="view_created_at" class="text-muted"></p>
                    </div>
                </div>

                <hr>

                <!-- Engins & matériel -->
                <h5><i class="fas fa-truck-monster mr-1"></i> Engins &amp; matériel utilisés</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:40px">#</th>
                                <th>Engin / Matériel</th>
                                <th class="text-right" width="150">Heures</th>
                                <th class="text-right" width="150">Carburant (L)</th>
                            </tr>
                        </thead>
                        <tbody id="view_engins_body"></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-right">Totaux</th>
                                <th class="text-right" id="view_total_heures"></th>
                                <th class="text-right" id="view_total_carburant"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <hr>

                <!-- Travaux & observations -->
                <h5><i class="fas fa-tasks mr-1"></i> Travaux réalisés (production du jour)</h5>
                <p id="view_travaux" class="text-muted"></p>

                <h5><i class="fas fa-exclamation-triangle mr-1"></i> Observations / incidents</h5>
                <p id="view_observations" class="text-muted"></p>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Fermer
                </button>
            </div>

        </div>
    </div>
</div>

<!-- SweetAlert2 si pas déjà chargé sur cette page -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function voirJournal(id) {
    $.ajax({
        url: "<?= base_url('journalProduction-get/') ?>" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {

            if (!res.status) {
                Swal.fire('Erreur', res.message || 'Journal introuvable.', 'error');
                return;
            }

            let jp = res.journal;

            // ----- Informations générales -----
            $('#view_reference').text(jp.reference);
            $('#view_date').text(formatDateFr(jp.journal_date));
            $('#view_chantier').text(jp.chantier_name || '-');
            $('#view_chef').text(jp.chef_chantier || '-');
            $('#view_meteo').text(jp.meteo || '-');
            $('#view_effectif_int').text(jp.effectif_interne);
            $('#view_effectif_st').text(jp.effectif_sous_traitant);
            $('#view_heures').text((parseFloat(jp.heures_travaillees) || 0) + ' h');
            $('#view_created_at').text(formatDateFr(jp.created_at));

            // ----- Badge statut -----
            let badge;
            if (jp.statut == 'valide') {
                badge = '<span class="badge badge-success">Validé</span>';
            } else if (jp.statut == 'en_attente') {
                badge = '<span class="badge badge-warning">En attente</span>';
            } else if (jp.statut == 'brouillon') {
                badge = '<span class="badge badge-secondary">Brouillon</span>';
            } else {
                badge = '<span class="badge badge-info">' + jp.statut + '</span>';
            }
            $('#view_statut').html(badge);

            // ----- Tableau des engins -----
            $('#view_engins_body').html('');
            let totalH = 0,
                totalC = 0;

            if (res.engins.length > 0) {
                res.engins.forEach(function(e, index) {
                    let h = parseFloat(e.heures_utilisation) || 0;
                    let c = parseFloat(e.carburant_l) || 0;
                    totalH += h;
                    totalC += c;

                    $('#view_engins_body').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${e.engin_name || '-'}</td>
                                <td class="text-right">${h}</td>
                                <td class="text-right">${c}</td>
                            </tr>
                        `);
                });
            } else {
                $('#view_engins_body').html(`
                        <tr>
                            <td colspan="4" class="text-center text-muted">Aucun engin utilisé.</td>
                        </tr>
                    `);
            }

            $('#view_total_heures').text(totalH + ' h');
            $('#view_total_carburant').text(totalC + ' L');

            // ----- Travaux & observations -----
            $('#view_travaux').text(jp.travaux_realises || '-');
            $('#view_observations').text(jp.observations || '-');

            // ----- Ouvrir la modale -----
            $('#modalVoirJournal').modal('show');
        },
        error: function() {
            Swal.fire('Erreur', 'Impossible de charger le détail du journal.', 'error');
        }
    });
}

function formatDateFr(dateValue) {
    if (!dateValue) return '-';
    let date = new Date(String(dateValue).replace(' ', 'T'));
    if (isNaN(date.getTime())) return dateValue;
    return date.toLocaleDateString('fr-FR');
}
</script>

<!-- ========== MODAL : MODIFIER LE JOURNAL ========== -->
<div class="modal fade" id="modalModifierJournal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form action="<?= base_url('journalProduction-update') ?>" method="post" id="formModifierJournal">

            <input type="hidden" name="id" id="edit_id">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier le journal de production
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- Informations générales -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date du journal <span class="text-danger">*</span></label>
                                <input type="date" name="jp_date" id="edit_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Chantier <span class="text-danger">*</span></label>
                                <select name="jp_chantier" id="edit_chantier" class="form-control" required>
                                    <option value="">-- Sélectionner le chantier --</option>
                                    <?php foreach ($allChantiers as $c): ?>
                                    <option value="<?= $c->id ?>"><?= $c->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Chef de chantier</label>
                                <input type="text" name="jp_chef" id="edit_chef" class="form-control"
                                    placeholder="Nom du responsable">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Statut</label>
                                <select name="jp_statut" id="edit_statut" class="form-control">
                                    <option value="brouillon">Brouillon</option>
                                    <option value="en_attente">En attente</option>
                                    <option value="valide">Validé</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Main-d'œuvre & conditions -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Météo</label>
                                <select name="jp_meteo" id="edit_meteo" class="form-control">
                                    <option>Ensoleillé</option>
                                    <option>Nuageux</option>
                                    <option>Pluvieux</option>
                                    <option>Orageux</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ouvriers internes</label>
                                <input type="number" name="jp_effectif_int" id="edit_effectif_int" class="form-control"
                                    min="0" value="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ouvriers sous-traitants</label>
                                <input type="number" name="jp_effectif_st" id="edit_effectif_st" class="form-control"
                                    min="0" value="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Heures travaillées</label>
                                <input type="number" name="jp_heures" id="edit_heures" class="form-control" min="0"
                                    step="0.5" value="8">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Engins & matériel -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">
                            <i class="fas fa-truck-monster mr-1"></i>
                            Engins &amp; matériel utilisés
                        </h5>
                        <button type="button" class="btn btn-sm btn-success" onclick="addEditEnginRow()">
                            <i class="fas fa-plus mr-1"></i>
                            Ajouter un engin
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="editEnginsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Engin / Matériel</th>
                                    <th width="170">Heures d'utilisation</th>
                                    <th width="170">Carburant (L)</th>
                                    <th width="60">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label>Travaux réalisés (production du jour)</label>
                        <textarea name="jp_travaux" id="edit_travaux" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Observations / incidents</label>
                        <textarea name="jp_observations" id="edit_observations" class="form-control"
                            rows="2"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
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
// Options des engins (générées depuis la base, réutilisées par les lignes dynamiques)
const enginOptions =
    `<?php foreach ($allEngins as $e): ?><option value="<?= $e->id ?>"><?= htmlspecialchars($e->designation, ENT_QUOTES) ?></option><?php endforeach; ?>`;

// ---------- Ouvrir la modale et pré-remplir ----------
function modifierJournal(id) {
    $.ajax({
        url: "<?= base_url('journalProduction-get/') ?>" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {

            if (!res.status) {
                Swal.fire('Erreur', res.message || 'Journal introuvable.', 'error');
                return;
            }

            let jp = res.journal;

            // Entête
            $('#edit_id').val(jp.id);
            $('#edit_date').val(jp.journal_date);
            $('#edit_chantier').val(jp.chantier_id);
            $('#edit_chef').val(jp.chef_chantier);
            $('#edit_statut').val(jp.statut);
            $('#edit_meteo').val(jp.meteo);
            $('#edit_effectif_int').val(jp.effectif_interne);
            $('#edit_effectif_st').val(jp.effectif_sous_traitant);
            $('#edit_heures').val(jp.heures_travaillees);
            $('#edit_travaux').val(jp.travaux_realises);
            $('#edit_observations').val(jp.observations);

            // Lignes d'engins
            $('#editEnginsTable tbody').html('');

            if (res.engins.length > 0) {
                res.engins.forEach(function(e) {
                    addEditEnginRow(e.engin_id, e.heures_utilisation, e.carburant_l);
                });
            } else {
                addEditEnginRow(); // au moins une ligne vide
            }

            $('#modalModifierJournal').modal('show');
        },
        error: function() {
            Swal.fire('Erreur', 'Impossible de charger le journal à modifier.', 'error');
        }
    });
}

// ---------- Ajouter une ligne engin (édition) ----------
function addEditEnginRow(engin_id = '', heures = 0, carburant = 0) {
    let $row = $(`
            <tr>
                <td>
                    <select name="jp_engin[]" class="form-control">
                        <option value="">-- Sélectionner --</option>
                        ${enginOptions}
                    </select>
                </td>
                <td>
                    <input type="number" name="jp_heures_engin[]" class="form-control" min="0" step="0.5" value="${heures}">
                </td>
                <td>
                    <input type="number" name="jp_carburant[]" class="form-control" min="0" value="${carburant}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeEditEnginRow(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);

    $row.find('select').val(engin_id); // pré-sélectionne l'engin de la ligne
    $('#editEnginsTable tbody').append($row);
}

// ---------- Supprimer une ligne (1 minimum) ----------
function removeEditEnginRow(button) {
    let tbody = document.querySelector('#editEnginsTable tbody');
    if (tbody.rows.length > 1) {
        button.closest('tr').remove();
    }
}
</script>

<script>
function supprimerJournal(id) {
    Swal.fire({
        title: 'Supprimer ce journal ?',
        text: "Le journal et tous ses engins associés seront supprimés définitivement.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {

        // ----- OUI : suppression -----
        if (result.isConfirmed) {

            $.ajax({
                url: "<?= base_url('journalProduction-delete') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(response) {

                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Supprimé',
                            text: 'Le journal a été supprimé avec succès.',
                            timer: 1200,
                            showConfirmButton: false
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1200);
                    } else {
                        Swal.fire('Erreur', response.message || 'La suppression a échoué.',
                            'error');
                    }
                },
                error: function() {
                    Swal.fire('Erreur', 'Impossible de supprimer ce journal.', 'error');
                }
            });

        }
        // ----- NON : le popup se ferme simplement, rien n'est supprimé -----

    });
}
</script>