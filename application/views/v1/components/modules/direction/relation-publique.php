<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-handshake text-primary mr-2"></i>
                        <?= $title ?>
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
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Messages Flash -->
            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-1"></i>
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle mr-1"></i>
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?>

            <!-- ============================================== -->
            <!-- CARTES KPI - RÉSUMÉ DES SORTIES CAISSE         -->
            <!-- ============================================== -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= number_format($statistiques['total_montant'] ?? 0, 0, ',', ' ') ?></h3>
                            <p>Total Sorties (Mois)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <span class="small-box-footer">
                            Caisse Principale <i class="fas fa-arrow-circle-right"></i>
                        </span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $statistiques['total_sorties'] ?? 0 ?></h3>
                            <p>Sorties Effectuées</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <span class="small-box-footer">
                            Ce mois-ci <i class="fas fa-arrow-circle-right"></i>
                        </span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php
                            // Récupérer le solde de la caisse principale
                            $this->db->select('current_balance');
                            $this->db->from('tbl_finance_cashbox');
                            $this->db->where('role', 'principale');
                            $this->db->where('status', 'active');
                            $solde = $this->db->get()->row()->current_balance ?? 0;
                            ?>
                            <h3><?= number_format($solde, 0, ',', ' ') ?></h3>
                            <p>Solde Caisse Principale</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <span class="small-box-footer">
                            Disponible <i class="fas fa-arrow-circle-right"></i>
                        </span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $statistiques['total_en_attente'] ?? 0 ?></h3>
                            <p>En Attente Validation</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="small-box-footer">
                            À approuver <i class="fas fa-arrow-circle-right"></i>
                        </span>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- ============================================== -->
            <!-- FORMULAIRE DE SORTIE CAISSE                    -->
            <!-- ============================================== -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-hand-holding-usd mr-1"></i>
                                Nouvelle Sortie Caisse
                            </h3>
                        </div>
                        <form id="formSortieCaisse" method="post" action="<?= base_url('save-relations-publique') ?>">
                            <!-- CSRF Token -->
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                                value="<?= $this->security->get_csrf_hash() ?>">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="beneficiaire">
                                        <i class="fas fa-user mr-1"></i> Bénéficiaire <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="beneficiaire" name="beneficiaire"
                                        placeholder="Nom du bénéficiaire" required maxlength="150">
                                </div>

                                <div class="form-group">
                                    <label for="montant">
                                        <i class="fas fa-money-bill mr-1"></i> Montant (BIF) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" id="montant" name="montant"
                                        placeholder="0" min="1000" step="100" required>
                                    <small class="form-text text-muted">Montant minimum : 1 000 BIF</small>
                                </div>

                                <div class="form-group">
                                    <label for="motif">
                                        <i class="fas fa-comment-dots mr-1"></i> Motif de la sortie <span
                                            class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" id="motif" name="motif" rows="3"
                                        placeholder="Décrire le motif de la sortie de caisse..." required
                                        maxlength="500"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="date_sortie">
                                        <i class="fas fa-calendar mr-1"></i> Date de sortie <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="date_sortie" name="date_sortie"
                                        value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="autorise_par">
                                        <i class="fas fa-user-tie mr-1"></i> Autorisé par <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select class="form-control" id="autorise_par" name="autorise_par" required>
                                        <option value="">-- Sélectionner --</option>
                                        <option value="dg">Directeur Général</option>
                                        <option value="daf">DAF / Finance</option>
                                        <option value="admin">Administrateur</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="reference">
                                        <i class="fas fa-hashtag mr-1"></i> Référence (optionnel)
                                    </label>
                                    <input type="text" class="form-control" id="reference" name="reference"
                                        placeholder="N° de référence (auto-généré si vide)" maxlength="100">
                                </div>

                                <div class="form-group">
                                    <label for="observation">
                                        <i class="fas fa-sticky-note mr-1"></i> Observation
                                    </label>
                                    <textarea class="form-control" id="observation" name="observation" rows="2"
                                        placeholder="Observations complémentaires..." maxlength="500"></textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-block" id="btnSubmit">
                                    <i class="fas fa-save mr-1"></i> Enregistrer la Sortie
                                </button>
                                <button type="button" class="btn btn-secondary btn-block mt-2" onclick="resetForm()">
                                    <i class="fas fa-times mr-1"></i> Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ============================================== -->
                <!-- TABLEAU DES SORTIES RÉCENTES                   -->
                <!-- ============================================== -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list mr-1"></i>
                                Relations Publiques et Transefert via Lumicash
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#modalExport">
                                    <i class="fas fa-download mr-1"></i> Exporter
                                </button>
                                <button type="button" class="btn btn-sm btn-default" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Filtres -->
                        <div class="card-body border-bottom">
                            <form id="formFiltres" method="get" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="filtre_date_debut">
                                                <i class="fas fa-calendar-alt mr-1"></i> Date début
                                            </label>
                                            <input type="date" class="form-control form-control-sm"
                                                id="filtre_date_debut" name="date_debut"
                                                value="<?= htmlspecialchars($filtre_date_debut ?? date('Y-m-01')) ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="filtre_date_fin">
                                                <i class="fas fa-calendar-alt mr-1"></i> Date fin
                                            </label>
                                            <input type="date" class="form-control form-control-sm" id="filtre_date_fin"
                                                name="date_fin"
                                                value="<?= htmlspecialchars($filtre_date_fin ?? date('Y-m-d')) ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="filtre_beneficiaire">
                                                <i class="fas fa-user mr-1"></i> Bénéficiaire
                                            </label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="filtre_beneficiaire" name="beneficiaire" placeholder="Rechercher..."
                                                value="<?= htmlspecialchars($filtre_beneficiaire ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="filtre_statut">
                                                <i class="fas fa-check-circle mr-1"></i> Statut
                                            </label>
                                            <select class="form-control form-control-sm" id="filtre_statut"
                                                name="statut">
                                                <option value="">Tous les statuts</option>
                                                <option value="valide"
                                                    <?= ($filtre_statut ?? '') === 'valide' ? 'selected' : '' ?>>
                                                    Validé
                                                </option>
                                                <option value="en_attente"
                                                    <?= ($filtre_statut ?? '') === 'en_attente' ? 'selected' : '' ?>>
                                                    En attente
                                                </option>
                                                <option value="rejete"
                                                    <?= ($filtre_statut ?? '') === 'rejete' ? 'selected' : '' ?>>
                                                    Rejeté
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-sm mr-2">
                                            <i class="fas fa-filter mr-1"></i> Filtrer
                                        </button>
                                        <a href="<?= current_url() ?>" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-redo mr-1"></i> Réinitialiser
                                        </a>
                                        <span class="text-muted ml-3" id="nbResultats">
                                            <?= count($sorties) ?> résultat(s)
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-body">
                            <?php if (empty($sorties)): ?>
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Aucune sortie enregistrée pour cette période</p>
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="tableSorties">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 8%">N°</th>
                                            <th style="width: 12%">Date</th>
                                            <th style="width: 20%">Bénéficiaire</th>
                                            <th style="width: 20%">Motif</th>
                                            <th style="width: 12%" class="text-right">Montant (BIF)</th>
                                            <th style="width: 10%">Autorisé par</th>
                                            <th style="width: 8%">Statut</th>
                                            <th style="width: 10%" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $total_affiche = 0;
                                            foreach ($sorties as $sortie):
                                                $total_affiche += $sortie->montant;
                                            ?>
                                        <tr id="row-<?= $sortie->id ?>">
                                            <td><strong><?= htmlspecialchars($sortie->reference) ?></strong></td>
                                            <td><?= date('d/m/Y', strtotime($sortie->date_sortie)) ?></td>
                                            <td><?= htmlspecialchars($sortie->beneficiaire) ?></td>
                                            <td><?= htmlspecialchars($sortie->motif) ?></td>
                                            <td class="text-right">
                                                <strong><?= number_format($sortie->montant, 0, ',', ' ') ?></strong>
                                            </td>
                                            <td>
                                                <?php
                                                        $libelles = [
                                                            'dg' => 'Directeur Général',
                                                            'daf' => 'DAF / Finance',
                                                            'admin' => 'Administrateur'
                                                        ];
                                                        echo htmlspecialchars($libelles[$sortie->autorise_par] ?? $sortie->autorise_par);
                                                        ?>
                                            </td>
                                            <td>
                                                <?php if ($sortie->status == 'valide'): ?>
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check mr-1"></i>Validé
                                                </span>
                                                <?php elseif ($sortie->status == 'en_attente'): ?>
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-clock mr-1"></i>En attente
                                                </span>
                                                <?php else: ?>
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-times mr-1"></i>Rejeté
                                                </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                        // Échapper les apostrophes pour JavaScript
                                                        $js_reference = str_replace("'", "\\'", $sortie->reference);
                                                        $js_date = date('d/m/Y', strtotime($sortie->date_sortie));
                                                        $js_beneficiaire = str_replace("'", "\\'", $sortie->beneficiaire);
                                                        $js_montant = number_format($sortie->montant, 0, ',', ' ');
                                                        $js_motif = str_replace("'", "\\'", $sortie->motif);
                                                        $js_autorise = str_replace("'", "\\'", $libelles[$sortie->autorise_par] ?? $sortie->autorise_par);
                                                        $js_observation = str_replace("'", "\\'", $sortie->observation ?? '');
                                                        $js_created = date('d/m/Y H:i', strtotime($sortie->created_at));
                                                        ?>

                                                <button type="button" class="btn btn-sm btn-info btn-view"
                                                    onclick="viewDetails('<?= $js_reference ?>','<?= $js_date ?>','<?= $js_beneficiaire ?>','<?= $js_montant ?>','<?= $js_motif ?>','<?= $js_autorise ?>','<?= $js_observation ?>','<?= $js_created ?>')"
                                                    title="Voir les détails">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                    onclick="confirmDelete(<?= $sortie->id ?>,'<?= $js_reference ?>',<?= $sortie->montant ?>)"
                                                    title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr class="font-weight-bold">
                                            <td colspan="4" class="text-right">Total affiché:</td>
                                            <td class="text-right text-primary">
                                                <?= number_format($total_affiche, 0, ',', ' ') ?> BIF</td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Modal Voir les détails -->
                <div class="modal fade" id="modalViewDetails">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h4 class="modal-title">
                                    <i class="fas fa-file-invoice mr-2"></i>
                                    Détails de la sortie <span id="viewReference"></span>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%"><i class="fas fa-hashtag mr-1"></i> Référence</th>
                                        <td id="viewRef"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-calendar mr-1"></i> Date de sortie</th>
                                        <td id="viewDate"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-user mr-1"></i> Bénéficiaire</th>
                                        <td id="viewBeneficiaire"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-money-bill mr-1"></i> Montant</th>
                                        <td id="viewMontant" class="text-primary font-weight-bold"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-comment mr-1"></i> Motif</th>
                                        <td id="viewMotif"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-user-tie mr-1"></i> Autorisé par</th>
                                        <td id="viewAutorise"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-sticky-note mr-1"></i> Observation</th>
                                        <td id="viewObservation"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-clock mr-1"></i> Créé le</th>
                                        <td id="viewCreated"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="button" class="btn btn-primary" onclick="window.print()">
                                    <i class="fas fa-print mr-1"></i> Imprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SweetAlert2 CSS -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <!-- SweetAlert2 JS -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                /**
                 * Afficher les détails d'une sortie
                 */
                function viewDetails(reference, date, beneficiaire, montant, motif, autorise, observation, created) {
                    document.getElementById('viewReference').textContent = reference;
                    document.getElementById('viewRef').textContent = reference;
                    document.getElementById('viewDate').textContent = date;
                    document.getElementById('viewBeneficiaire').textContent = beneficiaire;
                    document.getElementById('viewMontant').textContent = montant + ' BIF';
                    document.getElementById('viewMotif').textContent = motif;
                    document.getElementById('viewAutorise').textContent = autorise;
                    document.getElementById('viewObservation').textContent = observation || '-';
                    document.getElementById('viewCreated').textContent = created;

                    $('#modalViewDetails').modal('show');
                }

                /**
                 * Confirmer et supprimer une sortie
                 */
                function confirmDelete(id, reference, montant) {
                    Swal.fire({
                        title: 'Confirmer la suppression ?',
                        html: `
            <div class="text-left">
                <p><strong>Référence :</strong> ${reference}</p>
                <p><strong>Montant :</strong> ${new Intl.NumberFormat('fr-FR').format(montant)} BIF</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> 
                Cette action supprimera également le mouvement dans le livre de caisse principale.</p>
            </div>
        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-trash mr-1"></i> Oui, supprimer !',
                        cancelButtonText: '<i class="fas fa-times mr-1"></i> Annuler',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Afficher un loading
                            Swal.fire({
                                title: 'Suppression en cours...',
                                text: 'Veuillez patienter',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Requête AJAX pour supprimer
                            $.ajax({
                                url: '<?= base_url("direction/delete-sortie-rp") ?>',
                                type: 'POST',
                                data: {
                                    id: id,
                                    '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        // Supprimer la ligne du tableau
                                        $('#row-' + id).fadeOut(300, function() {
                                            $(this).remove();
                                        });

                                        // Recharger la page pour mettre à jour les statistiques
                                        setTimeout(function() {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Supprimé !',
                                                text: response.message,
                                                timer: 2000,
                                                showConfirmButton: false
                                            }).then(() => {
                                                location.reload();
                                            });
                                        }, 300);
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Erreur',
                                            text: response.message ||
                                                'Une erreur est survenue lors de la suppression.'
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Erreur AJAX:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erreur',
                                        text: 'Une erreur de communication est survenue. Vérifiez la console (F12).'
                                    });
                                }
                            });
                        }
                    });
                }
                </script>

                <!-- Modal Voir les détails (à placer avant le script) -->
                <div class="modal fade" id="modalViewDetails">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h4 class="modal-title">
                                    <i class="fas fa-file-invoice mr-2"></i>
                                    Détails de la sortie <span id="viewReference"></span>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%"><i class="fas fa-hashtag mr-1"></i> Référence</th>
                                        <td id="viewRef"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-calendar mr-1"></i> Date de sortie</th>
                                        <td id="viewDate"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-user mr-1"></i> Bénéficiaire</th>
                                        <td id="viewBeneficiaire"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-money-bill mr-1"></i> Montant</th>
                                        <td id="viewMontant" class="text-primary font-weight-bold"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-comment mr-1"></i> Motif</th>
                                        <td id="viewMotif"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-user-tie mr-1"></i> Autorisé par</th>
                                        <td id="viewAutorise"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-sticky-note mr-1"></i> Observation</th>
                                        <td id="viewObservation"></td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-clock mr-1"></i> Créé le</th>
                                        <td id="viewCreated"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="button" class="btn btn-primary" onclick="window.print()">
                                    <i class="fas fa-print mr-1"></i> Imprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- ============================================== -->
            <!-- ALERTES ET INFORMATIONS                        -->
            <!-- ============================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info-circle mr-1"></i> Informations importantes</h5>
                        <ul class="mb-0">
                            <li>Toutes les sorties de caisse principale sont enregistrées directement dans le livre de
                                caisse.</li>
                            <li>Les montants supérieurs à 500 000 BIF nécessitent l'approbation du Directeur Général.
                            </li>
                            <li>Un justificatif doit être fourni dans les 48h pour chaque sortie de caisse.</li>
                            <li>Le solde de la caisse principale est mis à jour en temps réel.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal Export -->
<div class="modal fade" id="modalExport">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Exporter les données</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Choisissez le format d'exportation :</p>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="exportExcel" name="exportFormat"
                            value="excel" checked>
                        <label for="exportExcel" class="custom-control-label">
                            <i class="fas fa-file-excel text-success mr-1"></i> Excel (.xlsx)
                        </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="exportPDF" name="exportFormat" value="pdf">
                        <label for="exportPDF" class="custom-control-label">
                            <i class="fas fa-file-pdf text-danger mr-1"></i> PDF
                        </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="exportCSV" name="exportFormat" value="csv">
                        <label for="exportCSV" class="custom-control-label">
                            <i class="fas fa-file-csv text-info mr-1"></i> CSV
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="exporterDonnees()">
                    <i class="fas fa-download mr-1"></i> Télécharger
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bibliothèques pour l'exportation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
/**
 * Fonction principale d'exportation
 */
function exporterDonnees() {
    var format = document.querySelector('input[name="exportFormat"]:checked').value;
    var sorties = <?= json_encode($sorties) ?>;
    var libelles = <?= json_encode($libelles) ?>;

    // Préparer les données
    var data = sorties.map(function(sortie) {
        return {
            'N°': sortie.reference,
            'Date': formatDate(sortie.date_sortie),
            'Bénéficiaire': sortie.beneficiaire,
            'Motif': sortie.motif,
            'Montant (BIF)': parseFloat(sortie.montant),
            'Autorisé par': libelles[sortie.autorise_par] || sortie.autorise_par,
            'Statut': getStatutLabel(sortie.status)
        };
    });

    // Ajouter le total
    var totalMontant = sorties.reduce(function(sum, sortie) {
        return sum + parseFloat(sortie.montant);
    }, 0);

    data.push({
        'N°': '',
        'Date': '',
        'Bénéficiaire': '',
        'Motif': '<strong>Total affiché</strong>',
        'Montant (BIF)': totalMontant,
        'Autorisé par': '',
        'Statut': ''
    });

    var nomFichier = 'Sorties_Caisse_Principale_' + formatDate(new Date()) + '_' + Math.floor(Math.random() * 1000);

    if (format === 'excel') {
        exporterExcel(data, nomFichier);
    } else if (format === 'pdf') {
        exporterPDF(data, nomFichier);
    } else if (format === 'csv') {
        exporterCSV(data, nomFichier);
    }

    // Fermer la modal
    $('#modalExport').modal('hide');
}

/**
 * Exporter en Excel
 */
function exporterExcel(data, nomFichier) {
    // Créer une feuille de calcul
    var ws = XLSX.utils.json_to_sheet(data);

    // Ajuster la largeur des colonnes
    ws['!cols'] = [{
            wch: 15
        }, // N°
        {
            wch: 12
        }, // Date
        {
            wch: 25
        }, // Bénéficiaire
        {
            wch: 35
        }, // Motif
        {
            wch: 15
        }, // Montant
        {
            wch: 20
        }, // Autorisé par
        {
            wch: 12
        } // Statut
    ];

    // Créer un classeur
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Sorties Caisse');

    // Générer le fichier
    XLSX.writeFile(wb, nomFichier + '.xlsx');

    // Notification
    Swal.fire({
        icon: 'success',
        title: 'Exportation réussie',
        text: 'Le fichier Excel a été téléchargé avec succès.',
        timer: 2000,
        showConfirmButton: false
    });
}

/**
 * Exporter en PDF
 */
function exporterPDF(data, nomFichier) {
    const {
        jsPDF
    } = window.jspdf;
    var doc = new jsPDF('l', 'mm', 'a4'); // Paysage

    // ============================================
    // AJOUTER LE LOGO (en base64 ou depuis URL)
    // ============================================
    // Option 1: Si vous avez le logo en base64
    // var logoBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANS...'; // Votre logo ici
    // doc.addImage(logoBase64, 'PNG', 10, 10, 20, 20);

    // Option 2: Charger depuis l'URL (nécessite que l'image soit chargée)
    var logoUrl = '<?= base_url("assets/v1/dist/img/logoUpdate.png") ?>';
    var img = new Image();
    img.crossOrigin = "anonymous";
    img.onload = function() {
        var canvas = document.createElement('canvas');
        canvas.width = img.width;
        canvas.height = img.height;
        var ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);
        var logoBase64 = canvas.toDataURL('image/png');

        // Ajouter le logo
        doc.addImage(logoBase64, 'PNG', 10, 8, 25, 25);

        // Générer le PDF après chargement du logo
        genererPDFContenu(doc, data, nomFichier);
    };
    img.src = logoUrl;
}

/**
 * Générer le contenu du PDF
 */
/**
 * Fonction principale d'exportation
 */
function exporterDonnees() {
    var format = document.querySelector('input[name="exportFormat"]:checked').value;
    var sorties = <?= json_encode($sorties) ?>;
    var libelles = <?= json_encode($libelles) ?>;

    // Préparer les données
    var data = sorties.map(function(sortie) {
        return {
            'N°': sortie.reference,
            'Date': formatDate(sortie.date_sortie),
            'Bénéficiaire': sortie.beneficiaire,
            'Motif': sortie.motif,
            'Montant (BIF)': parseFloat(sortie.montant),
            'Autorisé par': libelles[sortie.autorise_par] || sortie.autorise_par,
            'Statut': getStatutLabel(sortie.status)
        };
    });

    // Ajouter le total (SANS balises HTML)
    var totalMontant = sorties.reduce(function(sum, sortie) {
        return sum + parseFloat(sortie.montant);
    }, 0);

    data.push({
        'N°': '',
        'Date': '',
        'Bénéficiaire': '',
        'Motif': 'Total affiché', // ❌ PAS de <strong>
        'Montant (BIF)': totalMontant,
        'Autorisé par': '',
        'Statut': ''
    });

    var nomFichier = 'Sorties_Caisse_Principale_' + formatDate(new Date()).replace(/\//g, '-') + '_' + Math.floor(Math
        .random() * 1000);

    if (format === 'excel') {
        exporterExcel(data, nomFichier);
    } else if (format === 'pdf') {
        exporterPDF(data, nomFichier);
    } else if (format === 'csv') {
        exporterCSV(data, nomFichier);
    }

    // Fermer la modal
    $('#modalExport').modal('hide');
}

/**
 * Exporter en PDF - VERSION AMÉLIORÉE
 */
function exporterPDF(data, nomFichier) {
    const {
        jsPDF
    } = window.jspdf;
    var doc = new jsPDF('l', 'mm', 'a4'); // Paysage

    // ============================================
    // EN-TÊTE AVEC LOGO
    // ============================================
    var logoUrl = '<?= base_url("assets/v1/dist/img/logoUpdate.png") ?>';

    // Créer une image temporaire pour charger le logo
    var img = new Image();
    img.crossOrigin = "anonymous";
    img.onload = function() {
        // Convertir l'image en base64
        var canvas = document.createElement('canvas');
        canvas.width = img.width;
        canvas.height = img.height;
        var ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);
        var logoBase64 = canvas.toDataURL('image/png');

        // Ajouter le logo en haut à gauche
        doc.addImage(logoBase64, 'PNG', 10, 8, 30, 30);

        // Générer le contenu
        genererPDFContenu(doc, data, nomFichier);
    };

    // Si le logo ne charge pas, générer quand même le PDF
    img.onerror = function() {
        genererPDFContenu(doc, data, nomFichier);
    };

    img.src = logoUrl;
}

/**
 * Générer le contenu du PDF
 */
function genererPDFContenu(doc, data, nomFichier) {
    var pageWidth = doc.internal.pageSize.getWidth();

    // ============================================
    // EN-TÊTE
    // ============================================
    // Logo (positionné en haut à gauche)
    // doc.addImage(logoBase64, 'PNG', 10, 8, 30, 30);

    // Titre de l'entreprise
    doc.setFontSize(16);
    doc.setTextColor(40, 167, 69); // Vert SATRACO
    doc.setFont('helvetica', 'bold');
    doc.text('SATRACO CONSTRUCTION', 160, 15, {
        align: 'left'
    });

    // Sous-titre
    doc.setFontSize(10);
    doc.setTextColor(100, 100, 100);
    doc.setFont('helvetica', 'normal');
    doc.text('Construction Management System (CMS)', 160, 20, {
        align: 'left'
    });

    // Ligne de séparation verte - DESCENDUE pour ne pas toucher le logo
    doc.setDrawColor(40, 167, 69);
    doc.setLineWidth(0.5);
    doc.line(10, 45, pageWidth - 10, 45); // ✅ Changé de 30 à 45

    // Titre du document
    doc.setFontSize(13);
    doc.setTextColor(0, 0, 0);
    doc.setFont('helvetica', 'bold');
    doc.text('Relations Publiques et Transefert via Lumicash', pageWidth / 2, 55, { // ✅ Décalé vers le bas (40 -> 55)
        align: 'center'
    });

    // Période
    var dateDebut = document.getElementById('filtre_date_debut').value || 'Début';
    var dateFin = document.getElementById('filtre_date_fin').value || 'Fin';
    doc.setFontSize(9);
    doc.setFont('helvetica', 'italic');
    doc.setTextColor(100, 100, 100);
    doc.text('Période du ' + formatDate(dateDebut) + ' au ' + formatDate(dateFin), pageWidth / 2,
        60, { // ✅ Décalé vers le bas (45 -> 60)
            align: 'center'
        });

    // ============================================
    // TABLEAU
    // ============================================
    var headers = [
        ['N°', 'Date', 'Bénéficiaire', 'Motif', 'Montant (BIF)', 'Autorisé par', 'Statut']
    ];
    var rows = [];

    // Parcourir toutes les lignes SAUF la dernière (total)
    var totalRows = data.length - 1;

    for (var i = 0; i < totalRows; i++) {
        var item = data[i];

        // ✅ CORRECTION FORMATAGE MONTANT - Conversion explicite en nombre
        var montantVal = parseFloat(item['Montant (BIF)']);
        var montant = !isNaN(montantVal) ?
            formatNumber(montantVal) :
            '0';

        rows.push([
            item['N°'] || '',
            item['Date'] || '',
            item['Bénéficiaire'] || '',
            item['Motif'] || '',
            montant,
            item['Autorisé par'] || '',
            item['Statut'] || ''
        ]);
    }

    // Calculer le total
    var totalMontant = 0;
    for (var i = 0; i < totalRows; i++) {
        totalMontant += (parseFloat(data[i]['Montant (BIF)']) || 0);
    }

    // Ajouter la ligne de total (DERNIÈRE LIGNE)
    rows.push([
        '',
        '',
        '',
        'TOTAL AFFICHÉ',
        formatNumber(totalMontant), // ✅ Utilisation de la fonction formatNumber
        '',
        ''
    ]);

    // Créer le tableau avec autoTable
    doc.autoTable({
        head: headers,
        body: rows,
        startY: 65, // ✅ Décalé vers le bas (50 -> 65)
        theme: 'striped',
        headStyles: {
            fillColor: [40, 167, 69], // Vert SATRACO
            textColor: 255,
            fontStyle: 'bold',
            fontSize: 9,
            halign: 'center'
        },
        styles: {
            fontSize: 8,
            cellPadding: 3,
            overflow: 'linebreak',
            valign: 'middle'
        },
        columnStyles: {
            0: {
                cellWidth: 28,
                halign: 'center'
            }, // N°
            1: {
                cellWidth: 25,
                halign: 'center'
            }, // Date
            2: {
                cellWidth: 40
            }, // Bénéficiaire
            3: {
                cellWidth: 65
            }, // Motif
            4: {
                cellWidth: 35,
                halign: 'right',
                fontStyle: 'bold'
            }, // Montant
            5: {
                cellWidth: 35
            }, // Autorisé par
            6: {
                cellWidth: 25,
                halign: 'center'
            } // Statut
        },
        didParseCell: function(data) {
            // Mettre en évidence la ligne de total (dernière ligne)
            if (data.row.index === rows.length - 1) {
                data.cell.styles.fillColor = [220, 220, 220]; // Gris clair
                data.cell.styles.fontStyle = 'bold';
                data.cell.styles.textColor = [0, 0, 0];
            }
        },
        didDrawPage: function(data) {
            // Ajouter le footer sur chaque page
            var pageCount = doc.internal.getNumberOfPages();

            // Ligne de séparation
            doc.setDrawColor(200, 200, 200);
            doc.setLineWidth(0.3);
            doc.line(10, 200, pageWidth - 10, 200);

            // Footer
            doc.setFontSize(8);
            doc.setTextColor(150, 150, 150);
            doc.setFont('helvetica', 'italic');
            doc.text('Document généré le ' + new Date().toLocaleString('fr-FR'), pageWidth / 2, 205, {
                align: 'center'
            });
            doc.text('© 2026 SATRACO Construction - Construction Management System (CMS)', pageWidth / 2,
                210, {
                    align: 'center'
                });

            // Numéro de page
            doc.setFont('helvetica', 'normal');
            doc.text('Page ' + data.pageNumber + ' sur ' + pageCount, pageWidth - 15, 205, {
                align: 'right'
            });
        }
    });

    // ============================================
    // TÉLÉCHARGER LE PDF
    // ============================================
    doc.save(nomFichier + '.pdf');

    // Notification
    Swal.fire({
        icon: 'success',
        title: 'Exportation réussie',
        text: 'Le fichier PDF a été téléchargé avec succès.',
        timer: 2000,
        showConfirmButton: false
    });
}

/**
 * ✅ FONCTION DE FORMATAGE DES NOMBRES (format français)
 * Ex: 5000000 -> "5 000 000"
 */
function formatNumber(number) {
    if (isNaN(number) || number === null || number === undefined) {
        return '0';
    }

    // Convertir en chaîne et séparer partie entière/décimale
    var parts = number.toString().split('.');
    var partieEntiere = parts[0];
    var partieDecimale = parts.length > 1 ? parts[1] : '';

    // Ajouter les espaces tous les 3 chiffres
    var resultat = '';
    var count = 0;

    for (var i = partieEntiere.length - 1; i >= 0; i--) {
        if (count > 0 && count % 3 === 0) {
            resultat = ' ' + resultat;
        }
        resultat = partieEntiere[i] + resultat;
        count++;
    }

    // Ajouter la partie décimale si existe
    if (partieDecimale) {
        resultat += ',' + partieDecimale;
    }

    return resultat;
}

/**
 * Formater la date
 */
function formatDate(dateString) {
    if (!dateString) return '';
    var date = new Date(dateString);
    return date.toLocaleDateString('fr-FR');
}

/**
 * Obtenir le libellé du statut
 */
function getStatutLabel(status) {
    var labels = {
        'valide': 'Validé',
        'en_attente': 'En attente',
        'rejete': 'Rejeté'
    };
    return labels[status] || status;
}

/**
 * Exporter en CSV
 */
function exporterCSV(data, nomFichier) {
    var headers = ['N°', 'Date', 'Bénéficiaire', 'Motif', 'Montant (BIF)', 'Autorisé par', 'Statut'];
    var csvContent = '\uFEFF'; // BOM pour UTF-8
    csvContent += headers.join(';') + '\n';

    data.forEach(function(item) {
        var row = [
            item['N°'],
            item['Date'],
            '"' + item['Bénéficiaire'].replace(/"/g, '""') + '"',
            '"' + item['Motif'].replace(/"/g, '""') + '"',
            item['Montant (BIF)'],
            item['Autorisé par'],
            item['Statut']
        ];
        csvContent += row.join(';') + '\n';
    });

    var blob = new Blob([csvContent], {
        type: 'text/csv;charset=utf-8;'
    });
    var link = document.createElement('a');
    var url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', nomFichier + '.csv');
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    // Notification
    Swal.fire({
        icon: 'success',
        title: 'Exportation réussie',
        text: 'Le fichier CSV a été téléchargé avec succès.',
        timer: 2000,
        showConfirmButton: false
    });
}

/**
 * Formater la date
 */
function formatDate(dateString) {
    if (!dateString) return '';
    var date = new Date(dateString);
    return date.toLocaleDateString('fr-FR');
}

/**
 * Obtenir le libellé du statut
 */
function getStatutLabel(status) {
    var labels = {
        'valide': 'Validé',
        'en_attente': 'En attente',
        'rejete': 'Rejeté'
    };
    return labels[status] || status;
}
</script>