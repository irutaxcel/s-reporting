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
                                Historique des Sorties Caisse Principale
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
                        <div class="card-body">
                            <?php if (empty($sorties)): ?>
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Aucune sortie enregistrée pour cette période</p>
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 8%">N°</th>
                                            <th style="width: 12%">Date</th>
                                            <th style="width: 20%">Bénéficiaire</th>
                                            <th style="width: 25%">Motif</th>
                                            <th style="width: 15%" class="text-right">Montant (BIF)</th>
                                            <th style="width: 12%">Autorisé par</th>
                                            <th style="width: 8%">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $total_affiche = 0;
                                            foreach ($sorties as $sortie):
                                                $total_affiche += $sortie->montant;
                                            ?>
                                        <tr>
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
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr class="font-weight-bold">
                                            <td colspan="4" class="text-right">Total affiché:</td>
                                            <td class="text-right text-primary">
                                                <?= number_format($total_affiche, 0, ',', ' ') ?> BIF</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                        <!-- <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div> -->
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
                        <input class="custom-control-input" type="radio" id="exportExcel" name="exportFormat" checked>
                        <label for="exportExcel" class="custom-control-label">
                            <i class="fas fa-file-excel text-success mr-1"></i> Excel (.xlsx)
                        </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="exportPDF" name="exportFormat">
                        <label for="exportPDF" class="custom-control-label">
                            <i class="fas fa-file-pdf text-danger mr-1"></i> PDF
                        </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="exportCSV" name="exportFormat">
                        <label for="exportCSV" class="custom-control-label">
                            <i class="fas fa-file-csv text-info mr-1"></i> CSV
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-download mr-1"></i> Télécharger
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function resetForm() {
    if (confirm('Êtes-vous sûr de vouloir annuler ?')) {
        document.getElementById('formSortieCaisse').reset();
        document.getElementById('date_sortie').value = '<?= date("Y-m-d") ?>';
    }
}

// Validation côté client avant soumission
document.getElementById('formSortieCaisse').addEventListener('submit', function(e) {
    var montant = parseFloat(document.getElementById('montant').value);
    if (isNaN(montant) || montant < 1000) {
        e.preventDefault();
        alert('Le montant doit être au minimum de 1 000 BIF');
        return false;
    }

    var btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Enregistrement...';
});
</script>