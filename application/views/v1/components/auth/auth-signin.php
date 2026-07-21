<body class="hold-transition login-page">

    <style>
    .install-pwa-button {
        position: fixed;

        top: 25px;
        right: 30px;

        z-index: 9999;

        padding: 11px 18px;

        border: none;
        border-radius: 8px;

        background: #159447;
        color: #ffffff;

        font-size: 14px;
        font-weight: 700;

        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.22);

        transition:
            transform 0.2s ease,
            background-color 0.2s ease,
            box-shadow 0.2s ease;
    }

    .install-pwa-button:hover,
    .install-pwa-button:focus {
        background: #117d3c;
        color: #ffffff;

        transform: translateY(-2px);

        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.28);
    }

    .install-pwa-button i {
        margin-right: 6px;
    }

    @media (max-width: 575.98px) {

        .install-pwa-button {
            top: 15px;
            right: 15px;

            padding: 9px 13px;

            font-size: 12px;
        }

    }
    </style>

    <button type="button" id="installPwaButton" class="btn btn-success install-pwa-button" style="display: none;">

        <i class="fas fa-download mr-1"></i>
        Installer l'application

    </button>

    <div class="login-box">

        <div class="login-header">

            <div class="satraco-logo">
                <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO Logo">

                <h3>SATRACO</h3>

                <span>
                    Construction Management System
                </span>
            </div>

        </div>

        <div class="card login-card-wrapper shadow-lg border-0">

            <button type="button" id="installPwaButton" class="btn btn-success install-pwa-button"
                style="display: none;">

                <i class="fas fa-download mr-1"></i>

                <span>Installer l'application</span>

            </button>

            <div class="card-body login-card-body">

                <p class="login-box-msg">
                    Connectez-vous à votre espace de gestion
                </p>

                <?php if ($this->session->flashdata('error')) : ?>

                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error'); ?>
                </div>

                <?php endif; ?>

                <form action="<?= base_url('auth-login') ?>" method="post">

                    <div class="input-group mb-3">

                        <input type="email" name="email" class="form-control" placeholder="Adresse email"
                            autocomplete="email" required>

                        <div class="input-group-append">

                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>

                        </div>

                    </div>

                    <div class="input-group mb-3">

                        <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                            autocomplete="current-password" required>

                        <div class="input-group-append">

                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>

                        </div>

                    </div>

                    <div class="row align-items-center">

                        <div class="col-7">

                            <div class="icheck-primary">

                                <input type="checkbox" id="remember" name="remember">

                                <label for="remember">
                                    Se souvenir
                                </label>

                            </div>

                        </div>

                        <div class="col-5">

                            <button type="submit" class="btn btn-satraco btn-block">

                                Connexion

                            </button>

                        </div>

                    </div>

                </form>

                <hr>

                <p class="text-center text-muted mb-0 login-copyright">
                    © <?= date('Y') ?> SATRACO Construction
                </p>

            </div>

        </div>

    </div>