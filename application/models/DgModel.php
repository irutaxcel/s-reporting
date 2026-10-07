<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DgModel extends CI_Model
{
    /**
     * @var string Table des bons de paiement
     */
    public string $table_vouchers;

    /**
     * @var string Table des items de demande
     */
    public string $table_items;

    /**
     * @var string Table des formulaires de demande
     */
    public string $table_forms;

    /* ==========================================================
       Configuration du tableau de bord DG
       ========================================================== */

    /** Entreprise par défaut si la session ne contient pas company_id (SATRACO) */
    const DEFAULT_COMPANY_ID = 2;

    /** Tables utilisées par le tableau de bord */
    private $t = [
        'projets'    => 'projects',
        'chantiers'  => 'chantiers',
        'demandes'   => 'purchase_request_forms',
        'paiements'  => 'purchase_payment_vouchers',
        'caisses'    => 'tbl_finance_cashbox',
        'banques'    => 'tbl_finance_bank_account',
        'banque_ops' => 'tbl_finance_bank_operation',
        'employes'   => 'tbl_employes',
        'engins'     => 'tbl_engin_materiel',
        'users'      => 'users',
    ];

    /** Statuts de chantier considérés comme "actifs" (comparés en minuscules) */
    private $chantierActifSql = "LOWER(c.status) IN ('actif', 'en cours', 'en_cours')";

    /** Demandes qui attendent la décision du DG */
    private $attenteDgSql = "d.dg_status = 'en_attente' AND d.requires_validation = 1 AND d.workflow_status <> 'brouillon'";

    private $companyId;

    public function __construct()
    {
        parent::__construct();

        // Initialisation des tables
        $this->table_vouchers = 'purchase_payment_vouchers';
        $this->table_items    = 'purchase_request_items';
        $this->table_forms    = 'purchase_request_forms';

        // Entreprise courante pour le tableau de bord
        $cid = $this->session->userdata('company_id');
        $this->companyId = $cid ? (int) $cid : self::DEFAULT_COMPANY_ID;
    }

    /**
     * Récupérer les bons de paiement en attente pour l'utilisateur connecté
     *
     * @param int $user_id ID de l'utilisateur
     * @return array Liste des bons de paiement
     */
    public function getPendingVouchersByUser(int $user_id): array
    {
        $this->db->select('pv.*, pf.destination_chantier, pf.requested_by, pf.buyer_name, pf.category_type');
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pv.created_by', $user_id);
        $this->db->where('pv.payment_status', 'en_attente');
        $this->db->order_by('pv.payment_date', 'DESC');

        return $this->db->get()->result();
    }

    /**
     * Récupérer tous les bons de paiement (tous statuts) pour l'utilisateur
     *
     * @param int $user_id ID de l'utilisateur
     * @return array Liste des bons de paiement
     */
    public function getAllVouchersByUser(int $user_id): array
    {
        $this->db->select('pv.*, pf.destination_chantier, pf.requested_by, pf.buyer_name, pf.category_type');
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pv.created_by', $user_id);
        $this->db->order_by('pv.payment_date', 'DESC');

        return $this->db->get()->result();
    }

    /**
     * Récupérer les items d'une demande d'achat
     *
     * @param int $request_id ID de la demande
     * @return array Liste des items
     */
    public function getRequestItems(int $request_id): array
    {
        $this->db->where('request_id', $request_id);
        $this->db->order_by('id', 'ASC');

        return $this->db->get($this->table_items)->result();
    }

    /**
     * Récupérer un bon de paiement par son ID
     *
     * @param int $voucher_id ID du bon de paiement
     * @return object|null
     */
    public function getVoucherById(int $voucher_id)
    {
        $this->db->where('id', $voucher_id);
        return $this->db->get($this->table_vouchers)->row();
    }

    /**
     * Compter les vouchers par statut pour un utilisateur
     *
     * @param int $user_id ID de l'utilisateur
     * @return array
     */
    public function countVouchersByStatus(int $user_id): array
    {
        $this->db->select('payment_status, COUNT(*) as count');
        $this->db->where('created_by', $user_id);
        $this->db->group_by('payment_status');
        $results = $this->db->get($this->table_vouchers)->result();

        $counts = ['en_attente' => 0, 'effectue' => 0, 'annule' => 0];
        foreach ($results as $row) {
            if (isset($counts[$row->payment_status])) {
                $counts[$row->payment_status] = (int) $row->count;
            }
        }

        return $counts;
    }

    /**
     * Récupérer les demandes d'achat avec leurs items pour l'utilisateur connecté
     */
    public function getDemandesAchatByUser(int $user_id): array
    {
        $this->db->select('pf.*, pv.payment_number, pv.payment_status, pv.amount_paid as montant_autorise');
        $this->db->from($this->table_forms . ' pf');
        $this->db->join($this->table_vouchers . ' pv', 'pf.id = pv.request_id', 'left');
        $this->db->where('pf.company_id', 2); // Company ID = 2 (SATRACO)
        $this->db->where('pv.payment_status', 'en_attente');
        $this->db->order_by('pf.id', 'DESC');

        return $this->db->get()->result();
    }

    /**
     * Récupérer la liste unique des chantiers pour le filtre
     */
    public function getListeChantiers(): array
    {
        $sql = "SELECT DISTINCT `name` 
            FROM `chantiers` 
            WHERE `company_id` = 2 
            AND `name` IS NOT NULL 
            AND `name` != '' 
            ORDER BY `name` ASC";

        $result = $this->db->query($sql)->result();

        $chantiers = [];
        foreach ($result as $row) {
            $chantiers[] = $row->name;
        }

        return $chantiers;
    }

    /**
     * Récupérer les demandes d'achat groupées par chantier avec filtres
     * (AFFICHE TOUTES les demandes, y compris celles déjà payées)
     */
    public function getDemandesByChantier($user_id = null, $date_debut = null, $date_fin = null, $chantier_filtre = null): array
    {
        $this->db->select('pf.*, 
                pv.id as voucher_id, 
                pv.request_id, 
                pv.payment_number, 
                pv.payment_status, 
                pv.amount_paid as montant_autorise,
                u.first_name,
                u.last_name,
                CONCAT(u.first_name, " ", u.last_name) as demandeur_nom');
        $this->db->from($this->table_forms . ' pf');
        $this->db->join($this->table_vouchers . ' pv', 'pf.id = pv.request_id', 'left');
        $this->db->join('users u', 'pf.created_by = u.id', 'left');

        $this->db->where('pf.company_id', 2);

        if ($date_debut && $date_fin) {
            $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
            $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
        }
        if ($chantier_filtre && $chantier_filtre !== 'tous') {
            $this->db->where('pf.destination_chantier', $chantier_filtre);
        }
        if ($user_id) {
            $this->db->where('pv.created_by', $user_id);
        }

        $this->db->order_by('pf.destination_chantier', 'ASC');
        $this->db->order_by('pf.id', 'DESC');

        return $this->db->get()->result();
    }

    public function getVoucherStatistics($user_id = null, $date_debut = null, $date_fin = null, $chantier_filtre = null): array
    {
        // ✅ ÉTAPE 1 : Récupérer les IDs des demandes déjà payées
        $this->db->select('purchase_request_id');
        $this->db->from('tbl_finance_mouvement_secondaire');
        $this->db->where('status', 'validated');
        $this->db->where('purchase_request_id IS NOT NULL');
        $paid_requests = $this->db->get()->result();

        $paid_ids = [0];
        foreach ($paid_requests as $row) {
            $paid_ids[] = $row->purchase_request_id;
        }

        // Condition WHERE NOT IN manuelle pour plus de flexibilité
        $exclude_condition = "pf.id NOT IN (" . implode(',', $paid_ids) . ")";

        // 1. Total demandé
        $this->db->select_sum('pv.amount_paid');
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);
        $this->db->where($exclude_condition);

        if ($date_debut && $date_fin) {
            $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
            $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
        }
        if ($chantier_filtre && $chantier_filtre !== 'tous') {
            $this->db->where('pf.destination_chantier', $chantier_filtre);
        }
        if ($user_id) {
            $this->db->where('pv.created_by', $user_id);
        }
        $total_demande = $this->db->get()->row()->amount_paid ?? 0;

        // 2. Total autorisé
        // Ne compte que les demandes déjà effectuées (payées) : un montant simplement saisi/autorisé
        // sur une demande encore en attente n'est pas encore un montant "exécuté".
        $this->db->select_sum('pv.amount_paid');
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);
        $this->db->where('pv.amount_paid >', 0);
        $this->db->where('pv.payment_status', 'effectue');
        $this->db->where($exclude_condition);

        if ($date_debut && $date_fin) {
            $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
            $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
        }
        if ($chantier_filtre && $chantier_filtre !== 'tous') {
            $this->db->where('pf.destination_chantier', $chantier_filtre);
        }
        if ($user_id) {
            $this->db->where('pv.created_by', $user_id);
        }
        $total_autorise = $this->db->get()->row()->amount_paid ?? 0;

        // 3. Nombre total
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);
        $this->db->where($exclude_condition);

        if ($date_debut && $date_fin) {
            $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
            $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
        }
        if ($chantier_filtre && $chantier_filtre !== 'tous') {
            $this->db->where('pf.destination_chantier', $chantier_filtre);
        }
        if ($user_id) {
            $this->db->where('pv.created_by', $user_id);
        }
        $nb_demandes = $this->db->count_all_results();

        // 4. Nombre en attente
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);
        $this->db->where('pv.amount_paid', 0);
        $this->db->where($exclude_condition);

        if ($date_debut && $date_fin) {
            $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
            $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
        }
        if ($chantier_filtre && $chantier_filtre !== 'tous') {
            $this->db->where('pf.destination_chantier', $chantier_filtre);
        }
        if ($user_id) {
            $this->db->where('pv.created_by', $user_id);
        }
        $nb_en_attente = $this->db->count_all_results();

        // 5. Nombre effectué
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);
        $this->db->where('pv.amount_paid >', 0);
        $this->db->where($exclude_condition);

        if ($date_debut && $date_fin) {
            $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
            $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
        }
        if ($chantier_filtre && $chantier_filtre !== 'tous') {
            $this->db->where('pf.destination_chantier', $chantier_filtre);
        }
        if ($user_id) {
            $this->db->where('pv.created_by', $user_id);
        }
        $nb_effectue = $this->db->count_all_results();

        $ecart = $total_demande - $total_autorise;
        $taux_autorisation = $total_demande > 0 ? round(($total_autorise / $total_demande) * 100, 1) : 0;

        return [
            'total_demande'       => (float) $total_demande,
            'total_autorise'      => (float) $total_autorise,
            'nb_demandes'         => (int) $nb_demandes,
            'nb_en_attente'       => (int) $nb_en_attente,
            'nb_effectue'         => (int) $nb_effectue,
            'ecart'               => (float) $ecart,
            'taux_autorisation'   => (float) $taux_autorisation,
        ];
    }

    public function getVouchersByChantier($user_id = null, $date_debut = null, $date_fin = null, $chantier_filtre = null): array
    {
        // ✅ ÉTAPE 1 : Récupérer les IDs des demandes déjà payées
        $this->db->select('purchase_request_id');
        $this->db->from('tbl_finance_mouvement_secondaire');
        $this->db->where('status', 'validated');
        $this->db->where('purchase_request_id IS NOT NULL');
        $paid_requests = $this->db->get()->result();

        $paid_ids = [0];
        foreach ($paid_requests as $row) {
            $paid_ids[] = $row->purchase_request_id;
        }

        $this->db->select('pf.destination_chantier, pv.payment_status, SUM(pv.amount_paid) as total');
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);

        // ✅ Exclure les demandes déjà payées
        $this->db->where_not_in('pf.id', $paid_ids);

        if ($user_id) {
            $this->db->where('pv.created_by', $user_id);
        }
        if ($date_debut && $date_fin) {
            $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
            $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
        }
        if ($chantier_filtre && $chantier_filtre !== 'tous') {
            $this->db->where('pf.destination_chantier', $chantier_filtre);
        }

        $this->db->group_by('pf.destination_chantier, pv.payment_status');

        return $this->db->get()->result();
    }

    /**
     * Mettre à jour le montant autorisé d'un bon de paiement
     *
     * @param int $voucher_id ID du bon de paiement
     * @param float $montant_autorise Montant autorisé
     * @return bool
     */
    public function updateMontantAutorise(int $voucher_id, float $montant_autorise): bool
    {
        $data = [
            'amount_paid' => $montant_autorise,
            'payment_status' => $montant_autorise > 0 ? 'effectue' : 'en_attente',  // ← Auto-update statut
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $voucher_id);
        return $this->db->update($this->table_vouchers, $data);
    }

    /**
     * Récupérer le voucher_id associé à une demande
     *
     * @param int $request_id ID de la demande
     * @return object|null
     */
    public function getVoucherByRequestId(int $request_id)
    {
        $this->db->where('request_id', $request_id);
        return $this->db->get($this->table_vouchers)->row();
    }

    /**
     * Générer une référence unique pour la sortie (SC-2026-XXX)
     */
    public function genererReferenceSortie(): string
    {
        $annee = date('Y');
        $prefix = 'SC-' . $annee . '-';

        // Récupérer le dernier numéro de l'année en cours
        $this->db->select('reference');
        $this->db->from('tbl_relation_publique');
        $this->db->like('reference', $prefix, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get()->row();

        if ($last) {
            // Extraire le numéro et incrémenter
            $parts = explode('-', $last->reference);
            $numero = (int) end($parts) + 1;
        } else {
            $numero = 1;
        }

        return $prefix . str_pad($numero, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Insérer une sortie de caisse relation publique
     */
    public function insertSortieRelationPublique($data): int
    {
        $this->db->insert('tbl_relation_publique', $data);
        return $this->db->insert_id();
    }

    /**
     * Enregistrer la sortie dans le livre de caisse principale
     * (Mouvement de sortie directement enregistré)
     */
    public function enregistrerDansCaissePrincipale($data): bool
    {
        // ============================================
        // ÉTAPE 1 : Récupérer le solde actuel de la caisse principale
        // ============================================
        $this->db->select('current_balance');
        $this->db->from('tbl_finance_cashbox');
        $this->db->where('role', 'principale');
        $this->db->where('status', 'active');
        $this->db->limit(1);
        $cashbox = $this->db->get()->row();

        $balance_before = $cashbox ? (float) $cashbox->current_balance : 0;
        $balance_after  = $balance_before - (float) $data['montant'];

        // Vérifier que le solde est suffisant
        if ($balance_after < 0) {
            // Optionnel : Retourner false ou lancer une exception
            // return false;
        }

        // ============================================
        // ÉTAPE 2 : Générer une référence pour le mouvement (MVP-2026-XXX)
        // ============================================
        $annee = date('Y');
        $prefix = 'MVP-' . $annee . '-';

        $this->db->select('reference');
        $this->db->from('tbl_finance_mouvement_principale');
        $this->db->like('reference', $prefix, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $lastMouvement = $this->db->get()->row();

        if ($lastMouvement) {
            $parts = explode('-', $lastMouvement->reference);
            $numero = (int) end($parts) + 1;
        } else {
            $numero = 1;
        }

        $refMouvement = $prefix . str_pad($numero, 4, '0', STR_PAD_LEFT);

        // ============================================
        // ÉTAPE 3 : Préparer les données du mouvement
        // ============================================
        $mouvement = [
            'reference'         => $refMouvement,
            'sens'              => 'sortie',
            'nature'            => 'sortie_rp',           // Sortie Relation Publique
            'movement_date'     => $data['date_sortie'],
            'amount'            => (float) $data['montant'],
            'balance_before'    => $balance_before,
            'balance_after'     => $balance_after,
            'devise'            => 'BIF',
            'transfer_reference' => NULL,
            'third_party'       => $data['beneficiaire'],
            'category'          => 'Relation Publique',
            'payment_method'    => 'cash',
            'document_number'   => $data['reference'],
            'attachment'        => NULL,
            'label'             => 'Sortie RP - ' . $data['reference'],
            'observation'       => $data['motif'] . (!empty($data['observation']) ? ' | ' . $data['observation'] : ''),
            'status'            => 'validated',
            'created_by'        => $data['created_by'],
            'validated_by'      => NULL,
            'created_at'        => $data['created_at'],
            'updated_at'        => NULL
        ];

        // ============================================
        // ÉTAPE 4 : Insérer dans tbl_finance_mouvement_principale
        // ============================================
        $insertMouvement = $this->db->insert('tbl_finance_mouvement_principale', $mouvement);

        if (!$insertMouvement) {
            return false;
        }

        // ============================================
        // ÉTAPE 5 : Mettre à jour le solde de la caisse principale
        // ============================================
        $this->db->where('role', 'principale');
        $this->db->where('status', 'active');
        $this->db->update('tbl_finance_cashbox', [
            'current_balance' => $balance_after,
            'updated_at'      => date('Y-m-d H:i:s')
        ]);

        return true;
    }

    /**
     * Récupérer toutes les sorties de caisse relation publique avec filtres
     */
    public function getSortiesRelationPublique($date_debut = null, $date_fin = null, $status = null, $beneficiaire = null): array
    {
        $this->db->select('*');
        $this->db->from('tbl_relation_publique');
        $this->db->where('company_id', 2);

        if ($date_debut && $date_fin) {
            $this->db->where('date_sortie >=', $date_debut);
            $this->db->where('date_sortie <=', $date_fin);
        }

        if ($status) {
            $this->db->where('status', $status);
        }

        if ($beneficiaire) {
            $this->db->like('beneficiaire', $beneficiaire);
        }

        $this->db->order_by('date_sortie', 'DESC');
        $this->db->order_by('id', 'DESC');

        return $this->db->get()->result();
    }

    /**
     * Récupérer les statistiques des sorties
     */
    public function getStatistiquesSortiesRP($date_debut = null, $date_fin = null): array
    {
        $this->db->select('
        COUNT(*) as total_sorties,
        SUM(montant) as total_montant,
        SUM(CASE WHEN status = "valide" THEN montant ELSE 0 END) as total_valide,
        SUM(CASE WHEN status = "en_attente" THEN montant ELSE 0 END) as total_en_attente
    ');
        $this->db->from('tbl_relation_publique');
        $this->db->where('company_id', 2);

        if ($date_debut && $date_fin) {
            $this->db->where('date_sortie >=', $date_debut);
            $this->db->where('date_sortie <=', $date_fin);
        }

        $result = $this->db->get()->row();

        return [
            'total_sorties'       => (int) ($result->total_sorties ?? 0),
            'total_montant'       => (float) ($result->total_montant ?? 0),
            'total_valide'        => (float) ($result->total_valide ?? 0),
            'total_en_attente'    => (float) ($result->total_en_attente ?? 0),
        ];
    }

    /**
     * Récupérer une sortie RP par son ID
     */
    public function getSortieRPById($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tbl_relation_publique')->row();
    }

    /**
     * Supprimer une sortie RP et mettre à jour la caisse
     */
    public function deleteSortieRP($id, $sortie): bool
    {
        $this->db->trans_start(); // Début de transaction

        try {
            // ============================================
            // ÉTAPE 1 : Supprimer le mouvement dans tbl_finance_mouvement_principale
            // ============================================
            $this->db->where('document_number', $sortie->reference);
            $this->db->delete('tbl_finance_mouvement_principale');

            // ============================================
            // ÉTAPE 2 : Mettre à jour le solde de la caisse principale (réajouter le montant)
            // ============================================
            $this->db->select('current_balance');
            $this->db->from('tbl_finance_cashbox');
            $this->db->where('role', 'principale');
            $this->db->where('status', 'active');
            $cashbox = $this->db->get()->row();

            $current_balance = $cashbox ? (float) $cashbox->current_balance : 0;
            $new_balance = $current_balance + (float) $sortie->montant;

            $this->db->where('role', 'principale');
            $this->db->where('status', 'active');
            $this->db->update('tbl_finance_cashbox', [
                'current_balance' => $new_balance,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // ============================================
            // ÉTAPE 3 : Supprimer la sortie dans tbl_relation_publique
            // ============================================
            $this->db->where('id', $id);
            $this->db->delete('tbl_relation_publique');

            $this->db->trans_complete(); // Fin de transaction

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            }

            return true;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Erreur suppression sortie RP ID ' . $id . ': ' . $e->getMessage());
            return false;
        }
    }

    /* ##########################################################
       ##                TABLEAU DE BORD DG                    ##
       ########################################################## */

    /** Filtre entreprise pour les tables qui ont company_id */
    private function cf($alias)
    {
        return $this->companyId ? " AND {$alias}.company_id = " . (int) $this->companyId : '';
    }

    /**
     * Exécute une requête sans faire planter la page.
     * En cas d'erreur (table/colonne inexistante), retourne null et écrit l'erreur dans application/logs/.
     */
    private function run($sql, $binds = [])
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        $query = $this->db->query($sql, $binds);
        $this->db->db_debug = $debug;

        if ($query === false) {
            $err = $this->db->error();
            log_message('error', '[DgModel] ' . $err['message'] . ' | SQL: ' . preg_replace('/\s+/', ' ', $sql));
            return null;
        }
        return $query;
    }

    private function scalar($sql, $binds = [])
    {
        $q = $this->run($sql, $binds);
        if (!$q) return 0;
        $row = $q->row_array();
        return ($row && $row['val'] !== null) ? (float) $row['val'] : 0;
    }

    /** Colonne de soft delete de tbl_engin_materiel (1 = actif) si elle existe */
    private function enginActifSql()
    {
        foreach (['is_active', 'actif', 'active', 'statut_actif', 'visible'] as $col) {
            if ($this->db->field_exists($col, $this->t['engins'])) {
                return " AND e.{$col} = 1";
            }
        }
        return '';
    }

    /* ---------------- KPI ---------------- */
    public function getKpis($annee)
    {
        $t = $this->t;

        // Trésorerie : caisses actives (BIF) + comptes bancaires actifs
        $caisses = $this->scalar(
            "SELECT COALESCE(SUM(current_balance), 0) AS val
             FROM {$t['caisses']}
             WHERE status = 'active' AND devise = 'BIF'"
        );
        $banques = $this->scalar(
            "SELECT COALESCE(SUM(current_balance), 0) AS val
             FROM {$t['banques']}
             WHERE status = 'active'"
        );

        return [
            'chantiers_actifs' => (int) $this->scalar(
                "SELECT COUNT(*) AS val FROM {$t['chantiers']} c
                 WHERE {$this->chantierActifSql}" . $this->cf('c')
            ),

            'projets' => (int) $this->scalar(
                "SELECT COUNT(*) AS val FROM {$t['projets']}"
            ),

            'paiements_annee' => $this->scalar(
                "SELECT COALESCE(SUM(v.amount_paid), 0) AS val
                 FROM {$t['paiements']} v
                 WHERE v.payment_status = 'effectue' AND YEAR(v.payment_date) = ?" . $this->cf('v'),
                [$annee]
            ),

            'tresorerie'        => $caisses + $banques,
            'tresorerie_caisse' => $caisses,
            'tresorerie_banque' => $banques,

            'demandes_attente' => (int) $this->scalar(
                "SELECT COUNT(*) AS val FROM {$t['demandes']} d
                 WHERE {$this->attenteDgSql}" . $this->cf('d')
            ),

            'effectif' => (int) $this->scalar(
                "SELECT COUNT(*) AS val FROM {$t['employes']} WHERE statut = 'Actif'"
            ),
        ];
    }

    /* ---------- Engagements (demandes) vs Paiements effectués, par mois ---------- */
    public function getMonthlyFinance($annee)
    {
        $engagements = array_fill(1, 12, 0);
        $paiements   = array_fill(1, 12, 0);

        $q = $this->run(
            "SELECT MONTH(COALESCE(d.request_date, DATE(d.created_at))) AS m,
                    SUM(d.total_amount) AS total
             FROM {$this->t['demandes']} d
             WHERE d.workflow_status <> 'brouillon'
               AND YEAR(COALESCE(d.request_date, DATE(d.created_at))) = ?" . $this->cf('d') . "
             GROUP BY m",
            [$annee]
        );
        if ($q) {
            foreach ($q->result_array() as $r) {
                $engagements[(int) $r['m']] = (float) $r['total'];
            }
        }

        $q = $this->run(
            "SELECT MONTH(v.payment_date) AS m, SUM(v.amount_paid) AS total
             FROM {$this->t['paiements']} v
             WHERE v.payment_status = 'effectue' AND YEAR(v.payment_date) = ?" . $this->cf('v') . "
             GROUP BY m",
            [$annee]
        );
        if ($q) {
            foreach ($q->result_array() as $r) {
                $paiements[(int) $r['m']] = (float) $r['total'];
            }
        }

        return [
            'engagements' => array_values($engagements),
            'paiements'   => array_values($paiements),
        ];
    }

    /* ---------------- Chantiers par statut ---------------- */
    public function getChantiersByStatus()
    {
        $q = $this->run(
            "SELECT c.status, COUNT(*) AS total
             FROM {$this->t['chantiers']} c
             WHERE 1 = 1" . $this->cf('c') . "
             GROUP BY c.status
             ORDER BY total DESC"
        );
        return $q ? $q->result_array() : [];
    }

    /* ---------- Chantiers actifs + montant déjà payé sur leurs demandes ---------- */
    public function getChantiersEnCours($limit = 8)
    {
        $q = $this->run(
            "SELECT c.id, c.ref_chantier, c.name, c.chef_chantier, c.location,
                    c.budget, c.date_debut, c.date_fin_prevue,
                    COALESCE(p.depense, 0) AS depense
             FROM {$this->t['chantiers']} c
             LEFT JOIN (
                 SELECT r.chantier_id, SUM(v.amount_paid) AS depense
                 FROM {$this->t['paiements']} v
                 INNER JOIN {$this->t['demandes']} r ON r.id = v.request_id
                 WHERE v.payment_status = 'effectue'
                 GROUP BY r.chantier_id
             ) p ON p.chantier_id = c.id
             WHERE {$this->chantierActifSql}" . $this->cf('c') . "
             ORDER BY (c.date_fin_prevue IS NULL), c.date_fin_prevue ASC
             LIMIT " . (int) $limit
        );
        return $q ? $q->result_array() : [];
    }

    /* ---------------- Demandes en attente de validation DG ---------------- */
    public function getPendingValidations($limit = 6)
    {
        $q = $this->run(
            "SELECT d.id,
                    CONCAT('DA-', LPAD(d.id, 4, '0')) AS reference,
                    d.destination_chantier AS object,
                    d.total_amount,
                    COALESCE(d.request_date, DATE(d.created_at)) AS created_at,
                    d.requested_by AS demandeur
             FROM {$this->t['demandes']} d
             WHERE {$this->attenteDgSql}" . $this->cf('d') . "
             ORDER BY d.created_at ASC
             LIMIT " . (int) $limit
        );
        return $q ? $q->result_array() : [];
    }

    /* ---------------- Alertes (seulement celles avec au moins 1 élément) ---------------- */
    public function getAlertes()
    {
        $t = $this->t;
        $alertes = [];

        $n = (int) $this->scalar(
            "SELECT COUNT(*) AS val FROM {$t['chantiers']} c
             WHERE c.date_fin_prevue < CURDATE() AND {$this->chantierActifSql}" . $this->cf('c')
        );
        if ($n > 0) {
            $alertes[] = [
                'icon' => 'fa-hard-hat',
                'color' => 'danger',
                'label' => 'Chantiers en retard',
                'count' => $n,
                'url' => 'chantiers'
            ];
        }

        $n = (int) $this->scalar(
            "SELECT COUNT(*) AS val FROM {$t['caisses']}
             WHERE status = 'active' AND alert_threshold > 0 AND current_balance < alert_threshold"
        );
        if ($n > 0) {
            $alertes[] = [
                'icon' => 'fa-cash-register',
                'color' => 'warning',
                'label' => 'Caisses sous le seuil d\'alerte',
                'count' => $n,
                'url' => 'caisse'
            ];
        }

        $n = (int) $this->scalar(
            "SELECT COUNT(*) AS val FROM {$t['engins']} e
             WHERE e.etat NOT IN ('Disponible', 'Sur chantier') AND e.date_reforme IS NULL" . $this->enginActifSql()
        );
        if ($n > 0) {
            $alertes[] = [
                'icon' => 'fa-tools',
                'color' => 'warning',
                'label' => 'Engins indisponibles (maintenance / panne)',
                'count' => $n,
                'url' => 'engin-materiel'
            ];
        }

        $n = (int) $this->scalar(
            "SELECT COUNT(*) AS val FROM {$t['employes']}
             WHERE statut = 'Actif'
               AND date_fin_contrat BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)"
        );
        if ($n > 0) {
            $alertes[] = [
                'icon' => 'fa-file-contract',
                'color' => 'info',
                'label' => 'Contrats expirant sous 30 jours',
                'count' => $n,
                'url' => 'rh-contrats'
            ];
        }

        return $alertes;
    }

        /* ##########################################################
       ##             INDICATEURS DE PERFORMANCE               ##
       ########################################################## */

    /** Statuts DG considérés comme "approuvé" / "rejeté" */
    private $dgApprouveSql = "(LOWER(d.dg_status) LIKE 'valid%' OR LOWER(d.dg_status) LIKE 'approuv%')";
    private $dgRejeteSql   = "(LOWER(d.dg_status) LIKE 'rejet%' OR LOWER(d.dg_status) LIKE 'refus%')";

    /** Date de référence d'une demande */
    private $dateDemandeSql = "COALESCE(d.request_date, DATE(d.created_at))";

    /** Comme scalar(), mais retourne null s'il n'y a pas de donnée (utile pour les moyennes) */
    private function scalarNull($sql, $binds = [])
    {
        $q = $this->run($sql, $binds);
        if (!$q) return null;
        $row = $q->row_array();
        return ($row && $row['val'] !== null) ? (float) $row['val'] : null;
    }

    /** Sous-requête : montant payé par chantier */
    private function depenseParChantierSql()
    {
        return "SELECT r.chantier_id, SUM(v.amount_paid) AS depense
                FROM {$this->t['paiements']} v
                INNER JOIN {$this->t['demandes']} r ON r.id = v.request_id
                WHERE v.payment_status = 'effectue'
                GROUP BY r.chantier_id";
    }

    /* ---------- KPI de performance d'une année (comparables N / N-1) ---------- */
    public function getPerfKpis($annee)
    {
        $t = $this->t;
        $whereDemandes = "d.workflow_status <> 'brouillon' AND YEAR({$this->dateDemandeSql}) = ?" . $this->cf('d');

        $engage = $this->scalar(
            "SELECT COALESCE(SUM(d.total_amount), 0) AS val FROM {$t['demandes']} d WHERE {$whereDemandes}",
            [$annee]
        );

        $nbDemandes = (int) $this->scalar(
            "SELECT COUNT(*) AS val FROM {$t['demandes']} d WHERE {$whereDemandes}",
            [$annee]
        );

        $paye = $this->scalar(
            "SELECT COALESCE(SUM(v.amount_paid), 0) AS val
             FROM {$t['paiements']} v
             WHERE v.payment_status = 'effectue' AND YEAR(v.payment_date) = ?" . $this->cf('v'),
            [$annee]
        );

        $delai = $this->scalarNull(
            "SELECT AVG(DATEDIFF(v.payment_date, {$this->dateDemandeSql})) AS val
             FROM {$t['paiements']} v
             INNER JOIN {$t['demandes']} d ON d.id = v.request_id
             WHERE v.payment_status = 'effectue'
               AND YEAR(v.payment_date) = ?
               AND v.payment_date >= {$this->dateDemandeSql}" . $this->cf('v'),
            [$annee]
        );

        $app = 0;
        $rej = 0;
        $q = $this->run(
            "SELECT SUM(CASE WHEN {$this->dgApprouveSql} THEN 1 ELSE 0 END) AS app,
                    SUM(CASE WHEN {$this->dgRejeteSql} THEN 1 ELSE 0 END) AS rej
             FROM {$t['demandes']} d
             WHERE {$whereDemandes}",
            [$annee]
        );
        if ($q && ($row = $q->row_array())) {
            $app = (int) $row['app'];
            $rej = (int) $row['rej'];
        }

        return [
            'engage'           => $engage,
            'paye'             => $paye,
            'nb_demandes'      => $nbDemandes,
            'taux_execution'   => $engage > 0 ? round($paye / $engage * 100, 1) : null,
            'montant_moyen'    => $nbDemandes > 0 ? round($engage / $nbDemandes) : null,
            'delai_moyen'      => $delai !== null ? round($delai, 1) : null,
            'nb_approuvees'    => $app,
            'nb_rejetees'      => $rej,
            'taux_approbation' => ($app + $rej) > 0 ? round($app / ($app + $rej) * 100, 1) : null,
        ];
    }

    /* ---------- Indicateurs "photo du jour" ---------- */
    public function getSnapshotPerf($annee)
    {
        $t = $this->t;

        // Chantiers actifs : budget, consommation, retards
        $ch = ['nb' => 0, 'retard' => 0, 'budget' => 0, 'depense' => 0];
        $q = $this->run(
            "SELECT COUNT(*) AS nb,
                    SUM(CASE WHEN c.date_fin_prevue < CURDATE() THEN 1 ELSE 0 END) AS retard,
                    COALESCE(SUM(c.budget), 0) AS budget,
                    COALESCE(SUM(p.depense), 0) AS depense
             FROM {$t['chantiers']} c
             LEFT JOIN (" . $this->depenseParChantierSql() . ") p ON p.chantier_id = c.id
             WHERE {$this->chantierActifSql}" . $this->cf('c')
        );
        if ($q && ($row = $q->row_array())) {
            $ch = array_map('floatval', $row);
        }

        // Parc engins (hors réformés)
        $en = ['total' => 0, 'dispo' => 0, 'affectes' => 0];
        $q = $this->run(
            "SELECT COUNT(*) AS total,
                    SUM(CASE WHEN e.etat = 'Disponible' THEN 1 ELSE 0 END) AS dispo,
                    SUM(CASE WHEN e.etat = 'Sur chantier' THEN 1 ELSE 0 END) AS affectes
             FROM {$t['engins']} e
             WHERE e.date_reforme IS NULL" . $this->enginActifSql()
        );
        if ($q && ($row = $q->row_array())) {
            $en = array_map('floatval', $row);
        }

        // Ressources humaines
        $rh = ['total' => 0, 'chantier' => 0, 'bureau' => 0, 'masse' => 0];
        $q = $this->run(
            "SELECT COUNT(*) AS total,
                    SUM(CASE WHEN categorie = 'Chantier' THEN 1 ELSE 0 END) AS chantier,
                    SUM(CASE WHEN categorie = 'Bureau' THEN 1 ELSE 0 END) AS bureau,
                    COALESCE(SUM(salaire_base), 0) AS masse
             FROM {$t['employes']}
             WHERE statut = 'Actif'"
        );
        if ($q && ($row = $q->row_array())) {
            $rh = array_map('floatval', $row);
        }

        $embauches = (int) $this->scalar(
            "SELECT COUNT(*) AS val FROM {$t['employes']} WHERE YEAR(date_embauche) = ?",
            [$annee]
        );

        return [
            'chantiers_actifs'   => (int) $ch['nb'],
            'chantiers_retard'   => (int) $ch['retard'],
            'taux_retard'        => $ch['nb'] > 0 ? round($ch['retard'] / $ch['nb'] * 100, 1) : null,
            'budget_actifs'      => $ch['budget'],
            'depense_actifs'     => $ch['depense'],
            'taux_consommation'  => $ch['budget'] > 0 ? round($ch['depense'] / $ch['budget'] * 100, 1) : null,

            'engins_total'       => (int) $en['total'],
            'engins_dispo'       => (int) $en['dispo'],
            'engins_affectes'    => (int) $en['affectes'],
            'taux_disponibilite' => $en['total'] > 0 ? round(($en['dispo'] + $en['affectes']) / $en['total'] * 100, 1) : null,
            'taux_utilisation'   => $en['total'] > 0 ? round($en['affectes'] / $en['total'] * 100, 1) : null,

            'effectif'           => (int) $rh['total'],
            'effectif_chantier'  => (int) $rh['chantier'],
            'effectif_bureau'    => (int) $rh['bureau'],
            'masse_salariale'    => $rh['masse'],
            'embauches'          => $embauches,
        ];
    }

    /* ---------- Paiements effectués par mois ---------- */
    public function getMonthlyPaiements($annee)
    {
        $mois = array_fill(1, 12, 0);

        $q = $this->run(
            "SELECT MONTH(v.payment_date) AS m, SUM(v.amount_paid) AS total
             FROM {$this->t['paiements']} v
             WHERE v.payment_status = 'effectue' AND YEAR(v.payment_date) = ?" . $this->cf('v') . "
             GROUP BY m",
            [$annee]
        );
        if ($q) {
            foreach ($q->result_array() as $r) {
                $mois[(int) $r['m']] = (float) $r['total'];
            }
        }
        return array_values($mois);
    }

    /* ---------- Dépenses payées par catégorie de demande ---------- */
    public function getDepensesParCategorie($annee)
    {
        $q = $this->run(
            "SELECT COALESCE(NULLIF(d.category_type, ''), 'autre') AS cat, SUM(v.amount_paid) AS total
             FROM {$this->t['paiements']} v
             INNER JOIN {$this->t['demandes']} d ON d.id = v.request_id
             WHERE v.payment_status = 'effectue' AND YEAR(v.payment_date) = ?" . $this->cf('v') . "
             GROUP BY cat
             ORDER BY total DESC",
            [$annee]
        );
        return $q ? $q->result_array() : [];
    }

    /* ---------- Décisions du DG sur l'année ---------- */
    public function getDecisionsDg($annee)
    {
        $q = $this->run(
            "SELECT d.dg_status AS statut, COUNT(*) AS total
             FROM {$this->t['demandes']} d
             WHERE d.workflow_status <> 'brouillon'
               AND d.requires_validation = 1
               AND YEAR({$this->dateDemandeSql}) = ?" . $this->cf('d') . "
             GROUP BY d.dg_status
             ORDER BY total DESC",
            [$annee]
        );
        return $q ? $q->result_array() : [];
    }

    /* ---------- Parc engins par état ---------- */
    public function getEnginsParEtat()
    {
        $q = $this->run(
            "SELECT e.etat, COUNT(*) AS total
             FROM {$this->t['engins']} e
             WHERE e.date_reforme IS NULL" . $this->enginActifSql() . "
             GROUP BY e.etat
             ORDER BY total DESC"
        );
        return $q ? $q->result_array() : [];
    }

    /* ---------- Analyse de risque des chantiers actifs ---------- */
    public function getChantiersPerformance($limit = 15)
    {
        $q = $this->run(
            "SELECT c.id, c.ref_chantier, c.name, c.chef_chantier, c.budget,
                    c.date_debut, c.date_fin_prevue,
                    COALESCE(p.depense, 0) AS depense
             FROM {$this->t['chantiers']} c
             LEFT JOIN (" . $this->depenseParChantierSql() . ") p ON p.chantier_id = c.id
             WHERE {$this->chantierActifSql}" . $this->cf('c')
        );
        if (!$q) return [];

        $rows  = $q->result_array();
        $now   = strtotime(date('Y-m-d'));
        $ordre = ['Dépassement' => 0, 'En retard' => 1, 'À surveiller' => 2, 'Conforme' => 3, 'Données incomplètes' => 4];

        foreach ($rows as &$r) {
            $budget = (float) $r['budget'];
            $dep    = (float) $r['depense'];

            $r['pct_budget'] = $budget > 0 ? round($dep / $budget * 100, 1) : null;
            $r['pct_temps']  = null;

            if (!empty($r['date_debut']) && !empty($r['date_fin_prevue'])) {
                $deb = strtotime($r['date_debut']);
                $fin = strtotime($r['date_fin_prevue']);
                if ($fin > $deb) {
                    $r['pct_temps'] = round(max(0, min(100, ($now - $deb) / ($fin - $deb) * 100)), 1);
                }
            }

            $r['ecart'] = ($r['pct_budget'] !== null && $r['pct_temps'] !== null)
                ? round($r['pct_budget'] - $r['pct_temps'], 1)
                : null;

            if ($r['pct_budget'] !== null && $r['pct_budget'] > 100) {
                $r['risque'] = 'Dépassement';
            } elseif (!empty($r['date_fin_prevue']) && strtotime($r['date_fin_prevue']) < $now) {
                $r['risque'] = 'En retard';
            } elseif ($r['ecart'] !== null && $r['ecart'] > 15) {
                $r['risque'] = 'À surveiller';
            } elseif ($r['ecart'] !== null) {
                $r['risque'] = 'Conforme';
            } else {
                $r['risque'] = 'Données incomplètes';
            }
        }
        unset($r);

        usort($rows, function ($a, $b) use ($ordre) {
            $cmp = $ordre[$a['risque']] <=> $ordre[$b['risque']];
            return $cmp !== 0 ? $cmp : (($b['ecart'] ?? -999) <=> ($a['ecart'] ?? -999));
        });

        return array_slice($rows, 0, (int) $limit);
    }

        /* ##########################################################
       ##                  REPORTING GÉNÉRAL                    ##
       ########################################################## */

    /** Ajoute un filtre chantier (et son paramètre) si demandé */
    private function filtreChantier($alias, $chantierId, array &$binds)
    {
        if ($chantierId) {
            $binds[] = (int) $chantierId;
            return " AND {$alias}.chantier_id = ?";
        }
        return '';
    }

    /* ---------- Liste des chantiers pour le filtre ---------- */
    public function getReportChantiersList()
    {
        $q = $this->run(
            "SELECT c.id, c.ref_chantier, c.name, c.status
             FROM {$this->t['chantiers']} c
             WHERE 1 = 1" . $this->cf('c') . "
             ORDER BY c.name ASC"
        );
        return $q ? $q->result_array() : [];
    }

    /* ---------- Synthèse de la période ---------- */
    public function getReportSynthese($debut, $fin, $chantierId = null)
    {
        $t = $this->t;

        // Demandes de la période
        $binds = [$debut, $fin];
        $fc    = $this->filtreChantier('d', $chantierId, $binds);
        $dem   = ['engage' => 0, 'nb' => 0, 'app' => 0, 'rej' => 0, 'att' => 0];

        $q = $this->run(
            "SELECT COALESCE(SUM(d.total_amount), 0) AS engage,
                    COUNT(*) AS nb,
                    SUM(CASE WHEN {$this->dgApprouveSql} THEN 1 ELSE 0 END) AS app,
                    SUM(CASE WHEN {$this->dgRejeteSql} THEN 1 ELSE 0 END) AS rej,
                    SUM(CASE WHEN d.dg_status = 'en_attente' AND d.requires_validation = 1 THEN 1 ELSE 0 END) AS att
             FROM {$t['demandes']} d
             WHERE d.workflow_status <> 'brouillon'
               AND {$this->dateDemandeSql} BETWEEN ? AND ?" . $this->cf('d') . $fc,
            $binds
        );
        if ($q && ($row = $q->row_array())) {
            $dem = array_map('floatval', $row);
        }

        // Paiements effectués de la période
        $binds = [$debut, $fin];
        $fc    = $this->filtreChantier('d', $chantierId, $binds);
        $pay   = ['paye' => 0, 'nb' => 0];

        $q = $this->run(
            "SELECT COALESCE(SUM(v.amount_paid), 0) AS paye, COUNT(*) AS nb
             FROM {$t['paiements']} v
             INNER JOIN {$t['demandes']} d ON d.id = v.request_id
             WHERE v.payment_status = 'effectue'
               AND v.payment_date BETWEEN ? AND ?" . $this->cf('v') . $fc,
            $binds
        );
        if ($q && ($row = $q->row_array())) {
            $pay = array_map('floatval', $row);
        }

        return [
            'engage'        => $dem['engage'],
            'paye'          => $pay['paye'],
            'reste'         => max(0, $dem['engage'] - $pay['paye']),
            'nb_demandes'   => (int) $dem['nb'],
            'nb_paiements'  => (int) $pay['nb'],
            'nb_approuvees' => (int) $dem['app'],
            'nb_rejetees'   => (int) $dem['rej'],
            'nb_attente'    => (int) $dem['att'],
        ];
    }

    /* ---------- Évolution mensuelle sur la période ---------- */
    public function getReportMensuel($debut, $fin, $chantierId = null)
    {
        $t = $this->t;
        $moisFr = [1 => 'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

        // Squelette : tous les mois de la période
        $mois = [];
        $cur  = new DateTime(date('Y-m-01', strtotime($debut)));
        $end  = new DateTime(date('Y-m-01', strtotime($fin)));
        while ($cur <= $end) {
            $ym = $cur->format('Y-m');
            $mois[$ym] = [
                'ym'     => $ym,
                'label'  => $moisFr[(int) $cur->format('n')] . ' ' . $cur->format('Y'),
                'engage' => 0,
                'paye'   => 0,
            ];
            $cur->modify('+1 month');
        }

        $binds = [$debut, $fin];
        $fc    = $this->filtreChantier('d', $chantierId, $binds);
        $q = $this->run(
            "SELECT DATE_FORMAT({$this->dateDemandeSql}, '%Y-%m') AS ym, SUM(d.total_amount) AS total
             FROM {$t['demandes']} d
             WHERE d.workflow_status <> 'brouillon'
               AND {$this->dateDemandeSql} BETWEEN ? AND ?" . $this->cf('d') . $fc . "
             GROUP BY ym",
            $binds
        );
        if ($q) {
            foreach ($q->result_array() as $r) {
                if (isset($mois[$r['ym']])) $mois[$r['ym']]['engage'] = (float) $r['total'];
            }
        }

        $binds = [$debut, $fin];
        $fc    = $this->filtreChantier('d', $chantierId, $binds);
        $q = $this->run(
            "SELECT DATE_FORMAT(v.payment_date, '%Y-%m') AS ym, SUM(v.amount_paid) AS total
             FROM {$t['paiements']} v
             INNER JOIN {$t['demandes']} d ON d.id = v.request_id
             WHERE v.payment_status = 'effectue'
               AND v.payment_date BETWEEN ? AND ?" . $this->cf('v') . $fc . "
             GROUP BY ym",
            $binds
        );
        if ($q) {
            foreach ($q->result_array() as $r) {
                if (isset($mois[$r['ym']])) $mois[$r['ym']]['paye'] = (float) $r['total'];
            }
        }

        return array_values($mois);
    }

    /* ---------- Situation par chantier ---------- */
    public function getReportParChantier($debut, $fin, $chantierId = null)
    {
        $t = $this->t;
        $binds = [$debut, $fin, $debut, $fin];

        $sql = "SELECT c.id, c.ref_chantier, c.name, c.status, c.budget,
                       COALESCE(e.engage, 0) AS engage,
                       COALESCE(p.paye, 0)   AS paye,
                       COALESCE(cu.depense, 0) AS cumul
                FROM {$t['chantiers']} c
                LEFT JOIN (
                    SELECT d.chantier_id, SUM(d.total_amount) AS engage
                    FROM {$t['demandes']} d
                    WHERE d.workflow_status <> 'brouillon'
                      AND {$this->dateDemandeSql} BETWEEN ? AND ?
                    GROUP BY d.chantier_id
                ) e ON e.chantier_id = c.id
                LEFT JOIN (
                    SELECT d.chantier_id, SUM(v.amount_paid) AS paye
                    FROM {$t['paiements']} v
                    INNER JOIN {$t['demandes']} d ON d.id = v.request_id
                    WHERE v.payment_status = 'effectue'
                      AND v.payment_date BETWEEN ? AND ?
                    GROUP BY d.chantier_id
                ) p ON p.chantier_id = c.id
                LEFT JOIN (" . $this->depenseParChantierSql() . ") cu ON cu.chantier_id = c.id
                WHERE (e.engage IS NOT NULL OR p.paye IS NOT NULL OR {$this->chantierActifSql})" . $this->cf('c');

        if ($chantierId) {
            $sql .= " AND c.id = ?";
            $binds[] = (int) $chantierId;
        }
        $sql .= " ORDER BY paye DESC, engage DESC, c.name ASC";

        $q = $this->run($sql, $binds);
        if (!$q) return [];

        $rows = $q->result_array();
        foreach ($rows as &$r) {
            $budget = (float) $r['budget'];
            $r['reste_budget'] = $budget - (float) $r['cumul'];
            $r['pct'] = $budget > 0 ? round((float) $r['cumul'] / $budget * 100, 1) : null;
        }
        unset($r);

        return $rows;
    }

    /* ---------- Paiements par catégorie ---------- */
    public function getReportCategories($debut, $fin, $chantierId = null)
    {
        $binds = [$debut, $fin];
        $fc    = $this->filtreChantier('d', $chantierId, $binds);

        $q = $this->run(
            "SELECT COALESCE(NULLIF(d.category_type, ''), 'autre') AS libelle,
                    COUNT(*) AS nb, SUM(v.amount_paid) AS total
             FROM {$this->t['paiements']} v
             INNER JOIN {$this->t['demandes']} d ON d.id = v.request_id
             WHERE v.payment_status = 'effectue'
               AND v.payment_date BETWEEN ? AND ?" . $this->cf('v') . $fc . "
             GROUP BY libelle
             ORDER BY total DESC",
            $binds
        );
        return $q ? $q->result_array() : [];
    }

    /* ---------- Paiements par mode de paiement ---------- */
    public function getReportModesPaiement($debut, $fin, $chantierId = null)
    {
        $binds = [$debut, $fin];
        $fc    = $this->filtreChantier('d', $chantierId, $binds);

        $q = $this->run(
            "SELECT v.payment_mode AS libelle, COUNT(*) AS nb, SUM(v.amount_paid) AS total
             FROM {$this->t['paiements']} v
             INNER JOIN {$this->t['demandes']} d ON d.id = v.request_id
             WHERE v.payment_status = 'effectue'
               AND v.payment_date BETWEEN ? AND ?" . $this->cf('v') . $fc . "
             GROUP BY v.payment_mode
             ORDER BY total DESC",
            $binds
        );
        return $q ? $q->result_array() : [];
    }

    /* ---------- Plus gros paiements de la période ---------- */
    public function getReportTopPaiements($debut, $fin, $chantierId = null, $limit = 10)
    {
        $binds = [$debut, $fin];
        $fc    = $this->filtreChantier('d', $chantierId, $binds);

        $q = $this->run(
            "SELECT v.payment_number, v.summary, v.payment_date, v.amount_paid, v.payment_mode,
                    COALESCE(c.name, d.destination_chantier) AS chantier
             FROM {$this->t['paiements']} v
             INNER JOIN {$this->t['demandes']} d ON d.id = v.request_id
             LEFT JOIN {$this->t['chantiers']} c ON c.id = d.chantier_id
             WHERE v.payment_status = 'effectue'
               AND v.payment_date BETWEEN ? AND ?" . $this->cf('v') . $fc . "
             ORDER BY v.amount_paid DESC
             LIMIT " . (int) $limit,
            $binds
        );
        return $q ? $q->result_array() : [];
    }

        /* ##########################################################
       ##                     ANALYTIQUE                        ##
       ########################################################## */

    /** Expressions SQL des dimensions (liste blanche : jamais de saisie utilisateur dans le SQL) */
    private $dimensionsSql = [
        'chantier'  => "COALESCE(c.name, NULLIF(TRIM(d.destination_chantier), ''), 'Non rattaché')",
        'categorie' => "COALESCE(NULLIF(d.category_type, ''), 'autre')",
        'demandeur' => "COALESCE(NULLIF(TRIM(d.requested_by), ''), 'Non renseigné')",
        'acheteur'  => "COALESCE(NULLIF(TRIM(d.buyer_name), ''), 'Non renseigné')",
        'mode'      => "COALESCE(v.payment_mode, 'Non renseigné')",
    ];

    /**
     * Base commune des requêtes analytiques selon la mesure :
     *  - 'paye'   : paiements effectués (purchase_payment_vouchers)
     *  - 'engage' : demandes d'achat hors brouillon (purchase_request_forms)
     */
    private function analyseBase($mesure, $debut, $fin, $chantierId)
    {
        $t = $this->t;
        $binds = [$debut, $fin];

        if ($mesure === 'engage') {
            $from    = "{$t['demandes']} d
                        LEFT JOIN {$t['chantiers']} c ON c.id = d.chantier_id";
            $where   = "d.workflow_status <> 'brouillon'
                        AND {$this->dateDemandeSql} BETWEEN ? AND ?" . $this->cf('d');
            $montant = 'd.total_amount';
            $date    = $this->dateDemandeSql;
        } else {
            $from    = "{$t['paiements']} v
                        INNER JOIN {$t['demandes']} d ON d.id = v.request_id
                        LEFT JOIN {$t['chantiers']} c ON c.id = d.chantier_id";
            $where   = "v.payment_status = 'effectue'
                        AND v.payment_date BETWEEN ? AND ?" . $this->cf('v');
            $montant = 'v.amount_paid';
            $date    = 'v.payment_date';
        }

        $where .= $this->filtreChantier('d', $chantierId, $binds);

        return compact('from', 'where', 'montant', 'date', 'binds');
    }

    /** Liste des mois de la période : ['2026-01' => 'Jan 2026', ...] */
    private function moisPeriode($debut, $fin)
    {
        $noms = [1 => 'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        $mois = [];
        $cur  = new DateTime(date('Y-m-01', strtotime($debut)));
        $end  = new DateTime(date('Y-m-01', strtotime($fin)));
        while ($cur <= $end) {
            $mois[$cur->format('Y-m')] = $noms[(int) $cur->format('n')] . ' ' . $cur->format('Y');
            $cur->modify('+1 month');
        }
        return $mois;
    }

    /* ---------- Analyse d'une dimension : classement, Pareto, ABC ---------- */
    public function getAnalyseDimension($dim, $mesure, $debut, $fin, $chantierId = null)
    {
        $vide = ['lignes' => [], 'total' => 0, 'nb_operations' => 0, 'nb_80' => 0];
        if (!isset($this->dimensionsSql[$dim])) return $vide;

        $b      = $this->analyseBase($mesure, $debut, $fin, $chantierId);
        $expr   = $this->dimensionsSql[$dim];
        $idExpr = $dim === 'chantier' ? 'c.id' : 'NULL';
        $delai  = $mesure === 'paye'
            ? "AVG(CASE WHEN v.payment_date >= {$this->dateDemandeSql}
                        THEN DATEDIFF(v.payment_date, {$this->dateDemandeSql}) END)"
            : 'NULL';

        $q = $this->run(
            "SELECT {$expr} AS libelle,
                    {$idExpr} AS dim_id,
                    COUNT(*) AS nb,
                    COALESCE(SUM({$b['montant']}), 0) AS total,
                    AVG({$b['montant']}) AS moyenne,
                    {$delai} AS delai
             FROM {$b['from']}
             WHERE {$b['where']}
             GROUP BY libelle, dim_id
             ORDER BY total DESC",
            $b['binds']
        );
        if (!$q) return $vide;

        $rows  = $q->result_array();
        $total = array_sum(array_map('floatval', array_column($rows, 'total')));
        $nbOps = array_sum(array_map('intval', array_column($rows, 'nb')));

        $cumul = 0;
        $nb80  = 0;
        foreach ($rows as &$r) {
            $r['total']   = (float) $r['total'];
            $r['nb']      = (int) $r['nb'];
            $r['moyenne'] = (float) $r['moyenne'];
            $r['delai']   = $r['delai'] !== null ? round((float) $r['delai'], 1) : null;
            $r['part']    = $total > 0 ? $r['total'] / $total * 100 : 0;

            $avant      = $cumul;
            $cumul     += $r['part'];
            $r['cumul'] = min(100, $cumul);
            $r['classe'] = $avant < 80 ? 'A' : ($avant < 95 ? 'B' : 'C');

            if ($r['classe'] === 'A') $nb80++;
        }
        unset($r);

        return ['lignes' => $rows, 'total' => $total, 'nb_operations' => $nbOps, 'nb_80' => $nb80];
    }

    /* ---------- Matrice croisée (carte de chaleur) ---------- */
    public function getAnalyseMatrice($rowDim, $colDim, $mesure, $debut, $fin, $chantierId = null, $maxRows = 12, $maxCols = 6)
    {
        $vide = ['rows' => [], 'cols' => [], 'cells' => [], 'rowTotals' => [], 'colTotals' => [], 'max' => 0, 'total' => 0];
        if (!isset($this->dimensionsSql[$rowDim], $this->dimensionsSql[$colDim])) return $vide;

        $b = $this->analyseBase($mesure, $debut, $fin, $chantierId);

        $q = $this->run(
            "SELECT {$this->dimensionsSql[$rowDim]} AS r,
                    {$this->dimensionsSql[$colDim]} AS k,
                    COALESCE(SUM({$b['montant']}), 0) AS total
             FROM {$b['from']}
             WHERE {$b['where']}
             GROUP BY r, k",
            $b['binds']
        );
        if (!$q) return $vide;

        $data = $q->result_array();
        if (empty($data)) return $vide;

        // Totaux bruts pour déterminer les lignes / colonnes principales
        $rt = [];
        $ct = [];
        foreach ($data as $d) {
            $rt[$d['r']] = ($rt[$d['r']] ?? 0) + (float) $d['total'];
            $ct[$d['k']] = ($ct[$d['k']] ?? 0) + (float) $d['total'];
        }
        arsort($rt);
        arsort($ct);
        $topRows = array_slice(array_keys($rt), 0, $maxRows);
        $topCols = array_slice(array_keys($ct), 0, $maxCols);

        // Regroupement : au-delà du top, tout va dans "Autres"
        $cells = [];
        $rowTotals = [];
        $colTotals = [];
        foreach ($data as $d) {
            $r = in_array($d['r'], $topRows, true) ? $d['r'] : 'Autres';
            $k = in_array($d['k'], $topCols, true) ? $d['k'] : 'Autres';
            $v = (float) $d['total'];
            $cells[$r][$k]  = ($cells[$r][$k] ?? 0) + $v;
            $rowTotals[$r]  = ($rowTotals[$r] ?? 0) + $v;
            $colTotals[$k]  = ($colTotals[$k] ?? 0) + $v;
        }

        $rows = $topRows;
        if (isset($rowTotals['Autres'])) $rows[] = 'Autres';
        $cols = $topCols;
        if (isset($colTotals['Autres'])) $cols[] = 'Autres';

        $max = 0;
        foreach ($cells as $line) {
            foreach ($line as $v) $max = max($max, $v);
        }

        return [
            'rows'      => $rows,
            'cols'      => $cols,
            'cells'     => $cells,
            'rowTotals' => $rowTotals,
            'colTotals' => $colTotals,
            'max'       => $max,
            'total'     => array_sum($rowTotals),
        ];
    }

    /* ---------- Évolution mensuelle des principaux éléments ---------- */
    public function getAnalyseTendance($dim, $mesure, $debut, $fin, $chantierId, array $topLibelles)
    {
        $mois = $this->moisPeriode($debut, $fin);
        $vide = ['labels' => array_values($mois), 'series' => []];
        if (!isset($this->dimensionsSql[$dim]) || empty($topLibelles)) return $vide;

        $b = $this->analyseBase($mesure, $debut, $fin, $chantierId);

        $q = $this->run(
            "SELECT {$this->dimensionsSql[$dim]} AS libelle,
                    DATE_FORMAT({$b['date']}, '%Y-%m') AS ym,
                    COALESCE(SUM({$b['montant']}), 0) AS total
             FROM {$b['from']}
             WHERE {$b['where']}
             GROUP BY libelle, ym",
            $b['binds']
        );
        if (!$q) return $vide;

        $index  = array_flip(array_keys($mois));
        $series = [];
        foreach ($topLibelles as $lib) {
            $series[$lib] = array_fill(0, count($mois), 0);
        }
        $autres = array_fill(0, count($mois), 0);
        $aDesAutres = false;

        foreach ($q->result_array() as $r) {
            if (!isset($index[$r['ym']])) continue;
            $i = $index[$r['ym']];
            if (isset($series[$r['libelle']])) {
                $series[$r['libelle']][$i] += (float) $r['total'];
            } else {
                $autres[$i] += (float) $r['total'];
                $aDesAutres = true;
            }
        }
        if ($aDesAutres) {
            $series['Autres'] = $autres;
        }

        return ['labels' => array_values($mois), 'series' => $series];
    }

    /* ##########################################################
       ##                    STATISTIQUES                       ##
       ########################################################## */

    /* ---------- Séries pluriannuelles, saisonnalité, projection ---------- */
    public function getStatistiques($mesure, $anneeDebut, $anneeFin, $chantierId = null)
    {
        $annees = range($anneeDebut, $anneeFin);
        $mat    = [];
        $nbMat  = [];
        foreach ($annees as $y) {
            $mat[$y]   = array_fill(1, 12, 0.0);
            $nbMat[$y] = array_fill(1, 12, 0);
        }

        // 1. Données mensuelles brutes
        $b = $this->analyseBase($mesure, "{$anneeDebut}-01-01", "{$anneeFin}-12-31", $chantierId);
        $q = $this->run(
            "SELECT YEAR({$b['date']}) AS y, MONTH({$b['date']}) AS m,
                    COUNT(*) AS nb, COALESCE(SUM({$b['montant']}), 0) AS total
             FROM {$b['from']}
             WHERE {$b['where']}
             GROUP BY y, m",
            $b['binds']
        );
        if ($q) {
            foreach ($q->result_array() as $r) {
                $y = (int) $r['y'];
                $m = (int) $r['m'];
                if (isset($mat[$y])) {
                    $mat[$y][$m]   = (float) $r['total'];
                    $nbMat[$y][$m] = (int) $r['nb'];
                }
            }
        }

        $curY    = (int) date('Y');
        $curM    = (int) date('n');
        $dayFrac = (int) date('j') / (int) date('t');

        // 2. Totaux annuels
        $annuel = [];
        $prev   = null;
        foreach ($annees as $y) {
            $total    = array_sum($mat[$y]);
            $nb       = array_sum($nbMat[$y]);
            $complete = $y < $curY;
            $annuel[$y] = [
                'annee'      => $y,
                'total'      => $total,
                'nb'         => $nb,
                'moyenne'    => $nb > 0 ? $total / $nb : null,
                'complete'   => $complete,
                // Croissance calculée uniquement entre années terminées
                'croissance' => ($complete && $prev !== null && $prev['complete'] && $prev['total'] > 0)
                    ? ($total - $prev['total']) / $prev['total'] * 100
                    : null,
            ];
            $prev = $annuel[$y];
        }

        // Années terminées avec activité : base de la saisonnalité et du TCAM
        $pleines = array_values(array_filter($annees, function ($y) use ($annuel) {
            return $annuel[$y]['complete'] && $annuel[$y]['total'] > 0;
        }));

        // 3. Saisonnalité (indice 100 = mois moyen)
        $moyMois = array_fill(1, 12, 0.0);
        if ($pleines) {
            for ($m = 1; $m <= 12; $m++) {
                $s = 0;
                foreach ($pleines as $y) $s += $mat[$y][$m];
                $moyMois[$m] = $s / count($pleines);
            }
        }
        $sommeMoy = array_sum($moyMois);
        $moyGlob  = $sommeMoy / 12;
        $indices  = [];
        for ($m = 1; $m <= 12; $m++) {
            $indices[$m] = $moyGlob > 0 ? round($moyMois[$m] / $moyGlob * 100, 1) : null;
        }

        // 4. Année en cours : cumul et comparaison à la même période N-1
        $ytd = 0;
        for ($m = 1; $m <= $curM; $m++) $ytd += $mat[$curY][$m] ?? 0;

        $ytdPrev = null;
        if (isset($mat[$curY - 1])) {
            $ytdPrev = 0;
            for ($m = 1; $m < $curM; $m++) $ytdPrev += $mat[$curY - 1][$m];
            $ytdPrev += $mat[$curY - 1][$curM] * $dayFrac; // mois en cours au prorata
        }
        $ytdCroissance = ($ytdPrev !== null && $ytdPrev > 0) ? ($ytd - $ytdPrev) / $ytdPrev * 100 : null;

        // 5. Projection de fin d'année
        $projection = null;
        $methode    = null;
        if ($sommeMoy > 0) {
            $part = 0;
            for ($m = 1; $m < $curM; $m++) $part += $moyMois[$m];
            $part = ($part + $moyMois[$curM] * $dayFrac) / $sommeMoy;
            if ($part >= 0.05 && $ytd > 0) {
                $projection = $ytd / $part;
                $methode    = 'saisonnière (' . count($pleines) . ' an' . (count($pleines) > 1 ? 's' : '') . ' d\'historique)';
            }
        }
        if ($projection === null && $ytd > 0) {
            $joursAnnee  = (int) date('L') ? 366 : 365;
            $fracEcoulee = ((int) date('z') + 1) / $joursAnnee;
            $projection  = $ytd / $fracEcoulee;
            $methode     = 'linéaire (prorata des jours écoulés)';
        }

        // 6. TCAM sur les années terminées
        $tcam = null;
        if (count($pleines) >= 2) {
            $first = $pleines[0];
            $last  = end($pleines);
            $n     = $last - $first;
            if ($n > 0 && $annuel[$first]['total'] > 0) {
                $tcam = (pow($annuel[$last]['total'] / $annuel[$first]['total'], 1 / $n) - 1) * 100;
            }
        }

        // 7. Courbes cumulées : N, N-1, moyenne historique
        $cumul = ['n' => [], 'prev' => [], 'moyenne' => []];
        $cN = $cP = $cM = 0;
        for ($m = 1; $m <= 12; $m++) {
            $cN += $mat[$curY][$m] ?? 0;
            $cP += $mat[$curY - 1][$m] ?? 0;
            $cM += $moyMois[$m];
            $cumul['n'][]       = $m <= $curM ? $cN : null;
            $cumul['prev'][]    = isset($mat[$curY - 1]) ? $cP : null;
            $cumul['moyenne'][] = $pleines ? $cM : null;
        }

        // Meilleure année terminée
        $meilleure = null;
        foreach ($pleines as $y) {
            if ($meilleure === null || $annuel[$y]['total'] > $annuel[$meilleure]['total']) $meilleure = $y;
        }

        $moisEcoules = ($curM - 1) + $dayFrac;

        return [
            'annees'            => $annees,
            'mensuel'           => $mat,
            'annuel'            => $annuel,
            'pleines'           => $pleines,
            'saison'            => ['moyennes' => $moyMois, 'indices' => $indices],
            'ytd'               => $ytd,
            'ytd_prev'          => $ytdPrev,
            'ytd_croissance'    => $ytdCroissance,
            'projection'        => $projection,
            'methode'           => $methode,
            'tcam'              => $tcam,
            'meilleure'         => $meilleure,
            'moyenne_mensuelle' => $moisEcoules > 0 ? $ytd / $moisEcoules : null,
            'cumul'             => $cumul,
            'total_general'     => array_sum(array_column($annuel, 'total')),
        ];
    }

    /* ---------- Statistiques descriptives des montants d'une année ---------- */
    public function getStatsMontants($mesure, $annee, $chantierId = null)
    {
        $tranches = [
            ['label' => '< 500 000',       'min' => 0,        'max' => 500000],
            ['label' => '500 000 – 2 M',   'min' => 500000,   'max' => 2000000],
            ['label' => '2 M – 10 M',      'min' => 2000000,  'max' => 10000000],
            ['label' => '10 M – 50 M',     'min' => 10000000, 'max' => 50000000],
            ['label' => '≥ 50 M',          'min' => 50000000, 'max' => INF],
        ];

        $res = [
            'annee' => $annee,
            'n' => 0,
            'total' => 0,
            'moyenne' => null,
            'mediane' => null,
            'min' => null,
            'max' => null,
            'ecart_type' => null,
            'cv' => null,
            'tranches' => [],
        ];
        foreach ($tranches as $t) {
            $res['tranches'][] = ['label' => $t['label'], 'nb' => 0, 'total' => 0];
        }

        $b = $this->analyseBase($mesure, "{$annee}-01-01", "{$annee}-12-31", $chantierId);
        $q = $this->run(
            "SELECT {$b['montant']} AS montant
             FROM {$b['from']}
             WHERE {$b['where']}
             ORDER BY montant ASC",
            $b['binds']
        );
        if (!$q) return $res;

        $vals = array_map('floatval', array_column($q->result_array(), 'montant'));
        $n    = count($vals);
        if ($n === 0) return $res;

        $total   = array_sum($vals);
        $moyenne = $total / $n;
        $mediane = $n % 2 ? $vals[intdiv($n, 2)] : ($vals[$n / 2 - 1] + $vals[$n / 2]) / 2;

        $var = 0;
        foreach ($vals as $v) $var += ($v - $moyenne) ** 2;
        $ecart = sqrt($var / $n);

        foreach ($vals as $v) {
            foreach ($tranches as $i => $t) {
                if ($v >= $t['min'] && $v < $t['max']) {
                    $res['tranches'][$i]['nb']++;
                    $res['tranches'][$i]['total'] += $v;
                    break;
                }
            }
        }

        return array_merge($res, [
            'n'          => $n,
            'total'      => $total,
            'moyenne'    => $moyenne,
            'mediane'    => $mediane,
            'min'        => $vals[0],
            'max'        => $vals[$n - 1],
            'ecart_type' => $ecart,
            'cv'         => $moyenne > 0 ? $ecart / $moyenne * 100 : null,
        ]);
    }

    /* ---------- Activité par année (toute l'entreprise) ---------- */
    public function getActiviteAnnuelle($anneeDebut, $anneeFin)
    {
        $t   = $this->t;
        $act = [];
        foreach (range($anneeDebut, $anneeFin) as $y) {
            $act[$y] = ['demandes' => 0, 'paiements' => 0, 'chantiers' => 0, 'embauches' => 0];
        }

        $requetes = [
            'demandes' => "SELECT YEAR({$this->dateDemandeSql}) AS y, COUNT(*) AS nb
                           FROM {$t['demandes']} d
                           WHERE d.workflow_status <> 'brouillon'
                             AND YEAR({$this->dateDemandeSql}) BETWEEN ? AND ?" . $this->cf('d') . "
                           GROUP BY y",
            'paiements' => "SELECT YEAR(v.payment_date) AS y, COUNT(*) AS nb
                            FROM {$t['paiements']} v
                            WHERE v.payment_status = 'effectue'
                              AND YEAR(v.payment_date) BETWEEN ? AND ?" . $this->cf('v') . "
                            GROUP BY y",
            'chantiers' => "SELECT YEAR(c.date_debut) AS y, COUNT(*) AS nb
                            FROM {$t['chantiers']} c
                            WHERE YEAR(c.date_debut) BETWEEN ? AND ?" . $this->cf('c') . "
                            GROUP BY y",
            'embauches' => "SELECT YEAR(date_embauche) AS y, COUNT(*) AS nb
                            FROM {$t['employes']}
                            WHERE YEAR(date_embauche) BETWEEN ? AND ?
                            GROUP BY y",
        ];

        foreach ($requetes as $cle => $sql) {
            $q = $this->run($sql, [$anneeDebut, $anneeFin]);
            if (!$q) continue;
            foreach ($q->result_array() as $r) {
                if (isset($act[(int) $r['y']])) $act[(int) $r['y']][$cle] = (int) $r['nb'];
            }
        }

        return $act;
    }

        /* ##########################################################
       ##                  SUIVI DES PROJETS                    ##
       ########################################################## */

    /** Ordre de gravité des états de santé (0 = le plus grave) */
    private $santeOrdre = [
        'Dépassement'         => 0,
        'En retard'           => 1,
        'À surveiller'        => 2,
        'Conforme'            => 3,
        'Données incomplètes' => 4,
        'Hors activité'       => 5,
        'Sans chantier'       => 6,
    ];

    /** Statuts considérés comme "en activité" (projets et chantiers) */
    private function estActif($status)
    {
        return in_array(mb_strtolower(trim((string) $status)), ['actif', 'active', 'en cours', 'en_cours', 'ouvert'], true);
    }

    /**
     * Détecte les colonnes de la table projects (sa structure n'est pas figée ici).
     * Retourne ['name' => 'nom_colonne', 'budget' => ..., ...] pour les colonnes trouvées.
     */
    private function colonnesProjets()
    {
        static $cache = null;
        if ($cache !== null) return $cache;

        $cache = [];
        $table = $this->t['projets'];
        if (!$this->db->table_exists($table)) return $cache;

        $fields = $this->db->list_fields($table);
        $candidats = [
            'name'    => ['name', 'nom', 'project_name', 'nom_projet', 'libelle', 'titre', 'title', 'designation'],
            'code'    => ['code', 'ref', 'reference', 'ref_projet', 'project_code', 'code_projet'],
            'client'  => ['client_name', 'client', 'nom_client', 'maitre_ouvrage', 'customer_name'],
            'status'  => ['status', 'statut', 'etat'],
            'budget'  => ['budget', 'budget_total', 'montant', 'montant_marche', 'contract_amount', 'amount'],
            'debut'   => ['date_debut', 'start_date', 'date_start', 'debut'],
            'fin'     => ['date_fin_prevue', 'date_fin', 'end_date', 'deadline', 'fin'],
            'company' => ['company_id'],
        ];

        foreach ($candidats as $cle => $liste) {
            foreach ($liste as $col) {
                if (in_array($col, $fields, true)) {
                    $cache[$cle] = $col;
                    break;
                }
            }
        }
        return $cache;
    }

    /** % budget, % délai, écart et santé d'un chantier */
    private function evaluerChantier(array $r)
    {
        $now    = strtotime(date('Y-m-d'));
        $budget = (float) $r['budget'];
        $dep    = (float) $r['depense'];

        $r['actif']      = $this->estActif($r['status']);
        $r['pct_budget'] = $budget > 0 ? round($dep / $budget * 100, 1) : null;
        $r['pct_temps']  = null;

        if (!empty($r['date_debut']) && !empty($r['date_fin_prevue'])) {
            $deb = strtotime($r['date_debut']);
            $fin = strtotime($r['date_fin_prevue']);
            if ($fin > $deb) {
                $r['pct_temps'] = round(max(0, min(100, ($now - $deb) / ($fin - $deb) * 100)), 1);
            }
        }

        $r['ecart'] = ($r['pct_budget'] !== null && $r['pct_temps'] !== null)
            ? round($r['pct_budget'] - $r['pct_temps'], 1)
            : null;

        $r['en_retard'] = $r['actif'] && !empty($r['date_fin_prevue']) && strtotime($r['date_fin_prevue']) < $now;

        if ($r['pct_budget'] !== null && $r['pct_budget'] > 100) {
            $r['sante'] = 'Dépassement';
        } elseif (!$r['actif']) {
            $r['sante'] = 'Hors activité';
        } elseif ($r['en_retard']) {
            $r['sante'] = 'En retard';
        } elseif ($r['ecart'] !== null && $r['ecart'] > 15) {
            $r['sante'] = 'À surveiller';
        } elseif ($r['ecart'] !== null) {
            $r['sante'] = 'Conforme';
        } else {
            $r['sante'] = 'Données incomplètes';
        }

        return $r;
    }

    /* ---------- Portefeuille de projets avec leurs chantiers ---------- */
    public function getSuiviProjets(array $f)
    {
        $t    = $this->t;
        $cols = $this->colonnesProjets();
        $tableOk = $this->db->table_exists($t['projets']);

        // 1. Projets
        $projets = [];
        if ($tableOk) {
            $select = ['p.id'];
            foreach (['name', 'code', 'client', 'status', 'budget', 'debut', 'fin'] as $k) {
                if (isset($cols[$k])) $select[] = "p.`{$cols[$k]}` AS `{$k}`";
            }
            $where = (isset($cols['company']) && $this->companyId)
                ? ' WHERE p.`' . $cols['company'] . '` = ' . (int) $this->companyId
                : '';

            $q = $this->run("SELECT " . implode(', ', $select) . " FROM {$t['projets']} p{$where}");
            if ($q) {
                foreach ($q->result_array() as $p) {
                    $id = (int) $p['id'];
                    $projets[$id] = [
                        'id'     => $id,
                        'name'   => isset($p['name']) && $p['name'] !== '' ? $p['name'] : 'Projet #' . $id,
                        'code'   => $p['code'] ?? '',
                        'client' => $p['client'] ?? '',
                        'status' => $p['status'] ?? '',
                        'budget_projet' => isset($p['budget']) ? (float) $p['budget'] : 0,
                        'debut'  => $p['debut'] ?? null,
                        'fin'    => $p['fin'] ?? null,
                        'chantiers' => [],
                    ];
                }
            }
        }

        // Groupe des chantiers sans projet
        $projets[0] = [
            'id' => 0,
            'name' => 'Chantiers non rattachés à un projet',
            'code' => '',
            'client' => '',
            'status' => '',
            'budget_projet' => 0,
            'debut' => null,
            'fin' => null,
            'chantiers' => [],
        ];

        // 2. Chantiers avec dépenses, engagements et demandes en attente
        $q = $this->run(
            "SELECT c.id, c.project_id, c.ref_chantier, c.name, c.chef_chantier, c.location, c.status,
                    c.budget, c.date_debut, c.date_fin_prevue,
                    COALESCE(dp.depense, 0) AS depense,
                    COALESCE(en.engage, 0)  AS engage,
                    COALESCE(en.attente, 0) AS attente
             FROM {$t['chantiers']} c
             LEFT JOIN (" . $this->depenseParChantierSql() . ") dp ON dp.chantier_id = c.id
             LEFT JOIN (
                 SELECT d.chantier_id,
                        SUM(d.total_amount) AS engage,
                        SUM(CASE WHEN {$this->attenteDgSql} THEN 1 ELSE 0 END) AS attente
                 FROM {$t['demandes']} d
                 WHERE d.workflow_status <> 'brouillon'
                 GROUP BY d.chantier_id
             ) en ON en.chantier_id = c.id
             WHERE 1 = 1" . $this->cf('c') . "
             ORDER BY c.date_fin_prevue IS NULL, c.date_fin_prevue ASC"
        );

        if ($q) {
            foreach ($q->result_array() as $c) {
                $pid = (int) $c['project_id'];
                if (!isset($projets[$pid])) $pid = 0;
                $projets[$pid]['chantiers'][] = $this->evaluerChantier($c);
            }
        }

        if (empty($projets[0]['chantiers'])) unset($projets[0]);

        // 3. Agrégation par projet
        $now = strtotime(date('Y-m-d'));
        foreach ($projets as &$p) {
            $ch = $p['chantiers'];
            usort($p['chantiers'], function ($a, $b) {
                return $this->santeOrdre[$a['sante']] <=> $this->santeOrdre[$b['sante']];
            });

            $p['nb_chantiers']     = count($ch);
            $p['nb_actifs']        = count(array_filter($ch, function ($c) {
                return $c['actif'];
            }));
            $p['nb_retard']        = count(array_filter($ch, function ($c) {
                return $c['en_retard'];
            }));
            $p['budget_chantiers'] = array_sum(array_map('floatval', array_column($ch, 'budget')));
            $p['depense']          = array_sum(array_map('floatval', array_column($ch, 'depense')));
            $p['engage']           = array_sum(array_map('floatval', array_column($ch, 'engage')));
            $p['attente']          = array_sum(array_map('intval', array_column($ch, 'attente')));

            $p['budget'] = $p['budget_projet'] > 0 ? $p['budget_projet'] : $p['budget_chantiers'];

            $debuts = array_filter(array_column($ch, 'date_debut'));
            $fins   = array_filter(array_column($ch, 'date_fin_prevue'));
            $p['debut'] = $p['debut'] ?: ($debuts ? min($debuts) : null);
            $p['fin']   = $p['fin'] ?: ($fins ? max($fins) : null);

            $p['pct_budget'] = $p['budget'] > 0 ? round($p['depense'] / $p['budget'] * 100, 1) : null;
            $p['pct_temps']  = null;
            if ($p['debut'] && $p['fin'] && strtotime($p['fin']) > strtotime($p['debut'])) {
                $deb = strtotime($p['debut']);
                $p['pct_temps'] = round(max(0, min(100, ($now - $deb) / (strtotime($p['fin']) - $deb) * 100)), 1);
            }

            // Santé = chantier le plus critique
            $p['sante'] = 'Sans chantier';
            foreach ($ch as $c) {
                if ($this->santeOrdre[$c['sante']] < $this->santeOrdre[$p['sante']]) $p['sante'] = $c['sante'];
            }

            $p['actif'] = $p['nb_actifs'] > 0 || $this->estActif($p['status']);
        }
        unset($p);

        // 4. Filtres
        $liste = array_values(array_filter($projets, function ($p) use ($f) {
            if ($f['statut'] === 'actifs' && !$p['actif']) return false;
            if ($f['sante'] !== '' && $p['sante'] !== $f['sante']) return false;
            if ($f['q'] !== '') {
                $haystack = mb_strtolower($p['name'] . ' ' . $p['code'] . ' ' . $p['client']);
                foreach ($p['chantiers'] as $c) $haystack .= ' ' . mb_strtolower($c['name'] . ' ' . $c['ref_chantier']);
                if (mb_strpos($haystack, mb_strtolower($f['q'])) === false) return false;
            }
            return true;
        }));

        // 5. Tri (le groupe "non rattachés" toujours en dernier)
        usort($liste, function ($a, $b) use ($f) {
            if ($a['id'] === 0) return 1;
            if ($b['id'] === 0) return -1;
            switch ($f['tri']) {
                case 'budget':
                    return $b['budget'] <=> $a['budget'];
                case 'nom':
                    return strcasecmp($a['name'], $b['name']);
                case 'fin':
                    return ($a['fin'] ?: '9999-12-31') <=> ($b['fin'] ?: '9999-12-31');
                default:
                    $cmp = $this->santeOrdre[$a['sante']] <=> $this->santeOrdre[$b['sante']];
                    return $cmp !== 0 ? $cmp : (($b['pct_budget'] ?? 0) <=> ($a['pct_budget'] ?? 0));
            }
        });

        // 6. Indicateurs du portefeuille (sur la liste filtrée)
        $vrais   = array_filter($liste, function ($p) {
            return $p['id'] !== 0;
        });
        $budget  = array_sum(array_column($liste, 'budget'));
        $depense = array_sum(array_column($liste, 'depense'));
        $sante   = array_fill_keys(array_keys($this->santeOrdre), 0);
        foreach ($vrais as $p) $sante[$p['sante']]++;

        $kpi = [
            'nb_projets'       => count($vrais),
            'nb_chantiers'     => array_sum(array_column($liste, 'nb_chantiers')),
            'nb_actifs'        => array_sum(array_column($liste, 'nb_actifs')),
            'nb_retard'        => array_sum(array_column($liste, 'nb_retard')),
            'budget'           => $budget,
            'depense'          => $depense,
            'pct'              => $budget > 0 ? round($depense / $budget * 100, 1) : null,
            'nb_risque'        => $sante['Dépassement'] + $sante['En retard'] + $sante['À surveiller'],
            'attente'          => array_sum(array_column($liste, 'attente')),
        ];

        return [
            'projets'  => $liste,
            'kpi'      => $kpi,
            'sante'    => array_filter($sante),
            'colonnes' => $cols,
            'table_ok' => $tableOk,
        ];
    }

        /* ##########################################################
       ##          ARCHIVES DES DEMANDES D'ACHAT                ##
       ########################################################## */

    /** Détection des colonnes de purchase_request_items */
    public function getColonnesItems()
    {
        static $cache = null;
        if ($cache !== null) return $cache;

        $cache = [];
        if (!$this->db->table_exists($this->table_items)) return $cache;

        $fields = $this->db->list_fields($this->table_items);
        $candidats = [
            'designation' => ['designation', 'description', 'item_name', 'libelle', 'article', 'product_name', 'name', 'item'],
            'quantite'    => ['quantity', 'quantite', 'qty', 'qte'],
            'unite'       => ['unit', 'unite', 'unity', 'uom', 'unit_measure'],
            'pu'          => ['unit_price', 'prix_unitaire', 'pu', 'price', 'unit_cost', 'prix'],
            'total'       => ['total_price', 'prix_total', 'total', 'line_total', 'total_amount', 'montant', 'amount'],
        ];
        foreach ($candidats as $cle => $liste) {
            foreach ($liste as $col) {
                if (in_array($col, $fields, true)) {
                    $cache[$cle] = $col;
                    break;
                }
            }
        }
        return $cache;
    }

    /** Valeurs distinctes pour les listes de filtres */
    public function getArchivesOptions()
    {
        $t = $this->t;
        $opt = ['workflows' => [], 'categories' => []];

        $q = $this->run(
            "SELECT DISTINCT d.workflow_status AS v FROM {$t['demandes']} d
             WHERE d.workflow_status IS NOT NULL AND d.workflow_status <> ''" . $this->cf('d') . " ORDER BY v"
        );
        if ($q) $opt['workflows'] = array_column($q->result_array(), 'v');

        $q = $this->run(
            "SELECT DISTINCT d.category_type AS v FROM {$t['demandes']} d
             WHERE d.category_type IS NOT NULL AND d.category_type <> ''" . $this->cf('d') . " ORDER BY v"
        );
        if ($q) $opt['categories'] = array_column($q->result_array(), 'v');

        return $opt;
    }

    /** FROM commun : demande + chantier + bons de paiement agrégés + nombre d'articles */
    private function archivesFrom()
    {
        $t = $this->t;
        $from = "{$t['demandes']} d
                 LEFT JOIN {$t['chantiers']} c ON c.id = d.chantier_id
                 LEFT JOIN (
                     SELECT v.request_id,
                            GROUP_CONCAT(v.payment_number ORDER BY v.id SEPARATOR ', ') AS numeros,
                            SUM(CASE WHEN v.payment_status = 'effectue' THEN v.amount_paid ELSE 0 END) AS paye
                     FROM {$t['paiements']} v
                     GROUP BY v.request_id
                 ) pv ON pv.request_id = d.id";

        if ($this->db->table_exists($this->table_items)) {
            $from .= " LEFT JOIN (
                           SELECT request_id, COUNT(*) AS nb FROM {$this->table_items} GROUP BY request_id
                       ) it ON it.request_id = d.id";
        }
        return $from;
    }

    private function nbArticlesSql()
    {
        return $this->db->table_exists($this->table_items) ? 'COALESCE(it.nb, 0)' : '0';
    }

    /** WHERE des archives selon les filtres */
    private function archivesWhere(array $f, array &$binds)
    {
        $w = "1 = 1" . $this->cf('d');

        if ($f['du']) {
            $w .= " AND {$this->dateDemandeSql} >= ?";
            $binds[] = $f['du'];
        }
        if ($f['au']) {
            $w .= " AND {$this->dateDemandeSql} <= ?";
            $binds[] = $f['au'];
        }
        if ($f['chantier']) {
            $w .= " AND d.chantier_id = ?";
            $binds[] = (int) $f['chantier'];
        }

        if ($f['dg'] === 'en_attente') {
            $w .= " AND d.dg_status = 'en_attente'";
        } elseif ($f['dg'] === 'approuve') {
            $w .= " AND {$this->dgApprouveSql}";
        } elseif ($f['dg'] === 'rejete') {
            $w .= " AND {$this->dgRejeteSql}";
        }

        if ($f['paiement']) {
            $w .= " AND COALESCE(d.payment_status, 'non_paye') = ?";
            $binds[] = $f['paiement'];
        }
        if ($f['workflow'] !== '') {
            $w .= " AND d.workflow_status = ?";
            $binds[] = $f['workflow'];
        }
        if ($f['categorie'] !== '') {
            $w .= " AND d.category_type = ?";
            $binds[] = $f['categorie'];
        }

        if ($f['q'] !== '') {
            $like  = '%' . $this->db->escape_like_str($f['q']) . '%';
            $parts = [];
            foreach (['d.destination_chantier', 'd.requested_by', 'd.buyer_name', 'd.notes', 'c.name', 'c.ref_chantier', 'pv.numeros'] as $col) {
                $parts[] = "{$col} LIKE ? ESCAPE '!'";
                $binds[] = $like;
            }
            if (preg_match('/^(?:DA-?)?0*(\d+)$/i', trim($f['q']), $m)) {
                $parts[] = "d.id = ?";
                $binds[] = (int) $m[1];
            }
            $cols = $this->getColonnesItems();
            if (isset($cols['designation'])) {
                $parts[] = "EXISTS (SELECT 1 FROM {$this->table_items} i
                                    WHERE i.request_id = d.id AND i.`{$cols['designation']}` LIKE ? ESCAPE '!')";
                $binds[] = $like;
            }
            $w .= " AND (" . implode(' OR ', $parts) . ")";
        }

        return $w;
    }

    public function countArchives(array $f)
    {
        $binds = [];
        $where = $this->archivesWhere($f, $binds);
        return (int) $this->scalar("SELECT COUNT(*) AS val FROM " . $this->archivesFrom() . " WHERE {$where}", $binds);
    }

    public function getArchivesTotaux(array $f)
    {
        $binds = [];
        $where = $this->archivesWhere($f, $binds);
        $res = ['nb' => 0, 'total' => 0, 'paye' => 0, 'nb_articles' => 0];

        $q = $this->run(
            "SELECT COUNT(*) AS nb,
                    COALESCE(SUM(d.total_amount), 0) AS total,
                    COALESCE(SUM(pv.paye), 0) AS paye,
                    COALESCE(SUM(" . $this->nbArticlesSql() . "), 0) AS nb_articles
             FROM " . $this->archivesFrom() . "
             WHERE {$where}",
            $binds
        );
        if ($q && ($row = $q->row_array())) {
            $res = array_map('floatval', $row);
        }
        $res['reste'] = max(0, $res['total'] - $res['paye']);
        return $res;
    }

    public function getArchives(array $f, $limit = 25, $offset = 0)
    {
        $binds = [];
        $where = $this->archivesWhere($f, $binds);

        $q = $this->run(
            "SELECT d.id,
                    CONCAT('DA-', LPAD(d.id, 4, '0')) AS reference,
                    {$this->dateDemandeSql} AS date_demande,
                    d.destination_chantier, c.name AS chantier_nom, c.ref_chantier,
                    d.category_type, d.requested_by, d.buyer_name,
                    d.total_amount, d.dg_status, d.workflow_status,
                    COALESCE(d.payment_status, 'non_paye') AS payment_status,
                    d.notes,
                    pv.numeros,
                    COALESCE(pv.paye, 0) AS paye,
                    " . $this->nbArticlesSql() . " AS nb_articles
             FROM " . $this->archivesFrom() . "
             WHERE {$where}
             ORDER BY date_demande DESC, d.id DESC
             LIMIT " . (int) $offset . ", " . (int) $limit,
            $binds
        );
        return $q ? $q->result_array() : [];
    }

    /** Articles de plusieurs demandes, groupés par request_id */
    public function getArchivesItems(array $ids)
    {
        $out = [];
        $ids = array_filter(array_map('intval', $ids));
        if (!$ids || !$this->db->table_exists($this->table_items)) return $out;

        $cols = $this->getColonnesItems();
        $sel  = function ($k) use ($cols) {
            return isset($cols[$k]) ? "i.`{$cols[$k]}`" : 'NULL';
        };

        foreach (array_chunk($ids, 1000) as $chunk) {
            $q = $this->run(
                "SELECT i.id, i.request_id,
                        {$sel('designation')} AS designation,
                        {$sel('quantite')} AS quantite,
                        {$sel('unite')} AS unite,
                        {$sel('pu')} AS pu,
                        {$sel('total')} AS total
                 FROM {$this->table_items} i
                 WHERE i.request_id IN (" . implode(',', $chunk) . ")
                 ORDER BY i.request_id, i.id"
            );
            if (!$q) continue;

            foreach ($q->result_array() as $it) {
                $qte = $it['quantite'] !== null ? (float) $it['quantite'] : null;
                $pu  = $it['pu'] !== null ? (float) $it['pu'] : null;
                $tot = $it['total'] !== null ? (float) $it['total'] : (($qte !== null && $pu !== null) ? $qte * $pu : null);

                $out[(int) $it['request_id']][] = [
                    'designation' => (string) $it['designation'],
                    'quantite'    => $qte,
                    'unite'       => (string) $it['unite'],
                    'pu'          => $pu,
                    'total'       => $tot,
                ];
            }
        }
        return $out;
    }
}
