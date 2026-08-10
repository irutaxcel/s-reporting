<style>
    /* =============== RÔLES & PERMISSIONS =============== */
    .rp-page-header {
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

    .rp-page-header-icon {
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

    .rp-page-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #17302b;
    }

    .rp-page-header p {
        margin: 0;
        font-size: .85rem;
        color: #8a9591;
    }

    .rp-btn-save {
        background: linear-gradient(135deg, #0d3f37, #1f7a5c);
        color: #fff;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .rp-btn-save:hover {
        color: #fff;
        opacity: .92;
    }

    .rp-stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 2px 10px rgba(15, 60, 50, .07);
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .rp-stat-label {
        font-size: .68rem;
        letter-spacing: .6px;
        text-transform: uppercase;
        color: #93a1ad;
        font-weight: 700;
    }

    .rp-stat-value {
        font-size: 1.55rem;
        font-weight: 800;
        color: #17302b;
        line-height: 1.2;
    }

    .rp-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .rp-soft-green {
        background: #e5f5ec;
        color: #1f7a5c;
    }

    .rp-soft-blue {
        background: #e8f1fb;
        color: #2f7fd1;
    }

    .rp-soft-orange {
        background: #fdf3e3;
        color: #d9903f;
    }

    .rp-soft-purple {
        background: #f0ebfa;
        color: #7e5bd2;
    }

    .rp-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(15, 60, 50, .07);
        overflow: hidden;
    }

    .rp-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 18px 20px;
        border-bottom: 1px solid #edf1f0;
    }

    .rp-card-header-icon {
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

    .rp-card-title {
        font-weight: 700;
        color: #17302b;
    }

    .rp-card-subtitle {
        font-size: .8rem;
        color: #8a9591;
    }

    .rp-search {
        position: relative;
        min-width: 260px;
    }

    .rp-search input {
        width: 100%;
        border: 2px solid #e5ece9;
        border-radius: 10px;
        padding: 9px 14px 9px 38px;
        font-size: .88rem;
        transition: .15s;
    }

    .rp-search input:focus {
        outline: none;
        border-color: #1f7a5c;
        box-shadow: 0 0 0 4px rgba(31, 122, 92, .12);
    }

    .rp-search i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9db1ab;
    }

    .rp-table {
        margin: 0;
    }

    .rp-table thead th {
        background: #f7faf9;
        border-bottom: 2px solid #e5ece9;
        padding: 13px 14px;
        font-size: .7rem;
        letter-spacing: .6px;
        text-transform: uppercase;
        color: #7c8a86;
        text-align: left;
    }

    .rp-table td {
        padding: 12px 14px;
        vertical-align: middle;
        border-color: #f0f4f2;
        color: #3c4a47;
        font-size: .9rem;
    }

    .rp-table tbody tr:hover {
        background: #f4faf7;
    }

    .rp-code {
        background: #f2f5f4;
        color: #51605c;
        border-radius: 6px;
        padding: 3px 8px;
        font-size: .75rem;
    }

    .rp-muted {
        color: #b7c2be;
    }

    .rp-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: .76rem;
        font-weight: 700;
        border-radius: 20px;
        padding: 6px 13px;
        white-space: nowrap;
    }

    .rp-badge-admin {
        background: #e3f0fd;
        color: #2f7fd1;
    }

    .rp-badge-tech {
        background: #f0ebfa;
        color: #7e5bd2;
    }

    .rp-badge-finance {
        background: #fdf3e3;
        color: #d9903f;
    }

    .rp-badge-rh {
        background: #e5f5ec;
        color: #1f7a5c;
    }

    .rp-badge-client {
        background: #eef1f4;
        color: #5c6b67;
    }

    .rp-badge-default {
        background: #e5f5ec;
        color: #1f7a5c;
    }

    .rp-action-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .15s;
        cursor: pointer;
    }

    .rp-action-view {
        background: #e0f2f1;
        color: #0d7a6f;
    }

    .rp-action-view:hover {
        background: #c9e8e5;
    }

    .rp-action-edit {
        background: #fdf3e3;
        color: #d9903f;
    }

    .rp-action-edit:hover {
        background: #f8e5c8;
    }

    .rp-action-delete {
        background: #fdecec;
        color: #d33a3a;
    }

    .rp-action-delete:hover {
        background: #f8d3d3;
    }

    /* Modal permissions : groupes + chips */
    .rp-perm-group {
        border: 1px solid #edf1f0;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 14px;
        background: #fbfdfc;
    }

    .rp-perm-group-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #0d3f37;
        margin-bottom: 10px;
        font-size: .9rem;
    }

    .rp-perm-group-title i {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #0d3f37;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    .rp-perm-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .rp-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: 2px solid #e2e8e6;
        border-radius: 20px;
        padding: 6px 12px;
        font-size: .76rem;
        font-weight: 600;
        color: #5c6b67;
        cursor: pointer;
        transition: .15s;
        background: #fff;
    }

    .rp-chip input {
        accent-color: #1f7a5c;
        width: 14px;
        height: 14px;
        cursor: pointer;
        margin: 0;
    }

    .rp-chip:has(input:checked) {
        background: linear-gradient(135deg, #1f7a5c, #66bb6a);
        border-color: transparent;
        color: #fff;
    }

    .rp-modal-label {
        font-size: .78rem;
        font-weight: 700;
        color: #3c4a47;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 6px;
    }

    .rp-modal-note {
        font-size: .78rem;
        color: #8a9591;
    }
</style>

<!-- Content Wrapper -->
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

            <?php
            /* ---- Petits calculs pour les stats ---- */
            $totalPages  = 0;
            foreach ($permissions as $module) {
                $totalPages += count($module['permissions']);
            }
            $systemRoles = 0;
            foreach ($roles as $r) {
                if (strpos(strtoupper($r->code), 'ADMIN') !== false) $systemRoles++;
            }

            /* ---- Couleur du badge selon le code du rôle ---- */
            function rp_badge_class($code)
            {
                $c = strtoupper($code);
                if (strpos($c, 'ADMIN') !== false) return 'rp-badge-admin';
                if (preg_match('/COMPTABLE|TRESOR|FINANCIER|GESTION|AUDIT/', $c)) return 'rp-badge-finance';
                if (preg_match('/TECHNIQUE|TRAVAUX|CHANTIER|INGENIEUR|ARCHITECTE|DESSINATEUR|PROJETEUR|MATERIEL|STOCK|MAGASIN|SOUMISSION/', $c)) return 'rp-badge-tech';
                if (strpos($c, 'RH') !== false) return 'rp-badge-rh';
                if (preg_match('/PORTAL|SOUS_TRAITANT|CLIENT|FOURNISSEUR/', $c)) return 'rp-badge-client';
                return 'rp-badge-default';
            }
            ?>

            <!-- ============ EN-TÊTE ============ -->
            <div class="rp-page-header">
                <div class="rp-page-header-icon"><i class="fas fa-user-tag"></i></div>
                <div>
                    <h2>Rôles & Permissions</h2>
                    <p>Créez les rôles, attribuez leurs permissions par défaut et contrôlez les accès.</p>
                </div>
                <div class="ml-auto">
                    <button type="button" class="btn rp-btn-save" onclick="openRoleModal()">
                        <i class="fas fa-plus mr-1"></i> Nouveau rôle
                    </button>
                </div>
            </div>

            <!-- ============ STATISTIQUES ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="rp-stat-card">
                        <div>
                            <div class="rp-stat-label">Rôles enregistrés</div>
                            <div class="rp-stat-value"><?= count($roles) ?></div>
                        </div>
                        <div class="rp-stat-icon rp-soft-green"><i class="fas fa-user-tag"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="rp-stat-card">
                        <div>
                            <div class="rp-stat-label">Modules couverts</div>
                            <div class="rp-stat-value"><?= count($permissions) ?></div>
                        </div>
                        <div class="rp-stat-icon rp-soft-blue"><i class="fas fa-cubes"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="rp-stat-card">
                        <div>
                            <div class="rp-stat-label">Pages & accès</div>
                            <div class="rp-stat-value"><?= $totalPages ?></div>
                        </div>
                        <div class="rp-stat-icon rp-soft-orange"><i class="fas fa-th-large"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="rp-stat-card">
                        <div>
                            <div class="rp-stat-label">Rôles système</div>
                            <div class="rp-stat-value"><?= $systemRoles ?></div>
                        </div>
                        <div class="rp-stat-icon rp-soft-purple"><i class="fas fa-user-shield"></i></div>
                    </div>
                </div>
            </div>

            <!-- ============ LISTE DES RÔLES ============ -->
            <div class="rp-card">

                <div class="rp-card-header">
                    <div class="rp-card-header-icon"><i class="fas fa-users-cog"></i></div>
                    <div>
                        <div class="rp-card-title">Liste des rôles</div>
                        <div class="rp-card-subtitle">Consultez et gérez tous les rôles du système SATRACO CMS.</div>
                    </div>
                    <div class="ml-auto rp-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="roleSearch" placeholder="Rechercher un rôle par nom ou code…">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table rp-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th>Rôle</th>
                                <th>Code technique</th>
                                <th class="text-center">Utilisateurs</th>
                                <th class="text-center">Pages accessibles</th>
                                <th class="text-center" style="width:150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($roles as $i => $role): ?>
                                <tr>
                                    <td class="rp-muted"><?= $i + 1 ?></td>
                                    <td>
                                        <span class="rp-badge <?= rp_badge_class($role->code) ?>">
                                            <i class="fas fa-user-tag"></i>
                                            <?= html_escape($role->name) ?>
                                        </span>
                                    </td>
                                    <td><code class="rp-code"><?= html_escape($role->code) ?></code></td>
                                    <!-- ⏳ À dynamiser : COUNT(users) par rôle -->
                                    <td class="text-center"><?= $roleStats[$role->id]['users'] ?? 0 ?></td>
                                    <!-- ⏳ À dynamiser : COUNT(role_permissions) par rôle -->
                                    <td class="text-center"><?= $roleStats[$role->id]['perms'] ?? 0 ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center" style="gap:8px;">
                                            <button type="button" class="rp-action-btn rp-action-view"
                                                title="Voir les permissions" onclick="openRolePermissions(this)"
                                                data-id="<?= (int) $role->id ?>"
                                                data-name="<?= html_escape($role->name) ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="rp-action-btn rp-action-edit" title="Modifier"
                                                onclick="openRoleModal(this)" data-id="<?= (int) $role->id ?>"
                                                data-name="<?= html_escape($role->name) ?>"
                                                data-code="<?= html_escape($role->code) ?>">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="button" class="rp-action-btn rp-action-delete" title="Supprimer"
                                                data-id="<?= (int) $role->id ?>"
                                                data-name="<?= html_escape($role->name) ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- ============ MODAL : NOUVEAU / MODIFIER RÔLE ============ -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="roleForm" class="modal-content" style="border-radius:14px;overflow:hidden;">
            <div class="modal-header" style="border-bottom:1px solid #edf1f0;">
                <h5 class="modal-title" style="font-weight:700;color:#17302b;">
                    <span
                        style="width:36px;height:36px;border-radius:10px;background:#e5f5ec;color:#1f7a5c;display:inline-flex;align-items:center;justify-content:center;margin-right:8px;">
                        <i class="fas fa-user-tag"></i>
                    </span>
                    <span id="roleModalTitle">Nouveau rôle</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="rp-modal-label">Nom du rôle <span style="color:#d33a3a;">*</span></div>
                    <input type="text" id="roleName" name="name" class="form-control"
                        placeholder="Ex. : Responsable qualité" required>
                </div>
                <div class="form-group mb-0">
                    <div class="rp-modal-label">Code technique <span style="color:#d33a3a;">*</span></div>
                    <input type="text" id="roleCode" name="code" class="form-control"
                        placeholder="Ex. : RESPONSABLE_QUALITE" required>
                    <small class="rp-modal-note">Généré automatiquement depuis le nom (modifiable). Utilisé par le
                        système de permissions.</small>
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #edf1f0;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn rp-btn-save" id="roleModalSaveBtn">
                    <i class="fas fa-save mr-1"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============ MODAL : PERMISSIONS DU RÔLE ============ -->
<div class="modal fade" id="rolePermissionsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius:14px;overflow:hidden;">
            <div class="modal-header" style="border-bottom:1px solid #edf1f0;">
                <h5 class="modal-title" style="font-weight:700;color:#17302b;">
                    <span
                        style="width:36px;height:36px;border-radius:10px;background:#e5f5ec;color:#1f7a5c;display:inline-flex;align-items:center;justify-content:center;margin-right:8px;">
                        <i class="fas fa-user-shield"></i>
                    </span>
                    Permissions par défaut — <span id="rolePermName" style="color:#1f7a5c;"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">

                <?php foreach ($permissions as $module): ?>
                    <div class="rp-perm-group">
                        <div class="rp-perm-group-title">
                            <i class="fas <?= $module['icon'] ?>"></i>
                            <?= html_escape($module['label']) ?>
                        </div>
                        <div class="rp-perm-chips">
                            <?php foreach ($module['permissions'] as $p): ?>
                                <label class="rp-chip">
                                    <input type="checkbox" data-group="<?= $module['code'] ?>" data-perm="<?= $p['code'] ?>">
                                    <span><?= html_escape($p['label']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <small class="rp-modal-note">
                    ⏳ À l'étape de dynamisation, ces cases seront pré-cochées depuis la table
                    <code>role_permissions</code> et enregistrées comme permissions par défaut du rôle.
                </small>
            </div>
            <div class="modal-footer" style="border-top:1px solid #edf1f0;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn rp-btn-save" id="rolePermSaveBtn">
                    <i class="fas fa-save mr-1"></i> Enregistrer les permissions
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var editingRoleId = 0;
    var currentRoleId = 0;

    function rpCsrfPayload(extra) {
        var $csrf = $('#globalCsrf');
        var p = extra || {};
        if ($csrf.length) p[$csrf.attr('name')] = $csrf.val();
        return p;
    }

    function rpNotify(icon, title, text, sticky) {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            timer: sticky ? undefined : 1600,
            showConfirmButton: sticky ? true : false,
            confirmButtonColor: '#dc3545'
        });
    }

    function rpInit() {
        if (typeof jQuery === 'undefined') {
            console.error('[roles] jQuery introuvable.');
            return;
        }

        /* Recherche en direct */
        $('#roleSearch').on('keyup', function() {
            var q = $(this).val().toLowerCase();
            $('.rp-table tbody tr').each(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
            });
        });

        /* Code auto-généré depuis le nom */
        $('#roleName').on('input', function() {
            $('#roleCode').val($(this).val().trim().toUpperCase()
                .replace(/[^A-Z0-9]+/g, '_').replace(/^_+|_+$/g, ''));
        });

        /* ---- Créer / modifier un rôle ---- */
        $('#roleForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Enregistrement…',
                allowOutsideClick: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '<?= base_url('roles/save') ?>',
                type: 'POST',
                dataType: 'json',
                data: rpCsrfPayload({
                    id: editingRoleId,
                    name: $('#roleName').val(),
                    code: $('#roleCode').val()
                }),
                success: function(res) {
                    if (res.success) {
                        rpNotify('success', 'Succès', res.message);
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur serveur',
                        text: 'HTTP ' + xhr.status,
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });

        /* ---- Supprimer un rôle ---- */
        $(document).on('click', '.rp-action-delete', function() {
            var id = $(this).data('id'),
                name = $(this).data('name');
            Swal.fire({
                title: 'Supprimer ce rôle ?',
                html: '<strong>' + name + '</strong> sera définitivement supprimé.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then(function(r) {
                if (!r.isConfirmed) return;
                $.ajax({
                    url: '<?= base_url('roles/delete') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: rpCsrfPayload({
                        id: id
                    }),
                    success: function(res) {
                        if (res.success) {
                            rpNotify('success', 'Succès', res.message);
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur serveur',
                            text: 'HTTP ' + xhr.status,
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            });
        });

        /* ---- Enregistrer les permissions du rôle ---- */
        $('#rolePermSaveBtn').on('click', function() {
            if (!currentRoleId) return;

            var items = [];
            $('#rolePermissionsModal .rp-chip input:checked').each(function() {
                items.push($(this).data('group') + '|' + $(this).data('perm'));
            });

            Swal.fire({
                title: 'Enregistrement…',
                allowOutsideClick: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '<?= base_url('roles/permissions/save') ?>',
                type: 'POST',
                dataType: 'json',
                data: rpCsrfPayload({
                    role_id: currentRoleId,
                    items: items
                }),
                success: function(res) {
                    if (res.success) {
                        $('#rolePermissionsModal').modal('hide');
                        rpNotify('success', 'Succès', res.message);
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur serveur',
                        text: 'HTTP ' + xhr.status,
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });
    }

    /* ---- Modals ---- */
    function openRoleModal(btn) {
        if (btn) {
            editingRoleId = $(btn).data('id') || 0;
            $('#roleModalTitle').text('Modifier le rôle');
            $('#roleName').val($(btn).data('name'));
            $('#roleCode').val($(btn).data('code'));
            $('#roleModalSaveBtn').html('<i class="fas fa-save mr-1"></i> Enregistrer les modifications');
        } else {
            editingRoleId = 0;
            $('#roleModalTitle').text('Nouveau rôle');
            $('#roleName').val('');
            $('#roleCode').val('');
            $('#roleModalSaveBtn').html('<i class="fas fa-save mr-1"></i> Enregistrer');
        }
        $('#roleModal').modal('show');
    }

    function openRolePermissions(btn) {
        currentRoleId = $(btn).data('id') || 0;
        $('#rolePermName').text($(btn).data('name'));
        $('#rolePermissionsModal .rp-chip input').prop('checked', false);
        $('#rolePermissionsModal').modal('show');

        /* ✔ Pré-cochage depuis la BDD */
        $.ajax({
            url: '<?= base_url('roles/permissions/load') ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                role_id: currentRoleId
            },
            success: function(res) {
                if (!res.success) return;
                (res.grants || []).forEach(function(key) {
                    var parts = key.split('|');
                    $('#rolePermissionsModal .rp-chip input[data-group="' + parts[0] +
                            '"][data-perm="' + parts[1] + '"]')
                        .prop('checked', true);
                });
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', rpInit);
    } else {
        rpInit();
    }
</script>