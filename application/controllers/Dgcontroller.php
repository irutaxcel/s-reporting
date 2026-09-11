<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dgcontroller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('AuthModel', 'auth');
        $this->load->model('TechModel', 'tech');
        $this->load->model('AdminModel', 'admin');
        $this->load->model('FinanceModel', 'finance');
        $this->load->model('RhModel', 'Employe_model');
        $this->load->model('DgModel', 'dg');
        $this->load->library('upload');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function syntheseDemandes()
    {
        $data['title'] = 'Synthèse des demandes';

        // ============================================
        // GESTION DES FILTRES
        // ============================================
        $date_debut = $this->input->get('date_debut');
        $date_fin = $this->input->get('date_fin');
        $chantier_filtre = $this->input->get('chantier'); // NOUVEAU

        // Si pas de dates fournies, utiliser le mois actuel
        if (empty($date_debut) || empty($date_fin)) {
            $date_debut = date('Y-m-01');
            $date_fin = date('Y-m-d');
        }

        // Stocker les filtres pour la vue
        $data['filtre_date_debut'] = $date_debut;
        $data['filtre_date_fin'] = $date_fin;
        $data['filtre_chantier'] = $chantier_filtre;

        // Calculer le mois/année
        $data['mois_annee'] = date('F Y', strtotime($date_debut));
        $data['periode_affichage'] = date('d/m', strtotime($date_debut)) . ' - ' . date('d/m/Y', strtotime($date_fin));

        // ============================================
        // RÉCUPÉRER LA LISTE DES CHANTIERS (pour le select)
        // ============================================
        $data['liste_chantiers'] = $this->dg->getListeChantiers();

        // ============================================
        // RÉCUPÉRER LES DONNÉES
        // ============================================
        $data['demandes'] = $this->dg->getDemandesByChantier(null, $date_debut, $date_fin, $chantier_filtre);
        $data['statistics'] = $this->dg->getVoucherStatistics(null, $date_debut, $date_fin, $chantier_filtre);
        $data['chantiers_data'] = $this->dg->getVouchersByChantier(null, $date_debut, $date_fin, $chantier_filtre);

        // Grouper les demandes par chantier
        $data['demandes_by_chantier'] = [];
        foreach ($data['demandes'] as $demande) {
            $chantier = $demande->destination_chantier ?: 'Non spécifié';
            if (!isset($data['demandes_by_chantier'][$chantier])) {
                $data['demandes_by_chantier'][$chantier] = [];
            }
            $data['demandes_by_chantier'][$chantier][] = $demande;
        }

        // Charger les vues
        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/direction/synthese-demandes', $data);
        $this->load->view('v1/components/layout/footer');
    }

    /**
     * Mettre à jour le montant autorisé via AJAX
     */
    public function updateMontantAutorise()
    {
        // Vérifier que c'est une requête AJAX
        if (!$this->input->is_ajax_request()) {
            echo json_encode(['success' => false, 'message' => 'Requête invalide']);
            exit;
        }

        // Récupérer les données POST
        $request_id = $this->input->post('request_id');
        $montant_autorise = $this->input->post('montant_autorise');

        // Validation
        if (empty($request_id) || !is_numeric($montant_autorise)) {
            echo json_encode([
                'success' => false,
                'message' => 'Données invalides'
            ]);
            exit;
        }

        // Récupérer le voucher associé
        $voucher = $this->dg->getVoucherByRequestId((int)$request_id);

        if (!$voucher) {
            echo json_encode([
                'success' => false,
                'message' => 'Bon de paiement non trouvé'
            ]);
            exit;
        }

        // Mettre à jour le montant autorisé
        $updated = $this->dg->updateMontantAutorise(
            (int)$voucher->id,
            (float)$montant_autorise
        );

        if ($updated) {
            echo json_encode([
                'success' => true,
                'message' => 'Montant autorisé mis à jour avec succès',
                'montant_autorise' => number_format($montant_autorise, 0, ',', ' ')
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ]);
        }
    }

    public function imprimerSynthese()
    {
        $data['title'] = 'Synthèse des demandes d\'achat - Impression';

        // Récupérer les filtres
        $date_debut = $this->input->get('date_debut');
        $date_fin = $this->input->get('date_fin');
        $chantier_filtre = $this->input->get('chantier'); // NOUVEAU

        if (empty($date_debut) || empty($date_fin)) {
            $date_debut = date('Y-m-01');
            $date_fin = date('Y-m-d');
        }

        $data['filtre_date_debut'] = $date_debut;
        $data['filtre_date_fin'] = $date_fin;
        $data['filtre_chantier'] = $chantier_filtre;
        $data['mois_annee'] = date('F Y', strtotime($date_debut));
        $data['periode_affichage'] = date('d/m', strtotime($date_debut)) . ' - ' . date('d/m/Y', strtotime($date_fin));

        // Récupérer les données avec le filtre chantier
        $data['demandes'] = $this->dg->getDemandesByChantier(null, $date_debut, $date_fin, $chantier_filtre);
        $data['statistics'] = $this->dg->getVoucherStatistics(null, $date_debut, $date_fin, $chantier_filtre);
        $data['chantiers_data'] = $this->dg->getVouchersByChantier(null, $date_debut, $date_fin, $chantier_filtre);

        // Grouper par chantier
        $data['demandes_by_chantier'] = [];
        foreach ($data['demandes'] as $demande) {
            $chantier = $demande->destination_chantier ?: 'Non spécifié';
            if (!isset($data['demandes_by_chantier'][$chantier])) {
                $data['demandes_by_chantier'][$chantier] = [];
            }
            $data['demandes_by_chantier'][$chantier][] = $demande;
        }

        // Afficher le chantier filtré dans le titre si applicable
        if ($chantier_filtre && $chantier_filtre !== 'tous') {
            $data['title'] .= ' - ' . $chantier_filtre;
        }

        // Charger la vue d'impression
        $this->load->view('v1/components/modules/direction/synthese-demandes-print', $data);
    }

    public function directionArchives()
    {
        $data['title'] = 'Archives des demandes d\'achat';

        // Récupérer les filtres
        $date_debut = $this->input->get('date_debut');
        $date_fin = $this->input->get('date_fin');
        $chantier_filtre = $this->input->get('chantier');

        if (empty($date_debut) || empty($date_fin)) {
            $date_debut = date('Y-m-01');
            $date_fin = date('Y-m-d');
        }

        $data['filtre_date_debut'] = $date_debut;
        $data['filtre_date_fin'] = $date_fin;
        $data['filtre_chantier'] = $chantier_filtre;

        // Récupérer les données archivées avec le filtre chantier
        $data['demandes_archives'] = $this->dg->getArchivedDemandesByChantier(null, $date_debut, $date_fin, $chantier_filtre);

        // Charger les vues
        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/direction/direction-archives', $data);
        $this->load->view('v1/components/layout/footer');
    }

    /**
     * Page Relation Publique
     */
    public function directionRelationPublique()
    {
        $data['title'] = 'Relation Publique';

        // Récupérer les filtres
        $date_debut = $this->input->get('date_debut') ?: date('Y-m-01');
        $date_fin   = $this->input->get('date_fin') ?: date('Y-m-d');

        $data['filtre_date_debut'] = $date_debut;
        $data['filtre_date_fin']   = $date_fin;

        // Récupérer les sorties
        $data['sorties'] = $this->dg->getSortiesRelationPublique($date_debut, $date_fin);

        // Récupérer les statistiques
        $data['statistiques'] = $this->dg->getStatistiquesSortiesRP($date_debut, $date_fin);

        // Charger les vues
        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/direction/relation-publique', $data);
        $this->load->view('v1/components/layout/footer');
    }

    /**
     * Enregistrer une nouvelle sortie de caisse (Relation Publique)
     */
    public function saveRelationsPublique()
    {
        // Vérifier la méthode POST
        if ($this->input->method() !== 'post') {
            redirect('direction-relation-publique');
        }

        // Récupérer et nettoyer les données
        $beneficiaire = trim($this->input->post('beneficiaire'));
        $montant      = (float) $this->input->post('montant');
        $motif        = trim($this->input->post('motif'));
        $date_sortie  = $this->input->post('date_sortie');
        $autorise_par = $this->input->post('autorise_par');
        $reference    = trim($this->input->post('reference'));
        $observation  = trim($this->input->post('observation'));

        // Validation des données
        if (empty($beneficiaire) || empty($motif) || empty($date_sortie) || empty($autorise_par)) {
            $this->session->set_flashdata('error', 'Tous les champs obligatoires doivent être remplis.');
            redirect('direction-relation-publique');
        }

        if ($montant <= 0) {
            $this->session->set_flashdata('error', 'Le montant doit être supérieur à 0.');
            redirect('direction-relation-publique');
        }

        if ($montant < 1000) {
            $this->session->set_flashdata('error', 'Le montant minimum est de 1 000 BIF.');
            redirect('direction-relation-publique');
        }

        // Récupérer l'utilisateur connecté
        $user_id   = $this->session->userdata('user_id');
        $user_name = $this->session->userdata('username') ?? 'Inconnu';

        // Générer la référence si non fournie
        if (empty($reference)) {
            $reference = $this->dg->genererReferenceSortie();
        }

        // Préparer les données pour insertion
        $data = [
            'reference'         => $reference,
            'beneficiaire'      => $beneficiaire,
            'montant'           => $montant,
            'motif'             => $motif,
            'date_sortie'       => $date_sortie,
            'autorise_par'      => $autorise_par,
            'autorise_par_nom'  => $this->getLibelleAutorisation($autorise_par),
            'reference_doc'     => !empty($reference) ? $reference : null,
            'observation'       => !empty($observation) ? $observation : null,
            'status'            => 'valide',
            'company_id'        => 2,
            'created_by'        => $user_id,
            'created_by_nom'    => $user_name,
            'created_at'        => date('Y-m-d H:i:s')
        ];

        // Insérer dans la base de données
        $insert_id = $this->dg->insertSortieRelationPublique($data);

        if ($insert_id) {
            // Optionnel : Enregistrer aussi dans le livre de caisse principale
            $this->dg->enregistrerDansCaissePrincipale($data);

            $this->session->set_flashdata(
                'success',
                "Sortie de caisse enregistrée avec succès ! Référence : <strong>{$reference}</strong> - Montant : " .
                    number_format($montant, 0, ',', ' ') . " BIF"
            );
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de l\'enregistrement. Veuillez réessayer.');
        }

        redirect('direction-relation-publique');
    }

    /**
     * Obtenir le libellé de l'autorisation
     */
    private function getLibelleAutorisation($code)
    {
        $libelles = [
            'dg'    => 'Directeur Général',
            'daf'   => 'DAF / Finance',
            'admin' => 'Administrateur'
        ];
        return $libelles[$code] ?? $code;
    }
}
