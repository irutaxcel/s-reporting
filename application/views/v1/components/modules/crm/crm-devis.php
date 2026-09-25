<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-file-invoice-dollar text-primary"></i> Devis & Contrats par Chantier
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Devis & Contrats</li>
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
                            <i class="fas fa-file-invoice"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Devis</span>
                            <span class="info-box-number"><?= $stats['total_devis'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Devis Signés</span>
                            <span class="info-box-number"><?= $stats['devis_signes'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1">
                            <i class="fas fa-file-contract"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Contrats Actifs</span>
                            <span class="info-box-number"><?= $stats['contrats_actifs'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-hard-hat"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Chantiers</span>
                            <span class="info-box-number"><?= $stats['total_chantiers'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Liste des Devis & Contrats par Chantier
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#modalUploadDevis">
                            <i class="fas fa-plus"></i> Nouveau Devis
                        </button>
                        <button type="button" class="btn btn-info btn-sm ml-2" data-toggle="modal"
                            data-target="#modalUploadContrat">
                            <i class="fas fa-file-contract"></i> Nouveau Contrat
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
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput"
                                    placeholder="Rechercher un devis/contrat...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2" id="filterProjet" onchange="applyFilters()">
                                <option value="">Tous les projets</option>
                                <?php foreach ($projects as $project): ?>
                                    <option value="<?= $project->id ?>"><?= $project->reference ?> - <?= $project->name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2" id="filterChantier" onchange="applyFilters()">
                                <option value="">Tous les chantiers</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2" id="filterType" onchange="applyFilters()">
                                <option value="">Tous les types</option>
                                <option value="devis">Devis</option>
                                <option value="contrat">Contrat</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control select2" id="filterStatut" onchange="applyFilters()">
                                <option value="">Tous les statuts</option>
                                <option value="en_attente">En Attente</option>
                                <option value="signe">Signé</option>
                                <option value="expire">Expiré</option>
                                <option value="annule">Annulé</option>
                            </select>
                        </div>
                    </div>

                    <!-- Reset Filters Button -->
                    <div class="row mb-3">
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-sm btn-secondary" onclick="resetFilters()">
                                <i class="fas fa-times"></i> Réinitialiser les filtres
                            </button>
                            <span class="text-muted ml-2" id="filterCount"></span>
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

                    <!-- Documents Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="documentsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" class="checkbox-toggle">
                                    </th>
                                    <th>Référence</th>
                                    <th>Type</th>
                                    <th>Projet</th>
                                    <th>Chantier</th>
                                    <th>Montant</th>
                                    <th>Date Création</th>
                                    <th>Date Signature</th>
                                    <th>Date Expiration</th>
                                    <th width="120">Statut</th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fusionner devis et contrats en un seul tableau
                                $all_documents = array();

                                if (!empty($devis)) {
                                    foreach ($devis as $devis_item) {
                                        $all_documents[] = array(
                                            'id' => $devis_item->id,
                                            'type' => 'devis',
                                            'projet_id' => $devis_item->projet_id,
                                            'chantier_id' => $devis_item->chantier_id,
                                            'reference' => $devis_item->reference,
                                            'projet_name' => $devis_item->projet_name,
                                            'projet_reference' => $devis_item->projet_reference,
                                            'chantier_name' => $devis_item->chantier_name,
                                            'chantier_location' => $devis_item->chantier_location,
                                            'montant' => $devis_item->montant,
                                            'date_creation' => $devis_item->date_creation,
                                            'date_signature' => $devis_item->date_signature,
                                            'date_expiration' => $devis_item->date_expiration,
                                            'statut' => $devis_item->statut,
                                            'fichier' => $devis_item->fichier_devis,
                                        );
                                    }
                                }

                                if (!empty($contrats)) {
                                    foreach ($contrats as $contrat_item) {
                                        $all_documents[] = array(
                                            'id' => $contrat_item->id,
                                            'type' => 'contrat',
                                            'projet_id' => $contrat_item->projet_id,
                                            'chantier_id' => $contrat_item->chantier_id,
                                            'reference' => $contrat_item->numero_contrat,
                                            'projet_name' => $contrat_item->projet_name,
                                            'projet_reference' => $contrat_item->projet_reference,
                                            'chantier_name' => $contrat_item->chantier_name,
                                            'chantier_location' => $contrat_item->chantier_location,
                                            'montant' => $contrat_item->montant,
                                            'date_creation' => $contrat_item->date_signature,
                                            'date_signature' => $contrat_item->date_signature,
                                            'date_expiration' => $contrat_item->date_fin_prevue,
                                            'statut' => $contrat_item->statut,
                                            'fichier' => $contrat_item->fichier_contrat,
                                        );
                                    }
                                }

                                // Trier par date de création décroissante
                                usort($all_documents, function ($a, $b) {
                                    return strtotime($b['date_creation']) - strtotime($a['date_creation']);
                                });

                                // Afficher les documents
                                if (!empty($all_documents)):
                                    foreach ($all_documents as $doc):
                                ?>
                                        <tr data-type="<?= $doc['type'] ?>" data-projet-id="<?= $doc['projet_id'] ?? '' ?>"
                                            data-chantier-id="<?= $doc['chantier_id'] ?? '' ?>"
                                            data-statut="<?= $doc['statut'] ?>">
                                            <td>
                                                <input type="checkbox" class="checkbox-item">
                                            </td>
                                            <td><strong><?= htmlspecialchars($doc['reference']) ?></strong></td>
                                            <td>
                                                <?php if ($doc['type'] == 'devis'): ?>
                                                    <span class="badge badge-primary">
                                                        <i class="fas fa-file-invoice"></i> Devis
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-file-contract"></i> Contrat
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($doc['projet_name']) ?></strong><br>
                                                <small
                                                    class="text-muted"><?= htmlspecialchars($doc['projet_reference']) ?></small>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($doc['chantier_name']) ?></strong><br>
                                                <small
                                                    class="text-muted"><?= htmlspecialchars($doc['chantier_location']) ?></small>
                                            </td>
                                            <td>
                                                <strong><?= number_format($doc['montant'], 0, ',', ' ') ?> DA</strong>
                                            </td>
                                            <td>
                                                <i class="far fa-calendar"></i>
                                                <?= date('d/m/Y', strtotime($doc['date_creation'])) ?>
                                            </td>
                                            <td>
                                                <?php if ($doc['date_signature']): ?>
                                                    <i class="far fa-calendar-check"></i>
                                                    <?= date('d/m/Y', strtotime($doc['date_signature'])) ?>
                                                <?php else: ?>
                                                    <em class="text-muted">-</em>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($doc['date_expiration']): ?>
                                                    <i class="far fa-calendar-times"></i>
                                                    <?= date('d/m/Y', strtotime($doc['date_expiration'])) ?>
                                                <?php else: ?>
                                                    <em class="text-muted">-</em>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statut_class = '';
                                                $statut_icon = '';
                                                $statut_text = '';

                                                switch ($doc['statut']) {
                                                    case 'signe':
                                                        $statut_class = 'badge-success';
                                                        $statut_icon = '<i class="fas fa-check-circle"></i>';
                                                        $statut_text = 'Signé';
                                                        break;
                                                    case 'en_attente':
                                                        $statut_class = 'badge-warning';
                                                        $statut_icon = '<i class="fas fa-clock"></i>';
                                                        $statut_text = 'En Attente';
                                                        break;
                                                    case 'expire':
                                                        $statut_class = 'badge-danger';
                                                        $statut_icon = '<i class="fas fa-times-circle"></i>';
                                                        $statut_text = 'Expiré';
                                                        break;
                                                    case 'annule':
                                                        $statut_class = 'badge-secondary';
                                                        $statut_icon = '<i class="fas fa-ban"></i>';
                                                        $statut_text = 'Annulé';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge <?= $statut_class ?>">
                                                    <?= $statut_icon ?> <?= $statut_text ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-info" title="Voir"
                                                        onclick="viewDocument('<?= $doc['type'] ?>', <?= (int) $doc['id'] ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <?php if (!empty($doc['fichier'])): ?>
                                                        <a href="<?= base_url($doc['fichier']) ?>" target="_blank"
                                                            class="btn btn-success" title="Télécharger">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-success" title="Aucun fichier"
                                                            disabled>
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    <?php if ($doc['type'] == 'contrat'): ?>
                                                        <button type="button" class="btn btn-warning" title="Modifier">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-warning" title="Relancer">
                                                            <i class="fas fa-bell"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    <button type="button" class="btn btn-danger" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                else:
                                    ?>
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-5">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Aucun devis ou contrat trouvé</p>
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
                                Affichage de 1 à <?= count($all_documents) ?> sur <?= count($all_documents) ?> documents
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers float-right">
                                <ul class="pagination">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">&laquo;</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
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

    <!-- Modal Upload Devis -->
    <div class="modal fade" id="modalUploadDevis">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">
                        <i class="fas fa-file-invoice"></i> Enregistrer un Devis pour un Chantier
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formUploadDevis" method="post" action="<?= base_url('crm-devis-add') ?>"
                    enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Hiérarchie:</strong> Projet → Chantier → Devis
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Projet <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="selectProjetDevis" name="projet_id"
                                        onchange="getChantierId(this)" required>
                                        <option value="">Sélectionner un projet...</option>
                                        <?php foreach ($projects as $project): ?>
                                            <option value="<?= $project->id ?>"><?= $project->reference ?> -
                                                <?= $project->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Chantier <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="selectChantierDevis" name="chantier_id"
                                        required disabled>
                                        <option value="">Sélectionner d'abord le projet...</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Référence du Devis <span class="text-danger">*</span></label>
                                    <input type="text" name="reference" class="form-control"
                                        placeholder="Ex: DEV-2026-001" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Montant Total (DA) <span class="text-danger">*</span></label>
                                    <input type="number" name="montant" class="form-control" placeholder="0.00"
                                        step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date de Création <span class="text-danger">*</span></label>
                                    <input type="date" name="date_creation" class="form-control"
                                        value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date de Signature</label>
                                    <input type="date" name="date_signature" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date d'Expiration <span class="text-danger">*</span></label>
                                    <input type="date" name="date_expiration" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Statut <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="statut" required>
                                <option value="en_attente">En Attente</option>
                                <option value="signe">Signé</option>
                                <option value="expire">Expiré</option>
                                <option value="annule">Annulé</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-upload"></i> Fichier du Devis (PDF) <span class="text-danger">*</span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileDevis" name="fichier_devis"
                                    accept=".pdf" required onchange="previewFile(this)">
                                <label class="custom-file-label" for="fileDevis">
                                    Choisir un fichier PDF...
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Format accepté: PDF | Taille max: 10MB
                            </small>

                            <!-- Aperçu du fichier (caché par défaut) -->
                            <div id="filePreview" class="mt-3" style="display: none;">
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger fa-2x mr-3"></i>
                                        <div>
                                            <strong id="fileName">fichier.pdf</strong><br>
                                            <small class="text-muted" id="fileSize">0 MB</small>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-info mr-2" onclick="viewFile()">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeFile()">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Variable pour stocker le fichier sélectionné
                            var selectedFile = null;

                            // Fonction pour afficher l'aperçu du fichier
                            function previewFile(input) {
                                if (input.files && input.files[0]) {
                                    var file = input.files[0];
                                    selectedFile = file;

                                    // Vérifier le type de fichier
                                    if (file.type !== 'application/pdf') {
                                        alert('Seuls les fichiers PDF sont acceptés !');
                                        input.value = '';
                                        return;
                                    }

                                    // Vérifier la taille (10 MB = 10 * 1024 * 1024 bytes)
                                    var maxSize = 10 * 1024 * 1024;
                                    if (file.size > maxSize) {
                                        alert('La taille du fichier dépasse 10 MB !');
                                        input.value = '';
                                        return;
                                    }

                                    // Afficher les informations du fichier
                                    var fileName = file.name;
                                    var fileSize = (file.size / 1024 / 1024).toFixed(2);

                                    $('#fileName').text(fileName);
                                    $('#fileSize').text(fileSize + ' MB');
                                    $('#filePreview').slideDown();

                                    // Mettre à jour le label du custom-file
                                    $(input).siblings('.custom-file-label').text(fileName);
                                }
                            }

                            // Fonction pour voir le fichier (ouvrir dans un nouvel onglet)
                            function viewFile() {
                                if (selectedFile) {
                                    var fileURL = URL.createObjectURL(selectedFile);
                                    window.open(fileURL, '_blank');
                                }
                            }

                            // Fonction pour supprimer le fichier sélectionné
                            function removeFile() {
                                $('#fileDevis').val('');
                                $('#fileDevis').siblings('.custom-file-label').text('Choisir un fichier PDF...');
                                $('#filePreview').slideUp();
                                selectedFile = null;
                            }

                            // Initialisation
                            $(document).ready(function() {
                                // Gestion de l'affichage du nom de fichier (fallback)
                                $('.custom-file-input').on('change', function() {
                                    var fileName = $(this).val().split('\\').pop();
                                    $(this).siblings('.custom-file-label').addClass('selected').html(
                                        fileName);
                                });
                            });
                        </script>

                        <div class="form-group">
                            <label>Description / Notes</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Description du devis..."></textarea>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function getChantierId(selectElement) {
            const projectId = selectElement.value;
            const chantierSelect = document.getElementById('selectChantierDevis');

            console.log('Project ID selected:', projectId);

            // Clear existing options
            chantierSelect.innerHTML = '<option value="">Chargement...</option>';
            chantierSelect.disabled = true;

            if (projectId) {
                const url = '<?= base_url('crm-chantiers') ?>?project_id=' + projectId;
                console.log('Fetching from:', url);

                // Fetch chantiers for the selected project via AJAX
                fetch(url)
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error('HTTP error ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Chantiers received:', data);

                        // Reset options
                        chantierSelect.innerHTML = '<option value="">Sélectionner un chantier...</option>';

                        if (data && data.length > 0) {
                            data.forEach(chantier => {
                                const option = document.createElement('option');
                                option.value = chantier.id;
                                option.textContent = `${chantier.name} - ${chantier.location || ''}`;
                                chantierSelect.appendChild(option);
                            });
                            chantierSelect.disabled = false;
                            // Trigger select2 update
                            $(chantierSelect).trigger('change');
                        } else {
                            chantierSelect.innerHTML = '<option value="">Aucun chantier trouvé</option>';
                            chantierSelect.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching chantiers:', error);
                        chantierSelect.innerHTML = '<option value="">Erreur: ' + error.message + '</option>';
                        chantierSelect.disabled = true;
                    });
            } else {
                chantierSelect.innerHTML = '<option value="">Sélectionner d\'abord le projet...</option>';
                chantierSelect.disabled = true;
            }
        }

        // Gestion de l'affichage du nom de fichier
        $(document).ready(function() {
            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
            });
        });
    </script>

    <!-- Modal Upload Contrat -->
    <div class="modal fade" id="modalUploadContrat">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">
                        <i class="fas fa-file-contract"></i> Enregistrer un Contrat pour un Chantier
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formUploadContrat" method="post" action="<?= base_url('crm-contrat-add') ?>"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Hiérarchie:</strong> Projet → Chantier → Contrat
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Projet <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="selectProjetContrat" name="projet_id"
                                        onchange="getChantierContrat(this)" required>
                                        <option value="">Sélectionner un projet...</option>
                                        <?php foreach ($projects as $project): ?>
                                            <option value="<?= $project->id ?>"><?= $project->reference ?> -
                                                <?= $project->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Chantier <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="selectChantierContrat" name="chantier_id"
                                        required disabled>
                                        <option value="">Sélectionner d'abord le projet...</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>N° de Contrat <span class="text-danger">*</span></label>
                                    <input type="text" name="numero_contrat" class="form-control"
                                        placeholder="Ex: CNT-2026-001" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type de Contrat <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="type_contrat" required>
                                        <option value="">Sélectionner...</option>
                                        <option value="marche_public">Marché Public</option>
                                        <option value="gre_a_gre">Gré à Gré</option>
                                        <option value="appel_offres">Appel d'Offres</option>
                                        <option value="contrat_prive">Contrat Privé</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Montant du Contrat (DA) <span class="text-danger">*</span></label>
                                    <input type="number" id="montantContrat" name="montant" class="form-control"
                                        placeholder="0.00" step="0.01" min="0" required onchange="calculateTranches()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date de Signature <span class="text-danger">*</span></label>
                                    <input type="date" name="date_signature" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date de Fin Prévue</label>
                                    <input type="date" name="date_fin_prevue" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Délai de Réalisation (mois)</label>
                            <input type="number" name="delai_realisation" class="form-control" placeholder="Ex: 18">
                        </div>

                        <!-- SECTION MODALITÉS DE PAIEMENT -->
                        <div class="card card-info mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-money-bill-wave text-success"></i> Modalités de Paiement
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    Configurez les tranches de paiement selon l'avancement des travaux
                                </div>

                                <div id="tranchesContainer">
                                    <!-- Tranche 1 -->
                                    <div class="row mb-3 tranche-item">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tranche 1 - % du montant</label>
                                                <input type="number" name="tranche1_pourcentage"
                                                    class="form-control tranche-pourcentage" placeholder="30" min="0"
                                                    max="100" step="0.01" value="30" onchange="calculateTranches()">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>À l'avancement de (%)</label>
                                                <input type="number" name="tranche1_avancement" class="form-control"
                                                    placeholder="30" min="0" max="100" value="30">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Montant (DA)</label>
                                                <input type="text" name="tranche1_montant"
                                                    class="form-control tranche-montant" readonly value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Condition</label>
                                                <select name="tranche1_condition" class="form-control">
                                                    <option value="avancement">Selon avancement</option>
                                                    <option value="avance">Avance de démarrage</option>
                                                    <option value="reception_provisoire">Réception provisoire</option>
                                                    <option value="reception_definitive">Réception définitive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tranche 2 -->
                                    <div class="row mb-3 tranche-item">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tranche 2 - % du montant</label>
                                                <input type="number" name="tranche2_pourcentage"
                                                    class="form-control tranche-pourcentage" placeholder="30" min="0"
                                                    max="100" step="0.01" value="30" onchange="calculateTranches()">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>À l'avancement de (%)</label>
                                                <input type="number" name="tranche2_avancement" class="form-control"
                                                    placeholder="60" min="0" max="100" value="60">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Montant (DA)</label>
                                                <input type="text" name="tranche2_montant"
                                                    class="form-control tranche-montant" readonly value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Condition</label>
                                                <select name="tranche2_condition" class="form-control">
                                                    <option value="avancement">Selon avancement</option>
                                                    <option value="avance">Avance de démarrage</option>
                                                    <option value="reception_provisoire">Réception provisoire</option>
                                                    <option value="reception_definitive">Réception définitive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tranche 3 -->
                                    <div class="row mb-3 tranche-item">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tranche 3 - % du montant</label>
                                                <input type="number" name="tranche3_pourcentage"
                                                    class="form-control tranche-pourcentage" placeholder="30" min="0"
                                                    max="100" step="0.01" value="30" onchange="calculateTranches()">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>À l'avancement de (%)</label>
                                                <input type="number" name="tranche3_avancement" class="form-control"
                                                    placeholder="90" min="0" max="100" value="90">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Montant (DA)</label>
                                                <input type="text" name="tranche3_montant"
                                                    class="form-control tranche-montant" readonly value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Condition</label>
                                                <select name="tranche3_condition" class="form-control">
                                                    <option value="avancement">Selon avancement</option>
                                                    <option value="avance">Avance de démarrage</option>
                                                    <option value="reception_provisoire">Réception provisoire</option>
                                                    <option value="reception_definitive">Réception définitive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tranche 4 -->
                                    <div class="row mb-3 tranche-item">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tranche 4 - % du montant</label>
                                                <input type="number" name="tranche4_pourcentage"
                                                    class="form-control tranche-pourcentage" placeholder="8" min="0"
                                                    max="100" step="0.01" value="8" onchange="calculateTranches()">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>À l'avancement de (%)</label>
                                                <input type="number" name="tranche4_avancement" class="form-control"
                                                    placeholder="100" min="0" max="100" value="100">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Montant (DA)</label>
                                                <input type="text" name="tranche4_montant"
                                                    class="form-control tranche-montant" readonly value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Condition</label>
                                                <select name="tranche4_condition" class="form-control">
                                                    <option value="avancement">Selon avancement</option>
                                                    <option value="avance">Avance de démarrage</option>
                                                    <option value="reception_provisoire" selected>Réception provisoire
                                                    </option>
                                                    <option value="reception_definitive">Réception définitive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tranche 5 -->
                                    <div class="row mb-3 tranche-item">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tranche 5 - % du montant</label>
                                                <input type="number" name="tranche5_pourcentage"
                                                    class="form-control tranche-pourcentage" placeholder="2" min="0"
                                                    max="100" step="0.01" value="2" onchange="calculateTranches()">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>À l'avancement de (%)</label>
                                                <input type="number" name="tranche5_avancement" class="form-control"
                                                    placeholder="100" min="0" max="100" value="100">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Montant (DA)</label>
                                                <input type="text" name="tranche5_montant"
                                                    class="form-control tranche-montant" readonly value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Condition</label>
                                                <select name="tranche5_condition" class="form-control">
                                                    <option value="avancement">Selon avancement</option>
                                                    <option value="avance">Avance de démarrage</option>
                                                    <option value="reception_provisoire">Réception provisoire</option>
                                                    <option value="reception_definitive" selected>Réception définitive
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total des tranches -->
                                <div class="alert alert-success mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Total des tranches :</strong>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong id="totalTranches">0%</strong>
                                            <span id="totalTranchesAlert" class="text-danger ml-2"
                                                style="display:none;">
                                                <i class="fas fa-exclamation-triangle"></i> Le total doit être 100%
                                            </span>
                                            <span id="totalTranchesOK" class="text-success ml-2" style="display:none;">
                                                <i class="fas fa-check-circle"></i> OK
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN SECTION MODALITÉS DE PAIEMENT -->

                        <div class="form-group">
                            <label>
                                <i class="fas fa-upload"></i> Fichier du Contrat (PDF) <span
                                    class="text-danger">*</span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileContrat" name="fichier_contrat"
                                    accept=".pdf" required onchange="previewFileContrat(this)">
                                <label class="custom-file-label" for="fileContrat">
                                    Choisir un fichier PDF...
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Format accepté: PDF | Taille max: 10MB
                            </small>

                            <!-- Aperçu du fichier (caché par défaut) -->
                            <div id="filePreviewContrat" class="mt-3" style="display: none;">
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger fa-2x mr-3"></i>
                                        <div>
                                            <strong id="fileNameContrat">fichier.pdf</strong><br>
                                            <small class="text-muted" id="fileSizeContrat">0 MB</small>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-info mr-2"
                                            onclick="viewFileContrat()">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="removeFileContrat()">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Clauses et Conditions</label>
                            <textarea name="clauses" class="form-control" rows="3"
                                placeholder="Description des clauses..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Variable pour stocker le fichier sélectionné
        var selectedFileContrat = null;

        // Fonction pour charger les chantiers selon le projet sélectionné
        function getChantierContrat(selectElement) {
            const projectId = selectElement.value;
            const chantierSelect = document.getElementById('selectChantierContrat');

            chantierSelect.innerHTML = '<option value="">Chargement...</option>';
            chantierSelect.disabled = true;

            if (projectId) {
                const url = '<?= base_url('crm-chantiers') ?>?project_id=' + projectId;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        chantierSelect.innerHTML = '<option value="">Sélectionner un chantier...</option>';

                        if (data && data.length > 0) {
                            data.forEach(chantier => {
                                const option = document.createElement('option');
                                option.value = chantier.id;
                                option.textContent = `${chantier.name} - ${chantier.location || ''}`;
                                chantierSelect.appendChild(option);
                            });
                            chantierSelect.disabled = false;
                            $(chantierSelect).trigger('change');
                        } else {
                            chantierSelect.innerHTML = '<option value="">Aucun chantier trouvé</option>';
                            chantierSelect.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching chantiers:', error);
                        chantierSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                        chantierSelect.disabled = true;
                    });
            } else {
                chantierSelect.innerHTML = '<option value="">Sélectionner d\'abord le projet...</option>';
                chantierSelect.disabled = true;
            }
        }

        // Fonction pour afficher l'aperçu du fichier
        function previewFileContrat(input) {
            if (input.files && input.files[0]) {
                var file = input.files[0];
                selectedFileContrat = file;

                // Vérifier le type de fichier
                if (file.type !== 'application/pdf') {
                    alert('Seuls les fichiers PDF sont acceptés !');
                    input.value = '';
                    return;
                }

                // Vérifier la taille (10 MB)
                var maxSize = 10 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('La taille du fichier dépasse 10 MB !');
                    input.value = '';
                    return;
                }

                // Afficher les informations du fichier
                var fileName = file.name;
                var fileSize = (file.size / 1024 / 1024).toFixed(2);

                $('#fileNameContrat').text(fileName);
                $('#fileSizeContrat').text(fileSize + ' MB');
                $('#filePreviewContrat').slideDown();

                $(input).siblings('.custom-file-label').text(fileName);
            }
        }

        // Fonction pour voir le fichier
        function viewFileContrat() {
            if (selectedFileContrat) {
                var fileURL = URL.createObjectURL(selectedFileContrat);
                window.open(fileURL, '_blank');
            }
        }

        // Fonction pour supprimer le fichier sélectionné
        function removeFileContrat() {
            $('#fileContrat').val('');
            $('#fileContrat').siblings('.custom-file-label').text('Choisir un fichier PDF...');
            $('#filePreviewContrat').slideUp();
            selectedFileContrat = null;
        }

        // Initialisation
        $(document).ready(function() {
            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
            });
        });
    </script>

    <script>
        // Fonction pour calculer automatiquement les montants des tranches
        function calculateTranches() {
            var montantTotal = parseFloat($('#montantContrat').val()) || 0;
            var totalPourcentages = 0;

            // Calculer pour chaque tranche
            for (var i = 1; i <= 5; i++) {
                var pourcentage = parseFloat($('input[name="tranche' + i + '_pourcentage"]').val()) || 0;
                var montant = (montantTotal * pourcentage / 100).toFixed(2);

                $('input[name="tranche' + i + '_montant"]').val(formatNumber(montant) + ' DA');
                totalPourcentages += pourcentage;
            }

            // Mettre à jour le total
            $('#totalTranches').text(totalPourcentages.toFixed(2) + '%');

            if (totalPourcentages === 100) {
                $('#totalTranchesOK').show();
                $('#totalTranchesAlert').hide();
            } else {
                $('#totalTranchesOK').hide();
                $('#totalTranchesAlert').show();
            }
        }

        // Fonction pour formater les nombres
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }

        // Variable pour stocker le fichier sélectionné
        var selectedFileContrat = null;

        // Fonction pour charger les chantiers selon le projet sélectionné
        function getChantierContrat(selectElement) {
            const projectId = selectElement.value;
            const chantierSelect = document.getElementById('selectChantierContrat');

            chantierSelect.innerHTML = '<option value="">Chargement...</option>';
            chantierSelect.disabled = true;

            if (projectId) {
                const url = '<?= base_url('crm-chantiers') ?>?project_id=' + projectId;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        chantierSelect.innerHTML = '<option value="">Sélectionner un chantier...</option>';

                        if (data && data.length > 0) {
                            data.forEach(chantier => {
                                const option = document.createElement('option');
                                option.value = chantier.id;
                                option.textContent = `${chantier.name} - ${chantier.location || ''}`;
                                chantierSelect.appendChild(option);
                            });
                            chantierSelect.disabled = false;
                            $(chantierSelect).trigger('change');
                        } else {
                            chantierSelect.innerHTML = '<option value="">Aucun chantier trouvé</option>';
                            chantierSelect.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching chantiers:', error);
                        chantierSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                        chantierSelect.disabled = true;
                    });
            } else {
                chantierSelect.innerHTML = '<option value="">Sélectionner d\'abord le projet...</option>';
                chantierSelect.disabled = true;
            }
        }

        // Fonction pour afficher l'aperçu du fichier
        function previewFileContrat(input) {
            if (input.files && input.files[0]) {
                var file = input.files[0];
                selectedFileContrat = file;

                // Vérifier le type de fichier
                if (file.type !== 'application/pdf') {
                    alert('Seuls les fichiers PDF sont acceptés !');
                    input.value = '';
                    return;
                }

                // Vérifier la taille (10 MB)
                var maxSize = 10 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('La taille du fichier dépasse 10 MB !');
                    input.value = '';
                    return;
                }

                // Afficher les informations du fichier
                var fileName = file.name;
                var fileSize = (file.size / 1024 / 1024).toFixed(2);

                $('#fileNameContrat').text(fileName);
                $('#fileSizeContrat').text(fileSize + ' MB');
                $('#filePreviewContrat').slideDown();

                $(input).siblings('.custom-file-label').text(fileName);
            }
        }

        // Fonction pour voir le fichier
        function viewFileContrat() {
            if (selectedFileContrat) {
                var fileURL = URL.createObjectURL(selectedFileContrat);
                window.open(fileURL, '_blank');
            }
        }

        // Fonction pour supprimer le fichier sélectionné
        function removeFileContrat() {
            $('#fileContrat').val('');
            $('#fileContrat').siblings('.custom-file-label').text('Choisir un fichier PDF...');
            $('#filePreviewContrat').slideUp();
            selectedFileContrat = null;
        }

        // Initialisation
        $(document).ready(function() {
            // Gestion de l'affichage du nom de fichier (fallback)
            $('.c`ustom-file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
            });

            // Calcul initial
            calculateTranches();
        });
    </script>

    <!-- Modal View Devis/Contrat -->
    <div class="modal fade" id="modalViewDevis">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="viewDocTitle">
                        <i class="fas fa-eye"></i> Détails du Document
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Chargement -->
                    <div id="viewDocLoading" class="text-center py-5">
                        <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                        <p class="text-muted mt-2">Chargement...</p>
                    </div>

                    <!-- Erreur -->
                    <div id="viewDocError" class="alert alert-danger" style="display:none;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span id="viewDocErrorMessage">Impossible de charger le document.</span>
                    </div>

                    <!-- Contenu -->
                    <div id="viewDocBody" style="display:none;">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-muted mb-0" id="viewDocMeta"></p>
                            </div>
                            <div class="col-md-4 text-right" id="viewDocStatut"></div>
                        </div>

                        <hr>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Montant</span>
                                        <span class="info-box-number" id="viewDocMontant">-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success">
                                        <i class="fas fa-calendar-check"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Signature</span>
                                        <span class="info-box-number" id="viewDocDateSignature">-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning">
                                        <i class="fas fa-calendar-times"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" id="viewDocDateLabel">Expiration</span>
                                        <span class="info-box-number" id="viewDocDateExpiration">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong id="viewDocDescriptionLabel">Description :</strong><br>
                            <span id="viewDocDescription">-</span>
                        </div>

                        <!-- Tranches de paiement (contrats uniquement) -->
                        <div id="viewTranchesSection" style="display:none;">
                            <h5 class="mt-4">
                                <i class="fas fa-money-check-alt text-success"></i> Tranches de Paiement
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Tranche</th>
                                            <th>% du montant</th>
                                            <th>Avancement requis</th>
                                            <th>Montant</th>
                                            <th>Condition</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody id="viewTranchesBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-center mt-4" id="viewDocFileButtons">
                            <a href="#" target="_blank" id="viewDocOpenPdf" class="btn btn-primary btn-lg">
                                <i class="fas fa-file-pdf"></i> Voir le PDF
                            </a>
                            <a href="#" download id="viewDocDownloadPdf" class="btn btn-success btn-lg ml-2">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times"></i> Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <script>
        var crmBaseUrl = '<?= base_url() ?>';
        var crmDevisViewUrl = '<?= base_url('crm-devis-view') ?>';
        var crmContratViewUrl = '<?= base_url('crm-contrat-view') ?>';

        // Ouvre le modal et charge les détails d'un devis ou d'un contrat en AJAX
        function viewDocument(type, id) {
            var url = (type === 'contrat' ? crmContratViewUrl : crmDevisViewUrl) + '/' + id;

            $('#modalViewDevis').modal('show');
            $('#viewDocLoading').show();
            $('#viewDocError').hide();
            $('#viewDocBody').hide();

            fetch(url)
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }
                    return response.json();
                })
                .then(function(data) {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    renderViewDocument(data);
                })
                .catch(function(error) {
                    console.error('Erreur chargement document:', error);
                    $('#viewDocLoading').hide();
                    $('#viewDocErrorMessage').text(error.message || 'Impossible de charger le document.');
                    $('#viewDocError').show();
                });
        }

        function renderViewDocument(data) {
            var isContrat = data.type === 'contrat';
            var doc = isContrat ? data.contrat : data.devis;

            var reference = isContrat ? doc.numero_contrat : doc.reference;
            var icon = isContrat ? 'fa-file-contract' : 'fa-file-invoice';
            var typeLabel = isContrat ? 'Contrat' : 'Devis';

            $('#viewDocTitle').html(
                '<i class="fas ' + icon + '"></i> ' + typeLabel + ' N° ' + escapeHtml(reference)
            );
            $('#viewDocMeta').html(
                '<strong>Projet:</strong> ' + escapeHtml(doc.projet_name || '-') +
                ' (' + escapeHtml(doc.projet_reference || '-') + ')<br>' +
                '<strong>Chantier:</strong> ' + escapeHtml(doc.chantier_name || '-') + '<br>' +
                '<strong>Localisation:</strong> ' + escapeHtml(doc.chantier_location || '-')
            );
            $('#viewDocStatut').html(renderStatutBadge(doc.statut));

            $('#viewDocMontant').text(formatMontant(doc.montant) + ' DA');
            $('#viewDocDateSignature').text(doc.date_signature ? formatDate(doc.date_signature) : '-');

            $('#viewDocDateLabel').text(isContrat ? 'Fin Prévue' : 'Expiration');
            var dateFin = isContrat ? doc.date_fin_prevue : doc.date_expiration;
            $('#viewDocDateExpiration').text(dateFin ? formatDate(dateFin) : '-');

            $('#viewDocDescriptionLabel').text(isContrat ? 'Clauses et Conditions :' : 'Description :');
            $('#viewDocDescription').text(
                (isContrat ? doc.clauses : doc.description) || 'Aucune information renseignée.'
            );

            var fichier = isContrat ? doc.fichier_contrat : doc.fichier_devis;
            if (fichier) {
                $('#viewDocFileButtons').show();
                $('#viewDocOpenPdf').attr('href', crmBaseUrl + fichier);
                $('#viewDocDownloadPdf').attr('href', crmBaseUrl + fichier);
            } else {
                $('#viewDocFileButtons').hide();
            }

            if (isContrat) {
                $('#viewTranchesSection').show();
                renderTranches(data.tranches || []);
            } else {
                $('#viewTranchesSection').hide();
            }

            $('#viewDocLoading').hide();
            $('#viewDocError').hide();
            $('#viewDocBody').show();
        }

        function renderTranches(tranches) {
            var body = $('#viewTranchesBody');
            body.empty();

            if (!tranches.length) {
                body.append('<tr><td colspan="6" class="text-center text-muted">Aucune tranche enregistrée.</td></tr>');
                return;
            }

            tranches.forEach(function(t) {
                body.append(
                    '<tr>' +
                    '<td>' + t.numero_tranche + '</td>' +
                    '<td>' + parseFloat(t.pourcentage) + '%</td>' +
                    '<td>' + (t.avancement_requis !== null ? parseFloat(t.avancement_requis) + '%' : '-') +
                    '</td>' +
                    '<td>' + formatMontant(t.montant) + ' DA</td>' +
                    '<td>' + escapeHtml(t.condition_paiement || '-') + '</td>' +
                    '<td>' + renderTrancheStatutBadge(t.statut) + '</td>' +
                    '</tr>'
                );
            });
        }

        function renderStatutBadge(statut) {
            var map = {
                signe: ['badge-success', 'fa-check-circle', 'Signé'],
                en_attente: ['badge-warning', 'fa-clock', 'En Attente'],
                expire: ['badge-danger', 'fa-times-circle', 'Expiré'],
                annule: ['badge-secondary', 'fa-ban', 'Annulé']
            };
            var v = map[statut] || ['badge-secondary', 'fa-question', statut || '-'];
            return '<span class="badge ' + v[0] + ' badge-lg"><i class="fas ' + v[1] + '"></i> ' + v[2] + '</span>';
        }

        function renderTrancheStatutBadge(statut) {
            var map = {
                paye: ['badge-success', 'fa-check-circle', 'Payée'],
                en_attente: ['badge-warning', 'fa-clock', 'En attente'],
                retard: ['badge-danger', 'fa-exclamation-triangle', 'En retard']
            };
            var v = map[statut] || ['badge-secondary', 'fa-question', statut || '-'];
            return '<span class="badge ' + v[0] + '"><i class="fas ' + v[1] + '"></i> ' + v[2] + '</span>';
        }

        function formatMontant(val) {
            var num = parseFloat(val) || 0;
            return num.toLocaleString('fr-FR', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        function formatDate(dateStr) {
            var d = new Date(dateStr);
            if (isNaN(d.getTime())) {
                return dateStr;
            }
            var day = String(d.getDate()).padStart(2, '0');
            var month = String(d.getMonth() + 1).padStart(2, '0');
            return day + '/' + month + '/' + d.getFullYear();
        }

        function escapeHtml(str) {
            if (str === null || str === undefined) {
                return '';
            }
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }
    </script>

</div>
<!-- /.content-wrapper -->

<script>
    $(document).ready(function() {
        // Gestion de l'affichage du nom de fichier
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
        });

        // Select2
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Sélectionner...',
            allowClear: true
        });

        // Données des chantiers par projet (simulation)
        var chantiersParProjet = {
            '1': [{
                    id: '1',
                    name: 'Bâtiment Principal - Oran Campus'
                },
                {
                    id: '2',
                    name: 'Laboratoires - Oran Campus'
                },
                {
                    id: '3',
                    name: 'Parking - Oran Campus'
                }
            ],
            '2': [{
                    id: '4',
                    name: 'Bloc Chirurgie - Annaba'
                },
                {
                    id: '5',
                    name: 'Urgences - Annaba'
                },
                {
                    id: '6',
                    name: 'Hospitalisation - Annaba'
                }
            ],
            '3': [{
                    id: '7',
                    name: 'Stade Principal - Constantine'
                },
                {
                    id: '8',
                    name: 'Piscine Olympique - Constantine'
                }
            ]
        };

        // Gestion changement projet pour Devis
        $('#selectProjetDevis').on('change', function() {
            var projetId = $(this).val();
            var selectChantier = $('#selectChantierDevis');

            selectChantier.empty().append('<option value="">Sélectionner un chantier...</option>');

            if (projetId && chantiersParProjet[projetId]) {
                chantiersParProjet[projetId].forEach(function(chantier) {
                    selectChantier.append('<option value="' + chantier.id + '">' + chantier.name +
                        '</option>');
                });
                selectChantier.prop('disabled', false);
            } else {
                selectChantier.prop('disabled', true);
            }

            selectChantier.trigger('change');
        });

        // Gestion changement projet pour Contrat
        $('#selectProjetContrat').on('change', function() {
            var projetId = $(this).val();
            var selectChantier = $('#selectChantierContrat');

            selectChantier.empty().append('<option value="">Sélectionner un chantier...</option>');

            if (projetId && chantiersParProjet[projetId]) {
                chantiersParProjet[projetId].forEach(function(chantier) {
                    selectChantier.append('<option value="' + chantier.id + '">' + chantier.name +
                        '</option>');
                });
                selectChantier.prop('disabled', false);
            } else {
                selectChantier.prop('disabled', true);
            }

            selectChantier.trigger('change');
        });

        // Filtrage par projet
        $('#filterProjet').on('change', function() {
            var projetId = $(this).val();
            var selectChantier = $('#filterChantier');

            selectChantier.empty().append('<option value="">Tous les chantiers</option>');

            if (projetId && chantiersParProjet[projetId]) {
                chantiersParProjet[projetId].forEach(function(chantier) {
                    selectChantier.append('<option value="' + chantier.id + '">' + chantier.name +
                        '</option>');
                });
            }
        });
    });
