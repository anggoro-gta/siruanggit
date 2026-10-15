<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<style>
    #accordionExample .accordion-item {
        border: 0;
        border-radius: .5rem;
        box-shadow: 0 .25rem .75rem rgba(67, 89, 113, .18);
        overflow: hidden;
    }

    #accordionExample .accordion-button {
        box-shadow: none;
    }

    #accordionExample .accordion-button:not(.collapsed) {
        box-shadow: none;
    }

    .sticky-verification-card {
        position: sticky;
        top: 1rem;
        z-index: 2;
    }

    @media (max-width: 767.98px) {
        .sticky-verification-card {
            position: static;
        }
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0"><?= esc($title) ?></h5>
                    <a href="<?= base_url('verifikasi-peminjaman-ruang') ?>" class="btn btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th width="200">Tanggal Pinjam</th>
                                <td width="10">:</td>
                                <td><?= tanggal_indo($row['tglpinjam']) ?></td>
                            </tr>
                            <tr>
                                <th>Nama Peminjam</th>
                                <td>:</td>
                                <td><?= $row['namapeminjam'] ?></td>
                            </tr>
                            <tr>
                                <th>Nama Organisasi</th>
                                <td>:</td>
                                <td><?= $row['namaorganisasi'] ?></td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>:</td>
                                <td><?= $row['nohp'] ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Acara</th>
                                <td>:</td>
                                <td><?= esc(tanggal_indo($row['tgljamacaramulai'])) .' '. date('H:i:s', strtotime($row['tgljamacaramulai'])) ?> s.d. <?= esc(tanggal_indo($row['tgljamacaraselesai'])) .' '. date('H:i:s', strtotime($row['tgljamacaraselesai'])) ?></td>
                            </tr>
                            <tr>
                                <th>Perihal</th>
                                <td>:</td>
                                <td> <?= esc($row['acara'] ?? '-') ?>
                                </td>
                            </tr>
                            <tr>
                                <th>File Surat Pinjam</th>
                                <td>:</td>
                                <td>
                                    <?php if (!empty($row['filesuratpinjam'])) : ?>
                                    <a href="<?= base_url('upload/surat/' . rawurlencode($row['filesuratpinjam'])) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-show me-1"></i><?= esc($row['filesuratpinjam']) ?>
                                    </a>
                                    <?php else : ?>Tidak ada file<?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Harga Sewa</th>
                                <td>:</td>
                                <td><?= $row['hargasewa'] ? 'Rp ' . number_format($row['hargasewa'], 0, ',', '.') : '-' ?></td>
                            </tr>
                            <tr>
                                <th>Nama Ruangan</th>
                                <td>:</td>
                                <td>
                                    <?= $row['nama_ruang'] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>:</td>
                                <td><?= $row['alamat_ruang'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Luas Ruang</th>
                                <td>:</td>
                                <td><?= $row['luas_ruang'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Jumlah Kursi</th>
                                <td>:</td>
                                <td><?= $row['jml_kursi'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Jumlah Meja</th>
                                <td>:</td>
                                <td><?= $row['jml_meja'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Fasilitas</th>
                                <td>:</td>
                                <td><?= $row['fasilitas'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Peruntukan</th>
                                <td>:</td>
                                <td><?= strtoupper($row['peruntukan'] ?? '-') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm sticky-verification-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Verifikasi</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= base_url('verifikasi-peminjaman-ruang/update') ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= esc($row['id']) ?>">
                        <div class="mb-3">
                            <label for="tglverifikasi" class="form-label">Tanggal Verifikasi</label>
                            <input type="text" class="form-control" id="tglverifikasi" name="tglverifikasi" value="<?= esc($row['tglverifikasi'] ?? date('Y-m-d H:i:s')) ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="verifikator" class="form-label">Verifikator</label>
                            <input type="text" class="form-control" id="verifikator" name="verifikator" value="<?= esc(user()->fullname ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="isverifikasi" class="form-label">Status Verifikasi <sup class="text-danger">*</sup></label>
                            <select class="form-select" id="isverifikasi" name="isverifikasi" required>
                                <option value="">Pilih Status</option>
                                <option value="1" <?= $row['isverifikasi'] === '1' ? 'selected' : '' ?>>Disetujui</option>
                                <option value="0" <?= $row['isverifikasi'] === '0' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hargasewa" class="form-label">Harga Sewa</label>
                            <input type="number" class="form-control" id="hargasewa" name="hargasewa" value="<?= (int) $row['hargasewa'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="keteranganverifikasi" class="form-label">Keterangan Verifikasi</label>
                            <textarea class="form-control" id="keteranganverifikasi" name="keteranganverifikasi" rows="3"><?= esc($row['keteranganverifikasi']) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.active-menu-verifikasi-peminjaman-ruang')?.classList.add('active');
});
</script>
<?= $this->endSection(); ?>
