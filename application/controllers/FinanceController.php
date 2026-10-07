<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinanceController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('AuthModel', 'auth');
        $this->load->model('TechModel', 'tech');
        $this->load->model('FinanceModel', 'finance');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function financeDashboard()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Tableau de Bord DAF';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/finance/financeDashboard');
        $this->load->view('v1/components/layout/footer');
    }

    public function exercicesfinance()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Exercices Comptables';

        $data['exercises'] = $this->finance->get_exercises();
        $data['active_exercise'] = $this->finance->get_active_exercise();
        $data['total_exercises'] = $this->finance->count_exercises();
        $data['total_open'] = $this->finance->count_by_status('open');
        $data['total_closed'] = $this->finance->count_by_status('closed');

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/finance/exercicesfinance', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function exercise_store()
    {
        $this->load->model('FinanceModel', 'finance');

        $data = [
            'name'       => $this->input->post('name', true),
            'year'       => $this->input->post('year', true),
            'start_date' => $this->input->post('start_date', true),
            'end_date'   => $this->input->post('end_date', true),
            'status'     => $this->input->post('status', true),
            'is_active'  => $this->input->post('is_active', true),
            'created_by' => $this->session->userdata('id') ?? 1
        ];

        $this->finance->insert_exercise($data);

        $this->session->set_flashdata('success', 'Exercice comptable créé avec succès.');
        redirect('exercices');
    }

    public function exercise_close($id)
    {
        $this->load->model('FinanceModel', 'finance');

        $this->finance->close_exercise($id);

        $this->session->set_flashdata('success', 'Exercice comptable clôturé avec succès.');
        redirect('exercices');
    }

    public function exercise_update()
    {
        $this->load->model('FinanceModel', 'finance');

        $id = $this->input->post('id');

        $data = [
            'name'       => $this->input->post('name', true),
            'year'       => $this->input->post('year', true),
            'start_date' => $this->input->post('start_date', true),
            'end_date'   => $this->input->post('end_date', true),
            'status'     => $this->input->post('status', true),
            'is_active'  => $this->input->post('is_active', true),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->finance->update_exercise($id, $data);

        $this->session->set_flashdata('success', 'Exercice comptable modifié avec succès.');
        redirect('exercices');
    }

    public function account_classes()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Classes de Comptes';

        $allClasses = $this->finance->get_account_classes();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/finance/account_classes', ['account_classes' => $allClasses]);
        $this->load->view('v1/components/layout/footer');
    }

    public function account_class_update()
    {
        $this->load->model('FinanceModel', 'finance');

        $id = $this->input->post('id');

        $data = [
            'class_number' => $this->input->post('class_number', true),
            'class_name'   => $this->input->post('class_name', true),
            'nature'       => $this->input->post('nature', true),
            'description'  => $this->input->post('description', true),
            'status'       => $this->input->post('status', true),
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        $this->finance->update_account_class($id, $data);

        $this->session->set_flashdata('success', 'Classe comptable modifiée avec succès.');
        redirect('account-classes');
    }

    public function account_class_delete($id)
    {
        $this->load->model('FinanceModel', 'finance');

        $this->finance->delete_account_class($id);

        $this->session->set_flashdata('success', 'Classe comptable supprimée avec succès.');
        redirect('account-classes');
    }

    public function chart_accounts()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Plan Comptable';

        $allAccounts = $this->finance->get_chart_accounts();

        $account_classes = $this->finance->get_account_classes();

        $allChantier = $this->tech->getAllChantiers();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/finance/chart_accounts', ['chart_accounts' => $allAccounts, 'account_classes' => $account_classes, 'chantiers' => $allChantier]);
        $this->load->view('v1/components/layout/footer');
    }

    public function chart_account_store()
    {
        $this->load->model('FinanceModel', 'finance');

        $data = [

            'account_code'     => trim($this->input->post('account_code', true)),
            'account_name'     => trim($this->input->post('account_name', true)),
            'class_id'         => $this->input->post('class_id', true),
            'account_type'     => $this->input->post('account_type', true),
            'chantier_id'      => $this->input->post('chantier_id', true) ?: NULL,

            'opening_balance'  => $this->input->post('opening_balance', true),
            'current_balance'  => $this->input->post('opening_balance', true),

            'currency'         => $this->input->post('currency', true),

            'allow_entry'      => $this->input->post('allow_entry', true),

            'status'           => $this->input->post('status', true),

            'description'      => trim($this->input->post('description', true)),

            'created_by'       => $this->session->userdata('id'),

        ];

        // Vérifier que le code n'existe pas déjà
        if ($this->finance->chart_account_exist($data['account_code'])) {

            $this->session->set_flashdata(
                'error',
                'Ce code comptable existe déjà.'
            );

            redirect('chart-accounts');
        }

        $this->finance->insert_chart_account($data);

        $this->session->set_flashdata(
            'success',
            'Compte comptable créé avec succès.'
        );

        redirect('chart-accounts');
    }

    public function chart_account_update()
    {
        $this->load->model('FinanceModel', 'finance');

        $id = $this->input->post('id');

        $data = [
            'account_code'    => trim($this->input->post('account_code', true)),
            'account_name'    => trim($this->input->post('account_name', true)),
            'class_id'        => $this->input->post('class_id', true),
            'account_type'    => $this->input->post('account_type', true),
            'chantier_id'     => $this->input->post('chantier_id', true) ?: NULL,
            'opening_balance' => $this->input->post('opening_balance', true),
            'current_balance' => $this->input->post('opening_balance', true),
            'currency'        => $this->input->post('currency', true),
            'allow_entry'     => $this->input->post('allow_entry', true),
            'status'          => $this->input->post('status', true),
            'description'     => trim($this->input->post('description', true)),
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        $this->finance->update_chart_account($id, $data);

        $this->session->set_flashdata('success', 'Compte comptable modifié avec succès.');
        redirect('chart-accounts');
    }

    public function chart_account_delete($id)
    {
        $this->load->model('FinanceModel', 'finance');

        $this->finance->delete_chart_account($id);

        $this->session->set_flashdata(
            'success',
            'Compte comptable supprimé avec succès.'
        );

        redirect('chart-accounts');
    }

    public function journal_codes()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Codes journaux';

        $allAccounts = $this->finance->get_chart_accounts();

        $allJournalCodes = $this->finance->get_journal_codes();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/finance/journal_codes', ['journalCodes' => $allJournalCodes, 'chart_accounts' => $allAccounts]);
        $this->load->view('v1/components/layout/footer');
    }

    public function journal_code_store()
    {
        $data = array(

            'journal_code'       => strtoupper(trim($this->input->post('journal_code'))),
            'journal_name'       => trim($this->input->post('journal_name')),
            'journal_type'       => $this->input->post('journal_type'),

            'default_account_id' => !empty($this->input->post('default_account_id'))
                ? $this->input->post('default_account_id')
                : NULL,

            'allow_entry'        => $this->input->post('allow_entry'),

            'status'             => $this->input->post('status'),

            'description'        => trim($this->input->post('description')),

            'created_by'         => $this->session->userdata('user_id'),

            'created_at'         => date('Y-m-d H:i:s')

        );

        $this->finance->insert_journal_code($data);

        $this->session->set_flashdata(
            'success',
            'Code journal enregistré avec succès.'
        );

        redirect('journal-codes');
    }

    public function journal_code_update()
    {
        $id = $this->input->post('id');

        $data = array(

            'journal_code'       => $this->input->post('journal_code'),
            'journal_name'       => $this->input->post('journal_name'),
            'journal_type'       => $this->input->post('journal_type'),
            'default_account_id' => $this->input->post('default_account_id') ?: NULL,
            'allow_entry'        => $this->input->post('allow_entry'),
            'status'             => $this->input->post('status'),
            'description'        => $this->input->post('description'),
            'updated_at'         => date('Y-m-d H:i:s')

        );

        $this->finance->update_journal_code($id, $data);

        $this->session->set_flashdata(
            'success',
            'Code journal modifié avec succès.'
        );

        redirect('journal-codes');
    }

    public function journal_code_delete($id)
    {
        $this->finance->delete_journal_code($id);

        $this->session->set_flashdata(
            'success',
            'Code journal supprimé avec succès.'
        );

        redirect('journal-codes');
    }

    public function accounting_entries()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Écritures Comptables';

        $data['title'] = $title;

        $data['accounting_entries'] = $this->finance->get_accounting_entries();

        $data['exercises'] = $this->finance->get_exercises();
        $data['journalCodes'] = $this->finance->get_journal_codes();
        $data['chart_accounts'] = $this->finance->get_chart_accounts();
        $data['chantiers'] = $this->tech->getAllChantier();


        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/accounting_entries', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }


    public function accounting_entry_store()
    {
        $this->load->model('FinanceModel', 'finance');

        $debitAccounts  = $this->input->post('debit_account_id');
        $creditAccounts = $this->input->post('credit_account_id');
        $lineLabels     = $this->input->post('line_label');
        $debits         = $this->input->post('debit');
        $credits        = $this->input->post('credit');
        $hasTva         = $this->input->post('has_tva');
        $tvaTypes       = $this->input->post('tva_type');
        $tvaRates       = $this->input->post('tva_rate');
        $tvaAmounts     = $this->input->post('tva_amount');

        if (empty($debitAccounts) || count($debitAccounts) < 2) {
            $this->session->set_flashdata('error', 'Une écriture comptable doit contenir au minimum deux lignes.');
            redirect('accounting-entrys');
            return;
        }

        $totalDebit  = 0;
        $totalCredit = 0;
        $totalTva    = 0;

        foreach ($debits as $k => $debit) {
            $totalDebit  += (float) $debit;
            $totalCredit += (float) $credits[$k];
            $totalTva    += (float) $tvaAmounts[$k];
        }

        if ($totalDebit <= 0 || round($totalDebit, 2) != round($totalCredit, 2)) {
            $this->session->set_flashdata('error', 'Écriture non équilibrée. Le total débit doit être égal au total crédit.');
            redirect('accounting-entrys');
            return;
        }

        $pieceNumber = $this->input->post('piece_number');

        if (empty($pieceNumber)) {
            $pieceNumber = 'PC-' . date('Y') . '-' . str_pad(time() % 100000, 5, '0', STR_PAD_LEFT);
        }

        $entryData = [
            'piece_number'   => $pieceNumber,
            'exercise_id'    => $this->input->post('exercise_id'),
            'journal_id'     => $this->input->post('journal_id'),
            'operation_date' => $this->input->post('entry_date'),
            'reference'      => $this->input->post('piece_number'),
            'general_label'  => $this->input->post('label'),
            'chantier_id'    => $this->input->post('chantier_id') ?: NULL,
            'currency'       => $this->input->post('currency'),
            'total_debit'    => $totalDebit,
            'total_credit'   => $totalCredit,
            'total_tva'      => $totalTva,
            'observation'    => $this->input->post('note'),
            'status'         => 'draft',
            'created_by'     => $this->session->userdata('user_id')
        ];

        $this->db->trans_start();

        $entryId = $this->finance->insert_accounting_entry($entryData);

        foreach ($debitAccounts as $k => $debitAccountId) {

            if (empty($debitAccountId) || empty($creditAccounts[$k])) {
                continue;
            }

            $lineHasTva = isset($hasTva[$k]) ? (int) $hasTva[$k] : 0;

            $lineData = [
                'entry_id'          => $entryId,
                'debit_account_id'  => $debitAccountId,
                'credit_account_id' => $creditAccounts[$k],
                'line_label'        => $lineLabels[$k],
                'debit'             => (float) $debits[$k],
                'credit'            => (float) $credits[$k],
                'has_tva'           => $lineHasTva,
                'tva_type'          => $lineHasTva == 1 ? ($tvaTypes[$k] ?? NULL) : NULL,
                'tva_rate'          => $lineHasTva == 1 ? (float) $tvaRates[$k] : 0,
                'tva_amount'        => $lineHasTva == 1 ? (float) $tvaAmounts[$k] : 0,
            ];

            $this->finance->insert_accounting_entry_line($lineData);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Erreur lors de l’enregistrement de l’écriture comptable.');
            redirect('accounting-entrys');
            return;
        }

        $this->session->set_flashdata('success', 'Écriture comptable enregistrée avec succès.');
        redirect('accounting-entrys');
    }

    public function accounting_entry_edit($id)
    {
        $entry = $this->finance->get_accounting_entry_by_id($id);
        $lines = $this->finance->get_accounting_entry_lines($id);

        echo json_encode([
            'entry' => $entry,
            'lines' => $lines
        ]);
    }

    public function accounting_entry_update()
    {
        $this->load->model('FinanceModel', 'finance');

        $entryId = $this->input->post('id');

        if (!$entryId) {
            show_404();
        }

        /*
        |--------------------------------------------------------------------------
        | Récupération des données
        |--------------------------------------------------------------------------
        */

        $debitAccounts  = $this->input->post('debit_account_id');
        $creditAccounts = $this->input->post('credit_account_id');
        $lineLabels     = $this->input->post('line_label');
        $debits         = $this->input->post('debit');
        $credits        = $this->input->post('credit');

        $hasTva         = $this->input->post('has_tva');
        $tvaTypes       = $this->input->post('tva_type');
        $tvaRates       = $this->input->post('tva_rate');
        $tvaAmounts     = $this->input->post('tva_amount');

        $totalDebit  = 0;
        $totalCredit = 0;
        $totalTva    = 0;

        foreach ($debits as $k => $value) {

            $totalDebit  += (float)$debits[$k];
            $totalCredit += (float)$credits[$k];
            $totalTva    += (float)$tvaAmounts[$k];
        }

        if ($totalDebit <= 0 || round($totalDebit, 2) != round($totalCredit, 2)) {

            $this->session->set_flashdata(
                'error',
                'Le débit doit être égal au crédit.'
            );

            redirect('accounting-entrys');
            return;
        }

        /*
    |--------------------------------------------------------------------------
    | Mise à jour entête
    |--------------------------------------------------------------------------
    */

        $entryData = [

            'exercise_id'   => $this->input->post('exercise_id'),
            'journal_id'    => $this->input->post('journal_id'),
            'operation_date' => $this->input->post('entry_date'),
            'piece_number'  => $this->input->post('piece_number'),
            'reference'     => $this->input->post('piece_number'),
            'general_label' => $this->input->post('label'),
            'chantier_id'   => $this->input->post('chantier_id') ?: NULL,
            'currency'      => $this->input->post('currency'),
            'total_debit'   => $totalDebit,
            'total_credit'  => $totalCredit,
            'total_tva'     => $totalTva,
            'observation'   => $this->input->post('note')

        ];

        $this->finance->update_accounting_entry($entryId, $entryData);

        /*
        |--------------------------------------------------------------------------
        | Suppression anciennes lignes
        |--------------------------------------------------------------------------
        */

        $this->finance->delete_accounting_entry_lines($entryId);

        /*
        |--------------------------------------------------------------------------
        | Réinsertion
        |--------------------------------------------------------------------------
        */

        foreach ($debitAccounts as $k => $debitAccountId) {

            if (empty($debitAccountId) || empty($creditAccounts[$k])) {
                continue;
            }

            $lineHasTva = isset($hasTva[$k]) ? (int)$hasTva[$k] : 0;

            $line = [

                'entry_id' => $entryId,

                'debit_account_id' => $debitAccountId,

                'credit_account_id' => $creditAccounts[$k],

                'line_label' => $lineLabels[$k],

                'debit' => (float)$debits[$k],

                'credit' => (float)$credits[$k],

                'has_tva' => $lineHasTva,

                'tva_type' => $lineHasTva ? $tvaTypes[$k] : NULL,

                'tva_rate' => $lineHasTva ? (float)$tvaRates[$k] : 0,

                'tva_amount' => $lineHasTva ? (float)$tvaAmounts[$k] : 0

            ];

            $this->finance->insert_accounting_entry_line($line);
        }

        $this->session->set_flashdata(
            'success',
            'Écriture comptable modifiée avec succès.'
        );

        redirect('accounting-entrys');
    }

    public function accounting_entry_delete()
    {
        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode([
                'status' => false,
                'message' => 'Identifiant invalide.'
            ]);
            return;
        }

        /*
    |------------------------------------------------------------
    | Suppression des lignes
    |------------------------------------------------------------
    */

        $this->finance->delete_accounting_entry_lines($id);

        /*
    |------------------------------------------------------------
    | Suppression de l'entête
    |------------------------------------------------------------
    */

        $this->finance->delete_accounting_entry($id);

        echo json_encode([

            'status' => true,

            'message' => 'Écriture comptable supprimée avec succès.'

        ]);
    }

    public function accounting_entry_view($id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $entry = $this->finance->get_accounting_entry_by_id($id);
        $lines = $this->finance->get_accounting_entry_lines_details($id);

        echo json_encode([
            'entry' => $entry,
            'lines' => $lines
        ]);
    }

    public function journal()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Journal Comptable';

        $data['title'] = $title;
        $data['entries'] = $this->finance->get_journal_entries();

        foreach ($data['entries'] as $entry) {
            $entry->lines = $this->finance->get_journal_entry_lines($entry->id);
        }

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/journal', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    public function grand_livre()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Grand Livre Comptable';

        $data['title'] = $title;

        $rows = $this->finance->get_grand_livre_entries();

        $accounts = [];

        foreach ($rows as $row) {

            $accountId = $row->account_id;

            if (!isset($accounts[$accountId])) {
                $accounts[$accountId] = [
                    'account_code' => $row->account_code,
                    'account_name' => $row->account_name,
                    'total_debit'  => 0,
                    'total_credit' => 0,
                    'balance'      => 0,
                    'lines'        => []
                ];
            }

            $accounts[$accountId]['total_debit']  += (float) $row->debit_amount;
            $accounts[$accountId]['total_credit'] += (float) $row->credit_amount;

            $accounts[$accountId]['balance'] =
                $accounts[$accountId]['total_debit'] -
                $accounts[$accountId]['total_credit'];

            $row->running_balance = $accounts[$accountId]['balance'];

            $accounts[$accountId]['lines'][] = $row;
        }

        $data['accounts'] = $accounts;



        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/grand_livre', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    public function balance_generale()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $this->load->model('FinanceModel', 'finance');

        $title = 'Balance Générale';

        $data['title'] = $title;

        $data['balance'] = $this->finance->get_balance_generale();

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/balance_generale', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    public function cloture_comptable()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $this->load->model('FinanceModel', 'finance');

        $title = 'Clôture Comptable';

        $data['title'] = $title;
        $data['exercises'] = $this->finance->get_exercises();
        $data['active_exercise'] = $this->finance->get_active_exercise();
        $data['closing_stats'] = $this->finance->get_closing_stats();
        $data['closing_checks'] = $this->finance->get_closing_checks();
        $data['closing_history'] = $this->finance->get_closing_history();

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/cloture_comptable', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }



    public function caisse()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data = [];

        $data['title'] = 'Caisse';

        /* Code caisse généré automatiquement depuis la table */
        $data['nextCashboxCode'] = $this->finance->generateCashboxCode();

        /* DA attachées à un bon de paiement et non payées */
        $data['payablePurchaseRequests'] = $this->finance->getPayablePurchaseRequests();

        /* Drapeaux d'unicité des rôles (pour la modale) */
        $data['hasPrincipale'] = $this->finance->cashboxRoleExists('principale');
        $data['hasSecondaire'] = $this->finance->cashboxRoleExists('secondaire');

        /* Caisses actives pour les selects des modales */
        $data['allCashboxes'] = $this->finance->getAllActiveCashboxes();

        /* Statistiques dynamiques (2 caisses + livres) */
        $data['cashboxStats']   = $this->finance->getTwoCashboxStatistics();
        $data['principalCashbox'] = $this->finance->getPrincipalCashbox();
        $data['secondaryCashbox'] = $this->finance->getSecondaryCashbox();

        /* Période du graphique (GET) */
        $period = $this->input->get('cashflow_period');
        if (!in_array($period, ['7days', '30days', 'month'], true)) {
            $period = '7days';
        }
        $data['cashFlowPeriod']    = $period;
        $data['cashFlowEvolution'] = $this->finance->getCashflowEvolution($period);

        /* Alertes de trésorerie */
        $alertsData                = $this->finance->getTreasuryAlerts();
        $data['treasuryAlerts']    = $alertsData['alerts'];
        $data['treasuryAlertsCount'] = $alertsData['count'];

        /* Mouvements récents fusionnés (principale + secondaire) */
        $data['recentMovements']   = $this->finance->getRecentMovements(6);
        $data['allMovementsCount'] = $this->finance->countAllMovements();

        /* Dépenses secondaire par catégorie + consommation par chantier (filtrables) */
        $expenseRange = $this->_resolveExpensePeriod($this->input->get('expense_period', true));
        $data['expenseRange'] = $expenseRange;

        $data['secondaryExpensesByCategory'] = $this->finance->getSecondaryExpensesByCategory(
            $expenseRange['start'],
            $expenseRange['end']
        );
        $data['secondaryConsumptionByChantier'] = $this->finance->getSecondaryConsumptionByChantier(
            $expenseRange['start'],
            $expenseRange['end']
        );

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/caisse', $data);
        $this->load->view('v1/components/layout/footer');
    }

    /**
     * Résout une clé de période en plage de dates [start, end].
     * Utilisé par le filtre "Dépenses / Consommation par chantier" de la caisse.
     */
    private function _resolveExpensePeriod($period)
    {
        $options = [
            'day'     => "Aujourd'hui",
            'week'    => 'Cette semaine',
            'month'   => 'Ce mois',
            '3months' => '3 mois',
            '6months' => '6 mois',
            'year'    => 'Cette année',
        ];

        if (!isset($options[$period])) {
            $period = 'month';
        }

        $today = new DateTime('today'); // 00:00:00
        $end   = (clone $today)->setTime(23, 59, 59);

        switch ($period) {
            case 'day':
                $start = clone $today;
                break;
            case 'week':
                $start = (clone $today)->modify('monday this week');
                break;
            case '3months':
                $start = (clone $today)->modify('-3 months');
                break;
            case '6months':
                $start = (clone $today)->modify('-6 months');
                break;
            case 'year':
                $start = new DateTime($today->format('Y') . '-01-01');
                break;
            case 'month':
            default:
                $start = (clone $today)->modify('first day of this month');
                break;
        }
        $start->setTime(0, 0, 0);

        return [
            'key'     => $period,
            'label'   => $options[$period],
            'options' => $options,
            'start'   => $start->format('Y-m-d H:i:s'),
            'end'     => $end->format('Y-m-d H:i:s'),
            'display' => $start->format('d/m/Y') === $end->format('d/m/Y')
                ? $start->format('d/m/Y')
                : $start->format('d/m/Y') . ' → ' . $end->format('d/m/Y'),
        ];
    }

    public function caisseStore()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        /* ---------- Validation ---------- */
        $this->form_validation->set_rules('name', 'Intitulé', 'required|trim|max_length[150]');
        $this->form_validation->set_rules('role', 'Rôle', 'required|in_list[principale,secondaire]');
        $this->form_validation->set_rules('devise', 'Devise', 'required|in_list[BIF,USD,EUR]');
        $this->form_validation->set_rules('opening_balance', 'Solde initial', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('alert_threshold', 'Seuil d’alerte', 'required|numeric|greater_than_equal_to[0]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', validation_errors('<div>', '</div>'));
            redirect('caisse');
            return;
        }

        /* ---------- Insertion via le modèle ---------- */
        $result = $this->finance->createCashboxWithRole([
            'name'            => $this->input->post('name'),
            'role'            => $this->input->post('role'),
            'responsable'     => $this->input->post('responsable'),
            'devise'          => $this->input->post('devise'),
            'opening_balance' => $this->input->post('opening_balance'),
            'alert_threshold' => $this->input->post('alert_threshold'),
            'observation'     => $this->input->post('observation'),
            'created_by'      => $this->session->userdata('user_id'),
        ]);

        if (!$result['success']) {
            $this->session->set_flashdata('error', $result['message']);
        } else {
            $this->session->set_flashdata(
                'success',
                'Caisse « ' . $this->input->post('name') . ' » (' . $result['code'] . ') créée avec succès.'
            );
        }

        redirect('caisse');
    }

    private function _journalCaisseFilters()
    {
        $date = function ($v) {
            return ($v && preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) ? $v : null;
        };
        $type = $this->input->get('type', true);

        return [
            'caisse_id'   => (int) $this->input->get('caisse_id') ?: null,
            'chantier_id' => (int) $this->input->get('chantier_id') ?: null,
            'type'        => in_array($type, ['entree', 'sortie'], true) ? $type : null,
            'statut'      => $this->input->get('statut', true) ?: null,
            'date_debut'  => $date($this->input->get('date_debut', true)),
            'date_fin'    => $date($this->input->get('date_fin', true)),
            'q'           => trim((string) $this->input->get('q', true)) ?: null,
        ];
    }

    public function financeJournalCaisse()
    {
        $filters = $this->_journalCaisseFilters();

        $perPage = (int) $this->input->get('per_page');
        $perPage = in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 25;
        $page    = max(1, (int) $this->input->get('page'));

        $total   = $this->finance->countJournalCaisse($filters);
        $nbPages = max(1, (int) ceil($total / $perPage));
        $page    = min($page, $nbPages);
        $offset  = ($page - 1) * $perPage;

        $data = [];
        $data['title']      = 'Caisse'; // garder identique au sidebar
        $data['filters']    = $filters;
        $data['operations'] = $this->finance->getJournalCaisse($filters, $perPage, $offset);
        $data['totaux']     = $this->finance->getJournalCaisseTotaux($filters);
        $data['caisses']    = $this->finance->getCaissesForFilter();
        $data['chantiers']  = $this->finance->getChantiersForFilter();
        $data['pagination'] = [
            'total'    => $total,
            'page'     => $page,
            'nb_pages' => $nbPages,
            'per_page' => $perPage,
            'from'     => $total ? $offset + 1 : 0,
            'to'       => min($offset + $perPage, $total),
        ];

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/journal_caisse', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function financeJournalCaisseDetail($id = null)
    {
        $op = $this->finance->getJournalCaisseById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_status_header($op ? 200 : 404)
            ->set_output(json_encode($op
                ? ['success' => true, 'data' => $op]
                : ['success' => false, 'message' => 'Opération introuvable']));
    }

    public function financeJournalCaisseExport()
    {
        $filters    = $this->_journalCaisseFilters();
        $operations = $this->finance->getJournalCaisse($filters, null, 0);

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="journal_caisse_' . date('Ymd_His') . '.csv"');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF"); // BOM pour Excel
        fputcsv($out, [
            'Date',
            'Référence',
            'Caisse',
            'Code caisse',
            'Type',
            'Libellé',
            'Bénéficiaire',
            'DA',
            'Chantier',
            'Entrée',
            'Sortie',
            'Solde après',
            'Statut'
        ], ';');

        foreach ($operations as $op) {
            fputcsv($out, [
                date('d/m/Y H:i', strtotime($op->date_operation)),
                $op->reference,
                $op->caisse_nom,
                $op->caisse_code,
                $op->is_entree ? 'Entrée' : 'Sortie',
                $op->libelle,
                $op->beneficiaire,
                $op->da_reference,
                $op->chantier_nom,
                $op->is_entree ? $op->montant : '',
                $op->is_entree ? '' : $op->montant,
                $op->solde_apres,
                $op->statut,
            ], ';');
        }
        fclose($out);
        exit;
    }

    /**
     * Enregistrer une opération de caisse.
     *
     * Types acceptés :
     * - encaissement ;
     * - decaissement ;
     * - approvisionnement.
     */
    public function cashboxOperationStore()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $type = $this->input->post('operation_type');

        /* ---------- Validation de base ---------- */
        $this->form_validation->set_rules('operation_date', 'Date', 'required');
        $this->form_validation->set_rules('cashbox_id', 'Caisse', 'required|integer');
        $this->form_validation->set_rules('amount', 'Montant', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', 'Veuillez vérifier les champs du formulaire.');
            redirect('caisse');
            return;
        }

        $data = [
            'operation_date'             => $this->input->post('operation_date'),
            'cashbox_id'                 => (int) $this->input->post('cashbox_id'),
            'destination_cashbox_id'     => (int) $this->input->post('destination_cashbox_id'),
            'amount'                     => (float) $this->input->post('amount'),
            'category'                   => $this->input->post('category'),
            'third_party'                => $this->input->post('third_party'),
            'payment_method'             => $this->input->post('payment_method'),
            'document_number'            => $this->input->post('document_number'),
            'observation'                => $this->input->post('observation'),
            'expense_justification'      => $this->input->post('expense_justification'),
            'purchase_request_id'        => $this->input->post('purchase_request_id'),
            'purchase_request_reference' => $this->input->post('purchase_request_reference'),
            'payment_voucher_id'         => $this->input->post('payment_voucher_id'),
            'payment_voucher_reference'  => $this->input->post('payment_voucher_reference'),
            'created_by'                 => $this->session->userdata('user_id'),
        ];

        $result = $this->finance->recordCashboxOperation($type, $data);

        if (!$result['success']) {
            $this->session->set_flashdata('error', $result['message']);
        } else {
            $this->session->set_flashdata('success', $result['message']);
        }

        redirect('caisse');
    }

    public function caisseJournal()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['title'] = 'Journal de caisse';

        /* -------------------------------------------------
        * PÉRIODE DU JOURNAL
        * ------------------------------------------------- */
        $dateFrom = $this->input->get('journal_date_from');
        $dateTo   = $this->input->get('journal_date_to');

        if (empty($dateFrom) || strtotime($dateFrom) === false) {
            $dateFrom = date('Y-m-01');
        }
        if (empty($dateTo) || strtotime($dateTo) === false) {
            $dateTo = date('Y-m-d');
        }
        if (strtotime($dateFrom) > strtotime($dateTo)) {
            $tmp      = $dateFrom;
            $dateFrom = $dateTo;
            $dateTo   = $tmp;
        }

        /* -------------------------------------------------
        * FILTRES DU JOURNAL
        * ------------------------------------------------- */
        $filters = array(
            'search'     => trim((string) $this->input->get('journal_search')),
            'cashbox_id' => (int) $this->input->get('journal_cashbox'),
            'type'       => (string) $this->input->get('journal_type'),
            'status'     => (string) $this->input->get('journal_status'),
        );

        $data['journalDateFrom'] = $dateFrom;
        $data['journalDateTo']   = $dateTo;
        $data['journalFilters']  = $filters;

        /* -------------------------------------------------
        * STATISTIQUES DE LA PÉRIODE
        * ------------------------------------------------- */
        $data['journalStatistics'] = $this->finance
            ->getJournalPeriodStatistics($dateFrom, $dateTo);

        /* Options du filtre « caisse » */
        $data['journalCashboxes'] = $this->finance->getJournalCashboxOptions();

        /* -------------------------------------------------
        * PAGINATION
        * ------------------------------------------------- */
        $perPage    = 15;
        $total      = $this->finance->countJournalOperations($dateFrom, $dateTo, $filters);
        $totalPages = max(1, (int) ceil($total / $perPage));

        $page = max(1, (int) $this->input->get('page'));
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $perPage;

        /* -------------------------------------------------
        * DONNÉES DU TABLEAU
        * ------------------------------------------------- */
        $data['journalOperations'] = $this->finance
            ->getJournalOperations($dateFrom, $dateTo, $filters, $perPage, $offset);
        $data['journalDayTotals'] = $this->finance
            ->getJournalDayTotals($dateFrom, $dateTo, $filters);
        $data['journalPagination'] = array(
            'total'        => $total,
            'per_page'     => $perPage,
            'current_page' => $page,
            'total_pages'  => $totalPages,
            'offset'       => $offset,
        );

        /* -------------------------------------------------
        * RÉPARTITION PAR TYPE
        * (ignore volontairement le filtre « type » pour
        *  garder une répartition significative)
        * ------------------------------------------------- */
        $typeFilters = $filters;
        $typeFilters['type'] = '';
        $data['journalTypeDistribution'] = $this->finance
            ->getJournalTypeDistribution($dateFrom, $dateTo, $typeFilters);

        /* -------------------------------------------------
        * CAISSES LES PLUS ACTIVES
        * (ignore volontairement le filtre « caisse » pour
        *  garder la comparaison entre caisses)
        * ------------------------------------------------- */
        $activityFilters = $filters;
        $activityFilters['cashbox_id'] = 0;
        $data['journalCashboxActivity'] = $this->finance
            ->getJournalCashboxActivity($dateFrom, $dateTo, $activityFilters, 5);

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/caisse_journal', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function financeCashbox($id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $cashbox = $this->finance->getCashboxById((int) $id);
        if (!$cashbox) {
            $this->session->set_flashdata('error', 'Caisse introuvable.');
            redirect('caisse');
            return;
        }

        $data = [];
        $data['title']   = 'Livre de Caisse';
        $data['cashbox'] = $cashbox;

        $role = !empty($cashbox->role) ? $cashbox->role : 'secondaire';
        $data['cashboxRole'] = $role;

        /* Les deux caisses uniques (pour SOURCE DE FONDS / DESTINATION) */
        $data['principalCashbox'] = $this->finance->getPrincipalCashbox();
        $data['secondaryCashbox'] = $this->finance->getSecondaryCashbox();

        /* ---------- Filtres ---------- */
        $dateFrom = $this->input->get('livre_date_from');
        $dateTo   = $this->input->get('livre_date_to');
        $search   = trim((string) $this->input->get('livre_search'));

        $data['livreDateFrom'] = $dateFrom;
        $data['livreDateTo']   = $dateTo;
        $data['livreSearch']   = $search;

        /* ---------- Pagination (affichage décroissant) ---------- */
        $perPage    = 30;
        $total      = $this->finance->countLivreMovements($role, $dateFrom, $dateTo, $search);
        $totalPages = max(1, (int) ceil($total / $perPage));

        $page = max(1, (int) $this->input->get('page'));
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $perPage;          // offset "visuel" (ordre décroissant)

        /*
         * La requête reste en ordre croissant (le solde cumulé en dépend).
         * On calcule la tranche ASC correspondant à la page DESC demandée :
         *   page 1  -> les $perPage derniers mouvements
         *   dernière page -> les premiers mouvements (tranche éventuellement incomplète)
         */
        $ascOffset = $total - ($page * $perPage);
        $ascLimit  = $perPage;
        if ($ascOffset < 0) {
            $ascLimit += $ascOffset;               // tranche partielle sur la dernière page
            $ascOffset = 0;
        }

        $movements = [];
        if ($ascLimit > 0) {
            $movements = $this->finance->getLivreMovements($role, $dateFrom, $dateTo, $search, $ascLimit, $ascOffset);
            $movements = array_reverse($movements); // plus récent en premier
        }

        $data['livreMovements']  = $movements;
        $data['livreStats']      = $this->finance->getLivreStatistics($role, $dateFrom, $dateTo, $search);
        $data['livrePagination'] = [
            'total'        => $total,
            'per_page'     => $perPage,
            'current_page' => $page,
            'total_pages'  => $totalPages,
            'offset'       => $offset,
            // numéro chronologique de la 1re ligne affichée (ex. 378 en page 1)
            'number_start' => $ascOffset + count($movements),
        ];

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/finance_cashbox', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function financeCashboxPrint($id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $cashbox = $this->finance->getCashboxById((int) $id);
        if (!$cashbox) {
            $this->session->set_flashdata('error', 'Caisse introuvable.');
            redirect('caisse');
            return;
        }

        $role = !empty($cashbox->role) ? $cashbox->role : 'secondaire';

        $data = [];
        $data['title']       = ($role === 'principale') ? 'Livre de caisse principal' : 'Livre de caisse secondaire';
        $data['cashbox']     = $cashbox;
        $data['cashboxRole'] = $role;

        /* Les deux caisses (source / destination selon le rôle) */
        $data['principalCashbox'] = $this->finance->getPrincipalCashbox();
        $data['secondaryCashbox'] = $this->finance->getSecondaryCashbox();

        /* Tous les mouvements du livre concerné */
        $data['movements'] = $this->finance->getAllLivreMovements($role);

        /* Page autonome (pas de layout header/sidebar) */
        $this->load->view('v1/components/modules/finance/finance_cashbox_print', $data);
    }

    public function rapportFinancier()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data = [];
        $data['title'] = 'Rapport Financier';

        /* Filtres */
        $filters = [
            'search'      => trim((string) $this->input->get('rapport_search')),
            'situation'   => (string) $this->input->get('rapport_situation'),
            'chantier_id' => (int) $this->input->get('rapport_chantier'),   /* ✅ nouveau */
            'date_from'   => $this->input->get('rapport_date_from'),
            'date_to'     => $this->input->get('rapport_date_to'),
        ];
        $data['rapportFilters'] = $filters;

        /* ✅ Liste des chantiers pour le select du filtre */
        $data['allChantiers'] = $this->finance->getAllChantiers();

        /* Modale : DA avec bon effectué et non régularisées */
        $data['regularizableRequests'] = $this->finance->getRegularizablePurchaseRequests();

        /* Statistiques + lignes + historique (✅ stats filtrées aussi) */
        $data['reportStats']           = $this->finance->getFinancialReportStatistics($filters);
        $data['reportRows']            = $this->finance->getFinancialReportRows($filters);
        $data['recentRegularisations'] = $this->finance->getRecentRegularisations(6);

        /* Comptage des situations pour le donut (sans filtre situation, mais avec chantier) */
        $allRows = $this->finance->getFinancialReportRows([
            'search'      => $filters['search'],
            'chantier_id' => $filters['chantier_id'],
            'date_from'   => $filters['date_from'],
            'date_to'     => $filters['date_to'],
        ]);
        $counts = ['soldee' => 0, 'retour' => 0, 'supplement' => 0, 'attente' => 0];
        foreach ($allRows as $r) {
            $counts[$r->situation]++;
        }
        $data['situationCounts'] = $counts;

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/rapport_financier', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    public function retourCaisseStore()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $type = $this->input->post('regularisation_type');

        /* ---------- Validation ---------- */
        $this->form_validation->set_rules('purchase_request_id', 'Demande d’achat', 'required|integer');
        $this->form_validation->set_rules('regularisation_type', 'Type de régularisation', 'required|in_list[retour,supplement,exact]');
        $this->form_validation->set_rules('regularisation_date', 'Date', 'required');
        $this->form_validation->set_rules('justification', 'Justification', 'required|trim');

        if ($type !== 'exact') {
            $this->form_validation->set_rules('amount', 'Montant', 'required|numeric|greater_than[0]');
        }

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', validation_errors('<div>', '</div>'));
            redirect('rapport-financier');
            return;
        }

        /* ---------- Contrôle DA + bon effectué ---------- */
        $requestId = (int) $this->input->post('purchase_request_id');
        $request   = $this->finance->getRequestWithVoucher($requestId);

        if (!$request || empty($request->voucher_id)) {
            $this->session->set_flashdata('error', 'Cette demande n’a pas de bon de paiement.');
            redirect('rapport-financier');
            return;
        }
        if ($request->payment_status !== 'effectue') {
            $this->session->set_flashdata('error', 'Le bon de paiement de cette demande n’est pas encore effectué.');
            redirect('rapport-financier');
            return;
        }

        /* ---------- Montant : 0 si « exact » ---------- */
        $amount = ($type === 'exact') ? 0 : (float) $this->input->post('amount');

        /* ---------- Supplément : vérifier le solde de la secondaire ---------- */
        $secondary = $this->finance->getSecondaryCashbox();
        if (
            $type === 'supplement' && $secondary
            && $amount > (float) $secondary->current_balance
        ) {
            $this->session->set_flashdata('error', 'Solde de la caisse secondaire insuffisant pour ce supplément.');
            redirect('rapport-financier');
            return;
        }

        /* ---------- Insertion ---------- */
        $result = $this->finance->storeRegularisation([
            'purchase_request_id'        => $requestId,
            'payment_voucher_id'         => (int) $request->voucher_id,
            'purchase_request_reference' => 'DA-' . date('Y', strtotime($request->created_at ?? date('Y-m-d'))) . '-' . str_pad($requestId, 4, '0', STR_PAD_LEFT),
            'regularisation_type'        => $type,
            'amount'                     => $amount,
            'regularisation_date'        => $this->input->post('regularisation_date'),
            'concerned'                  => $this->input->post('concerned'),
            'receipt_number'             => $this->input->post('receipt_number'),
            'justification'              => $this->input->post('justification'),
            'observation'                => $this->input->post('observation'),
            'secondary_cashbox'          => $secondary,
            'created_by'                 => $this->session->userdata('user_id'),
        ]);

        if (!$result['success']) {
            $this->session->set_flashdata('error', $result['message']);
        } else {
            $labels = ['retour' => 'Retour à la caisse', 'supplement' => 'Supplément', 'exact' => 'Demande soldée'];
            $this->session->set_flashdata(
                'success',
                $labels[$type] . ' enregistré(e) avec succès pour ' . $request->payment_number . '.'
            );
        }

        redirect('rapport-financier');
    }

    public function rapportFinancierPrint()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data = [];
        $data['title'] = 'Rapport financier';

        /* Impression = toutes les données (aucun filtre) */
        $data['reportStats'] = $this->finance->getFinancialReportStatistics();
        $data['reportRows']  = $this->finance->getFinancialReportRows([]);
        $data['recentRegularisations'] = $this->finance->getRecentRegularisations(50);

        /* Page autonome (sans layout) */
        $this->load->view('v1/components/modules/finance/rapport_financier_print', $data);
    }









    /**
     * Affiche la page de gestion des encaissements.
     *
     * Cette méthode prépare :
     * - les caisses actives ;
     * - les statistiques principales ;
     * - l'évolution mensuelle des encaissements ;
     * - la répartition des encaissements par source ;
     * - l'historique paginé ;
     * - les encaissements attendus ;
     * - la synthèse de recouvrement par client.
     *
     * @return void
     */
    public function encaissements()
    {
        /*
        * =========================================================
        * 1. SÉCURITÉ DE LA PAGE
        * =========================================================
        *
        * Active cette partie si toutes les pages privées
        * exigent un utilisateur connecté.
        */

        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        /*
        * =========================================================
        * 2. INITIALISATION DES DONNÉES
        * =========================================================
        */

        $data = [];

        $data['title'] = 'Encaissements';

        /*
        * Valeurs par défaut.
        *
        * Elles empêchent les erreurs "Undefined variable"
        * dans la vue si une requête ne retourne aucun résultat.
        */
        $data['allCashboxes'] = [];
        $data['encaissementStatistics'] = [];
        $data['encaissementEvolution'] = [
            'start_date'       => date('Y-m-01'),
            'end_date'         => date('Y-m-t'),
            'labels'           => [],
            'amounts'          => [],
            'objectives'       => [],
            'operation_counts' => [],
            'total_amount'     => 0,
            'total_operations' => 0,
            'average_amount'   => 0,
        ];

        $data['encaissementSources'] = [
            'total_amount' => 0,
            'sources'      => [],
        ];

        $data['encaissementHistory'] = [];

        $data['encaissementPagination'] = [
            'current_page' => 1,
            'per_page'     => 10,
            'total_rows'   => 0,
            'total_pages'  => 1,
            'offset'       => 0,
        ];

        $data['upcomingExpectedReceipts'] = [];
        $data['openExpectedReceiptsCount'] = 0;
        $data['encaissementClientSummary'] = [];

        /*
     * =========================================================
     * 3. RÉCUPÉRER LES CAISSES ACTIVES
     * =========================================================
     *
     * Ces caisses alimentent la liste déroulante de la modale
     * "Enregistrer un encaissement".
     */

        $data['allCashboxes'] =
            $this->finance
            ->getAllActiveCashboxes();

        /*
     * =========================================================
     * 4. STATISTIQUES PRINCIPALES
     * =========================================================
     *
     * Cette méthode doit retourner notamment :
     *
     * - current_month_amount
     * - current_month_count
     * - monthly_variation
     * - today_amount
     * - today_count
     * - pending_amount
     * - pending_count
     * - receivable_amount
     * - receivable_clients_count
     */

        $data['encaissementStatistics'] =
            $this->finance
            ->getEncaissementMainStatistics();

        /*
     * =========================================================
     * 5. PÉRIODE DU GRAPHIQUE
     * =========================================================
     *
     * Paramètre attendu dans l'URL :
     *
     * encaissements?encaissement_period=6months
     */

        $allowedPeriods = [
            '6months',
            '12months',
            'current_year',
            'previous_year',
        ];

        $encaissementPeriod = trim(
            (string) $this->input->get(
                'encaissement_period',
                true
            )
        );

        /*
     * Lorsque la valeur est absente ou incorrecte,
     * nous utilisons les six derniers mois.
     */
        if (
            !in_array(
                $encaissementPeriod,
                $allowedPeriods,
                true
            )
        ) {
            $encaissementPeriod = '6months';
        }

        $data['encaissementPeriod'] =
            $encaissementPeriod;

        /*
     * =========================================================
     * 6. ÉVOLUTION DES ENCAISSEMENTS
     * =========================================================
     */

        $encaissementEvolution =
            $this->finance
            ->getEncaissementEvolution(
                $encaissementPeriod
            );

        /*
     * Vérification supplémentaire pour éviter les erreurs
     * si la méthode du modèle ne retourne pas un tableau.
     */
        if (is_array($encaissementEvolution)) {
            $data['encaissementEvolution'] =
                array_merge(
                    $data['encaissementEvolution'],
                    $encaissementEvolution
                );
        }

        /*
     * =========================================================
     * 7. SOURCES DES ENCAISSEMENTS
     * =========================================================
     *
     * La période utilisée est la même que celle du graphique.
     */

        $evolutionStartDate =
            $data['encaissementEvolution']['start_date']
            ?? date('Y-m-01');

        $evolutionEndDate =
            $data['encaissementEvolution']['end_date']
            ?? date('Y-m-t');

        $encaissementSources =
            $this->finance
            ->getEncaissementSources(
                $evolutionStartDate,
                $evolutionEndDate
            );

        if (is_array($encaissementSources)) {
            $data['encaissementSources'] =
                array_merge(
                    $data['encaissementSources'],
                    $encaissementSources
                );
        }

        /*
     * =========================================================
     * 8. PAGINATION DE L'HISTORIQUE
     * =========================================================
     */

        $encaissementsPerPage = 10;

        /*
     * Le numéro de page est récupéré dans l'URL :
     *
     * encaissements?page=2
     */
        $encaissementPage = (int) $this->input->get(
            'page',
            true
        );

        if ($encaissementPage < 1) {
            $encaissementPage = 1;
        }

        /*
     * Nombre total d'encaissements dans la base.
     */
        $totalEncaissements =
            (int) $this->finance
                ->countEncaissements();

        /*
     * Calcul du nombre total de pages.
     */
        $totalEncaissementPages =
            $totalEncaissements > 0
            ? (int) ceil(
                $totalEncaissements
                    / $encaissementsPerPage
            )
            : 1;

        /*
     * Empêcher une page supérieure au nombre de pages existantes.
     */
        if (
            $encaissementPage
            > $totalEncaissementPages
        ) {
            $encaissementPage =
                $totalEncaissementPages;
        }

        /*
     * Calcul de l'offset SQL.
     *
     * Page 1 : offset 0
     * Page 2 : offset 10
     * Page 3 : offset 20
     */
        $encaissementOffset =
            ($encaissementPage - 1)
            * $encaissementsPerPage;

        /*
     * Récupération de l'historique paginé.
     */
        $encaissementHistory =
            $this->finance
            ->getEncaissementHistory(
                $encaissementsPerPage,
                $encaissementOffset
            );

        $data['encaissementHistory'] =
            is_array($encaissementHistory)
            ? $encaissementHistory
            : [];

        /*
     * Informations utilisées dans le pied du tableau.
     */
        $data['encaissementPagination'] = [
            'current_page' =>
            $encaissementPage,

            'per_page' =>
            $encaissementsPerPage,

            'total_rows' =>
            $totalEncaissements,

            'total_pages' =>
            $totalEncaissementPages,

            'offset' =>
            $encaissementOffset,
        ];

        /*
     * =========================================================
     * 9. ENCAISSEMENTS ATTENDUS
     * =========================================================
     *
     * La partie gauche du dernier bloc affiche les quatre
     * prochaines échéances ouvertes.
     */

        $upcomingExpectedReceipts =
            $this->finance
            ->getUpcomingExpectedReceipts(4);

        $data['upcomingExpectedReceipts'] =
            is_array($upcomingExpectedReceipts)
            ? $upcomingExpectedReceipts
            : [];

        /*
     * Nombre total d'échéances ouvertes.
     *
     * Le badge peut afficher un nombre supérieur à quatre,
     * même si la liste ne présente que quatre éléments.
     */
        $data['openExpectedReceiptsCount'] =
            (int) $this->finance
                ->countOpenExpectedReceipts();

        /*
     * =========================================================
     * 10. SYNTHÈSE PAR CLIENT
     * =========================================================
     *
     * La partie droite du dernier bloc présente :
     *
     * - total facturé ;
     * - total encaissé ;
     * - reste à recouvrer ;
     * - pourcentage de recouvrement.
     */

        $encaissementClientSummary =
            $this->finance
            ->getEncaissementClientSummary(10);

        $data['encaissementClientSummary'] =
            is_array($encaissementClientSummary)
            ? $encaissementClientSummary
            : [];

        /*
     * =========================================================
     * 11. CHARGEMENT DES VUES
     * =========================================================
     */

        $this->load->view(
            'v1/components/layout/header',
            $data
        );

        $this->load->view(
            'v1/components/layout/sidebar',
            $data
        );

        $this->load->view(
            'v1/components/modules/finance/encaissements',
            $data
        );

        $this->load->view(
            'v1/components/layout/footer',
            $data
        );
    }

    /**
     * Affiche la page des décaissements.
     *
     * @return void
     */
    public function decaissements()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data = [];

        $data['title'] =
            'Décaissements';

        /*
        * Caisses pour la modale.
        */
        $data['allCashboxes'] =
            $this->finance
            ->getAllActiveCashboxes();

        /*
        * Statistiques principales.
        */
        $data['decaissementStatistics'] =
            $this->finance
            ->getDecaissementMainStatistics();

        /*
        * Période du graphique.
        */
        $allowedDecaissementPeriods = [
            '6months',
            '12months',
            'current_year',
            'previous_year',
        ];

        $decaissementPeriod = trim(
            (string) $this->input->get(
                'decaissement_period',
                true
            )
        );

        if (
            !in_array(
                $decaissementPeriod,
                $allowedDecaissementPeriods,
                true
            )
        ) {
            $decaissementPeriod = '6months';
        }

        $data['decaissementPeriod'] =
            $decaissementPeriod;

        /*
        * Données dynamiques du graphique.
        */
        $data['decaissementEvolution'] =
            $this->finance
            ->getDecaissementEvolution(
                $decaissementPeriod
            );

        /*
        * =========================================================
        * HISTORIQUE DES DÉCAISSEMENTS
        * =========================================================
        */

        $decaissementsPerPage = 10;

        $currentDecaissementPage = (int) $this->input->get(
            'page',
            true
        );

        if ($currentDecaissementPage < 1) {
            $currentDecaissementPage = 1;
        }

        /*
        * Nombre total de décaissements.
        */
        $totalDecaissements =
            $this->finance
            ->countDecaissementHistory();

        /*
        * Nombre total de pages.
        */
        $totalDecaissementPages =
            $totalDecaissements > 0
            ? (int) ceil(
                $totalDecaissements
                    / $decaissementsPerPage
            )
            : 1;

        /*
        * Empêcher une page supérieure au nombre disponible.
        */
        if (
            $currentDecaissementPage
            > $totalDecaissementPages
        ) {
            $currentDecaissementPage =
                $totalDecaissementPages;
        }

        /*
        * Offset SQL.
        */
        $decaissementOffset =
            (
                $currentDecaissementPage - 1
            )
            * $decaissementsPerPage;

        /*
        * Données du tableau.
        */
        $data['decaissementHistory'] =
            $this->finance
            ->getDecaissementHistory(
                $decaissementsPerPage,
                $decaissementOffset
            );

        /*
        * Informations de pagination.
        */
        $data['decaissementPagination'] = [
            'current_page' =>
            $currentDecaissementPage,

            'per_page' =>
            $decaissementsPerPage,

            'total_rows' =>
            $totalDecaissements,

            'total_pages' =>
            $totalDecaissementPages,

            'offset' =>
            $decaissementOffset,
        ];

        /*
        * =========================================================
        * SYNTHÈSE DES DÉCAISSEMENTS PAR CHANTIER
        * =========================================================
        */

        /*
        * Par défaut, la synthèse porte sur le mois en cours.
        */
        $chantierSummaryStartDate =
            date('Y-m-01');

        $chantierSummaryEndDate =
            date('Y-m-t');

        /*
        * Dates éventuellement envoyées par les filtres.
        */
        $requestedStartDate = trim(
            (string) $this->input->get(
                'chantier_start_date',
                true
            )
        );

        $requestedEndDate = trim(
            (string) $this->input->get(
                'chantier_end_date',
                true
            )
        );

        /*
        * Vérifier le format YYYY-MM-DD.
        */
        if (
            !empty($requestedStartDate)
            && preg_match(
                '/^\d{4}-\d{2}-\d{2}$/',
                $requestedStartDate
            )
        ) {
            $chantierSummaryStartDate =
                $requestedStartDate;
        }

        if (
            !empty($requestedEndDate)
            && preg_match(
                '/^\d{4}-\d{2}-\d{2}$/',
                $requestedEndDate
            )
        ) {
            $chantierSummaryEndDate =
                $requestedEndDate;
        }

        /*
        * Éviter une période inversée.
        */
        if (
            strtotime($chantierSummaryStartDate)
            > strtotime($chantierSummaryEndDate)
        ) {
            $temporaryDate =
                $chantierSummaryStartDate;

            $chantierSummaryStartDate =
                $chantierSummaryEndDate;

            $chantierSummaryEndDate =
                $temporaryDate;
        }

        $data['chantierSummaryStartDate'] =
            $chantierSummaryStartDate;

        $data['chantierSummaryEndDate'] =
            $chantierSummaryEndDate;

        $data['decaissementChantierSummary'] =
            $this->finance
            ->getDecaissementChantierSummary(
                $chantierSummaryStartDate,
                $chantierSummaryEndDate
            );

        /*
     * Chargement des vues.
     */
        $this->load->view(
            'v1/components/layout/header',
            $data
        );

        $this->load->view(
            'v1/components/layout/sidebar',
            $data
        );

        $this->load->view(
            'v1/components/modules/finance/decaissements',
            $data
        );

        $this->load->view(
            'v1/components/layout/footer',
            $data
        );
    }







    /**
     * Vérifie qu'une date respecte le format Y-m-d.
     *
     * @param string $date
     * @return bool
     */
    private function isValidDate($date)
    {
        $dateObject = DateTime::createFromFormat(
            'Y-m-d',
            $date
        );

        return $dateObject
            && $dateObject->format('Y-m-d') === $date;
    }

        /* =====================================================================
     * =====================================================================
     *  MODULE BANQUE V2 — CONTRÔLEUR
     * =====================================================================
     * ===================================================================== */

    /** Types qui DÉBITENT le compte sélectionné dans le formulaire. */
    private $bankDebitTypes = ['decaissement', 'transfert', 'retrait_banque', 'frais_bancaires'];

    /* ---------------------------------------------------------------------
     * OUTILS INTERNES
     * ------------------------------------------------------------------- */

    /** Vérifie la connexion. $json = true pour les appels AJAX. */
    private function bankRequireLogin(bool $json = false): bool
    {
        if ($this->session->userdata('user_id')) {
            return true;
        }

        if ($json) {
            $this->bankJson(['status' => false, 'message' => 'Session expirée. Reconnectez-vous.'], 401);
        } else {
            redirect('sign-in');
        }

        return false;
    }

    private function bankCurrentUserId(): ?int
    {
        $userId = $this->session->userdata('user_id') ?: $this->session->userdata('id');

        return $userId ? (int) $userId : null;
    }

    /** Réponse JSON (renvoie aussi le nouveau jeton CSRF si la protection est active). */
    private function bankJson(array $payload, int $httpStatus = 200): void
    {
        $payload['csrf_hash'] = $this->security->get_csrf_hash();

        $this->output
            ->set_status_header($httpStatus)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE));
    }

    /** Erreur de formulaire : message + réouverture de la modale + saisie conservée. */
    private function bankRedirectError(string $message, string $modalFlag = '', string $oldInputKey = ''): void
    {
        $this->session->set_flashdata('error', $message);

        if ($modalFlag !== '') {
            $this->session->set_flashdata($modalFlag, true);
        }

        if ($oldInputKey !== '') {
            $this->session->set_flashdata($oldInputKey, $this->input->post(null, true));
        }

        redirect('compte-banques');
    }

    /** Messages de validation en français. */
    private function bankValidationMessages(): void
    {
        $this->form_validation->set_message('required', 'Le champ {field} est obligatoire.');
        $this->form_validation->set_message('integer', 'La valeur du champ {field} est invalide.');
        $this->form_validation->set_message('numeric', 'Le champ {field} doit contenir un montant valide.');
        $this->form_validation->set_message('greater_than', 'Le champ {field} doit être supérieur à {param}.');
        $this->form_validation->set_message('greater_than_equal_to', 'Le champ {field} ne peut pas être négatif.');
        $this->form_validation->set_message('in_list', 'La valeur sélectionnée pour {field} est invalide.');
        $this->form_validation->set_message('min_length', 'Le champ {field} doit contenir au moins {param} caractères.');
        $this->form_validation->set_message('max_length', 'Le champ {field} ne doit pas dépasser {param} caractères.');
    }

    /** Retrouve l'id d'une banque à partir de son code ou de son nom. */
    private function bankIdFromCode(string $codeOrName): int
    {
        $codeOrName = trim($codeOrName);

        foreach ($this->finance->getActiveBanks() as $bank) {
            if (strcasecmp($bank->code, $codeOrName) === 0 || strcasecmp($bank->name, $codeOrName) === 0) {
                return (int) $bank->id;
            }
        }

        return 0;
    }

    /** Upload facultatif de la pièce justificative. */
    private function bankUploadAttachment(): array
    {
        if (empty($_FILES['attachment']['name'])) {
            return ['status' => true, 'file' => null];
        }

        $uploadPath = FCPATH . 'uploads/finance/bank_operations/';

        if (!is_dir($uploadPath) && !mkdir($uploadPath, 0755, true) && !is_dir($uploadPath)) {
            return ['status' => false, 'message' => 'Le dossier des pièces justificatives ne peut pas être créé.'];
        }

        $this->load->library('upload');
        $this->upload->initialize([
            'upload_path'   => $uploadPath,
            'allowed_types' => 'pdf|jpg|jpeg|png|doc|docx|xls|xlsx',
            'max_size'      => 5120,
            'encrypt_name'  => true,
            'remove_spaces' => true,
        ]);

        if (!$this->upload->do_upload('attachment')) {
            return ['status' => false, 'message' => strip_tags($this->upload->display_errors())];
        }

        return ['status' => true, 'file' => $this->upload->data('file_name')];
    }

    /* ---------------------------------------------------------------------
     * PAGE : COMPTES BANCAIRES
     * ------------------------------------------------------------------- */

    public function banques()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        $currency = 'BIF';
        $banks    = $this->finance->getActiveBanks();

        /* Filtres */
        $filters = [
            'search'   => trim((string) $this->input->get('search', true)),
            'bank_id'  => (int) $this->input->get('bank_id', true),
            'currency' => (string) $this->input->get('currency', true),
            'status'   => (string) $this->input->get('status', true),
        ];

        /* Compatibilité vue actuelle : filtre banque envoyé par son nom */
        $legacyBankName = trim((string) $this->input->get('bank_name', true));

        if ($filters['bank_id'] <= 0 && $legacyBankName !== '') {
            $filters['bank_id'] = $this->bankIdFromCode($legacyBankName);
        }

        /* Période du graphique */
        $period = (string) $this->input->get('bankflow_period', true);

        if (!in_array($period, ['7days', '30days', 'month', 'year'], true)) {
            $period = '7days';
        }

        /* Statistiques */
        $statistics = $this->finance->getBankMainStatistics($currency);
        $statistics['active_bif_accounts'] = $statistics['currency_accounts']; /* compatibilité vue */

        $data = [
            'title'                      => 'Comptes bancaires',

            'banks'                      => $banks,
            'availableBanks'             => array_map(function ($bank) {
                return (object) ['bank_name' => $bank->name];
            }, $banks),
            'bankFilters'                => $filters + ['bank_name' => $legacyBankName],

            'bankMainStatistics'         => $statistics,
            'allBankAccounts'            => $this->finance->getActiveBankAccounts(),
            'bankAccountSituations'      => $this->finance->getBankAccounts($filters),
            'activeBankAccountsCount'    => $statistics['active_accounts'],

            'recentBankOperations'       => $this->finance->getRecentBankOperations(10),
            'bankOperationsCount'        => $this->finance->countBankOperations(),

            'bankFlowPeriod'             => $period,
            'bankFlowEvolution'          => $this->finance->getBankFlowEvolution($period, $currency),
            'bankBalanceDistribution'    => $this->finance->getBankBalanceDistribution($currency),

            'nextBankAccountCode'        => $this->finance->getNextBankAccountCode(),
            'nextBankOperationReference' => $this->finance->getNextBankOperationReference(),

            'bankAlerts'                 => $this->finance->getBankAlerts(6),

            'principalCashbox'           => $this->finance->getPrincipalCashbox(),
        ];

        $data['bankAlertsCount'] = count($data['bankAlerts']);

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/banques', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    /* ---------------------------------------------------------------------
     * COMPTES BANCAIRES : CRÉATION / MODIFICATION / DÉTAIL
     * ------------------------------------------------------------------- */

    public function bankAccountStore()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        /* Compatibilité vue actuelle : banque envoyée par son code, pas de date d'ouverture */
        if (!$this->input->post('bank_id') && $this->input->post('bank_name')) {
            $_POST['bank_id'] = $this->bankIdFromCode((string) $this->input->post('bank_name', true));
        }

        if (!$this->input->post('opening_date')) {
            $_POST['opening_date'] = date('Y-m-d');
        }

        $this->form_validation->set_rules('name', 'Intitulé du compte', 'trim|required|min_length[2]|max_length[150]');
        $this->form_validation->set_rules('bank_id', 'Banque', 'trim|required|integer|greater_than[0]');
        $this->form_validation->set_rules('account_number', 'Numéro de compte', 'trim|required|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('account_type', 'Type de compte', 'trim|required|in_list[courant,epargne,garantie,projet,credit]');
        $this->form_validation->set_rules('currency', 'Devise', 'trim|required|in_list[BIF,USD,EUR]');
        $this->form_validation->set_rules('opening_date', 'Date d’ouverture', 'trim|required');
        $this->form_validation->set_rules('opening_balance', 'Solde initial', 'trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('overdraft_limit', 'Découvert autorisé', 'trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('alert_threshold', 'Seuil d’alerte', 'trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('branch_name', 'Agence', 'trim|max_length[150]');
        $this->form_validation->set_rules('accounting_account_id', 'Compte comptable', 'trim|integer');
        $this->form_validation->set_rules('observation', 'Observation', 'trim|max_length[2000]');
        $this->bankValidationMessages();

        if ($this->form_validation->run() === false) {
            $this->bankRedirectError(
                validation_errors('<div>', '</div>'),
                'open_bank_account_modal',
                'bank_account_old_input'
            );
            return;
        }

        $openingDate = (string) $this->input->post('opening_date', true);

        if (!$this->isValidDate($openingDate) || $openingDate > date('Y-m-d')) {
            $this->bankRedirectError(
                'La date d’ouverture est invalide ou située dans le futur.',
                'open_bank_account_modal',
                'bank_account_old_input'
            );
            return;
        }

        /* "0151 0010-02456" → "0151001002456" */
        $accountNumber = strtoupper(preg_replace('/[\s\-]+/', '', (string) $this->input->post('account_number', true)));

        $result = $this->finance->createBankAccount([
            'bank_id'               => (int) $this->input->post('bank_id', true),
            'name'                  => trim((string) $this->input->post('name', true)),
            'account_number'        => $accountNumber,
            'account_type'          => $this->input->post('account_type', true),
            'currency'              => $this->input->post('currency', true),
            'branch_name'           => $this->input->post('branch_name', true),
            'accounting_account_id' => $this->input->post('accounting_account_id', true),
            'opening_date'          => $openingDate,
            'opening_balance'       => (float) $this->input->post('opening_balance', true),
            'overdraft_limit'       => (float) $this->input->post('overdraft_limit', true),
            'alert_threshold'       => (float) $this->input->post('alert_threshold', true),
            'observation'           => $this->input->post('observation', true),
            'created_by'            => $this->bankCurrentUserId(),
        ]);

        if (!$result['status']) {
            $this->bankRedirectError($result['message'], 'open_bank_account_modal', 'bank_account_old_input');
            return;
        }

        $this->session->set_flashdata('success', $result['message']);
        redirect('compte-banques');
    }

    public function bankAccountUpdate()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $this->form_validation->set_rules('id', 'Compte', 'trim|required|integer|greater_than[0]');
        $this->form_validation->set_rules('name', 'Intitulé du compte', 'trim|required|min_length[2]|max_length[150]');
        $this->form_validation->set_rules('status', 'Statut', 'trim|required|in_list[active,inactive,blocked,closed]');
        $this->form_validation->set_rules('overdraft_limit', 'Découvert autorisé', 'trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('alert_threshold', 'Seuil d’alerte', 'trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('branch_name', 'Agence', 'trim|max_length[150]');
        $this->form_validation->set_rules('accounting_account_id', 'Compte comptable', 'trim|integer');
        $this->form_validation->set_rules('observation', 'Observation', 'trim|max_length[2000]');
        $this->bankValidationMessages();

        if ($this->form_validation->run() === false) {
            $this->bankRedirectError(validation_errors('<div>', '</div>'), 'open_bank_account_edit_modal');
            return;
        }

        $result = $this->finance->updateBankAccount(
            (int) $this->input->post('id', true),
            [
                'name'                  => trim((string) $this->input->post('name', true)),
                'status'                => $this->input->post('status', true),
                'branch_name'           => $this->input->post('branch_name', true),
                'accounting_account_id' => $this->input->post('accounting_account_id', true),
                'overdraft_limit'       => (float) $this->input->post('overdraft_limit', true),
                'alert_threshold'       => (float) $this->input->post('alert_threshold', true),
                'observation'           => $this->input->post('observation', true),
            ],
            $this->bankCurrentUserId()
        );

        $this->session->set_flashdata($result['status'] ? 'success' : 'error', $result['message']);
        redirect('compte-banques');
    }

    /** JSON : détail d'un compte (modales « Voir » et « Modifier »). */
    public function bankAccountView($id = null)
    {
        if (!$this->bankRequireLogin(true)) {
            return;
        }

        $account = $this->finance->getBankAccountById((int) $id);

        if (!$account) {
            $this->bankJson(['status' => false, 'message' => 'Compte bancaire introuvable.'], 404);
            return;
        }

        $this->bankJson(['status' => true, 'data' => $account]);
    }

    /* ---------------------------------------------------------------------
     * OPÉRATIONS BANCAIRES
     * ------------------------------------------------------------------- */

    public function bankOperationStore()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $type = trim((string) $this->input->post('operation_type', true));

        $types   = 'encaissement,decaissement,transfert,retrait_banque,versement_banque,frais_bancaires,interets_crediteurs';
        $methods = 'virement,cheque,versement_especes,retrait_especes,prelevement,autre,transfer,deposit,withdrawal';

        $this->form_validation->set_rules('operation_type', 'Type d’opération', 'trim|required|in_list[' . $types . ']');
        $this->form_validation->set_rules('operation_date', 'Date de l’opération', 'trim|required');
        $this->form_validation->set_rules('value_date', 'Date de valeur', 'trim');
        $this->form_validation->set_rules('bank_account_id', 'Compte bancaire', 'trim|required|integer|greater_than[0]');
        $this->form_validation->set_rules('amount', 'Montant', 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('category', 'Catégorie', 'trim|max_length[100]');
        $this->form_validation->set_rules('third_party', 'Tiers / Bénéficiaire', 'trim|max_length[255]');
        $this->form_validation->set_rules('payment_method', 'Mode d’opération', 'trim|required|in_list[' . $methods . ']');
        $this->form_validation->set_rules('document_number', 'Numéro de pièce', 'trim|max_length[100]');
        $this->form_validation->set_rules('label', 'Libellé', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('observation', 'Observation', 'trim|max_length[2000]');

        if ($type === 'transfert') {
            $this->form_validation->set_rules(
                'destination_bank_account_id',
                'Compte destination',
                'trim|required|integer|greater_than[0]'
            );
        }

        $this->bankValidationMessages();

        if ($this->form_validation->run() === false) {
            $this->bankRedirectError(
                validation_errors('<div>', '</div>'),
                'open_bank_operation_modal',
                'bank_operation_old_input'
            );
            return;
        }

        /* Dates */
        $operationDate = (string) $this->input->post('operation_date', true);
        $valueDate     = trim((string) $this->input->post('value_date', true));

        if (!$this->isValidDate($operationDate) || $operationDate > date('Y-m-d')) {
            $this->bankRedirectError(
                'La date de l’opération est invalide ou située dans le futur.',
                'open_bank_operation_modal',
                'bank_operation_old_input'
            );
            return;
        }

        if ($valueDate !== '' && !$this->isValidDate($valueDate)) {
            $this->bankRedirectError('La date de valeur est invalide.', 'open_bank_operation_modal', 'bank_operation_old_input');
            return;
        }

        /* Le compte sélectionné est débité ou crédité selon le type */
        $accountId = (int) $this->input->post('bank_account_id', true);
        $isDebit   = in_array($type, $this->bankDebitTypes, true);

        $sourceId      = $isDebit ? $accountId : null;
        $destinationId = $type === 'transfert'
            ? (int) $this->input->post('destination_bank_account_id', true)
            : ($isDebit ? null : $accountId);

        if ($type === 'transfert' && $sourceId === $destinationId) {
            $this->bankRedirectError(
                'Le compte source et le compte destination doivent être différents.',
                'open_bank_operation_modal',
                'bank_operation_old_input'
            );
            return;
        }

        /* Compatibilité vue actuelle : anciens codes de mode d'opération */
        $legacyMethods = [
            'transfer'   => 'virement',
            'deposit'    => 'versement_especes',
            'withdrawal' => 'retrait_especes',
        ];

        $paymentMethod = (string) $this->input->post('payment_method', true);
        $paymentMethod = $legacyMethods[$paymentMethod] ?? $paymentMethod;

        /* Pièce justificative */
        $upload = $this->bankUploadAttachment();

        if (!$upload['status']) {
            $this->bankRedirectError($upload['message'], 'open_bank_operation_modal', 'bank_operation_old_input');
            return;
        }

        $result = $this->finance->createBankOperation([
            'operation_type'              => $type,
            'operation_date'              => $operationDate,
            'value_date'                  => $valueDate,
            'source_bank_account_id'      => $sourceId,
            'destination_bank_account_id' => $destinationId,
            'amount'                      => (float) $this->input->post('amount', true),
            'category'                    => $this->input->post('category', true),
            'third_party'                 => $this->input->post('third_party', true),
            'payment_method'              => $paymentMethod,
            'document_number'             => $this->input->post('document_number', true),
            'attachment'                  => $upload['file'],
            'source_type'                 => $this->input->post('source_type', true),
            'source_id'                   => $this->input->post('source_id', true),
            'chantier_id'                 => $this->input->post('chantier_id', true),
            'label'                       => trim((string) $this->input->post('label', true)),
            'observation'                 => $this->input->post('observation', true),
            'status'                      => $this->input->post('save_as_pending') ? 'pending' : 'validated',
            'created_by'                  => $this->bankCurrentUserId(),
        ]);

        if (!$result['status']) {
            if (!empty($upload['file'])) {
                @unlink(FCPATH . 'uploads/finance/bank_operations/' . $upload['file']);
            }

            $this->bankRedirectError($result['message'], 'open_bank_operation_modal', 'bank_operation_old_input');
            return;
        }

        $this->session->set_flashdata('success', $result['message']);
        redirect('compte-banques');
    }

    /** JSON : détail d'une opération avec ses lignes du livre. */
    public function bankOperationView($id = null)
    {
        if (!$this->bankRequireLogin(true)) {
            return;
        }

        $operation = $this->finance->getBankOperationById((int) $id);

        if (!$operation) {
            $this->bankJson(['status' => false, 'message' => 'Opération introuvable.'], 404);
            return;
        }

        $this->bankJson(['status' => true, 'data' => $operation]);
    }

    /** AJAX POST : valider une opération en attente. */
    public function bankOperationValidate()
    {
        if (!$this->bankRequireLogin(true)) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $result = $this->finance->validateBankOperation(
            (int) $this->input->post('operation_id', true),
            $this->bankCurrentUserId()
        );

        $this->bankJson($result, $result['status'] ? 200 : 422);
    }

    /** AJAX POST : annuler une opération (contre-passation si validée). */
    public function bankOperationCancel()
    {
        if (!$this->bankRequireLogin(true)) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $result = $this->finance->cancelBankOperation(
            (int) $this->input->post('operation_id', true),
            (string) $this->input->post('cancel_reason', true),
            $this->bankCurrentUserId()
        );

        $this->bankJson($result, $result['status'] ? 200 : 422);
    }

        /* ---------------------------------------------------------------------
     * RAPPROCHEMENT BANCAIRE (6a)
     * ------------------------------------------------------------------- */

    /** Erreur de création : message + réouverture de la modale. */
    private function reconciliationRedirectError(string $message): void
    {
        $this->session->set_flashdata('error', $message);
        $this->session->set_flashdata('open_reconciliation_modal', true);
        $this->session->set_flashdata('reconciliation_old_input', $this->input->post(null, true));
        redirect('rapprochement');
    }

    /** Page : liste des rapprochements + situation par compte. */
    public function rapprochement()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        $statusLabels = $this->finance->getReconciliationStatusLabels();
        $status       = (string) $this->input->get('status', true);

        $filters = [
            'bank_account_id' => (int) $this->input->get('bank_account_id', true),
            'status'          => array_key_exists($status, $statusLabels) ? $status : '',
        ];

        $accountRows = [];

        foreach ($this->finance->getBankAccounts([]) as $account) {
            $accountRows[] = (object) [
                'account'          => $account,
                'period_start'     => $this->finance->getReconciliationPeriodStart($account),
                'expected_opening' => $this->finance->getReconciliationExpectedOpening($account),
                'open'             => $this->finance->getOpenReconciliation((int) $account->id),
            ];
        }

        $data = [
            'title'           => 'Rapprochement bancaire',
            'accountRows'     => $accountRows,
            'reconciliations' => $this->finance->getReconciliations($filters),
            'filters'         => $filters,
            'statusLabels'    => $statusLabels,
        ];

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/rapprochement', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    /** POST : création d'un rapprochement + relevé. */
    public function reconciliationStore()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $this->form_validation->set_rules('bank_account_id', 'Compte bancaire', 'trim|required|integer|greater_than[0]');
        $this->form_validation->set_rules('period_end', 'Date de fin', 'trim|required');
        $this->form_validation->set_rules('statement_date', 'Date du relevé', 'trim');
        $this->form_validation->set_rules('statement_number', 'N° du relevé', 'trim|max_length[50]');
        $this->form_validation->set_rules('statement_opening_balance', 'Solde initial du relevé', 'trim|required|numeric');
        $this->form_validation->set_rules('statement_closing_balance', 'Solde final du relevé', 'trim|required|numeric');
        $this->form_validation->set_rules('observation', 'Observation', 'trim|max_length[1000]');
        $this->bankValidationMessages();

        if ($this->form_validation->run() === false) {
            $this->reconciliationRedirectError(validation_errors('<div>', '</div>'));
            return;
        }

        $periodEnd     = (string) $this->input->post('period_end', true);
        $statementDate = trim((string) $this->input->post('statement_date', true));

        if (!$this->isValidDate($periodEnd)) {
            $this->reconciliationRedirectError('La date de fin est invalide.');
            return;
        }

        if ($statementDate !== '' && !$this->isValidDate($statementDate)) {
            $this->reconciliationRedirectError('La date du relevé est invalide.');
            return;
        }

        $result = $this->finance->createReconciliation([
            'bank_account_id'           => (int) $this->input->post('bank_account_id', true),
            'period_end'                => $periodEnd,
            'statement_date'            => $statementDate,
            'statement_number'          => $this->input->post('statement_number', true),
            'statement_opening_balance' => (float) $this->input->post('statement_opening_balance', true),
            'statement_closing_balance' => (float) $this->input->post('statement_closing_balance', true),
            'observation'               => $this->input->post('observation', true),
            'created_by'                => $this->bankCurrentUserId(),
        ]);

        if (!$result['status']) {
            $this->reconciliationRedirectError($result['message']);
            return;
        }

        $this->session->set_flashdata('success', $result['message']);
        redirect('rapprochement/' . (int) $result['id']);
    }

    /** Page : espace de travail d'un rapprochement. */
    public function reconciliationWorkspace($id = null)
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        $reconciliation = $this->finance->getReconciliationById((int) $id);

        if (!$reconciliation) {
            $this->session->set_flashdata('error', 'Rapprochement introuvable.');
            redirect('rapprochement');
            return;
        }

        $data = [
            'title'          => 'Rapprochement bancaire',
            'reconciliation' => $reconciliation,
            'summary'        => $this->finance->getReconciliationSummary($reconciliation),
            'statementLines' => $this->finance->getStatementLines((int) $reconciliation->statement_id),
            'statusLabels'   => $this->finance->getReconciliationStatusLabels(),
            'canEdit'        => in_array($reconciliation->status, ['draft', 'in_progress', 'completed'], true),
        ];

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/rapprochement_detail', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    /** POST : ajout manuel d'une ligne au relevé. */
    public function statementLineStore()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $reconciliationId = (int) $this->input->post('reconciliation_id', true);
        $back             = 'rapprochement/' . $reconciliationId;

        $this->form_validation->set_rules('operation_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('value_date', 'Date de valeur', 'trim');
        $this->form_validation->set_rules('label', 'Libellé', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('bank_reference', 'Référence banque', 'trim|max_length[100]');
        $this->form_validation->set_rules('direction', 'Sens', 'trim|required|in_list[debit,credit]');
        $this->form_validation->set_rules('amount', 'Montant', 'trim|required|numeric|greater_than[0]');
        $this->bankValidationMessages();

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', validation_errors('<div>', '</div>'));
            redirect($back);
            return;
        }

        $operationDate = (string) $this->input->post('operation_date', true);
        $valueDate     = trim((string) $this->input->post('value_date', true));

        if (!$this->isValidDate($operationDate) || ($valueDate !== '' && !$this->isValidDate($valueDate))) {
            $this->session->set_flashdata('error', 'Date invalide.');
            redirect($back);
            return;
        }

        $result = $this->finance->addStatementLine($reconciliationId, [
            'operation_date' => $operationDate,
            'value_date'     => $valueDate,
            'label'          => trim((string) $this->input->post('label', true)),
            'bank_reference' => $this->input->post('bank_reference', true),
            'direction'      => $this->input->post('direction', true),
            'amount'         => (float) $this->input->post('amount', true),
        ]);

        $this->session->set_flashdata($result['status'] ? 'success' : 'error', $result['message']);
        redirect($back);
    }

    /** AJAX POST : suppression d'une ligne du relevé. */
    public function statementLineDelete()
    {
        if (!$this->bankRequireLogin(true)) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $result = $this->finance->deleteStatementLine(
            (int) $this->input->post('reconciliation_id', true),
            (int) $this->input->post('line_id', true)
        );

        $this->bankJson($result, $result['status'] ? 200 : 422);
    }

    /** Date CSV : 31/10/2026, 1/10/2026, 2026-10-31, 31-10-2026, 31.10.2026. */
    private function bankCsvDate(string $value): ?string
    {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        foreach (['d/m/Y', 'j/n/Y', 'Y-m-d', 'd-m-Y', 'j-n-Y', 'd.m.Y'] as $format) {
            $date   = DateTime::createFromFormat('!' . $format, $value);
            $errors = DateTime::getLastErrors();

            if ($date && (!$errors || ($errors['warning_count'] === 0 && $errors['error_count'] === 0))) {
                return $date->format('Y-m-d');
            }
        }

        return null;
    }

    /** Montant CSV : « 1 250 000 », « 1.250.000,50 », « 1,250,000.50 ». Retourne -1 si invalide. */
    private function bankCsvAmount($value): float
    {
        $value = str_replace(["\xC2\xA0", ' ', "'"], '', trim((string) $value));

        if ($value === '' || $value === '-') {
            return 0.0;
        }

        if (strpos($value, ',') !== false && strpos($value, '.') !== false) {
            /* Le dernier séparateur rencontré est le séparateur décimal */
            if (strrpos($value, ',') > strrpos($value, '.')) {
                $value = str_replace(',', '.', str_replace('.', '', $value));
            } else {
                $value = str_replace(',', '', $value);
            }
        } elseif (strpos($value, ',') !== false) {
            $value = str_replace(',', '.', $value);
        }

        return is_numeric($value) ? abs(round((float) $value, 2)) : -1.0;
    }

    /**
     * Analyse un relevé CSV au format du modèle :
     * date ; date_valeur ; libelle ; reference ; debit ; credit
     */
    private function bankParseStatementCsv(string $path): array
    {
        $rows   = [];
        $errors = [];

        $handle = fopen($path, 'r');

        if (!$handle) {
            return ['rows' => [], 'errors' => ['Le fichier ne peut pas être lu.']];
        }

        /* Séparateur détecté sur la première ligne */
        $firstLine = (string) fgets($handle);
        $delimiter = ';';
        $best      = substr_count($firstLine, ';');

        foreach ([',', "\t"] as $candidate) {
            if (substr_count($firstLine, $candidate) > $best) {
                $best      = substr_count($firstLine, $candidate);
                $delimiter = $candidate;
            }
        }

        rewind($handle);

        $lineNo = 0;

        while (($columns = fgetcsv($handle, 0, $delimiter)) !== false) {
            $lineNo++;

            if ($lineNo > 2000) {
                $errors[] = 'Import limité à 2 000 lignes : la suite du fichier a été ignorée.';
                break;
            }

            /* Encodage Excel Windows → UTF-8, BOM retiré */
            $columns = array_map(function ($cell) {
                $cell = (string) $cell;

                if (function_exists('mb_check_encoding') && !mb_check_encoding($cell, 'UTF-8')) {
                    $cell = mb_convert_encoding($cell, 'UTF-8', 'Windows-1252');
                }

                return trim(preg_replace('/^\xEF\xBB\xBF/', '', $cell));
            }, $columns);

            /* Ligne vide */
            if (implode('', $columns) === '') {
                continue;
            }

            /* Ligne d'en-tête */
            if ($lineNo === 1 && stripos($columns[0], 'date') !== false) {
                continue;
            }

            $columns   = array_pad($columns, 6, '');
            $date      = $this->bankCsvDate($columns[0]);
            $valueDate = $columns[1] !== '' ? $this->bankCsvDate($columns[1]) : null;
            $label     = mb_substr($columns[2], 0, 255);
            $debit     = $this->bankCsvAmount($columns[4]);
            $credit    = $this->bankCsvAmount($columns[5]);

            if (!$date) {
                $errors[] = 'Ligne ' . $lineNo . ' : date invalide (« ' . $columns[0] . ' »).';
                continue;
            }

            if ($columns[1] !== '' && !$valueDate) {
                $errors[] = 'Ligne ' . $lineNo . ' : date de valeur invalide.';
                continue;
            }

            if ($label === '') {
                $errors[] = 'Ligne ' . $lineNo . ' : libellé manquant.';
                continue;
            }

            if ($debit < 0 || $credit < 0) {
                $errors[] = 'Ligne ' . $lineNo . ' : montant invalide.';
                continue;
            }

            if (($debit > 0) === ($credit > 0)) {
                $errors[] = 'Ligne ' . $lineNo . ' : renseignez soit un débit, soit un crédit.';
                continue;
            }

            $rows[] = [
                'line'           => $lineNo,
                'operation_date' => $date,
                'value_date'     => $valueDate,
                'label'          => $label,
                'bank_reference' => mb_substr($columns[3], 0, 100),
                'debit'          => $debit,
                'credit'         => $credit,
            ];
        }

        fclose($handle);

        return ['rows' => $rows, 'errors' => $errors];
    }

    /** POST : import CSV des lignes du relevé. */
    public function statementImport()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $reconciliationId = (int) $this->input->post('reconciliation_id', true);
        $back             = 'rapprochement/' . $reconciliationId;
        $file             = $_FILES['statement_file'] ?? null;

        if (!$file || empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            $this->session->set_flashdata('error', 'Choisissez un fichier CSV à importer.');
            redirect($back);
            return;
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, ['csv', 'txt'], true)) {
            $this->session->set_flashdata('error', 'Format non accepté. Depuis Excel : Fichier → Enregistrer sous → « CSV (séparateur : point-virgule) ».');
            redirect($back);
            return;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            $this->session->set_flashdata('error', 'Fichier trop volumineux (2 Mo maximum).');
            redirect($back);
            return;
        }

        $parsed = $this->bankParseStatementCsv($file['tmp_name']);

        if (empty($parsed['rows'])) {
            $details = !empty($parsed['errors'])
                ? '<br>' . implode('<br>', array_map('html_escape', array_slice($parsed['errors'], 0, 10)))
                : '';

            $this->session->set_flashdata('error', 'Aucune ligne valide trouvée dans le fichier.' . $details);
            redirect($back);
            return;
        }

        $result = $this->finance->importStatementLines(
            $reconciliationId,
            $parsed['rows'],
            $file['name'],
            $this->bankCurrentUserId()
        );

        if (!$result['status']) {
            $this->session->set_flashdata('error', $result['message']);
            redirect($back);
            return;
        }

        $errors  = array_merge($parsed['errors'], $result['errors']);
        $message = '<strong>' . (int) $result['imported'] . '</strong> ligne(s) importée(s).';

        if (!empty($errors)) {
            $message .= '<br><br><strong>' . count($errors) . ' ligne(s) ignorée(s) :</strong><br>'
                . implode('<br>', array_map('html_escape', array_slice($errors, 0, 10)))
                . (count($errors) > 10 ? '<br>…' : '');
        }

        $this->session->set_flashdata('success', $message);
        redirect($back);
    }

    /** Téléchargement du modèle CSV. */
    public function statementTemplate()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="modele_releve_bancaire.csv"');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['date', 'date_valeur', 'libelle', 'reference', 'debit', 'credit'], ';');
        fputcsv($out, ['01/10/2026', '01/10/2026', 'VIREMENT RECU CLIENT ABC', 'VIR123456', '', '2500000'], ';');
        fputcsv($out, ['03/10/2026', '03/10/2026', 'FRAIS TENUE DE COMPTE', 'FRS-OCT', '15000', ''], ';');
        fclose($out);
        exit;
    }

    /** AJAX POST : annulation d'un rapprochement non validé. */
    public function reconciliationCancel()
    {
        if (!$this->bankRequireLogin(true)) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $result = $this->finance->cancelReconciliation(
            (int) $this->input->post('reconciliation_id', true),
            (string) $this->input->post('cancel_reason', true),
            $this->bankCurrentUserId()
        );

        $this->bankJson($result, $result['status'] ? 200 : 422);
    }

        /* ---------------------------------------------------------------------
     * LIVRE DE BANQUE
     * ------------------------------------------------------------------- */

    /** Filtres communs à la page, l'impression et l'export. */
    private function bankLedgerFilters(): array
    {
        $dateFrom = (string) $this->input->get('date_from', true);
        $dateTo   = (string) $this->input->get('date_to', true);

        if (!$this->isValidDate($dateFrom)) {
            $dateFrom = date('Y-m-01');
        }

        if (!$this->isValidDate($dateTo)) {
            $dateTo = date('Y-m-d');
        }

        if ($dateFrom > $dateTo) {
            [$dateFrom, $dateTo] = [$dateTo, $dateFrom];
        }

        $sens       = (string) $this->input->get('sens', true);
        $reconciled = (string) $this->input->get('reconciled', true);
        $nature     = (string) $this->input->get('nature', true);

        return [
            'date_from'  => $dateFrom,
            'date_to'    => $dateTo,
            'sens'       => in_array($sens, ['entree', 'sortie'], true) ? $sens : '',
            'nature'     => array_key_exists($nature, $this->finance->getBankMovementNatureLabels()) ? $nature : '',
            'search'     => trim((string) $this->input->get('search', true)),
            'reconciled' => in_array($reconciled, ['yes', 'no'], true) ? $reconciled : '',
        ];
    }

    /** Compte demandé, ou premier compte actif si aucun identifiant. */
    private function bankLedgerAccount($id)
    {
        if ((int) $id > 0) {
            return $this->finance->getBankAccountById((int) $id);
        }

        $accounts = $this->finance->getActiveBankAccounts();

        return !empty($accounts) ? $this->finance->getBankAccountById((int) $accounts[0]->id) : null;
    }

    /** Page : livre de banque d'un compte. */
    public function bankLedger($id = null)
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        $account = $this->bankLedgerAccount($id);

        if (!$account) {
            $this->session->set_flashdata('error', 'Aucun compte bancaire trouvé. Créez d’abord un compte.');
            redirect('compte-banques');
            return;
        }

        $filters = $this->bankLedgerFilters();
        $ledger  = $this->finance->getBankLedger((int) $account->id, $filters);

        /* Pagination (ordre chronologique conservé) */
        $perPage = 50;
        $total   = count($ledger['rows']);
        $pages   = max(1, (int) ceil($total / $perPage));
        $page    = min(max(1, (int) $this->input->get('page')), $pages);

        $ledger['rows'] = array_slice($ledger['rows'], ($page - 1) * $perPage, $perPage);

        $data = [
            'title'        => 'Livre de banque',
            'account'      => $account,
            'accounts'     => $this->finance->getBankAccounts([]),
            'filters'      => $filters,
            'ledger'       => $ledger,
            'natureLabels' => $this->finance->getBankMovementNatureLabels(),
            'pagination'   => [
                'page'     => $page,
                'pages'    => $pages,
                'total'    => $total,
                'per_page' => $perPage,
                'from'     => $total ? ($page - 1) * $perPage + 1 : 0,
                'to'       => min($page * $perPage, $total),
            ],
        ];

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/banque_livre', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    /** Impression du livre (page autonome, toutes les lignes filtrées). */
    public function bankLedgerPrint($id = null)
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        $account = $this->bankLedgerAccount($id);

        if (!$account) {
            show_404();
            return;
        }

        $filters = $this->bankLedgerFilters();

        $this->load->view('v1/components/modules/finance/banque_livre_print', [
            'title'        => 'Livre de banque',
            'account'      => $account,
            'filters'      => $filters,
            'ledger'       => $this->finance->getBankLedger((int) $account->id, $filters),
            'natureLabels' => $this->finance->getBankMovementNatureLabels(),
            'printedBy'    => trim($this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name')),
        ]);
    }

    /** Export CSV du livre (compatible Excel). */
    public function bankLedgerExport($id = null)
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        $account = $this->bankLedgerAccount($id);

        if (!$account) {
            show_404();
            return;
        }

        $filters = $this->bankLedgerFilters();
        $ledger  = $this->finance->getBankLedger((int) $account->id, $filters);
        $natures = $this->finance->getBankMovementNatureLabels();

        $amount = function ($value) {
            return number_format((float) $value, 2, ',', '');
        };

        $date = function ($value) {
            return $value ? date('d/m/Y', strtotime($value)) : '';
        };

        $filename = 'livre_banque_' . $account->code . '_' . $filters['date_from'] . '_au_' . $filters['date_to'] . '.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF"); /* BOM pour Excel */

        fputcsv($out, ['Livre de banque', $account->code . ' — ' . $account->name, $account->bank_name, $account->account_number, $account->currency], ';');
        fputcsv($out, ['Période', $date($filters['date_from']) . ' au ' . $date($filters['date_to'])], ';');
        fputcsv($out, [], ';');

        fputcsv($out, ['N°', 'Date', 'Date de valeur', 'Référence', 'Opération', 'Nature', 'Libellé', 'Tiers', 'N° de pièce', 'Entrée', 'Sortie', 'Solde', 'Pointé'], ';');
        fputcsv($out, ['', $date($filters['date_from']), '', '', '', '', 'Solde d’ouverture', '', '', '', '', $amount($ledger['opening_balance']), ''], ';');

        foreach ($ledger['rows'] as $row) {
            fputcsv($out, [
                $row->line_number,
                $date($row->movement_date),
                $date($row->value_date),
                $row->reference,
                $row->operation_reference,
                $natures[$row->nature] ?? $row->nature,
                $row->label,
                $row->third_party,
                $row->document_number,
                $row->entry_amount > 0 ? $amount($row->entry_amount) : '',
                $row->exit_amount > 0 ? $amount($row->exit_amount) : '',
                $amount($row->running_balance),
                (int) $row->is_reconciled === 1 ? 'Oui' : 'Non',
            ], ';');
        }

        fputcsv($out, ['', '', '', '', '', '', 'Totaux', '', '', $amount($ledger['filtered_in']), $amount($ledger['filtered_out']), '', ''], ';');
        fputcsv($out, ['', $date($filters['date_to']), '', '', '', '', 'Solde de clôture', '', '', '', '', $amount($ledger['closing_balance']), ''], ';');

        fclose($out);
        exit;
    }

        /* =====================================================================
     *  PRÉVISIONS DE TRÉSORERIE
     * ===================================================================== */

    /** Filtres communs à la page et à l'export. */
    private function previsionFilters(): array
    {
        $horizon  = (string) $this->input->get('horizon', true);
        $currency = (string) $this->input->get('currency', true);
        $scenario = (string) $this->input->get('scenario', true);
        $flow     = (string) $this->input->get('flow_type', true);
        $status   = (string) $this->input->get('status', true);

        return [
            'horizon'   => in_array($horizon, ['13w', '6m', '12m'], true) ? $horizon : '13w',
            'currency'  => in_array($currency, ['BIF', 'USD', 'EUR'], true) ? $currency : 'BIF',
            'scenario'  => in_array($scenario, ['pondere', 'brut'], true) ? $scenario : 'pondere',
            'threshold' => trim((string) $this->input->get('threshold', true)),
            'flow_type' => in_array($flow, ['entree', 'sortie'], true) ? $flow : '',
            'status'    => in_array($status, ['open', 'planned', 'partially_realized', 'realized', 'cancelled'], true) ? $status : 'open',
        ];
    }

    /** Calcule position, seuil et plan pour des filtres donnés. */
    private function previsionBuild(array $filters): array
    {
        $position  = $this->finance->getTreasuryStartingPosition($filters['currency']);
        $threshold = is_numeric($filters['threshold']) ? max(0, (float) $filters['threshold']) : $position['alert_threshold'];

        $plan = $this->finance->getTreasuryPlan(
            $filters['horizon'],
            $filters['currency'],
            $filters['scenario'],
            $position['total'],
            $threshold
        );

        return [$position, $threshold, $plan];
    }

    public function prevision()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        $filters = $this->previsionFilters();
        [$position, $threshold, $plan] = $this->previsionBuild($filters);

        $data = [
            'title'                => 'Prévisions de trésorerie',
            'filters'              => $filters,
            'position'             => $position,
            'threshold'            => $threshold,
            'plan'                 => $plan,
            'categories'           => $this->finance->getForecastCategories(),
            'forecasts'            => $this->finance->getTreasuryForecasts([
                'currency'  => $filters['currency'],
                'flow_type' => $filters['flow_type'],
                'status'    => $filters['status'],
            ]),
            'forecastVsActual'     => $this->finance->getForecastVsActual($filters['currency'], 6),
            'bankAccounts'         => $this->finance->getActiveBankAccounts(),
            'chantiers'            => $this->finance->getAllChantiers(),
            'realizableOperations' => $this->finance->getRealizableBankOperations($filters['currency']),
        ];

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/prevision', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    /** POST : nouvelle prévision (avec récurrence éventuelle). */
    public function previsionStore()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $back = 'prevision?' . (string) $this->input->post('return_query', true);

        $this->form_validation->set_rules('flow_type', 'Sens du flux', 'trim|required|in_list[entree,sortie]');
        $this->form_validation->set_rules('category', 'Catégorie', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('label', 'Libellé', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('expected_date', 'Date prévue', 'trim|required');
        $this->form_validation->set_rules('amount', 'Montant', 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('currency', 'Devise', 'trim|required|in_list[BIF,USD,EUR]');
        $this->form_validation->set_rules('probability', 'Probabilité', 'trim|required|integer|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('recurrence', 'Récurrence', 'trim|required|in_list[none,weekly,monthly,quarterly,yearly]');
        $this->form_validation->set_rules('recurrence_end_date', 'Fin de récurrence', 'trim');
        $this->form_validation->set_rules('bank_account_id', 'Compte bancaire', 'trim|integer');
        $this->form_validation->set_rules('chantier_id', 'Chantier', 'trim|integer');
        $this->form_validation->set_rules('third_party', 'Tiers', 'trim|max_length[255]');
        $this->form_validation->set_rules('observation', 'Observation', 'trim|max_length[2000]');
        $this->bankValidationMessages();
        $this->form_validation->set_message('less_than_equal_to', 'Le champ {field} ne peut pas dépasser {param}.');

        $error = null;

        if ($this->form_validation->run() === false) {
            $error = validation_errors('<div>', '</div>');
        } else {
            $expectedDate = (string) $this->input->post('expected_date', true);
            $recurrence   = (string) $this->input->post('recurrence', true);
            $endDate      = trim((string) $this->input->post('recurrence_end_date', true));

            if (!$this->isValidDate($expectedDate)) {
                $error = 'La date prévue est invalide.';
            } elseif ($recurrence !== 'none' && !$this->isValidDate($endDate)) {
                $error = 'Indiquez une date de fin de récurrence valide.';
            }
        }

        if ($error === null) {
            $result = $this->finance->createTreasuryForecast([
                'flow_type'           => $this->input->post('flow_type', true),
                'category'            => $this->input->post('category', true),
                'label'               => trim((string) $this->input->post('label', true)),
                'expected_date'       => $expectedDate,
                'amount'              => (float) $this->input->post('amount', true),
                'currency'            => $this->input->post('currency', true),
                'probability'         => (int) $this->input->post('probability', true),
                'recurrence'          => $recurrence,
                'recurrence_end_date' => $endDate,
                'bank_account_id'     => $this->input->post('bank_account_id', true),
                'chantier_id'         => $this->input->post('chantier_id', true),
                'third_party'         => $this->input->post('third_party', true),
                'observation'         => $this->input->post('observation', true),
                'created_by'          => $this->bankCurrentUserId(),
            ]);

            if ($result['status']) {
                $this->session->set_flashdata('success', $result['message']);
                redirect($back);
                return;
            }

            $error = $result['message'];
        }

        $this->session->set_flashdata('error', $error);
        $this->session->set_flashdata('open_forecast_modal', true);
        $this->session->set_flashdata('forecast_old_input', $this->input->post(null, true));
        redirect($back);
    }

    /** AJAX POST : réalisation d'une prévision. */
    public function previsionRealize()
    {
        if (!$this->bankRequireLogin(true)) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $date = (string) $this->input->post('realized_date', true);

        if (!$this->isValidDate($date) || $date > date('Y-m-d')) {
            $this->bankJson(['status' => false, 'message' => 'La date de réalisation est invalide ou dans le futur.'], 422);
            return;
        }

        $result = $this->finance->realizeTreasuryForecast(
            (int) $this->input->post('forecast_id', true),
            (float) $this->input->post('realized_amount', true),
            $date,
            (int) $this->input->post('bank_operation_id', true) ?: null,
            $this->bankCurrentUserId()
        );

        $this->bankJson($result, $result['status'] ? 200 : 422);
    }

    /** AJAX POST : annulation d'une prévision (ou de la suite de sa série). */
    public function previsionCancel()
    {
        if (!$this->bankRequireLogin(true)) {
            return;
        }

        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $result = $this->finance->cancelTreasuryForecast(
            (int) $this->input->post('forecast_id', true),
            (string) $this->input->post('cancel_reason', true),
            (bool) $this->input->post('cancel_series', true),
            $this->bankCurrentUserId()
        );

        $this->bankJson($result, $result['status'] ? 200 : 422);
    }

    /** Export CSV du plan de trésorerie (compatible Excel). */
    public function previsionExport()
    {
        if (!$this->bankRequireLogin()) {
            return;
        }

        $filters = $this->previsionFilters();
        [$position, $threshold, $plan] = $this->previsionBuild($filters);

        $amount = function ($value) {
            return number_format((float) $value, 0, ',', '');
        };

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="plan_tresorerie_' . $filters['currency'] . '_' . date('Ymd') . '.csv"');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");

        fputcsv($out, ['Plan de trésorerie', $filters['currency'], 'Scénario : ' . ($filters['scenario'] === 'pondere' ? 'pondéré' : 'brut'), 'Édité le ' . date('d/m/Y H:i')], ';');
        fputcsv($out, [], ';');

        $header = ['Rubrique'];

        foreach ($plan['periods'] as $period) {
            $header[] = $period['label'] . ' (' . $period['sublabel'] . ')';
        }

        $header[] = 'Total';
        fputcsv($out, $header, ';');

        $line = function (string $label, array $values, $total = '') use ($out, $amount) {
            fputcsv($out, array_merge([$label], array_map($amount, $values), [$total === '' ? '' : $amount($total)]), ';');
        };

        $line('Solde de début', $plan['openings']);

        foreach ($plan['rows']['entree'] as $row) {
            $line('  + ' . $row['label'], $row['values'], $row['total']);
        }

        $line('Total encaissements', $plan['totals_in'], $plan['total_in']);

        foreach ($plan['rows']['sortie'] as $row) {
            $line('  - ' . $row['label'], $row['values'], $row['total']);
        }

        $line('Total décaissements', $plan['totals_out'], $plan['total_out']);
        $line('Flux net', $plan['net'], $plan['total_in'] - $plan['total_out']);
        $line('Solde de fin', $plan['closings']);
        $line('Seuil de sécurité', array_fill(0, count($plan['periods']), $threshold));

        fclose($out);
        exit;
    }

    public function factureClient()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Factures clients';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/finance/facture_client');
        $this->load->view('v1/components/layout/footer');
    }

    public function factureFournisseur()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Factures fournisseurs';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/finance/facture_fournisseur');
        $this->load->view('v1/components/layout/footer');
    }

    public function paiement()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Paiements';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/finance/paiement');
        $this->load->view('v1/components/layout/footer');
    }

    public function echeances()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Échéances';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/finance/echeances');
        $this->load->view('v1/components/layout/footer');
    }
}
