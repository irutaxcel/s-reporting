<?php
/* =====================================================================
   RÉFÉRENTIELS — partagés par la création, la modification et les filtres
   ===================================================================== */
$RH = [
    'departements' => [
        'DIRECTION GENERALE',
        'DIRECTION ADMINISTRATIVE ET FINANCIERE',
        'DIRECTION TECHNIQUE',
        'RH',
        'COMPTABILITE',
        'LOGISTIQUE',
        'BUREAU TECHNIQUE',
        'ARCHITECTURE',
        'INFORMATIQUE',
        'COMMERCE/MARKETING/JURIDIQUE/DESIGNER',
        'SUIVI CHANTIERS',
        'CHARROI',
        'PLANTON+GARDIEN+CUISINIER',
    ],
    'sites'        => ['Siège (Bujumbura)', 'Chantiers'],
    'sexes'        => ['Masculin' => 'M — Masculin', 'Féminin' => 'F — Féminin'],
    'nationalites' => [
        'Burundaise' => 'B — Burundaise',
        'Rwandaise' => 'Rwandaise',
        'Congolaise (RDC)' => 'Congolaise (RDC)',
        'Tanzanienne' => 'Tanzanienne',
        'Ougandaise' => 'Ougandaise',
        'Kényane' => 'Kényane',
        'Autre' => 'Autre',
    ],
    'categories'   => ['Bureau' => 'Personnel de bureau', 'Chantier' => 'Ouvrier de chantier'],
    'etats_civils' => ['Célibataire', 'Marié(e)', 'Divorcé(e)', 'Veuf(ve)'],
    'contrats'     => ['CDI', 'CDD', 'Stage'],
    'essais'       => ['3 mois', '6 mois', 'Aucune'],
    'paiements'    => ['Virement bancaire', 'Espèces', 'Mobile money'],
    'causes'       => ['Fin de contrat', 'Démission', 'Licenciement', 'Retraite', 'Décès', 'Abandon de poste', 'Autre'],
    'statuts'      => ['Actif', 'En congé', 'Suspendu', 'Fin de contrat'],
];

/** Génère des <option>. Tableau associatif = [valeur => libellé] */
$rh_options = function (array $liste, $selection = null) {
    $assoc = array_keys($liste) !== range(0, count($liste) - 1);
    $html  = '';
    foreach ($liste as $k => $v) {
        $val   = $assoc ? $k : $v;
        $html .= '<option value="' . html_escape($val) . '"'
            . ((string) $val === (string) $selection ? ' selected' : '') . '>'
            . html_escape($v) . '</option>';
    }
    return $html;
};

/* =====================================================================
   INDICATEURS
   ===================================================================== */
$aujourdhui = new DateTime('today');
$en_poste   = array_filter($employes, fn($e) => $e->statut !== 'Fin de contrat' && empty($e->date_sortie));
$nb_sortis  = count($employes) - count($en_poste);
$nb_actifs  = count(array_filter($en_poste, fn($e) => in_array($e->statut, ['Actif', 'En congé'])));
$nb_conge   = count(array_filter($en_poste, fn($e) => $e->statut === 'En congé'));
$nb_echus   = 0;
$nb_bientot = 0;
foreach ($en_poste as $e) {
    if ($e->type_contrat === 'CDI' || empty($e->date_fin_contrat)) continue;
    $j = (int) $aujourdhui->diff(new DateTime($e->date_fin_contrat))->format('%r%a');
    if ($j < 0)        $nb_echus++;
    elseif ($j <= 30)  $nb_bientot++;
}

/* Valeurs réellement présentes en base, pour les filtres */
$filtre_deps  = array_unique(array_filter(array_map(fn($e) => $e->departement, $employes)));
$filtre_sites = array_unique(array_filter(array_map(fn($e) => $e->site_affectation, $employes)));
sort($filtre_deps);
sort($filtre_sites);

/* =====================================================================
   GABARIT DU FORMULAIRE — utilisé par la création ('new') et la modification ('edit')
   ===================================================================== */
