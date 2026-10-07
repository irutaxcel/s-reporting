<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TechController extends CI_Controller
{

    const EQ_VIEW_DIR  = 'v1/components/modules/technique/';
    const EQ_UP_PHOTOS = 'uploads/engins/photos/';
    const EQ_UP_DOCS   = 'uploads/engins/documents/';
    const EQ_UP_MAINT  = 'uploads/engins/maintenance/';

    private $eqUploadErrors = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(['url', 'form', 'engin']);
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

    /* =========================================================
     *  BONS DE LIVRAISON
     * ========================================================= */

    private function _bl_json($data)
    {
        $data['csrf_hash'] = $this->security->get_csrf_hash();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function blPaidRequests()
    {
        $this->load->model('TechModel', 'tech');
        $company_id = $this->session->userdata('company_id');

        $this->_bl_json([
            'success' => true,
            'data'    => $this->tech->get_paid_requests_for_delivery($company_id),
        ]);
    }

    public function blRequestItems($request_id)
    {
        $this->load->model('TechModel', 'tech');
        $request_id = (int) $request_id;

        $request = $this->tech->get_purchase_request($request_id);
        if (!$request || !$this->tech->is_request_paid($request_id)) {
            return $this->_bl_json(['success' => false, 'message' => "Cette demande n'est pas payée ou n'existe pas."]);
        }

        $this->_bl_json([
            'success' => true,
            'items'   => $this->tech->get_request_items_for_delivery($request_id),
        ]);
    }

    public function blStore()
    {
        $this->load->model('TechModel', 'tech');

        $request_id = (int) $this->input->post('request_id');
        $request    = $this->tech->get_purchase_request($request_id);

        if (!$request || !$this->tech->is_request_paid($request_id)) {
            return $this->_bl_json(['success' => false, 'message' => "Demande d'achat invalide ou non payée."]);
        }
        if ($request->delivery_status === 'livre') {
            return $this->_bl_json(['success' => false, 'message' => 'Cette demande est déjà entièrement livrée.']);
        }

        $qtys = (array) $this->input->post('qty');
        $emplacement_id = (int) $this->input->post('emplacement_id') ?: null;

        // Lignes de la DA indexées par id
        $items = [];
        foreach ($this->tech->get_request_items_for_delivery($request_id) as $it) {
            $items[(int) $it->id] = $it;
        }

        $lines = [];
        $errors = [];

        foreach ($qtys as $item_id => $q) {
            $item_id = (int) $item_id;
            $q = (float) str_replace(',', '.', (string) $q);
            if ($q <= 0 || !isset($items[$item_id])) continue;

            $it = $items[$item_id];
            $remaining = (float) $it->quantity - (float) $it->qty_received;

            if ($q > $remaining + 0.0001) {
                $errors[] = $it->designation . ' : quantité supérieure au reste (' . number_format($remaining, 2, ',', ' ') . ').';
                continue;
            }

            $lines[] = [
                'request_item_id'   => $item_id,
                'designation'       => $it->designation,
                'quantity_ordered'  => (float) $it->quantity,
                'quantity_received' => $q,
            ];
        }

        if (!empty($errors)) {
            return $this->_bl_json(['success' => false, 'message' => 'Corrigez les lignes suivantes :', 'errors' => $errors]);
        }
        if (empty($lines)) {
            return $this->_bl_json(['success' => false, 'message' => 'Saisissez au moins une quantité reçue.']);
        }

        // Scan du BL (facultatif)
        $attachment = null;
        if (!empty($_FILES['attachment']['name'])) {
            $path = FCPATH . 'uploads/bons_livraison/';
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            $this->load->library('upload');
            $this->upload->initialize([
                'upload_path'   => $path,
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 5120,
                'encrypt_name'  => true,
            ]);
            if (!$this->upload->do_upload('attachment')) {
                return $this->_bl_json(['success' => false, 'message' => strip_tags($this->upload->display_errors())]);
            }
            $attachment = 'uploads/bons_livraison/' . $this->upload->data('file_name');
        }

        $note = [
            'company_id'            => $request->company_id,
            'request_id'            => $request_id,
            'payment_voucher_id'    => $this->tech->get_last_effective_voucher_id($request_id),
            'supplier_bl_reference' => trim((string) $this->input->post('supplier_bl_reference', true)) ?: null,
            'delivery_date'         => $this->input->post('delivery_date') ?: date('Y-m-d'),
            'emplacement_id'        => $emplacement_id,
            'received_by'           => trim((string) $this->input->post('received_by', true)) ?: null,
            'attachment'            => $attachment,
            'observation'           => trim((string) $this->input->post('observation', true)) ?: null,
            'created_by'            => $this->session->userdata('user_id'), // <-- clé de session à vérifier
            'created_at'            => date('Y-m-d H:i:s'),
        ];

        $result = $this->tech->create_delivery_note($note, $lines);

        if (!$result) {
            return $this->_bl_json(['success' => false, 'message' => "Erreur lors de l'enregistrement du bon de livraison."]);
        }

        $this->session->set_flashdata('success', 'Bon de livraison ' . $result['number'] . ' enregistré avec succès.');
        $this->_bl_json(['success' => true, 'message' => 'Bon de livraison ' . $result['number'] . ' enregistré.']);
    }

    /* ---------- Liste des bons de livraison ---------- */

    private function _emplacements_map()
    {
        $map = [];
        foreach ($this->tech->get_emplacements() as $e) {
            $map[(int) $e->id] = $e->nom_emplacement;
        }
        return $map;
    }

    private function _dn_allowed($note)
    {
        $company_id = $this->session->userdata('company_id');
        return $note && (empty($company_id) || (int) $note->company_id === (int) $company_id);
    }

    public function deliveryNotes()
    {
        $this->load->model('TechModel', 'tech');
        $company_id = $this->session->userdata('company_id');

        $filters = [
            'company_id' => $company_id,
            'date_from'  => $this->input->get('date_from'),
            'date_to'    => $this->input->get('date_to'),
            'q'          => trim((string) $this->input->get('q', true)),
        ];

        $per_page = 25;
        $total    = $this->tech->count_delivery_notes($filters);
        $pages    = max(1, (int) ceil($total / $per_page));
        $page     = min(max(1, (int) $this->input->get('page')), $pages);

        $data['title']        = 'Bons de livraison';
        $data['notes']        = $this->tech->get_delivery_notes($filters, $per_page, ($page - 1) * $per_page);
        $data['stats']        = $this->tech->get_delivery_stats($company_id);
        $data['emplacements'] = $this->_emplacements_map();
        $data['filters']      = $filters;
        $data['total']        = $total;
        $data['page']         = $page;
        $data['pages']        = $pages;
        $data['per_page']     = $per_page;

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/technique/deliveryNotes', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function deliveryNoteDetail($id)
    {
        $this->load->model('TechModel', 'tech');
        $note = $this->tech->get_delivery_note($id);

        if (!$this->_dn_allowed($note)) {
            return $this->_bl_json(['success' => false, 'message' => 'Bon de livraison introuvable.']);
        }

        $map = $this->_emplacements_map();
        $note->nom_emplacement = isset($map[(int) $note->emplacement_id]) ? $map[(int) $note->emplacement_id] : null;
        $note->attachment_url  = $note->attachment ? base_url($note->attachment) : null;

        $this->_bl_json([
            'success' => true,
            'note'    => $note,
            'items'   => $this->tech->get_delivery_note_items($id),
        ]);
    }

    public function deliveryNotePrint($id)
    {
        $this->load->model('TechModel', 'tech');
        $note = $this->tech->get_delivery_note($id);

        if (!$this->_dn_allowed($note)) {
            show_404();
        }

        $map = $this->_emplacements_map();
        $data['note']            = $note;
        $data['items']           = $this->tech->get_delivery_note_items($id);
        $data['nom_emplacement'] = isset($map[(int) $note->emplacement_id]) ? $map[(int) $note->emplacement_id] : '';

        $this->load->view('v1/components/modules/technique/deliveryNotePrint', $data);
    }

    // public function achatMateriels()
    // {
    //     if (!$this->session->userdata('user_id')) {
    //         redirect('sign-in');
    //         return;
    //     }

    //     $title = 'Achats & Approvisionnement';

    //     /*
    //     * Récupération des filtres envoyés par GET
    //     */
    //     $filters = [
    //         'chantier_id' => trim((string) $this->input->get('chantier_id', true)),

    //         'workflow_status' => trim(
    //             (string) $this->input->get('workflow_status', true)
    //         ),

    //         'date_debut' => trim(
    //             (string) $this->input->get('date_debut', true)
    //         ),

    //         'date_fin' => trim(
    //             (string) $this->input->get('date_fin', true)
    //         )
    //     ];

    //     /*
    //     * Liste des chantiers pour le champ select
    //     */
    //     $allChantiers = $this->tech->getAllChantier();

    //     /*
    //     * Liste des demandes d'achat avec filtres
    //     */
    //     $allAchats = $this->tech->getAllAchats($filters);

    //     /*
    //     * Données envoyées à la vue
    //     */
    //     $data = [
    //         'title'         => $title,
    //         'allChantiers' => $allChantiers,
    //         'allAchats'    => $allAchats,
    //         'filters'      => $filters
    //     ];

    //     $this->load->view(
    //         'v1/components/layout/header',
    //         [
    //             'title' => $title
    //         ]
    //     );

    //     $this->load->view(
    //         'v1/components/layout/sidebar'
    //     );

    //     $this->load->view(
    //         'v1/components/modules/technique/achatMateriels',
    //         $data
    //     );

    //     $this->load->view(
    //         'v1/components/layout/footer'
    //     );
    // }

    // public function achatMateriels()
    // {
    //     if (!$this->session->userdata('user_id')) {
    //         redirect('sign-in');
    //         return;
    //     }

    //     $title = 'Achats & Approvisionnement';

    //     $user_id  = (int) $this->session->userdata('user_id');
    //     $role_id  = (int) $this->session->userdata('role_id');

    //     /*
    //     * Récupération des filtres envoyés par GET
    //     */
    //     $filters = [
    //         'chantier_id'     => trim((string) $this->input->get('chantier_id', true)),
    //         'workflow_status' => trim((string) $this->input->get('workflow_status', true)),
    //         'date_debut'      => trim((string) $this->input->get('date_debut', true)),
    //         'date_fin'        => trim((string) $this->input->get('date_fin', true)),
    //         'user_id'         => $user_id,
    //         'role_id'         => $role_id
    //     ];

    //     /*
    //     * Liste des chantiers pour le champ select
    //     */
    //     $allChantiers = $this->tech->getAllChantier();

    //     /*
    //     * Liste des demandes d'achat avec filtres
    //     */
    //     $allAchats = $this->tech->getAllAchats($filters);

    //     /*
    //     * STATISTIQUES - Récupération des compteurs
    //     */
    //     $stats = [
    //         'demandes_validées'       => $this->tech->countDemandesValidees($filters),
    //         'achats_effectues'        => $this->tech->countAchatsEffectues($filters),
    //         'en_approvisionnement'    => $this->tech->countEnApprovisionnement($filters),
    //         'livraisons_retard'       => $this->tech->countLivraisonsRetard($filters)
    //     ];

    //     /*
    //     * Données envoyées à la vue
    //     */
    //     $data = [
    //         'title'         => $title,
    //         'allChantiers'  => $allChantiers,
    //         'allAchats'     => $allAchats,
    //         'filters'       => $filters,
    //         'stats'         => $stats
    //     ];

    //     $this->load->view('v1/components/layout/header', ['title' => $title]);
    //     $this->load->view('v1/components/layout/sidebar');
    //     $this->load->view('v1/components/modules/technique/achatMateriels', $data);
    //     $this->load->view('v1/components/layout/footer');
    // }

    // public function achatMateriels()
    // {
    //     if (!$this->session->userdata('user_id')) {
    //         redirect('sign-in');
    //         return;
    //     }

    //     $title = 'Achats & Approvisionnement';

    //     $user_id = (int) $this->session->userdata('user_id');
    //     $role_id = (int) $this->session->userdata('role_id');

    //     /*
    //     * ============================================================
    //     * PRIVILÈGE : afficher les demandes déjà payées en trésorerie
    //     * Réservé au SUPER_ADMIN (1) et ADMINISTRATEUR_SYSTEM (2).
    //     * ============================================================
    //     */
    //     $canSeePaidRequests = in_array($role_id, [1, 2], true);

    //     /*
    //     * Récupération des filtres envoyés par GET
    //     * include_payes n'est pris en compte QUE si le rôle est autorisé
    //     * (sécurité côté serveur : un autre rôle ne peut pas forcer l'URL)
    //     */
    //     $includePayes = $canSeePaidRequests
    //         && ($this->input->get('include_payes') === '1');

    //     $filters = [
    //         'chantier_id'     => trim((string) $this->input->get('chantier_id', true)),
    //         'workflow_status' => trim((string) $this->input->get('workflow_status', true)),
    //         'date_debut'      => trim((string) $this->input->get('date_debut', true)),
    //         'date_fin'        => trim((string) $this->input->get('date_fin', true)),
    //         'include_payes'   => $includePayes,
    //         'user_id'         => $user_id,
    //         'role_id'         => $role_id
    //     ];

    //     /*
    //     * Liste des chantiers pour le champ select
    //     */
    //     $allChantiers = $this->tech->getAllChantier();

    //     /*
    //     * Liste des demandes d'achat avec filtres
    //     */
    //     $allAchats = $this->tech->getAllAchats($filters);

    //     /*
    //     * STATISTIQUES - Récupération des compteurs
    //     */
    //     $stats = [
    //         'demandes_validées'    => $this->tech->countDemandesValidees($filters),
    //         'achats_effectues'     => $this->tech->countAchatsEffectues($filters),
    //         'en_approvisionnement' => $this->tech->countEnApprovisionnement($filters),
    //         'livraisons_retard'    => $this->tech->countLivraisonsRetard($filters),
    //         'deja_payees'          => $this->tech->countDejaPayees($filters)
    //     ];

    //     /*
    //     * Données envoyées à la vue
    //     */
    //     $data = [
    //         'title'              => $title,
    //         'allChantiers'       => $allChantiers,
    //         'allAchats'          => $allAchats,
    //         'filters'            => $filters,
    //         'stats'              => $stats,
    //         'canSeePaidRequests' => $canSeePaidRequests
    //     ];

    //     $this->load->view('v1/components/layout/header', ['title' => $title]);
    //     $this->load->view('v1/components/layout/sidebar');
    //     $this->load->view('v1/components/modules/technique/achatMateriels', $data);
    //     $this->load->view('v1/components/layout/footer');
    // }

    public function achatMateriels()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $title = 'Achats & Approvisionnement';

        $user_id = (int) $this->session->userdata('user_id');
        $role_id = (int) $this->session->userdata('role_id');

        /*
        * Récupération des filtres envoyés par GET
        * Note : On affiche TOUTES les demandes (payées incluses) par défaut
        */
        $filters = [
            'chantier_id'     => trim((string) $this->input->get('chantier_id', true)),
            'workflow_status' => trim((string) $this->input->get('workflow_status', true)),
            'date_debut'      => trim((string) $this->input->get('date_debut', true)),
            'date_fin'        => trim((string) $this->input->get('date_fin', true)),
            'user_id'         => $user_id,
            'role_id'         => $role_id
        ];

        /*
        * Liste des chantiers pour le champ select
        */
        $allChantiers = $this->tech->getAllChantier();

        /*
        * Liste des demandes d'achat avec filtres (TOUTES incluses)
        */
        $allAchats = $this->tech->getAllAchats($filters);

        /*
        * STATISTIQUES
        */
        $stats = [
            'demandes_validées'    => $this->tech->countDemandesValidees($filters),
            'achats_effectues'     => $this->tech->countAchatsEffectues($filters),
            'en_approvisionnement' => $this->tech->countEnApprovisionnement($filters),
            'livraisons_retard'    => $this->tech->countLivraisonsRetard($filters),
            'deja_payees'          => $this->tech->countDejaPayees($filters)
        ];

        /*
        * Données envoyées à la vue
        */
        $data = [
            'title'        => $title,
            'allChantiers' => $allChantiers,
            'allAchats'    => $allAchats,
            'filters'      => $filters,
            'stats'        => $stats
        ];

        $this->load->view('v1/components/layout/header', ['title' => $title]);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/technique/achatMateriels', $data);
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


    /* =====================================================================
     |  MODULE ENGINS & MATÉRIELS (Immobilisations)
     |  Pages « Engin & Materiel » et « Maintenance & Carburant ».
     |  Toutes les requêtes sont dans TechModel (section Engins).
     * ===================================================================== */


    /* =====================================================================
     |  OUTILS
     * ===================================================================== */

    private function eqUserId()
    {
        return (int) $this->session->userdata('user_id');
    }

    private function eqGuardPage()
    {
        if (!$this->eqUserId()) {
            redirect('sign-in');
            exit;
        }
    }

    private function eqGuardAjax()
    {
        if (!$this->eqUserId()) {
            $this->eqJson(['success' => false, 'message' => 'Session expirée, reconnectez-vous.'], 401);
            exit;
        }
    }

    private function eqJson(array $payload, $code = 200)
    {
        $payload['csrf'] = $this->security->get_csrf_hash();
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    }

    private function eqRender($view, array $data)
    {
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view(self::EQ_VIEW_DIR . $view, $data);
        $this->load->view('v1/components/layout/footer', $data);
    }

    private function eqBack($message, $type = 'error', $to = 'engin-materiel')
    {
        $this->session->set_flashdata($type, $message);
        redirect($to);
    }

    /** Page de retour autorisée après un formulaire */
    private function eqRedirectTarget($default = 'engin-materiel')
    {
        $to = (string) $this->input->post('redirect');
        return in_array($to, ['engin-materiel', 'maintenance-carburant'], true) ? $to : $default;
    }

    private function eqStr($key, $max = 255)
    {
        $v = trim((string) $this->input->post($key, true));
        return $v === '' ? null : mb_substr($v, 0, $max);
    }

    private function eqDec($key)
    {
        $v = str_replace([' ', "\xc2\xa0", ','], ['', '', '.'], trim((string) $this->input->post($key)));
        return is_numeric($v) ? (float) $v : null;
    }

    private function eqInt($key)
    {
        $v = (int) $this->input->post($key);
        return $v > 0 ? $v : null;
    }

    private function eqValidDate($v, $format = 'Y-m-d')
    {
        $v = trim((string) $v);
        $d = DateTime::createFromFormat($format, $v);
        return ($d && $d->format($format) === $v) ? $v : null;
    }

    private function eqPostDate($key)
    {
        return $this->eqValidDate($this->input->post($key));
    }

    private function eqOneOf($value, array $list, $default = null)
    {
        return in_array($value, $list, true) ? $value : $default;
    }

    private function eqFilters()
    {
        $get = function ($k) {
            return trim((string) $this->input->get($k, true));
        };
        $statuses = array_values(array_unique(array_merge(
            ['Validé'],
            TechModel::MAINT_STATUS,
            TechModel::PANNE_STATUS
        )));

        $f = [
            'q'            => mb_substr($get('q'), 0, 100),
            'categorie_id' => (int) $get('categorie_id'),
            'etat'         => $this->eqOneOf($get('etat'), TechModel::ETATS, ''),
            'chantier_id'  => (int) $get('chantier_id'),
            'engin_id'     => (int) $get('engin_id'),
            'type'         => $this->eqOneOf($get('type'), ['fuel', 'maintenance', 'panne'], ''),
            'status'       => $this->eqOneOf($get('status'), $statuses, ''),
            'date_debut'   => $this->eqValidDate($get('date_debut')),
            'date_fin'     => $this->eqValidDate($get('date_fin')),
        ];
        if ($f['date_debut'] && $f['date_fin'] && $f['date_debut'] > $f['date_fin']) {
            list($f['date_debut'], $f['date_fin']) = [$f['date_fin'], $f['date_debut']];
        }
        return $f;
    }

    /**
     * Upload multiple d'un champ tableau (name="x[]").
     * Conserve les index : [index => fichier | null].
     */
    private function eqUploadMany($field, $dir, $allowed, $maxKb)
    {
        $saved = [];
        if (empty($_FILES[$field]['name']) || !is_array($_FILES[$field]['name'])) {
            return $saved;
        }

        $path = FCPATH . $dir;
        if (!is_dir($path)) {
            @mkdir($path, 0755, true);
        }

        $this->load->library('upload');
        $files = $_FILES[$field];

        foreach ($files['name'] as $i => $name) {
            if ((int) $files['error'][$i] === UPLOAD_ERR_NO_FILE || $name === '') {
                $saved[$i] = null;
                continue;
            }
            $_FILES['_eq_one'] = [
                'name'     => $files['name'][$i],
                'type'     => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error'    => $files['error'][$i],
                'size'     => $files['size'][$i],
            ];
            $this->upload->initialize([
                'upload_path'   => $path,
                'allowed_types' => $allowed,
                'max_size'      => $maxKb,
                'encrypt_name'  => true,
            ]);

            if ($this->upload->do_upload('_eq_one')) {
                $d = $this->upload->data();
                $saved[$i] = [
                    'file_name' => $d['file_name'],
                    'orig_name' => mb_substr($d['client_name'], 0, 255),
                    'file_type' => $d['file_type'],
                    'file_size' => (int) round($d['file_size'] * 1024),
                ];
            } else {
                $saved[$i] = null;
                $this->eqUploadErrors[] = $name . ' : ' . strip_tags($this->upload->display_errors('', ''));
            }
        }
        unset($_FILES['_eq_one']);
        return $saved;
    }

    private function eqRemoveFile($dir, $fileName)
    {
        $file = FCPATH . $dir . basename((string) $fileName);
        if ($fileName && is_file($file)) {
            @unlink($file);
        }
    }

    private function eqFlashUploadErrors()
    {
        if ($this->eqUploadErrors) {
            $this->session->set_flashdata(
                'warning',
                "Certains fichiers n'ont pas été enregistrés : " . implode(' | ', $this->eqUploadErrors)
            );
        }
    }

    private function eqCsv($filename, array $head, array $lines)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF"); // BOM : accents corrects dans Excel
        fputcsv($out, $head, ';');
        foreach ($lines as $line) {
            fputcsv($out, $line, ';');
        }
        fclose($out);
        exit;
    }

    private function eqCsvNum($v, $dec = 2)
    {
        return $v === null || $v === '' ? '' : number_format((float) $v, $dec, ',', '');
    }

    /* =====================================================================
     |  PAGE : ENGIN & MATERIEL
     * ===================================================================== */

    public function enginMateriel()
    {
        $this->eqGuardPage();
        $f = $this->eqFilters();

        $this->eqRender('enginMateriel', [
            'title'       => 'Engin & Materiel',
            'filters'     => $f,
            'engins'      => $this->tech->getEngins($f),
            'allEngins'   => $this->tech->getEngins(),
            'stats'       => $this->tech->getParcStats(),
            'categories'  => $this->tech->getCategories(),
            'chantiers'   => $this->tech->getChantiers(),
            'alerts'      => array_slice($this->tech->getAlerts(30), 0, 6),
            'codePreview' => $this->tech->previewCode('ENG'),
        ]);
    }

    public function enginMaterielStore()
    {
        $this->eqSaveEngin(null);
    }

    public function enginMaterielUpdate()
    {
        $this->eqSaveEngin((int) $this->input->post('id'));
    }

    private function eqSaveEngin($id)
    {
        $this->eqGuardPage();
        if ($this->input->method() !== 'post') {
            redirect('engin-materiel');
        }
        if ($id && !$this->tech->getEngin($id)) {
            return $this->eqBack('Engin introuvable.');
        }

        $annee = (int) $this->input->post('annee_fabrication');
        $data  = [
            'designation'              => $this->eqStr('designation'),
            'categorie_id'             => $this->eqInt('categorie_id'),
            'marque'                   => $this->eqStr('marque', 100),
            'modele'                   => $this->eqStr('modele', 100),
            'plaque'                   => ($p = $this->eqStr('plaque', 50)) ? mb_strtoupper($p) : null,
            'numero_serie'             => $this->eqStr('numero_serie', 100),
            'numero_chassis'           => $this->eqStr('numero_chassis', 100),
            'numero_moteur'            => $this->eqStr('numero_moteur', 100),
            'annee_fabrication'        => ($annee >= 1950 && $annee <= (int) date('Y') + 1) ? $annee : null,
            'type_carburant'           => $this->eqOneOf($this->input->post('type_carburant'), TechModel::CARBURANTS, 'Diesel'),
            'capacite_reservoir'       => $this->eqDec('capacite_reservoir'),
            'type_compteur'            => $this->eqOneOf($this->input->post('type_compteur'), TechModel::COMPTEURS, 'km'),
            'consommation_reference'   => $this->eqDec('consommation_reference'),
            'responsable'              => $this->eqStr('responsable', 150),
            'date_acquisition'         => $this->eqPostDate('date_acquisition'),
            'date_mise_service'        => $this->eqPostDate('date_mise_service'),
            'valeur_achat'             => $this->eqDec('valeur_achat') ?: 0,
            'duree_amortissement_mois' => $this->eqInt('duree_amortissement_mois'),
            'valeur_residuelle'        => $this->eqDec('valeur_residuelle') ?: 0,
            'observation'              => $this->eqStr('observation', 5000),
        ];

        if (!$data['designation'] || !$data['categorie_id']) {
            return $this->eqBack('La désignation et la catégorie sont obligatoires.');
        }
        foreach (['capacite_reservoir', 'consommation_reference', 'valeur_achat', 'valeur_residuelle'] as $k) {
            if ($data[$k] !== null && $data[$k] < 0) {
                return $this->eqBack('Les montants et quantités ne peuvent pas être négatifs.');
            }
        }
        if ($data['valeur_residuelle'] > $data['valeur_achat'] && $data['valeur_achat'] > 0) {
            return $this->eqBack("La valeur résiduelle ne peut pas dépasser la valeur d'achat.");
        }
        if ($this->tech->plaqueExists($data['plaque'], (int) $id)) {
            return $this->eqBack('La plaque ' . $data['plaque'] . ' est déjà attribuée à un autre engin.');
        }

        $uid = $this->eqUserId();

        if ($id) {
            $data['updated_by'] = $uid;
            $this->tech->updateEngin($id, $data);
            $enginId = $id;
            $message = 'Fiche engin mise à jour.';
        } else {
            $compteur                 = max(0, (float) $this->eqDec('compteur_initial'));
            $data['compteur_initial'] = $compteur;
            $data['compteur_actuel']  = $compteur;
            $data['code_engin']       = $this->tech->reserveCode('ENG');
            $data['etat']             = 'Disponible';
            $data['localisation']     = $this->eqStr('localisation', 150) ?: 'Dépôt central';
            $data['created_by']       = $uid;

            $enginId = $this->tech->insertEngin($data);
            if (!$enginId) {
                return $this->eqBack("L'engin n'a pas pu être enregistré.");
            }

            $chantierId = $this->eqInt('chantier_id');
            if ($chantierId) {
                $this->tech->affecter($enginId, [
                    'chantier_id'     => $chantierId,
                    'localisation'    => null,
                    'date_debut'      => $data['date_mise_service'] ?: date('Y-m-d'),
                    'responsable'     => $data['responsable'],
                    'compteur_depart' => $compteur,
                    'observation'     => 'Affectation initiale',
                ], $uid);
            }
            $message = 'Engin ' . $data['code_engin'] . ' enregistré.';
        }

        $this->eqSaveEnginFiles($enginId);
        $this->eqFlashUploadErrors();
        $this->eqBack($message, 'success');
    }

    private function eqSaveEnginFiles($enginId)
    {
        foreach ($this->eqUploadMany('photos', self::EQ_UP_PHOTOS, 'jpg|jpeg|png', 5120) as $file) {
            if ($file) {
                $this->tech->addPhoto($enginId, $file);
            }
        }

        $docs  = $this->eqUploadMany('doc_file', self::EQ_UP_DOCS, 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png', 10240);
        $types = (array) $this->input->post('doc_type');
        $nums  = (array) $this->input->post('doc_numero', true);
        $exps  = (array) $this->input->post('doc_expiration');

        foreach ($docs as $i => $file) {
            if (!$file) {
                continue;
            }
            $num = isset($nums[$i]) ? trim((string) $nums[$i]) : '';
            $this->tech->addDocument($enginId, [
                'type_document'   => $this->eqOneOf(isset($types[$i]) ? $types[$i] : '', TechModel::DOC_TYPES, 'Autre'),
                'numero_document' => $num === '' ? null : mb_substr($num, 0, 100),
                'date_expiration' => isset($exps[$i]) ? $this->eqValidDate($exps[$i]) : null,
                'document'        => $file['file_name'],
                'original_name'   => $file['orig_name'],
                'file_type'       => $file['file_type'],
                'file_size'       => $file['file_size'],
                'created_by'      => $this->eqUserId(),
            ]);
        }
    }

    private function eqPhotosPayload($enginId)
    {
        return array_map(function ($p) {
            $p->url = base_url(self::EQ_UP_PHOTOS . $p->photo);
            return $p;
        }, $this->tech->getPhotos($enginId));
    }

    /** AJAX — données complètes d'un engin pour le formulaire de modification */
    public function enginMaterielGet($id)
    {
        $this->eqGuardAjax();
        $engin = $this->tech->getEngin($id);
        if (!$engin) {
            return $this->eqJson(['success' => false, 'message' => 'Engin introuvable.'], 404);
        }

        $documents = array_map(function ($d) {
            $d->url = base_url(self::EQ_UP_DOCS . $d->document);
            return $d;
        }, $this->tech->getDocuments($id));

        $this->eqJson([
            'success'   => true,
            'engin'     => $engin,
            'photos'    => $this->eqPhotosPayload($id),
            'documents' => $documents,
        ]);
    }

    /** AJAX — suppression (uniquement si aucun historique) */
    public function enginMaterielDelete()
    {
        $this->eqGuardAjax();
        $id    = $this->eqInt('id');
        $engin = $id ? $this->tech->getEngin($id) : null;
        if (!$engin) {
            return $this->eqJson(['success' => false, 'message' => 'Engin introuvable.'], 404);
        }
        if ($this->tech->hasOperations($id)) {
            return $this->eqJson([
                'success' => false,
                'message' => "Cet engin possède un historique (carburant, maintenances ou pannes). "
                    . "Utilisez « Réformer » pour le sortir du parc sans perdre ses données.",
            ], 409);
        }
        $this->tech->softDeleteEngin($id, $this->eqUserId());
        $this->eqJson(['success' => true, 'message' => 'Engin supprimé.']);
    }

    public function enginPhotoDelete()
    {
        $this->eqGuardAjax();
        $photo = $this->tech->deletePhoto($this->eqInt('id'));
        if (!$photo) {
            return $this->eqJson(['success' => false, 'message' => 'Photo introuvable.'], 404);
        }
        $this->eqRemoveFile(self::EQ_UP_PHOTOS, $photo->photo);
        $this->eqJson(['success' => true, 'photos' => $this->eqPhotosPayload($photo->engin_id)]);
    }

    public function enginPhotoPrincipale()
    {
        $this->eqGuardAjax();
        $photo = $this->tech->setPhotoPrincipale($this->eqInt('id'));
        if (!$photo) {
            return $this->eqJson(['success' => false, 'message' => 'Photo introuvable.'], 404);
        }
        $this->eqJson(['success' => true, 'photos' => $this->eqPhotosPayload($photo->engin_id)]);
    }

    public function enginDocumentDelete()
    {
        $this->eqGuardAjax();
        $doc = $this->tech->deleteDocument($this->eqInt('id'));
        if (!$doc) {
            return $this->eqJson(['success' => false, 'message' => 'Document introuvable.'], 404);
        }
        $this->eqRemoveFile(self::EQ_UP_DOCS, $doc->document);
        $this->eqJson(['success' => true]);
    }

    /** Formulaire — affectation à un chantier / retour au dépôt */
    public function enginAffecter()
    {
        $this->eqGuardPage();
        $to    = $this->eqRedirectTarget();
        $id    = $this->eqInt('engin_id');
        $engin = $id ? $this->tech->getEngin($id) : null;

        if (!$engin || $engin->etat === 'Réformé') {
            return $this->eqBack('Engin introuvable ou réformé.', 'error', $to);
        }

        $chantierId   = $this->eqInt('chantier_id');
        $localisation = $this->eqStr('localisation', 150);
        if (!$chantierId && !$localisation) {
            return $this->eqBack('Choisissez un chantier ou indiquez une localisation (dépôt, atelier…).', 'error', $to);
        }

        $compteur = $this->eqDec('compteur_depart');
        if ($compteur !== null && $engin->type_compteur !== 'aucun' && $compteur < (float) $engin->compteur_actuel) {
            return $this->eqBack(
                'Le compteur saisi (' . eq_num($compteur) . ') est inférieur au compteur actuel ('
                    . eq_num($engin->compteur_actuel) . ' ' . eq_unit($engin->type_compteur) . ').',
                'error',
                $to
            );
        }

        $ok = $this->tech->affecter($id, [
            'chantier_id'     => $chantierId,
            'localisation'    => $chantierId ? null : $localisation,
            'date_debut'      => $this->eqPostDate('date_debut') ?: date('Y-m-d'),
            'responsable'     => $this->eqStr('responsable', 150),
            'compteur_depart' => $compteur,
            'observation'     => $this->eqStr('observation', 2000),
        ], $this->eqUserId());

        $ok
            ? $this->eqBack($engin->code_engin . ' : affectation enregistrée.', 'success', $to)
            : $this->eqBack("L'affectation n'a pas pu être enregistrée.", 'error', $to);
    }

    /** Formulaire — sortie définitive du parc */
    public function enginReformer()
    {
        $this->eqGuardPage();
        $id    = $this->eqInt('engin_id');
        $engin = $id ? $this->tech->getEngin($id) : null;
        $motif = $this->eqStr('motif_reforme');

        if (!$engin || $engin->etat === 'Réformé') {
            return $this->eqBack('Engin introuvable ou déjà réformé.');
        }
        if (!$motif) {
            return $this->eqBack('Le motif de réforme est obligatoire.');
        }

        $this->tech->reformer($id, $this->eqPostDate('date_reforme') ?: date('Y-m-d'), $motif, $this->eqUserId());
        $this->eqBack($engin->code_engin . ' a été réformé (sorti du parc).', 'success');
    }

    /** AJAX (HTML) — dossier / rapport détaillé d'un engin */
    public function enginMaterielDossier($id)
    {
        if (!$this->eqUserId()) {
            http_response_code(401);
            echo '<div class="alert alert-warning mb-0">Session expirée, reconnectez-vous.</div>';
            return;
        }

        $du = $this->eqValidDate($this->input->get('du')) ?: date('Y-01-01');
        $au = $this->eqValidDate($this->input->get('au')) ?: date('Y-m-d');
        if ($du > $au) {
            list($du, $au) = [$au, $du];
        }

        $data = $this->tech->getEnginDossier($id, $du, $au);
        if (!$data) {
            http_response_code(404);
            echo '<div class="alert alert-warning mb-0">Engin introuvable.</div>';
            return;
        }
        $this->load->view(self::EQ_VIEW_DIR . 'partials/enginDossier', $data);
    }

    /** Export CSV du parc (filtres de la page appliqués) */
    public function enginMaterielExport()
    {
        $this->eqGuardPage();
        $lines = [];
        foreach ($this->tech->getEngins($this->eqFilters()) as $e) {
            $lines[] = [
                $e->code_engin,
                $e->designation,
                $e->nom_categorie,
                $e->marque,
                $e->modele,
                $e->plaque,
                $e->numero_serie,
                $e->type_carburant,
                $this->eqCsvNum($e->compteur_actuel, 0),
                eq_unit($e->type_compteur),
                $e->etat,
                $e->chantier_name ?: $e->localisation,
                $e->responsable,
                $e->date_acquisition,
                $this->eqCsvNum($e->valeur_achat, 0),
            ];
        }
        $this->eqCsv('parc-engins-' . date('Ymd') . '.csv', [
            'Code',
            'Désignation',
            'Catégorie',
            'Marque',
            'Modèle',
            'Plaque',
            'N° série',
            'Carburant',
            'Compteur',
            'Unité',
            'État',
            'Chantier / Localisation',
            'Responsable',
            "Date d'acquisition",
            "Valeur d'achat (BIF)",
        ], $lines);
    }

    /* =====================================================================
     |  PAGE : MAINTENANCE & CARBURANT
     * ===================================================================== */

    public function maintenanceCarburant()
    {
        $this->eqGuardPage();
        $f  = $this->eqFilters();
        $du = date('Y-m-01');
        $au = date('Y-m-t');

        $prefillPanne = null;
        $panneId      = (int) $this->input->get('panne');
        if ($panneId) {
            $prefillPanne = $this->tech->getPanne($panneId);
        }

        $this->eqRender('maintenanceCarburant', [
            'title'        => 'Maintenance & Carburant',
            'filters'      => $f,
            'stats'        => $this->tech->getMaintenanceFuelStats($du, $au),
            'fuels'        => $this->tech->getFuels($f, 15),
            'maintenances' => $this->tech->getMaintenances($f, 15),
            'pannes'       => $this->tech->getOpenPannes(),
            'alerts'       => array_slice($this->tech->getAlerts(30), 0, 8),
            'expensive'    => $this->tech->getMostExpensiveEngins($du, $au, 5),
            'conso'        => $this->tech->getConsumption(date('Y-m-d', strtotime('-90 days')), date('Y-m-d')),
            'monthly'      => $this->tech->getMonthlyCosts(6),
            'operations'   => $this->tech->getOperations($f, 50),
            'allEngins'    => $this->tech->getEngins(),
            'chantiers'    => $this->tech->getChantiers(),
            'prefillPanne' => $prefillPanne,
            'prefillEngin' => (int) $this->input->get('engin_id'),
        ]);
    }

    /* ---------------------------------------------------------------------
     |  Carburant
     * --------------------------------------------------------------------- */

    public function addNewRavitaillement()
    {
        $this->eqSaveFuel(null);
    }

    public function enginFuelUpdate()
    {
        $this->eqSaveFuel((int) $this->input->post('id'));
    }

    private function eqSaveFuel($id)
    {
        $this->eqGuardPage();
        $to = 'maintenance-carburant';

        if ($id && !$this->tech->getFuel($id)) {
            return $this->eqBack('Ravitaillement introuvable.', 'error', $to);
        }

        $enginId = $this->eqInt('engin_id');
        $engin   = $enginId ? $this->tech->getEngin($enginId) : null;
        if (!$engin || $engin->etat === 'Réformé') {
            return $this->eqBack('Sélectionnez un engin actif.', 'error', $to);
        }

        $date = $this->eqPostDate('operation_date');
        $qty  = $this->eqDec('quantity_litre');
        $pu   = $this->eqDec('unit_price');
        if (!$date || $qty === null || $qty <= 0 || $pu === null || $pu < 0) {
            return $this->eqBack('Date, quantité (> 0) et prix unitaire sont obligatoires.', 'error', $to);
        }
        if ($date > date('Y-m-d')) {
            return $this->eqBack('La date du ravitaillement ne peut pas être dans le futur.', 'error', $to);
        }

        $compteur = $engin->type_compteur === 'aucun' ? null : $this->eqDec('compteur');
        if ($compteur !== null) {
            $last = $this->tech->getLastCompteurBefore($enginId, $date, (int) $id);
            if ($last !== null && $compteur < $last) {
                return $this->eqBack(
                    'Le compteur saisi (' . eq_num($compteur) . ') est inférieur au dernier relevé ('
                        . eq_num($last) . ' ' . eq_unit($engin->type_compteur) . ').',
                    'error',
                    $to
                );
            }
        }

        $data = [
            'engin_id'       => $enginId,
            'chantier_id'    => $this->eqInt('chantier_id'),
            'operation_date' => $date,
            'type_carburant' => $this->eqOneOf($this->input->post('type_carburant'), TechModel::FUEL_TYPES, 'Diesel'),
            'source'         => $this->eqOneOf($this->input->post('source'), TechModel::FUEL_SOURCES, 'Station'),
            'numero_bon'     => $this->eqStr('numero_bon', 50),
            'quantity_litre' => round($qty, 2),
            'unit_price'     => round($pu, 2),
            'total_amount'   => round($qty * $pu, 2),
            'kilometrage'    => $engin->type_compteur === 'km' ? $compteur : null,
            'hour_meter'     => $engin->type_compteur === 'heure' ? $compteur : null,
            'plein_complet'  => $this->input->post('plein_complet') ? 1 : 0,
            'operator_name'  => $this->eqStr('operator_name', 150),
            'supplier'       => $this->eqStr('supplier', 180),
            'observation'    => $this->eqStr('observation', 2000),
        ];

        if ($id) {
            $ok      = $this->tech->updateFuel($id, $data);
            $message = 'Ravitaillement modifié.';
        } else {
            $data['created_by'] = $this->eqUserId();
            $ok      = $this->tech->insertFuel($data);
            $message = 'Ravitaillement enregistré : ' . eq_num($qty, 2) . ' L pour ' . $engin->code_engin . '.';
        }

        $ok
            ? $this->eqBack($message, 'success', $to)
            : $this->eqBack("Le ravitaillement n'a pas pu être enregistré.", 'error', $to);
    }

    public function enginFuelGet($id)
    {
        $this->eqGuardAjax();
        $fuel = $this->tech->getFuel($id);
        $fuel
            ? $this->eqJson(['success' => true, 'fuel' => $fuel])
            : $this->eqJson(['success' => false, 'message' => 'Ravitaillement introuvable.'], 404);
    }

    public function enginFuelCancel()
    {
        $this->eqGuardAjax();
        $this->tech->cancelFuel($this->eqInt('id'))
            ? $this->eqJson(['success' => true, 'message' => 'Ravitaillement annulé.'])
            : $this->eqJson(['success' => false, 'message' => 'Ravitaillement introuvable.'], 404);
    }

    /* ---------------------------------------------------------------------
     |  Maintenances
     * --------------------------------------------------------------------- */

    public function newTechniqueMaintenance()
    {
        $this->eqSaveMaintenance(null);
    }

    public function enginMaintenanceUpdate()
    {
        $this->eqSaveMaintenance((int) $this->input->post('id'));
    }

    private function eqSaveMaintenance($id)
    {
        $this->eqGuardPage();
        $to = 'maintenance-carburant';

        if ($id && !$this->tech->getMaintenance($id)) {
            return $this->eqBack('Maintenance introuvable.', 'error', $to);
        }

        $enginId = $this->eqInt('engin_id');
        $engin   = $enginId ? $this->tech->getEngin($enginId) : null;
        if (!$engin || $engin->etat === 'Réformé') {
            return $this->eqBack('Sélectionnez un engin actif.', 'error', $to);
        }

        $type         = $this->eqOneOf($this->input->post('maintenance_type'), TechModel::MAINT_TYPES);
        $status       = $this->eqOneOf($this->input->post('maintenance_status'), TechModel::MAINT_STATUS, 'Programmé');
        $intervention = $this->eqStr('intervention');
        $planned      = $this->eqPostDate('planned_date');
        $start        = $this->eqPostDate('start_date');
        $end          = $this->eqPostDate('end_date');

        if (!$type || !$intervention || !$planned) {
            return $this->eqBack("Type, nature de l'intervention et date prévue sont obligatoires.", 'error', $to);
        }

        $today = date('Y-m-d');
        if ($status === 'En cours' && !$start) {
            $start = $today;
        }
        if ($status === 'Terminé') {
            $start = $start ?: min($planned, $today);
            $end   = $end ?: $today;
        }
        if ($start && $end && $end < $start) {
            return $this->eqBack('La date de fin ne peut pas précéder la date de début.', 'error', $to);
        }

        // Pièces remplacées
        $pieces = [];
        $designs = (array) $this->input->post('piece_designation', true);
        $refs    = (array) $this->input->post('piece_reference', true);
        $qtys    = (array) $this->input->post('piece_quantite');
        $pus     = (array) $this->input->post('piece_prix');
        foreach ($designs as $i => $designation) {
            $designation = trim((string) $designation);
            if ($designation === '') {
                continue;
            }
            $q  = (float) str_replace(',', '.', isset($qtys[$i]) ? $qtys[$i] : 1);
            $pu = (float) str_replace(',', '.', isset($pus[$i]) ? $pus[$i] : 0);
            if ($q <= 0 || $pu < 0) {
                return $this->eqBack('Quantité (> 0) et prix des pièces invalides.', 'error', $to);
            }
            $ref = isset($refs[$i]) ? trim((string) $refs[$i]) : '';
            $pieces[] = [
                'designation'     => mb_substr($designation, 0, 255),
                'reference_piece' => $ref === '' ? null : mb_substr($ref, 0, 100),
                'quantite'        => round($q, 2),
                'prix_unitaire'   => round($pu, 2),
            ];
        }
        $partsCost = 0.0;
        foreach ($pieces as $p) {
            $partsCost += $p['quantite'] * $p['prix_unitaire'];
        }
        $labor = max(0, (float) $this->eqDec('labor_cost'));

        // Panne liée : doit appartenir au même engin
        $panneId = $this->eqInt('panne_id');
        if ($panneId) {
            $panne = $this->tech->getPanne($panneId);
            if (!$panne || (int) $panne->engin_id !== (int) $enginId) {
                $panneId = null;
            }
        }

        $compteur = $engin->type_compteur === 'aucun' ? null : $this->eqDec('compteur_intervention');

        $data = [
            'engin_id'                  => $enginId,
            'chantier_id'               => $this->eqInt('chantier_id'),
            'panne_id'                  => $panneId,
            'maintenance_type'          => $type,
            'intervention'              => $intervention,
            'planned_date'              => $planned,
            'start_date'                => $start,
            'end_date'                  => $end,
            'compteur_intervention'     => $compteur,
            'next_maintenance_date'     => $this->eqPostDate('next_maintenance_date'),
            'next_maintenance_compteur' => $engin->type_compteur === 'aucun' ? null : $this->eqDec('next_maintenance_compteur'),
            'immobilise'                => $this->input->post('immobilise') ? 1 : 0,
            'supplier'                  => $this->eqStr('supplier', 180),
            'technician'                => $this->eqStr('technician', 180),
            'parts_cost'                => round($partsCost, 2),
            'labor_cost'                => round($labor, 2),
            'total_cost'                => round($partsCost + $labor, 2),
            'description'               => $this->eqStr('description', 5000),
            'maintenance_status'        => $status,
        ];

        if ($id) {
            $ok            = $this->tech->updateMaintenance($id, $data, $pieces);
            $maintenanceId = $id;
            $message       = 'Maintenance modifiée.';
        } else {
            $data['created_by'] = $this->eqUserId();
            $maintenanceId = $this->tech->insertMaintenance($data, $pieces);
            $ok            = (bool) $maintenanceId;
            $message       = 'Maintenance enregistrée pour ' . $engin->code_engin . '.';
        }

        if (!$ok) {
            return $this->eqBack("La maintenance n'a pas pu être enregistrée.", 'error', $to);
        }

        foreach ($this->eqUploadMany('documents', self::EQ_UP_MAINT, 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png', 10240) as $file) {
            if ($file) {
                $this->tech->addMaintenanceDocument($maintenanceId, $file);
            }
        }
        $this->eqFlashUploadErrors();
        $this->eqBack($message, 'success', $to);
    }

    public function enginMaintenanceGet($id)
    {
        $this->eqGuardAjax();
        $m = $this->tech->getMaintenance($id);
        if (!$m) {
            return $this->eqJson(['success' => false, 'message' => 'Maintenance introuvable.'], 404);
        }
        foreach ($m->documents as $d) {
            $d->url = base_url(self::EQ_UP_MAINT . $d->document);
        }
        $this->eqJson(['success' => true, 'maintenance' => $m]);
    }

    public function enginMaintenanceStatus()
    {
        $this->eqGuardAjax();
        $status = $this->eqOneOf($this->input->post('status'), TechModel::MAINT_STATUS);
        if (!$status) {
            return $this->eqJson(['success' => false, 'message' => 'Statut invalide.'], 422);
        }
        $this->tech->setMaintenanceStatus($this->eqInt('id'), $status)
            ? $this->eqJson(['success' => true, 'message' => 'Maintenance : ' . $status . '.'])
            : $this->eqJson(['success' => false, 'message' => 'Maintenance introuvable.'], 404);
    }

    public function enginMaintenanceDocumentDelete()
    {
        $this->eqGuardAjax();
        $doc = $this->tech->deleteMaintenanceDocument($this->eqInt('id'));
        if (!$doc) {
            return $this->eqJson(['success' => false, 'message' => 'Document introuvable.'], 404);
        }
        $this->eqRemoveFile(self::EQ_UP_MAINT, $doc->document);
        $this->eqJson(['success' => true]);
    }

    /* ---------------------------------------------------------------------
     |  Pannes
     * --------------------------------------------------------------------- */

    public function enginPanneStore()
    {
        $this->eqGuardPage();
        $to      = $this->eqRedirectTarget('maintenance-carburant');
        $enginId = $this->eqInt('engin_id');
        $engin   = $enginId ? $this->tech->getEngin($enginId) : null;

        if (!$engin || $engin->etat === 'Réformé') {
            return $this->eqBack('Sélectionnez un engin actif.', 'error', $to);
        }

        $description = $this->eqStr('description', 5000);
        if (!$description) {
            return $this->eqBack('Décrivez la panne constatée.', 'error', $to);
        }

        $date = $this->eqValidDate($this->input->post('date_signalement'), 'Y-m-d\TH:i');
        $date = $date ? str_replace('T', ' ', $date) . ':00' : date('Y-m-d H:i:s');

        $id = $this->tech->insertPanne([
            'engin_id'         => $enginId,
            'chantier_id'      => $this->eqInt('chantier_id') ?: ($engin->chantier_id ?: null),
            'date_signalement' => $date,
            'gravite'          => $this->eqOneOf($this->input->post('gravite'), TechModel::GRAVITES, 'Majeure'),
            'description'      => $description,
            'signale_par'      => $this->eqStr('signale_par', 150),
            'compteur'         => $engin->type_compteur === 'aucun' ? null : $this->eqDec('compteur'),
            'immobilise'       => $this->input->post('immobilise') ? 1 : 0,
            'created_by'       => $this->eqUserId(),
        ]);

        if (!$id) {
            return $this->eqBack("La panne n'a pas pu être enregistrée.", 'error', $to);
        }

        if ($this->input->post('open_maintenance')) {
            $this->session->set_flashdata('success', 'Panne enregistrée. Complétez la maintenance corrective.');
            redirect('maintenance-carburant?panne=' . $id . '#maintenance');
        }
        $this->eqBack('Panne signalée pour ' . $engin->code_engin . '.', 'success', $to);
    }

    public function enginPanneStatus()
    {
        $this->eqGuardAjax();
        $status = $this->eqOneOf($this->input->post('status'), ['En diagnostic', 'Résolue', 'Annulée']);
        if (!$status) {
            return $this->eqJson(['success' => false, 'message' => 'Statut invalide.'], 422);
        }
        $this->tech->setPanneStatus($this->eqInt('id'), $status)
            ? $this->eqJson(['success' => true, 'message' => 'Panne : ' . $status . '.'])
            : $this->eqJson(['success' => false, 'message' => 'Panne introuvable.'], 404);
    }

    /** Export CSV de l'historique (filtres de la page appliqués) */
    public function maintenanceCarburantExport()
    {
        $this->eqGuardPage();
        $types = ['fuel' => 'Carburant', 'maintenance' => 'Maintenance', 'panne' => 'Panne'];
        $lines = [];
        foreach ($this->tech->getOperations($this->eqFilters(), null) as $o) {
            $lines[] = [
                $o->operation_date,
                $o->reference,
                $types[$o->source],
                $o->code_engin,
                $o->designation,
                $o->plaque,
                $o->operation_name,
                $o->operation_type,
                $o->chantier_name,
                $this->eqCsvNum($o->amount, 0),
                $o->responsible,
                $o->operation_status,
            ];
        }
        $this->eqCsv('historique-engins-' . date('Ymd') . '.csv', [
            'Date',
            'Référence',
            'Type',
            'Code engin',
            'Désignation',
            'Plaque',
            'Opération',
            'Détail',
            'Chantier',
            'Montant (BIF)',
            'Responsable',
            'Statut',
        ], $lines);
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
