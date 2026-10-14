<?= $this->extend('layouts/template_opd'); ?>

<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0"><?= esc($title) ?></h5>
            <a href="<?= base_url('peminjaman-ruang-opd') ?>" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <?php
                $fields = [
                    'nopinjam' => 'No. Peminjaman', 'tglpinjam' => 'Tanggal Pengajuan',
                    'namaorganisasi' => 'Nama Organisasi', 'namapeminjam' => 'Nama Peminjam',
                    'nohp' => 'No. HP', 'acara' => 'Acara',
                    'tgljamacaramulai' => 'Mulai Acara', 'tgljamacaraselesai' => 'Selesai Acara',
                    'nama_ruang' => 'Nama Ruangan', 'kode_ruang' => 'Kode Ruangan',
                    'kode_dinas' => 'Kode Dinas', 'keteranganverifikasi' => 'Keterangan Verifikasi'
                ];
                foreach ($fields as $key => $label) : ?>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><?= esc($label) ?></label>
                        <div class="form-control bg-light">
                            <?= esc($row[$key] ?? '-') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status</label>
                    <div class="form-control bg-light">
                        <?php if ($row['isverifikasi'] === '1' || $row['isverifikasi'] === 1) : ?>Disetujui
                        <?php elseif ($row['isverifikasi'] === '0' || $row['isverifikasi'] === 0) : ?>Ditolak
                        <?php else : ?>Menunggu Verifikasi<?php endif; ?>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">File Surat Izin</label>
                    <div>
                        <?php if (!empty($row['filesuratpinjam'])) : ?>
                            <a href="<?= base_url('upload/surat/' . rawurlencode($row['filesuratpinjam'])) ?>" target="_blank" rel="noopener">
                                <i class="bx bx-file me-1"></i><?= esc($row['filesuratpinjam']) ?>
                            </a>
                        <?php else : ?>Tidak ada file<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.active-menu-peminjaman-ruang-opd')?.classList.add('active');
});
</script>
<?= $this->endSection(); ?>
