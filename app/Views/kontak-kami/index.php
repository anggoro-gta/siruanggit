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

    .gambar {
        border: 1px solid #dddddd;
        border-radius: 8px; /* opsional */
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
        </div>
        <div class="card-body">
            <?php if (!empty($errors['general'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= esc($errors['general']) ?>
                </div>
            <?php endif; ?>
            <form autocomplete="off" method="POST" action="<?= $url ?>" enctype="multipart/form-data">
                <input type="hidden" class="form-control" name="id" id="id" value="<?= !empty($row) ? $row['id'] : '' ?>">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <label for="email" class="form-label">Email <sup class="text-danger">*</sup></label>
                        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" required value="<?= esc(old('email', (!empty($row) ? $row['email'] : '') ?? '')) ?>"></input>
                        <?php if (isset($errors['email'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['email']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="telp" class="form-label">Telepon <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control <?= isset($errors['telp']) ? 'is-invalid' : '' ?>" id="telp" name="telp" required value="<?= esc(old('telp', (!empty($row) ? $row['telp'] : '') ?? '')) ?>"></input>
                        <?php if (isset($errors['telp'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['telp']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-12">
                        <label for="alamat" class="form-label">Alamat <sup class="text-danger">*</sup></label>
                        <textarea class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>" id="alamat" name="alamat" required><?= esc(old('alamat', (!empty($row) ? $row['alamat'] : '') ?? '')) ?></textarea>
                        <?php if (isset($errors['alamat'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['alamat']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="latitude" class="form-label">Latitude <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control <?= isset($errors['latitude']) ? 'is-invalid' : '' ?>" id="latitude" name="latitude" required value="<?= esc(old('latitude', (!empty($row) ? $row['latitude'] : '') ?? '')) ?>"></input>
                        <?php if (isset($errors['latitude'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['latitude']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="longitude" class="form-label">Longitude <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control <?= isset($errors['longitude']) ? 'is-invalid' : '' ?>" id="longitude" name="longitude" required value="<?= esc(old('longitude', (!empty($row) ? $row['longitude'] : '') ?? '')) ?>"></input>
                        <?php if (isset($errors['longitude'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['longitude']) ?></div><?php endif; ?>
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
    const activemenu = document.querySelector('.active-menu-kontak-kami');

    activemenu.classList.add('active');

</script>


<?= $this->endSection(); ?>
