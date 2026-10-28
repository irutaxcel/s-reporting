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
        /*
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
        //     *   14 = ASSISTANT_ADMIN
        //     * Tous les autres rôles ne voient que leurs propres demandes.
        //     * ============================================================
        //     */
        $rolesSeeAll = [1, 2, 3, 4, 7, 14, 24, 30];
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

        // ============================================================
    // COÛT RÉEL & RENTABILITÉ (Direction Technique)
    // Sans modification de schéma : les postes sont déduits de la
    // désignation des lignes de DA, montant payé réparti au prorata.
    // ============================================================

    /** Mots-clés (désignation de ligne de DA) => poste "Engins & carburant" */
    private $crMotsEngins = [
        'gasoil',
        'gazoil',
        'gas-oil',
        'gas oil',
        'carburant',
        'essence',
        'diesel',
        'mazout',
        'lubrifiant',
        'huile',
        'graisse',
        'vidange',
        'pneu',
        'chambre a air',
        'batterie',
        'filtre a',
        'filtre gasoil',
        'filtre huile',
        'engin',
        'camion',
        'tracteur',
        'bulldozer',
        'niveleuse',
        'pelleteuse',
        'pelle hydraulique',
        'chargeuse',
        'compacteur',
        'rouleau compresseur',
        'grue',
        'benne',
        'location machine',
        'location de machine',
    ];

    /** Mots-clés => poste "Sous-traitance" (les noms des sous-traitants sont ajoutés automatiquement) */
    private $crMotsSousTraitance = [
        'sous-trait',
        'sous trait',
        'soustrait',
        'prestation',
        'tacheron',
        'tâcheron',
        "main d'oeuvre",
        "main d'œuvre",
        'main d oeuvre',
        "main-d'oeuvre",
        'main d’oeuvre',
    ];

    /** category_type des DA qui ne sont PAS des coûts de chantier */
    private $crCategoriesExclues = ['fonctionnement'];

    /** status_label des contrats main-d'œuvre exclus du coût (minuscules) */
    private $crContratsExclus = ['annule', 'annulé', 'resilie', 'résilié', 'rejete', 'rejeté'];

    /** % de budget consommé à partir duquel un chantier passe "À surveiller" */
    private $crSeuilSurveillance = 90;

    /** Points d'écart tolérés entre % budget consommé et % temps écoulé */
    private $crToleranceAvancement = 15;

    private $crMotsStCache = null;

    private function crInList(array $values)
    {
        return implode(',', array_map([$this->db, 'escape'], $values));
    }

    /** ( col LIKE '%mot1%' OR col LIKE '%mot2%' ... ) — insensible casse/accents en *_general_ci
     *  Les apostrophes sont doublées ('') et non échappées par \' : sinon CodeIgniter
     *  se trompe en repérant les chaînes et casse le remplacement des « ? » de la requête. */
    private function crLikeAny($col, array $mots)
    {
        $parts = [];
        foreach ($mots as $m) {
            $m = trim((string) $m);
            if ($m === '') {
                continue;
            }
            $motif   = '%' . $this->db->escape_like_str($m) . '%';
            $motif   = str_replace(['\\', "'"], ['\\\\', "''"], $motif);
            $parts[] = $col . " LIKE '" . $motif . "' ESCAPE '!'";
        }
        return $parts ? '(' . implode(' OR ', $parts) . ')' : '(0)';
    }

    /** Mots sous-traitance + noms des sous-traitants enregistrés */
    private function crMotsSousTraitanceComplets($companyId = 0)
    {
        if ($this->crMotsStCache !== null) {
            return $this->crMotsStCache;
        }
        $this->db->select('name')->from('subcontractors');
        if ($companyId > 0) {
            $this->db->where('company_id', $companyId);
        }
        $noms = [];
        foreach ($this->db->get()->result_array() as $s) {
            $nom = trim((string) $s['name']);
            if (mb_strlen($nom, 'UTF-8') >= 4) {   // évite les noms trop courts qui matcheraient tout
                $noms[] = $nom;
            }
        }
        return $this->crMotsStCache = array_merge($this->crMotsSousTraitance, $noms);
    }

    /** Sous-requête : par DA, montant total des lignes et part engins / sous-traitance */
    private function crSqlVentilation($companyId = 0)
    {
        $eng = $this->crLikeAny('i.designation', $this->crMotsEngins);
        $st  = $this->crLikeAny('i.designation', $this->crMotsSousTraitanceComplets($companyId));

        return "SELECT i.request_id,
                    SUM(i.total_price) AS total_items,
                    SUM(CASE WHEN $eng THEN i.total_price ELSE 0 END) AS items_engins,
                    SUM(CASE WHEN NOT $eng AND $st THEN i.total_price ELSE 0 END) AS items_st
                FROM purchase_request_items i
                GROUP BY i.request_id";
    }

    /** Liste des chantiers pour le filtre */
    public function getChantiersPourFiltreCoutReel($companyId = 0)
    {
        $this->db->select('id, ref_chantier, name')->from('chantiers');
        if ($companyId > 0) {
            $this->db->where('company_id', $companyId);
        }
        return $this->db->order_by('name', 'ASC')->get()->result_array();
    }

    /**
     * Coût réel par chantier et par poste + indicateurs calculés.
     * $filters : company_id, chantier_id, date_debut, date_fin (Y-m-d), statut
     */
    public function getCoutReelRentabilite(array $filters = [])
    {
        $companyId    = (int) ($filters['company_id'] ?? 0);
        $horsChantier = $this->crInList($this->crCategoriesExclues);
        $exclus       = $this->crInList($this->crContratsExclus);
        $ventil       = $this->crSqlVentilation($companyId);
        $binds        = [];

        // 1) Achats payés, répartis par poste au prorata des lignes de la DA
        $sqlAchats = "SELECT f.chantier_id,
                SUM(v.amount_paid * COALESCE(r.items_engins / NULLIF(r.total_items, 0), 0)) AS cout_engins,
                SUM(v.amount_paid * COALESCE(r.items_st     / NULLIF(r.total_items, 0), 0)) AS cout_sous_traitance,
                SUM(v.amount_paid * (1 - COALESCE((r.items_engins + r.items_st) / NULLIF(r.total_items, 0), 0))) AS cout_materiaux
            FROM purchase_payment_vouchers v
            INNER JOIN purchase_request_forms f ON f.id = v.request_id
            LEFT JOIN ($ventil) r ON r.request_id = f.id
            WHERE COALESCE(v.payment_status, 'effectue') = 'effectue'
              AND f.chantier_id > 0
              AND LOWER(f.category_type) NOT IN ($horsChantier)";
        if (!empty($filters['date_debut'])) {
            $sqlAchats .= " AND v.payment_date >= ?";
            $binds[] = $filters['date_debut'];
        }
        if (!empty($filters['date_fin'])) {
            $sqlAchats .= " AND v.payment_date <= ?";
            $binds[] = $filters['date_fin'];
        }
        $sqlAchats .= " GROUP BY f.chantier_id";

        // 2) Main-d'œuvre : montant de paie = unit_rate (comme la page "Suivie Paie Chantier").
        //    contract_amount est toujours enregistré à 0 par storePersonnelChantier().
        $debutMo = "COALESCE(w.start_date, DATE(w.created_at))";
        $finMo   = "COALESCE(w.end_date, w.start_date, DATE(w.created_at))";
        $sqlMo = "SELECT w.chantier_id, SUM(w.unit_rate) AS cout_main_oeuvre
            FROM workforce_contracts w
            WHERE w.chantier_id > 0
              AND LOWER(w.status_label) NOT IN ($exclus)";
        if (!empty($filters['date_fin'])) {
            $sqlMo .= " AND $debutMo <= ?";
            $binds[] = $filters['date_fin'];
        }
        if (!empty($filters['date_debut'])) {
            $sqlMo .= " AND $finMo >= ?";
            $binds[] = $filters['date_debut'];
        }
        $sqlMo .= " GROUP BY w.chantier_id";

        // 3) Requête principale
        $sql = "SELECT c.id, c.ref_chantier, c.name, c.budget, c.date_debut, c.date_fin_prevue, c.status,
                    p.name AS projet_name,
                    COALESCE(a.cout_materiaux, 0)      AS cout_materiaux,
                    COALESCE(m.cout_main_oeuvre, 0)    AS cout_main_oeuvre,
                    COALESCE(a.cout_engins, 0)         AS cout_engins,
                    COALESCE(a.cout_sous_traitance, 0) AS cout_sous_traitance
                FROM chantiers c
                LEFT JOIN projects p ON p.id = c.project_id
                LEFT JOIN ($sqlAchats) a ON a.chantier_id = c.id
                LEFT JOIN ($sqlMo) m     ON m.chantier_id = c.id
                WHERE 1 = 1";
        if ($companyId > 0) {
            $sql .= " AND c.company_id = ?";
            $binds[] = $companyId;
        }
        if (!empty($filters['chantier_id'])) {
            $sql .= " AND c.id = ?";
            $binds[] = (int) $filters['chantier_id'];
        }
        $sql .= " ORDER BY c.name ASC";

        $rows   = $this->db->query($sql, $binds)->result_array();
        $result = [];
        foreach ($rows as $r) {
            $r = $this->crCalculerIndicateurs($r);
            if (!empty($filters['statut']) && $r['statut'] !== $filters['statut']) {
                continue;
            }
            $result[] = $r;
        }
        return $result;
    }

    private function crCalculerIndicateurs(array $r)
    {
        foreach (['budget', 'cout_materiaux', 'cout_main_oeuvre', 'cout_engins', 'cout_sous_traitance'] as $k) {
            $r[$k] = round((float) $r[$k], 2);
        }
        $budget = $r['budget'];
        $cout   = $r['cout_materiaux'] + $r['cout_main_oeuvre'] + $r['cout_engins'] + $r['cout_sous_traitance'];

        $r['cout_total'] = $cout;
        $r['ecart']      = $budget - $cout;
        $r['marge_pct']  = $budget > 0 ? round(($budget - $cout) / $budget * 100, 1) : null;
        $r['conso_pct']  = $budget > 0 ? round($cout / $budget * 100, 1) : null;

        $r['temps_pct'] = null;
        if (!empty($r['date_debut']) && !empty($r['date_fin_prevue'])) {
            $debut = strtotime($r['date_debut']);
            $fin   = strtotime($r['date_fin_prevue']);
            if ($fin > $debut) {
                $pct = (time() - $debut) / ($fin - $debut) * 100;
                $r['temps_pct'] = round(max(0, min(100, $pct)), 1);
            }
        }

        if ($budget <= 0) {
            $r['statut'] = 'sans_budget';
        } elseif ($cout > $budget) {
            $r['statut'] = 'depassement';
        } elseif (
            $r['conso_pct'] >= $this->crSeuilSurveillance
            || ($r['temps_pct'] !== null && $r['temps_pct'] < 100
                && $r['conso_pct'] > $r['temps_pct'] + $this->crToleranceAvancement)
        ) {
            $r['statut'] = 'surveiller';
        } else {
            $r['statut'] = 'rentable';
        }

        $map = [
            'rentable'    => ['Rentable', 'success'],
            'surveiller'  => ['À surveiller', 'warning'],
            'depassement' => ['Dépassement', 'danger'],
            'sans_budget' => ['Sans budget', 'secondary'],
        ];
        $r['statut_label'] = $map[$r['statut']][0];
        $r['statut_class'] = $map[$r['statut']][1];

        return $r;
    }

    /** Totaux pour les tuiles, le pied de tableau et la répartition */
    public function getCoutReelSynthese(array $rows)
    {
        $s = [
            'nb_chantiers' => count($rows),
            'budget' => 0,
            'cout_materiaux' => 0,
            'cout_main_oeuvre' => 0,
            'cout_engins' => 0,
            'cout_sous_traitance' => 0,
            'cout_total' => 0,
            'nb_depassement' => 0,
            'nb_surveiller' => 0,
        ];
        foreach ($rows as $r) {
            foreach (['budget', 'cout_materiaux', 'cout_main_oeuvre', 'cout_engins', 'cout_sous_traitance', 'cout_total'] as $k) {
                $s[$k] += $r[$k];
            }
            if ($r['statut'] === 'depassement') $s['nb_depassement']++;
            if ($r['statut'] === 'surveiller')  $s['nb_surveiller']++;
        }
        $s['ecart']     = $s['budget'] - $s['cout_total'];
        $s['marge_pct'] = $s['budget'] > 0 ? round($s['ecart'] / $s['budget'] * 100, 1) : null;
        return $s;
    }

    /** Détail d'un chantier : indicateurs + paiements ventilés + contrats */
    public function getCoutReelDetailChantier($chantierId, array $filters = [])
    {
        $filters['chantier_id'] = (int) $chantierId;
        $filters['statut']      = '';
        $rows = $this->getCoutReelRentabilite($filters);
        if (empty($rows)) {
            return null;
        }
        $companyId = (int) ($filters['company_id'] ?? 0);

        // Paiements avec leur ventilation par poste
        $ventil = $this->crSqlVentilation($companyId);
        $binds  = [(int) $chantierId];
        $sql = "SELECT v.payment_number, v.payment_date, v.payment_mode, v.amount_paid, v.summary,
                       f.id AS da_id, f.requested_by,
                       COALESCE(r.total_items, 0) AS total_items,
                       COALESCE(r.items_engins, 0) AS items_engins,
                       COALESCE(r.items_st, 0) AS items_st
                FROM purchase_payment_vouchers v
                INNER JOIN purchase_request_forms f ON f.id = v.request_id
                LEFT JOIN ($ventil) r ON r.request_id = f.id
                WHERE f.chantier_id = ?
                  AND COALESCE(v.payment_status, 'effectue') = 'effectue'
                  AND LOWER(f.category_type) NOT IN (" . $this->crInList($this->crCategoriesExclues) . ")";
        if (!empty($filters['date_debut'])) {
            $sql .= " AND v.payment_date >= ?";
            $binds[] = $filters['date_debut'];
        }
        if (!empty($filters['date_fin'])) {
            $sql .= " AND v.payment_date <= ?";
            $binds[] = $filters['date_fin'];
        }
        $sql .= " ORDER BY v.payment_date DESC, v.id DESC";

        $paiements = $this->db->query($sql, $binds)->result_array();
        foreach ($paiements as &$p) {
            $tot = (float) $p['total_items'];
            $re  = $tot > 0 ? (float) $p['items_engins'] / $tot : 0;
            $rs  = $tot > 0 ? (float) $p['items_st'] / $tot : 0;
            $rm  = max(0, 1 - $re - $rs);

            $p['amount_paid'] = (float) $p['amount_paid'];
            $parts = array_filter([
                'Mat.' => $rm,
                'Engins' => $re,
                'S-trait.' => $rs,
            ], function ($x) {
                return $x > 0.0005;
            });

            if (count($parts) <= 1) {
                $cle = key($parts) ?: 'Mat.';
                $p['poste'] = ['Mat.' => 'Matériaux & achats', 'Engins' => 'Engins & carburant', 'S-trait.' => 'Sous-traitance'][$cle];
            } else {
                $txt = [];
                foreach ($parts as $lbl => $x) {
                    $txt[] = $lbl . ' ' . round($x * 100) . ' %';
                }
                $p['poste'] = 'Mixte : ' . implode(' / ', $txt);
            }
            unset($p['total_items'], $p['items_engins'], $p['items_st']);
        }
        unset($p);

        // Contrats main-d'œuvre
        $exclus = $this->crInList($this->crContratsExclus);
        $binds  = [(int) $chantierId];
        $sql = "SELECT worker_name, worker_type, function_name, start_date, end_date,
                       pay_mode, unit_rate, contract_amount, status_label
                FROM workforce_contracts
                WHERE chantier_id = ? AND LOWER(status_label) NOT IN ($exclus)";
        if (!empty($filters['date_fin'])) {
            $sql .= " AND COALESCE(start_date, DATE(created_at)) <= ?";
            $binds[] = $filters['date_fin'];
        }
        if (!empty($filters['date_debut'])) {
            $sql .= " AND COALESCE(end_date, start_date, DATE(created_at)) >= ?";
            $binds[] = $filters['date_debut'];
        }
        $sql .= " ORDER BY start_date DESC, id DESC";
        $contrats = $this->db->query($sql, $binds)->result_array();
        foreach ($contrats as &$c) {
            $c['unit_rate']       = (float) $c['unit_rate'];
            $c['contract_amount'] = (float) $c['unit_rate']; // montant réel = unit_rate (contract_amount toujours à 0)
        }
        unset($c);

        return [
            'chantier'  => $rows[0],
            'paiements' => $paiements,
            'contrats'  => $contrats,
        ];
    }

        // ============================================================
    // ÉVALUATION CHANTIER (Direction Technique)
    // Note de performance calculée à partir des données existantes :
    // budget (coût réel), délais, suivi (journal de production),
    // engins (pannes) et approvisionnement (DA payées livrées).
    // ============================================================

    /** Pondération des critères (total 100) */
    private $evPoids = ['budget' => 30, 'delais' => 25, 'suivi' => 20, 'engins' => 15, 'appro' => 10];

    /** Statuts de chantier considérés comme clôturés (comparaison en minuscules) */
    private $evStatutsClos = [
        'termine',
        'terminé',
        'cloture',
        'clôture',
        'clôturé',
        'clos',
        'acheve',
        'achevé',
        'receptionne',
        'réceptionné',
    ];

    /** Jours sans journal attendu (date('w') : 0 = dimanche … 6 = samedi) */
    private $evJoursNonOuvres = [6];

    /** Retard (jours) à partir duquel la note "Délais" tombe à 0 */
    private $evJoursRetardMax = 60;

    /** Délai (jours) laissé au fournisseur entre paiement et livraison */
    private $evDelaiLivraison = 7;

    /** Période d'analyse par défaut (jours) quand aucune date n'est choisie */
    private $evPeriodeDefaut = 30;

    public function getEvaluationPoids()
    {
        return $this->evPoids;
    }

    /** [du, au] : période choisie, ou les N derniers jours */
    public function getEvaluationPeriode(array $f = [])
    {
        $au = !empty($f['date_fin']) ? $f['date_fin'] : date('Y-m-d');
        $du = !empty($f['date_debut'])
            ? $f['date_debut']
            : date('Y-m-d', strtotime($au . ' -' . ($this->evPeriodeDefaut - 1) . ' days'));
        if ($du > $au) {
            list($du, $au) = [$au, $du];
        }
        return [$du, $au];
    }

    private function evIndex(array $rows, $key = 'chantier_id')
    {
        $out = [];
        foreach ($rows as $r) {
            $out[(int) $r[$key]] = $r;
        }
        return $out;
    }

    private function evClamp($v)
    {
        return round(max(0, min(100, $v)), 1);
    }

    private function evNum($n)
    {
        return number_format((float) $n, 0, ',', ' ');
    }

    /** Nombre de jours ouvrés entre deux dates incluses */
    private function evJoursOuvres($debut, $fin)
    {
        $d = strtotime($debut);
        $f = strtotime($fin);
        if (!$d || !$f || $d > $f) {
            return 0;
        }
        $n = 0;
        for ($t = $d; $t <= $f; $t = strtotime('+1 day', $t)) {
            if (!in_array((int) date('w', $t), $this->evJoursNonOuvres, true)) {
                $n++;
            }
        }
        return $n;
    }

    private function evGrade($note)
    {
        if ($note === null) return ['NE', 'Non évaluable', 'secondary'];
        if ($note >= 85)    return ['A', 'Excellent', 'success'];
        if ($note >= 70)    return ['B', 'Bon', 'info'];
        if ($note >= 50)    return ['C', 'À améliorer', 'warning'];
        return ['D', 'Critique', 'danger'];
    }

    /**
     * Évaluation de chaque chantier.
     * $filters : company_id, chantier_id, date_debut, date_fin, grade (A|B|C|D|NE), q
     */
    public function getEvaluationChantiers(array $filters = [])
    {
        list($du, $au) = $this->getEvaluationPeriode($filters);
        $companyId = (int) ($filters['company_id'] ?? 0);
        $today     = date('Y-m-d');

        // Base : coût réel cumulé depuis le début du chantier (sans filtre de dates)
        $base = $this->getCoutReelRentabilite([
            'company_id'  => $companyId,
            'chantier_id' => (int) ($filters['chantier_id'] ?? 0),
        ]);
        if (empty($base)) {
            return [];
        }
        $in = implode(',', array_map('intval', array_column($base, 'id')));

        $infos = $this->evIndex($this->db->query(
            "SELECT id, chef_chantier, location FROM chantiers WHERE id IN ($in)"
        )->result_array(), 'id');

        // Journal de production sur la période
        $journaux = $this->evIndex($this->db->query(
            "SELECT chantier_id,
                    COUNT(*) AS nb_journaux,
                    COUNT(DISTINCT journal_date) AS nb_jours,
                    COALESCE(SUM(statut = 'valide'), 0) AS nb_valides,
                    COALESCE(SUM(statut = 'en_attente'), 0) AS nb_attente,
                    COALESCE(SUM(heures_travaillees), 0) AS heures,
                    COALESCE(AVG(effectif_interne + effectif_sous_traitant), 0) AS effectif_moyen
               FROM tbl_journal_production
              WHERE chantier_id IN ($in) AND statut <> 'brouillon'
                AND journal_date BETWEEN ? AND ?
              GROUP BY chantier_id",
            [$du, $au]
        )->result_array());

        // Dernier journal (fin réelle approximative d'un chantier clôturé)
        $derniers = $this->evIndex($this->db->query(
            "SELECT chantier_id, MAX(journal_date) AS dernier
               FROM tbl_journal_production
              WHERE chantier_id IN ($in) AND statut <> 'brouillon'
              GROUP BY chantier_id"
        )->result_array());

        // Engins : pannes, carburant, maintenances sur la période
        $open = $this->crInList(self::PANNE_OPEN);
        $pannes = $this->evIndex($this->db->query(
            "SELECT chantier_id, COUNT(*) AS nb_pannes,
                    COALESCE(SUM(gravite = 'Critique'), 0) AS critiques,
                    COALESCE(SUM(gravite = 'Majeure'), 0)  AS majeures,
                    COALESCE(SUM(gravite = 'Mineure'), 0)  AS mineures,
                    COALESCE(SUM(panne_status IN ($open)), 0) AS ouvertes
               FROM tbl_engin_panne
              WHERE status = 1 AND panne_status <> 'Annulée' AND chantier_id IN ($in)
                AND DATE(date_signalement) BETWEEN ? AND ?
              GROUP BY chantier_id",
            [$du, $au]
        )->result_array());

        $fuels = $this->evIndex($this->db->query(
            "SELECT chantier_id, COUNT(*) AS nb_fuel,
                    COALESCE(SUM(total_amount), 0) AS cout_fuel,
                    COALESCE(SUM(quantity_litre), 0) AS litres
               FROM tbl_engin_fuel
              WHERE status = 1 AND chantier_id IN ($in) AND operation_date BETWEEN ? AND ?
              GROUP BY chantier_id",
            [$du, $au]
        )->result_array());

        $maints = $this->evIndex($this->db->query(
            "SELECT chantier_id, COUNT(*) AS nb_maint, COALESCE(SUM(total_cost), 0) AS cout_maint
               FROM tbl_engin_maintenance
              WHERE record_status = 1 AND maintenance_status IN ('En cours', 'Terminé')
                AND chantier_id IN ($in)
                AND COALESCE(end_date, start_date, planned_date) BETWEEN ? AND ?
              GROUP BY chantier_id",
            [$du, $au]
        )->result_array());

        // Approvisionnement : DA payées sur la période (hors délai de livraison toléré)
        $auAppro = min($au, date('Y-m-d', strtotime($today . ' -' . $this->evDelaiLivraison . ' days')));
        $appros  = [];
        if ($du <= $auAppro) {
            $horsChantier = $this->crInList($this->crCategoriesExclues);
            $appros = $this->evIndex($this->db->query(
                "SELECT f.chantier_id, COUNT(*) AS nb_payees,
                        COALESCE(SUM(f.delivery_status = 'livre'), 0)   AS livrees,
                        COALESCE(SUM(f.delivery_status = 'partiel'), 0) AS partielles
                   FROM purchase_request_forms f
                  WHERE f.chantier_id IN ($in)
                    AND LOWER(f.category_type) NOT IN ($horsChantier)
                    AND EXISTS (SELECT 1 FROM purchase_payment_vouchers v
                                 WHERE v.request_id = f.id AND v.payment_status = 'effectue'
                                   AND v.payment_date BETWEEN ? AND ?)
                  GROUP BY f.chantier_id",
                [$du, $auAppro]
            )->result_array());
        }

        $out = [];
        foreach ($base as $c) {
            $id   = (int) $c['id'];
            $jr   = $journaux[$id] ?? [];
            $pn   = $pannes[$id] ?? [];
            $fu   = $fuels[$id] ?? [];
            $mt   = $maints[$id] ?? [];
            $ap   = $appros[$id] ?? [];
            $info = $infos[$id] ?? [];
            $clos = in_array(mb_strtolower(trim((string) $c['status']), 'UTF-8'), $this->evStatutsClos, true);

            $notes   = [];
            $alertes = [];

            // 1. Budget
            if ($c['budget'] > 0) {
                $ref    = $clos ? 100 : ($c['temps_pct'] !== null ? $c['temps_pct'] : 100);
                $derive = $c['conso_pct'] - $ref;
                $notes['budget'] = $this->evClamp(100 - max(0, $derive) * 2);
                if ($c['cout_total'] > $c['budget']) {
                    $alertes[] = ['danger', 'Budget dépassé de ' . $this->evNum($c['cout_total'] - $c['budget']) . ' BIF'];
                } elseif ($derive > $this->crToleranceAvancement) {
                    $alertes[] = ['warning', 'Budget consommé à ' . round($c['conso_pct']) . ' % pour '
                        . round($ref) . ' % du délai écoulé'];
                }
            } else {
                $notes['budget'] = null;
                $alertes[] = ['secondary', 'Aucun budget saisi : critère budget non évalué'];
            }

            // 2. Délais
            $retard = null;
            $joursRestants = null;
            if (!empty($c['date_fin_prevue'])) {
                $finRef = $clos ? ($derniers[$id]['dernier'] ?? null) : $today;
                if ($finRef) {
                    $retard = max(0, (int) floor((strtotime($finRef) - strtotime($c['date_fin_prevue'])) / 86400));
                }
                if (!$clos) {
                    $reste = (int) floor((strtotime($c['date_fin_prevue']) - strtotime($today)) / 86400);
                    $joursRestants = $reste >= 0 ? $reste : null;
                }
            }
            $notes['delais'] = $retard === null ? null : $this->evClamp(100 - $retard * 100 / $this->evJoursRetardMax);
            if ($retard > 0) {
                $alertes[] = [
                    $retard > 30 ? 'danger' : 'warning',
                    ($clos ? 'Terminé avec ' : 'En retard de ') . $retard . ' jour(s) sur la fin prévue'
                ];
            } elseif ($joursRestants !== null && $joursRestants <= 15) {
                $alertes[] = ['info', 'Fin prévue dans ' . $joursRestants . ' jour(s)'];
            }

            // 3. Suivi (régularité du journal de production)
            $attendus   = null;
            $couverture = null;
            if (!$clos) {
                $debut    = max($du, $c['date_debut'] ?: $du);
                $fin      = min($au, $today);
                $attendus = $this->evJoursOuvres($debut, $fin);
                if ($attendus > 0) {
                    $couverture = min(100, round(((int) ($jr['nb_jours'] ?? 0)) / $attendus * 100, 1));
                }
            }
            $notes['suivi'] = $couverture;
            if ($couverture !== null && $couverture < 60) {
                $alertes[] = ['warning', (int) ($jr['nb_jours'] ?? 0) . ' jour(s) de journal pour '
                    . $attendus . ' jours ouvrés sur la période'];
            }
            if ((int) ($jr['nb_attente'] ?? 0) > 0) {
                $alertes[] = ['info', (int) $jr['nb_attente'] . ' journal(aux) en attente de validation'];
            }

            // 4. Engins
            $nbPannes = (int) ($pn['nb_pannes'] ?? 0);
            $ouvertes = (int) ($pn['ouvertes'] ?? 0);
            $activite = $nbPannes + (int) ($fu['nb_fuel'] ?? 0) + (int) ($mt['nb_maint'] ?? 0);
            $notes['engins'] = $activite > 0
                ? $this->evClamp(100 - (int) ($pn['mineures'] ?? 0) * 5 - (int) ($pn['majeures'] ?? 0) * 10
                    - (int) ($pn['critiques'] ?? 0) * 20 - $ouvertes * 5)
                : null;
            if ($ouvertes > 0) {
                $alertes[] = ['danger', $ouvertes . " panne(s) d'engin non résolue(s)"];
            }

            // 5. Approvisionnement
            $nbPayees = (int) ($ap['nb_payees'] ?? 0);
            $livrees  = (int) ($ap['livrees'] ?? 0);
            $partiel  = (int) ($ap['partielles'] ?? 0);
            $notes['appro'] = $nbPayees > 0 ? $this->evClamp(($livrees + 0.5 * $partiel) / $nbPayees * 100) : null;
            if ($nbPayees - $livrees > 0) {
                $alertes[] = ['warning', ($nbPayees - $livrees) . ' DA payée(s) pas entièrement livrée(s)'];
            }

            // Note globale (critères non évalués exclus, poids re-normalisés)
            $somme = 0;
            $poids = 0;
            foreach ($this->evPoids as $k => $w) {
                if ($notes[$k] !== null) {
                    $somme += $notes[$k] * $w;
                    $poids += $w;
                }
            }
            $note  = $poids > 0 ? round($somme / $poids, 1) : null;
            $grade = $this->evGrade($note);

            $row = [
                'id'              => $id,
                'ref_chantier'    => $c['ref_chantier'],
                'name'            => $c['name'],
                'projet_name'     => $c['projet_name'],
                'chef_chantier'   => $info['chef_chantier'] ?? null,
                'location'        => $info['location'] ?? null,
                'status'          => $c['status'],
                'clos'            => $clos,
                'date_debut'      => $c['date_debut'],
                'date_fin_prevue' => $c['date_fin_prevue'],
                'temps_pct'       => $c['temps_pct'],
                'budget'          => $c['budget'],
                'cout_total'      => $c['cout_total'],
                'conso_pct'       => $c['conso_pct'],
                'marge_pct'       => $c['marge_pct'],
                'retard'          => $retard,
                'jours_restants'  => $joursRestants,
                'nb_journaux'     => (int) ($jr['nb_journaux'] ?? 0),
                'nb_jours'        => (int) ($jr['nb_jours'] ?? 0),
                'nb_valides'      => (int) ($jr['nb_valides'] ?? 0),
                'nb_attente'      => (int) ($jr['nb_attente'] ?? 0),
                'heures'          => (float) ($jr['heures'] ?? 0),
                'effectif_moyen'  => round((float) ($jr['effectif_moyen'] ?? 0), 1),
                'attendus'        => $attendus,
                'couverture'      => $couverture,
                'nb_pannes'       => $nbPannes,
                'pannes_ouvertes' => $ouvertes,
                'cout_fuel'       => (float) ($fu['cout_fuel'] ?? 0),
                'litres'          => (float) ($fu['litres'] ?? 0),
                'cout_maint'      => (float) ($mt['cout_maint'] ?? 0),
                'nb_payees'       => $nbPayees,
                'livrees'         => $livrees,
                'partielles'      => $partiel,
                'notes'           => $notes,
                'note'            => $note,
                'grade'           => $grade[0],
                'grade_label'     => $grade[1],
                'grade_class'     => $grade[2],
                'alertes'         => $alertes,
            ];

            // Filtres en PHP (la note est calculée ici)
            if (!empty($filters['grade']) && $row['grade'] !== $filters['grade']) {
                continue;
            }
            if (!empty($filters['q'])) {
                $hay = $row['name'] . ' ' . $row['ref_chantier'] . ' ' . $row['projet_name'] . ' ' . $row['chef_chantier'];
                if (mb_stripos($hay, $filters['q'], 0, 'UTF-8') === false) {
                    continue;
                }
            }
            $out[] = $row;
        }

        // Du plus mauvais au meilleur, les non évaluables à la fin
        usort($out, function ($a, $b) {
            if ($a['note'] === null) return $b['note'] === null ? 0 : 1;
            if ($b['note'] === null) return -1;
            return $a['note'] <=> $b['note'];
        });

        return $out;
    }

    /** Totaux pour les tuiles et la répartition des classes */
    public function getEvaluationSynthese(array $rows)
    {
        $s = [
            'nb' => count($rows),
            'notes' => 0,
            'moyenne' => null,
            'retard' => 0,
            'grades' => ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'NE' => 0]
        ];
        $somme = 0;
        foreach ($rows as $r) {
            $s['grades'][$r['grade']]++;
            if ($r['note'] !== null) {
                $s['notes']++;
                $somme += $r['note'];
            }
            if (!$r['clos'] && $r['retard'] > 0) {
                $s['retard']++;
            }
        }
        $s['moyenne'] = $s['notes'] > 0 ? round($somme / $s['notes'], 1) : null;
        return $s;
    }

    /** Détail d'un chantier : évaluation + journaux, pannes et DA non livrées */
    public function getEvaluationDetail($chantierId, array $filters = [])
    {
        $filters['chantier_id'] = (int) $chantierId;
        $filters['grade'] = '';
        $filters['q']     = '';
        $rows = $this->getEvaluationChantiers($filters);
        if (empty($rows)) {
            return null;
        }
        list($du, $au) = $this->getEvaluationPeriode($filters);
        $id = (int) $chantierId;

        $journaux = $this->db->query(
            "SELECT reference, journal_date, chef_chantier, effectif_interne, effectif_sous_traitant,
                    heures_travaillees, statut
               FROM tbl_journal_production
              WHERE chantier_id = ? AND statut <> 'brouillon' AND journal_date BETWEEN ? AND ?
              ORDER BY journal_date DESC, id DESC LIMIT 15",
            [$id, $du, $au]
        )->result_array();

        $pannes = $this->db->query(
            "SELECT p.reference, DATE(p.date_signalement) AS date_signalement, p.gravite, p.panne_status,
                    p.description, m.code_engin, m.designation
               FROM tbl_engin_panne p
               JOIN tbl_engin_materiel m ON m.id = p.engin_id
              WHERE p.status = 1 AND p.panne_status <> 'Annulée' AND p.chantier_id = ?
                AND DATE(p.date_signalement) BETWEEN ? AND ?
              ORDER BY p.date_signalement DESC LIMIT 15",
            [$id, $du, $au]
        )->result_array();

        $horsChantier = $this->crInList($this->crCategoriesExclues);
        $da = $this->db->query(
            "SELECT f.id, f.requested_by, f.total_amount, f.delivery_status,
                    MAX(v.payment_date) AS payment_date, SUM(v.amount_paid) AS amount_paid
               FROM purchase_request_forms f
               JOIN purchase_payment_vouchers v ON v.request_id = f.id AND v.payment_status = 'effectue'
              WHERE f.chantier_id = ? AND f.delivery_status <> 'livre'
                AND LOWER(f.category_type) NOT IN ($horsChantier)
              GROUP BY f.id, f.requested_by, f.total_amount, f.delivery_status
              ORDER BY payment_date ASC LIMIT 15",
            [$id]
        )->result_array();

        return [
            'evaluation' => $rows[0],
            'periode'    => ['du' => $du, 'au' => $au],
            'poids'      => $this->evPoids,
            'journaux'   => $journaux,
            'pannes'     => $pannes,
            'da'         => $da,
        ];
    }

    // ============================================================
    // POINTAGE (Direction Technique)
    // Table tbl_pointage : une ligne par contrat (travailleur) et par jour.
    // ============================================================

    const POINTAGE_STATUTS = [
        'present'  => 'Présent',
        'demi'     => 'Demi-journée',
        'absent'   => 'Absent',
        'justifie' => 'Absence justifiée',
    ];

    /** Valeur en jours travaillés de chaque statut */
    private $ptValeurs = ['present' => 1, 'demi' => 0.5, 'absent' => 0, 'justifie' => 0];

    /** Semaine de travail : N jours à partir du dimanche (comme Personnel Chantier) */
    private $ptJoursSemaine = 6;

    /** Période d'activité d'un contrat (fin = début + 6 jours si non renseignée) */
    private function ptDebutSql($a = 'w')
    {
        return "COALESCE($a.start_date, DATE($a.created_at))";
    }

    private function ptFinSql($a = 'w')
    {
        return "COALESCE($a.end_date, DATE_ADD(COALESCE($a.start_date, DATE($a.created_at)), INTERVAL 6 DAY))";
    }

    /** Bornes de la semaine (dimanche → vendredi) contenant $date */
    public function getPointageSemaineBornes($date)
    {
        $t     = strtotime($date);
        $debut = (int) date('w', $t) === 0 ? date('Y-m-d', $t) : date('Y-m-d', strtotime('last sunday', $t));
        $jours = [];
        for ($i = 0; $i < $this->ptJoursSemaine; $i++) {
            $jours[] = date('Y-m-d', strtotime($debut . " +$i days"));
        }
        return ['debut' => $debut, 'fin' => end($jours), 'jours' => $jours];
    }

    /** Travailleurs actifs sur le chantier à la date + leur pointage éventuel */
    public function getPointageFeuille($chantierId, $date)
    {
        $exclus = $this->crInList($this->crContratsExclus);
        $sql = "SELECT w.id AS contract_id, w.worker_name, w.worker_type, w.function_name,
                       w.pay_mode, w.unit_rate,
                       p.statut, p.heures, p.observation
                  FROM workforce_contracts w
                  LEFT JOIN tbl_pointage p ON p.contract_id = w.id AND p.pointage_date = ?
                 WHERE w.chantier_id = ?
                   AND LOWER(w.status_label) NOT IN ($exclus)
                   AND " . $this->ptDebutSql() . " <= ?
                   AND " . $this->ptFinSql() . " >= ?
                 ORDER BY w.worker_name ASC, w.id ASC";
        return $this->db->query($sql, [$date, (int) $chantierId, $date, $date])->result_array();
    }

    /**
     * Enregistre la feuille d'une journée (insertion ou mise à jour).
     * $lignes : [contract_id => ['statut' => ''|clé, 'heures' => float|null, 'observation' => string|null]]
     * statut vide = pointage supprimé. Retourne le nombre de lignes enregistrées, ou false.
     */
    public function savePointage($chantierId, $date, array $lignes, $userId, $companyId = null)
    {
        // Seuls les contrats réellement actifs sur ce chantier à cette date sont acceptés
        $autorises = array_flip(array_map('intval', array_column($this->getPointageFeuille($chantierId, $date), 'contract_id')));

        $n = 0;
        $this->db->trans_start();
        foreach ($lignes as $contractId => $l) {
            $contractId = (int) $contractId;
            if (!isset($autorises[$contractId])) {
                continue;
            }
            if ($l['statut'] === '') {
                $this->db->delete('tbl_pointage', ['contract_id' => $contractId, 'pointage_date' => $date]);
                continue;
            }
            $this->db->query(
                "INSERT INTO tbl_pointage
                    (company_id, chantier_id, contract_id, pointage_date, statut, heures, observation, created_by)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE
                    statut = VALUES(statut), heures = VALUES(heures), observation = VALUES(observation),
                    updated_by = VALUES(created_by), updated_at = NOW()",
                [
                    $companyId ?: null,
                    (int) $chantierId,
                    $contractId,
                    $date,
                    $l['statut'],
                    $l['heures'],
                    $l['observation'],
                    $userId ?: null
                ]
            );
            $n++;
        }
        $this->db->trans_complete();

        return $this->db->trans_status() ? $n : false;
    }

    /** Récapitulatif d'une semaine : grille travailleurs × jours */
    public function getPointageSemaine($chantierId, array $b)
    {
        $exclus = $this->crInList($this->crContratsExclus);
        $debutSql = $this->ptDebutSql();
        $finSql   = $this->ptFinSql();

        $contrats = $this->db->query(
            "SELECT w.id, w.worker_name, w.worker_type, w.function_name,
                    $debutSql AS actif_du, $finSql AS actif_au
               FROM workforce_contracts w
              WHERE w.chantier_id = ? AND LOWER(w.status_label) NOT IN ($exclus)
                AND $debutSql <= ? AND $finSql >= ?
              ORDER BY w.worker_name ASC, w.id ASC",
            [(int) $chantierId, $b['fin'], $b['debut']]
        )->result_array();

        $map = [];
        foreach (
            $this->db->query(
                "SELECT contract_id, pointage_date, statut, heures
               FROM tbl_pointage
              WHERE chantier_id = ? AND pointage_date BETWEEN ? AND ?",
                [(int) $chantierId, $b['debut'], $b['fin']]
            )->result_array() as $p
        ) {
            $map[(int) $p['contract_id']][$p['pointage_date']] = $p;
        }

        $totaux = [];
        foreach ($b['jours'] as $d) {
            $totaux[$d] = ['presents' => 0, 'pointes' => 0];
        }

        $lignes = [];
        foreach ($contrats as $c) {
            $jours = [];
            $travailles = 0;
            $absences = 0;
            $actifs = 0;
            $heures = 0;
            foreach ($b['jours'] as $d) {
                $actif = $d >= $c['actif_du'] && $d <= $c['actif_au'];
                $p = $map[(int) $c['id']][$d] ?? null;
                if ($actif) {
                    $actifs++;
                }
                if ($p) {
                    $v = $this->ptValeurs[$p['statut']] ?? 0;
                    $travailles += $v;
                    $heures     += (float) $p['heures'];
                    if (in_array($p['statut'], ['absent', 'justifie'], true)) {
                        $absences++;
                    }
                    $totaux[$d]['pointes']++;
                    $totaux[$d]['presents'] += $v;
                }
                $jours[$d] = ['actif' => $actif, 'statut' => $p['statut'] ?? null];
            }
            $lignes[] = [
                'contract_id'   => (int) $c['id'],
                'worker_name'   => $c['worker_name'],
                'worker_type'   => $c['worker_type'],
                'function_name' => $c['function_name'],
                'jours'         => $jours,
                'travailles'    => $travailles,
                'absences'      => $absences,
                'actifs'        => $actifs,
                'heures'        => $heures,
                'taux'          => $actifs > 0 ? round($travailles / $actifs * 100, 1) : null,
            ];
        }

        return ['lignes' => $lignes, 'totaux' => $totaux];
    }

    /** Tuiles : jour + semaine + chantiers non pointés aujourd'hui */
    public function getPointageStats($companyId, $date, array $b)
    {
        $wp = $companyId > 0 ? ' AND company_id = ' . (int) $companyId : '';
        $wc = $companyId > 0 ? ' AND w.company_id = ' . (int) $companyId : '';

        $jour = $this->db->query(
            "SELECT COALESCE(SUM(statut IN ('present', 'demi')), 0) AS presents,
                    COALESCE(SUM(statut = 'absent'), 0) AS absents,
                    COALESCE(SUM(statut = 'justifie'), 0) AS justifies
               FROM tbl_pointage WHERE pointage_date = ? $wp",
            [$date]
        )->row_array();

        $sem = $this->db->query(
            "SELECT COUNT(*) AS nb,
                    COALESCE(SUM(CASE statut WHEN 'present' THEN 1 WHEN 'demi' THEN 0.5 ELSE 0 END), 0) AS jours
               FROM tbl_pointage WHERE pointage_date BETWEEN ? AND ? $wp",
            [$b['debut'], $b['fin']]
        )->row_array();

        $exclus = $this->crInList($this->crContratsExclus);
        $nonPointes = $this->db->query(
            "SELECT DISTINCT c.id, c.name
               FROM workforce_contracts w
               JOIN chantiers c ON c.id = w.chantier_id
              WHERE LOWER(w.status_label) NOT IN ($exclus) $wc
                AND " . $this->ptDebutSql() . " <= ? AND " . $this->ptFinSql() . " >= ?
                AND NOT EXISTS (SELECT 1 FROM tbl_pointage p
                                 WHERE p.chantier_id = w.chantier_id AND p.pointage_date = ?)
              ORDER BY c.name ASC",
            [$date, $date, $date]
        )->result_array();

        return [
            'presents'     => (int) $jour['presents'],
            'absents'      => (int) $jour['absents'],
            'justifies'    => (int) $jour['justifies'],
            'taux_semaine' => (int) $sem['nb'] > 0 ? round($sem['jours'] / $sem['nb'] * 100, 1) : null,
            'non_pointes'  => $nonPointes,
        ];
    }

    // ============================================================
    // ORDRES DE SERVICE (Direction Technique) — table tbl_ordre_service
    // ============================================================

    const OS_TYPES = [
        'demarrage'    => 'Démarrage des travaux',
        'arret'        => 'Arrêt / suspension',
        'reprise'      => 'Reprise des travaux',
        'travaux_supp' => 'Travaux supplémentaires',
        'modification' => 'Modification des travaux',
        'prolongation' => 'Prolongation de délai',
        'autre'        => 'Autre',
    ];

    const OS_STATUTS = [
        'brouillon' => 'Brouillon',
        'emis'      => 'Émis / notifié',
        'en_cours'  => 'En exécution',
        'execute'   => 'Exécuté',
        'annule'    => 'Annulé',
    ];

    const OS_SENS = [
        'emis' => 'Émis par SATRACO',
        'recu' => "Reçu du maître d'ouvrage",
    ];

    /** Changements de statut autorisés */
    const OS_TRANSITIONS = [
        'brouillon' => ['emis', 'annule'],
        'emis'      => ['en_cours', 'execute', 'annule'],
        'en_cours'  => ['execute', 'annule'],
        'execute'   => [],
        'annule'    => [],
    ];

    private function osRetardSql($a = 'o')
    {
        return "($a.statut IN ('emis', 'en_cours') AND $a.date_effet IS NOT NULL AND $a.delai_jours IS NOT NULL
                 AND DATE_ADD($a.date_effet, INTERVAL $a.delai_jours DAY) < CURDATE())";
    }

    private function osSelect()
    {
        $this->db->select("o.*, c.name AS chantier_name, c.ref_chantier, c.location AS chantier_location,
                p.name AS projet_name, s.name AS subcontractor_name,
                DATE_ADD(o.date_effet, INTERVAL o.delai_jours DAY) AS echeance,
                " . $this->osRetardSql() . " AS en_retard", false)
            ->from('tbl_ordre_service o')
            ->join('chantiers c', 'c.id = o.chantier_id', 'left')
            ->join('projects p', 'p.id = c.project_id', 'left')
            ->join('subcontractors s', 's.id = o.subcontractor_id', 'left')
            ->where('o.status', 1);
    }

    private function osFilters(array $f)
    {
        if (!empty($f['company_id']))  $this->db->where('o.company_id', (int) $f['company_id']);
        if (!empty($f['chantier_id'])) $this->db->where('o.chantier_id', (int) $f['chantier_id']);
        if (!empty($f['type']))        $this->db->where('o.type_os', $f['type']);
        if (!empty($f['sens']))        $this->db->where('o.sens', $f['sens']);
        if (!empty($f['statut'])) {
            if ($f['statut'] === 'retard') {
                $this->db->where($this->osRetardSql(), null, false);
            } else {
                $this->db->where('o.statut', $f['statut']);
            }
        }
        if (!empty($f['date_debut'])) $this->db->where('o.date_emission >=', $f['date_debut']);
        if (!empty($f['date_fin']))   $this->db->where('o.date_emission <=', $f['date_fin']);
        if (!empty($f['q'])) {
            $this->db->group_start()
                ->like('o.numero', $f['q'])
                ->or_like('o.objet', $f['q'])
                ->or_like('o.destinataire', $f['q'])
                ->or_like('o.emetteur', $f['q'])
                ->or_like('c.name', $f['q'])
                ->group_end();
        }
    }

    public function getOrdresService(array $f = [], $limit = null, $offset = 0)
    {
        $this->osSelect();
        $this->osFilters($f);
        $this->db->order_by('o.date_emission', 'DESC')->order_by('o.id', 'DESC');
        if ($limit) {
            $this->db->limit((int) $limit, (int) $offset);
        }
        return $this->db->get()->result_array();
    }

    public function countOrdresService(array $f = [])
    {
        $this->db->from('tbl_ordre_service o')
            ->join('chantiers c', 'c.id = o.chantier_id', 'left')
            ->where('o.status', 1);
        $this->osFilters($f);
        return $this->db->count_all_results();
    }

    public function getOrdreService($id)
    {
        $this->osSelect();
        return $this->db->where('o.id', (int) $id)->get()->row_array();
    }

    public function getOsStats($companyId = 0)
    {
        $w = $companyId > 0 ? ' AND company_id = ' . (int) $companyId : '';
        return $this->db->query(
            "SELECT COALESCE(SUM(date_emission >= ?), 0) AS mois,
                    COALESCE(SUM(statut = 'brouillon'), 0) AS brouillons,
                    COALESCE(SUM(statut IN ('emis', 'en_cours')), 0) AS actifs,
                    COALESCE(SUM(" . $this->osRetardSql('t') . "), 0) AS retard,
                    COALESCE(SUM(CASE WHEN type_os IN ('travaux_supp', 'modification') AND statut <> 'annule'
                                      THEN montant ELSE 0 END), 0) AS montant_supp
               FROM tbl_ordre_service t
              WHERE status = 1 $w",
            [date('Y-m-01')]
        )->row_array();
    }

    public function getSubcontractorsPourOs($companyId = 0)
    {
        $this->db->select('id, name, specialty')->from('subcontractors');
        if ($companyId > 0) {
            $this->db->where('company_id', (int) $companyId);
        }
        return $this->db->order_by('name', 'ASC')->get()->result_array();
    }

    /** Insère un OS avec un numéro réservé ; retourne [id, numero] ou false */
    public function insertOrdreService(array $data)
    {
        $this->db->trans_start();
        $data['numero'] = $this->reserveCode('OS');
        $this->db->insert('tbl_ordre_service', $data);
        $id = (int) $this->db->insert_id();
        $this->db->trans_complete();

        return $this->db->trans_status() ? ['id' => $id, 'numero' => $data['numero']] : false;
    }

    public function updateOrdreService($id, array $data)
    {
        return $this->db->where('id', (int) $id)->update('tbl_ordre_service', $data);
    }

    /** Change le statut ; retourne true ou un message d'erreur */
    public function setOsStatut($id, $statut, $userId)
    {
        $os = $this->db->get_where('tbl_ordre_service', ['id' => (int) $id, 'status' => 1])->row_array();
        if (!$os) {
            return 'Ordre de service introuvable.';
        }
        $permis = self::OS_TRANSITIONS[$os['statut']] ?? [];
        if (!in_array($statut, $permis, true)) {
            return 'Changement de statut non autorisé.';
        }

        $upd = ['statut' => $statut, 'updated_by' => $userId, 'updated_at' => date('Y-m-d H:i:s')];
        if ($statut === 'emis' && empty($os['date_notification'])) {
            $upd['date_notification'] = date('Y-m-d');
        }
        if ($statut === 'execute' && empty($os['date_execution'])) {
            $upd['date_execution'] = date('Y-m-d');
        }
        $this->db->where('id', $os['id'])->update('tbl_ordre_service', $upd);
        return true;
    }

    public function softDeleteOrdreService($id, $userId)
    {
        return $this->updateOrdreService($id, [
            'status' => 0,
            'updated_by' => $userId,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
