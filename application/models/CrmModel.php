<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CrmModel extends CI_Model
{
    public function getAllProject()
    {
        $this->db->select('*');
        $this->db->from('projects');
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
        $total = $this->db->get()->row()->total;

        // Projets en cours
        $this->db->select('COUNT(*) as en_cours');
        $this->db->from('projects');
        $this->db->where('status', 'En cours');
        $en_cours = $this->db->get()->row()->en_cours;

        // Projets planifiés
        $this->db->select('COUNT(*) as planifies');
        $this->db->from('projects');
        $this->db->where('status', 'Planifié');
        $planifies = $this->db->get()->row()->planifies;

        // Projets terminés
        $this->db->select('COUNT(*) as termines');
        $this->db->from('projects');
        $this->db->where('status', 'Terminé');
        $termines = $this->db->get()->row()->termines;

        return array(
            'total' => $total,
            'en_cours' => $en_cours,
            'planifies' => $planifies,
            'termines' => $termines
        );
    }

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
        $this->db->join('tbl_client_projet cp', 'p.id = cp.projet_id', 'left');
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

        return $this->db->get()->row();
    }

    // Récupérer les chantiers d'un projet
    public function getChantiersByProject($projectId)
    {
        $this->db->select('*');
        $this->db->from('chantiers');
        $this->db->where('projet_id', $projectId);
        $this->db->order_by('created_at', 'DESC');

        return $this->db->get()->result();
    }

    // Récupérer le contrat d'un projet
    public function getContratByProject($projectId)
    {
        $this->db->select('*');
        $this->db->from('tbl_crm_contrats');
        $this->db->where('projet_id', $projectId);

        return $this->db->get()->row();
    }

    // Ajouter un chantier
    public function addChantier($data)
    {
        $this->db->insert('tbl_chantiers', $data);
        return $this->db->insert_id();
    }

    // Ajouter un devis
    public function addDevis($data)
    {
        $this->db->insert('tbl_devis', $data);
        return $this->db->insert_id();
    }

    // Ajouter un contrat
    public function addContrat($data)
    {
        $this->db->insert('tbl_crm_contrats', $data);
        return $this->db->insert_id();
    }

    /**
     * Enregistre les tranches de paiement d'un contrat.
     * Toujours appelée à l'intérieur de la même transaction que addContrat().
     *
     * @param int   $contrat_id
     * @param array $tranches   Chaque élément : numero_tranche, pourcentage,
     *                          avancement_requis, montant, condition_paiement, statut
     * @return bool
     */
    public function addContratTranches($contrat_id, array $tranches)
    {
        if (empty($tranches)) {
            return TRUE;
        }

        foreach ($tranches as &$tranche) {
            $tranche['contrat_id'] = $contrat_id;
        }
        unset($tranche);

        return $this->db->insert_batch('tbl_contrat_tranches', $tranches);
    }

    // Récupérer tous les devis avec informations complètes
    public function getAllDevis()
    {
        $this->db->select('
        d.*,
        p.name as projet_name,
        p.reference as projet_reference,
        c.name as chantier_name,
        c.location as chantier_location
    ');
        $this->db->from('tbl_devis d');
        $this->db->join('projects p', 'd.projet_id = p.id', 'left');
        $this->db->join('tbl_chantiers c', 'd.chantier_id = c.id', 'left');
        $this->db->where('d.deleted_at IS NULL');
        $this->db->order_by('d.created_at', 'DESC');

        return $this->db->get()->result();
    }

    // Récupérer tous les contrats avec informations complètes
    public function getAllContrats()
    {
        $this->db->select('
        c.*,
        p.name as projet_name,
        p.reference as projet_reference,
        ch.name as chantier_name,
        ch.location as chantier_location
    ');
        $this->db->from('tbl_crm_contrats c');
        $this->db->join('projects p', 'c.projet_id = p.id', 'left');
        $this->db->join('tbl_chantiers ch', 'c.chantier_id = ch.id', 'left');
        $this->db->where('c.deleted_at IS NULL');
        $this->db->order_by('c.created_at', 'DESC');

        return $this->db->get()->result();
    }

    // Récupérer un devis par son id, avec projet/chantier (pour la vue détail)
    public function getDevisById($id)
    {
        $this->db->select('
            d.*,
            p.name as projet_name,
            p.reference as projet_reference,
            ch.name as chantier_name,
            ch.location as chantier_location
        ');
        $this->db->from('tbl_devis d');
        $this->db->join('projects p', 'd.projet_id = p.id', 'left');
        $this->db->join('tbl_chantiers ch', 'd.chantier_id = ch.id', 'left');
        $this->db->where('d.id', $id);
        $this->db->where('d.deleted_at IS NULL');

        return $this->db->get()->row();
    }

    // Récupérer un contrat par son id, avec projet/chantier (pour la vue détail)
    public function getContratById($id)
    {
        $this->db->select('
        c.*,
        p.name as projet_name,
        p.reference as projet_reference,
        ch.name as chantier_name,
        ch.location as chantier_location
    ');
        $this->db->from('tbl_crm_contrats c');
        $this->db->join('projects p', 'c.projet_id = p.id', 'left');
        $this->db->join('tbl_chantiers ch', 'c.chantier_id = ch.id', 'left');
        $this->db->where('c.id', $id);
        $this->db->where('c.deleted_at IS NULL');

        return $this->db->get()->row();
    }

    // Récupérer les tranches de paiement d'un contrat, dans l'ordre
    public function getContratTranches($contrat_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_contrat_tranches');
        $this->db->where('contrat_id', $contrat_id);
        $this->db->order_by('numero_tranche', 'ASC');

        return $this->db->get()->result();
    }

    // Statistiques Devis & Contrats
    public function getDevisContratsStats()
    {
        // Total devis
        $this->db->select('COUNT(*) as total');
        $this->db->from('tbl_devis');
        $this->db->where('deleted_at IS NULL');
        $total_devis = $this->db->get()->row()->total;

        // Devis signés
        $this->db->select('COUNT(*) as signes');
        $this->db->from('tbl_devis');
        $this->db->where('statut', 'signe');
        $this->db->where('deleted_at IS NULL');
        $devis_signes = $this->db->get()->row()->signes;

        // Contrats actifs
        $this->db->select('COUNT(*) as actifs');
        $this->db->from('tbl_crm_contrats');
        $this->db->where('statut', 'signe');
        $this->db->where('deleted_at IS NULL');
        $contrats_actifs = $this->db->get()->row()->actifs;

        // Total chantiers
        $this->db->select('COUNT(*) as chantiers');
        $this->db->from('tbl_chantiers');
        $this->db->where('deleted_at IS NULL');
        $total_chantiers = $this->db->get()->row()->chantiers;

        return array(
            'total_devis' => $total_devis,
            'devis_signes' => $devis_signes,
            'contrats_actifs' => $contrats_actifs,
            'total_chantiers' => $total_chantiers
        );
    }

    // Récupérer tous les chantiers avec informations complètes
    public function getAllChantiers()
    {
        $this->db->select('
            ch.*,
            p.name as projet_name,
            p.reference as projet_reference,
            c.raison_sociale as client_name
        ');
        $this->db->from('tbl_chantiers ch');
        $this->db->join('projects p', 'ch.projet_id = p.id', 'left');
        $this->db->join('tbl_client_projet cp', 'p.id = cp.projet_id', 'left');
        $this->db->join('tbl_clients c', 'cp.client_id = c.id', 'left');
        $this->db->where('ch.deleted_at IS NULL');
        $this->db->order_by('ch.created_at', 'DESC');

        return $this->db->get()->result();
    }

    // Statistiques des chantiers
    public function getChantiersStats()
    {
        // Total chantiers
        $this->db->select('COUNT(*) as total');
        $this->db->from('tbl_chantiers');
        $this->db->where('deleted_at IS NULL');
        $total = $this->db->get()->row()->total;

        // En cours
        $this->db->select('COUNT(*) as en_cours');
        $this->db->from('tbl_chantiers');
        $this->db->where('status', 'En cours');
        $this->db->where('deleted_at IS NULL');
        $en_cours = $this->db->get()->row()->en_cours;

        // Non démarrés (Planifié)
        $this->db->select('COUNT(*) as non_demarres');
        $this->db->from('tbl_chantiers');
        $this->db->where('status', 'Planifié');
        $this->db->where('deleted_at IS NULL');
        $non_demarres = $this->db->get()->row()->non_demarres;

        // Terminés
        $this->db->select('COUNT(*) as termines');
        $this->db->from('tbl_chantiers');
        $this->db->where('status', 'Terminé');
        $this->db->where('deleted_at IS NULL');
        $termines = $this->db->get()->row()->termines;

        return array(
            'total' => $total,
            'en_cours' => $en_cours,
            'non_demarres' => $non_demarres,
            'termines' => $termines
        );
    }

        /* ======================================================================
     *  REPORTING — Rentabilité des projets et des chantiers
     *
     *  Achat effectué    : demande (purchase_request_forms) avec au moins un bon
     *                      purchase_payment_vouchers.payment_status = 'effectue'
     *                      montant = SUM(purchase_request_items.total_price)
     *  Main-d'œuvre      : workforce_contracts.unit_rate
     *  Dépenses chantier : achats effectués + main-d'œuvre   (table chantiers)
     *  Coût du projet    : SUM(tbl_devis.montant, statut 'signe') des tbl_chantiers du projet
     *  Bénéfice          : coût du projet − dépenses (lien par projects.id)
     *  Filtres $f        : company_id, date_du, date_au (Y-m-d)
     * ====================================================================== */

    /**
     * Achats effectués agrégés par chantier (table `chantiers`).
     * Une demande sans chantier_id (0) est rattachée par le nom saisi dans
     * destination_chantier quand il correspond exactement à un chantier.
     */
    private function rptAchatsParChantierSql(array $f, array &$binds)
    {
        $voucherDate = '';
        if (!empty($f['date_du'])) {
            $voucherDate .= ' AND v.payment_date >= ?';
            $binds[] = $f['date_du'];
        }
        if (!empty($f['date_au'])) {
            $voucherDate .= ' AND v.payment_date <= ?';
            $binds[] = $f['date_au'];
        }

        $company = '';
        if (!empty($f['company_id'])) {
            $company = ' AND f.company_id = ?';
            $binds[] = (int) $f['company_id'];
        }

        return "
            SELECT ch.id AS chantier_id,
                   COUNT(DISTINCT f.id)       AS nb_achats,
                   SUM(it.total)              AS achats
            FROM purchase_request_forms f
            JOIN (SELECT request_id, SUM(total_price) AS total
                  FROM purchase_request_items GROUP BY request_id) it ON it.request_id = f.id
            JOIN chantiers ch
                 ON ch.id = f.chantier_id
                 OR (f.chantier_id = 0 AND TRIM(f.destination_chantier) = TRIM(ch.name))
            WHERE EXISTS (SELECT 1 FROM purchase_payment_vouchers v
                          WHERE v.request_id = f.id
                            AND v.payment_status = 'effectue'{$voucherDate})
              {$company}
            GROUP BY ch.id";
    }

    /** Main-d'œuvre agrégée par chantier (table `chantiers`). */
    private function rptMainOeuvreParChantierSql(array $f, array &$binds)
    {
        $where = 'w.chantier_id IS NOT NULL';
        if (!empty($f['date_du'])) {
            $where .= ' AND w.start_date >= ?';
            $binds[] = $f['date_du'];
        }
        if (!empty($f['date_au'])) {
            $where .= ' AND w.start_date <= ?';
            $binds[] = $f['date_au'];
        }
        if (!empty($f['company_id'])) {
            $where .= ' AND w.company_id = ?';
            $binds[] = (int) $f['company_id'];
        }

        return "
            SELECT w.chantier_id,
                   COUNT(*)                                        AS nb_contrats,
                   SUM(w.unit_rate)                          AS main_oeuvre,
                   SUM(CASE WHEN w.unit_rate = 0 THEN 1 ELSE 0 END) AS nb_sans_montant
            FROM workforce_contracts w
            WHERE {$where}
            GROUP BY w.chantier_id";
    }

    /** Devis signés + avancement agrégés par projet (tbl_chantiers / tbl_devis). */
    private function rptDevisParProjetSql()
    {
        return "
            SELECT tc.projet_id,
                   COUNT(DISTINCT tc.id)                         AS nb_chantiers_crm,
                   COALESCE(SUM(dv.devis), 0)                    AS devis,
                   CASE WHEN SUM(dv.devis) > 0
                        THEN SUM(tc.avancement * dv.devis) / SUM(dv.devis)
                        ELSE AVG(tc.avancement) END              AS avancement
            FROM tbl_chantiers tc
            LEFT JOIN (SELECT chantier_id, SUM(montant) AS devis
                       FROM tbl_devis
                       WHERE statut = 'signe' AND deleted_at IS NULL
                       GROUP BY chantier_id) dv ON dv.chantier_id = tc.id
            WHERE tc.deleted_at IS NULL
            GROUP BY tc.projet_id";
    }

    /** Portefeuille : un résumé par projet. */
    public function rptGetPortefeuille(array $f = [])
    {
        $binds = [];
        $achats = $this->rptAchatsParChantierSql($f, $binds);
        $mo     = $this->rptMainOeuvreParChantierSql($f, $binds);
        $devis  = $this->rptDevisParProjetSql();

        $company = '';
        if (!empty($f['company_id'])) {
            $company = 'WHERE p.company_id = ?';
            $binds[] = (int) $f['company_id'];
        }

        $sql = "
            SELECT p.id, p.name, p.reference, p.status, p.created_at,
                   COALESCE(dp.devis, 0)             AS devis,
                   COALESCE(dp.avancement, 0)        AS avancement,
                   COALESCE(dp.nb_chantiers_crm, 0)  AS nb_chantiers_crm,
                   COALESCE(dep.nb_chantiers, 0)     AS nb_chantiers,
                   COALESCE(dep.achats, 0)           AS achats,
                   COALESCE(dep.main_oeuvre, 0)      AS main_oeuvre,
                   COALESCE(dep.achats, 0) + COALESCE(dep.main_oeuvre, 0) AS depenses
            FROM projects p
            LEFT JOIN ({$devis}) dp ON dp.projet_id = p.id
            LEFT JOIN (
                SELECT ch.project_id,
                       COUNT(*)                      AS nb_chantiers,
                       SUM(COALESCE(a.achats, 0))    AS achats,
                       SUM(COALESCE(m.main_oeuvre,0)) AS main_oeuvre
                FROM chantiers ch
                LEFT JOIN ({$achats}) a ON a.chantier_id = ch.id
                LEFT JOIN ({$mo})     m ON m.chantier_id = ch.id
                GROUP BY ch.project_id
            ) dep ON dep.project_id = p.id
            {$company}
            ORDER BY depenses DESC, p.created_at DESC";

        return $this->db->query($sql, $binds)->result_array();
    }

    public function rptGetProjet($projetId)
    {
        return $this->db->query(
            "SELECT id, name, reference, status, created_at FROM projects WHERE id = ?",
            [(int) $projetId]
        )->row_array();
    }

    /** Client du projet (tbl_clients.projet_id ou tbl_client_projet). */
    public function rptGetClientProjet($projetId)
    {
        $row = $this->db->query(
            "SELECT COALESCE(NULLIF(c.nom_commercial, ''), c.raison_sociale) AS client
             FROM tbl_clients c
             WHERE c.deleted_at IS NULL
               AND (c.projet_id = ?
                    OR c.id IN (SELECT client_id FROM tbl_client_projet WHERE projet_id = ?))
             ORDER BY c.id DESC LIMIT 1",
            [(int) $projetId, (int) $projetId]
        )->row_array();
        return $row ? $row['client'] : null;
    }

    /** Chantiers opérationnels du projet (table `chantiers`) avec leurs dépenses. */
    public function rptGetChantiersDepenses($projetId, array $f = [])
    {
        $binds  = [];
        $achats = $this->rptAchatsParChantierSql($f, $binds);
        $mo     = $this->rptMainOeuvreParChantierSql($f, $binds);
        $binds[] = (int) $projetId;

        $sql = "
            SELECT ch.id, ch.ref_chantier, ch.name, ch.chef_chantier, ch.location, ch.status,
                   ch.date_debut, ch.date_fin_prevue,
                   COALESCE(a.nb_achats, 0)       AS nb_achats,
                   COALESCE(a.achats, 0)          AS achats,
                   COALESCE(m.nb_contrats, 0)     AS nb_contrats,
                   COALESCE(m.nb_sans_montant, 0) AS nb_sans_montant,
                   COALESCE(m.main_oeuvre, 0)     AS main_oeuvre,
                   COALESCE(a.achats, 0) + COALESCE(m.main_oeuvre, 0) AS depenses
            FROM chantiers ch
            LEFT JOIN ({$achats}) a ON a.chantier_id = ch.id
            LEFT JOIN ({$mo})     m ON m.chantier_id = ch.id
            WHERE ch.project_id = ?
            ORDER BY depenses DESC, ch.name";

        return $this->db->query($sql, $binds)->result_array();
    }

    /** Chantiers CRM du projet (tbl_chantiers) avec devis et avancement. */
    public function rptGetChantiersDevis($projetId)
    {
        $sql = "
            SELECT tc.id, tc.name, tc.location, tc.chef_chantier, tc.status, tc.avancement,
                   tc.date_debut, tc.date_fin_prevue,
                   COALESCE(d.devis_signe, 0)   AS devis_signe,
                   COALESCE(d.devis_attente, 0) AS devis_attente,
                   COALESCE(d.nb_devis, 0)      AS nb_devis,
                   d.refs_signes
            FROM tbl_chantiers tc
            LEFT JOIN (
                SELECT chantier_id,
                       SUM(CASE WHEN statut = 'signe'      THEN montant ELSE 0 END) AS devis_signe,
                       SUM(CASE WHEN statut = 'en_attente' THEN montant ELSE 0 END) AS devis_attente,
                       COUNT(*)                                                     AS nb_devis,
                       GROUP_CONCAT(CASE WHEN statut = 'signe' THEN reference END
                                    ORDER BY date_creation SEPARATOR ', ')          AS refs_signes
                FROM tbl_devis
                WHERE deleted_at IS NULL
                GROUP BY chantier_id
            ) d ON d.chantier_id = tc.id
            WHERE tc.projet_id = ? AND tc.deleted_at IS NULL
            ORDER BY devis_signe DESC, tc.name";

        return $this->db->query($sql, [(int) $projetId])->result_array();
    }

    /** Liste des achats effectués pour une série de chantiers (détail du modal). */
    public function rptGetAchatsEffectues(array $chantierIds, array $f = [], $limit = 300)
    {
        if (empty($chantierIds)) {
            return [];
        }
        $ids = implode(',', array_map('intval', $chantierIds));

        $binds = [];
        $voucherDate = '';
        if (!empty($f['date_du'])) {
            $voucherDate .= ' AND v.payment_date >= ?';
            $binds[] = $f['date_du'];
        }
        if (!empty($f['date_au'])) {
            $voucherDate .= ' AND v.payment_date <= ?';
            $binds[] = $f['date_au'];
        }

        $sql = "
            SELECT ch.id AS chantier_id, f.id, f.request_date, f.requested_by, f.destination_chantier,
                   pay.last_payment AS payment_date, pay.nb_bons,
                   (SELECT SUM(total_price) FROM purchase_request_items WHERE request_id = f.id) AS montant,
                   (SELECT designation FROM purchase_request_items WHERE request_id = f.id ORDER BY id LIMIT 1) AS premiere_ligne,
                   (SELECT COUNT(*) FROM purchase_request_items WHERE request_id = f.id) AS nb_lignes
            FROM purchase_request_forms f
            JOIN (SELECT v.request_id, MAX(v.payment_date) AS last_payment, COUNT(*) AS nb_bons
                  FROM purchase_payment_vouchers v
                  WHERE v.payment_status = 'effectue'{$voucherDate}
                  GROUP BY v.request_id) pay ON pay.request_id = f.id
            JOIN chantiers ch
                 ON ch.id = f.chantier_id
                 OR (f.chantier_id = 0 AND TRIM(f.destination_chantier) = TRIM(ch.name))
            WHERE ch.id IN ({$ids})
            ORDER BY pay.last_payment DESC, f.id DESC
            LIMIT " . (int) $limit;

        return $this->db->query($sql, $binds)->result_array();
    }

    /** Main-d'œuvre par type de travailleur pour une série de chantiers. */
    public function rptGetMainOeuvreParType(array $chantierIds, array $f = [])
    {
        if (empty($chantierIds)) {
            return [];
        }
        $ids   = implode(',', array_map('intval', $chantierIds));
        $binds = [];
        $where = "w.chantier_id IN ({$ids})";
        if (!empty($f['date_du'])) {
            $where .= ' AND w.start_date >= ?';
            $binds[] = $f['date_du'];
        }
        if (!empty($f['date_au'])) {
            $where .= ' AND w.start_date <= ?';
            $binds[] = $f['date_au'];
        }

        $sql = "
            SELECT w.chantier_id, w.worker_type,
                   COUNT(*)               AS nb_contrats,
                   SUM(w.unit_rate) AS montant
            FROM workforce_contracts w
            WHERE {$where}
            GROUP BY w.chantier_id, w.worker_type
            ORDER BY montant DESC, nb_contrats DESC";

        return $this->db->query($sql, $binds)->result_array();
    }

    /** Achats effectués non rattachés à un chantier (contrôle qualité). */
    public function rptGetAchatsNonRattaches(array $f = [])
    {
        $binds = [];
        $voucherDate = '';
        if (!empty($f['date_du'])) {
            $voucherDate .= ' AND v.payment_date >= ?';
            $binds[] = $f['date_du'];
        }
        if (!empty($f['date_au'])) {
            $voucherDate .= ' AND v.payment_date <= ?';
            $binds[] = $f['date_au'];
        }
        $company = '';
        if (!empty($f['company_id'])) {
            $company = ' AND f.company_id = ?';
            $binds[] = (int) $f['company_id'];
        }

        $sql = "
            SELECT COUNT(*) AS nb, COALESCE(SUM(it.total), 0) AS montant
            FROM purchase_request_forms f
            JOIN (SELECT request_id, SUM(total_price) AS total
                  FROM purchase_request_items GROUP BY request_id) it ON it.request_id = f.id
            WHERE EXISTS (SELECT 1 FROM purchase_payment_vouchers v
                          WHERE v.request_id = f.id
                            AND v.payment_status = 'effectue'{$voucherDate})
              AND NOT EXISTS (SELECT 1 FROM chantiers ch
                              WHERE ch.id = f.chantier_id
                                 OR (f.chantier_id = 0 AND TRIM(f.destination_chantier) = TRIM(ch.name)))
              {$company}";

        return $this->db->query($sql, $binds)->row_array();
    }
}