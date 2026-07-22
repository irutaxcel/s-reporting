<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TechModel extends CI_Model
{


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

    public function getAllAchats($filters = [])
    {
        $this->db->select("
            prf.*,
            p.name AS chantier_nom,
            COUNT(pri.id) AS nombre_articles,
            GROUP_CONCAT(
                DISTINCT pri.designation
                ORDER BY pri.id ASC
                SEPARATOR ', '
            ) AS articles_designation,
            COALESCE(SUM(pri.total_price), 0) AS montant_articles
        ");

        $this->db->from('purchase_request_forms prf');

        $this->db->join(
            'projects p',
            'p.id = prf.chantier_id',
            'left'
        );

        $this->db->join(
            'purchase_request_items pri',
            'pri.request_id = prf.id',
            'left'
        );

        /*
     * Filtre chantier
     */
        if (!empty($filters['chantier_id'])) {
            $this->db->where(
                'prf.chantier_id',
                (int) $filters['chantier_id']
            );
        }

        /*
     * Filtre statut
     */
        if (!empty($filters['workflow_status'])) {
            $this->db->where(
                'prf.workflow_status',
                $filters['workflow_status']
            );
        }

        /*
     * Filtre date début
     */
        if (!empty($filters['date_debut'])) {
            $dateDebut = date(
                'Y-m-d',
                strtotime($filters['date_debut'])
            );

            $this->db->where(
                "DATE(COALESCE(prf.request_date, prf.created_at)) >= " .
                    $this->db->escape($dateDebut),
                null,
                false
            );
        }

        /*
     * Filtre date fin
     */
        if (!empty($filters['date_fin'])) {
            $dateFin = date(
                'Y-m-d',
                strtotime($filters['date_fin'])
            );

            $this->db->where(
                "DATE(COALESCE(prf.request_date, prf.created_at)) <= " .
                    $this->db->escape($dateFin),
                null,
                false
            );
        }

        $this->db->group_by('prf.id');

        $this->db->order_by(
            'COALESCE(prf.request_date, prf.created_at)',
            'DESC',
            false
        );

        $this->db->order_by('prf.id', 'DESC');

        /*
        * Les 100 dernières demandes
        */
        $this->db->limit(100);

        return $this->db->get()->result();
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


    public function getAllEngins()
    {
        return $this->db
            ->select('
                e.*,
                c.nom_categorie,
                ch.name AS chantier_name,
                p.photo AS photo_principale
            ')
            ->from('tbl_engin_materiel e')
            ->join('tbl_engin_categorie c', 'c.id = e.categorie_id', 'left')
            ->join('chantiers ch', 'ch.id = e.chantier_id', 'left')
            ->join('tbl_engin_photo p', 'p.engin_id = e.id', 'left')
            ->where('e.status', 1)
            ->group_by('e.id')
            ->order_by('e.id', 'DESC')
            ->get()
            ->result();
    }

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
}