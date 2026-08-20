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
     */
    public function getVoucherStatistics($user_id = null, $date_debut = null, $date_fin = null, $chantier_filtre = null): array
    {
        // Condition de base pour le join
        $condition_base = "pv.created_by = pv.created_by"; // toujours vrai

        // Total demandé
        $this->db->select_sum('pv.amount_paid');
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
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

        $result_demande = $this->db->get()->row();
        $total_demande = $result_demande->amount_paid ?? 0;

        // Total autorisé
        $this->db->select_sum('pv.amount_paid');
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);
        $this->db->where('pv.amount_paid >', 0);

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

        $result_autorise = $this->db->get()->row();
        $total_autorise = $result_autorise->amount_paid ?? 0;

        // Nombre total de demandes
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
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

        $nb_demandes = $this->db->count_all_results();

        // Nombre en attente
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);
        $this->db->where('pv.amount_paid', 0);

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

        // Nombre autorisé
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);
        $this->db->where('pv.amount_paid >', 0);

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

        // Calcul
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

    /**
     * Récupérer les données groupées par chantier pour les graphiques avec filtres
     */
    public function getVouchersByChantier($user_id = null, $date_debut = null, $date_fin = null, $chantier_filtre = null): array
    {
        $this->db->select('pf.destination_chantier, pv.payment_status, SUM(pv.amount_paid) as total');
        $this->db->from($this->table_vouchers . ' pv');
        $this->db->join($this->table_forms . ' pf', 'pv.request_id = pf.id', 'left');
        $this->db->where('pf.company_id', 2);

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
     */
    public function getDemandesByChantier($user_id = null, $date_debut = null, $date_fin = null, $chantier_filtre = null): array
    {
        $this->db->select('pf.*, 
                    pv.id as voucher_id, 
                    pv.request_id, 
                    pv.payment_number, 
                    pv.payment_status, 
                    pv.amount_paid as montant_autorise');
        $this->db->from($this->table_forms . ' pf');
        $this->db->join($this->table_vouchers . ' pv', 'pf.id = pv.request_id', 'left');
        $this->db->where('pf.company_id', 2);

        // Filtre par date
        if ($date_debut && $date_fin) {
            $this->db->where('pv.created_at >=', $date_debut . ' 00:00:00');
            $this->db->where('pv.created_at <=', $date_fin . ' 23:59:59');
        }

        // Filtre par chantier
        if ($chantier_filtre && $chantier_filtre !== 'tous') {
            $this->db->where('pf.destination_chantier', $chantier_filtre);
        }

        // Filtre par user
        if ($user_id) {
            $this->db->where('pv.created_by', $user_id);
        }

        $this->db->order_by('pf.destination_chantier', 'ASC');
        $this->db->order_by('pf.id', 'DESC');

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
}