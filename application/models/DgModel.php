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

    public function __construct()
    {
        parent::__construct();

        // Initialisation des tables
        $this->table_vouchers = 'purchase_payment_vouchers';
        $this->table_items    = 'purchase_request_items';
        $this->table_forms    = 'purchase_request_forms';
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
     * Récupérer les statistiques globales avec filtres
     * Exclut les demandes déjà payées en trésorerie
     */
    // public function getVoucherStatistics($user_id = null, $date_debut = null, $date_fin = null, $chantier_filtre = null): array
    // {
    //     // Sous-requête pour exclure les demandes déjà payées
    //     $exclude_subquery = "(SELECT purchase_request_id FROM tbl_finance_mouvement_secondaire 
    //                     WHERE status = 'validated' 
    //                     AND purchase_request_id IS NOT NULL)";

    //     // Total demandé (excluant les demandes payées)
    //     $this->db->select_sum('pv.amount_paid');
    //     $this->db->from($this->table_vouchers . ' pv');
    //     $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
    //     $this->db->where('pf.company_id', 2);
    //     $this->db->where_not_in('pf.id', $exclude_subquery); // ✅ Exclure les payées

    //     if ($date_debut && $date_fin) {
    //         $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
    //         $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
    //     }
    //     if ($chantier_filtre && $chantier_filtre !== 'tous') {
    //         $this->db->where('pf.destination_chantier', $chantier_filtre);
    //     }
    //     if ($user_id) {
    //         $this->db->where('pv.created_by', $user_id);
    //     }

    //     $result_demande = $this->db->get()->row();
    //     $total_demande = $result_demande->amount_paid ?? 0;

    //     // Total autorisé (excluant les demandes payées)
    //     $this->db->select_sum('pv.amount_paid');
    //     $this->db->from($this->table_vouchers . ' pv');
    //     $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
    //     $this->db->where('pf.company_id', 2);
    //     $this->db->where('pv.amount_paid >', 0);
    //     $this->db->where_not_in('pf.id', $exclude_subquery); // ✅ Exclure les payées

    //     if ($date_debut && $date_fin) {
    //         $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
    //         $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
    //     }
    //     if ($chantier_filtre && $chantier_filtre !== 'tous') {
    //         $this->db->where('pf.destination_chantier', $chantier_filtre);
    //     }
    //     if ($user_id) {
    //         $this->db->where('pv.created_by', $user_id);
    //     }

    //     $result_autorise = $this->db->get()->row();
    //     $total_autorise = $result_autorise->amount_paid ?? 0;

    //     // Nombre total de demandes (excluant les payées)
    //     $this->db->from($this->table_vouchers . ' pv');
    //     $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
    //     $this->db->where('pf.company_id', 2);
    //     $this->db->where_not_in('pf.id', $exclude_subquery); // ✅ Exclure les payées

    //     if ($date_debut && $date_fin) {
    //         $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
    //         $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
    //     }
    //     if ($chantier_filtre && $chantier_filtre !== 'tous') {
    //         $this->db->where('pf.destination_chantier', $chantier_filtre);
    //     }
    //     if ($user_id) {
    //         $this->db->where('pv.created_by', $user_id);
    //     }

    //     $nb_demandes = $this->db->count_all_results();

    //     // Nombre en attente (excluant les payées)
    //     $this->db->from($this->table_vouchers . ' pv');
    //     $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
    //     $this->db->where('pf.company_id', 2);
    //     $this->db->where('pv.amount_paid', 0);
    //     $this->db->where_not_in('pf.id', $exclude_subquery); // ✅ Exclure les payées

    //     if ($date_debut && $date_fin) {
    //         $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
    //         $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
    //     }
    //     if ($chantier_filtre && $chantier_filtre !== 'tous') {
    //         $this->db->where('pf.destination_chantier', $chantier_filtre);
    //     }
    //     if ($user_id) {
    //         $this->db->where('pv.created_by', $user_id);
    //     }

    //     $nb_en_attente = $this->db->count_all_results();

    //     // Nombre autorisé (excluant les payées)
    //     $this->db->from($this->table_vouchers . ' pv');
    //     $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
    //     $this->db->where('pf.company_id', 2);
    //     $this->db->where('pv.amount_paid >', 0);
    //     $this->db->where_not_in('pf.id', $exclude_subquery); // ✅ Exclure les payées

    //     if ($date_debut && $date_fin) {
    //         $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
    //         $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
    //     }
    //     if ($chantier_filtre && $chantier_filtre !== 'tous') {
    //         $this->db->where('pf.destination_chantier', $chantier_filtre);
    //     }
    //     if ($user_id) {
    //         $this->db->where('pv.created_by', $user_id);
    //     }

    //     $nb_effectue = $this->db->count_all_results();

    //     // Calcul
    //     $ecart = $total_demande - $total_autorise;
    //     $taux_autorisation = $total_demande > 0 ? round(($total_autorise / $total_demande) * 100, 1) : 0;

    //     return [
    //         'total_demande'       => (float) $total_demande,
    //         'total_autorise'      => (float) $total_autorise,
    //         'nb_demandes'         => (int) $nb_demandes,
    //         'nb_en_attente'       => (int) $nb_en_attente,
    //         'nb_effectue'         => (int) $nb_effectue,
    //         'ecart'               => (float) $ecart,
    //         'taux_autorisation'   => (float) $taux_autorisation,
    //     ];
    // }



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



    public function getDemandesByChantier($user_id = null, $date_debut = null, $date_fin = null, $chantier_filtre = null): array
    {
        // ✅ ÉTAPE 1 : Récupérer les IDs des demandes déjà payées
        $this->db->select('purchase_request_id');
        $this->db->from('tbl_finance_mouvement_secondaire');
        $this->db->where('status', 'validated');
        $this->db->where('purchase_request_id IS NOT NULL');
        $paid_requests = $this->db->get()->result();

        // Créer un tableau des IDs payés
        $paid_ids = [0]; // 0 par défaut pour éviter les erreurs SQL si vide
        foreach ($paid_requests as $row) {
            $paid_ids[] = $row->purchase_request_id;
        }

        // ✅ ÉTAPE 2 : Requête principale
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

        // ✅ Exclure les demandes déjà payées (avec un tableau, pas une closure)
        $this->db->where_not_in('pf.id', $paid_ids);

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
        $this->db->where($exclude_condition); // ✅ Utiliser la condition manuelle

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
        $this->db->select_sum('pv.amount_paid');
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);
        $this->db->where('pv.amount_paid >', 0);
        $this->db->where($exclude_condition); // ✅ Exclure les payés

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
     * Récupérer toutes les sorties de caisse relation publique
     */
    public function getSortiesRelationPublique($date_debut = null, $date_fin = null, $status = null): array
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
}
