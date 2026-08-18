<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- le contenu de la page -->

            <!-- ============ STYLE LOCAL (page employés) ============ -->
            <style>
                .avatar-initials {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 34px;
                    height: 34px;
                    border-radius: 50%;
                    color: #fff;
                    font-weight: 600;
                    font-size: .78rem;
                    flex-shrink: 0;
                }

                .avatar-lg {
                    width: 90px;
                    height: 90px;
                    font-size: 2rem;
                    margin: 0 auto;
                }

                .table td {
                    vertical-align: middle;
                }

                .section-title {
                    color: #1f7a5c;
                    font-weight: 700;
                    border-bottom: 2px solid #e9ecef;
                    padding-bottom: .4rem;
                }

                .custom-file-label {
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .custom-file-label::after {
                    content: "Parcourir";
                    /* remplace "Browse" */
                }

                .custom-file-label.has-file {
                    color: #1f7a5c;
                    /* met en évidence qu'un fichier est choisi */
                    font-weight: 600;
                }
            </style>

            <!-- ============ 1. INDICATEURS ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Effectif total</span>
                            <span class="info-box-number">128</span>
                            <span class="progress-description">86 chantier · 42 bureau</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-file-contract"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Contrats actifs</span>
                            <span class="info-box-number">122</span>
                            <span class="progress-description">74 CDI · 48 CDD</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-umbrella-beach"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">En congé aujourd'hui</span>
                            <span class="info-box-number">6</span>
                            <span class="progress-description">2 demandes en attente</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Alertes (30 jours)</span>
                            <span class="info-box-number">4</span>
                            <span class="progress-description">CDD à renouveler / échéances</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. LISTE DES EMPLOYÉS ============ -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="card-title mb-0"><i class="fas fa-id-badge mr-1 text-success"></i> Liste des employés
                        </h3>
                        <div>
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-download mr-1"></i> Exporter
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-file-excel mr-2 text-success"></i>Excel</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-file-pdf mr-2 text-danger"></i>PDF</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-print mr-2 text-secondary"></i>Imprimer</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#modalNouvelEmploye">
                                <i class="fas fa-user-plus mr-1"></i> Nouvel employé
                            </button>
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div class="row mt-3">
                        <div class="col-md-4 mb-2">
                            <div class="input-group">
                                <input type="search" class="form-control"
                                    placeholder="Rechercher (nom, matricule, fonction…)">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-control">
                                <option>Département : tous</option>
                                <option>Direction Générale</option>
                                <option>DAF / Finance</option>
                                <option>Direction Technique</option>
                                <option>Ressources Humaines</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-control">
                                <option>Site : tous</option>
                                <option>Siège (Bujumbura)</option>
                                <option>Chantier Ngagara II</option>
                                <option>Chantier Gitega</option>
                                <option>Chantier Ngozi</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-control">
                                <option>Contrat : tous</option>
                                <option>CDI</option>
                                <option>CDD</option>
                                <option>Stage</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-control">
                                <option>Statut : tous</option>
                                <option>Actif</option>
                                <option>En congé</option>
                                <option>Suspendu</option>
                                <option>Fin de contrat</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>Matricule</th>
                                <th>Employé</th>
                                <th>Fonction</th>
                                <th>Affectation</th>
                                <th>Contrat</th>
                                <th>Date d'embauche</th>
                                <th>Statut</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $couleurs      = ['#1f7a5c', '#2c8a69', '#34608c', '#7a4f1f', '#8a3033', '#6c757d'];
                            $badge_contrat = ['CDI' => 'success', 'CDD' => 'warning', 'Stage' => 'info'];
                            $badge_statut  = ['Actif' => 'success', 'En congé' => 'info', 'Suspendu' => 'warning', 'Fin de contrat' => 'secondary'];

                            if (!empty($employes)):
                                foreach ($employes as $emp):
                                    // Initiales + couleur stable par employé
                                    $initiales = strtoupper(mb_substr($emp->prenoms, 0, 1) . mb_substr($emp->nom, 0, 1));
                                    $couleur   = $couleurs[$emp->employe_id % count($couleurs)];

                                    // Ligne de contact (email · téléphone), gère les NULL
                                    $contact = trim((!empty($emp->email) ? $emp->email . ' · ' : '') . (!empty($emp->telephone) ? $emp->telephone : ''));

                                    // Affectation : chantier (site) ou bureau (département)
                                    $icone = ($emp->categorie === 'Chantier') ? 'fa-hard-hat' : 'fa-building';
                                    $lieu  = ($emp->categorie === 'Chantier') ? $emp->site_affectation : $emp->departement;

                                    // Ancienneté
                                    $diff = (new DateTime($emp->date_embauche))->diff(new DateTime());
                                    $anciennete = $diff->y >= 1
                                        ? $diff->y . ' an' . ($diff->y > 1 ? 's' : '')
                                        : $diff->m . ' mois';
                            ?>
                                    <tr>
                                        <td><strong class="text-muted"><?= html_escape($emp->matricule) ?></strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar-initials mr-2"
                                                    style="background:<?= $couleur ?>"><?= $initiales ?></span>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        <?= html_escape($emp->prenoms . ' ' . mb_strtoupper($emp->nom)) ?></div>
                                                    <?php if ($contact !== ''): ?>
                                                        <small class="text-muted"><?= html_escape($contact) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= html_escape($emp->fonction) ?></td>
                                        <td><i class="fas <?= $icone ?> mr-1 text-muted"></i><?= html_escape($lieu) ?></td>
                                        <td><span
                                                class="badge badge-<?= $badge_contrat[$emp->type_contrat] ?? 'secondary' ?>"><?= $emp->type_contrat ?></span>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($emp->date_embauche)) ?>
                                            <small class="text-muted d-block"><?= $anciennete ?></small>
                                        </td>
                                        <td><span
                                                class="badge badge-<?= $badge_statut[$emp->statut] ?? 'secondary' ?>"><?= $emp->statut ?></span>
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-sm btn-default" title="Profil" data-toggle="modal"
                                                data-target="#modalProfilEmploye"><i class="fas fa-eye"></i></button>

                                            <button type="button" class="btn btn-sm btn-default" title="Modifier"
                                                onclick="ouvrirModalModification(<?= $emp->employe_id ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button class="btn btn-sm btn-default text-danger" title="Désactiver"><i
                                                    class="fas fa-user-slash"></i></button>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Aucun employé trouvé.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <small class="text-muted float-left mt-2">
                        Affichage de <?= count($employes) > 0 ? '1 à ' . count($employes) : '0' ?>
                        sur <?= count($employes) ?> employé<?= count($employes) > 1 ? 's' : '' ?>
                    </small>
                    <ul class="pagination pagination-sm float-right mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div>

            <!-- ============ 3. MODALE : NOUVEL EMPLOYÉ ============ -->
            <div class="modal fade" id="modalNouvelEmploye">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form id="formNouvelEmploye" action="<?= base_url('rh-employes_store') ?>"
                            enctype="multipart/form-data" method="post">
                            <!-- Si CSRF activé dans config.php, décommente : -->
                            <!-- <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"> -->

                            <div class="modal-header bg-success text-white">
                                <h4 class="modal-title"><i class="fas fa-user-plus mr-2"></i>Nouvel employé</h4>
                                <button type="button" class="close text-white"
                                    data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6 class="section-title">1. Informations personnelles</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Nom *</label><input type="text" name="nom"
                                                class="form-control" required></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Prénoms *</label><input type="text"
                                                name="prenoms" class="form-control" required></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Sexe</label><select name="sexe"
                                                class="form-control">
                                                <option>Masculin</option>
                                                <option>Féminin</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Date de naissance</label><input type="date"
                                                name="date_naissance" class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>État civil</label><select name="etat_civil"
                                                class="form-control">
                                                <option>Célibataire</option>
                                                <option>Marié(e)</option>
                                                <option>Divorcé(e)</option>
                                                <option>Veuf(ve)</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>N° CNID / NIN</label><input type="text"
                                                name="cnid" class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Téléphone</label><input type="text"
                                                name="telephone" class="form-control" placeholder="+257 …"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Email</label><input type="email" name="email"
                                                class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Adresse</label><input type="text" name="adresse"
                                                class="form-control"></div>
                                    </div>
                                </div>

                                <h6 class="section-title mt-3">2. Informations administratives &amp; contractuelles</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Matricule</label><input type="text"
                                                id="inputMatricule" class="form-control" name="matricule"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Catégorie</label><select name="categorie"
                                                class="form-control">
                                                <option value="Bureau">Personnel de bureau</option>
                                                <option value="Chantier">Ouvrier de chantier</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Fonction *</label><input type="text"
                                                name="fonction" class="form-control" required></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Département</label><select name="departement"
                                                class="form-control">
                                                <option>Direction Générale</option>
                                                <option>DAF / Finance</option>
                                                <option>Direction Technique</option>
                                                <option>Ressources Humaines</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Site d'affectation</label><select
                                                name="site_affectation" class="form-control">
                                                <option>Siège (Bujumbura)</option>
                                                <option>Chantier Ngagara II</option>
                                                <option>Chantier Gitega</option>
                                                <option>Chantier Ngozi</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Date d'embauche *</label><input type="date"
                                                name="date_embauche" class="form-control" required></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Type de contrat</label><select
                                                name="type_contrat" class="form-control">
                                                <option>CDI</option>
                                                <option>CDD</option>
                                                <option>Stage</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Fin de contrat (si CDD)</label><input type="date"
                                                name="date_fin_contrat" class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Période d'essai</label><select
                                                name="periode_essai" class="form-control">
                                                <option>3 mois</option>
                                                <option>6 mois</option>
                                                <option>Aucune</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Salaire de base (BIF) *</label><input
                                                type="number" name="salaire_base" class="form-control" required></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Mode de paiement</label><select
                                                name="mode_paiement" class="form-control">
                                                <option>Virement bancaire</option>
                                                <option>Espèces</option>
                                                <option>Mobile money</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>N° matricule INSS</label><input type="text"
                                                name="matricule_inss" class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>N° contribuable (OBR)</label><input type="text"
                                                name="numero_contribuable" class="form-control"></div>
                                    </div>
                                </div>

                                <h6 class="section-title mt-3">3. Documents initiaux</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group"><label>Copie CNID</label>
                                            <div class="custom-file"><input type="file" name="doc_cnid"
                                                    class="custom-file-input" id="docCnid"><label
                                                    class="custom-file-label" for="docCnid">Choisir…</label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"><label>Photo d'identité</label>
                                            <div class="custom-file"><input type="file" name="doc_photo"
                                                    class="custom-file-input" id="docPhoto"><label
                                                    class="custom-file-label" for="docPhoto">Choisir…</label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"><label>Contrat signé</label>
                                            <div class="custom-file"><input type="file" name="doc_contrat"
                                                    class="custom-file-input" id="docContrat"><label
                                                    class="custom-file-label" for="docContrat">Choisir…</label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"><label>CV / Diplômes</label>
                                            <div class="custom-file"><input type="file" name="doc_cv"
                                                    class="custom-file-input" id="docCv"><label
                                                    class="custom-file-label" for="docCv">Choisir…</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success" id="btnEnregistrerEmploye"><i
                                        class="fas fa-save mr-1"></i> Enregistrer l'employé</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    /* ---------- 1. Afficher le nom du fichier choisi (vanilla JS) ---------- */
                    document.querySelectorAll('.custom-file-input').forEach(function(input) {
                        input.addEventListener('change', function() {
                            var label = this.closest('.custom-file').querySelector(
                                '.custom-file-label');
                            if (this.files && this.files.length > 0) {
                                var noms = Array.prototype.map.call(this.files, function(f) {
                                    return f.name;
                                }).join(', ');
                                label.textContent = noms;
                                label.classList.add('has-file');
                            } else {
                                label.textContent = 'Choisir…';
                                label.classList.remove('has-file');
                            }
                        });
                    });

                    /* ---------- 2. Matricule auto à l'ouverture de la modale ---------- */
                    $('#modalNouvelEmploye').on('show.bs.modal', function() {
                        $.getJSON('<?= base_url("rh/next_matricule") ?>', function(res) {
                            $('#inputMatricule').val(res.matricule + ' (généré automatiquement)');
                        });
                    });

                    /* ---------- 3. Soumission AJAX du formulaire ---------- */
                    $('#formNouvelEmploye').on('submit', function(e) {
                        e.preventDefault();
                        var btn = $('#btnEnregistrerEmploye').prop('disabled', true)
                            .html('<i class="fas fa-spinner fa-spin mr-1"></i> Enregistrement…');

                        $.ajax({
                            url: '<?= base_url("rh/employes_store") ?>',
                            method: 'POST',
                            data: new FormData(this),
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: function(res) {
                                if (res.status === 'success') {
                                    $('#modalNouvelEmploye').modal('hide');
                                    (typeof toastr !== 'undefined') ? toastr.success(res
                                        .message): alert(res.message);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 900);
                                } else {
                                    (typeof toastr !== 'undefined') ? toastr.error(res.message):
                                        alert(res.message);
                                }
                            },
                            error: function() {
                                (typeof toastr !== 'undefined') ? toastr.error(
                                    'Erreur serveur.'): alert('Erreur serveur.');
                            },
                            complete: function() {
                                btn.prop('disabled', false).html(
                                    '<i class="fas fa-save mr-1"></i> Enregistrer l\'employé'
                                );
                            }
                        });
                    });
                });
            </script>

            <!-- ============ 4. MODALE : PROFIL 360° ============ -->
            <div class="modal fade" id="modalProfilEmploye">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fas fa-id-badge mr-2 text-success"></i>Profil employé</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Colonne identité -->
                                <div class="col-md-4 text-center border-right">
                                    <span class="avatar-initials avatar-lg" style="background:#1f7a5c">JN</span>
                                    <h4 class="mt-3 mb-1">Jean-Marie NDAYIZEYE</h4>
                                    <p class="text-muted">Responsable RH &amp; Suivi-Évaluation</p>
                                    <div class="mb-3">
                                        <span class="badge badge-success">CDI</span>
                                        <span class="badge badge-success">Actif</span>
                                        <span class="badge badge-info">Bureau</span>
                                    </div>
                                    <ul class="list-group list-group-unbordered mb-3 text-left">
                                        <li class="list-group-item px-0"><i
                                                class="fas fa-hashtag mr-2 text-muted"></i>Matricule :
                                            <strong>SAT-0001</strong>
                                        </li>
                                        <li class="list-group-item px-0"><i
                                                class="fas fa-calendar-alt mr-2 text-muted"></i>Embauche :
                                            <strong>02/03/2020 (6 ans)</strong>
                                        </li>
                                        <li class="list-group-item px-0"><i
                                                class="fas fa-building mr-2 text-muted"></i>Ressources Humaines — Siège
                                        </li>
                                        <li class="list-group-item px-0"><i
                                                class="fas fa-phone mr-2 text-muted"></i>+257 79 100 001</li>
                                        <li class="list-group-item px-0"><i
                                                class="fas fa-envelope mr-2 text-muted"></i>j.ndayizeye@satraco.bi</li>
                                    </ul>
                                    <button class="btn btn-success btn-block"><i class="fas fa-edit mr-1"></i>
                                        Modifier</button>
                                    <button class="btn btn-default btn-block"><i class="fas fa-print mr-1"></i> Imprimer
                                        la fiche</button>
                                </div>

                                <!-- Colonne onglets -->
                                <div class="col-md-8">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                href="#tabInfos">Informations</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                href="#tabContrat">Contrat</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                href="#tabConges">Congés</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                href="#tabDocs">Documents</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                href="#tabPaie">Paie</a></li>
                                    </ul>
                                    <div class="tab-content pt-3">

                                        <div class="tab-pane fade active show" id="tabInfos">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Nom complet</p>
                                                    <p class="font-weight-bold">NDAYIZEYE Jean-Marie</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Sexe</p>
                                                    <p class="font-weight-bold">Masculin</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Naissance</p>
                                                    <p class="font-weight-bold">01/01/1985 à Bujumbura</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">État civil</p>
                                                    <p class="font-weight-bold">Marié, 2 enfants</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">N° CNID</p>
                                                    <p class="font-weight-bold">1985010112345</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Adresse</p>
                                                    <p class="font-weight-bold">Ngagara, Bujumbura</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="tabContrat">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th class="text-muted" width="40%">Type de contrat</th>
                                                    <td><span class="badge badge-success">CDI</span></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Date de début</th>
                                                    <td>02/03/2020</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Période d'essai</th>
                                                    <td>6 mois — validée</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">Salaire de base</th>
                                                    <td>1 850 000 BIF</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">N° INSS</th>
                                                    <td>102 456</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-muted">N° contribuable OBR</th>
                                                    <td>401 234 567</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="tab-pane fade" id="tabConges">
                                            <div class="row text-center mb-3">
                                                <div class="col-4">
                                                    <div class="border rounded p-2"><small class="text-muted">Droit
                                                            annuel</small>
                                                        <h5 class="mb-0">20 j</h5>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="border rounded p-2"><small
                                                            class="text-muted">Pris</small>
                                                        <h5 class="mb-0">6 j</h5>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="border rounded p-2"><small
                                                            class="text-muted">Solde</small>
                                                        <h5 class="mb-0 text-success">14 j</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Période</th>
                                                        <th>Type</th>
                                                        <th>Statut</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>12/08/2026 → 21/08/2026</td>
                                                        <td>Congé annuel</td>
                                                        <td><span class="badge badge-info">En cours</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>23/12/2025 → 02/01/2026</td>
                                                        <td>Congé annuel</td>
                                                        <td><span class="badge badge-success">Approuvé</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="tab-pane fade" id="tabDocs">
                                            <ul class="list-group">
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span><i class="fas fa-id-card mr-2 text-success"></i>Copie
                                                        CNID.pdf</span>
                                                    <button class="btn btn-sm btn-default"><i
                                                            class="fas fa-download"></i></button>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span><i
                                                            class="fas fa-file-contract mr-2 text-success"></i>Contrat_CDI_signé.pdf</span>
                                                    <button class="btn btn-sm btn-default"><i
                                                            class="fas fa-download"></i></button>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span><i
                                                            class="fas fa-graduation-cap mr-2 text-success"></i>Diplôme_Licence_Gestion.pdf</span>
                                                    <button class="btn btn-sm btn-default"><i
                                                            class="fas fa-download"></i></button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-pane fade" id="tabPaie">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Période</th>
                                                        <th>Brut</th>
                                                        <th>Retenues</th>
                                                        <th>Net</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Juillet 2026</td>
                                                        <td>1 850 000</td>
                                                        <td>212 500</td>
                                                        <td><strong>1 637 500</strong></td>
                                                        <td><button class="btn btn-sm btn-default"><i
                                                                    class="fas fa-file-pdf text-danger"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Juin 2026</td>
                                                        <td>1 850 000</td>
                                                        <td>212 500</td>
                                                        <td><strong>1 637 500</strong></td>
                                                        <td><button class="btn btn-sm btn-default"><i
                                                                    class="fas fa-file-pdf text-danger"></i></button>
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
                </div>
            </div>

            <!-- ============ MODALE : MODIFIER EMPLOYÉ ============ -->
            <div class="modal fade" id="modalModifierEmploye">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form id="formModifierEmploye" enctype="multipart/form-data">
                            <input type="hidden" name="employe_id" id="editEmployeId">

                            <div class="modal-header bg-success text-white">
                                <h4 class="modal-title"><i class="fas fa-user-edit mr-2"></i>Modifier l'employé <span
                                        id="editMatriculeTitre"></span></h4>
                                <button type="button" class="close text-white"
                                    data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6 class="section-title">1. Informations personnelles</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Nom *</label><input type="text" name="nom"
                                                class="form-control" required></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Prénoms *</label><input type="text"
                                                name="prenoms" class="form-control" required></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Sexe</label><select name="sexe"
                                                class="form-control">
                                                <option>Masculin</option>
                                                <option>Féminin</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Date de naissance</label><input type="date"
                                                name="date_naissance" class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>État civil</label><select name="etat_civil"
                                                class="form-control">
                                                <option>Célibataire</option>
                                                <option>Marié(e)</option>
                                                <option>Divorcé(e)</option>
                                                <option>Veuf(ve)</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>N° CNID / NIN</label><input type="text"
                                                name="cnid" class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Téléphone</label><input type="text"
                                                name="telephone" class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Email</label><input type="email" name="email"
                                                class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Adresse</label><input type="text" name="adresse"
                                                class="form-control"></div>
                                    </div>
                                </div>

                                <h6 class="section-title mt-3">2. Informations administratives &amp; contractuelles</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Matricule</label><input type="text"
                                                id="inputMatriculeEdit" class="form-control" disabled></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Catégorie</label><select name="categorie"
                                                class="form-control">
                                                <option value="Bureau">Personnel de bureau</option>
                                                <option value="Chantier">Ouvrier de chantier</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Fonction *</label><input type="text"
                                                name="fonction" class="form-control" required></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Département</label><select name="departement"
                                                class="form-control">
                                                <option>Direction Générale</option>
                                                <option>DAF / Finance</option>
                                                <option>Direction Technique</option>
                                                <option>Ressources Humaines</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Site d'affectation</label><select
                                                name="site_affectation" class="form-control">
                                                <option>Siège (Bujumbura)</option>
                                                <option>Chantier Ngagara II</option>
                                                <option>Chantier Gitega</option>
                                                <option>Chantier Ngozi</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Date d'embauche *</label><input type="date"
                                                name="date_embauche" class="form-control" required></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Type de contrat</label><select
                                                name="type_contrat" class="form-control">
                                                <option>CDI</option>
                                                <option>CDD</option>
                                                <option>Stage</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Fin de contrat (si CDD)</label><input type="date"
                                                name="date_fin_contrat" class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Période d'essai</label><select
                                                name="periode_essai" class="form-control">
                                                <option>3 mois</option>
                                                <option>6 mois</option>
                                                <option>Aucune</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Salaire de base (BIF) *</label><input
                                                type="number" name="salaire_base" class="form-control" required></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Mode de paiement</label><select
                                                name="mode_paiement" class="form-control">
                                                <option>Virement bancaire</option>
                                                <option>Espèces</option>
                                                <option>Mobile money</option>
                                            </select></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>N° matricule INSS</label><input type="text"
                                                name="matricule_inss" class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>N° contribuable (OBR)</label><input type="text"
                                                name="numero_contribuable" class="form-control"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"><label>Statut</label><select name="statut"
                                                class="form-control">
                                                <option>Actif</option>
                                                <option>En congé</option>
                                                <option>Suspendu</option>
                                                <option>Fin de contrat</option>
                                            </select></div>
                                    </div>
                                </div>

                                <h6 class="section-title mt-3">3. Documents <small class="text-muted">(laisser vide pour
                                        conserver l'actuel)</small></h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group"><label>Copie CNID</label><small
                                                class="d-block text-muted mb-1" id="docActuel_doc_cnid">Aucun
                                                fichier</small>
                                            <div class="custom-file"><input type="file" name="doc_cnid"
                                                    class="custom-file-input" id="editDocCnid"><label
                                                    class="custom-file-label" for="editDocCnid">Remplacer…</label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"><label>Photo d'identité</label><small
                                                class="d-block text-muted mb-1" id="docActuel_doc_photo">Aucun
                                                fichier</small>
                                            <div class="custom-file"><input type="file" name="doc_photo"
                                                    class="custom-file-input" id="editDocPhoto"><label
                                                    class="custom-file-label" for="editDocPhoto">Remplacer…</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"><label>Contrat signé</label><small
                                                class="d-block text-muted mb-1" id="docActuel_doc_contrat">Aucun
                                                fichier</small>
                                            <div class="custom-file"><input type="file" name="doc_contrat"
                                                    class="custom-file-input" id="editDocContrat"><label
                                                    class="custom-file-label" for="editDocContrat">Remplacer…</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"><label>CV / Diplômes</label><small
                                                class="d-block text-muted mb-1" id="docActuel_doc_cv">Aucun
                                                fichier</small>
                                            <div class="custom-file"><input type="file" name="doc_cv"
                                                    class="custom-file-input" id="editDocCv"><label
                                                    class="custom-file-label" for="editDocCv">Remplacer…</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success" id="btnModifierEmploye"><i
                                        class="fas fa-save mr-1"></i> Enregistrer les modifications</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                /* =====================================================
   VARIABLES & FONCTIONS GLOBALES (accessibles depuis onclick)
   Définies en scope global : aucune dépendance jQuery au parse,
   jQuery n'est utilisé qu'AU CLIC (donc après chargement du footer).
   ===================================================== */
                var RH_BASE = '<?= base_url("/") ?>';

                function rhNotify(type, msg) {
                    if (typeof toastr !== 'undefined') {
                        toastr[type](msg);
                    } else {
                        alert(msg);
                    }
                }

                /* ---------- Bouton MODIFIER (onclick) ---------- */
                function ouvrirModalModification(id) {
                    $.getJSON(RH_BASE + 'rh-employe_get/' + id, function(res) {
                        if (res.status !== 'success') {
                            rhNotify('error', res.message);
                            return;
                        }

                        var emp = res.employe;
                        var $form = $('#formModifierEmploye');
                        $form[0].reset();

                        // Pré-remplit chaque champ (name = colonne SQL)
                        $.each(emp, function(cle, valeur) {
                            var $el = $form.find('[name="' + cle + '"]').not('input[type="file"]');
                            if ($el.length && valeur !== null) {
                                $el.val(cle === 'salaire_base' ? parseFloat(valeur) : valeur);
                            }
                        });

                        $('#editMatriculeTitre').text('(' + emp.matricule + ')');
                        $('#inputMatriculeEdit').val(emp.matricule);

                        // Documents actuels (lien de consultation)
                        ['doc_cnid', 'doc_photo', 'doc_contrat', 'doc_cv'].forEach(function(champ) {
                            var $cible = $('#docActuel_' + champ);
                            if (emp[champ]) {
                                var nomFichier = emp[champ].split('/').pop();
                                $cible.html('<a href="<?= base_url() ?>' + emp[champ] +
                                    '" target="_blank"><i class="fas fa-paperclip mr-1"></i>' +
                                    nomFichier + '</a>');
                            } else {
                                $cible.text('Aucun fichier');
                            }
                        });

                        $('#modalModifierEmploye').modal('show');
                    }).fail(function() {
                        rhNotify('error', 'Erreur serveur lors du chargement de la fiche.');
                    });
                }

                /* =====================================================
                   ATTACHES APRÈS CHARGEMENT COMPLET (jQuery garanti)
                   ===================================================== */
                document.addEventListener('DOMContentLoaded', function() {

                    /* Affichage du nom de fichier choisi (toutes les modales) */
                    document.querySelectorAll('.custom-file-input').forEach(function(input) {
                        input.addEventListener('change', function() {
                            var label = this.closest('.custom-file').querySelector(
                                '.custom-file-label');
                            label.textContent = (this.files && this.files.length) ? this.files[0]
                                .name : 'Choisir…';
                        });
                    });

                    /* ---------- CRÉATION : matricule auto à l'ouverture ---------- */
                    $('#modalNouvelEmploye').on('show.bs.modal', function() {
                        $.getJSON(RH_BASE + 'next_matricule', function(res) {
                            $('#inputMatricule').val(res.matricule + ' (généré automatiquement)');
                        });
                    });

                    /* ---------- CRÉATION : soumission ---------- */
                    $('#formNouvelEmploye').on('submit', function(e) {
                        e.preventDefault();
                        var btn = $('#btnEnregistrerEmploye').prop('disabled', true)
                            .html('<i class="fas fa-spinner fa-spin mr-1"></i> Enregistrement…');
                        $.ajax({
                            url: RH_BASE + 'employes_store',
                            method: 'POST',
                            data: new FormData(this),
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: function(res) {
                                if (res.status === 'success') {
                                    $('#modalNouvelEmploye').modal('hide');
                                    rhNotify('success', res.message);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 900);
                                } else {
                                    rhNotify('error', res.message);
                                }
                            },
                            error: function() {
                                rhNotify('error', 'Erreur serveur.');
                            },
                            complete: function() {
                                btn.prop('disabled', false).html(
                                    '<i class="fas fa-save mr-1"></i> Enregistrer l\'employé'
                                );
                            }
                        });
                    });

                    /* ---------- MODIFICATION : soumission ---------- */
                    $('#formModifierEmploye').on('submit', function(e) {
                        e.preventDefault();
                        var btn = $('#btnModifierEmploye').prop('disabled', true)
                            .html('<i class="fas fa-spinner fa-spin mr-1"></i> Enregistrement…');
                        $.ajax({
                            url: RH_BASE + 'employes_update',
                            method: 'POST',
                            data: new FormData(this),
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: function(res) {
                                if (res.status === 'success') {
                                    $('#modalModifierEmploye').modal('hide');
                                    rhNotify('success', res.message);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 900);
                                } else {
                                    rhNotify('error', res.message);
                                }
                            },
                            error: function() {
                                rhNotify('error', 'Erreur serveur.');
                            },
                            complete: function() {
                                btn.prop('disabled', false).html(
                                    '<i class="fas fa-save mr-1"></i> Enregistrer les modifications'
                                );
                            }
                        });
                    });
                });
            </script>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->