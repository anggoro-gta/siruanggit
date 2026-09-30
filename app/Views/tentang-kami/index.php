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
                    <div class="mb-4 col-md-12">
                        <label for="judul" class="form-label">Judul <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control <?= isset($errors['judul']) ? 'is-invalid' : '' ?>" id="judul" name="judul" required value="<?= esc(old('judul', (!empty($row) ? $row['judul'] : '') ?? '')) ?>"></input>
                        <?php if (isset($errors['judul'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['judul']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-12">
                        <label for="isi" class="form-label">Isi <sup class="text-danger">*</sup></label>
                        <textarea class="form-control <?= isset($errors['isi']) ? 'is-invalid' : '' ?>" id="isi" name="isi" required rows="5"><?= esc(old('isi', (!empty($row) ? $row['isi'] : '') ?? '')) ?></textarea>
                        <?php if (isset($errors['isi'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['isi']) ?></div><?php endif; ?>
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
    const activemenu = document.querySelector('.active-menu-tentang-kami');

    activemenu.classList.add('active');

</script>


<?= $this->endSection(); ?>
