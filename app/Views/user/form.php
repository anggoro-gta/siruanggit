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
<?php $errors = session('errors') ?? []; ?>
<!-- Content Wrapper. Contains page content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title"><?= $title ?></h5>
            </div>
            <a href="<?= base_url('master-user'); ?>" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <?php if (!empty($errors['general'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= esc($errors['general']) ?>
                </div>
            <?php endif; ?>
            <form autocomplete="off" method="POST" action="<?= $url ?>" enctype="multipart/form-data">
                <input type="hidden" class="form-control" name="id" id="id" value="<?= $id ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-4">
                            <label for="kategori" class="form-label">Status <sup class="text-danger">*</sup></label>
                            <select class="form-select <?= isset($errors['kategori']) ? 'is-invalid' : '' ?>" id="kategori" name="kategori" required>
                            <option value="admin" <?= old('kategori', $kategori ?? 'admin') === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="opd" <?= old('kategori', $kategori ?? '') === 'opd' ? 'selected' : '' ?>>OPD</option>
                            </select>
                            <?php if (isset($errors['kategori'])) : ?><div class="invalid-feedback"><?= esc($errors['kategori']) ?></div><?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <label for="username" class="form-label">Username <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-user"></i></span>
                            <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" id="username" name="username" required value="<?= esc(old('username', $username ?? '')) ?>">
                        </div>
                        <?php if (isset($errors['username'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['username']) ?></div><?php endif; ?>
                    </div>
                    <?php
                        if(!empty($id)){
                    ?>
                    <div class="mb-4 col-md-6 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Password <sup class="text-primary">( Kosongi jika tidak di ubah )</sup></label>
                        </div>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-key"></i></span>
                            <input type="password" id="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" autocomplete="new-password"/>
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>

                        <div class="invalid-feedback">
                            <?= esc($errors['password'] ?? '') ?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="mb-4 col-md-6">
                        <label for="fullname" class="form-label label-fullname">Nama Lengkap <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-id-card"></i></span>
                            <input type="text" class="form-control <?= isset($errors['fullname']) ? 'is-invalid' : '' ?>" id="fullname" name="fullname" required value="<?= esc(old('fullname', $fullname ?? '')) ?>">
                        </div>  
                        <?php if (isset($errors['fullname'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['fullname']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="fullname" class="form-label">Alamat</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-buildings"></i></span>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="nohp" class="form-label">No. HP</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-phone"></i></span>
                            <input type="text" class="form-control" id="nohp" name="nohp" value="<?= $nohp ?>">
                        </div>
                    </div>
                    <div class="mb-4 col-md-6 div-email d-none">
                        <label for="email" class="form-label">Email Organisasi</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                        </div>
                    </div>
                    <div id="form-opd" class="col-md-12 d-none">
                        <div class="row">
                            <div class="mb-4 col-md-6 div-nama_pimpinan">
                                <label for="nama_pimpinan" class="form-label">Nama Pimpinan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-id-card"></i></span>
                                    <input type="text" class="form-control" id="nama_pimpinan" name="nama_pimpinan" value="<?= $nama_pimpinan ?>">
                                </div>
                            </div>
                            <div class="mb-4 col-md-6 div-nip">
                                <label for="nip" class="form-label">NIP Pimpinan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-barcode"></i></span>
                                    <input type="text" class="form-control" id="nip" name="nip" value="<?= $nip ?>">
                                </div>
                            </div>
                            <div class="mb-4 col-md-6 div-namapj">
                                <label for="namapj" class="form-label">Nama Penanggung Jawab</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-id-card"></i></span>
                                    <input type="text" class="form-control" id="namapj" name="namapj" value="<?= $namapj ?>">
                                </div>
                            </div>
                            <div class="mb-4 col-md-6 div-nippj">
                                <label for="nippj" class="form-label">NIP Penanggung Jawab</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-barcode"></i></span>
                                    <input type="text" class="form-control" id="nippj" name="nippj" value="<?= $nippj ?>">
                                </div>
                            </div>
                            <div class="mb-4 col-md-6 div-wapj">
                                <label for="wapj" class="form-label">No. HP Penanggung Jawab</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-phone"></i></span>
                                    <input type="text" class="form-control" id="wapj" name="wapj" value="<?= $wapj ?>">
                                </div>
                            </div>
                            <div class="mb-4 col-md-6 div-jabatanpj">
                                <label for="jabatanpj" class="form-label">Jabatan Penanggung Jawab</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-briefcase"></i></span>
                                    <input type="text" class="form-control" id="jabatanpj" name="jabatanpj" value="<?= $jabatanpj ?>">
                                </div>
                            </div>
                            <div class="mb-4 col-md-6 div-suratpenugasanpj">
                                <label for="suratpenugasanpj" class="form-label">Surat Penugasan <sup class="text-primary">( Hanya boleh file ekstensi .jpg/.jpeg/.png/.webp/.pdf )</sup></label>
                                <input class="form-control" type="file" id="suratpenugasanpj" name="suratpenugasanpj" accept=".jpg,.jpeg,.png,.webp,.pdf">
                                <?php
                                    $surat_penugasan = '';
                                    if(!empty($suratpenugasanpj)) {
                                        $surat_penugasan = '<span class="badge bg-label-secondary mt-2"><a href="' . base_url('upload/sp/' . $suratpenugasanpj) . '"
                                            title="Download"
                                            aria-label="Download"
                                            download="' . esc($suratpenugasanpj) . '">
                                            <i class="bx bx-download"></i> '.$suratpenugasanpj.'
                                        </a></span>';
                                    }
                                    echo $surat_penugasan;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-secondary" type="reset">Batal</button>
                    <button class="btn btn-primary" type="submit"><?= $button ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script>
    const activemenu = document.querySelector('.active-menu-user');

    activemenu.classList.add('active');

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const kategori = document.getElementById('kategori');
    const formOpd = document.getElementById('form-opd');
    const divEmail = document.querySelector('.div-email');

    function toggleForm() {
        const isOpd = kategori.value === 'opd';

        divEmail.classList.toggle('d-none', !isOpd);

        const email = document.getElementById('email');
        email.disabled = !isOpd;

        formOpd.classList.toggle('d-none', !isOpd);

        formOpd.querySelectorAll('input, select, textarea').forEach(field => {
            field.disabled = !isOpd;
        });
    }

    kategori.addEventListener('change', toggleForm);
    toggleForm();
});
</script>


<?= $this->endSection(); ?>
