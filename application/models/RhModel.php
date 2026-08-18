<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RhModel extends CI_Model
{
    protected $table = 'tbl_employes';

    /** Génère le prochain matricule : SAT-0001, SAT-0002, … */
    public function generer_matricule()
    {
        $q = $this->db->query("SELECT MAX(CAST(SUBSTRING(matricule, 5) AS UNSIGNED)) AS num
                               FROM {$this->table} WHERE matricule LIKE 'SAT-%'");
        $num = ($q->row()->num !== NULL) ? (int) $q->row()->num : 0;
        return 'SAT-' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // public function get_all()
    // {
    //     return $this->db->order_by('nom ASC')->get($this->table)->result();
    // }

    /** Liste de tous les employés, par ordre décroissant (plus récents d'abord) */
    public function get_all($ordre = 'DESC')
    {
        return $this->db->order_by('employe_id', $ordre)
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['employe_id' => (int) $id])->row();
    }

    public function update($id, $data)
    {
        $this->db->where('employe_id', (int) $id);
        return $this->db->update($this->table, $data);
    }
}
