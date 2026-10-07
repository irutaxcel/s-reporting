<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TechModel extends CI_Model
{

    /* ---- Module Engins & Matériels ---- */
    /** Table des chantiers (colonnes utilisées : id, name) */
    const T_CHANTIER = 'chantiers';

    const ETATS        = ['Disponible', 'Sur chantier', 'Maintenance', 'En panne', 'Réformé'];
    const COMPTEURS    = ['km', 'heure', 'aucun'];
    const CARBURANTS   = ['Diesel', 'Essence', 'Mélange 2T', 'Électrique', 'Aucun'];
    const FUEL_TYPES   = ['Diesel', 'Essence', 'Mélange 2T'];
    const FUEL_SOURCES = ['Station', 'Stock interne', 'Fût chantier'];
    const MAINT_TYPES  = ['Préventive', 'Corrective', 'Inspection', 'Révision générale'];
    const MAINT_STATUS = ['Programmé', 'En cours', 'Terminé', 'Annulé'];
    const PANNE_OPEN   = ['Signalée', 'En diagnostic', 'En réparation'];
    const PANNE_STATUS = ['Signalée', 'En diagnostic', 'En réparation', 'Résolue', 'Annulée'];
    const GRAVITES     = ['Mineure', 'Majeure', 'Critique'];
    const DOC_TYPES    = [
        'Carte grise',
        'Assurance',
        'Contrôle technique',
        "Facture d'achat",
        'Autorisation de circuler',
        'Manuel / Notice',
        'Autre'
    ];

    /** Marge d'alerte avant une échéance au compteur */
    const MARGE_KM    = 500;
    const MARGE_HEURE = 25;


    public function getAllChantier()
    {
        return $this->db
            ->select('*')
            ->from('chantiers')
            ->order_by('name', 'ASC')
            ->get()
            ->result();
    }

    public function insertPersonnelChantierBatch($data)
    {
        return $this->db->insert_batch('workforce_contracts', $data);
    }

    public function getPersonlChantier($chantier_id, $date_debut, $date_fin)
    {
        return $this->db
            ->select('*')
            ->from('workforce_contracts')
            ->where('chantier_id', $chantier_id)
            ->where('created_at >=', $date_debut . ' 00:00:00')
            ->where('created_at <=', $date_fin . ' 23:59:59')
            ->order_by('created_at', 'DESC')
            ->get()
            ->result();
    }

    public function updatePersonnelChantier($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('workforce_contracts', $data);
    }

    public function deletePersonnelChantier($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('workforce_contracts');
    }

    // public function countAllPersonnel()
    // {
    //     return $this->db->count_all('workforce_contracts');
    // }

    // public function sumAllPersonnel()
    // {
    //     $this->db->select_sum('unit_rate');

    //     $result = $this->db->get('workforce_contracts')->row();

    //     return $result->unit_rate;
    // }

    public function getChantierById($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('chantiers')
            ->row();
    }

    public function countAllPersonnel($date_debut, $date_fin)
    {
        return $this->db
            ->where('DATE(created_at) >=', $date_debut)
            ->where('DATE(created_at) <=', $date_fin)
            ->count_all_results('workforce_contracts');
    }

    public function sumAllPersonnel($date_debut, $date_fin)
    {
        $this->db->select_sum('unit_rate');
        $this->db->where('DATE(created_at) >=', $date_debut);
        $this->db->where('DATE(created_at) <=', $date_fin);

        $result = $this->db->get('workforce_contracts')->row();

        return $result && $result->unit_rate ? $result->unit_rate : 0;
    }

    // public function getAllAchats($filters = [])
    // {
    //     $this->db->select("
    //         prf.*,
    //         p.name AS chantier_nom,
    //         COUNT(pri.id) AS nombre_articles,
    //         GROUP_CONCAT(
    //             DISTINCT pri.designation
    //             ORDER BY pri.id ASC
    //             SEPARATOR ', '
    //         ) AS articles_designation,
    //         COALESCE(SUM(pri.total_price), 0) AS montant_articles
    //     ");

    //     $this->db->from('purchase_request_forms prf');

    //     $this->db->join(
    //         'projects p',
    //         'p.id = prf.chantier_id',
    //         'left'
    //     );

    //     $this->db->join(
    //         'purchase_request_items pri',
    //         'pri.request_id = prf.id',
    //         'left'
    //     );

    //     /*
    //     * Filtre chantier
    //     */
    //     if (!empty($filters['chantier_id'])) {
    //         $this->db->where(
    //             'prf.chantier_id',
    //             (int) $filters['chantier_id']
    //         );
    //     }

    //     /*
    //     * Filtre statut
    //     */
    //     if (!empty($filters['workflow_status'])) {
    //         $this->db->where(
    //             'prf.workflow_status',
    //             $filters['workflow_status']
    //         );
    //     }

    //     /*
    //     * Filtre date début
    //     */
    //     if (!empty($filters['date_debut'])) {
    //         $dateDebut = date(
    //             'Y-m-d',
    //             strtotime($filters['date_debut'])
    //         );

    //         $this->db->where(
    //             "DATE(COALESCE(prf.request_date, prf.created_at)) >= " .
    //                 $this->db->escape($dateDebut),
    //             null,
    //             false
    //         );
    //     }

    //     /*
    //     * Filtre date fin
    //     */
    //     if (!empty($filters['date_fin'])) {
    //         $dateFin = date(
    //             'Y-m-d',
    //             strtotime($filters['date_fin'])
    //         );

    //         $this->db->where(
    //             "DATE(COALESCE(prf.request_date, prf.created_at)) <= " .
    //                 $this->db->escape($dateFin),
    //             null,
    //             false
    //         );
    //     }

    //     $this->db->group_by('prf.id');

    //     $this->db->order_by(
    //         'COALESCE(prf.request_date, prf.created_at)',
    //         'DESC',
    //         false
    //     );

    //     $this->db->order_by('prf.id', 'DESC');

    //     /*
    //     * Les 100 dernières demandes
    //     */
    //     $this->db->limit(100);

    //     return $this->db->get()->result();
    // }

    /**
     * ============================================================
     * EXCLUSION DES DEMANDES DÉJÀ PAYÉES EN TRÉSORERIE
     *
     * Une demande est considérée comme "déjà effectuée" si :
     *  - prf.payment_status = 'paye'
     *  - OU il existe un mouvement de trésorerie validé
     *    (tbl_finance_mouvement_secondaire :
     *     nature = 'paiement_da', sens = 'sortie', status = 'validated')
     * ============================================================
     */
    private function _excludeDejaPayees()
    {
        // 1) payment_status différent de 'paye' (ou NULL)
        $this->db->where(
            "(prf.payment_status IS NULL OR prf.payment_status <> 'paye')",
            null,
            false
        );

        // 2) aucun mouvement de paiement validé en trésorerie
        $this->db->where(
            "NOT EXISTS (
                SELECT 1
                FROM tbl_finance_mouvement_secondaire fms
                WHERE fms.purchase_request_id = prf.id
                  AND fms.nature = 'paiement_da'
                  AND fms.sens   = 'sortie'
                  AND fms.status = 'validated'
            )",
            null,
            false
        );
    }

    /**
     * Applique (ou non) l'exclusion des demandes déjà payées.
     * $filters['include_payes'] = true  => on les affiche quand même
     */
    private function _applyPayesFilter($filters)
    {
        if (empty($filters['include_payes'])) {
            $this->_excludeDejaPayees();
        }
    }

    // public function getAllAchats($filters = [])
    // {
    //     $this->db->select("
    //         prf.*,
    //         p.name AS chantier_nom,
    //         COUNT(pri.id) AS nombre_articles,
    //         GROUP_CONCAT(
    //             DISTINCT pri.designation
    //             ORDER BY pri.id ASC
    //             SEPARATOR ', '
    //         ) AS articles_designation,
    //         COALESCE(SUM(pri.total_price), 0) AS montant_articles
    //     ");

    //     $this->db->from('purchase_request_forms prf');

    //     $this->db->join('projects p', 'p.id = prf.chantier_id', 'left');

    //     $this->db->join('purchase_request_items pri', 'pri.request_id = prf.id', 'left');

    //     /*
    //     * ============================================================
    //     * FILTRE PAR UTILISATEUR (via created_by)
    //     * Rôles qui voient TOUTES les demandes :
    //     *   1  = SUPER_ADMIN
    //     *   2  = ADMINISTRATEUR_SYSTEM
    //     *   3  = DIRECTEUR_GENERAL
    //     *   4  = DIRECTEUR_TECHNIQUE
    //     *   7  = RESPONSABLE_ADMIN_FINANCIER (DAF)
    //     *   24 = TRESORIER
    //     *   30 = ASSISTANT_TRESORERIE
    //     * Tous les autres rôles ne voient que leurs propres demandes.
    //     * ============================================================
    //     */
    //     $rolesSeeAll = [1, 2, 3, 4, 7, 24, 30];

    //     if (!empty($filters['user_id']) && !empty($filters['role_id'])) {
    //         if (!in_array((int) $filters['role_id'], $rolesSeeAll)) {
    //             // Utilisateur classique : uniquement ses propres demandes
    //             $this->db->where('prf.created_by', (int) $filters['user_id']);
    //         }
    //         // Sinon (rôle privilégié) : pas de filtre → voit tout
    //     }

    //     /*
    //     * NOUVEAU : masquer les demandes déjà payées en trésorerie
    //     * (sauf si le filtre "include_payes" est activé)
    //     */
    //     $this->_applyPayesFilter($filters);

    //     /*
    //     * Filtre chantier
    //     */
    //     if (!empty($filters['chantier_id'])) {
    //         $this->db->where('prf.chantier_id', (int) $filters['chantier_id']);
    //     }

    //     /*
    //     * Filtre statut
    //     */
    //     if (!empty($filters['workflow_status'])) {
    //         $this->db->where('prf.workflow_status', $filters['workflow_status']);
    //     }

    //     /*
    //     * Filtre date début
    //     */
    //     if (!empty($filters['date_debut'])) {
    //         $dateDebut = date('Y-m-d', strtotime($filters['date_debut']));
    //         $this->db->where(
    //             "DATE(COALESCE(prf.request_date, prf.created_at)) >= " .
    //                 $this->db->escape($dateDebut),
    //             null,
    //             false
    //         );
    //     }

    //     /*
    //     * Filtre date fin
    //     */
    //     if (!empty($filters['date_fin'])) {
    //         $dateFin = date('Y-m-d', strtotime($filters['date_fin']));
    //         $this->db->where(
    //             "DATE(COALESCE(prf.request_date, prf.created_at)) <= " .
    //                 $this->db->escape($dateFin),
    //             null,
    //             false
    //         );
    //     }

    //     $this->db->group_by('prf.id');

    //     $this->db->order_by('COALESCE(prf.request_date, prf.created_at)', 'DESC', false);
    //     $this->db->order_by('prf.id', 'DESC');

    //     /*
    //     * Les 100 dernières demandes
    //     */
    //     $this->db->limit(100);

    //     return $this->db->get()->result();
    // }

    public function getAllAchats($filters = [])
    {
        // Utiliser une sous-requête pour récupérer le statut de paiement
        $this->db->select("
        prf.*,
        p.name AS chantier_nom,
        COUNT(pri.id) AS nombre_articles,
        GROUP_CONCAT(
            DISTINCT pri.designation
            ORDER BY pri.id ASC
            SEPARATOR ', '
        ) AS articles_designation,
        COALESCE(SUM(pri.total_price), 0) AS montant_articles,
        (SELECT payment_status 
         FROM purchase_payment_vouchers 
         WHERE request_id = prf.id 
         ORDER BY created_at DESC 
         LIMIT 1) AS last_payment_status
    ");

        $this->db->from('purchase_request_forms prf');
        $this->db->join('projects p', 'p.id = prf.chantier_id', 'left');
        $this->db->join('purchase_request_items pri', 'pri.request_id = prf.id', 'left');

        // Filtre utilisateur
        $rolesSeeAll = [1, 2, 3, 4, 7, 24, 30];
        if (!empty($filters['user_id']) && !empty($filters['role_id'])) {
            if (!in_array((int) $filters['role_id'], $rolesSeeAll)) {
                $this->db->where('prf.created_by', (int) $filters['user_id']);
            }
        }

        // Filtres
        if (!empty($filters['chantier_id'])) {
            $this->db->where('prf.chantier_id', (int) $filters['chantier_id']);
        }

        if (!empty($filters['workflow_status'])) {
            $this->db->where('prf.workflow_status', $filters['workflow_status']);
        }

        if (!empty($filters['date_debut'])) {
            $dateDebut = date('Y-m-d', strtotime($filters['date_debut']));
            $this->db->where("DATE(COALESCE(prf.request_date, prf.created_at)) >= " . $this->db->escape($dateDebut), null, false);
        }

        if (!empty($filters['date_fin'])) {
            $dateFin = date('Y-m-d', strtotime($filters['date_fin']));
            $this->db->where("DATE(COALESCE(prf.request_date, prf.created_at)) <= " . $this->db->escape($dateFin), null, false);
        }

        $this->db->group_by('prf.id');
        $this->db->order_by('prf.id', 'DESC');
        $this->db->limit(100);

        return $this->db->get()->result();
    }

    /**
     * Compteur aligné sur la liste :
     * demandes validées NON encore payées en trésorerie
     */
    public function countDemandesValidees($filters = [])
    {
        $this->db->where('workflow_status', 'Validé');

        // Exclusion des déjà payées (même logique que la liste)
        if (empty($filters['include_payes'])) {
            $this->db->where("(payment_status IS NULL OR payment_status <> 'paye')", null, false);
            $this->db->where(
                "NOT EXISTS (
                    SELECT 1
                    FROM tbl_finance_mouvement_secondaire fms
                    WHERE fms.purchase_request_id = purchase_request_forms.id
                    AND fms.nature = 'paiement_da'
                    AND fms.sens   = 'sortie'
                    AND fms.status = 'validated'
                )",
                null,
                false
            );
        }

        $this->_applyUserFilter($filters);

        return $this->db->count_all_results('purchase_request_forms');
    }

    /**
     * NOUVEAU : nombre de demandes déjà payées (masquées par défaut).
     * Utile pour afficher un petit badge d'information dans la vue.
     */
    public function countDejaPayees($filters = [])
    {
        $this->_applyUserFilter($filters);

        $this->db->group_start();

        $this->db->where('payment_status', 'paye');

        $this->db->or_where(
            "EXISTS (
                    SELECT 1
                    FROM tbl_finance_mouvement_secondaire fms
                    WHERE fms.purchase_request_id = purchase_request_forms.id
                      AND fms.nature = 'paiement_da'
                      AND fms.sens   = 'sortie'
                      AND fms.status = 'validated'
                )",
            null,
            false
        );

        $this->db->group_end();

        return $this->db->count_all_results('purchase_request_forms');
    }

    /**
     * Compter les achats effectués (livrés)
     */
    public function countAchatsEffectues($filters = [])
    {
        $this->db->where_in('workflow_status', ['livré', 'livre']);
        $this->_applyUserFilter($filters);
        return $this->db->count_all_results('purchase_request_forms');
    }

    /**
     * Compter les achats en approvisionnement (commandés)
     */
    public function countEnApprovisionnement($filters = [])
    {
        $this->db->where_in('workflow_status', ['commandée', 'commandee']);
        $this->_applyUserFilter($filters);
        return $this->db->count_all_results('purchase_request_forms');
    }

    /**
     * Compter les livraisons en retard
     * (workflow_status = commandée mais date de livraison dépassée)
     */
    public function countLivraisonsRetard($filters = [])
    {
        $today = date('Y-m-d');

        $this->db->where_in('workflow_status', ['commandée', 'commandee', 'En_attente']);
        $this->db->where('request_date <', $today); // Si vous avez ce champ
        // OU sinon basé sur created_at + délai dépassé
        // $this->db->where('DATE(created_at) <', date('Y-m-d', strtotime('-15 days')));

        $this->_applyUserFilter($filters);
        return $this->db->count_all_results('purchase_request_forms');
    }

    /**
     * Appliquer le filtre utilisateur (méthode helper)
     */
    private function _applyUserFilter($filters = [])
    {
        $rolesSeeAll = [1, 2, 3, 4, 7, 24, 30];

        if (!empty($filters['user_id']) && !empty($filters['role_id'])) {
            if (!in_array((int) $filters['role_id'], $rolesSeeAll)) {
                $this->db->where('created_by', (int) $filters['user_id']);
            }
        }
    }

    public function insert_achat_materiel_form($data_form, $articles, $quantites, $prix_unitaires, $observation_line, $totaux_lignes)
    {
        $this->db->trans_start();

        $this->db->insert('purchase_request_forms', $data_form);
        $form_id = $this->db->insert_id();

        if (!empty($articles)) {
            foreach ($articles as $key => $article) {

                if (trim($article) == '') {
                    continue;
                }

                $data_item = [
                    'request_id'      => $form_id,
                    'designation'     => $article,
                    'technical_specs' => null,
                    'quantity'        => $quantites[$key],
                    'unit_price'      => $prix_unitaires[$key],
                    'total_price'     => $totaux_lignes[$key],
                    'observations'    => $observation_line[$key],
                ];

                $this->db->insert('purchase_request_items', $data_item);
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // public function getAllAchats()
    // {
    //     $this->db->select("
    //         prf.*,
    //         p.name AS chantier_nom,
    //         GROUP_CONCAT(pri.designation SEPARATOR ', ') AS articles_designation
    //     ");

    //     $this->db->from('purchase_request_forms prf');
    //     $this->db->join('chantiers p', 'p.id = prf.chantier_id', 'left');
    //     $this->db->join('purchase_request_items pri', 'pri.request_id = prf.id', 'left');

    //     $this->db->group_by('prf.id');
    //     $this->db->order_by('prf.id', 'DESC');

    //     return $this->db->get()->result();
    // }

    public function validerAchat($id, $champ)
    {
        $data = [];

        if ($champ == 'technical_status') {

            // Validation DT
            $data = [
                'verifier_status'  => 'valide',
                'technical_status' => 'valide',
                'workflow_status' => 'En Attente'
            ];
        } elseif ($champ == 'financial_status') {

            // Validation DAF
            $data = [
                'verifier_status'  => 'valide',
                'financial_status' => 'valide',
                'workflow_status' => 'En Attente'
            ];
        } elseif ($champ == 'treasury_status') {

            // Validation Trésorerie
            $data = [
                'verifier_status' => 'valide',
                'treasury_status' => 'valide',
                'workflow_status' => 'Valide'
            ];
        } else {
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->update('purchase_request_forms', $data);
    }

    public function getAchatById($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('purchase_request_forms')
            ->row();
    }

    public function getAchatItems($id)
    {
        return $this->db
            ->where('request_id', $id)
            ->get('purchase_request_items')
            ->result();
    }

    public function updateAchatMateriel($id, $data_form, $articles, $quantites, $prix_unitaires, $totaux_lignes, $observation)
    {
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->update('purchase_request_forms', $data_form);

        $this->db->where('request_id', $id);
        $this->db->delete('purchase_request_items');

        if (!empty($articles)) {
            foreach ($articles as $key => $article) {
                if (trim($article) == '') {
                    continue;
                }

                $this->db->insert('purchase_request_items', [
                    'request_id'      => $id,
                    'designation'     => $article,
                    'technical_specs' => null,
                    'quantity'        => $quantites[$key],
                    'unit_price'      => $prix_unitaires[$key],
                    'total_price'     => $totaux_lignes[$key],
                    'observations'    => $observation[$key]
                ]);
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function deleteAchatMateriel($id)
    {
        $this->db->trans_start();

        $this->db->where('request_id', $id);
        $this->db->delete('purchase_request_items');

        $this->db->where('id', $id);
        $this->db->delete('purchase_request_forms');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function generateProjectReference()
    {
        $year = date('Y');

        $this->db->select('reference');
        $this->db->like('reference', 'PRJ-' . $year, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get('projects');

        if ($query->num_rows() > 0) {

            $lastRef = $query->row()->reference;

            // PRJ-2026-00018
            $number = (int) substr($lastRef, -5);

            $number++;
        } else {

            $number = 1;
        }

        return 'PRJ-' . $year . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    public function insertProject($data)
    {
        return $this->db->insert('projects', $data);
    }

    public function getAllProject()
    {
        $this->db->select('*');
        $this->db->from('projects');
        $this->db->order_by('id', 'DESC');

        return $this->db->get()->result();
    }

    public function getProjectById($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('projects')
            ->row();
    }

    public function updateProject($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('projects', $data);
    }

    public function deleteProject($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('projects');
    }

    public function generateChantierReference()
    {
        $this->db->select('ref_chantier');
        $this->db->from('chantiers');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $last = $query->row()->ref_chantier;

            $number = intval(substr($last, -3));

            $number++;
        } else {

            $number = 1;
        }

        return 'CH-' . date('Y') . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function insertChantier($data)
    {
        return $this->db->insert('chantiers', $data);
    }

    public function getAllChantiers()
    {
        $this->db->select('
            chantiers.*,
            projects.name AS project_name
        ');

        $this->db->from('chantiers');

        $this->db->join(
            'projects',
            'projects.id = chantiers.project_id',
            'left'
        );

        $this->db->order_by('chantiers.id', 'DESC');

        return $this->db->get()->result();
    }

    public function updateChantier($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('chantiers', $data);
    }

    public function deleteChantier($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('chantiers');
    }

    public function insert_subcontractor($data)
    {
        return $this->db->insert('subcontractors', $data);
    }

    public function getAllSubTraitant()
    {
        return $this->db
            ->order_by('id', 'DESC')
            ->get('subcontractors')
            ->result();
    }

    public function update_subcontractor($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update('subcontractors', $data);
    }

    public function delete_subcontractor($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('subcontractors');
    }

    public function insert_article($data)
    {
        return $this->db->insert('tbl_stock_article', $data);
    }

    public function insert_emplacement($data)
    {
        return $this->db->insert('tbl_stock_emplacement', $data);
    }

    public function insert_quantite_stock($data)
    {
        return $this->db->insert('tbl_stock_quantite', $data);
    }

    public function get_articles()
    {
        return $this->db->order_by('id', 'DESC')->get('tbl_stock_article')->result();
    }

    public function get_emplacements()
    {
        return $this->db->order_by('id', 'DESC')->get('tbl_stock_emplacement')->result();
    }

    public function get_stock_general()
    {
        $this->db->select('
            q.id,
            a.code_article,
            a.designation,
            a.unite,
            e.nom_emplacement,
            q.quantite
        ');
        $this->db->from('tbl_stock_quantite q');
        $this->db->join('tbl_stock_article a', 'a.id = q.article_id');
        $this->db->join('tbl_stock_emplacement e', 'e.id = q.emplacement_id');
        $this->db->order_by('q.id', 'DESC');

        return $this->db->get()->result();
    }

    public function get_stock_stats()
    {
        return [
            'total_articles' => $this->db->count_all('tbl_stock_article'),
            'total_emplacements' => $this->db->count_all('tbl_stock_emplacement'),
            'total_lignes_stock' => $this->db->count_all('tbl_stock_quantite'),
            'quantite_totale' => $this->db
                ->select_sum('quantite')
                ->get('tbl_stock_quantite')
                ->row()
                ->quantite ?? 0
        ];
    }

    public function get_stock_general_filtered($article_id = null, $emplacement_id = null)
    {
        $this->db->select("
            a.id AS article_id,
            a.code_article,
            a.designation,
            a.unite,
            a.categorie,
            e.id AS emplacement_id,
            e.nom_emplacement,

            SUM(q.quantite) AS quantite_emplacement,

            (
                SELECT SUM(sq.quantite)
                FROM tbl_stock_quantite sq
                WHERE sq.article_id = q.article_id
            ) AS total_article
        ", false);

        $this->db->from('tbl_stock_quantite q');
        $this->db->join('tbl_stock_article a', 'a.id = q.article_id');
        $this->db->join('tbl_stock_emplacement e', 'e.id = q.emplacement_id');

        if (!empty($article_id)) {
            $this->db->where('q.article_id', $article_id);
        }

        if (!empty($emplacement_id)) {
            $this->db->where('q.emplacement_id', $emplacement_id);
        }

        $this->db->group_by([
            'a.id',
            'a.code_article',
            'a.designation',
            'a.unite',
            'a.categorie',
            'e.id',
            'e.nom_emplacement'
        ]);

        $this->db->order_by('a.designation', 'ASC');
        $this->db->order_by('e.nom_emplacement', 'ASC');

        return $this->db->get()->result();
    }

    public function get_total_stock_by_article()
    {
        $this->db->select('
        a.code_article,
        a.designation,
        a.unite,
        SUM(q.quantite) AS total_quantite
    ');
        $this->db->from('tbl_stock_quantite q');
        $this->db->join('tbl_stock_article a', 'a.id = q.article_id');
        $this->db->group_by('q.article_id');
        $this->db->order_by('a.designation', 'ASC');

        return $this->db->get()->result();
    }

    public function getDatas()
    {
        return $this->db
            ->where('status', 1)
            ->get('tbl_engin_categorie')
            ->result();
    }

    public function insertData($table, $data)
    {
        $this->db->insert($table, $data);

        return $this->db->insert_id();
    }

    // public function getDatas($table, $where = [])
    // {
    //     return $this->db->get_where($table, $where)->result();
    // }

    public function getData($table, $where = [])
    {
        return $this->db->get_where($table, $where)->row();
    }

    public function updateData($table, $where, $data)
    {
        $this->db->where($where);
        return $this->db->update($table, $data);
    }


    /**
     * Liste des engins actifs (utilisée aussi par le Journal de production).
     * La photo principale est désormais lue via is_principale.
     */
    public function getAllEngins()
    {
        return $this->getEngins();
    }

    /* ---------------------------------------------------------------------
     |  ANCIENNES MÉTHODES de la page Maintenance & Carburant.
     |  Elles ne sont plus appelées par ces pages ; conservées pour ne pas
     |  casser un autre écran qui les utiliserait. Supprimez-les si aucun
     |  autre fichier ne les appelle (recherche : getAllEnginsWithFuel,
     |  getAllMaintenances, getMaintenanceAlerts, getMostExpensiveEnginsCurrentMonth,
     |  getRecentTechnicalOperations, getMaintenanceFuelStatistics).
     * --------------------------------------------------------------------- */
    public function getAllEnginsWithFuel($limit = null)
    {
        $this->db
            ->select('
            f.*,
            e.code_engin,
            e.designation,
            e.marque,
            e.modele,
            ch.name AS chantier_name
        ')
            ->from('tbl_engin_fuel f')
            ->join(
                'tbl_engin_materiel e',
                'e.id = f.engin_id',
                'left'
            )
            ->join(
                'chantiers ch',
                'ch.id = f.chantier_id',
                'left'
            )
            ->where('f.status', 1)
            ->order_by('f.operation_date', 'DESC')
            ->order_by('f.id', 'DESC');

        if (!empty($limit)) {
            $this->db->limit((int) $limit);
        }

        return $this->db->get()->result();
    }

    public function getAllMaintenances($limit = null)
    {
        $this->db
            ->select('
            m.*,
            e.code_engin,
            e.designation,
            e.marque,
            e.modele,
            ch.name AS chantier_name,
            COUNT(md.id) AS documents_count
        ')
            ->from('tbl_engin_maintenance m')
            ->join(
                'tbl_engin_materiel e',
                'e.id = m.engin_id',
                'left'
            )
            ->join(
                'chantiers ch',
                'ch.id = m.chantier_id',
                'left'
            )
            ->join(
                'tbl_engin_maintenance_document md',
                'md.maintenance_id = m.id',
                'left'
            )
            ->where('m.record_status', 1)
            ->group_by('m.id')
            ->order_by('m.planned_date', 'DESC')
            ->order_by('m.id', 'DESC');

        if (!empty($limit)) {
            $this->db->limit((int) $limit);
        }

        return $this->db->get()->result();
    }

    public function getMaintenanceAlerts($limit = 6)
    {
        return $this->db
            ->select("
            m.id,
            m.engin_id,
            m.maintenance_type,
            m.intervention,
            m.planned_date,
            m.next_maintenance_date,
            m.maintenance_status,
            m.description,
            e.code_engin,
            e.designation,
            DATEDIFF(
                COALESCE(m.next_maintenance_date, m.planned_date),
                CURDATE()
            ) AS days_remaining
        ", false)
            ->from('tbl_engin_maintenance m')
            ->join(
                'tbl_engin_materiel e',
                'e.id = m.engin_id',
                'left'
            )
            ->where('m.record_status', 1)
            ->where_in(
                'm.maintenance_status',
                ['Programmé', 'En cours']
            )
            ->where(
                "COALESCE(m.next_maintenance_date, m.planned_date) IS NOT NULL",
                null,
                false
            )
            ->where(
                "COALESCE(m.next_maintenance_date, m.planned_date) <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)",
                null,
                false
            )
            ->order_by(
                'COALESCE(m.next_maintenance_date, m.planned_date)',
                'ASC',
                false
            )
            ->limit((int) $limit)
            ->get()
            ->result();
    }

    public function getMostExpensiveEnginsCurrentMonth($limit = 5)
    {
        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        $sql = "
        SELECT
            e.id,
            e.code_engin,
            e.designation,
            e.marque,
            e.modele,

            COALESCE(f.total_fuel_cost, 0) AS fuel_cost,
            COALESCE(m.total_maintenance_cost, 0) AS maintenance_cost,

            (
                COALESCE(f.total_fuel_cost, 0)
                +
                COALESCE(m.total_maintenance_cost, 0)
            ) AS total_cost

        FROM tbl_engin_materiel e

        LEFT JOIN
        (
            SELECT
                engin_id,
                SUM(total_amount) AS total_fuel_cost
            FROM tbl_engin_fuel
            WHERE status = 1
              AND operation_date BETWEEN ? AND ?
            GROUP BY engin_id
        ) f
            ON f.engin_id = e.id

        LEFT JOIN
        (
            SELECT
                engin_id,
                SUM(total_cost) AS total_maintenance_cost
            FROM tbl_engin_maintenance
            WHERE record_status = 1
              AND planned_date BETWEEN ? AND ?
            GROUP BY engin_id
        ) m
            ON m.engin_id = e.id

        WHERE e.status = 1

          AND (
                COALESCE(f.total_fuel_cost, 0)
                +
                COALESCE(m.total_maintenance_cost, 0)
              ) > 0

        ORDER BY total_cost DESC

        LIMIT " . (int) $limit;

        return $this->db
            ->query(
                $sql,
                [
                    $monthStart,
                    $monthEnd,
                    $monthStart,
                    $monthEnd
                ]
            )
            ->result();
    }

    public function getRecentTechnicalOperations($limit = 20)
    {
        $limit = (int) $limit;

        if ($limit <= 0) {
            $limit = 20;
        }

        $sql = "
        SELECT *
        FROM
        (
            /*
            |--------------------------------------------------------------------------
            | Ravitaillements
            |--------------------------------------------------------------------------
            */

            SELECT
                f.id AS operation_id,
                'fuel' AS operation_source,

                f.operation_date AS operation_date,

                CONCAT(
                    'CAR-',
                    YEAR(f.operation_date),
                    '-',
                    LPAD(f.id, 5, '0')
                ) AS reference,

                f.engin_id,
                e.code_engin,
                e.designation,

                'Ravitaillement carburant' AS operation_name,
                'Carburant' AS operation_type,

                f.chantier_id,
                ch.name AS chantier_name,

                f.total_amount AS amount,
                f.operator_name AS responsible,

                CASE
                    WHEN f.status = 1 THEN 'Validé'
                    ELSE 'Annulé'
                END AS operation_status,

                f.observation AS description,

                0 AS documents_count

            FROM tbl_engin_fuel f

            LEFT JOIN tbl_engin_materiel e
                ON e.id = f.engin_id

            LEFT JOIN chantiers ch
                ON ch.id = f.chantier_id

            /*
            |--------------------------------------------------------------------------
            | Maintenance
            |--------------------------------------------------------------------------
            */

            UNION ALL

            SELECT
                m.id AS operation_id,
                'maintenance' AS operation_source,

                m.planned_date AS operation_date,

                CONCAT(
                    'MAI-',
                    YEAR(m.planned_date),
                    '-',
                    LPAD(m.id, 5, '0')
                ) AS reference,

                m.engin_id,
                e.code_engin,
                e.designation,

                m.intervention AS operation_name,
                m.maintenance_type AS operation_type,

                m.chantier_id,
                ch.name AS chantier_name,

                m.total_cost AS amount,
                m.technician AS responsible,

                m.maintenance_status AS operation_status,

                m.description AS description,

                (
                    SELECT COUNT(md.id)
                    FROM tbl_engin_maintenance_document md
                    WHERE md.maintenance_id = m.id
                ) AS documents_count

            FROM tbl_engin_maintenance m

            LEFT JOIN tbl_engin_materiel e
                ON e.id = m.engin_id

            LEFT JOIN chantiers ch
                ON ch.id = m.chantier_id

            WHERE m.record_status = 1

        ) AS operations

        ORDER BY
            operation_date DESC,
            operation_id DESC

        LIMIT {$limit}
    ";

        return $this->db
            ->query($sql)
            ->result();
    }

    public function getMaintenanceFuelStatistics()
    {
        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        /*
    |--------------------------------------------------------------------------
    | Carburant consommé ce mois
    |--------------------------------------------------------------------------
    */

        $fuel = $this->db
            ->select('
            COALESCE(SUM(quantity_litre), 0) AS total_litres,
            COALESCE(SUM(total_amount), 0) AS total_fuel_cost
        ')
            ->from('tbl_engin_fuel')
            ->where('status', 1)
            ->where('operation_date >=', $monthStart)
            ->where('operation_date <=', $monthEnd)
            ->get()
            ->row();

        /*
    |--------------------------------------------------------------------------
    | Maintenances programmées
    |--------------------------------------------------------------------------
    */

        $programmedMaintenance = $this->db
            ->from('tbl_engin_maintenance')
            ->where('record_status', 1)
            ->where('maintenance_status', 'Programmé')
            ->count_all_results();

        /*
    |--------------------------------------------------------------------------
    | Engins actuellement en atelier
    |--------------------------------------------------------------------------
    */

        $enginsInWorkshop = $this->db
            ->from('tbl_engin_materiel')
            ->where('status', 1)
            ->where('etat', 'Maintenance')
            ->count_all_results();

        /*
    |--------------------------------------------------------------------------
    | Coût d’exploitation du mois
    |--------------------------------------------------------------------------
    */

        $maintenance = $this->db
            ->select('COALESCE(SUM(total_cost), 0) AS total_maintenance_cost')
            ->from('tbl_engin_maintenance')
            ->where('record_status', 1)
            ->where('planned_date >=', $monthStart)
            ->where('planned_date <=', $monthEnd)
            ->get()
            ->row();

        $totalFuelCost = (float) ($fuel->total_fuel_cost ?? 0);

        $totalMaintenanceCost =
            (float) ($maintenance->total_maintenance_cost ?? 0);

        return (object) [
            'total_litres'              => (float) ($fuel->total_litres ?? 0),
            'programmed_maintenance'    => (int) $programmedMaintenance,
            'engins_in_workshop'        => (int) $enginsInWorkshop,
            'total_fuel_cost'           => $totalFuelCost,
            'total_maintenance_cost'    => $totalMaintenanceCost,
            'total_operation_cost'      => $totalFuelCost + $totalMaintenanceCost
        ];
    }

    /* =====================================================================
     |  MODULE ENGINS & MATÉRIELS (Immobilisations) — pages
     |  « Engin & Materiel » et « Maintenance & Carburant »
     * ===================================================================== */

    private function engNow()
    {
        return date('Y-m-d H:i:s');
    }

    /* =====================================================================
     |  RÉFÉRENTIELS
     * ===================================================================== */

    public function getCategories()
    {
        return $this->db->where('status', 1)->order_by('nom_categorie', 'ASC')
            ->get('tbl_engin_categorie')->result();
    }

    public function getChantiers()
    {
        return $this->db->select('id, name')->order_by('name', 'ASC')
            ->get(self::T_CHANTIER)->result();
    }

    /* =====================================================================
     |  RÉFÉRENCES AUTOMATIQUES (ENG / CARB / MNT / PAN / AFF)
     * ===================================================================== */

    /**
     * Réserve le prochain numéro de façon atomique (verrou de ligne).
     * Appelé uniquement au moment de l'enregistrement.
     */
    public function reserveCode($prefixe)
    {
        $annee = (int) date('Y');

        $this->db->trans_start();
        $this->db->query(
            'INSERT IGNORE INTO tbl_engin_code (prefixe, annee, dernier_numero) VALUES (?, ?, 0)',
            [$prefixe, $annee]
        );
        $row = $this->db->query(
            'SELECT id, dernier_numero FROM tbl_engin_code WHERE prefixe = ? AND annee = ? FOR UPDATE',
            [$prefixe, $annee]
        )->row();
        $numero = (int) $row->dernier_numero + 1;
        $this->db->query(
            'UPDATE tbl_engin_code SET dernier_numero = ?, updated_at = NOW() WHERE id = ?',
            [$numero, $row->id]
        );
        $this->db->trans_complete();

        return sprintf('%s-%d-%05d', $prefixe, $annee, $numero);
    }

    /** Aperçu du prochain code (affichage seulement, ne réserve rien) */
    public function previewCode($prefixe)
    {
        $row = $this->db->select('dernier_numero')
            ->where(['prefixe' => $prefixe, 'annee' => (int) date('Y')])
            ->get('tbl_engin_code')->row();

        return sprintf('%s-%d-%05d', $prefixe, date('Y'), ($row ? (int) $row->dernier_numero : 0) + 1);
    }

    /* =====================================================================
     |  PARC
     * ===================================================================== */

    private function engSelect()
    {
        $this->db->select("m.*, c.nom_categorie, c.code AS categorie_code, c.icon AS categorie_icon,
                ch.name AS chantier_name,
                (SELECT p.photo FROM tbl_engin_photo p
                  WHERE p.engin_id = m.id
                  ORDER BY p.is_principale DESC, p.id ASC LIMIT 1) AS photo_principale,
                (SELECT COUNT(*) FROM tbl_engin_document d
                  WHERE d.engin_id = m.id
                    AND d.date_expiration IS NOT NULL
                    AND d.date_expiration <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
                    AND NOT EXISTS (SELECT 1 FROM tbl_engin_document d2
                                     WHERE d2.engin_id = d.engin_id
                                       AND d2.type_document = d.type_document
                                       AND d2.date_expiration > d.date_expiration)) AS docs_alerte", false)
            ->from('tbl_engin_materiel m')
            ->join('tbl_engin_categorie c', 'c.id = m.categorie_id', 'left')
            ->join(self::T_CHANTIER . ' ch', 'ch.id = m.chantier_id', 'left')
            ->where('m.status', 1);
    }

    /**
     * Liste filtrée du parc.
     * Les engins réformés sont exclus sauf si on filtre explicitement sur 'Réformé'.
     */
    public function getEngins(array $f = [])
    {
        $this->engSelect();

        if (!empty($f['q'])) {
            $this->db->group_start()
                ->like('m.code_engin', $f['q'])
                ->or_like('m.designation', $f['q'])
                ->or_like('m.plaque', $f['q'])
                ->or_like('m.marque', $f['q'])
                ->or_like('m.modele', $f['q'])
                ->or_like('m.numero_serie', $f['q'])
                ->group_end();
        }
        if (!empty($f['categorie_id'])) {
            $this->db->where('m.categorie_id', (int) $f['categorie_id']);
        }
        if (!empty($f['chantier_id'])) {
            $this->db->where('m.chantier_id', (int) $f['chantier_id']);
        }
        if (!empty($f['etat'])) {
            $this->db->where('m.etat', $f['etat']);
        } else {
            $this->db->where('m.etat !=', 'Réformé');
        }

        return $this->db->order_by('m.code_engin', 'ASC')->get()->result();
    }

    public function getEngin($id)
    {
        $this->engSelect();
        return $this->db->where('m.id', (int) $id)->get()->row();
    }

    public function getParcStats()
    {
        return $this->db->query("SELECT
                COUNT(*)                              AS total,
                COALESCE(SUM(etat = 'Disponible'), 0)   AS disponible,
                COALESCE(SUM(etat = 'Sur chantier'), 0) AS sur_chantier,
                COALESCE(SUM(etat = 'Maintenance'), 0)  AS maintenance,
                COALESCE(SUM(etat = 'En panne'), 0)     AS en_panne,
                COALESCE(SUM(etat = 'Réformé'), 0)      AS reformes,
                COALESCE(SUM(IF(etat <> 'Réformé', COALESCE(valeur_achat, 0), 0)), 0) AS valeur_parc
            FROM tbl_engin_materiel WHERE status = 1")->row();
    }

    public function plaqueExists($plaque, $excludeId = 0)
    {
        if ($plaque === null || $plaque === '') {
            return false;
        }
        return $this->db->where(['plaque' => $plaque, 'status' => 1])
            ->where('id !=', (int) $excludeId)
            ->count_all_results('tbl_engin_materiel') > 0;
    }

    public function insertEngin(array $data)
    {
        $this->db->insert('tbl_engin_materiel', $data);
        return (int) $this->db->insert_id();
    }

    public function updateEngin($id, array $data)
    {
        $data['updated_at'] = $this->engNow();
        return $this->db->where('id', (int) $id)->update('tbl_engin_materiel', $data);
    }

    public function hasOperations($id)
    {
        $id  = (int) $id;
        $row = $this->db->query(
            'SELECT (SELECT COUNT(*) FROM tbl_engin_fuel WHERE engin_id = ?)
                  + (SELECT COUNT(*) FROM tbl_engin_maintenance WHERE engin_id = ?)
                  + (SELECT COUNT(*) FROM tbl_engin_panne WHERE engin_id = ?) AS n',
            [$id, $id, $id]
        )->row();
        return (int) $row->n > 0;
    }

    public function softDeleteEngin($id, $userId)
    {
        return $this->updateEngin($id, ['status' => 0, 'updated_by' => $userId]);
    }

    /* ---------------------------------------------------------------------
     |  Photos & documents
     * --------------------------------------------------------------------- */

    public function getPhotos($enginId)
    {
        return $this->db->where('engin_id', (int) $enginId)
            ->order_by('is_principale', 'DESC')->order_by('id', 'ASC')
            ->get('tbl_engin_photo')->result();
    }

    public function addPhoto($enginId, array $file)
    {
        $hasPrincipale = $this->db->where(['engin_id' => (int) $enginId, 'is_principale' => 1])
            ->count_all_results('tbl_engin_photo') > 0;

        $this->db->insert('tbl_engin_photo', [
            'engin_id'      => (int) $enginId,
            'photo'         => $file['file_name'],
            'original_name' => $file['orig_name'],
            'file_size'     => $file['file_size'],
            'is_principale' => $hasPrincipale ? 0 : 1,
        ]);
        return (int) $this->db->insert_id();
    }

    /** Supprime la ligne et retourne la photo (pour effacer le fichier) */
    public function deletePhoto($id)
    {
        $photo = $this->db->get_where('tbl_engin_photo', ['id' => (int) $id])->row();
        if (!$photo) {
            return null;
        }
        $this->db->delete('tbl_engin_photo', ['id' => $photo->id]);

        if ((int) $photo->is_principale === 1) {
            $next = $this->db->where('engin_id', $photo->engin_id)->order_by('id', 'ASC')
                ->limit(1)->get('tbl_engin_photo')->row();
            if ($next) {
                $this->db->where('id', $next->id)->update('tbl_engin_photo', ['is_principale' => 1]);
            }
        }
        return $photo;
    }

    public function setPhotoPrincipale($photoId)
    {
        $photo = $this->db->get_where('tbl_engin_photo', ['id' => (int) $photoId])->row();
        if (!$photo) {
            return null;
        }
        $this->db->where('engin_id', $photo->engin_id)->update('tbl_engin_photo', ['is_principale' => 0]);
        $this->db->where('id', $photo->id)->update('tbl_engin_photo', ['is_principale' => 1]);
        return $photo;
    }

    public function getDocuments($enginId)
    {
        return $this->db->where('engin_id', (int) $enginId)
            ->order_by('type_document', 'ASC')->order_by('date_expiration', 'DESC')
            ->get('tbl_engin_document')->result();
    }

    public function addDocument($enginId, array $data)
    {
        $data['engin_id'] = (int) $enginId;
        $this->db->insert('tbl_engin_document', $data);
        return (int) $this->db->insert_id();
    }

    public function deleteDocument($id)
    {
        $doc = $this->db->get_where('tbl_engin_document', ['id' => (int) $id])->row();
        if ($doc) {
            $this->db->delete('tbl_engin_document', ['id' => $doc->id]);
        }
        return $doc;
    }

    /* =====================================================================
     |  ÉTAT & COMPTEUR (règles métier)
     * ===================================================================== */

    /**
     * Recalcule l'état d'un engin à partir des événements :
     *   maintenance « En cours » immobilisante -> Maintenance
     *   panne ouverte immobilisante            -> En panne
     *   affecté à un chantier                  -> Sur chantier
     *   sinon                                  -> Disponible
     * Un engin réformé n'est jamais modifié.
     */
    public function syncEtat($enginId)
    {
        $e = $this->db->select('id, etat, chantier_id')
            ->get_where('tbl_engin_materiel', ['id' => (int) $enginId])->row();
        if (!$e || $e->etat === 'Réformé') {
            return;
        }

        $enMaintenance = $this->db->where([
            'engin_id' => $e->id,
            'record_status' => 1,
            'maintenance_status' => 'En cours',
            'immobilise' => 1,
        ])->count_all_results('tbl_engin_maintenance') > 0;

        $enPanne = $this->db->where(['engin_id' => $e->id, 'status' => 1, 'immobilise' => 1])
            ->where_in('panne_status', self::PANNE_OPEN)
            ->count_all_results('tbl_engin_panne') > 0;

        if ($enMaintenance) {
            $etat = 'Maintenance';
        } elseif ($enPanne) {
            $etat = 'En panne';
        } elseif (!empty($e->chantier_id)) {
            $etat = 'Sur chantier';
        } else {
            $etat = 'Disponible';
        }

        if ($etat !== $e->etat) {
            $this->db->where('id', $e->id)->update('tbl_engin_materiel', ['etat' => $etat, 'updated_at' => $this->engNow()]);
        }
    }

    /** compteur_actuel = plus grand relevé connu (carburant, maintenance, panne, affectation) */
    public function recalcCompteur($enginId)
    {
        $this->db->query("UPDATE tbl_engin_materiel m SET m.compteur_actuel = GREATEST(
                m.compteur_initial,
                COALESCE((SELECT MAX(IF(m.type_compteur = 'heure', f.hour_meter, f.kilometrage))
                            FROM tbl_engin_fuel f WHERE f.engin_id = m.id AND f.status = 1), 0),
                COALESCE((SELECT MAX(x.compteur_intervention)
                            FROM tbl_engin_maintenance x WHERE x.engin_id = m.id AND x.record_status = 1), 0),
                COALESCE((SELECT MAX(p.compteur)
                            FROM tbl_engin_panne p WHERE p.engin_id = m.id AND p.status = 1), 0),
                COALESCE((SELECT MAX(GREATEST(COALESCE(a.compteur_depart, 0), COALESCE(a.compteur_retour, 0)))
                            FROM tbl_engin_affectation a WHERE a.engin_id = m.id AND a.status = 1), 0)
            ) WHERE m.id = ?", [(int) $enginId]);
    }

    /** Plus grand relevé carburant saisi jusqu'à une date (contrôle de saisie) */
    public function getLastCompteurBefore($enginId, $date, $excludeFuelId = 0)
    {
        $e = $this->db->select('type_compteur, compteur_initial')
            ->get_where('tbl_engin_materiel', ['id' => (int) $enginId])->row();
        if (!$e || $e->type_compteur === 'aucun') {
            return null;
        }
        $col = $e->type_compteur === 'heure' ? 'hour_meter' : 'kilometrage';
        $row = $this->db->query(
            "SELECT MAX($col) AS c FROM tbl_engin_fuel
              WHERE engin_id = ? AND status = 1 AND operation_date <= ? AND id <> ?",
            [(int) $enginId, $date, (int) $excludeFuelId]
        )->row();

        return max((float) $e->compteur_initial, (float) ($row ? $row->c : 0));
    }

    /* =====================================================================
     |  AFFECTATIONS & RÉFORME
     * ===================================================================== */

    private function engCloseOpenAffectation($enginId, $dateFin, $compteurRetour = null)
    {
        $this->db->query(
            'UPDATE tbl_engin_affectation
                SET date_fin = GREATEST(date_debut, ?),
                    compteur_retour = COALESCE(?, compteur_retour),
                    updated_at = NOW()
              WHERE engin_id = ? AND date_fin IS NULL AND status = 1',
            [$dateFin, $compteurRetour, (int) $enginId]
        );
    }

    /**
     * Affecte un engin à un chantier (ou le ramène à un lieu : dépôt, atelier...).
     * Clôture l'affectation en cours, crée la nouvelle, met à jour la fiche.
     */
    public function affecter($enginId, array $a, $userId)
    {
        $enginId = (int) $enginId;

        $this->db->trans_start();

        $this->engCloseOpenAffectation($enginId, $a['date_debut'], $a['compteur_depart']);

        $this->db->insert('tbl_engin_affectation', [
            'reference'       => $this->reserveCode('AFF'),
            'engin_id'        => $enginId,
            'chantier_id'     => $a['chantier_id'] ?: null,
            'localisation'    => $a['localisation'] ?: null,
            'date_debut'      => $a['date_debut'],
            'responsable'     => $a['responsable'] ?: null,
            'compteur_depart' => $a['compteur_depart'],
            'observation'     => $a['observation'] ?: null,
            'created_by'      => $userId,
        ]);

        $upd = [
            'chantier_id'  => $a['chantier_id'] ?: null,
            'localisation' => $a['localisation'] ?: null,
            'updated_by'   => $userId,
        ];
        if (!empty($a['responsable'])) {
            $upd['responsable'] = $a['responsable'];
        }
        $this->updateEngin($enginId, $upd);

        $this->recalcCompteur($enginId);
        $this->syncEtat($enginId);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function getAffectations($enginId, $limit = 10)
    {
        return $this->db->select('a.*, ch.name AS chantier_name')
            ->from('tbl_engin_affectation a')
            ->join(self::T_CHANTIER . ' ch', 'ch.id = a.chantier_id', 'left')
            ->where(['a.engin_id' => (int) $enginId, 'a.status' => 1])
            ->order_by('a.date_debut', 'DESC')->order_by('a.id', 'DESC')
            ->limit((int) $limit)->get()->result();
    }

    public function reformer($enginId, $date, $motif, $userId)
    {
        $this->db->trans_start();
        $this->engCloseOpenAffectation($enginId, $date);
        $this->updateEngin($enginId, [
            'etat'          => 'Réformé',
            'date_reforme'  => $date,
            'motif_reforme' => $motif,
            'chantier_id'   => null,
            'localisation'  => 'Hors parc',
            'updated_by'    => $userId,
        ]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /* =====================================================================
     |  FILTRES COMMUNS (listes carburant / maintenance)
     * ===================================================================== */

    private function engApplyFilters(array $f, $alias, $dateExpr)
    {
        if (!empty($f['engin_id'])) {
            $this->db->where("$alias.engin_id", (int) $f['engin_id']);
        }
        if (!empty($f['chantier_id'])) {
            $this->db->where("$alias.chantier_id", (int) $f['chantier_id']);
        }
        if (!empty($f['date_debut'])) {
            $this->db->where("$dateExpr >=", $this->db->escape($f['date_debut']), false);
        }
        if (!empty($f['date_fin'])) {
            $this->db->where("$dateExpr <=", $this->db->escape($f['date_fin']), false);
        }
        if (!empty($f['q'])) {
            $this->db->group_start()
                ->like('m.code_engin', $f['q'])
                ->or_like('m.designation', $f['q'])
                ->or_like('m.plaque', $f['q'])
                ->or_like("$alias.reference", $f['q'])
                ->group_end();
        }
    }

    /* =====================================================================
     |  CARBURANT
     * ===================================================================== */

    public function getFuels(array $f = [], $limit = 15)
    {
        if (!empty($f['type']) && $f['type'] !== 'fuel') {
            return [];
        }
        if (!empty($f['status']) && $f['status'] !== 'Validé') {
            return [];
        }

        $this->db->select('f.*, m.code_engin, m.designation, m.plaque, m.type_compteur, ch.name AS chantier_name')
            ->from('tbl_engin_fuel f')
            ->join('tbl_engin_materiel m', 'm.id = f.engin_id')
            ->join(self::T_CHANTIER . ' ch', 'ch.id = f.chantier_id', 'left')
            ->where('f.status', 1);
        $this->engApplyFilters($f, 'f', 'f.operation_date');
        $this->db->order_by('f.operation_date', 'DESC')->order_by('f.id', 'DESC');
        if ($limit) {
            $this->db->limit((int) $limit);
        }
        return $this->db->get()->result();
    }

    public function getFuel($id)
    {
        return $this->db->select('f.*, m.code_engin, m.designation, m.plaque, m.type_compteur, ch.name AS chantier_name')
            ->from('tbl_engin_fuel f')
            ->join('tbl_engin_materiel m', 'm.id = f.engin_id')
            ->join(self::T_CHANTIER . ' ch', 'ch.id = f.chantier_id', 'left')
            ->where(['f.id' => (int) $id, 'f.status' => 1])
            ->get()->row();
    }

    public function insertFuel(array $data)
    {
        $this->db->trans_start();
        $data['reference'] = $this->reserveCode('CARB');
        $this->db->insert('tbl_engin_fuel', $data);
        $id = (int) $this->db->insert_id();
        $this->recalcCompteur($data['engin_id']);
        $this->db->trans_complete();

        return $this->db->trans_status() ? $id : false;
    }

    public function updateFuel($id, array $data)
    {
        $old = $this->db->get_where('tbl_engin_fuel', ['id' => (int) $id])->row();
        if (!$old) {
            return false;
        }
        $data['updated_at'] = $this->engNow();

        $this->db->trans_start();
        $this->db->where('id', (int) $id)->update('tbl_engin_fuel', $data);
        $this->recalcCompteur($data['engin_id']);
        if ((int) $old->engin_id !== (int) $data['engin_id']) {
            $this->recalcCompteur($old->engin_id);
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function cancelFuel($id)
    {
        $fuel = $this->db->get_where('tbl_engin_fuel', ['id' => (int) $id, 'status' => 1])->row();
        if (!$fuel) {
            return false;
        }
        $this->db->where('id', $fuel->id)->update('tbl_engin_fuel', ['status' => 0, 'updated_at' => $this->engNow()]);
        $this->recalcCompteur($fuel->engin_id);
        return true;
    }

    /* =====================================================================
     |  MAINTENANCES
     * ===================================================================== */

    public function getMaintenances(array $f = [], $limit = 15)
    {
        if (!empty($f['type']) && $f['type'] !== 'maintenance') {
            return [];
        }
        if (!empty($f['status']) && !in_array($f['status'], self::MAINT_STATUS, true)) {
            return [];
        }

        $this->db->select('x.*, m.code_engin, m.designation, m.plaque, m.type_compteur, ch.name AS chantier_name,
                (SELECT COUNT(*) FROM tbl_engin_maintenance_document d WHERE d.maintenance_id = x.id) AS documents_count,
                (SELECT COUNT(*) FROM tbl_engin_maintenance_piece pc WHERE pc.maintenance_id = x.id) AS pieces_count', false)
            ->from('tbl_engin_maintenance x')
            ->join('tbl_engin_materiel m', 'm.id = x.engin_id')
            ->join(self::T_CHANTIER . ' ch', 'ch.id = x.chantier_id', 'left')
            ->where('x.record_status', 1);
        if (!empty($f['status'])) {
            $this->db->where('x.maintenance_status', $f['status']);
        }
        $this->engApplyFilters($f, 'x', 'COALESCE(x.end_date, x.start_date, x.planned_date)');
        $this->db->order_by('x.planned_date', 'DESC')->order_by('x.id', 'DESC');
        if ($limit) {
            $this->db->limit((int) $limit);
        }
        return $this->db->get()->result();
    }

    public function getMaintenance($id)
    {
        $m = $this->db->select('x.*, m.code_engin, m.designation, m.plaque, m.type_compteur,
                ch.name AS chantier_name, p.reference AS panne_reference, p.description AS panne_description')
            ->from('tbl_engin_maintenance x')
            ->join('tbl_engin_materiel m', 'm.id = x.engin_id')
            ->join(self::T_CHANTIER . ' ch', 'ch.id = x.chantier_id', 'left')
            ->join('tbl_engin_panne p', 'p.id = x.panne_id', 'left')
            ->where(['x.id' => (int) $id, 'x.record_status' => 1])
            ->get()->row();
        if (!$m) {
            return null;
        }
        $m->pieces = $this->db->where('maintenance_id', $m->id)->order_by('id', 'ASC')
            ->get('tbl_engin_maintenance_piece')->result();
        $m->documents = $this->db->where('maintenance_id', $m->id)->order_by('id', 'ASC')
            ->get('tbl_engin_maintenance_document')->result();
        return $m;
    }

    private function engSavePieces($maintenanceId, array $pieces)
    {
        $this->db->delete('tbl_engin_maintenance_piece', ['maintenance_id' => (int) $maintenanceId]);
        if (!$pieces) {
            return;
        }
        foreach ($pieces as &$p) {
            $p['maintenance_id'] = (int) $maintenanceId;
        }
        unset($p);
        $this->db->insert_batch('tbl_engin_maintenance_piece', $pieces);
    }

    /** Répercute une maintenance sur la panne liée, le compteur et l'état de l'engin */
    private function engAfterMaintenanceChange($maintenanceId)
    {
        $m = $this->db->get_where('tbl_engin_maintenance', ['id' => (int) $maintenanceId])->row();
        if (!$m) {
            return;
        }

        if ($m->panne_id) {
            $panne = $this->db->get_where('tbl_engin_panne', ['id' => $m->panne_id])->row();
            if ($panne) {
                $upd = ['maintenance_id' => $m->id, 'updated_at' => $this->engNow()];
                if ($m->maintenance_status === 'Terminé') {
                    if (in_array($panne->panne_status, self::PANNE_OPEN, true)) {
                        $upd['panne_status']    = 'Résolue';
                        $upd['date_resolution'] = $this->engNow();
                    }
                } elseif ($m->maintenance_status === 'Annulé') {
                    if ($panne->panne_status === 'En réparation') {
                        $upd['panne_status'] = 'Signalée';
                    }
                } elseif (in_array($panne->panne_status, self::PANNE_OPEN, true)) {
                    $upd['panne_status'] = 'En réparation';
                }
                $this->db->where('id', $panne->id)->update('tbl_engin_panne', $upd);
            }
        }

        $this->recalcCompteur($m->engin_id);
        $this->syncEtat($m->engin_id);
    }

    public function insertMaintenance(array $data, array $pieces)
    {
        $this->db->trans_start();
        $data['reference'] = $this->reserveCode('MNT');
        $this->db->insert('tbl_engin_maintenance', $data);
        $id = (int) $this->db->insert_id();
        $this->engSavePieces($id, $pieces);
        $this->engAfterMaintenanceChange($id);
        $this->db->trans_complete();

        return $this->db->trans_status() ? $id : false;
    }

    public function updateMaintenance($id, array $data, array $pieces)
    {
        $old = $this->db->get_where('tbl_engin_maintenance', ['id' => (int) $id])->row();
        if (!$old) {
            return false;
        }
        $data['updated_at'] = $this->engNow();

        $this->db->trans_start();
        $this->db->where('id', $old->id)->update('tbl_engin_maintenance', $data);
        $this->engSavePieces($old->id, $pieces);

        // L'ancienne panne n'est plus liée : on la « libère »
        if ($old->panne_id && (int) $old->panne_id !== (int) $data['panne_id']) {
            $this->db->query(
                "UPDATE tbl_engin_panne
                    SET maintenance_id = NULL,
                        panne_status = IF(panne_status = 'En réparation', 'Signalée', panne_status),
                        updated_at = NOW()
                  WHERE id = ?",
                [$old->panne_id]
            );
        }

        $this->engAfterMaintenanceChange($old->id);
        if ((int) $old->engin_id !== (int) $data['engin_id']) {
            $this->recalcCompteur($old->engin_id);
            $this->syncEtat($old->engin_id);
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function setMaintenanceStatus($id, $status)
    {
        $m = $this->db->get_where('tbl_engin_maintenance', ['id' => (int) $id, 'record_status' => 1])->row();
        if (!$m) {
            return false;
        }
        $today = date('Y-m-d');
        $upd   = ['maintenance_status' => $status, 'updated_at' => $this->engNow()];

        if ($status === 'En cours' && empty($m->start_date)) {
            $upd['start_date'] = $today;
        }
        if ($status === 'Terminé') {
            if (empty($m->start_date)) {
                $upd['start_date'] = min($m->planned_date, $today);
            }
            if (empty($m->end_date)) {
                $upd['end_date'] = $today;
            }
        }

        $this->db->trans_start();
        $this->db->where('id', $m->id)->update('tbl_engin_maintenance', $upd);
        $this->engAfterMaintenanceChange($m->id);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function addMaintenanceDocument($maintenanceId, array $file)
    {
        $this->db->insert('tbl_engin_maintenance_document', [
            'maintenance_id' => (int) $maintenanceId,
            'document'       => $file['file_name'],
            'original_name'  => $file['orig_name'],
            'file_type'      => $file['file_type'],
            'file_size'      => $file['file_size'],
        ]);
    }

    public function deleteMaintenanceDocument($id)
    {
        $doc = $this->db->get_where('tbl_engin_maintenance_document', ['id' => (int) $id])->row();
        if ($doc) {
            $this->db->delete('tbl_engin_maintenance_document', ['id' => $doc->id]);
        }
        return $doc;
    }

    /* =====================================================================
     |  PANNES
     * ===================================================================== */

    public function insertPanne(array $data)
    {
        $this->db->trans_start();
        $data['reference'] = $this->reserveCode('PAN');
        $this->db->insert('tbl_engin_panne', $data);
        $id = (int) $this->db->insert_id();
        $this->recalcCompteur($data['engin_id']);
        $this->syncEtat($data['engin_id']);
        $this->db->trans_complete();

        return $this->db->trans_status() ? $id : false;
    }

    public function getPanne($id)
    {
        return $this->db->select('p.*, m.code_engin, m.designation, m.chantier_id AS engin_chantier_id')
            ->from('tbl_engin_panne p')
            ->join('tbl_engin_materiel m', 'm.id = p.engin_id')
            ->where(['p.id' => (int) $id, 'p.status' => 1])
            ->get()->row();
    }

    public function getOpenPannes($limit = 50)
    {
        return $this->db->select('p.*, m.code_engin, m.designation, m.plaque, ch.name AS chantier_name')
            ->from('tbl_engin_panne p')
            ->join('tbl_engin_materiel m', 'm.id = p.engin_id')
            ->join(self::T_CHANTIER . ' ch', 'ch.id = p.chantier_id', 'left')
            ->where(['p.status' => 1, 'm.status' => 1])
            ->where_in('p.panne_status', self::PANNE_OPEN)
            ->order_by("FIELD(p.gravite, 'Critique', 'Majeure', 'Mineure')", '', false)
            ->order_by('p.date_signalement', 'DESC')
            ->limit((int) $limit)->get()->result();
    }

    public function setPanneStatus($id, $status)
    {
        $p = $this->db->get_where('tbl_engin_panne', ['id' => (int) $id, 'status' => 1])->row();
        if (!$p) {
            return false;
        }
        $upd = ['panne_status' => $status, 'updated_at' => $this->engNow()];
        if ($status === 'Résolue') {
            $upd['date_resolution'] = $this->engNow();
        }
        $this->db->where('id', $p->id)->update('tbl_engin_panne', $upd);
        $this->syncEtat($p->engin_id);
        return true;
    }

    /* =====================================================================
     |  STATISTIQUES & TABLEAUX DE BORD
     * ===================================================================== */

    public function getMaintenanceFuelStats($du, $au)
    {
        $fuel = $this->db->query(
            'SELECT COALESCE(SUM(quantity_litre), 0) AS litres, COALESCE(SUM(total_amount), 0) AS montant, COUNT(*) AS nb
               FROM tbl_engin_fuel WHERE status = 1 AND operation_date BETWEEN ? AND ?',
            [$du, $au]
        )->row();

        $maint = $this->db->query(
            "SELECT COALESCE(SUM(total_cost), 0) AS cout, COUNT(*) AS nb
               FROM tbl_engin_maintenance
              WHERE record_status = 1 AND maintenance_status IN ('En cours', 'Terminé')
                AND COALESCE(end_date, start_date, planned_date) BETWEEN ? AND ?",
            [$du, $au]
        )->row();

        $prog = $this->db->query(
            "SELECT COUNT(*) AS total, COALESCE(SUM(planned_date < CURDATE()), 0) AS retard
               FROM tbl_engin_maintenance WHERE record_status = 1 AND maintenance_status = 'Programmé'"
        )->row();

        $parc = $this->db->query(
            "SELECT COALESCE(SUM(etat = 'Maintenance'), 0) AS atelier, COALESCE(SUM(etat = 'En panne'), 0) AS panne
               FROM tbl_engin_materiel WHERE status = 1"
        )->row();

        $pannes = $this->db->where('status', 1)->where_in('panne_status', self::PANNE_OPEN)
            ->count_all_results('tbl_engin_panne');

        return (object) [
            'fuel_litres'      => (float) $fuel->litres,
            'fuel_montant'     => (float) $fuel->montant,
            'fuel_nb'          => (int) $fuel->nb,
            'maint_cout'       => (float) $maint->cout,
            'maint_nb'         => (int) $maint->nb,
            'programmees'      => (int) $prog->total,
            'en_retard'        => (int) $prog->retard,
            'en_atelier'       => (int) $parc->atelier,
            'en_panne'         => (int) $parc->panne,
            'pannes_ouvertes'  => (int) $pannes,
            'cout_exploitation' => (float) $fuel->montant + (float) $maint->cout,
        ];
    }

    public function getMostExpensiveEngins($du, $au, $limit = 5)
    {
        return $this->db->query(
            "SELECT m.id, m.code_engin, m.designation, m.type_compteur,
                    COALESCE(f.cost, 0) AS fuel_cost,
                    COALESCE(x.cost, 0) AS maintenance_cost,
                    COALESCE(f.cost, 0) + COALESCE(x.cost, 0) AS total_cost
               FROM tbl_engin_materiel m
               LEFT JOIN (SELECT engin_id, SUM(total_amount) AS cost FROM tbl_engin_fuel
                           WHERE status = 1 AND operation_date BETWEEN ? AND ? GROUP BY engin_id) f ON f.engin_id = m.id
               LEFT JOIN (SELECT engin_id, SUM(total_cost) AS cost FROM tbl_engin_maintenance
                           WHERE record_status = 1 AND maintenance_status IN ('En cours', 'Terminé')
                             AND COALESCE(end_date, start_date, planned_date) BETWEEN ? AND ?
                           GROUP BY engin_id) x ON x.engin_id = m.id
              WHERE m.status = 1
             HAVING total_cost > 0
              ORDER BY total_cost DESC
              LIMIT " . (int) $limit,
            [$du, $au, $du, $au]
        )->result();
    }

    /** Coûts mensuels (carburant / maintenance) sur N mois glissants */
    public function getMonthlyCosts($months = 6, $enginId = null)
    {
        $first = strtotime(date('Y-m-01'));
        $keys  = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $keys[date('Y-m', strtotime("-$i months", $first))] = ['fuel' => 0.0, 'maintenance' => 0.0];
        }
        $start  = array_keys($keys)[0] . '-01';
        $filter = $enginId ? ' AND engin_id = ' . (int) $enginId : '';

        $fuel = $this->db->query(
            "SELECT DATE_FORMAT(operation_date, '%Y-%m') AS ym, SUM(total_amount) AS v
               FROM tbl_engin_fuel WHERE status = 1 AND operation_date >= ? $filter GROUP BY ym",
            [$start]
        )->result();
        foreach ($fuel as $r) {
            if (isset($keys[$r->ym])) {
                $keys[$r->ym]['fuel'] = (float) $r->v;
            }
        }

        $maint = $this->db->query(
            "SELECT DATE_FORMAT(COALESCE(end_date, start_date, planned_date), '%Y-%m') AS ym, SUM(total_cost) AS v
               FROM tbl_engin_maintenance
              WHERE record_status = 1 AND maintenance_status IN ('En cours', 'Terminé')
                AND COALESCE(end_date, start_date, planned_date) >= ? $filter
              GROUP BY ym",
            [$start]
        )->result();
        foreach ($maint as $r) {
            if (isset($keys[$r->ym])) {
                $keys[$r->ym]['maintenance'] = (float) $r->v;
            }
        }

        return $keys;
    }

    /**
     * Consommation réelle par engin (méthode du « plein à plein ») :
     * les litres versés après un plein complet, jusqu'au plein complet suivant,
     * rapportés à la distance (ou aux heures) parcourue entre les deux.
     *
     * @return array [engin_id => object]
     */
    public function getConsumption($du, $au, $enginId = null)
    {
        $sql = "SELECT f.engin_id, f.quantity_litre, f.total_amount, f.plein_complet,
                       IF(m.type_compteur = 'heure', f.hour_meter, f.kilometrage) AS compteur,
                       m.type_compteur, m.consommation_reference, m.code_engin, m.designation
                  FROM tbl_engin_fuel f
                  JOIN tbl_engin_materiel m ON m.id = f.engin_id
                 WHERE f.status = 1 AND m.status = 1 AND f.operation_date BETWEEN ? AND ?";
        $params = [$du, $au];
        if ($enginId) {
            $sql .= ' AND f.engin_id = ?';
            $params[] = (int) $enginId;
        }
        $sql .= ' ORDER BY f.engin_id, f.operation_date, compteur, f.id';

        $out = [];
        foreach ($this->db->query($sql, $params)->result() as $r) {
            $k = (int) $r->engin_id;
            if (!isset($out[$k])) {
                $out[$k] = (object) [
                    'engin_id'       => $k,
                    'code_engin'     => $r->code_engin,
                    'designation'    => $r->designation,
                    'type_compteur'  => $r->type_compteur,
                    'reference'      => $r->consommation_reference !== null ? (float) $r->consommation_reference : null,
                    'litres'         => 0.0,
                    'montant'        => 0.0,
                    'nb'             => 0,
                    'distance'       => 0.0,
                    'litres_mesures' => 0.0,
                    'compteur_min'   => null,
                    'compteur_max'   => null,
                    'conso'          => null,
                    'ecart'          => null,
                    'unite'          => $r->type_compteur === 'heure' ? 'L/h' : 'L/100 km',
                    '_last'          => null,
                    '_acc'           => 0.0,
                ];
            }
            $o = $out[$k];
            $o->litres  += (float) $r->quantity_litre;
            $o->montant += (float) $r->total_amount;
            $o->nb++;

            $c = ($r->compteur !== null && (float) $r->compteur > 0) ? (float) $r->compteur : null;
            if ($c !== null) {
                $o->compteur_min = $o->compteur_min === null ? $c : min($o->compteur_min, $c);
                $o->compteur_max = $o->compteur_max === null ? $c : max($o->compteur_max, $c);
            }

            if ($o->_last === null) {
                if ((int) $r->plein_complet === 1 && $c !== null) {
                    $o->_last = $c;
                }
                continue;
            }

            $o->_acc += (float) $r->quantity_litre;
            if ((int) $r->plein_complet === 1 && $c !== null && $c > $o->_last) {
                $o->distance       += $c - $o->_last;
                $o->litres_mesures += $o->_acc;
                $o->_acc  = 0.0;
                $o->_last = $c;
            }
        }

        foreach ($out as $o) {
            if ($o->distance > 0 && $o->type_compteur !== 'aucun') {
                $o->conso = $o->type_compteur === 'heure'
                    ? $o->litres_mesures / $o->distance
                    : $o->litres_mesures / $o->distance * 100;
                if ($o->reference) {
                    $o->ecart = ($o->conso - $o->reference) / $o->reference * 100;
                }
            }
            unset($o->_last, $o->_acc);
        }
        return $out;
    }

    /* =====================================================================
     |  ALERTES
     * ===================================================================== */

    private function engAlert($level, $icon, $title, $row, $text, $date = null, $days = null, $kind = '')
    {
        return (object) [
            'level'       => $level,
            'icon'        => $icon,
            'title'       => $title,
            'engin_id'    => isset($row->engin_id) ? (int) $row->engin_id : null,
            'code_engin'  => isset($row->code_engin) ? $row->code_engin : '',
            'designation' => isset($row->designation) ? $row->designation : '',
            'text'        => $text,
            'date'        => $date,
            'days'        => $days,
            'kind'        => $kind,
        ];
    }

    private function engLevelFromDays($days)
    {
        if ($days <= 0) {
            return 'danger';
        }
        return $days <= 7 ? 'warning' : 'info';
    }

    private function engDaysUntil($date)
    {
        $today = new DateTime('today');
        $d     = new DateTime($date);
        return (int) $today->diff($d)->format('%r%a');
    }

    /**
     * Toutes les alertes du parc, triées par urgence :
     * maintenances programmées, échéances (date / compteur), documents,
     * pannes ouvertes, consommations anormales.
     */
    public function getAlerts($days = 30)
    {
        $days   = (int) $days;
        $alerts = [];

        // 1. Maintenances programmées proches ou en retard
        $rows = $this->db->query(
            "SELECT x.id, x.engin_id, x.intervention, x.planned_date, m.code_engin, m.designation
               FROM tbl_engin_maintenance x JOIN tbl_engin_materiel m ON m.id = x.engin_id
              WHERE x.record_status = 1 AND x.maintenance_status = 'Programmé' AND m.status = 1
                AND x.planned_date <= DATE_ADD(CURDATE(), INTERVAL $days DAY)"
        )->result();
        foreach ($rows as $r) {
            $d = $this->engDaysUntil($r->planned_date);
            $alerts[] = $this->engAlert(
                $this->engLevelFromDays($d),
                $d < 0 ? 'fas fa-exclamation-triangle' : 'fas fa-calendar-alt',
                $d < 0 ? 'Maintenance en retard' : 'Maintenance programmée',
                $r,
                $r->intervention,
                $r->planned_date,
                $d,
                'maintenance'
            );
        }

        // Sous-requête : une maintenance de suivi existe déjà pour la même intervention
        $noFollowUp = "NOT EXISTS (SELECT 1 FROM tbl_engin_maintenance y
                                    WHERE y.engin_id = x.engin_id AND y.id > x.id
                                      AND y.intervention = x.intervention
                                      AND y.record_status = 1 AND y.maintenance_status <> 'Annulé')";

        // 2. Prochaines échéances par date
        $rows = $this->db->query(
            "SELECT x.id, x.engin_id, x.intervention, x.next_maintenance_date, m.code_engin, m.designation
               FROM tbl_engin_maintenance x JOIN tbl_engin_materiel m ON m.id = x.engin_id
              WHERE x.record_status = 1 AND x.maintenance_status = 'Terminé' AND m.status = 1
                AND m.etat <> 'Réformé'
                AND x.next_maintenance_date IS NOT NULL
                AND x.next_maintenance_date <= DATE_ADD(CURDATE(), INTERVAL $days DAY)
                AND $noFollowUp"
        )->result();
        foreach ($rows as $r) {
            $d = $this->engDaysUntil($r->next_maintenance_date);
            $alerts[] = $this->engAlert(
                $this->engLevelFromDays($d),
                'fas fa-clock',
                $d < 0 ? 'Entretien dépassé' : 'Entretien à prévoir',
                $r,
                $r->intervention,
                $r->next_maintenance_date,
                $d,
                'echeance'
            );
        }

        // 3. Prochaines échéances au compteur
        $rows = $this->db->query(
            "SELECT x.id, x.engin_id, x.intervention, x.next_maintenance_compteur,
                    m.compteur_actuel, m.type_compteur, m.code_engin, m.designation
               FROM tbl_engin_maintenance x JOIN tbl_engin_materiel m ON m.id = x.engin_id
              WHERE x.record_status = 1 AND x.maintenance_status = 'Terminé' AND m.status = 1
                AND m.etat <> 'Réformé' AND m.type_compteur <> 'aucun'
                AND x.next_maintenance_compteur IS NOT NULL
                AND m.compteur_actuel >= x.next_maintenance_compteur
                    - IF(m.type_compteur = 'heure', " . self::MARGE_HEURE . ", " . self::MARGE_KM . ")
                AND $noFollowUp"
        )->result();
        foreach ($rows as $r) {
            $reste = (float) $r->next_maintenance_compteur - (float) $r->compteur_actuel;
            $unit  = $r->type_compteur === 'heure' ? 'h' : 'km';
            $text  = $r->intervention . ' — ' . ($reste <= 0
                ? 'dépassé de ' . number_format(abs($reste), 0, ',', ' ') . ' ' . $unit
                : 'dans ' . number_format($reste, 0, ',', ' ') . ' ' . $unit);
            $alerts[] = $this->engAlert(
                $reste <= 0 ? 'danger' : 'warning',
                'fas fa-tachometer-alt',
                'Échéance au compteur',
                $r,
                $text,
                null,
                $reste <= 0 ? -1 : 3,
                'compteur'
            );
        }

        // 4. Documents expirés / à renouveler (dernier document de chaque type)
        $rows = $this->db->query(
            "SELECT d.engin_id, d.type_document, d.date_expiration, m.code_engin, m.designation
               FROM tbl_engin_document d JOIN tbl_engin_materiel m ON m.id = d.engin_id
              WHERE m.status = 1 AND m.etat <> 'Réformé'
                AND d.date_expiration IS NOT NULL
                AND d.date_expiration <= DATE_ADD(CURDATE(), INTERVAL $days DAY)
                AND NOT EXISTS (SELECT 1 FROM tbl_engin_document d2
                                 WHERE d2.engin_id = d.engin_id AND d2.type_document = d.type_document
                                   AND d2.date_expiration > d.date_expiration)"
        )->result();
        foreach ($rows as $r) {
            $d = $this->engDaysUntil($r->date_expiration);
            $alerts[] = $this->engAlert(
                $this->engLevelFromDays($d),
                'fas fa-file-contract',
                $d < 0 ? 'Document expiré' : 'Document à renouveler',
                $r,
                $r->type_document,
                $r->date_expiration,
                $d,
                'document'
            );
        }

        // 5. Pannes ouvertes
        foreach ($this->getOpenPannes(20) as $p) {
            $text = $p->gravite . ' — ' . mb_strimwidth((string) $p->description, 0, 70, '…');
            $alerts[] = $this->engAlert(
                $p->gravite === 'Mineure' ? 'warning' : 'danger',
                'fas fa-car-crash',
                'Panne ' . mb_strtolower($p->panne_status),
                $p,
                $text,
                substr($p->date_signalement, 0, 10),
                0,
                'panne'
            );
        }

        // 6. Consommations anormales (90 derniers jours, > 20 % au-dessus de la norme)
        $conso = $this->getConsumption(date('Y-m-d', strtotime('-90 days')), date('Y-m-d'));
        foreach ($conso as $c) {
            if ($c->ecart !== null && $c->ecart > 20) {
                $text = number_format($c->conso, 1, ',', ' ') . ' ' . $c->unite
                    . ' (norme ' . number_format($c->reference, 1, ',', ' ') . ', +'
                    . number_format($c->ecart, 0) . ' %)';
                $alerts[] = $this->engAlert('warning', 'fas fa-gas-pump', 'Consommation anormale', $c, $text, null, 5, 'conso');
            }
        }

        $rank = ['danger' => 0, 'warning' => 1, 'info' => 2];
        usort($alerts, function ($a, $b) use ($rank) {
            if ($rank[$a->level] !== $rank[$b->level]) {
                return $rank[$a->level] - $rank[$b->level];
            }
            return (int) $a->days - (int) $b->days;
        });

        return $alerts;
    }

    /* =====================================================================
     |  HISTORIQUE UNIFIÉ (carburant + maintenances + pannes)
     * ===================================================================== */

    public function getOperations(array $f = [], $limit = 50)
    {
        $ch  = self::T_CHANTIER;
        $sql = "SELECT * FROM (
                SELECT 'fuel' AS source, f.id AS operation_id, f.reference, f.operation_date,
                       f.engin_id, f.chantier_id, m.code_engin, m.designation, m.plaque,
                       ch.name AS chantier_name,
                       'Ravitaillement' AS operation_name,
                       CONCAT(f.quantity_litre, ' L · ', f.type_carburant) AS operation_type,
                       f.total_amount AS amount, f.operator_name AS responsible,
                       'Validé' AS operation_status, 0 AS documents_count, f.created_at
                  FROM tbl_engin_fuel f
                  JOIN tbl_engin_materiel m ON m.id = f.engin_id
                  LEFT JOIN $ch ch ON ch.id = f.chantier_id
                 WHERE f.status = 1
                UNION ALL
                SELECT 'maintenance', x.id, x.reference, COALESCE(x.end_date, x.start_date, x.planned_date),
                       x.engin_id, x.chantier_id, m.code_engin, m.designation, m.plaque,
                       ch.name,
                       x.intervention, x.maintenance_type,
                       x.total_cost, COALESCE(x.technician, x.supplier),
                       x.maintenance_status,
                       (SELECT COUNT(*) FROM tbl_engin_maintenance_document d WHERE d.maintenance_id = x.id),
                       x.created_at
                  FROM tbl_engin_maintenance x
                  JOIN tbl_engin_materiel m ON m.id = x.engin_id
                  LEFT JOIN $ch ch ON ch.id = x.chantier_id
                 WHERE x.record_status = 1
                UNION ALL
                SELECT 'panne', p.id, p.reference, DATE(p.date_signalement),
                       p.engin_id, p.chantier_id, m.code_engin, m.designation, m.plaque,
                       ch.name,
                       CONCAT('Panne ', LOWER(p.gravite)), LEFT(p.description, 80),
                       0, p.signale_par,
                       p.panne_status, 0, p.created_at
                  FROM tbl_engin_panne p
                  JOIN tbl_engin_materiel m ON m.id = p.engin_id
                  LEFT JOIN $ch ch ON ch.id = p.chantier_id
                 WHERE p.status = 1
            ) t WHERE 1 = 1";

        $p = [];
        if (!empty($f['type'])) {
            $sql .= ' AND t.source = ?';
            $p[] = $f['type'];
        }
        if (!empty($f['engin_id'])) {
            $sql .= ' AND t.engin_id = ?';
            $p[] = (int) $f['engin_id'];
        }
        if (!empty($f['chantier_id'])) {
            $sql .= ' AND t.chantier_id = ?';
            $p[] = (int) $f['chantier_id'];
        }
        if (!empty($f['status'])) {
            $sql .= ' AND t.operation_status = ?';
            $p[] = $f['status'];
        }
        if (!empty($f['date_debut'])) {
            $sql .= ' AND t.operation_date >= ?';
            $p[] = $f['date_debut'];
        }
        if (!empty($f['date_fin'])) {
            $sql .= ' AND t.operation_date <= ?';
            $p[] = $f['date_fin'];
        }
        if (!empty($f['q'])) {
            $like = '%' . $this->db->escape_like_str($f['q']) . '%';
            $sql .= ' AND (t.reference LIKE ? OR t.code_engin LIKE ? OR t.designation LIKE ? OR t.plaque LIKE ?)';
            array_push($p, $like, $like, $like, $like);
        }
        $sql .= ' ORDER BY t.operation_date DESC, t.created_at DESC';
        if ($limit) {
            $sql .= ' LIMIT ' . (int) $limit;
        }

        return $this->db->query($sql, $p)->result();
    }

    /* =====================================================================
     |  DOSSIER / RAPPORT D'UN ENGIN
     * ===================================================================== */

    public function getEnginDossier($id, $du, $au)
    {
        $engin = $this->getEngin($id);
        if (!$engin) {
            return null;
        }
        $id = (int) $engin->id;

        $fuel = $this->db->query(
            'SELECT COALESCE(SUM(quantity_litre), 0) AS litres, COALESCE(SUM(total_amount), 0) AS montant, COUNT(*) AS nb
               FROM tbl_engin_fuel WHERE engin_id = ? AND status = 1 AND operation_date BETWEEN ? AND ?',
            [$id, $du, $au]
        )->row();

        $maint = $this->db->query(
            "SELECT COALESCE(SUM(total_cost), 0) AS cout, COUNT(*) AS nb,
                    COALESCE(SUM(maintenance_type = 'Préventive'), 0) AS preventives,
                    COALESCE(SUM(maintenance_type = 'Corrective'), 0) AS correctives
               FROM tbl_engin_maintenance
              WHERE engin_id = ? AND record_status = 1 AND maintenance_status IN ('En cours', 'Terminé')
                AND COALESCE(end_date, start_date, planned_date) BETWEEN ? AND ?",
            [$id, $du, $au]
        )->row();

        // Jours d'immobilisation (maintenances + pannes sans maintenance), bornés à la période
        $jMaint = (int) $this->db->query(
            "SELECT COALESCE(SUM(GREATEST(0, DATEDIFF(LEAST(COALESCE(end_date, CURDATE()), ?), GREATEST(start_date, ?)) + 1)), 0) AS j
               FROM tbl_engin_maintenance
              WHERE engin_id = ? AND record_status = 1 AND immobilise = 1
                AND maintenance_status IN ('En cours', 'Terminé') AND start_date IS NOT NULL
                AND start_date <= ? AND COALESCE(end_date, CURDATE()) >= ?",
            [$au, $du, $id, $au, $du]
        )->row()->j;
        $jPanne = (int) $this->db->query(
            "SELECT COALESCE(SUM(GREATEST(0, DATEDIFF(LEAST(COALESCE(DATE(date_resolution), CURDATE()), ?),
                                                      GREATEST(DATE(date_signalement), ?)) + 1)), 0) AS j
               FROM tbl_engin_panne
              WHERE engin_id = ? AND status = 1 AND immobilise = 1 AND maintenance_id IS NULL
                AND panne_status <> 'Annulée'
                AND DATE(date_signalement) <= ? AND COALESCE(DATE(date_resolution), CURDATE()) >= ?",
            [$au, $du, $id, $au, $du]
        )->row()->j;

        $joursPeriode = max(1, (int) ((strtotime($au) - strtotime($du)) / 86400) + 1);
        $joursImmo    = min($joursPeriode, $jMaint + $jPanne);

        $consoAll = $this->getConsumption($du, $au, $id);
        $conso    = isset($consoAll[$id]) ? $consoAll[$id] : null;
        $distance = ($conso && $conso->compteur_max !== null) ? $conso->compteur_max - $conso->compteur_min : 0;

        $coutTotal = (float) $fuel->montant + (float) $maint->cout;

        $pannes = $this->db->select('p.*')
            ->from('tbl_engin_panne p')
            ->where(['p.engin_id' => $id, 'p.status' => 1])
            ->where('DATE(p.date_signalement) >=', $du)
            ->where('DATE(p.date_signalement) <=', $au)
            ->order_by('p.date_signalement', 'DESC')->get()->result();

        // Amortissement linéaire
        $amort = null;
        $debut = $engin->date_mise_service ?: $engin->date_acquisition;
        if ((float) $engin->valeur_achat > 0 && (int) $engin->duree_amortissement_mois > 0 && $debut) {
            $diff  = (new DateTime($debut))->diff(new DateTime('today'));
            $mois  = $diff->invert ? 0 : $diff->y * 12 + $diff->m;
            $base  = max(0, (float) $engin->valeur_achat - (float) $engin->valeur_residuelle);
            $dot   = $base / (int) $engin->duree_amortissement_mois;
            $cumul = min($base, $dot * $mois);
            $amort = (object) [
                'debut'              => $debut,
                'mois_ecoules'       => $mois,
                'dotation_mensuelle' => $dot,
                'cumul'              => $cumul,
                'vnc'                => (float) $engin->valeur_achat - $cumul,
                'taux'               => min(100, $mois / (int) $engin->duree_amortissement_mois * 100),
            ];
        }

        $filters = ['engin_id' => $id, 'date_debut' => $du, 'date_fin' => $au];

        return [
            'engin'          => $engin,
            'du'             => $du,
            'au'             => $au,
            'fuel'           => $fuel,
            'maint'          => $maint,
            'conso'          => $conso,
            'distance'       => $distance,
            'coutTotal'      => $coutTotal,
            'coutUnitaire'   => $distance > 0 ? $coutTotal / $distance : null,
            'joursPeriode'   => $joursPeriode,
            'joursImmo'      => $joursImmo,
            'disponibilite'  => max(0, 100 - $joursImmo / $joursPeriode * 100),
            'fuels'          => $this->getFuels($filters, 100),
            'maintenances'   => $this->getMaintenances($filters, 100),
            'pannes'         => $pannes,
            'affectations'   => $this->getAffectations($id, 10),
            'documents'      => $this->getDocuments($id),
            'amort'          => $amort,
            'monthly'        => $this->getMonthlyCosts(6, $id),
        ];
    }


    public function getLastPaymentVoucher()
    {
        return $this->db
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('purchase_payment_vouchers')
            ->row();
    }

    public function getPaymentVoucherByRequestId($requestId)
    {
        return $this->db
            ->where('request_id', (int) $requestId)
            ->order_by('id', 'DESC')
            ->get('purchase_payment_vouchers')
            ->row();
    }


    public function getPaymentVoucherById($id)
    {
        return $this->db
            ->select('
            ppv.*,
            prf.created_at AS request_created_at
        ')
            ->from('purchase_payment_vouchers ppv')
            ->join(
                'purchase_request_forms prf',
                'prf.id = ppv.request_id',
                'left'
            )
            ->where('ppv.id', (int) $id)
            ->get()
            ->row();
    }

    public function updatePaymentVoucher($id, array $data)
    {
        return $this->db
            ->where('id', (int) $id)
            ->update(
                'purchase_payment_vouchers',
                $data
            );
    }



    // ---------- Génération de la référence JP-AAAA-### ----------
    public function getNextJournalReference()
    {
        $row = $this->db->select_max('id')->get('tbl_journal_production')->row();
        $next = (!empty($row->id) ? (int) $row->id : 0) + 1;
        return 'JP-' . date('Y') . '-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    // ---------- Insertion journal + engins (transaction) ----------
    public function createJournalProduction($data, $enginRows)
    {
        $this->db->trans_start();

        $this->db->insert('tbl_journal_production', $data);
        $journal_id = $this->db->insert_id();

        foreach ($enginRows as $row) {
            $row['journal_production_id'] = $journal_id;
            $row['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_journal_production_engins', $row);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $journal_id : false;
    }

    // ---------- Liste des journaux (pour le tableau) ----------
    // public function getJournalProduction()
    // {
    //     $this->db->select('jp.*, c.name AS chantier_name,
    //     (SELECT COUNT(*) FROM tbl_journal_production_engins e
    //      WHERE e.journal_production_id = jp.id) AS nb_engins,
    //     (SELECT IFNULL(SUM(e.heures_utilisation), 0) FROM tbl_journal_production_engins e
    //      WHERE e.journal_production_id = jp.id) AS total_heures_engins');
    //     $this->db->from('tbl_journal_production jp');
    //     $this->db->join('chantiers c', 'c.id = jp.chantier_id', 'left');
    //     $this->db->order_by('jp.journal_date', 'DESC');
    //     $this->db->order_by('jp.id', 'DESC');
    //     return $this->db->get()->result();
    // }

    // // ---------- Engins d'un journal (pour le détail / modification) ----------
    // public function getJournalProductionEngins($journal_id)
    // {
    //     return $this->db->get_where('tbl_journal_production_engins', [
    //         'journal_production_id' => $journal_id
    //     ])->result();
    // }

    // ---------- Un journal + nom du chantier ----------
    public function getJournalProductionById($id)
    {
        $this->db->select('jp.*, c.name AS chantier_name');
        $this->db->from('tbl_journal_production jp');
        $this->db->join('chantiers c', 'c.id = jp.chantier_id', 'left');
        $this->db->where('jp.id', $id);
        return $this->db->get()->row();
    }

    // ---------- Engins du journal (avec désignation) ----------
    public function getJournalProductionEngins($journal_id)
    {
        $this->db->select('e.*, eng.designation AS engin_name');
        $this->db->from('tbl_journal_production_engins e');
        $this->db->join('tbl_engin_materiel eng', 'eng.id = e.engin_id', 'left');
        $this->db->where('e.journal_production_id', $journal_id);
        return $this->db->get()->result();
    }

    // ---------- Mise à jour journal + remplacement des engins ----------
    public function updateJournalProduction($id, $data, $enginRows)
    {
        $this->db->trans_start();

        // 1) Entête du journal
        $this->db->where('id', $id);
        $this->db->update('tbl_journal_production', $data);

        // 2) On remplace les lignes d'engins
        $this->db->where('journal_production_id', $id);
        $this->db->delete('tbl_journal_production_engins');

        foreach ($enginRows as $row) {
            $row['journal_production_id'] = $id;
            $row['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_journal_production_engins', $row);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // ---------- Suppression journal + ses engins ----------
    public function deleteJournalProduction($id)
    {
        $this->db->trans_start();

        // 1) Les lignes d'engins d'abord
        $this->db->where('journal_production_id', $id);
        $this->db->delete('tbl_journal_production_engins');

        // 2) Puis le journal lui-même
        $this->db->where('id', $id);
        $this->db->delete('tbl_journal_production');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // ---------- Nombre de journaux du mois en cours ----------
    public function countJournalProductionMois()
    {
        return $this->db
            ->where('YEAR(journal_date)', date('Y'))
            ->where('MONTH(journal_date)', date('n'))
            ->count_all_results('tbl_journal_production');
    }

    // ---------- Nombre de journaux selon le statut ----------
    public function countJournalProductionByStatut($statut)
    {
        return $this->db
            ->where('statut', $statut)
            ->count_all_results('tbl_journal_production');
    }

    // ---------- Total des heures d'engins (toutes lignes confondues) ----------
    public function sumHeuresEngins()
    {
        $this->db->select('IFNULL(SUM(heures_utilisation), 0) AS total');
        $row = $this->db->get('tbl_journal_production_engins')->row();
        return $row->total;
    }

    public function getJournalProduction($filters = [])
    {
        $this->db->select('jp.*, c.name AS chantier_name,
        (SELECT COUNT(*) FROM tbl_journal_production_engins e
         WHERE e.journal_production_id = jp.id) AS nb_engins,
        (SELECT IFNULL(SUM(e.heures_utilisation), 0) FROM tbl_journal_production_engins e
         WHERE e.journal_production_id = jp.id) AS total_heures_engins');
        $this->db->from('tbl_journal_production jp');
        $this->db->join('chantiers c', 'c.id = jp.chantier_id', 'left');

        // ----- Filtres -----
        if (!empty($filters['date_debut'])) {
            $this->db->where('jp.journal_date >=', $filters['date_debut']);
        }

        if (!empty($filters['date_fin'])) {
            $this->db->where('jp.journal_date <=', $filters['date_fin']);
        }

        if (!empty($filters['chantier'])) {
            $this->db->where('jp.chantier_id', $filters['chantier']);
        }

        if (!empty($filters['statut'])) {
            $this->db->where('jp.statut', $filters['statut']);
        }

        $this->db->order_by('jp.journal_date', 'DESC');
        $this->db->order_by('jp.id', 'DESC');
        return $this->db->get()->result();
    }

    public function update($id, $data)
    {
        $this->db->where('employe_id', (int) $id);
        return $this->db->update($this->table, $data);
    }

    // =====================================================
    // SUIVIE PAIE CHANTIER (table : workforce_contracts)
    // Semaines déterminées par created_at
    // =====================================================

    private function _selectWeeks()
    {
        $this->db->select("YEARWEEK(created_at, 3) AS yw,
                       MIN(start_date)  AS week_start,
                       MAX(end_date)    AS week_end,
                       MIN(created_at)  AS first_date");
    }

    // ---------- Semaines du mois en cours (par défaut) ----------
    public function getPaieWeeksOfMonth($year, $month)
    {
        $this->_selectWeeks();
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        $this->db->group_by('yw');
        $this->db->order_by('first_date', 'DESC');
        return $this->db->get('workforce_contracts')->result();
    }

    // ---------- Une semaine précise (quand on filtre) ----------
    public function getPaieWeekByYw($yw)
    {
        $this->_selectWeeks();
        // CORRECTION : condition complète + (int) + false (pas d'échappement auto)
        $this->db->where('YEARWEEK(created_at, 3) = ' . (int) $yw, null, false);
        $this->db->group_by('yw');
        return $this->db->get('workforce_contracts')->result();
    }

    // ---------- Toutes les semaines (select du filtre) ----------
    public function getAllPaieWeeks($limit = 24)
    {
        $this->_selectWeeks();
        $this->db->group_by('yw');
        $this->db->order_by('first_date', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('workforce_contracts')->result();
    }

    // ---------- Contrats d'une semaine (avec nom du chantier) ----------
    public function getPaieContracts($yw, $chantier_id = null)
    {
        $this->db->select('wc.*, c.name AS chantier_name');
        $this->db->from('workforce_contracts wc');
        $this->db->join('chantiers c', 'c.id = wc.chantier_id', 'left');

        // CORRECTION : condition complète + (int) + false
        $this->db->where('YEARWEEK(wc.created_at, 3) = ' . (int) $yw, null, false);

        if (!empty($chantier_id)) {
            $this->db->where('wc.chantier_id', (int) $chantier_id);
        }

        $this->db->order_by('wc.chantier_id', 'ASC');
        $this->db->order_by('wc.worker_name', 'ASC');
        return $this->db->get()->result();
    }

    // ---------- Statistiques des tuiles ----------
    public function sumPaieAll()
    {
        $this->db->select('IFNULL(SUM(unit_rate), 0) AS total');
        return $this->db->get('workforce_contracts')->row()->total;
    }

    public function sumPaieMonth($year, $month)
    {
        $this->db->select('IFNULL(SUM(unit_rate), 0) AS total');
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        return $this->db->get('workforce_contracts')->row()->total;
    }

    public function countPaieEnAttente($year = null, $month = null)
    {
        $this->db->where('(approved_by_dt = 0 OR approved_by_daf = 0)', null, false);

        if ($year && $month) {
            $this->db->where('YEAR(created_at)', $year);
            $this->db->where('MONTH(created_at)', $month);
        }

        return $this->db->count_all_results('workforce_contracts');
    }

    public function countChantiersPaieMonth($year, $month)
    {
        $this->db->select('COUNT(DISTINCT chantier_id) AS nb');
        $this->db->where('YEAR(created_at)', $year);
        $this->db->where('MONTH(created_at)', $month);
        return $this->db->get('workforce_contracts')->row()->nb;
    }

    /* =========================================================
     *  BONS DE LIVRAISON
     * ========================================================= */

    // DA ayant au moins un bon de paiement effectué et pas encore entièrement livrées
    public function get_paid_requests_for_delivery($company_id = null)
    {
        $this->db->select("prf.id, prf.destination_chantier, prf.requested_by, prf.total_amount,
            prf.request_date, prf.delivery_status,
            MAX(ppv.payment_date) AS last_payment_date,
            GROUP_CONCAT(DISTINCT ppv.payment_number ORDER BY ppv.id SEPARATOR ', ') AS payment_numbers,
            SUM(ppv.amount_paid) AS total_paid", false);
        $this->db->from('purchase_request_forms prf');
        $this->db->join(
            'purchase_payment_vouchers ppv',
            "ppv.request_id = prf.id AND ppv.payment_status = 'effectue'",
            'inner',
            false
        );
        $this->db->where('prf.delivery_status !=', 'livre');
        if (!empty($company_id)) {
            $this->db->where('prf.company_id', $company_id);
        }
        $this->db->group_by('prf.id');
        $this->db->order_by('last_payment_date', 'DESC');
        $this->db->order_by('prf.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_purchase_request($request_id)
    {
        return $this->db->get_where('purchase_request_forms', ['id' => (int) $request_id])->row();
    }

    public function is_request_paid($request_id)
    {
        return $this->db->where('request_id', (int) $request_id)
            ->where('payment_status', 'effectue')
            ->count_all_results('purchase_payment_vouchers') > 0;
    }

    public function get_last_effective_voucher_id($request_id)
    {
        $row = $this->db->select('id')
            ->where('request_id', (int) $request_id)
            ->where('payment_status', 'effectue')
            ->order_by('payment_date', 'DESC')->order_by('id', 'DESC')
            ->limit(1)->get('purchase_payment_vouchers')->row();
        return $row ? (int) $row->id : null;
    }

    // Lignes de la DA avec la quantité déjà reçue sur les BL précédents
    public function get_request_items_for_delivery($request_id)
    {
        $sql = "SELECT pri.id, pri.designation, pri.quantity, pri.unit_price,
                       COALESCE(SUM(dni.quantity_received), 0) AS qty_received
                FROM purchase_request_items pri
                LEFT JOIN delivery_note_items dni ON dni.request_item_id = pri.id
                WHERE pri.request_id = ?
                GROUP BY pri.id, pri.designation, pri.quantity, pri.unit_price
                ORDER BY pri.id ASC";
        return $this->db->query($sql, [(int) $request_id])->result();
    }

    private function generate_delivery_number()
    {
        $year = date('Y');
        $row = $this->db->select('delivery_number')
            ->like('delivery_number', 'BL-' . $year . '-', 'after')
            ->order_by('id', 'DESC')->limit(1)
            ->get('delivery_notes')->row();
        $next = $row ? ((int) substr($row->delivery_number, -6)) + 1 : 1;
        return sprintf('BL-%s-%06d', $year, $next);
    }

    public function create_delivery_note(array $note, array $lines)
    {
        $this->db->trans_start();

        $note['delivery_number'] = $this->generate_delivery_number();
        $this->db->insert('delivery_notes', $note);
        $note_id = $this->db->insert_id();

        foreach ($lines as $line) {
            $line['delivery_note_id'] = $note_id;
            $this->db->insert('delivery_note_items', $line);
        }

        $this->refresh_request_delivery_status($note['request_id']);

        $this->db->trans_complete();

        return $this->db->trans_status()
            ? ['id' => $note_id, 'number' => $note['delivery_number']]
            : false;
    }

    private function refresh_request_delivery_status($request_id)
    {
        $items = $this->get_request_items_for_delivery($request_id);
        $any = false;
        $all = !empty($items);

        foreach ($items as $it) {
            if ((float) $it->qty_received > 0) $any = true;
            if ((float) $it->qty_received + 0.0001 < (float) $it->quantity) $all = false;
        }

        $status = ($all && $any) ? 'livre' : ($any ? 'partiel' : 'non_livre');
        $this->db->where('id', (int) $request_id)
            ->update('purchase_request_forms', ['delivery_status' => $status]);
    }

    /* ---------- Liste des bons de livraison ---------- */

    private function _dn_base_query(array $f)
    {
        $this->db->from('delivery_notes dn');
        $this->db->join('purchase_request_forms prf', 'prf.id = dn.request_id', 'left');
        $this->db->join('purchase_payment_vouchers ppv', 'ppv.id = dn.payment_voucher_id', 'left');

        if (!empty($f['company_id'])) $this->db->where('dn.company_id', $f['company_id']);
        if (!empty($f['date_from']))  $this->db->where('dn.delivery_date >=', $f['date_from']);
        if (!empty($f['date_to']))    $this->db->where('dn.delivery_date <=', $f['date_to']);

        if (!empty($f['q'])) {
            $q = $f['q'];
            $this->db->group_start()
                ->like('dn.delivery_number', $q)
                ->or_like('dn.supplier_bl_reference', $q)
                ->or_like('dn.received_by', $q)
                ->or_like('prf.destination_chantier', $q)
                ->or_like('prf.requested_by', $q)
                ->or_like('ppv.payment_number', $q)
                ->or_like("CONCAT('DA-', prf.id)", $this->db->escape_like_str($q), 'both', false)
                ->group_end();
        }
    }

    public function count_delivery_notes(array $f)
    {
        $this->_dn_base_query($f);
        return $this->db->count_all_results();
    }

    public function get_delivery_notes(array $f, $limit, $offset)
    {
        $this->db->select("dn.*, prf.destination_chantier, prf.requested_by, prf.delivery_status,
            ppv.payment_number,
            (SELECT COUNT(*) FROM delivery_note_items dni WHERE dni.delivery_note_id = dn.id) AS nb_lines", false);
        $this->_dn_base_query($f);
        $this->db->order_by('dn.delivery_date', 'DESC');
        $this->db->order_by('dn.id', 'DESC');
        $this->db->limit((int) $limit, (int) $offset);
        return $this->db->get()->result();
    }

    public function get_delivery_note($id)
    {
        $this->db->select('dn.*, prf.destination_chantier, prf.requested_by, prf.request_date,
            prf.total_amount, prf.delivery_status,
            ppv.payment_number, ppv.amount_paid, ppv.payment_date, ppv.payment_mode');
        $this->db->from('delivery_notes dn');
        $this->db->join('purchase_request_forms prf', 'prf.id = dn.request_id', 'left');
        $this->db->join('purchase_payment_vouchers ppv', 'ppv.id = dn.payment_voucher_id', 'left');
        $this->db->where('dn.id', (int) $id);
        return $this->db->get()->row();
    }

    public function get_delivery_note_items($note_id)
    {
        return $this->db->where('delivery_note_id', (int) $note_id)
            ->order_by('id', 'ASC')
            ->get('delivery_note_items')->result();
    }

    public function get_delivery_stats($company_id = null)
    {
        $stats = [];

        // BL du mois
        $this->db->where('delivery_date >=', date('Y-m-01'));
        if ($company_id) $this->db->where('company_id', $company_id);
        $stats['bl_month'] = $this->db->count_all_results('delivery_notes');

        // DA livrées / partielles
        foreach (['livre' => 'da_livre', 'partiel' => 'da_partiel'] as $status => $key) {
            $this->db->where('delivery_status', $status);
            if ($company_id) $this->db->where('company_id', $company_id);
            $stats[$key] = $this->db->count_all_results('purchase_request_forms');
        }

        // DA payées non livrées
        $sql = "SELECT COUNT(DISTINCT prf.id) AS c
                FROM purchase_request_forms prf
                JOIN purchase_payment_vouchers ppv
                  ON ppv.request_id = prf.id AND ppv.payment_status = 'effectue'
                WHERE prf.delivery_status = 'non_livre'";
        $params = [];
        if ($company_id) {
            $sql .= " AND prf.company_id = ?";
            $params[] = $company_id;
        }
        $stats['da_non_livre'] = (int) $this->db->query($sql, $params)->row()->c;

        return $stats;
    }
}
