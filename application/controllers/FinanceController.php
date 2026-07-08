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
}