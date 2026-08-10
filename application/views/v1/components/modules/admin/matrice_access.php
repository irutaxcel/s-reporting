<style>
/* =============== MATRICE DES ACCÈS =============== */
.matrix-page-header {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    background: #fff;
    border-radius: 14px;
    padding: 18px 20px;
    box-shadow: 0 2px 10px rgba(15, 60, 50, .07);
    margin-bottom: 20px;
}

.matrix-page-header-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    color: #fff;
    font-size: 20px;
    background: linear-gradient(135deg, #0d3f37, #1f7a5c);
    display: flex;
    align-items: center;
    justify-content: center;
}

.matrix-page-header h2 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #17302b;
}

.matrix-page-header p {
    margin: 0;
    font-size: .85rem;
    color: #8a9591;
}

.matrix-btn-save {
    background: linear-gradient(135deg, #0d3f37, #1f7a5c);
    color: #fff;
    border-radius: 10px;
    padding: 10px 18px;
    font-weight: 600;
}

.matrix-btn-save:hover {
    color: #fff;
    opacity: .92;
}

.matrix-btn-reset {
    background: #eef2f1;
    color: #3c4a47;
    border-radius: 10px;
    padding: 10px 18px;
    font-weight: 600;
}

.matrix-btn-reset:hover {
    background: #e2e8e6;
    color: #22302c;
}

.matrix-stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 2px 10px rgba(15, 60, 50, .07);
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.matrix-stat-label {
    font-size: .68rem;
    letter-spacing: .6px;
    text-transform: uppercase;
    color: #93a1ad;
    font-weight: 700;
}

.matrix-stat-value {
    font-size: 1.55rem;
    font-weight: 800;
    color: #17302b;
    line-height: 1.2;
}

.matrix-stat-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    font-size: 17px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-soft-green {
    background: #e5f5ec;
    color: #1f7a5c;
}

.bg-soft-blue {
    background: #e8f1fb;
    color: #2f7fd1;
}

.bg-soft-orange {
    background: #fdf3e3;
    color: #d9903f;
}

.bg-soft-purple {
    background: #f0ebfa;
    color: #7e5bd2;
}

.matrix-user-selector {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(15, 60, 50, .07);
    margin-bottom: 20px;
}

.matrix-user-selector label {
    font-weight: 600;
    color: #17302b;
    margin-bottom: 8px;
    display: block;
}

.matrix-user-selector select {
    width: 100%;
    padding: 10px 14px;
    border: 2px solid #e5ece9;
    border-radius: 10px;
    font-size: .9rem;
}

.matrix-user-info {
    margin-top: 12px;
    padding: 12px;
    background: #f7faf9;
    border-radius: 8px;
    display: none;
}

.matrix-user-info.active {
    display: block;
}

.matrix-user-info-name {
    font-weight: 700;
    color: #0d3f37;
    font-size: 1rem;
}

.matrix-user-info-role {
    font-size: .8rem;
    color: #5c6b67;
}

.matrix-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 10px rgba(15, 60, 50, .07);
    overflow: hidden;
}

.matrix-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    padding: 18px 20px;
    border-bottom: 1px solid #edf1f0;
}

.matrix-card-header-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #e5f5ec;
    color: #1f7a5c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.matrix-card-title {
    font-weight: 700;
    color: #17302b;
}

.matrix-card-subtitle {
    font-size: .8rem;
    color: #8a9591;
}

.matrix-legend {
    font-size: .75rem;
    color: #5c6b67;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-left: 14px;
}

.matrix-legend .dot {
    width: 10px;
    height: 10px;
    border-radius: 4px;
    display: inline-block;
}

