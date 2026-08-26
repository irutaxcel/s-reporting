<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- ============ STYLE LOCAL (page registre) ============ -->
            <style>
            .registre-table th {
                background: #f4f6f9;
                font-size: .82rem;
                text-transform: uppercase;
                letter-spacing: .02em;
            }

            .registre-table td {
                font-size: .9rem;
            }

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

            @media print {
                .print-only {
                    display: block !important;
                }

                .no-print {
                    display: none !important;
                }

                .card {
                    border: 1px solid #000 !important;
                    box-shadow: none !important;
                }

                .info-box {
                    break-inside: avoid;
                }

                .registre-table tbody tr {
                    break-inside: avoid;
                }
            }
            </style>

            <?php
            /* ----- Dernière sortie par employé (démission, licenciement, fin de contrat, retraite) ----- */
            $sorties = [];
            foreach ($mouvements as $m) {
                if (
                    in_array($m->type_mouvement, ['Démission', 'Licenciement', 'Fin de contrat', 'Retraite'])
                    && !isset($sorties[$m->employe_id])
                ) {
                    $sorties[$m->employe_id] = $m;   // mouvements triés DESC → 1er rencontré = le plus récent
                }
            }

            $badge_type = ['CDI' => 'success', 'CDD' => 'warning', 'Stage' => 'info'];

            /* ----- Indicateurs ----- */
            $total = count($employes);
            $en_service = $nb_actifs = $nb_conge = $nb_sortis = 0;
            foreach ($employes as $e) {
                if ($e->statut === 'Fin de contrat') {
                    $nb_sortis++;
                    continue;
                }
                $en_service++;
                ($e->statut === 'En congé') ? $nb_conge++ : $nb_actifs++;
            }
            ?>

            <!-- ============ 1. INDICATEURS DU REGISTRE ============ -->
            <div class="row">
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
                            <span class="info-box-number"><?= $en_service ?></span>
                            <span class="progress-description"><?= $nb_actifs ?> actifs · <?= $nb_conge ?> en
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
                            <span class="progress-description">Démission · retraite · fin de contrat</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ 2. IDENTITÉ DE L'EMPLOYEUR + RAPPEL LÉGAL ============ -->
            <div class="row">
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
                                mesures d'application, tout employeur est tenu de tenir un <strong>registre du
                                    personnel</strong> à jour, à présenter à toute réquisition de l'<strong>Inspection
                                    Générale du Travail</strong> et de l'<strong>OBEM</strong>.
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

            <!-- ============ 3. REGISTRE DU PERSONNEL ============ -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="card-title mb-0"><i class="fas fa-book mr-1 text-success"></i> Registre du personnel
                        </h3>
                        <div class="no-print">
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-download mr-1"></i> Exporter
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-file-excel mr-2 text-success"></i>Excel</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-file-pdf mr-2 text-danger"></i>PDF</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" onclick="window.print()">
                                <i class="fas fa-print mr-1"></i> Imprimer le registre
                            </button>
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div class="row mt-3 no-print">
                        <div class="col-md-5 mb-2">
                            <div class="input-group">
                                <input type="search" id="searchRegistre" class="form-control"
                                    placeholder="Rechercher (nom, matricule, CNID…)">
                                <div class="input-group-append"><span class="input-group-text"><i
                                            class="fas fa-search"></i></span></div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select id="filterSite" class="form-control">
                                <option value="">Site : tous</option>
                                <option>Siège (Bujumbura)</option>
                                <option>Chantier Ngagara II</option>
                                <option>Chantier Gitega</option>
                                <option>Chantier Ngozi</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select id="filterSituation" class="form-control">
                                <option value="">Situation : tous</option>
                                <option>En service</option>
                                <option>En congé</option>
                                <option>Sorti</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select id="filterCategorie" class="form-control">
                                <option value="">Catégorie : tous</option>
                                <option>Bureau</option>
                                <option>Chantier</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped text-nowrap registre-table">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Matricule</th>
                                <th>Nom &amp; prénoms</th>
                                <th>Sexe</th>
                                <th>Date de naissance</th>
                                <th>N° CNID</th>
                                <th>Fonction</th>
                                <th>Cat.</th>
                                <th>Affectation</th>
                                <th>Embauche</th>
                                <th>Contrat</th>
                                <th>N° INSS</th>
                                <th>Situation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 0;
                            foreach ($employes as $e): $n++;
                                $sexe   = ($e->sexe === 'Féminin') ? 'F' : 'M';
                                $sorti  = isset($sorties[$e->employe_id]) ? $sorties[$e->employe_id] : NULL;
                                $affect = ($e->categorie === 'Chantier') ? $e->site_affectation : $e->departement;
                            ?>
                            <tr data-site="<?= html_escape($affect) ?>"
                                data-categorie="<?= html_escape($e->categorie) ?>"
                                data-situation="<?= $sorti ? 'Sorti' : ($e->statut === 'Fin de contrat' ? 'Sorti' : ($e->statut === 'En congé' ? 'En congé' : 'En service')) ?>">
                                <td><?= $n ?></td>
                                <td><strong><?= html_escape($e->matricule) ?></strong></td>
                                <td><?= html_escape(mb_strtoupper($e->nom) . ' ' . $e->prenoms) ?></td>
                                <td><?= $sexe ?></td>
                                <td><?= $e->date_naissance ? date('d/m/Y', strtotime($e->date_naissance)) : '—' ?></td>
                                <td><?= html_escape($e->cnid ?: '—') ?></td>
                                <td><?= html_escape($e->fonction) ?></td>
                                <td><?= html_escape($e->categorie) ?></td>
                                <td><?= html_escape($affect) ?></td>
                                <td><?= date('d/m/Y', strtotime($e->date_embauche)) ?></td>
                                <td><span
                                        class="badge badge-<?= $badge_type[$e->type_contrat] ?? 'secondary' ?>"><?= $e->type_contrat ?></span>
                                </td>
                                <td><?= html_escape($e->matricule_inss ?: '—') ?></td>
                                <td>
                                    <?php if ($sorti): ?>
                                    <span class="badge badge-secondary">Sorti —
                                        <?= strtolower($sorti->type_mouvement) ?>
                                        <?= date('d/m/Y', strtotime($sorti->date_effet)) ?></span>
                                    <?php elseif ($e->statut === 'Fin de contrat'): ?>
                                    <span class="badge badge-secondary">Sorti</span>
                                    <?php elseif ($e->statut === 'En congé'): ?>
                                    <span class="badge badge-info">En congé</span>
                                    <?php elseif ($e->statut === 'Suspendu'): ?>
                                    <span class="badge badge-warning">Suspendu</span>
                                    <?php else: ?>
                                    <span class="badge badge-success">En service</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <small class="text-muted float-left mt-2">
                        Registre mis à jour le <?= date('d/m/Y') ?> · Affichage de <?= $total ?>
                        inscrit<?= $total > 1 ? 's' : '' ?>
                    </small>
                    <ul class="pagination pagination-sm float-right mb-0 no-print">
                        <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div>

            <!-- ============ 4. BLOC DE SIGNATURES (visible uniquement à l'impression) ============ -->
            <div class="print-only mt-4">
                <p class="mb-4">Fait à Bujumbura, le <?= date('d/m/Y') ?></p>
                <div class="row text-center">
                    <div class="col-6">
                        <strong>Le Responsable RH</strong><br><br><br>
                        ______________________
                    </div>
                    <div class="col-6">
                        <strong>Pour la Direction Générale</strong><br><br><br>
                        ______________________
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ===== Recherche textuelle ===== */
    var s = document.getElementById('searchRegistre');
    if (s) {
        s.addEventListener('keyup', filtrer);
    }

    /* ===== Filtres par select (site, situation, catégorie) ===== */
    ['filterSite', 'filterSituation', 'filterCategorie'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('change', filtrer);
    });

    function filtrer() {
        var q = (s ? s.value : '').toLowerCase();
        var sit = document.getElementById('filterSite');
        var sts = document.getElementById('filterSituation');
        var cat = document.getElementById('filterCategorie');

        var fSite = sit ? sit.value : '';
        var fStat = sts ? sts.value : '';
        var fCat = cat ? cat.value : '';

        document.querySelectorAll('.registre-table tbody tr').forEach(function(tr) {
            var txt = tr.textContent.toLowerCase();
            var txtOk = !q || txt.indexOf(q) !== -1;
            var siteOk = !fSite || tr.dataset.site === fSite;
            var catOk = !fCat || tr.dataset.categorie === fCat;
            var statOk = !fStat || tr.dataset.situation === fStat;
            tr.style.display = (txtOk && siteOk && catOk && statOk) ? '' : 'none';
        });
    }
});
</script>