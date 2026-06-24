<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TechController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('AuthModel', 'auth');
        $this->load->model('TechModel', 'tech');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function personeChantier()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['title'] = 'Personnel Chantier';

        // Semaine actuelle : dimanche -> vendredi
        if (date('w') == 0) {
            $data['debut_semaine'] = date('Y-m-d');
        } else {
            $data['debut_semaine'] = date('Y-m-d', strtotime('last sunday'));
        }

        $data['fin_semaine'] = date('Y-m-d', strtotime($data['debut_semaine'] . ' +5 days'));

        // Données principales
        $data['allChantier'] = $this->tech->getAllChantier();

        // Totaux de la semaine actuelle
        $data['total_chantiers'] = count($data['allChantier']);
        $data['total_personnels'] = $this->tech->countAllPersonnel(
            $data['debut_semaine'],
            $data['fin_semaine']
        );

        $data['montant_total'] = $this->tech->sumAllPersonnel(
            $data['debut_semaine'],
            $data['fin_semaine']
        );

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/technique/personeChantier', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }



    public function storePersonnelChantier()
    {
        $chantier_id = $this->input->post('chantier_id');

        $worker_names   = $this->input->post('worker_name');
        $worker_types   = $this->input->post('worker_type');
        $functions      = $this->input->post('function_name');
        $start_dates    = $this->input->post('start_date');
        $end_dates      = $this->input->post('end_date');
        $payment_modes  = $this->input->post('payment_mode');
        $unit_rates     = $this->input->post('unit_rate');

        $approved_by_dt  = $this->input->post('directeur_technique') ? 1 : 0;
        $approved_by_daf = $this->input->post('directeur_financier') ? 1 : 0;

        if (empty($chantier_id) || empty($worker_names)) {
            $this->session->set_flashdata('error', 'Veuillez sélectionner un chantier et ajouter au moins un personnel.');
            redirect('personnel-chantier');
        }

        $insertData = [];

        foreach ($worker_names as $key => $worker_name) {

            if (trim($worker_name) == '') {
                continue;
            }

            $unit_rate = !empty($unit_rates[$key]) ? $unit_rates[$key] : 0;

            $insertData[] = [
                'company_id'       => $this->session->userdata('company_id'),
                'chantier_id'      => $chantier_id,
                'worker_name'      => trim($worker_name),
                'worker_type'      => $worker_types[$key] ?? 'Journalier',
                'function_name'    => $functions[$key] ?? null,
                'contact_phone'    => null,
                'start_date'       => !empty($start_dates[$key]) ? $start_dates[$key] : null,
                'end_date'         => !empty($end_dates[$key]) ? $end_dates[$key] : null,
                'pay_mode'         => $payment_modes[$key] ?? 'hebdomadaire',
                'unit_rate'        => $unit_rate,
                'contract_amount'  => 0,
                'status_label'     => 'actif',
                'approved_by_dt'   => $approved_by_dt,
                'approved_by_daf'  => $approved_by_daf,
                'notes'            => null,
                'created_at'       => date('Y-m-d H:i:s')
            ];
        }

        if (empty($insertData)) {
            $this->session->set_flashdata('error', 'Aucune ligne valide à enregistrer.');
            redirect('personnel-chantier');
        }

        $this->tech->insertPersonnelChantierBatch($insertData);

        $this->session->set_flashdata('success', 'Personnel chantier enregistré avec succès.');
        redirect('personnel-chantier');
    }

    public function personnelUpdate()
    {
        $id = $this->input->post('id');

        if (empty($id)) {
            $this->session->set_flashdata('error', 'Personnel introuvable.');
            redirect('personnel-chantier');
        }

        $data = [
            'worker_name'   => $this->input->post('worker_name', TRUE),
            'worker_type'   => $this->input->post('worker_type', TRUE),
            'function_name' => $this->input->post('function_name', TRUE),
            'start_date'    => $this->input->post('start_date') ?: null,
            'end_date'      => $this->input->post('end_date') ?: null,
            'pay_mode'      => $this->input->post('pay_mode', TRUE),
            'unit_rate'     => $this->input->post('unit_rate') ?: 0,
        ];

        $this->tech->updatePersonnelChantier($id, $data);

        $this->session->set_flashdata('success', 'Personnel modifié avec succès.');
        redirect('personnel-chantier');
    }

    public function personnelDelete($id)
    {
        $this->tech->deletePersonnelChantier($id);

        $this->session->set_flashdata(
            'success',
            'Personnel supprimé avec succès.'
        );

        redirect('personnel-chantier');
    }

    public function personnelChantierPrint()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['title'] = 'Personnel Chantier';

        // Semaine actuelle : dimanche -> vendredi
        if (date('w') == 0) {
            $data['debut_semaine'] = date('Y-m-d');
        } else {
            $data['debut_semaine'] = date('Y-m-d', strtotime('last sunday'));
        }

        $data['fin_semaine'] = date('Y-m-d', strtotime($data['debut_semaine'] . ' +5 days'));

        // Données principales
        $data['allChantier'] = $this->tech->getAllChantier();

        // Totaux de la semaine actuelle
        $data['total_chantiers'] = count($data['allChantier']);
        $data['total_personnels'] = $this->tech->countAllPersonnel(
            $data['debut_semaine'],
            $data['fin_semaine']
        );

        $data['montant_total'] = $this->tech->sumAllPersonnel(
            $data['debut_semaine'],
            $data['fin_semaine']
        );


        $this->load->view('v1/components/layout/header-print', $data);
        $this->load->view('v1/components/modules/technique/personnelChantierPrint', $data);
        $this->load->view('v1/components/layout/footer-print', $data);
    }
}
