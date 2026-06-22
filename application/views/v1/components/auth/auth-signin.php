<body class="hold-transition login-page">

    <div class="login-box">

        <div class="satraco-logo">
            <img src="<?= base_url('assets/v1/dist/img/logoUpdate.png') ?>" alt="SATRACO Logo">
            <h3>SATRACO</h3>
            <span>Construction Management System</span>
        </div>

        <div class="card shadow-lg border-0">
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
                        <input type="email" name="email" class="form-control" placeholder="Adresse email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
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

                <p class="text-center text-muted mb-0" style="font-size: 13px;">
                    © <?= date('Y') ?> SATRACO Construction
                </p>

            </div>
        </div>

    </div>