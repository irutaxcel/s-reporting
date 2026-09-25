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

    public function addChantier()
    {
        // Vérifier que c'est une requête POST
        if ($this->input->method() !== 'post') {
            redirect('crm-projets');
            return;
        }

        // Validation
        $config = array(
            array(
                'field' => 'projet_id',
                'label' => 'Projet',
                'rules' => 'required|numeric'
            ),
            array(
                'field' => 'name',
                'label' => 'Nom du Chantier',
                'rules' => 'required|min_length[3]'
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Veuillez corriger les erreurs du formulaire');
            redirect('crm-projets');
        } else {
            // Récupérer les données
            $data = array(
                'projet_id'       => $this->input->post('projet_id'),
                'name'            => $this->input->post('name'),
                'location'        => $this->input->post('location'),
                'chef_chantier'   => $this->input->post('chef_chantier'),
                'date_debut'      => $this->input->post('date_debut') ?: null,
                'date_fin_prevue' => $this->input->post('date_fin_prevue') ?: null,
                'status'          => $this->input->post('status') ?: 'Planifié',
                'budget'          => $this->input->post('budget') ?: 0,
                'avancement'      => $this->input->post('avancement') ?: 0,
                'created_at'      => date('Y-m-d H:i:s')
            );

            try {
                $chantier_id = $this->crm->addChantier($data);

                if ($chantier_id) {
                    $this->session->set_flashdata('success', 'Chantier ajouté avec succès !');
                } else {
                    $this->session->set_flashdata('error', 'Erreur lors de l\'ajout du chantier');
                }

                redirect('crm-projets');
            } catch (Exception $e) {
                log_message('error', 'Erreur addChantier: ' . $e->getMessage());
                $this->session->set_flashdata('error', 'Erreur système: ' . $e->getMessage());
                redirect('crm-projets');
            }
        }
    }

    public function chantiers()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Chantiers & Avancement';

        // Récupérer tous les chantiers avec informations complètes
        $data['chantiers'] = $this->crm->getAllChantiers();

        // Récupérer les statistiques
        $data['stats'] = $this->crm->getChantiersStats();

        // Récupérer tous les projets pour les filtres
        $data['projects'] = $this->crm->getAllProjects();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/crm/crm-chantiers', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function updateProgress()
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Méthode non autorisée');
            redirect('crm-chantiers-avancement');
            return;
        }

        $chantier_id = $this->input->post('chantier_id');
        $avancement = $this->input->post('avancement');
        $statut = $this->input->post('statut');

        if (!$chantier_id || $avancement === null) {
            $this->session->set_flashdata('error', 'Données incomplètes');
            redirect('crm-chantiers-avancement');
            return;
        }

        $data = array(
            'avancement' => $avancement,
            'status' => $statut
        );

        try {
            $this->db->where('id', $chantier_id);
            $this->db->update('tbl_chantiers', $data);

            $this->session->set_flashdata('success', 'Avancement mis à jour avec succès !');
        } catch (Exception $e) {
            log_message('error', 'Erreur updateProgress: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Erreur lors de la mise à jour');
        }

        redirect('crm-chantiers-avancement');
    }

    public function reporting()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Reporting & Statistiques';

        $this->load->model('CrmModel');

        // ---- Filtres (GET) ----
        $date = function ($v) {
            return (is_string($v) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) ? $v : null;
        };
        $filters = [
            'company_id' => $this->session->userdata('company_id') ?: null,
            'date_du'    => $date($this->input->get('du', true)),
            'date_au'    => $date($this->input->get('au', true)),
        ];

        // ---- Portefeuille : tous les projets ----
        $portefeuille = $this->CrmModel->rptGetPortefeuille($filters);

        // ---- Projet affiché : demandé, sinon le plus récent avec devis signé, sinon le plus dépensier ----
        $projetId = (int) $this->input->get('projet_id', true);
        if (!$projetId && !empty($portefeuille)) {
            $avecDevis = array_filter($portefeuille, function ($p) {
                return $p['devis'] > 0;
            });
            if (!empty($avecDevis)) {
                usort($avecDevis, function ($a, $b) {
                    return strcmp($b['created_at'], $a['created_at']);
                });
                $projetId = (int) $avecDevis[0]['id'];
            } else {
                $projetId = (int) $portefeuille[0]['id'];
            }
        }

        $projet       = $projetId ? $this->CrmModel->rptGetProjet($projetId) : null;
        $chantiers    = $projet ? $this->CrmModel->rptGetChantiersDepenses($projetId, $filters) : [];
        $chantiersCrm = $projet ? $this->CrmModel->rptGetChantiersDevis($projetId) : [];
        $chantierIds  = array_column($chantiers, 'id');

        // ---- Export Excel (CSV, séparateur ;) ----
        if ($this->input->get('export') === 'csv' && $projet) {
            $nom = 'rentabilite_' . preg_replace('/[^A-Za-z0-9_-]+/', '_', $projet['reference']) . '_' . date('Ymd') . '.csv';
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $nom . '"');
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Projet', $projet['name'] . ' (' . $projet['reference'] . ')'], ';');
            fputcsv($out, ['Période', ($filters['date_du'] ?: 'début') . ' → ' . ($filters['date_au'] ?: 'aujourd\'hui')], ';');
            fputcsv($out, [], ';');
            fputcsv($out, ['Chantier', 'Référence', 'Chef de chantier', 'Statut', 'Nb achats', 'Achats effectués (BIF)', 'Nb contrats MO', 'Main-d\'œuvre (BIF)', 'Dépenses totales (BIF)'], ';');
            $tA = 0;
            $tM = 0;
            foreach ($chantiers as $c) {
                fputcsv($out, [
                    $c['name'],
                    $c['ref_chantier'],
                    $c['chef_chantier'],
                    $c['status'],
                    $c['nb_achats'],
                    round($c['achats']),
                    $c['nb_contrats'],
                    round($c['main_oeuvre']),
                    round($c['depenses'])
                ], ';');
                $tA += $c['achats'];
                $tM += $c['main_oeuvre'];
            }
            $cout = array_sum(array_column($chantiersCrm, 'devis_signe'));
            fputcsv($out, ['TOTAL', '', '', '', '', round($tA), '', round($tM), round($tA + $tM)], ';');
            fputcsv($out, [], ';');
            fputcsv($out, ['Coût du projet (devis signés)', round($cout)], ';');
            fputcsv($out, ['Dépenses', round($tA + $tM)], ';');
            fputcsv($out, ['Bénéfice', round($cout - $tA - $tM)], ';');
            fclose($out);
            return;
        }

        $data = [
            'title'        => $title,
            'filters'      => $filters,
            'projetId'     => $projetId,
            'projet'       => $projet,
            'client'       => $projet ? $this->CrmModel->rptGetClientProjet($projetId) : null,
            'portefeuille' => $portefeuille,
            'chantiers'    => $chantiers,
            'chantiersCrm' => $chantiersCrm,
            'achatsDetail' => $this->CrmModel->rptGetAchatsEffectues($chantierIds, $filters),
            'moDetail'     => $this->CrmModel->rptGetMainOeuvreParType($chantierIds, $filters),
            'nonRattaches' => $this->CrmModel->rptGetAchatsNonRattaches($filters),
        ];

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/crm/crm-reporting', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function devis()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Devis';

        // Récupérer tous les projets
        $data['projects'] = $this->crm->getAllProjects();

        // Récupérer tous les devis et contrats
        $data['devis'] = $this->crm->getAllDevis();
        $data['contrats'] = $this->crm->getAllContrats();

        // Récupérer les statistiques
        $data['stats'] = $this->crm->getDevisContratsStats();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/crm/crm-devis', $data);
        $this->load->view('v1/components/layout/footer');
    }

    // Récupérer les chantiers d'un projet (pour AJAX)
    public function chantiersRequest()
    {
        // Headers pour JSON
        header('Content-Type: application/json');

        $project_id = $this->input->get('project_id');

        if (!$project_id) {
            echo json_encode([]);
            return;
        }

        $this->db->select('id, projet_id, name, location, status');
        $this->db->from('tbl_chantiers');
        $this->db->where('projet_id', $project_id);
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('name', 'ASC');

        $chantiers = $this->db->get()->result();

        echo json_encode($chantiers);
    }

    public function addDevis()
    {
        // 1. Vérifier que c'est une requête POST
        if ($this->input->method() !== 'post') {
            redirect('crm-devis');
            return;
        }

        // 2. Configuration de la validation
        $config = array(
            array(
                'field' => 'projet_id',
                'label' => 'Projet',
                'rules' => 'required|numeric',
                'errors' => array('required' => 'Le projet est obligatoire.')
            ),
            array(
                'field' => 'chantier_id',
                'label' => 'Chantier',
                'rules' => 'required|numeric',
                'errors' => array('required' => 'Le chantier est obligatoire.')
            ),
            array(
                'field' => 'reference',
                'label' => 'Référence',
                'rules' => 'required|min_length[3]|is_unique[tbl_devis.reference]',
                'errors' => array(
                    'required' => 'La référence est obligatoire.',
                    'is_unique' => 'Cette référence existe déjà.'
                )
            ),
            array(
                'field' => 'montant',
                'label' => 'Montant',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => array('greater_than' => 'Le montant doit être supérieur à 0.')
            ),
            array(
                'field' => 'date_creation',
                'label' => 'Date de création',
                'rules' => 'required',
                'errors' => array('required' => 'La date de création est obligatoire.')
            ),
            array(
                'field' => 'date_expiration',
                'label' => "Date d'expiration",
                'rules' => 'required',
                'errors' => array('required' => "La date d'expiration est obligatoire.")
            ),
            array(
                'field' => 'statut',
                'label' => 'Statut',
                'rules' => 'required|in_list[en_attente,signe,expire,annule]',
                'errors' => array(
                    'required' => 'Le statut est obligatoire.',
                    'in_list' => 'Le statut doit être valide.'
                )
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() === FALSE) {
            $error_msg = '<ul>';
            foreach ($this->form_validation->error_array() as $error) {
                $error_msg .= '<li>' . $error . '</li>';
            }
            $error_msg .= '</ul>';
            $this->session->set_flashdata('error', $error_msg);
            redirect('crm-devis');
        } else {
            // 3. Gestion de l'upload du fichier PDF (même pattern que RhController)
            $upload_config = [
                'upload_path'   => FCPATH . 'uploads/devis/',
                'allowed_types' => 'pdf',
                'max_size'      => 10240,
                'file_name'     => 'devis_' . time() . '_' . uniqid(),
            ];

            // Créer le dossier s'il n'existe pas (comme dans RhController)
            if (!is_dir($upload_config['upload_path'])) {
                mkdir($upload_config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload');
            $this->upload->initialize($upload_config);

            if (!$this->upload->do_upload('fichier_devis')) {
                $error = $this->upload->display_errors('', '');
                $this->session->set_flashdata('error', 'Erreur upload: ' . $error);
                redirect('crm-devis');
                return;
            }

            // Récupérer le nom du fichier (comme dans RhController)
            $fichier_nom = $this->upload->data('file_name');

            // 4. Préparation des données pour l'insertion en base
            $data = array(
                'projet_id'       => $this->input->post('projet_id'),
                'chantier_id'     => $this->input->post('chantier_id'),
                'reference'       => $this->input->post('reference'),
                'montant'         => $this->input->post('montant'),
                'date_creation'   => $this->input->post('date_creation'),
                'date_signature'  => $this->input->post('date_signature') ?: NULL,
                'date_expiration' => $this->input->post('date_expiration'),
                'statut'          => $this->input->post('statut'),
                'fichier_devis'   => 'uploads/devis/' . $fichier_nom,
                'description'     => $this->input->post('description'),
                'created_at'      => date('Y-m-d H:i:s')
            );

            // 5. Insertion en base de données
            try {
                $devis_id = $this->crm->addDevis($data);

                if ($devis_id) {
                    $this->session->set_flashdata(
                        'success',
                        'Devis enregistré avec succès !<br>' .
                            'Référence: ' . $data['reference']
                    );
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Erreur lors de l\'enregistrement en base de données.'
                    );
                }
            } catch (Exception $e) {
                log_message('error', 'Erreur addDevis: ' . $e->getMessage());
                $this->session->set_flashdata(
                    'error',
                    'Erreur système: ' . $e->getMessage()
                );
            }

            redirect('crm-devis');
        }
    }

    public function addContrat()
    {
        // 1. Vérifier que c'est une requête POST
        if ($this->input->method() !== 'post') {
            redirect('crm-devis');
            return;
        }

        // 2. Configuration de la validation (champs du contrat)
        $config = array(
            array(
                'field' => 'projet_id',
                'label' => 'Projet',
                'rules' => 'required|numeric',
                'errors' => array('required' => 'Le projet est obligatoire.')
            ),
            array(
                'field' => 'chantier_id',
                'label' => 'Chantier',
                'rules' => 'required|numeric',
                'errors' => array('required' => 'Le chantier est obligatoire.')
            ),
            array(
                'field' => 'numero_contrat',
                'label' => 'N° de Contrat',
                'rules' => 'required|min_length[3]|is_unique[tbl_crm_contrats.numero_contrat]',
                'errors' => array(
                    'required' => 'Le numéro de contrat est obligatoire.',
                    'is_unique' => 'Ce numéro de contrat existe déjà.'
                )
            ),
            array(
                'field' => 'type_contrat',
                'label' => 'Type de Contrat',
                'rules' => 'required|in_list[marche_public,gre_a_gre,appel_offres,contrat_prive]',
                'errors' => array(
                    'required' => 'Le type de contrat est obligatoire.',
                    'in_list' => 'Le type de contrat doit être valide.'
                )
            ),
            array(
                'field' => 'montant',
                'label' => 'Montant',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => array('greater_than' => 'Le montant doit être supérieur à 0.')
            ),
            array(
                'field' => 'date_signature',
                'label' => 'Date de signature',
                'rules' => 'required',
                'errors' => array('required' => 'La date de signature est obligatoire.')
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() === FALSE) {
            $error_msg = '<ul>';
            foreach ($this->form_validation->error_array() as $error) {
                $error_msg .= '<li>' . $error . '</li>';
            }
            $error_msg .= '</ul>';
            $this->session->set_flashdata('error', $error_msg);
            redirect('crm-devis');
            return;
        }

        // 3. Construction et validation métier des tranches de paiement.
        //    On fait ça AVANT l'upload du fichier : si les tranches sont invalides,
        //    on ne veut pas avoir déjà écrit un PDF sur le disque pour rien.
        //    Important : le montant de chaque tranche n'est JAMAIS pris depuis le
        //    formulaire (le champ envoyé est une chaîne formatée type "300 000.00 DA",
        //    calculée en JS et inexploitable pour une colonne decimal) — il est
        //    toujours recalculé ici à partir du montant du contrat.
        $montantContrat = (float) $this->input->post('montant');
        $tranches = array();
        $totalPourcentage = 0;
        $numero = 0;

        for ($i = 1; $i <= 5; $i++) {
            $pourcentagePost = $this->input->post("tranche{$i}_pourcentage");

            if ($pourcentagePost === NULL || $pourcentagePost === '' || !is_numeric($pourcentagePost)) {
                continue; // tranche non renseignée
            }

            $pourcentage = (float) $pourcentagePost;

            if ($pourcentage <= 0) {
                continue; // tranche désactivée (0%), on ne l'enregistre pas
            }

            $avancementPost = $this->input->post("tranche{$i}_avancement");
            $condition = trim((string) $this->input->post("tranche{$i}_condition"));

            $numero++;
            $totalPourcentage += $pourcentage;

            $tranches[] = array(
                'numero_tranche'     => $numero,
                'pourcentage'        => $pourcentage,
                'avancement_requis'  => ($avancementPost !== NULL && $avancementPost !== '' && is_numeric($avancementPost))
                    ? (float) $avancementPost
                    : NULL,
                'montant'            => round($montantContrat * $pourcentage / 100, 2),
                'condition_paiement' => $condition !== '' ? $condition : 'avancement',
                'statut'             => 'en_attente',
            );
        }

        // Tolérance de 0.01 pour absorber les arrondis à l'affichage
        if (empty($tranches) || abs($totalPourcentage - 100) > 0.01) {
            $this->session->set_flashdata(
                'error',
                'Le total des tranches de paiement doit être égal à 100% (actuellement ' .
                    number_format($totalPourcentage, 2) . '%).'
            );
            redirect('crm-devis');
            return;
        }

        // 4. Gestion de l'upload du fichier PDF (même pattern que addDevis)
        $upload_config = [
            'upload_path'   => FCPATH . 'uploads/contrats/',
            'allowed_types' => 'pdf',
            'max_size'      => 10240, // 10 MB
            'file_name'     => 'CNT_' . time() . '_' . uniqid(),
        ];

        // Créer le dossier s'il n'existe pas
        if (!is_dir($upload_config['upload_path'])) {
            mkdir($upload_config['upload_path'], 0777, TRUE);
        }

        $this->load->library('upload');
        $this->upload->initialize($upload_config);

        if (!$this->upload->do_upload('fichier_contrat')) {
            $error = $this->upload->display_errors('', '');
            $this->session->set_flashdata('error', 'Erreur upload: ' . $error);
            redirect('crm-devis');
            return;
        }

        // Récupérer le nom et le chemin complet du fichier
        $fichier_nom    = $this->upload->data('file_name');
        $fichier_chemin = FCPATH . 'uploads/contrats/' . $fichier_nom;

        // 5. Préparation des données pour l'insertion en base
        $data = array(
            'projet_id'         => $this->input->post('projet_id'),
            'chantier_id'       => $this->input->post('chantier_id'),
            'numero_contrat'    => $this->input->post('numero_contrat'),
            'type_contrat'      => $this->input->post('type_contrat'),
            'montant'           => $montantContrat,
            'date_signature'    => $this->input->post('date_signature'),
            'date_fin_prevue'   => $this->input->post('date_fin_prevue') ?: NULL,
            'delai_realisation' => $this->input->post('delai_realisation') ?: NULL,
            'fichier_contrat'   => 'uploads/contrats/' . $fichier_nom,
            'clauses'           => $this->input->post('clauses'),
            'statut'            => 'signe', // Par défaut signé car on enregistre un contrat
            'created_at'        => date('Y-m-d H:i:s')
        );

        // 6. Insertion transactionnelle : le contrat ET ses tranches, ou rien.
        //    Si l'insertion des tranches échoue après celle du contrat, tout est annulé.
        try {
            $this->db->trans_start();

            $contrat_id = $this->crm->addContrat($data);

            if ($contrat_id) {
                $this->crm->addContratTranches($contrat_id, $tranches);
            }

            $this->db->trans_complete();

            if ($contrat_id && $this->db->trans_status() !== FALSE) {
                $this->session->set_flashdata(
                    'success',
                    'Contrat enregistré avec succès !<br>' .
                        'N° Contrat: ' . $data['numero_contrat'] . ' — ' .
                        count($tranches) . ' tranche(s) de paiement enregistrée(s).'
                );
            } else {
                // La transaction a échoué : on ne laisse pas le PDF orphelin sur le disque
                if (is_file($fichier_chemin)) {
                    unlink($fichier_chemin);
                }
                log_message('error', 'Erreur addContrat: transaction échouée (contrat + tranches)');
                $this->session->set_flashdata(
                    'error',
                    'Erreur lors de l\'enregistrement en base de données.'
                );
            }
        } catch (Exception $e) {
            if (is_file($fichier_chemin)) {
                unlink($fichier_chemin);
            }
            log_message('error', 'Erreur addContrat: ' . $e->getMessage());
            $this->session->set_flashdata(
                'error',
                'Erreur système: ' . $e->getMessage()
            );
        }

        redirect('crm-devis');
    }

    /**
     * Détails d'un devis, appelé en AJAX par le modal "Voir" de crm-devis.php.
     */
    public function viewDevis($id = null)
    {
        if (!$this->session->userdata('user_id')) {
            $this->_jsonResponse(['error' => 'Non autorisé.'], 401);
            return;
        }

        $devis = $this->crm->getDevisById((int) $id);

        if (!$devis) {
            $this->_jsonResponse(['error' => 'Devis introuvable.'], 404);
            return;
        }

        $this->_jsonResponse([
            'type'  => 'devis',
            'devis' => $devis,
        ]);
    }

    /**
     * Détails d'un contrat et de ses tranches de paiement, appelé en AJAX
     * par le modal "Voir" de crm-devis.php.
     */
    public function viewContrat($id = null)
    {
        if (!$this->session->userdata('user_id')) {
            $this->_jsonResponse(['error' => 'Non autorisé.'], 401);
            return;
        }

        $contrat = $this->crm->getContratById((int) $id);

        if (!$contrat) {
            $this->_jsonResponse(['error' => 'Contrat introuvable.'], 404);
            return;
        }

        $tranches = $this->crm->getContratTranches($contrat->id);

        $this->_jsonResponse([
            'type'     => 'contrat',
            'contrat'  => $contrat,
            'tranches' => $tranches,
        ]);
    }

    /**
     * Petit utilitaire pour répondre en JSON depuis les endpoints AJAX.
     * Préfixée par _ : CodeIgniter ne la rend pas accessible directement par URL.
     */
    private function _jsonResponse($data, $statusCode = 200)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($statusCode)
            ->set_output(json_encode($data));
    }
}
