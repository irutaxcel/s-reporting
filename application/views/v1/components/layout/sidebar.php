<style>
/* ===============================
   SATRACO SIDEBAR FIX
=================================*/

.main-sidebar {
    background: linear-gradient(180deg, #102033, #173b35, #0f766e) !important;
}

.brand-link {
    height: 66px;
    display: flex;
    align-items: center;
    padding: 10px 14px;
    border-bottom: 1px solid rgba(255, 255, 255, .12);
}

.brand-link .brand-image {
    width: 42px;
    height: 42px;
    max-height: 42px;
    object-fit: contain;
    background: #fff;
    padding: 4px;
    border-radius: 50%;
    margin-right: 10px;
}

.brand-link .brand-text {
    color: #fff;
    font-size: 16px;
    font-weight: 800 !important;
    line-height: 1.15;
    white-space: normal;
}

.sidebar {
    padding: 12px 10px;
}

.nav-sidebar>.nav-item {
    margin-bottom: 9px;
}

.nav-sidebar .nav-link {
    display: flex;
    align-items: center;
    min-height: 48px;
    width: 100%;
    border-radius: 14px;
    padding: 10px 12px;
    color: #eaf7f2 !important;
    font-weight: 700;
    overflow: hidden;
}

.nav-sidebar .nav-icon {
    width: 22px;
    min-width: 22px;
    margin-right: 9px;
    text-align: center;
    font-size: 15px;
}

.nav-sidebar .nav-link p {
    flex: 1;
    margin: 0;
    font-size: 13px;
    line-height: 1.3;
    white-space: normal;
}

.nav-link>.right {
    position: static !important;
    margin-left: 8px;
}

/* menu principal actif */
.nav-sidebar>.nav-item>.nav-link.active {
    background: #74c476 !important;
    color: #fff !important;
}

/* niveau 2 */
.nav-treeview {
    padding-left: 8px;
    margin-top: 6px;
}

.nav-treeview .nav-link {
    min-height: 44px;
    background: #f4faf7 !important;
    color: #064b43 !important;
    border-radius: 13px;
    padding: 9px 11px;
    margin-bottom: 6px;
}

/* niveau 3 */
.nav-treeview .nav-treeview {
    padding-left: 10px;
    margin-top: 5px;
}

.nav-treeview .nav-treeview .nav-link {
    min-height: 40px;
    padding: 8px 10px;
}

.nav-treeview .nav-treeview .nav-link p {
    font-size: 12px;
}

/* cercles */
.nav-treeview .far.fa-circle {
    font-size: 8px;
    margin-right: 8px;
}

/* sous-menu actif */
.nav-treeview .nav-link.active {
    background: #fff !important;
    color: #064b43 !important;
    border: 2px solid #74c476 !important;
}

/* éviter le débordement */
.nav-sidebar .nav-link,
.nav-sidebar .nav-link p {
    max-width: 100%;
    word-break: normal;
    overflow-wrap: break-word;
}

/* AdminLTE mobile */
@media(max-width:768px) {

    .content-wrapper,
    .main-header,
    .main-footer {
        margin-left: 0 !important;
    }
}
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('dashboard') ?>" class="brand-link">

        <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO"
            class="brand-image img-circle elevation-2">

        <span class="brand-text font-weight-bold">
            SATRACO Construction ERP
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
                <?php if ($title == 'Personnel Chantier' || $title == 'Achats & Approvisionnement' || $title == 'Projets' || $title == 'Chantiers & exécution' || $title == 'Sous-traitants' || $title == 'Stocks' || $title == 'Engin & Materiel' || $title == 'Maintenance & Carburant' || $title == 'Coût Réel & Rentabilité' || $title == 'Journal Production') { ?>
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
                            <?php if ($title == 'Chantiers & exécution') { ?>
                            <a href="<?= base_url('chantiers') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Chantiers</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('chantiers') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Chantiers</p>
                            </a>
                            <?php } ?>

                        </li>

                        <!-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Demandes d'achat</p>
                            </a>
                        </li> -->

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
                            <?php if ($title == 'Sous-traitants') { ?>
                            <a href="<?= base_url('sous-traitant') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sous Traitant</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('sous-traitant') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sous Traitant</p>
                            </a>
                            <?php }
                                ?>

                        </li>

                        <li class="nav-item">
                            <?php if ($title == 'Stocks') { ?>
                            <a href="<?= base_url('stock-general') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stocks</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('stock-general') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stocks</p>
                            </a>
                            <?php } ?>

                        </li>

                        <li class="nav-item">
                            <?php if ($title == 'Engin & Materiel') { ?>
                            <a href="<?= base_url('engin-materiel') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Engin & Materiel</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('engin-materiel') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Engin & Materiel</p>
                            </a>
                            <?php } ?>
                        </li>

                        <li class="nav-item">
                            <?php if ($title == 'Maintenance & Carburant') { ?>
                            <a href="<?= base_url('maintenance-carburant') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Maintenance & Carburant</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('maintenance-carburant') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Maintenance & Carburant</p>
                            </a>
                            <?php } ?>
                        </li>

                        <li class="nav-item">
                            <?php if ($title == 'Journal Production') { ?>
                            <a href="<?= base_url('journal-production') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Journal Production</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('journal-production') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Journal Production</p>
                            </a>
                            <?php } ?>
                        </li>

                        <li class="nav-item">
                            <?php if ($title == 'Coût Réel & Rentabilité') { ?>
                            <a href="<?= base_url('cout-reelle-rentebilite') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Coût Réel & Rentabilité</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('cout-reelle-rentebilite') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Coût Réel & Rentabilité</p>
                            </a>
                            <?php } ?>
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

                <!-- ==========================
                        DAF / FINANCE
                    =========================== -->
                <?php if ($title == 'Tableau de Bord DAF'  || $title == 'Exercices Comptables' || $title == 'Classes de Comptes' || $title == 'Plan Comptable' || $title == 'Codes journaux' || $title == 'Écritures Comptables' || $title == 'Journal Comptable' || $title == 'Grand Livre Comptable' || $title == 'Balance Générale' || $title == 'Clôture Comptable' || $title == 'Caisse' || $title == 'Journal de caisse' ||  $title == 'Livre de Caisse' || $title == 'Encaissements' || $title == 'Décaissements' || $title == 'Comptes bancaires' || $title == 'Rapprochement bancaire' || $title == 'Prévisions de trésorerie' || $title == 'Factures clients' || $title == 'Factures fournisseurs' || $title == 'Paiements' || $title == 'Échéances' || $title == 'Rapport Financier') { ?>
                <li class="nav-item has-treeview menu-open">

                    <a href="#" class="nav-link active">
                        <?php } else { ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <?php } ?>
                        <i class="nav-icon fas fa-coins"></i>
                        <p>DAF / Finance</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>

                    <ul class="nav nav-treeview">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <?php if ($title == 'Tableau de Bord DAF') { ?>
                            <a href="<?= base_url('finance-dashboard') ?>" class="nav-link active">
                                <i class="fas fa-chart-pie nav-icon"></i>
                                <p>Tableau de bord DAF</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('finance-dashboard') ?>" class="nav-link">
                                <i class="fas fa-chart-pie nav-icon"></i>
                                <p>Tableau de bord DAF</p>
                            </a>
                            <?php } ?>
                        </li>

                        <!-- COMPTABILITE -->
                        <?php if ($title == 'Exercices Comptables' || $title == 'Classes de Comptes' || $title == 'Plan Comptable' || $title == 'Codes journaux' || $title == 'Écritures Comptables' || $title == 'Journal Comptable' || $title == 'Grand Livre Comptable' || $title == 'Balance Générale' || $title == 'Clôture Comptable') { ?>
                        <li class="nav-item has-treeview menu-open">

                            <a href="#" class="nav-link active">
                                <?php } else { ?>
                        <li class="nav-item has-treeview"></li>
                        <a href="#" class="nav-link">
                            <?php } ?>
                            <i class="fas fa-calculator nav-icon"></i>
                            <p>Comptabilité</p>
                            <i class="right fas fa-angle-left"></i>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <?php if ($title == 'Exercices Comptables') { ?>
                                <a href="<?= base_url('exercices') ?>" class="nav-link active">
                                    <i class="far fa-calendar-alt nav-icon"></i>
                                    <p>Exercices comptables</p>
                                </a>
                                <?php } else { ?>
                                <a href="<?= base_url('exercices') ?>" class="nav-link">
                                    <i class="far fa-calendar-alt nav-icon"></i>
                                    <p>Exercices comptables</p>
                                </a>
                                <?php } ?>
                            </li>

                            <li class="nav-item">
                                <?php if ($title == 'Classes de Comptes') { ?>
                                <a href="<?= base_url('account-classes') ?>" class="nav-link active">
                                    <i class="far fa-folder nav-icon"></i>
                                    <p>Classes comptables</p>
                                </a>
                                <?php } else { ?>
                                <a href="<?= base_url('account-classes') ?>" class="nav-link">
                                    <i class="far fa-folder nav-icon"></i>
                                    <p>Classes comptables</p>
                                </a>
                                <?php } ?>
                            </li>

                            <li class="nav-item">
                                <?php if ($title == 'Plan Comptable') { ?>
                                <a href="<?= base_url('chart-accounts') ?>" class="nav-link active">
                                    <i class="far fa-list-alt nav-icon"></i>
                                    <p>Plan comptable</p>
                                </a>
                                <?php } else { ?>
                                <a href="<?= base_url('chart-accounts') ?>" class="nav-link">
                                    <i class="far fa-list-alt nav-icon"></i>
                                    <p>Plan comptable</p>
                                </a>
                                <?php } ?>
                            </li>

                            <li class="nav-item">
                                <?php if ($title == 'Codes journaux') { ?>
                                <a href="<?= base_url('journal-codes') ?>" class="nav-link active">
                                    <i class="far fa-bookmark nav-icon"></i>
                                    <p>Codes journaux</p>
                                </a>
                                <?php } else { ?>
                                <a href="<?= base_url('journal-codes') ?>" class="nav-link">
                                    <i class="far fa-bookmark nav-icon"></i>
                                    <p>Codes journaux</p>
                                </a>
                                <?php } ?>
                            </li>

                            <li class="nav-item">
                                <?php if ($title == 'Écritures Comptables') { ?>
                                <a href="<?= base_url('accounting-entrys') ?>" class="nav-link active">
                                    <i class="far fa-edit nav-icon"></i>
                                    <p>Saisie comptable</p>
                                </a>
                                <?php } else { ?>
                                <a href="<?= base_url('accounting-entrys') ?>" class="nav-link">
                                    <i class="far fa-edit nav-icon"></i>
                                    <p>Saisie comptable</p>
                                </a>
                                <?php } ?>
                            </li>

                            <li class="nav-item">
                                <?php if ($title == 'Journal Comptable') { ?>
                                <a href="<?= base_url('journal') ?>" class="nav-link active">
                                    <i class="far fa-file-alt nav-icon"></i>
                                    <p>Journal comptable</p>
                                </a>
                                <?php } else { ?>
                                <a href="<?= base_url('journal') ?>" class="nav-link">
                                    <i class="far fa-file-alt nav-icon"></i>
                                    <p>Journal comptable</p>
                                </a>
                                <?php } ?>
                            </li>

                            <li class="nav-item">
                                <?php if ($title == 'Grand Livre Comptable') { ?>
                                <a href="<?= base_url('grand-livre') ?>" class="nav-link active">
                                    <i class="far fa-address-book nav-icon"></i>
                                    <p>Grand livre</p>
                                </a>
                                <?php } else { ?>
                                <a href="<?= base_url('grand-livre') ?>" class="nav-link">
                                    <i class="far fa-address-book nav-icon"></i>
                                    <p>Grand livre</p>
                                </a>
                                <?php } ?>
                            </li>

                            <li class="nav-item">
                                <?php if ($title == 'Balance Générale') { ?>
                                <a href="<?= base_url('balance-generale') ?>" class="nav-link active">
                                    <i class="far fa-chart-bar nav-icon"></i>
                                    <p>Balance générale</p>
                                </a>
                                <?php } else { ?>
                                <a href="<?= base_url('balance-generale') ?>" class="nav-link">
                                    <i class="far fa-chart-bar nav-icon"></i>
                                    <p>Balance générale</p>
                                </a>
                                <?php } ?>
                            </li>

                            <li class="nav-item">
                                <?php if ($title == 'Clôture Comptable') { ?>
                                <a href="<?= base_url('cloture-comptable') ?>" class="nav-link active">
                                    <i class="fas fa-lock nav-icon"></i>
                                    <p>Clôture comptable</p>
                                </a>
                                <?php } else { ?>
                                <a href="<?= base_url('cloture-comptable') ?>" class="nav-link">
                                    <i class="fas fa-lock nav-icon"></i>
                                    <p>Clôture comptable</p>
                                </a>
                                <?php } ?>
                            </li>

                        </ul>
                </li>

                <!-- TRESORERIE -->
                <?php if ($title == 'Caisse' || $title == 'Encaissements' || $title == 'Décaissements' || $title == 'Comptes bancaires' || $title == 'Rapprochement bancaire' || $title == 'Prévisions de trésorerie' || $title == 'Journal de caisse' || $title == 'Livre de Caisse' || $title == 'Rapport Financier') { ?>
                <li class="nav-item has-treeview menu-open">

                    <a href="#" class="nav-link active">
                        <?php } else { ?>
                <li class="nav-item has-treeview">

                    <a href="#" class="nav-link">
                        <?php } ?>


                        <i class="fas fa-wallet nav-icon"></i>
                        <p>Trésorerie</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>

                    <ul class="nav nav-treeview">

                        <!-- Caisse -->
                        <li class="nav-item">
                            <?php if ($title == 'Caisse' || $title == 'Journal de caisse' || $title == 'Livre de Caisse') { ?>
                            <a href="<?= base_url('caisse') ?>" class="nav-link active">
                                <i class="fas fa-cash-register nav-icon text-success"></i>
                                <p>Caisse</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('caisse') ?>" class="nav-link">
                                <i class="fas fa-cash-register nav-icon text-success"></i>
                                <p>Caisse</p>
                            </a>
                            <?php } ?>
                        </li>

                        <!-- Rapport Financier -->
                        <li class="nav-item">
                            <?php if ($title == 'Rapport Financier') { ?>
                            <a href="<?= base_url('rapport-financier') ?>" class="nav-link active">
                                <i class="fas fa-file-invoice-dollar nav-icon text-info"></i>
                                <p>Rapport Financier</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('rapport-financier') ?>" class="nav-link">
                                <i class="fas fa-file-invoice-dollar nav-icon text-info"></i>
                                <p>Rapport Financier</p>
                            </a>
                            <?php } ?>
                        </li>

                        <!-- Comptes bancaires -->
                        <li class="nav-item">
                            <?php if ($title == 'Comptes bancaires') { ?>
                            <a href="<?= base_url('compte-banques') ?>" class="nav-link active">
                                <i class="fas fa-university nav-icon text-primary"></i>
                                <p>Comptes bancaires</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('compte-banques') ?>" class="nav-link">
                                <i class="fas fa-university nav-icon text-primary"></i>
                                <p>Comptes bancaires</p>
                            </a>
                            <?php } ?>

                        </li>

                        <!-- Encaissements -->
                        <!-- <li class="nav-item">
                            <?php if ($title == 'Encaissements') { ?>
                            <a href="<?= base_url('encaissements') ?>" class="nav-link active">
                                <i class="fas fa-arrow-circle-down nav-icon text-success"></i>
                                <p>Encaissements</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('encaissements') ?>" class="nav-link">
                                <i class="fas fa-arrow-circle-down nav-icon text-success"></i>
                                <p>Encaissements</p>
                            </a>
                            <?php } ?>
                        </li> -->

                        <!-- Décaissements -->
                        <!-- <li class="nav-item">
                            <?php if ($title == 'Décaissements') { ?>
                            <a href="<?= base_url('decaissements') ?>" class="nav-link active">
                                <i class="fas fa-arrow-circle-up nav-icon text-danger"></i>
                                <p>Décaissements</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('decaissements') ?>" class="nav-link">
                                <i class="fas fa-arrow-circle-up nav-icon text-danger"></i>
                                <p>Décaissements</p>
                            </a>
                            <?php } ?>
                        </li> -->

                        <!-- Rapprochement bancaire -->
                        <li class="nav-item">
                            <?php if ($title == 'Rapprochement bancaire') { ?>
                            <a href="<?= base_url('rapprochement') ?>" class="nav-link active">
                                <i class="fas fa-exchange-alt nav-icon text-warning"></i>
                                <p>Rapprochement bancaire</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('rapprochement') ?>" class="nav-link">
                                <i class="fas fa-exchange-alt nav-icon text-warning"></i>
                                <p>Rapprochement bancaire</p>
                            </a>
                            <?php } ?>

                        </li>

                        <!-- Prévisions de trésorerie -->
                        <li class="nav-item">
                            <?php if ($title == 'Prévisions de trésorerie') { ?>
                            <a href="<?= base_url('prevision') ?>" class="nav-link active">
                                <i class=" fas fa-chart-line nav-icon text-info"></i>
                                <p>Prévisions de trésorerie</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('prevision') ?>" class="nav-link">
                                <i class="fas fa-chart-line nav-icon text-info"></i>
                                <p>Prévisions de trésorerie</p>
                            </a>
                            <?php } ?>

                        </li>



                    </ul>
                </li>

                <!-- FACTURATION -->
                <?php if ($title == 'Factures clients' || $title == 'Factures fournisseurs' || $title == 'Paiements' || $title == 'Échéances') { ?>
                <li class="nav-item has-treeview menu-open">

                    <a href="#" class="nav-link active">
                        <?php } else { ?>
                <li class="nav-item has-treeview ">

                    <a href="#" class="nav-link">
                        <?php } ?>

                        <i class="fas fa-file-invoice-dollar nav-icon"></i>
                        <p>Facturation</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <?php if ($title == 'Factures clients') { ?>
                            <a href="<?= base_url('facture-client') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Factures clients</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('facture-client') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Factures clients</p>
                            </a>
                            <?php } ?>
                        </li>

                        <li class="nav-item">
                            <?php if ($title == 'Factures fournisseurs') { ?>
                            <a href="<?= base_url('facture-fournisseur') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Factures fournisseurs</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('facture-fournisseur') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Factures fournisseurs</p>
                            </a>
                            <?php } ?>
                        </li>

                        <li class="nav-item">
                            <?php if ($title == 'Paiements') { ?>
                            <a href="<?= base_url('paiement') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Paiements</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('paiement') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Paiements</p>
                            </a>
                            <?php } ?>
                        </li>

                        <li class="nav-item">
                            <?php if ($title == 'Échéances') { ?>
                            <a href="<?= base_url('echeances') ?>" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Échéances</p>
                            </a>
                            <?php } else { ?>
                            <a href="<?= base_url('echeances') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Échéances</p>
                            </a>
                            <?php } ?>
                        </li>

                    </ul>
                </li>

                <!-- <li class="nav-item">
                    <a href="<?= base_url('finance/rh') ?>" class="nav-link">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Ressources Humaines</p>
                    </a>
                </li> -->

                <li class="nav-item">
                    <a href="<?= base_url('finance/controle') ?>" class="nav-link">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <p>Contrôle de gestion</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('finance/patrimoine') ?>" class="nav-link">
                        <i class="fas fa-building nav-icon"></i>
                        <p>Patrimoine</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('finance/ged') ?>" class="nav-link">
                        <i class="fas fa-folder-open nav-icon"></i>
                        <p>Documents / GED</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('finance/report') ?>" class="nav-link">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <p>Rapports financiers</p>
                    </a>
                </li>

            </ul>
            </li>


            <!-- RH -->
            <?php if ($title == 'Tableau de bord RH' || $title == 'Employés' || $title == 'Contrats & mouvements' || $title == 'Registre d\'employeur' || $title == 'Temps & présences' || $title == 'Congés' || $title == 'Paie' || $title == 'Conformité & déclarations' || $title == 'Discipline' || $title == 'Évaluations' || $title == 'Rapports & éditions' || $title == 'Paramètres RH') { ?>
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <?php } else { ?>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <?php } ?>


                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Ressources Humaines
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <?php if ($title == 'Tableau de bord RH') { ?>
                        <a href="<?= base_url('rh-dashboard') ?>" class="nav-link active">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <p>Tableau de bord RH</p>
                        </a>
                        <?php } else { ?>
                        <a href="<?= base_url('rh-dashboard') ?>" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <p>Tableau de bord RH</p>
                        </a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if ($title == 'Employés') { ?>
                        <a href="<?= base_url('rh-employes') ?>" class="nav-link active">
                            <i class="fas fa-id-badge nav-icon"></i>
                            <p>Employés</p>
                        </a>
                        <?php } else { ?>
                        <a href="<?= base_url('rh-employes') ?>" class="nav-link">
                            <i class="fas fa-id-badge nav-icon"></i>
                            <p>Employés</p>
                        </a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <a href="rh-contrats" class="nav-link">
                            <i class="fas fa-file-contract nav-icon"></i>
                            <p>Contrats & mouvements</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rh/registre" class="nav-link">
                            <i class="fas fa-book nav-icon"></i>
                            <p>Registre d'employeur</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rh/presences" class="nav-link">
                            <i class="fas fa-user-clock nav-icon"></i>
                            <p>Temps & présences</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rh/conges" class="nav-link">
                            <i class="fas fa-umbrella-beach nav-icon"></i>
                            <p>Congés</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rh/paie" class="nav-link">
                            <i class="fas fa-money-bill-wave nav-icon"></i>
                            <p>Paie</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rh/conformite" class="nav-link">
                            <i class="fas fa-landmark nav-icon"></i>
                            <p>Conformité & déclarations</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rh/discipline" class="nav-link">
                            <i class="fas fa-gavel nav-icon"></i>
                            <p>Discipline</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rh/evaluations" class="nav-link">
                            <i class="fas fa-clipboard-check nav-icon"></i>
                            <p>Évaluations</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rh/rapports" class="nav-link">
                            <i class="fas fa-chart-bar nav-icon"></i>
                            <p>Rapports & éditions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="rh/parametres" class="nav-link">
                            <i class="fas fa-cog nav-icon"></i>
                            <p>Paramètres RH</p>
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
            <?php if ($title == 'Utilisateurs' || $title == 'Matrice des access' || $title == 'Rôles & Permissions' || $title == 'Paramètres') { ?>
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <?php } else { ?>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <?php } ?>

                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        Administration
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <?php if ($title == 'Utilisateurs') { ?>
                        <a href="<?= base_url('users') ?>" class="nav-link active">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Utilisateurs</p>
                        </a>
                        <?php } else { ?>
                        <a href="<?= base_url('users') ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Utilisateurs</p>
                        </a>
                        <?php } ?>

                    </li>

                    <li class="nav-item">
                        <?php if ($title == 'Matrice des access') { ?>
                        <a href="<?= base_url('matrice-access') ?>" class="nav-link active">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Matrice des access</p>
                        </a>
                        <?php } else { ?>
                        <a href="<?= base_url('matrice-access') ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Matrice des access</p>
                        </a>
                        <?php } ?>
                    </li>
                    <li class="nav-item">
                        <?php if ($title == 'Rôles & Permissions') { ?>
                        <a href="<?= base_url('roles-permissions') ?>" class="nav-link active">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Rôles & Permissions</p>
                        </a>
                        <?php } else { ?>
                        <a href="<?= base_url('roles-permissions') ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Rôles & Permissions</p>
                        </a>
                        <?php } ?>
                    </li>

                    <li class="nav-item">
                        <?php if ($title == 'Paramètres') { ?>
                        <a href="<?= base_url('settings') ?>" class="nav-link active">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Paramètres</p>
                        </a>
                        <?php } else { ?>
                        <a href="<?= base_url('settings') ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Paramètres</p>
                        </a>
                        <?php } ?>
                    </li>

                </ul>
            </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>