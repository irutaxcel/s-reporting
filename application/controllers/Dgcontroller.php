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

    public function dashboard()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        if (!has_access('dg', 'direction-dashboard')) {
            show_error('Vous n\'avez pas accès à cette page.', 403, 'Accès refusé');
            return;
        }

        $annee = (int) $this->input->get('annee');
        if ($annee < 2000 || $annee > (int) date('Y') + 1) {
            $annee = (int) date('Y');
        }

        $data = [];
        $data['title']          = 'Tableau de bord DG';
        $data['annee']          = $annee;
        $data['kpi']            = $this->dg->getKpis($annee);
        $data['monthly']        = $this->dg->getMonthlyFinance($annee);
        $data['chantierStatus'] = $this->dg->getChantiersByStatus();
        $data['chantiers']      = $this->dg->getChantiersEnCours(8);
        $data['validations']    = $this->dg->getPendingValidations(6);
        $data['alertes']        = $this->dg->getAlertes();

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/direction/dashboard', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function indicateurPerformance()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        if (!has_access('dg', 'direction-indicateurs')) {
            show_error('Vous n\'avez pas accès à cette page.', 403, 'Accès refusé');
            return;
        }

        $annee = (int) $this->input->get('annee');
        if ($annee < 2000 || $annee > (int) date('Y') + 1) {
            $annee = (int) date('Y');
        }

        $data = [];
        $data['title']       = 'Indicateurs de performance';
        $data['annee']       = $annee;
        $data['perf']        = $this->dg->getPerfKpis($annee);
        $data['perfPrev']    = $this->dg->getPerfKpis($annee - 1);
        $data['snap']        = $this->dg->getSnapshotPerf($annee);
        $data['monthly']     = $this->dg->getMonthlyPaiements($annee);
        $data['monthlyPrev'] = $this->dg->getMonthlyPaiements($annee - 1);
        $data['categories']  = $this->dg->getDepensesParCategorie($annee);
        $data['decisions']   = $this->dg->getDecisionsDg($annee);
        $data['engins']      = $this->dg->getEnginsParEtat();
        $data['chantiers']   = $this->dg->getChantiersPerformance(15);

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/direction/indicateurPerformance', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function reportingGeneral()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        if (!has_access('dg', 'direction-reporting-general')) {
            show_error('Vous n\'avez pas accès à cette page.', 403, 'Accès refusé');
            return;
        }

        [$debut, $fin, $periode] = $this->resolvePeriode();
        $chantierId = (int) $this->input->get('chantier') ?: null;

        $data = [];
        $data['title']      = 'Reporting général';
        $data['debut']      = $debut;
        $data['fin']        = $fin;
        $data['periode']    = $periode;
        $data['chantierId'] = $chantierId;
        $data['listeChantiers'] = $this->dg->getReportChantiersList();
        $data['synthese']   = $this->dg->getReportSynthese($debut, $fin, $chantierId);
        $data['mensuel']    = $this->dg->getReportMensuel($debut, $fin, $chantierId);
        $data['parChantier'] = $this->dg->getReportParChantier($debut, $fin, $chantierId);
        $data['categories'] = $this->dg->getReportCategories($debut, $fin, $chantierId);
        $data['modes']      = $this->dg->getReportModesPaiement($debut, $fin, $chantierId);
        $data['topPaiements'] = $this->dg->getReportTopPaiements($debut, $fin, $chantierId, 10);

        $data['chantierNom'] = 'Tous les chantiers';
        foreach ($data['listeChantiers'] as $c) {
            if ((int) $c['id'] === $chantierId) {
                $data['chantierNom'] = $c['name'];
                break;
            }
        }

        if ($this->input->get('export') === 'csv') {
            $this->exportReportingCsv($data);
            return;
        }

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/direction/reportingGeneral', $data);
        $this->load->view('v1/components/layout/footer');
    }

    /**
     * Détermine la période du rapport à partir des paramètres GET.
     * @return array [date_debut, date_fin, code_periode]
     */
    private function resolvePeriode()
    {
        $periode = $this->input->get('periode');
        $today   = date('Y-m-d');

        switch ($periode) {
            case 'mois':
                $debut = date('Y-m-01');
                $fin   = $today;
                break;

            case 'trimestre':
                $moisDebut = (int) (floor((date('n') - 1) / 3) * 3 + 1);
                $debut = date('Y') . '-' . str_pad($moisDebut, 2, '0', STR_PAD_LEFT) . '-01';
                $fin   = $today;
                break;

            case 'annee_prec':
                $y     = (int) date('Y') - 1;
                $debut = "{$y}-01-01";
                $fin   = "{$y}-12-31";
                break;

            case 'personnalise':
                $debut = (string) $this->input->get('du');
                $fin   = (string) $this->input->get('au');
                break;

            default:
                $periode = 'annee';
                $debut   = date('Y-01-01');
                $fin     = $today;
        }

        $valide = function ($d) {
            $dt = DateTime::createFromFormat('Y-m-d', $d);
            return $dt && $dt->format('Y-m-d') === $d;
        };

        if (!$valide($debut) || !$valide($fin)) {
            return [date('Y-01-01'), $today, 'annee'];
        }
        if ($debut > $fin) {
            [$debut, $fin] = [$fin, $debut];
        }

        return [$debut, $fin, $periode];
    }

    /**
     * Export CSV du reporting (compatible Excel : BOM UTF-8 + séparateur ;)
     */
    private function exportReportingCsv(array $d)
    {
        $nom = 'reporting_general_' . $d['debut'] . '_' . $d['fin'] . '.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $nom . '"');
        header('Pragma: no-cache');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");

        $s = $d['synthese'];
        fputcsv($out, ['RAPPORT GÉNÉRAL D\'ACTIVITÉ'], ';');
        fputcsv($out, ['Période', date('d/m/Y', strtotime($d['debut'])) . ' au ' . date('d/m/Y', strtotime($d['fin']))], ';');
        fputcsv($out, ['Chantier', $d['chantierNom']], ';');
        fputcsv($out, ['Généré le', date('d/m/Y H:i')], ';');
        fputcsv($out, [], ';');

        fputcsv($out, ['SYNTHÈSE'], ';');
        fputcsv($out, ['Montant engagé (BIF)', $s['engage']], ';');
        fputcsv($out, ['Montant payé (BIF)', $s['paye']], ';');
        fputcsv($out, ['Reste à payer (BIF)', $s['reste']], ';');
        fputcsv($out, ['Nombre de demandes', $s['nb_demandes']], ';');
        fputcsv($out, ['Nombre de paiements', $s['nb_paiements']], ';');
        fputcsv($out, ['Demandes validées DG', $s['nb_approuvees']], ';');
        fputcsv($out, ['Demandes rejetées DG', $s['nb_rejetees']], ';');
        fputcsv($out, ['Demandes en attente DG', $s['nb_attente']], ';');
        fputcsv($out, [], ';');

        fputcsv($out, ['ÉVOLUTION MENSUELLE'], ';');
        fputcsv($out, ['Mois', 'Engagé (BIF)', 'Payé (BIF)', 'Écart (BIF)'], ';');
        foreach ($d['mensuel'] as $m) {
            fputcsv($out, [$m['label'], $m['engage'], $m['paye'], $m['engage'] - $m['paye']], ';');
        }
        fputcsv($out, [], ';');

        fputcsv($out, ['SITUATION PAR CHANTIER'], ';');
        fputcsv($out, ['Référence', 'Chantier', 'Statut', 'Budget', 'Engagé période', 'Payé période', 'Payé cumulé', 'Reste budget', '% consommé'], ';');
        foreach ($d['parChantier'] as $c) {
            fputcsv($out, [
                $c['ref_chantier'],
                $c['name'],
                $c['status'],
                $c['budget'],
                $c['engage'],
                $c['paye'],
                $c['cumul'],
                $c['reste_budget'],
                $c['pct'] === null ? '' : str_replace('.', ',', $c['pct']),
            ], ';');
        }
        fputcsv($out, [], ';');

        fputcsv($out, ['TOP PAIEMENTS'], ';');
        fputcsv($out, ['N° paiement', 'Date', 'Chantier', 'Objet', 'Mode', 'Montant (BIF)'], ';');
        foreach ($d['topPaiements'] as $p) {
            fputcsv($out, [
                $p['payment_number'],
                date('d/m/Y', strtotime($p['payment_date'])),
                $p['chantier'],
                $p['summary'],
                $p['payment_mode'],
                $p['amount_paid'],
            ], ';');
        }

        fclose($out);
        exit;
    }

    public function reportingAnalytique()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        if (!has_access('dg', 'direction-reporting-analytique')) {
            show_error('Vous n\'avez pas accès à cette page.', 403, 'Accès refusé');
            return;
        }

        [$debut, $fin, $periode] = $this->resolvePeriode();
        $chantierId = (int) $this->input->get('chantier') ?: null;

        $dimensions = [
            'chantier'  => 'Chantier',
            'categorie' => 'Catégorie',
            'demandeur' => 'Demandeur',
            'acheteur'  => 'Acheteur',
            'mode'      => 'Mode de paiement',
        ];

        $dim = (string) $this->input->get('dim');
        if (!isset($dimensions[$dim])) {
            $dim = 'chantier';
        }

        $mesure = $this->input->get('mesure') === 'engage' ? 'engage' : 'paye';
        if ($dim === 'mode') {
            $mesure = 'paye'; // le mode de paiement n'existe que sur les paiements
        }

        $colDim   = $dim === 'categorie' ? 'chantier' : 'categorie';
        $analyse  = $this->dg->getAnalyseDimension($dim, $mesure, $debut, $fin, $chantierId);
        $top5     = array_slice(array_column($analyse['lignes'], 'libelle'), 0, 5);

        $data = [];
        $data['title']          = 'Analytique';
        $data['debut']          = $debut;
        $data['fin']            = $fin;
        $data['periode']        = $periode;
        $data['chantierId']     = $chantierId;
        $data['dim']            = $dim;
        $data['colDim']         = $colDim;
        $data['mesure']         = $mesure;
        $data['dimensions']     = $dimensions;
        $data['listeChantiers'] = $this->dg->getReportChantiersList();
        $data['analyse']        = $analyse;
        $data['matrice']        = $this->dg->getAnalyseMatrice($dim, $colDim, $mesure, $debut, $fin, $chantierId);
        $data['tendance']       = $this->dg->getAnalyseTendance($dim, $mesure, $debut, $fin, $chantierId, $top5);

        $data['chantierNom'] = 'Tous les chantiers';
        foreach ($data['listeChantiers'] as $c) {
            if ((int) $c['id'] === $chantierId) {
                $data['chantierNom'] = $c['name'];
                break;
            }
        }

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/direction/reportingAnalytique', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function statistique()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        if (!has_access('dg', 'direction-statistiques')) {
            show_error('Vous n\'avez pas accès à cette page.', 403, 'Accès refusé');
            return;
        }

        $nbAnnees = (int) $this->input->get('annees');
        if (!in_array($nbAnnees, [3, 5, 7], true)) {
            $nbAnnees = 5;
        }

        $mesure     = $this->input->get('mesure') === 'engage' ? 'engage' : 'paye';
        $chantierId = (int) $this->input->get('chantier') ?: null;
        $anneeFin   = (int) date('Y');
        $anneeDebut = $anneeFin - $nbAnnees + 1;

        $data = [];
        $data['title']          = 'Statistiques';
        $data['nbAnnees']       = $nbAnnees;
        $data['mesure']         = $mesure;
        $data['chantierId']     = $chantierId;
        $data['anneeDebut']     = $anneeDebut;
        $data['anneeFin']       = $anneeFin;
        $data['listeChantiers'] = $this->dg->getReportChantiersList();
        $data['stats']          = $this->dg->getStatistiques($mesure, $anneeDebut, $anneeFin, $chantierId);
        $data['descN']          = $this->dg->getStatsMontants($mesure, $anneeFin, $chantierId);
        $data['descPrev']       = $this->dg->getStatsMontants($mesure, $anneeFin - 1, $chantierId);
        $data['activite']       = $this->dg->getActiviteAnnuelle($anneeDebut, $anneeFin);

        $data['chantierNom'] = 'Tous les chantiers';
        foreach ($data['listeChantiers'] as $c) {
            if ((int) $c['id'] === $chantierId) {
                $data['chantierNom'] = $c['name'];
                break;
            }
        }

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/direction/statistique', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function projectFollow()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        if (!has_access('dg', 'direction-projets')) {
            show_error('Vous n\'avez pas accès à cette page.', 403, 'Accès refusé');
            return;
        }

        $tri = (string) $this->input->get('tri');
        if (!in_array($tri, ['sante', 'budget', 'nom', 'fin'], true)) {
            $tri = 'sante';
        }

        $filtres = [
            'q'      => trim((string) $this->input->get('q')),
            'statut' => $this->input->get('statut') === 'tous' ? 'tous' : 'actifs',
            'sante'  => (string) $this->input->get('sante'),
            'tri'    => $tri,
        ];

        $data = [];
        $data['title']   = 'Suivi des projets';
        $data['filtres'] = $filtres;
        $data['suivi']   = $this->dg->getSuiviProjets($filtres);

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/direction/projectFollow', $data);
        $this->load->view('v1/components/layout/footer');
    }

    public function syntheseDemandes()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

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
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

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

    // public function directionArchives()
    // {
    //     if (!$this->session->userdata('user_id')) {
    //         redirect('sign-in');
    //         return;
    //     }

    //     $data['title'] = 'Archives';


    //     // Charger les vues
    //     $this->load->view('v1/components/layout/header', $data);
    //     $this->load->view('v1/components/layout/sidebar');
    //     $this->load->view('v1/components/modules/direction/direction-archives', $data);
    //     $this->load->view('v1/components/layout/footer');
    // }

    /**
     * Page Relation Publique
     */
    public function directionRelationPublique()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        $data['title'] = 'Relation Publique';

        // Récupérer les filtres
        $data['filtre_date_debut'] = $this->input->get('date_debut') ?: date('Y-m-01');
        $data['filtre_date_fin'] = $this->input->get('date_fin') ?: date('Y-m-d');
        $data['filtre_beneficiaire'] = $this->input->get('beneficiaire');
        $data['filtre_statut'] = $this->input->get('statut');

        // Récupérer les sorties avec filtres
        $data['sorties'] = $this->dg->getSortiesRelationPublique(
            $data['filtre_date_debut'],
            $data['filtre_date_fin'],
            $data['filtre_statut'],
            $data['filtre_beneficiaire']
        );

        // Récupérer les statistiques
        $data['statistiques'] = $this->dg->getStatistiquesSortiesRP(
            $data['filtre_date_debut'],
            $data['filtre_date_fin']
        );

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

    /**
     * Supprimer une sortie de caisse Relation Publique
     */
    public function deleteSortieRP()
    {
        // Vérifier que c'est une requête AJAX
        if (!$this->input->is_ajax_request()) {
            echo json_encode(['success' => false, 'message' => 'Requête invalide']);
            exit;
        }

        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID invalide']);
            exit;
        }

        // Récupérer les détails de la sortie avant suppression
        $sortie = $this->dg->getSortieRPById($id);

        if (!$sortie) {
            echo json_encode(['success' => false, 'message' => 'Sortie non trouvée']);
            exit;
        }

        // Supprimer la sortie et mettre à jour les tables
        $result = $this->dg->deleteSortieRP($id, $sortie);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => "La sortie {$sortie->reference} a été supprimée avec succès. Montant restitué : " .
                    number_format($sortie->montant, 0, ',', ' ') . " BIF"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la suppression. Veuillez réessayer.'
            ]);
        }
    }

    public function directionArchives()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('sign-in');
            return;
        }

        if (!has_access('dg', 'direction-archives')) {
            show_error('Vous n\'avez pas accès à cette page.', 403, 'Accès refusé');
            return;
        }

        $options = $this->dg->getArchivesOptions();
        $f = $this->archivesFiltres($options);

        if ($this->input->get('export') === 'xlsx') {
            $this->exportArchivesExcel($f);
            return;
        }

        $parPage = (int) $this->input->get('par_page');
        if (!in_array($parPage, [25, 50, 100], true)) {
            $parPage = 25;
        }

        $total = $this->dg->countArchives($f);
        $pages = max(1, (int) ceil($total / $parPage));
        $page  = min(max(1, (int) $this->input->get('page')), $pages);

        $rows = $this->dg->getArchives($f, $parPage, ($page - 1) * $parPage);

        $data = [];
        $data['title']          = 'Archives';
        $data['f']              = $f;
        $data['options']        = $options;
        $data['listeChantiers'] = $this->dg->getReportChantiersList();
        $data['rows']           = $rows;
        $data['items']          = $this->dg->getArchivesItems(array_column($rows, 'id'));
        $data['totaux']         = $this->dg->getArchivesTotaux($f);
        $data['colsItems']      = $this->dg->getColonnesItems();
        $data['page']           = $page;
        $data['pages']          = $pages;
        $data['parPage']        = $parPage;
        $data['total']          = $total;

        $this->load->view('v1/components/layout/header', $data);
        $this->load->view('v1/components/layout/sidebar');
        $this->load->view('v1/components/modules/direction/direction-archives', $data);
        $this->load->view('v1/components/layout/footer');
    }

    /** Lit et valide les filtres des archives */
    private function archivesFiltres(array $options)
    {
        $date = function ($d) {
            $d = (string) $d;
            $dt = DateTime::createFromFormat('Y-m-d', $d);
            return ($dt && $dt->format('Y-m-d') === $d) ? $d : '';
        };

        $dg = (string) $this->input->get('dg');
        $paiement = (string) $this->input->get('paiement');
        $workflow = (string) $this->input->get('workflow');
        $categorie = (string) $this->input->get('categorie');

        return [
            'q'         => trim((string) $this->input->get('q')),
            'du'        => $date($this->input->get('du')),
            'au'        => $date($this->input->get('au')),
            'chantier'  => (int) $this->input->get('chantier') ?: null,
            'dg'        => in_array($dg, ['en_attente', 'approuve', 'rejete'], true) ? $dg : '',
            'paiement'  => in_array($paiement, ['non_paye', 'partiel', 'paye'], true) ? $paiement : '',
            'workflow'  => in_array($workflow, $options['workflows'], true) ? $workflow : '',
            'categorie' => in_array($categorie, $options['categories'], true) ? $categorie : '',
        ];
    }

    /** Export Excel (.xlsx) : Demandes + Articles + Filtres */
    private function exportArchivesExcel(array $f)
    {
        @set_time_limit(120);

        $rows  = $this->dg->getArchives($f, 20000, 0);
        $items = $this->dg->getArchivesItems(array_column($rows, 'id'));

        $nice = function ($s) {
            return $s === null || $s === '' ? '' : ucfirst(str_replace('_', ' ', (string) $s));
        };
        $paiementLbl = ['non_paye' => 'Non payé', 'partiel' => 'Partiel', 'paye' => 'Payé'];

        // Onglet 1 : Demandes
        $lignesDemandes = [];
        foreach ($rows as $r) {
            $lignesDemandes[] = [
                $r['reference'],
                $r['date_demande'],
                $r['chantier_nom'] ?: '',
                $r['destination_chantier'],
                $nice($r['category_type']),
                $r['requested_by'],
                $r['buyer_name'],
                (int) $r['nb_articles'],
                (float) $r['total_amount'],
                $nice($r['dg_status']),
                $nice($r['workflow_status']),
                $paiementLbl[$r['payment_status']] ?? $nice($r['payment_status']),
                $r['numeros'],
                (float) $r['paye'],
                $r['notes'],
            ];
        }

        // Onglet 2 : Articles
        $lignesArticles = [];
        foreach ($rows as $r) {
            foreach ($items[$r['id']] ?? [] as $it) {
                $lignesArticles[] = [
                    $r['reference'],
                    $r['date_demande'],
                    $r['chantier_nom'] ?: $r['destination_chantier'],
                    $it['designation'],
                    $it['quantite'],
                    $it['unite'],
                    $it['pu'],
                    $it['total'],
                ];
            }
        }

        // Onglet 3 : Filtres utilisés
        $chantierNom = 'Tous';
        if ($f['chantier']) {
            foreach ($this->dg->getReportChantiersList() as $c) {
                if ((int) $c['id'] === $f['chantier']) {
                    $chantierNom = $c['name'];
                    break;
                }
            }
        }
        $dgLbl = ['en_attente' => 'En attente', 'approuve' => 'Validée', 'rejete' => 'Rejetée'];
        $filtres = [
            ['Export généré le', date('d/m/Y H:i')],
            ['Par', trim($this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'))],
            ['Période du', $f['du'] ? date('d/m/Y', strtotime($f['du'])) : 'Début'],
            ['Période au', $f['au'] ? date('d/m/Y', strtotime($f['au'])) : "Aujourd'hui"],
            ['Chantier', $chantierNom],
            ['Recherche', $f['q'] ?: '—'],
            ['Décision DG', $dgLbl[$f['dg']] ?? 'Toutes'],
            ['Paiement', $paiementLbl[$f['paiement']] ?? 'Tous'],
            ['Workflow', $f['workflow'] ? $nice($f['workflow']) : 'Tous'],
            ['Catégorie', $f['categorie'] ? $nice($f['categorie']) : 'Toutes'],
            ['Nombre de demandes', count($rows)],
            ['Nombre d\'articles', count($lignesArticles)],
        ];

        $this->load->library('simple_xlsx');
        $this->simple_xlsx
            ->addSheet(
                'Demandes',
                [
                    'N° demande',
                    'Date',
                    'Chantier',
                    'Destination',
                    'Catégorie',
                    'Demandeur',
                    'Acheteur',
                    'Nb articles',
                    'Montant total (BIF)',
                    'Décision DG',
                    'Workflow',
                    'Paiement',
                    'N° bon(s) de paiement',
                    'Montant payé (BIF)',
                    'Notes'
                ],
                $lignesDemandes,
                [
                    'string',
                    'date',
                    'string',
                    'string',
                    'string',
                    'string',
                    'string',
                    'int',
                    'money',
                    'string',
                    'string',
                    'string',
                    'string',
                    'money',
                    'string'
                ],
                [13, 12, 28, 28, 14, 22, 22, 11, 18, 14, 14, 12, 20, 18, 40],
                [8, 13]
            )
            ->addSheet(
                'Articles',
                ['N° demande', 'Date', 'Chantier', 'Désignation', 'Quantité', 'Unité', 'Prix unitaire (BIF)', 'Prix total (BIF)'],
                $lignesArticles,
                ['string', 'date', 'string', 'string', 'decimal', 'string', 'money', 'money'],
                [13, 12, 28, 45, 11, 10, 18, 18],
                [7]
            )
            ->addSheet('Filtres', ['Critère', 'Valeur'], $filtres, ['string', 'string'], [24, 40])
            ->download('archives_demandes_achat_' . date('Ymd_His') . '.xlsx');

        exit;
    }
}