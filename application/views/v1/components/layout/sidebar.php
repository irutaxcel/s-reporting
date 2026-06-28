<style>
.brand-link {
    border-bottom: 1px solid rgba(255, 255, 255, .1);
}

.brand-link .brand-image {
    max-height: 40px;
    width: 40px;
    object-fit: contain;
    background: #fff;
    padding: 3px;
}

.brand-link .brand-text {
    color: #ffffff;
    font-size: 18px;
    font-weight: 700 !important;
}
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('dashboard') ?>" class="brand-link">

        <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO"
            class="brand-image img-circle elevation-2">

        <span class="brand-text font-weight-bold">
            SATRACO Construction
        </span>

    </a>
    <!-- Sidebar -->
    <div class="sidebar">


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- TABLEAU DE BORD -->
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                    </a>
                </li>

                <!-- DIRECTION GENERALE -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Direction Générale
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reporting</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Validations</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Notifications & Alertes</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Messagerie interne</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- DIRECTION TECHNIQUE -->
                <?php if ($title == 'Personnel Chantier' || $title == 'Achats & Approvisionnement' || $title == 'Projets') { ?>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <?php } else { ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <?php } ?>

                        <i class="nav-icon fas fa-hard-hat"></i>
                        <p>
                            Direction Technique
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <?php if ($title == 'Projets') { ?>
                            <a href="<?= base_url('projects') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Projets</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('projects') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Projets</p>
                            </a>
                            <?php } ?>

                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Chantiers</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Demandes d'achat</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <?php if ($title == 'Achats & Approvisionnement') { ?>
                            <a href="<?= base_url('achat') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Achats</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('achat') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Achats</p>
                            </a>
                            <?php } ?>

                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fournisseurs</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sous Traitant</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stocks</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Engin & Materiel</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Maintenance & Carburant</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Journal Production</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cout Reelle & Rentebilite</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Evaluation Chantier</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <?php if ($title == 'Personnel Chantier') { ?>
                            <a href="<?= base_url('personnel-chantier') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Personnel Chantier</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('personnel-chantier') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Personnel Chantier</p>
                            </a>
                            <?php } ?>

                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pointage</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ordre service</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- FINANCE -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            DAF / Finance
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Trésorerie</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Factures & Paiements</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Budgets</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- RH -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Ressources Humaines
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Employés</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Paie</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- CRM -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-handshake"></i>
                        <p>
                            CRM & Clients
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Clients</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Devis</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- ADMIN -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Administration
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Utilisateurs</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rôles & Permissions</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Paramètres</p>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>