$rh_form_body = function ($p, $edit) use ($RH, $rh_options, $next_matricule) { ?>

    <!-- ===== 1. IDENTIFICATION ===== -->
    <h6 class="section-title">1. Identification du travailleur</h6>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group"><label>N° d'ordre / Matricule</label>
                <input type="text" id="<?= $p ?>Matricule" class="form-control" disabled
                    value="<?= $edit ? '' : html_escape($next_matricule) . ' (auto)' ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group"><label>Nom *</label>
                <input type="text" name="nom" class="form-control text-uppercase" maxlength="100" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group"><label>Prénom(s) *</label>
                <input type="text" name="prenoms" class="form-control" maxlength="100" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group"><label>Sexe *</label>
                <select name="sexe" class="form-control" required><?= $rh_options($RH['sexes']) ?></select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group"><label>Date de naissance</label>
                <input type="date" name="date_naissance" id="<?= $p ?>DateNaissance" class="form-control"
                    max="<?= date('Y-m-d') ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group"><label>Âge à l'embauche</label>
                <input type="text" id="<?= $p ?>Age" class="form-control" placeholder="Naissance + date d'entrée" disabled>
                <small id="<?= $p ?>AgeAlerte" class="text-danger d-none">Mineur à l'embauche (&lt; 18 ans)</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group"><label>Nationalité *</label>
                <select name="nationalite" class="form-control"
                    required><?= $rh_options($RH['nationalites'], 'Burundaise') ?></select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group"><label>N° CNI</label>
                <input type="text" name="cnid" class="form-control" maxlength="30">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group"><label>État civil</label>
                <select name="etat_civil" class="form-control"><?= $rh_options($RH['etats_civils']) ?></select>
            </div>
        </div>
    </div>

    <!-- ===== 2. EMPLOI ===== -->
    <h6 class="section-title mt-3">2. Emploi &amp; affectation</h6>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label>Qualification professionnelle *</label>
                <input type="text" name="fonction" class="form-control" maxlength="100"
                    placeholder="Ex : Comptable, Chauffeur, Ingénieur…" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>Date d'entrée *</label>
                <input type="date" name="date_embauche" id="<?= $p ?>DateEntree" class="form-control" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>Catégorie</label>
                <select name="categorie" class="form-control"><?= $rh_options($RH['categories']) ?></select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>Site d'affectation</label>
                <select name="site_affectation" class="form-control"><?= $rh_options($RH['sites']) ?></select>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group"><label>Département</label>
                <select name="departement" class="form-control"><?= $rh_options($RH['departements']) ?></select>
            </div>
        </div>
    </div>

    <!-- ===== 3. PROTECTION SOCIALE ===== -->
    <h6 class="section-title mt-3">3. Protection sociale</h6>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label>N° INSS</label>
                <input type="text" name="matricule_inss" class="form-control" maxlength="30">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>Assurance Maladie-Maternité</label>
                <input type="text" name="assurance_maladie" class="form-control" maxlength="100" list="rhListeAssurances"
                    placeholder="Choisir ou saisir…">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>N° contribuable (OBR)</label>
                <input type="text" name="numero_contribuable" class="form-control" maxlength="30">
            </div>
        </div>
    </div>

    <!-- ===== 4. CONTACT ===== -->
    <h6 class="section-title mt-3">4. Contact</h6>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label>N° téléphone</label>
                <input type="text" name="telephone" class="form-control" maxlength="30" placeholder="+257 …">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>E-mail professionnel</label>
                <input type="email" name="email" class="form-control" maxlength="120">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>Adresse</label>
                <input type="text" name="adresse" class="form-control" maxlength="255">
            </div>
        </div>
    </div>

    <!-- ===== 5. CONTRAT & PAIE ===== -->
    <h6 class="section-title mt-3">5. Contrat &amp; paie
        <small class="text-muted font-weight-normal">(hors registre — utilisé par la paie et les alertes)</small>
    </h6>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group"><label>Type de contrat</label>
                <select name="type_contrat" id="<?= $p ?>TypeContrat"
                    class="form-control"><?= $rh_options($RH['contrats']) ?></select>
            </div>
        </div>
        <div class="col-md-4" id="<?= $p ?>BlocFin" style="display:none">
            <div class="form-group"><label>Fin de contrat (CDD) *</label>
                <input type="date" name="date_fin_contrat" id="<?= $p ?>FinContrat" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>Période d'essai</label>
                <select name="periode_essai" class="form-control"><?= $rh_options($RH['essais']) ?></select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>Salaire BRUT (BIF) *</label>
                <input type="number" name="salaire_base" class="form-control" min="0" step="1" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>Mode de paiement</label>
                <select name="mode_paiement" class="form-control"><?= $rh_options($RH['paiements']) ?></select>
            </div>
        </div>
    </div>

    <!-- ===== 6. STATUT & SORTIE ===== -->
    <h6 class="section-title mt-3">6. <?= $edit ? 'Statut &amp; sortie' : 'Sortie' ?></h6>
    <div class="row">
        <?php if ($edit): ?>
            <div class="col-md-4">
                <div class="form-group"><label>Statut</label>
                    <select name="statut" id="editStatut" class="form-control">
                        <option>Actif</option>
                        <option>En congé</option>
                        <option>Suspendu</option>
                        <option value="Fin de contrat" hidden>Fin de contrat</option>
                    </select>
                    <small class="text-muted">Passe en « Fin de contrat » si une sortie est déclarée.</small>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-8 d-flex align-items-center mb-2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="<?= $p ?>ChkSortie">
                <label class="custom-control-label" for="<?= $p ?>ChkSortie">
                    <?= $edit ? "L'employé a quitté l'entreprise" : "Cet employé a déjà quitté l'entreprise (reprise du registre papier)" ?>
                </label>
            </div>
        </div>
    </div>
    <div class="row" id="<?= $p ?>BlocSortie" style="display:none">
        <div class="col-md-4">
            <div class="form-group"><label>Date de sortie *</label>
                <input type="date" name="date_sortie" id="<?= $p ?>DateSortie" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"><label>Cause de cessation *</label>
                <select name="cause_cessation" id="<?= $p ?>Cause" class="form-control">
                    <option value="">— Choisir —</option><?= $rh_options($RH['causes']) ?>
                </select>
            </div>
        </div>
    </div>

    <!-- ===== 7. DOCUMENTS ===== -->
    <h6 class="section-title mt-3">7. Documents
        <?php if ($edit): ?><small class="text-muted font-weight-normal">(laisser vide pour conserver
                l'actuel)</small><?php endif; ?></h6>
    <div class="row">
        <?php foreach (
            [
                'doc_cnid'    => ['Copie CNI', 'Cnid'],
                'doc_photo'   => ["Photo d'identité", 'Photo'],
                'doc_contrat' => ['Contrat signé', 'Contrat'],
                'doc_cv'      => ['CV / Diplômes', 'Cv'],
            ] as $champ => [$libelle, $suffixe]
        ): ?>
            <div class="col-md-3">
                <div class="form-group"><label><?= $libelle ?></label>
                    <?php if ($edit): ?>
                        <small class="d-block text-muted mb-1 text-truncate" id="docActuel_<?= $champ ?>">Aucun fichier</small>
                    <?php endif; ?>
                    <div class="custom-file">
                        <input type="file" name="<?= $champ ?>" class="custom-file-input" id="<?= $p ?>Doc<?= $suffixe ?>"
                            <?= $champ === 'doc_photo' ? 'accept="image/*"' : 'accept=".pdf,image/*"' ?>>
                        <label class="custom-file-label"
                            for="<?= $p ?>Doc<?= $suffixe ?>"><?= $edit ? 'Remplacer…' : 'Choisir…' ?></label>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php };

/* Messages flash (lus une seule fois) */
$flash_ok  = $this->session->flashdata('success');
$flash_err = $this->session->flashdata('error');
$JSON_SAFE = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_INVALID_UTF8_SUBSTITUTE;
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= html_escape($title) ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= html_escape($title) ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- =================================================================
                 STYLES DE LA PAGE
                 ================================================================= -->
            <style>
                /* --- Généraux --- */
                .avatar-initials {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 34px;
                    height: 34px;
                    border-radius: 50%;
                    color: #fff;
                    font-weight: 600;
                    font-size: .78rem;
                    flex-shrink: 0;
                }

                .section-title {
                    color: #1f7a5c;
                    font-weight: 700;
                    border-bottom: 2px solid #e9ecef;
                    padding-bottom: .4rem;
                }

                .custom-file-label {
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .custom-file-label::after {
                    content: "Parcourir";
                }

                .custom-file-label.has-file {
                    color: #1f7a5c;
                    font-weight: 600;
                }

                /* --- Tableau registre --- */
                .table-registre td {
                    vertical-align: middle;
                    white-space: normal;
                }

                .table-registre th {
                    white-space: nowrap;
                    font-size: .82rem;
                    text-transform: uppercase;
                    letter-spacing: .02em;
                    color: #495057;
                }

                .table-registre .nowrap {
                    white-space: nowrap;
                }

                .table-registre .cell-sub {
                    font-size: .76rem;
                    color: #6c757d;
                    line-height: 1.35;
                }

                .table-registre .cell-sub i {
                    width: 14px;
                    text-align: center;
                }

                .vide {
                    color: #ced4da;
                    font-style: italic;
                }

                .chip {
                    display: inline-block;
                    padding: .05rem .45rem;
                    border-radius: 10px;
                    background: #eef5f2;
                    color: #1f7a5c;
                    font-size: .7rem;
                    font-weight: 600;
                    margin-right: .2rem;
                }

                .chip-gris {
                    background: #f1f3f5;
                    color: #6c757d;
                }

                tr.row-sorti {
                    background: #fafafa !important;
                }

                tr.row-sorti td:not(:last-child) {
                    opacity: .7;
                }

                /* --- Profil --- */
                .profil-entete {
                    background: linear-gradient(135deg, #f3faf7 0%, #fff 70%);
                    border-radius: 10px;
                    padding: 1.1rem 1.25rem;
                    border: 1px solid #e3f1eb;
                }

                .profil-photo img,
                .profil-photo .avatar-initials {
                    width: 92px;
                    height: 92px;
                    border-radius: 50%;
                    object-fit: cover;
                    font-size: 2rem;
                    border: 3px solid #fff;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
                }

                .profil-kpi {
                    text-align: center;
                    padding: .3rem .9rem;
                    border-left: 1px solid #e3f1eb;
                }

                .profil-kpi .val {
                    font-size: 1.15rem;
                    font-weight: 700;
                    color: #1f7a5c;
                    line-height: 1.1;
                }

                .profil-kpi .lbl {
                    font-size: .7rem;
                    text-transform: uppercase;
                    color: #6c757d;
                    letter-spacing: .03em;
                }

                .profil-card {
                    border: 1px solid #e9ecef;
                    border-radius: 8px;
                    padding: .9rem 1rem;
                    height: 100%;
                    background: #fff;
                }

                .profil-card h6 {
                    color: #1f7a5c;
                    font-weight: 700;
                    font-size: .85rem;
                    text-transform: uppercase;
                    letter-spacing: .03em;
                    margin-bottom: .75rem;
                }

                .profil-dl dt {
                    font-weight: 500;
                    color: #6c757d;
                    font-size: .8rem;
                }

                .profil-dl dd {
                    font-weight: 600;
                    font-size: .88rem;
                    margin-bottom: .45rem;
                    word-break: break-word;
                }

                .profil-dl dd.vide {
                    font-weight: 400;
                }

                .doc-tile {
                    border: 1px dashed #ced4da;
                    border-radius: 8px;
                    padding: 1rem;
                    text-align: center;
                    height: 100%;
                }

                .doc-tile.ok {
                    border-style: solid;
                    border-color: #b8dfcf;
                    background: #f6fbf9;
                }

                .doc-tile i.fa-2x {
                    margin-bottom: .5rem;
                }

                .doc-tile img {
                    max-width: 100%;
                    max-height: 110px;
                    border-radius: 6px;
                    margin-bottom: .5rem;
                    object-fit: cover;
                }

                #profilTabs .nav-link {
                    font-weight: 600;
                    color: #6c757d;
                }

                #profilTabs .nav-link.active {
                    color: #1f7a5c;
                    border-bottom: 3px solid #1f7a5c;
                }

                /* --- Impression --- */
                @media print {

                    .main-sidebar,
                    .main-header,
                    .main-footer,
                    .content-header,
                    .info-box,
                    .modal,
                    .rh-filtres,
                    .rh-actions-liste,
                    .col-actions,
                    .card-footer {
                        display: none !important;
                    }

                    .content-wrapper {
                        margin-left: 0 !important;
                    }

                    .table-registre {
                        font-size: 10px;
                    }

                    .table-registre tr {
                        page-break-inside: avoid;
                    }
                }
            </style>

            <!-- =================================================================
                 1. INDICATEURS
                 ================================================================= -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Effectif en poste</span>
                            <span class="info-box-number"><?= count($en_poste) ?></span>
                            <span class="progress-description"><?= $nb_sortis ?> sorti<?= $nb_sortis > 1 ? 's' : '' ?>
                                au registre</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-file-contract"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Contrats actifs</span>
                            <span class="info-box-number"><?= $nb_actifs ?></span>
                            <span class="progress-description">Employés en activité</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-umbrella-beach"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">En congé</span>
                            <span class="info-box-number"><?= $nb_conge ?></span>
                            <span class="progress-description">Absences en cours</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Alertes contrats</span>
                            <span class="info-box-number"><?= $nb_echus + $nb_bientot ?></span>
                            <span class="progress-description"><?= $nb_echus ?> échu<?= $nb_echus > 1 ? 's' : '' ?> ·
                                <?= $nb_bientot ?> sous 30 j</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =================================================================
                 2. REGISTRE DES EMPLOYÉS
                 ================================================================= -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="card-title mb-0"><i class="fas fa-id-badge mr-1 text-success"></i> Registre des
                            employés</h3>
                        <div class="rh-actions-liste">
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-download mr-1"></i> Exporter
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" id="btnExportCsv"><i
                                            class="fas fa-file-excel mr-2 text-success"></i>Excel (CSV)</a>
                                    <a class="dropdown-item" href="#" id="btnExportPdf"><i
                                            class="fas fa-file-pdf mr-2 text-danger"></i>PDF</a>
                                    <a class="dropdown-item" href="#" id="btnImprimer"><i
                                            class="fas fa-print mr-2 text-secondary"></i>Imprimer</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#modalNouvelEmploye">
                                <i class="fas fa-user-plus mr-1"></i> Nouvel employé
                            </button>
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div class="row mt-3 rh-filtres">
                        <div class="col-lg-4 col-md-12 mb-2">
                            <div class="input-group">
                                <input type="search" id="searchInput" class="form-control"
                                    placeholder="Rechercher (nom, matricule, fonction, INSS, CNI, téléphone…)">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-search"></i></span></div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 mb-2">
                            <select id="fDep" class="form-control">
                                <option value="">Département : tous</option><?= $rh_options($filtre_deps) ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 mb-2">
                            <select id="fSite" class="form-control">
                                <option value="">Site : tous</option><?= $rh_options($filtre_sites) ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 mb-2">
                            <select id="fContrat" class="form-control">
                                <option value="">Contrat : tous</option><?= $rh_options($RH['contrats']) ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 mb-2">
                            <select id="fStatut" class="form-control">
                                <option value="">Statut : tous</option>
                                <option value="__presents" selected>En poste (hors sortis)</option>
                                <?= $rh_options($RH['statuts']) ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped table-registre mb-0" id="tableEmployes">
                        <thead>
                            <tr>
                                <th>Matricule</th>
                                <th>Employé</th>
                                <th>Qualification &amp; affectation</th>
                                <th>Protection sociale</th>
                                <th>Contrat</th>
                                <th>Entrée</th>
                                <th>Statut</th>
                                <th class="text-right col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $couleurs      = ['#1f7a5c', '#2c8a69', '#34608c', '#7a4f1f', '#8a3033', '#6c757d'];
                            $badge_contrat = ['CDI' => 'success', 'CDD' => 'warning', 'Stage' => 'info'];
                            $badge_statut  = ['Actif' => 'success', 'En congé' => 'info', 'Suspendu' => 'warning', 'Fin de contrat' => 'secondary'];
                            $vide          = '<span class="vide">—</span>';

                            if (!empty($employes)):
                                foreach ($employes as $emp):
                                    $initiales = mb_strtoupper(mb_substr($emp->prenoms, 0, 1) . mb_substr($emp->nom, 0, 1));
                                    $couleur   = $couleurs[$emp->employe_id % count($couleurs)];
                                    $sorti     = !empty($emp->date_sortie) || $emp->statut === 'Fin de contrat';

                                    // Âge à l'embauche & ancienneté (arrêtée à la sortie)
                                    $emb     = new DateTime($emp->date_embauche);
                                    $age_emb = !empty($emp->date_naissance) ? (new DateTime($emp->date_naissance))->diff($emb)->y : null;
                                    $ref     = !empty($emp->date_sortie) ? new DateTime($emp->date_sortie) : $aujourdhui;
                                    $diff    = $emb->diff($ref);
                                    $anciennete = $diff->y >= 1
                                        ? $diff->y . ' an' . ($diff->y > 1 ? 's' : '') . ($diff->m ? ' ' . $diff->m . ' m' : '')
                                        : ($diff->m >= 1 ? $diff->m . ' mois' : $diff->days . ' j');

                                    // Échéance du contrat
                                    $echeance = '';
                                    if (!empty($emp->date_fin_contrat) && $emp->type_contrat !== 'CDI') {
                                        $jours = (int) $aujourdhui->diff(new DateTime($emp->date_fin_contrat))->format('%r%a');
                                        $fin   = date('d/m/Y', strtotime($emp->date_fin_contrat));
                                        if ($sorti)           $echeance = '<span class="cell-sub">Fin le ' . $fin . '</span>';
                                        elseif ($jours < 0)   $echeance = '<span class="cell-sub text-danger font-weight-bold"><i class="fas fa-exclamation-circle"></i> Échu le ' . $fin . '</span>';
                                        elseif ($jours <= 30) $echeance = '<span class="cell-sub text-warning font-weight-bold"><i class="fas fa-clock"></i> Fin le ' . $fin . ' (J-' . $jours . ')</span>';
                                        else                  $echeance = '<span class="cell-sub">Fin le ' . $fin . '</span>';
                                    }

                                    $recherche = mb_strtolower(implode(' ', array_filter([
                                        $emp->matricule,
                                        $emp->nom,
                                        $emp->prenoms,
                                        $emp->fonction,
                                        $emp->departement,
                                        $emp->site_affectation,
                                        $emp->email,
                                        $emp->telephone,
                                        $emp->matricule_inss,
                                        $emp->cnid,
                                        $emp->nationalite ?? '',
                                        $emp->assurance_maladie ?? '',
                                    ])));
                            ?>
                                    <tr class="emp-row<?= $sorti ? ' row-sorti' : '' ?>" data-id="<?= (int) $emp->employe_id ?>"
                                        data-dep="<?= html_escape($emp->departement) ?>"
                                        data-site="<?= html_escape($emp->site_affectation) ?>"
                                        data-contrat="<?= html_escape($emp->type_contrat) ?>"
                                        data-statut="<?= html_escape($emp->statut) ?>"
                                        data-search="<?= html_escape($recherche) ?>">

                                        <td class="nowrap"><strong
                                                class="text-muted"><?= html_escape($emp->matricule) ?></strong></td>

                                        <td style="min-width:260px">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar-initials mr-2"
                                                    style="background:<?= $couleur ?>"><?= html_escape($initiales) ?></span>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        <?= html_escape($emp->prenoms . ' ' . mb_strtoupper($emp->nom)) ?></div>
                                                    <div class="cell-sub">
                                                        <i
                                                            class="fas <?= $emp->sexe === 'Féminin' ? 'fa-venus text-danger' : 'fa-mars text-primary' ?>"></i>
                                                        <?= $emp->sexe === 'Féminin' ? 'F' : 'M' ?>
                                                        · <?= html_escape($emp->nationalite ?? 'Burundaise') ?>
                                                        <?php if ($age_emb !== null): ?>· <?= $age_emb ?> ans à
                                                        l'embauche<?php endif; ?>
                                                    </div>
                                                    <div class="cell-sub">
                                                        <?php if (!empty($emp->cnid)): ?><i class="fas fa-id-card"></i>
                                                            <?= html_escape($emp->cnid) ?><br><?php endif; ?>
                                                        <?php if (!empty($emp->telephone)): ?><i class="fas fa-phone"></i>
                                                            <?= html_escape($emp->telephone) ?><br><?php endif; ?>
                                                        <?php if (!empty($emp->email)): ?><i class="fas fa-envelope"></i>
                                                            <?= html_escape($emp->email) ?><?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td style="min-width:220px">
                                            <div class="font-weight-bold"><?= html_escape($emp->fonction) ?></div>
                                            <div class="cell-sub">
                                                <span class="chip <?= $emp->categorie === 'Chantier' ? '' : 'chip-gris' ?>">
                                                    <i
                                                        class="fas <?= $emp->categorie === 'Chantier' ? 'fa-hard-hat' : 'fa-building' ?>"></i>
                                                    <?= html_escape($emp->categorie) ?>
                                                </span>
                                                <?= !empty($emp->departement) ? html_escape($emp->departement) : $vide ?>
                                            </div>
                                            <div class="cell-sub"><i class="fas fa-map-marker-alt"></i>
                                                <?= !empty($emp->site_affectation) ? html_escape($emp->site_affectation) : $vide ?>
                                            </div>
                                        </td>

                                        <td class="nowrap">
                                            <div class="cell-sub"><strong>INSS :</strong>
                                                <?= !empty($emp->matricule_inss) ? html_escape($emp->matricule_inss) : $vide ?>
                                            </div>
                                            <div class="cell-sub"><strong>Assurance :</strong>
                                                <?= !empty($emp->assurance_maladie) ? html_escape($emp->assurance_maladie) : $vide ?>
                                            </div>
                                            <div class="cell-sub"><strong>OBR :</strong>
                                                <?= !empty($emp->numero_contribuable) ? html_escape($emp->numero_contribuable) : $vide ?>
                                            </div>
                                        </td>

                                        <td class="nowrap">
                                            <span
                                                class="badge badge-<?= $badge_contrat[$emp->type_contrat] ?? 'secondary' ?>"><?= html_escape($emp->type_contrat) ?></span>
                                            <?= $echeance ? '<br>' . $echeance : '' ?>
                                        </td>

                                        <td class="nowrap">
                                            <?= date('d/m/Y', strtotime($emp->date_embauche)) ?>
                                            <div class="cell-sub"><?= $anciennete ?><?= $sorti ? ' (au départ)' : '' ?></div>
                                        </td>

                                        <td class="nowrap">
                                            <span
                                                class="badge badge-<?= $badge_statut[$emp->statut] ?? 'secondary' ?>"><?= html_escape($emp->statut) ?></span>
                                            <?php if (!empty($emp->date_sortie)): ?>
                                                <div class="cell-sub">Sorti le <?= date('d/m/Y', strtotime($emp->date_sortie)) ?>
                                                </div>
                                                <div class="cell-sub"><?= html_escape($emp->cause_cessation) ?></div>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-right nowrap col-actions">
                                            <button type="button" class="btn btn-sm btn-default" title="Profil"
                                                onclick="ouvrirProfil(<?= (int) $emp->employe_id ?>)"><i
                                                    class="fas fa-eye"></i></button>
                                            <button type="button" class="btn btn-sm btn-default" title="Modifier"
                                                onclick="ouvrirModalModification(<?= (int) $emp->employe_id ?>)"><i
                                                    class="fas fa-edit"></i></button>
                                            <?php if (!$sorti): ?>
                                                <button type="button" class="btn btn-sm btn-default text-danger"
                                                    title="Déclarer une sortie"
                                                    onclick="declarerSortie(<?= (int) $emp->employe_id ?>)"><i
                                                        class="fas fa-user-slash"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr id="emptyFiltre" style="display:none">
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-filter fa-2x mb-2 d-block"></i>Aucun employé ne correspond aux
                                        filtres.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucun employé enregistré.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center">
                        <small class="text-muted mr-3" id="infoPagination"></small>
                        <select id="fParPage" class="form-control form-control-sm" style="width:auto">
                            <option value="10">10 / page</option>
                            <option value="15" selected>15 / page</option>
                            <option value="25">25 / page</option>
                            <option value="1000">Tout</option>
                        </select>
                    </div>
                    <ul class="pagination pagination-sm mb-0" id="paginationEmployes"></ul>
                </div>
            </div>

            <!-- Suggestions d'assurance (partagées par les deux formulaires) -->
            <datalist id="rhListeAssurances">
                <option value="SANTE ASSURE">
                <option value="MFP">
                <option value="Aucune">
            </datalist>

            <!-- =================================================================
                 3. MODALE : NOUVEL EMPLOYÉ
                 ================================================================= -->
            <div class="modal fade" id="modalNouvelEmploye">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form id="newForm" method="post" action="<?= base_url('rh-employes-store') ?>"
                            enctype="multipart/form-data">
                            <div class="modal-header bg-success text-white">
                                <h4 class="modal-title"><i class="fas fa-user-plus mr-2"></i>Nouvel employé
                                    <small class="ml-2" style="opacity:.85">— Registre général d'emploi</small>
                                </h4>
                                <button type="button" class="close text-white"
                                    data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body"><?php $rh_form_body('new', false); ?></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>
                                    Enregistrer l'employé</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- =================================================================
                 4. MODALE : MODIFIER EMPLOYÉ
                 ================================================================= -->
            <div class="modal fade" id="modalModifierEmploye">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form id="editForm" method="post" action="<?= base_url('rh-employes-update') ?>"
                            enctype="multipart/form-data">
                            <input type="hidden" name="employe_id" id="editEmployeId">
                            <div class="modal-header bg-success text-white">
                                <h4 class="modal-title"><i class="fas fa-user-edit mr-2"></i>Modifier l'employé <span
                                        id="editMatriculeTitre"></span></h4>
                                <button type="button" class="close text-white"
                                    data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body"><?php $rh_form_body('edit', true); ?></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>
                                    Enregistrer les modifications</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- =================================================================
                 5. MODALE : PROFIL EMPLOYÉ
                 ================================================================= -->
            <div class="modal fade" id="modalProfilEmploye">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h4 class="modal-title"><i class="fas fa-id-badge mr-2"></i>Profil employé <span
                                    id="pMatriculeTitre"></span></h4>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>

                        <div class="modal-body">
                            <div class="profil-entete d-flex flex-wrap align-items-center mb-3">
                                <div class="profil-photo mr-3" id="pPhoto"></div>
                                <div class="flex-grow-1 mb-2">
                                    <h4 class="mb-0 font-weight-bold" id="pNomComplet"></h4>
                                    <div class="text-muted mb-1" id="pFonction"></div>
                                    <span class="badge mr-1" id="pBadgeStatut"></span>
                                    <span class="badge mr-1" id="pBadgeContrat"></span>
                                    <span class="chip" id="pChipCategorie"></span>
                                </div>
                                <div class="d-flex">
                                    <div class="profil-kpi">
                                        <div class="val" id="pAnciennete">—</div>
                                        <div class="lbl">Ancienneté</div>
                                    </div>
                                    <div class="profil-kpi">
                                        <div class="val" id="pAgeEmb">—</div>
                                        <div class="lbl">Âge à l'embauche</div>
                                    </div>
                                    <div class="profil-kpi">
                                        <div class="val" id="pAgeAct">—</div>
                                        <div class="lbl">Âge actuel</div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert mb-3" id="pAlerte" style="display:none"></div>

                            <ul class="nav nav-tabs mb-3" id="profilTabs">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                        href="#tabProfilRegistre"><i class="fas fa-book mr-1"></i>Fiche registre</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabProfilContrat"><i
                                            class="fas fa-file-contract mr-1"></i>Contrat &amp; paie</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabProfilDocs"><i
                                            class="fas fa-paperclip mr-1"></i>Documents <span class="badge badge-light"
                                            id="pNbDocs"></span></a></li>
                            </ul>

                            <div class="tab-content">
                                <!-- Fiche registre -->
                                <div class="tab-pane fade show active" id="tabProfilRegistre">
                                    <div class="row">
                                        <div class="col-lg-4 mb-3">
                                            <div class="profil-card">
                                                <h6><i class="fas fa-user mr-1"></i>Identification</h6>
                                                <dl class="row profil-dl mb-0">
                                                    <dt class="col-5">Matricule</dt>
                                                    <dd class="col-7" data-p="matricule"></dd>
                                                    <dt class="col-5">Nom</dt>
                                                    <dd class="col-7" data-p="nom" data-f="upper"></dd>
                                                    <dt class="col-5">Prénom(s)</dt>
                                                    <dd class="col-7" data-p="prenoms"></dd>
                                                    <dt class="col-5">Sexe</dt>
                                                    <dd class="col-7" data-p="sexe"></dd>
                                                    <dt class="col-5">Nationalité</dt>
                                                    <dd class="col-7" data-p="nationalite"></dd>
                                                    <dt class="col-5">Date de naissance</dt>
                                                    <dd class="col-7" data-p="date_naissance" data-f="date"></dd>
                                                    <dt class="col-5">N° CNI</dt>
                                                    <dd class="col-7" data-p="cnid"></dd>
                                                    <dt class="col-5">État civil</dt>
                                                    <dd class="col-7" data-p="etat_civil"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <div class="profil-card">
                                                <h6><i class="fas fa-briefcase mr-1"></i>Emploi &amp; affectation</h6>
                                                <dl class="row profil-dl mb-0">
                                                    <dt class="col-5">Qualification</dt>
                                                    <dd class="col-7" data-p="fonction"></dd>
                                                    <dt class="col-5">Date d'entrée</dt>
                                                    <dd class="col-7" data-p="date_embauche" data-f="date"></dd>
                                                    <dt class="col-5">Catégorie</dt>
                                                    <dd class="col-7" data-p="categorie"></dd>
                                                    <dt class="col-5">Département</dt>
                                                    <dd class="col-7" data-p="departement"></dd>
                                                    <dt class="col-5">Site</dt>
                                                    <dd class="col-7" data-p="site_affectation"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <div class="profil-card">
                                                <h6><i class="fas fa-shield-alt mr-1"></i>Protection sociale &amp;
                                                    contact</h6>
                                                <dl class="row profil-dl mb-0">
                                                    <dt class="col-5">N° INSS</dt>
                                                    <dd class="col-7" data-p="matricule_inss"></dd>
                                                    <dt class="col-5">Assurance mal.-mat.</dt>
                                                    <dd class="col-7" data-p="assurance_maladie"></dd>
                                                    <dt class="col-5">N° OBR</dt>
                                                    <dd class="col-7" data-p="numero_contribuable"></dd>
                                                    <dt class="col-5">Téléphone</dt>
                                                    <dd class="col-7" data-p="telephone"></dd>
                                                    <dt class="col-5">E-mail</dt>
                                                    <dd class="col-7" data-p="email"></dd>
                                                    <dt class="col-5">Adresse</dt>
                                                    <dd class="col-7" data-p="adresse"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3" id="pBlocSortie" style="display:none">
                                            <div class="profil-card" style="background:#fafafa">
                                                <h6 class="text-secondary"><i
                                                        class="fas fa-sign-out-alt mr-1"></i>Sortie</h6>
                                                <dl class="row profil-dl mb-0">
                                                    <dt class="col-md-2 col-5">Date de sortie</dt>
                                                    <dd class="col-md-4 col-7" data-p="date_sortie" data-f="date"></dd>
                                                    <dt class="col-md-2 col-5">Cause de cessation</dt>
                                                    <dd class="col-md-4 col-7" data-p="cause_cessation"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contrat & paie -->
                                <div class="tab-pane fade" id="tabProfilContrat">
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <div class="profil-card">
                                                <h6><i class="fas fa-file-signature mr-1"></i>Contrat</h6>
                                                <dl class="row profil-dl mb-0">
                                                    <dt class="col-5">Type de contrat</dt>
                                                    <dd class="col-7" data-p="type_contrat"></dd>
                                                    <dt class="col-5">Date d'entrée</dt>
                                                    <dd class="col-7" data-p="date_embauche" data-f="date"></dd>
                                                    <dt class="col-5">Fin de contrat</dt>
                                                    <dd class="col-7" data-p="date_fin_contrat" data-f="date"></dd>
                                                    <dt class="col-5">Période d'essai</dt>
                                                    <dd class="col-7" data-p="periode_essai"></dd>
                                                    <dt class="col-5">Statut</dt>
                                                    <dd class="col-7" data-p="statut"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="profil-card">
                                                <h6><i class="fas fa-money-bill-wave mr-1"></i>Rémunération</h6>
                                                <dl class="row profil-dl mb-0">
                                                    <dt class="col-5">Salaire brut</dt>
                                                    <dd class="col-7" data-p="salaire_base" data-f="money"></dd>
                                                    <dt class="col-5">Mode de paiement</dt>
                                                    <dd class="col-7" data-p="mode_paiement"></dd>
                                                    <dt class="col-5">Créé le</dt>
                                                    <dd class="col-7" data-p="cree_le" data-f="datetime"></dd>
                                                    <dt class="col-5">Modifié le</dt>
                                                    <dd class="col-7" data-p="modifie_le" data-f="datetime"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documents -->
                                <div class="tab-pane fade" id="tabProfilDocs">
                                    <div class="row" id="pDocs"></div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-success" id="pBtnModifier"><i
                                    class="fas fa-edit mr-1"></i>Modifier</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- =====================================================================
     SCRIPTS DE LA PAGE
     ===================================================================== -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<?php
$rh_map = [];
foreach ($employes as $e) {
    $rh_map[(int) $e->employe_id] = $e;
}
$rh_json = json_encode($rh_map, JSON_FORCE_OBJECT | $JSON_SAFE);
?>
<script>
    /* =====================================================================
   DONNÉES
   ===================================================================== */
    window.RH_EMPLOYES = <?= $rh_json !== false ? $rh_json : '{}' ?>;
    window.RH_BASE_URL = <?= json_encode(base_url(), $JSON_SAFE) ?>;
    window.RH_FLASH = {
        ok: <?= json_encode($flash_ok ?: null, $JSON_SAFE) ?>,
        err: <?= json_encode($flash_err ?: null, $JSON_SAFE) ?>
    };
    window.RH_FORM_NEW = null;
    window.RH_FORM_EDIT = null;

    /* Notification de secours si rhNotify n'est pas fourni par le layout */
    if (typeof window.rhNotify !== 'function') {
        window.rhNotify = function(type, msg) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: type,
                    title: msg,
                    showConfirmButton: false,
                    timer: 4500,
                    timerProgressBar: true
                });
            } else {
                alert(msg);
            }
        };
    }

    /* =====================================================================
       HELPERS
       ===================================================================== */
    window.rhFmtDate = function(d) {
        if (!d) return '';
        var p = String(d).substr(0, 10).split('-');
        return p.length === 3 ? p[2] + '/' + p[1] + '/' + p[0] : d;
    };

    /* Années pleines entre deux dates (Y-m-d) */
    window.rhAge = function(debut, fin) {
        if (!debut || !fin) return null;
        var a = new Date(debut),
            b = new Date(fin);
        var y = b.getFullYear() - a.getFullYear();
        if (b.getMonth() < a.getMonth() || (b.getMonth() === a.getMonth() && b.getDate() < a.getDate())) y--;
        return y;
    };

    /* Durée lisible entre deux dates (fin = aujourd'hui si vide) */
    window.rhDuree = function(debut, fin) {
        var a = new Date(debut),
            b = fin ? new Date(fin) : new Date();
        var mois = (b.getFullYear() - a.getFullYear()) * 12 + (b.getMonth() - a.getMonth());
        if (b.getDate() < a.getDate()) mois--;
        if (mois < 1) return Math.max(0, Math.round((b - a) / 86400000)) + ' j';
        var y = Math.floor(mois / 12),
            m = mois % 12;
        return (y ? y + ' an' + (y > 1 ? 's' : '') : '') + (y && m ? ' ' : '') + (m ? m + ' mois' : '');
    };

    /* Sélectionne une valeur ; si elle n'existe pas (ancienne nomenclature), l'ajoute pour ne pas la perdre */
    window.rhSetSelect = function($el, val) {
        if (val === null || val === undefined || val === '') return;
        var existe = $el.find('option').filter(function() {
            return this.value === String(val);
        }).length;
        if (!existe) $el.append($('<option class="rh-legacy">').val(val).text(val + ' (ancienne valeur)'));
        $el.val(val);
    };

    /* =====================================================================
       FORMULAIRES CRÉATION / MODIFICATION (logique commune, préfixe 'new' ou 'edit')
       ===================================================================== */
    window.rhBrancherForm = function(p) {
        var s = function(suffixe) {
            return $('#' + p + suffixe);
        };
        var $f = s('Form');

        function majAge() {
            var age = rhAge(s('DateNaissance').val(), s('DateEntree').val());
            if (age === null) {
                s('Age').val('');
                s('AgeAlerte').addClass('d-none');
                return;
            }
            if (age < 0) {
                s('Age').val('Dates incohérentes');
                s('AgeAlerte').addClass('d-none');
                return;
            }
            s('Age').val(age + ' ans');
            s('AgeAlerte').toggleClass('d-none', age >= 18);
        }

        function majContrat() {
            var cdd = s('TypeContrat').val() === 'CDD';
            s('BlocFin').toggle(cdd);
            s('FinContrat').prop('required', cdd);
            if (!cdd) s('FinContrat').val('');
        }

        function majSortie() {
            var on = s('ChkSortie').is(':checked');
            s('BlocSortie').toggle(on);
            s('DateSortie').add(s('Cause')).prop('required', on);
            if (!on) {
                s('DateSortie').val('');
                s('Cause').val('');
            }
            if (p === 'edit') {
                var $st = $('#editStatut');
                if (on) {
                    $st.val('Fin de contrat').prop('disabled', true);
                } else {
                    $st.prop('disabled', false);
                    if ($st.val() === 'Fin de contrat') $st.val('Actif');
                }
            }
        }

        s('DateNaissance').add(s('DateEntree')).on('change', majAge);
        s('TypeContrat').on('change', majContrat);
        s('ChkSortie').on('change', majSortie);

        $f.on('submit', function(e) {
            var entree = s('DateEntree').val(),
                naiss = s('DateNaissance').val();
            var sortie = s('DateSortie').val(),
                fin = s('FinContrat').val(),
                msg = null;
            if (naiss && entree && naiss >= entree) msg =
                "La date de naissance doit être antérieure à la date d'entrée.";
            else if (sortie && entree && sortie < entree) msg =
                "La date de sortie ne peut pas précéder la date d'entrée.";
            else if (fin && entree && fin <= entree) msg =
                "La fin du CDD doit être postérieure à la date d'entrée.";
            if (msg) {
                e.preventDefault();
                rhNotify('error', msg);
            }
        });

        function refresh() {
            majAge();
            majContrat();
            majSortie();
        }
        refresh();
        return {
            refresh: refresh,
            form: $f
        };
    };

    /* =====================================================================
       BOUTON « MODIFIER »
       ===================================================================== */
    window.ouvrirModalModification = function(id) {
        var emp = (window.RH_EMPLOYES || {})[id];
        if (!emp) {
            rhNotify('error', 'Employé introuvable.');
            return;
        }

        var $form = $('#editForm');
        $form[0].reset();
        $form.find('option.rh-legacy').remove();
        $form.find('.custom-file-label').text('Remplacer…').removeClass('has-file');

        var ignores = ['employe_id', 'matricule', 'statut', 'doc_cnid', 'doc_photo', 'doc_contrat', 'doc_cv'];
        $.each(emp, function(cle, valeur) {
            if (ignores.indexOf(cle) !== -1 || valeur === null) return;
            var $el = $form.find('[name="' + cle + '"]').not('input[type="file"]');
            if (!$el.length) return;
            if ($el.is('select')) rhSetSelect($el, valeur);
            else $el.val(cle === 'salaire_base' ? parseFloat(valeur) : valeur);
        });

        var sorti = !!emp.date_sortie || emp.statut === 'Fin de contrat';
        $('#editChkSortie').prop('checked', sorti);
        if (!sorti) rhSetSelect($('#editStatut'), emp.statut || 'Actif');

        $('#editMatriculeTitre').text('(' + emp.matricule + ')');
        $('#editMatricule').val(emp.matricule);
        $('#editEmployeId').val(emp.employe_id);

        ['doc_cnid', 'doc_photo', 'doc_contrat', 'doc_cv'].forEach(function(champ) {
            var $cible = $('#docActuel_' + champ).empty();
            if (emp[champ]) {
                $('<a target="_blank">').attr('href', RH_BASE_URL + emp[champ])
                    .append('<i class="fas fa-paperclip mr-1"></i>')
                    .append(document.createTextNode(emp[champ].split('/').pop()))
                    .appendTo($cible);
            } else {
                $cible.text('Aucun fichier');
            }
        });

        RH_FORM_EDIT.refresh();
        $('#modalModifierEmploye').modal('show');
    };

    /* =====================================================================
       BOUTON « DÉCLARER UNE SORTIE » : modification avec la sortie pré-cochée
       ===================================================================== */
    window.declarerSortie = function(id) {
        ouvrirModalModification(id);
        $('#editChkSortie').prop('checked', true);
        RH_FORM_EDIT.refresh();
        $('#modalModifierEmploye').one('shown.bs.modal', function() {
            var el = document.getElementById('editDateSortie');
            el.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            el.focus();
        });
    };

    /* =====================================================================
       BOUTON « PROFIL »
       ===================================================================== */
    window.ouvrirProfil = function(id) {
        var e = (window.RH_EMPLOYES || {})[id];
        if (!e) {
            rhNotify('error', 'Employé introuvable.');
            return;
        }
        var $m = $('#modalProfilEmploye');
        var sorti = !!e.date_sortie || e.statut === 'Fin de contrat';

        /* Champs simples */
        $m.find('[data-p]').each(function() {
            var v = e[this.dataset.p],
                f = this.dataset.f;
            if (v === null || v === undefined) v = '';
            if (f === 'date') v = rhFmtDate(v);
            else if (f === 'datetime') v = v ? rhFmtDate(v) + ' ' + String(v).substr(11, 5) : '';
            else if (f === 'upper') v = String(v).toUpperCase();
            else if (f === 'money') v = v !== '' ? Number(v).toLocaleString('fr-FR') + ' BIF' : '';
            $(this).text(v !== '' ? v : 'Non renseigné').toggleClass('vide', v === '');
        });

        /* En-tête */
        $('#pMatriculeTitre').text('(' + e.matricule + ')');
        $('#pNomComplet').text((e.prenoms || '') + ' ' + (e.nom || '').toUpperCase());
        $('#pFonction').text(e.fonction || '');

        var bStatut = {
            'Actif': 'success',
            'En congé': 'info',
            'Suspendu': 'warning',
            'Fin de contrat': 'secondary'
        };
        var bContrat = {
            'CDI': 'success',
            'CDD': 'warning',
            'Stage': 'info'
        };
        $('#pBadgeStatut').attr('class', 'badge mr-1 badge-' + (bStatut[e.statut] || 'secondary')).text(e.statut || '');
        $('#pBadgeContrat').attr('class', 'badge mr-1 badge-' + (bContrat[e.type_contrat] || 'secondary')).text(e
            .type_contrat || '');
        $('#pChipCategorie').attr('class', 'chip' + (e.categorie === 'Chantier' ? '' : ' chip-gris'))
            .html('<i class="fas ' + (e.categorie === 'Chantier' ? 'fa-hard-hat' : 'fa-building') + '"></i> ')
            .append(document.createTextNode(e.categorie || ''));

        var $ph = $('#pPhoto').empty();
        if (e.doc_photo && /\.(jpe?g|png|gif|webp)$/i.test(e.doc_photo)) {
            $('<img alt="Photo">').attr('src', RH_BASE_URL + e.doc_photo).appendTo($ph);
        } else {
            var couleurs = ['#1f7a5c', '#2c8a69', '#34608c', '#7a4f1f', '#8a3033', '#6c757d'];
            $('<span class="avatar-initials">').css('background', couleurs[e.employe_id % couleurs.length])
                .text(((e.prenoms || ' ')[0] + (e.nom || ' ')[0]).toUpperCase()).appendTo($ph);
        }

        $('#pAnciennete').text(rhDuree(e.date_embauche, sorti ? e.date_sortie : null));
        var ageEmb = rhAge(e.date_naissance, e.date_embauche);
        var ageAct = rhAge(e.date_naissance, new Date().toISOString().slice(0, 10));
        $('#pAgeEmb').text(ageEmb !== null ? ageEmb + ' ans' : '—');
        $('#pAgeAct').text(ageAct !== null ? ageAct + ' ans' : '—');

        /* Alerte : sortie ou échéance du contrat */
        var $al = $('#pAlerte').hide().attr('class', 'alert mb-3');
        if (sorti) {
            $al.addClass('alert-secondary').text('Employé sorti' +
                (e.date_sortie ? ' le ' + rhFmtDate(e.date_sortie) : '') +
                (e.cause_cessation ? ' — ' + e.cause_cessation : '') + '.').show();
        } else if (e.date_fin_contrat && e.type_contrat !== 'CDI') {
            var jours = Math.ceil((new Date(e.date_fin_contrat) - new Date(new Date().toDateString())) / 86400000);
            if (jours < 0) {
                $al.addClass('alert-danger').text('Contrat échu depuis le ' + rhFmtDate(e.date_fin_contrat) +
                    ' : à renouveler ou à clôturer (déclarer la sortie).').show();
            } else if (jours <= 30) {
                $al.addClass('alert-warning').text('Le contrat prend fin le ' + rhFmtDate(e.date_fin_contrat) +
                    ' (dans ' + jours + ' jour' + (jours > 1 ? 's' : '') + ').').show();
            }
        }
        $('#pBlocSortie').toggle(sorti);

        /* Documents */
        var docs = [
            ['doc_cnid', 'Copie CNI', 'fa-id-card'],
            ['doc_photo', "Photo d'identité", 'fa-portrait'],
            ['doc_contrat', 'Contrat signé', 'fa-file-signature'],
            ['doc_cv', 'CV / Diplômes', 'fa-graduation-cap']
        ];
        var $docs = $('#pDocs').empty(),
            nb = 0;
        docs.forEach(function(d) {
            var chemin = e[d[0]];
            var $col = $('<div class="col-md-3 col-6 mb-3">');
            var $tile = $('<div class="doc-tile">').appendTo($col);
            if (chemin) {
                nb++;
                var url = RH_BASE_URL + chemin;
                $tile.addClass('ok');
                if (/\.(jpe?g|png|gif|webp)$/i.test(chemin)) $('<img alt="">').attr('src', url).appendTo($tile);
                else $tile.append('<i class="fas fa-file-pdf fa-2x text-danger d-block"></i>');
                $('<div class="font-weight-bold small">').text(d[1]).appendTo($tile);
                $('<a target="_blank" class="btn btn-xs btn-outline-success mt-2">').attr('href', url)
                    .html('<i class="fas fa-external-link-alt mr-1"></i>Ouvrir').appendTo($tile);
            } else {
                $tile.append('<i class="fas ' + d[2] + ' fa-2x text-muted d-block"></i>');
                $('<div class="font-weight-bold small text-muted">').text(d[1]).appendTo($tile);
                $tile.append('<div class="small text-muted mt-1">Non fourni</div>');
            }
            $docs.append($col);
        });
        $('#pNbDocs').text(nb + '/4');

        /* Profil → Modifier : on attend la fermeture complète avant d'ouvrir l'autre modale */
        $('#pBtnModifier').off('click').on('click', function() {
            $m.one('hidden.bs.modal', function() {
                ouvrirModalModification(id);
            }).modal('hide');
        });

        $('#profilTabs a[href="#tabProfilRegistre"]').tab('show');
        $m.modal('show');
    };

    /* =====================================================================
       INITIALISATION (jQuery chargé par le footer)
       ===================================================================== */
    document.addEventListener('DOMContentLoaded', function() {

        /* ---------- Formulaires ---------- */
        RH_FORM_NEW = rhBrancherForm('new');
        RH_FORM_EDIT = rhBrancherForm('edit');

        $('#modalNouvelEmploye').on('hidden.bs.modal', function() {
            $('#newForm')[0].reset();
            $('#newForm .custom-file-label').text('Choisir…').removeClass('has-file');
            $('#newChkSortie').prop('checked', false);
            RH_FORM_NEW.refresh();
        });

        /* Nom du fichier choisi dans les champs d'upload */
        $(document).on('change', '.custom-file-input', function() {
            var f = this.files && this.files[0];
            var defaut = $(this).closest('#editForm').length ? 'Remplacer…' : 'Choisir…';
            $(this).siblings('.custom-file-label').text(f ? f.name : defaut).toggleClass('has-file', !!f);
        });

        /* ---------- Registre : filtres, pagination, export ---------- */
        var $rows = $('#tableEmployes tbody tr.emp-row');
        var page = 1,
            visibles = [];

        function filtrer() {
            var q = $('#searchInput').val().toLowerCase().trim();
            var dep = $('#fDep').val(),
                site = $('#fSite').val();
            var ct = $('#fContrat').val(),
                st = $('#fStatut').val();
            visibles = [];
            $rows.each(function() {
                var r = this.dataset;
                var okStatut = !st || (st === '__presents' ? r.statut !== 'Fin de contrat' : r.statut ===
                    st);
                if ((!q || r.search.indexOf(q) !== -1) && (!dep || r.dep === dep) &&
                    (!site || r.site === site) && (!ct || r.contrat === ct) && okStatut) {
                    visibles.push(this);
                }
            });
        }

        function rendre(reset) {
            if (reset) page = 1;
            filtrer();
            var par = parseInt($('#fParPage').val(), 10);
            var total = visibles.length;
            var nbPages = Math.max(1, Math.ceil(total / par));
            if (page > nbPages) page = nbPages;

            var debut = (page - 1) * par;
            $rows.hide();
            $(visibles.slice(debut, debut + par)).show();
            $('#emptyFiltre').toggle(total === 0);

            $('#infoPagination').text(total ?
                'Affichage de ' + (debut + 1) + ' à ' + Math.min(debut + par, total) + ' sur ' + total +
                (total !== $rows.length ? ' (filtré sur ' + $rows.length + ')' : '') :
                '0 résultat sur ' + $rows.length);

            var $p = $('#paginationEmployes').empty();
            if (nbPages <= 1) return;

            function li(lbl, num, actif, off) {
                return $('<li class="page-item">').toggleClass('active', actif).toggleClass('disabled', off)
                    .append($('<a class="page-link" href="#">').html(lbl).attr('data-page', num));
            }
            $p.append(li('&laquo;', page - 1, false, page === 1));
            for (var i = 1; i <= nbPages; i++) $p.append(li(i, i, i === page, false));
            $p.append(li('&raquo;', page + 1, false, page === nbPages));
        }

        $('#paginationEmployes').on('click', 'a', function(e) {
            e.preventDefault();
            if ($(this).parent().hasClass('disabled')) return;
            page = parseInt($(this).data('page'), 10);
            rendre(false);
        });
        $('#searchInput').on('input', function() {
            rendre(true);
        });
        $('#fDep, #fSite, #fContrat, #fStatut, #fParPage').on('change', function() {
            rendre(true);
        });

        /* Export CSV : lignes filtrées, colonnes dans l'ordre du registre */
        $('#btnExportCsv').on('click', function(e) {
            e.preventDefault();
            filtrer();
            var entetes = ['Matricule', 'Nom et prénom', "Âge à l'embauche", 'Sexe', 'Nationalité',
                'Qualification professionnelle', "Date d'entrée", 'N° INSS',
                'Assurance maladie-maternité',
                'Date de sortie', 'Cause de cessation', 'Date de naissance', 'N° CNI', 'Catégorie',
                'Département', "Site d'affectation", 'Téléphone', 'E-mail', 'Contrat', 'Fin de contrat',
                'Statut'
            ];
            var cel = function(v) {
                return '"' + String(v === null || v === undefined ? '' : v).replace(/"/g, '""') + '"';
            };
            var lignes = [entetes.map(cel).join(';')];

            visibles.forEach(function(tr) {
                var x = RH_EMPLOYES[tr.dataset.id];
                if (!x) return;
                var age = rhAge(x.date_naissance, x.date_embauche);
                lignes.push([
                    x.matricule, (x.nom || '').toUpperCase() + ' ' + (x.prenoms || ''),
                    age !== null ? age : '',
                    x.sexe === 'Féminin' ? 'F' : 'M', x.nationalite, x.fonction, rhFmtDate(x
                        .date_embauche),
                    x.matricule_inss, x.assurance_maladie, rhFmtDate(x.date_sortie), x
                    .cause_cessation,
                    rhFmtDate(x.date_naissance), x.cnid, x.categorie, x.departement, x
                    .site_affectation,
                    x.telephone, x.email, x.type_contrat, rhFmtDate(x.date_fin_contrat), x
                    .statut
                ].map(cel).join(';'));
            });

            var blob = new Blob(['\ufeff' + lignes.join('\r\n')], {
                type: 'text/csv;charset=utf-8;'
            });
            var a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'registre_employes_' + new Date().toISOString().slice(0, 10) + '.csv';
            document.body.appendChild(a);
            a.click();
            a.remove();
        });

        /* Impression / PDF : toutes les lignes filtrées, pas seulement la page courante */
        $('#btnImprimer, #btnExportPdf').on('click', function(e) {
            e.preventDefault();
            filtrer();
            $rows.hide();
            $(visibles).show();
            window.print();
            rendre(false);
        });

        rendre(true);

        /* ---------- Messages flash ---------- */
        if (RH_FLASH.ok) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Enregistrement réussi',
                    text: RH_FLASH.ok,
                    confirmButtonColor: '#1f7a5c',
                    confirmButtonText: 'Parfait !',
                    timer: 4000,
                    timerProgressBar: true
                });
            } else {
                rhNotify('success', RH_FLASH.ok);
            }
        }
        if (RH_FLASH.err) rhNotify('error', RH_FLASH.err);
    });
</script>