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

    public function insertContract($data)
    {
        $this->db->insert('tbl_contrats', $data);
        return $this->db->insert_id();
    }

    /** Contrats + infos employé, du plus récent au plus ancien */
    public function get_with_employes()
    {
        return $this->db
            ->select('c.*, e.matricule, e.nom, e.prenoms')
            ->from('tbl_contrats' . ' c')
            ->join('tbl_employes e', 'e.employe_id = c.employe_id')
            ->order_by('c.contrat_id', 'DESC')
            ->get()->result();
    }

    protected $table_mouvements = 'tbl_mouvements';   // ← nouvelle propriété

    /** Insertion d'un mouvement */
    public function insert_mouvement($data)
    {
        $this->db->insert($this->table_mouvements, $data);
        return $this->db->insert_id();
    }

    /** Mouvements + infos employé, du plus récent au plus ancien */
    public function get_mouvements_with_employes()
    {
        return $this->db
            ->select('m.*, e.matricule, e.nom, e.prenoms')
            ->from($this->table_mouvements . ' m')
            ->join('tbl_employes e', 'e.employe_id = m.employe_id')
            ->order_by('m.date_effet', 'DESC')
            ->get()->result();
    }

    protected $table_conges = 'tbl_conges';   // ← nouvelle propriété

    /** Insertion d'une demande de congé */
    public function insert_conge($data)
    {
        $this->db->insert($this->table_conges, $data);
        return $this->db->insert_id();
    }

    /** Demandes + infos employé (+ remplaçant), des plus récentes aux plus anciennes */
    public function get_conges_with_employes()
    {
        return $this->db
            ->select('cg.*, e.matricule, e.nom, e.prenoms,
                  r.matricule AS remplacant_matricule, r.nom AS remplacant_nom, r.prenoms AS remplacant_prenoms')
            ->from($this->table_conges . ' cg')
            ->join('tbl_employes e', 'e.employe_id = cg.employe_id')
            ->join('tbl_employes r', 'r.employe_id = cg.remplacant_id', 'left')
            ->order_by('cg.conge_id', 'DESC')
            ->get()->result();
    }
}