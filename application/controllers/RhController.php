<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RhController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('AuthModel', 'auth');
        $this->load->model('TechModel', 'tech');
        $this->load->model('AdminModel', 'admin');
        $this->load->model('FinanceModel', 'finance');
        $this->load->model('RhModel', 'Employe_model');
        $this->load->library('upload');
    }


    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $title = 'Tableau de bord RH';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/rh/rh-dashboard');
        $this->load->view('v1/components/layout/footer');
    }

    public function employes()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $title = 'Employés';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/rh/rh-employes');
        $this->load->view('v1/components/layout/footer');
    }

    /** AJAX : prochain matricule affiché dans la modale */
    public function next_matricule()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }
        $this->output->set_content_type('application/json')
            ->set_output(json_encode(['matricule' => $this->Employe_model->generer_matricule()]));
    }

    /** AJAX : enregistrement d'un nouvel employé */
    public function employes_store()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nom', 'Nom', 'required|trim');
        $this->form_validation->set_rules('prenoms', 'Prénoms', 'required|trim');
        $this->form_validation->set_rules('fonction', 'Fonction', 'required|trim');
        $this->form_validation->set_rules('date_embauche', "Date d'embauche", 'required');
        $this->form_validation->set_rules('salaire_base', 'Salaire de base', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 'error', 'message' => strip_tags(validation_errors('• ', ' '))]);
            return;
        }

        // 1. Upload des 4 documents (optionnels)
        $docs = [
            'doc_cnid'    => $this->_upload_doc('doc_cnid'),
            'doc_photo'   => $this->_upload_doc('doc_photo'),
            'doc_contrat' => $this->_upload_doc('doc_contrat'),
            'doc_cv'      => $this->_upload_doc('doc_cv'),
        ];
        foreach ($docs as $champ => $resultat) {
            if (is_array($resultat)) { // erreur d'upload
                echo json_encode(['status' => 'error', 'message' => $resultat['error']]);
                return;
            }
        }

        // 2. Insertion
        $data = array_merge([
            'matricule'           => $this->Employe_model->generer_matricule(),
            'nom'                 => $this->input->post('nom'),
            'prenoms'             => $this->input->post('prenoms'),
            'sexe'                => $this->input->post('sexe'),
            'date_naissance'      => $this->input->post('date_naissance') ?: NULL,
            'etat_civil'          => $this->input->post('etat_civil'),
            'cnid'                => $this->input->post('cnid'),
            'telephone'           => $this->input->post('telephone'),
            'email'               => $this->input->post('email'),
            'adresse'             => $this->input->post('adresse'),
            'categorie'           => $this->input->post('categorie'),
            'fonction'            => $this->input->post('fonction'),
            'departement'         => $this->input->post('departement'),
            'site_affectation'    => $this->input->post('site_affectation'),
            'date_embauche'       => $this->input->post('date_embauche'),
            'type_contrat'        => $this->input->post('type_contrat'),
            'date_fin_contrat'    => $this->input->post('date_fin_contrat') ?: NULL,
            'periode_essai'       => $this->input->post('periode_essai'),
            'salaire_base'        => $this->input->post('salaire_base'),
            'mode_paiement'       => $this->input->post('mode_paiement'),
            'matricule_inss'      => $this->input->post('matricule_inss'),
            'numero_contribuable' => $this->input->post('numero_contribuable'),
        ], $docs);

        $id = $this->Employe_model->insert($data);

        echo json_encode([
            'status'  => 'success',
            'message' => 'Employé ' . $data['matricule'] . ' enregistré avec succès.',
            'employe_id' => $id
        ]);
    }

    /** Helper upload d'un document */
    private function _upload_doc($champ)
    {
        if (empty($_FILES[$champ]['name'])) return NULL;

        $config = [
            'upload_path'   => FCPATH . 'uploads/rh/employes/',
            'allowed_types' => 'pdf|jpg|jpeg|png',
            'max_size'      => 2048,
            'file_name'     => $champ . '_' . time() . '_' . uniqid(),
        ];
        if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($champ)) {
            return ['error' => $champ . ' : ' . $this->upload->display_errors('', '')];
        }
        return 'uploads/rh/employes/' . $this->upload->data('file_name');
    }
}
