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

<?php
/* Titres par module : ouvrent (menu-open) et surlignent (active) les groupes */
$dgTitles     = ['Synthèse des demandes', 'Tableau de bord', 'Indicateurs de performance', 'Reporting général', 'Analytique', 'Statistiques', 'Validations & Approbations', 'Suivi des projets', 'Notifications & Alertes', 'Messagerie interne', 'Gestion des utilisateurs', 'Paramètres', 'Archives', 'Relation Publique'];
$techTitles   = ['Projets', 'Chantiers & exécution', 'Achats & Approvisionnement', 'Sous-traitants', 'Stocks', 'Engin & Materiel', 'Maintenance & Carburant', 'Journal Production', 'Coût Réel & Rentabilité', 'Personnel Chantier', 'Suivie Paie Chantier'];
$dafTitles    = ['Tableau de Bord DAF', 'Exercices Comptables', 'Classes de Comptes', 'Plan Comptable', 'Codes journaux', 'Écritures Comptables', 'Journal Comptable', 'Grand Livre Comptable', 'Balance Générale', 'Clôture Comptable', 'Caisse', 'Journal de caisse', 'Livre de Caisse', 'Comptes bancaires', 'Rapprochement bancaire', 'Prévisions de trésorerie', 'Factures clients', 'Factures fournisseurs', 'Paiements', 'Échéances', 'Rapport Financier', 'Contrôle de gestion', 'Patrimoine', 'Documents / GED', 'Rapports financiers'];
$comptaTitles = ['Exercices Comptables', 'Classes de Comptes', 'Plan Comptable', 'Codes journaux', 'Écritures Comptables', 'Journal Comptable', 'Grand Livre Comptable', 'Balance Générale', 'Clôture Comptable'];
$tresoTitles  = ['Caisse', 'Journal de caisse', 'Livre de Caisse', 'Rapport Financier', 'Comptes bancaires', 'Rapprochement bancaire', 'Prévisions de trésorerie'];
$factuTitles  = ['Factures clients', 'Factures fournisseurs', 'Paiements', 'Échéances'];
$rhTitles     = ['Tableau de bord RH', 'Employés', 'Contrats & mouvements', "Registre d'employeur", 'Temps & présences', 'Congés', 'Paie', 'Discipline', 'Évaluations', 'Rapports & éditions'];
$crmTitles    = ['Tableau de Bord CRM', 'Clients CRM', 'Devis', 'Projets CRM', 'Chantiers & Avancement', 'Reporting & Statistiques'];
$adminTitles  = ['Utilisateurs', 'Matrice des access', 'Rôles & Permissions', 'Paramètres'];
$reportTitles = ['Reporting général', 'Analytique', 'Statistiques'];
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="<?= base_url('dashboard') ?>" class="brand-link">
        <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO"
            class="brand-image img-circle elevation-2">
        <span class="brand-text font-weight-bold">SATRACO Construction ERP</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- ============ TABLEAU DE BORD (toujours visible) ============ -->
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                    </a>
                </li>

                <!-- ============ DIRECTION GÉNÉRALE ============ -->
                <?php if (has_any_access('dg')): ?>
                <li class="nav-item <?= in_array($title, $dgTitles, true) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= in_array($title, $dgTitles, true) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Direction Générale <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

                        <?php if (has_access('dg', 'direction-dashboard')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('direction/dashboard') ?>" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Tableau de bord</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('dg', 'direction-indicateurs')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('direction/indicateurs') ?>" class="nav-link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Indicateurs de performance</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- Sous-groupe Reporting -->
                        <?php if (has_access('dg', 'direction-reporting-general') || has_access('dg', 'direction-reporting-analytique') || has_access('dg', 'direction-statistiques')): ?>
                        <li class="nav-item <?= in_array($title, $reportTitles, true) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= in_array($title, $reportTitles, true) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Reporting <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if (has_access('dg', 'direction-reporting-general')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('direction/reporting/general') ?>"
                                        class="nav-link <?= $title == 'Reporting général' ? 'active' : '' ?>">
                                        <i class="nav-icon far fa-file-alt"></i>
                                        <p>Reporting général</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('dg', 'direction-reporting-analytique')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('direction/reporting/analytique') ?>"
                                        class="nav-link <?= $title == 'Analytique' ? 'active' : '' ?>">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Analytique</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('dg', 'direction-statistiques')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('direction/statistiques') ?>"
                                        class="nav-link <?= $title == 'Statistiques' ? 'active' : '' ?>">
                                        <i class="nav-icon fas fa-chart-bar"></i>
                                        <p>Statistiques</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('dg', 'direction-validations')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('direction/validations') ?>"
                                class="nav-link <?= $title == 'Validations & Approbations' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-check-double"></i>
                                <p>Validations & Approbations</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('dg', 'direction-projets')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('direction/projets') ?>"
                                class="nav-link <?= $title == 'Suivi des projets' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>Suivi des projets</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('dg', 'direction-notifications')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('direction/notifications') ?>"
                                class="nav-link <?= $title == 'Notifications & Alertes' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-bell"></i>
                                <p>Notifications & Alertes</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('dg', 'direction-messagerie')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('direction/messagerie') ?>"
                                class="nav-link <?= $title == 'Messagerie interne' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Messagerie interne</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('dg', 'synthese-demandes')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('synthese-demandes') ?>"
                                class="nav-link <?= $title == 'Synthèse des demandes' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Synthèse des demandes</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('dg', 'direction-relation-publique')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('direction-relation-publique') ?>"
                                class="nav-link <?= $title == 'Relation Publique' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-handshake"></i>
                                <p>Relation Publique</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('dg', 'direction-utilisateurs')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('direction/utilisateurs') ?>"
                                class="nav-link <?= $title == 'Gestion des utilisateurs' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Gestion des utilisateurs</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('dg', 'direction-parametres')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('direction/parametres') ?>" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>Paramètres</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('dg', 'direction-archives')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('direction-archives') ?>"
                                class="nav-link <?= $title == 'Archives' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>Archives</p>
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </li>
                <?php endif; ?>

                <!-- ============ DIRECTION TECHNIQUE ============ -->
                <?php if (has_any_access('tech')): ?>
                <li class="nav-item <?= in_array($title, $techTitles, true) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= in_array($title, $techTitles, true) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-hard-hat"></i>
                        <p>Direction Technique <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

                        <?php if (has_access('tech', 'projects')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('projects') ?>"
                                class="nav-link <?= $title == 'Projets' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Projets</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'chantiers')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('chantiers') ?>"
                                class="nav-link <?= $title == 'Chantiers & exécution' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Chantiers</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'achat')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('achat') ?>"
                                class="nav-link <?= $title == 'Achats & Approvisionnement' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Achats</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'fournisseurs')): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fournisseurs</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'sous-traitant')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('sous-traitant') ?>"
                                class="nav-link <?= $title == 'Sous-traitants' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sous Traitant</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'stock-general')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('stock-general') ?>"
                                class="nav-link <?= $title == 'Stocks' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stocks</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'engin-materiel')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('engin-materiel') ?>"
                                class="nav-link <?= $title == 'Engin & Materiel' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Engin & Materiel</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'maintenance-carburant')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('maintenance-carburant') ?>"
                                class="nav-link <?= $title == 'Maintenance & Carburant' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Maintenance & Carburant</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'journal-production')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('journal-production') ?>"
                                class="nav-link <?= $title == 'Journal Production' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Journal Production</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'cout-reelle-rentebilite')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('cout-reelle-rentebilite') ?>"
                                class="nav-link <?= $title == 'Coût Réel & Rentabilité' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Coût Réel & Rentabilité</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'evaluation-chantier')): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Evaluation Chantier</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'personnel-chantier')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('personnel-chantier') ?>"
                                class="nav-link <?= $title == 'Personnel Chantier' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Personnel Chantier</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'suivie-paie-chantier')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('suivie-paie-chantier') ?>"
                                class="nav-link <?= $title == 'Suivie Paie Chantier' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Suivie Paie Chantier</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'pointage')): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pointage</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('tech', 'ordre-service')): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ordre service</p>
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </li>
                <?php endif; ?>

                <!-- ============ DAF / FINANCE ============ -->
                <?php if (has_any_access('daf') || has_any_access('compta') || has_any_access('treso') || has_any_access('factu')): ?>
                <li class="nav-item has-treeview <?= in_array($title, $dafTitles, true) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= in_array($title, $dafTitles, true) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>DAF / Finance <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

                        <?php if (has_access('daf', 'finance-dashboard')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('finance-dashboard') ?>"
                                class="nav-link <?= $title == 'Tableau de Bord DAF' ? 'active' : '' ?>">
                                <i class="fas fa-chart-pie nav-icon"></i>
                                <p>Tableau de bord DAF</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- ---- Sous-groupe Comptabilité ---- -->
                        <?php if (has_any_access('compta')): ?>
                        <li
                            class="nav-item has-treeview <?= in_array($title, $comptaTitles, true) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= in_array($title, $comptaTitles, true) ? 'active' : '' ?>">
                                <i class="fas fa-calculator nav-icon"></i>
                                <p>Comptabilité <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if (has_access('compta', 'exercices')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('exercices') ?>"
                                        class="nav-link <?= $title == 'Exercices Comptables' ? 'active' : '' ?>">
                                        <i class="far fa-calendar-alt nav-icon"></i>
                                        <p>Exercices comptables</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('compta', 'account-classes')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('account-classes') ?>"
                                        class="nav-link <?= $title == 'Classes de Comptes' ? 'active' : '' ?>">
                                        <i class="far fa-folder nav-icon"></i>
                                        <p>Classes comptables</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('compta', 'chart-accounts')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('chart-accounts') ?>"
                                        class="nav-link <?= $title == 'Plan Comptable' ? 'active' : '' ?>">
                                        <i class="far fa-list-alt nav-icon"></i>
                                        <p>Plan comptable</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('compta', 'journal-codes')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('journal-codes') ?>"
                                        class="nav-link <?= $title == 'Codes journaux' ? 'active' : '' ?>">
                                        <i class="far fa-bookmark nav-icon"></i>
                                        <p>Codes journaux</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('compta', 'accounting-entrys')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('accounting-entrys') ?>"
                                        class="nav-link <?= $title == 'Écritures Comptables' ? 'active' : '' ?>">
                                        <i class="far fa-edit nav-icon"></i>
                                        <p>Saisie comptable</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('compta', 'journal')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('journal') ?>"
                                        class="nav-link <?= $title == 'Journal Comptable' ? 'active' : '' ?>">
                                        <i class="far fa-file-alt nav-icon"></i>
                                        <p>Journal comptable</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('compta', 'grand-livre')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('grand-livre') ?>"
                                        class="nav-link <?= $title == 'Grand Livre Comptable' ? 'active' : '' ?>">
                                        <i class="far fa-address-book nav-icon"></i>
                                        <p>Grand livre</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('compta', 'balance-generale')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('balance-generale') ?>"
                                        class="nav-link <?= $title == 'Balance Générale' ? 'active' : '' ?>">
                                        <i class="far fa-chart-bar nav-icon"></i>
                                        <p>Balance générale</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('compta', 'cloture-comptable')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('cloture-comptable') ?>"
                                        class="nav-link <?= $title == 'Clôture Comptable' ? 'active' : '' ?>">
                                        <i class="fas fa-lock nav-icon"></i>
                                        <p>Clôture comptable</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <!-- ---- Sous-groupe Trésorerie ---- -->
                        <?php if (has_any_access('treso')): ?>
                        <li
                            class="nav-item has-treeview <?= in_array($title, $tresoTitles, true) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= in_array($title, $tresoTitles, true) ? 'active' : '' ?>">
                                <i class="fas fa-wallet nav-icon"></i>
                                <p>Trésorerie <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if (has_access('treso', 'caisse')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('caisse') ?>"
                                        class="nav-link <?= in_array($title, ['Caisse', 'Journal de caisse', 'Livre de Caisse'], true) ? 'active' : '' ?>">
                                        <i class="fas fa-cash-register nav-icon text-success"></i>
                                        <p>Caisse</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('treso', 'rapport-financier')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('rapport-financier') ?>"
                                        class="nav-link <?= $title == 'Rapport Financier' ? 'active' : '' ?>">
                                        <i class="fas fa-file-invoice-dollar nav-icon text-info"></i>
                                        <p>Rapport Financier</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('treso', 'compte-banques')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('compte-banques') ?>"
                                        class="nav-link <?= $title == 'Comptes bancaires' ? 'active' : '' ?>">
                                        <i class="fas fa-university nav-icon text-primary"></i>
                                        <p>Comptes bancaires</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('treso', 'rapprochement')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('rapprochement') ?>"
                                        class="nav-link <?= $title == 'Rapprochement bancaire' ? 'active' : '' ?>">
                                        <i class="fas fa-exchange-alt nav-icon text-warning"></i>
                                        <p>Rapprochement bancaire</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('treso', 'prevision')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('prevision') ?>"
                                        class="nav-link <?= $title == 'Prévisions de trésorerie' ? 'active' : '' ?>">
                                        <i class="fas fa-chart-line nav-icon text-info"></i>
                                        <p>Prévisions de trésorerie</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <!-- ---- Sous-groupe Facturation ---- -->
                        <?php if (has_any_access('factu')): ?>
                        <li
                            class="nav-item has-treeview <?= in_array($title, $factuTitles, true) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= in_array($title, $factuTitles, true) ? 'active' : '' ?>">
                                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                                <p>Facturation <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if (has_access('factu', 'facture-client')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('facture-client') ?>"
                                        class="nav-link <?= $title == 'Factures clients' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Factures clients</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('factu', 'facture-fournisseur')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('facture-fournisseur') ?>"
                                        class="nav-link <?= $title == 'Factures fournisseurs' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Factures fournisseurs</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('factu', 'paiement')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('paiement') ?>"
                                        class="nav-link <?= $title == 'Paiements' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Paiements</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (has_access('factu', 'echeances')): ?>
                                <li class="nav-item">
                                    <a href="<?= base_url('echeances') ?>"
                                        class="nav-link <?= $title == 'Échéances' ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Échéances</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('daf', 'finance-controle')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('finance/controle') ?>"
                                class="nav-link <?= $title == 'Contrôle de gestion' ? 'active' : '' ?>">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>Contrôle de gestion</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('daf', 'finance-patrimoine')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('finance/patrimoine') ?>"
                                class="nav-link <?= $title == 'Patrimoine' ? 'active' : '' ?>">
                                <i class="fas fa-building nav-icon"></i>
                                <p>Patrimoine</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('daf', 'finance-ged')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('finance/ged') ?>"
                                class="nav-link <?= $title == 'Documents / GED' ? 'active' : '' ?>">
                                <i class="fas fa-folder-open nav-icon"></i>
                                <p>Documents / GED</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('daf', 'finance-report')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('finance/report') ?>"
                                class="nav-link <?= $title == 'Rapports financiers' ? 'active' : '' ?>">
                                <i class="fas fa-chart-bar nav-icon"></i>
                                <p>Rapports financiers</p>
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </li>
                <?php endif; ?>

                <!-- ============ RESSOURCES HUMAINES ============ -->
                <?php if (has_any_access('rh')): ?>
                <li class="nav-item <?= in_array($title, $rhTitles, true) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= in_array($title, $rhTitles, true) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Ressources Humaines <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (has_access('rh', 'rh-dashboard')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('rh-dashboard') ?>"
                                class="nav-link <?= $title == 'Tableau de bord RH' ? 'active' : '' ?>">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <p>Tableau de bord RH</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('rh', 'rh-employes')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('rh-employes') ?>"
                                class="nav-link <?= $title == 'Employés' ? 'active' : '' ?>">
                                <i class="fas fa-id-badge nav-icon"></i>
                                <p>Employés</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('rh', 'rh-contrats')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('rh-contrats') ?>"
                                class="nav-link <?= $title == 'Contrats & mouvements' ? 'active' : '' ?>">
                                <i class="fas fa-file-contract nav-icon"></i>
                                <p>Contrats & mouvements</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('rh', 'rh-registre')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('rh-registre') ?>"
                                class="nav-link <?= $title == "Registre d'employeur" ? 'active' : '' ?>">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Registre d'employeur</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('rh', 'rh-presences')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('rh-presences') ?>"
                                class="nav-link <?= $title == 'Temps & présences' ? 'active' : '' ?>">
                                <i class="fas fa-user-clock nav-icon"></i>
                                <p>Temps & présences</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('rh', 'rh-conges')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('rh-conges') ?>"
                                class="nav-link <?= $title == 'Congés' ? 'active' : '' ?>">
                                <i class="fas fa-umbrella-beach nav-icon"></i>
                                <p>Congés</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('rh', 'rh-paie')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('rh-paie') ?>"
                                class="nav-link <?= $title == 'Paie' ? 'active' : '' ?>">
                                <i class="fas fa-money-bill-wave nav-icon"></i>
                                <p>Paie</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('rh', 'rh-discipline')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('rh-discipline') ?>"
                                class="nav-link <?= $title == 'Discipline' ? 'active' : '' ?>">
                                <i class="fas fa-gavel nav-icon"></i>
                                <p>Discipline</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('rh', 'rh-evaluations')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('rh-evaluations') ?>"
                                class="nav-link <?= $title == 'Évaluations' ? 'active' : '' ?>">
                                <i class="fas fa-clipboard-check nav-icon"></i>
                                <p>Évaluations</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('rh', 'rh-rapports')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('rh-rapports') ?>"
                                class="nav-link <?= $title == 'Rapports & éditions' ? 'active' : '' ?>">
                                <i class="fas fa-chart-bar nav-icon"></i>
                                <p>Rapports & éditions</p>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ============ CRM & CLIENTS ============ -->
                <?php if (has_any_access('crm')): ?>
                <li class="nav-item has-treeview <?= in_array($title, $crmTitles, true) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= in_array($title, $crmTitles, true) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-handshake"></i>
                        <p>CRM & Clients <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (has_access('crm', 'crm-dashboard')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('crm-dashboard') ?>"
                                class="nav-link <?= $title == 'Tableau de Bord CRM' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Tableau de Bord</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('crm', 'crm-clients')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('crm-clients') ?>"
                                class="nav-link <?= $title == 'Clients CRM' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Clients</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('crm', 'crm-devis')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('crm-devis') ?>"
                                class="nav-link <?= $title == 'Devis' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>Devis</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('crm', 'crm-projets') || has_access('crm', 'crm-chantiers')): ?>
                        <li class="nav-header">SUIVI PROJETS</li>
                        <?php endif; ?>

                        <?php if (has_access('crm', 'crm-projets')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('crm-projets') ?>"
                                class="nav-link <?= $title == 'Projets CRM' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-project-diagram"></i>
                                <p>Projets</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('crm', 'crm-chantiers')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('crm-chantiers') ?>"
                                class="nav-link <?= $title == 'Chantiers & Avancement' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-hard-hat"></i>
                                <p>Chantiers & Avancement</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (has_access('crm', 'crm-reporting')): ?>
                        <li class="nav-header">ANALYSE</li>
                        <li class="nav-item">
                            <a href="<?= base_url('crm-reporting') ?>"
                                class="nav-link <?= $title == 'Reporting & Statistiques' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Reporting</p>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ============ ADMINISTRATION ============ -->
                <?php if (has_any_access('admin')): ?>
                <li class="nav-item <?= in_array($title, $adminTitles, true) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= in_array($title, $adminTitles, true) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Administration <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (has_access('admin', 'users')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('users') ?>"
                                class="nav-link <?= $title == 'Utilisateurs' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Utilisateurs</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('admin', 'matrice-access')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('matrice-access') ?>"
                                class="nav-link <?= $title == 'Matrice des access' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Matrice des access</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('admin', 'roles-permissions')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('roles-permissions') ?>"
                                class="nav-link <?= $title == 'Rôles & Permissions' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rôles & Permissions</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (has_access('admin', 'settings')): ?>
                        <li class="nav-item">
                            <a href="<?= base_url('settings') ?>"
                                class="nav-link <?= $title == 'Paramètres' ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Paramètres</p>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>
</aside>