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
}
