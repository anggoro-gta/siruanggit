<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<style>
    #accordionExample .accordion-item {
        border: 0;
        border-radius: .5rem;
        box-shadow: 0 .25rem .75rem rgba(67, 89, 113, .18);
        overflow: hidden;
        background-color: #71dd37;
    }

    #accordionExample .accordion-button {
        box-shadow: none;
        background-color: #71dd37;
        color: #fff;
    }

    #accordionExample .accordion-button::after {
        filter: brightness(0) invert(1);
    }

    #accordionExample .accordion-button:not(.collapsed) {
        box-shadow: none;
        background-color: #71dd37;
        color: #fff;
    }

    #accordionExample .accordion-body {
        background-color: #71dd37;
        color: #fff;
    }

    #accordionExample .accordion-item {
        border-radius: 1rem;
        background: linear-gradient(135deg, #71dd37 0%, #58c92c 100%);
        box-shadow: 0 .5rem 1.25rem rgba(71, 187, 45, .22);
    }

    #accordionExample .accordion-button,
    #accordionExample .accordion-button:not(.collapsed),
    #accordionExample .accordion-body {
        background: transparent;
    }

    #accordionExample .accordion-button {
        padding: 1.15rem 1.4rem;
        font-weight: 600;
    }

    #accordionExample .accordion-button:focus { box-shadow: none; }

    #accordionExample .accordion-body { padding: 0 1.4rem 1.35rem; }

    .approval-meta {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding: .85rem 0 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, .35);
        color: rgba(255, 255, 255, .92);
        font-size: .875rem;
    }

    .approval-meta span:last-child { text-align: right; white-space: nowrap; }
    .approval-note { padding-top: 1rem; }
    .approval-note-label {
        display: block;
        margin-bottom: .3rem;
        color: rgba(255, 255, 255, .75);
        font-size: .75rem;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
    }
    .approval-note-text { margin: 0; color: #fff; line-height: 1.5; }

    #accordionExample.is-rejected .accordion-item {
        background: linear-gradient(135deg, #ff5b5c 0%, #e53935 100%);
        box-shadow: 0 .5rem 1.25rem rgba(229, 57, 53, .22);
    }

    #accordionExample.is-cancelled .accordion-item {
        background: linear-gradient(135deg, #a3a3a3 0%, #7b7b7b 100%);
        box-shadow: 0 .5rem 1.25rem rgba(229, 229, 229, 0.22);
    }

    .sticky-verification-card {
        position: sticky;
        top: 1rem;
        z-index: 2;
    }

    .booking-timeline {
        position: relative;
        margin: 0;
        padding: .5rem 0 .25rem;
        list-style: none;
    }

    .booking-timeline::before {
        content: '';
        position: absolute;
        top: 1.25rem;
        bottom: 1.25rem;
        left: .45rem;
        width: 1px;
        background: #e2e5e9;
    }

    .booking-timeline-item {
        position: relative;
        display: flex;
        gap: 1rem;
        padding-bottom: 1.5rem;
    }

    .booking-timeline-item:last-child {
        padding-bottom: 0;
    }

    .booking-timeline-dot {
        position: relative;
        z-index: 1;
        flex: 0 0 1rem;
        width: 1rem;
        height: 1rem;
        margin-top: .2rem;
        border: 3px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 2px currentColor;
    }

    .booking-timeline-dot-primary { color: #696cff; background: #696cff; }
    .booking-timeline-dot-success { color: #71dd37; background: #71dd37; }
    .booking-timeline-dot-danger { color: #ff3e1d; background: #ff3e1d; }
    .booking-timeline-dot-secondary { color: #8592a3; background: #8592a3; }

    .booking-timeline-content {
        min-width: 0;
        flex: 1;
    }

    .booking-timeline-heading {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        color: #435971;
        font-weight: 600;
    }

    .booking-timeline-date {
        flex-shrink: 0;
        color: #a1acb8;
        font-size: .85rem;
        font-weight: 400;
    }

    .booking-timeline-description {
        margin-top: .45rem;
        color: #697a8d;
    }

    @media (max-width: 767.98px) {
        .sticky-verification-card {
            position: static;
        }

        .detail-card-header {
            display: flex;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .detail-card-header .card-title {
            flex: 1 1 auto;
            min-width: 0;
            margin-top: .35rem !important;
            font-size: 1.15rem;
            line-height: 1.25;
        }

        .detail-card-actions {
            display: flex;
            flex: 0 0 10.5rem;
            flex-direction: column;
            gap: .5rem;
        }

        .detail-card-actions .btn {
            width: 100%;
            margin: 0 !important;
        }

        .detail-card-actions .btn-warning {
            white-space: normal;
            line-height: 1.25;
        }
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between detail-card-header">
                    <h5 class="card-title mb-0"><?= esc($title) ?></h5>
                    <div class="detail-card-actions">
                        <a href="<?= base_url('verifikasi-pembayaran') ?>" class="btn btn-secondary">
                            <i class="bx bx-arrow-back me-1"></i> Kembali
                        </a>
                    </div>
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
                                <td>
                                    <?php
                                        $harga_pinjam = $row['hargasewa'] ? 'Rp ' . number_format($row['hargasewa'], 0, ',', '.') : '-';
                                        echo $harga_pinjam;
                                    ?>
                                </td>
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
                    <h5 class="card-title mb-0">Verifikasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= base_url('verifikasi-pembayaran/update') ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <?php
                            $is_verifikasi = $row['isverifikasi'] ?? null;
                            $is_verifikasi_bayar = $row['isverifikasibayar'] ?? null;
                        ?>
                        <input type="hidden" name="id" value="<?= esc($row['id']) ?>">
                        <div class="mb-3">
                            <label for="tglverifikasibayar" class="form-label">Tanggal Verifikasi</label>
                            <input type="text" class="form-control" id="tglverifikasibayar" name="tglverifikasibayar" value="<?= date('Y-m-d H:i:s') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="verifikator" class="form-label">Verifikator</label>
                            <input type="text" class="form-control" id="verifikator" name="verifikator" value="<?= esc(user()->fullname ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="hargasewa" class="form-label">Harga Sewa</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control nominal" id="hargasewa" name="hargasewa"
                                    inputmode="numeric" autocomplete="off" <?= in_array($is_verifikasi, ['1', '0']) ? 'readonly' : '' ?>
                                    value="<?= (int) ($row['hargasewa'] ?? 0) > 0 ? number_format((int) $row['hargasewa'], 0, ',', '.') : '0' ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="isverifikasibayar" class="form-label">Status Verifikasi <sup class="text-danger">*</sup></label>
                            <select class="form-select" id="isverifikasibayar" name="isverifikasibayar" required>
                                <option value="">Pilih Status</option>
                                <option value="1">Disetujui</option>
                                <option value="0">Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keteranganverifikasibayar" class="form-label">Keterangan Verifikasi</label>
                            <textarea class="form-control" id="keteranganverifikasibayar" name="keteranganverifikasibayar" rows="3"><?= esc($row['keteranganverifikasibayar']) ?></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="<?= base_url('upload/bukti-bayar/' . $row['buktibayar']) ?>" target="_blank"
                            class="btn btn-outline-info">
                                <i class="bx bx-file me-1"></i>Bukti Bayar
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
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
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.active-menu-verifikasi-pembayaran')?.classList.add('active');

    const hargaSewa = document.getElementById('hargasewa');
    const formatRupiah = (value) => {
        const digits = value.replace(/\D/g, '');
        if (digits === '') return '';
        return Number(digits).toLocaleString('id-ID');
    };

    hargaSewa?.addEventListener('input', function () {
        this.value = formatRupiah(this.value);
    });

    hargaSewa?.form.addEventListener('submit', function () {
        hargaSewa.value = hargaSewa.value.replace(/\D/g, '');
    });
});
</script>
<?= $this->endSection(); ?>
