<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Authentication';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['sign-in'] = 'Authentication';
$route['auth-login'] = 'Authentication/authlogin';
$route['auth-logout'] = 'Authentication/logout';

$route['dashboard'] = 'DashboardController/mainDashboard';

$route['main-dashboard'] = 'DashboardController/mainDashboard';

$route['direction-dashboard'] = 'Dgcontroller/dashboard';

$route['direction-indicateurs'] = 'Dgcontroller/indicateurPerformance';

$route['direction-reporting-general'] = 'Dgcontroller/reportingGeneral';

$route['direction-reporting-analytique'] = 'Dgcontroller/reportingAnalytique';

$route['direction-statistiques'] = 'Dgcontroller/statistique';

$route['direction-projets'] = 'Dgcontroller/projectFollow';

$route['synthese-demandes'] = 'Dgcontroller/syntheseDemandes';
$route['direction-archives'] = 'Dgcontroller/directionArchives';

$route['direction-relation-publique'] = 'Dgcontroller/directionRelationPublique';
$route['save-relations-publique'] = 'Dgcontroller/saveRelationsPublique';

$route['direction/delete-sortie-rp'] = 'Dgcontroller/deleteSortieRP';

// Route pour mettre à jour le montant autorisé
$route['direction/update-montant-autorise'] = 'Dgcontroller/updateMontantAutorise';

// Route pour l'impression
$route['direction/imprimer-synthese'] = 'Dgcontroller/imprimerSynthese';

$route['personnel-chantier'] = 'TechController/personeChantier';
$route['personnel-chantier/store'] = 'TechController/storePersonnelChantier';

$route['personnel-update'] = 'TechController/personnelUpdate';

$route['personnel-delete/(:num)'] = 'TechController/personnelDelete/$1';

$route['personnel-chantier-print'] = 'TechController/personnelChantierPrint';

$route['achat'] = 'TechController/achatMateriels';

$route['achats-materiels'] = 'TechController/achatMateriels';

$route['tech/store-bon-paiement'] = 'TechController/storeBonPaiement';

$route['tech/get-bon-paiement/(:num)']
    = 'TechController/get_bon_paiement/$1';

$route['tech/update-bon-paiement']
    = 'TechController/update_bon_paiement';

$route['tech/store_achat_materiel'] = 'TechController/store_achat_materiel';

$route['tech/valider-achat'] = 'TechController/valider_achat';

$route['tech/get-achat-materiel/(:num)'] = 'TechController/get_achat_materiel/$1';
$route['tech/update-achat-materiel'] = 'TechController/update_achat_materiel';

$route['tech/delete-achat-materiel'] = 'TechController/delete_achat_materiel';

$route['tech/print-achat/(:num)'] = 'TechController/print_achat/$1';

$route['projects'] = 'TechController/projects';
$route['tech/project-store'] = 'TechController/project_store';
$route['tech/project-edit-ajax'] = 'TechController/projectEditAjax';
$route['tech/project-update'] = 'TechController/projectUpdate';
$route['tech/project-delete-ajax'] = 'TechController/projectDeleteAjax';

$route['chantiers'] = 'TechController/chantiers';

$route['chantier-store'] = 'TechController/storeChantier';
$route['chantier-edit-ajax'] = 'TechController/getChantier';
$route['chantier-update'] = 'TechController/updateChantier';
$route['chantier-delete-ajax'] = 'TechController/deleteChantierAjax';

$route['sous-traitant'] = 'TechController/subTraitant';
$route['subcontractor-store'] = 'TechController/store_subcontractor';
$route['subcontractor-update'] = 'TechController/update_subcontractor';
$route['subcontractor-delete/(:num)'] = 'TechController/delete_subcontractor/$1';

$route['stock-general'] = 'TechController/stockGeneral';

$route['stock-article-store'] = 'TechController/stockArticleStore';
$route['stock-emplacement-store'] = 'TechController/stockEmplacementStore';
$route['stock-quantite-store'] = 'TechController/stockQuantiteStore';

$route['stock-bl-requests']          = 'TechController/blPaidRequests';
$route['stock-bl-items/(:num)']      = 'TechController/blRequestItems/$1';
$route['stock-bl-store']             = 'TechController/blStore';

