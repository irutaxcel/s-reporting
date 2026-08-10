<style>
/* =============== PARAMÈTRES =============== */
.st-page-header {
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

.st-page-header-icon {
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

.st-page-header h2 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #17302b;
}

.st-page-header p {
    margin: 0;
    font-size: .85rem;
    color: #8a9591;
}

.st-btn-save {
    background: linear-gradient(135deg, #0d3f37, #1f7a5c);
    color: #fff;
    border-radius: 10px;
    padding: 10px 18px;
    font-weight: 600;
}

.st-btn-save:hover {
    color: #fff;
    opacity: .92;
}

.st-btn-reset {
    background: #eef2f1;
    color: #3c4a47;
    border-radius: 10px;
    padding: 10px 18px;
    font-weight: 600;
}

.st-btn-reset:hover {
    background: #e2e8e6;
    color: #22302c;
}

.st-stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 2px 10px rgba(15, 60, 50, .07);
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.st-stat-label {
    font-size: .68rem;
    letter-spacing: .6px;
    text-transform: uppercase;
    color: #93a1ad;
    font-weight: 700;
}

.st-stat-value {
    font-size: 1.55rem;
    font-weight: 800;
    color: #17302b;
    line-height: 1.2;
}

.st-stat-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    font-size: 17px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.st-soft-green {
    background: #e5f5ec;
    color: #1f7a5c;
}

.st-soft-blue {
    background: #e8f1fb;
    color: #2f7fd1;
}

.st-soft-orange {
    background: #fdf3e3;
    color: #d9903f;
}

.st-soft-purple {
    background: #f0ebfa;
    color: #7e5bd2;
}

.st-soft-red {
    background: #fdecec;
    color: #d33a3a;
}

.st-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 10px rgba(15, 60, 50, .07);
    overflow: hidden;
    margin-bottom: 20px;
}

.st-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid #edf1f0;
}

.st-card-header-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #e5f5ec;
    color: #1f7a5c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.st-card-title {
    font-weight: 700;
    color: #17302b;
}

.st-card-subtitle {
    font-size: .78rem;
    color: #8a9591;
}

.st-card-body {
    padding: 8px 20px 18px;
}

.st-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 14px 0;
    border-bottom: 1px solid #f0f4f2;
    flex-wrap: wrap;
}

.st-row:last-child {
    border-bottom: 0;
    padding-bottom: 4px;
}

.st-row-label {
    font-weight: 600;
    color: #17302b;
    font-size: .9rem;
}

.st-row-desc {
    font-size: .76rem;
    color: #8a9591;
    margin-top: 2px;
}

.st-input,
.st-select {
    border: 2px solid #e5ece9;
    border-radius: 10px;
    padding: 9px 12px;
    font-size: .88rem;
    background: #f7faf9;
    color: #17302b;
    transition: .15s;
    min-width: 230px;
}

.st-input:focus,
.st-select:focus {
    outline: none;
    border-color: #1f7a5c;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(31, 122, 92, .12);
}

/* Switch custom */
.st-switch {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 26px;
    flex-shrink: 0;
}

.st-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.st-switch .st-slider {
    position: absolute;
    inset: 0;
    background: #cfd8d5;
    border-radius: 26px;
    transition: .2s;
    cursor: pointer;
}

.st-switch .st-slider::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #fff;
    top: 3px;
    left: 3px;
    transition: .2s;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .25);
}