.matrix-legend .dot.granted {
    background: linear-gradient(135deg, #1f7a5c, #66bb6a);
}

.matrix-legend .dot.denied {
    background: #e3e8e6;
}

.matrix-table-wrap {
    overflow-x: auto;
}

.matrix-table {
    margin: 0;
    min-width: 600px;
    border-collapse: collapse;
}

.matrix-table thead th {
    background: #f7faf9;
    border-bottom: 2px solid #e5ece9;
    padding: 14px 12px;
    text-align: center;
    vertical-align: middle;
}

.matrix-table thead th:first-child {
    text-align: left;
    width: 270px;
    min-width: 230px;
    position: sticky;
    left: 0;
    z-index: 2;
}

.matrix-table thead th:last-child {
    width: 120px;
}

.matrix-table td {
    padding: 10px 12px;
    text-align: center;
    vertical-align: middle;
    border-color: #f0f4f2;
}

.matrix-table td:first-child {
    text-align: left;
    min-width: 230px;
    position: sticky;
    left: 0;
    background: #fff;
    z-index: 1;
}

.matrix-perm {
    color: #3c4a47;
    font-size: .88rem;
}

.matrix-perm i {
    display: inline-block;
    width: 22px;
    text-align: center;
    color: #9db1ab;
    margin-right: 6px;
}

.matrix-row:hover>td {
    background: #f4faf7;
}

.matrix-group-row td {
    background: #f2f8f5 !important;
    border-top: 2px solid #e5ece9;
    padding: 12px 16px;
    position: static;
}

.matrix-group-head {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    color: #0d3f37;
    position: sticky;
    left: 0;
    width: max-content;
}

.matrix-group-icon {
    width: 30px;
    height: 30px;
    border-radius: 9px;
    background: #0d3f37;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.matrix-check-all-wrap {
    margin-left: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: .72rem;
    font-weight: 600;
    color: #5c6b67;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: .4px;
}

.matrix-check-all-wrap input {
    display: none;
}

.matrix-mini-toggle {
    width: 34px;
    height: 20px;
    background: #cfd8d5;
    border-radius: 20px;
    position: relative;
    transition: .2s;
}

.matrix-mini-toggle::after {
    content: '';
    position: absolute;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #fff;
    top: 3px;
    left: 3px;
    transition: .2s;
}

.matrix-check-all-wrap input:checked+.matrix-mini-toggle {
    background: #1f7a5c;
}

.matrix-check-all-wrap input:checked+.matrix-mini-toggle::after {
    left: 17px;
}

.matrix-check {
    display: inline-flex;
    cursor: pointer;
}

.matrix-check input {
    position: absolute;
    opacity: 0;
}

.matrix-check-box {
    width: 22px;
    height: 22px;
    border-radius: 7px;
    border: 2px solid #d8e0dd;
    background: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .15s;
}

.matrix-check-box::after {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    content: "\f00c";
    font-size: 11px;
    color: #fff;
    opacity: 0;
    transform: scale(.5);
    transition: .15s;
}

.matrix-check input:checked+.matrix-check-box {
    background: linear-gradient(135deg, #1f7a5c, #66bb6a);
    border-color: transparent;
}

.matrix-check input:checked+.matrix-check-box::after {
    opacity: 1;
    transform: scale(1);
}

.matrix-check input:disabled+.matrix-check-box {
    opacity: .4;
    cursor: not-allowed;
    background: #f0f2f1;
}

.matrix-card-footer {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    padding: 16px 20px;
    border-top: 1px solid #edf1f0;
}

.matrix-footer-note {
    font-size: .8rem;
    color: #8a9591;
}

.matrix-empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #8a9591;
}

.matrix-empty-state i {
    font-size: 3rem;
    margin-bottom: 16px;
    color: #cfd8d5;
}

/* ============ SÉLECTEUR D'UTILISATEUR ============ */
.matrix-user-selector {
    background: #fff;
    border-radius: 14px;
    padding: 18px 20px;
    box-shadow: 0 2px 10px rgba(15, 60, 50, .07);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.matrix-user-selector-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0d3f37, #1f7a5c);
    color: #fff;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.matrix-user-selector-title {
    font-weight: 700;
    color: #17302b;
    font-size: 1rem;
}

.matrix-user-selector-sub {
    font-size: .8rem;
    color: #8a9591;
}

/* Select customisé */
.matrix-select-wrap {
    position: relative;
    flex: 1;
    min-width: 260px;
}

.matrix-select-wrap select {
    width: 100%;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding: 12px 44px 12px 16px;
    border: 2px solid #e5ece9;
    border-radius: 12px;
    background: #f7faf9;
    font-size: .92rem;
    font-weight: 600;
    color: #17302b;
    cursor: pointer;
    transition: border-color .15s, background .15s, box-shadow .15s;
}

.matrix-select-wrap select:hover {
    border-color: #cfe0da;
    background: #fff;
}

.matrix-select-wrap select:focus {
    outline: none;
    border-color: #1f7a5c;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(31, 122, 92, .12);
}

/* Chevron vert (Font Awesome) à la place de la flèche native */
.matrix-select-wrap::after {
    content: "\f078";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    font-size: .75rem;
    color: #1f7a5c;
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}

/* Carte identité de l'utilisateur sélectionné */
.matrix-user-info {
    display: none;
    align-items: center;
    gap: 12px;
    background: #f2f8f5;
    border: 1px solid #dcefe5;
    border-radius: 12px;
    padding: 10px 16px;
}

.matrix-user-info.active {
    display: flex;
}

.matrix-user-info-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1f7a5c, #66bb6a);
    color: #fff;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.matrix-user-info-name {
    font-weight: 700;
    color: #0d3f37;
}

