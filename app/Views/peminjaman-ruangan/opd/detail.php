<?= $this->extend('layouts/template_opd'); ?>

<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <?php if ($row['isverifikasi'] === '1') : ?>
        <div class="alert alert-success py-3 px-4" role="alert">
            <h5 class="alert-heading mb-1"><i class="bx bx-check-circle me-1"></i>Disetujui</h5>
            <div>Note : <?= $row['keteranganverifikasi'] ?? '-' ?></div>
        </div>
    <?php elseif ($row['isverifikasi'] === '0') : ?>
        <div class="alert alert-danger py-3 px-4" role="alert">
            <h5 class="alert-heading mb-1"><i class="bx bx-x-circle me-1"></i>Ditolak</h5>
            <div>Note : <?= $row['keteranganverifikasi'] ?? '-' ?></div>
        </div>
    <?php else : ?>
        <div class="alert alert-primary py-3 px-4" role="alert">
            <h5 class="alert-heading mb-1"><i class="bx bx-hourglass me-1"></i>Belum Verifikasi</h5>
            <div>Note : Peminjaman ruang sedang menunggu verifikasi.</div>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0"><?= esc($title) ?></h5>
            <a href="<?= base_url('peminjaman-ruang-opd') ?>" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
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
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tbody>
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