.st-switch input:checked+.st-slider {
    background: linear-gradient(135deg, #1f7a5c, #66bb6a);
}

.st-switch input:checked+.st-slider::after {
    left: 23px;
}

.st-switch.st-switch-danger input:checked+.st-slider {
    background: linear-gradient(135deg, #c0392b, #e74c3c);
}

/* Zone dangereuse */
.st-card-danger {
    border: 1px solid #f5c6c6;
}

.st-card-danger .st-card-header {
    border-bottom-color: #f5dede;
    background: #fff7f7;
}

.st-card-danger .st-card-header-icon {
    background: #fdecec;
    color: #d33a3a;
}

.st-btn-outline {
    border: 2px solid #e5ece9;
    background: #fff;
    color: #3c4a47;
    border-radius: 10px;
    padding: 8px 14px;
    font-weight: 600;
    font-size: .8rem;
}

.st-btn-outline:hover {
    border-color: #1f7a5c;
    color: #1f7a5c;
}

.st-btn-danger {
    border: 2px solid #f5c6c6;
    background: #fff;
    color: #d33a3a;
    border-radius: 10px;
    padding: 8px 14px;
    font-weight: 600;
    font-size: .8rem;
}

.st-btn-danger:hover {
    background: #fdecec;
    color: #c0392b;
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

            <!-- ============ EN-TÊTE ============ -->
            <div class="st-page-header">
                <div class="st-page-header-icon"><i class="fas fa-sliders-h"></i></div>
                <div>
                    <h2>Paramètres du système</h2>
                    <p>Configurez le comportement global de SATRACO Construction ERP.</p>
                </div>
                <div class="ml-auto d-flex" style="gap:10px;">
                    <button type="button" class="btn st-btn-reset" id="stResetBtn">
                        <i class="fas fa-undo mr-1"></i> Réinitialiser
                    </button>
                    <button type="button" class="btn st-btn-save" id="stSaveBtn">
                        <i class="fas fa-save mr-1"></i> Enregistrer les paramètres
                    </button>
                </div>
            </div>

            <!-- ============ STATISTIQUES ============ -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="st-stat-card">
                        <div>
                            <div class="st-stat-label">Sections configurables</div>
                            <div class="st-stat-value">6</div>
                        </div>
                        <div class="st-stat-icon st-soft-blue"><i class="fas fa-layer-group"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="st-stat-card">
                        <div>
                            <div class="st-stat-label">Options activées</div>
                            <div class="st-stat-value" id="stActiveCount">0</div>
                        </div>
                        <div class="st-stat-icon st-soft-green"><i class="fas fa-toggle-on"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="st-stat-card">
                        <div>
                            <div class="st-stat-label">Dernière sauvegarde</div>
                            <div class="st-stat-value" style="font-size:1.05rem;">05/08/2026 02:00</div>
                        </div>
                        <div class="st-stat-icon st-soft-orange"><i class="fas fa-database"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="st-stat-card">
                        <div>
                            <div class="st-stat-label">Version du système</div>
                            <div class="st-stat-value" style="font-size:1.05rem;">1.0.0</div>
                        </div>
                        <div class="st-stat-icon st-soft-purple"><i class="fas fa-code-branch"></i></div>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- ============ ENTREPRISE ============ -->
                <div class="col-lg-6">
                    <div class="st-card">
                        <div class="st-card-header">
                            <div class="st-card-header-icon"><i class="fas fa-building"></i></div>
                            <div>
                                <div class="st-card-title">Informations de l'entreprise</div>
                                <div class="st-card-subtitle">Identité utilisée sur les documents officiels.</div>
                            </div>
                        </div>
                        <div class="st-card-body">
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Raison sociale</div>
                                    <div class="st-row-desc">Nom légal de l'entreprise</div>
                                </div>
                                <input type="text" class="st-input" value="SATRACO Construction">
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">N° fiscal / RCCM</div>
                                    <div class="st-row-desc">Identifiant réglementaire</div>
                                </div>
                                <input type="text" class="st-input" value="SAT-2024-RCCM-0457">
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">E-mail de contact</div>
                                    <div class="st-row-desc">Utilisé pour les notifications sortantes</div>
                                </div>
                                <input type="email" class="st-input" value="contact@satracoconstruction.com">
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Devise par défaut</div>
                                    <div class="st-row-desc">Appliquée aux montants et factures</div>
                                </div>
                                <select class="st-select">
                                    <option selected>Franc burundais (BIF)</option>
                                    <option>Franc rwandais (RWF)</option>
                                    <option>Dollar américain (USD)</option>
                                    <option>Euro (EUR)</option>
                                </select>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Fuseau horaire</div>
                                    <div class="st-row-desc">Dates et heures du système</div>
                                </div>
                                <select class="st-select">
                                    <option selected>Africa/Bujumbura (UTC+2)</option>
                                    <option>Africa/Kigali (UTC+2)</option>
                                    <option>Europe/Paris (UTC+1)</option>
                                </select>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Langue par défaut</div>
                                    <div class="st-row-desc">Interface des utilisateurs</div>
                                </div>
                                <select class="st-select">
                                    <option selected>Français</option>
                                    <option>English</option>
                                    <option>Kirundi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============ SÉCURITÉ ============ -->
                <div class="col-lg-6">
                    <div class="st-card">
                        <div class="st-card-header">
                            <div class="st-card-header-icon"><i class="fas fa-shield-alt"></i></div>
                            <div>
                                <div class="st-card-title">Sécurité & authentification</div>
                                <div class="st-card-subtitle">Politique de mots de passe et sessions.</div>
                            </div>
                        </div>
                        <div class="st-card-body">
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Longueur minimale du mot de passe</div>
                                    <div class="st-row-desc">Caractères requis à la création</div>
                                </div>
                                <select class="st-select" style="min-width:120px;">
                                    <option>6</option>
                                    <option selected>8</option>
                                    <option>10</option>
                                    <option>12</option>
                                </select>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Complexité renforcée</div>
                                    <div class="st-row-desc">Majuscules, chiffres et caractères spéciaux</div>
                                </div>
                                <label class="st-switch"><input type="checkbox" checked><span
                                        class="st-slider"></span></label>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Double authentification (2FA)</div>
                                    <div class="st-row-desc">Code de vérification à la connexion</div>
                                </div>
                                <label class="st-switch"><input type="checkbox"><span class="st-slider"></span></label>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Expiration de session</div>
                                    <div class="st-row-desc">Déconnexion automatique après inactivité</div>
                                </div>
                                <select class="st-select" style="min-width:150px;">
                                    <option>15 minutes</option>
                                    <option selected>30 minutes</option>
                                    <option>1 heure</option>
                                    <option>4 heures</option>
                                </select>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Tentatives de connexion max</div>
                                    <div class="st-row-desc">Blocage temporaire au-delà</div>
                                </div>
                                <select class="st-select" style="min-width:120px;">
                                    <option>3</option>
                                    <option selected>5</option>
                                    <option>10</option>
                                </select>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Expiration des mots de passe</div>
                                    <div class="st-row-desc">Obligation de renouvellement périodique</div>
                                </div>
                                <select class="st-select" style="min-width:150px;">
                                    <option>Jamais</option>
                                    <option selected>90 jours</option>
                                    <option>180 jours</option>
                                    <option>365 jours</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============ NOTIFICATIONS ============ -->
                <div class="col-lg-6">
                    <div class="st-card">
                        <div class="st-card-header">
                            <div class="st-card-header-icon"><i class="fas fa-bell"></i></div>
                            <div>
                                <div class="st-card-title">Notifications & alertes</div>
                                <div class="st-card-subtitle">Ce que le système doit signaler automatiquement.</div>
                            </div>
                        </div>
                        <div class="st-card-body">
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Notifications par e-mail</div>
                                    <div class="st-row-desc">Envoi des alertes par courriel</div>
                                </div>
                                <label class="st-switch"><input type="checkbox" checked><span
                                        class="st-slider"></span></label>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Alertes de stock</div>
                                    <div class="st-row-desc">Seuil minimum atteint sur un article</div>
                                </div>
                                <label class="st-switch"><input type="checkbox" checked><span
                                        class="st-slider"></span></label>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Échéances de paiement</div>
                                    <div class="st-row-desc">Factures arrivant à échéance sous 7 jours</div>
                                </div>
                                <label class="st-switch"><input type="checkbox" checked><span
                                        class="st-slider"></span></label>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Résumé quotidien</div>
                                    <div class="st-row-desc">Synthèse journalière envoyée à la direction</div>
                                </div>
                                <label class="st-switch"><input type="checkbox"><span class="st-slider"></span></label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============ AFFICHAGE ============ -->
                <div class="col-lg-6">
                    <div class="st-card">
                        <div class="st-card-header">
                            <div class="st-card-header-icon"><i class="fas fa-palette"></i></div>
                            <div>
                                <div class="st-card-title">Apparence & préférences</div>
                                <div class="st-card-subtitle">Confort d'utilisation par défaut.</div>
                            </div>
                        </div>
                        <div class="st-card-body">
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Thème de l'interface</div>
                                    <div class="st-row-desc">Couleurs par défaut du tableau de bord</div>
                                </div>
                                <select class="st-select">
                                    <option selected>Vert institutionnel</option>
                                    <option>Sombre</option>
                                    <option>Clair</option>
                                </select>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Format de date</div>
                                    <div class="st-row-desc">Affichage dans les listes et rapports</div>
                                </div>
                                <select class="st-select">
                                    <option selected>JJ/MM/AAAA</option>
                                    <option>AAAA-MM-JJ</option>
                                    <option>MM/JJ/AAAA</option>
                                </select>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Lignes par page</div>
                                    <div class="st-row-desc">Pagination par défaut des tableaux</div>
                                </div>
                                <select class="st-select" style="min-width:120px;">
                                    <option>10</option>
                                    <option selected>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Sidebar compacte</div>
                                    <div class="st-row-desc">Réduire le menu latéral par défaut</div>
                                </div>
                                <label class="st-switch"><input type="checkbox"><span class="st-slider"></span></label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============ SAUVEGARDE ============ -->
                <div class="col-lg-6">
                    <div class="st-card">
                        <div class="st-card-header">
                            <div class="st-card-header-icon"><i class="fas fa-database"></i></div>
                            <div>
                                <div class="st-card-title">Sauvegarde & maintenance</div>
                                <div class="st-card-subtitle">Protection des données du système.</div>
                            </div>
                        </div>
                        <div class="st-card-body">
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Sauvegarde automatique</div>
                                    <div class="st-row-desc">Copie planifiée de la base de données</div>
                                </div>
                                <label class="st-switch"><input type="checkbox" checked><span
                                        class="st-slider"></span></label>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Fréquence</div>
                                    <div class="st-row-desc">Intervalle entre deux sauvegardes</div>
                                </div>
                                <select class="st-select">
                                    <option selected>Quotidienne (02h00)</option>
                                    <option>Hebdomadaire</option>
                                    <option>Mensuelle</option>
                                </select>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Rétention locale</div>
                                    <div class="st-row-desc">Durée de conservation des copies</div>
                                </div>
                                <select class="st-select" style="min-width:150px;">
                                    <option>7 jours</option>
                                    <option selected>30 jours</option>
                                    <option>90 jours</option>
                                </select>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Sauvegarde manuelle</div>
                                    <div class="st-row-desc">Lancer une copie immédiate</div>
                                </div>
                                <button type="button" class="st-btn-outline st-btn-action"><i
                                        class="fas fa-download mr-1"></i> Sauvegarder maintenant</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============ ZONE DANGEREUSE ============ -->
                <div class="col-lg-6">
                    <div class="st-card st-card-danger">
                        <div class="st-card-header">
                            <div class="st-card-header-icon"><i class="fas fa-exclamation-triangle"></i></div>
                            <div>
                                <div class="st-card-title">Zone dangereuse</div>
                                <div class="st-card-subtitle">Actions sensibles à utiliser avec précaution.</div>
                            </div>
                        </div>
                        <div class="st-card-body">
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Mode maintenance</div>
                                    <div class="st-row-desc">Bloque l'accès à tous les utilisateurs non admins</div>
                                </div>
                                <label class="st-switch st-switch-danger"><input type="checkbox"><span
                                        class="st-slider"></span></label>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Exporter toutes les données</div>
                                    <div class="st-row-desc">Archive complète (JSON / SQL)</div>
                                </div>
                                <button type="button" class="st-btn-outline st-btn-action"><i
                                        class="fas fa-file-export mr-1"></i> Exporter</button>
                            </div>
                            <div class="st-row">
                                <div>
                                    <div class="st-row-label">Réinitialiser les paramètres</div>
                                    <div class="st-row-desc">Restaure la configuration d'usine</div>
                                </div>
                                <button type="button" class="st-btn-danger st-btn-action"><i
                                        class="fas fa-undo mr-1"></i> Réinitialiser</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function stInit() {
    if (typeof jQuery === 'undefined') {
        console.error('[settings] jQuery introuvable.');
        return;
    }

    /* Compteur d'options activées */
    function syncCount() {
        $('#stActiveCount').text($('.st-switch input:checked').length);
    }
    syncCount();
    $(document).on('change', '.st-switch input', syncCount);

    /* ⏳ Boutons : seront câblés à la dynamisation */
    $('#stSaveBtn').on('click', function() {
        Swal.fire('Info', 'La sauvegarde des paramètres sera disponible à l\'étape de dynamisation.', 'info');
    });

    $('#stResetBtn').on('click', function() {
        location.reload();
    });

    $(document).on('click', '.st-btn-action', function() {
        Swal.fire('Info', 'Cette action sera disponible à l\'étape de dynamisation.', 'info');
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', stInit);
} else {
    stInit();
}
</script>