$route['stock-delivery-notes']              = 'TechController/deliveryNotes';
$route['stock-delivery-note-detail/(:num)'] = 'TechController/deliveryNoteDetail/$1';
$route['stock-delivery-note-print/(:num)']  = 'TechController/deliveryNotePrint/$1';

// ---- Engin & Materiel ------------------------------------------------------
$route['engin-materiel']                = 'TechController/enginMateriel';
$route['engin-materiel-store']          = 'TechController/enginMaterielStore';
$route['engin-materiel-update']         = 'TechController/enginMaterielUpdate';
$route['engin-materiel-get/(:num)']     = 'TechController/enginMaterielGet/$1';
$route['engin-materiel-delete']         = 'TechController/enginMaterielDelete';
$route['engin-materiel-export']         = 'TechController/enginMaterielExport';
$route['engin-materiel-dossier/(:num)'] = 'TechController/enginMaterielDossier/$1';
$route['engin-photo-delete']            = 'TechController/enginPhotoDelete';
$route['engin-photo-principale']        = 'TechController/enginPhotoPrincipale';
$route['engin-document-delete']         = 'TechController/enginDocumentDelete';
$route['engin-affecter']                = 'TechController/enginAffecter';
$route['engin-reformer']                = 'TechController/enginReformer';

// ---- Maintenance & Carburant ---------------------------------------------
$route['maintenance-carburant']             = 'TechController/maintenanceCarburant';
$route['maintenance-carburant-export']      = 'TechController/maintenanceCarburantExport';
$route['add-new-ravitaillement']            = 'TechController/addNewRavitaillement';
$route['engin-fuel-update']                 = 'TechController/enginFuelUpdate';
$route['engin-fuel-get/(:num)']             = 'TechController/enginFuelGet/$1';
$route['engin-fuel-cancel']                 = 'TechController/enginFuelCancel';
$route['new-technique-maintenance']         = 'TechController/newTechniqueMaintenance';
$route['engin-maintenance-update']          = 'TechController/enginMaintenanceUpdate';
$route['engin-maintenance-get/(:num)']      = 'TechController/enginMaintenanceGet/$1';
$route['engin-maintenance-status']          = 'TechController/enginMaintenanceStatus';
$route['engin-maintenance-document-delete'] = 'TechController/enginMaintenanceDocumentDelete';
$route['engin-panne-store']                 = 'TechController/enginPanneStore';
$route['engin-panne-status']                = 'TechController/enginPanneStatus';

$route['cout-reelle-rentebilite'] = 'TechController/coutReelleRentebilite';

$route['journal-production'] = 'TechController/journalProduction';

$route['journalProduction-create'] = 'TechController/journalProductionCreate';

$route['journalProduction-get/(:num)'] = 'TechController/getJournalProduction/$1';

$route['journalProduction-update'] = 'TechController/updateJournalProduction';

$route['journalProduction-delete'] = 'TechController/deleteJournalProduction';

$route['journalProduction-print/(:num)'] = 'TechController/printJournalProduction/$1';

$route['suivie-paie-chantier'] = 'TechController/chantierPaie';


$route['finance-dashboard'] = 'FinanceController/financeDashboard';

$route['exercices'] = 'FinanceController/exercicesfinance';

$route['finance/exercices'] = 'FinanceController/exercicesfinance';
$route['finance/exercise-store'] = 'FinanceController/exercise_store';
$route['finance/exercise-close/(:num)'] = 'FinanceController/exercise_close/$1';

$route['finance/exercise-update'] = 'FinanceController/exercise_update';

$route['account-classes'] = 'FinanceController/account_classes';
$route['finance/account-class-update'] = 'FinanceController/account_class_update';
$route['finance/account-class-delete/(:num)'] = 'FinanceController/account_class_delete/$1';
$route['chart-accounts'] = 'FinanceController/chart_accounts';

$route['finance/chart-account-store'] = 'FinanceController/chart_account_store';
$route['finance/chart-account-update'] = 'FinanceController/chart_account_update';
$route['finance/chart-account-delete/(:num)'] = 'FinanceController/chart_account_delete/$1';


