<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CrmModel extends CI_Model
{
    public function getAllProject()
    {
        $this->db->select('*');
        $this->db->from('projects'); // ✅ Ajout du préfixe
        $this->db->order_by('name', 'ASC');

        return $this->db->get()->result();
    }

    public function addClient($data)
    {
        // Insertion dans la table tbl_clients
        $this->db->insert('tbl_clients', $data);
        return $this->db->insert_id(); // Retourne l'ID du client créé
    }

    public function insertClientProject($client_id, $projet_id)
    {
        // Insertion dans la table de liaison tbl_client_projet
        $data = array(
            'client_id' => $client_id,
            'projet_id' => $projet_id,
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('tbl_client_projet', $data);
        return $this->db->insert_id();
    }

    public function getAllClients()
    {
        // Récupérer tous les clients avec le nombre de projets associés
        $this->db->select('c.*, COUNT(cp.projet_id) as nb_projets');
        $this->db->from('tbl_clients c');
        $this->db->join('tbl_client_projet cp', 'c.id = cp.client_id', 'left');
        $this->db->group_by('c.id');
        $this->db->order_by('c.created_at', 'DESC');

        return $this->db->get()->result();
    }

    // public function getClientStats()
    // {
    //     // Statistiques globales
    //     $this->db->select('COUNT(*) as total');
    //     $this->db->from('tbl_clients');
    //     $total = $this->db->get()->row()->total;

    //     $this->db->select('COUNT(*) as actifs');
    //     $this->db->from('tbl_clients');
    //     $this->db->where('statut', 'actif');
    //     $actifs = $this->db->get()->row()->actifs;

    //     $this->db->select('COUNT(*) as prospects');
    //     $this->db->from('tbl_clients');
    //     $this->db->where('statut', 'prospect');
    //     $prospects = $this->db->get()->row()->prospects;

    //     $this->db->select('COUNT(DISTINCT projet_id) as projets_actifs');
    //     $this->db->from('tbl_client_projet');
    //     $projets_actifs = $this->db->get()->row()->projets_actifs;

    //     return array(
    //         'total' => $total,
    //         'actifs' => $actifs,
    //         'prospects' => $prospects,
    //         'projets_actifs' => $projets_actifs
    //     );
    // }

    // Récupérer un client par son ID
    public function getClientById($id)
    {
        $this->db->select('c.*, COUNT(cp.projet_id) as nb_projets');
        $this->db->from('tbl_clients c');
        $this->db->join('tbl_client_projet cp', 'c.id = cp.client_id', 'left');
        $this->db->where('c.id', $id);
        $this->db->group_by('c.id');

        return $this->db->get()->row();
    }

    // Mettre à jour un client
    public function updateClient($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_clients', $data);
    }

    // Supprimer un client (soft delete)
    public function deleteClient($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_clients', array(
            'deleted_at' => date('Y-m-d H:i:s'),
            'statut' => 'inactif'
        ));
    }

    // Supprimer définitivement un client
    public function hardDeleteClient($id)
    {
        // Supprimer d'abord les liaisons projets
        $this->db->where('client_id', $id);
        $this->db->delete('tbl_client_projet');

        // Supprimer le client
        $this->db->where('id', $id);
        return $this->db->delete('tbl_clients');
    }

    public function getClientStats()
    {
        // Total des clients
        $this->db->select('COUNT(*) as total');
        $this->db->from('tbl_clients');
        $this->db->where('deleted_at IS NULL');
        $total = $this->db->get()->row()->total;

        // Clients actifs
        $this->db->select('COUNT(*) as actifs');
        $this->db->from('tbl_clients');
        $this->db->where('statut', 'actif');
        $this->db->where('deleted_at IS NULL');
        $actifs = $this->db->get()->row()->actifs;

        // Prospects
        $this->db->select('COUNT(*) as prospects');
        $this->db->from('tbl_clients');
        $this->db->where('statut', 'prospect');
        $this->db->where('deleted_at IS NULL');
        $prospects = $this->db->get()->row()->prospects;

        // Clients inactifs
        $this->db->select('COUNT(*) as inactifs');
        $this->db->from('tbl_clients');
        $this->db->where('statut', 'inactif');
        $this->db->where('deleted_at IS NULL');
        $inactifs = $this->db->get()->row()->inactifs;

        // Nouveaux clients ce mois
        $this->db->select('COUNT(*) as nouveaux_ce_mois');
        $this->db->from('tbl_clients');
        $this->db->where('MONTH(created_at) =', date('m'));
        $this->db->where('YEAR(created_at) =', date('Y'));
        $this->db->where('deleted_at IS NULL');
        $nouveaux_ce_mois = $this->db->get()->row()->nouveaux_ce_mois;

        // Nouveaux clients cette semaine
        $this->db->select('COUNT(*) as nouveaux_cette_semaine');
        $this->db->from('tbl_clients');
        $this->db->where('YEARWEEK(created_at) =', date('YW'));
        $this->db->where('deleted_at IS NULL');
        $nouveaux_cette_semaine = $this->db->get()->row()->nouveaux_cette_semaine;

        // Projets actifs (distincts)
        $this->db->select('COUNT(DISTINCT projet_id) as projets_actifs');
        $this->db->from('tbl_client_projet');
        $this->db->join('projects p', 'tbl_client_projet.projet_id = p.id', 'left');
        $this->db->where('p.status', 'En cours');
        $projets_actifs = $this->db->get()->row()->projets_actifs;

        // Total des projets tous statuts confondus
        $this->db->select('COUNT(DISTINCT projet_id) as total_projets');
        $this->db->from('tbl_client_projet');
        $total_projets = $this->db->get()->row()->total_projets;

        // Calcul du pourcentage de clients actifs
        $pourcentage_actifs = $total > 0 ? round(($actifs / $total) * 100) : 0;

        // Calcul du pourcentage de prospects
        $pourcentage_prospects = $total > 0 ? round(($prospects / $total) * 100) : 0;

        return array(
            'total' => $total,
            'actifs' => $actifs,
            'prospects' => $prospects,
            'inactifs' => $inactifs,
            'projets_actifs' => $projets_actifs,
            'total_projets' => $total_projets,
            'nouveaux_ce_mois' => $nouveaux_ce_mois,
            'nouveaux_cette_semaine' => $nouveaux_cette_semaine,
            'pourcentage_actifs' => $pourcentage_actifs,
            'pourcentage_prospects' => $pourcentage_prospects
        );
    }

    // Statistiques des projets
    public function getProjectStats()
    {
        // Total projets
        $this->db->select('COUNT(*) as total');
        $this->db->from('projects');
        // $this->db->where('deleted_at IS NULL');
        $total = $this->db->get()->row()->total;

        // Projets en cours
        $this->db->select('COUNT(*) as en_cours');
        $this->db->from('projects');
        $this->db->where('status', 'En cours');
        // $this->db->where('deleted_at IS NULL');
        $en_cours = $this->db->get()->row()->en_cours;

        // Projets planifiés
        $this->db->select('COUNT(*) as planifies');
        $this->db->from('projects');
        $this->db->where('status', 'Planifié');
        // $this->db->where('deleted_at IS NULL');
        $planifies = $this->db->get()->row()->planifies;

        // Projets terminés
        $this->db->select('COUNT(*) as termines');
        $this->db->from('projects');
        $this->db->where('status', 'Terminé');
        // $this->db->where('deleted_at IS NULL');
        $termines = $this->db->get()->row()->termines;

        return array(
            'total' => $total,
            'en_cours' => $en_cours,
            'planifies' => $planifies,
            'termines' => $termines
        );
    }

    // Récupérer tous les projets avec informations complètes
    // public function getAllProjects()
    // {
    //     $this->db->select('
    //         p.*,
    //         c.raison_sociale as client_name,
    //         c.type_client,
    //         COUNT(ch.id) as nb_chantiers,
    //         COALESCE(AVG(ch.avancement), 0) as avg_avancement,
    //         0 as total_decaisse
    //     ');
    //     $this->db->from('projects p');
    //     $this->db->join('tbl_clients c', 'p.company_id = c.id', 'left');
    //     $this->db->join('tbl_chantiers ch', 'p.id = ch.projet_id AND ch.deleted_at IS NULL', 'left');
    //     $this->db->join('tbl_client_projet cp', 'p.id = cp.projet_id', 'left');
    //     // ✅ Supprimer la ligne WHERE p.deleted_at IS NULL
    //     $this->db->group_by('p.id');
    //     $this->db->order_by('p.created_at', 'DESC');

    //     return $this->db->get()->result();
    // }

    public function getAllProjects()
    {
        $this->db->select('
            p.*,
            c.raison_sociale as client_name,
            c.type_client,
            COUNT(ch.id) as nb_chantiers,
            COALESCE(AVG(ch.avancement), 0) as avg_avancement,
            0 as total_decaisse
        ');
        $this->db->from('projects p');
        // ✅ D'abord joindre la table de liaison
        $this->db->join('tbl_client_projet cp', 'p.id = cp.projet_id', 'left');
        // ✅ Ensuite joindre les clients via client_id
        $this->db->join('tbl_clients c', 'cp.client_id = c.id', 'left');
        $this->db->join('tbl_chantiers ch', 'p.id = ch.projet_id AND ch.deleted_at IS NULL', 'left');
        $this->db->group_by('p.id');
        $this->db->order_by('p.created_at', 'DESC');

        return $this->db->get()->result();
    }

    // Récupérer un projet avec tous ses détails
    public function getProjectById($id)
    {
        $this->db->select('
        p.*,
        c.raison_sociale as client_name,
        c.type_client,
        c.email as client_email,
        c.telephone as client_phone
    ');
        $this->db->from('projects p');
        $this->db->join('tbl_clients c', 'p.company_id = c.id', 'left');
        $this->db->where('p.id', $id);
        // $this->db->where('p.deleted_at IS NULL');

        return $this->db->get()->row();
    }

    // Récupérer les chantiers d'un projet
    public function getChantiersByProject($projectId)
    {
        $this->db->select('*');
        $this->db->from('chantiers');
        $this->db->where('projet_id', $projectId);
        // $this->db->where('deleted_at IS NULL');
        $this->db->order_by('created_at', 'DESC');

        return $this->db->get()->result();
    }

    // Récupérer le contrat d'un projet
    public function getContratByProject($projectId)
    {
        $this->db->select('*');
        $this->db->from('tbl_contrats');
        $this->db->where('projet_id', $projectId);
        // $this->db->where('deleted_at IS NULL');

        return $this->db->get()->row();
    }
}
