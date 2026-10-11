<?php
$fmt    = function ($n) {
    return number_format((float) $n, 0, ',', ' ');
};
$dateFr = function ($d) {
    return $d ? date('d/m/Y', strtotime($d)) : '—';
};
$statutClass = ['brouillon' => 'secondary', 'emis' => 'primary', 'en_cours' => 'info', 'execute' => 'success', 'annule' => 'dark'];
$typeClass   = [
    'demarrage' => 'success',
    'arret' => 'danger',
    'reprise' => 'info',
    'travaux_supp' => 'warning',
    'modification' => 'primary',
    'prolongation' => 'secondary',
    'autre' => 'light'
];
$st = $stats;
?>
<style>
.os-table td,
.os-table th {
    vertical-align: middle;
}

.os-section {
    font-weight: 600;
    margin: 16px 0 8px;
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 4px;
}

.os-detail td.l {
    width: 30%;
    background: #f6f8f6;
    font-weight: 600;
}

.os-desc {
    white-space: pre-wrap;
}
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- 1. TUILES -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= (int) $st['mois'] ?></h3>
                            <p>OS émis / reçus ce mois</p>
                        </div>
                        <div class="icon"><i class="fas fa-file-signature"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?= (int) $st['actifs'] ?> <small style="font-size:1rem">+
                                    <?= (int) $st['brouillons'] ?> brouillon(s)</small></h3>
                            <p>OS en cours (notifiés / en exécution)</p>
                        </div>
                        <div class="icon"><i class="fas fa-tasks"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="<?= site_url('ordre-service') ?>?statut=retard" class="small-box bg-danger d-block">
                        <div class="inner">
                            <h3><?= (int) $st['retard'] ?></h3>
                            <p>OS dont l'échéance est dépassée</p>
                        </div>
                        <div class="icon"><i class="fas fa-hourglass-end"></i></div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $fmt($st['montant_supp']) ?></h3>
                            <p>Travaux supplémentaires / modifs (BIF)</p>
                        </div>
                        <div class="icon"><i class="fas fa-coins"></i></div>
                    </div>
                </div>
            </div>

            <?php foreach (['success' => 'success', 'error' => 'danger', 'warning' => 'warning'] as $k => $cls):
                if ($this->session->flashdata($k)): ?>
            <div class="alert alert-<?= $cls ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $this->session->flashdata($k) ?>
            </div>
            <?php endif;
            endforeach; ?>

            <!-- 2. LISTE -->
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-signature mr-2"></i>Ordres de service
                        (<?= (int) $total ?>)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-primary" id="osNew"><i
                                class="fas fa-plus mr-1"></i>Nouvel ordre de service</button>
                        <a href="<?= site_url('ordre-service/export') . ($queryString ? '?' . $queryString : '') ?>"
                            class="btn btn-sm btn-success"><i class="fas fa-file-excel mr-1"></i>Exporter</a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="<?= site_url('ordre-service') ?>" method="get">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label>Chantier</label>
                                    <select name="chantier" class="form-control">
                                        <option value="">Tous les chantiers</option>
                                        <?php foreach ($allChantiers as $c): ?>
                                        <option value="<?= (int) $c['id'] ?>"
                                            <?= $filters['chantier_id'] == $c['id'] ? 'selected' : '' ?>>
                                            <?= html_escape($c['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label>Type</label>
                                    <select name="type" class="form-control">
                                        <option value="">Tous</option>
                                        <?php foreach ($types as $k => $lbl): ?>
                                        <option value="<?= $k ?>" <?= $filters['type'] === $k ? 'selected' : '' ?>>
                                            <?= $lbl ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label>Statut</label>
                                    <select name="statut" class="form-control">
                                        <option value="">Tous</option>
                                        <?php foreach ($statuts as $k => $lbl): ?>
                                        <option value="<?= $k ?>" <?= $filters['statut'] === $k ? 'selected' : '' ?>>
                                            <?= $lbl ?></option>
                                        <?php endforeach; ?>
                                        <option value="retard" <?= $filters['statut'] === 'retard' ? 'selected' : '' ?>>
                                            En retard</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label>Sens</label>
                                    <select name="sens" class="form-control">
                                        <option value="">Tous</option>
                                        <?php foreach ($sensList as $k => $lbl): ?>
                                        <option value="<?= $k ?>" <?= $filters['sens'] === $k ? 'selected' : '' ?>>
                                            <?= $lbl ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label>Recherche</label>
                                    <input type="text" name="q" class="form-control"
                                        placeholder="N°, objet, destinataire…"
                                        value="<?= html_escape($filters['q']) ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label>Émis du</label>
                                    <input type="date" name="date_debut" class="form-control"
                                        value="<?= html_escape($filters['date_debut']) ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label>au</label>
                                    <input type="date" name="date_fin" class="form-control"
                                        value="<?= html_escape($filters['date_fin']) ?>">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="btn-group btn-block mb-2">
                                    <button type="submit" class="btn btn-success"><i
                                            class="fas fa-search mr-1"></i>Filtrer</button>
                                    <a href="<?= site_url('ordre-service') ?>" class="btn btn-secondary"
                                        title="Réinitialiser"><i class="fas fa-redo-alt"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover table-striped os-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:40px">#</th>
                                    <th>N° / Date</th>
                                    <th>Chantier</th>
                                    <th>Type</th>
                                    <th>Objet</th>
                                    <th>Effet / Échéance</th>
                                    <th class="text-right">Montant</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-center" style="width:150px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($rows)): ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">Aucun ordre de service.</td>
                                </tr>
                                <?php else: foreach ($rows as $i => $o): ?>
                                <tr>
                                    <td><?= $offset + $i + 1 ?></td>
                                    <td class="text-nowrap">
                                        <strong><?= html_escape($o['numero']) ?></strong><br>
                                        <small class="text-muted"><?= $dateFr($o['date_emission']) ?></small><br>
                                        <small><i
                                                class="fas <?= $o['sens'] === 'recu' ? 'fa-arrow-down text-info' : 'fa-arrow-up text-success' ?> mr-1"></i><?= $o['sens'] === 'recu' ? 'Reçu' : 'Émis' ?></small>
                                    </td>
                                    <td>
                                        <strong><?= html_escape($o['chantier_name']) ?></strong>
                                        <?php if ($o['projet_name']): ?><br><small
                                            class="text-muted"><?= html_escape($o['projet_name']) ?></small><?php endif; ?>
                                    </td>
                                    <td><span
                                            class="badge badge-<?= $typeClass[$o['type_os']] ?? 'light' ?>"><?= html_escape($types[$o['type_os']] ?? $o['type_os']) ?></span>
                                    </td>
                                    <td>
                                        <?= html_escape($o['objet']) ?>
                                        <?php if ($o['destinataire'] || $o['subcontractor_name']): ?>
                                        <br><small class="text-muted"><i
                                                class="fas fa-user mr-1"></i><?= html_escape($o['destinataire'] ?: $o['subcontractor_name']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?= $dateFr($o['date_effet']) ?>
                                        <?php if ($o['echeance']): ?>
                                        <br><small
                                            class="<?= $o['en_retard'] ? 'text-danger font-weight-bold' : 'text-muted' ?>">
                                            → <?= $dateFr($o['echeance']) ?> (<?= (int) $o['delai_jours'] ?> j)
                                        </small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right text-nowrap">
                                        <?= $o['montant'] !== null ? $fmt($o['montant']) : '—' ?></td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-<?= $statutClass[$o['statut']] ?? 'secondary' ?>"><?= $statuts[$o['statut']] ?? $o['statut'] ?></span>
                                        <?php if ($o['en_retard']): ?><br><span class="badge badge-danger mt-1">En
                                            retard</span><?php endif; ?>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <button type="button" class="btn btn-sm btn-info js-os-detail"
                                            data-id="<?= (int) $o['id'] ?>" title="Détail"><i
                                                class="fas fa-eye"></i></button>
                                        <?php if (!in_array($o['statut'], ['execute', 'annule'], true)): ?>
                                        <button type="button" class="btn btn-sm btn-warning js-os-edit"
                                            data-id="<?= (int) $o['id'] ?>" title="Modifier"><i
                                                class="fas fa-edit"></i></button>
                                        <?php endif; ?>
                                        <a href="<?= site_url('ordre-service/print/' . (int) $o['id']) ?>"
                                            target="_blank" class="btn btn-sm btn-secondary" title="Imprimer"><i
                                                class="fas fa-print"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <small class="text-muted float-left">Échéance = date d'effet + délai d'exécution. Un OS notifié ou
                        en exécution dont l'échéance est passée est signalé en retard.</small>
                    <?= $pagination ?>
                </div>
            </div>

            <!-- 3. MODALE FORMULAIRE -->
            <div class="modal fade" id="osFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form class="modal-content" id="osForm" method="post" enctype="multipart/form-data"
                        action="<?= site_url('ordre-service/store') ?>">
                        <input type="hidden" name="<?= $csrfName ?>" value="<?= $csrfHash ?>" class="js-csrf">
                        <input type="hidden" name="id" id="os_id" value="">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title"><i class="fas fa-file-signature mr-2"></i><span
                                    id="osFormTitle">Nouvel ordre de service</span></h5>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sens</label><br>
                                        <?php foreach ($sensList as $k => $lbl): ?>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="os_sens_<?= $k ?>"
                                                name="sens" value="<?= $k ?>" <?= $k === 'emis' ? 'checked' : '' ?>>
                                            <label class="custom-control-label"
                                                for="os_sens_<?= $k ?>"><?= $lbl ?></label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>N°</label>
                                        <input type="text" class="form-control" id="os_numero"
                                            value="<?= html_escape($codePreview) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Type <span class="text-danger">*</span></label>
                                        <select name="type_os" id="os_type" class="form-control" required>
                                            <option value="">— Choisir —</option>
                                            <?php foreach ($types as $k => $lbl): ?><option value="<?= $k ?>">
                                                <?= $lbl ?></option><?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Chantier <span class="text-danger">*</span></label>
                                        <select name="chantier_id" id="os_chantier" class="form-control" required>
                                            <option value="">— Choisir —</option>
                                            <?php foreach ($allChantiers as $c): ?><option
                                                value="<?= (int) $c['id'] ?>"><?= html_escape($c['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 js-os-emis">
                                    <div class="form-group">
                                        <label>Sous-traitant (facultatif)</label>
                                        <select name="subcontractor_id" id="os_sub" class="form-control">
                                            <option value="">— Aucun —</option>
                                            <?php foreach ($subcontractors as $s): ?>
                                            <option value="<?= (int) $s['id'] ?>">
                                                <?= html_escape($s['name']) ?><?= $s['specialty'] ? ' — ' . html_escape($s['specialty']) : '' ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Émetteur</label>
                                        <input type="text" name="emetteur" id="os_emetteur" class="form-control"
                                            maxlength="191">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Destinataire</label>
                                        <input type="text" name="destinataire" id="os_dest" class="form-control"
                                            maxlength="191">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Objet <span class="text-danger">*</span></label>
                                        <input type="text" name="objet" id="os_objet" class="form-control"
                                            maxlength="255" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Description / prescriptions</label>
                                        <textarea name="description" id="os_desc" class="form-control"
                                            rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date d'émission <span class="text-danger">*</span></label>
                                        <input type="date" name="date_emission" id="os_date_em" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date d'effet</label>
                                        <input type="date" name="date_effet" id="os_date_eff" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Délai (jours)</label>
                                        <input type="number" min="0" step="1" name="delai_jours" id="os_delai"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Montant (BIF)</label>
                                        <input type="number" min="0" step="1" name="montant" id="os_montant"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pièce jointe (OS signé : PDF, JPG, PNG — 10 Mo)</label>
                                        <input type="file" name="fichier" class="form-control-file"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <small id="os_fichier_actuel" class="text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Observation</label>
                                        <textarea name="observation" id="os_obs" class="form-control"
                                            rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">Un OS émis est créé en <strong>brouillon</strong> ; un OS reçu est
                                enregistré directement comme <strong>notifié</strong>.</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary"><i
                                    class="fas fa-save mr-1"></i>Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 4. MODALE DÉTAIL -->
            <div class="modal fade" id="osDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title"><i class="fas fa-file-signature mr-2"></i><span
                                    id="osDetailTitle">Détail</span></h5>
                            <button type="button" class="close text-white"
                                data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body" id="osDetailBody"></div>
                        <div class="modal-footer" id="osDetailFooter"></div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var $ = window.jQuery;
    var URL = {
        store: <?= json_encode(site_url('ordre-service/store')) ?>,
        update: <?= json_encode(site_url('ordre-service/update')) ?>,
        get: <?= json_encode(site_url('ordre-service/get')) ?>,
        statut: <?= json_encode(site_url('ordre-service/statut')) ?>,
        del: <?= json_encode(site_url('ordre-service/delete')) ?>
    };
    var CSRF = {
        name: <?= json_encode($csrfName) ?>,
        hash: <?= json_encode($csrfHash) ?>
    };
    var TYPES = <?= json_encode($types) ?>;
    var STATUTS = <?= json_encode($statuts) ?>;
    var SENS = <?= json_encode($sensList) ?>;
    var STATUT_CLASS = <?= json_encode($statutClass) ?>;
    var NUMERO_PREVIEW = <?= json_encode($codePreview) ?>;

    var form = document.getElementById('osForm');
    var detailBody = document.getElementById('osDetailBody');
    var detailFooter = document.getElementById('osDetailFooter');
    var detailTitle = document.getElementById('osDetailTitle');

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function(c) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [c];
        });
    }

    function dateFr(d) {
        return d ? String(d).substring(0, 10).split('-').reverse().join('/') : '—';
    }

    function fmt(n) {
        return Math.round(Number(n) || 0).toLocaleString('fr-FR').replace(/[\u202f\u00a0]/g, ' ');
    }

    function majCsrf(hash) {
        if (!hash) {
            return;
        }
        CSRF.hash = hash;
        document.querySelectorAll('.js-csrf').forEach(function(i) {
            i.value = hash;
        });
    }

    function sensCourant() {
        var r = form.querySelector('input[name="sens"]:checked');
        return r ? r.value : 'emis';
    }

    function majSens() {
        var emis = sensCourant() === 'emis';
        document.querySelectorAll('.js-os-emis').forEach(function(el) {
            el.style.display = emis ? '' : 'none';
        });
        var em = document.getElementById('os_emetteur');
        if (emis && !em.value) {
            em.value = 'SATRACO Construction';
        }
        if (!emis && em.value === 'SATRACO Construction') {
            em.value = '';
        }
        em.placeholder = emis ? 'SATRACO Construction' : "Maître d'ouvrage / bureau de contrôle";
    }
    form.querySelectorAll('input[name="sens"]').forEach(function(r) {
        r.addEventListener('change', majSens);
    });

    document.getElementById('os_sub').addEventListener('change', function() {
        var dest = document.getElementById('os_dest');
        if (this.value && !dest.value) {
            dest.value = this.options[this.selectedIndex].text.split(' — ')[0];
        }
    });

    function getJson(url) {
        return fetch(url, {
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(r) {
                var type = r.headers.get('content-type') || '';
                if (type.indexOf('application/json') === -1) {
                    throw new Error('Erreur serveur (HTTP ' + r.status + ').');
                }
                return r.json();
            })
            .then(function(j) {
                majCsrf(j.csrf);
                if (!j.success) {
                    throw new Error(j.message || 'Erreur.');
                }
                return j;
            });
    }

    function postJson(url, data) {
        var fd = new FormData();
        fd.append(CSRF.name, CSRF.hash);
        Object.keys(data).forEach(function(k) {
            fd.append(k, data[k]);
        });
        return fetch(url, {
                method: 'POST',
                body: fd,
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(r) {
                var type = r.headers.get('content-type') || '';
                if (type.indexOf('application/json') === -1) {
                    throw new Error('Erreur serveur (HTTP ' + r.status + ').');
                }
                return r.json();
            })
            .then(function(j) {
                majCsrf(j.csrf);
                if (!j.success) {
                    throw new Error(j.message || 'Erreur.');
                }
                return j;
            });
    }

    // ---------- Création ----------
    document.getElementById('osNew').addEventListener('click', function() {
        form.reset();
        form.action = URL.store;
        document.getElementById('os_id').value = '';
        document.getElementById('os_numero').value = NUMERO_PREVIEW + ' (provisoire)';
        document.getElementById('os_date_em').value = new Date().toISOString().substring(0, 10);
        document.getElementById('os_fichier_actuel').textContent = '';
        document.getElementById('osFormTitle').textContent = 'Nouvel ordre de service';
        form.querySelectorAll('input[name="sens"]').forEach(function(r) {
            r.disabled = false;
        });
        majSens();
        $('#osFormModal').modal('show');
    });

    // ---------- Modification ----------
    function ouvrirEdition(id) {
        getJson(URL.get + '/' + id).then(function(j) {
            var o = j.os;
            form.reset();
            form.action = URL.update;
            document.getElementById('os_id').value = o.id;
            document.getElementById('os_numero').value = o.numero;
            form.querySelector('input[name="sens"][value="' + o.sens + '"]').checked = true;
            document.getElementById('os_type').value = o.type_os;
            document.getElementById('os_chantier').value = o.chantier_id;
            document.getElementById('os_sub').value = o.subcontractor_id || '';
            document.getElementById('os_emetteur').value = o.emetteur || '';
            document.getElementById('os_dest').value = o.destinataire || '';
            document.getElementById('os_objet').value = o.objet || '';
            document.getElementById('os_desc').value = o.description || '';
            document.getElementById('os_date_em').value = o.date_emission || '';
            document.getElementById('os_date_eff').value = o.date_effet || '';
            document.getElementById('os_delai').value = o.delai_jours !== null ? o.delai_jours : '';
            document.getElementById('os_montant').value = o.montant !== null ? Math.round(o.montant) :
                '';
            document.getElementById('os_obs').value = o.observation || '';
            document.getElementById('os_fichier_actuel').innerHTML = o.fichier_url ?
                'Actuel : <a href="' + esc(o.fichier_url) + '" target="_blank">' + esc(o.fichier_nom ||
                    'fichier') + '</a> (un nouveau fichier le remplace)' :
                '';
            document.getElementById('osFormTitle').textContent = 'Modifier ' + o.numero;
            majSens();
            $('#osDetailModal').modal('hide');
            $('#osFormModal').modal('show');
        }).catch(function(e) {
            alert(e.message);
        });
    }
    document.querySelectorAll('.js-os-edit').forEach(function(b) {
        b.addEventListener('click', function() {
            ouvrirEdition(b.dataset.id);
        });
    });

    // ---------- Détail ----------
    function ligne(l, v) {
        return '<tr><td class="l">' + l + '</td><td>' + v + '</td></tr>';
    }

    function ouvrirDetail(id) {
        detailTitle.textContent = 'Chargement…';
        detailBody.innerHTML =
            '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-info"></i></div>';
        detailFooter.innerHTML = '';
        $('#osDetailModal').modal('show');

        getJson(URL.get + '/' + id).then(function(j) {
            var o = j.os;
            detailTitle.textContent = o.numero + ' — ' + (TYPES[o.type_os] || o.type_os);

            var h = '<p><span class="badge badge-' + (STATUT_CLASS[o.statut] || 'secondary') + '">' +
                esc(STATUTS[o.statut] || o.statut) + '</span>' +
                (Number(o.en_retard) ? ' <span class="badge badge-danger">En retard</span>' : '') +
                ' <span class="text-muted ml-2">' + esc(SENS[o.sens] || o.sens) + '</span></p>';

            h += '<table class="table table-bordered table-sm os-detail">' +
                ligne('Chantier', esc(o.chantier_name) + (o.projet_name ?
                    ' <small class="text-muted">(' + esc(o.projet_name) + ')</small>' : '')) +
                ligne('Émetteur', esc(o.emetteur || '—')) +
                ligne('Destinataire', esc(o.destinataire || '—') + (o.subcontractor_name ?
                    ' <small class="text-muted">— sous-traitant : ' + esc(o.subcontractor_name) +
                    '</small>' : '')) +
                ligne('Objet', '<strong>' + esc(o.objet) + '</strong>') +
                ligne("Date d'émission", dateFr(o.date_emission)) +
                ligne('Notification', dateFr(o.date_notification)) +
                ligne("Date d'effet", dateFr(o.date_effet)) +
                ligne("Délai d'exécution", o.delai_jours !== null ? o.delai_jours +
                    ' jour(s) — échéance ' + dateFr(o.echeance) : '—') +
                ligne('Montant', o.montant !== null ? fmt(o.montant) + ' BIF' : '—') +
                ligne('Exécuté le', dateFr(o.date_execution)) +
                ligne('Pièce jointe', o.fichier_url ? '<a href="' + esc(o.fichier_url) +
                    '" target="_blank"><i class="fas fa-paperclip mr-1"></i>' + esc(o.fichier_nom ||
                        'Ouvrir') + '</a>' : '—') +
                '</table>';

            if (o.description) {
                h += '<div class="os-section">Description / prescriptions</div><div class="os-desc">' +
                    esc(o.description) + '</div>';
            }
            if (o.observation) {
                h += '<div class="os-section">Observation</div><div class="os-desc">' + esc(o
                    .observation) + '</div>';
            }
            detailBody.innerHTML = h;

            // Pied : actions
            var f = '<a href="' + esc(o.print_url) +
                '" target="_blank" class="btn btn-secondary mr-auto"><i class="fas fa-print mr-1"></i>Imprimer</a>';
            if (o.statut === 'brouillon') {
                f += '<button type="button" class="btn btn-outline-danger js-os-del" data-id="' + o.id +
                    '"><i class="fas fa-trash mr-1"></i>Supprimer</button>';
            }
            if (o.modifiable) {
                f += '<button type="button" class="btn btn-warning js-os-edit2" data-id="' + o.id +
                    '"><i class="fas fa-edit mr-1"></i>Modifier</button>';
            }
            (o.transitions || []).forEach(function(t) {
                var cls = t === 'annule' ? 'btn-outline-dark' : 'btn-' + (STATUT_CLASS[t] ||
                    'primary');
                f += '<button type="button" class="btn ' + cls + ' js-os-statut" data-id="' + o
                    .id + '" data-statut="' + t + '">' +
                    (t === 'annule' ? 'Annuler l\'OS' : '→ ' + esc(STATUTS[t])) + '</button>';
            });
            detailFooter.innerHTML = f;
        }).catch(function(e) {
            detailTitle.textContent = 'Erreur';
            detailBody.innerHTML = '<div class="alert alert-danger mb-0">' + esc(e.message) + '</div>';
        });
    }
    document.querySelectorAll('.js-os-detail').forEach(function(b) {
        b.addEventListener('click', function() {
            ouvrirDetail(b.dataset.id);
        });
    });

    detailFooter.addEventListener('click', function(e) {
        var b = e.target.closest('button');
        if (!b) {
            return;
        }
        if (b.classList.contains('js-os-edit2')) {
            ouvrirEdition(b.dataset.id);
            return;
        }

        if (b.classList.contains('js-os-statut')) {
            var label = b.dataset.statut === 'annule' ? 'annuler cet ordre de service' :
                'passer au statut « ' + STATUTS[b.dataset.statut] + ' »';
            if (!confirm('Confirmer : ' + label + ' ?')) {
                return;
            }
            b.disabled = true;
            postJson(URL.statut, {
                    id: b.dataset.id,
                    statut: b.dataset.statut
                })
                .then(function() {
                    location.reload();
                })
                .catch(function(err) {
                    alert(err.message);
                    b.disabled = false;
                });
        }

        if (b.classList.contains('js-os-del')) {
            if (!confirm('Supprimer définitivement ce brouillon ?')) {
                return;
            }
            b.disabled = true;
            postJson(URL.del, {
                    id: b.dataset.id
                })
                .then(function() {
                    location.reload();
                })
                .catch(function(err) {
                    alert(err.message);
                    b.disabled = false;
                });
        }
    });
});
</script>