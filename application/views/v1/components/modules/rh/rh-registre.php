<?php
/* =====================================================================
   PRÉPARATION DES DONNÉES DU REGISTRE
   ===================================================================== */

/* Sortie enregistrée via « Contrats & mouvements » (secours si la fiche n'a pas de date_sortie) */
$sorties_mvt = [];
foreach ($mouvements as $m) {
    if (
        in_array($m->type_mouvement, ['Démission', 'Licenciement', 'Fin de contrat', 'Retraite'])
        && !isset($sorties_mvt[$m->employe_id])
    ) {
        $sorties_mvt[$m->employe_id] = $m;   // mouvements triés DESC → le plus récent
    }
}

/* Registre : ordre d'entrée en service (date d'entrée, puis ordre de saisie) */
$registre = $employes;
usort($registre, function ($a, $b) {
    return [$a->date_embauche, (int) $a->employe_id] <=> [$b->date_embauche, (int) $b->employe_id];
});

$CODES_NAT = [
    'Burundaise' => 'B',
    'Rwandaise' => 'RW',
    'Congolaise (RDC)' => 'RDC',
    'Tanzanienne' => 'TZ',
    'Ougandaise' => 'UG',
    'Kényane' => 'KE',
    'Autre' => 'Autre',
];

/* Lignes prêtes à afficher + indicateurs */
$lignes   = [];
$nb_service = $nb_conge = $nb_sortis = 0;
$annees   = [];
$sites    = [];
$ordre    = 0;

foreach ($registre as $e) {
    $ordre++;
    $mv          = $sorties_mvt[$e->employe_id] ?? null;
    $date_sortie = !empty($e->date_sortie) ? $e->date_sortie : ($mv ? $mv->date_effet : null);
    $cause       = !empty($e->cause_cessation) ? $e->cause_cessation : ($mv ? $mv->type_mouvement : null);
    $sorti       = $date_sortie || $e->statut === 'Fin de contrat';

    if ($sorti) {
        $situation = 'Sorti';
        $nb_sortis++;
    } elseif ($e->statut === 'En congé') {
        $situation = 'En congé';
        $nb_conge++;
    } elseif ($e->statut === 'Suspendu') {
        $situation = 'Suspendu';
        $nb_service++;
    } else {
        $situation = 'En service';
        $nb_service++;
    }

    $age = !empty($e->date_naissance)
        ? (new DateTime($e->date_naissance))->diff(new DateTime($e->date_embauche))->y
        : null;

    $annee   = date('Y', strtotime($e->date_embauche));
    $annees[$annee] = true;
    if (!empty($e->site_affectation)) $sites[$e->site_affectation] = true;

    $nat = $e->nationalite ?? 'Burundaise';

    $lignes[] = (object) [
        'e'           => $e,
        'ordre'       => $ordre,
        'age'         => $age,
        'nat_code'    => $CODES_NAT[$nat] ?? $nat,
        'nat'         => $nat,
        'date_sortie' => $date_sortie,
        'cause'       => $cause,
        'sorti'       => $sorti,
        'situation'   => $situation,
        'annee'       => $annee,
        'search'      => mb_strtolower(implode(' ', array_filter([
            $e->matricule,
            $e->nom,
            $e->prenoms,
            $e->fonction,
            $e->cnid,
            $e->matricule_inss,
            $e->telephone,
            $e->email,
            $e->assurance_maladie ?? '',
        ]))),
    ];
}
krsort($annees);
ksort($sites);
$total = count($lignes);

