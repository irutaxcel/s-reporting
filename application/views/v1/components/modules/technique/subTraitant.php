<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sous-traitants</h1>
                    <p class="text-muted mb-0">
                        Gestion des sous-traitants intervenant sur les projets et chantiers.
                    </p>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Sous-traitants</li>
                    </ol>
                </div>
            </div>

        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- Statistiques -->
            <div class="row">

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>10</h3>
                            <p>Total sous-traitants</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>10</h3>
                            <p>Sous-traitants actifs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>7</h3>
                            <p>Spécialités</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tools"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Sous-traitants inactifs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-times"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Filtres -->
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i>
                        Filtres de recherche
                    </h3>
                </div>

                <div class="card-body">
                    <form action="#" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Recherche</label>
                                    <input type="text" class="form-control"
                                        placeholder="Nom, responsable, téléphone...">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Spécialité</label>
                                    <select class="form-control">
                                        <option value="">Toutes les spécialités</option>
                                        <option>Charpentier</option>
                                        <option>Ferrailleur</option>
                                        <option>Maçonnerie</option>
                                        <option>Soudeur</option>
                                        <option>Électricien</option>
                                        <option>Plombier</option>
                                        <option>Peintre</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select class="form-control">
                                        <option value="">Tous</option>
                                        <option value="active">Actif</option>
                                        <option value="inactive">Inactif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-success btn-block">
                                    <i class="fas fa-search"></i>
                                    Rechercher
                                </button>
                            </div>

                        </div>

                    </form>
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

            <!-- Liste -->
            <div class="card card-outline card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-hard-hat mr-1"></i>
                        Liste des sous-traitants
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#addSubcontractorModal">
                            <i class="fas fa-plus-circle"></i>
                            Nouveau sous-traitant
                        </button>

                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-print"></i>
                            Imprimer
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="subcontractorsTable" class="table table-bordered table-striped table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40">#</th>
                                    <th>Entreprise</th>
                                    <th>Responsable</th>
                                    <th>Spécialité</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th>Statut</th>
                                    <th>Date création</th>
                                    <th width="130" class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>1</td>
                                    <td><strong>TUYISENGE</strong></td>
                                    <td>Dieudonné</td>
                                    <td><span class="badge badge-light border">Charpentier</span></td>
                                    <td><i class="fas fa-phone text-success"></i> 62987670</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge badge-success">Actif</span></td>
                                    <td>08/05/2026 09:10</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            onclick="viewSubcontractor('TUYISENGE','Dieudonné','Charpentier','62987670','-','Actif','08/05/2026 09:10')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editSubcontractor('TUYISENGE','Dieudonné','Charpentier','62987670','','active')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSubcontractor()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td><strong>NDABARUSHIMANA</strong></td>
                                    <td>Jean de Dieu</td>
                                    <td><span class="badge badge-light border">Ferrailleur</span></td>
                                    <td><i class="fas fa-phone text-success"></i> 68155404</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge badge-success">Actif</span></td>
                                    <td>08/05/2026 10:44</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            onclick="viewSubcontractor('NDABARUSHIMANA','Jean de Dieu','Ferrailleur','68155404','-','Actif','08/05/2026 10:44')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editSubcontractor('NDABARUSHIMANA','Jean de Dieu','Ferrailleur','68155404','','active')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSubcontractor()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td><strong>NDARUBAYEMWO</strong></td>
                                    <td>Willerme</td>
                                    <td><span class="badge badge-light border">Maçonnerie et travaux
                                            complémentaires</span></td>
                                    <td><i class="fas fa-phone text-success"></i> 69514162</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge badge-success">Actif</span></td>
                                    <td>08/05/2026 10:47</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            onclick="viewSubcontractor('NDARUBAYEMWO','Willerme','Maçonnerie et travaux complémentaires','69514162','-','Actif','08/05/2026 10:47')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editSubcontractor('NDARUBAYEMWO','Willerme','Maçonnerie et travaux complémentaires','69514162','','active')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSubcontractor()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td><strong>HABONIMANA</strong></td>
                                    <td>Moise</td>
                                    <td><span class="badge badge-light border">Soudeur</span></td>
                                    <td><i class="fas fa-phone text-success"></i> 61222737</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge badge-success">Actif</span></td>
                                    <td>08/05/2026 10:50</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            onclick="viewSubcontractor('HABONIMANA','Moise','Soudeur','61222737','-','Actif','08/05/2026 10:50')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editSubcontractor('HABONIMANA','Moise','Soudeur','61222737','','active')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSubcontractor()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td><strong>CISHAHAYO Elie Moses</strong></td>
                                    <td>Elie Moses</td>
                                    <td><span class="badge badge-light border">Électricien</span></td>
                                    <td><i class="fas fa-phone text-success"></i> 69980120</td>
                                    <td>elie.moses@email.com</td>
                                    <td><span class="badge badge-success">Actif</span></td>
                                    <td>08/05/2026 11:47</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            onclick="viewSubcontractor('CISHAHAYO Elie Moses','Elie Moses','Électricien','69980120','elie.moses@email.com','Actif','08/05/2026 11:47')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editSubcontractor('CISHAHAYO Elie Moses','Elie Moses','Électricien','69980120','elie.moses@email.com','active')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSubcontractor()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>6</td>
                                    <td><strong>NIYINDAMUTSA</strong></td>
                                    <td>Adelin</td>
                                    <td><span class="badge badge-light border">Plombier</span></td>
                                    <td><i class="fas fa-phone text-success"></i> 71856908</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge badge-success">Actif</span></td>
                                    <td>08/05/2026 11:48</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            onclick="viewSubcontractor('NIYINDAMUTSA','Adelin','Plombier','71856908','-','Actif','08/05/2026 11:48')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editSubcontractor('NIYINDAMUTSA','Adelin','Plombier','71856908','','active')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSubcontractor()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>7</td>
                                    <td><strong>HATUNGIMANA</strong></td>
                                    <td>Vincent</td>
                                    <td><span class="badge badge-light border">Maçonnerie et travaux
                                            complémentaires</span></td>
                                    <td><i class="fas fa-phone text-success"></i> 61415334</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge badge-success">Actif</span></td>
                                    <td>08/05/2026 11:49</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            onclick="viewSubcontractor('HATUNGIMANA','Vincent','Maçonnerie et travaux complémentaires','61415334','-','Actif','08/05/2026 11:49')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editSubcontractor('HATUNGIMANA','Vincent','Maçonnerie et travaux complémentaires','61415334','','active')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSubcontractor()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>8</td>
                                    <td><strong>NDUWIMANA</strong></td>
                                    <td>Claude</td>
                                    <td><span class="badge badge-light border">Maçonnerie et travaux
                                            complémentaires</span></td>
                                    <td><i class="fas fa-phone text-success"></i> 66584017</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge badge-success">Actif</span></td>
                                    <td>08/05/2026 11:51</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            onclick="viewSubcontractor('NDUWIMANA','Claude','Maçonnerie et travaux complémentaires','66584017','-','Actif','08/05/2026 11:51')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editSubcontractor('NDUWIMANA','Claude','Maçonnerie et travaux complémentaires','66584017','','active')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSubcontractor()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>9</td>
                                    <td><strong>KWIZERA</strong></td>
                                    <td>Simeon</td>
                                    <td><span class="badge badge-light border">Peintre</span></td>
                                    <td><i class="fas fa-phone text-success"></i> 72134633</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge badge-success">Actif</span></td>
                                    <td>08/05/2026 11:53</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            onclick="viewSubcontractor('KWIZERA','Simeon','Peintre','72134633','-','Actif','08/05/2026 11:53')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editSubcontractor('KWIZERA','Simeon','Peintre','72134633','','active')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSubcontractor()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>10</td>
                                    <td><strong>NSHIMIRIMANA</strong></td>
                                    <td>Dismas</td>
                                    <td><span class="badge badge-light border">Carreleur et travaux divers
                                            maçonnerie</span></td>
                                    <td><i class="fas fa-phone text-success"></i> 68180628</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge badge-success">Actif</span></td>
                                    <td>08/05/2026 11:55</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm"
                                            onclick="viewSubcontractor('NSHIMIRIMANA','Dismas','Carreleur et travaux divers maçonnerie','68180628','-','Actif','08/05/2026 11:55')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editSubcontractor('NSHIMIRIMANA','Dismas','Carreleur et travaux divers maçonnerie','68180628','','active')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSubcontractor()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- Modal Ajout -->
    <div class="modal fade" id="addSubcontractorModal">
        <div class="modal-dialog modal-lg">

            <form action="<?= base_url('subcontractor-store') ?>" method="post">

                <input type="hidden" name="company_id" value="2">

                <div class="modal-content">

                    <div class="modal-header bg-success">
                        <h5 class="modal-title">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Nouveau sous-traitant
                        </h5>

                        <button type="button" class="close text-white" data-dismiss="modal">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Entreprise / Nom *</label>
                                    <input type="text" name="name" class="form-control" placeholder="Ex : TUYISENGE"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nom du responsable</label>
                                    <input type="text" name="contact_name" class="form-control"
                                        placeholder="Ex : Dieudonné">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Spécialité *</label>
                                    <input type="text" name="speciality" class="form-control"
                                        placeholder="Ex : Charpentier" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Téléphone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Ex : 62987670">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Ex : contact@email.com">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select name="status" class="form-control">
                                        <option value="active">Actif</option>
                                        <option value="inactive">Inactif</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Annuler
                        </button>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Enregistrer
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <!-- Modal Modification -->
    <div class="modal fade" id="editSubcontractorModal">
        <div class="modal-dialog modal-lg">

            <form action="#" method="post">

                <div class="modal-content">

                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">
                            <i class="fas fa-edit mr-1"></i>
                            Modifier le sous-traitant
                        </h5>

                        <button type="button" class="close" data-dismiss="modal">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Entreprise / Nom *</label>
                                    <input type="text" id="edit_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nom du responsable</label>
                                    <input type="text" id="edit_contact_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Spécialité *</label>
                                    <input type="text" id="edit_speciality" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Téléphone</label>
                                    <input type="text" id="edit_phone" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" id="edit_email" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select id="edit_status" class="form-control">
                                        <option value="active">Actif</option>
                                        <option value="inactive">Inactif</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Annuler
                        </button>

                        <button type="button" class="btn btn-warning">
                            <i class="fas fa-save"></i>
                            Modifier
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <!-- Modal Voir -->
    <div class="modal fade" id="viewSubcontractorModal">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header bg-info">
                    <h5 class="modal-title">
                        <i class="fas fa-eye mr-1"></i>
                        Détails du sous-traitant
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered">
                        <tr>
                            <th width="35%">Entreprise / Nom</th>
                            <td id="view_name"></td>
                        </tr>

                        <tr>
                            <th>Responsable</th>
                            <td id="view_contact_name"></td>
                        </tr>

                        <tr>
                            <th>Spécialité</th>
                            <td id="view_speciality"></td>
                        </tr>

                        <tr>
                            <th>Téléphone</th>
                            <td id="view_phone"></td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td id="view_email"></td>
                        </tr>

                        <tr>
                            <th>Statut</th>
                            <td id="view_status"></td>
                        </tr>

                        <tr>
                            <th>Date création</th>
                            <td id="view_created_at"></td>
                        </tr>
                    </table>

                </div>

            </div>

        </div>
    </div>

    <script>
    function editSubcontractor(name, contactName, speciality, phone, email, status) {
        $('#edit_name').val(name);
        $('#edit_contact_name').val(contactName);
        $('#edit_speciality').val(speciality);
        $('#edit_phone').val(phone);
        $('#edit_email').val(email);
        $('#edit_status').val(status);

        $('#editSubcontractorModal').modal('show');
    }

    function viewSubcontractor(name, contactName, speciality, phone, email, status, createdAt) {
        $('#view_name').text(name);
        $('#view_contact_name').text(contactName);
        $('#view_speciality').text(speciality);
        $('#view_phone').text(phone);
        $('#view_email').text(email);
        $('#view_status').html('<span class="badge badge-success">' + status + '</span>');
        $('#view_created_at').text(createdAt);

        $('#viewSubcontractorModal').modal('show');
    }

    function deleteSubcontractor() {
        Swal.fire({
            title: 'Confirmation',
            text: 'Voulez-vous vraiment supprimer ce sous-traitant ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        });
    }

    $(function() {
        $('#subcontractorsTable').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
            }
        });
    });
    </script>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->