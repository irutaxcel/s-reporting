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

    public function getPersonlChantier($id)
    {
        return $this->db
            ->select('*')
            ->from('workforce_contracts')
            ->where('chantier_id', $id)
            ->order_by('id', 'DESC')
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

    public function countAllPersonnel()
    {
        return $this->db->count_all('workforce_contracts');
    }

    public function sumAllPersonnel()
    {
        $this->db->select_sum('unit_rate');

        $result = $this->db->get('workforce_contracts')->row();

        return $result->unit_rate;
    }
}