$route['journal-codes'] = 'FinanceController/journal_codes';
$route['finance/journal-code-store'] = 'FinanceController/journal_code_store';
$route['finance/journal-code-update'] = 'FinanceController/journal_code_update';
$route['finance/journal-code-delete/(:num)'] = 'FinanceController/journal_code_delete/$1';

$route['accounting-entrys'] = 'FinanceController/accounting_entries';
$route['finance/accounting-entry-store'] = 'FinanceController/accounting_entry_store';

$route['finance/accounting-entry-edit/(:num)'] = 'FinanceController/accounting_entry_edit/$1';
$route['finance/accounting-entry-update'] = 'FinanceController/accounting_entry_update';
$route['finance/accounting-entry-delete'] = 'FinanceController/accounting_entry_delete';

$route['finance/accounting-entry-view/(:num)'] = 'FinanceController/accounting_entry_view/$1';

$route['journal'] = 'FinanceController/journal';

$route['grand-livre'] = 'FinanceController/grand_livre';

$route['balance-generale'] = 'FinanceController/balance_generale';

$route['cloture-comptable'] = 'FinanceController/cloture_comptable';


$route['caisse'] = 'FinanceController/caisse';

$route['finance-journal-caisse']                = 'FinanceController/financeJournalCaisse';
$route['finance-journal-caisse/detail/(:num)']  = 'FinanceController/financeJournalCaisseDetail/$1';
$route['finance-journal-caisse/export']         = 'FinanceController/financeJournalCaisseExport';

$route['finance-cashbox/(:num)'] = 'FinanceController/financeCashbox/$1';

$route['caisse-journal'] = 'FinanceController/caisseJournal';

$route['finance/caisse-store'] = 'FinanceController/caisseStore';

$route['finance-caisse-store'] = 'FinanceController/caisseStore';

$route['finance/cashbox-operation-store']
    = 'FinanceController/cashboxOperationStore';

$route['finance-cashbox-operation-store']
    = 'FinanceController/cashboxOperationStore';

$route['finance-cashbox-print/(:num)'] = 'FinanceController/financeCashboxPrint/$1';

$route['finance-rapport-financier-print'] = 'FinanceController/rapportFinancierPrint';

$route['cashbox-operation-store'] = 'FinanceController/cashboxOperationStore';

$route['rapport-financier'] = 'FinanceController/rapportFinancier';

$route['finance-retour_caisse'] = 'FinanceController/retourCaisseStore';

/* ===================== BANQUE V2 ===================== */
$route['compte-banques']             = 'FinanceController/banques';
$route['bank-account-store']         = 'FinanceController/bankAccountStore';
$route['bank-account-update']        = 'FinanceController/bankAccountUpdate';
$route['bank-account-view/(:num)']   = 'FinanceController/bankAccountView/$1';
$route['bank-operation-store']       = 'FinanceController/bankOperationStore';
$route['bank-operation-view/(:num)'] = 'FinanceController/bankOperationView/$1';
$route['bank-operation-validate']    = 'FinanceController/bankOperationValidate';
$route['bank-operation-cancel']      = 'FinanceController/bankOperationCancel';

$route['banque-livre']               = 'FinanceController/bankLedger';
$route['banque-livre/(:num)']        = 'FinanceController/bankLedger/$1';
$route['banque-livre-print/(:num)']  = 'FinanceController/bankLedgerPrint/$1';
$route['banque-livre-export/(:num)'] = 'FinanceController/bankLedgerExport/$1';

/* ===================== RAPPROCHEMENT BANCAIRE ===================== */
$route['rapprochement/(:num)']   = 'FinanceController/reconciliationWorkspace/$1';
$route['reconciliation-store']   = 'FinanceController/reconciliationStore';
$route['reconciliation-cancel']  = 'FinanceController/reconciliationCancel';
$route['statement-line-store']   = 'FinanceController/statementLineStore';
$route['statement-line-delete']  = 'FinanceController/statementLineDelete';
$route['statement-import']       = 'FinanceController/statementImport';
$route['statement-template']     = 'FinanceController/statementTemplate';

$route['encaissements'] = 'FinanceController/encaissements';

