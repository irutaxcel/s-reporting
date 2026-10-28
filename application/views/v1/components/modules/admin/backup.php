<?php
$fmtSize = function ($b) {
    $b = (float) $b;
    $u = ['o', 'Ko', 'Mo', 'Go'];
    $i = 0;
    while ($b >= 1024 && $i < 3) {
        $b /= 1024;
        $i++;
    }
    return number_format($b, $i ? 2 : 0, ',', ' ') . ' ' . $u[$i];
};
$lastBackup = !empty($backups) ? $backups[0] : null;
$totalBackupSize = array_sum(array_column($backups, 'size'));
?>

<style>
.bk-page {
    --bk-primary: #0f766e;
    --bk-primary-dark: #064b43;
    --bk-accent: #74c476;
    --bk-soft: #f4faf7;
    --bk-border: #e2ece7;
    --bk-danger: #dc3545;
    --bk-muted: #6b7f78;
}

.bk-page .bk-stat {
    background: #fff;
    border: 1px solid var(--bk-border);
    border-radius: 14px;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    height: 100%;
    box-shadow: 0 2px 8px rgba(16, 32, 51, .04);
}

.bk-page .bk-stat-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    color: #fff;
    flex-shrink: 0;
    background: linear-gradient(135deg, var(--bk-primary), var(--bk-accent));
}

