<?= $this->extend('auth/template/index'); ?>

<?= $this->section('logincontent'); ?>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="#" class="app-brand-link gap-2">
                            <img src="<?= base_url(); ?>/assets/img/icons/logo.png" class="circle-img" alt="logo">
                            <!-- <span class="app-brand-text demo text-body fw-bolder">SiRuang</span> -->
                            
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">SiRuang</h4>
                    <p class="mb-4">Silahkan masuk ke sistem menggunakan akun anda</p>

                    <p class="login-box-msg"><?= lang('Auth.loginTitle') ?></p>

                    <?= view('Myth\Auth\Views\_message_block') ?>
                    <form class="mb-3" action="<?= route_to('login') ?>" method="POST">
                        <?= csrf_field() ?>

                        <?php if ($config->validFields === ['email']) : ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="text"
                                    class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.email') ?>"
                                    id="email"
                                    name="email-username"
                                    placeholder="Enter your email or username"
                                    autofocus />

                                <div class="invalid-feedback">
                                    <?= session('errors.login') ?>
                                </div>

                            </div>
                        <?php else : ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input
                                    type="text"
                                    class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>"
                                    id="email"
                                    name="email-username"
                                    placeholder="Enter your email or username"
                                    autofocus />

                                <div class="invalid-feedback">
                                    <?= session('errors.login') ?>
                                </div>

                            </div>
                        <?php endif; ?>

                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="password"
                                    class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>"
                                    name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>

                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                        </div>
                        <?php if ($config->allowRemembering) : ?>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" <?php if (old('remember')) : ?> checked <?php endif ?> />
                                    <?= lang('Auth.rememberMe') ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit"><?= lang('Auth.loginAction') ?></button>
                        </div>
                    </form>

                    <?php if ($config->allowRegistration) : ?>
                        <p class="mb-0">
                            <a href="<?= route_to('register') ?>" class="text-center"><?= lang('Auth.needAnAccount') ?></a>
                        </p>
                    <?php endif; ?>
                    <?php if ($config->activeResetter) : ?>
                        <p class="mb-0">
                            <a href="<?= route_to('forgot') ?>" class="text-center"><?= lang('Auth.forgotYourPassword') ?></a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>
<!-- / Content -->
<?= $this->endSection(); ?>