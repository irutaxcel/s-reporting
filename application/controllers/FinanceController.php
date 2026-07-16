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

    // public function caisse()
    // {
    //     if (!$this->session->userdata('user_id')) {
    //         redirect('sign-in');
    //         return;
    //     }

    //     $data = [
    //         'title'           => 'Caisse',
    //         'allChantiers'    => $this->tech->getAllChantiers(),
    //         'allCashboxes'    => $this->finance->getAllCashboxes(),
    //         'nextCashboxCode' => $this->finance->getNextCashboxCode(),
    //     ];

    //     $this->load->view(
    //         'v1/components/layout/header',
    //         $data
    //     );

    //     $this->load->view(
    //         'v1/components/layout/sidebar',
    //         $data
    //     );

    //     $this->load->view(
    //         'v1/components/modules/finance/caisse',
    //         $data
    //     );

    //     $this->load->view(
    //         'v1/components/layout/footer'
    //     );
    // }

    public function caisse()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data = [];

        $data['title'] = 'Caisse';

        /*
     * =========================================================
     * FILTRES DES CAISSES
     * =========================================================
     */

        $cashboxSearch = trim(
            (string) $this->input->get(
                'cashbox_search',
                true
            )
        );

        $cashboxType = trim(
            (string) $this->input->get(
                'cashbox_type',
                true
            )
        );

        $cashboxChantierId = (int) $this->input->get(
            'chantier_id',
            true
        );

        $cashboxSituation = trim(
            (string) $this->input->get(
                'cashbox_situation',
                true
            )
        );

        if (
            !in_array(
                $cashboxType,
                ['', 'siege', 'chantier'],
                true
            )
        ) {
            $cashboxType = '';
        }

        if (
            !in_array(
                $cashboxSituation,
                ['', 'normal', 'faible', 'critique'],
                true
            )
        ) {
            $cashboxSituation = '';
        }

        $cashboxFilters = [
            'search'       => $cashboxSearch,
            'type'         => $cashboxType,
            'chantier_id'  => $cashboxChantierId,
            'situation'    => $cashboxSituation,
        ];

        $data['cashboxFilters'] =
            $cashboxFilters;

        /*
     * =========================================================
     * STATISTIQUES PRINCIPALES
     * =========================================================
     */

        $data['cashboxMainStatistics'] =
            $this->finance
            ->getCashboxMainStatistics();

        /*
     * =========================================================
     * LISTE ET SITUATION DES CAISSES
     * =========================================================
     */

        $data['allCashboxes'] =
            $this->finance
            ->getAllCashboxes();

        $data['cashboxSituations'] =
            $this->finance
            ->getCashboxSituations(
                $cashboxFilters
            );

        $data['filteredCashboxesCount'] =
            count(
                $data['cashboxSituations']
            );

        $data['activeCashboxesCount'] =
            $this->finance
            ->countActiveCashboxes();

        /*
     * =========================================================
     * ÉVOLUTION DE LA TRÉSORERIE
     * =========================================================
     */

        $allowedCashFlowPeriods = [
            '7days',
            '30days',
            'month',
            'year',
        ];

        $cashFlowPeriod = trim(
            (string) $this->input->get(
                'cashflow_period',
                true
            )
        );

        if (
            !in_array(
                $cashFlowPeriod,
                $allowedCashFlowPeriods,
                true
            )
        ) {
            $cashFlowPeriod = '7days';
        }

        $data['cashFlowPeriod'] =
            $cashFlowPeriod;

        $data['cashFlowEvolution'] =
            $this->finance
            ->getCashFlowEvolution(
                $cashFlowPeriod
            );

        /*
     * =========================================================
     * ALERTES
     * =========================================================
     */

        $data['treasuryAlerts'] =
            $this->finance
            ->getTreasuryAlerts(8);

        $data['treasuryAlertsCount'] =
            $this->finance
            ->countTreasuryAlerts();

        /*
     * =========================================================
     * MOUVEMENTS RÉCENTS
     * =========================================================
     */

        $data['recentCashboxMovements'] =
            $this->finance
            ->getRecentCashboxMovements(10);

        $data['cashboxMovementsCount'] =
            $this->finance
            ->countCashboxMovements();

        /*
     * =========================================================
     * DÉPENSES ET SYNTHÈSE CHANTIER
     * =========================================================
     */

        $data['monthlyMainExpenses'] =
            $this->finance
            ->getMonthlyMainExpenses(5);

        $data['cashboxSummaryByChantier'] =
            $this->finance
            ->getCashboxSummaryByChantier();

        /*
     * =========================================================
     * CODES AUTOMATIQUES
     * =========================================================
     */

        $data['nextCashboxCode'] =
            $this->finance
            ->getNextCashboxCode();

        $data['nextOperationReference'] =
            $this->finance
            ->getNextCashboxOperationReference();

        /*
     * =========================================================
     * CHANTIERS
     * =========================================================
     */

        $data['allChantiers'] =
            $this->tech
            ->getAllChantiers();

        /*
     * =========================================================
     * VUES
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
            'v1/components/modules/finance/caisse',
            $data
        );

        $this->load->view(
            'v1/components/layout/footer'
        );
    }

    public function caisseStore()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        /*
     * Règles de validation.
     */
        $this->form_validation->set_rules(
            'name',
            'Intitulé de la caisse',
            'trim|required|min_length[3]|max_length[150]'
        );

        $this->form_validation->set_rules(
            'type',
            'Type de caisse',
            'trim|required|in_list[siege,chantier]'
        );

        $this->form_validation->set_rules(
            'responsable',
            'Responsable de caisse',
            'trim|max_length[150]'
        );

        $this->form_validation->set_rules(
            'devise',
            'Devise',
            'trim|required|in_list[BIF,USD,EUR]'
        );

        $this->form_validation->set_rules(
            'opening_balance',
            'Solde initial',
            'trim|required|numeric|greater_than_equal_to[0]'
        );

        $this->form_validation->set_rules(
            'alert_threshold',
            'Seuil d’alerte',
            'trim|required|numeric|greater_than_equal_to[0]'
        );

        $type = $this->input->post(
            'type',
            true
        );

        /*
     * Le chantier est obligatoire uniquement pour une caisse chantier.
     */
        if ($type === 'chantier') {
            $this->form_validation->set_rules(
                'chantier_id',
                'Chantier associé',
                'trim|required|integer'
            );
        }

        $this->form_validation->set_message(
            'required',
            'Le champ {field} est obligatoire.'
        );

        $this->form_validation->set_message(
            'in_list',
            'La valeur sélectionnée pour {field} est invalide.'
        );

        $this->form_validation->set_message(
            'numeric',
            'Le champ {field} doit contenir un montant valide.'
        );

        $this->form_validation->set_message(
            'greater_than_equal_to',
            'Le champ {field} ne peut pas être négatif.'
        );

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata(
                'error',
                validation_errors('<div>', '</div>')
            );

            /*
         * old_input permettra de conserver les valeurs dans le formulaire.
         */
            $this->session->set_flashdata(
                'old_input',
                $this->input->post(NULL, true)
            );

            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $chantierId = null;

        if ($type === 'chantier') {
            $chantierId = (int) $this->input->post(
                'chantier_id',
                true
            );

            /*
         * Empêcher deux caisses actives sur un même chantier.
         */
            if ($this->finance->chantierHasCashbox($chantierId)) {
                $this->session->set_flashdata(
                    'error',
                    'Ce chantier possède déjà une caisse active.'
                );

                redirect($_SERVER['HTTP_REFERER']);
                return;
            }
        }

        /*
     * Pour une caisse siège, chantier_id reste obligatoirement NULL.
     */
        if ($type === 'siege') {
            $chantierId = null;
        }

        $openingBalance = (float) $this->input->post(
            'opening_balance',
            true
        );

        $cashboxData = [
            /*
         * Le champ code n'est pas récupéré ici.
         * Il sera généré automatiquement dans le modèle.
         */
            'name'            => trim(
                $this->input->post('name', true)
            ),

            'type'            => $type,
            'chantier_id'     => $chantierId,

            'responsable'     => trim(
                (string) $this->input->post('responsable', true)
            ) ?: null,

            'devise'          => $this->input->post(
                'devise',
                true
            ),

            'opening_balance' => $openingBalance,
            'current_balance' => $openingBalance,

            'alert_threshold' => (float) $this->input->post(
                'alert_threshold',
                true
            ),

            'observation'     => trim(
                (string) $this->input->post('observation', true)
            ) ?: null,

            'status'          => 'active',

            'created_by'      => $this->session->userdata('user_id')
                ?: null,

            'created_at'      => date('Y-m-d H:i:s'),
        ];

        $result = $this->finance->createCashbox(
            $cashboxData
        );

        if (!$result['status']) {
            $this->session->set_flashdata(
                'error',
                $result['message']
                    ?? 'Une erreur est survenue pendant la création de la caisse.'
            );

            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $this->session->set_flashdata(
            'success',
            'La caisse '
                . $result['code']
                . ' a été créée avec succès.'
        );

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function cashboxOperationStore()
    {
        /*
        * Autoriser uniquement les requêtes POST.
        */
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
        }

        $this->load->library('form_validation');

        /*
        * =========================================================
        * 1. RÈGLES DE VALIDATION
        * =========================================================
        */

        $this->form_validation->set_rules(
            'operation_type',
            'Type d’opération',
            'trim|required|in_list[encaissement,decaissement,approvisionnement]'
        );

        $this->form_validation->set_rules(
            'operation_date',
            'Date de l’opération',
            'trim|required'
        );

        $this->form_validation->set_rules(
            'cashbox_id',
            'Caisse concernée',
            'trim|required|integer'
        );

        $this->form_validation->set_rules(
            'amount',
            'Montant',
            'trim|required|numeric|greater_than[0]'
        );

        $this->form_validation->set_rules(
            'category',
            'Catégorie',
            'trim|max_length[100]'
        );

        $this->form_validation->set_rules(
            'third_party',
            'Bénéficiaire / Provenance',
            'trim|max_length[180]'
        );

        $this->form_validation->set_rules(
            'payment_method',
            'Mode de règlement',
            'trim|required|in_list[cash,bank,cheque,mobile]'
        );

        $this->form_validation->set_rules(
            'document_number',
            'Numéro de pièce',
            'trim|max_length[100]'
        );

        $this->form_validation->set_rules(
            'observation',
            'Observation',
            'trim'
        );

        /*
     * Récupérer le type d’opération avant la validation,
     * afin d’ajouter les règles conditionnelles.
     */
        $operationType = trim(
            (string) $this->input->post(
                'operation_type',
                TRUE
            )
        );

        /*
     * La caisse destination est obligatoire uniquement
     * pour un approvisionnement/transfert interne.
     */
        if ($operationType === 'approvisionnement') {
            $this->form_validation->set_rules(
                'destination_cashbox_id',
                'Caisse destination',
                'trim|required|integer'
            );
        }

        /*
     * Messages personnalisés.
     */
        $this->form_validation->set_message(
            'required',
            'Le champ {field} est obligatoire.'
        );

        $this->form_validation->set_message(
            'integer',
            'La valeur sélectionnée pour {field} est invalide.'
        );

        $this->form_validation->set_message(
            'numeric',
            'Le champ {field} doit contenir un nombre valide.'
        );

        $this->form_validation->set_message(
            'greater_than',
            'Le montant doit être supérieur à zéro.'
        );

        $this->form_validation->set_message(
            'in_list',
            'La valeur sélectionnée pour {field} est invalide.'
        );

        /*
        * Arrêter si la validation échoue.
        */
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata(
                'error',
                validation_errors('<div>', '</div>')
            );

            /*
            * Conserver les valeurs pour éventuellement
            * rouvrir la modale avec les anciennes données.
            */
            $this->session->set_flashdata(
                'operation_old_input',
                $this->input->post(NULL, TRUE)
            );

            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        /*
        * =========================================================
        * 2. RÉCUPÉRATION ET NORMALISATION DES DONNÉES
        * =========================================================
        */

        $operationDate = trim(
            (string) $this->input->post(
                'operation_date',
                TRUE
            )
        );

        $cashboxId = (int) $this->input->post(
            'cashbox_id',
            TRUE
        );

        $amount = (float) $this->input->post(
            'amount',
            TRUE
        );

        $category = trim(
            (string) $this->input->post(
                'category',
                TRUE
            )
        );

        $thirdParty = trim(
            (string) $this->input->post(
                'third_party',
                TRUE
            )
        );

        $paymentMethod = trim(
            (string) $this->input->post(
                'payment_method',
                TRUE
            )
        );

        $documentNumber = trim(
            (string) $this->input->post(
                'document_number',
                TRUE
            )
        );

        $observation = trim(
            (string) $this->input->post(
                'observation',
                TRUE
            )
        );

        /*
     * Vérifier que la date est réellement valide.
     */
        $dateObject = DateTime::createFromFormat(
            'Y-m-d',
            $operationDate
        );

        if (
            !$dateObject
            || $dateObject->format('Y-m-d') !== $operationDate
        ) {
            $this->session->set_flashdata(
                'error',
                'La date de l’opération est invalide.'
            );

            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        /*
     * Sécurisation supplémentaire.
     */
        if ($amount <= 0) {
            $this->session->set_flashdata(
                'error',
                'Le montant doit être supérieur à zéro.'
            );

            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        /*
        * =========================================================
        * 3. DÉTERMINER LA CAISSE SOURCE ET LA DESTINATION
        * =========================================================
        */

        $sourceCashboxId = NULL;
        $destinationCashboxId = NULL;

        /*
        * Encaissement :
        * la caisse concernée reçoit l’argent.
        */
        if ($operationType === 'encaissement') {
            $destinationCashboxId = $cashboxId;
        }

        /*
        * Décaissement :
        * la caisse concernée envoie ou dépense l’argent.
        */ elseif ($operationType === 'decaissement') {
            $sourceCashboxId = $cashboxId;
        }

        /*
        * Approvisionnement :
        * la caisse concernée est la source ;
        * la deuxième caisse est la destination.
        */ elseif ($operationType === 'approvisionnement') {
            $sourceCashboxId = $cashboxId;

            $destinationCashboxId = (int) $this->input->post(
                'destination_cashbox_id',
                TRUE
            );

            if ($destinationCashboxId <= 0) {
                $this->session->set_flashdata(
                    'error',
                    'La caisse destination est obligatoire.'
                );

                redirect($_SERVER['HTTP_REFERER']);
                return;
            }

            if ($sourceCashboxId === $destinationCashboxId) {
                $this->session->set_flashdata(
                    'error',
                    'La caisse source et la caisse destination doivent être différentes.'
                );

                redirect($_SERVER['HTTP_REFERER']);
                return;
            }
        }

        /*
     * =========================================================
     * 4. RÉCUPÉRER LES CAISSES
     * =========================================================
     */

        $sourceCashbox = NULL;
        $destinationCashbox = NULL;

        if ($sourceCashboxId !== NULL) {
            $sourceCashbox = $this->db
                ->where('id', $sourceCashboxId)
                ->get('tbl_finance_cashbox')
                ->row();

            if (!$sourceCashbox) {
                $this->session->set_flashdata(
                    'error',
                    'La caisse source sélectionnée est introuvable.'
                );

                redirect($_SERVER['HTTP_REFERER']);
                return;
            }

            if ($sourceCashbox->status !== 'active') {
                $this->session->set_flashdata(
                    'error',
                    'La caisse source sélectionnée n’est pas active.'
                );

                redirect($_SERVER['HTTP_REFERER']);
                return;
            }
        }

        if ($destinationCashboxId !== NULL) {
            $destinationCashbox = $this->db
                ->where('id', $destinationCashboxId)
                ->get('tbl_finance_cashbox')
                ->row();

            if (!$destinationCashbox) {
                $this->session->set_flashdata(
                    'error',
                    'La caisse destination sélectionnée est introuvable.'
                );

                redirect($_SERVER['HTTP_REFERER']);
                return;
            }

            if ($destinationCashbox->status !== 'active') {
                $this->session->set_flashdata(
                    'error',
                    'La caisse destination sélectionnée n’est pas active.'
                );

                redirect($_SERVER['HTTP_REFERER']);
                return;
            }
        }

        /*
        * Pour un approvisionnement, les deux caisses doivent
        * utiliser la même devise.
        */
        if (
            $operationType === 'approvisionnement'
            && $sourceCashbox
            && $destinationCashbox
            && $sourceCashbox->devise !== $destinationCashbox->devise
        ) {
            $this->session->set_flashdata(
                'error',
                'Le transfert est impossible entre deux caisses de devises différentes.'
            );

            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        /*
        * Vérification informative avant l’appel du modèle.
        * Le modèle devra refaire la vérification dans la transaction.
        */
        if (
            in_array(
                $operationType,
                ['decaissement', 'approvisionnement'],
                TRUE
            )
            && $sourceCashbox
            && (float) $sourceCashbox->current_balance < $amount
        ) {
            $this->session->set_flashdata(
                'error',
                'Le solde disponible dans la caisse source est insuffisant.'
            );

            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        /*
        * =========================================================
        * 5. UPLOAD DE LA PIÈCE JUSTIFICATIVE
        * =========================================================
        */

        $attachmentName = NULL;

        if (
            isset($_FILES['attachment'])
            && isset($_FILES['attachment']['name'])
            && $_FILES['attachment']['name'] !== ''
        ) {
            $uploadPath = FCPATH
                . 'uploads/finance/cashbox_operations/';

            /*
         * Créer le dossier s’il n’existe pas.
         */
            if (!is_dir($uploadPath)) {
                $created = mkdir(
                    $uploadPath,
                    0755,
                    TRUE
                );

                if (!$created && !is_dir($uploadPath)) {
                    $this->session->set_flashdata(
                        'error',
                        'Impossible de créer le dossier des pièces justificatives.'
                    );

                    redirect($_SERVER['HTTP_REFERER']);
                    return;
                }
            }

            $config = [
                'upload_path'   => $uploadPath,
                'allowed_types' => 'pdf|jpg|jpeg|png|doc|docx|xls|xlsx',
                'max_size'      => 5120,
                'encrypt_name'  => TRUE,
                'remove_spaces' => TRUE,
            ];

            $this->load->library(
                'upload',
                $config
            );

            $this->upload->initialize(
                $config
            );

            if (!$this->upload->do_upload('attachment')) {
                $this->session->set_flashdata(
                    'error',
                    strip_tags(
                        $this->upload->display_errors()
                    )
                );

                redirect($_SERVER['HTTP_REFERER']);
                return;
            }

            $uploadedFile = $this->upload->data();

            $attachmentName = $uploadedFile['file_name'];
        }

        /*
        * =========================================================
        * 6. GÉNÉRATION AUTOMATIQUE DU LIBELLÉ
        * =========================================================
        */

        $automaticLabel = '';

        switch ($operationType) {
            case 'encaissement':

                $automaticLabel = 'Encaissement';

                if ($category !== '') {
                    $automaticLabel .= ' - ' . $category;
                }

                if ($thirdParty !== '') {
                    $automaticLabel .=
                        ' - Provenance : '
                        . $thirdParty;
                }

                if ($destinationCashbox) {
                    $automaticLabel .=
                        ' - Caisse : '
                        . $destinationCashbox->name;
                }

                break;

            case 'decaissement':

                $automaticLabel = 'Décaissement';

                if ($category !== '') {
                    $automaticLabel .= ' - ' . $category;
                }

                if ($thirdParty !== '') {
                    $automaticLabel .=
                        ' - Bénéficiaire : '
                        . $thirdParty;
                }

                if ($sourceCashbox) {
                    $automaticLabel .=
                        ' - Caisse : '
                        . $sourceCashbox->name;
                }

                break;

            case 'approvisionnement':

                $sourceName = $sourceCashbox
                    ? $sourceCashbox->name
                    : 'Caisse source';

                $destinationName = $destinationCashbox
                    ? $destinationCashbox->name
                    : 'Caisse destination';

                $automaticLabel =
                    'Approvisionnement de '
                    . $sourceName
                    . ' vers '
                    . $destinationName;

                /*
                * Pour un transfert interne, la provenance peut
                * être générée automatiquement.
                */
                if ($thirdParty === '') {
                    $thirdParty = $sourceName;
                }

                /*
                * Forcer la catégorie si elle n’a pas été envoyée.
                */
                if ($category === '') {
                    $category = 'Approvisionnement';
                }

                break;
        }

        if ($documentNumber !== '') {
            $automaticLabel .=
                ' - Pièce : '
                . $documentNumber;
        }

        /*
        * Sécurité pour la taille maximale de la colonne VARCHAR(255).
        */
        $automaticLabel = mb_substr(
            $automaticLabel,
            0,
            255,
            'UTF-8'
        );

        /*
        * =========================================================
        * 7. DÉTERMINER LA DEVISE
        * =========================================================
        */

        $currency = 'BIF';

        if ($sourceCashbox) {
            $currency = $sourceCashbox->devise;
        } elseif ($destinationCashbox) {
            $currency = $destinationCashbox->devise;
        }

        /*
        * =========================================================
        * 8. PRÉPARER LES DONNÉES POUR LE MODÈLE
        * =========================================================
        */

        $currentUserId = $this->session->userdata('user_id')
            ?: NULL;

        $operationData = [
            /*
            * La référence sera générée dans le modèle.
            */
            'operation_type' => $operationType,

            'operation_date' => $operationDate,

            'source_cashbox_id' => $sourceCashboxId,

            'destination_cashbox_id' => $destinationCashboxId,

            'amount' => $amount,

            'currency' => $currency,

            'category' => $category !== ''
                ? $category
                : NULL,

            'third_party' => $thirdParty !== ''
                ? $thirdParty
                : NULL,

            'payment_method' => $paymentMethod,

            'document_number' => $documentNumber !== ''
                ? $documentNumber
                : NULL,

            'attachment' => $attachmentName,

            /*
            * Le libellé est généré automatiquement.
            */
            'label' => $automaticLabel,

            'observation' => $observation !== ''
                ? $observation
                : NULL,

            'status' => 'validated',

            'created_by' => $currentUserId,

            'validated_by' => $currentUserId,

            'created_at' => date('Y-m-d H:i:s'),
        ];

        /*
        * =========================================================
        * 9. APPEL DU MODÈLE
        * =========================================================
        */

        $result = $this->finance->createCashboxOperation(
            $operationData
        );

        /*
        * =========================================================
        * 10. GESTION DE L’ÉCHEC
        * =========================================================
        */

        if (
            !is_array($result)
            || empty($result['status'])
        ) {
            /*
            * Supprimer le fichier si la base n’a pas été mise à jour.
            */
            if ($attachmentName) {
                $filePath = FCPATH
                    . 'uploads/finance/cashbox_operations/'
                    . $attachmentName;

                if (is_file($filePath)) {
                    @unlink($filePath);
                }
            }

            $errorMessage =
                is_array($result)
                && !empty($result['message'])
                ? $result['message']
                : 'L’opération n’a pas pu être enregistrée.';

            $this->session->set_flashdata(
                'error',
                $errorMessage
            );

            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        /*
        * =========================================================
        * 11. MESSAGE DE SUCCÈS
        * =========================================================
        */

        $operationLabels = [
            'encaissement' => 'L’encaissement',
            'decaissement' => 'Le décaissement',
            'approvisionnement' => 'Le transfert interne',
        ];

        $successLabel = isset(
            $operationLabels[$operationType]
        )
            ? $operationLabels[$operationType]
            : 'L’opération';

        $reference = !empty($result['reference'])
            ? $result['reference']
            : '';

        $this->session->set_flashdata(
            'success',
            trim(
                $successLabel
                    . ' '
                    . $reference
                    . ' a été enregistré avec succès.'
            )
        );

        redirect($_SERVER['HTTP_REFERER']);
    }

    // public function banques()
    // {
    //     if (!$this->session->userdata('user_id')) {
    //         redirect('sign-in');
    //         return;
    //     }

    //     $data['title'] = 'Comptes bancaires';

    //     // $data['allChantiers'] = $this->tech->getAllChantier();

    //     // $data['encaissementsData'] = $this->tech->getEncaissementsData();

    //     $data['nextBankAccountCode'] =
    //         $this->finance->getNextBankAccountCode();

    //     $data['allBankAccounts'] =
    //         $this->finance->getAllActiveBankAccounts();

    //     $data['nextBankOperationReference'] =
    //         $this->finance->getNextBankOperationReference();

    //     $this->load->view('v1/components/layout/header', $data);
    //     $this->load->view('v1/components/layout/sidebar', $data);
    //     $this->load->view('v1/components/modules/finance/banques', $data);
    //     $this->load->view('v1/components/layout/footer', $data);
    // }

    public function banques()
    {

        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data = [];

        $data['title'] =
            'Comptes bancaires';

        /*
     * Statistiques principales.
     */
        $data['bankMainStatistics'] =
            $this->finance
            ->getBankMainStatistics();

        /*
     * Comptes bancaires.
     */
        $data['allBankAccounts'] =
            $this->finance
            ->getAllActiveBankAccounts();

        /*
     * Situation des comptes.
     */
        $data['bankAccountSituations'] =
            $this->finance
            ->getBankAccountSituations();

        $data['activeBankAccountsCount'] =
            $this->finance
            ->countActiveBankAccounts();

        /*
     * Mouvements bancaires récents.
     */
        $data['recentBankOperations'] =
            $this->finance
            ->getRecentBankOperations(10);

        $data['bankOperationsCount'] =
            $this->finance
            ->countBankOperations();

        /*
     * Évolution des flux.
     */
        $bankFlowPeriod = trim(
            (string) $this->input->get(
                'bankflow_period',
                true
            )
        );

        $allowedPeriods = [
            '7days',
            '30days',
            'month',
            'year',
        ];

        if (
            !in_array(
                $bankFlowPeriod,
                $allowedPeriods,
                true
            )
        ) {
            $bankFlowPeriod = '7days';
        }

        $data['bankFlowPeriod'] =
            $bankFlowPeriod;

        $data['bankFlowEvolution'] =
            $this->finance
            ->getBankFlowEvolution(
                $bankFlowPeriod
            );

        $data['bankBalanceDistribution'] =
            $this->finance
            ->getBankBalanceDistribution();

        /*
     * Références automatiques.
     */
        $data['nextBankAccountCode'] =
            $this->finance
            ->getNextBankAccountCode();

        $data['nextBankOperationReference'] =
            $this->finance
            ->getNextBankOperationReference();

        $data['bankAlerts'] =
            $this->finance
            ->getBankAlerts(6);

        $data['bankAlertsCount'] =
            count(
                $data['bankAlerts']
            );

        $this->load->view(
            'v1/components/layout/header',
            $data
        );

        $this->load->view(
            'v1/components/layout/sidebar',
            $data
        );

        $this->load->view(
            'v1/components/modules/finance/banques',
            $data
        );

        $this->load->view(
            'v1/components/layout/footer'
        );
    }

    /**
     * Enregistre un nouveau compte bancaire.
     */
    public function bankAccountStore()
    {
        /*
        * =========================================================
        * 1. AUTORISER UNIQUEMENT LES REQUÊTES POST
        * =========================================================
        */

        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        /*
        * Charger la bibliothèque de validation.
        */
        $this->load->library('form_validation');

        /*
        * =========================================================
        * 2. RÈGLES DE VALIDATION
        * =========================================================
        */

        $this->form_validation->set_rules(
            'name',
            'Intitulé du compte',
            'trim|required|min_length[2]|max_length[150]'
        );

        $this->form_validation->set_rules(
            'bank_name',
            'Banque',
            'trim|required|in_list[CRDB,BANCOBU,ECOBANK,KCB,BCB,BHB,INTERBANK]'
        );

        $this->form_validation->set_rules(
            'account_number',
            'Numéro de compte',
            'trim|required|min_length[4]|max_length[100]'
        );

        $this->form_validation->set_rules(
            'account_type',
            'Type de compte',
            'trim|required|in_list[courant,epargne,garantie,projet,credit]'
        );

        $this->form_validation->set_rules(
            'currency',
            'Devise',
            'trim|required|in_list[BIF,USD,EUR]'
        );

        $this->form_validation->set_rules(
            'opening_balance',
            'Solde initial',
            'trim|numeric|greater_than_equal_to[0]'
        );

        $this->form_validation->set_rules(
            'alert_threshold',
            'Seuil d’alerte',
            'trim|numeric|greater_than_equal_to[0]'
        );

        $this->form_validation->set_rules(
            'branch_name',
            'Agence bancaire',
            'trim|max_length[150]'
        );

        $this->form_validation->set_rules(
            'swift_code',
            'Code SWIFT',
            'trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'observation',
            'Observation',
            'trim|max_length[2000]'
        );

        /*
     * =========================================================
     * 3. MESSAGES DE VALIDATION
     * =========================================================
     */

        $this->form_validation->set_message(
            'required',
            'Le champ {field} est obligatoire.'
        );

        $this->form_validation->set_message(
            'min_length',
            'Le champ {field} doit contenir au moins {param} caractères.'
        );

        $this->form_validation->set_message(
            'max_length',
            'Le champ {field} ne doit pas dépasser {param} caractères.'
        );

        $this->form_validation->set_message(
            'numeric',
            'Le champ {field} doit contenir un montant valide.'
        );

        $this->form_validation->set_message(
            'greater_than_equal_to',
            'Le champ {field} ne peut pas contenir une valeur négative.'
        );

        $this->form_validation->set_message(
            'in_list',
            'La valeur sélectionnée pour {field} est invalide.'
        );

        /*
     * =========================================================
     * 4. ARRÊTER EN CAS D’ERREUR DE VALIDATION
     * =========================================================
     */

        if ($this->form_validation->run() === FALSE) {
            /*
         * Conserver temporairement les données saisies.
         */
            $this->session->set_flashdata(
                'bank_account_old_input',
                $this->input->post(NULL, TRUE)
            );

            $this->session->set_flashdata(
                'open_bank_account_modal',
                TRUE
            );

            $this->session->set_flashdata(
                'error',
                validation_errors('<div>', '</div>')
            );

            redirect('compte-banques');
            return;
        }

        /*
     * =========================================================
     * 5. RÉCUPÉRER ET NETTOYER LES DONNÉES
     * =========================================================
     */

        $name = trim(
            (string) $this->input->post(
                'name',
                TRUE
            )
        );

        $bankName = strtoupper(
            trim(
                (string) $this->input->post(
                    'bank_name',
                    TRUE
                )
            )
        );

        $accountNumber = trim(
            (string) $this->input->post(
                'account_number',
                TRUE
            )
        );

        $accountType = trim(
            (string) $this->input->post(
                'account_type',
                TRUE
            )
        );

        $currency = strtoupper(
            trim(
                (string) $this->input->post(
                    'currency',
                    TRUE
                )
            )
        );

        $openingBalance = (float) $this->input->post(
            'opening_balance',
            TRUE
        );

        $alertThreshold = (float) $this->input->post(
            'alert_threshold',
            TRUE
        );

        $branchName = trim(
            (string) $this->input->post(
                'branch_name',
                TRUE
            )
        );

        $swiftCode = strtoupper(
            trim(
                (string) $this->input->post(
                    'swift_code',
                    TRUE
                )
            )
        );

        $observation = trim(
            (string) $this->input->post(
                'observation',
                TRUE
            )
        );

        /*
     * Retirer les espaces inutiles du numéro de compte
     * pour éviter les doublons de forme :
     *
     * 0151 0010 02456
     * 0151001002456
     */
        $normalizedAccountNumber = preg_replace(
            '/[\s\-]+/',
            '',
            $accountNumber
        );

        if ($normalizedAccountNumber === '') {
            $this->session->set_flashdata(
                'error',
                'Le numéro de compte bancaire est invalide.'
            );

            $this->session->set_flashdata(
                'open_bank_account_modal',
                TRUE
            );

            redirect('compte-banques');
            return;
        }

        /*
     * Le code SWIFT est généralement enregistré
     * sans espaces.
     */
        if ($swiftCode !== '') {
            $swiftCode = preg_replace(
                '/\s+/',
                '',
                $swiftCode
            );
        }

        /*
     * =========================================================
     * 6. CONTRÔLES SUPPLÉMENTAIRES
     * =========================================================
     */

        if ($openingBalance < 0) {
            $this->session->set_flashdata(
                'error',
                'Le solde initial ne peut pas être négatif.'
            );

            $this->session->set_flashdata(
                'open_bank_account_modal',
                TRUE
            );

            redirect('compte-banques');
            return;
        }

        if ($alertThreshold < 0) {
            $this->session->set_flashdata(
                'error',
                'Le seuil d’alerte ne peut pas être négatif.'
            );

            $this->session->set_flashdata(
                'open_bank_account_modal',
                TRUE
            );

            redirect('compte-banques');
            return;
        }

        /*
     * =========================================================
     * 7. VÉRIFIER SI LE NUMÉRO DE COMPTE EXISTE DÉJÀ
     * =========================================================
     */

        $existingAccount = $this->db
            ->where(
                'account_number',
                $normalizedAccountNumber
            )
            ->get('tbl_finance_bank_account')
            ->row();

        if ($existingAccount) {
            $this->session->set_flashdata(
                'error',
                'Ce numéro de compte bancaire est déjà enregistré sous l’intitulé « '
                    . html_escape($existingAccount->name)
                    . ' ».'
            );

            $this->session->set_flashdata(
                'open_bank_account_modal',
                TRUE
            );

            redirect('compte-banques');
            return;
        }

        /*
     * Vérifier également l’intitulé dans la même banque
     * et dans la même devise.
     */
        $existingName = $this->db
            ->where('bank_name', $bankName)
            ->where('currency', $currency)
            ->where('name', $name)
            ->get('tbl_finance_bank_account')
            ->row();

        if ($existingName) {
            $this->session->set_flashdata(
                'error',
                'Un compte bancaire portant cet intitulé existe déjà pour cette banque et cette devise.'
            );

            $this->session->set_flashdata(
                'open_bank_account_modal',
                TRUE
            );

            redirect('compte-banques');
            return;
        }

        /*
     * =========================================================
     * 8. DÉMARRER UNE TRANSACTION
     * =========================================================
     */

        $this->db->trans_begin();

        try {
            /*
         * =====================================================
         * 9. GÉNÉRER LE CODE AUTOMATIQUEMENT
         * =====================================================
         *
         * Exemple :
         *
         * BAN-2026-001
         * BAN-2026-002
         * BAN-2026-003
         */

            $year = date('Y');

            $codePrefix = 'BAN-' . $year . '-';

            /*
         * Rechercher le dernier code de l’année en cours.
         */
            $lastBankAccount = $this->db
                ->select('code')
                ->from('tbl_finance_bank_account')
                ->like(
                    'code',
                    $codePrefix,
                    'after'
                )
                ->order_by('code', 'DESC')
                ->limit(1)
                ->get()
                ->row();

            $nextNumber = 1;

            if (
                $lastBankAccount
                && !empty($lastBankAccount->code)
            ) {
                /*
             * Exemple :
             * BAN-2026-007 devient 007.
             */
                $lastCodeParts = explode(
                    '-',
                    $lastBankAccount->code
                );

                $lastNumber = (int) end(
                    $lastCodeParts
                );

                $nextNumber = $lastNumber + 1;
            }

            $bankAccountCode = $codePrefix
                . str_pad(
                    (string) $nextNumber,
                    3,
                    '0',
                    STR_PAD_LEFT
                );

            /*
         * Sécurité supplémentaire :
         * vérifier que le code n’existe pas.
         */
            while (
                $this->db
                ->where('code', $bankAccountCode)
                ->count_all_results(
                    'tbl_finance_bank_account'
                ) > 0
            ) {
                $nextNumber++;

                $bankAccountCode = $codePrefix
                    . str_pad(
                        (string) $nextNumber,
                        3,
                        '0',
                        STR_PAD_LEFT
                    );
            }

            /*
         * =====================================================
         * 10. PRÉPARER LES DONNÉES
         * =====================================================
         */

            $currentUserId = $this->session->userdata(
                'user_id'
            );

            /*
         * Selon ton système, l’identifiant peut aussi être
         * stocké dans la session sous "id".
         */
            if (!$currentUserId) {
                $currentUserId = $this->session->userdata(
                    'id'
                );
            }

            $bankAccountData = [
                'code' => $bankAccountCode,

                'name' => $name,

                'bank_name' => $bankName,

                'account_number' =>
                $normalizedAccountNumber,

                'account_type' => $accountType,

                'currency' => $currency,

                /*
             * Lors de la création :
             * current_balance = opening_balance.
             */
                'opening_balance' =>
                $openingBalance,

                'current_balance' =>
                $openingBalance,

                'alert_threshold' =>
                $alertThreshold,

                'branch_name' =>
                $branchName !== ''
                    ? $branchName
                    : NULL,

                'swift_code' =>
                $swiftCode !== ''
                    ? $swiftCode
                    : NULL,

                'observation' =>
                $observation !== ''
                    ? $observation
                    : NULL,

                'status' => 'active',

                'created_by' =>
                $currentUserId ?: NULL,

                'updated_by' => NULL,

                'created_at' =>
                date('Y-m-d H:i:s'),

                'updated_at' => NULL,
            ];

            /*
         * =====================================================
         * 11. INSERTION DANS LA BASE
         * =====================================================
         */

            $inserted = $this->finance
                ->createBankAccount(
                    $bankAccountData
                );

            if (!$inserted) {
                throw new Exception(
                    'Le compte bancaire n’a pas pu être enregistré.'
                );
            }

            $bankAccountId = (int)
            $this->db->insert_id();

            if ($bankAccountId <= 0) {
                throw new Exception(
                    'L’identifiant du compte bancaire n’a pas été généré.'
                );
            }

            /*
         * =====================================================
         * 12. VÉRIFIER LA TRANSACTION
         * =====================================================
         */

            if ($this->db->trans_status() === FALSE) {
                throw new Exception(
                    'Une erreur de base de données est survenue pendant l’enregistrement.'
                );
            }

            /*
         * Valider définitivement les modifications.
         */
            $this->db->trans_commit();

            /*
         * =====================================================
         * 13. MESSAGE DE SUCCÈS
         * =====================================================
         */

            $bankLabels = [
                'CRDB' =>
                'CRDB Bank',

                'BANCOBU' =>
                'BANCOBU',

                'ECOBANK' =>
                'ECOBANK',

                'KCB' =>
                'KCB Bank',

                'BCB' =>
                'Banque de Crédit de Bujumbura',

                'BHB' =>
                'Banque de l’Habitat du Burundi',

                'INTERBANK' =>
                'Interbank Burundi',
            ];

            $displayBankName = isset(
                $bankLabels[$bankName]
            )
                ? $bankLabels[$bankName]
                : $bankName;

            $this->session->set_flashdata(
                'success',
                'Le compte bancaire '
                    . $bankAccountCode
                    . ' — '
                    . $name
                    . ' auprès de '
                    . $displayBankName
                    . ' a été créé avec succès.'
            );

            redirect('compte-banques');
            return;
        } catch (Throwable $exception) {
            /*
         * Annuler toutes les modifications en cas d’erreur.
         */
            if (
                $this->db->trans_status() === FALSE
                || $this->db->trans_depth() > 0
            ) {
                $this->db->trans_rollback();
            }

            log_message(
                'error',
                'Erreur création compte bancaire : '
                    . $exception->getMessage()
            );

            /*
         * Conserver les anciennes valeurs pour rouvrir
         * la modale sans perdre la saisie.
         */
            $this->session->set_flashdata(
                'bank_account_old_input',
                $this->input->post(NULL, TRUE)
            );

            $this->session->set_flashdata(
                'open_bank_account_modal',
                TRUE
            );

            $this->session->set_flashdata(
                'error',
                $exception->getMessage()
                    ?: 'Le compte bancaire n’a pas pu être enregistré.'
            );

            redirect('compte-banques');
            return;
        }
    }

    /**
     * Enregistre une opération bancaire :
     *
     * - encaissement ;
     * - décaissement ;
     * - transfert entre comptes bancaires.
     */
    public function bankOperationStore()
    {
        /*
        * =========================================================
        * 1. AUTORISER UNIQUEMENT POST
        * =========================================================
        */

        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $this->load->library('form_validation');

        /*
        * =========================================================
        * 2. RÈGLES DE VALIDATION
        * =========================================================
        */

        $this->form_validation->set_rules(
            'operation_type',
            'Type d’opération',
            'trim|required|in_list[encaissement,decaissement,transfert]'
        );

        $this->form_validation->set_rules(
            'operation_date',
            'Date de l’opération',
            'trim|required'
        );

        $this->form_validation->set_rules(
            'bank_account_id',
            'Compte bancaire concerné',
            'trim|required|integer'
        );

        $this->form_validation->set_rules(
            'amount',
            'Montant',
            'trim|required|numeric|greater_than[0]'
        );

        $this->form_validation->set_rules(
            'category',
            'Catégorie',
            'trim|max_length[100]'
        );

        $this->form_validation->set_rules(
            'third_party',
            'Tiers ou bénéficiaire',
            'trim|max_length[255]'
        );

        $this->form_validation->set_rules(
            'payment_method',
            'Mode d’opération',
            'trim|required|in_list[transfer,deposit,cheque,withdrawal]'
        );

        $this->form_validation->set_rules(
            'document_number',
            'Numéro de pièce',
            'trim|max_length[100]'
        );

        $this->form_validation->set_rules(
            'label',
            'Libellé de l’opération',
            'trim|required|max_length[2000]'
        );

        /*
        * Le compte destination est obligatoire
        * uniquement pour un transfert.
        */
        $operationType = trim(
            (string) $this->input->post(
                'operation_type',
                TRUE
            )
        );

        if ($operationType === 'transfert') {
            $this->form_validation->set_rules(
                'destination_bank_account_id',
                'Compte destination',
                'trim|required|integer'
            );
        }

        /*
        * =========================================================
        * 3. MESSAGES DE VALIDATION
        * =========================================================
        */

        $this->form_validation->set_message(
            'required',
            'Le champ {field} est obligatoire.'
        );

        $this->form_validation->set_message(
            'integer',
            'La valeur du champ {field} est invalide.'
        );

        $this->form_validation->set_message(
            'numeric',
            'Le champ {field} doit contenir un montant valide.'
        );

        $this->form_validation->set_message(
            'greater_than',
            'Le montant doit être supérieur à zéro.'
        );

        $this->form_validation->set_message(
            'in_list',
            'La valeur sélectionnée pour {field} est invalide.'
        );

        $this->form_validation->set_message(
            'max_length',
            'Le champ {field} ne doit pas dépasser {param} caractères.'
        );

        /*
        * =========================================================
        * 4. ARRÊTER EN CAS D’ERREUR
        * =========================================================
        */

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata(
                'bank_operation_old_input',
                $this->input->post(NULL, TRUE)
            );

            $this->session->set_flashdata(
                'open_bank_operation_modal',
                TRUE
            );

            $this->session->set_flashdata(
                'error',
                validation_errors('<div>', '</div>')
            );

            redirect('compte-banques');
            return;
        }

        /*
        * =========================================================
        * 5. RÉCUPÉRATION DES DONNÉES
        * =========================================================
        */

        $operationDate = trim(
            (string) $this->input->post(
                'operation_date',
                TRUE
            )
        );

        $bankAccountId = (int) $this->input->post(
            'bank_account_id',
            TRUE
        );

        $destinationBankAccountId = (int)
        $this->input->post(
            'destination_bank_account_id',
            TRUE
        );

        $amount = (float) $this->input->post(
            'amount',
            TRUE
        );

        $category = trim(
            (string) $this->input->post(
                'category',
                TRUE
            )
        );

        $thirdParty = trim(
            (string) $this->input->post(
                'third_party',
                TRUE
            )
        );

        $paymentMethod = trim(
            (string) $this->input->post(
                'payment_method',
                TRUE
            )
        );

        $documentNumber = trim(
            (string) $this->input->post(
                'document_number',
                TRUE
            )
        );

        $label = trim(
            (string) $this->input->post(
                'label',
                TRUE
            )
        );

        /*
        * =========================================================
        * 6. DÉTERMINER SOURCE ET DESTINATION
        * =========================================================
        */

        $sourceBankAccountId = NULL;
        $finalDestinationBankAccountId = NULL;

        /*
        * Encaissement :
        * le compte sélectionné reçoit l’argent.
        */
        if ($operationType === 'encaissement') {
            $finalDestinationBankAccountId =
                $bankAccountId;
        }

        /*
        * Décaissement :
        * le compte sélectionné fournit l’argent.
        */ elseif ($operationType === 'decaissement') {
            $sourceBankAccountId =
                $bankAccountId;
        }

        /*
        * Transfert :
        * le compte sélectionné est la source,
        * et destination_bank_account_id est la destination.
        */ elseif ($operationType === 'transfert') {
            $sourceBankAccountId =
                $bankAccountId;

            $finalDestinationBankAccountId =
                $destinationBankAccountId;

            if (
                $sourceBankAccountId
                === $finalDestinationBankAccountId
            ) {
                $this->session->set_flashdata(
                    'error',
                    'Le compte source et le compte destination doivent être différents.'
                );

                $this->session->set_flashdata(
                    'open_bank_operation_modal',
                    TRUE
                );

                redirect('compte-banques');
                return;
            }
        }

        /*
        * =========================================================
        * 7. VÉRIFIER LE COMPTE PRINCIPAL
        * =========================================================
        */

        $referenceAccountId =
            $sourceBankAccountId
            ?: $finalDestinationBankAccountId;

        $referenceAccount = $this->db
            ->where('id', $referenceAccountId)
            ->get('tbl_finance_bank_account')
            ->row();

        if (!$referenceAccount) {
            $this->session->set_flashdata(
                'error',
                'Le compte bancaire sélectionné est introuvable.'
            );

            $this->session->set_flashdata(
                'open_bank_operation_modal',
                TRUE
            );

            redirect('compte-banques');
            return;
        }

        if ($referenceAccount->status !== 'active') {
            $this->session->set_flashdata(
                'error',
                'Le compte bancaire sélectionné n’est pas actif.'
            );

            $this->session->set_flashdata(
                'open_bank_operation_modal',
                TRUE
            );

            redirect('compte-banques');
            return;
        }

        /*
        * =========================================================
        * 8. VÉRIFIER LE COMPTE DESTINATION DU TRANSFERT
        * =========================================================
        */

        if ($operationType === 'transfert') {
            $destinationAccount = $this->db
                ->where(
                    'id',
                    $finalDestinationBankAccountId
                )
                ->get('tbl_finance_bank_account')
                ->row();

            if (!$destinationAccount) {
                $this->session->set_flashdata(
                    'error',
                    'Le compte bancaire destination est introuvable.'
                );

                $this->session->set_flashdata(
                    'open_bank_operation_modal',
                    TRUE
                );

                redirect('compte-banques');
                return;
            }

            if ($destinationAccount->status !== 'active') {
                $this->session->set_flashdata(
                    'error',
                    'Le compte bancaire destination n’est pas actif.'
                );

                $this->session->set_flashdata(
                    'open_bank_operation_modal',
                    TRUE
                );

                redirect('compte-banques');
                return;
            }

            /*
            * Sans gestion de taux de change,
            * un transfert doit utiliser la même devise.
            */
            if (
                $referenceAccount->currency
                !== $destinationAccount->currency
            ) {
                $this->session->set_flashdata(
                    'error',
                    'Le transfert est impossible entre deux comptes de devises différentes. Ajoutez d’abord un système de taux de change.'
                );

                $this->session->set_flashdata(
                    'open_bank_operation_modal',
                    TRUE
                );

                redirect('compte-banques');
                return;
            }
        }

        /*
        * =========================================================
        * 9. VÉRIFIER LE SOLDE DISPONIBLE
        * =========================================================
        */

        if (
            in_array(
                $operationType,
                ['decaissement', 'transfert'],
                TRUE
            )
            && (float) $referenceAccount->current_balance
            < $amount
        ) {
            $this->session->set_flashdata(
                'error',
                'Solde insuffisant. Le compte '
                    . $referenceAccount->name
                    . ' dispose seulement de '
                    . number_format(
                        (float) $referenceAccount
                            ->current_balance,
                        2,
                        ',',
                        ' '
                    )
                    . ' '
                    . $referenceAccount->currency
                    . '.'
            );

            $this->session->set_flashdata(
                'open_bank_operation_modal',
                TRUE
            );

            redirect('compte-banques');
            return;
        }

        /*
        * =========================================================
        * 10. UPLOAD FACULTATIF
        * =========================================================
        */

        $attachmentName = NULL;

        if (
            isset($_FILES['attachment'])
            && !empty($_FILES['attachment']['name'])
        ) {
            $uploadPath =
                FCPATH
                . 'uploads/finance/bank_operations/';

            if (!is_dir($uploadPath)) {
                mkdir(
                    $uploadPath,
                    0755,
                    TRUE
                );
            }

            $config = [
                'upload_path' =>
                $uploadPath,

                'allowed_types' =>
                'pdf|jpg|jpeg|png|doc|docx|xls|xlsx',

                'max_size' =>
                5120,

                'encrypt_name' =>
                TRUE,

                'remove_spaces' =>
                TRUE,
            ];

            $this->load->library(
                'upload',
                $config
            );

            if (
                !$this->upload->do_upload(
                    'attachment'
                )
            ) {
                $this->session->set_flashdata(
                    'error',
                    strip_tags(
                        $this->upload
                            ->display_errors()
                    )
                );

                $this->session->set_flashdata(
                    'open_bank_operation_modal',
                    TRUE
                );

                redirect('compte-banques');
                return;
            }

            $uploadedFile =
                $this->upload->data();

            $attachmentName =
                $uploadedFile['file_name'];
        }

        /*
        * =========================================================
        * 11. IDENTIFIANT UTILISATEUR
        * =========================================================
        */

        $currentUserId =
            $this->session->userdata(
                'user_id'
            );

        if (!$currentUserId) {
            $currentUserId =
                $this->session->userdata(
                    'id'
                );
        }

        /*
        * =========================================================
        * 12. PRÉPARER LES DONNÉES
        * =========================================================
        */

        $operationData = [
            /*
         * Référence générée par le modèle.
         */
            'operation_type' =>
            $operationType,

            'operation_date' =>
            $operationDate,

            'source_bank_account_id' =>
            $sourceBankAccountId,

            'destination_bank_account_id' =>
            $finalDestinationBankAccountId,

            'amount' =>
            $amount,

            'currency' =>
            $referenceAccount->currency,

            'category' =>
            $category !== ''
                ? $category
                : NULL,

            'third_party' =>
            $thirdParty !== ''
                ? $thirdParty
                : NULL,

            'payment_method' =>
            $paymentMethod,

            'document_number' =>
            $documentNumber !== ''
                ? $documentNumber
                : NULL,

            'attachment' =>
            $attachmentName,

            'label' =>
            $label,

            'status' =>
            'validated',

            'created_by' =>
            $currentUserId ?: NULL,

            'validated_by' =>
            $currentUserId ?: NULL,

            'created_at' =>
            date('Y-m-d H:i:s'),
        ];

        /*
        * =========================================================
        * 13. ENREGISTRER VIA LE MODÈLE
        * =========================================================
        */

        $result =
            $this->finance
            ->createBankOperation(
                $operationData
            );

        if (
            empty($result['status'])
        ) {
            if ($attachmentName) {
                @unlink(
                    FCPATH
                        . 'uploads/finance/bank_operations/'
                        . $attachmentName
                );
            }

            $this->session->set_flashdata(
                'error',
                $result['message']
                    ?? 'L’opération bancaire n’a pas pu être enregistrée.'
            );

            $this->session->set_flashdata(
                'open_bank_operation_modal',
                TRUE
            );

            redirect('compte-banques');
            return;
        }

        /*
        * =========================================================
        * 14. MESSAGE DE SUCCÈS
        * =========================================================
        */

        $operationLabels = [
            'encaissement' =>
            'L’encaissement bancaire',

            'decaissement' =>
            'Le décaissement bancaire',

            'transfert' =>
            'Le transfert bancaire',
        ];

        $this->session->set_flashdata(
            'success',
            $operationLabels[$operationType]
                . ' '
                . $result['reference']
                . ' a été enregistré avec succès.'
        );

        redirect('compte-banques');
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

    public function rapprochement()
    {
        /*
     * Vérification de la connexion.
     */
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        /*
     * Tableau principal envoyé aux vues.
     */
        $data = [];

        $data['title'] = 'Rapprochement bancaire';

        /*
     * Récupération des comptes bancaires actifs.
     */
        $data['allBankAccounts'] =
            $this->finance
            ->getActiveBankAccountsForReconciliation();

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
            'v1/components/modules/finance/rapprochement',
            $data
        );

        $this->load->view(
            'v1/components/layout/footer',
            $data
        );
    }

    public function prevision()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Prévisions de trésorerie';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/finance/prevision');
        $this->load->view('v1/components/layout/footer');
    }
}