.bk-page .bk-stat-label {
    font-size: 12px;
    color: var(--bk-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .4px;
}

.bk-page .bk-stat-value {
    font-size: 19px;
    font-weight: 800;
    color: var(--bk-primary-dark);
    line-height: 1.2;
    word-break: break-all;
}

.bk-page .bk-stat-sub {
    font-size: 11.5px;
    color: var(--bk-muted);
}

.bk-page .bk-card {
    background: #fff;
    border: 1px solid var(--bk-border);
    border-radius: 14px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(16, 32, 51, .04);
}

.bk-page .bk-card-head {
    padding: 14px 18px;
    border-bottom: 1px solid var(--bk-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
}

.bk-page .bk-card-head h3 {
    font-size: 15.5px;
    font-weight: 800;
    color: var(--bk-primary-dark);
    margin: 0;
}

.bk-page .bk-card-head h3 i {
    color: var(--bk-primary);
    margin-right: 6px;
}

.bk-page .bk-card-body {
    padding: 18px;
}

.bk-page .bk-mode {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}

.bk-page .bk-mode label {
    flex: 1;
    min-width: 200px;
    border: 2px solid var(--bk-border);
    border-radius: 12px;
    padding: 12px 14px;
    cursor: pointer;
    margin: 0;
    transition: border-color .15s, background .15s;
}

.bk-page .bk-mode label.is-active {
    border-color: var(--bk-accent);
    background: var(--bk-soft);
}

.bk-page .bk-mode input {
    margin-right: 8px;
}

.bk-page .bk-mode strong {
    color: var(--bk-primary-dark);
}

.bk-page .bk-mode small {
    display: block;
    color: var(--bk-muted);
    margin-left: 22px;
}

.bk-page .bk-tables {
    display: none;
    border: 1px solid var(--bk-border);
    border-radius: 12px;
    margin-bottom: 14px;
}

.bk-page .bk-tables.is-visible {
    display: block;
}

.bk-page .bk-tables-tools {
    padding: 10px 12px;
    border-bottom: 1px solid var(--bk-border);
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
}

.bk-page .bk-tables-tools input[type=text] {
    flex: 1;
    min-width: 160px;
}

.bk-page .bk-tables-list {
    max-height: 300px;
    overflow-y: auto;
    padding: 8px 12px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 4px 14px;
}

.bk-page .bk-tables-list label {
    margin: 0;
    font-weight: 500;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 0;
    cursor: pointer;
}

.bk-page .bk-tables-list label span.meta {
    margin-left: auto;
    color: var(--bk-muted);
    font-size: 11px;
    white-space: nowrap;
}

.bk-page .btn-bk {
    background: var(--bk-primary);
    border-color: var(--bk-primary);
    color: #fff;
    font-weight: 700;
    border-radius: 10px;
    padding: 9px 18px;
}

.bk-page .btn-bk:hover {
    background: var(--bk-primary-dark);
    color: #fff;
}

.bk-page .btn-bk:disabled {
    opacity: .7;
}

.bk-page .bk-table {
    margin: 0;
}

.bk-page .bk-table th {
    font-size: 12px;
    text-transform: uppercase;
    color: var(--bk-muted);
    border-top: 0;
    background: var(--bk-soft);
}

.bk-page .bk-table td {
    vertical-align: middle;
    font-size: 13.5px;
}

.bk-page .bk-file {
    font-weight: 700;
    color: var(--bk-primary-dark);
    word-break: break-all;
}

.bk-page .bk-badge {
    display: inline-block;
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
    margin-left: 4px;
}

.bk-page .bk-badge.gz {
    background: #e0f2fe;
    color: #0369a1;
}

.bk-page .bk-badge.partial {
    background: #fef3c7;
    color: #92400e;
}

.bk-page .bk-badge.full {
    background: #dcfce7;
    color: #166534;
}

.bk-page .bk-empty {
    text-align: center;
    padding: 34px 10px;
    color: var(--bk-muted);
}

.bk-page .bk-empty i {
    font-size: 34px;
    margin-bottom: 8px;
    color: var(--bk-border);
}

.bk-page .bk-note {
    background: var(--bk-soft);
    border-left: 4px solid var(--bk-accent);
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 12.5px;
    color: var(--bk-primary-dark);
}

.bk-toast-wrap {
    position: fixed;
    top: 80px;
    right: 20px;
    z-index: 2000;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.bk-toast {
    min-width: 280px;
    max-width: 420px;
    padding: 12px 16px;
    border-radius: 10px;
    color: #fff;
    font-size: 13.5px;
    font-weight: 600;
    box-shadow: 0 8px 20px rgba(0, 0, 0, .18);
    animation: bkIn .2s ease;
}

.bk-toast.ok {
    background: #16a34a;
}

.bk-toast.err {
    background: #dc3545;
}

@keyframes bkIn {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }

    to {
        opacity: 1;
        transform: none;
    }
}
</style>

<div class="content-wrapper bk-page">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sauvegarde de la base de données</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item">Administration</li>
                        <li class="breadcrumb-item active">Sauvegarde BD</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- Statistiques -->
            <div class="row mb-3">
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="bk-stat">
                        <div class="bk-stat-icon"><i class="fas fa-database"></i></div>
                        <div>
                            <div class="bk-stat-label">Base</div>
                            <div class="bk-stat-value"><?= html_escape($dbStats->db_name) ?></div>
                            <div class="bk-stat-sub"><?= (int) $dbStats->tables_count ?> tables</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="bk-stat">
                        <div class="bk-stat-icon"><i class="fas fa-hdd"></i></div>
                        <div>
                            <div class="bk-stat-label">Taille de la base</div>
                            <div class="bk-stat-value"><?= $fmtSize($dbStats->size_bytes) ?></div>
                            <div class="bk-stat-sub">≈ <?= number_format((int) $dbStats->rows_count, 0, ',', ' ') ?>
                                lignes</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="bk-stat">
                        <div class="bk-stat-icon"><i class="fas fa-archive"></i></div>
                        <div>
                            <div class="bk-stat-label">Sauvegardes</div>
                            <div class="bk-stat-value"><?= count($backups) ?></div>
                            <div class="bk-stat-sub"><?= $fmtSize($totalBackupSize) ?> sur le serveur</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="bk-stat">
                        <div class="bk-stat-icon"><i class="fas fa-history"></i></div>
                        <div>
                            <div class="bk-stat-label">Dernière sauvegarde</div>
                            <div class="bk-stat-value" style="font-size:15px">
                                <?= $lastBackup ? date('d/m/Y H:i', $lastBackup['date']) : 'Aucune' ?>
                            </div>
                            <div class="bk-stat-sub"><?= $lastBackup ? $fmtSize($lastBackup['size']) : '—' ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nouvelle sauvegarde -->
            <div class="bk-card">
                <div class="bk-card-head">
                    <h3><i class="fas fa-plus-circle"></i> Nouvelle sauvegarde</h3>
                </div>
                <div class="bk-card-body">
                    <div class="bk-mode">
                        <label class="is-active" data-mode="all">
                            <input type="radio" name="bk_mode" value="all" checked>
                            <strong>Base complète</strong>
                            <small>Toutes les tables (recommandé)</small>
                        </label>
                        <label data-mode="selection">
                            <input type="radio" name="bk_mode" value="selection">
                            <strong>Tables sélectionnées</strong>
                            <small>Sauvegarde partielle</small>
                        </label>
                    </div>

                    <div class="bk-tables" id="bkTables">
                        <div class="bk-tables-tools">
                            <input type="text" class="form-control form-control-sm" id="bkSearch"
                                placeholder="Rechercher une table…">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="bkAll">Tout
                                cocher</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="bkNone">Tout
                                décocher</button>
                            <span class="small text-muted"><b id="bkCount">0</b> sélectionnée(s)</span>
                        </div>
                        <div class="bk-tables-list" id="bkList">
                            <?php foreach ($tables as $t): ?>
                            <label data-name="<?= html_escape(strtolower($t->name)) ?>">
                                <input type="checkbox" class="bk-tbl" value="<?= html_escape($t->name) ?>">
                                <?= html_escape($t->name) ?>
                                <span class="meta">≈<?= number_format((int) $t->rows_count, 0, ',', ' ') ?> ·
                                    <?= $fmtSize($t->size_bytes) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="bkCompress"
                                <?= $gzipOk ? 'checked' : 'disabled' ?>>
                            <label class="custom-control-label" for="bkCompress">
                                Compresser (.sql.gz)<?= $gzipOk ? '' : ' — zlib indisponible sur le serveur' ?>
                            </label>
                        </div>
                        <button type="button" class="btn btn-bk" id="bkCreate">
                            <i class="fas fa-download mr-1"></i> Lancer la sauvegarde
                        </button>
                    </div>
                </div>
            </div>

            <!-- Liste des sauvegardes -->
            <div class="bk-card">
                <div class="bk-card-head">
                    <h3><i class="fas fa-folder-open"></i> Sauvegardes disponibles</h3>
                </div>
                <?php if (empty($backups)): ?>
                <div class="bk-empty">
                    <i class="fas fa-box-open d-block"></i>
                    Aucune sauvegarde pour le moment.
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table bk-table">
                        <thead>
                            <tr>
                                <th>Fichier</th>
                                <th>Type</th>
                                <th>Taille</th>
                                <th>Date</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($backups as $b): ?>
                            <tr>
                                <td class="bk-file"><i class="far fa-file-code mr-1"></i><?= html_escape($b['name']) ?>
                                </td>
                                <td>
                                    <span
                                        class="bk-badge <?= $b['partial'] ? 'partial' : 'full' ?>"><?= $b['partial'] ? 'Partielle' : 'Complète' ?></span>
                                    <?php if ($b['compressed']): ?><span class="bk-badge gz">GZIP</span><?php endif; ?>
                                </td>
                                <td><?= $fmtSize($b['size']) ?></td>
                                <td><?= date('d/m/Y H:i:s', $b['date']) ?></td>
                                <td class="text-right text-nowrap">
                                    <a href="<?= base_url('backup/download?file=' . rawurlencode($b['name'])) ?>"
                                        class="btn btn-sm btn-outline-success" title="Télécharger">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger bk-del"
                                        data-file="<?= html_escape($b['name']) ?>" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            <div class="bk-note mb-4">
                <i class="fas fa-info-circle mr-1"></i>
                Pensez à télécharger régulièrement les sauvegardes et à les conserver hors du serveur.
                Pour restaurer : importez le fichier via phpMyAdmin ou
                <code>mysql -u USER -p NOM_BASE &lt; fichier.sql</code>
                (décompressez d'abord un <code>.sql.gz</code>).
            </div>

        </div>
    </section>
</div>

<div class="bk-toast-wrap" id="bkToasts"></div>

<script>
(function() {
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    let csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    const urlCreate = '<?= base_url('backup/create') ?>';
    const urlDelete = '<?= base_url('backup/delete') ?>';

    const $ = (s, c) => (c || document).querySelector(s);
    const $$ = (s, c) => Array.from((c || document).querySelectorAll(s));

    function toast(msg, ok) {
        const el = document.createElement('div');
        el.className = 'bk-toast ' + (ok ? 'ok' : 'err');
        el.textContent = msg;
        $('#bkToasts').appendChild(el);
        setTimeout(() => el.remove(), 4500);
    }

    function post(url, params) {
        const fd = new FormData();
        fd.append(csrfName, csrfHash);
        Object.keys(params).forEach(k => {
            const v = params[k];
            if (Array.isArray(v)) v.forEach(x => fd.append(k + '[]', x));
            else fd.append(k, v);
        });
        return fetch(url, {
                method: 'POST',
                body: fd,
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.json())
            .then(j => {
                if (j.csrf_hash) csrfHash = j.csrf_hash;
                return j;
            });
    }

    /* ---------- Mode complet / sélection ---------- */
    const modeLabels = $$('.bk-mode label');
    modeLabels.forEach(l => l.addEventListener('click', () => {
        modeLabels.forEach(x => x.classList.remove('is-active'));
        l.classList.add('is-active');
        $('input', l).checked = true;
        $('#bkTables').classList.toggle('is-visible', l.dataset.mode === 'selection');
    }));

    /* ---------- Sélection des tables ---------- */
    const updateCount = () => $('#bkCount').textContent = $$('.bk-tbl:checked').length;
    $$('.bk-tbl').forEach(c => c.addEventListener('change', updateCount));

    $('#bkSearch').addEventListener('input', e => {
        const q = e.target.value.trim().toLowerCase();
        $$('#bkList label').forEach(l => l.style.display = l.dataset.name.includes(q) ? '' : 'none');
    });
    $('#bkAll').addEventListener('click', () => {
        $$('#bkList label').forEach(l => {
            if (l.style.display !== 'none') $('input', l).checked = true;
        });
        updateCount();
    });
    $('#bkNone').addEventListener('click', () => {
        $$('.bk-tbl').forEach(c => c.checked = false);
        updateCount();
    });

    /* ---------- Créer une sauvegarde ---------- */
    $('#bkCreate').addEventListener('click', function() {
        const mode = $('input[name=bk_mode]:checked').value;
        const tables = $$('.bk-tbl:checked').map(c => c.value);

        if (mode === 'selection' && !tables.length) {
            toast('Sélectionnez au moins une table.', false);
            return;
        }

        const btn = this;
        const html = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Sauvegarde en cours…';

        post(urlCreate, {
                mode: mode,
                tables: mode === 'selection' ? tables : [],
                compress: $('#bkCompress').checked ? '1' : '0'
            })
            .then(j => {
                toast(j.message, j.success);
                if (j.success) setTimeout(() => location.reload(), 1200);
            })
            .catch(() => toast('Erreur réseau ou serveur (délai dépassé ?).', false))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = html;
            });
    });

    /* ---------- Supprimer ---------- */
    $$('.bk-del').forEach(b => b.addEventListener('click', function() {
        const file = this.dataset.file;
        if (!confirm('Supprimer définitivement la sauvegarde :\n' + file + ' ?')) return;

        const row = this.closest('tr');
        post(urlDelete, {
                file: file
            })
            .then(j => {
                toast(j.message, j.success);
                if (j.success) row.remove();
            })
            .catch(() => toast('Erreur réseau ou serveur.', false));
    }));
})();
</script>