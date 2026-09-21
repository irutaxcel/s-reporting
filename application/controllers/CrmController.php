<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CrmController extends CI_Controller
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
        $this->load->model('CrmModel', 'crm');
        $this->load->library('upload');
    }

    public function index()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Tableau de Bord CRM';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/crm/crm-dashboard');
        $this->load->view('v1/components/layout/footer');
    }

    public function clients()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Clients CRM';

        // Récupérer les statistiques
        $stats = $this->crm->getClientStats();

        // Récupérer tous les clients
        $data['clients'] = $this->crm->getAllClients();

        // Récupérer tous les projets pour le modal
        $data['projects'] = $this->crm->getAllProject();

        // Passer les stats à la vue
        $data['stats'] = $stats;

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/crm/crm-clients', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function addClient()
    {
        // Vérifier que c'est une requête POST
        if ($this->input->method() !== 'post') {
            redirect('crm-clients');
            return;
        }

        // Configuration de la validation
        $config = array(
            array(
                'field' => 'type_client',
                'label' => 'Type de Client',
                'rules' => 'required|in_list[entreprise,particulier,public]'
            ),
            array(
                'field' => 'raison_sociale',
                'label' => 'Raison Sociale',
                'rules' => 'required|min_length[3]'
            ),
            array(
                'field' => 'telephone',
                'label' => 'Téléphone',
                'rules' => 'required|min_length[8]'
            ),
            array(
                'field' => 'ville',
                'label' => 'Ville',
                'rules' => 'required'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'valid_email'
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() === FALSE) {
            // Validation échouée - retourner au formulaire avec les erreurs
            $this->session->set_flashdata('error', validation_errors());
            redirect('crm-clients');
        } else {
            // Validation réussie - Récupérer les données
            $data = array(
                'type_client'    => $this->input->post('type_client'),
                'categorie'      => $this->input->post('categorie') ?: 'C',
                'raison_sociale' => $this->input->post('raison_sociale'),
                'nom_commercial' => $this->input->post('nom_commercial'),
                'email'          => $this->input->post('email'),
                'telephone'      => $this->input->post('telephone'),
                'adresse'        => $this->input->post('adresse'),
                'ville'          => $this->input->post('ville'),
                'code_postal'    => $this->input->post('code_postal'),
                'pays'           => $this->input->post('pays') ?: 'Algérie',
                'rc'             => $this->input->post('rc'),
                'nif'            => $this->input->post('nif'),
                'ais'            => $this->input->post('ais'),
                'statut'         => 'prospect', // Statut par défaut
                'created_by'     => $this->session->userdata('user_id') ?: 1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s')
            );

            // Vérifier si un projet est associé
            $projet_id = $this->input->post('projet_id');

            try {
                // Insérer le client
                $client_id = $this->crm->addClient($data);

                if ($client_id) {
                    // Si un projet est associé, créer le lien
                    if (!empty($projet_id)) {
                        $this->crm->insertClientProject($client_id, $projet_id);
                    }

                    $this->session->set_flashdata('success', 'Client ajouté avec succès !');
                    redirect('crm-clients');
                } else {
                    $this->session->set_flashdata('error', 'Erreur lors de l\'enregistrement du client');
                    redirect('crm-clients');
                }
            } catch (Exception $e) {
                log_message('error', 'Erreur addClient: ' . $e->getMessage());
                $this->session->set_flashdata('error', 'Erreur système: ' . $e->getMessage());
                redirect('crm-clients');
            }
        }
    }

    // Mettre à jour un client
    public function updateClient()
    {
        if ($this->input->method() !== 'post') {
            redirect('crm-clients');
            return;
        }

        $client_id = $this->input->post('client_id');

        if (!$client_id) {
            $this->session->set_flashdata('error', 'ID client manquant');
            redirect('crm-clients');
            return;
        }

        // Validation
        $config = array(
            array(
                'field' => 'type_client',
                'label' => 'Type de Client',
                'rules' => 'required|in_list[entreprise,particulier,public]'
            ),
            array(
                'field' => 'raison_sociale',
                'label' => 'Raison Sociale',
                'rules' => 'required|min_length[3]'
            ),
            array(
                'field' => 'telephone',
                'label' => 'Téléphone',
                'rules' => 'required|min_length[8]'
            ),
            array(
                'field' => 'ville',
                'label' => 'Ville',
                'rules' => 'required'
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Veuillez corriger les erreurs du formulaire');
            redirect('crm-clients');
        } else {
            // Données à mettre à jour
            $data = array(
                'type_client'    => $this->input->post('type_client'),
                'categorie'      => $this->input->post('categorie') ?: 'C',
                'raison_sociale' => $this->input->post('raison_sociale'),
                'nom_commercial' => $this->input->post('nom_commercial'),
                'email'          => $this->input->post('email'),
                'telephone'      => $this->input->post('telephone'),
                'adresse'        => $this->input->post('adresse'),
                'ville'          => $this->input->post('ville'),
                'code_postal'    => $this->input->post('code_postal'),
                'pays'           => $this->input->post('pays') ?: 'Algérie',
                'rc'             => $this->input->post('rc'),
                'nif'            => $this->input->post('nif'),
                'ais'            => $this->input->post('ais'),
                'statut'         => $this->input->post('statut') ?: 'prospect',
                'updated_at'     => date('Y-m-d H:i:s')
            );

            $projet_id = $this->input->post('projet_id');

            try {
                // Mettre à jour le client
                $updated = $this->crm->updateClient($client_id, $data);

                if ($updated) {
                    // Mettre à jour la liaison projet si nécessaire
                    if (!empty($projet_id)) {
                        // Supprimer l'ancienne liaison
                        $this->db->where('client_id', $client_id);
                        $this->db->delete('tbl_client_projet');

                        // Créer la nouvelle liaison
                        $this->crm->insertClientProject($client_id, $projet_id);
                    } else {
                        // Supprimer la liaison si aucun projet sélectionné
                        $this->db->where('client_id', $client_id);
                        $this->db->delete('tbl_client_projet');
                    }

                    $this->session->set_flashdata('success', 'Client modifié avec succès !');
                } else {
                    $this->session->set_flashdata('error', 'Erreur lors de la modification');
                }

                redirect('crm-clients');
            } catch (Exception $e) {
                log_message('error', 'Erreur updateClient: ' . $e->getMessage());
                $this->session->set_flashdata('error', 'Erreur système: ' . $e->getMessage());
                redirect('crm-clients');
            }
        }
    }

    // Supprimer un client
    public function deleteClient($id)
    {
        if (!$id) {
            redirect('crm-clients');
            return;
        }

        try {
            $deleted = $this->crm->hardDeleteClient($id);

            if ($deleted) {
                $this->session->set_flashdata('success', 'Client supprimé avec succès !');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de la suppression');
            }
        } catch (Exception $e) {
            log_message('error', 'Erreur deleteClient: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Erreur système');
        }

        redirect('crm-clients');
    }

    public function projets()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Projets CRM';

        // Récupérer les statistiques
        $data['stats'] = $this->crm->getProjectStats();

        // Récupérer tous les projets
        $data['projects'] = $this->crm->getAllProjects();

        // Récupérer tous les clients pour les filtres
        $this->db->select('id, raison_sociale');
        $this->db->from('tbl_clients');
        $this->db->where('deleted_at IS NULL');
        $data['clients_list'] = $this->db->get()->result();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/crm/crm-projets', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function chantiers()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Chantiers & Avancement';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/crm/crm-chantiers');
        $this->load->view('v1/components/layout/footer');
    }

    public function reporting()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Reporting & Statistiques';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/crm/crm-reporting');
        $this->load->view('v1/components/layout/footer');
    }

    public function devis()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Devis';

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/crm/crm-devis');
        $this->load->view('v1/components/layout/footer');
    }
}
