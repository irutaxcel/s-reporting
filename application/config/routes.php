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

$route['main-dashboard'] = 'DashboardController/mainDashboard';

$route['personnel-chantier'] = 'TechController/personeChantier';
$route['personnel-chantier/store'] = 'TechController/storePersonnelChantier';

$route['personnel-update'] = 'TechController/personnelUpdate';

$route['personnel-delete/(:num)'] = 'TechController/personnelDelete/$1';

$route['personnel-chantier-print'] = 'TechController/personnelChantierPrint';

$route['achat'] = 'TechController/achatMateriels';

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

$route['engin-materiel'] = 'TechController/enginMateriel';
$route['engin-materiel-store'] = 'TechController/enginMaterielStore';

$route['engin-materiel-update'] = 'TechController/enginMaterielUpdate';

$route['engin-materiel-delete'] = 'TechController/enginMaterielDelete';

$route['engin-materiel-files'] = 'TechController/enginMaterielFiles';

$route['engin-photo-delete'] = 'TechController/enginPhotoDelete';
$route['engin-document-delete'] = 'TechController/enginDocumentDelete';

$route['maintenance-carburant'] = 'TechController/maintenanceCarburant';
$route['add-new-ravitaillement'] = 'TechController/addNewRavitaillement';

$route['new-technique-maintenance'] = 'TechController/newTechniqueMaintenance';

$route['cout-reelle-rentebilite'] = 'TechController/coutReelleRentebilite';


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
$route['finance/caisse-store'] = 'FinanceController/caisseStore';
$route['finance/cashbox-operation-store']
    = 'FinanceController/cashboxOperationStore';

$route['encaissements'] = 'FinanceController/encaissements';

$route['decaissements'] = 'FinanceController/decaissements';
