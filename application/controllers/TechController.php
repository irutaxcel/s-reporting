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
        $this->load->library('upload');
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

        /*
     * Récupération des filtres envoyés par GET
     */
        $filters = [
            'chantier_id' => trim((string) $this->input->get('chantier_id', true)),

            'workflow_status' => trim(
                (string) $this->input->get('workflow_status', true)
            ),

            'date_debut' => trim(
                (string) $this->input->get('date_debut', true)
            ),

            'date_fin' => trim(
                (string) $this->input->get('date_fin', true)
            )
        ];

        /*
     * Liste des chantiers pour le champ select
     */
        $allChantiers = $this->tech->getAllChantier();

        /*
     * Liste des demandes d'achat avec filtres
     */
        $allAchats = $this->tech->getAllAchats($filters);

        /*
     * Données envoyées à la vue
     */
        $data = [
            'title'         => $title,
            'allChantiers' => $allChantiers,
            'allAchats'    => $allAchats,
            'filters'      => $filters
        ];

        $this->load->view(
            'v1/components/layout/header',
            [
                'title' => $title
            ]
        );

        $this->load->view(
            'v1/components/layout/sidebar'
        );

        $this->load->view(
            'v1/components/modules/technique/achatMateriels',
            $data
        );

        $this->load->view(
            'v1/components/layout/footer'
        );
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
        $observation_line    = $this->input->post('observation');

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
            $observation_line,
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
        $observation   = $this->input->post('observation');

        $update = $this->TechModel->updateAchatMateriel(
            $id,
            $data_form,
            $articles,
            $quantites,
            $prix_unitaires,
            $totaux_lignes,
            $observation
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

    public function storeBonPaiement()
    {

        $last = $this->tech->getLastPaymentVoucher();

        $numero = $last ? $last->id + 1 : 1;

        $paymentNumber = 'BP-'
            . date('Y')
            . '-'
            . str_pad($numero, 6, '0', STR_PAD_LEFT);

        $data = [

            'company_id'         => $this->session->userdata('company_id'),

            'request_id'         => $this->input->post('request_id'),

            'payment_number'     => $paymentNumber,

            'summary'            => $this->input->post('summary'),

            'payment_mode'       => $this->input->post('payment_mode'),

            'amount_paid'        => $this->input->post('amount_paid'),

            'payment_reference'  => $this->input->post('payment_reference'),

            'payment_date'       => $this->input->post('payment_date'),

            'observation'        => $this->input->post('observation'),

            'payment_status'     => 'en_attente',

            'created_by'         => $this->session->userdata('user_id')

        ];

        $this->db->insert(
            'purchase_payment_vouchers',
            $data
        );

        $this->session->set_flashdata(
            'success',
            'Bon de paiement enregistré avec succès.'
        );

        redirect('achat');
    }

    public function print_achat($id)
    {
        $achat = $this->tech->getAchatById($id);

        $articles = $this->tech->getAchatItems($id);

        /*
        * Bon de paiement lié à la demande
        */
        $bonPaiement = $this->tech->getPaymentVoucherByRequestId($id);

        $this->load->view('v1/components/layout/header-print');

        $this->load->view(
            'v1/components/modules/technique/achatPrint',
            [
                'achat' => $achat,
                'articles' => $articles,
                'bonPaiement'  => $bonPaiement
            ]
        );

        $this->load->view('v1/components/layout/footer-print');
    }

    public function get_bon_paiement($id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }

        $id = (int) $id;

        $bonPaiement = $this->tech->getPaymentVoucherById($id);

        if (!$bonPaiement) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'Bon de paiement introuvable.'
                ]));
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'bon'    => $bonPaiement
            ]));
    }

    public function update_bon_paiement()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $id = (int) $this->input->post(
            'payment_voucher_id',
            true
        );

        if ($id <= 0) {

            $this->session->set_flashdata(
                'error',
                'Bon de paiement invalide.'
            );

            redirect('achat');
            return;
        }

        $bonPaiement = $this->tech
            ->getPaymentVoucherById($id);

        if (!$bonPaiement) {

            $this->session->set_flashdata(
                'error',
                'Le bon de paiement est introuvable.'
            );

            redirect('achat');
            return;
        }

        $this->form_validation->set_rules(
            'summary',
            'Synthèse',
            'required|trim'
        );

        $this->form_validation->set_rules(
            'payment_mode',
            'Mode de paiement',
            'required|trim'
        );

        $this->form_validation->set_rules(
            'amount_paid',
            'Montant payé',
            'required|numeric|greater_than[0]'
        );

        $this->form_validation->set_rules(
            'payment_reference',
            'Référence du paiement',
            'required|trim'
        );

        $this->form_validation->set_rules(
            'payment_date',
            'Date de paiement',
            'required|trim'
        );

        if ($this->form_validation->run() === false) {

            $this->session->set_flashdata(
                'error',
                strip_tags(validation_errors())
            );

            redirect('achat');
            return;
        }

        $allowedModes = [
            'especes',
            'cheque',
            'virement_bancaire',
            'transfert_mobile',
            'autre'
        ];

        $allowedStatuses = [
            'en_attente',
            'effectue',
            'annule'
        ];

        $paymentMode = $this->input->post(
            'payment_mode',
            true
        );

        $paymentStatus = $this->input->post(
            'payment_status',
            true
        );

        if (!in_array($paymentMode, $allowedModes, true)) {

            $this->session->set_flashdata(
                'error',
                'Mode de paiement invalide.'
            );

            redirect('achat');
            return;
        }

        if (!in_array($paymentStatus, $allowedStatuses, true)) {
            $paymentStatus = 'effectue';
        }

        $data = [

            'summary' => trim(
                $this->input->post('summary', true)
            ),

            'payment_mode' => $paymentMode,

            'amount_paid' => (float) $this->input->post(
                'amount_paid',
                true
            ),

            'payment_reference' => trim(
                $this->input->post(
                    'payment_reference',
                    true
                )
            ),

            'payment_date' => $this->input->post(
                'payment_date',
                true
            ),

            'payment_status' => $paymentStatus,

            'observation' => trim(
                $this->input->post(
                    'observation',
                    true
                )
            ),

            'updated_at' => date('Y-m-d H:i:s')

        ];

        $updated = $this->tech
            ->updatePaymentVoucher($id, $data);

        if (!$updated) {

            $this->session->set_flashdata(
                'error',
                'La modification du bon a échoué.'
            );

            redirect('achat');
            return;
        }

        $this->session->set_flashdata(
            'success',
            'Le bon de paiement a été modifié avec succès.'
        );

        redirect('achat');
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

    public function chantierPaie()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        // ----- Filtres GET -----
        $filters = [
            'semaine'  => $this->input->get('semaine'),   // valeur = YEARWEEK (ex : 202629)
            'chantier' => $this->input->get('chantier'),
        ];

        $year  = (int) date('Y');
        $month = (int) date('n');

        // ----- Semaines du mois en cours + drapeau mois vide -----
        $weeksMois        = $this->tech->getPaieWeeksOfMonth($year, $month);
        $data['moisVide'] = empty($weeksMois);

        // ----- Semaines à afficher -----
        if (!empty($filters['semaine'])) {
            // Semaine choisie dans le filtre
            $weeks = $this->tech->getPaieWeekByYw($filters['semaine']);
        } elseif (!$data['moisVide']) {
            // Par défaut : semaines du mois en cours
            $weeks = $weeksMois;
        } else {
            // CORRECTION : aucun paiement ce mois-ci → 4 dernières semaines existantes
            $weeks = $this->tech->getAllPaieWeeks(4);
        }

        // ----- Construction : semaine → chantiers → personnel -----
        $paieSemaines = [];
        $totalGeneral = 0;

        foreach ($weeks as $w) {
            $contracts = $this->tech->getPaieContracts($w->yw, $filters['chantier']);
            if (empty($contracts)) continue;

            $byChantier   = [];
            $totalSemaine = 0;

            foreach ($contracts as $ct) {
                $key = $ct->chantier_id ?: 0;
                $byChantier[$key]['name']   = $ct->chantier_name ?: 'Sans chantier';
                $byChantier[$key]['rows'][] = $ct;
                $byChantier[$key]['total']  = ($byChantier[$key]['total'] ?? 0) + (float) $ct->unit_rate;
                $totalSemaine += (float) $ct->unit_rate;
            }

            $paieSemaines[] = [
                'yw'         => $w->yw,
                'week_start' => $w->week_start,
                'week_end'   => $w->week_end,
                'chantiers'  => $byChantier,
                'total'      => $totalSemaine,
            ];
            $totalGeneral += $totalSemaine;
        }

        // ----- Options du select "Semaine" (optgroup par mois, selon created_at) -----
        $moisFr = [
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre'
        ];

        $weekOptions = [];
        foreach ($this->tech->getAllPaieWeeks(24) as $w) {
            $m = (int) date('n', strtotime($w->first_date));
            $weekOptions[$moisFr[$m]][] = [
                'yw'    => $w->yw,
                'label' => 'Semaine du ' . date('d/m', strtotime($w->week_start))
                    . ' au ' . date('d/m/Y', strtotime($w->week_end)),
            ];
        }

        // ----- Données pour la vue -----
        $data['title']         = 'Suivie Paie Chantier';
        $data['filters']       = $filters;
        $data['allChantiers']  = $this->tech->getAllChantier();
        $data['weekOptions']   = $weekOptions;
        $data['paieSemaines']  = $paieSemaines;
        $data['totalGeneral']  = $totalGeneral;

        // Tuiles
        $data['totalCumul']      = $this->tech->sumPaieAll();
        $data['totalMois']       = $this->tech->sumPaieMonth($year, $month);
        $data['nbEnAttente']     = $this->tech->countPaieEnAttente();
        $data['nbChantiersMois'] = $this->tech->countChantiersPaieMonth($year, $month);

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/technique/chantierPaie', $data);
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

    public function enginMateriel()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['title'] = 'Engin & Materiel';

        $data['categories'] = $this->tech->getDatas();

        $data['chantiers'] = $this->tech->getAllChantier();

        $annee = date('Y');
        $prefixe = 'ENG';

        $codeData = $this->db
            ->where('prefixe', $prefixe)
            ->where('annee', $annee)
            ->get('tbl_engin_code')
            ->row();

        if (!$codeData) {

            $this->db->insert('tbl_engin_code', [
                'prefixe' => $prefixe,
                'annee' => $annee,
                'dernier_numero' => 0
            ]);

            $dernierNumero = 0;
        } else {

            $dernierNumero = $codeData->dernier_numero;
        }

        $nouveauNumero = $dernierNumero + 1;

        $data['codeEngin'] = $prefixe . '-' .
            $annee . '-' .
            str_pad($nouveauNumero, 5, '0', STR_PAD_LEFT);

        $data['allEngins'] = $this->tech->getAllEngins();

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/technique/enginMateriel', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    private function uploadMultipleFiles($inputName, $uploadPath, $allowedTypes, $table, $column, $enginId)
    {
        if (empty($_FILES[$inputName]['name'][0])) {
            return;
        }

        $count = count($_FILES[$inputName]['name']);

        for ($i = 0; $i < $count; $i++) {

            $_FILES['file']['name']     = $_FILES[$inputName]['name'][$i];
            $_FILES['file']['type']     = $_FILES[$inputName]['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES[$inputName]['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES[$inputName]['error'][$i];
            $_FILES['file']['size']     = $_FILES[$inputName]['size'][$i];

            $config = [
                'upload_path'   => $uploadPath,
                'allowed_types' => $allowedTypes,
                'encrypt_name'  => true
            ];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $upload = $this->upload->data();

                $this->tech->insertData($table, [
                    'engin_id'   => $enginId,
                    $column      => $upload['file_name'],
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    private function updateEnginCode($codeEngin)
    {
        $parts = explode('-', $codeEngin);

        if (count($parts) < 3) {
            return;
        }

        $prefixe = $parts[0];
        $annee = $parts[1];
        $nouveauNumero = (int) $parts[2];

        $this->tech->updateData(
            'tbl_engin_code',
            [
                'prefixe' => $prefixe,
                'annee'  => $annee
            ],
            [
                'dernier_numero' => $nouveauNumero,
                'updated_at'     => date('Y-m-d H:i:s')
            ]
        );
    }

    public function enginMaterielStore()
    {
        $this->load->library('upload');

        $codeEngin = $this->input->post('code_engin');

        $data = [
            'code_engin'       => $codeEngin,
            'designation'      => $this->input->post('designation'),
            'categorie_id'     => $this->input->post('categorie_id'),
            'marque'           => $this->input->post('marque'),
            'modele'           => $this->input->post('modele'),
            'plaque'           => $this->input->post('plaque'),
            'numero_serie'     => $this->input->post('numero_serie'),
            'date_acquisition' => $this->input->post('date_acquisition') ?: null,
            'valeur_achat'     => $this->input->post('valeur_achat') ?: 0,
            'etat'             => $this->input->post('etat'),
            'localisation'     => $this->input->post('localisation'),
            'chantier_id'      => $this->input->post('chantier_id') ?: null,
            'observation'      => $this->input->post('observation'),
            'status'           => 1,
            'created_at'       => date('Y-m-d H:i:s')
        ];

        $enginId = $this->tech->insertData('tbl_engin_materiel', $data);

        if (!$enginId) {
            $this->session->set_flashdata('error', 'Erreur lors de l’enregistrement.');
            redirect('engin-materiel');
        }

        $this->uploadMultipleFiles(
            'photos',
            './uploads/engins/photos/',
            'jpg|jpeg|png|webp',
            'tbl_engin_photo',
            'photo',
            $enginId
        );

        $this->uploadMultipleFiles(
            'documents',
            './uploads/engins/documents/',
            'pdf|doc|docx|xls|xlsx|jpg|jpeg|png',
            'tbl_engin_document',
            'document',
            $enginId
        );

        $this->updateEnginCode($codeEngin);

        $this->session->set_flashdata('success', 'Engin enregistré avec succès.');
        redirect('engin-materiel');
    }


    public function enginMaterielFiles()
    {
        $engin_id = $this->input->post('engin_id');

        $photos = $this->db
            ->where('engin_id', $engin_id)
            ->get('tbl_engin_photo')
            ->result();

        $documents = $this->db
            ->where('engin_id', $engin_id)
            ->get('tbl_engin_document')
            ->result();

        echo json_encode([
            'photos' => $photos,
            'documents' => $documents
        ]);
    }


    public function enginPhotoDelete()
    {
        $id = $this->input->post('id');

        $photo = $this->db->where('id', $id)->get('tbl_engin_photo')->row();

        if ($photo) {
            $path = './uploads/engins/photos/' . $photo->photo;

            if (file_exists($path)) {
                unlink($path);
            }

            $this->db->where('id', $id)->delete('tbl_engin_photo');
        }

        echo json_encode(['status' => 'success']);
    }

    public function enginDocumentDelete()
    {
        $id = $this->input->post('id');

        $doc = $this->db->where('id', $id)->get('tbl_engin_document')->row();

        if ($doc) {
            $path = './uploads/engins/documents/' . $doc->document;

            if (file_exists($path)) {
                unlink($path);
            }

            $this->db->where('id', $id)->delete('tbl_engin_document');
        }

        echo json_encode(['status' => 'success']);
    }

    private function uploadEnginFiles(
        $inputName,
        $uploadPath,
        $allowedTypes,
        $table,
        $column,
        $enginId
    ) {
        if (
            empty($_FILES[$inputName]) ||
            empty($_FILES[$inputName]['name'][0])
        ) {
            return;
        }

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $this->load->library('upload');

        $fileCount = count($_FILES[$inputName]['name']);

        for ($i = 0; $i < $fileCount; $i++) {

            if ($_FILES[$inputName]['error'][$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            $_FILES['engin_file'] = [
                'name'     => $_FILES[$inputName]['name'][$i],
                'type'     => $_FILES[$inputName]['type'][$i],
                'tmp_name' => $_FILES[$inputName]['tmp_name'][$i],
                'error'    => $_FILES[$inputName]['error'][$i],
                'size'     => $_FILES[$inputName]['size'][$i]
            ];

            $config = [
                'upload_path'      => $uploadPath,
                'allowed_types'    => $allowedTypes,
                'encrypt_name'     => true,
                'remove_spaces'    => true,
                'max_size'         => 10240,
                'file_ext_tolower' => true
            ];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('engin_file')) {
                $uploadedFile = $this->upload->data();

                $this->tech->insertData(
                    $table,
                    [
                        'engin_id'   => $enginId,
                        $column      => $uploadedFile['file_name'],
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );
            } else {
                log_message(
                    'error',
                    'Erreur upload ' . $inputName . ' : ' .
                        strip_tags($this->upload->display_errors('', ''))
                );
            }

            unset($_FILES['engin_file']);
        }
    }


    public function enginMaterielUpdate()
    {
        $enginId = (int) $this->input->post('id');

        if ($enginId <= 0) {
            $this->session->set_flashdata(
                'error',
                'Identifiant de l’engin invalide.'
            );

            redirect('engin-materiel');
            return;
        }

        $dateAcquisition = $this->input->post('date_acquisition');
        $chantierId = $this->input->post('chantier_id');
        $valeurAchat = $this->input->post('valeur_achat');

        $data = [
            'designation'      => trim($this->input->post('designation')),
            'categorie_id'     => (int) $this->input->post('categorie_id'),
            'marque'           => trim($this->input->post('marque')),
            'modele'           => trim($this->input->post('modele')),
            'plaque'           => trim($this->input->post('plaque')),
            'numero_serie'     => trim($this->input->post('numero_serie')),
            'date_acquisition' => !empty($dateAcquisition) ? $dateAcquisition : null,
            'valeur_achat'     => !empty($valeurAchat) ? $valeurAchat : 0,
            'etat'             => $this->input->post('etat'),
            'localisation'     => trim($this->input->post('localisation')),
            'chantier_id'      => !empty($chantierId) ? (int) $chantierId : null,
            'observation'      => trim($this->input->post('observation')),
            'updated_at'       => date('Y-m-d H:i:s')
        ];

        $updated = $this->tech->updateData(
            'tbl_engin_materiel',
            ['id' => $enginId],
            $data
        );

        if (!$updated) {
            $this->session->set_flashdata(
                'error',
                'La modification de l’engin a échoué.'
            );

            redirect('engin-materiel');
            return;
        }

        /*
    |--------------------------------------------------------------------------
    | Ajout des nouvelles photos
    |--------------------------------------------------------------------------
    */

        $this->uploadEnginFiles(
            'photos',
            './uploads/engins/photos/',
            'jpg|jpeg|png|webp',
            'tbl_engin_photo',
            'photo',
            $enginId
        );

        /*
    |--------------------------------------------------------------------------
    | Ajout des nouveaux documents
    |--------------------------------------------------------------------------
    */

        $this->uploadEnginFiles(
            'documents',
            './uploads/engins/documents/',
            'pdf|doc|docx|xls|xlsx|jpg|jpeg|png',
            'tbl_engin_document',
            'document',
            $enginId
        );

        $this->session->set_flashdata(
            'success',
            'Engin / matériel modifié avec succès.'
        );

        redirect('engin-materiel');
    }

    public function maintenanceCarburant()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['title'] = 'Maintenance & Carburant';

        $data['chantiers'] = $this->tech->getAllChantier();
        $data['allEngins'] = $this->tech->getAllEngins();

        $data['allEnginsWithFuel'] =
            $this->tech->getAllEnginsWithFuel(10);

        $data['allMaintenances'] =
            $this->tech->getAllMaintenances(10);

        $data['maintenanceAlerts'] =
            $this->tech->getMaintenanceAlerts(6);

        $data['mostExpensiveEngins'] =
            $this->tech->getMostExpensiveEnginsCurrentMonth(5);

        $data['recentOperations'] =
            $this->tech->getRecentTechnicalOperations(20);

        /*
    |--------------------------------------------------------------------------
    | Statistiques
    |--------------------------------------------------------------------------
    */

        $data['maintenanceFuelStats'] =
            $this->tech->getMaintenanceFuelStatistics();

        $this->load->view(
            'v1/components/layout/header',
            $data
        );

        $this->load->view(
            'v1/components/layout/sidebar',
            $data
        );

        $this->load->view(
            'v1/components/modules/technique/maintenanceCarburant',
            $data
        );

        $this->load->view(
            'v1/components/layout/footer',
            $data
        );
    }

    public function addNewRavitaillement()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $enginId = (int) $this->input->post('engin_id');
        $chantierId = $this->input->post('chantier_id');

        $quantityLitre = (float) $this->input->post('quantity_litre');
        $unitPrice = (float) $this->input->post('unit_price');

        /*
        |--------------------------------------------------------------------------
        | Toujours recalculer côté serveur
        |--------------------------------------------------------------------------
        | Ne pas faire confiance uniquement au total envoyé par JavaScript.
        */

        $totalAmount = $quantityLitre * $unitPrice;

        if ($enginId <= 0) {
            $this->session->set_flashdata(
                'error',
                'Veuillez sélectionner un engin ou un matériel.'
            );

            redirect('maintenance-carburant');
            return;
        }

        if ($quantityLitre <= 0 || $unitPrice <= 0) {
            $this->session->set_flashdata(
                'error',
                'La quantité et le prix par litre doivent être supérieurs à zéro.'
            );

            redirect('maintenance-carburant');
            return;
        }

        $data = [
            'engin_id'       => $enginId,
            'chantier_id'    => !empty($chantierId) ? (int) $chantierId : null,
            'operation_date' => $this->input->post('operation_date'),

            'quantity_litre' => $quantityLitre,
            'unit_price'     => $unitPrice,
            'total_amount'   => $totalAmount,

            'kilometrage'    => $this->input->post('kilometrage') !== ''
                ? (float) $this->input->post('kilometrage')
                : null,

            'hour_meter'     => $this->input->post('hour_meter') !== ''
                ? (float) $this->input->post('hour_meter')
                : null,

            'operator_name'  => trim((string) $this->input->post('operator_name')),
            'supplier'       => trim((string) $this->input->post('supplier')),
            'observation'    => trim((string) $this->input->post('observation')),

            'status'         => 1,
            'created_at'     => date('Y-m-d H:i:s')
        ];

        $fuelId = $this->tech->insertData('tbl_engin_fuel', $data);

        if (!$fuelId) {
            $this->session->set_flashdata(
                'error',
                'Une erreur est survenue pendant l’enregistrement du ravitaillement.'
            );

            redirect('maintenance-carburant');
            return;
        }

        $this->session->set_flashdata(
            'success',
            'Ravitaillement enregistré avec succès.'
        );

        redirect('maintenance-carburant');
    }


    private function uploadMaintenanceDocuments($maintenanceId)
    {
        if (
            empty($_FILES['documents']) ||
            empty($_FILES['documents']['name'][0])
        ) {
            return [
                'success' => true,
                'message' => ''
            ];
        }

        $uploadPath = './uploads/engins/maintenance/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        if (!is_writable($uploadPath)) {
            return [
                'success' => false,
                'message' => 'Le dossier des pièces jointes n’est pas accessible en écriture.'
            ];
        }

        $this->load->library('upload');

        $fileCount = count($_FILES['documents']['name']);

        for ($i = 0; $i < $fileCount; $i++) {

            if ($_FILES['documents']['error'][$i] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            if ($_FILES['documents']['error'][$i] !== UPLOAD_ERR_OK) {
                return [
                    'success' => false,
                    'message' => 'Une pièce jointe contient une erreur d’envoi.'
                ];
            }

            $_FILES['maintenance_file'] = [
                'name'     => $_FILES['documents']['name'][$i],
                'type'     => $_FILES['documents']['type'][$i],
                'tmp_name' => $_FILES['documents']['tmp_name'][$i],
                'error'    => $_FILES['documents']['error'][$i],
                'size'     => $_FILES['documents']['size'][$i]
            ];

            $config = [
                'upload_path'      => $uploadPath,
                'allowed_types'    => 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png',
                'encrypt_name'     => true,
                'remove_spaces'    => true,
                'file_ext_tolower' => true,
                'max_size'         => 10240
            ];

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('maintenance_file')) {
                $error = strip_tags(
                    $this->upload->display_errors('', '')
                );

                unset($_FILES['maintenance_file']);

                return [
                    'success' => false,
                    'message' => 'Erreur pièce jointe : ' . $error
                ];
            }

            $uploadedFile = $this->upload->data();

            $documentData = [
                'maintenance_id' => $maintenanceId,
                'document'       => $uploadedFile['file_name'],
                'original_name'  => $uploadedFile['orig_name'],
                'file_type'      => $uploadedFile['file_type'],
                'file_size'      => (int) $_FILES['documents']['size'][$i],
                'created_at'     => date('Y-m-d H:i:s')
            ];

            $documentId = $this->tech->insertData(
                'tbl_engin_maintenance_document',
                $documentData
            );

            if (!$documentId) {
                $uploadedPath = $uploadPath . $uploadedFile['file_name'];

                if (is_file($uploadedPath)) {
                    unlink($uploadedPath);
                }

                unset($_FILES['maintenance_file']);

                return [
                    'success' => false,
                    'message' => 'Impossible d’enregistrer une pièce jointe dans la base.'
                ];
            }

            unset($_FILES['maintenance_file']);
        }

        return [
            'success' => true,
            'message' => ''
        ];
    }

    public function newTechniqueMaintenance()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $enginId = (int) $this->input->post('engin_id');
        $chantierId = $this->input->post('chantier_id');

        $partsCost = (float) $this->input->post('parts_cost');
        $laborCost = (float) $this->input->post('labor_cost');

        /*
    |--------------------------------------------------------------------------
    | Toujours recalculer côté serveur
    |--------------------------------------------------------------------------
    */

        $totalCost = $partsCost + $laborCost;

        if ($enginId <= 0) {
            $this->session->set_flashdata(
                'error',
                'Veuillez sélectionner un engin ou un matériel.'
            );

            redirect('maintenance-carburant');
            return;
        }

        if (empty($this->input->post('maintenance_type'))) {
            $this->session->set_flashdata(
                'error',
                'Veuillez sélectionner le type de maintenance.'
            );

            redirect('maintenance-carburant');
            return;
        }

        if (empty($this->input->post('intervention'))) {
            $this->session->set_flashdata(
                'error',
                'Veuillez renseigner la nature de l’intervention.'
            );

            redirect('maintenance-carburant');
            return;
        }

        if (empty($this->input->post('planned_date'))) {
            $this->session->set_flashdata(
                'error',
                'Veuillez renseigner la date prévue.'
            );

            redirect('maintenance-carburant');
            return;
        }

        $maintenanceData = [
            'engin_id'             => $enginId,
            'chantier_id'          => !empty($chantierId)
                ? (int) $chantierId
                : null,

            'maintenance_type'     => trim(
                (string) $this->input->post('maintenance_type')
            ),

            'intervention'         => trim(
                (string) $this->input->post('intervention')
            ),

            'planned_date'         => $this->input->post('planned_date'),

            'start_date'           => $this->input->post('start_date')
                ?: null,

            'end_date'             => $this->input->post('end_date')
                ?: null,

            'next_maintenance_date' => $this->input->post('next_maintenance_date')
                ?: null,

            'supplier'             => trim(
                (string) $this->input->post('supplier')
            ),

            'technician'           => trim(
                (string) $this->input->post('technician')
            ),

            'parts_cost'           => $partsCost,
            'labor_cost'           => $laborCost,
            'total_cost'           => $totalCost,

            'description'          => trim(
                (string) $this->input->post('description')
            ),

            'maintenance_status'   => $this->input->post('status'),

            'record_status'        => 1,
            'created_at'           => date('Y-m-d H:i:s')
        ];

        /*
    |--------------------------------------------------------------------------
    | Transaction
    |--------------------------------------------------------------------------
    */

        $this->db->trans_begin();

        $maintenanceId = $this->tech->insertData(
            'tbl_engin_maintenance',
            $maintenanceData
        );

        if (!$maintenanceId) {
            $this->db->trans_rollback();

            $this->session->set_flashdata(
                'error',
                'Erreur lors de l’enregistrement de la maintenance.'
            );

            redirect('maintenance-carburant');
            return;
        }

        /*
    |--------------------------------------------------------------------------
    | Upload des pièces jointes
    |--------------------------------------------------------------------------
    */

        $uploadResult = $this->uploadMaintenanceDocuments($maintenanceId);

        if (!$uploadResult['success']) {
            $this->db->trans_rollback();

            $this->session->set_flashdata(
                'error',
                $uploadResult['message']
            );

            redirect('maintenance-carburant');
            return;
        }

        /*
    |--------------------------------------------------------------------------
    | Mettre l’engin en maintenance si nécessaire
    |--------------------------------------------------------------------------
    */

        $maintenanceStatus = $this->input->post('status');

        if (
            $maintenanceStatus === 'En cours' ||
            $maintenanceStatus === 'Programmé'
        ) {
            $this->tech->updateData(
                'tbl_engin_materiel',
                ['id' => $enginId],
                [
                    'etat'       => 'Maintenance',
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();

            $this->session->set_flashdata(
                'error',
                'La maintenance n’a pas pu être enregistrée.'
            );

            redirect('maintenance-carburant');
            return;
        }

        $this->db->trans_commit();

        $this->session->set_flashdata(
            'success',
            'Maintenance enregistrée avec succès.'
        );

        redirect('maintenance-carburant');
    }

    public function journalProduction()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        // ----- Filtres reçus en GET -----
        $filters = [
            'date_debut' => $this->input->get('date_debut'),
            'date_fin'   => $this->input->get('date_fin'),
            'chantier'   => $this->input->get('chantier'),
            'statut'     => $this->input->get('statut'),
        ];

        $data['title']             = 'Journal Production';
        $data['filters']           = $filters;
        $data['allChantiers']      = $this->tech->getAllChantier();
        $data['allEngins']         = $this->tech->getAllEngins();
        $data['journalProduction'] = $this->tech->getJournalProduction($filters);

        // Statistiques des tuiles (globales, non filtrées)
        $data['nbJournauxMois']    = $this->tech->countJournalProductionMois();
        $data['nbJournauxValides'] = $this->tech->countJournalProductionByStatut('valide');
        $data['nbJournauxAttente'] = $this->tech->countJournalProductionByStatut('en_attente');
        $data['heuresEngins']      = $this->tech->sumHeuresEngins();

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/technique/journalProduction', $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    public function journalProductionCreate()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        // Validation minimale
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jp_date', 'Date du journal', 'required');
        $this->form_validation->set_rules('jp_chantier', 'Chantier', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Veuillez renseigner la date et le chantier du journal.');
            redirect('journalProduction');
            return;
        }

        // Statut selon le bouton cliqué (brouillon ou soumission)
        $statut = ($this->input->post('statut') === 'brouillon') ? 'brouillon' : 'en_attente';

        // Données principales
        $data = [
            'reference'              => $this->tech->getNextJournalReference(),
            'journal_date'           => $this->input->post('jp_date'),
            'chantier_id'            => $this->input->post('jp_chantier'),
            'chef_chantier'          => $this->input->post('jp_chef'),
            'meteo'                  => $this->input->post('jp_meteo'),
            'effectif_interne'       => (int) $this->input->post('jp_effectif_int'),
            'effectif_sous_traitant' => (int) $this->input->post('jp_effectif_st'),
            'heures_travaillees'     => (float) $this->input->post('jp_heures'),
            'travaux_realises'       => $this->input->post('jp_travaux'),
            'observations'           => $this->input->post('jp_observations'),
            'statut'                 => $statut,
            'created_by'             => $this->session->userdata('user_id'),
            'created_at'             => date('Y-m-d H:i:s'),
        ];

        // Lignes d'engins (on ignore les lignes sans engin sélectionné)
        $jp_engins = $this->input->post('jp_engin') ?? [];
        $jp_heures = $this->input->post('jp_heures_engin') ?? [];
        $jp_carb   = $this->input->post('jp_carburant') ?? [];

        $enginRows = [];
        foreach ($jp_engins as $i => $engin_id) {
            if (empty($engin_id)) continue;
            $enginRows[] = [
                'engin_id'           => (int) $engin_id,
                'heures_utilisation' => (float) ($jp_heures[$i] ?? 0),
                'carburant_l'        => (float) ($jp_carb[$i] ?? 0),
            ];
        }

        $journal_id = $this->tech->createJournalProduction($data, $enginRows);

        if ($journal_id) {
            $msg = ($statut === 'brouillon')
                ? 'Brouillon du journal enregistré avec succès.'
                : 'Journal de production enregistré et soumis pour validation.';
            $this->session->set_flashdata('success', $msg);
        } else {
            $this->session->set_flashdata('error', "Erreur lors de l'enregistrement du journal. Veuillez réessayer.");
        }

        redirect('journal-production');
    }

    public function getJournalProduction($id = null)
    {
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['status' => false, 'message' => 'Non autorisé.']);
            return;
        }

        $journal = $this->tech->getJournalProductionById((int) $id);

        if (!$journal) {
            echo json_encode(['status' => false, 'message' => 'Journal introuvable.']);
            return;
        }

        echo json_encode([
            'status'  => true,
            'journal' => $journal,
            'engins'  => $this->tech->getJournalProductionEngins($journal->id),
        ]);
    }

    public function updateJournalProduction()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $id = (int) $this->input->post('id');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('jp_date', 'Date du journal', 'required');
        $this->form_validation->set_rules('jp_chantier', 'Chantier', 'required|integer');

        if (!$id || $this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Modification impossible : vérifiez la date et le chantier.');
            redirect('journal-production');
            return;
        }

        $data = [
            'journal_date'           => $this->input->post('jp_date'),
            'chantier_id'            => $this->input->post('jp_chantier'),
            'chef_chantier'          => $this->input->post('jp_chef'),
            'meteo'                  => $this->input->post('jp_meteo'),
            'effectif_interne'       => (int) $this->input->post('jp_effectif_int'),
            'effectif_sous_traitant' => (int) $this->input->post('jp_effectif_st'),
            'heures_travaillees'     => (float) $this->input->post('jp_heures'),
            'travaux_realises'       => $this->input->post('jp_travaux'),
            'observations'           => $this->input->post('jp_observations'),
            'statut'                 => $this->input->post('jp_statut'),
            'updated_at'             => date('Y-m-d H:i:s'),
        ];

        // Lignes d'engins (on ignore les lignes sans engin)
        $jp_engins = $this->input->post('jp_engin') ?? [];
        $jp_heures = $this->input->post('jp_heures_engin') ?? [];
        $jp_carb   = $this->input->post('jp_carburant') ?? [];

        $enginRows = [];
        foreach ($jp_engins as $i => $engin_id) {
            if (empty($engin_id)) continue;
            $enginRows[] = [
                'engin_id'           => (int) $engin_id,
                'heures_utilisation' => (float) ($jp_heures[$i] ?? 0),
                'carburant_l'        => (float) ($jp_carb[$i] ?? 0),
            ];
        }

        if ($this->tech->updateJournalProduction($id, $data, $enginRows)) {
            $this->session->set_flashdata('success', 'Journal de production modifié avec succès.');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de la modification du journal.');
        }

        redirect('journal-production');
    }

    public function deleteJournalProduction()
    {
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['status' => false, 'message' => 'Non autorisé.']);
            return;
        }

        $id = (int) $this->input->post('id');

        if (!$id) {
            echo json_encode(['status' => false, 'message' => 'ID invalide.']);
            return;
        }

        if ($this->tech->deleteJournalProduction($id)) {
            echo json_encode(['status' => true, 'message' => 'Le journal a été supprimé avec succès.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'La suppression a échoué.']);
        }
    }

    public function printJournalProduction($id = null)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['journal'] = $this->tech->getJournalProductionById((int) $id);

        if (!$data['journal']) {
            echo 'Journal introuvable.';
            return;
        }

        $data['engins'] = $this->tech->getJournalProductionEngins($data['journal']->id);

        // Vue standalone (sans header/sidebar/footer)
        $this->load->view('v1/components/modules/technique/printJournalProduction', $data);
    }

    public function coutReelleRentebilite()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['title'] = 'Coût Réel & Rentabilité';

        $data['allChantiers'] = $this->tech->getAllChantier();

        // $data['coutReelleRentabilite'] = $this->tech->getCoutReelleRentabilite();

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/technique/coutReelleRentabilite', $data);
        $this->load->view('v1/components/layout/footer', $data);
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
