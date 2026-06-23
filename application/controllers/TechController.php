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

        $title = 'Personnel Chantier';

        $allChantier = $this->tech->getAllChantier();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/technique/personeChantier', ['allChantier' => $allChantier]);
        $this->load->view('v1/components/layout/footer');
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
}