$route['decaissements'] = 'FinanceController/decaissements';

$route['rapprochement'] = 'FinanceController/rapprochement';


$route['rh-dashboard'] = 'RhController/index';
$route['rh-employes'] = 'RhController/employes';
$route['rh-employes-store'] = 'RhController/employes_store';
$route['rh-next_matricule'] = 'RhController/next_matricule';

$route['rh-employe_get/(:num)'] = 'RhController/employe_get/$1';

$route['rh-employes-update'] = 'RhController/employes_update';

// $route['rh-contrats'] = 'RhController/rhContrats';

$route['rh-contrats']       = 'RhController/rhContrats';
$route['rh-contrats-store'] = 'RhController/contrats_store';

$route['rh-mouvements-store'] = 'RhController/mouvements_store';

$route['rh-registre'] = 'RhController/rhRegistre';

$route['rh-presences']       = 'RhController/rhPresences';
$route['rh-presences-store'] = 'RhController/presences_store';

$route['rh-conges']       = 'RhController/rhConges';
$route['rh-conges-store'] = 'RhController/conges_store';

$route['rh-paie'] = 'RhController/rhPaie';

$route['rh-conformite'] = 'RhController/rhConfirmite';

$route['rh-discipline']       = 'RhController/rhDiscipline';
$route['rh-discipline-store'] = 'RhController/discipline_store';

$route['rh-evaluations']       = 'RhController/rhEvaluations';
$route['rh-evaluations-store'] = 'RhController/evaluations_store';

$route['rh-rapports'] = 'RhController/rhRapport';

$route['rh-parametres'] = 'RhController/rhParametres';

$route['prevision'] = 'FinanceController/prevision';

/* ===================== PRÉVISIONS DE TRÉSORERIE ===================== */
$route['prevision-store']   = 'FinanceController/previsionStore';
$route['prevision-realize'] = 'FinanceController/previsionRealize';
$route['prevision-cancel']  = 'FinanceController/previsionCancel';
$route['prevision-export']  = 'FinanceController/previsionExport';

$route['facture-client'] = 'FinanceController/factureClient';
$route['facture-fournisseur'] = 'FinanceController/factureFournisseur';
$route['paiement'] = 'FinanceController/paiement';
$route['echeances'] = 'FinanceController/echeances';

$route['crm-dashboard'] = 'CrmController/index';

$route['crm-clients'] = 'CrmController/clients';
$route['crm-clients-add'] = 'CrmController/addClient';

$route['crm-clients-update'] = 'CrmController/updateClient';
$route['crm-clients-delete/(:num)'] = 'CrmController/deleteClient/$1';

$route['crm-projets'] = 'CrmController/projets';

$route['crm-chantiers-add'] = 'CrmController/addChantier';

$route['crm-chantiers-avancement'] = 'CrmController/chantiers';
$route['crm-chantiers-update-progress'] = 'CrmController/updateProgress';

$route['crm-reporting'] = 'CrmController/reporting';

$route['crm-devis'] = 'CrmController/devis';
$route['crm-chantiers'] = 'CrmController/chantiersRequest';
$route['crm-devis-add'] = 'CrmController/addDevis';
$route['crm-contrat-add'] = 'CrmController/addContrat';

$route['users'] = 'AdminController/users';
$route['utilisateurs-store'] = 'AdminController/storeUser';

$route['utilisateurs-update'] = 'AdminController/updateUser';

$route['administration/utilisateurs/toggleStatus'] = 'AdminController/toggleStatus';

$route['administration/utilisateurs/delete'] = 'AdminController/deleteUser';

$route['matrice-access']        = 'AdminController/matriceAccess';
$route['matrice-access/load']   = 'AdminController/matriceLoad';
$route['matrice-access/save']   = 'AdminController/matriceSave';

$route['roles-permissions']          = 'AdminController/rolesPermissions';
$route['roles/save']                 = 'AdminController/roleSave';
$route['roles/delete']               = 'AdminController/roleDelete';
$route['roles/permissions/load']     = 'AdminController/rolePermissionsLoad';
$route['roles/permissions/save']     = 'AdminController/rolePermissionsSave';

$route['settings'] = 'AdminController/settings';
