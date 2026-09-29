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
            <a href="<?= base_url('master-slider'); ?>" class="btn btn-secondary">
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
                    <div class="mb-4 col-md-6">
                        <label for="nourut" class="form-label">No. Urut <sup class="text-danger">*</sup></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" style="color: #9e9e9e"><i class="bx bx-hash"></i></span>
                            <input type="number" class="form-control <?= isset($errors['nourut']) ? 'is-invalid' : '' ?>" id="nourut" name="nourut" required value="<?= esc(old('nourut', $nourut ?? '')) ?>">
                        </div>
                        <?php if (isset($errors['nourut'])) : ?><div class="invalid-feedback d-block"><?= esc($errors['nourut']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="is_show" class="form-label">Ditampilkan <sup class="text-danger">*</sup></label>
                        <select class="form-select <?= isset($errors['is_show']) ? 'is-invalid' : '' ?>" id="is_show" name="is_show" required>
                        <option value="1" <?= old('is_show', $is_show ?? '1') === '1' ? 'selected' : '' ?>>Ya</option>
                        <option value="0" <?= old('is_show', $is_show ?? '0') === '0' ? 'selected' : '' ?>>Tidak</option>
                        </select>
                        <?php if (isset($errors['is_show'])) : ?><div class="invalid-feedback"><?= esc($errors['is_show']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="file_slider" class="form-label">Gambar <?= !empty($file_slider) ? '' : '<sup class="text-danger">*</sup> ' ?><sup class="text-primary">( Hanya boleh file ekstensi .jpg/.jpeg/.png/.webp )</sup></label>
                        <input class="form-control" type="file" id="file_slider" name="file_slider" accept=".jpg,.jpeg,.png,.webp" <?= !empty($file_slider) ? '' : 'required' ?>>
                        <?php if (isset($errors['file_slider'])) : ?><div class="invalid-feedback"><?= esc($errors['file_slider']) ?></div><?php endif; ?>
                        <?php
                            $fs = '';
                            if(!empty($file_slider)) {
                                $fs = '<a href="' . base_url('upload/slider/' . $file_slider) . '" title="Lihat" target="_blank">
                                    <img src="'. base_url('upload/slider/' . $file_slider) .'" width="50%" class="mt-2 gambar">
                                </a>';
                            }
                            echo $fs;
                        ?>
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
    const activemenu = document.querySelector('.active-menu-slider');

    activemenu.classList.add('active');

</script>


<?= $this->endSection(); ?>
