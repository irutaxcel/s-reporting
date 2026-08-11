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
        * DEMANDES D’ACHAT PRÊTES AU PAIEMENT
        * =========================================================
        */

        $data['payablePurchaseRequests'] =
            $this->finance
            ->getPayablePurchaseRequests();

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
        /*
        * =========================================================
        * AFFICHAGE DES ERREURS EN DÉVELOPPEMENT
        * =========================================================
        *
        * À retirer ou désactiver en production.
        */
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        try {

            /*
            * =========================================================
            * 1. AUTORISER UNIQUEMENT LES REQUÊTES POST
            * =========================================================
            */

            if ($this->input->method(TRUE) !== 'POST') {
                throw new RuntimeException(
                    'La méthode HTTP utilisée est invalide.'
                );
            }

            /*
            * =========================================================
            * 2. VÉRIFIER L’AUTHENTIFICATION
            * =========================================================
            */

            $currentUserId = (int) $this->session->userdata(
                'user_id'
            );

            if ($currentUserId <= 0) {
                redirect('sign-in');
                return;
            }

            /*
            * =========================================================
            * 3. CHARGER LA VALIDATION
            * =========================================================
            */

            $this->load->library(
                'form_validation'
            );

            /*
            * =========================================================
            * 4. RÉCUPÉRER LE TYPE D’OPÉRATION
            * =========================================================
            */

            $operationType = trim(
                (string) $this->input->post(
                    'operation_type',
                    TRUE
                )
            );

            /*
            * =========================================================
            * 5. RÈGLES GÉNÉRALES
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
            * =========================================================
            * 6. RÈGLES PROPRES AU DÉCAISSEMENT
            * =========================================================
            */

            if ($operationType === 'decaissement') {

                $this->form_validation->set_rules(
                    'purchase_request_id',
                    'Demande d’achat',
                    'trim|required|integer'
                );

                $this->form_validation->set_rules(
                    'payment_voucher_id',
                    'Bon de paiement',
                    'trim|required|integer'
                );

                $this->form_validation->set_rules(
                    'expense_justification',
                    'Justification de la dépense',
                    'trim|required'
                );
            }

            /*
            * =========================================================
            * 7. RÈGLES PROPRES À L’APPROVISIONNEMENT
            * =========================================================
            */

            if ($operationType === 'approvisionnement') {

                $this->form_validation->set_rules(
                    'destination_cashbox_id',
                    'Caisse destination',
                    'trim|required|integer'
                );
            }

            /*
            * =========================================================
            * 8. MESSAGES DE VALIDATION
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

            $this->form_validation->set_message(
                'max_length',
                'Le champ {field} dépasse la longueur autorisée.'
            );

            /*
            * =========================================================
            * 9. EXÉCUTER LA VALIDATION
            * =========================================================
            */

            if ($this->form_validation->run() === FALSE) {

                $validationMessage = strip_tags(
                    validation_errors(
                        '',
                        "\n"
                    )
                );

                $this->session->set_flashdata(
                    'error',
                    $validationMessage
                );

                $this->session->set_flashdata(
                    'operation_old_input',
                    $this->input->post(
                        NULL,
                        TRUE
                    )
                );

                redirect('caisse');
                return;
            }

            /*
            * =========================================================
            * 10. RÉCUPÉRER LES DONNÉES VALIDÉES
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

            $destinationCashboxId =
                (int) $this->input->post(
                    'destination_cashbox_id',
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

            $purchaseRequestId =
                (int) $this->input->post(
                    'purchase_request_id',
                    TRUE
                );

            $paymentVoucherId =
                (int) $this->input->post(
                    'payment_voucher_id',
                    TRUE
                );

            $purchaseRequestReference = trim(
                (string) $this->input->post(
                    'purchase_request_reference',
                    TRUE
                )
            );

            $paymentVoucherReference = trim(
                (string) $this->input->post(
                    'payment_voucher_reference',
                    TRUE
                )
            );

            $expenseJustification = trim(
                (string) $this->input->post(
                    'expense_justification',
                    TRUE
                )
            );

            /*
            * =========================================================
            * 11. VÉRIFIER LA DATE
            * =========================================================
            */

            $dateObject = DateTime::createFromFormat(
                'Y-m-d',
                $operationDate
            );

            if (
                !$dateObject ||
                $dateObject->format('Y-m-d') !== $operationDate
            ) {
                throw new RuntimeException(
                    'La date de l’opération est invalide.'
                );
            }

            /*
            * =========================================================
            * 12. VÉRIFICATIONS MÉTIER
            * =========================================================
            */

            if ($cashboxId <= 0) {
                throw new RuntimeException(
                    'Veuillez sélectionner une caisse.'
                );
            }

            if ($amount <= 0) {
                throw new RuntimeException(
                    'Le montant doit être supérieur à zéro.'
                );
            }

            if (
                $operationType === 'approvisionnement' &&
                $destinationCashboxId <= 0
            ) {
                throw new RuntimeException(
                    'Veuillez sélectionner la caisse destination.'
                );
            }

            if (
                $operationType === 'approvisionnement' &&
                $cashboxId === $destinationCashboxId
            ) {
                throw new RuntimeException(
                    'La caisse source et la caisse destination doivent être différentes.'
                );
            }

            if (
                $operationType === 'decaissement' &&
                $purchaseRequestId <= 0
            ) {
                throw new RuntimeException(
                    'La demande d’achat est obligatoire pour un décaissement.'
                );
            }

            if (
                $operationType === 'decaissement' &&
                $paymentVoucherId <= 0
            ) {
                throw new RuntimeException(
                    'Le bon de paiement est obligatoire pour un décaissement.'
                );
            }

            /*
            * =========================================================
            * 13. DÉTERMINER SOURCE ET DESTINATION
            * =========================================================
            */

            $sourceCashboxId = null;
            $finalDestinationCashboxId = null;

            /*
            * Encaissement :
            * la caisse sélectionnée reçoit l’argent.
            */
            if ($operationType === 'encaissement') {
                $finalDestinationCashboxId = $cashboxId;
            }

            /*
            * Décaissement :
            * la caisse sélectionnée est débitée.
            */
            if ($operationType === 'decaissement') {
                $sourceCashboxId = $cashboxId;
            }

            /*
            * Approvisionnement :
            * une caisse source est débitée,
            * une caisse destination est créditée.
            */
            if ($operationType === 'approvisionnement') {
                $sourceCashboxId = $cashboxId;
                $finalDestinationCashboxId =
                    $destinationCashboxId;
            }

            /*
            * =========================================================
            * 14. RÉCUPÉRER LA DEVISE
            * =========================================================
            */

            $cashbox = $this->finance
                ->getCashboxById(
                    $cashboxId
                );

            if (!$cashbox) {
                throw new RuntimeException(
                    'La caisse sélectionnée est introuvable.'
                );
            }

            $currency = !empty($cashbox->devise)
                ? $cashbox->devise
                : 'BIF';

            /*
            * =========================================================
            * 15. VÉRIFIER LE BON DE PAIEMENT
            * =========================================================
            */

            if ($operationType === 'decaissement') {

                $paymentVoucher =
                    $this->finance
                    ->getPurchasePaymentVoucherById(
                        $paymentVoucherId
                    );

                if (!$paymentVoucher) {
                    throw new RuntimeException(
                        'Le bon de paiement sélectionné est introuvable.'
                    );
                }

                if (
                    (int) $paymentVoucher->request_id
                    !== $purchaseRequestId
                ) {
                    throw new RuntimeException(
                        'Le bon de paiement ne correspond pas à la demande d’achat.'
                    );
                }

                if (
                    $paymentVoucher->payment_status
                    !== 'effectue'
                ) {
                    throw new RuntimeException(
                        'Le bon de paiement sélectionné n’est pas encore effectué.'
                    );
                }

                /*
                * Reprendre le montant réel depuis la base.
                */
                $amount =
                    (float) $paymentVoucher->amount_paid;

                /*
                * Reprendre les vraies références.
                */
                $paymentVoucherReference =
                    (string) $paymentVoucher->payment_number;

                if (
                    $expenseJustification === '' &&
                    !empty($paymentVoucher->summary)
                ) {
                    $expenseJustification =
                        (string) $paymentVoucher->summary;
                }
            }

            /*
            * =========================================================
            * 16. TÉLÉVERSEMENT DE LA PIÈCE
            * =========================================================
            */

            $attachmentName = null;

            if (
                isset($_FILES['attachment']) &&
                !empty($_FILES['attachment']['name'])
            ) {

                $uploadPath =
                    FCPATH
                    . 'uploads/finance/cashbox_operations/';

                if (!is_dir($uploadPath)) {

                    if (
                        !mkdir(
                            $uploadPath,
                            0755,
                            true
                        ) &&
                        !is_dir($uploadPath)
                    ) {
                        throw new RuntimeException(
                            'Impossible de créer le dossier des pièces justificatives.'
                        );
                    }
                }

                $uploadConfig = [
                    'upload_path'   => $uploadPath,
                    'allowed_types' =>
                    'pdf|jpg|jpeg|png|doc|docx|xls|xlsx',
                    'max_size'      => 5120,
                    'encrypt_name'  => TRUE,
                    'remove_spaces' => TRUE,
                ];

                $this->load->library(
                    'upload',
                    $uploadConfig
                );

                $this->upload->initialize(
                    $uploadConfig
                );

                if (
                    !$this->upload->do_upload(
                        'attachment'
                    )
                ) {
                    throw new RuntimeException(
                        strip_tags(
                            $this->upload->display_errors(
                                '',
                                ''
                            )
                        )
                    );
                }

                $uploadData =
                    $this->upload->data();

                $attachmentName =
                    $uploadData['file_name'];
            }

            /*
            * =========================================================
            * 17. GÉNÉRER LE LIBELLÉ
            * =========================================================
            */

            $operationLabels = [
                'encaissement' =>
                'Encaissement',

                'decaissement' =>
                'Décaissement',

                'approvisionnement' =>
                'Approvisionnement',
            ];

            $automaticLabel =
                $operationLabels[$operationType]
                ?? 'Opération de caisse';

            if ($category !== '') {
                $automaticLabel .=
                    ' - ' . $category;
            }

            if ($thirdParty !== '') {
                $automaticLabel .=
                    ' - Bénéficiaire / Provenance : '
                    . $thirdParty;
            }

            if ($expenseJustification !== '') {
                $automaticLabel .=
                    ' - Justification : '
                    . $expenseJustification;
            }

            /*
            * =========================================================
            * 18. PRÉPARER LES DONNÉES
            * =========================================================
            */

            $operationData = [
                'operation_type' =>
                $operationType,

                'operation_date' =>
                $operationDate,

                'source_cashbox_id' =>
                $sourceCashboxId,

                'destination_cashbox_id' =>
                $finalDestinationCashboxId,

                'purchase_request_id' =>
                $purchaseRequestId > 0
                    ? $purchaseRequestId
                    : null,

                'payment_voucher_id' =>
                $paymentVoucherId > 0
                    ? $paymentVoucherId
                    : null,

                'purchase_request_reference' =>
                $purchaseRequestReference !== ''
                    ? $purchaseRequestReference
                    : null,

                'payment_voucher_reference' =>
                $paymentVoucherReference !== ''
                    ? $paymentVoucherReference
                    : null,

                'expense_justification' =>
                $expenseJustification !== ''
                    ? $expenseJustification
                    : null,

                'amount' =>
                $amount,

                'currency' =>
                $currency,

                'category' =>
                $category !== ''
                    ? $category
                    : null,

                'third_party' =>
                $thirdParty !== ''
                    ? $thirdParty
                    : null,

                'payment_method' =>
                $paymentMethod,

                'document_number' =>
                $documentNumber !== ''
                    ? $documentNumber
                    : null,

                'attachment' =>
                $attachmentName,

                'label' =>
                $automaticLabel,

                'observation' =>
                $observation !== ''
                    ? $observation
                    : null,

                'status' =>
                'validated',

                'created_by' =>
                $currentUserId,

                'validated_by' =>
                $currentUserId,

                'created_at' =>
                date('Y-m-d H:i:s'),
            ];

            /*
            * =========================================================
            * 19. ENREGISTRER AVEC LE MODÈLE
            * =========================================================
            */

            $result = $this->finance
                ->createCashboxOperation(
                    $operationData
                );

            if (
                !is_array($result) ||
                empty($result['status'])
            ) {

                $modelMessage =
                    is_array($result) &&
                    !empty($result['message'])
                    ? $result['message']
                    : 'L’opération n’a pas pu être enregistrée.';

                throw new RuntimeException(
                    $modelMessage
                );
            }

            /*
            * =========================================================
            * 20. MESSAGE DE SUCCÈS
            * =========================================================
            */

            $reference =
                !empty($result['reference'])
                ? $result['reference']
                : '';

            $this->session->set_flashdata(
                'success',
                trim(
                    $automaticLabel
                        . ' '
                        . $reference
                        . ' enregistré avec succès.'
                )
            );

            redirect('caisse');
            return;
        } catch (Throwable $exception) {

            /*
            * =========================================================
            * GESTION CENTRALE DES ERREURS
            * =========================================================
            */

            $technicalMessage =
                $exception->getMessage()
                . ' | Fichier : '
                . $exception->getFile()
                . ' | Ligne : '
                . $exception->getLine();

            /*
            * Enregistrer dans application/logs.
            */
            log_message(
                'error',
                'cashboxOperationStore : '
                    . $technicalMessage
            );

            /*
            * Conserver les anciennes valeurs.
            */
            $this->session->set_flashdata(
                'operation_old_input',
                $this->input->post(
                    NULL,
                    TRUE
                )
            );

            /*
            * Afficher une erreur compréhensible.
            *
            * En développement, on affiche aussi
            * le fichier et la ligne.
            */
            if (
                defined('ENVIRONMENT') &&
                ENVIRONMENT === 'development'
            ) {
                $visibleMessage =
                    $technicalMessage;
            } else {
                $visibleMessage =
                    $exception->getMessage();
            }

            $this->session->set_flashdata(
                'error',
                $visibleMessage
            );

            redirect('caisse');
            return;
        }
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

        $data['title'] = 'Livre de Caisse';
        $cashboxId     = (int) $id;

        /* -------------------------------------------------
        * CAISSE CONCERNÉE
        * ------------------------------------------------- */
        $data['cashbox'] = $this->finance->getCashboxById($cashboxId);

        if (!$data['cashbox']) {
            show_404();
            return;
        }

        /* -------------------------------------------------
     * PÉRIODE DU LIVRE
     * ------------------------------------------------- */
        $dateFrom = $this->input->get('livre_date_from');
        $dateTo   = $this->input->get('livre_date_to');

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
        * FILTRES
        * ------------------------------------------------- */
        $filters = array(
            'search' => trim((string) $this->input->get('livre_search')),
            'type'   => (string) $this->input->get('livre_type'),
        );

        $data['livreDateFrom'] = $dateFrom;
        $data['livreDateTo']   = $dateTo;
        $data['livreFilters']  = $filters;

        /* -------------------------------------------------
        * LIGNES + STATISTIQUES
        * ------------------------------------------------- */
        $data['livreRows'] = $this->finance
            ->getLivreOperations($cashboxId, $dateFrom, $dateTo, $filters);

        $totalIn = 0;
        $totalOut = 0;
        $countIn = 0;
        $countOut = 0;
        foreach ($data['livreRows'] as $row) {
            if ($row->livre_direction === 'entree') {
                $totalIn += (float) $row->amount;
                $countIn++;
            } else {
                $totalOut += (float) $row->amount;
                $countOut++;
            }
        }

        $data['livreStats'] = array(
            'total_in'      => $totalIn,
            'total_out'     => $totalOut,
            'count_in'      => $countIn,
            'count_out'     => $countOut,
            'count_total'   => count($data['livreRows']),
            'final_balance' => (float) $data['cashbox']->current_balance,
        );

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/finance/finance_cashbox', $data);
        $this->load->view('v1/components/layout/footer');
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
            'operation_type' =>
            $operationType,

            'operation_date' =>
            $operationDate,

            'source_cashbox_id' =>
            $sourceCashboxId,

            'destination_cashbox_id' =>
            $destinationCashboxId,

            'purchase_request_id' =>
            $purchaseRequestId > 0
                ? $purchaseRequestId
                : null,

            'payment_voucher_id' =>
            $paymentVoucherId > 0
                ? $paymentVoucherId
                : null,

            'purchase_request_reference' =>
            $purchaseRequestReference !== ''
                ? $purchaseRequestReference
                : null,

            'payment_voucher_reference' =>
            $paymentVoucherReference !== ''
                ? $paymentVoucherReference
                : null,

            'expense_justification' =>
            $expenseJustification !== ''
                ? $expenseJustification
                : null,

            'amount' =>
            $amount,

            'currency' =>
            $currency,

            'category' =>
            $category !== ''
                ? $category
                : null,

            'third_party' =>
            $thirdParty !== ''
                ? $thirdParty
                : null,

            'payment_method' =>
            $paymentMethod,

            'document_number' =>
            $documentNumber !== ''
                ? $documentNumber
                : null,

            'attachment' =>
            $attachmentName,

            'label' =>
            $automaticLabel,

            'observation' =>
            $observation !== ''
                ? $observation
                : null,

            'status' =>
            'validated',

            'created_by' =>
            $currentUserId,

            'validated_by' =>
            $currentUserId,

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
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data = [];

        $data['title'] = 'Rapprochement bancaire';

        /*
        * Comptes bancaires.
        */
        $data['allBankAccounts'] =
            $this->finance
            ->getAllActiveBankAccounts();

        /*
        * Sessions pouvant être analysées.
        */
        $data['reconciliations'] =
            $this->finance
            ->getReconciliationsAvailableForAnalysis();

        /*
        * Statistiques.
        */
        $data['reconciliationStatistics'] =
            $this->finance
            ->getBankReconciliationMainStatistics();

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
            'v1/components/layout/footer'
        );
    }

    /**
     * Démarre une nouvelle session de rapprochement bancaire.
     */
    public function reconciliationStore()
    {
        /*
        * Vérifier l'authentification.
        */
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        /*
        * Accepter uniquement POST.
        */
        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $this->load->library('form_validation');

        /*
        * Règles de validation.
        */
        $this->form_validation->set_rules(
            'bank_account_id',
            'Compte bancaire',
            'trim|required|integer'
        );

        $this->form_validation->set_rules(
            'period_start',
            'Date de début',
            'trim|required'
        );

        $this->form_validation->set_rules(
            'period_end',
            'Date de fin',
            'trim|required'
        );

        $this->form_validation->set_rules(
            'statement_opening_balance',
            'Solde initial du relevé',
            'trim|required|numeric'
        );

        $this->form_validation->set_rules(
            'statement_closing_balance',
            'Solde final du relevé',
            'trim|required|numeric'
        );

        $this->form_validation->set_rules(
            'observation',
            'Observation',
            'trim|max_length[1000]'
        );

        /*
        * Messages personnalisés.
        */
        $this->form_validation->set_message(
            'required',
            'Le champ {field} est obligatoire.'
        );

        $this->form_validation->set_message(
            'integer',
            'Le champ {field} est invalide.'
        );

        $this->form_validation->set_message(
            'numeric',
            'Le champ {field} doit contenir un montant valide.'
        );

        $this->form_validation->set_message(
            'max_length',
            'Le champ {field} dépasse la longueur autorisée.'
        );

        /*
        * Validation échouée.
        */
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata(
                'error',
                validation_errors('<div>', '</div>')
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Récupération des données.
        */
        $bankAccountId = (int) $this->input->post(
            'bank_account_id',
            true
        );

        $periodStart = trim(
            (string) $this->input->post(
                'period_start',
                true
            )
        );

        $periodEnd = trim(
            (string) $this->input->post(
                'period_end',
                true
            )
        );

        $statementOpeningBalance = (float) $this->input->post(
            'statement_opening_balance',
            true
        );

        $statementClosingBalance = (float) $this->input->post(
            'statement_closing_balance',
            true
        );

        $observation = trim(
            (string) $this->input->post(
                'observation',
                true
            )
        );

        /*
        * Vérification du format des dates.
        */
        $startDateObject = DateTime::createFromFormat(
            'Y-m-d',
            $periodStart
        );

        $endDateObject = DateTime::createFromFormat(
            'Y-m-d',
            $periodEnd
        );

        if (
            !$startDateObject
            || $startDateObject->format('Y-m-d') !== $periodStart
            || !$endDateObject
            || $endDateObject->format('Y-m-d') !== $periodEnd
        ) {
            $this->session->set_flashdata(
                'error',
                'La période du rapprochement est invalide.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * La date de début ne peut pas être supérieure
        * à la date de fin.
        */
        if ($periodStart > $periodEnd) {
            $this->session->set_flashdata(
                'error',
                'La date de début doit être antérieure ou égale à la date de fin.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Vérifier les montants.
        *
        * Un compte bancaire peut éventuellement avoir un solde négatif.
        * On n'applique donc pas greater_than_equal_to[0]
        * au niveau métier.
        */
        if (
            !is_finite($statementOpeningBalance)
            || !is_finite($statementClosingBalance)
        ) {
            $this->session->set_flashdata(
                'error',
                'Les soldes du relevé sont invalides.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Récupérer le compte depuis la base.
        *
        * Ne jamais faire confiance à :
        * - currency envoyé par le formulaire ;
        * - system_balance envoyé par le formulaire.
        */
        $bankAccount =
            $this->finance->getActiveBankAccountById(
                $bankAccountId
            );

        if (!$bankAccount) {
            $this->session->set_flashdata(
                'error',
                'Le compte bancaire sélectionné est introuvable ou inactif.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Vérifier l'existence d'une session identique.
        */
        $alreadyExists =
            $this->finance
            ->bankReconciliationAlreadyExists(
                $bankAccountId,
                $periodStart,
                $periodEnd
            );

        if ($alreadyExists) {
            $this->session->set_flashdata(
                'error',
                'Un rapprochement est déjà ouvert pour ce compte et cette période.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Calculer les vrais soldes système depuis la base.
        */
        $systemOpeningBalance =
            $this->finance
            ->getBankAccountSystemBalanceAtDate(
                $bankAccountId,
                $periodStart
            );

        $systemClosingBalance =
            $this->finance
            ->getBankAccountSystemClosingBalance(
                $bankAccountId,
                $periodEnd
            );

        /*
        * Écart initial.
        *
        * Formule :
        * solde final banque - solde final système
        */
        $differenceBeforeAdjustment =
            $statementClosingBalance
            - $systemClosingBalance;

        /*
        * Au démarrage, aucun ajustement n'a encore été effectué.
        */
        $adjustmentAmount = 0;

        $differenceAfterAdjustment =
            $differenceBeforeAdjustment;

        /*
        * Préparation des données.
        */
        $reconciliationData = [
            'bank_account_id' =>
            $bankAccountId,

            'period_start' =>
            $periodStart,

            'period_end' =>
            $periodEnd,

            /*
            * La devise vient du compte bancaire,
            * et non du champ caché du formulaire.
            */
            'currency' =>
            $bankAccount->currency,

            'statement_opening_balance' =>
            $statementOpeningBalance,

            'statement_closing_balance' =>
            $statementClosingBalance,

            'system_opening_balance' =>
            $systemOpeningBalance,

            'system_closing_balance' =>
            $systemClosingBalance,

            'difference_before_adjustment' =>
            $differenceBeforeAdjustment,

            'adjustment_amount' =>
            $adjustmentAmount,

            'difference_after_adjustment' =>
            $differenceAfterAdjustment,

            'matched_operations_count' =>
            0,

            'unmatched_operations_count' =>
            0,

            'anomalies_count' =>
            0,

            /*
            * Utiliser la session plutôt que le champ caché.
            */
            'responsible_user_id' =>
            (int) $this->session->userdata('user_id'),

            'validated_by' =>
            null,

            'observation' =>
            $observation !== ''
                ? $observation
                : null,

            'validation_observation' =>
            null,

            'status' =>
            'in_progress',

            'started_at' =>
            date('Y-m-d H:i:s'),

            'completed_at' =>
            null,

            'validated_at' =>
            null,

            'created_at' =>
            date('Y-m-d H:i:s'),

            'updated_at' =>
            null,
        ];

        /*
        * Enregistrement dans le modèle.
        */
        $result =
            $this->finance
            ->createBankReconciliation(
                $reconciliationData
            );

        if (!$result['status']) {
            $this->session->set_flashdata(
                'error',
                $result['message']
                    ?? 'Le rapprochement bancaire n’a pas pu être démarré.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Message de succès.
        */
        $this->session->set_flashdata(
            'success',
            'Le rapprochement bancaire '
                . $result['reference']
                . ' a été démarré avec succès.'
        );

        redirect('rapprochement');
    }

    /**
     * Importe et enregistre un relevé bancaire.
     */
    public function bankStatementImportStore()
    {
        /*
     * Vérifier que l'utilisateur est connecté.
     */
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        /*
        * Accepter uniquement les requêtes POST.
        */
        if ($this->input->method(true) !== 'POST') {
            show_404();
            return;
        }

        $this->load->library('form_validation');

        /*
        * Règles de validation.
        */
        $this->form_validation->set_rules(
            'bank_account_id',
            'Compte bancaire',
            'trim|required|integer'
        );

        $this->form_validation->set_rules(
            'statement_date',
            'Date du relevé',
            'trim|required'
        );

        $this->form_validation->set_rules(
            'period_start',
            'Période de début',
            'trim|required'
        );

        $this->form_validation->set_rules(
            'period_end',
            'Période de fin',
            'trim|required'
        );

        $this->form_validation->set_rules(
            'opening_balance',
            'Solde initial du relevé',
            'trim|numeric'
        );

        $this->form_validation->set_rules(
            'closing_balance',
            'Solde final du relevé',
            'trim|required|numeric'
        );

        $this->form_validation->set_rules(
            'observation',
            'Observation',
            'trim|max_length[1000]'
        );

        /*
        * Messages de validation.
        */
        $this->form_validation->set_message(
            'required',
            'Le champ {field} est obligatoire.'
        );

        $this->form_validation->set_message(
            'integer',
            'Le champ {field} est invalide.'
        );

        $this->form_validation->set_message(
            'numeric',
            'Le champ {field} doit contenir un montant valide.'
        );

        $this->form_validation->set_message(
            'max_length',
            'Le champ {field} dépasse la longueur autorisée.'
        );

        /*
        * Validation du formulaire.
        */
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata(
                'error',
                validation_errors('<div>', '</div>')
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Vérifier que le fichier est présent.
        */
        if (
            !isset($_FILES['statement_file'])
            || empty($_FILES['statement_file']['name'])
        ) {
            $this->session->set_flashdata(
                'error',
                'Le fichier du relevé bancaire est obligatoire.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Récupération des données du formulaire.
        */
        $bankAccountId = (int) $this->input->post(
            'bank_account_id',
            true
        );

        $statementDate = trim(
            (string) $this->input->post(
                'statement_date',
                true
            )
        );

        $periodStart = trim(
            (string) $this->input->post(
                'period_start',
                true
            )
        );

        $periodEnd = trim(
            (string) $this->input->post(
                'period_end',
                true
            )
        );

        $openingBalanceInput =
            $this->input->post(
                'opening_balance',
                true
            );

        $closingBalanceInput =
            $this->input->post(
                'closing_balance',
                true
            );

        $openingBalance =
            $openingBalanceInput === ''
            || $openingBalanceInput === null
            ? 0
            : (float) $openingBalanceInput;

        $closingBalance =
            (float) $closingBalanceInput;

        $observation = trim(
            (string) $this->input->post(
                'observation',
                true
            )
        );

        /*
        * Vérifier les formats de dates.
        */
        if (
            !$this->isValidDate($statementDate)
            || !$this->isValidDate($periodStart)
            || !$this->isValidDate($periodEnd)
        ) {
            $this->session->set_flashdata(
                'error',
                'Une ou plusieurs dates du relevé sont invalides.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Vérifier la cohérence de la période.
        */
        if ($periodStart > $periodEnd) {
            $this->session->set_flashdata(
                'error',
                'La période de début doit être antérieure ou égale à la période de fin.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * La date du relevé ne devrait normalement pas
        * être antérieure à la fin de sa période.
        */
        if ($statementDate < $periodEnd) {
            $this->session->set_flashdata(
                'error',
                'La date du relevé ne peut pas être antérieure à la fin de la période.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Vérifier le compte bancaire depuis la base.
        */
        $bankAccount =
            $this->finance
            ->getActiveBankAccountById(
                $bankAccountId
            );

        if (!$bankAccount) {
            $this->session->set_flashdata(
                'error',
                'Le compte bancaire sélectionné est introuvable ou inactif.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Vérifier si un relevé existe déjà.
        */
        $statementExists =
            $this->finance
            ->bankStatementAlreadyExists(
                $bankAccountId,
                $periodStart,
                $periodEnd
            );

        if ($statementExists) {
            $this->session->set_flashdata(
                'error',
                'Un relevé bancaire existe déjà pour ce compte et cette période.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Préparer le dossier d'upload.
        */
        $uploadPath =
            FCPATH
            . 'uploads/finance/bank_statements/';

        if (!is_dir($uploadPath)) {
            $directoryCreated = mkdir(
                $uploadPath,
                0755,
                true
            );

            if (!$directoryCreated && !is_dir($uploadPath)) {
                $this->session->set_flashdata(
                    'error',
                    'Le dossier des relevés bancaires ne peut pas être créé.'
                );

                redirect('rapprochement');
                return;
            }
        }

        /*
        * Configuration de l'upload.
        */
        $uploadConfig = [
            'upload_path' =>
            $uploadPath,

            'allowed_types' =>
            'pdf|xls|xlsx|csv',

            'max_size' =>
            10240,

            'encrypt_name' =>
            true,

            'remove_spaces' =>
            true,

            'detect_mime' =>
            true,
        ];

        $this->load->library(
            'upload',
            $uploadConfig
        );

        /*
        * Envoyer le fichier.
        */
        if (!$this->upload->do_upload('statement_file')) {
            $uploadError = strip_tags(
                $this->upload->display_errors()
            );

            $this->session->set_flashdata(
                'error',
                $uploadError
                    ?: 'Le fichier du relevé bancaire est invalide.'
            );

            redirect('rapprochement');
            return;
        }

        $uploadedFile =
            $this->upload->data();

        $storedFileName =
            $uploadedFile['file_name'];

        /*
        * Préparer l'enregistrement.
        */
        $statementData = [
            'bank_account_id' =>
            $bankAccountId,

            'statement_date' =>
            $statementDate,

            'period_start' =>
            $periodStart,

            'period_end' =>
            $periodEnd,

            /*
            * La devise vient du compte bancaire.
            */
            'currency' =>
            $bankAccount->currency,

            'opening_balance' =>
            $openingBalance,

            'closing_balance' =>
            $closingBalance,

            'file_name' =>
            $storedFileName,

            'original_file_name' =>
            $uploadedFile['orig_name'] ?? null,

            'file_type' =>
            $uploadedFile['file_type'] ?? null,

            /*
            * CodeIgniter fournit file_size en Ko.
            * Nous le convertissons en octets.
            */
            'file_size' =>
            isset($uploadedFile['file_size'])
                ? (int) round(
                    (float) $uploadedFile['file_size']
                        * 1024
                )
                : null,

            'total_lines' =>
            0,

            'imported_lines' =>
            0,

            'rejected_lines' =>
            0,

            'observation' =>
            $observation !== ''
                ? $observation
                : null,

            'processing_message' =>
            null,

            'status' =>
            'uploaded',

            'imported_by' =>
            (int) $this->session->userdata(
                'user_id'
            ),

            'processed_at' =>
            null,

            'created_at' =>
            date('Y-m-d H:i:s'),

            'updated_at' =>
            null,
        ];

        /*
        * Insérer dans la base.
        */
        $result =
            $this->finance
            ->createBankStatement(
                $statementData
            );

        /*
        * En cas d'échec de l'insertion,
        * supprimer le fichier déjà envoyé.
        */
        if (!$result['status']) {
            $uploadedFilePath =
                $uploadPath
                . $storedFileName;

            if (is_file($uploadedFilePath)) {
                @unlink($uploadedFilePath);
            }

            $this->session->set_flashdata(
                'error',
                $result['message']
                    ?? 'Le relevé bancaire n’a pas pu être enregistré.'
            );

            redirect('rapprochement');
            return;
        }

        /*
        * Message de succès.
        */
        $this->session->set_flashdata(
            'success',
            'Le relevé bancaire '
                . $result['reference']
                . ' a été importé avec succès.'
        );

        redirect('rapprochement');
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

    /**
     * Lance l'analyse automatique d'un rapprochement bancaire.
     *
     * Cette méthode :
     * 1. vérifie l'utilisateur et la requête POST ;
     * 2. récupère la session de rapprochement ;
     * 3. recherche le relevé correspondant au compte et à la période ;
     * 4. compare les lignes du relevé aux opérations bancaires du système ;
     * 5. enregistre les résultats dans
     *    tbl_finance_bank_reconciliation_item ;
     * 6. met à jour les statistiques de la session.
     */
    public function analyzeBankReconciliationStore()
    {
        /*
     * Route de retour.
     */
        $redirectUrl = 'rapprochement';

        /*
     * =========================================================
     * 1. VÉRIFIER L'AUTHENTIFICATION
     * =========================================================
     */
        $userId = (int) $this->session->userdata('user_id');

        if ($userId <= 0) {
            redirect('sign-in');
            return;
        }

        /*
     * =========================================================
     * 2. ACCEPTER UNIQUEMENT UNE REQUÊTE POST
     * =========================================================
     */
        if (strtoupper($this->input->method()) !== 'POST') {
            show_404();
            return;
        }

        /*
     * =========================================================
     * 3. RÉCUPÉRER LES DONNÉES DU FORMULAIRE
     * =========================================================
     */
        $reconciliationId = (int) $this->input->post(
            'reconciliation_id',
            true
        );

        $dateTolerance = (int) $this->input->post(
            'date_tolerance',
            true
        );

        $amountToleranceRaw = $this->input->post(
            'amount_tolerance',
            true
        );

        /*
     * Nettoyer le montant au cas où l'utilisateur saisit
     * des espaces ou une virgule.
     */
        $amountToleranceRaw = str_replace(
            [' ', ','],
            ['', '.'],
            (string) $amountToleranceRaw
        );

        $amountTolerance = is_numeric($amountToleranceRaw)
            ? (float) $amountToleranceRaw
            : 0;

        /*
     * =========================================================
     * 4. VALIDER LES INFORMATIONS DU FORMULAIRE
     * =========================================================
     */
        if ($reconciliationId <= 0) {
            $this->session->set_flashdata(
                'error',
                'Veuillez sélectionner une session de rapprochement.'
            );

            redirect($redirectUrl);
            return;
        }

        /*
     * Tolérances autorisées dans le formulaire.
     */
        $allowedDateTolerances = [0, 1, 2, 3, 5];

        if (!in_array($dateTolerance, $allowedDateTolerances, true)) {
            $dateTolerance = 3;
        }

        if ($amountTolerance < 0) {
            $amountTolerance = 0;
        }

        /*
     * Limite de sécurité.
     *
     * Une tolérance excessivement élevée peut rapprocher
     * des opérations totalement différentes.
     */
        if ($amountTolerance > 100000000) {
            $this->session->set_flashdata(
                'error',
                'La tolérance sur le montant est trop élevée.'
            );

            redirect($redirectUrl);
            return;
        }

        /*
     * =========================================================
     * 5. VÉRIFIER LES TABLES NÉCESSAIRES
     * =========================================================
     */
        $requiredTables = [
            'tbl_finance_bank_reconciliation',
            'tbl_finance_bank_statement',
            'tbl_finance_bank_statement_line',
            'tbl_finance_bank_operation',
            'tbl_finance_bank_reconciliation_item',
        ];

        foreach ($requiredTables as $requiredTable) {
            if (!$this->db->table_exists($requiredTable)) {
                log_message(
                    'error',
                    'Table manquante pour le rapprochement : '
                        . $requiredTable
                );

                $this->session->set_flashdata(
                    'error',
                    'La table '
                        . $requiredTable
                        . ' est absente de la base de données.'
                );

                redirect($redirectUrl);
                return;
            }
        }

        /*
     * =========================================================
     * 6. RÉCUPÉRER LA SESSION DE RAPPROCHEMENT
     * =========================================================
     */
        $reconciliation = $this->finance
            ->getBankReconciliationById($reconciliationId);

        if (!$reconciliation) {
            $this->session->set_flashdata(
                'error',
                'La session de rapprochement sélectionnée est introuvable.'
            );

            redirect($redirectUrl);
            return;
        }

        /*
     * Empêcher l'analyse d'une session déjà clôturée.
     */
        $blockedStatuses = [
            'validated',
            'cancelled',
            'closed',
        ];

        if (
            in_array(
                (string) $reconciliation->status,
                $blockedStatuses,
                true
            )
        ) {
            $this->session->set_flashdata(
                'error',
                'Cette session est déjà validée, clôturée ou annulée.'
            );

            redirect($redirectUrl);
            return;
        }

        /*
     * Vérifier les informations essentielles de la session.
     */
        $bankAccountId = isset($reconciliation->bank_account_id)
            ? (int) $reconciliation->bank_account_id
            : 0;

        $periodStart = isset($reconciliation->period_start)
            ? (string) $reconciliation->period_start
            : '';

        $periodEnd = isset($reconciliation->period_end)
            ? (string) $reconciliation->period_end
            : '';

        if (
            $bankAccountId <= 0
            || empty($periodStart)
            || empty($periodEnd)
        ) {
            $this->session->set_flashdata(
                'error',
                'La session sélectionnée ne contient pas un compte ou une période valide.'
            );

            redirect($redirectUrl);
            return;
        }

        if (strtotime($periodStart) > strtotime($periodEnd)) {
            $this->session->set_flashdata(
                'error',
                'La date de début de la session est supérieure à la date de fin.'
            );

            redirect($redirectUrl);
            return;
        }

        /*
     * =========================================================
     * 7. TROUVER LE RELEVÉ BANCAIRE CORRESPONDANT
     * =========================================================
     *
     * La méthode du modèle doit vérifier :
     * - le même bank_account_id ;
     * - une période qui couvre ou croise la session.
     */
        $statement = $this->finance
            ->getStatementForReconciliation(
                $bankAccountId,
                $periodStart,
                $periodEnd
            );

        if (!$statement) {
            $bankName = !empty($reconciliation->bank_name)
                ? $reconciliation->bank_name
                : 'sélectionné';

            $this->session->set_flashdata(
                'error',
                'Aucun relevé bancaire du compte '
                    . $bankName
                    . ' ne couvre la période du '
                    . date('d/m/Y', strtotime($periodStart))
                    . ' au '
                    . date('d/m/Y', strtotime($periodEnd))
                    . '.'
            );

            redirect($redirectUrl);
            return;
        }

        $statementId = isset($statement->id)
            ? (int) $statement->id
            : 0;

        if ($statementId <= 0) {
            $this->session->set_flashdata(
                'error',
                'Le relevé bancaire trouvé ne possède pas un identifiant valide.'
            );

            redirect($redirectUrl);
            return;
        }

        /*
     * =========================================================
     * 8. RÉCUPÉRER LES LIGNES DU RELEVÉ
     * =========================================================
     */
        $statementLines = $this->finance
            ->getStatementLinesForAnalysis(
                $statementId,
                $periodStart,
                $periodEnd
            );

        if (empty($statementLines)) {
            $this->session->set_flashdata(
                'error',
                'Le relevé bancaire a bien été trouvé, mais il ne contient '
                    . 'aucune ligne à analyser. Le fichier PDF, Excel ou CSV doit '
                    . 'd’abord être transformé en lignes dans '
                    . 'tbl_finance_bank_statement_line.'
            );

            redirect($redirectUrl);
            return;
        }

        /*
     * =========================================================
     * 9. INITIALISER LES COMPTEURS
     * =========================================================
     */
        $matchedCount = 0;
        $partialCount = 0;
        $anomalyCount = 0;
        $missingSystemCount = 0;

        $totalDifference = 0;
        $totalStatementAmount = 0;
        $totalSystemAmount = 0;

        $now = date('Y-m-d H:i:s');

        /*
     * =========================================================
     * 10. DÉMARRER LA TRANSACTION SQL
     * =========================================================
     */
        $this->db->trans_begin();

        /*
     * Supprimer seulement les résultats automatiques
     * non validés de cette session.
     */
        $this->finance
            ->deletePreviousAutomaticAnalysis($reconciliationId);

        /*
     * Il est conseillé de remettre les lignes de ce relevé
     * à l'état unmatched avant une nouvelle analyse.
     */
        $this->db
            ->where('statement_id', $statementId)
            ->where_in(
                'matching_status',
                [
                    'matched',
                    'partially_matched',
                    'unmatched',
                ]
            )
            ->update(
                'tbl_finance_bank_statement_line',
                [
                    'matching_status' => 'unmatched',
                    'updated_at'      => $now,
                ]
            );

        /*
     * =========================================================
     * 11. ANALYSER CHAQUE LIGNE DU RELEVÉ BANCAIRE
     * =========================================================
     */
        foreach ($statementLines as $statementLine) {
            $statementLineId = isset($statementLine->id)
                ? (int) $statementLine->id
                : 0;

            if ($statementLineId <= 0) {
                continue;
            }

            $statementDate = !empty($statementLine->operation_date)
                ? $statementLine->operation_date
                : null;

            /*
         * Prendre la valeur absolue du montant.
         *
         * Le sens débit/crédit est normalement géré par
         * operation_direction dans la méthode de recherche.
         */
            $statementAmount = isset($statementLine->amount)
                ? abs((float) $statementLine->amount)
                : 0;

            $totalStatementAmount += $statementAmount;

            /*
         * Chercher la meilleure opération SATRACO possible.
         */
            $bankOperation = $this->finance
                ->findMatchingBankOperation(
                    $bankAccountId,
                    $statementLine,
                    $dateTolerance,
                    $amountTolerance
                );

            /*
         * -----------------------------------------------------
         * CAS 1 : UNE OPÉRATION SYSTÈME A ÉTÉ TROUVÉE
         * -----------------------------------------------------
         */
            if ($bankOperation) {
                $bankOperationId = isset($bankOperation->id)
                    ? (int) $bankOperation->id
                    : 0;

                $systemAmount = isset($bankOperation->amount)
                    ? abs((float) $bankOperation->amount)
                    : 0;

                $systemDate = !empty($bankOperation->operation_date)
                    ? $bankOperation->operation_date
                    : null;

                $totalSystemAmount += $systemAmount;

                /*
             * Calculer l'écart entre les deux montants.
             */
                $differenceAmount = abs(
                    $systemAmount - $statementAmount
                );

                /*
             * Calculer l'écart de dates.
             */
                $dateDifferenceDays = 0;

                if ($systemDate && $statementDate) {
                    $systemTimestamp = strtotime($systemDate);
                    $statementTimestamp = strtotime($statementDate);

                    $dateDifferenceDays = (int) floor(
                        abs(
                            $systemTimestamp
                                - $statementTimestamp
                        ) / 86400
                    );
                }

                /*
             * Déterminer le résultat de la comparaison.
             */
                if (
                    $differenceAmount <= $amountTolerance
                    && $dateDifferenceDays <= $dateTolerance
                ) {
                    /*
                 * Correspondance parfaite dans les tolérances.
                 */
                    $matchingStatus = 'matched';
                    $statementLineStatus = 'matched';

                    $matchedCount++;
                } elseif ($differenceAmount > $amountTolerance) {
                    /*
                 * Une opération potentielle a été trouvée,
                 * mais le montant dépasse la tolérance.
                 */
                    $matchingStatus = 'amount_mismatch';
                    $statementLineStatus = 'partially_matched';

                    $partialCount++;
                    $anomalyCount++;
                    $totalDifference += $differenceAmount;
                } else {
                    /*
                 * Le montant est compatible, mais pas la date.
                 */
                    $matchingStatus = 'date_mismatch';
                    $statementLineStatus = 'partially_matched';

                    $partialCount++;
                    $anomalyCount++;
                }

                /*
             * Calculer un score de confiance sur 100.
             */
                $confidenceScore = 100;

                /*
             * Retirer 10 points par jour de différence,
             * avec un maximum de 40 points.
             */
                $confidenceScore -= min(
                    40,
                    $dateDifferenceDays * 10
                );

                /*
             * Retirer des points si les montants diffèrent.
             */
                if ($differenceAmount > 0) {
                    if ($statementAmount > 0) {
                        $differencePercentage = (
                            $differenceAmount
                            / $statementAmount
                        ) * 100;

                        $confidenceScore -= min(
                            50,
                            (int) round($differencePercentage)
                        );
                    } else {
                        $confidenceScore -= 50;
                    }
                }

                $confidenceScore = max(
                    0,
                    min(100, $confidenceScore)
                );

                /*
             * Insérer le résultat de la comparaison.
             */
                $this->finance
                    ->insertReconciliationItem(
                        [
                            'reconciliation_id' =>
                            $reconciliationId,

                            'bank_operation_id' =>
                            $bankOperationId,

                            'statement_line_id' =>
                            $statementLineId,

                            'system_operation_date' =>
                            $systemDate,

                            'statement_operation_date' =>
                            $statementDate,

                            'system_amount' =>
                            $systemAmount,

                            'statement_amount' =>
                            $statementAmount,

                            'difference_amount' =>
                            $differenceAmount,

                            'matching_status' =>
                            $matchingStatus,

                            'matching_method' =>
                            'automatic',

                            'confidence_score' =>
                            $confidenceScore,

                            'justification' =>
                            null,

                            'observation' =>
                            'Analyse automatique : tolérance de date de ±'
                                . $dateTolerance
                                . ' jour(s) et tolérance de montant de '
                                . number_format(
                                    $amountTolerance,
                                    2,
                                    '.',
                                    ''
                                )
                                . '.',

                            /*
                         * matched_by est renseigné uniquement
                         * pour une vraie correspondance.
                         */
                            'matched_by' =>
                            $matchingStatus === 'matched'
                                ? $userId
                                : null,

                            'matched_at' =>
                            $matchingStatus === 'matched'
                                ? $now
                                : null,

                            'created_at' =>
                            $now,
                        ]
                    );

                /*
             * Mettre à jour la ligne bancaire.
             */
                $this->finance
                    ->updateStatementLineMatchingStatus(
                        $statementLineId,
                        $statementLineStatus
                    );
            } else {
                /*
             * -------------------------------------------------
             * CAS 2 : AUCUNE OPÉRATION SYSTÈME TROUVÉE
             * -------------------------------------------------
             */
                $missingSystemCount++;
                $anomalyCount++;

                /*
             * L'intégralité du montant constitue un écart
             * tant qu'aucune opération système n'est associée.
             */
                $totalDifference += $statementAmount;

                $this->finance
                    ->insertReconciliationItem(
                        [
                            'reconciliation_id' =>
                            $reconciliationId,

                            'bank_operation_id' =>
                            null,

                            'statement_line_id' =>
                            $statementLineId,

                            'system_operation_date' =>
                            null,

                            'statement_operation_date' =>
                            $statementDate,

                            'system_amount' =>
                            0,

                            'statement_amount' =>
                            $statementAmount,

                            'difference_amount' =>
                            $statementAmount,

                            'matching_status' =>
                            'missing_system_entry',

                            'matching_method' =>
                            'automatic',

                            'confidence_score' =>
                            0,

                            'justification' =>
                            null,

                            'observation' =>
                            'Cette opération figure sur le relevé bancaire, '
                                . 'mais aucune opération correspondante n’a été '
                                . 'trouvée dans le système.',

                            'matched_by' =>
                            null,

                            'matched_at' =>
                            null,

                            'created_at' =>
                            $now,
                        ]
                    );

                $this->finance
                    ->updateStatementLineMatchingStatus(
                        $statementLineId,
                        'unmatched'
                    );
            }
        }

        /*
     * =========================================================
     * 12. CALCULER LES TOTAUX DE LA SESSION
     * =========================================================
     */
        $totalAnalyzed = count($statementLines);

        $unmatchedCount = max(
            0,
            $totalAnalyzed - $matchedCount
        );

        /*
     * Solde final communiqué par la banque.
     */
        if (isset($statement->closing_balance)) {
            $statementClosingBalance = (float) $statement->closing_balance;
        } elseif (isset($reconciliation->statement_closing_balance)) {
            $statementClosingBalance =
                (float) $reconciliation->statement_closing_balance;
        } else {
            $statementClosingBalance = 0;
        }

        /*
     * Solde actuellement enregistré dans SATRACO.
     */
        if (isset($reconciliation->system_balance)) {
            $systemBalance = (float) $reconciliation->system_balance;
        } elseif (isset($reconciliation->account_current_balance)) {
            $systemBalance =
                (float) $reconciliation->account_current_balance;
        } else {
            $systemBalance = 0;
        }

        /*
     * Écart entre le solde bancaire et le solde système.
     */
        $differenceBefore = abs(
            $statementClosingBalance - $systemBalance
        );

        /*
     * Pourcentage rapproché.
     */
        $matchingPercentage = $totalAnalyzed > 0
            ? round(
                ($matchedCount / $totalAnalyzed) * 100,
                2
            )
            : 0;

        /*
     * =========================================================
     * 13. METTRE À JOUR LA SESSION
     * =========================================================
     */
        $sessionUpdated = $this->finance
            ->updateBankReconciliation(
                $reconciliationId,
                [
                    'total_operations' =>
                    $totalAnalyzed,

                    'matched_operations' =>
                    $matchedCount,

                    'unmatched_operations' =>
                    $unmatchedCount,

                    'difference_before_adjustment' =>
                    $differenceBefore,

                    'difference_after_adjustment' =>
                    $totalDifference,

                    'status' =>
                    'in_progress',

                    'updated_at' =>
                    $now,
                ]
            );

        if (!$sessionUpdated) {
            $this->db->trans_rollback();

            $this->session->set_flashdata(
                'error',
                'Impossible de mettre à jour la session de rapprochement.'
            );

            redirect($redirectUrl);
            return;
        }

        /*
     * =========================================================
     * 14. VÉRIFIER ET TERMINER LA TRANSACTION
     * =========================================================
     */
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();

            log_message(
                'error',
                'Échec de l’analyse du rapprochement bancaire. '
                    . 'Session ID : '
                    . $reconciliationId
            );

            $this->session->set_flashdata(
                'error',
                'Une erreur est survenue pendant l’analyse. '
                    . 'Aucune donnée n’a été enregistrée.'
            );

            redirect($redirectUrl);
            return;
        }

        $this->db->trans_commit();

        /*
     * =========================================================
     * 15. MESSAGE DE SUCCÈS
     * =========================================================
     */
        $message = 'Analyse terminée avec succès : '
            . $totalAnalyzed
            . ' opération(s) analysée(s), '
            . $matchedCount
            . ' correspondance(s), '
            . $partialCount
            . ' correspondance(s) partielle(s), '
            . $missingSystemCount
            . ' opération(s) absente(s) du système et '
            . $anomalyCount
            . ' anomalie(s). Taux de rapprochement : '
            . number_format(
                $matchingPercentage,
                2,
                ',',
                ' '
            )
            . ' %.';

        $this->session->set_flashdata(
            'success',
            $message
        );

        redirect($redirectUrl);
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
