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

    public function insert_achat_materiel_form($data_form, $articles, $quantites, $prix_unitaires, $totaux_lignes)
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
                    'observations'    => null
                ];

                $this->db->insert('purchase_request_items', $data_item);
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function getAllAchats()
    {
        $this->db->select("
            prf.*,
            p.name AS chantier_nom,
            GROUP_CONCAT(pri.designation SEPARATOR ', ') AS articles_designation
        ");

        $this->db->from('purchase_request_forms prf');
        $this->db->join('chantiers p', 'p.id = prf.chantier_id', 'left');
        $this->db->join('purchase_request_items pri', 'pri.request_id = prf.id', 'left');

        $this->db->group_by('prf.id');
        $this->db->order_by('prf.id', 'DESC');

        return $this->db->get()->result();
    }

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

    public function updateAchatMateriel($id, $data_form, $articles, $quantites, $prix_unitaires, $totaux_lignes)
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
                    'observations'    => null
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
}