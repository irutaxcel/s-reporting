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

    public function projects()
    {

        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Projets';

        $project_ref = $this->tech->generateProjectReference();

        $allProject = $this->tech->getAllProject();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view(
            'v1/components/modules/technique/projects',
            ['project_ref' => $project_ref, 'allProject' => $allProject]
        );
        $this->load->view('v1/components/layout/footer');
    }

    public function project_store()
    {
        $data = [
            'company_id' => 2,
            'name'       => $this->input->post('name', true),
            'reference'  => $this->input->post('reference', true),
            'status'     => $this->input->post('status', true),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $insertion = $this->tech->insertProject($data);

        if ($insertion) {

            $this->session->set_flashdata('success', 'Projet enregistré avec succès.');
        } else {
            $this->session->set_flashdata('error', 'Erreur de Insertion');
        }
        redirect('projects');
    }

    public function projectEditAjax()
    {
        $id = $this->input->post('id');

        $project = $this->tech->getProjectById($id);

        echo json_encode($project);
    }

    public function projectUpdate()
    {
        $id = $this->input->post('id', TRUE);

        $data = [
            'name'   => $this->input->post('name', TRUE),
            'status' => $this->input->post('status', TRUE),
        ];

        if ($this->tech->updateProject($id, $data)) {
            $this->session->set_flashdata('success', 'Projet modifié avec succès.');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de la modification du projet.');
        }

        redirect('projects');
    }

    public function projectDeleteAjax()
    {
        $id = $this->input->post('id');

        if ($this->tech->deleteProject($id)) {
            echo json_encode([
                'status' => true,
                'message' => 'Projet supprimé avec succès.'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Impossible de supprimer ce projet.'
            ]);
        }
    }

    public function chantiers()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Chantiers & exécution';

        $allProject = $this->tech->getAllProject();

        $reference = $this->tech->generateChantierReference();

        $allChantier = $this->tech->getAllChantiers();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view(
            'v1/components/modules/technique/chantiers',
            ['allProject' => $allProject, 'reference' => $reference, 'allChantier' => $allChantier]
        );
        $this->load->view('v1/components/layout/footer');
    }

    public function storeChantier()
    {
        $this->load->model('TechModel', 'tech');

        $data = [
            'company_id'       => 2, // ou $this->session->userdata('company_id')
            'project_id'       => $this->input->post('projet_id'),
            'ref_chantier'     => $this->input->post('reference'),
            'name'             => $this->input->post('nom_chantier'),
            'chef_chantier'    => $this->input->post('chef_chantier'),
            'location'         => $this->input->post('localisation'),
            'budget'           => $this->input->post('budget') ?: 0,
            'date_debut'       => $this->input->post('date_debut') ?: null,
            'date_fin_prevue'  => $this->input->post('date_fin_prevue') ?: null,
            'status'           => $this->input->post('etat'),
            'created_at'       => date('Y-m-d H:i:s')
        ];

        $insert = $this->tech->insertChantier($data);

        if ($insert) {
            $this->session->set_flashdata('success', 'Chantier enregistré avec succès.');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de l’enregistrement du chantier.');
        }

        redirect('chantiers');
    }

    public function getChantier()
    {
        $id = $this->input->post('id');

        $this->load->model('TechModel', 'tech');

        echo json_encode(
            $this->tech->getChantierById($id)
        );
    }

    public function updateChantier()
    {
        $this->load->model('TechModel', 'tech');

        $id = $this->input->post('id');

        $data = [
            'project_id'      => $this->input->post('projet_id'),
            'ref_chantier'    => $this->input->post('reference'),
            'name'            => $this->input->post('nom_chantier'),
            'chef_chantier'   => $this->input->post('chef_chantier'),
            'location'        => $this->input->post('localisation'),
            'budget'          => $this->input->post('budget') ?: 0,
            'date_debut'      => $this->input->post('date_debut') ?: null,
            'date_fin_prevue' => $this->input->post('date_fin_prevue') ?: null,
            'status'          => $this->input->post('etat')
        ];

        $update = $this->tech->updateChantier($id, $data);

        if ($update) {
            $this->session->set_flashdata('success', 'Chantier modifié avec succès.');
        } else {
            $this->session->set_flashdata('error', 'Aucune modification effectuée ou erreur.');
        }

        redirect('chantiers');
    }


    public function deleteChantierAjax()
    {
        $id = $this->input->post('id');

        $this->load->model('TechModel', 'tech');

        if ($this->tech->deleteChantier($id)) {

            echo json_encode([
                'status' => true,
                'message' => 'Chantier supprimé avec succès.'
            ]);
        } else {

            echo json_encode([
                'status' => false,
                'message' => 'Erreur lors de la suppression.'
            ]);
        }
    }

    public function subTraitant()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Sous-traitants';

        $allSubTraitant = $this->tech->getAllSubTraitant();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view(
            'v1/components/modules/technique/subTraitant',
            [
                'allSubTraitant' => $allSubTraitant
            ]
        );
        $this->load->view('v1/components/layout/footer');
    }

    public function store_subcontractor()
    {
        $this->load->model('TechModel', 'tech');

        $data = array(
            'company_id'    => $this->input->post('company_id'),
            'name'          => $this->input->post('name'),
            'contact_name'  => $this->input->post('contact_name'),
            'specialty'    => $this->input->post('speciality'),
            'phone'         => $this->input->post('phone'),
            'email'         => $this->input->post('email'),
            'status'        => $this->input->post('status'),
            'created_at'    => date('Y-m-d H:i:s')
        );

        $this->tech->insert_subcontractor($data);

        $this->session->set_flashdata('success', 'Sous-traitant enregistré avec succès.');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_subcontractor()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $this->load->model('TechModel', 'tech');

        $id = $this->input->post('id');

        $data = array(
            'name'         => $this->input->post('name'),
            'contact_name' => $this->input->post('contact_name'),
            'specialty'    => $this->input->post('speciality'),
            'phone'        => $this->input->post('phone'),
            'email'        => $this->input->post('email'),
            'status'       => $this->input->post('status')
        );

        $this->tech->update_subcontractor($id, $data);

        $this->session->set_flashdata('success', 'Sous-traitant modifié avec succès.');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_subcontractor($id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $this->tech->delete_subcontractor($id);

        $this->session->set_flashdata(
            'success',
            'Sous-traitant supprimé avec succès.'
        );

        redirect($_SERVER['HTTP_REFERER']);
    }



    public function stockGeneral()
    {
        $this->load->model('TechModel', 'tech');

        $article_id = $this->input->get('article_id');
        $emplacement_id = $this->input->get('emplacement_id');

        $data['title'] = 'Stocks';

        $data['articles'] = $this->tech->get_articles();
        $data['emplacements'] = $this->tech->get_emplacements();

        $data['stocks'] = $this->tech->get_stock_general_filtered($article_id, $emplacement_id);
        $data['totaux_articles'] = $this->tech->get_total_stock_by_article();
        $data['stats'] = $this->tech->get_stock_stats();

        $data['filter_article_id'] = $article_id;
        $data['filter_emplacement_id'] = $emplacement_id;

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/technique/stockGeneral', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function stockArticleStore()
    {
        $this->load->model('TechModel', 'tech');

        $data = [
            'code_article' => $this->input->post('code_article'),
            'designation'  => $this->input->post('designation'),
            'unite'        => $this->input->post('unite'),
            'categorie'   => $this->input->post('categorie'),
        ];

        $this->tech->insert_article($data);

        $this->session->set_flashdata('success', 'Article créé avec succès');
        redirect('stock-general');
    }

    public function stockEmplacementStore()
    {
        $this->load->model('TechModel', 'tech');

        $data = [
            'nom_emplacement' => $this->input->post('nom_emplacement'),
            'description'    => $this->input->post('description'),
        ];

        $this->tech->insert_emplacement($data);

        $this->session->set_flashdata('success', 'Emplacement créé avec succès');
        redirect('stock-general');
    }

    public function stockQuantiteStore()
    {
        $this->load->model('TechModel', 'tech');

        $data = [
            'article_id'     => $this->input->post('article_id'),
            'emplacement_id' => $this->input->post('emplacement_id'),
            'quantite'       => $this->input->post('quantite'),
        ];

        $this->tech->insert_quantite_stock($data);

        $this->session->set_flashdata('success', 'Quantité ajoutée au stock');
        redirect('stock-general');
    }

    public function achatMateriels()
    {

        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Achats & Approvisionnement';

        $allChantiers = $this->tech->getAllChantier();

        $allAchats = $this->tech->getAllAchats();

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view(
            'v1/components/modules/technique/achatMateriels',
            [
                'allChantiers' => $allChantiers,
                'allAchats'    => $allAchats
            ]
        );
        $this->load->view('v1/components/layout/footer');
    }

    public function store_achat_materiel()
    {
        // $this->load->model('TechModel');

        $chantier_id = $this->input->post('chantier_id');
        $chantier = $this->tech->getChantierById($chantier_id);
        $demande_par    = $this->input->post('demande_par');
        $charge_achat   = $this->input->post('charge_achat');
        $verifie_par    = $this->input->post('verifie_par');
        $total_general  = $this->input->post('total_general');

        $articles       = $this->input->post('article');
        $quantites      = $this->input->post('quantite');
        $prix_unitaires = $this->input->post('prix_unitaire');
        $totaux_lignes  = $this->input->post('total_ligne');

        $data_form = [

            'company_id'            => 2,

            'chantier_id'           => $chantier->id,

            'destination_chantier'  => $chantier->name,

            'requested_by'          => $demande_par,

            'buyer_name'            => $charge_achat,

            'category_type'         => 'chantier',

            'requires_validation'   => 1,

            'total_amount'          => $total_general,

            'verified_by'           => $verifie_par,

            'technical_approver'    => 'Directeur Technique',

            'financial_approver'    => 'Directrice Administrative et Financière',

            'dg_approver'           => 'Directeur Général',

            'treasurer_name'        => 'Trésorier',

            'verifier_status'       => 'en_attente',

            'technical_status'      => 'en_attente',

            'financial_status'      => 'en_attente',

            'dg_status'             => 'en_attente',

            'treasury_status'       => 'en_attente',

            'request_date'          => date('Y-m-d'),

            'workflow_status'       => 'en_attente',

            'created_by'           => $this->session->userdata('user_id'),

            'created_at'            => date('Y-m-d H:i:s')

        ];

        $insert = $this->tech->insert_achat_materiel_form(
            $data_form,
            $articles,
            $quantites,
            $prix_unitaires,
            $totaux_lignes
        );

        if ($insert) {
            $this->session->set_flashdata('success', 'Demande d’achat enregistrée avec succès.');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de l’enregistrement.');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function valider_achat()
    {
        // $this->load->model('TechModel');

        $id    = $this->input->post('id');
        $champ = $this->input->post('champ');

        $champs_autorises = [
            'technical_status',
            'financial_status',
            'treasury_status'
        ];

        if (!in_array($champ, $champs_autorises)) {
            echo json_encode(['status' => 'error']);
            return;
        }

        $update = $this->tech->validerAchat($id, $champ);

        echo json_encode([
            'status' => $update ? 'success' : 'error'
        ]);
    }

    public function get_achat_materiel($id)
    {
        $this->load->model('TechModel');

        $achat = $this->TechModel->getAchatById($id);
        $items = $this->TechModel->getAchatItems($id);

        echo json_encode([
            'achat' => $achat,
            'items' => $items
        ]);
    }

    public function update_achat_materiel()
    {
        $this->load->model('TechModel');

        $id            = $this->input->post('id');
        $chantier_id   = $this->input->post('chantier_id');
        $demande_par   = $this->input->post('demande_par');
        $charge_achat  = $this->input->post('charge_achat');
        $verifie_par   = $this->input->post('verifie_par');
        $total_general = $this->input->post('total_general');

        $chantier = $this->TechModel->getChantierById($chantier_id);

        $data_form = [
            'chantier_id'           => $chantier_id,
            'destination_chantier'  => $chantier ? $chantier->name : '',
            'requested_by'          => $demande_par,
            'buyer_name'            => $charge_achat,
            'total_amount'          => $total_general,
            'verified_by'           => $verifie_par
        ];

        $articles       = $this->input->post('article');
        $quantites      = $this->input->post('quantite');
        $prix_unitaires = $this->input->post('prix_unitaire');
        $totaux_lignes  = $this->input->post('total_ligne');

        $update = $this->TechModel->updateAchatMateriel(
            $id,
            $data_form,
            $articles,
            $quantites,
            $prix_unitaires,
            $totaux_lignes
        );

        $this->session->set_flashdata(
            $update ? 'success' : 'error',
            $update ? 'Demande modifiée avec succès.' : 'Erreur lors de la modification.'
        );

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_achat_materiel()
    {
        $this->load->model('TechModel');

        $id = $this->input->post('id');

        $delete = $this->TechModel->deleteAchatMateriel($id);

        echo json_encode([
            'status' => $delete ? 'success' : 'error'
        ]);
    }

    public function print_achat($id)
    {
        $achat = $this->tech->getAchatById($id);

        $articles = $this->tech->getAchatItems($id);

        $this->load->view('v1/components/layout/header-print');

        $this->load->view(
            'v1/components/modules/technique/achatPrint',
            [
                'achat' => $achat,
                'articles' => $articles
            ]
        );

        $this->load->view('v1/components/layout/footer-print');
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
