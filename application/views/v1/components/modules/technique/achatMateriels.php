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

            <!-- Small boxes -->
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>24</h3>
                            <p>Demandes validées</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>18</h3>
                            <p>Achats effectués</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>6</h3>
                            <p>En approvisionnement</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>2</h3>
                            <p>Livraisons en retard</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Card principale -->
            <div class="card card-outline card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clipboard-check mr-2"></i>
                        Demandes d'achat validées par DT, DAF et Trésorerie
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                            data-target="#modalNouvelAchat">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Créer un achat
                        </button>

                        <button class="btn btn-sm btn-secondary">
                            <i class="fas fa-print mr-1"></i>
                            Imprimer
                        </button>
                    </div>
                </div>

                <!-- Modal Nouvelle demande / Achat -->
                <div class="modal fade" id="modalNouvelAchat" tabindex="-1" role="dialog"
                    aria-labelledby="modalNouvelAchatLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <form action="<?= base_url('tech/store_achat_materiel') ?>" method="post" id="formNouvelAchat">
                            <div class="modal-content">

                                <div class="modal-header bg-success">
                                    <h5 class="modal-title" id="modalNouvelAchatLabel">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Nouvelle demande d'achat
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Chantier</label>
                                                <select name="chantier_id" class="form-control" required>
                                                    <option value="">-- Sélectionner le chantier --</option>
                                                    <?php foreach ($allChantiers as $chant) : ?>
                                                        <option value="<?= $chant->id ?>"><?= $chant->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Demandé par</label>
                                                <input type="text" name="demande_par" class="form-control"
                                                    placeholder="Nom du demandeur" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Chargé des achats</label>
                                                <input type="text" name="charge_achat" class="form-control"
                                                    placeholder="Nom du chargé des achats" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Vérifié par</label>
                                                <input type="text" name="verifie_par" class="form-control"
                                                    placeholder="Nom du vérificateur" required>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">
                                            <i class="fas fa-list mr-1"></i>
                                            Articles demandés
                                        </h5>

                                        <button type="button" class="btn btn-sm btn-success" onclick="addArticleRow()">
                                            <i class="fas fa-plus mr-1"></i>
                                            Ajouter article
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm" id="articlesTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Désignation article</th>
                                                    <th width="140">Quantité</th>
                                                    <th width="170">Prix unitaire</th>
                                                    <th width="180">Total</th>
                                                    <th width="60">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="article[]" class="form-control"
                                                            placeholder="Ex : Ciment, fer à béton..." required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="quantite[]"
                                                            class="form-control quantite" min="1" value="1"
                                                            onkeyup="calculerLigne(this)" onchange="calculerLigne(this)"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="prix_unitaire[]"
                                                            class="form-control prix_unitaire" min="0" value="0"
                                                            onkeyup="calculerLigne(this)" onchange="calculerLigne(this)"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="total_ligne[]"
                                                            class="form-control total_ligne" value="0" readonly>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="removeArticleRow(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-right">Total général</th>
                                                    <th>
                                                        <input type="number" name="total_general" id="total_general"
                                                            class="form-control font-weight-bold" value="0" readonly>
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Fermer
                                    </button>

                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save mr-1"></i>
                                        Enregistrer
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    function addArticleRow() {
                        let tbody = document.querySelector('#articlesTable tbody');

                        let tr = document.createElement('tr');

                        tr.innerHTML = `
                        <td>
                            <input type="text" name="article[]" class="form-control" placeholder="Ex : Ciment, fer à béton..." required>
                        </td>
                        <td>
                            <input type="number" name="quantite[]" class="form-control quantite" min="1" value="1" onkeyup="calculerLigne(this)" onchange="calculerLigne(this)" required>
                        </td>
                        <td>
                            <input type="number" name="prix_unitaire[]" class="form-control prix_unitaire" min="0" value="0" onkeyup="calculerLigne(this)" onchange="calculerLigne(this)" required>
                        </td>
                        <td>
                            <input type="number" name="total_ligne[]" class="form-control total_ligne" value="0" readonly>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeArticleRow(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;

                        tbody.appendChild(tr);
                    }

                    function removeArticleRow(button) {
                        let tbody = document.querySelector('#articlesTable tbody');

                        if (tbody.rows.length > 1) {
                            button.closest('tr').remove();
                            calculerTotalGeneral();
                        }
                    }

                    function calculerLigne(input) {
                        let tr = input.closest('tr');

                        let quantite = parseFloat(tr.querySelector('.quantite').value) || 0;
                        let prix = parseFloat(tr.querySelector('.prix_unitaire').value) || 0;
                        let total = quantite * prix;

                        tr.querySelector('.total_ligne').value = total;

                        calculerTotalGeneral();
                    }

                    function calculerTotalGeneral() {
                        let totalGeneral = 0;

                        document.querySelectorAll('.total_ligne').forEach(function(input) {
                            totalGeneral += parseFloat(input.value) || 0;
                        });

                        document.getElementById('total_general').value = totalGeneral;
                    }
                </script>

                <div class="card-body">

                    <!-- Filtres -->
                    <div class="row mb-3">

                        <div class="col-md-3">
                            <label>Chantier / Projet</label>
                            <select class="form-control">
                                <option>Tous les chantiers</option>
                                <option>Chantier Bujumbura</option>
                                <option>Chantier Gitega</option>
                                <option>Chantier Ngozi</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Statut achat</label>
                            <select class="form-control">
                                <option>Tous</option>
                                <option>Validée</option>
                                <option>Achat effectué</option>
                                <option>En approvisionnement</option>
                                <option>Livré</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>Date début</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <label>Date fin</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-success btn-block">
                                <i class="fas fa-search mr-1"></i>
                                Filtrer
                            </button>
                        </div>

                    </div>

                    <!-- Tableau -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="40">#</th>
                                    <th>Référence</th>
                                    <th>Chantier / Projet</th>
                                    <th>Demandeur</th>
                                    <th>Matériel demandé</th>
                                    <th>Montant estimé</th>
                                    <th>Date demande</th>
                                    <th>Validation</th>
                                    <th>Statut achat</th>
                                    <th width="170">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>1</td>
                                    <td><strong>DA-2026-001</strong></td>
                                    <td>Construction immeuble Bujumbura</td>
                                    <td>Jean Ndayisaba</td>
                                    <td>Ciment, fers à béton, gravier</td>
                                    <td><strong>12 500 000 BIF</strong></td>
                                    <td>20/06/2026</td>
                                    <td>
                                        <span class="badge badge-success">DT</span>
                                        <span class="badge badge-success">DAF</span>
                                        <span class="badge badge-success">Trésorerie</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">En approvisionnement</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" title="Voir détail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" title="Créer achat">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary" title="Imprimer">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td><strong>DA-2026-002</strong></td>
                                    <td>Chantier Gitega</td>
                                    <td>Claude Manirakiza</td>
                                    <td>Carburant, huile moteur, pièces engin</td>
                                    <td><strong>4 850 000 BIF</strong></td>
                                    <td>18/06/2026</td>
                                    <td>
                                        <span class="badge badge-success">DT</span>
                                        <span class="badge badge-success">DAF</span>
                                        <span class="badge badge-success">Trésorerie</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">Achat effectué</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td><strong>DA-2026-003</strong></td>
                                    <td>Route communale Ngozi</td>
                                    <td>Patrick Nshimirimana</td>
                                    <td>Sable, moellons, tuyaux PVC</td>
                                    <td><strong>7 300 000 BIF</strong></td>
                                    <td>15/06/2026</td>
                                    <td>
                                        <span class="badge badge-success">DT</span>
                                        <span class="badge badge-success">DAF</span>
                                        <span class="badge badge-success">Trésorerie</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">Livré</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="card-footer clearfix">
                    <div class="float-left">
                        <small class="text-muted">
                            Liste des demandes validées et prêtes pour l’achat ou l’approvisionnement.
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