.matrix-user-info-role {
    font-size: .78rem;
    color: #5c6b67;
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

            <input type="hidden" id="globalCsrf" name="<?= $this->security->get_csrf_token_name() ?>"
                value="<?= $this->security->get_csrf_hash() ?>">

            <input type="hidden" id="selectedUserId" value="<?= $selectedUserId ?>">

            <div class="matrix-page-header">
                <div class="matrix-page-header-icon"><i class="fas fa-th-large"></i></div>
                <div>
                    <h2>Matrice des accès</h2>
                    <p>Configurez les permissions individuelles de chaque utilisateur.</p>
                </div>
                <div class="ml-auto d-flex" style="gap:10px;">
                    <button type="button" class="btn matrix-btn-reset" id="matrixResetBtn">
                        <i class="fas fa-undo mr-1"></i> Réinitialiser
                    </button>
                    <button type="button" class="btn matrix-btn-save" id="matrixSaveBtn">
                        <i class="fas fa-save mr-1"></i> Enregistrer les modifications
                    </button>
                </div>
            </div>

            <!-- ============ SÉLECTEUR D'UTILISATEUR ============ -->
            <div class="matrix-user-selector">

                <div class="matrix-user-selector-icon"><i class="fas fa-user-check"></i></div>

                <div>
                    <div class="matrix-user-selector-title">Sélectionner un utilisateur</div>
                    <div class="matrix-user-selector-sub">Choisissez un compte pour gérer ses permissions individuelles.
                    </div>
                </div>

                <div class="matrix-select-wrap">
                    <select id="userSelect">
                        <option value="">-- Choisir un utilisateur --</option>
                        <?php foreach ($users as $u): ?>
                        <option value="<?= (int) $u->id ?>" <?= $selectedUserId == $u->id ? 'selected' : '' ?>>
                            <?= html_escape($u->first_name . ' ' . $u->last_name) ?> — <?= html_escape($u->email) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="matrix-user-info" id="userInfoBox">
                    <div class="matrix-user-info-avatar" id="userAvatar">U</div>
                    <div>
                        <div class="matrix-user-info-name" id="userName"></div>
                        <div class="matrix-user-info-role">Rôle : <span id="userRole"></span></div>
                    </div>
                </div>

            </div>

            <div class="row" id="statsRow" style="display:none;">
                <div class="col-lg-4 col-6">
                    <div class="matrix-stat-card">
                        <div>
                            <div class="matrix-stat-label">Modules couverts</div>
                            <div class="matrix-stat-value"><?= count($catalog) ?></div>
                        </div>
                        <div class="matrix-stat-icon bg-soft-blue"><i class="fas fa-cubes"></i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="matrix-stat-card">
                        <div>
                            <div class="matrix-stat-label">Permissions actives</div>
                            <div class="matrix-stat-value" id="matrixActiveCount">0</div>
                        </div>
                        <div class="matrix-stat-icon bg-soft-orange"><i class="fas fa-toggle-on"></i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="matrix-stat-card">
                        <div>
                            <div class="matrix-stat-label">Dernière modification</div>
                            <div class="matrix-stat-value" style="font-size:1.15rem;" id="lastUpdate">—</div>
                        </div>
                        <div class="matrix-stat-icon bg-soft-purple"><i class="fas fa-history"></i></div>
                    </div>
                </div>
            </div>

            <div id="matrixContainer" style="display:none;">
                <div class="matrix-card">
                    <div class="matrix-card-header">
                        <div class="matrix-card-header-icon"><i class="fas fa-user-shield"></i></div>
                        <div>
                            <div class="matrix-card-title">Permissions de l'utilisateur</div>
                            <div class="matrix-card-subtitle">Cochez / décochez pour ajuster les accès.</div>
                        </div>
                        <div class="ml-auto">
                            <span class="matrix-legend"><span class="dot granted"></span> Accordé</span>
                            <span class="matrix-legend"><span class="dot denied"></span> Refusé</span>
                        </div>
                    </div>

                    <div class="matrix-table-wrap">
                        <table class="table matrix-table">
                            <thead>
                                <tr>
                                    <th>Module / Permission</th>
                                    <th>Accès</th>
                                </tr>
                            </thead>
                            <tbody id="matrixBody"></tbody>
                        </table>
                    </div>

                    <div class="matrix-card-footer">
                        <i class="fas fa-info-circle text-muted"></i>
                        <span class="matrix-footer-note">
                            Les modifications ne prennent effet qu'après clic sur « Enregistrer les modifications ».
                        </span>
                    </div>
                </div>
            </div>

            <div id="emptyState" class="matrix-card">
                <div class="matrix-empty-state">
                    <i class="fas fa-user-slash"></i>
                    <h4>Aucun utilisateur sélectionné</h4>
                    <p>Choisissez un utilisateur dans la liste ci-dessus pour gérer ses permissions.</p>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function initMatrix() {
    if (typeof jQuery === 'undefined') {
        console.error('[matrice] jQuery introuvable.');
        return;
    }

    var catalog = <?= json_encode($catalog) ?>;
    var currentUserId = 0;
    var currentUserName = '';

    function renderMatrix(grants) {
        var html = '';
        catalog.forEach(function(module) {
            html += '<tr class="matrix-group-row"><td colspan="2"><div class="matrix-group-head">';
            html += '<span class="matrix-group-icon"><i class="fas ' + module.icon + '"></i></span>';
            html += module.label;
            html +=
                '<label class="matrix-check-all-wrap">Tout sélectionner <input type="checkbox" class="matrix-check-all" data-group="' +
                module.code + '"><span class="matrix-mini-toggle"></span></label>';
            html += '</div></td></tr>';

            module.permissions.forEach(function(perm) {
                var checked = grants.indexOf(module.code + '.' + perm.code) !== -1;
                html += '<tr class="matrix-row">';
                html += '<td class="matrix-perm"><i class="fas ' + perm.icon + '"></i>' + perm.label +
                    '</td>';
                html +=
                    '<td><label class="matrix-check"><input type="checkbox" class="matrix-input" data-group="' +
                    module.code + '" data-perm="' + perm.code + '" ' + (checked ? 'checked' : '') +
                    '><span class="matrix-check-box"></span></label></td>';
                html += '</tr>';
            });
        });
        $('#matrixBody').html(html);
        syncAll();
    }

    function loadUser(userId) {

        userId = parseInt(userId, 10) || 0; // "0", "", null → 0

        if (userId <= 0) {
            $('#matrixContainer, #statsRow').hide();
            $('#emptyState').show();
            $('#userInfoBox').removeClass('active');
            currentUserId = 0;
            return;
        }

        if (!userId) {
            $('#matrixContainer, #statsRow').hide();
            $('#emptyState').show();
            $('#userInfoBox').removeClass('active');
            return;
        }

        Swal.fire({
            title: 'Chargement…',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: function() {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '<?= base_url('matrice-access/load') ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                user_id: userId
            },
            success: function(res) {
                Swal.close();
                if (res.success) {
                    currentUserId = userId;
                    currentUserName = res.userName;
                    $('#userName').text(res.userName);
                    $('#userRole').text(res.userRole);
                    $('#userInfoBox').addClass('active');
                    $('#emptyState').hide();
                    $('#matrixContainer, #statsRow').show();
                    renderMatrix(res.grants);
                } else {
                    Swal.fire('Erreur', 'Utilisateur introuvable.', 'error');
                }
            },
            error: function(xhr) {
                Swal.close();
                Swal.fire('Erreur', 'Impossible de charger les données.', 'error');
            }
        });
    }

    function syncAll() {
        $('#matrixActiveCount').text($('.matrix-input:checked').length);
        $('.matrix-check-all').each(function() {
            var g = $(this).data('group');
            var all = $('.matrix-input[data-group="' + g + '"]:not(:disabled)').length;
            var on = $('.matrix-input[data-group="' + g + '"]:not(:disabled):checked').length;
            $(this).prop('checked', all > 0 && all === on);
        });
    }

    function doSave(items) {
        Swal.fire({
            title: 'Enregistrement…',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: function() {
                Swal.showLoading();
            }
        });

        var $csrf = $('#globalCsrf');
        var payload = {
            user_id: currentUserId,
            items: items
        };
        if ($csrf.length) payload[$csrf.attr('name')] = $csrf.val();

        $.ajax({
            url: '<?= base_url('matrice-access/save') ?>',
            type: 'POST',
            dataType: 'json',
            data: payload,
            success: function(res) {
                if ($csrf.length && res.csrf_hash) $csrf.val(res.csrf_hash);
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: res.message,
                        timer: 1400,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1200);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: res.message,
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function(xhr) {
                var detail;
                try {
                    detail = JSON.parse(xhr.responseText).message || xhr.responseText;
                } catch (e) {
                    detail = 'HTTP ' + xhr.status;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur serveur',
                    text: detail,
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    }

    // Événements
    $('#userSelect').on('change', function() {
        loadUser($(this).val());
    });

    $(document).on('change', '.matrix-check-all', function() {
        var g = $(this).data('group');
        $('.matrix-input[data-group="' + g + '"]:not(:disabled)').prop('checked', this.checked);
        syncAll();
    });

    $(document).on('change', '.matrix-input', syncAll);

    $('#matrixResetBtn').on('click', function() {
        if (currentUserId) loadUser(currentUserId);
    });

    $('#matrixSaveBtn').on('click', function() {
        if (!currentUserId) {
            Swal.fire('Attention', 'Veuillez d\'abord sélectionner un utilisateur.', 'warning');
            return;
        }

        var items = [];
        $('.matrix-input:checked').each(function() {
            items.push($(this).data('group') + '|' + $(this).data('perm'));
        });

        Swal.fire({
            title: 'Enregistrer les permissions ?',
            text: items.length + ' permission(s) seront accordées à ' + currentUserName + '.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1f7a5c',
            confirmButtonText: 'Oui, enregistrer',
            cancelButtonText: 'Annuler'
        }).then(function(r) {
            if (r.isConfirmed) doSave(items);
        });
    });

    // Chargement initial si un utilisateur est déjà sélectionné
    var initialUserId = $('#selectedUserId').val();
    if (initialUserId) loadUser(initialUserId);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMatrix);
} else {
    initMatrix();
}
</script>