</script>


<script>
    // Appliquer tous les filtres
    function applyFilters() {
        var searchTerm = $('#searchInput').val().toLowerCase();
        var projetFilter = $('#filterProjet').val();
        var chantierFilter = $('#filterChantier').val();
        var typeFilter = $('#filterType').val();
        var statutFilter = $('#filterStatut').val();

        var visibleCount = 0;

        // Filtrer les lignes du tableau
        $('#documentsTable tbody tr').each(function() {
            var row = $(this);
            var showRow = true;

            // Recherche textuelle
            if (searchTerm) {
                var rowText = row.text().toLowerCase();
                if (rowText.indexOf(searchTerm) === -1) {
                    showRow = false;
                }
            }

            // Filtre par projet
            if (projetFilter && row.data('projet-id') != projetFilter) {
                showRow = false;
            }

            // Filtre par chantier
            if (chantierFilter && row.data('chantier-id') != chantierFilter) {
                showRow = false;
            }

            // Filtre par type
            if (typeFilter && row.data('type') != typeFilter) {
                showRow = false;
            }

            // Filtre par statut
            if (statutFilter && row.data('statut') != statutFilter) {
                showRow = false;
            }

            // Afficher/masquer la ligne
            row.toggle(showRow);
            if (showRow) {
                visibleCount++;
            }
        });

        // Mettre à jour la pagination et le compteur
        updatePagination(visibleCount);
        updateFilterCount();
    }

    // Mettre à jour la pagination
    function updatePagination(visibleCount) {
        var totalCount = $('#documentsTable tbody tr').length;
        $('.dataTables_info').text(
            'Affichage de 1 à ' + visibleCount + ' sur ' + totalCount + ' documents'
        );
    }

    // Mettre à jour le compteur de filtres actifs
    function updateFilterCount() {
        var activeFilters = 0;
        if ($('#filterProjet').val()) activeFilters++;
        if ($('#filterChantier').val()) activeFilters++;
        if ($('#filterType').val()) activeFilters++;
        if ($('#filterStatut').val()) activeFilters++;
        if ($('#searchInput').val()) activeFilters++;

        if (activeFilters > 0) {
            $('#filterCount').text('(' + activeFilters + ' filtre(s) actif(s))');
        } else {
            $('#filterCount').text('');
        }
    }

    // Réinitialiser tous les filtres
    function resetFilters() {
        $('#searchInput').val('');
        $('#filterProjet').val('').trigger('change.select2');
        $('#filterChantier').val('').trigger('change.select2');
        $('#filterType').val('').trigger('change.select2');
        $('#filterStatut').val('').trigger('change.select2');

        // Afficher toutes les lignes
        $('#documentsTable tbody tr').show();

        // Mettre à jour la pagination
        var totalCount = $('#documentsTable tbody tr').length;
        updatePagination(totalCount);
        updateFilterCount();
    }

    // Mettre à jour les chantiers selon le projet sélectionné
    $('#filterProjet').on('change', function() {
        var projectId = $(this).val();
        var chantierSelect = $('#filterChantier');

        // Sauvegarder la valeur actuelle
        var currentVal = chantierSelect.val();

        chantierSelect.empty().append('<option value="">Tous les chantiers</option>');

        if (projectId) {
            // Récupérer les chantiers uniques pour ce projet
            var chantiers = [];
            $('#documentsTable tbody tr').each(function() {
                var row = $(this);
                if (row.data('projet-id') == projectId && row.data('chantier-id')) {
                    var chantierId = row.data('chantier-id');
                    var chantierName = row.find('td').eq(4).find('strong').text();

                    var alreadyExists = chantiers.some(function(c) {
                        return c.id === chantierId;
                    });

                    if (!alreadyExists && chantierName) {
                        chantiers.push({
                            id: chantierId,
                            name: chantierName
                        });
                    }
                }
            });

            // Trier par nom
            chantiers.sort(function(a, b) {
                return a.name.localeCompare(b.name);
            });

            // Ajouter les options
            chantiers.forEach(function(chantier) {
                chantierSelect.append(
                    '<option value="' + chantier.id + '">' + chantier.name + '</option>'
                );
            });
        }

        // Restaurer la valeur si elle existe encore
        if (currentVal && chantierSelect.find('option[value="' + currentVal + '"]').length > 0) {
            chantierSelect.val(currentVal);
        }

        chantierSelect.trigger('change.select2');
    });

    // Initialisation
    $(document).ready(function() {
        // Bouton Enter dans la recherche
        $('#searchInput').on('keypress', function(e) {
            if (e.which === 13) {
                applyFilters();
            }
        });

        // Initialiser Select2
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: function() {
                return $(this).find('option:first').text();
            },
            allowClear: true
        });

        // Compteur initial
        updateFilterCount();
    });
</script>