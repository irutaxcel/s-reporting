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
        $data['employes'] = $this->Employe_model->get_all('DESC');

        $next_matricule = $this->Employe_model->generer_matricule();
        $data['next_matricule'] = $next_matricule;

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/rh/rh-employes', $data);
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
    // public function employes_store()
    // {
    //     if (!$this->session->userdata('logged_in')) {
    //         redirect('sign-in');
    //     }

    //     $this->load->library('form_validation');
    //     $this->form_validation->set_rules('nom', 'Nom', 'required|trim');
    //     $this->form_validation->set_rules('prenoms', 'Prénoms', 'required|trim');
    //     $this->form_validation->set_rules('fonction', 'Fonction', 'required|trim');
    //     $this->form_validation->set_rules('date_embauche', "Date d'embauche", 'required');
    //     $this->form_validation->set_rules('salaire_base', 'Salaire de base', 'required|numeric');
    //     $this->form_validation->set_rules('email', 'Email', 'valid_email');

    //     if ($this->form_validation->run() === FALSE) {
    //         echo json_encode(['status' => 'error', 'message' => strip_tags(validation_errors('• ', ' '))]);
    //         return;
    //     }

    //     // 1. Upload des 4 documents (optionnels)
    //     $docs = [
    //         'doc_cnid'    => $this->_upload_doc('doc_cnid'),
    //         'doc_photo'   => $this->_upload_doc('doc_photo'),
    //         'doc_contrat' => $this->_upload_doc('doc_contrat'),
    //         'doc_cv'      => $this->_upload_doc('doc_cv'),
    //     ];
    //     foreach ($docs as $champ => $resultat) {
    //         if (is_array($resultat)) { // erreur d'upload
    //             echo json_encode(['status' => 'error', 'message' => $resultat['error']]);
    //             return;
    //         }
    //     }

    //     // 2. Insertion
    //     $data = array_merge([
    //         'matricule'           => $this->Employe_model->generer_matricule(),
    //         'nom'                 => $this->input->post('nom'),
    //         'prenoms'             => $this->input->post('prenoms'),
    //         'sexe'                => $this->input->post('sexe'),
    //         'date_naissance'      => $this->input->post('date_naissance') ?: NULL,
    //         'etat_civil'          => $this->input->post('etat_civil'),
    //         'cnid'                => $this->input->post('cnid'),
    //         'telephone'           => $this->input->post('telephone'),
    //         'email'               => $this->input->post('email'),
    //         'adresse'             => $this->input->post('adresse'),
    //         'categorie'           => $this->input->post('categorie'),
    //         'fonction'            => $this->input->post('fonction'),
    //         'departement'         => $this->input->post('departement'),
    //         'site_affectation'    => $this->input->post('site_affectation'),
    //         'date_embauche'       => $this->input->post('date_embauche'),
    //         'type_contrat'        => $this->input->post('type_contrat'),
    //         'date_fin_contrat'    => $this->input->post('date_fin_contrat') ?: NULL,
    //         'periode_essai'       => $this->input->post('periode_essai'),
    //         'salaire_base'        => $this->input->post('salaire_base'),
    //         'mode_paiement'       => $this->input->post('mode_paiement'),
    //         'matricule_inss'      => $this->input->post('matricule_inss'),
    //         'numero_contribuable' => $this->input->post('numero_contribuable'),
    //     ], $docs);

    //     $id = $this->Employe_model->insert($data);

    //     echo json_encode([
    //         'status'  => 'success',
    //         'message' => 'Employé ' . $data['matricule'] . ' enregistré avec succès.',
    //         'employe_id' => $id
    //     ]);
    // }

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
            $this->session->set_flashdata('error', 'Formulaire incomplet : ' . strip_tags(validation_errors('• ', ' ')));
            redirect('rh-employes');
            return;
        }

        // 1. Upload des 4 documents (optionnels)
        $docs = [];
        foreach (['doc_cnid', 'doc_photo', 'doc_contrat', 'doc_cv'] as $champ) {
            $res = $this->_upload_doc($champ);
            if (is_array($res)) { // erreur d'upload
                $this->session->set_flashdata('error', $res['error']);
                redirect('rh-employes');
                return;
            }
            if ($res !== NULL) {
                $docs[$champ] = $res;
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

        $this->Employe_model->insert($data);

        // 3. ✅ Plus de JSON : toast Swal via flashdata + retour à la liste
        $this->session->set_flashdata('success', 'Employé ' . $data['matricule'] . ' enregistré avec succès.');
        redirect('rh-employes');
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


    /** AJAX : récupère un employé pour la modale de modification */
    public function employe_get($id = NULL)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $emp = $this->Employe_model->get_by_id($id);
        if (!$emp) {
            echo json_encode(['status' => 'error', 'message' => 'Employé introuvable.']);
            return;
        }
        echo json_encode(['status' => 'success', 'employe' => $emp]);
    }


    /** AJAX : mise à jour d'un employé */
    // public function employes_update()
    // {
    //     if (!$this->session->userdata('logged_in')) {
    //         redirect('sign-in');
    //     }

    //     $id     = (int) $this->input->post('employe_id');
    //     $ancien = $this->Employe_model->get_by_id($id);
    //     if (!$ancien) {
    //         echo json_encode(['status' => 'error', 'message' => 'Employé introuvable.']);
    //         return;
    //     }

    //     $this->load->library('form_validation');
    //     $this->form_validation->set_rules('nom', 'Nom', 'required|trim');
    //     $this->form_validation->set_rules('prenoms', 'Prénoms', 'required|trim');
    //     $this->form_validation->set_rules('fonction', 'Fonction', 'required|trim');
    //     $this->form_validation->set_rules('date_embauche', "Date d'embauche", 'required');
    //     $this->form_validation->set_rules('salaire_base', 'Salaire de base', 'required|numeric');
    //     $this->form_validation->set_rules('email', 'Email', 'valid_email');

    //     if ($this->form_validation->run() === FALSE) {
    //         echo json_encode(['status' => 'error', 'message' => strip_tags(validation_errors('• ', ' '))]);
    //         return;
    //     }

    //     // Documents de remplacement (optionnels) : upload + suppression de l'ancien
    //     $docs = [];
    //     foreach (['doc_cnid', 'doc_photo', 'doc_contrat', 'doc_cv'] as $champ) {
    //         if (!empty($_FILES[$champ]['name'])) {
    //             $res = $this->_upload_doc($champ);
    //             if (is_array($res)) {
    //                 echo json_encode(['status' => 'error', 'message' => $res['error']]);
    //                 return;
    //             }
    //             if (!empty($ancien->$champ) && file_exists(FCPATH . $ancien->$champ)) {
    //                 unlink(FCPATH . $ancien->$champ);
    //             }
    //             $docs[$champ] = $res;
    //         }
    //     }

    //     $data = array_merge([
    //         'nom'                 => $this->input->post('nom'),
    //         'prenoms'             => $this->input->post('prenoms'),
    //         'sexe'                => $this->input->post('sexe'),
    //         'date_naissance'      => $this->input->post('date_naissance') ?: NULL,
    //         'etat_civil'          => $this->input->post('etat_civil'),
    //         'cnid'                => $this->input->post('cnid'),
    //         'telephone'           => $this->input->post('telephone'),
    //         'email'               => $this->input->post('email'),
    //         'adresse'             => $this->input->post('adresse'),
    //         'categorie'           => $this->input->post('categorie'),
    //         'fonction'            => $this->input->post('fonction'),
    //         'departement'         => $this->input->post('departement'),
    //         'site_affectation'    => $this->input->post('site_affectation'),
    //         'date_embauche'       => $this->input->post('date_embauche'),
    //         'type_contrat'        => $this->input->post('type_contrat'),
    //         'date_fin_contrat'    => $this->input->post('date_fin_contrat') ?: NULL,
    //         'periode_essai'       => $this->input->post('periode_essai'),
    //         'salaire_base'        => $this->input->post('salaire_base'),
    //         'mode_paiement'       => $this->input->post('mode_paiement'),
    //         'matricule_inss'      => $this->input->post('matricule_inss'),
    //         'numero_contribuable' => $this->input->post('numero_contribuable'),
    //         'statut'              => $this->input->post('statut'),
    //     ], $docs);

    //     $this->Employe_model->update($id, $data);
    //     echo json_encode(['status' => 'success', 'message' => 'Fiche ' . $ancien->matricule . ' mise à jour avec succès.']);
    // }


    public function employes_update()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $id     = (int) $this->input->post('employe_id');
        $ancien = $this->Employe_model->get_by_id($id);

        if (!$ancien) {
            $this->session->set_flashdata('error', 'Employé introuvable.');
            redirect('rh-employes');
            return;
        }

        // -------- Validation --------
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nom', 'Nom', 'required|trim');
        $this->form_validation->set_rules('prenoms', 'Prénoms', 'required|trim');
        $this->form_validation->set_rules('fonction', 'Fonction', 'required|trim');
        $this->form_validation->set_rules('date_embauche', "Date d'embauche", 'required');
        $this->form_validation->set_rules('salaire_base', 'Salaire de base', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Formulaire incomplet : ' . strip_tags(validation_errors('• ', ' ')));
            redirect('rh-employes');
            return;
        }

        // -------- Documents de remplacement (optionnels) --------
        $docs = [];
        foreach (['doc_cnid', 'doc_photo', 'doc_contrat', 'doc_cv'] as $champ) {
            if (!empty($_FILES[$champ]['name'])) {
                $res = $this->_upload_doc($champ);
                if (is_array($res)) {
                    $this->session->set_flashdata('error', $res['error']);
                    redirect('rh-employes');
                    return;
                }
                // Supprime l'ancien fichier du serveur
                if (!empty($ancien->$champ) && file_exists(FCPATH . $ancien->$champ)) {
                    unlink(FCPATH . $ancien->$champ);
                }
                $docs[$champ] = $res;
            }
        }

        // -------- Données à mettre à jour --------
        $data = array_merge([
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
            'statut'              => $this->input->post('statut'),
        ], $docs);

        $this->Employe_model->update($id, $data);

        $this->session->set_flashdata('success', 'Fiche ' . $ancien->matricule . ' mise à jour avec succès.');
        redirect('rh-employes');
    }

    public function rhContrats()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $title = 'Contrats & mouvements';
        $data  = [];

        $data['employes'] = $this->Employe_model->get_all('DESC');   // ← ligne 401 complétée
        $data['contrats'] = $this->Employe_model->get_with_employes();

        $data['mouvements'] = $this->Employe_model->get_mouvements_with_employes();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/rh/rh-contrats', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function contrats_store()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('employe_id', 'Employé', 'required|integer');
        $this->form_validation->set_rules('date_debut', 'Date de début', 'required');
        $this->form_validation->set_rules('fonction', 'Fonction', 'required|trim');
        $this->form_validation->set_rules('salaire_base', 'Salaire de base', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Formulaire incomplet : ' . strip_tags(validation_errors('• ', ' ')));
            redirect('rh-contrats');
            return;
        }

        // Upload du contrat signé (optionnel)
        $doc = NULL;
        if (!empty($_FILES['document']['name'])) {
            $config = [
                'upload_path'   => FCPATH . 'uploads/rh/contrats/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 2048,
                'file_name'     => 'contrat_' . time() . '_' . uniqid(),
            ];
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
            $this->load->library('upload');
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('document')) {
                $this->session->set_flashdata('error', 'Document : ' . $this->upload->display_errors('', ''));
                redirect('rh-contrats');
                return;
            }
            $doc = 'uploads/rh/contrats/' . $this->upload->data('file_name');
        }

        // Règle métier : un CDI n'a pas de date de fin
        $type = $this->input->post('type_contrat');

        $this->Employe_model->insertContract([
            'employe_id'       => $this->input->post('employe_id'),
            'operation'        => $this->input->post('operation'),
            'type_contrat'     => $type,
            'date_debut'       => $this->input->post('date_debut'),
            'date_fin'         => ($type !== 'CDI' && $this->input->post('date_fin')) ? $this->input->post('date_fin') : NULL,
            'periode_essai'    => $this->input->post('periode_essai'),
            'fonction'         => $this->input->post('fonction'),
            'salaire_base'     => $this->input->post('salaire_base'),
            'site_affectation' => $this->input->post('site_affectation'),
            'document'         => $doc,
            'observations'     => $this->input->post('observations'),
        ]);

        $this->session->set_flashdata('success', 'Contrat enregistré avec succès.');
        redirect('rh-contrats');
    }

    public function mouvements_store()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('employe_id', 'Employé', 'required|integer');
        $this->form_validation->set_rules('type_mouvement', 'Type de mouvement', 'required');
        $this->form_validation->set_rules('date_effet', "Date d'effet", 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Formulaire incomplet : ' . strip_tags(validation_errors('• ', ' ')));
            redirect('rh-contrats');
            return;
        }

        $id_emp = (int) $this->input->post('employe_id');
        $emp    = $this->Employe_model->get_by_id($id_emp);
        if (!$emp) {
            $this->session->set_flashdata('error', 'Employé introuvable.');
            redirect('rh-contrats');
            return;
        }

        // Upload du justificatif (optionnel)
        $justif = NULL;
        if (!empty($_FILES['justificatif']['name'])) {
            $config = [
                'upload_path'   => FCPATH . 'uploads/rh/mouvements/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 2048,
                'file_name'     => 'mouvement_' . time() . '_' . uniqid(),
            ];
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
            $this->load->library('upload');
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('justificatif')) {
                $this->session->set_flashdata('error', 'Justificatif : ' . $this->upload->display_errors('', ''));
                redirect('rh-contrats');
                return;
            }
            $justif = 'uploads/rh/mouvements/' . $this->upload->data('file_name');
        }

        $type          = $this->input->post('type_mouvement');
        $affectation   = $this->input->post('nouvelle_affectation');

        // 1. Enregistrement du mouvement
        $this->Employe_model->insert_mouvement([
            'employe_id'           => $id_emp,
            'type_mouvement'       => $type,
            'date_effet'           => $this->input->post('date_effet'),
            'nouvelle_affectation' => $affectation ?: NULL,
            'justificatif'         => $justif,
            'motif'                => $this->input->post('motif'),
            'encode_par'           => $this->session->userdata('nom') ?: $this->session->userdata('username'),
        ]);

        // 2. Effets automatiques sur la fiche employé
        if (in_array($type, ['Démission', 'Licenciement', 'Fin de contrat', 'Retraite'])) {
            // Sortie → l'employé passe en "Fin de contrat"
            $this->Employe_model->update($id_emp, ['statut' => 'Fin de contrat']);
        } elseif (in_array($type, ['Transfert', 'Promotion']) && $affectation !== '') {
            // Transfert / promotion → mise à jour de l'affectation
            $this->Employe_model->update($id_emp, ['site_affectation' => $affectation]);
        }

        $this->session->set_flashdata('success', 'Mouvement « ' . $type . ' » enregistré pour ' . $emp->matricule . '.');
        redirect('rh-contrats');
    }

    public function rhRegistre()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $title = "Registre d'employeur";
        $data  = [];

        // Registre : ordre croissant du matricule (comme un vrai registre papier)
        $data['employes']   = $this->Employe_model->get_all('ASC');
        $data['mouvements'] = $this->Employe_model->get_mouvements_with_employes();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/rh/rh-registre', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function rhPresences()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $title = "Temps & présences";
        $data = [];


        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/rh/rh-presences', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function rhConges()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $title = 'Congés';
        $data  = [];

        $data['employes'] = $this->Employe_model->get_all('DESC');
        $data['conges']   = $this->Employe_model->get_conges_with_employes();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/rh/rh-conges', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function conges_store()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('employe_id', 'Employé', 'required|integer');
        $this->form_validation->set_rules('date_debut', 'Date de début', 'required');
        $this->form_validation->set_rules('date_fin', 'Date de fin', 'required|callback_verif_periode');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Formulaire incomplet : ' . strip_tags(validation_errors('• ', ' ')));
            redirect('rh-conges');
            return;
        }

        // Upload du justificatif (optionnel)
        $justif = NULL;
        if (!empty($_FILES['justificatif']['name'])) {
            $config = [
                'upload_path'   => FCPATH . 'uploads/rh/conges/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 2048,
                'file_name'     => 'conge_' . time() . '_' . uniqid(),
            ];
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
            $this->load->library('upload');
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('justificatif')) {
                $this->session->set_flashdata('error', 'Justificatif : ' . $this->upload->display_errors('', ''));
                redirect('rh-conges');
                return;
            }
            $justif = 'uploads/rh/conges/' . $this->upload->data('file_name');
        }

        $this->Employe_model->insert_conge([
            'employe_id'    => $this->input->post('employe_id'),
            'type_conge'    => $this->input->post('type_conge'),
            'date_debut'    => $this->input->post('date_debut'),
            'date_fin'      => $this->input->post('date_fin'),
            'jours_ouvres'  => $this->_compter_jours_ouvres($this->input->post('date_debut'), $this->input->post('date_fin')),
            'remplacant_id' => $this->input->post('remplacant_id') ?: NULL,
            'justificatif'  => $justif,
            'observation'   => $this->input->post('observation'),
            'statut'        => 'En attente',
            'encode_par'    => $this->session->userdata('nom') ?: $this->session->userdata('username'),
        ]);

        $this->session->set_flashdata('success', 'Demande de congé soumise avec succès.');
        redirect('rh-conges');
    }

    /** Validation : la fin doit être >= au début */
    public function verif_periode($date_fin)
    {
        if ($date_fin < $this->input->post('date_debut')) {
            $this->form_validation->set_message('verif_periode', 'La date de fin doit être postérieure ou égale à la date de début.');
            return FALSE;
        }
        return TRUE;
    }

    /** Jours ouvrés (lun → ven) entre deux dates */
    private function _compter_jours_ouvres($debut, $fin)
    {
        $jours = 0;
        $d = new DateTime($debut);
        $f = new DateTime($fin);
        while ($d <= $f) {
            if ((int) $d->format('N') <= 5) $jours++;   // 1=lun … 5=ven
            $d->modify('+1 day');
        }
        return $jours;
    }

    public function rhPaie()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $title = "Paie";
        $data = [];


        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/rh/rh-paie', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function rhConfirmite()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('sign-in');
        }

        $title = "Conformité & déclarations";
        $data = [];


        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/rh/rh-conformite', $data);
        $this->load->view('v1/components/layout/footer');
    }
}