$fd = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '';
};   // format date
$v  = function ($x) {
    return ($x === null || $x === '') ? '' : html_escape($x);
};
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header no-print">
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
                 STYLES
                 ================================================================= -->
            <style>
            .section-title {
                color: #1f7a5c;
                font-weight: 700;
                border-bottom: 2px solid #e9ecef;
                padding-bottom: .4rem;
            }

            .legal-note {
                border-left: 4px solid #1f7a5c;
                background: #f8faf9;
            }

            .print-only {
                display: none;
            }

            /* --- Tableau façon registre papier --- */
            .registre-papier {
                border-collapse: collapse;
                width: 100%;
                font-size: .84rem;
                background: #fff;
            }

            .registre-papier th,
            .registre-papier td {
                border: 1px solid #9aa5ad;
                padding: .35rem .45rem;
                vertical-align: middle;
            }

            .registre-papier thead th {
                background: #f4f6f9;
                font-weight: 700;
                text-align: center;
                font-size: .76rem;
                line-height: 1.2;
            }

            .registre-papier thead tr.groupes th {
                background: #1f7a5c;
                color: #fff;
                text-transform: uppercase;
                letter-spacing: .04em;
                font-size: .72rem;
            }

            .registre-papier thead tr.groupes th.grp-f2 {
                background: #5c6f7b;
            }

            .registre-papier td.c {
                text-align: center;
            }

            .registre-papier td.nw {
                white-space: nowrap;
            }

            .registre-papier td.ordre {
                font-weight: 700;
                text-align: center;
                color: #1f7a5c;
            }

            .registre-papier td.nom {
                white-space: nowrap;
            }

            .registre-papier td.nom strong {
                letter-spacing: .02em;
            }

            .registre-papier tbody tr:nth-child(even) {
                background: #fafbfc;
            }

            .registre-papier tbody tr:hover {
                background: #eef7f3;
            }

            .registre-papier tr.sorti td {
                color: #6c757d;
            }

            .registre-papier tr.sorti td.sortie {
                color: #8a3033;
                font-weight: 600;
            }

            .registre-papier .sep-f2 {
                border-left: 3px solid #5c6f7b !important;
            }

            .registre-masque-f2 .col-f2 {
                display: none;
            }

            .legende {
                font-size: .78rem;
                color: #6c757d;
            }

            /* --- Impression : A4 paysage, comme le registre papier --- */
            @page {
                size: A4 landscape;
                margin: 8mm;
            }

            @media print {
                .print-only {
                    display: block !important;
                }

                .no-print,
                .main-sidebar,
                .main-header,
                .main-footer,
                .info-box {
                    display: none !important;
                }

                .content-wrapper {
                    margin-left: 0 !important;
                    background: #fff !important;
                }

                .card {
                    border: none !important;
                    box-shadow: none !important;
                }

                .card-body,
                .container-fluid {
                    padding: 0 !important;
                }

                .table-responsive {
                    overflow: visible !important;
                }

                .registre-papier {
                    font-size: 7.5pt;
                }

                .registre-papier th,
                .registre-papier td {
                    border: 1px solid #000 !important;
                    padding: 2px 3px;
                    color: #000 !important;
                }

                .registre-papier thead {
                    display: table-header-group;
                }

                .registre-papier thead th,
                .registre-papier thead tr.groupes th {
                    background: #fff !important;
                    color: #000 !important;
                }

                .registre-papier tbody tr {
                    break-inside: avoid;
                    background: #fff !important;
                }

                .registre-entete-papier {
                    display: flex !important;
                }
            }

            .registre-entete-papier {
                display: none;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 8px;
            }

            .registre-entete-papier .titre {
                font-weight: 700;
                font-size: 13pt;
            }

            .registre-entete-papier .sous-titre {
                text-align: center;
                font-size: 9pt;
            }

            .registre-entete-papier .visa {
                border: 1px dashed #000;
                border-radius: 50%;
                width: 170px;
                height: 70px;
                font-size: 8pt;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
            }
            </style>

            <!-- =================================================================
                 1. INDICATEURS
                 ================================================================= -->
            <div class="row no-print">
                <div class="col-lg-4 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-book"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Inscrits au registre</span>
                            <span class="info-box-number"><?= $total ?></span>
                            <span class="progress-description">Depuis la création de l'entreprise</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">En service</span>
                            <span class="info-box-number"><?= $nb_service + $nb_conge ?></span>
                            <span class="progress-description"><?= $nb_service ?> en poste · <?= $nb_conge ?> en
                                congé</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-user-minus"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sortis</span>
                            <span class="info-box-number"><?= $nb_sortis ?></span>
                            <span class="progress-description">Démission · retraite · fin de contrat…</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =================================================================
                 2. IDENTITÉ DE L'EMPLOYEUR + RAPPEL LÉGAL
                 ================================================================= -->
            <div class="row no-print">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0"><i class="fas fa-building mr-1 text-success"></i> Identité de
                                l'employeur</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Raison sociale</p>
                                    <p class="font-weight-bold">SATRACO Construction (SATRACO)</p>
                                    <p class="mb-1 text-muted">Activité principale</p>
                                    <p class="font-weight-bold">Construction de bâtiments et travaux publics</p>
                                    <p class="mb-1 text-muted">Siège social</p>
                                    <p class="font-weight-bold">Avenue du Large, Bujumbura — Burundi</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">N° RCCM</p>
                                    <p class="font-weight-bold">RC/BSB/2019/B/0456</p>
                                    <p class="mb-1 text-muted">N° employeur INSS</p>
                                    <p class="font-weight-bold">E-10245</p>
                                    <p class="mb-1 text-muted">N° contribuable (OBR)</p>
                                    <p class="font-weight-bold">400 987 654</p>
                                    <p class="mb-1 text-muted">Représentant légal</p>
                                    <p class="font-weight-bold">La Direction Générale</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card legal-note">
                        <div class="card-body">
                            <h6 class="font-weight-bold mb-2"><i class="fas fa-balance-scale mr-1 text-success"></i>
                                Obligation légale</h6>
                            <p class="mb-2 text-justify" style="font-size:.88rem">
                                Conformément au <strong>Code du travail de la République du Burundi</strong> et à ses
                                mesures
                                d'application, tout employeur est tenu de tenir un <strong>registre du
                                    personnel</strong> à jour,
                                à présenter à toute réquisition de l'<strong>Inspection Générale du Travail</strong> et
                                de l'<strong>OBEM</strong>.
                            </p>
                            <ul class="mb-0 pl-3" style="font-size:.85rem">
                                <li>Inscrire tout travailleur dès son embauche ;</li>
                                <li>Mentionner les départs (motif + date) ;</li>
                                <li>Conserver sans suppression ni rature ;</li>
                                <li>Imprimer et faire viser périodiquement.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =================================================================
                 3. REGISTRE GÉNÉRAL D'EMPLOI
                 ================================================================= -->
            <div class="card">
                <div class="card-header no-print">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="card-title mb-0"><i class="fas fa-book mr-1 text-success"></i> Registre général
                            d'emploi
                            <small class="text-muted ml-1">— ordre d'entrée en service</small>
                        </h3>
                        <div>
                            <div class="custom-control custom-switch d-inline-block mr-3 align-middle">
                                <input type="checkbox" class="custom-control-input" id="toggleF2" checked>
                                <label class="custom-control-label" for="toggleF2">Afficher les compléments</label>
                            </div>
                            <button type="button" class="btn btn-default mr-2" id="btnCsvRegistre">
                                <i class="fas fa-file-excel mr-1 text-success"></i> Excel (CSV)
                            </button>
                            <button type="button" class="btn btn-success" id="btnPrintRegistre">
                                <i class="fas fa-print mr-1"></i> Imprimer le registre
                            </button>
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div class="row mt-3">
                        <div class="col-lg-4 col-md-12 mb-2">
                            <div class="input-group">
                                <input type="search" id="searchRegistre" class="form-control"
                                    placeholder="Rechercher (nom, matricule, INSS, CNI, téléphone…)">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-search"></i></span></div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 mb-2">
                            <select id="filterSituation" class="form-control">
                                <option value="">Situation : toutes</option>
                                <option>En service</option>
                                <option>En congé</option>
                                <option>Suspendu</option>
                                <option>Sorti</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 mb-2">
                            <select id="filterCategorie" class="form-control">
                                <option value="">Catégorie : toutes</option>
                                <option>Bureau</option>
                                <option>Chantier</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 mb-2">
                            <select id="filterSite" class="form-control">
                                <option value="">Site : tous</option>
                                <?php foreach (array_keys($sites) as $s): ?>
                                <option value="<?= html_escape($s) ?>"><?= html_escape($s) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 mb-2">
                            <select id="filterAnnee" class="form-control">
                                <option value="">Entrée : toutes années</option>
                                <?php foreach (array_keys($annees) as $a): ?>
                                <option value="<?= $a ?>"><?= $a ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- En-tête reproduit du registre papier (impression) -->
                    <div class="registre-entete-papier">
                        <div>
                            <div class="titre">REGISTRE GÉNÉRAL D'EMPLOI</div>
                            <div style="font-size:9pt">SATRACO Construction · INSS employeur E-10245 · OBR 400 987 654
                            </div>
                        </div>
                        <div class="sous-titre">Liste nominative des travailleurs, inscrits dans l'ordre<br>de leur
                            entrée en service</div>
                        <div class="text-center">
                            <div style="font-size:10pt" class="mb-1">N° ..................</div>
                            <!-- <div class="visa">Cachet &amp; visa<br>Inspection du Travail</div> -->
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="registre-papier" id="tableRegistre">
                            <thead>
                                <tr class="groupes">
                                    <th colspan="12">Registre général d'emploi</th>
                                    <th colspan="6" class="col-f2 grp-f2 sep-f2">Compléments</th>
                                </tr>
                                <tr>
                                    <th>Matricule</th>
                                    <th>N°<br>d'ordre</th>
                                    <th>Nom et Prénom</th>
                                    <th>Âge</th>
                                    <th>Sexe</th>
                                    <th>Nationalité</th>
                                    <th>Qualification<br>professionnelle</th>
                                    <th>Date<br>d'entrée</th>
                                    <th>N° INSS</th>
                                    <th>Assurance<br>Maladie-Maternité</th>
                                    <th>Date de<br>sortie</th>
                                    <th>Cause de<br>cessation</th>
                                    <th class="col-f2 sep-f2">Date de<br>naissance</th>
                                    <th class="col-f2">N° CNI</th>
                                    <th class="col-f2">Cat.</th>
                                    <th class="col-f2">Site<br>d'affectation</th>
                                    <th class="col-f2">N° téléphone</th>
                                    <th class="col-f2">E-mail prof.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($lignes)): ?>
                                <tr>
                                    <td colspan="18" class="text-center text-muted py-4">Aucun travailleur inscrit au
                                        registre.</td>
                                </tr>
                                <?php endif; ?>
                                <?php foreach ($lignes as $l): $e = $l->e; ?>
                                <tr class="reg-row<?= $l->sorti ? ' sorti' : '' ?>"
                                    data-situation="<?= $l->situation ?>"
                                    data-categorie="<?= html_escape($e->categorie) ?>"
                                    data-site="<?= html_escape($e->site_affectation) ?>" data-annee="<?= $l->annee ?>"
                                    data-search="<?= html_escape($l->search) ?>">
                                    <td class="nw"><strong><?= html_escape($e->matricule) ?></strong></td>
                                    <td class="ordre"><?= $l->ordre ?></td>
                                    <td class="nom"><strong><?= html_escape(mb_strtoupper($e->nom)) ?></strong>
                                        <?= html_escape($e->prenoms) ?></td>
                                    <td class="c"><?= $l->age !== null ? $l->age : '' ?></td>
                                    <td class="c"><?= $e->sexe === 'Féminin' ? 'F' : 'M' ?></td>
                                    <td class="c" title="<?= html_escape($l->nat) ?>"><?= html_escape($l->nat_code) ?>
                                    </td>
                                    <td><?= $v($e->fonction) ?></td>
                                    <td class="nw c"><?= $fd($e->date_embauche) ?></td>
                                    <td class="nw"><?= $v($e->matricule_inss) ?></td>
                                    <td><?= $v($e->assurance_maladie ?? '') ?></td>
                                    <td class="nw c sortie"><?= $fd($l->date_sortie) ?></td>
                                    <td class="sortie"><?= $v($l->cause) ?></td>
                                    <td class="nw c col-f2 sep-f2"><?= $fd($e->date_naissance) ?></td>
                                    <td class="nw col-f2"><?= $v($e->cnid) ?></td>
                                    <td class="c col-f2"><?= $e->categorie === 'Chantier' ? 'Chantier' : 'Bureau' ?>
                                    </td>
                                    <td class="col-f2"><?= $v($e->site_affectation) ?></td>
                                    <td class="nw col-f2"><?= $v($e->telephone) ?></td>
                                    <td class="col-f2"><?= $v($e->email) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr id="regVide" style="display:none">
                                    <td colspan="18" class="text-center text-muted py-4"><i
                                            class="fas fa-filter mr-1"></i>Aucun travailleur ne correspond aux filtres.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap mt-2">
                        <span class="legende">
                            Âge = âge à l'entrée en service · Nationalité : B = Burundaise, RW = Rwandaise, RDC =
                            Congolaise,
                            TZ = Tanzanienne, UG = Ougandaise, KE = Kényane
                        </span>
                        <span class="legende" id="regCompteur">Registre mis à jour le <?= date('d/m/Y') ?> ·
                            <?= $total ?> inscrit<?= $total > 1 ? 's' : '' ?></span>
                    </div>
                </div>
            </div>

            <!-- =================================================================
                 4. SIGNATURES (impression uniquement)
                 ================================================================= -->
            <div class="print-only mt-4">
                <p class="mb-4">Arrêté le présent registre à <?= $total ?> inscrit<?= $total > 1 ? 's' : '' ?>. Fait à
                    Bujumbura, le <?= date('d/m/Y') ?></p>
                <div class="row text-center">
                    <div class="col-4"><strong>Le Responsable RH</strong><br><br><br>______________________</div>
                    <div class="col-4"><strong>Pour la Direction Générale</strong><br><br><br>______________________
                    </div>
                    <div class="col-4"><strong>Visa de l'Inspection du
                            Travail</strong><br><br><br>______________________</div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var table = document.getElementById('tableRegistre');
    var rows = Array.prototype.slice.call(table.querySelectorAll('tbody tr.reg-row'));
    var total = rows.length;
    var $ = function(id) {
        return document.getElementById(id);
    };

    /* ---------- Filtres ---------- */
    function filtrer() {
        var q = $('searchRegistre').value.toLowerCase().trim();
        var sit = $('filterSituation').value;
        var cat = $('filterCategorie').value;
        var site = $('filterSite').value;
        var an = $('filterAnnee').value;
        var n = 0;

        rows.forEach(function(tr) {
            var d = tr.dataset;
            var ok = (!q || d.search.indexOf(q) !== -1) && (!sit || d.situation === sit) &&
                (!cat || d.categorie === cat) && (!site || d.site === site) && (!an || d.annee === an);
            tr.style.display = ok ? '' : 'none';
            if (ok) n++;
        });

        $('regVide').style.display = (n === 0 && total > 0) ? '' : 'none';
        $('regCompteur').textContent = 'Registre mis à jour le <?= date('d/m/Y') ?> · ' +
            (n === total ? total + ' inscrit' + (total > 1 ? 's' : '') : n + ' affiché' + (n > 1 ? 's' : '') +
                ' sur ' + total);
    }

    $('searchRegistre').addEventListener('input', filtrer);
    ['filterSituation', 'filterCategorie', 'filterSite', 'filterAnnee'].forEach(function(id) {
        $(id).addEventListener('change', filtrer);
    });

    /* ---------- Afficher / masquer la feuille 2 (compléments) ---------- */
    $('toggleF2').addEventListener('change', function() {
        table.classList.toggle('registre-masque-f2', !this.checked);
    });

    /* ---------- Impression ---------- */
    $('btnPrintRegistre').addEventListener('click', function() {
        window.print();
    });

    /* ---------- Export CSV : colonnes et lignes affichées, dans l'ordre du registre ---------- */
    $('btnCsvRegistre').addEventListener('click', function() {
        var avecF2 = $('toggleF2').checked;
        var garder = function(cell) {
            return avecF2 || !cell.classList.contains('col-f2');
        };
        var cel = function(t) {
            return '"' + String(t).replace(/\s+/g, ' ').trim().replace(/"/g, '""') + '"';
        };

        var entetes = Array.prototype.slice.call(table.querySelectorAll('thead tr:last-child th'))
            .filter(garder).map(function(th) {
                return cel(th.innerText);
            });
        var lignes = [entetes.join(';')];

        rows.forEach(function(tr) {
            if (tr.style.display === 'none') return;
            lignes.push(Array.prototype.slice.call(tr.cells).filter(garder)
                .map(function(td) {
                    return cel(td.innerText);
                }).join(';'));
        });

        var blob = new Blob(['\ufeff' + lignes.join('\r\n')], {
            type: 'text/csv;charset=utf-8;'
        });
        var a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'registre_general_emploi_' + new Date().toISOString().slice(0, 10) + '.csv';
        document.body.appendChild(a);
        a.click();
        a.remove();
    });

    filtrer();
});
</script>