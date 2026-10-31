<?= $this->extend('layouts/template'); ?>

<?= $this->section('csskhusus'); ?>
<style>
    .form-label {
        text-transform: none !important;
        font-size: 10pt;
        color: #384551;
    }
    .form-control,
    .input-group-text {
        min-height: 38px;
    }

    .form-label {
        display: block;
        line-height: 1.5;
        margin-bottom: .5rem;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<?php
$errors  = session()->getFlashdata('errors') ?? [];
$success = session()->getFlashdata('success');
?>
<!-- Content Wrapper. Contains page content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title"><?= $title ?></h5>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bx bx-check-circle me-1"></i>
                            <?= esc(session()->getFlashdata('success')) ?>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors['general'])) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bx bx-error-circle me-1"></i>
                            <?= esc($errors['general']) ?>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                            </button>
                        </div>
                    <?php endif; ?>
                    <form autocomplete="off" method="POST" action="<?= esc($url) ?>">

                        <?= csrf_field() ?>

                        <input
                            type="hidden"
                            name="id"
                            id="id"
                            value="<?= esc($id) ?>"
                        >

                        <div class="row">

                            <div class="mb-4 form-password-toggle">
                                <label class="form-label" for="password_baru">
                                    Password Baru
                                    <sup class="text-danger">*</sup>
                                </label>

                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="color: #9e9e9e">
                                        <i class="bx bx-key"></i>
                                    </span>

                                    <input
                                        type="password"
                                        id="password_baru"
                                        name="password_baru"
                                        class="form-control <?= isset($errors['password_baru']) ? 'is-invalid' : '' ?>"
                                        placeholder="············"
                                        autocomplete="new-password"
                                    >

                                    <span class="input-group-text cursor-pointer">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>

                                <?php if (isset($errors['password_baru'])) : ?>
                                    <div class="text-danger small mt-1">
                                        <?= esc($errors['password_baru']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>


                            <div class="mb-4 form-password-toggle">
                                <label class="form-label" for="ulangi_password">
                                    Ulangi Password Baru
                                    <sup class="text-danger">*</sup>
                                </label>

                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="color: #9e9e9e">
                                        <i class="bx bx-key"></i>
                                    </span>

                                    <input
                                        type="password"
                                        id="ulangi_password"
                                        name="ulangi_password"
                                        class="form-control <?= isset($errors['ulangi_password']) ? 'is-invalid' : '' ?>"
                                        placeholder="············"
                                        autocomplete="new-password"
                                    >

                                    <span class="input-group-text cursor-pointer">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>

                                <?php if (isset($errors['ulangi_password'])) : ?>
                                    <div class="text-danger small mt-1">
                                        <?= esc($errors['ulangi_password']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">
                                <?= esc($button) ?>
                            </button>

                            <a
                                href="<?= site_url('users') ?>"
                                class="btn btn-secondary"
                            >
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script>
    document.querySelectorAll('.form-password-toggle .cursor-pointer')
        .forEach(function (toggle) {

            toggle.addEventListener('click', function () {

                const wrapper = this.closest('.form-password-toggle');
                const input = wrapper.querySelector('input');
                const icon = this.querySelector('i');

                setTimeout(function () {
                    if (input.type === 'text') {
                        icon.classList.remove('bx-hide');
                        icon.classList.add('bx-show');
                    } else {
                        icon.classList.remove('bx-show');
                        icon.classList.add('bx-hide');
                    }
                }, 0);

            });

        });
</script>

<?= $this->endSection(); ?>
