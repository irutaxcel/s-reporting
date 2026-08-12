<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
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
        $this->load->library('upload');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    // public function users()
    // {
    //     if (!$this->session->userdata('user_id')) {
    //         redirect('sign-in');
    //         return;
    //     }

    //     $title = 'Utilisateur';

    //     $this->load->view('v1/components/layout/header', ['title' => $title]);
    //     $this->load->view('v1/components/layout/sidebar');
    //     $this->load->view('v1/components/modules/admin/users');
    //     $this->load->view('v1/components/layout/footer');
    // }

    public function users()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $this->load->model('AdminModel', 'admin');

        $data['title'] = 'Utilisateurs';

        $data['users'] = $this->admin->getAllUsers();
        $data['roles'] = $this->admin->getAllRoles();

        $data['stats'] = [
            'total' => $this->admin->countUsers(),
            'actifs' => $this->admin->countUsersByStatus('actif'),
            'inactifs' => $this->admin->countUsersByStatus('inactif'),
            'administrateurs' => $this->admin->countAdministrators()
        ];

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/admin/users', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function storeUser()
    {
        if ($this->input->method(true) !== 'POST') {
            show_404();
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $this->form_validation->set_rules(
            'first_name',
            'Prénom',
            'trim|required|min_length[2]|max_length[100]'
        );

        $this->form_validation->set_rules(
            'last_name',
            'Nom',
            'trim|required|min_length[2]|max_length[100]'
        );

        $this->form_validation->set_rules(
            'email',
            'Adresse e-mail',
            'trim|required|valid_email|max_length[150]'
        );

        $this->form_validation->set_rules(
            'role_id',
            'Rôle',
            'trim|required|integer'
        );

        $this->form_validation->set_rules(
            'status',
            'Statut',
            'trim|required|in_list[active,inactive]'
        );

        $this->form_validation->set_rules(
            'password',
            'Mot de passe',
            'required|min_length[8]'
        );

        $this->form_validation->set_rules(
            'password_confirmation',
            'Confirmation du mot de passe',
            'required|matches[password]'
        );

        $this->form_validation->set_message(
            'required',
            'Le champ {field} est obligatoire.'
        );

        $this->form_validation->set_message(
            'valid_email',
            'Veuillez saisir une adresse e-mail valide.'
        );

        $this->form_validation->set_message(
            'matches',
            'Les mots de passe ne correspondent pas.'
        );

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata(
                'error',
                validation_errors('<div>', '</div>')
            );

            redirect('users');
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | DONNÉES
        |--------------------------------------------------------------------------
        */

        $firstName = trim(
            $this->input->post('first_name', true)
        );

        $lastName = trim(
            $this->input->post('last_name', true)
        );

        $email = strtolower(
            trim($this->input->post('email', true))
        );

        $roleId = (int) $this->input->post('role_id', true);

        $status = trim(
            $this->input->post('status', true)
        );

        $password = $this->input->post('password');

        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATIONS
        |--------------------------------------------------------------------------
        */

        if ($this->admin->emailExists($email)) {
            $this->session->set_flashdata(
                'error',
                'Cette adresse e-mail est déjà utilisée.'
            );

            redirect('users');
            return;
        }

        if (!$this->admin->roleExists($roleId)) {
            $this->session->set_flashdata(
                'error',
                'Le rôle sélectionné est invalide.'
            );

            redirect('users');
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | IDENTIFIER LA SOCIÉTÉ
        |--------------------------------------------------------------------------
        */

        $companyId = $this->session->userdata('company_id');

        if (empty($companyId)) {
            $companyId = 1;
        }

        /*
        |--------------------------------------------------------------------------
        | INSERTION
        |--------------------------------------------------------------------------
        */

        $dataUser = [
            'company_id' => (int) $companyId,

            'role_id' => $roleId,

            'first_name' => ucwords(
                strtolower($firstName)
            ),

            'last_name' => strtoupper($lastName),

            'email' => $email,

            'password_hash' => password_hash(
                $password,
                PASSWORD_BCRYPT
            ),

            'status' => $status,

            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->trans_begin();

        $userId = $this->admin->insertUser($dataUser);

        if (!$userId || $this->db->trans_status() === false) {
            $databaseError = $this->db->error();

            $this->db->trans_rollback();

            log_message(
                'error',
                'Erreur création utilisateur : ' .
                    ($databaseError['message'] ?? 'Erreur inconnue')
            );

            $this->session->set_flashdata(
                'error',
                'Une erreur est survenue pendant la création de l’utilisateur.'
            );

            redirect('users');
            return;
        }

        $this->db->trans_commit();

        $this->session->set_flashdata(
            'success',
            'L’utilisateur ' .
                html_escape($firstName . ' ' . $lastName) .
                ' a été créé avec succès.'
        );

        redirect('users');
    }

    public function updateUser()
    {
        if ($this->input->method(true) !== 'POST') {
            show_404();
        }

        $userId = (int) $this->input->post('id', true);

        if (!$this->admin->userExists($userId)) {
            $this->session->set_flashdata('error', 'L’utilisateur spécifié n’existe pas.');
            redirect('users');
            return;
        }

        $firstName = trim($this->input->post('first_name', true));
        $lastName  = trim($this->input->post('last_name', true));
        $email     = strtolower(trim($this->input->post('email', true)));
        $roleId    = (int) $this->input->post('role_id', true);
        $status    = trim($this->input->post('status', true));

        // ✔ Entreprise : chaîne vide = compte global (NULL)
        $companyIdRaw = trim((string) $this->input->post('company_id', true));
        $companyId    = ($companyIdRaw === '') ? null : (int) $companyIdRaw;

        if ($this->admin->emailExistsForOtherUser($email, $userId)) {
            $this->session->set_flashdata('error', 'Cette adresse e-mail est déjà utilisée par un autre utilisateur.');
            redirect('users');
            return;
        }

        if (!$this->admin->roleExists($roleId)) {
            $this->session->set_flashdata('error', 'Le rôle sélectionné est invalide.');
            redirect('users');
            return;
        }

        $dataUser = [
            'first_name' => ucwords(strtolower($firstName)),
            'last_name'  => strtoupper($lastName),
            'email'      => $email,
            'company_id' => $companyId,
            'role_id'    => $roleId,
            'status'     => $status,
        ];

        /* =====================================================
        ✔ RÉINITIALISATION DU MOT DE PASSE (optionnelle)
        Vide = on conserve l'ancien mot de passe
        ===================================================== */
        $password     = (string) $this->input->post('password', true);
        $confirmation = (string) $this->input->post('password_confirmation', true);

        if ($password !== '' || $confirmation !== '') {

            if ($password !== $confirmation) {
                $this->session->set_flashdata('error', 'Les deux mots de passe ne correspondent pas.');
                redirect('users');
                return;
            }

            if (strlen($password) < 8) {
                $this->session->set_flashdata('error', 'Le nouveau mot de passe doit contenir au moins 8 caractères.');
                redirect('users');
                return;
            }

            // Même format que tes hash existants ($2y$10$… = bcrypt)
            $dataUser['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (!$this->admin->updateUser($userId, $dataUser)) {
            log_message('error', 'Erreur mise à jour utilisateur ID: ' . $userId);
            $this->session->set_flashdata('error', 'Une erreur est survenue pendant la mise à jour de l’utilisateur.');
            redirect('users');
            return;
        }

        $this->session->set_flashdata('success', 'L’utilisateur a été mis à jour avec succès.');
        redirect('users');
    }

    // public function toggleStatus()
    // {
    //     $this->output->set_content_type('application/json');

    //     $id   = (int) $this->input->post('id');
    //     $user = $this->db->get_where('users', ['id' => $id])->row(); // adapte table/modèle

    //     if (!$user) {
    //         echo json_encode([
    //             'success'   => false,
    //             'message'   => 'Utilisateur introuvable.',
    //             'csrf_hash' => $this->security->get_csrf_hash(),
    //         ]);
    //         return;
    //     }

    //     $newStatus = ($user->status === 'active') ? 'inactive' : 'active';

    //     $this->db->where('id', $id)->update('users', [
    //         'status'     => $newStatus,
    //         'updated_at' => date('Y-m-d H:i:s'),
    //     ]);

    //     echo json_encode([
    //         'success'   => true,
    //         'message'   => ($newStatus === 'active')
    //             ? 'Compte activé avec succès.'
    //             : 'Compte désactivé avec succès.',
    //         'csrf_hash' => $this->security->get_csrf_hash(),
    //     ]);
    // }

    public function toggleStatus()
    {
        $this->output->set_content_type('application/json');

        $id = (int) $this->input->post('id');

        // ID manquant / invalide
        if ($id <= 0) {
            echo json_encode([
                'success'   => false,
                'message'   => 'ID utilisateur manquant.',
                'csrf_hash' => $this->security->get_csrf_hash(),
            ]);
            return;
        }

        $user = $this->db->get_where('users', ['id' => $id])->row();

        if (!$user) {
            echo json_encode([
                'success'   => false,
                'message'   => 'Utilisateur introuvable.',
                'csrf_hash' => $this->security->get_csrf_hash(),
            ]);
            return;
        }

        $newStatus = ($user->status === 'active') ? 'inactive' : 'active';

        // Uniquement les colonnes qui existent vraiment dans ta table
        $data = ['status' => $newStatus];

        $fields = $this->db->list_fields('users');
        if (in_array('updated_at', $fields, true)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $ok = $this->db->where('id', $id)->update('users', $data);

        echo json_encode([
            'success'   => (bool) $ok,
            'message'   => $ok
                ? (($newStatus === 'active') ? 'Compte activé avec succès.' : 'Compte désactivé avec succès.')
                : 'Échec de la mise à jour.',
            'csrf_hash' => $this->security->get_csrf_hash(),
        ]);
    }

    public function deleteUser()
    {
        $this->output->set_content_type('application/json');

        $id = (int) $this->input->post('id');

        if ($id <= 0) {
            echo json_encode([
                'success'   => false,
                'message'   => 'ID utilisateur manquant.',
                'csrf_hash' => $this->security->get_csrf_hash(),
            ]);
            return;
        }

        // Sécurité : interdiction de supprimer son propre compte
        if ($id === (int) $this->session->userdata('user_id')) { // adapte la clé session
            echo json_encode([
                'success'   => false,
                'message'   => 'Vous ne pouvez pas supprimer votre propre compte.',
                'csrf_hash' => $this->security->get_csrf_hash(),
            ]);
            return;
        }

        $user = $this->db->get_where('users', ['id' => $id])->row();

        if (!$user) {
            echo json_encode([
                'success'   => false,
                'message'   => 'Utilisateur introuvable.',
                'csrf_hash' => $this->security->get_csrf_hash(),
            ]);
            return;
        }

        $ok = $this->db->where('id', $id)->delete('users');

        echo json_encode([
            'success'   => (bool) $ok,
            'message'   => $ok ? 'Compte supprimé avec succès.' : 'Échec de la suppression.',
            'csrf_hash' => $this->security->get_csrf_hash(),
        ]);
    }

    // public function matriceAccess()
    // {
    //     if (!$this->session->userdata('user_id')) {
    //         redirect('sign-in');
    //         return;
    //     }

    //     $data['title'] = 'Matrice des access';

    //     $this->load->view('v1/components/layout/header', $data);
    //     $this->load->view('v1/components/layout/sidebar', $data);
    //     $this->load->view('v1/components/modules/admin/matrice_access', $data);
    //     $this->load->view('v1/components/layout/footer');
    // }

    public function matriceAccess()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['title']    = 'Matrice des access';
        $data['catalog']  = $this->permissionCatalog();
        $data['users']    = $this->db->select('users.id, users.first_name, users.last_name, users.email, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->order_by('users.first_name, users.last_name')
            ->get('users')->result();
        $data['selectedUserId'] = $this->input->get('user_id') ? (int)$this->input->get('user_id') : 0;

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/admin/matrice_access', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function matriceLoad()
    {
        $this->output->set_content_type('application/json');

        $userId = (int) $this->input->get('user_id');
        if ($userId <= 0) {
            echo json_encode(['success' => false, 'grants' => [], 'userName' => '']);
            return;
        }

        $user = $this->db->select('users.id, users.first_name, users.last_name, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('users.id', $userId)
            ->get('users')->row();

        if (!$user) {
            echo json_encode(['success' => false, 'grants' => [], 'userName' => '']);
            return;
        }

        $grants = [];
        foreach ($this->db->get_where('user_permissions', ['user_id' => $userId])->result() as $r) {
            $grants[] = $r->module_code . '.' . $r->permission_code;
        }

        echo json_encode([
            'success'  => true,
            'grants'   => $grants,
            'userName' => trim($user->first_name . ' ' . $user->last_name),
            'userRole' => $user->role_name ?? 'Aucun rôle',
        ]);
    }

    public function matriceSave()
    {
        $this->output->set_content_type('application/json');

        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
            return;
        }

        if (!$this->session->userdata('user_id')) {
            echo json_encode(['success' => false, 'message' => 'Session expirée.']);
            return;
        }

        $userId = (int) $this->input->post('user_id');
        if ($userId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Aucun utilisateur sélectionné.']);
            return;
        }

        $items   = $this->input->post('items') ?: [];
        $catalog = $this->permissionCatalog();

        $valid = [];
        foreach ($catalog as $m) foreach ($m['permissions'] as $p) $valid[$m['code'] . '.' . $p['code']] = true;

        $now  = date('Y-m-d H:i:s');
        $rows = [];
        foreach ($items as $item) {
            $parts = explode('|', (string) $item);
            if (count($parts) !== 2) continue;
            list($module, $perm) = $parts;
            if (!isset($valid[$module . '.' . $perm])) continue;
            $rows[] = ['user_id' => $userId, 'module_code' => $module, 'permission_code' => $perm, 'updated_at' => $now];
        }

        $this->db->trans_start();
        $this->db->delete('user_permissions', ['user_id' => $userId]);
        foreach (array_chunk($rows, 300) as $chunk) {
            $this->db->insert_batch('user_permissions', $chunk);
        }
        $this->db->trans_complete();

        $ok = $this->db->trans_status();
        echo json_encode([
            'success'   => $ok,
            'message'   => $ok ? 'Permissions enregistrées (' . count($rows) . ' accordées).' : "Échec de l'enregistrement.",
            'csrf_hash' => $this->security->get_csrf_hash(),
        ]);
    }

    private function permissionCatalog()
    {
        return [

            /* ---------- TABLEAU DE BORD ---------- */
            ['code' => 'dash', 'label' => 'Tableau de bord', 'icon' => 'fa-tachometer-alt', 'permissions' => [
                ['code' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'fa-tachometer-alt'],
            ]],

            /* ---------- DIRECTION GÉNÉRALE ---------- */
            ['code' => 'dg', 'label' => 'Direction Générale', 'icon' => 'fa-building', 'permissions' => [
                ['code' => 'reporting',     'label' => 'Reporting',               'icon' => 'fa-chart-bar'],
                ['code' => 'validations',   'label' => 'Validations',             'icon' => 'fa-check-double'],
                ['code' => 'notifications', 'label' => 'Notifications & Alertes', 'icon' => 'fa-bell'],
                ['code' => 'messagerie',    'label' => 'Messagerie interne',      'icon' => 'fa-envelope'],
            ]],

            /* ---------- DIRECTION TECHNIQUE ---------- */
            ['code' => 'tech', 'label' => 'Direction Technique', 'icon' => 'fa-hard-hat', 'permissions' => [
                ['code' => 'projects',              'label' => 'Projets',                 'icon' => 'fa-project-diagram'],
                ['code' => 'chantiers',             'label' => 'Chantiers & exécution',   'icon' => 'fa-hammer'],
                ['code' => 'achat',                 'label' => 'Achats & Approvisionnement', 'icon' => 'fa-shopping-cart'],
                ['code' => 'fournisseurs',          'label' => 'Fournisseurs',            'icon' => 'fa-truck'],
                ['code' => 'sous-traitant',         'label' => 'Sous-traitants',          'icon' => 'fa-people-carry'],
                ['code' => 'stock-general',         'label' => 'Stocks',                  'icon' => 'fa-boxes'],
                ['code' => 'engin-materiel',        'label' => 'Engins & Matériel',       'icon' => 'fa-truck-monster'],
                ['code' => 'maintenance-carburant', 'label' => 'Maintenance & Carburant', 'icon' => 'fa-gas-pump'],
                ['code' => 'journal-production',    'label' => 'Journal Production',      'icon' => 'fa-book'],
                ['code' => 'cout-reelle-rentebilite', 'label' => 'Coût Réel & Rentabilité', 'icon' => 'fa-chart-line'],
                ['code' => 'evaluation-chantier',   'label' => 'Evaluation Chantier',     'icon' => 'fa-clipboard-check'],
                ['code' => 'personnel-chantier',    'label' => 'Personnel Chantier',      'icon' => 'fa-users'],
                ['code' => 'pointage',              'label' => 'Pointage',                'icon' => 'fa-user-clock'],
                ['code' => 'ordre-service',         'label' => 'Ordres de service',       'icon' => 'fa-file-signature'],
            ]],

            /* ---------- DAF / FINANCE ---------- */
            ['code' => 'daf', 'label' => 'DAF / Finance', 'icon' => 'fa-coins', 'permissions' => [
                ['code' => 'finance-dashboard', 'label' => 'Tableau de bord DAF', 'icon' => 'fa-chart-pie'],
                ['code' => 'finance-rh',        'label' => 'Ressources Humaines', 'icon' => 'fa-users'],
                ['code' => 'finance-controle',  'label' => 'Contrôle de gestion', 'icon' => 'fa-chart-line'],
                ['code' => 'finance-patrimoine', 'label' => 'Patrimoine',          'icon' => 'fa-building'],
                ['code' => 'finance-ged',       'label' => 'Documents / GED',     'icon' => 'fa-folder-open'],
                ['code' => 'finance-report',    'label' => 'Rapports financiers', 'icon' => 'fa-chart-bar'],
            ]],

            /* ---------- COMPTABILITÉ ---------- */
            ['code' => 'compta', 'label' => 'Comptabilité', 'icon' => 'fa-calculator', 'permissions' => [
                ['code' => 'exercices',         'label' => 'Exercices comptables', 'icon' => 'fa-calendar-alt'],
                ['code' => 'account-classes',   'label' => 'Classes comptables',   'icon' => 'fa-folder'],
                ['code' => 'chart-accounts',    'label' => 'Plan comptable',       'icon' => 'fa-list-alt'],
                ['code' => 'journal-codes',     'label' => 'Codes journaux',       'icon' => 'fa-bookmark'],
                ['code' => 'accounting-entrys', 'label' => 'Saisie comptable',     'icon' => 'fa-edit'],
                ['code' => 'journal',           'label' => 'Journal comptable',    'icon' => 'fa-file-alt'],
                ['code' => 'grand-livre',       'label' => 'Grand livre',          'icon' => 'fa-address-book'],
                ['code' => 'balance-generale',  'label' => 'Balance générale',     'icon' => 'fa-chart-bar'],
                ['code' => 'cloture-comptable', 'label' => 'Clôture comptable',    'icon' => 'fa-lock'],
            ]],

            /* ---------- TRÉSORERIE ---------- */
            ['code' => 'treso', 'label' => 'Trésorerie', 'icon' => 'fa-wallet', 'permissions' => [
                ['code' => 'caisse',        'label' => 'Caisse',                     'icon' => 'fa-cash-register'],
                ['code' => 'compte-banques', 'label' => 'Comptes bancaires',          'icon' => 'fa-university'],
                ['code' => 'encaissements', 'label' => 'Encaissements',              'icon' => 'fa-arrow-circle-down'],
                ['code' => 'decaissements', 'label' => 'Décaissements',              'icon' => 'fa-arrow-circle-up'],
                ['code' => 'rapprochement', 'label' => 'Rapprochement bancaire',     'icon' => 'fa-exchange-alt'],
                ['code' => 'prevision',     'label' => 'Prévisions de trésorerie',   'icon' => 'fa-chart-line'],
            ]],

            /* ---------- FACTURATION ---------- */
            ['code' => 'factu', 'label' => 'Facturation', 'icon' => 'fa-file-invoice-dollar', 'permissions' => [
                ['code' => 'facture-client',      'label' => 'Factures clients',     'icon' => 'fa-file-invoice'],
                ['code' => 'facture-fournisseur', 'label' => 'Factures fournisseurs', 'icon' => 'fa-file-invoice-dollar'],
                ['code' => 'paiements',           'label' => 'Paiements',            'icon' => 'fa-money-bill-wave'],
                ['code' => 'echeances',           'label' => 'Échéances',            'icon' => 'fa-calendar-check'],
            ]],

            /* ---------- RESSOURCES HUMAINES ---------- */
            ['code' => 'rh', 'label' => 'Ressources Humaines', 'icon' => 'fa-users', 'permissions' => [
                ['code' => 'employes', 'label' => 'Employés', 'icon' => 'fa-id-badge'],
                ['code' => 'paie',     'label' => 'Paie',     'icon' => 'fa-money-check-alt'],
            ]],

            /* ---------- CRM & CLIENTS ---------- */
            ['code' => 'crm', 'label' => 'CRM & Clients', 'icon' => 'fa-handshake', 'permissions' => [
                ['code' => 'clients', 'label' => 'Clients', 'icon' => 'fa-handshake'],
                ['code' => 'devis',   'label' => 'Devis',   'icon' => 'fa-file-signature'],
            ]],

            /* ---------- ADMINISTRATION ---------- */
            ['code' => 'admin', 'label' => 'Administration', 'icon' => 'fa-cogs', 'permissions' => [
                ['code' => 'users',             'label' => 'Utilisateurs',      'icon' => 'fa-users-cog'],
                ['code' => 'matrice-access',    'label' => 'Matrice des accès', 'icon' => 'fa-th-large'],
                ['code' => 'roles-permissions', 'label' => 'Rôles & Permissions', 'icon' => 'fa-user-tag'],
                ['code' => 'settings',          'label' => 'Paramètres',        'icon' => 'fa-sliders-h'],
            ]],
        ];
    }

    // public function rolesPermissions()
    // {
    //     if (!$this->session->userdata('user_id')) {
    //         redirect('sign-in');
    //         return;
    //     }

    //     $data['title'] = 'Rôles & Permissions';
    //     $data['roles'] = $this->admin->getAllRoles();
    //     $data['permissions'] = $this->permissionCatalog();

    //     $this->load->view('v1/components/layout/header', $data);
    //     $this->load->view('v1/components/layout/sidebar', $data);
    //     $this->load->view('v1/components/modules/admin/roles_permissions', $data);
    //     $this->load->view('v1/components/layout/footer');
    // }

    public function rolesPermissions()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['title']       = 'Rôles & Permissions';
        $data['roles']       = $this->admin->getAllRoles();
        $data['permissions'] = $this->permissionCatalog();

        // ✔ Compteurs réels par rôle
        $stats = [];
        foreach ($this->db->select('role_id, COUNT(*) AS n')->group_by('role_id')->get('users')->result() as $r) {
            $stats[$r->role_id]['users'] = (int) $r->n;
        }
        foreach ($this->db->select('role_id, COUNT(*) AS n')->group_by('role_id')->get('role_permissions')->result() as $r) {
            $stats[$r->role_id]['perms'] = (int) $r->n;
        }
        $data['roleStats'] = $stats;

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/admin/roles_permissions', $data);
        $this->load->view('v1/components/layout/footer');
    }

    /* ---------- Créer / modifier un rôle ---------- */
    public function roleSave()
    {
        $this->output->set_content_type('application/json');
        if ($this->input->method() !== 'post' || !$this->session->userdata('user_id')) {
            echo json_encode(['success' => false, 'message' => 'Requête non autorisée.']);
            return;
        }

        $id   = (int) $this->input->post('id');
        $name = trim((string) $this->input->post('name'));
        $code = strtoupper(trim((string) $this->input->post('code')));

        if ($name === '' || $code === '') {
            echo json_encode(['success' => false, 'message' => 'Nom et code obligatoires.']);
            return;
        }
        if (!preg_match('/^[A-Z0-9_]+$/', $code)) {
            echo json_encode(['success' => false, 'message' => 'Code invalide (A-Z, 0-9, _ uniquement).']);
            return;
        }

        // Unicité du code
        $q = $this->db->where('code', $code);
        if ($id > 0) $q->where('id !=', $id);
        if ($q->count_all_results('roles') > 0) {
            echo json_encode(['success' => false, 'message' => 'Ce code de rôle existe déjà.']);
            return;
        }

        if ($id > 0) {
            $this->db->where('id', $id)->update('roles', ['name' => $name, 'code' => $code]);
            $msg = 'Rôle modifié avec succès.';
        } else {
            $this->db->insert('roles', ['name' => $name, 'code' => $code]);
            $msg = 'Rôle créé avec succès.';
        }

        echo json_encode(['success' => true, 'message' => $msg, 'csrf_hash' => $this->security->get_csrf_hash()]);
    }

    /* ---------- Supprimer un rôle ---------- */
    public function roleDelete()
    {
        $this->output->set_content_type('application/json');
        if ($this->input->method() !== 'post' || !$this->session->userdata('user_id')) {
            echo json_encode(['success' => false, 'message' => 'Requête non autorisée.']);
            return;
        }

        $id = (int) $this->input->post('id');

        if ($id === (int) $this->session->userdata('role_id')) {
            echo json_encode(['success' => false, 'message' => 'Vous ne pouvez pas supprimer votre propre rôle.']);
            return;
        }

        $users = $this->db->where('role_id', $id)->count_all_results('users');
        if ($users > 0) {
            echo json_encode(['success' => false, 'message' => "Suppression impossible : $users utilisateur(s) possèdent ce rôle."]);
            return;
        }

        $this->db->where('id', $id)->delete('roles'); // role_permissions nettoyé par ON DELETE CASCADE

        echo json_encode(['success' => true, 'message' => 'Rôle supprimé avec succès.', 'csrf_hash' => $this->security->get_csrf_hash()]);
    }

    /* ---------- Charger les permissions d'un rôle ---------- */
    public function rolePermissionsLoad()
    {
        $this->output->set_content_type('application/json');
        $roleId = (int) $this->input->get('role_id');

        $grants = [];
        if ($roleId > 0) {
            foreach ($this->db->get_where('role_permissions', ['role_id' => $roleId])->result() as $r) {
                $grants[] = $r->module_code . '|' . $r->permission_code;
            }
        }
        echo json_encode(['success' => true, 'grants' => $grants]);
    }

    /* ---------- Enregistrer les permissions d'un rôle ---------- */
    public function rolePermissionsSave()
    {
        $this->output->set_content_type('application/json');
        if ($this->input->method() !== 'post' || !$this->session->userdata('user_id')) {
            echo json_encode(['success' => false, 'message' => 'Requête non autorisée.']);
            return;
        }

        $roleId = (int) $this->input->post('role_id');
        if ($roleId <= 0 || $this->db->where('id', $roleId)->count_all_results('roles') === 0) {
            echo json_encode(['success' => false, 'message' => 'Rôle introuvable.']);
            return;
        }

        $items   = $this->input->post('items') ?: [];
        $catalog = $this->permissionCatalog();
        $valid   = [];
        foreach ($catalog as $m) foreach ($m['permissions'] as $p) $valid[$m['code'] . '|' . $p['code']] = true;

        $now  = date('Y-m-d H:i:s');
        $rows = [];
        foreach ($items as $item) {
            if (!isset($valid[$item])) continue;
            list($module, $perm) = explode('|', $item);
            $rows[] = ['role_id' => $roleId, 'module_code' => $module, 'permission_code' => $perm, 'updated_at' => $now];
        }

        $this->db->trans_start();
        $this->db->delete('role_permissions', ['role_id' => $roleId]);
        foreach (array_chunk($rows, 300) as $chunk) {
            $this->db->insert_batch('role_permissions', $chunk);
        }
        $this->db->trans_complete();

        $ok = $this->db->trans_status();
        echo json_encode([
            'success'   => $ok,
            'message'   => $ok ? 'Permissions enregistrées (' . count($rows) . ' accordées).' : "Échec de l'enregistrement.",
            'csrf_hash' => $this->security->get_csrf_hash(),
        ]);
    }

    public function settings()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['title'] = 'Paramètres';

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar', $data);
        $this->load->view('v1/components/modules/admin/settings', $data);
        $this->load->view('v1/components/layout/footer');
    }
}
